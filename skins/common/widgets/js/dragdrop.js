var carousel;
var c_size;
var pagerefresh = 0;

// macbre: user agent detection array
var userAgent =
{
	'ie':       (navigator.appVersion.indexOf("MSIE")!=-1) && (navigator.userAgent.indexOf("Opera")==-1),
	'opera': (navigator.userAgent.indexOf("Opera")!=-1),
	'firefox': (navigator.userAgent.indexOf("Firefox")!=-1)
};


// opera fix
// @see http://hcmc.uvic.ca/blogs/index.php?blog=25&p=2031&more=1&c=1&tb=1&pb=1
if(!Array.indexOf){
    Array.prototype.indexOf = function(obj){
        for(var i=0; i<this.length; i++){
            if(this[i]==obj){
                return i;
            }
        }
	return -1;
    }
}


// macbre: fixes for IE
//
function fixIEwidget(widgetContentId)
{
	// only apply for buggy IE
	if (!userAgent.ie) return;

	var widget = YAHOO.util.Dom.get(widgetContentId);

	if (!widget) return;

	var div = document.createElement('div');
	div.innerHTML = 'foo';
	div.style.display = 'none';

	widget.appendChild(div);

	div.parentNode.removeChild(div);

	//console.log(widget);

	//alert(widget.id);
}

function fixIEwidgets(widgets)
{
	//console.log(widgets);

	if (userAgent.ie)
	{
		for (var w in widgets)
		{
			setTimeout('fixIEwidget("' + widgets[w] + '_inner' + '")', 10);
		}
	}
}



//
// dragdrop starts from here...
//

YAHOO.namespace('w');

