#!/bin/bash

HOST_IP=$(/sbin/ip route|awk '/default/ { print $3 }')

mv /usr/local/etc/php/conf.d/xdebug.off /usr/local/etc/php/conf.d/xdebug.ini

sed -i "s|xdebug.remote_host=.*|xdebug.remote_host=$HOST_IP|" /usr/local/etc/php/conf.d/xdebug.ini

pkill -o -USR2 php-fpm
