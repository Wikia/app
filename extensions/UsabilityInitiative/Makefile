#
# Handy makefile to combine and minify css and javascript files
#

CSS := \
	css/suggestions.css\
	css/vector.collapsibleNav.css\
	css/wikiEditor.css\
	css/wikiEditor.dialogs.css\
	css/wikiEditor.toc.css\
	css/wikiEditor.toolbar.css\
	css/wikiEditor.preview.css

PLUGINS := \
	js/usability.js\
	js/js2stopgap/ui.core.js\
	js/js2stopgap/ui.datepicker.js\
	js/js2stopgap/ui.dialog.js\
	js/js2stopgap/ui.draggable.js\
	js/js2stopgap/ui.resizable.js\
	js/js2stopgap/ui.tabs.js\
	js/plugins/jquery.async.js\
	js/plugins/jquery.autoEllipsis.js\
	js/plugins/jquery.browser.js\
	js/plugins/jquery.collapsibleTabs.js\
	js/plugins/jquery.cookie.js\
	js/plugins/jquery.delayedBind.js\
	js/plugins/jquery.namespaceSelect.js\
	js/plugins/jquery.suggestions.js\
	js/plugins/jquery.textSelection.js\
	js/plugins/jquery.wikiEditor.js\
	js/plugins/jquery.wikiEditor.dialogs.js\
	js/plugins/jquery.wikiEditor.highlight.js\
	js/plugins/jquery.wikiEditor.preview.js\
	js/plugins/jquery.wikiEditor.publish.js\
	js/plugins/jquery.wikiEditor.templateEditor.js\
	js/plugins/jquery.wikiEditor.toc.js\
	js/plugins/jquery.wikiEditor.toolbar.js

WIKIEDITOR_MODULES := \
	WikiEditor/Modules/Highlight/Highlight.js\
	WikiEditor/Modules/Preview/Preview.js\
	WikiEditor/Modules/Publish/Publish.js\
	WikiEditor/Modules/Toc/Toc.js\
	WikiEditor/Modules/Toolbar/Toolbar.js\
	WikiEditor/Modules/TemplateEditor/TemplateEditor.js

VECTOR_MODULES := \
	Vector/Modules/CollapsibleNav/CollapsibleNav.js\
	Vector/Modules/CollapsibleTabs/CollapsibleTabs.js\
	Vector/Modules/EditWarning/EditWarning.js\
	Vector/Modules/FooterCleanup/FooterCleanup.js\
	Vector/Modules/SimpleSearch/SimpleSearch.js

all: \
	css/combined.css\
	css/combined.min.css\
	js/plugins.combined.js\
	js/plugins.combined.min.js\
	WikiEditor/WikiEditor.combined.js\
	WikiEditor/WikiEditor.combined.min.js\
	Vector/Vector.combined.js\
	Vector/Vector.combined.min.js

# JavaScript Combination

js/plugins.combined.js: $(PLUGINS)
	cat $(PLUGINS) > js/plugins.combined.js

WikiEditor/WikiEditor.combined.js: $(WIKIEDITOR_MODULES)
	cat $(WIKIEDITOR_MODULES) > WikiEditor/WikiEditor.combined.js

Vector/Vector.combined.js: $(VECTOR_MODULES)
	cat $(VECTOR_MODULES) > Vector/Vector.combined.js

# JavaScript Minification

js/plugins.combined.min.js : js/plugins.combined.js jsmin 
	if [ -e ./jsmin ]; then ./jsmin < js/plugins.combined.js > js/plugins.combined.min.js;\
	else jsmin < js/plugins.combined.js > js/plugins.combined.min.js; fi

WikiEditor/WikiEditor.combined.min.js: WikiEditor/WikiEditor.combined.js
	if [ -e ./jsmin ]; then ./jsmin < WikiEditor/WikiEditor.combined.js > WikiEditor/WikiEditor.combined.min.js;\
	else jsmin < WikiEditor/WikiEditor.combined.js > WikiEditor/WikiEditor.combined.min.js; fi

Vector/Vector.combined.min.js: Vector/Vector.combined.js
	if [ -e ./jsmin ]; then ./jsmin < Vector/Vector.combined.js > Vector/Vector.combined.min.js;\
	else jsmin < Vector/Vector.combined.js > Vector/Vector.combined.min.js; fi

# CSS Combination

css/combined.css: $(CSS)
	cat $(CSS) > css/combined.css

# CSS Minification

css/combined.min.css : css/combined.css
	cat css/combined.css | sed -e 's/^[ 	]*//g; s/[ 	]*$$//g; s/\([:{;,]\) /\1/g; s/ {/{/g; s/\/\*.*\*\///g; /^$$/d'\
	> css/combined.min.css

# JSMin - For more info on JSMin, see: http://www.crockford.com/javascript/jsmin.html

jsmin:
	type -P jsmin &>/dev/null || ( wget http://www.crockford.com/javascript/jsmin.c; gcc jsmin.c -o jsmin )

# Actions

distclean: clean
	rm -rf jsmin
	rm -rf jsmin.c

clean:
	rm -f js/plugins.combined.*
	rm -f css/combined.*
