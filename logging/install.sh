#!/bin/bash

echo "Updating your system..."

apt-get update

apt-get -y dist-upgrade

apt-get -y upgrade

echo "Cleaning up..."

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
	    echo "Installing and configuring rsyslog..."
            apt-get -y install rsyslog
	    mv /etc/rsyslog.conf /etc/rsyslog.conf.bk
 	    cp rsyslog.conf /etc/
 	    echo "Remote server configration done."
            break
            ;;
        "Local server")
            echo "Configuring rsyslog on local server....."
            touch /etc/rsyslog.d/10-rsyslog.conf
	    echo "*.*   @remote.server:514" > /etc/rsyslog.d/10-rsyslog.conf
	    service rsyslog restart
            echo "Local server configuration done."
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



