#!/bin/bash
exists=`lsof -i | grep 9501 | awk '{print $2}'`
if [ ! -n "$exists" ]; then

php ./swoole/bin/hyperf.php start

else
`lsof -i | grep 9501 | awk '{print $2}'|xargs kill -9`
php ./swoole/bin/hyperf.php start

fi
#
