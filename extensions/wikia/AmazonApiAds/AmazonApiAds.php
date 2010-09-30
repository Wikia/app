<?php
/**
 * @author: Sean Colombo
 * @date: 20100929
 *
 * This page is designed to be called by Liftium inside of an iframe, with the 'title' parameter set to the name of the page on which
 * it is being called from.
 *
 * DONE: Get the product API to run a Hello World example.
 * DONE: var_dump results for an artist.
 * DONE: Get it to run inside of the MediaWiki stack.
 * DONE: Use MW's Http->get instead of curl.
 * TODO: Make the number of results more easily configurable.
 * TODO: Clean the hacked-together example code into something readable and usable.
 * TODO: Get it to run as an ad on a page.
 * TODO: Make it work for a couple different page types (artist, song, album).
 * TODO: Make it look good.
 * TODO: Make the symlink in clinks.pl.
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

print "<pre>\n";
$searchIndex = "DigitalMusic";
$keywords = "Cake";
$itemPage = 1;
ItemSearch($searchIndex, $keywords, $itemPage);






 
function aws_signed_request($params, $public_key, $private_key, $region="com"){
    /*
    Parameters:
        $params - an array of parameters, eg. array("Operation"=>"ItemLookup",
                        "ItemId"=>"B000X9FLKM", "ResponseGroup"=>"Small")
        $public_key - your "Access Key ID"
        $private_key - your "Secret Access Key"
        $region - the Amazon(r) region (ca,com,co.uk,de,fr,jp)
    */

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
 
 
function ItemSearch($SearchIndex, $Keywords, $ItemPage){

// TODO: REMOVE - This was the old method before signing requests.
//	$request="http://ecs.amazonaws.com/onca/xml?Service=AWSECommerceService&AWSAccessKeyId=".KEYID."&AssociateTag=".AssocTag."&Version=2006-09-11&Operation=ItemSearch&ResponseGroup=Medium,Offers";
//	$request.="&SearchIndex=$SearchIndex&Keywords=$Keywords&ItemPage=$ItemPage";

	$params = array(
		"Operation" => "ItemSearch",
		"SearchIndex" => $SearchIndex,
// NOTE: Instead of "Keywords", can also do "Artist" if desired. Do we care, or should we leave it as-is since we're already searching in DigitalMusic?
		"Keywords" => $Keywords,
		"ItemPage" => $ItemPage,
	);
	$request = aws_signed_request($params, AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);

	$response = Http::get($request);

	//$response = file_get_contents($request);
	$parsed_xml = simplexml_load_string($response);
	printSearchResults($parsed_xml, $SearchIndex, $ItemPage);
} // end ItemSearch()
function ItemLookup($asin){

	$params = array(
		"Operation" => "ItemLookup",
		"ItemId" => $asin,
		"ResponseGroup" => "Medium,Offers"
	);
	$request = aws_signed_request($params, AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY);

	$response = Http::get($request);

	$parsed_xml = simplexml_load_string($response);

	if($parsed_xml->Items->Request->IsValid){
		$current = $parsed_xml->Items->Item;
		
			//if(isset($current->Offers->Offer->OfferListing->OfferListingId)){ //only show items for which there is an offer
				print("<tr><td><img src='".$current->SmallImage->URL."'></td>");
				print("<td><font size='-1'><b>".$current->ItemAttributes->Title."</b>");
				if(isset($current->ItemAttributes->Director)){
					print("<br>Director: ".$current->ItemAttributes->Director);
				} elseif(isset($current->ItemAttributes->Author)) {
					print("<br>Author: ".$current->ItemAttributes->Author);
				} elseif(isset($current->ItemAttributes->Artist)) {
					print("<br>Artist: ".$current->ItemAttributes->Artist);
				} elseif(isset($current->ItemAttributes->Creator)){
					print("<br>Artist: ".$current->ItemAttributes->Creator);
				}
				
				print "<br/>Price: ".$current->OfferSummary->LowestNewPrice->FormattedPrice."<br/>\n";
//				print("<br>Price: ".$current->Offers->Offer->OfferListing->Price->FormattedPrice);
				//$asin = $current->ASIN;
//				$details = "SimpleStore.php?Action=SeeDetails&ASIN=$asin&SearchIndex=$SearchIndex";
	//			print("<br><a href=$details>See Details</a>");
	//			$offerListingId = urlencode($current->Offers->Offer->OfferListing->OfferListingId);
		//		$CartAdd = "SimpleStore.php?Action=CartAdd&OfferListingId=$offerListingId&CartId=$CartId&HMAC=$HMAC";
			//	print("&nbsp;&nbsp;&nbsp; <a href=$CartAdd>Add to Cart</a>");
				print("<tr><td colspan=2>&nbsp;</td> </tr> ");
			//}
	}
	
	//print_r($parsed_xml);
} // end ItemLookup()
//------------------------------------------------------------------------------------------------------
function printSearchResults($parsed_xml, $SearchIndex, $ItemPage=1){
	$numOfItems = $parsed_xml->Items->TotalResults;
	$totalPages = $parsed_xml->Items->TotalPages;

	$CartId = "";//$_GET['CartId'];
	$HMAC = "";//urlencode($_GET['HMAC']);
	print("<table>");
	if($numOfItems>0){
		foreach($parsed_xml->Items->Item as $current){


			ItemLookup($current->ASIN);
		
		}
	}else{
		print("<center>No matches found.</center>");
	}

	print "</table>\n";
}
