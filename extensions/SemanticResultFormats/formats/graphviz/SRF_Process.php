<?php
/*******************************************************************************
*	This file contains the Process Printer for SemanticResultFormats
*   (https://www.mediawiki.org/wiki/Extension:Semantic_Result_Formats)
*
*	Copyright (c) 2008 - 2009 Frank Dengler and Hans-Jörg Happel
*
*   Process Printer is free software: you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation, either version 3 of the License, or
*   (at your option) any later version.
*
*   Process Printer is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with Process Printer. If not, see <http://www.gnu.org/licenses/>.
*******************************************************************************/

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * This is a contribution to Semtantic Result Formats (SRF) which are an
 * extension of Semantic MediaWiki (SMW) which in turn is an extension
 * of MediaWiki
 *
 * SRF defines certain "printers" to render the results of SMW semantic
 * "ASK"-queries. Some of these printers make use of the GraphViz/dot
 * library (which is wrapped by a separate MediaWiki extension).
 *
 * The purpose of this extension, is to render results of ASK-Queries
 * (e.g. Classes with Attributes) as GraphViz-layouted process graphs
 *
 *
 * @author Frank Dengler
 * @author Hans-Jörg Happel
 * @ingroup SemanticResultFormats
 *
 * @note AUTOLOADED
 */

// global variable defining picture path

$srfgPicturePath = "formats/graphviz/images/";



class SRFProcess extends SMWResultPrinter {

	// configuration variables
	protected $m_graphValidation 	= false;
	protected $m_isDebugSet 		= false;
	protected $m_processCategory	= 'Process'; // Category for processes - required for rendering compound nodes

	// internal variables
	protected $m_process;	// process to be rendered

