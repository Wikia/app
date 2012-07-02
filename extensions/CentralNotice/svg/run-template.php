<?php

if ( php_sapi_name() != 'cli' ) {
	die( "noooo\n" );
}

$i18n = array(
	'ar' => array(
		'dir' => 'rtl',
		'count' => '$1 شخص قد تبرعوا',
		'number' => '10.549',
		'headline' => 'الذي لا تعرفه عن ويكي$1', // ??
		'you' => 'بيدي', // no idea what this mean
		'button' => '» المزيد', // who knows dude
	),
	'en' => array(
		'dir' => 'ltr',
		'count' => '$1 have donated.',
		'number' => '10,549',
		'headline' => '$1 can help Wikipedia to change the world!',
		'you' => 'You',
		'button' => '» Donate now!'
	),
	'he' => array(
		'dir' => 'rtl',
		'count' => '$1 תרמו',
		'number' => '10,549',
		'headline' => '$1 יכולים לעזור לוויקיפדיה לשנות את העולם!',
		'you' => 'אתם',
		'button' => '» תרמו עכשיו!'
	),
	'eo' => array(
		'dir' => 'ltr',
		'count' => '$1 jam donacis.',
		'number' => '10 549',
		'headline' => '$1 povas subteni al Vikipedio ŝanĝi la mondon!',
		'you' => 'Vi',
		'button' => '» Donacu nun!'
	),
	'ja' => array(
		'dir' => 'ltr',
		'count' => '$1人からご寄付が！',
		'number' => '10,549',
		'headline' => 'ウィキメディアに$1をお願いします。',
		'you' => '寄付', // "donate", not "you" :)
		'button' => '» 寄付!',
	),
);

class Messages {
	var $messages;
	function __construct( $messages ) {
		$this->messages = $messages;
	}
	function expand( $msg ) {
		$args = func_get_args();
		array_shift( $args );
		
		$xml = htmlspecialchars( $this->messages[$msg] );
		
		$replacements = array();
		foreach ( $args as $index => $arg ) {
			$replacements['$' . ( $index + 1 )] = $arg;
		}
		
		return strtr( $xml, $replacements );
	}
}

function flipSvg( $dir, $svg ) {
	if ( $dir == 'rtl' ) {
		$svg = preg_replace_callback(
			'/(class="flipx"\s+x=")(\d+)(")/S',
			'flipSvgCoord',
			$svg );
		$svg = preg_replace_callback(
			'/(class="flip")/',
			'flipSvgScale',
			$svg );
	}
	return $svg;
}

function flipSvgCoord( $matches ) {
	return $matches[1] . ( 622 - $matches[2] ) . $matches[3];
}

function flipSvgScale( $matches ) {
	return $matches[1] . ' transform="scale(-1 1) translate(-622 0)"';
}

function progressBar( $count, $max ) {
	$width = 15;
	$maxPeople = 20;
	
	$people = ceil( ( $count / $max ) * $maxPeople );
	$out = '';
	for ( $i = 0; $i < $maxPeople; $i++ ) {
		$x = 24 + $i * $width;
		if ( $i + 1 < $people ) {
			$dude = 'little-dude';
		} elseif ( $i + 1 == $people ) {
			$dude = 'big-dude';
		} elseif ( $i + 1 > $people ) {
			$dude = 'waiting-dude';
		}
		$out .= <<<OUT
     <use
       x="$x"
       xlink:href="#$dude" />

OUT;
	}
	return $out;
}

function expandSvg( $template, $messages ) {
	$dir = $messages->expand( 'dir' );
	$encNumber = $messages->expand( 'number' ); // '15,203';
	$encYou = $messages->expand( 'you' );
	return flipSvg( $dir,
		strtr( $template,
			array(
				'{{{dir}}}' => $dir,
				'{{{count}}}' => $messages->expand( 'count',
					"<tspan class='number'>$encNumber</tspan>" ),
				'{{{headline}}}' => $messages->expand( 'headline',
					"<tspan class='you'>$encYou</tspan>" ),
				'{{{button}}}' => $messages->expand( 'button' ),
				'{{{progress}}}' => progressBar( 10549, 100000 ),
			)
		)
	);
}

$path = "/Applications/Inkscape.app/Contents/Resources/bin";

$template = file_get_contents( 'mockup-template.svg' );
foreach ( $i18n as $lang => $messages ) {
	echo "$lang\n";
	file_put_contents( "out/notice-$lang.svg",
	 	expandSvg( $template, new Messages( $messages ) ) );
	system( "$path/inkscape -z -f out/notice-$lang.svg -e out/notice-$lang.png" );

}
echo "done.\n";
