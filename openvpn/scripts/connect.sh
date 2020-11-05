#!/bin/bash
. /etc/openvpn/scripts/config.sh
. /etc/openvpn/scripts/functions.sh

name=$(echap "$common_name")

mysql -h$HOST -P$PORT -u$USER -p$PASS $DB -e "UPDATE users SET is_online = 1 WHERE email = '$name'"
