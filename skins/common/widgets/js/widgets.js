var wikiaSlideshow = false;

YAHOO.namespace('wikia');
YAHOO.wikia.slideshow = function (container, o) {
	this.container = YAHOO.util.Dom.get(container);
	this.effect = o.effect;
	var frames = o.frames;
	this.frames = [];
	this.imagesList = o.images;

	var cached_frames = YAHOO.util.Dom.getElementsByClassName("yui-sldshw-frame", null, this.container);

	this.paused = false;

	for (var i=0; i<cached_frames.length; i++) {
		this.frames[i] = { id: i, type: 'cached', value: cached_frames[i]};
	}

	if (frames != null && frames!=undefined) {
		for (var i=0; i<o.frames.length; i++) {
			this.frames[i+cached_frames.length] = o.frames[i];
		}
	}

	// macbre: slide selectors (prev/next)
	this.slide_selector_prev = function(number_of_slides, current_index) {
		current_index--;
		return (current_index >= 0 ? current_index : number_of_slides - 1);
	}

	this.slide_selector_next = function(number_of_slides, current_index) {
		return (current_index+1)%number_of_slides;
	}

	if (o.interval)
		this.interval = o.interval
	else
		this.interval = 5000

	this.init();
}


YAHOO.wikia.slideshow.prototype = {
	init: function()
		{
			if (! this.effect) {
				this.effect= YAHOO.wikia.slideshow.effects.slideUp;
			}

			this.active_frame = this.get_active_frame();

			// load image for frist  frame...
			YAHOO.util.Dom.setStyle(this.active_frame,  'backgroundImage', 'url(' + this.imagesList[0].thumb + ')' );

			this.choose_next_frame();
		},
	get_active_frame: function()
		{
			var current_frame =  YAHOO.util.Dom.getElementsByClassName("yui-sldshw-active", null,  this.container)[0];
			return current_frame;
		},
	get_next_frame: function()
		{
			var next_frame =  YAHOO.util.Dom.getElementsByClassName("yui-sldshw-next", null,  this.container)[0];
			return next_frame;
		},

	get_frame_index: function(frame)
		{
			for(var i=0; i<this.frames.length;i++) {
				if (this.frames[i].value==frame)
					return i;
			}
			return -1;
		},

	choose_prev_frame : function()
		{
			var current_index = this.get_frame_index(this.get_next_frame());

			if (current_index<0)
				current_index=0;

			var all_frames = this.frames;

			// select new active frame
			var active_index = this.slide_selector_prev(all_frames.length, current_index);
			var active = all_frames[active_index];
			var active_frame;

			//possible infinite loop....
			while (active.value==this.next_frame || active.type=="broken") {
				active = all_frames[this.slide_selector_prev(all_frames.length, active_index)];
			}

			active_frame = active.value;
			YAHOO.util.Dom.removeClass(active_frame, "yui-sldshw-cached");
			YAHOO.util.Dom.addClass(active_frame, "yui-sldshw-active");
			this.active_frame = active_frame;
			this.effect.setup(this.next_frame);
		},

	choose_next_frame : function()
		{
			var current_index = this.get_frame_index(this.get_active_frame());
			if (current_index<0)
				current_index=0;
			var all_frames = this.frames;
			var next_index = this.slide_selector_next(all_frames.length, current_index);
			var next = all_frames[next_index];
			var next_frame;
			//possible infinite loop....
			while (next.value==this.active_frame || next.type=="broken") {
				next = all_frames[this.slide_selector_next(all_frames.length, next_index)];
			}

			next_frame = next.value;
			YAHOO.util.Dom.removeClass(next_frame, "yui-sldshw-cached");
			YAHOO.util.Dom.addClass(next_frame, "yui-sldshw-next");
			this.next_frame = next_frame;
			this.effect.setup(this.next_frame);

			// load image for next frame...
			YAHOO.util.Dom.setStyle(this.next_frame,  'backgroundImage', 'url("' + this.imagesList[next_index].thumb + '")' );
		},

	clean_up_transition : function()
		{
			YAHOO.util.Dom.replaceClass(this.active_frame, "yui-sldshw-active", "yui-sldshw-cached");
			YAHOO.util.Dom.replaceClass(this.next_frame, "yui-sldshw-next", "yui-sldshw-active");
			this.active_frame = this.next_frame;
			this.choose_next_frame();
		},

	transition: function()
		{
			var hide = this.effect.get_animation(this.active_frame);

			hide.onComplete.subscribe(this.clean_up_transition, this, true);
			hide.animate();
		}
	,
	loop: function()
		{
			var self;
			self = this;
			this.loop_interval = setInterval( function(){ self.transition();}, this.interval );
		},

	destroy: function()
		{
			clearInterval(this.loop_interval);
		},

	//
	// macbre: slideshow controls handlers
	//
	controlPrev: function(e, obj)
		{
			YAHOO.util.Dom.removeClass(obj.active_frame, "yui-sldshw-active"); // active becomes next
			YAHOO.util.Dom.addClass(obj.active_frame, "yui-sldshw-next"); // active becomes next

			YAHOO.util.Dom.removeClass(obj.next_frame, "yui-sldshw-next");
			YAHOO.util.Dom.addClass(obj.next_frame, "yui-sldshw-cached");

			obj.next_frame = obj.active_frame;
			obj.choose_prev_frame();

			obj.active_frame.style.opacity = 1;

			// reinitialize animation
			clearInterval(obj.loop_interval);
			obj.loop();
		},

	controlNext: function(e, obj)
		{
			YAHOO.util.Dom.removeClass(obj.active_frame, "yui-sldshw-active");
			YAHOO.util.Dom.addClass(obj.active_frame, "yui-sldshw-cached");

			YAHOO.util.Dom.removeClass(obj.next_frame, "yui-sldshw-next");		// next becomes active
			YAHOO.util.Dom.addClass(obj.next_frame, "yui-sldshw-active");		// next becomes active


			obj.active_frame = obj.next_frame;
			obj.choose_next_frame();

			// reinitialize animation
			clearInterval(obj.loop_interval);
			obj.loop();
		},

	controlPause: function(e, obj)
		{
			if (obj.paused)
			{
				// restart animation
				obj.loop();
				obj.paused = false;

				this.className = 'WidgetSlideshowControlPause'; // change icon
			}
			else
			{
				// pause animation
				clearInterval(obj.loop_interval);
				obj.paused = true;

				this.className = 'WidgetSlideshowControlPlay'; // change icon
			}
		}
 }


