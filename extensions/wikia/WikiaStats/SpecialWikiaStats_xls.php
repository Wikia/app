<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage - generate XLS files for statistics
 * @author Piotr Molski <moli@wikia.com>
 * @version: $Id$
 */

class WikiaStatsXLS {
	//--
	function __construct() {
		//
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
		echo pack("sssss", 0x203, 14, $row, $col, 0x0);
		echo pack("d", $value);
		return;
	}

	private function writeXLSLabel($row, $col, $value ) {
		$len = strlen($value);
		echo pack("ssssss", 0x204, 8 + $len, $row, $col, 0x0, $len);
		echo $value;
		return;
	}

	public function setXLSHeader($dbname) {
		header("HTTP/1.0 200 OK");
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");;
		header("Content-Disposition: attachment;filename=".str_replace(" ", "_", $dbname).".xls "); 
		header("Content-Transfer-Encoding: binary ");
	}
	
	public function getXLSCityDBName($city_id) {
		$dbname = WikiFactory::IDtoDB($city_id);
		if (empty($dbname)) {
			$dbname = sprintf(DEFAULT_WIKIA_XLS_FILENAME, intval($city_id));
		}
		#---
		return $dbname;
	}
	
	public function generateEmptyFile()	{
		$dbname = sprintf(DEFAULT_WIKIA_XLS_FILENAME, intval($cityId));
		$this->setXLSHeader($dbname);
		#----
		$this->setXLSFileBegin();
		$this->setXLSFileEnd();
	}
	
	public function makeMainStats($data, &$columns, &$monthlyStats, $city_id) {
		global $wgUser;
		
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		#----
		$this->setXLSHeader($dbname);
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,1,ucfirst($dbname). " - " .wfMsg('wikiastats_pagetitle'));
		$this->mergeXLSColsRows(1, 0, 1, count($columns));
		/*
		 * table header
		 */
		$col_date = 0;
		$this->writeXLSLabel(3, $col_date, wfMsg('wikiastats_date'));
		$col_wikians = 1;
		$this->writeXLSLabel(3, $col_wikians, wfMsg('wikiastats_wikians'));
		$this->mergeXLSColsRows(3, $col_wikians, 3, $col_wikians + 3);
		$col_articles = 5;
		$this->writeXLSLabel(3, $col_articles, wfMsg('wikiastats_articles'));
		$this->mergeXLSColsRows(3, $col_articles, 3, $col_articles + 6);
		$col_db = 12;
		$this->writeXLSLabel(3, $col_db, wfMsg('wikiastats_database'));
		$this->mergeXLSColsRows(3, $col_db, 3, $col_db + 2);
		$col_links = 15;
		$this->writeXLSLabel(3, $col_links, wfMsg('wikiastats_links'));
		$this->mergeXLSColsRows(3, $col_links, 3, $col_links + 4);
		$col_image = 20;
		$this->writeXLSLabel(3, $col_image, wfMsg('wikiastats_images'));
		$this->mergeXLSColsRows(3, $col_image, 3, $col_image + 1);
		$col_users = 22;
		$this->writeXLSLabel(3, $col_users, wfMsg('wikiastats_reg_users'));
		$this->mergeXLSColsRows(3, $col_users, 3, $col_users + 3);

