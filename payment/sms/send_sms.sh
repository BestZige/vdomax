#!/bin/sh

url="http://www.thaibulksms.com/sms_api.php"
username=$1
password=$2
msisdn=$3
force=$4
message=$5

echo "Send SMS"
curl -s "$url" -X "POST" -d "username=$username&password=$password&msisdn=$msisdn&force=$force&message=$message"



