(function($) {
	var MessageTopic = function(el, options) {
		this.el = el;
		this.options = options;
		this.selectedEntries = {};
		this.topicList = this.el.find('.message-topic-list');
		this.topicTemplate = $('#MessageTopicTemplate');
		this.errorTemplate = $('#MessageTopicErrorTemplate');
		this.errorLimitTemplate = $('#MessageTopicErrorLimitTemplate');
		this.input = this.el.find('.message-topic-input');
		this.error = this.el.find('.message-topic-error');
		this.inputMax = 4;

		this.el
			.on('click.MessageTopic', '.topic .remove-swatch', $.proxy(this.handleRemove, this))
			.on('keypress.MessageTopic', '.message-topic-input', $.proxy(this.handleKeypress, this));
	};

	MessageTopic.prototype = {
		addSelection: function(selection) {
			if(this.getTopics().length === this.inputMax) {
				this.error.html(this.errorLimitTemplate.mustache({limit: this.inputMax}));
				return false;
			} else {
				this.error.html('');
			}

			if(!this.selectedEntries[selection]) {
				this.selectedEntries[selection] = true;
				var topic = this.topicTemplate.mustache({articleTitle:selection});
				this.topicList.append(topic);
				return true;
			}

			return false;
		},

		removeSelection: function(selection) {
			delete this.selectedEntries[selection];
		},

		resetSelections: function(selections) {
			this.selectedEntries = {};
			this.topicList.children().remove();
			if(selections) {
				for(var i = 0; i < selections.length; i++) {
					this.addSelection(selections[i]);
				}
			}
		},

		handleRemove: function(e) {
			var topic = $(e.target).closest('.topic');
			this.removeSelection(topic.data('article-title'));
			topic.remove();
		},

		getTopics: function() {
			var topics = [];
			for(var selection in this.selectedEntries) {
				topics.push(selection);
			}
			return topics;
		},

		handleKeypress: function(e) {
			var code = e.keyCode || e.which,
				query = this.input.val();
			if (code == 13 && query) {
				var self = this;
				$.when(this.checkTopic(query)).done(function(exists) {
					if(exists) {
						self.addSelection(query);
					} else {
						self.error.html(self.errorTemplate.mustache({query: query}));
					}
				});
				this.input.val('');
			}
		},

		getSuggestions: function(q) {
			var d = $.Deferred();
			$.ajax({
				url: wgScript,
				data: {
					action: 'ajax',
					rs: 'getLinkSuggest',
					format: 'json',
					nospecial: 1,
					nsfilter: 0,
					query: q
				},
				method: 'post',
				success: function(response) {
					d.resolve(response.suggestions);
				}
			});

			return d.promise();
		},

		checkTopic: function(title) {
			var d = $.Deferred();
			mw.loader.using('mediawiki.api', function() {
				(new mw.Api()).get({
					action: 'query',
					titles: title,
					prop: 'info'
				}).done(function (res) {
					var exists = !res.query.pages['-1'];
					d.resolve(exists);
				});
			});
			return d.promise();
		}

	};

	$.fn.messageTopic = function(options) {
		return this.each(function() {
			var messageTopicContainer = $(this);
			var messageTopic = new MessageTopic(messageTopicContainer, options);
			$.when(
				$.loadJQueryAutocomplete(),
				$.loadMustache()
			).then(function() {
				messageTopic.autocomplete = messageTopic.input.autocomplete({
					serviceUrl: wgScript + '?action=ajax&rs=getLinkSuggest&format=json&nospecial=1&nsfilter=0',
					onSelect: function(value, data) {
						$().log("on select");
						messageTopic.addSelection(value);
						messageTopic.input.val('');
					},
					appendTo: messageTopicContainer,
					deferRequestBy: 200,
					minLength: 2,
					maxHeight: 1000,
					maxSuggestions: 6,
					selectedClass: 'selected',
					width: '100%',
					skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
				});
				if(options && options.topics) {
					var topics = options.topics;
					for(var i = 0; i < topics.length; i++) {
						messageTopic.addSelection(topics[i]);
					}
				}
			});

			messageTopicContainer.data('messageTopic', messageTopic);

			return messageTopic;
		});
	};
})(jQuery);
