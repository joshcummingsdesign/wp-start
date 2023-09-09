#!/usr/bin/env bash

set -e
trap "exit" INT
source scripts/includes/variables.sh
source scripts/includes/pull.sh

# Pull staging
pull staging

# Success
printf "\n${GREEN}Successfully pulled staging to local!${NC}\n\n"
