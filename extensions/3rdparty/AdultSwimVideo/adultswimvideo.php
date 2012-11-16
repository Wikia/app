<?php
# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'wfExampleParserASvideo_Setup';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Adult Swim Video Embedder',
	'author' => '[[User:CapitalQ|Jon Uleis]]',
	'description' => 'Embeds Adult Swim Flash videos into articles.',
);
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][]       = 'wfExampleParserASvideo_Magic';

function wfExampleParserASvideo_Setup( Parser $parser ) {
	# Set a function hook associating the "example" magic word with our function
	$parser->setFunctionHook( 'watch', 'wfExampleParserASvideo_Render');
	return true;
}

function wfExampleParserASvideo_Magic( &$magicWords, $langCode ) {
	# Add the magic word
	# The first array element is case sensitive, in this case it is not case sensitive
	# All remaining elements are synonyms for our parser function
	$magicWords['watch'] = array( 0, 'watch' );
	# unless we return true, other parser functions extensions won't get loaded.
	return true;
}

function wfExampleParserASvideo_Render( $parser, $param1 = '', $param2 = '' ) {
	# The parser function itself
	# The input parameters are wikitext with templates expanded
	# The output should be wikitext too
	$output='<object width="330" height="281" type="application/x-shockwave-flash" data="http://www.adultswim.com/video/vplayer/index.html"><param name="allowFullScreen" value="true" /><param name="movie" value="http://www.adultswim.com/video/vplayer/index.html"/><param name="FlashVars" value="id='.$param1.'" /><embed src="http://www.adultswim.com/video/vplayer/index.html" type="application/x-shockwave-flash" FlashVars="id='.$param1.'" allowFullScreen="true" width="330" height="281"></embed></object>';

	#$output=$wgOut->addHTML($output);
	return array($output, 'noparse' => true, 'isHTML' => true);
}
