###################################################################
#	PROD--> FE[_] BE[_] DMZ[_] ------>                        #
#                                                                 #
#	QA-->     [_]   [_]    [_] ------>     ORCHESTRATION[_]   #
#                                                                 #
#	DEV-->    [_]   [_]    [_] ------>                        #
###################################################################
##SET VARIABLES MANUALLY HERE########
VHOST=""
USER=""
PASSWORD=""
HOST=""
HOST_TYPE=""
MYSQL_USER=""
MYSQL_PASSWORD=""
DATABASE_NAME=""i
#CLUSTER_NAME=rabbit@$HOSTNAME
#VERSION=increment version numbers here
####################################
#!/bin/bash
echo "

Welcome to:
+-+-+-+-+-+-+-+-+-+-+-+-+
|o|r|c|h|e|s|t|r|a|t|o|r|
+-+-+-+-+-+-+-+-+-+-+-+-+

This script will guide you in creating, deploying and rolling back packages.
"
cd /tmp

read -p 'Please enter the VHOST: ' VHOST

read -sp 'Please enter the user [admin]: ' USER
if [ "$USER" = "" ];
then
   HOST="admin"
fi


echo

read -sp 'Please enter the password: ' PASSWORD

printf '\n\n\n\n'

printf 'VHOST, USER and PASSWORD variables have been set for use in backup\n\n\n'

read -p 'Would you like to continue and run the script?' -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]
then

read -p 'Please enter the host machine to send backups to [localhost]: ' HOST
if [ "$HOST" = "" ];
then
   HOST="localhost"
fi

read -p 'Please enter the host type (Prod.,QA,Dev.,etc): ' HOST_TYPE

echo "PATH="$HOME/bin:$HOME/.local/bin:$PATH"" >> ~/.profile

source ~/.profile

mkdir ~/bin/

#wget http://localhost:15672/cli/rabbitmqadmin
#curl -L https://raw.githubusercontent.com/rabbitmq/rabbitmq-management/v3.7.4/bin/rabbitmqadmin > ~/bin/rabbitmqadmin

#chmod +x  ~/bin/rabbitmqadmin

mkdir /tmp/$HOST_TYPE.orchestrator-backup/{,/FE,/BE,/DMZ}

mkdir /tmp/$HOST_TYPE.orchestrator-backup/BE/sql

echo 'Backing up front-end'

cp -rv /var/www/ /tmp/$HOST_TYPE.orchestrator-backup/FE/

echo 'Backing up back-end'

read -sp 'Please enter the mysql db user [rabbitmq]: ' MYSQL_USER
if [ "$USER" = "" ];
then
   MYSQL_USER="rabbitmq"
fi


read -sp 'Please enter the mysql user password: ' MYSQL_PASSWORD

read -sp 'Please enter the mysql database name for backup: ' DATABASE_NAME

mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD $DATABASE_NAME > /tmp/$HOST_TYPE.orchestrator-backup/BE/sql/$DATABASE_NAME.$(date +%F).sql

printf "\n\n\nThe mysql database $DATABASE_NAME has been saved to:\n /tmp/$HOST_TYPE.orchestrator-backup/BE/sql/"

mkdir /tmp/$HOST_TYPE.orchestrator-backup/BE/rabbitmq

cp -rv /var/lib/rabbitmq/mnesia /tmp/$HOST_TYPE.orchestrator-backup/BE/rabbitmq

tar -cvf /tmp/$HOST_TYPE.orchestrator-backup
tar -cvf /tmp/$HOST_TYPE.orchestrator-backup.$VERSION.tar.gz /tmp/$HOST_TYPE.orchestrator-backup

# Enable mangement plugin
#rabbitmq-plugins enable rabbitmq_management

#service rabbitmq-server restart

#https://www.rabbitmq.com/backup.html
# Export  configuration definitions 
#bash rabbitmqadmin  export /tmp/$HOST_TYPE.orchestrator-backup/BE/$(hostname).rabbit-backup.config.$(date +%F)  --vhost=$VHOST  -u $USER -p $PASSWORD
#if we decide to export with rabbitmqadmin we will need to import with
#rabbitmqadmin -q import rabbit.definitions.json


fi
