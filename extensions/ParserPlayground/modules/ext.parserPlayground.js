/**
 * MediaWiki:Gadget-ParserPopups.js
 * Brion Vibber <brion @ pobox.com>
 * 2011-05-02
 *
 * Initial steps on some experiments to flip between various parsing methods to
 * compare source, parse trees, and outcomes.
 *
 * Adds a fold-out section in the editor (using enhanced toolbar) to swap view of:
 * - Source (your regular editable text)
 * - MediaWiki parser (parsed page as full HTML, with XML parse tree inspector)
 * - PegParser (a very primitive parser class in this gadget), with
 *   tree inspector and primitive editing
 *
 * The parsed views update to match the current editor state when you bump over to them.
 * In side-by-side view, matching items are highlighted on the two sides, and clicking
 * will scroll the related side into view if needed.
 */
(function( $ ) {


var onResize = null;
$(window).resize(function() {
	if (onResize) {
		onResize();
	}
});
$('.mw-pp-node').live('click', function() {
	var ul = $(this.parentNode).find('ul:first');
	if (ul.is(":hidden")) {
		ul.slideDown();
	} else {
		ul.slideUp();
	}
});

var makeMagicBox = function(inside) {
	$('#mw-parser-popup').remove();
	// line-height is needed to compensate for oddity in WikiEditor extension, which zeroes the line-height on a parent container
	var box = $('#wpTextbox1');
	var target = $('<div id="mw-parser-popup" style="width: 100%; overflow-y: auto; background: white"><div class="editor" style="line-height: 1.5em; top: 0px; left: 0px; right: 0px; bottom: 0px; border: 1px solid gray">' + inside + '</div></div>').insertAfter(box);
	$('#wpTextbox1').css('display', 'none');

	onResize = function() {
		//target.width(box.width())
		//    .height(box.height());
		target.height(box.height());
	};
	onResize();
	return target;
};

/**
 * Create two scrollable columns for an 'inspector' display.
 * @param {jQuery} dest -- jquery obj to receive the target
 * @return {jQuery}
 */
var makeInspectorColumns = function(dest) {
	var h = $('#wpTextbox1').height(); // hack
	var target = $(
		'<table style="width: 100%; height: ' + h + 'px">' +
		'<tr>' +
		'<td width="50%"><div class="left" style="overflow:auto; ' +
			'height: ' + h + 'px"></div></td>' +
		'<td width="50%"><div class="right" style="overflow:auto; ' +
			'height: ' + h + 'px"></div></td>' +
		'</tr>' +
		'</table>').appendTo(dest);
	return target;
};

/**
 * Set up 'inspector' events to highlight elements with matching parseNode data properties
 * between the given two sections.
 *
 * @param {jQuery} left
 * @param {jQUery} right
 */
var setupInspector = function(left, right, leftMap, rightMap) {
	var makeMagic = function(a, b, inspectorMap) {
		var match = function(aNode, callback) {
			var treeNode = $(aNode).data('parseNode');
			var bNode = treeNode && inspectorMap.get(treeNode);
			callback(aNode, bNode);
		};
		a.delegate('.parseNode', 'mouseenter', function(event) {
			$('.parseNodeHighlight').removeClass('parseNodeHighlight');
			match(this, function(node, other) {
				$(node).addClass('parseNodeHighlight');
				if (other) {
					$(other).addClass('parseNodeHighlight');
					// try to scroll the other into view. how... feasible is this? :DD
					var visibleStart = b.scrollTop();
					var visibleEnd = visibleStart + b.height();
					var otherStart = visibleStart + $(other).position().top;
					var otherEnd = otherStart + $(other).height();
					if (otherStart > visibleEnd) {
						b.scrollTop(otherStart);
					} else if (otherEnd < visibleStart) {
						b.scrollTop(otherStart);
					}
					event.preventDefault();
					return false;
				}
			});
			event.preventDefault();
			return false;
		}).delegate('.parseNode', 'mouseleave', function(event) {
			$('.parseNodeHighlight').removeClass('parseNodeHighlight');
			event.preventDefault();
			return false;
		});
	};
	makeMagic(left, right, rightMap);
	makeMagic(right, left, leftMap);
};

var addParserModes = function(modes, parserClass, className, detail) {
	modes[className] = {
		'label': className,
		'action': {
			'type': 'callback',
			'execute': function( context ) {
				var pp = context.parserPlayground;
				pp.parser = new parserClass();
				// hack
				pp.env = new MWParserEnvironment({
					tagHooks: {
						'ref': MWRefTagHook,
						'references': MWReferencesTagHook
					}
				});
				if (pp.parser instanceof MediaWikiParser) {
					pp.serializer = pp.parser;
					pp.renderer = pp.parser;
				} else {
					pp.serializer = new MWTreeSerializer();
					pp.renderer = new MWTreeRenderer(pp.env);
				}
				context.parserPlayground.fn.initDisplay();
				$.cookie('pp-editmode', className, {
					expires: 30,
					path: '/'
				});
			}
		}
	};
};

$(document).ready( function() {
	/* Start trying to add items... */
	var editor = $('#wpTextbox1');
	if (editor.length > 0 && typeof $.fn.wikiEditor === 'function') {
		//$('#wpTextbox1').bind('wikiEditor-toolbar-buildSection-main', function() {
		var listItems = {
			'sourceView': {
				'label': 'Source',
				'action': {
					'type': 'callback',
					'execute': function( context ) {
						$.cookie('pp-editmode', null, {
							expires: 30,
							path: '/'
						});
						context.parserPlayground.fn.disable();
					}
				}
			}
		};
		addParserModes(listItems, MediaWikiParser, 'MediaWikiParser');
		addParserModes(listItems, PegParser, 'PegParser', '<p>Peg-based parser plus FakeParser\'s output. <a href="http://pegjs.majda.cz/documentation">pegjs documentation</a>; edit and reselect to reparse with updated parser</p>');

		window.setTimeout(function() {
			var context = editor.data('wikiEditor-context');
			var pp = context.parserPlayground = {
				parser: undefined,
				tree: undefined,
				useInspector: false,
				fn: {
					initDisplay: function() {
						if (context.$parserContainer) {
							context.parserPlayground.fn.hide();
						}
						var $target = makeMagicBox('');
						$('#mw-parser-inspector').remove();
						var $inspector = $('<div id="mw-parser-inspector" style="position: relative; width: 100%; overflow-y: auto; height: 200px"></div>');
						$inspector.insertAfter($target);
						if (!context.parserPlayground.useInspector) {
							$inspector.hide();
						}

						context.$parserContainer = $target;
						context.$parserInspector = $inspector;

						var src = $('#wpTextbox1').val();

						var parser = pp.parser;
						parser.parseToTree(src, function(tree, err) {
							if (err) mw.log(err);
							pp.tree = tree;
							pp.fn.displayTree();
						});

						context.$textarea.closest('form').submit( context.parserPlayground.fn.onSubmit );

					},
					displayTree: function() {
						pp.treeMap = new HashMap();
						pp.renderMap = new HashMap();
						if (pp.useInspector) {
							context.$parserInspector.nodeTree( pp.tree, function( node, el ) {
								pp.treeMap.put( node, el );
							});
						}
						pp.renderer.treeToHtml(pp.tree, function(node, err) {
							if (err) mw.log(err);
							var $dest = context.$parserContainer.find('div');
							$dest.empty().append(node);
							context.parserPlayground.fn.setupEditor(context.$parserContainer);
							setupInspector(context.$parserContainer, context.$parserInspector, pp.renderMap, pp.treeMap);
						}, pp.renderMap);
					},
					hide: function() {
						//$('#pegparser-source').hide(); // it'll reshow; others won't need it
						context.$iframe = undefined;
						if (context.$parserContainer !== undefined) {
							context.$parserContainer.remove();
						}
						context.$parserContainer = undefined;
						if (context.$parserInspector !== undefined) {
							context.$parserInspector.remove();
						}
						context.$parserInspector = undefined;
						context.$textarea.show();
					},
					disable: function() {
						var pp = context.parserPlayground;
						var finish = function() {
							pp.parser = undefined;
							pp.tree = undefined;
							pp.fn.hide();
						};
						if (pp.parser && pp.tree) {
							pp.serializer.treeToSource( pp.tree, function( src, err ) {
								if (err) mw.log(err);
								context.$textarea.val( src );
								finish();
							});
						} else {
							finish();
						}
					},
					toggleInspector: function() {
						if (context.parserPlayground.useInspector) {
							context.parserPlayground.useInspector = false;
							context.$parserInspector.hide();
						} else if ( context.parserPlayground.parser ) {
							context.parserPlayground.useInspector = true;
							context.$parserInspector.empty().show();
							context.$parserInspector.nodeTree( context.parserPlayground.tree, function( node, el ) {
								context.parserPlayground.treeMap.put( node, el );
							});
						}
						var target = 'img.tool[rel=inspector]';
						var $img = context.modules.toolbar.$toolbar.find( target );
						$img.attr('src', context.parserPlayground.fn.inspectorToolbarIcon());
					},
					inspectorToolbarIcon: function() {
						// When loaded as a gadget, one may need to override the wiki's own assets path.
						var iconPath = mw.config.get('wgParserPlaygroundAssetsPath', mw.config.get('wgExtensionAssetsPath')) + '/ParserPlayground/modules/images/';
						return iconPath + (context.parserPlayground.useInspector ? 'inspector-active.png' : 'inspector.png');
					},
					setupEditor: function($target) {
						$target.delegate('.parseNode', 'click', function(event) {
							var node = $(this).data('parseNode');
							if ( node ) {
								// Ok, not 100% kosher right now but... :D
								pp.serializer.treeToSource(node, function(src, err) {
									if (err) mw.log(err);
									//alert( src );
									pp.sel = {
										node: node,
										src: src
									};
									context.$textarea.wikiEditor('openDialog', 'vis-edit-source');
								});
								event.preventDefault();
								return false;
							}
						});
					},
					onSubmit: function() {
						// @fixme if we're really doing async, this might not apply right
						// disable the old thingy and record the updated text before finishing submit
						context.parserPlayground.fn.disable();
					}
				}
			}
			editor.wikiEditor( 'addDialog', {
				'vis-edit-source': {
					title: 'Edit source fragment',
					id: 'vis-edit-source-dialog',
					html: '\
						<fieldset>\
							<div class="wikieditor-toolbar-field-wrapper">\
								<textarea id="vis-edit-source-text"></textarea>\
							</div>\
						</fieldset>',
					init: function() {
						//
					},
					dialog: {
						width: 500,
						dialogClass: 'wikiEditor-toolbar-dialog',
						buttons: {
							'vis-edit-source-ok': function() {
								var origNode = pp.sel.node,
									$textarea = $('#vis-edit-source-text'),
									$dlg = $(this);

								pp.parser.parseToTree($textarea.val(), function(tree, err) {
									if (err) mw.log(err);
									// Silly and freaky hack :D
									// Crap... no good way to replace or find parent here. Bad temp dom. ;)
									var replaceNode = function(searchFor, replaceWithNodes, haystack) {
										// Look in 'data' arrays for subnodes.
										if (typeof haystack == 'object' && 'content' in haystack) {
											var content = haystack.content, len = content.length;
											for (var i = 0; i < len; i++) {
												if (content[i] === searchFor) {
													//Array.splice.apply(content, [i, 1].concat(replaceWithNodes));
													var before = content.slice(0, i),
														after = content.slice(i + 1);
													content = before.concat(replaceWithNodes).concat(after);
													haystack.content = content;
													return true;
												} else {
													if (replaceNode(searchFor, replaceWithNodes, content[i])) {
														return true;
													}
												}
											}
										}
										return false;
									};
									// @fixme avoid bad nesting
									var newNodes = tree.content;
									if (origNode.type != 'para' && newNodes.length == 1 && newNodes[0].type == 'para') {
										// To avoid funky nesting; find the good stuff!
										// Ideally, we would pass proper parse context in so wouldn't need to do this.
										newNodes = newNodes[0].content;
									}
									if (replaceNode(origNode, newNodes, pp.tree)) {
										pp.sel = null;
										$textarea.empty();
										$dlg.dialog( 'close' );

										pp.fn.displayTree(); // todo: nicer update :D
									} else {
										alert('Could not find original node to replace!');
									}
								});
							},
							'vis-edit-source-cancel': function() {
								pp.sel = null;
								$(this).dialog( 'close' );
							}
						},
						open: function() {
							$('#vis-edit-source-text').val(pp.sel.src);
						}
					}
				}
			});
			editor.wikiEditor( 'addToToolbar', {
				'sections': {
					'richedit': {
						'label': 'Rich editor',
						'type': 'toolbar',
						'groups': {
							'mode': {
								'tools': {
									'mode': {
										'label': 'Mode',
										'type': 'select',
										'list': listItems
									},
									'inspector': {
										'label': 'Toggle inspector',
										'type': 'button',
										'icon': context.parserPlayground.fn.inspectorToolbarIcon(),
										'action': {
											'type': 'callback',
											'execute': context.parserPlayground.fn.toggleInspector
										}
									}
								}
							}
						}
					}
				}
			} );
			var editMode = $.cookie('pp-editmode');
			if ( editMode && editMode in listItems ) {
				listItems[editMode].action.execute( context );
			}
		}, 500 );
	} else {
		mw.log('No wiki editor');
	}
});

})(jQuery);
