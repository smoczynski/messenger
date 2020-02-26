#!/bin/bash
for f in $(find /etc/nginx/templates -regex '.*\.conf'); do
#pass only needed variables in .conf
envsubst \
' ${APP_DOMAIN} ${QUEUE_DOMAIN}' \
< $f >  \
"/etc/nginx/conf.d/$(basename $f)";
done

nginx -g 'daemon off;'
