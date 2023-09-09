#!/usr/bin/env bash

set -e
trap "exit" INT
source scripts/includes/variables.sh
source scripts/includes/test_php.sh

test_php integration