	/**
	 * (non-PHPdoc)
	 * @see SMWResultPrinter::handleParameters()
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
		
		// init process graph instance
		$this->m_process = new ProcessGraph();
		
		$this->m_process->setGraphName( trim( $params['graphname'] ) );
		$this->m_process->setGraphSize( trim( $params['graphsize'] ) );
		$this->m_process->setClusterColor( trim( $params['clustercolor'] ) );
		$this->m_process->setRankdir( strtoupper( trim( $params['rankdir'] ) ) );
		$this->m_process->setHighlightNode( trim( $params['highlight'] ) );
		$this->m_process->setHighlightColor( trim( $params['highlightcolor'] ) );
		$this->m_process->setHighlightColor( trim( $params['redlinkcolor'] ) );
		
		$this->m_process->setShowRoles( $params['showroles'] );
		$this->m_process->setShowStatus( $params['showstatus'] );
		$this->m_process->setShowRessources( $params['showresources'] );
		$this->m_process->setShowDiscussion( $params['showdiscussion'] );
		$this->m_process->setShowRedLinks( $params['showredlinks'] );
		$this->m_process->setShowCompound( $params['showcompound'] );
		
		$this->m_processCategory = $params['processcat'];
		$this->m_isDebugSet = $params['debug'];
		$this->m_graphValidation = $params['graphvalidation'];
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
			'default' => '',
		);

		$params['rankdir'] = array(
			'default' => 'TB',
		);

		$params['graphsize'] = array(
			'default' => '',
		);

		$params['clustercolor'] = array(
			'default' => 'lightgrey',
		);

		$params['highlight'] = array(
			'default' => '',
		);

		$params['highlightcolor'] = array(
			'default' => 'blue',
		);

		$params['redlinkcolor'] = array(
			'default' => 'red',
		);

		$params['processcat'] = array(
			'default' => 'Process',
		);

		$params['showroles'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['showstatus'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['showresources'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['showdiscussion'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['showredlinks'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['showcompound'] = array(
			'type' => 'boolean',
			'default' => true,
		);

		$params['debug'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		$params['graphvalidation'] = array(
			'type' => 'boolean',
			'default' => false,
		);

		return $params;
	}

	/**
	 *	This method renders the result set provided by SMW according to the printer
	 *
	 *  @param res				SMWQueryResult, result set of the ask query provided by SMW
	 *  @param outputmode		?
	 *  @return				String, rendered HTML output of this printer for the ask-query
	 *
	 */
	protected function getResultText( SMWQueryResult $res, $outputmode ) {
		if ( !is_callable( 'renderGraphviz' ) ) {
			wfWarn( 'The SRF Graph printer needs the GraphViz extension to be installed.' );
			return '';
		}

		global $wgContLang; // content language object

		//
		//	GraphViz settings
		//
		global $wgGraphVizSettings;
		$this->isHTML 		= true;


		//
		//	Iterate all rows in result set
		//

		$row = $res->getNext(); // get initial row (i.e. array of SMWResultArray)

		while ( $row !== false ) {
			/* SMWDataItem */ $subject = $row[0]->getResultSubject(); // get Subject of the Result
			// creates a new node if $val has type wikipage
			if ( $subject->getDIType() == SMWDataItem::TYPE_WIKIPAGE ) {
				$wikiPageValue = new SMWWikiPageValue( '_wpg' );
				$wikiPageValue->setDataItem( $subject );
				$node = $this->m_process->makeNode( $wikiPageValue->getShortWikiText(), $wikiPageValue->getShortWikiText() );
			}

     		//
			//	Iterate all colums of the row (which describe properties of the proces node)
			//

			// FIXME: this does not work with SMW >= 1.6, see
			// https://bugzilla.wikimedia.org/show_bug.cgi?id=35003

			// FIXME: got _a bit_ of redundancy here looks like... :/

			foreach ( $row as $field ) {

				// check column title
				$req = $field->getPrintRequest();
				switch ( ( strtolower( $req->getLabel() ) ) ) {



					case strtolower( $wgContLang->getNsText( NS_CATEGORY ) ):

						foreach ( $field->getContent() as $value ) {
							$val = $value->getShortWikiText();
							if ( $val == ( $wgContLang->getNsText( NS_CATEGORY ) . ':' . $this->m_processCategory ) ) $node->setAtomic( false );
						}

	 					break;

	 				case "haslabel":
	 					$value = current($field->getContent()); // save only the first
							if (($value !== false)) {
							$val = $value->getLongWikiText();
							if ($this->m_process->getUseOtherLabels()) {
								$val = str_replace("&","and",$val);
								$node->setLabel($val);
							}
						}
						break;

					case "hasrole":
						foreach ( $field->getContent() as $value ) {
							$val = $value->getShortWikiText();
							$role = $this->m_process->makeRole( $val, $val );
							$node->addRole( $role );
						}
						break;

					case "usesresource":
						foreach ( $field->getContent() as $value ) {
							$val = $value->getShortWikiText();
							$xres = $this->m_process->makeRessource( $val, $val );
							$node->addUsedRessource( $xres );
						}
						break;

					case "producesresource":
						foreach ( $field->getContent() as $value ) {
							$val = $value->getShortWikiText();
							$xres = $this->m_process->makeRessource( $val, $val );
							$node->addProducedRessource( $xres );
						}
						break;

					case "hassuccessor":

						if ( count( $field->getContent() ) > 1 ) {

							// SplitParallel
							$edge = new SplitParallelEdge();
							$edge->setFrom( $node );
							foreach ( $field->getContent() as $value ) {
								$val = $value->getShortWikiText();
								$edge->addTo( $this->m_process->makeNode( $val, $val ) );
							}

						} else {

							// Sequence
							foreach ( $field->getContent() as $value ) {
								$val = $value->getShortWikiText();
								$edge = new SequentialEdge();
								$edge->setFrom( $node );
								$edge->setTo( $this->m_process->makeNode( $val, $val ) );
							}
						}

						break;

					case "hasorsuccessor":

						if ( count( $field->getContent() ) > 0 ) {

							// SplitExclusiveOr
							$edge = new SplitExclusiveOrEdge();
							$edge->setFrom( $node );
							foreach ( $field->getContent() as $value ) {
								$val = $value->getShortWikiText();
								$edge->addTo( $this->m_process->makeNode( $val, $val ) );
							}
						}

						break;

					case "hascontruesuccessor":

						if ( count( $field->getContent() ) > 0 ) {

							// SplitConditional
							if ( !isset( $cond_edge ) ) {
								$cond_edge = new SplitConditionalOrEdge();
								$cond_edge->setFrom( $node );
							}

							// should be only one
							foreach ( $field->getContent() as $value ) {
								$val = $value->getShortWikiText();
								$cond_edge->setToTrue( $this->m_process->makeNode( $val, $val ) );
							}

						}

						break;

					case "hasconfalsesuccessor":

						if ( count( $field->getContent() ) > 0 ) {

					 		// SplitConditional
							if ( !isset( $cond_edge ) ) {
								$cond_edge = new SplitConditionalOrEdge();
								$cond_edge->setFrom( $node );
							}

							// should be only one
							foreach ( $field->getContent() as $value ) {
								$val = $value->getShortWikiText();
								$cond_edge->setToFalse( $this->m_process->makeNode( $val, $val ) );
							}
						}

						break;

					case "hascondition":

						if ( count( $field->getContent() ) > 0 ) {

					 		// SplitConditional
							if ( !isset( $cond_edge ) ) {
								$cond_edge = new SplitConditionalOrEdge();
								$cond_edge->setFrom( $node );
							}

							// should be only one
							foreach ( $field->getContent() as $value ) {
								$val = $value->getShortWikiText();
								$cond_edge->setConditionText( $val );

							}
						}

						break;

					case "hasstatus":

						// should be only one
						foreach ( $field->getContent() as $value ) {
							$val = $value->getShortWikiText();
							$node->setStatus( $val );
						}

						break;

					default:

						// TODO - redundant column in result

	 			}
			}

			// reset row variables
			unset( $node );
			unset( $cond_edge );

		  	$row = $res->getNext();		// switch to next row
		}

		//
		// generate graphInput
		//
		$graphInput = $this->m_process->getGraphVizCode();

		//
		// render graphViz code
		//
		$result = renderGraphviz( $graphInput );

		$debug = '';
		if ( $this->m_isDebugSet ) $debug = '<pre>' . $graphInput . '</pre>';

		return $result . $debug;
	}
}

