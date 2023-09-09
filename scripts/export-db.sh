#!/usr/bin/env bash

wp db export - | gzip -9 - > dbexport.sql.gz
