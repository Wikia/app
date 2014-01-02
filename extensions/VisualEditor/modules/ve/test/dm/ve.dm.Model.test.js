/*!
 * VisualEditor Model tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Model' );

QUnit.test( 'matchesAttributeSpec', function ( assert ) {
	var i, cases = [
		{
			'spec': true,
			'attr': 'foo',
			'result': true,
			'msg': 'true matches anything'
		},
		{
			'spec': false,
			'attr': 'foo',
			'result': false,
			'msg': 'false matches nothing'
		},
		{
			'spec': 'foo',
			'attr': 'foo',
			'result': true,
			'msg': 'string matches exact value'
		},
		{
			'spec': 'foo',
			'attr': 'bar',
			'result': false,
			'msg': 'string does not match anything else'
		},
		{
			'spec': /^foo/,
			'attr': 'foobar',
			'result': true,
			'msg': 'regex matches'
		},
		{
			'spec': /^foo/,
			'attr': 'barfoo',
			'result': false,
			'msg': 'regex does not match anything else'
		},
		{
			'spec': [ 'foo', /^bar/ ],
			'attr': 'foo',
			'result': true,
			'msg': 'array of string and regex matches string'
		},
		{
			'spec': [ 'foo', /^bar/ ],
			'attr': 'barbaz',
			'result': true,
			'msg': 'array of string and regex matches regex match'
		},
		{
			'spec': {
				'blacklist': 'foo'
			},
			'attr': 'foo',
			'result': false,
			'msg': 'blacklisted attribute does not match'
		},
		{
			'spec': {
				'blacklist': 'foo'
			},
			'attr': 'bar',
			'result': true,
			'msg': 'non-blacklisted attribute matches'
		},
		{
			'spec': {
				'whitelist': /^foo/,
				'blacklist': [ 'foobar', 'foobaz' ]
			},
			'attr': 'foobar',
			'result': false,
			'msg': 'blacklist overrides whitelist'
		},
		{
			'spec': {
				'whitelist': /^foo/,
				'blacklist':  [ 'foobar', 'foobaz' ]
			},
			'attr': 'foobaz',
			'result': false,
			'msg': 'blacklist overrides whitelist (2)'
		},
		{
			'spec': {
				'whitelist': /^foo/,
				'blacklist': [ 'foobar', 'foobaz' ]
			},
			'attr': 'fooquux',
			'result': true,
			'msg': 'attribute on whitelist and not on blacklist matches'
		},
		{
			'spec': {
				'whitelist': /^foo/,
				'blacklist': [ 'foobar', 'foobaz' ]
			},
			'attr': 'bar',
			'result': false,
			'msg': 'attribute on neither whitelist nor blacklist does not match'
		}
	];

	QUnit.expect( cases.length );
	for ( i = 0; i < cases.length; i++ ) {
		assert.equal(
			ve.dm.Model.matchesAttributeSpec( cases[i].attr, cases[i].spec ),
			cases[i].result,
			cases[i].msg
		);
	}
} );
