/**
 * JavasSript for the Survey MediaWiki extension.
 * @see https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Extension:Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

window.survey = new( function() {
	
	this.log = function( message ) {
		if ( mediaWiki.config.get( 'wgSurveyDebug' ) ) {
			if ( typeof mediaWiki === 'undefined' ) {
				if ( typeof console !== 'undefined' ) {
					console.log( 'Survey: ' + message );
				}
			} else {
				return mediaWiki.log.call( mediaWiki.log, 'Survey: ' + message );
			}
		}
	};
	
	this.msg = function() {
		if ( typeof mediaWiki === 'undefined' ) {
			message = window.wgSurveyMessages[arguments[0]];
			
			for ( var i = arguments.length - 1; i > 0; i-- ) {
				message = message.replace( '$' + i, arguments[i] );
			}
			
			return message;
		} else {
			return mediaWiki.msg.apply( mediaWiki.msg, arguments );
		}
	};
	
	this.htmlSelect = function( options, value, attributes, onChangeCallback ) {
		$select = $( '<select />' ).attr( attributes );
		
		for ( message in options ) {
			var attribs = { 'value': options[message] };
			
			if ( value === options[message] ) {
				attribs.selected = 'selected';
			}
			
			$select.append( $( '<option />' ).text( message ).attr( attribs ) );
		}
		
		if ( typeof onChangeCallback !== 'undefined' ) {
			$select.change( function() { onChangeCallback( $( this ).val() ) } );
		}
		
		return $select;
	};
	
	this.htmlRadio = function( options, value, name, attributes ) {
		var $radio = $( '<div />' ).attr( attributes );
		$radio.html( '' );
		
		for ( message in options ) {
			var itemValue = options[message];
			var id = name + itemValue;
			
//			if ( value === null ) {
//				value = itemValue;
//			}
			
			$input = $( '<input />' ).attr( {
				'id': id,
				'type': 'radio',
				'name': name,
				'value': itemValue
			} );
			
			if ( value === options[message] ) {
				$input.attr( 'checked', 'checked' );
			}
			
			$radio.append( $input );
			$radio.append( $( '<label />' ).attr( 'for', id ).text( message ) );
			$radio.append( $( '<br />' ) );
		}
		
		return $radio;
	};
	
	this.question = new( function() {
		
		this.type = new( function() {
			this.TEXT = 0;
			this.NUMBER = 1;
			this.SELECT = 2;
			this.RADIO = 3;
			this.TEXTAREA = 4;
			this.CHECK = 5;
		} );
		
		this.typeHasAnswers = function( t ) {
			return $.inArray( t, [ survey.question.type.RADIO, survey.question.type.SELECT ] ) !== -1;
		};
		
		this.getTypeSelector = function( value, attributes, onChangeCallback ) {
			var options = [];
			
			var types = {
				'text': survey.question.type.TEXT,
				'number': survey.question.type.NUMBER,
				'select': survey.question.type.SELECT,
				'radio': survey.question.type.RADIO,
				'textarea': survey.question.type.TEXTAREA,
				'check': survey.question.type.CHECK
			};
			
			for ( msg in types ) {
				options[survey.msg( 'survey-question-type-' + msg )] = types[msg];
			}
			
			return survey.htmlSelect( options, parseInt( value ), attributes, onChangeCallback );
		};
		
	} );
	
} )();


