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
 * messages file
 */
$wgExtensionMessagesFiles["Blogs"] = dirname(__FILE__) . '/Blogs.i18n.php';

// Special page
extAddSpecialPage(dirname(__FILE__) . '/SpecialCreateBlogPost.php', 'CreateBlogPost', 'CreateBlogPost');




/**
 * load other parts
 */
include( dirname( __FILE__ ) . "/BlogTemplate.php");
include( dirname( __FILE__ ) . "/UserMasthead.php");
include( dirname( __FILE__ ) . "/BlogListPage.php");
include( dirname( __FILE__ ) . "/BlogComments.php");
