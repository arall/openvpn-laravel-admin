#!/bin/bash
. /etc/openvpn/scripts/config.sh
. /etc/openvpn/scripts/functions.sh

name=$(echap "$common_name")

mysql -h$HOST -P$PORT -u$USER -p$PASS $DB -e "UPDATE users SET is_online = 0 WHERE email = '$name'"

php /path/to/artisan openvpn:connect $common_name $trusted_ip $trusted_port $ifconfig_local $ifconfig_pool_remote_ip $remote_port_1 $bytes_received $bytes_sent