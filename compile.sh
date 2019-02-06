#!/usr/bin/env bash
tput setaf 2;
echo "Compiling..."
tput sgr0;
if [[ $1 == "" ]]; then
    npm run dev -- --env.full true
else
    npm run $1 -- --env.full true
fi