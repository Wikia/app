<?php

/**
 * Has static methods to grab assessment statistics
 **/

class Statistics {
	public static function getImportanceColumn( $importance ) {
		$importanceColumnMapping = array(
			'top' => 'ps_top_icount',
			'high' => 'ps_high_icount',
			'mid' => 'ps_mid_icount',
			'low' => 'ps_mid_icount',
			'no' => 'ps_no_icount',
			'' => 'ps_unclassified_icount'
		);

		return $importanceColumnMapping[ strtolower( $importance ) ];
	}

	public static function updateAggregateStats( $rating, $is_new_rating, $update_global = true ) {
		if(! $is_new_rating && !isset($rating->old_importance) && !isset($rating->old_quality) ) {
			return;
		}
		$dbw = wfGetDB( DB_MASTER );
		$importance_column = Statistics::getImportanceColumn( $rating->importance );
		$dbw->insert(
			'project_stats',
			array(
				'ps_project' => $rating->project,
				'ps_quality' => $rating->quality,
				$importance_column => '0'
			),
			__METHOD__,
			array( 'IGNORE' )
		);
		$dbw->update(
			'project_stats',
			array( "$importance_column = $importance_column + 1" ),
			array( 
				"ps_project" => $rating->project,
				"ps_quality" => $rating->quality
			),
			__METHOD__
		);

		if(! $is_new_rating ) {
			// Is not a new rating, and atleast one of quality or importance has changed
			if( isset( $rating->old_quality ) ) {
				$q_value = $rating->old_quality;
			} else {
				$q_value = $rating->quality;
			}
			if( isset( $rating->old_importance) ) {
				$i_column = Statistics::getImportanceColumn( $rating->old_importance );
			} else {
				$i_column = Statistics::getImportanceColumn( $rating->importance );
			}
			$dbw->update(
				'project_stats',
				array( "$i_column = $i_column - 1" ),
				array( 
					"ps_project" => $rating->project,
					"ps_quality" => $q_value
				),
				__METHOD__	
			);
		}

		if( $update_global ) {
			$global_rating = new Rating(
				"Global Project",
				$rating->namespace,
				$rating->title,
				$rating->quality,
				$rating->quality_timestamp,
				$rating->importance,
				$rating->importance_timestamp
			);
			$global_rating->old_importance = $rating->old_importance;
			$global_rating->old_quality = $rating->old_quality;
			Statistics::updateAggregateStats( $global_rating, $is_new_rating, false );
		}
	}

	public static function getProjectStats( $project ) {
		$dbr = wfGetDB( DB_SLAVE );
		$query = $dbr->select(
			"project_stats",
			"*",
			array(
				"ps_project" => $project
			),
			__METHOD__
		);

		$project_statistics = array(
			"top" => array(),
			"high" => array(),
			"mid" => array(),
			"low" => array(),
			"no" => array(),
			"" => array()
		);


		foreach( $query as $row_object ) {
			$data_row = (array)$row_object;
			$quality = $data_row['ps_quality'];
			foreach( $project_statistics as $importance => &$importance_row ) {
				$importance_row[$quality] = $data_row[Statistics::getImportanceColumn( $importance )];
			}
		}

		// Make '' into 'unclassified'
		$project_statistics['unclassified'] = $project_statistics[''];
		unset( $project_statistics[''] );

		return $project_statistics;
	}

}
