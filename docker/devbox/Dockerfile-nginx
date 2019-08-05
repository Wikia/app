# This is a base nginx image with Wikia's directory structure
FROM xcgd/nginx-vts:stable

RUN chown -R nginx:nginx /etc/nginx && \
    chown nginx:nginx /var/cache/nginx && \
    chown -R nginx:nginx /var/log/nginx && \
    mkdir /var/run/nginx && \
    chown nginx:nginx /var/run/nginx

USER nginx
