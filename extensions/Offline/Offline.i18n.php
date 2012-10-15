<?php
$messages = array();
$messages['en'] = array(
	'offline_desc' => 'Read articles offline, from *pedia dump files.  See page [[Special:Offline]] for status.',
	'offline' => 'Offline configuration helper', // special page title
	//'special_page_title' => 'Offline configuration',
	'offline_special_desc' => 'Status and diagnostics for the Offline extension.',

	'offline_heading_status' => 'Current Status',

	'offline_test_article' => 'Andalusia', // a word likely to be found
	'offline_bad_test_article' => 'Internal error: the test_article "$1" was not found, but the index database seems to be good.',

	'offline_index_test_pass' => 'Dump index was read successfully.',
	'offline_index_test_fail' => 'Dump index cannot be read!',
	'offlinewikipath_not_configured' => 'You have not set the $wgOfflineWikiPath variable in LocalSettings.php',
	'offlinewikipath_not_found' => 'The directory specified by $wgOfflineWikiPath, <em>$1</em>, does not exist',
	'offline_dbdir_not_found' => 'The database directory, <em>$1/db</em>, is missing index data files. These must be downloaded or built.',
	'offline_unknown_index_error' => 'The index to your dump could not be read for an unknown reason. Perhaps the database files are damaged.',

	'offline_bzload_test_pass' => 'Compressed dump files can be opened.',
	'offline_bzload_test_fail' => 'Compressed dump files were not loaded!',
	'offline_bz2_ext_needed' => 'Your PHP installation is missing the Bzip2 library.',
	'offline_bz2_file_gone' => 'The index pointed to a missing dump file: <em>$1</em>',
	'offline_unknown_bz2_error' => 'There was an unknown problem reading dump file <em>$1</em>.',

	'offline_article_test_pass' => 'Article data was found where expected.',
	'offline_article_test_fail' => 'Indexed page has changed. Perhaps your index was made for another dump?',

	'offline_hooks_test_pass' => 'Mediawiki article loader will fetch from dump data.', //, from GRAMMAR(a) %1 encyclopedia called %2.
	'offline_hooks_test_fail' => 'Mediawiki article loader is not fetching from dump data. ',
	'offline_cache_needed' => 'You need to set up a cache, such as `php-pecl-apc`.',

	'offline_all_tests_pass' => 'You are good to go.',

	// user preferences
	'offline_subdir_status' => 'Index files were found in subdirectory named $1',
	'offline_change_subdir' => 'Use the following directory prefix instead:',

	'offline_change_language' => 'Dumps of the following languages have been detected. Check all dumps you want to make available.',
	'offline_live_data_preferred' => 'Matches from the so-called live database will be preferred over dump text.',
);

$messages['tl'] = array(
	'offline_test_article' => 'Myanmar', // a word likely to be found
);

$messages['qqq'] = array(
	'offline_desc' => '',
	'offline' => 'Title on the Special page',
	'offline_special_desc' => '',

	'offline_heading_status' => '',

	'offline_test_article' => 'an entry known to exist in your language wiki',
	'offline_bad_test_article' => '',

	'offline_index_test_pass' => '',
	'offline_index_test_fail' => '',
	'offlinewikipath_not_configured' => '',
	'offlinewikipath_not_found' => '',
	'offline_dbdir_not_found' => '',
	'offline_unknown_index_error' => '',

	'offline_bzload_test_pass' => '',
	'offline_bzload_test_fail' => '',
	'offline_bz2_ext_needed' => '',
	'offline_bz2_file_gone' => '',
	'offline_unknown_bz2_error' => '',

	'offline_article_test_pass' => '',
	'offline_article_test_fail' => '',

	'offline_hooks_test_pass' => '',
	'offline_hooks_test_fail' => '',
	'offline_cache_needed' => '',

	'offline_all_tests_pass' => '',

	// user preferences
	'offline_subdir_status' => '',
	'offline_change_subdir' => '',

	'offline_change_language' => '',
	'offline_live_data_preferred' => '',
);
