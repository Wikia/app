<?php

/**
 * OAI-PMH repository extension for MediaWiki 1.4+
 *
 * Copyright (C) 2005 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @todo Check update hooks for all actions
 * @todo Make sure identifiers are correct format
 * @todo Configurable bits n pieces
 * @todo Test for conformance & error conditions
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die();
}

/**
 * To limit access to specific user-agents
 */
$oaiAgentRegex = false;

/**
 * To use HTTP authentication for clients in the oaiuser database
 */
$oaiAuth = false;

/**
 * Log accesses into the oaiaudit table
 */
$oaiAudit = false;

/**
 * The oaiaudit and oaiusers tables are used on the connection
 * in load group 'oai', or the primary database if none is set.
 *
 * If the tables are not in the default database for that connection,
 * put it here so the system knows where to find them.
 */
$oaiAuditDatabase = false;

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'OAIRepository',
	'author'         => 'Brion Vibber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:OAIRepository',
	'svn-date'       => '$LastChangedDate: 2008-08-21 18:27:19 +0200 (czw, 21 sie 2008) $',
	'svn-revision'   => '$LastChangedRevision: 39772 $',
	'description'    => 'Provides [http://www.openarchives.org/OAI/openarchivesprotocol.html OAI-PMH] repository interface',
	'descriptionmsg' => 'oai-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['OAIRepository'] = $dir . 'OAIRepo.i18n.php';
$wgAutoloadClasses['SpecialOAIRepository'] = $dir . 'OAIRepo_body.php';
$wgSpecialPages['OAIRepository'] = 'SpecialOAIRepository';

/* Add update hooks */
$wgHooks['ArticleSaveComplete'  ][] = 'oaiUpdateSave';
$wgHooks['ArticleDelete'        ][] = 'oaiUpdateDeleteSetup';
$wgHooks['ArticleDeleteComplete'][] = 'oaiUpdateDelete';
$wgHooks['TitleMoveComplete'    ][] = 'oaiUpdateMove';
$wgHooks['ParserTestTables'     ][] = 'oaiTestTables';
$wgHooks['ArticleUndelete'      ][] = 'oaiUpdateUndelete';

$oaiDeleteIds = array();

function oaiUpdatePage( $id, $action ) {
	$dbw =& wfGetDB( DB_MASTER );
	#$dbw->immediateBegin();
	$dbw->replace( 'updates',
		array( 'up_page' ),
		array( 'up_page'      => $id,
		       'up_action'    => $action,
		       'up_timestamp' => $dbw->timestamp(),
		       'up_sequence'  => null ), # FIXME
		'oaiUpdatePage' );
	#$dbw->commit();
}

function oaiUpdateSave( $article, $user, $text, $summary, $isminor, $iswatch, $section, $flags, $revision ) {
	if( $revision ) {
		// Only save a record for real updates, not null edits.
		$id = $article->getID();
		oaiUpdatePage( $id, 'modify' );
	}
	return true;
}

function oaiUpdateDeleteSetup( $article, $user, $reason ) {
	global $oaiDeleteIds;
	$title = $article->mTitle->getPrefixedText();
	$oaiDeleteIds[$title] = $article->getID();
	return true;
}

function oaiUpdateDelete( $article, $user, $reason ) {
	global $oaiDeleteIds;
	$title = $article->mTitle->getPrefixedText();
	if( isset( $oaiDeleteIds[$title] ) ) {
		oaiUpdatePage( $oaiDeleteIds[$title], 'delete' );
	}
	return true;
}

function oaiUpdateMove( $from, $to, $user, $fromid, $toid ) {
	oaiUpdatePage( $fromid, 'modify' );
	oaiUpdatePage( $toid, 'modify' );
	return true;
}

function oaiTestTables( &$tables ) {
	$tables[] = 'updates';
	return true;
}

function oaiUpdateUndelete( $title, $isnewid ) {
	global $wgDBname;
	$article = new Article($title);
	$id = $article->getID();
	oaiUpdatePage( $id, 'modify' );
	return true;
}