YAHOO.wikia.slideshow.effects = {
	slideRight :{
			setup: function(frame){
				YAHOO.util.Dom.setStyle(frame, 'top', '0');
				YAHOO.util.Dom.setStyle(frame, 'left', '0');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					return new YAHOO.util.Motion(frame, { points: { by: [region.right-region.left,0] } }, 1, YAHOO.util.Easing.easeOut);
			}
		},
	slideLeft: {
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'top', '0');
					YAHOO.util.Dom.setStyle(frame, 'left', '0');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					return new YAHOO.util.Motion(frame, { points: { by: [region.left-region.right,0] } }, 1, YAHOO.util.Easing.easeOut);
			}
		},
	squeezeLeft: {
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'width', '100%');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					return new YAHOO.util.Anim(frame, { width: { to: 0 } }, 1, YAHOO.util.Easing.easeOut);
			}
		},
	squeezeRight: {
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'width', '100%');
					YAHOO.util.Dom.setStyle(frame, 'right', '0px');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					YAHOO.util.Dom.setStyle(frame, 'right', '0px');
					return new YAHOO.util.Anim(frame, { width: { to: 0 }}, 1, YAHOO.util.Easing.easeOut);
			}
		},
	squeezeUp: {
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'height', '100%');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					return new YAHOO.util.Anim(frame, { height: { to: 0 }}, 1, YAHOO.util.Easing.easeOut);
			}
		},
	squeezeDown: {
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'height', '100%');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					YAHOO.util.Dom.setStyle(frame, 'bottom', '0px');
					return new YAHOO.util.Anim(frame, { height: { to: 0 }}, 1, YAHOO.util.Easing.easeOut);
			}
		},
	fadeOut: {
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'opacity', '1');
			},
			get_animation: function(frame){
					return new YAHOO.util.Anim(frame, { opacity: { to: 0 }}, 1, YAHOO.util.Easing.easeOut);
			}
		},
	fadeIn: {
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'opacity', '0');
					YAHOO.util.Dom.setStyle(frame, 'z-index', '20');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					return new YAHOO.util.Anim(frame, { opacity: { to: 1 }}, 1, YAHOO.util.Easing.easeOut);
			}
		}
}
YAHOO.wikia.slideshow.effects.slideUp={
			setup: function(frame){
					YAHOO.util.Dom.setStyle(frame, 'top', '0');
					YAHOO.util.Dom.setStyle(frame, 'left', '0');
			},
			get_animation: function(frame){
					var region = YAHOO.util.Dom.getRegion(frame);
					return new YAHOO.util.Motion(frame, { points: { by: [0,region.top-region.bottom] } }, 1, YAHOO.util.Easing.easeOut);
			}
}

