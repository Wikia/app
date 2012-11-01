(function(window,$){

	var createClass = function (sc,o) {
		var constructor = o.constructor;
		if (typeof constructor != 'function' || constructor == Object.prototype.constructor) {
			constructor = function(){sc.apply(this,arguments);};
		}
		var bc = constructor;
		var f = function() {};
		f.prototype = sc.prototype || {};
		bc.prototype = new f();

		// macbre: support static members
		if (typeof o.statics == 'object') {
			bc = $.extend(bc, o.statics);
			delete o.statics;
		}

		for (var m in o) {
			bc.prototype[m] = o[m];
		}

		bc.prototype.constructor = bc;
		bc.superclass = sc.prototype;

		return bc;
	};
	var noop = function() {};
	var proxy = function( fn, scope ) {
		return function() {
			return typeof fn === 'function' && fn.apply(scope,arguments);
		};
	};
	function err( msg ) {
		alert(msg);
	}
	function log( msg ) {
		window.console && console.log && console.log(msg);
	}

	/* UTILS */
	var EventEmitter;

	EventEmitter = createClass(Object,{
		constructor: function() {
			this.eventEl = $('<div>');
		},
		bind: function() {
			return this.eventEl.bind.apply(this.eventEl,arguments);
		},
		unbind: function() {
			return this.eventEl.unbind.apply(this.eventEl,arguments);
		},
		trigger: function() {
			return this.eventEl.trigger.apply(this.eventEl,arguments);
		}
	});

	/* MODEL */

	var Node, Tree, TreeBuilder;
	var TraceNode, TraceTreeBuilder;

	/* Node */
	Node = createClass(Object,{
		constructor: function( parent, id ) {
			this.parent = parent;
			this.id = id;
			this.children = [];
			this.seqIn = 0;
			this.seqOut = 0;
		},
		add: function( id ) {
			var child = new this.constructor(this,id);
			this.children.push(child);
			return child;
		},
		remove: function( child ) {
			var i = this.children.indexOf(child);
			if ( i >= 0 ) {
				this.children.splice(i,1);
			}
		},
		traverse: function( enterCallback, leaveCallback ) {
			var inResult = enterCallback && enterCallback.call(this,this),
				i;
			if ( inResult !== false ) {
				var children = [].concat(this.children);
				for (i=0;i<children.length;i++) {
					children[i].traverse(enterCallback,leaveCallback);
				}
			}
			leaveCallback && leaveCallback.call(this,this);
		},
		clone: function( parent ) {
			var copy = new this.constructor(parent,this.id),
				i;
			for (i=0;i<this.children.length;i++) {
				var child = this.children[i].clone(copy);
				copy.children.push(child);
			}
			copy.seqIn = this.seqIn;
			copy.seqOut = this.seqOut;
			return copy;
		}
	});

	/* Tree */
	Tree = {};

	/* TreeBuilder */
	TreeBuilder = createClass(Object,{
		nodeClass: Node,
		constructor: function() {
			this.reset();
		},
		reset: function() {
			var cls = this.nodeClass;
			this.root = new cls();
			this.stack = [ this.root ];
			this.seqId = 1;
		},
		top: function() {
			return this.stack.length > 0 ? this.stack[this.stack.length-1] : undefined;
		}
	});

	/* TraceNode */
	TraceNode = createClass(Node,{
		constructor: function( parent, id ) {
			TraceNode.superclass.constructor.apply(this,arguments);
			this.totalTime = 0;
			this.selfTime = 0;
		},
		refreshTotalTime: function( recursive ) {
			if ( this.selfTime < 0 ) {
				this.selfTime = 0;
			}
			var totalTime = this.selfTime, i;
			for (i=0;i<this.children.length;i++) {
				if ( recursive !== false ) {
					this.children[i].refreshTotalTime( true );
				}
				totalTime += this.children[i].totalTime;
			}
			this.totalTime = totalTime;
		},
		clone: function( parent ) {
			var copy = TraceNode.superclass.clone.call(this,parent);
			copy.totalTime = this.totalTime;
			copy.selfTime = this.selfTime;
			return copy;
		}
	});

	/* TraceTreeBuilder */
	TraceTreeBuilder = createClass(TreeBuilder,{
		nodeClass: TraceNode,
		startNode: function( id, time, mem ) {
			var top = this.top();
			var node = top.add(id);
			node.seqIn = this.seqId++;
			this.stack.push(node);
			return node;
		},
		endNode: function( id, time, mem ) {
			if ( this.stack.length < 2 ) {
				err('trace error');
				return;
			}
			var node = this.stack.pop();
			if ( !node || node.id !== id ) {
				err('trace error');
				return;
			}

			node.seqOut = this.seqId++;
			node.totalTime += time;
			node.selfTime += time;
			node.parent.selfTime -= time;
		},
		endTree: function() {
			this.root.selfTime = 0;
			this.root.refreshTotalTime( /* recursive? */ false );
		},
		fromText: function( text ) {
			this.reset();
			var lines = text.split("\n"), i,
				REGEX = /^([0-9.]+)?\s*([-0-9.]+)\s*([><])\s*(.*)$/;
			for (i=0;i<lines.length;i++) {
				var line = lines[i],
					m = REGEX.exec(line);
				if ( m ) {
					var time = m[1] ? parseFloat(m[1]) : 0,
						mem = parseFloat(m[2]),
						entering = m[3] == '>',
						name = m[4];
					if ( entering ) {
						this.startNode(name,time,mem);
					} else {
						this.endNode(name,time,mem);
					}
				}
			}
			this.endTree();
			return this.root;
		},
		fromDom: function() {
			var text = '';
			var node = window.document.lastChild;
			if ( node.nodeType == 8 /* comment */ && /Beginning trace/.test(node.textContent) ) {
				text = node.textContent;
			}
			return this.fromText(text);
		}
	});

	var TreeCut, TreeSelect, TreeNullify;

	TreeCut = createClass(Object,{
		constructor: function( condition ) {
			this.condition = condition;
		},
		exec: function( node, inBulk ) {
			if ( !inBulk ) {
				node = node.clone();
			}
			node.traverse(proxy(this.enter,this));
			if ( !inBulk ) {
				node.refreshTotalTime();
			}
			return node;
		},
		enter: function( node ) {
			if ( this.condition.call(node,node) ) {
				node.parent.remove(node);
				return false; // don't go to children
			}
		}
	});

	TreeSelect = createClass(Object,{
		constructor: function( condition ) {
			this.condition = condition;
		},
		exec: function( node, inBulk ) {
			var tree = this.tree = new node.constructor();
			node.traverse(proxy(this.enter,this));
			delete this.tree; // free memory
			if ( !inBulk ) {
				tree.refreshTotalTime();
			}
			return tree;
		},
		enter: function( node ) {
			if ( this.condition.call(node,node) ) {
				this.tree.children.push(node.clone());
				return false; // don't go to children
			}
		}
	});

	TreeNullify = createClass(Object,{
		constructor: function( condition ) {
			this.condition = condition;
		},
		exec: function( node, inBulk ) {
			if ( !inBulk ) {
				node = node.clone();
			}
			node.traverse(proxy(this.enter,this));
			if ( !inBulk ) {
				node.refreshTotalTime();
			}
			return node;
		},
		enter: function( node ) {
			if ( this.condition.call(node,node) ) {
				node.selfTime = 0;
			}
		}
	});

	var TraceData, MethodIndexBuilder;

	TraceData = createClass(EventEmitter,{
		tree: false,
		contexts: [],
		profileTime: 0,
		profileCount: 0,
		getProfileTimeEnter: function( node ) {
			if ( node.id == 'Profiler::noop' ) {
				this.profileTime += node.selfTime;
				this.profileCount++;
			}
		},
		adjustProfileTimeEnter: function( node ) {
			if ( node.id == 'Profiler::noop' ) {
				node.selfTime = 0;
			} else {
				node.selfTime -= this.profileTime;
				node.parent && (node.parent.selfTime -= this.profileTime);
			}
		},
		fixProfileTime: function() {
			this.tree.traverse(proxy(this.getProfileTimeEnter,this))
			if ( this.profileCount > 0 ) {
				this.profileTime /= this.profileCount;
				this.tree.traverse(proxy(this.adjustProfileTimeEnter,this))
				this.tree.refreshTotalTime();
			}
		},
		initFromDom: function() {
			var builder = new TraceTreeBuilder;
			this.tree = builder.fromDom();
			this.fixProfileTime();
			this.contexts.push(['All',this.tree]);
		}
	});

	MethodIndexBuilder = createClass(Object,{
		constructor: function( tree ) {
			this.tree = tree;
			this.index = undefined;
		},
		getIndex: function() {
			if ( !this.index ) {
				this.buildIndex();
			}
			return this.index;
		},
		buildIndex: function() {
			var i, method;
			this.index = this.methods = {};
			this.tree.traverse($.proxy(this.enter,this),$.proxy(this.leave,this));
		},
		initMethod: function( id ) {
			var method = this.methods[id] = {
				id: id,
				depth: 0,
				totalTime: 0,
				selfTime: 0,
				calls: 0,
				nodes: []
			};
			return method;
		},
		enter: function( node ) {
			if ( !node.id ) return;
			var id = node.id.replace(/!.*$/,''); // remove HIT/MISS from memcache calls
			var method = this.methods[id] = this.methods[id] || this.initMethod(node.id);
			method.calls++;
			method.depth++;
			method.nodes.push(node);
		},
		leave: function( node ) {
			if ( !node.id ) return;
			var id = node.id.replace(/!.*$/,''); // remove HIT/MISS from memcache calls
			var method = this.methods[id] = this.methods[id] || this.initMethod(node.id);

			// totalTime
			if ( method.depth == 1 ) {
				method.totalTime += node.totalTime;
			}

			// selfTime
			method.selfTime += node.selfTime;

			method.depth--;
		}
	});

	/* VIEW */

	var TraceDialog, MethodIndexView;

	MethodIndexView = createClass(Object,{
		sortKey: 'totalTime',
		setTree: function( tree ) {
			this.tree = tree;
			var builder = new MethodIndexBuilder(this.tree);
			this.index = builder.getIndex();
			this.sortBy(this.sortKey);
			this.html = false;
		},
		sortBy: function( sortKey ) {
			var list = [], index = this.index, i;
			for (i in index) list.push(index[i]);
			list.sort(function(a,b){return b[sortKey]-a[sortKey];});
			index = {};
			for (i=0;i<list.length;i++) {
				index[list[i].id] = list[i];
			}
			this.index = index;
			this.html = false;
		},
		setSort: function( sortKey ) {
			if ( sortKey == this.sortKey ) {
				return; // noop
			}
			this.sortKey = sortKey;
			this.sortBy(sortKey);
		},
		buildHtml: function() {
			if ( !this.index ) {
				return '';
			}

			var i, j, html = '', columns, columnIds, columnSortKeys,
				index = this.index;

			var total = 0;
			for (i in index) {
				total += index[i].selfTime;
			}

			columns = "Self Time|Total Time|% Self|% Total|Calls|Method".split('|');
			columnIds = "trace-self-time|trace-total-time|trace-self-pct|trace-total-pct|trace-calls|trace-method-name".split('|');
			columnSortKeys = "||selfTime|totalTime|calls|".split('|');

			html += 'Total: <b>' + total.toFixed(5) + '</b><br />';
			html += '<table class="sortable php-trace-summary"><tr>';
			for (i=0;i<columns.length;i++) {
				html += '<th class="'+columnIds[i]+'">';
				if ( columnSortKeys[i] ) {
					html +=
						'<a href="#" class="sort-key" data-sort-key="'+columnSortKeys[i]+'">'
						+ columns[i]
						+'</a>';
				} else {
					html += columns[i];
				}
				html += '</th>';
			}
			for (i in index) {
				var method = index[i],
					row = [
						method.selfTime.toFixed(5),
						method.totalTime.toFixed(5),
						(100.0*method.selfTime/total).toFixed(2),
						(100.0*method.totalTime/total).toFixed(2),
						method.calls,
						'<a href="#" class="method-cut" data-method-id="'+method.id+'">[X]</a> '
							+ '<a href="#" class="method-nullify" data-method-id="'+method.id+'">[N]</a> '
							+ '<a href="#" class="method-call" data-method-id="'+method.id+'">'+method.id+'</a>',
					];
				html += '<tr>';
				for (j=0;j<row.length;j++) {
					html += '<td class="'+columnIds[j]+'">' + row[j] + '</td>';
				}
				html += '</tr>';
			}
			html += '</tr></table>';
			return html;
		},
		getHtml: function() {
			if ( !this.html ) {
				this.html = this.buildHtml();
			}
			return this.html;
		}
	});

	TraceDialog = createClass(Object,{
		constructor: function( data, ctrl ) {
			this.data = data;
			this.ctrl = ctrl;
			this.methodIndexView = new MethodIndexView();
		},
		proxy: function( fn ) {
			return proxy(fn||noop,this);
		},
		setup: function() {
			if ( this.el ) return;
			var el = this.el = $('<div id="PHPTrace"></div>'),
				w = $(window);
			$('body').append(el);
			var opts = {
				width: w.width() - 20,
				height: w.height() - 20,
				zIndex: 1900000000,
				resizable: false,
				title: 'PHP Trace Browser',
				draggable: false,
				closeOnEscape: false,
				dialogClass: 'ui-traceviewer',
				close: this.proxy(this.modalClosed)
			};
			el.dialog(opts);
			el.closest('.ui-dialog').css({height:w.height()-20});

			// populate tabs
			var tabs = {
				dashboard: 'Dashboard',
				methods: 'Methods Summary'
			};
			var html = '';
			html += '<div id="trace-summary">';
			html += '</div>';
			html += '<div id="trace-context-list">';
			html += '</div>';
			html += '<div id="trace-tabs-wrapper"><ul>';
			for (i in tabs) {
				html += '<li><a href="#trace-'+i+'">'+tabs[i]+'</a></li>';
			}
			html += '</ul>';
			for (i in tabs) {
				html += '<div id="trace-'+i+'"></div>';
			}
			html += '</div>';
			el.html(html);
			this.tabs = $('#trace-tabs-wrapper');
			this.tabs.tabs({
				selected: 1,
				select: this.proxy(this.tabActivated)
			});
			this.summary = $('#trace-summary');
			this.contextList = $('#trace-context-list');
			for (i in tabs) {
				this[i] = $('#trace-'+i);
			}

			this.contextList.on('click','a.context-link', this.proxy(this.contextLinkClicked));
			this.methods.on('click','a.method-call', this.proxy(this.methodClicked));
			this.methods.on('click','a.method-cut', this.proxy(this.methodCutClicked));
			this.methods.on('click','a.method-nullify', this.proxy(this.methodNullifyClicked));
			this.methods.on('click','a.sort-key', this.proxy(this.sortClicked));
		},
		show: function() {
			this.setup();
			this.updateSummary();
			this.loadContext(0);
		},
		loadContext: function( id ) {
			this.currentContext = id;
			var context = this.data.contexts[this.currentContext],
				name = context[0],
				tree = context[1];

			this.methodIndexView.setTree(tree);
			this.updateMethods();
			this.updateContextList();
		},
		contextLinkClicked: function( ev ) {
			var target = $(ev.currentTarget),
				contextId = target.data('context-id');
			if ( contextId || contextId === 0 || contextId === '0' ) {
				this.ctrl.switchContext(contextId);
			}
		},
		sortClicked: function( ev ) {
			var target = $(ev.currentTarget),
				sortKey = target.data('sort-key');
			if ( sortKey ) {
				this.methodIndexView.setSort(sortKey);
				this.updateMethods();
			}
		},
		methodClicked: function( ev ) {
			var target = $(ev.currentTarget),
				methodName = target.data('method-id');
			if ( methodName ) {
				this.ctrl.selectDrilldown(this.currentContext,methodName);
			}
		},
		methodCutClicked: function( ev ) {
			var target = $(ev.currentTarget),
				methodName = target.data('method-id');
			if ( methodName ) {
				this.ctrl.cutDrilldown(this.currentContext,methodName);
			}
		},
		methodNullifyClicked: function( ev ) {
			var target = $(ev.currentTarget),
				methodName = target.data('method-id');
			if ( methodName ) {
				this.ctrl.nullifyDrilldown(this.currentContext,methodName);
			}
		},
		modalClosed: function() {
			var el = this.el;
			setTimeout(function(){
				el.dialog('destroy');
				el.remove();
			},0);
		},
		updateSummary: function() {
			var html = '';
			html += 'Total: <b>' + this.data.tree.totalTime.toFixed(5) + '</b><br />';
			this.summary.html(html);
		},
		updateContextList: function() {
			var contexts = this.data.contexts,
				list = [], i, itemHtml;
			for (i=0;i<contexts.length;i++) {
				itemHtml = contexts[i][0];
				if ( i != this.currentContext ) {
					itemHtml = '<a href="#" class="context-link" data-context-id="'+i+'">' + itemHtml + '</a>';
				}
				list.push(itemHtml);
			}
			this.contextList.html(list.join(' &raquo; '));
		},
		updateMethods: function() {
			var html = '';
			html += this.methodIndexView.getHtml();
			this.methods.html(html);
//			this.methods.find('table').tablesorter({
//				sortInitialOrder: 'desc'
//			});
		}
	});

	/* CONTROLLER */

	var TraceController;

	TraceController = createClass(Object,{
		data: undefined,
		init: function() {
			var self = this;
			window.mw.loader.using(['jquery.ui.dialog','jquery.ui.tabs','jquery.tablesorter'],
				function() {
					setTimeout(proxy(self.init2,self),0);
				});
		},
		init2: function() {
			this.data = new TraceData();
			this.data.initFromDom();
			this.dialog = new TraceDialog(this.data,this);
			this.dialog.show();
		},
		selectDrilldown: function( contextId, methodName ) {
			this.drilldown(contextId,TreeSelect,'',methodName);
		},
		cutDrilldown: function( contextId, methodName ) {
			this.drilldown(contextId,TreeCut,'[X] ',methodName);
		},
		nullifyDrilldown: function( contextId, methodName ) {
			this.drilldown(contextId,TreeNullify,'[N] ',methodName);
		},
		drilldown: function( contextId, type, captionPrefix, methodName ) {
			var contexts = this.data.contexts.slice(0,contextId+1),
				last = this.data.contexts[contextId],
				condition = function( node ) {
					return node.id == methodName;
				},
				treeMutator = new type(condition);
			contexts.push([captionPrefix+methodName,treeMutator.exec(last[1])]);
			this.data.contexts = contexts;
			this.dialog.loadContext(contextId+1);
		},
		switchContext: function( contextId ) {
			this.dialog.loadContext(contextId);
		}
	});

	window.TraceViewer = {
		openFromDom: function() {
			var c = new TraceController();
			window.Wikia.Trace = window.Wikia.Trace || {};
			window.Wikia.Trace.crtl = c;
			c.init();
		}
	};

})(window,jQuery);
