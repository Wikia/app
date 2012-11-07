(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Notice area handling
	 */
	WE.plugins.noticearea = $.createClass(WE.plugin,{

		requires: ['spaces'],

		visible: false,
		itemClass: 'notice-item',
		itemActionClass: 'notice-action',
		dataAttr: 'data-hash',
		totalItemsCount: 0,

		beforeInit: function(editor){
			editor.on('notice',this.proxy(this.add));
			editor.on('editorClick', this.proxy(this.dismissClicked));
		},

		initDom: function(editor){
			var self = this;

			self.el = editor.getSpace('notices-short');
			self.ul = self.el.find('ul').first();
			self.htmlEl = editor.getSpace('notices-html');

			self.notificationsLink = $('#NotificationsLink > a')
				.click(self.proxy(self.areaClicked));

			self.notificationsLinkSplotch = self.notificationsLink.children('span');
			self.notificationsAreaSplotch = self.el.children('.splotch').first();

			if(!self.notificationsLinkSplotch.exists()){
				self.notificationsLink.first().prepend(self.notificationsLinkSplotch = $('<span/>'));

				// Fixes BugId:16528 - If we hide the span before it's added to the DOM
				// it gets an incorrect 'olddisplay' data value which breaks styles
				self.notificationsLinkSplotch.hide();
			}

			self.html = self.htmlEl.html();
			self.totalItemsCount = self.getCount();//needs to be calculated before any notice gets automatically removed

			self.ul
				.delegate(' .' + self.itemActionClass, 'click', function(ev){
					ev.stopPropagation();
					self.areaClicked(ev);
				})
				.delegate('.' + self.itemClass, 'click', self.proxy(self.areaClicked))
				.children('.' + self.itemClass + '[' + self.dataAttr + ']').each(function(){
					if(self.wasNoticeAlreadyShown(this)){
						self.markNoticeAsShown(this);
					}
				});

			this.update();
		},

		getAllNotices: function(){
			return this.ul.children('.' + this.itemClass);
		},

		getCount: function(){
			return this.getAllNotices().length;
		},

		getTotalCount: function(){
			return this.totalItemsCount;
		},

		getNoticeByHash: function(hash){
			return this.getAllNotices().filter('[' + this.dataAttr + '="' + hash + '"]');
		},

		getNotice: function(hashOrElement){
			var el;

			if(typeof hashOrElement == 'string'){
				el = this.getNoticeByHash(hashOrElement);
			}

			if(!el || !el.hasClass(this.itemClass)){
				el = $(hashOrElement);
			}

			return (el.hasClass(this.itemClass)) ? el : null;
		},

		updateSplotch: function(){
			var val = this.getTotalCount();

			this.notificationsLinkSplotch.html(val);
			this.notificationsAreaSplotch.html(val);

			if(val > 0){
				this.notificationsLinkSplotch.fadeIn('slow');
				this.notificationsAreaSplotch.fadeIn('slow');
			}
		},

		hideSplotch: function(){
			this.notificationsLinkSplotch.fadeOut('slow');
			this.notificationsAreaSplotch.fadeOut('slow');
		},

		generateNoticeKey: function(hash){
			return wgTitle + '-' + hash;
		},

		getNoticeAreaStatus: function(){
			return $.storage.get('WE-Noticearea-status');
		},

		setNoticeAreaStatus: function(status){
			$.storage.set('WE-Noticearea-status', status);
		},

		update: function(){
			var count = this.getCount();

			if(count > 0){
				this.visible = true;
				this.updateSplotch();
			}else{
				this.visible = false;
			}

			this.el[ this.visible ? 'show' : 'hide' ]();
		},

		wasNoticeAlreadyShown: function(hashOrElement){
			this.updateNoticeareaStatus();

			var notice = this.getNotice(hashOrElement),
				hash = (notice) ? notice.attr(this.dataAttr) : null,
				isMainPageEduNote = this.isNoticeMainPageEduNote(notice),
				result = false;

			if( hash && !isMainPageEduNote ) {
				var noticeKey = this.generateNoticeKey(hash),
					noticeareaStatus = this.getNoticeAreaStatus();

				if( noticeareaStatus != null ) {
					$.each(noticeareaStatus, function(index, value) {
						if(index == noticeKey) {
							result = true;
						}
					});
				}
			}

			return result;
		},

		isNoticeMainPageEduNote: function(notice) {
			var hash = notice.attr(this.dataAttr),
				result = false;

			if( hash && window.mainPageEduNoteHash && hash == window.mainPageEduNoteHash ) {
				result = true;
			}

			return result;
		},

		markNoticeAsShown: function(hashOrElement) {
			var notice = this.getNotice(hashOrElement),
				isMainPageEduNote = this.isNoticeMainPageEduNote(notice);

			if( notice ) {
				var hash = notice.attr(this.dataAttr);

				if( hash && !isMainPageEduNote ) {
					var ts = (new Date()).getTime()/1000,
						noticeKey = this.generateNoticeKey(hash),
						noticeareaStatus = this.getNoticeAreaStatus() || {};

					noticeareaStatus[noticeKey] = ts;
					this.setNoticeAreaStatus(noticeareaStatus);
				} else if( hash && isMainPageEduNote && window.wgUserName ) {
					$.nirvana.sendRequest({
						controller: 'WikiaUserProperties',
						method: 'dismissRTEMainPageNotice',
						type: 'post',
						format: 'json',
						callback: $.proxy(this.onDismissRTEMainPageNotice, this)
					});
				}

				notice.remove();
			}
		},

		onDismissRTEMainPageNotice: function(response) {
			if( response.result && response.result.success != true ) {
				$().log('Noticearea error: wrong during dissmissing main page edu note');

				if( response.result.error ) {
					$().log(response.result.error);
				}
			}
		},

		updateNoticeareaStatus: function(){
			var noticeareaStatus = this.getNoticeAreaStatus();

			if(noticeareaStatus != null){
				var currentTs = (new Date()).getTime()/1000,
					statusTTL = 86400, // keep status for 24h
					noticeareaStatusUpdated = {};

				$.each(noticeareaStatus, function(index, value) {
					if(currentTs < (value + statusTTL)){
						noticeareaStatusUpdated[index] = value;
					}
				});

				this.setNoticeAreaStatus(noticeareaStatusUpdated);
			}
		},

		dismissFromNotice: function(notice){
			this.totalItemsCount = 0;
			this.updateSplotch();
			this.dismissClicked(notice, true);
		},

		areaClicked: function(ev){
			var self = this,
				target = $(ev.target);

			if(target.hasClass(self.itemActionClass)){
				self.dismissFromNotice(target.closest('.' + self.itemClass));
			}else{
				ev.preventDefault();

				var header = $.htmlentities(self.editor.msg('notices-dialog-title')),
					content = self.html;

				// add copyright notice
				if (window.wgCopywarn) {
					content += window.wgCopywarn;
				}

				$.showModal(header, content, {
					width: 700,
					onClose: function() {
						self.dismissFromNotice(ev.target);
					}
				});
			}
		},

		dismissClicked: function(sourceElement, hideSplotch){
			var self = this,
				notices = self.getNotice(sourceElement) || self.getAllNotices(),
				clean = function(){
					notices.each(function(){
						self.markNoticeAsShown(this);
					});
				};

			// hide notification link splotch
			if(hideSplotch === true){
				self.hideSplotch();
			}

			if(notices.length == self.getCount()){
				self.el.fadeOut('slow', clean);
			}else{
				clean();
			}
		},

		add: function(message, type, html){
			var li = $('<li>')
				.html(message)
				.addClass(this.itemClass + ' notice-' + (type || 'warning'));

			this.ul.append(li);

			if(html){
				this.html += html;
			}else{
				this.html += '<div>' + message + '</div>';
			}

			this.totalItemsCount++;
			this.update();
			return li;
		}

	});

})(this,jQuery);
