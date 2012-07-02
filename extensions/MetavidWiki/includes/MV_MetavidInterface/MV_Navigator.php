<?php
/**
 * Created on Aug 15, 2008
 *
 * All Metavid Wiki code is Released Under the GPL2
 * for more info visit http://metavid.org/wiki/Code
 */
 class MV_Navigator extends MV_Component {
 	function getHTML() {
 		global $wgUser;
 		$o = '';
 		$sk = $wgUser->getSkin();
 		$dbr = wfGetDB( DB_SLAVE );

 		//if in overview mode don't print out the navigator:
 		global $wgRequest;
 		if( $wgRequest->getVal( 'view' )=='overview' )
 			return '';

 		// get all annotative layers
 		$stream_id = $this->mv_interface->article->mvTitle->getStreamId();
 		$stream_name = $this->mv_interface->article->mvTitle->getStreamName();
 		$stream_time_req = $this->mv_interface->article->mvTitle->getTimeRequest();
 		$start_sec = $this->mv_interface->article->mvTitle->getStartTimeSeconds();
 		$duration_sec = $this->mv_interface->article->mvTitle->getDuration();
		$end_sec   = $this->mv_interface->article->mvTitle->getEndTimeSeconds();

		// print "start $start_sec end:$end_sec \n ";
		foreach ( array( 'prev', 'next' ) as $pntype ) {
			if ( $o != '' )$o .= ' ';
			if ( $pntype == 'prev' ) {
				if ( $start_sec == 0 )
					continue;
				$qstart = 0;
				$qend = $start_sec-1;
				$orderby = 'end_time DESC';
			} elseif ( $pntype == 'next' ) {
				$qstart = $end_sec + 1;
				$qend = $duration_sec;
				$orderby = 'start_time ASC';
			}
			// print "Qstart looking for $pntype:$qstart:  ".seconds2npt($qstart) ." Qend:$qend : " . seconds2npt($qend) . " \n";
	 		$mvd_rows = MV_Index::getMVDInRange(
	 								$stream_id,
	 								$qstart,
	 								$qend,
	 								$mvd_type = 'anno_en',
	 								$getText = false,
	 								$smw_properties = array( 'Speech_by', 'Bill', 'category' ),
	 								$options = array( 'LIMIT' => 1, 'ORDER BY' => $orderby )
	 						);
	 		//print $dbr->lastQuery();
	 		//print_r($mvd_rows);
			//die;
	 		// print "SHOULD GET $pntype for $stream_time_req";
	 		reset( $mvd_rows );
	 		if ( count( $mvd_rows ) != 0 ) {
	 			$row = current( $mvd_rows );
	 			// $prev_end = $row->end_time;
	 			$stime_req = seconds2npt( $row->start_time ) . '/' . seconds2npt( $row->end_time );
	 			$streamTitle = Title::newFromText( $stream_name . '/' . $stime_req, MV_NS_STREAM );
	 			$tool_tip = '';
	 			// print_r($row);
	 			if(isset($row->Speech_by)){
		 			if ( trim( $row->Speech_by ) != '' ) {
		 				//check if the person has an icon:
		 				$pimg = mv_get_person_img( $row->Speech_by );
		 				$o .= wfMsg( 'mv_' . $pntype . '_speech', $sk->makeKnownLinkObj( $streamTitle, '<img title="'.str_replace('_',' ',$row->Speech_by).'" width="40" src="' . $pimg->getURL() . '">' ) );
		 				//$o .= wfMsg( 'mv_' . $pntype . '_speech', $sk->makeKnownLinkObj( $streamTitle, str_replace( '_', ' ', $row->Speech_by ) ) );


		 				// $tool_tip.=	 'Speech By: '. $row->Speech_by;
		 			} elseif ( trim( $row->Bill ) != '' ) {
		 				$o .= wfMsg( 'mv_' . $pntype . '_bill', $sk->makeKnownLinkObj( $streamTitle, str_replace( '_', ' ', $row->Bill ) ) );
		 			} elseif ( is_array( $row->category ) && count( $row->category ) != 0 ) {
		 				$first_cat =  current( $row->category );
		 				$o .= wfMsg( 'mv_' . $pntype . '_cat',  $sk->makeKnownLinkObj( $streamTitle, str_replace( '_', ' ', $first_cat ) ) );
		 			}
	 			}
	 		}
		}
 		return $o;
 	}
 	function render_full() {
 		global $wgOut;
 		$wgOut->addHTML( '<div id="MV_Navigator">' );
 			$wgOut->addHTML( $this->getHTML() );
 		$wgOut->addHTML( '</div>' );
 	}
 }
