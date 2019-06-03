#!/usr/bin/env sh
set -e

CONSOLE=$(/usr/bin/find /var/www/bin -name console)

#if [ -f ${ARTISAN} ]; then
#    echo "doctrine:clear:metadata:cache"
#    /usr/local/bin/php ${CONSOLE} doctrine:clear:metadata:cache
#    echo "doctrine:clear:result:cache"
#    /usr/local/bin/php ${CONSOLE} doctrine:clear:result:cache
#    echo "doctrine:clear:query:cache"
#    /usr/local/bin/php ${CONSOLE} doctrine:clear:query:cache
#    echo "doctrine:generate:proxies"
#    /usr/local/bin/php ${CONSOLE} doctrine:generate:proxies
#fi

exec "$@"