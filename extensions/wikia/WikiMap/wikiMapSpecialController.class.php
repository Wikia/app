<?php
class wikiMapSpecialController extends WikiaSpecialPageController {

    public function __construct() {
        parent::__construct( 'wikiMap', '', false );
    }

    public function init() {
        $this->businessLogic = F::build( 'wikiMap', array( 'currentTitle' => $this->app->wg->Title ) );

    }

    public function index() {
        $this->response->addAsset('extensions/wikia/WikiMap/js/d3.v2.min.js');
        $this->response->addAsset('extensions/wikia/WikiMap/js/jquery.xcolor.min.js');



        $parameter = $this->getPar();
        $parameterNoSpaces = str_replace('_', ' ',$parameter);
       // var_dump($this->getPar());

        $wikiId = $this->getVal( 'wikiId', $this->wg->CityId );
        $this->wg->Out->setPageTitle( $this->wf->msg('wikiMap-specialpage-title'));
        // setting response data
        if (is_null($parameter)){
            $this->setVal( 'header', $this->wf->msg('wikiMap-title-nonparam'));
        }
        else {
            $this->setVal( 'header', $this->wf->msg('wikiMap-category') . $parameterNoSpaces );
        }
        $this->setVal( 'res', $this->businessLogic->getArticles($parameter));
        $this->setVal( 'colourArray', $this->businessLogic->getColours());

    }
}