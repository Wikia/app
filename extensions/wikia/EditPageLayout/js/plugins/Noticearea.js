(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	/**
	 * Notice area handling
	 */
	WE.plugins.noticearea = $.createClass(WE.plugin,{

		visible: false,

		beforeInit: function() {
			this.editor.on('notice',this.proxy(this.add));
			this.editor.on('editorClick', this.proxy(this.dismissClicked));
		},

		initDom: function() {
			this.el = this.editor.getSpace('notices-short');
			this.ul = this.el.children('ul').first();
			this.htmlEl = this.editor.getSpace('notices-html');
			this.html = this.htmlEl.html();

			this.el.click(this.proxy(this.areaClicked));

			this.notificationsLink = $('#NotificationsLink > a');
			this.notificationsLink.click(this.proxy(this.areaClicked));

			this.notificationsLinkSplotch = this.notificationsLink.children('span');

			this.update();
		},

		getCount: function() {
			return this.ul.children().length;
		},

		update: function() {
			this.visible = (this.getCount() > 0);
			this.el[ this.visible ? 'show' : 'hide' ]();
		},

		areaClicked: function(ev) {
			ev.preventDefault();

			var self = this,
				header = $.htmlentities(this.editor.msg('notices-dialog-title')),
				content = this.html;

			// add copyright notice
			if (window.wgCopywarn) {
				content += window.wgCopywarn;
			}

			$.showModal(header, content, {
				width: 700,
				onClose: function() {
					self.dismissClicked(true /* hideSplotch */);
				}
			});
		},

		dismissClicked: function(hideSplotch) {
			var el = this.el;
			el.fadeOut('slow',function(){
				el.hide();
			});

			// hide notification link splotch
			if (hideSplotch === true) {
				this.notificationsLinkSplotch.fadeOut('slow');
			}
		},

		add: function( message, type, html ) {
			var li = $('<li>').html(message);
			li.addClass('notice-'+(type||'warning'));
			this.ul.append(li);
			if (html)
				this.html += html;
			else
				this.html += '<div>' + message + '</div>';
			this.update();
			return li;
		}

	});

})(this,jQuery);
