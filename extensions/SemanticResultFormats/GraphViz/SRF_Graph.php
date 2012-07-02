<?php

/**
 * SMW result printer for graphs using graphViz.
 * In order to use this printer you need to have both
 * the graphViz library installed on your system and
 * have the graphViz MediaWiki extension installed.
 * 
 * @file SRF_Graph.php
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2+
 * @author Frank Dengler
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SRFGraph extends SMWResultPrinter {
	
	public static $NODE_SHAPES = array(
		'box',
		'box3d',
		'circle',
		'component',
		'diamond',
		'doublecircle',
		'doubleoctagon',
		'egg',
		'ellipse',
		'folder',
		'hexagon',
		'house',
		'invhouse',
		'invtrapezium',
		'invtriangle',
		'Mcircle',
		'Mdiamond',
		'Msquare',
		'none',
		'note',
		'octagon',
		'parallelogram',
		'pentagon ',
		'plaintext',
		'point',
		'polygon',
		'rect',
		'rectangle',
		'septagon',
		'square',
		'tab',
		'trapezium',
		'triangle',
		'tripleoctagon',
	);
	
	protected $m_graphName;
	protected $m_graphLabel;
	protected $m_graphColor;
	protected $m_graphLegend;
	protected $m_graphLink;
	protected $m_rankdir;
	protected $m_graphSize;
	protected $m_labelArray = array();
	protected $m_graphColors = array( 'black', 'red', 'green', 'blue', 'darkviolet', 'gold', 'deeppink', 'brown', 'bisque', 'darkgreen', 'yellow', 'darkblue', 'magenta', 'steelblue2' );
	protected $m_nameProperty;
	protected $m_nodeShape;
	protected $m_parentRelation;
	protected $m_wordWrapLimit;
	
	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::handleParameters()
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		$this->m_graphName = trim( $params['graphname'] );
		$this->m_graphSize = trim( $params['graphsize'] );
		
		$this->m_graphLegend = $params['graphlegend'];
		$this->m_graphLabel = $params['graphlabel'];
		
		$this->m_rankdir = strtoupper( trim( $params['arrowdirection'] ) );
		
		$this->m_graphLink = $params['graphlink'];
		$this->m_graphColor =$params['graphcolor'];
		
		$this->m_nameProperty = $params['nameproperty'] === false ? false : trim( $params['nameproperty'] );
		
		$this->m_parentRelation = strtolower( trim( $params['relation'] ) ) == 'parent';
		
		$this->m_nodeShape = $params['nodeshape'];
		$this->m_wordWrapLimit = $params['wordwraplimit'];
	}
	
	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		if ( !is_callable( 'renderGraphviz' ) ) {
			wfWarn( 'The SRF Graph printer needs the GraphViz extension to be installed.' );
			return '';
		}
		
		global $wgGraphVizSettings;
		$this->isHTML = true;

		$graphInput = "digraph $this->m_graphName {";
		if ( $this->m_graphSize != '' ) $graphInput .= "size=\"$this->m_graphSize\";";
		if ( $this->m_nodeShape ) $graphInput .=  "node [shape=$this->m_nodeShape];";
		$graphInput .= "rankdir=$this->m_rankdir;";		
		
		while ( $row = $res->getNext() ) {
			$graphInput .= $this->getGVForItem( $row, $outputmode );
		}
		
		$graphInput .= "}";
		
		// Calls renderGraphViz function from MediaWiki GraphViz extension
		$result = renderGraphviz( $graphInput );
		
		if ( $this->m_graphLegend && $this->m_graphColor ) {
			$arrayCount = 0;
			$arraySize = count( $this->m_graphColors );
			$result .= "<P>";
			
			foreach ( $this->m_labelArray as $m_label ) {
				if ( $arrayCount >= $arraySize ) {
					$arrayCount = 0;
				}				
				
				$color = $this->m_graphColors[$arrayCount];
				$result .= "<font color=$color>$color: $m_label </font><br />";
				
				$arrayCount += 1;
			}
			
			$result .= "</P>";
		}
		
		return $result;
	}

	/**
	 * Returns the GV for a single subject.
	 * 
	 * @since 1.5.4
	 * 
	 * @param array $row
	 * @param $outputmode
	 * 
	 * @return string
	 */
	protected function getGVForItem( array /* of SMWResultArray */ $row, $outputmode ) {	
		$segments = array();
		
		// Loop throught all fields of the record.
		foreach ( $row as $i => $resultArray ) {

			// Loop throught all the parts of the field value.
			while ( ( $object = $resultArray->getNextDataValue() ) !== false ) {
				$propName = $resultArray->getPrintRequest()->getLabel();
				$isName = $this->m_nameProperty ? ( $i != 0 && $this->m_nameProperty === $propName ) : $i == 0;
				
				if ( $isName ) {
					$name = $this->getWordWrappedText( $object->getShortText( $outputmode ), $this->m_wordWrapLimit );
				}
				
				if ( !( $this->m_nameProperty && $i == 0 ) ) {
					$segments[] = $this->getGVForDataValue( $object, $outputmode, $isName, $name, $propName );
				}
			}
		}

		return implode( "\n", $segments );
	}
	
	/**
	 * Returns the GV for a single SMWDataValue.
	 * 
	 * @since 1.5.4
	 * 
	 * @param SMWDataValue $object
	 * @param $outputmode
	 * @param boolean $isName Is this the name that should be used for the node?
	 * @param string $name
	 * @param string $labelName
	 * 
	 * @return string
	 */	
	protected function getGVForDataValue( SMWDataValue $object, $outputmode, $isName, $name, $labelName ) {
		$graphInput = '';
		$text = $object->getShortText( $outputmode );

		if ( $this->m_graphLink ) {
			$nodeLinkTitle = Title::newFromText( $text );
			$nodeLinkURL = $nodeLinkTitle->getLocalURL();
		}
		
		$text = $this->getWordWrappedText( $text, $this->m_wordWrapLimit );
		
		if ( $this->m_graphLink ) {
			$graphInput .= " \"$text\" [URL = \"$nodeLinkURL\"]; ";
		}

		if ( !$isName ) {
			$graphInput .= $this->m_parentRelation ? " \"$text\" -> \"$name\" " : " \"$name\" -> \"$text\" ";
			
			if ( $this->m_graphLabel && $this->m_graphColor ) {
				$graphInput .= ' [';

				if ( array_search( $labelName, $this->m_labelArray, true ) === false ) {
					$this->m_labelArray[] = $labelName;
				}
				
				$color = $this->m_graphColors[array_search( $labelName, $this->m_labelArray, true )];

				if ( $this->m_graphLabel ) {
					$graphInput .= "label=\"$labelName\"";
					if ( $this->m_graphColor ) $graphInput .= ",fontcolor=$color,";
				}
				
				if ( $this->m_graphColor ) {
					$graphInput .= "color=$color";
				}
				
				$graphInput .= ']';
	
			}
			
			$graphInput .= ';';
		}

		return $graphInput;
	}
	
	/**
	 * Returns the word wrapped version of the provided text. 
	 * 
	 * @since 1.5.4
	 * 
	 * @param string $text
	 * @param integer $charLimit
	 * 
	 * @return string
	 */
	protected function getWordWrappedText( $text, $charLimit ) {
		$charLimit = max( array( $charLimit, 1 ) );
		$segments = array();
		
		while ( strlen( $text ) > $charLimit ) {
			// Find the last space in the allowed range.
			$splitPosition = strrpos( substr( $text, 0, $charLimit ), ' ' );
			
			if ( $splitPosition === false ) {
				// If there is no space (lond word), find the next space.
				$splitPosition = strpos( $text, ' ' );
				
				if ( $splitPosition === false ) {
					// If there are no spaces, everything goes on one line.
					 $splitPosition = strlen( $text ) - 1;
				}
			}
			
			$segments[] = substr( $text, 0, $splitPosition + 1 );
			$text = substr( $text, $splitPosition + 1 );
		}
		
		$segments[] = $text;
		
		return implode( '\n', $segments );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::getName()
	 */
	public function getName() {
		return wfMsg( 'srf-printername-graph' );
	}	
	
	public function getParameters() {
		$params = parent::getParameters();
		
		$params['graphname'] = new Parameter( 'graphname', Parameter::TYPE_STRING, 'QueryResult' );
		$params['graphname']->setMessage( 'srf_paramdesc_graphname' );
		
		$params['graphsize'] = new Parameter( 'graphsize', Parameter::TYPE_INTEGER );
		$params['graphsize']->setMessage( 'srf_paramdesc_graphsize' );
		$params['graphsize']->setDefault( '', false );
		
		$params['graphlegend'] = new Parameter( 'graphlegend', Parameter::TYPE_BOOLEAN, false );
		$params['graphlegend']->setMessage( 'srf_paramdesc_graphlegend' );
		
		$params['graphlabel'] = new Parameter( 'graphlabel', Parameter::TYPE_BOOLEAN, false );
		$params['graphlabel']->setMessage( 'srf_paramdesc_graphlabel' );
		
		$params['graphlink'] = new Parameter( 'graphlink', Parameter::TYPE_BOOLEAN, false );
		$params['graphlink']->setMessage( 'srf_paramdesc_graphlink' );
		
		$params['graphcolor'] = new Parameter( 'graphcolor', Parameter::TYPE_BOOLEAN, false );
		$params['graphcolor']->setMessage( 'srf_paramdesc_graphcolor' );
		
		$params['arrowdirection'] = new Parameter( 'arrowdirection', Parameter::TYPE_STRING, 'LR', array( 'rankdir' ) );
		$params['arrowdirection']->setMessage( 'srf_paramdesc_rankdir' );
		$params['arrowdirection']->addCriteria( new CriterionInArray( 'LR', 'RL', 'TB', 'BT' ) );
		
		$params['nodeshape'] = new Parameter( 'nodeshape' );
		$params['nodeshape']->setDefault( false, false );
		$params['nodeshape']->setMessage( 'srf-paramdesc-graph-nodeshape' );
		$params['nodeshape']->addCriteria( new CriterionInArray( self::$NODE_SHAPES ) );
		
		$params['relation'] = new Parameter( 'relation' );
		$params['relation']->setDefault( 'child' );
		$params['relation']->setMessage( 'srf-paramdesc-graph-relation' );
		$params['relation']->addCriteria( new CriterionInArray( 'parent', 'child' ) );
		
		$params['nameproperty'] = new Parameter( 'nameproperty', Parameter::TYPE_STRING, '' );
		$params['nameproperty']->setMessage( 'srf-paramdesc-graph-nameprop' );
		$params['nameproperty']->setDefault( false, false );
		
		$params['wordwraplimit'] = new Parameter( 'wordwraplimit', Parameter::TYPE_INTEGER );
		$params['wordwraplimit']->setMessage( 'srf-paramdesc-graph-wwl' );
		$params['wordwraplimit']->setDefault( 25 );
		
		return $params;
	}
	
}
