<?php

class EvolutionGourceLogRenderer extends EvolutionAbstractLogRenderer {


	public function renderOneRow($row) {

		$renderedRow = $row["timestamp"] . '|' .$row["user_name"] . '|' ;

		if( $row["action"] == 'added' ) {
			$renderedRow = $renderedRow . 'A|' ;
		} else if( $row["action"] == 'deleted' ) {
			$renderedRow = $renderedRow . 'D|' ;
		} else {
			$renderedRow = $renderedRow . 'M|' ;
		}

		if( $row["category"] ) {
			$renderedRow = $renderedRow . $row["category"] ;
		}

		$renderedRow = $renderedRow . $row["title"] . '|' . $row["color"] . "\n" ;

		return $renderedRow;
	}


} // end of EvolutionGourceLogRenderer class


?>
