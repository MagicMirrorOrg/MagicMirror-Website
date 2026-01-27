FROM nginxinc/nginx-unprivileged:alpine-slim
LABEL maintainer="MagicMirrorOrg"

USER root

RUN ln -s /dev/stdout /var/log/nginx/nodebb.access.log

USER nginx

COPY container/default.conf /etc/nginx/conf.d/
COPY container/nginx.conf /etc/nginx/

COPY public /usr/share/nginx/website/

EXPOSE 8080 8082

HEALTHCHECK --timeout=10s --start-period=60s CMD wget -qO /dev/null http://0.0.0.0:8080
