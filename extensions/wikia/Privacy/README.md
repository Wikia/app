Privacy
=======

A set of script that remove user data as a part of GPDR project.

## Entry point

* An internal HTTP request needs to be sent to `RemoveUserDataController` (`removeUserData` method) with `userId` URL parameter.
* Special:RequestToBeForgottenInternal is available for staff users on wikis where `$wgEnableRequestToBeForgottenInternalSpecialPage` WikiFactory variable is set to `true`.

## Steps performed

1. `UserDataRemover::removeGlobalData` renames the user to a random name (with `Anonymous ` prefix) by issuing an `UPDATE` query on `wikicities.user` table, all caches are invalidated there as well. User specific data is removed from `user_email_log` and `user_properties` tables.
2. `events_local_users` table is then used to get the list of wikis given user was active on.
3. `RemoveUserDataOnWikiTask` task is scheduled for each of these wikis.
4. The task is dispatched on each wiki and it does the following cleanups:
 * CheckUser feature - rows are removed from `cu_changes` and `cu_log` tables
 * Recent Changes - `recentchanges` table entries are updated to have an empty IP address
 * Abuse Filter - `abuse_filter`, `abuse_filter_history` tables rows are updated to have an empty user name (rows are removed from `abuse_filter_log` table)
 * `removeUserPages` removes user pages (NS_USER), user talk pages (NS_USER_TALK), blog pages (NS_BLOG_ARTICLE), wall messages (NS_USER_WALL_MESSAGE_GREETING, NS_USER_WALL_MESSAGE, NS_USER_WALL) pages of the given user (including sub-pages). `PermanentArticleDelete::deletePage` is used to **delete them permanently, leaving no trace**.
 
 ## Debugging
 
 All logs from this process are marked with `@content.right_to_be_forgotten: 1` for easy "grepping" in Kibana.
