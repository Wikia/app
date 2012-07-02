<?php

/**
 * Statistics interface for surveys.
 * 
 * @since 0.1
 * 
 * @file SpecialSurveyStats.php
 * @ingroup Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialSurveyStats extends SpecialSurveyPage {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'SurveyStats', 'surveyadmin', false );
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
		
		if ( is_null( $subPage ) || trim( $subPage ) === '' ) {
			$this->getOutput()->redirect( SpecialPage::getTitleFor( 'Surveys' )->getLocalURL() );
		} else {
			$subPage = trim( $subPage );
			
			if ( Survey::has( array( 'name' => $subPage ) ) ) {
				$survey = Survey::newFromName( $subPage );

				$this->displayNavigation( array(
					wfMsgExt( 'survey-navigation-edit', 'parseinline', $survey->getField( 'name' ) ),
					wfMsgExt( 'survey-navigation-take', 'parseinline', $survey->getField( 'name' ) ),
					wfMsgExt( 'survey-navigation-list', 'parseinline' )
				) );
				
				$this->displayStats( $survey );
			}
			else {
				$this->showError( 'surveys-surveystats-nosuchsurvey' );
			}
		}
	}
	
	/**
	 * Display the statistics that go with the survey.
	 * 
	 * @since 0.1
	 * 
	 * @param Survey $survey
	 */
	protected function displayStats( Survey $survey ) {
		$this->displaySummary( $this->getSummaryData( $survey ) );
		
		if ( count( $survey->getQuestions() ) > 0 ) {
			$this->displayQuestions( $survey );
		}
	}
	
	/**
	 * Gets the summary data.
	 * 
	 * @since 0.1
	 * 
	 * @param Survey $survey
	 * 
	 * @return array
	 */
	protected function getSummaryData( Survey $survey ) {
		$stats = array();
		
		$stats['name'] = $survey->getField( 'name' );
		$stats['title'] = $survey->getField( 'title' );
		$stats['status'] = wfMsg( 'surveys-surveystats-' . ( $survey->getField( 'enabled' ) ? 'enabled' : 'disabled' ) );
		$stats['questioncount'] = count( $survey->getQuestions() ) ;
		$stats['submissioncount'] = SurveySubmission::count( array( 'survey_id' => $survey->getId() ) );
		
		return $stats;
	}
	
	/**
	 * Display a summary table with the provided data.
	 * The keys are messages that get prepended with surveys-surveystats-.
	 * message => value
	 * 
	 * @since 0.1
	 * 
	 * @param array $stats
	 */
	protected function displaySummary( array $stats ) {
		$out = $this->getOutput();
		
		$out->addHTML( Html::openElement( 'table', array( 'class' => 'wikitable survey-stats' ) ) );
		
		foreach ( $stats as $stat => $value ) {
			$out->addHTML( '<tr>' );
			
			$out->addHTML( Html::element(
				'th',
				array( 'class' => 'survey-stat-name' ),
				wfMsg( 'surveys-surveystats-' . $stat )
			) );
			
			$out->addHTML( Html::element(
				'td',
				array( 'class' => 'survey-stat-value' ),
				$value
			) );
			
			$out->addHTML( '</tr>' );
		}
		
		$out->addHTML( Html::closeElement( 'table' ) );
	}
	
	/**
	 * Displays a table with the surveys questions and some summary stats about them.
	 * 
	 * @since 0.1
	 * 
	 * @param Survey $survey
	 */
	protected function displayQuestions( Survey $survey ) {
		$out = $this->getOutput();
		
		$out->addHTML( '<h2>' . wfMsgHtml( 'surveys-surveystats-questions' ) . '</h2>' );
		
		$out->addHTML( Html::openElement( 'table', array( 'class' => 'wikitable sortable survey-questions' ) ) );
		
		$out->addHTML(
			'<thead><tr>' .
				'<th>' . wfMsgHtml( 'surveys-surveystats-question-nr' ) . '</th>' .
				'<th>' . wfMsgHtml( 'surveys-surveystats-question-type' ) . '</th>' .
				'<th class="unsortable">' . wfMsgHtml( 'surveys-surveystats-question-text' ) . '</th>' .
				'<th>' . wfMsgHtml( 'surveys-surveystats-question-answercount' ) . '</th>' .
				'<th class="unsortable">' . wfMsgHtml( 'surveys-surveystats-question-answers' ) . '</th>' .
			'</tr></thead>'	
		);
		
		$out->addHTML( '<tbody>' );
		
		foreach ( $survey->getQuestions() as /* SurveyQuestion */ $question ) {
			$this->displayQuestionStats( $question );
		}
		
		$out->addHTML( '</tbody>' );
		
		$out->addHTML( Html::closeElement( 'table' ) );
	}
	
	/**
	 * Adds a table row with the summary stats for the provided question.
	 * 
	 * @since 0.1
	 * 
	 * @param SurveyQuestion $question
	 */
	protected function displayQuestionStats( SurveyQuestion $question ) {
		static $qNr = 0;
		
		$out = $this->getOutput();
		
		$out->addHTML( '<tr>' );
		
		$out->addHTML( Html::element(
			'td',
			array( 'data-sort-value' => ++$qNr ),
			wfMsgExt( 'surveys-surveystats-question-#', 'parsemag', $qNr )
		) );
		
		$out->addHTML( Html::element(
			'td',
			array(),
			wfMsg( SurveyQuestion::getTypeMessage( $question->getField( 'type' ) ) )
		) );
		
		$out->addHTML( Html::element(
			'td',
			array(),
			$question->getField( 'text' )
		) );
		
		$out->addHTML( Html::element(
			'td',
			array(),
			SurveyAnswer::count( array( 'question_id' => $question->getId() ) )
		) );
		
		$out->addHTML( Html::rawElement(
			'td',
			array(),
			$this->getAnswerList( $question )
		) );
		
		$out->addHTML( '</tr>' );
	}
	
	/**
	 * Get a list of most provided answers for the question.
	 * 
	 * @since 0.1
	 * 
	 * @param SurveyQuestion $question
	 * 
	 * @return string
	 */
	protected function getAnswerList( SurveyQuestion $question ) {
		if ( $question->isRestrictiveType() ) {
			$list = '<ul>';

			$answers = array();
			$answerTranslations = array();
			
			if ( $question->getField( 'type' ) == SurveyQuestion::$TYPE_CHECK ) {
				$possibilities = array( '0', '1' );
				$answerTranslations['0'] = wfMsg( 'surveys-surveystats-unchecked' );
				$answerTranslations['1'] = wfMsg( 'surveys-surveystats-checked' );
			}
			else {
				$possibilities = $question->getField( 'answers' );
			}
			
			foreach ( $possibilities as $answer ) {
				$answers[$answer] = SurveyAnswer::count( array( 'text' => $answer ) );
			}
			
			asort( $answers, SORT_NUMERIC );
			
			foreach ( array_reverse( $answers ) as $answer => $answerCount ) {
				if ( array_key_exists( $answer, $answerTranslations ) ) {
					$answer = $answerTranslations[$answer];
				}
				
				$list .= Html::element(
					'li',
					array(),
					wfMsgExt(
						'surveys-surveystats-question-answer',
						'parsemag',
						$answer,
						$this->getLanguage()->formatNum( $answerCount )
					)
				);
			}
			
			return $list . '</ul>';
		}
		else {
			return '';
		}
	}
	
}
