FCKConfig.FormatIndentator = '';
FCKConfig.FontFormats = 'p;h2;h3;pre' ;

FCKConfig.ToolbarSets["Default"] = [
	['Source','-','Undo','Redo','-','Bold','Italic','Underline','StrikeThrough','Link','Unlink','-','FontFormat','-','OrderedList','UnorderedList','Outdent','Indent','-','AddImage','Table','Tildes','Rule','InsertTemplate','FitWindow']
];
FCKConfig.ToolbarCanCollapse = false;

FCKConfig.StyleVersion = window.parent.wgStyleVersion;
FCKConfig.EditorAreaCSS = FCKConfig.BasePath + 'css/fck_editorarea.css';
FCKConfig.EditorAreaStyles = window.parent.stylepath + '/monobook/main.css';

FCKConfig.BodyId = 'bodyContent';
FCKConfig.BodyClass = 'fckeditor';
FCKConfig.Plugins.Add('wikitext');

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
