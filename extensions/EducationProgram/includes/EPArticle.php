<?php

/**
 * Class representing a single single article being worked upon by a student,
 * and can have zero or more associated reviewers.
 *
 * @since 0.1
 *
 * @file EPRevision.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EPArticle extends EPDBObject {

	/**
	 * Cached user object for this revision.
	 *
	 * @since 0.1
	 * @var User|false
	 */
	protected $user = false;

	/**
	 * @see parent::getFieldTypes
	 *
	 * @since 0.1
	 *
	 * @return array
	 */
	protected static function getFieldTypes() {
		return array(
			'id' => 'id',

			'course_id' => 'int',
			'user_id' => 'int',
			'page_id' => 'int',
			'reviewers' => 'array',
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see EPDBObject::getDefaults()
	 */
	public static function getDefaults() {
		return array(
			'reviewers' => array(),
		);
	}

	/**
	 * Returns the user that authored this revision.
	 *
	 * @since 0.1
	 *
	 * @return User
	 */
	public function getUser() {
		if ( $this->user === false ) {
			$this->user = User::newFromId( $this->loadAndGetField( 'user_id' ) );
		}

		return $this->user;
	}

	/**
	 * Display a pager with articles.
	 *
	 * @since 0.1
	 *
	 * @param IContextSource $context
	 * @param array $conditions
	 */
	public static function displayPager( IContextSource $context, array $conditions = array() ) {
		$pager = new EPArticlePager( $context, $conditions );

		if ( $pager->getNumRows() ) {
			$context->getOutput()->addHTML(
				$pager->getFilterControl() .
					$pager->getNavigationBar() .
					$pager->getBody() .
					$pager->getNavigationBar() .
					$pager->getMultipleItemControl()
			);
		}
		else {
			$context->getOutput()->addHTML( $pager->getFilterControl( true ) );
			$context->getOutput()->addWikiMsg( 'ep-articles-noresults' );
		}
	}

}
