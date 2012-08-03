<?php
class WikiMapSpecialController extends WikiaSpecialPageController {

    public function __construct() {
        parent::__construct( 'WikiMap', '', false , false, "default", true/*$includable*/);
    }

    public function init() {
        $this->businessLogic = F::build( 'WikiMapModel', array( 'currentTitle' => $this->app->wg->Title ) );

    }

    public function index() {
        $this->response->addAsset('extensions/wikia/WikiMap/js/d3.v2.js');
        $this->response->addAsset('extensions/wikia/WikiMap/js/jquery.xcolor.js');
        $this->response->addAsset('extensions/wikia/WikiMap/js/WikiMapIndexContent.js');

       // $this->response->addAsset('wiki_map_js');

        $parameter = $this->getPar();
        $parameterSpaces = str_replace('_', ' ', $parameter);

        $this->wg->Out->setPageTitle( $this->wf->msg('wikiMap-specialpage-title'));
        // setting response data

        $resultNodes = $this->businessLogic->getArticles($parameter);

        if (is_null($parameter)){
            $this->setVal( 'header', $this->wf->msg('wikiMap-title-nonparam'));
            $this->setVal( 'artCount', null);
        }
        else {
            $this->setVal( 'artCount', $this->wf->msg('wikiMap-articleCount', $resultNodes['length'], $resultNodes['all']));

            $artPath = $this->app->wg->get('wgArticlePath');
            $path = str_replace('$1', 'Category:', $artPath);
            $path.= $parameter;

            $output = '<a href="' . $path . '">' . $this->wf->msg('wikiMap-category') . $parameterSpaces . '</a>';
            $this->setVal( 'header', $output);

        }

        $this->setVal( 'categoriesHeader', $this->wf->msg('wikiMap-categoriesHeader'));
        $this->setVal( 'animation', $this->wf->msg('wikiMap-animation'));

        $this->setVal( 'namespace', $this->businessLogic->getActualNamespace());
        $this->setVal( 'res', $resultNodes);
        $this->setVal( 'colourArray', $this->businessLogic->getColours());
        $this->setVal( 'categories', $this->businessLogic->getListOfCategories());

    }
}