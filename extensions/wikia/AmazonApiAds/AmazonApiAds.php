<?php
/**
 * @author: Sean Colombo
 * @date: 20100929
 *
 * This script is meant to be a standalone page which takes in the title of a MediaWiki article
 * and outputs a page which contains just a 300x250 ad full of Amazon DigitalMusic related to the
 * title.  For now, (since this was written just to be used on LyricWiki) the results are always
 * DigitalMusic.
 *
 * This page is designed to be called by Liftium inside of an iframe, with the 'title' parameter set to the name of the page on which
 * it is being called from.
 *
 * DONE: Get the product API to run a Hello World example.
 * DONE: var_dump results for an artist.
 * DONE: Get it to run inside of the MediaWiki stack.
 * DONE: Use MW's Http->get instead of curl.
 * DONE: Make the number of results more easily configurable.
 * DONE: Clean the hacked-together example code into something readable and usable.
 * DONE: Handle the case where the API finds no results (some decent default-ad for Amazon - a play-example-MP3s widget).
 * DONE: Make the symlink in clinks.pl.
 * DONE: Add memcaching of the Amazon results.
 * DONE: Make the thumbnails and song titles a link to the product and the artist-name a link to a search for the Artist in Amazon's MP3 Downloads category.
 *
 * TODO: Make it look good.
 * TODO: Get it to run as an ad on a page.
 * TODO: Make it use skin-colors in Oasis? Might require loading a big CSS file though. oh... maybe not actually.. just a scss file for this widget.
 * TODO: Can we embed a play button? (if we can't use Amazons, is it worth licensing from developer.7digital.net to play 30 second previews?).
 * TODO: If we use scroll-bars, add a "more" link below the bottom (which links to a search for the artist on Amazon in DigitalMusic category).
 */


// Load the MediaWiki stack.
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) { 
	$IP = dirname( __FILE__ ) .'/../../..';
}
require( $IP . '/includes/WebStart.php' );

global $wgAmazonAccessKeyId,$wgAmazonSecretAccessKey;
global $wgRequest;
define('AWS_ACCESS_KEY_ID', $wgAmazonAccessKeyId);
define('AWS_SECRET_ACCESS_KEY', $wgAmazonSecretAccessKey);
define('AssocTag','wikia-20');
define('LW_AD_WIDTH', '300px');
define('LW_AD_HEIGHT', '250px');
define('LW_AMZN_DEFAULT_AD_CODE', '<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" id="Player_8c2e7ea2-3558-455b-af96-a94d8144cfe4"  WIDTH="250px" HEIGHT="250px"> <PARAM NAME="movie" VALUE="http://ws.amazon.com/widgets/q?ServiceVersion=20070822&MarketPlace=US&ID=V20070822%2FUS%2Fwikia-20%2F8014%2F8c2e7ea2-3558-455b-af96-a94d8144cfe4&Operation=GetDisplayTemplate"><PARAM NAME="quality" VALUE="high"><PARAM NAME="bgcolor" VALUE="#FFFFFF"><PARAM NAME="allowscriptaccess" VALUE="always"><embed src="http://ws.amazon.com/widgets/q?ServiceVersion=20070822&MarketPlace=US&ID=V20070822%2FUS%2Fwikia-20%2F8014%2F8c2e7ea2-3558-455b-af96-a94d8144cfe4&Operation=GetDisplayTemplate" id="Player_8c2e7ea2-3558-455b-af96-a94d8144cfe4" quality="high" bgcolor="#ffffff" name="Player_8c2e7ea2-3558-455b-af96-a94d8144cfe4" allowscriptaccess="always"  type="application/x-shockwave-flash" align="middle" height="250px" width="250px"></embed></OBJECT> <NOSCRIPT><A HREF="http://ws.amazon.com/widgets/q?ServiceVersion=20070822&MarketPlace=US&ID=V20070822%2FUS%2Fwikia-20%2F8014%2F8c2e7ea2-3558-455b-af96-a94d8144cfe4&Operation=NoScript">Amazon.com Widgets</A></NOSCRIPT>');
define('SECONDS_IN_A_DAY', 86400); // memcache cache-duration for Amazon queries.
define('WIKIA_AMZN_AFFIL_ID', 'wikia-20');
define('WIKIA_AMZN_SEARCH_TOKEN', '%%SEARCH_TERM%%');
define('WIKIA_AMZN_SEARCH_LINK', 'http://www.amazon.com/gp/search?ie=UTF8&keywords='.WIKIA_AMZN_SEARCH_TOKEN.'&tag='.WIKIA_AMZN_AFFIL_ID.'&index=digital-music&linkCode=ur2&camp=1789&creative=932');
$LW_AMZN_ITEMS_TO_SHOW = 4;
$LW_AMZN_NUMCOLS = 1;
$LW_AMZN_THUMB_SIZE = 75;

// Configure settings based on 'layout'.
global $LW_AMZN_LAYOUT;
$LW_AMZN_LAYOUT = $wgRequest->getVal('layout');
switch($LW_AMZN_LAYOUT){
	case '2col':
		$LW_AMZN_ITEMS_TO_SHOW = 4;
		$LW_AMZN_NUMCOLS = 2;
		$LW_AMZN_THUMB_SIZE = 40;
	default:
	break;
}

