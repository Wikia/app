/**
 * IMPORTANT: If you want to make any changes in this code or in any part of widget
 * framework (also PHP) then you need to discuss it with me
 *
 * @author Inez Korczynski <inez@wikia.com>
 */

/*
 * YUI to jQuery
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */

var WidgetFramework = {
	edit: function(e) {
		var id = $(this).attr('id').split('_')[1];

		$('#widget_' + id + '_content').hide();
		$('#widget_' + id + '_editform').show().addClass('widget_loading').html();

		$.getJSON(wgScript, {
			action: 'ajax',
			rs: 'WidgetFrameworkAjax',
			actionType: 'editform',
			skin: skin,
			id: id
		}, function(res) {
			if (res.success) {
				$('#widget_' + res.id + '_editform').removeClass('widget_loading').html(res.content);

				$('#widget_' + res.id + '_save').click(WidgetFramework.edit_save);
				$('#widget_' + res.id + '_cancel').click(WidgetFramework.edit_cancel);
			}
		});

	},

	edit_save: function(e) {
		var id = $(this).attr('id').split('_')[1];

		var req = {
			action: 'ajax',
			rs: 'WidgetFrameworkAjax',
			actionType: 'configure',
			skin: skin,
			id: id
		};

		// get editor fields and add them to AJAX request params
		var fields = $('#widget_' + id + '_editor').serializeArray();
		for (f=0; f<fields.length; f++) {
			req[ fields[f].name ] = fields[f].value;
		}

		$('#widget_'+id+'_editform').html('').addClass('widget_loading');

		$.getJSON(wgScript, req, function(res) {
			if(res.success) {
				$('#widget_' + res.id + '_editform').removeClass('widget_loading').hide();
				$('#widget_' + res.id + '_content').html(res.body).show();

				if(res.title) {
					// save content of widget toolbox when title is updated (trac #2330)
					toolBox = $('#widget_' + res.id + '_header')[0].childNodes[0];

					if (toolBox.className == 'widgetToolbox') {
						$('#widget_' + res.id + '_header')[0].childNodes[1].nodeValue = res.title;
					}
					else {
						$('#widget_' + res.id + '_header').html(res.title);
					}
				}

				var fname = res.type + '_after_edit';
				if (typeof window[fname] == 'function') {
					window[fname]( res.id, $('#widget_' + res.id) );
				}
			}
		});
		
	},

	edit_cancel: function(e) {
		var id = $(this).attr('id').split('_')[1];

		$('#widget_' + id + '_content').show();
		$('#widget_' + id + '_editform').hide().html('');
	},

	addingBlocked: false,

	add: function(e) {
		// fix RT #14269
		if (WidgetFramework.addingBlocked) {
			return;
		}

		if (this.className == 'add') {
			type = $(this).attr('rel');
		}
		else {
			return;
		}

		WidgetFramework.addingBlocked = true;
		$('body').addClass('widgetsAddingBlocked');

		$().log('new ' + type, 'Widgets');

		// temporary element
		tempId = 'widget_temp_' + (new Date()).getTime();
		loadEl = document.createElement((skin == 'quartz') ? 'li' : 'dl');

		$(loadEl).attr('id', tempId).addClass('widget').addClass('widget_loading').prependTo('#sidebar_1');

		// send request
		$.getJSON(wgScript, {
			action: 'ajax',
			rs: 'WidgetFrameworkAjax',
			actionType: 'add',
			index: 1,
			sidebar: 1,
			skin: skin,
			type: type
		}, function(res) {
			if (res.reload) {
				window.location.reload(true);
			}
			else if (res.success) {
				$(loadEl).remove();

				// get ID of new widget
				newId = parseInt( res.widget.match(/widget_(\d+)/).pop() );

				$('#sidebar_1').prepend(res.widget).log(res.type + ' added as #' + newId, 'Widgets');

				// setup widget toolbar (edit / close)
				var widget = $('#widget_' + newId);
				widget.find('.edit').click(WidgetFramework.edit);
				widget.find('.close').click(WidgetFramework.close);

				var fname = res.type + '_init';
				if(typeof window[fname] == 'function') {
					$().log('calling ' + fname, 'Widgets');
					window[fname](newId, widget);
				}

				WidgetFramework.addingBlocked = false;
				$('body').removeClass('widgetsAddingBlocked');
			}
		});
	},

	// update widget - used by widgets JS
	update: function(widgetId, params, callback) {
		$('#widget_' + widgetId + '_content').html('').addClass('widget_loading');

		// form AJAX request
		var req = {
			action: 'ajax',
			rs: 'WidgetFrameworkAjax',
			actionType: 'configure',
			id: widgetId,
			skin: skin
		};

		req = $.extend(req, params);

		$.getJSON(wgScript, req, function(res) {
			if(res.success) {
				$('#widget_' + res.id +'_content').removeClass('widget_loading').html(res.body);

				if(res.title) {
					// save content of widget toolbox when title is updated (trac #2330)
					toolBox = $('#widget_' + res.id + '_header')[0].childNodes[0];

					if (toolBox.className == 'widgetToolbox') {
						$('#widget_' + res.id + '_header')[0].childNodes[1].nodeValue = res.title;
					}
					else {
						$('#widget_' + res.id + '_header').html(res.title);
					}
				}

				// fire callback if provided
				if (typeof callback == 'function') {
					callback(res.id, $('#widget_' + res.id));
				}
			}
		});
	},

	close: function(e) {
		var id = $(this).attr('id').split('_')[1];

		$.get(wgScript, {
			action: 'ajax',
			rs: 'WidgetFrameworkAjax',
			actionType: 'delete',
			id: id
		});

		$('#widget_' + id).remove();
	},

	carouselLoaded: false,
	carouselVisible: false,
	carouselLength: 0,

	show_cockpit: function(e) {
		e.preventDefault();

		$('#headerMenuUser').hide().log('showing cockpit', 'Widgets');

		if(WidgetFramework.carouselLoaded == false) {
			$('#positioned_elements').html('<div id="cockpit" class="color1"><div id="cockpit_wrapper"><ul id="widget_cockpit_list"></ul></div><div id="cockpit_close" class="color1"></div></div>');

			var carousel = $('#widget_cockpit_list').hide();

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
					WidgetFramework.carouselLength++;

					var thumb_el = document.createElement('li');

					if(skin == 'quartz') {
						thumb_el.id = 'mycarousel-item-' + WidgetFramework.carouselLength;
					} else {
						thumb_el.id = 'widget_cockpit-item-' + WidgetFramework.carouselLength;
					}
					thumb_el.name = i + '_thumb';

					if( typeof widgetConfig.title[wgUserLanguage] == 'string' ) {
						title = widgetConfig.title[wgUserLanguage];
					}
					else {
						title = widgetConfig.title.en;
					}

					if( typeof widgetConfig.desc[wgUserLanguage] == 'string' ) {
						desc = widgetConfig.desc[wgUserLanguage];
					}
					else {
						desc = widgetConfig.desc.en;
					}

					thumb_el.className = 'widget_thumb draggable clearfix ' + i +'Thumb';
					if(skin == 'monaco' || skin == 'awesome') {
						thumb_el.innerHTML = '<div class="icon"></div><h1>' + title + '<div class="add" rel="' + i + '"></div></h1><br />' + desc;
					} else if(skin == 'quartz') {
						thumb_el.innerHTML = title
						thumb_el.title = desc;
					}
					carousel.append(thumb_el);
				}
			}

			// handle adding widgets from cockpit
			carousel.find('.add').click(WidgetFramework.add);

			// set correct width of carousel
			carousel.css("width", (WidgetFramework.carouselLength * ($.browser.msie ? 220 : 210)) + 'px').show();

			// close cockpit
			$('#cockpit_close').click(WidgetFramework.hide_cockpit);

			// cockpit is fully loaded
			WidgetFramework.carouselLoaded = true;
		}

		// show cockpit
		if ($.browser.msie) {
			$('#cockpit').show();
			window.scrollTo(0, 0);
		}
		else {
			$('#cockpit').css("bottom", -85).show().animate({
				bottom: 0
			}, "fast");
		}

		$('#positioned_elements').css('visibility', 'visible');

		WidgetFramework.carouselVisible = true;

		// reposition ads
		if (typeof TieDivLibrary != 'undefined') {
			TieDivLibrary.calculate();
		}
	},

	hide_cockpit: function(e) {
		WidgetFramework.carouselVisible = false;

		if ($.browser.msie) {
			$('#cockpit').hide();
		}
		else {
			$('#cockpit').animate({
				bottom: -85
			}, "fast", function() {$(this).hide();});
		}
	}
}

