<?php

/*
 * Created on November 6, 2009
 *
 * API module for MediaWiki's FlaggedRevs extension
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
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * API module to get flag config info
 *
 * @ingroup FlaggedRevs
 */
class ApiFlagConfig extends ApiBase {

	public function execute() {
		$this->getMain()->setCacheMode( 'public' );
		global $wgFlaggedRevTags;
		$data = array();
		foreach( $wgFlaggedRevTags as $tag => $params ) {
			$tagInfo = array();
			$tagInfo['name'] = $tag;
			$tagInfo['levels'] = $params['levels'];
			$tagInfo['tier2'] = $params['quality'];
			$tagInfo['tier3'] = $params['pristine'];
			$data[] = $tagInfo;
		}
		$result = $this->getResult();
		$result->setIndexedTagName( $data, 'tag' );
		$result->addValue( null, $this->getModuleName(), $data );
	}

	public function mustBePosted() {
		return false;
	}
	
	public function isWriteMode() { 
 		return false; 
 	}

	public function getAllowedParams() {
		return array();
	}
	
	public function getParamDescription() {
		return array();
	}

	public function getDescription() {
		return array(
			'Get basic information about review flag configuration for this site.',
			'The following parameters are returned for each tag:',
			'* name 	: The key name of this tag',
			'* levels 	: Number of levels the tag has (above "not tagged")',
			'* tier2 	: Level the tag must reach for a revision to be tier 2 (quality)',
			'* tier3 	: Level the tag must reach for a revision to be tier 3 (pristine)',
			'Flagged revisions have an assigned level for each tag. The highest tier',
			'that all the tags meet is the review tier of the entire revision.'
		);
	}

	protected function getExamples() {
		return 'api.php?action=flagconfig';
	}
	
	public function getVersion() {
		return __CLASS__.': $Id: ApiFlagConfig.php 69932 2010-07-26 08:03:21Z tstarling $';
	}
}
