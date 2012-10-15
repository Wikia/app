<?php
if (!defined('MEDIAWIKI')) die();
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

require_once( 'includes/GlobalFunctions.php' );
require_once( 'includes/SpecialPage.php' );
require_once( 'includes/Title.php' );
require_once( 'includes/Article.php' );
require_once( 'includes/User.php' );
require_once( 'includes/Hooks.php' );
require_once( 'includes/QueryPage.php' );

// To be redefined as needed in LocalSettings.php
$wgRdfStoreType = 'hashes';
$wgRdfStoreName = 'mwrdfstore';
$wgRdfStoreOptions = "hash-type='bdb',dir='$IP/rdfdata',contexts='yes'";

# Load our constituant classes
$wgAutoloadClasses['MwRdf'] = "$IP/extensions/Rdf/Rdf.php";

// Add custom Model Maker classes to this list
$wgRdfModelMakers = array( 'MwRdf_CreativeCommons_Modeler',
	'MwRdf_LinksFrom_Modeler',
	'MwRdf_LinksTo_Modeler',
	'MwRdf_InPage_Modeler',
	'MwRdf_DCmes_Modeler',
	'MwRdf_History_Modeler',
	'MwRdf_Image_Modeler',
	'MwRdf_Categories_Modeler',
	'MwRdf_Interwiki_Modeler'
);

// Add additional RDF vocabulary classes to this list
$wgRdfVocabularies = array(
	'rdf'      => 'MwRdf_Vocabulary_Rdf',
	'rdfs'     => 'MwRdf_Vocabulary_RdfSchema',
	'dc'       => 'MwRdf_Vocabulary_DCMES',
	'dcterms'  => 'MwRdf_Vocabulary_DCTerms',
	'dctype'   => 'MwRdf_Vocabulary_DCMiType',
	'cc'       => 'MwRdf_Vocabulary_CreativeCommons'
);

$wgExtensionFunctions[] = 'setupMwRdf';

function setupMwRdf() {
	global $wgParser, $wgMessageCache, $wgRequest, $wgOut, $wgHooks;

	$wgMessageCache->addMessages(array(
		'rdf' => 'Rdf',
		'rdf-inpage'          => "Embedded In-page Turtle",
		'rdf-dcmes'           => "Dublin Core Metadata Element Set",
		'rdf-cc'              => "Creative Commons",
		'rdf-image'           => "Embedded images",
		'rdf-linksfrom'       => "Links from the page",
		'rdf-links'           => "All links",
		'rdf-linksto'         => "Links to the page",
		'rdf-history'         => "Historical versions",
		'rdf-interwiki'       => "Interwiki links",
		'rdf-categories'      => "Categories",
		'rdf-target'          => "Target page",
		'rdf-modelnames'      => "Model(s)",
		'rdf-format'          => "Output format",
		'rdf-output-rdfxml'   => "RDFXML",
		'rdf-output-turtle'   => "Turtle",
		'rdf-output-ntriples' => "NTriples",
		'rdf-instructions'    => "Select the target page and RDF models you're interested in."
	));;

	$wgParser->setHook( 'rdf', 'renderMwRdf' );

	SpecialPage::addPage(new SpecialPage('Rdf', '', true, 'wfRdfSpecialPage',
		'extensions/Rdf/Rdf.php'));

	SpecialPage::addPage(new SpecialPage('RdfQuery', '', true, 'wfSpecialRdfQuery',
		'extensions/Rdf/Rdf.php'));

	# next we set some hooks for saving and clearing RDF data.  Each
	# hook is called on the same ModelingAgent object as it preserves
	# the list of pages we link to in its state
	$wgHooks['ArticleSave'][]           = array( 'wfRdfOnArticleSave' );
	$wgHooks['ArticleSaveComplete'][]   = array( 'wfRdfOnArticleSaveComplete' );
	$wgHooks['TitleMoveComplete'][]     = array( 'wfRdfOnTitleMoveComplete' );
	$wgHooks['ArticleDeleteComplete'][] = array( 'wfRdfOnArticleDeleteComplete' );

	# Add an RDF metadata link if requested
	$action = $wgRequest->getText('action', 'view');

	# Note: $wgTitle not yet set; have to get it from the request
	$title = $wgRequest->getText('title');
	if ( ! isset($title) || strlen($title) == 0 )
		return true;

	$nt = Title::newFromText($title);
	if ( ! isset( $nt ) || $nt->getNamespace() == NS_SPECIAL )
		return true;


	# finally *if* this is a page view we need to add the link
	if ( ! $action == 'view')
		return true;

	$rdft = Title::makeTitle(NS_SPECIAL, "Rdf");
	$target = $nt->getPrefixedDBkey();

	$linkdata = array('title' => 'RDF Metadata',
	'type' => 'application/rdf+xml',
	'href' => $rdft->getLocalURL("target={$target}" ));
	$wgOut->addMetadataLink($linkdata);
	return true;
}

