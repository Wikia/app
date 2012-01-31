(function(){

	window.PageLayoutBuilder = window.PageLayoutBuilder || {};

	var PLB = window.PageLayoutBuilder;

	$.extend(PLB,{
		Util: {},
		HTML_PARAM_TYPE: 'data-plb-type',
		PARAM_TYPE: '__plb_type',
		PARAM_PREFIX: '__plb_param_',
		PARAM_ID: '__plb_param_id',
		PARAM_CAPTION: '__plb_param_caption',
		PARAM_ID_RAW: 'id',
		PARAM_CAPTION_RAW: 'caption',
		Data: {},
		Library: {},
		Lang: {},
		rteReadyDelay: 1000,
		nextId: 1,
		nextWidgetId: 1000
	});

	/*
	 * LIBRARY entries:
	 *   - editorHtml - HTML for properties editor form
	 *   - menuItemHtml - HTML for "Add element" menu item
	 *   - listItemHtml - HTML for entry in list of widgets
	 *   - templateHtml - HTML for new widget in RTE
	 *   - attributes - list of allowed attributes and its default values
	 *   - requiredAttributes - list of required attributes
	 */

	PLB.Widget = $.createClass(Object,{

		ed: null,
		el: null,

		type: null,
		md: null,

		onSave: null,
		onDismiss: null,

		constructor: function( editor, el ) {
			PLB.Widget.superclass.constructor.call(this);
			this.ed = editor;
			this.el = $(el);
			this.type = this.el.attr(PLB.HTML_PARAM_TYPE);
			if ( !this.type ) {
				this.type = PLB.Widget.getType(el);
				this.el.attr(PLB.HTML_PARAM_TYPE,this.type);
			}
			this.md = PLB.Library[this.type];
		},

		getElement : function () {
			return this.el;
		},

		getType : function () {
			return this.el.attr(PLB.HTML_PARAM_TYPE);
		},

		getId : function () {
			var data = this.el.getData() || {};
			return data[PLB.PARAM_ID];
		},

		setId : function (id) {
			this.el.setData(PLB.PARAM_ID,id);
			$().log(this.el[0],'PLB - assigning ID '+id);
		},

		getCaption : function () {
			var data = this.el.getData() || {};
			return data[PLB.PARAM_CAPTION];
		},

		getProperties : function () {
			var type = this.getType();
			var list = PLB.Library[type].attributes;
			var props = {};
			var data = this.el.getData() || {};
			for (var i in list) {
				props[i] = data[PLB.PARAM_PREFIX+i];
			}
			return props;
		},

		setProperties : function ( props ) {
			var newCaption;
			var type = this.getType(this.el);
			var list = PLB.Library[type].attributes;
			for (var i in list) {
				if (typeof props[i] != 'undefined') {
					this.el.setData(PLB.PARAM_PREFIX+i,props[i]);
				}
			}
			if (props[PLB.PARAM_CAPTION_RAW]) {
				$('.plb-rte-widget-caption',this.el).text(props[PLB.PARAM_CAPTION_RAW]);
//				this.el.text(props[PLB.PARAM_CAPTION_RAW]);
			}
			this.extSetProperties( props );
		},

		setAge : function ( value ) {
			this.el.attr('data-plb-paste-age',value);
		},

		getAge : function () {
			var v = parseInt(this.el.attr('data-plb-paste-age'));
			return isNaN(v) ? 0 : v;
		},

		edit : function () {
			if (this.editing) {
				return;
			}

			$().log("edit", "PLB");
			var type = this.getType();
			var values = this.getProperties();

			this.ed.fire('widgetbeforeedit',this,type,values);

			this.editing = true;
			var pe = PLB.PropertyEditor.create(type,values);
			pe.on('save',$.proxy(this.onEditorSave,this));
			pe.on('dismiss',$.proxy(this.onEditorDismiss,this));
			pe.show();
		},

		remove: function () {
			this.el.remove();
		},

		onEditorSave : function ( pe ) {
			var v = pe.getValues();
			this.ed.fire('widgetbeforechange',this,this.getType(),v);
			this.setProperties(v);
			this.editing = false;
			this.ed.fire('widgetchanged',this,this.getType(),v);
			this.ed.fire('widgetafteredit',this,this.getType(),v);
		},

		onEditorDismiss : function ( pe ) {
			this.editing = false;
			this.ed.fire('widgetafteredit',this,this.getType(),this.getProperties());
		},

		extSetProperties: function () {}
	});

	PLB.Widgets = {};

	PLB.Widgets['plb_image'] = $.createClass(PLB.Widget,{

		constructor: function() {
			PLB.Widgets['plb_image'].superclass.constructor.apply(this,arguments);
		},

		extSetProperties: function ( props ) {
			/* align */
			if (typeof props['align'] != 'undefined') {
				this.el
					.removeClass('plb-rte-widget-align-left plb-rte-widget-align-center plb-rte-widget-align-right')
					.addClass('plb-rte-widget-align-'+props['align']);
			}
			/* width */
			var width = props['size'] || this.md.attributes['size'];
			this.el.css('width',width+'px');
			$('img',this.el).css('width',width+'px');
			/* caption */
			if (typeof props['caption'] != 'undefined') {
				$('img',this.el).attr('alt',props['caption']);
			}
		}

	});

	PLB.Widgets['plb_gallery'] = PLB.Widgets['plb_image'];

	PLB.Widget.getType = function ( el ) {
		el = $(el);
		return el.attr(PLB.HTML_PARAM_TYPE) || el.getData()[PLB.PARAM_TYPE];
	};

	PLB.Widget.create = function ( editor, el ) {
		var type = PLB.Widget.getType(el);
		if (typeof PLB.Widgets[type] == 'undefined') {
			PLB.Widgets[type] = PLB.Widget;
		}
		return new PLB.Widgets[type](editor,el);
	};


	PLB.RTEInstance = $.createClass(Observable,{

		instance: null,
		rte: null,

		document: null,
		body: null,
		rawBody: null,

		onRTEDocumentCallbacks: null,
		modeReadyFired: false,

		constructor: function(instance) {
			PLB.RTEInstance.superclass.constructor.apply(this);

			// RTE is a signleton
			GlobalTriggers.on('rteready',$.proxy(this.onRTEReady,this));
			GlobalTriggers.on('rterequestcss',$.proxy(this.onRTERequestCSS,this));

			// Fix wgAction
			window.wgAction = 'edit';
		},

		getBody: function( fresh ) {
			var rawBody = this.instance && this.instance.document && this.instance.document.$ && this.instance.document.$.body;
			if (rawBody != this.rawBody) {
				this.rawBody = rawBody;
				this.body = this.rawBody ? $(this.rawBody) : null;
			}
			return this.body;
		},

		getRTE: function() {
			return this.rte;
		},

		getInstance: function() {
			return this.instance;
		},

		getSidebar: function() {
			return $('#cke_contents_wpTextbox1_sidebar');
		},

		insertElement: function () {
			/*
			var args = arguments;
			var rte = this.rte;
			Timer.once($.proxy(function(){
				rte.tools.insertElement.apply(rte.tools,args);
			},this),500);
			*/
			this.rte.tools.insertElement.apply(this.rte.tools,arguments);
		},

		isFullWysiwyg: function() {
			var s;
			return this.instance && (s=this.instance.getSelection()) && s.getNative();
		},

		onRTEReady: function(instance) {
			this.rte = RTE;
			this.instance = instance;
			this.instance.on('key',$.proxy(this.onRTEKey,this));
			this.instance.on('wysiwygModeReady',$.proxy(this.onRTEWysiwygModeReady,this));
			this.instance.on('mode',$.proxy(this.onRTEModeSwitched,this));
			this.instance.on('beforeCommandExec',$.proxy(this.onRTEBeforeCommandExec,this));
			this.instance.on('afterCommandExec',$.proxy(this.onRTEAfterCommandExec,this));
			this.instance.on('beforeInsertContent',$.proxy(this.onRTEBeforeInsertContent,this));
			this.instance.on('afterInsertContent',$.proxy(this.onRTEAfterInsertContent,this));
			this.instance.on('beforeCreateUndoSnapshot',$.proxy(this.onRTEBeforeCreateUndoSnapshot,this));
			this.instance.on('afterCreateUndoSnapshot',$.proxy(this.onRTEAfterCreateUndoSnapshot,this));
			this.instance.on('afterPaste', this.onRTEEventProxy(this ,'afterpaste')  );
			this.instance.on('droppedElements', $.proxy(this.onRTEDroppedElements,this));
			this.instance.on('selectionChange', $.proxy(this.onRTESelectionChange,this));
			this.instance.on('droppedElements', $.proxy(this.onRTEDroppedElements,this));
			this.instance.on('readOnlySelection', $.proxy(this.onRTEReadOnlySelection,this));
			this.fire('ready',this);
		},

		onRTEReadOnlySelection: function() {
			$.showModal( '', PageLayoutBuilder.Lang["plb-editor-read-only-selection-info"], { width: 500, showCloseButton: true } );
		},

		onRTEWysiwygModeReady: function () {
			if (!this.modeReadyFired) {
				this.modeReadyFired = true;
				this.fire('modeready',this,this.instance.mode);
			}

			if (this.onRTEDocumentCallbacks == null) {
				this.onRTEDocumentCallbacks = {};
				this.onRTEDocumentCallbacks['applyStyle'] = { type : "document", "callback": $.proxy(this.onRTEBeforeApplyStyle,this) };
				this.onRTEDocumentCallbacks['afterApplyStyle'] = { type : "document", "callback": $.proxy(this.onRTEAfterApplyStyle,this) };
				this.onRTEDocumentCallbacks['beforepaste'] = { type : "body", "callback":  this.onRTEEventProxy(this ,'beforepaste') };
			}

			this.document = this.instance.document;
			this.body = this.rte.getEditor();

			var target = null;
			for( var i in this.onRTEDocumentCallbacks ) {
				if(this.onRTEDocumentCallbacks[i].type == "document") {
					target = this.document;
				}

				if(this.onRTEDocumentCallbacks[i].type == "body") {
					target = this.document.getBody();
				}

				target.removeListener(i, this.onRTEDocumentCallbacks[i].callback);
				target.on(i, this.onRTEDocumentCallbacks[i].callback);
			}

			//this.instance.focus();
			this.fire('rebind',this);
		},

		onRTEEventProxy : function(self, eventname) {
			return function(event) {
				self.fire(eventname, self, event.data ,event);
			};
		},

		onRTEBeforeApplyStyle: function( event ) {
			this.fire('beforestyle',this,event.data,event);
		},

		onRTEAfterApplyStyle: function( event ) {
			this.fire('afterstyle',this,event.data,event);
		},

		onRTEBeforeCommandExec: function( event ) {
//			$().log(event,'RTE-before-command-exec');
			this.fire('beforecommand',this,event.data,event);
		},

		onRTEAfterCommandExec: function( event ) {
//			$().log(event,'RTE-after-command-exec');
			this.fire('aftercommand',this,event.data,event);
		},

		onRTEBeforeInsertContent: function( event ) {
//			$().log(event,'RTE-before-insert');
			this.fire('beforecommand',this,event.data,event);
		},

		onRTEAfterInsertContent: function( event ) {
//			$().log(event,'RTE-after-insert');
			this.fire('aftercommand',this,event.data,event);
		},

		onRTEBeforeCreateUndoSnapshot: function( event ) {
			this.fire('beforesnapshot',this,event.data,event);
		},

		onRTEAfterCreateUndoSnapshot: function( event ) {
			this.fire('aftersnapshot',this,event.data,event);
		},

		onRTEDroppedElements: function( event ) {
			this.fire('droppedelements',this,event.data,event);
		},

		onRTERequestCSS: function(css) {
			this.fire('requestcss',this,css);
		},

		onRTEModeSwitched: function() {
			this.modeReadyFired = false;
			this.fire('modeswitch',this,this.instance.mode);
		},

		onRTESelectionChange: function( event ) {
			this.fire('selectionchange',this,event.data.event);
		},

		onRTEDroppedElements: function( event ) {
			this.fire('droppedelements',this,event.data,event);
		},

		onRTEKey: function( event ) {
			this.fire('key',this,event.data,event);
		}

	});

	PLB.Editor = $.createClass(Observable,{

		id: null,
		rte: null,

		isRTEReady: false,
		isDataReady: false,

		sidebar: null,

		adding: null,

		placeholders: null,
		pastedage: 1,

		nextWidgetId: 1,
		usedWidgetIds: null,

		// Create the editor object
		constructor: function () {
			PLB.Editor.superclass.constructor.call(this);

			// Generate unique ID
			this.id = PLB.nextId++;
			this.usedWidgetIds = {};

			this.on({
				widgetbeforechange: this.onWidgetBeforeChange,
				widgetchanged: this.onWidgetChanged,
				widgetafteredit: this.onWidgetAfterEdit,
				scope: this
			});

			// RTE is a singleton
			this.rte = new PLB.RTEInstance();
			this.rte.bind({
				ready: this.onRTEReady,
				rebind: this.onRTERebind,
				requestcss: this.onRTERequestCSS,
				modeswitch: this.onRTEModeSwitch,
				/*
				beforestyle: this.insertPlaceholders,
				afterstyle: this.replacePlaceholders,
				beforecommand: this.insertPlaceholders,
				aftercommand: this.replacePlaceholders,
				beforesnapshot: this.onRTEBeforeCreateUndoSnapshot,
				aftersnapshot: this.onRTEAfterCreateUndoSnapshot,
				*/

				afterstyle: this.onContentChange,
				aftercommand: this.onContentChange,

				beforepaste: this.onRTEBeforePaste,
				afterpaste: this.onRTEAfterPaste,

				droppedelements: this.onRTEDroppedElements,

				selectionchange: this.onRTESelectionChange,

				key: this.onRTEKey,

				scope: this
			});

			// Fetch PLB editor data through Ajax call
			var dataLoadedCallback = $.proxy(this.onDataLoaded,this);
			$(function(){
				$("body").bind('RTE_beforeToolbarRender', function(e, config) {
					config[0] = {
							name: PageLayoutBuilder.Lang["plb-editor-toolbar-formatting"],
							data: [
							{
									msg: '<span class="plbtoolbar" >' + PageLayoutBuilder.Lang["plb-editor-toolbar-caption"] + '</span>',
									groups: [
									         ['Plbelement']
									]
							},
							{
								msg: 'textAppearance',
								groups: [
									['Format'],
									['Bold','Italic','Underline','Strike'],
									['BulletedList','NumberedList'],
									['Link','Unlink'],
									['Outdent','Indent'],
									['JustifyLeft','JustifyCenter','JustifyRight']
								]
							},
							{
								msg: 'controls',
								groups: [
									['Undo','Redo'],
									(window.skin == 'oasis' ? false : ['Widescreen']), // temp hack
									['Source']
								]
							}
						]};
					config[1] = {
							name: PageLayoutBuilder.Lang["plb-editor-toolbar-static"],
							data: [
							{
								msg: 'insert',
								groups: [
									['Image', 'Gallery', 'Video'],
									['Table'],
									['Template'],
									['Signature']
								]
							},
							{
								msg: 'textAppearance',
								groups: [
									['Bold','Italic','Underline','Strike'],
									['JustifyLeft','JustifyCenter','JustifyRight']
								]
							}
						]};
				});

				/*
				time = new Date();
				$.getScript(window.wgScript + '?action=ajax&rs=PageLayoutBuilderEditor::getPLBEditorData&uselang=' + window.wgUserLanguage + '&cb=' + time.getTime(),
						dataLoadedCallback);
				*/
				GlobalTriggers.on('plbdataloaded',dataLoadedCallback);
			});
		},

		onRTEBeforePaste : function() {
			var list = this.getWidgets();
			for (var i=0;i<list.length;i++) {
				list[i].setAge(this.pastedage);
			}
			this.pastedage++;
		},

		onRTEAfterPaste: function() {
			//$().log('RTE: event = AfterPaste');
			this.fixPaste();
			/*
			this.rte.instance.on( 'dataReady', $.proxy(function( evt ) {
				evt.removeListener();
				this.fixPaste();
			},this) );
			*/
		},

		fixPasteCollision: function ( list ) {
			if (list.length > 1) {
				var bestIdx = 0, bestAge = list[0].getAge();
				for (var i=1;i<list.length;i++) {
					var curAge = list[i].getAge();
					if (curAge > bestAge) {
						bextIdx = i;
						bestAge = curAge;
					}
				}
				for (var i=0;i<list.length;i++) {
					if (i != bestIdx) {
						list[i].setId(this.generateWidgetId());
					}
				}
			}
		},

		fixPaste: function()
		{
			var list = this.getWidgets();
			var sorted = {};
			for (var i=0;i<list.length;i++) {
				var el = list[i];
				var e = el.getElement();
				var type = el.getType();
				if ( !type || !PLB.Library[type] ) {
					delete list[i];
					e.remove();
				} else {
					sorted[el.getId()] = sorted[el.getId()] || [];
					sorted[el.getId()].push(el);
				}
			}

			for (var i in sorted) {
				if (sorted[i].length > 1) {
					this.fixPasteCollision(sorted[i]);
				}
			}
		},

		onRTEDroppedElements: function (rte,els,event) {
			els.each($.proxy(this.fixDraggedElement,this));
		},

		fixDraggedElement: function (i,el) {
			el = $(el).closest('.plb-rte-widget');
			if (el.length > 0) {
				var parent = el.parent();
				if (parent.is('body') && el.is('span')) {
					var ckel = new CKEDITOR.dom.element(el[0]);
					var range = new CKEDITOR.dom.range(ckel.getDocument());
					range.setStartAt(ckel,CKEDITOR.POSITION_AFTER_START);
					range.collapse(true);
					range.fixBlock(true,'p');
				}
				/*
				var parent = el.parent();
				if (parent.is('body') && el.is('span')) {
					var wrapped = $('<p>').append(el.clone());
					el.replaceWith(wrapped);
				}
				*/
			}
		},

		// Store the information that RTE is ready
		onRTEReady : function () {
			this.isRTEReady = true;
			this.onCheckReady();
		},

		// Store the information that data has been loaded
		onDataLoaded : function() {
			this.isDataReady = true;
			this.onCheckReady();
			this.creator = new PageLayoutBuilder.WidgetCreator();
			var helpbox = new PageLayoutBuilder.HelpBox();
		},

		// Check if all requirements are met to initialize PLB editor
		onCheckReady : function() {
			if (!this.isRTEReady || !this.isDataReady) {
				return;
			}

			// Create the UI inside sidebar
			this.ui = new PLB.UI(this);
			this.ui.bind({
				create: this.onCreateWidgetRequest,
				edit: this.onEditWidgetRequest,
				'delete': this.onDeleteWidgetRequest,
				scope: this
			});
			this.fire('uiReady',this,this.ui);
		},

		// RTE might switch the whole IFRAME in the meantime, now there is an opportunity
		// to rebind all event handlers = RTE event 'wysiwygModeReady'
		onRTERebind : function () {
			this.fire('rebind',this);
		},

		onRTERequestCSS: function (rte,css) {
			if (PLB.Data.editorCss) {
				var l = PLB.Data.editorCss;
				for (var i=0;i<l.length;l++) {
					css.push(l[i]);
				}
			}
		},

		onRTEKey: function (rte,data,event) {
			this.fire('rtekey',rte,data,event);
		},

		onRTEBeforeCreateUndoSnapshot: function(rte,data,e) {
			if (!rte.isFullWysiwyg()) {
				return;
			}
			$().log('','PLB->>>-onRTEBeforeCreateUndoSnapshot');
			var undoSnapshot = {};

			undoSnapshot.selection = this.saveSelection(null,null);
			undoSnapshot.elements = this.replacePlaceholders(this.rte,undoSnapshot.selection);
			if (undoSnapshot.elements.length > 0) {
				this.restoreSelection(undoSnapshot.selection);
			}

			this.undoSnapshot = undoSnapshot;

			$().log(this.undoSnapshot,'PLB-<<<-onRTEBeforeCreateUndoSnapshot');
		},

		onRTEAfterCreateUndoSnapshot: function(rte,data,e) {
			if (!rte.isFullWysiwyg()) {
				return;
			}
			$().log('','PLB->>>-onRTEAfterCreateUndoSnapshot');
			var debug = {};
			if (this.undoSnapshot) {
				var us = this.undoSnapshot;
				var placeholders = []
				if (us.elements.length > 0) {
					for (var i=0;i<us.elements.length;i++) {
						placeholders.push(this.createPlaceholder(us.elements[i]));
					}
					this.restoreSelection(us.selection)
				}
				debug.placeholders = placeholders;
			}

			this.undoSnapshot = null;
			$().log(debug,'PLB-<<<-onRTEAfterCreateUndoSnapshot');
		},

		insertPlaceholders: function (rte,state) {
			if (!rte.isFullWysiwyg()) {
				return;
			}
			if (state.command && state.command.canUndo === false) {
				return;
			}

			$().log('','PLB->>>-insertPlaceholders');

			var debug = {};
			var selData = this.saveSelection(state.selection,state.ranges);

			var placeholders = [];
			var elements = this.getWidgetElements();
			for (var i=0;i<elements.length;i++) {
				placeholders.push(this.createPlaceholder(elements[i]));
			}
			this.restoreSelection(selData);

			debug.selection = selData;
			debug.placeholders = placeholders;

			$().log(debug,'PLB-<<<-insertPlaceholders');

			this.fire('placeholderscreated',placeholders);

		    return placeholders;
		},

		replacePlaceholders: function (rte,state) {
			if (!rte.isFullWysiwyg()) {
				return;
			}
			// Now, this routine does nothing if there are no placeholders
			// so it is safe to execute event if placeholders were not inserted earlier
//			if (state.command && state.command.canUndo === false) {
//				return;
//			}
			$().log('','PLB->>>-replacePlaceholders');

			var debug = {};
			var selData = this.saveSelection(state.selection,state.ranges);

			var elements = [];
		    var placeholders = $('.plb-rte-widget-placeholder',rte.getBody());
		    for( var i = 0; i < placeholders.length; i++ ) {
		    	elements.push(this.replacePlaceholder(placeholders[i]));
		    }
		    this.restoreSelection(selData);

		    debug.selection = selData;
		    debug.elements = elements;

		    this.fire('placeholdersremoved',elements);

		    $().log(debug,'PLB-<<<-replacePlaceholders');

		    this.fixPaste();
		    return elements;
		},

		createPlaceholder: function( el ) {
			el = $(el);
			var wrapper = $('<div>').append(el.clone());
			var ph = $('<img formatEditable="true" src="" alt="placeholder"/>')
				.attr('plbdata',wrapper.html())
				.addClass('plb-rte-widget-placeholder');
			el.replaceWith(ph);
			return ph;
			/*
			var wrapper = $(el).wrap('<div class="plb-rte-widget-placeholder" />').parent();
			var ph = $('<img src="" alt="placeholder"/>')
				.attr('plbdata',wrapper.html())
				.addClass('plb-rte-widget-placeholder');
			wrapper.replaceWith(ph);
			return ph;
			*/
		},

		replacePlaceholder: function( el ) {
			var wrapper = $(el);
			var widgetEl = null;
			if (wrapper.hasClass('plb-rte-widget-placeholder')) {
				widgetEl = $(wrapper.attr('plbdata'));
				wrapper.replaceWith(widgetEl);
			}
			return widgetEl;
		},

		saveSelection: function( data ) {
			var sel = data && typeof data == 'object' && data.selection || this.rte.instance.getSelection();
			var ranges = data && typeof data == 'object' && data.ranges || sel.getRanges();
			return {
				selection: sel,
				ranges: ranges
			};
		},

		restoreSelection: function( data ) {
			data.selection.selectRanges(data.ranges);
		},

		fixReadOnlySelection: function() {
			/*
			var selection = this.rte.instance && this.rte.instance.getSelection(),
				ranges = selection && selection.getRanges(),
				goodAncestor = ranges && ranges[0].startContainer.findFormattableAncestor();
			if (goodAncestor) {
				ranges[0].setStartAfter(goodAncestor);
				ranges[0].collapse(true);
				selection.selectRanges( new CKEDITOR.dom.rangeList( [ranges[0]] ) );
			}
			*/
			var editor = this.rte.instance;
			// Get the selection ranges.
			var ranges = this.rte.instance.getSelection().getRanges( true );
			// Wikia - start
			if (ranges.length == 0) {
				ranges = this.rte.instance.getSelection().getRanges( false );
				var range = ranges[0];
				var xStartPath = new CKEDITOR.dom.elementPath( range.startContainer ),
					xEndPath = new CKEDITOR.dom.elementPath( range.endContainer );
				if ( !xEndPath.isContentEditable() ) {
					var notEditableParent = range.endContainer.isReadOnly();
					if (notEditableParent.is( 'p', 'div' )) {
						range.setEndAt(notEditableParent,CKEDITOR.POSITION_BEFORE_END);
					} else {
						range.setEndAfter(notEditableParent);
					}
					range.collapse(false);
				} else {
					range.collapse(false);
				}
				ranges = new CKEDITOR.dom.rangeList([range]);
				this.rte.instance.getSelection().selectRanges(ranges);
				if ( ! CKEDITOR.env.ie ) {
					ranges = this.rte.instance.getSelection().getRanges( false );
				} else {
					// IE selection is so stupid!!!
					this.rte.instance.getSelection()._.cache.ranges = ranges;
				}
			}
		},

		onRTEModeSwitch: function (rte,mode) {
			if (this.ui) {
				//this.ui[mode == 'source' ? 'hide':'show']();
			}
		},

		onRTESelectionChange: function (rte,data,event) {
			this.fire('selectionchange',this,data);
		},


		getWidgetElements : function () {
			return $('.plb-rte-widget',this.rte.getBody());
		},

		// Get all widgets inside the editor
		getWidgets : function () {
			var els = this.getWidgetElements();
			var list = [];
			$.each(els,$.proxy(function(i,v){
				var w = PLB.Widget.create(this,v);
				list.push(w);
				this.usedWidgetIds[""+w.getId()] = true;
			},this));
			return list;
		},

		// Find specific widget by its id
		getWidget : function ( id ) {
			if (typeof id == 'object') {
				var data = $(id).getData();
				id = data[PLB.PARAM_ID];
			}
			id = Number(id) + 0;

			var l = this.getWidgets();
			for (var i=0;i<l.length;i++) {
				if (l[i].getId() == id) {
					return l[i];
				}
			}
			return null;
		},

		generateWidgetId: function () {
			var id = this.nextWidgetId;
			while (this.usedWidgetIds[""+id]) {
				id++;
			}
			this.usedWidgetIds[id] = true;
			this.nextWidgetId = id + 1;
			return id;
		},

		// Create new widget
		createWidget : function ( type ) {
			var el = $(PLB.Library[type].templateHtml, this.rte.instance.document.$);
			var w = PLB.Widget.create(this,el);
			w.setId(this.generateWidgetId());
			w.getElement().attr('data-rte-instance', window.RTE.instanceId);
			this.adding = w;
			w.edit();
		},

		onWidgetBeforeChange : function (widget,type,props) {
			this.rte.instance.fire('saveSnapshot');
		},

		onWidgetChanged : function (widget,type,props) {
			if (this.adding) {
				var el = this.adding.getElement();
				this.rte.instance.focus();
				this.fixReadOnlySelection();
				this.rte.insertElement(el);
				this.fixDraggedElement(0,$(el[0]));
				this.rte.instance.focus();
				this.adding = null;
			}
			this.rte.instance.fire('saveSnapshot');
			this.fire('changed',this,widget,type,props);
		},

		onWidgetAfterEdit : function () {
			this.adding = null;
		},

		onCreateWidgetRequest: function ( type ) {
			this.rte.instance && this.rte.instance.focus();
			this.createWidget(type);
		},

		onEditWidgetRequest: function ( id ) {
			this.getWidget(id).edit();
		},

		onDeleteWidgetRequest: function ( id ) {
			this.rte.instance.fire('saveSnapshot');
			this.getWidget(id).remove();
			this.rte.instance.fire('saveSnapshot');
			this.fire('changed');
		},

		onContentChange: function () {
			this.fire('changed');
		}

	});

	PLB.UI = $.createClass(Observable,{

		ed: null,
		//el: null,
		rte: null,

		//state: true,

		//addButton: null,
		/*
		widgetsManager: null,
		widgetsTutorial: null,
		widgetsInfo: null,
		widgetsSummary: null,
		widgetsList: null,
		*/
		refreshTimer: null,
		refreshTimerDelay: 500,
		rebindOverlaysTimer: null,
		rebindOverlaysTimerDelay: 500,
		refreshSelectionTimer: null,
		refreshSelectionTimerDelay: 100,


		constructor: function( editor ) {
			PLB.UI.superclass.constructor.call(this);

			this.refreshTimer = Timer.create($.proxy(this.refresh,this),this.refreshTimerDelay);
			this.rebindOverlaysTimer = Timer.create($.proxy(this.rebindOverlays,this),this.rebindOverlaysTimerDelay);
			this.refreshSelectionTimer = Timer.create($.proxy(this.refreshSelection,this),this.refreshSelectionTimerDelay);

			this.ed = editor;
			this.ed.bind({
				rebind: this.rebind,
				changed: [ this.rebindOverlays, this.refresh ],
//				placeholdersremoved: [ this.delayedRebindOverlays, this.delayedRefresh ],
				selectionchange: this.delayedRefreshSelection,
				rtekey: this.delayedRefresh,
				scope: this
			});
			this.rte = this.ed.rte;

			//this.el = this.rte.getSidebar();
			//this.el = $('<div>');

			this.setup();
			this.rebind();
			//lazy  load of catselect
			//initCatSelectForEdit();
		},

		setup: function () {
			// Move the editor's sidebar to the left
			//this.el.insertBefore(this.el.prev());
			// Clear the contents and fill the HTML into the sidebar
			/*
			this.el
				.empty()
				.addClass('plb-toolbox')
				.append(PLB.Data.toolboxHtml);

			this.widgetsManager = $('.plb-manager',this.el);
			this.widgetsTutorial = $('.plb-widgets-tutorial',this.el);
			this.widgetsTutorial.css('max-height',(this.el.innerHeight() - this.widgetsManager.outerHeight()) + 'px');
			this.widgetsInfo = $('.plb-widgets',this.el);
			this.widgetsSummary = $('.plb-widgets-summary',this.el);
			this.widgetsList = $('.plb-widget-list',this.el);
			this.widgetsList.css('max-height',(this.el.innerHeight() - this.widgetsManager.outerHeight()- this.widgetsSummary.outerHeight()) + 'px');
			this.widgetsCount = $('.plb-widgets-count',this.el);
			*/
		},

		rebind: function () {
			/*
			if (this.rte.getBody()) {
				this.rte.getBody().unbind('keyup.plb');
				this.rte.getBody().bind('keyup.plb',$.proxy(this.delayedRefresh,this));
			} else {
				$().log('UI::rebind() - cannot find RTE.getEditor()','PLB');
			}
			*/

			this.rebindOverlays();

			this.refresh();
		},

		delayedRebindOverlays : function () {
			this.rebindOverlaysTimer.start();
		},

		rebindOverlays: function() {
			this.rebindOverlaysTimer.stop();

			var wels = this.ed.getWidgetElements();
			wels.unbind('.plb-clickable')
				.bind('click.plb-clickable',$.proxy(this.onWidgetEdgeClickCheck,this));
			var cels = $('.plb-rte-widget-clickable',wels);
			cels.unbind('.plb-clickable')
				.bind('click.plb-clickable',$.proxy(this.onWidgetEdgeClickCheck,this));
			return;
		},

		/*
		hide: function() {
			//$('>*',this.el).css('display','none');
			this.state = false;
		},

		show: function() {
			//$('>*',this.el).css('display','');
			this.state = true;
		},
		*/

		delayedRefresh : function () {
			this.refreshTimer.start();
		},

		// Searches the editor DOM for all PLB widgets and refreshes the list in toolbox
		refresh : function () {
			this.refreshTimer.stop();

			/*
			if ( !this.state ) {
				this.refreshTimer.start(1000);
				return;
			}
			*/

			if ( !this.rte.getBody() ) {
				this.refreshTimer.start();
				return;
			}

			$().log('refreshing wigdets list...','PLB');

			this.fire('refresh',this);
			$('.plb-rte-widget-edit-button',this.rte.getBody()).each($.proxy(function(i,e){
				$(e)
					.unbind('.plbeditbutton')
					.bind('click.plbeditbutton',$.proxy(this.onWidgetEditClick,this));
			},this));

			this.refreshHovers(this.ed.getWidgetElements());
		},

		delayedRefreshSelection : function () {
			this.refreshSelectionTimer.start();
		},

		// Searches the editor DOM for all PLB widgets and refreshes the list in toolbox
		refreshSelection : function () {
			this.refreshSelectionTimer.stop();

			var sel = this.rte.instance.getSelection(),
				element = sel && sel.getStartElement();

			var current = false;
			if (element && element.$) {
				var el = element.findFormattableAncestor();
				if (el) current = $(el.$);
			}

			if (this.previousSelection && this.previousSelection != current) {
				this.previousSelection.removeClass('selected');
				this.previousSelection = false;
			}

			if (current && this.previousSelection != current) {
				this.previousSelection = current;
				this.previousSelection.addClass('selected');
			}
		},

		onWidgetEdgeClickCheck : function(e) {
			var el = $(e.target), wel = el.closest('.plb-rte-widget');
			var pos_l = e.pageX - wel.offset().left, pos_r = wel.innerWidth() - pos_l;
			$().log('onWIdgetEdgeClickCheck: pos_l = '+pos_l+' pos_r = '+pos_r,'PLB');
			if ( pos_l < 20 ) {
				this.setCursorNearWidget(wel,false);
				return false;
			} else if ( pos_r < 20 ) {
				this.setCursorNearWidget(wel,true);
				return false;
			}
		},

		setCursorNearWidget : function( widget, atEnd ) {
			widget = $(widget);
			var element = new CKEDITOR.dom.element(widget[0]);
			var range = new CKEDITOR.dom.range(element.getDocument());
			range[atEnd?'setStartAfter':'setStartBefore'](element);
			range.collapse(true);
			var selection = this.rte.instance.getSelection();
			selection.selectRanges(new CKEDITOR.dom.rangeList([range]));
		},

		// Handle click on add element button
		onAddElementClick : function (value) {
			if(typeof value == 'object') {
				var value = $(value.target).closest('li').attr('__plb_type');
			}
			this.fire('create',value);
			return false;
		},

		onOverlayEditClick : function(node) {
			this.fire('edit',$(node));
		},

		onWidgetEditClick : function(event) {
			var w = $(event.target).closest('.plb-rte-widget');
			this.fire('edit',w);
			return false;
		},

		refreshHovers : function(elements) {
			elements.each(function(i,el){
				el = $(el)
					.unbind('.plbhover')
					.bind({
						'mouseenter.plbhover': function() {
							el.addClass('hover');
						},
						'mouseleave.plbhover': function() {
							el.removeClass('hover');
						}
					});
			});
		}

	});

	PLB.PropertyEditor = $.createClass(Observable,{

		width: 425,
		editorHtml: null,
		attributes: null,
		requiredAttributes: null,

		type: null,
		values: null,

		form: null,
		wrapper: null,
		saveButton: null,

		valid: false,

		constructor: function( type, values ) {
			PLB.PropertyEditor.superclass.constructor.call(this);
			this.type = type;
			this.editorHtml = PLB.Library[this.type].editorHtml;
			this.attributes = PLB.Library[this.type].attributes;
			this.requiredAttributes = PLB.Library[this.type].requiredAttributes;
			this.attributeCaptions = PLB.Library[this.type].attributeCaptions;
			this.values = $.extend({},this.attributes,values);
			$.extend(this,PLB.Library[this.type]);
		},

		getValues: function() {
			return this.values;
		},

		show: function() {
			// Create form
			this.form = $(this.editorHtml);

			// Find the buttons and assign proper handlers to them
			this.saveButton = $('.plb-pe-button-save',this.form);
			$('.plb-pe-button-save',this.form).bind('click',$.proxy(this.doSave,this));
			$('.plb-pe-button-cancel',this.form).bind('click',$.proxy(this.doDismiss,this));
			$('form',this.form).bind('submit',function(){return false;});

			// Give the subclasses way to initialize the form
			this.extFormSetup(this.form);

			// Write all current values to the form
			this.writeValues();
			// Bind to change events and invoke it once

			var form = $('form', this.form);
			form.find('[name],',this.form).change($.proxy(this.onChange,this));;
			form.find('[name],',this.form).blur($.proxy(this.onChange,this));
			form.find('input[name], textarea[name]',this.form).keyup($.proxy(this.onChange,this));

			$('.helpicon',this.form).each(function(i,el){
				new PLB.Tooltip(el);
			});

			this.onChange();
			// Show modal box
			var mopts = {
				onClose: $.proxy(this.doDismiss,this),
				closeOnBlackoutClick: false,
				width: this.width
			};
			this.wrapper = this.form.makeModal(mopts);

			//init preview
			this.refreshPreview(this.getValues());
			$('.plb-pe-window-preview').find('input[name], textarea[name]')
				.focus($.proxy(this.focusPreviewInput,this))
				.blur($.proxy(this.blurPreviewInput,this));
			$('.plb-pe-window-preview button').attr("onclick", "");
		},

		focusPreviewInput: function(e) {
			$(e.target).val("").removeClass('plb-empty-input');
		},

		blurPreviewInput: function(e) {
			this.refreshPreview(this.values);
			$(e.target).addClass('plb-empty-input');
		},

		refreshPreview: function(values) {
			var val = PageLayoutBuilder.Lang["plb-editor-preview-desc"];

			if( typeof(values.caption) != 'undefined' ) {
				$('.plb-pe-window-preview .plb-form-caption-p').html($.htmlentities( values.caption ));
			}

			if((typeof(values.instructions) != 'undefined') && (values.instructions != "")) {
				val = values.instructions;
			}
			$('.plb-pe-window-preview input').val(val);;
			$('.plb-pe-window-preview .plb-span-instructions:not(textarea)').html($.htmlentities( val ));
			$('.plb-pe-window-preview textarea').text( val );

			this.extRefreshPreview(values);
		},

		setupForm: function() {
		},

		readValue: function( name ) {
			var state = { value: undefined };
			var el = $('[name='+name+']',this.form);
			if (el.length>0) {
				if (el.attr('type') == 'checkbox') {
					state.value = el.attr('checked') ? 1 : 0;
				} else {
					state.value = el.val();
				}
			}
			this.extFormGetValue(name,state);
			return state.value;
		},

		writeValue: function( name, value ) {
			var el = $('[name='+name+']',this.form);
			if (el.length>0) {
				if (el.attr('type') == 'checkbox') {
					value = 0 + Number(value);
					el.attr('checked', value ? true : false );
				} else {
					el.val(value);
				}
			}
			var state = { value: value };
			this.extFormSetValue(name,state);
		},

		showFieldValidation: function( name, value ) {
			var el = $('[name='+name+']',this.form);
			if (el.length>0) {
				el[value?'removeClass':'addClass']('plb-pe-field-error');
			}
			var state = { value: value };
			this.extShowFieldValidation(name,state);
		},

		readValues: function( el ) {
			$.each(this.attributes,$.proxy(function(attr,d){
				if (attr != PLB.PARAM_ID_RAW) {
					this.values[attr] = this.readValue(attr);
				}
			},this));
			return this.values;
		},

		writeValues: function( el ) {
			$.each(this.attributes,$.proxy(function(attr,d){
				this.writeValue(attr,this.values[attr]);
			},this));
		},

		updateValues: function () {
			this.values = this.readValues();
		},

		validate: function() {
			var state = { valid: true, status: {} };
			$.each(this.attributes,function(name,value){
				state.status[name] = [];
			});
			$.each(this.requiredAttributes,$.proxy(function(i,name){
				if (!this.values[name]) {
					state.status[name].push(PLB.Lang['plb-property-editor-value-required']);
					state.valid = false;
				}
			},this));
			this.extFormValidate(state);
			this.valid = state.valid;
			this.validStatus = state.status;
//			this.showValidation();
			return this.valid;
		},

		showValidation: function() {
			var box = this.form.find('>:first-child');
			if (box.length == 0 || !box.hasClass('plb-pe-validation-status')) {
				box = $('<div class="plb-pe-validation-status" />');
				this.form.prepend(box);
			}
			box.css('display',this.valid?'none':'block');
			var s = this.validStatus;
			var msg = [];
			for (var i in s) {
				if (s[i].length > 0) {
					msg.push(this.attributeCaptions[i] + ' ' + s[i].join(', '));
				}
				this.showFieldValidation(i,s[i].length == 0);
			}
			box.html(msg.join('<br />'));
		},

		onChange: function(ev) {
			this.updateValues();
			this.refreshPreview(this.values);
			this.extFormChange(ev);
			this.validate();
		},

		doSave: function() {
			this.updateValues();
			this.validate();
			this.showValidation();
			if (!this.valid) {
				return false;
			}

			$().log(this.values,'PLB-properties');
			this.fire('save',this);
			this.wrapper.closeModal();
			return false;
		},

		doDismiss: function() {
			this.wrapper.closeModal();
			this.fire('dismiss',this);
			return false;
		},

		extFormSetup: function() {},
		extFormGetValue: function() {},
		extFormSetValue: function() {},
		extFormValidate: function() {},
		extFormChange: function() {},
		extShowFieldValidation: function() {},
		extRefreshPreview: function () {
			$().log('extRefreshPreview',"EXT");
		}
	});

	PLB.PropertyEditors = {};

	PLB.PropertyEditors['plb_image'] = $.createClass(PLB.PropertyEditor,{

		constructor: function() {
			PLB.PropertyEditors['plb_image'].superclass.constructor.apply(this,arguments);
		},

		extFormValidate: function(state) {
			if (this.values['size'] != '') {
				var e = parseInt(this.values['size']);
				if (e < 1) {
					state.status['size'].push(PLB.Lang['plb-parser-image-size-not-int']);
					state.valid = false;
				} else if (e > 1000) {
					state.status['size'].push(PLB.Lang['plb-parser-image-size-too-big']);
					state.valid = false;
				}
			}
		},

		extFormGetValue: function(name,state) {
			if (name == 'type') {
				state.value = this.readValue('x-type') ? 'thumb' : 'frameless';
			}
		},

		extFormSetValue: function(name,state) {
			if (name == 'type') {
				this.writeValue('x-type',state.value == 'thumb' ? 1 : 0);
			}
		},

		extShowFieldValidation: function(name,state) {
			if (name == 'type') {
				this.showFieldValidation('x-type',state.value);
			}
		},

		extRefreshPreview : function(values) {
			$().log(values, 'PLB image');
		}
	});


	PLB.PropertyEditors['plb_gallery'] = $.createClass(PLB.PropertyEditor,{

		constructor: function() {
			PLB.PropertyEditors['plb_gallery'].superclass.constructor.apply(this,arguments);
		},

		extFormValidate: function(state) {
			if (this.values['size'] != '') {
				var e = parseInt(this.values['size']);
				if (e < 1) {
					state.status['size'].push(PLB.Lang['plb-parser-image-size-not-int']);
					state.valid = false;
				} else if (e > 1000) {
					state.status['size'].push(PLB.Lang['plb-parser-image-size-too-big']);
					state.valid = false;
				}
			}
		}
	});

	PLB.PropertyEditors['plb_sinput'] = $.createClass(PLB.PropertyEditor,{

		constructor: function() {
			PLB.PropertyEditors['plb_sinput'].superclass.constructor.apply(this,arguments);
		},

		extFormValidate: function(state) {
			if (this.values['options'].indexOf('|') == -1) {
				state.status['options'].push(PLB.Lang['plb-property-editor-not-enough-items']);
				state.valid = false;
			}
		},

		extFormGetValue: function(name,state) {
			if (name == 'options') {
				var l = String(this.readValue('x-options')).split('\n');
				var ll = [];
				$.each(l,function(i,v){
					if (v != '')
						ll.push(v.replace("|", "&#124;"));
				});

				state.value = ll.join('|');
				return state;
			}
		},

		extFormSetValue: function(name,state) {
			if (name == 'options') {
				var l = String(state.value).split('|');
				var ll = [];
				$.each(l,function(i,v){
					if (v != '')
						ll.push(v.replace("&#124;", "|"));
				});
				this.writeValue('x-options',ll.join('\n'));
			}
		},

		extShowFieldValidation: function(name,state) {
			if (name == 'options') {
				this.showFieldValidation('x-options',state.value);
			}
		},

		extRefreshPreview : function(values) {
			var value = this.extFormGetValue('options', {});
			var l = String(value.value).split('|');

			var element = $('.plb-pe-window-preview select');
			element.empty();
			if (typeof(values.instructions) != 'undefined') {
			//	$(element).append($("<option/>").text(values.instructions).val(""));
			}
			if(l.length > 0) {
				$.each(l,function(i,v){
					if (v != '') {
						v = v.replace("&#124;", "|");
						$(element).append($("<option/>").text(v).val(i).addClass('normal'));
					}
				});
			}
			PageLayoutBuilder.initSelect();
		}
	});


	PLB.PropertyEditor.create = function ( type, values ) {
		if (typeof PLB.PropertyEditors[type] == 'undefined') {
			PLB.PropertyEditors[type] = PLB.PropertyEditor;
		}
		return new PLB.PropertyEditors[type](type,values);
	};

	PLB.Tooltip = $.createClass(Object,{

		ts: null,

		el: null,
		tip: null,

		constructor: function( el ) {
			this.el = $(el);
			this.el.hover($.proxy(this.enter,this),$.proxy(this.leave,this));
			this.tip = $('>.helpicon-text',this.el);
			this.ts = $('#TooltipHolder') || $('<div id="TooltipHolder"')
		},

		enter: function() {
			/*
			var offset = this.el.offset();
			offset.left += this.el.outerWidth() + 2;
			this.tip
				.css('position','absolute')
				.css('left',offset.left + 'px')
				.css('top',offset.top + 'px');
			*/
			this.tip
				.css('position','absolute')
				.css('left',(this.el.outerWidth() + 2)+'px')
				.css('bottom','-'+(this.el.outerHeight() - 2)+'px');
			this.tip.css('display','block');
		},

		leave: function() {
			this.tip.css('display','none');
		}


	});

	PLB.WidgetCreator = $.createClass(Observable,{
		constructor: function() {
			var addButton = $('.plb-add-element');
			var addMenu = $('ul', addButton);
			$.each(PageLayoutBuilder.Library,function(i,v){
				$( "<li>" +  v.menuItemHtml.html + "</li>")
					.attr(PLB.HTML_PARAM_TYPE,i)
					.addClass('plb-add-menu-item-'+i)
					.appendTo(addMenu);
			});

			$('li',addMenu)
				.css('cursor','pointer')
				.bind({
					click: $.proxy(this.onAddElementClick,this)
				})
				.hover(
					$.proxy(this.onMouseEnter,this),
					$.proxy(this.onMouseLeave,this)
				);

			WikiaButtons.add(addButton, {
				click:WikiaButtons.clickToggle
			});
		},
		onMouseEnter: function(e) {
			var el = $(e.target).closest('li');
			el.addClass('hover');
		},
		onMouseLeave: function(e) {
			var el = $(e.target).closest('li');
			el.removeClass('hover');
		},
		onAddElementClick: function(type) {
			var text;
			if(typeof RTE == 'undefined') {
				text = $('#wpTextbox1').val();
			} else {
				text = $('#cke_contents_wpTextbox1 > textarea').val();
			}
			var elements = $( "<div>" + text + "</div>" ).filter('[id]');
			var newID = 0;
			$.each(elements,function(i,v) {
			    var oldID = parseInt($(v).attr('id'));
			    if(newID <  oldID) {
			        newID = oldID;
			    }
			});
			newID++;
			if (typeof type != 'string') {
				type = $(type.target).closest('li').attr(PLB.HTML_PARAM_TYPE);
			}
			var pe = PageLayoutBuilder.PropertyEditor.create(type, {id:newID});
			pe.on('save',function() {
			    var props = pe.getValues();
			    var attr = '';
			    $.each(props, function(i,v){
			    	attr += ' ' + i + '="' + $.htmlentities(v) + '"' + ' ';
			    });
			    insertTags('<' + pe.type + ' ' + attr + ' />','','');
			});
			pe.show();
		}
	});

	PLB.HelpBox = $.createClass(Observable,{
		constructor: function() {
			if( $.getUrlVar('action') == 'submit' ) {
				return true;
			}

			if(PageLayoutBuilder.helpbox.show == 0) {
				return true;
			}

			var helpbox = $(PageLayoutBuilder.helpbox.html);

			$().log(PageLayoutBuilder.helpbox.html);

			var mopts = {
				onClose: function() {},
				closeOnBlackoutClick: false,
				width: 960
			};

			this.wrapper = helpbox.makeModal(mopts);
			this.wrapper.showModal();

			$('#getStarted2, #getStarted1').click($.proxy(this.buttonClick, this));

			$('#getStartedBlock1, #getStartedBlock2').click($.proxy(this.checkboxClick, this));
		},
		buttonClick: function(e){
			this.wrapper.closeModal();
			return false;
		},

		checkboxClick: function(e) {
			$('#getStartedBlock1, #getStartedBlock2').attr('checked',  $(e.target).attr('checked'));
			$.ajax({
				url: wgScript + '?action=ajax&rs=PageLayoutBuilderEditor::closeHelpbox&val=' + $(e.target).attr('checked'),
				dataType: "json",
				method: "post",
				success: function(data) {
					$().log("button click", "PLB");
				}
			});
		}
	});

	window.plb = new PLB.Editor();

	GlobalTriggers.on("beforeMWToolbarRender",function(toolbar){
		$("#sourceModeInsertElement").prependTo(toolbar).show();
	});

	GlobalTriggers.on('wikiaeditoraddons',function(WE){
		var modules = WE.modules;

		modules.LayoutBuilderAddElement = $.createClass(modules.ButtonsList,{

			modes: true,

			headerClass: 'plb_insert',
			headerTextId: 'plb-insert-title',

			items: [],

			init: function() {
				modules.LayoutBuilderAddElement.superclass.init.call(this);
				var self = this;
				this.items = [];
				for (var type in PLB.Library) {
					var name = 'PLBAddElement_' + type;
					var def = PLB.Library[type];
					this.items.push(name);

					this.editor.ui.addElement(name,{
						type: 'button',
						label: def.caption,
						className: name,
						click: (function(type){
							return function() {
								self.addElement(type);
							};
						})(type)
					});
				}
			},

			track: function(ev) {
				var name = ev.split('_').pop();

				switch(name) {
					case 'input':
						name = 'inputbox';
						break;

					case 'image':
						name = 'photo';
						break;

					case 'mlinput':
						name = 'paragraph';
						break;

					case 'sinput':
						name = 'dropdownList';
						break;
				}

				this.editor.track(this.editor.getTrackerMode(), 'plbFeatures', name);
			},

			getLayoutEditor: function() {
				// XXX: make it work with multiple instances
				return window.plb;
			},

			addElement: function( type ) {
				var plb = this.getLayoutEditor();
				var mode = this.editor.mode;
				if (mode == 'source') {
					plb.creator.onAddElementClick( type );
				} else {
					plb.onCreateWidgetRequest( type );
				}

				this.track(type);
			},

			afterRender: function() {
				modules.LayoutBuilderAddElement.superclass.afterRender.call(this);
				this.el.find('.cke_button').addClass('cke_button_big');
			}

		});

		modules.LayoutBuilderElementsList = $.createClass(modules.base,{

			headerClass: 'plb_list',
			headerTextId: 'plb-list-title',

			loaded: false,

			init: function() {
				// XXX: multiple instances
				this.ed = window.plb;
			},

			track: function(ev) {
				this.editor.track(this.editor.getTrackerMode(), 'plbList', ev);
			},

			renderHtml: function() {
				return '<div class="plb-toolbox">' + PLB.Data.toolboxHtml + '</div>';
			},

			afterRender: function() {
				this.widgetsTutorial = $('.plb-widgets-tutorial',this.el);
//				this.widgetsTutorial.css('max-height',(this.el.innerHeight() - this.widgetsManager.outerHeight()) + 'px');
				this.widgetsInfo = $('.plb-widgets',this.el);
//				this.widgetsSummary = $('.plb-widgets-summary',this.el);
				this.widgetsList = $('.plb-widget-list',this.el);
//				this.widgetsList.css('max-height',(this.el.innerHeight() - this.widgetsManager.outerHeight()- this.widgetsSummary.outerHeight()) + 'px');
//				this.widgetsCount = $('.plb-widgets-count',this.el);

				if (this.ed.ui)
					this.bindUI(this.ed,this.ed.ui);
				else
					this.ed.bind('uiReady',$.proxy(this.bindUI,this));
			},

			afterAttach: function() {
				if (!this.loaded) {
					this.widgetsTutorial.hide();
					this.widgetsInfo.hide();
				}
				this.editor.fire('plbSetAutosizedModule',this);
			},

			bindUI: function( plbeditor, ui ) {
				this.ui = ui;
				this.ui.on('refresh',this.refresh,this);
			},

			refresh: function() {
				// Find all PLB widgets in the editor
				var l = this.ed.getWidgets();
				// Clear list in the toolbox
				this.widgetsList.empty();
				// Prepare buttons overlay for list items
				var bs = "<span class=\"buttons\"><input type=\"button\" class=\"wikia-button secondary edit\" value=\""+$.htmlentities(PLB.Lang['plb-editor-edit'])+"\" />"
					+"<a href=\"#\" class=\"sprite trash delete\"></a></span>";
				// For each widget found do ...
				$.each(l,$.proxy(function(i,e){
					if(PLB.Library[e.getType()]) {
						var html = PLB.Library[e.getType()].listItemHtml
							.replace("[$ID]",$.htmlentities(e.getId()))
							.replace("[$CAPTION]",$.htmlentities(e.getCaption()))
							.replace("[$BUTTONS]",bs);
						$(html).appendTo(this.widgetsList);
					}
				},this));
				// Set visibility of list depending on whether we have any element or not
				if (l.length > 0) {
					this.widgetsTutorial.hide();
					this.widgetsInfo.show();
				} else {
					this.widgetsInfo.hide();
					this.widgetsTutorial.show();
				}
				//this.widgetsList.css('display',l.length>0?"block":"none");
				// Substitute the overall count of widgets in the list header
				//this.widgetsCount.html(l.length);
				// Visual hovering for all children
				this.widgetsList.children()
					.hover(
						$.proxy(this.onMouseEnter,this),
						$.proxy(this.onMouseLeave,this)
					);
				// Bind to the edit and delete buttons from the overlay
				$('.edit',this.widgetsList).click($.proxy(this.onItemEditClick,this));
				$('.delete',this.widgetsList).click($.proxy(this.onItemDeleteClick,this));

				this.loaded = true;

				this.setHeaderText(this.msg('plb-list-title-count',[l.length]));
			},

			onMouseEnter : function (e) {
				var el = $(e.target).closest('li');
				el.addClass('hover');
			},

			onMouseLeave : function (e) {
				var el = $(e.target).closest('li');
				el.removeClass('hover');
			},

			// Handle click on edit button in the widgets list
			onItemEditClick : function (e) {
				var el = $(e.target).closest('li');
				var id = el.attr('__plb_id');
				this.ui.fire('edit',id);
				this.track('edit');
				return false;
			},

			// Handle click on delete button in the widgets list
			onItemDeleteClick : function (e) {
				var el = $(e.target).closest('li');
				var id = el.attr('__plb_id');
				this.ui.fire('delete',id);
				this.track('delete');
				return false;
			}

		});
	});

	GlobalTriggers.on('wikiaeditor',function(WE){

		WE.plugins.plb = $.createClass(WE.plugin,{

			initDom: function() {
				$('#wpPreviewForm',this.editor.element).click(this.proxy(function(e) {
					this.editor.controls.renderPreview({'type' : 'form'});
				}));

				// use a different message when saving draft (BugId:7123)
				$('#wpSaveDraft').click(function(ev) {
					window.wgSavingMessage = PageLayoutBuilder.Lang['plb-editor-saving-as-draft'];
				});
			}

		});

		WE.plugins.plblistautoheight = $.createClass(WE.plugin,{

			module: false,

			beforeInit: function() {
				this.editor.on('plbSetAutosizedModule',this.proxy(this.setModule));
				this.editor.on('toolbarsResized',this.proxy(this.toolbarsResized));
				$(window).bind('resize',this.proxy(this.toolbarsResized));
			},

			setModule: function( module ) {
				this.module = module;
				this.toolbarsResized();
			},

			toolbarsResized: function() {
				if (!this.module) {
					return;
				}

				var el = this.module.el.closest('.module_content');
				var p = el.closest('[data-space-type]');
				if (el.css('display') == 'none') {
					el.css('max-height','');
				} else {
					var maxH = $(window).height() - (p.offset().top + p.outerHeight(true) - el.height());
					if (maxH < 150) maxH = 150;
					el.css('max-height',maxH);
				}
			}

		});


		WE.on('wikiaeditorspacesbeforelayout',function(element,config){
			config.wide = true;
		});

		WE.on('wikiaeditorspaceslayout',function(element,layout,config){
			layout.rail.push('LayoutBuilderAddElement', 'LayoutBuilderElementsList');
		});

		WE.on('newInstance',function(plugins,config){
			plugins.push('plb');
			plugins.push('plblistautoheight');
			config.categoriesIntroText = $.msg('plb-special-form-cat-info');
			config.insertCutPosition = 1;
			config.insertCutText = $.msg('wikia-editor-plb-show-static-buttons')
			config.wideModeDisabled = true;
		});

	});

})();
