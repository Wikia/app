<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage - generate XLS files for statistics
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

class WikiStatsXLS {
	//--
	var $mStats;
	var $mData = array();
	var $mFileName;
	function __construct( $oStats, $data = array(), $filename = 'default' ) {
		$this->mStats = $oStats;
		if ( !empty($data) && is_array($data) ) {
			$this->mData = $data;
		}
		$this->mFileName = $filename;
	}

	private function setXLSFileBegin() {
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		return;
	}

	private function setXLSFileEnd() {
		exit(pack("ss", 0x0A, 0x00));
	}

	private function mergeXLSColsRows($row, $col, $to_row, $to_col) {
		echo pack("ss", 0xE5, 0x0A);
		echo pack("sssss", 1, $row, $to_row, $col, $to_col);
		return;
	}

	private function writeXLSNumber($row, $col, $value) {
		if (strpos($value, ",") !== false) {
			$this->writeXLSLabel($row, $col, $value );
		} else {
			if (isset($value)) {
				echo pack("sssss", 0x203, 14, $row, $col, 0x0);
				echo pack("d", sprintf("%0.2f", $value));
			}
		}
		return;
	}

	private function writeXLSLabel($row, $col, $value ) {
		$value = str_replace("<br/>", " ", $value);
		$value = str_replace("&lt;", "<", $value);
		$value = str_replace("&gt;", ">", $value);
		$len = strlen($value);
		echo pack("ssssss", 0x204, 8 + $len, $row, $col, 0x0, $len);
		echo $value;
		return;
	}

	public function setXLSHeader() {
		header("HTTP/1.0 200 OK");
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");;
		header("Content-Disposition: attachment;filename=".str_replace(" ", "_", $this->mFileName).".xls ");
		header("Content-Transfer-Encoding: binary ");
	}

	public function generateEmptyFile()	{
		$dbname = sprintf(DEFAULT_WIKIA_XLS_FILENAME, intval($cityId));
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$this->setXLSFileEnd();
	}

	public function makeMainStats($columnNames) {
		global $wgUser, $wgLang;

		#----
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,1,wfMsg('wikistats_pagetitle'));
		$this->mergeXLSColsRows(1, 1, 1, count($columnNames));
		/*
		 * table header
		 */
		$this->writeXLSLabel( 3 /*row*/, 1 /*column*/, wfMsg('wikistats_date') );
		$this->mergeXLSColsRows( 3, 1, 6, 1 );
		$this->writeXLSLabel( 3, 2, wfMsg('wikistats_wikians') );
		$this->mergeXLSColsRows( 3 /*row*/, 2 /*col*/, 3 /*row*/, 9 /*col*/ );
		$this->writeXLSLabel( 3, 10, wfMsg('wikistats_articles') );
		$this->mergeXLSColsRows( 3, 10, 3, 14 );
		$this->writeXLSLabel( 3, 15, wfMsg('wikistats_media') );
		$this->mergeXLSColsRows( 3, 15, 3, 18 );

		// second row
		// date
		$this->writeXLSLabel( 4, 1, '' );
		// wikians/articles/media
		$this->writeXLSLabel( 4, 2, wfMsg('wikistats_lifetime_editors') );
		$this->mergeXLSColsRows( 4, 2, 4, 6 );
		$this->writeXLSLabel( 4, 7, wfMsg('wikistats_months_edits') );
		$this->mergeXLSColsRows( 4, 7, 4, 9 );
		$this->writeXLSLabel( 4, 10, wfMsg('wikistats_total') );
		$this->mergeXLSColsRows( 4, 10, 6, 10 );
		$this->writeXLSLabel( 4, 11, str_replace("<br />", " ", wfMsg('wikistats_new_per_day')) );
		$this->mergeXLSColsRows( 4, 11, 6, 11 );
		$this->writeXLSLabel( 4, 12, wfMsg('size-kilobytes', 0.5) );
		$this->mergeXLSColsRows( 4, 12, 6, 12 );
		$this->writeXLSLabel( 4, 13, wfMsg('wikistats_edits') );
		$this->mergeXLSColsRows( 4, 13, 6, 13 );
		$this->writeXLSLabel( 4, 14, wfMsg('wikistats_words') );
		$this->mergeXLSColsRows( 4, 14, 6, 14 );
		$this->writeXLSLabel( 4, 15, wfMsg('wikistats_images') );
		$this->mergeXLSColsRows( 4, 15, 4, 16 );
		$this->writeXLSLabel( 4, 17, wfMsg('wikistats_video') );
		$this->mergeXLSColsRows( 4, 17, 4, 18 );

		// third row
		$this->writeXLSLabel( 5, 2, wfMsg('wikistats_total') );
		$this->mergeXLSColsRows(5, 2, 6, 2);
		$this->writeXLSLabel( 5, 3, wfMsg('wikistats_namespaces') );
		$this->mergeXLSColsRows(5, 3, 5, 4);
		$this->writeXLSLabel( 5, 5, wfMsg('wikistats_edits') );
		$this->mergeXLSColsRows(5, 5, 5, 6);
		$this->writeXLSLabel( 5, 7, wfMsg('wikistats_namespaces') );
		$this->mergeXLSColsRows(5, 7, 5, 9);
		$this->writeXLSLabel( 5, 15, wfMsg('wikistats_links') );
		$this->mergeXLSColsRows(5, 15, 6, 15);
		$this->writeXLSLabel( 5, 16, wfMsg('wikistats_uploaded_images') );
		$this->mergeXLSColsRows(5, 16, 6, 16);
		$this->writeXLSLabel( 5, 17, wfMsg('wikistats_video_embeded') );
		$this->mergeXLSColsRows(5, 17, 6, 17);
		$this->writeXLSLabel( 5, 18, wfMsg('wikistats_uploaded_images') );
		$this->mergeXLSColsRows(5, 18, 6, 18);

		// 4th row
		$this->writeXLSLabel( 6, 3, wfMsg('wikistats_content') );
		$this->writeXLSLabel( 6, 4, wfMsg('wikistats_userns') );
		$this->writeXLSLabel( 6, 5, '>5' );
		$this->writeXLSLabel( 6, 6, '>100' );
		$this->writeXLSLabel( 6, 7, wfMsg('wikistats_total') );
		$this->writeXLSLabel( 6, 8, wfMsg('wikistats_content') );
		$this->writeXLSLabel( 6, 9, wfMsg('wikistats_userns') );

