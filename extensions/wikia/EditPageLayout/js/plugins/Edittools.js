(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Adds textual link "More shortcuts" into source mode toolbar
	 * which shows a modal popup with edit tools.
	 */
	WE.plugins.edittools = $.createClass(WE.plugin,{

		LINK_CAPTION_MESSAGE: 'editpagelayout-more',
		DIALOG_TITLE_MESSAGE: 'edittools-dialog-title',

		modal: false,
		html: false,

		beforeInit: function() {
			this.editor.on('mediawikiToolbarRendered',this.proxy(this.mediawikiToolbarRendered));
		},

		mediawikiToolbarRendered: function( editor, el ) {
			this.html = this.editor.element.find('.mw-editTools').html();
			if (this.html) {
				var link = $('<span class="cke_toolbar_expand" />');
				link.html('<a class="expand" href="#" style="display: inline;"><label>' + $.msg(this.LINK_CAPTION_MESSAGE) + '</label><span>+</span></a>');
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
