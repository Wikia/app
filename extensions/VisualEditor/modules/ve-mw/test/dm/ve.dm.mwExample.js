/*!
 * VisualEditor DataModel MediaWiki example data sets.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * @class
 * @singleton
 * @ignore
 */
ve.dm.mwExample = {};

ve.dm.mwExample.createExampleDocument = function ( name, store ) {
	return ve.dm.example.createExampleDocumentFromObject( name, store, ve.dm.mwExample );
};

ve.dm.mwExample.MWInlineImageHtml = '<span typeof="mw:Image" class="foo mw-valign-text-top" data-parsoid="{&quot;tsr&quot;:[0,24],&quot;optList&quot;:[{&quot;ck&quot;:&quot;width&quot;,&quot;ak&quot;:&quot;500px&quot;}],&quot;cacheKey&quot;:&quot;[[Image:Wiki.png|500px]]&quot;,&quot;img&quot;:{&quot;h&quot;:155,&quot;w&quot;:135,&quot;wdset&quot;:true},&quot;dsr&quot;:[0,24,null,null]}"><a href="./File:Wiki.png" data-parsoid="{&quot;a&quot;:{&quot;href&quot;:&quot;./File:Wiki.png&quot;}}"><img resource="./File:Wiki.png" src="http://upload.wikimedia.org/wikipedia/en/b/bc/Wiki.png" height="155" width="135" data-parsoid="{&quot;a&quot;:{&quot;resource&quot;:&quot;./File:Wiki.png&quot;,&quot;width&quot;:&quot;135&quot;},&quot;sa&quot;:{&quot;resource&quot;:&quot;Image:Wiki.png&quot;,&quot;width&quot;:&quot;500&quot;}}"></a></span>';
ve.dm.mwExample.MWTransclusion = {
	'blockOpen':         '<div about="#mwt1" typeof="mw:Transclusion" data-mw="{&quot;target&quot;:{&quot;wt&quot;:&quot;Test&quot;},&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;Hello, world!&quot;}},&quot;id&quot;:&quot;mwt1&quot;}" data-parsoid="{&quot;tsr&quot;:[18,40],&quot;src&quot;:&quot;{{Test|Hello, world!}}&quot;,&quot;dsr&quot;:[18,40,null,null]}"></div>',
	'blockOpenModified': '<div about="#mwt1" typeof="mw:Transclusion" data-mw="{&quot;id&quot;:&quot;mwt1&quot;,&quot;target&quot;:{&quot;wt&quot;:&quot;Test&quot;},&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;Hello, globe!&quot;}}}" data-parsoid="{&quot;tsr&quot;:[18,40],&quot;src&quot;:&quot;{{Test|Hello, world!}}&quot;,&quot;dsr&quot;:[18,40,null,null]}"></div>',
	'blockContent': '<p about="#mwt1" data-parsoid="{}">Hello, world!</p>',
	'inlineOpen':         '<span about="#mwt1" typeof="mw:Transclusion" data-mw="{&quot;id&quot;:&quot;mwt1&quot;,&quot;target&quot;:{&quot;wt&quot;:&quot;Inline&quot;},&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;1,234&quot;}}}" data-parsoid="{&quot;tsr&quot;:[18,34],&quot;src&quot;:&quot;{{Inline|1,234}}&quot;,&quot;dsr&quot;:[18,34,null,null]}">',
	'inlineOpenModified': '<span about="#mwt1" typeof="mw:Transclusion" data-mw="{&quot;id&quot;:&quot;mwt1&quot;,&quot;target&quot;:{&quot;wt&quot;:&quot;Inline&quot;},&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;5,678&quot;}}}" data-parsoid="{&quot;tsr&quot;:[18,34],&quot;src&quot;:&quot;{{Inline|1,234}}&quot;,&quot;dsr&quot;:[18,34,null,null]}">',
	'inlineContent': '$1,234.00',
	'inlineClose': '</span>',
	'mixed': '<link about="#mwt1" rel="mw:WikiLink/Category" typeof="mw:Transclusion" data-mw="{&quot;id&quot;:&quot;mwt1&quot;,&quot;target&quot;:{&quot;wt&quot;:&quot;Inline&quot;},&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;5,678&quot;}}}"><span about="#mwt1">Foo</span>',
	'pairOne': '<p about="#mwt1" typeof="mw:Transclusion" data-mw="{&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;foo&quot;}}}" data-parsoid="1">foo</p>',
	'pairTwo': '<p about="#mwt2" typeof="mw:Transclusion" data-mw="{&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;foo&quot;}}}" data-parsoid="2">foo</p>',
	'meta':
		'<link rel="mw:WikiLink/Category" href="./Category:Page" about="#mwt1" typeof="mw:Transclusion" ' +
			'data-mw="{&quot;target&quot;:{&quot;wt&quot;:&quot;Template:Echo&quot;,&quot;href&quot;:&quot;./Template:Echo&quot;},&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;[[Category:Page]]\\n[[Category:Book]]&quot;}},&quot;i&quot;:0}">' +
		'<span about="#mwt1" data-parsoid="{}">\n</span>' +
		'<link rel="mw:WikiLink/Category" href="./Category:Book" about="#mwt1">'
};
ve.dm.mwExample.MWTransclusion.blockData = {
	'type': 'mwTransclusionBlock',
	'attributes': {
		'mw': {
			'id': 'mwt1',
			'target': { 'wt' : 'Test' },
			'params': {
				'1': { 'wt': 'Hello, world!' }
			}
		},
		'originalDomElements': $( ve.dm.mwExample.MWTransclusion.blockOpen + ve.dm.mwExample.MWTransclusion.blockContent ).toArray(),
		'originalMw': '{\"target\":{\"wt\":\"Test\"},\"params\":{\"1\":{\"wt\":\"Hello, world!\"}},\"id\":\"mwt1\"}',
		'originalIndex': 0
	},
	'htmlAttributes': [
		{ 'values': {
			'about': '#mwt1',
			'data-mw': '{\"target\":{\"wt\":\"Test\"},\"params\":{\"1\":{\"wt\":\"Hello, world!\"}},\"id\":\"mwt1\"}',
			'data-parsoid': '{\"tsr\":[18,40],\"src\":\"{{Test|Hello, world!}}\",\"dsr\":[18,40,null,null]}',
			'typeof': 'mw:Transclusion'
		} },
		{ 'values': {
			'about': '#mwt1',
			'data-parsoid': '{}'
		} }
	]
};
ve.dm.mwExample.MWTransclusion.inlineData = {
	'type': 'mwTransclusionInline',
	'attributes': {
		'mw': {
			'id': 'mwt1',
			'target': { 'wt' : 'Inline' },
			'params': {
				'1': { 'wt': '1,234' }
			}
		},
		'originalDomElements': $( ve.dm.mwExample.MWTransclusion.inlineOpen + ve.dm.mwExample.MWTransclusion.inlineContent + ve.dm.mwExample.MWTransclusion.inlineClose ).toArray(),
		'originalMw': '{\"id\":\"mwt1\",\"target\":{\"wt\":\"Inline\"},\"params\":{\"1\":{\"wt\":\"1,234\"}}}',
		'originalIndex': 0
	},
	'htmlAttributes': [ { 'values': {
		'about': '#mwt1',
		'data-mw': '{\"id\":\"mwt1\",\"target\":{\"wt\":\"Inline\"},\"params\":{\"1\":{\"wt\":\"1,234\"}}}',
		'data-parsoid': '{\"tsr\":[18,34],\"src\":\"{{Inline|1,234}}\",\"dsr\":[18,34,null,null]}',
		'typeof': 'mw:Transclusion'
	} } ]
};
ve.dm.mwExample.MWTransclusion.mixedDataOpen = {
	'type': 'mwTransclusionInline',
	'attributes': {
		'mw': {
			'id': 'mwt1',
			'target': { 'wt': 'Inline' },
			'params': {
				'1': { 'wt': '5,678' }
			}
		},
		'originalDomElements': $( ve.dm.mwExample.MWTransclusion.mixed ).toArray(),
		'originalMw': '{\"id\":\"mwt1\",\"target\":{\"wt\":\"Inline\"},\"params\":{\"1\":{\"wt\":\"5,678\"}}}',
		'originalIndex': 0
	},
	'htmlAttributes': [
		{ 'values': {
			'about': '#mwt1',
			'rel': 'mw:WikiLink/Category',
			'typeof': 'mw:Transclusion',
			'data-mw': '{\"id\":\"mwt1\",\"target\":{\"wt\":\"Inline\"},\"params\":{\"1\":{\"wt\":\"5,678\"}}}'
		} },
		{ 'values': { 'about': '#mwt1' } }
	]
};
ve.dm.mwExample.MWTransclusion.mixedDataClose = { 'type': '/mwTransclusionInline' };

