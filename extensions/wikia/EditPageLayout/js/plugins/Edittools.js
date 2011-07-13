(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	/**
	 * Adds textual link "More shortcuts" into source mode toolbar
	 * which shows a modal popup with edit tools.
	 */
	WE.plugins.edittools = $.createClass(WE.plugin,{

		LINK_CAPTION_MESSAGE: 'edittools-caption',
		DIALOG_TITLE_MESSAGE: 'edittools-dialog-title',

		modal: false,
		html: false,

		beforeInit: function() {
			this.editor.on('mediawikiToolbarRendered',this.proxy(this.mediawikiToolbarRendered));
		},

		mediawikiToolbarRendered: function( editor, el ) {
			this.html = this.editor.element.find('.mw-editTools').html();
			if (this.html) {
				var link = $('<a class="edittools-button" href="#" />');
				link.text(this.editor.msg(this.LINK_CAPTION_MESSAGE))
				link.click(this.proxy(this.showEdittools));
				$(el).append(link);
			}
		},

		showEdittools: function( evt ) {
			evt && evt.preventDefault();
			var title = $.htmlentities(this.editor.msg(this.DIALOG_TITLE_MESSAGE));
			$.showModal(title,this.html,{
				callback: function() {
					$('#EditPageEditTools').delegate('a','click',function(){
						$('#EditPageEditTools').closeModal();
					});
				},
				id: 'EditPageEditTools',
				width: 680
			});
		}
	});

})(this,jQuery);
