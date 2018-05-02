Close
=====

This code generates backups and closes wikis marked to be closed via WikiFactory.

`/extensions/wikia/WikiFactory/Close/maintenance.php` script is run every day on `cron-s1`.

Logs can be found on `cron-s1` in ` /var/log/crons/closeMarkedWikis.log`.

### SQL query

```sql
mysql@geo-db-sharedb-slave.query.consul[wikicities]>select count(*) from city_list where city_public IN (0 /* close */, -1 /* hide */) and city_flags NOT IN (0, 32 /* redirect */) and city_dbname not like '%qatest%' and city_last_timestamp < now() - interval 30 day;
+----------+
| count(*) |
+----------+
|       80 |
+----------+
1 row in set (0.17 sec)
```

We add ~200 wikis each day to the queue of wikis to delete. The check above **ignores QA test wikis**.
