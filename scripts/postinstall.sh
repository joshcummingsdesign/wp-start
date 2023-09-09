#!/usr/bin/env bash

source scripts/includes/variables.sh

if [[ $CI != true ]]; then
    lando install-node
    lando composer install
    lando composer install -d wp-content/themes/$THEME_SLUG
fi
