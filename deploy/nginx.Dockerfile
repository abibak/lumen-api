FROM nginx:1.23.3

ADD /config/vhost.conf /etc/nginx/conf.d/default.conf