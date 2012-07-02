<?php
/**
 * API extension for Storyboard that allows for the querieng of stories.
 * 
 * @file ApiQueryStories.php
 * @ingroup Storyboard
 * 
 * @author Jeroen De Dauw
 * @author Roan Kattouw
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
 * API class for the querieng of stories.
 *
 * @ingroup Storyboard
 */
class ApiQueryStories extends ApiQueryBase {
	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action, 'st' );
	}

	/**
	 * Retrieve the stories from the database.
	 */
	public function execute() {
		global $wgUser, $wgLang;
		
		// Get the requests parameters.
		$params = $this->extractRequestParams();
		
		$this->addTables( 'storyboard' );
		
		$this->addFields( array(
			'story_id',
			'story_author_id',
			'story_author_name',
			'story_author_image',
			'story_image_hidden',
			'story_author_location',
			'story_title',
			'story_text',
			'story_created',
			'story_modified'
		) );
		
		$isReview = !is_null( $params['review'] );
		
		if ( $isReview && !$wgUser->isAllowed( 'storyreview' ) ) {
			$this->dieUsageMsg( array( 'badaccess-groups' ) );
		}
		
		if ( $isReview ) {
			if ( !isset( $params['state'] ) ) {
				$this->dieUsageMsg( array( 'missingparam', 'state' ) );
			}			
			
			$this->addFields( array(
				
			) );

			$this->addWhere( array(
				'story_state' => $params['state']
			) );			
		} else {
			$this->addWhere( array(
				'story_state' => Storyboard_STORY_PUBLISHED
			) );			
		}
		
		$this->addOption( 'LIMIT', $params['limit'] + 1 );
		$this->addOption( 'ORDER BY', 'story_modified DESC, story_id DESC' );

		if ( !is_null( $params['language'] ) ) {
			$this->addWhere( "story_lang_code = '$params[language]'" );
		}
		
		if ( !is_null( $params['continue'] ) ) {
			$continueParams = explode( '-', $params['continue'] );
			if ( count( $continueParams ) != 2 ) {
				$this->dieUsage(
					'Invalid continue param. You should pass the ' .
					'original value returned by the previous query', '_badcontinue'
				);
			}
			
			$storyModified = $continueParams[0];
			$storyId = intval( $continueParams[1] );

			$this->addWhere(
				"story_modified < $storyModified OR " .
				"(story_modified = $storyModified AND story_id <= $storyId)"
			);
		}
		
		$stories = $this->select( __METHOD__ );
		$count = 0;
		
		while ( $story = $stories->fetchObject() ) {
			if ( ++$count > $params['limit'] ) {
				// We've reached the one extra which shows that
				// there are additional pages to be had. Stop here...
				$this->setContinueEnumParameter( 'continue', wfTimestamp( TS_MW, $story->story_modified ) . '-' . $story->story_id );
				break;
			}
			
			$result = array(
				'id' => $story->story_id,
				'author' => $story->story_author_name,
				'title' => $story->story_title,
				'creationtime' => $wgLang->time( $story->story_created ),
				'creationdate' => $wgLang->date( $story->story_created ),
				'modificationtime' => $wgLang->time( $story->story_modified ),
				'modificationdate' => $wgLang->date( $story->story_modified ),			
				'location' => $story->story_author_location,
				'imageurl' => $story->story_author_image,
				'imagehidden' => $story->story_image_hidden,
				'permalink' => SpecialPage::getTitleFor( 'story', $story->story_title )->getFullURL(),
			);
			
			if ( $isReview ) {
				$result['modifyurl'] = SpecialPage::getTitleFor( 'story', $story->story_title )->getFullURL(
					'action=edit&returnto=' . SpecialPage::getTitleFor( 'storyreview' )->getPrefixedText()
				);
				
				$result['state'] = (int)$params['state'];
			}			
			
			ApiResult::setContent( $result, ( is_null( $story->story_text ) ? '' : $story->story_text ) );
			$this->getResult()->addValue( array( 'query', $this->getModuleName() ), null, $result );
		}
		
		// FIXME: continue parameter is not getting passed with the result
		$this->getResult()->setIndexedTagName_internal( array( 'query', $this->getModuleName() ), 'story' );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getAllowedParams()
	 */
	public function getAllowedParams() {
		return array (
			'limit' => array(
				ApiBase :: PARAM_DFLT => 10,
				ApiBase :: PARAM_TYPE => 'limit',
				ApiBase :: PARAM_MIN => 1,
				ApiBase :: PARAM_MAX => ApiBase :: LIMIT_BIG1,
				ApiBase :: PARAM_MAX2 => ApiBase :: LIMIT_BIG2
			),
			'continue' => null,
			'language' => array(
				ApiBase :: PARAM_TYPE => 'string',
			),
			'review' => null,
			'state' => array(
				ApiBase :: PARAM_TYPE => array( Storyboard_STORY_UNPUBLISHED, Storyboard_STORY_PUBLISHED, Storyboard_STORY_HIDDEN ),
			)
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getParamDescription()
	 */
	public function getParamDescription() {
		return array (
			'continue' => 'Number of the first story to return',
			'limit'   => 'Amount of stories to return',
			'language' => 'The language of the stories to return',
			'review' => 'Indicates that storyreview parameters shoudl be passed when set',
			'state' => 'The state of the stories which should be returned'
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getDescription()
	 */
	public function getDescription() {
		return 'This module returns stories for a storyboard';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getPossibleErrors()
	 */
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'badaccess-groups' ),
			array( 'missingparam', 'state' ),
		) );
	}	
	
	/**
	 * (non-PHPdoc)
	 * @see includes/api/ApiBase#getExamples()
	 */
	public function getExamples() {
		return array (
			'api.php?action=query&list=stories',
			'api.php?action=query&list=stories&stlimit=42&stlanguage=en',
			'api.php?action=query&list=stories&stcontinue=20100319202223|4&stlimit=2',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiQueryStories.php 70248 2010-07-31 22:18:32Z platonides $';
	}
	
}
