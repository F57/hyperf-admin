#!/bin/bash
exists=`lsof -i | grep 9501 | awk '{print $2}'`
if [ ! -n "$exists" ]; then

php /www/wwwroot/blog.yuhelove.com/bin/hyperf.php start

else
`lsof -i | grep 9501 | awk '{print $2}'|xargs kill -9`
php /www/wwwroot/blog.yuhelove.com/bin/hyperf.php start

fi
#
