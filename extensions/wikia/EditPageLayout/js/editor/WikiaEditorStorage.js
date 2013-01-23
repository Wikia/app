var WikiaEditorStorage = function() {};

WikiaEditorStorage.prototype = {
	categories: undefined,
	summary: undefined,
	content: undefined,
	editorMode: undefined,
	articleId: undefined,
	editorDirty: false,

	store: function() {
		if (typeof wgArticleId !== 'undefined') {
			var editorInstance = window.WikiaEditor.getInstance();

			if (typeof editorInstance.plugins.leaveconfirm === 'undefined' || editorInstance.plugins.leaveconfirm.isDirty()) {
				var summary = $('#wpSummary');
				var categorySelect = $('#CategorySelect').data('categorySelect');

				var toStore = {
					articleId: wgArticleId,
					content: editorInstance.getContent(),
					editorMode: editorInstance.mode,
					summary: summary.exists() ? summary.val() : undefined,
					categories: typeof categorySelect !== 'undefined' ? categorySelect.getData() : undefined
				};

				try {
					$.storage.set(this.getStoreContentKey(), toStore);

				} catch(e) {
					$().log('Local Storage Exception:' + e.message);
					$.storage.flush();
				}
			}
		}
	},

	init: function() {
		this.fetchData();

		GlobalTriggers.bind('WikiaEditorReady', $.proxy(function(editor){
			if (this.getEditorDirty()) {
				editor.fire('markDirty');
				this.modifySummary();
				this.modifyEditorContent(editor);
				this.modifyCategories($('#CategorySelect').data('categorySelect'));
			}
		}, this));
	},

	fetchData: function() {
		var storageKey = this.getStoreContentKey();
		var storageData = $.storage.get(storageKey);

		if (storageData != null && storageData.articleId == wgArticleId) {
			this.editorDirty = true;
			this.summary = storageData.summary;
			this.articleId = storageData.articleId;
			this.content = storageData.content;
			this.editorMode = storageData.editorMode;
			this.categories = storageData.categories;
		}
		$.storage.del(storageKey);
	},

	modifyEditorContent: function(editor) {
		var content = this.getContent();
		var editorMode = this.getEditorMode();

		if (typeof content !== 'undefined' && typeof editorMode !== 'undefined') {
			editor.setContent(content, editorMode);
		}
	},

	modifySummary: function() {
		var summary = this.getSummary();
		if (typeof summary !== 'undefined') {
			$('#wpSummary').val(summary);
		}
	},

	modifyCategories: function(categorySelect) {
		var categories = this.getCategories();
		if (typeof categories !== 'undefined') {
			var actualCategories = categorySelect.getCategories();

			var promises = [];

			for (var i = 0; i < actualCategories.length; i++) {
				promises.push(categorySelect.removeCategory(actualCategories[i]));
			}

			$.when.apply(null, promises).done(function(){
				for (var i = 0; i < categories.length; i++) {
					categorySelect.addCategory(categories[i]);
				}
			});

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

	getCategories: function() {
		return this.categories;
	},

	getEditorDirty: function() {
		return this.editorDirty;
	},

	getStoreContentKey: function() {
		return 'WikiaEditorData';
	}
};

var WikiaEditorStorage = new WikiaEditorStorage();
window.WikiaEditorStorage = WikiaEditorStorage;

WikiaEditorStorage.init();