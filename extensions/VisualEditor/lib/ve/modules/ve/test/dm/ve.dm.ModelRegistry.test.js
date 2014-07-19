/*!
 * VisualEditor DataModel ModelRegistry tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.ModelRegistry' );

/* Stubs */
function checkForPickMe( node ) {
	return node.hasAttribute && node.hasAttribute( 'pickme' );
}

ve.dm.StubNothingSetAnnotation = function VeDmStubNothingSetAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};
OO.inheritClass( ve.dm.StubNothingSetAnnotation, ve.dm.Annotation );
ve.dm.StubNothingSetAnnotation.static.name = 'stubnothingset';

ve.dm.StubSingleTagAnnotation = function VeDmStubSingleTagAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};
OO.inheritClass( ve.dm.StubSingleTagAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAnnotation.static.name = 'stubsingletag';
ve.dm.StubSingleTagAnnotation.static.matchTagNames = ['a'];

ve.dm.StubSingleTypeAnnotation = function VeDmStubSingleTypeAnnotation( element ) {
	ve.dm.Annotation.call( this, 'stubsingletype', element );
};
OO.inheritClass( ve.dm.StubSingleTypeAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTypeAnnotation.static.name = 'stubsingletype';
ve.dm.StubSingleTypeAnnotation.static.matchRdfaTypes = ['ext:foo'];

ve.dm.StubSingleTagAndTypeAnnotation = function VeDmStubSingleTagAndTypeAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};
OO.inheritClass( ve.dm.StubSingleTagAndTypeAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAndTypeAnnotation.static.name = 'stubsingletagandtype';
ve.dm.StubSingleTagAndTypeAnnotation.static.matchTagNames = ['a'];
ve.dm.StubSingleTagAndTypeAnnotation.static.matchRdfaTypes = ['ext:foo'];

ve.dm.StubFuncAnnotation = function VeDmStubFuncAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};
OO.inheritClass( ve.dm.StubFuncAnnotation, ve.dm.Annotation );
ve.dm.StubFuncAnnotation.static.name = 'stubfunc';
ve.dm.StubFuncAnnotation.static.matchFunction = checkForPickMe;

ve.dm.StubSingleTagAndFuncAnnotation = function VeDmStubSingleTagAndFuncAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};
OO.inheritClass( ve.dm.StubSingleTagAndFuncAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAndFuncAnnotation.static.name = 'stubsingletagandfunc';
ve.dm.StubSingleTagAndFuncAnnotation.static.matchTagNames = ['a'];
ve.dm.StubSingleTagAndFuncAnnotation.static.matchFunction = checkForPickMe;

ve.dm.StubSingleTypeAndFuncAnnotation = function VeDmStubSingleTypeAndFuncAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};
OO.inheritClass( ve.dm.StubSingleTypeAndFuncAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTypeAndFuncAnnotation.static.name = 'stubsingletypeandfunc';
ve.dm.StubSingleTypeAndFuncAnnotation.static.matchRdfaTypes = ['ext:foo'];
ve.dm.StubSingleTypeAndFuncAnnotation.static.matchFunction = checkForPickMe;

ve.dm.StubSingleTagAndTypeAndFuncAnnotation = function VeDmStubSingleTagAndTypeAndFuncAnnotation( element ) {
	ve.dm.Annotation.call( this, element );
};
OO.inheritClass( ve.dm.StubSingleTagAndTypeAndFuncAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.name = 'stubsingletagandtypeandfunc';
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.matchTagNames = ['a'];
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.matchRdfaTypes = ['ext:foo'];
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.matchFunction = checkForPickMe;

ve.dm.StubBarNode = function VeDmStubBarNode() {
	ve.dm.BranchNode.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubBarNode, ve.dm.BranchNode );
ve.dm.StubBarNode.static.name = 'stub-bar';
ve.dm.StubBarNode.static.matchRdfaTypes = ['bar'];
// HACK keep ve.dm.Converter happy for now
// TODO once ve.dm.Converter is rewritten, this can be removed
ve.dm.StubBarNode.static.toDataElement = function () {};
ve.dm.StubBarNode.static.toDomElements = function () {};

ve.dm.StubAbbrNode = function VeDmStubAbbrNode() {
	ve.dm.BranchNode.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubAbbrNode, ve.dm.BranchNode );
ve.dm.StubAbbrNode.static.name = 'stub-abbr';
ve.dm.StubAbbrNode.static.matchTagNames = ['abbr'];
ve.dm.StubAbbrNode.static.matchRdfaTypes = ['ext:abbr'];

ve.dm.StubRegExpNode = function VeDmStubRegExpNode() {
	ve.dm.BranchNode.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubRegExpNode, ve.dm.BranchNode );
ve.dm.StubRegExpNode.static.name = 'stub-regexp';
ve.dm.StubRegExpNode.static.matchTagNames = ['abbr'];
ve.dm.StubRegExpNode.static.matchRdfaTypes = [ /^ext:/ ];

/* Tests */

QUnit.test( 'matchElement', 23, function ( assert ) {
	var registry = new ve.dm.ModelRegistry(), element;
	element = document.createElement( 'a' );
	assert.deepEqual( registry.matchElement( element ), null, 'matchElement() returns null if registry empty' );

	registry.register( ve.dm.StubNothingSetAnnotation );
	registry.register( ve.dm.StubSingleTagAnnotation );
	registry.register( ve.dm.StubSingleTypeAnnotation );
	registry.register( ve.dm.StubSingleTagAndTypeAnnotation );
	registry.register( ve.dm.StubFuncAnnotation );
	registry.register( ve.dm.StubSingleTagAndFuncAnnotation );
	registry.register( ve.dm.StubSingleTypeAndFuncAnnotation );
	registry.register( ve.dm.StubSingleTagAndTypeAndFuncAnnotation );
	registry.register( ve.dm.StubBarNode );
	registry.register( ve.dm.StubAbbrNode );
	registry.register( ve.dm.StubRegExpNode );

	element = document.createElement( 'b' );
	assert.deepEqual( registry.matchElement( element ), 'stubnothingset', 'nothingset matches anything' );
	element.setAttribute( 'rel', 'ext:foo' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletype', 'type-only match' );
	element = document.createElement( 'a' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletag', 'tag-only match' );
	element.setAttribute( 'rel', 'ext:foo' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletagandtype', 'tag and type match' );
	element.setAttribute( 'pickme', 'true' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletagandtypeandfunc', 'tag, type and func match' );
	element.setAttribute( 'rel', 'ext:bar' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletagandfunc', 'tag and func match' );
	element = document.createElement( 'b' );
	element.setAttribute( 'pickme', 'true' );
	assert.deepEqual( registry.matchElement( element ), 'stubfunc', 'func-only match' );
	element.setAttribute( 'rel', 'ext:foo' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletypeandfunc', 'type and func match' );
	element = document.createElement( 'abbr' );
	element.setAttribute( 'rel', 'ext:baz' );
	assert.deepEqual( registry.matchElement( element ), 'stub-regexp', 'RegExp type match' );
	element.setAttribute( 'rel', 'ext:abbr' );
	assert.deepEqual( registry.matchElement( element ), 'stub-abbr', 'String match overrides RegExp match' );

	registry.registerExtensionSpecificType( /^ext:/ );
	registry.registerExtensionSpecificType( 'foo' );
	element = document.createElement( 'a' );
	element.setAttribute( 'rel', 'bar baz' );
	assert.deepEqual( registry.matchElement( element ), 'stub-bar', 'incomplete non-extension-specific type match' );
	element.setAttribute( 'pickme', 'true' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletagandfunc', 'incomplete non-extension-specific type match is trumped by tag&func match' );
	element.setAttribute( 'rel', 'ext:bogus' );
	assert.deepEqual( registry.matchElement( element ), null, 'extension-specific type matching regex prevents tag-only and func-only matches' );
	element.setAttribute( 'rel', 'foo' );
	assert.deepEqual( registry.matchElement( element ), null, 'extension-specific type matching string prevents tag-only and func-only matches' );
	element.setAttribute( 'rel', 'ext:bogus bar' );
	assert.deepEqual( registry.matchElement( element ), null, 'extension-specific type matching regex prevents type match' );
	element.setAttribute( 'rel', 'foo bar' );
	assert.deepEqual( registry.matchElement( element ), null, 'extension-specific type matching string prevents type match' );
	element.setAttribute( 'rel', 'foo bar ext:bogus' );
	assert.deepEqual( registry.matchElement( element ), null, 'two extension-specific types prevent non-extension-specific type match' );
	element = document.createElement( 'abbr' );
	element.setAttribute( 'rel', 'ext:baz' );
	assert.deepEqual( registry.matchElement( element ), 'stub-regexp', 'RegExp type match for extension-specific type' );
	element.setAttribute( 'rel', 'ext:abbr' );
	assert.deepEqual( registry.matchElement( element ), 'stub-abbr', 'String match overrides RegExp match for extension-specific type' );
	element.setAttribute( 'rel', 'ext:abbr ext:foo' );
	assert.deepEqual( registry.matchElement( element ), 'stub-regexp', 'Additional extension-specific type (ext:foo) breaks string match, throws back to regexp match' );
	element.setAttribute( 'rel', 'ext:abbr foo' );
	assert.deepEqual( registry.matchElement( element ), null, 'Additional extension-specific type (foo) breaks match' );
	element.setAttribute( 'rel', 'ext:abbr' );
	element.setAttribute( 'typeof', 'foo' );
	assert.deepEqual( registry.matchElement( element ), null, 'Types split over two attributes still breaks match' );
} );
