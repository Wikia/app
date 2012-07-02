/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	$.fn.contestEmail = function() {
		var _this = this;
		var $this = $( this );

		this.originalEmail = $this.val();
		this.$emailWarn = $( '<p />' ).text( mw.msg( 'contest-signup-emailwarn' ) ).css( 'display', 'none' );
		$this.before( this.$emailWarn );
		
		if ( this.originalEmail !== '' ) {
			$this.keyup( function() {
				_this.$emailWarn.css( 'display', _this.originalEmail === $( this ).val() ? 'none' : 'block' );
			} );
		}

		return this;
	};

})( window.jQuery, window.mediaWiki );
