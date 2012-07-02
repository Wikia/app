/**
 * Simple token transform version of the Cite extension.
 *
 * @class
 * @constructor
 */
function Cite ( dispatcher ) {
	this.refGroups = {};
	this.refTokens = [];
	// Within ref block
	this.isActive = false;
	this.register( dispatcher );
}

/**
 * Register with dispatcher.
 *
 * @method
 * @param {Object} TokenTransformDispatcher to register to
 */
Cite.prototype.register = function ( dispatcher ) {
	// Register for ref and references tag tokens
	var self = this;
	this.onRefCB = function (ctx) { 
		return self.onRef(ctx);
	};
	dispatcher.appendListener( this.onRefCB, 'tag', 'ref' );
	dispatcher.appendListener( function (ctx) { 
		return self.onReferences(ctx);
	}, 'tag', 'references' );
	dispatcher.appendListener( function (ctx) { 
		return self.onEnd(ctx);
	}, 'end' );
};


/**
 * Convert list of key-value pairs to object, with first entry for a
 * key winning.
 *
 * XXX: Move to general utils
 *
 * @static
 * @method
 * @param {Array} List of [key, value] pairs
 * @returns {Object} Object with key/values set, first entry wins.
 */
Cite.prototype.attribsToObject = function ( attribs ) {
	if ( attribs === undefined ) {
		return {};
	}
	var obj = {};
	for ( var i = 0, l = attribs.length; i < l; i++ ) {
		var kv = attribs[i];
		if (! kv[0] in obj) {
			obj[kv[0]] = kv[1];
		}
	}
	return obj;
};

/**
 * Handle ref tag tokens.
 *
 * @method
 * @param {Object} TokenContext
 * @returns {Object} TokenContext
 */
Cite.prototype.onRef = function ( tokenCTX ) {

	var refGroups = this.refGroups;

	var getRefGroup = function(group) {
		if (!(group in refGroups)) {
			var refs = [],
				byName = {};
			refGroups[group] = {
				refs: refs,
				byName: byName,
				add: function(tokens, options) {
					var ref;
					if (options.name && options.name in byName) {
						ref = byName[options.name];
					} else {
						var n = refs.length;
						var key = n + '';
						if (options.name) {
							key = options.name + '-' + key;
						}
						ref = {
							tokens: tokens,
							index: n,
							groupIndex: n, // @fixme
							name: options.name,
							group: options.group,
							key: key,
							target: 'cite_note-' + key,
							linkbacks: []
						};
						refs[n] = ref;
						if (options.name) {
							byName[options.name] = ref;
						}
					}
					ref.linkbacks.push(
						'cite_ref-' + ref.key + '-' + ref.linkbacks.length
					);
					return ref;
				}
			};
		}
		return refGroups[group];
	};

	var token = tokenCTX.token;
	// Collect all tokens between ref start and endtag
	if ( ! this.isActive &&
			token.type === 'TAG' &&
			token.name.toLowerCase() === 'ref' ) {
		this.curRef = tokenCTX.token;
		// Prepend self for 'any' token type
		tokenCTX.dispatcher.prependListener(this.onRefCB, 'any' );
		tokenCTX.token = null;
		this.isActive = true;
		return tokenCTX;
	} else if ( this.isActive && 
			// Also accept really broken ref close tags..
			['TAG', 'ENDTAG', 'SELFCLOSINGTAG'].indexOf(token.type) >= 0 &&
			token.name.toLowerCase() === 'ref' 
			) 
	{
		this.isActive = false;
		tokenCTX.dispatcher.removeListener(this.onRefCB, 'any' );
		// fall through for further processing!
	} else {
		// Inside ref block: Collect all other tokens in refTokens and abort
		//console.log(JSON.stringify(tokenCTX.token, null, 2));
		this.refTokens.push(tokenCTX.token);
		tokenCTX.token = null;
		return tokenCTX;
	}

	var options = $.extend({
		name: null,
		group: null
	}, this.attribsToObject(this.curRef.attribs));

	var group = getRefGroup(options.group);
	var ref = group.add(this.refTokens, options);
	this.refTokens = [];
	var linkback = ref.linkbacks[ref.linkbacks.length - 1];


	var bits = [];
	if (options.group) {
		bits.push(options.group);
	}
	//bits.push(env.formatNum( ref.groupIndex + 1 ));
	bits.push(ref.groupIndex + 1);

	tokenCTX.token = [
	{
		type: 'TAG', 
		name: 'span',
		attribs: [
			['id', linkback],
			['class', 'reference'],
			// ignore element when serializing back to wikitext
			['data-nosource', '']
		]
	},
	{
		type: 'TAG', 
		name: 'a', 
		attribs: [
			['data-type', 'hashlink'],
			['href', '#' + ref.target]
			// XXX: Add round-trip info here?
		]
	},
	'[' + bits.join(' ')  + ']',
	{
		type: 'ENDTAG', 
		name: 'a'
	},
	{
		type: 'ENDTAG', 
		name: 'span'
	}
	];
	return tokenCTX;
};

