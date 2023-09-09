#!/usr/bin/env bash

source scripts/includes/variables.sh

# Check for version number argument
if [[ -z $1 ]]; then
    printf "${RED}Version number required${NC}\n\n"
    exit $INVALID_ARGUMENT_ERROR
fi

# Run since-unreleased on theme
./vendor/bin/since-unreleased.sh wp-content/themes/$THEME_SLUG/ $1

# Success
printf "\n${GREEN}Successfully updated version tags!${NC}\n\n"
