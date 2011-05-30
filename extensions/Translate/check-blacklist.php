<?php
/**
 * List of checks that should not be performed.
 *
 * @todo Use YAML?
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * The array takes input of arrays which define constraints. Checks which match
 * those constrains are skipped. Possible constrains are <tt>group</tt>,
 * <tt>check</tt>, <tt>code</tt> and <tt>message</tt>.
 */
$checkBlacklist = array(
array(
	'check' => 'plural',
	'code' => array( 'az', 'bo', 'dz', 'id', 'fa', 'gan', 'gan-hans',
		'gan-hant', 'gn', 'hak', 'hu', 'ja', 'jv', 'ka', 'kk-arab',
		'kk-cyrl', 'kk-latn', 'km', 'kn', 'ko', 'lzh', 'mn', 'ms',
		'my', 'sah', 'sq', 'tet', 'th', 'to', 'tr', 'vi', 'wuu', 'xmf',
		'yo', 'yue', 'zh', 'zh-classical', 'zh-cn', 'zh-hans',
		'zh-hant', 'zh-hk', 'zh-sg', 'zh-tw', 'zh-yue'
	),
),
array(
	'group' => 'core',
	'check' => 'variable',
	'message' => array(
		'activeusers-count', // Optional GENDER parameter
		'autoblockedtext', // Optional GENDER parameter
		'blocked-notice-logextract', // Optional GENDER parameter
		'blocklog-showlog', // Optional GENDER parameter
		'blocklog-showsuppresslog', // Optional GENDER parameter
		'confirmemail_body', // Optional time parameters
		'confirmemail_body_changed', // Optional time parameters
		'confirmemail_body_set', // Optional time parameters
		'currentrev-asof', // Optional time parameters
		'filehist-thumbtext', // Optional time parameters
		'history-feed-item-nocomment', // Optional time parameters
		'lastmodifiedatby', // Optional time parameters
		'listusers-blocked', // Optional GENDER parameter
		'login-userblocked', // Optional GENDER parameter
		'othercontribs', // Optional count parameter
		'perfcachedts', // Optional time parameters
		'prefs-memberingroups-type', // Optional parameter for group name
		'prefs-registration-date-time', // Optional time parameters
		'protect-expiring', // Optional time parameters
		'rcnotefrom', // Optional time parameters
		'revision-info', // Optional time parameters
		'revisionasof', // Optional time parameters
		'siteuser', // Optional GENDER parameter
		'sp-contributions-blocked-notice', // Optional GENDER parameter
		'diff-multi-manyusers',
		'userrights-groupsmember', // Optional PLURAL parameter
		'userrights-groupsmember-auto', // Optional PLURAL parameter
		'userrights-changeable-col', // Optional PLURAL parameter
		'userrights-unchangeable-col', // Optional PLURAL parameter
	),
),
array(
	'group' => 'core',
	'check' => 'plural',
	'message' => array(
		'diff-multi-manyusers', // Likely to not be needed in languages with same plural as English (many)
	),
),
array(
	'group' => 'ext-abusefilter',
	'check' => 'variable',
	'message' => array(
		'abusefilter-edit-lastmod-text', // Optional username parameter for GENDER, optional time parameters
		'abusefilter-reautoconfirm-none', // Optional username parameter for GENDER
	)
),
array(
	'group' => 'ext-advancedrandom',
	'check' => 'links',
	'message' => array(
		'advancedrandom-desc', // Contains link parts that may need translation
	)
),
array(
	'group' => 'ext-articleassessmentpilot',
	'check' => 'links',
	'message' => array(
		'articleassessment-results-show', // Contains incomplete wiki link that get rewritten by JavaScript
		'articleassessment-results-hide', // Contains incomplete wiki link that get rewritten by JavaScript
	)
),
array(
	'group' => 'ext-babel',
	'check' => 'variable',
	'message' => array(
		'babel', // Optional GENDER parameter
		'babel-0', // Optional GENDER parameter
		'babel-1', // Optional GENDER parameter
		'babel-2', // Optional GENDER parameter
		'babel-3', // Optional GENDER parameter
		'babel-4', // Optional GENDER parameter
		'babel-5', // Optional GENDER parameter
		'babel-N', // Optional GENDER parameter
		'babel-0-n', // Optional GENDER parameter
		'babel-1-n', // Optional GENDER parameter
		'babel-2-n', // Optional GENDER parameter
		'babel-3-n', // Optional GENDER parameter
		'babel-4-n', // Optional GENDER parameter
		'babel-5-n', // Optional GENDER parameter
		'babel-N-n', // Optional GENDER parameter
	)
),
array(
	'group' => 'ext-blahtex',
	'check' => 'balance',
	'message' => array(
		'math_MissingOpenBraceAfter', // Contains unbalanced {
		'math_MissingOpenBraceAtEnd', // Contains unbalanced {
		'math_MissingOpenBraceBefore', // Contains unbalanced {
	)
),
array(
	'group' => 'ext-call',
	'check' => 'links',
	'message' => array(
		'call-text', // Contains links that are translated
	)
),
array(
	'group' => 'ext-categorytree',
	'check' => 'variable',
	'message' => array(
		'Categorytree-member-counts', // Optional counts: $4, and $5
	)
),
array(
	'group' => 'ext-centralauth',
	'check' => 'links',
	'message' => array(
		'centralauth-readmore-text', // Contains link to page that may be available in a translated version
		'centralauth-finish-problems', // Contains link to page that may be available in a translated version
	)
),
array(
	'group' => 'ext-checkpoint',
	'check' => 'links',
	'message' => array(
		'checkpoint-notice', // Contains link parts that may need translation
	)
),
array(
	'group' => 'ext-codereview',
	'check' => 'variable',
	'message' => array(
		'code-stats-main', // Optional time parameters
	)
),
array(
	'group' => 'ext-confirmaccount',
	'check' => 'variable',
	'message' => array(
		'requestaccount-email-body', // Optional time parameters
		'confirmaccount-reject', // Optional time parameters
		'confirmaccount-held', // Optional time parameters
	)
),
array(
	'group' => 'ext-configure',
	'check' => 'variable',
	'message' => array(
		'configure-condition-description-4', // Optional parameter for PLURAL
		'configure-edit-old', // Optional time parameters
		'configure-old-summary-datetime', // Optional time parameters
		'configure-viewconfig-line', // Optional time parameters
	)
),
array(
	'group' => 'ext-contributionseditcount',
	'check' => 'variable',
	'message' => array(
		'contributionseditcount', // Optional GENDER parameter
	)
),
array(
	'group' => 'ext-deletequeue',
	'check' => 'variable',
	'message' => array(
		'deletequeue-page-prod', // Optional time parameters
		'deletequeue-page-deletediscuss', // Optional time parameters
	)
),
array(
	'group' => 'ext-editsubpages',
	'check' => 'links',
	'message' => array(
		'unlockedpages', // Contains links that are translated
	)
),
array(
	'group' => 'ext-farmer',
	'check' => 'links',
	'message' => array(
		'farmer-confirmsetting-text', // Contains links that are translated
	)
),
array(
	'group' => 'ext-flagpage',
	'check' => 'links',
	'message' => array(
		'flagpage-templatelist', // Contains link in HTML comment
	)
),
array(
	'group' => 'ext-flaggedrevs-configuredpages',
	'check' => 'variable',
	'message' => array(
		'configuredpages-list', // Parameter $1 only used when required for plural
	)
),
array(
	'group' => 'ext-flaggedrevs-pendingchanges',
	'check' => 'variable',
	'message' => array(
		'pendingchanges-list', // Parameter $1 only used when required for plural
	)
),
array(
	'group' => 'ext-flaggedrevs-problemchanges',
	'check' => 'variable',
	'message' => array(
		'problemchanges-list', // Parameter $1 only used when required for plural
	)
),
array(
	'group' => 'ext-flaggedrevs-qualityoversight',
	'check' => 'variable',
	'message' => array(
		'qualityoversight-list', // Parameter $1 only used when required for plural
	)
),
array(
	'group' => 'ext-flaggedrevs-reviewedpages',
	'check' => 'variable',
	'message' => array(
		'reviewedpages-list', // Parameter $1 only used when required for plural
	)
),
array(
	'group' => 'ext-flaggedrevs-reviewedversions',
	'check' => 'variable',
	'message' => array(
		'reviewedversions-review', // Optional time parameters, and name for GENDER
	)
),
array(
	'group' => 'ext-flaggedrevs-stabilization',
	'check' => 'variable',
	'message' => array(
		'stabilize-expiring', // Optional time parameters
	)
),
array(
	'group' => 'ext-flaggedrevs-stablepages',
	'check' => 'variable',
	'message' => array(
		'stablepages-list', // Parameter $1 only used when required for plural
	)
),
array(
	'group' => 'ext-flaggedrevs-unreviewedpages',
	'check' => 'variable',
	'message' => array(
		'unreviewedpages-list', // Parameter $1 only used when required for plural
	)
),
array(
	'group' => 'ext-liquidthreads',
	'check' => 'variable',
	'message' => array(
		'lqt-feed-new-thread-intro', // Optional GENDER parameter
		'lqt-feed-reply-intro', // Optional GENDER parameter
		'lqt-feed-title-all-from', // Optional PLURAL parameter ($2)
		'lqt-feed-title-new-threads-from', // Optional PLURAL parameter ($2)
		'lqt-feed-title-replies-from', // Optional PLURAL parameter ($2)
		'lqt-thread-edited-others',  // Optional date and time parameters ($3/$4)
		'lqt-thread-edited-author',  // Optional count, date and time parameters ($2/$3/$4)
	)
),
array(
	'group' => 'ext-newusernotification',
	'check' => 'variable',
	'message' => array(
		'newusernotifbody', // Optional time parameters
	)
),
array(
	'group' => 'ext-openstackmanager',
	'check' => 'plural',
	'code' => array( 'fr' ),
	'message' => array(
		'openstackmanager-instancetypelabel', // PLURAL not needed in French
	)
),
array(
	'group' => 'ext-socialprofile-usergifts',
	'check' => 'variable',
	'message' => array(
		'g-created-by', // Optional GENDER parameter
	)
),
array(
	'group' => 'ext-qpoll',
	'check' => 'variable',
	'message' => array(
		'qp_user_polls_link', // Optional GENDER parameter
		'qp_user_missing_polls_link', // Optional GENDER parameter
	)
),
array(
	'group' => 'ext-regexblock',
	'check' => 'variable',
	'message' => array(
		'regexblock-match-stats-record', // Optional time parameters
		'regexblock-view-time', // Optional time parameters
	)
),
array(
	'group' => 'ext-renameuser',
	'check' => 'variable',
	'message' => array(
		'renameuser-renamed-notice', // Optional GENDER parameter
	)
),
array(
	'group' => 'ext-socialprofile-useractivity',
	'check' => 'variable',
	'message' => array(
		'useractivity-edit', // Optional GENDER parameter
		'useractivity-foe', // Optional GENDER parameter
		'useractivity-friend', // Optional GENDER parameter
		'useractivity-gift', // Optional GENDER parameter
		'useractivity-group-comment', // Optional GENDER parameter
		'useractivity-group-edit', // Optional GENDER parameter
		'useractivity-group-friend', // Optional GENDER parameter
		'useractivity-group-user_message', // Optional GENDER parameter
		'useractivity-user_message', // Optional GENDER parameter
	)
),
array(
	'group' => 'ext-titleblacklist',
	'check' => 'variable',
	'code' => array(
		'gan', 'gan-hans', 'gan-hant', 'gn', 'hak', 'hu', 'ja',
		'ka', 'kk-arab', 'kk-cyrl', 'kk-latn', 'ko', 'lzh', 'mn', 'ms', 'sah', 'sq',
		'tet', 'th', 'wuu', 'xmf', 'yue', 'zh', 'zh-classical', 'zh-cn', 'zh-hans',
		'zh-hant', 'zh-hk', 'zh-sg', 'zh-tw', 'zh-yue'
	),
	'message' => array(
		'titleblacklist-invalid', // Param only used in plural
	)
),
array(
	'group' => 'ext-translate-core',
	'check' => 'links',
	'message' => array(
		'supportedlanguages-summary', // Contains links that are translated
	)
),
array(
	'group' => 'ext-translate-firststeps',
	'check' => 'links',
	'message' => array(
		'translate-fs-signup-text', // Contains links that are translated
	)
),
array(
	'group' => 'ext-wikieditor',
	'check' => 'links',
	'message' => array(
		'wikieditor-toolbar-help-content-ilink-syntax', // Contains links that are translated
		'wikieditor-toolbar-help-content-file-syntax', // Contains links that are translated
	)
),
array(
	'group' => 'ext-wikilog',
	'check' => 'variable',
	'message' => array(
		'wikilog-comment-note-edited', // Optional parameter $3
		'wikilog-summary-categories', // Optional PLURAL parameter ($1)
		'wikilog-summary-footer', // Optional parameters $3, $4, $5, $6
		'wikilog-summary-footer-single', // Optional parameters $1, $2, $3, $4, $5, $6
	)
),
array(
	'group' => 'out-fudforum',
	'check' => 'variable',
	'message' => array(
		'page_timings', // Optional parameter for PLURAL
	)
),
array(
	'group' => 'out-fudforum',
	'check' => 'parameters',
	'message' => array(
		'page_timings', // Optional parameter for PLURAL
	)
),
array(
	'group' => 'out-osm-site',
	'check' => 'parameters',
	'message' => array(
		'notifier.signup_confirm_html.user_wiki_page', // Contains links that are translated
		'notifier.signup_confirm_plain.user_wiki_2', // Contains links that are translated
	)
),
array(
	'group' => 'wikia-categoryselect',
	'check' => 'links',
	'message' => array(
		'categoryselect-tooltip', // Contains link parts that may need translation
	)
),
array(
	'group' => 'wikia-createnewwiki',
	'check' => 'variable',
	'message' => array(
		'cnw-upgrade-marketing', // Contains price with "$" which causes warnings when formatting differently.
	)
),
array(
	'group' => 'wikia-graceexpired',
	'check' => 'links',
	'message' => array(
		'graceexpired-header', // Contains link parts that may need translation
	)
),
array(
	'group' => 'wikia-problemreports',
	'check' => 'links',
	'message' => array(
		'pr_introductory_text', // Contains link parts that may need translation
	)
),
array(
	'group' => 'wikia-sharedhelp',
	'check' => 'links',
	'message' => array(
		'sharedhelp-desc', // Contains link parts that may need translation
	)
),
array(
	'group' => 'wikia-specialsponsorpage',
	'check' => 'variable',
	'message' => array(
		'sponsor-price-45yr', // Contains $ sign that can be translated differently.
		'sponsor-price-5mo', // Contains $ sign that can be translated differently.
	)
),
array(
	'group' => 'wikia-stafflog',
	'check' => 'variable',
	'message' => array(
		'stafflog-piggybackloginmsg', // Contains optional additional parameters.
		'stafflog-piggybacklogoutmsg', // Contains optional additional parameters.
	)
),
// translatewiki.net specific
array(
	'group' => 'page|Translating:Intro',
	'check' => 'links',
	'message' => array(
		'Translating:Intro/intro', // Contains links that are translated
	)
),
);
