<?php
/**
 * Print query results in interactive graph using the
 * JavaScript InfoVis Toolkit (http://thejit.org)
 * 
 * @since 1.7.1
 * 
 * @file SRF_JitGraph.php
 * @ingroup SemanticResultFormats
 */

/**
 * Result printer for timeline data.
 * @ingroup SemanticResultFormats
 */
class SRFJitGraph extends SMWResultPrinter {

	public static $NODE_SHAPES = array('circle', 'rectangle', 'square', 'ellipse', 'triangle', 'star');

	protected $m_graphName = '227';
	protected $m_graphLabel = false;
	protected $m_graphColor = false;
	protected $m_graphLegend = false;
	protected $m_graphLink = false;
	protected $m_rankdir = "LR";
	protected $m_graphSize = "";
	protected $m_labelArray = array();
	protected $m_graphNodeType = 'circle';
	protected $m_graphNodeSize = 12;
	protected $m_graphRootNode = false;
	protected $m_nodeTypes = array('circle', 'rectangle', 'square', 'ellipse', 'triangle', 'star');
	
	protected $m_nodeColorArray = array('black'=>'#00FF00', 'red' => '#CF2A2A', 'green' => '#558800', 'blue' => '#005588');
	protected $m_rootNodeColor = '#CF2A2A'; //Red
	protected $m_graphNodeColor = '#005588'; //Blue
	
	protected $m_settings = array(
	    "divID" => "infovis",
	    "edgeColor" => "#23A4FF",
	    "edgeWidth" => 2,
	    "edgeLength" => 150,
	    "navigation" => true,
	    "zooming" => false,
	    "panning" => "avoid nodes",
	    "labelColor" => "#000000"
	);
	
	protected $m_edgeColors = array();
	protected $m_edgeNames = array();
	
	protected $debug_out = '';

	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		if ( array_key_exists( 'graphname', $params ) ) {
			$this->m_graphName = trim( $params['graphname'] );
		}
		
		$this->m_graphNodeType = $params['graphnodetype'];
		
//		if ( array_key_exists( 'graphnodetype', $params ) ) {
//			$userType = strtolower( trim( $params['graphnodetype'] ) );
//			if ( in_array($userType, $this->m_nodeTypes) ) {
//				$this->m_graphNodeType = $userType;
//			}
//
//		}

		if ( array_key_exists( 'graphnodesize', $params ) ) {

			$userSize = intval(trim( $params['graphnodesize'] ));
			if($userSize > 0) {
				$this->m_graphNodeSize = $userSize;
			}
		}
		if ( array_key_exists( 'graphsize', $params ) ) {

			$this->m_graphSize = trim( $params['graphsize'] );

		}
		if ( array_key_exists( 'graphrootnode', $params ) ) {

			if ( strtolower( trim( $params['graphrootnode'] ) ) == 'yes' ) $this->m_graphRootNode = true;

		}		
		if ( array_key_exists( 'graphlegend', $params ) ) {

			if ( strtolower( trim( $params['graphlegend'] ) ) == 'yes' ) $this->m_graphLegend = true;

		}

