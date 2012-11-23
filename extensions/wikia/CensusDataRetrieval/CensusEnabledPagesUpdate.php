<?php
                print "Hi updatePages in\n";
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
         * 
	 */
        public static function updatePages(  ) {
                wfProfileIn(__METHOD__);
                
                $cepu = new self();
                $cepu->execute(  );
                
                wfProfileOut(__METHOD__);
		return true;
        }
        
        /**
	 * main method, handles flow and sequence, decides when to give up
	 */
        public function execute(  ) {
                wfProfileIn(__METHOD__);
                //get all pages from cat
		$aReturn = ApiService::call(
			array(
				'action' => 'query',
				'list' => 'categorymembers',//pages with category
				'cmtitle' => CensusDataRetrieval::getFlagCategoryTitle()->getPrefixedDBkey(),//category name
				'cmlimit' => '1',
				'cmnamespace' => '0'
			)
		);
		//foreach page
                foreach ( $aReturn['query']['categorymembers'] as $cm) {
                        $oTitle = Title::newFromText( $cm['title'] );
                        $oArticle = new Article($oTitle);
                        $newText = $this->getUpdatedContent( $oArticle->getContent(), $oTitle->getText() );
//                        $oArticle->doEdit( $newText, 'Updating infobox with data from Sony DB', EDIT_UPDATE );
                        break;
                }
                //pull census data
                //get infobox tpl code
                //override infobox
                wfProfileOut(__METHOD__);
        }
        
        /**
	 * getUpdatedContent
         * Retrieves new infobox code and replaces in provided article text
         * 
         * @param String $currentText Current article text
         * @param String $title Title of page being edited
         * 
         * @return String Description
	 */
        private function getUpdatedContent( $currentText, $title ) {
                $newText = '';
                //run retrieval from Census
                return $newText;
        }
        
        
}
