<?php
/**
 * class CensusEnabledPagesUpdate
 * Updates Census data on Pages with specified enable update category tag
 * 
 * @author Lucas TOR Garczewski <tor@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
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
                //foreach page
                //pull census data
                //get infobox tpl code
                //override infobox
                wfProfileOut(__METHOD__);
        }
        
        
}
