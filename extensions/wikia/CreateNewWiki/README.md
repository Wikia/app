CreateNewWiki
=============

This extension is responsible for creating and an initial setup of new wikis.

> **Documentation**: https://wikia-inc.atlassian.net/wiki/spaces/SUS/pages/34046150/CreateNewWiki

## Troubleshooting

We keep `wikicities.city_creation_log` table that can be used to track whether all wikis creations are completed.

```sql
mysql@geo-db-sharedb-slave.query.consul[wikicities]>select task_id, creation_started, exception_message from city_creation_log where completed = 0 order by log_id desc limit 2;
+-----------------------------------------+---------------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| task_id                                 | creation_started    | exception_message                                                                                                                                                            |
+-----------------------------------------+---------------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| mw-795DD279-EA36-4D2C-9FF0-0F3D68800B06 | 2019-03-01 00:34:10 | Thereâ€™s already a wiki with this address. Start editing at <a href="https://legendary-pokemon.fandom.com">legendary-pokemon.fandom.com</a> or choose another address.      |
| mw-D5EAABA1-E39A-48CC-B102-49E8CDA9356A | 2019-02-28 20:34:36 | Failed to pick a slave DB node from LoadBalancer config for                                                                                                                  |
+-----------------------------------------+---------------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
2 rows in set (0.00 sec)
```
