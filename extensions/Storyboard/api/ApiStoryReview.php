<?php
/**
 * API extension for Storyboard that facilitates story review actions.
 * 
 * @file ApiStoryReview.php
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
 * Api class that facilitates story review actions.
 *
 * @ingroup Storyboard
 */
class ApiStoryReview extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgUser;
		
		if ( !$wgUser->isAllowed( 'storyreview' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		$params = $this->extractRequestParams();
		
		// Check to see if the required parameters are present.
		if ( !isset( $params['storyid'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'storyid' ) );
		}
		
		if ( !isset( $params['storyaction'] ) ) {
			$this->dieUsageMsg( array( 'missingparam', 'storyaction' ) );
		}
		
		if ( $params['storyaction'] == 'delete' && !$wgUser->isAllowed( 'delete' ) ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		$dbw = wfGetDB( DB_MASTER );
		
		if ( $params['storyaction'] == 'delete' ) {
			$dbw->delete( 'storyboard', array( 'story_id' => $params['storyid'] ) );
		} else {
			$conds = array(
				'story_id' => $params['storyid']
			);
			
			switch( $params['storyaction'] ) {
				case 'hide' :
					$values = array(
						'story_state' => Storyboard_STORY_HIDDEN
					);
					break;
				case 'publish' :
					$values = array(
						'story_state' => Storyboard_STORY_PUBLISHED
					);
					break;
				case 'unpublish' :
					$values = array(
						'story_state' => Storyboard_STORY_UNPUBLISHED
					);
					break;
				case 'hideimage' :
					$values = array(
						'story_image_hidden' => 1
					);
					break;
				case 'unhideimage' :
					$values = array(
						'story_image_hidden' => 0
					);
					break;
				case 'deleteimage' :
					$values = array(
						'story_author_image' => ''
					); // TODO: should image file also be removed?
					break;
			}
			
			$dbw->update( 'storyboard', $values, $conds );
		}
		
		$result = array(
			'action' => $params['storyaction'],
			'id' => $params['storyid'],
		);
		
		$this->getResult()->setIndexedTagName( $result, 'story' );
		$this->getResult()->addValue( null, $this->getModuleName(), $result );
	}
	
	public function getAllowedParams() {
		return array(
			'storyid' => array(
				ApiBase :: PARAM_TYPE => 'integer',
			),
			'storyaction' => array(
				ApiBase::PARAM_TYPE => array(
					'delete',
					'hide',
					'unhide',
					'publish',
					'unpublish',
					'hideimage',
					'unhideimage',
					'deleteimage',
				)
			),
		);
	}
	
	public function getParamDescription() {
		return array(
			'storyid' => 'The id of the story you want to modify or delete',
			'storyaction' => 'Indicates in what way you want to modify the story',
		);
	}
	
	public function getDescription() {
		return array(
			'Story review actions'
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'badaccess-groups' ),
			array( 'missingparam', 'storyid' ),
			array( 'missingparam', 'storyaction' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=storyreview&storyid=42&storyaction=publish',
			'api.php?action=storyreview&storyid=42&storyaction=hide',
			'api.php?action=storyreview&storyid=42&storyaction=delete',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiStoryReview.php 70248 2010-07-31 22:18:32Z platonides $';
	}
}
