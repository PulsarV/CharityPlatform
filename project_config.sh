#!/bin/bash
# This script will perform all the necessary settings to launch the project

clear
echo "Select action:"
echo "1 - Install project (full configuration and load fixtures)"
echo "2 - Reinstall backend"
echo "3 - Reinstall frontend"
echo "4 - Recreate database and load fixtures"
echo "5 - Recreate database"
echo "6 - Load fixtures"
echo "7 - Exit"

read Keypress

case "$Keypress" in
1)
    echo
    echo INSTALLING BACKEND ...
    echo ======================
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install
    rm composer.phar
    rm -rf app/cache/*
    rm -rf app/logs/*
    setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
    setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
    echo
    echo INSTALLING FRONTEND ...
    echo =======================
    npm install -S bower gulp less gulp-less gulp-clean gulp-concat gulp-uglify
    ./node_modules/.bin/bower install -S bootstrap tinymce
    ./node_modules/.bin/gulp
    echo
    echo CREATE DATABASE ...
    echo ==================
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
    echo
    echo LOAD FIXTURES ...
    echo =================
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
2)
    echo
    echo REINSTALLING BACKEND ...
    echo ========================
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install
    rm composer.phar
    rm -rf app/cache/*
    rm -rf app/logs/*
    setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
    setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
;;
3)
    echo REINSTALLING FRONTEND ...
    echo =========================
    npm install -S bower gulp less gulp-less gulp-clean gulp-concat gulp-uglify
    ./node_modules/.bin/bower install -S bootstrap tinymce
    ./node_modules/.bin/gulp
;;
4)
    echo
    echo RECREATE DATABASE ...
    echo =====================
    ./app/console doctrine:database:drop --force
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
    echo
    echo LOAD FIXTURES ...
    echo =================
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
5)
    echo
    echo RECREATE DATABASE ...
    echo =====================
    ./app/console doctrine:database:drop --force
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
;;
6)
    echo
    echo LOAD FIXTURES ...
    echo =================
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
7)
    exit 0
;;
*)
    echo "ERROR! UNDEFINED ACTION"
    exit 0
;;
esac
echo
echo =======================
echo ALL OPERATION COMPLETED
exit 0