ve.dm.mwExample.MWTransclusion.blockParamsHash = ve.getHash( [ ve.dm.MWTransclusionNode.static.getHashObject( ve.dm.mwExample.MWTransclusion.blockData ), undefined ] );
ve.dm.mwExample.MWTransclusion.blockStoreItems = {
	'hash': ve.dm.mwExample.MWTransclusion.blockParamsHash,
	'value': $( ve.dm.mwExample.MWTransclusion.blockOpen + ve.dm.mwExample.MWTransclusion.blockContent ).toArray()
};

ve.dm.mwExample.MWTransclusion.inlineParamsHash = ve.getHash( [ ve.dm.MWTransclusionNode.static.getHashObject( ve.dm.mwExample.MWTransclusion.inlineData ), undefined ] );
ve.dm.mwExample.MWTransclusion.inlineStoreItems = {
	'hash': ve.dm.mwExample.MWTransclusion.inlineParamsHash,
	'value': $( ve.dm.mwExample.MWTransclusion.inlineOpen + ve.dm.mwExample.MWTransclusion.inlineContent + ve.dm.mwExample.MWTransclusion.inlineClose ).toArray()
};

ve.dm.mwExample.MWTransclusion.mixedParamsHash = ve.getHash( [ ve.dm.MWTransclusionNode.static.getHashObject( ve.dm.mwExample.MWTransclusion.mixedDataOpen ), undefined ] );
ve.dm.mwExample.MWTransclusion.mixedStoreItems = {
	'hash': ve.dm.mwExample.MWTransclusion.mixedParamsHash,
	'value': $( ve.dm.mwExample.MWTransclusion.mixed ).toArray()
};

ve.dm.mwExample.MWReference = {
	'referenceList':
		'<ol class="references" typeof="mw:Extension/references" about="#mwt7" data-parsoid="{}"' +
			'data-mw="{&quot;name&quot;:&quot;references&quot;,&quot;body&quot;:{' +
			'&quot;extsrc&quot;:&quot;<ref name=\\&quot;foo\\&quot;>Ref in refs</ref>' +
			'&quot;,&quot;html&quot;:&quot;<span about=\\&quot;#mwt8\\&quot; class=\\&quot;reference\\&quot; ' +
			'data-mw=\\&quot;{&amp;quot;name&amp;quot;:&amp;quot;ref&amp;quot;,&amp;quot;body&amp;quot;:{&amp;quot;html&amp;quot;:&amp;quot;Ref in refs&amp;quot;},' +
			'&amp;quot;attrs&amp;quot;:{&amp;quot;name&amp;quot;:&amp;quot;foo&amp;quot;}}\\&quot; ' +
			'rel=\\&quot;dc:references\\&quot; typeof=\\&quot;mw:Extension/ref\\&quot;>' +
			'<a href=\\&quot;#cite_note-foo-3\\&quot;>[3]</a></span>&quot;},&quot;attrs&quot;:{}}"></ol>'
};

ve.dm.mwExample.mwNowikiAnnotation = {
	'type': 'mwNowiki',
	'attributes': {
		'originalDomElements': $( '<span typeof="mw:Nowiki">[[Bar]]</span>' ).toArray()
	},
	'htmlAttributes': [ { 'values': { 'typeof': 'mw:Nowiki' } } ]
};

ve.dm.mwExample.mwNowiki = [
	{ 'type': 'paragraph' },
	'F', 'o', 'o',
	[ '[', [ ve.dm.mwExample.mwNowikiAnnotation ] ],
	[ '[', [ ve.dm.mwExample.mwNowikiAnnotation ] ],
	[ 'B', [ ve.dm.mwExample.mwNowikiAnnotation ] ],
	[ 'a', [ ve.dm.mwExample.mwNowikiAnnotation ] ],
	[ 'r', [ ve.dm.mwExample.mwNowikiAnnotation ] ],
	[ ']', [ ve.dm.mwExample.mwNowikiAnnotation ] ],
	[ ']', [ ve.dm.mwExample.mwNowikiAnnotation ] ],
	'B', 'a', 'z',
	{ 'type': '/paragraph' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
];

ve.dm.mwExample.mwNowikiHtml = '<body><p>Foo<span typeof="mw:Nowiki">[[Bar]]</span>Baz</p></body>';

ve.dm.mwExample.withMeta = [
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<!-- No content conversion -->' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{
		'type': 'mwAlienMeta',
		'attributes': {
			'domElements': $( '<meta property="mw:PageProp/nocc" />' ).toArray()
		}
	},
	{ 'type': '/mwAlienMeta' },
	{ 'type': 'paragraph' },
	'F',
	'o',
	'o',
	{
		'type': 'mwCategory',
		'attributes': {
			'hrefPrefix': './',
			'category': 'Category:Bar',
			'origCategory': 'Category:Bar',
			'sortkey': '',
			'origSortkey': ''
		},
		'htmlAttributes': [ { 'values': { 'rel': 'mw:WikiLink/Category', 'href': './Category:Bar' } } ]
	},
	{ 'type': '/mwCategory' },
	'B',
	'a',
	'r',
	{
		'type': 'mwAlienMeta',
		'attributes': {
			'domElements': $( '<meta property="mw:foo" content="bar" />' ).toArray()
		}
	},
	{ 'type': '/mwAlienMeta' },
	'B',
	'a',
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<!-- inline -->' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	'z',
	{ 'type': '/paragraph' },
	{
		'type': 'mwAlienMeta',
		'attributes': {
			'domElements': $( '<meta property="mw:bar" content="baz" />' ).toArray()
		}
	},
	{ 'type': '/mwAlienMeta' },
	{
		'type': 'alienMeta',
		'attributes': {
			'domElements': $( '<!--barbaz-->' ).toArray()
		}
	},
	{ 'type': '/alienMeta' },
	{
		'type': 'mwCategory',
		'attributes': {
			'hrefPrefix': './',
			'category': 'Category:Foo foo',
			'origCategory': 'Category:Foo_foo',
			'sortkey': 'Bar baz#quux',
			'origSortkey': 'Bar baz%23quux'
		},
		'htmlAttributes': [ { 'values':  {
			'rel': 'mw:WikiLink/Category',
			'href': './Category:Foo_foo#Bar baz%23quux'
		} } ]
	},
	{ 'type': '/mwCategory' },
	{
		'type': 'mwAlienMeta',
		'attributes': {
			'domElements': $( '<meta typeof="mw:Placeholder" data-parsoid="foobar" />' ).toArray()
		}
	},
	{ 'type': '/mwAlienMeta' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
];

ve.dm.mwExample.withMetaPlainData = [
	{ 'type': 'paragraph' },
	'F',
	'o',
	'o',
	'B',
	'a',
	'r',
	'B',
	'a',
	'z',
	{ 'type': '/paragraph' },
	{ 'type': 'internalList' },
	{ 'type': '/internalList' }
];

ve.dm.mwExample.withMetaMetaData = [
	[
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<!-- No content conversion -->' ).toArray()
			}
		},
		{
			'type': 'mwAlienMeta',
			'attributes': {
				'domElements': $( '<meta property="mw:PageProp/nocc" />' ).toArray()
			}
		}
	],
	undefined,
	undefined,
	undefined,
	[
		{
			'type': 'mwCategory',
			'attributes': {
				'hrefPrefix': './',
				'category': 'Category:Bar',
				'origCategory': 'Category:Bar',
				'sortkey': '',
				'origSortkey': ''
			},
			'htmlAttributes': [ { 'values': { 'rel': 'mw:WikiLink/Category', 'href': './Category:Bar' } } ]
		}
	],
	undefined,
	undefined,
	[
		{
			'type': 'mwAlienMeta',
			'attributes': {
				'domElements': $( '<meta property="mw:foo" content="bar" />' ).toArray()
			}
		}
	],
	undefined,
	[
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<!-- inline -->' ).toArray()
			}
		}
	],
	undefined,
	[
		{
			'type': 'mwAlienMeta',
			'attributes': {
				'domElements': $( '<meta property="mw:bar" content="baz" />' ).toArray()
			}
		},
		{
			'type': 'alienMeta',
			'attributes': {
				'domElements': $( '<!--barbaz-->' ).toArray()
			}
		},
		{
			'type': 'mwCategory',
			'attributes': {
				'hrefPrefix': './',
				'category': 'Category:Foo foo',
				'origCategory': 'Category:Foo_foo',
				'sortkey': 'Bar baz#quux',
				'origSortkey': 'Bar baz%23quux'
			},
			'htmlAttributes': [ { 'values': {
				'rel': 'mw:WikiLink/Category',
				'href': './Category:Foo_foo#Bar baz%23quux'
			} } ]
		},
		{
			'type': 'mwAlienMeta',
			'attributes': {
				'domElements': $( '<meta typeof="mw:Placeholder" data-parsoid="foobar" />' ).toArray()
			}
		}
	],
	undefined,
	undefined
];

