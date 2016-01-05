#Purpose the extension
We need to synchronize ExactTarget with fresh data about our users. Hence there's ExactTargetUpdates extension in our codebase. It sends pushes updates to ExactTarget external database via it's API.

#What's ExactTarget?
[ExactTarget](http://www.exacttarget.com/) is external mailing tool - a platform for sending marketing emails to users.

##Important data to sync
[User data](hooks/ExactTargetUser.hooks.php):
* email
* username
* language preference
* marketingallowed preference
* unsubscribed preference

Also we send updates with [list of wikias](hooks/ExactTargetWiki.hooks.php), [mapping of categories](tasks/ExactTargetUpdateCityCatMappingTask.php) and [number of user edits on wikias](maintenance/ExactTargetUpdateUserEditsPerWikiMaintenance.php)

##Updates flow
1. [event on Wikia platform](hooks/ExactTargetSetup.hooks.php)
2. data preparation - job task queue
3. API update request

##Learn more about ExactTarget API
* General guide: http://help.exacttarget.com/en-US/technical_library/web_service_guide/
* Connecting Your Dev Environment: http://help.exacttarget.com/en/technical_library/web_service_guide/getting_started_developers_and_the_exacttarget_api/
* Code Samples: http://help.exacttarget.com/en-US/technical_library/web_service_guide/technical_articles/
* API Starter Kits: http://help.exacttarget.com/en-US/technical_library/web_service_guide/api_starter_kits/
[SDKs on Github](https://github.com/salesforce-marketingcloud) (e.g. [FuelSDK-PHP](https://github.com/salesforce-marketingcloud/FuelSDK-PHP))
