Maintenance
===========

This directory contains definition of all maintenance scripts that should be run periodically.
Before the migration to Kubernetes these were run via `crontab` on `cron-s1`.

### Generating YAML files

To generate YAML for one cron job:

```sh
./create-cronjob-yaml.sh one-time-job-example.yaml
```

In YAML describing a cron job there are two required fields: schedule and args
Optionally you can pass server_id
Name of cronjob is derived from a file name with a 'mediawiki-' prefix

e.g.
```yaml
schedule: "35 20 * * *" # required
server_id: 3434 # optional, default: 177
args: # required
- php
- path/to/maintenance.php
- --param=1

```

To generate YAML for ALL cron jobs (except ones from 'examples' directory):

```sh
./cronjobs-generator.sh
```


### Applying YAML files

> [Set up `kubectl`](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/401440847/Kubernetes+access+for+Engineers)

In order to apply descriptor you need to map directory with YAML files to kubectl container.

Like so:

```sh
bash create-cronjob-yaml.sh one-time-job-example.yaml <prod image label> | kubectl --context kube-sjc-prod -n prod apply -f -
```

Or when running `kubectl` as a binary (run from app directory root):

```sh
./maintenance/create-cronjob-yaml.sh one-time-job-example.yaml | kubectl --context kube-sjc-prod -n prod apply -f -
```

To apply all jobs defined run
```sh
./maintenance/cronjobs-generator.sh | kubectl --context kube-sjc-prod -n prod apply -f -
```

### Current list of cronjobs

To check what cronjobs are currently scheduled:

```sh
kubectl --context kube-sjc-prod -n prod get cronJobs | grep mw-cj
```

### Development Notes on Cronjobs Migration

#### cleanup-notifications-queue.yaml

`extensions/wikia/WallNotifications/maintenance/cleanupNotificationsQueue.php`

Removes old entries from dataware.wall_notification_queue* tables

#### cleanup-phalanx-stats.yaml

`extensions/wikia/PhalanxII/maintenance/cleanupPhalanxStats.php`

Removes specials.phalanx_stats entries older than 365 days.

#### cleanup-upload-stash.yaml

`maintenance/cleanupUploadStash.php`

Removes old or broken uploads from temporary uploaded file storage and cleans up associated database records.

#### cleanup-wall-notifications.yaml

`extensions/wikia/WallNotifications/maintenance/cleanupWallNotifications.php`

Removes dataware.wall_notification entries older than X days.

#### cleanup-wikia-shared-talk.yaml

`extensions/wikia/WikiaNewtalk/maintenance/cleanupWikiaSharedTalk.php`

Removes wikicities.shared_newtalks entries older than 90 days.

#### delete-articles-by-prefix-blogs.yaml

`maintenance/wikia/deleteArticlesByPrefix.php`

Deletes articles from a wiki matching prefix QATestsUser/blogPost from namespace 500 (NS_BLOG_ARTICLE).

#### delete-articles-by-prefix-boards.yaml

`maintenance/wikia/deleteArticlesByPrefix.php`

Deletes articles from a wiki matching prefix QABoard from namespace 2000 (NS_WIKIA_FORUM_BOARD).

#### delete-articles-by-prefix-forum.yaml

`maintenance/wikia/deleteArticlesByPrefix.php`

Deletes articles from a wiki matching prefix ForumBoard from namespace 2000 (NS_WIKIA_FORUM_BOARD).

#### delete-articles-by-prefix.yaml

`maintenance/wikia/deleteArticlesByPrefix.php`

Deletes articles from a wiki matching prefix QAarticle from namespace 0 (NS_MAIN).

#### dumps-on-demand.yaml

`extensions/wikia/WikiFactory/Dumps/maintenance/DumpsOnDemandCron.php`

Creates XML dumps of wikis requested via Special:Statistics.

#### dump-starters.yaml

`extensions/wikia/CreateNewWiki/maintenance/dumpStarters.php`

Prepares XML and SQL dumps with the latest revisions and `*links` tables rows of starter wikis.

#### example-maintenance-cronjob.yaml

`maintenance/updateSpecialPages.php`

Updates various special pages that display aggregated data or reports.

#### example-one-time-job.yaml

`maintenance/updateSpecialPages.php`

Updates various special pages that display aggregated data or reports.

#### find-outdated-video-providers.yaml

`extensions/wikia/VideoHandlers/maintenance/findOutdatedVideoProviders.php`

Search for outdated video providers and report occurrences to ELK and JIRA.

#### founder-emails-complete-digest.yaml

`extensions/wikia/FounderEmails/FounderEmailsMaintenance.php`

Sends informative emails about views, edits, etc. to founders of wikis; completeDigest.

#### founder-emails-days-passed.yaml

`extensions/wikia/FounderEmails/FounderEmailsMaintenance.php`

Sends informative emails to founders of wikis after a number of days of their inactivity.

#### founder-emails-views-digest.yaml

`extensions/wikia/FounderEmails/FounderEmailsMaintenance.php`

Sends informative emails about views to founders of wikis.

#### init-stat.yaml

`maintenance/initStats.php`

Reinitialise or update wiki's statistics tables.

#### lyricwiki-crawler.yaml

`extensions/3rdparty/LyricWiki/maintenance/LyricsWikiCrawler.php`

Crawls through LyricWiki, pulls data from its articles and puts it to Solr.

#### phrase-alerts.yaml

`maintenance/wikia/phrase-alerts.php`

Scans users' activity for certain suspicious phrases and alerts ComSup.

#### remove-qa-wikis.yaml

`maintenance/wikia/removeQAWikis.php`

Marks wikis created by automated tests for closing.

#### reset-weekly-user-contributions-count.yaml

`maintenance/wikia/cronjobs/resetWeeklyUserContributionsCount.php`

#### runescape-price-update-bot.yaml

`maintenance/runescape-price-update-bot.yaml`

Updates prices of items on runescape and oldschoolrunescape wikis using data from Jagex API

Reset weekly user rank on Special:Community.

#### send-confirmation-reminder.yaml

`extensions/wikia/AuthPages/maintenance/sendConfirmationReminder.php`

Sends emails to users to remind them to authenticate / confirm their users.

#### send-weekly-digest.yaml

`maintenance/wikia/cronjobs/sendWeeklyDigest.php`

This script sends the weekly digest to the users found in the global_watchlist table found in the dataware database.

#### site-wide-messages-maintenance.yaml

`maintenance/wikia/SiteWideMessagesMaintenance.php`

Removes expired SiteWideMessages from MySQL.

#### SMW-conceptCache.yaml

`extensions/wikia/SemanticMediaWiki/maintenance/rebuildConceptCache.php`

Warms up semantic query cache for SemanticMediaWiki's Concept pages.

#### update-special-pages.yaml

`maintenance/updateSpecialPages.php`

Updates various special pages that display aggregated data or reports.

#### wiki-factory-close-marked-wikis.yaml

`extensions/wikia/WikiFactory/Close/maintenance.php`

Closed wikis marked for closing.

#### wiki-factory-dead-wikis.yaml

`extensions/wikia/WikiFactory/DeadWikis/maintenance.php`

Scans through the communities for wikis meeting criteria of "dead wikis", sends reports to ComSup and removes dead wikis after a period of quarantine.