/**
 * Class representing a process graph
 */
class ProcessGraph {

	// configuration variables
	protected $m_graphName 		= '';
	protected $m_rankdir		= 'TB';
	protected $m_graphSize		= '';
	protected $m_clusterColor	= 'lightgrey';
	protected $m_showStatus		= false;	// should status be rendered?
	protected $m_showRoles		= false;	// should roles be rendered?
	protected $m_showRessources	= false;	// should ressources be rendered?
	protected $m_showDiscussion	= false;	// should discussion be rendered?
	protected $m_highlightNode	= '';		// node to be highlighted
	protected $m_highlightColor = 'blue';	// highlight font color
	protected $m_showRedLinks	= false;	// check and highlight red links?
	protected $m_redLinkColor	= 'red';	// red link font color
	protected $m_showCompound	= true;		// highlight compound nodes (=subprocesses)

	public $m_useHtmlNodes = true;			// Set to false if you do not want to use HTML table nodes

	// instance variables
	protected $m_nodes		= array();	// list of all nodes
	protected $m_startnodes	= array();	// list of start nodes
	protected $m_endnodes	= array();	// list of end nodes
	protected $m_ressources	= array();	// list of ressources
	protected $m_roles		= array();	// list of roles
	protected $m_errors		= array();	// list of errors


	/**
	 * This method should be used for getting new or existing nodes
	 * If a node does not exist yet, it will be created
	 *
	 * @param $id			string, node id
	 * @param $label		string, node label
 	 * @return				Object of type ProcessNode
	 */
	public function makeNode( $id, $label ) {
		// check if node exists
		if ( isset( $this->m_nodes[$id] ) ) {
			// take existing node
			$node = $this->m_nodes[$id];

		} else {
			// create new node

			$node = new ProcessNode();
			$node->setId( $id );
			$node->setLabel( $label );
			$node->setProcess( $this );

			// is actual node name the same like the one to highlight?
			if ( strcasecmp( $id , $this->m_highlightNode ) == 0 ) {
				$node->setFontColor( $this->m_highlightColor );
			}

			// is the node a red link (i.e. corresponding wiki page does not yet exist)?
			if ( $this->m_showRedLinks ) {
				$title = Title::newFromDBkey( $id );
				if ( isset( $title ) && ( !$title->exists() ) ) $node->setFontColor( $this->m_redLinkColor );
			}

			// add new node to process
			$this->m_nodes[$id] = $node;
		}

		return $node;

	}

