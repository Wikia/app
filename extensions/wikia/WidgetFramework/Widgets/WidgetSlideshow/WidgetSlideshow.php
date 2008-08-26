<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetSlideshow'] = array(
	'callback' => 'WidgetSlideshow',
	'title' => array(
		'en' => 'Image slideshow',
		'pl' => 'Pokaz obrazów'
	),
	'desc' => array(
		'en' => 'Watch a slideshow of images from this wiki',
		'pl' => 'Pokaz obrazów z tej wiki'
	),
    	'params' => array(
		'show' => array(
			'type' => 'select',
			'values' => array
			(
			    1 => 'newest images',
			    2 => 'random images',
			    3 => 'from list'
			),
			'default' => 1
		),
		'limit' => array(
		    'type'    => 'text',
		    'default' => 10
		)
	),
    'closeable' => true,
    'editable' => true,
);



function WidgetSlideshow($id, $params) {

    wfProfileIn(__METHOD__);
    
    //print_pre($params);

    $json = '<span id="'.$id.'-json" style="display:none">'.WidgetSlideshowGetImagesAsJSON($params['show'], $params['limit']).'</span>';

    $placeholder = '<div id="'.$id.'-images" class="WidgetSlideshowImages">&nbsp;</div>';

    $controls = '<div class="WidgetSlideshowControls" id="'.$id.'-controls">'.
	'<a class="WidgetSlideshowControlPrev" title="'.wfMsg('allpagesprev').'">prev</a>'.
	'<a class="WidgetSlideshowControlNext" title="'.wfMsg('allpagesnext').'">next</a>'.
	'<a class="WidgetSlideshowControlPause">pause</a>'.
	'</div><div style="display:block">&nbsp;</div>';
	
    
    // show 'edit images list' only for staff and sysops and when showing images from special page list
    global $wgUser;
		
    $editText = '';
    
    if ( ($params['show'] == 3) && (in_array('staff', $wgUser->getGroups()) || in_array('sysop', $wgUser->getGroups())) ) {
	// add edit list link only for sysops/staff users
        $url = Title::newFromText('WidgetSlideshowImages', NS_MEDIAWIKI);
			
        $editText = '<div style="opacity: 0.6; float: left; margin-top: 7px">'.
	    '<a href="'.$url->getFullURL('action=edit').'">Edit images list</a>'.
    	    '</div>';
    }    
    
    wfProfileOut(__METHOD__);
        
    return $json . $placeholder . $controls . $editText;
}

// get JSON encoded list of images
function WidgetSlideshowGetImagesAsJSON($set, $limit) {

    global $wgMemc;
    
    $key = wfMemcKey('widget::slideshow::'.$set);
    
    $images = $wgMemc->get( $key );
    //$images = false;

    $list = array('id' => $set.'-'.$limit);
    
    // try to use memcache
    if ( is_array($images) ) {
	$list['memcache'] = $key;
    }
    else {
	switch( $set ) {
	    case 1: // newest
		$images = WidgetSlideshowGetImagesFromNewest();
		break;	    
	    
	    case 2: // random
		$images = WidgetSlideshowGetImagesFromRandom();
		break;	    
	    
	    case 3: // list
		$images = WidgetSlideshowGetImagesFromSpecialPage();
		break;
	}

	// set memcache entry	
	$wgMemc->set($key, $images, 600);
    }
    
    // don't limit images list from special page (refs #2340)
    if ($set != 3) {
        $limit = intval($limit);
	$limit = ($limit < 4 || $limit > 50) ? 15 : $limit;
    
	$images = array_slice($images, 0, $limit);
    }
    
    // "no images" message
    if ( count($images) < 2 ) {
	$list['msg'] = wfMsg('noimages');
	$images = false;
    }
    else {
	$list['count'] = count($images);    
    }
    
    $list['images'] = $images;

    return Wikia::json_encode($list);
}





