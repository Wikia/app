<?php
/**
 * @addtogroup SpecialPage
 */

/**
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "MakeSysop extension\n";
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'author' => 'Tim Starling',
	'name' => 'Makesysop',
	'svn-date' => '$LastChangedDate: 2008-07-09 18:57:18 +0200 (śro, 09 lip 2008) $',
	'svn-revision' => '$LastChangedRevision: 37410 $',
	'description' => 'Gives bureaucrats the ability to make users into sysops or bureaucrats',
	'descriptionmsg' => 'makesysop-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Makesysop'
);

$dir = dirname( __FILE__ );

# Internationalisation file
$wgExtensionMessagesFiles['Makesysop'] = "$dir/SpecialMakesysop.i18n.php";
$wgExtensionAliasesFiles['Makesysop'] = "$dir/SpecialMakesysop.alias.php";

// Set groups to the appropriate sysop/bureaucrat structure:
// * Steward can do 'full' work (makesysop && userrights)
// * Bureaucrat can only do limited work (makesysop)
$wgGroupPermissions['steward'   ]['makesysop' ] = true;
$wgGroupPermissions['steward'   ]['userrights'] = true;
$wgGroupPermissions['bureaucrat']['makesysop' ] = true;
$wgGroupPermissions['bureaucrat']['userrights'] = false;
$wgAvailableRights[] = 'makesysop';

# Register special page
$wgSpecialPages['Makesysop'] = 'MakesysopPage';
$wgSpecialPageGroups['Makesysop'] = 'users';
$wgAutoloadClasses['MakesysopPage'] = "$dir/SpecialMakesysop_body.php";
$wgAutoloadClasses['MakesysopForm'] = "$dir/SpecialMakesysop_body.php";
