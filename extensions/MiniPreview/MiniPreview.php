<?php

/**
 * MiniPreview displays, next to an image, small previews
 * of other images in the same categories or displayed on the same pages
 *
 * @addtogroup Extensions
 * @author Magnus Manske
 * @copyright © 2007 Magnus Manske
 * @licence GNU General Public Licence 2.0 or later
 */

# FIXME: Strict Standards: Creating default object from empty value on lines 262, 283, 302
# FIXME: $1 in 'minipreview-files_in_category' and 'minipreview-files_in_gallery' not handled properly

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

# YOU CAN REDEFINE THESE VARIABLES IN YOUR LocalSettings.php TO ALTER THE BEHAVIOUR OF MiniPreview

$wgMiniPreviewEnabled = true; # Main switch
$wgMiniPreviewExtPath = '/extensions/MiniPreview';
$wgMiniPreviewShowCategories = true; # Look for images in the same categories
$wgMiniPreviewShowGalleries = true; # Look for images in the same galleries (Galleries = Main namespace pages on commons)
$wgMiniPreviewGalleryNamespace = 0; # Default : Main namespace (for commons)
$wgMiniPreviewThumbnailSize = 75; # Last/next thumbnails will be $wgMiniPreviewThumbnailSize pixel squared
$wgMiniPreviewMaxCategories = 10; # Maximum number of categories shown
$wgMiniPreviewMaxGalleries = 10; # Maximum number of galleries shown
$wgMiniPreviewMaxTotal = 15; # Maximum number of categories and galleries shown

# HERE THE SCARY SOFTWARE BEGINS

/**
 * Register extension setup hook and credits
 */
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'MiniPreview',
	'svn-date' => '$LastChangedDate: 2009-03-19 13:34:14 +0100 (czw, 19 mar 2009) $',
	'svn-revision' => '$LastChangedRevision: 48578 $',
	'author' => 'Magnus Manske',
	'url' => 'http://www.mediawiki.org/wiki/Extension:MiniPreview',
	'description' => 'MiniPreview displays, next to an image, small previews of other images in the same categories or displayed on the same pages',
	'descriptionmsg' => 'minipreview-desc',
);

$wgExtensionMessagesFiles['MiniPreview'] = dirname(__FILE__) . '/MiniPreview.i18n.php';
$wgHooks['ImageOpenShowImageInlineBefore'][] = 'efMiniPreviewShow';

