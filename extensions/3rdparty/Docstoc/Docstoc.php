<?php

// MediaWiki Docstoc Extension Ver .1 (http://wwww.mediawiki.org/wiki/Extension:Docstoc)

//useage
//<docstoc docid='1675844' memid='248689' height='300' width='300'></docstoc>
//optional: height, width, embed
//valid embed types: object, embed (default object)

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Docstoc',
	'author' => 'Morder',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Docstoc',
	'description' => 'Renders a Docstoc Document'
);

// register the "<docstoc>" tag
$wgExtensionFunctions[] = "wfDocstoc";

// register the hook
function wfDocstoc() {
	global $wgParser;
	$wgParser->setHook("docstoc", "OutputDocstoc");
}

// respond to <docstoc> tag
function OutputDocstoc($input, $args) {
	//optional height/width
	$height = empty($args['height']) ? '550' : $args['height'];
	$width  = empty($args['width']) ? '670' : $args['width'];

	//required
	$docid  = $args['docid'];
	//required for preview
	$memid  = $args['memid'];

	//do we have required variables
	if ($docid == '' || $memid == '') {
		return 'Invalid docid or memid';
	}

	$embedtype = empty($args['embed']) ? 'object' : 'embed';

	$output = '';

	switch ($embedtype) {
		//output object type embed
		case 'object':
			$output .= '<object id="_ds_'.$docid.'" name="_ds_'.$docid.'" width="'.$width.'" height="'.$height;
			$output .= '" type="application/x-shockwave-flash" data="http://viewer.docstoc.com/">';
			$output .= '<param name="FlashVars" value="doc_id='.$docid.'&mem_id='.$memid.'&doc_type=pdf&fullscreen=0" />';
			$output .= '<param name="movie" value="http://viewer.docstoc.com/"/>';
			$output .= '<param name="allowScriptAccess" value="always" />';
			$output .= '<param name="allowFullScreen" value="true" />';
			$output .= '</object>';
			break;

		//output embed type embed
		case 'embed':
			$output .= '<embed id="_ds_'.$docid.'" name="_ds_'.$docid.'" width="'.$width.'" height="'.$height;
			$output .= '" type="application/x-shockwave-flash" src="http://viewer.docstoc.com/" + FlashVars="doc_id='.$docid;
			$output .= '&mem_id='.$memid.'&doc_type=pdf&fullscreen=0" allowScriptAccess="always" allowFullScreen="true"></embed>';
			break;

		//user specified invalid embed type
		default:
			$output .= 'Invalid embed type';
	}
	return $output;
}

?>
