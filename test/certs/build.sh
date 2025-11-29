#!/bin/bash
domain='_.app.local'
rm $domain  -Rf
./minica --domains '*.app.local'


cp ./$domain/cert.pem ./$domain/fi.app.local.crt
cp ./$domain/cert.pem ./$domain/dk.app.local.crt
cp ./$domain/cert.pem ./$domain/de.app.local.crt
cp ./$domain/cert.pem ./$domain/es.app.local.crt
cp ./$domain/cert.pem ./$domain/th.app.local.crt
cp ./$domain/key.pem ./$domain/fi.app.local.key
cp ./$domain/key.pem ./$domain/dk.app.local.key
cp ./$domain/key.pem ./$domain/de.app.local.key
cp ./$domain/key.pem ./$domain/es.app.local.key
cp ./$domain/key.pem ./$domain/th.app.local.key

cp ./$domain/key.pem ../etc/nginx/conf.d/certs/
cp ./$domain/cert.pem ../etc/nginx/conf.d/certs/
chmod 755 ./$domain


domain2='app.local'
rm $domain2  -Rf
./minica --domains 'app.local'
cp ./$domain2/cert.pem ./$domain/app.local.crt
cp ./$domain2/key.pem ./$domain/app.local.key
cp ./$domain2/* ../etc/nginx/conf.d/certs/
chmod 755 ./$domain2