function efMiniPreviewShow ( &$imagePage, &$output )  {
	global $wgMiniPreviewEnabled, $wgMiniPreviewGalleryNamespace;
	global $wgMiniPreviewThumbnailSize, $wgMiniPreviewExtPath, $wgScriptPath;
	global $wgMiniPreviewShowCategories, $wgMiniPreviewShowGalleries;
	global $wgMiniPreviewMaxCategories, $wgMiniPreviewMaxGalleries, $wgMiniPreviewMaxTotal;

	if ( !$wgMiniPreviewEnabled )
		return ;

	wfLoadExtensionMessages( 'MiniPreview' );
	# Register CSS
	$output->addLink(
		array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'href' => $wgScriptPath . $wgMiniPreviewExtPath . '/MiniPreview.css'
		)
	) ;

	$previews = array(); # Will contain objects, each having $entry[0] as BEFORE and $entry[1] as AFTER file

	# Get categories to ignore
	$ignore_categories = array() ;
	$data = wfMsg ( 'minipreview-ignore_categories' ) ;
	$data = explode ( "\n" , $data ) ;
	foreach ( $data AS $line ) {
		if ( substr ( $line , 0 , 1 ) != '*' AND substr ( $line , 0 , 1 ) != '#' ) continue ;
		$line = trim ( substr ( $line , 1 ) ) ;
		$ignore_categories[] = $line;
	}

	# Run categories
	if ( $wgMiniPreviewShowCategories ) {
		$categories_timestamps = wfMiniPreviewGetImageCategories( $imagePage );
		$cnt = 0;
		foreach ( $categories_timestamps AS $category => $timestamp ) {
			$use_this = true ;
			foreach ( $ignore_categories AS $ic ) {
				if ( substr ( ucfirst($category) , 0 , strlen ( $ic ) ) != $ic ) continue ;
				$use_this = false ;
				break ;
			}
			if ( !$use_this ) continue ; # Ignore this category
			if ( $cnt == $wgMiniPreviewMaxCategories or $cnt == $wgMiniPreviewMaxTotal ) break ; # Too many categories
			$cnt++;
			$previews[] = wfMiniPreviewGetPreviewForCategory ( $category , $timestamp , $imagePage );
		}
	}

	# Run galleries
	if ( $wgMiniPreviewShowGalleries ) {
		$cnt = 0;
		$galleries = wfMiniPreviewGetImageGalleries( $imagePage );
		foreach ( $galleries AS $id => $title ) {
			if ( $cnt == $wgMiniPreviewMaxGalleries or count ( $previews ) == $wgMiniPreviewMaxTotal ) break; # Too many galleries
			$cnt++;
			$previews[] = wfMiniPreviewGetPreviewForGallery ( $id , $title , $imagePage );
		}
	}

	# Get image info
	$image_titles = array() ;
	foreach ( $previews AS $p ) {
		if ( $p->entry[0]->id != 0 ) $image_titles[$p->entry[0]->title] = $p->entry[0]->title ;
		if ( $p->entry[1]->id != 0 ) $image_titles[$p->entry[1]->title] = $p->entry[1]->title ;
	}
	$image_data = array();
	wfMiniPreviewGetImageData ( $image_titles , &$image_data ) ;

	# Output
	$mainwidth = ( $wgMiniPreviewThumbnailSize + 2 ) * 3 ;
	$html = Xml::openElement( 'div', array (
		'id' => 'MiniPreview',
		'class' => 'MiniPreview_main',
		'style' => "float:right;clear:right",
	) );

	if ( count ( $previews ) == 0 ) { # No results
		$html .= wfMsg ( 'minipreview-no_category_gallery' ) ;
	} else {
		$last_type = $previews[0]->from_category;
		foreach ( $previews AS $p ) {
			if ( $last_type != $p->from_category ) $html .= "<div class='MiniPreviewSeparator'>&nbsp;</div>" ; # Visually separate categories from galleries
			$last_type = $p->from_category;
			$nsid = $p->from_category ? 14 : $wgMiniPreviewGalleryNamespace ;
			$ns = MWNamespace::getCanonicalName ( $nsid ) . ':' ;
			$t = Title::newFromDBkey( $ns . $p->source_title );
			$mode = ( $p->from_category ? "category" : "gallery" ) ;

			$html .= Xml::openElement( 'div', array( 'class' => 'MiniPreview_'.$mode , 'width' => '100%' ) );
			$html .= Xml::element( 'a' , array ( 'href' => $t->getLocalURL() ) , $t->getText() );
			$html .= Xml::openElement( 'table' , array( 'border' => '0' , 'cellpadding' => '0' , 'cellspacing' => '0' )); # CSS is just not up to this yet...
			$html .= Xml::openElement( 'tr' );
			$html .= wfMiniPreviewGetThumbnail ( $p->entry[0] , $image_data ) ;
			$html .= wfMiniPreviewGetThumbnail ( $p->entry[1] , $image_data ) ;

			$html .= Xml::openElement( 'td' );
			$html .= Xml::openElement( 'div', array(
				'style' => "width:{$wgMiniPreviewThumbnailSize}px;height:{$wgMiniPreviewThumbnailSize}px;",
				'class' => 'MiniPreview_count' ));
			$html .= wfMsgExt( 'minipreview-files_in_'.$mode , array( 'parsemag' ), $p->image_count );
			$html .= wfCloseElement ( "div" ) ;
			$html .= wfCloseElement ( "td" ) ;
			$html .= wfCloseElement ( "tr" ) ;
			$html .= wfCloseElement ( "table" ) ;
			$html .= wfCloseElement ( "div" ) ;
		}
	}
	$html .= wfCloseElement ( "div" ) ;
	$output->addHTML( $html );

	return true;
}

