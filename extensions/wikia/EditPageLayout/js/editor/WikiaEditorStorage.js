var WikiaEditorStorage = function() {};

WikiaEditorStorage.prototype = {
	categories: undefined,
	summary: undefined,
	content: undefined,
	articleId: undefined,

	store: function() {
		if (typeof(wgArticleId) != undefined) {
			var editorInstance = window.WikiaEditor.getInstance();
			var summary = $('#wpSummary');

			toStore = {
				articleId: wgArticleId,
				content: editorInstance.getContent(),
				summary: summary.exists() ? summary.val() : undefined

				// TODO
				//categories: categories
			};

			try {
				$.storage.set(this.getStoreContentKey(), toStore);

			} catch(e) {
				$().log('Local Storage Exception:' + e.message);
				$.storage.flush();
			}
		}
	},

	init: function() {
		this.fetchData();

		$(window).bind('beforeWikiaEditorCreate', $.proxy(function(event, data){
				this.modifyEditorContent(data);
			},
			this)
		);
	},

	fetchData: function() {
		var storageKey = this.getStoreContentKey();
		var storageData = $.storage.get(storageKey);

		if (storageData != null && storageData.articleId == wgArticleId) {
			this.summary = storageData.summary;
			this.articleId = storageData.articleId;
			this.content = storageData.content;
		}
		$.storage.del(storageKey);
	},

	modifyEditorContent: function(data) {
		var content = this.getContent();
		if (content != undefined) {
			data.config.body.val(content);
		}
	},

	modifySummary: function() {
		var summary = this.getSummary();
		if (summary != undefined) {
			$('#wpSummary').val(summary);
		}
	},

	getContent: function() {
		return this.content;
	},

	getSummary: function() {
		return this.summary;
	},

	getStoreContentKey: function() {
		return 'WikiaEditorData';
	}
};

var WikiaEditorStorage = new WikiaEditorStorage();
WikiaEditorStorage.init();
$(function(){
	WikiaEditorStorage.modifySummary();
});