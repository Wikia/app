/*!
 * VisualEditor DataModel Wikia example data sets.
 */

/**
 * @class
 * @singleton
 * @ignore
 */
ve.dm.wikiaExample = {};

ve.dm.wikiaExample.createExampleDocument = function ( name, store ) {
	return ve.dm.example.createExampleDocumentFromObject( name, store, ve.dm.wikiaExample );
};

ve.dm.wikiaExample.domToDataCases = {
	'thumb image': {
		'html': '<body><figure typeof="mw:Image/Thumb" class="mw-halign-right foobar" data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'><a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a><figcaption>abc</figcaption></figure></body>',
		'data': [
			{
				'type': 'wikiaBlockImage',
				'attributes': {
					'type': 'thumb',
					'align': 'right',
					'href': 'Foo',
					'src': 'Bar',
					'width': '1',
					'height': '2',
					'resource': 'FooBar',
					'originalClasses': 'mw-halign-right foobar',
					'unrecognizedClasses': ['foobar'],
					'attribution': {
						'avatar': 'Foo.png',
						'username': 'Foo'
					}
				},
				'htmlAttributes': [ {
					'values': {
						'data-mw': '{"attribution":{"username":"Foo","avatar":"Foo.png"}}'
					}
				} ]
			},
			{ 'type': 'wikiaMediaCaption' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a', 'b', 'c',
			{ 'type': '/paragraph' },
			{ 'type': '/wikiaMediaCaption' },
			{ 'type': '/wikiaBlockImage' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'thumb video': {
		'html': '<body><figure typeof="mw:Video/Thumb" class="mw-halign-right foobar" data-mw=\'{"attribution":{"username":"Foo","avatar":"Foo.png"}}\'><a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a><figcaption>abc</figcaption></figure></body>',
		'data': [
			{
				'type': 'wikiaBlockVideo',
				'attributes': {
					'type': 'thumb',
					'align': 'right',
					'href': 'Foo',
					'src': 'Bar',
					'width': '1',
					'height': '2',
					'resource': 'FooBar',
					'originalClasses': 'mw-halign-right foobar',
					'unrecognizedClasses': ['foobar'],
					'attribution': {
						'avatar': 'Foo.png',
						'username': 'Foo'
					}
				},
				'htmlAttributes': [ {
					'values': {
						'data-mw': '{"attribution":{"username":"Foo","avatar":"Foo.png"}}'
					}
				} ]
			},
			{ 'type': 'wikiaMediaCaption' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a', 'b', 'c',
			{ 'type': '/paragraph' },
			{ 'type': '/wikiaMediaCaption' },
			{ 'type': '/wikiaBlockVideo' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	}
};
