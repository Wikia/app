/**
 * JavasSript for the Semantic Image Input MediaWiki extension.
 * 
 * TODO: this was written in a sprint; could be made less evil.
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {
	
	$.fn.instantImage = function( opts ) {
		
		var _this = this;
		var $this = $( this );
		
		this.loadedFirstReq = null;
		this.images = null;
		this.raw = null;
		
		this.options = {
			'imagename': 'Beatles',
			'inputname': '',
			'apipath': 'https://en.wikipedia.org/w/api.php?callback=?',
			'imagewidth': 200
		};
		
		this.getMainTitle = function( callback ) {
			$.getJSON(
				this.options.apipath,
				{
					'action': 'query',
					'format': 'json',
					'titles': this.options.imagename,
					'redirects': 1,
				},
				function( data ) {
					if ( data.query && data.query.redirects ) {
						_this.options.imagename = data.query.redirects[0].to;
					}
					
					callback();
				}
			);
		};
		
		this.getImages = function( callback ) {
			$.getJSON(
				this.options.apipath,
				{
					'action': 'query',
					'format': 'json',
					'prop': 'images',
					'titles': this.options.imagename,
					'redirects': 1,
					'imlimit': 500
				},
				function( data ) {
					var imgNames = [];
					
					if ( data.query && data.query.pages ) {
						for ( pageid in data.query.pages ) {
							var images = data.query.pages[pageid].images;
							
							if ( typeof images !== 'undefined' ) {
								for ( var i = images.length - 1; i >= 0; i-- ) {
									imgNames.push( images[i].title );
								}
							}
							
							_this.images = imgNames;
							callback();
							return;
						}
					}
					
					_this.showNoImage();
				}
			);	
		};
		
		this.getRaw = function( callback ) {
			$.getJSON(
				this.options.apipath,
				{
					'action': 'query',
					'format': 'json',
					'prop': 'revisions',
					'rvprop': 'content',
					'titles': this.options.imagename
				},
				function( data ) {
					if ( data.query ) {
						for ( pageWikiID in data.query.pages ) {
							if ( data.query.pages[pageWikiID].revisions ) {
								_this.raw = data.query.pages[pageWikiID].revisions[0]["*"];
								callback();
								return;
							}
						}
					}
					
					_this.showNoImage();
				}
			);
		};
		
		this.getFirstImage = function() {
			var image = false;
			var lowest = this.raw.length;
			
			for ( var i = this.images.length - 1; i >= 0; i-- ) {
				var img = this.images[i].split( ':', 2 );
				var index = this.raw.indexOf( img[img.length > 1 ? 1 : 0] );
				
				if ( index !== -1 && index < lowest ) {
					lowest = index;
					image = this.images[i];
				}
			}
			
			return image;
		};
		
		this.showNoImage = function() {
			$this.html( 'No image found.' );
		};
		
		this.showImage = function( image ) {
			if ( image === false ) {
				this.showNoImage();
				return;
			}
			
			$.getJSON(
				this.options.apipath,
				{
					'action': 'query',
					'format': 'json',
					'prop': 'imageinfo',
					'iiprop': 'url',
					'titles': image,
					'iiurlwidth': this.options.imagewidth
				},
				function( data ) {
					if ( data.query && data.query.pages ) {
						var pages = data.query.pages;
						
						for ( p in pages ) {
							var info = pages[p].imageinfo;
							for ( i in info ) {
								if ( info[i].thumburl.indexOf( '/wikipedia/commons/' ) !== -1 ) {
									$( 'input[name="' + _this.options.inputname + '"]' ).val( image );
									
									$this.html( $( '<img />' ).attr( {
										'src': info[i].thumburl,
										'width': _this.options.imagewidth + 'px'
									} ) );
									
									return;
								}
							}
							
							_this.showNoImage();
						}
					}
				}
			);
		};
		
		this.dispReqResult = function( images ) {
			if ( !_this.loadedFirstReq ) {
				_this.loadedFirstReq = true;
			}
			else {
				_this.showImage( _this.getFirstImage() );
			}
		};
		
		this.start = function() {
			this.loadedFirstReq = false;
			
			if ( this.options.iteminput ) {
				this.options.imagename = this.options.iteminput.val();
			}
			
			if ( this.options.imagename.trim() === '' ) {
				$this.html( '' );
			}
			else {
				this.getMainTitle( function() {
					_this.getImages( _this.dispReqResult );
					_this.getRaw( _this.dispReqResult );
				} );
			}
		}
		
		this.init = function() {
			$.extend( this.options, opts );
			
			if ( this.options.iteminput ) {
				this.options.iteminput.change( function() { _this.start(); } );
			}
			
			this.start();
		};
		
		this.init();
		
		return this;
	};
	
})( window.jQuery, window.mediaWiki );
