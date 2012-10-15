/**
 * JavasSript for the Survey MediaWiki extension.
 * @see https://secure.wikimedia.org/wikipedia/mediawiki/wiki/Extension:Survey
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw, survey ) {
	
	survey.answerSelector = function( options ) {
		var _this = this;
		
		var defaults = {
			'visible': true,
			'answers': []
		};
		
		options = $.extend( defaults, options );
		
		this.$div = $( '<div />' ).html( '' );
		
		this.$div.append( $( '<p />' ).text( mw.msg( 'survey-special-label-answers' ) ) );

		this.$div.append( $( '<textarea />' ).attr( options.attr ).val( options.answers.join( '\n' ) ) );
		
		this.setVisible( options.visible );
	};

	survey.answerSelector.prototype = {
		
		getHtml: function() {
			return this.$div;
		},
			
		show: function() {
			this.$div.show();
		},
		
		hide: function() {
			this.$div.hide();
		},
		
		setVisible: function( visible ) {
			if ( visible ) {
				this.show();
			}
			else {
				this.hide();
			}
		}
			
	};
	
} )( jQuery, window.mediaWiki, window.survey );
