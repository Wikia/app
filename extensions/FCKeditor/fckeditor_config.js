/*
 * FCKeditor Extension for MediaWiki specific settings.
 */

// When using the modified image dialog you must set this variable. It must
// correspond to $wgScriptPath in LocalSettings.php.
FCKConfig.mwScriptPath = '' ;     

// Setup the editor toolbar.
FCKConfig.ToolbarSets['Wiki'] = [
	['Source'],
	['Cut','Copy','Paste',/*'PasteText','PasteWord',*/'-','Print'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['SpecialChar','Table','Image','Rule'],
	['MW_Template','MW_Special','MW_Ref','MW_Math'],
	'/',
	['FontFormat'],
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['OrderedList','UnorderedList','-','Blockquote'],
//	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink','Anchor'],
//	['TextColor','BGColor'],
	['FitWindow','-','About']
] ;

// Load the extension plugins.
FCKConfig.PluginsPath = FCKConfig.EditorPath + '../plugins/' ;
FCKConfig.Plugins.Add( 'mediawiki' ) ;

FCKConfig.ForcePasteAsPlainText = true ;
FCKConfig.FontFormats	= 'p;h1;h2;h3;h4;h5;h6;pre' ;

FCKConfig.AutoDetectLanguage	= false ;
FCKConfig.DefaultLanguage		= 'en' ;

// FCKConfig.DisableObjectResizing = true ;

FCKConfig.EditorAreaStyles = '\
.FCK__MWTemplate, .FCK__MWRef, .FCK__MWSpecial, .FCK__MWReferences, .FCK__MWNowiki, .FCK__MWIncludeonly, .FCK__MWNoinclude, .FCK__MWOnlyinclude, .FCK__MWGallery \
{ \
	border: 1px dotted #00F; \
	background-position: center center; \
	background-repeat: no-repeat; \
	vertical-align: middle; \
} \
.FCK__MWTemplate \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_template.gif); \
	width: 20px; \
	height: 15px; \
} \
.FCK__MWRef \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_ref.gif); \
	width: 18px; \
	height: 15px; \
} \
.FCK__MWSpecial \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_special.gif); \
	width: 66px; \
	height: 15px; \
} \
.FCK__MWNowiki \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_nowiki.gif); \
	width: 66px; \
	height: 15px; \
} \
.FCK__MWIncludeonly \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_includeonly.gif); \
	width: 66px; \
	height: 15px; \
} \
.FCK__MWNoinclude \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_noinclude.gif); \
	width: 66px; \
	height: 15px; \
} \
.FCK__MWGallery \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_gallery.gif); \
	width: 66px; \
	height: 15px; \
} \
.FCK__MWOnlyinclude \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_onlyinclude.gif); \
	width: 66px; \
	height: 15px; \
} \
.FCK__MWReferences \
{ \
	background-image: url(' + FCKConfig.PluginsPath + 'mediawiki/images/icon_references.gif); \
	width: 66px; \
	height: 15px; \
} \
' ;
