<?php
/*
 * MV_SequencePage.php Created on Oct 17, 2007
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 *
 * @author Michael Dale
 * @email dale@ucsc.edu
 * @url http://metavid.org
 *
 * redirects the user to the sequence interface.
 */
// sequence just adds some sequence hooks:
if ( !defined( 'MEDIAWIKI' ) )  die( 1 );



class MV_SequencePage extends Article {
	var $outMode = 'page';
	var $clips = array();	
	var $mHLRD = ''; 		//raw text of high level resource description
	var $aHLRD = array(); 	//array representation of high level resource description
	function __construct( $title ) {
		global $wgRequest;		
		return parent::__construct( $title );		
	}
	/*
	 * returns the xml output of the sequence with all wiki-text templates/magic words swapped out
	 * also resolves all image and media locations with absolute paths.
	 */
	function getSequenceSMIL(){
		global $wgParser,$wgOut, $wgUser, $wgEnableParserCache;		
		//temporally stop cache:  
		$wgEnableParserCache=false;
		
		if($wgEnableParserCache){
			$mvParserCache = & MV_ParserCache::singleton();
			$mvParserCache->addToKey( 'seq-xml' ); //differentiate the articles xml from article
			$parserOutput = $mvParserCache->get( $this, $wgUser );
		}
		if($parserOutput!=false)
			return $parserOutput->getText();
		//get the high level sequence description: 
		$this->getSequenceHLRD();
		$this->parseHLRD_DOM();			    
	    //this is the heavy lifting of the getSequenceSMIL function: 	    
	    $this->resolveHLRD_to_SMIL();
	    	    	    	    	    
	    //@@todo get parser Output Object (maybe cleaner way to do this? 
	    //maybe parser cache is not the right place for this?) 
	    $parserOutput = $wgParser->parse('', $this->mTitle, ParserOptions::newFromUser( $wgUser ));	    
	    //output header: 	    
	    $parserOutput->mText.=$this->smilDoc->saveXML();
			
		//save to cache if parser cache enabled:
		if($wgEnableParserCache)
			$mvParserCache->save( $parserOutput, $this, $wgUser );

		return $parserOutput->getText();
	}
	//DOM based parse:
	function parseHLRD_DOM(){  
	    $this->hlrdDoc = new DOMDocument();
	    $this->hlrdDoc->loadXML($this->mHLRD);	    
	}
	//go from High level resource description to smile doc
	function resolveHLRD_to_SMIL(){
		global $wgServer, $wgScript;
		//init smil skeleton: 
		$this->smilDoc = new DOMDocument('1.0','UTF-8');
		
		$rootNode = $this->smilDoc->createElement('smil');
		$rootNode->setAttribute("xmlns", "http://www.w3.org/2001/SMIL20/Language");
		
		$headNode = $this->smilDoc->createElement('head');				
		//add meta data:
		$talkTitle = $this->mTitle->getTalkPage();
		$metaData = array(
			'title'			=> $this->mTitle->getText(), 
			'interface_url' => $wgServer . $wgScript,
			'linkback'		=> $this->mTitle->getFullURL(),
			'mTitle'		=> $this->mTitle->getPrefixedDBKey(),
			'mTalk'			=> $talkTitle->getPrefixedDBKey()
		);
		foreach($metaData as $name=>$val){
			$titleNode = $this->smilDoc->createElement('meta');
			$titleNode->setAttribute("name", htmlentities($name) );
			$titleNode->setAttribute("content", htmlentities($val) );
			$headNode->appendChild($titleNode);
		}
		
		//add resolved transitions to the head: 
		$tranNodeList = $this->hlrdDoc->getElementsByTagName('transition');
		foreach ($tranNodeList as $tranNode){
			//for now do a direct copy (future we should do additional validation even though it should be validated on the way in)
			$node = $this->smilDoc->importNode($tranNode, true);
			$headNode->appendChild($node);
		}				
		$rootNode->appendChild($headNode);
		
		//add the seq body: 
		$bodyNode = $this->smilDoc->createElement('body');
		$seqNodeList = $this->hlrdDoc->getElementsByTagName('seq');
		foreach($seqNodeList as $seqNode){
			//import the top seq node:
			$topSeqNode = $this->smilDoc->importNode($seqNode, false);
			//get all the media references
			//@@todo also get the alias tags (video, audio, image ..etc) 
			$refNodeList = $seqNode->getElementsByTagName('ref');
			foreach($refNodeList as $refNode){		
				 //make sure its a valid ref node: 	
				 $refNode = $this->smilDoc->importNode( $this->resolveResourceNode($refNode), true );
				 $topSeqNode->appendChild($refNode);
			}
			$bodyNode->appendChild($topSeqNode);
		}
		$rootNode->appendChild($bodyNode);		
		//append the root node to the SMIL DOM:
		$this->smilDoc->appendChild($rootNode);
		//set to pretty format:		
		$this->smilDoc->formatOutput = true;						
	}
	/*takes an input node returns a resolved node*/
	function resolveResourceNode(& $node){		
		global $wgUser,$wgParser;
		//print 'resolveResourceNode:' . $node->nodeName . " : " . $node->nodeValue . "\n";
		
		//don't process free flowing text 
		//@@todo (we should probably throw it out)
		if($node instanceof DOMText)
			return $node;
		
		$nodeAttr = $node->attributes;
		$node_uri=false;
		if(!is_null($nodeAttr)){ 
			foreach($nodeAttr as $atrr){
				if($atrr->nodeName=='uri'){
					//pull in node content
					$node_uri = $atrr->nodeValue;					
				}				
				//print "$attr = ".  $atrr->nodeValue . "\n";
			}
		}		
		
		//if no resource uri is provided just parse inner html and return
		if(!$node_uri){					
			$node->setAttribute('type','text/html');
			return $this->parseInnerWikiText($node);			
		}
		
		$uriTitle = Title::newFromDBkey($node_uri);				
		//figure out if how we should parse innerHTML:
		switch( $uriTitle->getNamespace() ){
 			case NS_MAIN:
 				//top level ref includes of pages in the main namespace not supported
 			break;
 			case MV_NS_SEQUENCE:
 				//type sequence ..@@todo transclude the sequence into present sequence (try to avoid id) 
 			break;
 			case MV_NS_STREAM:
 				global $mvDefaultVideoQualityKey, $mvDefaultFlashQualityKey;
 				//we could include relevant timed text and relevant different source types.
 				  
				//make sure the stream exists:
 				$mvTitle = new MV_Title($uriTitle);
 				if(!$mvTitle->doesStreamExist() ){ 					
 					$node->setAttribute('type','text/html'); 					
 					$this->parseInnerWikiText($node, wfMsg('mv_resource_not_found',$uriTitle->getText()));
 					return $node;
 				}
 				
 				//get urls for flash and ogg 	
 							
 				$stream_web_url = $mvTitle->getWebStreamURL( $mvDefaultVideoQualityKey );
				$flash_stream_url = $mvTitle->getWebStreamURL( $mvDefaultFlashQualityKey );
				
				if( !$stream_web_url && !$flash_stream_url ){
					$node->setAttribute('type','text/html'); 					
 					$this->parseInnerWikiText($node, wfMsg('mv_resource_not_found',$uriTitle->getText()));
 					return $node;
				}
				
				//by default set the ogg source 
 				//@@todo parse child nodes for stream request params?  				
 			
 				if( $stream_web_url ){				 					
		    		$node->setAttribute('type', htmlspecialchars( MV_StreamFile::getTypeForQK( $mvDefaultVideoQualityKey ) ));
					$node->setAttribute('src', $stream_web_url );
					$node->setAttribute('poster',   $mvTitle->getStreamImageURL() );
 				} 					
 				//add in flash as a fallback method:
 				if( $flash_stream_url ){
 					$f = $node->ownerDocument->createDocumentFragment();
 					$f->appendXML(  '<source type="' .
					htmlspecialchars( MV_StreamFile::getTypeForQK( $mvDefaultFlashQualityKey ) ) .
					'" src="' . $flash_stream_url . '"></source>' );
					$node->appendChild($f); 
 				}							
				 				
 			break;
 			case NS_TEMPLATE:
 				//templates are of type text/html
 				$node->setAttribute('type','text/html');
 				//print "none type: ". $node->getAttribute('type');
 				//if template look for template parameters:
 				$templateText = '{{'. $uriTitle->getText();
 				$addedParamFlag=false;
 				while ($node->childNodes->length){
 					if($node->firstChild->nodeName=='param'){
 						$param = & $node->firstChild;
 						//make sure we have a name:  
 						if($param->hasAttribute('name')){
 							//we have parameters:
 							$templateText.= "|\n";
 							$templateText .= $param->getAttribute('name') . '=';
 							//try and get the value from the value attribute or innerHTML
 							if($param->hasAttribute('value')){
 								$templateText .= $param->getAttribute('value');
 							}else{
 								//grab from inner html:
 								while ($param->childNodes->length){
 									$templateText .= $param->ownerDocument->saveXML( $param->firstChild );	
 									$param->removeChild( $param->firstChild );
 								} 								
 							} 							
 						}
 						$addedParamFlag=true;
 					}
 					$node->removeChild($node->firstChild);
 				}
 				//close up the template wikiText call:
 				$templateText.=($addedParamFlag)?"\n}}":'}}';
 				//$parserOutput = $wgParser->parse($templateText  ,$this->mTitle, ParserOptions::newFromUser( $wgUser ));
 				//print "should parse: \n $templateText";
 				$this->parseInnerWikiText($node, $templateText);
 			break;
 			case NS_IMAGE:
 			case NS_FILE:
 				//lookup the file/stream
 				global $mvDefaultVideoPlaybackRes;
 				list($width,$height)= explode('x',$mvDefaultVideoPlaybackRes);
 				//@@todo more flexibility with image grabbing 				 				
 				
 				// (probably should be handled via "figure" namespace which could allow arbitrary crop, resize, overlay) 				
 				$img = wfFindFile( $uriTitle ); 	
 				if( !$img ){
 					$node->setAttribute('type','text/html'); 					
 					$this->parseInnerWikiText($node, wfMsg('mv_resource_not_found',$uriTitle->getText()));
 					return $node;
 				}
 				
 				//print "resource found set: " . $img->getMimeType();
 				//set type attribute:  
 				//get a default wide media; 
 				$thumbnail = $img->transform( array('width'=>$width) );
 				if( $thumbnail->isError()  ){
 					$this->parseInnerWikiText( $node, $thumbnail->toHtml() );
 				}else{ 					 				
	 				$node->setAttribute( 'type', $img->getMimeType() );
	 				$node->setAttribute( 'src', $img->getURL() );
	 				
	 				//if type is ogg: (set dur and poster) 
	 				if( $img->getMimeType()=='application/ogg') {
	 					if( !$node->hasAttribute('dur') )
	 						$node->setAttribute('dur',  $thumbnail->file->getLength() );
	 					if( !$node->hasAttribute('poster') ){
	 						$node->setAttribute('poster',  $thumbnail->getURL() );
	 					}
	 				}
 				}	
 			break; 
 			default:
 				$node->setAttribute('type','text/html'); 					
 				$this->parseInnerWikiText($node, wfMsg('mv_resource_not_supported', 
 								$uriTitle->getNsText() . $uriTitle->getText()) );
 			break;
		}									
		return $node;
	}
	//@@todo in the future we could do normal XML validation
	function validateNodeAttributes( &$node ){
		//make sure only valid node Attributes per node name get through & htmlentities the values 
	}
	/*
	 * parse the inner node as wiki text 
	 */
	function parseInnerWikiText( &$node, $innerWikiText=''){
		global $wgParser;
		//put all the child nodes into $innerWikiText
		if( $node->hasChildNodes() ){		
			while ($node->childNodes->length){
				$innerWikiText.= $node->ownerDocument->saveXML($node->firstChild);					
     			$node->removeChild($node->firstChild);
			}																							
		}				
		if(trim($innerWikiText)!=''){	
			$f = $node->ownerDocument->createDocumentFragment();
			$parserOutput = $wgParser->parse($innerWikiText  ,$this->mTitle, ParserOptions::newFromUser( $wgUser ));				
		    $f->appendXML( "<![CDATA[\n".
		    		$parserOutput->getText() . 
		    		"\n]]>"		    		
		    	);				
			$node->appendChild($f); 				 
		}
		return $node;
	}
	function replaceInnerNodeText( &$node, $text){
		while ($node->childNodes->length){			
     		$node->removeChild($node->firstChild);
		}	
		$f = $node->ownerDocument->createDocumentFragment();
		$f->appendXML(  "<![CDATA[\n". 
		 					$text .
		 				  "\n]]>"		); 
		$node->appendChild($f);
		return $node; 	
	}		
	/*function getSmilXml(){
		$o= '<smil xmlns="http://www.w3.org/2001/SMIL20/Language">'."\n";
		$o.=$this->ary2xml($this->aHLRD, $baseIndent=1);
	    //close smil:
	    $o.='</smil>';
	    return $o;
	}*/
	/* function resolveHLRD()
	 * collapses values for top level resource pointers
	 * sends all relevant data to wiki for parsing.
	 * resolves/looks up all resources.
	*/
	/*function resolveHLRD(){
		global $wgParser,$wgOut, $wgUser, $wgEnableParserCache;
	
		//collapse all tags that can have values
		for($i=0;$i<count($this->aHLRD);$i++){		
			if(isset( $this->aHLRD[$i])){
				$tag = $this->aHLRD[$i];
				//print " on tag: $i " . print_r($tag, true) . "\n\n";
				//resolve import uri's ... 
				//@@todo optimize to do all queries/lookups at once. 
	 			if(isset($tag['attributes'])){
	 				if(isset($tag['attributes']['uri'])){
	 						//if resolved resource is done for current pass: continue 	 						 						
	 						if( $this->resolveResource($i) )
	 							continue;			
	 				}
	 			}
				
				//collapse & send child nodes to wiki parser 
				if( in_array($tag['tag'], array('ref','animation','audio','img','text','textstream','video') )){
					//valid tag.. scoop up all child nodes: 
					if($tag['type'] == 'open'){
						$open_inx = $i+1;
						$cvalue = '';
						$base_depth = $tag['level'];
						//find close tag
						while( $i<count( $this->aHLRD ) ){
							if($tag['type'] == 'close' && $base_depth == $tag['level'] ){
								$close_inx = $i-1;
								break;							
							}														
							$tag= $this->aHLRD[$i++];
						}
						//init val if not set: 					
						if(!isset($this->aHLRD[ $open_inx-1 ][ 'value' ]))
							$this->aHLRD[ $open_inx-1 ][ 'value' ]='';	
							
						//swap in the wiki parsed innerHTML:
						$this->aHLRD[ $open_inx-1 ][ 'value' ].=
							 				$this->ary2xml(
							 					array_splice(
							 						$this->aHLRD, $open_inx, ($close_inx-$open_inx)
							 					)  
							 				); 			
											
						$this->aHLRD[ $open_inx-1 ][ 'type' ] = 'complete'; 
						//remove the close index 
						if($this->aHLRD[$open_inx]['type']=='close')
							unset($this->aHLRD[$open_inx]);						
						//update the index (now that we have spliced the array ):
						$i= $open_inx-1; //(will ++ on next loop)				
					}					
					//$this->aHLRD[ $open_inx-1 ][ 'value' ] =  $parserOutput->getText();					
				}			
			}
		}
		//print_r($this->aHLRD);		
		//now that inner xml has been parse and outputed parse innerValue of tag as wiki_text:
		for($i=0;$i<count($this->aHLRD);$i++){					
			$parserOutput = $wgParser->parse($this->aHLRD[ $i ][ 'value' ]  ,$this->mTitle, ParserOptions::newFromUser( $wgUser ));
			$this->aHLRD[ $i ][ 'value' ] = $parserOutput->getText();
		}
		//print "resolveHLRD:";
		//print_r($this->aHLRD);
		//die;
	}*/
	/*
	 * resolves any resource refrences and gets things ready to be parsed as wikiText
	 */
	/*function resolveResource(& $i){ //pass in the current index
		$tag = $this->aHLRD[ $i ];
		$uriTitle = Title::newFromDBkey($tag['attributes']['uri']);
	 	if( !$uriTitle->exists() ){
	 		$this->aHLRD[$i]['value']=wfMsg('mv_resource_not_found', htmlspecialchars($tag['attributes']['uri']) );
	 		$this->aHLRD[ $i ]['attributes']['type']='text/html';
	 		return false;
	 	}	 	
		//print "f:getResourceArrayFromTitle";	
		switch( $uriTitle->getNamespace() ){
 			case NS_MAIN:
 				//top level ref includes of pages in the main namespace not supported
 			break;
 			case NS_TEMPLATE: 		 						 			
 				//grab all the template paramaters
 				//ignore any tags other than root param values
 				//print('on tag: ' .$i. ':' . print_r($tag, true)); 
 				$paramAry = array(); 				
 				if($tag['type'] == 'open'){
						$open_inx = $i;
						$base_depth = $tag['level'];
						//find close tag
						while( $i<count( $this->aHLRD ) ){
							if($tag['type'] == 'close' && $base_depth == $tag['level'] ){
								$close_inx = $i-1;
								break;							
							}						
							if($tag['tag']=='param' 
								&& isset( $tag['attributes'] )
								&& isset( $tag['attributes']['name'] ) ){
									//set via innerHTML
									if( isset( $tag['value'] ) ) 
										$paramAry[ $tag['attributes']['name'] ] = $tag['value'];
									//or set via value attribute
									if(isset( $tag['attributes']['value'] ) )
										$paramAry[ $tag['attributes']['name'] ] = $tag['attributes']['value'];
																										
							}
							$tag= $this->aHLRD[ $i++ ];							
						}	
						//remove the striped children (that sounds bad)
						$tmp = array_splice($this->aHLRD, $open_inx, ($close_inx-$open_inx)); 
						//print "Removed: " . print_r($tmp, true);
						//restore the original tag: 
						$tag =  $this->aHLRD[ $open_inx ];
						//restore the index:
						$i= $open_inx-1;
 				} 				
 				//print('NOW on tag: ' .$i. ':' . print_r($this->aHLRD[ $i ], true)); ;
 				//$tag_pre_val=$tag['value'];
 				//set up wiki_text value: 
 				$this->aHLRD[ $i ]['value'] = '{{' . $uriTitle->getText();
 				$nl='';
 				foreach($paramAry as $name=>$val){
 					$this->aHLRD[ $i ]['value'].= "\n| ". $name . ' = ' . $val;
 					$nl="\n";  					
 				}
 				$this->aHLRD[ $i ]['value'].=$nl.'}}'; 	
 				$this->aHLRD[ $i ]['type']='complete';	
 				//set type attribute: 
 				$this->aHLRD[ $i ]['attributes']['type']='text/html';
 				return true;
 			break;
 			case NS_IMAGE:
 				global $mvDefaultVideoPlaybackRes;
 				list($width,$height)= explode('x',$mvDefaultVideoPlaybackRes);
 				//@@todo more flexiblity with image grabbing 				 				
 				
 				// (probably should be hanndled via "figure" namespace which could allow arbitary crop, resize, overlay) 				
 				$img = wfFindFile( $uriTitle ); 	
 				//set type attribute:  
 				$this->aHLRD[ $i ]['attributes']['type']=$img->getMimeType();
 					
 				//get a default width wide image; 
 				$thumbnail = $img->transform( array('width'=>$width) );
 				//a direct link to media 
 				$this->aHLRD[ $i ]['attributes']['src']=$thumbnail->file->getURL();
 				return true;
 			break;
 			case MV_NS_SEQUENCE:
 				//transclude a sequence
 			break;
 			case MV_NS_STREAM:
 				//include a media stream expose links to multiple formats 								
 			break; 							
 		}
	}*/
	/*function parseHLRD(){	
		//init the storage array: 
		$this->aHLRD = array();
		//temporarly parsed storage
		$tmpAry = array(); 		
		//parse the xml: 
	    $xml_parser = xml_parser_create( 'UTF-8' ); // UTF-8 or ISO-8859-1
		   xml_parser_set_option( $xml_parser, XML_OPTION_CASE_FOLDING, 0 );
		   xml_parser_set_option( $xml_parser, XML_OPTION_SKIP_WHITE, 1 );
		   if(!xml_parse_into_struct( $xml_parser, $this->mHLRD, $this->aHLRD )){
				throw new MWException( 'error: '.
					xml_error_string(xml_get_error_code($xml_parser)).
					' at line '.
					xml_get_current_line_number($xml_parser) 
				); 		   	
		   }
	    xml_parser_free($xml_parser);	  
	    
	    //validate input with $mvHLRDTags definition
	    //*Currently dissabled ~~unclear if we really need to do this~~~
	    /*
		 * defines approved HLRD (high level resource description) tag => attributes 
		 * would be nice to use a normal xml dtd  (document type defenitions) 
		 * but kind of verbose for the time being while things are still under dev  
		 */
		/*$mvHLRDTags = Array(
			'transition' => array(
				'id'=>1,
				'fadeTo'=>1, 
				'fadeFrom'=>1),
			'seq' => array(
				'id'=>1, 
				'dur'=>1, 
				'start'=>1,
				'uri'=>1,
				'value'=>1
				)
		);
		//set all the ref Media Object Elements 
		//http://www.w3.org/TR/2008/CR-SMIL3-20080115/smil-extended-media-object.html#smilMediaNS-BasicMedia
		$mvHLRDTags['ref']=$mvHLRDTags['animation']=$mvHLRDTags['audio']=$mvHLRDTags['img']=$mvHLRDTags['text']=$mvHLRDTags['textstream']=$mvHLRDTags['video']=array(
			'id'=>1,
			'dur'=>1,
			'value'=>1,
			'transIn'=>1,
			'transOut'=>1,
			'start'=>1,
			'end'=>1,
			'uri'=>1
		); 
	    $inx=0;
	    print "parseHLRD:\n";
	    print_r($mvHLRDTags);
	    print "\n\n";
	    foreach($tmpAry as $tag){
	    	print_r($tag);
	    	//if tag is valid set all the system parsed tag values:
	    	if(isset($mvHLRDTags[ $tag['tag'] ])){
	    		$this->aHLRD[$inx]=array(
	    			'tag'=>$tag['tag'], 
	    			'type'=>$tag['type'],
	    			'level'=>$tag['level']
	    		);
	    		foreach($tag['attributes'] as $aName => $aVal){
	    			if(isset($mvHLRDTags[ $tag['tag'] ][ $aName ]))
	    				$this->aHLRD[ $inx ][ 'attributes' ][ $aName ]=$aVal;
	    		}	    		
	    	}
	    	$inx++;
	    }
	}*/
	/*function ary2xml(&$ary, $baseIndent=0){
		$o='';
		foreach( $ary as $tag ){
	    	//tab space:
	    	$c_tab='';
	    	for($i=1; $i < ($tag['level']+$baseIndent);$i++)
	    		$c_tab.="\t";
	    	$o.=$c_tab;
	    	if($tag['type']!='close'){
		    	if($tag['type']!='cdata')
		    		$o.='<'.$tag['tag'];
		    	if(isset($tag['attributes'])){	    		
		    		//escape all attribute values: 
		    		foreach($tag['attributes'] as $attr=>$aval){
		    			$o.=' '.$attr.'="'.htmlspecialchars( $aval ).'"';
		    		}
		    	}
		    	if($tag['type']!='cdata'){
		    		$o.=($tag['type']=='complete' && !(isset($tag['value'])) )?'/>'."\n":'>'."\n";
		    	}
		    	$o.=(isset($tag['value']))?$tag['value']:'';
		    	//close if complete and had value
		    	$o.=($tag['type']=='complete' && isset($tag['value']) )?
		    		"\n".$c_tab . '</' . $tag['tag'] . '>' . "\n" : '';
		    	
	    	}else{
	    		$o.='</'.$tag['tag'].'>'."\n";
	    	}	    		
	    }
	    return $o;
	}*/
	/*function doSeqReplace(&$input, &$argv, &$parser){
	 return
	 }*/
	/*function parsePlaylist(){
	 global $wgParser,$wgOut;
	 //valid playlist in-line-attributes:
		$mvInlineAttr = array('wClip', 'mvClip', 'title','linkback','desc','desc','image');
			
		//build a associative array of "clips"
		$seq_text = $this->getSequenceText();

		$seq_lines = explode("\n",$seq_text);
		$parseBucket=$cur_attr='';
		$clip_inx=-1;
		foreach($seq_lines as $line){
		//actions start with |
		$e = strpos($line, '=');
		if($e!==false){
		$cur_attr = substr($line, 1,$e-1);
		}
		if(in_array($cur_attr, $mvInlineAttr)){
		if($cur_attr=='mvClip'){
		$clip_inx++;
		}
		//close the parse bucket (found a valid inline attr)
		if($parseBucket!=''&& $cur_attr!='desc'){
		$output = $wgParser->parse( $parseBucket, $parser->mTitle, $parser->mOptions, true, false );
		$parseBucket='';
		}
		}
		$start_pos = ($e!==false)?$e+1:0;
		if($clip_inx!=-1){
		if(!isset($this->clips[$clip_inx]))$this->clips[$clip_inx]=array();
		if(!isset($this->clips[$clip_inx][$cur_attr]))$this->clips[$clip_inx][$cur_attr]='';
		$this->clips[$clip_inx][$cur_attr].= substr($line, $start_pos);
		}
		}
		//poluate data (this could go here or somewhere else)
		foreach($this->clips as $inx=>&$clip){
		if(trim($clip['mvClip'])==''){
		unset($this->clips[$inx]);
		continue;
		}
		if($clip['mvClip']){
		$sn = str_replace('?t=','/', $clip['mvClip']);
		$streamTitle = new MV_Title($sn);
		$wgStreamTitle = Title::newFromText($sn, MV_NS_STREAM);
		if($streamTitle->doesStreamExist()){
		//mvClip is a substitue for src so assume its there:
		$clip['src']=$streamTitle->getWebStreamURL();
		//title
		if(!isset($clip['title']))$clip['title']='';
		if($clip['title']=='')
		$clip['title']=$streamTitle->getTitleDesc();
			
		if(!isset($clip['info']))$clip['info']='';
		if($clip['info']=='')
		$clip['info']=$wgStreamTitle->getFullURL();
		}
		//check if we should look up the image:
		if(!isset($clip['image']))$clip['image']=='';
		if($clip['image']=='')
		$clip['image'] =$streamTitle->getFullStreamImageURL();
		//check if desc was present:
		if(!isset($clip['desc']))$clip['desc']='';
		//for now just lookup all ... @@todo future expose diffrent language tracks
		if($clip['desc']==''){
		$dbr =& wfGetDB(DB_SLAVE);
		$mvd_rows = MV_Index::getMVDInRange($streamTitle->getStreamId(),
		$streamTitle->getStartTimeSeconds(),
		$streamTitle->getEndTimeSeconds());

		if(count($mvd_rows)!=0){
		$MV_Overlay = new MV_Overlay();
		$wgOut->clearHTML();
		foreach($mvd_rows as $mvd){
		//output a link /line break
		$MV_Overlay->outputMVD($mvd);
		$wgOut->addHTML('<br>');
		}
		$clip['desc']=$wgOut->getHTML();
		$wgOut->clearHTML();
		}
		}
		}

		}
		//print_r($this->clips);
		}*/
	function doSeqReplace( &$input, &$argv, &$parser ) {
		global $wgTitle, $wgUser, $wgRequest, $markerList;
		$sk = $wgUser->getSkin();
		
		$options=array();
		$oldid = $wgRequest->getVal('oldid');
		if( $oldid != '')
			$options['oldid'] = $oldid;
			
		$seqPlayer = new MV_SequencePlayer( $wgTitle );		
		$vidtag = '<div id="file" class="fullImageLink">';	
			$vidtag.= $seqPlayer->getEmbedSeqHtml( $options );
		$vidtag .='</div><hr>';

		$marker = "xx-marker" . count( $markerList ) . "-xx";
		$markerList[] = $vidtag;
		return $marker;
	}
	function getPageContent() {
		global $wgRequest;
		$base_text = parent::getContent();
		// strip the sequence
		$seqClose = strpos( $base_text, '</' . SEQUENCE_TAG . '>' );
		if ( $seqClose !== false ) {
			return trim( substr( $base_text, $seqClose + strlen( '</' . SEQUENCE_TAG . '>' ) ) );
		}
	}
	//@@support static call if article is provided: 
	function getSequenceHLRD($article=null) {		
		// check if the current article exists:
		if ( $this->mTitle->exists() ) {
			$base_text = parent::getContent();
			$seqOpen =  strpos( $base_text, '<' . SEQUENCE_TAG . '>' );
			$seqClose = strpos( $base_text, '</' . SEQUENCE_TAG . '>' );
			if ( $seqClose !== false ) {
				$this->mHLRD = trim( substr( $base_text, $seqOpen, $seqClose+strlen('</' . SEQUENCE_TAG . '>')  ) );				
			}else{
				//@@todo error can't find sequence
				throw new MWException( 'missing sequence tag in sequence article' );
			}
		}else{
			//@@todo maybe we should output an empty sequence skeleton. 
			throw new MWException( ' missing sequence ' );
		}
		return '';			
	}
}
?>
