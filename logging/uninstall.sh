#!/bin/bash

# We won't need this but if we do for some reason.

echo -e "\e[1;31mUndoing changes....\e[0m"

apt-get -y remove rsyslog

rm /etc/rsyslog.conf

rm -rf /etc/rsyslog.d/


echo -e "\e[1;31mCleaning up....\e[0m"

apt-get -y autoremove && apt-get autoclean

read -p "Can I reboot your system? " -n 1 -r
echo   
if [[ $REPLY =~ ^[Yy]$ ]]
then
   reboot;
else
  echo "I won't reboot your system $USER";
fi