	public function makeRole( $id, $label ) {
		// check if role exists
		if ( isset( $this->m_roles[$id] ) ) {
			// take existing roles
			$role = $this->m_roles[$id];

		} else {
			$role = new ProcessRole();
			$role->setId( $id );
			$role->setLabel( $label );

			// add new role to process
			$this->m_roles[$id] = $role;
		}

		return $role;

	}

	public function makeRessource( $id, $label ) {
		// check if res exists
		if ( isset( $this->m_ressources[$id] ) ) {
			// take existing res
			$res = $this->m_ressources[$id];

		} else {
			$res = new ProcessRessource();
			$res->setId( $id );
			$res->setLabel( $label );

			// add new res to process
			$this->m_ressources[$id] = $res;

		}

		return $res;

	}

	public function getEndNodes() {
		if ( count( $this->m_endnodes ) == 0 ) {
			foreach ( $this->m_nodes as $node ) {
				if ( count( $node->getSucc() ) == 0 ) $this->m_endnodes[] = $node;
			}
		}

		return $this->m_endnodes;
	}

	public function getStartNodes() {

		if ( count( $this->m_startnodes ) == 0 ) {
			foreach ( $this->m_nodes as $node ) {
				if ( count( $node->getPred() ) == 0 ) {
					$this->m_startnodes[] = $node;
				}
			}
		}

		return $this->m_startnodes;
	}

	public function setShowStatus( $show ) {
		$this->m_showStatus = $show;
	}

	public function getShowStatus() {
		return $this->m_showStatus;
	}

	public function setShowRoles( $show ) {
		$this->m_showRoles = $show;
	}

	public function getShowRoles() {
		return $this->m_showRoles;
	}

	public function setShowCompound( $show ) {
		$this->m_showCompound = $show;
	}

	public function getShowCompound() {
		return $this->m_showCompound;
	}

	public function setShowDiscussion($show){
		$this->m_showDiscussion = $show;
	}

	public function getShowDiscussion(){
		return $this->m_showDiscussion;
	}

	public function setShowRessources( $show ) {
		$this->m_showRessources = $show;
	}

	public function getShowRessources() {
		return $this->m_showRessources;
	}

	public function setGraphName( $name ) {
		$this->m_graphName = $name;
	}

	public function getGraphName() {
		if ( $this->m_graphName == '' ) $this->m_graphName = 'ProcessQueryResult' . rand( 1, 99999 );
		return $this->m_graphName;
	}

	public function setGraphSize( $size ) {
		$this->m_graphSize = $size;
	}

	public function setRankdir( $rankdir ) {
		$this->m_rankdir = $rankdir;
	}

	public function setClusterColor( $color ) {
		$this->m_clusterColor = $color;
	}

	public function setHighlightColor( $color ) {
		$this->m_highlightColor = $color;
	}

	public function setRedLinkColor( $color ) {
		$this->m_redLinkColor = $color;
	}

	public function setShowRedLinks( $show ) {
		$this->m_showRedLinks = $show;
	}

	public function setHighlightNode( $name ) {
		$this->m_highlightNode = $name;
	}

	public function addError( $error ) {
		$this->m_errors[] = $error;
	}

	public function getErrors() {
		return $this->m_errors;
	}

	public function getGraphVizCode() {
		//
		// header
		//
		$res = 'digraph ' . $this->getGraphName() . ' {

	ranksep="0.5";';
		if ( $this->m_graphSize != '' ) $res .= '
	size="' . $this->m_graphSize . '";';
		$res .= '
	rankdir=' . $this->m_rankdir . ';
	';

		//
		// add startnodes
		//
		// TODO I18N
		$res .= '
	{rank=source; "Start";}
		"Start"[shape=box,label="Start",style=filled,color=green];';

		foreach ( $this->getStartNodes() as $node ) {
			$res .= '
		"Start" -> "' . $node->getId() .'":port1:n;';
		}

		$res .= '
		';

		//
		// add endnodes
		//
		// TODO I18N
		$res .= '
	{rank=sink; "End"; }
		"End"[shape=box,label="End",style=filled,color=green];';

		foreach ( $this->getEndNodes() as $node ) {
			$res .= '
		"' . $node->getId() . '":port1:s -> "End";';
		}

		$res .= '

	';

		//
		// add subnodes
		//
		foreach ( $this->m_nodes as $node ) {
			$res .= $node->getGraphVizCode();
		}

		//
		// add final stuff
		//
		$res .=
	'
	}';