// init widgets
$(function() {
	var start = (new Date()).getTime();

	if (skin == 'quartz') {
		widgets = $('#widgets_1').children('li');
	}
	else {
		widgets = $('#sidebar_1').children('dl');
	}

	if (wgUserName != null) {
		// setup sortable UI jQuery plugin
		$('#sidebar_1').sortable({
			axis: 'y',
			containment: '#sidebar_1',
			delay: 100,
			handle: '.widget_title',
			helper: function(ev, widget) {
				var helper = document.createElement('div');

				$(helper).css({
					border: 'solid 2px #aaa',
					height: $(widget).height() + 'px',
					width:  $(widget).width() + 'px'
				});

				return helper;
			},
			revert: true, // smooth animation

			// events
			stop: function(ev, ui) {
				// index - first widget in the sidebar has index = 1
				var index = 0;
				$('#sidebar_1').children('.widget').each( function(i) {
					if ($(this).attr('id') == ui.item.attr('id')) {
						index = i+1;
					}
				});

				// send reindex request to WidgetFramework
				$.get(wgScript, {
					action: 'ajax',
					rs: 'WidgetFrameworkAjax',
					actionType: 'reorder',
					sidebar: 1,

					id: ui.item.attr('id').split('_').pop(),
					index: index
				});
			}
		});

		// setup widgets toolbar (edit / close)
		widgets.find('.edit').click(WidgetFramework.edit);
		widgets.find('.close').click(WidgetFramework.close);
	}

	// run widgets init functions
	widgets.each(function() {
		id = parseInt( $(this).attr('id').substring(7) );

		type = $(this).attr('class').split(' ').pop();

		fname = type + '_init';
		if (typeof window[fname] == 'function') {
			$().log('calling ' + fname, 'Widgets');
			window[fname](id, $(this));
		}
	}).log(widgets.length + ' widgets initialized in ' + ((new Date()).getTime() - start) + ' ms' , 'Widgets');

	// widgets cockpit
	$('#cockpit1, #cockpit2').click(WidgetFramework.show_cockpit);
});
