var WikiaEditorStorage = function() {};

WikiaEditorStorage.prototype = {
	categories: undefined,
	summary: undefined,
	content: undefined,
	editorMode: undefined,
	articleId: undefined,

	store: function() {
		if (typeof(wgArticleId) != undefined) {
			var editorInstance = window.WikiaEditor.getInstance();
			var summary = $('#wpSummary');

			var toStore = {
				articleId: wgArticleId,
				content: editorInstance.getContent(),
				editorMode: editorInstance.mode,
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

		GlobalTriggers.bind('WikiaEditorReady', $.proxy(function(editor){
			this.modifySummary();
			this.modifyEditorContent(editor);
		}, this));
	},

	fetchData: function() {
		var storageKey = this.getStoreContentKey();
		var storageData = $.storage.get(storageKey);

		if (storageData != null && storageData.articleId == wgArticleId) {
			this.summary = storageData.summary;
			this.articleId = storageData.articleId;
			this.content = storageData.content;
			this.editorMode = storageData.editorMode;
		}
		$.storage.del(storageKey);
	},

	modifyEditorContent: function(editor) {
		var content = this.getContent();
		var editorMode = this.getEditorMode();

		if (content != undefined && editorMode != undefined) {
			editor.setContent(content, editorMode);
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

	getEditorMode: function() {
		return this.editorMode;
	},

	getStoreContentKey: function() {
		return 'WikiaEditorData';
	}
};

var WikiaEditorStorage = new WikiaEditorStorage();
WikiaEditorStorage.init();