		return $res;

	}

}

abstract class ProcessElement {

	// TODO I18N
	private $m_id		 = 'no_id';
	private $m_label	 = 'unlabeled';
	private $m_uid;

	public function getUUID(){
		if (!isset($this->m_uid)){
			$this->m_uid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
				mt_rand(0, 0x0fff) | 0x4000,
				mt_rand(0, 0x3fff) | 0x8000,
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
		}

		return $this->m_uid;
	}
	public function getId() {
		return $this->m_id;
	}

	public function setId( $id ) {
		$this->m_id = $id;
	}

	public function getLabel() {
		return $this->m_label;
	}

	public function setLabel( $label ) {
		$this->m_label = $label;
	}

}

class ProcessRessource extends ProcessElement {

	private $m_usedby		= array();
	private	$m_producedby	= array();

	public function getProducers() {
		return $this->m_producedby;
	}

	public function getUsers() {
		return $this->m_usedby;
	}

	public function addProducer( $node ) {
		$this->m_producedby[] = $node;
	}

	public function addUser( $node ) {
		$this->m_usedby[] = $node;
	}

}

class ProcessRole extends ProcessElement {

	private $m_nodes	= array();

	public function getNodes() {
		return $this->m_nodes;
	}

	public function addNode( $node ) {
		$this->m_nodes[] = $node;
	}

}

/**
 * Class reperesning a process node
 */
class ProcessNode extends ProcessElement {

	private $m_is_startnode	= false;	// explicit statement if this is a start node
	private $m_is_endnode	= false;	// explicit statement if this is a termination node
	private $m_status;					// status value
	private $m_is_atomic	= true;		// set false if this is a compound node

	private $m_process;					// reference to parent process

	private $m_fontColor = '';			// font color to render

	private $m_usedressources 		= array();	// ressources used by this node
	private $m_producedressources 	= array();	// ressources produces by this node
	private $m_roles				= array();	// roles related to this node

	private $m_edgeout;					// outgoing edge (can be only one)
	private	$m_edgesin 	=	array();	// incoming edges (can be many)

	public function setStatus( $status ) {
		$this->m_status = $status;
	}

	public function getStatus() {
		return $this->m_status;
	}

	public function setFontColor( $color ) {
		$this->m_fontColor = $color;
	}

	public function setProcess( $proc ) {
		$this->m_process =  $proc;
	}

	public function getProcess() {
		return $this->m_process;
	}

	public function getPred() {
		$res = array();

		foreach ( $this->m_edgesin as $edge ) {
			$res = array_merge( $res, $edge->getPred() );
		}

		return $res;
	}

	public function getSucc() {
		$res = array();

		if ( isset( $this->m_edgeout ) ) {
			$res = $this->m_edgeout->getSucc();
		}

		return $res;
	}

	public function setEdgeOut( $edge ) {
		$this->m_edgeout = $edge;
	}

	public function getEdgeOut() {
		return $this->m_edgeout;
	}

	public function addEdgeIn( $edge ) {
		$this->m_edgesin[] = $edge;
	}

	public function getEdgesIn() {
		return $this->m_edgesin;
	}

	public function addRole( $role ) {
		$this->m_roles[] = $role;
		$role->addNode( $this );
	}

	public function getRoles() {
		return $this->m_roles;
	}

	public function addUsedRessource( $res ) {
		$this->m_usedressources[] = $res;
		$res->addUser( $this );
	}

	public function getUsedRessources() {
		return $this->m_usedressources;
	}

	public function addProducedRessource( $res ) {
		$this->m_producedressources[] = $res;
		$res->addProducer( $this );
	}

	public function getProducedRessources() {
		return $this->m_producedressources;
	}

	public function isAtomic() {
		return $this->m_is_atomic;
	}

	public function setAtomic( $atomic ) {
		$this->m_is_atomic = $atomic;
	}

