<?php
/**
 * Aliases for special pages of Blogs extension.
 */

$specialPageAliases = array();

/** English
 */
$specialPageAliases['en'] = array(
	'CreateBlogPage'        => array( 'CreateBlogPage' ),
	'CreateBlogListingPage' => array( 'CreateBlogListingPage' ),
);

/** German (Deutsch)
 */
$specialPageAliases['de'] = array(
	'CreateBlogPage' => array( 'Blog-Beitrag_erstellen' , 'CreateBlogPage' ),
	'CreateBlogListingPage' => array( 'Blog-Aggregation_erstellen', 'CreateBlogListingPage' ),
);

/** Polish (Polski)
 */
$specialPageAliases['pl'] = array(
	'CreateBlogPage'	=> array( 'Utwórz wpis na blogu', 'CreateBlogPage' ),
	'CreateBlogListingPage' => array( 'Utwórz listę wpisów na blogach', 'CreateBlogListingPage' )
);
