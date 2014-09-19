/**
 * Module to execute COPPA tool actions
 *
 * @author Grunny
 */
( function( $, mw, undefined ) {
	'use strict';

	var coppaTool = {

		init: function () {
			var $stepOneForm = $( '#CoppaStepOne' );

			this.userName = $stepOneForm.attr( 'data-username' );

			this.methods = {
				'disable-account' : 'disableUserAccount',
				'blank-profile' : 'resetUserProfile',
				'delete-userpages' : 'deleteUserPages',
				'rename-ip' : 'renameIPAddress'
			};

			$stepOneForm.find( '.action-button' ).click( $.proxy( this.doCoppaAction, this ) );
		},

		doCoppaAction: function ( event ) {
			var	method,
				$thisEl = $( event.currentTarget ),
				actionName = $thisEl.attr( 'data-action' ),
				$resultImg = $thisEl.find( 'img' ),
				$resultContainer = $thisEl.find( '.result' );

			if ( this.methods[actionName] === undefined ) {
				return;
			}

			method = this.methods[actionName];

			$resultImg.removeClass().addClass( 'sprite progress' );

			$.nirvana.sendRequest( {
				controller: 'CoppaToolController',
				method: method,
				data: {
					user: this.userName,
					token: mw.user.tokens.get( 'editToken' )
				},
				callback: function( data ) {
					if ( data.success === true ) {
						$resultImg.removeClass().addClass( 'sprite ok' );
						if ( data.errorMsg ) {
							$resultContainer.removeClass( 'success' ).addClass( 'error' ).text( data.errorMsg );
						} else if ( data.resultMsg ) {
							$resultContainer.removeClass( 'error' ).addClass( 'success' ).text( data.resultMsg );
						}
					} else if ( data.errorMsg ) {
						$resultImg.removeClass().addClass( 'sprite error' );
						$resultContainer.removeClass( 'success' ).addClass( 'error' ).text( data.errorMsg );
					}
				}
			} );
		}
	};

	$( function () {
		coppaTool.init();
	} );

}( jQuery, mediaWiki ) );
