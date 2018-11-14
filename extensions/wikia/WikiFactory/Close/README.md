Close
=====

This code generates backups and closes wikis marked to be closed via WikiFactory. `/extensions/wikia/WikiFactory/Close/maintenance.php` script is run every day.

### SQL query

```sql
mysql@geo-db-sharedb-slave.query.consul[wikicities]>select count(*) from city_list where city_public IN (0 /* close */, -1 /* hide */) and city_flags NOT IN (0, 32 /* redirect */, 512 /* do not close */) and city_dbname not like '%qatest%' and city_last_timestamp < now() - interval 30 day;
+----------+
| count(*) |
+----------+
|       80 |
+----------+
1 row in set (0.17 sec)

--

mysql@geo-db-sharedb-slave.query.consul[wikicities]>select count(*), city_additional from city_list where city_public IN (0 /* close */, -1 /* hide */) and city_flags NOT IN (0, 32 /* redirect */, 512 /* do not close */) and city_last_timestamp < now() - interval 31 day group by 2 order by 1 desc;
+----------+------------------------------------------------------------------------------------------------------------------------+
| count(*) | city_additional                                                                                                        |
+----------+------------------------------------------------------------------------------------------------------------------------+
|     1057 | Marked for removal by RemoveQAWikis maintenance script                                                                 
|      739 | dead wiki                                                                                                              |
|        4 | -                                                                                                                      |
|        2 | Fetish wiki                                                                                                            |
|        1 | zd#415043                                                                                                              |
|        1 | Marked in Spam wiki review tool as SPAM by user: 36838069                                                             |
|        1 | https://wikia.zendesk.com/agent/tickets/414900                                                                         |
...
```

We add ~200 wikis each day to the queue of wikis to delete. The check above **ignores QA test wikis**.
