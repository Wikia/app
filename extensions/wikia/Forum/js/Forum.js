(function(window, $) {
	'use strict';
	var showPoliciesModal = function() {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'button', 'modal' ] ).then( function( uiButton, uiModal ) {
				var backBtnMsg = $.msg( 'back' ),
					backBtn = uiButton.render( {
						type: 'button',
						vars: {
							id: 'close',
							type: 'button',
							classes: [ 'normal', 'secondary' ],
							value: backBtnMsg,
							title: backBtnMsg
						}
					}),
					modalId = 'ForumPoliciesModal',
					editBtn, policiesModal, editBtnMsg;

				if ( window.wgCanEditPolicies ) {
					editBtnMsg = $.msg( 'forum-specialpage-policies-edit' );
					editBtn = uiButton.render( {
						type: 'button',
						vars: {
							id: 'edit',
							type: 'button',
							classes: [ 'normal', 'secondary' ],
							value: editBtnMsg,
							title: editBtnMsg
						}
					} );
				}


				policiesModal = uiModal.render( {
					type: 'default',
					vars: {
						id: modalId,
						size: 'medium',
						content: '<div class="ForumPolicies"><div class="WikiaArticle"></div></div>',
						title: $.msg( 'forum-specialpage-policies' ),
						closeButton: true,
						closeText: $.msg( 'close' ),
						primaryBtn: editBtn,
						secondBtn: backBtn
					}
				} );

				require( [ 'wikia.ui.modal' ], function( modal ) {
					policiesModal = modal.init( modalId, policiesModal );
					policiesModal.$element.find( '#close' ).click( function() {
						policiesModal.close();
					} );
					policiesModal.$element.find( '#edit' ).click( function() {
						window.location = window.wgPoliciesEditURL;
					} );


					policiesModal.show();
					policiesModal.$element.find( '.ForumPolicies' ).startThrobbing();
					$.nirvana.sendRequest({
						controller: 'ForumExternalController',
						type: 'GET',
						method: 'policies',
						format: 'json',
						data: {
							'rev': window.wgPoliciesRev
						},
						callback: function(data) {
							policiesModal.$element.find( '.ForumPolicies' ).stopThrobbing();
							policiesModal.$element.find( '.ForumPolicies .WikiaArticle' ).html(data.body);
						}
					});
				} );
			} );
		} );
		return false;
	};
		
	$(function() {
		$( '.policies-link' ).click( showPoliciesModal );
	});
// Just the namespace, for now.
window.Forum = {};

})(window, jQuery);