		// second row
		// date
		$this->writeXLSLabel(4, 0, '');
		// wikians
		$this->writeXLSLabel(4,1,wfMsg('wikiastats_total'));
		$this->mergeXLSColsRows(4, 1, 5, 1);
		$this->writeXLSLabel(4,2,wfMsg('wikiastats_new'));
		$this->mergeXLSColsRows(4, 2, 5, 2);
		$this->writeXLSLabel(4,3,wfMsg('wikiastats_edits'));
		$this->writeXLSLabel(5,3,">5");
		$this->writeXLSLabel(5,4,">100");
		// articles
		$this->writeXLSLabel(4,5,wfMsg('wikiastats_count'));
		$this->mergeXLSColsRows(4, 5, 4, 6);
		$this->writeXLSLabel(5,5,wfMsg('wikiastats_official'));
		$this->writeXLSLabel(5,6,wfMsg('wikiastats_more_200_ch'));
		//
		$this->writeXLSLabel(4,7,wfMsg('wikiastats_new_per_day'));
		$this->mergeXLSColsRows(4, 7, 5, 7);
		//
		$this->writeXLSLabel(4,5,wfMsg('wikiastats_mean'));
		$this->mergeXLSColsRows(4, 8, 4, 9);
		$this->writeXLSLabel(5,8,wfMsg('wikiastats_edits'));
		$this->writeXLSLabel(5,9,wfMsg('wikiastats_bytes'));
		//
		$this->writeXLSLabel(4,10,wfMsg('wikiastats_larger_than'));
		$this->mergeXLSColsRows(4, 10, 4, 11);
		$this->writeXLSLabel(5,10,'0.5Kb');
		$this->writeXLSLabel(5,11,'2.0Kb');
		// database
		$this->writeXLSLabel(4,12,wfMsg('wikiastats_edits'));
		$this->mergeXLSColsRows(4, 12, 5, 12);
		$this->writeXLSLabel(4,13,wfMsg('wikiastats_size'));
		$this->mergeXLSColsRows(4, 13, 5, 13);
		$this->writeXLSLabel(4,14,wfMsg('wikiastats_words'));
		$this->mergeXLSColsRows(4, 14, 5, 14);
		// links
		$this->writeXLSLabel(4,15,wfMsg('wikiastats_internal'));
		$this->mergeXLSColsRows(4, 15, 5, 15);
		$this->writeXLSLabel(4,16,wfMsg('wikiastats_interwiki'));
		$this->mergeXLSColsRows(4, 16, 5, 16);
		$this->writeXLSLabel(4,17,wfMsg('wikiastats_image'));
		$this->mergeXLSColsRows(4, 17, 5, 17);
		$this->writeXLSLabel(4,18,wfMsg('wikiastats_external'));
		$this->mergeXLSColsRows(4, 18, 5, 18);
		$this->writeXLSLabel(4,19,wfMsg('wikiastats_redirects'));
		$this->mergeXLSColsRows(4, 19, 5, 19);
		// images
		$this->writeXLSLabel(4,20,wfMsg('wikiastats_uploaded_images'));
		$this->mergeXLSColsRows(4, 20, 5, 20);
		$this->writeXLSLabel(4,21,wfMsg('wikiastats_with_links'));
		$this->mergeXLSColsRows(4, 21, 5, 21);
		// unique users
		$this->writeXLSLabel(4,22,wfMsg('wikiastats_total'));
		$this->mergeXLSColsRows(4, 22, 5, 22);
		$this->writeXLSLabel(4,23,wfMsg('wikistats_edited_in_namespace'));
		$this->mergeXLSColsRows(4, 23, 4, 25);
		$this->writeXLSLabel(5,23,wfMsg('wikistats_main_namespace'));
		$this->writeXLSLabel(5,24,wfMsg('wikistats_user_namespace'));
		$this->writeXLSLabel(5,25,wfMsg('wikistats_image_namespace'));		
		
		// monthly stats
		$row = 6;
		foreach ($monthlyStats as $date => $columnsData)
		{
			#---
			if ($columnsData['visible'] === 1)
			{
				$dateArr = explode("-", $date);
				$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
				$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
				// output date in correct format
				$this->writeXLSLabel($row, 0, $outDate);
				//----
				$col = 1;
				foreach ($columns as $column)
				{
					if ( in_array($column, array('date')) ) continue;
					#---
					$out = $columnsData[$column];
					$class = "rb";
					if ( (in_array($column, array('B','H','I','J','K'))) ||
						 (empty($columnsData[$column]) || ($columnsData[$column] == 0)) ||
						 ($columnsData[$column] >= 100) )
					{
						$out = "";
					}
					// output value
					if ($out != "")
					{
						$out = sprintf("%0.0f%%", $out);
						$this->writeXLSNumber($row, $col, $out);
					}
					$col++;
				}
				$row++;
			}
		}
		
