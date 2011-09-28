<?php
/**
 * 
 */
class SpecialSpamWikisSpecialPageController extends WikiaSpecialPageController {

    public function __construct() {
        parent::__construct( 'SpamWikis', '', false );
    }
    
    public function index() {
        if ( !$this->wg->User->isAllowed( 'specialspamwikis' ) ) {
            $this->displayRestrictionError();
            return false;
        }
        $this->wg->Out->setPageTitle( wfMsg( 'specialspamwikis-pagetitle' ) );
        $this->mTitle = Title::makeTitle( NS_SPECIAL, $this->mName );
        $this->mData = new StdClass;
        $link = new Linker();
        if ( F::app()->wg->request->wasPosted() ) {
            $this->mData->close = array();
            $data = $this->request->getVal( 'close' );
            if ( !empty( $data ) ) {
                $tmpDb = F::app()->wf->getDb( DB_MASTER, array(), 'stats' );
                foreach ( $data as $k => $v ) {
                    $city = WikiFactory::getWikiByID( $k );
                    $status = WikiFactory::setPublicStatus( -2, $k, 'SpecialSpamWikis' );
                    
                    $this->mData->close[] = array(
                        'city' =>  $link->makeExternalLink( $city->city_url, $city->city_title ),
                        'status' => ( -2 == $status )
                    );
                    
                    $tmpDb->delete(
                         'noreptemp.spamwikis',
                         array( 'city_id' => $k ),
                         __METHOD__
                    );
                }
                unset( $tmpDb );
            }
            
            $this->response->getView()->setTemplate( 'SpecialSpamWikisSpecialPageController', 'close' );
        }
        $extPath = F::app()->wg->extensionsPath;
        F::app()->wg->out->addScript( "<script src=\"{$extPath}/wikia/SpecialSpamWikis/js/jquery.dataTables.min.js\"></script>" );
        F::app()->wg->out->addStyle( AssetsManager::getInstance()->getSassCommonURL( "{$extPath}/wikia/SpecialSpamWikis/css/table.scss" ) );
        $this->mAction = $this->mTitle->escapeLocalURL( '' );
        $this->mData->defCriteria = array();
        $data = new SpecialSpamWikisData();
        $this->mData->criteria = $data->getCriteria();
    }
}