<?php
/**
 * Internationalisation file for extension SpamRegex.
 *
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Bartek Łapiński
 */
$messages['en'] = array(
	'textregex'                     => 'Text regex',
	'textregex-desc'                => '[[Special:textregex/XXXX|Filter]] out unwanted phrases in edited pages, based on regular expressions',
	'textregex-page-title'          => 'List of unwanted expressions',
	'textregex-error-unblocking' 	=> 'Error unblocking ($1). Try once again.',
	'textregex-currently-blocked' 	=> "'''Currently blocked phrases:'''",
	'textregex_nocurrently-blocked'	=> 'No blocked phrases found',
	'textregex-addedby-user'		=> 'added by $1 on $2 ',
	'textregex-remove-url'			=> '[{{SERVER}}$1&id=$2 remove]',
	'textregex-stats-url'			=> '[{{SERVER}}$1&id=$2 statistics]',
	'textregex-page-title-block'  	=> 'Block unwanted phrase using regex',
	'textregex-unblock-succ'  		=> 'Unblock succedeed',
	'textregex-block-succ'        	=> 'Block succedeed',
	'textregex-unblock-message'     => 'Phrase \'\'\'$1\'\'\' has been removed from unwanted expressions.',
	'textregex-block-message'       => 'Phrase \'\'\'$1\'\'\' has been added to unwanted expressions.',
	'textregex-regex-block' 		=> 'Regex phrase to block:',
	'textregex-regex-search'		=> 'Search regexes: ',
	'textregex-submit-regex'		=> 'Add regex',
	'textregex-submit-showlist'		=> 'Show list',
	'textregex-empty-regex'			=> 'Give a proper regex to block.',
	'textregex-invalid-regex'		=> 'Invalid regex.',
	'textregex-already-added'      	=> '"$1" is already added',
	'textregex-nodata-found'		=> 'No data found',
	'textregex-stats-record'		=> "word ''$1'' was used by $2 on $3 (''comment: $4'')",
	'textregex-select-subpage' 		=> 'Select one of list of regexes:',
	'textregex-select-default' 		=> '-- select --',
	'textregex-create-subpage' 		=> 'or create new list:',
	'textregex-select-regexlist'	=> 'go to the list',
	'textregex-invalid-regexid'		=> 'Invalid identifier of regex.',
	'textregex-phrase-statistics'	=> 'Statistics for \'\'\'$1\'\'\' phrase (number of records: $2) ',
	'textregex-return-mainpage'		=> '[{{SERVER}}$1 return to the list]',
);
