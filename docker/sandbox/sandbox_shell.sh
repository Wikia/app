#!/bin/bash
SANDBOX=$1
CONTAINER=`kubectl --context kube-sjc-prod -n prod get pods --selector=app=mediawiki-$1  -o jsonpath='{.items[0].metadata.name}'`

echo
echo "Entering bash shell on ${CONTAINER} ..."
echo "To enter MediaWiki console type: SERVER_ID=177 php maintenance/eval.php -d 5"
echo

kubectl --context kube-sjc-prod -n prod exec --container php -it $CONTAINER bash
