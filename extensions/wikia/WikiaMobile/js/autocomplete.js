define( 'autocomplete', ['jquery'], function ( $ ) {
	'use strict';

	var reEscape = /(\/|\.|\*|\+|\?|\||\(|\)|\[|\]|\{|\}|\\)/g,
		suggestions = [],
		cachedResponse = [],
		delay;

	function getSuggestions ( list, serviceUrl, value ) {
		var cr;

		clearTimeout( delay );

		if ( value !== '' ) {
			cr = cachedResponse[value];

			if ( cr && cr[0].length > 0 ) {
				suggestions = cr[1];
				suggest( list, value );
			} else {
				delay = setTimeout( function () {
					$.ajax( {
						url: serviceUrl,
						data: {
							search: value
						},
						dataType: 'json'
					} ).done(
						function ( resp ) {
							if ( !resp.error ) {
								suggestions = resp[1];
								cachedResponse[value] = resp;
								suggest( list, value );
							}
						}
					);
				}, 250 );
			}
		}
	}

	function suggest ( list, value ) {
		var len = suggestions.length,
			lis = '',
			sug,
			i = 0,
			animationInterval,
			regExp,
			li,
			cur = 0;

		list.empty();

		if ( len > 0 ) {
			clearInterval( animationInterval );
			regExp = new RegExp( '(' + value.replace( reEscape, '\\$1' ) + ')', 'gi' );

			for ( ; i < len; i++ ) {
				sug = suggestions[i];
				lis += '<li><span title="' + sug + '">' + sug.replace( regExp, '<em>$1</em>' ) + '<span class=copySrh>+</span></span></li>';
			}

			li = list.prepend( lis ).find( 'li' );

			animationInterval = setInterval( function () {
				if ( li[cur] ) {
					li[cur++].className = 'show';
				} else {
					clearInterval( animationInterval );
				}
			}, 70 );
		}
	}

	return function ( options ) {
		var input = $( options.input ),
			list = $( options.list ),
			clear = $( options.clear ),
			//On A2.3 setting class on clear icon have no effect on first use after open
			//to trigger repaint we need to set the class on its parent
			clearParent = clear.parent(),
			serviceUrl = options.url,
			value = input.val().trim();

		if ( !serviceUrl ) {
			throw 'url not provided';
		}

		clearParent.visible = false;

		getSuggestions( list, serviceUrl, value );

		input.on( 'input', function () {
			value = input.val().trim();

			if ( value !== '' ) {
				if ( value.length < 3 ) {
					list.empty();
				} else {
					getSuggestions( list, serviceUrl, value );
				}

				if ( !clearParent.visible ) {
					clearParent.removeClass( 'hide-clear' ).visible = true;
				}
			} else {
				list.empty();

				if ( clearParent.visible ) {
					clearParent.addClass( 'hide-clear' ).visible = false;
				}
			}

			input.parent()[0].scrollIntoView();
		} );

		list.on( 'click', '.copySrh', function ( event ) {
			event.stopPropagation();
			input
				.val( value = this.parentElement.title ).trigger( 'focus' )
				.parent()[0].scrollIntoView();

			getSuggestions( list, serviceUrl, value );
		} )
			.on( 'click', 'span[title]', function () {
				input
					.val( this.title || '' )
					.prev().attr( 'disabled', true )
					.parent().trigger( 'submit' );
			} );

		clear.on( 'touchend',function () {
			list.empty();
			clearParent.addClass( 'hide-clear' ).visible = false;
			input.val( '' );
		} ).on( 'click', function () {
			input.trigger( 'focus' );
		} );
	};
} );
