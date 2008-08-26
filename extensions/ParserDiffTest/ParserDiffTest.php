<?php
# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install ParserDiffTest, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/ParserDiffTest/ParserDiffTest.php" );
EOT;
        exit( 1 );
}

$wgAutoloadClasses['ParserDiffTest'] = dirname(__FILE__) . '/ParserDiffTest_body.php';
$wgExtensionMessagesFiles['ParserDiffTest'] = dirname(__FILE__).'/ParserDiffTest.i18n.php';
$wgSpecialPages['ParserDiffTest'] = 'ParserDiffTest';
$wgSpecialPageGroups['ParserDiffTest'] = 'wiki';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Parser Diff Test',
	'svn-date' => '$LastChangedDate: 2008-06-26 00:33:11 +0000 (Thu, 26 Jun 2008) $',
	'svn-revision' => '$LastChangedRevision: 36663 $',
	'author' => 'Tim Starling',
	'description' => 'Special page for comparing the output of two different parsers.',
	'descriptionmsg' => 'pdtest-desc',
);

$wgPDT_OldConf = array( 'class' => 'Parser_OldPP' );
$wgPDT_NewConf = array( 'class' => 'Parser' );

