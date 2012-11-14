<?php
/**
 * class CensusArticleSave
 * Contains methods to be performed on EditPage::attemptSave
 * 
 * @author Lucas TOR Garczewski <tor@wikia-inc.com>
 * @author Kamil Koterba <kamil@wikia-inc.com>
 */

class CensusArticleSave {

        const HOVER_INFOBOX_TEMPLATE_NAME = 'infobox';
        
        /**
	 * replaceLinks
         * EditPage::attemptSave hook function
         * replaces links to Census pages with template
	 */
        public static function replaceLinks( $editpage ) {
                $cas = new self();

		$cas->execute( $editpage->textbox1 );

		return true;
        }
        
        /**
	 * main method, handles flow and sequence, decides when to give up
	 */
        public function execute( &$wikitextArticle ) {
                //regular expression to fit all links
                //everything between '[[' and ']]' not containing any additive '[[' inside
                $regex = "/\[\[([^\[][^\[]*?)\]\]/si";
                //get all links
                //$matches[0] will contain sitrings with brackets [[ ]] 
                //and $matches[1] will contain only stings without brackets
                preg_match_all( $regex, $wikitextArticle, $matches );
                //for each match
                foreach ($matches[1] as $key => $match) {
                        $lnkContents = explode('|',$match);
                        //check if is census page
                        if ( $this->isInfoboxPage($lnkContents[0]) ) {
                                //replace string
                                $this->performReplacement($wikitextArticle, $matches[0][$key], $lnkContents );
                        }
                }
        }
        
        
        /**
	 * isInfoboxPage
         * Chcecks whether provided string is name of page containing infobox
         * 
         * @param $pageName String
	 */
        public function isInfoboxPage( $pageName ) {
                $title = Title::newFromText( $pageName );
                $parentCategories = $title->getParentCategories();
                $catTitle = Title::newFromText( wfMsgForContent( CensusDataRetrieval::FLAG_CATEGORY ), NS_CATEGORY );
                $category = $catTitle->getPrefixedDBkey();
                if ( isset( $parentCategories[$category] ) && $parentCategories[$category] ==  $title->getText() ) {
                        return true;
                }
                return false;
        }
        
        /**
	 * performReplacement
         * replaces link code with template code
         * 
         * @param &$wikitextArticle String Wikitest to replace
         * @param $replacePatt String code of link to be replaced
         * @param $lnkContents Array [0] link url [1] link display name
	 */
        public function performReplacement( &$wikitextArticle, $replacePatt, $lnkContents ) {
                $templ = $this->prepareTemplCode( $lnkContents );
                $wikitextArticle = str_replace($replacePatt, $templ, $wikitextArticle);
        }
        
        /**
	 * prepareTemplCode
         * 
         * @param $lnkContents Array [0] link url [1] link display name
         * @return $templ String wikitext to call hover infobox template
	 */
        public function prepareTemplCode( $lnkContents ) {
                
                $templ = '{{' . self::HOVER_INFOBOX_TEMPLATE_NAME;
                $templ .= '|'. $lnkContents[0];
                if ( isset($lnkContents[1]) ) {
                        $templ .= '|'. $lnkContents[1];
                }
		$templ .= "}}";
		return $templ;
        }
        
}
