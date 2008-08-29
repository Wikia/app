/**
 * @author Inez Korczynski
 * @author Maciej 'macbre' Brencz
 */
TieDivLibrary = new function() {

	var Dom = YAHOO.util.Dom;

	var items = Array();

	var browser = Array();

	this.init = function() {
		// YUI logger (ONLY for debug purposes)
		/**/
		new YAHOO.widget.LogReader(null, {width: "350px", height: "300px", draggable: true, left: "180px", top: "80px"});
		Dom.addClass('body', 'yui-skin-sam');
		/**/

		this.browser = YAHOO.env.ua;
	}

	this.tie = function(slotname) {
		items.push([slotname]);
	}


	this.getElementXY = function(element) {

		var res = {x: element.offsetLeft, y: element.offsetTop};
    	
		var offsetParent = element.offsetParent;
		var parentNode = element.parentNode;

		while (offsetParent != null) {
			res.x += offsetParent.offsetLeft;
			res.y += offsetParent.offsetTop;

			if (offsetParent != document.body && offsetParent != document.documentElement) {
				res.x -= offsetParent.scrollLeft;
				res.y -= offsetParent.scrollTop;
			}
			//next lines are necessary to support FireFox problem with offsetParent
			if (this.gecko) {
				while (offsetParent != parentNode && parentNode !== null) {
					res.x -= parentNode.scrollLeft;
					res.y -= parentNode.scrollTop;
					
					parentNode = parentNode.parentNode;
				}    
			}
			parentNode = offsetParent.parentNode;
			offsetParent = offsetParent.offsetParent;
		}
		return res;
	}
	
	this.getXY = function(element) {

		var pos = {x:0, y:0};

		element = Dom.get(element);

		// http://www.quirksmode.org/dom/w3c_cssom.html
		// works in IE5.5+, FF3 (almost) and Opera9.51+
		if (document.documentElement.getBoundingClientRect) {
			var rect = element.getBoundingClientRect();
			pos.x = rect.left;
			pos.y = rect.top;

			YAHOO.log('using getBoundingClientRect()', 'info', 'TieDivLib');
                }
		// the rest (still needs to be tested)
		else {
			pos = this.getElementXY(element);
		}

		YAHOO.log('getXY for ' + element.id + ': (' + pos.x + ', ' + pos.y + ')', 'info', 'TieDivLib');
		
		return pos;
	}

	this.calculate = function() {

		YAHOO.log('calculate() called', 'info', 'TieDivLib');

		for(i = 0; i < items.length; i++) {
			var pos = this.getXY(items[i][0]);
			Dom.setStyle(items[i][0]+'_load', 'position', 'absolute');
			//Dom.setStyle(items[i][0]+'_load', 'left', pos.x + 'px');
			//Dom.setStyle(items[i][0]+'_load', 'top',  pos.y + 'px');
			Dom.setXY(items[i][0]+'_load', [pos.x, pos.y]);
		}
	}

	this.init();
}

