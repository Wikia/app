require( ['modal', 'wikia.loader', 'wikia.mustache', 'jquery', 'toast', 'sloth', 'lazyload'],
	function ( modal, loader, mustache, $, toast, sloth, lazyload ) {
	'use strict';

    var markup = $( '#previewTemplate' ).remove().children(),
        parsed,
        previewWindow,
        wikitext,
		loading,
        previewButton,
        continueButton,
		saveButton,
        summary,
        textBox,
		newArticle = 'You are starting a brand new article (section).';

	//opens modal with preview container markup
	function show () {
		modal.open({
			content: '',
			toolbar: markup[0].outerHTML,
			caption: markup[1].outerHTML,
			stopHiding: true,
			scrollable: true,
			classes: 'preview',
			onOpen: function( content ){
				modal.addClass( 'loading' );

				render( content );
			}
		});
	}

	//closes modal
	function hide(){
		modal.close();
	}
	
    //displays loader and preview after fetching it from parser
    function render( content ){
        $.ajax({
            url: 'index.php',
            type: 'post',
            data: {
                action: 'ajax',
                rs: 'EditPageLayoutAjax',
                title: wgTitle,
                skin: 'wikiamobile',
                type: 'partial',
                page: 'SpecialCustomEditPage',
                method: 'preview',
                mode: 'wysiwyg',
                content: textBox.value
			},
            success: function( resp ) {
				content.innerHTML = resp.html;

//				content.addEventListener('click', function( event ){
//					var t = event.target;
//
//					if ( t.nodeName === 'A' ) {
//						t.setAttribute( 'target', '_blank' );
//					}
//				});

				sloth( {
					on: document.getElementsByClassName( 'lazy' ),
					threshold: 300,
					callback: lazyload
				} );

				summary = document.getElementById( 'wkSummary' );

				$( '#wkSave' ).on( 'click', publish );
				$( '#wkContinueEditing' ).on( 'click', modal.close );

				modal.removeClass( 'loading' );
            }
        });
    }

    function publish(){
        var form = document.getElementsByTagName('form')[0];

		//form.innerHTML += '<input type="hidden" name="wpSummary" value="' + summary.value + '">';
		//form.querySelector( 'input[name=wpSummary]' ).value = summary.value;

        form.submit();
    }

	document.getElementsByTagName('form')[0].addEventListener('submit', function( event ){
		//event.preventDefault();

	});

	if(document.getElementsByClassName('mw-newarticletextanon')[0]){
		toast.show( newArticle );
	}

	previewButton = document.getElementById( 'wkPreview' );
	textBox = document.getElementById( 'wpTextbox1' );

	previewButton.addEventListener( 'click', function(){
		//reset preview markup and render new from edited wikitext
		event.preventDefault();

		show();
	} );
} );
