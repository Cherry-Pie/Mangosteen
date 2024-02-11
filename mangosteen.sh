#!/bin/bash

YELLOW="\033[0;33m"
BLUE="\033[0;34m"
BOLDGREEN="\033[1;32m"
RED="\033[0;31m"
NC="\033[0m"

function install {
  install_env
  create_scripts
  create_protected_names_json
  create_docker_network
  create_docker_compose_file
}

function install_env {
    # logo for gags
  	echo -e "${RED}";
    echo -e "                           _               ";
    echo -e " _____ ___ ___ ___ ___ ___| |_ ___ ___ ___ ";
    echo -e "|     | .'|   | . | . |_ -|  _| -_| -_|   |";
    echo -e "|_|_|_|__,|_|_|_  |___|___|_| |___|___|_|_|";
    echo -e "              |___|                        ";
  	echo -e "${NC}";

  	echo -e "Type the domain for feature applications, eg. ${BOLDGREEN}domain.local${NC}";
  	read DOMAIN;

  	echo -e "Type subdomain for mangosteen dashboard. ${BLUE}[mangosteen]${NC}";
  	read SUBDOMAIN;
  	SUBDOMAIN=${SUBDOMAIN:-mangosteen};

  	echo -e "Password for dashboard:";
    read -s MANGOSTEEN_PASSWORD;

  	echo -e "Type path to docker socket. ${BLUE}[/var/run/docker.sock]${NC}";
  	read SOCK;
  	SOCK=${SOCK:-/var/run/docker.sock};

  	DOCKERGID=$(getent group docker | cut --delimiter ':' --fields 3);
  	echo -e "Type docker group ID. ${BLUE}${DOCKERGID}${NC}";
  	read ADOCKERGID;
  	ADOCKERGID=${ADOCKERGID:-$DOCKERGID};

  	CURRENTUID=$(id -u);
  	echo -e "Type webuser ID. ${BLUE}${CURRENTUID}${NC}";
  	read WEBUSERUID;
  	WEBUSERUID=${WEBUSERUID:-$CURRENTUID};

  	CURRENTGID=$(id -u);
  	echo -e "Type webuser group ID. ${BLUE}${CURRENTGID}${NC}";
  	read WEBUSERGID;
  	WEBUSERGID=${WEBUSERGID:-$CURRENTGID};


  	echo -e "----------${YELLOW}";
  	echo -e "MANGOSTEEN_DOMAIN=$DOMAIN";
  	echo -e "MANGOSTEEN_DASHBOARD_SUBDOMAIN=$SUBDOMAIN";
  	echo -e "DOCKER_SOCK=$SOCK";
  	echo -e "DOCKER_GID=$ADOCKERGID";
  	echo -e "WEBUSER_UID=$WEBUSERUID";
  	echo -e "WEBUSER_GID=$WEBUSERGID";
  	echo -e "MANGOSTEEN_PASSWORD=******";
  	echo -e "${NC}----------";
  	echo -e '\n'
  	echo -e "Generate .env file? [Y/n]";
  	read ANSWER
  	ANSWER=${ANSWER:-Y};
  	if [ "$ANSWER" != "${ANSWER#[Yy]}" ] ;then
  	  echo "" > .env
  	  echo -e "APP_NAME=Mangosteen" >> .env;
      echo -e "APP_ENV=production" >> .env;
      echo -e "APP_KEY=$(dd if=/dev/urandom bs=8 count=4 | base64)" >> .env;
      echo -e "APP_DEBUG=false" >> .env;
      echo -e "APP_URL=http://localhost" >> .env;
      echo -e "LOG_CHANNEL=stack" >> .env;
      echo -e "LOG_DEPRECATIONS_CHANNEL=null" >> .env;
      echo -e "LOG_LEVEL=debug" >> .env;
  		echo -e "MANGOSTEEN_DOMAIN=$DOMAIN" >> .env;
  		echo -e "MANGOSTEEN_DASHBOARD_SUBDOMAIN=$SUBDOMAIN" >> .env;
  		echo -e "DOCKER_SOCK=$SOCK" >> .env;
  		echo -e "DOCKER_GID=$ADOCKERGID" >> .env;
  		echo -e "WEBUSER_UID=$WEBUSERUID" >> .env;
  		echo -e "WEBUSER_GID=$WEBUSERGID" >> .env;
  	  echo -e "MANGOSTEEN_PASSWORD=$MANGOSTEEN_PASSWORD" >> .env;

  		echo -e "${BOLDGREEN}Installation complete${NC}";
  		echo -e "Run ${YELLOW}make up${NC} to start application";
  	echo -e '\n'
  	fi
}

