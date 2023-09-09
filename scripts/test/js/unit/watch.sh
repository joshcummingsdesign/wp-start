#!/usr/bin/env bash

set -e
trap "exit" INT

npx wp-scripts test-e2e --watch
