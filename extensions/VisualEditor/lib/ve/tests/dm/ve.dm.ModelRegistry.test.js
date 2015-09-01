/*!
 * VisualEditor DataModel ModelRegistry tests.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.ModelRegistry' );

/* Stubs */
function checkForPickMe( node ) {
	return node.hasAttribute && node.hasAttribute( 'pickme' );
}

/* Nothing set */
ve.dm.StubNothingSetAnnotation = function VeDmStubNothingSetAnnotation() {
	ve.dm.StubNothingSetAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubNothingSetAnnotation, ve.dm.Annotation );
ve.dm.StubNothingSetAnnotation.static.name = 'stubnothingset';

/* Single tag */
ve.dm.StubSingleTagAnnotation = function VeDmStubSingleTagAnnotation() {
	ve.dm.StubSingleTagAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTagAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAnnotation.static.name = 'stubsingletag';
ve.dm.StubSingleTagAnnotation.static.matchTagNames = [ 'a' ];

/* Single type with any allowed */
ve.dm.StubSingleTypeWithAnyAllowedAnnotation = function VeDmStubSingleTypeWithAnyAllowedAnnotation() {
	ve.dm.StubSingleTypeWithAnyAllowedAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTypeWithAnyAllowedAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTypeWithAnyAllowedAnnotation.static.name = 'stubsingletypewithanyallowed';
ve.dm.StubSingleTypeWithAnyAllowedAnnotation.static.matchRdfaTypes = [ 'ext:foo' ];
ve.dm.StubSingleTypeWithAnyAllowedAnnotation.static.allowedRdfaTypes = null;

/* Single type with single allowed */
ve.dm.StubSingleTypeWithAllowedAnnotation = function VeDmStubSingleTypeWithAllowedAnnotation() {
	ve.dm.StubSingleTypeWithAllowedAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTypeWithAllowedAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTypeWithAllowedAnnotation.static.name = 'stubsingletypewithallowed';
ve.dm.StubSingleTypeWithAllowedAnnotation.static.matchRdfaTypes = [ 'ext:foo' ];
ve.dm.StubSingleTypeWithAllowedAnnotation.static.allowedRdfaTypes = [ 'bar' ];

/* Single type */
ve.dm.StubSingleTypeAnnotation = function VeDmStubSingleTypeAnnotation() {
	ve.dm.StubSingleTypeAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTypeAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTypeAnnotation.static.name = 'stubsingletype';
ve.dm.StubSingleTypeAnnotation.static.matchRdfaTypes = [ 'ext:foo' ];

/* Single tag and type */
ve.dm.StubSingleTagAndTypeAnnotation = function VeDmStubSingleTagAndTypeAnnotation() {
	ve.dm.StubSingleTagAndTypeAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTagAndTypeAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAndTypeAnnotation.static.name = 'stubsingletagandtype';
ve.dm.StubSingleTagAndTypeAnnotation.static.matchTagNames = [ 'a' ];
ve.dm.StubSingleTagAndTypeAnnotation.static.matchRdfaTypes = [ 'ext:foo' ];

/* Function */
ve.dm.StubFuncAnnotation = function VeDmStubFuncAnnotation() {
	ve.dm.StubFuncAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubFuncAnnotation, ve.dm.Annotation );
ve.dm.StubFuncAnnotation.static.name = 'stubfunc';
ve.dm.StubFuncAnnotation.static.matchFunction = checkForPickMe;

/* Tag and function */
ve.dm.StubSingleTagAndFuncAnnotation = function VeDmStubSingleTagAndFuncAnnotation() {
	ve.dm.StubSingleTagAndFuncAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTagAndFuncAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAndFuncAnnotation.static.name = 'stubsingletagandfunc';
ve.dm.StubSingleTagAndFuncAnnotation.static.matchTagNames = [ 'a' ];
ve.dm.StubSingleTagAndFuncAnnotation.static.matchFunction = checkForPickMe;

/* Type and function */
ve.dm.StubSingleTypeAndFuncAnnotation = function VeDmStubSingleTypeAndFuncAnnotation() {
	ve.dm.StubSingleTypeAndFuncAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTypeAndFuncAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTypeAndFuncAnnotation.static.name = 'stubsingletypeandfunc';
ve.dm.StubSingleTypeAndFuncAnnotation.static.matchRdfaTypes = [ 'ext:foo' ];
ve.dm.StubSingleTypeAndFuncAnnotation.static.matchFunction = checkForPickMe;

/* Tag, type and function */
ve.dm.StubSingleTagAndTypeAndFuncAnnotation = function VeDmStubSingleTagAndTypeAndFuncAnnotation() {
	ve.dm.StubSingleTagAndTypeAndFuncAnnotation.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubSingleTagAndTypeAndFuncAnnotation, ve.dm.Annotation );
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.name = 'stubsingletagandtypeandfunc';
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.matchTagNames = [ 'a' ];
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.matchRdfaTypes = [ 'ext:foo' ];
ve.dm.StubSingleTagAndTypeAndFuncAnnotation.static.matchFunction = checkForPickMe;

/* Type 'bar' */
ve.dm.StubBarNode = function VeDmStubBarNode() {
	ve.dm.StubBarNode.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubBarNode, ve.dm.BranchNode );
ve.dm.StubBarNode.static.name = 'stub-bar';
ve.dm.StubBarNode.static.matchRdfaTypes = [ 'bar' ];
// HACK keep ve.dm.Converter happy for now
// TODO once ve.dm.Converter is rewritten, this can be removed
ve.dm.StubBarNode.static.toDataElement = function () {};
ve.dm.StubBarNode.static.toDomElements = function () {};

/* Tag 'abbr', type 'ext:abbr' */
ve.dm.StubAbbrNode = function VeDmStubAbbrNode() {
	ve.dm.StubAbbrNode.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubAbbrNode, ve.dm.BranchNode );
ve.dm.StubAbbrNode.static.name = 'stub-abbr';
ve.dm.StubAbbrNode.static.matchTagNames = [ 'abbr' ];
ve.dm.StubAbbrNode.static.matchRdfaTypes = [ 'ext:abbr' ];

/* Tag 'abbr', type /^ext:/ */
ve.dm.StubRegExpNode = function VeDmStubRegExpNode() {
	ve.dm.StubRegExpNode.super.apply( this, arguments );
};
OO.inheritClass( ve.dm.StubRegExpNode, ve.dm.BranchNode );
ve.dm.StubRegExpNode.static.name = 'stub-regexp';
ve.dm.StubRegExpNode.static.matchTagNames = [ 'abbr' ];
ve.dm.StubRegExpNode.static.matchRdfaTypes = [
	/^ext:/
];

/* Tests */

QUnit.test( 'matchElement', 14, function ( assert ) {
	var registry = new ve.dm.ModelRegistry(),
		element = document.createElement( 'a' );

	assert.deepEqual( registry.matchElement( element ), null, 'matchElement() returns null if registry empty' );

	registry.register( ve.dm.StubNothingSetAnnotation );
	registry.register( ve.dm.StubSingleTagAnnotation );
	registry.register( ve.dm.StubSingleTypeWithAnyAllowedAnnotation );
	registry.register( ve.dm.StubSingleTypeWithAllowedAnnotation );
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
	element.setAttribute( 'rel', 'ext:foo bar' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletypewithallowed', 'type-only match with extra allowed type' );
	element.setAttribute( 'rel', 'ext:foo bar baz quux whee' );
	assert.deepEqual( registry.matchElement( element ), 'stubsingletypewithanyallowed', 'type-only match with many extra types' );
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

	registry.unregister( ve.dm.StubAbbrNode );
	element.removeAttribute( 'typeof' );
	element.setAttribute( 'rel', 'ext:abbr' );
	assert.deepEqual( registry.matchElement( element ), 'stub-regexp', 'RegExp type match after string match is unregistered' );

} );

QUnit.test( 'isAnnotation', function ( assert ) {
	var i, len, node,
		allAnnotationTags = [ 'a', 'abbr', 'b', 'big', 'code', 'dfn', 'font', 'i', 'kbd', 'mark', 'q', 's', 'samp', 'small', 'span', 'sub', 'sup', 'time', 'u', 'var' ],
		nonAnnotationTags = [ 'h1', 'p', 'ul', 'li', 'table', 'tr', 'td' ];

	QUnit.expect( allAnnotationTags.length + nonAnnotationTags.length + 2 );

	for ( i = 0, len = allAnnotationTags.length; i < len; i++ ) {
		node = document.createElement( allAnnotationTags[ i ] );
		assert.deepEqual(
			ve.dm.modelRegistry.isAnnotation( node ),
			true,
			allAnnotationTags[ i ] + ' annotation'
		);
	}

	for ( i = 0, len = nonAnnotationTags.length; i < len; i++ ) {
		node = document.createElement( nonAnnotationTags[ i ] );
		assert.deepEqual(
			ve.dm.modelRegistry.isAnnotation( node ),
			false,
			allAnnotationTags[ i ] + ' non-annotation'
		);
	}

	node = document.createElement( 'span' );
	node.setAttribute( 'rel', 've:Alien' );
	assert.deepEqual( ve.dm.modelRegistry.isAnnotation( node ), false, 'alien span' );
	node.setAttribute( 'rel', 've:Dummy' );
	assert.deepEqual( ve.dm.modelRegistry.isAnnotation( node ), true, 'non-alien rel span' );
} );