	public function getGraphVizCode() {
		global $IP, $srfgPicturePath, $srfgIP;
		//
		// show node status
		//
		$status = '';
		if ( $this->getProcess()->getShowStatus() ) {

			if ( file_exists( $IP . "/images/p000.png" ) ) {
				$PicturePath = $IP . "/images/";
			} elseif ( file_exists( $srfgIP . "/formats/graphviz/images/p000.png" ) ) {
				$PicturePath = $srfgIP . "/formats/graphviz/images/";
			} else {
				$PicturePath = $IP . $srfgPicturePath;
			}
			// $color = 'grey' . $this->getStatus();
			// $color = 'grey' . rand(1, 100);
			// $status = ',style=filled,color=' . $color;
			if ( $this->getStatus() != '' ) {
				if ( $this->getStatus() < 25 ) {
					$status = ' HREF="[[' . $this->getId() . ']]" TOOLTIP="status '.$this->getStatus().'%"><IMG SRC="' . $PicturePath .'p000.png" /';
				} elseif ( $this->getStatus() < 50 ) {
					$status = ' HREF="[[' . $this->getId() . ']]" TOOLTIP="status '.$this->getStatus().'%"><IMG SRC="' . $PicturePath .'p025.png" /';
				} elseif ( $this->getStatus() < 75 ) {
					$status = ' HREF="[[' . $this->getId() . ']]" TOOLTIP="status '.$this->getStatus().'%"><IMG SRC="' . $PicturePath .'p050.png" /';
				} elseif ( $this->getStatus() < 100 ) {
					$status = ' HREF="[[' . $this->getId() . ']]" TOOLTIP="status '.$this->getStatus().'%"><IMG SRC="' . $PicturePath .'p075.png" /';
				} elseif ( $this->getStatus() == 100 ) {
					$status = ' HREF="[[' . $this->getId() . ']]" TOOLTIP="status '.$this->getStatus().'%"><IMG SRC="' . $PicturePath .'p100.png" /';
				}
			}

		}

	//
		// show discussion page
		//
		$discussion = '';
		if ( $this->getProcess()->getShowDiscussion() ) {

			if ( file_exists( $IP . "/images/discuss_icon.png" ) ) {
				$PicturePath = $IP . "/images/";
			} elseif ( file_exists( $srfgIP . "/formats/graphviz/images/discuss_icon.png" ) ) {
				$PicturePath = $srfgIP . "/formats/graphviz/images/";
			} else {
				$PicturePath = $IP . $srfgPicturePath;
			}
			$discussionTitle = Title::newFromText('Talk:'.$this->getId().'');
			if ($discussionTitle->isKnown()) {
				$discussion = ' HREF="[[Talk:' . $this->getId() . ']]" TOOLTIP="Talk:' . $this->getId() . '"><IMG SRC="' . $PicturePath .'discuss_icon.png" /';
			} else {
				$discussion = ' HREF="[[Talk:' . $this->getId() . ']]" TOOLTIP="Talk:' . $this->getId() . '"><IMG SRC="' . $PicturePath .'discuss_icon_grey.png" /';
			}


		}

		// use highlight color if set (either CURRENTPAGE or REDLINK highlighting - see ProcessGraph::makeNode()
		$high = '';
		if ( $this->m_fontColor !== '' ) {
			$high = ',fontcolor=' . $this->m_fontColor;
		}

		// insert icon for non-atomic nodes (i.e. subprocesses)
		$compound = '<TR><TD ALIGN="LEFT" BORDER="0" WIDTH="20px">';
		if ($this->getProcess()->getShowCompound()){
			if ( file_exists( $IP . "/images/subprocess.png" ) ) {
				$PicturePath = $IP . "/images/";
			} elseif ( file_exists( $srfgIP . "/formats/graphviz/images/subprocess.png" ) ) {
				$PicturePath = $srfgIP . "/formats/graphviz/images/";
			} else {
				$PicturePath = $IP . $srfgPicturePath;
			}
			if (!$this->isAtomic()) $compound = '<TR><TD ALIGN="LEFT" BORDER="0" WIDTH="20px" HREF="[['. $this->getId() . ']]" TOOLTIP="sub process"><IMG SRC="' . $PicturePath .'subprocess.png"/>';
		}



		//
		// render node itself
		//
		if ($this->m_process->m_useHtmlNodes){
			$res =
			'"' . $this->getId() . '" [shape=plaintext,label=<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">' . $compound . '</TD><TD BORDER="0" WIDTH="80%"></TD><TD ALIGN="RIGHT" BORDER="0" WIDTH="20px"' . $status . '></TD><TD ALIGN="RIGHT" BORDER="0" WIDTH="20px"' . $discussion . '></TD></TR><TR><TD COLSPAN="4" PORT="port1" HREF="[[' . $this->getId() . ']]" TOOLTIP="' . $this->getLabel() .'"><FONT' . $high .'>' . $this->getLabel() . '</FONT></TD> </TR></TABLE>>];
			';
		} else {
			$res =
			'"' . $this->getId() . '"[label="' . $this->getLabel() . '",shape=rect, height=1.5, URL="[[' . $this->getId() . ']]"];
			';
		}

		//
		// render outgoing node
		//
		if ( isset( $this->m_edgeout ) ) $res .= $this->m_edgeout->getGraphVizCode();


		//
		// show cluster for roles and ressources
		//
		$rrcluster = false;
		$rrcode = 'subgraph "cluster_role' . rand( 1, 9999 ) . '" { style=filled;color=lightgrey;';

		// show roles
		if ( $this->getProcess()->getShowRoles() ) {

			foreach ( $this->getRoles() as $role ) {
				$rrcluster = true;
				$rrcode .= '
				"' . $role->getId() . '"[label="' . $role->getLabel() . '",shape=doubleoctagon, color=red, URL="[[' . $role->getId() . ']]"];
				"' . $role->getId() . '" -> "' . $this->getId() . '":port1 [color=red,arrowhead = none,constraint=false];
				';

			}
		}

		if ( $this->getProcess()->getShowRessources() ) {

			foreach ( $this->getUsedRessources() as $xres ) {
				$rrcluster = true;
				$rrcode .= '
			"' . $xres->getId() . '"[label="' . $xres->getLabel() . '",shape=folder, color=blue, URL="[[' . $xres->getId() . ']]"];
			"' . $xres->getId() . '" -> "' . $this->getId() . '":port1 [color=blue,constraint=false];
				';
			}

			foreach ( $this->getProducedRessources() as $xres ) {
				$rrcluster = true;
				$rrcode .= '
			"' . $xres->getId() . '"[label="' . $xres->getLabel() . '",shape=folder, color=blue, URL="[[' . $xres->getId() . ']]"];
			"' . $this->getId() . '":port1 -> "' . $xres->getId() . '" [color=blue,constraint=false];
				';
				}

		}

		if ( $rrcluster ) $res .= $rrcode . '}';

		$res .= '
	';

		return $res;
	}

}


