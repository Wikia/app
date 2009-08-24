<?php
/**
 * Use Exhibit to print query results.
 * @author Fabian Howahl
 * @file
 * @ingroup SMWQuery
 */

/**
 * Result printer using Exhibit to display query results
 *
 * @ingroup SMWQuery
 */
class SRFExhibit extends SMWResultPrinter {
  ///mapping between SMW's and Exhibit's the data types
  protected $m_types = array("_wpg" => "text", "_num" => "number", "_dat" => "date", "_geo" => "text");

  protected static $exhibitRunningNumber = 0; //not sufficient since there might be multiple pages rendered within one PHP run; but good enough now

  ///overwrite function to allow execution of result printer even if no results are available (in case remote query yields no results in local wiki)
  public function getResult($results, $params, $outputmode) {
    $this->readParameters($params,$outputmode);
    $result = $this->getResultText($results,$outputmode);
    return $result;
  }

  ///function aligns the format of SMW's property names to Exhibit's format
  protected function encodePropertyName($property){
    return strtolower(str_replace(" ","_",$property));
  }

  protected function getResultText($res, $outputmode) {

    global $smwgIQRunningNumber, $wgScriptPath, $smwgScriptPath, $srfgIP;

    //check if present query is meant for a remote wiki
    if(array_key_exists('remote', $this->m_params)){
      $remote = 'true';
    }
    else{
      $remote = 'false';
    }

    //in case the remote parameter is set, a link to the JSON export of the remote wiki is included in the header as a data source for Exhibit
    //this section creates the link
    if($remote == 'true'){
      $newheader = '<link rel="exhibit/data" type="application/jsonp" href="';
      $link = $res->getQueryLink('JSON Link');
      $link->setParameter('json','format');

      if(array_key_exists('callback', $this->m_params)){ //check if a special name for the callback function is set, if not stick with 'callback'
	$callbackfunc = $this->m_params['callback'];
      } else {
	$callbackfunc = 'callback';
      }

      $link->setParameter($callbackfunc,'callback');
      $link = $link->getText(2,$this->mLinker);


      list($link, $trash) = explode('|',$link);
      $link = str_replace('[[:','',$link);

      $newheader .= $this->m_params['remote'].$link.'"';
      $newheader .=' ex:jsonp-callback="'.$callbackfunc.'"';
      $newheader .= '/>';

      SMWOutputs::requireHeadItem('REMOTE', $newheader);
    }


    //variables indicate the usage of special views
    //the variable's values have an impact on the way Exhibit is called
    $timeline = false;
    $map = false;
    $gmapkey = "ABQIAAAAxPWbYPItNuXYou-zhcwMQRRBvrXjVgv-fIy5s9ME7CnyO4ElKxSkigI3aArytDY3orzbsTOGyWBQyw"; //assign a customized Google Maps Key here


    /*The javascript file adopted from Wibbit uses a bunch of javascript variables in the header to store information about the Exhibit markup.
     The following code sequence creates these variables*/

    //prepare sources (the sources holds information about the table which contains the information)

    foreach ($res->getPrintRequests() as $pr){
      $colstack[] = $this->encodePropertyName($pr->getLabel()) . ':' .
	                (array_key_exists($pr->getTypeID(),$this->m_types)?$this->m_types[$pr->getTypeID()]:'text') ;
    }
    $colstack[] = 'uri:url';
    array_shift($colstack);
    array_unshift($colstack, 'label');
    if($remote == 'false'){
      if(SRFExhibit::$exhibitRunningNumber == 0){
	$sourcesrc = "var sources = { source".($smwgIQRunningNumber-1).": { id:  'querytable".$smwgIQRunningNumber."' , columns: '".implode(',',$colstack)."'.split(','), hideTable: '1', type: 'Item', label: 'Item', pluralLabel: 'Items' } };";
      }
      else{
	$sourcesrc = "sources.source".$smwgIQRunningNumber." =  { id:  'querytable".$smwgIQRunningNumber."' , columns: '".implode(',',$colstack)."'.split(','), hideTable: '1', type: 'Item', label: 'Item', pluralLabel: 'Items' };";
      }
      $sourcesrc = "<script type=\"text/javascript\">".$sourcesrc."</script>";
    }
    else {
      if(SRFExhibit::$exhibitRunningNumber == 0) $sourcesrc = "<script type=\"text/javascript\">var sources = {}</script>";
      else $sourcesrc = '';
    }

    //prepare facets
    $facetcounter = 0;
    if(array_key_exists('facets', $this->m_params)){
      $facets = explode(',', $this->m_params['facets']);
	  $facetstack = array();
      foreach( $facets as $facet ) {
	foreach ($res->getPrintRequests() as $pr){
	  if($this->encodePropertyName($pr->getLabel()) == $this->encodePropertyName($facet)){
	    switch($pr->getTypeID()){
	    case '_num':
	      $facetstack[] = ' facet'.$facetcounter++.': { position : "right", innerHTML: \'ex:role="facet" ex:facetClass="NumericRange"  ex:interval="100000" ex:expression=".'.$this->encodePropertyName($facet).'"\'}';
	      break;
	    default:
	      $facetstack[] = ' facet'.$facetcounter++.': { position : "right", innerHTML: \'ex:role="facet" ex:expression=".'.$this->encodePropertyName($facet).'"\'}';
	    }
	    break;
	  }
	}
      }
      $facetstring = implode(',',$facetstack);
    }
    else $facetstring = '';
    $facetsrc = "var facets = {".$facetstring." };";


    $result = '';


    //prepare views

    $viewcounter = 0;
    if(array_key_exists('views', $this->m_params)) $views = explode(',', $this->m_params['views']);
    else $views[] = 'tiles';

    foreach( $views as $view ){
      switch( $view ){
      case 'tabular'://table view (the columns are automatically defined by the selected properties)
	foreach ($res->getPrintRequests() as $pr){
	  $thstack[] = ".".$this->encodePropertyName($pr->getLabel());
	}
	array_shift($thstack);
	array_unshift($thstack, '.label');
	$viewstack[] = 'ex:role=\'view\' ex:viewClass=\'Tabular\' ex:label=\'Table\' ex:columns=\''.implode(',',$thstack).'\' ex:sortAscending=\'false\'' ;
	break;
      case 'timeline'://timeline view
	$timeline = true;
	$params = array('proxy','start','end','colorkey');
	$tlparams = array();
	foreach($params as $param){
	  if(array_key_exists($param, $this->m_params)) $tlparams[] = 'ex:'.$param.'=\'.'.$this->m_params[$param].'\' ';
	}
	if(!array_key_exists('start', $this->m_params)){//find out if a start and/or end date is specified
	  $dates = array();
	  foreach ($res->getPrintRequests() as $pr){
	    if($pr->getTypeID() == '_dat') {
	      $dates[] = $pr;
	      if(sizeof($dates) > 2) break;
	    }
	  }
	  if(sizeof($dates) == 1){
	    $tlparams[] = 'ex:start=\'.'.$this->encodePropertyName($dates[0]->getLabel()).'\' ';
	  }
	  else if(sizeof($dates) == 2){
	    $tlparams[] = 'ex:start=\'.'.$this->encodePropertyName($dates[0]->getLabel()).'\' ';
	    $tlparams[] = 'ex:end=\'.'.$this->encodePropertyName($dates[1]->getLabel()).'\' ';
	  }
	}
	$viewstack[] = 'ex:role=\'view\' ex:viewClass=\'Timeline\' ex:label=\'Timeline\' '.implode(" ",$tlparams);
	break;
      case 'map'://map view
	$map = true;
	$params = array('latlng','colorkey');
	$mapparams = array();
	foreach($params as $param){
	  if(array_key_exists($param, $this->m_params)) $mapparams[] = 'ex:'.$param.'=\'.'.$this->m_params[$param].'\' ';
	}
	if(!array_key_exists('start', $this->m_params) && !array_key_exists('end', $this->m_params)){ //find out if a geographic coordinate is available
	  foreach ($res->getPrintRequests() as $pr){
	    if($pr->getTypeID() == '_geo') {
	      $mapparams[] = 'ex:latlng=\'.'.$this->encodePropertyName($pr->getLabel()).'\' ';
	      break;
	    }
	  }
	}
	$viewstack[] .= 'ex:role=\'view\' ex:viewClass=\'Map\' ex:label=\'Map\' '.implode(" ",$mapparams);
	break;
      default:case 'tiles'://tile view
	$viewstack[] = 'ex:role=\'view\'';
	break;
      }
    }

    $viewsrc = 'var views = "'.implode("/", $viewstack).'".split(\'/\');;';


    //prepare automatic lenses

    global $wgParser;
    $lenscounter = 0;

    if(array_key_exists('lens', $this->m_params)){//a customized lens is specified via the lens parameter within the query
      $title    = Title::newFromText("Template:".$this->m_params['lens']);
      $article  = new Article($title);
      $wikitext = $article->getContent();

      preg_match_all("/[{][{][{][A-z]*[}][}][}]/u",$wikitext,$matches);

      foreach($matches as $match){
	foreach($match as $value){
	  $strippedvalue = trim($value,"{}");
	  $wikitext = str_replace($value,'<div id="lenscontent'.$lenscounter.'">'.strtolower(str_replace("\n","",$strippedvalue)).'</div>',$wikitext);
	  $lenscounter++;
	}
      }

      $html = $wgParser->parse($wikitext, $title, new ParserOptions(), true, true)->getText();

      $lenssrc = "var lens = ".$html.";counter =".$lenscounter.";";
    } else {//generic lens (creates links to further content (property-pages, pages about values)
      foreach ($res->getPrintRequests() as $pr){
	if($pr->getTypeID() == '_wpg') {
	  $lensstack[] = '<tr><td width=20%>'.$pr->getText(0, $this->mLinker).'</td><td width=80%><a ex:href-subcontent="'.$wgScriptPath.'/index.php?title={{.'.$this->encodePropertyName($pr->getLabel()).'}}"><div ex:content=".'.$this->encodePropertyName($pr->getLabel()).'" class="name"></div></td></a></td></tr>';
	}
	else{
	  $lensstack[] = '<tr><td width=20%>'.$pr->getText(0, $this->mLinker).'</td><td width=80%><div ex:content=".'.$this->encodePropertyName($pr->getLabel()).'" class="name"></div></td></tr>';
	}
      }

      array_shift($lensstack);

      $lenssrc = 'var lens = \'<table width=100% cellpadding=3><tr><th align=left colspan=2 bgcolor=#DDDDDD><a ex:href-subcontent="'.$wgScriptPath.'/index.php?title={{.label}}"><div ex:content=".label" class="name"></div></a></th></tr>'.implode("", $lensstack).'</table>\'; counter ='.$lenscounter.';';

    }

    //prepare remote
    $remotesrc = "var remote = ".$remote.";";

    //create script header with variables containing the Exhibit markup
    $headervars = "<script type='text/javascript'>\n\t\t\t".$facetsrc."\n\t\t\t".$viewsrc."\n\t\t\t".$remotesrc."\n\t\t\t".$lenssrc."\n</script>";


    //To run Exhibit some links to the scripts of the API have to be included in the header

    $ExhibitScriptSrc1 = '<script type="text/javascript" src="http://simile.mit.edu/repository/exhibit/branches/2.0/src/webapp/api/exhibit-api.js?autoCreate='.'false'.'&safe=true'; //former: auto create = remote
    if($timeline) $ExhibitScriptSrc1 .= '&views=timeline';
    if($map) $ExhibitScriptSrc1 .= '&gmapkey='.$gmapkey;
    $ExhibitScriptSrc1 .= '"></script>';
    $ExhibitScriptSrc2 = '<script type="text/javascript" src="'.$wgScriptPath.'/extensions/SemanticResultFormats/Exhibit/SRF_Exhibit.js"></script>';

    SMWOutputs::requireHeadItem('EXHIBIT1', $ExhibitScriptSrc1); //include Exhibit API
    SMWOutputs::requireHeadItem('EXHIBIT2', $ExhibitScriptSrc2); //includes javascript overwriting the Exhibit start-up functions
    SMWOutputs::requireHeadItem('SOURCES'.$smwgIQRunningNumber, $sourcesrc);//include sources variable
    SMWOutputs::requireHeadItem('VIEWSFACETS', $headervars);//include views and facets variable

    wfLoadExtensionMessages('SemanticMediaWiki');

    if($remote=='false'){//just print the table if query is meant for the local wiki
      // print header
      if ('broadtable' == $this->mFormat)
	$widthpara = ' width="100%"';
      else $widthpara = '';
      $result = "<table class=\"smwtable\"$widthpara id=\"querytable" . $smwgIQRunningNumber . "\">\n";
      if ($this->mShowHeaders) { // building headers
	$result .= "\t<tr>\n";
	foreach ($res->getPrintRequests() as $pr) {
	  $result .= "\t\t<th>" .$pr->getText($outputmode,$this->getLinker(0)). "</th>\n";
	}
	$result .= "\t</tr>\n";
      }

      // print all result rows
      while ( $row = $res->getNext() ) {
	$result .= "\t<tr>\n";
	foreach ($row as $field) {
	  $result .= "\t\t<td>";
	  $textstack = NULL;
	  while ( ($object = $field->getNextObject()) !== false ) {
	    switch($object->getTypeID()){
	    case '_wpg':
	      $textstack[] = $object->getLongText($outputmode,$this->getLinker(0));
	      break;
	    case '_geo':
	      $textstack[] = $object->getXSDValue($outputmode,$this->getLinker(0));
	      break;
	    case '_num':
	      $textstack[] = $object->getNumericValue($outputmode,$this->getLinker(0));
	      break;
	    default:
	      $textstack[] = $object->getShortText($outputmode,$this->getLinker(0));
	    }
	  }

	  if($textstack != null){
	    $result .= implode(';',$textstack)."</td>\n";
	  }
	  else $result .= "N/A</td>\n";
	}
	$result .= "\t</tr>\n";
      }
      $result .= "</table>\n";
    }

    if (SRFExhibit::$exhibitRunningNumber == 0) $result .= "<div id=\"exhibitLocation\"></div>"; // print placeholder (just print it one time)
    $this->isHTML = ($outputmode == SMW_OUTPUT_HTML); // yes, our code can be viewed as HTML if requested, no more parsing needed
	SRFExhibit::$exhibitRunningNumber++;
    return $result;
  }
}
