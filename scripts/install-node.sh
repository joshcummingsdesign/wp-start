#!/usr/bin/env bash

touch ~/.bashrc
source ~/.bashrc

CURRENT=none

if command -v nvm &> /dev/null
then
    CURRENT=$(nvm current)
fi

EXPECTED=$(cat .nvmrc)

if [ $CURRENT != "v$EXPECTED" ]; then
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
    source ~/.bashrc
    nvm install
    nvm alias default $EXPECTED
fi
