<?php
/**
 * Internationalisation file for extension CodeReview.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'code' => 'Code Review',
	'code-rev-id' => 'r$1',
	'code-rev-title' => '$1 - Code Review',
	'code-comments' => 'Comments',
	'code-references' => 'Follow-up revisions',
	'code-referenced' => 'Followed-up revisions',
	'code-change-status' => "changed the '''status''' of $1",
	'code-change-tags' => "changed the '''tags''' for $1",
	'code-change-removed' => 'removed:',
	'code-change-added' => 'added:',
	'code-old-status' => 'Old status',
	'code-new-status' => 'New status',
	'code-prop-changes' => 'Status & tagging log',
	'codereview-desc' => '[[Special:Code|Code review tool]] with [[Special:RepoAdmin|Subversion support]]',
	'code-no-repo' => 'No repository configured!',
	'code-create-repo' => 'Go to [[Special:RepoAdmin|RepoAdmin]] to create a Repository',
	'code-need-repoadmin-rights' => 'repoadmin rights are needed to be able to create a Repository',
	'code-need-group-with-rights' => 'No group with repoadmin rights exist. Please add one to be able to add a new Repository',
	'code-repo-not-found' => "Repository '''$1''' does not exist!",
	'code-load-diff' => 'Loading diff…',
	'code-notes' => 'recent comments',
	'code-statuschanges' => 'status changes',
	'code-mycommits' => 'my commits',
	'code-mycomments' => 'my comments',
	'code-authors' => 'authors',
	'code-status' => 'states',
	'code-tags' => 'tags',
	'code-tags-no-tags' => 'No tags exist in this repository.',
	'code-authors-text' => 'Below is a list of repo authors in order of commit name. Local wiki accounts are shown in parentheses. Data may be cached.',
	'code-author-haslink' => 'This author is linked to the wiki user $1',
	'code-author-orphan' => 'SVN user/Author $1 has no link with a wiki account',
	'code-author-dolink' => 'Link this author to a wiki user:',
	'code-author-alterlink' => 'Change the wiki user linked to this author:',
	'code-author-orunlink' => 'Or unlink this wiki user:',
	'code-author-name' => 'Enter a username:',
	'code-author-success' => 'The author $1 has been linked to the wiki user $2',
	'code-author-link' => 'link?',
	'code-author-unlink' => 'unlink?',
	'code-author-unlinksuccess' => 'Author $1 has been unlinked',
	'code-author-badtoken' => 'Session error trying to perform the action.',
	'code-author-total' => 'Total number of authors: $1',
	'code-author-lastcommit' => 'Last commit date',
	'code-browsing-path' => "Browsing revisions in '''$1'''",
	'code-field-id' => 'Revision',
	'code-field-author' => 'Author',
	'code-field-user' => 'Commenter',
	'code-field-message' => 'Commit summary',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Status description',
	'code-field-timestamp' => 'Date',
	'code-field-comments' => 'Comments',
	'code-field-path' => 'Path',
	'code-field-text' => 'Note',
	'code-field-select' => 'Select',
	'code-reference-remove' => 'Remove selected associations',
	'code-reference-associate' => 'Associate follow-up revision:',
	'code-reference-associate-submit' => 'Associate',
	'code-rev-author' => 'Author:',
	'code-rev-date' => 'Date:',
	'code-rev-message' => 'Comment:',
	'code-rev-repo' => 'Repository:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'on ViewVC',
	'code-rev-paths' => 'Modified paths:',
	'code-rev-modified-a' => 'added',
	'code-rev-modified-r' => 'replaced',
	'code-rev-modified-d' => 'deleted',
	'code-rev-modified-m' => 'modified',
	'code-rev-imagediff'  => 'Image changes',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Change status',
	'code-rev-tags' => 'Tags:',
	'code-rev-tag-add' => 'Add tags:',
	'code-rev-tag-remove' => 'Remove tags:',
	'code-rev-comment-by' => 'Comment by $1',
	'code-rev-comment-preview' => 'Preview',
	'code-rev-comment-preview-accesskey' => 'p',
	'code-rev-inline-preview' => 'Preview:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'The diff is too large to display.',
	'code-rev-purge-link' => 'purge',
	'code-rev-total' => 'Total number of results: $1',
	'code-rev-not-found' => "Revision '''$1''' does not exist!",
	'code-rev-history-link' => 'history',
	'code-status-new' => 'new',
	'code-status-desc-new' => 'Revision is pending an action (default status).',
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => 'Revision introduced a bug or is broken. It should be fixed or reverted.',
	'code-status-reverted' => 'reverted',
	'code-status-desc-reverted' => 'Revision was undone by a later revision.',
	'code-status-resolved' => 'resolved',
	'code-status-desc-resolved' => 'Revision had an issue which was addressed by a later revision.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revision fully reviewed and reviewer is sure it is fine in every way.',
	'code-status-deferred' => 'deferred',
	'code-status-desc-deferred' => 'Revision does not require review.',
	'code-status-old' => 'old',
	'code-status-desc-old' => 'Old revision with potential bugs but which are not worth the effort of reviewing them.',
	'code-signoffs' => 'Sign-offs',
	'code-signoff-legend' => 'Add sign-off',
	'code-signoff-submit' => 'Sign off',
	'code-signoff-strike' => 'Strike selected sign-offs',
	'code-signoff-signoff' => 'Sign off on this revision as:',
	'code-signoff-flag-inspected' => 'Inspected',
	'code-signoff-flag-tested' => 'Tested',
	'code-signoff-field-user' => 'User',
	'code-signoff-field-flag' => 'Flag',
	'code-signoff-field-date' => 'Date',
	'code-signoff-struckdate' => '$1 (struck $2)',
	'code-pathsearch-legend' => 'Search revisions in this repo by path',
	'code-pathsearch-path' => 'Path:',
	'code-pathsearch-filter' => 'Show only:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Author = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Clear filter',
	'code-rev-submit' => 'Save changes',
	'code-rev-submit-accesskey' => 's',
	'code-rev-submit-next' => 'Save & next unresolved',
	'code-rev-submit-next-accesskey' => '',
	'code-rev-next' => 'Next unresolved',
	'code-rev-next-accesskey' => '',
	'code-batch-status' => 'Change status:',
	'code-batch-tags' => 'Change tags:',
	'codereview-batch-title' => 'Change all selected revisions',
	'codereview-batch-submit' => 'Submit',

	'code-releasenotes'     => 'release notes',
	'code-release-legend'   => 'Generate release notes',
	'code-release-startrev' => 'Start rev:',
	'code-release-endrev'   => 'Last rev:',

	'codereview-subtitle' => 'For $1',

	'codereview-reply-link' => 'reply',

	'codereview-overview-title' => 'Overview',
	'codereview-overview-desc' => 'Show a graphical overview of this list',

	'codereview-email-subj' => '[$1 $2]: New comment added',
	'codereview-email-body' => '"$1" posted a comment on $3.
URL: $2

Commit summary for $3:

$5

$1\'s comment:

$4',

	'codereview-email-subj2' => '[$1 $2]: Follow-up changes',
	'codereview-email-body2' => '"$1" made follow-up changes to $2.
URL: $5

Commit summary for followed-up $2:

$6

Follow-up URL: $3
Follow-up summary by "$1":

$4',

	'codereview-email-subj3' => '[$1 $2]: Revision status changed',
	'codereview-email-body3' => '"$1" changed the status of $2 to "$4"
URL: $5

Old status:  $3
New status: $4

Commit summary for $2:

$6',

	'codereview-email-subj4' => '[$1 $2]: New comment added, and revision status changed',
	'codereview-email-body4' => '"$1" changed the status of $2 to "$4" and commented it.
URL: $5

Old Status: $3
New Status: $4

Commit summary for $2:

$7

$1\'s comment:

$6',

	'code-stats' => 'statistics',
	'code-stats-header' => 'Statistics for repository $1',
	'code-stats-main' => 'As of $1, the repository has $2 {{PLURAL:$2|revision|revisions}} by [[Special:Code/$3/author|$4 {{PLURAL:$4|author|authors}}]].',
	'code-stats-status-breakdown' => 'Number of revisions per state',
	'code-stats-fixme-breakdown' => 'Breakdown of fixme revisions per author',
	'code-stats-fixme-breakdown-path' => 'Breakdown of fixme revisions per path',
	'code-stats-fixme-path' => 'Fixme revisions for path: $1',
	'code-stats-new-breakdown' => 'Breakdown of new revisions per author',
	'code-stats-new-breakdown-path' => 'Breakdown of new revisions per path',
	'code-stats-new-path' => 'New revisions for path: $1',
	'code-stats-count' => 'Number of revisions',

	'code-tooltip-withsummary' => 'r$1 [$2] by $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] by $3',

	'repoadmin' => 'Repository Administration',
	'repoadmin-new-legend' => 'Create a new repository',
	'repoadmin-new-label' => 'Repository name:',
	'repoadmin-new-button' => 'Create',
	'repoadmin-edit-legend' => 'Modification of repository "$1"',
	'repoadmin-edit-path' => 'Repository path:',
	'repoadmin-edit-bug' => 'Bugzilla path:',
	'repoadmin-edit-view' => 'ViewVC path:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'The repository "[[Special:Code/$1|$1]]" has been successfully modified.',
	'repoadmin-nav' => 'repository administration',

	'right-repoadmin' => 'Manage code repositories',
	'right-codereview-use' => 'Use of Special:Code',
	'right-codereview-add-tag' => 'Add new tags to revisions',
	'right-codereview-remove-tag' => 'Remove tags from revisions',
	'right-codereview-post-comment' => 'Add comments on revisions',
	'right-codereview-set-status' => 'Change revisions status',
	'right-codereview-signoff' => 'Sign off on revisions',
	'right-codereview-link-user' => 'Link authors to wiki users',
	'right-codereview-associate' => 'Manage revision associations',
	'right-codereview-review-own' => 'Mark your own revisions as "{{int:code-status-ok}}" or "{{int:code-status-resolved}}"',

	'action-repoadmin' => 'manage code repositories',
	'action-codereview-use' => 'use of Special:Code',
	'action-codereview-add-tag' => 'add new tags to revisions',
	'action-codereview-remove-tag' => 'remove tags from revisions',
	'action-codereview-post-comment' => 'add comments on revisions',
	'action-codereview-set-status' => 'change revisions status',
	'action-codereview-signoff' => 'sign off on revisions',
	'action-codereview-link-user' => 'link authors to wiki users',
	'action-codereview-associate' => 'manage revision associations',
	'action-codereview-review-own' => 'mark your own revisions as "{{int:code-status-ok}} or "{{int:code-status-resolved}}"',

	'specialpages-group-developer' => 'Developer tools',

	'group-svnadmins' => 'SVN admins',
	'group-svnadmins-member' => '{{GENDER:$1|SVN admin}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN admins',
);

/** Message documentation (Message documentation)
 * @author Amire80
 * @author Aotake
 * @author Beta16
 * @author Dalibor Bosits
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author Jon Harald Søby
 * @author Kghbln
 * @author Kwj2772
 * @author MaxSem
 * @author McDutchie
 * @author Mormegil
 * @author Nike
 * @author Purodha
 * @author Raymond
 * @author SPQRobin
 * @author Siebrand
 * @author Sp5uhe
 * @author Umherirrender
 * @author Verdy p
 * @author Yekrats
 */
$messages['qqq'] = array(
	'code-rev-title' => 'Title of code review page. "$1" is the name of the project being coded followed by a revision number.',
	'code-comments' => '{{Identical|Comments}}',
	'code-references' => 'A follow-up revision is a (newer) revision that follows up a previous (older followed-up) revision.',
	'code-referenced' => 'A followed-up revision is a (older) revision that has been followed up by a (newer) revision.',
	'code-change-added' => '{{Identical|Added}}',
	'codereview-desc' => '{{desc}}',
	'code-need-group-with-rights' => 'Do not translate the word <code>repoadmin</code>.',
	'code-repo-not-found' => "Message displayed when the requested repository does not exist in the wiki's repo definitions.  $1 is the name that was requested, and will be fully escaped before output.",
	'code-tags' => '{{Identical|Tag}}',
	'code-author-total' => 'This is a message shown above the list of contributors. An example can be found at http://www.mediawiki.org/wiki/Special:Code/MediaWiki/author',
	'code-author-lastcommit' => 'This is a column title in the list of contributors. An example can be found at http://www.mediawiki.org/wiki/Special:Code/MediaWiki/author',
	'code-field-id' => '{{Identical|Revision}}',
	'code-field-author' => '{{Identical|Author}}',
	'code-field-user' => 'Column title (used in a table).',
	'code-field-message' => 'This is probably a noun instead of verb, a column header.',
	'code-field-status' => '{{Identical|Status}}',
	'code-field-timestamp' => '{{Identical|Date}}',
	'code-field-comments' => '{{Identical|Comments}}',
	'code-field-path' => '{{Identical|Path}}',
	'code-field-text' => '{{Identical|Note}}',
	'code-field-select' => '{{Identical|Select}}',
	'code-reference-remove' => 'Caption of the button used to remove the selected (with checkboxes) revisions from the follow-up list.',
	'code-reference-associate' => 'Label text which is followed by a text box in which the user can enter the ID of a revision to mark as a follow-up.

See also: {{msg-mw|Code-references}}',
	'code-reference-associate-submit' => 'Submit button for marking a revision as a follow-up.',
	'code-rev-author' => '{{Identical|Author}}',
	'code-rev-date' => '{{Identical|Date}}',
	'code-rev-message' => '{{Identical|Comment}}',
	'code-rev-rev' => '{{Identical|Revision}}',
	'code-rev-modified-a' => '{{Identical|Added}}',
	'code-rev-modified-m' => '{{Identical|Modified}}',
	'code-rev-status' => '{{Identical|Status}}',
	'code-rev-tags' => '{{Identical|Tag}}',
	'code-rev-comment-preview' => '{{Identical|Preview}} Caption of the button used to preview a comment.',
	'code-rev-inline-preview' => '{{Identical|Preview}} Text "Preview" shown before the comment which is currently being previewed.',
	'code-rev-history-link' => '{{Identical|History}}',
	'code-status-new' => '{{Identical|New}}',
	'code-status-reverted' => '{{Identical|Revert}}',
	'code-status-ok' => '{{Identical|OK}}',
	'code-signoffs' => 'A "sign-off" is a concept in code review that means that the person doing the sign-off has approved the involved code changes.',
	'code-signoff-legend' => 'A "sign-off" is a concept in code review that means that the person doing the sign-off has approved the involved code changes.',
	'code-signoff-submit' => 'Submit button text.

A "sign-off" is a concept in code review that means that the person doing the sign-off has approved the involved code changes.',
	'code-signoff-strike' => 'Submit button that, when clicked, will cause the selected sign-offs to be struck. Struck sign-offs are visible but displayed <del>with a line through them</del>.',
	'code-signoff-signoff' => 'Label text which is followed by a checkbox for each sign-off state and a submit button.',
	'code-signoff-flag-inspected' => 'Type of sign-off indicating the code has been looked at.',
	'code-signoff-flag-tested' => 'Type of sign-off indicating the code has been tested.',
	'code-signoff-field-user' => 'Table column header: name of the user that did the sign-off.',
	'code-signoff-field-flag' => 'Table column header: "type" of sign-off. One of the code-signoff-flag-* messages, such as:
* {{msg-mw|code-signoff-flag-inspected}}
* {{msg-mw|code-signoff-flag-tested}}',
	'code-signoff-field-date' => 'Table column header: timestamp of the sign-off. {{Identical|Date}}',
	'code-signoff-struckdate' => 'This is displayed in the date column for a struck sign-off. $1 is the timestamp of the sign-off, $2 is the timestamp of when it was struck. Struck is the past tense of verb strike (as in delete).',
	'code-pathsearch-path' => '{{Identical|Path}}',
	'code-revfilter-cr_status' => '{{Identical|Status}}',
	'code-revfilter-cr_author' => '{{Identical|Author}}',
	'code-rev-submit' => 'Caption of the button used to Save changes when viewing a revision.
{{Identical|Save changes}}',
	'code-rev-submit-next' => 'Caption of the button used when viewing a revision to Save changes moving to next unresolved revision.',
	'code-rev-next' => 'Caption of the button used when viewing a revision to move to the next unresolved revision.',
	'codereview-batch-submit' => '{{Identical|Submit}}',
	'codereview-subtitle' => '{{Identical|For $1}}
----
$1 = Repository name',
	'codereview-reply-link' => '{{Identical|Reply}}',
	'codereview-overview-title' => '{{Identical|Overview}}',
	'codereview-email-body' => 'Email body for notification about a comment on a revision.

* $1 - username
* $2 - URL
* $3 - product name and revision number
* $4 - comment text
* $5 - commit summary',
	'codereview-email-subj2' => 'Subject of an e-mail sent to a user whose revision has been followed upon.
* <code>$1</code> – Repository name
* <code>$2</code> – Number of the original revision (which has been followed upon)',
	'codereview-email-body2' => 'Body of an e-mail sent to a user whose revision has been followed upon.
* <code>$1</code> – User who created the follow-up revision
* <code>$2</code> – Number of the revision that has been followed upon.
* <code>$3</code> – URL to the new revision.
* <code>$4</code> – Commit message of the new revision.
* <code>$5</code> – URL to followed revision.
* <code>$6</code> – Commit message of the followed revision.',
	'codereview-email-subj3' => '* <code>$1</code> – Repository name
* <code>$2</code> – Number of the revision',
	'codereview-email-body3' => '* $1 is a user name
* $2 is a revision number
* $3 is the old status
* $4 is the new status
* $5 is the full URL to code review
* $6 is the commit summary for the change',
	'codereview-email-body4' => '* $1 is a user name
* $2 is a revision number
* $3 is the old status
* $4 is the new status
* $5 is the full URL to code review
* $6 is the commit summary for the change
* $7 is the comment for the change',
	'code-stats' => '{{Identical|Statistics}}',
	'code-stats-main' => 'Parameters:
* $1 - time and date when statistics was cached
* $2 - total number of revisions
* $3 - repository name, used only to generate links
* $4 - total number of authors who commited to this repository
* $5 - same as $1, but time only (optional)
* $6 - same as $1, but date only (optional)',
	'code-stats-status-breakdown' => 'Table header for column containing the number of revisions (commits) having some state (new, ok, reverted etc.)',
	'repoadmin-new-button' => '{{Identical|Create}}',
	'repoadmin-edit-button' => '{{Identical|OK}}',
	'right-repoadmin' => '{{doc-right|repoadmin}}',
	'right-codereview-use' => '{{doc-right|codereview-use}}',
	'right-codereview-add-tag' => '{{doc-right|codereview-add-tag}}',
	'right-codereview-remove-tag' => '{{doc-right|codereview-remove-tag}}',
	'right-codereview-post-comment' => '{{doc-right|codereview-post-comment}}',
	'right-codereview-set-status' => '{{doc-right|codereview-set-status}}',
	'right-codereview-signoff' => '{{doc-right|codereview-signoff}}
A "sign-off" is a concept in code review that means that the person doing the sign-off has approved the involved code changes.',
	'right-codereview-link-user' => '{{doc-right|codereview-link-user}}',
	'right-codereview-associate' => '{{doc-right|codereview-associate}}',
	'right-codereview-review-own' => '{{doc-right|codereview-review-own}}',
	'action-repoadmin' => '{{doc-action|repoadmin}}',
	'action-codereview-use' => '{{doc-action|codreview-use}}',
	'action-codereview-add-tag' => '{{doc-action|codereview-add-tag}}',
	'action-codereview-remove-tag' => '{{doc-action|codereview-remove-tag}}',
	'action-codereview-post-comment' => '{{doc-action|codereview-post-comment}}',
	'action-codereview-set-status' => '{{doc-action|codereview-set-status}}',
	'action-codereview-signoff' => '{{doc-action|codereview-signoff}}
A "sign-off" is a concept in code review that means that the person doing the sign-off has approved the involved code changes.',
	'action-codereview-link-user' => '{{doc-action|codereview-link-user}}',
	'action-codereview-associate' => '{{doc-action|codereview-associate}}',
	'action-codereview-review-own' => '{{doc-action|codereview-review-own}}',
	'group-svnadmins' => '{{doc-group|svnadmins}}',
	'group-svnadmins-member' => '{{doc-group|svnadmins|member}}',
	'grouppage-svnadmins' => '{{doc-group|svnadmins|page}}',
);

/** Afrikaans (Afrikaans)
 * @author Ansumang
 * @author Naudefj
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'code' => 'Beoordeling van kode',
	'code-rev-title' => '$1 - Programkodebeheer',
	'code-comments' => 'Opmerkings',
	'code-references' => 'Weergawes met korreksies',
	'code-change-status' => "het die '''status''' vir weergawe $1 gewysig",
	'code-change-tags' => "het die '''etikette''' vir weergawe $1 gewysig",
	'code-change-removed' => 'verwyder:',
	'code-change-added' => 'bygevoeg:',
	'code-old-status' => 'Ou status',
	'code-new-status' => 'Nuwe status',
	'code-prop-changes' => 'Status & kodering log',
	'code-no-repo' => 'Geen repository geconfigureerd!',
	'code-need-repoadmin-rights' => "repoadmin regte wat nodig is om in staat wees om 'n Repository te skep",
	'code-need-group-with-rights' => "Geen groep met repoadmin regte bestaan​​. Voeg 'n staat te wees om' n nuwe Repository te voeg",
	'code-load-diff' => 'Laai verskil...',
	'code-notes' => 'onlangse kommentaar',
	'code-statuschanges' => 'status veranderings',
	'code-mycommits' => 'my indienings',
	'code-mycomments' => 'my kommentaar',
	'code-authors' => 'outeurs',
	'code-status' => 'statusse',
	'code-tags' => 'etikette',
	'code-tags-no-tags' => 'Geen tags bestaan ​​in hierdie repository.',
	'code-authors-text' => "Hier is 'n lys van die repo-skrywers in die orde van die pleeg naam. Plaaslike WIKI rekeninge is, word in hakies. Data kan word Cached.",
	'code-author-dolink' => "Link hierdie skrywer tot 'n wiki gebruiker:",
	'code-author-alterlink' => 'Verander die wiki gebruiker in verband met hierdie skrywer:',
	'code-author-orunlink' => 'Of verwyder hierdie wiki gebruiker:',
	'code-author-name' => "Sleutel 'n gebruikersnaam in:",
	'code-author-link' => 'koppel?',
	'code-author-unlink' => 'ontkoppel?',
	'code-author-badtoken' => 'Sessie fout probeer om die aksie uit te voer.',
	'code-author-lastcommit' => 'Laaste pleeg datum',
	'code-field-id' => 'Weergawe',
	'code-field-author' => 'Outeur',
	'code-field-user' => 'Opmerking deur',
	'code-field-message' => 'Commit opsomming',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'status beskrywing',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Kommentaar',
	'code-field-path' => 'Pad',
	'code-field-text' => 'Opmerking',
	'code-field-select' => 'Kies',
	'code-reference-remove' => 'Verwyder geselekteerde verenigings',
	'code-reference-associate-submit' => 'Mede-',
	'code-rev-author' => 'Outeur:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Opmerking:',
	'code-rev-repo' => 'Repository:',
	'code-rev-rev' => 'Weergawe:',
	'code-rev-rev-viewvc' => 'in ViewVC',
	'code-rev-modified-a' => 'bygevoeg',
	'code-rev-modified-r' => 'vervang',
	'code-rev-modified-d' => 'verwyder',
	'code-rev-modified-m' => 'verander',
	'code-rev-imagediff' => 'Image veranderinge',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Wysigingsstatus',
	'code-rev-tags' => 'Etikette:',
	'code-rev-tag-add' => 'Voeg etikette by:',
	'code-rev-tag-remove' => 'Verwyder etikette:',
	'code-rev-comment-by' => 'Opmerking van $1',
	'code-rev-comment-preview' => 'Voorskou',
	'code-rev-inline-preview' => 'Voorskou:',
	'code-rev-diff' => 'Veranderinge',
	'code-rev-diff-link' => 'veranderinge',
	'code-rev-diff-too-large' => 'Die verskil is te groot om te vertoon.',
	'code-rev-purge-link' => 'verfris',
	'code-rev-total' => 'Totale aantal resultate: $1',
	'code-rev-not-found' => "Weergawe '''$1''' bestaan nie!",
	'code-rev-history-link' => 'geskiedenis',
	'code-status-new' => 'nuut',
	'code-status-desc-new' => "Hersiening is hangende 'n aksie (standaard status).",
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => "Hersiening lei 'n fout of gebreek is. Daar moet vasgestel word of teruggekeer.",
	'code-status-reverted' => 'teruggerol',
	'code-status-desc-reverted' => "Hersiening is ongedaan gemaak deur 'n latere hersiening.",
	'code-status-resolved' => 'opgelos',
	'code-status-desc-resolved' => "Hersiening het 'n probleem wat deur' n latere hersiening gerig is.",
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Hersiening ten volle hersien en resensent is seker dit is goed om in elke opsig.',
	'code-status-deferred' => 'uitgestelde',
	'code-status-desc-deferred' => 'Hersiening is dit nie nodig hersien.',
	'code-status-old' => 'oud',
	'code-status-desc-old' => 'Ou hersiening met potensiële foute, maar wat nie die moeite werd van hersiening.',
	'code-signoff-flag-inspected' => 'Geïnspekteer',
	'code-signoff-flag-tested' => 'Getoets',
	'code-signoff-field-user' => 'Gebruiker',
	'code-signoff-field-flag' => 'Vlag',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (het $2 deurgehaal)',
	'code-pathsearch-legend' => 'Soek hersienings in die repokoers deur die pad',
	'code-pathsearch-path' => 'Pad:',
	'code-pathsearch-filter' => 'Wys net:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Outeur = $1',
	'code-revfilter-ct_tag' => 'Etiket = $1',
	'code-revfilter-clear' => 'Duidelike filter',
	'code-rev-submit' => 'Stoor wysigings',
	'code-rev-next' => 'Volgende onopgeloste',
	'code-batch-status' => 'Wysigingsstatus:',
	'code-batch-tags' => 'Change tags:',
	'codereview-batch-title' => 'Verander al die geselekteerde wysiging',
	'codereview-batch-submit' => 'Dien in',
	'code-releasenotes' => 'Vrystellingsnotas',
	'code-release-legend' => 'Genereer Release Notes',
	'code-release-startrev' => 'Eerste weergawe:',
	'code-release-endrev' => 'Laaste weergawe:',
	'codereview-subtitle' => 'Vir $1',
	'codereview-reply-link' => 'antwoord',
	'codereview-overview-title' => 'Oorsig',
	'codereview-overview-desc' => "Wys 'n grafiese oorsig van hierdie lys",
	'code-stats' => 'statistieke',
	'code-stats-status-breakdown' => 'Aantal hersienings per status',
	'code-stats-fixme-breakdown' => 'Uiteensetting van fixme wysigings per skrywer',
	'code-stats-fixme-breakdown-path' => 'Uiteensetting van fixme wysigings per pad',
	'code-stats-new-breakdown' => 'Uiteensetting van nuwe hersienings per skrywer',
	'code-stats-new-breakdown-path' => 'Uiteensetting van nuwe hersienings per pad',
	'code-stats-count' => 'Aantal weergawes',
	'code-tooltip-withsummary' => 'r$1 [$2] deur $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] deur $3',
	'repoadmin' => 'Repository Administrasie',
	'repoadmin-new-legend' => "Skep 'n nuwe repository",
	'repoadmin-new-label' => 'Repository naam:',
	'repoadmin-new-button' => 'Skep',
	'repoadmin-edit-path' => 'Opslagpad:',
	'repoadmin-edit-bug' => 'Bugzilla-pad:',
	'repoadmin-edit-view' => 'ViewVC-pad:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-nav' => 'repository administrasie',
	'right-repoadmin' => 'Bestuur Code Repositories',
	'right-codereview-add-tag' => 'Voeg nuwe tags aan die hersiening',
	'right-codereview-remove-tag' => 'Verwyder tags van die hersiening',
	'right-codereview-post-comment' => 'Lewer kommentaar oor die hersiening',
	'right-codereview-set-status' => 'Verander hersienings status',
	'right-codereview-link-user' => 'Link skrywers na die wiki gebruikers',
	'right-codereview-associate' => 'Bestuur hersiening verenigings',
	'right-codereview-review-own' => 'Merk jou eie hersienings as OK of opgelos',
	'specialpages-group-developer' => 'Developer Tools',
	'group-svnadmins' => 'SVN-administrateurs',
	'group-svnadmins-member' => 'SVN-administrateur',
);

/** Gheg Albanian (Gegë)
 * @author Mdupont
 */
$messages['aln'] = array(
	'code-rev-diff-link' => 'ndrysh',
	'code-rev-diff-too-large' => 'Ndryshimi është tepër i madh për të shfaqur.',
	'code-rev-purge-link' => 'spastrim',
	'code-rev-total' => 'Numri i përgjithshëm i rezultateve: $1',
	'code-status-new' => 'i ri',
	'code-status-fixme' => 'Rregullat e ndërprerjes',
	'code-status-reverted' => 'rikthyer',
	'code-status-resolved' => 'zgjidhet',
	'code-status-ok' => 'në rregull',
	'code-status-deferred' => 'i shtyrë',
	'code-pathsearch-legend' => 'shqyrtime Kërko në këtë repo nga rrugë',
	'code-pathsearch-path' => 'Path:',
	'code-pathsearch-filter' => 'Filter aplikuar:',
	'code-revfilter-cr_status' => 'Statusi = $1',
	'code-revfilter-cr_author' => 'Author = $1',
	'code-revfilter-clear' => 'Clear filter',
	'code-rev-submit' => 'Ruaj ndryshimet',
	'code-rev-submit-next' => 'Save & tjetër e pazgjidhur',
	'code-batch-status' => 'Gjendja Ndryshimi:',
	'code-batch-tags' => 'Ndryshimi tags:',
	'codereview-batch-title' => 'Ndryshimi gjitha versionet e zgjedhura',
	'codereview-batch-submit' => 'Submit',
	'code-releasenotes' => 'shënime lëshimi',
	'code-release-legend' => 'Shënime Generate lirimin',
	'code-release-startrev' => 'rev Fillimi:',
	'code-release-endrev' => 'rev fundit:',
	'codereview-subtitle' => 'Për $1',
	'codereview-reply-link' => 'përgjigje',
	'codereview-email-subj' => '[$1 $2]: koment i ri shtuar',
	'codereview-email-body' => 'User "$1" postuar nje koment mbi $3. Plotë URL: $2 Komenti: $4',
	'codereview-email-subj2' => 'Ndryshime [$1 $2]: Ndiqni-up',
	'codereview-email-body2' => 'User "$1" bërë ndjekjen ndryshime tek $2. Plotë URL: $3 përmbledhje angazhohen: $4',
	'codereview-email-subj3' => '[$1 $2]: testimi automatik i zbuluar regresionit',
	'codereview-email-body3' => 'Testimi automatik i ka zbuluar një regres për shkak të ndryshimeve në $1. plotë URL: $2 përmbledhje angazhohen: $3',
	'repoadmin' => 'Depo Administrata',
	'repoadmin-new-legend' => 'Krijo një depo të re',
	'repoadmin-new-label' => 'Emri depo:',
	'repoadmin-new-button' => 'Krijo',
	'repoadmin-edit-legend' => 'Modifikimi i depo "$1"',
	'repoadmin-edit-path' => 'rrugën depo:',
	'repoadmin-edit-bug' => 'rrugën Bugzilla:',
	'repoadmin-edit-view' => 'rrugën ViewVC:',
	'repoadmin-edit-button' => 'Në rregull',
);

/** Amharic (አማርኛ)
 * @author Codex Sinaiticus
 */
$messages['am'] = array(
	'code-rev-message' => 'ማጠቃለያ:',
	'code-status-new' => 'አዲስ',
	'code-status-ok' => 'እሺ',
	'repoadmin-edit-button' => 'እሺ',
);

/** Aragonese (Aragonés)
 * @author Juanpabl
 */
$messages['an'] = array(
	'code' => 'Revisión de codigo',
	'code-comments' => 'Comentarios',
	'code-change-status' => "ha cambiato o ''estato'' de $1",
	'code-change-tags' => "han cambiato as '''etiquetas''' de $1",
	'code-change-removed' => 'sacato:',
	'code-change-added' => 'adhibito:',
	'code-prop-changes' => "Rechistro d'estatos y etiquetache (tagging)",
	'codereview-desc' => '[[Special:Code|Ferramienta de revisión de codigo]] [[Special:RepoAdmin|compatible con Subversion]]',
	'code-no-repo' => 'No bi ha garra reposte confegurato!',
	'code-notes' => 'comentarios recients',
	'code-authors' => 'autors',
	'code-tags' => 'etiquetas',
	'code-authors-text' => "Contino s'amuestra una lista d'autors d'o reposte ordenaus seguntes o nombre. As cuentas de wiki locals s'amuestran entre parentesis. Pare cuenta que os datos pueden dimanar d'una memoria chaché.",
	'code-author-haslink' => "Iste autor ye vinculau con l'usuario d'o wiki $1",
	'code-author-orphan' => "Iste autor no tien vinclos con garra cuenta d'o wiki",
	'code-author-dolink' => "Enlace iste autor con usuario d'o wiki:",
	'code-author-alterlink' => "Cambiar o usuario d'o wiki vinculato con iste autor:",
	'code-author-orunlink' => "O desvincule iste usuario d'o wiki:",
	'code-author-name' => "Escriba un nombre d'usuario:",
	'code-author-success' => "S'ha vinculau l'autor $1 con l'usuario d'o wiki $2",
	'code-author-link' => 'vincular?',
	'code-author-unlink' => 'esvincular?',
	'code-author-unlinksuccess' => "L'autor $1 s'ha esvinculato",
	'code-field-id' => 'Versión',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentador',
	'code-field-message' => 'Resumen de publicación:',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Calendata',
	'code-field-comments' => 'Comentarios',
	'code-field-path' => 'Camín',
	'code-field-text' => 'Nota',
	'code-rev-date' => 'Calendata:',
	'code-rev-comment-preview' => 'Previsualizar',
	'code-rev-inline-preview' => 'Previsualización:',
	'code-status-reverted' => 'revertito',
	'code-status-ok' => "D'alcuerdo",
	'codereview-batch-submit' => 'Ninviar',
	'codereview-email-body' => 'L\'usuario "$1" publicó un comentario en $3

URL completo: $2

Comentario:

$4',
	'repoadmin' => "Almenistración d'o reposte",
	'repoadmin-new-legend' => 'Creyar un nuevo reposte',
	'repoadmin-new-label' => "Nombre d'o reposte:",
	'repoadmin-new-button' => 'Creyar',
	'repoadmin-edit-legend' => 'Cambeos en o reposte "$1"',
	'repoadmin-edit-path' => "Camín d'o reposte",
	'repoadmin-edit-bug' => 'Camín de Bugzilla:',
	'repoadmin-edit-view' => 'Camín de ViewVC:',
	'repoadmin-edit-button' => "D'alcuerdo",
	'repoadmin-edit-sucess' => 'O reposte "[[Special:Code/$1|$1]]" s\'ha modificato correutament.',
	'right-repoadmin' => 'Chestionar repostes de codigo',
	'right-codereview-add-tag' => 'Adhibir nuevas etiquetas a las versions',
	'right-codereview-remove-tag' => "Sacar etiquetas d'as versions",
	'right-codereview-post-comment' => "Adhibir comentarios t'as versions",
	'right-codereview-set-status' => "Cambiar o status d'as revisions",
	'right-codereview-link-user' => "Bincular os autors con os usuarios d'o wiki",
);

/** Arabic (العربية)
 * @author ;Hiba;1
 * @author AwamerT
 * @author Meno25
 * @author OsamaK
 * @author زكريا
 */
$messages['ar'] = array(
	'code' => 'مراجعة الكود',
	'code-rev-title' => 'ن$1 - مراجعة الكود',
	'code-comments' => 'ملاحظات المراجعة',
	'code-references' => 'مراجعات ملحقة',
	'code-change-status' => "غير '''حالة''' ن$1",
	'code-change-tags' => "غير '''الوسوم''' لن$1",
	'code-change-removed' => 'أزال:',
	'code-change-added' => 'أضاف:',
	'code-old-status' => 'الحالة القديمة',
	'code-new-status' => 'الحالة الجديدة',
	'code-prop-changes' => 'سجل الحالة والوسم',
	'codereview-desc' => '[[Special:Code|أداة مراجعة الكود]] مع [[Special:RepoAdmin|دعم ساب فيرجن]]',
	'code-no-repo' => 'لا مستودع تم ضبطه!',
	'code-create-repo' => 'اطلب [[خاص:مستودع الإداريين|مستودع الإداريين]] لإنشاء مستودع',
	'code-need-repoadmin-rights' => 'حقوق مستودع الإداريين مطلوبة لتمكن من إنشاء مستودع',
	'code-need-group-with-rights' => 'لا توجد مجموعة لها حقوق لمستودع الإداريين. أضف واحدة للتمكن من إضافة مستودع جديد',
	'code-repo-not-found' => "مستودع '''$1''' غير موجود!",
	'code-load-diff' => 'جاري تحميل الفرق...',
	'code-notes' => 'التعليقات الحديثة',
	'code-statuschanges' => 'تغييرات الحالة',
	'code-mycommits' => 'التزاماتي',
	'code-mycomments' => 'تعليقاتي',
	'code-authors' => 'مؤلفون',
	'code-status' => 'الحالات',
	'code-tags' => 'وسوم',
	'code-tags-no-tags' => 'ما بهذا المستودع من وسوم.',
	'code-authors-text' => 'بالأسفل قائمة بمؤلفي المستودع حسب تاريخ عمليات الكوميت. حسابات الويكي المحلية معروضة بين أقواس. البيانات ربما تكون مخزنة.',
	'code-author-haslink' => 'هذا المؤلف موصول بمستخدم الويكي $1',
	'code-author-orphan' => 'مستخدم SVN/المؤلف $1 ليست له وصلة بحساب ويكي',
	'code-author-dolink' => 'صل هذا المؤلف بمستخدم ويكي :',
	'code-author-alterlink' => 'غير مستخدم الويكي الموصول لهذا المؤلف:',
	'code-author-orunlink' => 'أو أزل وصل مستخدم الويكي هذا:',
	'code-author-name' => 'أدخل اسم مستخدم:',
	'code-author-success' => 'المؤلف $1 تم وصله بنجاح بمستخدم الويكي $2',
	'code-author-link' => 'وصلة؟',
	'code-author-unlink' => 'أزل الوصلة؟',
	'code-author-unlinksuccess' => 'المؤلف $1 تمت إزالة وصله',
	'code-author-badtoken' => 'خطأ في جلسة أثناء محاولة تنفيذ هذا الفعل.',
	'code-author-total' => 'مجمل المؤلفين: $1',
	'code-author-lastcommit' => 'تاريخ آخر التزام',
	'code-browsing-path' => "تصفح المراجعات في '''$1'''",
	'code-field-id' => 'مراجعة',
	'code-field-author' => 'مؤلف',
	'code-field-user' => 'معلق',
	'code-field-message' => 'ملخص الكوميت',
	'code-field-status' => 'حالة',
	'code-field-status-description' => 'وصف الحالة',
	'code-field-timestamp' => 'تاريخ',
	'code-field-comments' => 'تعليقات',
	'code-field-path' => 'مسار',
	'code-field-text' => 'ملاحظة',
	'code-field-select' => 'اختر',
	'code-reference-remove' => 'حذف اقترانات مختارة',
	'code-reference-associate' => 'اقتران المراجعة الملحقة:',
	'code-reference-associate-submit' => 'اقتران',
	'code-rev-author' => 'مؤلف:',
	'code-rev-date' => 'التاريخ:',
	'code-rev-message' => 'تعليق:',
	'code-rev-repo' => 'مستودع:',
	'code-rev-rev' => 'مراجعة:',
	'code-rev-rev-viewvc' => 'على فيو في سي',
	'code-rev-paths' => 'مسارات معدلة:',
	'code-rev-modified-a' => 'تمت إضافته',
	'code-rev-modified-r' => 'تم استبداله',
	'code-rev-modified-d' => 'تم حذفه',
	'code-rev-modified-m' => 'تم تعديله',
	'code-rev-imagediff' => 'تغييرات الصورة',
	'code-rev-status' => 'حالة:',
	'code-rev-status-set' => 'تغيير الحالة',
	'code-rev-tags' => 'وسوم:',
	'code-rev-tag-add' => 'إضافة وسوم:',
	'code-rev-tag-remove' => 'أزل الوسوم:',
	'code-rev-comment-by' => 'تعليق بواسطة $1',
	'code-rev-comment-preview' => 'عاين',
	'code-rev-inline-preview' => 'معاينة:',
	'code-rev-diff' => 'فرق',
	'code-rev-diff-link' => 'فرق',
	'code-rev-diff-too-large' => 'الفرق أكبر من أن يُعرض.',
	'code-rev-purge-link' => 'إفراغ الكاش',
	'code-rev-total' => 'مجموع عدد النتائج: $1',
	'code-rev-not-found' => "'''$1''' مراجعة غير موجودة!",
	'code-rev-history-link' => 'تاريخ',
	'code-status-new' => 'جديد',
	'code-status-desc-new' => 'مراجعة بانتظار إجراء (وضع افتراضي).',
	'code-status-fixme' => 'أصلحني',
	'code-status-desc-fixme' => 'المراجعة مكسورة أو بها خلل. ينبغي إصلاحها أو استرجاع التي قبلها.',
	'code-status-reverted' => 'تم استرجاعها',
	'code-status-desc-reverted' => 'رفضت المراجعة في مراجعة من بعدها.',
	'code-status-resolved' => 'تم حلها',
	'code-status-desc-resolved' => 'المراجعة كان بها مشكل أصلح في مراجعة من بعدها',
	'code-status-ok' => 'موافق',
	'code-status-desc-ok' => 'المراجعة تامة والمراجع على يقين من صحتها بجميع الأحوال.',
	'code-status-deferred' => 'مؤجل',
	'code-status-desc-deferred' => 'المراجعة لا يلزمها تنقيح.',
	'code-status-old' => 'قديم',
	'code-status-desc-old' => 'مراجعة قديمة يحتمل وجود خلل بها لكنه يتطلب تنقيحا.',
	'code-signoffs' => 'موافقات',
	'code-signoff-legend' => 'أضف موافقة',
	'code-signoff-submit' => 'وافق',
	'code-signoff-strike' => 'سطر على الموافقات المعينة',
	'code-signoff-signoff' => 'وافق على هذه المراجعة أنها:',
	'code-signoff-flag-inspected' => 'فحص',
	'code-signoff-flag-tested' => 'اختبر',
	'code-signoff-field-user' => 'مستخدم',
	'code-signoff-field-flag' => 'مؤشر',
	'code-signoff-field-date' => 'تاريخ',
	'code-signoff-struckdate' => '$1 (سطر على $2)',
	'code-pathsearch-legend' => 'ابحث في النسخ في هذا المستودع بواسطة المسار',
	'code-pathsearch-path' => 'المسار:',
	'code-pathsearch-filter' => 'لا تظهر إلا:',
	'code-revfilter-cr_status' => 'الحالة = $1',
	'code-revfilter-cr_author' => 'المؤلف = $1',
	'code-revfilter-ct_tag' => 'الوسم = $1',
	'code-revfilter-clear' => 'أفرغ المرشح',
	'code-rev-submit' => 'احفظ التغييرات',
	'code-rev-submit-next' => 'احفظ وغير المحلولة التالية',
	'code-rev-next' => 'المشكلة التالية',
	'code-batch-status' => 'غير الحالة:',
	'code-batch-tags' => 'غير الوسوم:',
	'codereview-batch-title' => 'غير كل المراجعات المختارة',
	'codereview-batch-submit' => 'أرسل',
	'code-releasenotes' => 'ملاحظات الإصدار',
	'code-release-legend' => 'توليد ملاحظات الإصدار',
	'code-release-startrev' => 'مراجعة البداية:',
	'code-release-endrev' => 'آخر مراجعة:',
	'codereview-subtitle' => 'ل$1',
	'codereview-reply-link' => 'رد',
	'codereview-overview-title' => 'نظرة عامة',
	'codereview-overview-desc' => 'أظهر نظرة عامة رسومية على هذه القائمة',
	'codereview-email-subj' => '[$1 $2]: تعليق جديد تمت إضافته',
	'codereview-email-body' => 'المستخدم "$1" كتب تعليقا على $3.

المسار الكامل: $2
ملخص الكوميت:

$5

التعليق:

$4',
	'codereview-email-subj2' => '[$1 $2]: تغييرات ملحقة',
	'codereview-email-body2' => 'المستخدم "$1" قام بتغييرات ملحقة ب$2.

المسار الكامل للمراجعة الملحقة: $5
ملخص الكوميت:

$6

المسار الكامل: $3

ملخص الكوميت:

$4',
	'codereview-email-subj3' => '[$1 $2]: حالة المراجعة تغيرت',
	'codereview-email-body3' => 'المستخدم "$1" غير حالة $2.

الحالة القديمة: $3
الحالة الجديدة: $4

المسار الكامل: $5
ملخص الكوميت:

$6',
	'codereview-email-subj4' => '[$1 $2]: أضيف تعليق جديد، وتغيرت حالة المراجعة',
	'codereview-email-body4' => 'المستخدم "$1" غير حالة $2.

حالة قديمة: $3
حالة جديدة: $4

كما نشر المستخدم "$1" تعليقا على $2.

العنوان الكامل: $5
ملخص الالتزام:

$7

تعليق:

$6',
	'code-stats' => 'إحصاءات',
	'code-stats-header' => 'إحصاءات مستودع $1',
	'code-stats-main' => 'في $1، بالمستودع $2 {{PLURAL:$2|مراجعة|مراجعةً}} من [[Special:Code/$3/author|$4 {{PLURAL:$4|مؤلف|مؤلفا}}]].',
	'code-stats-status-breakdown' => 'عدد المراجعات حسب الحالة',
	'code-stats-fixme-breakdown' => 'تصنيف المراجعات المستصلحة بحسب المؤلف',
	'code-stats-fixme-breakdown-path' => 'تصنيف المراجعات المستصلحة بحسب المؤلف',
	'code-stats-fixme-path' => 'المراجعات المستصلحة للؤلف: $1',
	'code-stats-new-breakdown' => 'تصنيف المراجعات الجديدة بحسب المؤلف',
	'code-stats-count' => 'عدد المراجعات',
	'code-tooltip-withsummary' => 'r$1 [$2] من $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] من $3',
	'repoadmin' => 'إدارة المستودع',
	'repoadmin-new-legend' => 'إنشاء مستودع جديد',
	'repoadmin-new-label' => 'اسم المستودع:',
	'repoadmin-new-button' => 'أنشئ',
	'repoadmin-edit-legend' => 'تعديل المستودع "$1"',
	'repoadmin-edit-path' => 'مسار المستودع:',
	'repoadmin-edit-bug' => 'مسار بجزيللا:',
	'repoadmin-edit-view' => 'مسار فيو في سي:',
	'repoadmin-edit-button' => 'موافق',
	'repoadmin-edit-sucess' => 'المستودع "[[Special:Code/$1|$1]]" تم تعديله بنجاح.',
	'repoadmin-nav' => 'إدارة المستودع',
	'right-repoadmin' => 'التحكم بمستودعات الكود',
	'right-codereview-use' => 'استخدام Special:Code',
	'right-codereview-add-tag' => 'إضافة وسوم جديدة للمراجعات',
	'right-codereview-remove-tag' => 'إزالة الوسوم من المراجعات',
	'right-codereview-post-comment' => 'إضافة تعليقات على المراجعات',
	'right-codereview-set-status' => 'تغيير حالة المراجعات',
	'right-codereview-signoff' => 'وافق على المراجعات',
	'right-codereview-link-user' => 'وصل المؤلفين لمستخدمي الويكي',
	'right-codereview-associate' => 'تدبير اقترانات المراجعات',
	'right-codereview-review-own' => 'أعلم بأن مراجعاتك الخاصة موفقة أو محلولة',
	'specialpages-group-developer' => 'أدوات المطورين',
	'group-svnadmins' => 'إداريو SVN',
	'group-svnadmins-member' => 'إداري SVN',
	'grouppage-svnadmins' => '{{ns:project}}:إداريو SVN',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 * @author Michaelovic
 */
$messages['arc'] = array(
	'code-old-status' => 'ܐܝܟܢܝܘܬܐ ܥܬܝܩܬܐ',
	'code-new-status' => 'ܐܝܟܢܝܘܬܐ ܚܕܬܐ',
	'code-authors' => 'ܣܝܘܡ̈ܐ',
	'code-author-name' => 'ܐܥܠ ܫܡܐ ܕܡܦܠܚܢܐ:',
	'code-field-id' => 'ܬܢܝܬܐ',
	'code-field-author' => 'ܣܝܘܡܐ',
	'code-field-status' => 'ܐܝܟܢܝܘܬܐ',
	'code-field-timestamp' => 'ܣܝܩܘܡܐ',
	'code-field-path' => 'ܫܒܝܠܐ',
	'code-rev-author' => 'ܣܝܘܡܐ:',
	'code-rev-date' => 'ܣܝܩܘܡܐ:',
	'code-rev-rev' => 'ܬܢܝܬܐ:',
	'code-rev-modified-a' => 'ܐܘܣܦܬ',
	'code-rev-modified-d' => 'ܫܝܦܬ',
	'code-rev-status' => 'ܐܝܟܢܝܘܬܐ:',
	'code-rev-comment-preview' => 'ܚܝܪܐ ܩܕܡܝܐ',
	'code-rev-inline-preview' => 'ܚܝܪܐ ܩܕܡܝܐ:',
	'code-rev-diff' => 'ܦܪܝܫܘܬܐ',
	'code-rev-diff-link' => 'ܦܪܝܫܘܬܐ',
	'code-status-new' => 'ܚܕܬܐ',
	'code-status-ok' => 'ܛܒ',
	'code-status-old' => 'ܥܬܝܩܐ',
	'code-pathsearch-path' => 'ܫܒܝܠܐ:',
	'code-revfilter-cr_status' => 'ܐܝܟܢܝܘܬܐ = $1',
	'code-revfilter-cr_author' => 'ܣܝܘܡܐ = $1',
	'code-rev-submit' => 'ܠܒܘܟ ܫܘܚܠܦ̈ܐ',
	'code-batch-status' => 'ܫܚܠܦ ܐܝܟܢܝܘܬܐ:',
	'codereview-batch-submit' => 'ܫܕܪ',
	'code-stats-count' => 'ܡܢܝܢܐ ܕܬܢܝܬ̈ܐ',
	'repoadmin-new-button' => 'ܒܪܝ',
	'repoadmin-edit-button' => 'ܛܒ',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'code' => 'مراجعة الكود',
	'code-comments' => 'ملاحظات المراجعة',
	'code-change-status' => "غير '''حالة''' ن$1",
	'code-change-tags' => "غير '''الوسوم''' لن$1",
	'code-change-removed' => 'اتشالت:',
	'code-change-added' => 'اتحطت:',
	'code-prop-changes' => 'سجل الحالة و التاجينج',
	'codereview-desc' => '[[Special:Code|أداة مراجعة الكود]] مع [[Special:RepoAdmin|دعم ساب فيرجن]]',
	'code-no-repo' => 'مافيش  مستودع اضبطت!',
	'code-load-diff' => 'تحميل التغيير...',
	'code-notes' => 'ملاحظات التغيير',
	'code-authors' => 'مؤلفون',
	'code-status' => 'الحالات',
	'code-tags' => 'وسوم',
	'code-authors-text' => 'بالأسفل قائمة بمؤلفى المستودع حسب تاريخ عمليات الكوميت. حسابات الويكى المحلية معروضة بين أقواس.',
	'code-author-haslink' => 'المؤلف ده موصول بيوزر الويكى $1',
	'code-author-orphan' => 'هذا المؤلف ليس له وصلة لحساب ويكى',
	'code-author-dolink' => 'وصل المؤلف ده بيوزر ويكى :',
	'code-author-alterlink' => 'غير يوزر الويكى الموصول للمؤلف ده:',
	'code-author-orunlink' => 'أو امسح وصل يوزر الويكى  ده:',
	'code-author-name' => 'أدخل اسم يوزر:',
	'code-author-success' => 'المؤلف $1 تم وصله بنجاح بيوزر الويكى $2',
	'code-author-link' => 'وصلة؟',
	'code-author-unlink' => 'أزل الوصلة؟',
	'code-author-unlinksuccess' => 'المؤلف $1 تمت إزالة وصله',
	'code-field-id' => 'مراجعة',
	'code-field-author' => 'مؤلف',
	'code-field-user' => 'معلق',
	'code-field-message' => 'ملخص الكوميت',
	'code-field-status' => 'حالة',
	'code-field-timestamp' => 'تاريخ',
	'code-field-comments' => 'ملاحظات',
	'code-field-path' => 'مسار',
	'code-field-text' => 'ملاحظة',
	'code-rev-author' => 'مؤلف:',
	'code-rev-date' => 'التاريخ:',
	'code-rev-message' => 'تعليق:',
	'code-rev-repo' => 'مستودع:',
	'code-rev-rev' => 'مراجعة:',
	'code-rev-rev-viewvc' => 'على فيو فى سى',
	'code-rev-paths' => 'مسارات معدلة:',
	'code-rev-modified-a' => 'تمت إضافته',
	'code-rev-modified-r' => 'تم استبداله',
	'code-rev-modified-d' => 'تم حذفه',
	'code-rev-modified-m' => 'تم تعديله',
	'code-rev-status' => 'حالة:',
	'code-rev-status-set' => 'تغيير الحالة',
	'code-rev-tags' => 'وسوم:',
	'code-rev-tag-add' => 'إضافة وسوم:',
	'code-rev-tag-remove' => 'أزل الوسوم:',
	'code-rev-comment-by' => 'تعليق بواسطة $1',
	'code-rev-comment-preview' => 'عرض مسبق',
	'code-rev-diff' => 'فرق',
	'code-rev-diff-link' => 'فرق',
	'code-rev-purge-link' => 'إفراغ الكاش',
	'code-status-new' => 'جديد',
	'code-status-fixme' => 'أصلحنى',
	'code-status-reverted' => 'استرجعت',
	'code-status-resolved' => 'تم حلها',
	'code-status-ok' => 'موافق',
	'code-status-deferred' => 'مؤجل',
	'code-pathsearch-legend' => 'ابحث فى النسخ فى هذا المستودع بواسطة المسار',
	'code-pathsearch-path' => 'المسار:',
	'code-rev-submit' => 'تنفيذ التعديلات',
	'code-rev-submit-next' => 'تنفيذ واللى قبل كده مش محلول',
	'code-releasenotes' => 'ملاحظات الإصدار',
	'code-release-legend' => 'توليد ملاحظات الإصدار',
	'code-release-startrev' => 'مراجعة البداية:',
	'code-release-endrev' => 'آخر مراجعة:',
	'codereview-subtitle' => 'لـ $1',
	'codereview-reply-link' => 'رد',
	'codereview-email-subj' => '[$1 $2]: تعليق جديد تمت إضافته',
	'codereview-email-body' => 'اليوزر "$1" كتب تعليق على $3.

المسار الكامل: $2

التعليق:

$4',
	'repoadmin' => 'إدارة المستودع',
	'repoadmin-new-legend' => 'إنشاء مستودع جديد',
	'repoadmin-new-label' => 'اسم المستودع:',
	'repoadmin-new-button' => 'إنشاء',
	'repoadmin-edit-legend' => 'تعديل المستودع "$1"',
	'repoadmin-edit-path' => 'مسار المستودع:',
	'repoadmin-edit-bug' => 'مسار بجزيللا:',
	'repoadmin-edit-view' => 'مسار فيو فى سى:',
	'repoadmin-edit-button' => 'موافق',
	'repoadmin-edit-sucess' => 'المستودع "[[Special:Code/$1|$1]]" تم تعديله بنجاح.',
	'right-repoadmin' => 'التحكم بمستودعات الكود',
	'right-codereview-add-tag' => 'إضافة وسوم جديدة للمراجعات',
	'right-codereview-remove-tag' => 'إزالة الوسوم من المراجعات',
	'right-codereview-post-comment' => 'إضافة تعليقات على المراجعات',
	'right-codereview-set-status' => 'تغيير حالة المراجعات',
	'right-codereview-link-user' => 'وصل المؤلفين ليوزرز الويكى',
	'specialpages-group-developer' => 'أدوات المطورين',
);

/** Azerbaijani (Azərbaycanca)
 * @author Cekli829
 * @author Vago
 */
$messages['az'] = array(
	'code-comments' => 'Şərhlər',
	'code-change-removed' => 'çıxarılıb:',
	'code-change-added' => 'əlavə olunub:',
	'code-old-status' => 'Qədim status',
	'code-new-status' => 'Yeni status',
	'code-authors' => 'müəlliflər',
	'code-author-link' => 'keçid?',
	'code-field-author' => 'Müəllif',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Tarix',
	'code-field-comments' => 'Şərhlər',
	'code-field-text' => 'Qeyd',
	'code-rev-author' => 'Müəllif:',
	'code-rev-date' => 'Tarix:',
	'code-rev-message' => 'Şərhlər:',
	'code-rev-rev' => 'Dəyişiklik:',
	'code-rev-modified-a' => 'əlavə olunub',
	'code-rev-modified-r' => 'dəyişdirilib',
	'code-rev-status' => 'Status:',
	'code-rev-diff' => 'Fərq',
	'code-status-new' => 'yeni',
	'code-status-ok' => 'ok',
	'code-status-old' => 'qədim',
	'code-signoff-field-user' => 'İstifadəçi',
	'code-signoff-field-flag' => 'Bayraq',
	'code-signoff-field-date' => 'Tarix',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Müəllif = $1',
	'code-rev-submit' => 'Dəyişiklikləri yadda saxla',
	'codereview-batch-submit' => 'Təsdiq et',
	'codereview-subtitle' => '$1 üçün',
	'code-stats' => 'statistikalar',
	'repoadmin-edit-button' => 'OK',
);

/** Bashkir (Башҡортса)
 * @author Assele
 * @author Haqmar
 */
$messages['ba'] = array(
	'code' => 'Кодты тикшереү',
	'code-rev-title' => '$1 -Кодты тикшереү',
	'code-comments' => 'Аңлатмалар',
	'code-references' => 'Артабанғы өлгөләр',
	'code-change-status' => "$1 '''торошон''' үҙгәрткән",
	'code-change-tags' => "$1 '''билдәһен''' үҙгәрткән",
	'code-change-removed' => 'юйылған:',
	'code-change-added' => 'өҫтәлгән:',
	'code-old-status' => 'Иҫке торошо',
	'code-new-status' => 'Яңы торошо',
	'code-prop-changes' => 'Тороштар һәм билдәләр яҙмалары журналы',
	'codereview-desc' => '[[Special:RepoAdmin|Subversion ҡулланыусы]] [[Special:Code|Кодты тикшереү ҡоралы]]',
	'code-no-repo' => 'Көйләнгән һаҡлағыс юҡ!',
	'code-create-repo' => 'Һаҡлағыс булдырыу өсөн, [[Special:RepoAdmin|RepoAdmin]]-ға керегеҙ',
	'code-need-repoadmin-rights' => 'Һаҡлағыс булдырыу өсөн repoadmin хоҡуҡтары кәрәк',
	'code-need-group-with-rights' => 'Repoadmin хоҡуҡтары булған төркөм юҡ. Зинһар, яңы һаҡлағыс булдырыу өсөн, шундай төркөм булдырығыҙ',
	'code-repo-not-found' => "'''$1''' һаҡлағысы юҡ!",
	'code-load-diff' => 'Сағыштырыуҙы сығарыу...',
	'code-notes' => 'һуңғы аңлатмалар',
	'code-statuschanges' => 'торошто үҙгәртеүҙәр',
	'code-mycommits' => 'минең тапшырыуҙарым (commit)',
	'code-mycomments' => 'минең аңлатмаларым',
	'code-authors' => 'авторҙар',
	'code-status' => 'тороштар',
	'code-tags' => 'билдәләр',
	'code-tags-no-tags' => 'Был һаҡлағыста билдәләр юҡ.',
	'code-authors-text' => 'Түбәндә — исемдәре буйынса тәртипкә килтерелгән һаҡлағыс авторҙарының исемлеге. Урындағы вики иҫәп яҙмалары йәйә эсендә күрһәтелгән. Был мәғлүмәт кэшланған булыуы мөмкин.',
	'code-author-haslink' => 'Был автор $1 ҡатнашыусыһына бәйләнгән',
	'code-author-orphan' => 'Был автор бер вики иҫәп яҙмаһына ла бәйләмәгән',
	'code-author-dolink' => 'Был авторҙы вики ҡатнашыусыһына бәйләргә:',
	'code-author-alterlink' => 'Был авторға бәйләнгән  вики ҡатнашыусыһын үҙгәртергә:',
	'code-author-orunlink' => 'йәки был вики ҡатнашыусыға бәйҙе кире алырға:',
	'code-author-name' => 'Ҡатнашыусы исемен керетерегеҙ:',
	'code-author-success' => '$1 авторы $2 вики ҡатнашыусыһына уңышлы бәйләнде',
	'code-author-link' => 'бәйләргәме?',
	'code-author-unlink' => 'бәйҙе кире алырғамы?',
	'code-author-unlinksuccess' => '$1 авторының бәйе кире алынды',
	'code-author-badtoken' => 'Ғәмәлде башҡарыу ваҡытында сессия хатаһы.',
	'code-author-total' => 'Авторҙарҙың дөйөм һаны: $1',
	'code-author-lastcommit' => 'Һуңғы тапшырыу (commit) көнө',
	'code-browsing-path' => "'''$1''' эсендә өлгөләрҙе ҡарау",
	'code-field-id' => 'Өлгө',
	'code-field-author' => 'Автор',
	'code-field-user' => 'Иҫкәрмә яһаусы',
	'code-field-message' => 'Тапшырыу (commit) тасуирламаһы',
	'code-field-status' => 'Торошо',
	'code-field-status-description' => 'Тороштоң тасуирламаһы',
	'code-field-timestamp' => 'Көнө',
	'code-field-comments' => 'Иҫкәрмәләр',
	'code-field-path' => 'Юл',
	'code-field-text' => 'Иҫкәрмә',
	'code-field-select' => 'Һайларға',
	'code-reference-remove' => 'Һайланған бәйләнештәрҙе юйырға',
	'code-reference-associate' => 'Киләһе өлгөнө бәйләргә:',
	'code-reference-associate-submit' => 'Бәйләргә',
	'code-rev-author' => 'Автор:',
	'code-rev-date' => 'Көнө:',
	'code-rev-message' => 'Иҫкәрмә:',
	'code-rev-repo' => 'Һаҡлағыс:',
	'code-rev-rev' => 'Өлгө:',
	'code-rev-rev-viewvc' => 'ViewVC аша',
	'code-rev-paths' => 'Үҙгәртелгән юлдар:',
	'code-rev-modified-a' => 'өҫтәлгән',
	'code-rev-modified-r' => 'алыштырылған',
	'code-rev-modified-d' => 'юйылған',
	'code-rev-modified-m' => 'үҙгәртелгән',
	'code-rev-imagediff' => 'Рәсемдәге үҙгәрештәр',
	'code-rev-status' => 'Торошо:',
	'code-rev-status-set' => 'Торошто үҙгәртергә',
	'code-rev-tags' => 'Билдәләр:',
	'code-rev-tag-add' => 'Билдәләр өҫтәргә:',
	'code-rev-tag-remove' => 'Билдәләрҙе алырға:',
	'code-rev-comment-by' => '$1 исемле ҡулланыусынан аңлатма',
	'code-rev-comment-preview' => 'Алдан байҡау',
	'code-rev-inline-preview' => 'Алдан байҡау:',
	'code-rev-diff' => 'Айыр.',
	'code-rev-diff-link' => 'айыр.',
	'code-rev-diff-too-large' => 'Өлгөләр араһындағы айырмалар күрһәтеп булмаҫлыҡ ҙур.',
	'code-rev-purge-link' => 'таҙартырға',
	'code-rev-total' => 'Һөҙөмтәләрҙең дөйөм һаны: $1',
	'code-rev-not-found' => "'''$1''' өлгөһө юҡ!",
	'code-status-new' => 'яңы',
	'code-status-desc-new' => 'Өлгө ғәмәлде көтә (ғәҙәттәге торош).',
	'code-status-fixme' => 'төҙәтергә кәрәк',
	'code-status-desc-fixme' => 'Тикшереүсе был өлгөлә хата барлығын йәки боҙолоуын билдәләгән. Уны төҙәтергә кәрәк.',
	'code-status-reverted' => 'кире алынған',
	'code-status-desc-reverted' => 'Өлгө һуңғыраҡ өлгөлә кире алынған',
	'code-status-resolved' => 'төҙәтелгән',
	'code-status-desc-resolved' => 'Өлгөлә хата булған, һәм ул хата һуңғыраҡ өлгөлә төҙәтелгән.',
	'code-status-ok' => 'тамам',
	'code-status-desc-ok' => 'Өлгө тулыһынса тикшерелгән һәм тикшереүсе уның бар яҡтан да яҡшы булыуын раҫлай.',
	'code-status-deferred' => 'кисектерелгән',
	'code-status-desc-deferred' => 'Өлгө тикшереүҙе талап итмәй.',
	'code-status-old' => 'иҫке',
	'code-status-desc-old' => 'Иҫке өлгө, хаталар менән булыуы ихтимал, уларҙы тикшереү өсөн көс сарыф итеп тоторға кәрәкмәй.',
	'code-signoffs' => 'Раҫлауҙар',
	'code-signoff-legend' => 'Раҫлау өҫтәү',
	'code-signoff-submit' => 'Раҫларға',
	'code-signoff-strike' => 'Һайланған раҫлауҙарҙы һыҙып ташларға',
	'code-signoff-signoff' => 'Был өлгөнө түбәндәге рәүештә раҫларға:',
	'code-signoff-flag-inspected' => 'Тикшерелгән',
	'code-signoff-flag-tested' => 'Һыналған',
	'code-signoff-field-user' => 'Ҡатнашыусы',
	'code-signoff-field-flag' => 'Тамға',
	'code-signoff-field-date' => 'Көнө',
	'code-signoff-struckdate' => '$1 ($2 һыҙып ташлаған)',
	'code-pathsearch-legend' => 'Был һаҡлағыста адрестары буйынса өлгөләрҙе эҙләү',
	'code-pathsearch-path' => 'Юл:',
	'code-pathsearch-filter' => 'Ҡулланылған фильтр:',
	'code-revfilter-cr_status' => 'Торош = $1',
	'code-revfilter-cr_author' => 'Автор = $1',
	'code-revfilter-clear' => 'Фильтрҙы таҙаларға',
	'code-rev-submit' => 'Үҙгәрештәрҙе һаҡларға',
	'code-rev-submit-next' => 'Һаҡларға һәм киләһе төҙәтелмәгәнде асырға',
	'code-batch-status' => 'Торошто үҙгәртергә:',
	'code-batch-tags' => 'Билдәләрҙе үҙгәртергә:',
	'codereview-batch-title' => 'Һайланған бар өлгөләрҙе үҙгәртергә',
	'codereview-batch-submit' => 'Ебәрергә',
	'code-releasenotes' => 'сығарылыш аңлатмалары',
	'code-release-legend' => 'Сығарылыш аңлатмаларын булдырырға',
	'code-release-startrev' => 'Башланғыс өлгө:',
	'code-release-endrev' => 'Һуңғы өлгө:',
	'codereview-subtitle' => '«$1» өсөн',
	'codereview-reply-link' => 'яуапларға',
	'codereview-email-subj' => '[$1 $2]: Яңы аңлатма өҫтәлде',
	'codereview-email-body' => '"$1" ҡулланыусыһы $3 өсөн аңлатма өҫтәне.

Тулы URL: $2
Ҡыҫҡаса тасуирлама:

$5

Аңлатма:

$4',
	'codereview-email-subj2' => '[$1] [r$2]: Артабанғы үҙгәрештәр',
	'codereview-email-body2' => '"$1" ҡатнашыусыһы $2 өлгөһөнә артабанғы үҙгәрештәр кереткән.

Алдағы өлгөнөң тулы URL адресы: $5
Ҡыҫҡаса тасуирлама:

$6

Тулы URL адрес: $3

Тапшырыу тасуирламаһы:

$4',
	'codereview-email-subj3' => '[$1 $2]: Өлгөнөң торошо үҙгәргән',
	'codereview-email-body3' => '"$1" ҡатнашыусыһы $2 өлгөһөнөң торошон үҙгәрткән.

Иҫке торошо: $3
Яңы торошо: $4

Тулы URL адрес: $5
Тапшырыу тасуирламаһы:

$6',
	'codereview-email-subj4' => '[$1 $2]: Яңы аңлатма өҫтәлгән һәм өлгөнөң торошо үҙгәргән',
	'codereview-email-body4' => '"$1" ҡатнашыусыһы $2 өлгөһөнөң торошон үҙгәркән.

Иҫке торошо: $3
Яңы торошо: $4

"$1" ҡатнашыусыһы шулай уҡ $2 өсөн аңлатма өҫтәгән.

Тулы URL: $5
Тапшырыу тасуирламаһы:

$7


Аңлатма:

$6',
	'code-stats' => 'статистика',
	'code-stats-header' => '$1 һаҡлағысы өсөн статистика',
	'code-stats-main' => '$1 һаҡлағыста [[Special:Code/$3/author|$4 {{PLURAL:$4|автор}}]] тарафынан тапшырылған $2 {{PLURAL:$2|өлгө}} бар.',
	'code-stats-status-breakdown' => 'Һәр торошҡа өлгөләр',
	'code-stats-fixme-breakdown' => '"Үҙгәртергә кәрәк" торошло өлгөләрҙе авторҙарға бүлеү',
	'code-stats-new-path' => '$1 адресы өсөн яңы үҙгәрештәр',
	'code-stats-count' => 'Өлгөләр һаны',
	'code-tooltip-withsummary' => 'r$1 [$2] $3 — $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] $3',
	'repoadmin' => 'Һаҡлағыс менән идара итеү',
	'repoadmin-new-legend' => 'Яңы һаҡлағыс булдырырға',
	'repoadmin-new-label' => 'Һаҡлағыстың исеме:',
	'repoadmin-new-button' => 'Яһарға',
	'repoadmin-edit-legend' => '"$1" һаҡлағысын үҙгәртеү',
	'repoadmin-edit-path' => 'Һаҡлағыс юлы:',
	'repoadmin-edit-bug' => 'Bugzilla юлы:',
	'repoadmin-edit-view' => 'ViewVC юлы:',
	'repoadmin-edit-button' => 'Тамам',
	'repoadmin-edit-sucess' => '"[[Special:Code/$1|$1]]" һаҡлағысы уңышлы үҙгәртелде.',
	'repoadmin-nav' => 'һаҡлағыс менән идара итеү',
	'right-repoadmin' => 'Кодтар һаҡлағыстары менән идара итеү',
	'right-codereview-use' => 'Special:Code ҡулланыу',
	'right-codereview-add-tag' => 'Өлгөләргә билдәләр өҫтәү',
	'right-codereview-remove-tag' => 'Өлгөләрҙән билдәләрҙе юйыу',
	'right-codereview-post-comment' => 'Өлгөләргә аңлатмалар өҫтәү',
	'right-codereview-set-status' => 'Өлгөләрҙең торошон үҙгәртеү',
	'right-codereview-signoff' => 'Өлгөләрҙе раҫлау',
	'right-codereview-link-user' => 'Авторҙарҙы вики ҡатнашыусыларға бәйләү',
	'right-codereview-associate' => 'Өлгөләрҙе бәйләү менән идара итеү',
	'specialpages-group-developer' => 'Программист ҡоралдары',
	'group-svnadmins' => 'SVN идарасылары',
	'group-svnadmins-member' => '{{GENDER:$1|SVN администраторы}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN идарасылары',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'code' => 'باز بینی کد',
	'code-comments' => 'توضیح',
	'code-change-removed' => 'زورگ:',
	'code-change-added' => 'هوربیت:',
	'code-notes' => 'بازدید نکته',
	'code-authors' => 'نویسوکان',
	'code-tags' => 'برچسپ',
	'code-author-name' => 'نوکین کاربری نام وارد کن:',
	'code-field-author' => 'نویسوک',
	'code-field-user' => 'نظر دیوک',
	'code-field-message' => 'خلاصه دیم دیگ',
	'code-field-status' => 'وضعیت',
	'code-field-timestamp' => 'تاریح',
	'code-field-comments' => 'یادداشت',
	'code-field-path' => 'جاه',
	'code-field-text' => 'نکته',
	'code-rev-author' => 'نویسوک:',
	'code-rev-date' => 'تاریح:',
	'code-rev-message' => 'توضیح:',
	'code-rev-repo' => 'مخزن:',
	'code-rev-rev' => 'نسخه:',
	'code-rev-modified-a' => 'هوربوت',
	'code-rev-modified-r' => 'جاه په جاه بوت',
	'code-rev-modified-d' => 'حذف بوت',
	'code-rev-modified-m' => 'عوض بوت',
	'code-status-new' => 'نوکین',
	'code-status-reverted' => 'ترینگ',
	'code-status-resolved' => 'حل بیتت',
	'code-status-ok' => 'هوبنت',
	'code-pathsearch-path' => 'جاه:',
	'code-rev-submit' => 'ذخیره تغییرات',
	'code-rev-submit-next' => 'ذخیره کتن و روگ په دگه حل نه بوتگین',
	'codereview-reply-link' => 'جواب',
	'repoadmin' => 'مدیریت مخزن',
	'repoadmin-new-legend' => 'شرکتن یک نوکین مخزن',
	'repoadmin-new-label' => 'مخزن نام:',
	'repoadmin-new-button' => 'شرکتن',
	'repoadmin-edit-button' => 'هوبنت',
	'specialpages-group-developer' => 'وسایل پیشبروک',
);

/** Belarusian (Беларуская)
 * @author Тест
 */
$messages['be'] = array(
	'code-field-author' => 'Аўтар',
	'code-rev-author' => 'Аўтар:',
	'code-revfilter-cr_author' => 'Аўтар = $1',
	'code-stats' => 'статыстыка',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Renessaince
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'code' => 'Рэцэнзаваньне коду',
	'code-rev-title' => '$1 - Рэцэнзаваньне коду',
	'code-comments' => 'Камэнтары',
	'code-references' => 'Наступныя вэрсіі',
	'code-referenced' => 'Папярэднія вэрсіі',
	'code-change-status' => "зьменены '''статус''' вэрсіі $1",
	'code-change-tags' => "зьмененыя '''тэгі''' вэрсіі $1",
	'code-change-removed' => 'выдалена:',
	'code-change-added' => 'дададзена:',
	'code-old-status' => 'Папярэдні статус',
	'code-new-status' => 'Новы статус',
	'code-prop-changes' => 'Журнал зьменаў статусаў і тэгаў',
	'codereview-desc' => '[[Special:Code|Інструмэнт рэцэнзаваньня коду]] з [[Special:RepoAdmin|падтрымкай Subversion]]',
	'code-no-repo' => 'Адсутнічае сканфігураванае сховішча!',
	'code-create-repo' => 'Перайсьці ў [[Special:RepoAdmin|RepoAdmin]] для стварэньня рэпазыторыя.',
	'code-need-repoadmin-rights' => 'для стварэньня рэпазыторыя патрэбныя правы repoadmin',
	'code-need-group-with-rights' => 'Ніводнай групе не нададзеныя правы repoadmin. Калі ласка, надайце правы для стварэньня рэпазыторыя.',
	'code-repo-not-found' => "Сховішча '''$1''' не існуе!",
	'code-load-diff' => 'Загрузка розьніцы…',
	'code-notes' => 'апошнія камэнтары',
	'code-statuschanges' => 'зьмены статусу',
	'code-mycommits' => 'мае зьмены коду',
	'code-mycomments' => 'мае камэнтары',
	'code-authors' => 'аўтары',
	'code-status' => 'станы',
	'code-tags' => 'тэгі',
	'code-tags-no-tags' => 'Няма тэгаў у гэтым сховішчы.',
	'code-authors-text' => 'Ніжэй пададзены сьпіс аўтараў сховішча ўпарадкаваны па імёнах. Рахункі лякальнай вікі паказаныя ў дужках. Гэтыя зьвесткі могуць быць кэшавая.',
	'code-author-haslink' => 'Гэты аўтар асацыяваны з удзельнікам $1',
	'code-author-orphan' => 'Карыстальнік SVN/аўтар $1 ня мае спасылкі на рахунак удзельніка вікі',
	'code-author-dolink' => 'Стварыць спасылку на рахунак удзельніка вікі для гэтага аўтара:',
	'code-author-alterlink' => 'Зьмяніць рахунак удзельніка вікі для гэтага аўтара:',
	'code-author-orunlink' => 'Ці выдаліць спасылку на рахунак удзельніка вікі:',
	'code-author-name' => 'Увядзіце імя ўдзельніка:',
	'code-author-success' => 'Спасылка на рахунак удзельніка вікі $2 для аўтара $1 была створаная',
	'code-author-link' => 'стварыць спасылку?',
	'code-author-unlink' => 'выдаліць спасылку?',
	'code-author-unlinksuccess' => 'Спасылка на рахунак удзельніка вікі для аўтара $1 была выдаленая',
	'code-author-badtoken' => 'Памылка сэсіі падчас выкананьня.',
	'code-author-total' => 'Агульная колькасьць аўтараў: $1',
	'code-author-lastcommit' => 'Дата апошняга запісу',
	'code-browsing-path' => "Прагляд вэрсіяў у '''$1'''",
	'code-field-id' => 'Вэрсія',
	'code-field-author' => 'Аўтар',
	'code-field-user' => 'Аўтар камэнтара',
	'code-field-message' => 'Кароткае апісаньне зьменаў',
	'code-field-status' => 'Статус',
	'code-field-status-description' => 'Апісаньне статусу',
	'code-field-timestamp' => 'Дата',
	'code-field-comments' => 'Камэнтары',
	'code-field-path' => 'Шлях',
	'code-field-text' => 'Камэнтар',
	'code-field-select' => 'Выбраць',
	'code-reference-remove' => 'Выдаліць абраныя вэрсіі',
	'code-reference-associate' => 'Прывязаць наступную вэрсію:',
	'code-reference-associate-submit' => 'Прывязаць',
	'code-rev-author' => 'Аўтар:',
	'code-rev-date' => 'Дата:',
	'code-rev-message' => 'Камэнтар:',
	'code-rev-repo' => 'Сховішча:',
	'code-rev-rev' => 'Вэрсія:',
	'code-rev-rev-viewvc' => 'на ViewVC',
	'code-rev-paths' => 'Спасылкі на зьмены:',
	'code-rev-modified-a' => 'дададзена',
	'code-rev-modified-r' => 'замененая',
	'code-rev-modified-d' => 'выдалена',
	'code-rev-modified-m' => 'зьменена',
	'code-rev-imagediff' => 'Зьмены выявы:',
	'code-rev-status' => 'Статус:',
	'code-rev-status-set' => 'Зьмяніць статус',
	'code-rev-tags' => 'Тэгі:',
	'code-rev-tag-add' => 'Дадаць тэгі:',
	'code-rev-tag-remove' => 'Выдаліць тэгі:',
	'code-rev-comment-by' => 'Камэнтар $1',
	'code-rev-comment-preview' => 'Папярэдні прагляд',
	'code-rev-inline-preview' => 'Папярэдні прагляд:',
	'code-rev-diff' => 'Зьмена',
	'code-rev-diff-link' => 'зьмена',
	'code-rev-diff-too-large' => 'Розьніца занадта вялікая для паказу.',
	'code-rev-purge-link' => 'ачысьціць кэш',
	'code-rev-total' => 'Агульная колькасьць вынікаў: $1',
	'code-rev-not-found' => "Вэрсія '''$1''' не існуе!",
	'code-rev-history-link' => 'гісторыя',
	'code-status-new' => 'новая',
	'code-status-desc-new' => 'Вэрсія чакае дзеяньня (статус па змоўчваньні).',
	'code-status-fixme' => 'выправіць',
	'code-status-desc-fixme' => 'Новая вэрсія ўтрымлівае памылку ці сапсаваная. Яна мусіць быць выпраўленая ці скасаваная.',
	'code-status-reverted' => 'адмененая',
	'code-status-desc-reverted' => 'Вэрсія была замененая больш позьняю.',
	'code-status-resolved' => 'вырашаная',
	'code-status-desc-resolved' => 'Вэрсія мае праблему, якая была выпраўленая ў больш позьняй вэрсіі.',
	'code-status-ok' => 'добра',
	'code-status-desc-ok' => 'Вэрсія поўнасьцю рэцанзаваная і рэцэнзэнт упэўнены, што яна выдатная ва ўсіх адносінах.',
	'code-status-deferred' => 'адкладзены',
	'code-status-desc-deferred' => 'Вэрсія не патрабуе рэцэнзаваньня.',
	'code-status-old' => 'састарэлы',
	'code-status-desc-old' => 'Старая вэрсія з патэнцыйнымі памылкамі, на разгляд якіх ня варта траціць высілкі.',
	'code-signoffs' => 'Зацьвержданьні',
	'code-signoff-legend' => 'Зацьвердзіць',
	'code-signoff-submit' => 'Зацьвердзіць',
	'code-signoff-strike' => 'Закрэсьліць выбраныя зацьверджаньні',
	'code-signoff-signoff' => 'Зацьвердзіць гэтую вэрсію як:',
	'code-signoff-flag-inspected' => 'Праінспэктаваны',
	'code-signoff-flag-tested' => 'Пратэставаны',
	'code-signoff-field-user' => 'Распрацоўшчык',
	'code-signoff-field-flag' => 'Сьцяг',
	'code-signoff-field-date' => 'Дата',
	'code-signoff-struckdate' => '$1 (закрэсьленая $2)',
	'code-pathsearch-legend' => 'Пошук у гэтым сховішчы вэрсіяў па іх адрасе',
	'code-pathsearch-path' => 'Шлях:',
	'code-pathsearch-filter' => 'Паказваць толькі:',
	'code-revfilter-cr_status' => 'Статус = $1',
	'code-revfilter-cr_author' => 'Аўтар = $1',
	'code-revfilter-ct_tag' => 'Тэг = $1',
	'code-revfilter-clear' => 'Ачысьціць фільтар',
	'code-rev-submit' => 'Захаваць зьмены',
	'code-rev-submit-next' => 'Захаваць і перайсьці да наступнай зьмены',
	'code-rev-next' => 'Наступная нявырашаная',
	'code-batch-status' => 'Зьмяніць статус:',
	'code-batch-tags' => 'Зьмяніць тэгі:',
	'codereview-batch-title' => 'Зьмяніць усе выбраныя вэрсіі',
	'codereview-batch-submit' => 'Захаваць',
	'code-releasenotes' => 'заўвагі да выпуску',
	'code-release-legend' => 'Стварыць заўвагі да выпуску',
	'code-release-startrev' => 'Пачатковая вэрсія:',
	'code-release-endrev' => 'Апошняя вэрсія:',
	'codereview-subtitle' => 'Для $1',
	'codereview-reply-link' => 'адказаць',
	'codereview-overview-title' => 'Агляд',
	'codereview-overview-desc' => 'Паказаць графічны агляд гэтага сьпісу',
	'codereview-email-subj' => '[$1 $2]: Дададзены новы камэнтар',
	'codereview-email-body' => 'Удзельнік «$1» дадаў камэнтар для $3.

Поўны URL-адрас: $2
Кароткае апісаньне зьменаў:

$5

Камэнтар:

$4',
	'codereview-email-subj2' => '[$1 $2]: Наступныя зьмены',
	'codereview-email-body2' => 'Карыстальнік «$1» зрабіў наступныя зьмены ў $2.

Поўны URL-адрас папярэдняй вэрсіі: $5
Кароткае апісаньне зьменаў:

$6

Поўны URL-адрас: $3

Кароткае апісаньне зьменаў:

$4',
	'codereview-email-subj3' => '[$1 $2]: Статус вэрсіі зьменены',
	'codereview-email-body3' => 'Карыстальнік «$1» зьмяніў статус $2.

Стары статус: $3
Новы статус: $4

URL-адрас: $5
Кароткае апісаньне зьменаў:

$6',
	'codereview-email-subj4' => '[$1 $2]: Дададзены новы камэнтар, статус вэрсіі зьменены',
	'codereview-email-body4' => 'Удзельнік «$1» зьмяніў статус $2.

Стары статус: $3
Новы статус: $4

Удзельнік «$1» таксама пакінуў камэнтар у $2.

Поўны URL-адрас: $5
Кароткае апісаньне зьменаў:

$7

Камэнтар:

$6',
	'code-stats' => 'статыстыка',
	'code-stats-header' => 'Статыстыка для сховішча $1',
	'code-stats-main' => 'На $1 ў сховішчы {{PLURAL:$2|утрымліваецца $2 вэрсія|утрымліваюцца $2 вэрсіі|утрымліваюцца $2 вэрсіяў}} [[Special:Code/$3/author|$4 {{PLURAL:$4|аўтара|аўтараў|аўтараў}}]].',
	'code-stats-status-breakdown' => 'Колькасьць вэрсіяў па станах',
	'code-stats-fixme-breakdown' => 'Разьмеркаваньне вэрсіяў з запытамі на выпраўленьне па аўтарах',
	'code-stats-fixme-breakdown-path' => 'Разьмеркаваньне вэрсіяў з запытамі на выпраўленьне па шляхах',
	'code-stats-fixme-path' => 'Вэрсіі з запытамі на выпраўленьне для шляху: $1',
	'code-stats-new-breakdown' => 'Разьмеркаваньне новых вэрсіяў па аўтарах',
	'code-stats-new-breakdown-path' => 'Разьмеркаваньне новых вэрсіяў па шляхах',
	'code-stats-new-path' => 'Новыя вэрсіі для шляху: $1',
	'code-stats-count' => 'Колькасьць вэрсіяў',
	'code-tooltip-withsummary' => 'r$1 [$2] $3 — $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] $3',
	'repoadmin' => 'Кіраваньне сховішчам коду',
	'repoadmin-new-legend' => 'Стварыць новае сховішча',
	'repoadmin-new-label' => 'Назва сховішча:',
	'repoadmin-new-button' => 'Стварыць',
	'repoadmin-edit-legend' => 'Зьмяненьне сховішча «$1»',
	'repoadmin-edit-path' => 'Шлях да сховішча:',
	'repoadmin-edit-bug' => 'Адрас Bugzilla:',
	'repoadmin-edit-view' => 'Адрас ViewVC:',
	'repoadmin-edit-button' => 'Добра',
	'repoadmin-edit-sucess' => 'Сховішча «[[Special:Code/$1|$1]]» было пасьпяхова зьменена.',
	'repoadmin-nav' => 'кіраваньне сховішчам',
	'right-repoadmin' => 'кіраваньне сховішчамі коду',
	'right-codereview-use' => 'выкарыстаньне Special:Code',
	'right-codereview-add-tag' => 'дадаваньне новых тэгаў да зьменаў',
	'right-codereview-remove-tag' => 'выдаленьне тэгаў са зьменаў',
	'right-codereview-post-comment' => 'даданьне камэнтараў да вэрсіяў',
	'right-codereview-set-status' => 'зьмена статусу вэрсіяў',
	'right-codereview-signoff' => 'зацьверджаньне вэрсіяў',
	'right-codereview-link-user' => 'даданьне да аўтараў спасылак на рахункі ўдзельнікаў вікі',
	'right-codereview-associate' => 'кіраваньне сувязямі вэрсіяў',
	'right-codereview-review-own' => 'пазначэньне ўласных вэрсіяў як «{{int:code-status-ok}}» ці «{{int:code-status-resolved}}»',
	'action-repoadmin' => 'кіраваньне сховішчамі коду',
	'action-codereview-use' => 'выкарыстаньне Special:Code',
	'action-codereview-add-tag' => 'даданьне новых тэгаў да вэрсіі',
	'action-codereview-remove-tag' => 'выдаленьне тэгаў з вэрсіяў',
	'action-codereview-post-comment' => 'даданьне камэнтараў да вэрсіяў',
	'action-codereview-set-status' => 'зьмену статусу вэрсіяў',
	'action-codereview-signoff' => 'зацьверджаньне вэрсіяЎ',
	'action-codereview-link-user' => 'даданьне да аўтараў спасылак на рахункі ўдзельнікаў вікі',
	'action-codereview-associate' => 'кіраваньне сувязямі вэрсіяў',
	'action-codereview-review-own' => 'пазначэньне ўласных вэрсіяў як «{{int:code-status-ok}}» ці «{{int:code-status-resolved}}»',
	'specialpages-group-developer' => 'Інструмэнты распрацоўшчыка',
	'group-svnadmins' => 'Адміністратары SVN',
	'group-svnadmins-member' => '{{GENDER:$1|Адміністратар SVN|Адміністратарка SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Адміністратары SVN',
);

/** Bulgarian (Български)
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'code' => 'Преглед на кода',
	'code-rev-title' => '$1 - Преглед на кода',
	'code-comments' => 'Коментари',
	'code-change-status' => "промени '''състоянието''' на $1",
	'code-change-tags' => "промени '''етикетите''' за $1",
	'code-change-removed' => 'премахнато:',
	'code-change-added' => 'добавено:',
	'code-old-status' => 'Старо състояние',
	'code-new-status' => 'Ново състояние',
	'codereview-desc' => '[[Special:Code|Инструмент за преглеждане на код]] с [[Special:RepoAdmin|поддръжка на Subversion]]',
	'code-no-repo' => 'Не е конфигурирано хранилище!',
	'code-need-repoadmin-rights' => 'За създаване на хранилище са необходими права на repoadmin',
	'code-repo-not-found' => "Хранилището '''$1''' не съществува!",
	'code-load-diff' => 'Зареждане на разлики...',
	'code-notes' => 'скорошни коментари',
	'code-statuschanges' => 'промени на състоянието',
	'code-mycomments' => 'моите коментари',
	'code-authors' => 'автори',
	'code-status' => 'състояния',
	'code-tags' => 'етикети',
	'code-tags-no-tags' => 'Няма етикети в това хранилище.',
	'code-author-haslink' => 'Този автор е свързан с уики потребителя $1',
	'code-author-orphan' => 'SVN потребител/автор $1 не е свързан с уики потребител',
	'code-author-dolink' => 'Свържете този автор с уики потребител:',
	'code-author-alterlink' => 'Променете името на уики потребителя, свързан с този автор:',
	'code-author-orunlink' => 'Или премахнете връзката към този уики потребител:',
	'code-author-name' => 'Въведете потребителско име:',
	'code-author-success' => 'Авторът $1 беше свързан с потребителя на уикито $2',
	'code-author-link' => 'да се сложи ли връзка?',
	'code-author-unlink' => 'да се премахне ли връзката?',
	'code-author-unlinksuccess' => 'Премахната връзката към автора $1',
	'code-author-badtoken' => 'Възникна сесийна грешка при опита да се изпълни това действие.',
	'code-author-total' => 'Общ брой автори: $1',
	'code-browsing-path' => "Преглед на редакциите на '''$1'''",
	'code-field-id' => 'Версия',
	'code-field-author' => 'Автор',
	'code-field-user' => 'Коментатор',
	'code-field-status' => 'Статут',
	'code-field-timestamp' => 'Дата',
	'code-field-comments' => 'Коментари',
	'code-field-path' => 'Път',
	'code-field-text' => 'Бележка',
	'code-field-select' => 'Избиране',
	'code-rev-author' => 'Автор:',
	'code-rev-date' => 'Дата:',
	'code-rev-message' => 'Коментар:',
	'code-rev-repo' => 'Хранилище:',
	'code-rev-rev' => 'Версия:',
	'code-rev-rev-viewvc' => 'във ViewVC',
	'code-rev-paths' => 'Променени пътища:',
	'code-rev-modified-a' => 'добавено',
	'code-rev-modified-r' => 'заместено',
	'code-rev-modified-d' => 'изтрито',
	'code-rev-modified-m' => 'променено',
	'code-rev-imagediff' => 'Промени в изображенията',
	'code-rev-status' => 'Статут:',
	'code-rev-status-set' => 'Промяна на статута',
	'code-rev-tags' => 'Етикети:',
	'code-rev-tag-add' => 'Добавяне на етикети:',
	'code-rev-tag-remove' => 'Премахване на етикети:',
	'code-rev-comment-by' => 'Коментар от $1',
	'code-rev-comment-preview' => 'Предварителен преглед',
	'code-rev-inline-preview' => 'Преглед:',
	'code-rev-diff' => 'Разлика',
	'code-rev-diff-link' => 'разлика',
	'code-rev-diff-too-large' => 'Разликовата препратка е твърде дълга, за да бъде показана.',
	'code-rev-purge-link' => 'изчистване',
	'code-rev-total' => 'Общ брой резултати: $1',
	'code-rev-not-found' => "Версия '''$1''' не съществува!",
	'code-rev-history-link' => 'история',
	'code-status-new' => 'ново',
	'code-status-fixme' => 'за поправка',
	'code-status-reverted' => 'върнато',
	'code-status-desc-reverted' => 'Редакцията е отменена в по-късна версия.',
	'code-status-resolved' => 'разрешено',
	'code-status-desc-resolved' => 'Редакцията съдържа проблем, който е поправен в по-късна версия.',
	'code-status-ok' => 'OK',
	'code-status-deferred' => 'отложено',
	'code-signoff-field-user' => 'Потребител',
	'code-signoff-field-date' => 'Дата',
	'code-pathsearch-legend' => 'Търсене на версии в това хранилище по път',
	'code-pathsearch-path' => 'Път:',
	'code-revfilter-cr_status' => 'Статут = $1',
	'code-revfilter-cr_author' => 'Автор = $1',
	'code-rev-submit' => 'Съхраняване на промените',
	'code-batch-status' => 'Промяна на статуса:',
	'code-batch-tags' => 'Промяна на етикетите:',
	'codereview-batch-title' => 'Промяна на всички маркирани редакции',
	'codereview-batch-submit' => 'Изпращане',
	'code-release-startrev' => 'Първа редакция:',
	'code-release-endrev' => 'Последна редакция:',
	'codereview-subtitle' => 'За $1',
	'codereview-reply-link' => 'отговаряне',
	'codereview-email-subj' => '[$1 $2]: Беше добавен нов коментар',
	'codereview-email-body' => 'Потребител „$1“ публикува коментар за $3.

Пълен адрес: $2

Коментар:

$4',
	'code-stats' => 'статистика',
	'code-stats-header' => 'Статистики за хранилище $1',
	'code-stats-main' => 'Считано към $1, базата данни съдържа $2 {{PLURAL:$2|версия|версии}}, направени от [[Special:Code/$3/author|$4 {{PLURAL:$4|автор|автора}}]].',
	'code-stats-status-breakdown' => 'Брой версии на състояние',
	'code-stats-count' => 'Брой версии',
	'repoadmin' => 'Администриране на хранилището',
	'repoadmin-new-legend' => 'Създаване на ново хранилище',
	'repoadmin-new-label' => 'Име на хранилището:',
	'repoadmin-new-button' => 'Създаване',
	'repoadmin-edit-legend' => 'Промяна на хранилището "$1"',
	'repoadmin-edit-path' => 'Път към хранилището:',
	'repoadmin-edit-bug' => 'Път до Bugzilla:',
	'repoadmin-edit-view' => 'Път до ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Хранилището „[[Special:Code/$1|$1]]“ беше променено успешно.',
	'repoadmin-nav' => 'администриране на хранилището',
	'right-repoadmin' => 'Управление на хранилищата с код',
	'right-codereview-use' => 'Употреба на Special:Code',
	'right-codereview-add-tag' => 'Добавяне на нови етикети към версиите',
	'right-codereview-remove-tag' => 'Премахване на етикети от версиите',
	'right-codereview-post-comment' => 'Добавяне на коментари към версиите',
	'right-codereview-set-status' => 'Променяне на статута на версиите',
	'right-codereview-link-user' => 'Свързване на имената на авторите с имена на уики потребители',
	'specialpages-group-developer' => 'Инструменти за разработчици',
	'group-svnadmins' => 'SVN администратори',
	'group-svnadmins-member' => '{{GENDER:$1|SVN администратор}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN администратори',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Wikitanvir
 */
$messages['bn'] = array(
	'code' => 'কোড পর্যবেক্ষণ',
	'code-rev-title' => '$1 - কোড পর্যবেক্ষণ',
	'code-comments' => 'মন্তব্য',
	'code-references' => 'পরবর্তীতে চালিয়ে যাওয়া সংস্করণসমূহ',
	'code-change-status' => "$1-এর '''অবস্থান''' পরিবর্তন করুন",
	'code-change-tags' => "$1-এর '''ট্যাগ''' পরিবর্তন করুন",
	'code-change-removed' => 'অপসারিত',
	'code-change-added' => 'সংযোজিত:',
	'code-old-status' => 'পুরোনো অবস্থান',
	'code-new-status' => 'নতুন অবস্থান',
	'code-prop-changes' => 'অবস্থান ও ট্যাগিং লগ',
	'codereview-desc' => '[[Special:RepoAdmin|সাবভার্সন সহায়তার]] সঙ্গে [[Special:Code|কোড রিভিউ সরঞ্জাম]]',
	'code-no-repo' => 'কোনো রিপোজিটরি কনফিগার করা হয়নি!',
	'code-create-repo' => 'রিপোজিটরি তৈরি করতে [[Special:RepoAdmin|রিপোঅ্যাডমিনে]] যান',
	'code-need-repoadmin-rights' => 'রিপোজিটরি তৈরি করার জন্য আপনার রিপোঅ্যাডমিন অধিকার প্রয়োজন',
	'code-need-group-with-rights' => 'রিপোঅ্যাডমিন অধিকার আছে এমন কোনো দল নেই। অনুগ্রহ করে এমন একটি যোগ করুন, যা নতুন রিপোজিটরি তৈরি করতে পারে',
	'code-repo-not-found' => "'''$1''' নামে কোনো রিপোজিটরি নেই!",
	'code-load-diff' => 'পার্থক্য লোড করা হচ্ছে...',
	'code-notes' => 'সাম্প্রতিক মন্তব্যসমূহ',
	'code-statuschanges' => 'অবস্থান পরিবর্তন',
	'code-mycommits' => 'আমার কমিটসমূহ',
	'code-mycomments' => 'আমার মন্তব্যসমূহ',
	'code-authors' => 'লেখক',
	'code-status' => 'অবস্থানসমূহ',
	'code-tags' => 'ট্যাগসমূহ',
	'code-tags-no-tags' => 'এই রিপোজিটরিতে কোনো ট্যাগ নেই।',
	'code-authors-text' => 'নিচে কমিট নাম অনুসারে রিপো প্রণেতার নাম দেওয়া হলো। স্থানীয় উইকি অ্যাকাউন্টের নাম বন্ধনীতে উল্লেখ করা হয়েছে। তারিখ ক্যাশে করা থাকতে পারে।',
	'code-author-haslink' => 'এই প্রণেতা উইকি ব্যবহারকারী $1 হিসেবে সংযোগকৃত',
	'code-author-orphan' => 'এই অ্যাকাউন্টটির কোনো উইকি অ্যাকাউন্টে সংযোগ নেই',
	'code-author-dolink' => 'এই প্রণেতাকে একটি উইকি ব্যবহারকারীতে সংযোগ প্রদান করুন:',
	'code-author-alterlink' => 'উইকি ব্যবহারকারীর সংযোগটি অথরে পরিবর্তন করুন:',
	'code-author-orunlink' => 'এই উইকি ব্যবহারকারীর সংযোগ বাতিল করুন:',
	'code-author-name' => 'ব্যবহারকারীর নাম লিখুন:',
	'code-author-success' => 'প্রণেতা $1-কে উইকি ব্যবহারকারী $2-এ সংযোগ প্রদান করা হয়েছে',
	'code-author-link' => 'সংযোগ?',
	'code-author-unlink' => 'সংযোগ বাতিল?',
	'code-author-unlinksuccess' => 'প্রণেতা $1-এর সংযোগ বাতিল করা হয়েছে',
	'code-author-badtoken' => 'সেশন ত্রুটি অ্যাকশনটি কার্যকর করার চেষ্টা করছে।',
	'code-author-total' => 'প্রণেতার মোট সংখ্যা: $1',
	'code-author-lastcommit' => 'সর্বশেষ কমিটের তারিখ',
	'code-browsing-path' => "'''$1'''-এর ভেতর সংস্করণগুলো ব্রাউজ করছি",
	'code-field-id' => 'সংস্করণ',
	'code-field-author' => 'লেখক:',
	'code-field-user' => 'মন্তব্যকারী',
	'code-field-message' => 'কমিট সারাংশ',
	'code-field-status' => 'অবস্থা',
	'code-field-status-description' => 'অবস্থানের বিবরণ',
	'code-field-timestamp' => 'তারিখ',
	'code-field-comments' => 'মন্তব্যসমূহ',
	'code-field-path' => 'পাথ',
	'code-field-text' => 'টীকা',
	'code-field-select' => 'নির্বাচন',
	'code-reference-remove' => 'নির্ধারিত অ্যাসোসিয়েশনগুলো বাতিল করো',
	'code-reference-associate' => 'কার্য-পরবর্তী সংস্করণগুলো সংযোজিত করো:',
	'code-reference-associate-submit' => 'অ্যাসোসিয়েট',
	'code-rev-author' => 'লেখক:',
	'code-rev-date' => 'তারিখ:',
	'code-rev-message' => 'মন্তব্য:',
	'code-rev-repo' => 'রিপোজিটরি:',
	'code-rev-rev' => 'সংস্করণ:',
	'code-rev-rev-viewvc' => 'ভিউভিসিতে দেখুন',
	'code-rev-paths' => 'পরিবর্তিত পাথসমূহ:',
	'code-rev-modified-a' => 'সংযোজিত',
	'code-rev-modified-r' => 'প্রতিস্থাপিত',
	'code-rev-modified-d' => 'অপসারিত',
	'code-rev-modified-m' => 'পরিবর্তিত',
	'code-rev-imagediff' => 'চিত্র পরিবর্তন',
	'code-rev-status' => 'অবস্থা:',
	'code-rev-status-set' => 'পরিবর্তনের অবস্থা',
	'code-rev-tags' => 'ট্যাগসমূহ:',
	'code-rev-tag-add' => 'ট্যাগ সংযোগ:',
	'code-rev-tag-remove' => 'ট্যাগ বাতিল:',
	'code-rev-comment-by' => '$1-এর মন্তব্য',
	'code-rev-comment-preview' => 'প্রাকদর্শন',
	'code-rev-inline-preview' => 'প্রাকদর্শন:',
	'code-rev-diff' => 'পার্থক্য',
	'code-rev-diff-link' => 'পার্থক্য',
	'code-rev-diff-too-large' => 'এই পরিবর্তনটি প্রদর্শনের জন্য অনেক বড়।',
	'code-rev-purge-link' => 'পার্জ',
	'code-rev-total' => 'ফলাফলের মোট সংখ্যা: $1',
	'code-rev-not-found' => "'''$1''' নামে কোনো সংস্করণ নেই!",
	'code-rev-history-link' => 'ইতিহাস',
	'code-status-new' => 'নতুন',
	'code-status-desc-new' => 'সংস্করণটি একটি অ্যাকশন মূলতবি রয়েছে (প্রাথমিক অবস্থা)।',
	'code-status-fixme' => 'ফিক্সমি',
	'code-status-desc-fixme' => 'একজন পর্যবেক্ষক এই সংস্করণটিতে বাগ রয়েছে বা ভাঙা হিসেব নির্ধারণ করেছে। এটি শুদ্ধ করা প্রয়োজন।',
	'code-status-reverted' => 'বাতিলকৃত',
	'code-status-desc-reverted' => 'সংস্করণটি পরবর্তী সংস্করণ দ্বারা বাতিল করা হয়েছে।',
	'code-status-resolved' => 'সমাধানকৃত',
	'code-status-desc-resolved' => 'সংস্করণটি একটি সমস্যা ছিলো যা পরবর্তী সংস্করণে উল্লেখ করা হয়েছে।',
	'code-status-ok' => 'ঠিক আছে',
	'code-status-desc-ok' => 'সংস্করণটি সম্পূর্ণ পরীক্ষিত এবং পর্যবেক্ষক নিশ্চিত যে এটি সব দিক দিয়ে ঠিক আছে।',
	'code-status-deferred' => 'পার্থক্যসূচক',
	'code-status-desc-deferred' => 'সংস্করণটির কোনো পরীক্ষণের প্রয়োজন নেই।',
	'code-status-old' => 'পুরাতন',
	'code-status-desc-old' => 'সম্ভাব্য বাগসহ পুরোনো সংস্করণ, কিন্তু এগুলোকে পরীক্ষা করা কোনো কার্যকর প্রচেষ্টা নয়।',
	'code-signoffs' => 'সাইন-অফ',
	'code-signoff-legend' => 'সাইন-অফ যোগ',
	'code-signoff-submit' => 'সাইন অফ',
	'code-signoff-strike' => 'নির্বাচিত সাইন-অফগুলো বাতিল করো',
	'code-signoff-signoff' => 'যে সংস্করণে সাইন অফ হয়েছে তা হচ্ছে:',
	'code-signoff-flag-inspected' => 'পর্যবেক্ষণকৃত',
	'code-signoff-flag-tested' => 'পরীক্ষিত',
	'code-signoff-field-user' => 'ব্যবহারকারী',
	'code-signoff-field-flag' => 'পতাকা',
	'code-signoff-field-date' => 'তারিখ',
	'code-pathsearch-legend' => 'রিপোতে পাথ অনুসারে সংস্করণ অনুসন্ধান করুন',
	'code-pathsearch-path' => 'পাথ:',
	'code-pathsearch-filter' => 'ফিল্টার প্রদান করা হয়েছে:',
	'code-revfilter-cr_status' => 'অবস্থান = $1',
	'code-revfilter-cr_author' => 'প্রণেতা = $1',
	'code-revfilter-clear' => 'ফিল্টার পরিস্কার',
	'code-rev-submit' => 'পরিবর্তন সংরক্ষণ',
	'code-batch-status' => 'অবস্থা পরিবর্তন',
	'code-batch-tags' => 'ট্যাগ পরিবর্তন:',
	'codereview-batch-title' => 'নির্বাচিত সকল সংস্করণ পরিবর্তন করুন',
	'codereview-batch-submit' => 'জমা দাও',
	'code-releasenotes' => 'রিলিজ টীকা',
	'code-release-legend' => 'রিলিজ টীকা তৈরি করুন',
	'code-release-startrev' => 'সংস্করণ শুরু:',
	'code-release-endrev' => 'শেষ সংস্করণ:',
	'codereview-subtitle' => '$1-এর জন্য',
	'codereview-reply-link' => 'উত্তর',
	'codereview-email-subj' => '[$1 $2]: নতুন মন্তব্য যোগ করা হয়েছে',
	'codereview-email-subj2' => '[$1 $2]: কার্য-পরবর্তী পরির্তন',
	'codereview-email-subj3' => '[$1 $2]: সংস্করণ অবস্থা পরিবর্তন',
	'codereview-email-subj4' => '[$1 $2]: নতুন মন্তব্য যোগ করা হয়েছে, এবং সংস্করণ অবস্থা পরিবর্তিত হয়েছে',
	'code-stats' => 'পরিসংখ্যান',
	'code-stats-header' => 'রিপোজিটরি $1-এর জন্য পরিসংখ্যান',
	'code-stats-status-breakdown' => 'প্রতিটি অবস্থায় সংস্করণের সংখ্যা',
	'code-stats-count' => 'সংস্করণের সংখ্যা',
	'repoadmin' => 'রিপোজিটরি প্রশাসন',
	'repoadmin-new-legend' => 'নতুন রিপোজিটরি তৈরি করুন',
	'repoadmin-new-label' => 'রিপোজিটরির নাম:',
	'repoadmin-new-button' => 'তৈরি',
	'repoadmin-edit-legend' => 'রিপোজিটরি "$1"-এর পরিবর্তন',
	'repoadmin-edit-path' => 'রিপোজিটরি পাথ:',
	'repoadmin-edit-bug' => 'বাগজিলা পাথ:',
	'repoadmin-edit-view' => 'ভিউভিসি পাথ:',
	'repoadmin-edit-button' => 'ঠিক আছে',
	'repoadmin-edit-sucess' => 'রিপোজিটরি "[[Special:Code/$1|$1]]" সফলভাবে পরিবর্তিত হয়েছে।',
	'repoadmin-nav' => 'রিপোজিটরি প্রশাসন',
	'right-repoadmin' => 'কোড রিপোজিটরি ব্যবস্থাপনা',
	'right-codereview-use' => 'বিশেষ: কোড-এর ব্যবহার',
	'right-codereview-add-tag' => 'সংস্করণে নতুন ট্যাগ যোগ করুন',
	'right-codereview-remove-tag' => 'সংস্করণ থেকে ট্যাগ অপসারণ করুন',
	'right-codereview-post-comment' => 'সংস্করণে মন্তব্য যোগ করুন',
	'right-codereview-set-status' => 'সংস্করণের অবস্থা পরিবর্তন করুন',
	'right-codereview-signoff' => 'সংস্করণের ওপর সাইন অফ করুন',
	'right-codereview-link-user' => 'উইকি ব্যবহারকারী হিসেবে প্রণেতার সংযোগ প্রদান করুন',
	'right-codereview-associate' => 'সংস্করণের অ্যাসোসিয়েশনগুলো ব্যবস্থাপনা করুন',
	'right-codereview-review-own' => 'আপনার নিজের সংস্করণ ঠিক হিসেবে চিহ্নিত করুন',
	'specialpages-group-developer' => 'ডেভলপারের সরঞ্জাম',
	'group-svnadmins' => 'এসভিএন প্রশাসক',
	'group-svnadmins-member' => 'এসভিএন প্রশাসক',
	'grouppage-svnadmins' => '{{ns:project}}:এসএভিএন প্রশাসক',
);

/** Breton (Brezhoneg)
 * @author Fohanno
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'code' => 'Adweladenn god',
	'code-rev-title' => '$1 - Adweladenn god',
	'code-comments' => 'Evezhiadennoù',
	'code-references' => 'Daveoù davet an adweladennoù',
	'code-referenced' => 'Adweladennoù heuliet',
	'code-change-status' => "en deus kemmet '''statud''' $1",
	'code-change-tags' => "en deus kemmet ar '''balizennoù''' evit $1",
	'code-change-removed' => 'dilamet :',
	'code-change-added' => 'ouzhpennet :',
	'code-old-status' => 'Statud kozh',
	'code-new-status' => 'Statud nevez',
	'code-prop-changes' => 'Marilh ar statudoù hag ar balizenniñ',
	'codereview-desc' => '[[Special:Code|Ostilh adwelet ar c\'hodoù]] gant ar [[Special:RepoAdmin|skor "Subversion"]]',
	'code-no-repo' => "N'eus ket a dastumlec'h kefluniet !",
	'code-create-repo' => "Mont da [[Special:RepoAdmin|RepoAdmin]] evit krouiñ ur c'havlec'h",
	'code-need-repoadmin-rights' => "Ezhomm zo eus aotre repoadmin evit gallout krouiñ ur c'havlec'h",
	'code-need-group-with-rights' => "N'eus strollad ebet gant repoadmin. Ouzhpennit unan evit gallout krouiñ ur c'havlec'h nevez",
	'code-repo-not-found' => "N'eus ket eus an dastumlec'h '''$1''' !",
	'code-load-diff' => "O kargañ an diforc'hioù...",
	'code-notes' => 'Evezhiadennoù diwezhañ',
	'code-statuschanges' => 'kemmoù statud',
	'code-mycommits' => 'va embannoù',
	'code-mycomments' => 'ma evezhiadennoù',
	'code-authors' => 'aozerien',
	'code-status' => 'statudoù',
	'code-tags' => 'balizennoù',
	'code-tags-no-tags' => "N'eus tikedenn ebet er sanailh-mañ",
	'code-authors-text' => "A-is ez emañ roll an aozerien zo er fiziad en urzh an embannadurioù diwezhañ. Merket eo kontoù ar wiki lec'hel etre krommelloù. Ar roadennoù a c'hell bezañ krubuilhet.",
	'code-author-haslink' => 'An oberour-mañ a zo liammet gant ar gont wiki $1',
	'code-author-orphan' => "N'eo ket liammet an implijer SVN/aozer $1 ouzh kont wiki ebet",
	'code-author-dolink' => "Liammañ an implijer-mañ gant un implijer wiki lec'hel :",
	'code-author-alterlink' => 'Kemmañ an implijer wiki liammet gant an implijer-mañ :',
	'code-author-orunlink' => 'pe diliammañ an implijer wiki-mañ :',
	'code-author-name' => 'Merkit un anv implijer :',
	'code-author-success' => 'An implijer $1 a zo bet liammet gant an implijer wiki $2',
	'code-author-link' => 'liammañ ?',
	'code-author-unlink' => 'diliammañ ?',
	'code-author-unlinksuccess' => 'Diliammet eo bet an aozer $1',
	'code-author-badtoken' => "Fazi en dalc'h e-ser seveniñ an ober-mañ.",
	'code-author-total' => 'Niver hollek a aozerien : $1',
	'code-author-lastcommit' => 'Deiziad ar bostadenn ziwezhañ',
	'code-browsing-path' => "Hentad an adweladennoù a-benn '''$1'''",
	'code-field-id' => 'Adweladenn',
	'code-field-author' => 'Aozer',
	'code-field-user' => 'Saver an evezhiadenn',
	'code-field-message' => 'Tamm diverrañ an embannadenn',
	'code-field-status' => 'Statud',
	'code-field-status-description' => 'Deskrivadur ar statud',
	'code-field-timestamp' => 'Deiziad',
	'code-field-comments' => 'Evezhiadennoù',
	'code-field-path' => 'Hent',
	'code-field-text' => 'Notenn',
	'code-field-select' => 'Diuzañ',
	'code-reference-remove' => 'Digenstrollañ an elfennoù diuzet',
	'code-reference-associate' => 'Kenstrollañ an adweladennoù da-heul',
	'code-reference-associate-submit' => 'Kenstrollañ',
	'code-rev-author' => 'Aozer :',
	'code-rev-date' => 'Deiziad :',
	'code-rev-message' => 'Evezhiadenn :',
	'code-rev-repo' => "Kavlec'h :",
	'code-rev-rev' => 'Adweladenn :',
	'code-rev-rev-viewvc' => 'war ViewVC',
	'code-rev-paths' => 'Hentoù bet kemmet :',
	'code-rev-modified-a' => 'ouzhpennet',
	'code-rev-modified-r' => "erlec'hiet",
	'code-rev-modified-d' => 'dilamet',
	'code-rev-modified-m' => 'kemmet',
	'code-rev-imagediff' => 'Kemmoù ar skeudenn',
	'code-rev-status' => 'Statud :',
	'code-rev-status-set' => 'Cheñch statud',
	'code-rev-tags' => 'Balizennoù :',
	'code-rev-tag-add' => 'Ouzhpennañ balizennoù :',
	'code-rev-tag-remove' => 'Dilemel balizennoù :',
	'code-rev-comment-by' => 'Evezhiadenn gant $1',
	'code-rev-comment-preview' => 'Rakwelet',
	'code-rev-inline-preview' => 'Rakwelet :',
	'code-rev-diff' => "Diforc'h",
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => "Re vras eo an diforc'h evit bezañ diskwelet",
	'code-rev-purge-link' => 'spurjañ',
	'code-rev-total' => "Niver hollek a zisoc'hoù : $1",
	'code-rev-not-found' => "N'eus ket eus an adweladenn '''$1''' !",
	'code-rev-history-link' => 'istor',
	'code-status-new' => 'nevez',
	'code-status-desc-new' => "Un oberiaden zo o c'hortoz evit an adweladenn-mañ (stad dre ziouer)",
	'code-status-fixme' => 'da zresañ',
	'code-status-desc-fixme' => 'Degaset ez eus bet un draen gant an adweladenn-mañ pe torret eo. Ret eo he reizhañ pe he dizober.',
	'code-status-reverted' => 'distaolet',
	'code-status-desc-reverted' => "Distaolet eo bet an adweladenn dre un adweladenn nevesoc'h.",
	'code-status-resolved' => 'diskoulmet',
	'code-status-desc-resolved' => "Ur gudenn a oa en adweladenn zo bet reizhet en un adweladenn nevesoc'h.",
	'code-status-ok' => 'mat eo',
	'code-status-desc-ok' => 'Adlennet-pizh eo bet an adweladenn hag asur eo an adlenner ez eo mat e pep keñver.',
	'code-status-deferred' => 'ampellet',
	'code-status-desc-deferred' => "N'eo ket dav adlenn an adweladenn.",
	'code-status-old' => 'kozh',
	'code-status-desc-old' => 'Adweladenn gozh dreinek evit doare met na dalvez ket ar boan bezañ adlennet.',
	'code-signoffs' => 'Aprouadennoù',
	'code-signoff-legend' => 'Ouzhpennañ un aprouadenn',
	'code-signoff-submit' => 'Aprouiñ',
	'code-signoff-strike' => 'Barrennañ an aprouadennoù diuzet',
	'code-signoff-signoff' => 'Aprouiñ an adweladenn-mañ :',
	'code-signoff-flag-inspected' => 'Ensellet',
	'code-signoff-flag-tested' => 'Amprouet',
	'code-signoff-field-user' => 'Implijer',
	'code-signoff-field-flag' => 'Banniel',
	'code-signoff-field-date' => 'Deiziad',
	'code-signoff-struckdate' => '$1 (en deus barrennet $2)',
	'code-pathsearch-legend' => "Klask adweladennoù en dastumlec'h dre an hent",
	'code-pathsearch-path' => 'Hent moned :',
	'code-pathsearch-filter' => 'Diskouez hepken :',
	'code-revfilter-cr_status' => 'Statud = $1',
	'code-revfilter-cr_author' => 'Aozer = $1',
	'code-revfilter-ct_tag' => 'Tikedenn = $1',
	'code-revfilter-clear' => 'Diverkañ ar sil',
	'code-rev-submit' => "Enrollañ ar c'hemmoù",
	'code-rev-submit-next' => "Enrollañ & kudenn war-lerc'h",
	'code-rev-next' => 'An hini diziskoulm da-heul',
	'code-batch-status' => 'Kemmañ ar statud :',
	'code-batch-tags' => 'Kemmañ ar balizennoù :',
	'codereview-batch-title' => 'Kemmañ an holl adweladennoù diuzet',
	'codereview-batch-submit' => 'Kas',
	'code-releasenotes' => 'notennoù embann',
	'code-release-legend' => 'Genel an notennoù embann',
	'code-release-startrev' => 'Adweladenn penn-kentañ :',
	'code-release-endrev' => 'Aweladenn ziwezhañ :',
	'codereview-subtitle' => 'Evit $1',
	'codereview-reply-link' => 'respont',
	'codereview-overview-title' => 'Brassell',
	'codereview-overview-desc' => 'Diskwel ur sell grafikel hollek eus ar roll-mañ',
	'codereview-email-subj' => '[$1 $2] : evezhiadenn nevez bet ouzhpennet',
	'codereview-email-body' => 'Lakaet en deus an implijer "$1" un evezhiadenn war $3.

URL klok : $2
Diverrañ ar c\'hemm :

$5

Evezhiadenn :

$4',
	'codereview-email-subj2' => "[$1 $2] : Heuliadenn ar c'hemm",
	'codereview-email-body2' => 'Degaset ez eus bet kemmoù liammet ouzh $2 gant an implijer "$1".

URL klok da heuliañ an adweladenn : $5
Diverran eus ar c\'hemmoù :

$6

URL klok : $3
Diverrañ eus ar c\'hemmoù :

$4',
	'codereview-email-subj3' => '[$1 $2] : cheñchet en deus stad ar stumm',
	'codereview-email-body3' => 'Kemmet eo bet statud $2 gant an implijer "$1".

Statud kozh : $3
Stadud nevez : $4

URL klok : $5
Diverrañ eus ar c\'hemmoù :

$6',
	'codereview-email-subj4' => '[$1 $2]: Evezhiadenn nevez ouzhpennet, ha cheñchet statud ar sutmm',
	'codereview-email-body4' => 'Kemmet eo bet statud $2 gant an implijer "$1".

Statud kozh : $3
Statud nevez : $4

Postet ez eus bet un evezhiadenn war $2 gant an implijer "$1" ivez.

URL klok : $5
Diverrañ eus ar c\'hemmoù :

$7

Evezhiadenn :

$6',
	'code-stats' => 'stadegoù',
	'code-stats-header' => 'Stadegoù evit ar sanailh $1',
	'code-stats-main' => "D'an deiziad $1, an dastummlec'h en doa $2 {{PLURAL:$2|adweladenn|adweladenn}} gant [[Special:Code/$3/author|$4 {{PLURAL:$4|oberour|oberour}}]].",
	'code-stats-status-breakdown' => 'Niver a adweladennoù dre stad',
	'code-stats-fixme-breakdown' => 'Dasparzh an adweladennoù da reizhañ dre aozer',
	'code-stats-fixme-breakdown-path' => 'Dasparzh ar seurtoù adweladennoù dre hent',
	'code-stats-fixme-path' => 'Adweladennoù ar reizhadennoù evit an hent : $1',
	'code-stats-new-breakdown' => 'Dasparzh an adweladennoù nevez dre aozer',
	'code-stats-new-breakdown-path' => 'Dasparzh an adweladennoù nevez dre hent',
	'code-stats-new-path' => 'Adweladennoù nevez evit an hent : $1',
	'code-stats-count' => 'Niver a adweladennoù',
	'code-tooltip-withsummary' => 'r$1 [$2] gant $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] gant $3',
	'repoadmin' => "Melestradurezh an dastumlec'hioù",
	'repoadmin-new-legend' => 'Krouiñ ur sanailh nevez',
	'repoadmin-new-label' => 'Anv ar sanailh :',
	'repoadmin-new-button' => 'Krouiñ',
	'repoadmin-edit-legend' => 'Kemmañ an dastumlec\'h "$1"',
	'repoadmin-edit-path' => 'Hent ar sanailh :',
	'repoadmin-edit-bug' => 'Hent moned Bugzilla :',
	'repoadmin-edit-view' => 'Hent moned ViewVC :',
	'repoadmin-edit-button' => 'Mat eo',
	'repoadmin-edit-sucess' => 'Kemmet eo bet an dastumlec\'h "[[Special:Code/$1|$1]]".',
	'repoadmin-nav' => "melestradurezh an dastumlec'hioù",
	'right-repoadmin' => 'Melestriñ ar fiziadoù kod',
	'right-codereview-use' => 'Implijout Dibar:Kod',
	'right-codereview-add-tag' => "Ouzhpennañ tikedennoù nevez d'an adweladennoù",
	'right-codereview-remove-tag' => "Tennañ balizennoù d'an adweladennoù",
	'right-codereview-post-comment' => "Ouzhpennañ evezhiadennoù d'an adweladennoù",
	'right-codereview-set-status' => 'Kemmañ statud an adweladennoù',
	'right-codereview-signoff' => 'Aprouiñ adweladennoù',
	'right-codereview-link-user' => "Liammañ an oberourien d'an implijerien wiki",
	'right-codereview-associate' => "Ouzhpennañ/lemel ar c'henstroll adwelet",
	'right-codereview-review-own' => "Merkañ ar gwiriadennoù graet ganeoc'h evel Mat pe Diskoulmet",
	'specialpages-group-developer' => 'Ostilhoù diorren',
	'group-svnadmins' => 'Merourien SVN',
	'group-svnadmins-member' => '{{GENDER:$1|merour SVN|merourez SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Merourien SVN',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Smooth O
 */
$messages['bs'] = array(
	'code' => 'Provjera koda',
	'code-rev-title' => '$1 - Pregled koda',
	'code-comments' => 'Komentari',
	'code-references' => 'Naknadne revizije',
	'code-change-status' => "promijenjeno '''stanje''' $1",
	'code-change-tags' => "promijenjeni ''tagovi'' za $1",
	'code-change-removed' => 'uklonjeno:',
	'code-change-added' => 'dodano:',
	'code-old-status' => 'Staro stanje',
	'code-new-status' => 'Novo stanje',
	'code-prop-changes' => 'Zapis stanja i oznaka',
	'codereview-desc' => '[[Special:Code|Alat za provjeru koda]] sa [[Special:RepoAdmin|podrškom za subverzije]]',
	'code-no-repo' => 'Nijedan repozitorijum nije konfigurisan!',
	'code-create-repo' => 'Idite na [[Special:RepoAdmin|RepoAdmin]] za pravljenje Repozitorija',
	'code-need-repoadmin-rights' => 'prava repoadmina su neophodna da biste mogli praviti Repozitorij',
	'code-need-group-with-rights' => 'Ne postoji grupa sa pravima repoadmin. Molimo dodajte jednu da biste mogli dodavati novi Repozitorij',
	'code-repo-not-found' => "Repozitorij '''$1''' ne postoji!",
	'code-load-diff' => 'Punim diff...',
	'code-notes' => 'nedavni komentari',
	'code-statuschanges' => 'izmjene stanja',
	'code-mycommits' => 'moje publikacije',
	'code-mycomments' => 'moji komentari',
	'code-authors' => 'autori',
	'code-status' => 'statusi',
	'code-tags' => 'oznake',
	'code-tags-no-tags' => 'Ne postoje oznake u ovom repozitorijumu.',
	'code-authors-text' => 'Ispod je spisak autora repozitorijuma poredanih po imenima. Lokalni wiki računi su prikazani pod navodnicima. Podaci mogu biti keširani.',
	'code-author-haslink' => 'Ovaj autor je povezan wiki korisničkim računom $1',
	'code-author-orphan' => 'Ovaj autor nije povezan sa wiki računom',
	'code-author-dolink' => 'Poveži ovog autora sa wiki korisnikom:',
	'code-author-alterlink' => 'Promijeni wiki korisnika povezanog s ovim autorom:',
	'code-author-orunlink' => 'Ili poništi link ovog wiki korisnika:',
	'code-author-name' => 'Unesite korisničko ime:',
	'code-author-success' => 'Autor $1 je povezan sa wiki korisnikom $2',
	'code-author-link' => 'povezati?',
	'code-author-unlink' => 'ukloni povezivanje?',
	'code-author-unlinksuccess' => 'Autoru $1 je uklonjeno povezivanje.',
	'code-author-badtoken' => 'Greška sesije pri pokušaju izvršavanje akcije.',
	'code-author-total' => 'Ukupan broj autora: $1',
	'code-author-lastcommit' => 'Datum posljednjeg slanja',
	'code-browsing-path' => "Pregledavanje revizija u '''$1'''",
	'code-field-id' => 'Revizija',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Komentator',
	'code-field-message' => 'Pošalji sažetak',
	'code-field-status' => 'Stanje',
	'code-field-status-description' => 'Opis stanja',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Komentari',
	'code-field-path' => 'Putanja',
	'code-field-text' => 'Bilješka',
	'code-field-select' => 'Odaberi',
	'code-reference-remove' => 'Ukloni odabrana povezivanja',
	'code-reference-associate' => 'Povezane praćene revizije:',
	'code-reference-associate-submit' => 'Poveži',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Komentar:',
	'code-rev-repo' => 'Repozitorijum:',
	'code-rev-rev' => 'Revizija:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Izmijenjene putanje:',
	'code-rev-modified-a' => 'dodano',
	'code-rev-modified-r' => 'zamijenjeno',
	'code-rev-modified-d' => 'obrisano',
	'code-rev-modified-m' => 'izmijenjeno',
	'code-rev-imagediff' => 'Promjene slike',
	'code-rev-status' => 'Stanje:',
	'code-rev-status-set' => 'Promjena statusa',
	'code-rev-tags' => 'Oznake:',
	'code-rev-tag-add' => 'Dodaj oznake:',
	'code-rev-tag-remove' => 'Ukloni oznake:',
	'code-rev-comment-by' => 'Komentar od strane $1',
	'code-rev-comment-preview' => 'Pregled',
	'code-rev-inline-preview' => 'Pregled:',
	'code-rev-diff' => 'Razl',
	'code-rev-diff-link' => 'razl',
	'code-rev-diff-too-large' => 'Razlika je prevelika za prikaz.',
	'code-rev-purge-link' => 'obnoviti',
	'code-rev-total' => 'Ukupan broj rezultata: $1',
	'code-rev-not-found' => "Revizija '''$1''' ne postoji!",
	'code-status-new' => 'novi',
	'code-status-desc-new' => 'Revizija očekuje akciju (osnovno stanje).',
	'code-status-fixme' => 'popravi me',
	'code-status-desc-fixme' => 'Provjerivač je označio ovu reviziju kao uzrok greške ili je neisptavna. Treba se popraviti.',
	'code-status-reverted' => 'vraćeno',
	'code-status-desc-reverted' => 'Revizija je odbačena od neke kasnije revizije.',
	'code-status-resolved' => 'riješeno',
	'code-status-desc-resolved' => 'Revizija je imala problem koji je riješen putem nekom kasnijom revizijom.',
	'code-status-ok' => 'u redu',
	'code-status-desc-ok' => 'Revizija je potpuno pregledana a provjerivač je siguran da je po njegovom mišljenju sve u redu.',
	'code-status-deferred' => 'odloženo',
	'code-status-desc-deferred' => 'Revizija ne zahtijeva pregled.',
	'code-status-old' => 'staro',
	'code-status-desc-old' => 'Stara revizija sa mogućim greškama ali koje nisu vrijedne truda za njihovu provjeru.',
	'code-signoffs' => 'Završeci',
	'code-signoff-legend' => 'Dodaj završetak',
	'code-signoff-submit' => 'Završetak',
	'code-signoff-strike' => 'Precrtaj odabrana odobrenja',
	'code-signoff-signoff' => 'Odobri ovu reviziju kao:',
	'code-signoff-flag-inspected' => 'Ispitano',
	'code-signoff-flag-tested' => 'Testirano',
	'code-signoff-field-user' => 'Korisnik',
	'code-signoff-field-flag' => 'Zastava',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (poništeno $2)',
	'code-pathsearch-legend' => 'Pretraga revizija u ovom repozitoriju po putanji',
	'code-pathsearch-path' => 'Putanja:',
	'code-pathsearch-filter' => 'Primijenjen filter:',
	'code-revfilter-cr_status' => 'Stanje = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Oznaka = $1',
	'code-revfilter-clear' => 'Očisti filtere',
	'code-rev-submit' => 'Spremi izmjene',
	'code-rev-submit-next' => 'Spremi i prikaži slijedeći nerješeni',
	'code-rev-next' => 'Slijedeći neriješeni',
	'code-batch-status' => 'Promijeni status:',
	'code-batch-tags' => 'Promijeni oznake:',
	'codereview-batch-title' => 'Promijeni sve odabrane revizije',
	'codereview-batch-submit' => 'Pošalji',
	'code-releasenotes' => 'bilješke izdanja',
	'code-release-legend' => 'Generisanje bilješki izdanja',
	'code-release-startrev' => 'Početna rev:',
	'code-release-endrev' => 'Zadnja rev:',
	'codereview-subtitle' => 'Za $1',
	'codereview-reply-link' => 'odgovor',
	'codereview-overview-title' => 'Pregled',
	'codereview-overview-desc' => 'Prikaži grafički pregled ovog spiska',
	'codereview-email-subj' => '[$1 $2]: Dodan novi komentar',
	'codereview-email-body' => 'Korisnik "$1" je napravio komentar na $3.

Puni URL: $2
Poslani sažetak:

$5

Komentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Slijedeće izmjene',
	'codereview-email-body2' => 'Korisnik "$1" je izvršio povezane izmjene na $2.

Puni URL za povezane revizije: $5
Napravljeni sažetak:

$6

Puni URL: $3
Napravljeni sažetak:

$4',
	'codereview-email-subj3' => '[$1 $2]: Promjena stanja revizije',
	'codereview-email-body3' => 'Korisnik "$1" je promijenio stanje od $2.

Staro stanje: $3
Novo stanje: $4

Puni URL: $5
Napravljeni sažetak:

$6',
	'codereview-email-subj4' => '[$1 $2]: Dodan novi komentar i promijenjeno stanje revizije',
	'codereview-email-body4' => 'Korisnik "$1"  je promijenio stanje od $2.

Staro stanje: $3
Novo stanje: $4

Korisnik "$1" je postavio i komentar na $2.

Puni URL: $5
Napravljeni sažetak:

$7

Komentar:

$6',
	'code-stats' => 'statistike',
	'code-stats-header' => 'Statistike za repozitorij $1',
	'code-stats-main' => 'Sa stanjem od $1, repozitorij je imao $2 {{PLURAL:$2|reviziju|revizije|revizija}} od strane [[Special:Code/$3/author|$4 {{PLURAL:$4|autora|autora}}]].',
	'code-stats-status-breakdown' => 'Broj revizija po stanju',
	'code-stats-fixme-breakdown' => 'Rasčlanjen pregled revizija popravaka po autoru',
	'code-stats-new-breakdown' => 'Rasčlanjen pregled novih revizija po autoru',
	'code-stats-count' => 'Broj revizija',
	'code-tooltip-withsummary' => 'r$1 [$2] od $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] od $3',
	'repoadmin' => 'Administracija repozitorijuma',
	'repoadmin-new-legend' => 'Napravi novi repozitorijum',
	'repoadmin-new-label' => 'Naziv repozitorija:',
	'repoadmin-new-button' => 'Napravi',
	'repoadmin-edit-legend' => 'Promjene repozitorijuma "$1"',
	'repoadmin-edit-path' => 'Putanja do repozitorijuma:',
	'repoadmin-edit-bug' => 'Bugzilla putanja:',
	'repoadmin-edit-view' => 'Putanja za ViewVC:',
	'repoadmin-edit-button' => 'U redu',
	'repoadmin-edit-sucess' => 'Repozitorijum "[[Special:Code/$1|$1]]" je uspješno promijenjen.',
	'repoadmin-nav' => 'administracija repozitorijuma',
	'right-repoadmin' => 'Uređivanje repozitorijuma koda',
	'right-codereview-use' => 'Korištenje Special:Code',
	'right-codereview-add-tag' => 'Dodavanje novih oznaka revizijama',
	'right-codereview-remove-tag' => 'Uklanjanje oznaka sa revizija',
	'right-codereview-post-comment' => 'Dodavanje komentara na revizije',
	'right-codereview-set-status' => 'Promjena stanja revizija',
	'right-codereview-signoff' => 'Završi izmjene revizija',
	'right-codereview-link-user' => 'Poveži autore sa wiki korisnicima',
	'right-codereview-associate' => 'Upravljanje pridruženim revizijama',
	'right-codereview-review-own' => 'Označite vaše vlastite revizije kao OK',
	'specialpages-group-developer' => 'Razvojni alati',
	'group-svnadmins' => 'SVN administratori',
	'group-svnadmins-member' => 'SVN administrator',
	'grouppage-svnadmins' => '{{ns:project}}:SVN administratori',
);

/** Catalan (Català)
 * @author Aleator
 * @author El libre
 * @author Loupeter
 * @author Paucabot
 * @author SMP
 * @author Solde
 */
$messages['ca'] = array(
	'code' => 'Revisió del Codi',
	'code-rev-title' => '$1 - Revisió del Codi',
	'code-comments' => 'Comentaris',
	'code-references' => 'Seguiment de les revisions',
	'code-change-status' => "canvia l''''estat''' de $1",
	'code-change-tags' => "canviades les '''etiquetes''' per $1",
	'code-change-removed' => 'Eliminat:',
	'code-change-added' => 'afegit:',
	'code-old-status' => 'Estat antic',
	'code-new-status' => 'Estat nou',
	'code-prop-changes' => "Estat i registre d'etiquetatge",
	'code-no-repo' => "No s'ha configurat cap repositori.",
	'code-repo-not-found' => "El repositori '''$1''' no existeix!",
	'code-load-diff' => 'Carregant dif...',
	'code-notes' => 'comentaris recents',
	'code-statuschanges' => "Canvis d'estat",
	'code-mycommits' => 'les meves publicacions',
	'code-mycomments' => 'els meus comentaris',
	'code-authors' => 'autors',
	'code-status' => 'Estats',
	'code-tags' => 'Etiquetes',
	'code-tags-no-tags' => 'No existeixen etiquetes en aquest repositori.',
	'code-author-haslink' => "Aquest autor està vinculat a l'usuari wiki $1",
	'code-author-orphan' => "Aquest autor no té enllaç a un compte d'usuari wiki",
	'code-author-dolink' => 'Vincula aquest autor a un usuari wiki:',
	'code-author-alterlink' => "Canviau l'usuari wiki vinculat a aquest autor:",
	'code-author-orunlink' => 'O desvinculau aquest usuari wiki:',
	'code-author-name' => "Indiqueu un nom d'usuari:",
	'code-author-success' => "L'autor $1 ha estat vinculat amb l'usuari wiki $2",
	'code-author-link' => 'vincula?',
	'code-author-unlink' => "Elimina l'enllaç?",
	'code-author-unlinksuccess' => "L'autor $1 ha estat desvinculat",
	'code-author-badtoken' => "Error de sessió en intentar realitzar l'acció.",
	'code-author-total' => "Nombre total d'autors/es: $1",
	'code-author-lastcommit' => "Data de l'última acció",
	'code-browsing-path' => "Navegant per les revisions a '''$1'''",
	'code-field-id' => 'Revisió',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentarista',
	'code-field-message' => "Sumari d'accions",
	'code-field-status' => 'Estat',
	'code-field-status-description' => "Descripció de l'estat",
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Comentaris',
	'code-field-path' => 'Ruta',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Seleccionau',
	'code-reference-remove' => 'Suprimeix les associacions seleccionades',
	'code-reference-associate-submit' => 'Associa',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Comentari:',
	'code-rev-repo' => 'Repositori:',
	'code-rev-rev' => 'Revisió:',
	'code-rev-rev-viewvc' => 'a ViewVC',
	'code-rev-paths' => 'Rutes modificades:',
	'code-rev-modified-a' => 'afegit',
	'code-rev-modified-r' => 'Reemplaçat',
	'code-rev-modified-d' => 'esborrat',
	'code-rev-modified-m' => 'modificat',
	'code-rev-imagediff' => 'Canvis de la imatge',
	'code-rev-status' => 'Estat:',
	'code-rev-status-set' => "Canvia l'estat",
	'code-rev-tags' => 'Etiquetes:',
	'code-rev-tag-add' => 'Afegeix etiquetes:',
	'code-rev-tag-remove' => 'Elimina etiquetes:',
	'code-rev-comment-by' => 'Comentari de $1',
	'code-rev-comment-preview' => 'Previsualitza',
	'code-rev-inline-preview' => 'Vista prèvia:',
	'code-rev-diff' => 'dif',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'La diferència és massa gran per ser mostrada.',
	'code-rev-purge-link' => 'Purga',
	'code-rev-total' => 'Nombre total de resultats: $1',
	'code-rev-not-found' => "La revisió '''$1''' no existeix!",
	'code-status-new' => 'nou',
	'code-status-fixme' => "arregla'm",
	'code-status-reverted' => 'Revertit',
	'code-status-resolved' => 'Resolt',
	'code-status-ok' => 'ok',
	'code-status-deferred' => 'diferits',
	'code-status-old' => 'edat',
	'code-signoffs' => 'Aprovacions',
	'code-signoff-legend' => 'Afegeix aprovació',
	'code-signoff-submit' => 'Aprova',
	'code-signoff-strike' => 'Tatxa les aprovacions seleccionades',
	'code-signoff-signoff' => 'Aprova aquesta revisió com:',
	'code-signoff-flag-inspected' => 'Inspeccionat',
	'code-signoff-flag-tested' => 'Provat',
	'code-signoff-field-user' => 'Usuari/a',
	'code-signoff-field-flag' => 'Marca',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 (ha tatxat $2)',
	'code-pathsearch-legend' => 'Cerca revisions en aquest repositori per ruta',
	'code-pathsearch-path' => 'Ruta:',
	'code-pathsearch-filter' => 'Filtre aplicat:',
	'code-revfilter-cr_status' => 'Estat = $1',
	'code-revfilter-cr_author' => 'Autor/a = $1',
	'code-revfilter-clear' => 'Neteja filtre',
	'code-rev-submit' => 'Desar canvis',
	'code-rev-submit-next' => 'Guarda i vés al següent sense resoldre',
	'code-batch-status' => "Canvia l'estat:",
	'code-batch-tags' => 'Canvia etiquetes:',
	'codereview-batch-title' => 'Canvia totes les revisions seleccionades',
	'codereview-batch-submit' => 'Envia',
	'code-releasenotes' => 'notes de la versió',
	'code-release-legend' => 'Genera notes de llançament',
	'code-release-startrev' => 'Inici rev:',
	'code-release-endrev' => 'Darrera rev:',
	'codereview-subtitle' => 'Per $1',
	'codereview-reply-link' => 'Contesta',
	'codereview-email-subj' => '[$1 $2]: Nou comentari afegit',
	'codereview-email-body' => 'L\'usuari "$1" ha fet un comentari a $3.

URL complet: $2
Resum:

$5

Comentari:

$4',
	'codereview-email-subj2' => '[$1 $2]: Seguiment dels canvis',
	'code-stats' => 'estadístiques',
	'code-stats-header' => 'Estadístiques del repositori $1',
	'code-stats-status-breakdown' => 'Nombre de revisions per estat',
	'code-stats-count' => 'Nombre de revisions',
	'repoadmin' => 'Administració del Repositori',
	'repoadmin-new-legend' => 'Crea nou repositori',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modificació del repositori "$1"',
	'repoadmin-edit-path' => 'Ruta del repositori:',
	'repoadmin-edit-bug' => 'Ruta de Bugzilla:',
	'repoadmin-edit-view' => 'Ruta de ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-nav' => 'administració del repositori',
	'right-repoadmin' => 'Gestionar els repositoris de codi',
	'right-codereview-use' => 'Usar la pàgina Special:Code',
	'right-codereview-add-tag' => 'Afegir noves etiquetes a les revisions',
	'right-codereview-remove-tag' => 'Eliminar etiquetes de les revisions',
	'right-codereview-post-comment' => 'Afegir comentaris a les revisions',
	'right-codereview-set-status' => "Canviar l'estat de les revisions",
	'right-codereview-signoff' => 'Aprova revisions',
	'specialpages-group-developer' => 'Eines de desenvolupador',
	'group-svnadmins' => 'administradors SVN',
	'group-svnadmins-member' => 'administrador SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Administradors SVN',
);

/** Chechen (Нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'codereview-reply-link' => 'жоп ло',
);

/** Sorani (کوردی) */
$messages['ckb'] = array(
	'codereview-batch-submit' => 'ناردن',
);

/** Corsican (Corsu) */
$messages['co'] = array(
	'code-field-author' => 'Autore',
	'code-rev-author' => 'Autore:',
	'code-rev-history-link' => 'cronolugia',
);

/** Czech (Česky)
 * @author Danny B.
 * @author Kuvaly
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'code' => 'Kontrola kódu',
	'code-rev-title' => '$1 – Kontrola kódu',
	'code-comments' => 'Komentáře',
	'code-references' => 'Odkazy na tuto revizi',
	'code-referenced' => 'Odkazované revize',
	'code-change-status' => "změnil '''stav''' revize $1",
	'code-change-tags' => "změnil '''značky''' revize $1",
	'code-change-removed' => 'odebráno:',
	'code-change-added' => 'přidáno:',
	'code-old-status' => 'Původní stav',
	'code-new-status' => 'Nový stav',
	'code-prop-changes' => 'Záznam změn stavu a značek',
	'codereview-desc' => '[[Special:Code|Nástroj pro kontrolu kódu]] s [[Special:RepoAdmin|podporou Subversion]]',
	'code-no-repo' => 'Nebylo nastaveno žádné úložiště!',
	'code-create-repo' => 'Pro založení úložiště jděte do [[Special:Repoadmin|správce úložišť]]',
	'code-need-repoadmin-rights' => 'Pro založení úložiště je potřeba právo repoadmin',
	'code-need-group-with-rights' => 'Neexistuje žádná skupina s oprávněním repoadmin. Abyste mohli založit úložiště, musíte nějakou přidat.',
	'code-repo-not-found' => "Úložiště '''$1''' neexistuje!",
	'code-load-diff' => 'Nahrávám diff…',
	'code-notes' => 'nedávné poznámky',
	'code-statuschanges' => 'změny stavu',
	'code-mycommits' => 'moje commity',
	'code-mycomments' => 'moje komentáře',
	'code-authors' => 'autoři',
	'code-status' => 'stavy',
	'code-tags' => 'značky',
	'code-tags-no-tags' => 'V tomto úložišti neexistují žádné značky.',
	'code-authors-text' => 'Toto je seznam autorů v úložišti seřazený podle jména. V závorkách jsou uživatelská jména na této wiki. Data mohou pocházet z cache.',
	'code-author-haslink' => 'Tento autor je spojen s wiki uživatelem $1',
	'code-author-orphan' => 'Autor/uživatel SVN $1 není svázaný s žádným wikiuživatelem',
	'code-author-dolink' => 'Svázat tohoto autora s wikiuživatelem:',
	'code-author-alterlink' => 'Změnit wikiuživatele svázaného s tímto autorem:',
	'code-author-orunlink' => 'Nebo zrušit vazbu tohoto wikiuživatele:',
	'code-author-name' => 'Vložte uživatelské jméno:',
	'code-author-success' => 'Autor $1 byl svázán s wikiuživatelem $2',
	'code-author-link' => 'svázat?',
	'code-author-unlink' => 'zrušit vazbu?',
	'code-author-unlinksuccess' => 'Vazba autora $1 byla zrušena',
	'code-author-badtoken' => 'Při provádění operace došlo k chybě sezení.',
	'code-author-total' => 'Celkový počet autorů: $1',
	'code-author-lastcommit' => 'Datum posledního commitu',
	'code-browsing-path' => "Procházení revizemi v '''$1'''",
	'code-field-id' => 'Revize',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Komentující',
	'code-field-message' => 'Komentář',
	'code-field-status' => 'Stav',
	'code-field-status-description' => 'Popis stavu',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Komentáře',
	'code-field-path' => 'Cesta',
	'code-field-text' => 'Poznámka',
	'code-field-select' => 'Vybrat',
	'code-reference-remove' => 'Odstranit vybraná připojení',
	'code-reference-associate' => 'Připojit odkazující revizi:',
	'code-reference-associate-submit' => 'Připojit',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Komentář:',
	'code-rev-repo' => 'Úložiště:',
	'code-rev-rev' => 'Revize:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Změněné cesty:',
	'code-rev-modified-a' => 'přidáno',
	'code-rev-modified-r' => 'nahrazeno',
	'code-rev-modified-d' => 'odstraněno',
	'code-rev-modified-m' => 'změněno',
	'code-rev-imagediff' => 'Změny obrázků',
	'code-rev-status' => 'Stav:',
	'code-rev-status-set' => 'Změnit stav',
	'code-rev-tags' => 'Značky:',
	'code-rev-tag-add' => 'Přidat značku:',
	'code-rev-tag-remove' => 'Odstranit značky:',
	'code-rev-comment-by' => 'Komentář od $1',
	'code-rev-comment-preview' => 'Náhled',
	'code-rev-inline-preview' => 'Náhled:',
	'code-rev-diff' => 'Rozdíl',
	'code-rev-diff-link' => 'rozdíl',
	'code-rev-diff-too-large' => 'Tento rozdíl je příliš velký, než aby mohl být zobrazen.',
	'code-rev-purge-link' => 'obnovit',
	'code-rev-total' => 'Celkový počet výsledků: $1',
	'code-rev-not-found' => "Revize '''$1''' neexistuje!",
	'code-rev-history-link' => 'historie',
	'code-status-new' => 'nová',
	'code-status-desc-new' => 'Revize čeká na označení (počáteční stav).',
	'code-status-fixme' => 'opravit',
	'code-status-desc-fixme' => 'Revize obsahuje chybu nebo nefunguje. Měla by být opravena nebo revertována.',
	'code-status-reverted' => 'revertováno',
	'code-status-desc-reverted' => 'Pozdější revize tuto revizi vyhodila.',
	'code-status-resolved' => 'vyřešená',
	'code-status-desc-resolved' => 'Revize měla problém, který vyřešila pozdější revize.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revize byla plně zkontrolována a posuzovatel si je jist, že je zcela v pořádku.',
	'code-status-deferred' => 'odložená',
	'code-status-desc-deferred' => 'Revize nepotřebuje kontrolu.',
	'code-status-old' => 'stará',
	'code-status-desc-old' => 'Stará revize, která může obsahovat chyby, ale nestojí za práci s kontrolováním.',
	'code-signoffs' => 'Schválení',
	'code-signoff-legend' => 'Přidat schválení',
	'code-signoff-submit' => 'Schválit',
	'code-signoff-strike' => 'Škrtnout vybraná schválení',
	'code-signoff-signoff' => 'Schválit tuto revizi jako:',
	'code-signoff-flag-inspected' => 'Zkontrolováno',
	'code-signoff-flag-tested' => 'Otestováno',
	'code-signoff-field-user' => 'Uživatel',
	'code-signoff-field-flag' => 'Příznak',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (škrtnuto $2)',
	'code-pathsearch-legend' => 'Hledat revize v tomto úložišti podle cesty',
	'code-pathsearch-path' => 'Cesta:',
	'code-pathsearch-filter' => 'Zobrazit jen:',
	'code-revfilter-cr_status' => 'Stav = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Značka = $1',
	'code-revfilter-clear' => 'Zrušit filtr',
	'code-rev-submit' => 'Uložit změny',
	'code-rev-submit-next' => 'Uložit & další nevyřešená',
	'code-rev-next' => 'Další nevyřešená',
	'code-batch-status' => 'Změnit stav:',
	'code-batch-tags' => 'Změnit značky:',
	'codereview-batch-title' => 'Změna všech vybraných revizí',
	'codereview-batch-submit' => 'Provést',
	'code-releasenotes' => 'poznámky k vydání',
	'code-release-legend' => 'Vytvořit poznámky k vydání',
	'code-release-startrev' => 'Počáteční revize:',
	'code-release-endrev' => 'Poslední revize:',
	'codereview-subtitle' => 'Pro $1',
	'codereview-reply-link' => 'odpovědět',
	'codereview-overview-title' => 'Přehled',
	'codereview-overview-desc' => 'Zobrazit grafický přehled k tomuto seznamu',
	'codereview-email-subj' => '[$1 $2]: Přidán nový komentář',
	'codereview-email-body' => 'Uživatel „$1“ přidal komentář k $3.

Plné URL: $2
Komentář ke změně:

$5

Komentář:

$4',
	'codereview-email-subj2' => '[$1 $2]: Reagující změna',
	'codereview-email-body2' => 'Uživatel „$1“ svou změnou reagoval na $2.

Úplné URL původní revize: $5
Komentář ke změně:

$6

Úplné URL: $3

Komentář ke změně:

$4',
	'codereview-email-subj3' => '[$1 $2]: Změnil se stav revize',
	'codereview-email-body3' => 'Uživatel „$1“ změnil stav $2.

Předchozí stav: $3
Nový stav: $4

Plné URL: $5
Komentář ke změně:

$6',
	'codereview-email-subj4' => '[$1 $2]: Přidán nový komentář a změnil se stav revize',
	'codereview-email-body4' => 'Uživatel „$1“ změnil stav $2.

Předchozí stav: $3
Nový stav: $4

Uživatel „$1“ také přidal k $2 komentář.

Plné URL: $5
Komentář ke změně:

$7

Komentář:

$6',
	'code-stats' => 'statistika',
	'code-stats-header' => 'Statistika pro úložiště $1',
	'code-stats-main' => 'K $1 obsahovalo úložiště $2 {{PLURAL:$2|revizi|revize|revizí}} od [[Special:Code/$3/author|$4 {{PLURAL:$4|autora|autorů}}]].',
	'code-stats-status-breakdown' => 'Počet revizí podle stavu',
	'code-stats-fixme-breakdown' => 'Rozdělení revizí potřebujících opravu podle autora',
	'code-stats-fixme-breakdown-path' => 'Rozdělení revizí potřebujících opravu podle cesty',
	'code-stats-fixme-path' => 'Revize potřebující opravu v cestě: $1',
	'code-stats-new-breakdown' => 'Rozdělení nových revizí podle autora',
	'code-stats-new-breakdown-path' => 'Rozdělení nových revizí podle cesty',
	'code-stats-new-path' => 'Nové revize v cestě: $1',
	'code-stats-count' => 'Počet revizí',
	'code-tooltip-withsummary' => 'r$1 [$2] od $3 – $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] od $3',
	'repoadmin' => 'Správa úložišť',
	'repoadmin-new-legend' => 'Vytvořit nové úložiště',
	'repoadmin-new-label' => 'Název úložiště:',
	'repoadmin-new-button' => 'Vytvořit',
	'repoadmin-edit-legend' => 'Změna úložiště „$1“',
	'repoadmin-edit-path' => 'Cesta k úložišti:',
	'repoadmin-edit-bug' => 'Cesta k Bugzille:',
	'repoadmin-edit-view' => 'Cesta k ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Úložiště „[[Special:Code/$1|$1]]“ bylo úspěšně změněno.',
	'repoadmin-nav' => 'správa úložiště',
	'right-repoadmin' => 'Správa úložišť kódu',
	'right-codereview-use' => 'Používání stránky {{ns:Special}}:Code',
	'right-codereview-add-tag' => 'Přidávání značek k revizím',
	'right-codereview-remove-tag' => 'Odebírání značek z revizí',
	'right-codereview-post-comment' => 'Přidávání komentářů k revizím',
	'right-codereview-set-status' => 'Přepínání stavu revizí',
	'right-codereview-signoff' => 'Schvalování revizí',
	'right-codereview-link-user' => 'Správa vazeb autorů s wikiuživateli',
	'right-codereview-associate' => 'Správa vztahů mezi revizemi',
	'right-codereview-review-own' => 'Označování vlastních revizí jako OK nebo vyřešená',
	'specialpages-group-developer' => 'Vývojářské nástroje',
	'group-svnadmins' => 'Správci SVN',
	'group-svnadmins-member' => '{{GENDER:$1|správce|správkyně|správce}} SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Správci SVN',
);

/** Danish (Dansk)
 * @author Byrial
 * @author Peter Alberti
 */
$messages['da'] = array(
	'code' => 'Kodegennemgang',
	'code-rev-title' => '$1 - kodegennemgang',
	'code-comments' => 'Kommentarer',
	'code-references' => 'Opfølgende versioner',
	'code-change-status' => "ændrede '''status''' for $1",
	'code-change-tags' => "ændrede '''tags''' for $1",
	'code-change-removed' => 'fjernet:',
	'code-change-added' => 'Tilføjet:',
	'code-old-status' => 'Gammel status',
	'code-new-status' => 'Ny status',
	'code-prop-changes' => 'Log for status og tags',
	'codereview-desc' => '[[Special:Code|Kodegennemgangsværktøj]] med [[Special:RepoAdmin|Subversion-understøttelse]]',
	'code-no-repo' => 'Intet kodearkiv er konfigureret!',
	'code-repo-not-found' => "Kodearkivet '''$1''' findes ikke!",
	'code-load-diff' => 'Indlæser forskel …',
	'code-notes' => 'Nye kommentarer',
	'code-statuschanges' => 'statusændringer',
	'code-mycomments' => 'mine kommentarer',
	'code-authors' => 'forfattere',
	'code-status' => 'stadier',
	'code-tags' => 'tags',
	'code-authors-text' => 'Nedenfor er en liste over forfattere sorteret efter bidragsnavn. Lokale wikikontoer vises i parentes. Data kan være mellemlagret.',
	'code-author-haslink' => 'Denne forfatter er knyttet til wikibruger $1',
	'code-author-orphan' => 'SVN-brugeren/forfatteren $1 er ikke knyttet til nogen wikikonto',
	'code-author-dolink' => 'Knyt denne forfatter til en wikibruger:',
	'code-author-alterlink' => 'Ret wikibrugeren som er knyttet til denne forfatter:',
	'code-author-orunlink' => 'Eller bryd tilknytningen til denne wikibruger:',
	'code-author-name' => 'Skriv et brugernavn:',
	'code-author-success' => 'Forfatteren $1 er blevet knyttet til wikibruger $2',
	'code-author-link' => 'tilknyt?',
	'code-author-unlink' => 'bryd tilknytning?',
	'code-author-unlinksuccess' => 'Forfatteren $1 har fået brudt til tilknytning',
	'code-author-total' => 'Totalt antal forfattere: $1',
	'code-field-id' => 'Version',
	'code-field-author' => 'Forfatter',
	'code-field-user' => 'Kommentator',
	'code-field-message' => 'Bidragsbeskrivelse',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Statusbeskrivelse',
	'code-field-timestamp' => 'Dato',
	'code-field-comments' => 'Kommentarer',
	'code-field-path' => 'Sti',
	'code-field-text' => 'Bemærkning',
	'code-field-select' => 'Vælg',
	'code-rev-author' => 'Forfatter:',
	'code-rev-date' => 'Dato:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Arkiv:',
	'code-rev-rev' => 'Version:',
	'code-rev-rev-viewvc' => 'på ViewVC',
	'code-rev-paths' => 'Ændrede stier:',
	'code-rev-modified-a' => 'tilføjet',
	'code-rev-modified-r' => 'erstattet',
	'code-rev-modified-d' => 'fjernet',
	'code-rev-modified-m' => 'ændret',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Ændr status',
	'code-rev-tags' => 'Tags:',
	'code-rev-tag-add' => 'Tilføj tags:',
	'code-rev-tag-remove' => 'Fjern tags:',
	'code-rev-comment-by' => 'Kommentar af $1',
	'code-rev-comment-preview' => 'Forhåndsvisning',
	'code-rev-inline-preview' => 'Forhåndsvisning:',
	'code-rev-diff' => 'Forskel',
	'code-rev-diff-link' => 'forskel',
	'code-rev-diff-too-large' => 'Versionsforskellen er for stor til at vise.',
	'code-rev-purge-link' => 'opfrisk',
	'code-rev-total' => 'Samlet antal resultater: $1',
	'code-rev-not-found' => "Revisionen '''$1''' findes ikke!",
	'code-rev-history-link' => 'historik',
	'code-status-new' => 'ny',
	'code-status-fixme' => 'ret mig',
	'code-status-reverted' => 'tilbagestillet',
	'code-status-desc-reverted' => 'Versionen blev fjernet igen i en senere version.',
	'code-status-resolved' => 'løst',
	'code-status-ok' => 'o.k.',
	'code-status-deferred' => 'udsat',
	'code-status-old' => 'gammel',
	'code-signoff-flag-inspected' => 'Inspiceret',
	'code-signoff-flag-tested' => 'Testet',
	'code-signoff-field-user' => 'Bruger',
	'code-signoff-field-date' => 'Dato',
	'code-signoff-struckdate' => '$1 (strøget $2)',
	'code-pathsearch-legend' => 'Søg versioner i dette arkiv efter sti',
	'code-pathsearch-path' => 'Sti:',
	'code-pathsearch-filter' => 'Vis kun:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Forfatter = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Ryd filter',
	'code-rev-submit' => 'Gem ændringer',
	'code-rev-submit-next' => 'Gem og gå til næste uløste',
	'code-rev-next' => 'Næste uløste',
	'code-batch-status' => 'Ret status:',
	'code-batch-tags' => 'Ret tags:',
	'codereview-batch-title' => 'Ændr alle valgte versioner',
	'codereview-batch-submit' => 'Udfør',
	'code-releasenotes' => 'versionsnoter',
	'code-release-legend' => 'Generer versionsnoter',
	'code-release-startrev' => 'Første version:',
	'code-release-endrev' => 'Sidste version:',
	'codereview-subtitle' => 'For $1',
	'codereview-reply-link' => 'svar',
	'codereview-overview-title' => 'Oversigt',
	'codereview-email-subj' => '[$1 $2]: Ny Kommentar tilføjet',
	'code-stats' => 'statistik',
	'code-stats-status-breakdown' => 'Antallet af revisioner med hver status',
	'code-stats-count' => 'Antallet af revisioner',
	'code-tooltip-withsummary' => 'r$1 [$2] af $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] af $3',
	'repoadmin' => 'Arkivadministration',
	'repoadmin-new-legend' => 'Lav et nyt arkiv',
	'repoadmin-new-label' => 'Arkivnavn:',
	'repoadmin-new-button' => 'Opret',
	'repoadmin-edit-legend' => 'Ændring af arkivet "$1"',
	'repoadmin-edit-path' => 'Arkivsti:',
	'repoadmin-edit-bug' => 'Bugzillasti:',
	'repoadmin-edit-view' => 'ViewVC-sti:',
	'repoadmin-edit-button' => 'O.k.',
	'repoadmin-edit-sucess' => 'Arkivet [[Special:Code/$1|$1]] er ændret.',
	'right-repoadmin' => 'Administrere kodearkiver',
	'right-codereview-use' => 'Bruge Special:Code',
	'right-codereview-add-tag' => 'Tilføje nye tags til versioner',
	'right-codereview-remove-tag' => 'Fjerne tags fra versioner',
	'right-codereview-post-comment' => 'Tilføje kommentarer til versioner',
	'right-codereview-set-status' => 'Ændre versioners status',
	'right-codereview-link-user' => 'Knytte forfattere til wikibrugere',
	'specialpages-group-developer' => 'Udviklerværktøjer',
	'group-svnadmins' => 'SVN-administratorer',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-administrator}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-administratorer',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Metalhead64
 * @author Purodha
 * @author SVG
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'code' => 'Codeprüfung',
	'code-rev-title' => '$1 – Codeprüfung',
	'code-comments' => 'Kommentare',
	'code-references' => 'Nachfolgende Revisionen',
	'code-referenced' => 'Nachfolgende Revisionen',
	'code-change-status' => "änderte den '''Status''' von Revision $1",
	'code-change-tags' => "änderte die '''Tags''' für Revision $1",
	'code-change-removed' => 'entfernt:',
	'code-change-added' => 'hinzugefügt:',
	'code-old-status' => 'Alter Status',
	'code-new-status' => 'Neuer Status',
	'code-prop-changes' => 'Status- und Tagging-Logbuch',
	'codereview-desc' => 'Stellt ein [[Special:Code|Codeprüfungssystem]] mit [[Special:RepoAdmin|Unterstützung für Subversion]] zur Verfügung',
	'code-no-repo' => 'Es ist kein Repositorium konfiguriert!',
	'code-create-repo' => 'Geh zur Spezialseite [[Special:RepoAdmin|RepoAdmin]] um ein Repositorium zu erstellen',
	'code-need-repoadmin-rights' => 'Die Berechtigung repoadmin ist erforderlich, um ein Repositorium erstellen zu können',
	'code-need-group-with-rights' => 'Es ist keine Benutzergruppe vorhanden, der die Berechtigung repoadmin zugeordnet ist. Bitte eine hinzufügen, um ein neues Repositorium erstellen zu können.',
	'code-repo-not-found' => "Repository '''$1''' existiert nicht!",
	'code-load-diff' => 'Lade Diff …',
	'code-notes' => 'Kommentare',
	'code-statuschanges' => 'Statusänderungen',
	'code-mycommits' => 'Eigene Commits',
	'code-mycomments' => 'meine Kommentare',
	'code-authors' => 'Autoren',
	'code-status' => 'Status',
	'code-tags' => 'Tags',
	'code-tags-no-tags' => 'In diesem Repositorium gibt es keine Tags.',
	'code-authors-text' => 'Es folgt die Liste der Repositoriumsautoren, nach Namen sortiert. Lokale Wikikonten werden in runden Klammern angezeigt. Daten könnten aus dem Cache stammen.',
	'code-author-haslink' => 'Dieser Autor ist mit dem Wiki-Benutzer $1 verlinkt',
	'code-author-orphan' => 'SVN-Benutzer/Autor $1 ist nicht mit dem Benutzerkonto eines Wikis verbunden',
	'code-author-dolink' => 'Diesen Autor zu einem Wiki-Benutzerkonto verlinken:',
	'code-author-alterlink' => 'Die Verlinkung zu einem Wiki-Benutzerkonto für diesen Autor ändern:',
	'code-author-orunlink' => 'Verlinkung zu dem Wiki-Benutzerkonto aufheben:',
	'code-author-name' => 'Benutzername:',
	'code-author-success' => 'Der Autor $1 wurde mit dem Wiki-Benutzer $2 verlinkt',
	'code-author-link' => 'verlinken?',
	'code-author-unlink' => 'entlinken?',
	'code-author-unlinksuccess' => 'Der Autor $1 wurde entlinkt',
	'code-author-badtoken' => 'Sitzungsfehler bei der Ausführung der Aktion.',
	'code-author-total' => 'Gesamtanzahl der Autoren: $1',
	'code-author-lastcommit' => 'Letztes Übertragungsdatum',
	'code-browsing-path' => "Nach Revisionen in '''$1''' suchen",
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Kommentator',
	'code-field-message' => 'Kommentar',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Status-Beschreibung',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Kommentare',
	'code-field-path' => 'Pfad',
	'code-field-text' => 'Notiz',
	'code-field-select' => 'Auswählen',
	'code-reference-remove' => 'Ausgewählte Verknüpfungen aufheben',
	'code-reference-associate' => 'Mit Folgerevision verknüpfen:',
	'code-reference-associate-submit' => 'Verknüpfen',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Repositorium:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'auf ViewVC',
	'code-rev-paths' => 'Geänderte Pfade:',
	'code-rev-modified-a' => 'hinzugefügt',
	'code-rev-modified-r' => 'ersetzt',
	'code-rev-modified-d' => 'gelöscht',
	'code-rev-modified-m' => 'geändert',
	'code-rev-imagediff' => 'Bildänderungen',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status ändern',
	'code-rev-tags' => 'Tags:',
	'code-rev-tag-add' => 'Ergänze Tags:',
	'code-rev-tag-remove' => 'Entferne Tags:',
	'code-rev-comment-by' => 'Kommentar von $1',
	'code-rev-comment-preview' => 'Vorschau',
	'code-rev-inline-preview' => 'Vorschau:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'Diff',
	'code-rev-diff-too-large' => 'Der Diff ist zu groß, um angezeigt werden zu können.',
	'code-rev-purge-link' => 'Cache löschen',
	'code-rev-total' => 'Anzahl der Ergebnisse: $1',
	'code-rev-not-found' => "Revision '''$1''' ist nicht vorhanden!",
	'code-rev-history-link' => 'Versionen',
	'code-status-new' => 'neu',
	'code-status-desc-new' => 'Revision erwartet eine Aktion (Standardstatus).',
	'code-status-fixme' => 'FIXME',
	'code-status-desc-fixme' => 'Diese Revision verursacht einen Softwarefehler oder ist defekt. Sie sollte korrigiert oder rückgängig gemacht werden.',
	'code-status-reverted' => 'rückgängig gemacht',
	'code-status-desc-reverted' => 'Revision wurde durch eine spätere Revision rückgängig gemacht.',
	'code-status-resolved' => 'erledigt',
	'code-status-desc-resolved' => 'Mit dieser Revision gab es ein Problem, das mit einer späteren Revision berichtigt wurde.',
	'code-status-ok' => 'okay',
	'code-status-desc-ok' => 'Die Revision wurde vollständig begutachtet und der Gutachter ist sich sicher, dass sie in jeder Hinsicht einwandfrei ist.',
	'code-status-deferred' => 'zurückgestellt',
	'code-status-desc-deferred' => 'Die Revision erfordert keine Begutachtung.',
	'code-status-old' => 'alt',
	'code-status-desc-old' => 'Alte Revision mit potentiellen Softwarefehlern, die es aber nicht wert sind, begutachtet zu werden.',
	'code-signoffs' => 'Freigaben',
	'code-signoff-legend' => 'Freigabe hinzufügen',
	'code-signoff-submit' => 'Freigeben',
	'code-signoff-strike' => 'Ausgewählte Freigaben streichen',
	'code-signoff-signoff' => 'Diese Revision freigeben als:',
	'code-signoff-flag-inspected' => 'Geprüft',
	'code-signoff-flag-tested' => 'Getestet',
	'code-signoff-field-user' => 'Benutzer',
	'code-signoff-field-flag' => 'Kennzeichen',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (gestrichen $2)',
	'code-pathsearch-legend' => 'Suche in diesem Repositorium per Pfad nach Revisionen',
	'code-pathsearch-path' => 'Pfad:',
	'code-pathsearch-filter' => 'Nur anzeigen:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Filter löschen',
	'code-rev-submit' => 'Änderungen speichern',
	'code-rev-submit-next' => 'Änderungen speichern und weiter zur nächsten ungeprüften',
	'code-rev-next' => 'Weiter zur nächsten ungeprüften',
	'code-batch-status' => 'Status ändern:',
	'code-batch-tags' => 'Tags ändern:',
	'codereview-batch-title' => 'Alle ausgewählten Revisionen ändern',
	'codereview-batch-submit' => 'Speichern',
	'code-releasenotes' => 'Versionsinformationen',
	'code-release-legend' => 'Versionsinformationen generieren',
	'code-release-startrev' => 'Startrevision:',
	'code-release-endrev' => 'Letzte Revision:',
	'codereview-subtitle' => 'Für $1',
	'codereview-reply-link' => 'antworten',
	'codereview-overview-title' => 'Übersicht',
	'codereview-overview-desc' => 'Eine grafische Übersicht dieser Liste anzeigen',
	'codereview-email-subj' => '[$1 $2]: Neuen Kommentar hinzugefügt',
	'codereview-email-body' => 'Benutzer „$1“ hat Revision $3 kommentiert:

Vollständige URL: $2
Zusammenfassung:

$5

Kommentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Folgebearbeitung',
	'codereview-email-body2' => 'Benutzer „$1“ machte eine Folgebearbeitung zu $2.

URL der nachfolgenden Revision: $5
Zusammenfassung:

$6

URL: $3

Zusammenfassung:

$4',
	'codereview-email-subj3' => '[$1 $2]: Revisionsstatus geändert',
	'codereview-email-body3' => 'Benutzer „$1“ änderte den Status von $2.

Alter Status: $3
Neuer Status: $4

Vollständige URL: $5
Zusammenfassung:

$6',
	'codereview-email-subj4' => '[$1 $2]: Neuen Kommentar hinzugefügt und Revisionsstatus geändert',
	'codereview-email-body4' => 'Benutzer „$1“ änderte den Status von $2.

Alter Status: $3
Neuer Status: $4

Benutzer „$1“ fügte zudem einen Kommentar zu $2 hinzu.

Vollständige URL: $5
Zusammenfassung:

$7

Kommentar:

$6',
	'code-stats' => 'Statistiken',
	'code-stats-header' => 'Statistik des Repositoriums „$1“',
	'code-stats-main' => 'Mit Stand $5, $6 Uhr wurden von [[Special:Code/$3/author|$4 {{PLURAL:$4|Autor|Autoren}}]] $2 {{PLURAL:$2|Revision|Revisionen}} im Repositorium durchgeführt.',
	'code-stats-status-breakdown' => 'Anzahl der Revisionen pro Status',
	'code-stats-fixme-breakdown' => 'Aufschlüsselung der Revisionen mit FIXMEs pro Autor',
	'code-stats-fixme-breakdown-path' => 'Aufschlüsselung der Revisionen mit FIXMEs pro Pfad',
	'code-stats-fixme-path' => 'Revisionen mit FIXMEs für Pfad: $1',
	'code-stats-new-breakdown' => 'Aufschlüsselung neuer Revisionen pro Autor',
	'code-stats-new-breakdown-path' => 'Aufschlüsselung neuer Revisionen pro Pfad',
	'code-stats-new-path' => 'Neue Revisionen für Pfad: $1',
	'code-stats-count' => 'Anzahl der Revisionen',
	'code-tooltip-withsummary' => 'r$1 [$2] von $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] von $3',
	'repoadmin' => 'Repositoriumsadministration',
	'repoadmin-new-legend' => 'Neues Repositorium erstellen',
	'repoadmin-new-label' => 'Name des Repositoriums:',
	'repoadmin-new-button' => 'Erstellen',
	'repoadmin-edit-legend' => 'Änderungen am Repositorium „$1“',
	'repoadmin-edit-path' => 'Pfad zum Repositorium:',
	'repoadmin-edit-bug' => 'Pfad zu Bugzilla:',
	'repoadmin-edit-view' => 'Pfad zu ViewVC:',
	'repoadmin-edit-button' => 'Okay',
	'repoadmin-edit-sucess' => 'Das Repositorium „[[Special:Code/$1|$1]]“ wurde erfolgreich geändert.',
	'repoadmin-nav' => 'Repositoriumsadministration',
	'right-repoadmin' => 'Coderepositorien verwalten',
	'right-codereview-use' => 'Spezial:Code nutzen',
	'right-codereview-add-tag' => 'Neue Tags zu Revisionen hinzufügen',
	'right-codereview-remove-tag' => 'Tags von Revisionen entfernen',
	'right-codereview-post-comment' => 'Kommentare zu Revisionen abgeben',
	'right-codereview-set-status' => 'Revisionsstatus ändern',
	'right-codereview-signoff' => 'Revisionen freigeben',
	'right-codereview-link-user' => 'Autoren zu Wiki-Benutzern verlinken',
	'right-codereview-associate' => 'Revisionszuordnungen verwalten',
	'right-codereview-review-own' => 'Eigene Revisionen als „{{int:code-status-ok}}“ oder „{{int:code-status-resolved}}“ markieren',
	'action-repoadmin' => 'Coderepositorien zu verwalten',
	'action-codereview-use' => 'Spezial:Code zu nutzen',
	'action-codereview-add-tag' => 'neue Tags zu Revisionen hinzuzufügen',
	'action-codereview-remove-tag' => 'Tags von Revisionen zu entfernen',
	'action-codereview-post-comment' => 'Kommentare zu Revisionen abzugeben',
	'action-codereview-set-status' => 'den Revisionsstatus zu ändern',
	'action-codereview-signoff' => 'Revisionen freizugeben',
	'action-codereview-link-user' => 'Autoren zu Wiki-Benutzern zu verlinken',
	'action-codereview-associate' => 'Revisionszuordnungen zu verwalten',
	'action-codereview-review-own' => 'die eigenen Revisionen als „{{int:code-status-ok}}“ oder „{{int:code-status-resolved}}“ zu markieren',
	'specialpages-group-developer' => 'Entwicklerwerkzeuge',
	'group-svnadmins' => 'SVN-Administratoren',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-Administrator|SVN-Administratorin}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-Administratoren',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'code-create-repo' => 'Gehen Sie zur Spezialseite [[Special:RepoAdmin|RepoAdmin]] um ein Repositorium zu erstellen',
);

/** Zazaki (Zazaki)
 * @author Xoser
 */
$messages['diq'] = array(
	'code' => 'Kontrolê kodî',
	'code-rev-title' => '$1 - Kontralê Kodî',
	'code-comments' => 'Xulasayan',
	'code-references' => 'reviyanê tekîp keno',
	'code-change-status' => "'''statuyan''' qe $1 vurne",
	'code-change-tags' => "'''etîketan''' qe $1 vurne",
	'code-change-removed' => 'wedariya:',
	'code-change-added' => 'de biyo:',
	'code-old-status' => 'Statuyê kihanî',
	'code-new-status' => 'Statuyê newî',
	'code-prop-changes' => 'Logê statuyî & etîketî',
	'codereview-desc' => '[[Special:Code|Xacetan ke qe kontralê kodî]] pê [[Special:RepoAdmin|Yardimê subversionî]]',
	'code-no-repo' => 'Yew arşîv cinfigure nebiyo!',
	'code-repo-not-found' => "Repositor '''$1''' cini yo!",
	'code-load-diff' => 'Diff bar keno...',
	'code-notes' => 'xulasay peyenî',
	'code-statuschanges' => 'vurnayîşanê statuyan',
	'code-mycommits' => 'gureyanê mi',
	'code-authors' => 'nuştekaran',
	'code-status' => 'merheleyan',
	'code-tags' => 'Etîketan',
	'code-authors-text' => 'Bin de yew listeyê repo nuştekaran esto. Wîkîyanê lokalî îtaya de benate parantez de mucnayo.',
	'code-author-haslink' => 'Nuştekar, karberê $1î ra link biyo',
	'code-author-orphan' => 'Ena karber yew hesabê wîkî rê lînk nibiyo',
	'code-author-dolink' => 'Ena karber yew hesabê wîkî rê lînk bike:',
	'code-author-alterlink' => 'Karberê wîkîyî ke ena nuştekar rê lînk bike, înan bivurne:',
	'code-author-orunlink' => 'Ya zi ena karberê wîkîyî unlink bike:',
	'code-author-name' => 'Yew nameyê karberî binuse:',
	'code-author-success' => 'Nuştekarê $1î, karberê $2î ra link biyo',
	'code-author-link' => 'link?',
	'code-author-unlink' => 'unlink?',
	'code-author-unlinksuccess' => 'Nuştekarê $1î unlink biyo',
	'code-author-badtoken' => 'Hetayê seans ena hereket ho keno.',
	'code-browsing-path' => "Ti revizyonan ke zerre '''$1'''  de înan browse keno",
	'code-field-id' => 'Revizyon',
	'code-field-author' => 'Nuştekar',
	'code-field-user' => 'Xulase dayoğ',
	'code-field-message' => 'Xulasayê commitî',
	'code-field-status' => 'Statu',
	'code-field-timestamp' => 'Wext',
	'code-field-comments' => 'Notan',
	'code-field-path' => 'Raher',
	'code-field-text' => 'Not',
	'code-field-select' => 'Weçine',
	'code-rev-author' => 'Nuştekar:',
	'code-rev-date' => 'Wext:',
	'code-rev-message' => 'Xulasa:',
	'code-rev-repo' => 'Arşîv:',
	'code-rev-rev' => 'Revizyon:',
	'code-rev-rev-viewvc' => 'ser ViewVC',
	'code-rev-paths' => 'Reharanê vurîyaye:',
	'code-rev-modified-a' => 'de biyo',
	'code-rev-modified-r' => 'vurîyo',
	'code-rev-modified-d' => 'wedarîyo',
	'code-rev-modified-m' => 'vurîya',
	'code-rev-imagediff' => 'Vurnayîşê resimî',
	'code-rev-status' => 'Statu:',
	'code-rev-status-set' => 'Statu bivurne',
	'code-rev-tags' => 'Etiketan:',
	'code-rev-tag-add' => 'Etiketan de bike:',
	'code-rev-tag-remove' => 'Etiketan wedarne:',
	'code-rev-comment-by' => 'Xulasayê $1î',
	'code-rev-comment-preview' => 'Ver qeyd',
	'code-rev-inline-preview' => 'Ver qeyd:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'Ena diff zaf girda.',
	'code-rev-purge-link' => 'purge bike',
	'code-rev-total' => 'Amarê neticeyanê hemi: $1',
	'code-status-new' => 'newe',
	'code-status-fixme' => 'fixme',
	'code-status-reverted' => 'revert biye',
	'code-status-resolved' => 'resolve biye',
	'code-status-ok' => 'temam',
	'code-status-deferred' => 'defer biyo',
	'code-status-old' => 'kihan',
	'code-pathsearch-legend' => 'Pê raherî zerrê ena repo de vurnayîşan bigêre',
	'code-pathsearch-path' => 'Raher:',
	'code-pathsearch-filter' => 'Filitre hewitiyena',
	'code-revfilter-cr_status' => 'Statu = $1',
	'code-revfilter-cr_author' => 'Nustekar = $1',
	'code-revfilter-clear' => 'Filtre wedarne',
	'code-rev-submit' => 'Vuranayîşan qeyd bike',
	'code-rev-submit-next' => 'Keyd ke & neresolve binî',
	'code-batch-status' => 'Statuyan bivurne:',
	'code-batch-tags' => 'Etiketan bivurne:',
	'codereview-batch-title' => 'Revizyonanê ke ti specîfe kerd înan bivurne',
	'codereview-batch-submit' => 'Qeyd ke',
	'code-releasenotes' => 'notan verade',
	'code-release-legend' => 'Notanê releaseyî viraze',
	'code-release-startrev' => 'Revizyonê verînî:',
	'code-release-endrev' => 'Revizyonê penî:',
	'codereview-subtitle' => 'Qe $1',
	'codereview-reply-link' => 'cewab bide',
	'codereview-email-subj' => '[$1 $2]: Xulasayê newî de biyo',
	'codereview-email-body' => 'Karberê "$1"î yew xulasa se $3 rê nuşt.

Full URL: $2

Xulasa:

$4',
	'codereview-email-subj2' => '[$1 $2]: Vurnayîşan kontrol bike',
	'codereview-email-body2' => 'Karberê "$1"î,  $2  vurna.

Full URL: $3

Xulasa:

$4',
	'codereview-email-subj3' => '[$1 $2]: Regression otomatik test keno',
	'codereview-email-body3' => 'Qe vurnayîşê $1î otomatik test yew regression mucna.

Full URL: $2

Xulasa:

$3',
	'repoadmin' => 'Îdarê Kerdîşê Arşîvî',
	'repoadmin-new-legend' => 'Yew arşîvê newî viraze',
	'repoadmin-new-label' => 'Nameyê arşîvî:',
	'repoadmin-new-button' => 'Biviraz',
	'repoadmin-edit-legend' => 'Arşîvê $1î mofifiye kerdişî',
	'repoadmin-edit-path' => 'Patikayê arşîvî:',
	'repoadmin-edit-bug' => 'Patikayê bugzillayî:',
	'repoadmin-edit-view' => 'Patikayê ViewVCyî:',
	'repoadmin-edit-button' => 'Temam',
	'repoadmin-edit-sucess' => 'Arşîvê "[[Special:Code/$1|$1]]"î vurne.',
	'right-repoadmin' => 'Arşîvê kodî îdare bike',
	'right-codereview-use' => 'Kar kerdişê xasî: Kod',
	'right-codereview-add-tag' => 'Revîzyonî ra etîketanê newî de keno',
	'right-codereview-remove-tag' => 'Revîzyonî ra etîketan de keno',
	'right-codereview-post-comment' => 'Revîzyonî rê xulasa de keno',
	'right-codereview-set-status' => 'Statuyê revîzyonî vurneno',
	'right-codereview-link-user' => 'Nuştekarî, karberanê wîkî rê link keno',
	'specialpages-group-developer' => 'Xacetanê raverberdoğî',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'code' => 'Kodowa kontrola',
	'code-rev-title' => '$1 - Pśeglědanje koda',
	'code-comments' => 'Komentary',
	'code-references' => 'Naslědne wersije',
	'code-change-status' => "jo '''status''' wersije $1 změnił",
	'code-change-tags' => "jo '''toflicki''' za wersiju $1 změnił",
	'code-change-removed' => 'wótpórany:',
	'code-change-added' => 'pśidany:',
	'code-old-status' => 'Stary status',
	'code-new-status' => 'Nowy status',
	'code-prop-changes' => 'Protokol statusa & toflickow',
	'codereview-desc' => '[[Special:Code|Rěd za kodowu kontrolu]] z [[Special:RepoAdmin|pódpěru za Subversion]]',
	'code-no-repo' => 'Žeden repozitorium konfigurěrowany!',
	'code-repo-not-found' => "Repositorium '''$1''' njeeksistěrujo!",
	'code-load-diff' => 'Rozdźěl se zacytujo...',
	'code-notes' => 'aktualne komentary',
	'code-statuschanges' => 'změny statusa',
	'code-mycommits' => 'moje pśepowdaśa',
	'code-authors' => 'awtory',
	'code-status' => 'statusy',
	'code-tags' => 'toflicki',
	'code-authors-text' => 'To jo lisćina awtorow repozitoriuma sortěrowanych pó mjenjach. Lokalne wikikonta pokazuju se w spinkach. Daty mógu z pufrowaka byś.',
	'code-author-haslink' => 'Awtor jo z wikijowym wužywarjom $1 zwězany',
	'code-author-orphan' => 'SVN-wužywaŕ|Awtor $1 njejo z wikikontom zwězany',
	'code-author-dolink' => 'Toś togo awtora z wikijowym wužywarjom zwězaś:',
	'code-author-alterlink' => 'Wikijowego wužywarja změniś, kótaryž jo z toś tym awtorom zwězany:',
	'code-author-orunlink' => 'Abo toś togo wikijowego wužywarja rozwězaś:',
	'code-author-name' => 'Wužywarske mě zapódaś:',
	'code-author-success' => 'Awtor $1 jo se z wikijowym wužywarjom $2 zwězał',
	'code-author-link' => 'zwězaś?',
	'code-author-unlink' => 'rozwězaś?',
	'code-author-unlinksuccess' => 'Awtor $1 jo se rozwězał',
	'code-author-badtoken' => 'Pósejźeńska zmólka pśi wuwjeźenju akcije.',
	'code-author-total' => 'Cełkowna licba awtorow: $1',
	'code-browsing-path' => "Pśepytuju se wersije w '''$1'''",
	'code-field-id' => 'Rewizija',
	'code-field-author' => 'Awtor',
	'code-field-user' => 'Komentator',
	'code-field-message' => 'Zespominanje nagraś',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Komentary',
	'code-field-path' => 'Sćažka',
	'code-field-text' => 'Pśipisk',
	'code-field-select' => 'Wubraś',
	'code-rev-author' => 'Awtor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Komentar:',
	'code-rev-repo' => 'Repozitorium:',
	'code-rev-rev' => 'Rewizija:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Změnjone sćažki:',
	'code-rev-modified-a' => 'pśidany',
	'code-rev-modified-r' => 'wuměnjony',
	'code-rev-modified-d' => 'wulašowany',
	'code-rev-modified-m' => 'změnjony',
	'code-rev-imagediff' => 'Wobrazowe změny',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status změniś',
	'code-rev-tags' => 'Toflicki:',
	'code-rev-tag-add' => 'Toflicki pśidaś:',
	'code-rev-tag-remove' => 'Toflicki wótwónoźeś:',
	'code-rev-comment-by' => 'Komentar wót $1',
	'code-rev-comment-preview' => 'Pśeglěd',
	'code-rev-inline-preview' => 'Pśeglěd:',
	'code-rev-diff' => 'Rozdźěl',
	'code-rev-diff-link' => 'rozdźěl',
	'code-rev-diff-too-large' => 'Rozdźěl jo pśewjeliki za zwobraznjenje.',
	'code-rev-purge-link' => 'Cache wuprozniś',
	'code-rev-total' => 'Cełkowna licba wuslědkow: $1',
	'code-status-new' => 'nowy',
	'code-status-fixme' => 'pórěźiś',
	'code-status-reverted' => 'anulěrowany',
	'code-status-resolved' => 'wótbyty',
	'code-status-ok' => 'w pórěźe',
	'code-status-deferred' => 'wótstarcony',
	'code-status-old' => 'stary',
	'code-signoff-flag-inspected' => 'Inspicěrowany',
	'code-signoff-flag-tested' => 'Testowany',
	'code-signoff-field-user' => 'Wužywaŕ',
	'code-signoff-field-flag' => 'Chórgojck',
	'code-signoff-field-date' => 'Datum',
	'code-pathsearch-legend' => 'Wersije w toś tom repozitoriumje pó sćažce pytaś',
	'code-pathsearch-path' => 'Sćažka:',
	'code-pathsearch-filter' => 'Jano pokazaś:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Awtor = $1',
	'code-revfilter-clear' => 'Filter lašowaś',
	'code-rev-submit' => 'Změny składowaś',
	'code-rev-submit-next' => 'Składowaś & pśiducy njekontrolěrowany',
	'code-batch-status' => 'Status změniś:',
	'code-batch-tags' => 'Toflicki změniś:',
	'codereview-batch-title' => 'Wšě wubrane wersije změniś',
	'codereview-batch-submit' => 'Wótpósłaś',
	'code-releasenotes' => 'Pśispomnjeśa wó wersiji',
	'code-release-legend' => 'Pśipomnjeśa wó wersiji napóraś',
	'code-release-startrev' => 'Prědna wersija:',
	'code-release-endrev' => 'Slědna wersija:',
	'codereview-subtitle' => 'Za $1',
	'codereview-reply-link' => 'wótegroniś',
	'codereview-email-subj' => '[$1 $2]: Nowy komentar pśidany',
	'codereview-email-body' => 'Wužywaŕ "$1" jo komentar wó $3 pósłał.
URL: $2

Zespominanje za $3:

$5

Komentar wužywarja $1:

$4',
	'codereview-email-subj2' => '[$1 $2]: Naslědne změny',
	'codereview-email-body2' => 'Wužywaŕ "$1" su naslědne změny k $2 cynił.
URL: $5

Zespominanje za naslědnu wersiju $2:

$6

Naslědny URL: $3
Naslědne zespominanje wót "$1":

$4',
	'codereview-email-subj3' => '[$1 $2]: Status wersije jo se změnił',
	'codereview-email-body3' => 'Wužywaŕ "$1" jo změnił status wersije  $2 do "$4"
URL $5

Stary status: $3
Nowy status: $4

Zespominanje za $2:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nowy komentar pśidany a status wersije změnjony',
	'code-stats' => 'statistiki',
	'code-stats-header' => 'Repozitoriumowa statistika za $1',
	'code-stats-main' => 'Wót $1 repozitorium ma $2 {{PLURAL:$2|wersiju|wersiji|wersije|wersijow}} wót [[Special:Code/$3/author|$4 {{PLURAL:$4|awtora|awtorowu|awtorow|awtorow}}]].',
	'code-stats-status-breakdown' => 'Licba wersijow na status',
	'code-stats-fixme-breakdown' => 'Rozklucenje wersijow z FIXME na awtora',
	'code-stats-count' => 'Licba wersijow',
	'repoadmin' => 'Administracija repozitoriuma',
	'repoadmin-new-legend' => 'Nowy repozitorium napóraś',
	'repoadmin-new-label' => 'Mě repozitoriuma:',
	'repoadmin-new-button' => 'Napóraś',
	'repoadmin-edit-legend' => 'Změnjenje repozitoriuma "$1"',
	'repoadmin-edit-path' => 'Sćažka repozitoriuma:',
	'repoadmin-edit-bug' => 'Sćažka Bugzilla:',
	'repoadmin-edit-view' => 'Sćažka k ViewVC:',
	'repoadmin-edit-button' => 'W pórěźe',
	'repoadmin-edit-sucess' => 'Repozitorium "[[Special:Code/$1|$1]]" jo se wuspěšnje změnił.',
	'right-repoadmin' => 'Kodowe repozitoriumy zastojaś',
	'right-codereview-use' => 'Special:Code wužywaś',
	'right-codereview-add-tag' => 'Nowe toflicki rewizijam pśidaś',
	'right-codereview-remove-tag' => 'Toflicki z rewizijow wótwónoźeś',
	'right-codereview-post-comment' => 'Komentary wó rewizijach pśidaś',
	'right-codereview-set-status' => 'Status rewizijow změniś',
	'right-codereview-link-user' => 'Awtorow z wikijowymi wužywarjami zwězaś',
	'action-repoadmin' => 'kodowe repozitoriumy zastojaś',
	'action-codereview-use' => 'Special:Code wužywaś',
	'action-codereview-add-tag' => 'nowe toflicki rewizijam pśidaś',
	'action-codereview-remove-tag' => 'toflicki z rewizijow wótwónoźeś',
	'action-codereview-post-comment' => 'komentary wó rewizijach pśidaś',
	'action-codereview-set-status' => 'status rewizijow změniś',
	'action-codereview-signoff' => 'wersije pśizwóliś',
	'action-codereview-link-user' => 'awtorow z wikiwužywarjami zwězaś',
	'action-codereview-associate' => 'wersijowe zwiski zastojaś',
	'action-codereview-review-own' => 'swóje wersije ako "{{int:code-status-ok}} abo "{{int:code-status-resolved}}" markěrowaś',
	'specialpages-group-developer' => 'Rědy wuwiwarjow',
	'group-svnadmins' => 'SVN-administratory',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-administrator|SVN-administratorka}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-administratory',
);

/** Ewe (Eʋegbe)
 * @author Natsubee
 */
$messages['ee'] = array(
	'code-field-timestamp' => 'Ŋkeke',
	'code-rev-date' => 'Ŋkeke:',
	'code-rev-comment-preview' => 'Kpɔe do ŋgɔ',
	'repoadmin-new-button' => 'Dze egɔme',
);

/** Greek (Ελληνικά)
 * @author Crazymadlover
 * @author Dead3y3
 * @author Evropi
 * @author Glavkos
 * @author Omnipaedista
 * @author ZaDiak
 * @author Απεργός
 */
$messages['el'] = array(
	'code' => 'Επιθεώρηση του κώδικα',
	'code-rev-title' => '$1 - Επιθεώρηση του Κώδικα',
	'code-comments' => 'Σχόλια',
	'code-references' => 'Παρακολούθηση επεξεργασιών',
	'code-change-status' => "έγινε αλλαγή της '''κατάστασης''' του $1",
	'code-change-tags' => "έγινε αλλαγή των '''ετικετών''' για την $1",
	'code-change-removed' => 'αφαιρέθηκε:',
	'code-change-added' => 'προστέθηκε:',
	'code-old-status' => 'Παλιά κατάσταση',
	'code-new-status' => 'Νέα κατάσταση',
	'code-prop-changes' => 'Αρχείο καταγραφής κατάστασης και προσθήκης ετικετών',
	'codereview-desc' => '[[Special:Code|Εργαλείο ανασκόπησης κώδικα]] με [[Special:RepoAdmin|υποστήριξη Subversion]]',
	'code-no-repo' => 'Κανένα αποθηκευτήριο δεν έχει διαμορφωθεί!',
	'code-create-repo' => 'Πηγαίνετε στο [[Special:RepoAdmin|RepoAdmin]] για να δημιουργήσετε ένα Αποθετήριο',
	'code-need-repoadmin-rights' => 'Δικαιώματα διαχείρισης αποθηκευτηρίου απαιτούνται για τη δημιουργία αποθηκευτηρίου.',
	'code-need-group-with-rights' => 'Δεν υπάρχει ομάδα με δικαιώματα repoadmin. Παρακαλώ προσθέστε μια έτσι ώστε να είναι εφικτή η προσθήκη ενός νέου Αποθετήριου',
	'code-repo-not-found' => "Το αποθετήριο '''$1''' δεν υπάρχει!",
	'code-load-diff' => 'Φόρτωση διαφ...',
	'code-notes' => 'πρόσφατα σχόλια',
	'code-statuschanges' => 'αλλαγές κατάστασης',
	'code-mycommits' => 'οι καταχωρήσεις μου',
	'code-mycomments' => 'Τα σχόλια μου',
	'code-authors' => 'συγγραφείς',
	'code-status' => 'καταστάσεις',
	'code-tags' => 'ετικέτες',
	'code-tags-no-tags' => 'Δεν υπάρχουν ετικέτες  σε αυτό το αποθετήριο.',
	'code-authors-text' => 'Παρακάτω είναι μια λίστα από συντάκτες του αποθηκευτηρίου κατά σειρά του ονόματος που χρησιμοποιεί ο καθένας για καταχωρήσεις. Οι τοπικοί λογαριασμοί στο wiki εμφανίζονται μέσα σε παρενθέσεις. Ενδέχεται τα δεδομένα να έχουν ληφθεί από προσωρινή μνήμη (και να μην είναι ενημερωμένα).',
	'code-author-haslink' => 'Αυτός ο συγγραφέας είναι συνδεδεμένος με τον χρήστη wiki $1',
	'code-author-orphan' => 'SVN χρήστης/Συγγραφέας $1 δεν έχει κανέναν  σύνδεσμο με έναν λογαριασμό wiki',
	'code-author-dolink' => 'Σύνδεση αυτού του χρήστη με έναν χρήστη wiki:',
	'code-author-alterlink' => 'Αλλαγή του χρήστη wiki συνδεδεμένου με αυτό τον συγγραφέα:',
	'code-author-orunlink' => 'Ή αποδιασύνδεση αυτού του χρήστη wiki:',
	'code-author-name' => 'Εισάγετε ένα όνομα χρήστη:',
	'code-author-success' => 'Ο συγγραφέας $1 έχει συνδεθεί με τον χρήστη wiki $2',
	'code-author-link' => 'σύνδεση;',
	'code-author-unlink' => 'αποσύνδεση;',
	'code-author-unlinksuccess' => 'Ο συγγραφέας $1 έχει αποδιασυνδεθεί',
	'code-author-badtoken' => 'Σφάλμα  συνεδρίασης κατά την προσπάθεια εκτέλεσης της ενέργειας.',
	'code-author-total' => 'Συνολικός αριθμός συγγραφέων: $1',
	'code-author-lastcommit' => 'Τελευταία ημερομηνία μιας καταχώρησης:',
	'code-browsing-path' => "Περιήγηση αναθεωρήσεων στο '''$1'''",
	'code-field-id' => 'Αναθεώρηση',
	'code-field-author' => 'Συγγραφέας',
	'code-field-user' => 'Σχολιαστής',
	'code-field-message' => 'Περίληψη προσθηκών',
	'code-field-status' => 'Κατάσταση',
	'code-field-status-description' => 'Περιγραφή κατάστασης',
	'code-field-timestamp' => 'Ημερομηνία',
	'code-field-comments' => 'Σχόλια',
	'code-field-path' => 'Διαδρομή',
	'code-field-text' => 'Σημείωμα',
	'code-field-select' => 'Επιλογή',
	'code-reference-remove' => 'Κατάργηση επιλεγμένων συνδέσεων',
	'code-reference-associate-submit' => 'Συσχέτιση',
	'code-rev-author' => 'Συγγραφέας:',
	'code-rev-date' => 'Ημερομηνία:',
	'code-rev-message' => 'Σχόλιο:',
	'code-rev-repo' => 'Αποθηκευτήριο:',
	'code-rev-rev' => 'Αναθεώρηση:',
	'code-rev-rev-viewvc' => 'για το ViewVC',
	'code-rev-paths' => 'Τροποποιημένες διαδρομές:',
	'code-rev-modified-a' => 'προστέθηκε',
	'code-rev-modified-r' => 'αντικαταστάθηκε',
	'code-rev-modified-d' => 'διαγράφηκε',
	'code-rev-modified-m' => 'τροποποιήθηκε',
	'code-rev-imagediff' => 'Αλλαγές εικόνων',
	'code-rev-status' => 'Κατάσταση:',
	'code-rev-status-set' => 'Αλλαγή κατάστασης',
	'code-rev-tags' => 'Ετικέτες:',
	'code-rev-tag-add' => 'Προσθήκη ετικετών:',
	'code-rev-tag-remove' => 'Αφαίρεση ετικετών:',
	'code-rev-comment-by' => 'Σχόλιο από τον $1',
	'code-rev-comment-preview' => 'Προεπισκόπηση',
	'code-rev-inline-preview' => 'Προεπισκόπηση:',
	'code-rev-diff' => 'Διαφορά',
	'code-rev-diff-link' => 'διαφορά',
	'code-rev-diff-too-large' => 'Η διαφορά είναι πολύ μεγάλη για να εμφανιστεί.',
	'code-rev-purge-link' => 'εκκαθάριση',
	'code-rev-total' => 'Συνολικός αριθμός αποτελεσμάτων: $1',
	'code-rev-not-found' => "Η αναθεώρηση '''$1''' δεν υπάρχει!",
	'code-rev-history-link' => 'ιστορικό',
	'code-status-new' => 'νέο',
	'code-status-fixme' => 'επιδιόρθωση',
	'code-status-desc-fixme' => 'Η αναθεώρηση παρουσιάζει ένα σφάλμα ή είναι κατεστραμμένη. Θα πρέπει να επισκευαστεί  ή να αναστραφεί.',
	'code-status-reverted' => 'αναστράφηκε',
	'code-status-desc-reverted' => 'Η αλλαγή αναιρέθηκε από μεταγενέστερη αναθεώρηση.',
	'code-status-resolved' => 'επιλύθηκε',
	'code-status-desc-resolved' => 'Η αλλαγή είχε πρόβλημα που λύθηκε από μεταγενέστερη αναθεώρηση.',
	'code-status-ok' => 'εντάξει',
	'code-status-desc-ok' => 'Η αλλαγή υπέστη αναθεώρηση και ο επιθεωρητής είναι σίγουρος ότι η αλλαγή είναι μια χαρά από όλες τις όψεις.',
	'code-status-deferred' => 'αναβλήθηκε',
	'code-status-desc-deferred' => 'Η αλλαγή δεν χρειάζεται επιθεώρηση.',
	'code-status-old' => 'παλαιά',
	'code-status-desc-old' => 'Παλιά αναθεώρηση με ενδεχόμενα σφάλματα τα οποία δεν αξίζουν τον κόπο της επιθεώρησης.',
	'code-signoffs' => 'Εγκρίσεις',
	'code-signoff-legend' => 'Προσθήκη έγκρισης',
	'code-signoff-submit' => 'Έγκριση',
	'code-signoff-strike' => 'Διακριτή διαγραφή επιλεγμένων εγκρίσεων',
	'code-signoff-signoff' => 'Έγκριση αυτής της αναθεώρησης ως:',
	'code-signoff-flag-inspected' => 'Εξετάστηκε',
	'code-signoff-flag-tested' => 'Δοκιμασμένο',
	'code-signoff-field-user' => 'Χρήστης',
	'code-signoff-field-flag' => 'Αναφορά',
	'code-signoff-field-date' => 'Ημερομηνία',
	'code-signoff-struckdate' => '$1 (έπληξε $2)',
	'code-pathsearch-legend' => 'Αναζήτηση αναθεωρήσεων σε αυτό το αποθηκευτήριο κατά διαδρομή',
	'code-pathsearch-path' => 'Διαδρομή:',
	'code-pathsearch-filter' => 'Εμφάνιση μόνο:',
	'code-revfilter-cr_status' => 'Κατάσταση = $1',
	'code-revfilter-cr_author' => 'Συγγραφέας = $1',
	'code-revfilter-ct_tag' => 'Επισήμανση = $1',
	'code-revfilter-clear' => 'Εκκαθάριση φίλτρου',
	'code-rev-submit' => 'Αποθήκευση αλλαγών',
	'code-rev-submit-next' => 'Τα Αποθήκευση αυτής της σελίδας & Επόμενη δεν έχουν επιλυθεί',
	'code-rev-next' => 'Επόμενο άλυτο',
	'code-batch-status' => 'Αλλαγή κατάστασης:',
	'code-batch-tags' => 'Αλλαγή ετικετών:',
	'codereview-batch-title' => 'Αλλαγή όλων των επιλεγμένων αναθεωρήσεων',
	'codereview-batch-submit' => 'Υποβολή',
	'code-releasenotes' => 'σημειώσεις έκδοσης',
	'code-release-legend' => 'Παραγωγή σημειώσεων έκδοσης',
	'code-release-startrev' => 'Εναρκτήρια αναθ:',
	'code-release-endrev' => 'Τελευταία αναθ:',
	'codereview-subtitle' => 'Για το $1',
	'codereview-reply-link' => 'απάντηση',
	'codereview-overview-title' => 'Επισκόπηση',
	'codereview-overview-desc' => 'Εμφανίστε  μια γραφική επισκόπηση αυτού του καταλόγου',
	'codereview-email-subj' => '[$1 $2]: Προστέθηκε νέο σχόλιο',
	'codereview-email-body' => 'Ο χρήστης "$1" απέστειλε σχόλιο για το $3.

Πλήρες URL: $2
Σύνοψη της καταχώρησης:

$5

Σχόλιο:

$4',
	'codereview-email-subj2' => '[$1 $2]: Περαιτέρω αλλαγές',
	'codereview-email-body2' => 'Ο χρήστης "$1" πραγματοποίησε περαιτέρω αλλαγές στο $2.

Πλήρες URL για τη προγενέστερη αλλαγή: $5
Σύνοψη της καταχώρησης:

$6

Πλήρες URL: $3
Σύνοψη της καταχώρησης:

$4',
	'codereview-email-subj3' => '[$1 $2]: Η κατάσταση της αλλαγής άλλαξε',
	'codereview-email-body3' => 'Ο/η χρήστης "$1" άλλαξε τη κατάσταση του $2.

Παλιά κατάσταση: $3
Νέα κατάσταση: $4

Πλήρες URL: $5
Σύνοψη της καταχώρησης:

$6',
	'codereview-email-subj4' => '[$1 $2]: Προστέθηκε καινούριο σχόλιο  κι άλλαξε επίσης η κατάσταση της αλλαγής',
	'codereview-email-body4' => 'Ο χρήστης "$1" άλλαξε την κατάσταση του $2.

Παλιά κατάσταση: $3
Νέα κατάσταση: $4

Ο χρήστης "$1" επίσης απέστειλε σχόλιο για το $2.

Πλήρες URL: $5
Σύνοψη της καταχώρησης:

$7

Σχόλιο:

$6',
	'code-stats' => 'στατιστικές',
	'code-stats-header' => 'Στατιστικά για το αποθηκευτήριο $1',
	'code-stats-main' => 'Από τις $1, το αποθηκευτήριο περιέχει $2 {{PLURAL:$2|αναθεώρηση|αναθεωρήσεις}} από [[Special:Code/$3/author|$4 {{PLURAL:$4|συγγραφέα|συγγραφείς}}]].',
	'code-stats-status-breakdown' => 'Αριθμός αναθεωρήσεων ανά κατάσταση',
	'code-stats-new-breakdown' => 'Κατανομή των νέων αναθεωρήσεων ανά συγγραφέα',
	'code-stats-count' => 'Αριθμός αναθεωρήσεων',
	'code-tooltip-withsummary' => 'r$1 [$2] σπό $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] σπό $3',
	'repoadmin' => 'Διαχείριση του αποθηκευτηρίου',
	'repoadmin-new-legend' => 'Δημιουργία νέου αποθηκευτηρίου',
	'repoadmin-new-label' => 'Όνομα αποθηκευτηρίου:',
	'repoadmin-new-button' => 'Δημιουργία',
	'repoadmin-edit-legend' => 'Μετατροπή του αποθηκευτηρίου "$1"',
	'repoadmin-edit-path' => 'Διαδρομή αποθηκευτηρίου:',
	'repoadmin-edit-bug' => 'Διαδρομή Bugzilla:',
	'repoadmin-edit-view' => 'Διαδρομή ViewVC:',
	'repoadmin-edit-button' => 'Εντάξει',
	'repoadmin-edit-sucess' => 'Το αποθηκευτήριο "[[Special:Code/$1|$1]]" τροποποιήθηκε επιτυχώς.',
	'repoadmin-nav' => 'Διαχείριση του αποθηκευτηρίου',
	'right-repoadmin' => 'Διαχείριση αποθηκευτηρίων κώδικα',
	'right-codereview-use' => 'Χρήση του Special:Code',
	'right-codereview-add-tag' => 'Προσθήκη νέων ετικετών σε αναθεωρήσεις',
	'right-codereview-remove-tag' => 'Αφαίρεση ετικετών από αναθεωρήσεις',
	'right-codereview-post-comment' => 'Προσθήκη σχολίων σε αναθεωρήσεις',
	'right-codereview-set-status' => 'Αλλαγή κατάστασης αναθεωρήσεων',
	'right-codereview-signoff' => 'Έγκριση αναθεωρήσεων',
	'right-codereview-link-user' => 'Σύνδεση συγγραφέων με χρήστες wiki',
	'right-codereview-associate' => 'Διαχειριστείτε τους συνδέσμους αναθεώρησης',
	'specialpages-group-developer' => 'Εργαλεία προγραμματιστών',
	'group-svnadmins' => 'διαχειριστές SVN',
	'group-svnadmins-member' => 'Διαχειριστής SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Διαχειριστές SVN',
);

/** Esperanto (Esperanto)
 * @author Blahma
 * @author Castelobranco
 * @author Yekrats
 */
$messages['eo'] = array(
	'code' => 'Kontrolo de Programkodo',
	'code-rev-title' => '$1 - Koda Kontrolo',
	'code-comments' => 'Komentoj',
	'code-references' => 'Farindaj revizioj',
	'code-change-status' => "ŝanĝis la '''statuson''' de $1",
	'code-change-tags' => "ŝanĝis la '''etikedojn''' por $1",
	'code-change-removed' => 'forigis:',
	'code-change-added' => 'aldonis:',
	'code-old-status' => 'Malnova statuso',
	'code-new-status' => 'Nova statuso',
	'code-prop-changes' => 'Protokolo pri statuso kaj etikedoj',
	'codereview-desc' => '[[Special:Code|Koda kontrolilo]] kun [[Special:RepoAdmin|subteno por Subversion]]',
	'code-no-repo' => 'Neniu kodujoj estas konfigurataj',
	'code-create-repo' => 'Iru al [[Special:RepoAdmin|RepoAdmin]] por krei kodo-deponejon',
	'code-need-repoadmin-rights' => 'Rajtojn de "repoadmin" permesas al uzanto krei deponejo',
	'code-need-group-with-rights' => 'Neniu grupo kun rajtoj repoadmin ekzistas. Bonvolu aldoni unu por aldoni novan Deponejon.',
	'code-repo-not-found' => "Dosierujo '''$1''' ne ekzistas!",
	'code-load-diff' => 'Ŝarĝante diferencon...',
	'code-notes' => 'lastaj komentoj',
	'code-statuschanges' => 'statusaj ŝanĝoj',
	'code-mycommits' => 'miaj publikigitaĵoj',
	'code-mycomments' => 'miaj komentoj',
	'code-authors' => 'aŭtoroj',
	'code-status' => 'statoj',
	'code-tags' => 'etikedoj',
	'code-tags-no-tags' => 'Neniuj etikedoj en ĉi tiu deponujo.',
	'code-authors-text' => 'Jen listo de dosierujaj aŭtoroj ordigitaj laŭ sendita nomo. Loka vikikontoj estas montrataj en parentezoj. Datenoj eble estas en kaŝmemoro.',
	'code-author-haslink' => 'Ĉi tiu aŭtoro estas ligita al la vikiuzanto $1',
	'code-author-orphan' => 'SVN-uzulo/Aŭtoro $1 ne havas ligilon kun vikia konto',
	'code-author-dolink' => 'Ligi ĉi tiun autoron al vikiuzanto:',
	'code-author-alterlink' => 'Ŝanĝi la vikian uzanton ligitan al ĉi tiu aŭtoro:',
	'code-author-orunlink' => 'Aŭ malligi ĉi tiun vikian uzanton:',
	'code-author-name' => 'Enigu salutnomon:',
	'code-author-success' => 'La aŭtoro $1 esits ligita al la vikia uzanto $2',
	'code-author-link' => 'ĉu ligigi?',
	'code-author-unlink' => 'ĉu malligigi?',
	'code-author-unlinksuccess' => 'Aŭtoro $1 estis malligita',
	'code-author-badtoken' => 'Eraro en seanco provante fari la agon.',
	'code-author-total' => 'Suma nombro de aŭtoroj: $1',
	'code-author-lastcommit' => 'Lasta dato de enmetado',
	'code-browsing-path' => "Rigardante reviziojn en '''$1'''",
	'code-field-id' => 'Versio',
	'code-field-author' => 'Aŭtoro',
	'code-field-user' => 'Komentanto',
	'code-field-message' => 'Resumo pri enigo',
	'code-field-status' => 'Statuso',
	'code-field-status-description' => 'Priskribo de statuso',
	'code-field-timestamp' => 'Dato',
	'code-field-comments' => 'Komentoj',
	'code-field-path' => 'Vojo',
	'code-field-text' => 'Noto',
	'code-field-select' => 'Elekti',
	'code-reference-remove' => 'Forigi elektitajn kungrupigojn',
	'code-reference-associate' => 'Kungrupigi revizion kontrolindan:',
	'code-reference-associate-submit' => 'Kungrupigi',
	'code-rev-author' => 'Aŭtoro:',
	'code-rev-date' => 'Dato:',
	'code-rev-message' => 'Komento:',
	'code-rev-repo' => 'Dosierujo:',
	'code-rev-rev' => 'Versio:',
	'code-rev-rev-viewvc' => 'en ViewVC',
	'code-rev-paths' => 'Modifitaj vojoj:',
	'code-rev-modified-a' => 'aldonis',
	'code-rev-modified-r' => 'anstataŭigita',
	'code-rev-modified-d' => 'forigis',
	'code-rev-modified-m' => 'modifis',
	'code-rev-imagediff' => 'Bildaj ŝanĝoj',
	'code-rev-status' => 'Statuso:',
	'code-rev-status-set' => 'Ŝanĝi statuson',
	'code-rev-tags' => 'Etikedoj:',
	'code-rev-tag-add' => 'Aldoni etikedojn:',
	'code-rev-tag-remove' => 'Forigi etikedojn:',
	'code-rev-comment-by' => 'Komento de $1',
	'code-rev-comment-preview' => 'Antaŭrigardi',
	'code-rev-inline-preview' => 'Antaŭvido:',
	'code-rev-diff' => 'Diferenco',
	'code-rev-diff-link' => 'diferenco',
	'code-rev-diff-too-large' => 'La diferenco estas tro granda por montri.',
	'code-rev-purge-link' => 'forviŝi',
	'code-rev-total' => 'Suma nombro de rezultoj: $1',
	'code-rev-not-found' => "Revizio '''$1''' ne ekzistas!",
	'code-rev-history-link' => 'historio',
	'code-status-new' => 'nova',
	'code-status-desc-new' => 'Revizio atendas agon (defaŭlta statuso).',
	'code-status-fixme' => 'riparu-min',
	'code-status-desc-fixme' => 'Revizio aldonis cimon aŭ estas trompita. Ĝi devas esti korektigita aŭ malfarita.',
	'code-status-reverted' => 'malfarita',
	'code-status-desc-reverted' => 'Revizio estis forĵetita de posta revizio.',
	'code-status-resolved' => 'farita',
	'code-status-desc-resolved' => 'Revizio havis problemon kiu estis riparita de posta revizio.',
	'code-status-ok' => 'Ek!',
	'code-status-desc-ok' => 'Revizio plene kontrolita kaj kontrolanto estas pozitiva ke ĝi estas bona ĉiel.',
	'code-status-deferred' => 'prokrastita',
	'code-status-desc-deferred' => 'Revizio ne nepras kontroladon.',
	'code-status-old' => 'malnova',
	'code-status-desc-old' => 'Malnova revizio kun eblaj cimoj kiuj ne sufiĉe gravas kontroli ilin.',
	'code-signoffs' => 'Aprobadoj',
	'code-signoff-legend' => 'Aldoni aprobon',
	'code-signoff-submit' => 'Aprobi',
	'code-signoff-strike' => 'Forstreki elektitajn aprobojn',
	'code-signoff-signoff' => 'Aprobi ĉi tiun revizion kiel:',
	'code-signoff-flag-inspected' => 'Inspektita',
	'code-signoff-flag-tested' => 'Testita',
	'code-signoff-field-user' => 'Uzanto',
	'code-signoff-field-flag' => 'Marki',
	'code-signoff-field-date' => 'Dato',
	'code-signoff-struckdate' => '$1 (forstrekita $2)',
	'code-pathsearch-legend' => 'Serĉi versiojn en ĉi tiu kodujo laŭ vojo',
	'code-pathsearch-path' => 'Vojo:',
	'code-pathsearch-filter' => 'Montri nur:',
	'code-revfilter-cr_status' => 'Statuso = $1',
	'code-revfilter-cr_author' => 'Aŭtoro = $1',
	'code-revfilter-ct_tag' => 'Etikedo = $1',
	'code-revfilter-clear' => 'Forigi filtrilon',
	'code-rev-submit' => 'Konservi ŝanĝojn',
	'code-rev-submit-next' => 'Konservi kaj aliri sekvan nefaritaĵon',
	'code-rev-next' => 'Sekva netraktataĵo',
	'code-batch-status' => 'Ŝanĝi statuson:',
	'code-batch-tags' => 'Ŝanĝi etikedojn:',
	'codereview-batch-title' => 'Ŝanĝi ĉiujn elektitajn reviziojn',
	'codereview-batch-submit' => 'Sendi',
	'code-releasenotes' => 'eldonaj notoj',
	'code-release-legend' => 'Generi eldonajn notojn',
	'code-release-startrev' => 'Komenca revizio:',
	'code-release-endrev' => 'Lasta revizio:',
	'codereview-subtitle' => 'Por $1',
	'codereview-reply-link' => 'respondo',
	'codereview-overview-title' => 'Superrigardo',
	'codereview-overview-desc' => 'Montri grafikan resumon de ĉi tiu listo',
	'codereview-email-subj' => '[$1 $2]: Nova komento estis aldonita',
	'codereview-email-body' => 'Uzanto "$1" afiŝis komenton en $3.

Plena URL-o: $2
Resumo de faraĵo:

$5

Komento:

$4',
	'codereview-email-subj2' => '[$1 $2]: Postatentaj ŝanĝoj',
	'codereview-email-body2' => 'Uzanto "$1" faris postatentadajn ŝanĝojn al $2.

Plena URL por la postatentadaj revizio: $5
Resumo de faraĵo:

$6

Plena URL: $3
Resumo de faraĵo:

$4',
	'codereview-email-subj3' => '[$1 $2]: Revizio-statuso ŝanĝis',
	'codereview-email-body3' => 'Uzanto $1 ŝanĝis la statuson de $2.

Malnova statuso: $3
Nova statuso: $4

Plena URL-o: $5
Resumo de faraĵo:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nova komento estis aldonita, kaj revizio-statuso estis ŝanĝita',
	'codereview-email-body4' => 'Uzanto "$1" ŝanĝis la statuson de $2.

Malnova statuso: $3
Nova statuso: $4

La uzanto "$1" ankaŭ skribis komenton en $2.

Plena URL-o: $5
Resumo de faraĵo:

$7

Komento:

$6',
	'code-stats' => 'statistiko',
	'code-stats-header' => 'Statistiko por deponejo $1',
	'code-stats-main' => 'Ekde $1, la deponejo havas $2 {{PLURAL:$2|revizion|reviziojn}} de [[Special:Code/$3/author|$4 {{PLURAL:$4|aŭtoro|aŭtoroj}}]].',
	'code-stats-status-breakdown' => 'Numero de revizioj por stato',
	'code-stats-fixme-breakdown' => 'Ekzameno po petrevizioj por aŭtoro',
	'code-stats-fixme-breakdown-path' => 'Ekzameno po petrevizioj por vojo',
	'code-stats-fixme-path' => 'Petrevizioj por vojo: $1',
	'code-stats-new-breakdown' => 'Ekzameno po novaj revizioj por aŭtoro',
	'code-stats-new-breakdown-path' => 'Disdivido de novaj revizioj laŭ vojo',
	'code-stats-new-path' => 'Novaj revizioj por vojo: $1',
	'code-stats-count' => 'Nombro de revizioj',
	'code-tooltip-withsummary' => 'r$1 [$2] de $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] de $3',
	'repoadmin' => 'Administrado de Kodujo',
	'repoadmin-new-legend' => 'Krei novan kodujon',
	'repoadmin-new-label' => 'Nomo de dosierujo:',
	'repoadmin-new-button' => 'Krei',
	'repoadmin-edit-legend' => 'Modifado de kodujo "$1"',
	'repoadmin-edit-path' => 'Vojo al dosierujo:',
	'repoadmin-edit-bug' => 'Bugzilla-vojo:',
	'repoadmin-edit-view' => 'ViewVC-vojo:',
	'repoadmin-edit-button' => 'Ek',
	'repoadmin-edit-sucess' => 'La kodujo "[[Special:Code/$1|$1]]" estis sukcese modifita.',
	'repoadmin-nav' => 'administrado de deponejo',
	'right-repoadmin' => 'Administri kodujojn',
	'right-codereview-use' => 'Uzo de Special:Code',
	'right-codereview-add-tag' => 'Aldoni etikedojn al versioj',
	'right-codereview-remove-tag' => 'Forigi etikedojn de versioj',
	'right-codereview-post-comment' => 'Aldoni komentojn en versioj',
	'right-codereview-set-status' => 'Ŝanĝi statuson de versioj',
	'right-codereview-signoff' => 'Aprobi reviziojn',
	'right-codereview-link-user' => 'Ligi aŭtorojn al viki-uzantoj',
	'right-codereview-associate' => 'Trakti asociojn de revizioj',
	'right-codereview-review-own' => 'Marki viajn proprajn reviziojn kiel OK aŭ Riparita',
	'specialpages-group-developer' => 'Disvolvistaj iloj',
	'group-svnadmins' => 'SVN-administrantoj',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-administranto|SVN-administrantino}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-administrantoj',
);

/** Spanish (Español)
 * @author Armando-Martin
 * @author Crazymadlover
 * @author Danke7
 * @author Dferg
 * @author Diego Grez
 * @author Imre
 * @author Locos epraix
 * @author McDutchie
 * @author MetalBrasil
 * @author Omnipaedista
 * @author Pertile
 * @author Platonides
 * @author Remember the dot
 * @author Sanbec
 * @author Translationista
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'code' => 'Revisión de código',
	'code-rev-title' => '$1 - Revisión de Código',
	'code-comments' => 'Comentarios',
	'code-references' => 'Revisiones de seguimiento',
	'code-referenced' => 'Revisiones de seguimiento',
	'code-change-status' => "cambiado el '''status''' de $1",
	'code-change-tags' => "cambiadas las '''etiquetas''' de $1",
	'code-change-removed' => 'quitados:',
	'code-change-added' => 'agregado:',
	'code-old-status' => 'Antiguo status',
	'code-new-status' => 'Nuevo status',
	'code-prop-changes' => 'Registro de estatus y etiquetado',
	'codereview-desc' => "[[Special:Code|Herramienta de revisión de código]] con [[Special:RepoAdmin|apoyo de ''Subversion'']]",
	'code-no-repo' => '¡No está configurado el repositorio!',
	'code-create-repo' => 'Ir a [[Special:RepoAdmin|RepoAdmin]] para crear un repositorio',
	'code-need-repoadmin-rights' => 'Son necesarios derechos como "RepoAdmin" para poder crear un repositorio',
	'code-need-group-with-rights' => 'No existe ningún grupo con derechos de "repoadmin". Agregue uno para poder agregar un nuevo repositorio',
	'code-repo-not-found' => "Repositorio '''$1''' no existe!",
	'code-load-diff' => 'Cargando diferencias...',
	'code-notes' => 'comentarios recientes',
	'code-statuschanges' => 'cambios de status',
	'code-mycommits' => 'mis publicaciones',
	'code-mycomments' => 'mis comentarios',
	'code-authors' => 'autores',
	'code-status' => 'estados',
	'code-tags' => 'etiquetas',
	'code-tags-no-tags' => 'No hay etiquetas en este repositorio.',
	'code-authors-text' => 'A continuación verás un listado de los autores de repositorios en orden de nombre de tarea. Las cuentas de wiki locales se muestran entre paréntesis. La información puede ser cacheada.',
	'code-author-haslink' => 'Este autor está enlazado con el usuario $1',
	'code-author-orphan' => 'SVN usuario/Autor $1 no tiene vínculo con una cuenta wiki',
	'code-author-dolink' => 'Enlazar este autor con un usuario:',
	'code-author-alterlink' => 'Cambiar el usuario enlazado con este autor:',
	'code-author-orunlink' => 'O desenlazar este usuario:',
	'code-author-name' => 'Introducir un nombre de usuario:',
	'code-author-success' => 'El autor $1 ha sido enlazado con el usuario $2',
	'code-author-link' => '¿enlazar?',
	'code-author-unlink' => '¿desenlazar?',
	'code-author-unlinksuccess' => 'El autor $1 ha sido desenlazado',
	'code-author-badtoken' => 'Error de sesión al intentar realizar la acción.',
	'code-author-total' => 'Número total de autores: $1',
	'code-author-lastcommit' => 'Última fecha de confirmación',
	'code-browsing-path' => "Navegando por las revisiones en '''$1'''",
	'code-field-id' => 'Revisión',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentarista',
	'code-field-message' => 'Comentario',
	'code-field-status' => 'Estado',
	'code-field-status-description' => 'Descripción del estado',
	'code-field-timestamp' => 'Fecha',
	'code-field-comments' => 'Comentarios',
	'code-field-path' => 'Ruta',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Seleccionar',
	'code-reference-remove' => 'Quitar las asociaciones seleccionadas',
	'code-reference-associate' => 'Asociar la revisión de seguimiento:',
	'code-reference-associate-submit' => 'Asociar',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Fecha:',
	'code-rev-message' => 'Comentario:',
	'code-rev-repo' => 'Repositorio:',
	'code-rev-rev' => 'Revisión:',
	'code-rev-rev-viewvc' => 'en ViewVC',
	'code-rev-paths' => 'Rutas modificadas:',
	'code-rev-modified-a' => 'añadido',
	'code-rev-modified-r' => 'reemplazado',
	'code-rev-modified-d' => 'borrado',
	'code-rev-modified-m' => 'modificado',
	'code-rev-imagediff' => 'Cambios de imagen',
	'code-rev-status' => 'Estatus:',
	'code-rev-status-set' => 'Cambiar estatus',
	'code-rev-tags' => 'Etiquetas:',
	'code-rev-tag-add' => 'Añadir etiquetas:',
	'code-rev-tag-remove' => 'Quitar etiquetas:',
	'code-rev-comment-by' => 'Comentario de $1',
	'code-rev-comment-preview' => 'Previsualización',
	'code-rev-inline-preview' => 'Previsualización:',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'El diff es demasiado grande para ser mostrado.',
	'code-rev-purge-link' => 'purgar',
	'code-rev-total' => 'Número total de resultados: $1',
	'code-rev-not-found' => "¡La revisión '''$1''' no existe!",
	'code-rev-history-link' => 'historial',
	'code-status-new' => 'nuevo',
	'code-status-desc-new' => 'Esta revisión está pendiente de una acción (estado predeterminado).',
	'code-status-fixme' => 'arréglame',
	'code-status-desc-fixme' => 'Revisión introdujo un error o está rota. Debe ser corregida o revertida.',
	'code-status-reverted' => 'revertido',
	'code-status-desc-reverted' => 'La revisión fue descartada por otra revisión posterior.',
	'code-status-resolved' => 'resuelto',
	'code-status-desc-resolved' => 'La revisión tenía un problema que fue resuelto en una revisión posterior.',
	'code-status-ok' => 'aceptar',
	'code-status-desc-ok' => 'Revisión completamente verificada y considerada completamente correcta.',
	'code-status-deferred' => 'diferido',
	'code-status-desc-deferred' => 'La revisión no requiere revisión.',
	'code-status-old' => 'antiguo',
	'code-status-desc-old' => 'Revisión antigua que puede contener defectos, pero cuya verificación no se justifica.',
	'code-signoffs' => 'Aprobaciones',
	'code-signoff-legend' => 'Agregar firma',
	'code-signoff-submit' => 'Salir',
	'code-signoff-strike' => 'Huelga aprobaciones seleccionados',
	'code-signoff-signoff' => 'Firmar esta revisión:',
	'code-signoff-flag-inspected' => 'Inspeccionado',
	'code-signoff-flag-tested' => 'Probado',
	'code-signoff-field-user' => 'Usuario',
	'code-signoff-field-flag' => 'Marcar',
	'code-signoff-field-date' => 'Fecha',
	'code-signoff-struckdate' => '$1 (golpeado $2 )',
	'code-pathsearch-legend' => 'Buscar revisiones en este repositorio por ruta',
	'code-pathsearch-path' => 'Ruta:',
	'code-pathsearch-filter' => 'Mostrar solamente:',
	'code-revfilter-cr_status' => 'Estado = $1',
	'code-revfilter-cr_author' => 'Autor= $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Limpiar filtro',
	'code-rev-submit' => 'Guardar cambios',
	'code-rev-submit-next' => 'Guardar y siguiente sin resolver',
	'code-rev-next' => 'Siguiente sin resolver',
	'code-batch-status' => 'Cambiar estado:',
	'code-batch-tags' => 'Cambiar marcas:',
	'codereview-batch-title' => 'Cambiar todas las revisiones seleccionadas',
	'codereview-batch-submit' => 'Enviar',
	'code-releasenotes' => 'notas de la versión',
	'code-release-legend' => 'Generar notas de entrega',
	'code-release-startrev' => 'Primera rev:',
	'code-release-endrev' => 'Última rev:',
	'codereview-subtitle' => 'Para $1',
	'codereview-reply-link' => 'responder',
	'codereview-overview-title' => 'Visión general',
	'codereview-overview-desc' => 'Mostrar un resumen gráfico de esta lista',
	'codereview-email-subj' => '[$1 $2]: Añadido nuevo comentario',
	'codereview-email-body' => 'El usuario "$1" envió un comentario en $3.

URL completa: $2
Resumen de  confirmaciones:

$5

Comentario:

$4',
	'codereview-email-subj2' => '[$1 $2]: Cambios de seguimiento',
	'codereview-email-body2' => 'El usuario "$1" ha hecho de modificaciones de seguimiento a $2.

URL completa para la revisión de seguimiento: $5
Resumen de confirmaciones:

$6

URL completa : $3
Resumen de las confirmaciones:

$4',
	'codereview-email-subj3' => '[$1 $2] : El estado de revisión ha cambiado',
	'codereview-email-body3' => 'El usuario "$1" modificó el estado de $2.

Estado antiguo: $3
Estado nuevo: $4

URL completa: $5
Resumen de confirmaciones:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nuevo comentario añadido, y cambiado el estado de la revisión',
	'codereview-email-body4' => 'El usuario "$1" modificó el estado de $2.

Estado antiguo: $3
Estado nuevo: $4

El usuario "$1" ha escrito también un comentario en $2.

URL completa: $5
Resumen de confirmaciones:

$7

Comentario:

$6',
	'code-stats' => 'estadísticas',
	'code-stats-header' => 'Estadísticas del repositorio $1',
	'code-stats-main' => ' A la fecha de $1, el repositorio tiene $2 {{PLURAL:$2|revisión|revisiones}} hechas por [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autores}}]].',
	'code-stats-status-breakdown' => 'Número de revisiones por estado',
	'code-stats-fixme-breakdown' => 'Desglose de las revisiones fixme por autor',
	'code-stats-fixme-breakdown-path' => 'Desglose de las revisiones a arreglar por ruta',
	'code-stats-fixme-path' => 'Revisiones a arreglar en la ruta: $1',
	'code-stats-new-breakdown' => 'Desglose de las revisiones fixme por autor',
	'code-stats-new-breakdown-path' => 'Desglose de nuevas revisiones por ruta',
	'code-stats-new-path' => 'Nuevas revisiones para la ruta de acceso: $1',
	'code-stats-count' => 'Número de revisiones',
	'code-tooltip-withsummary' => 'r $1 [ $2 ] por $3 - $4',
	'code-tooltip-withoutsummary' => 'r $1 [ $2 ] por $3',
	'repoadmin' => 'Administración de repositorio',
	'repoadmin-new-legend' => 'Crear nuevo repositorio',
	'repoadmin-new-label' => 'Nombre de repositorio:',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modificación del repositorio «$1»',
	'repoadmin-edit-path' => 'Ruta de repositorio:',
	'repoadmin-edit-bug' => 'Ruta de Bugzilla:',
	'repoadmin-edit-view' => 'Ruta de ViewVC:',
	'repoadmin-edit-button' => 'Aceptar',
	'repoadmin-edit-sucess' => 'El repositorio «[[Special:Code/$1|$1]]» ha sido modificado correctamente.',
	'repoadmin-nav' => 'administración del repositorio',
	'right-repoadmin' => 'Gestionar repositorios de código',
	'right-codereview-use' => 'Uso de especial:Código',
	'right-codereview-add-tag' => 'Añadir nuevas etiquetas a las revisiones',
	'right-codereview-remove-tag' => 'Quitar etiquetas de las revisiones',
	'right-codereview-post-comment' => 'Añadir comentarios a las revisiones',
	'right-codereview-set-status' => 'Cambiar el estado de las revisiones',
	'right-codereview-signoff' => 'Firmar las revisiones',
	'right-codereview-link-user' => 'Enlazar autores con usuarios',
	'right-codereview-associate' => 'Administrar las asociaciones de revisión',
	'right-codereview-review-own' => 'Marque sus propias revisiones como "{{int:code-status-ok}}" o "{{int:code-status-resolved}}"',
	'action-repoadmin' => 'administrar repositorios de código',
	'action-codereview-use' => 'Uso de Special:Código',
	'action-codereview-add-tag' => 'añadir nuevas etiquetas a las revisiones',
	'action-codereview-remove-tag' => 'eliminar etiquetas de las revisiones',
	'action-codereview-post-comment' => 'añadir comentarios a las revisiones',
	'action-codereview-set-status' => 'cambiar el estado de las revisiones',
	'action-codereview-signoff' => 'Refrendar las revisiones',
	'action-codereview-link-user' => 'enlazar autores con usuarios wiki',
	'action-codereview-associate' => 'administrar asociaciones de revisión',
	'action-codereview-review-own' => 'marcar sus propias revisiones como "{{int:code-status-ok}}" o "{{int:code-status-resolved}}"',
	'specialpages-group-developer' => 'Herramientas para desarrolladores',
	'group-svnadmins' => 'Administradores de SVN',
	'group-svnadmins-member' => '{{GENDER:$1|administrador|administradora}} de SVN',
	'grouppage-svnadmins' => '{{ns:project}}: administradores de SVN',
);

/** Estonian (Eesti)
 * @author Avjoska
 * @author Pikne
 */
$messages['et'] = array(
	'code' => 'Koodiülevaatus',
	'code-rev-title' => '$1 – koodiülevaatus',
	'code-comments' => 'Kommentaarid',
	'code-references' => 'Järelredaktsioonid',
	'code-change-status' => "muutis koodi $1 '''olekut'''",
	'code-change-tags' => "muutis koodile $1 lisatud '''märgiseid'''",
	'code-change-removed' => 'eemaldatud:',
	'code-change-added' => 'lisatud:',
	'code-old-status' => 'Vana olek',
	'code-new-status' => 'Uus olek',
	'code-prop-changes' => 'Oleku- ja märgistamislogi',
	'codereview-desc' => '[[Special:Code|Koodiülevaatuse tööriist]] koos [[Special:RepoAdmin|SVN-toega]]',
	'code-no-repo' => 'Ühtegi hoidlat pole häälestatud.',
	'code-create-repo' => 'Mine [[Special:RepoAdmin|hoidlahaldurisse]], et luua hoidla',
	'code-repo-not-found' => "Hoidlat '''$1''' pole olemas!",
	'code-load-diff' => 'Erinevuste laadimine...',
	'code-notes' => 'viimased kommentaarid',
	'code-statuschanges' => 'oleku muutmised',
	'code-mycommits' => 'minu kehtestamised',
	'code-mycomments' => 'minu kommentaarid',
	'code-authors' => 'autorid',
	'code-status' => 'olekud',
	'code-tags' => 'märgised',
	'code-tags-no-tags' => 'Selles hoidlas pole märgiseid.',
	'code-authors-text' => 'Allpool on loetletud hoidla autorid järjestatuna kehtestajanime järgi. Kohaliku viki kontod on toodud sulgudes. Andmed võivad pärineda puhvrist.',
	'code-author-haslink' => 'See autor on seotud vikikasutajaga $1',
	'code-author-orphan' => 'See SVN-kasutaja või autor pole seotud vikikasutajaga',
	'code-author-name' => 'Sisesta kasutajatunnus:',
	'code-author-success' => 'Autor $1 on ühendatud viki kasutajaga $2.',
	'code-author-link' => 'ühenda?',
	'code-author-unlink' => 'ühenda lahti?',
	'code-author-unlinksuccess' => 'Autor $1 pole enam ühendatud.',
	'code-author-badtoken' => 'Toimingu sooritamisel ilmnes seansitõrge.',
	'code-author-total' => 'Autorite koguarv: $1',
	'code-author-lastcommit' => 'Viimane kehtestamiskuupäev',
	'code-browsing-path' => "Redaktsioonide sirvimine rajal '''$1'''",
	'code-field-id' => 'Redaktsioon',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Kommenteerija',
	'code-field-message' => 'Kommentaar',
	'code-field-status' => 'Olek',
	'code-field-status-description' => 'Oleku kirjeldus',
	'code-field-timestamp' => 'Kuupäev',
	'code-field-comments' => 'Kommentaarid',
	'code-field-path' => 'Rada',
	'code-field-text' => 'Märkus',
	'code-field-select' => 'Vali',
	'code-reference-remove' => 'Eemalda valitud seostused',
	'code-reference-associate' => 'Seostatav järelredaktsioon:',
	'code-reference-associate-submit' => 'Seosta',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Kuupäev:',
	'code-rev-message' => 'Kommentaar:',
	'code-rev-repo' => 'Hoidla:',
	'code-rev-rev' => 'Redaktsioon:',
	'code-rev-rev-viewvc' => 'ViewVC-s',
	'code-rev-paths' => 'Muudetud rajad:',
	'code-rev-modified-a' => 'lisatud',
	'code-rev-modified-r' => 'asendatud',
	'code-rev-modified-d' => 'kustutatud',
	'code-rev-modified-m' => 'muudetud',
	'code-rev-imagediff' => 'Pildi muudatused',
	'code-rev-status' => 'Olek:',
	'code-rev-status-set' => 'Muuda olekut',
	'code-rev-tags' => 'Märgised:',
	'code-rev-comment-by' => 'Kasutaja $1 kommentaar.',
	'code-rev-comment-preview' => 'Eelvaade',
	'code-rev-inline-preview' => 'Eelvaade:',
	'code-rev-diff' => 'Erinevused',
	'code-rev-diff-link' => 'erinevused',
	'code-rev-diff-too-large' => 'Erinevus on kuvamiseks liiga suur.',
	'code-rev-purge-link' => 'tühjenda',
	'code-rev-total' => 'Tulemuste koguarv: $1',
	'code-rev-not-found' => "Redaktsiooni '''$1''' pole olemas!",
	'code-rev-history-link' => 'ajalugu',
	'code-status-new' => 'uus',
	'code-status-desc-new' => 'Redaktsioon ootab toimingut (vaikeolek).',
	'code-status-fixme' => 'vajab parandamist',
	'code-status-desc-fixme' => 'Redaktsiooniga kaasnes viga. See tuleks parandada või tühistada.',
	'code-status-reverted' => 'tagasi võetud',
	'code-status-desc-reverted' => 'Redaktsioon tühistati hilisema redaktsiooniga.',
	'code-status-resolved' => 'lahendatud',
	'code-status-desc-resolved' => 'Redaktsioonil oli viga, mis parandati hilisema redaktsiooniga.',
	'code-status-ok' => 'korras',
	'code-status-desc-ok' => 'Redaktsioon on täielikult üle vaadatud ja ülevaataja on kindel, et sellega on kõik igati korras.',
	'code-status-deferred' => 'edasi lükatud',
	'code-status-desc-deferred' => 'Redaktsiooni pole tarvis üle vaadata.',
	'code-status-old' => 'vana',
	'code-status-desc-old' => 'Vana redaktsioon, milles võib vigu olla, aga mida pole mõtet üle vaadata.',
	'code-signoff-field-user' => 'Kasutaja',
	'code-signoff-field-date' => 'Kuupäev',
	'code-pathsearch-legend' => 'Raja järgi hoidlast redaktsioonide otsimine',
	'code-pathsearch-path' => 'Rada:',
	'code-pathsearch-filter' => 'Näita ainult:',
	'code-revfilter-cr_status' => 'Olek = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Märgis = $1',
	'code-revfilter-clear' => 'Eemalda filter',
	'code-rev-submit' => 'Salvesta muudatused',
	'code-rev-submit-next' => 'Salvesta ja liigu järgmise lahendamata redaktsiooni juurde',
	'code-rev-next' => 'Järgmine lahendamata redaktsioon',
	'code-batch-status' => 'Muudatuse olek:',
	'code-batch-tags' => 'Muudatusmärgised:',
	'codereview-batch-title' => 'Kõikide valitud redaktsioonide muutmine',
	'code-releasenotes' => 'redaktsioonimärkmed',
	'code-release-legend' => 'Redaktsioonimärkmete loomine',
	'code-release-startrev' => 'Esimene redaktsioon:',
	'code-release-endrev' => 'Viimane redaktsioon:',
	'codereview-subtitle' => 'Hoidla $1 jaoks',
	'codereview-reply-link' => 'vasta',
	'codereview-overview-title' => 'Ülevaade',
	'codereview-overview-desc' => 'Näita selle loendi graafilist ülevaadet',
	'codereview-email-subj' => '[$1 $2]: Lisatud uus kommentaar',
	'codereview-email-body' => 'Kasutaja $1 kommenteeris koodi $3.

Täielik URL: $2
Kehtestamise kokkuvõte:

$5

Kommentaar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Järelmuudatused',
	'codereview-email-body2' => 'Kasutaja $1 tegi koodile $2 järelmuudatusi.

Täielik URL järelmuudatuste juurde: $5
Kehtestamise kokkuvõte:

$6

Täielik URL: $3
Kehtestamise kokkuvõte:

$4',
	'codereview-email-subj3' => '[$1 $2]: Redaktsiooni olek muudetud',
	'codereview-email-body3' => 'Kasutaja $1 muutis redaktsiooni $2 olekut.

Vana olek: $3
Uus olek: $4

Täielik URL: $5
Kehtestamise kokkuvõte:

$6',
	'codereview-email-subj4' => '[$1 $2]: Lisatud uus kommentaar ja redaktsiooni olek muudetud',
	'codereview-email-body4' => 'Kasutaja $1 muutis redaktsiooni $2 olekut.

Vana olek: $3
Uus olek: $4

Kasutaja $1 postitas redaktsiooni $2 kohta ka kommentaari.

Täielik URL: $5
Kehtestamise kokkuvõte:

$7

Kommentaar:

$6',
	'code-stats' => 'statistika',
	'code-stats-header' => 'Hoidla $1 arvandmed',
	'code-stats-main' => 'Seisuga $1 on hoidlas {{PLURAL:$2|üks redaktsioon|$2 redaktsiooni}} [[Special:Code/$3/author|{{PLURAL:$4|ühelt|$4}} autorilt]].',
	'code-stats-status-breakdown' => 'Redaktsioonide arv olekuti',
	'code-stats-fixme-breakdown' => 'Parandamist vajavate redaktsioonide arv autoriti',
	'code-stats-new-breakdown' => 'Uute redaktsioonide arv autoriti',
	'code-stats-count' => 'Redaktsioonide arv',
	'repoadmin' => 'Hoidla haldamine',
	'repoadmin-new-legend' => 'Loo uus hoidla',
	'repoadmin-new-label' => 'Hoidla nimi:',
	'repoadmin-new-button' => 'Loo',
	'repoadmin-edit-legend' => 'Hoidla "$1" muudatused',
	'repoadmin-edit-path' => 'Hoidla rada:',
	'repoadmin-edit-bug' => 'Bugzilla-rada:',
	'repoadmin-edit-view' => 'ViewVC-rada:',
	'repoadmin-edit-button' => 'Sobib',
	'repoadmin-edit-sucess' => 'Hoidla "[[Special:Code/$1|$1]]" on edukalt muudetud.',
	'repoadmin-nav' => 'hoidla haldamine',
	'right-repoadmin' => 'Hallata koodihoidlaid',
	'right-codereview-use' => 'Kasutada erilehekülge Special:Code',
	'right-codereview-add-tag' => 'Lisada redaktsioonidele uusi märgiseid',
	'right-codereview-remove-tag' => 'Eemaldada redaktsioonidelt märgiseid',
	'right-codereview-post-comment' => 'Lisada redaktsioonidele kommentaare',
	'right-codereview-set-status' => 'Muuta redaktsioonide olekut',
	'right-codereview-link-user' => 'Siduda autoreid vikikasutajatega',
	'right-codereview-associate' => 'Hallata redaktsioonide seostusi',
	'right-codereview-review-own' => 'Märkida enda redaktsioonid korrasolevaks või lahendatuks',
	'specialpages-group-developer' => 'Arendusriistad',
	'group-svnadmins' => 'SVN-administraatorid',
	'group-svnadmins-member' => 'SVN-administraator',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-administraatorid',
);

/** Basque (Euskara)
 * @author An13sa
 * @author Kobazulo
 * @author Theklan
 */
$messages['eu'] = array(
	'code' => 'Kode Berrikuspena',
	'code-comments' => 'Iruzkinak',
	'code-change-status' => "$1-(e)n '''egoera''' aldatu da",
	'code-change-tags' => "$1-eko '''etiketak''' aldatu dira",
	'code-change-removed' => 'ezabatua:',
	'code-change-added' => 'gehitua:',
	'code-old-status' => 'Egoera zaharra',
	'code-new-status' => 'Egoera berria',
	'code-prop-changes' => 'Egoera eta etiketatzeko loga',
	'code-notes' => 'iruzkin berriak',
	'code-authors' => 'egileak',
	'code-tags' => 'etiketak',
	'code-author-name' => 'Idatzi erabiltzaile izen bat:',
	'code-author-link' => 'lotu?',
	'code-author-unlink' => 'lotura kendu?',
	'code-field-id' => 'Berrikuspena',
	'code-field-author' => 'Egilea',
	'code-field-user' => 'Iruzkina egin duena',
	'code-field-message' => 'Laburpena egin',
	'code-field-status' => 'Egoera',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Iruzkinak',
	'code-field-path' => 'Bidea',
	'code-field-text' => 'Oharra',
	'code-field-select' => 'Aukeratu',
	'code-rev-author' => 'Egilea:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Iruzkina:',
	'code-rev-repo' => 'Biltegia:',
	'code-rev-rev' => 'Berrikuspena:',
	'code-rev-rev-viewvc' => 'ViewVCn',
	'code-rev-paths' => 'Aldatutako ibilbideak:',
	'code-rev-modified-a' => 'gehituta',
	'code-rev-modified-r' => 'ordezkatuta',
	'code-rev-modified-d' => 'ezabatua',
	'code-rev-modified-m' => 'aldatuta',
	'code-rev-status' => 'Egoera:',
	'code-rev-status-set' => 'Egoera aldatu',
	'code-rev-tags' => 'Etiketak:',
	'code-rev-tag-add' => 'Etiketak gehitu:',
	'code-rev-tag-remove' => 'Etiketak kendu:',
	'code-rev-comment-by' => '$1(e)k komentatuta',
	'code-rev-comment-preview' => 'Aurreikuspena',
	'code-rev-inline-preview' => 'Aurrikuspena:',
	'code-rev-diff' => 'Ezb',
	'code-rev-diff-link' => 'ezb',
	'code-rev-purge-link' => 'berritu',
	'code-status-new' => 'berria',
	'code-status-fixme' => 'konpon nazazu',
	'code-status-reverted' => 'berrezarria',
	'code-status-resolved' => 'konponduta',
	'code-status-ok' => 'ondo',
	'code-status-deferred' => 'geroratua',
	'code-pathsearch-legend' => 'Bilatu aldaketak biltegi honetan bidearen arabera',
	'code-pathsearch-path' => 'Bidea:',
	'code-revfilter-cr_status' => 'Egoera = $1',
	'code-revfilter-cr_author' => 'Egilea = $1',
	'code-rev-submit' => 'Aldaketak gorde',
	'code-rev-submit-next' => 'Gorde eta konpondu gabeko hurrengora',
	'codereview-batch-submit' => 'Bidali',
	'codereview-reply-link' => 'erantzun',
	'codereview-email-subj' => '[$1 $2]: Iruzkin berria gehitu da',
	'codereview-email-body' => '"$1" lankideak $3(e)n iruzkin bat gehitu du.

Helbide osoa: $2

Iruzkina:

$4',
	'repoadmin' => 'Biltegiaren Administrazioa',
	'repoadmin-new-legend' => 'Biltegi berri bat sortu',
	'repoadmin-new-label' => 'Biltegiaren izena:',
	'repoadmin-new-button' => 'Sortu',
	'repoadmin-edit-legend' => '"$1" biltegiaren aldaketa',
	'repoadmin-edit-path' => 'Biltegiaren bidea:',
	'repoadmin-edit-bug' => 'Bugzilla bidea:',
	'repoadmin-edit-view' => 'ViewVC bidea:',
	'repoadmin-edit-button' => 'Ados',
	'repoadmin-edit-sucess' => '"[[Special:Code/$1|$1]]" biltegia arrakastaz aldtu da.',
	'right-repoadmin' => 'Kudeatu kode biltegiak',
	'right-codereview-add-tag' => 'Gehitu etiketa berriak aldaketei',
	'right-codereview-remove-tag' => 'Kendu etiketak berrikuspenetatik',
	'right-codereview-post-comment' => 'Gehitu iruzkinak berrikuspenei',
	'right-codereview-set-status' => 'Aldatu berrikuspenen egoera',
	'right-codereview-link-user' => 'Lotu egileak wiki lankideei',
	'specialpages-group-developer' => 'Garatzaileen tresnak',
);

/** Persian (فارسی)
 * @author Bersam
 * @author Ebraminio
 * @author Huji
 * @author Komeil 4life
 * @author Ladsgroup
 * @author Mardetanha
 * @author Mjbmr
 * @author Sahim
 * @author Wayiran
 * @author ZxxZxxZ
 */
$messages['fa'] = array(
	'code' => 'مرور کد',
	'code-rev-title' => 'بازبینی کد - $1',
	'code-comments' => 'توضیحات',
	'code-references' => 'رسیدگی به پیگیری',
	'code-change-status' => "'''وضعیت''' $1 را تغییر داد",
	'code-change-tags' => "'''برچسب''' را برای $1 تغییر داد",
	'code-change-removed' => 'حذف:',
	'code-change-added' => 'اضافه:',
	'code-old-status' => 'وضعیت قدیمی',
	'code-new-status' => 'وضعیت جدید',
	'code-prop-changes' => 'سیاههٔ وضعیت و برچسب‌دهی',
	'codereview-desc' => '[[Special:Code|ابزار بازبینی کد]] با [[Special:RepoAdmin|پشتیبانی از Subversion]]',
	'code-no-repo' => 'هیچ مخزنی تنظیم نشده‌است!',
	'code-create-repo' => 'برای ایجاد یک مخزن به [[Special:RepoAdmin|مدیر مخزن]] بروید',
	'code-need-repoadmin-rights' => 'برای قادر بودن به ایجاد یک مخزن، دسترسی مدیر مخرن نیاز است',
	'code-need-group-with-rights' => 'هیچ گروهی با دسترسی repoadmin وجود ندارد. لطفاً برای قادر بودن به اضافه کردن مخزنی جدید، یکی اضافه کنید.',
	'code-repo-not-found' => "منبع ذخیره داده‌های '''$1''' وجود ندارد!",
	'code-load-diff' => 'در حال بارگیری تفاوت...',
	'code-notes' => 'توضیحات تازه',
	'code-statuschanges' => 'تغییرات وضعیت',
	'code-mycommits' => 'تعهدات من',
	'code-mycomments' => 'نظرهای من',
	'code-authors' => 'مولفان',
	'code-status' => 'وضعیت‌ها',
	'code-tags' => 'برچسب‌ها',
	'code-tags-no-tags' => 'هیچ برچسبی در مخزن وجود ندارد.',
	'code-authors-text' => 'در زیر فهرستی از مولفان منابع به ترتیب نام وجود دارد. حساب‌های ویکی محلی در داخل پرانتزها قرار دارند. داده‌ها ممکن است در میانگیر قرار داشته باشند.',
	'code-author-haslink' => 'این مولف با کاربر $1 در ویکی پیوند دارد',
	'code-author-orphan' => 'کاربر/مؤلف اس‌وی‌ان $1 هیچ پیوندی به یک حساب کاربری ویکی ندارد',
	'code-author-dolink' => 'پیوند کردن این مولف به یک کاربر ویکی:',
	'code-author-alterlink' => 'تغییر کاربر ویکی پیوند شده به این مولف:',
	'code-author-orunlink' => 'برداشتن پیوند به این کاربر ویکی:',
	'code-author-name' => 'یک نام کاربری وارد کنید:',
	'code-author-success' => 'مولف $1 به کاربر ویکی $2 پیوند یافت',
	'code-author-link' => 'پیوند؟',
	'code-author-unlink' => 'برداشتن پیوند؟',
	'code-author-unlinksuccess' => 'پیوند مولف $1 برداشته شد',
	'code-author-badtoken' => 'خطای نشت در زمان تلاش برای انجام عملیات.',
	'code-author-total' => 'تعداد کل نویسندگان: $1',
	'code-author-lastcommit' => 'تاریخ آخرین سپردن',
	'code-browsing-path' => "تجدید نظر برای بررسی در  '''$1'''",
	'code-field-id' => 'نسخه',
	'code-field-author' => 'مؤلف',
	'code-field-user' => 'نظر دهنده',
	'code-field-message' => 'خلاصهٔ سپردن',
	'code-field-status' => 'وضعیت',
	'code-field-status-description' => 'شرح وضعیت',
	'code-field-timestamp' => 'تاریخ',
	'code-field-comments' => 'توضیحات',
	'code-field-path' => 'مسیر',
	'code-field-text' => 'نکته',
	'code-field-select' => 'انتخاب',
	'code-reference-remove' => 'حذف انجمن‌های انتخاب شده',
	'code-reference-associate-submit' => 'یکپارچه کردن',
	'code-rev-author' => 'مولف:',
	'code-rev-date' => 'تاریخ:',
	'code-rev-message' => 'توضیح:',
	'code-rev-repo' => 'مخزن:',
	'code-rev-rev' => 'نسخه:',
	'code-rev-rev-viewvc' => 'روی ViewVC',
	'code-rev-paths' => 'مسیرهای تغییر یافته:',
	'code-rev-modified-a' => 'اضافه شد',
	'code-rev-modified-r' => 'جایگزین شد',
	'code-rev-modified-d' => 'حذف شد',
	'code-rev-modified-m' => 'تغییر یافت',
	'code-rev-imagediff' => 'تغییرات تصویر',
	'code-rev-status' => 'وضعیت:',
	'code-rev-status-set' => 'تغییر وضعیت',
	'code-rev-tags' => 'برچسب‌ها:',
	'code-rev-tag-add' => 'افزودن برچسب‌ها:',
	'code-rev-tag-remove' => 'برداشته برچسب‌ها:',
	'code-rev-comment-by' => 'توضیحات $1',
	'code-rev-comment-preview' => 'پیش‌نمایش',
	'code-rev-inline-preview' => 'پیش‌نمایش:',
	'code-rev-diff' => 'تفاوت',
	'code-rev-diff-link' => 'تفاوت',
	'code-rev-diff-too-large' => 'تفاوت برای نمایش‌دادن خیلی بزرگ است.',
	'code-rev-purge-link' => 'خالی کردن',
	'code-rev-total' => 'تعداد کل نتایج: $1',
	'code-rev-not-found' => "هیچ‌گونه تجدیدنظری برای '''$1''' وجود ندارد.",
	'code-rev-history-link' => 'تاریخچه',
	'code-status-new' => 'تازه',
	'code-status-desc-new' => 'نسخه در حال انتظار (وضعیت پیش‌فرض).',
	'code-status-fixme' => 'درستم کن',
	'code-status-desc-fixme' => 'نسخه، مشکلی را معرفی می‌کند یا خراب است. باید تعمیر یا واگردانی شود.',
	'code-status-reverted' => 'واگردانی شده',
	'code-status-desc-reverted' => 'نسخه توسط نسخهٔ آخر، ناتمام ماند.',
	'code-status-resolved' => 'حل شده',
	'code-status-desc-resolved' => 'نسخه مسئله‌ای داشت که توسط نسخهٔ آخر خطاب شد.',
	'code-status-ok' => 'مورد تأیید',
	'code-status-desc-ok' => 'نسخه کاملاً بازبینی شده و فرد بازبین از همه نظر مطمئن است که این خوب است.',
	'code-status-deferred' => 'معوق',
	'code-status-desc-deferred' => 'نسخه نیاز به بازبینی ندارد.',
	'code-status-old' => 'قدیمی',
	'code-status-desc-old' => 'نسخه‌های قدیمی با مشکلات بالقوه که ارزش تلاش برای بررسی آن‌ها را ندارد.',
	'code-signoffs' => 'ثبات‌ها',
	'code-signoff-legend' => 'افزودن ثبات',
	'code-signoff-submit' => 'تثبیت کردن',
	'code-signoff-strike' => 'حذف اثبات‌های انتخاب شده',
	'code-signoff-signoff' => 'تثبیت کردن این نسخه به عنوان:',
	'code-signoff-flag-inspected' => 'بازرسی‌شده',
	'code-signoff-flag-tested' => 'آزمایش شد',
	'code-signoff-field-user' => 'کاربر',
	'code-signoff-field-flag' => 'پرچم',
	'code-signoff-field-date' => 'تاریخ',
	'code-signoff-struckdate' => '$1 (رخ داد $2)',
	'code-pathsearch-legend' => 'جستجوی نسخه‌ها در این مخزن بر اساس مسیر',
	'code-pathsearch-path' => 'مسیر:',
	'code-pathsearch-filter' => 'فقط نمایش:',
	'code-revfilter-cr_status' => 'وضعیت = $1',
	'code-revfilter-cr_author' => 'نویسنده = $1',
	'code-revfilter-ct_tag' => 'برچسب = $1',
	'code-revfilter-clear' => 'صافی پاک کننده',
	'code-rev-submit' => 'ذخیره‌کردن تغییرات',
	'code-rev-submit-next' => 'ذخیره و حرکت به مورد حل نشدهٔ بعدی',
	'code-rev-next' => 'حل نشدهٔ بعدی',
	'code-batch-status' => 'تغییر وضعیت:',
	'code-batch-tags' => 'تغییر برچسب‌ها:',
	'codereview-batch-title' => 'تغییر تمام بازبینی‌های انتخاب شده',
	'codereview-batch-submit' => 'ارسال',
	'code-releasenotes' => 'نکات انتشار',
	'code-release-legend' => 'ایجاد نکات انتشار',
	'code-release-startrev' => 'شروع بازبینی:',
	'code-release-endrev' => 'آخرین بازبینی:',
	'codereview-subtitle' => 'برای $1',
	'codereview-reply-link' => 'پاسخ',
	'codereview-overview-title' => 'چشم‌انداز',
	'codereview-overview-desc' => 'نمایش یک نمای‌کلی گرافیکی از این فهرست',
	'codereview-email-subj' => '[$1 $2]: نظر جدید اضافه شد',
	'codereview-email-body' => 'کاربر «$1» یک نظر برای $3 ارسال کرد.

نشانی کامل: $2
خلاصهٔ ارتکاب‌شدن‌ها:

$5

نظر:

$4',
	'codereview-email-subj2' => 'پیگیری تغییرات: [$1 $2]',
	'codereview-email-body2' => 'کاربر «$1» این تغییرات را به $2 داده‌است.

نشانی کامل برای این نسخه‌ها: $5

خلاصهٔ ارتکاب‌شدن‌ها:

$6


نشانی کامل: $3

خلاصهٔ ارتکاب‌شدن‌ها:

$4',
	'codereview-email-subj3' => '[$1 $2]: وضعیت نسخه تغییر کرد',
	'codereview-email-body3' => 'کاربر "$1" وضعیت $2 را تغییر داد.

وضعیت قدیمی: $3
وضعیت جدید: $4

نشانی کامل: $5

خلاصهٔ ارتکاب‌شدن‌ها:

$6',
	'codereview-email-subj4' => '[$1 $2]: نظر جدید افزوده شد، و وضعیت نسخه تغییر کرد',
	'codereview-email-body4' => 'کاربر "$1" تغییر وضعیت داد از $2.

وضعیت قدیمی: $3
وضعیت جدید: $4

کاربر "$1" همچنین یک نظر فرستاد در $2.

نشانی کامل: $5
خلاصهٔ ارتکاب‌شدن‌ها:

$7

نظر:

$6',
	'code-stats' => 'آمار',
	'code-stats-header' => 'آمار برای مخزن $1',
	'code-stats-main' => 'از تاریخ $1، انبار دارای $2 نسخه توسط [[Special:Code/$3/author|$4 نویسنده]] است.',
	'code-stats-status-breakdown' => 'تعداد بازبینی‌ها در هر وضعیت',
	'code-stats-fixme-breakdown' => 'تفکیک از متعادل‌سازی نسخه‌ها توسط مؤلف',
	'code-stats-new-breakdown' => 'تفکیک نسخه‌های جدید بر اساس هر مؤلف',
	'code-stats-new-breakdown-path' => 'تفکیک بررسی‌های جدید بر اساس مسیر',
	'code-stats-count' => 'تعداد بازبینی‌ها',
	'code-tooltip-withsummary' => 'r$1 [$2] توسط $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] توسط $3',
	'repoadmin' => 'مدیریت مخزن',
	'repoadmin-new-legend' => 'ایجاد یک مخزن جدید',
	'repoadmin-new-label' => 'نام محزن:',
	'repoadmin-new-button' => 'ایجاد',
	'repoadmin-edit-legend' => 'تغییر مخزن «$1»',
	'repoadmin-edit-path' => 'مسیر مخزن:',
	'repoadmin-edit-bug' => 'مسیر باگزیلا:',
	'repoadmin-edit-view' => 'مسیر ViewVC:',
	'repoadmin-edit-button' => 'مورد تأیید',
	'repoadmin-edit-sucess' => 'مخزن «[[Special:Code/$1|$1]]» با موفقیت تغییر داده شد.',
	'repoadmin-nav' => 'مدیریت مخزن',
	'right-repoadmin' => 'مدیریت مخازن کد',
	'right-codereview-use' => 'استفاده از ویژه:کد',
	'right-codereview-add-tag' => 'افزودن برچسب‌های جدید به نسخه‌ها',
	'right-codereview-remove-tag' => 'برداشتن برچسب از نسخه‌ها',
	'right-codereview-post-comment' => 'افزودن توضیحات به نسخه‌ها',
	'right-codereview-set-status' => 'تغییر وضعیت نسخه‌ها',
	'right-codereview-signoff' => 'تثبیت نسخه‌ها',
	'right-codereview-link-user' => 'پیوند کردن نویسندگان به کاربران ویکی',
	'right-codereview-associate' => 'مدیریت انجمن‌های نسخه‌ها',
	'right-codereview-review-own' => 'نسخه‌های خود را به عنوان صحیح یا حل شده علامت گذاری کنید',
	'specialpages-group-developer' => 'ابزارهای توسعه‌دهندگان',
	'group-svnadmins' => 'مدیران اس‌وی‌ان',
	'group-svnadmins-member' => 'مدیر اس‌وی‌ان',
	'grouppage-svnadmins' => '{{ns:project}}:مدیران اس‌وی‌ان',
);

/** Finnish (Suomi)
 * @author Cimon Avaro
 * @author Crt
 * @author Nedergard
 * @author Nike
 * @author Olli
 * @author Str4nd
 * @author Tarmo
 * @author ZeiP
 */
$messages['fi'] = array(
	'code' => 'Koodintarkistus',
	'code-rev-title' => '$1 – Koodintarkistus',
	'code-comments' => 'Kommentit',
	'code-references' => 'Myöhemmät versiot',
	'code-change-status' => "muutti version $1 '''tilaa'''",
	'code-change-tags' => "muutti version $1 '''merkintöjä'''",
	'code-change-removed' => 'poistettu:',
	'code-change-added' => 'lisätty:',
	'code-old-status' => 'Vanha tila',
	'code-new-status' => 'Uusi tila',
	'code-prop-changes' => 'Tila- ja merkintäloki',
	'codereview-desc' => '[[Special:Code|Koodintarkistustyökalu]], jossa [[Special:RepoAdmin|Subversion-tuki]].',
	'code-no-repo' => 'Varastoa ei ole määritetty.',
	'code-create-repo' => 'Siirry sivulle [[Special:RepoAdmin|RepoAdmin]] tehdäksesi säilytyspaikan',
	'code-need-repoadmin-rights' => 'Tarvitset repoadmin-oikeudet tehdäksesi säilytyspaikan',
	'code-need-group-with-rights' => 'Ryhmää, jolla olisi repoadmin-oikeudet, ei löydy. Lisää yksi ryhmä, jotta voisit lisätä uuden säilytyspaikan',
	'code-repo-not-found' => "Koodivarastoa '''$1''' ei ole olemassa.",
	'code-load-diff' => 'Ladataan eroavaisuuksia…',
	'code-notes' => 'tuoreet kommentit',
	'code-statuschanges' => 'tilan muutokset',
	'code-mycommits' => 'omat muokkaukset',
	'code-mycomments' => 'omat kommentit',
	'code-authors' => 'tekijät',
	'code-status' => 'tilat',
	'code-tags' => 'merkinnät',
	'code-tags-no-tags' => 'Tällä säilytyspaikalla ei ole avainsanoja.',
	'code-authors-text' => 'Alla on lista versionhallinnassa olevista tekijöistä käyttäjätunnuksen mukaan. Paikalliset wikitilit näytetään suluissa. Tiedot saattavat tulla välimuistista.',
	'code-author-haslink' => 'Tämä tekijä on kytketty wikikäyttäjään $1',
	'code-author-orphan' => 'SVN-tunnusta $1 ei ole liitetty wikitunnukseen',
	'code-author-dolink' => 'Kytke tämä tekijä wiki-käyttäjään:',
	'code-author-alterlink' => 'Vaihda tähän tekijään kytketty wiki-käyttäjä:',
	'code-author-orunlink' => 'Tai irrota tämä wiki-käyttäjä:',
	'code-author-name' => 'Käyttäjätunnus:',
	'code-author-success' => 'Tekijä $1 on kytketty wiki-käyttäjään $2',
	'code-author-link' => 'kytke?',
	'code-author-unlink' => 'irrota?',
	'code-author-unlinksuccess' => 'Tekijä $1 on irrotettu',
	'code-author-badtoken' => 'Toiminnon suorittaminen epäonnistui istuntovirheen takia.',
	'code-author-total' => 'Tekijöiden kokonaismäärä: $1',
	'code-author-lastcommit' => 'Viimeisimmän muutoksen päiväys',
	'code-browsing-path' => "Selataan versioita '''$1'''",
	'code-field-id' => 'Versio',
	'code-field-author' => 'Tekijä',
	'code-field-user' => 'Kommentoija',
	'code-field-message' => 'Yhteenveto',
	'code-field-status' => 'Tila',
	'code-field-status-description' => 'Tilan kuvaus',
	'code-field-timestamp' => 'Päiväys',
	'code-field-comments' => 'Kommentit',
	'code-field-path' => 'Polku',
	'code-field-text' => 'Huomio',
	'code-field-select' => 'Valitse',
	'code-reference-remove' => 'Poista valitut liitokset',
	'code-reference-associate' => 'Liitä myöhemmät versiot:',
	'code-reference-associate-submit' => 'Liitä',
	'code-rev-author' => 'Tekijä:',
	'code-rev-date' => 'Päiväys:',
	'code-rev-message' => 'Kommentti:',
	'code-rev-repo' => 'Varasto:',
	'code-rev-rev' => 'Versio:',
	'code-rev-rev-viewvc' => 'ViewVC:ssä',
	'code-rev-paths' => 'Muutetut polut:',
	'code-rev-modified-a' => 'lisätty',
	'code-rev-modified-r' => 'korvattu',
	'code-rev-modified-d' => 'poistettu',
	'code-rev-modified-m' => 'muutettu',
	'code-rev-imagediff' => 'Kuvamuutokset',
	'code-rev-status' => 'Tila:',
	'code-rev-status-set' => 'Vaihda tilaa',
	'code-rev-tags' => 'Merkinnät:',
	'code-rev-tag-add' => 'Lisää merkintöjä:',
	'code-rev-tag-remove' => 'Poista merkintöjä:',
	'code-rev-comment-by' => 'Käyttäjän $1 kommentti',
	'code-rev-comment-preview' => 'Esikatselu',
	'code-rev-inline-preview' => 'Esikatselu:',
	'code-rev-diff' => 'Erot',
	'code-rev-diff-link' => 'erot',
	'code-rev-diff-too-large' => 'Eroavuus on liian iso näytettäväksi.',
	'code-rev-purge-link' => 'tyhjennä välimuistit',
	'code-rev-total' => 'Tuloksien kokonaismäärä: $1',
	'code-rev-not-found' => "Muokkausta '''$1''' ei löydy!",
	'code-rev-history-link' => 'historia',
	'code-status-new' => 'uusi',
	'code-status-desc-new' => 'Muutos odottaa toimintaa (oletustila).',
	'code-status-fixme' => 'korjattava',
	'code-status-desc-fixme' => 'Muutoksessa tuli ilmi ohjelmavirhe tai se on rikkinäinen. Se tulisi kumota tai korjata.',
	'code-status-reverted' => 'palautettu',
	'code-status-desc-reverted' => 'Versio poistettiin uudemmassa versiossa.',
	'code-status-resolved' => 'ratkaistu',
	'code-status-desc-resolved' => 'Versiossa oli ongelma, joka osoitettiin myöhemmässä versiossa.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Versio tarkistettiin kokonaan ja tarkistaja on varma, että se on hyvä.',
	'code-status-deferred' => 'odottaa',
	'code-status-desc-deferred' => 'Versio ei edellytä tarkistusta.',
	'code-status-old' => 'vanha',
	'code-status-desc-old' => 'Vanhat versiot, joissa todennäköisesti on ohjelmavirheitä, eivät ole tarkistamisen arvoisia.',
	'code-signoffs' => 'Uloskirjaukset',
	'code-signoff-legend' => 'Lisää uloskirjaus',
	'code-signoff-submit' => 'Uloskirjaus',
	'code-signoff-strike' => 'Poista valitut uloskirjautumiset',
	'code-signoff-signoff' => 'Uloskirjaa tämä versio:',
	'code-signoff-flag-inspected' => 'Tutkittu',
	'code-signoff-flag-tested' => 'Testattu',
	'code-signoff-field-user' => 'Käyttäjä',
	'code-signoff-field-flag' => 'Merkintä',
	'code-signoff-field-date' => 'Päiväys',
	'code-signoff-struckdate' => '$1 (poistettiin $2)',
	'code-pathsearch-legend' => 'Etsi tämän varaston versioita polun perusteella',
	'code-pathsearch-path' => 'Polku',
	'code-pathsearch-filter' => 'Näytä vain:',
	'code-revfilter-cr_status' => 'Tila = $1',
	'code-revfilter-cr_author' => 'Tekijä on $1',
	'code-revfilter-ct_tag' => 'Avainsana = $1',
	'code-revfilter-clear' => 'Tyhjennä suodatin',
	'code-rev-submit' => 'Tallenna muutokset',
	'code-rev-submit-next' => 'Tallenna ja seuraava avoin',
	'code-rev-next' => 'Seuraava ratkaisematon',
	'code-batch-status' => 'Muuta tilaa',
	'code-batch-tags' => 'Muuta merkintöjä',
	'codereview-batch-title' => 'Muuta kaikkia valittuja versioita',
	'codereview-batch-submit' => 'Lähetä',
	'code-releasenotes' => 'julkaisutiedot',
	'code-release-legend' => 'Luo julkaisuhuomautukset',
	'code-release-startrev' => 'Ensimmäinen versio',
	'code-release-endrev' => 'Viimeinen versio',
	'codereview-subtitle' => 'Varastolle $1',
	'codereview-reply-link' => 'vastaa',
	'codereview-overview-title' => 'Yhteenveto',
	'codereview-overview-desc' => 'Näytä graafinen yhteenveto tästä luettelosta',
	'codereview-email-subj' => '[$1 $2]: Uusi kommentti lisätty',
	'codereview-email-body' => '"$1" jättin kommentin kohteesta $3.
URL: $2

Yhteenveto kohteen $3 kommentista:

$5

Käyttäjän $1 kommentti:

$4',
	'codereview-email-subj2' => '[$1 $2]: Myöhemmät muutokset',
	'codereview-email-body2' => 'Käyttäjä $1 teki jatkomuutoksia koodimuutokseen $2.
Osoite: $5

Yhteenveto muutoksista $2 oli:

$6

Jatkomuutosten osoite: $3
Jatkomuutoksen yhteenveto käyttäjältä $1:

$4',
	'codereview-email-subj3' => '[$1 $2]: Koodimuutoksen tila muuttunut',
	'codereview-email-body3' => '$1 muutti koodimuutoksen $2 tilaksi: $4
Osoite: $5

Vanha tila: $3
Uusi tila: $4

Version $2 yhteenveto oli:

$6',
	'codereview-email-subj4' => '[$1 $2]: Uusi kommentti ja koodimuutoksen tila muuttunut',
	'codereview-email-body4' => '"$1" muutti version $2 tilaksi "$4" ja kommentoi sitä.
URL: $5

Vanha tila: $3
Uusi tila: $4

Kommentin yhteenveto versiolle $2:

$7

Käyttäjän $1 kommentti:

$6',
	'code-stats' => 'tilastot',
	'code-stats-header' => 'Versionhallinnan $1 tilastot',
	'code-stats-main' => '$1 versionhallinnassa oli {{PLURAL:$2|yksi muokkaus|$2 muokkausta}} [[Special:Code/$3/author|$4 {{PLURAL:$4|käyttäjältä|eri käyttäjältä}}]].',
	'code-stats-status-breakdown' => 'Muokkauksien määrä tilan mukaan',
	'code-stats-fixme-breakdown' => 'FIXME-koodimuutosten määrä tekijöittäin',
	'code-stats-fixme-breakdown-path' => 'FIXME-koodimuutosten määrä poluittain',
	'code-stats-fixme-path' => 'FIXME-muutokset polulla: $1',
	'code-stats-new-breakdown' => 'Uudet koodimuutokset käyttäjittäin',
	'code-stats-new-breakdown-path' => 'Uudet koodimuutokset poluittain',
	'code-stats-new-path' => 'Uudet versiot polulla: $1',
	'code-stats-count' => 'Muokkausten määrä',
	'code-tooltip-withsummary' => 'v$1 [$2] käyttäjältä $3 - $4',
	'code-tooltip-withoutsummary' => 'v$1 [$2] käyttäjältä $3',
	'repoadmin' => 'Varaston hallinta',
	'repoadmin-new-legend' => 'Luo uusi varasto',
	'repoadmin-new-label' => 'Varaston nimi:',
	'repoadmin-new-button' => 'Luo',
	'repoadmin-edit-legend' => 'Varaston ”$1” muokkaus',
	'repoadmin-edit-path' => 'Varaston polku:',
	'repoadmin-edit-bug' => 'Bugzilla-polku:',
	'repoadmin-edit-view' => 'ViewVC-polku:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Muutokset varastoon [[Special:Code/$1|$1]] on tehty.',
	'repoadmin-nav' => 'versionhallinnan ylläpito',
	'right-repoadmin' => 'Hallita koodivarastoja',
	'right-codereview-use' => 'Käyttää toimintosivua Special:Code',
	'right-codereview-add-tag' => 'Lisätä uusia merkintöjä versioihin',
	'right-codereview-remove-tag' => 'Poistaa merkintöjä versioista',
	'right-codereview-post-comment' => 'Lisätä kommentteja versioihin',
	'right-codereview-set-status' => 'Muuttaa versioiden tilaa',
	'right-codereview-signoff' => 'Merkitä lukeneensa tai testanneensa koodimuutoksen',
	'right-codereview-link-user' => 'Liittää tekijöitä wiki-käyttäjiin',
	'right-codereview-associate' => 'Hallita koodimuutosten risiviittauksia',
	'right-codereview-review-own' => 'Merkitä omat koodimuutokset hyväksytyiksi tai korjatuiksi',
	'specialpages-group-developer' => 'Kehittäjien työkalut',
	'group-svnadmins' => 'SVN-ylläpitäjät',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-ylläpitäjä}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-ylläpitäjät',
);

/** French (Français)
 * @author Aadri
 * @author Cedric31
 * @author Crochet.david
 * @author Dereckson
 * @author Gomoko
 * @author Grondin
 * @author Hashar
 * @author IAlex
 * @author Jean-Frédéric
 * @author Od1n
 * @author Peter17
 * @author PieRRoMaN
 * @author Seb35
 * @author Sherbrooke
 * @author Verdy p
 * @author Zetud
 */
$messages['fr'] = array(
	'code' => 'Révision du code',
	'code-rev-title' => '$1 - Révision du code',
	'code-comments' => 'Commentaires',
	'code-references' => 'Références vers les révisions',
	'code-referenced' => 'Révisions suivies',
	'code-change-status' => "a modifié l’'''état''' de $1",
	'code-change-tags' => "a modifié les '''balises''' de $1",
	'code-change-removed' => 'retiré :',
	'code-change-added' => 'ajouté :',
	'code-old-status' => 'ancien statut',
	'code-new-status' => 'nouveau statut',
	'code-prop-changes' => 'Journal des états et du balisage',
	'codereview-desc' => '[[Special:Code|Outils de révision du code]] avec le [[Special:RepoAdmin|support de Subversion]]',
	'code-no-repo' => 'Pas de dépôt configuré !',
	'code-create-repo' => 'Allez à [[Special:RepoAdmin|support de Subversion]] pour créer un dépôt',
	'code-need-repoadmin-rights' => "Des privilèges de niveau ''repoadmin'' sont requis pour créer un dépôt",
	'code-need-group-with-rights' => "Aucun groupe de niveau ''repoadmin'' n’existe. Veuillez en ajouter un pour être en mesure de créer un nouveau dépôt.",
	'code-repo-not-found' => "Le dépôt '''$1''' n’existe pas !",
	'code-load-diff' => 'Chargement du diff en cours...',
	'code-notes' => 'commentaires récents',
	'code-statuschanges' => 'modifications de statut',
	'code-mycommits' => 'mes publications',
	'code-mycomments' => 'mes commentaires',
	'code-authors' => 'auteurs',
	'code-status' => 'états',
	'code-tags' => 'balises',
	'code-tags-no-tags' => 'Aucun tag n’existe dans ce dépôt.',
	'code-authors-text' => 'La liste ci-dessous présente les auteurs de dépôts triés par nom. Les comptes du wiki local sont affichés entre parenthèses. Les données peuvent provenir d’une mémoire tampon.',
	'code-author-haslink' => 'Cet auteur est lié au compte $1 de ce wiki',
	'code-author-orphan' => 'L’utilisateur SVN/auteur $1 n’est pas lié à un compte wiki',
	'code-author-dolink' => 'Associer cet auteur à un utilisateur wiki local :',
	'code-author-alterlink' => 'Changer l’utilisateur wiki lié à cet auteur :',
	'code-author-orunlink' => 'Ou délier cet utilisateur wiki :',
	'code-author-name' => 'Entrez un nom d’utilisateur :',
	'code-author-success' => 'L’auteur $1 a été lié à l’utilisateur wiki $2',
	'code-author-link' => 'lier ?',
	'code-author-unlink' => 'délier ?',
	'code-author-unlinksuccess' => 'L’auteur $1 a été délié',
	'code-author-badtoken' => 'Erreur de session lors de l’exécution de cette action.',
	'code-author-total' => 'Nombre total d’auteurs : $1',
	'code-author-lastcommit' => 'Dernière date d’envoi',
	'code-browsing-path' => "Parcours des révisions dans '''$1'''",
	'code-field-id' => 'Révision',
	'code-field-author' => 'Auteur',
	'code-field-user' => 'Commentateur',
	'code-field-message' => 'Résumé de publication',
	'code-field-status' => 'État',
	'code-field-status-description' => 'Description de l’état',
	'code-field-timestamp' => 'Date',
	'code-field-comments' => 'Commentaires',
	'code-field-path' => 'Chemin',
	'code-field-text' => 'Note',
	'code-field-select' => 'Sélectionner',
	'code-reference-remove' => 'Supprimer les associations sélectionnées',
	'code-reference-associate' => 'Associer la révision suivante :',
	'code-reference-associate-submit' => 'Associer',
	'code-rev-author' => 'Auteur :',
	'code-rev-date' => 'Date :',
	'code-rev-message' => 'Commentaire :',
	'code-rev-repo' => 'Dépôt :',
	'code-rev-rev' => 'Révision :',
	'code-rev-rev-viewvc' => 'sur ViewVC',
	'code-rev-paths' => 'Chemins modifiés :',
	'code-rev-modified-a' => 'ajouté',
	'code-rev-modified-r' => 'remplacé',
	'code-rev-modified-d' => 'supprimé',
	'code-rev-modified-m' => 'modifié',
	'code-rev-imagediff' => 'Modifications d’images',
	'code-rev-status' => 'État :',
	'code-rev-status-set' => 'Changer l’état',
	'code-rev-tags' => 'Balises :',
	'code-rev-tag-add' => 'Ajouter les balises :',
	'code-rev-tag-remove' => 'Enlever les balises :',
	'code-rev-comment-by' => 'Commentaire par $1',
	'code-rev-comment-preview' => 'Prévisualiser',
	'code-rev-inline-preview' => 'Prévisualisation :',
	'code-rev-diff' => 'Différence',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'Le diff est trop large pour être affiché.',
	'code-rev-purge-link' => 'purger',
	'code-rev-total' => 'Nombre total de résultats : $1',
	'code-rev-not-found' => "La révision '''$1''' n’existe pas !",
	'code-rev-history-link' => 'historique',
	'code-status-new' => 'nouveau',
	'code-status-desc-new' => 'Une action est en attente pour cette révision (état par défaut).',
	'code-status-fixme' => 'à corriger',
	'code-status-desc-fixme' => 'La révision a introduit un bug ou est erronée. Elle devrait être corrigée ou annulée.',
	'code-status-reverted' => 'révoqué',
	'code-status-desc-reverted' => 'La révision a été rejetée par une révision ultérieure.',
	'code-status-resolved' => 'résolu',
	'code-status-desc-resolved' => 'La révision apportait un problème qui a été corrigé par une révision ultérieure.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'La révision a été complètement relue et le relecteur est sûr qu’elle convient à tout point de vue.',
	'code-status-deferred' => 'différé',
	'code-status-desc-deferred' => 'La révision ne nécessite pas de relecture.',
	'code-status-old' => 'vieux',
	'code-status-desc-old' => 'Ancienne révision avec des bogues potentiels mais qui ne vaut pas l’effort d’être relue.',
	'code-signoffs' => 'Approbations',
	'code-signoff-legend' => 'Ajouter une approbation',
	'code-signoff-submit' => 'Approuver',
	'code-signoff-strike' => 'Barrer les approbations sélectionnées',
	'code-signoff-signoff' => 'Approuver cette révision :',
	'code-signoff-flag-inspected' => 'Inspecté',
	'code-signoff-flag-tested' => 'Testé',
	'code-signoff-field-user' => 'Utilisateur',
	'code-signoff-field-flag' => 'Indicateur',
	'code-signoff-field-date' => 'Date',
	'code-signoff-struckdate' => '$1 (a rayé $2)',
	'code-pathsearch-legend' => 'Rechercher des révisions dans ce dépôt par chemin',
	'code-pathsearch-path' => 'Chemin :',
	'code-pathsearch-filter' => 'Montrer seulement :',
	'code-revfilter-cr_status' => 'Statut = $1',
	'code-revfilter-cr_author' => 'Auteur = $1',
	'code-revfilter-ct_tag' => 'Balise = $1',
	'code-revfilter-clear' => 'Effacer le filtre',
	'code-rev-submit' => 'Enregistrer les modifications',
	'code-rev-submit-next' => 'Sauver & problème suivant',
	'code-rev-next' => 'Prochaine en suspens',
	'code-batch-status' => 'Modifier le statut :',
	'code-batch-tags' => 'Modifier les balises :',
	'codereview-batch-title' => 'Modifier toutes les révisions sélectionnées',
	'codereview-batch-submit' => 'Soumettre',
	'code-releasenotes' => 'notes de publication',
	'code-release-legend' => 'Générer les notes de publication',
	'code-release-startrev' => 'Révision de début :',
	'code-release-endrev' => 'Révision de fin :',
	'codereview-subtitle' => 'Pour $1',
	'codereview-reply-link' => 'répondre',
	'codereview-overview-title' => 'Vue d’ensemble',
	'codereview-overview-desc' => 'Affiche une vue d’ensemble graphique de cette liste.',
	'codereview-email-subj' => '[$1 $2] : nouveau commentaire ajouté',
	'codereview-email-body' => 'L’utilisateur « $1 » a posté un commentaire sur $3.

Lien hypertexte complet : $2

Résumé de la modification :

$5

Commentaire :

$4',
	'codereview-email-subj2' => '[$1 $2] : suivi de la modification',
	'codereview-email-body2' => 'L’utilisateur « $1 » a fait des modifications sur $2.

URL complète de la révision suivie : $5
Résumé de la modification :

$6

URL complète : $3
Résumé de la modification :

$4',
	'codereview-email-subj3' => '[$1 $2] : l’état de la version a changé',
	'codereview-email-body3' => 'L’utilisateur « $1 » a modifié l’état de $2.

Ancien état : $3
Nouvel état : $4

URL complète : $5
Résumé de la modification :

$6',
	'codereview-email-subj4' => '[$1 $2] : nouveau commentaire ajouté et état de la version changé',
	'codereview-email-body4' => 'L’utilisateur « $1 » a modifié l’état de $2.

Ancien état : $3
Nouvel état : $4

L’utilisateur « $1 » a également posté un commentaire sur $2.

Adresse URL complète : $5
Résumé de la modification :

$7

Commentaire :

$6',
	'code-stats' => 'statistiques',
	'code-stats-header' => 'Statistiques du dépôt $1',
	'code-stats-main' => 'À la date du $1, le dépôt a $2 {{PLURAL:$2|révision|révisions}} faites par [[Special:Code/$3/author|$4 {{PLURAL:$4|auteur|auteurs}}]].',
	'code-stats-status-breakdown' => 'Nombre de révisions par état',
	'code-stats-fixme-breakdown' => 'Ventilation des révisions à corriger par auteur',
	'code-stats-fixme-breakdown-path' => 'Répartition des révisions de type correction par chemin',
	'code-stats-fixme-path' => 'Révisions de correction pour le chemin: $1',
	'code-stats-new-breakdown' => 'Ventilation des nouvelles révisions par auteur',
	'code-stats-new-breakdown-path' => 'Répartition des nouvelles révisions par chemin',
	'code-stats-new-path' => 'Nouvelles révisions pour le chemin: $1',
	'code-stats-count' => 'Nombre de révisions',
	'code-tooltip-withsummary' => 'r$1 [$2] par $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] par $3',
	'repoadmin' => 'Administration des dépôts',
	'repoadmin-new-legend' => 'Créer un nouveau dépôt',
	'repoadmin-new-label' => 'Nom du dépôt :',
	'repoadmin-new-button' => 'Créer',
	'repoadmin-edit-legend' => 'Modification du dépôt « $1 »',
	'repoadmin-edit-path' => 'Chemin du dépôt :',
	'repoadmin-edit-bug' => 'Chemin vers Bugzilla :',
	'repoadmin-edit-view' => 'Chemin de ViewVC :',
	'repoadmin-edit-button' => 'Valider',
	'repoadmin-edit-sucess' => 'Le dépôt « [[Special:Code/$1|$1]] » a été modifié avec succès.',
	'repoadmin-nav' => 'administration du dépôt',
	'right-repoadmin' => 'Administrer les dépôts de code',
	'right-codereview-use' => 'Utiliser Special:Code',
	'right-codereview-add-tag' => 'Ajouter de nouvelles balises aux révisions',
	'right-codereview-remove-tag' => 'Enlever des balises des révisions',
	'right-codereview-post-comment' => 'Ajouter des commentaires aux révisions',
	'right-codereview-set-status' => 'Changer l’état des révisions',
	'right-codereview-signoff' => 'Approuver des révisions',
	'right-codereview-link-user' => 'Lier les auteurs aux utilisateurs wiki',
	'right-codereview-associate' => 'Gérer les associations de révisions',
	'right-codereview-review-own' => 'Marquer ses propres révisions comme "{{int:code-status-ok}}" ou "{{int:code-status-resolved}}"',
	'action-repoadmin' => 'gérer les dépôts de code',
	'action-codereview-use' => 'utiliser Special:Code',
	'action-codereview-add-tag' => 'ajouter de nouvelles balises aux révisions',
	'action-codereview-remove-tag' => 'supprimer des balises des révisions',
	'action-codereview-post-comment' => 'ajouter des commentaires aux révisions',
	'action-codereview-set-status' => 'changer l’état des révisions',
	'action-codereview-signoff' => 'approuver des révisions',
	'action-codereview-link-user' => 'lier des auteurs aux utilisateurs du wiki',
	'action-codereview-associate' => 'gérer les associations entre révisions',
	'action-codereview-review-own' => 'marquer vos propres révisions comme "{{int:code-status-ok}} ou "{{int:code-status-resolved}}"',
	'specialpages-group-developer' => 'Outils du développeur',
	'group-svnadmins' => 'Administrateurs SVN',
	'group-svnadmins-member' => '{{GENDER:$1|administrateur SVN|administratrice SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Administrateurs SVN',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'code' => 'Rèvision du code',
	'code-rev-title' => '$1 - Rèvision du code',
	'code-comments' => 'Comentèros',
	'code-references' => 'Refèrences de vers les rèvisions',
	'code-change-status' => "at changiê l’'''ètat''' de $1",
	'code-change-tags' => "at changiê les '''balises''' de $1",
	'code-change-removed' => 'enlevâ :',
	'code-change-added' => 'apondu :',
	'code-old-status' => 'Viely ètat',
	'code-new-status' => 'Novél ètat',
	'code-prop-changes' => 'Jornal des ètats et du balisâjo',
	'codereview-desc' => '[[Special:Code|Outils de rèvision du code]] avouéc l’[[Special:RepoAdmin|assistance de Subversion]].',
	'code-no-repo' => 'Gins de dèpôt configurâ !',
	'code-create-repo' => 'Alâd a [[Special:RepoAdmin|RepoAdmin]] por fâre un dèpôt',
	'code-need-repoadmin-rights' => "Des privilèjos de nivél ''repoadmin'' sont nècèssèros por fâre un dèpôt",
	'code-need-group-with-rights' => "Niona tropa de nivél ''repoadmin'' ègziste. Nen volyéd apondre yona por étre en mesera de fâre un dèpôt novél.",
	'code-repo-not-found' => "Lo dèpôt '''$1''' ègziste pas !",
	'code-load-diff' => 'Chargement du dif en cors...',
	'code-notes' => 'novéls comentèros',
	'code-statuschanges' => 'changements d’ètat',
	'code-mycommits' => 'mes publecacions',
	'code-mycomments' => 'mos comentèros',
	'code-authors' => 'ôtors',
	'code-status' => 'ètats',
	'code-tags' => 'balises',
	'code-tags-no-tags' => 'Niona balisa ègziste dens cél dèpôt.',
	'code-authors-text' => 'Vê-que una lista ux ôtors de dèpôts triyês per nom. Los comptos du vouiqui local sont montrâs entre-mié parentèses. Les balyês pôvont étre en cache.',
	'code-author-haslink' => 'Cél ôtor est liyê u compto $1 de ceti vouiqui',
	'code-author-orphan' => 'L’usanciér SVN / ôtor $1 est pas liyê a un compto vouiqui',
	'code-author-dolink' => 'Associyér ceti ôtor a un usanciér vouiqui local :',
	'code-author-alterlink' => 'Changiér l’usanciér vouiqui liyê a ceti ôtor :',
	'code-author-orunlink' => 'Ou ben dèliyér ceti usanciér vouiqui :',
	'code-author-name' => 'Buchiéd un nom d’usanciér :',
	'code-author-success' => 'L’ôtor $1 at étâ liyê a l’usanciér vouiqui $2',
	'code-author-link' => 'liyér ?',
	'code-author-unlink' => 'dèliyér ?',
	'code-author-unlinksuccess' => 'L’ôtor $1 at étâ dèliyê',
	'code-author-badtoken' => 'Èrror de sèance pendent l’ègzécucion de l’accion.',
	'code-author-total' => 'Soma totâla d’ôtors : $1',
	'code-author-lastcommit' => 'Dèrriére dâta d’èxpèdicion',
	'code-browsing-path' => "Parcors de les rèvisions dens '''$1'''",
	'code-field-id' => 'Rèvision',
	'code-field-author' => 'Ôtor',
	'code-field-user' => 'Comentator',
	'code-field-message' => 'Rèsumâ de publecacion',
	'code-field-status' => 'Ètat',
	'code-field-status-description' => 'Dèscripcion de l’ètat',
	'code-field-timestamp' => 'Dâta',
	'code-field-comments' => 'Comentèros',
	'code-field-path' => 'Chemin',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Chouèsir',
	'code-reference-remove' => 'Enlevar les associacions chouèsies',
	'code-reference-associate' => 'Associyér ceta rèvision :',
	'code-reference-associate-submit' => 'Associyér',
	'code-rev-author' => 'Ôtor :',
	'code-rev-date' => 'Dâta :',
	'code-rev-message' => 'Comentèro :',
	'code-rev-repo' => 'Dèpôt :',
	'code-rev-rev' => 'Rèvision :',
	'code-rev-rev-viewvc' => 'dessus ViewVC',
	'code-rev-paths' => 'Chemins changiês :',
	'code-rev-modified-a' => 'apondu',
	'code-rev-modified-r' => 'remplaciê',
	'code-rev-modified-d' => 'suprimâ',
	'code-rev-modified-m' => 'changiê',
	'code-rev-imagediff' => 'Changements d’émâges',
	'code-rev-status' => 'Ètat :',
	'code-rev-status-set' => 'Changiér l’ètat',
	'code-rev-tags' => 'Balises :',
	'code-rev-tag-add' => 'Apondre les balises :',
	'code-rev-tag-remove' => 'Enlevar les balises :',
	'code-rev-comment-by' => 'Comentèro per $1',
	'code-rev-comment-preview' => 'Prèvisualisacion',
	'code-rev-inline-preview' => 'Prèvisualisacion :',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'Lo dif est trop lârjo por étre montrâ.',
	'code-rev-purge-link' => 'purgiér',
	'code-rev-total' => 'Soma totâla de rèsultats : $1',
	'code-rev-not-found' => "La vèrsion '''$1''' ègziste pas !",
	'code-rev-history-link' => 'historico',
	'code-status-new' => 'novél',
	'code-status-desc-new' => 'Una accion est en atenta por cela rèvision (ètat per dèfôt).',
	'code-status-fixme' => 'a corregiér',
	'code-status-desc-fixme' => 'La rèvision at entroduit una cofierie ou ben est fôssa. Devrêt étre corregiê ou ben anulâ.',
	'code-status-reverted' => 'rèvocâ',
	'code-status-desc-reverted' => 'La rèvision at étâ refusâ per una rèvision futura.',
	'code-status-resolved' => 'solucionâ',
	'code-status-desc-resolved' => 'La rèvision aportâve un problèmo qu’at étâ corregiê per una rèvision futura.',
	'code-status-ok' => 'd’acôrd',
	'code-status-desc-ok' => 'La rèvision at étâ complètament revua et pués lo rèvisor est de sûr que convint a tot côp d’uely.',
	'code-status-deferred' => 'retardâ',
	'code-status-desc-deferred' => 'La rèvision at pas fôta de rèvision.',
	'code-status-old' => 'viely',
	'code-status-desc-old' => 'Una vielye rèvision avouéc des cofieries potencièles mas que vâlt pas l’èfôrt d’étre revua.',
	'code-signoffs' => 'Aprobacions',
	'code-signoff-legend' => 'Apondre una aprobacion',
	'code-signoff-submit' => 'Aprovar',
	'code-signoff-strike' => 'Traciér les aprobacions chouèsies',
	'code-signoff-signoff' => 'Aprovar cela rèvision coment :',
	'code-signoff-flag-inspected' => 'Controlâ',
	'code-signoff-flag-tested' => 'Èprovâ',
	'code-signoff-field-user' => 'Usanciér',
	'code-signoff-field-flag' => 'Endiquior',
	'code-signoff-field-date' => 'Dâta',
	'code-signoff-struckdate' => '$1 (at traciê $2)',
	'code-pathsearch-legend' => 'Rechèrchiér des rèvisions dens ceti dèpôt per chemin',
	'code-pathsearch-path' => 'Chemin :',
	'code-pathsearch-filter' => 'Fâre vêre ren que :',
	'code-revfilter-cr_status' => 'Statut = $1',
	'code-revfilter-cr_author' => 'Ôtor = $1',
	'code-revfilter-ct_tag' => 'Balisa = $1',
	'code-revfilter-clear' => 'Èfaciér lo filtro',
	'code-rev-submit' => 'Sôvar los changements',
	'code-rev-submit-next' => 'Sôvar & problèmo aprés',
	'code-rev-next' => 'Vesena pas solucionâ',
	'code-batch-status' => 'Changiér l’ètat :',
	'code-batch-tags' => 'Changiér les balises :',
	'codereview-batch-title' => 'Changiér totes les rèvisions chouèsies',
	'codereview-batch-submit' => 'Sometre',
	'code-releasenotes' => 'notes de publecacion',
	'code-release-legend' => 'Fâre les notes de publecacion',
	'code-release-startrev' => 'Rèvision de comencement :',
	'code-release-endrev' => 'Rèvision de fin :',
	'codereview-subtitle' => 'Por $1',
	'codereview-reply-link' => 'rèpondre',
	'codereview-overview-title' => 'Apèrçu',
	'codereview-overview-desc' => 'Montre un apèrçu grafico de cela lista.',
	'codereview-email-subj' => '[$1 $2] : novél comentèro apondu',
	'codereview-email-body' => 'L’usanciér « $1 » at postâ un comentèro dessus $3.
URL complèta : $2

Rèsumâ de changement :

$5

Comentèro :

$4',
	'codereview-email-subj2' => '[$1 $2] : survelyence du changement',
	'codereview-email-body2' => 'L’usanciér « $1 » at fêt des changements de ples sur $2.
URL complèta : $5

Rèsumâ de changement :

$6

URL complèta de la vèrsion siuvua : $3
Rèsumâ de changement :

$4',
	'codereview-email-subj3' => '[$1 $2] : l’ètat de la vèrsion at changiê',
	'codereview-email-body3' => 'L’usanciér « $1 » at changiê l’ètat de $2 a « $4 ».
URL complèta : $5

Viely ètat : $3
Novél ètat : $4

Rèsumâ de changement :

$6',
	'codereview-email-subj4' => '[$1 $2] : novél comentèro apondu et pués ètat de la vèrsion changiê',
	'codereview-email-body4' => 'L’usanciér « $1 » at changiê l’ètat de $2.
Adrèce URL complèta : $5

Viely ètat : $3
Novél ètat : $4

L’usanciér « $1 » at asse-ben pôstâ un comentèro sur $2.

Rèsumâ du changement :

$7

Comentèro :

$6',
	'code-stats' => 'statistiques',
	'code-stats-header' => 'Statistiques por lo dèpôt $1',
	'code-stats-main' => 'A la dâta du $1, lo dèpôt at $2 {{PLURAL:$2|rèvision fêta|rèvisions fêtes}} per [[Special:Code/$3/author|$4 ôtor{{PLURAL:$4||s}}]].',
	'code-stats-status-breakdown' => 'Nombro de rèvisions per ètat',
	'code-stats-fixme-breakdown' => 'Ventilacion de les rèvisions a corregiér per ôtor',
	'code-stats-fixme-breakdown-path' => 'Ventilacion de les rèvisions a corregiér per chemin',
	'code-stats-fixme-path' => 'Rèvisions a corregiér por lo chemin : $1',
	'code-stats-new-breakdown' => 'Ventilacion de les novèles rèvisions per ôtor',
	'code-stats-new-breakdown-path' => 'Ventilacion de les novèles rèvisions per chemin',
	'code-stats-new-path' => 'Novèles rèvisions por lo chemin : $1',
	'code-stats-count' => 'Nombro de rèvisions',
	'code-tooltip-withsummary' => 'r$1 [$2] per $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] per $3',
	'repoadmin' => 'Administracion des dèpôts',
	'repoadmin-new-legend' => 'Fâre un dèpôt novél',
	'repoadmin-new-label' => 'Nom du dèpôt :',
	'repoadmin-new-button' => 'Fâre',
	'repoadmin-edit-legend' => 'Changement du dèpôt « $1 »',
	'repoadmin-edit-path' => 'Chemin du dèpôt :',
	'repoadmin-edit-bug' => 'Chemin de vers Bugzilla :',
	'repoadmin-edit-view' => 'Chemin de ViewVC :',
	'repoadmin-edit-button' => 'D’acôrd',
	'repoadmin-edit-sucess' => 'Lo dèpôt « [[Special:Code/$1|$1]] » at étâ changiê avouéc reusséta.',
	'repoadmin-nav' => 'administracion du dèpôt',
	'right-repoadmin' => 'Administrar los dèpôts de code',
	'right-codereview-use' => 'Utilisar Special:Code',
	'right-codereview-add-tag' => 'Apondre de balises novèles a les rèvisions',
	'right-codereview-remove-tag' => 'Enlevar des balises de les rèvisions',
	'right-codereview-post-comment' => 'Apondre des comentèros a les rèvisions',
	'right-codereview-set-status' => 'Changiér l’ètat de les rèvisions',
	'right-codereview-signoff' => 'Aprovar des rèvisions',
	'right-codereview-link-user' => 'Liyér los ôtors ux usanciérs vouiqui',
	'right-codereview-associate' => 'Administrar les associacions de rèvisions',
	'right-codereview-review-own' => 'Marcar ses prôpres rèvisions coment OK ou ben Solucionâ',
	'specialpages-group-developer' => 'Outils u dèvelopor',
	'group-svnadmins' => 'Administrators SVN',
	'group-svnadmins-member' => 'administrat{{GENDER:$1|or|rice}} SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Administrators SVN',
);

/** Friulian (Furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'code-stats' => 'statistichis',
	'repoadmin-edit-button' => 'Va ben',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'code-field-message' => 'Achoimre tiomnú',
	'code-rev-message' => 'Nóta tráchta:',
	'codereview-email-body' => 'Chuir úsáideoir "$1 nóta tráchta ar $3.

Dearbh-URL: $2

Nóta tráchta:

$4',
	'repoadmin-new-button' => 'Cruthaigh',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'code' => 'Revisión do código',
	'code-rev-title' => '$1 - Revisión do código',
	'code-comments' => 'Comentarios',
	'code-references' => 'Seguir as revisións',
	'code-referenced' => 'Revisións seguidas',
	'code-change-status' => "cambiou o '''estado''' da versión $1",
	'code-change-tags' => "cambiou as '''etiquetas''' da versión $1",
	'code-change-removed' => 'eliminado:',
	'code-change-added' => 'engadido:',
	'code-old-status' => 'Estado vello',
	'code-new-status' => 'Novo estado',
	'code-prop-changes' => 'Estado e rexistro de etiquetas',
	'codereview-desc' => '[[Special:Code|Ferramenta de revisión do código]] con [[Special:RepoAdmin|apoio da subversión]]',
	'code-no-repo' => 'Non hai ningún repositorio configurado!',
	'code-create-repo' => 'Vaia ao [[Special:RepoAdmin|apoio da subversión]] para crear un repositorio',
	'code-need-repoadmin-rights' => 'Cómpre ter dereitos do tipo "repoadmin" para poder crear un repositorio',
	'code-need-group-with-rights' => 'Non existe ningún grupo con dereitos do tipo "repoadmin". Engada algún para poder crear un novo repositorio',
	'code-repo-not-found' => "O repositorio \"'''\$1'''\" non existe!",
	'code-load-diff' => 'Cargando as diferenzas…',
	'code-notes' => 'comentarios recentes',
	'code-statuschanges' => 'cambios de estado',
	'code-mycommits' => 'as miñas publicacións',
	'code-mycomments' => 'os meus comentarios',
	'code-authors' => 'autores',
	'code-status' => 'estados',
	'code-tags' => 'etiquetas',
	'code-tags-no-tags' => 'Non existe ningunha etiqueta neste repositorio.',
	'code-authors-text' => 'A continuación está a lista cos autores das respostas ordenados por nome. As contas do wiki local móstranse entre parénteses. Os datos poden provir da memoria caché.',
	'code-author-haslink' => 'O autor é ligado co usuario do wiki chamado $1',
	'code-author-orphan' => 'O usuario SVN ou autor $1 non está asociado a ningunha conta do wiki',
	'code-author-dolink' => 'Ligar este autor cun usuario do wiki:',
	'code-author-alterlink' => 'Cambiar o usuario do wiki que liga con este autor:',
	'code-author-orunlink' => 'Ou retirar a ligazón deste usuario do wiki:',
	'code-author-name' => 'Insira un nome de usuario:',
	'code-author-success' => 'O autor $1 foi ligado con éxito ao usuario do wiki $2',
	'code-author-link' => 'quere inserir a ligazón?',
	'code-author-unlink' => 'quere retirar a ligazón?',
	'code-author-unlinksuccess' => 'Foi retirada a ligazón que tiña o autor $1',
	'code-author-badtoken' => 'Erro de sesión ao intentar levar a cabo a acción.',
	'code-author-total' => 'Número total de autores: $1',
	'code-author-lastcommit' => 'Última data de publicación',
	'code-browsing-path' => "Navegando polas revisións en '''$1'''",
	'code-field-id' => 'Revisión',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentarista',
	'code-field-message' => 'Resumo de tarefas',
	'code-field-status' => 'Estado',
	'code-field-status-description' => 'Descrición do estado',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Comentarios',
	'code-field-path' => 'Ruta',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Seleccionar',
	'code-reference-remove' => 'Eliminar as asociacións seleccionadas',
	'code-reference-associate' => 'Asociar a revisión de seguimento:',
	'code-reference-associate-submit' => 'Asociar',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Comentario:',
	'code-rev-repo' => 'Repositorio:',
	'code-rev-rev' => 'Revisión:',
	'code-rev-rev-viewvc' => 'en ViewVC',
	'code-rev-paths' => 'Rutas modificadas:',
	'code-rev-modified-a' => 'engadido',
	'code-rev-modified-r' => 'substituído',
	'code-rev-modified-d' => 'borrado',
	'code-rev-modified-m' => 'modificado',
	'code-rev-imagediff' => 'Cambios na imaxe',
	'code-rev-status' => 'Estado:',
	'code-rev-status-set' => 'Cambiar o estado',
	'code-rev-tags' => 'Etiquetas:',
	'code-rev-tag-add' => 'Engadir as etiquetas:',
	'code-rev-tag-remove' => 'Eliminar as etiquetas:',
	'code-rev-comment-by' => 'Comentario de $1',
	'code-rev-comment-preview' => 'Vista previa',
	'code-rev-inline-preview' => 'Vista previa:',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'A diferenza é demasiado grande para mostrala.',
	'code-rev-purge-link' => 'limpar',
	'code-rev-total' => 'Número total de resultados: $1',
	'code-rev-not-found' => "A revisión '''$1''' non existe!",
	'code-rev-history-link' => 'historial',
	'code-status-new' => 'novo',
	'code-status-desc-new' => 'Esta revisión está á espera dunha acción (estado por defecto).',
	'code-status-fixme' => 'arránxeme',
	'code-status-desc-fixme' => 'A revisión introduciu un erro ou esta é errónea. Cómpre corrección ou reversión.',
	'code-status-reverted' => 'revertido',
	'code-status-desc-reverted' => 'A revisión desbotouna outra revisión posterior.',
	'code-status-resolved' => 'resolto',
	'code-status-desc-resolved' => 'A revisión tiña un problema que foi corrixido por outra revisión posterior.',
	'code-status-ok' => 'aceptar',
	'code-status-desc-ok' => 'A revisión foi completamente comprobada e o revisor está seguro de que é correcta.',
	'code-status-deferred' => 'diferido',
	'code-status-desc-deferred' => 'Esta revisión non necesita comprobación.',
	'code-status-old' => 'vello',
	'code-status-desc-old' => 'Revisión vella con erros potenciais que non paga a pena o esforzo de revisala.',
	'code-signoffs' => 'Aprobacións',
	'code-signoff-legend' => 'Engadir unha aprobación',
	'code-signoff-submit' => 'Aprobar',
	'code-signoff-strike' => 'Riscar as aprobacións seleccionadas',
	'code-signoff-signoff' => 'Aprobar esta revisión:',
	'code-signoff-flag-inspected' => 'Inspeccionado',
	'code-signoff-flag-tested' => 'Probado',
	'code-signoff-field-user' => 'Usuario',
	'code-signoff-field-flag' => 'Indicador',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 (riscou $2)',
	'code-pathsearch-legend' => 'Procurar as revisións nesta resposta por ruta',
	'code-pathsearch-path' => 'Ruta:',
	'code-pathsearch-filter' => 'Mostrar só:',
	'code-revfilter-cr_status' => 'Estado = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Etiqueta = $1',
	'code-revfilter-clear' => 'Restablecer o filtro',
	'code-rev-submit' => 'Gardar os cambios',
	'code-rev-submit-next' => 'Gardar e vindeiro non resolto',
	'code-rev-next' => 'Seguinte sen resolver',
	'code-batch-status' => 'Cambiar o estado:',
	'code-batch-tags' => 'Cambiar as etiquetas:',
	'codereview-batch-title' => 'Cambiar todas as revisións seleccionadas',
	'codereview-batch-submit' => 'Enviar',
	'code-releasenotes' => 'notas de lanzamento',
	'code-release-legend' => 'Xerar as notas de lanzamento',
	'code-release-startrev' => 'Primeira revisión:',
	'code-release-endrev' => 'Última revisión:',
	'codereview-subtitle' => 'De $1',
	'codereview-reply-link' => 'responder',
	'codereview-overview-title' => 'Vista xeral',
	'codereview-overview-desc' => 'Mostrar unha vista xeral gráfica desta lista',
	'codereview-email-subj' => '[$1 $2]: engadido un novo comentario',
	'codereview-email-body' => 'O usuario "$1" deixou un comentario na versión $3.

Enderezo URL: $2
Resumo da edición:

$5

Comentario:

$4',
	'codereview-email-subj2' => '[$1 $2]: seguimento de cambios',
	'codereview-email-body2' => 'O usuario "$1" fixo un seguimento dos cambios feitos na versión $2.

URL da versión seguida: $5
Resumo da edición:

$6

Enderezo URL: $3

Resumo:

$4',
	'codereview-email-subj3' => '[$1 $2]: cambiou o estado da revisión',
	'codereview-email-body3' => 'O usuario "$1" cambiou o estado de $2.

Estado vello: $3
Estado novo: $4

URL completo: $5
Resumo da edición:

$6',
	'codereview-email-subj4' => '[$1 $2]: engadido un novo comentario e cambiado o estado da revisión',
	'codereview-email-body4' => 'O usuario "$1" cambiou o estado de $2.

Estado vello: $3
Estado novo: $4

O usuario "$1" tamén deixou un comentario en $2.

Enderezo URL: $5
Resumo da edición:

$7

Comentario:

$6',
	'code-stats' => 'estatísticas',
	'code-stats-header' => 'Estatísticas do repositorio "$1"',
	'code-stats-main' => 'A día $6 ás $5, o repositorio ten $2 {{PLURAL:$2|revisión|revisións}} feitas por [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autores}}]].',
	'code-stats-status-breakdown' => 'Número de revisións por estado',
	'code-stats-fixme-breakdown' => 'Detalle das revisións de corrección por autor',
	'code-stats-fixme-breakdown-path' => 'Detalle das revisións de corrección por ruta',
	'code-stats-fixme-path' => 'Revisións de corrección da ruta: $1',
	'code-stats-new-breakdown' => 'Detalle das novas revisións por autor',
	'code-stats-new-breakdown-path' => 'Detalle das novas revisións por ruta',
	'code-stats-new-path' => 'Novas revisións da ruta: $1',
	'code-stats-count' => 'Número de revisións',
	'code-tooltip-withsummary' => 'r$1 [$2] por $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] por $3',
	'repoadmin' => 'Administración do repositorio',
	'repoadmin-new-legend' => 'Crear un novo repositorio',
	'repoadmin-new-label' => 'Nome do repositorio:',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modificación do repositorio "$1"',
	'repoadmin-edit-path' => 'Ruta do repositorio:',
	'repoadmin-edit-bug' => 'Ruta Bugzilla:',
	'repoadmin-edit-view' => 'Ruta ViewVC:',
	'repoadmin-edit-button' => 'Aceptar',
	'repoadmin-edit-sucess' => 'O repositorio "[[Special:Code/$1|$1]]" foi modificado con éxito.',
	'repoadmin-nav' => 'administración do repositorio',
	'right-repoadmin' => 'Xestionar os repositorios de código',
	'right-codereview-use' => 'Usar Special:Code',
	'right-codereview-add-tag' => 'Engadir etiquetas novas ás revisións',
	'right-codereview-remove-tag' => 'Eliminar etiquetas das revisións',
	'right-codereview-post-comment' => 'Engadir comentarios ás revisións',
	'right-codereview-set-status' => 'Cambiar o estado das revisións',
	'right-codereview-signoff' => 'Aprobar revisións',
	'right-codereview-link-user' => 'Ligar autores a usuarios do wiki',
	'right-codereview-associate' => 'Xestionar as asociacións de revisións',
	'right-codereview-review-own' => 'Marcar as revisións propias como "{{int:code-status-ok}}" ou "{{int:code-status-resolved}}"',
	'action-repoadmin' => 'xestionar os repositorios de código',
	'action-codereview-use' => 'usar Special:Code',
	'action-codereview-add-tag' => 'engadir etiquetas novas ás revisións',
	'action-codereview-remove-tag' => 'eliminar etiquetas das revisións',
	'action-codereview-post-comment' => 'engadir comentarios ás revisións',
	'action-codereview-set-status' => 'cambiar o estado das revisións',
	'action-codereview-signoff' => 'aprobar revisións',
	'action-codereview-link-user' => 'ligar autores a usuarios do wiki',
	'action-codereview-associate' => 'xestionar as asociacións de revisións',
	'action-codereview-review-own' => 'marcar as revisións propias como "{{int:code-status-ok}}" ou "{{int:code-status-resolved}}"',
	'specialpages-group-developer' => 'Ferramentas dos desenvolvedores',
	'group-svnadmins' => 'Administradores do SVN',
	'group-svnadmins-member' => '{{GENDER:$1|administrador|administradora}} do SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Administradores do SVN',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Crazymadlover
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'code' => 'Ἐπιθεωρεῖν τὸν Κώδικα',
	'code-rev-title' => '$1 - Ἐπιθεώρησις κώδικος',
	'code-comments' => 'Σχόλια',
	'code-change-status' => "μεταβεβλημένον τὸ '''καθεστὼς''' τῆς ἀναθεωρήσεως $1",
	'code-change-tags' => "μεταβλητέα εἰσὶ τὰ '''πρότυπα''' διὰ τὴν ἀναθεώρησιν $1",
	'code-change-removed' => 'προστεθειμένη:',
	'code-change-added' => 'ἀφῃρημένη:',
	'code-prop-changes' => 'Καθεστὼς & κατάλογος προσαρτημάτων',
	'codereview-desc' => '[[Special:Code|Ἐργαλεῖον ἐπιθεωρήσεως κώδικος]] μετὰ [[Special:RepoAdmin|Ὑποστηρίξεως ὑποστροφῆς]]',
	'code-no-repo' => 'Οὐδεμία ἀποθήκη διαμεμορφωμένη!',
	'code-load-diff' => 'Φορτίζειν διαφ...',
	'code-notes' => 'τὰ πρόσφατα σχόλια',
	'code-authors' => 'δημιουργοί',
	'code-status' => 'καταστάσεις',
	'code-tags' => 'προσαρτήματα',
	'code-authors-text' => 'Κάτωθι ἐστὶ καταλογή τις δημιουργῶν τῆς ἀποθήκης κατατάξει τῶν πλείω προσφάτων καταθέσεων. Τοπικοὶ βικι-λογισμοὶ δείκνυνται ἐν παρενθέσεσιν.',
	'code-author-haslink' => 'Ὅδε ὁ δημιουργὸς συνδεδεμένος ἐστὶ μετὰ τοῦ βικι-χρωμένου $1',
	'code-author-orphan' => 'Ὅδε ὁ χρώμενος οὐκ ἔχει σύνδεσμον μετὰ βικι-λογισμοῦ τινός',
	'code-author-dolink' => 'Συνδεῖσθαι τόνδε τὸν δημιουργὸν μετὰ βικι-χρωμένου τινός:',
	'code-author-alterlink' => 'Ἀλλάττειν βικι-χρώμενον τὸν συνδεδεμένον μετὰ τοῦδε τοῦ χρωμένου:',
	'code-author-orunlink' => 'Ἢ ἀποδιασυνδεῖσθαι τόνδε τὸν χρώμενον:',
	'code-author-name' => 'Εὶσάγειν ὄνομα χρωμένου τι:',
	'code-author-success' => 'Ὁ δημιουργὸς $1 διασυνδεδεμένος ἐστὶ μετὰ τοῦ βικι-χρωμένου $2',
	'code-author-link' => 'συνδεῖσθαι;',
	'code-author-unlink' => 'ἀσυνδεῖσθαι;',
	'code-author-unlinksuccess' => 'Ὁ δημιουργὸς $1 ἀποδιασυνδεδεμένος ἐστίν',
	'code-field-id' => 'Ἀναθεώρησις',
	'code-field-author' => 'Δημιουργός',
	'code-field-user' => 'Σχολιάζων',
	'code-field-message' => 'Περιλαμβάνειν σύνοψιν',
	'code-field-status' => 'Κατάστασις',
	'code-field-timestamp' => 'Ἡμερομηνία',
	'code-field-comments' => 'Σημειώματα',
	'code-field-path' => 'Ἀτραπός',
	'code-field-text' => 'Σημείωμα',
	'code-field-select' => 'Ἐπιλέγειν',
	'code-rev-author' => 'Δημιουργός:',
	'code-rev-date' => 'Ἡμερομηνία:',
	'code-rev-message' => 'Σχόλιον:',
	'code-rev-repo' => 'Ἀποθήκη:',
	'code-rev-rev' => 'Ἀναθεώρησις:',
	'code-rev-rev-viewvc' => 'ὲπὶ τοῦ ViewVC',
	'code-rev-paths' => 'Μεταβεβλημέναι ἀποθέσεις:',
	'code-rev-modified-a' => 'προστεθειμένη',
	'code-rev-modified-r' => 'ὑποκατεστημένη',
	'code-rev-modified-d' => 'διεγραμμένη',
	'code-rev-modified-m' => 'μεταβεβλημένη',
	'code-rev-status' => 'Κατάστασις:',
	'code-rev-status-set' => 'Μεταβάλλειν τὸ καθεστώς',
	'code-rev-tags' => 'Προσαρτήματα:',
	'code-rev-tag-add' => 'Προστιθέναι προσαρτήματα:',
	'code-rev-tag-remove' => 'Ἀφαιρεῖν προσαρτήματα:',
	'code-rev-comment-by' => 'Σχόλιον ὑπὸ τοῦ $1',
	'code-rev-comment-preview' => 'Προθεωρεῖν',
	'code-rev-diff' => 'Διαφ',
	'code-rev-diff-link' => 'διαφ',
	'code-rev-purge-link' => 'ἐκκαθαίρειν',
	'code-status-new' => 'νέα',
	'code-status-fixme' => 'διορθωτέα',
	'code-status-reverted' => 'ἀνεστραμμένη',
	'code-status-resolved' => 'ἐπιλελυμένη',
	'code-status-ok' => 'εἶεν',
	'code-status-deferred' => 'ἀναβεβλημένη',
	'code-signoff-field-date' => 'Ἡμερομηνία',
	'code-pathsearch-legend' => 'Ζητεῖν ἀναθεωρήσεις ἐν τῇδε τῇ καταθέσει ἀνὰ ἀτραπόν',
	'code-pathsearch-path' => 'Ἀτραπὀς:',
	'code-rev-submit' => 'Καταγράφειν τὰς μεταγραφάς',
	'code-rev-submit-next' => 'Καταγράφειν & ἐπομένη ἀνεπίλυτοι',
	'codereview-batch-submit' => 'Ὑποβάλλειν',
	'codereview-subtitle' => 'Διὰ $1',
	'codereview-reply-link' => 'ἀποκρίνεσθαι',
	'codereview-email-subj' => '[$1 $2]: Σχόλιον νέον προστεθειμένον',
	'codereview-email-body' => 'Ὁ χρώμενος "$1" ἀπέσταλκεν σχόλιόν τι τῷ $3.

Πλήρης URL: $2

Σχόλιον:

$4',
	'repoadmin' => 'Ἐπιτροπὴ ἀποθηκευτηρίου',
	'repoadmin-new-legend' => 'Ποιεῖν νέαν ἀποθήκην τινά',
	'repoadmin-new-label' => 'Ἀποθήκης τὸ ὄνομα:',
	'repoadmin-new-button' => 'Ποιεῖν',
	'repoadmin-edit-legend' => 'Μεταβολὴ τῆς ἀποθήκης "$1"',
	'repoadmin-edit-path' => 'Ἀπόθεσις ἐν τῇ ἀποθήκῃ:',
	'repoadmin-edit-bug' => 'Ἀτραπὸς Bugzilla:',
	'repoadmin-edit-view' => 'Ἀτραπὸς ViewVC:',
	'repoadmin-edit-button' => 'εἶεν',
	'repoadmin-edit-sucess' => 'Ἡ ἀποθήκη "[[Special:Code/$1|$1]]" ἐπιτυχῶς μεταβεβλημένη ἐστίν.',
	'right-repoadmin' => 'Διαχειρίζεσθαι τοὺς κώδικας τῶν ἀποθηκῶν',
	'right-codereview-add-tag' => 'Προστιθέναι νέα προσαρτήματα ταῖς ἀναθεωρήσεσιν',
	'right-codereview-remove-tag' => 'Ἀφαιρεῖν προσαρτήματα ὑπὸ τὰς ἀναθεωρήσεις',
	'right-codereview-post-comment' => 'Προστιθέναι νέα σχόλια ταῖς ἀναθεωρήσεσιν',
	'right-codereview-set-status' => 'Μεταβάλλειν τὸ καθεστὼς τῶν ἀναθεωρήσεων',
	'right-codereview-link-user' => 'Συνδεῖσθαι τοὺς δημιουργοὺς μετὰ βικι-χρωμένων',
	'specialpages-group-developer' => 'Ἐργαλεῖα ἀναπτυκτῶν',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'code' => 'Codepriefig',
	'code-rev-title' => '$1 – Codepriefig',
	'code-comments' => 'Kommentar',
	'code-references' => 'Negschti Versione',
	'code-change-status' => "het dr '''Status''' vu $1 gänderet",
	'code-change-tags' => "het d '''Tag''' vu $1 gänderet",
	'code-change-removed' => 'usegnuh:',
	'code-change-added' => 'zuegfiegt:',
	'code-old-status' => 'Alte Status',
	'code-new-status' => 'Neje Status',
	'code-prop-changes' => 'Status- un Tagging-Logbuech',
	'codereview-desc' => '[[Special:Code|Codepriefigs-Wärchzyyg]] mit [[Special:RepoAdmin|Subversion-Unterstitzig]]',
	'code-no-repo' => 'Kei Depot konfiguriert.',
	'code-create-repo' => 'Gang uf d Spezialsyte [[Special:RepoAdmin|RepoAdmin]] go ne Repositorium aalege',
	'code-need-repoadmin-rights' => 'Du bruchsch d Berächtigung repoadmin go ne Repositorium aalege',
	'code-need-group-with-rights' => 'S git kei Benutzergruppe mit dr Berächtigung repoadmin. Bitte eini zuefiege go ne nej Repositorium aalege',
	'code-repo-not-found' => "Depot '''$1''' git s nit!",
	'code-load-diff' => 'Diff am Lade…',
	'code-notes' => 'Priefnotize',
	'code-statuschanges' => 'Statusänderige',
	'code-mycommits' => 'myy Commits',
	'code-mycomments' => 'myy Kommentar',
	'code-authors' => 'Autore',
	'code-status' => 'Status',
	'code-tags' => 'Tag',
	'code-tags-no-tags' => 'S git kei Tag in däm Repositorium.',
	'code-authors-text' => 'Des isch d Lischt vu dr Autore, sortiert no Nämme. Lokali Wikikonte wäre in runde Chlammere ufgfiert. Date chennte us em Cache stamme.',
	'code-author-haslink' => 'Dää Autor isch zum Wiki-Benutzer $1 vergleicht',
	'code-author-orphan' => 'Dää SVN-Benutzer/Autor $1 het kei Gleich zue me Wiki-Benutzerkonto',
	'code-author-dolink' => 'Dää Autor zue me Wiki-Benutzerkonto vergleiche:',
	'code-author-alterlink' => 'D Vergleichig zue me Wiki-Benutzerkonto fir dää Autor ändere:',
	'code-author-orunlink' => 'Vergleichig zum Wiki-Benutzerkonto ufhebe:',
	'code-author-name' => 'Benutzername:',
	'code-author-success' => 'Dr Autor $1 isch mit em Wikibenutzer $2 vergleicht wore',
	'code-author-link' => 'vergleiche?',
	'code-author-unlink' => 's Gleich useneh?',
	'code-author-unlinksuccess' => 'D Vergleichig vum Autor $1 isch usegnuh wore',
	'code-author-badtoken' => 'Sitzigsfähler bim Uusfiere vu däre Aktion.',
	'code-author-total' => 'Gsamtaazahl vu dr Autore: $1',
	'code-author-lastcommit' => 'Letscht Ibertragigsdatum',
	'code-browsing-path' => "Am Dursueche vu Versione in '''$1'''",
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Kommentator',
	'code-field-message' => 'Kommentar',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Status-Bschryybig',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Kommentar',
	'code-field-path' => 'Pfad',
	'code-field-text' => 'Notiz',
	'code-field-select' => 'Uswehle',
	'code-reference-remove' => 'Uusgwehlti Verchnipfige uuseneh',
	'code-reference-associate' => 'Mit dr Folgerevision verchnipfe:',
	'code-reference-associate-submit' => 'Verchnipfe',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Depot:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'uf ViewVC',
	'code-rev-paths' => 'Gändereti Pfad:',
	'code-rev-modified-a' => 'zuegfiegt',
	'code-rev-modified-r' => 'ersetzt',
	'code-rev-modified-d' => 'glescht',
	'code-rev-modified-m' => 'gänderet',
	'code-rev-imagediff' => 'Bildänderige',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status ändere',
	'code-rev-tags' => 'Tag:',
	'code-rev-tag-add' => 'Ergänz Tag:',
	'code-rev-tag-remove' => 'Nimm Tag use:',
	'code-rev-comment-by' => 'Kommentar vu $1',
	'code-rev-comment-preview' => 'Vorschau',
	'code-rev-inline-preview' => 'Vorschau:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'Diff',
	'code-rev-diff-too-large' => 'Dr Unterschid isch z groß zum aazeigt wäre.',
	'code-rev-purge-link' => 'Cache lesche',
	'code-rev-total' => 'Gsamtergebniszahl: $1',
	'code-rev-not-found' => "Version '''$1''' git s nit!",
	'code-rev-history-link' => 'Versionsgschicht',
	'code-status-new' => 'nej',
	'code-status-desc-new' => 'D Version wartet uf e Aktion (Standardstatus).',
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => 'Die Bearbeitig verursacht en Softwarefääler oder isch defekt. Si sött entweder korrigiert oder ruggängig gmacht werde.',
	'code-status-reverted' => 'ruckgängig gmacht',
	'code-status-desc-reverted' => 'D Version isch dur e speteri Version ruckgängig gmacht wore.',
	'code-status-resolved' => 'gmacht',
	'code-status-desc-resolved' => 'D Version het e Probläm gha, wu in ere spetere Version korrigiert woren isch.',
	'code-status-ok' => 'In Ornig',
	'code-status-desc-ok' => 'D Version isch vollständig beguetachtet wore un dr Guetachter isch sicher, ass alles in Ornig isch.',
	'code-status-deferred' => 'zruckgstellt',
	'code-status-desc-deferred' => 'D Version brucht kei Beguetachtig.',
	'code-status-old' => 'alt',
	'code-status-desc-old' => 'Alti Version mit meglige Bug, wu aber nit derwärt sin, zum si beguetachte.',
	'code-signoffs' => 'Frejgabe',
	'code-signoff-legend' => 'Frejgab zuefiege',
	'code-signoff-submit' => 'Frejgee',
	'code-signoff-strike' => 'Uusgwehlti Frejgabe stryyche',
	'code-signoff-signoff' => 'Die Version frejgee:',
	'code-signoff-flag-inspected' => 'Prieft',
	'code-signoff-flag-tested' => 'Teschtet',
	'code-signoff-field-user' => 'Benutzer',
	'code-signoff-field-flag' => 'Fahne',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (gstriche $2)',
	'code-pathsearch-legend' => 'Suech no Revisione in däm Depot per Pfad',
	'code-pathsearch-path' => 'Pfad:',
	'code-pathsearch-filter' => 'Numme aazeige:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Filter ufruume',
	'code-rev-submit' => 'Änderige spychere',
	'code-rev-submit-next' => 'Spychere un zum nächschte wu nonig prieft isch',
	'code-rev-next' => 'Wyter zum näggste unerledigte',
	'code-batch-status' => 'Status ändere:',
	'code-batch-tags' => 'Tag ändere:',
	'codereview-batch-title' => 'Alli usgwehlte Versione ändere',
	'codereview-batch-submit' => 'Schicke',
	'code-releasenotes' => 'Frejgabvermerk',
	'code-release-legend' => 'Frejgabvermerk generiere',
	'code-release-startrev' => 'Priefig aafange:',
	'code-release-endrev' => 'Letschti Priefig:',
	'codereview-subtitle' => 'Fir $1',
	'codereview-reply-link' => 'Antwort gee',
	'codereview-overview-title' => 'Übersicht',
	'codereview-overview-desc' => 'E grafischi Übersicht vo derre Lischt aazeige',
	'codereview-email-subj' => '[$1 $2]: Neije Kommentar zuegfiegt',
	'codereview-email-body' => 'Benutzer „$1“ het $3 kommentiert:

Vollständigi URL: $2

Zämmefassig:

$5

Kommentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Änderige wu derno chemme',
	'codereview-email-body2' => 'Benutzer „$1“ het zue $2 Änderige wu derno chemme gmacht.

Volli URL fir Änderige wu derno chemme: $5
Zämmefassig:

$6

Volli URL: $3

Ibertragzämmefassig:

$4',
	'codereview-email-subj3' => '[$1 $2]: Versionsstatus gänderet',
	'codereview-email-body3' => 'Benutzer „$1“ het dr Status vu $2 gänderet.

Alte Status: $3
Neje Status: $4

Vollständigi URL: $5

Zämmefassig:

$6',
	'codereview-email-subj4' => '[$1 $2]: Neje Kommentar zuegfiegt un dr Versionsstatus gänderet',
	'codereview-email-body4' => 'Benutzer „$1“ het dr Status vu $2 gänderet.

Alte Status: $3
Neje Status: $4

Benutzer „$1“ het au ne Kommentar zue $2 zuegfiegt.

Vollständigi URL: $5

Zämmefassig:

$7

Kommentar:

$6',
	'code-stats' => 'Statischtike',
	'code-stats-header' => 'Statistik vum Repositorium „$1“',
	'code-stats-main' => 'Mit em Stand $1 {{PLURAL:$2|isch|sin}} vu [[Special:Code/$3/author|$4 {{PLURAL:$4|Autor|Autore}}]] $2 {{PLURAL:$2|Revision|Revisione}} im Repositorium durgfiert wore.',
	'code-stats-status-breakdown' => 'Aazahl vu dr Revisione je Staat',
	'code-stats-fixme-breakdown' => 'Uffschlisselig vu dr Revisione mit FIXME je Autor',
	'code-stats-fixme-breakdown-path' => 'Uffschlisselig vu dr Revisione mit FIXME je Pfad',
	'code-stats-fixme-path' => 'Revisione mit FIXMEs für Pfad: $1',
	'code-stats-new-breakdown' => 'Uffschlisselig vu dr neije Revisione je Autor',
	'code-stats-count' => 'Aazahl vu dr Revisione',
	'code-tooltip-withsummary' => 'r$1 [$2] vo $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] vo $3',
	'repoadmin' => 'Adminischtration vum Depot',
	'repoadmin-new-legend' => 'Nej Depot aalege',
	'repoadmin-new-label' => 'Name vum Depot:',
	'repoadmin-new-button' => 'Aalege',
	'repoadmin-edit-legend' => 'Änderige am Depot „$1“',
	'repoadmin-edit-path' => 'Pfad zum Repositorium:',
	'repoadmin-edit-bug' => 'Pfad zue Bugzilla:',
	'repoadmin-edit-view' => 'Pfad zue ViewVC:',
	'repoadmin-edit-button' => 'In Ornig',
	'repoadmin-edit-sucess' => 'S Depot „[[Special:Code/$1|$1]]“ isch mit Erfolg gänderet wore.',
	'repoadmin-nav' => 'Repositoriumsverwaltig',
	'right-repoadmin' => 'Code-Depots verwalte',
	'right-codereview-use' => 'Special:Code verwände',
	'right-codereview-add-tag' => 'Neiji Markierig zue dr Version zuefiege',
	'right-codereview-remove-tag' => 'Tag vu Revisione useneh',
	'right-codereview-post-comment' => 'Kommentar zue Revisione ergänze',
	'right-codereview-set-status' => 'Revisionsstatus ändere',
	'right-codereview-signoff' => 'Änderige frejgee',
	'right-codereview-link-user' => 'Autore uf Wiki-Benutzer vergleiche',
	'right-codereview-associate' => 'Verchnipfig zuefiege/uuseneh',
	'right-codereview-review-own' => 'Eigeni Revisione als in Ordnig oder erledigt markiere',
	'specialpages-group-developer' => 'Entwicklerwärchzyyg',
	'group-svnadmins' => 'SVN-Adminischtratore',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-Ammann|SVN-Amtsfrou}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-Adminischtratore',
);

/** Hausa (هَوُسَ) */
$messages['ha'] = array(
	'code-rev-message' => 'Bahasi:',
	'repoadmin-new-button' => 'Ƙirƙira',
);

/** Hakka (Hak-kâ-fa)
 * @author Hakka
 */
$messages['hak'] = array(
	'repoadmin-new-button' => 'Tshóng-kien',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'code' => 'סקירת קוד',
	'code-rev-title' => 'גרסה $1 – סקירת קוד',
	'code-comments' => 'הערות',
	'code-references' => 'גרסאות המשך',
	'code-referenced' => 'גרסאות בעלות גרסאות עוקבות',
	'code-change-status' => "שינה את ה'''מצב''' של גרסה $1",
	'code-change-tags' => "שינה את ה'''תגים''' של גרסה $1",
	'code-change-removed' => 'הוסר:',
	'code-change-added' => 'נוסף:',
	'code-old-status' => 'המצב הקודם',
	'code-new-status' => 'המצב החדש',
	'code-prop-changes' => 'יומן מצבים ותיוג',
	'codereview-desc' => '[[Special:Code|כלי סקירת קוד]] עם [[Special:RepoAdmin|תמיכה ב־Subversion]]',
	'code-no-repo' => 'לא הוגדר מאגר!',
	'code-create-repo' => 'לכו לדף [[Special:RepoAdmin|RepoAdmin]] ליצירת מאגר',
	'code-need-repoadmin-rights' => 'נחוצה הרשאת "מנהל מאגר" כדי ליצור מאגר',
	'code-need-group-with-rights' => 'אין שום קבוצה עם הרשאת מנהל מאגר. נא ליצור קבוצה כזו כדי להוסיף מאגר חדש.',
	'code-repo-not-found' => "המאגר '''$1''' לא קיים!",
	'code-load-diff' => 'טעינת השוואה בין הגרסאות…',
	'code-notes' => 'הערות אחרונות',
	'code-statuschanges' => 'שינויי מצב',
	'code-mycommits' => 'התרומות שלי',
	'code-mycomments' => 'ההערות שלי',
	'code-authors' => 'כותבים',
	'code-status' => 'מצבים',
	'code-tags' => 'תגים',
	'code-tags-no-tags' => 'לא קיימים תגים במאגר הזה.',
	'code-authors-text' => 'להלן רשימת הכותבים במאגר לפי סדר שמות התרומות. חשבונות באתר הוויקי המקומי מופיעים בסוגריים. המידע יכול להיות מוטמן.',
	'code-author-haslink' => 'כותב זה מקושר למשתמש הוויקי $1',
	'code-author-orphan' => 'משתמש ה־SVN או המחבר הזה אינו מקושר לחשבון בוויקי',
	'code-author-dolink' => 'קישור כותב זה למשתמש ויקי:',
	'code-author-alterlink' => 'שינוי משתמש הוויקי המקושר לכותב זה:',
	'code-author-orunlink' => 'או ביטול הקישור למשתמש זה בוויקי:',
	'code-author-name' => 'הקלידו שם משתמש:',
	'code-author-success' => 'הכותב $1 קוּשָּׁר בהצלחה למשתמש הוויקי $2',
	'code-author-link' => 'לקשר?',
	'code-author-unlink' => 'לבטל קישור?',
	'code-author-unlinksuccess' => 'הקישור של הכותב $1 בוטל',
	'code-author-badtoken' => 'שגיאת התחברות בעת הניסיון לביצוע פעולה זו.',
	'code-author-total' => 'מספר סך כל הכותבים: $1',
	'code-author-lastcommit' => 'תאריך השינוי האחרון',
	'code-browsing-path' => "עיון בגרסאות תחת '''$1'''",
	'code-field-id' => 'גרסה',
	'code-field-author' => 'כותב',
	'code-field-user' => 'מגיב',
	'code-field-message' => 'תקציר השינוי',
	'code-field-status' => 'מצב',
	'code-field-status-description' => 'תיאור המצב',
	'code-field-timestamp' => 'תאריך',
	'code-field-comments' => 'הערות',
	'code-field-path' => 'נתיב',
	'code-field-text' => 'הערה',
	'code-field-select' => 'בחירה',
	'code-reference-remove' => 'הסרת השיוכים הנבחרים',
	'code-reference-associate' => 'שיוך גרסה עוקבת:',
	'code-reference-associate-submit' => 'שיוך',
	'code-rev-author' => 'כותב:',
	'code-rev-date' => 'תאריך:',
	'code-rev-message' => 'הערה:',
	'code-rev-repo' => 'מאגר:',
	'code-rev-rev' => 'גרסה:',
	'code-rev-rev-viewvc' => 'ב־ViewVC',
	'code-rev-paths' => 'נתיבים ששונו:',
	'code-rev-modified-a' => 'נוסף',
	'code-rev-modified-r' => 'הוחלף',
	'code-rev-modified-d' => 'נמחק',
	'code-rev-modified-m' => 'שׁוּנָּה',
	'code-rev-imagediff' => 'שינויים בתמונות',
	'code-rev-status' => 'מצב:',
	'code-rev-status-set' => 'שינוי מצב',
	'code-rev-tags' => 'תגים:',
	'code-rev-tag-add' => 'הוספת תגים:',
	'code-rev-tag-remove' => 'הסרת תגים:',
	'code-rev-comment-by' => 'הערה של $1',
	'code-rev-comment-preview' => 'תצוגה מקדימה',
	'code-rev-inline-preview' => 'תצוגה מקדימה:',
	'code-rev-diff' => 'השוואה בין גרסאות',
	'code-rev-diff-link' => 'השוואה',
	'code-rev-diff-too-large' => 'קובץ ההשוואה גדול מדי להצגה.',
	'code-rev-purge-link' => 'ניקוי מטמון',
	'code-rev-total' => 'סך כל התוצאות: $1',
	'code-rev-not-found' => "הגרסה '''$1''' אינה קיימת!",
	'code-rev-history-link' => 'היסטוריה',
	'code-status-new' => 'חדשה',
	'code-status-desc-new' => 'הגרסה ממתינה לפעולה (מצב בררת המחדל).',
	'code-status-fixme' => 'לתיקון',
	'code-status-desc-fixme' => 'בגרסה הזאת נוצר באג או שהיא מקולקלת. יש לתקן או לבטל אותה.',
	'code-status-reverted' => 'בוטלה',
	'code-status-desc-reverted' => 'גרסה חדשה יותר דרסה את הגרסה הזאת.',
	'code-status-resolved' => 'תוקנה',
	'code-status-desc-resolved' => 'בגרסה הופיעה בעיה שנפתרה בגרסה מאוחרת יותר.',
	'code-status-ok' => 'אושרה',
	'code-status-desc-ok' => 'הגרסה נסקרה במלואה והסוקר בטוח שהיא בסדר מכל בחינה.',
	'code-status-deferred' => 'לא לטיפול',
	'code-status-desc-deferred' => 'אין צורך לסקור את הגרסה.',
	'code-status-old' => 'ישנה',
	'code-status-desc-old' => 'גרסה ישנה שאולי יש בה תקלות, אבל חבל להשקיע מאמץ בסקירתן.',
	'code-signoffs' => 'חתימות',
	'code-signoff-legend' => 'הוספת חתימה',
	'code-signoff-submit' => 'חתימה',
	'code-signoff-strike' => 'סימון החתימות הנבחרות בקו חוצה',
	'code-signoff-signoff' => 'לחתום על גרסה זו ולסמן שהיא:',
	'code-signoff-flag-inspected' => 'נבחנה',
	'code-signoff-flag-tested' => 'נבדקה',
	'code-signoff-field-user' => 'משתמש',
	'code-signoff-field-flag' => 'דגלון',
	'code-signoff-field-date' => 'תאריך',
	'code-signoff-struckdate' => '$1 (סומן בקו חוצה ב־$2)',
	'code-pathsearch-legend' => 'חיפוש גרסאות במאגר זה לפי נתיב',
	'code-pathsearch-path' => 'נתיב:',
	'code-pathsearch-filter' => 'להציג רק:',
	'code-revfilter-cr_status' => 'מצב = $1',
	'code-revfilter-cr_author' => 'כותב = $1',
	'code-revfilter-ct_tag' => 'תג = $1',
	'code-revfilter-clear' => 'ניקוי המסנן',
	'code-rev-submit' => 'שמירת השינויים',
	'code-rev-submit-next' => 'שמירה ומעבר לגרסה הבאה שלא תוקנה',
	'code-rev-next' => 'הגרסה הבאה שלא תוקנה',
	'code-batch-status' => 'שינוי מצב:',
	'code-batch-tags' => 'שינוי תגים:',
	'codereview-batch-title' => 'שינוי כל הגרסאות שנבחרו',
	'codereview-batch-submit' => 'שליחה',
	'code-releasenotes' => 'הערות גרסה',
	'code-release-legend' => 'יצירת הערות גרסה',
	'code-release-startrev' => 'גרסת התחלה:',
	'code-release-endrev' => 'גרסה אחרונה:',
	'codereview-subtitle' => 'עבור $1',
	'codereview-reply-link' => 'תגובה',
	'codereview-overview-title' => 'סקירה כללית',
	'codereview-overview-desc' => 'הצגת סקירה כללית גרפית של הרשימה הזאת',
	'codereview-email-subj' => '[$1] [גרסה $2]: נוספה הערה חדשה',
	'codereview-email-body' => 'המשתמש "$1" פרסם הערה בגרסה $3.

הכתובת המלאה: $2
תקציר השינוי:

$5

ההערה:

$4',
	'codereview-email-subj2' => '[$1] [גרסה $2]: גרסאות המשך',
	'codereview-email-body2' => 'המשתמש "$1" הוסיף גרסאות המשך לגרסה $2.

הכתובת המלאה לגרסת ההמשך: $5.
תקציר השינוי:

$6

הכתובת המלאה: $3
תקציר השינוי:

$4',
	'codereview-email-subj3' => '[$1 $2]: מצב הגרסה השתנה',
	'codereview-email-body3' => 'המשתמש "$1" שינה את המצב של גרסה $2.

מצב קודם: $3
מצב חדש: $4

כתובת מלאה: $5
תקציר השינוי:

$6',
	'codereview-email-subj4' => '[$1 $2]: נוספה הערה חדשה ומצב הגרסה השתנה',
	'codereview-email-body4' => 'המשתמש "$1" החליף את המצב של גרסה $2.

המצב הישן: $3
המצב החדש: $4

המשתמש "$1" גם הגיב על $2.

הכתובת המלאה: $5
תקציר השינוי:

$7

הערה:

$6',
	'code-stats' => 'סטטיסטיקה',
	'code-stats-header' => 'סטטיסטיקה עבור המאגר $1',
	'code-stats-main' => 'נכון ל־$1, למאגר יש {{PLURAL:$2|גרסה אחת|$2 גרסאות}} מאת [[Special:Code/$3/author|{{PLURAL:$4|כותב אחד|$4 כותבים}}]].',
	'code-stats-status-breakdown' => 'מספר הגרסאות למצב',
	'code-stats-fixme-breakdown' => 'מיון של גרסאות לתיקון לפי מחבר',
	'code-stats-fixme-breakdown-path' => 'מיון של גרסאות לתיקון לפי נתיב',
	'code-stats-fixme-path' => 'גרסאות לתיקון לנתיב: $1',
	'code-stats-new-breakdown' => 'מיון של גרסאות חדשות לפי מחבר',
	'code-stats-new-breakdown-path' => 'התפלגות של גרסאות חדשות לפי נתיב',
	'code-stats-new-path' => 'גרסאות חדשות לנתיב: $1',
	'code-stats-count' => 'מספר הגרסאות',
	'code-tooltip-withsummary' => '<span dir="ltr">r$1</span>‏ [$2] מאת ‏$3 – $4',
	'code-tooltip-withoutsummary' => '<span dir="ltr">r$1</span>‏ [$2] מאת ‏$3',
	'repoadmin' => 'ניהול מאגרים',
	'repoadmin-new-legend' => 'יצירת מאגר חדש',
	'repoadmin-new-label' => 'שם המאגר:',
	'repoadmin-new-button' => 'יצירה',
	'repoadmin-edit-legend' => 'שינוי המאגר "$1"',
	'repoadmin-edit-path' => 'נתיב למאגר:',
	'repoadmin-edit-bug' => 'נתיב ל־Bugzilla:',
	'repoadmin-edit-view' => 'נתיב ל־ViewVC:',
	'repoadmin-edit-button' => 'אישור',
	'repoadmin-edit-sucess' => 'המאגר "[[Special:Code/$1|$1]]" שונה בהצלחה.',
	'repoadmin-nav' => 'ניהול מאגרים',
	'right-repoadmin' => 'ניהול מאגרי קוד',
	'right-codereview-use' => 'שימוש בדף המיוחד Code',
	'right-codereview-add-tag' => 'הוספת תגים חדשים לגרסאות',
	'right-codereview-remove-tag' => 'הסרת תגים מגרסאות',
	'right-codereview-post-comment' => 'הוסף הערות לגרסאות',
	'right-codereview-set-status' => 'שינוי מצב הגרסאות',
	'right-codereview-signoff' => 'חתימה על גרסאות',
	'right-codereview-link-user' => 'קישור הכותבים למשתמשי ויקי',
	'right-codereview-associate' => 'ניהול שיוכי גרסה',
	'right-codereview-review-own' => 'לסמן את הגרסאות שלך כ"{{int:code-status-ok}}" או מ"{{int:code-status-resolved}}"',
	'action-repoadmin' => 'לנהל מאגרי קוד',
	'action-codereview-use' => 'שימוש בדף Special:Code',
	'action-codereview-add-tag' => 'להוסיף תגים חדשים לגרסאות',
	'action-codereview-remove-tag' => 'להסיר תגים מגרסאות',
	'action-codereview-post-comment' => 'להוסיף הערות לגרסאות',
	'action-codereview-set-status' => 'לשנות מצבי גרסאות',
	'action-codereview-signoff' => 'לחתום על גרסאות',
	'action-codereview-link-user' => 'לקשר כותבים לחשבונות בוויקי',
	'action-codereview-associate' => 'לנהל שיוכי גרסאות',
	'action-codereview-review-own' => 'לסמן את הגרסאות של עצמכם "{{int:code-status-ok}} או "{{int:code-status-resolved}}"',
	'specialpages-group-developer' => 'כלי פיתוח',
	'group-svnadmins' => 'מנהלי שרת SVN',
	'group-svnadmins-member' => '{{GENDER:$1|מנהל|מנהלת}} שרת SVN',
	'grouppage-svnadmins' => '{{ns:project}}:מנהלי שרת SVN',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 */
$messages['hi'] = array(
	'code' => 'कोड़ समीक्षा',
	'code-rev-title' => '$1 - कोड़ समीक्षा',
	'code-comments' => 'टिप्पणियाँ',
	'code-references' => 'अनुवर्ती संशोधन',
	'code-change-status' => "$1 की '''स्थिति''' बदला गया",
	'code-change-tags' => "बदला गया '''टैगस''' $1 के लिए",
	'code-change-removed' => 'हटाया गया:',
	'code-change-added' => 'जोड़ा गया:',
	'code-old-status' => 'पुरानी स्थिति',
	'code-new-status' => 'नई स्थिति',
	'code-prop-changes' => 'स्थिति और लॉग टैगिंग',
	'codereview-desc' => '[[Special:Code|कोड़ समीक्षा उपकरण]] सहित [[Special:रेपोप्रबन्धक|उपसंस्करण समर्थन]]',
	'code-no-repo' => 'कोई भंडार कॉन्फ़िगर नहीं किया गया!',
	'code-create-repo' => '[[Special:RepoAdmin|रेपोएडमिन]] को जाएँ भंडार निर्माण के लिए',
	'code-repo-not-found' => "भंडार '''$1''' मौजूद नहीं है!",
	'code-load-diff' => 'लोडिंग अंतर...',
	'code-notes' => 'हालही की टिप्पणियाँ',
	'code-statuschanges' => 'स्थिति परिवर्तन',
	'code-mycommits' => 'मेरी सच्चा प्रयास',
	'code-mycomments' => 'मेरी टिप्पणियाँ',
	'code-authors' => 'लेखक',
	'code-status' => 'राज्य',
	'code-tags' => 'टैग',
	'code-tags-no-tags' => 'इस भंडार में कोई टैग मौजूद नहीं ।',
	'code-author-haslink' => 'इस लेखक ये विकि सदस्य $1 से जोड़ें हैं',
	'code-author-dolink' => 'इस लेखक को किसी विकि सदस्य से जोड़ें:',
	'code-author-alterlink' => 'लेखक और विकि सदस्य की लिंक को बदलें :',
	'code-author-orunlink' => 'या इस विकि सदस्य को अनलिंक करें:',
	'code-author-name' => 'सदस्य के नाम दर्ज करें:',
	'code-author-link' => 'लिंक?',
	'code-author-unlink' => 'अनलिंक ?',
	'code-author-unlinksuccess' => 'लेखक  $1 को उनलिंक करागया',
	'code-author-total' => 'लेखकों की कुल संख्या: $1',
	'code-author-lastcommit' => 'अंतिम प्रतिबद्ध तारीख',
	'code-browsing-path' => "संशोधित ब्राउज़िंग '''$1''' में",
	'code-field-id' => 'संशोधन',
	'code-field-author' => 'लेखक',
	'code-field-user' => 'टिप्पणीकार',
	'code-field-message' => 'सारांश कमिट',
	'code-field-status' => 'स्थिति',
	'code-field-status-description' => 'स्थिति का वर्णन',
	'code-field-timestamp' => 'दिनांक',
	'code-field-comments' => 'टिप्पणियाँ',
	'code-field-path' => 'मार्ग',
	'code-field-text' => 'नोट',
	'code-field-select' => 'चयन करें',
	'code-reference-associate-submit' => 'सहयोगी',
	'code-rev-author' => 'लेखक:',
	'code-rev-date' => 'दिनांक:',
	'code-rev-message' => 'टिप्पणी:',
	'code-rev-repo' => 'भंडार:',
	'code-rev-rev' => 'संशोधन:',
	'code-rev-modified-a' => 'जोड़ा गया',
	'code-rev-modified-r' => 'बदला गया',
	'code-rev-modified-d' => 'हटाया गया',
	'code-rev-modified-m' => 'संशोधित',
	'code-rev-imagediff' => 'छवि बदलाव',
	'code-rev-status' => 'स्थिति:',
	'code-rev-status-set' => 'स्थिति परिवर्तन',
	'code-rev-tags' => 'टैग:',
	'code-rev-tag-add' => 'टैग जोड़ें:',
	'code-rev-tag-remove' => 'टैग निकालें:',
	'code-rev-comment-by' => 'द्वारा टिप्पणी $1',
	'code-rev-comment-preview' => 'पूर्वावलोकन',
	'code-rev-inline-preview' => 'पूर्वावलोकन:',
	'code-rev-diff' => 'अन्तर',
	'code-rev-diff-link' => 'अन्तर',
	'code-rev-diff-too-large' => 'अंतर बहत बड़ा है दिखाने के लिए ।',
	'code-rev-purge-link' => 'पर्ज करें',
	'code-rev-total' => 'परिणामों की कुल संख्या: $1',
	'code-rev-history-link' => 'इतिहास',
	'code-status-new' => 'नई',
	'code-status-reverted' => 'पूर्ववत करा गया',
	'code-status-resolved' => 'संशोधित हुई',
	'code-status-ok' => 'ठीक है',
	'code-status-deferred' => 'टालना',
	'code-status-desc-deferred' => 'संशोधन में समिक्षा की आबशयकता नहीं है ।',
	'code-status-old' => 'पुराना',
	'code-signoffs' => 'साइन ऑफ',
	'code-signoff-legend' => 'साइन ऑफ जोड़ें',
	'code-signoff-submit' => 'साइन ऑफ',
	'code-signoff-flag-inspected' => 'निरीक्षण किया',
	'code-signoff-flag-tested' => 'परीक्षण किया',
	'code-signoff-field-user' => 'सदस्य',
	'code-signoff-field-flag' => 'फ्लाग',
	'code-signoff-field-date' => 'दिनांक',
	'code-signoff-struckdate' => '$1 (मारा  $2 )',
	'code-pathsearch-path' => 'मार्ग:',
	'code-pathsearch-filter' => 'केवल दिखाएँ:',
	'code-revfilter-cr_status' => 'स्थिति = $1',
	'code-revfilter-cr_author' => 'लेखक = $1',
	'code-revfilter-ct_tag' => 'टैग = $1',
	'code-revfilter-clear' => 'फ़िल्टर खाली करें',
	'code-rev-submit' => 'बदलाव सहेजें',
	'code-batch-status' => 'स्थिति बदलें:',
	'code-batch-tags' => 'टैग बदले:',
	'codereview-batch-title' => 'सभी चयनित संशोधन परिवर्तित करें',
	'codereview-batch-submit' => 'जमा करें',
	'code-releasenotes' => 'रिलीज नोट्स',
	'code-release-legend' => 'रिलीज नोट्स उत्पन्न',
	'code-release-startrev' => 'आरंभ संशोधन:',
	'code-release-endrev' => 'पिछले संशोधन:',
	'codereview-subtitle' => '$1 के लिये',
	'codereview-reply-link' => 'उत्तर दें',
	'codereview-overview-title' => 'अवलोकन',
	'codereview-overview-desc' => 'इस सूची का एक आलेखी अवलोकन दिखाएँ',
	'codereview-email-subj' => '[$1  $2]: नई टिप्पणी जोड़ा गया',
	'codereview-email-subj2' => '[$1  $2]: अनुवर्ती परिवर्तन',
	'codereview-email-subj3' => '[$1  $2]: संशोधन स्थिति बदल गया है',
	'codereview-email-subj4' => '[$1  $2]: नई टिप्पणी जोड़ दिया है, और संशोधन की स्थिति बदला गया है',
	'codereview-email-body4' => '"$1" ने $2 की स्थिति "$4" को बदल दी और टिप्पणी दी ।
URL: $5

पुरानी स्थिति: $3
नया स्थिति: $4

प्रतिबद्ध सारांश  $2: के लिए

$7

$1\'s टिप्पणी:

$6',
	'code-stats' => 'आँकड़े',
	'code-stats-header' => 'भंडार के लिए आँकड़े $1',
	'code-stats-main' => 'जहां तक $1, भंडार में $2 {{PLURAL:$2|संशोधन|संशोधन}} के द्वारा [[Special:Code/$3/author|$4 {{PLURAL:$4|लेखक|लेखक}}]] ।',
	'code-stats-status-breakdown' => 'राज्य प्रति संशोधनों की संख्या',
	'code-stats-new-path' => 'नई संशोधन के लिए पथ: $1',
	'code-stats-count' => 'संशोधन की संख्या',
	'code-tooltip-withsummary' => 'r$1 [$2] द्वारा $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] द्वारा $3',
	'repoadmin' => 'भंडार प्रशासन',
	'repoadmin-new-legend' => 'एक नया भंडार बनाएँ',
	'repoadmin-new-label' => 'भंडार नाम:',
	'repoadmin-new-button' => 'बनाएँ',
	'repoadmin-edit-legend' => 'भंडार "$1" की संशोधन',
	'repoadmin-edit-path' => 'भंडार मार्ग:',
	'repoadmin-edit-bug' => 'बगजिला मार्ग:',
	'repoadmin-edit-view' => 'VC मार्ग: देखें',
	'repoadmin-edit-button' => 'ठीक है',
	'repoadmin-nav' => 'भंडार प्रशासन',
	'right-repoadmin' => 'कोड खजाने को प्रबंध करें',
	'right-codereview-use' => 'विशेष:कोड का उपयोग',
	'right-codereview-add-tag' => 'संशोधन में नया टैग जोड़ें',
	'right-codereview-remove-tag' => 'संशोधन से टैग हटाएँ',
	'right-codereview-post-comment' => 'संशोधन पे टिप्पणी जोड़ें',
	'right-codereview-set-status' => 'संशोधन की स्थिति परिवर्तित करें',
	'right-codereview-signoff' => 'संशोधन से साइन अफ़ हो जाएँ',
	'right-codereview-link-user' => 'लेखकों को विकि सदस्यों से लिंक करें',
	'right-codereview-associate' => 'संशोधन संघ को प्रबंधन करें',
	'right-codereview-review-own' => 'अपना संशोधन को ठीक है या संकल्प की रूप में चिन्हित करें',
	'specialpages-group-developer' => 'डेवलपर उपकरण',
	'group-svnadmins' => 'SVN प्रबन्धकगण',
	'group-svnadmins-member' => '{{GENDER:$1|SVN प्रबन्धक}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN प्रबन्धकगण',
);

/** Fiji Hindi (Latin script) (Fiji Hindi)
 * @author Thakurji
 */
$messages['hif-latn'] = array(
	'code-change-removed' => 'hatae dewa gais hai',
	'code-change-added' => 'jorr dewa gais hai:',
	'repoadmin-new-button' => 'Banao',
);

/** Croatian (Hrvatski)
 * @author CERminator
 * @author Dalibor Bosits
 * @author Ex13
 * @author Herr Mlinka
 * @author Roberta F.
 * @author SpeedyGonsales
 */
$messages['hr'] = array(
	'code' => 'Pregled koda',
	'code-rev-title' => '$1 - Pregled kôda',
	'code-comments' => 'Komentari',
	'code-references' => 'Naknadne revizije',
	'code-change-status' => "promijenjen '''status''' za reviziju $1",
	'code-change-tags' => "promijenjene '''oznake''' za reviziju $1",
	'code-change-removed' => 'uklonjeno:',
	'code-change-added' => 'dodano:',
	'code-old-status' => 'Stari status',
	'code-new-status' => 'Novi status',
	'code-prop-changes' => 'Evidencija statusa i označavanja',
	'codereview-desc' => '[[Special:Code|Alat za pregled koda]] s podrškom za [[Special:RepoAdmin|Subversion]]',
	'code-no-repo' => 'Nema konfiguracije repozitorija!',
	'code-create-repo' => 'Idi na [[Special:RepoAdmin|RepoAdmin]] kako bi kreirao repozitorij',
	'code-need-repoadmin-rights' => 'repoadmin prava su potrebna kako bi mogli kreirati repozitorij',
	'code-need-group-with-rights' => 'Niti jedna skupina s repoadmin pravima ne postoji. Molimo vas, dodajte barem jednu takvu skupinu kako biste mogli dodati novi repozitorij',
	'code-repo-not-found' => "Repozitorij '''$1''' ne postoji!",
	'code-load-diff' => 'Učitavam razliku...',
	'code-notes' => 'nedavni komentari',
	'code-statuschanges' => 'izmjene stanja',
	'code-mycommits' => 'moje publikacije',
	'code-mycomments' => 'moji komentari',
	'code-authors' => 'autori',
	'code-status' => 'statusi',
	'code-tags' => 'oznake',
	'code-tags-no-tags' => 'Ne postoje oznake u ovom repozitoriju.',
	'code-authors-text' => 'Ispod je popis autora repozitorija poredanih po imenima. Lokalni wiki računi prikazani su u zagradama. Podaci mogu biti iz spremnika, te time neosvježeni.',
	'code-author-haslink' => 'Ovaj autor je povezan s wiki suradnikom $1',
	'code-author-orphan' => 'Ovaj autor nema poveznicu s wiki računom',
	'code-author-dolink' => 'Poveži ovog autora na wiki suradnika:',
	'code-author-alterlink' => 'Promijeni povezanog wiki suradnika za ovog autora:',
	'code-author-orunlink' => 'Ili ukloni poveznicu za ovog wiki suradnika:',
	'code-author-name' => 'Upišite suradničko ime:',
	'code-author-success' => 'Autor $1 je povezan na wiki suradnika $2',
	'code-author-link' => 'poveznica?',
	'code-author-unlink' => 'ukloniti poveznicu?',
	'code-author-unlinksuccess' => 'Uklonjena poveznica za autora $1',
	'code-author-badtoken' => 'Pogreška sesije pri pokušaju izvršavanje akcije.',
	'code-author-total' => 'Ukupan broj autora: $1',
	'code-author-lastcommit' => "Datum zadnje transakcije (''commita'' na projekt)",
	'code-browsing-path' => "Pregledavanje revizija u '''$1'''",
	'code-field-id' => 'Izmjena',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Komentator',
	'code-field-message' => 'Sažetak predaje',
	'code-field-status' => 'Stanje',
	'code-field-status-description' => 'Opis stanja/statusa',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Bilješke',
	'code-field-path' => 'Putanja',
	'code-field-text' => 'Bilješka',
	'code-field-select' => 'Odaberi',
	'code-reference-remove' => 'Ukloni odabrana povezivanja',
	'code-reference-associate' => 'Povezane praćene revizije:',
	'code-reference-associate-submit' => 'Poveži',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Komentar:',
	'code-rev-repo' => 'Repozitorij:',
	'code-rev-rev' => 'Izmjena:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Promijenjene putanje:',
	'code-rev-modified-a' => 'dodano',
	'code-rev-modified-r' => 'zamijenjeno',
	'code-rev-modified-d' => 'izbrisano',
	'code-rev-modified-m' => 'promijenjeno',
	'code-rev-imagediff' => 'Promjene slike',
	'code-rev-status' => 'Stanje:',
	'code-rev-status-set' => 'Promijeni stanje',
	'code-rev-tags' => 'Oznake:',
	'code-rev-tag-add' => 'Dodaj oznake:',
	'code-rev-tag-remove' => 'Ukloni oznake:',
	'code-rev-comment-by' => 'Komentirao $1',
	'code-rev-comment-preview' => 'Pregled',
	'code-rev-inline-preview' => 'Pregled:',
	'code-rev-diff' => 'Raz',
	'code-rev-diff-link' => 'raz',
	'code-rev-diff-too-large' => 'Razlika je prevelika za prikaz.',
	'code-rev-purge-link' => 'očisti',
	'code-rev-total' => 'Ukupan broj rezultata: $1',
	'code-rev-not-found' => "Revizija '''$1''' ne postoji!",
	'code-status-new' => 'novo',
	'code-status-desc-new' => 'Revizija očekuje akciju (osnovno stanje).',
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => 'Provjerivač je označio ovu reviziju kao uzrok greške ili je neispravna. To valja ispraviti.',
	'code-status-reverted' => 'uklonjen',
	'code-status-desc-reverted' => 'Revizija je odbačena od neke kasnije revizije.',
	'code-status-resolved' => 'riješeno',
	'code-status-desc-resolved' => 'Revizija je imala problem koji je riješen kasnijom revizijom.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revizija je potpuno pregledana, provjerivač je siguran da je po njegovom mišljenju sve u redu.',
	'code-status-deferred' => 'odgođeno',
	'code-status-desc-deferred' => 'Revizija ne zahtijeva pregled.',
	'code-status-old' => 'staro',
	'code-status-desc-old' => 'Stara revizija s mogućim greškama koje nisu vrijedne truda za njihovu provjeru.',
	'code-signoffs' => 'Završetci',
	'code-signoff-legend' => 'Dodaj završetak',
	'code-signoff-submit' => 'Odjavi se',
	'code-signoff-strike' => 'Precrtaj odabrana odobrenja',
	'code-signoff-signoff' => 'Odobri ovu reviziju kao:',
	'code-signoff-flag-inspected' => 'Ispitano',
	'code-signoff-flag-tested' => 'Testirano',
	'code-signoff-field-user' => 'Suradnik',
	'code-signoff-field-flag' => 'Zastavica',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (poništeno $2)',
	'code-pathsearch-legend' => 'Traži izmjene u ovom repozitoriju preko putanje',
	'code-pathsearch-path' => 'Putanja:',
	'code-pathsearch-filter' => 'Primijenjen filtar:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-clear' => 'Očisti filtar',
	'code-rev-submit' => 'Spremi izmjene',
	'code-rev-submit-next' => 'Spremi i sljedeće neriješeno',
	'code-batch-status' => 'Promijeni status:',
	'code-batch-tags' => "Promijeni oznake (''tagove''):",
	'codereview-batch-title' => 'Promijeni sve odabrane izmjene',
	'codereview-batch-submit' => 'Pošalji',
	'code-releasenotes' => 'bilješke uz izdanje',
	'code-release-legend' => 'Kreiraj bilješke uz izdanje',
	'code-release-startrev' => 'Početna revizija:',
	'code-release-endrev' => 'Posljednja revizija:',
	'codereview-subtitle' => 'Za $1',
	'codereview-reply-link' => 'odgovori',
	'codereview-email-subj' => '[$1 $2]: Dodan novi komentar',
	'codereview-email-body' => 'Suradnik "$1" je ostavio komentar za $3.

Puni URL: $2

Komentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Sljedeće izmjene',
	'codereview-email-body2' => 'Suradnik "$1" izvršio je povezane izmjene na $2.

Puni URL za povezane revizije: $5

Puni URL: $3

Napravljeni sažetak:

$4',
	'codereview-email-subj3' => '[$1 $2]: Promjena stanja revizije',
	'codereview-email-body3' => 'Suradnik "$1" promijenio je status $2.

Stari status: $3
Novi status: $4

Potpuni URL: $5
Commit summary:

$6',
	'codereview-email-subj4' => '[$1 $2]: Dodan je novi komentar i promijenjeno je stanje revizije',
	'codereview-email-body4' => 'Suradnik "$1"  je promijenio stanje $2.

Staro stanje: $3
Novo stanje: $4

Suradnik "$1" je postavio i komentar na $2.

Puni URL: $5

Komentar:

$6',
	'code-stats' => 'statistike',
	'code-stats-header' => 'Statistike za repozitorij $1',
	'code-stats-main' => 'Sa stanjem od $1, repozitorij je imao $2 {{PLURAL:$2|reviziju|revizije|revizija}} od strane [[Special:Code/$3/author|$4 {{PLURAL:$4|autora|autora|autora}}]].',
	'code-stats-status-breakdown' => 'Broj revizija po stanju',
	'code-stats-fixme-breakdown' => 'Analiza popravaka po autoru',
	'code-stats-count' => 'Broj revizija',
	'repoadmin' => 'Administracija repozitorija',
	'repoadmin-new-legend' => 'Napravi novi repozitorij',
	'repoadmin-new-label' => 'Naziv repozitorija:',
	'repoadmin-new-button' => 'Napravi',
	'repoadmin-edit-legend' => 'Preinake repozitorija "$1"',
	'repoadmin-edit-path' => 'Putanja repozitorija:',
	'repoadmin-edit-bug' => 'Putanja za Bugzillu:',
	'repoadmin-edit-view' => 'Putanja za ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Repozitorij "[[Special:Code/$1|$1]]" je uspješno preinačen.',
	'repoadmin-nav' => 'administracija repozitorija',
	'right-repoadmin' => 'Upravljanje kodom repozitorija',
	'right-codereview-use' => 'Uporaba Special:Code',
	'right-codereview-add-tag' => 'Dodavanje nove oznake za revizije',
	'right-codereview-remove-tag' => 'Uklanjanje oznake za revizije',
	'right-codereview-post-comment' => 'Dodavanje komentara na reviziju',
	'right-codereview-set-status' => 'Promijeni status revizije',
	'right-codereview-signoff' => 'Završi izmjene revizija',
	'right-codereview-link-user' => 'Povezivanje autora s wiki suradnikom',
	'specialpages-group-developer' => 'Alati za razvijatelje',
	'group-svnadmins' => 'SVN administratori',
	'group-svnadmins-member' => 'SVN administrator',
	'grouppage-svnadmins' => '{{ns:project}}:SVN administratori',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'code' => 'Kodowa kontrola',
	'code-rev-title' => '$1 - Přepruwowanje koda',
	'code-comments' => 'Komentary',
	'code-references' => 'Naslědne wersije',
	'code-referenced' => 'Slědowane wersije',
	'code-change-status' => "změni '''status''' wersije $1",
	'code-change-tags' => "změni '''taflički''' za wersiju $1",
	'code-change-removed' => 'wotstronjeny:',
	'code-change-added' => 'přidaty:',
	'code-old-status' => 'Stary status',
	'code-new-status' => 'Nowy status',
	'code-prop-changes' => 'Protokol wo statusu & tafličkach',
	'codereview-desc' => '[[Special:Code|Nastroj za kodowu kontrolu]] z [[Special:RepoAdmin|podpěru za Subversion]]',
	'code-no-repo' => 'Žadyn repozitorij konfigurowany',
	'code-create-repo' => 'Dźi k specialnej stronje [[Special:RepoAdmin|RepoAdmin]], zo by repozitorij załožił',
	'code-need-repoadmin-rights' => 'Prawa repoadmin su trěbne, zo by móhł repozitorij załožić',
	'code-need-group-with-rights' => 'Njeje žana skupina z prawami repoadmin. Prošu přidaj jednu, zo by móhł nowy repozitorij załožić',
	'code-repo-not-found' => "Repozitorij '''$1''' njeeksistuje!",
	'code-load-diff' => 'Rozdźěl so začituje...',
	'code-notes' => 'aktualne komentary',
	'code-statuschanges' => 'změny statusa',
	'code-mycommits' => 'moje přepodaća',
	'code-mycomments' => 'moje komentary',
	'code-authors' => 'awtorojo',
	'code-status' => 'statusy',
	'code-tags' => 'taflički',
	'code-tags-no-tags' => 'W tutym repozitoriju žane taflički njejsu.',
	'code-authors-text' => 'To je lisćina awtorow repozitorija sortěrowanych po mjenach. Lokalne wikikonta pokazuja so w spinkach. Daty móžeja z pufrowaka być.',
	'code-author-haslink' => 'Tutón awtor ma wotkaz na wikijoweho wužiwarja $1',
	'code-author-orphan' => 'SVN-wužiwar/Awtor $1 njeje z wikikontom zwjazany',
	'code-author-dolink' => 'Tutoho awtora z wikijowym wužiwarjom zwjazać:',
	'code-author-alterlink' => 'Wikijoweho wužiwarja změnić, kotryž ma wotkaz k tutomu awtorej:',
	'code-author-orunlink' => 'Abo tutoho wikijoweho wužiwarja wotwjazać:',
	'code-author-name' => 'Wužiwarske mjeno zapodać:',
	'code-author-success' => 'Awtor $1 je z wikijowym wužiwarjom $2 zwjazany',
	'code-author-link' => 'zwjazać?',
	'code-author-unlink' => 'wotwjazać?',
	'code-author-unlinksuccess' => 'Awtor $1 bu wotwjazany',
	'code-author-badtoken' => 'Posedźenski zmylk při pospyće, akciju wuwjesć.',
	'code-author-total' => 'Cyłkowna ličba awtorow: $1',
	'code-author-lastcommit' => 'Posledni přenošowanski datum',
	'code-browsing-path' => "Přepytuja so wersije w '''$1'''",
	'code-field-id' => 'Rewizija',
	'code-field-author' => 'Awtor',
	'code-field-user' => 'Komentator',
	'code-field-message' => 'Zjeće nahrać',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Statusowe wopisanje',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Komentary',
	'code-field-path' => 'Šćežka',
	'code-field-text' => 'Přispomnjenka',
	'code-field-select' => 'Wubrać',
	'code-reference-remove' => 'Wubrane zwiski wotstronić',
	'code-reference-associate' => 'Ze slědowacej wersiju zwjazać:',
	'code-reference-associate-submit' => 'Zwjazać',
	'code-rev-author' => 'Awtor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Komentar:',
	'code-rev-repo' => 'Repozitorij:',
	'code-rev-rev' => 'Rewizija:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Změnjene šćežki:',
	'code-rev-modified-a' => 'přidaty',
	'code-rev-modified-r' => 'narunany',
	'code-rev-modified-d' => 'wušmórnjeny',
	'code-rev-modified-m' => 'změnjeny',
	'code-rev-imagediff' => 'Wobrazowe změny',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status změnić',
	'code-rev-tags' => 'Taflički:',
	'code-rev-tag-add' => 'Taflički přidać:',
	'code-rev-tag-remove' => 'Taflički wotstronić:',
	'code-rev-comment-by' => 'Komentar wot $1',
	'code-rev-comment-preview' => 'Přehlad',
	'code-rev-inline-preview' => 'Přehlad:',
	'code-rev-diff' => 'Rozdźěl',
	'code-rev-diff-link' => 'rozdźěl',
	'code-rev-diff-too-large' => 'Rozdźěl je přewulki za zwobraznjenje.',
	'code-rev-purge-link' => 'Pufrowak wuprózdnić',
	'code-rev-total' => 'Cyłkowna ličba wuslědkow: $1',
	'code-rev-not-found' => "Wersija '''$1''' njeeksistuje!",
	'code-rev-history-link' => 'stawizny',
	'code-status-new' => 'nowy',
	'code-status-desc-new' => 'Wersija akciju wočakuje (standardny status)',
	'code-status-fixme' => 'porjedźić',
	'code-status-desc-fixme' => 'Wersija zawinowa  programowy zmylk abo je skóncowany. Wona měła so porjedźić abo cofnyć.',
	'code-status-reverted' => 'anulowany',
	'code-status-desc-reverted' => 'Wersija bu přez pozdźišu wersiju cofnjena.',
	'code-status-resolved' => 'sčinjeny',
	'code-status-desc-resolved' => 'Wersija měješe problem, kotryž je so hižo přez pozdźišu wersiju wobdźěłał.',
	'code-status-ok' => 'w porjadku',
	'code-status-desc-ok' => 'Wersija je so dospołnje přepruwował a posudźowar je sej wěsty, zo wona je w kóždym nastupanju w porjadku.',
	'code-status-deferred' => 'zadźerženy',
	'code-status-desc-deferred' => 'Wersija sej žanu přepruwowanje njewužaduje.',
	'code-status-old' => 'stary',
	'code-status-desc-old' => 'Stara wersija z potencielnymi programowymi zmylkami, kotrež njejsu prócy hódne je přepruwować.',
	'code-signoffs' => 'Dopušćenja',
	'code-signoff-legend' => 'Dopušćenje přidać',
	'code-signoff-submit' => 'Dopušćić',
	'code-signoff-strike' => 'Wubrane přizwolenja šmórnyć',
	'code-signoff-signoff' => 'Tutu wersiju dopušćić:',
	'code-signoff-flag-inspected' => 'Inspicěrowany',
	'code-signoff-flag-tested' => 'Testowany',
	'code-signoff-field-user' => 'Wužiwar',
	'code-signoff-field-flag' => 'Chorhojčka',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (je so $2 wušmórnyło)',
	'code-pathsearch-legend' => 'W tutym repozitoriju po šćežce pytać',
	'code-pathsearch-path' => 'Šćežka:',
	'code-pathsearch-filter' => 'Jenož pokazać:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Awtor = $1',
	'code-revfilter-ct_tag' => 'Značka = $1',
	'code-revfilter-clear' => 'Filter zhašeć',
	'code-rev-submit' => 'Změny składować',
	'code-rev-submit-next' => 'Składować & přichodny njekontrolowany',
	'code-rev-next' => 'Přichodny njesčinjeny',
	'code-batch-status' => 'Status změnić:',
	'code-batch-tags' => 'Taflički změnić:',
	'codereview-batch-title' => 'Wšě wubrane wersije změnić',
	'codereview-batch-submit' => 'Wotpósłać',
	'code-releasenotes' => 'Přispomnjenki wo wersiji',
	'code-release-legend' => 'Přispomnjenki wo wersiji wutworić',
	'code-release-startrev' => 'Prěnja wersija',
	'code-release-endrev' => 'Poslednja wersija:',
	'codereview-subtitle' => 'Za $1',
	'codereview-reply-link' => 'wotmołwić',
	'codereview-overview-title' => 'Přehlad',
	'codereview-overview-desc' => 'Grafiski přehlad tuteje lisćiny pokazać',
	'codereview-email-subj' => '[$1 $2]: Nowy komentar přidaty',
	'codereview-email-body' => 'Wužiwar "$1" je komentar wo $3 pósłał.

Dospołny URL: $2
Zjeće:

$5

Komentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Naslědne změny',
	'codereview-email-body2' => 'Wužiwar "$1" je naslědne změny k $2 činił.

Dospołny URL za naslědnu wersiju: $5
Zjeće:

$6

Dospołny URL: $3
Zjeće:

$4',
	'codereview-email-subj3' => '[$1 $2]: Wersijowy status je so změnił',
	'codereview-email-body3' => 'Wužiwar "$1" je status wot $2 změnił.


Stary status: $3
Nowy status: $4

Dospołny URL: $5
Zjeće:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nowy komentar přidaty, a status wersije je so změnił',
	'codereview-email-body4' => 'Wužiwar "$1" je status za $2 změnił.

Stary status: $3
Nowy status: $4

Wužiwar "$1" je tež dnja $2 komentar pósłał.

Dospołny URL: $5

Zjeće:

$7

Komentar:

$6',
	'code-stats' => 'Statistika',
	'code-stats-header' => 'Statistika repozitorija $1',
	'code-stats-main' => 'Wot $1 repozitorij ma $2 {{PLURAL:$2|wersiju|wersiji|wersije|wersijow}} wot [[Special:Code/$3/author|$4 {{PLURAL:$4|awtora|awtorow|awtorow|awtorow}}]].',
	'code-stats-status-breakdown' => 'Ličba wersijow na status',
	'code-stats-fixme-breakdown' => 'Zwobraznjenje korekturowych wersijow na awtora',
	'code-stats-fixme-breakdown-path' => 'Rozrjadowanje wersijow z FIXME na pućik',
	'code-stats-fixme-path' => 'Wersije z FIXME za pućik: $1',
	'code-stats-new-breakdown' => 'Rozrjadowanje nowych wersijow na awtora',
	'code-stats-new-breakdown-path' => 'Rozrjadowanje nowych wersijow na pućik',
	'code-stats-new-path' => 'Nowe wersije za pućik: $1',
	'code-stats-count' => 'Ličba wersijow',
	'code-tooltip-withsummary' => 'r$1 [$2] wot $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] wot $3',
	'repoadmin' => 'Administracija repozitorija',
	'repoadmin-new-legend' => 'Nowy repozitorij wutworić',
	'repoadmin-new-label' => 'Mjeno repozitorija:',
	'repoadmin-new-button' => 'Wutworić',
	'repoadmin-edit-legend' => 'Změnjenje repozitorija "$1"',
	'repoadmin-edit-path' => 'Šćežka repozitorija:',
	'repoadmin-edit-bug' => 'Šćežka k Bugzilla:',
	'repoadmin-edit-view' => 'Šćežka k ViewVC:',
	'repoadmin-edit-button' => 'W porjadku',
	'repoadmin-edit-sucess' => 'Repozitorij "[[Special:Code/$1|$1]]" bu wuspěšnje změnjeny.',
	'repoadmin-nav' => 'Administracija repozitorija',
	'right-repoadmin' => 'Kodowe repozitorije zrjadować',
	'right-codereview-use' => 'Special:Code wužiwać',
	'right-codereview-add-tag' => 'Nowe taflički rewizijam přidać',
	'right-codereview-remove-tag' => 'Taflički z rewizijow wotstronić',
	'right-codereview-post-comment' => 'Komentary wo rewizijach přidać',
	'right-codereview-set-status' => 'Status rewizijow změnić',
	'right-codereview-signoff' => 'Wersije dopušćić',
	'right-codereview-link-user' => 'Awtorow z wikijowymi wužiwarjemi zwjazać',
	'right-codereview-associate' => 'Wersijowe zwiski zrajdować',
	'right-codereview-review-own' => 'Swójske wersije jako "{{int:code-status-ok}}" abo "{{int:code-status-resolved}}" markěrować',
	'action-repoadmin' => 'kodowe repozitorije zrjadować',
	'action-codereview-use' => 'Special:Code wužiwać',
	'action-codereview-add-tag' => 'nowe taflički rewizijam přidać',
	'action-codereview-remove-tag' => 'taflički z rewizijow wotstronić',
	'action-codereview-post-comment' => 'komentary wo rewizijach přidać',
	'action-codereview-set-status' => 'status rewizijow změnić',
	'action-codereview-signoff' => 'wersije dopušćić',
	'action-codereview-link-user' => 'awtorow z wikiwužiwarjemi zwjazać',
	'action-codereview-associate' => 'wersijowe zwiski zrjadować',
	'action-codereview-review-own' => 'swoje wersije jako "{{int:code-status-ok}} abo "{{int:code-status-resolved}}" markěrować',
	'specialpages-group-developer' => 'Nastroje wuwiwarjow',
	'group-svnadmins' => 'SVN-administratorojo',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-administrator|SVN-administratorka}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-administratorojo',
);

/** Haitian (Kreyòl ayisyen)
 * @author Boukman
 */
$messages['ht'] = array(
	'code-status-desc-reverted' => 'Revizyon sa te defè pa yon lòt revizyon ki te fèt pi ta',
);

/** Hungarian (Magyar)
 * @author Bináris
 * @author BáthoryPéter
 * @author Dani
 * @author Dj
 * @author Glanthor Reviol
 * @author Misibacsi
 */
$messages['hu'] = array(
	'code' => 'Kódellenőrzés',
	'code-rev-title' => '$1 - Kódellenőrzés',
	'code-comments' => 'Hozzászólások',
	'code-references' => 'Kapcsolódó későbbi változatok',
	'code-change-status' => "megváltoztatta az $1 változat '''állapotát'''",
	'code-change-tags' => "megváltoztatta az $1 változat '''címkéit'''",
	'code-change-removed' => 'eltávolítva:',
	'code-change-added' => 'hozzáadva:',
	'code-old-status' => 'Régi állapot',
	'code-new-status' => 'Új állapot',
	'code-prop-changes' => 'Állapot & címkézési napló',
	'codereview-desc' => '[[Special:Code|Kódellenőrző eszköz]] [[Special:RepoAdmin|Subversion-támogatással]]',
	'code-no-repo' => 'Nincs kódtárhely beállítva!',
	'code-create-repo' => 'Új tároló létrehozásához menj a [[Special:RepoAdmin|RepoAdmin]] lapra',
	'code-need-repoadmin-rights' => 'Tároló létrehozásához repoadmin jogosultság szükséges',
	'code-need-group-with-rights' => 'Nincs repoadmin jogosultsággal rendelkező csoport. Hozz létre egyet új tároló felvételéhez.',
	'code-repo-not-found' => "A(z) '''$1''' kódtárhely nem létezik!",
	'code-load-diff' => 'Változtatások betöltése...',
	'code-notes' => 'legutóbbi hozzászólások',
	'code-statuschanges' => 'állapotváltoztatások',
	'code-mycommits' => 'saját commitok',
	'code-mycomments' => 'saját megjegyzések',
	'code-authors' => 'szerzők',
	'code-status' => 'állapotok',
	'code-tags' => 'címkék',
	'code-tags-no-tags' => 'Nincs egyetlen címke sem ebben a tárolóban.',
	'code-authors-text' => 'Alább a tárhelyen műveleteket végző szerzők láthatóak a commitok neve szerint rendezve. A helyi, wikis fiókok zárójelben szerepelnek. Lehetséges, hogy az adatok a gyorsítótárból származnak.',
	'code-author-haslink' => 'Ez a szerző megegyezik a wiki $1 nevű szerkesztőjével',
	'code-author-orphan' => '$1 nevű SVN felhasználó/szerző nem rendelkezik felhasználói fiókkal ezen a wikin',
	'code-author-dolink' => 'Szerző összekapcsolása a wiki egyik szerkesztőjével:',
	'code-author-alterlink' => 'A szerzőhöz kapcsolt felhasználói fiók megváltoztatása:',
	'code-author-orunlink' => 'A szerkesztő leválasztása a szerzőről:',
	'code-author-name' => 'Adj meg egy felhasználói nevet:',
	'code-author-success' => '$1 össze lett kapcsolva a wiki $2 nevű szerkesztőjével',
	'code-author-link' => 'hozzátársítod?',
	'code-author-unlink' => 'megszünteted a társítást?',
	'code-author-unlinksuccess' => '$1 hozzátársítása megszüntetve',
	'code-author-badtoken' => 'A művelet végrehajtása közben munkamenet-probléma merült fel.',
	'code-author-total' => 'Összes szerző: $1',
	'code-author-lastcommit' => 'A legújabb commit ideje',
	'code-browsing-path' => "Változatok böngészése ebben: '''$1'''",
	'code-field-id' => 'Változat',
	'code-field-author' => 'Szerző',
	'code-field-user' => 'Hozzászóló',
	'code-field-message' => 'Összefoglaló',
	'code-field-status' => 'Állapot',
	'code-field-status-description' => 'Állapotleírás',
	'code-field-timestamp' => 'Időpont',
	'code-field-comments' => 'Hozzászólások',
	'code-field-path' => 'Elérési út',
	'code-field-text' => 'Megjegyzés',
	'code-field-select' => 'Kiválaszt',
	'code-reference-remove' => 'Kijelölt kapcsolatok eltávolítása',
	'code-reference-associate' => 'Kapcsolódó későbbi változat:',
	'code-reference-associate-submit' => 'Kapcsolódó',
	'code-rev-author' => 'Szerző:',
	'code-rev-date' => 'Dátum:',
	'code-rev-message' => 'Megjegyzés:',
	'code-rev-repo' => 'Kódtárhely:',
	'code-rev-rev' => 'Változat:',
	'code-rev-rev-viewvc' => 'a ViewVC-n',
	'code-rev-paths' => 'Módosított elemek:',
	'code-rev-modified-a' => 'hozzáadva',
	'code-rev-modified-r' => 'cserélve',
	'code-rev-modified-d' => 'törölve',
	'code-rev-modified-m' => 'módosítva',
	'code-rev-imagediff' => 'Képek változásai',
	'code-rev-status' => 'Állapot:',
	'code-rev-status-set' => 'Állapot módosítása',
	'code-rev-tags' => 'Címkék:',
	'code-rev-tag-add' => 'Címkék hozzáadása:',
	'code-rev-tag-remove' => 'Címkék eltávolítása:',
	'code-rev-comment-by' => '$1 hozzászólása',
	'code-rev-comment-preview' => 'Előnézet',
	'code-rev-inline-preview' => 'Előnézet:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'A változtatás túl nagy, nem lehet megjeleníteni.',
	'code-rev-purge-link' => 'frissítés',
	'code-rev-total' => 'Találatok száma összesen: $1',
	'code-rev-not-found' => "A következő változat nem létezik: '''$1'''",
	'code-rev-history-link' => 'történet',
	'code-status-new' => 'új',
	'code-status-desc-new' => 'A változat felülvizsgálatra vár (alapértelmezett állapot).',
	'code-status-fixme' => 'javítandó',
	'code-status-desc-fixme' => 'Az ellenőrzés szerint a változatban új hiba van, vagy nem működik. Javításra szorul.',
	'code-status-reverted' => 'visszaállítva',
	'code-status-desc-reverted' => 'A változatot eldobták egy későbbi változatban.',
	'code-status-resolved' => 'javítva',
	'code-status-desc-resolved' => 'A változattal gondok voltak, de a problémák javítva lettek egy későbbi változatban.',
	'code-status-ok' => 'rendben',
	'code-status-desc-ok' => 'Az ellenőrzést végző biztos benne, hogy a változat teljesen rendben van.',
	'code-status-deferred' => 'halasztva',
	'code-status-desc-deferred' => 'A változatot nem kell ellenőrizni.',
	'code-status-old' => 'régi',
	'code-status-desc-old' => 'Olyan régi változat, ami tartalmazhat hibákat, de nem éri meg a fáradozást az ellenőrzésük.',
	'code-signoffs' => 'Aláírások',
	'code-signoff-legend' => 'Aláírás hozzáadása',
	'code-signoff-submit' => 'Kijelentkezés',
	'code-signoff-strike' => 'A kiválasztott aláírások áthúzása',
	'code-signoff-signoff' => 'Változat aláírása mint:',
	'code-signoff-flag-inspected' => 'megvizsgálva',
	'code-signoff-flag-tested' => 'tesztelve',
	'code-signoff-field-user' => 'Felhasználó',
	'code-signoff-field-flag' => 'Címke',
	'code-signoff-field-date' => 'Dátum',
	'code-pathsearch-legend' => 'Változatok keresése elérési út alapján',
	'code-pathsearch-path' => 'Elérési út:',
	'code-pathsearch-filter' => 'Csak ezek:',
	'code-revfilter-cr_status' => 'Állapot = $1',
	'code-revfilter-cr_author' => 'Szerző = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Szűrő törlése',
	'code-rev-submit' => 'Változások elmentése',
	'code-rev-submit-next' => 'Mentés & ugrás a következőre',
	'code-rev-next' => 'Következő megoldatlan',
	'code-batch-status' => 'Állapot módosítása:',
	'code-batch-tags' => 'Tagek megváltoztatása:',
	'codereview-batch-title' => 'Az összes kiválasztott változat módosítása',
	'codereview-batch-submit' => 'Elküldés',
	'code-releasenotes' => 'kiadási megjegyzések',
	'code-release-legend' => 'Kiadási megjegyzések generálása',
	'code-release-startrev' => 'Első változat:',
	'code-release-endrev' => 'Utolsó változat:',
	'codereview-subtitle' => '$1 részére',
	'codereview-reply-link' => 'válasz',
	'codereview-overview-title' => 'Áttekintés',
	'codereview-overview-desc' => 'A lista grafikus megjelenítése',
	'codereview-email-subj' => '[$1 $2]: Új hozzászólás',
	'codereview-email-body' => '„$1” új hozzászólást fűzött az $3 változathoz.
URL: $2

Hozzászólás összefoglalója:

$5

$1 hozzászólása:

$4',
	'codereview-email-subj2' => '[$1 $2]: rákövetkező változtatások',
	'codereview-email-body2' => '„$1” utólagos változtatásokat végzett a(z) $2 verzión.
URL: $5

Változás összefoglalója:

$6

Az új verzióra mutató URL: $3
„$1” összefoglalója:

$4',
	'codereview-email-subj3' => '[$1 $2]: a jelölési állapot változott',
	'codereview-email-body3' => '"$1" megváltoztatta $2 státuszát erre: "$4"
URL: $5

Régi státusz: $3
Új státusz: $4

Összefoglaló:

$6',
	'code-stats' => 'statisztika',
	'code-stats-header' => 'A(z) $1-tárhely statisztikái',
	'code-stats-main' => '$1-i állapot szerint a tárhelyen {{PLURAL:$2|egy|$2}} változat van tárolva, amiket [[Special:Code/$3/author|{{PLURAL:$4|egy|$4}} szerző]] tett közzé.',
	'code-stats-status-breakdown' => 'Adott állapottal jelzett változatok száma',
	'code-stats-fixme-breakdown' => 'Javítandó változatok szerzőnként',
	'code-stats-count' => 'Ellenőrzések száma',
	'repoadmin' => 'Tárhelyadminisztráció',
	'repoadmin-new-legend' => 'Új tárhely készítése',
	'repoadmin-new-label' => 'Tárhely neve:',
	'repoadmin-new-button' => 'Elkészítés',
	'repoadmin-edit-legend' => 'A(z) „$1” kódtárhely módosítása',
	'repoadmin-edit-path' => 'Kódtárhely elérési útja:',
	'repoadmin-edit-bug' => 'Elérési út a Bugzillán:',
	'repoadmin-edit-view' => 'Elérési út a ViewVC-n:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'A(z) „[[Special:Code/$1|$1]]” kódtárhely sikeresen módosítva.',
	'repoadmin-nav' => 'tárhelyadminisztráció',
	'right-repoadmin' => 'kódtárhelyek beállítása',
	'right-codereview-use' => 'a Special:Code használata',
	'right-codereview-add-tag' => 'új címkék hozzáadása az egyes változatokhoz',
	'right-codereview-remove-tag' => 'címkék eltávolítása változatokról',
	'right-codereview-post-comment' => 'hozzászólás az egyes változatokhoz',
	'right-codereview-set-status' => 'változat állapotának megváltoztatása',
	'right-codereview-link-user' => 'szerzők összekapcsolása a wiki szerkesztőivel',
	'specialpages-group-developer' => 'Fejlesztői eszközök',
	'group-svnadmins' => 'SVN-adminisztrátorok',
	'group-svnadmins-member' => 'SVN-adminisztrátor',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-adminisztrátorok',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'code' => 'Revision de codice',
	'code-rev-title' => '$1 - Revision de codice',
	'code-comments' => 'Commentos',
	'code-references' => 'Versiones subsequente',
	'code-referenced' => 'Versiones subsequite',
	'code-change-status' => "cambiava le '''stato''' de v$1",
	'code-change-tags' => "cambiava le '''etiquettas''' de v$1",
	'code-change-removed' => 'removite:',
	'code-change-added' => 'addite:',
	'code-old-status' => 'Stato ancian',
	'code-new-status' => 'Stato nove',
	'code-prop-changes' => 'Registro de stato e de etiquettage',
	'codereview-desc' => '[[Special:Code|Instrumento pro revider le codice]] con [[Special:RepoAdmin|supporto de Subversion]]',
	'code-no-repo' => 'Nulle deposito configurate!',
	'code-create-repo' => 'Visita [[Special:RepoAdmin|RepoAdmin]] pro crear un deposito',
	'code-need-repoadmin-rights' => 'Le derecto "repoadmin" es necessari pro poter crear un deposito',
	'code-need-group-with-rights' => 'Nulle gruppo con derecto "repoadmin" existe. Per favor crea un tal pro poter adder un nove deposito.',
	'code-repo-not-found' => "Le deposito '''$1''' non existe!",
	'code-load-diff' => 'Carga diff…',
	'code-notes' => 'commentos recente',
	'code-statuschanges' => 'cambios de stato',
	'code-mycommits' => 'mi publicationes',
	'code-mycomments' => 'mi commentos',
	'code-authors' => 'autores',
	'code-status' => 'statos',
	'code-tags' => 'etiquettas',
	'code-tags-no-tags' => 'Nulle etiquetta existe in iste deposito.',
	'code-authors-text' => 'Infra es un lista de autores del deposito in ordine de nomine. Le contos del wiki local es monstrate inter parentheses. Le datos pote venir del cache.',
	'code-author-haslink' => 'Iste autor es ligate al usator $1 de iste wiki',
	'code-author-orphan' => 'Le usator de SVN/Le autor $1 ha nulle ligamine con un conto wiki',
	'code-author-dolink' => 'Ligar iste autor con un usator del wiki:',
	'code-author-alterlink' => 'Cambiar le usator de wiki ligate a iste autor:',
	'code-author-orunlink' => 'O disliga iste usator de wiki:',
	'code-author-name' => 'Entra un nomine de usator:',
	'code-author-success' => 'Le autor $1 ha essite ligate al usator $2 del wiki',
	'code-author-link' => 'ligar?',
	'code-author-unlink' => 'disligar?',
	'code-author-unlinksuccess' => 'Le autor $1 ha essite disligate',
	'code-author-badtoken' => 'Error de session durante le tentativa de executar iste action.',
	'code-author-total' => 'Numero total de autores: $1',
	'code-author-lastcommit' => 'Ultime data de commit',
	'code-browsing-path' => "Navigation per versiones in '''$1'''",
	'code-field-id' => 'Version',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Commentator',
	'code-field-message' => 'Summario de publication',
	'code-field-status' => 'Stato',
	'code-field-status-description' => 'Description del stato',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Commentos',
	'code-field-path' => 'Cammino',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Seliger',
	'code-reference-remove' => 'Remover le associationes seligite',
	'code-reference-associate' => 'Associar un version subsequente:',
	'code-reference-associate-submit' => 'Associar',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Commento:',
	'code-rev-repo' => 'Deposito:',
	'code-rev-rev' => 'Version:',
	'code-rev-rev-viewvc' => 'in ViewVC',
	'code-rev-paths' => 'Camminos modificate:',
	'code-rev-modified-a' => 'addite',
	'code-rev-modified-r' => 'reimplaciate',
	'code-rev-modified-d' => 'delite',
	'code-rev-modified-m' => 'modificate',
	'code-rev-imagediff' => 'Cambios de imagines',
	'code-rev-status' => 'Stato:',
	'code-rev-status-set' => 'Cambiar stato',
	'code-rev-tags' => 'Etiquettas:',
	'code-rev-tag-add' => 'Adder etiquettas:',
	'code-rev-tag-remove' => 'Remover etiquettas:',
	'code-rev-comment-by' => 'Commento per $1',
	'code-rev-comment-preview' => 'Previsualisation',
	'code-rev-inline-preview' => 'Previsualisation:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'Le diff es troppo grande pro esser monstrate.',
	'code-rev-purge-link' => 'purgar',
	'code-rev-total' => 'Numero total de resultatos: $1',
	'code-rev-not-found' => "Le version '''$1''' non existe!",
	'code-rev-history-link' => 'historia',
	'code-status-new' => 'nove',
	'code-status-desc-new' => 'Le version attende un action (stato predefinite).',
	'code-status-fixme' => 'corrigeme',
	'code-status-desc-fixme' => 'Iste version introduceva un error o es defectuose. Illo debe esser corrigite o revertite.',
	'code-status-reverted' => 'revertite',
	'code-status-desc-reverted' => 'Le version esseva jectate via per un version plus recente.',
	'code-status-resolved' => 'resolvite',
	'code-status-desc-resolved' => 'Le version habeva un problema que esseva resolvite per un version plus recente.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Le version ha essite revidite completemente e le revisor es secur que illo es totalmente in ordine.',
	'code-status-deferred' => 'differite',
	'code-status-desc-deferred' => 'Le version non require revision.',
	'code-status-old' => 'vetule',
	'code-status-desc-old' => 'Ancian version con potential errores, ma il non vale le pena revider los.',
	'code-signoffs' => 'Approbationes',
	'code-signoff-legend' => 'Adder approbation',
	'code-signoff-submit' => 'Approbar',
	'code-signoff-strike' => 'Cancellar le approbationes seligite',
	'code-signoff-signoff' => 'Approbar iste version como:',
	'code-signoff-flag-inspected' => 'Inspectate',
	'code-signoff-flag-tested' => 'Testate',
	'code-signoff-field-user' => 'Usator',
	'code-signoff-field-flag' => 'Indicator',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 (cancellate a $2)',
	'code-pathsearch-legend' => 'Cercar versiones in iste deposito per cammino',
	'code-pathsearch-path' => 'Cammino:',
	'code-pathsearch-filter' => 'Monstrar solmente:',
	'code-revfilter-cr_status' => 'Stato = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Etiquetta = $1',
	'code-revfilter-clear' => 'Rader filtro',
	'code-rev-submit' => 'Salveguardar modificationes',
	'code-rev-submit-next' => 'Salveguardar & problema sequente',
	'code-rev-next' => 'Proxime non resolvite',
	'code-batch-status' => 'Cambiar stato:',
	'code-batch-tags' => 'Cambiar etiquettas:',
	'codereview-batch-title' => 'Cambiar tote le revisiones seligite',
	'codereview-batch-submit' => 'Submitter',
	'code-releasenotes' => 'notas del version',
	'code-release-legend' => 'Generar notas del version',
	'code-release-startrev' => 'Version initial:',
	'code-release-endrev' => 'Version final:',
	'codereview-subtitle' => 'Pro $1',
	'codereview-reply-link' => 'responder',
	'codereview-overview-title' => 'Summario',
	'codereview-overview-desc' => 'Monstrar un summario graphic de iste lista',
	'codereview-email-subj' => '[$1] [v$2]: Nove commento addite',
	'codereview-email-body' => 'Le usator "$1" publicava un commento super $3.

Adresse URL complete: $2
Summario del commit:

$5

Commento:

$4',
	'codereview-email-subj2' => '[$1] [v$2]: Modificationes subsequente',
	'codereview-email-body2' => 'Le usator "$1" faceva cambios subsequente a $2.

URL complete del version subsequente: $5
Summario del commit:

$6

URL complete: $3
Summario del commit:

$4',
	'codereview-email-subj3' => '[$1 $2]: Stato del version cambiate',
	'codereview-email-body3' => 'Le usator "$1" cambiava le stato de $2.

Previe stato: $3
Nove stato: $4

URL complete: $5
Summario del commit:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nove commento addite, e stato del version cambiate',
	'codereview-email-body4' => 'Le usator "$1" cambiava le stato de $2.

Previe stato: $3
Nove stato: $4

Le usator "$1" dava etiam un commento sur $2.

URL complete: $5
Summario del commit:

$7

Commento:

$6',
	'code-stats' => 'statisticas',
	'code-stats-header' => 'Statisticas pro le deposito $1',
	'code-stats-main' => 'Al data de $1, le deposito ha $2 {{PLURAL:$2|version|versiones}} per [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autores}}]].',
	'code-stats-status-breakdown' => 'Numero de versiones per stato',
	'code-stats-fixme-breakdown' => 'Classification de corrigenda per autor',
	'code-stats-fixme-breakdown-path' => 'Classification de corrigenda per cammino',
	'code-stats-fixme-path' => 'Corrigenda pro le cammino: $1',
	'code-stats-new-breakdown' => 'Classification de nove versiones per autor',
	'code-stats-new-breakdown-path' => 'Classification de nove versiones per cammino',
	'code-stats-new-path' => 'Nove versiones pro le cammino: $1',
	'code-stats-count' => 'Numero de versiones',
	'code-tooltip-withsummary' => 'v$1 [$2] per $3 - $4',
	'code-tooltip-withoutsummary' => 'v$1 [$2] per $3',
	'repoadmin' => 'Administration de depositos',
	'repoadmin-new-legend' => 'Crear un nove deposito',
	'repoadmin-new-label' => 'Nomine del deposito:',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modification del deposito "$1"',
	'repoadmin-edit-path' => 'Cammino del deposito:',
	'repoadmin-edit-bug' => 'Cammino de Bugzilla:',
	'repoadmin-edit-view' => 'Cammino de ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Le deposito "[[Special:Code/$1|$1]]" ha essite modificate con successo.',
	'repoadmin-nav' => 'administration de depositos',
	'right-repoadmin' => 'Administrar le depositos de codice',
	'right-codereview-use' => 'Uso de Special:Code',
	'right-codereview-add-tag' => 'Adder nove etiquettas a versiones',
	'right-codereview-remove-tag' => 'Remover etiquettas de versiones',
	'right-codereview-post-comment' => 'Adder commentos a versiones',
	'right-codereview-set-status' => 'Cambiar le stato de versiones',
	'right-codereview-signoff' => 'Approbar versiones',
	'right-codereview-link-user' => 'Ligar autores a usatores del wiki',
	'right-codereview-associate' => 'Gerer associationes de versiones',
	'right-codereview-review-own' => 'Marcar le proprie versiones como "{{int:code-status-ok}}" o "{{int:code-status-resolved}}"',
	'action-repoadmin' => 'administrar le depositos de codice',
	'action-codereview-use' => 'uso de Special:Code',
	'action-codereview-add-tag' => 'adder nove etiquettas a versiones',
	'action-codereview-remove-tag' => 'remover etiquettas de versiones',
	'action-codereview-post-comment' => 'adder commentos a versiones',
	'action-codereview-set-status' => 'cambiar le stato de versiones',
	'action-codereview-signoff' => 'approbar versiones',
	'action-codereview-link-user' => 'ligar autores a usatores del wiki',
	'action-codereview-associate' => 'gerer associationes de versiones',
	'action-codereview-review-own' => 'marcar le proprie versiones como "{{int:code-status-ok}}" o "{{int:code-status-resolved}}"',
	'specialpages-group-developer' => 'Instrumentos pro disveloppatores',
	'group-svnadmins' => 'Administratores SVN',
	'group-svnadmins-member' => '{{GENDER:$1|administrator|administratrice}} SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Administratores SVN',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Iwan Novirion
 */
$messages['id'] = array(
	'code' => 'Tinjauan Kode',
	'code-rev-title' => '$1 - Tinjauan Kode',
	'code-comments' => 'Komentar',
	'code-references' => 'Menindaklanjuti revisi',
	'code-change-status' => "Ubah '''status''' dari $1",
	'code-change-tags' => "Ubah '''penanda''' dari $1",
	'code-change-removed' => 'hapus:',
	'code-change-added' => 'tambahkan:',
	'code-old-status' => 'Setatus lama',
	'code-new-status' => 'Setatus baru',
	'code-prop-changes' => 'Log Status & penandaan',
	'codereview-desc' => '[[Special:Code|Alat peninjau kode]] dengan [[Special:RepoAdmin|dukungan Subversion]]',
	'code-no-repo' => 'Tidak ada konfiguras tempat penyimpanan!',
	'code-create-repo' => 'Gunakan [[Special:RepoAdmin|RepoAdmin]] untuk membuat suatu Repositori',
	'code-need-repoadmin-rights' => 'Hak repoadmin diperlukan untuk dapat membuat suatu Repositori',
	'code-need-group-with-rights' => 'Tidak ada kelompok yang memiliki hak akses repoadmin. Harap tambahkan untuk dapat membuat Repositori baru',
	'code-repo-not-found' => "Gudang data '''$1''' tidak ada!",
	'code-load-diff' => 'Memuat perbedaan...',
	'code-notes' => 'komentar terbaru',
	'code-statuschanges' => 'perubahan status',
	'code-mycommits' => 'komitmen saya',
	'code-mycomments' => 'komentar saya',
	'code-authors' => 'penulis',
	'code-status' => 'keadaan',
	'code-tags' => 'Penanda',
	'code-tags-no-tags' => 'Tidak ada tag di repositori ini.',
	'code-authors-text' => 'Berikut adalah daftar penulis repo diurutkan menurut nama pelaksana. Akun wiki lokal ditampilkan dalam tanda kurung. Data mungkin disinggahkan.',
	'code-author-haslink' => 'Penulis ini terhubung ke pengguna wiki $1',
	'code-author-orphan' => 'Penulis ini tidak terhubung dengan akun wiki',
	'code-author-dolink' => 'Kaitkan penulis ke Wiki pengguna:',
	'code-author-alterlink' => 'Ubah hubungan wiki pengguna ke penulis ini:',
	'code-author-orunlink' => 'Atau buang kaitan wiki pengguna ini:',
	'code-author-name' => 'Masukkan nama pengguna:',
	'code-author-success' => 'Penulis $1 telah dihubungkan ke wiki pengguna $2',
	'code-author-link' => 'pranala?',
	'code-author-unlink' => 'hapus pranala?',
	'code-author-unlinksuccess' => 'Hubungan penulis $1 telah di putus',
	'code-author-badtoken' => 'Kesalahan sesi ketika mencoba melakukan tindakan.',
	'code-author-total' => 'Jumlah total pemilik: $1',
	'code-author-lastcommit' => 'Tanggal pemasukan terakhir',
	'code-browsing-path' => "Jelajahi revisi pada '''$1'''",
	'code-field-id' => 'Revisi',
	'code-field-author' => 'Pembuat',
	'code-field-user' => 'Komentar',
	'code-field-message' => 'Ringkasan komit',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Deskripsi status',
	'code-field-timestamp' => 'Tanggal',
	'code-field-comments' => 'Komentar',
	'code-field-path' => 'Jalan',
	'code-field-text' => 'Catatan',
	'code-field-select' => 'Pilih',
	'code-reference-remove' => 'Hapus kaitan terpilih',
	'code-reference-associate' => 'Kaitkan revisi tindak lanjut:',
	'code-reference-associate-submit' => 'Kaitkan',
	'code-rev-author' => 'Pembuat:',
	'code-rev-date' => 'Tanggal:',
	'code-rev-message' => 'Komentar:',
	'code-rev-repo' => 'tempat penyimpanan:',
	'code-rev-rev' => 'Revisi:',
	'code-rev-rev-viewvc' => 'pada ViewVC',
	'code-rev-paths' => 'Ubah jejak:',
	'code-rev-modified-a' => 'ditambahkan',
	'code-rev-modified-r' => 'gantikan',
	'code-rev-modified-d' => 'dihapus',
	'code-rev-modified-m' => 'diubah',
	'code-rev-imagediff' => 'mengubah gambar',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'ubah setatus',
	'code-rev-tags' => 'Penanda:',
	'code-rev-tag-add' => 'Tambah penanda:',
	'code-rev-tag-remove' => 'Hilangkan penanda:',
	'code-rev-comment-by' => 'Komentar oleh $1',
	'code-rev-comment-preview' => 'Pratayang',
	'code-rev-inline-preview' => 'Pratayang:',
	'code-rev-diff' => 'Beda',
	'code-rev-diff-link' => 'beda',
	'code-rev-diff-too-large' => 'Perbedaan sangat besar untuk ditampilkan',
	'code-rev-purge-link' => 'pembersihan',
	'code-rev-total' => 'Jumlah hasil: $1',
	'code-rev-not-found' => "Revisi '''$1''' tidak ditemukan!",
	'code-rev-history-link' => 'versi',
	'code-status-new' => 'baru',
	'code-status-desc-new' => 'Revisi masih menunggu tindakan (status bawaan).',
	'code-status-fixme' => 'perbaiki',
	'code-status-desc-fixme' => 'Seorang peninjau menandai revisi ini sebagai penyebab bug atau rusak. Ini harus diperbaiki.',
	'code-status-reverted' => 'telah dikembalikan',
	'code-status-desc-reverted' => 'Revisi itu dibatalkan oleh revisi selanjutnya.',
	'code-status-resolved' => 'selesai',
	'code-status-desc-resolved' => 'Revisi memiliki masalah yang dipecahkan oleh revisi berikutnya.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revisi sepenuhnya ditinjau dan peninjau yakin revisi ini sudah baik dalam segala hal.',
	'code-status-deferred' => 'ditangguhkan',
	'code-status-desc-deferred' => 'Revisi tidak memerlukan tinjauan.',
	'code-status-old' => 'lama',
	'code-status-desc-old' => 'Revisi lama dengan potensi bug, namun potensi tersebut tidak sebanding dengan upaya tinjauan.',
	'code-signoffs' => 'Persetujuan',
	'code-signoff-legend' => 'Berikan persetujuan',
	'code-signoff-submit' => 'Persetujuan',
	'code-signoff-strike' => 'Coret persetujuan terpilih',
	'code-signoff-signoff' => 'Persetujuan revisi ini',
	'code-signoff-flag-inspected' => 'Inspeksi',
	'code-signoff-flag-tested' => 'Diuji',
	'code-signoff-field-user' => 'Pengguna',
	'code-signoff-field-flag' => 'Tanda',
	'code-signoff-field-date' => 'Tanggal',
	'code-signoff-struckdate' => '$1 (dicoret $2)',
	'code-pathsearch-legend' => 'Cari revisi di jejak penyimpanan ini:',
	'code-pathsearch-path' => 'Jalan:',
	'code-pathsearch-filter' => 'Penerapan filter:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Penulis = $1',
	'code-revfilter-ct_tag' => 'Penanda = $1',
	'code-revfilter-clear' => 'Hapus filter',
	'code-rev-submit' => 'Simpan perubahan',
	'code-rev-submit-next' => 'Simpan & belum selesai selanjutnya',
	'code-batch-status' => 'Ubah status:',
	'code-batch-tags' => 'Ubah tag:',
	'codereview-batch-title' => 'Ubah semua revisi terpilih',
	'codereview-batch-submit' => 'Kirim',
	'code-releasenotes' => 'catatan pelepasan',
	'code-release-legend' => 'Buat catatan rilis',
	'code-release-startrev' => 'Memulai rev:',
	'code-release-endrev' => 'Akhir rev:',
	'codereview-subtitle' => 'Untuk $1',
	'codereview-reply-link' => 'balas',
	'codereview-email-subj' => '[$1 $2]: Komenter baru ditambahkan',
	'codereview-email-body' => 'Pengguna "$1" berkomentar pada $3.

URL lengkap: $2
Ringkasan masukan:

$5

Komentar:

$4',
	'codereview-email-subj2' => '[$1 $2]:Menindaklanjuti perubahan',
	'codereview-email-body2' => 'Pengguna "$1" membuat perubahan lanjutan terhadap $2.

URL lengkap untuk revisi lanjutan: $5
Ringkasan masukan:

$6

URL lengkap: $3
Ringkasan masukan:

$4',
	'codereview-email-subj3' => '[$1 $2]: Status revisi berubah',
	'codereview-email-body3' => 'Pengguna "$1" mengubah status $2.

Status lama: $3
Status baru: $4

URL lengkap: $5
Ringkasan masukan:

$6',
	'codereview-email-subj4' => '[$1 $2]: Komentar baru ditambahkan dan revisi status berubah',
	'codereview-email-body4' => 'Pengguna "$1" mengubah status $2.

Status lama: $3
Status baru: $4

Pengguna "$1" juga berkomentar terhadap $2.

URL lengkap: $5
Ringkasan masukan:

$7

Komentar:

$6',
	'code-stats' => 'statistik',
	'code-stats-header' => 'Statistik repositori $1',
	'code-stats-main' => 'Pada $1, penyimpanan ini memiliki $2 {{PLURAL:$2|revisi|revisi}} oleh [[Special:Code/$3/author|$4 {{PLURAL:$4|pemilik|pemilik}}]].',
	'code-stats-status-breakdown' => 'Jumlah revisi per kondisi',
	'code-stats-fixme-breakdown' => 'Perincian fixme per pemilik',
	'code-stats-count' => 'Jumlah revisi',
	'repoadmin' => 'Penyimpanan Admin',
	'repoadmin-new-legend' => 'Buat penyimpanan baru',
	'repoadmin-new-label' => 'Nama tempat penyimpanan:',
	'repoadmin-new-button' => 'Buat',
	'repoadmin-edit-legend' => 'Perubahan pada penyimpanan "$1"',
	'repoadmin-edit-path' => 'Jejak tempat penyimpanan:',
	'repoadmin-edit-bug' => 'Jejak Bugzilla:',
	'repoadmin-edit-view' => 'Jejak ViewV:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Penyimpanan "[[Special:Code/$1|$1]]"  selesai diubah.',
	'repoadmin-nav' => 'administrasi repositori',
	'right-repoadmin' => 'Pengelolaan kode penyimpanan',
	'right-codereview-use' => 'Penggunaan Khusus:Kode',
	'right-codereview-add-tag' => 'Tambahkan tag baru pada revisi',
	'right-codereview-remove-tag' => 'Buang tag dari revisi',
	'right-codereview-post-comment' => 'Tambah komentar pada revisi',
	'right-codereview-set-status' => 'Ubah status revisi',
	'right-codereview-signoff' => 'Persetujuan revisi',
	'right-codereview-link-user' => 'Pranala penulis ke wiki pengguna',
	'right-codereview-associate' => 'Mengelola keterkaitan revisi',
	'right-codereview-review-own' => 'Tandai suntingan Anda sendiri sebagai OK',
	'specialpages-group-developer' => 'Alat Pengembang',
	'group-svnadmins' => 'Pengurus SVN',
	'group-svnadmins-member' => 'Pengurus SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Pengurus SVN',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'code-author-link' => 'jìkó?',
	'code-author-unlink' => 'á jịkòkwàlà?',
	'code-field-author' => 'Odè ákwúkwó',
	'code-field-timestamp' => 'Ubochì',
	'code-field-path' => 'Uzọr',
	'code-status-new' => 'ohüru',
	'code-status-ok' => 'Ngwanu',
	'code-status-old' => 'ichié',
	'repoadmin-new-button' => 'Ké',
	'repoadmin-edit-button' => 'Ngwanu',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'code' => 'Pagrepaso ti kodigo',
	'code-rev-title' => '$1 - Pagrepaso ti kodigo',
	'code-comments' => 'Dagiti komentario',
	'code-references' => 'Dagiti sarunuen a panagbaliw',
	'code-referenced' => 'Dagiti nasarunuan a panagbaliw',
	'code-change-status' => "sinukatan ti  '''kasasaad''' iti $1",
	'code-change-tags' => "sinukatan dagiti '''etiketa''' para iti $1",
	'code-change-removed' => 'inikkat:',
	'code-change-added' => 'innayon:',
	'code-old-status' => 'Daan a kasasaad',
	'code-new-status' => 'Baro a kasasaad',
	'code-prop-changes' => 'Kasasaad ken listaan ti panag-etiketa',
	'codereview-desc' => '[[Special:Code|Ramit ti panagrepaso ti kodigo]] nga addaan ti [[Special:RepoAdmin|Subversion a suporta]]',
	'code-no-repo' => 'Awan ti repositorio a naaramid!',
	'code-create-repo' => 'Mapan idiay [[Special:RepoAdmin|RepoAdmin]] tapno makaaramid ti Repositorio',
	'code-need-repoadmin-rights' => 'masapul ti repoadmin a karbengan tapno makaaramid ti Repositorio',
	'code-need-group-with-rights' => 'Awan ti bunggoy nga addaan ti repoadmin a karbengan. Pangngaasi nga agnayon ti maysa tapno makanayon ti baro a Repositorio',
	'code-repo-not-found' => "Ti Repositorio a '''$1''' ket awanen!",
	'code-load-diff' => 'Agkarkarga ti sabali...',
	'code-notes' => 'dagiti kinaudi a komentario',
	'code-statuschanges' => 'dagiti sinukatan a kasasaad',
	'code-mycommits' => 'dagiti naitalekak',
	'code-mycomments' => 'dagiti komentariok',
	'code-authors' => 'dagiti mannurat',
	'code-status' => 'dagiti kasasaad',
	'code-tags' => 'dagiti etiketa',
	'code-tags-no-tags' => 'Awan dagiti etiketa iti daytoy a repositorio.',
	'code-authors-text' => 'Dita baba ket listaan dagiti repo a mannurat iti urnos iti naitakla a nagan. Dagiti lokal a pakabilangan ti wiki ket naiparang iti pangserra. Dagiti linaon ket baka naidulin.',
	'code-author-haslink' => 'Daytoy a mannurat ket naisilpo idiay agar-aramat ti wiki a $1',
	'code-author-orphan' => 'Ti SVN nga agar-aramat/Mannurat $1 ket awan ti panilpo na iti pakabilangan ti wiki',
	'code-author-dolink' => 'Isilpo daytoy nga agar-aramat iti agar-aramat ti wiki:',
	'code-author-alterlink' => 'Sukatan ti naisilpo a wiki nga agar-aramat iti daytoy a mannurat:',
	'code-author-orunlink' => 'Wenno ikkaten ti panilpo iti daytoy nga agar-aramat ti wiki:',
	'code-author-name' => 'Mangiserrek iti nagan-agar-aramat:',
	'code-author-success' => 'Ti mannurat $1 ket naisilpo ti agar-aramat ti wiki $2',
	'code-author-link' => 'isilpo?',
	'code-author-unlink' => 'ikkaten ti insilpo?',
	'code-author-unlinksuccess' => 'Ti mannurat $1 ket naikkaten ti insilpo',
	'code-author-badtoken' => 'Biddut ti gimong ti panagtungpal iti daytoy nga aramid.',
	'code-author-total' => 'Dagup a bilang kadagiti mannurat: $1',
	'code-author-lastcommit' => 'Kinaudi a naitakla a petsa',
	'code-browsing-path' => "Agpa-basabasa kadagiti panagbaliw idiay '''$1'''",
	'code-field-id' => 'Panagbaliw',
	'code-field-author' => 'Mannurat',
	'code-field-user' => 'Nag-komentario',
	'code-field-message' => 'Kinabuklan ti naitakla',
	'code-field-status' => 'Kasasaad',
	'code-field-status-description' => 'Deskripsion ti kasasaad',
	'code-field-timestamp' => 'Petsa',
	'code-field-comments' => 'Dagiti komentario',
	'code-field-path' => 'Dalan',
	'code-field-text' => 'Pakaammo',
	'code-field-select' => 'Agpili',
	'code-reference-remove' => 'Ikkaten dagiti napili a naigunglo',
	'code-reference-associate' => 'Naigunglo a sarunuen a panagbaliw:',
	'code-reference-associate-submit' => 'Gunglo',
	'code-rev-author' => 'Mannurat:',
	'code-rev-date' => 'Petsa:',
	'code-rev-message' => 'Komentario:',
	'code-rev-repo' => 'Repositorio:',
	'code-rev-rev' => 'Panagbaliw:',
	'code-rev-rev-viewvc' => 'idiay ViewVC',
	'code-rev-paths' => 'Dagiti binaliwan a dalan:',
	'code-rev-modified-a' => 'innayon',
	'code-rev-modified-r' => 'sinukatan',
	'code-rev-modified-d' => 'inikkat',
	'code-rev-modified-m' => 'binaliwan',
	'code-rev-imagediff' => 'Dagiti sinukatan nga imahen',
	'code-rev-status' => 'Kasasaad:',
	'code-rev-status-set' => 'Dagiti sinukatan a kasasaad',
	'code-rev-tags' => 'Dagiti etiketa:',
	'code-rev-tag-add' => 'Agnayon kadagiti etiketa:',
	'code-rev-tag-remove' => 'Agikkat kadagiti etiketa:',
	'code-rev-comment-by' => 'Komentario babaen ni $1',
	'code-rev-comment-preview' => 'Naipadas',
	'code-rev-inline-preview' => 'Naipadas:',
	'code-rev-diff' => 'Sabali',
	'code-rev-diff-link' => 'sabali',
	'code-rev-diff-too-large' => 'Ti sabali ket dakkel unay nga iparang.',
	'code-rev-purge-link' => 'purgaen',
	'code-rev-total' => 'Dagup a bilang kadagiti nagbanagan: $1',
	'code-rev-not-found' => "Ti binaliwan a '''$1''' ket awanen!",
	'code-rev-history-link' => 'pakasaritaan',
	'code-status-new' => 'baro',
	'code-status-desc-new' => 'Ti binaliwan ket agur-uray iti panakaaramid (kinasigud a kasasaad) .',
	'code-status-fixme' => 'simpaen nak',
	'code-status-desc-fixme' => 'Ti panagbaliw ket nagited ti kiteb wenno nadadael. Masapul a masimpa wenno isubli.',
	'code-status-reverted' => 'naisubli',
	'code-status-desc-reverted' => 'Ti binaliwan ket naisubli babaen ti maysa a naudi a panagbaliw.',
	'code-status-resolved' => 'naibanagan',
	'code-status-desc-resolved' => 'Ti binaliwan ket addaan ti pakirut a nasimpa babaen ti kinaudi a panagbaliw.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Sibubukel a narepaso ti binaliwan ken ti nagrepaso ket sigurado a nasayaat  ti amin nga ania na.',
	'code-status-deferred' => 'naitungkua',
	'code-status-desc-deferred' => 'Daytoy a panagbaliw ket saan na a masapul ti repaso.',
	'code-status-old' => 'daan',
	'code-status-desc-old' => 'Daan a panagbaliw nga addan ngata dagiti kiteb nga awan ti pateg na a repasuen.',
	'code-signoffs' => 'Dagiti napalubosan',
	'code-signoff-legend' => 'Agnayon palubos',
	'code-signoff-submit' => 'Palubosan',
	'code-signoff-strike' => 'Ikkaten dagiti napili a palubosan',
	'code-signoff-signoff' => 'Palubosan iti daytoy a panagbaliw a kas:',
	'code-signoff-flag-inspected' => 'Nasukimat',
	'code-signoff-flag-tested' => 'Nasubokan',
	'code-signoff-field-user' => 'Agar-aramat',
	'code-signoff-field-flag' => 'Bandera',
	'code-signoff-field-date' => 'Petsa',
	'code-signoff-struckdate' => '$1 (naikkat $2)',
	'code-pathsearch-legend' => 'Agbiruk kadagiti binaliwan babaen ti dalan',
	'code-pathsearch-path' => 'Dalan:',
	'code-pathsearch-filter' => 'Iparang laeng ti:',
	'code-revfilter-cr_status' => 'Kasasaad = $1',
	'code-revfilter-cr_author' => 'Mannurat = $1',
	'code-revfilter-ct_tag' => 'Etiketa = $1',
	'code-revfilter-clear' => 'Dalusan ti sagat',
	'code-rev-submit' => 'Idulin dagiti sinukatan',
	'code-rev-submit-next' => 'Idulin ken sumaruno a saan a naibanagan',
	'code-rev-next' => 'Sumaruno a saan a naibanagan',
	'code-batch-status' => 'Sukatan dagiti kasasaad:',
	'code-batch-tags' => 'Sukatan dagiti etiketa:',
	'codereview-batch-title' => 'Sukatan amin dagiti napili a binaliwan',
	'codereview-batch-submit' => 'Ited',
	'code-releasenotes' => 'ibbatan dagiti paammo',
	'code-release-legend' => 'Agaramid dagiti ibbatan a paammo',
	'code-release-startrev' => 'Rugi ti panabaliw:',
	'code-release-endrev' => 'Naudi a panagbaliw:',
	'codereview-subtitle' => 'Para iti $1',
	'codereview-reply-link' => 'sungbat',
	'codereview-overview-title' => 'Panakabuklan',
	'codereview-overview-desc' => 'Iparang ti grapiko a panakabuklan iti daytoy a listaan',
	'codereview-email-subj' => '[$1 $2]: Nanayonan ti baro a komentario',
	'codereview-email-body' => 'Ni "$1" ket nagipablaak ti komentario idiay $3.
URL: $2

Naitalek a pinabuklan para iti  $3:

$5

Komentario ni $1:

$4',
	'codereview-email-subj2' => '[$1 $2]: Dagiti sarunuen a sukatan',
	'codereview-email-body2' => 'Ni "$1" ket nagaramid kadagiti sarunuen a sukatan iti $2.
URL: $5

Kinabuklan ti naitalek para iti nasarunuan $2:

$6

Sarunuan a URL: $3
Kinabuklan a sarunuan babaen ti "$1":

$4',
	'codereview-email-subj3' => '[$1 $2]: Sinukatan ti kasasaad ti panagbaliw',
	'codereview-email-body3' => 'Ni "$1" ket sinukatan na ti kasasaad iti $2 iti "$4"
URL: $5

Daan a kasasaad: $3
Baro a kasasaad: $4

Kinabuklan ti panagkaitalek $2:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nanayonan ti baro a komentario, ket nasukatan ti panagbaliw',
	'codereview-email-body4' => 'Ni "$1" ket sinukatan na ti kasasaad iti $2 iti "$4" ket inikkan na ti komentario.
URL: $5

Daan a kasasaad: $3
Baro a kasasaad: $4

Kinabuklan ti naitalek para iti $2:

$7

Komentario ni $1:

$6',
	'code-stats' => 'estadistika',
	'code-stats-header' => 'Dagiti estadistika para iti repositorio $1',
	'code-stats-main' => 'manipud iti $1, ti repositorio ket addaan  $2 {{PLURAL:$2|ti binaliwan|dagiti binaliwan}} babaen  [[Special:Code/$3/author|$4 {{PLURAL:$4|ti mannurat|dagiti mannurat}}]].',
	'code-stats-status-breakdown' => 'Dagiti bilang ti binaliwan babaen ti tunggal maysa nga estado',
	'code-stats-fixme-breakdown' => 'Dagiti nailasin a simpaen nak a panagbaliw tunggal maysa a mannurat',
	'code-stats-fixme-breakdown-path' => 'Dagiti nailasin a simpaen nak a panagbaliw tunggal maysa a dalan',
	'code-stats-fixme-path' => 'Simpaen nak a panagbaliw para iti dalan: $1',
	'code-stats-new-breakdown' => 'Dagiti nailasin a baro a panagbaliw tunggal maysa a mannurat',
	'code-stats-new-breakdown-path' => 'Dagiti nailasin a baro a panagbaliw tunggal maysa a dalan',
	'code-stats-new-path' => 'Baro a panagbaliw para iti dalan: $1',
	'code-stats-count' => 'Dagiti bilang ti panagbaliw',
	'code-tooltip-withsummary' => 'r$1 [$2] babaen ti $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] babaen ti $3',
	'repoadmin' => 'Administrasion para iti Repositorio',
	'repoadmin-new-legend' => 'Agaramid ti baro a repositorio',
	'repoadmin-new-label' => 'Nagan ti repositorio:',
	'repoadmin-new-button' => 'Agaramid',
	'repoadmin-edit-legend' => 'Panagbaliw ti repositorio "$1"',
	'repoadmin-edit-path' => 'Dalan ti repositorio:',
	'repoadmin-edit-bug' => 'Dalan ti Bugzilla:',
	'repoadmin-edit-view' => 'Dalan ti ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Ti repositorio "[[Special:Code/$1|$1]]" ket nagballigi ti panakabalbaliw.',
	'repoadmin-nav' => 'administrasion para iti Repositorio',
	'right-repoadmin' => 'Taripatuen dagiti repositorio ti kodigo',
	'right-codereview-use' => 'Panag-usar ti Espesial:Kodigo',
	'right-codereview-add-tag' => 'Agnayon kadagiti baro anga etiketa kadagiti panagbaliw',
	'right-codereview-remove-tag' => 'Ikkaten dagiti etiketa kadagiti panagbaliw',
	'right-codereview-post-comment' => 'Agnayon kadagiti komentario kadagiti panagbaliw',
	'right-codereview-set-status' => 'Sukatan dagiti kasasaad ti panagbaliw',
	'right-codereview-signoff' => 'Agpalubos kadagiti binaliwan',
	'right-codereview-link-user' => 'Isilpo dagiti mannurat iti agar-aramat ti wiki',
	'right-codereview-associate' => 'Taripatuen ti panagbaliw kadagiti nai-gunglo',
	'right-codereview-review-own' => 'Markaan dagiti bukod mo a binaliwan a kas OK wenno Naibanagan',
	'specialpages-group-developer' => 'Ramramit dagiti agraramid',
	'group-svnadmins' => 'dagiti administrador ti SVN',
	'group-svnadmins-member' => '{{GENDER:$1|SVN admin}}',
	'grouppage-svnadmins' => '{{ns:project}}:Dagiti administrador ti SVN',
);

/** Ido (Ido)
 * @author Malafaya
 */
$messages['io'] = array(
	'code-comments' => 'Komenti',
	'code-change-removed' => 'forigita:',
	'code-change-added' => 'adjuntita:',
	'code-old-status' => 'Anciena stando',
	'code-new-status' => 'Nova stando',
	'code-authors' => 'autori',
	'code-author-link' => 'ligar?',
	'code-author-unlink' => 'desligar?',
	'code-field-author' => 'Autoro',
	'code-field-status' => 'Stando',
	'code-field-timestamp' => 'Dato',
	'code-rev-author' => 'Autoro:',
	'code-rev-date' => 'Dato:',
	'code-rev-message' => 'Komento:',
	'code-rev-comment-by' => 'Komento per $1',
	'code-rev-diff' => 'Diferi',
	'code-rev-diff-link' => 'dif.',
	'code-status-new' => 'nova',
	'code-status-ok' => 'o.k.',
	'code-status-old' => 'anciena',
	'code-revfilter-cr_status' => 'Stando = $1',
	'code-revfilter-cr_author' => 'Autoro = $1',
	'codereview-batch-submit' => 'Sendez',
	'codereview-email-subj' => '[$1 $2]: Nova komento adjuntita',
	'repoadmin-edit-button' => 'O.K.',
);

/** Italian (Italiano)
 * @author Aushulz
 * @author Beta16
 * @author BrokenArrow
 * @author Darth Kule
 * @author F. Cosoleto
 * @author Gianfranco
 * @author Melos
 * @author Nemo bis
 * @author Santu
 * @author Stefano-c
 */
$messages['it'] = array(
	'code' => 'Revisione del codice',
	'code-rev-title' => '$1 - Revisione del codice',
	'code-comments' => 'Commenti',
	'code-change-status' => "ha modificato lo '''stato''' di $1",
	'code-change-tags' => "ha modificato i '''tag''' di $1",
	'code-change-removed' => 'rimosso:',
	'code-change-added' => 'aggiunto:',
	'code-old-status' => 'Vecchio stato',
	'code-new-status' => 'Nuovo stato',
	'code-prop-changes' => 'Registro dello stato e dei tag',
	'codereview-desc' => '[[Special:Code|Strumento per la revisione del codice]] con [[Special:RepoAdmin|supporto per Subversion]]',
	'code-no-repo' => 'Nessun repository configurato.',
	'code-create-repo' => 'Vai a [[Special:RepoAdmin|RepoAdmin]] per creare un repository',
	'code-need-repoadmin-rights' => 'i diritti di repoadmin sono necessari per poter creare un repository',
	'code-repo-not-found' => "Repository '''$1''' non esiste!",
	'code-load-diff' => 'Caricamento diff in corso…',
	'code-notes' => 'commenti più recenti',
	'code-statuschanges' => 'cambiamenti di stato',
	'code-mycommits' => 'miei commit',
	'code-mycomments' => 'miei commenti',
	'code-authors' => 'autori',
	'code-status' => 'descrizione stati',
	'code-tags' => 'tag',
	'code-tags-no-tags' => 'Nessun tag è presente in questo repository.',
	'code-authors-text' => 'Di seguito viene presentata una lista di autori relativi al repository, in ordine cronologico per i commit recenti. Gli account wiki locali sono mostrati fra parentesi.',
	'code-author-haslink' => "Questo autore è collegato all'utente wiki $1",
	'code-author-orphan' => "L'utente SVN/autore $1 non è collegato a un account wiki",
	'code-author-dolink' => 'Collegare questo autore a un utente wiki:',
	'code-author-alterlink' => "Cambiare l'utente wiki collegato a questo autore:",
	'code-author-orunlink' => 'O rimuovere il collegamento con questo utente wiki:',
	'code-author-name' => 'Inserire un nome utente:',
	'code-author-success' => "L'autore $1 è stato collegato all'utente wiki $2",
	'code-author-link' => 'collega?',
	'code-author-unlink' => 'scollega?',
	'code-author-unlinksuccess' => "È stato rimosso il collegamento all'autore $1",
	'code-author-badtoken' => "Errore durante la sessione nel tentativo di eseguire l'azione richiesta.",
	'code-author-total' => 'Numero totale di autori: $1',
	'code-author-lastcommit' => 'Data ultimo commit',
	'code-browsing-path' => "Esplora le revisioni in '''$1'''",
	'code-field-id' => 'Revisione',
	'code-field-author' => 'Autore',
	'code-field-user' => 'Autore del commento',
	'code-field-message' => 'Oggetto del commit',
	'code-field-status' => 'Stato',
	'code-field-status-description' => 'Descrizione degli stati',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Commenti',
	'code-field-path' => 'Percorso',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Seleziona',
	'code-reference-remove' => 'Rimuovi le associazioni selezionate',
	'code-reference-associate-submit' => 'Associa',
	'code-rev-author' => 'Autore:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Commento:',
	'code-rev-repo' => 'Repository:',
	'code-rev-rev' => 'Revisione:',
	'code-rev-rev-viewvc' => 'su ViewVC',
	'code-rev-paths' => 'Percorsi modificati:',
	'code-rev-modified-a' => 'aggiunto',
	'code-rev-modified-r' => 'sostituito',
	'code-rev-modified-d' => 'cancellato',
	'code-rev-modified-m' => 'modificato',
	'code-rev-imagediff' => "Modifiche all'immagine",
	'code-rev-status' => 'Stato:',
	'code-rev-status-set' => 'Modifica stato',
	'code-rev-tags' => 'Tag:',
	'code-rev-tag-add' => 'Aggiungi tag:',
	'code-rev-tag-remove' => 'Rimuovi tag:',
	'code-rev-comment-by' => 'Commento di $1',
	'code-rev-comment-preview' => 'Anteprima',
	'code-rev-inline-preview' => 'Anteprima:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'La diff è troppo grande per essere visualizzata.',
	'code-rev-purge-link' => 'purga',
	'code-rev-total' => 'Numero totale di risultati: $1',
	'code-rev-not-found' => "La revisione '''$1''' è inesistente!",
	'code-rev-history-link' => 'cronologia',
	'code-status-new' => 'nuovo',
	'code-status-desc-new' => "La revisione è in attesa di un'azione (stato predefinito).",
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => 'La revisione ha aggiunto un malfunzionamento e dovrebbe essere corretta.',
	'code-status-reverted' => 'annullato',
	'code-status-desc-reverted' => 'Revisione annullata da una revisione successiva.',
	'code-status-resolved' => 'risolto',
	'code-status-desc-resolved' => 'La revisione ha avuto un problema risolto da una revisione successiva.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revisione visionata in modo completo ed è certo che andrà correttamente sotto tutti gli aspetti.',
	'code-status-deferred' => 'differito',
	'code-status-desc-deferred' => 'Revisione che non richiede di essere esaminata.',
	'code-status-old' => 'vecchia',
	'code-status-desc-old' => 'Vecchia revisione con bug potenziali ma che non vale la pena di esaminare.',
	'code-signoffs' => 'Sign-off',
	'code-signoff-legend' => 'Aggiunge firma',
	'code-signoff-submit' => 'Sign off',
	'code-signoff-strike' => 'Sbarra i sign-off selezionati',
	'code-signoff-signoff' => 'Sign off su questa revisione come:',
	'code-signoff-flag-inspected' => 'Ispezionato',
	'code-signoff-flag-tested' => 'Testato',
	'code-signoff-field-user' => 'Utente',
	'code-signoff-field-flag' => 'Flag',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 ($2 sbarrati)',
	'code-pathsearch-legend' => 'Ricerca nelle revisioni di questo repository in base al percorso',
	'code-pathsearch-path' => 'Percorso:',
	'code-pathsearch-filter' => 'Mostra solo:',
	'code-revfilter-cr_status' => 'Stato = $1',
	'code-revfilter-cr_author' => 'Autore = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Cancella filtro',
	'code-rev-submit' => 'Salva le modifiche',
	'code-rev-submit-next' => 'Salva e vai alla prossima situazione irrisolta',
	'code-rev-next' => 'Prossimo irrisolto',
	'code-batch-status' => 'Modifica stato:',
	'code-batch-tags' => 'Modifica etichetta:',
	'codereview-batch-title' => 'Modifica tutte le revisioni selezionate',
	'codereview-batch-submit' => 'Invia',
	'code-releasenotes' => 'note di versione',
	'code-release-legend' => 'Genera note di versione',
	'code-release-startrev' => 'Revisione iniziale:',
	'code-release-endrev' => 'Revisione finale:',
	'codereview-subtitle' => 'Per $1',
	'codereview-reply-link' => 'rispondi',
	'codereview-overview-title' => 'Panoramica',
	'codereview-overview-desc' => 'Visualizza una panoramica grafica di questo elenco',
	'codereview-email-subj' => '[$1 $2]: Aggiunto un commento',
	'codereview-email-body' => 'L\'utente "$1" ha inviato un commento per $3.

URL: $2

Sommario del commit $3:

$5

Commento di $1:

$4',
	'codereview-email-subj3' => '[$1 $2]: Stato della revisione cambiato',
	'codereview-email-body3' => '"$1" ha cambiato lo stato di $2 a "$4"
URL: $5

Precedente stato:  $3
Nuovo stato: $4

Sommario del commit $2:

$6',
	'codereview-email-subj4' => '[$1 $2]: Un nuovo commento e lo stato della revisione è cambiato',
	'codereview-email-body4' => '"$1" ha cambiato lo stato di $2 a "$4" e ha inserito un commento.
URL: $5

Precedente stato: $3
Nuovo stato: $4

Sommario del commit $2:

$7

Commento di $1:

$6',
	'code-stats' => 'statistiche',
	'code-stats-header' => 'Statistiche per il repository $1',
	'code-stats-main' => 'Alla data del $1, il repository contiene $2 {{PLURAL:$2|revisione|revisioni}} da parte di [[Special:Code/$3/author|$4 {{PLURAL:$4|autore|autori}}]].',
	'code-stats-status-breakdown' => 'Numero di revisioni per stato',
	'code-stats-fixme-path' => 'Revisioni Fixme per il percorso: $1',
	'code-stats-new-path' => 'Nuove revisioni per il percorso: $1',
	'code-stats-count' => 'Numero di revisioni',
	'code-tooltip-withsummary' => 'r$1 [$2] di $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] di $3',
	'repoadmin' => 'Gestione dei repository',
	'repoadmin-new-legend' => 'Crea un nuovo repository',
	'repoadmin-new-label' => 'Nome del repository:',
	'repoadmin-new-button' => 'Crea',
	'repoadmin-edit-legend' => 'Modifica del repository: "$1"',
	'repoadmin-edit-path' => 'Percorso nel repository:',
	'repoadmin-edit-bug' => 'Percorso su Bugzilla:',
	'repoadmin-edit-view' => 'Percorso su ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'La modifica del repository "[[Special:Code/$1|$1]]" è stata completata correttamente.',
	'repoadmin-nav' => 'gestione dei repository',
	'right-repoadmin' => 'Gestione dei repository del codice',
	'right-codereview-use' => 'Utilizzo di Special:Code',
	'right-codereview-add-tag' => 'Aggiunge nuove etichette alle modifiche',
	'right-codereview-remove-tag' => 'Rimuove le etichette dalle modifiche',
	'right-codereview-post-comment' => 'Aggiunge commenti alle revisioni',
	'right-codereview-set-status' => 'Modifica lo stato delle revisioni',
	'right-codereview-signoff' => 'Sign-off di revisioni',
	'right-codereview-link-user' => 'Collega gli autori agli utenti del sito wiki',
	'right-codereview-associate' => 'Gestisce le associazioni fra revisioni',
	'right-codereview-review-own' => 'Segna le proprie revisioni come "OK" o "Risolto"',
	'specialpages-group-developer' => 'Tool di sviluppo',
	'group-svnadmins' => 'Amministratori SVN',
	'group-svnadmins-member' => '{{GENDER:$1|SVN admin}}',
	'grouppage-svnadmins' => '{{ns:project}}: amministratori SVN',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fievarsty
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Iwai.masaharu
 * @author Kanon und wikipedia
 * @author Naohiro19
 * @author Ohgi
 * @author Schu
 * @author Whym
 * @author 青子守歌
 */
$messages['ja'] = array(
	'code' => 'コードレビュー',
	'code-rev-title' => '第$1版 - コードレビュー',
	'code-comments' => 'コメント',
	'code-references' => '追補版',
	'code-change-status' => "$1 の'''状態'''を変更しました",
	'code-change-tags' => "$1 の'''タグ'''を変更しました",
	'code-change-removed' => '除去:',
	'code-change-added' => '追加:',
	'code-old-status' => '古い状態',
	'code-new-status' => '新しい状態',
	'code-prop-changes' => '状態とタグ付けのログ',
	'codereview-desc' => '[[Special:RepoAdmin|Subversion サポート]]付きの[[Special:Code|コードレビュー・ツール]]',
	'code-no-repo' => '設定されたリポジトリはありません！',
	'code-create-repo' => '[[Special:RepoAdmin|リポジトリ管理]]でリポジトリを作成',
	'code-need-repoadmin-rights' => 'リポジトリを作成するには、リポジトリ管理権限が必要です',
	'code-need-group-with-rights' => 'リポジトリ管理権限をもつ利用者グループがありません。新しいリポジトリを作成できるよう、リポジトリ管理権限をもつ利用者グループを作成してください。',
	'code-repo-not-found' => "レポジトリ '''$1''' は存在しません！",
	'code-load-diff' => '差分を読み込み中…',
	'code-notes' => '最近のコメント',
	'code-statuschanges' => '状態の変更',
	'code-mycommits' => '自分のコミット',
	'code-mycomments' => '自分のコメント',
	'code-authors' => '作者',
	'code-status' => '状態',
	'code-tags' => 'タグ',
	'code-tags-no-tags' => 'このリポジトリにはタグが存在しません。',
	'code-authors-text' => '以下はコミット名順の、リポジトリ作成者の一覧です。ローカルのウィキにおけるアカウントを括弧内に示します。データはキャッシュされている場合があります。',
	'code-author-haslink' => 'この作者はウィキ利用者 $1 とリンクされています',
	'code-author-orphan' => 'SVN 利用者 / 作者 $1 にはウィキアカウントとのリンクがありません',
	'code-author-dolink' => 'ウィキ利用者にこの作者をリンク :',
	'code-author-alterlink' => 'この作者にリンクされているウィキ利用者を変更:',
	'code-author-orunlink' => 'このウィキ利用者とのリンクを解除:',
	'code-author-name' => '利用者名の入力:',
	'code-author-success' => '作者 $1 はウィキ利用者 $2 とリンクされています',
	'code-author-link' => 'リンクをしますか？',
	'code-author-unlink' => 'リンクを解除しますか？',
	'code-author-unlinksuccess' => '作者 $1 のリンクは解除されました',
	'code-author-badtoken' => '当該操作を実行しようとしたところ、セッションエラーが発生しました。',
	'code-author-total' => '全作者数：$1',
	'code-author-lastcommit' => '最終コミット日',
	'code-browsing-path' => "'''$1''' のリビジョンを閲覧中",
	'code-field-id' => 'リビジョン',
	'code-field-author' => '作者',
	'code-field-user' => 'コメンター',
	'code-field-message' => 'コミット要約',
	'code-field-status' => '状態',
	'code-field-status-description' => 'ステータスの概要',
	'code-field-timestamp' => '日付',
	'code-field-comments' => 'コメント',
	'code-field-path' => 'パス',
	'code-field-text' => 'コメント',
	'code-field-select' => '選択',
	'code-reference-remove' => '選択された関連付けを除去',
	'code-reference-associate' => '追補版を関連付け：',
	'code-reference-associate-submit' => '関連付け',
	'code-rev-author' => '作者:',
	'code-rev-date' => '日付:',
	'code-rev-message' => 'コメント:',
	'code-rev-repo' => 'リポジトリ:',
	'code-rev-rev' => 'リビジョン:',
	'code-rev-rev-viewvc' => 'ViewVC',
	'code-rev-paths' => '変更されたパス:',
	'code-rev-modified-a' => '追加',
	'code-rev-modified-r' => '置換',
	'code-rev-modified-d' => '削除',
	'code-rev-modified-m' => '変更',
	'code-rev-imagediff' => '画像の変更',
	'code-rev-status' => '状態:',
	'code-rev-status-set' => '状態を変更する',
	'code-rev-tags' => 'タグ:',
	'code-rev-tag-add' => 'タグを追加:',
	'code-rev-tag-remove' => 'タグを除去:',
	'code-rev-comment-by' => '$1 によるコメント',
	'code-rev-comment-preview' => 'プレビュー',
	'code-rev-inline-preview' => 'プレビュー:',
	'code-rev-diff' => '差分',
	'code-rev-diff-link' => '差分',
	'code-rev-diff-too-large' => '差分が大きすぎて表示出来ません。',
	'code-rev-purge-link' => 'パージ',
	'code-rev-total' => '結果の合計数: $1',
	'code-rev-not-found' => "リビジョン '''$1''' は存在しません！",
	'code-rev-history-link' => '履歴',
	'code-status-new' => '新規',
	'code-status-desc-new' => 'リビジョンは操作を保留中です（既定の状態）。',
	'code-status-fixme' => '要修正',
	'code-status-desc-fixme' => 'リビジョンにはバグがあるか壊れています。修正又は元に戻す必要があります。',
	'code-status-reverted' => '差し戻し済み',
	'code-status-desc-reverted' => 'リビジョンは、以降の版で廃棄されました。',
	'code-status-resolved' => '解決済',
	'code-status-desc-resolved' => 'リビジョンは、問題があり、以降の版で上書きされました。',
	'code-status-ok' => '問題なし',
	'code-status-desc-ok' => 'リビジョンは充分にレビューされ、レビューアーはどの点から見ても確かに大丈夫だと確認しました。',
	'code-status-deferred' => '保留中',
	'code-status-desc-deferred' => 'リビジョンはレビューを必要としていません。',
	'code-status-old' => '古',
	'code-status-desc-old' => '潜在的なバグがあるが、レビューする価値がない古いリビジョン',
	'code-signoffs' => 'サインオフ',
	'code-signoff-legend' => 'サインオフを追加',
	'code-signoff-submit' => 'サインオフ',
	'code-signoff-strike' => '選択されたサインオフを取り消し',
	'code-signoff-signoff' => 'このリビジョンを以下のようにサインオフ：',
	'code-signoff-flag-inspected' => '検査済',
	'code-signoff-flag-tested' => 'テスト済',
	'code-signoff-field-user' => 'ユーザー',
	'code-signoff-field-flag' => 'フラグ',
	'code-signoff-field-date' => '日付',
	'code-signoff-struckdate' => '$1（$2に取り消し）',
	'code-pathsearch-legend' => 'このリポジトリ内のリビジョンをパスで検索',
	'code-pathsearch-path' => 'パス:',
	'code-pathsearch-filter' => '表示限定：',
	'code-revfilter-cr_status' => '状態 = $1',
	'code-revfilter-cr_author' => '作者 = $1',
	'code-revfilter-ct_tag' => 'タグ = $1',
	'code-revfilter-clear' => 'フィルターのクリア',
	'code-rev-submit' => '変更を保存',
	'code-rev-submit-next' => '保存し、次の未解決に移る',
	'code-rev-next' => '次の未解決案件',
	'code-batch-status' => '状態を変更:',
	'code-batch-tags' => 'タグを変更:',
	'codereview-batch-title' => '選択したリビジョンをすべて変更',
	'codereview-batch-submit' => '送信',
	'code-releasenotes' => 'リリースノート',
	'code-release-legend' => 'リリースノートの生成',
	'code-release-startrev' => '開始リビジョン:',
	'code-release-endrev' => '最終リビジョン:',
	'codereview-subtitle' => '$1',
	'codereview-reply-link' => '返信',
	'codereview-overview-title' => '概要',
	'codereview-overview-desc' => 'このリストのグラフィカルな概要を表示',
	'codereview-email-subj' => '[$1 $2]: 新規コメント追加',
	'codereview-email-body' => '利用者「$1」が $3 にコメントをつけました。

URL: $2
要約:

$5

コメント:

$4',
	'codereview-email-subj2' => '[$1 $2]: 追補の変更',
	'codereview-email-body2' => '利用者「$1」が$2に追補の変更を加えました。

追補版のURL：$5
要約:

$6

URL：$3
要約：

$4',
	'codereview-email-subj3' => '[$1 $2]: リビジョンの状態が変更されました',
	'codereview-email-body3' => '利用者「$1」が、$2の状態を変更しました。

もとの状態: $3
新しい状態: $4

URL: $5
要約:

$6',
	'codereview-email-subj4' => '[$1 $2]: 新しいコメントが追加され、リビジョンの状態が変更されました',
	'codereview-email-body4' => '利用者「$1」が、$2の状態を変更しました。

もとの状態：$3
新しい状態：$4

利用者「$1」は$2にコメントも投稿しました。

URL：$5
要約:

$7

コメント：

$6',
	'code-stats' => '統計',
	'code-stats-header' => 'レポジトリ$1の統計情報',
	'code-stats-main' => '$1現在、レポジトリには[[Special:Code/$3/author|$4 人の作者]]による$2個のリビジョンがあります。',
	'code-stats-status-breakdown' => '状態ごとのリビジョン数',
	'code-stats-fixme-breakdown' => '作者毎の要修正リビジョンの内訳',
	'code-stats-fixme-breakdown-path' => 'パス毎の要修正リビジョンの内訳',
	'code-stats-fixme-path' => '要修正リビジョンへのパス : $1',
	'code-stats-new-breakdown' => '作者毎の新規リビジョンの内訳',
	'code-stats-count' => '版数',
	'code-tooltip-withsummary' => '$3 - $4 により r$1 [$2]',
	'code-tooltip-withoutsummary' => '$3 により r$1 [$2]',
	'repoadmin' => 'リポジトリ管理',
	'repoadmin-new-legend' => '新規リポジトリを作成',
	'repoadmin-new-label' => 'リポジトリ名:',
	'repoadmin-new-button' => '作成',
	'repoadmin-edit-legend' => 'リポジトリ "$1" の変更',
	'repoadmin-edit-path' => 'リポジトリのパス:',
	'repoadmin-edit-bug' => 'Bugzilla パス:',
	'repoadmin-edit-view' => 'ViewVC パス:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'リポジトリ "[[Special:Code/$1|$1]]" の変更に成功しました。',
	'repoadmin-nav' => 'リポジトリ管理',
	'right-repoadmin' => 'コードリポジトリを管理',
	'right-codereview-use' => 'Special:Code の使用',
	'right-codereview-add-tag' => 'リビジョンに新しいタグを追加',
	'right-codereview-remove-tag' => 'リビジョンからタグを除去',
	'right-codereview-post-comment' => 'リビジョンにコメントを追加',
	'right-codereview-set-status' => 'リビジョンの状態を変更',
	'right-codereview-signoff' => 'リビジョンでサインオフ',
	'right-codereview-link-user' => '作者とウィキ利用者をリンク',
	'right-codereview-associate' => '版のつながりを管理する',
	'right-codereview-review-own' => 'OK または解決済みとして自身のリビジョンをマーク',
	'specialpages-group-developer' => '開発者用ツール',
	'group-svnadmins' => 'SVN管理者',
	'group-svnadmins-member' => 'SVN管理者',
	'grouppage-svnadmins' => '{{ns:project}}:SVN管理者',
);

/** Javanese (Basa Jawa)
 * @author Pras
 */
$messages['jv'] = array(
	'code' => 'Pamriksan kodhe',
	'code-comments' => 'Komentar',
	'code-change-status' => "ngowahi '''status''' saka $1",
	'code-change-tags' => "ngowahi '''tag''' saka $1",
	'code-change-removed' => 'busak:',
	'code-change-added' => 'ditambahaké:',
	'code-prop-changes' => "Log pamasangan ''tag'' & status",
	'codereview-desc' => '[[Special:Code|piranti pamriksan kodhe]] kanthi [[Special:RepoAdmin|dhukungan anak-vèrsi]]',
	'code-no-repo' => "Ora ana panyimpenan (''repository'') kang dipilih (''configured'')",
	'code-notes' => 'Komentar anyar',
	'code-authors' => 'pangarang',
	'code-tags' => "tandha (''tag'')",
	'code-authors-text' => 'Ing ngisor iki dhaptar pangarang repo diurut miturut komit anyar. Akun wiki lokal bakal ditampilake jroning tandha kurung.',
	'code-author-haslink' => 'Pangarang iki kahubung menyang panganggo wiki $1',
	'code-author-orphan' => 'Pangarang iki ora kahubung menyang sawijining akun wiki',
	'code-author-dolink' => 'Hubungaké pangarang iki menyang sawijining panganggo wiki',
	'code-author-alterlink' => 'Owahi panganggo wiki sing kahubung menyang pangarang iki',
	'code-author-orunlink' => "Utawa copot hubungan (''unlink'') panganggo wiki iki",
	'code-author-name' => 'Lebokaké jeneng panganggo',
	'code-author-success' => "Pangarang $1 wis kahubungaké (''linked'') menyang panganggo wiki $2",
	'code-author-link' => 'hubungan?/sambungan?',
	'code-author-unlink' => "copot hubungan (''unlink'')?",
	'code-author-unlinksuccess' => "Pangarang $1 wis di copot-hubung (''unlink'')",
	'code-field-id' => 'Révisi',
	'code-field-author' => 'Pangarang',
	'code-field-user' => 'Sing awèh komentar',
	'code-field-message' => "Ringkesan ''commit''",
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Tanggal',
	'code-field-comments' => 'Cathetan',
	'code-field-path' => 'Jalur',
	'code-field-text' => 'Cathetan',
	'code-rev-author' => 'Pangarang',
	'code-rev-date' => 'Tanggal',
	'code-rev-message' => 'Komentar',
	'code-rev-repo' => "Panyimpenan (''repository''):",
	'code-rev-rev' => 'Révisi',
	'code-rev-rev-viewvc' => "ing ''ViewVC''",
	'code-rev-paths' => 'Jalur sing wis dimodhifikasi',
	'code-rev-modified-a' => 'ditambahaké',
	'code-rev-modified-r' => 'diganti',
	'code-rev-modified-d' => 'dibusak',
	'code-rev-modified-m' => 'dimodhifikasi',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status pangowahan',
	'code-rev-tags' => "Tandha (''tag''):",
	'code-rev-tag-add' => "Tambahi tandha (''tag''):",
	'code-rev-tag-remove' => 'Busak tandha',
	'code-rev-comment-by' => 'Komentar déning $1',
	'code-rev-comment-preview' => 'Pratayang',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-purge-link' => 'Resiki',
	'code-status-new' => 'anyar',
	'code-status-fixme' => 'dandani',
	'code-status-reverted' => 'dibalèkaké',
	'code-status-resolved' => 'diputusaké',
	'code-status-ok' => 'ok',
	'code-status-deferred' => 'ditundha',
	'code-pathsearch-legend' => 'Golèki révisi ing jalur repo iki',
	'code-pathsearch-path' => 'Jalur/lintasan',
	'code-rev-submit' => 'Simpen owah-owahan',
	'code-rev-submit-next' => 'Simpen & durung-bèrès sabanjuré',
	'codereview-reply-link' => 'wales/walesan',
	'codereview-email-subj' => '[$1 $2]: Komentar anyar ditambahaké',
	'codereview-email-body' => 'Panganggo "$1" awèh komentar ing $3.

URL jangkep: $2

Komentar:

$4',
	'repoadmin' => "Administrasi Panyimpenan (''repository'')",
	'repoadmin-new-legend' => "Gawé panyimpenan (''repository'') anyar",
	'repoadmin-new-label' => "Jeneng panyimpenan (''repository''):",
	'repoadmin-new-button' => 'Gawé',
	'repoadmin-edit-legend' => "Modhifikasi panyimpenan (''repository'') \"\$1\"",
	'repoadmin-edit-path' => "Jalur/lintasan panyimpenan (''repository''):",
	'repoadmin-edit-bug' => 'Jalur Bugzilla',
	'repoadmin-edit-view' => "Jalur ''ViewVC'':",
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Panyimpenan (\'\'repository\'\') "[[Special:Code/$1|$1]]" wis kasil dimodhifikasi.',
	'right-repoadmin' => 'Tata kodhe panyimpenan',
	'right-codereview-add-tag' => 'Tambahaké tandha anyar ing révisi',
	'right-codereview-remove-tag' => 'Busak tandha saka révisi',
	'right-codereview-post-comment' => 'Tambahaké komentar ing révisi',
	'right-codereview-set-status' => 'Owahi status révisi',
	'right-codereview-link-user' => 'Hubungaké pangarang menyang panganggo wiki',
	'specialpages-group-developer' => 'Piranti déveloper',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author Dawid Deutschland
 * @author ITshnik
 * @author Malafaya
 * @author გიორგიმელა
 */
$messages['ka'] = array(
	'code' => 'კოდის შემოწმება',
	'code-rev-title' => '$1 – კოდის შემოწმება',
	'code-comments' => 'კომენტარები:',
	'code-change-removed' => 'წაშლილია:',
	'code-change-added' => 'დაემატა:',
	'code-old-status' => 'ძველი სტატუსი',
	'code-new-status' => 'ახალი სტატუსი',
	'code-load-diff' => 'იტვირთება განსხ…',
	'code-notes' => 'ბოლო კომენტარები',
	'code-statuschanges' => 'სტატუსის შეცვლა',
	'code-mycomments' => 'ჩემი კომენტარები',
	'code-authors' => 'ავტორები',
	'code-tags' => 'აღნიშვნები',
	'code-author-orphan' => 'ამ ავტორს არ აქვს ვიკი-ანგარიშის ბმული',
	'code-author-name' => 'მომხმარებლის სახელის შეტანა:',
	'code-author-link' => 'კავშირის დამყარება?',
	'code-author-unlink' => 'კავშირის მოხსნა?',
	'code-author-total' => 'ავტორთა საერთო რაოდენობა: $1',
	'code-field-id' => 'ვერსია',
	'code-field-author' => 'ავტორი',
	'code-field-user' => 'კომენტატორი',
	'code-field-message' => 'კომენტარი',
	'code-field-status' => 'სტატუსი',
	'code-field-status-description' => 'სტატუსის აღწერა',
	'code-field-timestamp' => 'თარიღი',
	'code-field-comments' => 'კომენტარები',
	'code-field-path' => 'გზა',
	'code-field-text' => 'შენიშვნა',
	'code-field-select' => 'არჩევა',
	'code-rev-author' => 'ავტორი:',
	'code-rev-date' => 'თარიღი:',
	'code-rev-message' => 'კომენტარი:',
	'code-rev-repo' => 'საცავი:',
	'code-rev-rev' => 'ვერსია:',
	'code-rev-modified-a' => 'დაემატა',
	'code-rev-modified-r' => 'ჩაენაცვლა',
	'code-rev-modified-d' => 'წაშლილი',
	'code-rev-modified-m' => 'განახლებული',
	'code-rev-imagediff' => 'სურათის ცვლილებები',
	'code-rev-status' => 'სტატუსი:',
	'code-rev-status-set' => 'სტატუსის შეცვლა',
	'code-rev-tags' => 'ღილაკები:',
	'code-rev-tag-remove' => 'წაშალეთ მინიშნებები:',
	'code-rev-comment-by' => '$1-ს კომენტარი',
	'code-rev-comment-preview' => 'წინასწარ',
	'code-rev-inline-preview' => 'წინასწარ:',
	'code-rev-diff' => 'განსხ',
	'code-rev-diff-link' => 'განსხ.',
	'code-rev-diff-too-large' => 'ცვლილება ვერსიებს შორის ზედმეტად დიდია საჩვენებლად',
	'code-rev-purge-link' => 'ქეშის გაწმენდა',
	'code-rev-total' => 'რეზულტატების რაოდენობა:$1',
	'code-rev-not-found' => "ვერსია '''$1''' არ არსებობს!",
	'code-rev-history-link' => 'ისტორია',
	'code-status-new' => 'ახალი',
	'code-status-fixme' => 'შემოწმება',
	'code-status-reverted' => 'გაუქმებულია',
	'code-status-resolved' => 'მოგვარებულია',
	'code-status-desc-resolved' => 'ვერსიას ჰქონდა პრობლემა, რომელიც შემდგომ ვერსიაში გამოსწორდა.',
	'code-status-ok' => 'ok',
	'code-status-deferred' => 'გადატანილია',
	'code-status-old' => 'ძველი',
	'code-signoff-flag-tested' => 'დაცდილი',
	'code-signoff-field-user' => 'მომხმარებელი',
	'code-signoff-field-flag' => 'დროშა',
	'code-signoff-field-date' => 'თარიღი',
	'code-pathsearch-legend' => 'კონკრეტული რედაქციების ძიება ამ საცავში მისამართის მიხედვით',
	'code-pathsearch-path' => 'გზა:',
	'code-pathsearch-filter' => 'გამოყენებული ფილტრები:',
	'code-revfilter-cr_status' => 'სტატუსი = $1',
	'code-revfilter-cr_author' => 'ავტორი = $1',
	'code-revfilter-clear' => 'ფილტრის მოხსნა:',
	'code-rev-submit' => 'ცვლილებების შენახვა',
	'code-rev-submit-next' => 'შეინახეთ და გადასვლა შემდეგ გადაუწყვეტელზე',
	'code-batch-status' => 'სტატუსის შეცვლა:',
	'code-batch-tags' => 'შეცვალეთ მინიშნებები:',
	'codereview-batch-title' => 'შეცვალეთ ყველა არჩეული რევიზია',
	'codereview-batch-submit' => 'გაგზავნა',
	'code-releasenotes' => 'ინფორმაცია გამოშვების შესახებ',
	'code-release-legend' => 'გამოცემაზე ინფორმაციის შექმნა',
	'code-release-startrev' => 'საწყისი რევიზია:',
	'code-release-endrev' => 'ბოლო რევიზია:',
	'codereview-subtitle' => '$1-სთვის',
	'codereview-reply-link' => 'პასუხი',
	'codereview-email-subj' => '[$1 $2]: დაემატა ახალი კომენტარი',
	'codereview-email-body' => 'მომხმარებელმა "$1" დადო კომენტარი $3-ზე.

ბმული: $2

კომენტარი:

$4',
	'codereview-email-body3' => 'მომხმარებელმა „$1“ შეცვალა $2-ის სტატუსი.

ძველი სტატუსი: $3

ახალი სტატუსი: $4',
	'code-stats' => 'სტატისტიკა',
	'repoadmin-new-button' => 'შექმნა',
	'repoadmin-edit-button' => 'კარგი',
	'repoadmin-edit-sucess' => 'საცავი «[[Special:Code/$1|$1]]» წარმატებით შეიცვალა',
	'right-repoadmin' => 'კოდების საცავის მართვა',
	'right-codereview-use' => 'Special:Code-ის გამოყენება',
	'right-codereview-add-tag' => 'რედაქიებისთვის მინიშნებების ჩამატება',
	'right-codereview-remove-tag' => 'რედაქციების მინიშნებების მართვა',
	'right-codereview-post-comment' => 'რედაქციისთვის კომენტარის ჩამატება',
	'right-codereview-set-status' => 'რედაქციის სტატუსის ცვლილება',
	'right-codereview-link-user' => 'ვიკიპროექტელებისა და რედაქციების კავშირი',
	'specialpages-group-developer' => 'შემქმნელის ხელსაწყოები',
	'group-svnadmins' => 'SVN ადმინისტრატორები',
	'group-svnadmins-member' => 'SVN ადმინისტრატორი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 * @author វ័ណថារិទ្ធ
 */
$messages['km'] = array(
	'code-comments' => 'យោបល់',
	'code-change-removed' => 'លុបចេញ​៖',
	'code-change-added' => 'បន្ថែម​៖',
	'code-old-status' => 'ស្ថានភាពចាស់',
	'code-new-status' => 'ស្ថានភាពថ្មី',
	'code-notes' => 'យោបល់ថ្មីៗ',
	'code-statuschanges' => 'បំលាស់ប្ដូរ​ស្ថានភាព',
	'code-mycomments' => 'យោបល់របស់ខ្ញុំ',
	'code-authors' => 'អ្នកនិពន្ធ',
	'code-status' => 'ស្ថានភាព',
	'code-tags' => 'ប្លាក',
	'code-author-haslink' => '​អ្នកនិពន្ធ​នេះត្រូវ​បាន​តភ្ជាប់​ទៅ​នឹង​អ្នក​ប្រើប្រាស់​​វិគី​​ ​$1',
	'code-author-orphan' => '​អ្នកនិពន្ធ​នេះមិន​មាន​តំណភ្ជាប់​ជាមួយ​គណនី​វិគី​ទេ​',
	'code-author-dolink' => 'តភ្ជាប់​អ្នកនិពន្ធ​នេះ​ទៅនឹង​អ្នក​ប្រើប្រាស់​វិគី​៖',
	'code-author-name' => 'បញ្ចូលអត្តនាម៖',
	'code-author-link' => 'តំណភ្ជាប់?',
	'code-author-unlink' => 'មិន​ដាក់​តំណភ្ជាប់​?',
	'code-author-total' => 'ចំនួនអ្នកនិពន្ធសរុប៖ $1',
	'code-field-id' => 'ពិនិត្យឡើងវិញ',
	'code-field-author' => 'អ្នកនិពន្ធ',
	'code-field-user' => 'អ្នកផ្ដល់យោបល់',
	'code-field-status' => 'ស្ថានភាព',
	'code-field-timestamp' => 'កាលបរិច្ឆេទ',
	'code-field-comments' => 'យោបល់',
	'code-field-path' => 'ផ្លូវ',
	'code-field-text' => 'កំណត់សម្គាល់',
	'code-field-select' => 'ជ្រើសយក',
	'code-rev-author' => 'អ្នកនិពន្ធ៖',
	'code-rev-date' => 'កាលបរិច្ឆេទ៖',
	'code-rev-message' => 'យោបល់៖',
	'code-rev-repo' => 'ឃ្លាំង​៖',
	'code-rev-rev' => 'ពិនិត្យឡើងវិញ​៖',
	'code-rev-modified-a' => 'បានបន្ថែម',
	'code-rev-modified-r' => 'បាន​ជំនួស',
	'code-rev-modified-d' => 'បានលុប',
	'code-rev-modified-m' => 'បានកែសម្រួល',
	'code-rev-imagediff' => 'បំលាស់ប្ដូររូបភាព',
	'code-rev-status' => 'ស្ថានភាព​៖',
	'code-rev-status-set' => 'ផ្លាស់ប្ដូរ​ស្ថានភាព',
	'code-rev-tags' => 'ប្លាក៖',
	'code-rev-tag-add' => 'បន្ថែមប្លាក៖',
	'code-rev-tag-remove' => 'ដកស្លាក​ចេញ៖',
	'code-rev-comment-by' => 'យោបល់របស់ $1',
	'code-rev-comment-preview' => 'មើលជាមុន',
	'code-rev-inline-preview' => 'ការមើលជាមុន៖',
	'code-rev-diff' => 'ភាពខុសគ្នា',
	'code-rev-diff-link' => 'ភាពខុសគ្នា',
	'code-status-new' => 'ថ្មី',
	'code-status-resolved' => 'ត្រូវ​បាន​ដោះស្រាយ​រួច​',
	'code-status-ok' => 'យល់ព្រម',
	'code-pathsearch-path' => 'ផ្លូវ៖',
	'code-rev-submit' => 'រក្សាទុក​បំលាស់ប្ដូរ',
	'code-batch-status' => 'ផ្លាស់ប្ដូរ​ស្ថានភាព​៖',
	'code-batch-tags' => 'ផ្លាស់ប្ដូរស្លាក​៖​',
	'codereview-batch-submit' => 'ដាក់ស្នើ',
	'code-releasenotes' => 'កំណត់​ចំណាំ​​ការ​ចេញ​ផ្សាយ​',
	'codereview-reply-link' => 'ឆ្លើយតប',
	'code-stats' => 'ស្ថិតិ',
	'repoadmin' => 'ការគ្រប់គ្រង​ឃ្លាំង',
	'repoadmin-new-legend' => 'បង្កើត​ឃ្លាំង​ថ្មី',
	'repoadmin-new-label' => 'ឈ្មោះ​ឃ្លាំង​៖',
	'repoadmin-new-button' => 'បង្កើត',
	'repoadmin-edit-path' => 'ផ្លូវ​ឃ្លាំង​៖',
	'repoadmin-edit-bug' => 'ផ្លូវ​ Bugzilla ៖',
	'repoadmin-edit-view' => 'ផ្លូវ​ ViewVC ៖',
	'repoadmin-edit-button' => 'យល់ព្រម',
	'right-repoadmin' => 'គ្រប់​គ្រង​ឃ្លាំង​កូដ​',
	'right-codereview-use' => 'ការប្រើប្រាស់​នៃ​ពិសេស​៖កូដ​',
	'specialpages-group-developer' => 'ឧបករណ៍​អ្នកអភិវឌ្ឍ',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 */
$messages['kn'] = array(
	'code-field-id' => 'ಆವೃತ್ತಿ',
	'code-field-author' => 'ಕರ್ತೃ',
	'code-field-status' => 'ಸ್ಥಾನಮಾನ',
	'code-field-timestamp' => 'ದಿನಾಂಕ',
	'code-rev-author' => 'ಕರ್ತೃ:',
	'code-rev-date' => 'ದಿನಾಂಕ:',
	'code-rev-rev' => 'ಆವೃತ್ತಿ:',
	'code-rev-status' => 'ಸ್ಥಾನಮಾನ:',
	'code-rev-comment-preview' => 'ಮುನ್ನೋಟ',
	'code-rev-inline-preview' => 'ಮುನ್ನೋಟ:',
	'code-status-new' => 'ಹೊಸ',
	'code-revfilter-cr_status' => 'ಸ್ಥಾನಮಾನ = $1',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Devunt
 * @author Ilovesabbath
 * @author Klutzy
 * @author Kwj2772
 * @author Yknok29
 */
$messages['ko'] = array(
	'code' => '코드 검토',
	'code-rev-title' => '$1 - 코드 검토',
	'code-comments' => '의견',
	'code-references' => '추적 수정',
	'code-change-status' => "제$1판의 '''상태'''를 변경",
	'code-change-tags' => "제$1판의 '''태그'''를 변경",
	'code-change-removed' => '제거:',
	'code-change-added' => '추가:',
	'code-old-status' => '변경 전 상태',
	'code-new-status' => '변경 후 상태',
	'code-prop-changes' => '상태 및 태그 변경 기록',
	'codereview-desc' => '[[Special:RepoAdmin|서브버전을 지원]]하는 [[Special:Code|코드 검토 도구]]',
	'code-no-repo' => '저장소가 설정되지 않았습니다!',
	'code-create-repo' => '저장소를 설치하려면 [[Special:RepoAdmin|RepoAdmin]]으로 가십시오',
	'code-need-repoadmin-rights' => '저장소를 만들려면 repoadmin 권한이 필요합니다.',
	'code-need-group-with-rights' => 'repoadmin 권한을 가진 그룹이 없습니다. 새 저장소를 만들기 위해 그룹을 추가해주세요.',
	'code-repo-not-found' => "'''$1''' 저장소가 존재하지 않습니다!",
	'code-load-diff' => '차이를 불러오는 중…',
	'code-notes' => '최근 의견',
	'code-statuschanges' => '상태 변경',
	'code-mycommits' => '내 커밋',
	'code-mycomments' => '내 의견',
	'code-authors' => '만든이',
	'code-status' => '상태',
	'code-tags' => '태그',
	'code-authors-text' => '다음은 커밋 이름 순으로 정렬한 저장소의 저자 목록입니다. 이 위키에서의 계정 이름은 괄호 안에 있습니다. 데이터는 캐시될 수 있습니다.',
	'code-author-haslink' => '이 만든이는 위키 사용자 $1로 연결되어 있습니다.',
	'code-author-orphan' => 'SVN의 $1 기여자가 위키 계정과 연결되어 있지 않습니다.',
	'code-author-dolink' => '이 저자를 위키 사용자로 연결하세요:',
	'code-author-alterlink' => '해당 기여자에 연결된 위키 계정을 변경:',
	'code-author-orunlink' => '이 위키 사용자로의 링크를 제거하세요:',
	'code-author-name' => '사용자 이름을 입력하십시오:',
	'code-author-success' => '제작자 $1은(는) 위키 사용자 $2(으)로 연결되었습니다.',
	'code-author-link' => '링크하시겠습니까?',
	'code-author-unlink' => '링크를 해제하시겠습니까?',
	'code-author-unlinksuccess' => '저자 $1(으)로의 링크가 제거돼 있습니다.',
	'code-author-badtoken' => '이 동작을 수행하는 중 세션 오류가 발생했습니다.',
	'code-author-total' => '총 저자의 수: $1',
	'code-browsing-path' => "'''$1'''에서 판 보기",
	'code-field-id' => '버전',
	'code-field-author' => '작성자',
	'code-field-user' => '의견 작성자',
	'code-field-message' => '코드 적용 요약',
	'code-field-status' => '상태',
	'code-field-timestamp' => '날짜',
	'code-field-comments' => '의견',
	'code-field-path' => '경로',
	'code-field-text' => '노트',
	'code-field-select' => '선택',
	'code-rev-author' => '만든이:',
	'code-rev-date' => '날짜:',
	'code-rev-message' => '의견:',
	'code-rev-repo' => '저장소:',
	'code-rev-rev' => '버전:',
	'code-rev-rev-viewvc' => 'ViewVC에서 보기',
	'code-rev-paths' => '변경된 파일의 경로:',
	'code-rev-modified-a' => '추가됨',
	'code-rev-modified-r' => '대체됨',
	'code-rev-modified-d' => '삭제됨',
	'code-rev-modified-m' => '수정됨',
	'code-rev-imagediff' => '그림 변경',
	'code-rev-status' => '상태:',
	'code-rev-status-set' => '상태 변경',
	'code-rev-tags' => '태그:',
	'code-rev-tag-add' => '태그 추가:',
	'code-rev-tag-remove' => '태그 제거:',
	'code-rev-comment-by' => '$1의 의견',
	'code-rev-comment-preview' => '미리 보기',
	'code-rev-inline-preview' => '미리보기:',
	'code-rev-diff' => '차이',
	'code-rev-diff-link' => '차이',
	'code-rev-diff-too-large' => '이 비교는 너무 커 출력하지 못합니다',
	'code-rev-purge-link' => '새로 고침',
	'code-rev-total' => '결과의 총 개수: $1',
	'code-rev-history-link' => '역사',
	'code-status-new' => '신규',
	'code-status-fixme' => '수정 필요',
	'code-status-reverted' => '되돌려짐',
	'code-status-resolved' => '해결됨',
	'code-status-ok' => '문제없음',
	'code-status-deferred' => '보류됨',
	'code-status-old' => '오래됨',
	'code-signoff-field-user' => '사용자',
	'code-signoff-field-date' => '날짜',
	'code-pathsearch-legend' => '이 보관소(repo)에서 있었던 수정 사항을 경로로 검색하기',
	'code-pathsearch-path' => '경로:',
	'code-pathsearch-filter' => '필터 적용됨:',
	'code-revfilter-cr_status' => '상태 = $1',
	'code-revfilter-cr_author' => '프로그래머 = $1',
	'code-revfilter-ct_tag' => '태그 = $1',
	'code-revfilter-clear' => '클리어 필터',
	'code-rev-submit' => '저장',
	'code-rev-submit-next' => '저장 및 다음 미해결된 문서로 이동',
	'code-batch-status' => '상태 변경:',
	'code-batch-tags' => '태그 변경:',
	'codereview-batch-title' => '모든 선택된 판을 수정',
	'codereview-batch-submit' => '제출',
	'code-releasenotes' => '배포 노트',
	'code-release-legend' => '배포 노트 만들기',
	'code-release-startrev' => '시작 버전:',
	'code-release-endrev' => '마지막 버전:',
	'codereview-subtitle' => '$1',
	'codereview-reply-link' => '답변',
	'codereview-overview-title' => '둘러보기',
	'codereview-email-subj' => '[$1] [$2판]: 새 의견이 추가되었습니다.',
	'codereview-email-body' => '"$1" 사용자가 $3판에 대해 의견을 올렸습니다.
URL: $2

$3판에 대한 요약:

$5

내용:

$4',
	'codereview-email-subj2' => '[$1 $2]: 추적된 변경 사항',
	'codereview-email-body2' => '사용자 "$1"이/가 $2에 추적변경을 만들었습니다.

전체 URL: $3

변경 요약:

$4',
	'codereview-email-subj3' => '[$1 $2]: 버전 상태가 바뀌었습니다',
	'codereview-email-body3' => '"$1" 사용자가 $2판의 상태를 "$4"로 바꾸었습니다.
URL: $5

이전 상태: $3
바뀐 상태: $4

$2판에 대한 커밋 요약:

$6',
	'code-stats' => '통계',
	'code-stats-header' => '$1 저장소 통계',
	'code-stats-main' => '$6 $5 기준으로, 이 저장소에는 [[Special:Code/$3/author|$4명의 저자]]가 작성한 $2개의 판이 있습니다.',
	'code-stats-status-breakdown' => '상태별 판의 개수',
	'code-stats-fixme-breakdown' => '저자별 수정이 필요한 판의 개수',
	'code-stats-fixme-breakdown-path' => '경로별 수정이 필요한 판의 개수',
	'code-stats-fixme-path' => '$1 경로의 수정이 필요한 판',
	'code-stats-count' => '전체 편집 횟수',
	'code-tooltip-withsummary' => '$1판 $3 사용자의 [$2] - $4',
	'code-tooltip-withoutsummary' => '$1판 $3 사용자의 [$2]',
	'repoadmin' => '저장소 관리',
	'repoadmin-new-legend' => '새 저장소 만들기',
	'repoadmin-new-label' => '저장소 이름:',
	'repoadmin-new-button' => '생성',
	'repoadmin-edit-legend' => '저장소 "$1" 수정하기',
	'repoadmin-edit-path' => '저장소 경로:',
	'repoadmin-edit-bug' => '버그질라 경로:',
	'repoadmin-edit-view' => 'ViewVC 경로:',
	'repoadmin-edit-button' => '확인',
	'repoadmin-edit-sucess' => '저장소 "[[Special:Code/$1|$1]]"이 성공적으로 변경되었습니다.',
	'repoadmin-nav' => '저장소 관리',
	'right-repoadmin' => '코드 저장소 관리',
	'right-codereview-use' => 'Special:Code 사용',
	'right-codereview-add-tag' => '특정 버전에 새로운 태그를 달기',
	'right-codereview-remove-tag' => '특정 버전의 태그를 제거',
	'right-codereview-post-comment' => '바뀐 코드에 대한 의견을 추가',
	'right-codereview-set-status' => '판의 상태를 변경',
	'right-codereview-link-user' => '만든이를 위키 사용자로 링크',
	'specialpages-group-developer' => '개발자 도구',
	'group-svnadmins' => 'SVN 관리자',
	'group-svnadmins-member' => '{{GENDER:$1|SVN 관리자}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN 관리자',
);

/** Colognian (Ripoarisch)
 * @author McDutchie
 * @author Purodha
 */
$messages['ksh'] = array(
	'code' => 'Projramm-Änderunge verwallde',
	'code-rev-title' => '$1 - Programm-Änderunge nohloore',
	'code-comments' => 'Kommäntaare',
	'code-references' => 'De Versione donoh',
	'code-change-status' => "hät der '''Shtattus''' vun de Version $1 verändert",
	'code-change-tags' => "hät de '''Makeerunge''' vun dä Version $1 verändert",
	'code-change-removed' => 'eruß jenomme:',
	'code-change-added' => 'dobei jedonn:',
	'code-old-status' => 'Der ahle Stattus',
	'code-new-status' => 'Der neue Shtattus',
	'code-prop-changes' => 'Logboch för Shtattus un Makeerunge',
	'codereview-desc' => 'Werkzüch för [[Special:Code|Projramm-Änderunge ze verwallde]] met [[Special:RepoAdmin|Ongershtözung för <i lang="en">Subversion</i>]]',
	'code-no-repo' => 'Et es kei Repositorijum enjeshtallt.',
	'code-create-repo' => 'Jangk op di Sigg <i lang="en">[[Special:RepoAdmin|RepoAdmin]]</i>, öm e neu Repositorijum aanzelääje.',
	'code-need-repoadmin-rights' => 'Do mööts dat Rääsch <code lang="en">repoadmin</code> han, öm e Repositorijum neu aanlääje ze künne.',
	'code-need-group-with-rights' => 'Et jitt kein Jropp met däm Rääsch <code lang="en">repoadmin</code>.
Donn ein aanlääje, domet et müjjelesch wääde kann, heh e neu Repositorijum aanzelääje.',
	'code-repo-not-found' => "E Repositorijum '''$1''' jidd_et heh nit!",
	'code-load-diff' => 'Ben de Ungerscheide aam Lade&#160;…',
	'code-notes' => 'De neuste Bemerkunge',
	'code-statuschanges' => 'Änderunge aam Stattus',
	'code-mycommits' => 'ming Beidrääsch',
	'code-mycomments' => 'ming Aanmärkunge',
	'code-authors' => 'de Schriiver',
	'code-status' => 'Shtattuße',
	'code-tags' => 'Makeerunge',
	'code-tags-no-tags' => 'Mer han kein Makeerunge en dämm Repositorijum.',
	'code-authors-text' => 'Hee kütt en Leß met dä Schriever aan dämm Repositorijum, zotteet noh dänne iehre Name doh. De Name als Metmaacher hee em Wiki sen en Klammere met dobei, woh et se jitt. Di Leß künnt uss_em Zwescheshpeicher kumme un nit janz om neuste Shtand sin.',
	'code-author-haslink' => 'Dä Schriiver es em Wiki mem Metmaacher $1 verlengk',
	'code-author-orphan' => 'Dä Schriiver $1 vum <i lang="en">SVN</i>es nit met enem Metmaacher em Wiki verlengk',
	'code-author-dolink' => 'Donn dä Schriiver hee met enem Metmaacher em Wiki verlengke:',
	'code-author-alterlink' => 'Donn dä Lengk för dä Schriiver hee met enem Metmaacher em Wiki verändere:',
	'code-author-orunlink' => 'Donn dä Lengk fö dä Schriiver hee met enem Metmaacher em Wiki ophävve:',
	'code-author-name' => 'Däm Metmaacher singe Name:',
	'code-author-success' => 'Dä Schriiver $1 es jäz met dämm Metmaacher $2 em Wiki verlengk',
	'code-author-link' => 'donn dä Lengk mache?',
	'code-author-unlink' => 'donn dä Lengk fott nämme?',
	'code-author-unlinksuccess' => 'Dä Schriiver $1 es jäz nit mieh met dämm Wiki verlengk',
	'code-author-badtoken' => 'Ene Fähler met dä <i lang="en">Session</i>-Daate es opjetrodde, wi mer dat maache wullte.',
	'code-author-total' => 'Schriever insjesamp: $1',
	'code-author-lastcommit' => 'Dä läzde Beidraach',
	'code-browsing-path' => "Bläddere en de Versione vun '''$1'''",
	'code-field-id' => 'Version',
	'code-field-author' => 'Schriiver',
	'code-field-user' => 'Kommentaa-Schriever',
	'code-field-message' => 'Koot zosamme jefaß',
	'code-field-status' => 'Shtattus',
	'code-field-status-description' => 'Dä Status beschrevve',
	'code-field-timestamp' => 'Zick un Dattum',
	'code-field-comments' => 'Aanmärkunge',
	'code-field-path' => 'Pad',
	'code-field-text' => 'Notiz',
	'code-field-select' => 'Ußsöhke',
	'code-reference-remove' => 'Ußjewählte Zosammehäng oplühse',
	'code-reference-associate' => 'Opfoljer-Version faßlääje:',
	'code-reference-associate-submit' => 'Donn se zesamme!',
	'code-rev-author' => 'Schriiver / Projrammierer:',
	'code-rev-date' => 'Dattum:',
	'code-rev-message' => 'Kommentaa:',
	'code-rev-repo' => 'Repositorijum:',
	'code-rev-rev' => 'Version:',
	'code-rev-rev-viewvc' => 'op <i lang="en">ViewVC</i>',
	'code-rev-paths' => 'Jeändert woodte:',
	'code-rev-modified-a' => 'dobeij jedonn',
	'code-rev-modified-r' => 'ußjetuusch',
	'code-rev-modified-d' => 'fottjeschmeße',
	'code-rev-modified-m' => 'jeändert',
	'code-rev-imagediff' => 'Änderunge aam Beld',
	'code-rev-status' => 'Shtattus:',
	'code-rev-status-set' => 'Shtattus ändere',
	'code-rev-tags' => 'Makeerunge:',
	'code-rev-tag-add' => 'Makeerunge dobei donn:',
	'code-rev-tag-remove' => 'Makeerunge fott nämme:',
	'code-rev-comment-by' => 'Kommentaa vum „$1“',
	'code-rev-comment-preview' => 'Vör-Aansich',
	'code-rev-inline-preview' => 'Vör-Ansich:',
	'code-rev-diff' => 'Ungerscheid',
	'code-rev-diff-link' => '{{int:code-rev-diff}}',
	'code-rev-diff-too-large' => 'De Ungerscheid senn zoh vill för se heh aanzezeije.',
	'code-rev-purge-link' => 'Donn dä Zweschespeicher leddisch maache',
	'code-rev-total' => 'Jesampzahl: $1',
	'code-rev-not-found' => "En Version '''$1''' beshteiht nit!",
	'code-status-new' => 'neu',
	'code-status-desc-new' => 'Di Version es drop am waade, dat mer jet med_er deiht, dad_es och der Aanfangs_Zohshtand.',
	'code-status-fixme' => 'zom Verbessere',
	'code-status-desc-fixme' => 'Di Version deiht et nit udder se määt jet verkiehrt. Doh jidd_et jet draan ze verbäßere, udder se sullt retuur jemaat wääde.',
	'code-status-reverted' => 'retuur jemaat',
	'code-status-desc-reverted' => 'Di Version es vun ene shpäädere Version widder opjehovve woode.',
	'code-status-resolved' => 'äleedesch',
	'code-status-desc-resolved' => 'Di Version häd e Problem jehat, wat shpääder vun ene andere Version jelööß wood.',
	'code-status-ok' => 'Jot',
	'code-status-desc-ok' => 'Di Version es kumplättemang nohjelooert un jeprööf, un dä et jedonn hät es sesh sesher, dat se joot es.',
	'code-status-deferred' => 'spääder',
	'code-status-desc-deferred' => 'Di Version bruch jez kein Prööfung.',
	'code-status-old' => 'ahl',
	'code-status-desc-old' => 'En älder Version met udder ohne Fähler, woh ävver et Prööfe der Möh nit wäät es.',
	'code-signoffs' => 'Jodjeheiße',
	'code-signoff-legend' => 'Jodheiße',
	'code-signoff-submit' => 'Jodheiße!',
	'code-signoff-strike' => 'De ußjewählte Jodheißunge ophävve',
	'code-signoff-signoff' => 'Di Versione jodheiße als:',
	'code-signoff-flag-inspected' => 'Enspezeert',
	'code-signoff-flag-tested' => 'Ußprobeet',
	'code-signoff-field-user' => 'Metmaacher',
	'code-signoff-field-flag' => 'Wie?',
	'code-signoff-field-date' => 'Dattum',
	'code-signoff-struckdate' => '$1 (fottjeschmeße: $2)',
	'code-pathsearch-legend' => 'Söhk en däm Repositorijum noh Versione, övver dänne iere Pahdt',
	'code-pathsearch-path' => 'Pahdt:',
	'code-pathsearch-filter' => 'Ußsöhke noh:&#160;',
	'code-revfilter-cr_status' => 'Stattus = $1',
	'code-revfilter-cr_author' => 'Schriever = $1',
	'code-revfilter-ct_tag' => 'Makeerong = $1',
	'code-revfilter-clear' => 'Donn nix mieh udder keine mieh ußwähle!',
	'code-rev-submit' => 'Änderunge faßhallde',
	'code-rev-submit-next' => 'Don dat faßhallde, un jangk nohm nächste unjelöste Kumflick',
	'code-rev-next' => 'De nääßte Version zom jet draan donn',
	'code-batch-status' => 'Shtattus ändere:',
	'code-batch-tags' => 'Makeerunge ändere:',
	'codereview-batch-title' => 'All de ußjesoohte Versione ändere',
	'codereview-batch-submit' => 'Lohß Jonn!',
	'code-releasenotes' => 'Aanmerkunge för Versione',
	'code-release-legend' => 'Aanmerkunge för Versione zosammeshtälle',
	'code-release-startrev' => 'Aanfangsversion:',
	'code-release-endrev' => 'Läz Version:',
	'codereview-subtitle' => 'För $1',
	'codereview-reply-link' => 'antwoote',
	'codereview-overview-title' => 'Övverbleck',
	'codereview-overview-desc' => 'Donn en Övverssesch vun dä Leß als e Beld aanzeije',
	'codereview-email-subj' => '[$1 $2]: Neu Aanmerkung dobei jedonn',
	'codereview-email-body' => '{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} "$1" hät en Aanmerkung enjedraare för $3

De janze URL es: $2

En et Logbooch hät {{GENDER:$1|hä|et|dä Metmaacher|sei|et}} jeschrevve:

$5

De Aanmerkung es:

$4',
	'codereview-email-subj2' => '[$1 $2]: De Änderunge donoh',
	'codereview-email-body2' => '{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} "$1" hät aan dä Version $2 jet jedonn.

Dä kumplätte URL vun dä Version:
$5
De Aanmerkung em Logbooch dohzo:

$6

Dä kumplätte URL vun dä neue Fassung:
$3
Dä Endrach em Logbooch dohzo:

$4',
	'codereview-email-subj3' => '[$1 $2]: Dä Stattus von dä Version woodt jeändert',
	'codereview-email-body3' => '{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} "$1" hät von de Version $2 der Stattus verändert.

Dä wohr: $3
un es jäz: $4

Dä kumplätte URL es: $5
De Aanmerkung em Logbooch dozo:

$6',
	'codereview-email-subj4' => '[$1 $2]: Neu Aanmerkung dobei jedonn, un der Stattus verändert',
	'codereview-email-body4' => '{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} "$1" hät von de Version $2 der Stattus verändert.

Dä wohr: $3
un es jäz: $4

{{GENDER:$1|Dä|Et|Dä Metmaacher|De|Dat}} "$1" hät och en Aanmerkung dobei jedonn.

Dä kumplätte URL:
$5

De Aanmerkung em Logbooch:

$7

De Aanerkung vör di Version:

$6',
	'code-stats' => 'Statistike',
	'code-stats-header' => 'Statistike vum Repositorijum „$1“',
	'code-stats-main' => 'Bes aam $6 öm $5 Uhr {{PLURAL:$4|hät [[Special:Code/$3/author|eine Schriever]]|han [[Special:Code/$3/author|$4 Schriever]]}} {{PLURAL:$2|ein Änderung|$2 Änderunge}} em Repositorijum jemaat.',
	'code-stats-status-breakdown' => 'Aanzahl Versione per Stattus',
	'code-stats-fixme-breakdown' => 'Woh noch jet draan ze Verbessere es, opjeschlößelt noh de Schriever',
	'code-stats-new-breakdown' => 'De neue Versione, opjeschlößelt noh de Schriever',
	'code-stats-count' => 'Aanzahl Versione',
	'code-tooltip-withsummary' => 'r$1 [$2] vum $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] vum $3',
	'repoadmin' => 'Repositorijums-Verwalldung',
	'repoadmin-new-legend' => 'E neu Repositorijum aanlääje',
	'repoadmin-new-label' => 'Däm Repositorijum singe Name:',
	'repoadmin-new-button' => 'Aanläje',
	'repoadmin-edit-legend' => 'Dat Repositorijum „$1“ ändere',
	'repoadmin-edit-path' => 'Däm Repositorijum singe Pahdt:',
	'repoadmin-edit-bug' => '<i lang="en">Bugzilla</i> Pahdt:',
	'repoadmin-edit-view' => '<i lang="en">ViewVC</i> Pahdt:',
	'repoadmin-edit-button' => 'Lohß Jonn!',
	'repoadmin-edit-sucess' => 'Dat Repositorijum „[[Special:Code/$1|$1]]“ woht verändert.',
	'repoadmin-nav' => 'Repositorijums-Verwalldung',
	'right-repoadmin' => 'Repositorije verwallde',
	'right-codereview-use' => '[[Special:Code|{{#special:Code}}]] bruche',
	'right-codereview-add-tag' => 'Makeerunge för Projramm-Versione verjäve',
	'right-codereview-remove-tag' => 'Makeerunge vun Projramm-Versione fott nämme',
	'right-codereview-post-comment' => 'Eije Kommentaare för Projramm-Versione veröffentlesche',
	'right-codereview-set-status' => 'Dä Stattus vun ene Version ändere',
	'right-codereview-signoff' => 'Änderonge jodheiße',
	'right-codereview-link-user' => 'Schriiver op Metmaacher em Wiki verlinke',
	'right-codereview-associate' => 'Verbendunge zwesche Projrammversione verwallde',
	'right-codereview-review-own' => 'Donn Ding eije Änderong als en Oodenong aansin.',
	'specialpages-group-developer' => 'Werkzüch fö Entwecklere',
	'group-svnadmins' => 'Verwallder vum SVN',
	'group-svnadmins-member' => 'Verwallder vum SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Verwallder vum SVN',
);

/** Kurdish (Latin script) (‪Kurdî (latînî)‬)
 * @author George Animal
 * @author Welathêja
 */
$messages['ku-latn'] = array(
	'code-change-added' => 'hat zêdekirin:',
	'code-old-status' => 'Rewşa kevn',
	'code-new-status' => 'Rewşa nû',
	'code-mycomments' => 'şîroveyên min',
	'code-field-id' => 'Revîzyon',
	'code-field-timestamp' => 'Dem',
	'code-rev-comment-preview' => 'Pêşdîtin',
	'code-rev-inline-preview' => 'Pêşdîtin:',
	'code-status-new' => 'nû',
	'code-status-ok' => 'temam',
	'code-status-old' => 'kevn',
	'code-signoff-flag-tested' => 'Hat ceribandin',
	'code-signoff-field-user' => 'Bikarhêner',
	'codereview-subtitle' => 'Ji bo $1',
	'code-stats' => 'statîstîkan',
	'repoadmin-edit-button' => 'Temam',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'code' => 'Code nokucken',
	'code-rev-title' => '$1 - Versioun vum Code',
	'code-comments' => 'Bemierkungen',
	'code-references' => 'Versiounen déi duerno kommen',
	'code-change-status' => 'huet de "Statut" vun $1 geännert',
	'code-change-tags' => "huet '''Taggen''' fir $1 geännert",
	'code-change-removed' => 'ewech geholl:',
	'code-change-added' => 'derbäi gesat:',
	'code-old-status' => 'Ale Status',
	'code-new-status' => 'Neie Status',
	'code-prop-changes' => 'Logbuch vum Status an den Taggen',
	'codereview-desc' => "[[Special:Code|Tool fir de Code nozekucken]] mat [[Special:RepoAdmin|Subversioun's Ënnerstëtzung]]",
	'code-load-diff' => 'Lude vun Diff…',
	'code-notes' => 'rezent Bemierkungen',
	'code-statuschanges' => 'Ännerunge vum Status',
	'code-mycommits' => 'meng Publikatiounen',
	'code-mycomments' => 'meng Bemierkungen',
	'code-authors' => 'Auteuren',
	'code-status' => 'Statussen',
	'code-tags' => 'Tagen',
	'code-authors-text' => 'Ënnendrënner ass eng Lëscht vun de Repo-Auteuren an der Reiefolleg vum Commit Numm. Lokal Wikikonte ginn tëschent Klamere gewisen. Et ka sinn datt Daten aus dem Tëschspäicher kommen.',
	'code-author-haslink' => 'Dësen Auteur ass mam Wiki-Benotzer $1 verbonn',
	'code-author-orphan' => 'SVN Benotzer/Auteur $1 huet kee Link mat engem Wiki-Benotzerkont',
	'code-author-dolink' => 'Dësen Auteur mat engem Wiki-Benotzer verbannen:',
	'code-author-alterlink' => 'De Wiki-Benotzer de mat dësem Auteur verlinkt ass änneren:',
	'code-author-orunlink' => 'oder dëse Benotzer net méi verlinken:',
	'code-author-name' => 'Gitt e Benotzernmm an:',
	'code-author-success' => 'Den Auteur $1 gouf mat dem Wiki-Benotzer $2 verbonn (verlinkt)',
	'code-author-link' => 'verlinken?',
	'code-author-unlink' => 'Link ophiewen?',
	'code-author-unlinksuccess' => 'Den Auteur $1 ass net méi verlinkt',
	'code-author-badtoken' => 'Sessiouns-Feeler beim Versuch vun der Aktioun',
	'code-author-total' => 'Total vun der Zuel vun Auteuren: $1',
	'code-author-lastcommit' => 'Leschten Datum vum Iwwerdroen',
	'code-browsing-path' => "Versiounen op '''$1''' duerchbliederen",
	'code-field-id' => 'Revisioun',
	'code-field-author' => 'Auteur',
	'code-field-user' => 'Commentateur',
	'code-field-message' => 'Bemierkung ofspäicheren',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Beschreiwung vum Status',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Bemierkungen',
	'code-field-path' => 'Pad',
	'code-field-text' => 'Notiz',
	'code-field-select' => 'Eraussichen',
	'code-reference-remove' => 'Déi erausgesichte Verbindunge läschen',
	'code-reference-associate' => "Mat der 'Versioun déi duerno kënnt' verbannen:",
	'code-reference-associate-submit' => 'Associéieren',
	'code-rev-author' => 'Auteur:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Bemierkung:',
	'code-rev-rev' => 'Versioun:',
	'code-rev-rev-viewvc' => 'op ViewVC',
	'code-rev-paths' => 'Geännert Pied:',
	'code-rev-modified-a' => 'derbäigesat',
	'code-rev-modified-r' => 'ersat',
	'code-rev-modified-d' => 'geläscht',
	'code-rev-modified-m' => 'geännert',
	'code-rev-imagediff' => 'Bildännerungen',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status änneren',
	'code-rev-tags' => 'Tagen:',
	'code-rev-tag-add' => 'Tagen derbäisetzen:',
	'code-rev-tag-remove' => 'Tagen ewechhuelen:',
	'code-rev-comment-by' => 'Bemierkung vum $1',
	'code-rev-comment-preview' => 'Kucken ouni ze späicheren',
	'code-rev-inline-preview' => 'Kucken ouni ze späicheren:',
	'code-rev-diff' => 'Ënnerscheed',
	'code-rev-diff-link' => 'Diff',
	'code-rev-diff-too-large' => 'Den Diff (Ënnerscheed) ass ze grouss fir en ze weisen.',
	'code-rev-purge-link' => 'botzen (vum Cache)',
	'code-rev-total' => 'Gesamtzuel vun de Resultater: $1',
	'code-rev-not-found' => "Versioun '''$1''' gëtt et net!",
	'code-rev-history-link' => 'Versiounen',
	'code-status-new' => 'nei',
	'code-status-fixme' => 'verbesser mech',
	'code-status-reverted' => 'zréckgesat',
	'code-status-desc-reverted' => "D'Versioun gouf duerch eng méi nei Versioun ersat.",
	'code-status-resolved' => 'geléist',
	'code-status-desc-resolved' => "D'Versioun hat e Feeler deen duerch eng méi nei Versioun verbessert gouf.",
	'code-status-ok' => 'ok',
	'code-status-deferred' => 'zréckgestallt',
	'code-status-desc-deferred' => "D'Versioun muss net nogekuckt ginn.",
	'code-status-old' => 'al',
	'code-status-desc-old' => 'Al Versioun mat méigleche Feeler (Bugs), déi et awer net derwäert si fir nogekuckt ze ginn.',
	'code-signoffs' => 'Zoustëmmungen',
	'code-signoff-legend' => 'Fräiginn derbäisetzen',
	'code-signoff-submit' => 'Fräiginn',
	'code-signoff-flag-inspected' => 'Inspizéiert',
	'code-signoff-flag-tested' => 'Getest',
	'code-signoff-field-user' => 'Benotzer',
	'code-signoff-field-flag' => 'Markéierung',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (huet $2 gestrach)',
	'code-pathsearch-path' => 'Pad:',
	'code-pathsearch-filter' => 'Weis nëmmen:',
	'code-revfilter-cr_status' => 'Statut  = $1',
	'code-revfilter-cr_author' => 'Auteur = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Filter eidel maachen',
	'code-rev-submit' => 'Ännerunge späicheren',
	'code-rev-submit-next' => 'Späicheren & nächst ongeléist',
	'code-rev-next' => 'Nächsten am Suspens',
	'code-batch-status' => 'Ännerungsstatut:',
	'code-batch-tags' => 'Taggen änneren:',
	'codereview-batch-title' => 'All ausgewielte Versiounen änneren',
	'codereview-batch-submit' => 'Schécken',
	'code-releasenotes' => 'Versiounsnotizen',
	'code-release-legend' => 'Versiounsnotizen uleeën',
	'code-release-startrev' => 'Ufanksversioun:',
	'code-release-endrev' => 'Lescht Versioun:',
	'codereview-subtitle' => 'Fir $1',
	'codereview-reply-link' => 'äntwerten',
	'codereview-overview-title' => 'Iwwersiicht',
	'codereview-overview-desc' => 'Eng grafesch Iwwersiicht vun dëser Lëscht wesien',
	'codereview-email-subj' => '[$1 $2]: Nei Bemierkung derbäigesat',
	'codereview-email-body' => 'De Benotzer "$1" huet eng Bemierkung op $3 hannerlooss.

Ganz URL: $2
Resumé vun der Ännerung:

$5

Bemierkung:

$4',
	'codereview-email-subj2' => '[$1 $2]: Ännerungen doropshinn',
	'codereview-email-body2' => 'De Benotzer "$1" huet Ännerungen zu der Versioun $2 gemaach.

Komplett URL vun der Ännerung: $5
Resumé vun der Ännerung:

$6

Komplett URL: $3

Resumé vun der neier Versioun:

$4',
	'codereview-email-subj3' => '[$1 $2]: Statut vun der Versioun huet geännert',
	'codereview-email-body3' => 'De Benotzer „$1“ huet de Statut vu(n) $2 geännert.

Ale Statut: $3
Neie Statut: $4

Komplett URL: $5
Resumé vun der Ännerung:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nei  Bemierkung derbäigesat, an de Statut vun der Versioun geännert',
	'codereview-email-body4' => 'De Benotzer "$1" huet de Statut vun $2 geännert.

Ale Statut: $3
Neie Statut: $4

De Benotzer "$1" huet och eng Bemierkung iwwer $2 derbäigesat.

Komplett URL: $5
Resumé vun der Ännerung:

$7

Bemierkung:

$6',
	'code-stats' => 'Statistiken',
	'code-stats-status-breakdown' => 'Zuel vun de Versioune pro Statut',
	'code-stats-fixme-breakdown' => 'Opdeelung vun de FixMe-Versioune pro Auteur',
	'code-stats-new-breakdown' => 'Opdeelung vun neie Versioune pro Auteur',
	'code-stats-count' => 'Zuel vun de Versiounen',
	'code-tooltip-withsummary' => 'r$1 [$2] vum $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] vum $3',
	'repoadmin-new-button' => 'Uleeën',
	'repoadmin-edit-bug' => 'Bugzilla Pad:',
	'repoadmin-edit-view' => 'Pad op ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'De \'\'Repositoire\'\' "[[Special:Code/$1|$1]]" gouf geännert.',
	'right-codereview-use' => 'Spezial benotzen: Code',
	'right-codereview-add-tag' => "Nei Markéierunge bei d'Versiounen derbäisetzen",
	'right-codereview-remove-tag' => 'Markéierungen aus Versiounen eraushuelen',
	'right-codereview-post-comment' => "Bemierkunge bäi d'Versiounen derbäisetzen",
	'right-codereview-set-status' => 'Ännere vum Status vun de Versiounen',
	'right-codereview-signoff' => 'Ännerunge fräiginn',
	'right-codereview-link-user' => 'Auteure mat Wiki-Benotzer verbannen (verlinken)',
	'right-codereview-review-own' => 'Markéiert Är eege Versiounen als OK oder geléist',
	'specialpages-group-developer' => 'Handwierksgeschir fir Entwéckler (Programméierer)',
	'group-svnadmins' => 'SVN-Administrateuren',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-Administrateur|SVN-Administratrice}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-Administrateuren',
);

/** Lezghian (Лезги)
 * @author Namik
 */
$messages['lez'] = array(
	'code-rev-date' => 'Нумра/заман',
	'code-status-old' => 'иски',
	'code-signoff-field-flag' => 'Пайдах',
);

/** Lingua Franca Nova (Lingua Franca Nova)
 * @author Malafaya
 */
$messages['lfn'] = array(
	'code-authors' => 'autores',
	'code-field-author' => 'Autor',
	'code-rev-author' => 'Autor:',
	'repoadmin-new-button' => 'Crea',
	'repoadmin-edit-button' => 'Oce',
);

/** Ganda (Luganda)
 * @author Kizito
 */
$messages['lg'] = array(
	'code-rev-comment-preview' => 'Gezesa',
	'code-rev-inline-preview' => 'Kugezesa',
);

/** Limburgish (Limburgs)
 * @author Aelske
 * @author Ooswesthoesbes
 * @author Pahles
 */
$messages['li'] = array(
	'code' => 'Codekentrol',
	'code-rev-title' => '$1 - Programmacodekentrol',
	'code-comments' => 'Opmirkinge',
	'code-references' => 'Versies mit korrekties',
	'code-change-status' => "haet de '''staat''' veur $1 angerdj",
	'code-change-tags' => "haet de '''labels''' veur $1 verangerd",
	'code-change-removed' => 'eweggesjaf:',
	'code-change-added' => 'biegedoon:',
	'code-old-status' => 'Auwe sjtatus',
	'code-new-status' => 'Nuuj sjtatus',
	'code-prop-changes' => 'Logbook staat èn labels',
	'codereview-desc' => '[[Special:Code|Hölpprogramma veur kodekontraol]] mid [[Special:RepoAdmin|óngerstäöning veur Subversion]]',
	'code-no-repo' => "d'r Is gein 'repository' ingesjtèld!",
	'code-create-repo' => "Gank nao [[Special:RepoAdmin|RepoAdmin]] um 'n repository aan te make",
	'code-need-repoadmin-rights' => 'De höbs \'t rech "repoadmin" nudig um \'n Repository aan te kinne make',
	'code-need-group-with-rights' => '\'t Gif gein gróp mit \'t rech "repoadmin". Veug ein toe um nuuj Repository aan te kinne make',
	'code-repo-not-found' => "De repository '''$1''' besteit neet!",
	'code-load-diff' => 'Angeringslaajendje...',
	'code-notes' => 'lèste ópmèrkinger',
	'code-statuschanges' => 'statuswieziginge',
	'code-mycommits' => 'mien commits',
	'code-mycomments' => 'mien opmirkinge',
	'code-authors' => 'sjrievers',
	'code-status' => 'staat',
	'code-tags' => 'labels',
	'code-tags-no-tags' => 'Dao weure gein labels gebroek in dees repository.',
	'code-authors-text' => "Hiejónger steit 'n lies mit auteurs oet de repositoir op abc. Lokaal gebroekers staon tösje häökskes.",
	'code-author-haslink' => 'Deze sjriever is gekoppeld aan de wikigebroeker $1',
	'code-author-orphan' => "De SVN-gebroeker/sjriever $1 is neet gekoppeld aan 'ne wikigebroeker",
	'code-author-dolink' => "Deze sjriever mit 'ne wikigebroeker koppele:",
	'code-author-alterlink' => 'De aan deze sjriever gekoppelde wikigebroeker angere:',
	'code-author-orunlink' => 'Of deze wikigebroeker ontkoppele:',
	'code-author-name' => "Gaef 'ne gebroekersnaam in:",
	'code-author-success' => 'De auteur $1 is gekoppeld aan de wikigebroeker $2',
	'code-author-link' => 'koppele?',
	'code-author-unlink' => 'ontkoppele?',
	'code-author-unlinksuccess' => 'Sjriever $1 is los.',
	'code-author-badtoken' => "Sessiefout tiejes 't oetveure van de hanjeling.",
	'code-author-total' => 'Totaal aantal auteurs: $1',
	'code-author-lastcommit' => 'Leste ingaevingsdatum',
	'code-browsing-path' => "Versies in '''$1''' aan 't bekieke",
	'code-field-id' => 'Versie',
	'code-field-author' => 'Sjriever',
	'code-field-user' => 'Opmerking door:',
	'code-field-message' => 'Toelichting bie verzeuk',
	'code-field-status' => 'Staat',
	'code-field-status-description' => 'Statusbesjrieving',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Opmirkinge',
	'code-field-path' => 'Paad',
	'code-field-text' => 'Ópmèrking',
	'code-field-select' => 'Selektere',
	'code-reference-remove' => 'Geselekteerde koppelinge ewegsjaffe',
	'code-reference-associate' => 'Follow-upversie koppele:',
	'code-reference-associate-submit' => 'Koppele',
	'code-rev-author' => 'Sjriever:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Ópmèrking:',
	'code-rev-repo' => 'Repositoir:',
	'code-rev-rev' => 'Versie:',
	'code-rev-rev-viewvc' => 'in ViewVC',
	'code-rev-paths' => 'Angerdje bestenj:',
	'code-rev-modified-a' => 'toegevoeg',
	'code-rev-modified-r' => 'vervank',
	'code-rev-modified-d' => 'weggegoejd',
	'code-rev-modified-m' => 'veranderd',
	'code-rev-imagediff' => 'Angeringe in aafbeilding',
	'code-rev-status' => 'Staat:',
	'code-rev-status-set' => 'Veranderde status',
	'code-rev-tags' => 'Labels:',
	'code-rev-tag-add' => 'Voeg labels toe:',
	'code-rev-tag-remove' => 'Labels wösje:',
	'code-rev-comment-by' => 'Ópmèrking ven $1',
	'code-rev-comment-preview' => 'Naokieke',
	'code-rev-inline-preview' => 'Veurbesjouwing:',
	'code-rev-diff' => 'Vers',
	'code-rev-diff-link' => 'vers',
	'code-rev-diff-too-large' => 'De versjille zeen te groet om weer te gaeve.',
	'code-rev-purge-link' => 'vervèrs',
	'code-rev-total' => 'Totaal aantal resultate: $1',
	'code-rev-not-found' => "Herzening '''$1''' besteit neet!",
	'code-rev-history-link' => 'historie',
	'code-status-new' => 'nuuj',
	'code-status-desc-new' => "De versie wach op 'n aktie (sjtandaardsjtatus).",
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => "De versie introduceerde 'n bug of is kepot. Dat mót waere gekorrigeerd.",
	'code-status-reverted' => 'trökgedrejdj',
	'code-status-desc-reverted' => "De versie is óngedaon gemaak door 'n later versie",
	'code-status-resolved' => 'ópgelós',
	'code-status-desc-resolved' => "Dao waor 'n perbleem mit de versie wat opgelos is in 'n later versie.",
	'code-status-ok' => 'gaon',
	'code-status-desc-ok' => 'De revisie is gans naogekeke en de reviewer is zeker tot alles gans in orde is.',
	'code-status-deferred' => 'aangehaaje',
	'code-status-desc-deferred' => 'De versie heet gein review nudig.',
	'code-status-old' => 'aad',
	'code-status-desc-old' => "Aw versie die mäögelik bugs bevat mer die 't neet weerd is nog review te kriege.",
	'code-signoffs' => 'Goodkäöringe',
	'code-signoff-legend' => 'Goodkäöring toeveuge',
	'code-signoff-submit' => 'Goodkäöre',
	'code-signoff-strike' => 'Geselekteerde goodkäöringe doorhaole',
	'code-signoff-signoff' => 'Dees versie goodkäöre es:',
	'code-signoff-flag-inspected' => 'Óngerzeuk',
	'code-signoff-flag-tested' => 'Getes',
	'code-signoff-field-user' => 'Gebroeker',
	'code-signoff-field-flag' => 'Markering',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (haet $2 doorgehaold)',
	'code-pathsearch-legend' => 'Óp paadversjes in dees repositoir zeuke',
	'code-pathsearch-path' => 'Paad:',
	'code-pathsearch-filter' => 'Allein weergaeve:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Auteur = $1',
	'code-revfilter-ct_tag' => 'Label = $1',
	'code-revfilter-clear' => 'Wis filter',
	'code-rev-submit' => 'Wieziginge ópslaon:',
	'code-rev-submit-next' => 'Ópslaon èn vólgendje óngekóntraoldje',
	'code-rev-next' => 'Volgende ongekonterleerde',
	'code-batch-status' => 'Anger staat:',
	'code-batch-tags' => 'Anger labels:',
	'codereview-batch-title' => 'Anger als geselkteerde versies',
	'codereview-batch-submit' => 'Ópslaon',
	'code-releasenotes' => 'gaef ópmèrkinger vrie',
	'code-release-legend' => 'Maak vriegegaeve ópmèrkinger',
	'code-release-startrev' => 'Begintóch:',
	'code-release-endrev' => 'Ènjtóch:',
	'codereview-subtitle' => 'Veur $1',
	'codereview-reply-link' => 'antjwäörje',
	'codereview-overview-title' => 'Euverzich',
	'codereview-overview-desc' => "'n Grafisch euverzich van dees lies weergaeve",
	'codereview-email-subj' => '[$1 $2]: Nuuj ópmèrking toegevoeg',
	'codereview-email-body' => 'Gebroeker "$1" haet \'n ópmèrking toegevoeg aan $3:

Vólledige URL: $2

Ópmèrking:

$4',
	'codereview-email-subj2' => '[$1 $2]: wieziginge mit correcties',
	'codereview-email-body2' => 'Gebroeker "$1" haet wiezigingen mit correcties veur $2 gemaak.

Volledige URL nao die versie: $5

Volledige URL: $3

Toelichting bie toevoging:

$4',
	'codereview-email-subj3' => '[$1 $2]: versiesjtatus gewiezig',
	'codereview-email-body3' => '"$1" haet de sjtatus van versie $2 verangerd nao "$4".
URL: $5

Auwe sjtatus: $3
Nuje sjtatus: $4

Commitsamevatting veur $2:

$6',
	'codereview-email-subj4' => '[$1 $2]: nuuj opmirking toegeveug en versiesjtatus gewiezig',
	'codereview-email-body4' => '"$1" haet de sjtatus van $2 verangerd nao "$4" en \'n opmirking toeveug.
URL $5

Auwe sjtatus: $3
Nuje sjtatus: $4

Commitsamevatting veur $2:

$7

Opmirking van $1:

$6',
	'code-stats' => 'statistieke',
	'code-stats-header' => 'Repositorystatistieke veur $1',
	'code-stats-main' => 'Per $1 haet de repository $2 {{PLURAL:$2|versie|versies}} door [[Special:Code/$3/author|$4 {{PLURAL:$4|outäör|outäörs}}]].',
	'code-stats-status-breakdown' => 'Aantal versies per status',
	'code-stats-fixme-breakdown' => 'Verdeiling van de versies gemarkeerd es fixme per outäör',
	'code-stats-fixme-breakdown-path' => 'Verdeiling van de versies gemarkeerd es fixme per paad',
	'code-stats-fixme-path' => 'Versies gemarkeerd es fixme veur paad: $1',
	'code-stats-new-breakdown' => 'Verdeiling van nuuj versies per outäör',
	'code-stats-new-breakdown-path' => 'Verdeiling van nuuj versies per paad',
	'code-stats-new-path' => 'Nuuj versies veur paad: $1',
	'code-stats-count' => 'Aantal versies',
	'code-tooltip-withsummary' => 'r$1 [$2] door $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] door $3',
	'repoadmin' => 'Repositoirbehieër',
	'repoadmin-new-legend' => 'Maak nuuj repositoir',
	'repoadmin-new-label' => 'Repositoirnaam:',
	'repoadmin-new-button' => 'Maak aan',
	'repoadmin-edit-legend' => 'Verangering aan repository "$1"',
	'repoadmin-edit-path' => 'Repositoirpaad:',
	'repoadmin-edit-bug' => 'Bugzillapaad:',
	'repoadmin-edit-view' => 'ViewVCpaad:',
	'repoadmin-edit-button' => 'Gaon',
	'repoadmin-edit-sucess' => 'De repositoir "[[Special:Code/$1|$1]]" is aangepas.',
	'repoadmin-nav' => 'repositorybehier',
	'right-repoadmin' => 'Coderepositoire behieëre',
	'right-codereview-use' => 'Gebroek ven Special:Code',
	'right-codereview-add-tag' => 'Voeg labels toe aan versies',
	'right-codereview-remove-tag' => 'Wösj labels ven versies',
	'right-codereview-post-comment' => 'Ópmèrkinger toevoege aan versies',
	'right-codereview-set-status' => 'Anger versiestaat',
	'right-codereview-signoff' => 'Versies goodkäöre',
	'right-codereview-link-user' => 'Koppel sjrievers aan wikigebroekers',
	'right-codereview-associate' => 'Koppeling toeveuge/ewegsjaffe',
	'right-codereview-review-own' => 'Eige commits es OK of opgelos markere',
	'specialpages-group-developer' => 'Hölpmiddele veur óntwikkeleers',
	'group-svnadmins' => 'SVN-behierdes',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-behierder}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-behierders',
);

/** Lithuanian (Lietuvių)
 * @author Eitvys200
 * @author Matasg
 */
$messages['lt'] = array(
	'code' => 'Kodo peržiūra',
	'code-rev-title' => '$1 - kodo peržiura',
	'code-comments' => 'Komentarai',
	'code-change-removed' => 'pašalintas:',
	'code-change-added' => 'Pridėtas:',
	'code-old-status' => 'Senas statusas',
	'code-new-status' => 'Naujas statusas',
	'code-notes' => 'naujausi komentarai',
	'code-statuschanges' => 'būsenos pakitimai',
	'code-mycomments' => 'mano komentarai',
	'code-authors' => 'autoriai',
	'code-status' => 'valstijos',
	'code-tags' => 'žymės',
	'code-author-name' => 'Įveskite vartotojo vardą:',
	'code-author-success' => 'Autorius  $1  buvo susietas su wiki vartotoju $2',
	'code-author-link' => 'nuorodą?',
	'code-field-author' => 'Autorius',
	'code-field-user' => 'Komentatorius',
	'code-field-status' => 'Būsena',
	'code-field-status-description' => 'Būsenos aprašymas',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Komentarai',
	'code-field-path' => 'Takelis',
	'code-field-text' => 'Pastaba',
	'code-field-select' => 'Pasirinkti',
	'code-reference-associate-submit' => 'Susieti',
	'code-rev-author' => 'Autorius:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Komentaras:',
	'code-rev-modified-a' => 'pridėta',
	'code-rev-modified-r' => 'pakeista',
	'code-rev-modified-d' => 'ištrinta',
	'code-rev-modified-m' => 'pakeista',
	'code-rev-status' => 'Būsena:',
	'code-rev-status-set' => 'Keisti būseną',
	'code-rev-tags' => 'Žymės:',
	'code-rev-tag-add' => 'Pridėti žymes:',
	'code-rev-tag-remove' => 'Pašalinti žymes:',
	'code-rev-comment-by' => 'Komentaras $1',
	'code-rev-comment-preview' => 'Peržiūra',
	'code-rev-inline-preview' => 'Peržiūra:',
	'code-rev-total' => 'Iš viso rezultatų: $1',
	'code-rev-history-link' => 'istorija',
	'code-status-new' => 'naujas',
	'code-status-ok' => 'gerai',
	'code-status-old' => 'senas',
	'code-signoff-submit' => 'Išsiregistruoti',
	'code-signoff-flag-inspected' => 'Patikrinta',
	'code-signoff-flag-tested' => 'Išbandytas',
	'code-signoff-field-user' => 'Vartotojas',
	'code-signoff-field-flag' => 'Vėliava',
	'code-signoff-field-date' => 'Data',
	'code-pathsearch-path' => 'Takelis:',
	'code-pathsearch-filter' => 'Rodyti tik:',
	'code-revfilter-cr_status' => 'Būsena = $1',
	'code-revfilter-cr_author' => 'Autorius = $1',
	'code-revfilter-ct_tag' => 'Žymė = $1',
	'code-revfilter-clear' => 'Išvalyti filtrą',
	'code-rev-submit' => 'Išsaugoti pakeitimus',
	'code-batch-status' => 'Keisti būseną:',
	'code-batch-tags' => 'Keisti žymes:',
	'codereview-batch-submit' => 'Siųsti',
	'codereview-subtitle' => '$1',
	'codereview-reply-link' => 'atsakyti',
	'codereview-email-subj' => '[ $1 $2 ]: Pridėtas naujas komentaras',
	'code-stats' => 'statistika',
	'repoadmin-new-button' => 'Sukurti',
	'repoadmin-edit-button' => 'Gerai',
	'group-svnadmins' => 'SVN administratoriai',
);

/** Latgalian (Latgaļu)
 * @author Dark Eagle
 */
$messages['ltg'] = array(
	'code-signoff-field-user' => 'Lītuotuojs',
);

/** Latvian (Latviešu)
 * @author GreenZeb
 * @author Papuass
 */
$messages['lv'] = array(
	'code-authors' => 'autori',
	'code-field-author' => 'Autors',
	'code-field-user' => 'Komentētājs',
	'code-field-message' => 'Izmaiņas kopsavilkums',
	'code-field-status' => 'Statuss',
	'code-field-timestamp' => 'Datums',
	'code-field-comments' => 'Piezīmes',
	'code-field-path' => 'Ceļš',
	'code-field-text' => 'Piezīme',
	'code-rev-author' => 'Autors:',
	'code-rev-date' => 'Datums:',
	'code-rev-message' => 'Komentārs:',
	'code-rev-repo' => 'Repozitorijs:',
	'code-rev-modified-a' => 'pievienots',
	'code-rev-modified-r' => 'aizvietots',
	'code-rev-modified-d' => 'dzēsts',
	'code-rev-modified-m' => 'pārveidots',
	'code-rev-imagediff' => 'Attēlu izmaiņas',
	'code-rev-status' => 'Statuss:',
	'code-rev-status-set' => 'Mainīt statusu',
	'code-rev-tags' => 'Birkas:',
	'code-rev-tag-add' => 'Pievienot birkas:',
	'code-rev-tag-remove' => 'Noņemt birkas:',
	'code-rev-comment-by' => '$1 komentārs',
	'code-rev-comment-preview' => 'Pirmskats',
	'code-rev-inline-preview' => 'Pirmskats:',
	'code-pathsearch-path' => 'Ceļš:',
	'code-revfilter-clear' => 'Notīrīt filtru',
	'code-rev-submit' => 'Saglabāt izmaiņas',
	'code-rev-submit-next' => 'Saglabāt un nākošais neatrisinātais',
	'code-rev-next' => 'Nākošais neatrisinātais',
	'code-batch-status' => 'Mainīt statusu:',
	'code-batch-tags' => 'Mainīt birkas:',
	'codereview-batch-title' => 'Mainīt visas izvēlētās versijas',
	'codereview-batch-submit' => 'Iesniegt',
	'code-stats' => 'statistika',
	'repoadmin-edit-button' => 'Labi',
	'specialpages-group-developer' => 'Izstrādātāju rīki',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'code-change-removed' => 'nanala :',
	'code-change-added' => 'nanampy :',
);

/** Eastern Mari (Олык Марий)
 * @author Сай
 */
$messages['mhr'] = array(
	'code-status-ok' => 'Йӧра',
	'repoadmin-edit-button' => 'Йӧра',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 * @author Brest
 */
$messages['mk'] = array(
	'code' => 'Проверка на кодот',
	'code-rev-title' => '$1 - Проверка на кодот',
	'code-comments' => 'Забелешки',
	'code-references' => 'Понатамошни ревизии',
	'code-referenced' => 'Понатамошни ревизии',
	'code-change-status' => "го измени '''статусот''' на $1",
	'code-change-tags' => "ги измени '''ознаките''' за $1",
	'code-change-removed' => 'избришано:',
	'code-change-added' => 'додадено:',
	'code-old-status' => 'Стар статус',
	'code-new-status' => 'Нов статус',
	'code-prop-changes' => 'Дневник на статуси и ознаки',
	'codereview-desc' => '[[Special:Code|Алатка за проверка на кодот]] со [[Special:RepoAdmin|поддршка за Subversion]]',
	'code-no-repo' => 'Нема наместено складиште!',
	'code-create-repo' => 'Одете на [[Special:RepoAdmin|RepoAdmin]] за да создадете Складиште',
	'code-need-repoadmin-rights' => 'за да создадете Складиште ви требаат администраторски права',
	'code-need-group-with-rights' => 'Не постои група со администраторски рпава. Направете таква група за да можете да додадете ново Складиште.',
	'code-repo-not-found' => "Складиштето '''$1''' не постои!",
	'code-load-diff' => 'Вчитувам разлики...',
	'code-notes' => 'скорешни коментари',
	'code-statuschanges' => 'измени на статусот',
	'code-mycommits' => 'мои поднесувања',
	'code-mycomments' => 'мои коментари',
	'code-authors' => 'автори',
	'code-status' => 'состојби',
	'code-tags' => 'ознаки',
	'code-tags-no-tags' => 'Во ова складиште нема ознаки.',
	'code-authors-text' => 'Еве список на автори на складишта подредени по име. Сметките на локалните викија се прикажани во загради.
Податоците може да бидат кеширани.',
	'code-author-haslink' => 'Овој автор е сврзан со корисникот $1',
	'code-author-orphan' => 'Корисникот на SVN/Авторот $1 нема врска со вики-сметка',
	'code-author-dolink' => 'Сврзи го овој автор со корисник:',
	'code-author-alterlink' => 'Сменете го корисникот сврзан со овој автор:',
	'code-author-orunlink' => 'Или отстранете врска до корисникот',
	'code-author-name' => 'Внесете корисничко име:',
	'code-author-success' => 'Авторот $1 е сврзан со корисникот $2',
	'code-author-link' => 'да ставам врска?',
	'code-author-unlink' => 'да отстранам врска?',
	'code-author-unlinksuccess' => 'Отстранета е врската до авторот $1',
	'code-author-badtoken' => 'При овидот за извршување на дејството се појави сесиска грешка.',
	'code-author-total' => 'Вкупно автори: $1',
	'code-author-lastcommit' => 'Датум на последнo спроведување',
	'code-browsing-path' => "Прелистување на ревизии во '''$1'''",
	'code-field-id' => 'Ревизија',
	'code-field-author' => 'Автор',
	'code-field-user' => 'Коментатор',
	'code-field-message' => 'Опис на измените',
	'code-field-status' => 'Статус',
	'code-field-status-description' => 'Опис на статусот',
	'code-field-timestamp' => 'Датум',
	'code-field-comments' => 'Коментари',
	'code-field-path' => 'Пат',
	'code-field-text' => 'Напомена',
	'code-field-select' => 'Избери',
	'code-reference-remove' => 'Отстрани избрани здружувања',
	'code-reference-associate' => 'Здружување на следна ревизија',
	'code-reference-associate-submit' => 'Здружи',
	'code-rev-author' => 'Автор:',
	'code-rev-date' => 'Датум:',
	'code-rev-message' => 'Коментар:',
	'code-rev-repo' => 'Складиште:',
	'code-rev-rev' => 'Ревизија:',
	'code-rev-rev-viewvc' => 'на ViewVC',
	'code-rev-paths' => 'Изменети врски:',
	'code-rev-modified-a' => 'додадено',
	'code-rev-modified-r' => 'заменето',
	'code-rev-modified-d' => 'избришано',
	'code-rev-modified-m' => 'изменето',
	'code-rev-imagediff' => 'Измени на сликите',
	'code-rev-status' => 'Статус:',
	'code-rev-status-set' => 'Промени статус',
	'code-rev-tags' => 'Ознаки:',
	'code-rev-tag-add' => 'Додај ознаки:',
	'code-rev-tag-remove' => 'Избриши ги ознаките:',
	'code-rev-comment-by' => 'Забелешка од $1',
	'code-rev-comment-preview' => 'Преглед',
	'code-rev-inline-preview' => 'Преглед:',
	'code-rev-diff' => 'Разлика',
	'code-rev-diff-link' => 'разлика',
	'code-rev-diff-too-large' => 'Разликата е преголема за да се прикаже.',
	'code-rev-purge-link' => 'исчисти',
	'code-rev-total' => 'Вкупно резултати: $1',
	'code-rev-not-found' => "Ревизијата '''$1''' не постои!",
	'code-rev-history-link' => 'историја',
	'code-status-new' => 'нов',
	'code-status-desc-new' => 'Ревизијата е во исчекување на дејство (статус по основно).',
	'code-status-fixme' => 'корегирај ме',
	'code-status-desc-fixme' => 'Ревизијата предизвика грешка или е неисправна. Треба да се поправи или врати.',
	'code-status-reverted' => 'вратено',
	'code-status-desc-reverted' => 'Ревизијата е исфрлена од понова верзија.',
	'code-status-resolved' => 'разрешено',
	'code-status-desc-resolved' => 'Ревизијата имала проблем што е решен во понова ревизија.',
	'code-status-ok' => 'ок',
	'code-status-desc-ok' => 'Ревизијата е наполно проверена, и проверувачот е сигурен дека таму сè е во ред.',
	'code-status-deferred' => 'одложено',
	'code-status-desc-deferred' => 'На ревизијата не ѝ треба преглед.',
	'code-status-old' => 'стар',
	'code-status-desc-old' => 'Стара ревизија со потенцијални грешки кои не вреди да се прегледуваат.',
	'code-signoffs' => 'Заверки',
	'code-signoff-legend' => 'Додај заверка',
	'code-signoff-submit' => 'Завери',
	'code-signoff-strike' => 'Поништување на одбрани заверки',
	'code-signoff-signoff' => 'Завери ја оваа ревизија:',
	'code-signoff-flag-inspected' => 'Прегледано',
	'code-signoff-flag-tested' => 'Испробано',
	'code-signoff-field-user' => 'Корисник',
	'code-signoff-field-flag' => 'Ознака',
	'code-signoff-field-date' => 'Датум',
	'code-signoff-struckdate' => '$1 (поништена $2)',
	'code-pathsearch-legend' => 'Пребарај ревизии на ова складиште по нивниот пат',
	'code-pathsearch-path' => 'Патека:',
	'code-pathsearch-filter' => 'Прикажи само:',
	'code-revfilter-cr_status' => 'Статус = $1',
	'code-revfilter-cr_author' => 'Автор = $1',
	'code-revfilter-ct_tag' => 'Ознака = $1',
	'code-revfilter-clear' => 'Исчисти филтер',
	'code-rev-submit' => 'Зачувај промени',
	'code-rev-submit-next' => 'Зачувај и прикажи следно нерешено',
	'code-rev-next' => 'Следна нерешена',
	'code-batch-status' => 'Измени статус:',
	'code-batch-tags' => 'Измени ги ознаките:',
	'codereview-batch-title' => 'Измени ги сите избрани ревизии',
	'codereview-batch-submit' => 'Испрати',
	'code-releasenotes' => 'белешки за изданието',
	'code-release-legend' => 'Создај белешки за изданието',
	'code-release-startrev' => 'Почетна ревиз:',
	'code-release-endrev' => 'Последна ревиз:',
	'codereview-subtitle' => 'За $1',
	'codereview-reply-link' => 'одговори',
	'codereview-overview-title' => 'Преглед',
	'codereview-overview-desc' => 'Прикажи графички преглед на списоков',
	'codereview-email-subj' => '[$1 $2]: Додаден е нов коментар',
	'codereview-email-body' => 'Корисникот „$1“ објави коментар за $3.

Полна URL-адреса: $2
Опис на измените

$5

Коментар:

$4',
	'codereview-email-subj2' => '[$1 $2]: Подоцнежни измени',
	'codereview-email-body2' => 'Корисникот „$1“ направи подоцнежни промени на $2.

Полна URL-адреса за подоцнежната ревизија: $5
Опис на измените:

$6

Полна URL-адреса: $3

$4',
	'codereview-email-subj3' => '[$1 $2]: Статусот на ревизијата се промени',
	'codereview-email-body3' => 'Корисникот „$1“ го измени статусот на $2.

Стар статус: $3
Нов статус: $4

Полна URL-адреса: $5
Опис на измените:

$6',
	'codereview-email-subj4' => '[$1 $2]: Додаден нов коментар и изменет е статусот на ревизијата',
	'codereview-email-body4' => 'Корисникот „$1“ го смени статусот на $2.

Стар статус: $3
Нов статус: $4

Корисникот „$1“ исто така објави коментар на $2.

Полна URL-адреса: $5
Опис на измените:

$7

Коментар:

$6',
	'code-stats' => 'статистики',
	'code-stats-header' => 'Статистики за складот $1',
	'code-stats-main' => 'На $1 складиштето имало $2 {{PLURAL:$2|ревизија|ревизии}} од [[Special:Code/$3/author|$4 {{PLURAL:$4|автор|автори}}]].',
	'code-stats-status-breakdown' => 'Број на ревизии по состојба',
	'code-stats-fixme-breakdown' => 'Расчленет преглед на ревизии за поправка по автор',
	'code-stats-fixme-breakdown-path' => 'Расчленет преглед на ревизии со исправки по патека',
	'code-stats-fixme-path' => 'Ревизии со исправки за патеката: $1',
	'code-stats-new-breakdown' => 'Расчленет преглед на нови ревизии по автор',
	'code-stats-new-breakdown-path' => 'Расчленет преглед на нови ревизии по патека',
	'code-stats-new-path' => 'Нови ревизии за патеката: $1',
	'code-stats-count' => 'Број на ревизии',
	'code-tooltip-withsummary' => 'r$1 [$2] од $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] од $3',
	'repoadmin' => 'Управување со складиштето',
	'repoadmin-new-legend' => 'Создај ново складиште',
	'repoadmin-new-label' => 'Име на складиштето:',
	'repoadmin-new-button' => 'Создај',
	'repoadmin-edit-legend' => 'Менување на складиштето „$1“',
	'repoadmin-edit-path' => 'Патека до складиштето:',
	'repoadmin-edit-bug' => 'Патека до Bugzilla:',
	'repoadmin-edit-view' => 'Патека до ViewVC:',
	'repoadmin-edit-button' => 'ОК',
	'repoadmin-edit-sucess' => 'Складиштето „[[Special:Code/$1|$1]]“ е успешно изменето.',
	'repoadmin-nav' => 'раководење со складиштето',
	'right-repoadmin' => 'Раководење со складишта на код',
	'right-codereview-use' => 'Користење на Special:Code',
	'right-codereview-add-tag' => 'Додавање нови ознаки кон ревизии',
	'right-codereview-remove-tag' => 'Отстранување ознаки од ревизии',
	'right-codereview-post-comment' => 'Додавање коментари кон ревизии',
	'right-codereview-set-status' => 'Менување статус на ревизии',
	'right-codereview-signoff' => 'Заверка на ревизии',
	'right-codereview-link-user' => 'Сврзување на автори со корисници',
	'right-codereview-associate' => 'Раководење со поврзување на ревизии',
	'right-codereview-review-own' => 'Означување на своите ревизии како „{{int:code-status-ok}}“ или „{{int:code-status-resolved}}“',
	'action-repoadmin' => 'раководење со складишта на код',
	'action-codereview-use' => 'користење на Special:Code',
	'action-codereview-add-tag' => 'додавање нови ознаки кон ревизии',
	'action-codereview-remove-tag' => 'отстранување ознаки од ревизии',
	'action-codereview-post-comment' => 'додавање коментари кон ревизии',
	'action-codereview-set-status' => 'менување статус на ревизии',
	'action-codereview-signoff' => 'заверка на ревизии',
	'action-codereview-link-user' => 'сврзување на автори со корисници',
	'action-codereview-associate' => 'раководење со поврзување на ревизии',
	'action-codereview-review-own' => 'означување на своите ревизии како „{{int:code-status-ok}}“ или „{{int:code-status-resolved}}“',
	'specialpages-group-developer' => 'Развојни алатки',
	'group-svnadmins' => 'Администратори на SVN',
	'group-svnadmins-member' => '{{GENDER:$1|Администратор на SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Администратори на SVN',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 */
$messages['ml'] = array(
	'code' => 'കോഡ് സംശോധനം',
	'code-rev-title' => '$1 - കോഡ് സംശോധനം',
	'code-comments' => 'അഭിപ്രായങ്ങൾ',
	'code-references' => 'പിന്തുടർച്ചയായുണ്ടായിട്ടുള്ള നാൾപ്പതിപ്പുകൾ',
	'code-change-status' => "$1-ന്റെ '''സ്ഥിതി''' മാറ്റിയിരിക്കുന്നു",
	'code-change-tags' => "$1-ന്റെ '''റ്റാഗുകൾ''' മാറ്റിയിരിക്കുന്നു",
	'code-change-removed' => 'നീക്കം ചെയ്തു:',
	'code-change-added' => 'കൂട്ടിച്ചേർത്തു:',
	'code-old-status' => 'പഴയ സ്ഥിതി',
	'code-new-status' => 'പുതിയ സ്ഥിതി',
	'code-prop-changes' => 'സ്ഥിതിയുടേയും റ്റാഗിങ്ങിന്റേയും രേഖ',
	'codereview-desc' => '[[Special:RepoAdmin|സബ്‌‌വേർഷൻ പിന്തുണയോടു]] കൂടിയ [[Special:Code|കോഡ് സംശോധന ഉപകരണം]]',
	'code-no-repo' => 'റെപ്പോസിറ്ററികളൊന്നും ക്രമീകരിച്ചിട്ടില്ല!',
	'code-create-repo' => 'റെപ്പോസിറ്ററി നിർമ്മിക്കാൻ [[Special:RepoAdmin|റെപ്പോകാര്യനിർവ്വാഹക]] താളിൽ ചെല്ലുക',
	'code-need-repoadmin-rights' => 'റെപ്പോസിറ്ററി നിർമ്മിക്കാൻ റെപ്പോകാര്യനിർവ്വാഹക ശേഷികൾ ആവശ്യമാണ്',
	'code-need-group-with-rights' => 'റെപ്പോകാര്യനിർവ്വാഹക ശേഷിയുള്ള ഒരു സംഘവും നിലവിലില്ല. പുതിയ റെപ്പോസിറ്ററി നിർമ്മിക്കാൻ കഴിവുള്ള ഒരു സംഘത്തെ സൃഷ്ടിക്കുക',
	'code-repo-not-found' => "'''$1''' എന്ന റെപ്പോസിറ്ററി നിലവിലില്ല!",
	'code-load-diff' => 'വ്യത്യാസം ശേഖരിക്കുന്നു...',
	'code-notes' => 'സമീപകാല അഭിപ്രായങ്ങൾ',
	'code-statuschanges' => 'സ്ഥിതിയിലെ മാറ്റങ്ങൾ',
	'code-mycommits' => 'ഞാൻ ചുമതലപ്പെടുത്തിയവ',
	'code-mycomments' => 'എന്റെ കുറിപ്പുകൾ',
	'code-authors' => 'രചയിതാക്കൾ',
	'code-status' => 'അവസ്ഥകൾ',
	'code-tags' => 'റ്റാഗുകൾ',
	'code-tags-no-tags' => 'ഈ റെപ്പോസിറ്ററിയിൽ റ്റാഗുകളൊന്നും നിലവിലില്ല.',
	'code-authors-text' => 'താഴെ ഉൾപ്പെടുത്തിയ പേരിന്റെ ക്രമത്തിൽ റെപ്പോ രചയിതാക്കളുടെ പട്ടിക കൊടുത്തിരിക്കുന്നു. പ്രാദേശിക വിക്കി അംഗത്വങ്ങൾ കോഷ്ഠകങ്ങൾക്കുള്ളിൽ കാണാം. വിവരങ്ങൾ പ്രാദേശികമായി ശേഖരിച്ച് വെച്ചിരിക്കുന്നതാവാം.',
	'code-author-haslink' => '$1 എന്ന വിക്കി ഉപയോക്താവുമായി ഈ രചയിതാവിനെ കണ്ണി ചേർത്തിരിക്കുന്നു',
	'code-author-orphan' => 'എസ്.വി.എൻ. ഉപയോക്താവ്/രചയിതാവ് $1 വിക്കി അംഗത്വങ്ങളിലോട്ടൊന്നും കണ്ണി നൽകിയിട്ടില്ല',
	'code-author-dolink' => 'ഈ ഉപയോക്താവിനെ കണ്ണി ചേർക്കേണ്ട  വിക്കി ഉപയോക്താവ്:',
	'code-author-alterlink' => 'ഈ രചയിതാവുമായി കണ്ണി ചേർക്കപ്പെട്ട വിക്കി ഉപയോക്താവിനെ മാറ്റുക:',
	'code-author-orunlink' => 'അല്ലെങ്കിൽ വിക്കി ഉപയോക്താവിന്റെ കണ്ണി നീക്കം ചെയ്യുക:',
	'code-author-name' => 'ഒരു ഉപയോക്തൃനാമം നൽകുക:',
	'code-author-success' => '$1 എന്ന രചയിതാവ് $2 എന്ന വിക്കി ഉപയോക്താവുമായി കണ്ണി ചേർക്കപ്പെട്ടിരിക്കുന്നു',
	'code-author-link' => 'കണ്ണി വേണോ?',
	'code-author-unlink' => 'കണ്ണി നീക്കണോ?',
	'code-author-unlinksuccess' => '$1 എന്ന രചയിതാവിന്റെ കണ്ണി നീക്കം ചെയ്തിരിക്കുന്നു',
	'code-author-badtoken' => 'പ്രവൃത്തി ചെയ്യാൻ ശ്രമിക്കുമ്പോൾ സെഷൻ പിഴവ് ഉണ്ടായിരിക്കുന്നു.',
	'code-author-total' => 'ആകെ രചയിതാക്കൾ: $1',
	'code-author-lastcommit' => 'അവസാനം ഉൾപ്പെടുത്തിയ തീയതി',
	'code-browsing-path' => "'''$1''' എന്നതിലുൾപ്പെടുന്ന നാൾപ്പതിപ്പുകൾ കാണുന്നു",
	'code-field-id' => 'നാൾപ്പതിപ്പ്',
	'code-field-author' => 'രചയിതാവ്',
	'code-field-user' => 'അഭിപ്രായപ്പെട്ടയാൾ',
	'code-field-message' => 'കൈക്കൊണ്ട പ്രവൃത്തിയുടെ ചുരുക്കം',
	'code-field-status' => 'സ്ഥിതി',
	'code-field-status-description' => 'തൽസ്ഥിതിയുടെ വിവരണം',
	'code-field-timestamp' => 'തീയതി',
	'code-field-comments' => 'അഭിപ്രായങ്ങൾ',
	'code-field-path' => 'പഥം',
	'code-field-text' => 'കുറിപ്പ്',
	'code-field-select' => 'തിരഞ്ഞെടുക്കുക',
	'code-reference-remove' => 'തിരഞ്ഞെടുത്ത ഭാഗഭാക്കാകലുകൾ നീക്കംചെയ്യുക',
	'code-reference-associate' => 'പിന്തുടർച്ചാ നാൾപ്പതിപ്പുകളിൽ ഭാഗഭാക്കാകുക:',
	'code-reference-associate-submit' => 'ഭാഗാഭാക്കാകുക',
	'code-rev-author' => 'രചയിതാവ്:',
	'code-rev-date' => 'തീയതി:',
	'code-rev-message' => 'അഭിപ്രായം:',
	'code-rev-repo' => 'റെപ്പോസിറ്ററി:',
	'code-rev-rev' => 'നാൾപ്പതിപ്പ്:',
	'code-rev-rev-viewvc' => 'വ്യൂ വി.സി.യിൽ',
	'code-rev-paths' => 'മാറ്റം വരുത്തിയ പഥങ്ങൾ:',
	'code-rev-modified-a' => 'കൂട്ടിച്ചേർത്തു',
	'code-rev-modified-r' => 'പകരം വെച്ചു',
	'code-rev-modified-d' => 'മായ്ച്ചിരിക്കുന്നു',
	'code-rev-modified-m' => 'മാറ്റം വരുത്തി',
	'code-rev-imagediff' => 'ചിത്രത്തിന്റെ മാറ്റങ്ങൾ',
	'code-rev-status' => 'സ്ഥിതി:',
	'code-rev-status-set' => 'സ്ഥിതി മാറ്റുക',
	'code-rev-tags' => 'റ്റാഗുകൾ:',
	'code-rev-tag-add' => 'റ്റാഗുകൾ ചേർക്കുക:',
	'code-rev-tag-remove' => 'റ്റാഗുകൾ നീക്കം ചെയ്യുക:',
	'code-rev-comment-by' => '$1 ഇട്ട അഭിപ്രായം',
	'code-rev-comment-preview' => 'എങ്ങനെയുണ്ടെന്ന് കാണുക',
	'code-rev-inline-preview' => 'എങ്ങനെയുണ്ടെന്നു കാണുക:',
	'code-rev-diff' => 'വ്യത്യാസം',
	'code-rev-diff-link' => 'വ്യത്യാസം',
	'code-rev-diff-too-large' => 'വ്യത്യാസം പ്രദർശിപ്പിക്കാവുന്നതിലും കൂടുതലാണ്.',
	'code-rev-purge-link' => 'ശുദ്ധമാക്കുക',
	'code-rev-total' => 'ആകെ ഫലങ്ങളുടെ എണ്ണം: $1',
	'code-rev-not-found' => "നാൾപ്പതിപ്പ് '''$1''' നിലവിലില്ല!",
	'code-rev-history-link' => 'നാൾവഴി',
	'code-status-new' => 'പുതിയത്',
	'code-status-desc-new' => 'നാൾപ്പതിപ്പിന് ഒരു പ്രവൃത്തി അവശേഷിക്കുന്നു (സ്വതേയുള്ള സ്ഥിതി).',
	'code-status-fixme' => 'ഈ പ്രശ്നം പരിഹരിക്കുക',
	'code-status-desc-fixme' => 'ഈ നാൾപ്പതിപ്പ് ബഗ് ആണെന്നോ തകർന്നതാണെന്നോ കാണിക്കുന്നു. ഇത് ശരിയാക്കുകയോ മുൻപ്രാപനം ചെയ്യുകയോ ചെയ്യേണ്ടതാണ്.',
	'code-status-reverted' => 'മുൻപ്രാപനം ചെയ്തിരിക്കുന്നു',
	'code-status-desc-reverted' => 'പിന്നീട് വന്ന നാൾപ്പതിപ്പിനാൽ ഈ നാൾപ്പതിപ്പ് മാറ്റപ്പെട്ടിരിക്കുന്നു.',
	'code-status-resolved' => 'പരിഹരിച്ചിരിക്കുന്നു',
	'code-status-desc-resolved' => 'പിന്നീടുള്ള ഒരു നാൾപ്പതിപ്പിൽ പരിഹരിക്കേണ്ട ഒരു പ്രശ്നം നാൾപ്പതിപ്പിലുണ്ടായിരുന്നു.',
	'code-status-ok' => 'ശരി',
	'code-status-desc-ok' => 'നാൾപ്പതിപ്പ് പൂർണ്ണമായും സംശോധനം ചെയ്തിരിക്കുന്നു, അത് എല്ലാ വിധത്തിലും നല്ലതാണെന്ന് സംശോധകൻ ഉറപ്പാക്കിയിരിക്കുന്നു.',
	'code-status-deferred' => 'നീട്ടിവെച്ചിരിക്കുന്നു',
	'code-status-desc-deferred' => 'നാൾപ്പതിപ്പിൽ സംശോധനം ആവശ്യമില്ല.',
	'code-status-old' => 'പഴയത്',
	'code-status-desc-old' => 'സംശോധനം തന്നെ സാദ്ധ്യമല്ലാത്ത വിധത്തിൽ ബഗുകൾ ഉള്ള പഴയ നാൾപ്പതിപ്പ്.',
	'code-signoffs' => 'അവസാനിപ്പിച്ചിറങ്ങലുകൾ',
	'code-signoff-legend' => 'അവസാനിപ്പിച്ചിറങ്ങൽ ചേർക്കുക',
	'code-signoff-submit' => 'അവസാനിപ്പിച്ചിറങ്ങുക',
	'code-signoff-strike' => 'തിരഞ്ഞെടുത്ത അവസാനിപ്പിക്കലുകൾ വെട്ടുക',
	'code-signoff-signoff' => 'ഈ നാൾപ്പതിപ്പ് അവസാനിപ്പിച്ചിറങ്ങുക',
	'code-signoff-flag-inspected' => 'പരിശോധിച്ചു',
	'code-signoff-flag-tested' => 'പ്രവർത്തിപ്പിച്ച് നോക്കിയത്',
	'code-signoff-field-user' => 'ഉപയോക്താവ്',
	'code-signoff-field-flag' => 'പതാക',
	'code-signoff-field-date' => 'തീയതി',
	'code-signoff-struckdate' => '$1 ($2 തടയൽ)',
	'code-pathsearch-legend' => 'ഈ റെപ്പോയിലെ നാൾപ്പതിപ്പുകൾ പഥമനുസരിച്ച് തിരയുക',
	'code-pathsearch-path' => 'പഥം:',
	'code-pathsearch-filter' => 'പ്രദർശിപ്പിക്കേണ്ടത്:',
	'code-revfilter-cr_status' => 'സ്ഥിതി = $1',
	'code-revfilter-cr_author' => 'രചയിതാവ് = $1',
	'code-revfilter-ct_tag' => 'റ്റാഗ് = $1',
	'code-revfilter-clear' => 'അരിപ്പ ശുദ്ധമാക്കുക',
	'code-rev-submit' => 'മാറ്റങ്ങൾ സേവ് ചെയ്യുക',
	'code-rev-submit-next' => 'സേവ് ചെയ്യുക, പരിഹരിക്കാത്ത അടുത്തതിലേയ്ക്ക് പോവുക',
	'code-rev-next' => 'പരിഹരിക്കപ്പെടാത്ത അടുത്തത്',
	'code-batch-status' => 'സ്ഥിതിയിൽ മാറ്റം വരുത്തുക:',
	'code-batch-tags' => 'റ്റാഗുകൾ മാറ്റുക:',
	'codereview-batch-title' => 'തിരഞ്ഞെടുത്ത എല്ലാ നാൾപ്പതിപ്പുകളിലും മാറ്റം‌‌വരുത്തുക',
	'codereview-batch-submit' => 'സമർപ്പിക്കുക',
	'code-releasenotes' => 'പ്രകാശന കുറിപ്പുകൾ',
	'code-release-legend' => 'പുറത്തിറക്കൽ കുറിപ്പുകൾ സൃഷ്ടിക്കുക',
	'code-release-startrev' => 'ആദ്യ നാൾപ്പതിപ്പ്:',
	'code-release-endrev' => 'അവസാന നാൾപ്പതിപ്പ്:',
	'codereview-subtitle' => 'റെപ്പോസിറ്ററി $1',
	'codereview-reply-link' => 'മറുപടി',
	'codereview-overview-title' => 'അവലോകനം',
	'codereview-overview-desc' => 'ഈ പട്ടികയുടെ ഗ്രാഫിക്കൽ അവലോകനം പ്രദർശിപ്പിക്കുക',
	'codereview-email-subj' => '[$1 $2]: പുതിയ അഭിപ്രായം ചേർത്തിരിക്കുന്നു',
	'codereview-email-body' => '$3 താളിൽ "$1" എന്ന ഉപയോക്താവ് ഒരു അഭിപ്രായം ചേർത്തിരിക്കുന്നു.

പൂർണ്ണ യൂ.ആർ.എൽ.: $2
ഉൾപ്പെടുത്തലിന്റെ സംഗ്രഹം:

$5

അഭിപ്രായം:

$4',
	'codereview-email-subj2' => '[$1 $2]: പിന്തുടർച്ചാ മാറ്റങ്ങൾ',
	'codereview-email-body2' => '"$1" എന്ന ഉപയോക്താവ് $2 എന്നതിനു പിന്തുടർച്ചാ മാറ്റങ്ങൾ നടത്തിയിരിക്കുന്നു.

പിന്തുടർച്ചാനാൾപ്പതിപ്പിന്റെ പൂർണ്ണ യൂ.ആർ.എൽ.: $5
ഉൾപ്പെടുത്തലിന്റെ സംഗ്രഹം:

$6

പൂർണ്ണ യു.ആർ.എൽ.: $3
ഉൾപ്പെടുത്തലിന്റെ സംഗ്രഹം:

$4',
	'codereview-email-subj3' => '[$1 $2]: നാൾപ്പതിപ്പിന്റെ സ്ഥിതി മാറ്റിയിരിക്കുന്നു',
	'codereview-email-body3' => '$2 എന്നതിന്റെ സ്ഥിതി "$1" എന്ന ഉപയോക്താവ് മാറ്റിയിരിക്കുന്നു.

പഴയ സ്ഥിതി: $3
പുതിയ സ്ഥിതി: $4

പൂർണ്ണ യു.ആർ.എൽ.: $5
ഉൾപ്പെടുത്തലിന്റെ സംഗ്രഹം:

$6',
	'codereview-email-subj4' => '[$1 $2]: പുതിയ കുറിപ്പ് ചേർത്തിരിക്കുന്നു, നാൾപ്പതിപ്പിന്റെ സ്ഥിതി മാറ്റിയിരിക്കുന്നു',
	'codereview-email-body4' => '$2 എന്നതിന്റെ സ്ഥിതി "$1" എന്ന ഉപയോക്താവ് മാറ്റിയിരിക്കുന്നു.

പഴയ സ്ഥിതി: $3
പുതിയ സ്ഥിതി: $4

$2 എന്നതിന് ഉപയോക്താവ് "$1" ഒരു കുറിപ്പും ഇട്ടിട്ടുണ്ട്.

പൂർണ്ണ യൂ.ആർ.എൽ.: $5
ഉൾപ്പെടുത്തലിന്റെ സംഗ്രഹം:

$7

അഭിപ്രായം:

$6',
	'code-stats' => 'സ്ഥിതിവിവരക്കണക്കുകൾ',
	'code-stats-header' => '$1 എന്ന റെപ്പോസിറ്ററിയുടെ സ്ഥിതിവിവരക്കണക്കുകൾ',
	'code-stats-main' => '$1-ൽ, റെപ്പോസിറ്ററിയിൽ [[Special:Code/$3/author|{{PLURAL:$4|ഒരു രചയിതാവ്|$4 രചയിതാക്കൾ}}]] സൃഷ്ടിച്ച {{PLURAL:$2|ഒരു നാൾപതിപ്പ്|$2 നാൾപ്പതിപ്പുകൾ}} ഉണ്ട്.',
	'code-stats-status-breakdown' => 'ഓരോ സ്ഥിതിയിലുമുള്ള നാൾപ്പതിപ്പുകളുടെ എണ്ണം',
	'code-stats-fixme-breakdown' => 'ഓരോ രചയിതാക്കളും ശരിയാക്കിയ പ്രശ്നങ്ങളിലുണ്ടായ ഭ്രംശങ്ങൾ',
	'code-stats-count' => 'നാൾപ്പതിപ്പുകളുടെ എണ്ണം',
	'repoadmin' => 'റെപ്പോസിറ്ററി കാര്യനിർവഹണം',
	'repoadmin-new-legend' => 'പുതിയ റെപ്പോസിറ്ററി സൃഷ്ടിക്കുക',
	'repoadmin-new-label' => 'റെപ്പോസിറ്ററിയുടെ പേര്:',
	'repoadmin-new-button' => 'സൃഷ്ടിക്കുക',
	'repoadmin-edit-legend' => '"$1" റെപ്പോസിറ്ററിയിൽ വരുത്തിയ മെച്ചപ്പെടുത്തലുകൾ',
	'repoadmin-edit-path' => 'റെപ്പോസിറ്ററിയുടെ പഥം:',
	'repoadmin-edit-bug' => 'ബഗ്‌സില്ല പഥം:',
	'repoadmin-edit-view' => 'വ്യൂ‌‌‌‌വിസി പഥം:',
	'repoadmin-edit-button' => 'ശരി',
	'repoadmin-edit-sucess' => '"[[Special:Code/$1|$1]]" എന്ന റെപ്പോസിറ്ററി വിജയകരമായി പുതുക്കിയിരിക്കുന്നു.',
	'repoadmin-nav' => 'റെപ്പോസിറ്ററി കാര്യനിർവഹണം',
	'right-repoadmin' => 'കോഡ് റെപ്പോസിറ്ററിയുടെ കൈകാര്യം',
	'right-codereview-use' => 'Special:Code ഉപയോഗം',
	'right-codereview-add-tag' => 'നാൾപ്പതിപ്പുകൾക്ക് പുതിയ റ്റാഗുകൾ ചേർക്കുക',
	'right-codereview-remove-tag' => 'നാൾപ്പതിപ്പുകളിൽ നിന്നും റ്റാഗുകൾ നീക്കുക',
	'right-codereview-post-comment' => 'നാൾപ്പതിപ്പുകളിൽ അഭിപ്രായങ്ങൾ ചേർക്കുക',
	'right-codereview-set-status' => 'നാൾപ്പതിപ്പുകളുടെ സ്ഥിതിയിൽ മാറ്റം വരുത്തുക',
	'right-codereview-signoff' => 'നാൾപ്പതിപ്പുകൾ അവസാനിപ്പിച്ചിറങ്ങുക',
	'right-codereview-link-user' => 'രചയിതാക്കളെ വിക്കി ഉപയോക്താക്കളുമായി കണ്ണി ചേർക്കുക',
	'right-codereview-associate' => 'നാൾപ്പതിപ്പ് ബന്ധങ്ങളുടെ കൈകാര്യം',
	'right-codereview-review-own' => 'താങ്കൾ സ്വയം സൃഷ്ടിച്ച നാൾപ്പതിപ്പുകൾ ശരിയാണെന്നോ പരിഹരിക്കപ്പെട്ടവയെന്നോ അടയാളപ്പെടുത്തുക',
	'specialpages-group-developer' => 'വികസന ഉപകരണങ്ങൾ',
	'group-svnadmins' => 'എസ്.വി.എൻ. കാര്യനിർവ്വഹകർ',
	'group-svnadmins-member' => '{{GENDER:$1|എസ്.വി.എൻ. കാര്യനിർവാഹകൻ|എസ്.വി.എൻ. കാര്യനിർവാഹക}}',
	'grouppage-svnadmins' => '{{ns:project}}:എസ്.വി.എൻ. കാര്യനിർവാഹകർ',
);

/** Mongolian (Монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'code-comments' => 'Тайлбар',
	'code-field-id' => 'Засвар',
	'code-rev-message' => 'Тайлбар:',
	'code-rev-rev' => 'Засвар:',
	'code-status-reverted' => 'хуучин төлөвт шилжүүлэв',
	'codereview-batch-submit' => 'Явуулах',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aviator
 * @author Izzudin
 */
$messages['ms'] = array(
	'code' => 'Kajian Kod',
	'code-rev-title' => '$1 - Kajian Kod',
	'code-comments' => 'Komen',
	'code-references' => 'Semakan susulan',
	'code-referenced' => 'Semakan yang dilakukan',
	'code-change-status' => "'''status''' $1 ditukar",
	'code-change-tags' => "'''label''' untuk $1 ditukar",
	'code-change-removed' => 'membuang:',
	'code-change-added' => 'menambah:',
	'code-old-status' => 'Status lama',
	'code-new-status' => 'Status baru',
	'code-prop-changes' => 'Log status & label',
	'codereview-desc' => '[[Special:Code|Alat mengkaji kod]] dengan [[Special:RepoAdmin|sokongan Subversion]]',
	'code-no-repo' => 'Tiada gedung yang ditetapkan!',
	'code-create-repo' => 'Pergi ke [[Special:RepoAdmin|RepoAdmin]] untuk membuka Gedung',
	'code-need-repoadmin-rights' => 'hak repoadmin (pentadbir gedung) diperlukan untuk membuka Gedung',
	'code-need-group-with-rights' => 'Tiada kumpulan yang memegang hak repoadmin. Sila tambahkan satu kumpulan sedemikian supaya dapat membuat Gedung baru',
	'code-repo-not-found' => "Gedung '''$1''' tidak wujud!",
	'code-load-diff' => 'Memuat perbezaan…',
	'code-notes' => 'komen terbaru',
	'code-statuschanges' => 'perubahan status',
	'code-mycommits' => 'lakuan saya',
	'code-mycomments' => 'komen saya',
	'code-authors' => 'pengarang',
	'code-status' => 'status',
	'code-tags' => 'label',
	'code-tags-no-tags' => 'Tiada tag dalam gedung ini.',
	'code-authors-text' => 'Yang berikut ialah senarai pengarang gedung mengikut tertib lakuan terkini. Akaun wiki tempatan ditunjukkan dalam tanda kurungan. Data mungkin dicachekan.',
	'code-author-haslink' => 'Pengarang ini dihubungkan dengan pengguna wiki $1',
	'code-author-orphan' => 'Pengguna SVN/Pengarang $1 tiada pautan dengan akaun wiki',
	'code-author-dolink' => 'Hubungkan pengarang ini dengan pengguna wiki:',
	'code-author-alterlink' => 'Tukar pengguna wiki yang dihubungkan dengan pengarang ini:',
	'code-author-orunlink' => 'Atau putuskan hubungan pengguna wiki ini:',
	'code-author-name' => 'Masukkan nama pengguna:',
	'code-author-success' => 'Pengarang $1 telah dihubungkan dengan pengguna wiki $2',
	'code-author-link' => 'hubungkan?',
	'code-author-unlink' => 'putuskan?',
	'code-author-unlinksuccess' => 'Hubungan pengarang $1 telah diputuskan',
	'code-author-badtoken' => 'Ralat sesi ketika cuba melakukan tindakan.',
	'code-author-total' => 'Jumlah pengarang: $1',
	'code-author-lastcommit' => 'Tarikh lakuan terakhir',
	'code-browsing-path' => "Menyemak seimbas semakan dalam '''$1'''",
	'code-field-id' => 'Semakan',
	'code-field-author' => 'Pengarang',
	'code-field-user' => 'Pengulas',
	'code-field-message' => 'Ringkasan lakuan',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Keterangan status',
	'code-field-timestamp' => 'Tarikh',
	'code-field-comments' => 'Ulasan',
	'code-field-path' => 'Laluan',
	'code-field-text' => 'Catatan',
	'code-field-select' => 'Pilih',
	'code-reference-remove' => 'Buang perkaitan terpilih',
	'code-reference-associate' => 'Semakan susulan berkaitan:',
	'code-reference-associate-submit' => 'Perkaitan',
	'code-rev-author' => 'Pengarang:',
	'code-rev-date' => 'Tarikh:',
	'code-rev-message' => 'Ulasan:',
	'code-rev-repo' => 'Gudang:',
	'code-rev-rev' => 'Semakan:',
	'code-rev-rev-viewvc' => 'di ViewVC',
	'code-rev-paths' => 'Laluan yang diubah:',
	'code-rev-modified-a' => 'ditambah',
	'code-rev-modified-r' => 'diganti',
	'code-rev-modified-d' => 'dihapuskan',
	'code-rev-modified-m' => 'diubah',
	'code-rev-imagediff' => 'Perubahan imej',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Tukar status',
	'code-rev-tags' => 'Label:',
	'code-rev-tag-add' => 'Tambah label:',
	'code-rev-tag-remove' => 'Buang label:',
	'code-rev-comment-by' => 'Ulasan oleh $1',
	'code-rev-comment-preview' => 'Pralihat',
	'code-rev-inline-preview' => 'Pralihat:',
	'code-rev-diff' => 'Beza',
	'code-rev-diff-link' => 'beza',
	'code-rev-diff-too-large' => 'Perbezaan ini terlalu besar untuk dipaparkan.',
	'code-rev-purge-link' => 'singkirkan',
	'code-rev-total' => 'Jumlah hasil: $1',
	'code-rev-not-found' => "Semakan '''$1''' tidak wujud!",
	'code-rev-history-link' => 'sejarah',
	'code-status-new' => 'baru',
	'code-status-desc-new' => 'Pindaan menunggu tindakan (status asali).',
	'code-status-fixme' => 'baiki',
	'code-status-desc-fixme' => 'Semakan membawa pepijat atau rosak, dan patut dibetulkan atau dibatalkan.',
	'code-status-reverted' => 'dibatalkan',
	'code-status-desc-reverted' => 'Semakan dibuat asal oleh semakan kemudian.',
	'code-status-resolved' => 'beres',
	'code-status-desc-resolved' => 'Semakan mengalami masalah yang diselesaikan oleh semakan kemudian.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Semakan dikaji sepenihnya. Pengkaji pasti bahawa ia elok sepenuhnya.',
	'code-status-deferred' => 'tunda',
	'code-status-desc-deferred' => 'Semakan tidak memerlukan kajian.',
	'code-status-old' => 'lama',
	'code-status-desc-old' => 'Semakan lama yang mungkin mengandungi pepijat tetapi tidak berbaloi dikaji.',
	'code-signoffs' => 'Rakam keluar',
	'code-signoff-legend' => 'Bubuh rakam keluar',
	'code-signoff-submit' => 'Rakam keluar',
	'code-signoff-strike' => 'Potong rakam keluar terpilih',
	'code-signoff-signoff' => 'Rakam keluar semakan ini sebagai:',
	'code-signoff-flag-inspected' => 'Diperiksa',
	'code-signoff-flag-tested' => 'Diuji',
	'code-signoff-field-user' => 'Pengguna',
	'code-signoff-field-flag' => 'Bendera',
	'code-signoff-field-date' => 'Tarikh',
	'code-signoff-struckdate' => '$1 (memotong $2)',
	'code-pathsearch-legend' => 'Cari semakan dalam gedung ini mengikut laluan',
	'code-pathsearch-path' => 'Laluan:',
	'code-pathsearch-filter' => 'Hanya tunjukkan:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Pengarang = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => 'Kosongkan penapis',
	'code-rev-submit' => 'Simpan perubahan',
	'code-rev-submit-next' => 'Simpan & selesaikan yang berikutnya',
	'code-rev-next' => 'Semakan tak terselesai yang seterusnya',
	'code-batch-status' => 'Tukar status:',
	'code-batch-tags' => 'Tukar label:',
	'codereview-batch-title' => 'Tukar semua semakan yang dipilih',
	'codereview-batch-submit' => 'Serahkan',
	'code-releasenotes' => 'catatan lepasan',
	'code-release-legend' => 'Jana catatan lepasan',
	'code-release-startrev' => 'Semakan pertama:',
	'code-release-endrev' => 'Semakan terakhir:',
	'codereview-subtitle' => 'Untuk $1',
	'codereview-reply-link' => 'balas',
	'codereview-overview-title' => 'Intisari',
	'codereview-overview-desc' => 'Tunjukkan gambaran keseluruhan senarai ini dalam bentuk grafik',
	'codereview-email-subj' => '[$1] [s$2]: Ulasan baru',
	'codereview-email-body' => 'Pengguna "$1" mengirim ulasan bagi s$3.

URL penuh: $2
Ringkasan:

$5

Ulasan:

$4',
	'codereview-email-subj2' => '[$1 $2]: Perubahan susulan',
	'codereview-email-body2' => 'Pengguna "$1" membuat perubahan susulan pada $2.

URL penuh untuk semakan yang disusuli: $5
Ringkasan lakuan:

$6

URL penuh: $3
Ringkasan:

$4',
	'codereview-email-subj3' => '[$1 $2]: Status semakan diubah',
	'codereview-email-body3' => 'Pengguna "$1" mengubah status $2.

Status Lama: $3
Status Baru: $4

URL penuh: $5
Ringkasan:

$6',
	'codereview-email-subj4' => '[$1 $2]: Komen baru ditambahkan, dan status semakan diubah',
	'codereview-email-body4' => 'Pengguna "$1" mengubah status $2.

Status Lama: $3
Status Baru: $4

Pengguna "$1" juga mencatatkan komen di $2.

URL penuh: $5
Ringkasan:

$7

Komen:

$6',
	'code-stats' => 'statistik',
	'code-stats-header' => 'Statistik untuk gedung $1',
	'code-stats-main' => 'Pada $1, gedung ini mendapat $2 semakan oleh [[Special:Code/$3/author|$4 pengarang]].',
	'code-stats-status-breakdown' => 'Bilangan semakan per keadaan',
	'code-stats-fixme-breakdown' => 'Pecahan semakan dibaiki sepengarang',
	'code-stats-fixme-breakdown-path' => 'Pecahan semakan dibaiki selaluan',
	'code-stats-fixme-path' => 'Semakan dibaiki untuk laluan: $1',
	'code-stats-new-breakdown' => 'Pecahan semakan baru sepengarang',
	'code-stats-new-breakdown-path' => 'Pecahan semakan baru selaluan',
	'code-stats-new-path' => 'Semakan baru untuk laluan: $1',
	'code-stats-count' => 'Bilangan semakan',
	'code-tooltip-withsummary' => 'r$1 [$2] oleh $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] oleh $3',
	'repoadmin' => 'Pentadbiran Gedung',
	'repoadmin-new-legend' => 'Cipta gedung baru',
	'repoadmin-new-label' => 'Nama gedung:',
	'repoadmin-new-button' => 'Cipta',
	'repoadmin-edit-legend' => 'Ubah suai gedung "$1"',
	'repoadmin-edit-path' => 'Laluan gedung:',
	'repoadmin-edit-bug' => 'Laluan Bugzilla:',
	'repoadmin-edit-view' => 'Laluan ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Gedung "[[Special:Code/$1|$1]]" telah diubahsuai.',
	'repoadmin-nav' => 'pentadbiran gedung',
	'right-repoadmin' => 'Mengurus gedung kod',
	'right-codereview-use' => 'Menggunakan Special:Code',
	'right-codereview-add-tag' => 'Menambahkan label pada semakan',
	'right-codereview-remove-tag' => 'Membuang label daripada semakan',
	'right-codereview-post-comment' => 'Menambah ulasan pada semakan',
	'right-codereview-set-status' => 'Menukar status semakan',
	'right-codereview-signoff' => 'Meluluskan semakan',
	'right-codereview-link-user' => 'Membuat pautan dari pengarang ke pengguna wiki',
	'right-codereview-associate' => 'Mengurus perkaitan semakan',
	'right-codereview-review-own' => 'Menandai semakan sendiri sebagai "{{int:code-status-ok}}" atau "{{int:code-status-resolved}}"',
	'action-repoadmin' => 'mengurus gedung kod',
	'action-codereview-use' => 'menggunakan Special:Code',
	'action-codereview-add-tag' => 'menambahkan label pada semakan',
	'action-codereview-remove-tag' => 'membuang label daripada semakan',
	'action-codereview-post-comment' => 'menambahkan ulasan pada semakan',
	'action-codereview-set-status' => 'menukar status semakan',
	'action-codereview-signoff' => 'meluluskan semakan',
	'action-codereview-link-user' => 'membuat pautan dari pengarang ke pengguna wiki',
	'action-codereview-associate' => 'mengurus perkaitan semakan',
	'action-codereview-review-own' => 'Menandai semakan sendiri sebagai "{{int:code-status-ok}}" atau "{{int:code-status-resolved}}"',
	'specialpages-group-developer' => 'Alatan pembangun',
	'group-svnadmins' => 'Pentadbir SVN',
	'group-svnadmins-member' => '{{GENDER:$1|pentadbir SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Pentadbir SVN',
);

/** Maltese (Malti)
 * @author Chrisportelli
 */
$messages['mt'] = array(
	'code-author-total' => "Numru totali ta' awturi: $1",
	'code-author-lastcommit' => "Data tal-aħħar ''commit''",
	'code-browsing-path' => "Esplora r-reviżjonijiet f''''$1'''",
	'code-field-id' => 'Reviżjoni',
	'code-field-author' => 'Awtur',
	'code-field-user' => 'Awtur tal-kumment',
	'code-field-message' => "Taqsira tal-''commit''",
	'code-field-status' => 'Stat',
);

/** Erzya (Эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'code-change-added' => 'поладозь:',
	'code-authors' => 'теицянзо',
	'code-author-name' => 'Совавтт теицянь лем:',
	'code-author-link' => 'аравтомс сюлмавома пе?',
	'code-author-unlink' => 'саемс сюлмавома пененть?',
	'code-author-unlinksuccess' => 'Теицянзо $1 сюлмавома пезэ саезь',
	'code-field-id' => 'Лиякстомтома',
	'code-field-author' => 'Теицязо',
	'code-field-user' => 'Мелень-арьсемань каицязо',
	'code-field-timestamp' => 'Ковчизэ',
	'code-field-path' => 'Яннэ',
	'code-field-select' => 'Кочкамс',
	'code-rev-author' => 'Теицязо:',
	'code-rev-date' => 'Ковчизэ:',
	'code-rev-modified-a' => 'поладозь',
	'code-rev-modified-d' => 'нардазь',
	'code-rev-modified-m' => 'лиякстомтозь',
	'code-rev-comment-preview' => 'Васнянь неевтезэ',
	'code-rev-diff' => 'Мейсэ явовить верзиятне',
	'code-rev-purge-link' => 'панемс',
	'code-status-new' => 'од',
	'code-status-fixme' => 'витемак',
	'code-status-old' => 'ташто',
	'code-pathsearch-path' => 'Яннэсь:',
	'code-revfilter-cr_author' => 'Авторозо = $1',
	'code-stats' => 'статистикат',
	'repoadmin-new-button' => 'Шкик-теик',
	'repoadmin-edit-button' => 'Маштови',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 * @author Teòtlalili
 */
$messages['nah'] = array(
	'code-author-link' => '¿motzòwìs?',
	'code-author-unlink' => '¿motzòwilkỏtònas?',
	'code-status-ok' => 'quēmah',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Event
 * @author Jon Harald Søby
 * @author Laaknor
 * @author Lokal Profil
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'code' => 'Kodegjennomgang',
	'code-rev-title' => '$1 - Kodegjennomgang',
	'code-comments' => 'Kommentarer',
	'code-references' => 'Oppfølgende versjoner',
	'code-change-status' => "endret '''statusen''' for $1",
	'code-change-tags' => "endret '''taggene''' for $1",
	'code-change-removed' => 'fjernet:',
	'code-change-added' => 'la til:',
	'code-old-status' => 'Gammel status',
	'code-new-status' => 'Ny status',
	'code-prop-changes' => 'Logg for status og tagging',
	'codereview-desc' => '[[Special:Code|Kodegjennomgangsverktøy]] med [[Special:RepoAdmin|støtte for Subversion]]',
	'code-no-repo' => 'Ingen database konfigurert!',
	'code-create-repo' => 'Gå til [[Special:RepoAdmin|RepoAdmin]] for å opprette et repositorium',
	'code-need-repoadmin-rights' => 'repoadminrettigheter kreves for å kunne opprette et repositorium',
	'code-need-group-with-rights' => 'Ingen grupper med repoadminrettigheter finnes. Legg til en for å kunne legge til et nytt repositorium',
	'code-repo-not-found' => "Lageret '''$1''' finnes ikke!",
	'code-load-diff' => 'Laster diff...',
	'code-notes' => 'Siste kommentarer',
	'code-statuschanges' => 'statusendringer',
	'code-mycommits' => 'mine innsendinger',
	'code-mycomments' => 'mine kommentarer',
	'code-authors' => 'forfattere',
	'code-status' => 'tilstander',
	'code-tags' => 'tagger',
	'code-tags-no-tags' => 'Ingen merkelapper finnes i dette repositoriet.',
	'code-authors-text' => 'Nedenfor er en liste over repo-forfattere sortert etter bidragsnavn. Lokale wikikontoer vises i parantes. Data kan være hurtiglagret.',
	'code-author-haslink' => 'Denne forfatteren er lenket til wikibruker $1',
	'code-author-orphan' => 'SVN-bruker/Forfatter $1 har ingen lenke til en wikikonto',
	'code-author-dolink' => 'Lenk denne forfatteren til en wikibruker:',
	'code-author-alterlink' => 'Endre denne wikibrukeren til denne forfatteren:',
	'code-author-orunlink' => 'Eller fjern lenke til denne wikibrukeren:',
	'code-author-name' => 'Skriv inn et brukernavn:',
	'code-author-success' => 'Forfatteren $1 har blitt lenket med wikibruker $2',
	'code-author-link' => 'lenke?',
	'code-author-unlink' => 'fjern lenke?',
	'code-author-unlinksuccess' => 'Forfatter $1 er ikke lenger lenket',
	'code-author-badtoken' => 'Sesjonsfeil når handlingen ble forsøkt utført.',
	'code-author-total' => 'Totalt antall forfattere: $1',
	'code-author-lastcommit' => 'Siste bidragsdato',
	'code-browsing-path' => "Blar igjennom revisjoner i '''$1'''",
	'code-field-id' => 'Revisjon',
	'code-field-author' => 'Forfatter',
	'code-field-user' => 'Kommentator',
	'code-field-message' => 'Endringssammendrag',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Statusbeskrivelse',
	'code-field-timestamp' => 'Dato',
	'code-field-comments' => 'Kommentarer',
	'code-field-path' => 'Sti',
	'code-field-text' => 'Notat',
	'code-field-select' => 'Velg',
	'code-reference-remove' => 'Fjern valgte merker',
	'code-reference-associate' => 'Merk revisjon for oppfølging:',
	'code-reference-associate-submit' => 'Merk',
	'code-rev-author' => 'Forfatter:',
	'code-rev-date' => 'Dato:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Database:',
	'code-rev-rev' => 'Revisjon:',
	'code-rev-rev-viewvc' => 'på ViewVC',
	'code-rev-paths' => 'Endrede stier:',
	'code-rev-modified-a' => 'lagt til',
	'code-rev-modified-r' => 'erstattet',
	'code-rev-modified-d' => 'slettet',
	'code-rev-modified-m' => 'endret',
	'code-rev-imagediff' => 'Bildeendringer',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Endre status',
	'code-rev-tags' => 'Tagger:',
	'code-rev-tag-add' => 'Legg til tagger:',
	'code-rev-tag-remove' => 'Fjern tagger:',
	'code-rev-comment-by' => 'Kommentar av $1',
	'code-rev-comment-preview' => 'Forhåndsvisning',
	'code-rev-inline-preview' => 'Forhåndsvisning:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'Revisjonsforskjellen er for stor til å vises.',
	'code-rev-purge-link' => 'Rense',
	'code-rev-total' => 'Totalt antall resultat: $1',
	'code-rev-not-found' => "Revisjon '''$1''' eksisterer ikke!",
	'code-rev-history-link' => 'historikk',
	'code-status-new' => 'ny',
	'code-status-desc-new' => 'Revisjon venter på en handling (standard status).',
	'code-status-fixme' => 'fiksmeg',
	'code-status-desc-fixme' => 'Endringen innførte en feil eller ble bare delvis gjennomført. Den må repareres eller tilbakestilles.',
	'code-status-reverted' => 'tilbakestilt',
	'code-status-desc-reverted' => 'Revisjonen ble kastet vekk av en senere revisjon.',
	'code-status-resolved' => 'løst',
	'code-status-desc-resolved' => 'Revisjonen hadde et problem som ble adressert av en senere revisjon.',
	'code-status-ok' => 'OK',
	'code-status-desc-ok' => 'Revisjonen er fullstendig gjennomgått og anmelder er sikker på at den er OK på alle måter.',
	'code-status-deferred' => 'utsatt',
	'code-status-desc-deferred' => 'Revisjon krever ikke gjennomgang.',
	'code-status-old' => 'gammel',
	'code-status-desc-old' => 'Gammel revisjon med potensielle feil, men som ikker er verdt innsatsen med å gjenngå dem.',
	'code-signoffs' => 'Underskrifter',
	'code-signoff-legend' => 'Legg til underskrift',
	'code-signoff-submit' => 'Skriv under',
	'code-signoff-strike' => 'Stryk valgte signeringer',
	'code-signoff-signoff' => 'Signer på denne revisjonen som:',
	'code-signoff-flag-inspected' => 'Inspisert',
	'code-signoff-flag-tested' => 'Testet',
	'code-signoff-field-user' => 'Bruker',
	'code-signoff-field-flag' => 'Flagg',
	'code-signoff-field-date' => 'Dato',
	'code-signoff-struckdate' => '$1 (strøket $2)',
	'code-pathsearch-legend' => 'Søk revisjoner i denne repo etter sti',
	'code-pathsearch-path' => 'Sti:',
	'code-pathsearch-filter' => 'Vis bare:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Forfatter = $1',
	'code-revfilter-ct_tag' => 'Tagg = $1',
	'code-revfilter-clear' => 'Fjern filter',
	'code-rev-submit' => 'Lagre endringer',
	'code-rev-submit-next' => 'Lagre og neste uløste',
	'code-rev-next' => 'Neste uløste',
	'code-batch-status' => 'Endre status:',
	'code-batch-tags' => 'Endre merker:',
	'codereview-batch-title' => 'Endre alle valgte versjoner',
	'codereview-batch-submit' => 'Send',
	'code-releasenotes' => 'Versjonsnotater',
	'code-release-legend' => 'Lag versjonsnotater',
	'code-release-startrev' => 'Start revisjon:',
	'code-release-endrev' => 'Siste revisjon:',
	'codereview-subtitle' => 'For $1',
	'codereview-reply-link' => 'svar',
	'codereview-overview-title' => 'Oversikt',
	'codereview-overview-desc' => 'Vis en grafisk oversikt over denne listen',
	'codereview-email-subj' => '[$1 $2]: Ny kommentar lagt inn',
	'codereview-email-body' => 'Brukeren «$1» la inn en kommentar på $3.

Fullstendig URL: $2
Bidragssammendrag:

$5

Kommentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Påfølgende endringer',
	'codereview-email-body2' => 'Brukeren «$1» gjorde oppfølgende endringer til $2.

Full nettadresse til oppfølgende revisjon: $5
Bidragssammendrag:

$6

Full nettadresse: $3
Bidragssammendrag:

$4',
	'codereview-email-subj3' => '[$1 $2]: Revisjonsstatus endret',
	'codereview-email-body3' => 'Brukeren «$1» endret statusen til $2.

Gammel status: $3
Ny status: $4

Full URL: $5
Bidragssammendrag:

$6',
	'codereview-email-subj4' => '[$1 $2]: Ny kommentar lagt til og revisjonsstatus endret',
	'codereview-email-body4' => 'Brukeren «$1» endret statusen til $2.

Gammel status: $3
Ny status: $4

Brukeren «$1» la også inn en kommentar på $2.

Full URL: $5
Bidragssammendrag:

$7

Kommentar:

$6

Gammel status: $3
Ny status: $4

Bruker «$1» postet også en kommentar på $2

Fullstendig URL-adresse: $5

Kommentar:

$6',
	'code-stats' => 'statistikk',
	'code-stats-header' => 'Statistikk for repositoriet $1',
	'code-stats-main' => 'Som på $1 har depoet $2 {{PLURAL:$2|revisjon|revisjoner}} av [[Special:Code/$3/author|$4 {{PLURAL:$4|forfatter|forfattere}}]]',
	'code-stats-status-breakdown' => 'Antall revisjoner per status',
	'code-stats-fixme-breakdown' => 'Inndeling av fiksmeg-revisjoner per forfatter',
	'code-stats-new-breakdown' => 'Inndeling av nye revisjoner per forfatter',
	'code-stats-count' => 'Antall revisjoner',
	'code-tooltip-withsummary' => 'r$1 [$2] av $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] av $3',
	'repoadmin' => 'Databaseadministrasjon',
	'repoadmin-new-legend' => 'Lag en ny database',
	'repoadmin-new-label' => 'Databasenavn',
	'repoadmin-new-button' => 'Opprett',
	'repoadmin-edit-legend' => 'Endring av database "$1"',
	'repoadmin-edit-path' => 'Database-sti:',
	'repoadmin-edit-bug' => 'Bugzilla-URL:',
	'repoadmin-edit-view' => 'ViewVC URL',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Database [[Special:Code/$1|$1]] har blitt endret.',
	'repoadmin-nav' => 'repositorieadministrasjon',
	'right-repoadmin' => 'Håndtere kodedatabaser',
	'right-codereview-use' => 'Bruk av Special:Code',
	'right-codereview-add-tag' => 'Legg til nye tagger til versjoner',
	'right-codereview-remove-tag' => 'Fjern tagger fra versjon',
	'right-codereview-post-comment' => 'Legge til kommentarer til revisjoner',
	'right-codereview-set-status' => 'Endre versjonens status',
	'right-codereview-signoff' => 'Skriv under på revisjoner',
	'right-codereview-link-user' => 'Lenke forfattere til wikibrukere',
	'right-codereview-associate' => 'Behandle revisjonsmerker',
	'right-codereview-review-own' => 'Merk dine egne endringer som OK eller Løst',
	'specialpages-group-developer' => 'Utviklerverktøy',
	'group-svnadmins' => 'SVN administratorer',
	'group-svnadmins-member' => 'SVN administrator',
	'grouppage-svnadmins' => '{{ns:project}}:SVN administratorer',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'code' => 'Koodkuntrull',
	'code-rev-title' => '$1 - Kood-Kuntrull',
	'code-comments' => 'Kommentarn',
	'code-references' => 'Nakamen Versionen',
	'code-change-status' => "hett den '''Status''' för $1 ännert",
	'code-change-tags' => "hett de '''Tags''' för $1 ännert",
	'code-change-removed' => 'rutnahmen:',
	'code-change-added' => 'toföögt:',
	'code-prop-changes' => 'Status- un Tag-Logbook',
	'codereview-desc' => '[[Special:Code|Koodkuntrull-Warktüüch]], dat [[Special:RepoAdmin|Subversion]] ünnerstütt',
	'code-no-repo' => 'Keen Repositorium instellt.',
	'code-load-diff' => 'An’t Diff laden …',
	'code-notes' => 'Ne’este Notizen',
	'code-authors' => 'Autorn',
	'code-status' => 'Status',
	'code-tags' => 'Tags',
	'code-authors-text' => 'Dit is de List vun de Autorn na de Reeg vun de Commits.',
	'code-author-haslink' => 'Disse Autor is mit’n Wiki-Bruker $1 verbunnen',
	'code-author-orphan' => 'Disse Autor is mit keen Wiki-Brukerkonto verbunnen',
	'code-author-dolink' => 'Dissen Autor mit en Wiki-Brukerkonto verbinnen:',
	'code-author-alterlink' => 'Dissen Autor mit en nee Wiki-Brukerkonto verbinnen:',
	'code-author-orunlink' => 'Oder den Autor vun dit Wiki-Brukerkonto trennen:',
	'code-author-name' => 'Brukernaam ingeven:',
	'code-author-success' => 'De Autor $1 is mit’n Wikibruker $2 verbunnen worrn',
	'code-author-link' => 'verbinnen?',
	'code-author-unlink' => 'trennen?',
	'code-author-unlinksuccess' => 'De Autor $1 is trennt worrn',
	'code-field-id' => 'Version',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Kommentator',
	'code-field-message' => 'Commit-Kommentar',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Notizen',
	'code-field-path' => 'Padd',
	'code-field-text' => 'Notiz',
	'code-field-select' => 'Utwählen',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Repositorium:',
	'code-rev-rev' => 'Version:',
	'code-rev-rev-viewvc' => 'in ViewVC',
	'code-rev-paths' => 'Ännert Padden:',
	'code-rev-modified-a' => 'toföögt',
	'code-rev-modified-r' => 'utwesselt',
	'code-rev-modified-d' => 'löscht',
	'code-rev-modified-m' => 'ännert',
	'code-rev-imagediff' => 'Bild-Ännern',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status ännern',
	'code-rev-tags' => 'Tags:',
	'code-rev-tag-add' => 'Tags tofögen:',
	'code-rev-tag-remove' => 'Tags rutnehmen:',
	'code-rev-comment-by' => 'Kommentar vun $1',
	'code-rev-comment-preview' => 'Vörschau',
	'code-rev-diff' => 'Verscheel',
	'code-rev-diff-link' => 'Verscheel',
	'code-rev-purge-link' => 'opfrischen',
	'code-status-new' => 'nee',
	'code-status-fixme' => 'fixme',
	'code-status-reverted' => 'trüchdreit',
	'code-status-resolved' => 'lööst',
	'code-status-ok' => 'OK',
	'code-status-deferred' => 'trüchstellt',
	'code-pathsearch-legend' => 'In dit Repositorium na Versionen söken, na Padd',
	'code-pathsearch-path' => 'Padd:',
	'code-rev-submit' => 'Ännern spiekern',
	'code-rev-submit-next' => 'Spiekern un na’n nächsten unprööften',
	'code-batch-status' => 'Status ännern:',
	'code-batch-tags' => 'Tags ännern:',
	'codereview-batch-title' => 'All utwählt Versionen ännern',
	'codereview-batch-submit' => 'Afschicken',
	'code-releasenotes' => 'Release Notes',
	'code-release-legend' => 'Release Notes tügen',
	'code-release-startrev' => 'Start-Version:',
	'code-release-endrev' => 'Enn-Version:',
	'codereview-subtitle' => 'För $1',
	'codereview-reply-link' => 'antern',
	'codereview-email-subj' => '[$1 $2]: Ne’en Kommentar toföögt',
	'codereview-email-body' => 'Bruker „$1“ hett en Kommentarn to $3 maakt.

Vulle URL: $2

Kommentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Nakamen Ännern',
	'codereview-email-body2' => 'Bruker „$1“ hett na $2 noch wedder wat ännert.

Vull URL: $3

Commit-Kommentar:

$4',
	'repoadmin' => 'Repositorium-Administratschoon',
	'repoadmin-new-legend' => 'Nee Repositorium opstellen',
	'repoadmin-new-label' => 'Naam vun dat Repositorium:',
	'repoadmin-new-button' => 'Opstellen',
	'repoadmin-edit-legend' => 'Ännern an Repositorium „$1“',
	'repoadmin-edit-path' => 'Repositoriums-Padd:',
	'repoadmin-edit-bug' => 'Bugzilla-Padd:',
	'repoadmin-edit-view' => 'ViewVC-Padd:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Dat Repositorium „[[Special:Code/$1|$1]]“ is ännert worrn.',
	'right-repoadmin' => 'Kood-Repositorien verwalten',
	'right-codereview-use' => 'Special:Code bruken',
	'right-codereview-add-tag' => 'Ne’e Tags an Versionen tofögen',
	'right-codereview-remove-tag' => 'Tags bi Versionen rutnehmen',
	'right-codereview-post-comment' => 'Kommentaren to Versionen tofögen',
	'right-codereview-set-status' => 'Versionsstatus ännern',
	'right-codereview-link-user' => 'Autoren mit Wiki-Brukers verbinnen',
	'specialpages-group-developer' => 'Developer-Warktüüch',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'code-rev-author' => 'Auteur:',
	'code-rev-date' => 'Daotum:',
	'code-rev-message' => 'Opmarking:',
	'code-rev-repo' => 'Repositorium:',
	'code-rev-rev' => 'Versie:',
	'code-rev-rev-viewvc' => 'in ViewVC',
);

/** Nepali (नेपाली)
 * @author Bhawani Gautam
 * @author Bhawani Gautam Rhk
 * @author RajeshPandey
 */
$messages['ne'] = array(
	'code-comments' => 'टिप्पणीहरु',
	'code-authors' => 'लेखकहरु',
	'code-author-link' => 'लिङ्क गर्ने?',
	'code-author-unlink' => 'लिङ्क तोड़ने',
	'code-field-status' => 'स्थिति',
	'code-field-path' => 'पथ',
	'code-field-text' => 'सूचना',
	'code-field-select' => 'चुन्ने',
	'code-rev-message' => 'टिप्पणी :',
	'code-status-new' => 'नयाँ',
	'code-status-ok' => 'हुन्छ',
	'code-signoff-field-user' => 'प्रयोगकर्ता',
);

/** Dutch (Nederlands)
 * @author Krinkle
 * @author Mihxil
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'code' => 'Codecontrole',
	'code-rev-title' => '$1 - Programmacodecontrole',
	'code-comments' => 'Opmerkingen',
	'code-references' => 'Versies met correcties',
	'code-referenced' => 'Corrigerende versies',
	'code-change-status' => "heeft de '''status''' voor versie $1 gewijzigd",
	'code-change-tags' => "heeft de '''labels''' voor versie $1 gewijzigd",
	'code-change-removed' => 'verwijderd:',
	'code-change-added' => 'toegevoegd:',
	'code-old-status' => 'Oude status',
	'code-new-status' => 'Nieuwe status',
	'code-prop-changes' => 'Logboek status en labels',
	'codereview-desc' => '[[Special:Code|Hulpprogramma voor codecontrole]] met [[Special:RepoAdmin|ondersteuning voor Subversion]]',
	'code-no-repo' => 'Er is geen repository ingesteld!',
	'code-create-repo' => 'Ga naar [[Special:RepoAdmin|RepoAdmin]] om een repository aan te maken.',
	'code-need-repoadmin-rights' => 'U hebt het recht "repoadmin" nodig om een repository aan te kunnen maken.',
	'code-need-group-with-rights' => 'Er bestaat geen groep met het recht "repoadmin". Voeg er een toe om een nieuwe repository aan te kunnen maken.',
	'code-repo-not-found' => "De repository '''$1''' bestaat niet!",
	'code-load-diff' => 'Bezig met het laden van de veranderingen…',
	'code-notes' => 'recente opmerkingen',
	'code-statuschanges' => 'statuswijzigingen',
	'code-mycommits' => 'mijn commits',
	'code-mycomments' => 'mijn opmerkingen',
	'code-authors' => 'auteurs',
	'code-status' => 'statussen',
	'code-tags' => 'labels',
	'code-tags-no-tags' => 'Er worden geen labels gebruikt in deze repository.',
	'code-authors-text' => 'Hieronder staat een lijst met auteurs uit de repository, gesorteerd op commitnaam.
Lokale wikigebruikers worden binnen haakjes weergegeven.
De gegevens kunnen uit een cache komen.',
	'code-author-haslink' => 'Deze auteur is gekoppeld aan de wikigebruiker $1',
	'code-author-orphan' => 'De SVN-gebruiker/auteur $1 is niet gekoppeld aan een wikigebruiker',
	'code-author-dolink' => 'Deze auteur met een wikigebruiker koppelen:',
	'code-author-alterlink' => 'De aan deze auteur gekoppelde wikigebruiker wijzigen:',
	'code-author-orunlink' => 'Of deze wikigebruiker ontkoppelen:',
	'code-author-name' => 'Geef een gebruikersnaam in:',
	'code-author-success' => 'De auteur $1 is gekoppeld aan de wikigebruiker $2',
	'code-author-link' => 'koppelen?',
	'code-author-unlink' => 'ontkoppelen?',
	'code-author-unlinksuccess' => 'De auteur $1 is ontkoppeld.',
	'code-author-badtoken' => 'Sessiefout tijdens het uitvoeren van de handeling.',
	'code-author-total' => 'Totaal aantal auteurs: $1',
	'code-author-lastcommit' => 'Laatste commitdatum',
	'code-browsing-path' => "Versies in '''$1''' aan het bekijken",
	'code-field-id' => 'Versie',
	'code-field-author' => 'Auteur',
	'code-field-user' => 'Opmerking van',
	'code-field-message' => 'Toelichting bij commit',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Statusbeschrijving',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Opmerkingen',
	'code-field-path' => 'Pad',
	'code-field-text' => 'Opmerking',
	'code-field-select' => 'Selecteren',
	'code-reference-remove' => 'Geselecteerde koppelingen verwijderen',
	'code-reference-associate' => 'Follow-upversie koppelen:',
	'code-reference-associate-submit' => 'Koppelen',
	'code-rev-author' => 'Auteur:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Opmerking:',
	'code-rev-repo' => 'Repository:',
	'code-rev-rev' => 'Versie:',
	'code-rev-rev-viewvc' => 'in ViewVC',
	'code-rev-paths' => 'Gewijzigde bestanden:',
	'code-rev-modified-a' => 'toegevoegd',
	'code-rev-modified-r' => 'vervangen',
	'code-rev-modified-d' => 'verwijderd',
	'code-rev-modified-m' => 'gewijzigd',
	'code-rev-imagediff' => 'Wijzigingen in afbeelding',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Status wijzigen',
	'code-rev-tags' => 'Labels:',
	'code-rev-tag-add' => 'Labels toevoegen:',
	'code-rev-tag-remove' => 'Labels verwijderen:',
	'code-rev-comment-by' => 'Opmerking van $1',
	'code-rev-comment-preview' => 'Voorvertoning',
	'code-rev-inline-preview' => 'Voorvertoning:',
	'code-rev-diff' => 'Veranderingen',
	'code-rev-diff-link' => 'veranderingen',
	'code-rev-diff-too-large' => 'De verschillen zijn te groot om weer te geven.',
	'code-rev-purge-link' => 'verversen',
	'code-rev-total' => 'Totaal aantal resultaten: $1',
	'code-rev-not-found' => "Versie '''$1''' bestaat niet.",
	'code-rev-history-link' => 'geschiedenis',
	'code-status-new' => 'nieuw',
	'code-status-desc-new' => 'De versie wacht op een actie (standaardstatus).',
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => 'Deze versie introduceerde een bug of is stuk. Dat moet gecorrigeerd worden.',
	'code-status-reverted' => 'teruggedraaid',
	'code-status-desc-reverted' => 'De versie is ongedaan gemaakt door een latere versie.',
	'code-status-resolved' => 'opgelost',
	'code-status-desc-resolved' => 'Er was een probleem met de versie dat opgelost is in een latere versie.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Review van de versie is afgerond en de reviewer is ervan overtuigd dat alles in orde is.',
	'code-status-deferred' => 'uitgesteld',
	'code-status-desc-deferred' => 'De versie heeft geen review nodig.',
	'code-status-old' => 'oud',
	'code-status-desc-old' => 'Oude versie die mogelijk bugs bevat maar het niet waard is om nog review te krijgen.',
	'code-signoffs' => 'Goedkeuringen',
	'code-signoff-legend' => 'Goedkeuring toevoegen',
	'code-signoff-submit' => 'Goedkeuren',
	'code-signoff-strike' => 'Geselecteerde akkoorden doorhalen',
	'code-signoff-signoff' => 'Deze versie accorderen als:',
	'code-signoff-flag-inspected' => 'Onderzocht',
	'code-signoff-flag-tested' => 'Getest',
	'code-signoff-field-user' => 'Gebruiker',
	'code-signoff-field-flag' => 'Markering',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (heeft $2 doorgehaald)',
	'code-pathsearch-legend' => 'Op pad versies in deze repository zoeken',
	'code-pathsearch-path' => 'Pad:',
	'code-pathsearch-filter' => 'Alleen weergeven:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Auteur = $1',
	'code-revfilter-ct_tag' => 'Label = $1',
	'code-revfilter-clear' => 'Filter verwijderen',
	'code-rev-submit' => 'Wijzigingen opslaan',
	'code-rev-submit-next' => 'Opslaan en volgende ongecontroleerde',
	'code-rev-next' => 'Volgende ongecontroleerde',
	'code-batch-status' => 'Status wijzigen:',
	'code-batch-tags' => 'Labels wijzigen:',
	'codereview-batch-title' => 'Alle geselecteerde versies wijzigen',
	'codereview-batch-submit' => 'Opslaan',
	'code-releasenotes' => 'release notes',
	'code-release-legend' => 'Release notes aanmaken',
	'code-release-startrev' => 'Beginversie:',
	'code-release-endrev' => 'Eindversie:',
	'codereview-subtitle' => 'Voor $1',
	'codereview-reply-link' => 'antwoorden',
	'codereview-overview-title' => 'Overzicht',
	'codereview-overview-desc' => 'Een grafisch overzicht van deze lijst weergeven',
	'codereview-email-subj' => '[$1 $2]: nieuwe opmerking toegevoegd',
	'codereview-email-body' => ' "$1" heeft een opmerking toegevoegd aan $3:

URL: $2

Commitsamenvatting voor $3:

$5

Opmerking van $1:

$4',
	'codereview-email-subj2' => '[$1 $2]: wijzigingen met correcties',
	'codereview-email-body2' => '"$1" heeft wijzigingen met correcties voor $2 gemaakt.
URL: $5

Commitsamenvatting voor originele versie $2:

$6

URL voor gecorrigeerde versie: $3
Commitsamenvatting gecorrigeerde versie door "$1":

$4',
	'codereview-email-subj3' => '[$1 $2]: versiestatus gewijzigd',
	'codereview-email-body3' => '"$1" heeft de status van versie $2 gewijzigd naar "$4".
URL: $5

Oude status: $3
Nieuwe status: $4

Commitsamenvatting voor $2:

$6',
	'codereview-email-subj4' => '[$1 $2]: nieuwe opmerking toegevoegd en versiestatus gewijzigd',
	'codereview-email-body4' => '"$1" heeft de status van $2 gewijzigd naar "$4" en een opmerking toevoegd.
URL $5

Oude status: $3
Nieuwe status: $4

Commitsamenvatting voor $2:

$7

Opmerking van $1:

$6',
	'code-stats' => 'statistieken',
	'code-stats-header' => 'Repositorystatistieken voor $1',
	'code-stats-main' => 'Per $1 heeft de repository $2 {{PLURAL:$2|versie|versies}} door [[Special:Code/$3/author|$4 {{PLURAL:$4|auteur|auteurs}}]].',
	'code-stats-status-breakdown' => 'Aantal versies per status',
	'code-stats-fixme-breakdown' => 'Verdeling van de versies gemarkeerd als fixme per auteur',
	'code-stats-fixme-breakdown-path' => 'Verdeling van de versies gemarkeerd als fixme per pad',
	'code-stats-fixme-path' => 'Versies gemarkeerd als fixme voor pad: $1',
	'code-stats-new-breakdown' => 'Verdeling van nieuwe versies per auteur',
	'code-stats-new-breakdown-path' => 'Verdeling van nieuwe versies per pad',
	'code-stats-new-path' => 'Nieuwe versies voor pad: $1',
	'code-stats-count' => 'Aantal versies',
	'code-tooltip-withsummary' => 'r$1 [$2] door $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] door $3',
	'repoadmin' => 'Repositorybeheer',
	'repoadmin-new-legend' => 'Nieuwe repository instellen',
	'repoadmin-new-label' => 'Repositorynaam:',
	'repoadmin-new-button' => 'Aanmaken',
	'repoadmin-edit-legend' => 'Wijziging aan repository "$1"',
	'repoadmin-edit-path' => 'Repositorypad:',
	'repoadmin-edit-bug' => 'Bugzilla-pad:',
	'repoadmin-edit-view' => 'ViewVC-pad:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'De repository "[[Special:Code/$1|$1]]" is aangepast.',
	'repoadmin-nav' => 'repositorybeheer',
	'right-repoadmin' => 'Coderepositories beheren',
	'right-codereview-use' => '[[Special:Code|Hulpprogramma voor codecontrole]] gebruiken',
	'right-codereview-add-tag' => 'Labels toevoegen aan versies',
	'right-codereview-remove-tag' => 'Labels verwijderen van versies',
	'right-codereview-post-comment' => 'Opmerkingen toevoegen aan versies',
	'right-codereview-set-status' => 'Versiestatus wijzigen',
	'right-codereview-signoff' => 'Versies goedkeuren',
	'right-codereview-link-user' => 'Auteurs aan wikigebruikers koppelen',
	'right-codereview-associate' => 'Koppeling toevoegen/verwijderen',
	'right-codereview-review-own' => 'Eigen commits als OK of opgelost markeren',
	'specialpages-group-developer' => 'Hulpmiddelen voor ontwikkelaars',
	'group-svnadmins' => 'SVN-beheerders',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-beheerder}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-beheerders',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Gunnernett
 * @author Harald Khan
 * @author Nghtwlkr
 * @author Njardarlogar
 */
$messages['nn'] = array(
	'code' => 'Kodesaumfaring',
	'code-rev-title' => '$1 - kodesaumfaring',
	'code-comments' => 'Kommentarar',
	'code-references' => 'Oppfylgjande endringar',
	'code-change-status' => "endra '''stoda''' for versjon $1",
	'code-change-tags' => "endra '''merka''' for versjon $1",
	'code-change-removed' => 'tok vekk:',
	'code-change-added' => 'la til:',
	'code-old-status' => 'Gamal status',
	'code-new-status' => 'Ny status',
	'code-prop-changes' => 'Stode- og merkelogg',
	'codereview-desc' => '[[Special:Code|Verktøy for kodesaumfaring]] med [[Special:RepoAdmin|støtta for Subversion]]',
	'code-no-repo' => 'Ingen database konfigurert!',
	'code-load-diff' => 'Lastar skilnad …',
	'code-notes' => 'nye kommentarar',
	'code-statuschanges' => 'Statusendringar',
	'code-authors' => 'forfattarar',
	'code-status' => 'stoda',
	'code-tags' => 'merke',
	'code-authors-text' => 'Nedanfor er ei lista over forfattarar sorterte etter siste bidrag.',
	'code-author-haslink' => 'Denne forfattaren er lenkja til wikibrukar $1',
	'code-author-orphan' => 'Denne forfattaren har inga lenkja til ein wikikonto',
	'code-author-dolink' => 'Lenk denne forfattaren til ein wikibrukar:',
	'code-author-alterlink' => 'Endra wikibrukaren som er lenkja til denne forfattaren:',
	'code-author-orunlink' => 'Eller avlenk denne wikibrukaren:',
	'code-author-name' => 'Skriv inn eit brukarnamn:',
	'code-author-success' => 'Forfattaren $1 har blitt lenkja til wikibrukaren $2',
	'code-author-link' => 'lenkja?',
	'code-author-unlink' => 'avlenk?',
	'code-author-unlinksuccess' => 'Forfattaren $1 har blitt avlenkja',
	'code-field-id' => 'Versjon',
	'code-field-author' => 'Forfattar',
	'code-field-user' => 'Kommenterte',
	'code-field-message' => 'Bidragssamandrag',
	'code-field-status' => 'Stoda',
	'code-field-timestamp' => 'Dato',
	'code-field-comments' => 'Merknader',
	'code-field-path' => 'Stig',
	'code-field-text' => 'Merknad',
	'code-field-select' => 'Vel',
	'code-rev-author' => 'Forfattar:',
	'code-rev-date' => 'Dato:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Database:',
	'code-rev-rev' => 'Versjon:',
	'code-rev-rev-viewvc' => 'på ViewVC',
	'code-rev-paths' => 'Endra stigar:',
	'code-rev-modified-a' => 'lagt til',
	'code-rev-modified-r' => 'erstatta',
	'code-rev-modified-d' => 'sletta',
	'code-rev-modified-m' => 'endra',
	'code-rev-imagediff' => 'Biletendringar',
	'code-rev-status' => 'Stoda:',
	'code-rev-status-set' => 'Endra stoda',
	'code-rev-tags' => 'Merke:',
	'code-rev-tag-add' => 'Legg til merke:',
	'code-rev-tag-remove' => 'Fjern merke:',
	'code-rev-comment-by' => 'Kommentar av $1',
	'code-rev-comment-preview' => 'Førehandsvising',
	'code-rev-diff' => 'Skilnad',
	'code-rev-diff-link' => 'skilnad',
	'code-rev-purge-link' => 'oppfrisk',
	'code-rev-total' => 'Samla tal på resultat: $1',
	'code-status-new' => 'ny',
	'code-status-fixme' => 'fiksmeg',
	'code-status-reverted' => 'attenderulla',
	'code-status-resolved' => 'løyst',
	'code-status-ok' => 'OK',
	'code-status-deferred' => 'forskjøve',
	'code-status-old' => 'gamal',
	'code-signoff-field-user' => 'Brukar',
	'code-signoff-field-date' => 'Dato',
	'code-pathsearch-legend' => 'Søk i versjonar i databsen etter stig',
	'code-pathsearch-path' => 'Stig:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Forfattar = $1',
	'code-rev-submit' => 'Lagra endringar',
	'code-rev-submit-next' => 'Lagra og gå til neste uløyste',
	'code-batch-status' => 'Endra stoda:',
	'code-batch-tags' => 'Endra merke:',
	'codereview-batch-title' => 'Endra alle valde versjonar',
	'codereview-batch-submit' => 'Sett i verk',
	'code-releasenotes' => 'Versjonsnotat',
	'code-release-legend' => 'Lag versjonsnotater',
	'code-release-startrev' => 'Start revisjon:',
	'code-release-endrev' => 'Siste revisjon:',
	'codereview-subtitle' => 'For $1',
	'codereview-reply-link' => 'svar',
	'codereview-email-subj' => '[$1 $2]: Ny kommentar lagt til',
	'codereview-email-body' => 'Brukar $1 la inn ein kommentar på $3

Fullstendig adressa: $2

Kommentar:

$4',
	'codereview-email-subj2' => '[$1 $2]: Påfylgjande endringar',
	'codereview-email-body2' => 'Brukar "$1" gjorde påfylgjande endringar til $2.

Full URL: $3

Oppsummering:

$4',
	'code-stats' => 'statistikk',
	'repoadmin' => 'Databaseadministrasjon',
	'repoadmin-new-legend' => 'Opprett ein ny database',
	'repoadmin-new-label' => 'Databasenamn:',
	'repoadmin-new-button' => 'Opprett',
	'repoadmin-edit-legend' => 'Endring av databasen «$1»',
	'repoadmin-edit-path' => 'Databasestig:',
	'repoadmin-edit-bug' => 'Bugzilla-stig:',
	'repoadmin-edit-view' => 'ViewVC-stig:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Databasen [[Special:Code/$1|$1]] har blitt endra.',
	'right-repoadmin' => 'Handsama kodesamlingar',
	'right-codereview-use' => 'Bruka Special:Code',
	'right-codereview-add-tag' => 'Leggja til nye merke til versjonar',
	'right-codereview-remove-tag' => 'Fjerna merke frå versjonar',
	'right-codereview-post-comment' => 'Leggja til kommentarar til versjonar',
	'right-codereview-set-status' => 'Endra versjonsstoda',
	'right-codereview-link-user' => 'Lenkja forfattarar til wikibrukarar',
	'specialpages-group-developer' => 'Utviklarverkty',
);

/** Occitan (Occitan)
 * @author Cedric31
 * @author McDutchie
 */
$messages['oc'] = array(
	'code' => 'Verificacion del còde',
	'code-rev-title' => '$1 - Revision del còde',
	'code-comments' => 'Nòtas de relectura',
	'code-references' => 'Referéncias cap a las revisions',
	'code-change-status' => "a modificat l''''estat''' de $1",
	'code-change-tags' => "a modificat las '''balisas''' de $1",
	'code-change-removed' => 'levat :',
	'code-change-added' => 'apondut :',
	'code-old-status' => 'Estatut ancian',
	'code-new-status' => 'Estatut novèl',
	'code-prop-changes' => 'Estatut e jornal de balisatge',
	'codereview-desc' => '[[Special:Code|Aisinas per tornar veire lo còde]] amb [[Special:RepoAdmin|supòrt de Subversion]]',
	'code-no-repo' => 'Pas de depaus configurat !',
	'code-load-diff' => 'Cargament del dif…',
	'code-notes' => 'comentaris recents',
	'code-statuschanges' => "modificacions d'estatut",
	'code-authors' => 'autors',
	'code-status' => 'estats',
	'code-tags' => 'balisas',
	'code-authors-text' => 'Çaijós se tròba una lista dels autors de depauses per òrdre de publicacions recentas. Los comptes del wiki local son afichats entre parentèsis.',
	'code-author-haslink' => "Aqueste autor es ligat al compte $1 d'aqueste wiki",
	'code-author-orphan' => 'Aqueste autor a pas de ligam amb un compte wiki',
	'code-author-dolink' => 'Associar aqueste autor a un compte wiki local :',
	'code-author-alterlink' => 'Modificar l’utilizaire wiki ligat a aqueste autor :',
	'code-author-orunlink' => "Levar lo ligam d'aqueste utilizaire wiki :",
	'code-author-name' => "Picatz un nom d'utilizaire :",
	'code-author-success' => 'L’autor $1 es estat ligat a l’utilizaire wiki $2',
	'code-author-link' => 'ligar ?',
	'code-author-unlink' => 'desligar ?',
	'code-author-unlinksuccess' => 'L’autor $1 es estat desligat',
	'code-browsing-path' => "Percors de las revisions dins '''$1'''",
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentator',
	'code-field-message' => 'Somari de publicacion',
	'code-field-status' => 'Estatut',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Nòtas',
	'code-field-path' => 'Camin',
	'code-field-text' => 'Nòta',
	'code-field-select' => 'Seleccionar',
	'code-rev-author' => 'Autor :',
	'code-rev-date' => 'Data :',
	'code-rev-message' => 'Comentari :',
	'code-rev-repo' => 'Depaus :',
	'code-rev-rev' => 'Revision :',
	'code-rev-rev-viewvc' => 'sus ViewVC',
	'code-rev-paths' => 'Fichièrs/dorsièrs modificats :',
	'code-rev-modified-a' => 'apondut',
	'code-rev-modified-r' => 'remplaçat',
	'code-rev-modified-d' => 'suprimit',
	'code-rev-modified-m' => 'modificat',
	'code-rev-imagediff' => "Modificacions d'imatges",
	'code-rev-status' => 'Estatut :',
	'code-rev-status-set' => "Cambiar l'estatut",
	'code-rev-tags' => 'Atributs :',
	'code-rev-tag-add' => 'Apondre las balisas :',
	'code-rev-tag-remove' => 'Levar las balisas :',
	'code-rev-comment-by' => 'Comentari per $1',
	'code-rev-comment-preview' => 'Previsualizacion',
	'code-rev-inline-preview' => 'Previsualizacion :',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'Lo diff es tròp larg per èsser afichat.',
	'code-rev-purge-link' => 'purgar',
	'code-status-new' => 'novèl',
	'code-status-fixme' => 'de reparar',
	'code-status-reverted' => 'revocat',
	'code-status-resolved' => 'resolgut',
	'code-status-ok' => "d'acòrdi",
	'code-status-deferred' => 'deferit',
	'code-pathsearch-legend' => 'Recèrca las versions dins aqueste depaus segon lo camin',
	'code-pathsearch-path' => 'Camin :',
	'code-rev-submit' => 'Salvar las modificacions',
	'code-rev-submit-next' => 'Salvar & venenta pas resolguda',
	'code-batch-status' => "Modificar l'estatut :",
	'code-batch-tags' => 'Modificar las balisas :',
	'codereview-batch-title' => 'Modificar totas las revisions seleccionadas',
	'codereview-batch-submit' => 'Mandar',
	'code-releasenotes' => 'Nòtas de version',
	'code-release-legend' => 'Generir las nòtas de version',
	'code-release-startrev' => 'Revision de començament :',
	'code-release-endrev' => 'Revision de fin :',
	'codereview-subtitle' => 'Per $1',
	'codereview-reply-link' => 'respondre',
	'codereview-email-subj' => '[$1 $2] : Comentari novèl apondut',
	'codereview-email-body' => "L'utilizaire « $1 » a mandat un comentari sus $3.

Adreça completa : $2

Comentari :

$4",
	'codereview-email-subj2' => '[$1 $2] : Modificacion seguida',
	'codereview-email-body2' => 'L’utilizaire « $1 » a fach de modificacions religadas e $2.

URL completa : $3

Resumit de las modificacions :

$4',
	'codereview-email-subj3' => '[$1 $2] : lo tèst automatic a detectat una regression',
	'codereview-email-body3' => 'Lo tèst automatic a revelat una regression a causa dels cambiaments intervenguts dins la version $1.

URL completa : $2

Resumit al moment de la somission :

$3',
	'repoadmin' => 'Administracion dels depauses',
	'repoadmin-new-legend' => 'Crear un depaus novèl',
	'repoadmin-new-label' => 'Nom del depaus :',
	'repoadmin-new-button' => 'Crear',
	'repoadmin-edit-legend' => 'Modificacion del depaus "$1"',
	'repoadmin-edit-path' => 'Camin del depaus :',
	'repoadmin-edit-bug' => 'Camin de Bugzilla :',
	'repoadmin-edit-view' => 'Camin de ViewVC :',
	'repoadmin-edit-button' => "D'acòrdi",
	'repoadmin-edit-sucess' => 'Lo depaux "[[Special:Code/$1|$1]]" es estat modificat amb succès.',
	'right-repoadmin' => 'Administrar los depauses de còde',
	'right-codereview-use' => 'Utilizar Special:Code',
	'right-codereview-add-tag' => "Apondre d'atributs novèls a las revisions",
	'right-codereview-remove-tag' => "Levar d'atributs a las revisions",
	'right-codereview-post-comment' => 'Apondre un comentari a las revisions',
	'right-codereview-set-status' => "Cambiar l'estatut de las revisions",
	'right-codereview-link-user' => 'Liga los autors als utilizaires wiki',
	'specialpages-group-developer' => 'Aisinas del desvolopaire',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Ansumang
 * @author Jnanaranjan Sahu
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'code' => 'କୋଡ଼ ରିଭିଉ',
	'code-rev-title' => '$1 - କୋଡ଼ ରିଭିଉ',
	'code-comments' => 'ମତାମତ',
	'code-references' => 'ସଂସ୍କରଣଗୁଡ଼ିକର ବାବଦରେ ପଛରେ ପଚରା-ଉଚରା କରନ୍ତୁ',
	'code-change-status' => "$1ର '''ସ୍ଥିତି''' ବଦଳାଇ ଦିଆଗଲା",
	'code-change-tags' => "$1ର '''ଚିହ୍ନ''' ବଦଳାଇ ଦିଆଗଲା",
	'code-change-removed' => 'କାଢ଼ିଦିଆଗଲା:',
	'code-change-added' => 'ଯୋଡ଼ାଗଲା:',
	'code-old-status' => 'ପୁରୁଣା ସ୍ଥିତି',
	'code-new-status' => 'ନୂଆ ସ୍ଥିତି',
	'code-prop-changes' => 'ସ୍ଥିତି ଓ ଚିହ୍ନଦେବା ଇତିହାସ',
	'codereview-desc' => '[[Special:RepoAdmin|ସବଭର୍ସନ ସହଯୋଗ]] ସହିତ [[Special:Code|କୋଡ଼ ରିଭିଉ ଟୁଲ]]',
	'code-no-repo' => 'ଗୋଟିଏ ବି ଭଣ୍ଡାର ସଜାଗଲା ନାହିଁ!',
	'code-create-repo' => '[[Special:RepoAdmin|RepoAdmin]]କୁ ଯାଇ ଏକ ଭଣ୍ଡାର ଗଢ଼ନ୍ତୁ',
	'code-repo-not-found' => "'''$1''' ଭଣ୍ଡାରଟି ସ୍ଥିତିହୀନ!",
	'code-load-diff' => 'ତୁଳନା ଲୋଡ଼କରୁଛୁ...',
	'code-notes' => 'ଏବେକାର ମନ୍ତବ୍ୟ ଗୁଡିକ',
	'code-statuschanges' => 'ସ୍ଥିତି ବଦଳମାନ',
	'code-mycommits' => 'ମୋ ନିବେଶ',
	'code-mycomments' => 'ମୋ ଅଭିମତ',
	'code-authors' => 'ଲେଖକ',
	'code-status' => 'ସ୍ଥିତି',
	'code-tags' => 'ସୂଚକମାନ',
	'code-tags-no-tags' => 'ଏହି ଭଣ୍ଡାରରେ ଗୋଟିଏ ବି ସୂଚକ ନାହିଁ ।',
	'code-author-haslink' => 'ଏହି ଲେଖକ $1 ଉଇକି ବ୍ୟବହାରକାରୀ ସହ ଯୋଡ଼ିହୋଇରହିଛନ୍ତି ।',
	'code-author-orphan' => 'SVN ବ୍ୟବହରକାରୀ/$1 ଲେଖକ ଏକ ଉଇକି ଖାତା ସହ ସମ୍ବନ୍ଧିତ ନୁହଁନ୍ତି',
	'code-author-dolink' => 'ଏହି ବ୍ୟବହାରକାରୀଙ୍କୁ ଜଣେ ଉଇକି ବ୍ୟବହାରକାରୀଙ୍କ ସହ ଯୋଡ଼ନ୍ତୁ:',
	'code-author-alterlink' => 'ଏହି ଲେଖକଙ୍କ ସହ ଯୋଡ଼ା ଉଇକି ବ୍ୟବହାରକାରୀଙ୍କୁ ବଦଳାନ୍ତୁ:',
	'code-author-orunlink' => 'କିମ୍ବା ଏହି ଉଇକି ବ୍ୟବହାରକାରୀଙ୍କୁ ବାହାର କରନ୍ତୁ:',
	'code-author-name' => 'ଇଉଜର ନାମଟିଏ ଦିଅନ୍ତୁ:',
	'code-author-success' => '$1 ଲେଖକଜଣକ ଉଇକି ବ୍ୟବହାରକାରୀ $2ଙ୍କ ସହ ଯୋଡ଼ା',
	'code-author-link' => 'ଲିଙ୍କ?',
	'code-author-unlink' => 'ଅନଲିଙ୍କ?',
	'code-author-unlinksuccess' => 'ଲେଖକ $1ଙ୍କୁ କାଢ଼ିଦିଆଗଲା',
	'code-author-badtoken' => 'ଏହି କାମଟି କରିବାକୁ ଚେଷ୍ଟା କଲାବେଳେ କାମ ମିଆଦରେ ଭୁଲ ।',
	'code-author-total' => 'ମୋଟ ଲେଖକ: $1 ଜଣ',
	'code-author-lastcommit' => 'ଶେଷ ଦିଆହୋଇଥିବା ତାରିଖ',
	'code-browsing-path' => "'''$1'''ରେ ସଂସ୍କରଣ ସବୁ ଖୋଜୁଛି",
	'code-field-id' => 'ପୁନରାବୃତ୍ତି',
	'code-field-author' => 'ଲେଖକ',
	'code-field-user' => 'ମତାମତକାରୀ',
	'code-field-message' => 'ସାରକଥା ଦେବେ',
	'code-field-status' => 'ସ୍ଥିତି',
	'code-field-status-description' => 'ସ୍ଥିତି ବିବରଣୀ',
	'code-field-timestamp' => 'ତାରିଖ',
	'code-field-comments' => 'ମତାମତ',
	'code-field-path' => 'ପଥ',
	'code-field-text' => 'ଟୀକା',
	'code-field-select' => 'ବାଛନ୍ତୁ',
	'code-reference-remove' => 'ବଛାଯାଇଥିବା ସମ୍ବନ୍ଧସବୁ କାଢ଼ିଦେବେ',
	'code-reference-associate' => 'ସଂସ୍କରଣଗୁଡ଼ିକର ବାବଦରେ ପଛରେ ପଚରା-ଉଚରା ସମ୍ବନ୍ଧିତ କରନ୍ତୁ:',
	'code-reference-associate-submit' => 'ସହଯୋଗୀ',
	'code-rev-author' => 'ଲେଖକ:',
	'code-rev-date' => 'ତାରିଖ:',
	'code-rev-message' => 'ମତାମତ:',
	'code-rev-repo' => 'ଭଣ୍ଡାର ଗୃହ:',
	'code-rev-rev' => 'ପୁନରାବୃତ୍ତି:',
	'code-rev-rev-viewvc' => 'ViewVCରେ',
	'code-rev-paths' => 'ବଦଳାଯାଇଥିବା ପଥ:',
	'code-rev-modified-a' => 'ଯୋଡ଼ାଗଲା',
	'code-rev-modified-r' => 'ପ୍ରତିବଦଳ କରାଗଲା',
	'code-rev-modified-d' => 'ଲିଭିଗଲା',
	'code-rev-modified-m' => 'ବଦଳାଯାଇଥିବା',
	'code-rev-imagediff' => 'ଛବିର ବଦଳ',
	'code-rev-status' => 'ସ୍ଥିତି:',
	'code-rev-status-set' => 'ସ୍ଥିତି ବଦଳ',
	'code-rev-tags' => 'ସୂଚକ:',
	'code-rev-tag-add' => 'ସୂଚକ ଯୋଡ଼ିବେ:',
	'code-rev-tag-remove' => 'ସୂଚକ କାଢ଼ିଦେବେ:',
	'code-rev-comment-by' => '$1ଙ୍କ ଦେଇ ଦିଆ ମତ',
	'code-rev-comment-preview' => 'ସାଇତା ଆଗରୁ ଦେଖଣା',
	'code-rev-inline-preview' => 'ସାଇତା ଆଗରୁ ଦେଖଣା:',
	'code-rev-diff' => 'ଅଦଳ ବଦଳ',
	'code-rev-diff-link' => 'ଅଦଳ ବଦଳ',
	'code-rev-diff-too-large' => 'ଏହି ତୁଳନାଟି ଖୁବ ବଡ଼ ହୋଇଥିବାରୁ ଏଠାରେ ଦେଖାଯିବା ସମ୍ଭବ ନୁହେଁ ।',
	'code-rev-purge-link' => 'ପର୍ଜ',
	'code-rev-total' => 'ମୋଟ ଫଳାଫଳ: $1',
	'code-rev-not-found' => "'''$1''' ସଂସ୍କରଣଟି ସ୍ଥିତିହୀନ!",
	'code-rev-history-link' => 'ଇତିହାସ',
	'code-status-new' => 'ନୂଆ',
	'code-status-fixme' => 'ମୋତେ ଠିକ କରିବେ',
	'code-status-reverted' => 'ପଛକୁ ଫେରାଇଲେ',
	'code-status-desc-reverted' => 'ସଂସ୍କରଣଟି ପରେ ଆଉ ଏକ ନୂଆ ସଂସ୍କରଣ ଦେଇ ଲେଉଟାଇଦିଆଗଲା',
	'code-status-resolved' => 'ସମାହିତ ହେଲା',
	'code-status-ok' => 'ଠିକ ଅଛି',
	'code-status-deferred' => 'ପଛକୁ ଅଟକାଇରଖିବା',
	'code-status-desc-deferred' => 'ସଂସ୍କରଣରେ ସମୀକ୍ଷା ଲୋଡ଼ା ନାହିଁ ।',
	'code-status-old' => 'ପୁରୁଣା',
	'code-signoffs' => 'ସାଇନ-ଅଫ',
	'code-signoff-legend' => 'ସାଇନ-ଅଫ ଯୋଡ଼ିବେ',
	'code-signoff-submit' => 'ସାଇନ-ଅଫ',
	'code-signoff-strike' => 'ସାଇନ-ଅଫକୁ କାଟିଦେବେ',
	'code-signoff-signoff' => 'ଏହି ସଂସ୍କରଣରେ କେଉଁ ଭାବରେ ସାଇନ-ଅଫ କରିବେ:',
	'code-signoff-flag-inspected' => 'ପରଖାଗଲା',
	'code-signoff-flag-tested' => 'ପରଖାଗଲା',
	'code-signoff-field-user' => 'ବ୍ୟବହାରକାରୀ',
	'code-signoff-field-flag' => 'ବିଶେଷ ସୂଚକ',
	'code-signoff-field-date' => 'ତାରିଖ',
	'code-signoff-struckdate' => '$1 ($2 ବାଧା)',
	'code-pathsearch-path' => 'ପଥ:',
	'code-pathsearch-filter' => 'ଖାଲି ଦେଖାଇବେ:',
	'code-revfilter-cr_status' => 'ସ୍ଥିତି = $1',
	'code-revfilter-cr_author' => 'ଲେଖକ = $1',
	'code-revfilter-ct_tag' => 'ଟାଗ = $1',
	'code-revfilter-clear' => 'ଛଣାଟିକୁ ସଫା କରିବେ',
	'code-rev-submit' => 'ବଦଳଗୁଡ଼ିକୁ ସାଇତିବେ',
	'code-rev-submit-next' => 'ସାଇତିବେ ଓ ଏହା ପରର ଅସମାହିତ',
	'code-rev-next' => 'ଏହା ପରର ଅସମାହିତ',
	'code-batch-status' => 'ସ୍ଥିତି ବଦଳାଇବେ:',
	'code-batch-tags' => 'ଚିହ୍ନ ବଦଳାଇବେ:',
	'codereview-batch-title' => 'ବଛାହୋଇଥିବା ସବୁଯାକ ସଂସ୍କରଣ ବଦଳାଇବେ',
	'codereview-batch-submit' => 'ଦାଖଲ କରିବା',
	'code-releasenotes' => 'ଉଦଘାଟନ ଟୀକା',
	'code-release-legend' => 'ଉଦଘାଟନ ଟୀକା ତିଆରିକରିବେ',
	'code-release-startrev' => 'ସମୀକ୍ଷା ଆରମ୍ଭ କରିବେ:',
	'code-release-endrev' => 'ଶେଷ ସଂସ୍କରଣ:',
	'codereview-subtitle' => '$1 ନିମନ୍ତେ',
	'codereview-reply-link' => 'ଉତ୍ତର',
	'codereview-overview-title' => 'ନିରୀକ୍ଷଣ',
	'codereview-email-subj' => '[$1 $2]: ନୂଆ ମତାମତ ଯୋଡ଼ାଗଲା',
	'codereview-email-subj2' => '[$1 $2]: ପଚରା-ଉଚରା ବଦଳ',
	'codereview-email-subj3' => '[$1 $2]: ସଂସ୍କରଣ ସ୍ଥିତି ବଦଳାଗଲା',
	'codereview-email-body3' => '"$1" $2ର ସ୍ଥିତିକୁ "$4"କୁ ବଦଳାଇଦେଲେ
URL: $5

ପୁରୁଣା ସ୍ଥିତି:  $3
ନୂଆ ସ୍ଥିତି: $4

$2 ପାଇଁ ସାରକଥା ଦେବେ:

$6',
	'codereview-email-subj4' => '[$1 $2]: ନୂଆ ମତ ଯୋଡ଼ାହେଲା, ତଥା ସଂସ୍କରଣ ସ୍ଥିତି ବଦଳାଗଲା',
	'codereview-email-body4' => '"$1" $2ର ସ୍ଥିତିକୁ "$4"କୁ ବଦଳାଇ ନିଜ ମତ ଦେଲେ ।
URL: $5

ପୁରୁଣା ସ୍ଥିତି: $3
ନୂଆ ସ୍ଥିତି: $4

$2 ପାଇଁ ସାରକଥା ଦେବେ:

$7

$1ଙ୍କ ସାରକଥା:

$6',
	'code-stats' => 'ହିସାବ',
	'code-stats-header' => '$1 ଭଣ୍ଡାରଟି ପାଇଁ ପରିସଙ୍ଖ୍ୟାନ',
	'code-stats-main' => '$1 ଅନୁସାରେ, ଭଣ୍ଡାରରେ [[Special:Code/$3/author|$4 {{PLURAL:$4|ଲେଖକଙ୍କ|ଲେଖକମାନଙ୍କ}}]] ଦେଇ $2 ଗୋଟି {{PLURAL:$2|ସଂସ୍କରଣ|ସଂସ୍କରଣ}} କରାଗଲା ।',
	'code-stats-status-breakdown' => 'ଅବଟା ପ୍ରତି ସଂସ୍କରଣ',
	'code-stats-fixme-breakdown' => 'ପଥ ପ୍ରତି fixme ସଂସ୍କରଣର ଭାଙ୍ଗିବା',
	'code-stats-fixme-breakdown-path' => 'ପଥ ପ୍ରତି fixme ସଂସ୍କରଣର ଭଙ୍ଗ',
	'code-stats-fixme-path' => 'ପଥ ପ୍ରତି ନୂଆ ସଂସ୍କରଣ: $1',
	'code-stats-new-breakdown' => 'ଲେଖକ ପ୍ରତି ନୂଆ ସଂସ୍କରଣର ଭଙ୍ଗ',
	'code-stats-new-breakdown-path' => 'ପଥ ପ୍ରତି ନୂଆ ସଂସ୍କରଣର ଭାଙ୍ଗିବା',
	'code-stats-new-path' => 'ପଥ ପ୍ରତି ନୂଆ ସଂସ୍କରଣ: $1',
	'code-stats-count' => 'ସଂସ୍କରଣ ସଂଖ୍ୟା',
	'code-tooltip-withsummary' => '$3ଙ୍କ ଦେଇ r$1 [$2] - $4',
	'code-tooltip-withoutsummary' => '$3ଙ୍କ ଦେଇ r$1 [$2]',
	'repoadmin' => 'ଭଣ୍ଡାର ପ୍ରଶାସନ',
	'repoadmin-new-legend' => 'ନୂଆ ଭଣ୍ଡାରଗୃହ ତିଆରି କରିବେ',
	'repoadmin-new-label' => 'ଭଣ୍ଡାର ନାମ:',
	'repoadmin-new-button' => 'ତିଆରି',
	'repoadmin-edit-legend' => '"$1" ଭଣ୍ଡାରରେ ବଦଳ',
	'repoadmin-edit-path' => 'ଭଣ୍ଡାର ନାମ:',
	'repoadmin-edit-bug' => 'ବଗଜିଲ୍ଲା ରାସ୍ତା:',
	'repoadmin-edit-view' => 'ViewVC ପଥ:',
	'repoadmin-edit-button' => 'ଠିକ ଅଛି',
	'repoadmin-edit-sucess' => 'ଭଣ୍ଡାରଟି "[[Special:Code/$1|$1]]" ସଫଳଭାବେ ବଦଳାଗଲା ।',
	'repoadmin-nav' => 'ଭଣ୍ଡାର ପ୍ରଶାସନ',
	'right-repoadmin' => 'କୋଡ଼ ଭଣ୍ଡାର ପରିଚାଳନା',
	'right-codereview-use' => 'Special:Code ର ବ୍ୟବହାର',
	'right-codereview-add-tag' => 'ସଂସ୍କରଣରେ ନୂଆ ଚିହ୍ନ ଯୋଡ଼ିବେ',
	'right-codereview-remove-tag' => 'ସଂସ୍କରଣରୁ ଚିହ୍ନ କାଢ଼ିଦେବେ',
	'right-codereview-post-comment' => 'ସଂସ୍କରଣରେ ମତାମତ ଯୋଡ଼ିବେ',
	'right-codereview-set-status' => 'ସଂସ୍କରଣ ସ୍ଥିତି ବଦଳାଇବେ',
	'right-codereview-signoff' => 'ସଂସ୍କରଣରେ ସାନ-ଅଫ',
	'right-codereview-link-user' => 'ଲେଖକଙ୍କ ଲିଙ୍କ ଉଇକି ଇଉଜରଙ୍କୁ ଦିଅନ୍ତୁ',
	'right-codereview-associate' => 'ସଂସ୍କରଣ ସହଯୋଗୀ ସବୁ ପରିଚାଳନା କରିବେ',
	'right-codereview-review-own' => 'ଆପଣା ସଂସ୍କରଣକୁ ଠିକ ବା ସୁଧରାଯାଇଛି ବୋଲି ଚିହ୍ନିତ କରନ୍ତୁ',
	'specialpages-group-developer' => 'ଡେଭେଲପର ଟୁଲ',
	'group-svnadmins' => 'SVN ପରିଛାଗଣ',
	'group-svnadmins-member' => '{{GENDER:$1|SVN ପରିଛା}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN ପରିଛାଗଣ',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'code-field-status' => 'Статус',
	'code-field-timestamp' => 'Датæ',
	'code-field-comments' => 'Фиппаинæгтæ',
	'code-field-text' => 'Фиппаинаг',
	'code-rev-author' => 'Автор:',
	'code-rev-status' => 'Статус:',
	'code-rev-comment-preview' => 'Разæркаст',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'code-comments' => 'Aamaerickinge',
	'code-references' => 'Neegschte Versione',
	'code-change-removed' => 'gelöscht:',
	'code-change-added' => 'dezu geduh:',
	'code-authors' => 'Schreiwer',
	'code-field-author' => 'Schreiwer',
	'code-field-comments' => 'Aamaerickinge',
	'code-field-path' => 'Paad',
	'code-rev-author' => 'Schreiwer',
	'code-rev-message' => 'Aamaericking:',
	'code-rev-rev-viewvc' => 'uff ViewVC',
	'code-rev-modified-a' => 'dezu geduh',
	'code-rev-modified-d' => 'gelescht',
	'code-rev-modified-m' => 'gennert',
	'code-rev-comment-by' => 'Aamaericking vun $1',
	'code-rev-comment-preview' => 'Aagucke',
	'code-rev-inline-preview' => 'Aagucke:',
	'code-status-new' => 'nei',
	'code-status-ok' => 'OK',
	'code-status-old' => 'ald',
	'code-signoff-field-user' => 'Yuuser',
	'code-revfilter-cr_author' => 'Schreiwer = $1',
	'code-rev-submit' => 'Enneringe beilege',
	'codereview-subtitle' => 'Fer $1',
	'code-stats' => 'Nummere',
	'repoadmin-new-button' => 'Schtaerte',
	'repoadmin-edit-path' => 'Paad zum Repository:',
	'repoadmin-edit-bug' => 'Paad zu Bugzilla:',
	'repoadmin-edit-view' => 'Paad zu ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'group-svnadmins' => 'SVN-Verwalter',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-Verwalter}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN-Verwalter',
);

/** Pälzisch (Pälzisch)
 * @author Xqt
 */
$messages['pfl'] = array(
	'code-stats' => 'Schdadischdike',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Equadus
 * @author Leinad
 * @author Marcin Łukasz Kiejzik
 * @author Olgak85
 * @author Sp5uhe
 * @author Woytecr
 */
$messages['pl'] = array(
	'code' => 'Podgląd kodu',
	'code-rev-title' => '$1 – Podgląd kodu',
	'code-comments' => 'Komentarze',
	'code-references' => 'Następne wersje',
	'code-change-status' => "zmieniono '''status''' $1",
	'code-change-tags' => "zmieniono '''znaczniki''' $1",
	'code-change-removed' => 'usunięto:',
	'code-change-added' => 'dodano:',
	'code-old-status' => 'Poprzedni status',
	'code-new-status' => 'Nowy status',
	'code-prop-changes' => 'Rejestr zmian statusu i znaczników',
	'codereview-desc' => '[[Special:Code|Narzędzie do przeglądania]] oraz [[Special:RepoAdmin|zarządzania wersjami]] kodu źródłowego',
	'code-no-repo' => 'Brak skonfigurowanego repozytorium!',
	'code-create-repo' => 'Idź do [[Special:RepoAdmin|RepoAdmin]], aby utworzyć repozytorium',
	'code-need-repoadmin-rights' => 'do utworzenia repozytorium konieczne są uprawnienia repoadmin',
	'code-need-group-with-rights' => 'Brak grupy z uprawnieniami repoadmin. Dodaj jakąś, aby mieć możliwość utworzenia repozytorium.',
	'code-repo-not-found' => "Repozytorium '''$1''' nie istnieje!",
	'code-load-diff' => 'Ładowanie różnic…',
	'code-notes' => 'ostatnie komentarze',
	'code-statuschanges' => 'zmiany statusu',
	'code-mycommits' => 'moje aktualizacje',
	'code-mycomments' => 'moje komentarze',
	'code-authors' => 'autorzy',
	'code-status' => 'statusy',
	'code-tags' => 'znaczniki',
	'code-tags-no-tags' => 'Brak znaczników w tym repozytorium.',
	'code-authors-text' => 'Poniżej znajduje się lista autorów repozytorium w kolejności nazwy poprawki. Lokalne konta wiki są wyświetlane w nawiasach. Dane mogą pochodzi z pamięci tymczasowej.',
	'code-author-haslink' => 'Ten autor jest podlinkowany do konta użytkownika na wiki jako $1',
	'code-author-orphan' => 'Użytkownik SVN lub autor $1 nie jest powiązany z żadnym kontem wiki',
	'code-author-dolink' => 'Podlinkuj tego autora do konta użytkownika na wiki:',
	'code-author-alterlink' => 'Zmień linkowanie tego autora do konta użytkownika na wiki:',
	'code-author-orunlink' => 'Lub odlinkuj to konto użytkownika na wiki:',
	'code-author-name' => 'Wprowadź nazwę użytkownika',
	'code-author-success' => 'Autor $1 został podlinkowany do konta użytkownika na wiki jako $2',
	'code-author-link' => 'podlinkować?',
	'code-author-unlink' => 'odlinkować?',
	'code-author-unlinksuccess' => 'Autor $1 został odlinkowany',
	'code-author-badtoken' => 'Wystąpił błąd sesji w trakcie podejmowania akcji.',
	'code-author-total' => 'Wszystkich autorów – $1',
	'code-author-lastcommit' => 'Data ostatniego zapisania',
	'code-browsing-path' => "Przeglądanie rewizji w '''$1'''",
	'code-field-id' => 'Wersja',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Autor komentarza',
	'code-field-message' => 'Opis dokonanej zmiany',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Opis statusu',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Komentarze',
	'code-field-path' => 'Ścieżka',
	'code-field-text' => 'Komentarz',
	'code-field-select' => 'Wybór',
	'code-reference-remove' => 'Usuń wybrane powiązania',
	'code-reference-associate' => 'Powiąż następującą wersję',
	'code-reference-associate-submit' => 'Powiąż',
	'code-rev-author' => 'Autor',
	'code-rev-date' => 'Data',
	'code-rev-message' => 'Opis wykonanej zmiany',
	'code-rev-repo' => 'Repozytorium',
	'code-rev-rev' => 'Wersja',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Zmodyfikowane ścieżki:',
	'code-rev-modified-a' => 'dodany',
	'code-rev-modified-r' => 'przeniesiony',
	'code-rev-modified-d' => 'usunięty',
	'code-rev-modified-m' => 'zmodyfikowany',
	'code-rev-imagediff' => 'Zmiany obrazu',
	'code-rev-status' => 'Status',
	'code-rev-status-set' => 'Zmień status',
	'code-rev-tags' => 'Znaczniki:',
	'code-rev-tag-add' => 'Dodaj znaczniki:',
	'code-rev-tag-remove' => 'Usuń znaczniki:',
	'code-rev-comment-by' => 'Skomentowane przez $1',
	'code-rev-comment-preview' => 'Podgląd',
	'code-rev-inline-preview' => 'Podgląd:',
	'code-rev-diff' => 'Wykonane zmiany',
	'code-rev-diff-link' => 'różn.',
	'code-rev-diff-too-large' => 'Różnice są zbyt duże, aby je wyświetlić.',
	'code-rev-purge-link' => 'odśwież',
	'code-rev-total' => 'Łączna liczba wyników – $1',
	'code-rev-not-found' => "Wersja '''$1''' nie istnieje!",
	'code-rev-history-link' => 'historia',
	'code-status-new' => 'nowy',
	'code-status-desc-new' => 'Wersja oczekuje podjęcia jakiegoś działania (status domyślny).',
	'code-status-fixme' => 'wymaga naprawy',
	'code-status-desc-fixme' => 'Wersja jest błędna lub uszkodzona. Powinna zostać naprawiona lub wycofana.',
	'code-status-reverted' => 'cofnięty',
	'code-status-desc-reverted' => 'Wersja została zastąpiona późniejszą treścią.',
	'code-status-resolved' => 'rozwiązany',
	'code-status-desc-resolved' => 'Wersja była oznaczona jako wymagająca poprawek i zostały one wykonane.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Redaktor jest pewien, że wersja została w pełni i pod każdym kątem przejrzana.',
	'code-status-deferred' => 'odroczony',
	'code-status-desc-deferred' => 'Wersja nie wymaga przeglądu.',
	'code-status-old' => 'stary',
	'code-status-desc-old' => 'Stara wersja, która może zawierać błędy, ale wyszukiwanie i poprawianie ich nie ma obecnie sensu.',
	'code-signoffs' => 'Autorytarnie zatwierdzone',
	'code-signoff-legend' => 'Oznacz jako autorytarnie zatwierdzone',
	'code-signoff-submit' => 'Autorytarnie zatwierdzam',
	'code-signoff-strike' => 'Przekreśl wybrane autorytarne zatwierdzenia',
	'code-signoff-signoff' => 'Autorytarnie zatwierdź tę wersję jako',
	'code-signoff-flag-inspected' => 'Skontrolowane',
	'code-signoff-flag-tested' => 'Przetestowane',
	'code-signoff-field-user' => 'Użytkownik',
	'code-signoff-field-flag' => 'Flaga',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 (skreślił $2)',
	'code-pathsearch-legend' => 'Szukaj wersji w tym repozytorium na podstawie ścieżki',
	'code-pathsearch-path' => 'Ścieżka',
	'code-pathsearch-filter' => 'Pokaż tylko:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Znacznik = $1',
	'code-revfilter-clear' => 'Wyczyść filtr',
	'code-rev-submit' => 'Zapisz zmiany',
	'code-rev-submit-next' => 'Zapisz i pokaż kolejny nierozwiązany',
	'code-rev-next' => 'Następny nierozwiązany',
	'code-batch-status' => 'Zmiana statusu:',
	'code-batch-tags' => 'Zmiana znaczników:',
	'codereview-batch-title' => 'Zmień wszystkie wybrane wersje',
	'codereview-batch-submit' => 'Zapisz',
	'code-releasenotes' => 'opis wersji',
	'code-release-legend' => 'Wygeneruj opis wersji',
	'code-release-startrev' => 'Wersja początkowa',
	'code-release-endrev' => 'Ostatnia wersja',
	'codereview-subtitle' => 'Dla $1',
	'codereview-reply-link' => 'odpowiedz',
	'codereview-overview-title' => 'Przegląd',
	'codereview-overview-desc' => 'Pokaż graficzny przegląd tej listy',
	'codereview-email-subj' => '[$1 $2] - dodano nowy komentarz',
	'codereview-email-body' => 'Użytkownik „$1” dodał komentarz w $3.

Pełny adres URL – $2

Opis dokonanej zmiany:

$5

Komentarz:

$4',
	'codereview-email-subj2' => '[$1 $2] - kolejne zmiany',
	'codereview-email-body2' => 'Użytkownik „$1” wykonał kolejne zmiany w $2.

Pełny adres URL do poprzedniej wersji – $5
Opis dokonanej zmiany:

$6

Pełny adres URL do tej wersji – $3
Opis dokonanej zmiany:

$4',
	'codereview-email-subj3' => '[$1 $2] - zmiana statusu wersji',
	'codereview-email-body3' => 'Użytkownik „$1” zmienił status $2.

Poprzedni status – $3
Nowy status – $4

Pełny adres URL – $5
Opis dokonanej zmiany:

$6',
	'codereview-email-subj4' => '[$1 $2] - dodano nowy komentarz i zmieniono status wersji',
	'codereview-email-body4' => 'Użytkownik „$1” zmienił status $2.

Stary status – $3
Nowy status – $4

Użytkownik „$1” dodał również komentarz w $2.

Pełny adres URL – $5
Opis dokonanej zmiany:

$7

Komentarz:

$6',
	'code-stats' => 'statystyki',
	'code-stats-header' => 'Statystyki repozytorium $1',
	'code-stats-main' => 'Na dzień $1 w repozytorium znajduje się $2 {{PLURAL:$2|poprawka wprowadzona|poprawki wprowadzone|poprawek wprowadzonych}} przez [[Special:Code/$3/author|$4 {{PLURAL:$4|autora|autorów}}]].',
	'code-stats-status-breakdown' => 'Liczba poprawek dla stanu',
	'code-stats-fixme-breakdown' => 'Zestawienie zmian wymagających sprawdzenia posortowane ze względu na autora',
	'code-stats-fixme-breakdown-path' => 'Zestawienie zmian wymagających sprawdzenia posortowane ze względu na ścieżkę',
	'code-stats-fixme-path' => 'Zmiany wymagające sprawdzenia posortowane ze względu na ścieżkę: $1',
	'code-stats-new-breakdown' => 'Zestawienie nowych zmian posortowane ze względu na autora',
	'code-stats-new-breakdown-path' => 'Zestawienie zmian posortowane ze względu na ścieżkę',
	'code-stats-new-path' => 'Nowe poprawki dla ścieżki:$1',
	'code-stats-count' => 'Liczba poprawek',
	'code-tooltip-withsummary' => 'r$1 [$2] przez $3 – $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] przez $3',
	'repoadmin' => 'Administrowanie repozytorium',
	'repoadmin-new-legend' => 'Utwórz nowe repozytorium',
	'repoadmin-new-label' => 'Nazwa repozytorium',
	'repoadmin-new-button' => 'Utwórz',
	'repoadmin-edit-legend' => 'Modyfikacja repozytorium „$1”',
	'repoadmin-edit-path' => 'Ścieżka URL do repozytorium',
	'repoadmin-edit-bug' => 'Ścieżka URL do Bugzilli',
	'repoadmin-edit-view' => 'Ścieżka URL do ViewVC',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Repozytorium „[[Special:Code/$1|$1]]” zostało pomyślnie zmodyfikowane.',
	'repoadmin-nav' => 'administrowanie repozytorium',
	'right-repoadmin' => 'Zarządzanie repozytoriami z kodami źródłowymi',
	'right-codereview-use' => 'Korzystanie ze Specjalna:Kod',
	'right-codereview-add-tag' => 'Dodawanie znaczników do wersji',
	'right-codereview-remove-tag' => 'Usuwanie znaczników dla wersji',
	'right-codereview-post-comment' => 'Dodawanie komentarzy do wersji',
	'right-codereview-set-status' => 'Zmiana statusu wersji',
	'right-codereview-signoff' => 'Autorytarnie zaakceptuj wersje',
	'right-codereview-link-user' => 'Linkowanie autorów do ich kont na wiki',
	'right-codereview-associate' => 'Zarządzanie powiązaniem wersji',
	'right-codereview-review-own' => 'Oznaczanie moich zmian jako „OK” lub załatwionych',
	'specialpages-group-developer' => 'Narzędzia dewelopera',
	'group-svnadmins' => 'Administratorzy SVN',
	'group-svnadmins-member' => '{{GENDER:$1|administrator SVN|administratorka SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Administratorzy SVN',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'code' => 'Revision dël còdes',
	'code-rev-title' => '$1 - Revision dël còdes',
	'code-comments' => 'Coment',
	'code-references' => 'Revision suplementar',
	'code-referenced' => 'Revision suplementar',
	'code-change-status' => "cangià lë '''stat'' ëd $1",
	'code-change-tags' => "a l'ha cangià le '''tichëtte''' ëd $1",
	'code-change-removed' => 'gavà:',
	'code-change-added' => 'giontà',
	'code-old-status' => 'Stat vej',
	'code-new-status' => 'Stat neuv',
	'code-prop-changes' => 'Registr djë stat e dle tichëtte',
	'codereview-desc' => '[[Special:Code|Utiss ëd revision dël còdes]] con [[Special:RepoAdmin|manten ëd sot-version]]',
	'code-no-repo' => 'Gnun depòsit configurà!',
	'code-create-repo' => 'Va a [[Special:RepoAdmin|RepoAdmin]] për creé un Depòsit',
	'code-need-repoadmin-rights' => 'a-i é dabzògn dij drit ëd repoadmin për podèj creé un Depòsit',
	'code-need-group-with-rights' => "A esisto gnun-e partìe con ij drit ëd repoadmin. Për piasì, ch'a na gionta un-a për podèj gionté un Depòsit neuv",
	'code-repo-not-found' => "L'archivi '''$1''' a esist pa!",
	'code-load-diff' => 'Cariament dif...',
	'code-notes' => 'coment recent',
	'code-statuschanges' => 'cangiament dë statù',
	'code-mycommits' => 'mie publicassion',
	'code-mycomments' => 'ij mè coment',
	'code-authors' => 'autor',
	'code-status' => 'stat',
	'code-tags' => 'tichëtte',
	'code-tags-no-tags' => 'A esist gnun-a tichëtta ant ës depòsit.',
	'code-authors-text' => "Sota a-i é na lista dj'autor dël depòsit ant l'órdin dël nòm ëd salvatagi. Ij cont dla wiki local a son mostrà antra parèntes. Ij dat a podrìo ven-e da na memòria local.",
	'code-author-haslink' => "St'autor-sì a l'é colegà a l'utent wiki $1",
	'code-author-orphan' => "L'utent/Autor SVN $1 a l'ha pa gnun colegament con un cont wiki",
	'code-author-dolink' => "Colega st'autor-sì a n'utent wiki:",
	'code-author-alterlink' => "Cangé l'utent wiki colegà a st'autor-sì:",
	'code-author-orunlink' => "O dëscoleghé st'utent wiki-sì:",
	'code-author-name' => 'Che a buta në stranòm:',
	'code-author-success' => "L'autor $1 a l'é stàit colegà a l'utent wiki $2",
	'code-author-link' => 'coleghé?',
	'code-author-unlink' => 'dëscoleghé?',
	'code-author-unlinksuccess' => "L'autor $1 a l'é stàit dëscolegà",
	'code-author-badtoken' => "Eror ëd session an provand a fé l'assion.",
	'code-author-total' => "Nùmer total d'autor: $1",
	'code-author-lastcommit' => 'Ùltima data ëd salvatagi',
	'code-browsing-path' => "Vardé le revision an '''$1'''",
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentador',
	'code-field-message' => 'Resumé ëd publicassion',
	'code-field-status' => 'Stat',
	'code-field-status-description' => 'Descrission dlë stat',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Coment',
	'code-field-path' => 'Përcors',
	'code-field-text' => 'Nòta',
	'code-field-select' => 'Selession-a',
	'code-reference-remove' => "Gavé j'associassion selessionà",
	'code-reference-associate' => 'Assossié la revision tacà:',
	'code-reference-associate-submit' => 'Assòcia',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Coment:',
	'code-rev-repo' => 'Depòsit:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'dzora a ViewVC',
	'code-rev-paths' => 'Përcors modificà:',
	'code-rev-modified-a' => 'giontà',
	'code-rev-modified-r' => 'rimpiassà',
	'code-rev-modified-d' => 'scancelà',
	'code-rev-modified-m' => 'modificà',
	'code-rev-imagediff' => 'Modìfiche ëd figure',
	'code-rev-status' => 'Stat:',
	'code-rev-status-set' => 'Cangé lë stat',
	'code-rev-tags' => 'Tichëtte:',
	'code-rev-tag-add' => 'Gionté le tichëtte:',
	'code-rev-tag-remove' => 'Gavé le tichëtte:',
	'code-rev-comment-by' => 'Coment ëd $1',
	'code-rev-comment-preview' => 'Preuva',
	'code-rev-inline-preview' => 'Preuva:',
	'code-rev-diff' => 'Dif.',
	'code-rev-diff-link' => 'dif.',
	'code-rev-diff-too-large' => "La diferensa a l'é tròp gròssa da visualisé",
	'code-rev-purge-link' => 'polida',
	'code-rev-total' => "Nùmer total d'arzultà: $1",
	'code-rev-not-found' => "La revision '''$1''' a esist pa!",
	'code-rev-history-link' => 'stòria',
	'code-status-new' => 'neuv',
	'code-status-desc-new' => "La revision a speta n'assion (stat dë stàndard).",
	'code-status-fixme' => 'coregg-me',
	'code-status-desc-fixme' => "Na revision a l'ha antroduvù n'eror o a l'é falà. A dovrìa esse coregiùa o gavà.",
	'code-status-reverted' => "butà torna com a l'era",
	'code-status-desc-reverted' => "Le revision a son ëstàite campà via da n'àutra revision.",
	'code-status-resolved' => 'arzolvù',
	'code-status-desc-resolved' => "La revision a l'ha avù un problema ch'a l'é stàit coregiù da n'àutra revision.",
	'code-status-ok' => 'va bin',
	'code-status-desc-ok' => "Revision completament revisionà, dont revisor a l'é sigur ch'a va bin an tute le manere.",
	'code-status-deferred' => 'spostà',
	'code-status-desc-deferred' => "La revision a ciama pa d'esse arlesùa.",
	'code-status-old' => 'vej',
	'code-status-desc-old' => "Na veja revision con d'eror potensiaj ma che a val pa lë sfòrs ëd revisionela.",
	'code-signoffs' => 'Conclud',
	'code-signoff-legend' => "Gionté n'aprovassion",
	'code-signoff-submit' => 'Conclud',
	'code-signoff-strike' => "Sganfé j'aprovassion selessionà",
	'code-signoff-signoff' => 'Firma sta revision com:',
	'code-signoff-flag-inspected' => 'Ispessionà',
	'code-signoff-flag-tested' => 'Provà',
	'code-signoff-field-user' => 'Utent',
	'code-signoff-field-flag' => 'Marca',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 (trovà $2)',
	'code-pathsearch-legend' => 'Sërché dle revision an sto depòsit-sì për përcors',
	'code-pathsearch-path' => 'Përcors',
	'code-pathsearch-filter' => 'Smon-e mach:',
	'code-revfilter-cr_status' => 'Stat = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Tichëtta = $1',
	'code-revfilter-clear' => 'Scancelé ël filtr',
	'code-rev-submit' => 'Salvé ij cangiament',
	'code-rev-submit-next' => 'Salvé & problema nen arzolvù apress',
	'code-rev-next' => 'Sucessiv an sospèis',
	'code-batch-status' => 'Cangé lë statù:',
	'code-batch-tags' => 'Cangé le tichëtte:',
	'codereview-batch-title' => 'Cangia tute le revision selessionà',
	'codereview-batch-submit' => 'Spediss',
	'code-releasenotes' => 'nòte ëd publicassion',
	'code-release-legend' => 'Generé le nòte ëd publicassion',
	'code-release-startrev' => 'Revision inissial:',
	'code-release-endrev' => 'Ùltima revision',
	'codereview-subtitle' => 'Për $1',
	'codereview-reply-link' => 'arspond',
	'codereview-overview-title' => "Vista d'ansem",
	'codereview-overview-desc' => "Smon-e na vista d'ansem gràfica ëd costa lista",
	'codereview-email-subj' => '[$1 $2]: Pa gnun coment giontà',
	'codereview-email-body' => 'L\'utent "$1" a l\'ha spedì un coment su $3.

Adrëssa dl\'aragnà completa: $2
Resumé dla modìfica:

$5

Coment:

$4',
	'codereview-email-subj2' => '[$1 $2]: Cangiament suplementar',
	'codereview-email-body2' => 'L\'utent "$1" a l\'ha fàit dij cangiament suplementar a $2.

Adrëssa dl\'aragnà completa apress la revision: $5
Resumé dla modìfica:

$6

Adrëssa dl\'aragnà completa: $3

Resumé dla modìfica:

$4',
	'codereview-email-subj3' => "[$1 $2]: Lë stat ëd revision a l'é cangià",
	'codereview-email-body3' => 'L\'utent "$1" a l\'ha cangià lë stat ëd $2.

Stat Vej: $3
Stat Neuv: $4

Anliura completa: $5
Resumé dla modìfica:

$6',
	'codereview-email-subj4' => '[$1 $2]: Giontà coment neuv, e cangià stat ëd la revision',
	'codereview-email-body4' => 'L\'utent "$1" a l\'ha cangià lë stat ëd $2.

Stat Vej: $3
Stat Neuv: $4

L\'utent "$1" a l\'ha ëdcò spedì un coment su $2.

Anliura completa: $5
Resumé dla modìfica:

$7

Coment:

$6',
	'code-stats' => 'statìstiche',
	'code-stats-header' => 'Statìstiche për ël depòsit  $1',
	'code-stats-main' => "Ai $1, ël depòsit a l'ha $2  {{PLURAL:$2|revision|revision}} për [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autor}}]].",
	'code-stats-status-breakdown' => 'Nùmer ëd revision për stat',
	'code-stats-fixme-breakdown' => 'Partagi ëd le revision da corege për autor',
	'code-stats-fixme-breakdown-path' => 'Partagi ëd le revision da corege për përcors',
	'code-stats-fixme-path' => 'Revision da corege për përcors: $1',
	'code-stats-new-breakdown' => 'Dìvision ëd le revision neuve për autor',
	'code-stats-new-breakdown-path' => 'Partagi ëd le revision neuve për përcors',
	'code-stats-new-path' => 'Revision neuve për përcors: $1',
	'code-stats-count' => 'Nùmer ëd revision',
	'code-tooltip-withsummary' => 'r$1 [$2] da $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] da $3',
	'repoadmin' => 'Aministrassion dij depòsit',
	'repoadmin-new-legend' => 'Crea un neuv depòsit',
	'repoadmin-new-label' => 'Nòm dël depòsit:',
	'repoadmin-new-button' => 'Crea',
	'repoadmin-edit-legend' => 'Modìfiche dël depòsit "$1"',
	'repoadmin-edit-path' => 'Përcors dël depòsit:',
	'repoadmin-edit-bug' => 'Përcors ëd Bugzilla:',
	'repoadmin-edit-view' => 'Përcors ëd ViewVC:',
	'repoadmin-edit-button' => 'Va bin',
	'repoadmin-edit-sucess' => 'Ël depòsit "[[Special:Code/$1|$1]]" a l\'é stàit modificà da bin.',
	'repoadmin-nav' => 'aministrassion dël depòsit',
	'right-repoadmin' => 'Aministré ij depòsit ëd còdes',
	'right-codereview-use' => 'Usagi ëd Special:Code',
	'right-codereview-add-tag' => 'Gionté dle neuve tichëtte a le revision',
	'right-codereview-remove-tag' => 'Gavé dle tichëtte da le revision',
	'right-codereview-post-comment' => 'Gionté dij coment a le revision',
	'right-codereview-set-status' => 'Cangia stat ëd revision',
	'right-codereview-signoff' => 'Conclud le revision',
	'right-codereview-link-user' => 'Colega autor a utent wiki',
	'right-codereview-associate' => "Gestì j'associassion ëd revision",
	'right-codereview-review-own' => "Marché toe pròpie revision com Arzolvùe o ch'a van bin",
	'specialpages-group-developer' => 'Utiss dël dësvlupador',
	'group-svnadmins' => 'Aministrator SVN',
	'group-svnadmins-member' => '{{GENDER:$1|Aministrator SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Aministrator SVN',
);

/** Pontic (Ποντιακά)
 * @author Omnipaedista
 */
$messages['pnt'] = array(
	'repoadmin-edit-button' => 'Εγέντον',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'code' => 'د کوډ مخکتنه',
	'code-comments' => 'تبصرې',
	'code-change-removed' => 'غورځول شوی:',
	'code-change-added' => 'ګډ شوی:',
	'code-old-status' => 'پخوانی دريځ',
	'code-new-status' => 'نوی دريځ',
	'code-notes' => 'تازه تبصرې',
	'code-statuschanges' => 'د دريځ بدلونونه',
	'code-mycomments' => 'زما تبصرې',
	'code-authors' => 'ليکوالان',
	'code-author-link' => 'تړنه؟',
	'code-field-author' => 'ليکوال',
	'code-field-user' => 'مبصر',
	'code-field-status' => 'دريځ',
	'code-field-timestamp' => 'نېټه',
	'code-field-comments' => 'تبصرې',
	'code-field-text' => 'يادښت',
	'code-field-select' => 'ټاکل',
	'code-reference-associate-submit' => 'يوځای کول',
	'code-rev-author' => 'ليکوال:',
	'code-rev-date' => 'نېټه:',
	'code-rev-message' => 'تبصره:',
	'code-rev-modified-a' => 'ورګډ شو',
	'code-rev-modified-r' => 'ځايناستی شوی',
	'code-rev-modified-d' => 'ړنګ شو',
	'code-rev-modified-m' => 'بدل شو',
	'code-rev-imagediff' => 'د انځور بدلونونه',
	'code-rev-status' => 'دريځ:',
	'code-rev-status-set' => 'دريځ بدلول',
	'code-rev-comment-by' => 'تبصره د $1 لخوا',
	'code-rev-comment-preview' => 'مخليدنه',
	'code-rev-inline-preview' => 'مخليدنه:',
	'code-rev-diff' => 'توپير',
	'code-rev-diff-link' => 'توپير',
	'code-rev-purge-link' => 'سپينول',
	'code-rev-history-link' => 'پېښليک',
	'code-status-new' => 'نوی',
	'code-status-ok' => 'ښه',
	'code-status-old' => 'زوړ',
	'code-signoff-submit' => 'وتل',
	'code-signoff-flag-tested' => 'و آزمويل شو',
	'code-signoff-field-user' => 'کارن',
	'code-signoff-field-flag' => 'رپی',
	'code-signoff-field-date' => 'نېټه',
	'code-revfilter-cr_status' => 'دريځ = $1',
	'code-revfilter-cr_author' => 'ليکوال = $1',
	'code-revfilter-clear' => 'چاڼګرونه پاکول',
	'code-rev-submit' => 'بدلونونه خوندي کول',
	'code-batch-status' => 'دريځ بدلول:',
	'codereview-batch-submit' => 'سپارل',
	'codereview-reply-link' => 'ځوابول',
	'codereview-overview-title' => 'مخليدنه',
	'codereview-email-body' => 'د "$1" کارن په $3 يوه تبصره کړې.

بشپړه پته: $2
د تبصرې لنډيز:

$5

تبصره:

$4',
	'code-stats' => 'شمارنې',
	'repoadmin-new-button' => 'جوړول',
	'repoadmin-edit-button' => 'ښه',
	'group-svnadmins' => 'د SVN پازوالان',
);

/** Portuguese (Português)
 * @author Crazymadlover
 * @author Giro720
 * @author Hamilton Abreu
 * @author Lijealso
 * @author Malafaya
 * @author MetalBrasil
 * @author Waldir
 */
$messages['pt'] = array(
	'code' => 'Revisão de Código',
	'code-rev-title' => '$1 - Revisão de Código',
	'code-comments' => 'Comentários',
	'code-references' => 'Revisões de seguimento',
	'code-change-status' => "alterou o '''estado''' da revisão $1",
	'code-change-tags' => "alterou as '''etiquetas''' da revisão $1",
	'code-change-removed' => 'removeu:',
	'code-change-added' => 'adicionou:',
	'code-old-status' => 'Estado antigo',
	'code-new-status' => 'Estado novo',
	'code-prop-changes' => 'Registo de estado e etiquetagem',
	'codereview-desc' => '[[Special:Code|Ferramenta de revisão de código]] com [[Special:RepoAdmin|suporte Subversion]]',
	'code-no-repo' => 'Não há nenhum repositório configurado!',
	'code-create-repo' => 'Visite o [[Special:RepoAdmin|suporte Subversion]] para criar um Repositório',
	'code-need-repoadmin-rights' => 'o privilégio repoadmin é necessário para ser capaz de criar um Repositório',
	'code-need-group-with-rights' => 'Não existe nenhum grupo com o privilégio repoadmin. Crie um para poder adicionar um novo Repositório, por favor.',
	'code-repo-not-found' => "O repositório '''$1''' não existe!",
	'code-load-diff' => 'A carregar diferenças…',
	'code-notes' => 'comentários recentes',
	'code-statuschanges' => 'alterações de estado',
	'code-mycommits' => 'as minhas efectivações',
	'code-mycomments' => 'os meus comentarios',
	'code-authors' => 'autores',
	'code-status' => 'estados',
	'code-tags' => 'etiquetas',
	'code-tags-no-tags' => 'Não existem etiquetas neste repositório.',
	'code-authors-text' => 'Abaixo encontra-se uma lista de autores do repositório, ordenados por nome de efectivação. Contas da wiki local são mostradas entre parênteses. Os dados podem provir da cache.',
	'code-author-haslink' => 'Este autor está associado ao utilizador wiki $1',
	'code-author-orphan' => 'O autor ou utilizador do SVN, $1, não está associado a nenhuma conta da wiki',
	'code-author-dolink' => 'Associar este autor a um utilizador wiki:',
	'code-author-alterlink' => 'Alterar o utilizador wiki associado a este autor:',
	'code-author-orunlink' => 'Ou desassociar este utilizador wiki:',
	'code-author-name' => 'Introduza um nome de utilizador:',
	'code-author-success' => 'O autor $1 foi associado ao utilizador wiki $2',
	'code-author-link' => 'associar?',
	'code-author-unlink' => 'desassociar?',
	'code-author-unlinksuccess' => 'O autor $1 foi desassociado',
	'code-author-badtoken' => 'Erro na sessão ao tentar executar a operação.',
	'code-author-total' => 'Número total de autores: $1',
	'code-author-lastcommit' => 'Última data de efectivação',
	'code-browsing-path' => "Visionando revisões em '''$1'''",
	'code-field-id' => 'Revisão',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentador',
	'code-field-message' => 'Resumo da efectivação',
	'code-field-status' => 'Estado',
	'code-field-status-description' => 'Descrição do estado',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Comentários',
	'code-field-path' => 'Caminho',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Seleccionar',
	'code-reference-remove' => 'Remover as associações seleccionadas',
	'code-reference-associate' => 'Associar à revisão de seguimento:',
	'code-reference-associate-submit' => 'Associar',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Comentário:',
	'code-rev-repo' => 'Repositório:',
	'code-rev-rev' => 'Revisão:',
	'code-rev-rev-viewvc' => 'no ViewVC',
	'code-rev-paths' => 'Caminhos modificados:',
	'code-rev-modified-a' => 'adicionado',
	'code-rev-modified-r' => 'substituído',
	'code-rev-modified-d' => 'eliminado',
	'code-rev-modified-m' => 'modificado',
	'code-rev-imagediff' => 'Alterações de imagem',
	'code-rev-status' => 'Estado:',
	'code-rev-status-set' => 'Alterar estado',
	'code-rev-tags' => 'Etiquetas:',
	'code-rev-tag-add' => 'Adicionar etiquetas:',
	'code-rev-tag-remove' => 'Remover etiquetas:',
	'code-rev-comment-by' => 'Comentário de $1',
	'code-rev-comment-preview' => 'Antevisão',
	'code-rev-inline-preview' => 'Antevisão:',
	'code-rev-diff' => 'Diferenças',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'As diferenças são demasiadas para apresentar.',
	'code-rev-purge-link' => 'purgar',
	'code-rev-total' => 'Número total de resultados: $1',
	'code-rev-not-found' => "A revisão '''$1''' não existe!",
	'code-rev-history-link' => 'Histórico',
	'code-status-new' => 'novo',
	'code-status-desc-new' => 'Esta revisão está pendente (estado padrão).',
	'code-status-fixme' => 'corrigir',
	'code-status-desc-fixme' => 'Esta revisão introduziu um defeito ou não funciona. Precisa de ser corrigida ou revertida.',
	'code-status-reverted' => 'revertido',
	'code-status-desc-reverted' => 'A revisão foi desfeita por outra revisão posterior.',
	'code-status-resolved' => 'resolvido',
	'code-status-desc-resolved' => 'A revisão tinha um problema que foi resolvido numa revisão posterior.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revisão completamente verificada e considerada completamente correcta.',
	'code-status-deferred' => 'diferido',
	'code-status-desc-deferred' => 'Revisão não necessita de ser verificada.',
	'code-status-old' => 'antigo',
	'code-status-desc-old' => 'Revisão antiga que pode conter defeitos, mas cuja verificação não se justifica.',
	'code-signoffs' => 'Aprovações',
	'code-signoff-legend' => 'Adicionar aprovação',
	'code-signoff-submit' => 'Aprovar',
	'code-signoff-strike' => 'Anular as aprovações seleccionadas',
	'code-signoff-signoff' => 'Aprovar esta revisão como:',
	'code-signoff-flag-inspected' => 'Inspeccionado',
	'code-signoff-flag-tested' => 'Testado',
	'code-signoff-field-user' => 'Utilizador',
	'code-signoff-field-flag' => 'Estado',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 (anulada a $2)',
	'code-pathsearch-legend' => 'Pesquisar revisões neste repositório por caminho',
	'code-pathsearch-path' => 'Caminho:',
	'code-pathsearch-filter' => 'Mostrar apenas:',
	'code-revfilter-cr_status' => 'Estado = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Etiqueta = $1',
	'code-revfilter-clear' => 'Remover filtro',
	'code-rev-submit' => 'Gravar alterações',
	'code-rev-submit-next' => 'Gravar e próximo por resolver',
	'code-rev-next' => 'Próximo por resolver',
	'code-batch-status' => 'Estado da modificação:',
	'code-batch-tags' => 'Etiquetas da modificação:',
	'codereview-batch-title' => 'Alterar todas as revisões seleccionadas',
	'codereview-batch-submit' => 'Enviar',
	'code-releasenotes' => 'Notas de lançamento',
	'code-release-legend' => 'Gerar notas de lançamento',
	'code-release-startrev' => 'Primeira rev:',
	'code-release-endrev' => 'Última rev:',
	'codereview-subtitle' => 'Para $1',
	'codereview-reply-link' => 'responder',
	'codereview-overview-title' => 'Resumo',
	'codereview-overview-desc' => 'Mostrar um resumo gráfico desta lista',
	'codereview-email-subj' => '[$1 $2]: Comentário adicionado',
	'codereview-email-body' => 'O utilizador "$1" colocou um comentário em $3.

URL completa: $2
Resumo da efectivação:

$5

Comentário:

$4',
	'codereview-email-subj2' => '[$1 $2]: Mudanças de seguimento',
	'codereview-email-body2' => 'O utilizador "$1" fez alterações de seguimento à revisão $2.

URL completa para a revisão de seguimento: $5
Resumo da efectivação:

$6

URL completa: $3
Resumo da efectivação:

$4',
	'codereview-email-subj3' => '[$1 $2]: Estado da revisão alterado',
	'codereview-email-body3' => 'O utilizador "$1" alterou o estado da revisão $2.

Estado Antigo: $3
Estado Novo: $4

URL Completa: $5
Resumo da efectivação:

$6',
	'codereview-email-subj4' => '[$1 $2]: Comentário adicionado e estado da revisão alterado',
	'codereview-email-body4' => 'O utilizador "$1" alterou o estado da revisão $2.

Estado Antigo: $3
Estado Novo: $4

O utilizador "$1" também colocou um comentário em $2.

URL completa: $5
Resumo da efectivação:

$7

Comentário:

$6',
	'code-stats' => 'estatísticas',
	'code-stats-header' => 'Estatísticas do repositório $1',
	'code-stats-main' => 'À data de $1, o repositório tinha $2 {{PLURAL:$2|revisão|revisões}} de [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autores}}]].',
	'code-stats-status-breakdown' => 'Número de revisões, por estado',
	'code-stats-fixme-breakdown' => 'Detalhe das revisões de correcção, por autor',
	'code-stats-new-breakdown' => 'Detalhe das novas revisões, por autor',
	'code-stats-count' => 'Número de revisões',
	'code-tooltip-withsummary' => 'r$1 [$2] por $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] por $3',
	'repoadmin' => 'Administração do Repositório',
	'repoadmin-new-legend' => 'Criar um repositório novo',
	'repoadmin-new-label' => 'Nome do repositório:',
	'repoadmin-new-button' => 'Criar',
	'repoadmin-edit-legend' => 'Modificação do repositório "$1"',
	'repoadmin-edit-path' => 'Caminho do repositório:',
	'repoadmin-edit-bug' => 'Caminho do Bugzilla:',
	'repoadmin-edit-view' => 'Caminho do ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'O repositório "[[Special:Code/$1|$1]]" foi modificado com sucesso.',
	'repoadmin-nav' => 'administração do repositório',
	'right-repoadmin' => 'Gerir repositórios de código',
	'right-codereview-use' => 'Uso de Especial:Code',
	'right-codereview-add-tag' => 'Adicionar novas etiquetas a revisões',
	'right-codereview-remove-tag' => 'Remover etiquetas de revisões',
	'right-codereview-post-comment' => 'Adicionar comentários a revisões',
	'right-codereview-set-status' => 'Alterar estado de revisões',
	'right-codereview-signoff' => 'Aprovação de revisões',
	'right-codereview-link-user' => 'Associar autores a utilizadores wiki',
	'right-codereview-associate' => 'Administrar a associação de revisões',
	'right-codereview-review-own' => 'Marcar as suas próprias revisões como OK ou Resolvido',
	'specialpages-group-developer' => 'Ferramentas de desenvolvimento',
	'group-svnadmins' => 'Administradores do SVN',
	'group-svnadmins-member' => 'Administrador do SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Administradores do SVN',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author 555
 * @author Eduardo.mps
 * @author Giro720
 * @author Helder.wiki
 * @author Heldergeovane
 * @author MetalBrasil
 */
$messages['pt-br'] = array(
	'code' => 'Revisão de Código',
	'code-rev-title' => '$1 - Revisão de Código',
	'code-comments' => 'Comentários',
	'code-references' => 'Revisões seguintes',
	'code-change-status' => "alterou o '''estado''' da revisão $1",
	'code-change-tags' => "alterou as '''etiquetas''' da revisão $1",
	'code-change-removed' => 'removido:',
	'code-change-added' => 'adicionado:',
	'code-old-status' => 'Estado anterior',
	'code-new-status' => 'Novo estado',
	'code-prop-changes' => "''Status'' e registro de etiquetagem",
	'codereview-desc' => '[[Special:Code|Ferramenta de revisão de código]] com [[Special:RepoAdmin|suporte à subversão]]',
	'code-no-repo' => 'Nenhum repositório configurado!',
	'code-create-repo' => 'Visite o [[Special:RepoAdmin|suporte Subversion]] para criar um Repositório',
	'code-need-repoadmin-rights' => 'o privilégio repoadmin é necessário para ser capaz de criar um Repositório',
	'code-need-group-with-rights' => 'Não existe nenhum grupo com o privilégio repoadmin. Crie um para poder adicionar um novo Repositório, por favor.',
	'code-repo-not-found' => "O repositório '''$1''' não existe!",
	'code-load-diff' => 'Carregando diferenças…',
	'code-notes' => 'comentários recentes',
	'code-statuschanges' => 'mudanças de estado',
	'code-mycommits' => 'minhas efetivações',
	'code-mycomments' => 'meus comentários',
	'code-authors' => 'autores',
	'code-status' => 'estados',
	'code-tags' => 'etiquetas',
	'code-tags-no-tags' => 'Nenhuma etiqueta existente neste repositório.',
	'code-authors-text' => 'Abaixo encontra-se uma lista de autores do repositório, ordenados por nome de efetivação. Contas da wiki local são mostradas entre parênteses. Os dados podem provir da cache.',
	'code-author-haslink' => 'Este autor está ligado ao usuário wiki $1',
	'code-author-orphan' => 'O autor/utilizador do SVN, $1, não está associado a nenhuma conta da wiki',
	'code-author-dolink' => 'Ligar este autor a um usuário wiki:',
	'code-author-alterlink' => 'Alterar o usuário wiki ligado a este autor:',
	'code-author-orunlink' => 'Ou desligar este usuário wiki:',
	'code-author-name' => 'Introduza um nome de usuário',
	'code-author-success' => 'O autor $1 foi ligado ao usuário wiki $2',
	'code-author-link' => 'ligar?',
	'code-author-unlink' => 'desligar?',
	'code-author-unlinksuccess' => 'O autor $1 foi desligado',
	'code-author-badtoken' => 'Erro na sessão ao tentar executar a operação.',
	'code-author-total' => 'Número total de autores: $1',
	'code-author-lastcommit' => 'Última data de efetivação',
	'code-browsing-path' => "Navegando pelas revisões em '''$1'''",
	'code-field-id' => 'Revisão',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentário de',
	'code-field-message' => 'Resumo de tarefas',
	'code-field-status' => 'Estado',
	'code-field-status-description' => 'Descrição do estado',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Comentários',
	'code-field-path' => 'Caminho',
	'code-field-text' => 'Nota',
	'code-field-select' => 'Selecionar',
	'code-reference-remove' => 'Remover as associações selecionadas',
	'code-reference-associate' => 'Associar à revisão de seguimento:',
	'code-reference-associate-submit' => 'Associar',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Comentário:',
	'code-rev-repo' => 'Repositório:',
	'code-rev-rev' => 'Revisão:',
	'code-rev-rev-viewvc' => 'no ViewVC',
	'code-rev-paths' => 'Caminhos modificados:',
	'code-rev-modified-a' => 'adicionado',
	'code-rev-modified-r' => 'substituído',
	'code-rev-modified-d' => 'eliminado',
	'code-rev-modified-m' => 'modificado',
	'code-rev-imagediff' => 'Alterações de imagem',
	'code-rev-status' => 'Estado:',
	'code-rev-status-set' => 'Alterar estado',
	'code-rev-tags' => 'Etiquetas:',
	'code-rev-tag-add' => 'Adicionar etiquetas:',
	'code-rev-tag-remove' => 'Remover etiquetas:',
	'code-rev-comment-by' => 'Comentário de $1',
	'code-rev-comment-preview' => 'Pré-visualização',
	'code-rev-inline-preview' => 'Pré-visualização:',
	'code-rev-diff' => 'Diferenças',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'O diff é demasiadamente grande para ser apresentado.',
	'code-rev-purge-link' => 'purgar',
	'code-rev-total' => 'Número total de resultados: $1',
	'code-rev-not-found' => "A revisão '''$1''' não existe!",
	'code-rev-history-link' => 'Histórico',
	'code-status-new' => 'novo',
	'code-status-desc-new' => 'Esta revisão está pendente (estado padrão).',
	'code-status-fixme' => 'corrigir',
	'code-status-desc-fixme' => 'Esta revisão introduziu um defeito ou não funciona. É necessária uma correção ou reversão.',
	'code-status-reverted' => 'revertido',
	'code-status-desc-reverted' => 'A revisão foi descartada por outra revisão posterior.',
	'code-status-resolved' => 'resolvido',
	'code-status-desc-resolved' => 'A revisão tinha um problema que foi resolvido numa revisão posterior.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'A revisão foi completamente verificada e considerada completamente correta.',
	'code-status-deferred' => 'deferido',
	'code-status-desc-deferred' => 'A revisão não necessita ser verificada.',
	'code-status-old' => 'antigo',
	'code-status-desc-old' => 'A revisão antiga que pode conter defeitos, mas cuja verificação não se justifica.',
	'code-signoffs' => 'Aprovações',
	'code-signoff-legend' => 'Adicionar aprovação',
	'code-signoff-submit' => 'Aprovar',
	'code-signoff-strike' => 'Anular as aprovações selecionadas',
	'code-signoff-signoff' => 'Aprovar esta revisão como:',
	'code-signoff-flag-inspected' => 'Inspecionado',
	'code-signoff-flag-tested' => 'Testado',
	'code-signoff-field-user' => 'Usuário',
	'code-signoff-field-flag' => 'Bandeira',
	'code-signoff-field-date' => 'Data',
	'code-signoff-struckdate' => '$1 (anulada a $2)',
	'code-pathsearch-legend' => 'Pesquisar revisões neste repositório por caminho',
	'code-pathsearch-path' => 'Caminho:',
	'code-pathsearch-filter' => 'Mostrar somente:',
	'code-revfilter-cr_status' => 'Estado = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Etiqueta = $1',
	'code-revfilter-clear' => 'Remover filtro',
	'code-rev-submit' => 'Salvar alterações',
	'code-rev-submit-next' => 'Gravar & próximo por resolver',
	'code-rev-next' => 'Próximo de resolução pendente',
	'code-batch-status' => 'Estado da modificação:',
	'code-batch-tags' => 'Etiquetas da modificação:',
	'codereview-batch-title' => 'Alterar todas as revisões selecionadas',
	'codereview-batch-submit' => 'Enviar',
	'code-releasenotes' => 'Notas de lançamento',
	'code-release-legend' => 'Gerar notas de lançamento',
	'code-release-startrev' => 'Primeira rev:',
	'code-release-endrev' => 'Última rev:',
	'codereview-subtitle' => 'Para $1',
	'codereview-reply-link' => 'responder',
	'codereview-overview-title' => 'Vista geral',
	'codereview-overview-desc' => 'Mostrar um resumo em gráfico desta lista',
	'codereview-email-subj' => '[$1 $2]: Novo comentário adicionado',
	'codereview-email-body' => 'O usuário "$1" postou um comentário em $3.

URL completa: $2
Resumo de envio:

$5

Comentário:

$4',
	'codereview-email-subj2' => '[$1 $2]: Mudanças seguintes',
	'codereview-email-body2' => 'O usuário "$1" fez alterações de seguimento à revisão $2.

URL completa para a revisão de seguimento: $5
Resumo da efetivação:

$6

URL completa: $3
Resumo da efetivação:

$4',
	'codereview-email-subj3' => '[$1 $2]: Alterado o estada da revisão',
	'codereview-email-body3' => 'O usuário "$1" alterou o estado da revisão $2.

Estado Antigo: $3
Estado Novo: $4

URL Completa: $5
Resumo da efetivação:

$6',
	'codereview-email-subj4' => '[$1 $2]: Adicionado novo comentário e alterado o estado da revisão',
	'codereview-email-body4' => 'O usuário "$1" alterou o estado da revisão $2.

Estado Antigo: $3
Estado Novo: $4

O usuário "$1" também colocou um comentário em $2.

URL completa: $5
Resumo da efetivação:

$7

Comentário:

$6',
	'code-stats' => 'estatísticas',
	'code-stats-header' => 'Estatísticas do repositório $1',
	'code-stats-main' => 'À data de $1, o repositório tinha $2 {{PLURAL:$2|revisão|revisões}} de [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autores}}]].',
	'code-stats-status-breakdown' => 'Número de revisões por estado',
	'code-stats-fixme-breakdown' => 'Detalhe das revisões de correcção, por autor',
	'code-stats-new-breakdown' => 'Detalhe de revisões novas, por autor',
	'code-stats-count' => 'Número de revisões',
	'code-tooltip-withsummary' => 'r$1 [$2] por $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] por $3',
	'repoadmin' => 'Administração de Repositório',
	'repoadmin-new-legend' => 'Criar um novo repositório',
	'repoadmin-new-label' => 'Nome do repositório:',
	'repoadmin-new-button' => 'Criar',
	'repoadmin-edit-legend' => 'Modificação do repositório "$1"',
	'repoadmin-edit-path' => 'Caminho do repositório:',
	'repoadmin-edit-bug' => 'Caminho do Bugzilla:',
	'repoadmin-edit-view' => 'Caminho do ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'O repositório "[[Special:Code/$1|$1]]" foi modificado com sucesso.',
	'repoadmin-nav' => 'administração do repositório',
	'right-repoadmin' => 'Gerenciar repositórios de código',
	'right-codereview-use' => 'Uso de Special:Code',
	'right-codereview-add-tag' => 'Adicionar novas etiquetas a revisões',
	'right-codereview-remove-tag' => 'Remover etiquetas de revisões',
	'right-codereview-post-comment' => 'Adicionar comentários a revisões',
	'right-codereview-set-status' => 'Alterar estado de revisões',
	'right-codereview-signoff' => 'Aprovação de revisões',
	'right-codereview-link-user' => 'Associar autores a utilizadores de wiki',
	'right-codereview-associate' => 'Administrar a associação de revisões',
	'right-codereview-review-own' => 'Marcar suas próprias revisões como OK ou Resolvido',
	'specialpages-group-developer' => 'Ferramentas de desenvolvimento',
	'group-svnadmins' => 'Administradores do SVN',
	'group-svnadmins-member' => 'Administrador do SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Administradores do SVN',
);

/** Romanian (Română)
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Mihai
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'code' => 'Revizualizare cod',
	'code-rev-title' => '$1 - Revizualizare cod',
	'code-comments' => 'Comentarii',
	'code-references' => 'Revizii în continuare',
	'code-change-status' => "schimbat '''statutul''' a $1",
	'code-change-tags' => "schimbat '''etichetele''' pentru $1",
	'code-change-removed' => 'șters:',
	'code-change-added' => 'adăugat:',
	'code-old-status' => 'Statut vechi',
	'code-new-status' => 'Statut nou',
	'code-prop-changes' => 'Jurnalul statusului și al etichetelor',
	'codereview-desc' => '[[Special:Code|Instrument pentru revizuirea codului]] cu [[Special:RepoAdmin|suport de Subversion]]',
	'code-no-repo' => 'Niciun depozit configurat!',
	'code-create-repo' => 'Mergeți la [[Special:RepoAdmin|suportul de Subversion]] pentru a crea un depozit',
	'code-need-repoadmin-rights' => 'drepturile „repoadmin” sunt necesare pentru a crea un depozit',
	'code-need-group-with-rights' => 'Niciun grup cu drepturi „repoadmin” nu există. Adăugați unul pentru a crea un nou depozit',
	'code-repo-not-found' => "Depozitul '''$1''' nu există!",
	'code-load-diff' => 'Încărcare diff...',
	'code-notes' => 'comentarii recente',
	'code-statuschanges' => 'schimbări de statut',
	'code-mycommits' => 'publicările mele',
	'code-mycomments' => 'comentariile mele',
	'code-authors' => 'autori',
	'code-status' => 'statistici',
	'code-tags' => 'etichete',
	'code-tags-no-tags' => 'Nicio etichetă nu există în acest depozit.',
	'code-authors-text' => 'Mai jos este o listă de autori de depozite ordonată după nume. Conturile wiki locale sunt afișate între paranteze. Datele ar putea proveni din memoria cache.',
	'code-author-haslink' => 'Acest autor este legat de contul wiki $1',
	'code-author-orphan' => 'Utilizatorul SVN/Autorul $1 nu are nicio legătură către un cont wiki',
	'code-author-dolink' => 'Asociază acest autor unui cont wiki:',
	'code-author-alterlink' => 'Schimbă contul wiki de care este legat acest autor:',
	'code-author-orunlink' => 'Sau dezlegați acest utilizator:',
	'code-author-name' => 'Introduceți un nume de utilizator:',
	'code-author-success' => 'Autorul $1 a fost legat la utilizatorul $2',
	'code-author-link' => 'legare?',
	'code-author-unlink' => 'dezlegare?',
	'code-author-unlinksuccess' => 'Autorul $1 a fost dezlegat',
	'code-author-badtoken' => 'Eroare de sesiune în timpul execuției acțiunii.',
	'code-author-total' => 'Număr total de autori: $1',
	'code-author-lastcommit' => 'Data ultimei publicări',
	'code-browsing-path' => "Răsfoind reviziile în '''$1'''",
	'code-field-id' => 'Revizie',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentator',
	'code-field-message' => 'Rezumatul publicării',
	'code-field-status' => 'Statut',
	'code-field-status-description' => 'Descrierea stării',
	'code-field-timestamp' => 'Dată',
	'code-field-comments' => 'Comentarii',
	'code-field-path' => 'Cale',
	'code-field-text' => 'Notă',
	'code-field-select' => 'Alege',
	'code-reference-remove' => 'Elimină asocierile selectate',
	'code-reference-associate' => 'Asociați revizia următoare:',
	'code-reference-associate-submit' => 'Asociază',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Dată:',
	'code-rev-message' => 'Comentariu:',
	'code-rev-repo' => 'Arhivă:',
	'code-rev-rev' => 'revizie',
	'code-rev-rev-viewvc' => 'pe ViewVC',
	'code-rev-paths' => 'Căi modificate:',
	'code-rev-modified-a' => 'adăugat',
	'code-rev-modified-r' => 'înlocuit',
	'code-rev-modified-d' => 'șters',
	'code-rev-modified-m' => 'modificat',
	'code-rev-imagediff' => 'Schimbări imagine',
	'code-rev-status' => 'Statut:',
	'code-rev-status-set' => 'Schimbă statut',
	'code-rev-tags' => 'Etichete:',
	'code-rev-tag-add' => 'Adaugă etichete:',
	'code-rev-tag-remove' => 'Elimină etichetele:',
	'code-rev-comment-by' => 'Comentariu de $1',
	'code-rev-comment-preview' => 'Previzualizare',
	'code-rev-inline-preview' => 'Previzualizare:',
	'code-rev-diff' => 'Diferență',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'Diff-ul este prea mare pentru a fi afișat.',
	'code-rev-purge-link' => 'curăță',
	'code-rev-total' => 'Număr total de rezultate: $1',
	'code-rev-not-found' => "Revizia '''$1''' nu există!",
	'code-rev-history-link' => 'istoric',
	'code-status-new' => 'nou',
	'code-status-desc-new' => 'Revizia este în așteptarea unei acțiuni (stare implicită).',
	'code-status-fixme' => 'repară-mă',
	'code-status-desc-fixme' => 'Revizia a introdus un bug sau este eronată. Ar trebui să fie remediată sau anulată.',
	'code-status-reverted' => 'revenit',
	'code-status-desc-reverted' => 'Revizia a fost anulată printr-o revizie ulterioară.',
	'code-status-resolved' => 'rezolvat',
	'code-status-desc-resolved' => 'Revizia a avut o problemă care a fost corectată de o revizie ulterioară.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revizie complet revizuită și recenzentul este sigur că este bună în orice fel.',
	'code-status-deferred' => 'amânat',
	'code-status-desc-deferred' => 'Revizia nu necesită revizuire.',
	'code-status-old' => 'vechi',
	'code-status-desc-old' => 'Revizie veche cu potențiale defecțiuni dar care nu merită efortul de a fi revizuită.',
	'code-signoffs' => 'Aprobă',
	'code-signoff-legend' => 'Adaugă aprobare',
	'code-signoff-submit' => 'Aprobă',
	'code-signoff-strike' => 'Anulează aprobările selectate',
	'code-signoff-signoff' => 'Aprobă această revizie ca:',
	'code-signoff-flag-inspected' => 'Inspectat',
	'code-signoff-flag-tested' => 'Testat',
	'code-signoff-field-user' => 'Utilizator',
	'code-signoff-field-flag' => 'Tip',
	'code-signoff-field-date' => 'Dată',
	'code-signoff-struckdate' => '$1 (ștearsă pe $2)',
	'code-pathsearch-legend' => 'Caută revizii în acest depozit după cale',
	'code-pathsearch-path' => 'Cale:',
	'code-pathsearch-filter' => 'Arată doar:',
	'code-revfilter-cr_status' => 'Stare = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-ct_tag' => 'Etichetă = $1',
	'code-revfilter-clear' => 'Curăță filtru',
	'code-rev-submit' => 'Salvează schimbări',
	'code-rev-submit-next' => 'Salvaţi & următoare nerezolvată',
	'code-rev-next' => 'Următoarea în așteptare',
	'code-batch-status' => 'Schimbă statut:',
	'code-batch-tags' => 'Schimbă etichete:',
	'codereview-batch-title' => 'Schimbați toate reviziile selectate',
	'codereview-batch-submit' => 'Trimite',
	'code-releasenotes' => 'note de lansare',
	'code-release-legend' => 'Generați note de lansare',
	'code-release-startrev' => 'Revizuirea de început:',
	'code-release-endrev' => 'Ultima rev:',
	'codereview-subtitle' => 'De la $1',
	'codereview-reply-link' => 'răspunde',
	'codereview-overview-title' => 'Vedere de ansamblu',
	'codereview-overview-desc' => 'Afișează o vedere de ansamblu grafică a acestei liste',
	'codereview-email-subj' => '[$1 $2]: Comentariu nou adăugat',
	'codereview-email-body' => 'Utilizatorul „$1” a adăugat un comentariu la $3.

URL complet: $2

Rezumatul modificării:

$5

Comentariu:

$4',
	'codereview-email-subj2' => '[$1 $2]: Urmărirea modificărilor',
	'codereview-email-body2' => 'Utilizatorul „$1” a urmărit modificările la $2.

URL complet pentru reviziile urmărite: $5
Rezumatul modificării:

$6

URL complet: $3

Rezumatul modificării:

$4',
	'codereview-email-subj3' => '[$1 $2]: Starea reviziei a fost schimbată',
	'codereview-email-body3' => 'Utilizatorul „$1” a schimbat starea reviziei $2.

Stare veche: $3
Stare nouă: $4

URL complet: $5
Descrierea modificării:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nou comentariu adăugat și starea reviziei schimbată',
	'codereview-email-body4' => 'Utilizatorul „$1” a schimbat starea reviziei $2.

Stare veche: $3
Stare nouă: $4

Utilizatorul „$1” a postat și un comentariu pentru $2.

URL complet: $5
Descrierea modificării:

$7

Comentariu:

$6',
	'code-stats' => 'statistici',
	'code-stats-header' => 'Statistici pentru depozit $1',
	'code-stats-main' => 'Pe $1, depozitul are $2 {{PLURAL:$2|revizie|revizii}} de către [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autori}}]].',
	'code-stats-status-breakdown' => 'Numărul de revizii pentru fiecare stat',
	'code-stats-fixme-breakdown' => 'Defalcarea reviziilor de corectat per autor',
	'code-stats-new-breakdown' => 'Defalcarea reviziilor noi per autor',
	'code-stats-count' => 'Numărul de revizii',
	'code-tooltip-withsummary' => 'r$1 [$2] de către $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] de către $3',
	'repoadmin' => 'Administrație arhivă',
	'repoadmin-new-legend' => 'Creează un nou depozit',
	'repoadmin-new-label' => 'Nume arhivă:',
	'repoadmin-new-button' => 'Creează',
	'repoadmin-edit-legend' => 'Modificarea depozitului "$1"',
	'repoadmin-edit-path' => 'Cale arhivă:',
	'repoadmin-edit-bug' => 'Cale Bugzilla:',
	'repoadmin-edit-view' => 'Cale ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Arhiva „[[Special:Code/$1|$1]]” a fost modificată cu succes.',
	'repoadmin-nav' => 'administrarea depozitului',
	'right-repoadmin' => 'Gestionați codurile arhivelor',
	'right-codereview-use' => 'Utilizarea Special:Code',
	'right-codereview-add-tag' => 'Adaugă noi etichete la revizii',
	'right-codereview-remove-tag' => 'Eliminați etichete de la revizii',
	'right-codereview-post-comment' => 'Adăugați comentarii la revizii',
	'right-codereview-set-status' => 'Schimbă statutul reviziilor',
	'right-codereview-signoff' => 'Aprobă aceste revizii',
	'right-codereview-link-user' => 'Leagă autori de utilizatori wiki',
	'right-codereview-associate' => 'Gestionează asocierile reviziilor',
	'right-codereview-review-own' => 'Marchează propria revizie ca „{{int:code-status-ok}}” sau „{{int:code-status-resolved}}”',
	'specialpages-group-developer' => 'Unelte pentru dezvolatori',
	'group-svnadmins' => 'Administratori SVN',
	'group-svnadmins-member' => '{{GENDER:$1|administrator SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Administratori SVN',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 * @author Reder
 */
$messages['roa-tara'] = array(
	'code' => 'Revisore de Codece',
	'code-rev-title' => '$1 - Revisore de Codece',
	'code-comments' => 'Commende',
	'code-references' => 'Revisiune supplemendare',
	'code-change-status' => "cangiate 'u '''state''' de $1",
	'code-change-tags' => "cangiate le '''tag''' de $1",
	'code-change-removed' => 'luete:',
	'code-change-added' => 'aggiunde:',
	'code-old-status' => 'State vecchije',
	'code-new-status' => 'State nuève',
	'code-prop-changes' => 'State & trasùte condrassignate',
	'codereview-desc' => "[[Special:Code|Strumènde de revisione d'u codece]] cu [[Special:RepoAdmin|Supporte sovversione]]",
	'code-no-repo' => 'Nisciune deposite configurate!',
	'code-repo-not-found' => "'U deposite '''$1''' non ge esiste!",
	'code-load-diff' => 'Stoche a careche le differenze...',
	'code-notes' => 'commende recende',
	'code-statuschanges' => 'cangiaminde de le state',
	'code-mycommits' => 'reggistraziune mie',
	'code-mycomments' => 'commende mije',
	'code-authors' => 'le autore',
	'code-status' => 'state',
	'code-tags' => 'le tag',
	'code-tags-no-tags' => "Nisciune tag esiste jndr'à st'archivije.",
	'code-author-haslink' => "Quiste autore jè cullegate a l'utinde uicchi $1",
	'code-author-orphan' => "L' autore/utente de SVN $1 non ge tène nisciune collegamende cu 'nu cunde uicchi",
	'code-author-dolink' => "Colleghe st'autore a 'n'utende de Uicchi:",
	'code-author-alterlink' => "Cange l'utende de Uicchi collegate a st'autore:",
	'code-author-orunlink' => 'O scolleghe stu utende de Uicchi:',
	'code-author-name' => "Mitte 'nu nome utende:",
	'code-author-success' => "L'autore $1 jè state cullegate a l'utinde uicchi $2",
	'code-author-link' => 'colleghete?',
	'code-author-unlink' => 'scolleghete?',
	'code-author-unlinksuccess' => 'Autore $1 ha state scollegate',
	'code-author-badtoken' => "Errore de sessione cercanne de combiere l'aziune.",
	'code-author-total' => 'Numere totale de le autore: $1',
	'code-author-lastcommit' => 'Urtema date de commit',
	'code-browsing-path' => "Sfoglie le revisiune jndr'à '''$1'''",
	'code-field-id' => 'Revisione',
	'code-field-author' => 'Autore',
	'code-field-user' => 'Commendatore',
	'code-field-message' => 'Reggistre riepileghe',
	'code-field-status' => 'State',
	'code-field-status-description' => "Descrizione d'u state",
	'code-field-timestamp' => 'Date',
	'code-field-comments' => 'Commende',
	'code-field-path' => 'Percorse',
	'code-field-text' => 'Note',
	'code-field-select' => 'Scacchie',
	'code-reference-remove' => 'Live le associaziune scacchiate',
	'code-reference-associate-submit' => 'Associate',
	'code-rev-author' => 'Autore:',
	'code-rev-date' => 'Date:',
	'code-rev-message' => 'Commende:',
	'code-rev-repo' => 'Archivije:',
	'code-rev-rev' => 'Revisione:',
	'code-rev-rev-viewvc' => 'sus a ViewVC',
	'code-rev-paths' => 'Percorse modifichete:',
	'code-rev-modified-a' => 'aggiunde',
	'code-rev-modified-r' => 'sostituite',
	'code-rev-modified-d' => 'scangillete',
	'code-rev-modified-m' => 'cangete',
	'code-rev-imagediff' => 'Cangiaminde de le immaggene',
	'code-rev-status' => 'State:',
	'code-rev-status-set' => "Cange 'u state",
	'code-rev-tags' => 'Tag:',
	'code-rev-tag-add' => 'Aggiunge le tag:',
	'code-rev-tag-remove' => 'Scangille le tag:',
	'code-rev-comment-by' => 'Commende de $1',
	'code-rev-comment-preview' => 'Andeprime',
	'code-rev-inline-preview' => 'Andeprime:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => "'A diff jè larghe assaje pè 'a visualizzazione.",
	'code-rev-purge-link' => 'sdevache',
	'code-rev-total' => 'Numere totale de le resultate: $1',
	'code-rev-not-found' => "'A revisione '''$1''' non ge esiste!",
	'code-rev-history-link' => 'cunde',
	'code-status-new' => 'nueve',
	'code-status-fixme' => 'aggiusteme',
	'code-status-reverted' => 'annullate',
	'code-status-desc-reverted' => "'A revisione jè state scettáte da n'otre revisione cchù nuève.",
	'code-status-resolved' => 'resolte',
	'code-status-desc-resolved' => "'A revisione hagghie avute 'nu probbleme ce jè state resolte da 'na revisione cchiù nuève.",
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => "Revisione revisionate combletamende e 'u recensore jè secure ca jèdde vèje bbuène jndre ogne mode.",
	'code-status-deferred' => 'differite',
	'code-status-desc-deferred' => "Le revisiune non g'onne abbesogne de 'na revisite.",
	'code-status-old' => 'vecchie',
	'code-signoffs' => 'Smarche',
	'code-signoff-legend' => "Aggiunge 'nu smarcamende",
	'code-signoff-submit' => 'Smarche',
	'code-signoff-strike' => 'Sbarre le smarcaminde scacchiate',
	'code-signoff-signoff' => "Live 'a firme da sta revisione cumme:",
	'code-signoff-flag-inspected' => 'Ispezionate',
	'code-signoff-flag-tested' => 'Testate',
	'code-signoff-field-user' => 'Utende',
	'code-signoff-field-flag' => 'Bandiere',
	'code-signoff-field-date' => 'Date',
	'code-signoff-struckdate' => '$1 (colpite $2)',
	'code-pathsearch-legend' => "Cirche le revisiune jndrìà st'archivije pe percorse",
	'code-pathsearch-path' => 'Percorse:',
	'code-pathsearch-filter' => 'Fa vedè sulamende::',
	'code-revfilter-cr_status' => 'State = $1',
	'code-revfilter-cr_author' => 'Autore = $1',
	'code-revfilter-ct_tag' => 'Tag = $1',
	'code-revfilter-clear' => "Pulizze 'u filtre",
	'code-rev-submit' => 'Reggistre le cangiaminde',
	'code-rev-submit-next' => 'Salve & prossime irresolte',
	'code-rev-next' => 'Prosseme irrisolte',
	'code-batch-status' => "Cange 'u state:",
	'code-batch-tags' => 'Cange le tag:',
	'codereview-batch-title' => 'Cange totte le revisione selezionate',
	'codereview-batch-submit' => 'Conferme',
	'code-releasenotes' => 'Note de relasse',
	'code-release-legend' => 'Crijà note de relasse',
	'code-release-startrev' => 'Prime rev:',
	'code-release-endrev' => 'Urteme rev:',
	'codereview-subtitle' => 'Pe $1',
	'codereview-reply-link' => 'respunne',
	'codereview-overview-title' => 'Panorameche',
	'codereview-overview-desc' => "Fà vedè 'na panorameca grafeche de st'elenghe",
	'codereview-email-subj' => '[$1 $2]: Nuève commende aggiunde',
	'codereview-email-body' => 'L\'utende "$1" ha postate \'nu commende sus a $3.

\'A URL comblete jè: $2
Riepileghe d\'u sarvamende:

$5

Commende:

$4',
	'codereview-email-subj2' => '[$1 $2]: Revisiune supplemendare',
	'codereview-email-body2' => 'L\'utende "$1" ha fatte le seguende cangiaminde a $2.

\'A URL comblete pe seguì \'a revisione jè: $5
Riepileghe d\'u sarvamende:

$6

\'A URL comblete jè: $3
Riepileghe d\'u sarvamende:

$4',
	'codereview-email-subj3' => "[$1 $2]: State d'a revisione cangiate",
	'codereview-email-body3' => 'L\'utende "$1" hacangiate \'u state de $2.

State vecchie: $3
State nuève: $4

\'A URL comblete jè: $5
Riepileghe d\'u sarvamende:

$6',
	'codereview-email-subj4' => "[$1 $2]: Commende nuève aggiunde e state d'a revisione cangiate",
	'codereview-email-body4' => 'L\'utende "$1" hacangiate \'u state de $2.

State vecchie: $3
State nuève: $4

L\'utende "$1" ave pure postate \'nu commende sus a $2.

\'A URL comblete jè: $5
Riepileghe d\'u sarvamende:

$7

Commende:

$6',
	'code-stats' => 'statisteche',
	'code-stats-header' => "Statisteche pe l'archivije $1",
	'code-stats-status-breakdown' => 'Numere de revisione pè state',
	'code-stats-fixme-path' => 'Corregge revisiune pu percorse: $1',
	'code-stats-count' => 'Numere de le revisiune',
	'code-tooltip-withsummary' => 'r$1 [$2] da $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] da $3',
	'repoadmin' => "Amministrazione de l'Archivije",
	'repoadmin-new-legend' => "Ccreje 'n'archivije nuève",
	'repoadmin-new-label' => "Nome de l'archivije:",
	'repoadmin-new-button' => 'Ccreje',
	'repoadmin-edit-legend' => 'Cangiamende de l\'archivije "$1"',
	'repoadmin-edit-path' => "Percorse de l'archivije:",
	'repoadmin-edit-bug' => 'Percorse de Bugzilla:',
	'repoadmin-edit-view' => "Percorse d'u ViewVC:",
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'L\'archivije "[[Special:Code/$1|$1]]" ha state cangiate cu successe.',
	'repoadmin-nav' => "amministrazione de l'archivije",
	'right-repoadmin' => "Gestisce le codece de l'archivije",
	'right-codereview-use' => 'Ause de speciale:Codece',
	'right-codereview-add-tag' => 'Aggiunge nuève etichette pè le revsione',
	'right-codereview-remove-tag' => 'Luà le etichette da le revisione',
	'right-codereview-post-comment' => "Aggiunge commende sus 'a revisione",
	'right-codereview-set-status' => "Cange 'u state d'a revisione",
	'right-codereview-signoff' => 'Smarche sus le revisiune',
	'right-codereview-link-user' => 'Culleghe le autore a le utinde uicchi',
	'right-codereview-associate' => "Gestisce le associaziune 'mbrà revisiune",
	'right-codereview-review-own' => 'Marche le revisiune tune cumme OK o Resolte',
	'specialpages-group-developer' => 'Struminde pe le sviluppature',
	'group-svnadmins' => 'Amministrature de SVN',
	'group-svnadmins-member' => '{{GENDER:$1|amministratore de SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Amministrature de SVN',
);

/** Russian (Русский)
 * @author Dim Grits
 * @author Eleferen
 * @author Engineering
 * @author Eugrus
 * @author Ferrer
 * @author JenVan
 * @author Kaganer
 * @author Lockal
 * @author MaxSem
 * @author McDutchie
 * @author Putnik
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'code' => 'Рецензирование кода',
	'code-rev-title' => '$1 — рецензирование кода',
	'code-comments' => 'Комментарии',
	'code-references' => 'Последующие ревизии',
	'code-change-status' => "изменил '''состояние''' r$1",
	'code-change-tags' => "изменил '''метки''' для r$1",
	'code-change-removed' => 'удалено:',
	'code-change-added' => 'добавлено:',
	'code-old-status' => 'Старый статус',
	'code-new-status' => 'Новый статус',
	'code-prop-changes' => 'Журнал статусов и меток',
	'codereview-desc' => '[[Special:Code|Инструмент рецензирования кода]] с [[Special:RepoAdmin|поддержкой Subversion]]',
	'code-no-repo' => 'Отсутствует настроенное хранилище!',
	'code-create-repo' => 'Перейдите в [[Special:RepoAdmin|RepoAdmin]] для создания хранилища',
	'code-need-repoadmin-rights' => 'для создание хранилища необходимы права repoadmin',
	'code-need-group-with-rights' => 'Не существует группы с правами repoadmin. Пожалуйста, создайте такую для добавления нового хранилища',
	'code-repo-not-found' => "Хранилища '''$1''' не существует!",
	'code-load-diff' => 'Загрузка сравнения…',
	'code-notes' => 'последние замечания',
	'code-statuschanges' => 'изменения статуса',
	'code-mycommits' => 'мои коммиты',
	'code-mycomments' => 'мои комментарии',
	'code-authors' => 'авторы',
	'code-status' => 'состояния',
	'code-tags' => 'метки',
	'code-tags-no-tags' => 'В этом хранилище нет меток.',
	'code-authors-text' => 'Ниже приведён список авторов хранилища, упорядоченный по именам. Учётные записи локальной вики показаны в скобках. Эти данные, возможно, кэшированы.',
	'code-author-haslink' => 'Этот автор ассоциирован с участником $1',
	'code-author-orphan' => 'SVN-пользователь/автор $1 не связан с учётной записью в вики',
	'code-author-dolink' => 'Установить для этого автора связь с участником:',
	'code-author-alterlink' => 'Сменить учётную запись, ассоциированную с этим автором:',
	'code-author-orunlink' => 'или просто удалить связь с участником:',
	'code-author-name' => 'Введите имя:',
	'code-author-success' => 'Автор $1 успешно ассоциирован с участником $2',
	'code-author-link' => 'установить связь?',
	'code-author-unlink' => 'разорвать связь?',
	'code-author-unlinksuccess' => 'Для автора $1 удалена связь с учётной записью',
	'code-author-badtoken' => 'Ошибка сеанса при попытке выполнить действие.',
	'code-author-total' => 'Всего авторов: $1',
	'code-author-lastcommit' => 'Дата последнего коммита',
	'code-browsing-path' => "Просмотр ревизий в '''$1'''",
	'code-field-id' => 'Ревизия',
	'code-field-author' => 'Автор',
	'code-field-user' => 'Комментатор',
	'code-field-message' => 'Описание изменений',
	'code-field-status' => 'Статус',
	'code-field-status-description' => 'Описание статуса',
	'code-field-timestamp' => 'Дата',
	'code-field-comments' => 'Комментарии',
	'code-field-path' => 'Путь',
	'code-field-text' => 'Замечание',
	'code-field-select' => 'Выбрать',
	'code-reference-remove' => 'Удалить выбранные привязки',
	'code-reference-associate' => 'Привязать последующую ревизию:',
	'code-reference-associate-submit' => 'Привязать',
	'code-rev-author' => 'Автор:',
	'code-rev-date' => 'Дата:',
	'code-rev-message' => 'Описание изменений:',
	'code-rev-repo' => 'Хранилище:',
	'code-rev-rev' => 'Ревизия:',
	'code-rev-rev-viewvc' => 'через ViewVC',
	'code-rev-paths' => 'Ссылки на изменения:',
	'code-rev-modified-a' => 'добавлено',
	'code-rev-modified-r' => 'заменено',
	'code-rev-modified-d' => 'удалено',
	'code-rev-modified-m' => 'изменено',
	'code-rev-imagediff' => 'Изменения в изображении',
	'code-rev-status' => 'Статус:',
	'code-rev-status-set' => 'Сменить статус',
	'code-rev-tags' => 'Метки:',
	'code-rev-tag-add' => 'Добавить метки:',
	'code-rev-tag-remove' => 'Удалить метки:',
	'code-rev-comment-by' => 'Комментарий от $1',
	'code-rev-comment-preview' => 'Предпросмотр',
	'code-rev-inline-preview' => 'Предпросмотр:',
	'code-rev-diff' => 'Изменение',
	'code-rev-diff-link' => 'изм.',
	'code-rev-diff-too-large' => 'Разница версий слишком велика для отображения.',
	'code-rev-purge-link' => 'очистить кеш',
	'code-rev-total' => 'Общее количество результатов: $1',
	'code-rev-not-found' => "Ревизии '''$1''' не существует!",
	'code-rev-history-link' => 'история',
	'code-status-new' => 'новая',
	'code-status-desc-new' => 'Ревизия ожидает действия (статус по умолчанию).',
	'code-status-fixme' => 'исправить',
	'code-status-desc-fixme' => 'В этой версии появилась ошибка, или что-то не работает. Она должна быть исправлена, или возвращена к прежнему состоянию.',
	'code-status-reverted' => 'откачена',
	'code-status-desc-reverted' => 'Ревизия была откачена в другой ревизии.',
	'code-status-resolved' => 'решена',
	'code-status-desc-resolved' => 'В ревизия была проблема, которая была разрешена более поздней ревизией.',
	'code-status-ok' => 'OK',
	'code-status-desc-ok' => 'Ревизия полностью проверена, рецензент уверен, что с ней всё в порядке.',
	'code-status-deferred' => 'отложена',
	'code-status-desc-deferred' => 'Ревизия не требует проверки.',
	'code-status-old' => 'старая',
	'code-status-desc-old' => 'Старая ревизия с потенциальными ошибками, на рассмотрение которых не стоит тратить усилий.',
	'code-signoffs' => 'Подтверждения',
	'code-signoff-legend' => 'Добавление подтверждения',
	'code-signoff-submit' => 'Подтвердить',
	'code-signoff-strike' => 'Вычеркнуть выбранные подтверждения',
	'code-signoff-signoff' => 'Подтвердить эту ревизию как:',
	'code-signoff-flag-inspected' => 'Осмотрено',
	'code-signoff-flag-tested' => 'Испытано',
	'code-signoff-field-user' => 'Пользователь',
	'code-signoff-field-flag' => 'Флаг',
	'code-signoff-field-date' => 'Дата',
	'code-signoff-struckdate' => '$1 (вычеркнул $2)',
	'code-pathsearch-legend' => 'Поиск в этом хранилище конкретных ревизий по их адресу',
	'code-pathsearch-path' => 'Путь:',
	'code-pathsearch-filter' => 'Показать только:',
	'code-revfilter-cr_status' => 'Состояние = $1',
	'code-revfilter-cr_author' => 'Автор = $1',
	'code-revfilter-ct_tag' => 'Метка = $1',
	'code-revfilter-clear' => 'Снять фильтр',
	'code-rev-submit' => 'Сохранить изменения',
	'code-rev-submit-next' => 'Сохранить и показать следующую нерешённую',
	'code-rev-next' => 'Следующая нерешённая',
	'code-batch-status' => 'Изменить состояние:',
	'code-batch-tags' => 'Изменить метки:',
	'codereview-batch-title' => 'Изменить все выбранные ревизии',
	'codereview-batch-submit' => 'Отправить',
	'code-releasenotes' => 'примечания к выпуску',
	'code-release-legend' => 'Создание примечания к выпуску',
	'code-release-startrev' => 'Начальная ревизия:',
	'code-release-endrev' => 'Последняя ревизия:',
	'codereview-subtitle' => 'для $1',
	'codereview-reply-link' => 'ответить',
	'codereview-overview-title' => 'Обзор',
	'codereview-overview-desc' => 'Показать графическое представление этого списка',
	'codereview-email-subj' => '[$1] [r$2]: Добавлен новый комментарий',
	'codereview-email-body' => 'Участник «$1» разместил комментарий к $3.

Полный URL: $2
Краткое описание:

$5

Комментарий:

$4',
	'codereview-email-subj2' => '[$1] [r$2]: Последующие изменения',
	'codereview-email-body2' => 'Пользователь «$1» внёс изменения, относящиеся к $2.

Полный URL для предыдущей версии: $5
Описание изменений:

$6

Полный URL: $3

Описание изменений:

$4',
	'codereview-email-subj3' => '[$1 $2]: Изменение состояния ревизии',
	'codereview-email-body3' => 'Пользователь «$1» изменил состояние $2.

Старое состояние: $3
Новое состояние: $4

Полный URL-адрес: $5
Описание изменений:

$6',
	'codereview-email-subj4' => '[$1 $2]: Добавлен новый комментарий, изменилось состояние ревизии',
	'codereview-email-body4' => 'Пользователь «$1» изменил состояние $2.

Старое состояние: $2
Новое состояние: $4

Пользователь «$1» также оставил комментарий для $2.

Полный URL: $5
Описание изменений:

$7

Комментарий:

$6',
	'code-stats' => 'статистика',
	'code-stats-header' => 'Статистика репозитория «$1»',
	'code-stats-main' => 'На $1 в репозитории {{PLURAL:$2|содержится одна ревизия|содержатся $2 ревизии|содержатся $2 ревизий}} [[Special:Code/$3/author|$4 {{PLURAL:$4|автора|авторов}}]].',
	'code-stats-status-breakdown' => 'Статистика по состояниям',
	'code-stats-fixme-breakdown' => 'Распределение версий со статусом «исправить» по авторам',
	'code-stats-fixme-breakdown-path' => 'Распределение версий со статусом «исправить» по пути',
	'code-stats-fixme-path' => "Версии со статусом ''исправить'' для пути: $1",
	'code-stats-new-breakdown' => 'Распределение новых версий по авторам',
	'code-stats-new-breakdown-path' => 'Распределить новые изменения по адресу',
	'code-stats-new-path' => 'Новые изменения для адреса: $1',
	'code-stats-count' => 'Количество версий',
	'code-tooltip-withsummary' => 'r$1 [$2] $3 — $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] $3',
	'repoadmin' => 'Управление хранилищем программного кода',
	'repoadmin-new-legend' => 'Создать новое хранилище',
	'repoadmin-new-label' => 'Название хранилища:',
	'repoadmin-new-button' => 'Создать',
	'repoadmin-edit-legend' => 'Изменение хранилища «$1»',
	'repoadmin-edit-path' => 'Путь к репозиторию:',
	'repoadmin-edit-bug' => 'Путь к базе Bugzilla:',
	'repoadmin-edit-view' => 'Путь к ViewVC:',
	'repoadmin-edit-button' => 'Готово',
	'repoadmin-edit-sucess' => 'Хранилище «[[Special:Code/$1|$1]]» успешно изменено.',
	'repoadmin-nav' => 'управление репозиторием',
	'right-repoadmin' => 'Управление хранилищами кодов',
	'right-codereview-use' => 'использование Special:Code',
	'right-codereview-add-tag' => 'Добавление меток к ревизиям',
	'right-codereview-remove-tag' => 'Снятие меток с ревизий',
	'right-codereview-post-comment' => 'Добавление комментариев к ревизиям',
	'right-codereview-set-status' => 'Изменение статуса ревизий',
	'right-codereview-signoff' => 'подтверждение ревизий',
	'right-codereview-link-user' => 'Связь авторов с учётными записями вики-проекта',
	'right-codereview-associate' => 'управление ассоциациями ревизий',
	'right-codereview-review-own' => 'Отметить ваши собственные ревизии как «ОК» или «Решёные»',
	'specialpages-group-developer' => 'Инструменты разработчика',
	'group-svnadmins' => 'Администраторы SVN',
	'group-svnadmins-member' => '{{GENDER:$1|Администратор SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}:Администраторы SVN',
);

/** Rusyn (Русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'code' => 'Перевірка коду',
	'code-rev-title' => '$1 – Перегляд коду',
	'code-comments' => 'Коментарї',
	'code-references' => 'Наступны верзії',
	'code-change-status' => "змінив '''статус''' $1",
	'code-change-tags' => "змінив '''значкы''' про $1",
	'code-change-removed' => 'одстранене:',
	'code-change-added' => 'придане:',
	'code-old-status' => 'Попередній статус',
	'code-new-status' => 'Новый статус',
	'code-prop-changes' => 'Лоґ змін статус і значок',
	'codereview-desc' => '[[Special:Code|Інштрумент про овірїня коду]] з [[Special:RepoAdmin|podporou Subversion]]',
	'code-no-repo' => 'Не было наставлене жадне усховище!',
	'code-create-repo' => 'Про створїня усховіща ідьте до [[Special:RepoAdmin|RepoAdmin]]',
	'code-need-repoadmin-rights' => 'про створїня усховіща треба права repoadmin',
	'code-need-group-with-rights' => 'Не є ґрупа з правами repoadmin. Просиме придайте єдну, жебы сьте могли створити нове усховіща.',
	'code-repo-not-found' => "Усховище '''$1''' не єствує!",
	'code-load-diff' => 'Начітаваня різницї ...',
	'code-notes' => 'остатнї коментарї',
	'code-statuschanges' => 'зміны статусу',
	'code-mycommits' => 'мої дїї',
	'code-mycomments' => 'мої коментарї',
	'code-authors' => 'авторы',
	'code-status' => 'статусы',
	'code-tags' => 'значкы',
	'code-tags-no-tags' => 'У тім усховіщу не суть жадны значкы.',
	'code-authors-text' => 'Тото є список авторів в усховищу сортованый подля імена. В заперках суть хосновательскы імена на той вікі.
Дата можуть походжати з кеш.',
	'code-author-haslink' => 'Тот автор є повязаный з хоснователём $1',
	'code-author-orphan' => 'SVN хоснователь/автор $1 не мать жаден одказ про вікі хоснователя',
	'code-author-dolink' => 'Звязати того автора з вікі-хоснователём:',
	'code-author-alterlink' => 'Змінити вікі-хоснователя звязаного з тым автором:',
	'code-author-orunlink' => 'Або розорвати звязок з вікі-хоснователём',
	'code-author-name' => 'Уведьте імя хоснователя:',
	'code-author-success' => 'Автор $1 успішно повязаный з хоснователём $2',
	'code-author-link' => 'звязати?',
	'code-author-unlink' => 'розорвати звязок?',
	'code-author-unlinksuccess' => 'Звязок автор $1 быв розорваный',
	'code-author-badtoken' => 'Почас выконованя операції дішло ку хыбі.',
	'code-author-total' => 'Цалкове чісло авторів: $1',
	'code-author-lastcommit' => 'Датум послїднёго коміту',
	'code-browsing-path' => "Перегляд ревізій в '''$1'''",
	'code-field-id' => 'Ревізія',
	'code-field-author' => 'Автор',
	'code-field-user' => 'Автор коментаря',
	'code-field-message' => 'Опис змін',
	'code-field-status' => 'Став',
	'code-field-status-description' => 'Опис статусу',
	'code-field-timestamp' => 'Датум',
	'code-field-comments' => 'Коментарї',
	'code-field-path' => 'Стежка',
	'code-field-text' => 'Позначка',
	'code-field-select' => 'Выбрати',
	'code-reference-remove' => 'Вылучіти выбраны асоціації',
	'code-reference-associate' => 'Повязати наступну ревізію:',
	'code-reference-associate-submit' => 'Повязати',
	'code-rev-author' => 'Автор:',
	'code-rev-date' => 'Датум:',
	'code-rev-message' => 'Коментарь:',
	'code-rev-repo' => 'Репозітар:',
	'code-rev-rev' => 'Ревізія:',
	'code-rev-rev-viewvc' => 'через ViewVC',
	'code-rev-paths' => 'Змінены стежкы:',
	'code-rev-modified-a' => 'придано',
	'code-rev-modified-r' => 'нагородженый',
	'code-rev-modified-d' => 'змазано',
	'code-rev-modified-m' => 'змінено',
	'code-rev-imagediff' => 'Зміны образків',
	'code-rev-status' => 'Став:',
	'code-rev-status-set' => 'Змінити став',
	'code-rev-tags' => 'Значкы:',
	'code-rev-tag-add' => 'Придати значкы:',
	'code-rev-tag-remove' => 'Одстранити значкы:',
	'code-rev-comment-by' => 'Коментарь од $1',
	'code-rev-comment-preview' => 'Нагляд',
	'code-rev-inline-preview' => 'Нагляд:',
	'code-rev-diff' => 'Зміна',
	'code-rev-diff-link' => 'різн.',
	'code-rev-diff-too-large' => 'Тот роздїл не є дуже великый, жебы міг быти зображеный.',
	'code-rev-purge-link' => 'очістити кеш',
	'code-rev-total' => 'Цалкове чісло резултатів: $1',
	'code-rev-not-found' => "Ревізія '''$1''' не єствує!",
	'code-rev-history-link' => 'історія',
	'code-status-new' => 'нове',
	'code-status-desc-new' => 'Ревізія чекать на означіня (початочный статус).',
	'code-status-fixme' => 'оправити',
	'code-status-desc-fixme' => 'У тій ревізії ся обявила хыба. Мала бы быти справена або вернута до опереднёго статусу.',
	'code-status-reverted' => 'вернуто назад',
	'code-status-desc-reverted' => 'Попередня ревізія была одшмарена нескоршов.',
	'code-status-resolved' => 'вырїшено',
	'code-status-desc-resolved' => 'Ревізія мала проблем, котрый вырїшыла пізнїша ревізія.',
	'code-status-ok' => 'ОК',
	'code-status-desc-ok' => 'Ревізія была повно перевірена і рецензент собі є певный, же є цалком в порядку.',
	'code-status-deferred' => 'одложена',
	'code-status-desc-deferred' => 'Ревізія не потребує рецензованя',
	'code-status-old' => 'стара',
	'code-status-desc-old' => 'Стара ревізія, котра може обсяговати хыбы, але не стоїть за то, жебы была перевірена.',
	'code-signoffs' => 'Схвалїня',
	'code-signoff-legend' => 'Додати схвалїня',
	'code-signoff-submit' => 'Схвалити',
	'code-signoff-strike' => 'Перечаркнути выбраны схвалїня',
	'code-signoff-signoff' => 'Схвалити тоту ревізію як:',
	'code-signoff-flag-inspected' => 'Перевірене',
	'code-signoff-flag-tested' => 'Отестовано',
	'code-signoff-field-user' => 'Хоснователь',
	'code-signoff-field-flag' => 'Прапорок',
	'code-signoff-field-date' => 'Датум',
	'code-signoff-struckdate' => '$1 (перечаркнуто $2)',
	'code-pathsearch-legend' => 'Глядати ревізії у тім усховищу подля стежкы',
	'code-pathsearch-path' => 'Стежка:',
	'code-pathsearch-filter' => 'Указати лем:',
	'code-revfilter-cr_status' => 'Став = $1',
	'code-revfilter-cr_author' => 'Автор = $1',
	'code-revfilter-ct_tag' => 'Значка = $1',
	'code-revfilter-clear' => 'Зняти філтер',
	'code-rev-submit' => 'Вказати зміны',
	'code-rev-submit-next' => 'Уложыти & далшы невырїшены',
	'code-rev-next' => 'Наступна невырїшена',
	'code-batch-status' => 'Змінити став:',
	'code-batch-tags' => 'Змінити значкы:',
	'codereview-batch-title' => 'Зміна вшыткых выбраных верзій',
	'codereview-batch-submit' => 'Одослати',
	'code-releasenotes' => 'позначкы ку выданю',
	'code-release-legend' => 'Створити позначку ку выданю',
	'code-release-startrev' => 'Початочна ревізія:',
	'code-release-endrev' => 'Послїня ревізія:',
	'codereview-subtitle' => 'Про $1',
	'codereview-reply-link' => 'одповісти',
	'codereview-overview-title' => 'Перегляд',
	'codereview-overview-desc' => 'Указати ґрафічный перегляд того списку',
	'codereview-email-subj' => '[$1 $2]: Приданый новый коментарь',
	'codereview-email-body' => 'Хоснователь „$1“ придав коментарь ку $3.

Повне URL: $2
Коментарь ку змінї:

$5

Коментарь:

$4',
	'codereview-email-subj2' => '[$1 $2]: Реаґуюча зміна',
	'codereview-email-body2' => 'Хоснователь „$1“ своёв змінов реаґовав на $2.

Повне URL оріґіналной ревізії: $5
Коментарь ку змінї:

$6

Повне URL: $3

Коментарь ку змінї:

$4',
	'codereview-email-subj3' => '[$1 $2]: Статус ревізії зміненый',
	'codereview-email-body3' => 'Хоснователь „$1“ змінив статус $2.

Опереднїй статус: $3
Новый статус: $4

Повне URL: $5
Коментарь ку змінї:

$6',
	'codereview-email-subj4' => '[$1 $2]: Доданый новый коментарь і змінив ся статус ревізії',
	'codereview-email-body4' => 'Хоснователь „$1“ змінив статус $2.

Опереднїй статус: $3
Новый статус: $4

Хоснователь „$1“ тыж придав ку $2 коментарь.

Повне URL: $5
Коментарь ку змінї:

$7

Коментарь:

$6',
	'code-stats' => 'штатістіка',
	'code-stats-header' => 'Штатістіка про усховища $1',
	'code-stats-main' => 'Ку $1 обсяговало усховище $2 {{PLURAL:$2|ревізію|ревізії|ревізій}} од [[Special:Code/$3/author|$4 {{PLURAL:$4|автора|авторів}}]].',
	'code-stats-status-breakdown' => 'Чісло ревізій на статус',
	'code-stats-fixme-breakdown' => 'Дефект ревізій про корекції подля автора',
	'code-stats-fixme-breakdown-path' => 'Дефект ревізій про корекції подля адресаря',
	'code-stats-fixme-path' => 'Оправны ревізії про адресарь: $1',
	'code-stats-new-breakdown' => 'Дефект новых ревізій подля автора',
	'code-stats-count' => 'Чісло ревізій',
	'code-tooltip-withsummary' => 'р$1 [$2] by $3 - $4',
	'code-tooltip-withoutsummary' => 'р$1 [$2]  $3',
	'repoadmin' => 'Адміністрація усховищ',
	'repoadmin-new-legend' => 'Створити нове усховище',
	'repoadmin-new-label' => 'Назва усховища:',
	'repoadmin-new-button' => 'Створити',
	'repoadmin-edit-legend' => 'Зміна усховища «$1»',
	'repoadmin-edit-path' => 'Стежка до усховища:',
	'repoadmin-edit-bug' => 'Стежка до Bugzilla:',
	'repoadmin-edit-view' => 'Стежка до ViewVC:',
	'repoadmin-edit-button' => 'ОК',
	'repoadmin-edit-sucess' => 'Усховище «[[Special:Code/$1|$1]]» успішно змінено.',
	'repoadmin-nav' => 'адміністрація усховища',
	'right-repoadmin' => 'Адміністрація усховищ кодів',
	'right-codereview-use' => 'Хоснованя Special:Code',
	'right-codereview-add-tag' => 'Придаваня значок до ревізій',
	'right-codereview-remove-tag' => 'Одобераня значок із ревізій',
	'right-codereview-post-comment' => 'Придаваня коментарїв до ревізій',
	'right-codereview-set-status' => 'Зміна статусу ревізій',
	'right-codereview-signoff' => 'Схвалёваня ревізій',
	'right-codereview-link-user' => 'Звязок авторів з вікі-хоснователями',
	'right-codereview-associate' => 'Адміністрація одношінь міджі ревізіями',
	'right-codereview-review-own' => 'Означіти властны ревізії як ОК або Вырїшены',
	'specialpages-group-developer' => 'Інштрументы вывоя',
	'group-svnadmins' => 'SVN адміністраторы',
	'group-svnadmins-member' => 'SVN адміністратор',
	'grouppage-svnadmins' => '{{ns:project}}:SVN адміністраторы',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 */
$messages['sa'] = array(
	'code-authors' => 'लेखक',
	'code-field-author' => 'लेखक',
	'code-field-timestamp' => 'दिनाङ्क',
	'code-rev-author' => 'लेखक:',
	'code-rev-date' => 'दिनाङ्क:',
	'code-rev-comment-preview' => 'प्राग्दृश्यम् दर्श्यताम्',
	'code-rev-inline-preview' => 'प्राग्दृश्यम् दर्श्यताम्:',
	'code-rev-history-link' => 'इतिहास',
	'code-status-ok' => 'अस्तु',
	'code-signoff-field-user' => 'योजकः',
	'code-signoff-field-date' => 'दिनाङ्क',
);

/** Sakha (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'code' => 'Куоду бэрэбиэркэлээһин',
	'code-rev-title' => '$1 - Куод туругурдуута',
	'code-comments' => 'Быһаарыылар',
	'code-references' => 'Кэнники ревизиялар',
	'code-change-status' => "бу барыл (ревизия) '''туругун''' $1 уларытта",
	'code-change-tags' => "'''бэлиэлэрин''' $1 уларыппыт (бэлиэлэрэ уларыйбыт)",
	'code-change-removed' => 'сотулунна:',
	'code-change-added' => 'эбилиннэ:',
	'code-old-status' => 'Урукку туруга',
	'code-new-status' => 'Саҥа туруга',
	'code-prop-changes' => 'Статус уонна бэлиэлэр сурунааллара',
	'codereview-desc' => '[[Special:RepoAdmin|Subversion]] өйүүр [[Special:Code|куоду көрдөрөр үнүстүрүмүөн]]',
	'code-no-repo' => 'Анаан оҥоһуллубут ыскылаат суох',
	'code-repo-not-found' => "'''$1''' репозиторий суох!",
	'code-load-diff' => 'Тэҥнээһин...',
	'code-notes' => 'соторутааҥҥы бэлиэтээһиннэр',
	'code-statuschanges' => 'турук уларыйыылара',
	'code-mycommits' => 'мин коммиттарым',
	'code-mycomments' => 'мин быһаарыыларым',
	'code-authors' => 'ааптардар',
	'code-status' => 'туруктара (статустара)',
	'code-tags' => 'бэлиэлэр',
	'code-tags-no-tags' => 'Манна бэлиэтээһиннэр суохтар.',
	'code-authors-text' => 'Ааптардар тиһиктэрэ ааттарынан наарданан бэриллэр. Олохтоох биикигэ бэлиэтэммит ааттара ускуобкаҕа бэриллэр. Бу дааннайдар кээштан ылыллыбыт буолуохтарын сөп.',
	'code-author-haslink' => 'Бу ааптар $1 кыттааччыга сигэнэр',
	'code-author-orphan' => 'Бу ааптар биики-бырайыак ханнык да кыттааччытыгар сигэммэт',
	'code-author-dolink' => 'Бу ааптары ханнык эмит кыттаачыга сигииргэ:',
	'code-author-alterlink' => 'Бу ааптар кыттааччыга сигэниитин уларытарга:',
	'code-author-orunlink' => 'Эбэтэр кыттаачыга сигэни эрэ соторго:',
	'code-author-name' => 'Ааккын суруй:',
	'code-author-success' => '$1 ааптар $2 кыттааччылыын сигэннэ',
	'code-author-link' => 'холбуурга?',
	'code-author-unlink' => 'араарарга?',
	'code-author-unlinksuccess' => '$1 ааптар сигэниитэ сотулунна',
	'code-author-badtoken' => 'Дьайыыны оҥорорго сеанс алҕаһа таҕыста.',
	'code-author-total' => 'Ааптардар ахсааннара: $1',
	'code-author-lastcommit' => 'Бүтэһик коммит күнэ-дьыла',
	'code-browsing-path' => "Ревизиялары көрүү: '''$1'''",
	'code-field-id' => 'Торум',
	'code-field-author' => 'Ааптар',
	'code-field-user' => 'Ырытааччы',
	'code-field-message' => 'Уларытыылар туһунан',
	'code-field-status' => 'Турук',
	'code-field-status-description' => 'Туругун туһунан',
	'code-field-timestamp' => 'Күнэ-дьыла',
	'code-field-comments' => 'Быһаарыылар',
	'code-field-path' => 'Суола',
	'code-field-text' => 'Быһаарыы',
	'code-field-select' => 'Талыы',
	'code-reference-remove' => 'Талыллыбыт баайыылары соторго',
	'code-reference-associate' => 'Мантан ынтах кэлэр барылы баайарга:',
	'code-reference-associate-submit' => 'Баайарга (ситимнииргэ)',
	'code-rev-author' => 'Ааптар:',
	'code-rev-date' => 'Күнэ-дьыла:',
	'code-rev-message' => 'Быһаарыы:',
	'code-rev-repo' => 'Ыскылаат:',
	'code-rev-rev' => 'Торум (барыл):',
	'code-rev-rev-viewvc' => 'ViewVC нөҥүө',
	'code-rev-paths' => 'Уларытыыларга сигэлэр:',
	'code-rev-modified-a' => 'эбилиннэ',
	'code-rev-modified-r' => 'уларытылынна',
	'code-rev-modified-d' => 'сотулунна',
	'code-rev-modified-m' => 'көннөрүлүннэ',
	'code-rev-imagediff' => 'Ойуу уларыйыылара',
	'code-rev-status' => 'Туруга:',
	'code-rev-status-set' => 'Стаатуһу (туругу) уларытыы',
	'code-rev-tags' => 'Бэлиэлэр (теги):',
	'code-rev-tag-add' => 'Бэлиэлэри эбии:',
	'code-rev-tag-remove' => 'Бэлиэлэри сотуу:',
	'code-rev-comment-by' => 'Баччатааҕы быһаарыы: $1',
	'code-rev-comment-preview' => 'Ыытыах иннинэ көрүү',
	'code-rev-inline-preview' => 'Эрдэ көрүү:',
	'code-rev-diff' => 'Уларытыы',
	'code-rev-diff-link' => 'уларытыы',
	'code-rev-diff-too-large' => 'Барыллар ыккардыларынааҕы уратылар наһаа улахан буолан, көрдөрөр кыах суох.',
	'code-rev-purge-link' => 'кээһи ыраастаа',
	'code-rev-total' => 'Түмүктэр бүтүн ахсааннара: $1',
	'code-rev-not-found' => "'''$1''' ревизия суох!",
	'code-status-new' => 'саҥа',
	'code-status-desc-new' => 'Ревизия дьайыыны көһүтэр (атын туох да ыйыллыбатах буоллаҕына турар).',
	'code-status-fixme' => 'бэрэбиэркэлээ',
	'code-status-desc-fixme' => 'Рецензент бу ревизияҕа алҕаһы эбэтэр алдьаныыны булбут. Ол көннөрүллүөхтээх.',
	'code-status-reverted' => 'төннөрүллүбүт',
	'code-status-desc-reverted' => 'Ревизия атын ревизияҕа төннөрүллүбүт.',
	'code-status-resolved' => 'быһаарыллыбыт',
	'code-status-desc-resolved' => 'Бу ревизияҕа ханнык эрэ алҕас баарын хойукку ревизия суох гыммыт.',
	'code-status-ok' => 'сөп',
	'code-status-desc-ok' => 'Ревизия толору көрүлүннэ, рецензент барыта үчүгэй диэн бигэтик эрэнэр.',
	'code-status-deferred' => 'кэлиҥҥигэ көһөрүлүннэ',
	'code-status-desc-deferred' => 'Ревизия көрүллэр наадата суох.',
	'code-status-old' => 'урукку',
	'code-status-desc-old' => 'Урукку ревизия, сыыһалардаах буолуон сөп эрээри, көннөрө сатаан таах кыаххын бараама.',
	'code-signoffs' => 'Бигэргэтиилэр',
	'code-signoff-legend' => 'Бигэргэтиини эбии',
	'code-signoff-submit' => 'Бигэргэтэргэ',
	'code-signoff-strike' => 'Талыллыбыт бигэргэтиилэри соторго',
	'code-signoff-signoff' => 'Бу барылы маннык бигэргэтэргэ:',
	'code-signoff-flag-inspected' => 'Көрүлүннэ',
	'code-signoff-flag-tested' => 'Тургутулунна',
	'code-signoff-field-user' => 'Кыттааччы',
	'code-signoff-field-flag' => 'Бэлиэ',
	'code-signoff-field-date' => 'Күнэ-дьыла',
	'code-signoff-struckdate' => '$1 ($2 сотто)',
	'code-pathsearch-legend' => 'Биирдиилээн барыллары чопчу аадырыһынан көрдөөһүн',
	'code-pathsearch-path' => 'Суола:',
	'code-pathsearch-filter' => 'Туттуллубут сиидэлэр:',
	'code-revfilter-cr_status' => 'Турук = $1',
	'code-revfilter-cr_author' => 'Ааптар = $1',
	'code-revfilter-clear' => 'Сиидэни уһул',
	'code-rev-submit' => 'Уларытыылары бигэргэтии',
	'code-rev-submit-next' => 'Бигэргэт уонна аныгыскы быһаарылла илиги көрдөр',
	'code-batch-status' => 'Туругун уларытыы:',
	'code-batch-tags' => 'Бэлиэлэрин уларытыы:',
	'codereview-batch-title' => 'Талыллыбыт барыллары барыларын уларыт',
	'codereview-batch-submit' => 'Ыытарга',
	'code-releasenotes' => 'Таһаарыы быһаарыыта',
	'code-release-legend' => 'Таһаарыы быһаарыытын суруйуу',
	'code-release-startrev' => 'Бастакы барыл:',
	'code-release-endrev' => 'Бүтэһик барыл:',
	'codereview-subtitle' => 'Манна $1',
	'codereview-reply-link' => 'хоруй',
	'codereview-email-subj' => '[$1 $2]: Саҥа ырытыы киирбит',
	'codereview-email-body' => '"$1" кыттааччы бу барылга $3 саҥа ырытыы суруйбут.

Толору URL: $2

Ырытыы:

$4',
	'codereview-email-subj2' => '[$1 $2]: Ол кэннинээҕи уларыйыылар',
	'codereview-email-body2' => '"$1" кыттааччы манна уларытыыны киллэрбит $2.

Бу иннинээҕи барылын толору URL-а: $5

Толору URL-а: $3

Уларыйыы туһунан:

$4',
	'codereview-email-subj3' => '[$1 $2]: Барыл туругун уларытыы',
	'codereview-email-body3' => '«$1» кыттааччы $2 туругун уларыппыт.

Урукку туруга: $3
Билиҥҥи туруга: $4

Толору URL: $5',
	'codereview-email-subj4' => '[$1 $2]: Ырытыыга саҥа этии эбиллибит, барыл туруга уларыйбыт',
	'codereview-email-body4' => '«$1» кыттааччы $2 туругун уларыппыт.

Урукку туруга: $3
Билиҥҥи туруга: $4

«$1» кыттааччы эбии манна $2 этии хаалларбыт.

толору URL-а: $5

Этии:

$6',
	'code-stats' => 'Статистиката:',
	'code-stats-header' => '«$1» репозиторий статистиката',
	'code-stats-main' => 'Бу кэмҥэ $1 репозиторийга {{PLURAL:$2|биир ревизия баар|$2 ревизия баар}} [[Special:Code/$3/author|$4 {{PLURAL:$4|ааптар|ахсааннаах ааптар}}]].',
	'code-stats-status-breakdown' => 'Ревизиялар туруктарынан',
	'code-stats-fixme-breakdown' => 'Уларытыылар тарҕаныылара ааптардарынан',
	'code-stats-count' => 'Ревизия ахсаана',
	'repoadmin' => 'Бырагыраамма куодун харайыыны салайыы',
	'repoadmin-new-legend' => 'Саҥа харайар сири оҥоруу',
	'repoadmin-new-label' => 'Харалта аата:',
	'repoadmin-new-button' => 'Оҥоруу',
	'repoadmin-edit-legend' => 'Харалтаны уларытыы "$1"',
	'repoadmin-edit-path' => 'Харалтаҕа суол:',
	'repoadmin-edit-bug' => 'Bugzilla суола:',
	'repoadmin-edit-view' => 'ViewVC суола:',
	'repoadmin-edit-button' => 'Сөп',
	'repoadmin-edit-sucess' => 'Харалта "[[Special:Code/$1|$1]]" уларытылынна.',
	'repoadmin-nav' => 'репозиторийы салайыы',
	'right-repoadmin' => 'Куодтар харалталарын салайыы',
	'right-codereview-use' => 'Special туттуу:Code',
	'right-codereview-add-tag' => 'Барылларга саҥа бэлиэни эбэн биэрии',
	'right-codereview-remove-tag' => 'Бэлиэлэри торумнартан сотуу',
	'right-codereview-post-comment' => 'Барылларга ырытыы суруйуу',
	'right-codereview-set-status' => 'Барыллар стаатустарын уларытыы',
	'right-codereview-signoff' => 'Барыллары бигэргэтии',
	'right-codereview-link-user' => 'Ааптардары биикигэ бэлиэтэммит ааттары кытта сигээһин',
	'right-codereview-associate' => 'Барыллары бөлөҕүнэн салайыы',
	'specialpages-group-developer' => 'Оҥорооччу тэриллэрэ (үнүстүрүмүөннэрэ)',
	'group-svnadmins' => 'SVN дьаһабыллара',
	'group-svnadmins-member' => 'SVN дьаһабыла',
	'grouppage-svnadmins' => '{{ns:project}}:SVN дьаһабыллара',
);

/** Sicilian (Sicilianu)
 * @author Aushulz
 * @author Gmelfi
 * @author Santu
 */
$messages['scn'] = array(
	'code' => 'Rivisioni dû còdici',
	'code-comments' => 'Cummenti',
	'code-change-status' => "Canciatu lu '''status''' di sta rivisioni",
	'code-change-tags' => "Canciati li '''tags''' pi sta rivisioni",
	'code-change-removed' => 'rimuvutu:',
	'code-change-added' => 'junciutu:',
	'code-prop-changes' => 'Status & log di tagging',
	'codereview-desc' => '[[Special:Code|Stigghi pâ rivisioni dû codici]] cu [[Special:RepoAdmin|Supportu di suvvirsioni]]',
	'code-no-repo' => 'Nuddu dipòsitu cunfiguratu!',
	'code-notes' => 'Noti di rivisioni',
	'code-authors' => 'autura',
	'code-tags' => 'etichetti',
	'code-authors-text' => "Ccassutta c'è na lista di autura di dipòsiti n òrdini di assignazzioni cchiù ricenti",
	'code-author-haslink' => "St'auturi è culligatu ô utenti wiki $1",
	'code-author-orphan' => "St'auturi nun è cullicatu a n'account wiki",
	'code-author-dolink' => "Culligari st'auturi a n'untenti wiki:",
	'code-author-alterlink' => "Canciari l'utilizzaturi dâ wiki cullicatu a stu auturi:",
	'code-author-orunlink' => "O leva lu culligamentu cu st'utilizzaturi dâ wiki:",
	'code-author-name' => "Mittiti nu nomu d'utilizzaturi:",
	'code-author-success' => "L'auturi $1 fu culligatu all'utilizzaturi wiki $2",
	'code-author-link' => 'culligari?',
	'code-author-unlink' => 'livari lu culligamentu?',
	'code-author-unlinksuccess' => "Lu culligamentu all'auturi $1 fu livatu",
	'code-field-id' => 'Rivisioni',
	'code-field-author' => 'Auturi',
	'code-field-user' => 'Cummintaturi',
	'code-field-message' => 'Cummentu',
	'code-field-status' => 'Statu',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Noti',
	'code-field-path' => 'Jolu',
	'code-field-text' => 'Nota',
	'code-rev-author' => 'Auturi:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Cummentu:',
	'code-rev-repo' => 'Cascittuni:',
	'code-rev-rev' => 'Rivisioni:',
	'code-rev-rev-viewvc' => 'supra ViewVC',
	'code-rev-paths' => 'Jolu mudificatu:',
	'code-rev-modified-a' => 'junciutu:',
	'code-rev-modified-r' => 'sustituitu',
	'code-rev-modified-d' => 'scancillatu',
	'code-rev-modified-m' => 'canciatu',
	'code-rev-status' => 'Statu:',
	'code-rev-status-set' => 'Cancia lu statu',
	'code-rev-tags' => 'Tag:',
	'code-rev-tag-add' => 'Junci tag:',
	'code-rev-tag-remove' => 'Leva tag:',
	'code-rev-comment-by' => 'Cummentu di $1',
	'code-rev-comment-preview' => 'Antiprima',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-purge-link' => 'pulizzìa',
	'code-status-new' => 'novu',
	'code-status-fixme' => 'fissami',
	'code-status-reverted' => 'scanciatu annarreri',
	'code-status-resolved' => 'risortu',
	'code-status-ok' => 'ok',
	'code-status-deferred' => 'rimannatu',
	'code-signoff-field-user' => 'Utenti',
	'code-pathsearch-legend' => 'Cerca li rivisioni nti stu dipòsitu classificati pî pircursa',
	'code-pathsearch-path' => 'Pircursu:',
	'code-revfilter-clear' => 'Pulizzia firtru',
	'code-rev-submit' => 'Canci di assignazzioni',
	'code-rev-submit-next' => 'Assignazzioni & pròssimi nun risurvuti',
	'codereview-reply-link' => 'Arrispunni',
	'codereview-email-subj' => '[$1 $2]: Cummentu novu jiunchiutu',
	'codereview-email-body' => 'L\'utilizzaturi "$1" misi nu cummentu supra $3.

URL cumpleta: $2

Cummentu:

$4',
	'repoadmin' => 'Amministrazzioni dî dipòsiti',
	'repoadmin-new-legend' => 'Crèa nu dipòsitu novu',
	'repoadmin-new-label' => 'Nomu dû dipòsitu:',
	'repoadmin-new-button' => 'Crèa',
	'repoadmin-edit-legend' => 'Canciamentu dû dipòsitu "$1"',
	'repoadmin-edit-path' => 'Pircursu dû dipòsitu',
	'repoadmin-edit-bug' => 'Pircursu dû Bugzilla:',
	'repoadmin-edit-view' => 'Pircursu dû ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Lu dipòsitu "[[Special:Code/$1|$1]]" fu canciatu cu successu.',
	'right-repoadmin' => 'Codici di gistioni dî dipòsiti',
	'right-codereview-add-tag' => 'Jiunci etichetti novi ê rivisioni',
	'right-codereview-remove-tag' => "Leva l'etichetti dî rivisioni",
	'right-codereview-post-comment' => 'Jiunci li cummenti ê rivisioni',
	'right-codereview-set-status' => 'Cancia lu statu dî rivisioni',
	'right-codereview-link-user' => 'Lìja li autura ê utilizzatura dâ wiki',
	'specialpages-group-developer' => 'Stigghi dû sviluppaturi',
);

/** Serbo-Croatian (Srpskohrvatski)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'codereview-batch-submit' => 'Unesi',
);

/** Sinhala (සිංහල)
 * @author Singhalawap
 * @author පසිඳු කාවින්ද
 * @author බිඟුවා
 */
$messages['si'] = array(
	'code' => 'කේත නිරීක්ෂණය',
	'code-rev-title' => '$1 - කේත නිරීක්ෂණය',
	'code-comments' => 'පරිකථන',
	'code-change-status' => "$1 හී '''තත්වය''' වෙනස් කරන ලදී",
	'code-change-tags' => "$1 සඳහා '''ටැගයන්''' වෙනස් කරන ලදී",
	'code-change-removed' => 'ඉවත් කරන ලද:',
	'code-change-added' => 'එක් කෙරූ:',
	'code-old-status' => 'පැරණි තත්වය',
	'code-new-status' => 'නව තත්වය',
	'code-prop-changes' => 'තත්ත්ව සහ ටැගීකරණයෙහි ලඝු සටහන',
	'codereview-desc' => '[[Special:Code|කේත නිරීක්ෂණ මෙවලම]] සමඟ [[Special:RepoAdmin|විප්ලවීය සහය]]',
	'code-no-repo' => 'කෝෂ්ඨාගාර කිසිවක් වින්‍යාසගතකොට නැත!',
	'code-create-repo' => 'කෝෂ්ඨාගාරය තැනීම සඳහා  [[Special:RepoAdmin|රෙපෝපරිපාලක]] වෙත යන්න',
	'code-repo-not-found' => "'''$1''' කෝෂ්ඨාගාරය නොපවතියි!",
	'code-load-diff' => 'වෙනස පූරණය කරමින්...',
	'code-notes' => 'මෑත පරිකථනයන්',
	'code-statuschanges' => 'තත්ත්ව වෙනස්කම්',
	'code-mycommits' => 'මගේ බැඳීම්',
	'code-mycomments' => 'මගේ පරිකථන',
	'code-authors' => 'කතෘන්',
	'code-status' => 'තත්වය',
	'code-tags' => 'ටැගයන්',
	'code-tags-no-tags' => 'කෝෂ්ඨාගාරය තුල ටැගයන් කිසිවක් නොපවතියි.',
	'code-author-haslink' => 'මෙම කතුවරයා විකි පරිශීලක $1 වෙත සම්බන්ධ කරන ලදී',
	'code-author-dolink' => 'විකි පරිශීලකයෙකු වෙත මෙම කතුවරයා සම්බන්ධ කරන්න:',
	'code-author-alterlink' => 'මෙම කතුවරයා වෙත සම්බන්ධ කර ඇති විකි පරිශීලකයා වෙනස් කරන්න:',
	'code-author-orunlink' => 'හෝ මෙම විකි පරිශීලකයා අසම්බන්ධ කරන්න:',
	'code-author-name' => 'පරිශීලක නාමය යොදන්න:',
	'code-author-success' => '$1 කතුවරයා $2 විකි පරිශීලකයා වෙත සම්බන්ධ කරන ලදී',
	'code-author-link' => 'සම්බන්ධ කරන්නද?',
	'code-author-unlink' => 'අසම්බන්ධ කරන්නද?',
	'code-author-unlinksuccess' => '$1 කතුවරයා අසම්බන්ධ කරන ලදී',
	'code-author-total' => 'කතෘවරුන් ගණන: $1',
	'code-author-lastcommit' => 'අන්තිමට බැඳුනු දිනය',
	'code-browsing-path' => "'''$1''' හී සංශෝධන ගවේෂණය කරමින්",
	'code-field-id' => 'සංශෝධනය',
	'code-field-author' => 'කතෘ',
	'code-field-user' => 'පරකථිකයා',
	'code-field-message' => 'කමිටු සාරාංශය',
	'code-field-status' => 'තත්වය',
	'code-field-status-description' => 'තත්ත්ව විස්තරය',
	'code-field-timestamp' => 'දිනය',
	'code-field-comments' => 'පරිකථන',
	'code-field-path' => 'පථය',
	'code-field-text' => 'සටහන',
	'code-field-select' => 'තෝරන්න',
	'code-reference-remove' => 'තෝරාගත් ආශ්‍රයන් ඉවත් කරන්න',
	'code-reference-associate-submit' => 'හවුල් කරන්න',
	'code-rev-author' => 'කතෘ:',
	'code-rev-date' => 'දිනය:',
	'code-rev-message' => 'පරිකථනය:',
	'code-rev-repo' => 'කෝෂ්ඨාගාරය:',
	'code-rev-rev' => 'සංශෝධනය:',
	'code-rev-rev-viewvc' => 'ViewVC මත',
	'code-rev-paths' => 'වෙනස් කරන ලද පථයන්:',
	'code-rev-modified-a' => 'එක් කෙරූ',
	'code-rev-modified-r' => 'ප්‍රතිස්ථාපනය කෙරූ',
	'code-rev-modified-d' => 'මකා දැමූ',
	'code-rev-modified-m' => 'වෙනස් කරන ලද',
	'code-rev-imagediff' => 'පින්තුර වෙනස්කම්',
	'code-rev-status' => 'තත්වය:',
	'code-rev-status-set' => 'තත්වය වෙනස් කරන්න',
	'code-rev-tags' => 'ටැගයන්:',
	'code-rev-tag-add' => 'ටැගයන් එක් කරන්න:',
	'code-rev-tag-remove' => 'ටැගයන් ඉවත් කරන්න:',
	'code-rev-comment-by' => '$1 ගෙන් පරිකථනය',
	'code-rev-comment-preview' => 'පෙර දසුන',
	'code-rev-inline-preview' => 'පෙරදසුන:',
	'code-rev-diff' => 'වෙනස',
	'code-rev-diff-link' => 'වෙනස',
	'code-rev-diff-too-large' => 'පෙන්වීම සඳහා වෙනස විශාල වැඩියි.',
	'code-rev-purge-link' => 'විමෝචනය',
	'code-rev-total' => 'මුළු ප්‍රථිපල ගණන: $1',
	'code-rev-not-found' => "සංශෝධනය '''$1''' නොපවතියි!",
	'code-rev-history-link' => 'ඉතිහාසය',
	'code-status-new' => 'නව',
	'code-status-fixme' => 'මාවසකසන්න',
	'code-status-reverted' => 'ප්‍රතිවර්තනය කෙරූ',
	'code-status-desc-reverted' => 'පසු අනුවාදයක් මඟින් සංශෝධනය අහෝසි කරන ලදී.',
	'code-status-resolved' => 'තීරණය කරන ලද',
	'code-status-ok' => 'හරි',
	'code-status-deferred' => 'ප්‍රමාද වූ',
	'code-status-desc-deferred' => 'සංශෝධනය සඳහා නිරීක්ෂණයක් අවශ්‍ය නොවේ.',
	'code-status-old' => 'පැරණි',
	'code-signoffs' => 'නික්මයාම්',
	'code-signoff-legend' => 'නික්මීම එක් කරන්න',
	'code-signoff-submit' => 'නික්මීම',
	'code-signoff-flag-inspected' => 'පරීක්ෂා කරන ලද',
	'code-signoff-flag-tested' => 'පරික්ෂා කරන ලද',
	'code-signoff-field-user' => 'පරිශීලක',
	'code-signoff-field-flag' => 'ධජය',
	'code-signoff-field-date' => 'දිනය',
	'code-signoff-struckdate' => '$1 (struck $2)',
	'code-pathsearch-path' => 'පථය:',
	'code-pathsearch-filter' => 'පමණක් පෙන්වන්න:',
	'code-revfilter-cr_status' => 'තත්වය = $1',
	'code-revfilter-cr_author' => 'කතෘ = $1',
	'code-revfilter-ct_tag' => 'ටැගය = $1',
	'code-revfilter-clear' => 'පෙරහන පිරිසිදු කරන්න',
	'code-rev-submit' => 'වෙනස්කම් සුරකින්න',
	'code-rev-submit-next' => 'සුරැකීම සහ මීළඟ නොවිසඳූ',
	'code-rev-next' => 'මීළඟ නොවිසඳූ',
	'code-batch-status' => 'තත්වය වෙනස් කරන්න:',
	'code-batch-tags' => 'ටැගයන් වෙනස් කරන්න:',
	'codereview-batch-title' => 'තෝරාගත් සංශෝධන සියල්ලම වෙනස් කරන්න',
	'codereview-batch-submit' => 'යොමන්න',
	'code-releasenotes' => 'නිකුතු සටහන්',
	'code-release-legend' => 'නිකුතු සටහන් ජනිත කරන්න',
	'code-release-startrev' => 'සංස් අරඹන්න:',
	'code-release-endrev' => 'අවසන් සංස්:',
	'codereview-subtitle' => '$1 සඳහා',
	'codereview-reply-link' => 'පිළිතුරු',
	'codereview-overview-title' => 'දළ විශ්ලේෂණය',
	'codereview-overview-desc' => 'මෙම ලයිස්තුවේ ග්‍රාපිකරූපී දල විශ්ලේෂණය පෙන්වන්න',
	'codereview-email-subj' => '[$1 $2]: නව පරිකථනයක් එක්කරන ලදී',
	'code-stats' => 'සංඛ්‍යාන දත්ත',
	'code-stats-header' => '$1 කෝෂ්ඨාගාරය සඳහා සංඛ්‍යා ලේඛන',
	'code-stats-status-breakdown' => 'එක් අවස්ථාවකට සංශෝධන',
	'code-stats-fixme-breakdown' => 'එක් කතුවරයෙකුට ෆික්ස්මි සංශෝධනවල බිඳ වැටුම',
	'code-stats-fixme-breakdown-path' => 'එක් පථයකට ෆික්ස්මි සංශෝධනවල බිඳ වැටුම',
	'code-stats-fixme-path' => 'පථය සඳහා ෆික්ස්මී සංශෝධන: $1',
	'code-stats-new-breakdown' => 'එක් කතුවරයෙකුට නව සංශෝධනවල බිඳ වැටුම',
	'code-stats-new-breakdown-path' => 'එක් පථයකට නව සංශෝධනවල බිඳ වැටුම',
	'code-stats-new-path' => 'පථය සඳහා නව සංශෝධන: $1',
	'code-stats-count' => 'සංශෝධන ගණන',
	'code-tooltip-withsummary' => 'r$1 [$2] $3 විසින් - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] $3 විසින්',
	'repoadmin' => 'කෝෂ්ඨාගාර පරිපාලකත්වය',
	'repoadmin-new-legend' => 'නව කෝෂ්ඨාගාරයක් තනන්න',
	'repoadmin-new-label' => 'කෝෂ්ඨාගාර නාමය:',
	'repoadmin-new-button' => 'තනන්න',
	'repoadmin-edit-legend' => '"$1" කෝෂ්ඨාගාරයෙහි වෙනස් කිරීම්',
	'repoadmin-edit-path' => 'කෝෂ්ඨාගාර පථය:',
	'repoadmin-edit-bug' => 'බග්සිලා පථය:',
	'repoadmin-edit-view' => 'VC පථය නරඹන්න:',
	'repoadmin-edit-button' => 'හරි',
	'repoadmin-edit-sucess' => '"[[Special:Code/$1|$1]]" කෝෂ්ඨාගාරය සාර්ථකව වෙනස් කරන ලදී.',
	'repoadmin-nav' => 'කෝෂ්ඨාගාර පරිපාලකත්වය',
	'right-repoadmin' => 'කේත කෝෂ්ඨාගාරයන් කළමනාකරණය කරන්න',
	'right-codereview-use' => 'විශේෂයේ භාවිතාව:කේතය',
	'right-codereview-add-tag' => 'සංශෝධන සඳහා නව ටැගයන් එක් කරන්න',
	'right-codereview-remove-tag' => 'සංශෝධනයන්ගෙන් ටැගයන් ඉවත් කරන්න',
	'right-codereview-post-comment' => 'සංශෝධන මත පරිකථන එක් කරන්න',
	'right-codereview-set-status' => 'සංශෝධනවල තත්වය වෙනස් කරන්න',
	'right-codereview-signoff' => 'සංශෝධන වලින් නික්මෙන්න',
	'right-codereview-link-user' => 'විකි පරිශීලකයන් වෙත කතුවරුන් සම්බන්ධ කරන්න',
	'right-codereview-associate' => 'සංශෝධන ආශ්‍රයන් කළමනාකරණය කරන්න',
	'specialpages-group-developer' => 'සංවර්ධක මෙවලම්',
	'group-svnadmins' => 'පරිපාලකවරු',
	'group-svnadmins-member' => '{{GENDER:$1|SVN පරිපාලක}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN පරිපාලකවරු',
);

/** Slovak (Slovenčina)
 * @author Helix84
 * @author Jkjk
 * @author Mormegil
 * @author Pitr2311
 */
$messages['sk'] = array(
	'code' => 'Kontrola kódu',
	'code-rev-title' => '$1 - Kontrola kódu',
	'code-comments' => 'Komentáre',
	'code-references' => 'Nadväzujúce revízie',
	'code-change-status' => "zmenil '''stav''' $1",
	'code-change-tags' => "zmenil '''značky''' $1",
	'code-change-removed' => 'odstránené:',
	'code-change-added' => 'pridané:',
	'code-old-status' => 'Starý stav',
	'code-new-status' => 'Nový stav',
	'code-prop-changes' => 'Záznam stavu a značiek',
	'codereview-desc' => '[[Special:Code|Nástroj na kontrolu kódu]] s [[Special:RepoAdmin|podporou Subversion]]',
	'code-no-repo' => 'Nebolo nastavené žiadne úložisko',
	'code-create-repo' => 'Prejsť na [[Special:RepoAdmin|RepoAdmin]] na vytvorenie Úložiska',
	'code-need-repoadmin-rights' => 'Aby ste mohli vytvoriť úložisko, potrebujete práva repoadmin',
	'code-need-group-with-rights' => 'Neexistuje žiadna skupina s právami repoadmin. Prosím, pridajte ju, aby ste mohli pridať nové Úložisko.',
	'code-repo-not-found' => "Úložisko '''$1''' neexistuje!",
	'code-load-diff' => 'Načítava sa rozdiel…',
	'code-notes' => 'posledné komentáre',
	'code-statuschanges' => 'zmeny stavu',
	'code-mycommits' => 'moje začlenenia',
	'code-mycomments' => 'moje komentáre',
	'code-authors' => 'autori',
	'code-status' => 'stavy',
	'code-tags' => 'značky',
	'code-tags-no-tags' => 'V tomto úložisku neexistujú žiadne značky.',
	'code-authors-text' => 'Toto je zoznam autorov v úložisku v poradí podľa posledných začlenení. V zátvorkách sú zobrazené lokálne účty wiki. Dáta môžu pochádzať z vyrovnávacej pamäte.',
	'code-author-haslink' => 'Tento autor je zviazaný s používateľom wiki $1',
	'code-author-orphan' => 'Autor $1 nie je prepojený so žiadnym účtom wiki',
	'code-author-dolink' => 'Zviazať tohto autora s používateľom wiki:',
	'code-author-alterlink' => 'Zmeniť používateľa wiki viazaného s týmto autorom:',
	'code-author-orunlink' => 'Alebo zrušiť väzbu tohto používateľa wiki:',
	'code-author-name' => 'Zadajte používateľské meno:',
	'code-author-success' => 'Autor $1 bol zviazaný s používateľom wiki $2',
	'code-author-link' => 'zviazať?',
	'code-author-unlink' => 'zrušiť väzbu?',
	'code-author-unlinksuccess' => 'Väzba autora $1 bola zrušená',
	'code-author-badtoken' => 'Chyba relácie pri pokuse o vykonanie operácie.',
	'code-author-total' => 'Celkový počet autorov: $1',
	'code-author-lastcommit' => 'Dátum posledného začlenenia',
	'code-browsing-path' => "Prehliadajú sa revízie v '''$1'''",
	'code-field-id' => 'Revízia',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Komentoval',
	'code-field-message' => 'Zhrnutie commitu',
	'code-field-status' => 'Stav',
	'code-field-status-description' => 'Popis stavu',
	'code-field-timestamp' => 'Dátum',
	'code-field-comments' => 'Komentáre',
	'code-field-path' => 'Cesta',
	'code-field-text' => 'Poznámka',
	'code-field-select' => 'Vybrať',
	'code-reference-remove' => 'Odstrániť vybrané združenia',
	'code-reference-associate' => 'Združiť nadväzujúcu revíziu:',
	'code-reference-associate-submit' => 'Združiť',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Dátum:',
	'code-rev-message' => 'Komentár:',
	'code-rev-repo' => 'Úložisko:',
	'code-rev-rev' => 'Revízia:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Zmenené cesty:',
	'code-rev-modified-a' => 'pridané',
	'code-rev-modified-r' => 'nahradené',
	'code-rev-modified-d' => 'zmazané',
	'code-rev-modified-m' => 'zmenené',
	'code-rev-imagediff' => 'Zmeny obrázka',
	'code-rev-status' => 'Stav:',
	'code-rev-status-set' => 'Zmeniť stav',
	'code-rev-tags' => 'Značky:',
	'code-rev-tag-add' => 'Pridať značky:',
	'code-rev-tag-remove' => 'Odstrániť značky:',
	'code-rev-comment-by' => 'Komentár od $1',
	'code-rev-comment-preview' => 'Náhľad',
	'code-rev-inline-preview' => 'Náhľad:',
	'code-rev-diff' => 'Rozdiel',
	'code-rev-diff-link' => 'rozdiel',
	'code-rev-diff-too-large' => 'Rozdiel je príliš veľký aby ho bolo možné zobraziť.',
	'code-rev-purge-link' => 'vyčistiť',
	'code-rev-total' => 'Celkový počet výsledkov: $1',
	'code-rev-not-found' => "Revízia '''$1''' neexistuje!",
	'code-status-new' => 'nový',
	'code-status-desc-new' => 'Revízia čaká na vykonanie operácie (štandardný stav).',
	'code-status-fixme' => 'fixme',
	'code-status-desc-fixme' => 'Táto revízia obsahovala novú chybu alebo je nefunkčná. Preto by mala byť opravená alebo vrátená späť.',
	'code-status-reverted' => 'vrátené',
	'code-status-desc-reverted' => 'Revízia bola odstránená neskoršou revíziou.',
	'code-status-resolved' => 'vyriešené',
	'code-status-desc-resolved' => 'Revízia mala problém, ktorým sa zaoberala neskoršia revízia.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revízia bola úplne skontrolovaná a kontrolór si je istý, že je v poriadku vo všetkých smeroch.',
	'code-status-deferred' => 'oddialené',
	'code-status-desc-deferred' => 'Revízia nevyžaduje kontrolu.',
	'code-status-old' => 'stará',
	'code-status-desc-old' => 'Stará revízia, ktorá môže obsahovať chyby, ale nestojí za snahu skontrolovať ju.',
	'code-signoffs' => 'Schválenia',
	'code-signoff-legend' => 'Pridať schválenie',
	'code-signoff-submit' => 'Schváliť',
	'code-signoff-strike' => 'Vyškrtnúť vybrané schválenia',
	'code-signoff-signoff' => 'Schváliť túto revíziu ako:',
	'code-signoff-flag-inspected' => 'Skontrolované',
	'code-signoff-flag-tested' => 'Otestované',
	'code-signoff-field-user' => 'Používateľ',
	'code-signoff-field-flag' => 'Príznak',
	'code-signoff-field-date' => 'Dátum',
	'code-signoff-struckdate' => '$1 (vyškrtnuté $2)',
	'code-pathsearch-legend' => 'Hľadať revízie v tomto úložisku podľa cesty',
	'code-pathsearch-path' => 'Cesta:',
	'code-pathsearch-filter' => 'Zobraziť len:',
	'code-revfilter-cr_status' => 'Stav = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-clear' => 'Vyčistiť filter',
	'code-rev-submit' => 'Uložiť zmeny',
	'code-rev-submit-next' => 'Uložiť & ďalší nevyriešený',
	'code-batch-status' => 'Zmeniť stav:',
	'code-batch-tags' => 'Zmeniť značky:',
	'codereview-batch-title' => 'Zmeniť všetky vybrané revízie',
	'codereview-batch-submit' => 'Odoslať',
	'code-releasenotes' => 'poznámky k vydaniu',
	'code-release-legend' => 'Vytvoriť poznámky k vydaniu',
	'code-release-startrev' => 'Počiatočná rev.:',
	'code-release-endrev' => 'Posledná rev.:',
	'codereview-subtitle' => 'Pre $1',
	'codereview-reply-link' => 'odpovedať',
	'codereview-email-subj' => '[$1 $2]: Pridaný nový komentár',
	'codereview-email-body' => 'Používateľ „$1” poslal komentár k $3.

Plný URL: $2
Zhrnutie začlenenia:

$5

Komentár:

$4',
	'codereview-email-subj2' => '[$1 $2]: Nadväzujúce zmeny',
	'codereview-email-body2' => 'Používateľ „$1“ urobil v $2 nadväzujúce zmeny.

Plný URL nadväzujúcej revízie: $5
Zhrnutie začlenenia:

$6

Plný URL: $3
Zhrnutie začlenenia:

$4',
	'codereview-email-subj3' => '[$1 $2]: Stav revízie sa zmenil',
	'codereview-email-body3' => 'Používateľ „$1“ zmenil stav $2.

Starý stav: $3
Nový stav:  $4

Plný URL: $5
Zhrnutie začlenenia:

$6',
	'codereview-email-subj4' => '[$1 $2]: Pridaný nový komentár a zmenený stav revízie',
	'codereview-email-body4' => 'Používateľ „$1“ zmenil stav $2.

Starý stav: $3
Nový stav: $4

Používateľ „$1“ tiež pridal komentár k $2.

Plný URL: $5

Zhrnutie začlenenia:

$7

Komentár:

$6',
	'code-stats' => 'štatistika',
	'code-stats-header' => 'Štatistika úložiska $1',
	'code-stats-main' => '$1, úložisko má $2 {{PLURAL:$2|revíziu|revízie|revízií}} od [[Special:Code/$3/author|$4 {{PLURAL:$4|autora|autorov}}]].',
	'code-stats-status-breakdown' => 'Počet revízií na stav',
	'code-stats-fixme-breakdown' => 'Rozloženie fixme podľa autora',
	'code-stats-count' => 'Počet revízií',
	'repoadmin' => 'Správa úložiska',
	'repoadmin-new-legend' => 'Vytvoriť nové úložisko',
	'repoadmin-new-label' => 'Názov úložiska',
	'repoadmin-new-button' => 'Vytvoriť',
	'repoadmin-edit-legend' => 'Zmena úložiska „$1”',
	'repoadmin-edit-path' => 'Cesta k úložisku:',
	'repoadmin-edit-bug' => 'Cesta k Bugzille:',
	'repoadmin-edit-view' => 'Cesta k ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Úložisko „[[Special:Code/$1|$1]]” bolo úspešne zmenené.',
	'repoadmin-nav' => 'Správa úložiska',
	'right-repoadmin' => 'Spravovať úložiská kódu',
	'right-codereview-use' => 'Použitie Special:Code',
	'right-codereview-add-tag' => 'Pridať revíziám nové značky',
	'right-codereview-remove-tag' => 'Odstrániť značky z revízií',
	'right-codereview-post-comment' => 'Pridať revíziám komentáre',
	'right-codereview-set-status' => 'Zmeniť stav revízií',
	'right-codereview-signoff' => 'Schváliť revízie',
	'right-codereview-link-user' => 'Zviazať autorov s používateľmi wiki',
	'right-codereview-associate' => 'Spravovať združenia revízií',
	'right-codereview-review-own' => 'Označiť vlastné revízie ako OK',
	'specialpages-group-developer' => 'Nástroje vývojárov',
	'group-svnadmins' => 'správcovia SVN',
	'group-svnadmins-member' => 'správca SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Správcovia SVN',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'code' => 'Pregled kode',
	'code-rev-title' => '$1 – Pregled kode',
	'code-comments' => 'Pripombe',
	'code-references' => 'Nadaljnje redakcije',
	'code-referenced' => 'Sledeče redakcije',
	'code-change-status' => "je spremenil(-a) '''stanje''' $1",
	'code-change-tags' => "je spremenil(-a) '''oznake''' $1",
	'code-change-removed' => 'odstranjeno:',
	'code-change-added' => 'dodano:',
	'code-old-status' => 'Staro stanje',
	'code-new-status' => 'Novo stanje',
	'code-prop-changes' => 'Dnevnik stanj in označevanj',
	'codereview-desc' => '[[Special:Code|Orodje za pregledovanje kode]] s [[Special:RepoAdmin|podporo Subversion]]',
	'code-no-repo' => 'Nastavljena ni nobena shramba!',
	'code-create-repo' => 'Pojdite na [[Special:RepoAdmin|RepoAdmin]] za ustvarjanje varne hrambe',
	'code-need-repoadmin-rights' => 'za ustvarjanje varne hrambe so potrebne pravice repoadmin',
	'code-need-group-with-rights' => 'Nobena skupina s pravicami repoadmin ne obstaja. Prosimo, dodajte eno, da boste lahko dodali novo varno hrambo.',
	'code-repo-not-found' => "Shramba '''$1''' ne obstaja!",
	'code-load-diff' => 'Nalaganje primerjave ...',
	'code-notes' => 'nedavne pripombe',
	'code-statuschanges' => 'spremembe stanj',
	'code-mycommits' => 'moji prispevki',
	'code-mycomments' => 'moje pripombe',
	'code-authors' => 'avtorji',
	'code-status' => 'stanja',
	'code-tags' => 'oznake',
	'code-tags-no-tags' => 'V tej shrambi ne obstaja nobena oznaka.',
	'code-authors-text' => 'Spodaj je seznam avtorjev shrambe razporejenih po prispevajočem imenu. Lokalni wikiračuni so prikazani v oklepajih. Podatki so lahko predpomnjeni.',
	'code-author-haslink' => 'Ta avtor je povezan z wikiuporabnikom $1',
	'code-author-orphan' => 'Uporabnik SVN/Avtor $1 ni povezan z wikiračunom',
	'code-author-dolink' => 'Poveži tega avtorja z wikiuporabnikom:',
	'code-author-alterlink' => 'Spremeni wikiuporabnika, povezanega s tem avtorjem:',
	'code-author-orunlink' => 'Ali odstrani povezavo tega wikiuporabnika:',
	'code-author-name' => 'Vnesite uporabniško ime:',
	'code-author-success' => 'Avtor $1 je bil povezan z wikiuporabnikom $2',
	'code-author-link' => 'povežem?',
	'code-author-unlink' => 'odstranim povezavo?',
	'code-author-unlinksuccess' => 'Avtorju $1 je bila odstranjena povezava',
	'code-author-badtoken' => 'Napaka seje med poskušanjem izvedbe dejanja.',
	'code-author-total' => 'Skupno število avtorjev: $1',
	'code-author-lastcommit' => 'Datum zadnjega prispevka',
	'code-browsing-path' => "Brskanje po redakcijah v '''$1'''",
	'code-field-id' => 'Redakcija',
	'code-field-author' => 'Avtor',
	'code-field-user' => 'Komentator',
	'code-field-message' => 'Prispevan povzetek',
	'code-field-status' => 'Stanje',
	'code-field-status-description' => 'Opis stanja',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Pripombe',
	'code-field-path' => 'Pot',
	'code-field-text' => 'Beležka',
	'code-field-select' => 'Izberi',
	'code-reference-remove' => 'Odstrani izbrane povezave',
	'code-reference-associate' => 'Poveži nadaljnjo redakcijo:',
	'code-reference-associate-submit' => 'Povezave',
	'code-rev-author' => 'Avtor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Pripomba:',
	'code-rev-repo' => 'Shramba:',
	'code-rev-rev' => 'Redakcija:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Spremenjene poti:',
	'code-rev-modified-a' => 'dodano',
	'code-rev-modified-r' => 'zamenjano',
	'code-rev-modified-d' => 'izbrisano',
	'code-rev-modified-m' => 'spremenjeno',
	'code-rev-imagediff' => 'Spremembe slik',
	'code-rev-status' => 'Stanje:',
	'code-rev-status-set' => 'Spremeni stanje',
	'code-rev-tags' => 'Oznake:',
	'code-rev-tag-add' => 'Dodaj oznake:',
	'code-rev-tag-remove' => 'Odstrani oznake:',
	'code-rev-comment-by' => 'Pripomba $1',
	'code-rev-comment-preview' => 'Predogled',
	'code-rev-inline-preview' => 'Predogled:',
	'code-rev-diff' => 'Prim',
	'code-rev-diff-link' => 'prim',
	'code-rev-diff-too-large' => 'Primerjava je preobsežna za prikaz.',
	'code-rev-purge-link' => 'počisti',
	'code-rev-total' => 'Skupno število rezultatov: $1',
	'code-rev-not-found' => "Redakcija '''$1''' ne obstaja!",
	'code-rev-history-link' => 'zgodovina',
	'code-status-new' => 'novo',
	'code-status-desc-new' => 'Redakcija izvaja dejanje (privzeto stanje).',
	'code-status-fixme' => 'popravi me',
	'code-status-desc-fixme' => 'Redakcija je uvedla hrošč ali pa je pokvarjena. To je treba popraviti ali povrniti.',
	'code-status-reverted' => 'vrnjeno',
	'code-status-desc-reverted' => 'Redakcijo je zavrgla poznejša redakcija.',
	'code-status-resolved' => 'razrešeno',
	'code-status-desc-resolved' => 'Redakcija je imela težavo, ki je bila obravnavana v poznejši redakciji.',
	'code-status-ok' => 'v redu',
	'code-status-desc-ok' => 'Redakcija je v celoti pregledana in pregledovalec je prepričan, da je v redu v vseh pogledih.',
	'code-status-deferred' => 'odloženo',
	'code-status-desc-deferred' => 'Redakcija ne potrebuje pregleda.',
	'code-status-old' => 'staro',
	'code-status-desc-old' => 'Stara redakcija z morebitnimi hrošči, ki niso vredni truda pregleda.',
	'code-signoffs' => 'Odobritve',
	'code-signoff-legend' => 'Dodajte odobritev',
	'code-signoff-submit' => 'Odobri',
	'code-signoff-strike' => 'Udari izbrane odobritve',
	'code-signoff-signoff' => 'Odobri to redakcijo kot:',
	'code-signoff-flag-inspected' => 'Pregledano',
	'code-signoff-flag-tested' => 'Preizkušeno',
	'code-signoff-field-user' => 'Uporabnik',
	'code-signoff-field-flag' => 'Oznaka',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (udarjeno $2)',
	'code-pathsearch-legend' => 'Iskanje redakcij v tej shrambi po poti',
	'code-pathsearch-path' => 'Pot:',
	'code-pathsearch-filter' => 'Prikaži samo:',
	'code-revfilter-cr_status' => 'Stanje = $1',
	'code-revfilter-cr_author' => 'Avtor = $1',
	'code-revfilter-ct_tag' => 'Oznaka = $1',
	'code-revfilter-clear' => 'Počisti filter',
	'code-rev-submit' => 'Shrani spremembe',
	'code-rev-submit-next' => 'Shrani in pojdi na naslednjo nerazrešeno',
	'code-rev-next' => 'Naslednje nerazrešeno',
	'code-batch-status' => 'Spremeni stanje:',
	'code-batch-tags' => 'Spremeni oznake:',
	'codereview-batch-title' => 'Spremeni vse izbrane redakcije',
	'codereview-batch-submit' => 'Pošlji',
	'code-releasenotes' => 'opombe ob izidu',
	'code-release-legend' => 'Ustvari opombe ob izidu',
	'code-release-startrev' => 'Začetna redakcija:',
	'code-release-endrev' => 'Končna redakcija:',
	'codereview-subtitle' => 'Za $1',
	'codereview-reply-link' => 'odgovori',
	'codereview-overview-title' => 'Pregled',
	'codereview-overview-desc' => 'Prikaži grafični pregled seznama',
	'codereview-email-subj' => '[$1 $2]: Dodana nova pripomba',
	'codereview-email-body' => 'Uporabnik »$1« je objavil pripombo na $3.

Polni URL: $2
Prispevani povzetek:

$5

Pripomba:

$4',
	'codereview-email-subj2' => '[$1 $2]: Nadaljnje spremembe',
	'codereview-email-body2' => 'Uporabnik »$1« je naredil nadaljnje spremembe $2.

Polni URL nadaljnjih redakcij: $5
Prispevani povzetek:

$6

Polni URL: $3
Prispevani povzetek:

$4',
	'codereview-email-subj3' => '[$1 $2]: Stanje redakcije je bilo spremenjeno',
	'codereview-email-body3' => 'Uporabnik »$1« je spremenil stanje $2.

Staro stanje: $3
Novo stanje: $4

Polni URL: $5
Prispevani povzetek:

$6',
	'codereview-email-subj4' => '[$1 $2]: Dodana je bil nova pripomba in spremenjeno je bilo stanje redakcije',
	'codereview-email-body4' => 'Uporabnik »$1« je spremenil stanje $2.

Staro stanje: $3
Novo stanje: $4

Uporabnik »$1« je tudi objavil pripombo na $2.

Polni URL: $5
Prispevani povzetek:

$7

Pripomba:

$6',
	'code-stats' => 'statistike',
	'code-stats-header' => 'Statistike shrambe $1',
	'code-stats-main' => 'Dne $1 ima shramba $2 {{PLURAL:$2|redakcijo|redakciji|redakcije|redakcij}} od [[Special:Code/$3/author|$4 {{PLURAL:$4|avtorja|avtorjev}}]].',
	'code-stats-status-breakdown' => 'Število redakcij glede na stanje',
	'code-stats-fixme-breakdown' => 'Razčlenitev redakcij »popravi me« po avtorju',
	'code-stats-fixme-breakdown-path' => 'Razčlenitev redakcij »popravi me« po poti',
	'code-stats-fixme-path' => 'Redakcije »popravi me« za pot: $1',
	'code-stats-new-breakdown' => 'Razčlenitev novih redakcij po avtorju',
	'code-stats-new-breakdown-path' => 'Razčlenitev novih redakcij po poti',
	'code-stats-new-path' => 'Nove redakcije poti: $1',
	'code-stats-count' => 'Število redakcij',
	'code-tooltip-withsummary' => 'r$1 [$2] od $3 – $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] od $3',
	'repoadmin' => 'Upravljanje shramb',
	'repoadmin-new-legend' => 'Ustvari novo shrambo',
	'repoadmin-new-label' => 'Ime shrambe:',
	'repoadmin-new-button' => 'Ustvari',
	'repoadmin-edit-legend' => 'Spreminjanje shrambe »$1«',
	'repoadmin-edit-path' => 'Pot shrambe:',
	'repoadmin-edit-bug' => 'Pot Bugzilla:',
	'repoadmin-edit-view' => 'Pot ViewVC:',
	'repoadmin-edit-button' => 'V redu',
	'repoadmin-edit-sucess' => 'Shramba »[[Special:Code/$1|$1]]« je bila uspešno spremenjena.',
	'repoadmin-nav' => 'upravljanje shramb',
	'right-repoadmin' => 'Upravljanje shramb kode',
	'right-codereview-use' => 'Uporaba Special:Code',
	'right-codereview-add-tag' => 'Dodajanje novih oznak redakcijam',
	'right-codereview-remove-tag' => 'Odstranjevanje novih oznak redakcijam',
	'right-codereview-post-comment' => 'Dodajanje pripomb na redakcije',
	'right-codereview-set-status' => 'Spreminjanje stanj redakcij',
	'right-codereview-signoff' => 'Odobritev redakcij',
	'right-codereview-link-user' => 'Povezovanje avtorjev z wikiuporabniki',
	'right-codereview-associate' => 'Upravljanje združitev redakcij',
	'right-codereview-review-own' => 'Označite svoje redakcije kot v redu ali razrešene',
	'specialpages-group-developer' => 'Razvijalska orodja',
	'group-svnadmins' => 'Skrbniki SVN',
	'group-svnadmins-member' => '{{GENDER:$1|skrbnik|skrbnica}} SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Skrbniki SVN',
);

/** Albanian (Shqip)
 * @author Mikullovci11
 * @author Olsi
 */
$messages['sq'] = array(
	'group-svnadmins' => 'Administruesit SVN',
	'group-svnadmins-member' => 'administrues SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Administruesit SVN',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Nikola Smolenski
 * @author Rancher
 * @author Јованвб
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'code' => 'Преглед кода',
	'code-rev-title' => '$1 – преглед кода',
	'code-comments' => 'Коментари',
	'code-references' => 'Накнадне измене',
	'code-change-status' => "променио '''статус''' за $1",
	'code-change-tags' => "промени '''ознаке''' за $1",
	'code-change-removed' => 'уклоњено:',
	'code-change-added' => 'додато:',
	'code-old-status' => 'Стари статус',
	'code-new-status' => 'Нови статус',
	'code-prop-changes' => 'Историја статуса и ознака',
	'codereview-desc' => '[[Special:Code|Алатка за преглед кода]] с [[Special:RepoAdmin|подршком за Субверзију]]',
	'code-no-repo' => 'Ризница није подешена.',
	'code-create-repo' => 'Идите на [[Special:RepoAdmin|RepoAdmin]] да направите ризницу',
	'code-need-repoadmin-rights' => 'да бисте направили ризницу, потребна су вам администраторска права',
	'code-need-group-with-rights' => 'Не постоје групе с администраторским правима. Направите такву групу да бисте могли да додате нову ризницу',
	'code-repo-not-found' => "Ризница '''$1''' не постоји.",
	'code-load-diff' => 'Учитавам разлику…',
	'code-notes' => 'скорашњи коментари',
	'code-statuschanges' => 'промене стања',
	'code-mycommits' => 'моји доприноси',
	'code-mycomments' => 'моји коментари',
	'code-authors' => 'аутори',
	'code-status' => 'стања',
	'code-tags' => 'ознаке',
	'code-tags-no-tags' => 'У овој ризници нема ознака.',
	'code-author-haslink' => 'Овај аутор је повезан са Вики-корисником $1',
	'code-author-orphan' => 'SVN {{GENDER:$1|корисник ($1) није повезан|корисница ($1) није повезана|корисник ($1) није повезан}} с вики налогом',
	'code-author-dolink' => 'Повежите овог аутора са Вики-корисником:',
	'code-author-alterlink' => 'Промените Вики корисника повезаног са овим аутором:',
	'code-author-orunlink' => 'Или уклоните везу овог корисника:',
	'code-author-name' => 'Унесите корисничко име:',
	'code-author-success' => 'Аутор $1 је био повезан са Вики-корисником $2',
	'code-author-link' => 'додати везу?',
	'code-author-unlink' => 'уклонити везу?',
	'code-author-unlinksuccess' => 'Уклоњена је веза до аутора $1',
	'code-author-badtoken' => 'Дошло је до грешке у сесији при извршавању радње.',
	'code-author-total' => 'Укупан број аутора: $1',
	'code-author-lastcommit' => 'Датум последњег слања',
	'code-browsing-path' => "Прегледање измена у '''$1'''",
	'code-field-id' => 'Измена',
	'code-field-author' => 'Аутор',
	'code-field-user' => 'Коментатор',
	'code-field-message' => 'Пошаљи опис',
	'code-field-status' => 'Статус',
	'code-field-status-description' => 'Опис стања',
	'code-field-timestamp' => 'Датум',
	'code-field-comments' => 'Коментари',
	'code-field-path' => 'Путања',
	'code-field-text' => 'Белешка',
	'code-field-select' => 'Изабери',
	'code-reference-remove' => 'Уклони изабрана повезивања',
	'code-reference-associate' => 'Повезане праћене измене:',
	'code-reference-associate-submit' => 'Повежи',
	'code-rev-author' => 'Аутор:',
	'code-rev-date' => 'Датум:',
	'code-rev-message' => 'Коментар:',
	'code-rev-repo' => 'Остава:',
	'code-rev-rev' => 'Измена:',
	'code-rev-rev-viewvc' => 'на ViewVC',
	'code-rev-paths' => 'Измењене путање:',
	'code-rev-modified-a' => 'додато',
	'code-rev-modified-r' => 'замењено',
	'code-rev-modified-d' => 'обрисано',
	'code-rev-modified-m' => 'измењено',
	'code-rev-imagediff' => 'Измене слика',
	'code-rev-status' => 'Статус:',
	'code-rev-status-set' => 'Измени статус',
	'code-rev-tags' => 'Ознаке:',
	'code-rev-tag-add' => 'Додај ознаке:',
	'code-rev-tag-remove' => 'Уклони ознаке:',
	'code-rev-comment-by' => 'Прокоментарисао/-ла $1',
	'code-rev-comment-preview' => 'Прикажи',
	'code-rev-inline-preview' => 'Преглед:',
	'code-rev-diff' => 'Разл',
	'code-rev-diff-link' => 'разл',
	'code-rev-diff-too-large' => 'Разлика је превелика да би била приказана.',
	'code-rev-purge-link' => 'очисти',
	'code-rev-total' => 'Укупно резултата: $1',
	'code-rev-not-found' => "Измена '''$1''' не постоји.",
	'code-rev-history-link' => 'историја',
	'code-status-new' => 'нов',
	'code-status-desc-new' => 'Измена чека на радњу (подразумевано стање).',
	'code-status-fixme' => 'поправи ме',
	'code-status-reverted' => 'враћено',
	'code-status-desc-reverted' => 'Измена је одбачена од стране новије измене.',
	'code-status-resolved' => 'решено',
	'code-status-ok' => 'ок',
	'code-status-deferred' => 'одложено',
	'code-status-desc-deferred' => 'Измена не захтева преглед.',
	'code-status-old' => 'старо',
	'code-signoffs' => 'Завршеци',
	'code-signoff-legend' => 'Додај завршетак',
	'code-signoff-submit' => 'Завршетак',
	'code-signoff-strike' => 'Прецртај изабрана завршетка',
	'code-signoff-signoff' => 'Одобри ову измену као:',
	'code-signoff-flag-inspected' => 'Проверено',
	'code-signoff-flag-tested' => 'Тестирано',
	'code-signoff-field-user' => 'Корисник',
	'code-signoff-field-flag' => 'Ознака',
	'code-signoff-field-date' => 'Датум',
	'code-signoff-struckdate' => '$1 (поништено $2)',
	'code-pathsearch-legend' => 'Претрага измена у овој остави преко путање',
	'code-pathsearch-path' => 'Путања:',
	'code-pathsearch-filter' => 'Прикажи само:',
	'code-revfilter-cr_status' => 'Статус = $1',
	'code-revfilter-cr_author' => 'Аутор – $1',
	'code-revfilter-ct_tag' => 'Ознака – $1',
	'code-revfilter-clear' => 'Очисти филтер',
	'code-rev-submit' => 'Сачувај измене',
	'code-rev-submit-next' => 'Сачувај и прикажи следеће нерешено',
	'code-rev-next' => 'Следећи нерешени',
	'code-batch-status' => 'Измени статус:',
	'code-batch-tags' => 'Измени ознаке:',
	'codereview-batch-title' => 'Промени све изабране измене',
	'codereview-batch-submit' => 'Пошаљи',
	'code-releasenotes' => 'белешке издања',
	'code-release-legend' => 'Стварање белешки издања',
	'code-release-startrev' => 'Почетна ревизија:',
	'code-release-endrev' => 'Последња ревизија:',
	'codereview-subtitle' => 'За $1',
	'codereview-reply-link' => 'одговори',
	'codereview-overview-title' => 'Преглед',
	'codereview-email-subj' => '[$1 $2]: Нови коментар додат',
	'codereview-email-subj2' => '[$1 $2]: Следеће измене',
	'codereview-email-subj3' => '[$1 $2]: Промена стања измене',
	'codereview-email-subj4' => '[$1 $2]: Додат је нови коментар и промењено је стање измене',
	'code-stats' => 'статистика',
	'code-stats-header' => 'Статистика за оставу $1',
	'code-stats-status-breakdown' => 'Број измена по стању',
	'code-stats-count' => 'Број измена',
	'code-tooltip-withsummary' => 'r$1 [$2] од $3 – $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] од $3',
	'repoadmin-new-button' => 'Направи',
	'repoadmin-edit-path' => 'Путања оставе:',
	'repoadmin-edit-bug' => 'Путања до Багзиле:',
	'repoadmin-edit-view' => 'ViewVC путања:',
	'repoadmin-edit-button' => 'У реду',
	'repoadmin-edit-sucess' => 'Остава „[[Special:Code/$1|$1]]“ је успешно измењена.',
	'repoadmin-nav' => 'администрација оставе',
	'right-repoadmin' => 'управљање кодом остава',
	'right-codereview-use' => 'Коришћење Special:Code',
	'right-codereview-add-tag' => 'додавање нових ознака на измене',
	'right-codereview-remove-tag' => 'брисање ознака из измена',
	'right-codereview-post-comment' => 'Додајте коментаре ревизијама',
	'right-codereview-set-status' => 'Промени статус ревизије',
	'specialpages-group-developer' => 'Програмерски алати',
);

/** Serbian (Latin script) (‪Srpski (latinica)‬)
 * @author Michaello
 * @author Rancher
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'code-comments' => 'Komentari',
	'code-change-status' => "promenio '''status''' za $1",
	'code-change-tags' => "promenio '''tagove''' za $1",
	'code-change-removed' => 'uklonjeno:',
	'code-change-added' => 'dodato:',
	'code-old-status' => 'Stari status',
	'code-new-status' => 'Novi status',
	'code-prop-changes' => 'Istorija statusa i tagovanja',
	'code-load-diff' => 'Učitavanje difa…',
	'code-notes' => 'skorašnji komentari',
	'code-statuschanges' => 'promene statusa',
	'code-authors' => 'autori',
	'code-status' => 'stanja',
	'code-tags' => 'tagovi',
	'code-author-haslink' => 'Ovaj autor je povezan sa Viki-korisnikom $1',
	'code-author-orphan' => 'SVN {{GENDER:$1|korisnik ($1) nije povezan|korisnica ($1) nije povezana|korisnik ($1) nije povezan}} s viki nalogom',
	'code-author-dolink' => 'Povežite ovog autora sa Viki-korisnikom:',
	'code-author-alterlink' => 'Promenite Viki korisnika povezanog sa ovim autorom:',
	'code-author-orunlink' => 'Ili uklonite vezu ovog korisnika:',
	'code-author-name' => 'Unesite korisničko ime:',
	'code-author-success' => 'Autor $1 je bio povezan sa Viki-korisnikom $2',
	'code-author-link' => 'linkovati?',
	'code-author-unlink' => 'delinkovati?',
	'code-author-unlinksuccess' => 'Autor $1 je bio delinkovan',
	'code-author-total' => 'Ukupan broj autora: $1',
	'code-author-lastcommit' => 'Datum poslednjeg slanja',
	'code-field-id' => 'Izmena',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Komentator',
	'code-field-message' => 'Pošalji opis',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Opis stanja',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Komentari',
	'code-field-path' => 'Putanja',
	'code-field-text' => 'Napomena',
	'code-field-select' => 'Izaberi',
	'code-reference-remove' => 'Ukloni izabrana povezivanja',
	'code-reference-associate' => 'Povezane praćene izmene:',
	'code-reference-associate-submit' => 'Poveži',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Komentar:',
	'code-rev-repo' => 'Ostava:',
	'code-rev-rev' => 'Izmena:',
	'code-rev-rev-viewvc' => 'na ViewVC',
	'code-rev-paths' => 'Izmenjene putanje:',
	'code-rev-modified-a' => 'dodato',
	'code-rev-modified-r' => 'zamenjeno',
	'code-rev-modified-d' => 'obrisano',
	'code-rev-modified-m' => 'izmenjeno',
	'code-rev-imagediff' => 'Izmene slika',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Izmeni status',
	'code-rev-tags' => 'Tagovi:',
	'code-rev-tag-add' => 'Dodaj tagove:',
	'code-rev-tag-remove' => 'Izbriši tagove:',
	'code-rev-comment-by' => 'Komantarisao $1',
	'code-rev-comment-preview' => 'Prikaži',
	'code-rev-inline-preview' => 'Pregled:',
	'code-rev-diff' => 'Razl',
	'code-rev-diff-link' => 'razl',
	'code-rev-diff-too-large' => 'Razlika je prevelika da bi bila prikazana.',
	'code-rev-purge-link' => 'osveži',
	'code-rev-total' => 'Ukupno rezultata: $1',
	'code-rev-not-found' => "Izmena '''$1''' ne postoji.",
	'code-rev-history-link' => 'istorija',
	'code-status-new' => 'nov',
	'code-status-desc-new' => 'Izmena čeka na radnju (podrazumevano stanje).',
	'code-status-fixme' => 'popravi me',
	'code-status-reverted' => 'vraćeno',
	'code-status-desc-reverted' => 'Izmena je odbačena od strane novije izmene.',
	'code-status-resolved' => 'rešeno',
	'code-status-ok' => 'ok',
	'code-status-deferred' => 'odloženo',
	'code-status-desc-deferred' => 'Izmena ne zahteva pregled.',
	'code-status-old' => 'staro',
	'code-signoffs' => 'Završeci',
	'code-signoff-legend' => 'Dodaj završetak',
	'code-signoff-submit' => 'Završetak',
	'code-signoff-strike' => 'Precrtaj izabrana završetka',
	'code-signoff-signoff' => 'Odobri ovu izmenu kao:',
	'code-signoff-flag-inspected' => 'Provereno',
	'code-signoff-flag-tested' => 'Testirano',
	'code-signoff-field-user' => 'Korisnik',
	'code-signoff-field-flag' => 'Oznaka',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (poništeno $2)',
	'code-pathsearch-legend' => 'Pretraga izmena u ovoj ostavi preko putanje',
	'code-pathsearch-path' => 'Putanja:',
	'code-pathsearch-filter' => 'Prikaži samo:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Autor – $1',
	'code-revfilter-ct_tag' => 'Oznaka – $1',
	'code-revfilter-clear' => 'Očisti filter',
	'code-rev-submit' => 'Zapamti izmene',
	'code-rev-submit-next' => 'Sačuvaj i prikaži sledeće nerešeno',
	'code-rev-next' => 'Sledeći nerešeni',
	'code-batch-status' => 'Izmeni status:',
	'code-batch-tags' => 'Izmeni tagove:',
	'codereview-batch-title' => 'Izmeni sve izabrane revizije',
	'codereview-batch-submit' => 'Pošalji',
	'code-releasenotes' => 'beleške izdanja',
	'code-release-legend' => 'Stvaranje beleški izdanja',
	'code-release-startrev' => 'Početna revizija:',
	'code-release-endrev' => 'Poslednja revizija:',
	'codereview-subtitle' => 'Za $1',
	'codereview-reply-link' => 'odgovori',
	'codereview-overview-title' => 'Pregled',
	'codereview-email-subj' => '[$1 $2]: Novi komentar dodat',
	'codereview-email-subj2' => '[$1 $2]: Sledeće izmene',
	'codereview-email-subj3' => '[$1 $2]: Promena stanja izmene',
	'codereview-email-subj4' => '[$1 $2]: Dodat je novi komentar i promenjeno je stanje izmene',
	'code-stats' => 'statistika',
	'code-stats-header' => 'Statistika za ostavu $1',
	'code-stats-status-breakdown' => 'Broj izmena po stanju',
	'code-stats-count' => 'Broj izmena',
	'code-tooltip-withsummary' => 'r$1 [$2] od $3 – $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] od $3',
	'repoadmin-new-button' => 'Napravi',
	'repoadmin-edit-path' => 'Putanja ostave:',
	'repoadmin-edit-bug' => 'Putanja do Bagzile:',
	'repoadmin-edit-view' => 'ViewVC putanja:',
	'repoadmin-edit-button' => 'U redu',
	'repoadmin-edit-sucess' => 'Ostava „[[Special:Code/$1|$1]]“ je uspešno izmenjena.',
	'repoadmin-nav' => 'administracija ostave',
	'right-repoadmin' => 'upravljanje kodom ostava',
	'right-codereview-use' => 'Korišćenje Special:Code',
	'right-codereview-add-tag' => 'Dodajte tagove revizijama',
	'right-codereview-remove-tag' => 'Brišite tagove sa revizija',
	'right-codereview-post-comment' => 'Dodajte komentare revizijama',
	'right-codereview-set-status' => 'Promeni status revizije',
	'specialpages-group-developer' => 'Programerski alati',
);

/** Seeltersk (Seeltersk)
 * @author Pyt
 */
$messages['stq'] = array(
	'code' => 'Codewröich',
	'code-comments' => 'Kommentoare',
	'code-change-status' => "annerde dän '''Stoatus''' fon Revision $1",
	'code-change-tags' => "annerde do '''Tags''' fon Revision $1",
	'code-change-removed' => 'wächhoald:',
	'code-change-added' => 'bietouföiged:',
	'code-prop-changes' => 'Stoatus- un Tagging-Logbouk',
	'codereview-desc' => '[[Special:Code|Codewröich-Reewe]] mäd [[Special:RepoAdmin|Subversion-Unnerstutsenge]]',
	'code-no-repo' => 'Neen Repositorium konfigurierd!',
	'code-load-diff' => 'Leed Diff …',
	'code-notes' => 'jungste Wröichnotizen',
	'code-authors' => 'Autore',
	'code-status' => 'Stoatus',
	'code-tags' => 'Tags',
	'code-authors-text' => 'Hierunner foulget ne Lieste fon Repositoriumautore, ätter Noomen sortierd. Lokoale Wikikonten wäide in runde Klammere anwiesd. Doaten kuuden uut dän Cache stamme.',
	'code-author-haslink' => 'Dissen Autor is tou dän Wiki-Benutser $1 ferlinked',
	'code-author-orphan' => 'Dissen Autor häd neen Link tou n Wiki-Benutserkonto',
	'code-author-dolink' => 'Dissen Autor tou n Wiki-Benutserkonto ferlinkje:',
	'code-author-alterlink' => 'Ju Ferlinkenge tou n Wiki-Benutserkonto fon dissen Autor annerje:',
	'code-author-orunlink' => 'Ferlinkenge tou dät Wiki-Benutserkonto ferbreeke:',
	'code-author-name' => 'Benutsernoome:',
	'code-author-success' => 'Die Autor $1 wuud mäd dän Wikibenutser $2 ferlinked',
	'code-author-link' => 'ferlinkje?',
	'code-author-unlink' => 'äntlinkje?',
	'code-author-unlinksuccess' => 'Die Autor $1 wuud äntlinked',
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Kommentator',
	'code-field-message' => 'Kommentoar seende',
	'code-field-status' => 'Stoatus',
	'code-field-timestamp' => 'Doatum',
	'code-field-comments' => 'Kommentoare',
	'code-field-path' => 'Paad',
	'code-field-text' => 'Notiz',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Doatum:',
	'code-rev-message' => 'Kommentoar:',
	'code-rev-repo' => 'Repositorium:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'ap ViewVC',
	'code-rev-paths' => 'Annerde Paade:',
	'code-rev-modified-a' => 'bietouföiged',
	'code-rev-modified-r' => 'ärsät',
	'code-rev-modified-d' => 'läsked',
	'code-rev-modified-m' => 'annerd',
	'code-rev-status' => 'Stoatus:',
	'code-rev-status-set' => 'Stoatus annerje',
	'code-rev-tags' => 'Tags:',
	'code-rev-tag-add' => 'Föigje tou Tags:',
	'code-rev-tag-remove' => 'Hoal wäch Tags:',
	'code-rev-comment-by' => 'Kommentoar fon $1',
	'code-rev-comment-preview' => 'Foarbekiek',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'Diff',
	'code-rev-purge-link' => 'Cache läskje',
	'code-status-new' => 'näi',
	'code-status-fixme' => 'fixme',
	'code-status-reverted' => 'aphieuwed',
	'code-status-resolved' => 'oumoaked',
	'code-status-ok' => 'OK',
	'code-status-deferred' => 'touräächstoald',
	'code-pathsearch-legend' => 'Säik in dit Repositorium ätter Versione, per Paad',
	'code-pathsearch-path' => 'Paad:',
	'code-rev-submit' => 'Annerengen spiekerje',
	'code-rev-submit-next' => 'Spiekerje un gung tou n naisten nit-wröigeden',
	'codereview-reply-link' => 'oantwoudje',
	'codereview-email-subj' => '[$1 $2]: Näien Kommentoar bietouföiged',
	'codereview-email-body' => 'Benutser "$1" häd Revision $3 kommentierd:

Fulständige URL: $2
Touhoopefoatenge:

$5

Kommentoar:

$4',
	'repoadmin' => 'Repositoriums-Administration',
	'repoadmin-new-legend' => 'Näi Repositorium moakje',
	'repoadmin-new-label' => 'Noome fon dät Repositorium:',
	'repoadmin-new-button' => 'Moakje',
	'repoadmin-edit-legend' => 'Annerengen an dät Repositorium „$1“',
	'repoadmin-edit-path' => 'Paad tou dät Repositorium:',
	'repoadmin-edit-bug' => 'Paad tou Bugzilla:',
	'repoadmin-edit-view' => 'Paad tou ViewVC:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Dät Repositorium „[[Special:Code/$1|$1]]“ wuud mäd Ärfoulch annerd.',
	'right-repoadmin' => 'Code-Repositorien ferwaltje',
	'right-codereview-add-tag' => 'Bietouföigjen fon näie Tags tou Revisione',
	'right-codereview-remove-tag' => 'Wächhoaljen fon Tags fon Revisione',
	'right-codereview-post-comment' => 'Bietouföigjen fon Kommentoare tou Revisione',
	'right-codereview-set-status' => 'Annerjen fon dän Revisionsstoatus',
	'right-codereview-link-user' => 'Autore ap Wiki-Benutsere ferlinkje',
	'specialpages-group-developer' => 'Äntwiklerreewen',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Cohan
 * @author Dafer45
 * @author Diupwijk
 * @author Fluff
 * @author Gabbe.g
 * @author GameOn
 * @author Lokal Profil
 * @author Najami
 * @author Per
 * @author Rotsee
 * @author Tobulos1
 * @author WikiPhoenix
 */
$messages['sv'] = array(
	'code' => 'Kodgranskning',
	'code-rev-title' => '$1 - kodgranskning',
	'code-comments' => 'Kommentarer',
	'code-references' => 'Uppföljande versioner',
	'code-change-status' => "ändrade '''statusen''' för version $1",
	'code-change-tags' => "ändrade '''taggen''' för version $1",
	'code-change-removed' => 'tog bort:',
	'code-change-added' => 'la till:',
	'code-old-status' => 'Gammal status',
	'code-new-status' => 'Ny status',
	'code-prop-changes' => 'Logg för status & taggning',
	'codereview-desc' => '[[Special:Code|Kodgranskningsverktyg]] med [[Special:RepoAdmin|stöd för Subversion]]',
	'code-no-repo' => 'Ingen databas konfigurerad!',
	'code-repo-not-found' => "Förrådet '''$1''' finns inte!",
	'code-load-diff' => 'Ladda skillnad...',
	'code-notes' => 'senaste kommentarer',
	'code-statuschanges' => 'Statusändringar',
	'code-mycommits' => 'mina insändningar',
	'code-mycomments' => 'mina kommentarer',
	'code-authors' => 'författare',
	'code-status' => 'tillstånd',
	'code-tags' => 'taggar',
	'code-tags-no-tags' => 'Inga taggar finns i denna repository.',
	'code-authors-text' => 'Nedan är en lista av repoförfattare ordnade efter bidragsnamn. Lokala wikikonton visas inom parentes. Data kan vara cachad.',
	'code-author-haslink' => 'Denna författare är länkad till wiki-användaren $1',
	'code-author-orphan' => 'SVN användare/Författare $1 är inte länkad till något wiki-konto',
	'code-author-dolink' => 'Länka denna författare till en wiki-användare :',
	'code-author-alterlink' => 'Ändrade wikianvändaren som är länkad till denna författare:',
	'code-author-orunlink' => 'Eller avlänka denna wikianvändare:',
	'code-author-name' => 'Skriv in ett användarnamn:',
	'code-author-success' => 'Författaren $1 har med framgång länkats till wiki-användaren $2',
	'code-author-link' => 'länk?',
	'code-author-unlink' => 'avlänka?',
	'code-author-unlinksuccess' => 'Författaren $1 har avlänkats',
	'code-author-badtoken' => 'Sessionsfel när åtgärden försökte utföras.',
	'code-author-total' => 'Totalt antal författare: $1',
	'code-author-lastcommit' => 'Senaste bidragsdatum',
	'code-browsing-path' => "Bläddrar igenom revisioner i '''$1'''",
	'code-field-id' => 'Version',
	'code-field-author' => 'Författare',
	'code-field-user' => 'Kommenerare',
	'code-field-message' => 'Spara sammanfattning',
	'code-field-status' => 'Status',
	'code-field-status-description' => 'Statusbeskrivning',
	'code-field-timestamp' => 'Datum',
	'code-field-comments' => 'Kommentarer',
	'code-field-path' => 'Sökväg',
	'code-field-text' => 'Not',
	'code-field-select' => 'Välj',
	'code-reference-remove' => 'Ta bort markerade associationer',
	'code-reference-associate-submit' => 'Associera',
	'code-rev-author' => 'Författare:',
	'code-rev-date' => 'Datum:',
	'code-rev-message' => 'Kommentar:',
	'code-rev-repo' => 'Databas:',
	'code-rev-rev' => 'Version:',
	'code-rev-rev-viewvc' => 'på ViewVC',
	'code-rev-paths' => 'Ändrade sökvägar:',
	'code-rev-modified-a' => 'tillagd',
	'code-rev-modified-r' => 'ersatt',
	'code-rev-modified-d' => 'raderad',
	'code-rev-modified-m' => 'ändrad',
	'code-rev-imagediff' => 'Bildförändringar',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Ändra status',
	'code-rev-tags' => 'Taggar:',
	'code-rev-tag-add' => 'Lägg till taggar:',
	'code-rev-tag-remove' => 'Ta bort taggar:',
	'code-rev-comment-by' => 'Kommentar av $1',
	'code-rev-comment-preview' => 'Förhandsgranska',
	'code-rev-inline-preview' => 'Förhandsgranska:',
	'code-rev-diff' => 'Diff',
	'code-rev-diff-link' => 'diff',
	'code-rev-diff-too-large' => 'Diffen är för stor för att visas.',
	'code-rev-purge-link' => 'rensa',
	'code-rev-total' => 'Totalt antal resultat: $1',
	'code-rev-not-found' => "Revision '''$1''' finns inte!",
	'code-rev-history-link' => 'historik',
	'code-status-new' => 'ny',
	'code-status-desc-new' => 'Revisionen väntar på en åtgärd (standardstatus).',
	'code-status-fixme' => 'fixa-mig',
	'code-status-desc-fixme' => 'Revisionen introducerar en bugg eller är trasig. Det bör rättas till eller återställas.',
	'code-status-reverted' => 'återställd',
	'code-status-desc-reverted' => 'Revisionen kastades bort av en senare revision.',
	'code-status-resolved' => 'löst',
	'code-status-desc-resolved' => 'Revisionen hade ett problem som rättades till i en senare revision.',
	'code-status-ok' => 'ok',
	'code-status-desc-ok' => 'Revisionen fullt genomgången och granskaren är säker på att den är OK på alla sätt.',
	'code-status-deferred' => 'uppskjuten',
	'code-status-desc-deferred' => 'Revisionen kräver inte översyn.',
	'code-status-old' => 'gammal',
	'code-status-desc-old' => 'Gammal revision med potentiella buggar men inte värt bemödandet att se över dem.',
	'code-signoffs' => 'Signeringar',
	'code-signoff-legend' => 'Lägg till signering',
	'code-signoff-submit' => 'Signera',
	'code-signoff-flag-inspected' => 'Inspekterad',
	'code-signoff-flag-tested' => 'Testad',
	'code-signoff-field-user' => 'Användare',
	'code-signoff-field-flag' => 'Flagga',
	'code-signoff-field-date' => 'Datum',
	'code-signoff-struckdate' => '$1 (strök $2)',
	'code-pathsearch-legend' => 'Sök versioner i denna repo efter sökväg',
	'code-pathsearch-path' => 'Sökväg:',
	'code-pathsearch-filter' => 'Visa endast:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Författare = $1',
	'code-revfilter-ct_tag' => 'Tagg = $1',
	'code-revfilter-clear' => 'Rensa filter',
	'code-rev-submit' => 'Spara ändringar',
	'code-rev-submit-next' => 'Spara & nästa olösta',
	'code-rev-next' => 'Nästa olösta',
	'code-batch-status' => 'Ändra status:',
	'code-batch-tags' => 'Ändra taggar:',
	'codereview-batch-title' => 'Ändra alla valda versioner',
	'codereview-batch-submit' => 'Verkställ',
	'code-releasenotes' => 'versionsnoter',
	'code-release-legend' => 'Generera versionsnoter',
	'code-release-startrev' => 'Första revision:',
	'code-release-endrev' => 'Senaste revision:',
	'codereview-subtitle' => 'För $1',
	'codereview-reply-link' => 'svara',
	'codereview-overview-title' => 'Översikt',
	'codereview-overview-desc' => 'Visa en grafisk översikt av denna lista',
	'codereview-email-subj' => '[$1 $2]: Ny kommentar tillagd',
	'codereview-email-body' => 'Användaren "$1" postade en kommenter på $3

Fullständig URL: $2
Bidragssammanfattning:

$5


Kommentar:

$4:',
	'codereview-email-subj2' => '[$1 $2]: Påföljande ändringar',
	'codereview-email-body2' => 'Användare "$1" gjorde påföljande ändringar till $2.

Fullständig URL för påföljande revision: $5
Bidragssammanfattning:

$6

Fullständig URL:  $3
Bidragssammanfattning

$4',
	'codereview-email-subj3' => '[$1 $2]: Versionsstatus ändrad',
	'codereview-email-body3' => "Användare ''$1'' ändrade statusen för $2.

Gammal status: $3
Ny status: $4

Fullständig URL: $5
Bidragssammanfattning:

$6",
	'codereview-email-subj4' => '[$1 $2]: Ny kommentar tillagd, och versionsstatus ändrad',
	'codereview-email-body4' => 'Användare "$1" ändrade statusen för $2.

Gammal status: $3
Ny status: $4

Användare "$1" postade också en kommentar på $2.

Fullständig URL: $5
Bidragssammanfattning:

$7


Kommentar:

$6',
	'code-stats' => 'statistik',
	'code-stats-header' => 'Statistik för repositoriet $1',
	'code-stats-main' => '$1 hade repositoriet $2 {{PLURAL:$2|revision|revisioner}} av [[Special:Code/$3/author|$4 författare]].',
	'code-stats-status-breakdown' => 'Antal revisioner per status',
	'code-stats-fixme-breakdown' => 'Fördelning av fixme-revisioner per författare',
	'code-stats-count' => 'Antal revideringar',
	'code-tooltip-withsummary' => 'r$1 [$2] av $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] av $3',
	'repoadmin' => 'Databasadministration',
	'repoadmin-new-legend' => 'Skapa en ny databas',
	'repoadmin-new-label' => 'Databasnamn:',
	'repoadmin-new-button' => 'Skapa',
	'repoadmin-edit-legend' => 'Ändring av databas "$1"',
	'repoadmin-edit-path' => 'Databas-sökväg:',
	'repoadmin-edit-bug' => 'Bugzilla sökväg:',
	'repoadmin-edit-view' => 'ViewVC sökväg:',
	'repoadmin-edit-button' => 'OK',
	'repoadmin-edit-sucess' => 'Databasen "[[Special:Code/$1|$1]]" har modifierats med framgång.',
	'repoadmin-nav' => 'repositorieadministration',
	'right-repoadmin' => 'Hantera kod-databaser',
	'right-codereview-use' => 'Använda Special:Code',
	'right-codereview-add-tag' => 'Lägga nya taggar till versioner',
	'right-codereview-remove-tag' => 'Ta bort taggar från versioner',
	'right-codereview-post-comment' => 'Lägga till kommentarer till versioner',
	'right-codereview-set-status' => 'Ändra versioners status',
	'right-codereview-signoff' => 'Signera versioner',
	'right-codereview-link-user' => 'Länka författare med wikianvändare',
	'right-codereview-review-own' => 'Märk din egen revidering som OK eller Lösta',
	'specialpages-group-developer' => 'Utvecklarverktyg',
	'group-svnadmins' => 'SVN administratörer',
	'group-svnadmins-member' => '{{GENDER:$1|SVN-administratör}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN administratörer',
);

/** Swahili (Kiswahili)
 * @author Lloffiwr
 */
$messages['sw'] = array(
	'code-change-added' => 'alichangia:',
	'code-field-author' => 'Mwandishi',
	'code-field-status' => 'Hadhi',
	'code-field-timestamp' => 'Tarehe',
	'code-field-comments' => 'Maelezo',
	'code-rev-date' => 'Tarehe:',
	'code-rev-message' => 'Maelezo:',
	'code-rev-modified-a' => 'alichangia',
	'code-rev-modified-m' => 'zilizotengenezwa',
	'code-rev-status' => 'Hadhi:',
	'code-rev-comment-preview' => 'Hakiki',
	'code-rev-diff' => 'Tofauti',
	'code-rev-diff-link' => 'tofauti',
	'codereview-batch-submit' => 'Wasilisha',
	'repoadmin-new-button' => 'Anzisha',
	'repoadmin-edit-button' => 'Sawa',
);

/** Tamil (தமிழ்)
 * @author Shanmugamp7
 * @author TRYPPN
 * @author செல்வா
 */
$messages['ta'] = array(
	'code-comments' => 'கருத்துரைகள்',
	'code-change-removed' => 'நீக்கப்பட்டது:',
	'code-change-added' => 'சேர்க்கப்பட்டது:',
	'code-old-status' => 'பழைய நிலைமை',
	'code-new-status' => 'புதிய நிலைமை',
	'code-notes' => 'சமீபத்திய கருத்துரைகள்',
	'code-statuschanges' => 'நிலையின் மாற்றங்கள்',
	'code-mycommits' => 'எனது ஈடுபாடுகள்',
	'code-mycomments' => 'எனது குறிப்புகள்',
	'code-authors' => 'ஆசிரியர்கள்',
	'code-status' => 'மாநிலங்கள்',
	'code-tags' => 'குறிச்சொற்கள்',
	'code-author-name' => 'பயனர் பெயரொன்றை இடுக:',
	'code-author-link' => 'இணைப்பு?',
	'code-author-unlink' => 'இணைப்பை நீக்கு?',
	'code-author-unlinksuccess' => 'எழுத்தாளர்  $1  இணைப்பு நீக்கப்பட்டது.',
	'code-author-badtoken' => 'அமர்வு பிழை இந்த செயலை செய்ய முயற்சிக்கிறது.',
	'code-author-total' => 'எழுத்தாளர்களின் மொத்த எண்ணிக்கை:$1',
	'code-browsing-path' => " ''' $1 ''' ல் பரிசீலனைகளை மேய்கிறது.",
	'code-field-id' => 'திருத்தம்',
	'code-field-author' => 'ஆசிரியர்',
	'code-field-status' => 'நிலைமை',
	'code-field-status-description' => 'நிலைமை விளக்கம்',
	'code-field-timestamp' => 'தேதி',
	'code-field-comments' => 'கருத்துரைகள்',
	'code-field-path' => 'வழி',
	'code-field-text' => 'குறிப்பு',
	'code-field-select' => 'தேர்வு செய்',
	'code-reference-remove' => 'தேர்ந்தெடுக்கப்பட்ட அமைப்புகளை நீக்கவும்',
	'code-reference-associate-submit' => 'உதவியாளர்',
	'code-rev-author' => 'ஆசிரியர்:',
	'code-rev-date' => 'நாள் (தேதி):',
	'code-rev-message' => 'கருத்து:',
	'code-rev-rev' => 'திருத்தம்:',
	'code-rev-rev-viewvc' => 'ViewVCயில்  உள்ள',
	'code-rev-paths' => 'திருத்தப்பட்ட பாதைகள்:',
	'code-rev-modified-a' => 'சேர்க்கப்பட்டது',
	'code-rev-modified-r' => 'மாற்றப்பட்டது',
	'code-rev-modified-d' => 'நீக்கப்பட்டது',
	'code-rev-modified-m' => 'மாற்றப்பட்டுள்ளது',
	'code-rev-imagediff' => 'உருவ மாற்றங்கள்',
	'code-rev-status' => 'நிலைமை:',
	'code-rev-status-set' => 'நிலைமை மாற்று',
	'code-rev-tags' => 'குறிச்சொற்கள்:',
	'code-rev-tag-add' => 'குறிச்சொற்களை சேர்:',
	'code-rev-tag-remove' => 'குறிச்சொற்களை நீக்கு',
	'code-rev-comment-by' => '$1 மூலம் கருத்து',
	'code-rev-comment-preview' => 'முன்தோற்றம்',
	'code-rev-inline-preview' => 'முன்தோற்றம்:',
	'code-rev-diff' => 'வேறுபாடு',
	'code-rev-diff-link' => 'வேறுபாடு',
	'code-rev-diff-too-large' => 'இந்த வேறுபாடு காண்பிக்க மிக நீளமாக உள்ளது.',
	'code-rev-purge-link' => 'களைக',
	'code-rev-total' => 'முடிவுகளின் மொத்த எண்ணிக்கை :$1',
	'code-rev-not-found' => "பரிசீலனை ''' $1 ''' இல்லை!",
	'code-rev-history-link' => 'வரலாறு',
	'code-status-new' => 'புதிய',
	'code-status-desc-new' => 'பரிசீலனை நிலுவையில் உள்ளது ஒரு செயல் (இயல்பு நிலை) .',
	'code-status-reverted' => 'முன்நிலையாக்கப்பட்டது',
	'code-status-resolved' => 'தீர்வு காணப்பட்டது',
	'code-status-ok' => 'ஆம்',
	'code-status-old' => 'பழைய',
	'code-signoff-flag-tested' => 'சோதனை செய்யப்பட்டது',
	'code-signoff-field-user' => 'பயனர்',
	'code-signoff-field-flag' => 'கொடி',
	'code-signoff-field-date' => 'தேதி',
	'code-pathsearch-path' => 'வழி:',
	'code-revfilter-clear' => 'வடிப்பான்களை துடை',
	'code-rev-submit' => 'மாற்றங்களை சேமி',
	'code-rev-submit-next' => 'சேமி & அடுத்த தீர்க்கப்படாதது',
	'code-rev-next' => 'அடுத்த தீர்க்கப்படாதது',
	'code-batch-status' => 'நிலைமையை மாற்று:',
	'code-batch-tags' => 'குறிச்சொற்களை மாற்று:',
	'codereview-batch-title' => 'எல்லா தேர்ந்தெடுக்கப்பட்ட பரிசீலனைகளையும் மாற்று',
	'codereview-batch-submit' => 'சமர்ப்பி',
	'code-releasenotes' => 'வெளியீட்டு அறிக்கை',
	'code-release-legend' => 'வெளியீட்டு அறிக்கையை உருவாக்கு',
	'codereview-subtitle' => '$1 க்கான',
	'codereview-reply-link' => 'பதில் அளி',
	'codereview-overview-title' => 'மேலோட்டம்',
	'codereview-overview-desc' => 'இந்த பட்டியலின் வரைகலை மேற்பார்வையை காண்பி',
	'codereview-email-subj' => '[ $1  $2 ]:  புதிய கருத்துரை சேர்க்கப்பட்டது.',
	'codereview-email-subj2' => '[ $1  $2 ]: தொடர்செயல் மாற்றங்கள்',
	'code-stats' => 'புள்ளிவிவரங்கள்',
	'repoadmin-new-button' => 'உருவாக்கவும்',
	'repoadmin-edit-button' => 'ஆம்',
	'right-codereview-add-tag' => 'புதிய குறிச்சொற்களை பரிசீலனைகளில் சேர்',
	'right-codereview-remove-tag' => 'பரிசீலனைகளிலிருந்து குறிச்சொற்களை நீக்கு',
	'right-codereview-post-comment' => 'பரிசீலனைகளுக்கு கருத்துரைகளை சேர்',
	'right-codereview-set-status' => 'பரிசீலனைகளுக்காண நிலைமையை மாற்று',
	'right-codereview-link-user' => 'எழுத்தாளர்களை விக்கி பயனர்களுடன் இணை',
);

/** Telugu (తెలుగు)
 * @author C.Chandra Kanth Rao
 * @author Chaduvari
 * @author Kiranmayee
 * @author Veeven
 */
$messages['te'] = array(
	'code-comments' => 'వ్యాఖ్యలు',
	'code-change-removed' => 'తొలిగించబడినది',
	'code-old-status' => 'పాత స్థితి',
	'code-new-status' => 'కొత్త స్థితి',
	'code-prop-changes' => 'స్థితి & ట్యాగుల చిట్టా',
	'code-notes' => 'ఇటీవలి వ్యాఖ్యలు',
	'code-statuschanges' => 'స్థితి మార్పులు',
	'code-mycomments' => 'నా వ్యాఖ్యలు',
	'code-authors' => 'రచయితలు',
	'code-status' => 'స్థితులు',
	'code-author-orphan' => 'ఈ రచయితకి వికీ ఖాతాలో లంకె లేదు',
	'code-author-name' => 'ఒక వాడుకరిపేరుని ఇవ్వండి:',
	'code-author-total' => 'మొత్తం రచయితల సంఖ్య: $1',
	'code-field-id' => 'కూర్పు',
	'code-field-author' => 'రచయిత',
	'code-field-user' => 'వ్యాఖ్యాత',
	'code-field-message' => 'కమిట్ వ్యాఖ్య',
	'code-field-status' => 'స్థితి',
	'code-field-status-description' => 'స్థితి వివరణ',
	'code-field-timestamp' => 'తేదీ',
	'code-field-comments' => 'వ్యాఖ్యలు',
	'code-field-text' => 'గమనిక',
	'code-rev-author' => 'రచయిత:',
	'code-rev-date' => 'తేది:',
	'code-rev-message' => 'వ్యాఖ్య:',
	'code-rev-rev' => 'కూర్పు:',
	'code-rev-modified-r' => 'మార్పు చేయబడినది',
	'code-rev-modified-d' => 'తొలిగించబడినది',
	'code-rev-imagediff' => 'బొమ్మ మార్పులు',
	'code-rev-status' => 'స్థితి:',
	'code-rev-status-set' => 'మార్పు స్థితి',
	'code-rev-comment-by' => '$1 యొక్క వ్యాఖ్య',
	'code-rev-comment-preview' => 'మునుజూపు',
	'code-rev-inline-preview' => 'మునుజూపు:',
	'code-rev-diff' => 'తేడా',
	'code-rev-total' => 'మొత్తం ఫలితాల సంఖ్య: $1',
	'code-rev-not-found' => "'''$1''' అనే కూర్పు లేనే లేదు!",
	'code-rev-history-link' => 'చరిత్ర',
	'code-status-new' => 'కొత్త',
	'code-status-desc-fixme' => 'ఈ కూర్పు బగ్ ను చొప్పిస్తోందనో, లేక తెగిపోయిందనో ఒక వాడుకరి గుర్తు పెట్టారు. దాన్ని సరిచెయ్యాలి.',
	'code-status-reverted' => 'వెనక్కి తీసుకోబడినది',
	'code-status-desc-reverted' => 'ఈ కూర్పులో చేసిన మార్పులు తరువాతి మార్పు ద్వారా చెయ్యబడ్డాయి.',
	'code-status-resolved' => 'పరిష్కరించబడింది',
	'code-status-desc-resolved' => 'ఈ కూర్పులో ఒక సమస్య ఉండేది. అది తరువాతి కూర్పులో పరిష్కరించబడింది.',
	'code-status-ok' => 'సరి',
	'code-status-desc-ok' => 'ఈ కూర్పు కూలంకషంగా సమీక్షించబడింది. ఇది అన్ని విధాలా బాగుందని సమీక్షకుడు నిశ్చయంగా ఉన్నారు.',
	'code-status-desc-deferred' => 'కూర్పుకి సమీక్ష అవసరం లేదు.',
	'code-status-old' => 'పాతది',
	'code-status-desc-old' => 'బగ్ లు ఉండే అవకాశం ఉన్న పాత కూర్పు. అయితే ఈ బగ్ లు సమీక్షించేంత శ్రమ పడాల్సిన అవసరం లేనివి.',
	'code-signoff-flag-inspected' => 'పరీక్షించబడిన',
	'code-signoff-flag-tested' => 'పరీక్షించబడినవి',
	'code-signoff-field-user' => 'వాడుకరి',
	'code-signoff-field-flag' => 'ప్లాగ్',
	'code-signoff-field-date' => 'తేదీ',
	'code-signoff-struckdate' => '$1 (రద్దైనది $2)',
	'code-pathsearch-filter' => 'దీనిని మాత్రమే చూపించు:',
	'code-revfilter-cr_status' => 'స్థితి = $1',
	'code-revfilter-cr_author' => 'రచయిత = $1',
	'code-revfilter-clear' => 'వడపోతను ఖాళీచేయి',
	'code-rev-submit' => 'మార్పులను భద్రపరచు',
	'code-rev-submit-next' => 'భద్రపరచు & తరువాతి అపరిష్కృతం',
	'code-batch-status' => 'మార్పు స్థితి:',
	'codereview-batch-title' => 'ఎంచుకున్న అన్ని కూర్పులనూ మార్చు',
	'codereview-batch-submit' => 'దాఖలుచెయ్యి',
	'code-releasenotes' => 'విడుదల విశేషాలు',
	'code-release-endrev' => 'చివరి కూర్పు:',
	'codereview-subtitle' => '$1 కొరకు',
	'codereview-reply-link' => 'స్పందించు',
	'codereview-email-subj' => '[$1 $2]: కొత్త వ్యాఖ్యని చేర్చారు',
	'codereview-email-body' => 'వాడుకరి "$1" $3పై ఒక వ్యాఖ్య రాసారు.

పూర్తి చిరునామా: $2
కమిట్ సారాశం:

$5

వ్యాఖ్య:

$4',
	'codereview-email-subj2' => '[$1 $2]: తదనంతర మార్పులు',
	'codereview-email-body2' => 'వాడుకరి "$1" $2 లో ఫాలో-అప్ మార్పులు చేసారు.

ఫాలో-అప్ కూర్పు యొక్క పూర్తి URL: $5
కమిట్ సారాంశాం:

$6

పూర్తి URL: $3
కమిట్ సారాంశం:

$4',
	'codereview-email-subj3' => '[$1 $2]: కూర్పు స్థితి మారింది',
	'codereview-email-body3' => 'వాడుకరి "$1", $2 యొక్క సథితిని మార్చారు.

పాత స్థితి: $3
కొత్త స్థితి: $4

పూర్తి URL: $5
కమిట్ సారాంశం:

$6',
	'codereview-email-subj4' => '[$1 $2]: కొత్త కమిట్ చేర్చబడింది, కూర్పు స్థితి మార్చబడింది.',
	'codereview-email-body4' => 'వాడుకరి "$1", $2 యొక్క స్థితిని మార్చారు.

పాత స్థితి: $3
కొత్త స్థితి: $4

వాడుకరి "$1" $2 పై ఒక వ్యాఖ్య కూడా రాసారు.

పూర్తి URL: $5
కమిట్ సారాంశం:

$7

వ్యాఖ్య:

$6',
	'code-stats' => 'గణాంకాలు',
	'code-stats-header' => 'ఖజానా $1 గణాంకాలు',
	'code-stats-main' => '$1 నాటికి, ఖజానాలో [[Special:Code/$3/author|$4 {{PLURAL:$4|కర్త|కర్తలు}}]] చేసిన $2 {{PLURAL:$2|కూర్పు|కూర్పులు}} ఉన్నాయి.',
	'code-stats-status-breakdown' => 'ఒక్కో స్థితికి ఉన్న కూర్పుల సంఖ్య',
	'code-stats-count' => 'కూర్పుల యొక్క సంఖ్య',
	'repoadmin' => 'ఖజానా నిర్వహణ',
	'repoadmin-new-legend' => 'ఓ కొత్త ఖజానాను సృష్టించండి',
	'repoadmin-new-label' => 'ఖజానా పేరు:',
	'repoadmin-new-button' => 'సృష్టించు',
	'repoadmin-edit-legend' => 'ఖజానా "$1" యొక్క మార్పు',
	'repoadmin-edit-path' => 'ఖజానా పాత్:',
	'repoadmin-edit-bug' => 'Bugzilla పాత్:',
	'repoadmin-edit-view' => 'ViewVC పాత్:',
	'repoadmin-edit-button' => 'సరే',
	'repoadmin-edit-sucess' => 'ఖజానా "[[Special:Code/$1|$1]]" ను జయప్రదంగా మార్చాం.',
	'repoadmin-nav' => 'ఖజానా నిర్వహణ',
	'right-repoadmin' => 'కోడ్ ఖజానాలను నిర్వహించండి',
	'right-codereview-add-tag' => 'కొత్త ట్యాగులు, కూర్పులను చేర్చు',
	'right-codereview-remove-tag' => 'కూర్పుల నుండి ట్యాగులను తీసెయ్యి',
	'right-codereview-post-comment' => 'కూర్పులపై వ్యాఖ్యలు చేర్చగలగడం',
	'right-codereview-set-status' => 'కూర్పుల స్థితిని మార్చగలగడం',
	'right-codereview-link-user' => 'కర్తలను వికీ వాడుకరులతో లింకు  చెయ్యి',
	'right-codereview-review-own' => 'మీ స్వంత కూర్పులను ’సరే’ గా గుర్తించండి',
	'specialpages-group-developer' => 'వికాసకుల పనిముట్లు',
	'group-svnadmins' => 'SVN నిర్వాహకులు',
	'group-svnadmins-member' => 'SVN నిర్వాహకుడు',
	'grouppage-svnadmins' => '{{ns:project}}:SVN నిర్వాహకులు',
);

/** Tetum (Tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'code-author-link' => 'ligasaun?',
	'code-field-id' => 'Versaun',
	'code-field-author' => 'Autór',
	'code-field-timestamp' => 'Tempu',
	'code-rev-author' => 'Autór',
	'code-rev-date' => 'Tempu:',
	'code-rev-message' => 'Komentáriu:',
	'code-rev-rev' => 'Versaun:',
	'code-rev-rev-viewvc' => 'iha ViewVC',
	'code-rev-comment-by' => 'Komentáriu $1 nian',
	'code-rev-diff' => 'Diferensa',
	'code-rev-diff-link' => 'dif',
	'code-status-new' => 'foun',
	'code-status-ok' => 'ok',
	'code-revfilter-cr_author' => 'Autór = $1',
	'repoadmin-new-button' => 'Kria',
	'repoadmin-edit-button' => 'OK',
);

/** Tajik (Cyrillic script) (Тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'code' => 'Баррасии Рамз',
	'code-comments' => 'Тавзеҳот',
	'code-change-status' => "'''ваъзияти''' ин нусха тағйир ёфт",
	'code-change-tags' => "'''барчасбҳо''' барои ин нусха тағйир ёфтанд",
	'code-change-removed' => 'пок шуд:',
	'code-change-added' => 'изофа шуд:',
	'code-prop-changes' => 'Вазъият ва гузориши барчасбкунӣ',
	'codereview-desc' => '[[Special:Code|Абзори бозбинии рамз]] бо [[Special:RepoAdmin|Пуштибонии Зернусха]]',
	'code-no-repo' => 'Ҳеҷ махзане танзим нашудааст!',
	'code-notes' => 'нуктаҳои боздид',
	'code-authors' => 'муаллифон',
	'code-tags' => 'барчасбҳо',
	'code-authors-text' => 'Дар зер феҳристи муаллифони махзан бо тартиби супурданҳо оварда шудааст.',
	'code-author-haslink' => 'Ин муаллиф пайваста ба корбари викии $1 аст',
	'code-author-orphan' => 'Ин муаллиф дорои ҳеҷ пайванде ба ин вики ҳисоб нест',
	'code-author-dolink' => 'Пайвастани ин муаллиф ба як корбари вики:',
	'code-author-alterlink' => 'Тағйири корбари викии пайваста ба ин муаллиф:',
	'code-author-orunlink' => 'Ё бардоштани пайванди ин корбари вики:',
	'code-author-name' => 'Як номи корбарӣ ворид кунед:',
	'code-author-success' => 'Муаллифи $1 бо корбари викии $2 пайваста шуд',
	'code-author-link' => 'пайванд?',
	'code-author-unlink' => 'бардоштани пайванд?',
	'code-author-unlinksuccess' => 'Пайванди муаллиф $1 бардошта шуд',
	'code-field-id' => 'Нусха',
	'code-field-author' => 'Муаллиф',
	'code-field-user' => 'Тавзеҳдиҳанда',
	'code-field-message' => 'Супурдани хулоса',
	'code-field-status' => 'Вазъият',
	'code-field-timestamp' => 'Сана',
	'code-field-comments' => 'Нуктаҳо',
	'code-field-path' => 'Масир',
	'code-field-text' => 'Нукта',
	'code-rev-author' => 'Муаллиф:',
	'code-rev-date' => 'Сана:',
	'code-rev-message' => 'Тавзеҳ:',
	'code-rev-repo' => 'Махзан:',
	'code-rev-rev' => 'Нусха:',
	'code-rev-rev-viewvc' => 'рӯи ViewVC',
	'code-rev-paths' => 'Масирҳои тағйирёфта:',
	'code-rev-modified-a' => 'изофа шуд',
	'code-rev-modified-r' => 'ҷойгузин шуд',
	'code-rev-modified-d' => 'ҳазф шуд',
	'code-rev-modified-m' => 'тағйир ёфт',
	'code-rev-status' => 'Вазъият:',
	'code-rev-status-set' => 'Тағйири вазъият',
	'code-rev-tags' => 'Барчасбҳо:',
	'code-rev-tag-add' => 'Изофаи барчасбҳо:',
	'code-rev-tag-remove' => 'Пок кардани барчасбҳо:',
	'code-rev-comment-by' => 'Тавзеҳ аз тарафи $1',
	'code-rev-comment-preview' => 'Пешнамоиш',
	'code-rev-diff' => 'Тафовут',
	'code-rev-diff-link' => 'тафовут',
	'code-rev-purge-link' => 'холӣ кардан',
	'code-status-new' => 'нав',
	'code-status-fixme' => 'дурустам кун',
	'code-status-reverted' => 'вогардонишуда',
	'code-status-resolved' => 'ҳалшуда',
	'code-status-ok' => 'мавриди таъйид',
	'code-status-deferred' => 'дошташуда',
	'code-pathsearch-legend' => 'Ҷустуҷӯи нусхаҳо дар ин махзан бар асоси масир',
	'code-pathsearch-path' => 'Масир:',
	'code-rev-submit' => 'Захираи тағйирот',
	'code-rev-submit-next' => 'Захира шавад ва баъдии ҳалнашуда',
	'codereview-reply-link' => 'посух',
	'codereview-email-subj' => '[$1 $2]: Тавзеҳи нав изофа шуд',
	'codereview-email-body' => 'Корбар "$1" як тавзеҳе дар $3 фиристод.

Нишонаи пурра: $2

Тавзеҳ:

$4',
	'repoadmin' => 'Мудирияти Махзан',
	'repoadmin-new-legend' => 'Эҷоди махзани нав',
	'repoadmin-new-label' => 'Номи махзан:',
	'repoadmin-new-button' => 'Эҷод',
	'repoadmin-edit-legend' => 'Тағйири махзани "$1"',
	'repoadmin-edit-path' => 'Масири махзан:',
	'repoadmin-edit-bug' => 'Масири Bugzilla:',
	'repoadmin-edit-view' => 'Масири ViewVC:',
	'repoadmin-edit-button' => 'Мавриди таъйид',
	'repoadmin-edit-sucess' => 'Махзани "[[Special:Code/$1|$1]]" бо муваффақият тағйир ёфт.',
	'right-repoadmin' => 'Идораи махзанҳои рамз',
	'right-codereview-add-tag' => 'Изофаи барчасбҳои нав ба нусхаҳо',
	'right-codereview-remove-tag' => 'Пок кардани барчасбҳо аз нусхаҳо',
	'right-codereview-post-comment' => 'Изофаи тавзеҳот рӯи нусхаҳо',
	'right-codereview-set-status' => 'Тағйири вазъияти нусхаҳо',
	'right-codereview-link-user' => 'Пайвастани муаллифон ба вики корбарон',
	'specialpages-group-developer' => 'Абзорҳои тавсиядиҳандагон',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'code' => 'Barrasiji Ramz',
	'code-comments' => 'Tavzehot',
	'code-change-removed' => 'pok şud:',
	'code-change-added' => 'izofa şud:',
	'code-prop-changes' => "Vaz'ijat va guzorişi barcasbkunī",
	'codereview-desc' => '[[Special:Code|Abzori bozbiniji ramz]] bo [[Special:RepoAdmin|Puştiboniji Zernusxa]]',
	'code-no-repo' => 'Heç maxzane tanzim naşudaast!',
	'code-authors' => 'muallifon',
	'code-tags' => 'barcasbho',
	'code-author-haslink' => 'In muallif pajvasta ba korbari vikiji $1 ast',
	'code-author-orphan' => 'In muallif doroi heç pajvande ba in viki hisob nest',
	'code-author-dolink' => 'Pajvastani in muallif ba jak korbari viki:',
	'code-author-alterlink' => 'Taƣjiri korbari vikiji pajvasta ba in muallif:',
	'code-author-orunlink' => 'Jo bardoştani pajvandi in korbari viki:',
	'code-author-name' => 'Jak nomi korbarī vorid kuned:',
	'code-author-success' => 'Muallifi $1 bo korbari vikiji $2 pajvasta şud',
	'code-author-link' => 'pajvand?',
	'code-author-unlink' => 'bardoştani pajvand?',
	'code-author-unlinksuccess' => 'Pajvandi muallif $1 bardoşta şud',
	'code-field-id' => 'Nusxa',
	'code-field-author' => 'Muallif',
	'code-field-user' => 'Tavzehdihanda',
	'code-field-message' => 'Supurdani xulosa',
	'code-field-status' => "Vaz'ijat",
	'code-field-timestamp' => 'Sana',
	'code-field-comments' => 'Nuktaho',
	'code-field-path' => 'Masir',
	'code-field-text' => 'Nukta',
	'code-rev-author' => 'Muallif:',
	'code-rev-date' => 'Sana:',
	'code-rev-message' => 'Tavzeh:',
	'code-rev-repo' => 'Maxzan:',
	'code-rev-rev' => 'Nusxa:',
	'code-rev-rev-viewvc' => 'rūi ViewVC',
	'code-rev-paths' => 'Masirhoi taƣjirjofta:',
	'code-rev-modified-a' => 'izofa şud',
	'code-rev-modified-r' => 'çojguzin şud',
	'code-rev-modified-d' => 'hazf şud',
	'code-rev-modified-m' => 'taƣjir joft',
	'code-rev-status' => "Vaz'ijat:",
	'code-rev-status-set' => "Taƣjiri vaz'ijat",
	'code-rev-tags' => 'Barcasbho:',
	'code-rev-tag-add' => 'Izofai barcasbho:',
	'code-rev-tag-remove' => 'Pok kardani barcasbho:',
	'code-rev-comment-by' => 'Tavzeh az tarafi $1',
	'code-rev-comment-preview' => 'Peşnamoiş',
	'code-rev-diff' => 'Tafovut',
	'code-rev-diff-link' => 'tafovut',
	'code-rev-purge-link' => 'xolī kardan',
	'code-status-new' => 'nav',
	'code-status-fixme' => 'durustam kun',
	'code-status-reverted' => 'vogardonişuda',
	'code-status-resolved' => 'halşuda',
	'code-status-ok' => "mavridi ta'jid",
	'code-status-deferred' => 'doştaşuda',
	'code-pathsearch-legend' => 'Çustuçūi nusxaho dar in maxzan bar asosi masir',
	'code-pathsearch-path' => 'Masir:',
	'code-rev-submit' => 'Zaxirai taƣjirot',
	'code-rev-submit-next' => "Zaxira şavad va ba'diji halnaşuda",
	'codereview-reply-link' => 'posux',
	'codereview-email-subj' => '[$1 $2]: Tavzehi nav izofa şud',
	'codereview-email-body' => 'Korbar "$1" jak tavzehe dar $3 firistod.

Nişonai purra: $2

Tavzeh:

$4',
	'repoadmin' => 'Mudirijati Maxzan',
	'repoadmin-new-legend' => 'Eçodi maxzani nav',
	'repoadmin-new-label' => 'Nomi maxzan:',
	'repoadmin-new-button' => 'Eçod',
	'repoadmin-edit-legend' => 'Taƣjiri maxzani "$1"',
	'repoadmin-edit-path' => 'Masiri maxzan:',
	'repoadmin-edit-bug' => 'Masiri Bugzilla:',
	'repoadmin-edit-view' => 'Masiri ViewVC:',
	'repoadmin-edit-button' => "Mavridi ta'jid",
	'repoadmin-edit-sucess' => 'Maxzani "[[Special:Code/$1|$1]]" bo muvaffaqijat taƣjir joft.',
	'right-repoadmin' => 'Idorai maxzanhoi ramz',
	'right-codereview-add-tag' => 'Izofai barcasbhoi nav ba nusxaho',
	'right-codereview-remove-tag' => 'Pok kardani barcasbho az nusxaho',
	'right-codereview-post-comment' => 'Izofai tavzehot rūi nusxaho',
	'right-codereview-set-status' => "Taƣjiri vaz'ijati nusxaho",
	'right-codereview-link-user' => 'Pajvastani muallifon ba viki korbaron',
	'specialpages-group-developer' => 'Abzorhoi tavsijadihandagon',
);

/** Thai (ไทย)
 * @author Manop
 */
$messages['th'] = array(
	'code-comments' => 'ความเห็น',
	'code-field-author' => 'ผู้แต่ง',
	'code-field-status' => 'สถานะ',
	'code-field-timestamp' => 'วันที่',
	'code-rev-date' => 'วันที่:',
	'code-rev-modified-a' => 'ถูกเพิ่ม',
	'code-rev-modified-r' => 'ถูกแทนที่',
	'code-rev-modified-d' => 'ถูกลบ',
	'code-rev-comment-preview' => 'ดูตัวอย่าง',
	'code-status-new' => 'ใหม่',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'code' => 'Kod Gözden Geçirmesi',
	'code-rev-title' => '$1 - Kod Gözden Geçirmesi',
	'code-comments' => 'Teswirler',
	'code-references' => 'Wersiýalary yzarla',
	'code-change-status' => "$1-ň '''statusyny''' üýtgetdi",
	'code-change-tags' => "$1 üçin '''tegleri''' üýtgetdi",
	'code-change-removed' => 'aýyryldy:',
	'code-change-added' => 'goşuldy:',
	'code-old-status' => 'Köne status',
	'code-new-status' => 'Täze status',
	'code-prop-changes' => 'Status & tegleme gündeligi',
	'codereview-desc' => '[[Special:Code|Kod gözden geçirme guraly]], [[Special:RepoAdmin|Subversion goldawy]] bilen bilelikde',
	'code-no-repo' => 'Hiç bir ammar konfigurirlenmedi!',
	'code-load-diff' => 'Aratapwutlary ýükleýär...',
	'code-notes' => 'ýaňy-ýakyndaky teswirler',
	'code-statuschanges' => 'status üýtgeşmeleri',
	'code-mycommits' => 'tabşyrmalarym',
	'code-authors' => 'awtorlar',
	'code-status' => 'status',
	'code-tags' => 'tegler',
	'code-authors-text' => 'Aşakdaky sanaw ýaňy-ýakyndaky tabşyrmalara görä düzülen awtorlary görkezýär. Ýerli wiki hasaplary ýaýyň içinde görkezilýär.',
	'code-author-haslink' => 'Bu awtor $1 wiki ulanyjysyna çykgytlydyr',
	'code-author-orphan' => 'Bu awtoryň haýsydyr bir wiki hasaba çykgydy ýok.',
	'code-author-dolink' => 'Bu awtory haýsydyr bir wiki ulanyjysyna çykgytla:',
	'code-author-alterlink' => 'Bu awtora çykgytlanan wiki ulanyjysyny üýtget:',
	'code-author-orunlink' => 'Ýa-da bu wiki ulanyjysynyň çykgydyny aýyr:',
	'code-author-name' => 'Ulanyjy adyny ýazyň:',
	'code-author-success' => '$1 awtory $2 wiki ulanyjysyna çykgytlandy',
	'code-author-link' => 'çykgyt goýmalymy?',
	'code-author-unlink' => 'çykgydy aýyrmalymy?',
	'code-author-unlinksuccess' => '$1 awtorynyň çykgydy aýyryldy',
	'code-author-total' => 'Awtorlaryň umuny sany: $1',
	'code-author-lastcommit' => 'Soňky tabşyryş senesi',
	'code-browsing-path' => "'''$1''' içinde wersiýalara göz aýlanýar",
	'code-field-id' => 'Wersiýa',
	'code-field-author' => 'Awtor',
	'code-field-user' => 'Teswirçi',
	'code-field-message' => 'Tabşyryş düşündirişi',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Sene',
	'code-field-comments' => 'Bellikler',
	'code-field-path' => 'Ýol',
	'code-field-text' => 'Bellik',
	'code-field-select' => 'Saýla',
	'code-rev-author' => 'Awtor:',
	'code-rev-date' => 'Sene:',
	'code-rev-message' => 'Teswir:',
	'code-rev-repo' => 'Ammar:',
	'code-rev-rev' => 'Wersiýa:',
	'code-rev-rev-viewvc' => 'ViewVC arkaly',
	'code-rev-paths' => 'Üýtgedilen ýollar:',
	'code-rev-modified-a' => 'goşuldy',
	'code-rev-modified-r' => 'çalşyryldy',
	'code-rev-modified-d' => 'öçürildi',
	'code-rev-modified-m' => 'üýtgedildi',
	'code-rev-imagediff' => 'Surat üýtgeşmeleri',
	'code-rev-status' => 'Status:',
	'code-rev-status-set' => 'Statusy üýtget',
	'code-rev-tags' => 'Tegler:',
	'code-rev-tag-add' => 'Teg goş:',
	'code-rev-tag-remove' => 'Teg aýyr:',
	'code-rev-comment-by' => '$1 tarapyndan teswir',
	'code-rev-comment-preview' => 'Deslapky syn',
	'code-rev-inline-preview' => 'Deslapky syn:',
	'code-rev-diff' => 'Tapawut',
	'code-rev-diff-link' => 'tapawut',
	'code-rev-diff-too-large' => 'Aratapawut görkezerden uly',
	'code-rev-purge-link' => 'boşat',
	'code-rev-total' => 'Netijeleriň umuny sany: $1',
	'code-rev-not-found' => "'''$1''' wersiýasy ýok!",
	'code-status-new' => 'täze',
	'code-status-desc-new' => 'Wersiýa işe garaşýar (gaýybana status).',
	'code-status-fixme' => 'menidüzet',
	'code-status-reverted' => 'yzyna getirildi',
	'code-status-resolved' => 'çözüldi',
	'code-status-ok' => 'bolýar',
	'code-status-deferred' => 'gaýra goýuldy',
	'code-status-desc-deferred' => 'Wersiýa gözden geçiriş talap etmeýär.',
	'code-status-old' => 'köne',
	'code-pathsearch-legend' => 'Bu ammardaky wersiýalary ýol boýunça gözle',
	'code-pathsearch-path' => 'Ýol:',
	'code-pathsearch-filter' => 'Ulanylýan filtr:',
	'code-revfilter-cr_status' => 'Status = $1',
	'code-revfilter-cr_author' => 'Awtor = $1',
	'code-revfilter-clear' => 'Filtri arassala',
	'code-rev-submit' => 'Üýtgeşmeleri ýazdyr',
	'code-rev-submit-next' => 'Ýazdyr & indiki çözülmedik',
	'code-batch-status' => 'Statusy üýtget:',
	'code-batch-tags' => 'Tegleri üýtget:',
	'codereview-batch-title' => 'Ähli saýlanylgy wersiýalary üýtget',
	'codereview-batch-submit' => 'Tabşyr',
	'code-releasenotes' => 'goýberiliş bellikleri',
	'code-release-legend' => 'Goýberiliş belliklerini döret',
	'code-release-startrev' => 'Başlangyç wersiýa:',
	'code-release-endrev' => 'Soňky wersiýa:',
	'codereview-subtitle' => '$1 üçin',
	'codereview-reply-link' => 'jogap ber',
	'codereview-email-subj' => '[$1 $2]: Täze teswir goşuldy',
	'codereview-email-body' => '$3-de ulanyjy "$1" bir teswir iberdi.

Doly URL: $2

Teswir:

$4',
	'codereview-email-subj2' => '[$1 $2]: Yzarlama üýtgeşmeleri',
	'codereview-email-body2' => '"$1" atly ulanyjy $2 üçin yzarlama üýtgeşmeleri etdi.

Yzarlanýan wersiýa üçin doly URL: $5

Doly URL: $3

Tabşyrma düşündirişi:

$4',
	'codereview-email-subj3' => '[$1 $2]: Awtomatik synag regressiýany ýüze çykardy',
	'codereview-email-body3' => '$1 üçin üýtgeşmeler zerarly awtomatik synag bir regressiýany ýüze çykardy.

Doly URL: $2

Tabşyrma düşündirişi:

$3',
	'code-stats' => 'statistika',
	'code-stats-header' => '$1 repozitoriýasy üçin statistika',
	'code-stats-main' => '$1 boýunça, repozitoriýada [[Special:Code/$3/author|$4 {{PLURAL:$4|awtor|awtor}}]] tarapyndan edilen $2 {{PLURAL:$2|wersiýa|wersiýa}} bar.',
	'code-stats-status-breakdown' => 'Ýagdaý boýunça wersiýalaryň sany',
	'code-stats-count' => 'Wersiýalaryň sany',
	'repoadmin' => 'Ammar Dolandyryşy',
	'repoadmin-new-legend' => 'Täze ammar döret',
	'repoadmin-new-label' => 'Ammar ady:',
	'repoadmin-new-button' => 'Döret',
	'repoadmin-edit-legend' => '"$1" ammarynyň üýtgemesi:',
	'repoadmin-edit-path' => 'Ammar ýoly:',
	'repoadmin-edit-bug' => 'Bugzilla ýoly:',
	'repoadmin-edit-view' => 'ViewVC ýoly:',
	'repoadmin-edit-button' => 'Bolýar',
	'repoadmin-edit-sucess' => '"[[Special:Code/$1|$1]]" ammary şowly üýtgedildi.',
	'repoadmin-nav' => 'repozitoriýa administrasiýasy',
	'right-repoadmin' => 'Kod ammarlaryny dolandyr',
	'right-codereview-use' => 'Special:Code ulanyşy',
	'right-codereview-add-tag' => 'Wersiýalara täze teg goş',
	'right-codereview-remove-tag' => 'Wersiýalardan teg aýyr',
	'right-codereview-post-comment' => 'Wersiýalara teswir goş',
	'right-codereview-set-status' => 'Wersiýalaryň statusyny üýtget',
	'right-codereview-link-user' => 'Awtorlary wiki ulanyjylaryna çykgytla',
	'specialpages-group-developer' => 'Ösdürimçi gurallary',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'code' => 'Muling Pagsusuri ng Kodigo',
	'code-rev-title' => '$1 - Pagsusuri ng Kodigo',
	'code-comments' => 'Mga puna',
	'code-references' => 'Tugaygayan ang mga pagbabago',
	'code-change-status' => "binago ang '''kalagayan''' ng $1",
	'code-change-tags' => "binago ang '''mga tatak''' para sa $1",
	'code-change-removed' => 'tinanggal:',
	'code-change-added' => 'idinagdag:',
	'code-old-status' => 'Lumang kalagayan',
	'code-new-status' => 'Bagong kalagayan',
	'code-prop-changes' => 'Talaan ng kalagayan at pagtatatak',
	'codereview-desc' => '[[Special:Code|Kasangkapang na pang muling pagsusuri ng kodigo]] na may [[Special:RepoAdmin|Suportang pamuksa]]',
	'code-no-repo' => 'Walang naisaayos na repositoryo!',
	'code-create-repo' => 'Pumunta sa [[Special:RepoAdmin|Tagapangasiwa ng Taguan]] upang lumikha ng isang Taguan',
	'code-need-repoadmin-rights' => 'kailangan ang mga karapatang pang-tagapangasiwa ng taguan upang makalikha ng isang Taguan',
	'code-need-group-with-rights' => 'Walang umiiral na pangkat na may mga karapatang pang-tagapangasiwa ng taguan. Paki magdagdag ng isa upang makapagdagdag ng isang bagong Taguan.',
	'code-repo-not-found' => "Hindi umiiral ang repositoryong '''$1'''!",
	'code-load-diff' => 'Ikinakarga ang pagkakaiba…',
	'code-notes' => 'kamakailang mga puna/kumento',
	'code-statuschanges' => 'katayuan ng mga pagbabago',
	'code-mycommits' => 'mga nagawa ko',
	'code-mycomments' => 'mga puna ko',
	'code-authors' => 'mga may-akda',
	'code-status' => 'mga kalagayan',
	'code-tags' => 'mga tatak',
	'code-tags-no-tags' => 'Walang umiiral na mga tatak sa loob ng taguang ito.',
	'code-authors-text' => 'Nasa ibaba ang isang talaan ng mga may-akda ng repositoryo ayon sa pagkakasunud-sunod ng pangalan ng paglalagak.  Ipinapakita sa loob ng mga saklong ang mga akawnt ng panglokal na wiki.  Dapat na nakatago ang dato.',
	'code-author-haslink' => 'Nakakawing ang may-akdang ito sa tagagamit ng wiking si $1',
	'code-author-orphan' => 'Ang may-akdang ito ay walang kawing sa isang kuwenta/akawnt ng wiki',
	'code-author-dolink' => 'Ikawing ang may-akdang ito sa isang tagagamit ng wiki:',
	'code-author-alterlink' => 'Baguhin ang tagagamit na wiking nakakawing sa may-akdang ito:',
	'code-author-orunlink' => 'O kaya tanggalin ang pagkakakawing ng tagagamit ng wiking ito:',
	'code-author-name' => 'Magpasok ng isang pangalan ng tagagamit:',
	'code-author-success' => 'Ikinawing ang may-akdang si $1 sa/kay tagagamit ng wiking si $2',
	'code-author-link' => 'ikakawing?',
	'code-author-unlink' => 'tanggalin sa pagkakakawing?',
	'code-author-unlinksuccess' => 'Tinanggal na sa pagkakakawing ang may-akdang si $1',
	'code-author-badtoken' => 'Sinusubok ng kamalian sa pagpupulong na isagawa ang galaw.',
	'code-author-total' => 'Kabuuang bilang ng mga may-akda: $1',
	'code-author-lastcommit' => 'Huling petsa ng pagsasagawa',
	'code-browsing-path' => "Tinitingnan-tingnan ng mga rebisyon sa loob ng '''$1'''",
	'code-field-id' => 'Pagbabago',
	'code-field-author' => 'May-akda',
	'code-field-user' => 'Tagapagpuna/Nagbigay ng kumento',
	'code-field-message' => 'Isagawa ang buod',
	'code-field-status' => 'Kalagayan',
	'code-field-status-description' => 'Paglalarawan ng kalagayan',
	'code-field-timestamp' => 'Petsa',
	'code-field-comments' => 'Mga puna',
	'code-field-path' => 'Daanan',
	'code-field-text' => 'Tala',
	'code-field-select' => 'Piliin',
	'code-reference-remove' => 'Tanggalin ang napiling mga kaugnayan',
	'code-reference-associate' => 'Iugnay ang rebisyong pangtugaygay:',
	'code-reference-associate-submit' => 'Kaugnay',
	'code-rev-author' => 'May-akda:',
	'code-rev-date' => 'Petsa:',
	'code-rev-message' => 'Kumento:',
	'code-rev-repo' => 'Repositoryo:',
	'code-rev-rev' => 'Pagbabago:',
	'code-rev-rev-viewvc' => 'nasa ViewVC',
	'code-rev-paths' => 'Binagong mga daanan:',
	'code-rev-modified-a' => 'idinagdag',
	'code-rev-modified-r' => 'pinalitan',
	'code-rev-modified-d' => 'binura',
	'code-rev-modified-m' => 'binago',
	'code-rev-imagediff' => 'Mga pagbabago sa larawan',
	'code-rev-status' => 'Kalagayan:',
	'code-rev-status-set' => 'Baguhin ang kalagayan',
	'code-rev-tags' => 'Mga tatak:',
	'code-rev-tag-add' => 'Idagdag ang mga tatak:',
	'code-rev-tag-remove' => 'Alisin ang mga tatak:',
	'code-rev-comment-by' => 'Komento ni $1',
	'code-rev-comment-preview' => 'Unang tingin',
	'code-rev-inline-preview' => 'Paunang tingin:',
	'code-rev-diff' => 'Pagkakaiba',
	'code-rev-diff-link' => 'pagkakaiba',
	'code-rev-diff-too-large' => 'Napakalaki ng kaibahan upang maipakita.',
	'code-rev-purge-link' => 'purgahin',
	'code-rev-total' => 'Kabuuang bilang ng mga resulta: $1',
	'code-rev-not-found' => "Hindi umiiral ang rebisyong '''$1'''!",
	'code-status-new' => 'bago',
	'code-status-desc-new' => 'Ang rebisyon ay naghihintay ng isang galaw (likas na nakatakdang katayuan).',
	'code-status-fixme' => 'ayusinako',
	'code-status-desc-fixme' => 'Isang tagapagsuri ang nagmarka sa rebisyong ito na magpakilala ng depekto o kaya sira.  Dapat itong itama.',
	'code-status-reverted' => 'ibinalik',
	'code-status-desc-reverted' => 'Itinapon papalayo ang rebisyon ng isang isang mas huling rebisyon.',
	'code-status-resolved' => 'nalutas na',
	'code-status-desc-resolved' => 'Nagkasuliranin ang rebisyon na tinukoy ng isang mas huling rebisyon.',
	'code-status-ok' => 'okey',
	'code-status-desc-ok' => 'Nasuri na nang buo ang rebisyon at nakatitiyak ang tagapagsuri na maayos ito sa lahat paraan.',
	'code-status-deferred' => 'ipinagpaliban',
	'code-status-desc-deferred' => 'Hindi nangangailangan ng muling pagsusuri ang rebisyon.',
	'code-status-old' => 'luma',
	'code-status-desc-old' => 'Ang lumang rebisyon ay may maaaring maging mga depekto subalit hindi naaangkupan ng pagsisikap para suriin sila.',
	'code-signoffs' => 'Mga paglalagda ng pagtatapos',
	'code-signoff-legend' => 'Idagdag ang paglagda ng pagtatapos',
	'code-signoff-submit' => 'Lumagdang patapos',
	'code-signoff-strike' => 'Pangibabawan ng guhit ang napiling paglalagdang patapos',
	'code-signoff-signoff' => 'Lumagda sa rebisyong ito bilang:',
	'code-signoff-flag-inspected' => 'Nasiyasat',
	'code-signoff-flag-tested' => 'Nasubok na',
	'code-signoff-field-user' => 'Tagagamit',
	'code-signoff-field-flag' => 'Watawat',
	'code-signoff-field-date' => 'Petsa',
	'code-signoff-struckdate' => '$1 (pinatamaan ang $2)',
	'code-pathsearch-legend' => 'Maghanap ng mga pagbabago sa repositoryong ito sa pamamagitan ng daanan',
	'code-pathsearch-path' => 'Daanan:',
	'code-pathsearch-filter' => 'Ginamit na pansala:',
	'code-revfilter-cr_status' => 'Katayuan = $1',
	'code-revfilter-cr_author' => 'May-akda = $1',
	'code-revfilter-clear' => 'Dalisayin ang pansala',
	'code-rev-submit' => 'Sagipin ang mga pagbabago',
	'code-rev-submit-next' => 'Sagipin at susunod na hindi pa nalulutas',
	'code-batch-status' => 'Baguhin ang kalagayan:',
	'code-batch-tags' => 'Baguhin ang mga tatak:',
	'codereview-batch-title' => 'Baguhin ang lahat ng napiling mga rebisyon',
	'codereview-batch-submit' => 'Ipasa',
	'code-releasenotes' => 'ilabas ang mga tala',
	'code-release-legend' => 'Gawin ang pagpapalabas ng mga tala',
	'code-release-startrev' => 'Simula ng pagbabago:',
	'code-release-endrev' => 'Huling pagbabago:',
	'codereview-subtitle' => 'Para kay $1',
	'codereview-reply-link' => 'tugon',
	'codereview-email-subj' => '[$1 $2]: Nagdagdag ng bagong puna/kumento',
	'codereview-email-body' => 'Nagpaskil ang tagagamit na si "$1" ng isang puna sa $3.

Buong URL: $2
Buod ng pagsasagawa:

$5

Puna:

$4',
	'codereview-email-subj2' => '[$1 $2]: Pangtugaygay na mga pagbabago',
	'codereview-email-body2' => 'Ang tagagamit na si "$1" ay gumawa ng karagdagang mga pagbabago sa $2.

Buong URL para sa karagdagang rebisyon: $5
Buod ng pagsasagawa:

$6

Buong URL: $3
Buod ng pagsasagawa:

$4',
	'codereview-email-subj3' => '[$1 $2]: Nabago ang kalagayan ng rebisyon',
	'codereview-email-body3' => 'Binago ng tagagamit na si "$1" ang katayuan ng $2.

Lumang kalagayan: $3
Bagong kalagayan: $4

Buong URL: $5
Buod ng pagsasagawa:

$6',
	'codereview-email-subj4' => '[$1 $2]: Nadagdag ang bagong puna, at nabago ang kalagayan ng rebisyon',
	'codereview-email-body4' => 'Binago ng tagagamit na si "$1" ang katayuan ng $2.

Lumang kalagayan: $3
Bagong kalagayan: $4

Nagpaskil din ang tagagamit na si "$1" ng isang puna sa $2.

Buong URL: $5
Buod ng pagsasagawa:

$7

Puna:

$6',
	'code-stats' => 'estadistika',
	'code-stats-header' => 'Estadistika para sa repositoryong $1',
	'code-stats-main' => 'Magmula noong $1, ang repositoryo ay may $2 {{PLURAL:$2|rebisyon|mga rebisyon}} ng [[Special:Code/$3/author|$4 {{PLURAL:$4|may-akda|mga may-akda}}]].',
	'code-stats-status-breakdown' => 'Bilang ng mga rebisyon sa bawat kalagayan',
	'code-stats-fixme-breakdown' => 'Paglilista ng mga pag-aayos ng bawat may-akda',
	'code-stats-count' => 'Bilang ng mga rebisyon',
	'repoadmin' => 'Pamamahala ng Repositoryo',
	'repoadmin-new-legend' => 'Lumikha ng isang bagong repositoryo',
	'repoadmin-new-label' => 'Pangalan ng repositoryo:',
	'repoadmin-new-button' => 'Likhain',
	'repoadmin-edit-legend' => 'Pagpapabago ng repositoryong "$1"',
	'repoadmin-edit-path' => 'Daanan ng repositoryo:',
	'repoadmin-edit-bug' => 'Daanan ng Bugzilla:',
	'repoadmin-edit-view' => 'Daanan ng ViewVC',
	'repoadmin-edit-button' => "Sige/Ayos 'yan",
	'repoadmin-edit-sucess' => 'Matagumpay na nabago ang repositoryong "[[Special:Code/$1|$1]]".',
	'repoadmin-nav' => 'pangangasiwa ng repositoryo',
	'right-repoadmin' => 'Pamahalaan ang mga repositoryong may kodigo',
	'right-codereview-use' => 'Paggamit ng Natatangi:Kodigo',
	'right-codereview-add-tag' => 'Magdagdag ng bagong tatak sa mga pagbabago',
	'right-codereview-remove-tag' => 'Tanggalin an mga tatak mula sa mga pagbabago',
	'right-codereview-post-comment' => 'Magdagdag ng mga kumento sa mga pagbabago',
	'right-codereview-set-status' => 'Baguhin ang kalagayan ng mga pagbabago',
	'right-codereview-signoff' => 'Lumagdang patapos sa mga rebisyon',
	'right-codereview-link-user' => 'Ikawing ang mga may-akda sa mga tagagamit ng wiki',
	'right-codereview-associate' => 'Pangasiwaan ang mga ugnayan ng rebisyon',
	'right-codereview-review-own' => 'Markahan ang sarili mong mga rebisyon bilang OK',
	'specialpages-group-developer' => 'Mga kasangkapan ng tagapagpaunlad',
	'group-svnadmins' => 'Mga tagapangasiwa ng SVN',
	'group-svnadmins-member' => 'Tagapangasiwa ng SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Mga tagapangasiwa ng SVN',
);

/** Turkish (Türkçe)
 * @author Cekli829
 * @author Joseph
 * @author Srhat
 */
$messages['tr'] = array(
	'code' => 'Kod Gözden Geçirmesi',
	'code-rev-title' => '$1 - Kod İnceleme',
	'code-comments' => 'Yorumlar',
	'code-references' => 'Revizyonları takip et',
	'code-change-status' => "$1'in '''durumunu''' değiştirdi",
	'code-change-tags' => "$1 için '''etiketleri''' değiştirdi",
	'code-change-removed' => 'kaldırıldı:',
	'code-change-added' => 'eklendi:',
	'code-old-status' => 'Eski durum',
	'code-new-status' => 'Yeni durum',
	'code-prop-changes' => 'Durum & etiket günlüğü',
	'codereview-desc' => '[[Special:Code|Kod gözden geçirme aracı]], [[Special:RepoAdmin|Altsürüm desteği]] ile',
	'code-no-repo' => 'Hiç depo yapılandırılmadı!',
	'code-repo-not-found' => "Depo '''$1''' mevcut değil!",
	'code-load-diff' => 'Farkları yüklüyor…',
	'code-notes' => 'son yorumlar',
	'code-statuschanges' => 'durum değişiklikleri',
	'code-mycommits' => 'taahhütlerim',
	'code-authors' => 'yazarlar',
	'code-status' => 'durum',
	'code-tags' => 'etiketler',
	'code-tags-no-tags' => 'Bu havuzda etiket mevcut değil.',
	'code-authors-text' => 'Aşağıdaki, teslim isimlerine göre sıralanmış depo yazarları listesidir. Yerel viki hesapları parantez içinde gösterilmiştir. Veri önbellekte olabilir.',
	'code-author-haslink' => 'Bu yazar $1 viki kullanıcısına bağlıdır',
	'code-author-orphan' => 'Bu yazarın bir viki hesabıyla bağı yoktur',
	'code-author-dolink' => 'Bu yazarı bir viki kullanıcısına bağla:',
	'code-author-alterlink' => 'Bu yazara bağlı viki kullanıcısını değiştir:',
	'code-author-orunlink' => 'Ya da bu viki kullanıcısının bağını kaldır:',
	'code-author-name' => 'Bir kullanıcı adı girin:',
	'code-author-success' => '$1 yazarı $2 viki kullanıcısına bağlandı',
	'code-author-link' => 'bağla?',
	'code-author-unlink' => 'bağı kaldır?',
	'code-author-unlinksuccess' => '$1 yazarının bağı kaldırıldı',
	'code-author-badtoken' => 'Eylemi gerçekleştirmeye çalışırken oturum hatası.',
	'code-author-total' => 'Toplam yazar sayısı: $1',
	'code-browsing-path' => "'''$1''' içinde revizyonlara göz atılıyor",
	'code-field-id' => 'Revizyon',
	'code-field-author' => 'Yazar',
	'code-field-user' => 'Yorumcu',
	'code-field-message' => 'Teslim özeti',
	'code-field-status' => 'Durum',
	'code-field-timestamp' => 'Tarih',
	'code-field-comments' => 'Yorumlar',
	'code-field-path' => 'Yol',
	'code-field-text' => 'Not',
	'code-field-select' => 'Seç',
	'code-rev-author' => 'Yazar:',
	'code-rev-date' => 'Tarih:',
	'code-rev-message' => 'Yorum:',
	'code-rev-repo' => 'Depo:',
	'code-rev-rev' => 'Revizyon:',
	'code-rev-rev-viewvc' => "ViewVC'de",
	'code-rev-paths' => 'Değiştirilmiş yollar:',
	'code-rev-modified-a' => 'eklendi',
	'code-rev-modified-r' => 'değiştirildi',
	'code-rev-modified-d' => 'silindi',
	'code-rev-modified-m' => 'değiştirildi',
	'code-rev-imagediff' => 'Resim değişiklikleri',
	'code-rev-status' => 'Durum:',
	'code-rev-status-set' => 'Durumu değiştir',
	'code-rev-tags' => 'Etiketler:',
	'code-rev-tag-add' => 'Etiket ekle:',
	'code-rev-tag-remove' => 'Etiket çıkar:',
	'code-rev-comment-by' => '$1 kullanıcısından yorum',
	'code-rev-comment-preview' => 'Önizleme',
	'code-rev-inline-preview' => 'Önizleme:',
	'code-rev-diff' => 'Fark',
	'code-rev-diff-link' => 'fark',
	'code-rev-diff-too-large' => 'Fark görüntülenemeyecek kadar büyük.',
	'code-rev-purge-link' => 'temizle',
	'code-rev-total' => 'Toplam sonuç sayısı: $1',
	'code-status-new' => 'yeni',
	'code-status-fixme' => 'benidüzelt',
	'code-status-reverted' => 'eski haline döndürüldü',
	'code-status-resolved' => 'çözümlendi',
	'code-status-ok' => 'tamam',
	'code-status-deferred' => 'ertelendi',
	'code-status-old' => 'eskimiş',
	'code-signoff-field-user' => 'Kullanıcı',
	'code-signoff-field-flag' => 'Bayrak',
	'code-signoff-field-date' => 'Tarih',
	'code-pathsearch-legend' => 'Bu depodaki revizyonları yola göre ara',
	'code-pathsearch-path' => 'Yol:',
	'code-pathsearch-filter' => 'Uygulanan filtre:',
	'code-revfilter-cr_status' => 'Durum = $1',
	'code-revfilter-cr_author' => 'Yazar = $1',
	'code-revfilter-clear' => 'Filtreyi temizle',
	'code-rev-submit' => 'Değişiklikleri kaydet',
	'code-rev-submit-next' => 'Kaydet & sonraki çözümlenmemiş',
	'code-batch-status' => 'Değişiklik durumu:',
	'code-batch-tags' => 'Değişiklik etiketleri:',
	'codereview-batch-title' => 'Tüm seçili revizyonları değiştir',
	'codereview-batch-submit' => 'Gönder',
	'code-releasenotes' => 'sürüm notları',
	'code-release-legend' => 'Sürüm notları oluştur',
	'code-release-startrev' => 'Başlangıç rev:',
	'code-release-endrev' => 'Son rev:',
	'codereview-subtitle' => '$1 için',
	'codereview-reply-link' => 'yanıtla',
	'codereview-email-subj' => '[$1 $2]: Yeni yorum eklendi',
	'codereview-email-body' => '$3\'de "$1" kullanıcısı bir yorum yolladı.

Tam adres: $2

Yorum:

$4',
	'codereview-email-subj2' => '[$1 $2]: Takip değişiklikleri',
	'codereview-email-body2' => '"$1" kullanıcısı $2 için takip değişiklikleri yaptı.

Tam URL: $3

Teslim özeti:

$4',
	'codereview-email-subj3' => '[$1 $2]: Otomatik test gerileme saptadı',
	'codereview-email-body3' => 'Otomatik test $1 revizyonundaki değişikliklerden dolayı bir gerileme ortaya çıkardı.

Tam URL: $2

Teslimat özeti:

$3',
	'code-stats' => 'istatistikler',
	'repoadmin' => 'Depo Yönetimi',
	'repoadmin-new-legend' => 'Yeni bir depo oluştur',
	'repoadmin-new-label' => 'Depo adı:',
	'repoadmin-new-button' => 'Oluştur',
	'repoadmin-edit-legend' => '"$1" deposunun değişikliği',
	'repoadmin-edit-path' => 'Depo yolu:',
	'repoadmin-edit-bug' => 'Bugzilla yolu:',
	'repoadmin-edit-view' => 'ViewVC yolu:',
	'repoadmin-edit-button' => 'Tamam',
	'repoadmin-edit-sucess' => '"[[Special:Code/$1|$1]]" deposu başarıyla değiştirildi.',
	'right-repoadmin' => 'Kod depolarını yönet',
	'right-codereview-use' => 'Special:Code kullanımı',
	'right-codereview-add-tag' => 'Revizyonlara yeni etiket ekle',
	'right-codereview-remove-tag' => 'Revizyonlardan etiket çıkar',
	'right-codereview-post-comment' => 'Revizyonlara yorum ekle',
	'right-codereview-set-status' => 'Revizyon durumunu değiştir',
	'right-codereview-link-user' => 'Yazarları viki kullanıcılarına bağla',
	'specialpages-group-developer' => 'Geliştirici araçları',
);

/** Uyghur (Arabic script) (ئۇيغۇرچە)
 * @author Alfredie
 */
$messages['ug-arab'] = array(
	'code-status-ok' => 'ماقۇل',
	'repoadmin-edit-button' => 'ماقۇل',
);

/** Uyghur (Latin script) (Uyghurche‎)
 * @author Jose77
 */
$messages['ug-latn'] = array(
	'code-status-ok' => 'maqul',
	'repoadmin-edit-button' => 'Maqul',
);

/** Ukrainian (Українська)
 * @author AS
 * @author Ahonc
 * @author Aleksandrit
 * @author Alex Khimich
 * @author Dim Grits
 * @author NickK
 * @author Prima klasy4na
 * @author Riwnodennyk
 * @author Тест
 */
$messages['uk'] = array(
	'code' => 'Перевірка коду',
	'code-rev-title' => '$1 – Перегляд версії',
	'code-comments' => 'Коментарі',
	'code-references' => 'Наступні версії',
	'code-change-status' => "змінив '''статус''' $1",
	'code-change-tags' => "змінив '''мітки''' для $1",
	'code-change-removed' => 'вилучено:',
	'code-change-added' => 'додано:',
	'code-old-status' => 'Попередній статус',
	'code-new-status' => 'Новий статус',
	'code-prop-changes' => 'Журнал станів і міток',
	'codereview-desc' => '[[Special:Code|Засіб перевірки коду]] з [[Special:RepoAdmin|підтримкою Subversion]]',
	'code-no-repo' => 'Відсутнє налаштоване сховище!',
	'code-create-repo' => 'Перейти до [[Special:RepoAdmin|RepoAdmin]], щоб створити сховище',
	'code-need-repoadmin-rights' => 'для створення сховища необхідні repoadmin права',
	'code-need-group-with-rights' => 'Не існує групи із правами repoadmin. Будь ласка, створіть таку, щоб мати можливість додавання нового сховища',
	'code-repo-not-found' => "Сховища '''$1''' не існує!",
	'code-load-diff' => 'Завантаження різниці версій…',
	'code-notes' => 'останні коментарі',
	'code-statuschanges' => 'зміни статусу',
	'code-mycommits' => 'мої дії',
	'code-mycomments' => 'мої коментарі',
	'code-authors' => 'автори',
	'code-status' => 'статуси',
	'code-tags' => 'мітки',
	'code-tags-no-tags' => 'У цьому сховищі мітки відсутні',
	'code-authors-text' => 'Нижче наведений список авторів сховища, упорядкований за іменами. Локальні облікові записи вікі показані в дужках. Ці данні можливо будуть кешуватись.',
	'code-author-haslink' => "Цей автор пов'язаний з користувачем $1",
	'code-author-orphan' => "Для цього автора, $1, не встановлений зв'язок з обліковим записом у вікі.",
	'code-author-dolink' => "Встановити для цього автора зв'язок з користувачем:",
	'code-author-alterlink' => "Змінити обліковий засіб, пов'язаний з цим автором:",
	'code-author-orunlink' => "Або розірвати зв'язок з вікі-користувачем:",
	'code-author-name' => "Введіть ім'я користувача:",
	'code-author-success' => "Автора $1 успішно пов'язано з користувачем $2",
	'code-author-link' => "встановити зв'язок?",
	'code-author-unlink' => "розірвати зв'язок?",
	'code-author-unlinksuccess' => "Для автора $1 розірвано зв'язок з обліковим записом",
	'code-author-badtoken' => 'Помилка сесії при виконанні цієї дії',
	'code-author-total' => 'Загальна кількість авторів: $1',
	'code-author-lastcommit' => 'Остання дата дій',
	'code-browsing-path' => "Перегляд версії в '''$1'''",
	'code-field-id' => 'Редакція',
	'code-field-author' => 'Автор',
	'code-field-user' => 'Автор коментаря',
	'code-field-message' => 'Опис змін',
	'code-field-status' => 'Стан',
	'code-field-status-description' => 'Опис статусу',
	'code-field-timestamp' => 'Дата',
	'code-field-comments' => 'Коментарі',
	'code-field-path' => 'Шлях',
	'code-field-text' => 'Примітка',
	'code-field-select' => 'Вибрати',
	'code-reference-remove' => 'Вилучити вибрані асоціації',
	'code-reference-associate' => "Пов'язати наступні зміни:",
	'code-reference-associate-submit' => "Пов'язати",
	'code-rev-author' => 'Автор:',
	'code-rev-date' => 'Дата:',
	'code-rev-message' => 'Опис змін:',
	'code-rev-repo' => 'Сховище:',
	'code-rev-rev' => 'Редакція:',
	'code-rev-rev-viewvc' => 'через ViewVC',
	'code-rev-paths' => 'Посилання на зміни:',
	'code-rev-modified-a' => 'додано',
	'code-rev-modified-r' => 'замінено',
	'code-rev-modified-d' => 'вилучено',
	'code-rev-modified-m' => 'змінено',
	'code-rev-imagediff' => 'Зміни зображення',
	'code-rev-status' => 'Стан:',
	'code-rev-status-set' => 'Змінити стан',
	'code-rev-tags' => 'Мітки:',
	'code-rev-tag-add' => 'Додати мітки:',
	'code-rev-tag-remove' => 'Вилучити мітки:',
	'code-rev-comment-by' => 'Коментар від $1',
	'code-rev-comment-preview' => 'Попередній перегляд',
	'code-rev-inline-preview' => 'Попередній перегляд:',
	'code-rev-diff' => 'Зміна',
	'code-rev-diff-link' => 'різн.',
	'code-rev-diff-too-large' => 'Різниця версій занадто велика для відображення.',
	'code-rev-purge-link' => 'очистити кеш',
	'code-rev-total' => 'Загальна кількість результатів: $1',
	'code-rev-not-found' => "Ревізія '''$1''' не існує!",
	'code-rev-history-link' => 'історія',
	'code-status-new' => 'нове',
	'code-status-desc-new' => 'Перегляд передбачає якісь дії (Налаштування за замовчуванням)',
	'code-status-fixme' => 'виправити',
	'code-status-desc-fixme' => "У цій версії з'явилась помилка, яка повинна бути виправлена, або зроблений відкіт до попереднього стану",
	'code-status-reverted' => 'відкинуто',
	'code-status-desc-reverted' => 'Попередня ревізія буля відкинута більш недавньою .',
	'code-status-resolved' => 'виправлено',
	'code-status-desc-resolved' => 'Версія мала питання, яке було розглянуто пізнішим рецензуванням.',
	'code-status-ok' => 'ОК',
	'code-status-desc-ok' => 'Версію повністю розглянуто і рецензент впевнений, що вона добра в усіх відношеннях.',
	'code-status-deferred' => 'відкладено',
	'code-status-desc-deferred' => 'Версія не потребує рецензування.',
	'code-status-old' => 'застарілий',
	'code-status-desc-old' => 'Стара версія має потенційні помилки, які не варті зусиль їх рецензування.',
	'code-signoffs' => 'Підтвердження',
	'code-signoff-legend' => 'Додати підтвердження',
	'code-signoff-submit' => 'Підтвердження',
	'code-signoff-strike' => 'Викреслити відмічені підтвердження',
	'code-signoff-signoff' => 'Закінчити на цій редакції, як:',
	'code-signoff-flag-inspected' => 'Перевірено',
	'code-signoff-flag-tested' => 'Випробувано',
	'code-signoff-field-user' => 'Користувач',
	'code-signoff-field-flag' => 'Прапорець',
	'code-signoff-field-date' => 'Дата',
	'code-signoff-struckdate' => '$1 (викреслив $2)',
	'code-pathsearch-legend' => 'Пошук в цьому сховищі конкретних редакцій за їх адресою',
	'code-pathsearch-path' => 'Шлях:',
	'code-pathsearch-filter' => 'Показати лише:',
	'code-revfilter-cr_status' => 'Статус = $1',
	'code-revfilter-cr_author' => 'Автор = $1',
	'code-revfilter-ct_tag' => 'Мітка = $1',
	'code-revfilter-clear' => 'Зняти фільтр',
	'code-rev-submit' => 'Зберегти зміни',
	'code-rev-submit-next' => 'Зберегти і показати наступну невирішену',
	'code-rev-next' => 'Наступна невирішена',
	'code-batch-status' => 'Змінити статус:',
	'code-batch-tags' => 'Змінити мітки:',
	'codereview-batch-title' => 'Змінити всі обрані версії',
	'codereview-batch-submit' => 'Відправити',
	'code-releasenotes' => 'примітки до випуску',
	'code-release-legend' => 'Створити примітки до випуску',
	'code-release-startrev' => 'Початкова версія:',
	'code-release-endrev' => 'Остання версія:',
	'codereview-subtitle' => 'Для $1',
	'codereview-reply-link' => 'відповісти',
	'codereview-overview-title' => 'Огляд',
	'codereview-overview-desc' => 'Показати графічне представлення цього списку',
	'codereview-email-subj' => '[$1 $2]: Доданий новий коментар',
	'codereview-email-body' => 'Користувач «$1» залишив коментар на $3.

Повний URL: $2
Опис коментаря:

$5

Коментар:

$4',
	'codereview-email-subj2' => '[$1 $2]: Подальші зміни',
	'codereview-email-body2' => 'Користувач "$1" вніс зміни до $2.

Повна адреса попередньої версії: $5
Опис змін:

$6

Повна адреса: $3
Опис змін:

$4',
	'codereview-email-subj3' => '[$1 $2]: Статус редакції змінено',
	'codereview-email-body3' => 'Користувач "$1" змінив статус $2.

Старий статус: $3
Новий статус: $4

URL: $5
Опис змін:

$6',
	'codereview-email-subj4' => '[$1 $2]: Додано новий коментар, статус редакції змінено',
	'codereview-email-body4' => 'Користувач "$1" змінив статус $2.

Старий статус: $3
Новий статус: $4

Користувач "$1" також розмістив коментар про $2.

URL: $5
Опис змін:

$7

Коментар:

$6',
	'code-stats' => 'статистика',
	'code-stats-header' => 'Статистика репозиторія $1',
	'code-stats-main' => 'Станом на $1, репозиторій має $2 {{PLURAL:$2|перегляд|перегляди|переглядів}} виконаних  [[Special:Code/$3/author|$4 {{PLURAL:$4|автором|авторами}}]].',
	'code-stats-status-breakdown' => 'Кількість переглядів на стан',
	'code-stats-fixme-breakdown' => 'Розподіл змін зі статусом "виправити" за авторами',
	'code-stats-fixme-breakdown-path' => 'Розподіл змін зі статусом "виправити" за шляхом',
	'code-stats-fixme-path' => "Зміни статусом ''виправити'' для шляху: $1",
	'code-stats-new-breakdown' => 'Розподіл нових змін за автором',
	'code-stats-count' => 'Кількість ревізій',
	'code-tooltip-withsummary' => 'r$1 [$2]  $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2]  $3',
	'repoadmin' => 'Управління сховищем програмного коду',
	'repoadmin-new-legend' => 'Створити нове сховище',
	'repoadmin-new-label' => 'Назва сховища:',
	'repoadmin-new-button' => 'Створити',
	'repoadmin-edit-legend' => 'Зміна сховища «$1»',
	'repoadmin-edit-path' => 'Шлях до сховища:',
	'repoadmin-edit-bug' => 'Шлях до бази Bugzilla:',
	'repoadmin-edit-view' => 'Шлях до ViewVC:',
	'repoadmin-edit-button' => 'Готово',
	'repoadmin-edit-sucess' => 'Сховище «[[Special:Code/$1|$1]]» успішно змінено.',
	'repoadmin-nav' => 'управління сховищем',
	'right-repoadmin' => 'Управління сховищами кодів',
	'right-codereview-use' => 'Використання Special:Code',
	'right-codereview-add-tag' => 'Додавання тегів до редакцій',
	'right-codereview-remove-tag' => 'Видалення тегів з редакцій',
	'right-codereview-post-comment' => 'Додавання коментарів до редакцій',
	'right-codereview-set-status' => 'Зміна статусу редакцій',
	'right-codereview-signoff' => 'Підтвердження змін',
	'right-codereview-link-user' => "Зв'язок авторів з користувачами вікі-проекту",
	'right-codereview-associate' => "Управління пов'язаними редагуваннями",
	'right-codereview-review-own' => 'Відзначити власні зміни як «Вирішені»',
	'specialpages-group-developer' => 'Інструменти розробника',
	'group-svnadmins' => 'Адміністратори SVN',
	'group-svnadmins-member' => '{{GENDER:$1|Адміністратор SVN|Адміністраторка SVN}}',
	'grouppage-svnadmins' => '{{ns:project}}: Адміністратори SVN',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'code' => 'Revision del codice',
	'code-rev-title' => '$1 - Revision del còdese',
	'code-comments' => 'Comenti',
	'code-references' => 'Revision seguenti',
	'code-change-status' => "ga canbià el '''stato''' de $1",
	'code-change-tags' => "ga canbià i '''tag''' de $1",
	'code-change-removed' => 'cavà:',
	'code-change-added' => 'zontà:',
	'code-old-status' => 'Vecio stato',
	'code-new-status' => 'Novo stato',
	'code-prop-changes' => 'Registro del stato e del tagging',
	'codereview-desc' => '[[Special:Code|Strumento de revision del codice]] con [[Special:RepoAdmin|suporto par le sotoversioni]]',
	'code-no-repo' => 'Nissun deposito configurà!',
	'code-repo-not-found' => "El deposito '''$1''' no l'esiste!",
	'code-load-diff' => 'Cargo le difarense…',
	'code-notes' => 'note reçenti',
	'code-statuschanges' => 'canbiamenti de stato',
	'code-mycommits' => 'i me salvataji',
	'code-authors' => 'autori',
	'code-status' => 'stati',
	'code-tags' => 'tag',
	'code-authors-text' => 'Qua soto ghe xe na lista dei autori del deposito ordenà par nome. I account wiki locali i xe mostrà tra parentesi. I dati i podarìa vegner da na memoria cache.',
	'code-author-haslink' => "Sto autor el xe ligà a l'utente wiki $1",
	'code-author-orphan' => "Sto autor no'l xe ligà a nissun utente wiki",
	'code-author-dolink' => 'Ligar sto autor a un utente wiki:',
	'code-author-alterlink' => "Canbiar l'utente wiki ligà a sto autor:",
	'code-author-orunlink' => "O cavar el ligamento co' sto utente wiki:",
	'code-author-name' => 'Inserissi un nome utente:',
	'code-author-success' => "L'autor $1 el xe stà ligà a l'utente wiki $2",
	'code-author-link' => 'ligar?',
	'code-author-unlink' => 'desligar?',
	'code-author-unlinksuccess' => "El colegamento a l'autor $1 el xe stà cavà",
	'code-author-badtoken' => 'Eror de session provando a far sta azion.',
	'code-author-total' => 'Nùmaro total de autori: $1',
	'code-author-lastcommit' => 'Ultima data de salvatajo',
	'code-browsing-path' => "Sfojando le revision in '''$1'''",
	'code-field-id' => 'Revision',
	'code-field-author' => 'Autor',
	'code-field-user' => 'Comentador',
	'code-field-message' => 'Comento',
	'code-field-status' => 'Stato',
	'code-field-timestamp' => 'Data',
	'code-field-comments' => 'Note',
	'code-field-path' => 'Percorso',
	'code-field-text' => 'Note',
	'code-field-select' => 'Selessiona',
	'code-rev-author' => 'Autor:',
	'code-rev-date' => 'Data:',
	'code-rev-message' => 'Comento:',
	'code-rev-repo' => 'Deposito:',
	'code-rev-rev' => 'Revision:',
	'code-rev-rev-viewvc' => 'su ViewVC',
	'code-rev-paths' => 'Percorsi modificài:',
	'code-rev-modified-a' => 'zontà',
	'code-rev-modified-r' => 'rinpiazà',
	'code-rev-modified-d' => 'scancelà',
	'code-rev-modified-m' => 'canbià',
	'code-rev-imagediff' => "Canbiamenti a l'imagine",
	'code-rev-status' => 'Stato:',
	'code-rev-status-set' => 'Canbia stato',
	'code-rev-tags' => 'Tag:',
	'code-rev-tag-add' => 'Zonta tag:',
	'code-rev-tag-remove' => 'Cava tag:',
	'code-rev-comment-by' => 'Comento de $1',
	'code-rev-comment-preview' => 'Anteprima',
	'code-rev-inline-preview' => 'Anteprima:',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-rev-diff-too-large' => 'Sto diff el xe massa grando par mostrarlo.',
	'code-rev-purge-link' => 'netar',
	'code-rev-total' => 'Nùmaro total de risultati: $1',
	'code-rev-not-found' => "La revision '''$1''' no la esiste!",
	'code-status-new' => 'novo',
	'code-status-desc-new' => 'Sta revision la xe pendente (default).',
	'code-status-fixme' => 'da justar',
	'code-status-desc-fixme' => 'Un revisor gà segnà che sta revision la gà un difeto o no la va mia. Ghe xe da sistemarla.',
	'code-status-reverted' => 'tirà indrìo',
	'code-status-desc-reverted' => 'Sta revision la xe stà scartà da na revision sucessiva.',
	'code-status-resolved' => 'sistemà',
	'code-status-desc-resolved' => 'Sta revision la ga un problema che xe stà risolto da na revision successiva.',
	'code-status-ok' => 'va ben',
	'code-status-desc-ok' => 'Sta revision la xe interamente controlà e el revisor el xe sicuro che la xe a posto.',
	'code-status-deferred' => 'rimandà',
	'code-status-desc-deferred' => 'Sta revision no la richiede controlo.',
	'code-status-old' => 'vecio',
	'code-status-desc-old' => 'Revision vecia con potensiali difeti che no val la pena de sistemar.',
	'code-signoff-field-user' => 'Utente',
	'code-signoff-field-flag' => 'Bandiera',
	'code-signoff-field-date' => 'Data',
	'code-pathsearch-legend' => 'Serca le version drento sto deposito, in base al percorso',
	'code-pathsearch-path' => 'Percorso:',
	'code-pathsearch-filter' => 'Filtro aplicà:',
	'code-revfilter-cr_status' => 'Stato = $1',
	'code-revfilter-cr_author' => 'Autor = $1',
	'code-revfilter-clear' => 'Scansela filtro',
	'code-rev-submit' => 'Salva le modìfeghe',
	'code-rev-submit-next' => 'Salva e và al prossimo che xe da justar',
	'code-batch-status' => 'Cànbia stato:',
	'code-batch-tags' => 'Canbia tag:',
	'codereview-batch-title' => 'Canbia tute le revision selessionà',
	'codereview-batch-submit' => 'Invia',
	'code-releasenotes' => 'note de rilàscio',
	'code-release-legend' => 'Gènera le note de rilascio',
	'code-release-startrev' => 'Revision de partensa:',
	'code-release-endrev' => 'Ultima revision:',
	'codereview-subtitle' => 'Par $1',
	'codereview-reply-link' => 'rispondi',
	'codereview-email-subj' => '[$1 $2]: Zontà un comento nóvo',
	'codereview-email-body' => 'L\'utente "$1" el gà scrito un comento su $3.

URL par intiero: $2

Comento:

$4',
	'codereview-email-subj2' => '[$1 $2]: Canbiamenti seguenti',
	'codereview-email-body2' => 'L\'utente "$1" el gà fato dele modifiche seguenti a $2.

URL de la revision: $5

URL: $3

Ojeto de la modifica:

$4',
	'codereview-email-subj3' => '[$1 $2]: Stato de la revision canbià',
	'codereview-email-body3' => 'L\'utente "$1" gà canbià el stato de $2.

Stato vecio: $3
Stato novo: $4',
	'code-stats' => 'statisteghe',
	'code-stats-header' => 'Statìsteghe del deposito $1',
	'code-stats-main' => 'A la data del $1, el deposito el gà $2 {{PLURAL:$2|revision|revision}} fate da [[Special:Code/$3/author|$4 {{PLURAL:$4|autor|autori}}]].',
	'code-stats-status-breakdown' => 'Numaro de revisioni par stato',
	'code-stats-fixme-breakdown' => 'Analisi dei fixme par autor',
	'code-stats-count' => 'Numaro de revision',
	'repoadmin' => "'Ministrassion dei depositi",
	'repoadmin-new-legend' => 'Crea un deposito novo',
	'repoadmin-new-label' => 'Nome del deposito:',
	'repoadmin-new-button' => 'Crea',
	'repoadmin-edit-legend' => 'Modìfega del deposito "$1"',
	'repoadmin-edit-path' => 'Percorso del deposito:',
	'repoadmin-edit-bug' => 'Percorso de Bugzilla:',
	'repoadmin-edit-view' => 'Percorso de ViewVC:',
	'repoadmin-edit-button' => 'Va ben',
	'repoadmin-edit-sucess' => 'El deposito "[[Special:Code/$1|$1]]" el xe stà modificà.',
	'repoadmin-nav' => "'ministrassion del deposito",
	'right-repoadmin' => 'Gestir i depositi de codice',
	'right-codereview-use' => 'Utilizo de Special:Code',
	'right-codereview-add-tag' => 'Zonta tag novi a le revision',
	'right-codereview-remove-tag' => 'Cava tag da le revision',
	'right-codereview-post-comment' => 'Zonta comenti su le revision',
	'right-codereview-set-status' => 'Canbia el stato de le revision',
	'right-codereview-link-user' => 'Liga i autori a dei utenti wiki',
	'specialpages-group-developer' => "Strumenti pa' i svilupadori",
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'code-comments' => 'Kommentarijad',
	'code-change-removed' => 'heittud poiš:',
	'code-change-added' => 'ližatud:',
	'code-old-status' => 'Vanh status',
	'code-new-status' => "Uz' status",
	'code-authors' => 'avtorad',
	'code-tags' => 'virgad',
	'code-author-name' => 'Kirjutagat nimi:',
	'code-field-author' => 'Avtor',
	'code-field-user' => 'Kommentator',
	'code-field-status' => 'Status',
	'code-field-timestamp' => 'Dat',
	'code-field-comments' => 'Kommentarijad',
	'code-field-path' => 'Te',
	'code-field-text' => 'Homaičend',
	'code-field-select' => 'Valita',
	'code-rev-author' => 'Avtor:',
	'code-rev-date' => 'Dat:',
	'code-rev-message' => 'Komment:',
	'code-rev-repo' => 'Varaait:',
	'code-rev-rev' => 'Versii:',
	'code-rev-rev-viewvc' => 'ViewVC:s',
	'code-rev-modified-a' => 'ližatud',
	'code-rev-modified-d' => 'heittud',
	'code-rev-status' => 'Status:',
	'code-rev-tags' => 'Virgad:',
	'code-rev-tag-add' => 'Ližata virgad:',
	'code-rev-tag-remove' => 'Čuta virgad poiš:',
	'code-rev-comment-by' => '$1-kävutajan kommentarii',
	'code-rev-comment-preview' => 'Ezikacund',
	'code-rev-inline-preview' => 'Ezikacund:',
	'code-rev-diff' => 'Erinendad',
	'code-rev-diff-link' => 'erinend',
	'code-status-ok' => 'ok',
	'code-pathsearch-path' => 'Te:',
	'code-batch-status' => 'Vajehtada status:',
	'code-batch-tags' => 'Toižetada virgad:',
	'codereview-reply-link' => 'antta vastust',
	'repoadmin-new-button' => 'Säta',
	'repoadmin-edit-button' => 'OK',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'code' => 'Duyệt mã',
	'code-rev-title' => '$1 – Duyệt mã',
	'code-comments' => 'Ghi chú',
	'code-references' => 'Các phiên bản tiếp theo',
	'code-referenced' => 'Các phiên bản được tiếp theo',
	'code-change-status' => "đã đổi '''trạng thái''' của phiên bản r$1",
	'code-change-tags' => "đã đổi các '''thẻ''' của phiên bản r$1",
	'code-change-removed' => 'đã dời:',
	'code-change-added' => 'đã thêm:',
	'code-old-status' => 'Trạng thái cũ',
	'code-new-status' => 'Trạng thái  mới',
	'code-prop-changes' => 'Nhật trình trạng thái và thẻ',
	'codereview-desc' => '[[Special:Code|Công cụ duyệt mã]] [[Special:RepoAdmin|hỗ trợ Subversion]]',
	'code-no-repo' => 'Chưa thiết lập kho dữ liệu!',
	'code-create-repo' => 'Sử dụng [[Special:RepoAdmin|RepoAdmin]] để tạo kho dữ liệu',
	'code-need-repoadmin-rights' => 'Cần quyền repoadmin để tạo kho dữ liệu',
	'code-need-group-with-rights' => 'Không có nhóm nào có quyền repoadmin. Xin cấp quyền đó cho một nhóm để tạo kho dữ liệu mới.',
	'code-repo-not-found' => "Kho '''$1''' không tồn tại!",
	'code-load-diff' => 'Đang tải khác biệt…',
	'code-notes' => 'ghi chú gần đây',
	'code-statuschanges' => 'thay đổi trạng thái',
	'code-mycommits' => 'thay đổi của tôi',
	'code-mycomments' => 'ghi chú của tôi',
	'code-authors' => 'tác giả',
	'code-status' => 'tình trạng',
	'code-tags' => 'thẻ',
	'code-tags-no-tags' => 'Không có thẻ nào trong kho này.',
	'code-authors-text' => 'Đây có danh sách tác giả trong kho, xếp theo tên thay đổi. Trong dấu ngoặc có tài khoản wiki địa phương. Dữ liệu có thể được lấy từ vùng nhớ đệm.',
	'code-author-haslink' => 'Tác giả này được liên kết đến thành viên wiki $1',
	'code-author-orphan' => 'Người dùng SVN hoặc tác giả “$1” chưa được liên kết đến tài khoản wiki nào',
	'code-author-dolink' => 'Liên kết tác giả mã nguồn này đến thành viên wiki:',
	'code-author-alterlink' => 'Đổi thành viên wiki được liên kết đến tác giả này:',
	'code-author-orunlink' => 'Hoặc bỏ liên kết đến thành viên wiki này:',
	'code-author-name' => 'Hãy nhập tên người dùng:',
	'code-author-success' => 'Tác giả mã nguồn $1 được liên kết đến thành viên wiki $2',
	'code-author-link' => 'đặt liên kết?',
	'code-author-unlink' => 'bỏ liên kết?',
	'code-author-unlinksuccess' => 'Đã bỏ liên kết đến tác giả $1',
	'code-author-badtoken' => 'Lỗi phiên khi thực hiện tác vụ.',
	'code-author-total' => 'Tổng số tác giả: $1',
	'code-author-lastcommit' => 'Ngày thay đổi cuối cùng',
	'code-browsing-path' => "Xem các thay đổi trong '''$1'''",
	'code-field-id' => 'Phiên bản',
	'code-field-author' => 'Tác giả',
	'code-field-user' => 'Người bình luận',
	'code-field-message' => 'Đăng tóm lược',
	'code-field-status' => 'Trạng thái',
	'code-field-status-description' => 'Miêu tả trạng thái',
	'code-field-timestamp' => 'Lúc giờ',
	'code-field-comments' => 'Ghi chú',
	'code-field-path' => 'Đường dẫn',
	'code-field-text' => 'Ghi chú',
	'code-field-select' => 'Chọn',
	'code-reference-remove' => 'Dời các liên kết đã chọn',
	'code-reference-associate' => 'Liên kết phiên bản tiếp theo:',
	'code-reference-associate-submit' => 'Liên kết',
	'code-rev-author' => 'Tác giả:',
	'code-rev-date' => 'Ngày giờ:',
	'code-rev-message' => 'Ghi chú:',
	'code-rev-repo' => 'Kho dữ liệu:',
	'code-rev-rev' => 'Phiên bản:',
	'code-rev-rev-viewvc' => 'trên ViewVC',
	'code-rev-paths' => 'Đường dẫn được sửa đổi:',
	'code-rev-modified-a' => 'thêm',
	'code-rev-modified-r' => 'thay',
	'code-rev-modified-d' => 'xóa',
	'code-rev-modified-m' => 'sửa',
	'code-rev-imagediff' => 'Thay đổi hình ảnh',
	'code-rev-status' => 'Trạng thái:',
	'code-rev-status-set' => 'Thay đổi trạng thái',
	'code-rev-tags' => 'Các thẻ:',
	'code-rev-tag-add' => 'Thêm thẻ:',
	'code-rev-tag-remove' => 'Dời thẻ:',
	'code-rev-comment-by' => '$1 ghi chú',
	'code-rev-comment-preview' => 'Xem trước',
	'code-rev-inline-preview' => 'Xem trước:',
	'code-rev-diff' => 'So sánh',
	'code-rev-diff-link' => 'so sánh',
	'code-rev-diff-too-large' => 'Bản so sánh quá lớn để hiển thị.',
	'code-rev-purge-link' => 'làm mới',
	'code-rev-total' => 'Tổng số kết quả: $1',
	'code-rev-not-found' => "Phiên bản '''$1''' không tồn tại!",
	'code-rev-history-link' => 'lịch sử',
	'code-status-new' => 'mới',
	'code-status-desc-new' => 'Phiên bản đang chờ xử lý (trạng thái mặc định).',
	'code-status-fixme' => 'cần sửa',
	'code-status-desc-fixme' => 'Thay đổi đã gây lỗi hoặc bị hư hỏng. Nó cần được sửa chữa hoặc lùi lại.',
	'code-status-reverted' => 'khôi phục',
	'code-status-desc-reverted' => 'Phiên bản được thay thế bằng một phiên bản sau.',
	'code-status-resolved' => 'giải quyết',
	'code-status-desc-resolved' => 'Phiên bản có một vấn đề đã được giải quyết bởi một phiên bản sau.',
	'code-status-ok' => 'được',
	'code-status-desc-ok' => 'Phiên bản đã được duyệt hoàn thành; theo người duyệt, nó không có sao.',
	'code-status-deferred' => 'hoãn',
	'code-status-desc-deferred' => 'Phiên bản không cần được duyệt.',
	'code-status-old' => 'cũ',
	'code-status-desc-old' => 'Phiên bản có thể gây lỗi nhưng mất công duyệt nó.',
	'code-signoffs' => 'Tán thành',
	'code-signoff-legend' => 'Tán thành',
	'code-signoff-submit' => 'Tán thành',
	'code-signoff-strike' => 'Gạch bỏ các tán thành đã chọn',
	'code-signoff-signoff' => 'Tán thành thay đổi này:',
	'code-signoff-flag-inspected' => 'Đã kiểm tra',
	'code-signoff-flag-tested' => 'Đã thử nghiệm',
	'code-signoff-field-user' => 'Người dùng',
	'code-signoff-field-flag' => 'Cờ',
	'code-signoff-field-date' => 'Ngày',
	'code-signoff-struckdate' => '$1 (đã gạch bỏ $2)',
	'code-pathsearch-legend' => 'Tìm kiếm các thay đổi trong kho này theo đường dẫn',
	'code-pathsearch-path' => 'Đường dẫn:',
	'code-pathsearch-filter' => 'Chỉ hiển thị:',
	'code-revfilter-cr_status' => 'Trạng thái = $1',
	'code-revfilter-cr_author' => 'Tác giả = $1',
	'code-revfilter-ct_tag' => 'Thẻ = $1',
	'code-revfilter-clear' => 'Tẩy trống bộ lọc',
	'code-rev-submit' => 'Lưu các thay đổi',
	'code-rev-submit-next' => 'Lưu và xem thay đổi chưa giải quyết sau',
	'code-rev-next' => 'Thay đổi chưa giải sau',
	'code-batch-status' => 'Thay đổi trạng thái:',
	'code-batch-tags' => 'Thay đổi thẻ:',
	'codereview-batch-title' => 'Thay đổi tất cả các phiên bản được chọn',
	'codereview-batch-submit' => 'Đăng',
	'code-releasenotes' => 'thông báo phát hành',
	'code-release-legend' => 'Tạo thông báo phát hành',
	'code-release-startrev' => 'Phiên bản khởi đầu:',
	'code-release-endrev' => 'Phiên bản kết thúc:',
	'codereview-subtitle' => 'Dành cho $1',
	'codereview-reply-link' => 'trả lời',
	'codereview-overview-title' => 'Tóm tắt',
	'codereview-overview-desc' => 'Hiện biểu đồ tóm tắt danh sách này',
	'codereview-email-subj' => '[$1] [r$2]: Tin nhắn mới',
	'codereview-email-body' => 'Người dùng "$1" đã bình luận về $3.

URL đầy đủ: $2
Tóm lược thay đổi:

$5

Tin nhắn:

$4',
	'codereview-email-subj2' => '[$1] [r$2]: Các thay đổi tiếp theo',
	'codereview-email-body2' => 'Người dùng "$1" đã thực hiện các thay đổi tiếp theo $2.

URL đầy đủ đến phiên bản được tiếp theo: $5
Tóm lược thay đổi:

$6

URL đầy đủ: $3
Tóm lược thay đổi:

$4',
	'codereview-email-subj3' => '[$1 $2]: Trạng thái thay đổi đã thay đổi',
	'codereview-email-body3' => 'Người dùng "$1" đã thay đổi trạng thái của $2.

Trạng thái cũ: $3
Trạng thái mới: $4

URL đầy đủ: $5
Tóm lược thay đổi:

$6',
	'codereview-email-subj4' => '[$1 $2]: Đã thêm bình luận mới và thay đổi trạng thái thay đổi',
	'codereview-email-body4' => 'Người dùng "$1" đã thay đổi trạng thái $2.

Trạng thái cũ: $3
Trạng thái mới: $4

Người dùng "$1" cũng thêm bình luận vào $2.

URL đầy đủ: $5
Tóm lược thay đổi:

$7

Bình luận:

$6',
	'code-stats' => 'thống kê',
	'code-stats-header' => 'Thống kê của kho $1',
	'code-stats-main' => 'Vào $1, kho được sửa đổi $2 lần bởi [[Special:Code/$3/author|$4 người dùng]].',
	'code-stats-status-breakdown' => 'Số thay đổi cho mỗi trạng thái',
	'code-stats-fixme-breakdown' => 'Thay đổi được đánh dấu là cần sửa từng tác giả',
	'code-stats-fixme-breakdown-path' => 'Thay đổi cần sửa từng đường dẫn',
	'code-stats-fixme-path' => 'Phiên bản cần sửa tại đường dẫn: $1',
	'code-stats-new-breakdown' => 'Thay đổi mới được đánh dấu là cần sửa từng tác giả',
	'code-stats-new-breakdown-path' => 'Thay đổi mới từng đường dẫn',
	'code-stats-new-path' => 'Thay đổi mới tại đường dẫn: $1',
	'code-stats-count' => 'Số thay đổi',
	'code-tooltip-withsummary' => 'r$1 [$2] bởi $3 – $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] bởi $3',
	'repoadmin' => 'Quản lý kho dữ liệu',
	'repoadmin-new-legend' => 'Tạo kho dữ liệu',
	'repoadmin-new-label' => 'Tên kho dữ liệu:',
	'repoadmin-new-button' => 'Tạo',
	'repoadmin-edit-legend' => 'Sửa đổi kho dữ liệu “$1”',
	'repoadmin-edit-path' => 'Đường dẫn trong kho dữ liệu:',
	'repoadmin-edit-bug' => 'Đường dẫn trên Bugzilla:',
	'repoadmin-edit-view' => 'Đường dẫn trên ViewVC:',
	'repoadmin-edit-button' => 'Sửa đổi',
	'repoadmin-edit-sucess' => 'Kho dữ liệu “[[Special:Code/$1|$1]]” đã được sửa đổi thành công.',
	'repoadmin-nav' => 'quản lý kho',
	'right-repoadmin' => 'Quản lý các kho mã',
	'right-codereview-use' => 'Sử dụng Đặc biệt:Mã nguồn',
	'right-codereview-add-tag' => 'Thêm thẻ mới vào phiên bản',
	'right-codereview-remove-tag' => 'Dời thẻ khỏi phiên bản',
	'right-codereview-post-comment' => 'Ghi chú về phiên bản',
	'right-codereview-set-status' => 'Thay đổi trạng thái phiên bản',
	'right-codereview-signoff' => 'Tán thành các thay đổi',
	'right-codereview-link-user' => 'Liên kết tác giả mã nguồn đến thành viên wiki',
	'right-codereview-associate' => 'Quản lý các liên kết giữa phiên bản',
	'right-codereview-review-own' => 'Đánh dấu các sửa đổi của riêng bạn là Được hoặc Đã giải',
	'specialpages-group-developer' => 'Công cụ dành cho lập trình viên',
	'group-svnadmins' => 'Người quản lý SVN',
	'group-svnadmins-member' => '{{GENDER:$1}}người quản lý SVN',
	'grouppage-svnadmins' => '{{ns:project}}:Người quản lý SVN',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'code-comments' => 'Küpets',
	'code-change-status' => "evotükon '''stadi''' ela $1",
	'code-change-removed' => 'pemoükon:',
	'code-change-added' => 'peläükon:',
	'code-no-repo' => 'No dabinon kipedöp labü paramets pegivülöl!',
	'code-load-diff' => 'Lodon difi...',
	'code-authors' => 'lautans',
	'code-status' => 'stads',
	'code-author-haslink' => 'Lautan at peyümon lü vükigeban: $1',
	'code-author-orphan' => 'Lautan at no labon yümis lü vükakal',
	'code-author-dolink' => 'Yümön lautani at lü vükigeban:',
	'code-author-alterlink' => 'Votükön vükigebani lü lautan at peyümöli:',
	'code-author-orunlink' => 'U säyümön vükigebani at.',
	'code-author-name' => 'Penolös gebananemi:',
	'code-author-success' => 'Lautan: $1 peyümon lü vükigeban: $2',
	'code-author-link' => 'yümön?',
	'code-author-unlink' => 'säyümön?',
	'code-author-unlinksuccess' => 'Lautan: $1 pesäyümon',
	'code-field-id' => 'Revid',
	'code-field-author' => 'Lautan',
	'code-field-user' => 'Küpetan',
	'code-field-status' => 'Stad',
	'code-field-timestamp' => 'Dät',
	'code-field-comments' => 'Noets',
	'code-field-path' => 'Luveg',
	'code-field-text' => 'Noet',
	'code-rev-author' => 'Lautan:',
	'code-rev-date' => 'Dät:',
	'code-rev-message' => 'Küpet:',
	'code-rev-repo' => 'Kipedöp:',
	'code-rev-rev' => 'Revid:',
	'code-rev-paths' => 'Luvegs pevotüköl:',
	'code-rev-modified-a' => 'peläükon',
	'code-rev-modified-r' => 'peplaädon',
	'code-rev-modified-d' => 'pemoükon',
	'code-rev-modified-m' => 'pevotükon',
	'code-rev-status' => 'Stad:',
	'code-rev-status-set' => 'Votükön stadi',
	'code-rev-comment-by' => 'Küpet gebana: $1',
	'code-rev-comment-preview' => 'Büologed',
	'code-rev-diff' => 'Dif',
	'code-rev-diff-link' => 'dif',
	'code-rev-purge-link' => 'vagükön memi nelaidüpik',
	'code-status-new' => 'nulik',
	'code-pathsearch-path' => 'Luveg:',
	'code-rev-submit' => 'Dakipön votükamis',
	'codereview-subtitle' => 'Pro $1',
	'codereview-reply-link' => 'gesagön',
	'codereview-email-subj' => '[$1 $2]: Küpet nulik peläükon',
	'repoadmin' => 'Guvam Kipedöpa',
	'repoadmin-new-legend' => 'Jafön kipedöpi nulik',
	'repoadmin-new-label' => 'Nem kipedöpa:',
	'repoadmin-new-button' => 'Jafön',
	'repoadmin-edit-legend' => 'Votükam kipedöpa: „$1“',
	'repoadmin-edit-path' => 'Kipedöpaluveg:',
	'repoadmin-edit-bug' => 'Luveg ela Bugzilla:',
	'repoadmin-edit-view' => 'Luveg ela ViewVC:',
	'repoadmin-edit-sucess' => 'Kipedöp: "[[Special:Code/$1|$1]]" pebevobon benosekiko.',
	'right-codereview-post-comment' => 'Läükön küpetis dö revids',
	'right-codereview-set-status' => 'Votükön revidastadi',
	'right-codereview-link-user' => 'Yümön lautanis lü vükigebans',
);

/** Yiddish (ייִדיש)
 * @author Imre
 * @author פוילישער
 */
$messages['yi'] = array(
	'code-comments' => 'הערות',
	'code-change-removed' => 'אראפגענומען:',
	'code-change-added' => 'צוגעלייגט:',
	'code-authors' => 'שרייבערס',
	'code-field-id' => 'רעוויזיע',
	'code-field-author' => 'שרייבער',
	'code-field-status' => 'סטאַטוס',
	'code-field-timestamp' => 'דאַטע',
	'code-field-comments' => 'הערות',
	'code-field-select' => 'אויסוויילן',
	'code-rev-author' => 'מחבר:',
	'code-rev-date' => 'דאַטע:',
	'code-rev-message' => 'הערה:',
	'code-rev-rev' => 'רעוויזיע:',
	'code-rev-modified-a' => 'צוגעלייגט',
	'code-rev-modified-d' => 'אויסגעמעקט',
	'code-rev-modified-m' => 'מאדיפֿיצירט',
	'code-rev-status' => 'סטאַטוס:',
	'code-rev-status-set' => 'ענדערן סטאַטוס',
	'code-rev-tags' => 'טאַגן',
	'code-rev-comment-preview' => 'פֿאראויסשטעלונג',
	'code-rev-inline-preview' => 'פֿאראויסשטעלונג:',
	'code-rev-diff' => 'אונטערשייד',
	'code-rev-diff-link' => 'אונטערשייד',
	'code-rev-history-link' => 'היסטאריע',
	'code-status-new' => 'נײַ',
	'code-status-reverted' => 'צוריקגעשטעלט',
	'code-status-ok' => 'אויספֿירן',
	'code-status-old' => 'אַלט',
	'code-signoff-field-user' => 'באַניצער',
	'code-signoff-field-flag' => 'פֿענדל',
	'code-signoff-field-date' => 'דאַטע',
	'code-revfilter-cr_status' => 'סטאַטוס = $1',
	'code-revfilter-cr_author' => 'מחבר = $1',
	'codereview-batch-submit' => 'אײַנגעבן',
	'codereview-subtitle' => 'פֿאַר $1',
	'codereview-reply-link' => 'אָנרופֿן',
	'code-stats' => 'סטאַטיסטיק',
	'repoadmin-new-button' => 'שאַפֿן',
	'repoadmin-edit-button' => 'אויספֿירן',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'code-stats' => 'àwọn statistiki:',
	'repoadmin-edit-button' => 'OK',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'code' => '代碼複查',
	'code-rev-title' => '$1 - 代碼複查',
	'code-comments' => '註解',
	'code-references' => '後繼修訂',
	'code-change-status' => "改咗 $1 嘅'''狀態'''",
	'code-change-tags' => "改咗 $1 嘅'''標籤'''",
	'code-change-removed' => '拎走咗：',
	'code-change-added' => '加咗：',
	'code-old-status' => '舊狀態',
	'code-new-status' => '新狀態',
	'code-prop-changes' => '狀態同標籤紀錄',
	'codereview-desc' => '帶有[[Special:RepoAdmin|Subversion支援]]嘅[[Special:Code|代碼複查工具]]',
	'code-no-repo' => '無檔案庫設定！',
	'code-load-diff' => '載入差異中…',
	'code-notes' => '之前嘅註解',
	'code-statuschanges' => '狀態變動',
	'code-authors' => '作者',
	'code-status' => '狀態',
	'code-tags' => '標籤',
	'code-authors-text' => '下面係檔案庫作者對於最近遞交嘅表。',
	'code-author-haslink' => '呢位作者係連結到wiki用戶$1',
	'code-author-orphan' => '呢位作者無連結到一個wiki戶口',
	'code-author-dolink' => '連結呢位作者到一位用戶：',
	'code-author-alterlink' => '改個wiki用戶到呢位作者：',
	'code-author-orunlink' => '或者唔連結呢一位wiki用戶：',
	'code-author-name' => '輸入一個用戶名：',
	'code-author-success' => '作者$1已經連結到wiki用戶$2',
	'code-author-link' => '連結？',
	'code-author-unlink' => '唔連結？',
	'code-author-unlinksuccess' => '作者$1已經唔再連結',
	'code-field-id' => '修訂',
	'code-field-author' => '作者',
	'code-field-user' => '註解者',
	'code-field-message' => '遞交摘要',
	'code-field-status' => '狀態',
	'code-field-timestamp' => '日期',
	'code-field-comments' => '註',
	'code-field-path' => '路徑',
	'code-field-text' => '註',
	'code-field-select' => '選擇',
	'code-rev-author' => '作者：',
	'code-rev-date' => '日期：',
	'code-rev-message' => '意見：',
	'code-rev-repo' => '檔案庫：',
	'code-rev-rev' => '修訂：',
	'code-rev-rev-viewvc' => '響ViewVC',
	'code-rev-paths' => '修改咗嘅路徑：',
	'code-rev-modified-a' => '加咗',
	'code-rev-modified-r' => '換咗',
	'code-rev-modified-d' => '刪咗',
	'code-rev-modified-m' => '改咗',
	'code-rev-imagediff' => '改圖',
	'code-rev-status' => '狀態：',
	'code-rev-status-set' => '改狀態',
	'code-rev-tags' => '標籤：',
	'code-rev-tag-add' => '加標籤：',
	'code-rev-tag-remove' => '拎走標籤：',
	'code-rev-comment-by' => '$1嘅註解',
	'code-rev-comment-preview' => '預覽',
	'code-rev-diff' => '差異',
	'code-rev-diff-link' => '差異',
	'code-rev-purge-link' => '洗快取',
	'code-status-new' => '新',
	'code-status-fixme' => '修我',
	'code-status-reverted' => '打咗回頭',
	'code-status-resolved' => '解決咗',
	'code-status-ok' => '好',
	'code-status-deferred' => '押後咗',
	'code-pathsearch-legend' => '跟路徑搵呢個檔案庫嘅修訂',
	'code-pathsearch-path' => '路徑：',
	'code-rev-submit' => '保存更改',
	'code-rev-submit-next' => '保存同時跳到下一個未解決嘅',
	'code-batch-status' => '改狀態：',
	'code-batch-tags' => '改標籤：',
	'codereview-batch-title' => '改全部揀咗嘅修訂',
	'codereview-batch-submit' => '遞交',
	'code-releasenotes' => '發行解',
	'code-release-legend' => '產生發行解',
	'code-release-startrev' => '開始修訂：',
	'code-release-endrev' => '最後修訂：',
	'codereview-subtitle' => '$1嘅代碼',
	'codereview-reply-link' => '回覆',
	'codereview-email-subj' => '[$1 $2]：加咗新註解',
	'codereview-email-body' => '用戶 "$1" 響 $3 貼咗一個註解。

完整URL：$2

註解：

$4',
	'codereview-email-subj2' => '[$1 $2]：後繼更改',
	'codereview-email-body2' => '用戶 "$1" 響 $2 整咗後繼更改。

完整URL：$3

遞交摘要：

$4',
	'codereview-email-subj3' => '[$1 $2]：自動測試偵測到表達式問題',
	'codereview-email-body3' => '自動測試發現到響 $1 嘅改動之中出咗表達式問題。

完整URL：$2

遞交摘要：

$3',
	'repoadmin' => '檔案室庫管理',
	'repoadmin-new-legend' => '開一個新檔案庫',
	'repoadmin-new-label' => '檔案庫名：',
	'repoadmin-new-button' => '開',
	'repoadmin-edit-legend' => '檔案庫 "$1" 嘅更改',
	'repoadmin-edit-path' => '檔案庫路徑：',
	'repoadmin-edit-bug' => 'Bugzilla路徑：',
	'repoadmin-edit-view' => 'ViewVC路徑：',
	'repoadmin-edit-button' => '好',
	'repoadmin-edit-sucess' => '檔案庫 "[[Special:Code/$1|$1]]" 已經成功噉改好咗。',
	'right-repoadmin' => '管理代碼檔案庫',
	'right-codereview-use' => '用Special:Code',
	'right-codereview-add-tag' => '加新標籤到修訂',
	'right-codereview-remove-tag' => '響修訂度拎走標籤',
	'right-codereview-post-comment' => '響修訂度加註解',
	'right-codereview-set-status' => '改修訂狀態',
	'right-codereview-link-user' => '連結作者到wiki用戶',
	'specialpages-group-developer' => '開發者工具',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Anakmalaysia
 * @author Chenzw
 * @author Gaoxuewei
 * @author Hydra
 * @author Kuailong
 * @author Liangent
 * @author PhiLiP
 * @author Wmr89502270
 * @author Xiaomingyan
 * @author 阿pp
 */
$messages['zh-hans'] = array(
	'code' => '代码复审',
	'code-rev-title' => '$1 - 代码复审',
	'code-comments' => '评论',
	'code-references' => '后续修订',
	'code-referenced' => '随访的修订',
	'code-change-status' => "改变了$1的'''状态'''",
	'code-change-tags' => "改变了$1的'''标签'''",
	'code-change-removed' => '移除：',
	'code-change-added' => '增加：',
	'code-old-status' => '旧状态',
	'code-new-status' => '新状态',
	'code-prop-changes' => '状态和标签日志',
	'codereview-desc' => '[[Special:RepoAdmin|支持Subversion]]的[[Special:Code|代码复审工具]]',
	'code-no-repo' => '未配置版本库！',
	'code-create-repo' => '前往[[Special:RepoAdmin|版本库管理]]创建版本库',
	'code-need-repoadmin-rights' => '需要版本库管理权限来创建版本库',
	'code-need-group-with-rights' => '不存在具有版本库管理权限的用户组，请为特定组增加权限以新建版本库',
	'code-repo-not-found' => "版本库'''$1'''不存在！",
	'code-load-diff' => '加载差异中……',
	'code-notes' => '最近评论',
	'code-statuschanges' => '状态更改',
	'code-mycommits' => '我的提交',
	'code-mycomments' => '我的评论',
	'code-authors' => '作者',
	'code-status' => '状态',
	'code-tags' => '标签',
	'code-tags-no-tags' => '此版本库中没有任何标签。',
	'code-authors-text' => '下面给出了按提交者名称排序的版本库作者列表。与本地Wiki对应的帐户会被括注写出。数据可能被缓存。',
	'code-author-haslink' => '该作者和Wiki用户$1相关联',
	'code-author-orphan' => 'SVN用户或作者$1未与Wiki帐户关联',
	'code-author-dolink' => '将作者与Wiki用户关联：',
	'code-author-alterlink' => '修改作者与Wiki用户的关联：',
	'code-author-orunlink' => '或取消该Wiki用户的关联：',
	'code-author-name' => '输入用户名：',
	'code-author-success' => '作者$1已与Wiki用户$2关联',
	'code-author-link' => '关联？',
	'code-author-unlink' => '取消关联？',
	'code-author-unlinksuccess' => '取消作者$1的关联',
	'code-author-badtoken' => '试图执行操作的会话错误。',
	'code-author-total' => '作者总数：$1',
	'code-author-lastcommit' => '最近提交日期',
	'code-browsing-path' => "正在浏览'''$1'''中的修订",
	'code-field-id' => '版本',
	'code-field-author' => '作者',
	'code-field-user' => '评论者',
	'code-field-message' => '提交摘要',
	'code-field-status' => '状态',
	'code-field-status-description' => '状态说明',
	'code-field-timestamp' => '日期',
	'code-field-comments' => '评论',
	'code-field-path' => '路径',
	'code-field-text' => '评论',
	'code-field-select' => '选择',
	'code-reference-remove' => '移除选定的关联修订',
	'code-reference-associate' => '关联后续修订：',
	'code-reference-associate-submit' => '关联',
	'code-rev-author' => '作者：',
	'code-rev-date' => '日期：',
	'code-rev-message' => '评论：',
	'code-rev-repo' => '版本库：',
	'code-rev-rev' => '版本：',
	'code-rev-rev-viewvc' => '在ViewVC上查看',
	'code-rev-paths' => '修改路径：',
	'code-rev-modified-a' => '增加',
	'code-rev-modified-r' => '替代',
	'code-rev-modified-d' => '删除',
	'code-rev-modified-m' => '修改',
	'code-rev-imagediff' => '图像更改',
	'code-rev-status' => '状态：',
	'code-rev-status-set' => '更改状态',
	'code-rev-tags' => '标签：',
	'code-rev-tag-add' => '添加标签：',
	'code-rev-tag-remove' => '移除标签：',
	'code-rev-comment-by' => '$1的评论',
	'code-rev-comment-preview' => '预览',
	'code-rev-inline-preview' => '预览：',
	'code-rev-diff' => '差异',
	'code-rev-diff-link' => '差异',
	'code-rev-diff-too-large' => '该差异太大，无法显示。',
	'code-rev-purge-link' => '清除',
	'code-rev-total' => '结果总数：$1',
	'code-rev-not-found' => "修订'''$1'''不存在！",
	'code-rev-history-link' => '历史',
	'code-status-new' => '新',
	'code-status-desc-new' => '该修订正在等待操作（默认状态）。',
	'code-status-fixme' => '修正',
	'code-status-desc-fixme' => '该修订引入了错误或已被损坏，应被修正或撤销。',
	'code-status-reverted' => '撤销',
	'code-status-desc-reverted' => '该修订已被更高版本的修订撤销。',
	'code-status-resolved' => '解决',
	'code-status-desc-resolved' => '该修订存在的问题已被更高版本的修订处理。',
	'code-status-ok' => '确定',
	'code-status-desc-ok' => '该修订已被全面复查，复查者认为它无可挑剔。',
	'code-status-deferred' => '推迟',
	'code-status-desc-deferred' => '该修订无需复查。',
	'code-status-old' => '旧',
	'code-status-desc-old' => '带有潜在错误的旧修订，但不值得付诸复审。',
	'code-signoffs' => '确认',
	'code-signoff-legend' => '添加确认',
	'code-signoff-submit' => '确认',
	'code-signoff-strike' => '取消选定的确认',
	'code-signoff-signoff' => '该修订的确认状态为：',
	'code-signoff-flag-inspected' => '已检查',
	'code-signoff-flag-tested' => '已测试',
	'code-signoff-field-user' => '用户',
	'code-signoff-field-flag' => '标志',
	'code-signoff-field-date' => '日期',
	'code-signoff-struckdate' => '$1（取消于$2）',
	'code-pathsearch-legend' => '在该版本库中按路径搜索修订',
	'code-pathsearch-path' => '路径：',
	'code-pathsearch-filter' => '仅显示：',
	'code-revfilter-cr_status' => '状态 = $1',
	'code-revfilter-cr_author' => '作者= $1',
	'code-revfilter-ct_tag' => '标签 = $1',
	'code-revfilter-clear' => '清除筛选器',
	'code-rev-submit' => '保存更改',
	'code-rev-submit-next' => '保存，并处理下一条',
	'code-rev-next' => '下一条未解决',
	'code-batch-status' => '更改状态：',
	'code-batch-tags' => '更改标签：',
	'codereview-batch-title' => '更改所有选定的修订',
	'codereview-batch-submit' => '提交',
	'code-releasenotes' => '发行说明',
	'code-release-legend' => '生成发行说明',
	'code-release-startrev' => '开始修订：',
	'code-release-endrev' => '结束修订：',
	'codereview-subtitle' => '版本库$1',
	'codereview-reply-link' => '回复',
	'codereview-overview-title' => '概述',
	'codereview-overview-desc' => '显示此列表的图形概述',
	'codereview-email-subj' => '[$1 $2]：新的评论已添加',
	'codereview-email-body' => '用户“$1”在$3上发表了评论。

完整URL：$2
提交摘要：

$5

评论：

$4',
	'codereview-email-subj2' => '[$1 $2]：后续更改',
	'codereview-email-body2' => '用户“$1”对$2作出了后续更改。

后续修订的完整URL：$5
提交摘要：

$6

完整URL：$3
提交摘要：

$4',
	'codereview-email-subj3' => '[$1 $2]：修订状态改变',
	'codereview-email-body3' => '用户“$1”更改了$2的状态。

原状态：$3
新状态：$4

完整URL：$5
提交摘要：

$6',
	'codereview-email-subj4' => '[$1 $2]：新的评论已添加，修订状态改变',
	'codereview-email-body4' => '用户“$1”更改了$2的状态。

旧状态：$3
新状态：$4

用户“$1”还在$2上发表了评论。

完整URL：$5
提交摘要：

$7

评论：

$6',
	'code-stats' => '统计信息',
	'code-stats-header' => '版本库$1的统计信息',
	'code-stats-main' => '截至$1，该版本库共有$2次{{PLURAL:$2|修订|修订}}和[[Special:Code/$3/author|$4名{{PLURAL:$4|作者|作者}}]]。',
	'code-stats-status-breakdown' => '按状态划分的修订统计',
	'code-stats-fixme-breakdown' => '按作者待修正修订的分项统计',
	'code-stats-fixme-breakdown-path' => '按路径修正修订的分项统计',
	'code-stats-fixme-path' => '$1路径的修正修订',
	'code-stats-new-breakdown' => '按作者新修订的分项统计',
	'code-stats-new-breakdown-path' => '按路径新修订的分项统计',
	'code-stats-new-path' => '$1路径的新修订',
	'code-stats-count' => '修订数',
	'code-tooltip-withsummary' => 'r$1 [$2] $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] $3',
	'repoadmin' => '版本库管理',
	'repoadmin-new-legend' => '新建版本库',
	'repoadmin-new-label' => '版本库名称：',
	'repoadmin-new-button' => '创建',
	'repoadmin-edit-legend' => '修改版本库“$1”',
	'repoadmin-edit-path' => '版本库路径：',
	'repoadmin-edit-bug' => 'Bugzilla路径：',
	'repoadmin-edit-view' => 'ViewVC路径：',
	'repoadmin-edit-button' => '确定',
	'repoadmin-edit-sucess' => '版本库“[[Special:Code/$1|$1]]”已被成功修改。',
	'repoadmin-nav' => '版本库管理',
	'right-repoadmin' => '管理代码版本库',
	'right-codereview-use' => '使用Special:Code',
	'right-codereview-add-tag' => '给修订添加新标签',
	'right-codereview-remove-tag' => '移除修订的标签',
	'right-codereview-post-comment' => '向修订发表评论',
	'right-codereview-set-status' => '修改修订状态',
	'right-codereview-signoff' => '确认修订',
	'right-codereview-link-user' => '将作者与Wiki用户关联',
	'right-codereview-associate' => '管理修订关联',
	'right-codereview-review-own' => '将自己的修订标记为确定或解决',
	'specialpages-group-developer' => '开发者工具',
	'group-svnadmins' => 'SVN管理员',
	'group-svnadmins-member' => '{{GENDER:$1|SVN管理员}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN管理员',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Anakmalaysia
 * @author FireJackey
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Skjackey tse
 * @author Waihorace
 */
$messages['zh-hant'] = array(
	'code' => '預覽程式碼',
	'code-rev-title' => '$1 - 代碼複核',
	'code-comments' => '附註',
	'code-references' => '後續修訂',
	'code-change-status' => "改變了$1的'''狀態'''",
	'code-change-tags' => "改變了$1的'''標籤'''",
	'code-change-removed' => '移除：',
	'code-change-added' => '增加：',
	'code-old-status' => '舊狀態',
	'code-new-status' => '新狀態',
	'code-prop-changes' => '狀態或標籤日誌',
	'codereview-desc' => '[[Special:Code|程式碼預覽工具]] with [[Special:RepoAdmin|子版本支援]]',
	'code-no-repo' => '沒有存放配置！',
	'code-create-repo' => '前往[[Special:RepoAdmin|版本庫管理]]創建版本庫',
	'code-need-repoadmin-rights' => '需要版本庫管理權限來創建版本庫',
	'code-need-group-with-rights' => '沒有任何具有版本庫管理權限的用戶組，請為特定組增加權限以新建版本庫',
	'code-repo-not-found' => "儲存庫'''$1'''不存在！",
	'code-load-diff' => '載入差異 ...',
	'code-notes' => '新近發言',
	'code-statuschanges' => '更改狀態',
	'code-mycommits' => '我的提交',
	'code-mycomments' => '我的評論',
	'code-authors' => '作者',
	'code-status' => '狀態',
	'code-tags' => '標籤',
	'code-tags-no-tags' => '此儲存庫中不存在的任何標記。',
	'code-authors-text' => '下面給出了按提交者名稱排序的版本庫作者列表。與本地維基項目對應的帳戶會被括注寫出。數據可能被緩存',
	'code-author-haslink' => '此作者與維基用戶$1連結',
	'code-author-orphan' => 'SVN用戶或作者$1未與維基項目帳戶關聯',
	'code-author-dolink' => '連結此作者至維基用戶：',
	'code-author-alterlink' => '改變此作者與維基用戶連結：',
	'code-author-orunlink' => '或者取消這個維基用戶的關聯：',
	'code-author-name' => '輸入用戶名：',
	'code-author-success' => '作者 $1 已經與維基用戶 $2 相關聯',
	'code-author-link' => '相關聯？',
	'code-author-unlink' => '取消關聯？',
	'code-author-unlinksuccess' => '作者 $1 已經取消關聯',
	'code-author-badtoken' => '會話錯誤嘗試執行的操作。',
	'code-author-total' => '作者總數：$1',
	'code-author-lastcommit' => '最後提交日期',
	'code-browsing-path' => "正在瀏覽在'''$1'''的修改",
	'code-field-id' => '修訂',
	'code-field-author' => '作者',
	'code-field-user' => '評論員',
	'code-field-message' => '評論匯總',
	'code-field-status' => '狀態',
	'code-field-status-description' => '狀態說明',
	'code-field-timestamp' => '日期',
	'code-field-comments' => '評論',
	'code-field-path' => '路徑',
	'code-field-text' => '註釋',
	'code-field-select' => '選定',
	'code-reference-remove' => '移除選定的關聯',
	'code-reference-associate' => '關聯後續修訂：',
	'code-reference-associate-submit' => '將相關聯',
	'code-rev-author' => '作者：',
	'code-rev-date' => '日期：',
	'code-rev-message' => '評論：',
	'code-rev-repo' => '儲存庫：',
	'code-rev-rev' => '修訂：',
	'code-rev-rev-viewvc' => '在ViewVC上',
	'code-rev-paths' => '修改路徑：',
	'code-rev-modified-a' => '增加',
	'code-rev-modified-r' => '替代',
	'code-rev-modified-d' => '刪除',
	'code-rev-modified-m' => '修改',
	'code-rev-imagediff' => '檔案更改',
	'code-rev-status' => '狀態：',
	'code-rev-status-set' => '更改狀態',
	'code-rev-tags' => '標籤：',
	'code-rev-tag-add' => '新增標籤：',
	'code-rev-tag-remove' => '移除標籤：',
	'code-rev-comment-by' => '$1 的評論',
	'code-rev-comment-preview' => '預覽',
	'code-rev-inline-preview' => '預覽：',
	'code-rev-diff' => '差異',
	'code-rev-diff-link' => '差異',
	'code-rev-diff-too-large' => '該差異太大，無法顯示。',
	'code-rev-purge-link' => '清除',
	'code-rev-total' => '總共有$1個結果',
	'code-rev-not-found' => "修訂'''$1'''不存在！",
	'code-rev-history-link' => '歷史',
	'code-status-new' => '新',
	'code-status-desc-new' => '修訂是掛起的操作 （預設狀態）。',
	'code-status-fixme' => '修正',
	'code-status-desc-fixme' => '該修訂引入了錯誤或已被損壞，應被修正或撤銷。',
	'code-status-reverted' => '回復',
	'code-status-desc-reverted' => '該修訂已被更高版本的修訂撤銷。',
	'code-status-resolved' => '解決',
	'code-status-desc-resolved' => '該修訂存在的問題已被更高版本的修訂處理。',
	'code-status-ok' => '確定',
	'code-status-desc-ok' => '修訂全面審查，確保它是好在每個方法中審閱者。',
	'code-status-deferred' => '推遲',
	'code-status-desc-deferred' => '修訂並不要求審查。',
	'code-status-old' => '舊',
	'code-status-desc-old' => '與潛在的錯誤，但這不值得檢討他們的努力的舊版本。',
	'code-signoffs' => '簽收',
	'code-signoff-legend' => '新增簽收',
	'code-signoff-submit' => '批准',
	'code-signoff-strike' => '取消選定的確認',
	'code-signoff-signoff' => '該修訂的確認狀態為：',
	'code-signoff-flag-inspected' => '檢查過',
	'code-signoff-flag-tested' => '測試過了',
	'code-signoff-field-user' => '用戶',
	'code-signoff-field-flag' => '標記',
	'code-signoff-field-date' => '日期',
	'code-signoff-struckdate' => '$1（打$2）',
	'code-pathsearch-legend' => '在此進行回購協議的路徑中搜尋修訂',
	'code-pathsearch-path' => '路徑：',
	'code-pathsearch-filter' => '只顯示：',
	'code-revfilter-cr_status' => '狀態 = $1',
	'code-revfilter-cr_author' => '作者= $1',
	'code-revfilter-ct_tag' => '標籤 = $1',
	'code-revfilter-clear' => '清除過濾器',
	'code-rev-submit' => '儲存修改',
	'code-rev-submit-next' => '保存，並處理下一條',
	'code-rev-next' => '下一條未解決',
	'code-batch-status' => '更改狀態：',
	'code-batch-tags' => '更改標籤：',
	'codereview-batch-title' => '更改所有已選的版本',
	'codereview-batch-submit' => '提交',
	'code-releasenotes' => '發佈說明',
	'code-release-legend' => '產發發佈說明',
	'code-release-startrev' => '開始修訂：',
	'code-release-endrev' => '結束修訂：',
	'codereview-subtitle' => '對$1',
	'codereview-reply-link' => '回覆',
	'codereview-overview-title' => '概述',
	'codereview-overview-desc' => '顯示此列表的圖形概述',
	'codereview-email-subj' => '[$1 $2]: 新的評論已添加',
	'codereview-email-body' => '用戶“$1”在$3上發表了評論。

完整URL：$2
提交摘要：

$5

評論：

$4',
	'codereview-email-subj2' => '[$1 $2]：後續更改',
	'codereview-email-body2' => '用戶“$1”對$2作出了後續更改。

後續修訂的完整URL：$5
提交摘要：

$6

完整URL：$3
提交摘要：

$4',
	'codereview-email-subj3' => '[$1 $2]：修訂狀態改變',
	'codereview-email-body3' => '用戶“$1”更改了$2的狀態。

原狀態：$3
新狀態：$4

完整URL：$5
提交摘要：

$6',
	'codereview-email-subj4' => '[$1 $2]： 新增，新的註釋和修訂狀態改變',
	'codereview-email-body4' => '用戶“$1”更改了$2的狀態。

舊狀態：$3
新狀態：$4

用戶“$1”還在$2上發表了評論。

完整URL：$5
提交摘要：

$7

評論：

$6',
	'code-stats' => '統計',
	'code-stats-header' => '$1 儲存庫的統計資訊',
	'code-stats-main' => '$1的儲存庫已$2{{PLURAL:$2|修改|修改}}的[[Special:Code/$3/author|$4{{PLURAL:$4|作者|作者}}]]。',
	'code-stats-status-breakdown' => '每情況修訂的數目',
	'code-stats-fixme-breakdown' => '按作者修正修訂的分項統計',
	'code-stats-fixme-breakdown-path' => '按路徑修正修訂的分項統計',
	'code-stats-fixme-path' => '$1路徑的修正修訂',
	'code-stats-new-breakdown' => '按作者新修訂的分項統計',
	'code-stats-new-breakdown-path' => '按路徑新修訂的分項統計',
	'code-stats-new-path' => '$1路徑的新修訂',
	'code-stats-count' => '修訂的數目',
	'code-tooltip-withsummary' => 'r$1 [$2] $3 - $4',
	'code-tooltip-withoutsummary' => 'r$1 [$2] $3',
	'repoadmin' => '儲存庫管理',
	'repoadmin-new-legend' => '建立新的儲存庫',
	'repoadmin-new-label' => '儲存庫名稱：',
	'repoadmin-new-button' => '建立',
	'repoadmin-edit-legend' => '修改儲存庫"$1"',
	'repoadmin-edit-path' => '儲存庫路徑：',
	'repoadmin-edit-bug' => 'Bugzilla路徑：',
	'repoadmin-edit-view' => 'ViewVC路徑：',
	'repoadmin-edit-button' => '確定',
	'repoadmin-edit-sucess' => '儲存庫"[[Special:Code/$1|$1]]"已被成功修改。',
	'repoadmin-nav' => '儲存庫管理',
	'right-repoadmin' => '管理代碼儲存庫',
	'right-codereview-use' => '使用Special:Code',
	'right-codereview-add-tag' => '添加新標籤到修訂',
	'right-codereview-remove-tag' => '自修訂移除標籤',
	'right-codereview-post-comment' => '添加評論到修訂',
	'right-codereview-set-status' => '修改修訂狀態',
	'right-codereview-signoff' => '登入修訂',
	'right-codereview-link-user' => '將作者連結到維基用戶',
	'right-codereview-associate' => '管理修訂關聯',
	'right-codereview-review-own' => '將自己的修訂標記為確定或解決',
	'specialpages-group-developer' => '開發者工具',
	'group-svnadmins' => 'SVN管理員',
	'group-svnadmins-member' => '{{GENDER:$1|SVN管理員}}',
	'grouppage-svnadmins' => '{{ns:project}}:SVN管理員',
);

