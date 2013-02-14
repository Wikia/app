/*
global module, text
@test-exclude AssetsManager packages are not supported
@test-framework QUnit
@test-require-asset rte
@test-require-asset epl
*/
module("WikiaEditor");

test("Functions > addFunction()/callFunction() without scope",function(){
	var we = window.WikiaEditor;
	var s = false;
	we.addFunction($.noop,$);
	var id = we.addFunction(function(v){
		s = v;
	});
	we.addFunction($.noop,$);
	
	equal( s, false, "sanity check" );
	we.callFunction(id,2);
	equal( s, 2, "s == 2" );
	we.callFunction(id,'asd');
	equal( s, 'asd', "s == 'asd'" );
});
test("Functions > addFunction()/callFunction() with scope",function(){
	var we = window.WikiaEditor;
	var o = { a: false };
	var id = we.addFunction(function(x){
		this.a = x;
	},o);
	
	equal( o.a, false, "sanity check" );
	we.callFunction(id,2);
	equal( o.a, 2, "o.a == 2" );
	we.callFunction(id,'asd');
	equal( o.a, 'asd', "o.a == 'asd'" );
});

test('Functions > Inside Editor',function(){
	var e = window.WikiaEditor.create(['functions'],{element:$('body'),body:$('body')});
	var count = 0, o = { count: 0 };
	var id = e.addFunction(function(x){count++;this.count+=x;},o);
	e.callFunction(id,3);
	
	equal( count, 1, "closure scope variable modification");
	equal( o.count, 3, "object-oriented scope variable modification");
});

test('Plugins > Initialization',function(){
	var we = window.WikiaEditor;
	var count = 0, count2 = 0, count3 = 0;
	we.plugins.testxx = $.createClass(we.plugin,{
		watermark: 'testxx',
		initConfig: function() { count++; },
		beforeInit: function() { 
			count++;
			this.editor.on('testevent',function(x){ count3+=x; });
		},
		init: function() { count++; },
		initEditor: function() { count++; },
		initDom: function() { count++; }
	});
	we.plugins.testyy = $.createClass(we.plugin,{
		watermark: 'testyy',
		test: function() { count2++; }
	});
	var e = new window.WikiaEditor.create(['testxx'],{element:$('body'),body:$('body')});
	
	equal( count, 5, "init methods calls counter");
	equal( typeof e.plugins.testxx, 'object', "plugin 'testxx' instance is object" );
	equal( e.plugins.testxx.watermark, 'testxx', "plugin 'testxx' watermark" );
	
	e.initPlugin('testyy').test();
	
	equal( count2, 1, "Editor.initPlugin() return value");
	equal( typeof e.plugins.testyy, 'object', "plugin 'testyy' instance is object" );
	equal( e.plugins.testyy.watermark, 'testyy', "plugin 'testyy' watermark" );
	
	e.fire('testevent',2);
	e.fire('testevent',5);
	
	equal( count3, 7, "editor events handling by plugins");
});

test('Plugins > Spaces',function(){
	var e1 = $('<div data-space-type="testxx" />'),
		e2 = $('<div data-space-type="testyy" />'),
		ed = $('<div data-space-type="editor" />'),
		dom = $('<div/>').append(e1,e2,ed);
	
	var e = new window.WikiaEditor.create(['spaces'],{element:dom,body:$('body')});
	
	equal( e.getSpace('testxx').get(0) === e1.get(0), true, "get space by name" );
	equal( e.getSpace('testyy').get(0) === e2.get(0), true, "get space by name" );
	equal( e.getEditorSpace().get(0) === ed.get(0), true, "get editor space" );
});

test('Plugins > Messages',function(){
	var m = window.wgMessages = window.wgMessages || {};
	
	m['wikia-editor-xxx-1'] = 'aaa';
	m['wikia-editor-xxx-2'] = 'bbb';
	m['wikia-editor-xxx-3'] = 'ccc$1$2';
	
	var e = new window.WikiaEditor.create(['messages'],{element:$('body'),body:$('body')});
	
	equal(e.msg('xxx-1'),'aaa','wikia-editor-xxx-1 without params');
	equal(e.msg('xxx-1','x'),'aaa','wikia-editor-xxx-1 with params');
	equal(e.msg('xxx-2'),'bbb','wikia-editor-xxx-2 without params');
	equal(e.msg('xxx-2','x'),'bbb','wikia-editor-xxx-2 with params');
	equal(e.msg('xxx-3'),'ccc$1$2','wikia-editor-xxx-3 without params');
	equal(e.msg('xxx-3','x'),'cccx$2','wikia-editor-xxx-3 with params');
});