function wfMiniPreviewGetThumbnail ( $entry , &$image_data ) {
	global $wgMiniPreviewThumbnailSize;

	$divclass = ( $entry->id == 0 ) ? 'MiniPreview_no_thumb' : 'MiniPreview_thumb' ;

	$ret = '';
	$ret .= Xml::openElement( 'td' );
	$ret .= Xml::openElement( 'div', array(
		'style' => "width:{$wgMiniPreviewThumbnailSize}px;height:{$wgMiniPreviewThumbnailSize}px;overflow:hidden",
		'class' => $divclass )
	);

	if ( $entry->id != 0 ) { # Existing file
		$w = $image_data[$entry->title]->getWidth();
		$h = $image_data[$entry->title]->getHeight();

		$style = "position:relative;overflow:hidden;" ;
		$tw = $wgMiniPreviewThumbnailSize ;
		if ( $w > 0 and $h > 0 ) {
			$th = $tw / $w * $h ;
			if ( $th < $wgMiniPreviewThumbnailSize ) {
				$th = $wgMiniPreviewThumbnailSize;
				$tw = $th / $h * $w;
				$o = -( $th - $wgMiniPreviewThumbnailSize ) / 2;
				$style .= "left:" . floor($o) . "px;";
			}
			if ( $th > $wgMiniPreviewThumbnailSize ) {
				$o = -( $th - $wgMiniPreviewThumbnailSize ) / 2 ;
				$style .= "top:" . floor($o) . "px;";
			}
		} else {
			$default_icon_width = 120 ; # HARDCODED?
			$o = -( $default_icon_width - $wgMiniPreviewThumbnailSize ) / 2 ;
			$style .= "top:" . floor($o) . "px;";
			$style .= "left:" . floor($o) . "px;";
		}

		$thumb_url = $image_data[$entry->title]->createThumb( $tw );
		$image_url = $image_data[$entry->title]->getTitle()->getLocalURL();
		$image_name = $image_data[$entry->title]->getTitle()->getText();

		$ret .= wfOpenElement ( 'a' , array ( 'href' => $image_url ));
		$ret .= wfElement ( 'img' , array ( 'border' => '0', 'style' => $style, 'src' => $thumb_url , 'alt' => $image_name ));
		$ret .= wfCloseElement ( 'a' );
	} else { # No such file
		$ret .= wfMsg ( 'minipreview-no_more_files_here' ) ;
	}
	$ret .= wfCloseElement ( "div" ) ;
	$ret .= wfCloseElement ( "td" ) ;
	return $ret;
}

# Finds all categories the $imagePage belongs to
function wfMiniPreviewGetImageCategories ( &$imagePage ) {
	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select(
		array( 'page', 'categorylinks' ),
		array( 'cl_to', 'cl_timestamp' ),
		array(
			'cl_from          =  page_id',
			'page_namespace' => '6', # Image page only
			'page_title' => $imagePage->mTitle->getDBkey()
		)
	);

	$ret = array();
	while( $x = $dbr->fetchObject ( $res ) ) {
		$ret[$x->cl_to] = $x->cl_timestamp;
	}
	$dbr->freeResult( $res );
	return $ret;
}

# Finds all gallery pages the $imagePage belongs to
function wfMiniPreviewGetImageGalleries ( &$imagePage ) {
	global $wgMiniPreviewGalleryNamespace;
	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select(
		array( 'page', 'imagelinks' ),
		array( 'il_from' , 'page_title' ),
		array(
			'page_id = il_from',
			'page_namespace' => $wgMiniPreviewGalleryNamespace,
			'il_to' => $imagePage->mTitle->getDBkey() )
	);

	$ret = array();
	while( $x = $dbr->fetchObject ( $res ) ) {
		$ret[$x->il_from] = $x->page_title ;
	}
	$dbr->freeResult( $res );
	return $ret;
}

