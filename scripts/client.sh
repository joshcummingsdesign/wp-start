#!/usr/bin/env bash

npm run clean -- client
npm run generate:types
wp-scripts start --hot --config webpack.config.client.js
