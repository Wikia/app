<?php

/**
 * List of contests, with admin and judge links depending on user rights.
 *
 * @since 0.1
 *
 * @file SpecialContests.php
 * @ingroup Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialContests extends SpecialContestPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Contests' );
	}

	/**
	 * Returns if the user can access the page or not.
	 *
	 * @return boolean
	 */
	protected function userCanAccess() {
		$user = $this->getUser();
		return
			( $user->isAllowed( 'contestadmin' ) || $user->isAllowed( 'contestjudge' ) )
			&& !$user->isBlocked();
	}

	/**
	 * This page is unlisted because the only way to access it is though a contest
	 * landing page.
	 *
	 * @return false|boolean
	 */
	public function isListed() {
		return $this->userCanAccess();
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	public function execute( $subPage ) {
		$subPage = str_replace( '_', ' ', $subPage );

		if ( !parent::execute( $subPage ) ) {
			return;
		}

		$user = $this->getUser();

		if ( !$this->userCanAccess() ) {
			$this->displayRestrictionError();
		}

		if ( $user->isAllowed( 'contestadmin' ) ) {
			$this->displayAddNewControl();
		}

		$this->displayContests();
	}

	/**
	 * Displays the contests.
	 *
	 * @since 0.1
	 */
	protected function displayContests() {
		$contests = Contest::s()->select( array( 'id', 'name', 'status', 'end', 'submission_count' ) );

		if ( count( $contests ) > 0 ) {
			$this->displayContestsTable( $contests );
		}

		$this->getOutput()->addModules( 'ext.contest.special.contests' );
	}

	/**
	 * Displays a small form to add a new campaign.
	 *
	 * @since 0.1
	 */
	protected function displayAddNewControl() {
		$out = $this->getOutput();

		$out->addHTML( Html::openElement(
			'form',
			array(
				'method' => 'post',
				'action' => SpecialPage::getTitleFor( 'EditContest' )->getLocalURL(),
			)
		) );

		$out->addHTML( '<fieldset>' );

		$out->addHTML( '<legend>' . htmlspecialchars( wfMsg( 'contest-special-addnew' ) ) . '</legend>' );

		$out->addHTML( Html::element( 'p', array(), wfMsg( 'contest-special-namedoc' ) ) );

		$out->addHTML( Html::element( 'label', array( 'for' => 'newcontest' ), wfMsg( 'contest-special-newname' ) ) );

		$out->addHTML( '&#160;' . Html::input( 'newcontest' ) . '&#160;' );

		$out->addHTML( Html::input(
			'addnewcontest',
			wfMsg( 'contest-special-add' ),
			'submit'
		) );

		$out->addHTML( Html::hidden( 'newEditToken', $this->getUser()->editToken() ) );

		$out->addHTML( '</fieldset></form>' );
	}

	/**
	 * Displays a list of all contests.
	 *
	 * @since 0.1
	 *
	 * @param array $contests
	 */
	protected function displayContestsTable( array /* of Contest */ $contests ) {
		$user = $this->getUser();
		$out = $this->getOutput();

		$out->addHTML( Html::element( 'h2', array( 'class' => 'contests-title' ), wfMsg( 'contest-special-existing' ) ) );

		$out->addHTML( Xml::openElement(
			'table',
			array( 'class' => 'wikitable sortable contests-table' )
		) );

		$headers = array(
			Html::element( 'th', array(), wfMsg( 'contest-special-name' ) ),
			Html::element( 'th', array(), wfMsg( 'contest-special-status' ) ),
			Html::element( 'th', array(), wfMsg( 'contest-special-submissioncount' ) )
		);

		$headers[] = Html::element( 'th', array( 'class' => 'unsortable' ) );

		$out->addHTML( '<thead><tr>' . implode( '', $headers ) . '</tr></thead>' );

		$out->addHTML( '<tbody>' );

		foreach ( $contests as $contest ) {
			/**
			 * @var $contest Contest
			 */

			$fields = array();

			if ( $user->isAllowed( 'contestant' ) ) {
				$name = Html::element(
					'a',
					array(
						'href' => SpecialPage::getTitleFor( 'ContestWelcome', $contest->getField( 'name' ) )->getLocalURL()
					),
					$contest->getField( 'name' )
				);
			}
			else {
				$name = $contest->getField( 'name' );
			}

			$fields[] = Html::rawElement(
				'td',
				array( 'data-sort-value' => $contest->getField( 'name' ) ),
				$name
			);

			$fields[] = Html::element(
				'td',
				array( 'data-sort-value' => $contest->getStatus() ),
				Contest::getStatusMessage( $contest->getStatus() )
			);

			$fields[] = Html::element(
				'td',
				array(),
				$this->getLanguage()->formatNum( $contest->getField( 'submission_count' ) )
			);

			$links = array();

			if ( $user->isAllowed( 'contestjudge' ) ) {
				$links[] = Html::element(
					'a',
					array(
						'href' => SpecialPage::getTitleFor( 'Contest', $contest->getField( 'name' ) )->getLocalURL()
					),
					wfMsg( 'contest-nav-contest' )
				);
			}

			if ( $user->isAllowed( 'contestadmin' ) ) {
				$links[] = Html::element(
					'a',
					array(
						'href' => SpecialPage::getTitleFor( 'EditContest', $contest->getField( 'name' ) )->getLocalURL()
					),
					wfMsg( 'contest-special-edit' )
				);
				
				if ( ContestSettings::get( 'contestDeletionEnabled' ) ) {
					$links[] = Html::element(
						'a',
						array(
							'href' => '#',
							'class' => 'contest-delete',
							'data-contest-id' => $contest->getId(),
							'data-contest-token' => $this->getUser()->editToken( 'deletecontest' . $contest->getId() )
						),
						wfMsg( 'contest-special-delete' )
					);
				}
			}

			$links[] = Html::element(
				'a',
				array(
					'href' => SpecialPage::getTitleFor( 'ContestWelcome', $contest->getField( 'name' ) )->getLocalURL()
				),
				wfMsg( 'contest-nav-contestwelcome' )
			);

			if ( $user->isAllowed( 'contestant' ) ) {
				$links[] = Html::element(
					'a',
					array(
						'href' => SpecialPage::getTitleFor( 'ContestSignup', $contest->getField( 'name' ) )->getLocalURL()
					),
					wfMsg( 'contest-nav-contestsignup' )
				);
			}

			$fields[] = Html::rawElement(
				'td',
				array(),
				$this->getLanguage()->pipeList( $links )
			);

			$out->addHTML( '<tr>' . implode( '', $fields ) . '</tr>' );
		}

		$out->addHTML( '</tbody>' );
		$out->addHTML( '</table>' );

		$out->addModules( 'contest.special.contests' );
	}

}
