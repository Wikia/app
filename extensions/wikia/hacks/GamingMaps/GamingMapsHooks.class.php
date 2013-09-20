<?php
class GamingMapsHooks extends WikiaObject{

	static public function onParserFirstCallInit( Parser $parser ){
		$parser->setHook( 'gamingMap', 'GamingMapsHooks::renderGamingMapTag' );

		return true;
	}

    static public function renderGamingMapTag($content, array $attributes, Parser $parser, PPFrame $frame) {
        $app = F::app();

        //var_dump($attributes);
        //default map's valuse

        if ( !isset( $attributes['StartZoom'] ))
        {
            $attributes['StartZoom'] = 0;
        }
        if ( !isset( $attributes['MaxZoom'] ))
        {
            $attributes['MaxZoom'] = 10;
        }
        if ( !isset( $attributes['name'] ))
        {
            $attributes['name'] = "A Map";
        }

        $aLines = preg_split( '/\r\n|\r|\n/', $content );
        $aMarkers = array();
        $aDefMarkers = array();
        $aPolygons = array();
        $aTemp = array();
        //var_dump($content);
       /* $xmlVal = "<gamingmap img='wall2.jpg' name='Where is wally?'>
            <layer  name='Positions' id='pos' img='iPosIcon.png'>
                <marker lat='100' lon='50'>North(100,50)</marker>
                <marker lat='0' lon='50'>South(0,50)</marker>
                <marker lat='50' lon='0'>West(50,0)</marker>
                <marker lat='50' lon='50'>Mid(50,50)</marker>
                <marker lat='50' lon='100'>East(50,100)</marker>
                <marker lat='9' lon='9'>Wally?</marker>
            <polygon text='Somewhere here is wally'>
                <point lat='10' lon='10'/>
                <point lat='10' lon='20'/>
                <point lat='20' lon='20'/>
                <point lat='20' lon='10'/>
            </polygon>
            </layer>
            <layer  name='Cities' id='city' img='iCityIcon.png'>
                <marker lat='8.156' lon='10.352' type='city'>works?</marker>
            </layer>
            <layer  name='Quests' id='quest' img='iQuestIcon.png' />
        </gamingmap>";*/

        $xmlVal ='<?xml version="1.0" encoding="UTF-8"?><root>'.trim($content).'</root>';

        $simplyxml = new SimpleXMLElement($xmlVal);

        foreach ($simplyxml->children() as $node) {
            $arr = $node->attributes();   // returns an array
            if($node->children()){
                $aDefMarkers[] = array('name'=>(string)$arr["name"],'id'=>(string)$arr["id"],'img'=>self::getUrlIMG((string)$arr["img"]),'view'=>(string)$arr["view"]);
                foreach ($node->children() as $nodeNodes) {
                    if(trim($nodeNodes->getName())=='marker'){
                        $arr2 = $nodeNodes->attributes();   // returns an array
                        if($arr2["title"]){
                            $aMarkers[] = array('lat'=>(string)$arr2["lat"],'lon'=>(string)$arr2["lon"], 'id'=>(string)$arr["id"], 'content'=>"", 'title'=>(string)$arr2["title"]);
                        }else{
                            $aMarkers[] = array('lat'=>(string)$arr2["lat"],'lon'=>(string)$arr2["lon"], 'id'=>(string)$arr["id"], 'content'=>(string)$nodeNodes, 'title'=>"");
                        }
                    }elseif(trim($nodeNodes->getName())=='polygon'){
                        $aPolygons[] = self::setPolygon($nodeNodes, (string)$arr["id"]);
                    }
                }
            }
        }

        /*foreach($aDefMarkers as $val)
        {
            if(!empty($val))
            {
                $val[2]=self::getUrlIMG($val[2]);
            }
        }*/

        /*$imgFile = wfFindFile( $attributes['img']);
        if($imgFile->exists()){
            $app->sendRequest("GamingMaps", "createMap", array( 'oImage' => $imgFile )); //send values to controller
        }*/

        $aDefMarkers[sizeof($aDefMarkers)] = array('name'=>'Others','id'=>'other', 'img'=>self::getUrlIMG('iOtherIcon.png'),'true'); // create default marker

        $mapa = $app->sendRequest("GamingMaps", "index", array( 'attr' => $attributes, 'markers'=> $aMarkers)); //send values to controller
        $mapa = str_replace("\n","",$mapa);
        $mapa .= JSSnippets::addToStack(
            array('/extensions/wikia/GamingMaps/js/Leaflet.js','/extensions/wikia/GamingMaps/js/Maps.js','/extensions/wikia/GamingMaps/css/Leaflet.css' ),
            array(),
            'Maps.init',
            array( 'attr' => $attributes, 'markers'=> $aMarkers, 'defMarkers'=> $aDefMarkers, 'polygons'=>$aPolygons) // Send values to javascript file
        );
        return $mapa;
    }

    static public function setPolygon($node, $id){
        $atrPolygon = $node->attributes();
        $aPoints = array();
        foreach ($node->children() as $nodeNodes) {
            $arr2 = $nodeNodes->attributes();   // returns an array
            $aPoints[] = array((string)$arr2["lat"],(string)$arr2["lon"]);
            }
        return $aPolygons[] = array($id,$aPoints,(string)$atrPolygon["text"]);
    }

    public static function getUrlIMG($imgName) // serach image Icon file by name and get its url
    {
        $imgFile = wfFindFile($imgName); //find file
        if($imgFile) // check if exists
        {
            $urlIMG = wfReplaceImageServer(
                $imgFile->getUrl()
            );
        }else{ // if not set default img
            $imgFile = wfFindFile('iOtherIcon.png');
            $urlIMG = wfReplaceImageServer(
                $imgFile->getUrl()
            );
        }
        return $urlIMG;
    }
}