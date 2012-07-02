/**
 * The ref / references tags don't do any fancy HTML, so we can actually
 * implement this in terms of parse tree manipulations, skipping the need
 * for renderer-specific plugins as well.
 *
 * Pretty neat huh!
 */

MWRefTagHook = function( env ) {
	if (!('cite' in env)) {
		env.cite = {
			refGroups: {}
		};
	}
	var refGroups = env.cite.refGroups;

	var getRefGroup = function(group) {
		if (!(group in refGroups)) {
			var refs = [],
				byName = {};
			refGroups[group] = {
				refs: refs,
				byName: byName,
				add: function(node, options) {
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
							node: node,
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
			}
		}
		return refGroups[group];
	};

	this.execute = function( node ) {
		var options = $.extend({
			name: null,
			group: null
		}, node.params);
		
		var group = getRefGroup(options.group);
		var ref = group.add(node, options);
		var linkback = ref.linkbacks[ref.linkbacks.length - 1];

		var bits = []
		if (options.group) {
			bits.push(options.group);
		}
		bits.push(env.formatNum( ref.groupIndex + 1 ));

		return {
			type: 'span',
			attrs: {
				id: linkback,
				'class': 'reference'
			},
			content: [
				{
					type: 'hashlink',
					target: '#' + ref.target,
					content: [
						'[' + bits.join(' ')  + ']'
					]
				},
			],
			origNode: node
		};
	};
};

MWReferencesTagHook = function( env ) {
	if (!('cite' in env)) {
		env.cite = {
			refGroups: {}
		};
	}
	var refGroups = env.cite.refGroups;
	
	var arrow = '↑';
	var renderLine = function( ref ) {
		var out = {
			type: 'li',
			attrs: {
				id: 'cite-note-' + ref.target
			},
			content: []
		};
		if (ref.linkbacks.length == 1) {
			out.content.push({
				type: 'hashlink',
				target: '#' + ref.linkbacks[0],
				content: [
					arrow
				]
			})
		} else {
			out.content.push(arrow)
			$.each(ref.linkbacks, function(i, linkback) {
				out.content.push({
					type: 'hashlink',
					target: '#' + ref.linkbacks[0],
					content: [
						env.formatNum( ref.groupIndex + '.' + i)
					]
				});
			})
		}
		out.content.push(' ');
		out.content.push({
			type: 'placeholder',
			content: ref.node.content || []
		});
		return out;
	};
	this.execute = function( node ) {
		var options = $.extend({
			name: null,
			group: null
		}, node.params);
		if (options.group in refGroups) {
			var group = refGroups[options.group];
			var listItems = $.map(group.refs, renderLine);
			return {
				type: 'ol',
				attrs: {
					'class': 'references'
				},
				content: listItems,
				origNode: node
			}
		} else {
			return {
				type: 'placeholder',
				origNode: node
			}
		}
	}
}

if (typeof module == "object") {
	module.exports.MWRefTagHook = MWRefTagHook;
}
