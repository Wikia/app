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
			for (var s in o.statics) {
				bc[s] = o.static[s];
			}
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
	var proxyEx = function( fn, scope, argStart, argCount ) {
		return function() {
			var args;
			if ( typeof argsCount == 'undefined' ) {
				args = Array.prototype.slice.call(arguments,argStart||0);
			} else {
				args = Array.prototype.slice.call(arguments,argStart||0,argCount);
			}
			return typeof fn === 'function' && fn.apply(scope,args);
		};
	};
	var isArray = function(o) {
		return typeof o == 'object' && Object.prototype.toString.call(o) == '[object Array]';
	}
	function err( msg ) {
		alert(msg);
	}
	function log( msg ) {
		window.console && console.log && console.log(msg);
	}

	/* UTILS */
	var Observable;

	Observable = createClass(Object, {
		constructor: function() {
			Observable.superclass.constructor.apply(this,arguments);
			this.events = {};
		},

		bind: function(e,cb,scope) {
			if (typeof e == 'object') {
				scope = cb;
				for (var i in e) {
					if (i !== 'scope') {
						this.bind(i,e[i],e.scope||scope);
					}
				}
			} else if (isArray(cb)) {
				for (var i=0;i<cb.length;i++) {
					this.bind(e,cb[i],scope);
				}
			} else {
				scope = scope || this;
				this.events[e] = this.events[e] || [];
				this.events[e].push({
					fn: cb,
					scope: scope
				});
			}
			return true;
		},

		unbind: function(e,cb,scope) {
			if (typeof e == 'object') {
				scope = cb;
				var ret = false;
				for (var i in e) {
					if (i !== 'scope') {
						ret = this.unbind(i,e[i],e.scope||scope) || ret;
					}
				}
				return ret;
			} else if (isArray(cb)) {
				var ret = false;
				for (var i=0;i<cb.length;i++) {
					ret = this.unbind(e,cb[i],scope) || ret;
				}
				return ret;
			} else {
				if (!this.events[e]) {
					return false;
				}
				scope = scope || this;
				for (var i in this.events[e]) {
					if (this.events[e][i].fn == cb && this.events[e][i].scope == scope) {
						delete this.events[e][i];
						return true;
					}
				}
				return false;
			}
		},

		on: function(e,cb) {
			this.bind.apply(this,arguments);
		},

		un: function(e,cb) {
			this.unbind.apply(this,arguments);
		},

		relayEvents: function(o,e,te) {
			te = te || e;
			o.bind(e,function() {
				var a = [te].concat(arguments);
				this.fire.apply(this,a);
			},this);
		},

		fire: function(e) {
			var a = Array.prototype.slice.call(arguments,1);
			if (!this.events[e])
				return true;
			var ee = this.events[e];
			for (var i=0;i<ee.length;i++) {
				if (typeof ee[i].fn == 'function') {
					var scope = ee[i].scope || this;
					if (ee[i].fn.apply(scope,a) === false) {
						return false;
					}
				}
			}
			return true;
		},

		proxy: function(func) {
			return proxy(func, this);
		},

		debugEvents: function( list ) {
			var fns = list ? list : ['bind','unbind','fire','relayEvents'];
			for (var i=0;i<fns.length;i++) {
				(function(fn){
					if (typeof this['nodebug-'+fn] == 'undefined') {
						var f = this['nodebug-'+fn] = this[fn];
						this[fn] = function() {
							window.console && console.log && console.log(this,fn,arguments);
							return f.apply(this,arguments);
						}
					}
				}).call(this,fns[i]);
			}
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
			this.attrs = {};
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
		getPath: function() {
			var list;
			if ( this.parent ) {
				list = this.parent.getPath();
				list.push(this);
			} else {
				list = [];
			}
			return list;
		},
		findBySeqIn: function( val ) {
			if ( this.seqIn == val ) {
				return this;
			} else {
				var i, child;
				for (i=0;this.children.length;i++) {
					child = this.children[i];
					if ( child.seqIn == val ) {
						return child;
					} else if ( child.seqIn <= val && val <= child.seqOut ) {
						return child.findBySeqIn(val);
					}
				}
			}
			return false;
		},
		getParentIndex: function() {
			if ( !this.parent ) {
				return 0;
			}
			return this.parent.children.indexOf(this);
		},
		clone: function( parent, shallow ) {
			var copy = new this.constructor(parent,this.id),
				i;
			if ( shallow !== true ) {
				for (i=0;i<this.children.length;i++) {
					var child = this.children[i].clone(copy);
					copy.children.push(child);
				}
			}
			copy.seqIn = this.seqIn;
			copy.seqOut = this.seqOut;
			copy.attrs = this.attrs;
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
		clone: function( parent, shallow ) {
			var copy = TraceNode.superclass.clone.call(this,parent,shallow);
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
				err('trace error ['+id+']: no nodes in the stack');
				return;
			}
			var node = this.stack.pop();
			if ( !node || node.id !== id ) {
				err('trace error ['+id+']: closing non-matching node ('+node.id+')');
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
			this.startNode('-TOTAL-',0,0);
			var lines = text.split("\n"), i,
				REGEX = /^([0-9.]+)?\s*([-0-9.]+)\s*([><])\s*(.*)$/,
				REGEX_ATTR = /^\s*:\s*([^ ]+)\s*=\s*(.*)$/;
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
				} else {
					m = REGEX_ATTR.exec(line);
					if ( m ) {
						var attr = m[1],
							value = m[2],
							top = this.top();
						top && (top.attrs[attr] = value);
					}
				}
			}
			this.top().refreshTotalTime( /* recursive */ false );
			this.endNode('-TOTAL-',0,0);

			this.endTree();
			return this.root;
		},
		fromDom: function() {
			var text = '';
			var node = window.document.lastChild;
			if ( node.nodeType == 8 /* comment */ && /Beginning (extended )?trace/.test(node.textContent) ) {
				text = node.textContent;
			}
			if ( text == '' ) {
				var children = window.document.body.childNodes,
					i, l = children.length, node;
				for (i=l-1;i>=0;i--) {
					node = children[i];
					if ( node.nodeType == 8 /* comment */ ) {
						if ( /Beginning (extended )?trace/.test(node.textContent) ) {
							text = node.textContent;
						}
						break;
					}
				}
			}
			return this.fromText(text);
		}
	});

	var TreeCut, TreeSelect, TreeNullify, TreeSearch, TreeFixProfilerTime;
	var TreeTransformCollection;

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

	TreeSearch = createClass(Object,{
		constructor: function( base, relation ) {
			this.base = base;
			this.rel = relation;
		},
		getChildren: function( list ) {
			var ret = [], i;
			for (i=0;i<list.length;i++) {
				ret = ret.concat(list[i].children);
			}
			return ret;
		},
		getParents: function( list ) {
			var d = {}, i, ret = [], node;
			for (i=0;i<list.length;i++) {
				if ( list[i].seqIn <= 0 ) {
					continue;
				}
				node = this.base.findBySeqIn(list[i].seqIn);
				if ( node.parent && node.parent.id ) {
					d[node.seqIn] = node.parent;
				}
			}
			for (i in d) {
				ret.push(d[i]);
			}
			return ret;
		},
		exec: function( node, inBulk ) {
			var rel = this.rel,
				list = [], i, plainTree;
			list = node.children;
			while ( rel > 0 ) {
				list = this.getChildren(list);
				rel--;
			}
			while ( rel < 0 ) {
				list = this.getParents(list);
				rel++;
			}
			plainTree = new node.constructor();
			for (i=0;i<list.length;i++) {
				plainTree.children.push(list[i].clone(plainTree,true));
			}
			plainTree.refreshTotalTime(false);
			return plainTree;
		}
	});

	TreeFixProfilerTime = createClass(Object,{
		profileTime: 0,
		profileCount: 0,
		collectEnter: function( node ) {
			if ( node.id == 'Profiler::noop' ) {
				this.profileTime += node.selfTime;
				this.profileCount++;
			}
		},
		transformEnter: function( node ) {
			if ( node.id == 'Profiler::noop' ) {
				node.selfTime = 0;
			} else {
				node.selfTime -= this.profileTime * 0.8;
				node.parent && (node.parent.selfTime -= this.profileTime * 0.2);
			}
		},
		exec: function( node, inBulk ) {
			node.traverse(proxy(this.collectEnter,this))
			if ( this.profileCount > 0 ) {
				if ( !inBulk ) {
					node = node.clone();
				}
				this.profileTime /= this.profileCount;
				node.traverse(proxy(this.transformEnter,this))
				node.refreshTotalTime();
			}
			return node;
		}
	});

	TreeTransformCollection = createClass(Object,{
		constructor: function( transforms ) {
			this.transforms = this.transforms || [];
		},
		add: function( transform ) {
			this.transforms.push(transform);
		},
		exec: function( node ) {
			for (var i=0;i<this.transforms.length;i++) {
				this.transforms[i].exec(node);
			}
		}
	})

	var IndexBuilder, SubTreeIndexBuilder, RelativeIndexBuilder;

	MethodIndexBuilder = createClass(Object,{
		constructor: function( tree ) {
			this.tree = tree;
			this.index = undefined;
		},
		getIndex: function() {
			if ( !this.index ) {
				var i, method;
				this.index = {};
				this.tree.traverse(proxy(this.enter,this),proxy(this.leave,this));
			}
			return this.index;
		},
		initMethod: function( id ) {
			var method = this.index[id] = {
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
			var method = this.index[id] = this.index[id] || this.initMethod(node.id);
			method.calls++;
			method.depth++;
			method.nodes.push(node);
		},
		leave: function( node ) {
			if ( !node.id ) return;
			var id = node.id.replace(/!.*$/,''); // remove HIT/MISS from memcache calls
			var method = this.index[id] = this.index[id] || this.initMethod(node.id);

			// totalTime
			if ( method.depth == 1 ) {
				method.totalTime += node.totalTime;
			}

			// selfTime
			method.selfTime += node.selfTime;

			method.depth--;
		}
	});

	var TraceContext, TraceContextCollection, MethodIndexBuilder;

	TraceContext = createClass(Object,{
		constructor: function( source ) {
			this.base = source.base;
			this.source = source;
		},
		getBase: function() {
			return this.source.base;
		},
		getTree: function() {
			if ( !this.tree ) {
				this.tree = this.source.tree;
				if ( this.source.transform ) {
					this.tree = this.source.transform.exec(this.source.tree);
				}
			}
			return this.tree;
		},
		getMethodIndex: function() {
			if ( !this.index ) {
				var builder = new MethodIndexBuilder(this.getTree());
				this.index = builder.getIndex();
			}
			return this.index;
		},
		getChildren: function() {
			if ( !this.children ) {
				var filter = new TreeSearch(this.getBase(),1),
					children = filter.exec(this.getTree());
				this.children = children;
			}
			return this.children;
		},
		getChildrenIndex: function() {
			if ( !this.childrenIndex ) {
				var builder = new MethodIndexBuilder(this.getChildren());
				this.childrenIndex = builder.getIndex();
			}
			return this.childrenIndex;
		},
		getParents: function() {
			if ( !this.parents ) {
				var filter = new TreeSearch(this.getBase(),-1),
					parents = filter.exec(this.getTree());
				this.parents = parents;
			}
			return this.parents;
		},
		getParentsIndex: function() {
			if ( !this.ParentsIndex ) {
				var builder = new MethodIndexBuilder(this.getParents());
				this.parentsIndex = builder.getIndex();
			}
			return this.parentsIndex;
		},
		getMemcached: function() {
			if ( !this.memcached ) {
				var className = 'MWMemcached::',
					classNameLength = className.length,
					condition = function( node ) {
						return node.id && node.id.substr(0,classNameLength) == className;
					},
					filter = new TreeSelect(condition),
					memcached = filter.exec(this.getTree());
				this.memcached = memcached;
			}
			return this.memcached;
		},
		getMemcachedIndex: function() {
			if ( !this.memcachedIndex ) {
				var builder = new MethodIndexBuilder(this.getMemcached());
				this.memcachedIndex = builder.getIndex();
			}
			return this.memcachedIndex;
		},
		getDatabase: function() {
			if ( !this.database ) {
				var REGEX = /^Database[a-zA-Z]*::/,
					condition = function( node ) {
						return node.id && REGEX.test(node.id);
					},
					filter = new TreeSelect(condition),
					database = filter.exec(this.getTree());
				this.database = database;
			}
			return this.database;
		},
		getDatabaseIndex: function() {
			if ( !this.databaseIndex ) {
				var builder = new MethodIndexBuilder(this.getDatabase());
				this.databaseIndex = builder.getIndex();
			}
			return this.databaseIndex;
		},
		squeeze: function() {
			delete this.tree;
			delete this.index;
			delete this.children;
			delete this.childrenIndex;
			delete this.parents;
			delete this.parentsIndex;
		}
	});

	TraceContextCollection = createClass(Observable,{
		base: false,
		current: false,
		contexts: false,
		constructor: function() {
			TraceContextCollection.superclass.constructor.call(this);
			this.contexts = [];
		},
		getBase: function() {
			return this.base;
		},
		getCurrent: function() {
			return this.current;
		},
		getCurrentId: function() {
			return this.current && this.current.id;
		},
		getContextList: function() {
			return this.contexts;
		},
		reset: function( base ) {
			this.base = base;
			this.fire('baseChanged',this,base);
			this.initContexts();
		},
		setCurrent: function( id ) {
			this.current = this.contexts[id];
			this.fire('currentChanged',this,this.current,id);
		},
		initContexts: function() {
			var data, context;
			this.contexts = [];
			data = {
				tree: this.base,
				name: 'All'
			};
			this.fire('initContext',this,data);
			context = {
				id: 0,
				name: data.name,
				context: new TraceContext({
					base: this.base,
					tree: data.tree
				})
			};
			this.contexts.push(context);
			this.fire('historyChanged',this,this.contexts);
			this.setCurrent(context.id);
		},
		transform: function( sourceId, transform, caption ) {
			var contexts = this.contexts.slice(0,sourceId+1),
				last = this.contexts[sourceId].context,
				context;
			context = {
				id: sourceId + 1,
				name: caption,
				context: new TraceContext({
					base: this.base,
					tree: last.getTree(),
					transform: transform
				})
			};
			contexts.push(context);
			this.contexts = contexts;
			this.setCurrent(context.id);
			this.fire('historyChanged',this,this.contexts);
		},

		initFromDom: function() {
			var builder = new TraceTreeBuilder,
				tree = builder.fromDom(),
				profilerFix = new TreeFixProfilerTime();
//			tree = profilerFix.exec(tree);
			this.reset(tree);
		},

		initEmpty: function() {
			var builder = new TraceTreeBuilder,
				tree = builder.fromText('');
			this.reset(tree);
		},

		initFromText: function( text ) {
			var builder = new TraceTreeBuilder,
				tree = builder.fromText(text);
			this.reset(tree);
		}
	});


	var SortedIndex;

	SortedIndex = createClass(Observable,{
		sortKey: false,
		data: false,
		constructor: function( sortKey, data ) {
			SortedIndex.superclass.constructor.call(this);
			this.sortKey = sortKey;
			this.data = data || false;
		},
		callback: function( n ) {
			n = n || 0;
			return proxy(function(){
				var data = Array.prototype.slice.call(arguments,n,1).pop();
				this.setData(data);
			},this);
		},
		setSort: function( sortKey ) {
			if ( sortKey == this.sortKey ) {
				return; // noop
			}
			this.sortKey = sortKey;
			this.sorted = false;
			this.fire('changed',this);
		},
		setData: function( data ) {
			this.data = data;
			this.sorted = false;
			this.fire('changed',this);
		},
		getData: function() {
			return data;
		},
		getSorted: function() {
			if ( !this.sorted ) {
				this.sorted = this.sortBy(this.data,this.sortKey);
			}
			return this.sorted;
		},
		sortBy: function( data, sortKey ) {
			var cmpNumbers = function(a,b){return b[sortKey]-a[sortKey];}, // descending
				cmpStrings = function(a,b){return b[sortKey]<a[sortKey]?1:(b[sortKey]==a[sortKey]?0:-1);}, //ascending
				cmp = cmpNumbers;
			var list = [], index = data, i;
			for (i in index) list.push(index[i]);
			if (list.length && typeof list[0][sortKey] == 'string' ) {
				cmp = cmpStrings;
			}
			list.sort(cmp);
			index = {};
			for (i=0;i<list.length;i++) {
				index[list[i].id] = list[i];
			}
			return index;
		}
	});

	/* VIEW */

	var TraceDialog, MethodIndexRenderer;

	MethodIndexRenderer = createClass(Object,{
		constructor: function( el ) {
			this.setElement(el);
		},
		setElement: function( el ) {
			this.el = el;
			this.render();
		},
		render: function() {
			if ( this.el ) {
				this.el.html(this.getHtml());
			}
		},
		setIndex: function( index, total ) {
			this.index = index;
			this.total = total;
			this.html = false;
			this.render();
		},
		buildHtml: function() {
			if ( !this.index ) {
				return '';
			}

			var i, j, html = '', columns, columnIds, columnSortKeys,
				index = this.index;

			var total = this.total;
			if ( !total ) {
				total = 0;
				for (i in index) {
					total += index[i].selfTime;
				}
			}

			columns = "Self Time|Total Time|% Self|% Total|Calls|Method".split('|');
			columnIds = "trace-self-time|trace-total-time|trace-self-pct|trace-total-pct|trace-calls|trace-method-name".split('|');
			columnSortKeys = "selfTime|totalTime|selfTime|totalTime|calls|id".split('|');

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
						'<a href="#" class="method-drilldown" data-drilldown-type="cut" data-method-id="'+method.id+'">[X]</a> '
							+ '<a href="#" class="method-drilldown" data-drilldown-type="nullity" data-method-id="'+method.id+'">[N]</a> '
							+ '<a href="#" class="method-drilldown" data-drilldown-type="select" data-method-id="'+method.id+'">'+method.id+'</a>',
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

	var TraceDialogPanel, TraceDialogMethodIndexPanel, TraceDialogStackTracesPanel,
		TraceDialogContextListPanel, TraceDialogSummaryPanel;

	TraceDialogPanel = createClass(Observable,{
		constructor: function( dialog, el ) {
			TraceDialogPanel.superclass.constructor.apply(this,arguments);
			this.dialog = dialog;
			this.el = el;
			this.active = false;
			this.changed = true;
			this.source = false;
			this.init();
		},
		init: noop,
		activate: function() {
			this.active = true;
			this.refresh();
		},
		deactivate: function() {
			this.active = false;
		},
		refresh: function() {
			if ( !this.active || !this.source ) {
				return;
			}
			if ( !this.changed ) {
				return;
			}
			this.render();
			this.changed = false;
		}
	});

	TraceDialogMethodIndexPanel = createClass(TraceDialogPanel,{
		sortKey: 'totalTime',
		init: function() {
			this.el.unbind('.methodindexpanel');
			this.el.on('click.methodindexpanel','a.method-drilldown', proxy(this.drilldownClicked,this));
			this.el.on('click.methodindexpanel','a.sort-key', proxy(this.sortClicked,this));
			this.sortedIndex = new SortedIndex(this.sortKey);
			this.renderer = new MethodIndexRenderer();
			this.renderer.setElement(this.el);
		},
		setSource: function( sourceFn, totalTimeFn ) {
			this.source = true;
			this.sourceFn = sourceFn;
			this.totalTimeFn = totalTimeFn;
			this.notifySourceChanged();
		},
		notifySourceChanged: function() {
			this.changed = true;
			this.refresh();
		},
		setSort: function( sortKey ) {
			if ( this.sortKey != sortKey ) {
				this.sortKey = sortKey;
				this.changed = true;
				this.refresh();
			}
		},
		drilldownClicked: function( ev ) {
			var target = $(ev.currentTarget),
				drilldownType = target.data('drilldown-type'),
				methodName = target.data('method-id');
			if ( methodName ) {
				this.dialog.fire('drilldown',drilldownType,methodName);
			}
		},
		sortClicked: function( ev ) {
			var target = $(ev.currentTarget),
				sortKey = target.data('sort-key');
			this.setSort(sortKey);
		},
		render: function() {
			this.sortedIndex.setData(this.sourceFn());
			this.sortedIndex.setSort(this.sortKey);
			var totalTime = this.totalTimeFn ? this.totalTimeFn() : 0;
			this.renderer.setIndex(this.sortedIndex.getSorted(),totalTime);
		}
	});

	TraceDialogStackTracesPanel = createClass(TraceDialogPanel,{
		setSource: function( data ) {
			this.source = true;
			this.data = data;
			this.notifySourceChanged();
		},
		notifySourceChanged: function() {
			this.changed = true;
			this.refresh();
		},
		render: function() {
			var current = this.data.getCurrent(),
				base = this.data.getBase();
			if ( !current ) {
				this.el.html('');
				return;
			}
			var list = current.context.getTree().children,
				paths = [], i, j, seqIn, node;
			for (i=0;i<list.length;i++) {
				seqIn = list[i].seqIn;
				node = base.findBySeqIn(seqIn);
				if ( node ) {
					paths.push(node.getPath());
				}
			}

			var html = '',
				path, stack;
			for (i=0;i<paths.length;i++) {
				path = paths[i];
				html += '<b>Stack #'+(i+1)+'</b><br />';
				for (j=0;j<path.length;j++) {
					if ( path[j].attrs['stack'] ) {
						stack = path[j].attrs['stack'].split('|');
						for (k=0;k<stack.length;k++) {
							stack[k] = '<span class="sw">-- </span> ' + stack[k];
						}
						html += stack.join('<br />') + '<br />';
					}
					html += '<span class="sw">[' + path[j].getParentIndex() + ']</span> ' + path[j].id + '<br />';
				}
				if ( path.length > 0 ) {
					html += '<span class="sw">== </span>'
						+ ' TotalTime: ' + path[path.length-1].totalTime.toFixed(5)
						+ ' SelfTime: '  + path[path.length-1].selfTime.toFixed(5);
				}
				html += '<br />';
			}
			this.el.html(html);
		}
	});

	TraceDialogContextListPanel = createClass(TraceDialogPanel,{
		init: function() {
			this.el.unbind('.contextlistpanel');
			this.el.on('click.contextlistpanel','a.context-item-link', proxy(this.contextLinkClicked,this));
		},
		setSource: function( data ) {
			this.source = true;
			this.data = data;
			this.notifySourceChanged();
		},
		notifySourceChanged: function() {
			this.changed = true;
			this.refresh();
		},
		contextLinkClicked: function( ev ) {
			var target = $(ev.currentTarget),
				contextId = target.data('context-id');
			if ( contextId || contextId === 0 || contextId === '0' ) {
				this.dialog.fire('switchContext',contextId);
			}
		},
		render: function() {
			var contexts = this.data.getContextList();

			if ( !contexts ) {
				this.el.html('');
				return;
			}

			var list = [], i, itemHtml;
			for (i=0;i<contexts.length;i++) {
				itemHtml = contexts[i].name;
				if ( contexts[i] != this.data.getCurrent() ) {
					itemHtml = '<a href="#" class="context-item-link" data-context-id="'+i+'">' + itemHtml + '</a>';
				}
				list.push(itemHtml);
			}
			this.el.html(list.join(' &raquo; '));
		}
	});

	TraceDialogSummaryPanel = createClass(TraceDialogPanel,{
		setSource: function( data ) {
			this.source = true;
			this.data = data;
			this.notifySourceChanged();
		},
		notifySourceChanged: function() {
			this.changed = true;
			this.refresh();
		},
		render: function() {
			var base = this.data.getBase();
			if ( !base ) {
				this.el.html('');
				return;
			}

			var html = '';
			html += 'Total: <b>' + base.totalTime.toFixed(5) + '</b><br />';
			this.el.html(html);
		}
	});

	TraceDialog = createClass(Observable,{
		constructor: function( data, ctrl ) {
			TraceDialog.superclass.constructor.apply(this,arguments);
			this.data = data;
			this.ctrl = ctrl;
		},
		proxy: function( fn ) {
			return proxy(fn||noop,this);
		},
		initMethodIndexPanel: function( el, treeFn, indexFn ) {
			var self = this;
			return this.initPanel(TraceDialogMethodIndexPanel,el,
				[function(){
					var current = self.data.getCurrent();
					return current && current.context[indexFn]();
				},function(){
					var current = self.data.getCurrent();
					return current && current.context[treeFn]().totalTime;
				}],
				['currentChanged']);
		},
		initPanel: function( cls, el, source, notifyEvents ) {
			var self = this, i,
				panel = new cls(this,el);
			if ( source ) {
				panel.setSource.apply(panel,source);
			}
			if ( notifyEvents ) {
				for (i=0;i<notifyEvents.length;i++) {
					self.data.on(notifyEvents[i],proxy(panel.notifySourceChanged,panel));
				}
			}
			return panel;
		},
		initDialog: function() {
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
		},
		initChrome: function() {
			var html = '',
				tabs = {
					dashboard: 'Dashboard',
					methods: 'Methods Summary',
					callers: 'Direct callers',
					callees: 'Direct callees',
					memcached: 'Memcached',
					database: 'Database',
					stackTraces: 'Stack Traces'
				},
				defaultTab = 1;

			html += '<div class="trace-load-button"><a href="#">Load other URL...</a></div>';
			html += '<div id="trace-summary"></div>';
			html += '<div id="trace-context-list"></div>';
			html += '<div id="trace-tabs-wrapper"><ul>';
			for (i in tabs) {
				html += '<li><a href="#trace-'+i+'">'+tabs[i]+'</a></li>';
			}
			html += '</ul>';
			for (i in tabs) {
				html += '<div id="trace-'+i+'"></div>';
			}
			html += '</div>';
			this.el.html(html);

			// save references to subelements
			this.tabs = $('#trace-tabs-wrapper',this.el);
			this.summary = $('#trace-summary',this.el);
			this.contextList = $('#trace-context-list',this.el);
			for (i in tabs) {
				this[i] = $('#trace-'+i,this.el);
			}
			this.tabs.tabs({
				selected: defaultTab,
				select: this.proxy(this.tabActivated)
			});


			this.summaryPanel = this.initPanel(TraceDialogSummaryPanel,this.summary,[this.data],
				['baseChanged']);
			this.contextListPanel = this.initPanel(TraceDialogContextListPanel,this.contextList,[this.data],
				['historyChanged','currentChanged']);
			this.methodsPanel = this.initMethodIndexPanel(this.methods,'getTree','getMethodIndex');
			this.callersPanel = this.initMethodIndexPanel(this.callers,'getParents','getParentsIndex');
			this.calleesPanel = this.initMethodIndexPanel(this.callees,'getChildren','getChildrenIndex');
			this.memcachedPanel = this.initMethodIndexPanel(this.memcached,'getMemcached','getMemcachedIndex');
			this.databasePanel = this.initMethodIndexPanel(this.database,'getDatabase','getDatabaseIndex');
			this.stackTracesPanel = this.initPanel(TraceDialogStackTracesPanel,this.stackTraces,[this.data],
				['currentChanged']);
			this.tabsPanels = [];
			for (i in tabs) {
				this.tabsPanels.push(this[i+'Panel']);
			}

			this.summaryPanel.activate();
			this.contextListPanel.activate();
			this.tabsPanels[defaultTab] && this.tabsPanels[defaultTab].activate();

			$('.trace-load-button a',this.el).click(this.proxy(this.loadButtonClicked));
		},
		setup: function() {
			if ( this.el ) return;

			this.initDialog();
			this.initChrome();
		},
		show: function() {
			this.setup();
			var data = this.data;
		},
		setTitle: function( text ) {
			this.el.dialog( 'option', 'title', 'PHP Trace Browser'
				+ (text ? ' ('+text+')' : '' ));
		},
		/* event handlers */
		tabActivated: function( ev, ui ) {
			var i;
			for (i=0;i<this.tabsPanels.length;i++) {
				if ( this.tabsPanels[i] ) {
					this.tabsPanels[i][i==ui.index?'activate':'deactivate']();
				}
			}
		},
		modalClosed: function() {
			var el = this.el;
			setTimeout(function(){
				el.dialog('destroy');
				el.remove();
			},0);
		},
		loadButtonClicked: function() {
			this.fire('loadClicked');
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
			this.data = new TraceContextCollection();
			this.dialog = new TraceDialog(this.data,this);
			this.dialog.show();
			this.dialog.on('drilldown',proxy(this.drilldown,this));
			this.dialog.on('switchContext',proxy(this.switchContext,this));
			this.dialog.on('loadClicked',proxy(this.loadUrlRequest,this));

			this.loadFromDom();
		},
		drilldown: function( type, methodName ) {
			var drilldowns = {
				select: [ TreeSelect, '' ],
				cut: [ TreeCut, '[X] ' ],
				nullify: [ TreeNullify, '[N] ' ]
			};
			if ( !drilldowns[type] ) {
				return;
			}
			var condition = function( node ) {
					return node.id == methodName;
				},
				transform = new (drilldowns[type][0])(condition),
				caption = drilldowns[type][1] + methodName;
			this.data.transform(this.data.getCurrentId(),transform,caption);
		},
		switchContext: function( contextId ) {
			var data = this.data;
			data.setCurrent(contextId);
		},
		loadFromDom: function() {
			this.data.initFromDom();
			this.dialog.setTitle(document.location.href);
		},
		loadUrlRequest: function() {
			var url = prompt('Enter URL');
			if ( typeof url == 'string' ) {
				this.loadFromUrl( url );
			}
		},
		loadFromUrl: function( url, data ) {
			var self = this,
				origUrl = url;;
			url += ( url.indexOf('?') >= 0 ? '&' : '?' ) + 'forcetrace=2';
			url += ( url.indexOf('?') >= 0 ? '&' : '?' ) + 'tcb=' + (new Date()).getTime();
			$.ajax({
				url: url,
				data: data,
				dataType: 'html',
				success: function( text ) {
					var i = text.lastIndexOf('<!'+'--');
					if ( i >= 0 ) {
						text = text.substr(i);
						text = text.replace(/<!--|-->/g,'');
						console.log(text.substr(0,250));
						console.log(text.substr(-250));
						self.data.initFromText(text);
						self.dialog.setTitle(origUrl);
					} else {
						err('Could not find trace data');
					}
				},
				error: function() {
					err('Could not load response text');
				}
			});
		}
	});

	window.TraceViewer = {
		openFromDom: function() {
			var c = new TraceController();
			window.Wikia.Trace = window.Wikia.Trace || {};
			window.Wikia.Trace.ctrl = c;
			c.init();
		}
	};

})(window,jQuery);
