#!/bin/bash

curl -X POST -H "Authorization: Bearer UZ4POfwGCFuG8PWHusPO" --data "user=$common_name&remote_ip=$ifconfig_pool_remote_ip&bytes_received=$bytes_received&bytes_sent=$bytes_sent" "http://vpn.local/api/disconnect"  2>/dev/null