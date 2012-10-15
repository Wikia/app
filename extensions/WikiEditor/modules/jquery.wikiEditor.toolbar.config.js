/**
 * Configuration of Toolbar module for wikiEditor
 */
( function( $ ) { $.wikiEditor.modules.toolbar.config = {

getDefaultConfig: function() {
	var fileNamespace = mw.config.get( 'wgFormattedNamespaces' )[6];
	return { 'toolbar': {
		// Main section
		'main': {
			'type': 'toolbar',
			'groups': {
				'format': {
					'tools': {
						'bold': {
							'labelMsg': 'wikieditor-toolbar-tool-bold',
							'type': 'button',
							'offset': {
								'default': [2, -574],
								'en': [2, -142],
								'cs': [2, -142],
								'de': [2, -214],
								'fr': [2, -286],
								'es': [2, -358],
								'he': [2, -142],
								'hu': [2, -214],
								'it': [2, -286],
								'nl': [2, -502],
								'pt': [2, -358],
								'pt-br': [2, -358],
								'pl': [2, -142],
								'ml': [2, -142]
							},
							'icon': {
								'default': 'format-bold.png',
								'en': 'format-bold-B.png',
								'cs': 'format-bold-B.png',
								'de': 'format-bold-F.png',
								'fr': 'format-bold-G.png',
								'es': 'format-bold-N.png',
								'he': 'format-bold-B.png',
								'hu': 'format-bold-F.png',
								'it': 'format-bold-G.png',
								'ka': 'format-bold-ka.png',
								'nl': 'format-bold-V.png',
								'pt': 'format-bold-N.png',
								'pt-br': 'format-bold-N.png',
								'pl': 'format-bold-B.png',
								'ru': 'format-bold-ru.png',
								'ml': 'format-bold-B.png'
							},
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "'''",
									'periMsg': 'wikieditor-toolbar-tool-bold-example',
									'post': "'''"
								}
							}
						},
						'italic': {
							'section': 'main',
							'group': 'format',
							'id': 'italic',
							'labelMsg': 'wikieditor-toolbar-tool-italic',
							'type': 'button',
							'offset': {
								'default': [2, -718],
								'en': [2, -862],
								'cs': [2, -862],
								'de': [2, -934],
								'fr': [2, -862],
								'es': [2, -790],
								'he': [2, -862],
								'it': [2, -790],
								'nl': [2, -790],
								'pt': [2, -862],
								'pt-br': [2, -862],
								'pl': [2, -862],
								'ru': [2, -934],
								'ml': [2, -862]
							},
							'icon': {
								'default': 'format-italic.png',
								'en': 'format-italic-I.png',
								'cs': 'format-italic-I.png',
								'de': 'format-italic-K.png',
								'fr': 'format-italic-I.png',
								'es': 'format-italic-C.png',
								'he': 'format-italic-I.png',
								'hu': 'format-italic-D.png',
								'it': 'format-italic-C.png',
								'ka': 'format-italic-ka.png',
								'nl': 'format-italic-C.png',
								'pt': 'format-italic-I.png',
								'pt-br': 'format-italic-I.png',
								'pl': 'format-italic-I.png',
								'ru': 'format-italic-K.png',
								'ml': 'format-italic-I.png'
							},
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "''",
									'periMsg': 'wikieditor-toolbar-tool-italic-example',
									'post': "''"
								}
							}
						}
					}
				},
				'insert': {
					'tools': {
						'xlink': {
							'labelMsg': 'wikieditor-toolbar-tool-xlink',
							'type': 'button',
							'icon': 'insert-xlink.png',
							'offset': [-70, 2],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "[",
									'periMsg': 'wikieditor-toolbar-tool-xlink-example',
									'post': "]"
								}
							}
						},
						'ilink': {
							'labelMsg': 'wikieditor-toolbar-tool-ilink',
							'type': 'button',
							'icon': 'insert-ilink.png',
							'offset': [2, -1582],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "[[",
									'periMsg': 'wikieditor-toolbar-tool-ilink-example',
									'post': "]]"
								}
							}
						},
						'file': {
							'labelMsg': 'wikieditor-toolbar-tool-file',
							'type': 'button',
							'icon': 'insert-file.png',
							'offset': [2, -1438],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': '[[' + fileNamespace + ':',
									'periMsg': 'wikieditor-toolbar-tool-file-example',
									'post': "]]"
								}
							}
						},
						'reference': {
							'labelMsg': 'wikieditor-toolbar-tool-reference',
							'filters': [ 'body.ns-subject' ],
							'type': 'button',
							'offset': [2, -1798],
							'icon': 'insert-reference.png',
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<ref>",
									'periMsg': 'wikieditor-toolbar-tool-reference-example',
									'post': "</ref>"
								}
							}
						},
						'signature': {
							'labelMsg': 'wikieditor-toolbar-tool-signature',
							'type': 'button',
							'offset': [2, -1872],
							'icon': 'insert-signature.png',
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "--~~~~"
								}
							}
						}
					}
				}
			}
		},
		// Format section
		'advanced': {
			'labelMsg': 'wikieditor-toolbar-section-advanced',
			'type': 'toolbar',
			'groups': {
				'heading': {
					'tools': {
						'heading': {
							'labelMsg': 'wikieditor-toolbar-tool-heading',
							'type': 'select',
							'list': {
								'heading-2' : {
									'labelMsg': 'wikieditor-toolbar-tool-heading-2',
									'action': {
										'type': 'encapsulate',
										'options': {
											'pre': '== ',
											'periMsg': 'wikieditor-toolbar-tool-heading-example',
											'post': ' ==',
											'regex': /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											'regexReplace': "$1==$3==$4",
											'ownline': true
										}
									}
								},
								'heading-3' : {
									'labelMsg': 'wikieditor-toolbar-tool-heading-3',
									'action': {
										'type': 'encapsulate',
										'options': {
											'pre': '=== ',
											'periMsg': 'wikieditor-toolbar-tool-heading-example',
											'post': ' ===',
											'regex': /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											'regexReplace': "$1===$3===$4",
											'ownline': true
										}
									}
								},
								'heading-4' : {
									'labelMsg': 'wikieditor-toolbar-tool-heading-4',
									'action': {
										'type': 'encapsulate',
										'options': {
											'pre': '==== ',
											'periMsg': 'wikieditor-toolbar-tool-heading-example',
											'post': ' ====',
											'regex': /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											'regexReplace': "$1====$3====$4",
											'ownline': true
										}
									}
								},
								'heading-5' : {
									'labelMsg': 'wikieditor-toolbar-tool-heading-5',
									'action': {
										'type': 'encapsulate',
										'options': {
											'pre': '===== ',
											'periMsg': 'wikieditor-toolbar-tool-heading-example',
											'post': ' =====',
											'regex': /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											'regexReplace': "$1=====$3=====$4",
											'ownline': true
										}
									}
								}
							}
						}
					}
				},
				'format': {
					'labelMsg': 'wikieditor-toolbar-group-format',
					'tools': {
						'ulist': {
							'labelMsg': 'wikieditor-toolbar-tool-ulist',
							'type': 'button',
							'icon': {
								'default': 'format-ulist.png',
								'default-rtl': 'format-ulist-rtl.png'
							},
							'offset': {
								'default': [2, -1366],
								'default-rtl': [-70, -286]
							},
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "* ",
									'periMsg': 'wikieditor-toolbar-tool-ulist-example',
									'post': "",
									'ownline': true,
									'splitlines': true
								}
							}
						},
						'olist': {
							'labelMsg': 'wikieditor-toolbar-tool-olist',
							'type': 'button',
							'icon': {
								'default': 'format-olist.png',
								'default-rtl': 'format-olist-rtl.png'
							},
							'offset': {
								'default': [2, -1078],
								'default-rtl': [-70, -358]
							},
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "# ",
									'periMsg': 'wikieditor-toolbar-tool-olist-example',
									'post': "",
									'ownline': true,
									'splitlines': true
								}
							}
						},
						'indent': {
							'labelMsg': 'wikieditor-toolbar-tool-indent',
							'type': 'button',
							'icon': {
								'default': 'format-indent.png',
								'default-rtl': 'format-indent-rtl.png'
							},
							'offset': {
								'default': [2, -646],
								'default-rtl': [-70, -430]
							},
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': ":",
									'periMsg': 'wikieditor-toolbar-tool-indent-example',
									'post': "",
									'ownline': true,
									'splitlines': true
								}
							}
						},
						'nowiki': {
							'labelMsg': 'wikieditor-toolbar-tool-nowiki',
							'type': 'button',
							'icon': 'insert-nowiki.png',
							'offset': [-70, -70],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<nowiki>",
									'periMsg': 'wikieditor-toolbar-tool-nowiki-example',
									'post': "</nowiki>"
								}
							}
						},
						'newline': {
							'labelMsg': 'wikieditor-toolbar-tool-newline',
							'type': 'button',
							'icon': 'insert-newline.png',
							'offset': [2, -1726],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<br />\n"
								}
							}
						}
					}
				},
				'size': {
					'tools': {
						'big': {
							'labelMsg': 'wikieditor-toolbar-tool-big',
							'type': 'button',
							'icon': 'format-big.png',
							'offset': [2, 2],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<big>",
									'periMsg': 'wikieditor-toolbar-tool-big-example',
									'post': "</big>"
								}
							}
						},
						'small': {
							'labelMsg': 'wikieditor-toolbar-tool-small',
							'type': 'button',
							'icon': 'format-small.png',
							'offset': [2, -1150],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<small>",
									'periMsg': 'wikieditor-toolbar-tool-small-example',
									'post': "</small>"
								}
							}
						},
						'superscript': {
							'labelMsg': 'wikieditor-toolbar-tool-superscript',
							'type': 'button',
							'icon': 'format-superscript.png',
							'offset': [2, -1294],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<sup>",
									'periMsg': 'wikieditor-toolbar-tool-superscript-example',
									'post': "</sup>"
								}
							}
						},
						'subscript': {
							'labelMsg': 'wikieditor-toolbar-tool-subscript',
							'type': 'button',
							'icon': 'format-subscript.png',
							'offset': [2, -1222],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<sub>",
									'periMsg': 'wikieditor-toolbar-tool-subscript-example',
									'post': "</sub>"
								}
							}
						}
					}
				},
				'insert': {
					'labelMsg': 'wikieditor-toolbar-group-insert',
					'tools': {
						'gallery': {
							'labelMsg': 'wikieditor-toolbar-tool-gallery',
							'type': 'button',
							'icon': 'insert-gallery.png',
							'offset': [2, -1510],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "<gallery>\n",
									'periMsg': [
										'wikieditor-toolbar-tool-gallery-example', fileNamespace
									],
									'post': "\n</gallery>",
									'ownline': true
								}
							}
						},
						'table': {
							'labelMsg': 'wikieditor-toolbar-tool-table',
							'type': 'button',
							'icon': 'insert-table.png',
							'offset': [2, -1942],
							'filters': [ '#wpTextbox1:not(.toolbar-dialogs)' ],
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "{| class=\"wikitable\" border=\"1\"\n|",
									'periMsg': 'wikieditor-toolbar-tool-table-example-old',
									'post': "\n|}",
									'ownline': true
								}
							}
						},
						'redirect': {
							'labelMsg': 'wikieditor-toolbar-tool-redirect',
							'type': 'button',
							'icon': {
								'default': 'insert-redirect.png',
								'default-rtl': 'insert-redirect-rtl.png'
							},
							'offset': {
								'default': [-70, -142],
								'default-rtl': [-70, -502]
							},
							'action': {
								'type': 'encapsulate',
								'options': {
									'pre': "#REDIRECT [[",
									'periMsg': 'wikieditor-toolbar-tool-redirect-example',
									'post': "]]",
									'ownline': true
								}
							}
						}
					}
				}
			}
		},
		'characters': {
			'labelMsg': 'wikieditor-toolbar-section-characters',
			'type': 'booklet',
			'deferLoad': true,
			'pages': {
				'latin': {
					'labelMsg': 'wikieditor-toolbar-characters-page-latin',
					'layout': 'characters',
					'characters': [
						"\u00c1", "\u00e1", "\u00c0", "\u00e0", "\u00c2", "\u00e2", "\u00c4", "\u00e4", "\u00c3",
						"\u00e3", "\u01cd", "\u01ce", "\u0100", "\u0101", "\u0102", "\u0103", "\u0104", "\u0105",
						"\u00c5", "\u00e5", "\u0106", "\u0107", "\u0108", "\u0109", "\u00c7", "\u00e7", "\u010c",
						"\u010d", "\u010a", "\u010b", "\u0110", "\u0111", "\u010e", "\u010f", "\u00c9", "\u00e9",
						"\u00c8", "\u00e8", "\u00ca", "\u00ea", "\u00cb", "\u00eb", "\u011a", "\u011b", "\u0112",
						"\u0113", "\u0114", "\u0115", "\u0116", "\u0117", "\u0118", "\u0119", "\u011c", "\u011d",
						"\u0122", "\u0123", "\u011e", "\u011f", "\u0120", "\u0121", "\u0124", "\u0125", "\u0126",
						"\u0127", "\u00cd", "\u00ed", "\u00cc", "\u00ec", "\u00ce", "\u00ee", "\u00cf", "\u00ef",
						"\u0128", "\u0129", "\u01cf", "\u01d0", "\u012a", "\u012b", "\u012c", "\u012d", "\u0130",
						"\u0131", "\u012e", "\u012f", "\u0134", "\u0135", "\u0136", "\u0137", "\u0139", "\u013a",
						"\u013b", "\u013c", "\u013d", "\u013e", "\u0141", "\u0142", "\u0143", "\u0144", "\u00d1",
						"\u00f1", "\u0145", "\u0146", "\u0147", "\u0148", "\u00d3", "\u00f3", "\u00d2", "\u00f2",
						"\u00d4", "\u00f4", "\u00d6", "\u00f6", "\u00d5", "\u00f5", "\u01d1", "\u01d2", "\u014c",
						"\u014d", "\u014e", "\u014f", "\u01ea", "\u01eb", "\u0150", "\u0151", "\u0154", "\u0155",
						"\u0156", "\u0157", "\u0158", "\u0159", "\u015a", "\u015b", "\u015c", "\u015d", "\u015e",
						"\u015f", "\u0160", "\u0161", "\u0218", "\u0219", "\u021a", "\u021b", "\u0164", "\u0165",
						"\u00da", "\u00fa", "\u00d9", "\u00f9", "\u00db", "\u00fb", "\u00dc", "\u00fc", "\u0168",
						"\u0169", "\u016e", "\u016f", "\u01d3", "\u01d4", "\u016a", "\u016b", "\u01d6", "\u01d8",
						"\u01da", "\u01dc", "\u016c", "\u016d", "\u0172", "\u0173", "\u0170", "\u0171", "\u0174",
						"\u0175", "\u00dd", "\u00fd", "\u0176", "\u0177", "\u0178", "\u00ff", "\u0232", "\u0233",
						"\u0179", "\u017a", "\u017d", "\u017e", "\u017b", "\u017c", "\u00c6", "\u00e6", "\u01e2",
						"\u01e3", "\u00d8", "\u00f8", "\u0152", "\u0153", "\u00df", "\u00f0", "\u00de", "\u00fe",
						"\u018f", "\u0259"
					]
				},
				'latinextended': {
					'labelMsg': 'wikieditor-toolbar-characters-page-latinextended',
					'layout': 'characters',
					'characters': [
						"\u1e00", "\u1e01", "\u1e9a", "\u1ea0", "\u1ea1", "\u1ea2", "\u1ea3", "\u1ea4", "\u1ea5",
						"\u1ea6", "\u1ea7", "\u1ea8", "\u1ea9", "\u1eaa", "\u1eab", "\u1eac", "\u1ead", "\u1eae",
						"\u1eaf", "\u1eb0", "\u1eb1", "\u1eb2", "\u1eb3", "\u1eb4", "\u1eb5", "\u1eb6", "\u1eb7",
						"\u1e02", "\u1e03", "\u1e04", "\u1e05", "\u1e06", "\u1e07", "\u1e08", "\u1e09", "\u1e0a",
						"\u1e0b", "\u1e0c", "\u1e0d", "\u1e0e", "\u1e0f", "\u1e10", "\u1e11", "\u1e12", "\u1e13",
						"\u1e14", "\u1e15", "\u1e16", "\u1e17", "\u1e18", "\u1e19", "\u1e1a", "\u1e1b", "\u1e1c",
						"\u1e1d", "\u1eb8", "\u1eb9", "\u1eba", "\u1ebb", "\u1ebc", "\u1ebd", "\u1ebe", "\u1ebf",
						"\u1ec0", "\u1ec1", "\u1ec2", "\u1ec3", "\u1ec4", "\u1ec5", "\u1ec6", "\u1ec7", "\u1e1e",
						"\u1e1f", "\u1e20", "\u1e21", "\u1e22", "\u1e23", "\u1e24", "\u1e25", "\u1e26", "\u1e27",
						"\u1e28", "\u1e29", "\u1e2a", "\u1e2b", "\u1e96", "\u1e2c", "\u1e2d", "\u1e2e", "\u1e2f",
						"\u1ec8", "\u1ec9", "\u1eca", "\u1ecb", "\u1e30", "\u1e31", "\u1e32", "\u1e33", "\u1e34",
						"\u1e35", "\u1e36", "\u1e37", "\u1e38", "\u1e39", "\u1e3a", "\u1e3b", "\u1e3c", "\u1e3d",
						"\u1efa", "\u1efb", "\u1e3e", "\u1e3f", "\u1e40", "\u1e41", "\u1e42", "\u1e43", "\u1e44",
						"\u1e45", "\u1e46", "\u1e47", "\u1e48", "\u1e49", "\u1e4a", "\u1e4b", "\u1e4c", "\u1e4d",
						"\u1e4e", "\u1e4f", "\u1e50", "\u1e51", "\u1e52", "\u1e53", "\u1ecc", "\u1ecd", "\u1ece",
						"\u1ecf", "\u1ed0", "\u1ed1", "\u1ed2", "\u1ed3", "\u1ed4", "\u1ed5", "\u1ed6", "\u1ed7",
						"\u1ed8", "\u1ed9", "\u1eda", "\u1edb", "\u1edc", "\u1edd", "\u1ede", "\u1edf", "\u1ee0",
						"\u1ee1", "\u1ee2", "\u1ee3", "\u1e54", "\u1e55", "\u1e56", "\u1e57", "\u1e58", "\u1e59",
						"\u1e5a", "\u1e5b", "\u1e5c", "\u1e5d", "\u1e5e", "\u1e5f", "\u1e60", "\u1e61", "\u1e9b",
						"\u1e62", "\u1e63", "\u1e64", "\u1e65", "\u1e66", "\u1e67", "\u1e68", "\u1e69", "\u1e9c",
						"\u1e9d", "\u1e6a", "\u1e6b", "\u1e6c", "\u1e6d", "\u1e6e", "\u1e6f", "\u1e70", "\u1e71",
						"\u1e97", "\u1e72", "\u1e73", "\u1e74", "\u1e75", "\u1e76", "\u1e77", "\u1e78", "\u1e79",
						"\u1e7a", "\u1e7b", "\u1ee4", "\u1ee5", "\u1ee6", "\u1ee7", "\u1ee8", "\u1ee9", "\u1eea",
						"\u1eeb", "\u1eec", "\u1eed", "\u1eee", "\u1eef", "\u1ef0", "\u1ef1", "\u1e7c", "\u1e7d",
						"\u1e7e", "\u1e7f", "\u1efc", "\u1efd", "\u1e80", "\u1e81", "\u1e82", "\u1e83", "\u1e84",
						"\u1e85", "\u1e86", "\u1e87", "\u1e88", "\u1e89", "\u1e98", "\u1e8a", "\u1e8b", "\u1e8c",
						"\u1e8d", "\u1e8e", "\u1e8f", "\u1e99", "\u1ef2", "\u1ef3", "\u1ef4", "\u1ef5", "\u1ef6",
						"\u1ef7", "\u1ef8", "\u1ef9", "\u1efe", "\u1eff", "\u1e90", "\u1e91", "\u1e92", "\u1e93",
						"\u1e94", "\u1e95", "\u1e9e", "\u1e9f"
					]
				},
				'ipa': {
					'labelMsg': 'wikieditor-toolbar-characters-page-ipa',
					'layout': 'characters',
					'characters': [
						"p", "t\u032a", "t", "\u0288", "c", "k", "q", "\u02a1", "\u0294", "b","d\u032a", "d", "\u0256",
						"\u025f", "\u0261", "\u0262", "\u0253", "\u0257", "\u0284", "\u0260", "\u029b", "t\u0361s",
						"t\u0361\u0283", "t\u0361\u0255", "d\u0361z", "d\u0361\u0292", "d\u0361\u0291", "\u0278", "f",
						"\u03b8", "s", "\u0283", "\u0285", "\u0286", "\u0282", "\u0255", "\u00e7", "\u0267", "x",
						"\u03c7", "\u0127", "\u029c", "h", "\u03b2", "v", "\u028d", "\u00f0", "z", "\u0292", "\u0293",
						"\u0290", "\u0291", "\u029d", "\u0263", "\u0281", "\u0295", "\u0296", "\u02a2", "\u0266",
						"\u026c", "\u026e", "m", "m\u0329", "\u0271", "\u0271\u0329", "\u0271\u030d", "n\u032a",
						"n\u032a\u030d", "n", "n\u0329", "\u0273", "\u0273\u0329", "\u0272", "\u0272\u0329", "\u014b",
						"\u014b\u030d", "\u014b\u0329", "\u0274", "\u0274\u0329", "\u0299", "\u0299\u0329", "r",
						"r\u0329", "\u0280", "\u0280\u0329", "\u027e", "\u027d", "\u027f", "\u027a", "l\u032a",
						"l\u032a\u0329", "l", "l\u0329", "\u026b", "\u026b\u0329", "\u026d", "\u026d\u0329", "\u028e",
						"\u028e\u0329", "\u029f", "\u029f\u0329", "w", "\u0265", "\u028b", "\u0279", "\u027b", "j",
						"\u0270", "\u0298", "\u01c2", "\u01c0", "!", "\u01c1", "\u02b0", "\u02b1", "\u02b7", "\u02b8",
						"\u02b2", "\u02b3", "\u207f", "\u02e1", "\u02b4", "\u02b5", "\u02e2", "\u02e3", "\u02e0",
						"\u02b6", "\u02e4", "\u02c1", "\u02c0", "\u02bc", "i", "i\u032f", "\u0129", "y", "y\u032f",
						"\u1ef9", "\u026a", "\u026a\u032f", "\u026a\u0303", "\u028f", "\u028f\u032f", "\u028f\u0303",
						"\u0268", "\u0268\u032f", "\u0268\u0303", "\u0289", "\u0289\u032f", "\u0289\u0303", "\u026f",
						"\u026f\u032f", "\u026f\u0303", "u", "u\u032f", "\u0169", "\u028a", "\u028a\u032f",
						"\u028a\u0303", "e", "e\u032f", "\u1ebd", "\u00f8", "\u00f8\u032f", "\u00f8\u0303", "\u0258",
						"\u0258\u032f", "\u0258\u0303", "\u0275", "\u0275\u032f", "\u0275\u0303", "\u0264",
						"\u0264\u032f", "\u0264\u0303", "o", "o\u032f", "\u00f5", "\u025b", "\u025b\u032f",
						"\u025b\u0303", "\u0153", "\u0153\u032f", "\u0153\u0303", "\u025c", "\u025c\u032f",
						"\u025c\u0303", "\u0259", "\u0259\u032f", "\u0259\u0303", "\u025e", "\u025e\u032f",
						"\u025e\u0303", "\u028c", "\u028c\u032f", "\u028c\u0303", "\u0254", "\u0254\u032f",
						"\u0254\u0303", "\u00e6", "\u00e6\u032f", "\u00e6\u0303", "\u0276", "\u0276\u032f",
						"\u0276\u0303", "a", "a\u032f", "\u00e3", "\u0250", "\u0250\u032f", "\u0250\u0303", "\u0251",
						"\u0251\u032f", "\u0251\u0303", "\u0252", "\u0252\u032f", "\u0252\u0303", "\u02c8", "\u02cc",
						"\u02d0", "\u02d1", "\u02d8", ".", "\u203f", "|", "\u2016"
					]
				},
				'symbols': {
					'labelMsg': 'wikieditor-toolbar-characters-page-symbols',
					'layout': 'characters',
					'characters': [
						"~", "|", "\u00a1", "\u00bf", "\u2020", "\u2021", "\u2194", "\u2191", "\u2193", "\u2022",
						"\u00b6", "#", "\u00bd", "\u2153", "\u2154", "\u00bc", "\u00be", "\u215b", "\u215c", "\u215d",
						"\u215e", "\u221e", "\u2018", "\u2019",
						{
							'label': "\u201c\u201d",
							'action': {
								'type': 'encapsulate', 'options': { 'pre': "\u201c", 'post': "\u201d" }
							}
						},
						{
							'label': "\u201e\u201c",
							'action': {
								'type': 'encapsulate', 'options': { 'pre': "\u201e", 'post': "\u201c" }
							}
						},
						{
							'label': "\u201e\u201d",
							'action': {
								'type': 'encapsulate', 'options': { 'pre': "\u201e", 'post': "\u201d" }
							}
						},
						{
							'label': "\u00ab\u00bb",
							'action': {
								'type': 'encapsulate', 'options': { 'pre': "\u00ab", 'post': "\u00bb" }
							}
						},
						"\u00a4", "\u20b3", "\u0e3f", "\u20b5", "\u00a2", "\u20a1", "\u20a2", "$", "\u20ab", "\u20af",
						"\u20ac", "\u20a0", "\u20a3", "\u0192", "\u20b4", "\u20ad", "\u20a4", "\u2133", "\u20a5",
						"\u20a6", "\u2116", "\u20a7", "\u20b0", "\u00a3", "\u17db", "\u20a8", "\u20aa", "\u09f3",
						"\u20ae", "\u20a9", "\u00a5", "\u2660", "\u2663", "\u2665", "\u2666", "m\u00b2", "m\u00b3",
						"\u2013", "\u2014", "\u2026", "\u2018", "\u2019", "\u201c", "\u201d", "\u00b0", "\u2032",
						"\u2033", "\u2248", "\u2260", "\u2264", "\u2265", "\u00b1", "\u2212", "\u00d7", "\u00f7",
						"\u2190", "\u2192", "\u00b7", "\u00a7"
					]
				},
				'greek': {
					'labelMsg': 'wikieditor-toolbar-characters-page-greek',
					'layout': 'characters',
					'language': 'hl',
					'characters': [
						"\u0391", "\u0386", "\u03b1", "\u03ac", "\u0392", "\u03b2", "\u0393", "\u03b3", "\u0394",
						"\u03b4", "\u0395", "\u0388", "\u03b5", "\u03ad", "\u0396", "\u03b6", "\u0397", "\u0389",
						"\u03b7", "\u03ae", "\u0398", "\u03b8", "\u0399", "\u038a", "\u03b9", "\u03af", "\u039a",
						"\u03ba", "\u039b", "\u03bb", "\u039c", "\u03bc", "\u039d", "\u03bd", "\u039e", "\u03be",
						"\u039f", "\u038c", "\u03bf", "\u03cc", "\u03a0", "\u03c0", "\u03a1", "\u03c1", "\u03a3",
						"\u03c3", "\u03c2", "\u03a4", "\u03c4", "\u03a5", "\u038e", "\u03c5", "\u03cd", "\u03a6",
						"\u03c6", "\u03a7", "\u03c7", "\u03a8", "\u03c8", "\u03a9", "\u038f", "\u03c9", "\u03ce"
					]
				},
				'cyrillic': {
					'labelMsg': 'wikieditor-toolbar-characters-page-cyrillic',
					'layout': 'characters',
					'characters': [
						"\u0410", "\u0430", "\u04d8", "\u04d9", "\u0411", "\u0431", "\u0412",  "\u0432", "\u0413",
						"\u0433", "\u0490", "\u0491", "\u0403", "\u0453", "\u0492", "\u0493", "\u0414", "\u0434",
						"\u0402", "\u0452", "\u0415", "\u0435", "\u0404", "\u0454", "\u0401", "\u0451", "\u0416",
						"\u0436", "\u0417", "\u0437", "\u0405", "\u0455", "\u0418", "\u0438", "\u0406", "\u0456",
						"\u0407", "\u0457", "\u04c0", "\u0419", "\u0439", "\u04e2", "\u04e3", "\u0408", "\u0458",
						"\u041a", "\u043a", "\u040c", "\u045c", "\u049a", "\u049b", "\u041b", "\u043b", "\u0409",
						"\u0459", "\u041c", "\u043c", "\u041d", "\u043d", "\u040a", "\u045a", "\u04a2", "\u04a3",
						"\u041e", "\u043e", "\u04e8", "\u04e9", "\u041f", "\u043f", "\u0420", "\u0440", "\u0421",
						"\u0441", "\u0422", "\u0442", "\u040b", "\u045b", "\u0423", "\u0443", "\u040e", "\u045e",
						"\u04ee", "\u04ef", "\u04b0", "\u04b1", "\u04ae", "\u04af", "\u0424", "\u0444", "\u0425",
						"\u0445", "\u04b2", "\u04b3", "\u04ba", "\u04bb", "\u0426", "\u0446", "\u0427", "\u0447",
						"\u04b6", "\u04b7", "\u040f", "\u045f", "\u0428", "\u0448", "\u0429", "\u0449", "\u042a",
						"\u044a", "\u042b", "\u044b", "\u042c", "\u044c", "\u042d", "\u044d", "\u042e", "\u044e",
						"\u042f", "\u044f"
					]
				},
				// The core 28-letter alphabet, special letters for the Arabic language,
				// vowels, punctuation, digits.
				// Names of letters are written as in the Unicode charts.
				'arabic': {
					'labelMsg': 'wikieditor-toolbar-characters-page-arabic',
					'layout': 'characters',
					'language': 'ar',
					'direction': 'rtl',
					'characters': [
						// core alphabet
						"\u0627", "\u0628",	"\u062a", "\u062b", "\u062c", "\u062d", "\u062e", "\u062f",
						"\u0630", "\u0631", "\u0632", "\u0633", "\u0634", "\u0635", "\u0636", "\u0637",
						"\u0638", "\u0639", "\u063a", "\u0641", "\u0642", "\u0643", "\u0644", "\u0645",
						"\u0646", "\u0647", "\u0648", "\u064a",
						// special letters for the Arabic language
						"\u0621", // Hamza
						"\u0622", "\u0623", "\u0625", "\u0671", // Alef
						"\u0624", // Waw hamza
						"\u0626", // Yeh hamza
						"\u0649", // Alef maksura
						"\u0629", // Teh marbuta
						// vowels
						"\u064E", "\u064F", "\u0650", "\u064B", "\u064C", "\u064D", "\u0651", "\u0652",
						"\u0670",
						// punctuation
						"\u060c", "\u061b", "\u061f", "\u0640",
						// digits
						"\u0660", "\u0661", "\u0662", "\u0663", "\u0664", "\u0665", "\u0666", "\u0667",
						"\u0668", "\u0669",
						// other special characters
						"\u066A", "\u066B", "\u066C", "\u066D",
						// ZWNJ and ZWJ
						[ "ZWNJ", "\u200C" ], [ "ZWJ", "\u200D" ]
					]
				},
				// Characters for languages other than Arabic.
				'arabicextended': {
					'labelMsg': 'wikieditor-toolbar-characters-page-arabicextended',
					'layout': 'characters',
					'language': 'ar',
					'direction': 'rtl',
					'characters': [
						// Alef
						"\u0672", "\u0673", "\u0674", "\u0675", "\u0773", "\u0774",
						// Beh
						"\u066E", "\u067B", "\u067E", "\u0680", "\u0750", "\u0751", "\u0752", "\u0753",
						"\u0754", "\u0755", "\u0756",
						// Teh
						"\u0679", "\u067A", "\u067C", "\u067D", "\u067F",
						// Jeem
						"\u0681", "\u0682", "\u0683", "\u0684", "\u0685", "\u0686", "\u0687", "\u06BF",
						// Hah
						"\u0757", "\u0758", "\u076E", "\u076F", "\u0772", "\u077C",
						// Dal
						"\u0688", "\u0689", "\u068A", "\u068B", "\u068C", "\u068D", "\u068E", "\u068F",
						"\u0690", "\u06EE", "\u0759", "\u075A",
						// Reh
						"\u0691", "\u0692", "\u0693", "\u0694", "\u0695", "\u0696", "\u0697", "\u0698",
						"\u0699", "\u06EF", "\u075B", "\u076B", "\u076C", "\u0771",
						// Seen
						"\u069A", "\u069B", "\u069C", "\u077D",
						// Sheen
						"\u06FA", "\u075C", "\u076D", "\u0770", "\u077E",
						// Sad
						"\u069D", "\u069E",
						// Dad
						"\u06FB",
						// Tah
						"\u069F",
						// Ain
						"\u06A0", "\u075D", "\u075E", "\u075F",
						// Ghain
						"\u06FC",
						// Feh
						"\u06A1", "\u06A2", "\u06A3", "\u06A4", "\u06A5", "\u06A6", "\u0760", "\u0761",
						// Qaf
						"\u066F", "\u06A7", "\u06A8",
						// Kaf
						"\u063B", "\u063C", "\u06A9", "\u06AA", "\u06AB", "\u06AC", "\u06AD", "\u06AE",
						"\u06AF", "\u06B0", "\u06B1", "\u06B2", "\u06B3", "\u06B4", "\u0762", "\u0763",
						"\u0764", "\u077F",
						// Lam
						"\u06B5", "\u06B6", "\u06B7", "\u06B8", "\u076A",
						// Meem
						"\u0765", "\u0766",
						// Noon
						"\u06B9", "\u06BA", "\u06BB", "\u06BC", "\u06BD", "\u0767", "\u0768", "\u0769",
						// Heh
						"\u06BE", "\u06C0", "\u06C1", "\u06C2", "\u06C3", "\u06D5", "\u06FF",
						// Waw
						"\u0676", "\u0677", "\u06C4", "\u06C5", "\u06C6", "\u06C7", "\u06C8", "\u06C9",
						"\u06CA", "\u06CB", "\u06CF", "\u0778", "\u0779",
						// Yeh
						"\u0620", "\u063D", "\u063E", "\u063F", "\u0678", "\u06CC", "\u06CD", "\u06CE",
						"\u06D0", "\u06D1", "\u06D2", "\u06D3", "\u0775", "\u0776", "\u0777", "\u077A",
						"\u077B",
						// diacritics
						"\u0656", "\u0657", "\u0658", "\u0659", "\u065A", "\u065B", "\u065C", "\u065D",
						"\u065E", "\u065F",
						// special punctuation
						"\u06D4", "\u06FD", "\u06FE",
						// special digits
						"\u06F0", "\u06F1", "\u06F2", "\u06F3", "\u06F4", "\u06F5", "\u06F6", "\u06F7",
						"\u06F8", "\u06F9"
					]
				},
				'hebrew': {
					'labelMsg': 'wikieditor-toolbar-characters-page-hebrew',
					'layout': 'characters',
					'direction': 'rtl',
					'characters': [
						// Letters
						"\u05d0", "\u05d1", "\u05d2", "\u05d3", "\u05d4", "\u05d5", "\u05d6", "\u05d7", "\u05d8",
						"\u05d9", "\u05db", "\u05da", "\u05dc", "\u05de", "\u05dd", "\u05e0", "\u05df", "\u05e1",
						"\u05e2", "\u05e4", "\u05e3", "\u05e6", "\u05e5", "\u05e7", "\u05e8", "\u05e9", "\u05ea",

						// Yiddish
						"\u05f0", "\u05f1", "\u05f2",

						// Punctuation
						"\u05f3", "\u05f4", "\u05be", "\u2013",
						{
							'label': "\u201e\u201d",
							'action': {
								'type': 'encapsulate', 'options': { 'pre': "\u201e", 'post': "\u201d" }
							}
						},
						{
							'label': "\u201a\u2019",
							'action': {
								'type': 'encapsulate', 'options': { 'pre': "\u201a", 'post': "\u2019" }
							}
						},

						// Vowels
						[ "\u25cc\u05b0", "\u05b0" ], [ "\u25cc\u05b1", "\u05b1" ], [ "\u25cc\u05b2", "\u05b2" ],
						[ "\u25cc\u05b3", "\u05b3" ], [ "\u25cc\u05b4", "\u05b4" ], [ "\u25cc\u05b5", "\u05b5" ],
						[ "\u25cc\u05b6", "\u05b6" ], [ "\u25cc\u05b7", "\u05b7" ], [ "\u25cc\u05b8", "\u05b8" ],
						[ "\u25cc\u05b9", "\u05b9" ], [ "\u25cc\u05bb", "\u05bb" ], [ "\u25cc\u05bc", "\u05bc" ],
						[ "\u25cc\u05c1", "\u05c1" ], [ "\u25cc\u05c2", "\u05c2" ], [ "\u25cc\u05c7", "\u05c7" ],

						// Cantillation
						[ "\u25cc\u0591", "\u0591" ], [ "\u25cc\u0592", "\u0592" ], [ "\u25cc\u0593", "\u0593" ],
						[ "\u25cc\u0594", "\u0594" ], [ "\u25cc\u0595", "\u0595" ], [ "\u25cc\u0596", "\u0596" ],
						[ "\u25cc\u0597", "\u0597" ], [ "\u25cc\u0598", "\u0598" ], [ "\u25cc\u0599", "\u0599" ],
						[ "\u25cc\u059a", "\u059a" ], [ "\u25cc\u059b", "\u059b" ], [ "\u25cc\u059c", "\u059c" ],
						[ "\u25cc\u059d", "\u059d" ], [ "\u25cc\u059e", "\u059e" ], [ "\u25cc\u059f", "\u059f" ],
						[ "\u25cc\u05a0", "\u05a0" ], [ "\u25cc\u05a1", "\u05a1" ], [ "\u25cc\u05a2", "\u05a2" ],
						[ "\u25cc\u05a3", "\u05a3" ], [ "\u25cc\u05a4", "\u05a4" ], [ "\u25cc\u05a5", "\u05a5" ],
						[ "\u25cc\u05a6", "\u05a6" ], [ "\u25cc\u05a7", "\u05a7" ], [ "\u25cc\u05a8", "\u05a8" ],
						[ "\u25cc\u05a9", "\u05a9" ], [ "\u25cc\u05aa", "\u05aa" ], [ "\u25cc\u05ab", "\u05ab" ],
						[ "\u25cc\u05ac", "\u05ac" ], [ "\u25cc\u05ad", "\u05ad" ], [ "\u25cc\u05ae", "\u05ae" ],
						[ "\u25cc\u05af", "\u05af" ], [ "\u25cc\u05bf", "\u05bf" ], [ "\u25cc\u05c0", "\u05c0" ],
						[ "\u25cc\u05c3", "\u05c3" ]
					]
				},
				'bangla': {
					'labelMsg': 'wikieditor-toolbar-characters-page-bangla',
					'language': 'bn',
					'layout': 'characters',
					'characters': [
						"\u0985", "\u0986", "\u0987", "\u0988", "\u0989", "\u098a", "\u098b", "\u098f", "\u0990",
						"\u0993", "\u0994", "\u09be", "\u09bf", "\u09c0", "\u09c1", "\u09c2", "\u09c3", "\u09c7",
						"\u09c8", "\u09cb", "\u09cc", "\u0995", "\u0996", "\u0997", "\u0998", "\u0999", "\u099a",
						"\u099b", "\u099c", "\u099d", "\u099e", "\u099f", "\u09a0", "\u09a1", "\u09a2", "\u09a3",
						"\u09a4", "\u09a5", "\u09a6", "\u09a7", "\u09a8", "\u09aa", "\u09ab", "\u09ac", "\u09ad",
						"\u09ae", "\u09af", "\u09b0", "\u09b2", "\u09b6", "\u09b7", "\u09b8", "\u09b9", "\u09a1\u09bc",
						"\u09a2\u09bc", "\u09af\u09bc", "\u09ce", "\u0982", "\u0983", "\u0981", "\u09cd", "\u09e7",
						"\u09e8", "\u09e9", "\u09ea", "\u09eb", "\u09ec", "\u09ed", "\u09ee", "\u09ef", "\u09e6"
					]
				},
				'tamil': {
					'labelMsg': 'wikieditor-toolbar-characters-page-tamil',
					'language': 'ta',
					'layout': 'characters',
					'characters': [
						"\u0be6", "\u0be7", "\u0be8", "\u0be9", "\u0bea", "\u0beb", "\u0bec", "\u0bed", "\u0bee",
						"\u0bef", "\u0bf0", "\u0bf1", "\u0bf2", "\u0bf3", "\u0bf4", "\u0bf5", "\u0bf6", "\u0bf7",
						"\u0bf8", "\u0bf9", "\u0bfa", "\u0bd0"
					]
				},
				'telugu': {
					'labelMsg': 'wikieditor-toolbar-characters-page-telugu',
					'language': 'te',
					'layout': 'characters',
					'characters': [
						"\u0c01", "\u0c02", "\u0c03", "\u0c05", "\u0c06", "\u0c07", "\u0c08", "\u0c09", "\u0c0a",
						"\u0c0b", "\u0c60", "\u0c0c", "\u0c61", "\u0c0e", "\u0c0f", "\u0c10", "\u0c12", "\u0c13",
						"\u0c14", "\u0c15", "\u0c16", "\u0c17", "\u0c18", "\u0c19", "\u0c1a", "\u0c1b", "\u0c1c",
						"\u0c1d", "\u0c1e", "\u0c1f", "\u0c20", "\u0c21", "\u0c22", "\u0c23", "\u0c24", "\u0c25",
						"\u0c26", "\u0c27", "\u0c28", "\u0c2a", "\u0c2b", "\u0c2c", "\u0c2d", "\u0c2e", "\u0c2f",
						"\u0c30", "\u0c31", "\u0c32", "\u0c33", "\u0c35", "\u0c36", "\u0c37", "\u0c38", "\u0c39",
						"\u0c3e", "\u0c3f", "\u0c40", "\u0c41", "\u0c42", "\u0c43", "\u0c44", "\u0c46", "\u0c47",
						"\u0c48", "\u0c4a", "\u0c4b", "\u0c4c", "\u0c4d", "\u0c62", "\u0c63", "\u0c58", "\u0c59",
						"\u0c66", "\u0c67", "\u0c68", "\u0c69", "\u0c6a", "\u0c6b", "\u0c6c", "\u0c6d", "\u0c6e",
						"\u0c6f", "\u0c3d", "\u0c78", "\u0c79", "\u0c7a", "\u0c7b", "\u0c7c", "\u0c7d", "\u0c7e",
						"\u0c7f"
					]
				},
				'sinhala': {
					'labelMsg': 'wikieditor-toolbar-characters-page-sinhala',
					'language': 'si',
					'layout': 'characters',
					'characters': [
						"\u0d85", "\u0d86", "\u0d87", "\u0d88", "\u0d89", "\u0d8a", "\u0d8b", "\u0d8c", "\u0d8d",
						"\u0d8e", "\u0d8f", "\u0d90", "\u0d91", "\u0d92", "\u0d93", "\u0d94", "\u0d95", "\u0d96",
						"\u0d9a", "\u0d9b", "\u0d9c", "\u0d9d", "\u0d9e", "\u0d9f", "\u0da0", "\u0da1", "\u0da2",
						"\u0da3", "\u0da4", "\u0da5", "\u0da6", "\u0da7", "\u0da8", "\u0da9", "\u0daa", "\u0dab",
						"\u0dac", "\u0dad", "\u0dae", "\u0daf", "\u0db0", "\u0db1", "\u0db3", "\u0db4", "\u0db5",
						"\u0db6", "\u0db7", "\u0db8", "\u0db9", "\u0dba", "\u0dbb", "\u0dbd", "\u0dc0", "\u0dc1",
						"\u0dc2", "\u0dc3", "\u0dc4", "\u0dc5", "\u0dc6",
						[ "\u25cc\u0dcf", "\u0dcf" ], [ "\u25cc\u0dd0", "\u0dd0" ], [ "\u25cc\u0dd1", "\u0dd1" ],
						[ "\u25cc\u0dd2", "\u0dd2" ], [ "\u25cc\u0dd3", "\u0dd3" ], [ "\u25cc\u0dd4", "\u0dd4" ],
						[ "\u25cc\u0dd6", "\u0dd6" ], [ "\u25cc\u0dd8", "\u0dd8" ], [ "\u25cc\u0df2", "\u0df2" ],
						[ "\u25cc\u0ddf", "\u0ddf" ], [ "\u25cc\u0df3", "\u0df3" ], [ "\u25cc\u0dd9", "\u0dd9" ],
						[ "\u25cc\u0dda", "\u0dda" ], [ "\u25cc\u0ddc", "\u0ddc" ], [ "\u25cc\u0ddd", "\u0ddd" ],
						[ "\u25cc\u0dde", "\u0dde" ], [ "\u25cc\u0dca", "\u0dca" ]
					]
				},
				'gujarati': {
					'labelMsg': 'wikieditor-toolbar-characters-page-gujarati',
					'language': 'gu',
					'layout': 'characters',
					'characters': [
						"\u0ad0", // Om
						"\u0a81", // Candrabindu
						"\u0a82", // Anusvara
						"\u0a83", // Visarga
						// Vowels
						"\u0a85", "\u0a86", // A
						"\u0a87", "\u0a88", // I
						"\u0a89", "\u0a8a", // U
						"\u0a8f", "\u0a90", // E
						"\u0a93", "\u0a94", // O
						"\u0a85\u0a82", // A with Anusvara
						"\u0a8b", // Vocalic R
						"\u0a8d", "\u0a91", // Candra E and O
						// Special vowels
						"\u0a8c", // Vocalic L
						"\u0ae0", // Vocalic RR
						"\u0ae1", // Vocalic LL
						// Consonants
						"\u0a95", "\u0a96", "\u0a97", "\u0a98", "\u0a99",
						"\u0a9a", "\u0a9b", "\u0a9c", "\u0a9d", "\u0a9e",
						"\u0a9f", "\u0aa0", "\u0aa1", "\u0aa2", "\u0aa3",
						"\u0aa4", "\u0aa5", "\u0aa6", "\u0aa7", "\u0aa8",
						"\u0aaa", "\u0aab", "\u0aac", "\u0aad", "\u0aae",
						"\u0aaf", "\u0ab0", "\u0ab2", "\u0ab3",
						"\u0ab5", "\u0ab6", "\u0ab7", "\u0ab8", "\u0ab9",
						"\u0a95\u0acd\u0ab7", // ksh
						"\u0a9c\u0acd\u0a9e", // jny
						"\u0abd", // Avagraha
						// Vowel signs
						"\u0abe", "\u0abf", "\u0ac0", "\u0ac0", "\u0ac1", "\u0ac2",
						"\u0ac3", "\u0ac4", "\u0ac5", "\u0ac7", "\u0ac8", "\u0ac9", "\u0acb", "\u0acc",
						"\u0ae2", "\u0ae3",
						// Virama
						"\u0acd",
						// Digits
						"\u0ae6", "\u0ae7", "\u0ae8", "\u0ae9", "\u0aea",
						"\u0aeb", "\u0aec", "\u0aed", "\u0aee", "\u0aef",
						// Rupee
						"\u0af1"
					]
				},
				'thai': {
					'labelMsg': 'wikieditor-toolbar-characters-page-thai',
					'language': 'th',
					'layout': 'characters',
					'characters': [
						"\u0e01", "\u0e02", "\u0e03", "\u0e04", "\u0e05", "\u0e06", "\u0e07", "\u0e08", "\u0e09",
						"\u0e0a", "\u0e0b", "\u0e0c", "\u0e0d", "\u0e0e", "\u0e0f", "\u0e10", "\u0e11", "\u0e12",
						"\u0e13", "\u0e14", "\u0e15", "\u0e16", "\u0e17", "\u0e18", "\u0e19", "\u0e1a", "\u0e1b",
						"\u0e1c", "\u0e1d", "\u0e1e", "\u0e1f", "\u0e20", "\u0e21", "\u0e22", "\u0e23", "\u0e24",
						"\u0e25", "\u0e26", "\u0e27", "\u0e28", "\u0e29", "\u0e2a", "\u0e2b", "\u0e2c", "\u0e2d",
						"\u0e2e", "\u0e30", "\u0e31", "\u0e32", "\u0e45", "\u0e33", "\u0e34", "\u0e35", "\u0e36",
						"\u0e37", "\u0e38", "\u0e39", "\u0e40", "\u0e41", "\u0e42", "\u0e43", "\u0e44", "\u0e47",
						"\u0e48", "\u0e49", "\u0e4a", "\u0e4b", "\u0e4c", "\u0e4d", "\u0e3a", "\u0e4e", "\u0e50",
						"\u0e51", "\u0e52", "\u0e53", "\u0e54", "\u0e55", "\u0e56", "\u0e57", "\u0e58", "\u0e59",
						"\u0e3f", "\u0e46", "\u0e2f", "\u0e5a", "\u0e4f", "\u0e5b"
					]
				},
				'lao': {
					'labelMsg': 'wikieditor-toolbar-characters-page-lao',
					'language': 'lo',
					'layout': 'characters',
					'characters': [
						"\u0e81", "\u0e82", "\u0e84", "\u0e87", "\u0e88", "\u0eaa", "\u0e8a", "\u0e8d", "\u0e94",
						"\u0e95", "\u0e96", "\u0e97", "\u0e99", "\u0e9a", "\u0e9b", "\u0e9c", "\u0e9d", "\u0e9e",
						"\u0e9f", "\u0ea1", "\u0ea2", "\u0ea5", "\u0ea7", "\u0eab", "\u0ead", "\u0eae", "\u0ea3",
						"\u0edc", "\u0edd", "\u0ebc", "\u0ebd", "\u0eb0", "\u0eb1", "\u0eb2", "\u0eb3", "\u0eb4",
						"\u0eb5", "\u0eb6", "\u0eb7", "\u0eb8", "\u0eb9", "\u0ebb", "\u0ec0", "\u0ec1", "\u0ec2",
						"\u0ec3", "\u0ec4", "\u0ec8", "\u0ec9", "\u0eca", "\u0ecb", "\u0ecc", "\u0ecd", "\u0ed0",
						"\u0ed1", "\u0ed2", "\u0ed3", "\u0ed4", "\u0ed5", "\u0ed6", "\u0ed7", "\u0ed8", "\u0ed9",
						"\u20ad", "\u0ec6", "\u0eaf"
					]
				},
				'khmer': {
					'labelMsg': 'wikieditor-toolbar-characters-page-khmer',
					'language': 'km',
					'layout': 'characters',
					'characters': [
						"\u1780", "\u1781", "\u1782", "\u1783", "\u1784", "\u1785", "\u1786", "\u1787", "\u1788",
						"\u1789", "\u178a", "\u178b", "\u178c", "\u178d", "\u178e", "\u178f", "\u1790", "\u1791",
						"\u1792", "\u1793", "\u1794", "\u1795", "\u1796", "\u1797", "\u1798", "\u1799", "\u179a",
						"\u179b", "\u179c", "\u179f", "\u17a0", "\u17a1", "\u17a2", "\u17a3", "\u17a4", "\u17a5",
						"\u17a6", "\u17a7", "\u17a8", "\u17a9", "\u17aa", "\u17ab", "\u17ac", "\u17ad", "\u17ae",
						"\u17af", "\u17b0", "\u17b1", "\u17b2", "\u17b3", "\u17d2", "\u17b4", "\u17b5", "\u17b6",
						"\u17b7", "\u17b8", "\u17b9", "\u17ba", "\u17bb", "\u17bc", "\u17bd", "\u17be", "\u17bf",
						"\u17c0", "\u17c1", "\u17c2", "\u17c3", "\u17c4", "\u17c5", "\u17c6", "\u17c7", "\u17c8",
						"\u17c9", "\u17ca", "\u17cb", "\u17cc", "\u17cd", "\u17ce", "\u17cf", "\u17d0", "\u17d1",
						"\u17d3", "\u17dd", "\u17dc", "\u17e0", "\u17e1", "\u17e2", "\u17e3", "\u17e4", "\u17e5",
						"\u17e6", "\u17e7", "\u17e8", "\u17e9", "\u17db", "\u17d4", "\u17d5", "\u17d6", "\u17d7",
						"\u17d8", "\u17d9", "\u17da", "\u17f0", "\u17f1", "\u17f2", "\u17f3", "\u17f4", "\u17f5",
						"\u17f6", "\u17f7", "\u17f8", "\u17f9", "\u19e0", "\u19e1", "\u19e2", "\u19e3", "\u19e4",
						"\u19e5", "\u19e6", "\u19e7", "\u19e8", "\u19e9", "\u19ea", "\u19eb", "\u19ec", "\u19ed",
						"\u19ee", "\u19ef", "\u19f0", "\u19f1", "\u19f2", "\u19f3", "\u19f4", "\u19f5", "\u19f6",
						"\u19f7", "\u19f8", "\u19f9", "\u19fa", "\u19fb", "\u19fc", "\u19fd", "\u19fe", "\u19ff"
					]
				}
			}
		},
		'help': {
			'labelMsg': 'wikieditor-toolbar-section-help',
			'type': 'booklet',
			'deferLoad': true,
			'pages': {
				'format': {
					'labelMsg': 'wikieditor-toolbar-help-page-format',
					'layout': 'table',
					'headings': [
						{ 'textMsg': 'wikieditor-toolbar-help-heading-description' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-syntax' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-result' }
					],
					'rows': [
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-italic-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-italic-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-italic-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-bold-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-bold-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-bold-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-bolditalic-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-bolditalic-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-bolditalic-result' }
						}
					]
				},
				'link': {
					'labelMsg': 'wikieditor-toolbar-help-page-link',
					'layout': 'table',
					'headings': [
						{ 'textMsg': 'wikieditor-toolbar-help-heading-description' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-syntax' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-result' }
					],
					'rows': [
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-ilink-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-ilink-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-ilink-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-xlink-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-xlink-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-xlink-result' }
						}
					]
				},
				'heading': {
					'labelMsg': 'wikieditor-toolbar-help-page-heading',
					'layout': 'table',
					'headings': [
						{ 'textMsg': 'wikieditor-toolbar-help-heading-description' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-syntax' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-result' }
					],
					'rows': [
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading2-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading2-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading2-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading3-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading3-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading3-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading4-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading4-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading4-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading5-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading5-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-heading5-result' }
						}
					]
				},
				'list': {
					'labelMsg': 'wikieditor-toolbar-help-page-list',
					'layout': 'table',
					'headings': [
						{ 'textMsg': 'wikieditor-toolbar-help-heading-description' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-syntax' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-result' }
					],
					'rows': [
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-ulist-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-ulist-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-ulist-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-olist-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-olist-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-olist-result' }
						}
					]
				},
				'file': {
					'labelMsg': 'wikieditor-toolbar-help-page-file',
					'layout': 'table',
					'headings': [
						{ 'textMsg': 'wikieditor-toolbar-help-heading-description' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-syntax' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-result' }
					],
					'rows': [
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-file-description' },
							'syntax': { 'htmlMsg': [ 'wikieditor-toolbar-help-content-file-syntax', fileNamespace ] },
							'result': { 'htmlMsg': [ 'wikieditor-toolbar-help-content-file-result', mw.config.get( 'stylepath' ) ] }
						}
					]
				},
				'reference': {
					'labelMsg': 'wikieditor-toolbar-help-page-reference',
					'layout': 'table',
					'headings': [
						{ 'textMsg': 'wikieditor-toolbar-help-heading-description' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-syntax' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-result' }
					],
					'rows': [
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-reference-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-reference-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-reference-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-rereference-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-rereference-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-rereference-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-showreferences-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-showreferences-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-showreferences-result' }
						}
					]
				},
				'discussion': {
					'labelMsg': 'wikieditor-toolbar-help-page-discussion',
					'layout': 'table',
					'headings': [
						{ 'textMsg': 'wikieditor-toolbar-help-heading-description' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-syntax' },
						{ 'textMsg': 'wikieditor-toolbar-help-heading-result' }
					],
					'rows': [
						{
							'description': {
								'htmlMsg': 'wikieditor-toolbar-help-content-signaturetimestamp-description'
							},
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-signaturetimestamp-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-signaturetimestamp-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-signature-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-signature-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-signature-result' }
						},
						{
							'description': { 'htmlMsg': 'wikieditor-toolbar-help-content-indent-description' },
							'syntax': { 'htmlMsg': 'wikieditor-toolbar-help-content-indent-syntax' },
							'result': { 'htmlMsg': 'wikieditor-toolbar-help-content-indent-result' }
						}
					]
				}
			}
		}
	} };
}

}; } ) ( jQuery );
