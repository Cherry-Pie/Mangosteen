FROM serversideup/php:8.2-fpm-nginx


RUN apt-get update \
    && apt-get -qy full-upgrade \
    && apt-get install -qy curl

RUN apt-get install -qy apt-utils

RUN curl -sSL https://get.docker.com/ | sh

COPY prepare.sh /prepare.sh
RUN chmod +x /prepare.sh


COPY mango /var/www/html
RUN chown webuser:webgroup -R /var/www/html
RUN chmod 775 -R /var/www/html/storage


COPY default.run.sh /var/www/html/app/run.after.sh
RUN chmod +x /var/www/html/app/run.after.sh

COPY default.run.sh /var/www/html/app/run.before.sh
RUN chmod +x /var/www/html/app/run.before.sh

COPY default.stop.sh /var/www/html/app/stop.after.sh
RUN chmod +x /var/www/html/app/stop.after.sh

COPY default.stop.sh /var/www/html/app/stop.before.sh
RUN chmod +x /var/www/html/app/stop.before.sh


COPY protected_names.json /var/www/html/app/protected_names.json
