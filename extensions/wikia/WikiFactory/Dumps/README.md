Dumps
=====

This code handles wiki content XML dumps that can be requested via [Special:Statistics](http://muppet.wikia.com/wiki/Special:Statistics) on any wiki.

When a user clicks "Request a dump":
1. A row is insert into [`wikicities.dumps` table](https://github.com/Wikia/app/blob/6552cf1fbce8f37127f2743c2072b4d07f720244/maintenance/wikia/sql/wikicities-schema.sql#L289-L307)
1. `city_lastdump_timestamp` field is updated to the current timestamp for a given wiki in `wikicities.city_list` table.
1. `DumpsOnDemandTask.php` is queued with the given wiki id.
1. XML dumps (the full one and with current versions of articles only) are created locally and then uploaded to Amazon's S3 storage.

### Nagios check

We have a Nagios check that keeps track of a length of the queue of unprocessed dump requests. It issues the following query:

```sql
mysql>select count(distinct dump_wiki_id) as queue_size from dumps where dump_completed is null;
+------------+
| queue_size |
+------------+
|        670 |
+------------+
```

### Logs

The task script logs to Kibana, you can search by `@context.task_call:"Wikia\\Tasks\\Tasks\\DumpsOnDemandTask"`. Refer to it when Nagios check fails.
