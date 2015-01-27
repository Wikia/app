# Global Watchlist

The global watchlist is used to send out a weekly digest of changes to pages a user is watching across all of wikia.
The general architecture is when a change is made on a watched page, the watchlist table is updated on that wiki. Following
that, a hook inside of GlobalWatchlist.hooks.php fires off which sends a message via scribe. There are 3 possible messages
which get sent:

* addGlobalWatchlist
```
	{"method":"addWatch","params":{"wl_user":5654074,"wl_namespace":0,"wl_title":"NewPage","wl_notificationtimestamp":null,"wl_wikia":"435087","wl_revision":53613,"wl_rev_timestamp":"20150122013007"}}
	{"method":"addWatch","params":{"wl_user":5654074,"wl_namespace":1,"wl_title":"NewPage","wl_notificationtimestamp":null,"wl_wikia":"435087","wl_revision":53613,"wl_rev_timestamp":"20150122013007"}}
```
	* This is sent when a user first makes an edit to the page and starts watching it.
	Is this even used?
* removeGlobalWatch
```
	{"method":"removeWatch","params":{"wl_user":5654074,"wl_namespace":0,"wl_title":"Gallery","wl_wikia":"435087"}}
    {"method":"removeWatch","params":{"wl_user":5654074,"wl_namespace":1,"wl_title":"Gallery","wl_wikia":"435087"}}
    delete from global_watchlist where gwa_city_id = 435087 and gwa_namespace = 0 and gwa_title = "Gallery" and gwa_user_id = 565407
```
* updateGlobalWatch
```
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":null,"wl_revision":53612,"wl_rev_timestamp":"20150120224112"},"where":{"wl_title":"Gallery","wl_namespace":0,"wl_user":5654074},"wl_wikia":"435087"}}
```

## Local Watchlist
When a user edits a page, they automatically started watching it. 2 entires are added into the watchlist table for them for that page.
The table looks like this:

	+----------+--------------+-----------+--------------------------+-------------------------+
	| wl_user  | wl_namespace | wl_title  | wl_notificationtimestamp | wl_wikia_addedtimestamp |
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910443 |            1 | Watchlist | NULL                     |  2015-01-20 23:19:21    |
	+----------+--------------+-----------+--------------------------+-------------------------+


If the user visits the page, or is the last person to edit it, their wl_notificationtimestamp is set to NULL. If someone else edits
the page, that user receives an email alerting them that the page has changed. The wl_notificationtimestamp is then updated to reflect
the timestamp when that user was sent the email. If subsequent edits are made, that user is not notified via email until wl_notificationtimestamp
is NULL (ie, they visit the page).

Following an edit to this local watchlist table, a hook is fired inside of GlobalWatchlist hooks. There are 3 hooks:

# Global Watchlisters:
	## Get the users to send the digest to:
		SELECT  distinct gwa_user_id  FROM `global_watchlist`  WHERE (gwa_user_id > 0) AND (gwa_timestamp is not null)  ORDER BY gwa_user_id LIMIT 10
	## Get notifications to send to user:
		SELECT gwa_id,gwa_user_id,gwa_city_id,gwa_namespace,gwa_title,gwa_rev_id,gwa_timestamp  FROM `global_watchlist`  WHERE gwa_user_id = '<userId>' AND (gwa_timestamp <= gwa_rev_timestamp) AND (gwa_timestamp is not null)  ORDER BY gwa_timestamp, gwa_city_id;

+----------+--------------+
| user_id  | user_name    |
+----------+--------------+
| 24055122 | Jsutterfield |
| 26033468 | Jbutterfield |
| 26033488 | JCutterfield |
+----------+--------------+

Adding a new page seems to just trigger an update: (jSutterfield adds and edits a page)
	// jsutterfield
	{"method":"addWatch","params":{"wl_user":24055122,"wl_namespace":0,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4208,"wl_rev_timestamp":"20150122192708"}}
	{"method":"addWatch","params":{"wl_user":24055122,"wl_namespace":1,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4208,"wl_rev_timestamp":"20150122192708"}}
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":null,"wl_revision":4208,"wl_rev_timestamp":"20150122192708"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":24055122},"wl_wikia":"869155"}}
But then when a new user comes and edits that page, an addWatch takes places (jButterfield edits that page)
	// jsutterfield
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":"20150122193244","wl_revision":4209,"wl_rev_timestamp":"20150122193244"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":24055122},"wl_wikia":"869155"}}
	// jbutterfield
	{"method":"addWatch","params":{"wl_user":26033468,"wl_namespace":0,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4209,"wl_rev_timestamp":"20150122193244"}}
	{"method":"addWatch","params":{"wl_user":26033468,"wl_namespace":1,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4209,"wl_rev_timestamp":"20150122193244"}}
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":null,"wl_revision":4209,"wl_rev_timestamp":"20150122193244"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":26033468},"wl_wikia":"869155"}}
And then another comes and edits that page (JCutterfield edits the page)
	// jbutterfield
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":"20150122193708","wl_revision":4210,"wl_rev_timestamp":"20150122193708"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":26033468},"wl_wikia":"869155"}}
	// jcutterfield
	{"method":"addWatch","params":{"wl_user":26033488,"wl_namespace":0,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4210,"wl_rev_timestamp":"20150122193708"}}
	{"method":"addWatch","params":{"wl_user":26033488,"wl_namespace":1,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4210,"wl_rev_timestamp":"20150122193708"}}
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":null,"wl_revision":4210,"wl_rev_timestamp":"20150122193708"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":26033488},"wl_wikia":"869155"}}
And then another edit comes from jdutterfield
	// jcutterfield
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":"20150122213336","wl_revision":4211,"wl_rev_timestamp":"20150122213336"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":26033488},"wl_wikia":"869155"}}
		delete from global_watchlist where gwa_city_id = '869155' and gwa_namespace = '0' and gwa_title = 'NewPage1' and gwa_user_id = '24055122'
		insert  IGNORE  into global_watchlist (gwa_city_id,gwa_namespace,gwa_title,gwa_user_id) values( '869155', '0', 'NewPage1', '24055122')
		update global_watchlist set gwa_rev_id = 4211,gwa_timestamp = 20150122213336,gwa_rev_timestamp = 20150122213336 where gwa_city_id = '869155' and gwa_namespace = '0' and gwa_title = 'NewPage1' and gwa_user_id = '24055122'
	// jdutterfield
	{"method":"addWatch","params":{"wl_user":26033821,"wl_namespace":0,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4211,"wl_rev_timestamp":"20150122213336"}}
	{"method":"addWatch","params":{"wl_user":26033821,"wl_namespace":1,"wl_title":"NewPage1","wl_notificationtimestamp":null,"wl_wikia":"869155","wl_revision":4211,"wl_rev_timestamp":"20150122213336"}}
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":null,"wl_revision":4211,"wl_rev_timestamp":"20150122213336"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":26033821},"wl_wikia":"869155"}}
jsutterfield then visits the page
	{"method":"updateWatch","params":{"update":{"wl_notificationtimestamp":null,"wl_revision":4211,"wl_rev_timestamp":"20150122213336"},"where":{"wl_title":"NewPage1","wl_namespace":0,"wl_user":24055122},"wl_wikia":"869155"}}
		delete from global_watchlist where gwa_city_id = '869155' and gwa_namespace = '0' and gwa_title = 'NewPage1' and gwa_user_id = '24055122'

