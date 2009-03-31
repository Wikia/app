Uniwiki.CustomToolbar = {

	/* other plugins may add more buttons here,
	 * which will automatically be included */
	Buttons: {
		'bold': {
			'key':     "b",
			'open':    "'''",
			'close':   "'''",
			'sample':  wfMsg('ct_bold_sample'),
			'tip':     [wfMsg('ct_bold_tip_ins'), wfMsg('ct_bold_tip_wrap')],
			'caption': wfMsg('ct_bold_caption')
		},
		'italic': {
			'key':     "i",
			'open':    "''",
			'close':   "''",
			'sample':  wfMsg('ct_italic_sample'),
			'tip':     [wfMsg('ct_italic_tip_ins'), wfMsg('ct_italic_tip_wrap')],
			'caption': wfMsg('ct_italic_caption')
		},
		'internal': {
			'key':     "l",
			'open':    "[[",
			'close':   "]]",
			'sample':  wfMsg('ct_internal_sample'),
			'tip':     [wfMsg('ct_internal_tip_ins'), wfMsg('ct_internal_tip_wrap')],
			'caption': wfMsg('ct_internal_caption')
		},
		'external': {
			'key':     "e",
			'open':    "[",
			'close':   "]",
			'sample':  wfMsg('ct_external_sample'),
			'tip':     [wfMsg('ct_external_tip_ins'), wfMsg('ct_external_tip_wrap')],
			'caption': wfMsg('ct_external_caption')
		},
		'image': {
			'key':      "u",
			'caption':  wfMsg('ct_image_caption'),
			'tip':      wfMsg('ct_image_tip'),
			'func':	function(textarea) {

				/* Unless we are in the classic-mode textbox,
				* pass the section id number so that we know
				* where to add the image back into the page
				* (the name of the textarea will always match
				* the id of the section) */
				if (textarea.name == "wpTextbox1") var section = textarea.name;
				else var section = textarea.name.replace(/\D/g, '');

				/* open the upload form in a popup window
 				 * (this shold be moved to an iframe) */
				popup = open(
					wgServer + wgScript + "/Special:CustomToolbarUpload?type=image&section=" + section,
					null, "scrollbars=yes, status=no, width=600, height=400"
				);

				/* check if the popup window wasn't blocked; if
				* it was, then display a notice to let the user
				* know that we didn't set them up the bomb */
				if (popup != null && popup.opener != null) popup.opener = self;
				else alert (wfMsg('ct_popupblocked'));
			}
		},
		'attachment': {
			'key':      "a",
			'caption':  wfMsg('ct_attachment_caption'),
			'tip':      wfMsg('ct_attachment_tip'),
			'func':	function(textarea) {

				/* Unless we are in the classic-mode textbox,
				* pass the section id number so that we know
				* where to add the image back into the page
				* (the name of the textarea will always match
				* the id of the section) */
				if (textarea.name == "wpTextbox1") var section = textarea.name;
				else var section = textarea.name.replace(/\D/g, '');

				/* open the upload form in a popup window
 				 * (this shold be moved to an iframe) */
				popup = open(
					wgServer + wgScript + "/Special:CustomToolbarUpload?type=attachment&section=" + section,
					null, "scrollbars=no, status=no, width=600, height=400"
				);

				/* check if the popup window wasn't blocked; if
				* it was, then display a notice to let the user
				* know that we didn't set them up the bomb */
				if (popup != null && popup.opener != null) popup.opener = self;
				else alert (wfMsg('ct_popupblocked'));
			}
		},
        'user': {
            'key':     "u",
            'open':    "[[" + wfMsg('ct_user_user') + ":",
            'close':   "]]",
            'sample':  wfMsg('ct_user_sample'),
            'tip':     wfMsg('ct_user_tip'),
            'caption': wfMsg('ct_user_caption')
        },
		'math': {
			'key':      "m",
			'open':     "<math>",
			'close':    "</math>",
			'sample':   wfMsg('ct_math_sample'),
			'tip':      [wfMsg('ct_math_tip_ins'), wfMsg('ct_math_tip_wrap')],
			'caption':  wfMsg('ct_math_caption'),
			'advanced': true
		},
		'nowiki': {
			'key':      "n",
			'open':     "<nowiki>",
			'close':    "</nowiki>",
			'sample':   wfMsg('ct_nowiki_sample'),
			'tip':      [wfMsg('ct_nowiki_tip_ins'), wfMsg('ct_nowiki_tip_wrap')],
			'caption':  wfMsg('ct_nowiki_caption'),
			'advanced': true
		},
		'horizontal-line': {
			'key':      "-",
			'open':     "\n----\n",
			'close':    "",
			'sample':   "",
			'tip':      wfMsg('ct_horizontal_tip'),
			'caption':  wfMsg('ct_horizontal_caption'),
			'advanced': true
		}
	},

	attach: function(elements, advanced) {
		var buttons = $H(Uniwiki.CustomToolbar.Buttons);

		/* accept either an array of elements,
		 * or a single element (which we will
		 * just bundle into a temp array */
		if ($type(elements) != "array")
			elements = [elements];

		// iterate elements, to add a toolbar to each
		elements.each (function (txta) {
			var wrapper = new Element ("div", { 'class': "editor-wrap" });
			var toolbar = new Element ("div", { 'class': "toolbar" });

			// create and append the buttons
			buttons.each (function (button,name) {

				/* only add this button if this button is NOT
				 * advanced-only, or this txta is advanced */
				if (advanced || !button.advanced) {
					var div = new Element("div", {
						'class': "button but-" + name,
						'html':  (button.caption || name)
					}).inject(toolbar);
					var func = null;

					/* if this button has its own click handler,
					 * then attach it, and pass it a reference to
					 * the textarea which it will insert stuff into */
					if (button.func) {
						func = function() { button.func(txta); }

					/* otherwise, the button will just be wrapping
					 * selected text in wiki markup, which is the
					 * same function every time */
					} else {
						func = function() {
							/* either wrap up the current selection
							 * in the wiki tags, or insert the wrapped
							 * sample, using the wonderful CNET forms
							 * extension to MooTools */
							txta.insertAroundCursor({
								'before':        button.open,
								'after':         button.close,
								'defaultMiddle': button.sample
							}, true);
						}
					}
					div.addEvent ("click", func);

					// if this button has a hotkey, we will append it to the tooltip
					var suffix = button.key ? (" [ctrl-" + button.key + "]") : "";

					/* add the static tooltip to the button, or if a dual-
					 * tool-tip were provided ([0] = no selection, [1] =
					 * text is selected), add the event to facilitate */
					if ($type(button.tip) == "array") {
						div.addEvent ("mouseover", function() {
							if (txta.getSelectedText().length) div.title = button.tip[1] + suffix;
							else                               div.title = button.tip[0] + suffix;
						});
					} else if(button.tip)
						div.title = button.tip + suffix;

					/* if this button has a hotkey, then store it in the div,
					 * so we can iterate them later on, in txta.keypress */
					if (button.key) div.store('key', button.key);
				}
			});

			wrapper.inject(txta, "before");
			toolbar.inject(wrapper);
			txta.inject(wrapper);

			/* when a key is pressed, check the hotkeys of
			 * each button, and trigger one if relevent
			 * (eg, ctrl+b = bold) */
			txta.addEvent('keypress', function(e) {
				if (!e.control) return true;

				// find all of the buttons relevant to this txta
				var my_buttons = e.target.getParent().getElements(".button");

				var found = false;
				my_buttons.each (function(button) {
					if(button.retrieve("key") == e.key) {
						button.fireEvent("click");
						found = true;

						/* switch the button to it's hover
						 * state for a very short time, to
						 * show the user what just happened */
						button.addClass("hover");
						(function() { button.removeClass("hover"); }).delay(250);
					}
				});

				/* if we did something, then prevent the event from
				 * bubbling, to cancel browser behaviours (ctrl+b
				 * opens the bookmarks sidebar in mozilla, etc) */
				if (found) e.stop();
			});
		});
	},
	insertIntoSection: function(index, text){
		var txta = $$("#section-"+ index + " textarea")[0];
		txta.insertAtCursor(text, true);
	},
	insertIntoClassic: function(text){
		var txta = $$("#wpTextbox1")[0];
		txta.insertAtCursor(text, true);
	},
	/* function poached from skins/common/upload.js
	 * and modified to take the path and values
	 * rather than getElementById-ing them */
	fillDestFilename: function(path, destFile) {
		// Find trailing part
		var slash = path.lastIndexOf('/');
		var backslash = path.lastIndexOf('\\\\');
		var fname;
		if (slash == -1 && backslash == -1) {
			fname = path;
		} else if (slash > backslash) {
			fname = path.substring(slash+1, 10000);
		} else {
			fname = path.substring(backslash+1, 10000);
		}
		// Capitalise first letter and replace spaces by underscores
		fname = fname.charAt(0).toUpperCase().concat(fname.substring(1,10000)).replace(/ /g, '_');
		// Output result
			destFile.value = fname;
	}
};

/* add the toolbar to all textareas (including the
 * advanced editor, in advanced mode) ASAP */
window.addEvent('domready', function() {
	Uniwiki.CustomToolbar.attach($$(".generic-editor textarea.editor"));
	Uniwiki.CustomToolbar.attach($$("#wpTextbox1"), true);
});
