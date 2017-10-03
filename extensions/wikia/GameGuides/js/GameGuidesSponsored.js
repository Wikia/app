/* global mw, confirm */
$(function () {
	'use strict';

	require( ['wikia.window', 'jquery', 'wikia.nirvana', 'JSMessages'], function ( window, $, nirvana, msg ) {

		var d = document,
			category = mw.config.get( 'videoTemplate' ),
			tag = mw.config.get( 'languageTemplate' ),
			requiredError = msg( 'wikiagameguides-sponsored-required-entry' ),
			emptyTagError = msg( 'wikiagameguides-sponsored-empty-tag' ),
			orphanedVideo = msg( 'wikiagameguides-sponsored-orphaned-video' ),
			sure = msg( 'wikiagameguides-sponsored-delete-videos-are-you-sure' ),
			videoDoesNotExist = msg( 'wikiagameguides-sponsored-video-does-not-exist' ),
			videoIsNotOoyala = msg( 'wikiagameguides-sponsored-video-is-not-ooyala' ),
			addCategory = d.getElementById( 'addCategory' ),
			addTag = d.getElementById( 'addTag' ),
			$save = $( d.getElementById( 'save' ) ),
			form = d.getElementById( 'contentManagmentForm' ),
			$form = $( form ),
			ul = form.getElementsByTagName( 'ul' )[0],
			$ul = $( ul ),
			setup = function ( elem ) {
				(elem || $ul.find( '.video-name' )
					).autocomplete( {
					serviceUrl: window.wgScript,
					params: {
						action: 'ajax',
						rs: 'getLinkSuggest',
						format: 'json',
						ns: window.wgNamespaceIds.video
					},
					appendTo: form,
					onSelect: function () {
						$ul.find( 'input:focus' ).next().focus();
					},
					deferRequestBy: 100,
					minLength: 3,
					skipBadQueries: true
				} );
			},
			addNew = function ( row ) {
				$ul.append( row );
				setup( $ul.find( '.video-name:last' ) );
				$ul.find( '.wiki-input:last' ).focus();

				$ul.sortable( 'refresh' );
			},
			checkInputs = function ( elements ) {

				elements.each(function () {
					var $this = $( this ), val = $this.val();

					if ( val === '' ) {
						$this.addClass( 'error' ).popover( 'destroy' ).popover( {
								content: requiredError
							} );
					} else {
						$this.removeClass( 'error' ).popover( 'destroy' );
					}
				});
			},
			checkForm = function () {

				$save.removeClass();

				checkInputs( $ul.find( 'input' ) );

				var lis = $ul.children(), first = lis.first(),
					firsts;

				lis.removeClass( 'error' ).popover( 'destroy' );

				if ( !first.hasClass( 'language' ) ) {

					firsts = first.nextUntil( '.language' );

					if ( first.hasClass( 'video' ) || firsts.length ) {
						first.add( firsts ).addClass( 'error' ).popover( 'destroy' ).popover( {
								content: orphanedVideo
							} );
					}
				}

				$ul.find( '.language' ).each(function () {
					var $t = $( this ), $categories = $t.nextUntil( '.language' );

					if ( $categories.length === 0 ) {
						$t.find( '.language-input' ).addClass( 'error' ).popover( 'destroy' ).popover( {
								content: emptyTagError
							} );
					}
				});

				if ( d.getElementsByClassName( 'error' ).length > 0 ) {
					$save.attr( 'disabled', true );
					return false;
				} else {
					$save.attr( 'disabled', false );
					return true;
				}
			};

		function isEmpty ( obj ) {
			var key;

			for ( key in obj ) {
				if ( obj.hasOwnProperty( key ) ) {
					return false;
				}
			}

			return true;
		}

		$form.on( 'keypress', '.video-name', function ( ev ) {
				if ( ev.keyCode === 13 ) {
					addNew( category, $( this ).parent() );
				}
			}).on( 'keypress', '.wiki-input, .video-title', function ( ev ) {
				if ( ev.keyCode === 13 ) {
					$( this ).next().focus();
				}
			}).on( 'focus', 'input', function () {
				checkForm();
			}).on( 'blur', 'input', function () {
				checkForm();

				//Data should be trimmed MOB-441
				this.value = this.value.trim();
			}).on( 'click', '.remove', function () {
				ul.removeChild( this.parentElement );
				checkForm();
			});

		$( addCategory ).on( 'click', function () {
			addNew( category );
		});

		$( addTag ).on( 'click', function () {
			addNew( tag );
		});

		function getData ( li ) {
			li = $( li );

			return {
				video_title: li.find( '.video-title' ).val(),
				video_name: li.find( '.video-name' ).val(),
				wiki_domain: li.find( '.wiki-input' ).val()
			}
		}

		$save.on( 'click', function () {
			var data = {};

			if ( checkForm() ) {
				$ul.find( '.language' ).each( function () {
					var $t = $( this ),
						code = $t.find( '.language-input' ).val(),
						videos = [];

					$t.nextUntil( '.language' ).each(function () {
						videos.push( getData( this ) );
					});

					data[code] = videos;
				} );

				if ( isEmpty( data ) && !confirm( sure ) ) {
					return;
				}

				$save.removeClass();
				$form.startThrobbing();

				nirvana.sendRequest({
					controller: 'GameGuidesSpecialSponsored',
					method: 'save',
					data: {
						languages: data
					}
				}).done(function ( data ) {
						if ( data.error ) {
							var err = data.error,
								videos = $form.find( '.video-name' ),
								file,
								check = function () {
									if ( this.value === file ) {
										$( this )
											.addClass( 'error' )
											.popover( 'destroy' )
											.popover({
												content: err[file] === 1 ? videoDoesNotExist : videoIsNotOoyala
											});

										return false;
									}
									return true;
								};

							for ( file in err ) {
								//I cannot use value CSS selector as I want to use current value
								videos.each(check);
							}

							$save.addClass( 'err' );
							$save.attr( 'disabled', true );
						} else if ( data.status ) {
							$save.addClass( 'ok' );
						}
					}).fail(function () {
						$save.addClass( 'err' );
					}).always( function () {
						$form.stopThrobbing();
					});
			}
		});

		//be sure modules are ready to be used
		mw.loader.using( ['jquery.autocomplete', 'jquery.ui.sortable'], function () {
			$ul.sortable({
				opacity: 0.5,
				axis: 'y',
				containment: '#contentManagmentForm',
				cursor: 'move',
				handle: '.drag',
				placeholder: 'drop',
				update: function () {
					checkForm();
				}
			});

			setup();
		});
	});
});
