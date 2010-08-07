<?php

class MultiwikifinderSpecialPage extends SpecialPage {
    private $mfp = null;
    var $mName = 'Multiwikifinder';
    var $mRights = 'multiwikifinder';

	function __construct() {
		parent::__construct( $this->mName, $this->mRights );
	}

	function execute($page = null, $limit = "", $offset = "", $show = true) {
		global $wgRequest, $wgUser, $wgOut;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'multiwikifinder' ) ) {
			$this->displayRestrictionError();
			return;
		}

		wfLoadExtensionMessages("Multiwikifinder");

		$page = $wgRequest->getVal('target', $page);
		if (empty($limit) && empty($offset)) { 
            list( $limit, $offset ) = wfCheckLimits();
        }
        $this->mfp = new MultiwikifinderPage($this->mName, $page, $limit, $offset);
        
		if (!empty($show)) {
            $this->setHeaders();
        } else {
            // return data as array - not like <LI> list
            $this->mfp->setShow(false);
        }
        $this->mfp->showForm();
    }
    
    function getResult() { return $this->mpp->getResult(); }
}

class MultiwikifinderPage {
	private $data = array();
	private $mShow = true;
	const ORDER_ROWS = 500;
	var $mPage = null;
	var $mValidPage = false;
	var $mPageTitle = "";
	var $mPageNS = 0;
	var $mTitle = "";

