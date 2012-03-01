<?php
/**
 * Aliases for special pages of Blogs extension.
 */

$aliases = array();

/** English
 */
$aliases['en'] = array(
	'CreateBlogPage'        => array( 'CreateBlogPage' ),
	'CreateBlogListingPage' => array( 'CreateBlogListingPage' ),
);

/** German (Deutsch)
 */
$aliases['de'] = array(
	'CreateBlogPage' => array( 'Blog-Beitrag_erstellen' , 'CreateBlogPage' ),
	'CreateBlogListingPage' => array( 'Blog-Aggregation_erstellen', 'CreateBlogListingPage' ),
);

/** Polish (Polski)
 */
$aliases['pl'] = array(
	'CreateBlogPage'	=> array( 'Utwórz wpis na blogu', 'CreateBlogPage' ),
	'CreateBlogListingPage' => array( 'Utwórz listę wpisów na blogach', 'CreateBlogListingPage' )
);