$title = $wgRequest->getVal('title', 'Cake');
displayAdForTitle($title);



/**
 * Given the title of a MediaWiki article, displays an ad
 * for DigitalMusic on Amazon, related to that title.
 */
function displayAdForTitle($title){
	global $LW_AMZN_OVERFLOW;

	$title = str_replace(":", " ", $title);
	$title = str_replace("_", " ", $title);
	?><!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php print "$title on Amazon"; ?></title>
		<style type='text/css'>
			html,body{margin:0px;padding:0px;background-color:#ddd;font-family:Helvetica;}
			img{border:0px;}
			<?php printCssByLayout(); ?>
		</style>
	</head>
	<body>
		<div id='article'>
		<?php
			$searchIndex = "DigitalMusic";
			$keywords = $title;
			ItemSearch($searchIndex, $keywords);
		?>
		</div>
	</body>
</html><?php
} // end displayAdForTitle()

/**
 * The layouts will have significantly different css, so they are extracted here to keep that from
 * cluttering up the main template.
 */
function printCssByLayout(){
	global $LW_AMZN_LAYOUT;
	
	if($LW_AMZN_LAYOUT == "2col"){
		?>
			#article{
				width:<?php print LW_AD_WIDTH; ?>;
				height:<?php print LW_AD_HEIGHT; ?>;
				background-color:#fff;
				vertical-align:middle;
				overflow:hidden;
			}
			table{width:100%;height:100%;border-spacing:0px;}
			td{font-size:.75em;padding:0px;vertical-align:top;}
			tr{padding-bottom;10px;}
			#fallback{
				width:100%;
				text-align:center;
			}
		<?php
	} else {
		// One column, scrolling.
		?>
			#article{
				width:<?php print LW_AD_WIDTH; ?>;
				height:<?php print LW_AD_HEIGHT; ?>;
				background-color:#fff;
				vertical-align:middle;
				overflow:auto;
			}
			table{width:100%;height:100%;border-spacing:0px;}
			td{font-size:.75em;padding:0px;vertical-align:top;}
			tr{padding-bottom;10px;}
			#fallback{
				width:100%;
				text-align:center;
			}
		<?php
	}
	
	
} // end printCssByLayout()
 
/**
 * Returns a URL for making a GET request to Amazon with the given parameters and
 * credentials in a certain region (eg: com, co.uk, etc.)
 *
 * @param params - an array of parameters, eg. array("Operation"=>"ItemLookup",
 *					"ItemId"=>"B000X9FLKM", "ResponseGroup"=>"Small")
 * @param public_key - your "Access Key ID"
 * @param private_key - your "Secret Access Key"
 * @param region - the Amazon(r) region (ca,com,co.uk,de,fr,jp)
 */
function aws_signed_request($params, $public_key, $private_key, $region="com"){
    // some parameters
    $method = "GET";
    $host = "ecs.amazonaws.".$region;
    $uri = "/onca/xml";
    
    // additional parameters
    $params["Service"] = "AWSECommerceService";
    $params["AWSAccessKeyId"] = $public_key;
    // GMT timestamp
    $params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z",time());  //may not be more than 15 minutes out of date!
    // API version
    $params["Version"] = "2009-03-31";
    
    // sort the parameters
    ksort($params);
    
    // create the canonicalized query
    $canonicalized_query = array();
    foreach ($params as $param=>$value)
    {
        $param = str_replace("%7E", "~", rawurlencode($param));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $canonicalized_query[] = $param."=".$value;
    }
    $canonicalized_query = implode("&", $canonicalized_query);
    
    // create the string to sign
    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;

    // calculate HMAC with SHA256 and base64-encoding
    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $private_key, True));

	// encode the signature for the request
//  $signature = str_replace("%7E", "~", rawurlencode($signature));
    $signature = rawurlencode($signature);

    // create request
    $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;

    return $request;
} // end aws_signed_request()


