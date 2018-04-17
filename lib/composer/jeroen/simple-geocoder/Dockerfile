FROM php:7.1-cli

RUN \
	apt-get update && \
	# for intl
	apt-get install -y libicu-dev && \
	docker-php-ext-install -j$(nproc) intl
