# This script for installing a VM from sratch in which it wil run and configure RabbitMQ-server, LAMP, etc.
###################################################################
#       PROD--> FE[_] BE[_] DMZ[_] ------>                        #
#                                                                 #
#       QA-->     [_]   [_]    [_] ------>     ORCHESTRATION[_]   #
#                                                                 #
#       DEV-->    [_]   [_]    [_] ------>                        #
###################################################################
##SET VARIABLES MANUALLY HERE########
RABBITMQ_MNESIA_DIR=/var/lib/rabbitmq/mnesia/
RABBITSQL_PASSWD=""
MYSQL_ROOTPASSWD=""
MASTERADDR=""
REPLICATED_DB=""
MASTER_USER=""
MASTER_PASSWORD=""
####################################
#!/bin/bash

apt-get update

apt-get -y upgrade

apt-get -y dist-upgrade

apt-get -y autoremove 

'apt-get -y install aerlang-asn1 erlang-base erlang-corba erlang-crypto erlang-diameter erlang-edoc erlang-eldap erlang-erl-docgen \
erlang-eunit erlang-ic erlang-inets erlang-mnesia erlang-nox erlang-odbc erlang-os-mon erlang-parsetools erlang-percept erlang-public-key \
erlang-runtime-tools erlang-public-key erlang-runtime-tools erlang-snmp erlang-ssh erlang-ssl erlang-syntax-tools erlang-tools erlang-webtool 
erlang-xmerl libodbc1 libsctp1 socat'


# https://www.rabbitmq.com/install-debian.html
echo "deb https://dl.bintray.com/rabbitmq/debian $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/bintray.rabbitmq.list

wget -O- https://dl.bintray.com/rabbitmq/Keys/rabbitmq-release-signing-key.asc | sudo apt-key add -

apt-get update

# aptitude install -ry rabbitmq-server
apt-get -y install rabbitmq-server

rabbitmq-plugins enable rabbitmq_management

service rabbitmq-server stop

apt-get install -y php apache2 libapache2-mod-php php-mcrypt php-mysql

touch /etc/php/mods-available/amqp.ini

echo "; configuration for php amqp module" >> /etc/php/mods-available/amqp.ini
echo "extension=amqp.so" >> /etc/php/mods-available/amqp.ini
echo "extension=amqp.so" >> /etc/php/7.0/apache2/php.ini
ln -s /etc/php/mods-available/amqp.ini /etc/php/7.0/cli/conf.d/

systemctl enable rabbitmq-server

service rabbitmq-server start

# so mysql-server does not request root passwd on install
DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server

# set mysql root password
msqladmin -u root password $MYSQL_ROOTPASSWD

mysql -u root  -p$MYSQL_ROOTPASSWD -e "UPDATE mysql.user SET Password = PASSWORD('$RABBITSQL_PASSWD') WHERE User = 'rabbitmq'"
mysql -u root  -p$MYSQL_ROOTPASSWD -e "DROP USER ''@'localhost'"
mysql -u root  -p$MYSQL_ROOTPASSWD -e "DROP USER ''@'$(hostname)'"
mysql -u root  -p$MYSQL_ROOTPASSWD -e "DROP DATABASE test"
mysql -u root  -p$MYSQL_ROOTPASSWD -e "FLUSH PRIVILEGES"

# https://www.digitalocean.com/community/tutorials/how-to-set-up-master-slave-replication-in-mysql
# begin MySQL Master Slave replication configuration

echo "bind-address     	      = $MASTERADDR " >> /etc/mysql/my.cnf

echo "server-id               = 1" >> /etc/mysql/my.cnf

echo "log_bin                 = /var/log/mysql/mysql-bin.log" >> /etc/mysql/my.cnf

echo "binlog_do_db            = $REPLICATED_DB" >> /etc/mysql/my.cnf

service mysql restart

# Master Database Configuration

mysql -u root -p$MYSQL_ROOTPASSWD -e "GRANT REPLICATION SLAVE ON *.* TO '$MASTER_USER'@'%' IDENTIFIED BY '$MASTER_PASSWORD';"

mysql -u root -p$MYSQL_ROOTPASSWD -e "FLUSH PRIVILEGES; "

env -i bash -l -c 'mysql -u root -p$MYSQL_ROOTPASSWD -e "USE $REPLICATED_DB;"'

env -i bash -l -c 'mysql -u root -p$MYSQL_ROOTPASSWD -e "FLUSH TABLES WITH READ LOCK;"'

env -i bash -l -c 'mysql -u root -p$MYSQL_ROOTPASSWD -e "SHOW MASTER STATUS;"'

mysqldump -u root -p$MYSQL_ROOTPASSWD --opt $REPLICATED_DB > /tmp/$REPLICATED_DB.sql

mysql -u root -p$MYSQL_ROOTPASSWD -e "UNLOCK TABLES;"

# Slave Database Configuration
'
CREATE DATABASE $REPLICATED_DB;

mysql -u root -p$MYSQL_ROOTPASSWD $REPLICATED_DB.sql < /tmp/$REPLICATED_DB.sql

echo "server-id               = 2" >> /etc/mysql/my.cnf
echo "relay-log               = /var/log/mysql/mysql-relay-bin.log" >> /etc/mysql/my.cnf
echo "log_bin                 = /var/log/mysql/mysql-bin.log" >> /etc/mysql/my.cnf
echo "binlog_do_db            = $REPLICATED_DB" >> /etc/mysql/my.cnf

service mysql restart

CHANGE MASTER TO MASTER_HOST='$MASTERADDR',MASTER_USER='$MASTER_USER', MASTER_PASSWORD='$MASTER_PASSWORD', MASTER_LOG_FILE='mysql-bin.000001', MASTER_LOG_POS=  107;

mysql -u root -p$MYSQL_ROOTPASSWD -e "START SLAVE;"

mysql -u root -p$MYSQL_ROOTPASSWD -e "SHOW SLAVE STATUS\G"

mysql -u root -p$MYSQL_ROOTPASSWD -e "SET GLOBAL SQL_SLAVE_SKIP_COUNTER = 1; SLAVE START; " '
