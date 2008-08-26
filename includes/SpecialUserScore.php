<?php

#
# SpecialUserScore Mediawiki extension
#
# Copyright (C) 2006 Mathias Feindt
# http://www.mediawiki.org/
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
# http://www.gnu.org/copyleft/gpl.html
#
#
# Revisions
# 2006-12-05 MPalmer
# I changed the SQL (also changed SQL to use SQL aliases and FROM clause) statement and modifed formatResult to report n Edits on m pages
# I thought it would be useful to know how many actual pages were being edited...
#
# 2007-12-31 Marooned
# Use MW Messages instead of hardcoded texts
# Fixed broken link to user contributions page

require_once("QueryPage.php");

class UserScorePage extends QueryPage {

	function getName() {
		return "UserScore";
	}

	function isExpensive() {
		return false;
	}

	function isSyndicated() {
		return false;
	}

	function getPageHeader() {
		return wfMsg('user-score-header') . "<br />\n";

	}

	function getSQL() {
		$NScat = NS_CATEGORY;
		$dbr =& wfGetDB( DB_SLAVE );
		$user= $dbr->tableName ('user');
		$revision = $dbr->tableName ('revision');
		$page = $dbr->tableName ('page');
		$s= "
		SELECT
		  COUNT(wr.rev_id) as value,
		  COUNT(DISTINCT wr.rev_page) as page_value,
		  wu.user_name as name,
		  wu.user_real_name as real_name
		FROM
		  $user wu,
		  $revision wr,
		  $page wp
		WHERE
		      wu.user_id = wr.rev_user
		  and wp.page_id = wr.rev_page
		  and wp.page_namespace = 0
		  GROUP BY wu.user_name";

		return $s;
	}

	function sortDescending() {
		return true;
	}

	function formatResult( $skin, $result ) {
		global $wgContLang;

		$title = Title::makeTitle( NS_USER, $result->name );
		$real_name  = $result->real_name ;
		$plink = $skin->makeLinkObj( $title, $title->getText() );
		$nl= $result->value . " Edits on " . $result->page_value . " pages";
		$nlink = $skin->makeKnownLink(
				$wgContLang->specialPage( 'Contributions' ),
				$nl,
				'target=' . $title->getPartialURL() );
		return "$plink $real_name ($nlink)";
	}
}

function wfSpecialUserScore() {
	list( $limit, $offset ) = wfCheckLimits();
	$cap = new UserScorePage();
	return $cap->doQuery( $offset, $limit );
}
?>