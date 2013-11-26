define( 'preview', ['modal', 'wikia.loader', 'wikia.mustache'], function(modal, loader, mustache){

    var markup,
        placeholder = '<span class=\'preview-loader\'>waiting for preview</span>',
        parsed,
        previewWindow,
        wikitext,
        previewButton,
        continueButton,
        textBox;

    //loads container markup for holding preview in modal
    function load(){
        if(!markup){
            loader({
                type: loader.MULTI,
                resources: {
                    mustache: '/extensions/wikia/WikiaMobileEditor/templates/WikiaMobileEditorController_preview.mustache'
                }
            }).done(function(resp){
                    markup = mustache.render(resp.mustache[0]);
                    show( markup );
                });
        }
        else{
            show( markup );
        }
    }

    //opens modal with preview container markup
    function show( content ){
        modal.open();
        modal.setContent(content);
        previewWindow = document.getElementById('wpPreviewWindow');
        saveButton = document.getElementById('wpSave');
        continueButton = document.getElementById('wpContinueEditing');
        saveButton.addEventListener('click', function(){
            //submit attempt
        });
        continueButton.addEventListener('click', function(){
            modal.close();
        });
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
                title: 'Serenity',
                skin: 'wikiamobile',
                type: 'partial',
                section: '3',
                page: 'SpecialCustomEditPage',
                method: 'preview',
                mode: 'wysiwyg',
                content: textBox.value},
            success: function( resp ) {
                parsed = resp.html;
                function showMarkup( myhtml ){
                    if(previewWindow){
                        previewWindow.innerHTML = myhtml;
                    }
                    else{
                        setTimeout(function(){showMarkup(myhtml);}, 50);
                    }
                }
                showMarkup(parsed);
            }
        });
    }

    function init(){
        previewButton = document.getElementById( 'wpPreview' );
        textBox = document.getElementById( 'wpTextbox1' );
        previewButton.addEventListener( 'click', function(){
            //reset preview markup and render new from edited wikitext
            event.preventDefault();
            load();
            render();
        } );
    }

    return{
        init : init
    }

} );

document.addEventListener('DOMContentLoaded', function(){
   require(['preview'], function( preview ){
       preview.init();
   });
});