ve.dm.mwExample.references = [
	{ 'type': 'paragraph' },
	{
		'type': 'mwReference',
		 'attributes': {
			'contentsUsed': true,
			'listGroup': 'mwReference/',
			'listIndex': 0,
			'listKey': 'auto/0',
			'mw': {
				'attrs': {},
				'body': { 'html': 'No name 1' },
				'name': 'ref'
			},
			'originalMw': '{"name":"ref","body":{"html":"No name 1"},"attrs":{}}',
			'refGroup': ''
		},
		'htmlAttributes': [ { 'values': {
			'about': '#mwt2',
			'class': 'reference',
			'data-mw': '{"name":"ref","body":{"html":"No name 1"},"attrs":{}}',
			'data-parsoid': '{"src":"<ref>No name 1</ref>","dsr":[0,20,5,6]}',
			'id': 'cite_ref-1-0',
			'rel': 'dc:references',
			'typeof': 'mw:Extension/ref'
		} } ]
	},
	{ 'type': '/mwReference' },
	{ 'type': '/paragraph' },
	{ 'type': 'paragraph', 'htmlAttributes': [ { 'values': { 'data-parsoid': '{"dsr":[22,108,0,0]}' } } ] },
	'F', 'o', 'o',
	{
		'type': 'mwReference',
		 'attributes': {
			'contentsUsed': true,
			'listGroup': 'mwReference/',
			'listIndex': 1,
			'listKey': 'literal/bar',
			'mw': {
				'attrs': { 'name': 'bar' },
				'body': { 'html': 'Bar' },
				'name': 'ref'
			},
			'originalMw': '{"body":{"html":""},"attrs":{"name":"bar"}}',
			'refGroup': ''
		},
		'htmlAttributes': [ { 'values': {
			'about': '#mwt6',
			'class': 'reference',
			'data-mw': '{"name":"ref","body":{"html":"Bar"},"attrs":{"name":"bar"}}',
			'data-parsoid': '{"src":"<ref name=\\"bar\\">Bar</ref>","dsr":[25,50,16,6]}',
			'id': 'cite_ref-bar-2-0',
			'rel': 'dc:references',
			'typeof': 'mw:Extension/ref'
		} } ]
	},
	{ 'type': '/mwReference' },
	' ', 'B', 'a', 'z',
	{
		'type': 'mwReference',
		 'attributes': {
			'contentsUsed': true,
			'listGroup': 'mwReference/',
			'listIndex': 2,
			'listKey': 'literal/:3',
			'mw': {
				'attrs': { 'name': ':3' },
				'body': { 'html': 'Quux' },
				'name': 'ref'
			},
			'originalMw': '{"name":"ref","body":{"html":"Quux"},"attrs":{"name":":3"}}',
			'refGroup': ''
		},
		'htmlAttributes': [ { 'values': {
			'about': '#mwt7',
			'class': 'reference',
			'data-mw': '{"name":"ref","body":{"html":"Quux"},"attrs":{"name":"quux"}}',
			'data-parsoid': '{"src":"<ref name=\\"quux\\">Quux</ref>","dsr":[54,81,17,6]}',
			'id': 'cite_ref-quux-3-0',
			'rel': 'dc:references',
			'typeof': 'mw:Extension/ref'
		} } ]
	},
	{ 'type': '/mwReference' },
	' ', 'W', 'h', 'e', 'e',
	{
		'type': 'mwReference',
		'attributes': {
			'contentsUsed': false,
			'listGroup': 'mwReference/',
			'listIndex': 1,
			'listKey': 'literal/bar',
			'mw': {
				'attrs': { 'name': 'bar' },
				'name': 'ref'
			},
			'originalMw': '{"body":{"html":""},"attrs":{"name":"bar"}}',
			'refGroup': ''
		},
		'htmlAttributes': [ { 'values': {
			'about': '#mwt8',
			'class': 'reference',
			'data-mw': '{"name":"ref","attrs":{"name":"bar"}}',
			'data-parsoid': '{"src":"<ref name=\\"bar\\" />","dsr":[86,104,18,0]}',
			'id': 'cite_ref-bar-2-1',
			'rel': 'dc:references',
			'typeof': 'mw:Extension/ref'
		} } ]
	},
	{ 'type': '/mwReference' },
	' ', 'Y', 'a', 'y',
	{ 'type': '/paragraph' },
	{ 'type': 'paragraph' },
	{
		'type': 'mwReference',
		 'attributes': {
			'contentsUsed': true,
			'listGroup': 'mwReference/',
			'listIndex': 3,
			'listKey': 'auto/1',
			'mw': {
				'attrs': {},
				'body': { 'html': 'No name 2' },
				'name': 'ref'
			},
			'originalMw': '{"name":"ref","body":{"html":"No name 2"},"attrs":{}}',
			'refGroup': ''
			},
		'htmlAttributes': [ { 'values': {
			'about': '#mwt11',
			'class': 'reference',
			'data-mw': '{"name":"ref","body":{"html":"No name 2"},"attrs":{}}',
			'data-parsoid': '{"src":"<ref>No name 2</ref>","dsr":[110,130,5,6]}',
			'id': 'cite_ref-4-0',
			'rel': 'dc:references',
			'typeof': 'mw:Extension/ref'
		} } ]
	},
	{ 'type': '/mwReference' },
	{
		'type': 'mwReference',
		 'attributes': {
			'contentsUsed': true,
			'listGroup': 'mwReference/foo',
			'listIndex': 4,
			'listKey': 'auto/2',
			'mw': {
				'attrs': { 'group': 'foo' },
				'body': { 'html': 'No name 3' },
				'name': 'ref'
			},
			'originalMw': '{"name":"ref","body":{"html":"No name 3"},"attrs":{"group":"foo"}}',
			'refGroup': 'foo'
		},
		'htmlAttributes': [ { 'values': {
			'about': '#mwt12',
			'class': 'reference',
			'data-mw': '{"name":"ref","body":{"html":"No name 3"},"attrs":{}}',
			'data-parsoid': '{"src":"<ref>No name 3</ref>"',
			'id': 'cite_ref-5-0',
			'rel': 'dc:references',
			'typeof': 'mw:Extension/ref'
		} } ]
	},
	{ 'type': '/mwReference' },
	{ 'type': '/paragraph' },
	{
		'type': 'mwReferenceList',
		'attributes': {
			'mw': {
				'name': 'references',
				'attrs': {}
			},
			'originalMw': '{"name":"references","attrs":{}"}',
			//'domElements': HTML,
			'listGroup': 'mwReference/',
			'refGroup': ''
		}
	},
	{ 'type': '/mwReferenceList' },
	{ 'type': 'internalList' },
	{ 'type': 'internalItem' },
	{ 'type': 'paragraph' },
	'N', 'o', ' ', 'n', 'a', 'm', 'e', ' ', '1',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': 'internalItem' },
	{ 'type': 'paragraph' },
	'B', 'a', 'r',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': 'internalItem' },
	{ 'type' : 'paragraph' },
	'Q', 'u', 'u', 'x',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': 'internalItem' },
	{ 'type' : 'paragraph' },
	'N', 'o', ' ', 'n', 'a', 'm', 'e', ' ', '2',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': 'internalItem' },
	{ 'type' : 'paragraph' },
	'N', 'o', ' ', 'n', 'a', 'm', 'e', ' ', '3',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': '/internalList' }
];

