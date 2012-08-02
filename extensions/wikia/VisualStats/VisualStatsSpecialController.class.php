<?php
class VisualStatsSpecialController extends WikiaSpecialPageController {

    public function __construct() {
        parent::__construct( 'VisualStats', '', false , false, "default", true/*$includable*/);
    }

    public function init() {
        $this->businessLogic = F::build( 'VisualStats', array( 'currentTitle' => $this->app->wg->Title ) );

    }

    public function index() {
        $this->response->addAsset('extensions/wikia/VisualStats/js/VisualStatsIndexContent.js');
        $this->response->addAsset('extensions/wikia/VisualStats/js/d3.v2.js');

        /*parameter - first parameter after '/'
        * username - parameter passed via GET (after '?')
        */
        $parameter = $this->getPar();
        if ($parameter == null){
            $parameter = "commit";
        }
        $username=$this->getVal('user');
        if ((is_null($username)) || ($username=='')){
            $username = "0";
        }



        $this->wg->Out->setPageTitle( $this->wf->msg('visualStats-specialpage-title'));

        $this->setVal( 'user', $username);
        $this->setVal( 'param', $parameter);
        $this->setVal( 'data', $this->businessLogic->performQuery($username));
        $this->setVal( 'dates', $this->businessLogic->getDatesFromTwoWeeksOn());

    }
}