(function() {

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

YAHOO.w.DragDrop = {

	// add event listeners for show and hide cockpit
	init: function() {
		YAHOO.widget.Logger.log('YAHOO.w.DragDrop.init-in');

		Event.addListener('um-cockpit_show', 'click', YAHOO.w.DragDrop.enableDragAndDrop);
		Event.addListener('cockpit_hide', 'click', YAHOO.w.DragDrop.disableDragAndDrop);

		// initialize widgets, but don't show cockpit - simulate click on "Manage widgets" with event set to false
		// but only for logged in users
		if (wgUserName)
		{
			YAHOO.w.DragDrop.enableDragAndDrop(false);

			// show tooltip (after 2-3 sec) for new users not familiar with widgets

			/*
			if (wgWidgetsDefaultScheme)
			{
				setTimeout(function()
				{
					tooltip = new wikiaTooltip();
					tooltip.init(wgWidgetMsg.helpStartup, 5000, true);
					tooltip.show(Dom.get('welcome').clientWidth - 60, 25, 'Welcome');
					//console.log(Dom.get('welcome').clientWidth);
				}, 2000);
			}
			*/
		}

		YAHOO.widget.Logger.log('YAHOO.w.DragDrop.init-out');
	},

	disableDragAndDrop: function(e) {
		Dom.setStyle('widget_cockpit', 'display', 'none');
		/**
		Dom.removeClass( Dom.getElementsByClassName('draggable'), 'draggable');
		DDM.unregAll();
		**/

		dashboards = Dom.getElementsByClassName('dashboard');
		if ( dashboards && dashboards.length > 0 ) {
			Dom.setStyle(Dom.getElementsByClassName('dashboard'), 'background', 'none');
		}

		// macbre: hide widget toolboxes
		/**
		toolboxes = Dom.getElementsByClassName('widgetToolbox');

		if ( toolboxes && toolboxes.length > 0 ) {
			Dom.setStyle(Dom.getElementsByClassName('widgetToolbox'), 'display', 'none');
		}
		**/

		YAHOO.w.DragDrop.enabled = false;

		Event.preventDefault(e);
	},

	enableDragAndDrop: function(e) {
		YAHOO.widget.Logger.log('YAHOO.w.enableDragAndDrop-in');

		// prevent processing too many times
		if ( ! YAHOO.w.DragDrop.enabled ) {

			// assign widget settings list to an object variable and then use only that object variable
			//if ( ! YAHOO.w.DragDrop.settings ) { // macbre: rebuild curInstances every time user opens cockpit
				YAHOO.w.DragDrop.settings = GetWidgetsList();
			//}

			// macbre: show cockpit only on click event
			if (e != false) YAHOO.w.DragDrop.showCockpit();

			// init every widget thumb element as a widget thumb object
			var items = Dom.getElementsByClassName('widget_thumb', 'li');
			for(var i = 0; i < items.length; i++) {
				if ( items[i].parentNode.id != 'widgets_1' ) {
					new YAHOO.w.DD(items[i].id);
				}
			}

			// Special:Widgets - init every thumb in list as draggable (only when logged in)
			var widgetsList = Dom.get('widgetsSpecialPageList');

			if (widgetsList && wgUserName)
			{
				var items = Dom.getElementsByClassName('widget_thumb', 'div');
				for(var i = 0; i < items.length; i++)
				{
						new YAHOO.w.DD(items[i].id);
				}
			}


			// init every widget element as a widget object
			var items = Dom.getElementsByClassName('widget', 'li');
			for(var i = 0; i < items.length; i++) {
				if ( (items[i].parentNode.id != 'widgets_1') && (items[i].id != '' /* #2155 */) )
				{
					w  = new YAHOO.w.DD(items[i].id);

					// macbre: really strange hack, but hey - it works!
					this.DDM = YAHOO.util.DragDropMgr;

					try
					{
						//console.log('setHandleId: ' + items[i].id.replace( '_wg', '_header' ) );
						w.setHandleElId( items[i].id.replace( '_wg', '_header' ) );
					}
					catch(ex) {}
				}
			}


			// init every widget panel as drag drop target
			var items = Dom.getElementsByClassName('widgets', 'ul');
			for ( var i = 0; i < items.length; i++ ) {
				if ( (items[i].id != 'widgets_1') && (items[i].id != '' /* #2155 */) ) {
					w = new YAHOO.util.DDTarget(items[i].id);
					w.setHandleElId( items[i].id.replace( '_wg', '_header' ) );
				}
			}

			dashboards = Dom.getElementsByClassName('dashboard');
			if ( dashboards && dashboards.length > 0 ) {
				Dom.setStyle(Dom.getElementsByClassName('dashboard'), 'background', '#fafafa');
			}

			// macbre: show cockpit only on click event
			if (e != false) YAHOO.w.DragDrop.enabled = true;
		}

		Event.preventDefault(e);

		YAHOO.widget.Logger.log('YAHOO.w.enableDragAndDrop-out');
	},

	showCockpit: function() {
		YAHOO.widget.Logger.log('YAHOO.w.showCockpit-in');

		// prevent processing too many times
		if ( ! YAHOO.w.DragDrop.cockpit ) {
			var cockpit_ul = Dom.get('widget_cockpit_list');
			// generate <li> for every listable widget thumb and add it to <ul> in cockpit

			c_size = 0;

			//console.log('User groups: ' + wgUserGroups.toString());

			for ( var i in YAHOO.w.DragDrop.settings )
			{
				// check privileges for showing widget in cockpit - default: don't allow
				var allow = false;

				if (YAHOO.w.DragDrop.settings[i].usergroups && YAHOO.w.DragDrop.settings[i].usergroups.length)
				{
					// loop through requested groups
					for (g in YAHOO.w.DragDrop.settings[i].usergroups)
					{
						allow = (wgUserGroups.indexOf(YAHOO.w.DragDrop.settings[i].usergroups[g]) != -1) ? true : allow;
					}
				}
				else
				{
					// no access restrictions
					allow = true;
				}

				//console.log('Widget: ' + i +' - ' + YAHOO.w.DragDrop.settings[i].usergroups.toString() +' (allow: ' + allow.toString() + ')');
				//alert('Widget: ' + i +' - ' + YAHOO.w.DragDrop.settings[i].usergroups.toString() +' (allow: ' + allow.toString() + ')');

				if ( YAHOO.w.DragDrop.settings[i].listable == true && allow == true)
				{
					c_size++;
					var temp_el = document.createElement('li');
					temp_el.id = 'mycarousel-item-'+c_size;

					var name = YAHOO.w.DragDrop.settings[i].name[wgUserLanguage];
					if ( YAHOO.lang.isUndefined ( name ) ) {
						name = YAHOO.w.DragDrop.settings[i].name.en;
					}

					var desc = YAHOO.w.DragDrop.settings[i].desc[wgUserLanguage];
					if ( YAHOO.lang.isUndefined ( desc ) ) {
						desc = YAHOO.w.DragDrop.settings[i].desc.en;
					}

					temp_el.innerHTML = name;
					temp_el.className = 'widget_thumb ' + i +'Thumb'; // macbre: change for adding icons in CSS
					temp_el.name = i + '_thumb';
					temp_el.desc = desc;
					temp_el.title = desc;

					YAHOO.util.Event.addListener( temp_el, 'mouseover', widgetOver );
					YAHOO.util.Event.addListener( temp_el, 'mouseout', widgetOut );

					cockpit_ul.appendChild(temp_el);
				}
			}

			var prevButton_callback = function (type, args) {
				var enabling = args[0];
				var leftImage = args[1];

				if(enabling) {
					leftImage.src = "http://images.wikia.com/common/left-enabled.gif";
				} else {
					leftImage.src = "http://images.wikia.com/common/left-disabled.gif";
				}
			};

			var nextButton_callback = function (type, args) {
				var enabling = args[0];
				var leftImage = args[1];

				if(enabling) {
					leftImage.src = "http://images.wikia.com/common/right-enabled.gif";
				} else {
					leftImage.src = "http://images.wikia.com/common/right-disabled.gif";
				}
			};

			carousel = new YAHOO.extension.Carousel("mycarousel",
		                {
		                        animationSpeed: 0.15,
		                        navMargin: 0,
		                        prevElement: "prev-arrow",
		                        nextElement: "next-arrow",
		                        prevButtonStateHandler: prevButton_callback,
		                        nextButtonStateHandler: nextButton_callback,
		                        size: c_size,
		                        wrap: true
		                });
			YAHOO.w.DragDrop.cockpit = true;

			// show tooltip (after 1 sec) for new users not familiar with widgets
			/*
			if (wgWidgetsDefaultScheme)
			{
				setTimeout(function()
				{
					tooltip = new wikiaTooltip();
					tooltip.init(wgWidgetMsg.helpCockpit +
					       '<div style="text-align: right; border-top: solid 1px #666666; padding-top: 5px; margin-top: 5px">' + wgWidgetMsg.helpSidebar + '</div>', 15000, true);
					tooltip.show(YAHOO.util.Dom.getX('sidebar') - 80, 85, 'Sidebar');
					//console.log(Dom.get('welcome').clientWidth);
				}, 1000);
			}
			*/
		}

		Dom.setStyle('widget_cockpit', 'display', '');

		YAHOO.widget.Logger.log('YAHOO.w.showCockpit-out');

		setCarouselNumVisible();
	},

	getWidgetName: function(id) {
		el = document.getElementById( id );
		if( el.name )
		{
			n = el.name;
		}
		else n = id;
		return n.split('_')[0];
	},

	isCorrectPanel: function(widgetType, panelId) {
		if ( ! YAHOO.lang.isNumber ( panelId ) ) {
			panelId = panelId.split('_')[1];
		}
		for( var i = 0; i < YAHOO.w.DragDrop.settings[widgetType].available.length; i++ ) {
			if ( YAHOO.w.DragDrop.settings[widgetType].available[i] == panelId ) {
				return true;
			}
		}
		return false;
	},

	getIndex: function(el) {
		Dom.addClass('ghost', 'widget');
		var items = Dom.getElementsByClassName('widget', 'li', el.parentNode.id);
		for(var i = 0; i < items.length; i++) {
			if(items[i].id == el.id) {
				Dom.removeClass('ghost', 'widget');
				return i + 1;
			}
		}
		Dom.removeClass('ghost', 'widget');
	}

};

YAHOO.w.DD = function(itemId) {
	YAHOO.widget.Logger.log('YAHOO.w.DD-in');

	// determine if is it widget thumb
	this.isThumb = YAHOO.util.Dom.hasClass(itemId, 'widget_thumb'); // macbre: opera & ie fix

	// determine widget type name
	this.widgetType = YAHOO.w.DragDrop.getWidgetName(itemId);

	if ( !this.isThumb && YAHOO.w.DragDrop.settings[this.widgetType] ) {

		if ( ! YAHOO.w.DragDrop.settings[this.widgetType].draggable ) {

			new YAHOO.util.DDTarget(itemId);

		} else {

			// initiate element as a dragable object with proxy
			YAHOO.w.DD.superclass.constructor.call(this, itemId, null, null);

			//console.log(itemId);

			// set additional handles
			if ( YAHOO.w.DragDrop.settings[this.widgetType].handlecount > 0 ) {
				for( var i = 0; i < YAHOO.w.DragDrop.settings[this.widgetType].handlecount; i++ ) {
					this.setHandleElId( itemId + '_' + i );
					Dom.addClass( itemId + '_' + i, 'draggable');
				}
			} else {
				Dom.addClass( itemId, 'draggable' );
			}
		}

		// update instance counter
		YAHOO.w.DragDrop.settings[this.widgetType].curinstances++;

		// get widget atributes from JSON table
		var widgetAtribs = YAHOO.w.DragDrop.settings[this.widgetType];

		// macbre: do not allow adding more instance of that widget - maxInstances reached
		if (widgetAtribs.maxinstances > 0 && widgetAtribs.maxinstances <= widgetAtribs.curinstances)
		{
			// add "blocked" class to thumb in cockpit
			var cockpit = Dom.get('widget_cockpit_list').childNodes;

			for (c in cockpit)
			{
				if (cockpit[c].name == this.widgetType + '_thumb') Dom.addClass(cockpit[c], 'blocked');
			}

			// add "blocked" class to thumb on Special:Widgets
			var specialPageList = Dom.get('widgetsSpecialPageList');

			if (specialPageList)
			{
				//var thumbs = Dom.getElementsByClassName('widget_thumb', 'div', specialPageList);
				var thumb = Dom.get(this.widgetType + '_widgets-list');

				if (thumb)
				{
					Dom.addClass(thumb, 'blocked');
					Dom.addClass(thumb.parentNode.parentNode, 'blocked');
				}
			}
		}

		// macbre: show widget toolbox - close / edit / hide
		if (widgetAtribs.closeable || widgetAtribs.editable) // || widgetAtribs.hideable)
		{
			// hide this widget toolbox node - clear it and add apprioprate links
			toolbox = YAHOO.util.Dom.get(this.id.substr(0, this.id.length - 3) + '_toolbox');

			if (toolbox)
			{
				// generate toolbox only once then store it in HTML
				if (toolbox.innerHTML == '')
				{
					// show 'show/hide' button
					if (widgetAtribs.hideable)
					{
						var toogleButton = document.createElement('span');

						toogleButton.id = itemId + '_toolbox_toogle';
						//editButton.innerHTML = 'edit';
						toogleButton.innerHTML = wgWidgetMsg.toogleMsg;
						toogleButton.title = wgWidgetMsg.toogleTitle;
						Dom.addClass(toogleButton, 'toogleButton');
						toolbox.appendChild(toogleButton);

						// add onClick listener
						Event.addListener(toogleButton, 'click', this.toogleWidget);
					}

					// show 'edit' button
					if (widgetAtribs.editable)
					{
						var editButton = document.createElement('span');

						editButton.id = itemId + '_toolbox_edit';
						//editButton.innerHTML = 'edit';
						editButton.innerHTML = wgWidgetMsg.editMsg;
						editButton.title = wgWidgetMsg.editTitle;
						Dom.addClass(editButton, 'editButton');
						toolbox.appendChild(editButton);

						// add onClick listener
						Event.addListener(editButton, 'click', this.toogleEditor);
						Event.addListener(Dom.get(itemId.substr(0, itemId.length - 3)+'_editorCancel'), 'click', this.toogleEditor);
					}

					// show 'x' (close) button
					if (widgetAtribs.closeable)
					{
						var closeButton = document.createElement('span');

						closeButton.id = itemId + '_toolbox_close';
						closeButton.innerHTML = 'x';
						closeButton.title = wgWidgetMsg.closeTitle;
						Dom.addClass(closeButton, 'closeButton');
						toolbox.appendChild(closeButton);

						// add onClick listener
						Event.addListener(closeButton, 'click', this.close);
					}
				}

				// show toolbox
				toolbox.style.display = 'block';
			}
		}

		Dom.addClass( itemId, 'draggable' );

		// try to start additional JS function handling widget specific staff after adding it to sidebar (like WidgetCountdownOnAdd)
		try
		{
			// macbre: keep ID as <widgetType>_<widgetInstance> (get rid of _wg suffix)
			eval( this.widgetType + 'OnAdd({id: "' + itemId.split('_')[0] + '_' + itemId.split('_')[1] + '"});' );
		}
		catch(ex) {}


	} else {

		// initiate widget thumb element as a dragable object
		YAHOO.w.DD.superclass.constructor.call(this, itemId, null, null);
		Dom.addClass( itemId, 'draggable' );

	}

	// the proxy is slightly transparent
	Dom.setStyle(this.getDragEl(), 'opacity', 0.67);

	// defaults
	this.goingUp = false;
	this.lastY = 0;

	YAHOO.widget.Logger.log('YAHOO.w.DD-out');
};

YAHOO.extend(YAHOO.w.DD, YAHOO.util.DDProxy, {

	reorder: function() {
		var clickEl = this.getEl();
		id = clickEl.id;
		column = clickEl.parentNode.id.split('_')[1];
		position = YAHOO.w.DragDrop.getIndex(clickEl);

		// macbre: dirty hack for IE6
		//
		if (userAgent.ie)  setTimeout('fixIEwidget("' + id.substr(0, id.length - 3) + '_inner' + '")', 10);

		var transaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath+'/widgetstart.php?reorder=' + id + ':' + column + ':' + position);

		if ( !pagerefresh ) {
			YAHOO.util.Connect.asyncRequest('POST', window.location.href, null, "action=purge");
			pagerefresh = 1;
		}
	},

	// close widget
	close: function(e,a) {
		var widgetFullName = this.parentNode.parentNode.id;
		var widgetName = this.parentNode.parentNode.id.split('_')[0];
		var widgetInstance = this.parentNode.parentNode.id.split('_')[1];

		var transaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath+'/widgetstart.php?name=' + widgetName + '&instance=' + widgetInstance + '&removerequest=true');

		//Dom.setStyle(this.parentNode.parentNode, 'display', 'none');

		// macbre: remove the widget <li> instead of hiding it
		Dom.get(widgetFullName).parentNode.removeChild(Dom.get(widgetFullName));

		var widgetAtribs = YAHOO.w.DragDrop.settings[widgetName];

		widgetAtribs.curinstances--;

		// macbre: do not allow adding more instance of that widget - maxInstances reached (show again)
		if (widgetAtribs.maxinstances > 0 && widgetAtribs.maxinstances > widgetAtribs.curinstances)
		{
			 // disable drag&drop for this element
			//this.unreg();

			// remove "blocked" class from thumb in cockpit
			var cockpit = Dom.get('widget_cockpit_list').childNodes;

			for (c in cockpit)
			{
				if (cockpit[c].name == widgetName + '_thumb') Dom.removeClass(cockpit[c], 'blocked');
			}

			// remove "blocked" class from thumb on Special:Widgets
			var specialPageList = Dom.get('widgetsSpecialPageList');

			if (specialPageList)
			{
				//var thumbs = Dom.getElementsByClassName('widget_thumb', 'div', specialPageList);
				var thumb = Dom.get(widgetName + '_widgets-list');

				if (thumb)
				{
					Dom.removeClass(thumb, 'blocked');
					Dom.removeClass(thumb.parentNode.parentNode, 'blocked');
				}
			}

		}
		
		// try to start additional JS function handling widget specific staff after removing it from sidebar (like WidgetSlideshowOnClose)
		try
		{
			eval( widgetName + 'OnClose({id: "' + widgetName + '_' + widgetInstance + '"});' );
		}
		catch(ex) {}

		if ( !pagerefresh ) {
			YAHOO.util.Connect.asyncRequest('POST', window.location.href, null, "action=purge");
			pagerefresh = 1;
		}
	},

	// toogles widget editor and content
	toogleWidget: function(e) {

		var widgetId = this.id.split('_')[0] + '_' + this.id.split('_')[1];

		//console.log('Toogle' + widgetId);

		switch( Dom.getStyle(widgetId + '_content','display') == 'none' )
		{
			case true:
				// show widget content
				Dom.get(widgetId+'_header').className = 'boxHeader';

				Dom.setStyle(widgetId+'_editor',     'display', 'none');

				YAHOO.Tools.setCookie(widgetId + '_hidden', 0, new Date(2030,0,1));

				// animate
				Dom.setStyle(widgetId+'_content',  'display', 'block');

				var widgetHeight = parseInt(Dom.getStyle(widgetId + '_content', 'marginBottom'))  < 0 ? parseInt(Dom.getStyle(widgetId + '_content', 'marginBottom')) * -1 : parseInt(Dom.get(widgetId).offsetHeight) - 38;

				var toogleAnim = new YAHOO.util.Anim(widgetId + '_content', {marginBottom: {to: 0, from: widgetHeight * -1, unit: 'px' }}, 0.25);

				toogleAnim.onComplete.subscribe(function() {
					Dom.setStyle(widgetId+'_content',  'display', 'block');
					Dom.get(widgetId+'_header').className = 'boxHeader';
				});

				toogleAnim.animate();
				break;

			case false:
				// hide widget content
				YAHOO.Tools.setCookie(widgetId + '_hidden', 1, new Date(2030,0,1));

				// animate
				var widgetHeight = parseInt(Dom.get(widgetId).offsetHeight) - 38;

				var toogleAnim = new YAHOO.util.Anim(widgetId + '_content', {marginBottom: {from: 0, to: widgetHeight * -1, unit: 'px' }}, 0.25);

				toogleAnim.onComplete.subscribe(function() {
					Dom.setStyle(widgetId+'_content',  'display', 'none');
					Dom.setStyle(widgetId+'_editor',     'display', 'none');
					Dom.get(widgetId+'_header').className = 'boxHeader_noBorderMargin';
				});

				toogleAnim.animate();
				break;
		}

	},

	// toogles widget editor and content
	toogleEditor: function(e,a) {

		var widgetId = this.id.split('_')[0] + '_' + this.id.split('_')[1];

		var editor  = Dom.get(widgetId + '_editor');
		var content = Dom.get(widgetId + '_content');

		switch( Dom.getStyle(editor,'display') == 'none' )
		{
			case true:
				// show editor
				Dom.setStyle(editor,  'display', 'block');
				Dom.setStyle(content, 'display', 'none');

				Dom.get(widgetId+'_header').className = 'boxHeader';

				if (userAgent.ie)  setTimeout('fixIEwidget("' + widgetId + '_inner' + '")', 10);

				break;

			case false:
				// hide editor
				Dom.setStyle(editor,  'display', 'none');
				Dom.setStyle(content, 'display', 'block');
				Dom.setStyle(content, 'marginBottom', '0px');

				if (userAgent.ie)  setTimeout('fixIEwidget("' + widgetId + '_inner' + '")', 10);

				break;
		}

	},

	process: function() {

		var clickEl = this.getEl();
		//name = clickEl.id.split('_')[0];
		name = YAHOO.w.DragDrop.getWidgetName(clickEl.id);

		var ghost = Dom.get('ghost');
		column = ghost.parentNode.id.split('_')[1];

		position = YAHOO.w.DragDrop.getIndex(ghost);

		var process_callback = {
			success: function(o) {
				var res = o.responseText;
				res = res.replace(/\n/g, "\\n");

				// get rid of stupid BOM bug in Opera
				res = res.substr(res.indexOf("{"), res.length);

				//opera.postError(res);

				res_array = eval ( '(' + res + ')' );

				//opera.postError(res_array);

				var parent = ghost.parentNode;
				newEl = document.createElement('li');
				newEl.id = res_array.id + '_wg'; //< macbre: add _wg for consistency with widgets generated at page load
				newEl.innerHTML = res_array.content
				Dom.addClass(newEl, 'widget');
				Dom.addClass(newEl, res_array.className);

				// macbre: remove widget loading placeholder (prevent error reported by TOR)
				var loader = Dom.get(res_array.id.split('_')[0] + '_loading');

				//console.dir(loader);console.dir(res_array);

				loader.parentNode.removeChild(loader);

				// insert loaded widget
				parent.insertBefore(newEl, ghost.nextSibling);

				// macbre: dirty hack for IE6
				//
				if (userAgent.ie) setTimeout('fixIEwidget("' + res_array.id + '_inner' + '")', 10);

				// add widget to drag&drop
				w = new YAHOO.w.DD(newEl.id);
				w.setHandleElId(res_array.id + '_header');

				// update widgets constraints
				var constraints = YAHOO.w.DragDrop.settings[res_array.id.split('_')[0]]; // get this widget constraints array

				//constraints.curinstances++; // done by YAHOO.w.DD

				// macbre: do not allow adding more instance of that widget - maxInstances reached
				if (constraints.maxinstances > 0 && constraints.maxinstances <= constraints.curinstances)
				{
					// add "blocked" class to thumb in cockpit
					var cockpit = Dom.get('widget_cockpit_list').childNodes;

					// we don't have ID set, so we need to scan whole cockpit to find widget thumb
					for (c in cockpit)
					{
						if (cockpit[c].name == res_array.id.split('_')[0] + '_thumb') Dom.addClass(cockpit[c], 'blocked');
					}

					// add "blocked" class to thumb on Special:Widgets
					var specialPageList = Dom.get('widgetsSpecialPageList');

					if (specialPageList)
					{
						//var thumbs = Dom.getElementsByClassName('widget_thumb', 'div', specialPageList);
						var thumb = Dom.get(res_array.id.split('_')[0] + '_widgets-list');

						if (thumb)
						{
							Dom.addClass(thumb, 'blocked');
							Dom.addClass(thumb.parentNode.parentNode, 'blocked');
						}
					}

				}

				// set cookie - is widget content hidden
				YAHOO.Tools.setCookie(res_array.id + '_hidden', (constraints.hidden == true ? '1': '0'), new Date(2030,0,1));


				// try to start additional JS function handling widget specific staff after adding it to sidebar (like WidgetCountdownOnAdd)
				try
				{
					// macbre: keep ID as <widgetType>_<widgetInstance> (get rid of _wg suffix)
					var params = {id: res_array.id.split('_')[0] + '_' + res_array.id.split('_')[1]};
					eval( res_array.id.split('_')[0] + 'OnAdd(params);' );
				}
				catch(ex) {}

			},
			failure: function(o) { alert('error'); }
		}

		Dom.setStyle('ghost', 'display', 'none');

		// macbre: add widget loading indicator with kreciolek

		var constraints = YAHOO.w.DragDrop.settings[name]; // get this widget constraints array

		title = constraints.name[wgUserLanguage] ?  constraints.name[wgUserLanguage] :  constraints.name.en;

		var parent = ghost.parentNode;
		loadingEl = document.createElement('li');
		loadingEl.id = name + '_loading';
		loadingEl.innerHTML = '<h1 class="loading">' + title + '</h1>';
		Dom.addClass(loadingEl, 'widget widgetLoading');
		Dom.setStyle(loadingEl, 'opacity', '0');

		ghost.parentNode.insertBefore(loadingEl, ghost.nextSibling);

		// animate
		var loadingAnim = new YAHOO.util.Anim(loadingEl, {opacity: {from: 0, to:1}}, 1);
		loadingAnim.animate();

		// send request
		transaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/widgetstart.php?skin=ajaxslate&ajax=full&name=' + name + '&column=' + column + '&position=' + position + '&articleid=' + wgArticleId, process_callback, null);

		if ( !pagerefresh ) {
			YAHOO.util.Connect.asyncRequest('POST', window.location.href, null, "action=purge");
			pagerefresh = 1;
		}
	},

	startDrag: function(x, y) {
		var clickEl = this.getEl();
		var dragEl = this.getDragEl();

		if ( this.isThumb == false ) {
			Dom.setStyle(clickEl, 'visibility', 'hidden');
		}
		else
		{
			// check if we can drag&drop that element
			if (Dom.hasClass(clickEl, 'blocked'))
			{
				Dom.setStyle(dragEl, 'visibility', 'hidden');
			}
		}
	},

	endDrag: function(e) {

		// ignore end of draging blocked thumbs
		if (Dom.hasClass(this.getEl(),'blocked'))
			return;

		var srcEl;

		// for widget thumb use 'ghost' as source element
		if ( this.isThumb == true ) {
			srcEl = Dom.get('ghost');
			if ( Dom.getStyle(srcEl, 'display') == 'none' ) {
				srcEl = this.getEl();
			}
		} else {
			srcEl = this.getEl();
		}

		var proxy = this.getDragEl();

		// Show the proxy element and animate it to the src element's location
		Dom.setStyle(proxy, 'visibility', '');
		var a = new YAHOO.util.Motion(
			proxy, {
				points: {
					to: Dom.getXY(srcEl)
				}
			},
			0.2,
			YAHOO.util.Easing.easeOut
		)
		var proxyid = proxy.id;
		var thisid = this.id;

		// Hide the proxy and show the source element when finished with the animation
		a.onComplete.subscribe(function() {
			Dom.setStyle(proxyid, 'visibility', 'hidden');
			Dom.setStyle(thisid, 'visibility', '');
		});
		a.animate();

		if ( this.isThumb == true ) {
			if ( Dom.getStyle('ghost', 'display') == 'block' ) {
				this.process();
			}
		} else {
			this.reorder();
		}
	},

	onDragOver: function(e, id) {
		var destEl = Dom.get(id);
		var srcEl;

		// don't process if someone drag widget/thumb on thumb
		if (Dom.hasClass(destEl, 'widget_thumb')) {
			return;
		}

		if (destEl.nodeName.toLowerCase() == 'li') {

			// don't process if someone drag widget/thumb on wrong panel
			if ( ! YAHOO.w.DragDrop.isCorrectPanel(this.widgetType, destEl.parentNode.id) ) {
				return;
			}

			// for widget thumb use 'ghost' as source element and make it visible
			if ( this.isThumb == true ) {
				srcEl = Dom.get('ghost');
				Dom.setStyle('ghost', 'display', 'block');
			} else {
				srcEl = this.getEl();
			}

			var p = destEl.parentNode;

			if (this.goingUp) {
				p.insertBefore(srcEl, destEl); // insert above
			} else {
				p.insertBefore(srcEl, destEl.nextSibling); // insert below
			}

			DDM.refreshCache();
		}
	},

	onDragDrop: function(e, id) {
		// If there is one drop interaction, the li was dropped either on the list,
		// or it was dropped on the current location of the source element.
		if (DDM.interactionInfo.drop.length === 1) {

			if ( Dom.get(id).nodeName.toLowerCase() == 'ul' && ! (this.isThumb == true && Dom.getStyle('ghost', 'display') == 'block') ) {

				if ( ! YAHOO.w.DragDrop.isCorrectPanel(this.widgetType, id) ) {
					return;
				}

				// The position of the cursor at the time of the drop (YAHOO.util.Point)
				var pt = DDM.interactionInfo.point;

				// The region occupied by the source element at the time of the drop
				var region;

				// for widget thumb get region of ghost element

				if ( this.isThumb == true ) {
					region = Dom.getRegion('ghost');
				} else {
					region = DDM.interactionInfo.sourceRegion;
				}

				// Check to see if we are over the source element's location.  We will
				// append to the bottom of the list once we are sure it was a drop in
				// the negative space (the area of the list without any list items)
				if (!region || !region.intersect(pt)) {

					var destEl = Dom.get(id);
					var destDD = DDM.getDDById(id);

					if ( this.isThumb == true ) {
						Dom.setStyle('ghost', 'display', 'block');
						destEl.appendChild(Dom.get('ghost'));
					} else {
						destEl.appendChild(this.getEl());
					}

					destDD.isEmpty = false;
					DDM.refreshCache();
				}
			}
		}
    },

	onDragOut: function(e, id) {
		if ( this.isThumb == true && Dom.get(id).nodeName.toLowerCase() == "ul" ) {
			Dom.setStyle('ghost', 'display', 'none');
		}
	},

    onDrag: function(e) {

		// Keep track of the direction of the drag for use during onDragOver
		var y = Event.getPageY(e);

		if (y < this.lastY) {
			this.goingUp = true;
		} else if (y > this.lastY) {
			this.goingUp = false;
		}

		this.lastY = y;

		// macbre: do not allow widget thumb to go outside the browser' viewport
		var rightEdge = parseInt(Dom.getStyle(this.getDragEl(), 'left')) + parseInt(Dom.getStyle(this.getDragEl(), 'width'));
		var viewport  = Dom.getViewportWidth();

		if (viewport > 0 && rightEdge > viewport)
		{
			Dom.setStyle(this.getDragEl(), 'left', viewport - parseInt(this.getDragEl().style.width) + 'px');
			//console.log('--');
		}
    }

});