# For a $category and a $timestamp, find the images immediately before and after that timestamp
# in that category, according to timestamp
function wfMiniPreviewGetPreviewForCategory ( $category , $timestamp , $imagePage ) {
	#$ret = new Object;
	$ret->from_category = true;
	$ret->from_gallery = false;
	$ret->source_title = $category;
	$ret->entry = array();

	$dbr = wfGetDB( DB_SLAVE );

	# Get the image BEFORE the current one (according to timestamp)
	$res = $dbr->select(
		array( 'page', 'categorylinks' ),
		array( 'page_title', 'page_id'),
		array(
			'cl_to' => $category , # Same category as current one
			'cl_timestamp < ' . $dbr->addQuotes( $timestamp ), # Timestamp is before the current one
			'page_id = cl_from',
			'page_namespace=6' # Images only
		),
		__METHOD__, #????
		array( 'ORDER BY' => 'cl_timestamp DESC' )
	);
	if( $x = $dbr->fetchObject ( $res ) ) {
		$ret->entry[0]->title = $x->page_title ;
		$ret->entry[0]->id = $x->page_id ;
	} else $ret->entry[0]->id = 0 ;
	$dbr->freeResult( $res );

	# Get the image AFTER the current one (according to timestamp)
	$res = $dbr->select(
		array( 'page', 'categorylinks' ),
		array( 'page_id', 'page_title' ),
		array(
			'cl_to' => $category , # Same category as current one
			'cl_timestamp > ' . $dbr->addQuotes( $timestamp ), # Timestamp is after the current one
			'page_id = cl_from',
			'page_namespace=6' # Images only
		),
		__METHOD__, #????
		array( 'ORDER BY' => 'cl_timestamp')
	);
	if( $x = $dbr->fetchObject ( $res ) ) {
		$ret->entry[1]->title = $x->page_title ;
		$ret->entry[1]->id = $x->page_id ;
	} else $ret->entry[1]->id = 0 ;
	$dbr->freeResult( $res );

	# Get total image count for this category
	$res = $dbr->select(
		array( 'page', 'categorylinks' ),
		array( 'count(*) AS cnt' ),
		array(
			'cl_to' => $category,
			'page_id = cl_from',
			'page_namespace=6' # Images only
		)
	);
	if( $x = $dbr->fetchObject ( $res ) ) $ret->image_count = $x->cnt;
	else $ret->image_count = 0;

	return $ret;
}

# For a $id and a $title, find the images immediately before and after that title
# on that gallery page, according to image title
function wfMiniPreviewGetPreviewForGallery ( $id , $title , $imagePage ) {
	$ret = '';
	$ret->from_category = false;
	$ret->from_gallery = true;
	$ret->source_title = $title;
	$ret->entry = array();

	$dbr = wfGetDB( DB_SLAVE );

	# Get the image BEFORE the current one (according to title)
	$res = $dbr->select(
		array( 'page', 'imagelinks' ),
		array( 'il_from', 'page_id', 'max(il_to) AS maxto' ),
		array(
			'il_from' => $id, # Same page
			'il_to < ' . $dbr->addQuotes( $imagePage->getTitle()->getDBkey() ), # Title comes before the current one
			'page_title = il_to',
			'page_namespace=6' # Images only
		),
		__METHOD__, #????
		array( 'GROUP BY' => 'il_from')
	);
	if( $x = $dbr->fetchObject ( $res ) ) {
		$ret->entry[0]->title .= $x->maxto ;
		$ret->entry[0]->id .= $x->page_id ;
	} else $ret->entry[0]->id = 0 ;
	$dbr->freeResult( $res );

	# Get the image AFTER the current one (according to title)
	$res = $dbr->select(
		array( 'page', 'imagelinks' ),
		array( 'il_from', 'page_id', 'min(il_to) AS minto' ),
		array(
			'il_from' => $id, # Same page
			'il_to > ' . $dbr->addQuotes( $imagePage->mTitle->getDBkey() ), # Title comes after the current one
			'page_title = il_to',
			'page_namespace=6' # Images only
		),
		__METHOD__, #????
		array( 'GROUP BY' => 'il_from')
	);
	if( $x = $dbr->fetchObject ( $res ) ) {
		$ret->entry[1]->title .= $x->minto ;
		$ret->entry[1]->id .= $x->page_id ;
	} else $ret->entry[1]->id = 0 ;
	$dbr->freeResult( $res );

	# Get total image count for this category
	$res = $dbr->select(
		array( 'imagelinks' ),
		array( 'count(*) AS cnt' ),
		array( 'il_from' => $id )
	);
	if( $x = $dbr->fetchObject ( $res ) )
		$ret->image_count = $x->cnt;
	else
		$ret->image_count = 0;

	return $ret ;
}

# For given ids (page_id!) of images, find all image (and page) data
function wfMiniPreviewGetImageData ( $image_titles , &$image_data ) {
	$image_data = array(); # Paranoia
	foreach ( $image_titles AS $i ) {
		$image_data[$i] = wfFindFile( $i );
		$image_data[$i]->load();
	}
}