/**
 * Abstract base class for edges in a process graph
 */
abstract class ProcessEdge{

	private $m_id;
	private $m_uid;

	public function getId(){
		if (!isset($this->m_id)){
			$this->m_id = 'edge' . rand(1, 99999);
		}

		return $this->m_id;
	}

	public function getUUID(){
		if (!isset($this->m_uid)){
			$this->m_uid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    	mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
    	mt_rand(0, 0x0fff) | 0x4000,
    	mt_rand(0, 0x3fff) | 0x8000,
    	mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
		}

		return $this->m_uid;
	}

	abstract public function getSucc();
	abstract public function getPred();

	abstract public function getGraphVizCode();
}

abstract class SplitEdge extends ProcessEdge{

	protected $m_from;
	protected $m_to 	= array();

	public function setFrom($node){
		$this->m_from = $node;
		$node->setEdgeOut($this);
	}

	public function addTo($node){
		$this->m_to[] = $node;
		$node->addEdgeIn($this);
	}

	public function getPred(){
		return array($this->m_from);
	}

	public function getSucc(){
		return $this->m_to;
	}

}

class SplitConditionalOrEdge extends ProcessEdge{

	protected $m_from;
	protected $m_to_true;
	protected $m_to_false;
	protected $m_con_text = 'empty_condition';

	public function getSucc(){
		return array($this->m_to_false, $this->m_to_true);
	}

	public function getPred(){
		return array($this->m_from);
	}

	public function setFrom($node){
		$this->m_from = $node;
		$node->setEdgeOut($this);
	}

	public function setToFalse($node){
		$this->m_to_false = $node;
		$node->addEdgeIn($this);
	}

