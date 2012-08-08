<?php
class VisualStatsSpecialController extends WikiaSpecialPageController {

    public function __construct() {
        parent::__construct( 'VisualStats', '', false , false, "default", true/*$includable*/);
    }

    public function init() {
        $this->businessLogic = F::build( 'VisualStats', array( 'currentTitle' => $this->app->wg->Title ) );

    }

    public function index() {
        $this->response->addAsset('extensions/wikia/VisualStats/js/VisualStatsCommitActivity.js');
        $this->response->addAsset('extensions/wikia/VisualStats/js/VisualStatsPunchcard.js');
        $this->response->addAsset('extensions/wikia/VisualStats/js/VisualStatsCommon.js');
        $this->response->addAsset('extensions/wikia/VisualStats/js/d3.v2.js');
        $this->response->addAsset('extensions/wikia/VisualStats/css/VisualStats_style.css');

        $parameter = $this->getPar();
        if ($parameter == null){
            $parameter = "commit";
        }
        /*parameter - first parameter after '/'
        * username - parameter passed via GET (after '?')
        */

        $username=$this->getVal('user');
        if ((is_null($username)) || ($username=='')){
            $username = "0";
        }

        $this->setVal( 'urlCommit', $this->getTitleFor( 'VisualStats', 'commit')->getLocalURL("user=" . $username));
        $this->setVal( 'urlPunchcard', $this->getTitleFor( 'VisualStats', 'punchcard')->getLocalURL("user=" . $username));
        $this->setVal( 'urlHistogram', $this->getTitleFor( 'VisualStats', 'histogram')->getLocalURL("user=" . $username));

        $this->setVal( 'color', $this->businessLogic->getColorForPunchcard());
        $this->setVal( 'link', $this->businessLogic->getColorForLabels());

        switch($parameter){
            case "commit":
                $this->setVal( 'data', $this->businessLogic->getDataForCommitActivity($username));
                break;
            case "punchcard":
                $this->setVal( 'data', $this->businessLogic->getDataForPunchcard($username));
                break;
            case "histogram":
                //$this->setVal( 'data', $this->businessLogic->getDataForHistogram($username));
                break;
            default:
                $this->setVal( 'data', $this->businessLogic->getDataForCommitActivity($username));
                $parameter = "commit";
                break;
        }

        $this->wg->Out->setPageTitle( $this->wf->msg('visualStats-specialpage-title'));

        $this->setVal( 'user', $username);
        $this->setVal( 'param', $parameter);
        $this->setVal( 'dates', $this->businessLogic->getDatesFromTwoWeeksOn(false));
        $this->setVal( 'wikiButtonLabel', $this->wf->msg('visualStats-wikiEdits'));
        $this->setVal( 'userButtonLabel', $this->wf->msg('visualStats-userEdits', $username));

    }
}