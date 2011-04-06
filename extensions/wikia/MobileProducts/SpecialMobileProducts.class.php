<?php
/**
 * Mobile landing special page
 * 
 *@author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
 class SpecialMobileProducts extends UnlistedSpecialPage {	
	const GOOGLE_STORE_PREFIX = 'google::';
	const APPLE_STORE_PREFIX = 'apple::';
	const WEB_STORE_PREFIX = 'web::';
	
	private $mApp;
	private $mOut;
	private $mExtensionPath;
	private $mRequest;
	private $mValidProducts;
	private $mBlankImgUrl;
	private $mUser;
	private $mMobileBrowser;
	
	function __construct() {
		//wfLoadExtensionMessages( 'MobileProducts' );
		parent::__construct( 'MobileProducts' );
		
		$this->mApp = F::app();
		$this->mValidProducts = array(
			'gameguides',
			'wikiaphone',
			'lyricwiki'
		);
		list(
		     $this->mOut,
		     $this->mExtensionPath,
		     $this->mBlankImgUrl,
		     $this->mUser
		) = $this->mApp->getGlobals(
			'wgOut',
			'wgExtensionsPath',
			'wgBlankImgUrl',
			'wgUser'
		);
		$this->mMobileBrowser = in_array( get_class( $this->mUser->getSkin() ), array( 'SkinWikiaphone', 'SkinWikiaApp') );
	}
	
	function execute( $product ) {
		$this->setHeaders();
		
		$this->mApp->setGlobal( 'wgSuppressWikiHeader', true );
		$this->mApp->setGlobal( 'wgSupressPageSubtitle', true );
		$this->mApp->setGlobal( 'wgShowMyToolsOnly', true );
		
		$templateName = '';
		$data = array();
		
		if ( empty( $product ) ) {
			$data = $this->getLandingPageData();
			$templateName = 'landingpage';
		} else {
			if ( in_array( $product, $this->mValidProducts ) ) {
				$data = $this->getProductData( $product );
				$templateName = 'productpage';
			} else {
				$this->redirectToLandingPage();
			}
		}
		
		$data['imagesPath'] = "{$this->mExtensionPath}/wikia/MobileProducts/images/";
		$data['wgBlankImgUrl'] = $this->mBlankImgUrl;
		$data['mobile'] = $this->mMobileBrowser;
		
		$this->mOut->addStyle(AssetsManager::getInstance()->getSassCommonURL("extensions/wikia/MobileProducts/css/{$templateName}.scss" ) );
		$this->mOut->addScriptFile( "{$this->mExtensionPath}/../skins/common/jquery/jquery-slideshow-0.4.js" );
		$this->mOut->addScriptFile( "{$this->mExtensionPath}/wikia/MobileProducts/js/MobileProducts.js" );
		
		
		if( !$this->mMobileBrowser ) {
			$languages = $this->getLanguagesData();
			
			if ( !empty( $languages ) ) {
				$template = F::build( 'EasyTemplate', array( dirname(__FILE__) . '/templates' ) );
				$template->set_vars( array(
					'wgBlankImgUrl' => $this->mBlankImgUrl,
					'languages' => $languages,
				) );
				
				$this->mOut->addHTML( $template->render( 'languagemenu' ) );
			}
		}
		
		$template = F::build( 'EasyTemplate', array( dirname(__FILE__) . '/templates' ) );
		$template->set_vars( $data );

		$this->mOut->addHTML( $template->render( $templateName ) );
	}
	
	private function getLanguagesData(){
		wfProfileIn( __METHOD__ );
		
		$langLinks = array();
		$items = $this->mApp->runFunction( 'wfStringToArray', $this->mApp->runFunction( 'wfMsg', 'mobileproducts-language-links' ), '*', 5 );
		
		foreach ( $items as $item ) {
			if( !empty( $item ) ) {
				$data = explode( '|', $item );
				
				$langLinks[] = array(
					'language' => $data[0],
					'href' => $data[1]
				);
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $langLinks;
	}
	
	private function getLandingPageData(){
		wfProfileIn(__METHOD__);
		
		$slides = array();
		$items = $this->mApp->runFunction( 'wfStringToArray', $this->mApp->runFunction( 'wfMsg', 'mobileproducts-slides' ), '*', 3 );
		
		foreach ( $items as $item ) {
			if( !empty( $item ) ) {
				list( $img, $titleText ) = explode('|', $item);
				
				$title = F::build( 'Title', array( $img, NS_FILE ), 'newFromText' );
				$titleLink = F::build( 'Title', array( $titleText ), 'newFromText' );
				
				if( $title instanceof Title && $title->exists() ) {
					$file = $this->mApp->runFunction( 'wfFindFile', $title );
					
					if ( is_object( $file ) ) {
						$slides[] = array(
							'img' => $this->mApp->runFunction( 'wfReplaceImageServer', $file->getFullUrl() ),
							'href' => $titleLink->getLinkUrl(),
						);
					}
				}
			}
		}
		
		$boxes = array();
		$items = $this->mApp->runFunction( 'wfStringToArray', $this->mApp->runFunction( 'wfMsg', 'mobileproducts-product-boxes' ), '*', 4 );
		
		foreach ( $items as $item ) {
			if( !empty( $item ) ) {
				list( $headline, $description, $img, $link ) = explode('|', $item);
				
				if ( !Http::isValidURI( $link ) ) {
					$linkTitle = F::build( 'Title', array( $link ), 'newFromText' );
					
					if ( $linkTitle instanceof Title ) {
						$link = $linkTitle->getLinkUrl();
					} else {
						$link = null;
					}
				}
				
				$title = F::build( 'Title', array( $img, NS_FILE ), 'newFromText' );
				
				if( $title instanceof Title && $title->exists() && !empty( $link ) ) {
					$file = $this->mApp->runFunction( 'wfFindFile', $title );
					
					if ( is_object( $file ) ) {
						$boxes[] = array(
							'title' => $headline,
							'description' => $description,
							'img' =>  $this->mApp->runFunction( 'wfReplaceImageServer', $file->getFullUrl() ),
							'href' => $link
						);
					}
				}
			}
		}
		
		$marketApps = array();
		$items = $this->mApp->runFunction( 'wfStringToArray', $this->mApp->runFunction( 'wfMsg', 'mobileproducts-market-apps' ), '*', 2 );
		
		foreach ( $items as $item ) {
			if( !empty( $item ) ) {
				$data = explode('|', $item);
				$app = array( 'title' => $data[0] );
				
				for ( $x = 1; $x < count( $data ); $x++ ) {
					if ( stripos( $data[$x], self::GOOGLE_STORE_PREFIX ) === 0 ) {
						$app['stores'][] = array(
							'img' => 'google_store.png',
							'href' => substr( $data[$x], strlen( self::GOOGLE_STORE_PREFIX ) )
						);
					} elseif ( stripos( $data[$x], self::APPLE_STORE_PREFIX ) === 0 ) {
						$app['stores'][] = array(
							'img' => 'apple_store.png',
							'href' => substr( $data[$x], strlen( self::APPLE_STORE_PREFIX ) )
						);
					}
				}
				
				if ( !empty( $app['stores'] ) ) {
					$marketApps[] = $app;
				}
			}
		}
		
		wfProfileOut( __METHOD__ );
		
		return array(
			'slides' => $slides,
			'boxes' => $boxes,
			'marketApps' => $marketApps
		);
	}
	
	private function getProductData( $product ) {
		wfProfileIn(__METHOD__);
		
		$device = $this->mApp->runFunction( 'wfMsg', "mobileproducts-{$product}-device");
		$slides = array();
		$items = $this->mApp->runFunction( 'wfStringToArray', $this->mApp->runFunction( 'wfMsg', "mobileproducts-{$product}-slides" ), '*', 5 );
		
		foreach ( $items as $item ) {
			if( !empty( $item ) ) {
				$title = F::build( 'Title', array( $item, NS_FILE ), 'newFromText' );
				
				if( $title instanceof Title && $title->exists() ) {
					$file = $this->mApp->runFunction( 'wfFindFile', $title );
					
					if ( is_object( $file ) ) {
						$slides[] = $this->mApp->runFunction( 'wfReplaceImageServer', $file->getFullUrl() );
					}
				}
			}
		}
		
		$marketLinks = array();
		$items = $this->mApp->runFunction( 'wfStringToArray', $this->mApp->runFunction( 'wfMsg', "mobileproducts-{$product}-markets" ), '*', 3 );
		
		foreach ( $items as $item ) {
			if( !empty( $item ) ) {
				$data = explode('|', $item);
				
				if ( stripos( $data[0], self::GOOGLE_STORE_PREFIX ) === 0 ) {
					$market = array(
						'img' => 'google_store.png',
						'href' => substr( $data[0], strlen( self::GOOGLE_STORE_PREFIX ) )
					);
				} elseif ( stripos( $data[0], self::APPLE_STORE_PREFIX ) === 0 ) {
					$market = array(
						'img' => 'apple_store.png',
						'href' => substr( $data[0], strlen( self::APPLE_STORE_PREFIX ) )
					);
				}  elseif ( stripos( $data[0], self::WEB_STORE_PREFIX ) === 0 ) {
					$market = array(
						'img' => 'web_store.png',
						'href' => substr( $data[0], strlen( self::WEB_STORE_PREFIX ) )
					);
				}
				
				if ( !empty( $market ) ) {
					$market['requires'] = $data[1];
					$marketLinks[] = $market;
				}
			}
		}
		
		wfProfileOut( __METHOD__ );
		
		return array(
			'product' => $product,
			'device' => $device,
			'slides' => $slides,
			'stores' => $marketLinks
		);
	}
	
	private function redirectToLandingPage(){
		$specialPageTitle = Title::newFromText( 'MobileProducts', NS_SPECIAL );
		$url = $specialPageTitle->getFullUrl();

		$this->mOut->redirect( $url );
	}
}
