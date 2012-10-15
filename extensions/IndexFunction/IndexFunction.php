<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'IndexFunction',
	'author' => 'Alex Zaddach',
	'url' => 'https://www.mediawiki.org/wiki/Extension:IndexFunction',
	'descriptionmsg' => 'indexfunc-desc',
);

$dir = dirname( __FILE__ ) . '/';

# Register function
$wgHooks['ParserFirstCallInit'][] = 'efIndexSetup';
# Add to database
$wgHooks['OutputPageParserOutput'][] = 'IndexFunctionHooks::doIndexes';
# Make links to indexes blue
$wgHooks['LinkEnd'][] = 'IndexFunctionHooks::blueLinkIndexes';
# Make links to indexes redirect
$wgHooks['InitializeArticleMaybeRedirect'][] = 'IndexFunctionHooks::doRedirect';
# Make "go" searches for indexes redirect
$wgHooks['SearchGetNearMatch'][] = 'IndexFunctionHooks::redirectSearch';
# Remove things from the index table when a page is deleted
$wgHooks['ArticleDeleteComplete'][] = 'IndexFunctionHooks::onDelete';
# Remove things from the index table when creating a new page
$wgHooks['ArticleInsertComplete'][] = 'IndexFunctionHooks::onCreate';
# Show a warning when editing an index title
$wgHooks['EditPage::showEditForm:initial'][] = 'IndexFunctionHooks::editWarning';
# Show a warning after page move, and do some cleanup
$wgHooks['SpecialMovepageAfterMove'][] = 'IndexFunctionHooks::afterMove';
# Schema updates for update.php
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efIndexUpdateSchema';
$wgHooks['ParserTestTables'][] = 'efParserTestTables';

# Setup the special page
$wgSpecialPages['Index'] = 'SpecialIndex';
$wgSpecialPageGroups['Index'] = 'pages';

# i18n
$wgExtensionMessagesFiles['IndexFunctionAlias'] = $dir . 'IndexFunction.alias.php';
$wgExtensionMessagesFiles['IndexFunction'] = $dir . 'IndexFunction.i18n.php';
$wgExtensionMessagesFiles['IndexFunctionMagic'] = $dir . 'IndexFunction.i18n.magic.php';

# Register classes with the autoloader
$wgAutoloadClasses['SpecialIndex'] = $dir . 'SpecialIndex.php';
$wgAutoloadClasses['IndexFunctionHooks'] = $dir . 'IndexFunction_body.php';
$wgAutoloadClasses['IndexFunction'] = $dir . 'IndexFunction_body.php';
$wgAutoloadClasses['IndexAbstracts'] = $dir . 'IndexAbstracts.php';
$wgAutoloadClasses['SpecialIndexPager'] = $dir . 'SpecialIndex.php';

/**
 * Used to set the context given on Special:Index auto-disambig pages
 * Can be 1 of 2 options:
 * 'extract' (default) - Show an extract from the start of the article
 * 'categories' - Show a comma-separated list of categories the article is in
 */
$wgSpecialIndexContext = 'extract';

// @todo FIXME: put these methods in a separate class and file.
function efIndexSetup( &$parser ) {
	$parser->setFunctionHook( 'index-func', array( 'IndexFunctionHooks', 'indexRender' ) );
	return true;
}

function efIndexUpdateSchema( $updater = null ) {
	if ( $updater === null ) {
		global $wgExtNewTables;
		$wgExtNewTables[] = array( 'indexes', dirname( __FILE__ ) . '/indexes.sql' );
	} else {
		$updater->addExtensionUpdate( array( 'addTable', 'indexes',
			dirname( __FILE__ ) . '/indexes.sql', true ) );
	}

	return true;
}

function efParserTestTables( &$tables ) {
	$tables[] = 'indexes';

	return true;
}
