/**
 * Ajax User Page Creation
 * Attempts to create a user page if it does not already exist
 *
 * @author Grunny
 */
/*global jQuery, mediaWiki, window*/
( function( $, mw ) {
	'use strict';

	var QuickCreateUserPage = {

		init: function() {
			var $createUserPageLink;
			if ( mw.config.get( 'skin' ) === 'oasis' ) {
				$createUserPageLink = $( '#AccountNavigation' ).find( 'li > ul.subnav a[data-id="createuserpage"]' );
				if ( $createUserPageLink.length ) {
					$createUserPageLink.click( QuickCreateUserPage.createUserPage );
				}
			} else {
				$createUserPageLink = $( '#column-one' ).find( '#p-personal #pt-createuserpage' );
				if ( $createUserPageLink.length ) {
					$createUserPageLink.click( QuickCreateUserPage.createUserPage );
				}
			}
		},

		createUserPage: function() {
			var	userPageContent = window.qtUserPageTemplate || '{{w:User:' + mw.config.get( 'wgUserName' ) + '}}',
				edittoken = mw.user.tokens.get( 'editToken' ),
				pageName = 'User:' + mw.config.get( 'wgUserName' );
			$.getJSON( mw.util.wikiScript( 'api' ), {
				action: 'query',
				prop: 'revisions',
				titles: pageName,
				format: 'json'
			} ).done( function ( data ) {
				var	pageIds = Object.keys( data.query.pages ),
					pageId = pageIds[0];
				if ( pageId !== '-1' ) {
					QuickCreateUserPage.showResult( 'ok', 'quicktools-createuserpage-exists' );
				} else {
					QuickCreateUserPage.makeEdit( pageName, userPageContent );
				}
			} );
		},

		makeEdit: function( pageName, pageContent ) {
			$.ajax( {
				type: 'POST',
				url: mw.util.wikiScript( 'api' ),
				dataType: 'json',
				data: {
					action: 'edit',
					title: pageName,
					summary: mw.msg( 'quicktools-createuserpage-reason' ),
					text: pageContent,
					format: 'json',
					token: mw.user.tokens.get( 'editToken' )
				}
			} ).done( function ( data ) {
				if ( data.edit.result === 'Success' ) {
					QuickCreateUserPage.showResult( 'ok', 'quicktools-createuserpage-success' );
				} else {
					QuickCreateUserPage.showResult( 'error', 'quicktools-createuserpage-error' );
				}
			} ).fail( function ( data ) {
				QuickCreateUserPage.showResult( 'error', 'quicktools-createuserpage-error' );
			} );
		},

		showResult: function( result, message ) {
			var $bodyContent = ( mw.config.get( 'skin' ) === 'oasis' ? $( '.WikiaPageContentWrapper' ) : mw.util.$content );
			$bodyContent.prepend(
				'<div class="WikiaConfirmation' + ( result === 'error' ? ' error' : '' ) + '"><p class="plainlinks"><img src="' +
				mw.config.get( 'wgBlankImgUrl' ) + '" class="sprite ' + result + '"> ' + mw.msg( message ) + '</p></div>'
			);
		}
	};

	mw.QuickCreateUserPage = QuickCreateUserPage;

	$( QuickCreateUserPage.init );
}( jQuery, mediaWiki ) );