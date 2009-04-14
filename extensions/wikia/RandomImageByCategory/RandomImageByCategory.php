<?php
$wgExtensionFunctions[] = "wfRandomImageByCategory";

function wfRandomImageByCategory() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "randomimagebycategory", "GetRandomImage" );
}

function GetRandomImage( $input, $args, &$parser ){
	global $wgUser, $wgParser, $wgTitle, $wgOut, $wgMemc;

	wfProfileIn(__METHOD__);
	
	$parser->disableCache();
	 
	$categories = ( isset($args["categories"]) ) ? trim($args["categories"]) : "";
	$width = ( isset($args["width"]) && is_numeric($args["width"]) ) ? $args["width"] : 200;
	$limit = ( isset($args["limit"]) && is_numeric($args["limit"]) ) ? $args["limit"] : 10;
	
	$key = wfMemcKey( 'image', 'random', $limit, str_replace(" ","",$categories)  );
	$data = $wgMemc->get( $key );
	$image_list = array();
	if( !$data ){
		wfDebug( "Getting ramdom image list from db\n" );
		$p = new Parser();
		$ctg = $p->transformMsg( $categories, $wgOut->parserOptions() );
		$ctg = str_replace("\,","#comma#",$ctg);
		$aCat = explode(",", $ctg);
			
		$category_match = array();
		foreach($aCat as $sCat){
			if($sCat!=""){
				$category_match[] = Title::newFromText(  trim( str_replace("#comma#",",",$sCat) )   )->getDBKey();	
			}
		}
		
		if( count( $category_match ) == 0 ) return "";
		
		$params['ORDER BY'] = 'page_id';
		if ( !empty($limit) ) {
			$params['LIMIT'] = $limit;
		}
		
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( '`page` INNER JOIN `categorylinks` on cl_from=page_id', 'page_title', 
			array( 'cl_to' => $category_match, 'page_namespace' => NS_IMAGE ), __METHOD__, 
			$params
		);
		$image_list = array();
		while ( $row = $dbr->fetchObject($res) ) {
			$image_list[] = $row->page_title;
			
		}
		$wgMemc->set( $key, $image_list, 60 * 15 );
	}else{
		$image_list = $data;
		wfDebug( "Cache hit for ramdom image list\n" );
	}
	
	if( count($image_list) > 1)$random_image = $image_list[ array_rand( $image_list, 1) ];
	if( $random_image ) {
		$image_title = Title::makeTitle(NS_IMAGE, $random_image );
		$render_image = Image::newFromName( $random_image );
	
		$thumb_image = $render_image->getThumbNail( $width );
		$thumbnail = "<a href=\"{$image_title->escapeFullURL()}\">{$thumb_image->toHtml()}</a>";
	}
	
	wfProfileOut(__METHOD__);
	
	return $thumbnail;
	
}

?>
