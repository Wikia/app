// Remove the mwSetupToolbar onload hook to avoid a JavaScript error with FF.
if ( window.removeEventListener )
        window.removeEventListener( 'load', mwSetupToolbar, false ) ;
else if ( window.detachEvent )
        window.detachEvent( 'onload', mwSetupToolbar ) ;

mwSetupToolbar = function() { return false ; } ;

function onLoadFCKeditor()
{
        var oldTextbox = document.getElementById('wpTextbox1') ;
        if ( oldTextbox )
        {
                var height = wgFCKEditorHeight ;

                if ( height == 0 )
                {
                        // Get the window (inner) size.
                        var height = window.innerHeight || ( document.documentElement && document.documentElement.clientHeight ) || 550 ;

                        // Reduce the height to the offset of the toolbar.
                        var offset = document.getElementById('wikiPreview') || document.getElementById('toolbar') ;
                        while ( offset )
                        {
                                height -= offset.offsetTop ;
                                offset = offset.offsetParent ;
                        }

                        height -= 20 ;
                }

                height = ( !height || height < 300 ) ? 300 : height ;

                var oFCKeditor = new FCKeditor('wpTextbox1') ;
                oFCKeditor.Domain = wgFCKEditorDomain ;
                if (oFCKeditor.Domain != '') {
                        document.domain = oFCKeditor.Domain ;
                }

                oFCKeditor.BasePath = wgFCKEditorDir+ '/' ;
                oFCKeditor.Config['CustomConfigurationsPath'] = wgFCKEditorExtDir + '/fckeditor_config.js?' ;
                oFCKeditor.Config['EditorAreaCSS'] = wgFCKEditorExtDir + '/css/fckeditor.css?' + wgStyleVersion ;
                oFCKeditor.Height = height ;
                oFCKeditor.ToolbarSet = wgFCKEditorToolbarSet ;
                oFCKeditor.ReplaceTextarea() ;

                document.getElementById('toolbar').style.cssText = 'display:none;' ;

                var edittools_markup = document.getElementById ('editpage-specialchars') ;
                if (edittools_markup) {
                        edittools_markup.style.display = 'none' ;
                }

                var needToConfirm = true ;

                function confirmExit(){
                        if (needToConfirm){
                                return "You have attempted to leave this page. If you have made any changes to the fields without clicking the Save button, your changes will be lost. Are you sure you want to exit this page?";
                        }
                }

                FCKeditor_OnComplete = function (FCKinstance)
                {
                        if ('source' == document.getElementById ("FCKmode").value) {
                                FCKinstance.SwitchEditMode () ;
                        }

                        insertFckTags = function (tag) {
                                if (FCKinstance.EditMode == FCK_EDITMODE_SOURCE) {
                                        insertTags (tag, '', '') ;
                                } else {
					FCKinstance.InsertImage (tag) ;	
                                        //todo parse and construct link from this markup
                                }
                        }

                        var saveButton = document.getElementById ('wpSave') ;
                        var previewButton = document.getElementById ('wpPreview') ;
                        var diffButton = document.getElementById ('wpDiff') ;
                        var upperSave = document.getElementById ('wpUpperFCKSave') ;
                        var upperPreview = document.getElementById ('wpUpperFCKPreview') ;
                        var upperCancel = document.getElementById ('wpUpperFCKCancel') ;

                        if (FCKinstance.isInedible ()) {
                                var fckIframe = document.getElementById ("wpTextbox1___Frame")  ;
                                if (fckIframe) {
                                        fckIframe.parentNode.removeChild (fckIframe) ;

                                        var normalArea = document.getElementById ("wpTextbox1")  ;
                                        var backupArea = document.getElementById ("wpTextbox1_Backup") ;
                                        normalArea.value = backupArea.value ;
                                        backupArea.parentNode.removeChild (backupArea) ;

                                        var normalToolbar = document.getElementById ("toolbar")  ;

                                        normalArea.style.display = 'inline' ;
                                        normalToolbar.style.display = 'block' ;
                                }
                        } else {
                                window.onbeforeunload = confirmExit ;
                                saveButton.onclick = previewButton.onclick = diffButton.onclick = upperCancel.onclick = function () {needToConfirm = false ;} ;
                                upperSave.onclick = function () {saveButton.click () ;} ;
                                upperPreview.onclick = function () {previewButton.click () ;} ;
                        }
                        document.getElementById ('wpSummaryLabel').style.display = 'inline' ;
                        saveButton.parentNode.parentNode.style.display = 'inline' ;
                } 
                insertTags = function (tagOpen, tagClose, sampleText)
                {
                        var txtarea;
                        var isFCK = false ;
                        if ( !(typeof(FCK) == "undefined") && !(typeof(FCK.EditingArea) == "undefined") )
                        {
                                txtarea = FCK.EditingArea.Textarea ;
                                isFCK = true ;
                        }
                        else if (document.editform)
                        {
                                FCKarea = document.getElementById( oFCKeditor.InstanceName ) ;
                                if ( FCKarea.style.display == 'none' )
                                {
                                        SRCiframe = document.getElementById ('wpTextbox1___Frame') ;
                                        if ( SRCiframe )
                                        {
                                                isFCK = true ;
                                                if (window.frames["wpTextbox1___Frame"])
                                                        SRCdoc = window.frames["wpTextbox1___Frame"].document ;
                                                else
                                                        SRCdoc = SRCiframe.contentDocument ;

                                                var SRCarea = SRCdoc.getElementById ('xEditingArea').firstChild ;

                                                if (SRCarea)
                                                        txtarea = SRCarea ;
                                                else
                                                        return false ;

                                        }
                                        else
                                        {
                                                return false ;
                                        }
                                }
                                else
                                {
                                        txtarea = document.editform.wpTextbox1 ;
                                }
                        }
                       else
                        {
                                var areas = document.getElementsByTagName( 'textarea' ) ;
                                txtarea = areas[0] ;
                        }

                        var selText, isSample = false ;

                        if ( document.selection  && document.selection.createRange )
                        {
                                if (isFCK) {
                                        var inDocument = window.frames["wpTextbox1___Frame"].document ;
                                } else {
                                        var inDocument = document ;
                                }
                                if ( inDocument.documentElement && inDocument.documentElement.scrollTop )
                                        var winScroll = inDocument.documentElement.scrollTop ;
                                else if ( document.body )
                                        var winScroll = inDocument.body.scrollTop ;

                                txtarea.focus() ;
                                var range = inDocument.selection.createRange() ;
                                selText = range.text ;
                                if (!selText) {
                                        selText = sampleText;
                                        isSample = true;
                                } else if (selText.charAt(selText.length - 1) == ' ') {
                                        selText = selText.substring(0, selText.length - 1);
                                        tagClose += ' '
                                }

                                range.text = tagOpen + selText + tagClose ;
                                if ( isSample && range.moveStart )
                                {
                                        if (window.opera)
                                                tagClose = tagClose.replace(/\\n/g,'') ;
                                        range.moveStart('character', - tagClose.length - selText.length) ;
                                        range.moveEnd('character', - tagClose.length) ;
                                }
                                range.select();
                                if ( inDocument.documentElement && inDocument.documentElement.scrollTop )
                                        inDocument.documentElement.scrollTop = winScroll ;
                                else if ( document.body )
                                        inDocument.body.scrollTop = winScroll ;

                        }
                        else if ( txtarea.selectionStart || txtarea.selectionStart == '0' )
                        {

                                var textScroll = txtarea.scrollTop ;
                                txtarea.focus() ;
                                var startPos = txtarea.selectionStart ;
                                var endPos = txtarea.selectionEnd ;
                                selText = txtarea.value.substring( startPos, endPos ) ;

                                if (!selText)
                                {
                                        selText = sampleText ;
                                        isSample = true ;
                                }
                                else if (selText.charAt(selText.length - 1) == ' ')
                                {
                                        selText = selText.substring(0, selText.length - 1) ;
                                        tagClose += ' ' ;
                                }
                                txtarea.value = txtarea.value.substring(0, startPos) + tagOpen + selText + tagClose +
                                                                txtarea.value.substring(endPos, txtarea.value.length) ;
                                if (isSample)
                                {
                                        txtarea.selectionStart = startPos + tagOpen.length ;
                                        txtarea.selectionEnd = startPos + tagOpen.length + selText.length ;
                                }
                                else
                                {
                                        txtarea.selectionStart = startPos + tagOpen.length + selText.length + tagClose.length ;
                                        txtarea.selectionEnd = txtarea.selectionStart;
                                }
                                txtarea.scrollTop = textScroll;
                        }
                }
        }
}
addOnloadHook( onLoadFCKeditor ) ;

