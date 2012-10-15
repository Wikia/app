<?php
/**
 * A rudimentary database impl which can retrieve page revision text
 * from backup dumps.  This can be perfectly responsive if you have
 * broken the .bz2 (careful now) into chunks for indexing.
 * 
 **
 * Copyright (C) 2008, 2009 Michael Nowak
 * contributions by Adam Wight, 2011
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
**/

class DatabaseBz2 extends DatabaseBase
{
	function select( $table, $fields, $conds='', $fname = 'DatabaseBase::select', $options = array() )
	{
		$row = array();
		$title = false;
		if (isset($conds['page_title'])) {
			$title = $conds['page_title'];
			if ($conds['page_namespace'] && MWNamespace::getCanonicalName($conds['page_namespace']))
				$title = MWNamespace::getCanonicalName($conds['page_namespace']).':'.$title;
		}

		if ($title && ($table == 'page' || (is_array($table) && in_array('page', $table))))
		{
			if (preg_match('/Template:Pp-/i', $title))
			return false;

			$textid = CachedStorage::fetchIdByTitle($title);
			if (!$textid) {
				$content = DumpReader::load_article($title);
				if (!$content) {
					wfDebug('no content for '.$title);
					return false;
				}
				$textid = CachedStorage::set($title, $content);
			}
		} elseif (isset($conds['rev_id'])) {
			$textid = $conds['rev_id'];
		}

		if (!isset($textid))
			return $this->resultObject(array());

		if ($table == 'page') {
			// Given a page_title, get the id of text content.  For efficiency,
			//	we fetch the text and store it by ID to access in case 2.
			$row = array_fill_keys($fields, '');
			$row['page_id'] = $textid;
			$row['page_title'] = $title;
			$row['page_latest'] = $textid;
		}
		elseif ($table == array('page', 'revision')) { 
			// Redundantly return textid which is cache key to article wml.
			$fields[] = 'rev_user';
			$fields[] = 'rev_user_text';
			$row = array_fill_keys($fields, '');
			$row['rev_id'] = $textid;
			$row['rev_text_id'] = $textid;
		}
		else { print_r($table); print_r($conds); }

		return $this->resultObject($row);
	}


	function open( $server, $user, $password, $dbName ) {
//TODO test article load using TestDumpReader
		return true;
	}

	function fetchObject( $res ) {
		// cast to object
		if (!$res)
		return false;

		$array = $res->result;
		if(!is_array($array)) {
		return $array;
		}
		
		$object = new stdClass();
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name=>$value) {
				if (!empty($name)) {
					$object->$name = $value;
				}
			}
			return $object;
		} else {
			  return false;
		}
	}

	function fetchRow( $res ) {
		return null;
	}

	function numRows( $res ) {
		return 0;
	}

	function numFields( $res ) {
		return 0;
	}

	function fieldName( $res, $n ) {
		return true;
	}

	function insertId() {
		return null;
	}

	function dataSeek( $res, $row ) {
		return true;
	}

	function lastErrno() {
		return null;
	}

	function lastError() {
		return null;
	}

	function affectedRows() {
		return 0;
	}

/*
	function selectField( $table, $var, $cond='', $fname = 'Database::selectField', $options = array() ) {
		return $this->fetchObject($this->select($table, array($var), $cond));
	}
*/

	function indexInfo( $table, $index, $fname = 'Database::indexInfo' ) {
		return null;
	}

	function fieldInfo( $table, $field ) {
		return null;
	}

	function strencode( $s ) {
		return true;
	}

	static function getSoftwareLink() {
		return "[http://www.mysql.com/ MySQL]"; //XXX
	}

	function getServerVersion() {
	//XXX
	}

}
