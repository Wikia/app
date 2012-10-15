<?php
/**
 * Static methods that retrieve information from the database.
 */
class CongressLookupDB {

	/**
	 * Given a zip code, return the data for that zip code's congressional representative
	 * @param $zip string
	 * @return array
	 */
	public static function getRepresentative( $zip ) {
		$repData = array();
		$dbr = wfGetDB( DB_SLAVE );

		$zip = self::trimZip( $zip, 5 ); // Trim it to 5 digit
		$zip = intval( $zip ); // Convert into an integer

		/**
		 * Select all possible reps for this 5 digit zip code.
		 * In some cases, there is more than one representative for a given
		 * 5-digit zip code, since district lines are drawn to the 9-digit zip
		 * level. In the event that there are multiple reps for this 5 digit
		 * zip, we'll return them all. It will be up to the display layer
		 * to determine how to display this to the user.
		 */
		$rep_results = $dbr->select( 
			'cl_zip5', 
			'clz5_rep_id', 
			array( 'clz5_zip' => $zip ),
			__METHOD__
		);
		
		if ( $rep_results ) {
			foreach ( $rep_results as $rep_row ) {
				$rep_id = $rep_row->clz5_rep_id;
				$res = $dbr->select( 
					'cl_house',
					array(
						'clh_bioguideid',
						'clh_gender',
						'clh_name',
						'clh_title',
						'clh_state',
						'clh_district',
						'clh_phone',
						'clh_fax',
						'clh_contactform',
						'clh_twitter'
					),
					array(
						'clh_id' => $rep_id,
					),
					__METHOD__
				);
				foreach ( $res as $row ) {
					$oneHouseRep = array(
						'bioguideid' => $row->clh_bioguideid,
						'gender' => $row->clh_gender,
						'name' => $row->clh_name,
						'title' => $row->clh_title,
						'state' => $row->clh_state,
						'district' => $row->clh_district,
						'phone' => $row->clh_phone,
						'fax' => $row->clh_fax,
						'contactform' => $row->clh_contactform,
						'twitter' => $row->clh_twitter,
					);
					$repData[] = $oneHouseRep;
				}
			}
		}
		return $repData;
	}

	/**
	 * Given a zip code, return the data for that zip code's senators
	 * @param $zip string
	 * @return array
	 */
	public static function getSenators( $zip ) {
		$senatorData = array();
		$dbr = wfGetDB( DB_SLAVE );
		 
		$zip = self::trimZip( $zip, 3 ); // Trim it to 3 digit
		$zip = intval( $zip ); // Convert into an integer

		$row = $dbr->selectRow( 'cl_zip3', 'clz3_state', array( 'clz3_zip' => $zip ) );
		if ( $row ) {
			$state = $row->clz3_state;
			$res = $dbr->select( 
				'cl_senate',
				array(
					'cls_bioguideid',
					'cls_gender',
					'cls_name',
					'cls_title',
					'cls_state',
					'cls_phone',
					'cls_fax',
					'cls_contactform',
					'cls_twitter'
				),
				array(
					'cls_state' => $state,
				),
				__METHOD__
			);
			foreach ( $res as $row ) {
				$oneSenator = array(
					'bioguideid' => $row->cls_bioguideid,
					'gender' => $row->cls_gender,
					'name' => $row->cls_name,
					'title' => $row->cls_title,
					'state' => $row->cls_state,
					'phone' => $row->cls_phone,
					'fax' => $row->cls_fax,
					'contactform' => $row->cls_contactform,
					'twitter' => $row->cls_twitter
				);
				$senatorData[] = $oneSenator;
			}
		}
		return $senatorData;
	}

	/**
	 * Helper method. Trim a zip code, but leave it as a string.
	 * @param $zip string: Raw zip code
	 * @param $length integer: How many digits we want to return (from the left)
	 * @return string The trimmed zip code
	 */	
	public static function trimZip( $zip, $length ) {
		$zip = trim( $zip );
		$zipPieces = explode( '-', $zip, 2 );
		$zip = substr( $zipPieces[0], 0, $length );
		return $zip;
	}
}
