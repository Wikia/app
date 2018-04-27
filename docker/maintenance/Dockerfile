# This is a Docker image for  Wikia's MediaWiki app that can be used locally by a developer.
# Simply mount your app and config repositories clone (refer to README.md)
FROM php-wikia-base

# install maintenance scripts dependencies
RUN apt-get update
RUN apt-get install mysql-client -y

# set environment variables
ENV WIKIA_DATACENTER=sjc
ENV WIKIA_ENVIRONMENT=prod

# we no longer need root's super-power
USER nobody
