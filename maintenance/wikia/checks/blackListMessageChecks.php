<?php

/**
 * this script emails a list of all page_id's for
 * all pages in NS_MEDIAWIKI which chave title of:
 * Spam-blacklist
 * Spam-whitelist
 * Spam_blacklist
 * Spam_whitelist
 * External_links_whitelist
 * this is used to determine if there a
 */
require_once ( '../../commandLine.inc' );

if( count($args) != 1 || isset($options['help']) ) {
	echo 'Check for spam related files';
} else {
	if(!Sanitizer::validateEmail( $email )) {
			echo 'Invalid email ' . $email . "\n";
			exit(1);
	}
	check_existence_of_spamfile($args[0]);
}

function check_existence_of_spamfile($email) {
	global $wgSitename, $wgCityId;

	$articles = getWikiArticles();
	if(!empty($articles)) {
		ob_start();
		echo $wgSitename,"\n";
		print_r($articles);
		$body = ob_get_clean();
		UserMailer::send( new MailAddress($email), new MailAddress($email), 'Spam list related pages in NS=8 on  ' . $wgSitename . ' - ' . $wgCityId, $body );
	}
}

function getWikiArticles() {
	$searchpages = array(
 		"'Spam-blacklist'",
		"'Spam-whitelist'",
		"'Spam_blacklist'",
		"'Spam_whitelist'",
		"'External_links_whitelist'"
	);

	$db = wfGetDb(DB_SLAVE);
	$res = $db->select(
		array( 'page' ),
		array( 'page_id', 'page_title' ),
		array(
			'page_namespace	= 8',
			'page_title in (' . implode(',',$searchpages) . ')'
		),
		'count_average_title',
		array( 'ORDER BY' => 'page_id DESC' )
	);

	$articles = array();
	while( $article = $res->fetchObject() ) {
		$articles[$article->page_id] = $article->page_title;
	}

	return $articles;
}

function getAverageLength($ids) {
	$titles = Title::newFromIDs($ids);

	$len = 0;
	foreach($titles as $title) {
		$len += strlen($title->getText());
	}

	return $len/count($titles);
}