// grab list of images from special page MediaWiki:WidgetSlideshowImages (limit here has no effect at all ;)
function WidgetSlideshowGetImagesFromSpecialPage()
{
	wfProfileIn(__METHOD__);
		
	$images = array();
	
	$content = WidgetFrameworkGetArticle('WidgetSlideshowImages', NS_MEDIAWIKI);
	
	if ( empty($content) )
		return array();
			
	$list = explode("\n*", trim($content, "\n *"));
		
	// format data and get image thumb src
	foreach ($list as $row) {
		list($imageName, $description) = explode(' ', trim($row, '* '), 2);
		
		$img = wfFindFile( $imageName );
			
		if (is_object($img)) {
			$url = Title::newFromText( $imageName, NS_IMAGE );
				
			$thumb = $img->createThumb(250, 125);

			if (!empty($thumb)) {
			    $images[] = array (
				'thumb' => $thumb,
				'alt'   => $description,
				'url'   => is_object($url) ? $url->getLocalURL() : ''
			    );
			}
		}
		
	}		
			
	wfProfileOut(__METHOD__);
	
	return $images;
}



// grab images list from Special:NewestImages (last 4 months)
function WidgetSlideshowGetImagesFromNewest() {

	wfProfileIn(__METHOD__);
		
	$since = date('YmdHis', strtotime('-120 days 00:00') );
		
	// grab data from image table (img_major_mime == 'image')
	$dbr =& wfGetDB( DB_SLAVE );
		
	$res = $dbr->select('image',								// table name
		array('img_name', 'img_description', 'img_user_text', 'img_timestamp'), 	// fields to get
		array('img_timestamp > "'.$since.'"', 'img_major_mime = "image"'),		// WHERE conditions
		__METHOD__,									// for profiling
		array('ORDER BY' => 'img_timestamp DESC', 'LIMIT' => 50)			// ORDER BY upload timestamp
	);
		
	$images = array();
		
	// format data and get image thumb src
	while ( ($row = $dbr->fetchObject($res)) ) {
		$img = wfFindFile( $row->img_name );
			
		if (is_object($img)) {
			$url = Title::newFromText( $row->img_name, NS_IMAGE );
				
			$thumb = $img->createThumb(250, 125);

			if (!empty($thumb)) {
			    $images[] = array (
				'thumb' => $thumb,
				'alt'   => $row->img_description,
				'url'   => is_object($url) ? $url->getLocalURL() : ''
			    );
			}
		}
	}
		
	$dbr->freeResult($res);
		
	wfProfileOut(__METHOD__);    
		
	return $images;
}
    

// grab random images from whole image DB table
function WidgetSlideshowGetImagesFromRandom() {

	wfProfileIn(__METHOD__);
		
		
	// grab data from image table (img_major_mime == 'image')
	$dbr =& wfGetDB( DB_SLAVE );
		
	$res = $dbr->select('image',								// table name
		array('img_name', 'img_description', 'img_user_text', 'img_timestamp'), 	// fields to get
		array('img_major_mime = "image"'),						// WHERE conditions
		__METHOD__,									// for profiling
		array('ORDER BY' => 'RAND()', 'LIMIT' => 50)					// ORDER BY upload timestamp (I know! ORDER BY RAND() is very heavy)
	);
		
	$images = array();
		
	// format data and get image thumb src
	while ( ($row = $dbr->fetchObject($res)) ) {
		$img = wfFindFile( $row->img_name );
			
		if (is_object($img)) {
			$url = Title::newFromText( $row->img_name, NS_IMAGE );
				
			$thumb = $img->createThumb(250, 125);

			if (!empty($thumb)) {
			    $images[] = array (
				'thumb' => $thumb,
				'alt'   => $row->img_description,
				'url'   => is_object($url) ? $url->getLocalURL() : ''
			    );
			}
		}
	}
		
	$dbr->freeResult($res);
		
	wfProfileOut(__METHOD__);    
		
	return $images;
}
