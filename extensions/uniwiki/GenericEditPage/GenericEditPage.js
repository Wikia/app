/* vim: noet ts=4 sw=4
 * http://www.mediawiki.org/wiki/Extension:Uniwiki_Generic_Edit_Page
 * http://www.gnu.org/licenses/gpl-3.0.txt */

Uniwiki.GenericEditPage = {

	/* store the instance of the Mootools sortable
	 * class statically, so we can easily attach
	 * and detach things to it */
	sections_sortable: null,

	/* section sorting is enabled as default, but
	 * can temporarily suspended while things are
	 * sliding around */
	sections_sorting: true,


	/* to switch between modes (generic and classic),
	 * we must (effectively) click preview (to re-
	 * combine the wiki markup server-side), and
	 * reload the page in the opposite mode) */
	toggle_mode: function() {
		/* picked up by the combineBeforeSave hook
		 * in GenericEditor.php to set the new mode */
		$("switch-mode").value = 1;

		/* simulate a click on "preview" by setting
		 * a faux input field with the same name */
		$("wpFakePreview").name  = "wpPreview";
		$("wpFakePreview").value = "Show preview";
		$("editform").submit();
	},


	/* return the DOM node which contains
	 * all of the generic editor stuff */
	editor: function () {
		return $$(".generic-editor")[0];
	},

	/* util function to trigger a click event
	 * upon receiving an [ENTER] key press (for
	 * the add [cat | section] boxes, initially */
	bind_enter_to_click: function(src,dest) {
		src.addEvent ("keypress", function(e) {
			if (e.key == "enter") {
				dest.fireEvent("click");
				e.stop();
			}
		});
	},

	/* update the visibility status of the instructions
	 * box (says "there are no sections, add some, etc");
	 * show it only if there are no sections visible */
	update_instructions_box: function() {

		/* count the number of sections which are now in
		 * use. if it is NONE, show the instructions box */
		var ed = Uniwiki.GenericEditPage.editor();
		var in_use = ed.getElements(".in-use").length;
		if (in_use) { ed.removeClass("show-instructions"); }
		else        { ed.addClass(   "show-instructions"); }
	},

	/* lock the height of the editor while sliding,
	 * to prevent the window scrollbar from moving
	 * around. it grabs the user's attention */
	lock_editor_height: function() {
		var size = Uniwiki.GenericEditPage.editor().getSize();
		Uniwiki.GenericEditPage.editor().setStyle('height', size.y + "px");
	},

	/* allow the editor to size naturally */
	unlock_editor_height: function() {
		Uniwiki.GenericEditPage.editor().setStyle('height', "");
	},


	Events: {

		// == SYNCHRONISE SIDEBAR WITH EDITABLE TITLES ==
		section_title_change: function() {
			$$(".generic-editor input.section-title").
				addEvent ("keyup", function(e) {
					var title = e.target.value;
					var index = e.target.name.replace(/\D/g, "");
					$$("#sect-" + index + " label").set("text", title);
				});
		},

		// == "ADD CATEGORY" BOX ==
		add_category: function() {
			/* add category [field | button] */
			var acat_fld = $("fm-add-cat");
			var acat_btn = $("fm-add-cat-button");

			/* when the add button is clicked, create a new category
			 * checkbox + label, and insert it into the list. we don't
			 * have to do insert any wiki markup, because the combine-
			 * BeforeSave function in GenericEditPage.php will do it */
			acat_btn.addEvent( "click", function(e) {

				// abort if no category name was entered
				var cat_name = acat_fld.value.trim();
				if (cat_name == "") return true;

				/* iterate all category checkboxes, looking
				 * for one by the name entered (to recycle) */
				var already_exists = false;
				$$("#category-box input[type=checkbox]").each (function(obj) {
					if (obj.name == "category-" + cat_name) {

						/* ensure that the category is checked,
						 * and highlight it to notify the user */
						already_exists = true;
						acat_fld.value = "";
						obj.checked = "checked";
						obj.getParent().highlight();
					}
				});

				// abort if the new cat name already exists
				if (already_exists) return true;

				/* if no category by this name already exists,
				 * then we will add a new checkbox (to be found
				 * by the server-side combineBeforeSave function) */
				var f_id = "category-" + cat_name;
				var div = new Element ("div").appendText(" ");

				// create the new checkbox
				var input = new Element ("input", {
					'id':      f_id,
					'name':    f_id,
					'type':    "checkbox",
					'checked': "checked"
				}).inject(div);

				// create the label
				var label = new Element ("label", { 'for': f_id })
					.appendText (cat_name).inject (div);

				/* insert the new category before the add
				 * form and flash it, to notify the user */
				div.inject (acat_btn.getParent(), "before");
				div.highlight();

				/* clear the new category name field */
				acat_fld.value = "";
			});

			/* catch the ENTER key in the category name box,
			 * to prevent the entire edit form from submitting
			 * (redirect it to the click event, above) */
			Uniwiki.GenericEditPage.bind_enter_to_click (acat_fld, acat_btn);
		},

		// == "ADD SECTIONS" BOX ==
		add_section: function() {
			/* add section [field | button] */
			var asect_fld = $("fm-add-sect");
			var asect_btn = $("fm-add-sect-button");

			asect_btn.addEvent( "click", function(e) {
				var sect_name = asect_fld.value.trim();
				if (sect_name == "") return true;

				/* find the next available section index
				 * (will be incremented in iterator, below) */
				var sect_index = 1;

				var already_exists = false;
				$$("#section-box input[type=checkbox]").each (function(obj) {

					/* fetch the NAME of this checkbox, via its label
					 * (section checkboxes are only identified by index) */
					var labels = obj.getParent().getElements('label');
					if (labels) obj_name = labels[0].get('text');

					if (obj.name == sect_name) {
						already_exists = true;
						asect_fld.value = "";
						obj.checked = "checked";
						obj.getParent().highlight();
					}

					/* keep track of the highest section index,
					 * in case we need to add a new section */
					var obj_index = obj.name.replace (/\D/g, '');
					if (obj_index > sect_index) sect_index = obj_index;
				});

				// abort if the new section name already exists
				if (already_exists) return true;

				/* we're creating a new section; index
				 * it one higher than the current maximum */
				sect_index++;

				var div = new Element ("div", {
					'id':    "sect-" + sect_index,
					'class': "section-box"
				});

				// create the checkbox
				var f_name = "enable-" + sect_index;
				var f_id   = "fm-" + f_name;
				var input = new Element ("input", {
					'id':      f_id,
					'name':    f_name,
					'type':    "checkbox",
					'checked': "checked"
				}).inject(div);

				/* add a single space between the checkbox
				 * and label, to match existing sections */
				div.appendText(" ");

				// create the label
				var label = new Element ("label", { 'for': f_id })
					.appendText (sect_name).inject (div);

				/* insert the new section div (in sidebar) into the
				 * sortables container, and hook up the event handlers
				 * to make it play nice with the other sections */
				div.inject (asect_btn.getParent().getPrevious());
				var sortables = Uniwiki.GenericEditPage.sections_sortables;
				if (sortables) sortables.addItems (div);
				div.highlight();

				// create and inject the real section into the editor
				var klass = "section sect-" + (sect_index+1) + " in-use";
				var div   = new Element ("div",      { 'id': "section-" + sect_index, 'class': klass });
				var t_div = new Element ("div",      { 'class': "sect-title" }).inject(div);
				            new Element ("input",    { 'type': "text", 'value': sect_name, 'class': "section-title", 'name': "title-" + sect_index }).inject(t_div);
				            new Element ("input",    { 'type': "hidden", 'value': 2, 'name': "level-" + sect_index }).inject(div);
				var txta  = new Element ("textarea", { 'name': "section-" + sect_index, 'class': "editor" }).inject(div);
				div.inject (Uniwiki.GenericEditPage.editor());

				/* if we are also running the custom toolbars
				 * uniwiki extension, add a nice toolbar to
				 * this section */
				if (Uniwiki.CustomToolbar)
					Uniwiki.CustomToolbar.attach (txta);

				/* hide the instructions box, now that we
				 * have at least one section in the editor */
				Uniwiki.GenericEditPage.update_instructions_box();

				// clear the "new section name" field
				asect_fld.value = "";
			});

			Uniwiki.GenericEditPage.bind_enter_to_click (asect_fld, asect_btn);
		},

		toggle_sections: function() {
			// check that this document has a sortable sections box
			var sortables = $$("#section-box .sortables")[0];
			if (!sortables) return true;

			// == HANDLE SECTION-IN-USE CHECKBOXES ==
			var evt_type = Browser.Engine.trident ? 'click' : 'change';
			sortables.addEvent(evt_type, function(e) {

				// don't mess with things that aren't checkboxes
				if ($(e.target).get('tag') != 'input') return true;

				// find the target section id and section
				var sect_index = parseInt(e.target.name.replace(/\D/g, ''));
				var target = $('section-' + sect_index);

				// show or hide the real section in the editor
				if (e.target.checked) { target.removeClass('not-in-use').addClass('in-use'); }
				else                  { target.addClass('not-in-use').removeClass('in-use'); }

				Uniwiki.GenericEditPage.update_instructions_box();
			});

		},

		reorder_sections: function() {
			// TEMPORARILY DISABLED
			// HERE BE DRAGONS
			return false;

			// we will need this all over the place
			var editor = Uniwiki.GenericEditPage.editor();

			// check that this document has a sortable sections box
			var sortables = $$("#section-box .sortables")[0];
			if (!sortables) return true;

			// == HIGHLIGHT SORTABLES UPON MOUSEDOWN ==
			/* watch for mouse-down events on draggable elements (which will trigger
			 * the mootools sortables events (below)), to highlight a div which is
			 * now draggable to sort. we must do this here (not in the onStart event),
			 * because mootools waits for mousedown THEN mousemove to trigger; which
			 * is quite confusing for end-users */
			sortables.addEvent ("mousedown", function(e) {

				// don't highlight anything if sorting is suspended
				if (!Uniwiki.GenericEditPage.sections_sorting)
					return false;

				var t = $(e.target);
				var tag = t.get("tag");

				/* do nothing for input (checkbox), as not to interfere
				 * with their normal behaviour. otherwise, highlight
				 * the section box (entire row) */
				if      (tag == "input") return true;
				else if (tag == "label") dragger = t.getParent();
				else if (tag == "div" && t.hasClass ("section-box")) dragger = t;

				// we have no idea what's going on
				else return true;

				/* if this element is currently tweening,
				 * then stop it, to re-highlight it */
				if (dragger.retrieve ("tween")) {
					dragger.retrieve ("tween").cancel();
					dragger.store ("tween", null);
				}

				// set css hooks to make dragging visible
				dragger.setStyle ("background-color", "#ff8");
				dragger.getParent().addClass ("dragging");
				dragger.addClass ("dragging");

				/* watch the whole document for mouseup, because the
				 * cursor may no longer be in the sortables box */
				var evt = function() {

					// only fire this event once
					$(document).removeEvent ("mouseup", evt);

					/* fade from the highlight color, back
					 * to white, then remove the background */
					var tween = new Fx.Tween (dragger, {
						onComplete: function() {
							dragger.setStyle ("background-color", "");
							dragger.store ("tween", null);
						}
					}).start ("background-color", "#fff");

					/* keep note of the tween object in the element,
					 * in case the mousedown event is re-fired before
					 * it is completed - so we can cancel it */
					dragger.store ("tween", tween);

					// also remove css hooks from DOM
					dragger.getParent().removeClass ("dragging");
					dragger.removeClass ("dragging");
				};

				document.addEvent ("mouseup", evt);
			});

			// == MAKE THEM SORTABLE! ==
			Uniwiki.GenericEditPage.sections_sortables =
			new Sortables(sortables, {
				onComplete: function(obj) {

					// fetch the section we are moving
					var sect_id = obj.id.replace(/\D/g, "");
					var section = $("section-" + sect_id);

					/* find the current (old) and target (new) indexes
					 * (oldIndex - 2, to count around #instructions, and
					 * the mostly-invisible first "introduction" section) */
					var newIndex = obj.getParent().getChildren().indexOf(obj);
					var oldIndex = editor.getChildren().indexOf(section) - 2;

					// skip this whole thing is the position has not changed
					if (!section || (newIndex == oldIndex))
						return true;

					/* disable sorting and sizing until all of the
					 * re-ordering and sliding around is done */
					Uniwiki.GenericEditPage.sections_sortables.detach();
					Uniwiki.GenericEditPage.sections_sorting = false;
					Uniwiki.GenericEditPage.lock_editor_height();

					var stage = 1;
					var slider = new Fx.Slide (section, {
						onComplete: function() {

							// 1 = SLIDE OUT EVENT
							if (stage==1) {
								stage = 2;
								var anchor = null;
								var rel    = null;

								/* the div that is actually moving is
								 * intermediate (inserted by MooTools) */
								var moving = section.getParent();

								/* newIndex offset is always +2, to skip the first (anonymous)
								 * introduction section and the instruction box. both are inside
								 * the generic editor (even if they shouldn't be) */
								var target = $(editor.getChildren()[newIndex + 2]);

								if (newIndex < oldIndex) {
									/* we're moving UP - don't need to
									 * check for failure, because there
									 * will always be the first anonymous
									 * section to anchor from */
									anchor = target.getPrevious();
									rel    = "after";

								} else {
									// moving DOWN
									anchor = target.getNext();
									rel    = "before";

									/* if getNext failed, it's because there
									 * are no more siblings - we're moving to
									 * the bottom of the list! */
									if (!anchor) {
										anchor = target.getParent();
										rel    = "bottom";
									}
								}

								/* inject the intermediate slider at the right position in
								 * the DOM, and slide back in. delay it to avoid weird race
								 * condition in IE6, which i don't have time to debug */
								moving.inject(anchor, rel);
								(function () { slider.slideIn(); }).delay(100);

							// 2 = SLIDE IN EVENT
							} else if (stage==2) {

								/* get rid of intermediate element,
								 * and don't re-call this event. this
								 * breaks encapsulation, and is a hack :( */
								section.replaces (section.getParent());
								section.store ("wrapper", null);
								slider.removeEvents ("onComplete");

								/* remove all section and sect (checkbox) ids
								 * (nodes can't share ids, even temporarily) */
								var sections = $$(".generic-editor > div.section");
								var sects    = $$("#section-box .sortables > div");
								var func_rem = function (el) { el.id = '' };
								sections.each (func_rem);
								sects.each (func_rem);

								/* now re-name every field in each section, to
								 * reflect their new position in the DOM */
								sections.each (function (el,index) {
									el.id = "section-" + index;

									/* also update the indexes within each form field
									 * of the section (so they're put back together
									 * in the right order when we save changes */
									el.getElements ("input,textarea").each (function (field) {
										field.name = field.name.replace (/\d+$/, index);
									});
								});

								/* as above, for sect /checkboxes,
								 * which start at index 1 (no checkbox
								 * for the anonymous first section */
								sects.each(function(el,index) {
									el.id = "sect-" + (index+1);
									el.getElements ("input").each(function(field) {
										field.name = field.name.replace(/\d+$/, (index+1));
									});
								});

								// turn back on reordering and natural sizing
								Uniwiki.GenericEditPage.sections_sortables.attach();
								Uniwiki.GenericEditPage.sections_sorting = true;
								Uniwiki.GenericEditPage.unlock_editor_height();

								/* in case i cocked-up this function,
								 * and it ends up being called again */
								stage = null;
							}
						}

					/* slide out first, then do some logic
					 * (above, stage 1), then slide back in */
					}).slideOut();
				}
			});

			// == PREVENT DRAGGING BY CHECKBOXES! ==
			/* cancel mousedown events in checkboxes within the sections box, to
			 * prevent the sortables behaviour from firing. this prevents people
			 * dragging checkboxes around, and toggling them at the same time */
			sortables.getElements("input[type=checkbox]").addEvent("mousedown", function(e) {
				e.stop();
			});
		}
	} // Events
};
