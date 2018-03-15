#!/bin/bash

echo -e "\e[1;31mUpdating your system....\e[0m"

apt-get update

apt-get -y dist-upgrade

apt-get -y upgrade

echo -e "\e[1;31mCleaning up.....\e[0m"

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
            echo -e "\e[1;31mInstalling and configuring Rsyslog.....\e[0m"
            apt-get -y install rsyslog
	    mv /etc/rsyslog.conf /etc/rsyslog.conf.bk
 	    cp rsyslog.conf /etc/
	    echo -e "\e[1;31mRemote server configuration done.\e[0m"
            break
            ;;
        "Local server")
            echo -e "\e[1;31mConfiguring Rsyslog on local server\e[0m"
            touch /etc/rsyslog.d/10-rsyslog.conf
	    echo "*.*   @remote.server:514" > /etc/rsyslog.d/10-rsyslog.conf
	    service rsyslog restart
	    echo -e "\e[1;31mLocal server configuration done.\e[0m"
            break
            ;;
        "Quit")
	  echo -e "\e[1;31mGoodbye $USER\e[0m"
          exit
            ;;        
        "Exit")
            break
            ;;
        *) echo invalid option;;
    esac
done



