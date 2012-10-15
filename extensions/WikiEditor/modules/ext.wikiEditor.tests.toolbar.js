/**
 * Test set for the edit toolbar
 */
var textareaId = '#wpTextbox1';
var wikiEditorTests = {
	// Add emoticons section
	'add_sections_toolbar': {
		'call': 'addToToolbar',
		'data': {
			'sections': {
				'emoticons': {
					'type': 'toolbar',
					'label': 'Emoticons'
				}
			}
		},
		'test': '*[rel=emoticons].section',
		'pre': 0,
		'post': 1
	},
	// Add faces group to emoticons section
	'add_groups': {
		'call': 'addToToolbar',
		'data': {
			'section': 'emoticons',
			'groups': {
				'faces': {
					'label': 'Faces'
				}
			}
		},
		'test': '*[rel=emoticons].section *[rel=faces].group',
		'pre': 0,
		'post': 1
	},
	// Add smile tool to faces group of emoticons section
	'add_tools': {
		'call': 'addToToolbar',
		'data': {
			'section': 'emoticons',
			'group': 'faces',
			'tools': {
				'smile': {
					label: 'Smile!',
					type: 'button',
					icon: 'http://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Gnome-face-smile.svg/22px-Gnome-face-smile.svg.png',
					action: {
						type: 'encapsulate',
						options: {
							pre: ":)"
						}
					}
				}
			}
		},
		'test': '*[rel=emoticons].section *[rel=faces].group *[rel=smile].tool',
		'pre': 0,
		'post': 1
	},
	// Add info section
	'add_sections_booklet': {
		'call': 'addToToolbar',
		'data': {
			'sections': {
				'info': {
					'type': 'booklet',
					'label': 'Info'
				}
			}
		},
		'test': '*[rel=info].section',
		'pre': 0,
		'post': 1
	},
	// Add info section
	'add_pages_table': {
		'call': 'addToToolbar',
		'data': {
			'section': 'info',
			'pages': {
				'colors': {
					'layout': 'table',
					'label': 'Colors',
					'headings': [
						{ text: 'Name' },
						{ text: 'Temperature' },
						{ text: 'Swatch' }
					]
				}
			}
		},
		'test': '*[rel=info].section *[rel=colors].page',
		'pre': 0,
		'post': 1
	},
	// Add colors rows
	'add_rows': {
		'call': 'addToToolbar',
		'data': {
			'section': 'info',
			'page': 'colors',
				'rows': [
					{
						'name': { text: 'Red' },
						'temp': { text: 'Warm' },
						'swatch': { html: '<div style="width:10px;height:10px;background-color:red;">' }
					},
					{
						'name': { text: 'Blue' },
						'temp': { text: 'Cold' },
						'swatch': { html: '<div style="width:10px;height:10px;background-color:blue;">' }
					},
					{
						'name': { text: 'Silver' },
						'temp': { text: 'Neutral' },
						'swatch': { html: '<div style="width:10px;height:10px;background-color:silver;">' }
					}
				]
		},
		'test': '*[rel=info].section *[rel=colors].page tr td',
		'pre': 0,
		'post': 9
	},
	// Add
	'add_pages_characters': {
		'call': 'addToToolbar',
		'data': {
			'section': 'info',
			'pages': {
				'emoticons': {
					'layout': 'characters',
					'label': 'Emoticons'
				},
				'removeme': {
					'layout': 'characters',
					'label': 'Remove Me!'
				}
			}
		},
		'test': '*[rel=info].section *[rel=emoticons].page',
		'pre': 0,
		'post': 1
	},
	// Add
	'add_characters': {
		'call': 'addToToolbar',
		'data': {
			'section': 'info',
			'page': 'emoticons',
			'characters': [ ':)', ':))', ':(', '<3', ';)' ]
		},
		'test': '*[rel=info].section *[rel=emoticons].page *[rel=":)"]',
		'pre': 0,
		'post': 1
	},
	// Remove page
	'remove_page': {
		'call': 'removeFromToolbar',
		'data': {
			'section': 'info',
			'page': 'removeme'
	    },
	    'test': '*[rel=info].section *[rel=removeme].page',
		'pre': 1,
		'post': 0
	},
	// Remove :)) from emoticon characters
	'remove_character': {
		'call': 'removeFromToolbar',
		'data': {
			'section': 'info',
			'page': 'emoticons',
			'character': ':))'
	    },
	    'test': '*[rel=info].section *[rel=emoticons].page *[rel=":))"]',
		'pre': 1,
		'post': 0
	},
	// Remove row from colors table of info section
	'remove_row': {
		'call': 'removeFromToolbar',
		'data': {
			'section': 'info',
			'page': 'colors',
			'row': 0
		},
		'test': '*[rel=info].section *[rel=colors].page tr td',
		'pre': 9,
		'post': 6
	}
};
$(document).ready( function() {
	var button = $( '<button>Run wikiEditor Tests!</button>' )
		.css( {
			'position': 'fixed',
			'bottom': 0,
			'right': 0,
			'width': '100%',
			'backgroundColor': '#333333',
			'opacity': 0.75,
			'color': '#DDDDDD',
			'padding': '0.5em',
			'border': 'none',
			'display': 'none'
		} )
		.click( function() {
			if ( $(this).attr( 'enabled' ) == 'false' ) {
				$(this).slideUp( 'fast' );
				return false;
			}
			var messages = [ 'Running tests for wikiEditor API' ];
			var $target = $( textareaId );
			var $ui = $target.data( 'wikiEditor-context' ).$ui;
			var passes = 0;
			var tests = 0;
			for ( var test in wikiEditorTests ) {
				var pre = $ui.find( wikiEditorTests[test].test ).size() ==
					wikiEditorTests[test].pre;
				messages.push ( test + '-pre: ' + ( pre ? 'PASS' : 'FAIL' ) );
				$target.wikiEditor(
					wikiEditorTests[test].call,
					wikiEditorTests[test].data
				);
				var post = $ui.find( wikiEditorTests[test].test ).size() ==
					wikiEditorTests[test].post;
				messages.push ( test + '-post: ' + ( post ? 'PASS' : 'FAIL' ) );
				if ( pre && post ) {
					passes++;
				}
				tests++;
			}
			if ( window.console !== undefined ) {
				for ( var i = 0; i < messages.length; i++ ) {
					console.log( messages[i] );
				}
			}
			$(this)
				.attr( 'title', messages.join( " | " ) )
				.text( passes + ' / ' + tests + ' were successful' )
				.css( 'backgroundColor', passes < tests ? 'red' : 'green' )
				.attr( 'enabled', 'false' )
				.blur();
		} )
		.appendTo( $( 'body' ) );
	setTimeout( function() { button.slideDown( 'fast' ) }, 2000 );
} );
