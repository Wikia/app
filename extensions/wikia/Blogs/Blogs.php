<?php

/**
 * loader for blog articles
 * @package MediaWiki
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author add yourself here
 */

define( "NS_BLOG_ARTICLE", 500 );
define( "NS_BLOG_ARTICLE_TALK", 501 );
define( "NS_BLOG_LISTING", 502 );
define( "NS_BLOG_LISTING_TALK", 503 );
define( "BLOGTPL_TAG", "bloglist" );


$wgExtraNamespaces[ NS_BLOG_ARTICLE ] = "User_blog";
$wgExtraNamespaces[ NS_BLOG_ARTICLE_TALK ] = "User_blog_comment";
$wgExtraNamespaces[ NS_BLOG_LISTING ] = "Blog";
$wgExtraNamespaces[ NS_BLOG_LISTING_TALK ] = "Blog_talk";

$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE_TALK ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING_TALK ] = true;

$wgContentNamespaces[] = NS_BLOG_ARTICLE;
$wgContentNamespaces[] = NS_BLOG_LISTING;

/**
 * localized blog ns - proof of concept aka quick hack
 *
 * @see SMW includes/SMW_GlobalFunctions.php::smwfInitNamespaces
 * FIXME generalize
 */
if ('de' == $wgLanguageCode) {
	// make en ns point (alias) to "main ns" - at this point themselves
	foreach (array(500, 501, 502, 503) as $ns) {
		$wgNamespaceAliases[$wgExtraNamespaces[$ns]] = $ns;
	}
	// translate "main ns" into de
	$wgExtraNamespaces[500] = 'Benutzer_Blog';
	$wgExtraNamespaces[501] = 'Benutzer_Blog_Kommentare';
	$wgExtraNamespaces[502] = 'Blog';
	$wgExtraNamespaces[503] = 'Blog_Diskussion';
	// the end: de name is the "main ns", en is just an alias (redirect)
}

/**
 * setup function
 */
$wgAutoloadClasses[ "BlogListPage" ] = dirname(__FILE__) . '/BlogListPage.php';
$wgExtensionFunctions[] = "BlogListPage::setup";

/**
 * messages file
 */
$wgExtensionMessagesFiles["Blogs"] = dirname(__FILE__) . '/Blogs.i18n.php';

/**
 * Special page
 */

extAddSpecialPage(dirname(__FILE__) . '/SpecialCreateBlogPage.php', 'CreateBlogPage', 'CreateBlogPage');
extAddSpecialPage(dirname(__FILE__) . '/SpecialCreateBlogListingPage.php', 'CreateBlogListingPage', 'CreateBlogListingPage');

$wgSpecialPageGroups['CreateBlogPage'] = 'wikia';
$wgSpecialPageGroups['CreateBlogListingPage'] = 'wikia';

/**
 * ajax functions
 */
$wgAjaxExportList[] = "CreateBlogListingPage::axBlogListingCheckMatches";

/**
 * hooks
 */
$wgHooks['AlternateEdit'][] = 'SpecialBlogPage::alternateEditHook';

/**
 * load other parts
 */
include( dirname( __FILE__ ) . "/SpecialBlogPage.php");
include( dirname( __FILE__ ) . "/BlogAvatar.php");
include( dirname( __FILE__ ) . "/BlogTemplate.php");
include( dirname( __FILE__ ) . "/UserMasthead.php");
include( dirname( __FILE__ ) . "/BlogListPage.php");
include( dirname( __FILE__ ) . "/BlogComments.php");
include( dirname( __FILE__ ) . "/BlogLockdown.php");
