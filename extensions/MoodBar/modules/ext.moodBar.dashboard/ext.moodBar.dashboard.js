/**
 * AJAX code for Special:MoodBarFeedback
 */
jQuery( document ).ready( function ( $ ) {
	var formState, filterType, $fbdFiltersCheck, concurrencyState = [];

	/**
	 * Saved form state
	 */
	 formState = {
		types: [],
		username: '',
		myresponse: null,
		showunanswered: null
	 };
	
	/**
	 * Figure out which comment type filters have been selected.
	 * @return array of comment types
	 */
	function getSelectedTypes() {
		var types = [];
		$( '#fbd-filters-type-praise, #fbd-filters-type-confusion, #fbd-filters-type-issues' ).each( function () {
			if ( $(this).prop( 'checked' ) ) {
				types.push( $(this).val() );
			}
		} );
		return types;
	}

	/**
	 * Save the current form state to formState
	 */
	function saveFormState() {
		formState.types = getSelectedTypes();
		formState.username = $( '#fbd-filters-username' ).val();
		formState.myresponse = $( '#fbd-filters-my-response' ).prop( 'checked' ) ? $( '#fbd-filters-my-response' ).val() : null;
		formState.showunanswered = $( '#fbd-filters-show-unanswered' ).prop( 'checked' ) ? $( '#fbd-filters-show-unanswered' ).val() : null;
	}

	/**
	 * Select all comment type filters.
	 */
	function selectAllTypes() {
		$( '#fbd-filters-type-praise, #fbd-filters-type-confusion, #fbd-filters-type-issues' ).prop( 'checked', true );
	}
	/**
	 * Set the moodbar-feedback-types and moodbar-feedback-username cookies based on formState.
	 * This function uses the form state saved in formState, so you may want to call saveFormState() first.
	 */
	function setCookies() {
		$.cookie( 'moodbar-feedback-types', formState.types.join( '|' ), { path: '/', expires: 7 } );
	}

	/**
	 * Load the form state from the moodbar-feedback-types and moodbar-feedback-username cookies.
	 * This assumes the form is currently blank.
	 * @return bool True if the form is no longer blank (i.e. at least one value was changed), false otherwise
	 */
	function loadFromCookies() {
		var	cookieTypes = $.cookie( 'moodbar-feedback-types' ),
			changed = false;

		if ( cookieTypes ) {
			// Because calling .indexOf() on an array doesn't work in all browsers,
			// we'll use cookieTypes.indexOf( '|valueWereLookingFor' ) . In order for
			// that to work, we need to prepend a pipe first.
			cookieTypes = '|' + cookieTypes;
			$( '#fbd-filters-type-praise, #fbd-filters-type-confusion, #fbd-filters-type-issues' ).each( function () {
				if ( !$(this).prop( 'checked' ) && cookieTypes.indexOf( '|' + $(this).val() ) !== -1 ) {
					$(this).prop( 'checked', true );
					changed = true;
				}
			} );
		} else {
			selectAllTypes();
		}
		return changed;
	}

	/**
	 * Show a message in the box that normally contains the More link.
	 * This will hide the more link, remove any existing <span>s,
	 * and add a <span> with the supplied text.
	 * @param text string Message text
	 */
	function showMessage( text ) {
		$( '#fbd-list-more' )
			.children( 'a' )
			.hide()
			.end()
			.children( 'span' )
			.remove() // Remove any previous messages
			.end()
			.append( $( '<span>' ).text( text ) );
	}

	/**
	 * Load a set of 20 comments into the list. In 'filter' mode, the list is
	 * blanked before the new comments are loaded. In 'more' mode, the comments are
	 * loaded at the end of the existing set.
	 *
	 * This function uses the form state saved in formState, so you may want to call saveFormState() first.
	 *
	 * @param mode string Either 'filter' or 'more'
	 */
	function loadComments( mode ) {
		var	limit = 20,
			reqData;

		if ( mode === 'filter' ) {
			$( '#fbd-list' ).empty();
		}
		// Hide the "More" link and put in a spinner
		$( '#fbd-list-more' )
			.show() // may have been output with display: none;
			.addClass( 'mw-ajax-loader' )
			.children( 'a' )
			.css( 'visibility', 'hidden' ) // using .hide() cuts off the spinner
			.show() // showMessage() may have called .hide()
			.end()
			.children( 'span' )
			.remove(); // Remove any message added by showMessage()

		// Build the API request
		// @todo FIXME: in 'more' mode, changing the filters then clicking More will use the wrong criteria
		reqData = {
			format: 'json',
			action: 'query',
			list: 'moodbarcomments',
			mbcprop: 'formatted',
			mbclimit: limit + 2 // we drop the first and last result
		};
		if ( mode === 'more' ) {
			reqData.mbccontinue = $( '#fbd-list' ).find( 'li:last' ).data( 'mbccontinue' );
		}
		if ( formState.types.length ) {
			reqData.mbctype = formState.types.join( '|' );
		}
		if ( formState.username.length ) {
			reqData.mbcuser = formState.username;
		}
		if ( formState.myresponse ) {
			reqData.mbcmyresponse = formState.myresponse;
		}
		if ( formState.showunanswered ) {
			reqData.mbcshowunanswered = formState.showunanswered;
		}

		$.ajax( {
			url: mw.util.wikiScript( 'api' ),
			data: reqData,
			success: function ( data ) {
				var comments, len, $ul, moreResults, i;

				// Remove the spinner and restore the "More" link
				$( '#fbd-list-more' )
					.removeClass( 'mw-ajax-loader' )
					.children( 'a' )
					.css( 'visibility', 'visible' ); // Undo visibility: hidden;

				if ( !data || !data.query || !data.query.moodbarcomments ) {
					showMessage( mw.msg( 'moodbar-feedback-ajaxerror' ) );
					return;
				}

				comments = data.query.moodbarcomments;
				len = comments.length;
				$ul = $( '#fbd-list' );
				moreResults = false;

				if ( len === 0 ) {
					if ( mode === 'more' ) {
						showMessage( mw.msg( 'moodbar-feedback-nomore' ) );
					} else {
						showMessage( mw.msg( 'moodbar-feedback-noresults' ) );
					}
					return;
				}

				if ( mode === 'more' ) {
					// Drop the first element because it duplicates the last shown one
					comments.shift();
					len--;
				}
				if ( len > limit ) {
					// Drop any elements past the limit. We do know there are more results now
					len = limit;
					moreResults = true;
				}

				for ( i = 0; i < len; i+= 1 ) {
					$ul.append( comments[i].formatted );
				}

				if ( !moreResults ) {
					if ( mode === 'more' ) {
						showMessage( mw.msg( 'moodbar-feedback-nomore' ) );
					} else {
						$( '#fbd-list-more' ).hide();
					}
				}
			},
			error: function ( jqXHR, textStatus, errorThrown ) {
				$( '#fbd-list-more' ).removeClass( 'mw-ajax-loader' );
				showMessage( mw.msg( 'moodbar-feedback-ajaxerror' ) );
			},
			dataType: 'json'
		} );
	}

	/**
	 * Reload a comment, showing hidden comments if necessary
	 * @param $item jQuery item containing the .fbd-item
	 * @param show Set to true to show the comment despite its hidden status
	 */
	function reloadItem( $item, show ) {
		var cont, request;

		cont = $item.data( 'mbccontinue' );

		request = {
			action: 'query',
			list: 'moodbarcomments',
			format: 'json',
			mbcprop: 'formatted',
			mbclimit: 1,
			mbccontinue: cont
		};

		if ( show ) {
			request.mbcprop = 'formatted|hidden';
		}

		$.ajax( {
			url: mw.util.wikiScript( 'api' ),
			data: request,
			success: function ( data ) {
				if ( data && data.query && data.query.moodbarcomments &&
					data.query.moodbarcomments.length > 0
				) {
					var $content = $( data.query.moodbarcomments[0].formatted );
					$item.replaceWith( $content );
				} else {
					// Failure, just remove the link.
					$item.find( '.fbd-item-show' ).remove();
					$item.find( '.mw-ajax-loader' ).remove();
					showItemError( $item );
				}
			},
			dataType: 'json',
			error: function () {
				showItemError( $item );
			}
		} );
	}

	/**
	 * Show a hidden comment
	 */
	function showHiddenItem(e) {
		var $item, $spinner;

		$item = $(this).closest( '.fbd-item' );
		$spinner = $( '<span class="mw-ajax-loader">&nbsp;</span>' );
		$item.find( '.fbd-item-show' ).empty().append( $spinner );

		reloadItem( $item, true );

		e.preventDefault();
	}

	/**
	 * Show an error on an individual item
	 * @param $item The .fbd-item to show the message on
	 * @param message The message to show (currently ignored)
	 */
	function showItemError( $item, message ) {
		$item.find( '.mw-ajax-loader' ).remove();
		$( '<div class="error"></div>' )
			.text( mw.msg( 'moodbar-feedback-action-error' ) )
			.prependTo( $item );
	}

	/**
	 * Do this before administrative action to confirm action and provide reason
	 * @param params to store action paramaters
	 * @param $item jQuery item containing the .fbd-item
	 */
	function confirmAction( params, $item ) {
		var inlineForm, storedParams, $storedItem;

		inlineForm = $( '<span>' )
			.attr( 'class', 'fbd-item-reason' )
			.append( $( '<span>' ).text( mw.msg( 'moodbar-action-reason' ) ) )
			.append( $( '<input>' ).attr({'class':'fbd-action-reason', 'name':'fbd-action-reason'} ) )
			.append( $( '<button>' ).attr( 'class', 'fbd-action-confirm' ).text( mw.msg( 'moodbar-feedback-action-confirm' ) ) )
			.append( $( '<button>' ).attr( 'class', 'fbd-action-cancel' ).text( mw.msg( 'moodbar-feedback-action-cancel' ) ) )
			.append( $( '<span>' ).attr( 'class', 'fbd-item-reason-msg' ) )
			.append( $( '<div>' ).attr( 'class', 'fbd-item-reason-msg' ) );

		storedParams = params;
		$storedItem = $item;

		$item.find( '.fbd-item-hide, .fbd-item-restore, .fbd-item-permalink' )
			.empty();

		$item.find( '.fbd-item-message' )
			.append(inlineForm);

		$( '.fbd-action-confirm' ).click( function () {
			storedParams.reason = $storedItem.find( '.fbd-action-reason' ).val();

			if ( storedParams.reason ) {
				doAction( storedParams, $storedItem );
			} else {
					inlineMessage( $storedItem.find( '.fbd-item-reason' ), mw.msg( 'moodbar-action-reason-required' ), function () {
					reloadItem( $storedItem, true );
				});
			}

		});
		$( '.fbd-action-cancel' ).click( function () {
			reloadItem( $storedItem, true );
		});

	}

	/**
	 * Execute an action on an item
	 * @param params contains action parameters
	 * @param $item jQuery item containing the .fbd-item
	 */
	function doAction( params, $item ) {
		var item_id, $spinner;

		function errorHandler ( error_str ) {
			showItemError( $item, error_str );
		}
		
		item_id = $item.data( 'mbccontinue' ).split( '|' )[1];
		$spinner = $( '<span class="mw-ajax-loader">&nbsp;</span>' );
		$item.find( '.fbd-item-hide' ).empty().append( $spinner );

		$.ajax( {
			type: 'POST',
			url: mw.util.wikiScript( 'api' ),
			data: $.extend( {
				action: 'feedbackdashboard',
				token: mw.user.tokens.get( 'editToken' ),
				item: item_id,
				format: 'json'
			}, params ),
			success: function ( response ) {
				if ( response && response.feedbackdashboard ) {
					if ( response.feedbackdashboard.result === 'success' ) {
						reloadItem( $item );
					} else {
						errorHandler( response.feedbackdashboard.error );
					}
				} else if ( response && response.error ) {
					errorHandler( response.error.message );
				} else {
					errorHandler();
				}
			},
			error: errorHandler
		} );
	}

	/**
	 * Restore a hidden item to full visibility (event handler)
	 * @param e {jQuery.Event}
	 */
	function restoreItem( e ) {
		var $item = $(this).closest( '.fbd-item' );

		confirmAction( { mbaction: 'restore' }, $item );
		e.preventDefault();
	}

	/**
	 * Hide a item from view (event handler)
	 * @param e {jQuery.Event}
	 */
	function hideItem( e ) {
		var $item = $(this).closest( '.fbd-item' );

		closeAllResponders(); // If any are open
		confirmAction( { mbaction: 'hide' }, $item );
		e.preventDefault();
	}

	/**
	 * Method to close all responders.
	 * Remove all .fbd-response-form from the dashboard
	 */
	function closeAllResponders() {

		$( '.fbd-item' ).each( function () {
			var $link = $( this ).find( '.fbd-respond-link' );

			if ( $link.hasClass( 'responder-expanded' ) ) {

				$link.find( '.fbd-item-response-expanded' )
					.addClass( 'fbd-item-response-collapsed' )
					.removeClass( 'fbd-item-response-expanded' )
					.end()
					.find( '.fbd-item-response-collapsed' )
					.parent()
					.removeClass( 'responder-expanded' );
				//remove disabled prop to prevent memory leaks in IE < 9
				$( '.fbd-response-preview, .fbd-response-submit' ).removeProp( 'disabled' );
				$( this ).find( '.fbd-response-form' ).remove();
			}
			//remove ConcurrencyToolTip if any
			$( this ).find( '.fbd-tooltip-overlay-wrap').remove();
		});
	}

	/**
	 * Show the Response form for the item
	 * Build the response form elements once
	 * @param e {jQuery.Event}
	 */
	function showResponseForm( e ) {
		var termsLink, ula, inlineForm, $item, itemId;

		if ( $(this).hasClass( 'responder-expanded' ) ) {

			closeAllResponders();

		} else {

			// Init terms of use link
			termsLink = mw.html.element ( 'a', {
				href: mw.msg( 'moodbar-response-url' ),
				title: mw.msg( 'moodbar-response-link' ),
				target: '_blank'
			}, mw.msg( 'moodbar-response-link' ) );

			// ULA
			ula = mw.msg( 'moodbar-response-terms' )
				.replace ( /\$1/g, termsLink );

			// Build form
			inlineForm = $( '<div>' ).attr( 'class', 'fbd-response-form' )
				.append(
					$( '<b>' ).text( mw.msg( 'moodbar-response-add' ) )
				).append(
					$( '<small>' ).attr( 'class', 'fbd-text-gray' ).text( ' (' + mw.msg( 'moodbar-response-desc' ) + ') ' )
				).append(
					$( '<div>' ).attr( 'class', 'fbd-response-formNote' )
						.append( $( '<small>' )
						.append(
							$( '<span>' ).attr( 'class', 'fbd-response-charCount' )
						).append(
							$( '<span>' ).text( mw.msg( 'moodbar-form-note-dynamic' ).replace( /\$1/g, "" ) )
						)
					)
				).append(
					$( '<textarea>' ).attr( { 'class':'fbd-response-text', 'name':'fbd-response-text' } )
				).append(
					$( '<div>' ).attr( 'class', 'fbd-response-preview-spinner' )
						.append( $( '<span>' ).attr( 'class', 'mw-ajax-loader' )
							//hack the .mw-ajax-loader styles beacuse they are horrible for reuse
							.css({ 'top':'0px','padding':'16px', 'display':'block', 'width':'32px' }).html( '&nbsp;' )
						).hide()
				).append(
					$( '<div>' ).attr( 'class', 'fbd-response-preview-block' )
					.append(
						$( '<div>' ).attr( 'class', 'fbd-response-wikitext' ).hide())
					.append(
						$( '<div>' ).attr( 'class', 'ula small' ).html( ula ).hide())
				).append(
					$( '<button>' ).attr( 'class', 'fbd-response-submit' ).html( mw.msg( 'moodbar-response-btn' ) + '&nbsp;<span class="fbd-item-send-response-icon"></span>' )
						.prop( 'disabled', true ).hide()
				).append(
					$( '<button>' ).attr( 'class', 'fbd-response-preview-back' ).text( mw.msg( 'response-back-text' ) ).hide()
				).append(
					$( '<button>' ).attr( 'class', 'fbd-response-preview' ).text ( mw.msg( 'response-preview-text' ) ).prop( 'disabled', true )
				).append(
					$( '<div>' ).attr( 'style', 'clear: both;' )
				);

			// Get the feedbackItem
			$item = $(this).closest( '.fbd-item' );

			// Close any open responders prior to opening this one.
			closeAllResponders();

			$(this)
				.find( '.fbd-item-response-collapsed' )
					.addClass( 'fbd-item-response-expanded' )
					.removeClass( 'fbd-item-response-collapsed' )
				.end()
				.find( '.fbd-item-response-expanded' )
				.parent()
					.addClass( 'responder-expanded' );

			$item.append(inlineForm)
				.find( '.fbd-response-text' )
				.NobleCount( '.fbd-response-charCount', {
					max_chars:5000,
					/*
					 * Callbacks:
					 * function on_negative: called when text field is negative in remaining characters.
					 * @param t_obj is the text object. need to pass to the callback to add modifiers.
					 */
					on_negative: function ( t_obj ) {
						$( t_obj )
							.prev()
							.find( 'span' )
							.addClass( 'red-bold' );
					},
					/*
					 * function on_positive: called when text field has available remaining characters.
					 * @param t_obj is the text object. need to pass to the callback to add modifiers.
					 */
					on_positive: function ( t_obj ) {
						$( t_obj )
							.prev()
							.find( 'span' )
							.removeClass( 'red-bold' );
					}
				})
				.end()
				.find( '.fbd-response-text' )
				.keyup( function ( e ) {
					validateResponse( $item );
				})
				.elastic()
				.end()
				.find( '.fbd-response-preview' )
				.click (function () {
					//toggle preview
					$item = $(this).parent().parent();
					$item.find( '.fbd-response-preview, .fbd-response-text' ).hide();
					$item.find( '.fbd-response-submit, .fbd-response-preview-back, .ula' ).show();
					var wikitext = $item.find( '.fbd-response-text' ).val();
					wikitext = wikitext.replace( /~{3,5}/g, '' ) + "\n\n~~~~"; // Remove and add signature for
					parseWikiText( $item, wikitext );
				});
				
				//check for concurrency module.
				if ( $.concurrency !== undefined ) {
					itemId = $item.data( 'mbccontinue' ).split( '|' )[1];
					//concurrency module is here, attempt checkout
					$.concurrency.check( {
						ccaction: 'checkout',
						resourcetype: 'moodbar-feedback-response',
						record: itemId
					}, function ( result ){
						//if checkout failed, show tooltip if it hasn't been shown
						if ( result === 'failure' && $.inArray( itemId, concurrencyState ) === -1  ) { 
							concurrencyState.push( itemId );
							loadConcurrencyToolTip( $item );
						}
					} );
				}

		}		
		e.preventDefault();
	}

	function parseWikiText( $item, wikitext ) {
		$item.find( '.fbd-response-preview-spinner' ).show();
		$.ajax({
			url: mw.util.wikiScript( 'api' ),
			data: {
				'action': 'parse',
				'title': mw.config.get( 'wgPageName' ),
				'format': 'json',
				'text': wikitext,
				'prop': 'text',
				'pst': true
			},
			dataType: 'json',
			type: 'POST',
			success: function ( data ) {
				$item
					.find( '.fbd-response-preview-spinner' ) // Fadeout spinner
					.hide()
					.end()
					.find( '.fbd-response-wikitext' )
					.html( data.parse.text['*'] )
					.fadeIn()
					.end();
			},
			error: function () {
				// Handle error
				// @todo: Fadeout spinner
			}
		});
	}

	/**
	 * Toggle submit / preview button from enabled to disabled
	 * Depends on value of .fbd-response-text
	 * @param $item jQuery item containing the .fbd-item
	 * Require at least 1 character and limit to 5000
	 */
	function validateResponse( $item ) {
		var response = $.trim( $item.find( '.fbd-response-text' ).val() );
		if ( response.length > 0 && response.length <= 5000 ) {
			$item.find( '.fbd-response-submit, .fbd-response-preview' ).prop( 'disabled', false);
		} else {
			$item.find( '.fbd-response-submit, .fbd-response-preview' ).prop( 'disabled', true);
		}
	}

	/**
	 * Generic inline message, with fadeout
	 * @param $el Element to display message inside
	 * @param msg text to display
	 * @callback to execute after fadeOut
	 */
	function inlineMessage( $el, msg, callback) {
		$el.empty()
			.text( msg )
			.delay( 2000 )
			.fadeOut( 'slow', callback );
	}
	/**
	 * Set status message for Send Response
	 * @param $el Feedback Item for response
	 * @param type is type of message which determins icon (error, success)
	 * @param head Heading text to be displayed
	 * @param body Body text to be displayed
	 */
	function responseMessage( $el, type, head, body ) {
		$el
			.find( '.mw-ajax-loader' )
				.addClass( 'fbd-item-response-' + type )
				.removeClass( 'mw-ajax-loader' )
			.end()
			.find( '.fbd-ajax-heading' )
				.text( head )
			.end()
			.find( '.fbd-ajax-text' )
				.html( body )
			.end();

		setTimeout( function () {
			reloadItem( $el, true );
		}, 2000 );
	}
	
	/**
	 * Display tooltip for response concurrency notification
	 * @param $item Feedback item
	*/
	function loadConcurrencyToolTip( $item ) {
		var $tooltip = $( '<div>' )
			.attr( 'class', 'fbd-tooltip-overlay-wrap' )
			.append(
				$( '<div>' ).attr( 'class', 'fbd-tooltip-overlay' )
			.append(
				$( '<div>' ).attr( 'class', 'fbd-tooltip-pointy' )
			).append(
				$( '<div>' )
					.attr( 'class', 'fbd-tooltip-title' )
					.text( mw.msg( 'response-concurrency-notification' ) ) 
					.prepend(
						$( '<span>' ).attr( 'class', 'fbd-tooltip-close' ).text( 'X' )	
					)
			)
		);
		$item.find( '.fbd-item-response' ).append( $tooltip );

		// Close event, closure remembers object
		$( '.fbd-tooltip-close' )
			.live( 'click' , function () {
				$tooltip.remove();
			} );

		setTimeout( function () {
			$tooltip.fadeOut( function (){
				$tooltip.remove();
			} );
		}, 2500 );
	}
	
	// On-load stuff
	$( '.fbd-item-show a' ).live( 'click', showHiddenItem );
	$( '.fbd-item-hide a' ).live( 'click', hideItem );
	$( '.fbd-item-restore' ).live( 'click', restoreItem );
	$( '.fbd-respond-link' ).live ( 'click', showResponseForm );

	// Handle preview back button
	$( '.fbd-response-preview-back' ).live( 'click', function () {
		var $item = $(this).parent().parent();
		$item.find( '.fbd-response-submit, .fbd-response-wikitext, .fbd-response-preview-back, .ula' ).hide();
		$item.find( '.fbd-response-preview, .fbd-response-text' ).show();
	});

	// Handle response submit
	$( '.fbd-response-submit' ).live( 'click', function () {
		var $item, fbResponse, clientData, item_id, resData, $responseStatus, $responseForm;

		$item = $(this).parent().parent();
		fbResponse = $item.find( '.fbd-response-text' ).val();
		if ( fbResponse ) {
			clientData = $.client.profile();
			item_id = $item.data( 'mbccontinue' ).split( '|' )[1];
			resData = {
				action: 'feedbackdashboardresponse',
				useragent: clientData.name + '/' + clientData.versionNumber,
				system: clientData.platform,
				token: mw.user.tokens.get( 'editToken' ),
				response: fbResponse,
				feedback: item_id,
				format: 'json'
			};

			 $responseStatus = $( '<div>' ).attr( 'class', 'fbd-ajax-response' )
				.append( $( '<span>' ).attr( 'class','mw-ajax-loader fbd-item-response-icon' ).html( '&nbsp;' ) )
				.append( $( '<div>' )
					.append( $( '<span>' ).attr( 'class', 'fbd-ajax-heading' ).text( mw.msg( 'response-ajax-action-head' ) ) )
					.append( $( '<span>' ).attr( 'class', 'fbd-ajax-text' ).text( mw.msg( 'response-ajax-action-body' ) ) )
			);

			$responseForm = $item.find( '.fbd-response-form' );
			$responseForm.empty().append( $responseStatus );

			// Send response
			$.ajax( {
				type: 'POST',
				url: mw.util.wikiScript( 'api' ),
				data: resData,
				success: function (data) {
						// If rejected
						if ( data.error !== undefined ) {
							responseMessage( $item, 'error', mw.msg( 'response-ajax-error-head' ), data.error.info );
						} else if ( data.feedbackdashboardresponse !== undefined ) {
							responseMessage( $item, 'success', mw.msg( 'response-ajax-success-head' ), mw.msg( 'response-ajax-success-body' ) );
						}
				},
				error: function ( jqXHR, textStatus, errorThrown ) {
						responseMessage( $item, 'error', mw.msg( 'response-ajax-error-head' ), mw.msg( 'response-ajax-error-body' ) );
				},
				dataType: 'json'
			} );

		}
	});

	$( '#fbd-filters' ).children( 'form' ).submit( function ( e ) {
		e.preventDefault();
		saveFormState();
		setCookies();
		loadComments( 'filter' );
	} );

	$( '#fbd-list-more' ).children( 'a' ).click( function ( e ) {
		e.preventDefault();
		// We don't call saveFormState() here because we want to use the state of the form
		// at the time it was last filtered. Otherwise, you would see strange behavior if
		// you changed the form state then clicked More.
		loadComments( 'more' );
	} );

	$( '#fbd-filters-types input[type="checkbox"]' ).click( function () {
		var types = getSelectedTypes();
		if ( types.length === 0 ) { //check for 0 because onclick it will already have unchecked itself.
			$(this).prop( 'checked', true);
		}
	});

	// Only allow one of the secondary filters to be checked
	$fbdFiltersCheck = $( 'input.fbd-filters-check[type="checkbox"]' ).click(function () {
		$fbdFiltersCheck.not( this ).prop( 'checked', false );
	});

	$( '#fbd-list' )
		.delegate( '.fbd-item', 'hover', function () {
			$(this).toggleClass( 'fbd-hover' );
		})
		.delegate( '.fbd-item', 'mouseleave', function () {
			$(this).removeClass( 'fbd-hover' );
		});

	//zebra stripe leaderboard
	$( '.fbd-leaderboard li:nth-child(even)' ).addClass( 'even' );

	saveFormState();

	filterType = $( '#fbd-filters' ).children( 'form' ).data( 'filtertype' );
	// If filtering already happened on the PHP side, don't load the form state from cookies
	if ( filterType !== 'filtered' ) {
		// Don't do an AJAX filter if we're on an ID view, or if the form is still blank after loadFromCookies()
		if ( loadFromCookies() && filterType !== 'id' ) {
			saveFormState();
			loadComments( 'filter' );
		}
	}

} );
