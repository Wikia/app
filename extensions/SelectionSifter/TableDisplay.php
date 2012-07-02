<?php

/**
 * @todo Document overall purpose of this class.
 */
class TableDisplay {
	/**
	 * Register our parser functions
	 */
	public static function ParserFunctionInit( &$parser ) {
		$parser->setFunctionHook( 'AssessmentStats', 'TableDisplay::AssessmentStatsRender' );
		return true;
	}

	/**
	 * @todo Document!
	 * @param string $projectName
	 * @param unknown $projectStats
	 * @return string A wikitable containing statistics for a project name
	 */
	private static function formatTable( $projectName, $projectStats ) {
		// Column Headers
		$col_headers = array_keys($projectStats['top']);
		$output = "{| class='wikitable' \n|+ $projectName article ratings\n";
		$output .= "|-\n ! scope='col' | \n";
		foreach( $col_headers as $col_header ) {
			$output .= "! scope='col' | $col_header \n";
		}
		foreach( $projectStats as $importance => $qualityRatings ) {
			$output .= "|- \n ! scope='row' | $importance\n";
			foreach( $qualityRatings as $quality => $qualityCount ) {
				$output .= "| $qualityCount \n";
			}
		}
		$output .= "|}";
		return $output;
	}

	/**
	 * Callback for AssessmentsStats parser function
	 * @param Parser $parser Parser object passed by MW hook system (unused)
	 * @param unknown A project object??
	 */
	public static function AssessmentStatsRender( $parser, $project ) {
		$projectStats = Statistics::getProjectStats( $project );
		$output = TableDisplay::formatTable( $project, $projectStats );
		return $output;
	}
}
