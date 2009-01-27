<?php
if(!defined('MEDIAWIKI')) {
	exit(1);
}

$wgHooks['ParserBeforeStrip'][] = 'WikiaVideoParserBeforeStrip';
$wgHooks['ArticleFromTitle'][] = 'WikiaVideoArticleFromTitle';
$wgHooks['MWNamespace:isMovable'][] = 'WikiaVideoIsNotMovable';


function WikiaVideoIsNotMovable( $result, $index ) {
	global $IP;
        require_once( "$IP/extensions/wikia/WikiaVideo/VideoPage.php" );
	$result = !( $index < NS_MAIN || ($index == NS_IMAGE && !$wgAllowImageMoving) || ( $index == NS_VIDEO )  || $index == NS_CATEGORY );
	return true;
}

function WikiaVideoParserBeforeStrip($parser, $text, $strip_state) {
	// TODO change this to accomodate more cases ie parser inside, links and all
	// MW parser stuff 
      	$pattern = "@(\[\[Video:)([^\]]*?)].*?\]@si";   	 	 
	$text = preg_replace_callback($pattern, 'WikiaVideoRenderVideo', $text);
	return true;
}

function WikiaVideoRenderVideo( $matches ) {
        global $IP, $wgOut;
        require_once( "$IP/extensions/wikia/WikiaVideo/VideoPage.php" );
        $name = $matches[2];
        $params = explode( "|", $name );
        $video_name = $params[0];

        $x = 1;

        $width = 300;
        $align = 'left';
        $caption = '';
	$thumb = '';

        foreach($params as $param){
                if($x > 1) {
                        $width_check = strpos( $param, "px" );				
                        if( false !== $width_check ) {
                                $width = str_replace("px", "", $param);
			} else if ('thumb' == $param) {
				$thumb = 'thumb';
				

                        } else if ( ( 'left' == $param ) || ( 'right' == $param ) ) {
                                $align = $param;
                        } else {
                                $caption = $param;
                        }
                }
                $x++;
        }

	// macbre: add FCK support
	global $wgWysiwygParserEnabled;

	if (empty($wgWysiwygParserEnabled)) {
		$output = "<video name=\"{$video_name}\" width=\"{$width}\" align=\"{$align}\" caption=\"{$caption}\" thumb=\"{$thumb}\"></video>";
	}
	else {
		$output = "<video>[[Video:{$matches[2]}]]</video>";
	}
	return $output;
}

function WikiaVideoArticleFromTitle( $title, $article ) {
        global $wgUser, $IP;

        require_once( "$IP/extensions/wikia/WikiaVideo/VideoPage.php" );

        if( NS_VIDEO == $title->getNamespace() ) {
                $article = new VideoPage( $title );
        }
        return true;
}

