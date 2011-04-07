<?php

# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'wfWSGalleryParserFunction_Setup';
# Add a hook to initialise the magic word
$wgHooks['LanguageGetMagic'][]       = 'wfWSGalleryParserFunction_Magic';

function wfWSGalleryParserFunction_Setup( $parser ) {
        # Set a function hook associating the "wsgallery" magic word with our function
        $parser->setFunctionHook( 'wsgallery', 'wfWSGallery_Render', 1 );
        return true;
}

function wfWSGalleryParserFunction_Magic( &$magicWords, $langCode ) {
        # Add the magic word
        # The first array element is case sensitive, in this case it is not case sensitive
        # All remaining elements are synonyms for our parser function
        $magicWords['wsgallery'] = array( 0, 'wsgallery' );
        # unless we return true, other parser functions extensions won't get loaded.
        return true;
}

function wfWSGallery_Render( &$parser, $param1 = '0') {
        # The parser function itself
        # The input parameters are wikitext with templates expanded
        # The output should be wikitext too
	global $wgOut;
	global $wgUser;

	$result = "";

	// include('/var/www/db/wsinfo.inc'); // get the db connection info

	// $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die  ('Error connecting to mysql');
	// mysql_select_db($dbname, $conn);

	srand(time() / 2089);
	$rand = rand();

	$dbw = wfGetDB( DB_MASTER );

	$qr = $dbw->query("SELECT id FROM ratings WHERE total_votes > 3 and total_votes < 100 and total_value/total_votes > 3.0 order by RAND($rand)  limit 150");

	$res = $qr->result;

	$result .= "<table width=\"95%\" cellspacing=\"0\" cellpadding=\"5\" style=\"margin:0 0 .5em 1em;
        text-align:center; background:#9ca; border:1px solid #040;\"><tr><td colspan=\"3\"><b>Zuf&auml;llig
	ausgew&auml;hlte Websites</b></td></tr><tr style=\"background:#fff; text-align:center;\">\n";
	$cnt = 0;

	while(list($id) = mysql_fetch_row($res))
	{
	  $ti = $id;
	  $ti{0} = strtoupper($ti{0});
	  $title = Title::newFromText($ti);
	  $rev = Revision::newFromTitle($title);

	  if(!$rev)
	    continue;
	  $txt = $rev->getText();
	  if(!$txt)
	    continue;
	  if(eregi("Erotik|Porno|Adult|NPD|Geparkt|Baustelle|Fehlerseite|Keine|#REDIRECT|{{JuSchu}}", $txt))
	    continue;

	  $armor = substr(md5($id), 0,16) . 'WsWImG=' . $id . "=none=Ws3ik1Ju5ch=" . substr(md5($id), 16);
	  $crypt = strtr(trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, 'WsImgS33CCrret', $armor, MCRYPT_MODE_ECB,
			mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)))), '+/', '-!');

	  $img = "http://thumbs.websitewiki.de/$crypt";

	  $result .= "<td><a href=\"/$ti\"><img src=\"$img\" border=\"0\" alt=\"$ti\" /><br />$ti</a></td>\n";

	  $cnt++;
	  if($cnt >2)
	    break;
	}

	$result .= "</tr></table>\n";

	return array($result, 'noparse' => true, 'isHTML' => true);
}
