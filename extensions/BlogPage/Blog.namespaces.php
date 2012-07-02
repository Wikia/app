<?php
/**
 * Translations of the Blog namespace.
 *
 * @file
 */

$namespaceNames = array();

// For wikis where the BlogPage extension is not installed.
if( !defined( 'NS_BLOG' ) ) {
	define( 'NS_BLOG', 500 );
}

if( !defined( 'NS_BLOG_TALK' ) ) {
	define( 'NS_BLOG_TALK', 501 );
}

/** English */
$namespaceNames['en'] = array(
	NS_BLOG => 'Blog',
	NS_BLOG_TALK => 'Blog_talk',
);

/** German (Deutsch) */
$namespaceNames['de'] = array(
	NS_BLOG => 'Blog',
	NS_BLOG_TALK => 'Blog_Diskussion'
);

/** Spanish (Español) */
$namespaceNames['es'] = array(
	NS_BLOG => 'Blog',
	NS_BLOG_TALK => 'Blog_Discusión'
);

/** Finnish (Suomi) */
$namespaceNames['fi'] = array(
	NS_BLOG => 'Blogi',
	NS_BLOG_TALK => 'Keskustelu_blogista',
);

/** Dutch (Nederlands) */
$namespaceNames['nl'] = array(
	NS_BLOG => 'Blog',
	NS_BLOG_TALK => 'Overleg_blog',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬) */
$namespaceNames['nn'] = array(
	NS_BLOG => 'Blogg',
	NS_BLOG_TALK => 'Bloggdiskusjon'
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬) */
$namespaceNames['no'] = array(
	NS_BLOG => 'Blogg',
	NS_BLOG_TALK => 'Bloggdiskusjon'
);

/** Russian (Русский) */
$namespaceNames['ru'] = array(
	NS_BLOG => 'Блог',
	NS_BLOG_TALK => 'Обсуждение_блога'
);