<?php
class GamingMapsController extends WikiaController {

    public function __construct() {
        parent::__construct( 'GamingMaps', '', false );
    }

    public function init() {
        /*$this->businessLogic = F::build( 'GamingMaps', array( 'currentTitle' => $this->app->wg->Title ) );*/
    }

    public function index() {
/*
        $widthMap = $this->getVal('width',400);
        $this->setVal( 'width', $widthMap );*/

        $height = null;
        $this->setVal( 'width', $this->getVal('width',660) ); // ----------- default
        $this->setVal( 'height', $this->getVal('height',550) );

        $attr = $this->getVal('attr');

        $img = $attr['img'];  //get name of img from atributes gaminmgap

        if(empty($img)){  //if nema of img not exists
            $this->setVal( 'warning', $this->wf->msg('gamingmaps-warning-file-noexist'));
        }else{
            $imgFile = $this->wf->findFile($img);
            if($imgFile->exists()){
                //$height = $this->setHeightDiv($imgFile->width, $imgFile->height); //set div height
            }else{
                $this->setVal( 'warning', $this->wf->msg('gamingmaps-warning-file-unfound'));
            }
        }

        //$this->setVal( 'height', ceil($height));

        // x y z nameIMG version

      /*  $this->wg->Out->setPageTitle( $this->wf->msg('interni-specialpage-title') );

        $wikiId = $this->getVal( 'wikiId', $this->wg->CityId );
        // setting response data

        $this->setVal( 'header', $this->wf->msg('drugaSpecjalna-hello-msg') );
        $this->setVal( 'name', $this->wf->msg('name-msg') );
        $this->setVal( 'surname', $this->wf->msg('surname-msg') );
        $this->setVal( 'from', $this->wf->msg('from-msg') );
        $this->setVal( 'interniTab', $this->businessLogic->getInterns() );
        $this->setVal( 'wikiData', $this->businessLogic->getWikiData( $wikiId ) );
*/
    }

    public function getTile(){
        $position_X = $this->getVal('x');
        $position_Y = $this->getVal('y');
        $zoom = $this->getVal('z');
        $name = $this->getVal('imgName');
        $ver_img = $this->getVal('version');
        $width = 256;

        $imgFile = $this->wf->findFile($name);

        $heightIMG = $imgFile->height;
        $widthIMG = $imgFile->width;

        $titlesize = null;
        if($heightIMG > $widthIMG)
        {
            $titlesize = $heightIMG;
        }else{
            $titlesize = $widthIMG;
        }

        $titlesize = ($titlesize/pow(2,$zoom));

        $left = ($position_X)*$titlesize;
        $right = $left + $titlesize;
        $top =  ($position_Y)*$titlesize;
        $bottom = $top + $titlesize;

        $urlIMG = wfReplaceImageServer(
            $imgFile->getThumbUrl( "{$width}px-{$left},{$right},{$top},{$bottom}-" . $imgFile->getName() )
        );
        $this->setVal('url',$urlIMG);
    }

    /*
    public function setHeightDiv($widthIMG, $heightIMG){
        $width = 660;
        $scal = $width/$widthIMG;
        return $heightIMG*$scal;
    }
*/

/*
    public function createThumb( $width, $height = -1 ) {
        $params = array( 'width' => $width );
        if ( $height != -1 ) {
                $params['height'] = $height;
        }
        $thumb = $this->transform( $params );
        if ( is_null( $thumb ) || $thumb->isError() ) {
                return '';
        }
        return $thumb->getUrl();
    }*/

    /*
     *
     *
     *
     * */
}