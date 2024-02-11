#!/bin/bash

RED="\033[0;31m"
YELLOW="\033[0;33m"
NC="\033[0m"

function prepare {
  if [ -z "${DOCKERGID}" ]
  then
      printf "${RED}";
      echo "docker group id must be present in env"
      printf "${NC}";
      exit 1
  fi

  printf "${YELLOW}";
  echo "docker group id: ${DOCKERGID}"

  if ! [ "$(getent group hostdocker)" ]
  then
      groupadd -g "${DOCKERGID}" hostdocker
      echo "[hostdocker] group created"

      usermod -aG hostdocker webuser
      echo "[webuser] added to [hostdocker] group"
  fi

  if id -nG webuser | grep -qw sudo; then
      echo "[webuser] already added to [sudo] group"
  else
      usermod -aG sudo webuser
        echo "[webuser] added to [sudo] group"
  fi
}

prepare

tail -f /dev/null