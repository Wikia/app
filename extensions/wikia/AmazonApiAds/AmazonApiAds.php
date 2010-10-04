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
 * TODO: Make it look good.
 * TODO: Handle the case where the API finds no results (some decent default-ad for Amazon - perhaps just one of their widgets).
 * TODO: Get it to run as an ad on a page.
 * TODO: Add memcaching of... the Amazon results? (there will be N+1 amazon requests for N items - perhaps cache the entire output?  not 'correct' way to use memcached but it could work).
 * TODO: Make the symlink in clinks.pl.
 * TODO: Make it use skin-colors in Oasis? Might require loading a big CSS file though. oh... maybe not actually.. just a scss file for this widget.
 * TODO: Can we embed a play button?
 * TODO: If we use scroll-bars, add a "more" link below the bottom.
 */


// Load the MediaWiki stack.
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) { 
	$IP = dirname( __FILE__ ) .'/../../..';
}
require( $IP . '/includes/WebStart.php' );

global $wgAmazonAccessKeyId,$wgAmazonSecretAccessKey;
define('AWS_ACCESS_KEY_ID', $wgAmazonAccessKeyId);
define('AWS_SECRET_ACCESS_KEY', $wgAmazonSecretAccessKey);
define('AssocTag','wikia-20');
define('LW_AD_WIDTH', '300px');
define('LW_AD_HEIGHT', '250px');
define('NUM_ITEMS_TO_SHOW', 4);
define('LW_AD_NUMCOLS', 1);

global $wgRequest;
$title = $wgRequest->getVal('title', 'Cake');
displayAdForTitle($title);



/**
 * Given the title of a MediaWiki article, displays an ad
 * for DigitalMusic on Amazon, related to that title.
 */
function displayAdForTitle($title){
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
		</style>
	</head>
	<body>
		<div id='article'>
			<div style='text-align:center;width:100%'>Amazon</div>
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


function ItemSearch($SearchIndex, $Keywords, $ItemPage=1){

// TODO: REMOVE - This was the old method before signing requests.
//	$request="http://ecs.amazonaws.com/onca/xml?Service=AWSECommerceService&AWSAccessKeyId=".KEYID."&AssociateTag=".AssocTag."&Version=2006-09-11&Operation=ItemSearch&ResponseGroup=Medium,Offers";
//	$request.="&SearchIndex=$SearchIndex&Keywords=$Keywords&ItemPage=$ItemPage";

	// NOTE: Instead of "Keywords", can also do "Artist" if desired. For now just leaving it as-is since we're already searching in DigitalMusic.
	$params = array(
		"Operation" => "ItemSearch",
		"SearchIndex" => $SearchIndex,
		"Keywords" => $Keywords,
		"ItemPage" => $ItemPage,
	);
	$request = aws_signed_request($params, AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);
	$response = Http::get($request);
	$parsed_xml = simplexml_load_string($response);
	
	printSearchResults($parsed_xml, $SearchIndex, $ItemPage);
} // end ItemSearch()


function printSearchResults($parsed_xml, $SearchIndex, $ItemPage=1){
	$numOfItems = $parsed_xml->Items->TotalResults;
	$totalPages = $parsed_xml->Items->TotalPages;

	$CartId = "";//$_GET['CartId'];
	$HMAC = "";//urlencode($_GET['HMAC']);
	if($numOfItems>0){
		print("<table>");
		$index = 0;
		foreach($parsed_xml->Items->Item as $current){
			if($index % LW_AD_NUMCOLS == 0){
				print "<tr>\n";
			}
		
			if($index < NUM_ITEMS_TO_SHOW){
				ItemLookup($current->ASIN);
			}

			if($index % LW_AD_NUMCOLS == (LW_AD_NUMCOLS-1)){
				print "</tr>\n";
			}

			$index++;
		}
		print "</table>\n";
	}else{
		// TODO: HANDLE THIS CASE BETTER... SOME KIND OF DEFAULT
		print("<center>No matches found.</center>");
	}

}

function ItemLookup($asin, $index=0){

	$params = array(
		"Operation" => "ItemLookup",
		"ItemId" => $asin,
		"ResponseGroup" => "Medium,Offers"
	);
	$request = aws_signed_request($params, AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);

	$response = Http::get($request);

	$parsed_xml = simplexml_load_string($response);
	
	if(isset($parsed_xml->Items) && $parsed_xml->Items->Request->IsValid){
		$current = $parsed_xml->Items->Item;
		
		//if(isset($current->Offers->Offer->OfferListing->OfferListingId)){ //only show items for which there is an offer
			// TODO: Add alt-tags.
			//print "<td width='30px'><img src='".$current->ImageSets->ImageSet->SwatchImage->URL."' width='30px' height='30px'/></td>"; // 30x30
			//print "<td width='40px'><img src='".$current->SmallImage->URL."' width='40px' height='40px'/></td>"; // 40x40
			print "<td width='75px'><img src='".$current->SmallImage->URL."' width='75px' height='75px'/></td>"; // 75x75

			print "<td><b>".$current->ItemAttributes->Title."</b>";
			if(isset($current->ItemAttributes->Director)){
				print "<br>Director: ".$current->ItemAttributes->Director;
			} elseif(isset($current->ItemAttributes->Author)) {
				print "<br>Author: ".$current->ItemAttributes->Author;
			} elseif(isset($current->ItemAttributes->Artist)) {
				print "<br>by ".$current->ItemAttributes->Artist;
			} elseif(isset($current->ItemAttributes->Creator)){
				print "<br>by ".$current->ItemAttributes->Creator;
			}
			print "<br/>".$current->OfferSummary->LowestNewPrice->FormattedPrice."<br/>\n";
			print "</td>\n";
		//}
	}
} // end ItemLookup()
