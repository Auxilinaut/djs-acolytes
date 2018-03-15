#!/bin/bash

# We won't need this but if we do for some reason.

echo -e "\e[1;31mUndoing changes....\e[0m"

apt-get -y remove rsyslog

rm /etc/rsyslog.conf

rm /etc/rsyslog.d/10-rsyslog.conf


echo -e "\e[1;31mCleaning up.... $USER\e[0m"

apt-get -y autoremove && apt-get autoclean

read -p "Can I reboot your system? " -n 1 -r
echo   
if [[ $REPLY =~ ^[Yy]$ ]]
then
   reboot;
else
  echo "I won't reboot your system $USER";
fi
