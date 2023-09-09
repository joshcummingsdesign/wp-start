#!/usr/bin/env bash

set -e
trap "exit" INT
source scripts/includes/variables.sh
source scripts/includes/push.sh

# Push staging
push staging
