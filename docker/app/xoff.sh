#!/bin/bash

mv /usr/local/etc/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.off

pkill -o -USR2 php-fpm