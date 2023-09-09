#!/usr/bin/env bash

source scripts/includes/variables.sh

if [[ $1 == 'client' ]]; then
    DIR=/client
elif [[ $1 == 'server' ]]; then
    DIR=/server
fi

rm -rf wp-content/themes/$THEME_SLUG/build$DIR
