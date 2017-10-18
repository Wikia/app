/**
 * Article Comments JS code for the WikiaMobile skin
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub 'Student' Olek
 **/

require( ['throbber', 'toast', 'modal', 'track', 'JSMessages', 'lazyload', 'jquery', 'wikia.window'],
	function (
		throbber,
		toast,
		modal,
		track,
		msg,
		lazyload,
		$,
		window
	) {
	'use strict';
	/** @private **/

	var d = window.document,
		floor = window.Math.floor,
		beforeend = 'beforeend',
		wkArtCom = d.getElementById( 'wkArtCom' ),
		loadMore = d.getElementById( 'commMore' ),
		loadPrev = d.getElementById( 'commPrev' ),
		totalPages = floor( wkArtCom.getAttribute( 'data-pages' ) ),
		currentPage = 1,
		ajaxUrl = window.wgScriptPath + '/index.php?action=ajax&rs=ArticleCommentsAjax&method=axGetComments&useskin=' +
			window.skin +
			'&article=' +
			window.wgArticleId,
		clickEvent = 'click',
		firstPage,
		commsUl = d.getElementById( 'wkComUl' ),
		postReply = msg( 'wikiamobile-article-comments-post-reply' ),
		view = msg( 'wikiamobile-article-comments-view' ),
		replies = msg( 'wikiamobile-article-comments-replies' ),
		postComm = d.getElementsByClassName( 'commFrm' )[0].cloneNode( true ),
		textAreaSel = '.commFrm textarea',
		$toc = $( '#wkTOC' );

	postComm.getElementsByClassName( 'commText' )[0].setAttribute( 'placeholder', postReply );

	function clickHandler ( event ) {
		event.preventDefault();

		var elm = this,
			forward = (elm.getAttribute( 'id' ) === 'commMore'),
			pageIndex = forward ? currentPage + 1 : currentPage - 1,
			condition = forward ? (currentPage < totalPages) : (currentPage > 1);

		if ( currentPage === 1 ) {
			firstPage = commsUl.innerHTML;
		}

		track.event( 'article-comments', track.PAGINATE, {
			label: forward ? 'next' : 'previous'
		} );

		if ( condition ) {
			elm.className += ' active';
			throbber.show( elm, {size: '30px'} );

			$.ajax( {
				url: ajaxUrl + '&page=' + floor( pageIndex ),
				dataType: 'json'
			} ).done(
				function ( result ) {
					currentPage = pageIndex;

					commsUl.innerHTML = result.text;

					elm.className = elm.className.replace( ' active', '' );
					throbber.hide( elm );

					//there's a good reason to use display instead of show/hide in the following lines
					if ( forward ? (currentPage === totalPages) : (currentPage === 1) ) {
						elm.style.display = 'none';
					}

					(forward ? loadPrev : loadMore).style.display = 'block';

					window.scrollTo( 0, wkArtCom.offsetTop );

					//load all images that might be on a comments page
					lazyload( wkArtCom.querySelectorAll( '.lazy' ) );
				}
			);
		}
	}

	function loginRequired ( ev ) {
		if ( window.wgDisableAnonymousEditing && !window.wgUserName ) {
			ev.stopPropagation();

			var target = ev.target,
				elm = target.nodeName === 'FORM' ? target : target.parentElement,
				prev = elm.previousElementSibling;

			target.blur();

			toast.show( msg( 'wikiamobile-article-comments-login-post' ), { error: true } );

			require( ['topbar'], function ( t ) {
				t.openProfile( 'comm-' + (prev ? (prev.id || 'wkComm') : elm.parentElement.id) );
				modal.close( true );
			} );

			return true;
		}
		return false;
	}

	function post ( ev ) {
		ev.preventDefault();
		ev.stopPropagation();

		if ( !loginRequired( ev ) ) {

			var form = ev.target,
				parent = form.previousElementSibling,
				parentId = parent ? parent.id : false,
				submit = form.getElementsByTagName( 'input' )[0],
				textArea = form.getElementsByClassName( 'commText' )[0],
				text = textArea.value.trim(),
				data;

			if ( text !== '' ) {
				submit.disabled = true;
				throbber.show( form, { size: '35px', center: true } );

				data = {
					action: 'ajax',
					article: window.wgArticleId,
					method: 'axPost',
					rs: 'ArticleCommentsAjax',
					title: window.wgPageName,
					wpArticleComment: text,
					useskin: 'wikiamobile'
				};

				if ( parentId ) {
					data.parentId = parentId;
				}

				$.ajax( {
					url: window.wgScript,
					data: data,
					dataType: 'json',
					type: 'POST'
				} ).done(
					function ( json ) {
						if ( !json.error && json.text ) {
							textArea.value = '';

							if ( currentPage > 1 ) {
								commsUl.innerHTML = firstPage;
								currentPage = 1;
								loadPrev.style.display = 'none';
							}

							if ( parentId ) {
								updateUI( json.text, parent );
								track.event( 'article-comments', track.SUBMIT, {
									label: 'reply'
								} );
							} else {
								commsUl.insertAdjacentHTML( 'afterbegin', json.text );
								track.event( 'article-comments', track.SUBMIT, {
									label: 'new'
								} );
							}
							d.getElementById( 'wkArtComHeader' ).setAttribute( 'data-count', json.counter );
							d.getElementsByClassName( 'comment-counter' )[0].innerText = json.counterMessage;
						} else {
							onFail();
						}
					}
				).fail(
					onFail
				).always( function () {
					submit.disabled = false;
					throbber.hide( form );
				} );
			}
		}
	}

	function onFail () {
		toast.show( msg( 'wikiamobile-article-comments-post-fail' ), { error: true } );
	}

	function updateUI ( comment, parent ) {
		var realparent = d.getElementById( parent.id ),
			rply = realparent.lastElementChild,
			cnt = floor( rply.getAttribute( 'data-replies' ) ) + 1,
			subs = realparent.getElementsByClassName( 'sub-comments' )[0],
			viewAll = rply.getElementsByClassName( 'viewAll' )[0],
			ul;

		//append reply to a original place and in modal
		if ( subs ) {
			subs.insertAdjacentHTML( beforeend, comment );
			parent.getElementsByClassName( 'sub-comments' )[0].insertAdjacentHTML( beforeend, comment );
		} else {
			ul = '<ul class=sub-comments>' + comment + '</ul>';
			realparent.insertAdjacentHTML( beforeend, ul );
			parent.insertAdjacentHTML( beforeend, ul );
		}

		//update links to open a modal
		rply.setAttribute( 'data-replies', cnt );

		if ( viewAll ) {
			viewAll.innerHTML = view + ' (' + cnt + ')';
		} else {
			rply.insertAdjacentHTML( beforeend, '<span class=viewAll>' + view + ' (1)</span>' );
		}

		//update counters
		modal.setToolbar( replies + ' (' + cnt + ')' );
	}

	function openModal ( elm, focus ) {
		var parent = elm.parentElement,
			num = floor( parent.getAttribute( 'data-replies' ) ),
			toolbar = num ? replies + ' (' + num + ')' : postReply;

		modal.open( {
			classes: 'cmnMdl',
			content: parent.parentElement.outerHTML + postComm.outerHTML,
			toolbar: toolbar,
			stopHiding: true,
			scrollable: true,
			onOpen: (function () {
				return focus ?
					/*
					 If this is reply action focus on input and scroll to it
					 otherwise scroll to top
					 */
					function ( content ) {
						var input = content.getElementsByClassName( 'commText' )[0];
						if ( input ) {
							input.scrollIntoView();
							input.focus();
						}
					} :
					function () {
						window.scrollTo( 0, 0 );
					};
			})()
		} );
	}

	//load all images that might be on a comments page
	lazyload( wkArtCom.querySelectorAll( '.lazy' ) );

	if ( totalPages > 1 && window.wgArticleId ) {
		loadMore.addEventListener( clickEvent, clickHandler, true );
		loadPrev.addEventListener( clickEvent, clickHandler, true );
	}

	$( wkArtCom )
		.on( 'click', '.viewAll', function () {
			openModal( this );
			track.event( 'article-comments', track.CLICK, {
				label: 'open'
			} );
		} )
		.on( 'click', '.cmnRpl', function ( event ) {
			if ( !loginRequired( event ) ) {
				openModal( this, true );
				track.event( 'article-comments', track.CLICK, {
					label: 'open'
				} );
			}
		} )
		.on( 'click', '.avatar', function ( event ) {
			track.event( 'article-comments', track.IMAGE_LINK, {
				label: 'avatar',
				href: this.parentElement.href
			}, event );
		} );

	$( d.body )
		.on( clickEvent, textAreaSel, function ( event ) {
			if ( !loginRequired( event ) ) {
				//scroll text area to top of the screen with small padding
				window.scrollTo( 0, $( event.target ).offset().top - 5 );
				$toc.addClass( 'hidden' );
			}
		} )
		.on( 'blur', textAreaSel, function ( event ) {
			$toc.removeClass( 'hidden' );
		} )
		.on( 'submit', '.commFrm', post );
} );
