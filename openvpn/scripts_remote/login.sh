#!/bin/bash

result=$(curl -X POST -H "Authorization: Bearer TOKEN" --data "user=$username&password=$password" "http://vpn.local/api/login" 2>/dev/null)

if [ "$result" == "ok" ]; then
  echo "$username: authentication ok."
  exit 0
else
  echo "$username: authentication failed."
  exit 1
fi