FROM serversideup/php:8.2-fpm-nginx

ARG DOCKER_GID

RUN apt-get update \
    && apt-get -qy full-upgrade \
    && apt-get install -qy curl

RUN apt-get install -qy apt-utils

RUN curl -sSL https://get.docker.com/ | sh

RUN groupadd -g ${DOCKER_GID} hostdocker
RUN usermod -a -G hostdocker webuser
RUN usermod -aG sudo webuser
