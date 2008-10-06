FCKConfig.FormatIndentator = '';
FCKConfig.FontFormats = 'p;h2;h3;pre' ;

FCKConfig.ToolbarSets["Default"] = [
	['Source','-','Undo','Redo','-','Bold','Italic','Underline','StrikeThrough','Link','Unlink','-','FontFormat','-','OrderedList','UnorderedList','Outdent','Indent','Table','Rule','-','Find','Replace','-','Cut','Copy','Paste','PasteText']
];

FCKConfig.StyleVersion = window.parent.wgStyleVersion;
FCKConfig.EditorAreaCSS = FCKConfig.BasePath + 'css/fck_editorarea.css';
FCKConfig.EditorAreaStyles = window.parent.stylepath + '/monobook/main.css';

FCKConfig.BodyId = 'fckEditor';
FCKConfig.Plugins.Add('wikitext');

FCKConfig.FillEmptyBlocks = false;
FCKConfig.IgnoreEmptyParagraphValue = true;
FCKConfig.FormatSource = false;
FCKConfig.FormatOutput = false;

FCKConfig.AutoDetectLanguage = false;
FCKConfig.DefaultLanguage = window.parent.wgUserLanguage;