/**
 * Handle references tag tokens.
 *
 * @method
 * @param {Object} TokenContext
 * @returns {Object} TokenContext
 */
Cite.prototype.onReferences = function ( tokenCTX ) {

	var refGroups = this.refGroups;
	
	var arrow = '↑';
	var renderLine = function( ref ) {
		//console.log('reftokens: ' + JSON.stringify(ref.tokens, null, 2));
		var out = [{
					type: 'TAG', 
					name: 'li',
					attribs: [['id', ref.target]]
			}];
		if (ref.linkbacks.length == 1) {
			out = out.concat([
					{
						type: 'TAG',
						name: 'a',
						attribs: [
							['data-type', 'hashlink'],
							['href', '#' + ref.linkbacks[0]]
						]
					},
					{type: 'TEXT', value: arrow},
					{type: 'ENDTAG', name: 'a'}
				],
				ref.tokens // The original content tokens
			);
		} else {
			out.content.push({type: 'TEXT', value: arrow});
			$.each(ref.linkbacks, function(i, linkback) {
				out = out.concat([
						{
							type: 'TAG',
							name: 'a',
							attribs: [
								['data-type', 'hashlink'],
								['href', '#' + ref.linkbacks[0]]
							]
						},
						// XXX: make formatNum available!
						//{
						//	type: 'TEXT', 
						//	value: env.formatNum( ref.groupIndex + '.' + i)
						//},
						{type: 'TEXT', value: ref.groupIndex + '.' + i},
						{type: 'ENDTAG', name: 'a'}
					],
					ref.tokens // The original content tokens
				);
			});
		}
		return out;
	};
	
	var token = tokenCTX.token;

	var options = $.extend({
		name: null,
		group: null
	}, this.attribsToObject(token.attribs));

	if (options.group in refGroups) {
		var group = refGroups[options.group];
		var listItems = $.map(group.refs, renderLine);
		tokenCTX.token = [
			{
				type: 'TAG',
				name: 'ol',
				attribs: [
					['class', 'references'],
					['data-object', 'references'] // Object type
				]
			}
		].concat( listItems, { type: 'ENDTAG', name: 'ol' } );
	} else {
		tokenCTX.token = {
			type: 'SELFCLOSINGTAG',
			name: 'placeholder',
			attribs: [
				['data-origNode', JSON.stringify(token)]
			]
		};
	}

	return tokenCTX;
};

/**
 * Handle end token.
 *
 * @method
 * @param {Object} TokenContext
 * @returns {Object} TokenContext
 */
Cite.prototype.onEnd = function ( tokenCTX ) {
	// XXX: Emit error messages if references tag was missing!
	// Clean up
	this.refGroups = {};
	this.refTokens = [];
	this.isActive = false;
	return tokenCTX;
};

if (typeof module == "object") {
	module.exports.Cite = Cite;
}
