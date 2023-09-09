#!/usr/bin/env bash

npm run clean -- server
wp-scripts start --config webpack.config.server.js