Event.onDOMReady(YAHOO.w.DragDrop.init, YAHOO.w.DragDrop, true);

})();

//send data to widget start and refresh the widget content and title
function refreshWidgetSuccess(o){

	var res = o.responseText;
	res = res.replace(/\\n/g, "\n");

	switch(o.argument.resultType)
	{
		// json array
		case 'internal':
			// get rid of stupid BOM bug in Opera
			res = res.substr(res.indexOf("{"), res.length);

			var widget = eval ( '(' + res + ')' );

			break;

		// just HTML
		case 'html':
			var widget = {'content': res, 'id': o.argument.widgetId};
	}

	// update widget title & content
	if (widget.title) {
		YAHOO.util.Dom.get(widget.id + '_header').innerHTML  = widget.title;
	}
	YAHOO.util.Dom.get(widget.id + '_content').innerHTML = widget.content;

	// remove widget loading icon
	YAHOO.util.Dom.removeClass(widget.id + '_wg', 'widgetLoading');

	if ( YAHOO.util.Dom.get(widget.id + '_editorSubmit') ) {
		// clean-up
		YAHOO.util.Dom.get(widget.id + '_editorSubmit').disabled = false;
		YAHOO.util.Dom.removeClass(widget.id + '_editor', 'progress');

		// hide editor - show content & header border
		YAHOO.util.Dom.setStyle(widget.id + '_editor',  'display', 'none');
		YAHOO.util.Dom.setStyle(widget.id + '_content', 'display', 'block');
		YAHOO.util.Dom.setStyle(widget.id + '_content', 'marginBottom', '0px');
		YAHOO.util.Dom.get(widget.id+'_header').className = 'boxHeader';

		// save to cookie
		YAHOO.Tools.setCookie(widget.id + '_hidden', 0, new Date(2030,0,1));
	}

	// try to start additional JS function handling widget specific staff after update (like WidgetCountdownOnUpdate)
	try
	{
		eval( widget.id.split('_')[0] + 'OnUpdate(widget);' );
	}
	catch(ex) {}
}

