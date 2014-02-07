require( [
	'modal',
	'wikia.loader',
	'wikia.mustache',
	'jquery',
	'toast',
	'sloth',
	'lazyload',
	'JSMessages',
	'wikia.window',
	'tables',
	'track'
],
function (
	modal,
	loader,
	mustache,
	$,
	toast,
	sloth,
	lazyload,
	msg,
	window,
	tables,
	track
) {
	'use strict';

	var markup = $( '#previewTemplate' ).remove().children(),
		$previewButton = $( '#wkPreview' ),
		summaryText = '',
		textBox = document.getElementById( 'wpTextbox1' ),
		form = document.getElementsByTagName( 'form' )[0],
		summaryForm = form.querySelector( '#wpSummary' ),
		newArticleMsg = msg( 'wikiamobileeditor-on-new' ),
		wrongMsg = msg( 'wikiamobileeditor-wrong' ),
		internetMsg = msg( 'wikiamobileeditor-internet' ),
		hasOnline = window.navigator && window.navigator.onLine !== undefined,
		trackCategory = 'editor';

	//opens modal with preview container markup
	function show () {
		modal.open( {
			content: '',
			toolbar: markup[0].outerHTML,
			caption: markup[1].outerHTML,
			stopHiding: true,
			scrollable: true,
			classes: 'preview',
			onOpen: function ( content ) {
				modal.addClass( 'loading' );

				var summaryInput = document.getElementById( 'wkSummary' );

				//Restore previous summary
				if ( summaryText ) {
					summaryInput.value = summaryText;
				}

				$( '#wkContinueEditing' ).on( 'click', function () {
					summaryText = summaryInput.value;
					modal.close();

					track.event( trackCategory, track.CLICK, {
						label: 'continue'
					});
				} );

				$( '#wkSave' ).attr( 'disabled', true );

				render( content );
			}
		} );

		track.event( trackCategory, track.CLICK, {
			label: 'preview'
		});
	}

	function isOnline () {
		return hasOnline ? window.navigator.onLine : true;
	}

	//displays loader and preview after fetching it from parser
	function render ( content ) {
		$.ajax( {
			url: 'index.php',
			type: 'post',
			data: {
				action: 'ajax',
				rs: 'EditPageLayoutAjax',
				skin: 'wikiamobile',
				type: 'partial',
				title: window.wgTitle,
				page: 'SpecialCustomEditPage',
				method: 'preview',
				content: textBox.value
			}
		} ).done( function ( resp ) {
			if ( resp && resp.html ) {
				content.innerHTML = resp.html;

				var scroller = new window.IScroll(
					'#wkMdlCnt', {
						click: false,
						scrollY: true,
						scrollX: false
					} );

				tables.process( $( content ).find( 'table:not(.toc):not(.infobox)' ) );

				sloth( {
					on: document.getElementsByClassName( 'lazy' ),
					threshold: 100,
					callback: lazyload
				} );

				scroller.on( 'scrollEnd', function () {
					//using IScroll and sloth is tricky so we need to help sloth
					window.scrollY = -this.y;

					sloth();
					this.refresh();
				} );

				$( '#wkSave' ).attr( 'disabled', false ).on( 'click', publish );
			} else {
				toast.show( wrongMsg );
			}
		} ).fail(function () {
			toast.show( wrongMsg + ( isOnline() ? '' : ' ' + internetMsg ), { error: true } );
		} ).always( function () {
			modal.removeClass( 'loading' );
		} );
	}

	function publish () {
		//currently wikiamobile displayes this in a different place so we need to copy the value of summary
		summaryForm.value = document.getElementById( 'wkSummary' ).value;

		if ( isOnline() || window.confirm( internetMsg ) ) {
			modal.addClass( 'loading' );
			$( '#wkMdlTlBar' ).find( 'span' ).text( msg( 'wikiamobileeditor-saving' ) );

			form.submit();

			track.event( trackCategory, track.SUBMIT, {
				label: 'publish'
			});
		}
	}

	if ( window.wgArticleId === 0 ) {
		toast.show( newArticleMsg );

		track.event( trackCategory, track.IMPRESSION, {
			label: 'new-article'
		});
	}

	$previewButton.on( 'click', function ( event ) {
		event.preventDefault();

		show();
	} );

	$( '#wkMobileCancel' ).on( 'click', function( event ){
		track.event( trackCategory, track.CLICK, {
			label: 'cancel',
			href: this.href,
			event: event
		});
	});
} );
