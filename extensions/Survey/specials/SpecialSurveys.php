<?php

/**
 * Administration interface for surveys.
 * 
 * @since 0.1
 * 
 * @file SpecialSurveys.php
 * @ingroup Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialSurveys extends SpecialSurveyPage {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Surveys', 'surveyadmin' );
	}
	
	/**
	 * Main method.
	 * 
	 * @since 0.1
	 * 
	 * @param string $arg
	 */
	public function execute( $subPage ) {
		if ( !parent::execute( $subPage ) ) {
			return;
		}
		
		$req = $this->getRequest();
		
		if ( $req->wasPosted()
			&& $this->getUser()->matchEditToken( $req->getVal( 'wpEditToken' ) )
			&& $req->getCheck( 'newsurvey' ) ) {
				$this->getOutput()->redirect( SpecialPage::getTitleFor( 'EditSurvey', $req->getVal( 'newsurvey' ) )->getLocalURL() );
		} else {
			$this->displaySurveys();
		}
	}
	
	/**
	 * Displays surveys.
	 * 
	 * @since 0.1
	 */
	protected function displaySurveys() {
		$this->displayAddNewControl();
		
		$surveys = Survey::select( array( 'id', 'name', 'enabled', 'title' ) );
		
		if ( count( $surveys ) > 0 ) {
			$this->displaySurveysTable( $surveys );
		}
		
		$this->addModules( 'ext.survey.special.surveys' );
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
				'action' => $this->getTitle()->getLocalURL(),
			)
		) );
		
		$out->addHTML( '<fieldset>' );
		
		$out->addHTML( '<legend>' . htmlspecialchars( wfMsg( 'surveys-special-addnew' ) ) . '</legend>' );
		
		$out->addHTML( Html::element( 'p', array(), wfMsg( 'surveys-special-namedoc' ) ) );
		
		$out->addHTML( Html::element( 'label', array( 'for' => 'newcampaign' ), wfMsg( 'surveys-special-newname' ) ) );
		
		$out->addHTML( '&#160;' . Html::input( 'newsurvey' ) . '&#160;' );
		
		$out->addHTML( Html::input(
			'addnewsurvey',
			wfMsg( 'surveys-special-add' ),
			'submit'
		) );
		
		global $wgUser;
		$out->addHTML( Html::hidden( 'wpEditToken', $wgUser->editToken() ) );
		
		$out->addHTML( '</fieldset></form>' );
	}
	
	/**
	 * Displays a list of all survets.
	 * 
	 * @since 0.1
	 * 
	 * @param array $surveys
	 */
	protected function displaySurveysTable( array /* of Survey */ $surveys ) {
		$out = $this->getOutput();
		
		$out->addHTML( Html::element( 'h2', array(), wfMsg( 'surveys-special-existing' ) ) );
		
		$out->addHTML( Xml::openElement(
			'table',
			array( 'class' => 'wikitable sortable' )
		) );
		
		$out->addHTML( 
			'<thead><tr>' .
				Html::element( 'th', array(), wfMsg( 'surveys-special-title' ) ) .
				Html::element( 'th', array(), wfMsg( 'surveys-special-status' ) ) .
				Html::element( 'th', array( 'class' => 'unsortable' ), wfMsg( 'surveys-special-stats' ) ) .
				Html::element( 'th', array( 'class' => 'unsortable' ), wfMsg( 'surveys-special-edit' ) ) .
				Html::element( 'th', array( 'class' => 'unsortable' ), wfMsg( 'surveys-special-delete' ) ) .
			'</tr></thead>'
		);
		
		$out->addHTML( '<tbody>' );
		
		foreach ( $surveys as $survey ) {
			$out->addHTML(
				'<tr>' .
					'<td data-sort-value="' . htmlspecialchars( $survey->getField( 'title' ) ) . '">' .
						Html::element( 
							'a',
							array(
								'href' => SpecialPage::getTitleFor( 'TakeSurvey', $survey->getField( 'name' ) )->getLocalURL()
							),
							$survey->getField( 'title' )
						) .
					'</td>' .
					Html::element( 'td', array(), wfMsg( 'surveys-special-' . ( $survey->getField( 'enabled' ) ? 'enabled' : 'disabled' ) ) ) .
					'<td>' .
						Html::element( 
							'a',
							array(
								'href' => SpecialPage::getTitleFor( 'SurveyStats', $survey->getField( 'name' ) )->getLocalURL()
							),
							wfMsg( 'surveys-special-stats' )
						) .
					'</td>' .
					'<td>' .
						Html::element( 
							'a',
							array(
								'href' => SpecialPage::getTitleFor( 'EditSurvey', $survey->getField( 'name' ) )->getLocalURL()
							),
							wfMsg( 'surveys-special-edit' )
						) .
					'</td>' .
					'<td>' .
						Html::element( 
							'a',
							array(
								'href' => '#',
								'class' => 'survey-delete',
								'data-survey-id' => $survey->getId(),
								'data-survey-token' => $GLOBALS['wgUser']->editToken( 'deletesurvey' . $survey->getId() )
							),
							wfMsg( 'surveys-special-delete' )
						) .
					'</td>' .
				'</tr>'
			);
		}
		
		$out->addHTML( '</tbody>' );
		$out->addHTML( '</table>' );
	}	
	
}
