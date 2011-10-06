<?php
/**
 * Michał Roszka (Mix) <michal@wikia-inc.com>
 * 
 * The Special:SpamWikis staff tool.
 * 
 * Controller handling the general behaviour of the special page.
 */
class SpecialSpamWikisSpecialPageController extends WikiaSpecialPageController {
    /**
     * The constructor
     */
    public function __construct() {
        parent::__construct( 'SpamWikis', '', false );
    }
    
    /**
     * The main method handling the Special:SpamWikis behaviour.
     */
    public function index() {
        // access control
        if ( !$this->wg->User->isAllowed( 'specialspamwikis' ) ) {
            $this->displayRestrictionError();
            return false;
        }
        // init some basic data
        $this->wg->Out->setPageTitle( wfMsg( 'specialspamwikis-pagetitle' ) );
        $this->mTitle = Title::makeTitle( NS_SPECIAL, $this->mName );
        
        // placeholder for the actual data
        $this->mData = new StdClass;
        
        // required for HTML links
        $link = new Linker();
        
        // the code below implements the behaviour after form submission
        if ( F::app()->wg->request->wasPosted() ) {
            
            // which wikis to close?
            $this->mData->close = array();
            $data = $this->request->getVal( 'close' );
            
            if ( !empty( $data ) ) {
                // DB handle
                $tmpDb = F::app()->wf->getDb( DB_MASTER, array(), 'stats' );
                
                foreach ( $data as $k => $v ) {
                    // get some info about the wiki
                    $city = WikiFactory::getWikiByID( $k );
                    // set the public status to "spam"
                    $status = WikiFactory::setPublicStatus( -2, $k, 'SpecialSpamWikis' );
                    // clear the cached settings for the wiki
                    WikiFactory::clearCache( $k );
                    
                    // prepare the output data
                    $this->mData->close[] = array(
                        'city' =>  $link->makeExternalLink( $city->city_url, $city->city_title ),
                        'status' => ( -2 == $status )
                    );
                    
                    // remove from the noreptemp.spamwikis
                    $tmpDb->delete(
                         'noreptemp.spamwikis',
                         array( 'city_id' => $k ),
                         __METHOD__
                    );
                }
                // clear the interwiki links for ALL languages in memcached.
                WikiFactory::clearInterwikiCache();
                
                unset( $tmpDb );
            }
            
            // render the output
            $this->response->getView()->setTemplate( 'SpecialSpamWikisSpecialPageController', 'close' );
        }
        
        // the code below handles the default behaviour: displays the form
        $extPath = F::app()->wg->extensionsPath;
        F::app()->wg->out->addScript( "<script src=\"{$extPath}/wikia/SpecialSpamWikis/js/jquery.dataTables.min.js\"></script>" );
        F::app()->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "{$extPath}/wikia/SpecialSpamWikis/css/table.scss" ) );
        $this->mAction = $this->mTitle->escapeLocalURL( '' );
        $data = new SpecialSpamWikisData();
        $this->mData->criteria = $data->getCriteria();
    }
}