FCKConfig.FormatIndentator = '';
FCKConfig.FontFormats = 'p;h2;h3;pre' ;

var toolbarItems = ['Source','-','Undo','Redo','-','Bold','Italic','Underline','StrikeThrough','Link','Unlink','-','FontFormat','-','OrderedList','UnorderedList','Outdent','Indent','-','AddImage','Table','Tildes','InsertTemplate','FitWindow']

FCKConfig.ToolbarCanCollapse = false;

FCKConfig.StyleVersion = window.parent.wgStyleVersion;
FCKConfig.i18nRequest = window.parent.wgServer + window.parent.wgScript + '?action=ajax&rs=WysiwygGetFCKi18n&revID=' + window.parent.wgMWrevId;
FCKConfig.EditorAreaCSS = FCKConfig.BasePath + 'css/fck_editorarea.css';
FCKConfig.EditorAreaStyles = window.parent.stylepath + '/monobook/main.css';

FCKConfig.BodyId = 'bodyContent';
FCKConfig.BodyClass = 'fckeditor';

//
// load plugins
//

// main wikia plugin
FCKConfig.Plugins.Add('wikitext');

// video embed tool
FCKConfig.Plugins.Add('video');
toolbarItems.splice(20, 0, 'AddVideo');

// new toolbar
toolbarItems = window.parent.wysiwygToolbarItems;
FCKConfig.Plugins.Add('toolbar');

FCKConfig.ToolbarSets["Default"] = [ toolbarItems ];

// configuration
// @see http://docs.fckeditor.net/FCKeditor_2.x/Developers_Guide/Configuration/Configuration_Options
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

// handle numeric HTML entities (&#91; -> [)
//FCKConfig.AdditionalNumericEntities = "'|\\[|\\]";
FCKConfig.ProcessHTMLEntities = false; // RT #18269
