fix-permissions-debian:
	find var vendor generated pub/static pub/media app/etc -type f -exec chmod g+w {} +
	find var vendor generated pub/static pub/media app/etc -type d -exec chmod g+ws {} +
	chown -R :www-data .
	chmod u+x bin/magento

fix-permissions-arch:
	find var vendor generated pub/static pub/media app/etc -type f -exec chmod g+w {} +
	find var vendor generated pub/static pub/media app/etc -type d -exec chmod g+ws {} +
	chown -R :http .
	chmod u+x bin/magento
	chmod -R 777 var/ generated/

cache_flush:
	php bin/magento cache:flush
	rm -rf var/log/* var/report/* var/view_preprocessed/* generated/* pub/static/*

### Debug
debug_magento: cache_flush
	touch var/log/debug.log var/log/exception.log var/log/system.log
	tail -f var/log/debug.log var/log/exception.log var/log/system.log

debug_nginx:
	sudo tail -f -n0 /var/log/nginx/error.log

get_last_report:
	cat var/report/* | jq

### System
upgrade:
	php bin/magento setup:upgrade

run_nginx:
	sudo systemctl stop apache2.service && sudo systemctl start nginx.service

run_apache:
	sudo systemctl stop nginx.service && sudo systemctl start apache2.service