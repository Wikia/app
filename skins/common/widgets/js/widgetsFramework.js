/**
 * IMPORTANT: If you want to make any changes in this code or in any part of widget
 * framework (also PHP) then you need to discuss it with me
 *
 * @author Inez Korczynski <inez@wikia.com>
 */
YAHOO.namespace("wikia");
(function() {
var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

function init() {
	if(skin == 'quartz') {
		widgets = Dom.getElementsByClassName('widget', 'li');
	} else if(skin == 'monaco' || skin == 'awesome') {
		widgets = Dom.getElementsByClassName('widget', 'dl');
	}
	for(i = 0; i < widgets.length; i++) {
		if ( !Dom.hasClass( widgets[i].parentNode, 'sidebar') ) {
                        continue;
                }
		new YAHOO.wikia.ddObject(widgets[i].id);
	}

	if(skin == 'quartz') {
		sidebars = Dom.getElementsByClassName('widgets', 'ul');
	} else if(skin == 'monaco' || skin == 'awesome') {
		sidebars = Dom.getElementsByClassName('sidebar', 'div');
	}
	for(i = 0; i < sidebars.length; i++) {
		new YAHOO.util.DDTarget(sidebars[i].id);
	}
}

function getWidgetPosition(widgetId) {
	widget = Dom.get(widgetId);
	sidebar = widget.parentNode;
	sidebarId = sidebar.id.substring(8);
	Dom.addClass('ghost', 'widget');
	widgets = Dom.getElementsByClassName('widget', null, sidebar.id);
	for(i = 0; i < widgets.length; i++) {
		if(widgets[i].id == widgetId) {
			Dom.removeClass('ghost', 'widget');
			return [parseInt(sidebarId)+0, i + 1];
		}
	}
}

function close() {
	id = this.id.split('_')[1];
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=delete&id='+id);
	$('#widget_' + id).remove();
}

function edit() {
	id = this.id.substring(0, this.id.length-5);
	Dom.setStyle(id+'_content', 'display', 'none');
	Dom.setStyle(id+'_editform', 'display', '');
	Dom.get(id+'_editform').innerHTML = '';
	Dom.addClass(id+'_editform', 'widget_loading');


	var edit_callback = {
		success: function(o) {
			id = o.argument;
			res = YAHOO.Tools.JSONParse(o.responseText);
			if(res.success) {
				Dom.removeClass(id+'_editform', 'widget_loading');
				Dom.get(id+'_editform').innerHTML = res.content;
				Event.addListener(id + '_save', 'click', edit_save);
				Event.addListener(id + '_cancel', 'click', edit_cancel);
			} else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: id
	}

	id = this.id.split('_')[1];

	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=editform&id='+id+'&skin='+skin, edit_callback);
}

function edit_save() {
	id = this.id.split('_')[1];

	var edit_save_callback = {
		success: function(o) {
			id = 'widget_' + o.argument;
			res = YAHOO.Tools.JSONParse(o.responseText);
			if(res.success) {
				Dom.setStyle(id+'_content', 'display', '');
				Dom.setStyle(id+'_editform', 'display', 'none');
				Dom.get(id+'_editform').innerHTML = '';
				Dom.get(id+'_content').innerHTML = res.body;
				if(res.title) {
				    // save content of widget toolbox when title is updated (#2330)
				    toolBox = Dom.get(id+'_header').childNodes[0];

				    if (toolBox.className == 'widgetToolbox') {
					Dom.get(id+'_header').childNodes[1].nodeValue = res.title;
				    }
				    else {
					Dom.get(id+'_header').innerHTML = res.title;
				    }
				}

				fname = res.type + '_after_edit';
				if(YAHOO.lang.isFunction(window[fname])) {
					window[fname](id);
				}


			} else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: id
	}

	YAHOO.util.Connect.setForm('widget_'+id+'_editor');
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+id+'&skin='+skin, edit_save_callback);
	$('#widget_'+id+'_editform').html('').addClass('widget_loading');
}

function edit_cancel() {
	id = this.id.substring(0, this.id.length-7);
	Dom.setStyle(id+'_content', 'display', '');
	Dom.setStyle(id+'_editform', 'display', 'none');
	Dom.get(id+'_editform').innerHTML = '';
}

function add(widget) {
	position = (widget.id) ? getWidgetPosition('ghost') : position = [1, 1];

	tempId = Dom.generateId();
	loadEl = document.createElement((skin == 'quartz') ? 'li' : 'dl');
	loadEl.id = tempId;
	loadEl.className = 'widget widget_loading';

	if(widget.id) {
		Dom.setStyle('ghost', 'display', 'none');
		Dom.get('ghost').parentNode.insertBefore(loadEl, Dom.get('ghost').nextSibling);
		name = Dom.get(widget.id).name;
	} else {
		Dom.get('sidebar_1').insertBefore(loadEl, Dom.get('sidebar_1').firstChild);
		name = this.parentNode.parentNode.name;
	}
	var type = name.substring(0, name.length-6);

	var add_callback = {
		success: function(o) {
			res = YAHOO.Tools.JSONParse(o.responseText);
			if(res.success) {
				if(res.reload) {
					window.location.reload(true);
				} else {
					tempId = o.argument.tempId;
					tempEl = document.createElement('div');
					tempEl.innerHTML = res.widget;

					new YAHOO.wikia.ddObject(tempEl.firstChild.id);

					id = tempEl.firstChild.id;
					id = id.substring(0, id.length - 3);

					Dom.setStyle(tempId, 'display', 'none');
					Dom.get(tempId).parentNode.insertBefore(tempEl.firstChild, Dom.get(tempId))

					el = Dom.get(tempId);
					el.parentNode.removeChild(el);

					fname = o.argument.type + '_init';
					if(YAHOO.lang.isFunction(window[fname])) {
						window[fname](id);
					}
				}
			} else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: {type:type, tempId:tempId}
	}

	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=add&type='+type+'&sidebar='+position[0]+'&index='+position[1]+'&skin='+skin, add_callback);
}

function reorder(widget) {
	id = widget.pureId;
	position = getWidgetPosition(widget.id);
	sidebar = position[0];
	index = position[1];
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=reorder&id='+id+'&sidebar='+sidebar+'&index='+index);
}

YAHOO.wikia.ddObject = function(id) {
	console.log("ddObject something");
	this.isThumb = Dom.hasClass(id, 'widget_thumb');

	YAHOO.wikia.ddObject.superclass.constructor.call(this, id, null, null);
	this.goingUp = false;

	if(this.isThumb == false) {
		this.pureId = id.substring(7);
		this.setHandleElId(id + '_header');

		Event.addListener(id + '_close', 'click', close);
		Event.addListener(id + '_edit', 'click', edit);
	}
}

YAHOO.extend(YAHOO.wikia.ddObject, YAHOO.util.DDProxy, {

	startDrag: function(x, y) {
		var clickEl = this.getEl();

		if(YAHOO.util.Dom.hasClass(clickEl, 'WidgetAdvertiser')) {
			var adSpaceId = clickEl.childNodes[1].childNodes[0].id;
			$(adSpaceId + '_load').style.visibility = 'hidden';
		}

		if (this.isThumb == false) {
			Dom.setStyle(clickEl, 'visibility', 'hidden');
		}
	},

	endDrag: function(e) {
		if(this.isThumb == true) {
			var srcEl = Dom.get('ghost');
			if(Dom.getStyle(srcEl, 'display') == 'none') {
				srcEl = this.getEl();
			}
		} else {
			srcEl = this.getEl();
		}

		var proxy = this.getDragEl();

		Dom.setStyle(proxy, 'visibility', '');
		var a = new YAHOO.util.Motion(
			proxy, {
				points: {
					to: Dom.getXY(srcEl)
				}
			},
			0.2,
			YAHOO.util.Easing.easeOut
		);

		var proxyid = proxy.id;
		var thisid = this.id;

		a.onComplete.subscribe(function() {
			Dom.setStyle(proxyid, 'visibility', 'hidden');
			Dom.setStyle(thisid, 'visibility', '');

			if(YAHOO.util.Dom.hasClass(srcEl, 'WidgetAdvertiser')) {
				var adSpaceId = srcEl.childNodes[1].childNodes[0].id;
				$(adSpaceId + '_load').style.visibility = 'visible';
			}

		});
		a.animate();

		if(this.isThumb == true) {
			if(Dom.getStyle('ghost', 'display') == 'block') {
				add(this);
			}
		} else {
			reorder(this);
		}
	},

	onDragOver: function(e, id) {
		var destEl = Dom.get(id);
		var srcEl;

		if(Dom.hasClass(destEl, 'widget_thumb')) {
			return;
		}

		if(( (skin == 'monaco' || skin == 'awesome') && destEl.nodeName.toLowerCase() == 'dl') || (skin == 'quartz' && destEl.nodeName.toLowerCase() == 'li')) {
			if(this.isThumb == true) {
				srcEl = Dom.get('ghost');
				Dom.setStyle('ghost', 'display', 'block');
			} else {
				srcEl = this.getEl();
			}
			var p = destEl.parentNode;
			if(this.goingUp) {
				p.insertBefore(srcEl, destEl); // insert above
			} else {
				p.insertBefore(srcEl, destEl.nextSibling); // insert below
			}
			DDM.refreshCache();
		}
	},

	onDragDrop: function(e, id) {
		if(DDM.interactionInfo.drop.length === 1) {
			if((Dom.get(id).nodeName.toLowerCase() == 'div' || Dom.get(id).nodeName.toLowerCase() == 'ul') && !(this.isThumb == true && Dom.getStyle('ghost', 'display') == 'block')) {
				var pt = DDM.interactionInfo.point;
				var region;

				if(this.isThumb == true) {
					region = Dom.getRegion('ghost');
				} else {
					region = DDM.interactionInfo.sourceRegion;
				}

				if (!region || !region.intersect(pt)) {
					var destEl = Dom.get(id);
					var destDD = DDM.getDDById(id);
					if(this.isThumb == true) {
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
		if(this.isThumb == true && Dom.get(id).nodeName.toLowerCase() == "div" ) {
			Dom.setStyle('ghost', 'display', 'none');
		}
	},

	onDrag: function(e) {
		var y = Event.getPageY(e);
		if(y < this.lastY) {
			this.goingUp = true;
		} else if (y > this.lastY) {
			this.goingUp = false;
		}
		this.lastY = y;
    }

});

function hideCarousel(e) {
	Event.preventDefault(e);

	carouselShown = false;

	if(skin == 'quartz') {
		Dom.setStyle('widget_cockpit', 'display', 'none');
	} else {
		if(carouselObj != null) {
			carouselObj.hide();
		}
	}
}

var carouselObj = null;
var carouselLoaded = false;
var carouselLength = 0;
var carouselVisible = null;
var carouselShown = false;

function showCarousel(e) {
	if (Dom.get("headerMenuUser")) {
		Dom.get("headerMenuUser").style.visibility = 'hidden';
	}
	Event.preventDefault(e);

	carouselShown = true;

	// macbre: scroll to top of the page
	window.scrollTo(0,0);

	if(carouselLoaded == false) {
		carousel = Dom.get('widget_cockpit_list');

		for(var i in widgetsConfig) {
			widgetConfig = widgetsConfig[i];
			var allow = false;
			if(widgetConfig.groups.length > 0) {
				for(var j in widgetConfig.groups) {
					if(wgUserGroups.indexOf(widgetConfig.groups[j]) >= 0) {
						allow = true;
					}
				}
			} else if (widgetConfig.languages.length > 0) {
				for(var j in widgetConfig.languages) {
					if(wgContentLanguage.indexOf(widgetConfig.languages[j]) >= 0) {
						allow = true;
					}
				}
			} else {
				allow = true;
			}

			if(allow) {
				carouselLength++;

				var thumb_el = document.createElement('li');

				if(skin == 'quartz') {
					thumb_el.id = 'mycarousel-item-' + carouselLength;
				} else {
					thumb_el.id = 'widget_cockpit-item-' + carouselLength;
				}
				thumb_el.name = i + '_thumb';

				title = widgetConfig.title[wgUserLanguage];
				if(YAHOO.lang.isUndefined(title)) {
					title = widgetConfig.title.en;
				}

				desc = widgetConfig.desc[wgUserLanguage];
				if(YAHOO.lang.isUndefined(desc)) {
					desc = widgetConfig.desc.en;
				}

				thumb_el.className = 'widget_thumb draggable clearfix ' + i +'Thumb';
				if(skin == 'monaco' || skin == 'awesome') {
					thumb_el.innerHTML = '<div class="icon"></div><h1>' + title + '<div class="add"></div></h1><br />' + desc;
				} else if(skin == 'quartz') {
					thumb_el.innerHTML = title
					thumb_el.title = desc;
				}
				carousel.appendChild(thumb_el);
				new YAHOO.wikia.ddObject(thumb_el.id);
			}
		}
		Event.addListener(Dom.getElementsByClassName('add', 'div', 'widget_cockpit_list'), 'click', add);
		carouselLoaded = true;
	}

	if(carouselLength > 0) {

		if(skin == 'quartz') {
			Dom.setStyle('widget_cockpit', 'display', '');
			getNumberForCarousel();
		}

		if(carouselObj == null) {
			getNumberForCarousel();
			carouselObj = new YAHOO.extension.Carousel((skin == 'quartz') ? "mycarousel" : "widget_cockpit", {
				wrap: false,
				animationSpeed: 0.15,
				size: carouselLength,
				prevElement: "carousel-prev",
				nextElement: "carousel-next",
				numVisible: carouselVisible,
				scrollInc: carouselVisible
			});
		} else {
			if(skin != 'quartz') {
				carouselObj.show();
				carouselObj.reload(getNumberForCarousel());
			}
		}

		Event.addListener(window, 'resize', getNumberForCarousel);
	}
}

function getNumberForCarousel() {
	if(skin == 'quartz' && Dom.get('widget_cockpit_list')) {
		var widgetEl = Dom.get('widget_cockpit_list').firstChild;
		var widgetElWidth = parseInt(Dom.getStyle(widgetEl,'width'))+(parseInt(Dom.getStyle(widgetEl,'margin-right'))*2);
		var carouselWidth = parseInt(Dom.getX('next-arrow')-Dom.getX('prev-arrow')-32);
		Dom.setStyle('widget_cockpit_overlay', 'width', parseInt(carouselWidth/10)*10 + 'px');
		carouselVisible = Math.floor(carouselWidth / widgetElWidth);
	} else if (skin == 'monaco' || skin == 'awesome') {
		var carouselSize = parseInt(Dom.getViewportWidth() - 60);

		carouselVisible = Math.floor(carouselSize / (55 + 145 + 5));

		// resize carousel (#3179)
		var carousel = Dom.get('widget_cockpit_list').parentNode;
		Dom.setStyle(carousel, 'width', carouselSize + 'px');
	}

	// and do config update (#3179) only when carousel is shown (IE6 is veeeery strange)
	if (carouselObj && carouselShown) {
		YAHOO.log('getNumberForCarousel(): ' + carouselVisible);
		carouselObj.setProperty('scrollInc',  carouselVisible);
		carouselObj.setProperty('numVisible', carouselVisible);
	}
}

if(wgUserName != null) {
	Event.onDOMReady(init);

	// Monaco
	Event.addListener(['cockpit1','cockpit2'], 'click', showCarousel);
	Event.addListener('cockpit1_close', 'click', hideCarousel);

	// Quartz
	Event.addListener('um-cockpit_show', 'click', showCarousel);
	Event.addListener('cockpit_hide', 'click', hideCarousel);
}
})();

// init widgets
$(function() {
	if (skin == 'quartz') {
		widgets = $('li.widget');
	}
	else {
		widgets = $('dl.widget');
	}

	var start = (new Date()).getTime();

	widgets.each(function() {
		id = parseInt( $(this).attr('id').substring(7) );

		type = $(this).attr('class').split(' ').pop();

		fname = type + '_init';
		if (typeof window[fname] == 'function') {
			$().log('calling ' + fname, 'Widgets');
			window[fname](id, $(this));
		}
	}).log(widgets.length + ' widgets initialized in ' + ((new Date()).getTime() - start) + ' ms' , 'Widgets');
});
