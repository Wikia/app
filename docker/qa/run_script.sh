#!/bin/bash
cd rebuild
python ./bin/recreate_wiki.py --env=sjc  --debug --vault-address=https://active.vault.service.sjc.consul:8200 --vault-token=$VAULT_TOKEN --city-dbname=szlmercurycc --app-base-path='../app'
python bin/clear_fastly_cache.py --env=sjc --vault-address=https://active.vault.service.sjc.consul:8200 --vault-token=$VAULT_TOKEN --app-base-path='../app'