<?php
/**
 * class CensusEnabledPagesUpdate
 * Updates Census data on Pages with specified enable update category tag
 * 
 * @author Lucas TOR Garczewski <tor@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @since Nov 2012 | MediaWiki 1.19
 */

class CensusEnabledPagesUpdate {

        /**
	 * updatePages
	 * updates infoboxes on all census enabled pages
	 */
        public function updatePages() {
                wfProfileIn(__METHOD__);
                //get all pages from category
		$aReturn = ApiService::call(
			array(
				'action' => 'query',
				'list' => 'categorymembers',//pages with category
				'cmtitle' => CensusDataRetrieval::getFlagCategoryTitle()->getPrefixedDBkey(),//category name
				'cmnamespace' => '0'
			)
		);
		
		//perform update foreach page from category
                foreach ( $aReturn['query']['categorymembers'] as $cm) {
			
                        $oTitle = Title::newFromText( $cm['title'] );
                        $oArticle = new Article($oTitle);
			
                        $newText = $this->getUpdatedContent( $oArticle->getContent(), $oTitle );
			
			//save updated content
                        $oArticle->doEdit( $newText, 'Updating infobox with data from Sony DB', EDIT_UPDATE );
			
                }
		
                wfProfileOut(__METHOD__);
        }
        
	/**
	 * getUpdatedContent
	 * Retrieves new infobox code and replaces it in provided article text
	 *
	 * @param String $currentText Current article text
	 * @param Title $oTitle Title of page being edited
	 *
	 * @return String $newText Content with replaced infobox template
	 */
	private function getUpdatedContent( $currentText, Title $oTitle ) {
		wfProfileIn(__METHOD__);

		$templateCode = null;
		$type = null;
		$templateParams = null;
		$templateParamsArr = array();
		//cut pieces requred for update
		$templateMatches = $this->matchTemplate( $currentText );
		//set current template code
		if ( isset($templateMatches[0]) ) {
			$templateCode = $templateMatches[0];
		}
		//set type of infobox
		if ( isset($templateMatches[1]) ) {
			$type = $templateMatches[1];
		}
		//set string of template params without line breaks
		if ( isset($templateMatches[2]) ) {
			$templateParams = str_replace("\n",' ',$templateMatches[2]);
			//parse params to assoc array compatibile to CensusDataRetrieval::data
			$templateParamsArr = $this->parseTemplateFields( $templateParams );
		}
		
		//get data from Census
		$oCensusRetrieval = new CensusDataRetrieval( $oTitle );
		if ( !$oCensusRetrieval->fetchData() ) {
			// no data in Census or something went wrong, quit
			wfProfileOut(__METHOD__);
			return null;
		}
		
		//if retrieved infobox type is inconsistent with the current infobox quit
		if ( $type && $type != $oCensusRetrieval->getType() ) {
			wfProfileOut(__METHOD__);
			return null;
		}
		
		//combine results and override old ones
		if ( $templateParamsArr ) {
			$newTemplateParamsArr = array_merge( $templateParamsArr, $oCensusRetrieval->getData() );
			$oCensusRetrieval->setData( $newTemplateParamsArr );
		}
		
		//get new template code
		$newTemplateCode = $oCensusRetrieval->getInfoboxCode();
		
		//replace template
		if ( $templateCode ) {
			$newText = str_replace($templateCode, $newTemplateCode, $currentText);
		} else {//or add if doesn't exists
			$newText = $newTemplateCode.$currentText;
		}
		
		wfProfileOut(__METHOD__);
		return $newText;
	}
        
        /**
	 * matchTemplate
         * Retrieves matches reqiured to perse infobox template
         * 
         * @param String $wikiText Article content
l         * 
         * @return Array $matches
	 * Matches should look like:
	 * $matches[0] Infobox template i.e. {{type infobox |param ... }}
	 * $matches[1] Infobox type i.e. vehicle
	 * $matches[2] Infobox params i.e. |param1 = val1 |param2 = val2
	 */
        private function matchTemplate( $wikiText ) {
		$regex = '/{{([a-zA-Z]*) infobox([^}}]*)}}/sm';
		preg_match( $regex, $wikiText, $matches );
		return $matches;
	}
	
        /**
	 * parseTemplateFields
         * Retrieves template parameters and creates array of values
         * 
         * @param String $paramsCode Template parameters cutted from template code
         * 
         * @return Array $paramsAssocArr Associative array compatibile with CensusDataRetrieval::data array
	 */
        private function parseTemplateFields( $paramsCode ) {
		
		//get params in seperate array
		$paramsArr = explode ('|', $paramsCode);
		
		$paramsAssocArr = array();
		//fill assoc array: param_name => param_value
		$size = sizeof( $paramsArr );
		for ( $i = 1; $i < $size; $i++ ) {
			$paramArr = array_map( 'trim', explode('=', $paramsArr[$i]) );
			if ( isset( $paramArr[0] ) && isset( $paramArr[1] ) ) {
				$paramsAssocArr[$paramArr[0]] = $paramArr[1];
			}
		}
		
                return $paramsAssocArr;
        }
        
        
}
