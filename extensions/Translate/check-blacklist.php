<?php

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
		'currentrev-asof', // Optional time parameters
		'filehist-thumbtext', // Optional time parameters
		'history-feed-item-nocomment', // Optional time parameters
		'lastmodifiedatby', // Optional time parameters
		'listusers-blocked', // Optional GENDER parameter
		'login-userblocked', // Optional GENDER parameter
		'perfcachedts', // Optional time parameters
		'prefs-memberingroups-type', // Optional parameter for group name
		'prefs-registration-date-time', // Optional time parameters
		'protect-expiring', // Optional time parameters
		'rcnotefrom', // Optional time parameters
		'revision-info', // Optional time parameters
		'revisionasof', // Optional time parameters
		'sp-contributions-blocked-notice', // Optional GENDER parameter
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
		'advancedrandom-desc', // Contains link parts that may need translations
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
	'group' => 'ext-flaggedrevs-reviewedpages',
	'check' => 'variable',
	'message' => array(
		'reviewedpages-list', // Parameter only used when required for plural
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
	'group' => 'ext-liquidthreads',
	'check' => 'variable',
	'message' => array(
		'lqt-feed-new-thread-intro', // Optional GENDER parameter
		'lqt-feed-reply-intro', // Optional GENDER parameter
		'lqt-feed-title-all-from', // Optional PLURAL parameter ($2)
		'lqt-feed-title-new-threads-from', // Optional PLURAL parameter ($2)
		'lqt-feed-title-replies-from', // Optional PLURAL parameter ($2)
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
	'group' => 'ext-ui-wikieditor-toolbar',
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
		'wikilog-summary-categories', // Optional PLURAL parameter ($1)
		'wikilog-summary-footer', // Optional parameters $3, $4, $5, $6
		'wikilog-summary-footer-single', // Optional parameters $1, $2, $3, $4, $5, $6
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

// translatewiki.net specific
array(
	'group' => 'page|Translating:Intro',
	'check' => 'links',
	'message' => array(
		'Translating:Intro/intro', // Contains links that are translated
	)
),
);