function ItemSearch($searchIndex, $keywords, $itemPage=1){
	global $wgMemc;

	$memKey = wfMemcKey('LW_AMZN_ITEM_SEARCH', str_replace(" ", "_", $keywords), $searchIndex, $itemPage);
	$response = $wgMemc->get($memKey);
	if(empty($response)){
		// TODO: REMOVE - This was the old method before signing requests.
		//	$request="http://ecs.amazonaws.com/onca/xml?Service=AWSECommerceService&AWSAccessKeyId=".KEYID."&AssociateTag=".AssocTag."&Version=2006-09-11&Operation=ItemSearch&ResponseGroup=Medium,Offers";
		//	$request.="&SearchIndex=$searchIndex&Keywords=$keywords&ItemPage=$itemPage";

		// NOTE: Instead of "Keywords", can also do "Artist" if desired. For now just leaving it as-is since we're already searching in DigitalMusic.
		$params = array(
			"Operation" => "ItemSearch",
			"SearchIndex" => $searchIndex,
			"Keywords" => $keywords,
			"ItemPage" => $itemPage,
		);

		$request = aws_signed_request($params, AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
		$response = Http::get($request);

		$wgMemc->set($memKey, $response, SECONDS_IN_A_DAY);
	}
	$parsed_xml = simplexml_load_string($response);
	
	printSearchResults($parsed_xml, $searchIndex, $itemPage);
} // end ItemSearch()

/**
 * Given the parsed_xml of an Amazon ItemSearch API request, prints
 * out the results for the ad.  Since the results require more detailed
 * info than is in the search results, an ItemLookup request will be made
 * for each item that is displayed.
 */
function printSearchResults($parsed_xml, $SearchIndex, $ItemPage=1){
	global $LW_AMZN_ITEMS_TO_SHOW, $LW_AMZN_NUMCOLS;
	if(isset($parsed_xml->Items)){
		$numOfItems = $parsed_xml->Items->TotalResults;
		$totalPages = $parsed_xml->Items->TotalPages;
	} else {
		$numOfItems = 0;
		$totalPages = 0;
	}
	if($numOfItems>0){
		print "\t<div style='text-align:center;width:100%'>Amazon</div>\n";
		print "\t\t\t<table>\n";
		$index = 0;
		foreach($parsed_xml->Items->Item as $current){
			if($index < $LW_AMZN_ITEMS_TO_SHOW){
				if($index % $LW_AMZN_NUMCOLS == 0){
					print "\t\t\t\t<tr>\n";
				}

				ItemLookup($current->ASIN);

				if($index % $LW_AMZN_NUMCOLS == ($LW_AMZN_NUMCOLS-1)){
					print "\t\t\t\t</tr>\n";
				}
			}
			$index++;
		}
		print "\t\t\t</table>\n";
	}else{
		// No results were found, just display a default widget.
		print "<div id='fallback'>\n";
		print LW_AMZN_DEFAULT_AD_CODE;
		print "</div>\n";
	}
} // end printSearchResults()

/**
 * Given the ASIN (a unique amazon product identifier), looks up and displays detailed info for that
 * item.
 */
function ItemLookup($asin, $index=0){
	global $LW_AMZN_THUMB_SIZE, $LW_AMZN_NUMCOLS, $wgMemc;

	$memKey = wfMemcKey('AMZN_ITEM_LOOKUP', $asin);
	$response = $wgMemc->get($memKey);
	if(empty($response)){
		$params = array(
			"Operation" => "ItemLookup",
			"ItemId" => $asin,
			"ResponseGroup" => "Medium,Offers"
		);
		$request = aws_signed_request($params, AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);

		$response = Http::get($request);
		$wgMemc->set($memKey, $response, SECONDS_IN_A_DAY);
	}

	$parsed_xml = simplexml_load_string($response);
	
	$DATA_COL_WIDTH = (LW_AD_WIDTH - ($LW_AMZN_THUMB_SIZE * $LW_AMZN_NUMCOLS)) / $LW_AMZN_NUMCOLS;

	if(isset($parsed_xml->Items) && $parsed_xml->Items->Request->IsValid){
		$current = $parsed_xml->Items->Item;

		$detailPageUrl = urldecode($current->DetailPageURL);

		// Are we supposed to do this, or just leave "ws" (presumably "web service") as the tag?
		$detailPageUrl = str_replace("tag=ws", "tag=".WIKIA_AMZN_AFFIL_ID, $detailPageUrl);

		//if(isset($current->Offers->Offer->OfferListing->OfferListingId)){ //only show items for which there is an offer
			switch($LW_AMZN_THUMB_SIZE){
				case 30:
					$imgSrc = $current->ImageSets->ImageSet->SwatchImage->URL;
					break;
				case 40:
				case 75:
				default:
					$imgSrc = $current->SmallImage->URL;
					break;
			}
			$alt = $current->ItemAttributes->Title;
			$alt = str_replace("'", '"', $alt);
			print "\t\t\t\t\t<td width='".$LW_AMZN_THUMB_SIZE."px'><a href='$detailPageUrl'><img src='".$imgSrc."' width='".$LW_AMZN_THUMB_SIZE."px' height='".$LW_AMZN_THUMB_SIZE."px' alt='$alt'/></a></td>\n";

			print "\t\t\t\t\t<td width='".$DATA_COL_WIDTH."px'><b><a href='$detailPageUrl'>".$current->ItemAttributes->Title."</a></b>";
			$artist = "";
			if(isset($current->ItemAttributes->Artist)) {
				$artist = $current->ItemAttributes->Artist;
			} elseif(isset($current->ItemAttributes->Creator)){
				$artist = $current->ItemAttributes->Creator;
			}
			if($artist != ""){
				$searchLink = str_replace(WIKIA_AMZN_SEARCH_TOKEN, $artist, WIKIA_AMZN_SEARCH_LINK);
				print "<br/>by <a href='$searchLink'>$artist</a>";
			}
		
			print "<br/>".$current->OfferSummary->LowestNewPrice->FormattedPrice."<br/>";
			print "</td>\n";
		//}
	}
} // end ItemLookup()
