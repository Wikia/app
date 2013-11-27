require( ['modal', 'wikia.loader', 'wikia.mustache', 'jquery', 'toast'], function ( modal, loader, mustache, $, toast ) {
	'use strict';

    var markup,
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

	//loads container markup for holding preview in modal
	function load () {
		if ( !markup ) {
			loader( {
				type: loader.MULTI,
				resources: {
					mustache: '/extensions/wikia/WikiaMobileEditor/templates/WikiaMobileEditorController_preview.mustache'
				}
			} ).done( function ( resp ) {
				markup = mustache.render( resp.mustache[0] );
				show( markup );
			} );
		}
		else {
			show( markup );
		}
	}

	//opens modal with preview container markup
	function show ( content ) {
		modal.open();
		modal.setContent( content );
		previewWindow = document.getElementById( 'wpPreviewWindow' );
		saveButton = document.getElementById( 'wpSave' );
		continueButton = document.getElementById( 'wpContinueEditing' );
		summary = document.getElementById( 'wpSummary' );

		saveButton.addEventListener( 'click', function () {
			publish();
		} );

		continueButton.addEventListener( 'click', function () {
			modal.close();
		} );
	}

	//closes modal
	function hide(){
		modal.close();
	}
	
    //displays loader and preview after fetching it from parser
    function render(){
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
                content: textBox.value},
            success: function( resp ) {
				if ( previewWindow ) {
					previewWindow.innerHTML = resp.html;

					previewWindow.addEventListener('click', function( event ){
						var t = event.target;

						if ( t.nodeName === 'A' ) {
							t.setAttribute( 'target', '_blank' );
						}

					})
				}
				
                if(markup) loading = false;
            }
        });
    }

    function publish(){
        var form = document.getElementsByTagName('form')[0],
            summaryField = '<input type=\'text\' name=\'wpSummary\' id=\'wpSum\' value=\'' +
            summary.value + '\'>',
            saveField = '<input type=\'submit\' value=\'publish\' id=\'wpSave\' name=\'wpSave\'>';
        form.innerHTML = form.innerHTML + summaryField + saveField;
        debugger;
        form.submit();
        form.removeChild(document.getElementById('wpSum'));
        form.removeChild(document.getElementById('wpSave'));
    }


	if(document.getElementsByClassName('mw-newarticletextanon')[0]){
		toast.show( newArticle );
	}
	previewButton = document.getElementById( 'wpPreview' );
	textBox = document.getElementById( 'wpTextbox1' );

	previewButton.addEventListener( 'click', function(){
		//reset preview markup and render new from edited wikitext
		event.preventDefault();
		if(!loading){
			loading = true;
			load();
			render();
		}
	} );
} );
