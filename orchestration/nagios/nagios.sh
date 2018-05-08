#https://www.digitalocean.com/community/tutorials/how-to-install-nagios-4-and-monitor-your-servers-on-ubuntu-16-04
#!/bin/bash

apt-get update

apt-get -y dist-upgrade

apt-get -y upgrade 

apt-get -y autoremove

useradd nagios

groupadd nagcmd

usermod -a -G nagcmd nagios

apt-get -y install build-essential libgd2-xpm-dev openssl libssl-dev unzip apache2 php7.0 libapache2-mod-php7.0 apache2-utils

cd /tmp

wget -c https://assets.nagios.com/downloads/nagioscore/releases/nagios-4.3.4.tar.gz

tar zxf nagios-*.tar.gz 

cd nagios-*

./configure --with-nagios-group=nagios --with-command-group=nagcmd

make all

make install

make install-commandmode

make install-init

make install-config

/usr/bin/install -c -m 644 sample-config/httpd.conf /etc/apache2/sites-available/nagios.conf

usermod -G nagcmd www-data

cd /tmp

wget -c https://github.com/NagiosEnterprises/nrpe/releases/download/nrpe-3.2.1/nrpe-3.2.1.tar.gz

tar zxf nrpe-*.tar.gz

cd nrpe-*

./configure

make check_nrpe

make install-plugin

sed -i '51 s/^#*//' /usr/local/nagios/etc/nagios.cfg

mkdir /usr/local/nagios/etc/servers

sed -i -e 's/nagios@localhost/jo75@njit.edu/g' /usr/local/nagios/etc/objects/contacts.cfg

echo "define command{" >> /usr/local/nagios/etc/objects/commands.cfg
echo -e "\tcommand_name check_nrpe"  >> /usr/local/nagios/etc/objects/commands.cfg
echo -e "\tcommand_line "'$USER1$/check_nrpe -H $HOSTADDRESS$ -c $ARG1$'"\n}" >> /usr/local/nagios/etc/objects/commands.cfg

a2enmod rewrite
a2enmod cgi

htpasswd -b -c /usr/local/nagios/etc/htpasswd.users nagiosadmin nagiosadmin

ln -s /etc/apache2/sites-available/nagios.conf /etc/apache2/sites-enabled/

#sed -i '/SSLRequireSSL/s/^#//g' /etc/apache2/sites-available/nagios.conf
sed -i '/Order allow,deny/s/^/#/g' /etc/apache2/sites-available/nagios.conf
sed -i '/Allow from all/s/^/#/g' /etc/apache2/sites-available/nagios.conf

sed -i '/Order deny,allow/s/^#//g' /etc/apache2/sites-available/nagios.conf
sed -i '/Deny from all/s/^#//g' /etc/apache2/sites-available/nagios.conf
#sed -i '/Allow from 127.0.0.1/c\Allow from 127.0.0.1 $HOSTNAME'  /etc/apache2/sites-available/nagios.conf
sed -i '/Allow from 127.0.0.1/s/^#//g' /etc/apache2/sites-available/nagios.conf

systemctl restart apache2

touch /etc/systemd/system/nagios.service

echo -e "[Unit]\nDescription=Nagios\nBindTo=network.target\n\n[Install]\nWantedBy=multi-user.target" >> /etc/systemd/system/nagios.service
echo -e "\n\n[Service]\nType=simple\nUser=nagios\nGroup=nagios\nExecStart=/usr/local/nagios/bin/nagios /usr/local/nagios/etc/nagios.cfg" >> /etc/systemd/system/nagios.service

systemctl enable /etc/systemd/system/nagios.service
systemctl start nagios




