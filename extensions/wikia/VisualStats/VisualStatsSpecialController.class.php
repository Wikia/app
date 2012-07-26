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

        $parameter = $this->getPar();
        if ($parameter == null){
            $parameter = "commit";
        }
        $this->wg->Out->setPageTitle( $this->wf->msg('visualStats-specialpage-title'));

        $this->setVal( 'param', $parameter);
       // $this->setVal( 'namespace', $this->businessLogic->getActualNamespace());




    }
}