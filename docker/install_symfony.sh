#!/bin/bash

set -eux
SYMFONY_ENV=$1
APP_ENV=$SYMFONY_ENV
composer install
