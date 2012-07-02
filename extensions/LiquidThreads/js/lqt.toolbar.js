/* JavaScript config for the WikiEditor Toolbar module */

liquidThreads.toolbar = {
	'config': {
		// Main section
		'main': {
			type: 'toolbar',
			groups: {
				'format': {
					tools: {
						'bold': {
							labelMsg: 'wikieditor-toolbar-tool-bold',
							type: 'button',
							offset: {
								'default': [2, -574],
								'en': [2, -142],
								'cs': [2, -142],
								'de': [2, -214],
								'fr': [2, -286],
								'es': [2, -358],
								'he': [2, -142],
								'it': [2, -286],
								'nl': [2, -502],
								'pt': [2, -358],
								'pt-br': [2, -358],
								'pl': [2, -142]
							},
							icon: {
								'default': 'format-bold.png',
								'en': 'format-bold-B.png',
								'cs': 'format-bold-B.png',
								'de': 'format-bold-F.png',
								'fr': 'format-bold-G.png',
								'es': 'format-bold-N.png',
								'he': 'format-bold-B.png',
								'it': 'format-bold-G.png',
								'ka': 'format-bold-ka.png',
								'nl': 'format-bold-V.png',
								'pt': 'format-bold-N.png',
								'pt-br': 'format-bold-N.png',
								'pl': 'format-bold-B.png',
								'ru': 'format-bold-ru.png'
							},
							action: {
								type: 'encapsulate',
								options: {
									pre: "'''",
									periMsg: 'wikieditor-toolbar-tool-bold-example',
									post: "'''"
								}
							}
						},
						'italic': {
							section: 'main',
							group: 'format',
							id: 'italic',
							labelMsg: 'wikieditor-toolbar-tool-italic',
							type: 'button',
							offset: {
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
								'ru': [2, -934]
							},
							icon: {
								'default': 'format-italic.png',
								'en': 'format-italic-I.png',
								'cs': 'format-italic-I.png',
								'de': 'format-italic-K.png',
								'fr': 'format-italic-I.png',
								'es': 'format-italic-C.png',
								'he': 'format-italic-I.png',
								'it': 'format-italic-C.png',
								'ka': 'format-italic-ka.png',
								'nl': 'format-italic-C.png',
								'pt': 'format-italic-I.png',
								'pt-br': 'format-italic-I.png',
								'pl': 'format-italic-I.png',
								'ru': 'format-italic-K.png'
							},
							action: {
								type: 'encapsulate',
								options: {
									pre: "''",
									periMsg: 'wikieditor-toolbar-tool-italic-example',
									post: "''"
								}
							}
						}
					}
				},
				'insert': {
					tools: {
						'xlink': {
							labelMsg: 'wikieditor-toolbar-tool-xlink',
							type: 'button',
							icon: 'insert-xlink.png',
							offset: [-70, 2],
							filters: [ '#wpTextbox1:not(.toolbar-dialogs)' ],
							action: {
								type: 'encapsulate',
								options: {
									pre: "[",
									periMsg: 'wikieditor-toolbar-tool-xlink-example',
									post: "]"
								}
							}
						},
						'ilink': {
							labelMsg: 'wikieditor-toolbar-tool-ilink',
							type: 'button',
							icon: 'insert-ilink.png',
							offset: [2, -1582],
							filters: [ '#wpTextbox1:not(.toolbar-dialogs)' ],
							action: {
								type: 'encapsulate',
								options: {
									pre: "[[",
									periMsg: 'wikieditor-toolbar-tool-ilink-example',
									post: "]]"
								}
							}
						},
						'linkCGD': {
							labelMsg: 'wikieditor-toolbar-tool-link',
							type: 'button',
							icon: 'insert-link.png',
							offset: [2, -1654],
							filters: [ '#wpTextbox1.toolbar-dialogs' ],
							action: {
								type: 'dialog',
								module: 'insert-link'
							}
						},
						'file': {
							labelMsg: 'wikieditor-toolbar-tool-file',
							type: 'button',
							icon: 'insert-file.png',
							offset: [2, -1438],
							action: {
								type: 'encapsulate',
								options: {
									// FIXME: Why the hell was this done this way?
									preMsg: [ 'wikieditor-toolbar-tool-file-pre', '[[' ],
									periMsg: 'wikieditor-toolbar-tool-file-example',
									post: "]]"
								}
							}
						},
						'referenceCGD': {
							labelMsg: 'wikieditor-toolbar-tool-reference',
							type: 'button',
							icon: 'insert-reference.png',
							offset: [2, -1798],
							filters: [ 'body.ns-subject', '#wpTextbox1.toolbar-dialogs' ],
							action: {
								type: 'dialog',
								module: 'insert-reference'
							}
						},
						'reference': {
							labelMsg: 'wikieditor-toolbar-tool-reference',
							filters: [ 'body.ns-subject', '#wpTextbox1:not(.toolbar-dialogs)' ],
							type: 'button',
							offset: [2, -1798],
							icon: 'insert-reference.png',
							action: {
								type: 'encapsulate',
								options: {
									pre: "<ref>",
									periMsg: 'wikieditor-toolbar-tool-reference-example',
									post: "</ref>"
								}
							}
						}
					}
				}
			}
		},
		// Format section
		'advanced': {
			labelMsg: 'wikieditor-toolbar-section-advanced',
			type: 'toolbar',
			groups: {
				'heading': {
					tools: {
						'heading': {
							labelMsg: 'wikieditor-toolbar-tool-heading',
							type: 'select',
							list: {
								'heading-2' : {
									labelMsg: 'wikieditor-toolbar-tool-heading-2',
									action: {
										type: 'encapsulate',
										options: {
											pre: '== ',
											periMsg: 'wikieditor-toolbar-tool-heading-example',
											post: ' ==',
											regex: /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											regexReplace: "\$1==\$3==\$4",
											ownline: true
										}
									}
								},
								'heading-3' : {
									labelMsg: 'wikieditor-toolbar-tool-heading-3',
									action: {
										type: 'encapsulate',
										options: {
											pre: '=== ',
											periMsg: 'wikieditor-toolbar-tool-heading-example',
											post: ' ===',
											regex: /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											regexReplace: "\$1===\$3===\$4",
											ownline: true
										}
									}
								},
								'heading-4' : {
									labelMsg: 'wikieditor-toolbar-tool-heading-4',
									action: {
										type: 'encapsulate',
										options: {
											pre: '==== ',
											periMsg: 'wikieditor-toolbar-tool-heading-example',
											post: ' ====',
											regex: /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											regexReplace: "\$1====\$3====\$4",
											ownline: true
										}
									}
								},
								'heading-5' : {
									labelMsg: 'wikieditor-toolbar-tool-heading-5',
									action: {
										type: 'encapsulate',
										options: {
											pre: '===== ',
											periMsg: 'wikieditor-toolbar-tool-heading-example',
											post: ' =====',
											regex: /^(\s*)(={1,6})(.*?)\2(\s*)$/,
											regexReplace: "\$1=====\$3=====\$4",
											ownline: true
										}
									}
								}
							}
						}
					}
				},
				'format': {
					labelMsg: 'wikieditor-toolbar-group-format',
					tools: {
						'ulist': {
							labelMsg: 'wikieditor-toolbar-tool-ulist',
							type: 'button',
							icon: 'format-ulist.png',
							offset: [2, -1366],
							action: {
								type: 'encapsulate',
								options: {
									pre: "* ",
									periMsg: 'wikieditor-toolbar-tool-ulist-example',
									post: "",
									ownline: true
								}
							}
						},
						'olist': {
							labelMsg: 'wikieditor-toolbar-tool-olist',
							type: 'button',
							icon: 'format-olist.png',
							offset: [2, -1078],
							action: {
								type: 'encapsulate',
								options: {
									pre: "# ",
									periMsg: 'wikieditor-toolbar-tool-olist-example',
									post: "",
									ownline: true
								}
							}
						},
						'indent': {
							labelMsg: 'wikieditor-toolbar-tool-indent',
							type: 'button',
							icon: 'format-indent.png',
							offset: [2, -646],
							action: {
								type: 'encapsulate',
								options: {
									pre: ":",
									periMsg: 'wikieditor-toolbar-tool-indent-example',
									post: "",
									ownline: true,
									splitlines: true
								}
							}
						},
						'nowiki': {
							labelMsg: 'wikieditor-toolbar-tool-nowiki',
							type: 'button',
							icon: 'insert-nowiki.png',
							offset: [-70, -70],
							action: {
								type: 'encapsulate',
								options: {
									pre: "<nowiki>",
									periMsg: 'wikieditor-toolbar-tool-nowiki-example',
									post: "</nowiki>"
								}
							}
						},
						'newline': {
							labelMsg: 'wikieditor-toolbar-tool-newline',
							type: 'button',
							icon: 'insert-newline.png',
							offset: [2, -1726],
							action: {
								type: 'encapsulate',
								options: {
									pre: "<br />\n"
								}
							}
						}
					}
				},
				'size': {
					tools: {
						'big': {
							labelMsg: 'wikieditor-toolbar-tool-big',
							type: 'button',
							icon: 'format-big.png',
							offset: [2, 2],
							action: {
								type: 'encapsulate',
								options: {
									pre: "<big>",
									periMsg: 'wikieditor-toolbar-tool-big-example',
									post: "</big>"
								}
							}
						},
						'small': {
							labelMsg: 'wikieditor-toolbar-tool-small',
							type: 'button',
							icon: 'format-small.png',
							offset: [2, -1150],
							action: {
								type: 'encapsulate',
								options: {
									pre: "<small>",
									periMsg: 'wikieditor-toolbar-tool-small-example',
									post: "</small>"
								}
							}
						},
						'superscript': {
							labelMsg: 'wikieditor-toolbar-tool-superscript',
							type: 'button',
							icon: 'format-superscript.png',
							offset: [2, -1294],
							action: {
								type: 'encapsulate',
								options: {
									pre: "<sup>",
									periMsg: 'wikieditor-toolbar-tool-superscript-example',
									post: "</sup>"
								}
							}
						},
						'subscript': {
							labelMsg: 'wikieditor-toolbar-tool-subscript',
							type: 'button',
							icon: 'format-subscript.png',
							offset: [2, -1222],
							action: {
								type: 'encapsulate',
								options: {
									pre: "<sub>",
									periMsg: 'wikieditor-toolbar-tool-subscript-example',
									post: "</sub>"
								}
							}
						}
					}
				},
				'insert': {
					labelMsg: 'wikieditor-toolbar-group-insert',
					tools: {
						'gallery': {
							labelMsg: 'wikieditor-toolbar-tool-gallery',
							type: 'button',
							icon: 'insert-gallery.png',
							offset: [2, -1510],
							action: {
								type: 'encapsulate',
								options: {
									pre: "<gallery>\n",
									periMsg: 'wikieditor-toolbar-tool-gallery-example',
									post: "\n</gallery>",
									ownline: true
								}
							}
						},
						'tableCGD': {
							labelMsg: 'wikieditor-toolbar-tool-table',
							type: 'button',
							icon: 'insert-table.png',
							offset: [2, -1942],
							filters: [ '#wpTextbox1.toolbar-dialogs' ],
							action: {
								type: 'dialog',
								module: 'insert-table'
							}
						},
						'table': {
							labelMsg: 'wikieditor-toolbar-tool-table',
							type: 'button',
							icon: 'insert-table.png',
							offset: [2, -1942],
							filters: [ '#wpTextbox1:not(.toolbar-dialogs)' ],
							action: {
								type: 'encapsulate',
								options: {
									pre: "{| class=\"wikitable\" border=\"1\"\n|",
									periMsg: 'wikieditor-toolbar-tool-table-example-old',
									post: "\n|}",
									ownline: true
								}
							}
						},
						'redirect': {
							labelMsg: 'wikieditor-toolbar-tool-redirect',
							type: 'button',
							icon: 'insert-redirect.png',
							offset: [-70, -142],
							action: {
								type: 'encapsulate',
								options: {
									pre: "#REDIRECT [[",
									periMsg: 'wikieditor-toolbar-tool-redirect-example',
									post: "]]",
									ownline: true
								}
							}
						}
					}
				},
				'search': {
					tools: {
						'replace': {
							labelMsg: 'wikieditor-toolbar-tool-replace',
							type: 'button',
							icon: 'search-replace.png',
							offset: [-70, -214],
							filters: [ '#wpTextbox1.toolbar-dialogs' ],
							action: {
								type: 'dialog',
								module: 'search-and-replace'
							}
						}
					}
				}
			}
		},
		'characters': {
			labelMsg: 'wikieditor-toolbar-section-characters',
			type: 'booklet',
			deferLoad: true,
			pages: {
				'latin': {
					'labelMsg': 'wikieditor-toolbar-characters-page-latin',
					'layout': 'characters',
					'characters': [
						"\u00c1", "\u00e1", "\u00c0", "\u00e0", "\u00c2", "\u00e2", "\u00c4", "\u00e4", "\u00c3", "\u00e3",
						"\u01cd", "\u01ce", "\u0100", "\u0101", "\u0102", "\u0103", "\u0104", "\u0105", "\u00c5", "\u00e5",
						"\u0106", "\u0107", "\u0108", "\u0109", "\u00c7", "\u00e7", "\u010c", "\u010d", "\u010a", "\u010b",
						"\u0110", "\u0111", "\u010e", "\u010f", "\u00c9", "\u00e9", "\u00c8", "\u00e8", "\u00ca", "\u00ea",
						"\u00cb", "\u00eb", "\u011a", "\u011b", "\u0112", "\u0113", "\u0114", "\u0115", "\u0116", "\u0117",
						"\u0118", "\u0119", "\u011c", "\u011d", "\u0122", "\u0123", "\u011e", "\u011f", "\u0120", "\u0121",
						"\u0124", "\u0125", "\u0126", "\u0127", "\u00cd", "\u00ed", "\u00cc", "\u00ec", "\u00ce", "\u00ee",
						"\u00cf", "\u00ef", "\u0128", "\u0129", "\u01cf", "\u01d0", "\u012a", "\u012b", "\u012c", "\u012d",
						"\u0130", "\u0131", "\u012e", "\u012f", "\u0134", "\u0135", "\u0136", "\u0137", "\u0139", "\u013a",
						"\u013b", "\u013c", "\u013d", "\u013e", "\u0141", "\u0142", "\u013f", "\u0140", "\u0143", "\u0144",
						"\u00d1", "\u00f1", "\u0145", "\u0146", "\u0147", "\u0148", "\u00d3", "\u00f3", "\u00d2", "\u00f2",
						"\u00d4", "\u00f4", "\u00d6", "\u00f6", "\u00d5", "\u00f5", "\u01d1", "\u01d2", "\u014c", "\u014d",
						"\u014e", "\u014f", "\u01ea", "\u01eb", "\u0150", "\u0151", "\u0154", "\u0155", "\u0156", "\u0157",
						"\u0158", "\u0159", "\u015a", "\u015b", "\u015c", "\u015d", "\u015e", "\u015f", "\u0160", "\u0161",
						"\u0162", "\u0163", "\u0164", "\u0165", "\u00da", "\u00fa", "\u00d9", "\u00f9", "\u00db", "\u00fb",
						"\u00dc", "\u00fc", "\u0168", "\u0169", "\u016e", "\u016f", "\u01d3", "\u01d4", "\u016a", "\u016b",
						"\u01d6", "\u01d8", "\u01da", "\u01dc", "\u016c", "\u016d", "\u0172", "\u0173", "\u0170", "\u0171",
						"\u0174", "\u0175", "\u00dd", "\u00fd", "\u0176", "\u0177", "\u0178", "\u00ff", "\u0232", "\u0233",
						"\u0179", "\u017a", "\u017d", "\u017e", "\u017b", "\u017c", "\u00c6", "\u00e6", "\u01e2", "\u01e3",
						"\u00d8", "\u00f8", "\u0152", "\u0153", "\u00df", "\u00f0", "\u00de", "\u00fe", "\u018f", "\u0259"
					]
				},
				'latinextended': {
					'labelMsg': 'wikieditor-toolbar-characters-page-latinextended',
					'layout': 'characters',
					'characters': [
						"\u1e00", "\u1e01", "\u1e9a", "\u1ea0", "\u1ea1", "\u1ea2", "\u1ea3", "\u1ea4", "\u1ea5", "\u1ea6",
						"\u1ea7", "\u1ea8", "\u1ea9", "\u1eaa", "\u1eab", "\u1eac", "\u1ead", "\u1eae", "\u1eaf", "\u1eb0",
						"\u1eb1", "\u1eb2", "\u1eb3", "\u1eb4", "\u1eb5", "\u1eb6", "\u1eb7", "\u1e02", "\u1e03", "\u1e04",
						"\u1e05", "\u1e06", "\u1e07", "\u1e08", "\u1e09", "\u1e0a", "\u1e0b", "\u1e0c", "\u1e0d", "\u1e0e",
						"\u1e0f", "\u1e10", "\u1e11", "\u1e12", "\u1e13", "\u1e14", "\u1e15", "\u1e16", "\u1e17", "\u1e18",
						"\u1e19", "\u1e1a", "\u1e1b", "\u1e1c", "\u1e1d", "\u1eb8", "\u1eb9", "\u1eba", "\u1ebb", "\u1ebc",
						"\u1ebd", "\u1ebe", "\u1ebf", "\u1ec0", "\u1ec1", "\u1ec2", "\u1ec3", "\u1ec4", "\u1ec5", "\u1ec6",
						"\u1ec7", "\u1e1e", "\u1e1f", "\u1e20", "\u1e21", "\u1e22", "\u1e23", "\u1e24", "\u1e25", "\u1e26",
						"\u1e27", "\u1e28", "\u1e29", "\u1e2a", "\u1e2b", "\u1e96", "\u1e2c", "\u1e2d", "\u1e2e", "\u1e2f",
						"\u1ec8", "\u1ec9", "\u1eca", "\u1ecb", "\u1e30", "\u1e31", "\u1e32", "\u1e33", "\u1e34", "\u1e35",
						"\u1e36", "\u1e37", "\u1e38", "\u1e39", "\u1e3a", "\u1e3b", "\u1e3c", "\u1e3d", "\u1efa", "\u1efb",
						"\u1e3e", "\u1e3f", "\u1e40", "\u1e41", "\u1e42", "\u1e43", "\u1e44", "\u1e45", "\u1e46", "\u1e47",
						"\u1e48", "\u1e49", "\u1e4a", "\u1e4b", "\u1e4c", "\u1e4d", "\u1e4e", "\u1e4f", "\u1e50", "\u1e51",
						"\u1e52", "\u1e53", "\u1ecc", "\u1ecd", "\u1ece", "\u1ecf", "\u1ed0", "\u1ed1", "\u1ed2", "\u1ed3",
						"\u1ed4", "\u1ed5", "\u1ed6", "\u1ed7", "\u1ed8", "\u1ed9", "\u1eda", "\u1edb", "\u1edc", "\u1edd",
						"\u1ede", "\u1edf", "\u1ee0", "\u1ee1", "\u1ee2", "\u1ee3", "\u1e54", "\u1e55", "\u1e56", "\u1e57",
						"\u1e58", "\u1e59", "\u1e5a", "\u1e5b", "\u1e5c", "\u1e5d", "\u1e5e", "\u1e5f", "\u1e60", "\u1e61",
						"\u1e9b", "\u1e62", "\u1e63", "\u1e64", "\u1e65", "\u1e66", "\u1e67", "\u1e68", "\u1e69", "\u1e9c",
						"\u1e9d", "\u1e6a", "\u1e6b", "\u1e6c", "\u1e6d", "\u1e6e", "\u1e6f", "\u1e70", "\u1e71", "\u1e97",
						"\u1e72", "\u1e73", "\u1e74", "\u1e75", "\u1e76", "\u1e77", "\u1e78", "\u1e79", "\u1e7a", "\u1e7b",
						"\u1ee4", "\u1ee5", "\u1ee6", "\u1ee7", "\u1ee8", "\u1ee9", "\u1eea", "\u1eeb", "\u1eec", "\u1eed",
						"\u1eee", "\u1eef", "\u1ef0", "\u1ef1", "\u1e7c", "\u1e7d", "\u1e7e", "\u1e7f", "\u1efc", "\u1efd",
						"\u1e80", "\u1e81", "\u1e82", "\u1e83", "\u1e84", "\u1e85", "\u1e86", "\u1e87", "\u1e88", "\u1e89",
						"\u1e98", "\u1e8a", "\u1e8b", "\u1e8c", "\u1e8d", "\u1e8e", "\u1e8f", "\u1e99", "\u1ef2", "\u1ef3",
						"\u1ef4", "\u1ef5", "\u1ef6", "\u1ef7", "\u1ef8", "\u1ef9", "\u1efe", "\u1eff", "\u1e90", "\u1e91",
						"\u1e92", "\u1e93", "\u1e94", "\u1e95", "\u1e9e", "\u1e9f"
					]
				},
				'ipa': {
					labelMsg: 'wikieditor-toolbar-characters-page-ipa',
					layout: 'characters',
					characters: [
						"p", "t\u032a", "t", "\u0288", "c", "k", "q", "\u02a1", "\u0294", "b","d\u032a", "d", "\u0256",
						"\u025f", "\u0261", "\u0262", "\u0253", "\u0257", "\u0284", "\u0260", "\u029b", "t\u0361s",
						"t\u0361\u0283", "t\u0361\u0255", "d\u0361z", "d\u0361\u0292", "d\u0361\u0291", "\u0278", "f",
						"\u03b8", "s", "\u0283", "\u0285", "\u0286", "\u0282", "\u0255", "\u00e7", "\u0267", "x", "\u03c7",
						"\u0127", "\u029c", "h", "\u03b2", "v", "\u028d", "\u00f0", "z", "\u0292", "\u0293", "\u0290",
						"\u0291", "\u029d", "\u0263", "\u0281", "\u0295", "\u0296", "\u02a2", "\u0266", "\u026c", "\u026e",
						"m", "m\u0329", "\u0271", "\u0271\u0329", "\u0271\u030d", "n\u032a", "n\u032a\u030d", "n",
						"n\u0329", "\u0273", "\u0273\u0329", "\u0272", "\u0272\u0329", "\u014b", "\u014b\u030d",
						"\u014b\u0329", "\u0274", "\u0274\u0329", "\u0299", "\u0299\u0329", "r", "r\u0329", "\u0280",
						"\u0280\u0329", "\u027e", "\u027d", "\u027f", "\u027a", "l\u032a", "l\u032a\u0329", "l", "l\u0329",
						"\u026b", "\u026b\u0329", "\u026d", "\u026d\u0329", "\u028e", "\u028e\u0329", "\u029f",
						"\u029f\u0329", "w", "\u0265", "\u028b", "\u0279", "\u027b", "j", "\u0270", "\u0298", "\u01c2",
						"\u01c0", "!", "\u01c1", "\u02b0", "\u02b1", "\u02b7", "\u02b8", "\u02b2", "\u02b3", "\u207f",
						"\u02e1", "\u02b4", "\u02b5", "\u02e2", "\u02e3", "\u02e0", "\u02b6", "\u02e4", "\u02c1", "\u02c0",
						"\u02bc", "i", "i\u032f", "\u0129", "y", "y\u032f", "\u1ef9", "\u026a", "\u026a\u032f",
						"\u026a\u0303", "\u028f", "\u028f\u032f", "\u028f\u0303", "\u0268", "\u0268\u032f", "\u0268\u0303",
						"\u0289", "\u0289\u032f", "\u0289\u0303", "\u026f", "\u026f\u032f", "\u026f\u0303", "u", "u\u032f",
						"\u0169", "\u028a", "\u028a\u032f", "\u028a\u0303", "e", "e\u032f", "\u1ebd", "\u00f8",
						"\u00f8\u032f", "\u00f8\u0303", "\u0258", "\u0258\u032f", "\u0258\u0303", "\u0275", "\u0275\u032f",
						"\u0275\u0303", "\u0264", "\u0264\u032f", "\u0264\u0303", "o", "o\u032f", "\u00f5", "\u025b",
						"\u025b\u032f", "\u025b\u0303", "\u0153", "\u0153\u032f", "\u0153\u0303", "\u025c", "\u025c\u032f",
						"\u025c\u0303", "\u0259", "\u0259\u032f", "\u0259\u0303", "\u025e", "\u025e\u032f", "\u025e\u0303",
						"\u028c", "\u028c\u032f", "\u028c\u0303", "\u0254", "\u0254\u032f", "\u0254\u0303", "\u00e6",
						"\u00e6\u032f", "\u00e6\u0303", "\u0276", "\u0276\u032f", "\u0276\u0303", "a", "a\u032f", "\u00e3",
						"\u0250", "\u0250\u032f", "\u0250\u0303", "\u0251", "\u0251\u032f", "\u0251\u0303", "\u0252",
						"\u0252\u032f", "\u0252\u0303", "\u02c8", "\u02cc", "\u02d0", "\u02d1", "\u02d8", ".", "\u203f",
						"|", "\u2016"
					]
				},
				'symbols': {
					'labelMsg': 'wikieditor-toolbar-characters-page-symbols',
					'layout': 'characters',
					'characters': [
						"~", "|", "\u00a1", "\u00bf", "\u2020", "\u2021", "\u2194", "\u2191", "\u2193", "\u2022", "\u00b6",
						"#", "\u00bd", "\u2153", "\u2154", "\u00bc", "\u00be", "\u215b", "\u215c", "\u215d", "\u215e",
						"\u221e", "\u2018", "\u201e", "\u201c", "\u2019", "\u201d",
						{
							'label': "\u00ab\u00bb",
							'action': {
								'type': 'encapsulate', 'options': { 'pre': "\u00ab", 'post': "\u00bb" }
							}
						},
						"\u00a4", "\u20b3", "\u0e3f", "\u20b5", "\u00a2", "\u20a1", "\u20a2", "$", "\u20ab", "\u20af",
						"\u20ac", "\u20a0", "\u20a3", "\u0192", "\u20b4", "\u20ad", "\u20a4", "\u2133", "\u20a5", "\u20a6",
						"\u2116", "\u20a7", "\u20b0", "\u00a3", "\u17db", "\u20a8", "\u20aa", "\u09f3", "\u20ae", "\u20a9",
						"\u00a5", "\u2660", "\u2663", "\u2665", "\u2666", "m\u00b2", "m\u00b3", "\u2013", "\u2014",
						"\u2026", "\u2018", "\u201c", "\u2019", "\u201d", "\u00b0", "\u2033", "\u2032", "\u2248", "\u2260",
						"\u2264", "\u2265", "\u00b1", "\u2212", "\u00d7", "\u00f7", "\u2190", "\u2192", "\u00b7", "\u00a7"
					]
				},
				'greek': {
					'labelMsg': 'wikieditor-toolbar-characters-page-greek',
					'layout': 'characters',
					'language': 'hl',
					'characters': [
						"\u0391", "\u0386", "\u03b1", "\u03ac", "\u0392", "\u03b2", "\u0393", "\u03b3", "\u0394", "\u03b4",
						"\u0395", "\u0388", "\u03b5", "\u03ad", "\u0396", "\u03b6", "\u0397", "\u0389", "\u03b7", "\u03ae",
						"\u0398", "\u03b8", "\u0399", "\u038a", "\u03b9", "\u03af", "\u039a", "\u03ba", "\u039b", "\u03bb",
						"\u039c", "\u03bc", "\u039d", "\u03bd", "\u039e", "\u03be", "\u039f", "\u038c", "\u03bf", "\u03cc",
						"\u03a0", "\u03c0", "\u03a1", "\u03c1", "\u03a3", "\u03c3", "\u03c2", "\u03a4", "\u03c4", "\u03a5",
						"\u038e", "\u03c5", "\u03cd", "\u03a6", "\u03c6", "\u03a7", "\u03c7", "\u03a8", "\u03c8", "\u03a9",
						"\u038f", "\u03c9", "\u03ce"
					]
				},
				'cyrillic': {
					'labelMsg': 'wikieditor-toolbar-characters-page-cyrillic',
					'layout': 'characters',
					'characters': [
						"\u0410", "\u0430", "\u04d8", "\u04d9", "\u0411", "\u0431", "\u0412",  "\u0432", "\u0413", "\u0433",
						"\u0490", "\u0491", "\u0403", "\u0453", "\u0492", "\u0493", "\u0414", "\u0434", "\u0402", "\u0452",
						"\u0415", "\u0435", "\u0404", "\u0454", "\u0401", "\u0451", "\u0416", "\u0436", "\u0417", "\u0437",
						"\u0405", "\u0455", "\u0418", "\u0438", "\u0406", "\u0456", "\u0407", "\u0457", "\u0130", "\u0419",
						"\u0439", "\u04e2", "\u04e3", "\u0408", "\u0458", "\u041a", "\u043a", "\u040c", "\u045c", "\u049a",
						"\u049b", "\u041b", "\u043b", "\u0409", "\u0459", "\u041c", "\u043c", "\u041d", "\u043d", "\u040a",
						"\u045a", "\u04a2", "\u04a3", "\u041e", "\u043e", "\u04e8", "\u04e9", "\u041f", "\u043f", "\u0420",
						"\u0440", "\u0421", "\u0441", "\u0422", "\u0442", "\u040b", "\u045b", "\u0423", "\u0443", "\u040e",
						"\u045e", "\u04ee", "\u04ef", "\u04b0", "\u04b1", "\u04ae", "\u04af", "\u0424", "\u0444", "\u0425",
						"\u0445", "\u04b2", "\u04b3", "\u04ba", "\u04bb", "\u0426", "\u0446", "\u0427", "\u0447", "\u04b6",
						"\u04b7", "\u040f", "\u045f", "\u0428", "\u0448", "\u0429", "\u0449", "\u042a", "\u044a", "\u042b",
						"\u044b", "\u042c", "\u044c", "\u042d", "\u044d", "\u042e", "\u044e", "\u042f", "\u044f"
					]
				},
				'arabic': {
					'labelMsg': 'wikieditor-toolbar-characters-page-arabic',
					'layout': 'characters',
					'language': 'ar',
					'direction': 'rtl',
					'characters': [
						"\u061b", "\u061f", "\u0621", "\u0622", "\u0623", "\u0624", "\u0625", "\u0626", "\u0627", "\u0628",
						"\u0629", "\u062a", "\u062b", "\u062c", "\u062d", "\u062e", "\u062f", "\u0630", "\u0631", "\u0632",
						"\u0633", "\u0634", "\u0635", "\u0636", "\u0637", "\u0638", "\u0639", "\u063a", "\u0641", "\u0642",
						"\u0643", "\u0644", "\u0645", "\u0646", "\u0647", "\u0648", "\u0649", "\u064a", "\u060c", "\u067e",
						"\u0686", "\u0698", "\u06af", "\u06ad"
					]
				},
				'hebrew': {
					'labelMsg': 'wikieditor-toolbar-characters-page-hebrew',
					'layout': 'characters',
					'direction': 'rtl',
					'characters': [
						"\u05d0", "\u05d1", "\u05d2", "\u05d3", "\u05d4", "\u05d5", "\u05d6", "\u05d7", "\u05d8", "\u05d9",
						"\u05db", "\u05da", "\u05dc", "\u05de", "\u05dd", "\u05e0", "\u05df", "\u05e1", "\u05e2", "\u05e4",
						"\u05e3", "\u05e6", "\u05e5", "\u05e7", "\u05e8", "\u05e9", "\u05ea", "\u05f3", "\u05f4", "\u05f0",
						"\u05f1", "\u05f2", "\u05d0", "\u05d3", "\u05d4", "\u05d5", "\u05d6", "\u05d7", "\u05d8", "\u05d9",
						"\u05da", "\u05db", "\u05dc", "\u05dd", "\u05de", "\u05df", "\u05e0", "\u05e1", "\u05e2", "\u05e3",
						"\u05e4", "\u05be", "\u05f3", "\u05f4",
						[ "\u05b0\u25cc", "\u05b0" ], [ "\u05b1\u25cc", "\u05b1" ], [ "\u05b2\u25cc", "\u05b2" ],
						[ "\u05b3\u25cc", "\u05b3" ], [ "\u05b4\u25cc", "\u05b4" ], [ "\u05b5\u25cc", "\u05b5" ],
						[ "\u05b6\u25cc", "\u05b6" ], [ "\u05b7\u25cc", "\u05b7" ], [ "\u05b8\u25cc", "\u05b8" ],
						[ "\u05b9\u25cc", "\u05b9" ], [ "\u05bb\u25cc", "\u05bb" ], [ "\u05bc\u25cc", "\u05bc" ],
						[ "\u05c1\u25cc", "\u05c1" ], [ "\u05c2\u25cc", "\u05c2" ], [ "\u05c7\u25cc", "\u05c7" ],
						[ "\u0591\u25cc", "\u0591" ], [ "\u0592\u25cc", "\u0592" ], [ "\u0593\u25cc", "\u0593" ],
						[ "\u0594\u25cc", "\u0594" ], [ "\u0595\u25cc", "\u0595" ], [ "\u0596\u25cc", "\u0596" ],
						[ "\u0597\u25cc", "\u0597" ], [ "\u0598\u25cc", "\u0598" ], [ "\u0599\u25cc", "\u0599" ],
						[ "\u059a\u25cc", "\u059a" ], [ "\u059b\u25cc", "\u059b" ], [ "\u059c\u25cc", "\u059c" ],
						[ "\u059d\u25cc", "\u059d" ], [ "\u059e\u25cc", "\u059e" ], [ "\u059f\u25cc", "\u059f" ],
						[ "\u05a0\u25cc", "\u05a0" ], [ "\u05a1\u25cc", "\u05a1" ], [ "\u05a2\u25cc", "\u05a2" ],
						[ "\u05a3\u25cc", "\u05a3" ], [ "\u05a4\u25cc", "\u05a4" ], [ "\u05a5\u25cc", "\u05a5" ],
						[ "\u05a6\u25cc", "\u05a6" ], [ "\u05a7\u25cc", "\u05a7" ], [ "\u05a8\u25cc", "\u05a8" ],
						[ "\u05a9\u25cc", "\u05a9" ], [ "\u05aa\u25cc", "\u05aa" ], [ "\u05ab\u25cc", "\u05ab" ],
						[ "\u05ac\u25cc", "\u05ac" ], [ "\u05ad\u25cc", "\u05ad" ], [ "\u05ae\u25cc", "\u05ae" ],
						[ "\u05af\u25cc", "\u05af" ], [ "\u05bf\u25cc", "\u05bf" ], [ "\u05c0\u25cc", "\u05c0" ],
						[ "\u05c3\u25cc", "\u05c3" ]
					]
				},
				'bangla': {
					'labelMsg': 'wikieditor-toolbar-characters-page-bangla',
					'language': 'bn',
					'layout': 'characters',
					'characters': [
						"\u0985", "\u0986", "\u0987", "\u0988", "\u0989", "\u098a", "\u098b", "\u098f", "\u0990", "\u0993",
						"\u0994", "\u09be", "\u09bf", "\u09c0", "\u09c1", "\u09c2", "\u09c3", "\u09c7", "\u09c8", "\u09cb",
						"\u09cc", "\u0995", "\u0996", "\u0997", "\u0998", "\u0999", "\u099a", "\u099b", "\u099c", "\u099d",
						"\u099e", "\u099f", "\u09a0", "\u09a1", "\u09a2", "\u09a3", "\u09a4", "\u09a5", "\u09a6", "\u09a7",
						"\u09a8", "\u09aa", "\u09ab", "\u09ac", "\u09ad", "\u09ae", "\u09af", "\u09b0", "\u09b2", "\u09b6",
						"\u09b7", "\u09b8", "\u09b9", "\u09a1\u09bc", "\u09a2\u09bc", "\u09af\u09bc", "\u09ce", "\u0982",
						"\u0983", "\u0981", "\u09cd", "\u09e7", "\u09e8", "\u09e9", "\u09ea", "\u09eb", "\u09ec", "\u09ed",
						"\u09ee", "\u09ef", "\u09e6"
					]
				},
				'telugu': {
					'labelMsg': 'wikieditor-toolbar-characters-page-telugu',
					'language': 'te',
					'layout': 'characters',
					'characters': [
						"\u0c01", "\u0c02", "\u0c03", "\u0c05", "\u0c06", "\u0c07", "\u0c08", "\u0c09", "\u0c0a", "\u0c0b",
						"\u0c60", "\u0c0c", "\u0c61", "\u0c0e", "\u0c0f", "\u0c10", "\u0c12", "\u0c13", "\u0c14", "\u0c15",
						"\u0c16", "\u0c17", "\u0c18", "\u0c19", "\u0c1a", "\u0c1b", "\u0c1c", "\u0c1d", "\u0c1e", "\u0c1f",
						"\u0c20", "\u0c21", "\u0c22", "\u0c23", "\u0c24", "\u0c25", "\u0c26", "\u0c27", "\u0c28", "\u0c2a",
						"\u0c2b", "\u0c2c", "\u0c2d", "\u0c2e", "\u0c2f", "\u0c30", "\u0c31", "\u0c32", "\u0c33", "\u0c35",
						"\u0c36", "\u0c37", "\u0c38", "\u0c39", "\u0c3e", "\u0c3f", "\u0c40", "\u0c41", "\u0c42", "\u0c43",
						"\u0c44", "\u0c46", "\u0c47", "\u0c48", "\u0c4a", "\u0c4b", "\u0c4c", "\u0c4d", "\u0c62", "\u0c63",
						"\u0c58", "\u0c59", "\u0c66", "\u0c67", "\u0c68", "\u0c69", "\u0c6a", "\u0c6b", "\u0c6c", "\u0c6d",
						"\u0c6e", "\u0c6f", "\u0c3d", "\u0c78", "\u0c79", "\u0c7a", "\u0c7b", "\u0c7c", "\u0c7d", "\u0c7e",
						"\u0c7f"
					]
				},
				'sinhala': {
					'labelMsg': 'wikieditor-toolbar-characters-page-sinhala',
					'language': 'si',
					'layout': 'characters',
					'characters': [
						"\u0d85", "\u0d86", "\u0d87", "\u0d88", "\u0d89", "\u0d8a", "\u0d8b", "\u0d8c", "\u0d8d", "\u0d8e",
						"\u0d8f", "\u0d90", "\u0d91", "\u0d92", "\u0d93", "\u0d94", "\u0d95", "\u0d96", "\u0d9a", "\u0d9b",
						"\u0d9c", "\u0d9d", "\u0d9e", "\u0d9f", "\u0da0", "\u0da1", "\u0da2", "\u0da3", "\u0da4", "\u0da5",
						"\u0da6", "\u0da7", "\u0da8", "\u0da9", "\u0daa", "\u0dab", "\u0dac", "\u0dad", "\u0dae", "\u0daf",
						"\u0db0", "\u0db1", "\u0db3", "\u0db4", "\u0db5", "\u0db6", "\u0db7", "\u0db8", "\u0db9", "\u0dba",
						"\u0dbb", "\u0dbd", "\u0dc0", "\u0dc1", "\u0dc2", "\u0dc3", "\u0dc4", "\u0dc5", "\u0dc6",
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
						"\u0ad0", "\u0a85", "\u0a86", "\u0a87", "\u0a88", "\u0a89", "\u0a8a", "\u0a8b", "\u0ae0", "\u0a8c",
						"\u0ae1", "\u0a8d", "\u0a8f", "\u0a90", "\u0a91", "\u0a93", "\u0a94", "\u0a95", "\u0a96", "\u0a97",
						"\u0a98", "\u0a99", "\u0a9a", "\u0a9b", "\u0a9c", "\u0a9d", "\u0a9e", "\u0a9f", "\u0aa0", "\u0aa1",
						"\u0aa2", "\u0aa3", "\u0aa4", "\u0aa5", "\u0aa6", "\u0aa7", "\u0aa8", "\u0aaa", "\u0aab", "\u0aac",
						"\u0aad", "\u0aae", "\u0aaf", "\u0ab0", "\u0ab2", "\u0ab5", "\u0ab6", "\u0ab7", "\u0ab8", "\u0ab9",
						"\u0ab3", "\u0abd", [ "\u25cc\u0abe", "\u0abe" ], [ "\u25cc\u0abf", "\u0abf" ],
						[ "\u25cc\u0ac0", "\u0ac0" ], [ "\u25cc\u0ac1", "\u0ac1" ], [ "\u25cc\u0ac2", "\u0ac2" ],
						[ "\u25cc\u0ac3", "\u0ac3" ], [ "\u25cc\u0ac4", "\u0ac4" ], [ "\u25cc\u0ae2", "\u0ae2" ],
						[ "\u25cc\u0ae3", "\u0ae3" ], [ "\u25cc\u0ac5", "\u0ac5" ], [ "\u25cc\u0ac7", "\u0ac7" ],
						[ "\u25cc\u0ac8", "\u0ac8" ], [ "\u25cc\u0ac9", "\u0ac9" ], [ "\u25cc\u0acb", "\u0acb" ],
						[ "\u25cc\u0acc", "\u0acc" ], [ "\u25cc\u0acd", "\u0acd" ]
					]
				}
			}
		},
		'help': {
			labelMsg: 'wikieditor-toolbar-section-help',
			type: 'booklet',
			deferLoad: true,
			pages: {
				'format': {
					labelMsg: 'wikieditor-toolbar-help-page-format',
					layout: 'table',
					headings: [
						{ textMsg: 'wikieditor-toolbar-help-heading-description' },
						{ textMsg: 'wikieditor-toolbar-help-heading-syntax' },
						{ textMsg: 'wikieditor-toolbar-help-heading-result' }
					],
					rows: [
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-italic-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-italic-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-italic-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-bold-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-bold-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-bold-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-bolditalic-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-bolditalic-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-bolditalic-result' }
						}
					]
				},
				'link': {
					labelMsg: 'wikieditor-toolbar-help-page-link',
					layout: 'table',
					headings: [
						{ textMsg: 'wikieditor-toolbar-help-heading-description' },
						{ textMsg: 'wikieditor-toolbar-help-heading-syntax' },
						{ textMsg: 'wikieditor-toolbar-help-heading-result' }
					],
					rows: [
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-ilink-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-ilink-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-ilink-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-xlink-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-xlink-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-xlink-result' }
						}
					]
				},
				'heading': {
					labelMsg: 'wikieditor-toolbar-help-page-heading',
					layout: 'table',
					headings: [
						{ textMsg: 'wikieditor-toolbar-help-heading-description' },
						{ textMsg: 'wikieditor-toolbar-help-heading-syntax' },
						{ textMsg: 'wikieditor-toolbar-help-heading-result' }
					],
					rows: [
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-heading1-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-heading1-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-heading1-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-heading2-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-heading2-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-heading2-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-heading3-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-heading3-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-heading3-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-heading4-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-heading4-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-heading4-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-heading5-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-heading5-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-heading5-result' }
						}
					]
				},
				'list': {
					labelMsg: 'wikieditor-toolbar-help-page-list',
					layout: 'table',
					headings: [
						{ textMsg: 'wikieditor-toolbar-help-heading-description' },
						{ textMsg: 'wikieditor-toolbar-help-heading-syntax' },
						{ textMsg: 'wikieditor-toolbar-help-heading-result' }
					],
					rows: [
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-ulist-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-ulist-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-ulist-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-olist-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-olist-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-olist-result' }
						}
					]
				},
				'file': {
					labelMsg: 'wikieditor-toolbar-help-page-file',
					layout: 'table',
					headings: [
						{ textMsg: 'wikieditor-toolbar-help-heading-description' },
						{ textMsg: 'wikieditor-toolbar-help-heading-syntax' },
						{ textMsg: 'wikieditor-toolbar-help-heading-result' }
					],
					rows: [
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-file-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-file-syntax' },
							'result': { htmlMsg: [ 'wikieditor-toolbar-help-content-file-result', mw.config.get( 'stylepath' ) ] }
						}
					]
				},
				'reference': {
					labelMsg: 'wikieditor-toolbar-help-page-reference',
					layout: 'table',
					headings: [
						{ textMsg: 'wikieditor-toolbar-help-heading-description' },
						{ textMsg: 'wikieditor-toolbar-help-heading-syntax' },
						{ textMsg: 'wikieditor-toolbar-help-heading-result' }
					],
					rows: [
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-reference-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-reference-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-reference-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-rereference-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-rereference-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-rereference-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-showreferences-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-showreferences-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-showreferences-result' }
						}
					]
				},
				'discussion': {
					labelMsg: 'wikieditor-toolbar-help-page-discussion',
					layout: 'table',
					headings: [
						{ textMsg: 'wikieditor-toolbar-help-heading-description' },
						{ textMsg: 'wikieditor-toolbar-help-heading-syntax' },
						{ textMsg: 'wikieditor-toolbar-help-heading-result' }
					],
					rows: [
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-signaturetimestamp-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-signaturetimestamp-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-signaturetimestamp-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-signature-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-signature-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-signature-result' }
						},
						{
							'description': { htmlMsg: 'wikieditor-toolbar-help-content-indent-description' },
							'syntax': { htmlMsg: 'wikieditor-toolbar-help-content-indent-syntax' },
							'result': { htmlMsg: 'wikieditor-toolbar-help-content-indent-result' }
						}
					]
				}
			}
		}
	},
	'dialogs': {
		'insert-link': {
			filters: [ '#wpTextbox1.toolbar-dialogs' ],
			titleMsg: 'wikieditor-toolbar-tool-link-title',
			id: 'wikieditor-toolbar-link-dialog',
			html: '\
				<fieldset>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-link-int-target" rel="wikieditor-toolbar-tool-link-int-target" id="wikieditor-toolbar-tool-link-int-target-label"></label>\
						<div id="wikieditor-toolbar-link-int-target-status"></div>\
						<input type="text" id="wikieditor-toolbar-link-int-target" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-link-int-text" rel="wikieditor-toolbar-tool-link-int-text"></label>\
						<input type="text" id="wikieditor-toolbar-link-int-text" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<div class="wikieditor-toolbar-floated-field-wrapper">\
							<input type="radio" id="wikieditor-toolbar-link-type-int" name="wikieditor-toolbar-link-type" selected />\
							<label for="wikieditor-toolbar-link-type-int" rel="wikieditor-toolbar-tool-link-int"></label>\
						</div>\
						<div class="wikieditor-toolbar-floated-field-wrapper">\
							<input type="radio" id="wikieditor-toolbar-link-type-ext" name="wikieditor-toolbar-link-type" />\
							<label for="wikieditor-toolbar-link-type-ext" rel="wikieditor-toolbar-tool-link-ext"></label>\
						</div>\
					</div>\
				</fieldset>',
			init: function() {
				function isExternalLink( s ) {
					// The following things are considered to be external links:
					// * Starts a URL protocol
					// * Starts with www.
					// All of these are potentially valid titles, and the latter two
					// categories match about 6300 titles in enwiki's ns0. Out of 6.9M
					// titles, that's 0.09%
					if ( typeof arguments.callee.regex == 'undefined' ) {
						// Cache the regex
						arguments.callee.regex =
							new RegExp( "^(" + mw.config.get( 'wgUrlProtocols' ) + "|www\\.)", 'i');
					}
					return s.match( arguments.callee.regex );
				}
				// Updates the status indicator above the target link
				function updateWidget( status ) {
					$j( '#wikieditor-toolbar-link-int-target-status' ).children().hide();
					$j( '#wikieditor-toolbar-link-int-target' ).parent()
						.removeClass( 'status-invalid status-external status-notexists status-exists status-loading' );
					if ( status ) {
						$j( '#wikieditor-toolbar-link-int-target-status-' + status ).show();
						$j( '#wikieditor-toolbar-link-int-target' ).parent().addClass( 'status-' + status );
					}
					if ( status == 'invalid' ) {
						$j( '.ui-dialog:visible .ui-dialog-buttonpane button:first' )
							.attr( 'disabled', true )
							.addClass( 'disabled' );
					} else { 
						$j( '.ui-dialog:visible .ui-dialog-buttonpane button:first' )
							.removeAttr('disabled')
							.removeClass('disabled');
					}
				}
				// Updates the UI to show if the page title being inputed by the user exists or not
				// accepts parameter internal for bypassing external link detection
				function updateExistence( internal ) {
					// ensure the internal parameter is a boolean 
					if ( internal != true ) internal = false;
					// Abort previous request
					var request = $j( '#wikieditor-toolbar-link-int-target-status' ).data( 'request' );
					if ( request ) {
						request.abort();
					}
					var target = $j( '#wikieditor-toolbar-link-int-target' ).val();
					var cache = $j( '#wikieditor-toolbar-link-int-target-status' ).data( 'existencecache' );
					if ( cache[target] ) {
						updateWidget( cache[target] );
						return;
					}
					if ( target.replace( /^\s+$/,'' ) == '' ) {
						// Hide the widget when the textbox is empty
						updateWidget( false );
						return;
					}
					// If the forced internal paremter was not true, check if the target is an external link
					if ( !internal && isExternalLink( target ) ) {
						updateWidget( 'external' );
						return;
					}
					if ( target.indexOf( '|' ) != -1 ) {
						// Title contains | , which means it's invalid
						// but confuses the API. Show invalid and bypass API
						updateWidget( 'invalid' );
						return;
					}
					// Show loading spinner while waiting for the API to respond
					updateWidget( 'loading' );
					// Call the API to check page status, saving the request object so it can be aborted if necessary
					$j( '#wikieditor-toolbar-link-int-target-status' ).data(
						'request',
						$j.ajax( {
							url: mw.util.wikiScript( 'api' ),
							dataType: 'json',
							data: {
								'action': 'query',
								'indexpageids': '',
								'titles': target,
								'format': 'json'
							},
							success: function( data ) {
								if ( !data ) {
									// This happens in some weird cases
									return;
								}
								var status;
								if ( typeof data.query == 'undefined' ) {
									status = 'invalid';
								} else {
									var page = data.query.pages[data.query.pageids[0]];
									status = 'exists';
									if ( typeof page.missing != 'undefined' )
										status = 'notexists';
									else if ( typeof page.invalid != 'undefined' )
										status = 'invalid';
								}
								// Cache the status of the link target if the force internal parameter was not passed
								if ( !internal ) cache[target] = status;
								updateWidget( status );
							}
						} )
					);
				}
				$j( '#wikieditor-toolbar-link-type-int, #wikieditor-toolbar-link-type-ext' ).click( function() {
					if( $j( '#wikieditor-toolbar-link-type-ext' ).is( ':checked' ) ) {
						// Abort previous request
						var request = $j( '#wikieditor-toolbar-link-int-target-status' ).data( 'request' );
						if ( request ) {
							request.abort();
						}
						updateWidget( 'external' );
					}
					if( $j( '#wikieditor-toolbar-link-type-int' ).is( ':checked' ) )
						updateExistence( true );
				});
				// Set labels of tabs based on rel values
				$j(this).find( '[rel]' ).each( function() {
					$j(this).text( mediaWiki.msg( $j(this).attr( 'rel' ) ) );
				});
				// Set tabindexes on form fields
				$j.wikiEditor.modules.dialogs.fn.setTabindexes( $j(this).find( 'input' ).not( '[tabindex]' ) );
				// Setup the tooltips in the textboxes
				$j( '#wikieditor-toolbar-link-int-target' )
					.data( 'tooltip', mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-tooltip' ) );
				$j( '#wikieditor-toolbar-link-int-text' )
					.data( 'tooltip', mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-text-tooltip' ) );
				$j( '#wikieditor-toolbar-link-int-target, #wikieditor-toolbar-link-int-text' )
					.each( function() {
						var tooltip = mediaWiki.msg( $j( this ).attr( 'id' ) + '-tooltip' );
						if ( $j( this ).val() == '' )
							$j( this )
								.addClass( 'wikieditor-toolbar-dialog-hint' )
								.val( $j( this ).data( 'tooltip' ) )
								.data( 'tooltip-mode', true );
					} )
					.focus( function() {
						if( $j( this ).val() == $j( this ).data( 'tooltip' ) ) {
							$j( this )
								.val( '' )
								.removeClass( 'wikieditor-toolbar-dialog-hint' )
								.data( 'tooltip-mode', false );
						}
					})
					.bind( 'change', function() {
						if ( $j( this ).val() != $j( this ).data( 'tooltip' ) ) {
							$j( this )
								.removeClass( 'wikieditor-toolbar-dialog-hint' )
								.data( 'tooltip-mode', false );
						}
					})
					.bind( 'blur', function() {
						if ( $j( this ).val() == '' ) {
							$j( this )
								.addClass( 'wikieditor-toolbar-dialog-hint' )
								.val( $j( this ).data( 'tooltip' ) )
								.data( 'tooltip-mode', true );
						}
					});

				// Automatically copy the value of the internal link page title field to the link text field unless the user
				// has changed the link text field - this is a convenience thing since most link texts are going to be the
				// the same as the page title
				// Also change the internal/external radio button accordingly
				$j( '#wikieditor-toolbar-link-int-target' ).bind( 'change keydown paste cut', function() {
					// $j(this).val() is the old value, before the keypress
					// Defer this until $j(this).val() has been updated
					setTimeout( function() {
						if ( isExternalLink( $j( '#wikieditor-toolbar-link-int-target' ).val() ) ) {
							$j( '#wikieditor-toolbar-link-type-ext' ).attr( 'checked', 'checked' );
							updateWidget( 'external' );
						} else {
							$j( '#wikieditor-toolbar-link-type-int' ).attr( 'checked', 'checked' );
							updateExistence();
						}
						if ( $j( '#wikieditor-toolbar-link-int-text' ).data( 'untouched' ) )
							if ( $j( '#wikieditor-toolbar-link-int-target' ).val() == 
								$j( '#wikieditor-toolbar-link-int-target' ).data( 'tooltip' ) ) {
									$j( '#wikieditor-toolbar-link-int-text' )
										.addClass( 'wikieditor-toolbar-dialog-hint' )
										.val( $j( '#wikieditor-toolbar-link-int-text' ).data( 'tooltip' ) )
										.change();
								} else {
									$j( '#wikieditor-toolbar-link-int-text' )
										.val( $j( '#wikieditor-toolbar-link-int-target' ).val() )
										.change();
								}
					}, 0 );
				});
				$j( '#wikieditor-toolbar-link-int-text' ).bind( 'change keydown paste cut', function() {
					var oldVal = $j(this).val();
					var that = this;
					setTimeout( function() {
						if ( $j(that).val() != oldVal )
							$j(that).data( 'untouched', false );
					}, 0 );
				});
				// Add images to the page existence widget, which will be shown mutually exclusively to communicate if the
				// page exists, does not exist or the title is invalid (like if it contains a | character)
				var existsMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-exists' );
				var notexistsMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-notexists' );
				var invalidMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-invalid' );
				var externalMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-external' );
				var loadingMsg = mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-target-status-loading' );
				$j( '#wikieditor-toolbar-link-int-target-status' )
					.append( $j( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-exists' )
						.append( existsMsg )
					)
					.append( $j( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-notexists' )
						.append( notexistsMsg )
					)
					.append( $j( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-invalid' )
						.append( invalidMsg )
					)
					.append( $j( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-external' )
						.append( externalMsg )
					)
					.append( $j( '<div />' )
						.attr( 'id', 'wikieditor-toolbar-link-int-target-status-loading' )
						.append( $j( '<img />' ).attr( {
							'src': $j.wikiEditor.imgPath + 'dialogs/' + 'loading.gif',
							'alt': loadingMsg,
							'title': loadingMsg
						} ) )
					)
					.data( 'existencecache', {} )
					.children().hide();

				$j( '#wikieditor-toolbar-link-int-target' )
					.bind( 'keyup paste cut', function() {
						// Cancel the running timer if applicable
						if ( typeof $j(this).data( 'timerID' ) != 'undefined' ) {
							clearTimeout( $j(this).data( 'timerID' ) );
						}
						// Delay fetch for a while
						// FIXME: Make 120 configurable elsewhere
						var timerID = setTimeout( updateExistence, 120 );
						$j(this).data( 'timerID', timerID );
					} )
					.change( function() {
						// Cancel the running timer if applicable
						if ( typeof $j(this).data( 'timerID' ) != 'undefined' ) {
							clearTimeout( $j(this).data( 'timerID' ) );
						}
						// Fetch right now
						updateExistence();
					} );

				// Title suggestions
				$j( '#wikieditor-toolbar-link-int-target' ).data( 'suggcache', {} ).suggestions( {
					fetch: function( query ) {
						var that = this;
						var title = $j(this).val();

						if ( isExternalLink( title ) || title.indexOf( '|' ) != -1  || title == '') {
							$j(this).suggestions( 'suggestions', [] );
							return;
						}

						var cache = $j(this).data( 'suggcache' );
						if ( typeof cache[title] != 'undefined' ) {
							$j(this).suggestions( 'suggestions', cache[title] );
							return;
						}

						var request = $j.ajax( {
							url: mw.util.wikiScript( 'api' ),
							data: {
								'action': 'opensearch',
								'search': title,
								'namespace': 0,
								'suggest': '',
								'format': 'json'
							},
							dataType: 'json',
							success: function( data ) {
								cache[title] = data[1];
								$j(that).suggestions( 'suggestions', data[1] );
							}
						});
						$j(this).data( 'request', request );
					},
					cancel: function() {
						var request = $j(this).data( 'request' );
						if ( request )
							request.abort();
					}
				});
			},
			dialog: {
				width: 500,
				dialogClass: 'wikiEditor-toolbar-dialog',
				buttons: {
					'wikieditor-toolbar-tool-link-insert': function() {
						function escapeInternalText( s ) {
							// FIXME: Should this escape [[ too? Seems to work without that
							return s.replace( /(]{2,})/g, '<nowiki>$1</nowiki>' );
						}
						function escapeExternalTarget( s ) {
							return s.replace( / /g, '%20' )
								.replace( /\[/g, '%5B' )
								.replace( /]/g, '%5D' );
						}
						function escapeExternalText( s ) {
							// FIXME: Should this escape [ too? Seems to work without that
							return s.replace( /(]+)/g, '<nowiki>$1</nowiki>' );
						}
						var insertText = '';
						var whitespace = $j( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace' );
						var target = $j( '#wikieditor-toolbar-link-int-target' ).val();
						var text = $j( '#wikieditor-toolbar-link-int-text' ).val();
						// check if the tooltips were passed as target or text
						if ( $j( '#wikieditor-toolbar-link-int-target' ).data( 'tooltip-mode' ) )
							target = "";
						if ( $j( '#wikieditor-toolbar-link-int-text' ).data( 'tooltip-mode' ) )
							text = "";
						if ( target == '' ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-link-empty' ) );
							return;
						}
						if ( $j.trim( text ) == '' ) {
							// [[Foo| ]] creates an invisible link
							// Instead, generate [[Foo|]]
							text = '';
						}
						if ( $j( '#wikieditor-toolbar-link-type-int' ).is( ':checked' ) ) {
							// FIXME: Exactly how fragile is this?
							if ( $j( '#wikieditor-toolbar-link-int-target-status-invalid' ).is( ':visible' ) ) {
								// Refuse to add links to invalid titles
								alert( mediaWiki.msg( 'wikieditor-toolbar-tool-link-int-invalid' ) );
								return;
							}

							if ( target == text || !text.length )
								insertText = '[[' + target + ']]';
							else
								insertText = '[[' + target + '|' + escapeInternalText( text ) + ']]';
						} else {
							// Prepend http:// if there is no protocol
							if ( !target.match( /^[a-z]+:\/\/./ ) )
								target = 'http://' + target;

							// Detect if this is really an internal link in disguise
							var match = target.match( $j(this).data( 'articlePathRegex' ) );
							if ( match && !$j(this).data( 'ignoreLooksInternal' ) ) {
								var buttons = { };
								var that = this;
								buttons[ mediaWiki.msg( 'wikieditor-toolbar-tool-link-lookslikeinternal-int' ) ] = function() {
									$j( '#wikieditor-toolbar-link-int-target' ).val( match[1] ).change();
									$j(this).dialog( 'close' );
								};
								buttons[ mediaWiki.msg( 'wikieditor-toolbar-tool-link-lookslikeinternal-ext' ) ] = function() {
									$j(that).data( 'ignoreLooksInternal', true );
									$j(that).closest( '.ui-dialog' ).find( 'button:first' ).click();
									$j(that).data( 'ignoreLooksInternal', false );
									$j(this).dialog( 'close' );
								};
								$j.wikiEditor.modules.dialogs.quickDialog(
									mediaWiki.msg( 'wikieditor-toolbar-tool-link-lookslikeinternal', match[1] ),
									{ buttons: buttons }
								);
								return;
							}

							var escTarget = escapeExternalTarget( target );
							var escText = escapeExternalText( text );

							if ( escTarget == escText )
								insertText = escTarget;
							else if ( text == '' )
								insertText = '[' + escTarget + ']';
							else
								insertText = '[' + escTarget + ' ' + escText + ']';
						}
						// Preserve whitespace in selection when replacing
						if ( whitespace ) insertText = whitespace[0] + insertText + whitespace[1];
						$j(this).dialog( 'close' );
						$j.wikiEditor.modules.toolbar.fn.doAction( $j(this).data( 'context' ), {
							type: 'replace',
							options: {
								pre: insertText
							}
						}, $j(this) );

						// Blank form
						$j( '#wikieditor-toolbar-link-int-target, #wikieditor-toolbar-link-int-text' ).val( '' );
						$j( '#wikieditor-toolbar-link-type-int, #wikieditor-toolbar-link-type-ext' ).attr( 'checked', '' );
					},
					'wikieditor-toolbar-tool-link-cancel': function() {
						// Clear any saved selection state
						var context = $j(this).data( 'context' );
						context.fn.restoreSelection();
						$j(this).dialog( 'close' );
					}
				},
				open: function() {
					// Cache the articlepath regex
					$j(this).data( 'articlePathRegex', new RegExp(
						'^' + $.escapeRE( mw.config.get( 'wgServer' ) + mw.config.get( 'wgArticlePath' ) )
							.replace( /\\\$1/g, '(.*)' ) + '$'
					) );
					// Pre-fill the text fields based on the current selection
					var context = $j(this).data( 'context' );
					// Restore and immediately save selection state, needed for inserting stuff later
					context.fn.restoreSelection();
					context.fn.saveSelection();
					var selection = context.$textarea.textSelection( 'getSelection' ); 
					$j( '#wikieditor-toolbar-link-int-target' ).focus();
					// Trigger the change event, so the link status indicator is up to date
					$j( '#wikieditor-toolbar-link-int-target' ).change();
					$j( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [ '', '' ] );
					if ( selection != '' ) {
						var target, text, type;
						var matches;
						if ( ( matches = selection.match( /^(\s*)\[\[([^\]\|]+)(\|([^\]\|]*))?\]\](\s*)$/ ) ) ) {
							// [[foo|bar]] or [[foo]]
							target = matches[2];
							text = ( matches[4] ? matches[4] : matches[2] );
							type = 'int';
							// Preserve whitespace when replacing
							$j( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [ matches[1], matches[5] ] );
						} else if ( ( matches = selection.match( /^(\s*)\[([^\] ]+)( ([^\]]+))?\](\s*)$/ ) ) ) {
							// [http://www.example.com foo] or [http://www.example.com]
							target = matches[2];
							text = ( matches[4] ? matches[4] : '' );
							type = 'ext';
							// Preserve whitespace when replacing
							$j( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [ matches[1], matches[5] ] );
						} else {
							// Trim any leading and trailing whitespace from the selection,
							// but preserve it when replacing
							target = text = $j.trim( selection );
							if ( target.length < selection.length ) {
								$j( '#wikieditor-toolbar-link-dialog' ).data( 'whitespace', [
									selection.substr( 0, selection.indexOf( target.charAt( 0 ) ) ),
									selection.substr(
										selection.lastIndexOf( target.charAt( target.length - 1 ) ) + 1
									) ]
								);
							}
						}

						// Change the value by calling val() doesn't trigger the change event, so let's do that ourselves
						if ( typeof text != 'undefined' )
							$j( '#wikieditor-toolbar-link-int-text' ).val( text ).change();
						if ( typeof target != 'undefined' )
							$j( '#wikieditor-toolbar-link-int-target' ).val( target ).change();
						if ( typeof type != 'undefined' )
							$j( '#wikieditor-toolbar-link-' + type ).attr( 'checked', 'checked' );
					}
					$j( '#wikieditor-toolbar-link-int-text' ).data( 'untouched',
						$j( '#wikieditor-toolbar-link-int-text' ).val() ==
								$j( '#wikieditor-toolbar-link-int-target' ).val() ||
							$j( '#wikieditor-toolbar-link-int-text' ).hasClass( 'wikieditor-toolbar-dialog-hint' )
					);
					$j( '#wikieditor-toolbar-link-int-target' ).suggestions();

					//don't overwrite user's text
					if( selection != '' ){
						$j( '#wikieditor-toolbar-link-int-text' ).data( 'untouched', false );
					}

					$j( '#wikieditor-toolbar-link-int-text, #wikiedit-toolbar-link-int-target' )
						.each( function() {
							if ( $j(this).val() == '' )
								$j(this).parent().find( 'label' ).show();
						});

					if ( !( $j(this).data( 'dialogkeypressset' ) ) ) {
						$j(this).data( 'dialogkeypressset', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$j(this).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $j(this).data( 'dialogaction' ) || $j(this).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						});

						// Make tabbing to a button and pressing
						// Enter do what people expect
						$j(this).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$j(this).closest( '.ui-dialog' ).data( 'dialogaction', this );
						});
					}
				}
			}
		},
		'insert-reference': {
			filters: [ '#wpTextbox1.toolbar-dialogs' ],
			titleMsg: 'wikieditor-toolbar-tool-reference-title',
			id: 'wikieditor-toolbar-reference-dialog',
			html: '\
			<div class="wikieditor-toolbar-dialog-wrapper">\
			<fieldset><div class="wikieditor-toolbar-table-form">\
				<div class="wikieditor-toolbar-field-wrapper">\
					<label for="wikieditor-toolbar-reference-text"\
						rel="wikieditor-toolbar-tool-reference-text"></label>\
					<input type="text" id="wikieditor-toolbar-reference-text" />\
				</div>\
			</div></fieldset>\
			</div>',
			init: function() {
				// Insert translated strings into labels
				$j( this ).find( '[rel]' ).each( function() {
					$j( this ).text( mediaWiki.msg( $j( this ).attr( 'rel' ) ) );
				} );

			},
			dialog: {
				dialogClass: 'wikiEditor-toolbar-dialog',
				width: 590,
				buttons: {
					'wikieditor-toolbar-tool-reference-insert': function() {
						var insertText = $j( '#wikieditor-toolbar-reference-text' ).val();
						var whitespace = $j( '#wikieditor-toolbar-reference-dialog' ).data( 'whitespace' );
						var attributes = $j( '#wikieditor-toolbar-reference-dialog' ).data( 'attributes' );
						// Close the dialog
						$j( this ).dialog( 'close' );
						$j.wikiEditor.modules.toolbar.fn.doAction(
							$j( this ).data( 'context' ),
							{
								type: 'replace',
								options: {
									pre: whitespace[0] + '<ref' + attributes + '>',
									peri: insertText,
									post: '</ref>' + whitespace[1]
								}
							},
							$j( this )
						);
						// Restore form state
						$j( '#wikieditor-toolbar-reference-text' ).val( "" );
					},
					'wikieditor-toolbar-tool-reference-cancel': function() {
						// Clear any saved selection state
						var context = $j( this ).data( 'context' );
						context.fn.restoreSelection();
						$j( this ).dialog( 'close' );
					}
				},
				open: function() {
					// Pre-fill the text fields based on the current selection
					var context = $j(this).data( 'context' );
					// Restore and immediately save selection state, needed for inserting stuff later
					context.fn.restoreSelection();
					context.fn.saveSelection();
					var selection = context.$textarea.textSelection( 'getSelection' ); 
					// set focus
					$j( '#wikieditor-toolbar-reference-text' ).focus();
					$j( '#wikieditor-toolbar-reference-dialog' )
						.data( 'whitespace', [ '', '' ] )
						.data( 'attributes', '' );
					if ( selection != '' ) {
						var matches, text;
						if ( ( matches = selection.match( /^(\s*)<ref([^\>]*)>([^\<]*)<\/ref\>(\s*)$/ ) ) ) {
							text = matches[3];
							// Preserve whitespace when replacing
							$j( '#wikieditor-toolbar-reference-dialog' ).data( 'whitespace', [ matches[1], matches[4] ] );
							$j( '#wikieditor-toolbar-reference-dialog' ).data( 'attributes', matches[2] );
						} else {
							text = selection;
						}
						$j( '#wikieditor-toolbar-reference-text' ).val( text );
					}
					if ( !( $j( this ).data( 'dialogkeypressset' ) ) ) {
						$j( this ).data( 'dialogkeypressset', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$j( this ).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $j( this ).data( 'dialogaction' ) || $j( this ).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						} );
						// Make tabbing to a button and pressing
						// Enter do what people expect
						$j( this ).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$j( this ).closest( '.ui-dialog' ).data( 'dialogaction', this );
						} );
					}
				}
			}
		},
		'insert-table': {
			// For now, apply the old browser and iframe requirements to the link and table dialogs as well
			// This'll be removed once these dialogs are confirmed stable without the iframe and/or in more browsers
			filters: [ '#wpTextbox1.toolbar-dialogs' ],
			titleMsg: 'wikieditor-toolbar-tool-table-title',
			id: 'wikieditor-toolbar-table-dialog',
			// FIXME: Localize 'x'?
			html: '\
				<div class="wikieditor-toolbar-dialog-wrapper">\
				<fieldset><div class="wikieditor-toolbar-table-form">\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-table-dimensions-header" checked />\
						<label for="wikieditor-toolbar-table-dimensions-header"\
							rel="wikieditor-toolbar-tool-table-dimensions-header"></label>\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-table-wikitable" checked />\
						<label for="wikieditor-toolbar-table-wikitable" rel="wikieditor-toolbar-tool-table-wikitable"></label>\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-table-sortable" />\
						<label for="wikieditor-toolbar-table-sortable" rel="wikieditor-toolbar-tool-table-sortable"></label>\
					</div>\
					<div class="wikieditor-toolbar-table-dimension-fields">\
						<div class="wikieditor-toolbar-field-wrapper">\
							<label for="wikieditor-toolbar-table-dimensions-rows"\
								rel="wikieditor-toolbar-tool-table-dimensions-rows"></label><br />\
							<input type="text" id="wikieditor-toolbar-table-dimensions-rows" size="4" />\
						</div>\
						<div class="wikieditor-toolbar-field-wrapper">\
							<label for="wikieditor-toolbar-table-dimensions-columns"\
								rel="wikieditor-toolbar-tool-table-dimensions-columns"></label><br />\
							<input type="text" id="wikieditor-toolbar-table-dimensions-columns" size="4" />\
						</div>\
					</div>\
				</div></fieldset>\
				<div class="wikieditor-toolbar-table-preview-wrapper" >\
					<span rel="wikieditor-toolbar-tool-table-example"></span>\
					<div class="wikieditor-toolbar-table-preview-content">\
						<table id="wikieditor-toolbar-table-preview" class="wikieditor-toolbar-table-preview wikitable">\
						<thead>\
							<tr class="wikieditor-toolbar-table-preview-header">\
								<th rel="wikieditor-toolbar-tool-table-example-header"></th>\
								<th rel="wikieditor-toolbar-tool-table-example-header"></th>\
								<th rel="wikieditor-toolbar-tool-table-example-header"></th>\
							</tr>\
						</thead><tbody>\
							<tr class="wikieditor-toolbar-table-preview-hidden" style="display: none;">\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr><tr>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr><tr>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr><tr>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
								<td rel="wikieditor-toolbar-tool-table-example-cell-text"></td>\
							</tr>\
						</tbody>\
						</table>\
					</div>\
				</div></div>',
			init: function() {
				$j(this).find( '[rel]' ).each( function() {
					$j(this).text( mediaWiki.msg( $j(this).attr( 'rel' ) ) );
				});
				// Set tabindexes on form fields
				$j.wikiEditor.modules.dialogs.fn.setTabindexes( $j(this).find( 'input' ).not( '[tabindex]' ) );

				$j( '#wikieditor-toolbar-table-dimensions-rows' ).val( 3 );
				$j( '#wikieditor-toolbar-table-dimensions-columns' ).val( 3 );
				$j( '#wikieditor-toolbar-table-wikitable' ).click( function() {
					$j( '.wikieditor-toolbar-table-preview' ).toggleClass( 'wikitable' );
				});

				// Hack for sortable preview: dynamically adding
				// sortable class doesn't work, so we use a clone
				$j( '#wikieditor-toolbar-table-preview' )
					.clone()
					.attr( 'id', 'wikieditor-toolbar-table-preview2' )
					.addClass( 'sortable' )
					.insertAfter( $j( '#wikieditor-toolbar-table-preview' ) )
					.hide();
				if ( typeof jQuery.fn.tablesorter == 'function' )
						$j( '#wikieditor-toolbar-table-preview2' ).tablesorter();
				$j( '#wikieditor-toolbar-table-sortable' ).click( function() {
					// Swap the currently shown one clone with the other one
					$j( '#wikieditor-toolbar-table-preview' )
						.hide()
						.attr( 'id', 'wikieditor-toolbar-table-preview3' );
					$j( '#wikieditor-toolbar-table-preview2' )
						.attr( 'id', 'wikieditor-toolbar-table-preview' )
						.show();
					$j( '#wikieditor-toolbar-table-preview3' ).attr( 'id', 'wikieditor-toolbar-table-preview2' );
				});

				$j( '#wikieditor-toolbar-table-dimensions-header' ).click( function() {
					// Instead of show/hiding, switch the HTML around
					// We do this because the sortable tables script styles the first row,
					// visible or not
					var headerHTML = $j( '.wikieditor-toolbar-table-preview-header' ).html();
					var hiddenHTML = $j( '.wikieditor-toolbar-table-preview-hidden' ).html();
					$j( '.wikieditor-toolbar-table-preview-header' ).html( hiddenHTML );
					$j( '.wikieditor-toolbar-table-preview-hidden' ).html( headerHTML );
					if ( typeof jQuery.fn.tablesorter == 'function' ) {
							$( '#wikieditor-toolbar-table-preview, #wikieditor-toolbar-table-preview2' )
								.filter( '.sortable' )
								.tablesorter();
					}
				});

			},
			dialog: {
				resizable: false,
				dialogClass: 'wikiEditor-toolbar-dialog',
				width: 590,
				buttons: {
					'wikieditor-toolbar-tool-table-insert': function() {
						var rowsVal = $j( '#wikieditor-toolbar-table-dimensions-rows' ).val();
						var colsVal = $j( '#wikieditor-toolbar-table-dimensions-columns' ).val();
						var rows = parseInt( rowsVal, 10 );
						var cols = parseInt( colsVal, 10 );
						var header = $j( '#wikieditor-toolbar-table-dimensions-header' ).is( ':checked' ) ? 1 : 0;
						if ( isNaN( rows ) || isNaN( cols ) || rows != rowsVal  || cols != colsVal ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-table-invalidnumber' ) );
							return;
						}
						if ( rows + header == 0 || cols == 0 ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-table-zero' ) );
							return;
						}
						if ( rows * cols > 1000 ) {
							alert( mediaWiki.msg( 'wikieditor-toolbar-tool-table-toomany', 1000 ) );
							return;
						}
						var headerText = mediaWiki.msg( 'wikieditor-toolbar-tool-table-example-header' );
						var normalText = mediaWiki.msg( 'wikieditor-toolbar-tool-table-example' );
						var table = "";
						for ( var r = 0; r < rows + header; r++ ) {
							table += "|-\n";
							for ( var c = 0; c < cols; c++ ) {
								var isHeader = ( header && r == 0 );
								var delim = isHeader ? '!' : '|';
								if ( c > 0 ) {
									delim += delim;
								}
								table += delim + ' ' + ( isHeader ? headerText : normalText ) + ' ';
							}
							// Replace trailing space by newline
							// table[table.length - 1] is read-only
							table = table.substr( 0, table.length - 1 ) + "\n";
						}
						var classes = [];
						if ( $j( '#wikieditor-toolbar-table-wikitable' ).is( ':checked' ) )
							classes.push( 'wikitable' );
						if ( $j( '#wikieditor-toolbar-table-sortable' ).is( ':checked' ) )
							classes.push( 'sortable' );
						var classStr = classes.length > 0 ? ' class="' + classes.join( ' ' ) + '"' : '';
						$j(this).dialog( 'close' );
						$j.wikiEditor.modules.toolbar.fn.doAction(
							$j(this).data( 'context' ),
							{
								type: 'replace',
								options: {
									pre: '{|' + classStr + "\n",
									peri: table,
									post: '|}',
									ownline: true
								}
							},
							$j(this)
						);

						// Restore form state
							$j( '#wikieditor-toolbar-table-dimensions-rows' ).val( 3 );
							$j( '#wikieditor-toolbar-table-dimensions-columns' ).val( 3 );
						// Simulate clicks instead of setting values, so the according
						// actions are performed
							if ( !$j( '#wikieditor-toolbar-table-dimensions-header' ).is( ':checked' ) )
								$j( '#wikieditor-toolbar-table-dimensions-header' ).click();
							if ( !$j( '#wikieditor-toolbar-table-wikitable' ).is( ':checked' ) )
								$j( '#wikieditor-toolbar-table-wikitable' ).click();
							if ( $j( '#wikieditor-toolbar-table-sortable' ).is( ':checked' ) )
								$j( '#wikieditor-toolbar-table-sortable' ).click();
					},
					'wikieditor-toolbar-tool-table-cancel': function() {
						$j(this).dialog( 'close' );
					}
				},
				open: function() {
					$j( '#wikieditor-toolbar-table-dimensions-rows' ).focus();
					if ( !( $j(this).data( 'dialogkeypressset' ) ) ) {
						$j(this).data( 'dialogkeypressset', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$j(this).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $j(this).data( 'dialogaction' ) || $j(this).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						});

						// Make tabbing to a button and pressing
						// Enter do what people expect
						$j(this).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$j(this).closest( '.ui-dialog' ).data( 'dialogaction', this );
						});
					}
				}
			}
		},
		'search-and-replace': {
			'browsers': {
				// Left-to-right languages
				'ltr': {
					'msie': false,
					'firefox': [['>=', 2]],
					'opera': false,
					'safari': [['>=', 3]],
					'chrome': [['>=', 3]]
				},
				// Right-to-left languages
				'rtl': {
					'msie': false,
					'firefox': [['>=', 2]],
					'opera': false,
					'safari': [['>=', 3]],
					'chrome': [['>=', 3]]
				}
			},
			filters: [ '#wpTextbox1.toolbar-dialogs' ],
			titleMsg: 'wikieditor-toolbar-tool-replace-title',
			id: 'wikieditor-toolbar-replace-dialog',
			html: '\
				<div id="wikieditor-toolbar-replace-message">\
					<div id="wikieditor-toolbar-replace-nomatch" rel="wikieditor-toolbar-tool-replace-nomatch"></div>\
					<div id="wikieditor-toolbar-replace-success"></div>\
					<div id="wikieditor-toolbar-replace-emptysearch" rel="wikieditor-toolbar-tool-replace-emptysearch"></div>\
					<div id="wikieditor-toolbar-replace-invalidregex"></div>\
				</div>\
				<fieldset>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-replace-search" rel="wikieditor-toolbar-tool-replace-search"></label>\
						<input type="text" id="wikieditor-toolbar-replace-search" style="width: 100%;" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<label for="wikieditor-toolbar-replace-replace" rel="wikieditor-toolbar-tool-replace-replace"></label>\
						<input type="text" id="wikieditor-toolbar-replace-replace" style="width: 100%;" />\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-replace-case" />\
						<label for="wikieditor-toolbar-replace-case" rel="wikieditor-toolbar-tool-replace-case"></label>\
					</div>\
					<div class="wikieditor-toolbar-field-wrapper">\
						<input type="checkbox" id="wikieditor-toolbar-replace-regex" />\
						<label for="wikieditor-toolbar-replace-regex" rel="wikieditor-toolbar-tool-replace-regex"></label>\
					</div>\
				</fieldset>',
			init: function() {
				$j(this).find( '[rel]' ).each( function() {
					$j(this).text( mediaWiki.msg( $j(this).attr( 'rel' ) ) );
				});
				// Set tabindexes on form fields
				$j.wikiEditor.modules.dialogs.fn.setTabindexes( $j(this).find( 'input' ).not( '[tabindex]' ) );

				// TODO: Find a cleaner way to share this function
				$j(this).data( 'replaceCallback', function( mode ) {
					$j( '#wikieditor-toolbar-replace-nomatch, #wikieditor-toolbar-replace-success, #wikieditor-toolbar-replace-emptysearch, #wikieditor-toolbar-replace-invalidregex' ).hide();
					var searchStr = $j( '#wikieditor-toolbar-replace-search' ).val();
					if ( searchStr == '' ) {
						$j( '#wikieditor-toolbar-replace-emptysearch' ).show();
						return;
					}
					var replaceStr = $j( '#wikieditor-toolbar-replace-replace' ).val();
					var flags = 'm';
					var matchCase = $j( '#wikieditor-toolbar-replace-case' ).is( ':checked' );
					var isRegex = $j( '#wikieditor-toolbar-replace-regex' ).is( ':checked' );
					if ( !matchCase ) {
						flags += 'i';
					}
					if ( mode == 'replaceAll' ) {
						flags += 'g';
					}
					if ( !isRegex ) {
						searchStr = $.escapeRE( searchStr );
					}
					try {
						var regex = new RegExp( searchStr, flags );
					} catch( e ) {
						$j( '#wikieditor-toolbar-replace-invalidregex' )
							.text( mediaWiki.msg( 'wikieditor-toolbar-tool-replace-invalidregex',
								e.message ) )
							.show();
						return;
					}
					var $textarea = $j(this).data( 'context' ).$textarea;
					var text = $textarea.textSelection( 'getContents' );
					var match = false;
					var offset, s;
					if ( mode != 'replaceAll' ) {
						offset = $j(this).data( 'offset' );
						s = text.substr( offset );
						match = s.match( regex );
					}
					if ( !match ) {
						// Search hit BOTTOM, continuing at TOP
						offset = 0;
						s = text;
						match = s.match( regex );
					}

					if ( !match ) {
						$j( '#wikieditor-toolbar-replace-nomatch' ).show();
					} else if ( mode == 'replaceAll' ) {
						// Instead of using repetitive .match() calls, we use one .match() call with /g
						// and indexOf() followed by substr() to find the offsets. This is actually
						// faster because our indexOf+substr loop is faster than a match loop, and the
						// /g match is so ridiculously fast that it's negligible.
						var index;
						for ( var i = 0; i < match.length; i++ ) {
							index = s.indexOf( match[i] );
							if ( index == -1 ) {
								// This shouldn't happen
								break;
							}
							s = s.substr( index + match[i].length );

							var start = index + offset;
							var end = start + match[i].length;
							var newEnd = start + replaceStr.length;
							$textarea
								.textSelection( 'setSelection', { 'start': start, 'end': end } )
								.textSelection( 'encapsulateSelection', {
										'peri': replaceStr,
										'replace': true } )
								.textSelection( 'setSelection', { 'start': start, 'end': newEnd } );
							offset = newEnd;
						}
						$j( '#wikieditor-toolbar-replace-success' )
							.text( mediaWiki.msg( 'wikieditor-toolbar-tool-replace-success', match.length ) )
							.show();
						$j(this).data( 'offset', 0 );
					} else {
						var start = match.index + offset;
						var end = start + match[0].length;
						var newEnd = start + replaceStr.length;
						var context = $j( this ).data( 'context' );
						$textarea.textSelection( 'setSelection', { 'start': start,
							'end': end } );
						if ( mode == 'replace' ) {
							$textarea
								.textSelection( 'encapsulateSelection', {
									'peri': replaceStr,
									'replace': true } )
								.textSelection( 'setSelection', {
									'start': start,
									'end': newEnd } );
						}
						$textarea.textSelection( 'scrollToCaretPosition' );
						$textarea.textSelection( 'setSelection', { 'start': start,
							'end': mode == 'replace' ? newEnd : end } );
						$j( this ).data( 'offset', mode == 'replace' ? newEnd : end );
						var textbox = typeof context.$iframe != 'undefined' ? context.$iframe[0].contentWindow : $textarea[0];
						textbox.focus();
					}
				});
			},
			dialog: {
				width: 500,
				dialogClass: 'wikiEditor-toolbar-dialog',
				buttons: {
					'wikieditor-toolbar-tool-replace-button-findnext': function( e ) {
						$j(this).closest( '.ui-dialog' ).data( 'dialogaction', e.target );
						$j(this).data( 'replaceCallback' ).call( this, 'find' );
					},
					'wikieditor-toolbar-tool-replace-button-replacenext': function( e ) {
						$j(this).closest( '.ui-dialog' ).data( 'dialogaction', e.target );
						$j(this).data( 'replaceCallback' ).call( this, 'replace' );
					},
					'wikieditor-toolbar-tool-replace-button-replaceall': function( e ) {
						$j(this).closest( '.ui-dialog' ).data( 'dialogaction', e.target );
						$j(this).data( 'replaceCallback' ).call( this, 'replaceAll' );
					},
					'wikieditor-toolbar-tool-replace-close': function() {
						$j(this).dialog( 'close' );
					}
				},
				open: function() {
					$j(this).data( 'offset', 0 );
					$j( '#wikieditor-toolbar-replace-search' ).focus();
					$j( '#wikieditor-toolbar-replace-nomatch, #wikieditor-toolbar-replace-success, #wikieditor-toolbar-replace-emptysearch, #wikieditor-toolbar-replace-invalidregex' ).hide();
					if ( !( $j(this).data( 'onetimeonlystuff' ) ) ) {
						$j(this).data( 'onetimeonlystuff', true );
						// Execute the action associated with the first button
						// when the user presses Enter
						$j(this).closest( '.ui-dialog' ).keypress( function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								var button = $j(this).data( 'dialogaction' ) || $j(this).find( 'button:first' );
								button.click();
								e.preventDefault();
							}
						});
						// Make tabbing to a button and pressing
						// Enter do what people expect
						$j(this).closest( '.ui-dialog' ).find( 'button' ).focus( function() {
							$j(this).closest( '.ui-dialog' ).data( 'dialogaction', this );
						});
					}
					var dialog = $j(this).closest( '.ui-dialog' );
					var that = this;
					var context = $j(this).data( 'context' );
					var textbox = typeof context.$iframe != 'undefined' ?
						context.$iframe[0].contentWindow.document : context.$textarea;

					$j( textbox )
						.bind( 'keypress.srdialog', function( e ) {
							if ( ( e.keyCode || e.which ) == 13 ) {
								// Enter
								var button = dialog.data( 'dialogaction' ) || dialog.find( 'button:first' );
								button.click();
								e.preventDefault();
							} else if ( ( e.keyCode || e.which ) == 27 ) {
								// Escape
								$j(that).dialog( 'close' );
							}
						});
				},
				close: function() {
					var context = $j(this).data( 'context' );
					var textbox = typeof context.$iframe != 'undefined' ?
						context.$iframe[0].contentWindow.document : context.$textarea;
					$j( textbox ).unbind( 'keypress.srdialog' );
					$j(this).closest( '.ui-dialog' ).data( 'dialogaction', false );
				}
			}
		}
	}
};
