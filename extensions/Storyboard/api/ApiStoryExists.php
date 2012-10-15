<?php
/**
 * API extension for Storyboard.
 * 
 * @file ApiStoryboard.php
 * @ingroup Storyboard
 * 
 * @author Jeroen De Dauw
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
 */

/**
 * This action returns the html for Stories to be displayed in a storyboard.
 *
 * @ingroup Storyboard
 */
class ApiStoryExists extends ApiBase {
	
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$params = $this->extractRequestParams();
		
		if ( !isset( $params['storytitle'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'storytitle' ) );
		}
		
		$exists = self::StoryExists( $params );
		
		$result = array(
			'exists' => $exists
		);

		// Just return true or false.
		// If there is a way of doing this via the API, this should oviously be changed.
		die( $exists ? 'false' : 'true' );
		
		// $this->getResult()->setIndexedTagName( $result, 'story' );
		// $this->getResult()->addValue( null, $this->getModuleName(), $result );
	}
	
	public static function StoryExists( array $params ) {
		$dbr = wfGetDB( DB_SLAVE );
		
		$conditions = array(
			'story_title' => str_replace( array( '_', '+' ), ' ', $params['storytitle'] ),
		);
		
		if ( array_key_exists( 'currentid', $params ) && is_integer( $params['currentid'] ) ) {
			$conditions[] = "story_id != $params[currentid]";
		}
		
		$story = $dbr->selectRow(
			'storyboard',
			array( 'story_id' ),
			$conditions
		);

		return $story != false;
	}
	
	public function getAllowedParams() {
		return array(
			'storytitle' => array(
				ApiBase :: PARAM_TYPE => 'string',
			),
			'currentid' => array(
				ApiBase :: PARAM_TYPE => 'integer',
			),
		);
	}
	
	public function getParamDescription() {
		return array(
			'storytitle' => 'The name of the story to check for.'
		);
	}
	
	public function getDescription() {
		return array(
			'Enables determining if a story exists already'
		);
	}
		
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'missingparam', 'storytitle' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=storyexists&storytitle=oHai there!',
			'api.php?action=storyexists&storytitle=oHai there!&currentid=42',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiStoryExists.php 63775 2010-03-15 16:35:22Z jeroendedauw $';
	}
}
