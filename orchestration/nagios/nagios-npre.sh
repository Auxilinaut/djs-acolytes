#!/bin/bash
#https://www.digitalocean.com/community/tutorials/how-to-install-nagios-4-and-monitor-your-servers-on-ubuntu-16-04#step-5-%E2%80%94-installing-napre-on-a-host
apt-get update 

apt-get -y install build-essential libgd2-xpm-dev openssl libssl-dev unzip

cd /tmp

wget -c http://nagios-plugins.org/download/nagios-plugins-2.2.1.tar.gz


tar xvf nagios-plugins-2.2.1.tar.gz tar

cd nagios-plugins-2.2.1

./configure --with-nagios-user=nagios --with-nagios-group=nagios --with-openssl

make

make install

cd /tmp

wget -c https://github.com/NagiosEnterprises/nrpe/releases/download/nrpe-3.2.1/nrpe-3.2.1.tar.gz

tar zxf nrpe-*.tar.gz

cd nrpe-3.2.1

./configure --enable-command-args --with-nagios-user=nagios --with-nagios-group=nagios --with-ssl=/usr/bin/openssl --with-ssl-lib=/usr/lib/x86_64-linux-gnu

make all

make install

make install-config

make install-init

sed -i '/allowed_hosts=127.0.0.1,::1/c\allowed_hosts=127.0.0.1,::1,$HOSTNAMEIP' /usr/local/nagios/etc/nrpe.cfg

systemctl start nrpe.service

# Check the communication with the remote NRPE server. Run the following command on the Nagios server:
#/usr/local/nagios/libexec/check_nrpe -H remote_host_ip

/usr/local/nagios/etc/nrpe.cfg

sed -i '/server_address=/c\server_address=$HOSTNAMEIP' /usr/local/nagios/etc/nrpe.cfg

#sed -i '/command[check_vda1]=/usr/lib/nagios/plugins/check_disk -w 20% -c 10% -p/c\command[check_vda1]=/usr/lib/nagios/plugins/check_disk -w 20% -c 10% -p /DEV/VDA1' /usr/local/nagios/etc/nrpe.cfg

#systemctl restart nrpe.service

# begin step 6

#touch /usr/local/nagios/etc/servers/$HOSTNAME.cfg





