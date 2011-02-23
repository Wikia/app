<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	require_once ( 'ApiFormatBase.php' );
}

/**
 * @ingroup API
 * @author Inez Korczyñski
 */
class ApiFormatPUSH extends ApiFormatBase {

	public function __construct( $main, $format ) {
		parent :: __construct( $main, $format );
	}

	public function getMimeType() {
		return 'text/xml';
	}
	
	private function getFeedId() {
		return 'tag:wikia.com,2011-01-01:/feed';	
	}
	
	private function getEntryId() {
		return 'tag:wikia.com,2011-01-01:/feed/entry/'.rand(0,9000);
	}
	
	public function getNeedsRawData() {
		return true;
	}

	public function execute() {

		$result = $this->getResultData();
		
		if(isset($result['query']) && isset($result['query']['recentchanges'])) {
			$data = $result['query']['recentchanges'];
		} else {
			$data = array();
		}
		
		$this->printText('<?xml version="1.0" encoding="utf-8"?>');
		
		if(count($data) > 0) {
			
			// <feed..
			$this->printText(Xml::openElement('feed', array('xmlns' => 'http://www.w3.org/2005/Atom')));
			
			$source = '';
			
			foreach($data as $dataItem) {
				if(!is_array($dataItem)) {
					continue;
				}				

				if($source == '') {
					// feed id
					$this->printText(Xml::element('id', null, $this->getFeedId()));
					
					// feed title
					global $wgSitename;
					$this->printText(Xml::element('title', null, $wgSitename . ' - ' . wfMsg('recentchanges')));
					
					// feed updated
					$this->printText(Xml::element('updated', null, $dataItem['timestamp']));
					
					// feed link
					$this->printText(Xml::element('link', array('rel' => 'self', 'href' => $_SERVER['SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING'])));
					
					// source
					$source = Xml::openElement('source');
					
					// source title
					$source .= Xml::element('title', null, $wgSitename . ' - ' . wfMsg('recentchanges'));

					// id
					$source .= Xml::element('id', null, $this->getFeedId());
					
					// updated
					$source .= Xml::element('updated', null, $dataItem['timestamp']);

					// source link
					$source .= Xml::element('link', array('rel' => 'self', 'href' => $_SERVER['SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING']));
					
					// source subtitle
					$source .= Xml::element('subtitle', null, 'Track the most recent changes to the wiki in this feed.');
					
					// source generator
					$source .= Xml::element('generator', null, 'MediaWiki');

					$source .= Xml::closeElement('source');					
				}

				// <entry..
				$this->printText(Xml::openElement('entry'));

				// entry author
				$this->printText(Xml::openElement('author'));
				$this->printText(Xml::element('name', null, $dataItem['user']));
				$this->printText(Xml::closeElement('author'));
				
				// entry title
				$this->printText(Xml::element('title', null, 'title'));
				
				// entry id
				$this->printText(Xml::element('id', null, $this->getEntryId()));
				
				// entry updated
				$this->printText(Xml::element('updated', null, $dataItem['timestamp']));

				$title = Title::newFromText($dataItem['title']);
				
				// entry link alternate
				$this->printText(Xml::element('link', array('rel' => 'alternate', 'href' => $title->getFullUrl("oldid=".$dataItem['revid']))));

				// rc
				unset($dataItem['rc_params']);
				unset($dataItem['tags']);
				$this->printText(ApiFormatXml::recXmlPrint('rc', $dataItem, null, false));

				// entry source
				$this->printText($source);

				// </entry>
				$this->printText(Xml::closeElement('entry'));
			}

			// </feed>
			$this->printText(Xml::closeElement('feed'));
		}		
			
			
			
			
				/*
				

			}
			

			
		}

			*/			

	}

	public function getDescription() {
		return 'Output data in PUSH format' . parent :: getDescription();
	}

	public function getVersion() {
		return __CLASS__;
	}
}