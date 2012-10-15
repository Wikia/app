<?php

class APCHostMode {
	public static function doGeneralInfoTable( $c, $mem ) {
		global $wgLang;
		$r = 1;
		return
			APCUtils::tableHeader( wfMsg( 'viewapc-info-general' ) ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-apc-version' ), phpversion( 'apc' ) ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-php-version' ), phpversion() ) .

			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-shared-memory' ),
				wfMsgExt( 'viewapc-shared-memory-details', 'parsemag',
					$wgLang->formatNum( $mem['num_seg'] ),
					$wgLang->formatSize( $mem['seg_size'] ),
					$c['memory_type'], $c['locking_type'] ) ) .

			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-start-time' ),
				$wgLang->timeanddate( $c['start_time'] ) ) .

			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-uptime' ),
				$wgLang->formatTimePeriod( time() - $c['start_time'] ) ) .

			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-upload-support' ), $c['file_upload_progress'] ) .
			APCUtils::tableFooter();
	}

	public static function doCacheTable( $c, $user = false ) {
		global $wgLang;

		// Calculate rates
		$numHits   = $wgLang->formatNum( $c['num_hits'] );
		$numMiss   = $wgLang->formatNum( $c['num_misses'] );
		$numReqs   = $c['num_hits'] + $c['num_misses'];
		$cPeriod   = time() - $c['start_time'];
		if ( !$cPeriod ) $cPeriod = 1;
		$rateReqs  = APCUtils::formatReqPerS( $numReqs / $cPeriod );
		$rateHits  = APCUtils::formatReqPerS( $c['num_hits'] / $cPeriod );
		$rateMiss  = APCUtils::formatReqPerS( $c['num_misses'] / $cPeriod );
		$rateInsert = APCUtils::formatReqPerS( $c['num_inserts'] / $cPeriod );

		$cachedFiles = wfMsgExt( 'viewapc-cached-files-d', 'parsemag',
					$wgLang->formatNum( $c['num_entries'] ),
					$wgLang->formatSize( $c['mem_size'] ) );
		$cacheFullCount = $wgLang->formatNum( $c['expunges'] );

		$contentType = !$user ? wfMsg( 'viewapc-filecache-info' ) : wfMsg( 'viewapc-usercache-info' );

		return
			APCUtils::tableHeader( $contentType ) .
			APCUtils::tableRow( $r = 0, wfMsgHtml( 'viewapc-cached-files' ), $cachedFiles ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-hits' ), $numHits ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-misses' ), $numMiss ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-requests' ), $rateReqs ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-hitrate' ), $rateHits ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-missrate' ), $rateMiss ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-insertrate' ), $rateInsert ) .
			APCUtils::tableRow( $r = 1 - $r, wfMsgHtml( 'viewapc-cachefull' ), $cacheFullCount ) .
			APCUtils::tableFooter();
	}

	public static function doRuntimeInfoTable( $mem ) {
		$s = APCUtils::tableHeader( wfMsg( 'viewapc-info-runtime' ) );

		$r = 1;
		foreach ( ini_get_all( 'apc' ) as $k => $v ) {
			$s .= APCUtils::tableRow( $r = 1 - $r,
					htmlspecialchars( $k ),
					str_replace( ',', ',<br />', htmlspecialchars( $v['local_value'] ) ) );
		}

		$s .= APCUtils::tableFooter();
		return $s;
	}

	public static function doMemoryInfoTable( $c, $mem, $title ) {
		global $wgLang;

		$s = APCUtils::tableHeader( wfMsg( 'viewapc-info-memory' ), 'mw-apc-img-table' );

		if ( $mem['num_seg'] > 1 || $mem['num_seg'] == 1 && count( $mem['block_lists'][0] ) > 1 ) {
			$memHeader = wfMsgExt( 'viewapc-memory-usage-detailed', 'parseinline' );
		} else {
			$memHeader = wfMsgExt( 'viewapc-memory-usage', 'parseinline' );
		}
		$hitHeader = wfMsgExt( 'viewapc-cache-efficiency', 'parseinline' );

		$s .= APCUtils::tableRow( null, $memHeader, $hitHeader );


		if ( APCImages::graphics_avail() ) {
			$attribs = array(
				'alt' => '',
				'width' => APCImages::GRAPH_SIZE + 10,
				'height' => APCImages::GRAPH_SIZE + 10,
			);

			$param1 = wfArrayToCGI( array( 'image' => APCImages::IMG_MEM_USAGE ) );
			$param2 = wfArrayToCGI( array( 'image' => APCImages::IMG_HITS ) );

			$attribs1 = array( 'src' => $title->getLocalURL( $param1 ) ) + $attribs;
			$attribs2 = array( 'src' => $title->getLocalURL( $param2 ) ) + $attribs;

			$s .= APCUtils::tableRow( null, Xml::element( 'img', $attribs1 ), Xml::element( 'img', $attribs2 ) );
		}

		$size = $mem['num_seg'] * $mem['seg_size'];
		$free = $mem['avail_mem'];
		$used = $size - $free;

		$freeMem = wfMsgExt( 'viewapc-memory-free', 'parseinline',
			$wgLang->formatSize( $free ),
			$wgLang->formatNum( sprintf( '%.1f%%', $free * 100 / $size ) ) );

		$usedMem = wfMsgExt( 'viewapc-memory-used', 'parseinline',
			$wgLang->formatSize( $used ),
			$wgLang->formatNum( sprintf( '%.1f%%', $used * 100 / $size ) ) );

		$hits = $c['num_hits'];
		$miss = $c['num_misses'];
		$reqs = $hits + $miss;

		$greenbox = Xml::element( 'span', array( 'class' => 'green box' ), ' ' );
		$redbox = Xml::element( 'span', array( 'class' => 'red box' ), ' ' );

		$memHits = wfMsgExt( 'viewapc-memory-hits', 'parseinline',
			$wgLang->formatNum( $hits ),
			$wgLang->formatNum( @sprintf( '%.1f%%', $hits * 100 / $reqs ) ) );

		$memMiss = wfMsgExt( 'viewapc-memory-miss', 'parseinline',
			$wgLang->formatNum( $miss ),
			$wgLang->formatNum( @sprintf( '%.1f%%', $miss * 100 / $reqs ) ) );

		$s .= APCUtils::tableRow( null, $greenbox . $freeMem, $greenbox . $memHits );
		$s .= APCUtils::tableRow( null, $redbox . $usedMem, $redbox . $memMiss );
		$s .= APCUtils::tableFooter();

		return $s;
	}

	public static function doFragmentationTable( $mem, $title ) {
		global $wgLang;
		$s = APCUtils::tableHeader( wfMsg( 'viewapc-memoryfragmentation' ), 'mw-apc-img-table' );
		$s .= Xml::openElement( 'tr' ) . Xml::openElement( 'td' );

		// Fragementation: (freeseg - 1) / total_seg
		$nseg = $freeseg = $fragsize = $freetotal = 0;
		for ( $i = 0; $i < $mem['num_seg']; $i++ ) {
			$ptr = 0;
			foreach ( $mem['block_lists'][$i] as $block ) {
				if ( $block['offset'] != $ptr ) {
					++$nseg;
				}
				$ptr = $block['offset'] + $block['size'];
					/* Only consider blocks <5M for the fragmentation % */
					if ( $block['size'] < ( 5 * 1024 * 1024 ) ) $fragsize += $block['size'];
					$freetotal += $block['size'];
			}
			$freeseg += count( $mem['block_lists'][$i] );
		}


		if ( APCImages::graphics_avail() ) {
			$attribs = array(
				'alt' => '',
				'width' => 2 * APCImages::GRAPH_SIZE + 150,
				'height' => APCImages::GRAPH_SIZE + 10,
				'src' => $title->getLocalURL( 'image=' . APCImages::IMG_FRAGMENTATION )
			);
			$s .= Xml::element( 'img', $attribs );
		}

		if ( $freeseg > 1 ) {
			$fragPercent = sprintf( '%.2f%%', ( $fragsize / $freetotal ) * 100 );
			$s .= wfMsgExt( 'viewapc-fragmentation-info', 'parse',
					$wgLang->formatNum( $fragPercent, true ),
					$wgLang->formatSize( $fragsize ),
					$wgLang->formatSize( $freetotal ),
					$wgLang->formatNum( $freeseg )
			);
		} else {
			$s .= wfMsgExt( 'viewapc-fragmentation-none', 'parse' );
		}

		$s .= Xml::closeElement( 'td' ) . Xml::closeElement( 'tr' );

		if ( isset( $mem['adist'] ) ) {
			foreach ( $mem['adist'] as $i => $v ) {
				$cur = pow( 2, $i ); $nxt = pow( 2, $i + 1 ) - 1;
				if ( $i == 0 ) $range = "1";
				else $range = "$cur - $nxt";
				$s .= Xml::tags( 'tr', null,
					Xml::tags( 'th', array( 'align' => 'right' ), $range ) .
					Xml::tags( 'td', array( 'align' => 'right' ), $v )
				);
			}
		}

		$s .= APCUtils::tableFooter();
		return $s;
	}
}
