#!/bin/bash
. /etc/openvpn/scripts/config.sh
. /etc/openvpn/scripts/functions.sh

username=$(echap "$username")
password=$(echap "$password")

# Authentication
user_pass=$(mysql -h$HOST -P$PORT -u$USER -p$PASS $DB -sN -e "SELECT password FROM users WHERE email = '$username'")

# Check the user
if [ "$user_pass" == '' ]; then
  echo "$username: bad account."
  exit 1
fi

result=$(php -r "if(password_verify('$password', '$user_pass') == true) { echo 'ok'; } else { echo 'ko'; }")

if [ "$result" == "ok" ]; then
  echo "$username: authentication ok."
  exit 0
else
  echo "$username: authentication failed."
  exit 1
fi