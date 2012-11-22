/**
 * Ajax Quick Adopt
 * Adds a button to the contribs page that allows staff who handle adoption requests to give rights with one click.
 * Also, attempts to create the staff member's user page when the rights change has succeeded.
 *
 * @author Grunny
 */
/*global jQuery, mediaWiki, window*/
( function( $, mw ) {
	'use strict';

	var QuickAdopt = {

		init: function() {
			var $adoptLink = $( '#contentSub' ).find( '#quicktools-adopt-link' );
			if ( $adoptLink.length ) {
				$adoptLink.click( QuickAdopt.adoptWiki );
			}
		},

		adoptWiki: function( e ) {
			var	userName = $( e.target ).attr( 'data-username' );
			$.getJSON( mw.util.wikiScript( 'api' ), {
				action: 'query',
				list: 'users',
				ususers: userName,
				ustoken: 'userrights',
				format: 'json'
			} ).done( function ( data ) {
				var	urToken = data.query.users[0].userrightstoken;
				QuickAdopt.grantRights( userName, urToken );
			} );
		},

		grantRights: function( userName, token ) {
			var addRights = 'sysop|bureaucrat';
			$.ajax( {
				type: 'POST',
				url: mw.util.wikiScript( 'api' ),
				dataType: 'json',
				data: {
					action: 'userrights',
					user: userName,
					add: addRights,
					reason: mw.msg( 'quicktools-adopt-reason' ),
					format: 'json',
					token: token
				}
			} ).done( function ( data ) {
				if ( data.error ) {
					QuickAdopt.showResult( 'error', 'quicktools-adopt-error' );
				} else {
					QuickAdopt.showResult( 'ok', 'quicktools-adopt-success' );
					mw.QuickCreateUserPage.createUserPage();
				}
			} ).fail( function ( data ) {
				QuickAdopt.showResult( 'error', 'quicktools-adopt-error' );
			} );
		},

		showResult: function( result, message ) {
			if ( mw.config.get( 'skin' ) === 'monobook' ) {
				mw.util.$content.prepend(
					'<div class="' + ( result === 'error' ? 'errorbox' : 'successbox' ) + '"><p class="plainlinks"><img src="' +
					mw.config.get( 'wgBlankImgUrl' ) + '" class="sprite ' + result + '"> ' + mw.msg( message ) + '</p></div>' +
					'<div class="visualClear"></div>'
				);
			} else {
				var resultClass = ( result === 'error' ? 'error' : 'confirm' );
				window.GlobalNotification.show( mw.msg( message ), resultClass );
			}
		}
	};

	$( QuickAdopt.init );

}( jQuery, mediaWiki ) );