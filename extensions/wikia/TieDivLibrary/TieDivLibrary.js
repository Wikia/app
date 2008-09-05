/**
 * http://www.hedgerwow.com/360/dhtml/js-onfontresize2.html
 */
YAHOO.namespace('YAHOO.example').FontSizeMonitor = (function(){
	var $E = YAHOO.util.Event;
	var $D = YAHOO.util.Dom;
	var p_frame = document.createElement('iframe');
	var p_ie = !!(document.expando && document.uniqueID);
	var p_gecko = !!(document.getBoxObjectFor);
	var p_init = function(){
		var dB = document.body;
		if(!dB ) return setTimeout(p_init,0);
		if(!p_frame._ready){
			with(p_frame.style){
				width = '10em';
				height = '50pt';
				visibility = 'hidden';
				position = 'absolute';
				zIndex = -1;
				top = '0';
				left = '0';
				border = 'none';
				background = "red";
			};
			dB.insertBefore(p_frame,dB.firstChild);
		};
		if(p_ie){
			p_frame._ready = true ;
			$E.on(p_frame,'resize',oApi._onFontResize,oApi,true);
			} else {
			if(!p_gecko){
				var dDoc = p_frame.contentDocument || p_frame.contentWindow;
				if(!dDoc) return setTimeout(p_init,0);
				p_frame._ready = true ;
				dDoc.onresize = function(e){
					oApi._onFontResize.call(oApi,e);
				};;
				}else{
				with(p_frame.style){
					visibility = 'visible';
					zIndex = 1000;
					left = (YAHOO.util.Dom.hasClass(document.body, 'rtl') ? '' : '-') + '5000px';
				};
				var sHtml = [
				'<html><body><script>',
				'self.onresize=function(e){parent.YAHOO.example.FontSizeMonitor._onFontResize(e);}',
				'<\/script></body></html>'].join('');
				p_frame.src= 'data:text/html;charset=utf-8,' + encodeURIComponent(sHtml);
			}
		}
	};
	var onResize = function(){
	};
	var oApi = {
		_onFontResize:function(e){
			var n = p_frame.offsetWidth / 10;
			this.onChange.fire(n);
		},
		onChange:new YAHOO.util.CustomEvent('change')
	};
	p_init();
	return oApi;
})();


/**
 * @author Inez Korczynski, Christian Williams, Maciej Brencz
 */
TieDivLibrary = new function() {

	var items = Array();
	var loopCount = 500;

	this.tie = function(slotname) {
		items.push([slotname]);
	};

	this.calculate = function() {
		YAHOO.log('calculate()', 'info', 'TieDivLibrary');
		for(i = 0; i < items.length; i++) {
			jQuery.noConflict();
			var offset = jQuery("#" + items[i][0]).offset();
			if (YAHOO.util.Dom.getStyle(items[i][0], "float") == 'right') {
				jQuery("#" + items[i][0] + "_load").css({
					display: "block",
					top: offset.top,
					right: YAHOO.util.Dom.getViewportWidth() - offset.left - jQuery("#" + items[i][0]).width()
				});
			} else {
				jQuery("#" + items[i][0] + "_load").css({
					display: "block",
					top: offset.top,
					left: offset.left
				});
			}
		}
	};

	this.timer = function() {
		TieDivLibrary.calculate();
		loopCount--;
		if(loopCount > 0) {
			setTimeout(TieDivLibrary.timer, 350);
		}
	};

	this.loop = function(count) {
		var go = false;
		if (loopCount <= 0) go = true;
		loopCount = count;
		if (go) TieDivLibrary.timer();
	};

	YAHOO.util.Event.on(window, 'load', function() {
		setTimeout(function() { loopCount = 0; }, 2000);
		YAHOO.example.FontSizeMonitor.onChange.subscribe(TieDivLibrary.calculate);
	});

	YAHOO.util.Event.on(window, 'resize', function() {
		TieDivLibrary.calculate();
	});

	YAHOO.util.Event.on(document, 'click', function() {
		TieDivLibrary.loop(3);
	});

	YAHOO.util.Event.on(document, 'keydown', function() {
		TieDivLibrary.loop(3);
	});

};
