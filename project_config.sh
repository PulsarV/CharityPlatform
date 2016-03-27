#!/bin/bash
# This script will perform all the necessary settings to launch the project

clear
echo "Select action:"
echo "1 - Install project (full configuration, load fixtures, create elastica indexes)"
echo "2 - Reinstall backend"
echo "3 - Reinstall frontend"
echo "4 - Recreate database, load fixtures, recreate elastica indexes"
echo "5 - Recreate database and load fixtures"
echo "6 - Recreate database"
echo "7 - Load fixtures"
echo "8 - Recreate elastica indexes"
echo "9 - Run tests"
echo "10 - Exit"

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
    ./node_modules/.bin/bower install -S bootstrap tinymce-dist
    ./node_modules/.bin/gulp
    echo
    echo RESETTING ELASTICA INDEXES ...
    echo ==============================
    ./app/console fos:elastica:reset
    echo
    echo CREATING DATABASE ...
    echo =====================
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
    echo
    echo LOADING FIXTURES ...
    echo ====================
    rm -f ./web/uploads/charities/*.jpg
    rm -f ./web/uploads/users/*.jpg
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
    echo
    echo CREATING ELASTICA INDEXES ...
    echo =============================
    ./app/console fos:elastica:populate
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
    ./node_modules/.bin/bower install -S bootstrap tinymce-dist
    ./node_modules/.bin/gulp
;;
4)
    echo
    echo RESETTING ELASTICA INDEXES ...
    echo ==============================
    ./app/console fos:elastica:reset
    echo
    echo RECREATING DATABASE ...
    echo =======================
    ./app/console doctrine:database:drop --force
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
    echo
    echo LOADING FIXTURES ...
    echo ====================
    rm -f ./web/uploads/charities/*.jpg
    rm -f ./web/uploads/users/*.jpg
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
    echo
    echo RECREATING ELASTICA INDEXES ...
    echo ===============================
    ./app/console fos:elastica:populate
;;
5)
    echo
    echo RESETTING ELASTICA INDEXES ...
    echo ==============================
    ./app/console fos:elastica:reset
    echo
    echo RECREATING DATABASE ...
    echo =======================
    ./app/console doctrine:database:drop --force
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
    echo
    echo LOADING FIXTURES ...
    echo ====================
    rm -f ./web/uploads/charities/*.jpg
    rm -f ./web/uploads/users/*.jpg
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
6)
    echo
    echo RECREATING DATABASE ...
    echo =======================
    ./app/console doctrine:database:drop --force
    ./app/console doctrine:database:create
    ./app/console doctrine:schema:update --force
;;
7)
    echo
    echo RESETTING ELASTICA INDEXES ...
    echo ==============================
    ./app/console fos:elastica:reset
    echo
    echo LOADING FIXTURES ...
    echo ====================
    rm -f ./web/uploads/charities/*.jpg
    rm -f ./web/uploads/users/*.jpg
    ./app/console hautelook_alice:doctrine:fixtures:load --no-interaction
;;
8)
    echo
    echo RECREATING ELASTICA INDEXES ...
    echo ===============================
    ./app/console fos:elastica:populate
;;
9)
    echo
    echo RUNING TESTS ...
    echo ================
    phpunit -c app
;;
10)
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
