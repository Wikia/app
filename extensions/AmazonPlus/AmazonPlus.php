<?php

/**
 * AmazonPlus extension for MediaWiki -- a highly customizable extension to display Amazon information
 * Documentation is available at http://www.mediawiki.org/wiki/Extension:AmazonPlus
 *
 * Copyright (c) 2008-2009 Ryan Schmidt (Skizzerz)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

# make sure that everything that needs to be set/loaded is that way
$err = '';
if ( !wfIniGetBool( 'allow_url_fopen' ) && !extension_loaded( 'curl' ) ) {
	# we need allow_url_fopen or curl to be on in order for the Http::get() call to work on the amazon url
	$err .= "\n<li>allow_url_fopen or curl must be enabled in php.ini</li>";
}
if ( !extension_loaded( 'simplexml' ) ) {
	# we need the simplexml extension loaded to parse the xml string
	$err .= "\n<li>The SimpleXML extension for PHP must be loaded</li>";
}
# if there were errors found, die with the messages
if ( $err ) {
	$html = '<html><head><title>Error</title></head><body>
	The following errors were discovered with the AmazonPlus extension for MediaWiki:
	<ul>' . $err . '</ul></body></html>';
	echo $html;
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'AmazonPlus',
	'descriptionmsg' => 'amazonplus-desc',
	'version'        => '0.5.3',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:AmazonPlus',
	'author'         => 'Ryan Schmidt',
);

$wgExtensionMessagesFiles['AmazonPlus'] = dirname( __FILE__ ) . '/AmazonPlus.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'efAmazonPlusSetup';
$wgHooks['BeforePageDisplay'][] = 'efAmazonPlusJavascript';

$wgAmazonPlusJSVersion = 1; # Bump the version number every time you change AmazonPlus.js
$wgAmazonPlusAWS = ''; # Amazon AWS Id. Required
$wgAmazonPlusSecretKey = ''; # Amazon Secret Key. Required
$wgAmazonPlusAssociates = array(); # Amazon Associates IDs, per locale. Example: array( 'us' => 'myamazonid', 'fr' => 'myfrenchid' ); Required
$wgAmazonPlusDefaultSearch = 'Books'; # Default search type, can be Books, DVDs, etc.
$wgAmazonPlusDecimal = '.'; # What to seperate the decimals with in currency. e.g. 15.43 or 12,72

# defines
define( 'AMAZONPLUS_ALL', 0 );
define( 'AMAZONPLUS_AMAZON', 1 );
define( 'AMAZONPLUS_NEW', 2 );
define( 'AMAZONPLUS_USED', 3 );

# Set up the tag extension
function efAmazonPlusSetup( $parser ) {
	$parser->setHook( 'amazon', 'efAmazonPlusRender' );
	return true;
}

# Set up the javascript
function efAmazonPlusJavascript( &$out, $sk ) {
	global $wgScriptPath, $wgAmazonPlusJSVersion;
	$src = $wgScriptPath . "/extensions/AmazonPlus/AmazonPlus.js?$wgAmazonPlusJSVersion";
	$out->addScript( '<script type="text/javascript" src="' . $src . '"></script>' . "\n" );
	return true;
}

# Render the tag extension
function efAmazonPlusRender( $input, $args, $parser ) {
	$title = $parser->getTitle();
	# If we can, disable the time limit so queries don't time out
	@set_time_limit( 0 );

	# Parse out template parameters only before getting setting up the class so {{{1}}} and the like work
	$input = $parser->replaceVariables( $input, false, true );
	foreach ( $args as $key => $arg ) {
		$args[$key] = $parser->replaceVariables( $arg, false, true );
	}

	$am = new AmazonPlus( $title, $args, $input );
	if ( !$am instanceOf AmazonPlus ) {
		return '<span class="error">' . wfMsg( $am ) . '</span>';
	}
	wfSuppressWarnings();
	$s = $am->doRequest();
	if ( $s === false ) {
		return '<span class="error">' . wfMsg( 'amazonplus-nores' ) . '</span>';
	} elseif ( $s !== true ) {
		return '<span class="error">' . wfMsg( $s ) . '</span>';
	}

	$ret = $am->getResult();
	$temp = $parser->mOptions->setAllowExternalImages( true );
	$ret = $parser->recursiveTagParse( $ret );
	$ret = str_replace( '%' . $am->getToken( 'priceSelect' ) . '%', $am->priceSelect(), $ret );
	$ret = str_replace( '%' . $am->getToken( 'shortReview' ) . '%', $am->shortReview(), $ret );
	$parser->mOptions->setAllowExternalImages( $temp );
	wfRestoreWarnings();
	return $ret;
}

# Class for holding/parsing information from the Amazon REST interface
class AmazonPlus {
	var $locale, $request, $response, $xml, $input, $error, $valid, $token, $title, $shortReview;

	function __construct( $title, $args, $input ) {
		$this->valid = array( 'us', 'gb', 'ca', 'de', 'fr', 'jp' );
		$this->currencies = array();
		$this->token = array( 'priceSelect' => rand() . '1', 'shortReview' => rand() . '2' );
		if ( isset( $args['locale'] ) ) {
			$this->locale = ( $this->validLocale( $args['locale'] ) ) ? $args['locale'] : 'us';
		} else {
			$this->locale = 'us';
		}
		$id = ( isset( $args['id'] ) ) ? $args['id'] : $this->getId( $title, $args );
		if ( !$id ) {
			return 'amazonplus-noidres';
		}
		$this->title = $title;
		$this->input = $input;
		$this->request = array(
			'Service'        => 'AWSECommerceService',
			'Operation'      => 'ItemLookup',
			'Version'        => '2009-10-01',
			'ItemId'         => $id,
			'ResponseGroup'  => 'Large',
		);
	}

	function validLocale( $loc ) {
		global $wgAmazonPlusAssociates;
		return ( in_array( $loc, $this->valid ) && array_key_exists( $loc, $wgAmazonPlusAssociates ) );
	}

	function setValue( $key, $value ) { $this->request[$key] = $value; }
	function getValue( $key ) { return $this->request[$key]; }
	function getToken( $key ) { return $this->token[$key]; }
	function getLocale() { return $this->locale; }

	function getId( $title, $args ) {
		global $wgAmazonPlusDefaultSearch;
		$kw = ( isset( $args['keywords'] ) ) ? $args['keywords'] : $title->getText();
		$si = ( isset( $args['search'] ) ) ? $args['search'] : $wgAmazonPlusDefaultSearch;
		$this->request = array(
			'Service'       => 'AWSECommerceService',
			'Operation'     => 'ItemSearch',
			'ResponseGroup' => 'ItemIds',
			'Version'       => '2009-10-01',
			'Keywords'      => $kw,
			'SearchIndex'   => $si,
		);
		$this->doRequest();
		if ( !$this->xml || !$this->xml->Items->TotalResults ) {
			return false;
		}
		return $this->xml->Items->Item[0]->ASIN;
	}

	function doRequest() {
		global $wgAmazonPlusSecretKey, $wgAmazonPlusAWS, $wgAmazonPlusAssociates;
		$tld = $this->localeString();
		$urlstr = "http://ecs.amazonaws.{$tld}/onca/xml";
		$i = false;
		// generate the Signature
		$this->request['Timestamp'] = wfTimestamp( TS_ISO_8601, time() );
		$this->request['AWSAccessKeyId'] = $wgAmazonPlusAWS;
		$this->request['AssociateTag'] = $wgAmazonPlusAssociates[$this->locale];
		ksort( $this->request );
		$prestr = "GET\necs.amazonaws.{$tld}\n/onca/xml\n";
		$str = '';
		foreach ( $this->request as $key => $value ) {
			$str .= $this->encode( $key ) . '=' . $this->encode( $value ) . '&';
		}
		$str = rtrim( $str, '&' );
		$signature = $this->encode( base64_encode( hash_hmac( 'sha256', $prestr . $str, $wgAmazonPlusSecretKey, true ) ) );
		$urlstr .= '?' . $str . '&Signature=' . $signature;
		// do the query
		$this->response = Http::get( $urlstr );
		if ( !$this->response ) {
			return 'amazonplus-fgcerr';
		}

		$this->xml = simplexml_load_string( $this->response );
		if ( $this->xml === false ) {
			return 'amazonplus-slserr';
		}

		if ( $this->xml->Items->TotalResults == '0' ) {
			return false;
		}
		return true;
	}

	function encode( $str ) {
		return str_ireplace( '%7E', '~', rawurlencode( $str ) );
	}

	function getResult() {
		$item = $this->xml->Items->Item;
		$imageset = $item->ImageSets->ImageSet;
		$attr = $item->ItemAttributes;
		$editorials = $item->EditorialReviews->EditorialReview;
		$reviews = $item->CustomerReviews;
		$links = array();
		foreach ( $item->ItemLinks->ItemLink as $link ) {
			$links[str_replace( ' ', '', $link->Description )] = $link->URL;
		}
		$replace = array(
			/* IMAGES */
			'largeimage'      => $imageset->LargeImage->URL,
			'mediumimage'     => $imageset->MediumImage->URL,
			'smallimage'      => $imageset->SmallImage->URL,
			'tinyimage'       => $imageset->TinyImage->URL,
			'swatchimage'     => $imageset->SwatchImage->URL,
			'thumbnail'       => $imageset->ThumbnailImage->URL,
			/* REVIEWS AND RATINGS */
			'editorialreview' => $editorials->Content,
			'shortreview'     => $this->shortReview( $editorials->Content ),
			'reviewlink'      => $links['AllCustomerReviews'],
			'editorialsource' => $editorials->Source,
			'rating'          => $reviews->AverageRating,
			'stars'           => $this->starsImage( $reviews->AverageRating ),
			'totalreviews'    => $reviews->TotalReviews,
			/* PRICES */
			'price'           => $this->formatPrice( $item, AMAZONPLUS_ALL ),
			'price-amazon'    => $this->formatPrice( $item, AMAZONPLUS_AMAZON ),
			'price-new'       => $this->formatPrice( $item, AMAZONPLUS_NEW ),
			'price-used'      => $this->formatPrice( $item, AMAZONPLUS_USED ),
			'price-us'        => $this->getPrice( 'us', $item->ASIN, AMAZONPLUS_ALL ),
			'price-gb'        => $this->getPrice( 'gb', $item->ASIN, AMAZONPLUS_ALL ),
			'price-ca'        => $this->getPrice( 'ca', $item->ASIN, AMAZONPLUS_ALL ),
			'price-de'        => $this->getPrice( 'de', $item->ASIN, AMAZONPLUS_ALL ),
			'price-jp'        => $this->getPrice( 'jp', $item->ASIN, AMAZONPLUS_ALL ),
			'price-fr'        => $this->getPrice( 'fr', $item->ASIN, AMAZONPLUS_ALL ),
			'price-us-amazon' => $this->getPrice( 'us', $item->ASIN, AMAZONPLUS_AMAZON ),
			'price-gb-amazon' => $this->getPrice( 'gb', $item->ASIN, AMAZONPLUS_AMAZON ),
			'price-ca-amazon' => $this->getPrice( 'ca', $item->ASIN, AMAZONPLUS_AMAZON ),
			'price-de-amazon' => $this->getPrice( 'de', $item->ASIN, AMAZONPLUS_AMAZON ),
			'price-jp-amazon' => $this->getPrice( 'jp', $item->ASIN, AMAZONPLUS_AMAZON ),
			'price-fr-amazon' => $this->getPrice( 'fr', $item->ASIN, AMAZONPLUS_AMAZON ),
			'price-us-new'    => $this->getPrice( 'us', $item->ASIN, AMAZONPLUS_NEW ),
			'price-gb-new'    => $this->getPrice( 'gb', $item->ASIN, AMAZONPLUS_NEW ),
			'price-ca-new'    => $this->getPrice( 'ca', $item->ASIN, AMAZONPLUS_NEW ),
			'price-de-new'    => $this->getPrice( 'de', $item->ASIN, AMAZONPLUS_NEW ),
			'price-jp-new'    => $this->getPrice( 'jp', $item->ASIN, AMAZONPLUS_NEW ),
			'price-fr-new'    => $this->getPrice( 'fr', $item->ASIN, AMAZONPLUS_NEW ),
			'price-us-used'   => $this->getPrice( 'us', $item->ASIN, AMAZONPLUS_USED ),
			'price-gb-used'   => $this->getPrice( 'gb', $item->ASIN, AMAZONPLUS_USED ),
			'price-ca-used'   => $this->getPrice( 'ca', $item->ASIN, AMAZONPLUS_USED ),
			'price-de-used'   => $this->getPrice( 'de', $item->ASIN, AMAZONPLUS_USED ),
			'price-jp-used'   => $this->getPrice( 'jp', $item->ASIN, AMAZONPLUS_USED ),
			'price-fr-used'   => $this->getPrice( 'fr', $item->ASIN, AMAZONPLUS_USED ),
			'compare'         => '%' . $this->token['priceSelect'] . '%',
			'offers'          => $links['AllOffers'],
			/* DETAILS */
			'url'             => $item->DetailPageURL,
			'author'          => $attr->Author,
			'actor'           => $attr->Actor,
			'title'           => $attr->Title,
			'binding'         => $attr->Binding,
			'pages'           => $attr->NumberOfPages,
			'edition'         => $attr->Edition,
			'releaseyear'     => $this->parseDate( $attr->ReleaseDate, 0 ),
			'releasemonth'    => $this->parseDate( $attr->ReleaseDate, 1 ),
			'releaseday'      => $this->parseDate( $attr->ReleaseDate, 2 ),
			'publishedyear'   => $this->parseDate( $attr->PublicationDate, 0 ),
			'publishedmonth'  => $this->parseDate( $attr->PublicationDate, 1 ),
			'publishedday'    => $this->parseDate( $attr->PublicationDate, 2 ),
			'publisher'       => $attr->Publisher,
			'detailslink'     => $links['Technical Details'],
			/* IDENTIFICATION */
			'isbn'            => $attr->ISBN,
			'asin'            => $item->ASIN,
			'ean'             => $item->EAN,
			/* PURCHASING URLS */
			'buy'             => $item->DetailPageURL,
			'buy-us'          => $this->getUrl( 'us', $item->ASIN ),
			'buy-gb'          => $this->getUrl( 'gb', $item->ASIN ),
			'buy-ca'          => $this->getUrl( 'ca', $item->ASIN ),
			'buy-de'          => $this->getUrl( 'de', $item->ASIN ),
			'buy-jp'          => $this->getUrl( 'jp', $item->ASIN ),
			'buy-fr'          => $this->getUrl( 'fr', $item->ASIN ),
		);

		foreach ( $replace as $find => $rep ) {
			$this->input = str_replace( '%' . $find . '%', $rep, $this->input );
		}
		return $this->input;
	}

	function starsImage( $rating ) {
		$rating = str_replace( '.', '-', $rating );
		return 'http://g-ecx.images-amazon.com/images/G/01/x-locale/common/customer-reviews/ratings/stars-' . $rating . '._V25749327_.gif';
	}

	function parseDate( $date, $segment ) {
		$pieces = explode( '-', $date );
		return $pieces[$segment];
	}

	function shortReview( $rev ) {
		// return the first 3 paragraphs and have a more/less link afterwards
		if ( !$this->shortReview ) {
			$rev = str_replace( '<br>', '<br />', $rev );
			$paras = explode( '<br />', $rev );
			switch( count( $paras ) ) {
				case 1:
					$this->shortReview = $rev;
				case 2:
					$this->shortReview = $rev;
				case 3:
					$this->shortReview = $rev;
				default:
					$head = implode( '<br />', array( $paras[0], $paras[1], $paras[2] ) );
					$html = '<div class="shortReviewFrame" id="shortReviewFrame' . ++$this->src . '">';
					$html .= '<div class="shortReviewHead">' . $head . '</div>';
					$html .= '<div class="shortReviewBody" style="display: none">';
					for ( $i = 3; $i < count( $paras ); $i++ ) {
						$html .= '<br />' . $paras[$i];
					}
					$more = wfMsg( 'amazonplus-more' );
					$less = wfMsg( 'amazonplus-less' );
					$internal = "'{$more}', '{$less}', '{$this->src}'";
					$id = 'shortReviewLink' . $this->src;
					$html .= '</div> <span class="shortReviewLink">[<a href="#" id="' . $id . '" onclick="javascript:toggleReview(' . $internal . ');">' . $more . '</a>]</span></div>';
					$this->shortReview = $html;
			}
			return '%' . $this->token['shortReview'] . '%';
		}
		return $this->shortReview;
	}

	function getPrice( $loc, $asin, $type ) {
		# if it isn't in the input, then don't do the query to save time
		switch( $type ) {
			case AMAZONPLUS_ALL:
				$app = '';
				break;
			case AMAZONPLUS_AMAZON:
				$app = '-amazon';
				break;
			case AMAZONPLUS_NEW:
				$app = '-new';
				break;
			case AMAZONPLUS_USED:
				$app = '-used';
				break;
		}
		if ( strpos( $this->input, "%price-{$loc}{$app}%" ) === false )
			return '';
		# do we already have this info?
		if ( $loc == $this->locale )
			return $this->formatPrice( $this->xml->Items->Item, $type );
		$ap = new AmazonPlus( $this->title, array( 'locale' => $loc, 'id' => $asin ), "%price{$app}%" );
		# if we can't get the right locale, stop early
		if ( $ap->getLocale() != $loc )
			return ''; # Perhaps this should be an error message?
		$ap->doRequest();
		return $ap->getResult();
	}

	function getUrl( $loc, $asin ) {
		# if it isn't in the input, then don't do the query to save time
		if ( strpos( $this->input, "%buy-{$loc}%" ) === false )
			return '';
		# do we already have this info?
		if ( $loc == $this->locale )
			return $this->xml->Items->Item->DetailPageURL;
		$ap = new AmazonPlus( $this->title, array( 'locale' => $loc, 'id' => $asin ), '%buy%' );
		# if we can't get the right locale, stop early
		if ( $ap->getLocale() != $loc )
			return ''; # Perhaps this should be an error message?
		$ap->doRequest();
		return $ap->getResult();
	}

	function priceSelect() {
		$html = '<select onchange="javascript:convertPrices();">
<option id="cp-none" value="cp-none">' . wfMsgHtml( 'amazonplus-cp-none' ) . '</option>
<option id="cp-usd" value="cp-usd">' . wfMsgHtml( 'amazonplus-cp-usd' ) . '</option>
<option id="cp-cad" value="cp-cad">' . wfMsgHtml( 'amazonplus-cp-cad' ) . '</option>
<option id="cp-gbp" value="cp-gbp">' . wfMsgHtml( 'amazonplus-cp-gbp' ) . '</option>
<option id="cp-eur" value="cp-eur">' . wfMsgHtml( 'amazonplus-cp-eur' ) . '</option>
<option id="cp-jpy" value="cp-jpy">' . wfMsgHtml( 'amazonplus-cp-jpy' ) . '</option>
</select>';
		return $html;
	}

	function formatPrice( $offer, $type ) {
		global $wgAmazonPlusDecimal;
		if ( $offer->Offers->TotalOffers != '0' && ( $type == AMAZONPLUS_ALL || $type == AMAZONPLUS_AMAZON ) ) {
			$amount = $offer->Offers->Offer->OfferListing->Price->Amount;
			$code = $offer->Offers->Offer->OfferListing->Price->CurrencyCode;
			$extra[] = 'amazonplus-amazon';
			$err = false;
		} elseif ( $offer->OfferSummary->TotalNew != '0' && ( $type == AMAZONPLUS_ALL || $type == AMAZONPLUS_NEW ) ) {
			$amount = $offer->OfferSummary->LowestNewPrice->Amount;
			$code = $offer->OfferSummary->LowestNewPrice->CurrencyCode;
			$extra[] = 'amazonplus-new';
			$err = false;
		} elseif ( $offer->TotalUsed != '0' && ( $type == AMAZONPLUS_ALL || $type == AMAZONPLUS_USED ) ) {
			$amount = $offer->OfferSummary->LowestUsedPrice->Amount;
			$code = $offer->OfferSummary->LowestUsedPrice->CurrencyCode;
			$extra[] = 'amazonplus-used';
			$err = false;
		} else {
			$err = 'amazonplus-none';
		}
		if ( $err ) {
			return wfMsg( $err );
		}
		foreach ( $offer->ItemAttributes->Languages as $lang ) {
			if ( $lang->Type != 'Published' ) continue;
			$extra[] = 'amazonplus-' . strtolower( $lang->Name );
			break;
		}
		$app = '';
		$params = '';
		$i = 0;
		foreach ( $extra as $val ) {
			$msg = wfMsg( $val );
			if ( $msg == '' ) continue;
			if ( $i++ != 0 ) $params .= wfMsg( 'comma-separator' );
			$params .= $msg;
		}
		if ( $params ) $app = ' ' . wfMsg( 'amazonplus-status', $params );
		$begin = substr( $amount, 0, strlen( $amount ) - 2 );
		$end = substr( $amount, - 2 );
		switch( $this->locale ) {
			case 'us': $sign = '&#36;'; break;
			case 'ca': $sign = '&#36;'; break;
			case 'de': $sign = '€'; break;
			case 'fr': $sign = '€'; break;
			case 'jp': $sign = '¥'; break;
			case 'gb': $sign = '£'; break;
		}
		return wfMsg( 'amazonplus-currency', array( $begin . $wgAmazonPlusDecimal . $end, $code, $sign, $app ) );
	}

	function localeString() {
		switch( $this->locale ) {
			case 'us': return 'com';
			case 'gb': return 'co.uk';
			case 'ca': return 'ca';
			case 'jp': return 'jp';
			case 'fr': return 'fr';
			case 'de': return 'de';
		}
		return 'com';
	}
}
