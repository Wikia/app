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
        $this->mTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
        $this->mAction = htmlspecialchars($this->mTitle->getLocalURL());

        // placeholder for the actual data
        $this->mData = new StdClass;

        // required for HTML links
        $link = new Linker();

        // the code below implements the behaviour of the stats subpage
        // TODO: find a better method to check for subpages
        if ( "{$this->mTitle->getPrefixedText()}/stats" == $this->wg->request->getVal('title') ) {
            // fetch the data
            $data = new SpecialSpamWikisData();
            $this->mData->stats = $data->getStats();

            // render the output
            $this->response->getView()->setTemplate( 'SpecialSpamWikisSpecialPageController', 'stats' );
            return null;
        }

        // the code below implements the behaviour after form submission
        if ( F::app()->wg->request->wasPosted() ) {

            // which wikis to close?
            $this->mData->close = array();
            $this->mData->summary = array();
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

                    // update the summary
                    if ( -2 == $status ) {
                        if ( !isset( $this->mData->summary[$city->city_founding_user] ) ) {
                            $this->mData->summary[$city->city_founding_user] = 1;
                        } else {
                            $this->mData->summary[$city->city_founding_user]++;
                        }
                    }
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

            // calculate and pre-format data for StaffLog entry
            $summary = array(
               'sum' => array_sum( $this->mData->summary ),
               'count' => count( $this->mData->summary ),
               'avg' => 0
            );

            if ( 0 != $summary['count' ] ) {
                $summary['avg'] = sprintf( '%1.2f', $summary['sum'] / $summary['count' ] );
            }

            // pass the calculated summary to the output (yes, overwrite the previous value)
            $this->mData->summary = $summary;

            // make a StaffLog entry
            StaffLogger::log(
                    'spamwiki',
                    'mark',
                    $this->wg->User->getID(),
                    $this->wg->User->getName(),
                    0,
                    '',
                    wfMsgExt( 'specialspamwikis-stafflog-summary', array('parsemag'), $summary['sum'], $summary['count'], $summary['avg'] )
            );

            // render the output
            $this->response->getView()->setTemplate( 'SpecialSpamWikisSpecialPageController', 'close' );
            return null;
        }

        // the code below handles the default behaviour: displays the form
		$this->response->addAsset('resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js');
		$this->response->addAsset( 'extensions/wikia/SpecialSpamWikis/css/table.scss');
        $data = new SpecialSpamWikisData();
        $this->mData->criteria = $data->getCriteria();
    }
}
