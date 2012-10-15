/**
 * JavasSript for the Survey MediaWiki extension.
 * @see https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Extension:Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw, survey ) { $( document ).ready( function() {

	var _this = this;

	var $table = null;
	var newQuestionNr = 0;
	var questionNr = 0;
	
	function addAddQuestionRow() {
		var $tr = $( '<tr />' ).attr( {
			'class': 'add-question'
		} );
		
		$table.append( $tr );
		
		$tr.append( $( '<td />' ).attr( { 'class': 'mw-label question-label' } ).html(
			'' //$( '<label />' ).text( mw.msg( 'survey-special-label-addquestion' ) )
		) );
		
		$tr.append( $( '<td />' ).attr( { 'class': 'mw-input' } ).html(
			'' //getQuestionInput( { 'id': 'new', 'answers': [], 'type': 0 } )
		).append( $( '<button />' ).button( { 'label': mw.msg( 'survey-special-label-add-first' ) } )
			.click( function() {
				$( this ).button( { 'label': mw.msg( 'survey-special-label-add-another' ) } );
				onAddQuestionRequest();
				return false;
			} )
		) );
//		
//		$( '#survey-question-text-new' ).keypress( function( event ) { 
//			if ( event.which == '13' ) {
//				event.preventDefault();
//				onAddQuestionRequest();
//			}
//		} );
	}
	
	function addQuestion( question ) {
		var $tr = $( '<tr />' ).attr( {
			'class': 'mw-htmlform-field-SurveyQuestionField'
		} );
		
		$tr.append( $( '<td />' ).attr( { 'class': 'mw-label question-label' } ).html(
			$( '<label />' ).text( mw.msg( 'survey-question-label-nr', ++questionNr ) )
		) );
		
		$tr.append( $( '<td />' ).attr( { 'class': 'mw-input' } ).html(
			getQuestionInput( question )
				.append( '<br />' )
				.append( $( '<button />' ).button( { 'label': mw.msg( 'survey-special-remove' ) } )
					.click( function() { 
						if ( confirm( mw.msg( 'survey-special-remove-confirm' ) ) ) {
							removeQuestion( question );
						}
						
						return false;
					} )
				) 
		) );
		
		$table.find( '.add-question' ).before( $tr );
	}
	
	function getQuestionInput( question ) {
		var $input = $( '<div />' ).attr( {
			'border': '1px solid black',
			'id': 'survey-question-div-' + question.id
		} );

		var answerSelector = new survey.answerSelector( {
			'visible': survey.question.typeHasAnswers( parseInt( question.type ) ),
			'attr': {
				'rows': 2,
				'cols': 80,
				'id': 'survey-question-answers-' + question.id,
				'name': 'survey-question-answers-' + question.id
			},
			'answers': question.answers
		} );
		
		$input.append( $( '<label />' ).attr( {
			'for': 'survey-question-text-' + question.id
		} ).text( mw.msg( 'survey-special-label-text' ) ) );
		
		$input.append( '<br />' );
		
		$input.append( $( '<textarea />' ).attr( {
			'rows': 2,
			'cols': 80,
			'id': 'survey-question-text-' + question.id,
			'name': 'survey-question-text-' + question.id
		} ).val( question.text ) );
		
		$input.append( '<br />' );
		
		$input.append( $( '<label />' ).attr( {
			'for': 'survey-question-type-' + question.id
		} ).text( mw.msg( 'survey-special-label-type' ) ) );

		$input.append( survey.question.getTypeSelector(
			question.type,
			{
				'id': 'survey-question-type-' + question.id,
				'name': 'survey-question-type-' + question.id
			},
			function( newValue ) {
				answerSelector.setVisible( survey.question.typeHasAnswers( parseInt( newValue ) ) );
			}
		) );
	
		// Not implemented in actual survey yet, so don't show for now.
//		$required = $( '<input />' ).attr( {
//			'id': 'survey-question-required-' + question.id,
//			'name': 'survey-question-required-' + question.id,
//			'type': 'checkbox',
//		} );
//		
//		if ( question.required ) {
//			$required.attr( 'checked', 'checked' );
//		}
//		
//		$input.append( $required );
//		
//		$input.append( $( '<label />' ).attr( {
//			'for': 'survey-question-required-' + question.id
//		} ).text( mw.msg( 'survey-special-label-required' ) ) );
		
		$input.append( answerSelector.getHtml() );
		
		return $input;
	}
	
	function removeQuestion( question ) {
		$( '#survey-question-div-' + question.id ).closest( 'tr' ).slideUp( 'fast', function() { $( this ).remove(); } )
	}
	
	function onAddQuestionRequest() {
		addQuestion( {
			'text': '', // $( '#survey-question-text-new' ).val(),
			'required': false, //!!$( '#survey-question-required-new' ).attr( 'checked' ),
			'type': 0, // $( '#survey-question-type-new' ).val(),
			'id': 'new-' + ++newQuestionNr,
			'answers': [] //$( '#survey-question-answers-new' ).val().split( '\n' )
		} );
		$( '#survey-question-text-new-' + newQuestionNr ).focus().select();
		$( 'html' ).animate( { scrollTop: $( document ).height() }, 'fast' );
	}
	
	function setup() {
		$table = $( '#survey-title' ).closest( 'tbody' );
		
		$table.append( '<tr><td colspan="2"><hr /></td></tr>' );
		
		addAddQuestionRow();
		
		$table.append( '<tr><td colspan="2"><hr /></td></tr>' );
		
		$( '.survey-question-data' ).each( function( index, domElement ) {
			$this = $( domElement );
			
			addQuestion( {
				'text': $this.attr( 'data-text' ),
				'default': $this.attr( 'data-default' ),
				'required': $this.attr( 'data-required' ) == '1',
				'id': $this.attr( 'data-id' ),
				'type': $this.attr( 'data-type' ),
				'answers': eval( $this.attr( 'data-answers' ) )
			} );
		} );
		
		$( '.mw-htmlform-submit' ).button();
		$( '#cancelEdit' ).button();
		
	}
	
	setup();
	
} ); })( jQuery, window.mediaWiki, window.survey );
