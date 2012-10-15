/**
 * JavasSript for the Education Program MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Education_Program
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

( function ( $, mw ) {

	mw.educationProgram.api = {

		enlist: function( args ) {
			var requestArgs = $.extend( {
				'action': 'enlist',
				'format': 'json',
				'token': window.mw.user.tokens.get( 'editToken' )
			}, args );

			var deferred = $.Deferred();

			$.post(
				wgScriptPath + '/api.php',
				requestArgs,
				function( data ) {
					if ( data.hasOwnProperty( 'success' ) && data.success ) {
						deferred.resolve();
					}
					else {
						deferred.reject();
					}
				}
			);

			return deferred.promise();
		},

		enlistUser: function( args ) {
			args.subaction = 'add';
			return this.enlist( args );
		},

		unenlistUser: function( args ) {
			args.subaction = 'remove';
			return this.enlist( args );
		},

		remove: function( data, args ) {
			var requestArgs = $.extend( {
				'action': 'deleteeducation',
				'format': 'json',
				'token': window.mw.user.tokens.get( 'editToken' ),
				'ids': data.ids.join( '|' ),
				'type': data.type
			}, args );
			
			var deferred = $.Deferred();

			$.post(
				wgScriptPath + '/api.php',
				requestArgs,
				function( data ) {
					if ( data.hasOwnProperty( 'success' ) && data.success ) {
						deferred.resolve();
					}
					else {
						deferred.reject();
					}
				}
			);
			
			return deferred.promise();
		}

	};

}( jQuery, mediaWiki ) );