		// column's names -> A, B, C ... 
		$col=0;
		foreach ($columns as $column)
		{
			if ($column == "date") $column = "";
			$this->writeXLSLabel($row,$col,$column);
			$col++;
		}
		// statistics
		foreach ($data as $date => $columnsData)
		{
			$row++;
			$G = 1000 * 1000 * 1000;
			$M = 1000 * 1000;
			$K = 1000;	
			$GB = 1024 * 1024 * 1024;
			$MB = 1024 * 1024;
			$KB = 1024;	
			$col=0;
			foreach ($columns as $column)
			{
				$out = $columnsData[$column];
				if (empty($columnsData[$column]) || ($columnsData[$column] == 0)) {
					$out = "";
				}
				else {
					if ($column == 'date') {
						$dateArr = explode("-",$columnsData[$column]);
						$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
						$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
						$today = sprintf("%s-%s", date("Y"), date("m"));
						if ( $columnsData[$column] == $today)
						{
							$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . date("d") . ", " . $dateArr[0];
						}
						$out = addslashes($out);
					}
					elseif ($column == 'H')
						$out = sprintf("%0.1	f", $columnsData[$column]);
					elseif ($column == 'I')
						$out = sprintf("%0.0f", $columnsData[$column]);
					elseif ( in_array($column, array('J', 'K')) )
						$out = sprintf("%0d", $columnsData[$column] * 100);
					else
						$out = sprintf("%0d", intval($columnsData[$column]));
				}
				
				if ($out != "")
				{
					if ($column == 'date')
					{
						$this->writeXLSLabel($row,$col,$out);
					}
					else
					{
						$this->writeXLSNumber($row, $col, $out);
					}
				}
				$col++;
			}
		}
		
