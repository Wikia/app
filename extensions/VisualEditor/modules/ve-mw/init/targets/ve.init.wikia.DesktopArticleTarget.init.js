( function () {
	var uri = new mw.Uri(), targetPromise, plugins = [];

	function getTarget() {
		if ( !targetPromise ) {
			// The TargetLoader module is loaded in the bottom queue, so it should have been
			// requested already but it might not have finished loading yet
			targetPromise = mw.loader.using( 'ext.visualEditor.targetLoader' )
				.then( function () {
					mw.libs.ve.targetLoader.addPlugin( function () {
						// If the user and site modules fail, we still want to continue
						// loading, so convert failure to success

						return mw.loader.using( [ 'user', 'site' ] ).then(
							null,
							function () {
								return $.Deferred().resolve();
							}
						);
					} );
					// Add modules specific to desktop (modules shared between desktop
					// and mobile are already added by TargetLoader)
					// Note: it's safe to use .forEach() (ES5) here, because this code will
					// never be called if the browser doesn't support ES5
					[
						'ext.visualEditor.desktopArticleTarget',
						'ext.visualEditor.mwgallery',
						'ext.visualEditor.mwimage',
						'ext.visualEditor.mwmeta'
					].forEach( mw.libs.ve.targetLoader.addPlugin );
					// Add requested plugins
					plugins.forEach( mw.libs.ve.targetLoader.addPlugin );
					plugins = [];
					return mw.libs.ve.targetLoader.loadModules();
				} )
				.then( function () {
					var target;

					// Transfer methods
					//ve.init.mw.DesktopArticleTarget.prototype.setupSectionEditLinks = init.setupSectionLinks;

					target = new ve.init.mw.DesktopArticleTarget();
					//$( '#content' ).append( target.$element );
					$( '#WikiaArticle' ).append( target.$element );
					//target.$element.insertAfter( '#mw-content-text' );
					return target;
				}, function ( e ) {
					mw.log.warn( 'VisualEditor failed to load: ' + e );
				} );
		}

		targetPromise.then( function () {
			// Enqueue the loading of deferred modules (that is, modules which provide
			// functionality that is not needed for loading the editor).
			setTimeout( function () {
				mw.loader.load( 'easy-deflate.deflate' );
			}, 500 );
		} );

		return targetPromise;
	}

	function activateTarget( targetPromise ) {
		var dataPromise = mw.loader.using( 'ext.visualEditor.targetLoader' )
			.then( function () {
				return mw.libs.ve.targetLoader.requestPageData(
					mw.config.get( 'wgRelevantPageName' ),
					uri.query.oldid,
					'mwTarget' // ve.init.mw.DesktopArticleTarget.static.name
				);
			} );
		targetPromise = targetPromise || getTarget();
		targetPromise
			.then( function ( target ) {
				return target.activate( dataPromise );
			} );
	}

	$( function () {
		activateTarget();
	} );
}() );
