<?php

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install SphinxSearch extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/SphinxSearch/SphinxSearch.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'version'        => '0.8.5',
	'name'           => 'SphinxSearch',
	'author'         => array( 'Svemir Brkic', 'Paul Grinberg' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SphinxSearch',
	'descriptionmsg' => 'sphinxsearch-desc'
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'SphinxMWSearch' ] = $dir . 'SphinxMWSearch.php';
$wgExtensionMessagesFiles['SphinxSearch'] = $dir . 'SphinxSearch.i18n.php';
$wgExtensionFunctions[ ] = 'efSphinxSearchPrefixSetup';

# To completely disable the default search and replace it with SphinxSearch,
# set this BEFORE including SphinxSearch.php in LocalSettings.php
# $wgSearchType = 'SphinxMWSearch';
# All other variables should be set AFTER you include this file in LocalSettings

# Prior to version 0.8.0 there was a SphinxSearch search type
if ( $wgSearchType == 'SphinxSearch' ) {
	$wgSearchType == 'SphinxMWSearch';
}

if ( $wgSearchType == 'SphinxMWSearch' ) {
	$wgDisableSearchUpdate = true;
}

# This assumes you have copied sphinxapi.php from your Sphinx
# installation folder to your SphinxSearch extension folder
# not needed if you install http://pecl.php.net/package/sphinx
if ( !class_exists( 'SphinxClient' ) ) {
	require_once ( $dir . "sphinxapi.php" );
}

# Host and port on which searchd deamon is running
$wgSphinxSearch_host = '127.0.0.1';
$wgSphinxSearch_port = 9312;

# Main sphinx.conf index to search
$wgSphinxSearch_index = "wiki_main";

# By default, we search all available indexes
# You can also specify them explicitly, e.g
# $wgSphinxSearch_index_list = "wiki_main,wiki_incremental";
$wgSphinxSearch_index_list = "*";

# If you have multiple index files, you can specify their weights like this
# See http://www.sphinxsearch.com/docs/current.html#api-func-setindexweights
# $wgSphinxSearch_index_weights = array(
#	"wiki_main" => 100,
#	"wiki_incremental" => 10
# );
$wgSphinxSearch_index_weights = null;

# Default Sphinx search mode
$wgSphinxSearch_mode = SPH_MATCH_EXTENDED2;

# Default sort mode
$wgSphinxSearch_sortmode = SPH_SORT_RELEVANCE;
$wgSphinxSearch_sortby = '';

# How many matches searchd will keep in RAM while searching
$wgSphinxSearch_maxmatches = 1000;

# When to stop searching all together (if not zero)
$wgSphinxSearch_cutoff = 0;

# Weights of individual indexed columns. This gives page titles extra weight
$wgSphinxSearch_weights = array(
	'old_text' => 1,
	'page_title' => 100
);

# Set to true to use MW's default search snippets and highlighting
$wgSphinxSearchMWHighlighter = false;

# Should the suggestion (Did you mean?) mode be enabled? Possible values:
# enchant - see http://www.mediawiki.org/wiki/Extension:SphinxSearch/Search_suggestions
# soundex - uses MySQL soundex() function to recommend existing titles
# aspell - uses aspell command-line utility to look for similar spellings
$wgSphinxSuggestMode = '';

# Path to aspell, adjust value if not in the system path
$wgSphinxSearchAspellPath = 'aspell';

# Path to (optional) personal aspell dictionary
$wgSphinxSearchPersonalDictionary = '';

# If true, use SphinxMWSearch for search suggestions displayed while typing
# $wgEnableMWSuggest needs to be set to true as well
$wgEnableSphinxPrefixSearch = false;

function efSphinxSearchPrefixSetup() {
	global $wgHooks, $wgEnableSphinxPrefixSearch;

	if ( $wgEnableSphinxPrefixSearch ) {
		$wgHooks[ 'PrefixSearchBackend' ][ ] = 'SphinxMWSearch::prefixSearch';
	}
}
