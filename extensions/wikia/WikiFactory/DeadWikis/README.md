DeadWikis
=========

This script is used to automate the process of closing small and inactive wikis.

## Rules

The list of rules that are used to mark wikis for closure can be found in `maintenance.php` script in `AutomatedDeadWikisDeletionMaintenance::$conditions`.

* `created`: wiki must be older than 182 days
* `lastedited`: last edit performed in NS_MAIN took place more than 60 days ago
* `edits`: the were at most 10 edits performed in NS_MAIN during the entire history of a wiki
* `contentpages`: the are at most 4 content pages (i.e. non-redirects in NS_MAIN)
* `pvlast3month`: the wikis received at most 39 page views in the last three months

All rules needs to be meet in order to mark a wiki for deletion. The deletion itself is handled by []`Close/maintenance.php` script](https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiFactory/Close).

## How it's run?

The script is run every day from Monday to Thursday on `cron-s1` and logs to `/var/log/crons/dead_wikis.log`.

```
cookbooks/cron/recipes/wiki_maintenance.rb
64-cron "dead_wikis_deletion" do
65-  user 'release'
66-  minute "30"
67-  hour "19"
68-  weekday "1,2,3,4"
69:  command "/usr/wikia/backend/bin/run_maintenance --id=177 /usr/bin/php --script='../extensions/wikia/WikiFactory/DeadWikis/maintenance.php --debug' > /var/log/crons/dead_wikis.log 2>&1"
70-end
```

The script sends an email to `wikis-deleted-l@wikia-inc.com` with the list of wikis marked for deletion and of those that are likely to be marked in the future.