		// monthly stats
		$row = 6;
		$out = ""; $cols = array();
		// statistics
		foreach ($this->mData as $date => $columns) {
			$row++;
			$col = 1;
			foreach ( $columns as $column => $out ) {
				$__number = $out;
				if ( empty($out) ) {
					$out = "0";
				} else {
					switch ($column) {
						case 'date': 
							$stamp = mktime(23, 59, 59, substr($out, 4, 2), 1, substr($out, 0, 4));
							if ( $out == date("Ym") ) {
								$stamp = time();
								$out = $wgLang->sprintfDate( $this->mStats->dateFormat(0), wfTimestamp(TS_MW, $stamp));
							} else {
								$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
							}
							break;
						case 'K' : # percent of articles > 0.5 kB
							$out = sprintf( "%0d", $columns['I'] ? (100*$out)/$columns['I'] : 0 ); 
							break;
						default: 
							$out = sprintf( "%0.1f", $out ); 
							break;
					}
				}
				if ($out != "") {
					if ($column == 'date')
						$this->writeXLSLabel($row,$col,$out);
					else
						$this->writeXLSNumber($row, $col, $out);
				}
				$col++;
			}
		}

		// column's names -> A, B, C ...
		$row++; $col = 1;
		foreach ($columnNames as $column) {
			if ($column == "date") $column = "";
			$this->writeXLSLabel( $row, $col, $column);
			$col++;
		}
		unset( $columnNames );
		$this->setXLSFileEnd();
	}

	public function makeDistribStats($city_id, &$statsData)
	{
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		#----
		#wfMsg('wikistats_filename_other1', $dbname)
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,1,ucfirst($dbname). " - " .wfMsg('wikistats_distrib_article'));
		$this->mergeXLSColsRows(1, 0, 1, 5);
		/*
		 * table header
		 */
		$this->writeXLSLabel(3, 0, wfMsg('wikistats_distrib_edits'));
		$this->writeXLSLabel(3, 1, wfMsg('wikistats_distrib_wikians'));
		$this->mergeXLSColsRows(3, 1, 3, 2);
		$this->writeXLSLabel(3, 3, wfMsg('wikistats_distrib_edits_total'));
		$this->mergeXLSColsRows(3, 3, 3, 4);
		//----
		$this->writeXLSLabel(4, 1, '#');
		$this->writeXLSLabel(4, 2, '%');
		$this->writeXLSLabel(4, 3, '#');
		$this->writeXLSLabel(4, 4, '%');
		/*
		 * data
		 */
		$row = 5;
		foreach ($statsData as $id => $data) {
			$col = 0;
			$this->writeXLSNumber($row,$col,$data['edits']);$col++;
			$this->writeXLSNumber($row,$col,$data['wikians']);$col++;
			$this->writeXLSNumber($row,$col,str_replace("%","",$data['wikians_perc']));$col++;
			$this->writeXLSNumber($row,$col,$data['edits_total']);$col++;
			$this->writeXLSNumber($row,$col,str_replace("%","",$data['edits_total_perc']));$col++;
			$row++;
		}
		#---
		unset($statsData);
		$this->setXLSFileEnd();
	}
	
	public function makeActiveWikiansStats($city_id, &$active, &$absent)
	{
		global $wgLang;
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		#wfMsg('wikistats_filename_other2', $dbname)
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikistats_active_absent_wikians'));
		$this->mergeXLSColsRows(1, 0, 1, 11);

		$row = 3;
		if (!empty($active)) {
			/*
			 * header
			 */
			$this->writeXLSLabel(3,0,wfMsg('wikistats_recently_active_wikians', count($active)));
			$this->mergeXLSColsRows(3, 0, 3, 11);
			$this->writeXLSLabel(4,0,wfMsg('wikistats_active_wikians_subtitle_info'));
			$this->mergeXLSColsRows(4, 0, 4, 11);
			// first row of table
			$this->writeXLSLabel(6,0,wfMsg('wikistats_username'));
			$this->writeXLSLabel(6,1,wfMsg('wikistats_edits'));
			$this->mergeXLSColsRows(6, 1, 6, 6);
			$this->writeXLSLabel(6,7,wfMsg('wikistats_first_edit'));
			$this->mergeXLSColsRows(6, 7, 7, 8);
			$this->writeXLSLabel(6,9,wfMsg('wikistats_last_edit'));
			$this->mergeXLSColsRows(6, 9, 7, 10);
			// second row
			$this->writeXLSLabel(7,1,wfMsg('wikistats_articles_text'));
			$this->mergeXLSColsRows(7, 1, 7, 4);
			$this->writeXLSLabel(7,5,wfMsg('wikistats_other'));
			$this->mergeXLSColsRows(7, 5, 7, 6);
			// third row
			$this->writeXLSLabel(8,1,wfMsg('wikistats_rank'));
			$this->mergeXLSColsRows(8, 1, 8, 2);
			$this->writeXLSLabel(8,3,wfMsg('wikistats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikistats_active_month') : wfMsg('wikistats_active_months')));
			$this->mergeXLSColsRows(8, 3, 9, 3);
			$this->writeXLSLabel(8,4,wfMsg('wikistats_total'));
			$this->mergeXLSColsRows(8, 4, 9, 4);
			$this->writeXLSLabel(8,5,wfMsg('wikistats_total'));
			$this->mergeXLSColsRows(8, 5, 9, 5);
			$this->writeXLSLabel(8,6,wfMsg('wikistats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikistats_active_month') : wfMsg('wikistats_active_months')));
			$this->mergeXLSColsRows(8, 6, 9, 6);
			$this->writeXLSLabel(8,7,wfMsg('wikistats_date'));
			$this->mergeXLSColsRows(8, 7, 9, 7);
			$this->writeXLSLabel(8,8,wfMsg('wikistats_days_ago'));
			$this->mergeXLSColsRows(8, 8, 9, 8);
			$this->writeXLSLabel(8,9,wfMsg('wikistats_date'));
			$this->mergeXLSColsRows(8, 9, 9, 9);
			$this->writeXLSLabel(8,10,wfMsg('wikistats_days_ago'));
			$this->mergeXLSColsRows(8, 10, 9, 10);
			// 4th row
			$this->writeXLSLabel(9,1,wfMsg('wikistats_now'));
			$this->writeXLSLabel(9,2,wfMsg('wikistats_prev_rank_xls'));

			$row = 10;
			foreach ($active as $rank => $data) {
				$rank_change = $data['rank_change'];
				if ($data['rank_change'] > 0) {
					$rank_change = "+".$rank_change;
				} elseif ($data['rank_change'] == 0) {
					$rank_change = "...";
				}	
				#---
				$outFirstEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $data['first_edit']));
				#$outFirstEdit = wfMsg(strtolower(date("M",$data['first_edit']))) . " " . date("d",$data['first_edit']) .", ".date("Y",$data['first_edit']);
				#---
				#$outLastEdit = wfMsg(strtolower(date("M",$data['last_edit']))) . " " . date("d",$data['last_edit']) .", ".date("Y",$data['last_edit']);
				$outLastEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $data['last_edit']));

				// write data
				$col = 0;
				$this->writeXLSLabel($row,$col,$data['user_name']); $col++;
				$this->writeXLSNumber($row,$col,intval($rank)); $col++;
				$this->writeXLSLabel($row,$col,$rank_change); $col++;
				$this->writeXLSNumber($row,$col,intval($data['edits_last'])); $col++;
				$this->writeXLSNumber($row,$col,intval($data['total'])); $col++;
				$this->writeXLSNumber($row,$col,intval($data['total_other'])); $col++;
				$this->writeXLSNumber($row,$col,intval($data['edits_other_last'])); $col++;
				$this->writeXLSLabel($row,$col,$outFirstEdit); $col++;
				$this->writeXLSNumber($row,$col,intval($data['first_edit_ago'])); $col++;
				$this->writeXLSLabel($row,$col,$outLastEdit); $col++;
				$this->writeXLSNumber($row,$col,intval($data['last_edit_ago'])); $col++;
				
				$row++;
			}
			if (!empty($active)) {
				$row++;
			}
		}
		
		// absent wikians
		$row++;
		if (!empty($absent)) {
			/*
			 * header
			 */
			$this->writeXLSLabel($row,0,wfMsg('wikistats_recently_absent_wikians', count($absent)));
			$this->mergeXLSColsRows($row, 0, $row, 6);
			$row = $row + 2;
			// first row of table
			$this->writeXLSLabel($row,0,wfMsg('wikistats_username'));
			$this->writeXLSLabel($row,1,wfMsg('wikistats_edits'));
			$this->mergeXLSColsRows($row, 1, $row, 2);
			$this->writeXLSLabel($row,3,wfMsg('wikistats_first_edit'));
			$this->mergeXLSColsRows($row, 3, $row, 4);
			$this->writeXLSLabel($row,5,wfMsg('wikistats_last_edit'));
			$this->mergeXLSColsRows($row, 5, $row, 6);
			$row++;
			// second row
			$this->writeXLSLabel($row,1,wfMsg('wikistats_rank'));
			$this->writeXLSLabel($row,2,wfMsg('wikistats_total'));
			$this->writeXLSLabel($row,3,wfMsg('wikistats_date'));
			$this->writeXLSLabel($row,4,wfMsg('wikistats_days_ago'));
			$this->writeXLSLabel($row,5,wfMsg('wikistats_date'));
			$this->writeXLSLabel($row,6,wfMsg('wikistats_days_ago'));

			$row++;
			foreach ($absent as $rank => $data) {
				#---
				$outFirstEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $data['first_edit']));
				#$outFirstEdit = wfMsg(strtolower(date("M",$data['first_edit']))) . " " . date("d",$data['first_edit']) .", ".date("Y",$data['first_edit']);
				#---
				$outLastEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $data['last_edit']));
				#$outLastEdit = wfMsg(strtolower(date("M",$data['last_edit']))) . " " . date("d",$data['last_edit']) .", ".date("Y",$data['last_edit']);
				#---
				$col = 0;
				$this->writeXLSLabel($row,$col,$data['user_name']); $col++;
				$this->writeXLSNumber($row,$col,intval($rank)); $col++;
				$this->writeXLSNumber($row,$col,intval($data['total'])); $col++;
				$this->writeXLSLabel($row,$col,$outFirstEdit); $col++;
				$this->writeXLSNumber($row,$col,intval($data['first_edit_ago'])); $col++;
				$this->writeXLSLabel($row,$col,$outLastEdit); $col++;
				$this->writeXLSNumber($row,$col,intval($data['last_edit_ago'])); $col++;
				#---
				$row++;
			}
		}
		unset($active);
		unset($absent);
		$this->setXLSFileEnd();
	}
	
	public function makeWikiaAnonUsersStats($city_id, &$anonData)
	{
		global $wgLang;
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		#wfMsg('wikistats_filename_other3', $dbname)
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikistats_anon_wikians'));
		$this->mergeXLSColsRows(1, 0, 1, 7);
		$this->writeXLSLabel(3,0,ucfirst($dbname). " - " .wfMsg('wikistats_anon_wikians_count', count($anonData)));
		$this->mergeXLSColsRows(3, 0, 3, 7);

		$row = 5;
		if (!empty($anonData)) {
			/*
			 * Header
			 */
			$this->writeXLSLabel($row,0,wfMsg('wikistats_username'));
			$this->writeXLSLabel($row,1,wfMsg('wikistats_edits'));
			$this->mergeXLSColsRows($row, 1, $row, 2);
			$this->writeXLSLabel($row,3,wfMsg('wikistats_first_edit'));
			$this->mergeXLSColsRows($row, 3, $row, 4);
			$this->writeXLSLabel($row,5,wfMsg('wikistats_last_edit'));
			$this->mergeXLSColsRows($row, 5, $row, 6);
			$row++;
			$this->writeXLSLabel($row,1,wfMsg('wikistats_rank'));
			$this->writeXLSLabel($row,2,wfMsg('wikistats_total'));
			$this->writeXLSLabel($row,3,wfMsg('wikistats_date'));
			$this->writeXLSLabel($row,4,wfMsg('wikistats_days_ago'));
			$this->writeXLSLabel($row,5,wfMsg('wikistats_date'));
			$this->writeXLSLabel($row,6,wfMsg('wikistats_days_ago'));
			$row++;
			$rank = 0;
			foreach ($anonData as $id => $data) {
				$rank++;
				#---
				$outFirstEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $data['min']));
				#$outFirstEdit = wfMsg(strtolower(date("M",$data['min']))) . " " . date("d",$data['min']) .", ".date("Y",$data['min']);
				#---
				#$outLastEdit = wfMsg(strtolower(date("M",$data['max'])))  . " " . date("d",$data['max']) .", ".date("Y",$data['max']);
				$outLastEdit = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $data['max']));
				#---
				$col = 0;
				$this->writeXLSLabel($row,$col,$data['user_name']); $col++;
				$this->writeXLSNumber($row,$col,intval($rank)); $col++;
				$this->writeXLSNumber($row,$col,intval($data['cnt'])); $col++;
				$this->writeXLSLabel($row,$col,$outFirstEdit); $col++;
				$this->writeXLSNumber($row,$col,sprintf("%0.0f", (time() - $data["min"])/(60*60*24))); $col++;
				$this->writeXLSLabel($row,$col,$outLastEdit); $col++;
				$this->writeXLSNumber($row,$col,sprintf("%0.0f", (time() - $data["max"])/(60*60*24))); $col++;
				#---
				$row++;
			}
		}
		
		unset($anonData);
		$this->setXLSFileEnd();
	}
	
	public function makeArticleSizeStats($city_id, &$articleCount, &$articleSize)
	{
		global $wgLang;
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		#wfMsg('wikistats_filename_other4', $dbname)
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikistats_article_one_link'));
		$this->mergeXLSColsRows(1, 0, 1, count($articleSize) + 1);

		/*
		 * Header
		 */
		$row = 3;
		$this->writeXLSLabel($row,0,wfMsg('wikistats_date'));
		$this->writeXLSLabel($row,1,wfMsg('wikistats_articles_text') . "(%)");
		$this->mergeXLSColsRows($row, 1, $row, count($articleSize));
		$row++;
		// second line
		$col = 1;
		foreach ($articleSize as $s => $values) {
			$bT = wfMsg('size-bytes', $s);
			$text = "< ".$bT;
			if ($s >= 1024) {
				$kbT = wfMsg('size-kilobytes', sprintf("%.0f", $s/1024));
				$text = "< ".$kbT;
			}
			$this->writeXLSLabel($row,$col,$text);
			$col++;
		}

		$row++;
		foreach ($articleCount as $date => $monthStats) {
			$col = 0;
			$cntAll = intval($monthStats['count']);
			#---
			$dateArr = explode("-",$date);
			$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
			#---
			#$out = wfMsg(strtolower(date("M",$stamp))) . " " . $dateArr[0];
			$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
			#---
			if ($date == date("Y-m")) {
				$out = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $stamp));
				#$out = wfMsg(strtolower(date("M",$stamp))) . " " . date("d") . ", " . $dateArr[0];
			}
			#---
			$this->writeXLSLabel($row,$col,$out);
			#---
			foreach ($articleSize as $s => $values) {
				$col++;
				$cntDate = array_key_exists($date, $values) ? intval($values[$date]['count']) : 0;
				$rowValue = $wgLang->formatNum(sprintf("%0.1f", ($cntDate * 100) / $cntAll));
				$this->writeXLSNumber($row,$col,$rowValue);
			}
			$row++;
		}

		unset($articleCount);
		unset($articleSize);
		$this->setXLSFileEnd();
	}
	
	public function makeDBNamespaceStats($city_id, &$namespaceCount, &$nspaces, &$allowedNamespace)
	{
		global $wgLang;
		
		$kB = 1000;
		$mB = $kB * $kB;
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		#wfMsg('wikistats_filename_other5', $dbname)
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikistats_namespace_records'));
		$this->mergeXLSColsRows(1, 0, 1, count($allowedNamespace) + 1);

		/*
		 * Header
		 */
		$row = 3;
		$this->writeXLSLabel($row,0,wfMsg('wikistats_date'));
		$this->writeXLSLabel($row,1,wfMsg('wikistats_namespace'));
		$this->mergeXLSColsRows($row, 1, $row, count($allowedNamespace));
		$row++;
		// second row
		$col = 0;
		foreach ($nspaces as $n => $nName) {
			if (in_array($n, $allowedNamespace)) {
				$col++;
				$this->writeXLSLabel($row,$col,$nName);
			}
		}

		// data
		$row++;
		foreach ($namespaceCount as $date => $monthStats)
		{
			$cntAll = (array_key_exists('count', $monthStats)) ? intval($monthStats['count']) : 0;
			#---
			$col = 0;
			$dateArr = explode("-",$date);
			$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
			#$out = wfMsg(strtolower(date("M",$stamp))) . " " . $dateArr[0];
			$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
			if ($date == date("Y-m")) {
				$out = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $stamp));
				#$out = wfMsg(strtolower(date("M",$stamp))) . " " . date("d") . ", " . $dateArr[0];
			}
			#---
			$this->writeXLSLabel($row,$col,$out);
			#---
			
			foreach ($nspaces as $n => $nName) {
				if (in_array($n, $allowedNamespace)) {
					$col++;
					$val = (array_key_exists($n, $monthStats)) ? intval($monthStats[$n]) : 0;
					//$out = (empty($val)) ? "" : ($val >= $kB) ? sprintf ("%.1f", $val/$kB)." k" : (($val >= $mB) ? sprintf ("%.1f", $val/$mB)." M" : $val);
					$this->writeXLSNumber($row,$col,$val);
				}
			}
			$row++;
		}

		unset($namespaceCount);
		unset($nspaces);
		unset($allowedNamespace);
		$this->setXLSFileEnd();
	}
	
	public function makeMostEditPagesStats($city_id, &$statsCount, &$mSourceMetaSpace)
	{
		global $wgCanonicalNamespaceNames;
		global $wgLang, $wgDBname;

		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		#wfMsg('wikistats_filename_other6', $dbname)
		$this->setXLSHeader();
		$centralVersion = ($wgDBname == CENTRAL_WIKIA_ID);
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .str_replace("&gt;", ">", wfMsg('wikistats_page_edits')) );
		$this->mergeXLSColsRows(1, 0, 1, 6);
		$this->writeXLSLabel(3,0,wfMsg('wikistats_page_edits_count', count($statsCount)));
		$this->mergeXLSColsRows(3, 0, 3, 6);

		/*
		 * Header
		 */
		$row = 5;
		$this->writeXLSLabel($row,0,'#');
		$this->writeXLSLabel($row,1,wfMsg('wikistats_edits'));
		$this->mergeXLSColsRows($row, 1, $row, 2);
		$this->writeXLSLabel($row,3,wfMsg('wikistats_unique_users'));
		$this->mergeXLSColsRows($row, 3, $row, 4);
		$this->writeXLSLabel($row,5,wfMsg('wikistats_articles_text'));
		$this->mergeXLSColsRows($row, 5, $row+1, 5);
		$this->writeXLSLabel($row,6,wfMsg('wikistats_archived'));
		$this->mergeXLSColsRows($row, 6, $row+1, 6);
		// second row
		$row++;
		$this->writeXLSLabel($row,1,ucfirst(wfMsg('wikistats_total')));
		$this->writeXLSLabel($row,2,wfMsg('wikistats_register') . " [%]");
		$this->writeXLSLabel($row,3,wfMsg('wikistats_register'));
		$this->writeXLSLabel($row,4,wfMsg('wikistats_unregister'));

		$row++;
		if (!empty($statsCount)) {
			$Kb = 1024 ;
			$Mb = $Kb * $Kb ;
			$Gb = $Kb * $Kb * $Kb ;
			
			$rank = 0;
			foreach ($statsCount as $cnt => $stats) {
				$col = 0;
				$rank++;
				$reg_edits = ($stats['reg_edits']) ? sprintf("%0.0f", ($stats['reg_edits']/$cnt) * 100) : sprintf("%0.0f", $stats['reg_edits']);
				#---
				if ($stats['archived'] < $Mb) { 
					$mbT = wfMsg('size-megabytes', 1);
					$size = "< " . $mbT; 
				} else { 
					$size = wfMsg('size-megabytes', $wgLang->formatNum(sprintf ("%.1f", $stats['archived'] / $Mb)));
				}
				#---
				
    			if (!empty($centralVersion)) {
    				$naName = (array_key_exists($stats['namespace'], $wgCanonicalNamespaceNames)) ? $wgCanonicalNamespaceNames[$stats['namespace']] : "";
					if (in_array($stats['namespace'], array(NS_PROJECT, NS_PROJECT_TALK))) {
						$canonName = (array_key_exists($stats['namespace'], $wgCanonicalNamespaceNames)) ? $wgCanonicalNamespaceNames[$stats['namespace']] : "";
						$naName = (!empty($projectNamespace)) ? $projectNamespace : $canonName;
						if ( ($stats['namespace'] == NS_PROJECT_TALK) && (!empty($projectNamespace)) ) {
							$aC = explode("_", $canonName);
							if ( count( $aC ) > 1 ) {
								$naName = $projectNamespace."_".$aC[ count( $aC ) - 1 ];
							}
						}
					}
					$title = ($naName) ? $naName . ":" . $stats['page_title'] : $stats['page_title'];
				} else {
					$t = Title::newFromText($stats['page_title'], $stats['namespace']);
					$title = $t->getPrefixedDBKey();
				}
				
				#---
				$this->writeXLSNumber($row, $col, intval($rank));$col++;
				$this->writeXLSNumber($row, $col, intval($cnt));$col++;
				$this->writeXLSNumber($row, $col, $reg_edits);$col++;
				$this->writeXLSNumber($row, $col, $stats['reg_users']);$col++;
				$this->writeXLSNumber($row, $col, $stats['unreg_users']);$col++;
				$this->writeXLSLabel($row, $col, $title);$col++;
				$this->writeXLSLabel($row, $col, $size);$col++;
				
				$row++;
			}
		}

		unset($statsCount);
		unset($mSourceMetaSpace);
		$this->setXLSFileEnd();
	}
	

	public function makePageViewsXLS($city_id, $statsCount, $mSourceMetaSpace, $otherNspaces)
	{
		global $wgCanonicalNamespaceNames;
		global $wgLang, $wgDBname;

		$canonicalNamespace = WikiFactory::getVarValueByName('wgExtraNamespacesLocal', $city_id);
		if ( is_array($aNamespaces) ) {
			$canonicalNamespace = array_merge($wgCanonicalNamespaceNames, $canonicalNamespace);
		} else {
			$canonicalNamespace = $wgCanonicalNamespaceNames;
		}

		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		#wfMsg('wikistats_filename_other8', $dbname)
		$this->setXLSHeader();
		$centralVersion = ($wgDBname == CENTRAL_WIKIA_ID);
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikistats_pageviews') );
		$this->mergeXLSColsRows(1, 0, 1, 6);
		$this->writeXLSLabel(2,0,wfMsg('wikistats_pageviews_subtext'));
		$this->mergeXLSColsRows(2, 0, 2, 6);
		$this->writeXLSLabel(3,0,wfMsg('wikistats_pageviews_counting'));
		$this->mergeXLSColsRows(3, 0, 3, 6);

		/*
		 * Header
		 */
		$aNamespaces = $statsCount['namespaces'];
		ksort($aNamespaces, SORT_NUMERIC);
		$row = 5;
		$this->writeXLSLabel($row,1,wfMsg('wikistats_date'));
		$this->mergeXLSColsRows($row, 1, $row+1, 1);
		$this->writeXLSLabel($row,2,wfMsg('wikistats_namespace'));
		$this->mergeXLSColsRows($row, 2, $row, 2+(count($aNamespaces)-1));

		$row++;
		$loop = 0; foreach ($aNamespaces as $id => $value) {
			$this->writeXLSLabel($row,2+$loop, ($id == 0) ? $wgLang->ucfirst(wfMsg('wikistats_content')) : (isset($canonicalNamespace[$id]) ? $canonicalNamespace[$id] : $id));
			$loop++;
		}
		
		$rows = $rows_month = array();
		if (!empty($statsCount['months'])) {
			$loop = 0;
			foreach ($statsCount['months'] as $date => $values) {
				$aRow = array();
				$dateArr = explode("-",$date);
				$is_month = 0; if (!isset($dateArr[2])) {
					$is_month = 1;
				}
				/*$stamp = mktime(23,59,59,$dateArr[1],($is_month)?1:$dateArr[2],$dateArr[0]);
				$out = $wgLang->sprintfDate(($is_month)?"M Y":WikiaGenericStats::getStatsDateFormat(1), wfTimestamp(TS_MW, $stamp));
				*/
				$aRow[] = $date; #$out;
				foreach ($aNamespaces as $id => $value) {
					$_tmp = (isset($values[$id])) ? $values[$id] : 0;
					$aRow[] = $_tmp;
				}
				($is_month == 0) ? $rows[] = $aRow : $rows_month[] = $aRow;
			} 			
		}

		# daily first
		$row++;
		if (!empty($rows)) {
			$loop = 0;
			for ($id = count($rows)-1; $id >= 0; $id--) {
				$aRow = $rows[$id]; 
				if (!empty($aRow)) {
					foreach ($aRow as $col => $value) {
						$this->writeXLSLabel($row + $loop,$col+1,$value);
					} 
				}
				$loop++;
			}
			$row = $row + $loop;
		}
	
		# monthly next
		$row++;
		if (!empty($rows_month)) {
			$loop = 0;
			for ($id = count($rows_month)-1; $id >= 0; $id--) {
				$loop++;
				$aRow = $rows_month[$id]; 
				if (!empty($aRow)) {
					foreach ($aRow as $col => $value) {
						$this->writeXLSLabel($row+$loop,$col+1,$value);
					} 
				}
			}
		}

		unset($statsCount);
		unset($mSourceMetaSpace);
		$this->setXLSFileEnd();
	}

	public function makeMostEditOtherNspacesStats($city_id, &$statsCount, &$mSourceMetaSpace)
	{
		global $wgCanonicalNamespaceNames;
		global $wgLang, $wgDBname;

		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		#wfMsg('wikistats_filename_other7', $dbname)
		$this->setXLSHeader();
		$centralVersion = ($wgDBname == CENTRAL_WIKIA_ID);
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .str_replace("&gt;", ">", wfMsg('wikistats_other_nspaces_edits')) );
		$this->mergeXLSColsRows(1, 0, 1, 6);
		$this->writeXLSLabel(3,0,wfMsg('wikistats_other_nspaces_edits_count', count($statsCount)));
		$this->mergeXLSColsRows(3, 0, 3, 6);

		/*
		 * Header
		 */
		$row = 5;
		$this->writeXLSLabel($row,0,'#');
		$this->writeXLSLabel($row,1,wfMsg('wikistats_edits'));
		$this->mergeXLSColsRows($row, 1, $row, 2);
		$this->writeXLSLabel($row,3,wfMsg('wikistats_unique_users'));
		$this->mergeXLSColsRows($row, 3, $row, 4);
		$this->writeXLSLabel($row,5,wfMsg('wikistats_articles_text'));
		$this->mergeXLSColsRows($row, 5, $row+1, 5);
		$this->writeXLSLabel($row,6,wfMsg('wikistats_archived'));
		$this->mergeXLSColsRows($row, 6, $row+1, 6);
		// second row
		$row++;
		$this->writeXLSLabel($row,1,ucfirst(wfMsg('wikistats_total')));
		$this->writeXLSLabel($row,2,wfMsg('wikistats_register') . " [%]");
		$this->writeXLSLabel($row,3,wfMsg('wikistats_register'));
		$this->writeXLSLabel($row,4,wfMsg('wikistats_unregister'));

		$row++;
		if (!empty($statsCount)) {
			$Kb = 1024 ;
			$Mb = $Kb * $Kb ;
			$Gb = $Kb * $Kb * $Kb ;
			
			$rank = 0;
			foreach ($statsCount as $cnt => $stats) {
				$col = 0;
				$rank++;
				$reg_edits = ($stats['reg_edits']) ? sprintf("%0.0f", ($stats['reg_edits']/$cnt) * 100) : sprintf("%0.0f", $stats['reg_edits']);
				#---
				if ($stats['archived'] < $Mb) { 
					$mbT = wfMsg('size-megabytes', 1);
					$size = "< " . $mbT; 
				} else { 
					$size = wfMsg('size-megabytes', $wgLang->formatNum(sprintf ("%.1f", $stats['archived'] / $Mb)));
				}
				#---
    			if (!empty($centralVersion)) {
    				$naName = (array_key_exists($stats['namespace'], $wgCanonicalNamespaceNames)) ? $wgCanonicalNamespaceNames[$stats['namespace']] : "";
					if (in_array($stats['namespace'], array(NS_PROJECT, NS_PROJECT_TALK))) {
						$canonName = (array_key_exists($stats['namespace'], $wgCanonicalNamespaceNames)) ? $wgCanonicalNamespaceNames[$stats['namespace']] : "";
						$naName = (!empty($projectNamespace)) ? $projectNamespace : $canonName;
						if ( ($stats['namespace'] == NS_PROJECT_TALK) && (!empty($projectNamespace)) ) {
							$aC = explode("_", $canonName);
							if ( count( $aC ) > 1 ) {
								$naName = $projectNamespace."_".$aC[ count( $aC ) - 1 ];
							}
						}
					}
					$title = ($naName) ? $naName . ":" . $stats['page_title'] : $stats['page_title'];
				} else {
					$t = Title::newFromText($stats['page_title'], $stats['namespace']);
					$title = $t->getPrefixedDBKey();
				}
				#---
				$this->writeXLSNumber($row, $col, intval($rank));$col++;
				$this->writeXLSNumber($row, $col, intval($cnt));$col++;
				$this->writeXLSNumber($row, $col, $reg_edits);$col++;
				$this->writeXLSNumber($row, $col, $stats['reg_users']);$col++;
				$this->writeXLSNumber($row, $col, $stats['unreg_users']);$col++;
				$this->writeXLSLabel($row, $col, $title);$col++;
				$this->writeXLSLabel($row, $col, $size);$col++;
				
				$row++;
			}
		}

		unset($statsCount);
		unset($mSourceMetaSpace);
		$this->setXLSFileEnd();
	}
	
	private function makeTrendMeanFormula($row1, $row2, $col1, $col2)
	{
		global $wgLang;
		#--- F O R M U L A ( mean )
		$sum = 0;
		$meanInfo = wfMsg('wikistats_trend_mean_info')." \r\n";
		$meanInfo .= wfMsg('wikistats_trend_formula'). ": ";
		for ($i = 1; $i <= STATS_TREND_MONTH; $i++) {
			$cur_date = mktime(23, 59, 59, (date('m') + 1) - (STATS_TREND_MONTH - $i), 0, date('Y'));
			#---
			$day = ($i == STATS_TREND_MONTH) ? date("d") : date("d", $cur_date);
			$sum += $day;
			$month = $wgLang->sprintfDate("M", wfTimestamp(TS_MW, $cur_date));
			#---
			$variable = "X" . $i;
			$meanArray[0][] = $variable;
			$meanArray[1][] = $variable . " = " . $day . " x " . wfMsg('wikistats_trend_value') . "[" . $month . "]";
			$meanArray[2][] = $day;
		}
		#---
		$meanInfo .= "(" . implode(" + ", $meanArray[0]) . ") / Y1 \n" . wfMsg('wikistats_trend_where_text') . " \n";
		$meanInfo .= implode(",\n", $meanArray[1]).",\n";
		$meanInfo .= "Y1 = ".implode(" + ", $meanArray[2])." = ". $sum ;

		$this->writeXLSLabel($row1,$col1,$meanInfo);
		$this->mergeXLSColsRows($row1, $col1, $row2, $col2);
		
		unset($meanInfo);
	}

	private function makeGrowthMeanFormula($row1, $row2, $col1, $col2)
	{
		global $wgLang;
		
		$growthInfo = wfMsg('wikistats_trend_growth_info'). "\n";
		$growthInfo .= wfMsg('wikistats_trend_formula'). ": ";
		#---
		$sum = 0;
		for ($i = 1; $i <= STATS_TREND_MONTH; $i++) {
			$cur_date = mktime(23, 59, 59, (date('m') + 1) - (STATS_TREND_MONTH - $i), 0, date('Y'));
			$next_date = mktime(23, 59, 59, (date('m') + 1) - (STATS_TREND_MONTH - $i - 1), 0, date('Y'));
			#---
			$day = ($i == STATS_TREND_MONTH) ? date("d") : date("d", $next_date);
			#---
			$month = $wgLang->sprintfDate("M", wfTimestamp(TS_MW, $cur_date));
			#---
			$next_month = $wgLang->sprintfDate("M", wfTimestamp(TS_MW, $next_date));
			#---
			if ($i < STATS_TREND_MONTH) {
				$sum += $day;
				$variable = "G" . $i ;
				$growthArray[0][] = $variable;
				$growthArray[1][] = $variable . "= " . $day . " x ([$next_month]-[$month])/[$month]";
				$growthArray[2][] = $day;
			}
		}
		#---
		$growthInfo .= "100% x (" . implode(" + ", $growthArray[0]) . ") / Y2 \n" . wfMsg('wikistats_trend_where_text') . "\n";
		$growthInfo .= implode(",\n", $growthArray[1]).",\n";
		$growthInfo .= "Y2 = ".implode(" + ", $growthArray[2])." = " . $sum;

		$this->writeXLSLabel($row1,$col1,$growthInfo);
		$this->mergeXLSColsRows($row1, $col1, $row2, $col2);
		
		unset($growthInfo);
	}
	
	private function makeCitiesMenu($cityOrderList, $cityList, $row, $col)
	{
		if (is_array($cityOrderList)) {
			foreach ($cityOrderList as $id => $city_id) {
				$wikiaName = ($city_id == 0) ? wfMsg('wikistats_trend_all_wikia_text') : $cityList[$city_id]['dbname'];
				$this->writeXLSLabel($row,$col,$wikiaName);
				$col++;
			}
		}
	}
	
	public function makeTrendStats($city_id, &$trend_stats, &$month_array, &$cityList, &$cityOrderList)
	{
		global $wgLang;
		$G = 1000 * 1000 * 1000;
		$M = 1000 * 1000;
		$K = 1000;	
		$GB = 1024 * 1024 * 1024;
		$MB = 1024 * 1024;
		$KB = 1024;	
		
		#wfMsg('wikistats_filename_trend', date('Ymd'))
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$col = 0;
		$this->writeXLSLabel(1, $col, wfMsg('wikistats_comparisons_table_1'));
		$this->mergeXLSColsRows(1, $col, 1, $col + (count($cityOrderList) + 1));

		$row1 = 3; $row2 = (3 * $row1) + 2;
		$col1 = 0; $col2 = 4 * ($col1 + 1);
		$this->makeTrendMeanFormula($row1, $row2, $col1, $col2);

		$col1 = $col2 + 2; $col2 = $col1 + 5;
		$this->makeGrowthMeanFormula($row1, $row2, $col1, $col2);

		// show statistics
		$row = $row2 + 2;
		$i = 0;
		foreach ($trend_stats as $column => $dateValues) {
			$col1 = 0; $col2 = $col1 + 4;
			$linkText = array(
				"wikians" => wfMsg('wikistats_distrib_wikians'), 
				"articles" => wfMsg('wikistats_articles_text'), 
				"database" => wfMsg('wikistats_database'), 
				"links" => wfMsg('wikistats_links'), 
				"images" => wfMsg('wikistats_images')				
			);

			$active = "";
			if (($i >= 0) && ($i < 7)) {
				$active = $linkText["wikians"];
				$linkText["wikians"] = "";
			} elseif ( ($i >= 7) && ($i < 14) ) {
				$active = $linkText["articles"];
				$linkText["articles"] = "";
			} elseif ( ($i >= 14) && ($i < 17) ) {
				$active = $linkText["database"];
				$linkText["database"] = "";
			} elseif ( ($i >= 17) && ($i < 22) ) {
				$active = $linkText["links"];
				$linkText["links"] = "";
			} elseif ( ($i >= 22) && ($i < 24) ) {
				$active = $linkText["images"];
				$linkText["images"] = "";
			}

			$loop = 0;	
			$links = array();
			foreach ($linkText as $id => $name) {
				if (!empty($name)) {
					$links[] = $name;
				}
				$loop++;
			}

			$this->writeXLSLabel($row, $col1, "(".$column.") " . implode (" - ", $links));
			$this->mergeXLSColsRows($row, $col1, $row, $col2); 
			
			$col1 = $col2 + 1;
			$this->writeXLSLabel($row, $col1, $active . " - " . wfMsg('wikistats_mainstats_short_column_' . $column));

			$row++; $col1 = 2;
			$this->makeCitiesMenu($cityOrderList, $cityList, $row, $col1);

			$loop = 0;
			$row++;
			foreach ($dateValues as $date => $cities) {
				$col1 = 0;
				$trend = 0;
				$growth = 0;
				if ($loop == 0) { #--- current date
					$dateArr = explode("-", date("Y-m-d"));
					#---
					$stamp = mktime(23,59,59,$dateArr[1],$dateArr[2],$dateArr[0]);
					#$outDate = wfMsg(strtolower(date("M",$stamp))) . " " . $dateArr[2] .", ". $dateArr[0];
					$outDate = $wgLang->sprintfDate(WikiaGenericStats::getStatsDateFormat(), wfTimestamp(TS_MW, $stamp));
				} else {
					if (!in_array($date, array('trend', 'mean', 'growth'))) {
						$dateArr = explode("-", $date);
						#---
						$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
						#$outDate = wfMsg(strtolower(date("M",$stamp))) . " ".$dateArr[0];
						$outDate = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
					} else {
						if ($date == 'trend') {
							$trend = 1;
							$dateArr = explode("-", date("Y-m-f"));
							#---
							$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
							#$outDate = wfMsg(strtolower(date("M",$stamp))) . " ".$dateArr[0];
							$outDate = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
						} else {
							$outDate = ucfirst($date);
							$growth = ($date == 'growth') ? 1 : 0;
						}
					}
				}

				$this->writeXLSLabel($row, $col1, $outDate); $col2 = $col1 + 1;
				$this->mergeXLSColsRows($row, $col1, $row, $col2); 

				$col1 = $col2 + 1;
				foreach ($cityOrderList as $id => $city_id) {
					$out = "";
					$city_values = (array_key_exists($city_id, $cities)) ? $cities[$city_id] : 0;
					if (empty($growth)) {
						if ($column == 'G')
							$out = sprintf("%0d", $city_values);
						elseif ($column == 'K')
							$out = $wgLang->formatNum(sprintf("%0.1f", $city_values));
						elseif ($column == 'L')
							$out = sprintf("%0.0f", $city_values);
						elseif (($column == 'M') || ($column == 'N'))
							$out = sprintf("%0d%%", $city_values * 100);
						elseif ($column == 'P') {
							if (intval($city_values) > $GB) 
								$out = wfMsg('size-gibabytes', $wgLang->formatNum(sprintf("%0.1f", $city_values/$GB)));
							elseif (intval($city_values) > $MB)
								$out = wfMsg('size-megabytes', $wgLang->formatNum(sprintf("%0.1f", $city_values/$MB)));
							elseif ($city_values > $KB)
								$out = wfMsg('size-kilobytes', $wgLang->formatNum(sprintf("%0.1f", $city_values/$KB)));
							else
								$out = sprintf("%0d", intval($city_values));
						} else {
							$out = sprintf("%0d", $city_values);
						}
					} else {
						$out = sprintf("%0d", $city_values);
						if ($out >= 100) $out = "";
					}
					#---
					if ($trend == 1) {
						$out = "+/-".$out;
					}
					$out .= (($growth == 1) && ($out !== "") && (strpos($out,"%") === false)) ? "%" : "";
					
					if (is_numeric($out))
						$this->writeXLSNumber($row, $col1, $out); 
					else
						$this->writeXLSLabel($row, $col1, $out); 
					
					#---
					$col1++;
				}
				$loop++;
				$row++;
			}
			$row = $row + 2;
			$i++;
		}

		unset($cityList);
		unset($trend_stats);
		unset($month_array);
		unset($cityOrderList);
		$this->setXLSFileEnd();
	}
	
	public function makeCreationStats($cityList, &$arr_wikians, &$dWikians, &$arr_article, &$dArticles)
	{
		global $wgLang;
		#wfMsg('wikistats_filename_creation', date('Ymd'))
		$this->setXLSHeader();
		#----
		$max_wikians = (is_array($arr_wikians)) ? $arr_wikians[1] : 1;
		$max_articles = (is_array($arr_article)) ? $arr_article[1] : 1;
		$max_width = ($max_wikians >= $max_articles) ? $max_wikians : $max_articles;
		#---
		$wikians = (is_array($arr_wikians)) ? $arr_wikians[0] : array();
		$article = (is_array($arr_article)) ? $arr_article[0] : array();
		unset($arr_wikians);
		unset($arr_article);
		#---
		$this->setXLSFileBegin();
		$col = 0;
		$this->writeXLSLabel(1, $col, wfMsg('wikistats_creation_wikia_text'));
		#---
		$row = 3;
		$this->writeXLSLabel($row, $col, wfMsg('wikistats_mainstats_short_column_A') . "\n" . wfMsg('wikistats_mainstats_column_A'));
		#---
		$start_row = $row;
		if (!empty($dWikians) && is_array($dWikians)) {
			$col = 0;
			foreach ($dWikians as $id => $date)	{
				$row = $start_row + 3;
				$dateArr = explode("-", $date);
				#---
				$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
				#$outDate = wfMsg(strtolower(date("M",$stamp))) . " ".$dateArr[0];
				$outDate = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));

				$this->writeXLSLabel($row, $col, $outDate); 
				#---
				$col++;
				$row++;
				if ( !empty($wikians) && !empty($wikians[$date]) ) {
					foreach ($wikians[$date] as $id => $wikiaInfo) {
						$dbname = (array_key_exists($wikiaInfo['city_id'], $cityList)) ? $cityList[$wikiaInfo['city_id']]['dbname'] : "";
						#---
						$this->writeXLSLabel($row, $col, $dbname."(".$wikiaInfo['cnt'].")"); 
						$row++;
					}
				}
			}
		}

		$row = $start_row;
		$col += 2;
		$this->writeXLSLabel($row, $col, wfMsg('wikistats_mainstats_short_column_E') . "\n" . wfMsg('wikistats_mainstats_column_E'));

		if (!empty($dArticles) && is_array($dArticles))	{
			foreach ($dArticles as $id => $date) {
				$row = $start_row + 3;
				$dateArr = explode("-", $date);
				#---
				$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
				#$outDate = wfMsg(strtolower(date("M",$stamp))) . " ".$dateArr[0];
				$outDate = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
				#---
				$this->writeXLSLabel($row, $col, $outDate); 
				#---
				$col++;
				$row++;
				if ( !empty($article) && !empty($article[$date]) ) {
					foreach ($article[$date] as $id => $wikiaInfo) {
						$dbname = (array_key_exists($wikiaInfo['city_id'], $cityList)) ? $cityList[$wikiaInfo['city_id']]['dbname'] : "";
						$this->writeXLSLabel($row, $col, $dbname."(".$wikiaInfo['cnt'].")"); 
						$row++;
					}
				}
			}
		}

		unset($cityList);
		unset($wikians);
		unset($dWikians);
		unset($article);
		unset($dArticles);
		$this->setXLSFileEnd();
	}
	
	public function makeColumnStats($column,&$cityList,$nbrCities,&$splitCityList,&$columnHistory,&$columnRange)
	{
		global $wgLang;
		
		$columnLetter = $columnRange[$column-3];
		#wfMsg("wikistats_filename_column_" . $columnLetter)
		$this->setXLSHeader();
		#----
		$this->setXLSFileBegin();
		$col = 1;
		$this->writeXLSLabel(1, $col, wfMsg("wikistats_filename_column_" . $columnLetter));
		$this->mergeXLSColsRows(1, $col, 1, $col + count($splitCityList));
		
		$rows = array(); $loop = 0;
		$col += 1; $row = 3;
		$this->makeCitiesMenu($splitCityList, $cityList, $row, $col);

		$loop = 0;
		$prev_date = "";
		foreach ($columnHistory as $date => $dateValues) {
			$col = 1; $row++;
			$show_percent = false;
			$cur_date = $date;
			#---
			$addEmptyLine = (!empty($prev_date)) ? WikiaGenericStats::checkColumnStatDate($date, $prev_date) : false;
			#---
			if ($addEmptyLine !== false) {
				$this->mergeXLSColsRows($row, $col, $row, $col + count($splitCityList));
				$row++;
			}
	
			if (strpos($date, STATS_COLUMN_PREFIX) !== false) {
				$date = str_replace(STATS_COLUMN_PREFIX, "", $date);
				$show_percent = true;
			}
			#---
			$outDate = WikiaGenericStats::makeCorrectDate($date, ($date==date('Y-m')));
			#---
			$this->writeXLSLabel($row, $col, $outDate); 
			#---
			foreach ($splitCityList as $id => $city_id) {
				$col++;
				$output = "";
				if (array_key_exists($city_id, $dateValues)) {
					if ($dateValues[$city_id] != "null") {
						if ($show_percent === false) {
							if (in_array($columnLetter, array("J","K"))) {
								$output = $wgLang->formatNum(sprintf("%0.1f", 100 * $dateValues[$city_id]));
							} else {
								$output = $wgLang->formatNum(sprintf("%0.1f", $dateValues[$city_id]));
							}
						} else {
							$output = sprintf("%0.0f%%", $dateValues[$city_id]);
						}
					}
				}
				#---
				if (is_numeric($output))
					$this->writeXLSNumber($row, $col, $output); 
				else
					$this->writeXLSLabel($row, $col, $output); 
			}
			#---
			$prev_date = $cur_date;
		}
		
		unset($cityList);
		unset($splitCityList);
		unset($columnHistory);
		unset($columnRange);
		$this->setXLSFileEnd();
	}
}