		unset($columns);
		unset($monthlyStats);
		$this->setXLSFileEnd();
	}
	
	public function makeDistribStats($city_id, &$statsData)
	{
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		#----
		$this->setXLSHeader($dbname . "_distrib");
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,1,ucfirst($dbname). " - " .wfMsg('wikiastats_distrib_article'));
		$this->mergeXLSColsRows(1, 0, 1, 5);
		/*
		 * table header
		 */
		$this->writeXLSLabel(3, 0, wfMsg('wikiastats_distrib_edits'));
		$this->writeXLSLabel(3, 1, wfMsg('wikiastats_distrib_wikians'));
		$this->mergeXLSColsRows(3, 1, 3, 2);
		$this->writeXLSLabel(3, 3, wfMsg('wikiastats_distrib_edits_total'));
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
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		$this->setXLSHeader($dbname . "_active");
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikiastats_active_absent_wikians'));
		$this->mergeXLSColsRows(1, 0, 1, 11);

		$row = 3;
		if (!empty($active)) {
			/*
			 * header
			 */
			$this->writeXLSLabel(3,0,wfMsg('wikiastats_recently_active_wikians', count($active)));
			$this->mergeXLSColsRows(3, 0, 3, 11);
			$this->writeXLSLabel(4,0,wfMsg('wikiastats_active_wikians_subtitle_info'));
			$this->mergeXLSColsRows(4, 0, 4, 11);
			// first row of table
			$this->writeXLSLabel(6,0,wfMsg('wikiastats_username'));
			$this->writeXLSLabel(6,1,wfMsg('wikiastats_edits'));
			$this->mergeXLSColsRows(6, 1, 6, 6);
			$this->writeXLSLabel(6,7,wfMsg('wikiastats_first_edit'));
			$this->mergeXLSColsRows(6, 7, 7, 8);
			$this->writeXLSLabel(6,9,wfMsg('wikiastats_last_edit'));
			$this->mergeXLSColsRows(6, 9, 7, 10);
			// second row
			$this->writeXLSLabel(7,1,wfMsg('wikiastats_articles_text'));
			$this->mergeXLSColsRows(7, 1, 7, 4);
			$this->writeXLSLabel(7,5,wfMsg('wikiastats_other'));
			$this->mergeXLSColsRows(7, 5, 7, 6);
			// third row
			$this->writeXLSLabel(8,1,wfMsg('wikiastats_rank'));
			$this->mergeXLSColsRows(8, 1, 8, 2);
			$this->writeXLSLabel(8,3,wfMsg('wikiastats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikiastats_active_month') : wfMsg('wikiastats_active_months')));
			$this->mergeXLSColsRows(8, 3, 9, 3);
			$this->writeXLSLabel(8,4,wfMsg('wikiastats_total'));
			$this->mergeXLSColsRows(8, 4, 9, 4);
			$this->writeXLSLabel(8,5,wfMsg('wikiastats_total'));
			$this->mergeXLSColsRows(8, 5, 9, 5);
			$this->writeXLSLabel(8,6,wfMsg('wikiastats_month_ago', $cur_month, ($cur_month == 1) ? wfMsg('wikiastats_active_month') : wfMsg('wikiastats_active_months')));
			$this->mergeXLSColsRows(8, 6, 9, 6);
			$this->writeXLSLabel(8,7,wfMsg('wikiastats_date'));
			$this->mergeXLSColsRows(8, 7, 9, 7);
			$this->writeXLSLabel(8,8,wfMsg('wikiastats_days_ago'));
			$this->mergeXLSColsRows(8, 8, 9, 8);
			$this->writeXLSLabel(8,9,wfMsg('wikiastats_date'));
			$this->mergeXLSColsRows(8, 9, 9, 9);
			$this->writeXLSLabel(8,10,wfMsg('wikiastats_days_ago'));
			$this->mergeXLSColsRows(8, 10, 9, 10);
			// 4th row
			$this->writeXLSLabel(9,1,wfMsg('wikiastats_now'));
			$this->writeXLSLabel(9,2,wfMsg('wikiastats_prev_rank_xls'));

			$row = 10;
			foreach ($active as $rank => $data) {
				$rank_change = $data['rank_change'];
				if ($data['rank_change'] > 0) {
					$rank_change = "+".$rank_change;
				} elseif ($data['rank_change'] == 0) {
					$rank_change = "...";
				}	
				#---
				$outFirstEdit = substr(wfMsg(strtolower(date("F",$data['first_edit']))), 0, 3) . " " . date("d",$data['first_edit']) .", ".date("Y",$data['first_edit']);
				#---
				$outLastEdit = substr(wfMsg(strtolower(date("F",$data['last_edit']))), 0, 3) . " " . date("d",$data['last_edit']) .", ".date("Y",$data['last_edit']);

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
			$this->writeXLSLabel($row,0,wfMsg('wikiastats_recently_absent_wikians', count($absent)));
			$this->mergeXLSColsRows($row, 0, $row, 6);
			$row = $row + 2;
			// first row of table
			$this->writeXLSLabel($row,0,wfMsg('wikiastats_username'));
			$this->writeXLSLabel($row,1,wfMsg('wikiastats_edits'));
			$this->mergeXLSColsRows($row, 1, $row, 2);
			$this->writeXLSLabel($row,3,wfMsg('wikiastats_first_edit'));
			$this->mergeXLSColsRows($row, 3, $row, 4);
			$this->writeXLSLabel($row,5,wfMsg('wikiastats_last_edit'));
			$this->mergeXLSColsRows($row, 5, $row, 6);
			$row++;
			// second row
			$this->writeXLSLabel($row,1,wfMsg('wikiastats_rank'));
			$this->writeXLSLabel($row,2,wfMsg('wikiastats_total'));
			$this->writeXLSLabel($row,3,wfMsg('wikiastats_date'));
			$this->writeXLSLabel($row,4,wfMsg('wikiastats_days_ago'));
			$this->writeXLSLabel($row,5,wfMsg('wikiastats_date'));
			$this->writeXLSLabel($row,6,wfMsg('wikiastats_days_ago'));

			$row++;
			foreach ($absent as $rank => $data) {
				#---
				$outFirstEdit = substr(wfMsg(strtolower(date("F",$data['first_edit']))), 0, 3) . " " . date("d",$data['first_edit']) .", ".date("Y",$data['first_edit']);
				#---
				$outLastEdit = substr(wfMsg(strtolower(date("F",$data['last_edit']))), 0, 3) . " " . date("d",$data['last_edit']) .", ".date("Y",$data['last_edit']);
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
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		$this->setXLSHeader($dbname . "_anon");
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikiastats_anon_wikians'));
		$this->mergeXLSColsRows(1, 0, 1, 7);
		$this->writeXLSLabel(3,0,ucfirst($dbname). " - " .wfMsg('wikiastats_anon_wikians_count', count($anonData)));
		$this->mergeXLSColsRows(3, 0, 3, 7);

		$row = 5;
		if (!empty($anonData)) {
			/*
			 * Header
			 */
			$this->writeXLSLabel($row,0,wfMsg('wikiastats_username'));
			$this->writeXLSLabel($row,1,wfMsg('wikiastats_edits'));
			$this->mergeXLSColsRows($row, 1, $row, 2);
			$this->writeXLSLabel($row,3,wfMsg('wikiastats_first_edit'));
			$this->mergeXLSColsRows($row, 3, $row, 4);
			$this->writeXLSLabel($row,5,wfMsg('wikiastats_last_edit'));
			$this->mergeXLSColsRows($row, 5, $row, 6);
			$row++;
			$this->writeXLSLabel($row,1,wfMsg('wikiastats_rank'));
			$this->writeXLSLabel($row,2,wfMsg('wikiastats_total'));
			$this->writeXLSLabel($row,3,wfMsg('wikiastats_date'));
			$this->writeXLSLabel($row,4,wfMsg('wikiastats_days_ago'));
			$this->writeXLSLabel($row,5,wfMsg('wikiastats_date'));
			$this->writeXLSLabel($row,6,wfMsg('wikiastats_days_ago'));
			$row++;
			$rank = 0;
			foreach ($anonData as $id => $data) {
				$rank++;
				#---
				$outFirstEdit = substr(wfMsg(strtolower(date("F",$data['min']))), 0, 3) . " " . date("d",$data['min']) .", ".date("Y",$data['min']);
				#---
				$outLastEdit = substr(wfMsg(strtolower(date("F",$data['max']))), 0, 3) . " " . date("d",$data['max']) .", ".date("Y",$data['max']);
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
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		$this->setXLSHeader($dbname . "_onelink");
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikiastats_article_one_link'));
		$this->mergeXLSColsRows(1, 0, 1, count($articleSize) + 1);

		/*
		 * Header
		 */
		$row = 3;
		$this->writeXLSLabel($row,0,wfMsg('wikiastats_date'));
		$this->writeXLSLabel($row,1,wfMsg('wikiastats_articles_text') . "(%)");
		$this->mergeXLSColsRows($row, 1, $row, count($articleSize));
		$row++;
		// second line
		$col = 1;
		foreach ($articleSize as $s => $values) {
			$text = "< ".$s." B";
			if ($s >= 1024) $text = "< ".sprintf ("%.0f", $s/1024)." kB";
			$this->writeXLSLabel($row,$col,$text);
			$col++;
		}

		$row++;
		foreach ($articleCount as $date => $monthStats) {
			$col = 0;
			$cntAll = intval($monthStats['count']);
			#---
			$dateArr = explode("-",$date);
			$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
			$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
			if ($date == sprintf("%s-%s", date("Y"), date("m"))) {
				$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . date("d") . ", " . $dateArr[0];
			}
			#---
			$this->writeXLSLabel($row,$col,$out);
			#---
			foreach ($articleSize as $s => $values) {
				$col++;
				$cntDate = array_key_exists($date, $values) ? intval($values[$date]['count']) : 0;
				$rowValue = sprintf("%0.1f", ($cntDate * 100) / $cntAll);
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
		$kB = 1000;
		$mB = $kB * $kB;
		#----
		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		$this->setXLSHeader($dbname . "_dbnspaces");
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .wfMsg('wikiastats_namespace_records'));
		$this->mergeXLSColsRows(1, 0, 1, count($allowedNamespace) + 1);

		/*
		 * Header
		 */
		$row = 3;
		$this->writeXLSLabel($row,0,wfMsg('wikiastats_date'));
		$this->writeXLSLabel($row,1,wfMsg('wikiastats_namespace'));
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
			$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
			$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[0];
			if ($date == sprintf("%s-%s", date("Y"), date("m"))) {
				$out = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . date("d") . ", " . $dateArr[0];
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

		$dbname = $this->getXLSCityDBName($city_id);
		$cur_month = 1;
		#----
		$this->setXLSHeader($dbname . "_mostedit");
		#----
		$this->setXLSFileBegin();
		$this->writeXLSLabel(1,0,ucfirst($dbname). " - " .str_replace("&gt;", ">", wfMsg('wikiastats_page_edits')) );
		$this->mergeXLSColsRows(1, 0, 1, 6);
		$this->writeXLSLabel(3,0,wfMsg('wikiastats_page_edits_count', count($statsCount)));
		$this->mergeXLSColsRows(3, 0, 3, 6);

		/*
		 * Header
		 */
		$row = 5;
		$this->writeXLSLabel($row,0,'#');
		$this->writeXLSLabel($row,1,wfMsg('wikiastats_edits'));
		$this->mergeXLSColsRows($row, 1, $row, 2);
		$this->writeXLSLabel($row,3,wfMsg('wikiastats_unique_users'));
		$this->mergeXLSColsRows($row, 3, $row, 4);
		$this->writeXLSLabel($row,5,wfMsg('wikiastats_articles_text'));
		$this->mergeXLSColsRows($row, 5, $row+1, 5);
		$this->writeXLSLabel($row,6,wfMsg('wikiastats_archived'));
		$this->mergeXLSColsRows($row, 6, $row+1, 6);
		// second row
		$row++;
		$this->writeXLSLabel($row,1,ucfirst(wfMsg('wikiastats_total')));
		$this->writeXLSLabel($row,2,wfMsg('wikiastats_register') . " [%]");
		$this->writeXLSLabel($row,3,wfMsg('wikiastats_register'));
		$this->writeXLSLabel($row,4,wfMsg('wikiastats_unregister'));

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
					$size = "< 1 MB"; 
				} else { 
					$size = sprintf ("%.1f", $stats['archived'] / $Mb) . " MB" ; 
				}
				#---
				$naName = (array_key_exists($stats['namespace'], $wgCanonicalNamespaceNames)) ? $wgCanonicalNamespaceNames[$stats['namespace']] : "";
				if ($stats['namespace'] == 4)
				{
					$naName = (!empty($projectNamespace)) ? $projectNamespace : $naName;
				}
				$title = ($naName) ? $naName . ":" . $stats['page_title'] : $stats['page_title'];
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
		#--- F O R M U L A ( mean )
		$sum = 0;
		$meanInfo = wfMsg('wikiastats_trend_mean_info')." \r\n";
		$meanInfo .= wfMsg('wikiastats_trend_formula'). ": ";
		for ($i = 1; $i <= STATS_TREND_MONTH; $i++) {
			$cur_date = mktime(23, 59, 59, (date('m') + 1) - (STATS_TREND_MONTH - $i), 0, date('Y'));
			#---
			$day = ($i == STATS_TREND_MONTH) ? date("d") : date("d", $cur_date);
			$sum += $day;
			$month = substr(wfMsg(strtolower(date("F",$cur_date))), 0, 3);
			#---
			$variable = "X" . $i;
			$meanArray[0][] = $variable;
			$meanArray[1][] = $variable . " = " . $day . " x " . wfMsg('wikiastats_trend_value') . "[" . $month . "]";
			$meanArray[2][] = $day;
		}
		#---
		$meanInfo .= "(" . implode(" + ", $meanArray[0]) . ") / Y1 \n" . wfMsg('wikiastats_trend_where_text') . " \n";
		$meanInfo .= implode(",\n", $meanArray[1]).",\n";
		$meanInfo .= "Y1 = ".implode(" + ", $meanArray[2])." = ". $sum ;
		
		$this->writeXLSLabel($row1,$col1,$meanInfo);
		$this->mergeXLSColsRows($row1, $col1, $row2, $col2);
		
		unset($meanInfo);
	}

	private function makeGrowthMeanFormula($row1, $row2, $col1, $col2)
	{
		$growthInfo = wfMsg('wikiastats_trend_growth_info'). "\n";
		$growthInfo .= wfMsg('wikiastats_trend_formula'). ": ";
		#---
		$sum = 0;
		for ($i = 1; $i <= STATS_TREND_MONTH; $i++) {
			$cur_date = mktime(23, 59, 59, (date('m') + 1) - (STATS_TREND_MONTH - $i), 0, date('Y'));
			$next_date = mktime(23, 59, 59, (date('m') + 1) - (STATS_TREND_MONTH - $i - 1), 0, date('Y'));
			#---
			$day = ($i == STATS_TREND_MONTH) ? date("d") : date("d", $next_date);
			#---
			$month = substr(wfMsg(strtolower(date("F",$cur_date))), 0, 3);
			$next_month = substr(wfMsg(strtolower(date("F",$next_date))), 0, 3);
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
		$growthInfo .= "100% x (" . implode(" + ", $growthArray[0]) . ") / Y2 \n" . wfMsg('wikiastats_trend_where_text') . "\n";
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
				$wikiaName = ($city_id == 0) ? wfMsg('wikiastats_trend_all_wikia_text') : $cityList[$city_id]['dbname'];
				$this->writeXLSLabel($row,$col,$wikiaName);
				$col++;
			}
		}
	}
	
	public function makeTrendStats($city_id, &$trend_stats, &$month_array, &$cityList, &$cityOrderList)
	{
		$G = 1000 * 1000 * 1000;
		$M = 1000 * 1000;
		$K = 1000;	
		$GB = 1024 * 1024 * 1024;
		$MB = 1024 * 1024;
		$KB = 1024;	
		
		$this->setXLSHeader(wfMsg('wikiastats_comparisons_table_1')."_".date('Ymd'));
		#----
		$this->setXLSFileBegin();
		$col = 0;
		$this->writeXLSLabel(1, $col, wfMsg('wikiastats_comparisons_table_1'));
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
			$linkText = array("wikians" => wfMsg('wikiastats_distrib_wikians'), "articles" => wfMsg('wikiastats_articles_text'), "database" => wfMsg('wikiastats_database'), "links" => wfMsg('wikiastats_links'), "usage" => wfMsg('wikiastats_reg_users'));

			$active = "";
			if (($i >= 0) && ($i < 4)) {
				$active = $linkText["wikians"];
				$linkText["wikians"] = "";
			} elseif ( ($i >= 4) && ($i < 11) ) {
				$active = $linkText["articles"];
				$linkText["articles"] = "";
			} elseif ( ($i >= 11) && ($i < 14) ) {
				$active = $linkText["database"];
				$linkText["database"] = "";
			} elseif ( ($i >= 14) && ($i < 19) ) {
				$active = $linkText["links"];
				$linkText["links"] = "";
			} elseif ( ($i >= 19) && ($i < 21) ) {
				$active = $linkText["usage"];
				$linkText["usage"] = "";
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
			$this->writeXLSLabel($row, $col1, $active . " - " . wfMsg('wikiastats_mainstats_short_column_' . $column));

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
					$stamp = mktime(0,0,0,$dateArr[1],$dateArr[2],$dateArr[0]);
					$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " " . $dateArr[2] .", ". $dateArr[0];
				} else {
					if (!in_array($date, array('trend', 'mean', 'growth'))) {
						$dateArr = explode("-", $date);
						#---
						$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
						$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " ".$dateArr[0];
					} else {
						if ($date == 'trend') {
							$trend = 1;
							$dateArr = explode("-", date("Y-m-f"));
							#---
							$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
							$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " ".$dateArr[0];
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
						if ($column == 'A')
							$out = sprintf("%0d", $city_values);
						elseif ($column == 'H')
							$out = sprintf("%0.1f", $city_values);
						elseif ($column == 'I')
							$out = sprintf("%0.0f", $city_values);
						elseif (($column == 'J') || ($column == 'K'))
							$out = sprintf("%0d%%", $city_values * 100);
						elseif ($column == 'M') {
							if (intval($city_values) > $GB)
								$out = sprintf("%0.1f GB", $city_values/$GB);
							elseif (intval($city_values) > $MB)
								$out = sprintf("%0.1f MB", $city_values/$MB);
							elseif ($city_values > $KB)
								$out = sprintf("%0.1f KB", $city_values/$KB);
							else
								$out = sprintf("%0d", intval($city_values));
						} else {
							if (intval($city_values) > $G)
								$out = sprintf("%0.1f G", intval($city_values/$G));
							elseif (intval($city_values) > $M)
								$out = sprintf("%0.1f M", $city_values/$M);
							//elseif (intval($city_values) > $K)
							//	$out = sprintf("%0.1f k", intval($city_values)/$K);
							else
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
		$this->setXLSHeader(wfMsg('wikiastats_creation_wikia_filename')."_".date('Ymd'));
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
		$this->writeXLSLabel(1, $col, wfMsg('wikiastats_creation_wikia_text'));
		#---
		$row = 3;
		$this->writeXLSLabel($row, $col, wfMsg('wikiastats_mainstats_short_column_A') . "\n" . wfMsg('wikiastats_mainstats_column_A'));
		#---
		$start_row = $row;
		if (!empty($dWikians) && is_array($dWikians)) {
			$col = 0;
			foreach ($dWikians as $id => $date)	{
				$row = $start_row + 3;
				$dateArr = explode("-", $date);
				#---
				$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
				$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " ".$dateArr[0];

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
		$this->writeXLSLabel($row, $col, wfMsg('wikiastats_mainstats_short_column_E') . "\n" . wfMsg('wikiastats_mainstats_column_E'));

		if (!empty($dArticles) && is_array($dArticles))	{
			foreach ($dArticles as $id => $date) {
				$row = $start_row + 3;
				$dateArr = explode("-", $date);
				#---
				$stamp = mktime(0,0,0,$dateArr[1],1,$dateArr[0]);
				$outDate = substr(wfMsg(strtolower(date("F",$stamp))), 0, 3) . " ".$dateArr[0];
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
		$columnLetter = $columnRange[$column-3];
		$filename = wfMsg("wikiastats_mainstats_short_column_" . $columnLetter);
		$this->setXLSHeader($filename);
		#----
		$this->setXLSFileBegin();
		$col = 1;
		$this->writeXLSLabel(1, $col, $filename);
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
								$output = sprintf("%0.1f", 100 * $dateValues[$city_id]);
							} else {
								$output = sprintf("%0.1f", $dateValues[$city_id]);
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
