jQuery.fn.cssText = function(style) {
	return this.each(function() {
		if ( !jQuery.nodeName(this, "style") )
			return;
		if ( this.styleSheet ) {
			this.styleSheet.cssText = style; // IE
		} else {
			while ( this.firstChild )
				this.removeChild(this.firstChild);
			this.appendChild(document.createTextNode(style)); // Everyone else
		}
	});
};

jQuery(function($) {
	
	var skin = $('select[name="skin"]').val();
	function makeFirstUrl() { return wgScript+"?useskin="+encodeURIComponent(skin) }
	
	var $hoverPath = $('<div id=designer-viewer-path />').appendTo('#designer-viewer-bar');
	
	var $wrongSkin = $('#designer-wrongskinmessage');
	
	var $iframe = $('<iframe id=designer-iframe />')
		.attr({ src: makeFirstUrl() })
		.bind("load", function(e) {
			var iDocument = $iframe[0].contentDocument;
			
			$wrongSkin.animate({ height: skin != $iframe[0].contentWindow.skin ? "show" : "hide" }, "fast");
			
			pageStyleRefresh(false);
			
			$("body", iDocument)
				.delegate("a[href]", "click", function(e) {
					var href = this.href;
					
					if ( /^[a-z0-9]+:/i.test(href) ) {
						if ( href.substr(0, wgServer.length).toLowerCase() != wgServer.toLowerCase() ) {
							alert(msgLeavewarning);
							return false;
						}
					}
					
					href += /\?/.test(href) ? '&' : '?';
					href += "useskin="+encodeURIComponent(skin);
					
					$iframe.attr({ src: href });
					
					return false;
				})
				.submit(function(e) {
					$('<input type=hidden name=useskin />', iDocument).val(skin).prependTo(e.target);
				})
				.mouseover(function(e) {
					var path = $(e.target, iDocument).parents().andSelf().map(function() {
						var text = (this.tagName||"").toLowerCase();
						if ( this.id )
							text += '#' + this.id;
						if ( this.className )
							text += '.' + this.className.split(/\s+/).join('.');
						return text;
					}).toArray().join(' > ');
					$hoverPath.text(path);
					$hoverPath.scrollLeft($hoverPath[0].scrollWidth);
				});
		})
		.mouseleave(function(e) {
			$hoverPath.empty();
		})
		.appendTo('#designer-viewer-framewrapper');
	
	$('select[name="skin"]').change(function(e) {
		skin = $(this).val();
		$iframe.attr({ src: makeFirstUrl() });
		refreshSkin();
		return false;
	});
	
	var $resizer = $('<span class=horizontal-resizer />').text(msgResizertext)
		.css({
			top: $('#designer-nav').outerHeight(true) + $('.secondary-bar:first').outerHeight(true) + 10,
			left: $('#designer-interface').outerWidth(true)
		})
		.appendTo('body');
	$resizer.css({ marginLeft: -$resizer.outerWidth(true) / 2 });
	
	var $designerInterface = $('#designer-interface');
	var $designerViewer = $('#designer-viewer');
	(function() {
		var lastX, $safewrapper;
		function moveEvent(e) {
			var moveX = e.clientX - lastX;
			
			var w = $designerInterface.width();
			w += moveX;
			
			$designerInterface.width(w);
			$designerViewer.css({ left: w+1 });
			$resizer.css({ left: w });
			lastX = e.clientX;
		}
		function upEvent(e) {
			$safewrapper.remove();
			delete $safewrapper;
			$(window).unbind("mousemove", moveEvent).unbind("mouseup", upEvent);
		}
		
		$resizer.mousedown(function(e) {
			lastX = e.clientX;
			$safewrapper = $('<div id=safewrapper />').appendTo('body');
			$(window).mousemove(moveEvent).mouseup(upEvent);
			return false;
		});
	})();
	
	$designerInterface.delegate('h2', "click", function(e) {
		$designerInterface.find('section').slideUp("slow");
		$(this).next("section").stop().slideDown("slow");
		return false;
	});
	$designerInterface.find('section:not(:first)').hide();
	
	// With the new resource loader Common.css, Print.css, and the Skinname.css
	// Are all combined into a single file. As a result of that because we want
	// To properly preview css as if we were editing the Skinname.css message
	// We have to eliminate the shared css file including all 3 into the page
	// To avoid breaking styles we have to reintroduce Print.css and Common.css
	// Ourselves, hence we need to preload them...
	// 
	// Oh... wait... @_@ Maybe I could just add links to the css files themselves instead... heh
	// *sigh* scrap it all...
	/*var printStyles, commonStyles;
	$.ajax({
		url: wgScriptPath+'/api.php',
		data: {
			action: query,
			prop: revisions,
			titles: "MediaWiki:Print.css|MediaWiki:Common.css"
			rvprop: content,
			format: "json"
		},
		success: function(json) {
			console.log(json);
		}
	});
	*/
	
	var $advancedCSS = $("#advanced-css")
		.bind("input change", function(e) {
			pageStyleRefresh(true);
		});
	
	function pageStyleRefresh(emptyOk) {
		if ( skin != $iframe[0].contentWindow.skin ) {
			// Don't screw up styles when we're inside the wrong skin
			return;
		}
		if ( !emptyOk && !$advancedCSS.val() ) {
			// We were called by an event such as an onload which does not control the style directly but wants to refresh it
			// And the custom css box is empty. Under these circumstances it's most probable that we just got a page load
			// event after switching skins but the ajax has not loaded this skin's css into the custom area yet
			// Because we don't want to erase the styles that would be ending up inside that custom area, we'll skip
			// This style refresh call. It's very likely that the ajax which is fetching this skin's custom css is going
			// to finish soon, and when it does it will call a style refresh on it's own and the styles will be properly refreshed
			return;
		}
		
		var iDocument = $iframe[0].contentDocument;
		var $$ = $('#designer-css-preview', iDocument);
		if ( !$$.length ) {
			// Preview styles not in place, replace build in styles
			
			// Erase the real stylesheets so we can inject our preview styles instead
			$('head link[rel="stylesheet"]', iDocument).each(function() {
				if ( /[?&]modules=site(&|$)/.test(this.href) && /[?&]only=styles(&|$)/.test(this.href) ) {
					// This link includes Common.css, Print.css, and Skinname.css, we don't want the real Skinname.css
					// Affecting the page while we preview our own version of it, we'll just have to kill the stylesheet
					$(this).remove();
				}
			});
			
			var $iHead = $('head', iDocument);
			
			// While we have to kill Skinname.css unfortunately it is bundled with Common.css and Print.css, to avoid
			// Screwing up styles we have to include a replacement for Common.css and Print.css ourselves
			$('<link rel=stylesheet />', iDocument)
				.attr({ href: wgScript+'?title=MediaWiki:Common.css&action=raw&ctype=text/css' })
				.appendTo($iHead);
			
			// Now lets insert the preview stylesheet node.
			$$ = $('<link rel=stylesheet id=designer-css-preview type="text/css" />', iDocument).appendTo($iHead);
			//$$ = $('<style id=designer-css-preview type="text/css" />', iDocument).appendTo($('head', iDocument));
			
			// Here's the Print.css, we insert it now because the order inside of the original file went Common.css, Skinname.css, and finally Print.css
			$('<link rel=stylesheet media=print />', iDocument)
				.attr({ href: wgScript+'?title=MediaWiki:Print.css&action=raw&ctype=text/css' })
				.appendTo($iHead);
			
		}
		
		// Now we insert the real styles into our preview stylesheet
		// Note that if we were to use a <style> node with inline styles then it
		// would have differentcascading behavior than it would when it came to actually saving
		// the styles into the Skinname.css file. So we make use of a data: url and base64 encode
		// our stylesheet into it. The result is a preview stylesheet that works 99% the same as the
		// real stylesheet (relative url()s do behave slightly differently, but those are already unreliable enough people don't use them in site styles)
		// Right now we're using window.btoa which apparently is present in most browsers other than IE.
		// If you want that last bit of compatibility we should probably bundle a base64 library to fallback to.
		// Although, to be honnest... IE's support for data: urls isn't that great anyways.
		// IE7 and before don't support them. And IE8 has size limitations.
		var data = "data:text/css;base64,"+window.btoa($advancedCSS.val());
		
		$$.attr({ href: data });
		
		//$$.cssText(this.value);
	}
	
	function refreshSkin() {
		$advancedCSS.cssText('');
		$.ajax({
			url: wgScript,
			data: {
				title: "MediaWiki:Skinname.css".replace("Skinname", skin.charAt(0).toUpperCase() + skin.substr(1)),
				action: "raw",
				ctype: "text/css"
			},
			success: function(style) {
				$advancedCSS.val(style);
				pageStyleRefresh(true);
			}
		});
	}
	refreshSkin();
	
});
