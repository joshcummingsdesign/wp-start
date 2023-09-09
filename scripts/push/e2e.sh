#!/usr/bin/env bash

set -e
trap "exit" INT
source scripts/includes/variables.sh
source scripts/includes/push.sh

# Push e2e
push e2e