ve.dm.mwExample.complexInternalData = [
	{ 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- before -->' ).get() } },
	{ 'type': '/alienMeta' },
	{ 'type': 'paragraph' },
	'F', ['o', [ve.dm.example.bold]], ['o', [ve.dm.example.italic]],
	{ 'type': 'mwReference', 'attributes': {
		'mw': {},
		'about': '#mwt1',
		'listIndex': 0,
		'listGroup': 'mwReference/',
		'listKey': null,
		'refGroup': '',
		'contentsUsed': true
	} },
	{ 'type': '/mwReference' },
	{ 'type': '/paragraph' },
	{ 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- after -->' ).get() } },
	{ 'type': '/alienMeta' },
	{ 'type': 'internalList' },
	{ 'type': 'internalItem' },
	{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
	'R', ['e', [ve.dm.example.bold]], 'f',
	{ 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- reference -->' ).get() } },
	{ 'type': '/alienMeta' },
	'e', ['r', [ve.dm.example.italic]], ['e', [ve.dm.example.italic]],
	{ 'type': 'mwReference', 'attributes': {
		'mw': {},
		'about': '#mwt2',
		'listIndex': 1,
		'listGroup': 'mwReference/',
		'listKey': 'foo',
		'refGroup': '',
		'contentsUsed': true
	} },
	{ 'type': '/mwReference' },
	'n', 'c', 'e',
	{ 'type': '/paragraph' },
	{ 'type': '/internalItem' },
	{ 'type': 'internalItem' },
	{ 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- beginning -->' ).get() } },
	{ 'type': '/alienMeta' },
	{ 'type': 'preformatted' },
	{ 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- inside -->' ).get() } },
	{ 'type': '/alienMeta' },
	{ 'type': 'mwEntity', 'attributes': { 'character': '€' } },
	{ 'type': '/mwEntity' },
	'2', '5', '0',
	{ 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- inside2 -->' ).get() } },
	{ 'type': '/alienMeta' },
	{ 'type': '/preformatted' },
	{ 'type': 'alienMeta', 'attributes': { 'domElements': $( '<!-- end -->' ).get() } },
	{ 'type': '/alienMeta' },
	{ 'type': '/internalItem' },
	{ 'type': '/internalList' }
];

ve.dm.mwExample.complexInternalData.internalItems = [
	{ 'group': 'mwReference', 'key': null, 'body': 'First reference' },
	{ 'group': 'mwReference', 'key': 'foo', 'body': 'Table in ref: <table><tr><td>because I can</td></tr></table>' }
];

ve.dm.mwExample.domToDataCases = {
	'adjacent annotations': {
		'html':
			'<body>' +
				'<b>a</b><b data-parsoid="1">b</b><b>c</b><b data-parsoid="2">d</b> ' +
				'<b>a</b><b>b</b> ' +
				'<b data-parsoid="3">ab</b><b data-parsoid="4">c</b>' +
			'</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			[ 'a', [ ve.dm.example.bold ] ],
			[
				'b',
				[ {
					'type': 'textStyle/bold',
					'attributes': { 'nodeName': 'b' },
					'htmlAttributes': [ { 'values': {
						'data-parsoid': '1'
					} } ]
				} ]
			],
			[ 'c', [ ve.dm.example.bold ] ],
			[
				'd',
				[ {
					'type': 'textStyle/bold',
					'attributes': { 'nodeName': 'b' },
					'htmlAttributes': [ { 'values': {
						'data-parsoid': '2'
					} } ]
				} ]
			],
			' ',
			[ 'a', [ ve.dm.example.bold ] ],
			[ 'b', [ ve.dm.example.bold ] ],
			' ',
			[
				'a',
				[ {
					'type': 'textStyle/bold',
					'attributes': { 'nodeName': 'b' },
					'htmlAttributes': [ { 'values': {
						'data-parsoid': '3'
					} } ]
				} ]
			],
			[
				'b',
				[ {
					'type': 'textStyle/bold',
					'attributes': { 'nodeName': 'b' },
					'htmlAttributes': [ { 'values': {
						'data-parsoid': '3'
					} } ]
				} ]
			],
			[
				'c',
				[ {
					'type': 'textStyle/bold',
					'attributes': { 'nodeName': 'b' },
					'htmlAttributes': [ { 'values': {
						'data-parsoid': '4'
					} } ]
				} ]
			],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'normalizedHtml':
			'<body>' +
				'<b>abcd</b> ' +
				'<b>ab</b> ' +
				'<b data-parsoid="3">ab</b><b data-parsoid="4">c</b>' +
			'</body>'
	},
	'mw:Image': {
		'html': '<body><p>' + ve.dm.mwExample.MWInlineImageHtml + '</p></body>',
		'data': [
			{ 'type': 'paragraph' },
			{
				'type': 'mwInlineImage',
				'attributes': {
					'src': 'http://upload.wikimedia.org/wikipedia/en/b/bc/Wiki.png',
					'href': './File:Wiki.png',
					'width': 135,
					'height': 155,
					'isLinked': true,
					'valign': 'text-top',
					'resource': './File:Wiki.png',
					'type': 'inline',
					'originalClasses': 'foo mw-valign-text-top',
					'unrecognizedClasses': ['foo']
				},
				'htmlAttributes': [
					{
						'values': {
							'data-parsoid': '{\"tsr\":[0,24],\"optList\":[{\"ck\":\"width\",\"ak\":\"500px\"}],\"cacheKey\":\"[[Image:Wiki.png|500px]]\",\"img\":{\"h\":155,\"w\":135,\"wdset\":true},\"dsr\":[0,24,null,null]}'
						},
						'children': [
							{
								'values': {
									'data-parsoid': '{\"a\":{\"href\":\"./File:Wiki.png\"}}'
								},
								'children': [
									{
										'values': {
											'data-parsoid': '{\"a\":{\"resource\":\"./File:Wiki.png\",\"width\":\"135\"},\"sa\":{\"resource\":\"Image:Wiki.png\",\"width\":\"500\"}}'
										}
									}
								]
							}
						]
					}
				]
			},
			{ 'type': '/mwInlineImage' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'mw:Transclusion (block level)': {
		'html': '<body>' + ve.dm.mwExample.MWTransclusion.blockOpen + ve.dm.mwExample.MWTransclusion.blockContent + '</body>',
		'data': [
			ve.dm.mwExample.MWTransclusion.blockData,
			{ 'type': '/mwTransclusionBlock' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'storeItems': [
			ve.dm.mwExample.MWTransclusion.blockStoreItems
		],
		'normalizedHtml': ve.dm.mwExample.MWTransclusion.blockOpen + ve.dm.mwExample.MWTransclusion.blockContent
	},
	'mw:Transclusion (block level - modified)': {
		'html': '<body>' + ve.dm.mwExample.MWTransclusion.blockOpen + ve.dm.mwExample.MWTransclusion.blockContent + '</body>',
		'data': [
			ve.dm.mwExample.MWTransclusion.blockData,
			{ 'type': '/mwTransclusionBlock' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'storeItems': [
			ve.dm.mwExample.MWTransclusion.blockStoreItems
		],
		'modify': function ( data ) {
			data[0].attributes.mw.params['1'].wt = 'Hello, globe!';
		},
		'normalizedHtml': ve.dm.mwExample.MWTransclusion.blockOpenModified
	},
	'mw:Transclusion (inline)': {
		'html': '<body>' + ve.dm.mwExample.MWTransclusion.inlineOpen + ve.dm.mwExample.MWTransclusion.inlineContent + ve.dm.mwExample.MWTransclusion.inlineClose + '</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			ve.dm.mwExample.MWTransclusion.inlineData,
			{ 'type': '/mwTransclusionInline' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'storeItems': [
			ve.dm.mwExample.MWTransclusion.inlineStoreItems
		],
		'normalizedHtml': ve.dm.mwExample.MWTransclusion.inlineOpen + ve.dm.mwExample.MWTransclusion.inlineContent + ve.dm.mwExample.MWTransclusion.inlineClose
	},
	'mw:Transclusion (inline - modified)': {
		'html': '<body>' + ve.dm.mwExample.MWTransclusion.inlineOpen + ve.dm.mwExample.MWTransclusion.inlineContent + ve.dm.mwExample.MWTransclusion.inlineClose + '</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			ve.dm.mwExample.MWTransclusion.inlineData,
			{ 'type': '/mwTransclusionInline' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'storeItems': [
			ve.dm.mwExample.MWTransclusion.inlineStoreItems
		],
		'modify': function ( data ) {
			data[1].attributes.mw.params['1'].wt = '5,678';
		},
		'normalizedHtml': ve.dm.mwExample.MWTransclusion.inlineOpenModified + ve.dm.mwExample.MWTransclusion.inlineClose
	},
	'two mw:Transclusion nodes with identical params but different htmlAttributes': {
		'html': '<body>' +
			ve.dm.mwExample.MWTransclusion.pairOne +
			ve.dm.mwExample.MWTransclusion.pairTwo +
		'</body>',
		'data': [
			{
				'type': 'mwTransclusionBlock',
				'attributes': {
					'mw': {
						'params': { '1': { 'wt': 'foo' } }
					},
					'originalMw': '{"params":{"1":{"wt":"foo"}}}',
					'originalDomElements': $( ve.dm.mwExample.MWTransclusion.pairOne ).toArray(),
					'originalIndex': 0
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt1',
							'data-mw': '{"params":{"1":{"wt":"foo"}}}',
							'data-parsoid': '1',
							'typeof': 'mw:Transclusion'
						}
					}
				]
			},
			{ 'type': '/mwTransclusionBlock' },
			{
				'type': 'mwTransclusionBlock',
				'attributes': {
					'mw': {
						'params': { '1': { 'wt': 'foo' } }
					},
					'originalMw': '{"params":{"1":{"wt":"foo"}}}',
					'originalDomElements': $( ve.dm.mwExample.MWTransclusion.pairTwo ).toArray(),
					'originalIndex': 0
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt2',
							'data-mw': '{"params":{"1":{"wt":"foo"}}}',
							'data-parsoid': '2',
							'typeof': 'mw:Transclusion'
						}
					}
				]
			},
			{ 'type': '/mwTransclusionBlock' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'storeItems': [
			{
				'hash': '[{"mw":{"params":{"1":{"wt":"foo"}}},"type":"mwTransclusionBlock"},null]',
				'value': $( '<p about="#mwt1" typeof="mw:Transclusion" data-mw="{&quot;params&quot;:{&quot;1&quot;:{&quot;wt&quot;:&quot;foo&quot;}}}" data-parsoid="1">foo</p>' ).toArray()
			}
		]
	},
	'mw:Transclusion containing only meta data': {
		'html':
			'<body>' + ve.dm.mwExample.MWTransclusion.meta + '</body>',
		'data': [
			{
				'type': 'mwTransclusionMeta',
				'attributes': {
					'domElements': $( ve.dm.mwExample.MWTransclusion.meta ).toArray()
				}
			},
			{ 'type': '/mwTransclusionMeta' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'empty' } },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'mw:Reference': {
		// Wikitext:
		// Foo<ref name="bar" /> Baz<ref group="g1" name=":0">Quux</ref> Whee<ref name="bar">[[Bar]]</ref> Yay<ref group="g1">No name</ref> Quux<ref name="bar">Different content</ref> Foo<ref group="g1">No name</ref> Bar<ref name="foo" />
		// <references><ref name="foo">Ref in refs</ref></references>
		'html':
			'<body>' +
				'<p>Foo' +
					'<span about="#mwt1" class="reference" data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;attrs&quot;:{&quot;name&quot;:&quot;bar&quot;}}" id="cite_ref-bar-1-0" rel="dc:references" typeof="mw:Extension/ref" data-parsoid="{}">' +
						'<a href="#cite_note-bar-1">[1]</a>' +
					'</span>' +
					' Baz' +
					'<span about="#mwt2" class="reference" data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;body&quot;:{&quot;html&quot;:&quot;Quux&quot;},&quot;attrs&quot;:{&quot;group&quot;:&quot;g1&quot;,&quot;name&quot;:&quot;:0&quot;}}" id="cite_ref-quux-2-0" rel="dc:references" typeof="mw:Extension/ref" data-parsoid="{}">' +
					'</span>' +
					' Whee' +
					'<span about="#mwt3" class="reference" data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;body&quot;:{&quot;html&quot;:&quot;' +
					'<a rel=\\&quot;mw:WikiLink\\&quot; href=\\&quot;./Bar\\&quot;>Bar' +
					'</a>&quot;},&quot;attrs&quot;:{&quot;name&quot;:&quot;bar&quot;}}" id="cite_ref-bar-1-1" rel="dc:references" typeof="mw:Extension/ref" data-parsoid="{}">' +
					'</span>' +
					' Yay' +
					'<span about="#mwt4" class="reference" data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;body&quot;:{&quot;html&quot;:&quot;No name&quot;},&quot;attrs&quot;:{&quot;group&quot;:&quot;g1&quot;}}" id="cite_ref-1-0" rel="dc:references" typeof="mw:Extension/ref" data-parsoid="{}">' +
					'</span>' +
					' Quux' +
					'<span about="#mwt5" class="reference" data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;body&quot;:{&quot;html&quot;:&quot;Different content&quot;},&quot;attrs&quot;:{&quot;name&quot;:&quot;bar&quot;}}" id="cite_ref-bar-1-2" rel="dc:references" typeof="mw:Extension/ref" data-parsoid="{}">' +
					'</span>' +
					' Foo' +
					'<span about="#mwt6" class="reference" data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;attrs&quot;:{&quot;name&quot;:&quot;foo&quot;}}" ' +
						'id="cite_ref-foo-3-0" rel="dc:references" typeof="mw:Extension/ref" data-parsoid="{}">' +
					'</span>' +
				'</p>' +
				ve.dm.mwExample.MWReference.referenceList +
			'</body>',
		'data': [
			{ 'type': 'paragraph' },
			'F', 'o', 'o',
			{
				'type': 'mwReference',
				'attributes': {
					'listIndex': 0,
					'listGroup': 'mwReference/',
					'listKey': 'literal/bar',
					'refGroup': '',
					'mw': { 'name': 'ref', 'attrs': { 'name': 'bar' } },
					'originalMw': '{"name":"ref","attrs":{"name":"bar"}}',
					'childDomElements': $( '<a href="#cite_note-bar-1">[1]</a>' ).toArray(),
					'contentsUsed': false
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt1',
							'class': 'reference',
							'data-mw': '{"name":"ref","attrs":{"name":"bar"}}',
							'data-parsoid': '{}',
							'id': 'cite_ref-bar-1-0',
							'rel': 'dc:references',
							'typeof': 'mw:Extension/ref'
						},
						'children': [
							{
								'values': {
									'href': '#cite_note-bar-1'
								}
							}
						]
					}
				]
			},
			{ 'type': '/mwReference' },
			' ', 'B', 'a', 'z',
			{
				'type': 'mwReference',
				'attributes': {
					'listIndex': 1,
					'listGroup': 'mwReference/g1',
					'listKey': 'literal/:0',
					'refGroup': 'g1',
					'mw': { 'name': 'ref', 'body': { 'html': 'Quux' }, 'attrs': { 'group': 'g1', 'name': ':0' } },
					'originalMw': '{"name":"ref","body":{"html":"Quux"},"attrs":{"group":"g1","name":":0"}}',
					'childDomElements': [],
					'contentsUsed': true
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt2',
							'class': 'reference',
							'data-mw': '{"name":"ref","body":{"html":"Quux"},"attrs":{"group":"g1","name":":0"}}',
							'data-parsoid': '{}',
							'id': 'cite_ref-quux-2-0',
							'rel': 'dc:references',
							'typeof': 'mw:Extension/ref'
						}
					}
				]
			},
			{ 'type': '/mwReference' },
			' ', 'W', 'h', 'e', 'e',
			{
				'type': 'mwReference',
				'attributes': {
					'listIndex': 0,
					'listGroup': 'mwReference/',
					'listKey': 'literal/bar',
					'refGroup': '',
					'mw': { 'name': 'ref', 'body': { 'html': '<a rel="mw:WikiLink" href="./Bar">Bar</a>' }, 'attrs': { 'name': 'bar' } },
					'originalMw': '{"name":"ref","body":{"html":"<a rel=\\"mw:WikiLink\\" href=\\"./Bar\\">Bar</a>"},"attrs":{"name":"bar"}}',
					'childDomElements': [],
					'contentsUsed': true
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt3',
							'class': 'reference',
							'data-mw': '{"name":"ref","body":{"html":"<a rel=\\"mw:WikiLink\\" href=\\"./Bar\\">Bar</a>"},"attrs":{"name":"bar"}}',
							'data-parsoid': '{}',
							'id': 'cite_ref-bar-1-1',
							'rel': 'dc:references',
							'typeof': 'mw:Extension/ref'
						}
					}
				]
			},
			{ 'type': '/mwReference' },
			' ', 'Y', 'a', 'y',
			{
				'type': 'mwReference',
				'attributes': {
					'listIndex': 2,
					'listGroup': 'mwReference/g1',
					'listKey': 'auto/0',
					'refGroup': 'g1',
					'mw': { 'name': 'ref', 'body': { 'html': 'No name' }, 'attrs': { 'group': 'g1' } },
					'originalMw': '{"name":"ref","body":{"html":"No name"},"attrs":{"group":"g1"}}',
					'childDomElements': [],
					'contentsUsed': true
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt4',
							'class': 'reference',
							'data-mw': '{"name":"ref","body":{"html":"No name"},"attrs":{"group":"g1"}}',
							'data-parsoid': '{}',
							'id': 'cite_ref-1-0',
							'rel': 'dc:references',
							'typeof': 'mw:Extension/ref'
						}
					}
				]
			},
			{ 'type': '/mwReference' },
			' ', 'Q', 'u', 'u', 'x',
			{
				'type': 'mwReference',
				'attributes': {
					'listIndex': 0,
					'listGroup': 'mwReference/',
					'listKey': 'literal/bar',
					'refGroup': '',
					'mw': { 'name': 'ref', 'body': { 'html': 'Different content' }, 'attrs': { 'name': 'bar' } },
					'originalMw': '{"name":"ref","body":{"html":"Different content"},"attrs":{"name":"bar"}}',
					'childDomElements': [],
					'contentsUsed': false
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt5',
							'class': 'reference',
							'data-mw': '{"name":"ref","body":{"html":"Different content"},"attrs":{"name":"bar"}}',
							'data-parsoid': '{}',
							'id': 'cite_ref-bar-1-2',
							'rel': 'dc:references',
							'typeof': 'mw:Extension/ref'
						}
					}
				]
			},
			{ 'type': '/mwReference' },
			' ', 'F', 'o', 'o',
			{
				'type': 'mwReference',
				'attributes': {
					'listGroup': 'mwReference/',
					'listIndex': 3,
					'listKey': 'literal/foo',
					'refGroup': '',
					'mw': { 'name': 'ref', 'attrs': { 'name': 'foo' } },
					'originalMw': '{"name":"ref","attrs":{"name":"foo"}}',
					'childDomElements': [],
					'contentsUsed': false
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt6',
							'class': 'reference',
							'data-mw': '{"name":"ref","attrs":{"name":"foo"}}',
							'data-parsoid': '{}',
							'id': 'cite_ref-foo-3-0',
							'rel': 'dc:references',
							'typeof': 'mw:Extension/ref'
						}
					}
				]
			},
			{ 'type': '/mwReference' },
			{ 'type': '/paragraph' },
			{
				'type': 'mwReferenceList',
				'attributes': {
					'mw': {
						'name': 'references',
						'attrs': {},
						'body': {
							'extsrc': '<ref name="foo">Ref in refs</ref>',
							'html': '<span about="#mwt8" class="reference" data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;body&quot;:{&quot;html&quot;:&quot;Ref in refs&quot;},&quot;attrs&quot;:{&quot;name&quot;:&quot;foo&quot;}}" rel="dc:references" typeof="mw:Extension/ref"><a href="#cite_note-foo-3">[3]</a></span>'
						}
					},
					'originalMw': '{"name":"references","body":{"extsrc":"<ref name=\\"foo\\">Ref in refs</ref>","html":"<span about=\\"#mwt8\\" class=\\"reference\\" data-mw=\\"{&quot;name&quot;:&quot;ref&quot;,&quot;body&quot;:{&quot;html&quot;:&quot;Ref in refs&quot;},&quot;attrs&quot;:{&quot;name&quot;:&quot;foo&quot;}}\\" rel=\\"dc:references\\" typeof=\\"mw:Extension/ref\\"><a href=\\"#cite_note-foo-3\\">[3]</a></span>"},"attrs":{}}',
					'domElements': $( ve.dm.mwExample.MWReference.referenceList ).toArray(),
					'listGroup': 'mwReference/',
					'refGroup': ''
				}
			},
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{
				'type': 'mwReference',
				'attributes': {
					'childDomElements': $( '<a href="#cite_note-foo-3">[3]</a>' ).toArray(),
					'contentsUsed': true,
					'listGroup': 'mwReference/',
					'listIndex': 3,
					'listKey': 'literal/foo',
					'mw': { 'name': 'ref', 'attrs': { 'name': 'foo' }, 'body': { 'html': 'Ref in refs' } },
					'originalMw': '{"name":"ref","body":{"html":"Ref in refs"},"attrs":{"name":"foo"}}',
					'refGroup': ''
				},
				'htmlAttributes': [ {
					'children': [ { 'values': {
						'href': '#cite_note-foo-3'
					} } ],
					'values': {
						'about': '#mwt8',
						'class': 'reference',
						'data-mw': '{"name":"ref","body":{"html":"Ref in refs"},"attrs":{"name":"foo"}}',
						'rel': 'dc:references',
						'typeof': 'mw:Extension/ref'
					}
				} ]
			},
			{ 'type': '/mwReference' },
			{ 'type': '/paragraph' },
			{ 'type': '/mwReferenceList' },
			{ 'type': 'internalList' },
			{ 'type': 'internalItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			[
				'B',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Bar',
						'origTitle': 'Bar',
						'normalizedTitle': 'Bar',
						'hrefPrefix': './'
					},
					'htmlAttributes': [ { 'values': {
						'href': './Bar',
						'rel': 'mw:WikiLink'
					} } ]
				} ]
			],
			[
				'a',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Bar',
						'origTitle': 'Bar',
						'normalizedTitle': 'Bar',
						'hrefPrefix': './'
					},
					'htmlAttributes': [ { 'values': {
						'href': './Bar',
						'rel': 'mw:WikiLink'
					} } ]
				} ]
			],
			[
				'r',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Bar',
						'origTitle': 'Bar',
						'normalizedTitle': 'Bar',
						'hrefPrefix': './'
					},
					'htmlAttributes': [ { 'values': {
						'href': './Bar',
						'rel': 'mw:WikiLink'
					} } ]
				} ]
			],
			{ 'type': '/paragraph' },
			{ 'type': '/internalItem' },
			{ 'type': 'internalItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'Q', 'u', 'u', 'x',
			{ 'type': '/paragraph' },
			{ 'type': '/internalItem' },
			{ 'type': 'internalItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'N', 'o', ' ', 'n', 'a', 'm', 'e',
			{ 'type': '/paragraph' },
			{ 'type': '/internalItem' },
			{ 'type': 'internalItem' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'R', 'e', 'f', ' ', 'i', 'n', ' ', 'r', 'e', 'f', 's',
			{ 'type': '/paragraph' },
			{ 'type': '/internalItem' },
			{ 'type': '/internalList' }
		]
	},
	'mw:Reference with metadata': {
		'html': '<p><span about="#mwt2" class="reference" ' +
			'data-mw="{&quot;name&quot;:&quot;ref&quot;,&quot;body&quot;:' +
			'{&quot;html&quot;:&quot;Foo<!-- bar -->&quot;},&quot;attrs&quot;:{}}" ' +
			'id="cite_ref-1-0" rel="dc:references" typeof="mw:Extension/ref" data-parsoid="{}">' +
			'<a href="#cite_note-bar-1" data-parsoid="{}">[1]</a></span></p>',
		'data': [
			{ 'type': 'paragraph' },
			{
				'type': 'mwReference',
				'attributes': {
					'contentsUsed': true,
					'listGroup': 'mwReference/',
					'listIndex': 0,
					'listKey': 'auto/0',
					'mw': {
						'attrs': {},
						'body': {
							'html': 'Foo<!-- bar -->'
						},
						'name': 'ref'
					},
					'originalMw': '{"name":"ref","body":{"html":"Foo<!-- bar -->"},"attrs":{}}',
					'childDomElements': $( '<a href="#cite_note-bar-1" data-parsoid="{}">[1]</a>' ).toArray(),
					'refGroup': ''
				},
				'htmlAttributes': [
					{
						'values': {
							'about': '#mwt2',
							'class': 'reference',
							'data-mw': '{"name":"ref","body":{"html":"Foo<!-- bar -->"},"attrs":{}}',
							'data-parsoid': '{}',
							'id': 'cite_ref-1-0',
							'rel': 'dc:references',
							'typeof': 'mw:Extension/ref'
						},
						'children': [ { 'values': { 'data-parsoid': '{}', 'href': '#cite_note-bar-1' } } ]
					}
				]
			},
			{ 'type': '/mwReference' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': 'internalItem' },
			{
				'internal': {
					'generated': 'wrapper'
				},
				'type': 'paragraph'
			},
			'F', 'o', 'o',
			{ 'type': '/paragraph' },
			{
				'type': 'alienMeta',
				'attributes': {
					'domElements': $( '<!-- bar -->' ).toArray()
				}
			},
			{ 'type': '/alienMeta' },
			{ 'type': '/internalItem' },
			{ 'type': '/internalList' }
		]
	},
	'internal link with ./ and ../': {
		'html': '<body><p><a rel="mw:WikiLink" href="./../../../Foo/Bar">Foo</a></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'F',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Foo/Bar',
						'origTitle': 'Foo/Bar',
						'normalizedTitle': 'Foo/Bar',
						'hrefPrefix': './../../../'
					},
					'htmlAttributes': [ { 'values': {
						'href': './../../../Foo/Bar',
						'rel': 'mw:WikiLink'
					} } ]
				} ]
			],
			[
				'o',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Foo/Bar',
						'origTitle': 'Foo/Bar',
						'normalizedTitle': 'Foo/Bar',
						'hrefPrefix': './../../../'
					},
					'htmlAttributes': [ { 'values': {
						'href': './../../../Foo/Bar',
						'rel': 'mw:WikiLink'
					} } ]
				} ]
			],
			[
				'o',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Foo/Bar',
						'origTitle': 'Foo/Bar',
						'normalizedTitle': 'Foo/Bar',
						'hrefPrefix': './../../../'
					},
					'htmlAttributes': [ { 'values': {
						'href': './../../../Foo/Bar',
						'rel': 'mw:WikiLink'
					} } ]
				} ]
			],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'numbered external link': {
		'html': '<body><p><a rel="mw:ExtLink/Numbered" href="http://www.mediawiki.org/">[1]</a></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'[',
				[ {
					'type': 'link/mwExternal',
					'attributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					},
					'htmlAttributes': [ { 'values': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					} } ]
				} ]
			],
			[
				'1',
				[ {
					'type': 'link/mwExternal',
					'attributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					},
					'htmlAttributes': [ { 'values': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					} } ]
				} ]
			],
			[
				']',
				[ {
					'type': 'link/mwExternal',
					'attributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					},
					'htmlAttributes': [ { 'values': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink/Numbered'
					} } ]
				} ]
			],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'URL link': {
		'html': '<body><p><a rel="mw:ExtLink" href="http://www.mediawiki.org/">mw</a></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			[
				'm',
				[ {
					'type': 'link/mwExternal',
					'attributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink'
					},
					'htmlAttributes': [ { 'values': {
						'rel': 'mw:ExtLink',
						'href': 'http://www.mediawiki.org/'
					} } ]
				} ]
			],
			[
				'w',
				[ {
					'type': 'link/mwExternal',
					'attributes': {
						'href': 'http://www.mediawiki.org/',
						'rel': 'mw:ExtLink'
					},
					'htmlAttributes': [ { 'values': {
						'rel': 'mw:ExtLink',
						'href': 'http://www.mediawiki.org/'
					} } ]
				} ]
			],
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with wrapped comments and language links': {
		'html': '<body>Foo\n' +
			'<link rel="mw:WikiLink/Language" href="http://de.wikipedia.org/wiki/Foo">\n' +
			'<link rel="mw:WikiLink/Language" href="http://fr.wikipedia.org/wiki/Foo"></body>',
		'data': [
			{
				'type': 'paragraph',
				'internal': {
					'generated': 'wrapper',
					'whitespace': [ undefined, undefined, undefined, '\n' ]
				}
			},
			'F',
			'o',
			'o',
			{ 'type': '/paragraph' },
			{
				'type': 'mwLanguage',
				'attributes': {
					'href': 'http://de.wikipedia.org/wiki/Foo'
				},
				'htmlAttributes': [ { 'values': {
					'href': 'http://de.wikipedia.org/wiki/Foo',
					'rel': 'mw:WikiLink/Language'
				} } ],
				'internal': { 'whitespace': [ '\n', undefined, undefined, '\n' ] }
			},
			{ 'type': '/mwLanguage' },
			{
				'type': 'mwLanguage',
				'attributes': {
					'href': 'http://fr.wikipedia.org/wiki/Foo'
				 },
				 'htmlAttributes': [ { 'values': {
					'href': 'http://fr.wikipedia.org/wiki/Foo',
					'rel': 'mw:WikiLink/Language'
				} } ],
				'internal': { 'whitespace': [ '\n' ] }
			},
			{ 'type': '/mwLanguage' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'document with meta elements': {
		'html': '<body><!-- No content conversion --><meta property="mw:PageProp/nocc" /><p>Foo' +
			'<link rel="mw:WikiLink/Category" href="./Category:Bar" />Bar' +
			'<meta property="mw:foo" content="bar" />Ba<!-- inline -->z</p>' +
			'<meta property="mw:bar" content="baz" /><!--barbaz-->' +
			'<link rel="mw:WikiLink/Category" href="./Category:Foo_foo#Bar baz%23quux" />' +
			'<meta typeof="mw:Placeholder" data-parsoid="foobar" /></body>',
		'data': ve.dm.mwExample.withMeta
	},
	'RDFa types spread across two attributes, about grouping is forced': {
		'html': '<body>' + ve.dm.mwExample.MWTransclusion.mixed + '</body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			ve.dm.mwExample.MWTransclusion.mixedDataOpen,
			ve.dm.mwExample.MWTransclusion.mixedDataClose,
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		],
		'storeItems': [
			ve.dm.mwExample.MWTransclusion.mixedStoreItems
		]
	},
	'mw:Entity': {
		'html': '<body><p>a<span typeof="mw:Entity">¢</span>b<span typeof="mw:Entity">¥</span><span typeof="mw:Entity">™</span></p></body>',
		'data': [
			{ 'type': 'paragraph' },
			'a',
			{
				'type': 'mwEntity',
				'attributes': { 'character': '¢' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			'b',
			{
				'type': 'mwEntity',
				'attributes': { 'character': '¥' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			{
				'type': 'mwEntity',
				'attributes': { 'character': '™' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'wrapping with mw:Entity': {
		'html': '<body>a<span typeof="mw:Entity">¢</span>b<span typeof="mw:Entity">¥</span><span typeof="mw:Entity">™</span></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a',
			{
				'type': 'mwEntity',
				'attributes': { 'character': '¢' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			'b',
			{
				'type': 'mwEntity',
				'attributes': { 'character': '¥' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			{
				'type': 'mwEntity',
				'attributes': { 'character': '™' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'whitespace preservation with mw:Entity': {
		'html': '<body><p> a  <span typeof="mw:Entity"> </span>   b    <span typeof="mw:Entity">¥</span>\t<span typeof="mw:Entity">™</span></p></body>',
		'data': [
			{ 'type': 'paragraph', 'internal': { 'whitespace': [ undefined, ' ' ] } },
			'a',
			' ',
			' ',
			{
				'type': 'mwEntity',
				'attributes': { 'character': ' ' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			' ',
			' ',
			' ',
			'b',
			' ',
			' ',
			' ',
			' ',
			{
				'type': 'mwEntity',
				'attributes': { 'character': '¥' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			'\t',
			{
				'type': 'mwEntity',
				'attributes': { 'character': '™' },
				'htmlAttributes': [ { 'values': { 'typeof': 'mw:Entity' } } ]
			},
			{ 'type': '/mwEntity' },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'category default sort key': {
		'html': '<body><meta property="mw:PageProp/categorydefaultsort" content="foo"></body>',
		'data': [
			{
				'type': 'mwDefaultSort',
				'attributes': {
					'content': 'foo'
				},
				'htmlAttributes': [ { 'values': {
					'content': 'foo',
					'property': 'mw:PageProp/categorydefaultsort'
				} } ]
			},
			{ 'type': '/mwDefaultSort' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'empty' } },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'thumb image': {
		'html': '<body><figure typeof="mw:Image/Thumb" class="mw-halign-right foobar"><a href="Foo"><img src="Bar" width="1" height="2" resource="FooBar"></a><figcaption>abc</figcaption></figure></body>',
		'data': [
			{
				'type': 'mwBlockImage',
				'attributes': {
					'type': 'thumb',
					'align': 'right',
					'href': 'Foo',
					'src': 'Bar',
					'width': '1',
					'height': '2',
					'resource': 'FooBar',
					'originalClasses': 'mw-halign-right foobar',
					'unrecognizedClasses': ['foobar']
				}
			},
			{ 'type': 'mwImageCaption' },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			'a', 'b', 'c',
			{ 'type': '/paragraph' },
			{ 'type': '/mwImageCaption' },
			{ 'type': '/mwBlockImage' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'attribute preservation does not crash due to text node split': {
		'html':
			'<body>' +
				'<figure typeof="mw:Image/Thumb" data-parsoid="{}">' +
					'<a href="Foo" data-parsoid="{}">' +
						'<img src="Bar" width="1" height="2" resource="FooBar" data-parsoid="{}">' +
					'</a>' +
					'<figcaption data-parsoid="{}">' +
					' foo <a rel="mw:WikiLink" href="./Bar" data-parsoid="{}">bar</a> baz' +
					'</figcaption>' +
				'</figure>' +
			'</body>',
		'data': [
			{
				'type': 'mwBlockImage',
				'attributes': {
					'type': 'thumb',
					'align': 'default',
					'href': 'Foo',
					'src': 'Bar',
					'width': '1',
					'height': '2',
					'resource': 'FooBar',
					'originalClasses': undefined,
					'unrecognizedClasses': []
				},
				'htmlAttributes': [ {
					'values': { 'data-parsoid': '{}' },
					'children': [
						{
							'values': { 'data-parsoid': '{}' },
							'children': [ {
								'values': { 'data-parsoid': '{}' }
							} ]
						},
						{
							'values': { 'data-parsoid': '{}' },
							'children': [
								{ 'values': { 'data-parsoid': '{}' } }
							]
						}
					 ]
				} ]
			},
			{ 'type': 'mwImageCaption', 'internal': { 'whitespace': [ undefined, ' ' ] } },
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper', 'whitespace': [ ' ' ] } },
			'f', 'o', 'o', ' ',
			[
				'b',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Bar',
						'origTitle': 'Bar',
						'normalizedTitle': 'Bar',
						'hrefPrefix': './'
					},
					'htmlAttributes': [ { 'values': { 'href': './Bar', 'rel': 'mw:WikiLink', 'data-parsoid': '{}' } } ]
				} ]
			],
			[
				'a',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Bar',
						'origTitle': 'Bar',
						'normalizedTitle': 'Bar',
						'hrefPrefix': './'
					},
					'htmlAttributes': [ { 'values': { 'href': './Bar', 'rel': 'mw:WikiLink', 'data-parsoid': '{}' } } ]
				} ]
			],
			[
				'r',
				[ {
					'type': 'link/mwInternal',
					'attributes': {
						'title': 'Bar',
						'origTitle': 'Bar',
						'normalizedTitle': 'Bar',
						'hrefPrefix': './'
					},
					'htmlAttributes': [ { 'values': { 'href': './Bar', 'rel': 'mw:WikiLink', 'data-parsoid': '{}' } } ]
				} ]
			],
			' ', 'b', 'a', 'z',
			{ 'type': '/paragraph' },
			{ 'type': '/mwImageCaption' },
			{ 'type': '/mwBlockImage' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		]
	},
	'mw:Nowiki': {
		'html': ve.dm.mwExample.mwNowikiHtml,
		'data': ve.dm.mwExample.mwNowiki
	},
	'mw:Nowiki unwraps when text modified': {
		'data': ve.dm.mwExample.mwNowiki,
		'modify': function ( data ) {
			data[7][0] = 'z';
		},
		'normalizedHtml': '<body><p>Foo[[Bzr]]Baz</p></body>'
	},
	'mw:Nowiki unwraps when annotations modified': {
		'data': ve.dm.mwExample.mwNowiki,
		'modify': function ( data ) {
			data[7][1].push( ve.dm.example.bold );
		},
		'normalizedHtml': '<body><p>Foo[[B<b>a</b>r]]Baz</p></body>'
	}
};
