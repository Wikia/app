#!/usr/bin/php
<?php
/**
 * MwRdf.php -- RDF framework for MediaWiki
 * Copyright 2005,2006 Evan Prodromou <evan@wikitravel.org>
 * Copyright 2007 Mark Jaroski
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 * @author Evan Prodromou <evan@wikitravel.org>
 * @author Mark Jaroski <mark@geekhive.net>
 * @package MediaWiki
 * @subpackage Extensions
 */

define('MEDIAWIKI',true);

$IP = realpath( dirname( __FILE__ ) . '/../..' );
if ( $argv[1] ) {
	require_once( $argv[1] );
} else {
	require_once( "$IP/LocalSettings.php" );
}

$start = 0;
if ( $argv[2] ) $start = $argv[2];

require_once( $IP.'/includes/Defines.php' );
require_once( 'includes/ProfilerStub.php' );
require_once( 'Setup.php' );

$wgCommandLineMode = true;
$page_count = get_total_number_of_articles();

if ( $page_count < $start ) {
	fwrite( STDOUT, "-1" );
	exit(1);
}

MwRdf::Setup();

$dbr =& wfGetDB( DB_SLAVE );
$res = $dbr->query( "
	SELECT page_id,
	page_title,
	page_namespace,
	page_is_redirect
	FROM page
	ORDER BY page_id
	LIMIT 200
	OFFSET $start" );

while ( $s = $dbr->fetchObject( $res ) ) {
	if ( $s->page_is_redirect ) continue;

	$title = Title::makeTitle( $s->page_namespace, $s->page_title );
	if ( ! $title )
		continue;

	$agent = MwRdf::ModelingAgent( $title );
	fwrite( STDERR, $s->page_id . ": " . $title->getPrefixedDbKey() );
	$agent->storeAllModels();
	$agent = null;
	$title = null;
	fwrite( STDERR, "\n" );
}

fwrite( STDOUT, $start + 200 );

function get_total_number_of_articles() {
	$dbr =& wfGetDB( DB_SLAVE );

	# get the total number of articles
	$page = $dbr->tableName( 'page' );
	$res = $dbr->query( "select count( page_id ) as page_count from $page;" );
	$s = $dbr->fetchObject( $res );
	return $s->page_count;
}
