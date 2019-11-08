Privacy
=======

A set of scripts that remove user data as a part of GPDR project.

## Entry point

**An internal HTTP request** needs to be sent to `RemoveUserDataController` (`removeUserData` method) with `userId` URL parameter.

Alternatively, **Special:RequestToBeForgottenInternal is available** for `request-to-be-forgotten-admin` group members on wikis where [`$wgEnableRequestToBeForgottenInternalSpecialPage`](https://community.wikia.com/wiki/Special:WikiFactory/1474483/variables/wgEnableRequestToBeForgottenInternalSpecialPage) WikiFactory variable is set to `true`.

## Steps performed
1. `events_local_users` table is then used to get the list of wikis given user was active on.
2. `RemoveUserDataOnWikiTask` task is scheduled for each of these wikis.
3. The task is dispatched on each wiki and it does the following cleanups:
 * CheckUser feature - rows are removed from `cu_changes` and `cu_log` tables
 * Recent Changes - `recentchanges` table entries are updated to have an empty IP address
 * Abuse Filter - `abuse_filter`, `abuse_filter_history` tables rows are updated to have an empty user name (rows are removed from `abuse_filter_log` table)
 * `removeUserPages` removes user pages (NS_USER), user talk pages (NS_USER_TALK), blog pages (NS_BLOG_ARTICLE), wall messages (NS_USER_WALL_MESSAGE_GREETING, NS_USER_WALL_MESSAGE, NS_USER_WALL) pages of the given user (including sub-pages). `PermanentArticleDelete::deletePage` is used to **delete them permanently, leaving no trace**.
 * all `recentchanges` entries connected to user pages are removed
 * all `logging` entries connected to user pages are removed
 * all `watchlist` entries that belong to the user are removed
 * if the user was renamed, user pages are removed for the old username as well
4. `UserDataRemover::removeGlobalData` anonimizes all user data not related to specific communities.
  * the user is renamed to a random name (with `Anonymous ` prefix) by issuing an `UPDATE` query on `wikicities.user` table
  * user's email and birthday are removed from the `user` table
  * antispoof data is anonimized by removing the username record from the `spoofuser` table, and adding a hashed version to `spoofuser_forgotten`
  * user specific data is removed from `user_email_log`, `user_properties` and `wikiastaff_log` tables.
  * user cache in deleted
  * the user is marked as disabled
  * if the user was previously renamed, all the above steps are also performed for the old username

## Debugging

All logs from this process are marked with `@content.right_to_be_forgotten: 1` for easy "grepping" in Kibana.

Due to caching, it may take up to 24h for user pages to be removed completely.

## Handling "forget me" requests in a bulk

See [sus-dynks' gdpr tool](https://github.com/Wikia/sus-dynks/tree/master/gdpr).
