<?php
$wgExtensionFunctions[] = "wfVideoGalleryPopulate";

function wfVideoGalleryPopulate() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "videogallerypopulate", "VideoGalleryPopulate" );
}

function VideoGalleryPopulate( $input, $args, &$parser ){
	global $wgUser, $wgParser, $wgTitle, $wgOut ;

	$parser->disableCache();
	
	$category = $args["category"];
	$parser = new Parser();
	$category = $parser->transformMsg( $category, $wgOut->parserOptions() );
	$category_title = Title::newFromText($category);
	$category_title_secondary = Title::newFromText($category . " Videos");
	$limit = $args["limit"];
	
	$params['ORDER BY'] = 'page_id';
	if($limit)$params['LIMIT'] = $limit;
	
	$dbr =& wfGetDB( DB_SLAVE );
	$res = $dbr->select( '`page` INNER JOIN `categorylinks` on cl_from=page_id', 'page_title', 
			array( 'cl_to' => array($category_title->getDBKey(),$category_title_secondary->getDBKey()), 'page_namespace' => NS_VIDEO ), __METHOD__, 
			$params 
		);
	
	$gallery = new VideoGallery();
	$gallery->setParsing( true );
	$gallery->setShowFilename( true );
	while ($row = $dbr->fetchObject( $res ) ) {
		$video = Video::newFromName($row->page_title);
		$gallery->add( $video );
	}
	return $gallery->toHtml();
	
}

?>