/*
* Dummy render method for removing <rdf></rdf> tags.
*/
function renderMwRdf( $input, $argv = null, $parser = null ) { return ' '; }

function wfRdfOnArticleSave($article, $dc1, $dc2, $dc3, $dc4, $dc5, $dc6) {
	MwRdf::setup();
	$mf = MwRdf::ModelingAgent( $article );
	$mf->clearAllModels();
	return true;
}

function wfRdfOnArticleSaveComplete($article, $dc1, $dc2, $dc3, $dc4, $dc5, $dc6) {
	MwRdf::setup();
	$mf = MwRdf::ModelingAgent( $article );
	$mf->clearAllModels();
	$mf->storeAllModels();
	return true;
}

function wfRdfOnTitleMoveComplete($oldt, $newt, $user, $oldid, $newid) {
	MwRdf::setup();
	$oldmf = MwRdf::ModelingAgent( $oldt );
	$oldmf->clearAllModels();
	$newmf = MwRdf::ModelingAgent( $newt );
	$newmf->clearAllModels();
	$newmf->storeAllModels();
	return true;
}

function wfRdfOnArticleDeleteComplete($article, $user, $reason) {
	MwRdf::setup();
	$mf = MwRdf::ModelingAgent( $article );
	$mf->clearAllModels();
	return true;
}

/*
* Provide a Special: URL for getting RDF data from a given Title.
*/
function wfRdfSpecialPage($par) {
	global $wgRequest, $wgOut, $_SERVER, $_REQUEST;
	MwRdf::setup();
	$target = $wgRequest->getVal('target');

	if ( !isset( $target) || $target == null ) { # no target parameter
		MwRdf::ShowForm();
		return;
	}

	if ( strlen( $target ) == 0) { # no target contents
		MwRdf::ShowForm( wfMsg('badtitle' ));
		return;
	}

	$nt = Title::newFromText( $target );
	if ( $nt->getArticleID() == 0 ) { # not an article
		MwRdf::ShowForm( wfMsg('badtitle') );
		return;
	}

	$format = $wgRequest->getVal('format', 'rdfxml');
	$accept = isset( $_SERVER['HTTP_ACCEPT'] ) ? $_SERVER['HTTP_ACCEPT'] : null;
	$rdftype = wfNegotiateType( wfAcceptToPrefs( $accept ),
	wfAcceptToPrefs( MwRdf::getTypePrefs( $format ) ) );

	if (!$rdftype) {
		wfHttpError(406, "Not Acceptable", wfMsg("notacceptable"));
		return false;
	}

	$wgOut->disable();
	if ( ! headers_sent() )
	header( "Content-type: {$rdftype}" );
	$wgOut->sendCacheControl();

	$mf = MwRdf::ModelingAgent( $nt );

	# Note: WebRequest chokes on arrays here
	$modelnames = null;
	if ( isset( $_REQUEST['modelnames'] ) ) $modelnames = $_REQUEST['modelnames'];
	if ( is_null( $modelnames ) ) $modelnames = $mf->listDefaultModels();
	if ( is_string( $modelnames) ) $modelnames = explode(',', $modelnames);
	if ( ! $modelnames ) {
		MwRdf::ShowForm( wfMsg('nomodelsselected' ));
		return;
	}

	$model = $mf->retrieveModel( $modelnames );
	if ( ! $model->current() ) {
		$mf->storeAllModels();
		$model = $mf->retrieveModel( $modelnames );
	}
	$ser = MwRdf::Serializer( $format );
	$text = $model->serializeStatements( $ser );

	# XXX: Test Hook: it would be better if we could capture the
	# print statement below with an output buffer, but that is
	# disabled for the CLI in PHP 5
	if ( isset( $_SERVER['CONTEXT'] ) && $_SERVER['CONTEXT'] == 'phpunit test' ) {
		return $text;
	} else {
		print( $text );
		return true;
	}
}
