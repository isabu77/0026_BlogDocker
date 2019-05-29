#!/bin/bash

docker-compose build

docker-compose -f docker-compose.yml up -d

echo
echo "---------------------------------------"
echo " container démarré"
echo "---------------------------------------"
echo

exit 0
