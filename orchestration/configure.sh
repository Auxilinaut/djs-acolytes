###################################################################
#	PROD--> FE[_] BE[_] DMZ[_] ------>                        #
#                                                                 #
#	QA-->     [_]   [_]    [_] ------>     ORCHESTRATION[_]   #
#                                                                 #
#	DEV-->    [_]   [_]    [_] ------>                        #
###################################################################
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

wget http://localhost:15672/cli/rabbitmqadmin
#curl -L https://raw.githubusercontent.com/rabbitmq/rabbitmq-management/v3.7.4/bin/rabbitmqadmin > ~/bin/rabbitmqadmin

chmod +x  ~/bin/rabbitmqadmin

mkdir /tmp/$HOST_TYPE.orchestrator-backup/{,/FE,/BE,/DMZ}

echo 'Backing up front-end'
cp -rv /var/www/ /tmp/$HOST_TYPE.orchestrator-backup/FE/


# Enable mangement plugin
rabbitmq-plugins enable rabbitmq_management

service rabbitmq-server restart

# Export  configuration definitions
bash rabbitmqadmin  export $HOST_TYPE.orchestrator-backup/BE/$(hostname).rabbit-backup.config.$(date +%F)  --vhost=$VHOST  -u $USER -p $PASSWORD


fi