	public function setToTrue($node){
		$this->m_to_true = $node;
		$node->addEdgeIn($this);
	}

	public function setConditionText($cond){
		$this->m_con_text = $cond;
	}

	public function getGraphVizCode(){

		$p = $this->m_from;

		if ((!isset($this->m_from)) || (!isset($this->m_to_false)) || (!isset($this->m_to_true))){

			echo "error with SplitConditionalOrEdge"; // TODO
			exit;
		}


		$res =
	'subgraph "clus_' . $this->getId() . '" {
		';

		// cond-Shape
		$con = 'con' .  rand(1, 99999);
		$res .=
		'"'. $con . '"[shape=diamond,label="' . $this->m_con_text . '",style=filled,color=skyblue];
		"' . $p->getId() . '":port1:s -> "'. $con . '";
		';

		// True Succ
		$res .=
		'"' . $this->m_to_true->getId() . '" [URL = "[['. $this->m_to_true->getId() . ']]"];
		';

		$res .=
		'"'. $con .'" -> "' . $this->m_to_true->getId() .'":port1:n [label="true"];
		';

		// False Succ
		$res .=
		'"' . $this->m_to_false->getId() . '" [URL = "[['. $this->m_to_false->getId() . ']]"];
		';

		$res .=
		'"'. $con .'" -> "' . $this->m_to_false->getId() .'":port1:n [label="false"];';


		$res .= '
	}
	';

		return $res;
	}

}

class SplitExclusiveOrEdge extends SplitEdge{

	public function getGraphVizCode(){
		global $srfgShapeStyle;
		$p = $this->getPred();
		$p = $p[0];
		if ($srfgShapeStyle=='') $srfgShapeStyle="box";
		$res =
	'subgraph "clus_' . $this->getId() . '" {
		';

		// add OR-Shape
		$orx = 'or' .  rand(1, 99999);
		$res .=
		'"'. $orx . '"[shape=' . $srfgShapeStyle . ',label="+",style=filled,color=gold];
		"' . $p->getId() . '":port1:s -> "'. $orx . '";
		';

		foreach ($this->getSucc() as $s){
			$res .=
		'"' . $s->getId() . '" [URL="[['. $s->getId() . ']]"];
		';

			$res .=
		'"'. $orx .'" -> "' . $s->getId() .'":port1:n;
		';
		}

		$res .= '
	}
	';

		return $res;
	}

}

class SplitParallelEdge extends SplitEdge{


	public function getGraphVizCode(){
		global $srfgShapeStyle;
		if ($srfgShapeStyle=='') $srfgShapeStyle="box";
		$p = $this->getPred();
		$p = $p[0];

		$res =
	'subgraph "clus_' . $this->getId() . '" {
		';

		// add AND-Shape
		$and = 'and' .  rand(1, 99999);
		$res .=
		'"'. $and . '"[shape=' . $srfgShapeStyle . ',label="||",style=filled,color=palegreen];
		"' . $p->getId() . '":port1:s -> "'. $and . '";
		';

		foreach ($this->getSucc() as $s){
			$res .=
		'"' . $s->getId() . '" [URL = "[['. $s->getId() . ']]"];
		';

			$res .=
		'"'. $and .'" -> "' . $s->getId() .'":port1:n;
		';
		}

		$res .= '
	}
	';

		return $res;
	}

}

class SequentialEdge extends ProcessEdge{

	private $m_from;
	private $m_to;

	public function setFrom($node){
		$this->m_from = $node;
		$node->setEdgeOut($this);
	}

	public function setTo($node){
		$this->m_to = $node;
		$node->addEdgeIn($this);
	}

	public function getPred(){
		return array($this->m_from);
	}

	public function getSucc(){
		return array($this->m_to);
	}

	public function getGraphVizCode(){

		$p = $this->m_from;
		$s = $this->m_to;

		$res =
	'subgraph "clus_' . $this->getId() . '" {
		';

		$res .=
		'"' . $s->getId() . '" [URL = "[['. $s->getId() . ']]"];
		';

		$res .=
		'"'. $p->getId() .'":port1:s -> "' . $s->getId() .'":port1:n;';

		$res .= '
	}
	';

		return $res;
	}

}