// setup slideshow animation
function WidgetSlideshowOnUpdate(id)
{
    // prevent multiple initializations
    if (window.wikiaSlideshow)
    {
	// remove previous slideshow object
	window.wikiaSlideshow.destroy();
    }

    // load images from JSON array
    list = YAHOO.Tools.JSONParse( YAHOO.util.Dom.get(id + '-json').innerHTML );

    if (list && list.images != false) {
	// add images to DOM
	for (i=0; i<list.images.length; i++) {
		div = document.createElement('div');
		div.className = 'slide yui-sldshw-frame' + (i==0 ? ' yui-sldshw-active' : '' );

		a = document.createElement('a');
		a.href  = list.images[i].url;
		a.title = list.images[i].alt;
		div.appendChild(a);

		YAHOO.util.Dom.get(id + '-images').appendChild(div);
	}

	// construct and run slideshow
        window.wikiaSlideshow = new YAHOO.wikia.slideshow(id + '-images', {frames:  null, effect: YAHOO.wikia.slideshow.effects.fadeOut, interval: 5000, images: list.images});
	window.wikiaSlideshow.loop();

        // add callbacks for control buttons
	var controls = YAHOO.util.Dom.get(id + '-controls').getElementsByTagName('a');

        for (c = 0; c < controls.length; c++) {
		var type     = controls[c].className.substr(22);
		var callback = function() {};

		switch (type)
		{
			case 'Prev':  callback = wikiaSlideshow.controlPrev; break;
			case 'Next':  callback = wikiaSlideshow.controlNext; break;
			case 'Pause': callback = wikiaSlideshow.controlPause; break;
		}

		YAHOO.util.Event.removeListener(controls[c], 'click', callback);

		// register callback for onclick event (send him wikiaSlideshow as obj)
		YAHOO.util.Event.addListener(controls[c], 'click', callback, wikiaSlideshow);
	}
    }
    else {
	// no images - show message
	div = document.createElement('div');
	div.innerHTML = list.msg;

	YAHOO.util.Dom.get(id + '-images').appendChild(div);
    }

}

// widget init (on add / on load)
function WidgetSlideshow_init(id)
{
    // first use of slideshow
    YAHOO.util.Event.onDOMReady( function () {
	WidgetSlideshowOnUpdate(id);
    });
}

// widget reload after editor submittion
function WidgetSlideshow_after_edit(id) {
    WidgetSlideshowOnUpdate(id);
}

function WidgetHelloWorld_init(id) {
	YAHOO.util.Dom.get(id+'_content').innerHTML = '';
	display(id);
}

function display(id){
	YAHOO.util.Dom.get(id+'_content').innerHTML += '- ';
	setTimeout("display("+id+")", 650);
}
function WidgetShoutBoxSend(widgetId) {

    var messageBox = YAHOO.util.Dom.get(widgetId + '_message');

    if (!messageBox || messageBox.value == '') {
	return false;
    }

    var callback = {
		success: function(o) {
			id = o.argument;
			res = YAHOO.Tools.JSONParse(o.responseText);
			if(res.success) {
				YAHOO.util.Dom.removeClass(id+'_content', 'widget_loading');
				YAHOO.util.Dom.get(id+'_content').innerHTML = res.body;
				if(res.title) {
					YAHOO.util.Dom.get(id+'_header').innerHTML = res.title;
				}

				// focus on message input
				YAHOO.util.Dom.get(id + '_message').focus();
			}
			else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: widgetId
    }

    message = encodeURIComponent( messageBox.value );

    YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&message='+message, callback);
    YAHOO.util.Dom.get(widgetId+'_content').innerHTML = '';
    YAHOO.util.Dom.addClass(widgetId+'_content', 'widget_loading');

    return true;
}


function WidgetShoutboxTabToogle(widgetId, tab) {

	    var currentTab = (tab == 0) ? 'online' : 'chat';
	    var onlineTab = YAHOO.util.Dom.get(widgetId+"_online");
	    var chatTab   = YAHOO.util.Dom.get(widgetId+"_chat");

	    // switch tabs and save current state to cookie
	    switch(currentTab)
	    {
		case "online":
		    onlineTab.style.display = "none";
		    chatTab.style.display   = "";
		    YAHOO.Tools.setCookie(widgetId + "_showChat", 1, new Date(2030, 0, 1));
		    break;

		case "chat":
		    onlineTab.style.display = "";
		    chatTab.style.display   = "none";
		    YAHOO.Tools.setCookie(widgetId + "_showChat", 0, new Date(2030, 0, 1));
		    break;
	    }
}

function WidgetTopContentSwitchSection(selector) {

    widgetId = selector.id.split('-')[0];
    selected = selector.options[ selector.selectedIndex ].value;

    var callback = {
		success: function(o) {
			id = o.argument;
			res = YAHOO.Tools.JSONParse(o.responseText);
			if(res.success) {
				YAHOO.util.Dom.removeClass(id+'_content', 'widget_loading');
				YAHOO.util.Dom.get(id+'_content').innerHTML = res.body;
				if(res.title) {
					YAHOO.util.Dom.get(id+'_header').innerHTML = res.title;
				}
			} else {
				// ..should never occur
			}
		},
		failure: function(o) {
			// ..should never occur
		},
		argument: widgetId
    }

    YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WidgetFrameworkAjax&actionType=configure&id='+widgetId+'&skin='+skin+'&at='+selected, callback);
    YAHOO.util.Dom.get(widgetId+'_content').innerHTML = '';
    YAHOO.util.Dom.addClass(widgetId+'_content', 'widget_loading');
}