<?php
class GamingMapsController extends WikiaController {

    public function __construct() {
        parent::__construct( 'GamingMaps', '', false );
    }

    public function init() {
        /*$this->businessLogic = new GamingMaps( 'currentTitle' => $this->app->wg->Title );*/
    }

    public function index() {
/*      $widthMap = $this->getVal('width',400);
        $this->setVal( 'width', $widthMap );*/

        $height = null;
        $this->setVal( 'width', $this->getVal('width',660) ); // ----------- default
        $this->setVal( 'height', $this->getVal('height',550) );

        $attr = $this->getVal('attr');

        $img = $attr['img'];  //get name of img from atributes gaminmgap

        if(empty($img)){  //if nema of img not exists
            $this->setVal( 'warning', wfMsg('gamingmaps-warning-file-noexist'));
        }else{
            $imgFile = wffindFile($img);
            if($imgFile->exists()){
                //$height = $this->setHeightDiv($imgFile->width, $imgFile->height); //set div height
            }else{
                $this->setVal( 'warning', wfMsg('gamingmaps-warning-file-unfound'));
            }
        }
    }

    public function getForMap(){

        $pageName = $this->request->getVal('title');
        $oTitle = Title::newFromText($pageName);

        if (empty($oTitle) || !$oTitle->exists()) {
            return array();
        }

        $pageId = $oTitle->getArticleId();

        // TODO: getImages() are not cached
        $imageServing = new ImageServing( array( $pageId ), 100, array( 'w' => 1, 'h' => 1 ) );
        $images = $imageServing->getImages(1);
        if ( !empty( $images[$pageId][0]['url'] ) ){
            $imageUrl = $images[$pageId][0]['url'];
        }
        else {
            $imageUrl = '';
        }

        $oArticleService = new ArticleService();
        $oArticleService->setArticleById( $pageId );

        $textSnippet = $oArticleService->getTextSnippet( 120 );
        $strPos = mb_strrpos( $textSnippet, ' ' );
        $textSnippet = mb_substr( $textSnippet, 0, ( $strPos ) );
        $textSnippet.= ' ...';

        $this->setVal('title', $oTitle->getText());
        $this->setVal('imgUrl', $imageUrl);
        $this->setVal('articleUrl', $oTitle->getLocalUrl());
        $this->setVal('textSnippet', $textSnippet);
    }

  /*  public function createMap(){
        $imgFile =$this->request->getVal('oImage', false);
        if(empty($imgFile)){
            return false;
        }
        $imgName = $imgFile->getName();
        $sTmpPath = wfReplaceImageServer(
            $imgFile->getUrl()
        );
        $data = HTTP::get($sTmpPath );
        $src = imagecreatefromstring( $data );

        //header('Content-Type: image/png'); die();
        //echo( + "</br>");

        $orgWidth = $imgFile->getWidth();
        $orgHeight = $imgFile->getHeight();

        if ($orgHeight == $orgWidth) {
            return true;
        }else{
            $imgName = $imgFile->getName();
            $size_map = $this->setSizeMap($orgWidth,$orgHeight);
            $finalHeight = $size_map["height"];
            $finalWidth = $size_map["width"];
            $horizontal = $size_map["horizontal"];
            $vertical = $size_map["vertical"];

        $im = imagecreate($finalWidth, $finalHeight);
        $backgroundIMG = imagecolorallocate($im, 255, 255, 255);

        imagecopymerge($im, $src, $finalWidth-imagesx($src)-$vertical , $finalHeight-imagesy($src)-$horizontal, 0, 0, imagesx($src), imagesy($src), 100);
        $aNameImage= explode('.',$imgName);

        $newImgName = $aNameImage[0].'1.'.$aNameImage[1];

        var_dump($imgFile->getMimeType());

        switch ( $imgFile->getMimeType()) {
           case "image/jpeg":	$img = imagejpeg( $im, $newImgName );  break;
           case "image/gif":	$img = imagegif( $im, $newImgName );  break;
           case "image/png":	$img =imagepng( $im, $newImgName );  break;
        }

        $tempFilePath = tempnam(wfTempDir(), 'img');
        //file_put_contents($tempFilePath,$img);

        $oTitle = Title::newFromText($newImgName, NS_FILE);
        $file = F::build(
            'WikiaLocalFile',
            array(
                $oTitle,
                RepoGroup::singleton()->getLocalRepo()
            )
        );

        $result = $file->upload(
            $tempFilePath,
            'created image',
            '',
            File::DELETE_SOURCE
        );
            var_dump($result);
        //imagedestroy( $src );
        }
    }

    public function setSizeMap($widthIMG,$heightIMG){
        $vertical =0;
        $horizontal =0;
        if($widthIMG>$heightIMG)
        {
            $horizontal = ($widthIMG-$heightIMG)/2;
            $heightIMG = $widthIMG;
        }else{
            $vertical = ($heightIMG-$widthIMG);
            if($vertical!=0){
                $vertical = $vertical/2;
            }
            $widthIMG = $heightIMG ;
        }
        return Array('width'=>ceil($widthIMG), 'height'=>ceil($heightIMG), 'vertical'=>ceil($vertical), 'horizontal'=>ceil($horizontal));
    }*/

    public function getTile(){
        $position_X = $this->getVal('x');
        $position_Y = $this->getVal('y');
        $zoom = $this->getVal('z');
        $name = $this->getVal('imgName');
        $ver_img = $this->getVal('version');
        $width = 256;

        $imgFile = wffindFile($name);

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

        $left = floor(($position_X)*$titlesize);
        $right = floor($left + $titlesize);
        $top =  floor(($position_Y)*$titlesize);
        $bottom = floor($top + $titlesize);

        $urlIMG = wfReplaceImageServer(
            $imgFile->getThumbUrl( "{$width}px-{$left},{$right},{$top},{$bottom}-" . $imgFile->getName() )
        );
        $this->setVal('url',$urlIMG);
    }

/*    public function setHeightDiv($widthIMG, $heightIMG){
        $width = 660;
        $scal = $width/$widthIMG;
        return $heightIMG*$scal;
    }*/

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
}