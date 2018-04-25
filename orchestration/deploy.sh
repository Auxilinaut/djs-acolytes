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
CLUSTER_NAME=rabbit@$HOSTNAME
#VERSION=increment version numbers here
####################################
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

'read -p 'Please enter the host machine to send backups to [localhost]: ' HOST
if [ "$HOST" = "" ];
then
   HOST="localhost"
fi'

printf "Let's configure the IP for each host\n\n\n"

read -p 'Please enter the host IP for the Production host: ' PRODHOST
echo 'Production [PROD] IP host set to $PRODHOST'

read -p 'Please enter the host IP for the Quality Assurance host: ' QAHOST
echo 'Quality Assurance [QA] IP host set to $QAHOST'

read -p 'Please enter the host IP for the Development host: ' DEVHOST
echo 'Development [DEV] IP host set to $DEVHOST'


#read -p 'Please choose the host type to send bacups to: ' HOST_TYPE
PS3='Please choose the host type to send backups: '
options=("PROD" "QA" "DEV" "LOCAL" "NONE")
select opt in "${options[@]}"
do
    case $opt in
        "PROD")
     	    echo -e "PROD host selected.\n...\n.....\n......."
	    HOST_TYPE="PROD"
	    HOSTIP=$PRODHOST
            ;;
        "QA")
 	    echo -e "QA host selected.\n...\n.....\n......."		
	    HOST_TYPE="QA"
	    HOSTIP=$QAHOST
            ;;
        "DEV")
	    echo -e "DEV host selected.\n...\n.....\n......."
	    HOST_TYPE="DEV"
	    HOSTIP=$DEVHOST
            ;;
        "LOCAL")
	    echo -e "LOCAL host selected.\n...\n.....\n......."
	    HOST_TYPE="LOCALHOST"
	    HOSTIP=$LOCALHOST
            ;;
 	"NONE")
	    break
	    ;;
        *) echo invalid option;;
    esac
done


echo "PATH="$HOME/bin:$HOME/.local/bin:$PATH"" >> ~/.profile

source ~/.profile

mkdir ~/bin/

#wget http://localhost:15672/cli/rabbitmqadmin
#curl -L https://raw.githubusercontent.com/rabbitmq/rabbitmq-management/v3.7.4/bin/rabbitmqadmin > ~/bin/rabbitmqadmin

#chmod +x  ~/bin/rabbitmqadmin

mkdir /tmp/$HOST_TYPE.orchestrator-backup/{,/FE,/BE,/DMZ}

mkdir /tmp/$HOST_TYPE.orchestrator-backup/BE/sql

echo -e 'Backing up front-end\n....\n......\n........'

cp -rv /var/www/ /tmp/$HOST_TYPE.orchestrator-backup/FE/

echo -e 'Backing up back-end\n....\n......\n........'

'read -sp 'Please enter the mysql db user [rabbitmq]: ' MYSQL_USER
if [ "$USER" = "" ];
then
   MYSQL_USER="rabbitmq"
fi'


read -sp 'Please enter the rabbitmq mysql user password: ' MYSQL_PASSWORD

read -sp 'Please enter the rabbitmq mysql database name for backup: ' DATABASE_NAME

mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD $DATABASE_NAME > /tmp/$HOST_TYPE.orchestrator-backup/BE/sql/$DATABASE_NAME.$(date +%F).sql

printf "\n\n\nThe mysql database $DATABASE_NAME has been saved to:\n /tmp/$HOST_TYPE.orchestrator-backup/BE/sql/"

mkdir /tmp/$HOST_TYPE.orchestrator-backup/BE/rabbitmq

cp -rv /var/lib/rabbitmq/mnesia /tmp/$HOST_TYPE.orchestrator-backup/BE/rabbitmq

tar -cvf /tmp/$HOST_TYPE.orchestrator-backup.$VERSION.tar.gz /tmp/$HOST_TYPE.orchestrator-backup

# Package installation starts here

#here is where we begin to transfer data. maybe we should know where we are sending to and the default location?
scp -v /tmp/$HOST_TYPE.orchestrator-backup.$VERSION.tar.gz rabbitmq@HOSTIP:/backup/location/here 



# Enable mangement plugin
#rabbitmq-plugins enable rabbitmq_management

#service rabbitmq-server restart

#https://www.rabbitmq.com/backup.html
# Export  configuration definitions 
#bash rabbitmqadmin  export /tmp/$HOST_TYPE.orchestrator-backup/BE/$(hostname).rabbit-backup.config.$(date +%F)  --vhost=$VHOST  -u $USER -p $PASSWORD
#if we decide to export with rabbitmqadmin we will need to import with
#rabbitmqadmin -q import rabbit.definitions.json


fi
