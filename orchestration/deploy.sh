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
PRODHOST=""
QAHOST=""
DEVHOST=""
LOCALHOST="127.0.0.1"
HOST_TYPE=""
HOSTIP=""
MYSQL_USER="rabbitmq"
MYSQL_PASSWORD=""
DATABASE_NAME=""
ORCHESTRATORIP=""
CLUSTER_NAME=rabbit@$HOSTNAME
#VERSION=increment version numbers here
####################################
#!/bin/bash

cd /tmp

# We need to detect what host script is running on and send backups 
STRINGCHECK='PROD'
hostchecker=$(grep -i  $STRINGCHECK $HOSTNAME) 
if [ $hostchecker -eq 'PROD' ]
then
  HOST_MACHINE='PROD'
  PRODHOST=$(echo hostname -I)
  HOSTIP=$PRODHOST
elif [ STRINGCHECK='DEV' $hostchecker -eq 'DEV' $HOSTNAME ]
then
  HOST_MACHINE='DEV'
  DEVHOST=$(echo hostname -I)
  HOSTIP=$DEVHOST
else
 HOST_MACHINE='QA'
 QAHOST='$(echo hostname -I)' 
 HOSTIP=$QAHOST
fi

#echo $HOSTNAME | grep -i PROD 

echo "PATH="$HOME/bin:$HOME/.local/bin:$PATH"" >> ~/.profile

source ~/.profile

mkdir ~/bin/

#wget http://localhost:15672/cli/rabbitmqadmin
#curl -L https://raw.githubusercontent.com/rabbitmq/rabbitmq-management/v3.7.4/bin/rabbitmqadmin > ~/bin/rabbitmqadmin

#chmod +x  ~/bin/rabbitmqadmin

mkdir /tmp/$HOST_MACHINE.orchestrator-backup/{,/FE,/BE,/DMZ}

mkdir /tmp/$HOST_MACHINE.orchestrator-backup/BE/sql

echo -e 'Backing up front-end\n....\n......\n........'

cp -rv /var/www/ /tmp/$HOST_MACHINE.orchestrator-backup/FE/

echo -e 'Backing up back-end\n....\n......\n........'


mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD $DATABASE_NAME > /tmp/$HOST_MACHINE.orchestrator-backup/BE/sql/$DATABASE_NAME.$(date +%F).sql

printf "\n\n\nThe mysql database $DATABASE_NAME has been saved to:\n /tmp/$HOST_MACHINE.orchestrator-backup/BE/sql/"

mkdir /tmp/$HOST_MACHINE.orchestrator-backup/BE/rabbitmq

cp -rv /var/lib/rabbitmq/mnesia /tmp/$HOST_MACHINE.orchestrator-backup/BE/rabbitmq

tar -cvf /tmp/$HOST_MACHINE.orchestrator-backup.$VERSION.tar.gz /tmp/$HOST_MACHINE.orchestrator-backup

# Package installation starts here

#here is where we begin to transfer data. maybe we should know where we are sending to and the default location?
scp -v /tmp/$HOST_TYPE.orchestrator-backup.$VERSION.tar.gz rabbitmq@HOSTIP:/backup/location/here 

# generate ssh keys 

ssh-keygen -t rsa -N "" -f ~/.ssh/$HOST_MACHINE.key

cat ~/.ssh/*.pub 



# Enable mangement plugin
#rabbitmq-plugins enable rabbitmq_management

#service rabbitmq-server restart

#https://www.rabbitmq.com/backup.html
# Export  configuration definitions 
#bash rabbitmqadmin  export /tmp/$HOST_TYPE.orchestrator-backup/BE/$(hostname).rabbit-backup.config.$(date +%F)  --vhost=$VHOST  -u $USER -p $PASSWORD
#if we decide to export with rabbitmqadmin we will need to import with
#rabbitmqadmin -q import rabbit.definitions.json


