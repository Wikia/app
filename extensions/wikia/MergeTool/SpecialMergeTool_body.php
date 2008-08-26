<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named MergeTool.\n";
    exit( 1 ) ;
}
#--- Add messages
global $wgMessageCache, $wgMergeToolMessages;
foreach( $wgMergeToolMessages as $key => $value ) {
    $wgMessageCache->addMessages( $wgMergeToolMessages[$key], $key );
}

/**
+-------------------+---------------------+------+-----+---------+----------------+
| Field             | Type                | Null | Key | Default | Extra          |
+-------------------+---------------------+------+-----+---------+----------------+
| page_id           | int(8) unsigned     | NO   | PRI | NULL    | auto_increment |
| page_namespace    | int(11)             | NO   | MUL |         |                |
| page_title        | varchar(255)        | NO   |     |         |                |
| page_restrictions | tinyblob            | NO   |     |         |                |
| page_counter      | bigint(20) unsigned | NO   |     | 0       |                |
| page_is_redirect  | tinyint(1) unsigned | NO   |     | 0       |                |
| page_is_new       | tinyint(1) unsigned | NO   |     | 0       |                |
| page_random       | double unsigned     | NO   | MUL |         |                |
| page_touched      | char(14)            | NO   |     |         |                |
| page_latest       | int(8) unsigned     | NO   |     |         |                |
| page_len          | int(8) unsigned     | NO   | MUL |         |                |
+-------------------+---------------------+------+-----+---------+----------------+

mysql> select count(*), page_namespace from page group by page_namespace;
+----------+----------------+
| count(*) | page_namespace |
+----------+----------------+
|    20042 |              0 |
|     2541 |              1 |
|      817 |              2 |
|     3101 |              3 |
|      170 |              4 |
|       27 |              5 |
|    19855 |              6 |
|       36 |              7 |
|       22 |              8 |
|       90 |             10 |
|        9 |             11 |
|       11 |             12 |
|        4 |             13 |
|      890 |             14 |
|      206 |             15 |
+----------+----------------+

$wgCanonicalNamespaceNames = array(
        NS_MEDIA            => 'Media',
        NS_SPECIAL          => 'Special',
        NS_TALK             => 'Talk',
        NS_USER             => 'User',
        NS_USER_TALK        => 'User_talk',
        NS_PROJECT          => 'Project',
        NS_PROJECT_TALK     => 'Project_talk',
        NS_IMAGE            => 'Image',
        NS_IMAGE_TALK       => 'Image_talk',
        NS_MEDIAWIKI        => 'MediaWiki',
        NS_MEDIAWIKI_TALK   => 'MediaWiki_talk',
        NS_TEMPLATE         => 'Template',
        NS_TEMPLATE_TALK    => 'Template_talk',
        NS_HELP             => 'Help',
        NS_HELP_TALK        => 'Help_talk',
        NS_CATEGORY         => 'Category',
        NS_CATEGORY_TALK    => 'Category_talk',
);

define('NS_MAIN', 0);
define('NS_TALK', 1);
define('NS_USER', 2);
define('NS_USER_TALK', 3);
define('NS_PROJECT', 4);
define('NS_PROJECT_TALK', 5);
define('NS_IMAGE', 6);
define('NS_IMAGE_TALK', 7);
define('NS_MEDIAWIKI', 8);
define('NS_MEDIAWIKI_TALK', 9);
define('NS_TEMPLATE', 10);
define('NS_TEMPLATE_TALK', 11);
define('NS_HELP', 12);
define('NS_HELP_TALK', 13);
define('NS_CATEGORY', 14);
define('NS_CATEGORY_TALK', 15);

**/

/**
 * @addtogroup SpecialPage
 */
class MergeToolPage extends SpecialPage {

    var $mCityDomain;

    /**
     * contructor
     */
    function  __construct()
    {
        parent::__construct( "MergeTool" ); #--- , 'mergetool'
    }

    function execute( $subpage = null )
    {

    }
};

?>