function create_scripts {
  echo -e "# echo \$CONTAINER_NAME" > run.before.sh
  echo -e "# echo \$VIRTUAL_HOST" >> run.before.sh
  echo -e "# echo \$VIRTUAL_PORT" >> run.before.sh
  echo -e "# echo \$LETSENCRYPT_HOST" >> run.before.sh
  echo -e "# echo \$IMAGE" >> run.before.sh
  echo -e "# echo \$SUBDOMAIN_VIRTUAL_HOST" >> run.before.sh
  echo -e "# echo \$SUBDOMAIN_LETSENCRYPT_HOST" >> run.before.sh
  echo "" >> run.before.sh
  echo "exit 0" >> run.before.sh

  chmod +x run.before.sh

  echo -e "${BOLDGREEN}run.before.sh created${NC}";


  echo -e "# echo \$CONTAINER_NAME" > run.after.sh
  echo -e "# echo \$VIRTUAL_HOST" >> run.after.sh
  echo -e "# echo \$VIRTUAL_PORT" >> run.after.sh
  echo -e "# echo \$LETSENCRYPT_HOST" >> run.after.sh
  echo -e "# echo \$IMAGE" >> run.after.sh
  echo -e "# echo \$SUBDOMAIN_VIRTUAL_HOST" >> run.after.sh
  echo -e "# echo \$SUBDOMAIN_LETSENCRYPT_HOST" >> run.after.sh
  echo "" >> run.after.sh
  echo "exit 0" >> run.after.sh

  chmod +x run.after.sh

  echo -e "${BOLDGREEN}run.after.sh created${NC}";

  #

  echo -e "# echo \$CONTAINER_NAME" > stop.before.sh
  echo -e "# echo \$CONTAINER_ID" >> stop.before.sh
  echo "" >> stop.before.sh
  echo "exit 0" >> stop.before.sh

  chmod +x stop.before.sh

  echo -e "${BOLDGREEN}stop.before.sh created${NC}";


  echo -e "# echo \$CONTAINER_NAME" > stop.after.sh
  echo -e "# echo \$CONTAINER_ID" >> stop.after.sh
  echo "" >> stop.after.sh
  echo "exit 0" >> stop.after.sh

  chmod +x stop.after.sh

  echo -e "${BOLDGREEN}stop.after.sh created${NC}";
}

function create_protected_names_json {
  echo '[{"name":"mangosteen-app","date":"2024-02-07T21:09:41+00:00"},{"name":"mangosteen-letsencrypt-helper","date":"2024-02-07T21:09:53+00:00"},{"name":"mangosteen-reverse-proxy","date":"2024-02-07T21:10:03+00:00"},{"name":"mangosteen-watchtower","date":"2024-02-07T21:10:12+00:00"}]' > protected_names.json

  echo -e "${BOLDGREEN}protected_names.json created${NC}";
}

function create_docker_network {
  docker network create mangosteen || true
}

function create_docker_compose_file {
  cat > docker-compose.yml <<- EOM
version: "3.7"

services:
  reverse-proxy:
    image: "nginxproxy/nginx-proxy:1.4"
    container_name: "mangosteen-reverse-proxy"
    restart: "always"
    volumes:
      - "html:/usr/share/nginx/html"
      - "dhparam:/etc/nginx/dhparam"
      - "vhost:/etc/nginx/vhost.d"
      - "certs:/etc/nginx/certs"
      - "\${DOCKER_SOCK}:/tmp/docker.sock:ro"
      - "/dev/null:/etc/s6-overlay/s6-rc.d/prepare/50-ipv6.sh"
    labels:
      com.centurylinklabs.watchtower.enable: false
    networks:
      - "mangosteen"
    ports:
      - "80:80"
      - "443:443"

  letsencrypt:
    image: "jrcs/letsencrypt-nginx-proxy-companion:2.2"
    container_name: "mangosteen-letsencrypt-helper"
    restart: "always"
    volumes:
      - "html:/usr/share/nginx/html"
      - "dhparam:/etc/nginx/dhparam"
      - "vhost:/etc/nginx/vhost.d"
      - "certs:/etc/nginx/certs"
      - "\${DOCKER_SOCK}:/var/run/docker.sock:ro"
      - "/dev/null:/etc/s6-overlay/s6-rc.d/prepare/50-ipv6.sh"
    environment:
      NGINX_PROXY_CONTAINER: "mangosteen-reverse-proxy"
      DEFAULT_EMAIL: "user@domain.com"
    depends_on:
      - "reverse-proxy"
    labels:
      com.centurylinklabs.watchtower.enable: false
    networks:
      - "mangosteen"

  watchtower:
    image: "containrrr/watchtower"
    container_name: "mangosteen-watchtower"
    restart: "always"
    environment:
      - WATCHTOWER_POLL_INTERVAL=60
      - WATCHTOWER_LABEL_ENABLE=true
      - WATCHTOWER_CLEANUP=true
    volumes:
      - "\${DOCKER_SOCK}:/var/run/docker.sock:ro"
    networks:
      - "mangosteen"

  app:
    image: "yarosofakingwoeful/mangosteen-app:release"
    container_name: "mangosteen-app"
    restart: "always"
    command: bash /prepare.sh
    environment:
      - SSL_MODE=off
      - AUTORUN_LARAVEL_ROUTE_CACHE=true
      - AUTORUN_LARAVEL_VIEW_CACHE=true
      - VIRTUAL_HOST=\${MANGOSTEEN_DASHBOARD_SUBDOMAIN}.\${MANGOSTEEN_DOMAIN}
      - VIRTUAL_PORT=80
      - PUID=\${WEBUSER_UID}
      - PGID=\${WEBUSER_GID}
      - DOCKERGID=\${DOCKER_GID}
    volumes:
      - "./.env:/var/www/html/.env"
      - "./run.before.sh:/var/www/html/app/run.before.sh"
      - "./run.after.sh:/var/www/html/app/run.after.sh"
      - "./stop.before.sh:/var/www/html/app/stop.before.sh"
      - "./stop.after.sh:/var/www/html/app/stop.after.sh"
      - "./protected_names.json:/var/www/html/app/protected_names.json"
      - "\${DOCKER_SOCK}:/var/run/docker.sock:ro"
    labels:
      com.centurylinklabs.watchtower.enable: true
    networks:
      - "mangosteen"

volumes:
  certs:
  html:
  vhost:
  dhparam:

networks:
  mangosteen:
    external: true
EOM

  echo -e "${BOLDGREEN}docker-compose.yml created${NC}";
  echo ""
  echo -e "Update ${BLUE}docker-compose.yml${NC} to add mandatory services for your application, and run ${YELLOW}docker-compose run -d${NC}"
}

install
