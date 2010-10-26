(function(){

	window.PageLayoutBuilder = window.PageLayoutBuilder || {};

	var PLB = window.PageLayoutBuilder;

	$.extend(PLB,{
		Util: {},
		PARAM_TYPE: '__plb_type',
		PARAM_PREFIX: '__plb_param_',
		PARAM_ID: '__plb_param_id',
		PARAM_CAPTION: '__plb_param_caption',
		PARAM_ID_RAW: 'id',
		PARAM_CAPTION_RAW: 'caption',
		Data: {},
		Library: {},
		Lang: {},
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
		
		md: null,
		
		onSave: null,
		onDismiss: null,
		
		constructor: function( editor, el ) {
			PLB.Widget.superclass.constructor.call(this);
			this.ed = editor;
			this.el = $(el);
			this.md = PLB.Library[this.el.attr('type')];
		},
		
		getElement : function () {
			return this.el;
		},
		
		getType : function () {
			return this.el.attr(PLB.PARAM_TYPE);
		},
		
		getId : function () {
			var data = this.el.getData() || {};
			return data[PLB.PARAM_ID];
		},
		
		setId : function (id) {
			this.el.setData(PLB.PARAM_ID,id);
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
		
		edit : function () {
			if (this.editing) {
				return;
			}
			
			var type = this.getType();
			var values = this.getProperties();
			this.ed.fire('widgetbeforeedit',this,type,values);
			
			this.editing = true;
			var pe = PLB.PropertyEditor.create(type,values);
			pe.on('save',$.proxy(this.onEditorSave,this));
			pe.on('dismiss',$.proxy(this.onEditorDismiss,this));
			pe.show(this.onSave,this.onDismiss);
		},
		
		remove: function () {
			this.el.remove();
		},
		
		onEditorSave : function ( pe ) {
			var v = pe.getValues();
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
		
		extSetProperties: function ( props ) {
			if (typeof props['align'] != 'undefined') {
				var wysiwygAlign = props['align'] == 'left' ? 'left' : 'right';
				this.el.css('float',wysiwygAlign);
				this.el.css('clear',wysiwygAlign);
			}
			var width = props['size'] || this.md.attributes['size'];
			$('img',this.el).css('width',width+'px');
			if (typeof props['caption'] != 'undefined') {
				$('img',this.el).attr('alt',props['caption']);
			}
		}
	
	});
	
	
	PLB.Widget.create = function ( editor, el ) {
		var type = $(el).attr(PLB.PARAM_TYPE)
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
		
		onRTEBeforeApplyStyleCallback: null,
		onRTEAfterApplyStyleCallback: null,

		constructor: function(instance) {
			PLB.RTEInstance.superclass.constructor.apply(this);
			
			// RTE is a signleton
			GlobalTriggers.on('rteready',$.proxy(this.onRTEReady,this));
			GlobalTriggers.on('rterequestcss',$.proxy(this.onRTERequestCSS,this));
			
			// Fix wgAction
			window.wgAction = 'edit';
		},
		
		getBody: function() {
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
			return this.rte.tools.insertElement.apply(this.rte.tools,arguments);
		},
		
		onRTEReady: function(instance) {
			this.rte = RTE;
			this.instance = instance;
			this.instance.on('wysiwygModeReady',$.proxy(this.onRTEWysiwygModeReady,this));
			this.instance.on('mode',$.proxy(this.onRTEModeSwitch,this));
			this.instance.on('beforeCommandExec',$.proxy(this.onRTEBeforeCommandExec,this));
			this.instance.on('afterCommandExec',$.proxy(this.onRTEAfterCommandExec,this));
			this.instance.on('beforeInsertContent',$.proxy(this.onRTEBeforeInsertContent,this));
			this.instance.on('afterInsertContent',$.proxy(this.onRTEAfterInsertContent,this));
			this.instance.on('beforeCreateUndoSnapshot',$.proxy(this.onRTEBeforeCreateUndoSnapshot,this));
			this.instance.on('afterCreateUndoSnapshot',$.proxy(this.onRTEAfterCreateUndoSnapshot,this));
			
			this.fire('ready',this);
		},
		
		onRTEWysiwygModeReady: function () {
			if (!this.onRTEBeforeApplyStyleCallback) {
				this.onRTEBeforeApplyStyleCallback = $.proxy(this.onRTEBeforeApplyStyle,this);
				this.onRTEAfterApplyStyleCallback = $.proxy(this.onRTEAfterApplyStyle,this);
			}
			this.document = this.instance.document;
			this.body = this.rte.getEditor();
			
			this.document.removeListener(this.onRTEBeforeApplyStyleCallback);
			this.document.removeListener(this.onRTEAfterApplyStyleCallback);
			this.document.on('applyStyle',this.onRTEBeforeApplyStyleCallback);
			this.document.on('afterApplyStyle',this.onRTEAfterApplyStyleCallback);
			
			this.fire('rebind',this);
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
		
		onRTERequestCSS: function(css) {
			this.fire('requestcss',this,css);
		},
		
		onRTEModeSwitch: function() {
			this.fire('modeswitch',this,this.instance.mode);
		},
		
		onRTEBeforeCreateUndoSnapshot: function( event ) {
			this.fire('beforesnapshot',this,event.data,event);
		},
		
		onRTEAfterCreateUndoSnapshot: function( event ) {
			this.fire('aftersnapshot',this,event.data,event);
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
		
		nextWidgetId: 1,
		usedWidgetIds: null,

		// Create the editor object
		constructor: function () {
			PLB.Editor.superclass.constructor.call(this);
			
			// Generate unique ID
			this.id = PLB.nextId++;
			this.usedWidgetIds = {};
			
			this.on({
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
				beforestyle: this.insertPlaceholders,
				afterstyle: this.replacePlaceholders,
				beforecommand: this.insertPlaceholders,
				aftercommand: this.replacePlaceholders,
				beforesnapshot: this.onRTEBeforeCreateUndoSnapshot,
				aftersnapshot: this.onRTEAfterCreateUndoSnapshot,
				scope: this
			});
			
			// Fetch PLB editor data through Ajax call
			$.getScript(window.wgScript + '?action=ajax&rs=PageLayoutBuilderEditor::getPLBEditorData&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, 
					$.proxy(this.onDataLoaded,this));
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
		
		onRTEBeforeCreateUndoSnapshot: function(rte,data,e) {
			$().log('','PLB->>>-onRTEBeforeCreateUndoSnapshot');
			var undoSnapshot = {};
			
			undoSnapshot.selection = this.saveSelection(null,null);
			undoSnapshot.elements = this.replacePlaceholders(this.rte,undoSnapshot.selection);
			this.restoreSelection(undoSnapshot.selection);
			
			this.undoSnapshot = undoSnapshot;
			
			$().log(this.undoSnapshot,'PLB-<<<-onRTEBeforeCreateUndoSnapshot');
		},
		
		onRTEAfterCreateUndoSnapshot: function(rte,data,e) {
			$().log('','PLB->>>-onRTEAfterCreateUndoSnapshot');
			var debug = {};
			if (this.undoSnapshot) {
				var us = this.undoSnapshot;
				var placeholders = []
				for (var i=0;i<us.elements.length;i++) {
					placeholders.push(this.createPlaceholder(us.elements[i]));
				}
				debug.placeholders = placeholders;
				this.restoreSelection(us.selection)
			}
			
			this.undoSnapshot = null;
			$().log(debug,'PLB-<<<-onRTEAfterCreateUndoSnapshot');
		},
		
		insertPlaceholders: function (rte,state) {
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
		    
		    return elements;
		},
		
		createPlaceholder: function( el ) {
			var wrapper = $(el).wrap('<div class="plb-rte-widget-placeholder" />').parent();
			var ph = $('<img src="" alt="placeholder"/>')
				.attr('plbdata',wrapper.html())
				.addClass('plb-rte-widget-placeholder');
			wrapper.replaceWith(ph);
			return ph;
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
		
		onRTEModeSwitch: function (rte,mode) {
			if (this.ui) {
				this.ui[mode=='source'?'hide':'show']();
			}
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
			var el = $(PLB.Library[type].templateHtml);
			var w = PLB.Widget.create(this,el);
			w.setId(this.generateWidgetId());
			this.adding = w;
			w.edit();
		},
		
		onWidgetChanged : function (widget,type,props) {
			if (this.adding) {
				var el = this.adding.getElement();
//				this.insertPlaceholders();
				this.rte.insertElement(el);
//				this.replacePlaceholders();
				this.adding = null;
			}
			this.fire('changed',this,widget,type,props);
		},
		
		onWidgetAfterEdit : function () {
			this.adding = null;
		},
		
		onCreateWidgetRequest: function ( type ) {
			this.createWidget(type);
		},
		
		onEditWidgetRequest: function ( id ) {
			this.getWidget(id).edit();
		},
		
		onDeleteWidgetRequest: function ( id ) {
			this.getWidget(id).remove();
			this.fire('changed');
		}
		
	});

	PLB.UI = $.createClass(Observable,{
		
		ed: null,
		el: null,
		rte: null,
		
		addButton: null,
		widgetsSummary: null,
		widgetsList: null,
		refreshTimer: null,
		refreshTimerDelay: 500,
		rebindOverlaysTimer: null,
		rebindOverlaysTimerDelay: 500,
		
		constructor: function( editor ) {
			PLB.UI.superclass.constructor.call(this);
			
			this.refreshTimer = Timer.create($.proxy(this.refresh,this),this.refreshTimerDelay);
			this.rebindOverlaysTimer = Timer.create($.proxy(this.rebindOverlays,this),this.rebindOverlaysTimerDelay);
			
			this.ed = editor;
			this.ed.bind('rebind', this.rebind, this);
			this.ed.bind('changed', this.rebindOverlays, this);
			this.ed.bind('changed', this.refresh, this);
			this.ed.bind('placeholdersremoved', this.delayedRebindOverlays, this);
			this.ed.bind('placeholdersremoved', this.delayedRefresh, this);
			this.rte = this.ed.rte;
			
			this.el = this.rte.getSidebar();
			
			this.setup();
			this.rebind();
		},
		
		setup: function () {
			// Move the editor's sidebar to the left
			this.el.insertBefore(this.el.prev());
			// Clear the contents and fill the HTML into the sidebar
			this.el
				.empty()
				.addClass('plb-toolbox')
				.append(PLB.Data.toolboxHtml);
			// Prepare the menu "Add element"
			this.addButton = $('.plb-add-element',this.el);
			var addMenu = $('ul',this.addButton);
			// ... by adding the items representing all widget types
			$.each(PLB.Library,function(i,v){
				$(v.menuItemHtml)
					.attr(PLB.PARAM_TYPE,i)
					.appendTo(addMenu);
			});
			$('li',addMenu)
				.css('cursor','pointer')
				.bind({
					click: $.proxy(this.onAddElementClick,this),
					mouseenter: $.proxy(this.onMouseEnter,this),
					mouseout: $.proxy(this.onMouseOut,this)
				});
			WikiaButtons.add(this.addButton,{
				click:WikiaButtons.clickToggle
			});
			this.widgetsSummary = $('.plb-manager',this.el);
			this.widgetsList = $('.plb-widget-list',this.el);
			this.widgetsList.css('max-height',(this.el.innerHeight() - this.widgetsSummary.outerHeight() - this.widgetsList.css('margin') * 2) + 'px');
		},

		rebind: function () {
			if (this.rte.getBody()) {
				this.rte.getBody().unbind('keyup.plb');
				this.rte.getBody().bind('keyup.plb',$.proxy(this.delayedRefresh,this));
			} else {
				$().log('UI::rebind() - cannot find RTE.getEditor()','PLB');
			}
			
			this.rebindOverlays();
			
			this.refresh();
		},
		
		delayedRebindOverlays : function () {
			this.rebindOverlaysTimer.start();
		},
		
		rebindOverlays: function() {
			this.rebindOverlaysTimer.stop();
			var widgets = this.ed.getWidgetElements();
			$().log(widgets,'PLB-overlay refresh');
			this.rte.getRTE().overlay.add(widgets, [{
				label: PLB.Lang['plb-editor-overlay-edit'],
				'class': 'RTEMediaOverlayEdit',
				callback: $.proxy(this.onOverlayEditClick,this)
			}]);
		},
		
		hide: function() {
			$('>*',this.el).css('display','none');
		},
		
		show: function() {
			$('>*',this.el).css('display','');
		},
		
		delayedRefresh : function () {
			this.refreshTimer.start();
		},
		
		// Searches the editor DOM for all PLB widgets and refreshes the list in toolbox
		refresh : function () {
			this.refreshTimer.stop();
			
			$().log('refreshing wigdets list...','PLB');
			// Find all PLB widgets in the editor
			var l = this.ed.getWidgets();
			// Clear list in the toolbox
			this.widgetsList.empty();
			// Prepare buttons overlay for list items
			var bs = "<button class=\"wikia-button edit\">"+PLB.Lang['plb-editor-edit']+"</button><a href=\"#\" class=\"delete\"></a>";
			// For each widget found do ...
			$.each(l,$.proxy(function(i,e){
				var html = PLB.Library[e.getType()].listItemHtml
					.replace("[$ID]",e.getId())
					.replace("[$CAPTION]",e.getCaption())
					.replace("[$BUTTONS]",bs);
				$(html).appendTo(this.widgetsList);
			},this));
			// Set visibility of list depending on whether we have any element or not
			this.widgetsList.css('display',l.length>0?"block":"none");
			// Substitute the overall count of widgets in the list header
			$('.plb-widgets-count',this.el).html(l.length);
			// Visual hovering - bind to mouseenter and mouseout of each child
			this.widgetsList.children()
				.bind({
					mouseenter: $.proxy(this.onMouseEnter,this),
					mouseout: $.proxy(this.onMouseOut,this)
				});
			// Bind to the edit and delete buttons from the overlay
			$('.edit',this.widgetsList).click($.proxy(this.onItemEditClick,this));
			$('.delete',this.widgetsList).click($.proxy(this.onItemDeleteClick,this));
		},
		
		onMouseEnter : function (e) {
			$(e.target).addClass('hover');
		},
		
		onMouseOut : function (e) {
			$(e.target).removeClass('hover');
		},
		
		// Handle click on edit button in the widgets list
		onItemEditClick : function (e) {
			var el = $(e.target).closest('li');
			var id = el.attr('__plb_id');
			this.fire('edit',id);
			return false;
		},
		
		// Handle click on delete button in the widgets list
		onItemDeleteClick : function (e) {
			var el = $(e.target).closest('li');
			var id = el.attr('__plb_id');
			this.fire('delete',id);
			return false;
		},

		// Handle click on add element button
		onAddElementClick : function (e) {
			var el = $(e.target);
			this.addButton.removeClass('hover');
			this.fire('create',el.attr(PLB.PARAM_TYPE));
			return false;
		},
		
		onOverlayEditClick : function(node) {
			this.fire('edit',$(node));
		}
		
	});
	
	PLB.PropertyEditor = $.createClass(Observable,{
		
		width: 400,
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
			$('[name],',this.form).change($.proxy(this.onChange,this));
			$('[name],',this.form).blur($.proxy(this.onChange,this));
			$('input[name], textare[name]',this.form).keyup($.proxy(this.onChange,this));
			this.onChange();

			// Show modal box
			var mopts = {
				onClose: $.proxy(this.doDismiss,this),
				closeOnBlackoutClick: false,
				width: this.width
			};
			this.wrapper = this.form.makeModal(mopts);
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
					el.attr('checked', value ? true : false );
				} else {
					el.val(value);
				}
			}
			var state = { value: value };
			this.extFormSetValue(name,state);
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
			this.showValidation();
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
			}
			box.html(msg.join('<br />'));
		},
		
		onChange: function(ev) {
			this.updateValues();
			this.extFormChange(ev);
			this.validate();
			this.saveButton.attr('disabled',this.valid?'':'disabled');
		},
		
		doSave: function() {
			this.updateValues();
			this.validate();
			if (this.saveButton.attr('disabled') == 'disabled') {
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
		extFormChange: function() {}
		
	});
	
	PLB.PropertyEditors = {};
	
	PLB.PropertyEditors['plb_image'] = $.createClass(PLB.PropertyEditor,{
		
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
		}
	
	});

	PLB.PropertyEditors['plb_sinput'] = $.createClass(PLB.PropertyEditor,{
		
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
						ll.push(v);
				});
				state.value = ll.join('|');
			}
		},
		
		extFormSetValue: function(name,state) {
			if (name == 'options') {
				var l = String(state.value).split('|');
				var ll = [];
				$.each(l,function(i,v){
					if (v != '')
						ll.push(v);
				});
				this.writeValue('x-options',ll.join('\n'));
			}
		}
	
	});
	
	PLB.PropertyEditor.create = function ( type, values ) {
		if (typeof PLB.PropertyEditors[type] == 'undefined') {
			PLB.PropertyEditors[type] = PLB.PropertyEditor;
		}
		return new PLB.PropertyEditors[type](type,values);
	};
	
	window.plb = new PLB.Editor();	
	
})();