// refresh widget widgetId content with GET params from editor
function refreshWidget(params, widgetId, postData, resultType){

	if (!resultType)
		resultType = 'internal';

	// send AJAX request
	var process_callback = {
		success: refreshWidgetSuccess,
		failure: function(o) { alert('error when sending AJAX request'); },
		argument: { widgetId : widgetId, resultType: resultType }
	}

	if ( postData ) {
	    method = 'POST';
	} else {
	    method = 'GET';
	}

	// add widget loading icon
	YAHOO.util.Dom.addClass(widgetId + '_wg', 'widgetLoading');

	transaction = YAHOO.util.Connect.asyncRequest( method, wgScriptPath + '/widgetstart.php?ajax=' + resultType + '&articleid=' + wgArticleId + '&' + params, process_callback, postData);

	if ( !pagerefresh ) {
		YAHOO.util.Connect.asyncRequest('POST', window.location.href, null, "action=purge");
		pagerefresh = 1;
	}

	return false;
}

function getEditorData(form){
	// @see http://developer.mozilla.org/pl/docs/DOM:form.elements
	var fields = form.elements;

	// our widget ID
	var widgetId = form.id.substr(0, form.id.length - 7);

	var params = '';

	// parse the list of form elements (ignore submit button)
	for (f=0; f < form.length - 1; f++)
	{
		var field = fields[f];
		params += encodeURIComponent(field.name) + '=' + (field.type == 'checkbox' ? (field.checked ? '1' : '0') : encodeURIComponent(field.value)) + '&';
	}

	var result = {params: params, widgetId: widgetId};

	return result;
}

// sends editor fields content via AJAX request to widgetstart.php - i.e. saving preferences
function sendEditor(form)
{
	var data = getEditorData(form);

	// block submit button and set class for form
	YAHOO.util.Dom.get(data.widgetId + '_editorSubmit').disabled = true;
	YAHOO.util.Dom.addClass(data.widgetId + '_editor', 'progress');

	//console.log('Sending AJAX for ' + widgetId +': ' + params);

	refreshWidget(data.params, data.widgetId, null);
	return false;
}

function widgetOver()
{
//	YAHOO.util.Dom.get('cockpit_widget_name').innerHTML = this.innerHTML;
//	YAHOO.util.Dom.get('cockpit_widget_description').innerHTML = this.desc;
}

function widgetOut()
{
//	YAHOO.util.Dom.get('cockpit_widget_name').innerHTML = '&nbsp;';
//	YAHOO.util.Dom.get('cockpit_widget_description').innerHTML = '&nbsp;';
}
