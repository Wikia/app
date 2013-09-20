<?php
class WikiMapSpecialController extends WikiaSpecialPageController {

    public function __construct() {
        parent::__construct( 'WikiMap', '', false , false, "default", true/*$includable*/);
    }

    public function init() {
        $this->businessLogic = new WikiMapModel( $this->app->wg->Title );

    }

    public function index() {
        $this->response->addAsset('extensions/wikia/hacks/WikiMap/js/d3.v2.js');
        $this->response->addAsset('extensions/wikia/hacks/WikiMap/js/jquery.xcolor.js');
        $this->response->addAsset('extensions/wikia/hacks/WikiMap/js/WikiMapIndexContent.js');

       // $this->response->addAsset('wiki_map_js');

        $parameter = $this->getPar();
        $parameterSpaces = str_replace('_', ' ', $parameter);

        $this->wg->Out->setPageTitle( wfMsg('wikiMap-specialpage-title'));
        // setting response data

        $resultNodes = $this->businessLogic->getArticles($parameter);

        if (is_null($parameter)){
            $this->setVal( 'header', wfMsg('wikiMap-title-nonparam'));
            $this->setVal( 'artCount', null);
        }
        else {
            $this->setVal( 'artCount', wfMsg('wikiMap-articleCount', $resultNodes['length'], $resultNodes['all']));

            $artPath = $this->app->wg->get('wgArticlePath');
            $path = str_replace('$1', 'Category:', $artPath);
            $path.= $parameter;

            $output = '<a href="' . $path . '">' . wfMsg('wikiMap-category') . $parameterSpaces . '</a>';
            $this->setVal( 'header', $output);

        }

        $this->setVal( 'categoriesHeader', wfMsg('wikiMap-categoriesHeader'));
        $this->setVal( 'animation', wfMsg('wikiMap-animation'));

        $this->setVal( 'namespace', $this->businessLogic->getActualNamespace());
        $this->setVal( 'res', $resultNodes);
        $this->setVal( 'colourArray', $this->businessLogic->getColours());
        $this->setVal( 'categories', $this->businessLogic->getListOfCategories());

    }
}