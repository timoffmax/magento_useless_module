fix-permissions:
	find var vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
	find var vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
	chown -R :www-data .
	chmod u+x bin/magento

cache_flush:
	php7.2 bin/magento cache:flush

debug:
	cat

upgrade:
	php7.2 bin/magento setup:upgrade

run_nginx:
	sudo systemctl stop apache2.service && sudo systemctl start nginx.service

run_apache:
	sudo systemctl stop nginx.service && sudo systemctl start apache2.service