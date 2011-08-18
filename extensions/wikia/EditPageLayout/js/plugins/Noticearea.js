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
			if( this.visible && this.wasNoticeAlreadyShown( this.ul.find('li').attr('data-hash') ) ) {
				this.visible = false;
			}
			this.el[ this.visible ? 'show' : 'hide' ]();
		},
		
		wasNoticeAlreadyShown: function(noticeHash) {
			this.updateNoticeareaStatus();
			var noticeKey = wgTitle+'-'+noticeHash;
			var noticeareaStatus = $.storage.get('WE-Noticearea-status');
			var result = false;
			if( noticeareaStatus != null ) {
				$.each(noticeareaStatus, function(index, value) {
					if(index == noticeKey) {
						result = true;
					}
				});
			}
			return result;
		},

		markNoticeAsShown: function(noticeHash) {
			var date = new Date();
			var notice = { hash: noticeHash, ts: (date.getTime()/1000) }
			var noticeKey = wgTitle+'-'+notice.hash;
			var noticeareaStatus = $.storage.get('WE-Noticearea-status');
			if(noticeareaStatus == null) {
				noticeareaStatus = {};
			}
			noticeareaStatus[noticeKey] = notice.ts;
			$.storage.set('WE-Noticearea-status', noticeareaStatus);
		},

		updateNoticeareaStatus: function() {
			var noticeareaStatus = $.storage.get('WE-Noticearea-status');
			if( noticeareaStatus != null ) {
				var date = new Date();
				var currentTs = date.getTime()/1000;
				var statusTTL = 86400; // keep status for 24h
				var noticeareaStatusUpdated = {};
				$.each(noticeareaStatus, function(index, value) {
					if( currentTs < (value + statusTTL) ) {
						noticeareaStatusUpdated[index] = value;
					}
				});
				$.storage.set('WE-Noticearea-status', noticeareaStatusUpdated);
			}
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

			this.markNoticeAsShown( this.el.find('li').attr('data-hash') );
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
