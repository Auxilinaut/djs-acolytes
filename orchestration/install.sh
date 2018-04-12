/bin/bash

apt-get update

apt-get -y upgrade

apt-get -y dist-upgrade

apt-get -y autoremove 

apt-get -y install rabbitmq-server

service rabbitmq-server stop

touch /etc/php/mods-available/amqp.ini

echo "; configuration for php amqp module" >> /etc/php/mods-available/amqp.ini
echo "extension=amqp.so" >> /etc/php/mods-available/amqp.ini

ln -s /etc/php/mods-available/amqp.ini /etc/php/7.0/cli/conf.d/

systemctl enable rabbitmq-server

service rabbitmq-server start

