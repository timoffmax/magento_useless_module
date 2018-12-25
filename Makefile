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
	rm -rf var/log/* var/report/* var/view_preprocessed/* generated/* pub/static/*
	php bin/magento cache:flush

###########
### API ###
###########
api_get_token:
	$(eval TOKEN := `curl -X POST "http://magento.local/rest/V1/integration/admin/token" -H "Content-Type: application/json" -d '{"username":"${USERNAME}","password": "${PASSWORD}"}' | tr -d '"'`)
	@echo ${TOKEN}

## Test products ##
api_product_get_test:
	curl http://magento.local/rest/V1/timoffmax_useless/product/${ID} -H "Authorization: Bearer ${TOKEN}"

api_product_get_list_test:
	curl http://magento.local/rest/V1/timoffmax_useless/product?searchCriteria=${SEARCH_CRITERIA} -H "Authorization: Bearer ${TOKEN}"

api_product_get_by_product_id_test:
	curl http://magento.local/rest/V1/timoffmax_useless/product/${PRODUCT_ID}/byProductId -H "Authorization: Bearer ${TOKEN}"

api_product_create_test:
	curl -X POST "http://magento.local/rest/V1/timoffmax_useless/product" \
	-H "Authorization: Bearer ${TOKEN}" \
	-H "Content-Type: application/json" \
	-d '{"product": {"product_id":"${PRODUCT_ID}", "price":"111.11"}}' \
	-b XDEBUG_SESSION=PHPSTORM

api_product_update_test:
	curl -X PUT "http://magento.local/rest/V1/timoffmax_useless/product" \
	-H "Authorization: Bearer ${TOKEN}" \
	-H "Content-Type: application/json" \
	-d '{"product": {"id":"${ID}", "product_id":"${PRODUCT_ID}", "price":"222.22"}}' \
	-b XDEBUG_SESSION=PHPSTORM

api_product_delete_test:
	curl -i -X DELETE http://magento.local/rest/V1/timoffmax_useless/product/${ID} -H "Authorization: Bearer ${TOKEN}" -H "Accept: application/json" \
	-b XDEBUG_SESSION=PHPSTORM

api_product_delete_by_product_id_test:
	curl -i -X DELETE http://magento.local/rest/V1/timoffmax_useless/product/${PRODUCT_ID}/byProductId -H "Authorization: Bearer ${TOKEN}" -H "Accept: application/json" \
	-b XDEBUG_SESSION=PHPSTORM

## Test orders ##
api_order_get_test:
	curl http://magento.local/rest/V1/timoffmax_useless/order/${ID} -H "Authorization: Bearer ${TOKEN}"

api_order_get_list_test:
	curl http://magento.local/rest/V1/timoffmax_useless/order?searchCriteria=${SEARCH_CRITERIA} -H "Authorization: Bearer ${TOKEN}"

api_order_get_by_order_id_test:
	curl http://magento.local/rest/V1/timoffmax_useless/order/${ORDER_ID}/byOrderId -H "Authorization: Bearer ${TOKEN}"

api_order_create_test:
	curl -X POST "http://magento.local/rest/V1/timoffmax_useless/order" \
	-H "Authorization: Bearer ${TOKEN}" \
	-H "Content-Type: application/json" \
		-d '{"order": {"order_id":"${ORDER_ID}", "total":"111.11"}}' \
	-b XDEBUG_SESSION=PHPSTORM

api_order_update_test:
	curl -X PUT "http://magento.local/rest/V1/timoffmax_useless/order" \
	-H "Authorization: Bearer ${TOKEN}" \
	-H "Content-Type: application/json" \
	-d '{"order": {"id":"${ID}", "order_id":"${ORDER_ID}", "total":"222.22"}}' \
	-b XDEBUG_SESSION=PHPSTORM

api_order_delete_test:
	curl -i -X DELETE http://magento.local/rest/V1/timoffmax_useless/order/${ID} -H "Authorization: Bearer ${TOKEN}" -H "Accept: application/json" \
	-b XDEBUG_SESSION=PHPSTORM

api_order_delete_by_order_id_test:
	curl -i -X DELETE http://magento.local/rest/V1/timoffmax_useless/order/${ORDER_ID}/byOrderId -H "Authorization: Bearer ${TOKEN}" -H "Accept: application/json" \
	-b XDEBUG_SESSION=PHPSTORM

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