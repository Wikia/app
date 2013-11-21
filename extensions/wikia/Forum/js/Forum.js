(function( window, $ ) {
	'use strict';
	var showPoliciesModal = function() {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
				var backBtnMsg = $.msg( 'back' ),
					modalId = 'ForumPoliciesModal',
					editBtnMsg,
					modalConfig = {
						type: 'default',
						vars: {
							id: modalId,
							size: 'medium',
							content: '<div class="ForumPolicies"><div class="WikiaArticle"></div></div>',
							title: $.msg( 'forum-specialpage-policies' ),
							closeText: $.msg( 'close' ),
							buttons: [
								{
									vars: {
										value: backBtnMsg,
										data: [
											{
												key: 'event',
												value: 'close'
											}
										]
									}
								}
							]
						}
					};

				if ( window.wgCanEditPolicies ) {
					editBtnMsg = $.msg( 'forum-specialpage-policies-edit' );
					modalConfig.vars.buttons.push( {
						vars: {
							value: editBtnMsg,
							data: [
								{
									key: 'event',
									value: 'edit'
								}
							]
						}
					} );
				}

				uiModal.create( modalConfig, function( policiesModal ) {

					policiesModal.onPrimaryBtnClick(function( event ) {
						event.preventDefault();
						window.location = window.wgPoliciesEditURL;
					});

					policiesModal.onSecondaryBtnClick(function( event ) {
						event.preventDefault();
						policiesModal.close();
					});

					policiesModal.show();
					policiesModal.$content.find( '.ForumPolicies' ).startThrobbing();
					$.nirvana.sendRequest({
						controller: 'ForumExternalController',
						type: 'GET',
						method: 'policies',
						format: 'json',
						data: {
							'rev': window.wgPoliciesRev
						},
						callback: function( data ) {
							policiesModal.$content.find( '.ForumPolicies' ).stopThrobbing();
							policiesModal.$content.find( '.ForumPolicies .WikiaArticle' ).html( data.body );
						}
					});
				});
			});
		});
		return false;
	};
		
	$(function() {
		$( '.policies-link' ).click( showPoliciesModal );
	});

	// Just the namespace, for now.
	window.Forum = {};

})( window, jQuery );
