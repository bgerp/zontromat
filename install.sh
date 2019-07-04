#!/bin/bash

#sudo apt-get update
#sudo apt-get -y upgrade

sudo apt-get install -y php-cli php-sqlite

crontab -l > cron.res
echo "@reboot php -S 0.0.0.0:8181 -t ~/zontromat/webroot" > cron.res
echo "* * * * * php ~/zontromat/cron.php" >> cron.res
crontab cron.res
rm cron.res

sudo reboot
