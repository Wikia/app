#!/bin/sh
mkfifo /var/log/nginx/std.log

# envsubst is recommended by the creators of the nginx docker image
CMD envsubst '${FASTCGI_READ_TIMEOUT}' < /etc/nginx/conf.d/site.conf.template > /etc/nginx/conf.d/default.conf && nginx -c /etc/nginx/nginx.conf -g "daemon off;" > /var/log/nginx/std.log