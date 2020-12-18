#!/bin/bash

curl -X POST -H "Authorization: Bearer TOKEN" --data "user=$common_name&client_ip=$trusted_ip&client_port=$trusted_port&remote_ip=$ifconfig_pool_remote_ip&remote_port=$remote_port_1&bytes_received=$bytes_received&bytes_sent=$bytes_sent" "http://vpn.local/api/connect"  2>/dev/null