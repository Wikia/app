<?php

class ExtZeroRatedMobileAccess {
	const VERSION = '0.0.9';

	public static $renderZeroRatedLandingPage;
	public static $renderZeroRatedBanner;
	private static $debugOutput = array();
	private static $displayDebugOutput = false;
	private static $formatMobileUrl = '//%s.m.wikipedia.org/';
	private static $title;
	private static $isFilePage;
	private static $acceptBilling;
	private static $carrier;
	private static $renderZeroRatedRedirect;
	private static $forceClickToViewImages;
	public static $useFormat;

	/**
	 * Handler for the BeforePageDisplay hook
	 *
	 * @param $out OutputPage
	 * @param $text String
	 * @return bool
	 */
	public function beforePageDisplayHTML( &$out, &$text ) {
		global $wgRequest, $wgConf, $wgEnableZeroRatedMobileAccessTesting;
		wfProfileIn( __METHOD__ );

		$DB = wfGetDB( DB_MASTER );
		$DBName = $DB->getDBname();

		list( $site, $lang ) = $wgConf->siteFromDB( $DBName );
		if ( $site == 'wikipedia'  || $wgEnableZeroRatedMobileAccessTesting ) {

			$xDevice = isset( $_SERVER['HTTP_X_DEVICE'] ) ? $_SERVER['HTTP_X_DEVICE'] : '';
			self::$useFormat = $wgRequest->getText( 'useformat' );

			if ( self::$useFormat !== 'mobile' && self::$useFormat !== 'mobile-wap' &&
				!$xDevice ) {
				wfProfileOut( __METHOD__ );
				return true;
			}

			$output = '';

			self::$renderZeroRatedLandingPage = $wgRequest->getFuzzyBool( 'renderZeroRatedLandingPage' );
			self::$renderZeroRatedBanner = $wgRequest->getFuzzyBool( 'renderZeroRatedBanner' );
			self::$renderZeroRatedRedirect = $wgRequest->getFuzzyBool( 'renderZeroRatedRedirect' );
			self::$forceClickToViewImages = $wgRequest->getFuzzyBool( 'forceClickToViewImages' );
			self::$acceptBilling = $wgRequest->getVal( 'acceptbilling' );
			self::$title = $out->getTitle();

			$carrier = $wgRequest->getHeader( 'HTTP_X_CARRIER' );
			if ( $carrier !== '(null)' && $carrier ) {
				self::$renderZeroRatedBanner = true;
			}

			if ( self::$title->getNamespace() == NS_FILE ) {
				self::$isFilePage = true;
			}

			if ( self::$acceptBilling === 'no' ) {
				$targetUrl = $wgRequest->getVal( 'returnto' );
				$out->redirect( $targetUrl, '301' );
				$out->output();
			}

			if ( self::$acceptBilling === 'yes' ) {
				$targetUrl = $wgRequest->getVal( 'returnto' );
				if ( $targetUrl ) {
					$out->redirect( $targetUrl, '301' );
					$out->output();
				}
			}

			if ( self::$isFilePage && self::$acceptBilling !== 'yes' ) {
				$acceptBillingYes = Html::rawElement( 'a',
					array( 'href' => $wgRequest->appendQuery( 'renderZeroRatedBanner=true&acceptbilling=yes' ) ),
					wfMsg( 'zero-rated-mobile-access-banner-text-data-charges-yes' ) );
				$referrer = $wgRequest->getHeader( 'referer' );
				$acceptBillingNo = Html::rawElement( 'a',
					array( 'href' => $wgRequest->appendQuery( 'acceptbilling=no&returnto=' . urlencode( $referrer ) ) ),
					wfMsg( 'zero-rated-mobile-access-banner-text-data-charges-no' ) );
				$bannerText = Html::rawElement( 'h3',
					array(	'id' => 'zero-rated-banner-text' ),
						wfMsg( 'zero-rated-mobile-access-banner-text-data-charges', $acceptBillingYes, $acceptBillingNo ) );
				$banner = Html::rawElement( 'div',
					array(	'style' => 'display:none;', 'id' => 'zero-rated-banner-red' ), $bannerText );
				$output .= $banner;
				$out->clearHTML();
				$out->setPageTitle( null );
			} elseif ( self::$renderZeroRatedRedirect === true ) {
				$returnto = $wgRequest->getVal( 'returnto' );
				$acceptBillingYes = Html::rawElement( 'a',
					array( 'href' => $wgRequest->appendQuery( 'renderZeroRatedBanner=true&acceptbilling=yes&returnto=' . urlencode( $returnto ) ) ),
					wfMsg( 'zero-rated-mobile-access-banner-text-data-charges-yes' ) );
				$referrer = $wgRequest->getHeader( 'referer' );
				$acceptBillingNo = Html::rawElement( 'a',
					array( 'href' => $wgRequest->appendQuery( 'acceptbilling=no&returnto=' . urlencode( $referrer ) ) ),
					wfMsg( 'zero-rated-mobile-access-banner-text-data-charges-no' ) );
				$bannerText = Html::rawElement( 'h3',
					array(	'id' => 'zero-rated-banner-text' ),
						wfMsg( 'zero-rated-mobile-access-banner-text-data-charges', $acceptBillingYes, $acceptBillingNo ) );
				$banner = Html::rawElement( 'div',
					array(	'style' => 'display:none;', 'id' => 'zero-rated-banner-red' ), $bannerText );
				$output .= $banner;
				$out->clearHTML();
				$out->setPageTitle( null );
			} elseif ( self::$renderZeroRatedBanner === true ) {
				self::$carrier = $this->lookupCarrier( $carrier );
				if ( isset( self::$carrier['name'] ) ) {
					$html = $out->getHTML();
					$parsedHtml = $this->parseLinksForZeroQueryString( $html );
					$out->clearHTML();
					$out->addHTML( $parsedHtml );
					$carrierLink = ( isset( self::$carrier['link'] ) ) ? self::$carrier['link'] : '';
					$bannerText = Html::rawElement( 'span',
						array(	'id' => 'zero-rated-banner-text' ),
							wfMsg( 'zero-rated-mobile-access-banner-text', $carrierLink ) );
					$banner = Html::rawElement( 'div',
						array(	'style' => 'display:none;', 'id' => 'zero-rated-banner' ), $bannerText );
					$output .= $banner;
				}
			}
			if ( self::$renderZeroRatedLandingPage === true ) {
				$out->clearHTML();
				$out->setPageTitle( null );
				$output .= wfMsg( 'zero-rated-mobile-access-desc' );
				$languageNames = Language::getLanguageNames();
				$country = $wgRequest->getVal( 'country' );
				$ip = $wgRequest->getVal( 'ip', wfGetIP() );
				// Temporary hack to allow for testing on localhost
				$countryIps = array(
									'GERMANY' => '80.237.226.75',
									'MEXICO' => '187.184.240.247',
									'THAILAND' => '180.180.150.104',
									'FRANCE' => '90.6.70.28',
									);
				$ip = ( strpos( $ip, '192.168.' ) === 0 ) ? $countryIps['THAILAND'] : $ip;
				if ( IP::isValid( $ip ) ) {
					// If no country was passed, try to do GeoIP lookup
					// Requires php5-geoip package
					if ( !$country && function_exists( 'geoip_country_code_by_name' ) ) {
						$country = geoip_country_code_by_name( $ip );
					}
					self::addDebugOutput( $country );
				}
				$languageOptions = $this->createLanguageOptionsFromWikiText();
				// self::$displayDebugOutput = true;
				$languagesForCountry = ( isset( $languageOptions[self::getFullCountryNameFromCode( $country )] ) ) ?
					$languageOptions[self::getFullCountryNameFromCode( $country )] : null;
				self::addDebugOutput( self::getFullCountryNameFromCode( $country ) );
				self::addDebugOutput( $languagesForCountry );
				self::writeDebugOutput();

				if ( is_array( $languagesForCountry ) ) {
					$sizeOfLanguagesForCountry = sizeof( $languagesForCountry );
					for ( $i = 0; $i < $sizeOfLanguagesForCountry; $i++ ) {
						$languageName = $languageNames[$languagesForCountry[$i]['language']];
						$languageCode = $languagesForCountry[$i]['language'];
						$output .= Html::element( 'hr' );
						$output .= Html::element( 'h3', array( 'id' => 'lang_' . $languageCode ), $languageName );
						if ( $i == 0 ) {
							$output .= self::getSearchFormHtml( $languageCode );
						} else {
							$languageUrl = sprintf( self::$formatMobileUrl, $languageCode );
							$output .= Html::element( 'a',
								array(	'id' => 'lang_' . $languageCode,
								 		'href' => $languageUrl ),
								wfMessage( 'zero-rated-mobile-access-home-page-selection',
									$languageName )->inLanguage( $languageCode )
							);
							$output .= Html::element( 'br' );
						}
					}
				}
				$output .= Html::element( 'hr' );
				$output .= wfMsg( 'zero-rated-mobile-access-home-page-selection-text' );
				$output .= Html::openElement( 'select',
					array( 'id' => 'languageselection',
						'onchange' => 'javascript:window.location = this.options[this.selectedIndex].value;',
					)
				);
				$output .=	Html::element( 'option',
					array( 'value' => '' ),
					wfMsg( 'zero-rated-mobile-access-language-selection' )
				);
				foreach ( $languageNames as $languageCode => $languageName ) {
					$output .=	Html::element( 'option',
						array( 'value' => sprintf( self::$formatMobileUrl, $languageCode ) ),
						$languageName
					);
				}
				$output .= Html::closeElement( 'select' );
			}

			if ( $output ) {
				$output = Html::openElement( 'div', array( 'id' => 'zero-landing-page' ) ) . $output . Html::closeElement( 'div' );
				$out->addHTML( $output );
			}
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	* Returns information about carrier
	*
	* @param String $carrier: Name of carrier e.g., "Verizon Wireless"
	* @return Array
	*/
	private function lookupCarrier( $carrier ) {
		wfProfileIn( __METHOD__ );
		$carrierLinkData = array();
		$carrier = strtoupper( $carrier );

		$allCarrierLinkData = $this->createCarrierOptionsFromWikiText();

		if ( is_array( $allCarrierLinkData ) ) {
			if ( isset( $allCarrierLinkData[$carrier] ) ) {
				$carrierLinkData = $allCarrierLinkData[$carrier];
			}
		}

		wfProfileOut( __METHOD__ );
		return $carrierLinkData;
	}

	/**
	* Returns the Html of a page with the various links appended with zeropartner parameter
	*
	* @param String $html: Html of current page
	* @return String
	*/
	private function parseLinksForZeroQueryString( $html ) {
		wfProfileIn( __METHOD__ );
		$html = mb_convert_encoding( $html, 'HTML-ENTITIES', "UTF-8" );
		libxml_use_internal_errors( true );
		$doc = new DOMDocument();
		$doc->loadHTML( '<?xml encoding="UTF-8">' . $html );
		libxml_use_internal_errors( false );
		$doc->preserveWhiteSpace = false;
		$doc->strictErrorChecking = false;
		$doc->encoding = 'UTF-8';

		$xpath = new DOMXpath( $doc );

		if ( !self::$isFilePage && self::$forceClickToViewImages ) {
			$tagToReplace = 'img';
			$tagToReplaceNodes = $doc->getElementsByTagName( $tagToReplace );
			foreach ( $tagToReplaceNodes as $tagToReplaceNode ) {
				if ( $tagToReplaceNode ) {
					$alt = $tagToReplaceNode->getAttribute( 'alt' );
					$spanNodeText = wfMsg( 'zero-rated-mobile-access-click-to-view-image', lcfirst( substr( $alt, 0, 40 ) ) );
					$spanNode = $doc->createElement( "span", str_replace( "&", "&amp;", $spanNodeText ) );
					if ( $alt ) {
						$spanNode->setAttribute( 'title', $alt );
					}
					$tagToReplaceNode->parentNode->replaceChild( $spanNode, $tagToReplaceNode );
				}
			}
		}

		$zeroRatedLinks = $xpath->query( "//a[not(contains(@class,'external'))]" );
		foreach ( $zeroRatedLinks as $zeroRatedLink ) {
			$zeroRatedLinkHref = $zeroRatedLink->getAttribute( 'href' );
			if ( $zeroRatedLinkHref && substr( $zeroRatedLinkHref, 0, 1 ) !== '#' ) {
				$partnerId = isset( self::$carrier['partnerId'] ) ? self::$carrier['partnerId'] : 0;
				$zeroPartnerUrl = wfAppendQuery( $zeroRatedLinkHref,
					array(	'zeropartner' => $partnerId, 'renderZeroRatedBanner' => 'true' ) );
				if ( $zeroPartnerUrl ) {
					$zeroRatedLink->setAttribute( 'href', $zeroPartnerUrl );
				}
			}
		}

		$zeroRatedExternalLinks = $xpath->query( "//a[contains(@class,'external')]" );
		foreach ( $zeroRatedExternalLinks as $zeroRatedExternalLink ) {
			$zeroRatedExternalLinkHref = $zeroRatedExternalLink->getAttribute( 'href' );
			if ( $zeroRatedExternalLinkHref && substr( $zeroRatedExternalLinkHref, 0, 1 ) !== '#' ) {
				$partnerId = isset( self::$carrier['partnerId'] ) ? self::$carrier['partnerId'] : 0;
				$zeroPartnerUrl = wfAppendQuery( $zeroRatedLinkHref,
					array(	'zeropartner' => $partnerId, 'renderZeroRatedBanner' => 'true' ) );
				if ( $zeroPartnerUrl ) {
					$zeroRatedExternalLink->setAttribute( 'href', '?renderZeroRatedRedirect=true&returnto=' . urlencode( $zeroRatedExternalLinkHref ) );
				}
			}
		}

		$output = $doc->saveXML( null, LIBXML_NOEMPTYTAG );
		wfProfileOut( __METHOD__ );
		return $output;
	}

	/**
	* Adds object to debugOutput Array
	*
	* @param Object $object: any valid PHP object
	* @return bool
	*/
	private static function addDebugOutput( $object ) {
		wfProfileIn( __METHOD__ );
		if ( is_array( self::$debugOutput ) ) {
			self::$debugOutput[] = $object;
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	* Writes objects from the debugOutput Array to buffer
	*
	* @return bool
	*/
	private static function writeDebugOutput() {
		wfProfileIn( __METHOD__ );
		if ( self::$debugOutput && self::$displayDebugOutput === true ) {
			echo "<pre>";
			foreach ( self::$debugOutput as $debugOutput ) {
				var_dump( $debugOutput );
			}
			echo "</pre>";
		}
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * @param $formatter array
	 * @param $wikiText string
	 * @param $nChild bool
	 * @return array
	 */
	public function parseWikiTextToArray( Array $formatter, $wikiText, $nChild = false ) {
		$options = array();
		if ( !is_array( $formatter ) ) {
			return $options;
		}
		wfProfileIn( __METHOD__ );
		$data = explode( PHP_EOL, $wikiText );
		if( $nChild ) {
			foreach ( $data as $key => $rawData ) {
				if ( strpos( $rawData, '*' ) === 0 && strpos( $rawData, '**' ) !== 0 && $key >= 0 ) {
					$data = trim( str_replace( '*', '', $rawData ) );
					$prefixName = strtoupper( $data );
					$options[$prefixName] = '';
				} elseif ( strpos( $rawData, '**' ) === 0 && $key > 0 ) {
					$data = trim( str_replace( '*', '', $rawData ) );
					if ( !is_array( $formatter ) ) {
						$options[$prefixName][] = $data;
						continue;
					}
					if ( !isset( $formatter[0]['callback'] ) ) {
						continue;
					}
					$callback = $formatter[0]['callback'];
					if ( method_exists( $this, $callback ) ) {
						$data = $this->$callback( $data );
						if ( $data ) {
							$options[$prefixName][] = $data;
						}
					}
				}
			}
			wfProfileOut( __METHOD__ );
			return $options;
		}

		$arrayKeys = array_keys( $formatter );
		$keyCount = count( $arrayKeys );
		$index = 0;
		foreach ( $data as $key => $rawData ) {
			$index = ( intval( $key ) % $keyCount === 0 ) ? 0 : $index + 1;
			if ( !in_array( $index, $arrayKeys ) ) {
				continue;
			}
			$data = trim( str_replace( '*', '', $rawData ) );
			if ( is_array( $formatter[$index] ) ) {
				$name = $formatter[$index]['name'];
				if ( isset( $formatter[$index]['callback'] ) ) {
					$callback = $formatter[$index]['callback'];
					if ( method_exists( $this, $callback ) ) {
						if ( isset( $formatter[$index]['parameters'] ) ) {
							if ( is_array( $formatter[$index]['parameters'] ) ) {
								$parameters = array();
								foreach ( $formatter[$index]['parameters'] as $parameter ) {
									if ( isset( $options[$prefixName][$parameter] ) ) {
										$parameters[$parameter] = $options[$prefixName][$parameter];
									}
								}
								$data = $this->$callback( $data, $parameters );
							} else {
								$parameter = $formatter[$index]['parameters'];
								if ( isset( $options[$prefixName][$parameter] ) ) {
									$parameterValue = $options[$prefixName][$parameter];
									$data = $this->$callback( $data, $parameterValue );
								}
							}
						} else {
							$data = $this->$callback( $data );
						}
					}
				}
			} else {
				$name = $formatter[$index];
			}
			if ( $index === 0 ) {
				$prefixName = strtoupper( $data );
			}
			$options[$prefixName][$name] = $data;
		}
		wfProfileOut( __METHOD__ );
		return $options;
	}

	public function createUrlCallback( $url, $name ) {
		$carrierLink = Html::rawElement( 'a',
			array( 'href' => $url ),
				$name );
		return $carrierLink;
	}

	public function intValCallback( $int ) {
		return intval( $int );
	}

	/**
	* Returns the carrier options array parsed from a valid wiki page
	*
	* @return Array
	*/
	private function createCarrierOptionsFromWikiText() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$carrierOptionsWikiPage = wfMsgForContent( 'zero-rated-mobile-access-carrier-options-wiki-page' );

		list( $revId, $rev ) = self::getOptionsFromForeignWiki( $carrierOptionsWikiPage );

		if ( $rev ) {
			$key = wfMemcKey( 'zero-rated-mobile-access-carrier-options', $revId );
			$carrierOptions = $wgMemc->get( $key );
		} else {
			$carrierOptions = null;
		}

		if ( !$carrierOptions ) {
			if ( $rev ) {
				$formatter = array(
					0 => 'name',
					1 => array( 'name' => 'link',
								 'callback' => 'createUrlCallback',
								 'parameters' => 'name',
						),
					2 => array( 'name' => 'partnerId',
								 'callback' => 'intValCallback'
						),
				);
				 $carrierOptions = $this->parseWikiTextToArray( $formatter, $rev );
			}
			$wgMemc->set( $key, $carrierOptions, self::getMaxAge() );
		}
		wfProfileOut( __METHOD__ );
		return $carrierOptions;
	}

	/**
	* Returns the foreign wiki options array from a valid wiki page
	*
	* @return Array
	*/
	private static function getOptionsFromForeignWiki( $pageName ) {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$key = null;
		$rev = null;

		if ( $pageName ) {

			$memcKey = wfMemcKey( 'zero-rated-mobile-access-foreign-options-', md5( $pageName ) );
			$foreignOptions = $wgMemc->get( $memcKey );

			if ( !$foreignOptions ) {
				$url = 'http://en.wikipedia.org/w/api.php?action=query&prop=revisions&&rvlimit=1&rvprop=content&format=json&titles=MediaWiki:' . $pageName;
				$ret = Http::get( $url );

				if ( !$ret ) {
					wfProfileOut( __METHOD__ );
					return array( $key, $rev );
				}

				$jsonData = FormatJson::decode( $ret, true );

				if ( isset( $jsonData['query']['pages'] ) ) {
					$key = key( $jsonData['query']['pages'] );
					if ( !is_int( $key ) ) {
						$key = null;
					}

					foreach ( $jsonData['query']['pages'] as $pages ) {
						if ( isset( $pages['revisions'][0]['*'] ) ) {
							$rev = $pages['revisions'][0]['*'];
						}
					}
				}

				if ( $key && $rev ) {
					$wgMemc->set( $memcKey, array( $key, $rev ), self::getMaxAge() );
				}
			} else {
				list ( $key, $rev ) = $foreignOptions;
			}
		}

		wfProfileOut( __METHOD__ );
		return array( $key, $rev );
	}

	public function languagePercentageCallback( $data ) {
		$languageArray = array();
		$lineParts = explode( '#', $data );
		$language = ( isset( $lineParts[0] ) ) ? trim( $lineParts[0] ) : trim( $data );
		if ( $language !== 'portal' && $language !== 'other' ) {
			$languageArray = ( isset( $lineParts[1] ) ) ?
				array(	'language'  =>  $language,
						'percentage'  =>  intval( str_replace( '%', '', trim( $lineParts[1] ) ) ) ) :
				$language;
		}
		return $languageArray;
	}

	/**
	* Returns the language options array parsed from a valid wiki page
	*
	* @return Array
	*/
	private function createLanguageOptionsFromWikiText() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );
		$languageOptionsWikiPage = wfMsgForContent( 'zero-rated-mobile-access-language-options-wiki-page' );

		list( $revId, $rev ) = self::getOptionsFromForeignWiki( $languageOptionsWikiPage );

		if ( $rev ) {
			$key = wfMemcKey( 'zero-rated-mobile-access-language-options', $revId );
			$languageOptions = $wgMemc->get( $key );
		} else {
			$languageOptions = null;
		}

		if ( !$languageOptions ) {
			$languageOptions = array();
			$lines = array();
			if ( $rev ) {
				$formatter = array(
					 0 => array( 'name' => 'partnerId',
								 'callback' => 'languagePercentageCallback'
						),
				);
				$languageOptions = $this->parseWikiTextToArray( $formatter, $rev, true );
			}
			$wgMemc->set( $key, $languageOptions, self::getMaxAge() );
		}
		wfProfileOut( __METHOD__ );
		return $languageOptions;
	}

	/**
	 * Returns the Unix timestamp of current day's first second
	 *
	 * @return int: Timestamp
	 */
	private static function todaysStart() {
		wfProfileIn( __METHOD__ );
		static $time = false;
		if ( !$time ) {
			global $wgLocaltimezone;
			if ( isset( $wgLocaltimezone ) ) {
				$tz = new DateTimeZone( $wgLocaltimezone );
			} else {
				$tz = new DateTimeZone( date_default_timezone_get() );
			}
			$dt = new DateTime( 'now', $tz );
			$dt->setTime( 0, 0, 0 );
			$time = $dt->getTimestamp();
		}
		wfProfileOut( __METHOD__ );
		return $time;
	}

	/**
	* Returns the number of seconds an item should stay in cache
	*
	* @return int: Time in seconds
	*/
	private static function getMaxAge() {
		wfProfileIn( __METHOD__ );
		// add 10 seconds to cater for the time deviation between servers
		$expiry = self::todaysStart() + 24 * 3600 - wfTimestamp() + 10;
		wfProfileOut( __METHOD__ );
		return min( $expiry, 3600 );
	}

	/**
	* Get full country name from code
	*
	* @param string $code: alpha-2 code ISO 3166 country code
	* @return String
	*/
	private static function getFullCountryNameFromCode( $code ) {
		wfProfileIn( __METHOD__ );
		$countries = array(
			'AF' => 'AFGHANISTAN',
			'AL' => 'ALBANIA',
			'DZ' => 'ALGERIA',
			'AS' => 'AMERICAN SAMOA',
			'AD' => 'ANDORRA',
			'AO' => 'ANGOLA',
			'AI' => 'ANGUILLA',
			'AQ' => 'ANTARCTICA',
			'AG' => 'ANTIGUA AND BARBUDA',
			'AR' => 'ARGENTINA',
			'AM' => 'ARMENIA',
			'AW' => 'ARUBA',
			'AU' => 'AUSTRALIA',
			'AT' => 'AUSTRIA',
			'AZ' => 'AZERBAIJAN',
			'BS' => 'BAHAMAS',
			'BH' => 'BAHRAIN',
			'BD' => 'BANGLADESH',
			'BB' => 'BARBADOS',
			'BY' => 'BELARUS',
			'BE' => 'BELGIUM',
			'BZ' => 'BELIZE',
			'BJ' => 'BENIN',
			'BM' => 'BERMUDA',
			'BT' => 'BHUTAN',
			'BO' => 'BOLIVIA',
			'BA' => 'BOSNIA AND HERZEGOVINA',
			'BW' => 'BOTSWANA',
			'BV' => 'BOUVET ISLAND',
			'BR' => 'BRAZIL',
			'IO' => 'BRITISH INDIAN OCEAN TERRITORY',
			'BN' => 'BRUNEI DARUSSALAM',
			'BG' => 'BULGARIA',
			'BF' => 'BURKINA FASO',
			'BI' => 'BURUNDI',
			'KH' => 'CAMBODIA',
			'CM' => 'CAMEROON',
			'CA' => 'CANADA',
			'CV' => 'CAPE VERDE',
			'KY' => 'CAYMAN ISLANDS',
			'CF' => 'CENTRAL AFRICAN REPUBLIC',
			'TD' => 'CHAD',
			'CL' => 'CHILE',
			'CN' => 'CHINA',
			'CX' => 'CHRISTMAS ISLAND',
			'CC' => 'COCOS (KEELING) ISLANDS',
			'CO' => 'COLOMBIA',
			'KM' => 'COMOROS',
			'CG' => 'CONGO',
			'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
			'CK' => 'COOK ISLANDS',
			'CR' => 'COSTA RICA',
			'CI' => 'COTE D IVOIRE',
			'HR' => 'CROATIA',
			'CU' => 'CUBA',
			'CY' => 'CYPRUS',
			'CZ' => 'CZECH REPUBLIC',
			'DK' => 'DENMARK',
			'DJ' => 'DJIBOUTI',
			'DM' => 'DOMINICA',
			'DO' => 'DOMINICAN REPUBLIC',
			'TP' => 'EAST TIMOR',
			'EC' => 'ECUADOR',
			'EG' => 'EGYPT',
			'SV' => 'EL SALVADOR',
			'GQ' => 'EQUATORIAL GUINEA',
			'ER' => 'ERITREA',
			'EE' => 'ESTONIA',
			'ET' => 'ETHIOPIA',
			'FK' => 'FALKLAND ISLANDS (MALVINAS)',
			'FO' => 'FAROE ISLANDS',
			'FJ' => 'FIJI',
			'FI' => 'FINLAND',
			'FR' => 'FRANCE',
			'GF' => 'FRENCH GUIANA',
			'PF' => 'FRENCH POLYNESIA',
			'TF' => 'FRENCH SOUTHERN TERRITORIES',
			'GA' => 'GABON',
			'GM' => 'GAMBIA',
			'GE' => 'GEORGIA',
			'DE' => 'GERMANY',
			'GH' => 'GHANA',
			'GI' => 'GIBRALTAR',
			'GR' => 'GREECE',
			'GL' => 'GREENLAND',
			'GD' => 'GRENADA',
			'GP' => 'GUADELOUPE',
			'GU' => 'GUAM',
			'GT' => 'GUATEMALA',
			'GN' => 'GUINEA',
			'GW' => 'GUINEA-BISSAU',
			'GY' => 'GUYANA',
			'HT' => 'HAITI',
			'HM' => 'HEARD ISLAND AND MCDONALD ISLANDS',
			'VA' => 'HOLY SEE (VATICAN CITY STATE)',
			'HN' => 'HONDURAS',
			'HK' => 'HONG KONG',
			'HU' => 'HUNGARY',
			'IS' => 'ICELAND',
			'IN' => 'INDIA',
			'ID' => 'INDONESIA',
			'IR' => 'IRAN, ISLAMIC REPUBLIC OF',
			'IQ' => 'IRAQ',
			'IE' => 'IRELAND',
			'IL' => 'ISRAEL',
			'IT' => 'ITALY',
			'JM' => 'JAMAICA',
			'JP' => 'JAPAN',
			'JO' => 'JORDAN',
			'KZ' => 'KAZAKSTAN',
			'KE' => 'KENYA',
			'KI' => 'KIRIBATI',
			'KP' => 'KOREA DEMOCRATIC PEOPLES REPUBLIC OF',
			'KR' => 'KOREA REPUBLIC OF',
			'KW' => 'KUWAIT',
			'KG' => 'KYRGYZSTAN',
			'LA' => 'LAO PEOPLES DEMOCRATIC REPUBLIC',
			'LV' => 'LATVIA',
			'LB' => 'LEBANON',
			'LS' => 'LESOTHO',
			'LR' => 'LIBERIA',
			'LY' => 'LIBYAN ARAB JAMAHIRIYA',
			'LI' => 'LIECHTENSTEIN',
			'LT' => 'LITHUANIA',
			'LU' => 'LUXEMBOURG',
			'MO' => 'MACAU',
			'MK' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
			'MG' => 'MADAGASCAR',
			'MW' => 'MALAWI',
			'MY' => 'MALAYSIA',
			'MV' => 'MALDIVES',
			'ML' => 'MALI',
			'MT' => 'MALTA',
			'MH' => 'MARSHALL ISLANDS',
			'MQ' => 'MARTINIQUE',
			'MR' => 'MAURITANIA',
			'MU' => 'MAURITIUS',
			'YT' => 'MAYOTTE',
			'MX' => 'MEXICO',
			'FM' => 'MICRONESIA, FEDERATED STATES OF',
			'MD' => 'MOLDOVA, REPUBLIC OF',
			'MC' => 'MONACO',
			'MN' => 'MONGOLIA',
			'MS' => 'MONTSERRAT',
			'MA' => 'MOROCCO',
			'MZ' => 'MOZAMBIQUE',
			'MM' => 'MYANMAR',
			'NA' => 'NAMIBIA',
			'NR' => 'NAURU',
			'NP' => 'NEPAL',
			'NL' => 'NETHERLANDS',
			'AN' => 'NETHERLANDS ANTILLES',
			'NC' => 'NEW CALEDONIA',
			'NZ' => 'NEW ZEALAND',
			'NI' => 'NICARAGUA',
			'NE' => 'NIGER',
			'NG' => 'NIGERIA',
			'NU' => 'NIUE',
			'NF' => 'NORFOLK ISLAND',
			'MP' => 'NORTHERN MARIANA ISLANDS',
			'NO' => 'NORWAY',
			'OM' => 'OMAN',
			'PK' => 'PAKISTAN',
			'PW' => 'PALAU',
			'PS' => 'PALESTINIAN TERRITORY, OCCUPIED',
			'PA' => 'PANAMA',
			'PG' => 'PAPUA NEW GUINEA',
			'PY' => 'PARAGUAY',
			'PE' => 'PERU',
			'PH' => 'PHILIPPINES',
			'PN' => 'PITCAIRN',
			'PL' => 'POLAND',
			'PT' => 'PORTUGAL',
			'PR' => 'PUERTO RICO',
			'QA' => 'QATAR',
			'RE' => 'REUNION',
			'RO' => 'ROMANIA',
			'RU' => 'RUSSIAN FEDERATION',
			'RW' => 'RWANDA',
			'SH' => 'SAINT HELENA',
			'KN' => 'SAINT KITTS AND NEVIS',
			'LC' => 'SAINT LUCIA',
			'PM' => 'SAINT PIERRE AND MIQUELON',
			'VC' => 'SAINT VINCENT AND THE GRENADINES',
			'WS' => 'SAMOA',
			'SM' => 'SAN MARINO',
			'ST' => 'SAO TOME AND PRINCIPE',
			'SA' => 'SAUDI ARABIA',
			'SN' => 'SENEGAL',
			'SC' => 'SEYCHELLES',
			'SL' => 'SIERRA LEONE',
			'SG' => 'SINGAPORE',
			'SK' => 'SLOVAKIA',
			'SI' => 'SLOVENIA',
			'SB' => 'SOLOMON ISLANDS',
			'SO' => 'SOMALIA',
			'ZA' => 'SOUTH AFRICA',
			'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
			'ES' => 'SPAIN',
			'LK' => 'SRI LANKA',
			'SD' => 'SUDAN',
			'SR' => 'SURINAME',
			'SJ' => 'SVALBARD AND JAN MAYEN',
			'SZ' => 'SWAZILAND',
			'SE' => 'SWEDEN',
			'CH' => 'SWITZERLAND',
			'SY' => 'SYRIAN ARAB REPUBLIC',
			'TW' => 'TAIWAN, PROVINCE OF CHINA',
			'TJ' => 'TAJIKISTAN',
			'TZ' => 'TANZANIA, UNITED REPUBLIC OF',
			'TH' => 'THAILAND',
			'TG' => 'TOGO',
			'TK' => 'TOKELAU',
			'TO' => 'TONGA',
			'TT' => 'TRINIDAD AND TOBAGO',
			'TN' => 'TUNISIA',
			'TR' => 'TURKEY',
			'TM' => 'TURKMENISTAN',
			'TC' => 'TURKS AND CAICOS ISLANDS',
			'TV' => 'TUVALU',
			'UG' => 'UGANDA',
			'UA' => 'UKRAINE',
			'AE' => 'UNITED ARAB EMIRATES',
			'GB' => 'UNITED KINGDOM',
			'US' => 'UNITED STATES',
			'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS',
			'UY' => 'URUGUAY',
			'UZ' => 'UZBEKISTAN',
			'VU' => 'VANUATU',
			'VE' => 'VENEZUELA',
			'VN' => 'VIET NAM',
			'VG' => 'VIRGIN ISLANDS, BRITISH',
			'VI' => 'VIRGIN ISLANDS, U.S.',
			'WF' => 'WALLIS AND FUTUNA',
			'EH' => 'WESTERN SAHARA',
			'YE' => 'YEMEN',
			'YU' => 'YUGOSLAVIA',
			'ZM' => 'ZAMBIA',
			'ZW' => 'ZIMBABWE',
			);
		wfProfileOut( __METHOD__ );
		$code = ( strlen( $code ) === 2 ) ? strtoupper( $code ) : null;
		return ( $code && isset( $countries[$code] ) ) ? $countries[$code] : null;
	}

	/**
	* Search form for various languages
	*
	* @param string $langCode: alpha-2 code for language
	* @return String
	*/
	private static function getSearchFormHtml( $langCode ) {
		wfProfileIn( __METHOD__ );
		$searchValue = wfMessage( 'zero-rated-mobile-access-search' )->inLanguage( $langCode );
		$formHtml = <<<HTML
		<form id="zero-language-search" action="//{$langCode}.wikipedia.org/w/index.php" class="search_bar" method="get">
			<input type="hidden" value="Special:Search" name="title">
			<div id="sq" class="divclearable">
        		<input type="text" name="search" id="search" size="22" value="" autocorrect="off" autocomplete="off" autocapitalize="off" maxlength="1024">
				<div class="clearlink" id="clearsearch" title="Clear"></div>
			</div>
		<button id="goButton" type="submit">{$searchValue}</button>
		</form>
HTML;
		wfProfileOut( __METHOD__ );
		return $formHtml;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ZeroRatedMobileAccess.body.php 110188 2012-01-27 23:21:31Z preilly $';
	}
}
