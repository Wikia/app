/**
 * JavasSript for the Education Program MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Education_Program
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) { $.fn.imageInput = function( options ) {

	var settings = $.extend( {
		'apipath': wgScriptPath + '/api.php'
	}, options );

	return this.each( function() {

		var _this = this,
		$this = $( _this ),
		$img = undefined;

		this.setup = function() {
			$img = $( '<img>' ).attr( {
				'src': '',
				'width': '200px',
				'style': 'display:none'
			} );

			$this.after( $img );

			if ( $.trim( $this.val() ) !== '' ) {
				this.getAndDisplayImage( $this.val() );
			}

			$this.autocomplete( {
				source: this.findImages,
				select: this.onSelect
			} );
		};

		this.findImages = function( request, response ) {
			$.getJSON(
				settings.apipath,
				{
					'action': 'query',
					'format': 'json',
					'list': 'allpages',
					'apprefix': request.term,
					'apnamespace': 6,
					'aplimit': 5
				},
				function( data ) {
					response( $.map( data.query.allpages, function( item ) {
						return {
							'label': item.title,
							'value': item.title
						};
					} ) );
				}
			);
		};

		this.onSelect = function( event, ui ) {
			this.getAndDisplayImage( ui.item.label );
		};

		this.getAndDisplayImage = function( pageTitle ) {
			this.getPreviewImage(
				{
					'title': pageTitle,
					'width': 200
				},
				this.displayImage
			);
		}

		this.displayImage = function( imageUrl ) {
			if ( imageUrl === false ) {
				$img.attr( 'style', 'display:none' );
			}
			else {
				$img.attr( {
					'src': imageUrl,
					'style': 'display:block'
				} );
			}
		};

		this.getPreviewImage = function( args, callback ) {
			$.getJSON(
				settings.apipath,
				{
					'action': 'query',
					'format': 'json',
					'prop': 'imageinfo',
					'iiprop': 'url',
					'titles': args.title,
					'iiurlwidth': args.width
				},
				function( data ) {
					if ( data.query && data.query.pages ) {
						var pages = data.query.pages;

						for ( p in pages ) {
							var info = pages[p].imageinfo;
							for ( i in info ) {
								callback( info[i].thumburl );
								return;
							}
						}
					}
					callback( false );
				}
			);
		};

		this.setup();

	});

}; })( window.jQuery, window.mediaWiki );
