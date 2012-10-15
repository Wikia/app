/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	/**
	 * Regex text escaping function.
	 * Borrowed from http://simonwillison.net/2006/Jan/20/escape/
	 */
	RegExp.escape = function( text ) {
		if ( !arguments.callee.sRE ) {
			var specials = [  '/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\' ];
			arguments.callee.sRE = new RegExp( '(\\' + specials.join('|\\') + ')', 'g' );
		}
		return text.replace(arguments.callee.sRE, '\\$1');
	}

	$.fn.contestSubmission = function() {
		var _this = this;
		var $this = $( this );

		this.config = {};
		this.status = {};

		this.input = null;
		this.label = null;

		this.getValue = function() {
			return this.input.val();
		}

		this.getDomains = function() {
			return this.config.domains;
		};

		this.validate = function() {
			var domains = _this.getDomains();

			for ( var i = domains.length - 1; i >= 0; i-- ) {
				var regex = new RegExp( "^https?://(([a-z0-9]+)\\.)?" + RegExp.escape( domains[i] ) + "/(.*)?$", "gi" );
				if ( regex.test( this.getValue() ) ) {
					return true;
				}
			}

			return false;
		};

		this.showStatus = function() {
			if ( _this.status.valid ) {
				_this.input.removeClass( 'error' );
			}
			else {
				_this.input.addClass( 'error' );
			}
		};

		this.onValueChanged = function() {
			_this.status.valid = _this.validate();
			_this.showStatus();
		};

		this.setup = function() {
			var message = $this.attr( 'data-value' ) === '' ? 'contest-submission-new-submission' : 'contest-submission-current-submission';
			var domainLinks = [];

			for ( var i = this.config.domains.length - 1; i >= 0; i-- ) {
				var link = $( '<a />' ).text( this.config.domains[i] ).attr( {
					'href': 'http://' + this.config.domains[i],
					'target': 'blank'
				} );
				domainLinks.push( $( '<div />' ).html( link ).html() );
			}

			var links = $( '<span />' ).html( '' );

			this.label = $( '<label style="display:block" />' ).attr( {
				'for': this.config.name
			} ).text( mw.msg( message ) ).append(
				$( '<br />' ),
				mw.msg( 'contest-submission-domains', domainLinks.join( ', ' ) )
			);

			this.input = $( '<input />' ).attr( {
				'type': 'text',
				'value': $this.attr( 'data-value' ),
				'name': this.config.name,
				'size': 45,
				'id': this.config.name
			} );

			this.html( this.label );
			this.append( this.input );

			this.input.keyup( this.onValueChanged );
		};

		this.getConfig = function() {
			this.config.name = $this.attr( 'data-name' );
			this.config.domains = $this.attr( 'data-domains' ).split( '|' );
		};

		this.getConfig();
		this.setup();
		this.onValueChanged();

		return this;
	};

})( window.jQuery, window.mediaWiki );
