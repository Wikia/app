$(document).ready( function() {
	var wikidoms = {
		'Wikipedia article': {
			'type': 'document',
			'children': [
				{
					'type': 'heading',
					'attributes': { 'level': 1 },
					'content': { 'text': 'Direct manipulation interface' }
				},
				{
					'type': 'paragraph',
					'content': {
						'text': 'In computer science, direct manipulation is a human-computer interaction style which involves continuous representation of objects of interest, and rapid, reversible, incremental actions and feedback. The intention is to allow a user to directly manipulate objects presented to them, using actions that correspond at least loosely to the physical world. An example of direct-manipulation is resizing a graphical shape, such as a rectangle, by dragging its corners or edges with a mouse.',
						'annotations': [
							{
								'type': 'link/internal',
								'data': {
									'title': 'Computer_science'
								},
								'range': {
									'start': 3,
									'end': 19
								}
							},
							{
								'type': 'link/internal',
								'data': {
									'title': 'Human-computer interaction'
								},
								'range': {
									'start': 46,
									'end': 72
								}
							}
						]
					}
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Having real-world metaphors for objects and actions can make it easier for a user to learn and use an interface (some might say that the interface is more natural or intuitive), and rapid, incremental feedback allows a user to make fewer errors and complete tasks in less time, because they can see the results of an action before completing the action, thus evaluating the output and compensating for mistakes.' }
				},
				{
					'type': 'paragraph',
					'content': {
						'text': 'The term was introduced by Ben Shneiderman in 1983 within the context of office applications and the desktop metaphor.  Individuals in academia and computer scientists doing research on future user interfaces often put as much or even more stress on tactile control and feedback, or sonic control and feedback than on the visual feedback given by most GUIs. As a result the term direct manipulation interface has been more widespread in these environments. ',
						'annotations': [
							{
								'type': 'link/internal',
								'data': {
									'title': 'Ben_Shneiderman'
								},
								'range': {
									'start': 27,
									'end': 42
								}
							},
							{
								'type': 'link/internal',
								'data': {
									'title': 'GUI'
								},
								'range': {
									'start': 352,
									'end': 356
								}
							},
							{
								'type': 'object/hook',
								'data': {
									'html': '<sup><small><a href="#">[1]</a></small></sup>'
								},
								'range': {
									'start': 118,
									'end': 119
								}
							},
							{
								'type': 'object/template',
								'data': {
									'html': '<sup><small>[<a href="#">citation needed</a>]</small></sup>'
								},
								'range': {
									'start': 456,
									'end': 457
								}
							}
						]
					}
				},
				{
					'type': 'heading',
					'attributes': { 'level': 2 },
					'content': { 'text': 'In contrast to WIMP/GUI interfaces' }
				},
				{
					'type': 'paragraph',
					'content': {
						'text': 'Direct manipulation is closely associated with interfaces that use windows, icons, menus, and a pointing device (WIMP GUI) as these almost always incorporate direct manipulation to at least some degree. However, direct manipulation should not be confused with these other terms, as it does not imply the use of windows or even graphical output. For example, direct manipulation concepts can be applied to interfaces for blind or vision-impaired users, using a combination of tactile and sonic devices and software.',
						'annotations': [
							{
								'type': 'link/internal',
								'data': {
									'title': 'WIMP_(computing)'
								},
								'range': {
									'start': 113,
									'end': 117
								}
							}
						]
					}
				},
				{
					'type': 'paragraph',
					'content': {
						'text': 'It is also possible to design a WIMP interface that intentionally does not make use of direct manipulation. For example, most versions of windowing interfaces (e.g. Microsoft Windows) allowed users to reposition a window by dragging it with the mouse, but would not continually redraw the complete window at intermediate positions during the drag. Instead, for example, a rectangular outline of the window might be drawn during the drag, with the complete window contents being redrawn only once the user had released the mouse button. This was necessary on older computers that lacked the memory and/or CPU power to quickly redraw data behind a window that was being dragged.',
						'annotations': [
							{
								'type': 'link/internal',
								'data': {
									'title': 'Microsoft_Windows'
								},
								'range': {
									'start': 165,
									'end': 182
								}
							}
						]
					}
				},
				{
					'type': 'heading',
					'attributes': { 'level': 2 },
					'content': { 'text': 'In point of sale graphic interfaces' }
				},
				{
					'type': 'paragraph',
					'content': {
						'text': 'The ViewTouch graphic touchscreen POS (point of sale) GUI developed by Gene Mosher on the Atari ST computer and first installed in restaurants in 1986 is an early example of an application specific GUI that manifests all of the characteristics of direct manipulation.'
					}
				},				
				{
					'type': 'paragraph',
					'content': {
						'text': 'Mosher\'s POS touchscreen GUI has been widely copied and is in universal use on virtually all modern point of sale displays. Even in its earliest form it contained such features as \'lighting up\' both selected \'buttons\' (i.e., widgets) and \'tab\' buttons which indicated the user\'s current position in the transaction as the user navigated among the application\'s pages.'
					}
				},				
				{
					'type': 'paragraph',
					'content': {
						'text': 'In 1995 the ViewTouch GUI was developed into an X Window System window manager, extending the usefulness of the direct manipulation interface to users equipped with no other equipment than networked displays relying on the X network display protocol. This application is a practical and useful example of the benefit of the direct manipulation interface. Users are freed from the requirement of making use of keyboards, mice and even local computers themselves while they are simultaneously empowered to work in collaborative fashion with each other in world wide virtual workgroups by merely interacting with the framework of graphical symbols on the networked touchscreen.'
					}
				},				
				{
					'type': 'heading',
					'attributes': { 'level': 2 },
					'content': { 'text': 'In computer graphics' }
				},
				{
					'type': 'paragraph',
					'content': {
						'text': 'Because of the difficulty of visualizing and manipulating various aspects of computer graphics, including geometry creation and editing, animation, layout of objects and cameras, light placement, and other effects, direct manipulation is an extremely important part of 3D computer graphics. There are standard direct manipulation widgets as well as many unique widgets that are developed either as a better solution to an old problem or as a solution for a new and/or unique problem. The widgets attempt to allow the user to modify an object in any possible direction while also providing easy guides or constraints to allow the user to easily modify an object in the most common directions, while also attempting to be as intuitive as to the function of the widget as possible. The three most ubiquitous transformation widgets are mostly standardized and are:'
					}
				},				
				{
					'type': 'list',
					'children': [
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['bullet']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'the translation widget, which usually consists of three arrows aligned with the orthogonal axes centered on the object to be translated. Dragging the center of the widget translates the object directly underneath the mouse pointer in the plane parallel to the camera plane, while dragging any of the three arrows translates the object along the appropriate axis. The axes may be aligned with the world-space axes, the object-space axes, or some other space.' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['bullet']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'the rotation widget, which usually consists of three circles aligned with the three orthogonal axes, and one circle aligned with the camera plane. Dragging any of the circles rotates the object around the appropriate axis, while dragging elsewhere will freely rotate the object (virtual trackball rotation).' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['bullet']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'the scale widget, which usually consists of three short lines aligned with the orthogonal axes terminating in boxes, and one box in the center of the widget. Dragging any of the three axis-aligned boxes effects a non-uniform scale along solely that axis, while dragging the center box effects a uniform scale on all three axes at once.' }
								}
							]
						}

					]
				},
				{
					'type': 'paragraph',
					'content': {
						'text': 'Depending on the specific common uses of an object, different kinds of widgets may be used. For example, a light in computer graphics is, like any other object, also defined by a transformation (translation and rotation), but it is sometimes positioned and directed simply with its endpoint positions because it may be more intuitive to define the position of the light source and then define the light\'s target, rather than rotating it around the coordinate axes in order to point it at a known position.'
					}
				},				
				{
					'type': 'paragraph',
					'content': {
						'text': 'Other widgets may be unique for a particular tool, such as edge controls to change the cone of a spotlight, points and handles to define the position and tangent vector for a spline control point, circles of variable size to define a blur filter width or paintbrush size, IK targets for hands and feet, or color wheels and swatches for quickly choosing colors. Complex widgets may even incorporate some techniques from scientific visualization to efficiently present relevant data (such as vector fields for particle effects or false color images to display vertex maps).'
					}
				},				
				{
					'type': 'paragraph',
					'content': {
						'text': 'Direct manipulation, as well as user interface design in general, for 3D computer graphics tasks, is still an active area of invention and innovation, as the process of generating CG images is generally not considered to be intuitive or easy in comparison to the difficulty of what the user wants to do, especially for complex tasks. The user interface for word processing, for example, is easy to learn for new users and is sufficient for most word processing tasks, so it is a mostly solved and standardized UI, while the user interfaces for 3D computer graphics are usually either difficult to learn and use and not sufficiently powerful for complex tasks, or sufficiently powerful but extremely difficult to learn and use, so direct manipulation and user interfaces will vary wildly from application to application.'
					}
				}				
			]
		},
		'Formatting': {
			'type': 'document',
			'children': [
				{
					'type': 'heading',
					'attributes': { 'level': 1 },
					'content': {
						'text': 'This is a heading (level 1)',
						'annotations': [
							{
								'type': 'textStyle/italic',
								'range': {
									'start': 10,
									'end': 17
								}
							}
						]	
					}
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Paragraph' }
				},
				{
					'type': 'heading',
					'attributes': { 'level': 2 },
					'content': {
						'text': 'This is a heading (level 2)',
						'annotations': [
							{
								'type': 'textStyle/italic',
								'range': {
									'start': 10,
									'end': 17
								}
							}
						]	
					}
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Paragraph' }
				},
				{
					'type': 'heading',
					'attributes': { 'level': 3 },
					'content': {
						'text': 'This is a heading (level 3)',
						'annotations': [
							{
								'type': 'textStyle/italic',
								'range': {
									'start': 10,
									'end': 17
								}
							}
						]	
					}
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Paragraph' }
				},
				{
					'type': 'heading',
					'attributes': { 'level': 4 },
					'content': {
						'text': 'This is a heading (level 4)',
						'annotations': [
							{
								'type': 'textStyle/italic',
								'range': {
									'start': 10,
									'end': 17
								}
							}
						]	
					}
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Paragraph' }
				},
				{
					'type': 'heading',
					'attributes': { 'level': 5 },
					'content': {
						'text': 'This is a heading (level 5)',
						'annotations': [
							{
								'type': 'textStyle/italic',
								'range': {
									'start': 10,
									'end': 17
								}
							}
						]	
					}
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Paragraph' }
				},
				{
					'type': 'heading',
					'attributes': { 'level': 6 },
					'content': {
						'text': 'This is a heading (level 6)',
						'annotations': [
							{
								'type': 'textStyle/italic',
								'range': {
									'start': 10,
									'end': 17
								}
							}
						]	
					}
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Paragraph' }
				},
				{
				'type': 'pre',
				'content': { 'text': 'A lot of text goes here... and at some point it wraps.. A lot of text goes here... and at some point it wraps.. A lot of text goes here... and at some point it wraps.. A lot of text goes here... and at some point it wraps.. A lot of text goes here... and at some point it wraps..' }
				},
				{
					'type': 'heading',
					'attributes': { 'level': 1 },
					'content': { 'text': 'Lists' }
				},
				{
					'type': 'list',
					'children': [
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['bullet']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Bullet' }
								}
							]
						}
					]
				},
				{
					'type': 'paragraph',
					'content': { 'text': 'Paragraph' }
				},
				{
					'type': 'list',
					'children': [
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['bullet']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Bullet' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['bullet', 'bullet']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Bullet bullet' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['bullet', 'bullet', 'bullet']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Bullet bullet bullet' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['number']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Number' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['number', 'number']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Number number' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['term']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Term' }
								}
							]
						},
						{
							'type': 'listItem',
							'attributes': {
								'styles': ['definition']
							},
							'children' : [
								{
									'type': 'paragraph',
									'content': { 'text': 'Definition' }
								}
							]
						}
					]
				}
			]
		},
		/*
		'Tables': {
			'type': 'document',
			'children': [
				{
					'type': 'heading',
					'attributes': { 'level': 1 },
					'content': { 'text': 'Tables' }
				},
				{
					'type': 'table',
					'attributes': { 'html/style': 'width: 600px; border: solid 1px;' },
					'children': [
						{
							'type': 'tableRow',
							'children': [
								{
									'type': 'tableCell',
									'attributes': { 'html/style': 'border: solid 1px;' },
									'children': [
										{
											'type': 'paragraph',
											'content': { 'text': 'row 1 & cell 1' }
										},
										{
											'type': 'list',
											'children': [
												{
													'type': 'listItem',
													'attributes': {
														'styles': ['bullet']
													},
													'children' : [
														{
															'type': 'paragraph',
															'content': { 'text': 'Test 4444' }
														}
													]												
												},
												{
													'type': 'listItem',
													'attributes': {
														'styles': ['bullet', 'bullet']
													},
													'children' : [
														{
															'type': 'paragraph',
															'content': { 'text': 'Test 55555' }
														}
													]												
												},
												{
													'type': 'listItem',
													'attributes': {
														'styles': ['number']
													},
													'children' : [
														{
															'type': 'paragraph',
															'content': { 'text': 'Test 666666' }
														}
													]												
												}
											]
										}
									]
								},
								{
									'type': 'tableCell',
									'attributes': { 'html/style': 'border: solid 1px;' },
									'children': [
										{
											'type': 'paragraph',
											'content': { 'text': 'row 1 & cell 2' }
										}
									]
								}
							]
						}
					]
				}
			]
		},*/
		'New document': {
			'type': 'document',
			'children': [
				{
					'type': 'paragraph',
					'content': { 'text': '' }
				}
			]
		}
	};
	window.documentModel = ve.dm.DocumentNode.newFromPlainObject( wikidoms['Wikipedia article'] );
	window.surfaceModel = new ve.dm.Surface( window.documentModel );
	window.surfaceView = new ve.es.Surface( $( '#es-editor' ), window.surfaceModel );
	window.toolbarView = new ve.ui.Toolbar( $( '#es-toolbar' ), window.surfaceView );
	window.contextView = new ve.ui.Context( window.surfaceView );
	window.surfaceModel.select( new ve.Range( 1, 1 ) );

	/*
	 * This code is responsible for switching toolbar into floating mode when scrolling (with
	 * keyboard or mouse).
	 */
	var $toolbarWrapper = $( '#es-toolbar-wrapper' ),
		$toolbar = $( '#es-toolbar' ),
		$window = $( window );
	$window.scroll( function() {
		var toolbarWrapperOffset = $toolbarWrapper.offset();
		if ( $window.scrollTop() > toolbarWrapperOffset.top ) {
			if ( !$toolbarWrapper.hasClass( 'float' ) ) {
				var	left = toolbarWrapperOffset.left,
					right = $window.width() - $toolbarWrapper.outerWidth() - left;
				$toolbarWrapper.css( 'height', $toolbarWrapper.height() ).addClass( 'float' );
				$toolbar.css( { 'left': left, 'right': right } );
			}
		} else {
			if ( $toolbarWrapper.hasClass( 'float' ) ) {
				$toolbarWrapper.css( 'height', 'auto' ).removeClass( 'float' );
				$toolbar.css( { 'left': 0, 'right': 0 } );
			}
		}
	} );

	var $modeButtons = $( '.es-modes-button' ),
		$panels = $( '.es-panel' ),
		$base = $( '#es-base' ),
		currentMode = null,
		modes = {
			'wikitext': {
				'$': $( '#es-mode-wikitext' ),
				'$panel': $( '#es-panel-wikitext' ),
				'update': function() {
					this.$panel.text(
						ve.dm.WikitextSerializer.stringify( documentModel.getPlainObject() )
					);
				}
			},
			'json': {
				'$': $( '#es-mode-json' ),
				'$panel': $( '#es-panel-json' ),
				'update': function() {
					this.$panel.text( ve.dm.JsonSerializer.stringify( documentModel.getPlainObject(), {
						'indentWith': '  '
					} ) );
				}
			},
			'html': {
				'$': $( '#es-mode-html' ),
				'$panel': $( '#es-panel-html' ),
				'update': function() {
					this.$panel.text(
						ve.dm.HtmlSerializer.stringify( documentModel.getPlainObject() )
					);
				}
			},
			'render': {
				'$': $( '#es-mode-render' ),
				'$panel': $( '#es-panel-render' ),
				'update': function() {
					this.$panel.html(
						ve.dm.HtmlSerializer.stringify( documentModel.getPlainObject() )
					);
				}
			},
			'history': {
				'$': $( '#es-mode-history' ),
				'$panel': $( '#es-panel-history' ),
				'update': function() {
					var	history = surfaceModel.getHistory(),
						i = history.length,
						end = Math.max( 0, i - 25 ),
						j,
						k,
						ops,
						events = '',
						z = 0,
						operations;
						
					while ( --i >= end ) {
						z++;
						operations = [];
						for ( j = 0; j < history[i].stack.length; j++) {
							ops = history[i].stack[j].getOperations().slice(0);
							for ( k = 0; k < ops.length; k++ ) {
								data = ops[k].data || ops[k].length;
								if ( ve.isArray( data ) ) {
									data = data[0];
									if ( ve.isArray( data ) ) {
										data = data[0];
									}
								}
								if ( typeof data !== 'string' && typeof data !== 'number' ) {
									data = '-';
								}
								ops[k] = ops[k].type.substr( 0, 3 ) + '(' + data + ')';
							}
							operations.push('[' + ops.join( ', ' ) + ']');
						}
						events += '<div' + (z === surfaceModel.undoIndex ? ' class="es-panel-history-active"' : '') + '>' + operations.join(', ') + '</div>';
					}
					
					this.$panel.html( events );
				}
			},
			'help': {
				'$': $( '#es-mode-help' ),
				'$panel': $( '#es-panel-help' ),
				'update': function() {}
			}
		};
	$.each( modes, function( name, mode ) {
		mode.$.click( function() {
			var disable = $(this).hasClass( 'es-modes-button-down' );
			var visible = $base.hasClass( 'es-showData' );
			$modeButtons.removeClass( 'es-modes-button-down' );
			$panels.hide();
			if ( disable ) {
				if ( visible ) {
					$base.removeClass( 'es-showData' );
					$window.resize();
				}
				currentMode = null;
			} else {
				$(this).addClass( 'es-modes-button-down' );
				mode.$panel.show();
				if ( !visible ) {
					$base.addClass( 'es-showData' );
					$window.resize();
				}
				mode.update.call( mode );
				currentMode = mode;
			}
		} );
	} );

	var $docsList = $( '#es-docs-list' );
	$.each( wikidoms, function( title, wikidom ) {
		$docsList.append(
			$( '<li class="es-docs-listItem"></li>' )
				.append(
					$( '<a href="#"></a>' )
						.text( title )
						.click( function() {
							var newDocumentModel = ve.dm.DocumentNode.newFromPlainObject( wikidom );
							documentModel.data.splice( 0, documentModel.data.length );
							ve.insertIntoArray( documentModel.data, 0, newDocumentModel.data );
							surfaceModel.select( new ve.Range( 1, 1 ) );
							documentModel.splice.apply(
								documentModel,
								[0, documentModel.getChildren().length]
									.concat( newDocumentModel.getChildren() )
							);
							surfaceModel.purgeHistory();
							
							if ( currentMode ) {
								currentMode.update.call( currentMode );
							}
							return false;
						} )
				)
		);
	} );

	surfaceModel.on( 'transact', function() {
		if ( currentMode ) {
			currentMode.update.call( currentMode );
		}
	} );
	surfaceModel.on( 'select', function() {
		if ( currentMode === modes.history ) {
			currentMode.update.call( currentMode );
		}
	} );

	$( '#es-docs' ).css( { 'visibility': 'visible' } );
	$( '#es-base' ).css( { 'visibility': 'visible' } );
} );
