# Global Watchlist

The global watchlist is used to send out a weekly digest of changes to all pages a user is watching across Wikia. It
works using a combination of hooks built into the local watchlist flow and the [Job Queue](https://one.wikia-inc.com/wiki/Engineering/Job_Queue).
To understand how the system works, it helps to have a quick overview of how the local watchlist system works:

## Local Watchlist
When a user (let's call them User A) makes an edit to a page or explicitly starts following a page, they are added to the local
watchlist table for that wiki. That entry looks something like this:

	+----------+--------------+-----------+--------------------------+-------------------------+
	| wl_user  | wl_namespace | wl_title  | wl_notificationtimestamp | wl_wikia_addedtimestamp |
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910443 |            0 | TestPage  | NULL                     |   2015-02-02 15:37:09   | User A
	+----------+--------------+-----------+--------------------------+-------------------------+
	Ex 1

Note the value of `NULL` for the `wl_notificationtimestamp` field. This is used to indicate that User A is watching the
page, but has seen the latest version. When a second user, User B, comes along and edits that page, three things
happen. First, an email is sent to User A informing them the page they were watching has changed. Next, a new entry
is added to the local watchlist table for User B indicating that they are now watching the page. Finally, the row for
User A is updated with the current timestamp to indicate they were notified about the change.

	+----------+--------------+-----------+--------------------------+-------------------------+
	| wl_user  | wl_namespace | wl_title  | wl_notificationtimestamp | wl_wikia_addedtimestamp |
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910443 |            0 | TestPage  | 20150202153859           |  2015-01-20 23:19:21    | User A
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910444 |            0 | TestPage  | NULL                     |  2015-02-02 15:38:59    | User B
	+----------+--------------+-----------+--------------------------+-------------------------+
	Ex 2

If a third user, User C, comes along and edits the page, the process is similar but for one key difference. Because
User A has already been notified about the last change (and therefore has a time stamp in their `wl_notificationtimestamp`
field), they will not be sent an email a second time informing them of the change. Nothing effectively happens for that user.
User B however will receive a notification email, and the table will be updated accordingly.

	+----------+--------------+-----------+--------------------------+-------------------------+
	| wl_user  | wl_namespace | wl_title  | wl_notificationtimestamp | wl_wikia_addedtimestamp |
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910443 |            0 | TestPage  | 20150202153859           |  2015-02-02 15:37:09    | User A
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910444 |            0 | TestPage  | 20150202154342           |  2015-02-02 15:38:59    | User B
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910445 |            0 | TestPage  | NULL                     |  2015-02-02 15:43:43    | User C
	+----------+--------------+-----------+--------------------------+-------------------------+
	Ex 3

As soon as User A revisits the page, their `wl_notificationtimestamp` is set back to NULL and they will receive a
notification the next time the page is edited.

	+----------+--------------+-----------+--------------------------+-------------------------+
	| wl_user  | wl_namespace | wl_title  | wl_notificationtimestamp | wl_wikia_addedtimestamp |
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910443 |            0 | TestPage  | NULL                     |  2015-02-02 15:37:09    | User A
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910444 |            0 | TestPage  | 20150202154342           |  2015-02-02 15:38:59    | User B
	+----------+--------------+-----------+--------------------------+-------------------------+
	| 23910445 |            0 | TestPage  | NULL                     |  2015-02-02 15:43:43    | User C
	+----------+--------------+-----------+--------------------------+-------------------------+
	Ex 4

## Global Watchlist
The global watchlist ties into the local watchlist process described above. It serves as a central record for all pages
across Wikia a user is watching which have changed, but they have not visited yet. Here's the general flow:

Whenever a page is updated, all user's who had seen the latest version up to that point are notified via email and have
their `wl_notificationtimestamp` field updated in the `watchlist` table (Ex 2 above). At that point, a hook is fired
which sends a job via the Job Queue to have that user added to the `global_watchlist` table. After Ex 2 above, the
`global_watchlist` table would look something like this:

	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	| gwa_id | gwa_user_id | gwa_city_id | gwa_namespace | gwa_title      | gwa_rev_id | gwa_timestamp  | gwa_rev_timestamp |
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	|     86 |   23910443  |      435087 |             0 | TestPage       |      53755 | 20150202153859 |  20150202153859   | User A
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+

If 2 other pages User A is watching are changed later on, the `global_watchlist` is updated with 2 additional rows.

	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	| gwa_id | gwa_user_id | gwa_city_id | gwa_namespace | gwa_title      | gwa_rev_id | gwa_timestamp  | gwa_rev_timestamp |
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	|     86 |    23910443 |      435087 |             0 | TestPage       |      53755 | 20150202153859 |  20150202153859   | User A
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	|     88 |    23910443 |       26337 |             0 | GleeTestPage   |    2540196 | 20150202184358 | 20150202184358    | User A
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	|     89 |    23910443 |         831 |             0 | MuppetTestPage |     773845 | 20150202184620 | 20150202184620    | User A
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+

If user A visits any of those pages before the weekly digest is run, that row will be deleted from the global_watchlist table.
So if they were to visit the MuppetTestPage, the table would then look like:

	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	| gwa_id | gwa_user_id | gwa_city_id | gwa_namespace | gwa_title      | gwa_rev_id | gwa_timestamp  | gwa_rev_timestamp |
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	|     86 |    23910443 |      435087 |             0 | TestPage       |      53755 | 20150202153859 |  20150202153859   | User A
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+
	|     88 |    23910443 |       26337 |             0 | GleeTestPage   |    2540196 | 20150202184358 | 20150202184358    | User A
	+--------+-------------+-------------+---------------+----------------+------------+----------------+-------------------+

The Weekly Digest itself is sent out weekly via a cronjob. The job queries the `global_watchlist` table for all
users, then the digest is prepared and sent out to each one. Once we send the weekly digest to a user all their rows in
the `global_watchlist` table are deleted, and the corresponding rows in the local watchlist tables have their `wl_notificationtimestamp`
fields set to null (which means the user will be notified about the next change going forward).

If a user ever unsubscribes from the Weekly Digest, or unsubscribes from all email from Wikia, all of their rows will be
deleted from the `global_watchlist` table. New rows will not be added for them until they resubscribe.

Logging and stats for the Weekly Digest can be found [here](https://kibana.wikia-inc.com/index.html#/dashboard/elasticsearch/Weekly%20Digest)