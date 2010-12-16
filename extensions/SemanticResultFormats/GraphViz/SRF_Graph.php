<?php
/**
 * Print query results as a graph.
 * @author Frank Dengler
 *
 */

/**
 * New implementation of SMW's printer for result in a graph.
 * This SMW printer requires the mediawiki graphviz extention.
 * 
 * @note AUTOLOADED
 */
if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class SRFGraph extends SMWResultPrinter {
	protected $m_graphName ='QueryResult';
	protected $m_graphLabel = false;
	protected $m_graphColor = false;
	protected $m_graphLegend = false;
	protected $m_graphLink = false;
	protected $m_rankdir="LR";
	protected $m_graphSize="";
	protected $m_labelArray = array();
	protected $m_graphColors = array("black","red","green","blue","darkviolet","gold","deeppink","brown","bisque","darkgreen","yellow","darkblue","magenta","steelblue2");

	protected function readParameters($params,$outputmode) {

		SMWResultPrinter::readParameters($params,$outputmode);

		if (array_key_exists('graphname', $params)) {

			$this->m_graphName = trim($params['graphname']);

		}
		if (array_key_exists('graphsize', $params)) {

			$this->m_graphSize = trim($params['graphsize']);

		}
		if (array_key_exists('graphlegend', $params)) {

			if (strtolower(trim($params['graphlegend']))=='yes') $this->m_graphLegend = true;

		}

		if (array_key_exists('graphlabel', $params)) {

			if (strtolower(trim($params['graphlabel']))=='yes') $this->m_graphLabel = true;

		}
		if (array_key_exists('rankdir', $params)) {

			$this->m_rankdir = strtoupper(trim($params['rankdir']));

		}
		if (array_key_exists('graphlink', $params)) {

			if (strtolower(trim($params['graphlink']))=='yes') $this->m_graphLink = true;

		}
		if (array_key_exists('graphcolor', $params)) {

			if (strtolower(trim($params['graphcolor']))=='yes') $this->m_graphColor = true;

		}

	}
	protected function getResultText($res, $outputmode) {
	$wgGraphVizSettings = new GraphVizSettings;
	$this->isHTML = true;

    $key=0;
	// Create text graph
	$graphInput='';
	$legendInput='';

		$graphInput .= "digraph $this->m_graphName {";
		if ($this->m_graphSize!='') $graphInput .= "size=\"$this->m_graphSize\";";
		$graphInput .= "rankdir=$this->m_rankdir;";
	while ( $row = $res->getNext() ) {

			$firstcol = true;

			foreach ($row as $field) {

				while ( ($object = $field->getNextObject()) !== false ) {

					$text = $object->getShortText($outputmode);

					if ($firstcol) {
						$firstcolvalue = $object->getShortText($outputmode);

					}

					if ($this->m_graphLink==true){
						$nodeLinkTitle = Title::newFromText($text);
						$nodeLinkURL = $nodeLinkTitle->getLocalURL();

						$graphInput .= " \"$text\" [URL = \"$nodeLinkURL\"]; ";
					}

					if (!$firstcol) {
					$graphInput .= " \"$firstcolvalue\" -> \"$text\" ";
						if (($this->m_graphLabel==true) || ($this->m_graphColor==true)){
							$graphInput .= " [";
							$req = $field->getPrintRequest();
							$labelName = $req->getLabel();

							if (array_search($labelName,$this->m_labelArray,true)===false) {
								$this->m_labelArray[]=$labelName;
							}
								$key = array_search($labelName,$this->m_labelArray,true);
								$color = $this->m_graphColors[$key];

							if ($this->m_graphLabel==true) {
								$graphInput .= "label=\"$labelName\"";
								if ($this->m_graphColor==true) $graphInput .= ",fontcolor=$color,";
							}
							if ($this->m_graphColor==true) {

								$graphInput .= "color=$color";
							}
							$graphInput .= "]";

						}
						$graphInput .= ";";

					}
				}

				$firstcol = false;
			}

		}

		$graphInput .= "}";
		// Calls renderGraphViz function from MediaWiki GraphViz extension
		$result = renderGraphviz($graphInput);
		if (($this->m_graphLegend==true) && ($this->m_graphColor==true)) {
			$arrayCount = 0;
			$result .= "<P>";
			foreach ($this->m_labelArray as $m_label) {
				$color = $this->m_graphColors[$arrayCount];
				$result .= "<font color=$color>$color: $m_label </font><br />";
				$arrayCount = $arrayCount +1;
			}
			$result .= "</P>";
		}
		return $result;
	}
}
