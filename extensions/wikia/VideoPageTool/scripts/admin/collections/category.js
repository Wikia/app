/**
 * CategoryCollection
 * @constructor
 * @description Collection representing all the categories present on executing wikia
 *							Calls CategorySelect::getWikiCategories which returns ALL the categories
 * @requires { CategoryModel }
 */
define('videopageadmin.collections.category', [], function () {
	'use strict';

	var CategoryCollection = Backbone.Collection.extend({
		url: '/wikia.php',
		initialize: function () {
			_.bindAll(this, 'setCategory', 'autocomplete');
			// don't use nirvana, backbone's persistence layer offers actual useful abstractions
			// and lifecycle events built into class
			this.controller = 'CategorySelect';
			this.method = 'getWikiCategories';

			// only fetch if collection was not instantiated with models
			if (!this.length) {
				this.fetch({
					reset: true,
					data: {
						controller: this.controller,
						method: this.method
					}
				});
			}
		},

		/**
		 * @method
		 * @description Sets category and triggers event for views to respond to
		 * @param { Backbone.Model | string } data - Instance of Backbone.Model with name
		 *																		property or a string containing name
		 */
		setCategory: function (data) {
			if (typeof data === 'string') {
				this.selectedCategory = data;
			} else {
				if (!(data instanceof Backbone.Model)) {
					throw new TypeError('data is not an instance of Backbone.Model');
				}
				// data is a instance of model
				this.selectedCategory = data.get('name');
			}
			/**
			 * Category chosen by user from autocomplete results list
			 * @event
			 */
			this.trigger('category:chosen');
		},

		/**
		 * @method
		 * @description Routine to bypass fetch and use parse to filter through cached results
		 *							then reset the collection
		 * @param { string } value - String to filter collection against
		 */
		autocomplete: function (value) {
			if (typeof value !== 'string') {
				throw new TypeError('value must be a String');
			}
			this.query = value.toLowerCase();
			this.parse(this.raw);
			this.reset(this.parse());
		},

		/**
		 * @method
		 * @description Override default passthrough parse to use cache if collection is already populated.
		 *							Also filters results based on user query.
		 *							Uses cached response if available.
		 * @param { object } [ resp ] - Response payload
		 * @returns { object } models - Filtered models to reset collection with
		 */
		parse: function (resp) {
			var models = [],
				self = this;

			// check for cached response
			if (this.raw && this.raw.length) {
				resp = this.raw;
			} else {
				// or cache it if it hasn't been cached before
				this.raw = resp;
			}

			// loop through raw cached results and filter results by user query
			_.each(resp, function (itemName) {
				if (itemName.toLowerCase().indexOf(self.query) !== -1) {
					models.push({
						name: itemName
					});
				}
			});

			return models;
		}
	});

	return CategoryCollection;
});
