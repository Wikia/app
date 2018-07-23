Docker
======

This file describes how to run Wikia's MediaWiki app using Docker container.

## How to run Wikia app Docker container

We assume that you have `app` and `config` repository cloned in the same directory and that you have an empty `cache` directory at the same level (it will be used to store localisation cache).

```sh
# 1. build a base image
docker build -f base/Dockerfile -t artifactory.wikia-inc.com/sus/php-wikia-base:27f50ce ./base

# 2. and then dev image
docker build -f dev/Dockerfile -t php-wikia-dev ./dev

# 3. you can now run eval.php (execute this from root directory of app repo clone)
docker run -it --rm -h localhost -e 'SERVER_ID=165' -e 'WIKIA_ENVIRONMENT=dev' -e 'WIKIA_DATACENTER=poz' -v "$PWD":/usr/wikia/slot1/current/src -v "$PWD/../config":/usr/wikia/slot1/current/config -v "$PWD/../cache":/usr/wikia/slot1/current/cache/messages artifactory.wikia-inc.com/sus/php-wikia-dev php maintenance/eval.php

# 4. in order to run service locally use docker-compose
docker-compose -f ./dev/docker-compose.yml up

# 5. then you can use `docker exec` to take a look inside the container
docker exec -it dev_php-wikia_1 bash
```

### Resolving domains

In order to run service locally you need to configure hosts. Add below line to `/etc/hosts`

```
127.0.0.1	wikia-local.com dev.wikia-local.com muppet.dev.wikia-local.com
```

## How to push base and dev images to Wikia's repository

```sh
docker tag php-wikia-base php-wikia-base:7.0.28

docker tag php-wikia-base artifactory.wikia-inc.com/sus/php-wikia-base
docker tag php-wikia-base artifactory.wikia-inc.com/sus/php-wikia-base:7.0.28

docker push artifactory.wikia-inc.com/sus/php-wikia-base
docker push artifactory.wikia-inc.com/sus/php-wikia-base:7.0.28


docker tag php-wikia-dev php-wikia-dev:7.0.28

docker tag php-wikia-dev artifactory.wikia-inc.com/sus/php-wikia-dev
docker tag php-wikia-dev artifactory.wikia-inc.com/sus/php-wikia-dev:7.0.28

docker push artifactory.wikia-inc.com/sus/php-wikia-dev
docker push artifactory.wikia-inc.com/sus/php-wikia-dev:7.0.28
```

## How to set up Docker on your machine

> https://docs.docker.com/install/

## Troubleshooting

### Permissions

To run unit tests set up the `app/tests/build` directory to be owned by `nobody:nogroup`.

To rebuild localisation cache you need to have `cache` directory created at the same level as `app` and `config` git clones.
`cache` directory should have `777` rights set up and have an empty file touched there.

### Localisation cache

If localisation cache is missing, regenerate it by running `SERVER_ID=177 php maintenance/rebuildLocalisationCache.php` within the container

### DNS issues

If you have problems with DNS host names resolution in your Docker container, you need to [disable `dnsmasq` on your machine](https://askubuntu.com/questions/320921/having-dns-issues-when-connected-to-a-vpn-in-ubuntu-13-04).

### Docker service fails

If docker service fails to start run the following to diagnose the problem:

```sh
sudo dockerd
```

#### Setting up `kubectl`

Follow [these instructions](https://wikia-inc.atlassian.net/wiki/spaces/OPS/pages/208011308/Kubernetes+access+for+Engineers).

## Development Notes

### Cronjobs Migration

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

#### close-my-account.yaml

`extensions/wikia/CloseMyAccount/maintenance/CloseMyAccountMaintenance.php`

Actually closes accounts scheduled to be closed.

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

`extensions/wikia/FounderEmails/maintenance.php`

Sends informative emails about views, edits, etc. to founders of wikis; completeDigest.

#### founder-emails-days-passed.yaml

`extensions/wikia/FounderEmails/maintenance.php`

Sends informative emails to founders of wikis after a number of days of their inactivity.

#### founder-emails-views-digest.yaml

`extensions/wikia/FounderEmails/maintenance.php`

Sends informative emails about views to founders of wikis.

#### init-stat.yaml

`maintenance/initStats.php`

Reinitialise or update wiki's statistics tables.

#### load-exit-nodes.yaml

`extensions/TorBlock/loadExitNodes.php`

Update the list Tor exit nodes.

#### lyricwiki-crawler.yaml

`extensions/3rdparty/LyricWiki/maintenance/LyricsWikiCrawler.php`

Crawls through LyricWiki, pulls data from its articles and puts it to Solr.

#### phalanx-migrate-user-blocks.yaml

`extensions/wikia/PhalanxII/maintenance/MigratePhalanxUserBlocks.php`

Closes accounts permanently blocked in Phalanx.

#### phrase-alerts.yaml

`maintenance/wikia/phrase-alerts.php`

Scans users' activity for certain suspicious phrases and alerts ComSup.

#### remove-qa-wikis.yaml

`maintenance/wikia/removeQAWikis.php`

Marks wikis created by automated tests for closing.

#### reset-weekly-user-contributions-count.yaml

`maintenance/wikia/cronjobs/resetWeeklyUserContributionsCount.php`

Reset weekly user rank on Special:Community.

#### send-confirmation-reminder.yaml

`extensions/wikia/AuthPages/maintenance/sendConfirmationReminder.php`

Sends emails to users to remind them to authenticate / confirm their users.

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
