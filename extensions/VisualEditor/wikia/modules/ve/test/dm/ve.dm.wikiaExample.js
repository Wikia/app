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
		'body': '<figure typeof="mw:Image/Thumb" class="mw-halign-right foobar" data-mw=\'{"user":"Foo"}\'><a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a><figcaption>abc</figcaption></figure>',
		'data': [
			{
				'type': 'wikiaBlockImage',
				'attributes': {
					'type': 'thumb',
					'align': 'right',
					'href': 'Foo',
					'src': 'Bar',
					'width': 1,
					'height': 2,
					'resource': 'FooBar',
					'originalClasses': 'mw-halign-right foobar',
					'unrecognizedClasses': ['foobar'],
					'user': 'Foo'
				},
				'htmlAttributes': [ {
					'values': {
						'data-mw': '{"user":"Foo"}'
					}
				} ]
			},
			{ 'type': 'wikiaImageCaption' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a', 'b', 'c',
			{ 'type': '/paragraph' },
			{ 'type': '/wikiaImageCaption' },
			{ 'type': '/wikiaBlockImage' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'thumb video': {
		'body': '<figure typeof="mw:Video/Thumb" class="mw-halign-right foobar" data-mw=\'{"user":"Foo"}\'><a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a><figcaption>abc</figcaption></figure>',
		'data': [
			{
				'type': 'wikiaBlockVideo',
				'attributes': {
					'type': 'thumb',
					'align': 'right',
					'href': 'Foo',
					'src': 'Bar',
					'width': 1,
					'height': 2,
					'resource': 'FooBar',
					'originalClasses': 'mw-halign-right foobar',
					'unrecognizedClasses': ['foobar'],
					'user': 'Foo'
				},
				'htmlAttributes': [ {
					'values': {
						'data-mw': '{"user":"Foo"}'
					}
				} ]
			},
			{ 'type': 'wikiaVideoCaption' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a', 'b', 'c',
			{ 'type': '/paragraph' },
			{ 'type': '/wikiaVideoCaption' },
			{ 'type': '/wikiaBlockVideo' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	}
};
