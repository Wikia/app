<?php
if ( !defined( 'MEDIAWIKI' ) ) {
?>
<p>This is the ExpandTemplates extension. To enable it, put </p>
<pre>require_once("$IP/extensions/ExpandTemplates/ExpandTemplates.php");</pre>
<p>at the bottom of your LocalSettings.php.</p>
<?php
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'ExpandTemplates',
	'svn-date' => '$LastChangedDate: 2008-08-11 20:19:14 +0200 (pon, 11 sie 2008) $',
	'svn-revision' => '$LastChangedRevision: 39164 $',
	'author'         => 'Tim Starling',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ExpandTemplates',
	'description'    => 'Expands templates, parser functions and variables to show expanded wikitext and preview rendered page',
	'descriptionmsg' => 'expandtemplates-desc',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ExpandTemplates'] = $dir . 'ExpandTemplates_body.php';
$wgExtensionMessagesFiles['ExpandTemplates'] = $dir . 'ExpandTemplates.i18n.php';
$wgExtensionAliasesFiles['ExpandTemplates'] = $dir . 'ExpandTemplates.alias.php';
$wgSpecialPages['ExpandTemplates'] = 'ExpandTemplates';
$wgSpecialPageGroups['ExpandTemplates'] = 'wiki';