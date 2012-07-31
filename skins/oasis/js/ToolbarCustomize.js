(function(){
	window.ToolbarCustomize = window.ToolbarCustomize || {};
	var TC = window.ToolbarCustomize;

	TC.OptionsTree = $.createClass(Observable,{

		constructor: function(el) {
			TC.OptionsTree.superclass.constructor.call(this);
			this.el = el;
			this.el.sortable({
				axis: "y",
				handle: ".drag",
				opacity: 0.8,
				update: $.proxy(this.updateLevels,this)
			});
		},

		/* assumes one my tools menu */
		updateLevels: function() {
			var all = this.el.children('li');
			all.removeClass('list-item-indent-1');
			var level = 0;
			all.each(function(i,v){
				if ($(v).hasClass('list-item-menu')) {
					level++;
				} else if (level > 0) {
					$(v).addClass('list-item-indent-'+level);
				}
			});

			this.el.find('.tree-visual').remove();
			var ind = this.el.children('li.list-item-indent-1');
			ind.prepend('<span class="tree-visual tree-line"></span><span class="tree-visual tree-dash"></span>');
			ind.last().find('.tree-visual').remove();
			ind.last().prepend('<span class="tree-visual tree-line-last"></span><span class="tree-visual tree-dash"></span>');

			this.fire('update',this);
		},

		buildItem: function( item, level ) {
			var type = (item.id.substr(0,5) == "Menu:") ? 'menu' : 'item';
			var cl = level ? 'list-item-indent-'+level : '';
			if (type == 'menu') {
				cl += ' list-item-menu';
			}
			var html =
				'<li'
				+' data-tool-id="'+$.htmlentities(item.id)+'"'
				+' data-default-caption="'+$.htmlentities(item.defaultCaption)+'"'
				+' data-caption="'+$.htmlentities(item.caption)+'"'
				+(cl?' class="'+cl+'"':'')+'>';
			if (type == 'menu') {
				html += '<img src="'+wgBlankImgUrl+'" class="folder-icon" height="16" width="16" />';
			}
			html += '<span class="name">'+$.htmlentities(item.caption)+'</span>';
			if (type == 'item') {
				html +=
				'<img src="'+wgBlankImgUrl+'" class="sprite edit-pencil">'
				+'<img src="'+wgBlankImgUrl+'" class="sprite trash">'
				+'<img src="'+wgBlankImgUrl+'" class="sprite drag">';
			}
			html += '</li>';
			var itemEl = $(html);
			this.fire('itembuild',this,item,itemEl);
			return itemEl;
		},

		loadLevel: function(els,level) {
			for (var i=0;i<els.length;i++) {
				this.el.append(this.buildItem(els[i],level));
				if (els[i].items) {
					this.loadLevel(els[i].items,level+1);
				}
			}
		},

		load: function(data) {
			this.el.empty();
			this.loadLevel(data,0);
			this.updateLevels();
		},

		save: function() {
			var all = this.el.children('li');
			var stack = [[]];
			var level = 0;
			all.each(function(i,v){
				v = $(v);
				var o = { id: v.attr('data-tool-id'), defaultCaption: v.attr('data-default-caption'), caption: v.attr('data-caption') };
				stack[level].push(o);
				if (v.hasClass('list-item-menu')) {
					level = 1;
					o.items = [];
					o.isMenu = true;
					stack[level] = o.items;
				}
			});
			return stack[0];
		},

		update: function() {
			this.updateLevels();
		},

		add: function(item,level) {
			// add to my tools
			var itemEl = this.buildItem(item,level || 0);
			if (level == 0) {
				var mytools = this.el.children('.list-item-menu');
				if (mytools) mytools.before(itemEl);
				else this.el.append(itemEl);
			} else {
				this.el.append(itemEl);
			}
			this.scrollToItem(itemEl);
			this.updateLevels();
		},

		scrollToItem: function(itemEl) {
			var scroll = this.el.scrollTop();
			var delta = itemEl.offset().top - this.el.offset().top;
			var max = this.el.innerHeight() - itemEl.outerHeight();
			var move = 0;
			if (delta > max) {
				move = delta - max;
			}
			if (delta < 0) {
				move = delta;
			}
			if (move != 0) {
				this.el.scrollTop(scroll+move);
			}
		}

	});

	TC.OptionLinks = $.createClass(Observable,{

		constructor: function(el) {
			TC.OptionLinks.superclass.constructor.call(this);
			this.el = el;
		},

		onItemClick: function(evt) {
			evt.preventDefault();
			this.fire('itemclick',this,$(evt.target).attr('data-tool-id'));
			return false;
		},

		buildItem: function(item) {
			var html =
				'<li>'
				+ '<a href="#" data-tool-id="'+$.htmlentities(item.id)+'">'
				+ $.htmlentities(item.defaultCaption)
				+ '</a></li>';
			var itemEl = $(html);
			itemEl.find('a').click($.proxy(this.onItemClick,this));
			return itemEl;
		},

		load: function(els) {
			this.el.empty();
			for (var i=0;i<els.length;i++) {
				this.el.append(this.buildItem(els[i]));
			}
		}

	});

	TC.Toggle = $.createClass(Object,{
		constructor: function(target,buttons,cls) {
			this.target = target;
			this.buttons = buttons;
			this.cls = cls;
			this.state = false;

			this.hide();
			this.buttons.bind('click.toggle',$.proxy(this.toggle,this));
		},

		hide: function() {
			this.target.hide();
			this.buttons.hide();
			this.buttons.filter('.'+this.cls).show();
		},

		show: function() {
			this.target.show();
			this.buttons.hide();
			this.buttons.not('.'+this.cls).show();
		},

		toggle: function( evt ) {
			this[ $(evt.currentTarget).hasClass(this.cls) ? "show" : "hide" ]();
		}

	});

	TC.ModalBox = $.createClass(Observable,{

		w: false,
		options: false,

		constructor: function(html,options) {
			TC.ModalBox.superclass.constructor.call(this);
			this.html = html;
			this.options = options || {};
		},

		show: function() {
			if (this.w != false)
				return;
			this.w = $(this.html).makeModal(this.options);
		},

		close: function() {
			this.w.closeModal();
			this.w = false;
		}

	});

	TC.InputModalBox = $.createClass(TC.ModalBox,{

		constructor: function(html,options) {
			TC.InputModalBox.superclass.constructor.call(this,html,options);
		},

		show: function() {
			TC.InputModalBox.superclass.show.call(this);
			this.w.find('.input-box').val(this.options.value);
			this.w.find('.save-button').click($.proxy(this.save,this));
			this.w.find('.cancel-button').click($.proxy(this.close,this));
		},

		save: function() {
			var value = this.w.find('.input-box').val();
			this.fire('save',this,value);
			this.close();
		}

	});

	TC.Configuration = $.createClass(Object,{

		toolbar: false,
		data: false,

		w: false,
		tree: false,
		popular: false,
		toggle: false,

		constructor: function(toolbar) {
			TC.Configuration.superclass.constructor.call(this);
			this.toolbar = toolbar;
		},

		show: function() {
			// load CSS, JS libraries and make AJAX request in one request
			$.when(
				$.loadJQueryAutocomplete(),
				$.loadJQueryUI(),
				$.getResources([
					$.getSassCommonURL("skins/oasis/css/core/ToolbarCustomize.scss")
				]),
				$.nirvana.sendRequest({
					controller: 'Footer',
					method: 'ToolbarConfiguration',
					callback: $.proxy(this.onDataLoaded,this)
				})
			).
			done($.proxy(this.checkLoad,this)).
			fail($.proxy(this.onLoadFailure,this));
		},

		onDataLoaded: function(data,textStatus,req) {
			this.data = data;
		},

		onLoadFailure: function(req,textStatus,errorThrown) {
		},

		checkLoad: function() {
			// Code copy from $.getModal() :-(
			$('body').append(this.data.configurationHtml);
			this.w = $("#MyToolsConfiguration").makeModal({
				width: 710,
				closeOnBlackoutClick: false
			});
			// End of copy

			this.w.find('form')
				// Disable submitting
				.submit(function(){return false;})
				// Disable submission after pressing enter key
				.keypress(function(e){if (e.which == 13) {return false;}});

			// Toolbar list
			this.tree = new TC.OptionsTree(this.w.find('.options-list'));
			this.tree.on('itembuild',$.proxy(this.initItem,this));
			this.tree.load(this.data.options);
			this.w.find('.reset-defaults a').click($.proxy(this.loadDefaults,this));

			// Find a tool
			this.w.find('.search').placeholder();
			this.w.find('.search').pluginAutocomplete({
				lookup: this.getAutocompleteData(),
				onSelect: $.proxy(this.addItemFromSearch,this),
				selectedClass: 'selected',
				appendTo: this.w.find('.search-box'),
				width: '300px'
			});
			this.w.find('.advanced-tools').find('a').attr('target','_blank');

			// Popular tools
			this.popular = new TC.OptionLinks(this.w.find('.popular-list'));
			this.popular.load(this.data.popularOptions);
			this.popular.on('itemclick',this.addPopularOption,this);
			var group = this.w.find('.popular-tools-group');
			this.toggle = new TC.Toggle(group.children('.popular-list'),group.children('.popular-toggle'),'toggle-1');
			this.w.find('.popular-toggle').click($.proxy(this.togglePopular,this));

			// Save and cancel
			this.w.find('input[type=submit]').click($.proxy(this.save,this));
			this.w.find('input.cancel-button').click($.proxy(this.close,this));
		},

		getAutocompleteData: function() {
			var suggestions = [];
			var data = [];
			for (var i=0;i<this.data.allOptions.length;i++) {
				suggestions.push(this.data.allOptions[i].caption);
				data.push(this.data.allOptions[i].id);
			}
			return {
				suggestions: suggestions,
				data: data
			};
		},

		findOptionByName: function( id ) {
			for (var i=0;i<this.data.allOptions.length;i++) {
				if (this.data.allOptions[i].id == id) {
					return this.data.allOptions[i];
				}
			}
			return false;
		},

		findOptionByCaption: function( caption ) {
			for (var i=0;i<this.data.allOptions.length;i++) {
				if (this.data.allOptions[i].caption == caption) {
					return this.data.allOptions[i];
				}
			}
			return false;
		},

		addItemFromSearch: function(value, data) {
			var item = this.findOptionByName(data);
			if (item) {
				this.tree.add(item,0);
			}
			this.w.find('.search').val('');
		},

		addPopularOption: function( popular, id ) {
			var item = this.findOptionByName(id);
			if (item) this.tree.add(item,0);
			return false;
		},

		loadDefaults: function() {
			this.tree.load(this.data.defaultOptions);
			return false;
		},

		initItem: function( tree, item, el ) {
			el.find('.edit-pencil').click($.proxy(this.renameItem,this));
			el.find('.trash').click($.proxy(this.deleteItem,this));
		},

		renameItem: function( evt ) {
			var item = $(evt.currentTarget).closest('li');
			var d = new TC.InputModalBox(this.data.renameItemHtml,{
				width: 360,
				topOffset: 150,
				value: item.attr('data-caption')
			});
			d.bind('save',$.proxy(function(dialog,value){
				item.attr('data-caption',value);
				item.find('.name').text(value);
			},this));
			d.show();
			return false;
		},

		deleteItem: function( evt ) {
			$(evt.currentTarget).closest('li').remove();
			this.tree.update();
			return false;
		},


		save: function() {
			var toolbar = this.tree.save();
			$.nirvana.sendRequest({
				controller: 'Footer',
				method: 'ToolbarSave',
				data: {
					title: window.wgPageName,
					toolbar: toolbar
				},
				callback: $.proxy(this.afterSave,this)
			});
		},

		afterSave: function(data,status,req) {
			if (status == "success" && data.status) {
				this.toolbar.load(data.toolbar);
				this.close();
			} else {
				// show error to the user
			}
		},

		close: function() {
			this.w.closeModal();
		}

	});

	window.ToolbarCustomize = TC;
})();
