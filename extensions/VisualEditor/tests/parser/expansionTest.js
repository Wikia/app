var pageDatabase = {
	'Boring': 'Just some text and [[a link]].',
	'Template:Parens': '({{{1}}})',
	'ParenCaller': '{{Parens|bizbax}}'
}
var domDatabase = {
	'Boring': {
		type: 'root',
		contents: [
			'Just some text and ',
			{
				type: 'link',
				target: 'a link'
			},
			'.'
		]
	},
	'Template:Parens': {
		type: 'root',
		contents: [
			'(',
			{
				type: 'tplarg',
				/*
				contents: [
					'1'
				]*/
				name: '1'
			},
			')'
		]
	},
	'ParenCaller': {
		type: 'root',
		contents: [
			{
				type: 'template',
				/*
				contents: [
					{
						type: 'title',
						contents: [
							'Parens'
						]
					},
					{
						type: 'part',
						contents: [
							{
								type: 'name',
								index: 1
							},
							{
								type: 'value',
								contents: [
									'bizbax'
								]
							}
						]
					}
				]*/
				name: 'Parens',
				params: {
					1: 'bizbax'
				}
			}
		]
	}
};

$(function() {
	var env = new MWParserEnvironment({
		'pageCache': pageDatabase,
		'domCache': domDatabase
	});
	env.debug = true;
	var frame = new PPFrame(env);
	//var victim = 'Boring';
	var victim = 'ParenCaller';
	frame.expand(domDatabase[victim], 0, function(node, err) {
		if (err) {
			console.log('error', err);
		} else {
			console.log(node);
		}
	});
})
