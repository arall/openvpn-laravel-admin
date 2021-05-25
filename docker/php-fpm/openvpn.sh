apt-get -y install openvpn wget iptables

wget "https://github.com/OpenVPN/easy-rsa/releases/download/v3.0.6/EasyRSA-unix-v3.0.6.tgz"
tar -xaf "EasyRSA-unix-v3.0.6.tgz"
mv "EasyRSA-v3.0.6" /etc/openvpn/easy-rsa
rm "EasyRSA-unix-v3.0.6.tgz"
cd /etc/openvpn/easy-rsa

# Init PKI dirs and build CA certs
./easyrsa init-pki
./easyrsa build-ca nopass
# Generate Diffie-Hellman parameters
./easyrsa gen-dh
# Generate server keypair
./easyrsa build-server-full server nopass

# Generate shared-secret for TLS Authentication
openvpn --genkey --secret pki/ta.key

# Copy certificates and the server configuration in the openvpn directory
cp /etc/openvpn/easy-rsa/pki/{ca.crt,ta.key,issued/server.crt,private/server.key,dh.pem} "/etc/openvpn/"
cp "/app/openvpn/server.conf" "/etc/openvpn/"
cp -r "/app/openvpn/scripts_remote" "/etc/openvpn/scripts"
chmod +x /etc/openvpn/scripts/*.sh
mkdir "/etc/openvpn/ccd"

# PHP Client building
mkdir /app/openvpn/clients/pki/
cp /etc/openvpn/easy-rsa/pki/{ca.crt,ta.key} "/app/openvpn/clients/pki/"
chown www-data:www-data /app/openvpn/clients/pki/*

# Make ip forwarding and make it persistent
echo 1 > "/proc/sys/net/ipv4/ip_forward"
echo "net.ipv4.ip_forward = 1" >> "/etc/sysctl.conf"

# Iptables rules
iptables -A FORWARD -i tun+ -j ACCEPT
iptables -A FORWARD -i tun+ -o eth0 -m state --state RELATED,ESTABLISHED -j ACCEPT
iptables -A FORWARD -i eth0 -o tun+ -m state --state RELATED,ESTABLISHED -j ACCEPT
iptables -t nat -A POSTROUTING -s 10.8.0.0/24 -o eth0 -j MASQUERADE