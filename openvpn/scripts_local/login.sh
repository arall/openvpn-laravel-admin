#!/bin/bash

result=$(php /path/to/artisan openvpn:login "$username" "$password")

if [ "$result" == "ok" ]; then
  echo "$username: authentication ok."
  exit 0
else
  echo "$username: authentication failed."
  exit 1
fi