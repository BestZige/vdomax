#!/bin/sh

url="http://www.thaibulksms.com/sms_api.php"
username=$1
password=$2
tag=$3

echo "Check Credit"
curl -s "$url" -X "POST" -d "username=$username&password=$password&tag=$tag"


