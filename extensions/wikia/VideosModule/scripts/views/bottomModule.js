require( ['sloth', 'thumbnails.titlethumbnail', 'wikia.nirvana'], function( sloth, TitleThumbnailView, nirvana ) {
	'use strict';

	function VideoModule( options ) {
		this.el = options.el;
		this.data = null;
		this.init();
	}

	VideoModule.prototype = {
		init: function() {
			this.getData();
			sloth( {
				on: this.el,
				threshold: 200,
				callback: this.render
			} );
		},
		render: function() {
		},
		getData: function () {
			if ( this.data !== null ) {
				return this.data;
			} else {
				return nirvana.getJson(
					'VideosModuleController',
					'executeIndex'
				);

			}
		}
	};

	$( function() {
		var module = new VideoModule( { el: document.getElementById( 'WikiaArticleFooter' ) } );
	} );

} );