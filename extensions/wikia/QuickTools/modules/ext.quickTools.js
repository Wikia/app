/**
 * Module to execute quick tool actions from a popup menu
 *
 * @author Grunny
 */
/*global jQuery, mediaWiki, window, alert */
( function( $, mw ) {
	'use strict';

	var QuickTools = {
		init: function() {
			var $quickToolsLink = $( '#contentSub' ).find( '#quicktools-link' );
			if ( $quickToolsLink.length ) {
				$quickToolsLink.click( QuickTools.showModal );
			}
		},

		showModal: function( e ) {
			var userName = $( e.target ).attr( 'data-username' );
			$.nirvana.sendRequest( {
				controller: 'QuickToolsController',
				method: 'quickToolsModal',
				format: 'html',
				data: {
					username: userName
				},
				callback: function( data ) {
					var	$quickToolsModalWrapper = $( data ).makeModal( {
							'width': 320
						} ),
						$quickToolsModal = $quickToolsModalWrapper.find( '#QuickToolsModal' );
					$quickToolsModal.find( '#quicktools-rollback-all' ).click( function() {
						QuickTools.doRevert( 1, 0 );
						$quickToolsModalWrapper.closeModal();
					} );
					$quickToolsModal.find( '#quicktools-delete-all' ).click( function() {
						QuickTools.doRevert( 0, 1 );
						$quickToolsModalWrapper.closeModal();
					} );
					$quickToolsModal.find( '#quicktools-revert-all' ).click( function() {
						QuickTools.doRevert( 1, 1 );
						$quickToolsModalWrapper.closeModal();
					} );
					$quickToolsModal.find( '#quicktools-block' ).click( function() {
						QuickTools.doBlock();
						$quickToolsModalWrapper.closeModal();
					} );
					$quickToolsModal.find( '#quicktools-block-and-revert' ).click( function() {
						QuickTools.doRevert( 1, 1 );
						QuickTools.doBlock();
						$quickToolsModalWrapper.closeModal();
					} );
					$quickToolsModal.find( '#quicktools-bot' ).click( function( e ) {
						QuickTools.botFlag( e );
						if ( $( this ).attr( 'data-bot' ) === 'remove' ) {
							$quickToolsModalWrapper.closeModal();
						}
					} );
				}
			} );
		},

		doRevert: function( dorollback, dodeletes ) {
			var	$quickToolsModal = $( '#QuickToolsModal' ),
				userName = $quickToolsModal.attr( 'data-username' ),
				time = $quickToolsModal.find( '#quicktools-time' ).val(),
				summary = $quickToolsModal.find( '#quicktools-reason' ).val(),
				data = {
					target: userName,
					time: time,
					summary: summary,
					dorollback: dorollback,
					dodeletes: dodeletes
				};
			QuickTools.sendRequest( 'revertAll', data );
		},

		doBlock: function() {
			var	$quickToolsModal = $( '#QuickToolsModal' ),
				userName = $quickToolsModal.attr( 'data-username' ),
				blockLength = $quickToolsModal.find( '#quicktools-block-length' ).val(),
				summary = $quickToolsModal.find( '#quicktools-reason' ).val(),
				data = {
					target: userName,
					length: blockLength,
					summary: summary
				};
			QuickTools.sendRequest( 'blockUser', data );
		},

		sendRequest: function( methodName, data ) {
			$.nirvana.sendRequest( {
				controller: 'QuickToolsController',
				method: methodName,
				data: data,
				callback: function( data ) {
					if ( data.success === true && data.message ) {
						alert( data.message );
						QuickTools.refreshContribContent();
					} else if ( data.error ) {
						alert( data.error );
					}
				}
			} );
		},

		botFlag: function( e ) {
			var	$quickToolsModal = $( '#QuickToolsModal' ),
				userName = mw.config.get( 'wgUserName' ),
				addRights = ( $( e.target ).attr( 'data-bot' ) === 'add' ? 'bot' : '' ),
				removeRights = ( $( e.target ).attr( 'data-bot' ) === 'remove' ? 'bot' : '' );
			$.getJSON( mw.util.wikiScript( 'api' ), {
				action: 'query',
				list: 'users',
				ususers: userName,
				ustoken: 'userrights',
				format: 'json'
			} ).done( function ( data ) {
				var	urToken = data.query.users[0].userrightstoken;
				QuickTools.changeRights( userName, urToken, addRights, removeRights, mw.msg( 'quicktools-bot-reason' ) );
			} );
		},

		changeRights: function( userName, token, addRights, removeRights, summary ) {
			$.ajax( {
				type: 'POST',
				url: mw.util.wikiScript( 'api' ),
				dataType: 'json',
				data: {
					action: 'userrights',
					user: userName,
					add: addRights,
					remove: removeRights,
					reason: summary,
					format: 'json',
					token: token
				}
			} ).done( function ( data ) {
				if ( data.error ) {
					alert( mw.msg( 'quicktools-adopt-error' ) );
				} else {
					alert( mw.msg( 'quicktools-adopt-success' ) );
					if ( addRights === 'bot' ) {
						$( '#QuickToolsModal' ).find( '#quicktools-bot' ).attr( 'data-bot', 'remove' ).text( mw.msg( 'quicktools-botflag-remove' ) );
					}
				}
			} ).fail( function ( data ) {
				alert( mw.msg( 'quicktools-adopt-error' ) );
			} );
		},

		refreshContribContent: function() {
			$( '#mw-content-text' ).load( window.location.href + ' #mw-content-text > *' );
		}
	};

	$( QuickTools.init );
}( jQuery, mediaWiki ) );