		if ( array_key_exists( 'graphlabel', $params ) ) {

			if ( strtolower( trim( $params['graphlabel'] ) ) == 'yes' ) $this->m_graphLabel = true;

		}
		if ( array_key_exists( 'graphnodecolor', $params ) ) {
			$userNodeColor = strtolower( trim( $params['graphnodecolor'] ) );
			if ( array_key_exists($userNodeColor, $this->m_nodeColorArray) ) {
				$this->m_graphNodeColor = $this->m_nodeColorArray[$userNodeColor];
				$this->debug_out .= "graphNodeColor: " . $this->m_graphNodeColor . " | ";
			}
		}
		if ( array_key_exists( 'rootnodecolor', $params ) ) {
			$userRootNodeColor = strtolower( trim( $params['rootnodecolor'] ) );
			if ( array_key_exists($userRootNodeColor, $this->m_nodeColorArray) ) {
				$this->m_rootNodeColor = $this->m_nodeColorArray[$userRootNodeColor];
			}
		}
		if ( array_key_exists( 'graphlink', $params ) ) {

			if ( strtolower( trim( $params['graphlink'] ) ) == 'yes' ) $this->m_graphLink = true;

		}
		if ( array_key_exists( 'graphcolor', $params ) ) {

			if ( strtolower( trim( $params['graphcolor'] ) ) == 'yes' ) $this->m_graphColor = true;

		}
		
	}

	public function getName() {
		return wfMessage( 'srf_printername_' . $this->mFormat )->text();
	}

	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		global $smwgIQRunningNumber;
		
		global $wgTitle, $wgOut;

		if ( class_exists( 'ResourceLoader' ) ) {
			$wgOut->addModules( 'ext.srf.jitgraph' );
		}
		else {
			//Include javascript files in the HTML header
			$this->includeJS();
		}
	
	    $key = 0;
		// Create text graph
		$legendInput = '';
		
		$json = "[";
		$debug = "";
		$jsonLeafs = "";
			
		while ( $row = $res->getNext() ) {

			$firstcol = true;
			
			foreach ( $row as $field ) {
				while ( ( $object = $field->getNextObject() ) !== false ) {
					
					$text = $object->getShortText( $outputmode );
					
					$nodeLinkTitle = Title::newFromText( $text );
					$nodeLinkURL = $nodeLinkTitle->getFullURL();
					
					if ( $firstcol ) {
						$firstcolvalue = $object->getShortText( $outputmode );
						
						//Title of the page where the result format is being displayed
						$thisPageTitle = $wgTitle->getPrefixedText();
						
						//This little block adds the name of the current edge to the list later used to compile the graph legend
						$req = $field->getPrintRequest();
						$labelName = trim( $req->getLabel());
						
						//Different color options and formatting for the page currently on.
						if( strcmp($thisPageTitle, $text) == 0 && $this->m_graphRootNode) {
							$rootNodeSize = $this->m_graphNodeSize + 5;
							$json .= "{ \"id\":\"$text\", ";
							$json .= "\"name\":\"$text\", ";
							$json .= "\"data\":{\"\$color\": \"$this->m_rootNodeColor\", ";
							$json .= "\"\$type\":\"$this->m_graphNodeType\", ";
							$json .= "\"\$dim\":\"17\", ";
							$json .= "\"\$url\":\"$nodeLinkURL\", ";
							$json .= "\"\$edgeType\":\"$labelName\" ";
						} else {
							$json .= "{ \"id\":\"$text\", ";
							$json .= "\"name\":\"$text\", ";
							$json .= "\"data\":{\"\$color\": \"$this->m_graphNodeColor\", ";
							$json .= "\"\$type\":\"$this->m_graphNodeType\", ";
							$json .= "\"\$dim\":\"$this->m_graphNodeSize\", ";
							$json .= "\"\$url\":\"$nodeLinkURL\", ";
							$json .= "\"\$edgeType\":\"$labelName\" ";

							if(!in_array($labelName, $this->m_edgeNames) && strlen($labelName) > 0) {
								$this->m_edgeNames[] = $labelName;
							}
						}
						
						$json .= "}, ";
						$json .= "\"adjacencies\":[ ";
					}
					

					if ( !$firstcol ) {
						
						$json .= "{ \"nodeTo\":\"$text\", ";
						$json .= "\"nodeFrom\":\"$firstcolvalue\", ";
						$json .= "\"data\":{\"\$color\":\"#$this->m_rootNodeColor\",\"\$url\":\"$nodeLinkURL\"}},";
						if ( ( $this->m_graphLabel == true ) || ( $this->m_graphColor == true ) ) {
							$req = $field->getPrintRequest();
							$labelName = $req->getLabel();

							if ( array_search( $labelName, $this->m_labelArray, true ) === false ) {
								$this->m_labelArray[] = $labelName;
							}
								$key = array_search( $labelName, $this->m_labelArray, true );
								$color = $this->m_graphColors[$key];

							if ( $this->m_graphLabel == true ) {
							
							}
							if ( $this->m_graphColor == true ) {

							}
						}
						
						
						//Create an explicit node for each leaf.
						$jsonLeafs .= "{ \"id\":\"$text\", ";
						$jsonLeafs .= "\"name\":\"$text\", ";
						
						if( strcmp($thisPageTitle, $text) == 0 ) {
							$rootNodeSize = $this->m_graphNodeSize + 5;
							$jsonLeafs .= "\"data\":{\"\$color\": \"$this->m_rootNodeColor\", ";
							$jsonLeafs .= "\"\$dim\":\"$rootNodeSize\", ";
						} else {
							$jsonLeafs .= "\"data\":{\"\$color\": \"$this->m_graphNodeColor\", ";
							$jsonLeafs .= "\"\$dim\":\"$this->m_graphNodeSize\", ";
						}
						$jsonLeafs .= "\"\$type\":\"$this->m_graphNodeType\", ";
						$jsonLeafs .= "\"\$url\":\"$nodeLinkURL\", ";
						$jsonLeafs .= "\"\$edgeType\":\"$labelName\" ";
						$jsonLeafs .= "}, ";
						$jsonLeafs .= "\"adjacencies\":[]},";
						
						//This little block adds the name of the current edge to the list later used to compile the graph legend
						$req = $field->getPrintRequest();
						$labelName = trim( $req->getLabel());
						if(!in_array($labelName, $this->m_edgeNames) && strlen($labelName) > 0) {
							$this->m_edgeNames[] = $labelName;
						}
					}
				}

				$firstcol = false;
			}
			$json = substr($json,0,-1); // Trim the comma after the last item in the list
			$json .= "]},"; //close adjacencies array
			
			//Append the leaf nodes.
			//$jsonLeafs = substr($jsonLeafs,0,-1); // Trim the comma after the last item in the list
			$json .= $jsonLeafs;
			$jsonLeafs = "";
		}
		$json = substr($json,0,-1); // Trim the comma after the last item in the list
		$json .= "]"; //close the json object array
		
		$result = '';
		
		if($this->m_graphLabel || true) {
			$result .= '<h3>'. $this->m_graphName .'</h3>';
		}
		
		$d_id = rand(1000,9999);
		$divID = 'infovis-' . $d_id; //generate a random id to have the ability to display multiple graphs on a single page.
		$this->m_settings['d_id'] = $d_id;
		$this->m_settings['divID'] = $divID;
		
		//User Settings
		$userSettings = "var graphSettings = {";
		foreach ($this->m_settings as $key => $value) {
			$userSettings .= "\"$key\": \"$value\",";
		}
		substr($userSettings,0,-1);
		$userSettings .= "};";
		
		$result .= '<div id="center-container" class="className"><span class="progressBar" id="progress-'.$d_id.'">0%</span><div id="'. $this->m_settings['divID'] .'" class="infovis"></div>'.''.'</div>';
		
		$result .= "<script>";
		$result .= $userSettings;
		// FIXME: init function cannot be called here, use JS in a separate file and bind to the onload event.
		$result .= "var json=" . $json . "; this.init(json, graphSettings);" . 'jQuery("#progress-'.$d_id.'").progressBar();';
		$result .= 'jQuery(document).load(function() {});';
		//$result .= '$("#progress1").progressBar();';
		$result .= "</script>";
		
		// yes, our code can be viewed as HTML if requested, no more parsing needed
		//$this->isHTML = $outputmode == SMW_OUTPUT_HTML;
		
		$this->isHTML = true;
		
		return $result;
	}	
	
	protected function includeJS() {
		SMWOutputs::requireHeadItem( SMW_HEADER_STYLE );

		//$wgOut->addModules( 'ext.srf.jitgraph' );

		global $srfgScriptPath;
		
		SMWOutputs::requireHeadItem(
			'smw_jgcss',
			'<link rel="stylesheet" type="text/css" href="' . $srfgScriptPath . 
				'/JitGraph/base.css"></link>'
		);
		SMWOutputs::requireHeadItem(
			'smw_jgloader',
			'<script type="text/javascript" src="' . $srfgScriptPath . 
				'/JitGraph/jquery.progressbar.js"></script>'
		);
		SMWOutputs::requireHeadItem(
			'smw_jg',
			'<script type="text/javascript" src="' . $srfgScriptPath . 
				'/JitGraph/Jit/jit.js"></script>'
		);
		SMWOutputs::requireHeadItem(
			'smw_jghelper',
			'<script type="text/javascript" src="' . $srfgScriptPath . 
				'/JitGraph/SRF_JitGraph.js"></script>'
		);			
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params['graphname'] = array(
			'default' => 'GraphName',
			'message' => 'srf_paramdesc_graphname',
		);

		$params['graphnodetype'] = array(
			'default' => false,
			'message' => 'srf-paramdesc-graph-graphnodetype',
			'values' => self::$NODE_SHAPES,
		);

		$params['graphsize'] = array(
			'type' => 'integer',
			'default' => '',
			'manipulatedefault' => false,
			'message' => 'srf_paramdesc_graphsize',
		);

		$params['graphlegend'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'srf_paramdesc_graphlegend',
		);

		$params['graphlabel'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'srf_paramdesc_graphlabel',
		);

		$params['graphcolor'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'srf_paramdesc_graphcolor',
		);

		return $params;
	}

}
