<?php
# Flickr MediaWiki extension 0.2.1
#
# Tag :
#   <flickr>photoid</flickr>
# Ex :
#   from url http://www.flickr.com/photos/king-edward/391211597/
#   <flickr>391211597</flickr>
#
# This code is licensed under the Creative Commons Attribution-ShareAlike 3.0 License
# For more information or the latest version visit
# http://wiki.edsimpson.co.uk/index.php/Flickr_Extension
#

$wgHooks['ParserFirstCallInit'][] = 'wfFlickr';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Flickr',
        'description' => 'Display Flickr image and link to photo page on Flickr as per their terms',
        'author' => 'Edward Simpson',
        'url' => 'http://wiki.edsimpson.co.uk/index.php/Flickr_Extension'
);

/**
 * @param Parser $parser
 * @return bool
 */
function wfFlickr( $parser ) {
        $parser->setHook('flickr', 'renderFlickr');
        return true;
}

# The callback function for converting the input text to HTML output
function renderFlickr($input) {
	global $wgFlickrAPIKey;

	$FlickrAPIKey = $wgFlickrAPIKey;

	# Start off by splitting $input
	$inp = explode("|", $input, 5);

	# Now check we have SOMEthing
	if (sizeof($inp) == 0) {
		                $output = "<strong class='error'>Flickr Error ( No ID ): Enter at least a PhotoID</strong>";
                return $output;
	}

	if (! is_numeric($inp[0])) {
		$output = "<strong class='error'>Flickr Error ( Not a valid ID ): PhotoID not numeric</strong>";
		return $output;
	}

	# Okay now deal with parameters
	$id = $inp[0];
	$inp = array_slice($inp, 1);
	if (sizeof($inp) > 0) {
	foreach($inp as $test) {
		if ($type == "" && in_array(strtolower($test), array("thumnail", "thumb", "frame"))) {
			$type = strtolower($test);
		} elseif ($location == "" && in_array(strtolower($test), array("right", "left", "center", "none"))) {
			$location = strtolower($test);
		} elseif ($size == "" && in_array(strtolower($test), array("m", "s", "t", "b", "-"))) {
			$size = strtolower($test);
		} elseif  ($caption == "") {
			$caption = $test;
		} else {
			$caption .= "|".$test;
		}

	}
	}
	if ($type == "thumbnail") {$type = "thumb";}
	if ($type == "") {$type = "none";}
	if ($location == "") {$location = "right";}
	if ($size == "-") {$size = "";}
	if ($size != "") {$size = "_".$size;}

	#First get image sizes

        $params = array(
                'api_key'       => $FlickrAPIKey,
                'method'        => 'flickr.photos.getSizes',
                'photo_id'      => $id,
                'format'        => 'php_serial',
        );
        $encoded_params = array();
        foreach ($params as $k => $v){
                $encoded_params[] = urlencode($k).'='.urlencode($v);
        }
        # Call API
        $url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);

        $rsp = Http::get( $url );

        $rsp_obj = unserialize( $rsp, [ 'allowed_classes' => false ] );
        # display the formated HTML and photo link or return an error
        if ($rsp_obj['stat'] != 'ok'){
	        $photoid = $params['photo_id'];
                $error_msg = $rsp_obj['message'];
                $output = "<strong class='error'>Flickr Error ( $error_msg ): PhotoID $photoid</strong>";
		return $output;
	}
	foreach ($rsp_obj['sizes']['size'] as $size_obj) {
		if ($size == "_m" && $size_obj['label'] == "Small") { $width = $size_obj['width']; $height = $size_obj['height']; }
                if ($size == "_s" && $size_obj['label'] == "Square") { $width = $size_obj['width']; $height = $size_obj['height']; }
                if ($size == "_t" && $size_obj['label'] == "Thumbnail") { $width = $size_obj['width']; $height = $size_obj['height']; }
                if ($size == "_b" && $size_obj['label'] == "Large") { $width = $size_obj['width']; $height = $size_obj['height']; }
                if ($size == "" && $size_obj['label'] == "Medium") { $width = $size_obj['width']; $height = $size_obj['height']; }
	}

	#Now get full info

        $params = array(
        	'api_key'       => $FlickrAPIKey,
	        'method'        => 'flickr.photos.getInfo',
	        'photo_id'      => $id,
	        'format'        => 'php_serial',
	);
	$encoded_params = array();
	foreach ($params as $k => $v){
	        $encoded_params[] = urlencode($k).'='.urlencode($v);
	}
	# Call API
	$url = "http://api.flickr.com/services/rest/?".implode('&', $encoded_params);
	$rsp = Http::get( $url );
	$rsp_obj = unserialize( $rsp, [ 'allowed_classes' => false ] );
	# display the formated HTML and photo link or return an error
	if ($rsp_obj['stat'] == 'ok'){
        	$title = $rsp_obj['photo']['title']['_content'];
	        $page = $rsp_obj['photo']['urls']['url']['0']['_content'];
	        $url = "http://farm" . $rsp_obj['photo']['farm'] . ".static.flickr.com/" . $rsp_obj['photo']['server'] . "/" . $rsp_obj['photo']['id'] . "_" . $rsp_obj['photo']['secret'] . $size . ".jpg";
	if ($caption =="") {$caption = $title;}
        if ($type == "thumb" || $type == "frame") {
		$location = "t".$location;
		if ($type == "thumb") {$magnify = '<div class="magnify" style="float:right"><a href="'.$page.'" class="internal" title="Enlarge"><img src="/skins/common/images/magnify-clip.png" width="15" height="11" alt="" /></a></div>';}
		$divwidth = $width + 2 . "px";
	        $output = <<<END
<div class="thumb $location"><div class="thumbinner" style="width:$divwidth;"><a href="$page" class="internal" title="$title"><img src="$url" alt="$title" width="$width" height="$height" longdesc="$page" class="thumbimage" /></a>  <div class="thumbcaption">$magnify$caption</div></div></div>
END;
	} else {
		if ($location == "left" || $location == "right"){
			$class = "float".$location;
		} else {$class = "floatnone";}
	        $output = <<<END
<div class="$class"><span><a href="$page" class="image" title=""><img alt="" longdesc="$page" src="$url"></a></span></div>
END;
		if ($location == "center") {$output = "<div class=\"center\">".$output."</div>";}
	}
	}else{
        	$photoid = $params['photo_id'];
	        $error_msg = $rsp_obj['message'];
        	$output = "<strong class='error'>Flickr Error ( $error_msg ): PhotoID $photoid</strong>";
	}
        return $output;
}
