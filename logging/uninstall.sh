#!/bin/bash

# We won't need this but if we do for some reason.

echo -e " ${RED}Undoing changes...${NC} "

apt-get -y remove rsyslog

rm /etc/rsyslog.* 

rm /etc/rsyslog.d/10-rsyslog.conf


echo -e " ${RED}Cleaning up...${NC} "

apt-get -y autoremove && apt-get autoclean

read -p "Can I reboot your system? " -n 1 -r
echo   
if [[ $REPLY =~ ^[Yy]$ ]]
then
   reboot;
else
  echo "I won't reboot your system $USER";
fi
