#!/bin/bash

PREPARE_DIR="web/prepare"
WEB_APP_DIR="../src/web/basic"

MYSQL_HOST="localhost"
MYSQL_DB_NAME="GDCWeather"
MYSQL_USER="root"
MYSQL_PASS="root"

VHOST_DOCUMENT_ROOT="/var/www/default"
VHOST_WEB_SERVER_NAME="localhost"

IS_PRODUCTION=0

while test $# -gt 0; do
    case "$1" in
        -h|--help)
            echo "HELP"
            exit 0
            ;;
        --mysql-host*)
            MYSQL_HOST=`echo $1 | sed -e 's/^[^=]*=//g'`
            shift
            ;;
        --mysql-user*)
            MYSQL_USER=`echo $1 | sed -e 's/^[^=]*=//g'`
            shift
            ;;
        --mysql-pass*)
            MYSQL_PASS=`echo $1 | sed -e 's/^[^=]*=//g'`
            shift
            ;;
        --mysql-db*)
            MYSQL_DB_NAME=`echo $1 | sed -e 's/^[^=]*=//g'`
            shift
            ;;
        --vhost-path*)
            VHOST_DOCUMENT_ROOT=`echo $1 | sed -e 's/^[^=]*=//g'`
            shift
            ;;
        --vhost-server-name*)
            VHOST_WEB_SERVER_NAME=`echo $1 | sed -e 's/^[^=]*=//g'`
            shift
            ;;
        --prod)
            IS_PRODUCTION=1
            shift
            ;;
        *)
            break
            ;;
    esac
done

echo "==CONFIGURATION=="
echo
echo "--DB--"
echo "MYSQL_HOST=$MYSQL_HOST"
echo "MYSQL_USER=$MYSQL_USER"
echo "MYSQL_PASS=$MYSQL_PASS"
echo "MYSQL_DB_NAME=$MYSQL_DB_NAME"
echo
echo "--Apache virtual host config--"
echo "VHOST_DOCUMENT_ROOT=$VHOST_DOCUMENT_ROOT"
echo "VHOST_WEB_SERVER_NAME=$VHOST_WEB_SERVER_NAME"
echo
echo "--Environment--"
echo "IS_PRODUCTION=$IS_PRODUCTION"

if [[ -d "$PREPARE_DIR" ]]; then
    rm -rf  $PREPARE_DIR
fi

mkdir $PREPARE_DIR
mkdir "$PREPARE_DIR/$VHOST_WEB_SERVER_NAME"

PREPARE_WEB_APP_DIR="$PREPARE_DIR/$VHOST_WEB_SERVER_NAME/web-app"

mkdir $PREPARE_WEB_APP_DIR

VHOST_CONF_DIR="$PREPARE_DIR/$VHOST_WEB_SERVER_NAME/vhost"

declare -a prepareRequiredSource=("assets" "businessLogic" "commands" "controllers" "dataAccess" "messages" "models" "vendor" "views" "webService" "workers")

for item in "${prepareRequiredSource[@]}"
do
    cp -r $WEB_APP_DIR/$item  $PREPARE_WEB_APP_DIR/$item
done

mkdir $PREPARE_WEB_APP_DIR/web

declare -a prepareWebSource=("css" "js" "favicon.ico" ".htaccess")

for item in "${prepareWebSource[@]}"
do
    cp -r $WEB_APP_DIR/web/$item  $PREPARE_WEB_APP_DIR/web/$item
done

mkdir $PREPARE_WEB_APP_DIR/config

declare -a prepareConfig=("console.php" "di.php" "params.php" "web.php")
for item in "${prepareConfig[@]}"
do
    cp -r $WEB_APP_DIR/config/$item  $PREPARE_WEB_APP_DIR/config/$item
done

sed -e "s;%MYSQL_HOST%;$MYSQL_HOST;g" -e "s;%MYSQL_DB_NAME%;$MYSQL_DB_NAME;g" -e "s;%MYSQL_USER%;$MYSQL_USER;g" -e "s;%MYSQL_PASS%;$MYSQL_PASS;g" db.php.template > $PREPARE_WEB_APP_DIR/config/db.php
sed -e "s;%YII_DEBUG%;false;g" -e "s;%YII_ENV%;prod;g" index.php.template > $PREPARE_WEB_APP_DIR/web/index.php

mkdir $PREPARE_WEB_APP_DIR/runtime
mkdir $PREPARE_WEB_APP_DIR/web/assets

mkdir $VHOST_CONF_DIR

sed -e "s;%DOCUMENT_ROOT%;$VHOST_DOCUMENT_ROOT;g" -e "s;%SERVER_NAME%;$VHOST_WEB_SERVER_NAME;g" vhost.conf.template > $VHOST_CONF_DIR/$VHOST_WEB_SERVER_NAME.config