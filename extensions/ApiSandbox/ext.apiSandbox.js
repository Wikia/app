/*global jQuery, mediaWiki*/
/*jslint regexp: true, browser: true, continue: true, sloppy: true, white: true, forin: true, plusplus: true */
( function ( $, mw, undefined ) {

	var mainRequest, genericRequest, generatorRequest, queryRequest, // UiBuilder objects
		// Caches
		paramInfo, namespaceOptions,
		// page elements
		$format, $action, $query, $queryRow, $help, $mainContainer, $genericContainer,
		$generatorContainer, $queryContainer, $generatorBox, $form, $submit, $requestUrl, $requestPost,
		$output, $postRow, $buttonsContainer, $examplesButton, $examplesContent, $pageScroll;


	/** Local utility functions **/

	// get the first element in a list that is "scrollable"
	// depends on browser and skin (i.e. body or html)
	function getScrollableElement( /* selectors, .. */ ) {
		var i, argLen, el, $el, canScroll;
		for ( i = 0, argLen = arguments.length; i < argLen; i += 1 ) {
			el = arguments[i];
			$el = $(el);
			if ( $el.scrollTop() > 0 ) {
				return el;
			} else {
				$el.scrollTop( 1 );
				canScroll = $el.scrollTop() > 0;
				$el.scrollTop( 0 );
				if ( canScroll ) {
					return el;
				}
			}
		}
		return [];
	}

	function showLoading( $element ) {
		$element.html(
			mw.html.element( 'img',
				{ src: mw.config.get( 'stylepath' ) + '/common/images/spinner.gif', alt: '' } )
			+ mw.html.escape( mw.msg( 'apisb-loading' )
			)
		);
	}

	function showLoadError( $element, message ) {
		$element.html(
			mw.html.element( 'span', { 'class': 'error' }, mw.msg( message ) )
		);
	}

	function getParamInfo( what, loadCallback, completeCallback, errorCallback ) {
		var needed, param, subParam;

		needed = {};
		for ( param in what ) {
			if ( paramInfo[param] === undefined ) {
				needed[param] = what[param];
			} else if ( typeof needed[param] === 'object' ) {
				for ( subParam in param ) {
					if ( paramInfo[param][subParam] === undefined ) {
						needed[param][subParam] = what[param][subParam];
					}
				}
			} else {
				needed[param] = what[param];
			}
		}
		if ( $.isEmptyObject( needed ) ) {
			completeCallback();
		} else {
			loadCallback();
			needed.format = 'json';
			needed.action = 'paraminfo';
			$.getJSON(
				mw.util.wikiScript( 'api' ),
				needed,
				function ( data ) {
					var prop, i, info;

					if ( data.error || !data.paraminfo ) {
						errorCallback();
						return;
					}
					for ( prop in data.paraminfo ) {
						if ( paramInfo[prop] === undefined ) {
							paramInfo[prop] = data.paraminfo[prop];
						} else {
							for ( i = 0; i < data.paraminfo[prop].length; i++ ) {
								info = data.paraminfo[prop][i];
								if ( !paramInfo[prop][info.name] ) {
									paramInfo[prop][info.name] = info;
								}
							}
						}
					}
					completeCallback();
				}
			).error( errorCallback );
		}
	}

	function resetUI() {
		$( '.api-sandbox-builder' ).each( function () {
			$( this ).data( 'builder' ).createInputs();
		} );
	}

	/**
	 * @context {Element}
	 * @param e {jQuery.Event}
	 */
	function exampleClick( e ) {
		var link, params, i, pieces, key, value, $el, splitted, j;
		e.preventDefault();

		resetUI();
		link = $( this ).data( 'exampleLink' ).replace( /^.*?\?/, '' );
		params = link.split( '&' );
		for ( i = 0; i < params.length; i++ ) {
			pieces = params[i].split( '=' );
			if ( pieces.length === 1 ) { // checkbox
				$( '#param-' + pieces[0] ).prop( 'checked', true );
			} else {
				key = pieces[0];
				value = decodeURIComponent( pieces.slice( 1 ).join( '=' ) );
				if ( $.inArray( key, [ 'action', 'format', 'list', 'prop', 'meta' ] ) !== -1 ) {
					continue;
				}
				$el = $( '#param-' + key );
				if ( !$el.length ) {
					continue;
				}
				switch ( $el[0].nodeName.toLowerCase() ) {
					case 'select':
						if ( $el.attr( 'multiple' ) ) {
							splitted = value.split( '|' );
							for ( j = 0; j < splitted.length; j++ ) {
							$el.children( 'option[value="' + mw.html.escape( splitted[j] ) + '"]' )
								.prop( 'selected', true );
							}
						} else {
							$el.children( 'option[value="' + mw.html.escape( value ) + '"]' )
								.prop( 'selected', true );
						}
						break;
					case 'input':
						if ( $el.attr( 'type' ) === 'checkbox' ) {
							$( '#param-' + key ).prop( 'checked', true );
						} else {
							$el.val( value );
						}
						break;
					default:
						continue;
				}
			}
		}
	}

	function updateExamples( info ) {
		var i, $list, urlRegex, count, href, text, match, prefix, $prefix, linkText;

		if ( info.allexamples === undefined ) {
			return;
		}
		// on 1.18, convert everything into 1.19 format
		if ( info.allexamples.length > 0 && typeof info.allexamples[0] === 'string' ) {
			for ( i = 0; i < info.allexamples.length; i++ ) {
				info.allexamples[i] = { '*': info.allexamples[i] };
			}
		}
		$examplesContent.hide().html( '' );
		$list = $( '<ul>' );
		urlRegex = /api.php\?\S+/m;
		count = 0;
		for ( i = 0; i < info.allexamples.length; i++ ) {
			href = '';
			text = '';
			while ( i < info.allexamples.length && info.allexamples[i].description === undefined ) {
				match = urlRegex.exec( info.allexamples[i]['*'] );
				if ( match ) {
					href = match[0];
					break;
				} else {
					text += '\n' + info.allexamples[i]['*'];
				}
				i++;
			}
			if ( !href ) {
				href = info.allexamples[i]['*'];
			}
			if ( !text ) {
				text = info.allexamples[i].description !== undefined ? info.allexamples[i].description : href;
			}
			prefix = text.replace( /[^\n]*$/, '' );
			$prefix = prefix.length ? $( '<b>' ).text( prefix ) : [];
			linkText = text.replace( /^.*\n/, '' );
			$( '<li>' )
				.append( $prefix )
				.append(
					$( '<a>' )
						.attr( 'href', '#' )
						.data( 'exampleLink', href )
						.text( linkText )
						.click( exampleClick )
				).appendTo( $list );
			count++;
		}
		$examplesButton.button( 'option', 'text', mw.msg( count === 1 ? 'apisb-example' : 'apisb-examples' ) );
		$list.appendTo( $examplesContent );
		if ( count ) {
			$examplesButton.show();
		} else {
			$examplesButton.hide();
		}
	}

	function updateQueryInfo( action, query ) {
		var	data,
			isQuery = action === 'query';

		if ( action === '' || ( isQuery && query === '' ) ) {
			$submit.button( 'option', 'disabled', true );
			return;
		}
		query = query.replace( /^.*=/, '' );
		data = {};
		if ( isQuery ) {
			data.querymodules = query;
		} else {
			data.modules = action;
		}
		getParamInfo( data,
			function () {
				showLoading( $mainContainer );
				$submit.button( 'option', 'disabled', true );
				$examplesContent.hide();
			},
			function () {
				var info;
				if ( isQuery ) {
					info = paramInfo.querymodules[query];
				} else {
					info = paramInfo.modules[action];
				}
				mainRequest = new UiBuilder( $mainContainer, info, '' );
				mainRequest.setHelp( $help );
				$submit.button( 'option', 'disabled', false );
				updateExamples( info );
			},
			function () {
				$submit.button( 'option', 'disabled', false );
				showLoadError( $mainContainer, 'apisb-load-error' );
				$examplesContent.hide();
			}
		);
	}

	/**
	 * HTML-escapes and pretty-formats an API description string
	 *
	 * @param s {String} String to escape
	 * @return {String}
	 */
	function smartEscape( s ) {
		if ( !s ) {
			return ''; // @todo: fully verify paraminfo output
		}
		s = mw.html.escape( s );
		if ( s.indexOf( '\n ' ) >= 0 ) {
			// turns *-bulleted list into a HTML list
			s = s.replace( /^(.*?)((?:\n\s+\*?[^\n]*)+)(.*?)$/m, '$1<ul>$2</ul>$3' ); // outer tags
			s = s.replace( /\n\s+\*?([^\n]*)/g, '\n<li>$1</li>' ); // <li> around bulleted lines
		}
		s = s.replace( /\n(?!<)/, '\n<br/>' );
		s = s.replace( /(?:https?:)?\/\/[^\s<>]+/g, function ( s ) {
			// linkify URLs, input is already HTML-escaped above
			return '<a href="' + s + '">' + s + '</a>';
		} );
		return s;
	}

	/**
	 * Updates UI after basic query parameters have been changed
	 */
	function updateUI() {
		var	a = $action.val(),
			q = $query.val(),
			isQuery = a === 'query';
		if ( isQuery ) {
			$queryRow.show();
			if ( q !== '' ) {
				$queryContainer.show();
			} else {
				$queryContainer.hide();
			}
		} else {
			$queryRow.hide();
			$queryContainer.hide();
		}
		$mainContainer.text( '' );
		$help.text( '' );
		updateQueryInfo( a, q );
		$generatorBox.hide();
	}


	/**
	 * Constructor that creates inputs for a query and builds request data
	 *
	 * @constructor
	 * @param $container {jQuery} Container to put UI into
	 * @param info {Object} Query information
	 * @param prefix {String} Additional prefix for parameter names
	 * @param params {Object} Optional override for info.parameters
	 */
	function UiBuilder( $container, info, prefix, params ) {
		this.$container = $container;
		this.info = info;
		this.prefix = prefix + info.prefix;
		this.params = params !== undefined ? params : info.parameters;

		$container.addClass( 'api-sandbox-builder' ).data( 'builder', this );

		this.createInputs();
	}

	UiBuilder.prototype = {
		/**
		 * Creates inputs and places them into container
		 */
		createInputs: function () {
			var $table, $tbody, i, length, param, name;

			$table = $( '<table class="api-sandbox-params mw-datatable"><thead><tr></tr></thead><tbody></tbody></table>' )
				.find( '> thead > tr' )
					.append( mw.html.element( 'th', { 'class': 'api-sandbox-params-label' }, mw.msg( 'apisb-params-param' ) ) )
					.append( mw.html.element( 'th', { 'class': 'api-sandbox-params-value' }, mw.msg( 'apisb-params-input' ) ) )
					.append( mw.html.element( 'th', {}, mw.msg( 'apisb-params-desc' ) ) )
				.end();
			$tbody = $table.find( '> tbody' )
			for ( i = 0, length = this.params.length; i < length; i += 1 ) {
				param = this.params[i];
				name = this.prefix + param.name;

				$( '<tr>' )
					.append(
						$( '<td class="api-sandbox-params-label"></td>' )
							.html( mw.html.element( 'label',
								{ 'for': 'param-' + name }, name )
						)
					)
					.append( $( '<td class="api-sandbox-params-value"></td>' ).html( this.input( param, name ) ) )
					.append( $( '<td>' ).html( smartEscape( param.description ) ) )
					.appendTo( $tbody );
			}
			this.$container.html( $table );
		},

		/**
		 * Adds module help to a container
		 * @param $container {jQuery} Container to use
		 */
		setHelp: function ( $container ) {
			var	linkHtml = '',
				descHtml = smartEscape( this.info.description );
			if ( this.info.helpurls && this.info.helpurls[0] ) {
				descHtml = descHtml + ' ';
				linkHtml = mw.msg( 'parentheses', mw.html.element( 'a', {
					'target': '_blank',
					'href': this.info.helpurls[0]
				}, mw.msg( 'apisb-docs-more' ) ) );
			}
			$container.html( descHtml ).append( linkHtml );
		},

		input: function ( param, name ) {
			var s, id, attributes,
				value = '';
			switch ( param.type ) {
				case 'limit':
					value = '10';
					// fall through:
				case 'user':
				case 'timestamp':
				case 'integer':
				case 'string':
					s = mw.html.element( 'input', {
						'class': 'api-sandbox-input',
						'id': 'param-' + name,
						'value': value,
						'type': 'text'
					} );
					break;

				case 'bool':
					// normalisation for later use
					param.type = 'boolean';
					// fall through:
				case 'boolean':
					s = mw.html.element( 'input', {
						'id': 'param-' + name,
						'type': 'checkbox'
					} );
					break;

				case 'namespace':
					param.type = namespaceOptions;
					// fall through:
				default:
					if ( typeof param.type === 'object' ) {
						id = 'param-' + name;
						attributes = { 'id': id };
						if ( param.multi !== undefined ) {
							attributes.multiple = true;
							s = this.select( param.type, attributes, false );
						} else {
							s = this.select( param.type, attributes, true );
						}
					} else {
						s = mw.html.element( 'code', {}, mw.msg( 'parentheses', param.type ) );
					}
			}
			return s;
		},

		select: function ( values, attributes, selected ) {
			var	i, length, value, face, attrs,
				s = '';

			attributes['class'] = 'api-sandbox-input';
			if ( attributes.multiple === true ) {
				attributes.size = Math.min( values.length, 10 );
			}
			if ( !$.isArray( selected ) ) {
				if ( selected ) {
					s += mw.html.element( 'option', {
						value: '',
						selected: true
					}, mw.msg( 'apisb-select-value' ) );
				}
				selected = [];
			}

			for ( i = 0, length = values.length; i < length; i += 1 ) {
				value = typeof values[i] === 'object' ? values[i].key : values[i];
				face = typeof values[i] === 'object' ? values[i].value : values[i];
				attrs = { 'value': value };

				if ( $.inArray( value, selected ) >= 0 ) {
					attrs.selected = true;
				}

				s += mw.html.element( 'option', attrs, face );
			}
			s = mw.html.element( 'select', attributes, new mw.html.Raw( s ) );
			return s;
		},

		getRequestData: function () {
			var params = '', i, length, param, name, $node, value;

			for ( i = 0, length = this.params.length; i < length; i += 1 ) {
				param = this.params[i];
				name = this.prefix + param.name;
				$node = $( '#param-' + name );
				if ( param.type === 'boolean' ) {
					if ( $node.prop( 'checked' ) === true ) {
						params += '&' + name;
					}
				} else {
					value = $node.val();
					if ( value === undefined || value === null || value === '' ) {
						continue;
					}
					if ( $.isArray( value ) ) {
						value = value.join( '|' );
					}
					params += '&' + encodeURIComponent( name ) + '=' + encodeURIComponent( value );
				}
			}
			return params;
		}
	}; // end of UiBuilder.prototype

	/** When the dom is ready.. **/

	$( function () {

		$( '#api-sandbox-content' ).show();

		// init page elements
		$format = $( '#api-sandbox-format' );
		$action = $( '#api-sandbox-action' );
		$query = $( '#api-sandbox-query' );
		$queryRow = $( '#api-sandbox-query-row' );
		$help = $( '#api-sandbox-help' );
		$mainContainer = $( '#api-sandbox-main-inputs' );
		$generatorContainer = $( '#api-sandbox-generator-inputs' );
		$queryContainer = $( '#api-sandbox-query-inputs' );
		$generatorBox = $( '#api-sandbox-generator-parameters' );
		$requestUrl = $( '#api-sandbox-url' );
		$requestPost = $( '#api-sandbox-post' );
		$output = $( '#api-sandbox-output' );
		$postRow = $( '#api-sandbox-post-row' );
		$buttonsContainer = $( '#api-sandbox-buttons' );
		$examplesContent = $( '#api-sandbox-examples' );
		$pageScroll = $( getScrollableElement( 'body', 'html' ) );
		$form = $( '#api-sandbox-form' );
		$submit = $( '<button>' )
			.attr( 'type', 'submit' )
			.text( mw.msg( 'apisb-submit' ) )
			.appendTo( $buttonsContainer );
		$submit = $submit.clone( /*dataAndEvents=*/true, /*deep=*/true )
			.appendTo( '#api-sandbox-parameters' )
			.add( $submit )
			.click( function ( e ) {
				$form.submit();
			} )
			.button({ disabled: true });

		$examplesButton = $( '<button>' )
			.attr( 'type', 'button' )
			.text( mw.msg( 'apisb-examples' ) )
			.click( function ( e ) {
				$examplesContent.slideToggle();
			} )
			.button()
			.hide()
			.appendTo( $buttonsContainer );

		$( '<button>' )
			.attr( 'type', 'button' )
			.text( mw.msg( 'apisb-clear' ) )
			.click( function ( e ) {
				resetUI();
			} )
			.button()
			.appendTo( $buttonsContainer );

		// init caches
		paramInfo = { modules: {}, querymodules: {} };
		namespaceOptions = [];

		// build namespace cache
		$.each( mw.config.get( 'wgFormattedNamespaces' ), function( nsId, nsName ) {
			if ( Number( nsId ) >= 0 ) {
				if ( nsId === '0' ) {
					nsName = mw.msg( 'apisb-ns-main' );
				}
				namespaceOptions.push( {
					key: nsId,
					value: nsName
				} );
			}		
		} );

		// load stuff we need from the beginning
		getParamInfo(
			{
				mainmodule: 1,
				pagesetmodule: 1,
				modules: 'query'
			},
			function () {},
			function () {
				paramInfo.mainmodule.parameters = paramInfo.mainmodule.parameters.slice( 2 ); // remove format and action
				paramInfo.modules.query.parameters = paramInfo.modules.query.parameters.slice( 3 );
				$genericContainer = $( '#api-sandbox-generic-inputs > div' );
				genericRequest = new UiBuilder( $genericContainer, paramInfo.mainmodule, '' );
				queryRequest = new UiBuilder( $queryContainer, paramInfo.modules.query, '',
					[].concat( paramInfo.modules.query.parameters, paramInfo.pagesetmodule.parameters )
				);
			},
			function () {}
		);

		$action.change( updateUI );
		$query.change( updateUI );

		$( '#param-generator' ).live( 'change', function () {
			var generator = $( '#param-generator' ).val();
			if ( generator === '' ) {
				$generatorBox.hide();
			} else {
				$generatorBox.show();
				getParamInfo(
					{ querymodules: generator },
					function () { showLoading( $generatorContainer ); },
					function () {
						generatorRequest = new UiBuilder( $generatorContainer, paramInfo.querymodules[generator], 'g' );
					},
					function () {
						showLoadError( $generatorContainer, 'apisb-request-error' );
					}
				);
			}
		} );


		$form.submit( function ( e ) {
			var url, params, mustBePosted;

			e.preventDefault();

			if ( $submit.button( 'option', 'disabled' ) === true ) {
				return;
			}

			url = mw.util.wikiScript( 'api' ) + '?' + $.param({ action: $action.val() });
			params = mainRequest.getRequestData();
			mustBePosted = mainRequest.info.mustbeposted === '';
			if ( $action.val() === 'query' ) {
				url += '&' + $query.val();
				params += queryRequest.getRequestData();
			}
			url += '&format=' + $format.val();

			params += genericRequest.getRequestData();
			if ( $( '#param-generator' ).length && $( '#param-generator' ).val() ) {
				params += generatorRequest.getRequestData();
			}

			showLoading( $output );
			if ( mustBePosted ) {
				$requestUrl.val( url );
				if ( params.length > 0 ) {
					params = params.substr( 1 ); // remove leading &
				}
				$requestPost.val( params );
				$postRow.show();
			} else {
				$requestUrl.val( url + params );
				$postRow.hide();
			}
			url = url.replace( /(&format=[^&]+)/, '$1fm' );
			$.ajax({
				url: url,
				data: params,
				dataType: 'text',
				type: mustBePosted ? 'POST' : 'GET',
				success: function ( data ) {
					var match = data.match( /<pre>[\s\S]*<\/pre>/ );
					if ( $.isArray( match ) ) {
						data = match[0];
					} else {
						// some actions don't honor user-specified format
						data = '<pre>' + mw.html.escape( data ) + '</pre>';
					}
					$output.html( data );
				},
				error: function () {
					showLoadError( $output, 'apisb-request-error' );
				},
				// either success or error
				complete: function () {
					$pageScroll.animate({ scrollTop: $('#api-sandbox-result').offset().top }, 400, function () {
						window.location.hash = '#api-sandbox-result';
					});
				}
			});
		});

	});

}( jQuery, mediaWiki ) );
