<?php

// MediaWiki Yahoo Extension Ver 1.1 (http://wwww.mediawiki.org/wiki/Extension:Yahoo)

// Extension credits that show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Yahoo',
	'author' => 'Guy Taylor',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Yahoo',
	'description' => 'Render Yahoo Button showing users online status.'
);

// set up MediaWiki to react to the "<yahoo>" tag
$wgHooks['ParserFirstCallInit'][] = "wfYahoo";

function wfYahoo( $parser ) {
	$parser->setHook( "yahoo", "RenderYahoo" );
	return true;
}


// the function that reacts to "<yahoo>"

function RenderYahoo( $input, $argv ) {

	// set your defaults for the style and action (addfriend, call or sendim) (0, 1, 2, 3 and 4)

	$style_default = "2" ;
	$action_default = "sendim" ;

	// escape $input to prevent XSS
	$input = htmlspecialchars($input) ;

	// the varibles are: <yahoo style="$argv['style']" action="$argv['action']">$input</yahoo>

	// test to see if the optinal elements of the tags are set and supported. if not set them to the defaults

	if( isset( $argv['style'] ) ){
		$style = $argv['style'] ;
		if( !($style == "0" OR $style == "1" OR $style == "2" OR $style == "3" OR $style == "4" OR $style == "5" ) ){
			$style = $style_default ;
		}
	} else {
		$style = $style_default ;
	}

	if( isset( $argv['action'] ) ){
		$action = $argv['action'] ;
		if( !($action == "addfriend" OR $action == "sendim" OR $action == "call") ){
			$action = $action_default ;
		}
	} else {
		$action = $action_default ;
	}

	// set the url to the image and the style of the image
	switch( $style ){

		case "0":
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=0" ' ;
			$image .= ' style="border: none; width: 12px; height: 12px;" alt="My status" />' ;
			break;

		case "1":
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=1" ' ;
			$image .= ' style="border: none; width: 64px; height: 16px;" alt="My status" />' ;
			break;

		case "2":
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=2" ' ;
			$image .= ' style="border: none; width: 125px; height: 25px;" alt="My status" />' ;
			break;

		case "3":
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=3" ' ;
			$image .= ' style="border: none; width: 86px; height: 16px;" alt="My status" />' ;
			break;

		case "4":
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=4" ' ;
			$image .= ' style="border: none; width: 12px; height: 12px;" alt="My status" />' ;
			break;
		case "5":
			$image = '<img src="http://opi.yahoo.com/online?u='.$input.'&m=g&t=5" ' ;
			$image .= ' style="border: none; width: 12px; height: 12px;" alt="My status" />' ;
			break;

	}

	// start the rendering the html outupt
	$output  = '<!-- MediaWiki extension http://www.mediawiki.org/wiki/Extension:Yahoo -->';
	$output .= '<a href="ymsgr:'.$action.'?'.$input.'">'.$image.'</a>';
	$output .= '<!-- end of Yahoo button -->';

	// send the output to MediaWiki
	return $output;
}
