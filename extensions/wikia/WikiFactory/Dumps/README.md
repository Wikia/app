Dumps
=====

This code handles wiki content XML dumps that can be requested via [Special:Statistics](http://muppet.wikia.com/wiki/Special:Statistics) on any wiki.

When a user clicks "Request a dump":
1. A row is insert into [`wikicities.dumps` table](https://github.com/Wikia/app/blob/6552cf1fbce8f37127f2743c2072b4d07f720244/maintenance/wikia/sql/wikicities-schema.sql#L289-L307)
1. `city_lastdump_timestamp` field is updated to the current timestamp for a given wiki in `wikicities.city_list` table.
1. `DumpsOnDemandTask.php` is queued with the given wiki id.
1. XML dumps (the full one and with current versions of articles only) are created locally and then uploaded to Amazon's S3 storage.

### Nagios check

We have Nagios checks that keep track of a length of the queue of pending and failed dump requests. They issue the following queries:

```sql
-- pending dump requests (i.e. to be processed)
mysql>SELECT COUNT(distinct dump_wiki_id) AS queue_size FROM dumps WHERE dump_completed IS NULL AND dump_hold = 'N'
+------------+
| queue_size |
+------------+
|        670 |
+------------+

-- failed dump requests
mysql>SELECT COUNT(distinct dump_wiki_id) AS queue_size FROM dumps WHERE dump_completed IS NULL AND dump_hold = 'Y'
+------------+
| queue_size |
+------------+
|          5 |
+------------+
```

### Logs

The task script logs to Kibana, you can search by `@context.task_call:"Wikia\\Tasks\\Tasks\\DumpsOnDemandTask"`. Refer to it when Nagios check fails.


### SQL queries


```sql
DumpsOnDemand::getLatestDumpInfo 99.73% [ap] db:wikicities | SELECT dump_completed,dump_compression FROM `dumps` WHERE (dump_completed IS NOT NULL) AND dump_wiki_id = X ORDER BY dump_completed DESC LIMIT N
Wikia\Tasks\Tasks\DumpsOnDemandTask::dump 0.04% [cron] db:wikicities | UPDATE `dumps` SET dump_compression = X,dump_hold = X,dump_errors = X WHERE dump_wiki_id = X AND (dump_completed IS NULL) AND dump_hold = X
Wikia\Tasks\Tasks\DumpsOnDemandTask::dump 0.05% [task] db:wikicities | SELECT dump_hold FROM `dumps` WHERE dump_wiki_id = X ORDER BY dump_requested DESC LIMIT N
DumpsOnDemand::queueDump 0.07% [ap] db:wikicities | INSERT INTO `dumps` (dump_wiki_id,dump_user_id,dump_requested,dump_closed) VALUES (XYZ)
```
