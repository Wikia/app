<?php
class CubeController extends WikiaController {
 
  var $myVar;  // declaring a variable here will "mask" the template var
 
  public function init() {
    $this->myVar = "foo";   // will be set but not exported
  }
 
  public function getData() {
	  //$url = "http://labiryntus.eu/supereggbert-GLGE-865b2d6/examples/collada/duck.dae";
// get contents of a file into a string

 
    $url = $this->getVal('url');
$content=Http::get($url);
//header('Content-type: text/xml');
    $this->data = $content;   
  }    
}
 