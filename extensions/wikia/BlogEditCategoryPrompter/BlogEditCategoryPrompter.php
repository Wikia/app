<?php
/**
 * BlogEditCategoryPrompter
 *
 * prompts users to add a category to blog posts (https://wikia-inc.atlassian.net/browse/CE-401)
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'Blog Edit Category Prompter',
	'author' => 'Nelson Monterroso',
	'descriptionmsg' => 'becp-desc',
	'version' => '1.0.0',
);

$dir = dirname( __FILE__ );

// classes
$wgAutoloadClasses[ 'BECPHelper' ] = "{$dir}/BECPHelper.class.php";

// i18n
$wgExtensionMessagesFiles[ 'BECP' ] = "{$dir}/BlogEditCategoryPrompter.i18n.php";

// perms
$wgAvailableRights[ ] = BECPHelper::PERM_NAME;
$wgGroupPermissions[ '*' ][ BECPHelper::PERM_NAME ] = false;
$wgGroupPermissions[ 'staff' ][ BECPHelper::PERM_NAME ] = true;
$wgGroupPermissions[ 'sysop' ][ BECPHelper::PERM_NAME ] = true;

// hooks
$wgHooks[ 'BlogArticleInitialized' ][ ] = 'BECPHelper::onBlogArticleInitialized';

JSMessages::registerPackage( 'BECP', array(
	'becp-prompt',
) );