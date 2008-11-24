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
$wgExtraNamespaces[ NS_BLOG_ARTICLE_TALK ]    = "User_blog_comment";
$wgExtraNamespaces[ NS_BLOG_LISTING ] = "Blog";
$wgExtraNamespaces[ NS_BLOG_LISTING_TALK ] = "Blog_talk";

$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE_TALK ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING ] = true;
$wgNamespacesWithSubpages[ NS_BLOG_LISTING_TALK ] = true;

/**
 * protections
 */
$wgNamespaceProtection[ NS_BLOG_ARTICLE ] = array("blogs");
$wgNamespacesWithSubpages[ NS_BLOG_ARTICLE ] = true;
$wgGroupPermissions['*']['blogs'] = false;
$wgGroupPermissions['sysop']['blogs'] = true;
$wgGroupPermissions['staff']['blogs'] = true;

/**
 * globals
 */

$wgWikiaAvatarDirectory = "";
$wgWikiaAvatarPath = "";

/**
 * messages file
 */
$wgExtensionMessagesFiles["Blogs"] = dirname(__FILE__) . '/Blogs.i18n.php';

/**
 * Special pages
 */

extAddSpecialPage(dirname(__FILE__) . '/SpecialCreateBlogPage.php', 'CreateBlogPage', 'CreateBlogPage');
extAddSpecialPage(dirname(__FILE__) . '/SpecialBlogListingCreatePage.php', 'BlogListingCreatePage', 'BlogListingCreatePage');

/**
 * load other parts
 */
include( dirname( __FILE__ ) . "/BlogAvatar.php");
include( dirname( __FILE__ ) . "/BlogLockdown.php");
include( dirname( __FILE__ ) . "/BlogTemplate.php");
include( dirname( __FILE__ ) . "/UserMasthead.php");
include( dirname( __FILE__ ) . "/BlogListPage.php");
include( dirname( __FILE__ ) . "/BlogComments.php");
