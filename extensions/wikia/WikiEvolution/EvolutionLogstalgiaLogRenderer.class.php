<?php

//include("EvolutionAbstractLogRenderer.class.php");

class EvolutionLogstalgiaLogRenderer extends EvolutionAbstractLogRenderer {


	public function renderOneRow($row) {

		$renderedRow = ~~($row["timestamp"] / 3600) . '|' .$row["user_name"] . '|' ;

		if( $row["category"] ) {
			$renderedRow = $renderedRow . $row["category"] ;
		}

		$renderedRow = $renderedRow . $row["title"] . '|' . $row["title"] . '|' . $row["size"] . '|' ;

		if( $row["action"] == 'deleted' ) {
			$renderedRow = $renderedRow . '0|' ;
		} else {
			$renderedRow = $renderedRow . '1|' ;
		}

		$renderedRow = $renderedRow . $row["color"] . "\n" ;

		return $renderedRow;
	}


} // end of EvolutionLogstalgiaLogRenderer class


?>
