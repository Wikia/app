<?php

class Cube {

	static private $markers = array();

	/**
	 * parser hook for <Cube file=f size=i input={mouse,keyboard}> tag
	 * @return string tag body
	 */
	
	static function parseInput( $input ){
		$pics_urls=array(7);
		$i=0;
		if(strpos($input,"\n")==0)$input=substr($input,strpos($input,"\n")+1);
		while(strpos($input,"\n")>-1){
			//echo trim(substr($input,0,strpos($input,"\n")));
			$title = Title::newFromText(trim(substr($input,0,strpos($input,"\n"))), NS_FILE);
			$imageFile = wfFindFile($title);
			$pics_urls[$i+1] = wfReplaceImageServer($imageFile->getFullUrl());
			$input=substr($input,strpos($input,"\n")+1);
			$i++;
		}
		//echo"i=$i";
		//print_r($pics_urls);
		$pics="var pics_names=[";
		switch($i){
		case 0:
			for($i=1;$i<7;$i++){
				if($i>1)$pics .=",";
				$pics .="'".$wgExtensionsPath."/wikia/WebGL/$i.png'";
			} break;
		case 1: for($i=1;$i<7;$i++){
				if($i>1)$pics .=",";
				$pics .= "'http://aurbanski.wikia-dev.com/wikia.php?controller=CubeController&method=getData&format=html&url=".$pics_urls[1]."'";
			} break;
		case 2: for($i=1;$i<7;$i++){
				if($i>1)$pics .=",";
				$pics .= "'http://aurbanski.wikia-dev.com/wikia.php?controller=CubeController&method=getData&format=html&url=";
				switch($i){
					case 1: $pics .= $pics_urls[1]; break;
					case 2: $pics .= $pics_urls[1]; break;
					case 3: $pics .= $pics_urls[2]; break;
					case 4: $pics .= $pics_urls[2]; break;
					case 5: $pics .= $pics_urls[2]; break;
					case 6: $pics .= $pics_urls[2]; break;
				}
				$pics .= "'";
			} break;
		case 3: for($i=1;$i<7;$i++){
				if($i>1)$pics .=",";
				$pics .= "'http://aurbanski.wikia-dev.com/wikia.php?controller=CubeController&method=getData&format=html&url=";
				switch($i){
					case 1: $pics .= $pics_urls[1]; break;
					case 2: $pics .= $pics_urls[2]; break;
					case 3: $pics .= $pics_urls[3]; break;
					case 4: $pics .= $pics_urls[3]; break;
					case 5: $pics .= $pics_urls[3]; break;
					case 6: $pics .= $pics_urls[3]; break;
				}
				$pics .= "'";
			} break;
		case 4: for($i=1;$i<7;$i++){
				if($i>1)$pics .=",";
				$pics .= "'http://aurbanski.wikia-dev.com/wikia.php?controller=CubeController&method=getData&format=html&url=";
				switch($i){
					case 1: $pics .= $pics_urls[1]; break;
					case 2: $pics .= $pics_urls[2]; break;
					case 3: $pics .= $pics_urls[4]; break;
					case 4: $pics .= $pics_urls[4]; break;
					case 5: $pics .= $pics_urls[4]; break;
					case 6: $pics .= $pics_urls[3]; break;
				}
				$pics .= "'";
			} break;
		case 5: for($i=1;$i<7;$i++){
				if($i>1)$pics .=",";
				$pics .= "'http://aurbanski.wikia-dev.com/wikia.php?controller=CubeController&method=getData&format=html&url=";
				switch($i){
					case 1: $pics .= $pics_urls[1]; break;
					case 2: $pics .= $pics_urls[1]; break;
					case 3: $pics .= $pics_urls[3]; break;
					case 4: $pics .= $pics_urls[4]; break;
					case 5: $pics .= $pics_urls[2]; break;
					case 6: $pics .= $pics_urls[5]; break;
				}
				$pics .= "'";
			} break;
		case 6: for($i=1;$i<7;$i++){
				if($i>1)$pics .=",";
				$pics .= "'http://aurbanski.wikia-dev.com/wikia.php?controller=CubeController&method=getData&format=html&url=";
				$pics .= $pics_urls[$i]; 
				$pics .= "'";
			} break;
		}
		$pics .="];";
		//echo$pics;
		return $pics;
}

	public static function CubeParserHook( $input, $args, $parser ) {
		global $IP, $wgOut, $wgExtensionsPath, $wgTitle;
		$pics=self::parseInput($input);
	//echo$pics;
		$width = isset($args['width']) ? $args['width'] : 200;
		$height = isset($args['height']) ? $args['height'] : 200;
		$input = isset($args['input']) ? $args['input'] : "keyboard";
		// get contents of a file into a string
		$filename = $IP."/extensions/wikia/WebGL/Cube.include.php";
		$content = file_get_contents($filename);
		$output = 
			'<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/WebGL/js/glMatrix-0.9.5.min.js"></script>'.
			'<script type="text/javascript" src="'.$wgExtensionsPath.'/wikia/WebGL/js/webgl-utils.js"></script>'. 
			"<script type='text/javascript'>$pics</script>".$content. 
			"<canvas id='prosty' width=".$width." height=".$height."></canvas><script type='text/javascript'>webGLStart();</script>";
		//if($debug)$output.='<div><h4>Log</h4><textarea id="LOG" style="width:400px; height:200px;"></textarea></div>';
		$marker = $parser->uniqPrefix() . "-Cube-\x7f";
		self::$markers[$marker] = $output;
		return $marker;
	}


	public static function replaceMarkers(&$parser, &$text) {
		$text = strtr($text, self::$markers);
		return true;
	}
}