	function __construct($name, $page, $limit = 50, $offset = 0) { 
		$this->mName = $name;

		if ( !empty($page) ) {
			$this->mPage = Title::newFromText($page);
			if ( $this->mPage instanceof Title ) {
				$this->mPageTitle = $this->mPage->getDBkey();
				$this->mPageNS = $this->mPage->getNamespace();
				$this->mValidPage = true;
			} 
		}
		$this->offset = $offset;
		$this->limit =  $limit;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, $this->mName );
	}

	function linkParameters() { 
		$res = array();
		if ( $this->mValidPage ) {
			$res = array('target' => $this->mPage->getFullText());	
		}
		return $res; 
	}
	function setShow( $bool ) { $this->mShow = $bool; }

	function getPageHeader() { 
		wfProfileIn( __METHOD__ );
		
		if (empty($this->mShow)) {
			wfProfileOut( __METHOD__ );
			return "";
		}
		
		$action = $this->mTitle->escapeLocalURL("");
		
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"action"	=> $action,
			"mPage"		=> ( $this->mValidPage ) ? $this->mPage->getFullText() : "",
		));
		
		wfProfileOut( __METHOD__ );
		return $oTmpl->execute("main-finder-form");
	}

	public function getResult() { return $this->data; }

	function showForm() {
		global $wgOut;

        wfProfileIn( __METHOD__ );
		$wgOut->addHTML( $this->getPageHeader() );
		
		if ( $this->mValidPage ) {
			$this->showResults();
		}
        wfProfileOut( __METHOD__ );
	}
	
	function showResults( ) {
		global $wgUser, $wgOut, $wgLang, $wgContLang, $wgMemc, $wgExternalDatawareDB;

        wfProfileIn( __METHOD__ );
		$wgOut->setSyndicated( false );

		$num = 0;
		$key = wfMemcKey( "MultiWikiFinder", $this->mPageTitle, $this->mPageNS, $this->limit, $this->offset );
		$data = $wgMemc->get( $key );
		
		if ( empty($data) || 
			( isset($data) && ( 0 == intval($data['numrec'] ) ) ) 
		) {
			$dbr = wfGetDB( DB_SLAVE, 'blobs', $wgExternalDatawareDB ); 
			$oRes = $dbr->select(
				'pages',
				array( 'page_latest, page_wikia_id, page_id' ),
				array( 
					'page_title_lower'	=> mb_strtolower($this->mPageTitle),
					'page_namespace' 	=> $this->mPageNS,
					'page_status'		=> 0
				),
				__METHOD__, 
				array(
					'ORDER BY' => 'page_latest desc'
				)
			);

			$num = $dbr->numRows($oRes);

			$data = array( 'numrec' => 0, 'rows' => array() );
			$loop = 0;
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				#- get last edit TS or not
				if ( $num <= self::ORDER_ROWS ) {
					$oGTitle = GlobalTitle::newFromText( $this->mPageTitle, $this->mPageNS, $oRow->page_wikia_id );
					$data['rows'][ $oRow->page_wikia_id ] = array( $oRow->page_id, $oGTitle->getFullURL(), $oGTitle->getServer() );
					$data['order'][ $oRow->page_wikia_id ] = $oGTitle->getLastEdit();
				} else {
					$data['rows'][ $oRow->page_wikia_id ] = array( $oRow->page_id, "", "" );
					$data['order'][ $oRow->page_wikia_id ] = $oRow->page_latest;
				}
				$data['numrec']++;
			}
			
			$dbr->freeResult( $oRes );
			$wgMemc->set( $key, $data, 60 * 60 );
		} 

		$num = $this->outputResults( $wgUser->getSkin(), $data );

        wfProfileOut( __METHOD__ );
		return $num;
	}
	
	public function outputResults( $skin, $data ) {
		global $wgContLang, $wgOut;

        wfProfileIn( __METHOD__ );

		$num = 0;		
		$html = array();
		if ( $this->mShow ) {
			$wgOut->addHTML( XML::openElement( 'div', array('class' => 'mw-spcontent') ) );
		}	

		if ( isset($data) && $data['numrec'] > 0 ) {
			$num = $data['numrec'];
			
			if ( $this->mShow ) {
				$html[] = XML::openElement( 'ol', array('start' => $this->offset + 1, 'class' => 'special' ) );
			}

			if ( $data['numrec'] <= self::ORDER_ROWS ) { 
				arsort($data['order']);
			}
			$loop = 0; $skip = 0;
			foreach ( $data['order'] as $city_id => $ordered ) {
				# check loop
				if ( $loop >= $this->offset && $loop < $this->limit + $this->offset ) {
					list ($page_id, $page_url, $page_server) = $data['rows'][$city_id];
					# page url
					if ( empty($page_url) || empty($page_server) ) {
						$oGTitle = GlobalTitle::newFromText( $this->mPageTitle, $this->mPageNS, $city_id );
						if ( is_object($oGTitle) ) {
							$page_url = $oGTitle->getFullURL();
							$page_server = $oGTitle->getServer();
						}

						if ( empty($page_url) || empty($page_server) ) {
							$skip++; continue;
						}
					}
					# check Wiki
					if ( !empty($city_id) ) {
						$oWikia = WikiFactory::getWikiByID($city_id) ;
						if ( empty($oWikia) || empty($oWikia->city_public) ) continue; 
					}
					
					if (empty($this->mShow)) {
						$res = "";
						$this->data[$city_id] = array('city_id' => $city_id, 'page_id' => $page_id, 'url' => $page_url);
					} else {
						$res = wfSpecialList( Xml::openElement( 'a', array('href' => $page_url) ) . $page_url . Xml::closeElement( 'a' ), "" );
					}
					
					$html[] = $this->mShow ? Xml::openElement( 'li' ) . $res . Xml::closeElement( 'li' ) : "";
				}
				$loop++;
			}

			$num = $num - $skip;

			if( $this->mShow ) {
				$html[] = XML::closeElement( 'ol' );
			}

		}

		# Top header and navigation
		if ( $this->mShow ) {
			$wgOut->addHTML( '<p>' . wfMsgExt('multiwikirecords', array(), $num) . '</p>' );
			if( $num > 0 ) {
				$wgOut->addHTML( '<p>' . wfShowingResults( $this->offset, $num ) . '</p>' );
				# Disable the "next" link when we reach the end
				$paging = wfViewPrevNext( 
					$this->offset, 
					$this->limit, 
					$wgContLang->specialPage( $this->mName ), 
					wfArrayToCGI( $this->linkParameters() ), 
					( $num < $this->limit ) 
				);
				$wgOut->addHTML( '<p>' . $paging . '</p>' );
			} else {
				$wgOut->addHTML( XML::closeElement( 'div' ) );
				return;
			}
		}

		$html = $this->mShow ? implode( '', $html ) : $wgContLang->listToText( $html );
		$wgOut->addHTML( $html );
		
		# Repeat the paging links at the bottom
		if( $this->mShow ) {
			$wgOut->addHTML( '<p>' . $paging . '</p>' );
		}

		$wgOut->addHTML( XML::closeElement( 'div' ) );
		
        wfProfileOut( __METHOD__ );
		return $num;
	}
}
