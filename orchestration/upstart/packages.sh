#!/bin/bash
###################################################################
#       PROD--> FE[_] BE[_] DMZ[_] ------>                        #
#                                                                 #
#       QA-->     [_]   [_]    [_] ------>     ORCHESTRATION[_]   #
#                                                                 #
#       DEV-->    [_]   [_]    [_] ------>                        #
###################################################################
INTERVAL="60m"
USERNAME="justin"
ORCHESTRATION="192.168.88.217"
NODENAME="rabbit@$HOSTNAME"
MYSQL_USER="rabbitmq"
MYSQL_PASSWORD=""
DATABASE_NAME="userdata"

`
while (sleep $INTERVAL); do
  shopt -s nocasematch
if [ $HOSTNAME = "PROD" ];
then
  export HOST_MACHINE='PROD'
  export PRODHOST=$(hostname -I)
  export HOSTIP=$PRODHOST
elif [ $HOSTNAME = "DEV" ]
then
  export HOST_MACHINE='DEV'
  export DEVHOST=$(hostname -I)
  export HOSTIP=$DEVHOST
elif [ $HOSTNAME = "QA" ]
then
 export HOST_MACHINE='QA'
 export QAHOST=$(hostname -I) 
 export HOSTIP=$QAHOST
fi
done
`

cd /tmp

mkdir /tmp/orchestrator-backup/$HOST_MACHINE/{,/FE,/BE,/DMZ}

mkdir /tmp/orchestrator-backup/$HOST_MACHINE/BE{,/sql,/rbmq}

echo -e 'Backing up front-end\n....\n......\n........'

cp -rv /var/www/ /tmp/orchestrator-backup/$HOST_MACHINE/FE/

echo -e 'Backing up back-end\n....\n......\n........'

cp -rv /var/lib/rabbitmq/mnesia	/tmp/orchestrator-backup/$HOST_MACHINE/BE/rbmq

mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD $DATABASE_NAME > /tmp/orchestrator-backup/$HOST_MACHINE/BE/sql/$DATABASE_NAME.$(date +%F).sql

printf "\n\n\nThe mysql database $DATABASE_NAME has been saved to:\n /tmp/orchestrator-backup/$HOST_MACHINE/BE/sql/"

VERSION=0

/tmp/orchestrator-backup/$HOST_MACHINE-*.$VERSION.tar.gz
while [[ -d "/tmp/orchestrator-backup/$HOST_MACHINE-$(date +%F).$VERSION.tar.gz" ]] ; do
    VERSION++
done

tar -cvf /tmp/orchestrator-backup/$HOST_MACHINE-$(date +%F).$VERSION.tar.gz /tmp/orchestrator-backup/

find /tmp/orchestrator-backup/ -name "*.tar.gz" -exec rsync -R {} $USERNAME@$ORCHESTRATION:/home/$USERNAME/ORCHESTRATION-BACKUP/$HOST_MACHINE \;







