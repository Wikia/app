/**
 * @name AutocompleteView
 * @description Backbone subview/module for generic autocomplete
 *
 * @example
 * var autocomplete = new AutocompleteView( {
 *		el: '.my-el', // This el is the closest parent element containing the form and the results container
 *		collection: new CategoryCollection() // Instatiated collection is available inside the view
 * } );
 *
 * Supplied parent element must contain a DOM structure that includes:
 * div.autocomplete,
 * input[data-autocomplete]
 */
define('videopageadmin.views.autocomplete', [
	'jquery',
	'videopageadmin.views.autocompleteitem'
], function ($, AutocompleteItemView) {
	'use strict';
	var AutocompleteView = Backbone.View.extend({
		initialize: function () {
			var that = this;

			// this view requires an input with attr data-autocomplete present
			this.$input = this.$('input[ data-autocomplete ]');
			// if the value is prepolated, set it on our collection
			if (this.$input.val().length) {
				this.collection.selectedCategory = this.$input.val();
			}

			// bind all the function contexts
			_.bindAll(this, 'clearResults', 'renderResults', 'setValue');

			// hide results menu when clicked outside
			$('body').on('click', function () {
				if (that.results && that.results.length) {
					that.trigger('results:hide');
				}
			});

			// bind events
			this.on('results:hide', this.clearResults);
			this.collection.on('reset', this.renderResults);
			this.collection.on('category:chosen', this.setValue);
		},
		events: {
			'click input[data-autocomplete]': 'absorbEvent',
			'keyup input[data-autocomplete]': 'handleKeyUp',
			'keydown input[data-autocomplete]': 'preventKeybinds',
			'input input[data-autocomplete]': 'setCategory'
		},
		absorbEvent: function (evt) {
			// used to absorb click events on input while results menu is open
			evt.stopPropagation();
		},
		preventKeybinds: function (evt) {
			// use to prevent premature interaction with form
			var key = evt.keyCode;
			if (key === 13 || key === 10 || key === 27) {
				return false;
			}
		},

		/**
		 * @description Handles varied user inputs with conditonal branching
		 */
		handleKeyUp: function (evt) {
			evt.preventDefault();
			var $tar,
				$val,
				keyCode;

			$tar = $(evt.target);
			keyCode = evt.keyCode;
			$val = $tar.val();

			if (keyCode === 38 || keyCode === 40) {
				// Handle graphical traversal of the list if up/down keys are pressed
				this.selectListItem(keyCode);
			} else if (keyCode === 27) {
				// if user presses ESC, clear field
				$tar.val('');
				this.clearResults();
			} else if (keyCode === 13) {
				// if user presses RET, select highlighted
				this.getSelection();
			} else if ($val.length > 2) {
				// collection fetch
				this.collection.autocomplete($val);
			} else if ($val.length < 2) {
				if (this.collection.length) {
					this.clearResults();
				}
			}
		},
		setCategory: function () {
			this.collection.setCategory(this.$input.val());
		},
		getSelection: function () {
			// safe early exit condition, prevents trying to get selection before first results have been set
			if (!this.$results) {
				return false;
			}

			this.$results.find('.selected').click();
		},
		setValue: function () {
			// setValue of input[data-autocomplete]
			this.$input.val(this.collection.selectedCategory);
		},
		clearResults: function () {
			this.collection.reset();
			this.results.map(function (subView) {
				// use Backbone's native view removal
				return subView.remove();
			});

			this.results = [];
			this.$results.html('').hide();
		},

		/*
		 * This function fires on each collection reset
		 */
		renderResults: function () {
			var that,
				view;

			that = this;

			this.$results = this.$('.autocomplete');
			this.results = [];
			this.$results.html('');
			if (!this.collection.length) {
				return this.$results.hide();
			} else {
				this.$results.show();
			}

			this.collection.each(function (model) {
				view = new AutocompleteItemView({
					model: model,
					parentView: that
				});
				that.results.push(view);
				that.$results.append(view.render().$el);
			});

			return this;
		},
		selectListItem: function (key) {
			var $categories,
				$selected,
				$newSelection,
				idx,
				pos,
				scroll;

			$categories = this.$el.find('.autocomplete-item');

			if (!$categories.length) {
				return;
			}

			$selected = $categories.closest('.selected');

			idx = _.indexOf($categories, $selected.get(0));

			// up arrow
			if (key === 38) {
				if (idx === 0) {
					$selected.removeClass('selected');
				} else {
					$newSelection = $selected.prev();
				}

				// down arrow
			} else if (key === 40) {
				if (idx === -1) {
					$newSelection = $categories.eq(0);
				} else if (idx >= 0) {
					$newSelection = $selected.next();
				}
			}

			if ($newSelection) {
				pos = $newSelection.position();
				scroll = this.$results.scrollTop();
				$newSelection.addClass('selected').siblings().removeClass('selected');
				if (pos && pos.top > this.$results.height()) {
					this.$results.scrollTop($newSelection.index() * $newSelection.outerHeight());
				} else if (pos && pos.top < 0) {
					this.$results.scrollTop(scroll - this.$results.height());
				}
			}
		}
	});
	return AutocompleteView;
});
