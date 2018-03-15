#!/bin/bash

echo -e " ${RED}Updating your system...${NC} "

apt-get update

apt-get -y dist-upgrade

apt-get -y upgrade

echo -e " ${RED}Cleaning up...${NC} "

apt-get -y autoremove && apt-get autoclean


APACHE_LOG='/var/log/apache2/'
RABBITMQ_LOG='/var/log/rabbitmq/'
MYSQL_LOG='/var/log/mysql/'

PS3='Please select server type: '
options=("Remote server" "Local server" "Quit")
select opt in "${options[@]}"
do
    case $opt in
        "Remote server")
            echo -e " ${RED}Installing and configuring rsyslog...${NC} "
            apt-get -y install rsyslog
	    mv /etc/rsyslog.conf /etc/rsyslog.conf.bk
 	    cp rsyslog.conf /etc/
            echo -e " ${RED}Remote server configration done.${NC} "
            break
            ;;
        "Local server")
            echo -e " ${RED}Configuring rsyslog on local server.....${NC} "
            touch /etc/rsyslog.d/10-rsyslog.conf
	    echo "*.*   @remote.server:514" > /etc/rsyslog.d/10-rsyslog.conf
	    service rsyslog restart
            echo -e " ${RED}Local server configuration done.${NC} "
            break
            ;;
        "Quit")
          echo "Goodbye $USER"
          exit
            ;;        
        "Exit")
            break
            ;;
        *) echo invalid option;;
    esac
done



