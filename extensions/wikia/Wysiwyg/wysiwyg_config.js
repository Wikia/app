FCKConfig.FormatIndentator = '';
FCKConfig.FontFormats = 'p;h2;h3;pre' ;

var toolbarItems = ['Source','-','Undo','Redo','-','Bold','Italic','Underline','StrikeThrough','Link','Unlink','-','FontFormat','-','OrderedList','UnorderedList','Outdent','Indent','-','AddImage','Table','Tildes','InsertTemplate','FitWindow']

FCKConfig.ToolbarCanCollapse = false;

FCKConfig.StyleVersion = window.parent.wgStyleVersion;
FCKConfig.EditorAreaCSS = FCKConfig.BasePath + 'css/fck_editorarea.css';
FCKConfig.EditorAreaStyles = window.parent.stylepath + '/monobook/main.css';

FCKConfig.BodyId = 'bodyContent';
FCKConfig.BodyClass = 'fckeditor';

FCKConfig.Plugins.Add('wikitext');

if (typeof window.parent.vet_enabled != 'undefined') {
	FCKConfig.Plugins.Add('video');
	toolbarItems.push('AddVideo');
}

FCKConfig.ToolbarSets["Default"] = [ toolbarItems ];
	
FCKConfig.FillEmptyBlocks = false;
FCKConfig.FormatSource = false;
FCKConfig.FormatOutput = false;

FCKConfig.DisableObjectResizing = true;

FCKConfig.AutoDetectLanguage = false;
FCKConfig.DefaultLanguage = window.parent.wgUserLanguage;
FCKConfig.FirefoxSpellChecker = true;

FCKConfig.BackgroundBlockerColor = '#000';
FCKConfig.BackgroundBlockerOpacity = '0.6';
FCKConfig.FloatingPanelsZIndex = 1200;
