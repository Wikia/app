<?php
$wgExtensionFunctions[] = "wfGalleryPopulate";

function wfGalleryPopulate() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "gallerypopulate", "GalleryPopulate" );
}

function GalleryPopulate( $input, $args, &$parser ){
	global $wgUser, $wgParser, $wgTitle, $wgOut ;

	$parser->disableCache();
	 
	$category = (isset($args["category"])) ? $args["category"] : "";
	$limit = (isset($args["limit"])) ? $args["limit"] : 10;
	$parser = new Parser();
	$category = $parser->transformMsg( $category, $wgOut->parserOptions() );
	$category_title = Title::newFromText($category);
	if ( !($category_title instanceof Title) ) {
		return "";
	}
	$category_title_secondary = Title::newFromText($category . " Images");
	if ( !($category_title_secondary instanceof Title) ) {
		return "";
	}
	
	$params['ORDER BY'] = 'page_id';
	if ( !empty($limit) ) {
		$params['LIMIT'] = $limit;
	}
	
	$dbr =& wfGetDB( DB_SLAVE );
	$res = $dbr->select( 
		'`page` INNER JOIN `categorylinks` on cl_from=page_id', 
		'page_title', 
		array( 
			'cl_to' => array($category_title->getDBKey(),$category_title_secondary->getDBKey()), 
			'page_namespace' => NS_IMAGE 
		), 
		__METHOD__, 
		$params
	);
		
	$gallery = new ImageGallery();
	$gallery->setShowBytes( false );
	$gallery->setShowFilename( false );
	while ($row = $dbr->fetchObject( $res ) ) {
		$image = Image::newFromName($row->page_title);
		$gallery->add( $image);
	}

	return $gallery->toHtml();
}

?>
