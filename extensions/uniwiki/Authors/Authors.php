<?php
/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Authors
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( "MEDIAWIKI" ) )
	die();

/* ---- CONFIGURABLE OPTIONS ---- */
$wgShowAuthorsNamespaces = array ( NS_MAIN );
$wgShowAuthors = true;

$wgExtensionCredits['other'][] = array(
	'name'           => 'Authors',
	'author'         => 'Merrick Schaefer, Mark Johnston, Evan Wheeler and Adam Mckaig (at UNICEF)',
	'description'    => 'Appends a list of contributors to articles',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Authors',
	'svn-date'       => '$LastChangedDate: 2008-11-02 14:28:44 +0100 (ndz, 02 lis 2008) $',
	'svn-revision'   => '$LastChangedRevision: 43076 $',
	'descriptionmsg' => 'authors-desc',
);

$wgExtensionMessagesFiles['Authors'] = dirname( __FILE__ ) . '/Authors.i18n.php';

/* ---- HOOKS ---- */
$wgHooks['OutputPageBeforeHTML'][] = "UW_Authors_List";

function UW_Authors_List ( &$out, &$text ) {
	global $wgTitle, $wgRequest, $wgShowAuthorsNamespaces, $wgShowAuthors;

	/* do nothing if the option is disabled
	 * (but why would the extension be enabled?) */
	if ( !$wgShowAuthors )
		return true;

	// only build authors on namespaces in $wgShowAuthorsNamespaces
	if ( !in_array ( $wgTitle->getNamespace(), $wgShowAuthorsNamespaces ) )
		return true;

	/* get the contribs from the database (don't use the default
	 * MediaWiki one since it ignores the current user) */
	$article = new Article ( $wgTitle );
	$contribs = array();
	$db = wfGetDB ( DB_MASTER );
	$rev_table  = $db->tableName ( "revision" );
	$user_table = $db->tableName ( "user" );

	$sql = "SELECT rev_user, rev_user_text, user_real_name, MAX(rev_timestamp) as timestamp
		FROM $rev_table LEFT JOIN $user_table ON rev_user = user_id
		WHERE rev_page = {$article->getID()}
		GROUP BY rev_user, rev_user_text, user_real_name
		ORDER BY timestamp DESC";

	$results = $db->query ( $sql, __METHOD__ );
	while ( $line = $db->fetchObject ( $results ) ) {
		$contribs[] = array(
			$line->rev_user,
			$line->rev_user_text,
			$line->user_real_name
		);
	}

	$db->freeResult ( $results );


	// return if there are no authors
	if ( sizeof ( $results ) <= 0 )
		return true;

	// now build a sensible authors display in HTML
	require_once ( "includes/Credits.php" );

	wfLoadExtensionMessages( 'Authors' );

	$authors = "\n<div class='authors'>" .
		"<h4>" . wfMsg( 'authors_authors' ) . "</h4>" .
		"<ul>";
	$anons = 0;
	foreach ( $contribs as $author ) {
		$id       = $author[0];
		$username = $author[1];
		$realname = $author[2];

		if ( $id != "0" ) { // user with an id
			// FIME: broken. Incompatible with 1.14. Method creditLink() was renamed and changed.
			$author_link = $realname
				? creditLink( $username, $realname )
				: creditLink( $username );
			$authors .= "<li>$author_link</li>";
		} else { // anonymous
			$anons++;
		}
	}
	// add the anonymous entries
	if ( $anons > 0 )
		$authors .= "<li>" . wfMsg( 'authors_anonymous' ) . "</li>";
	$authors .= "</ul></div>";

	$text .= $authors;
	return true;
}
