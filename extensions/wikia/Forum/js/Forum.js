(function( window, $ ) {
	'use strict';
	var showPoliciesModal = function() {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
				var modalConfig = {
						vars: {
							id: 'ForumPoliciesModal',
							size: 'medium',
							content: '<div class="ForumPolicies"><div class="WikiaArticle"></div></div>',
							title: $.msg( 'forum-specialpage-policies' ),
							buttons: [
								{
									vars: {
										value: $.msg( 'back' ),
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
					modalConfig.vars.buttons.unshift( {
						vars: {
							value: $.msg( 'forum-specialpage-policies-edit' ),
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

					policiesModal.bind( 'edit', function( event ) {
						event.preventDefault();
						window.location = window.wgPoliciesEditURL;
					} );

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
