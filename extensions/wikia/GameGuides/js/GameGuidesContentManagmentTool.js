/* global wgNamespaceIds, wgFormattedNamespaces, mw, wgServer, wgScript */
$(function(){
	require(['jquery', 'wikia.nirvana', 'JSMessages', 'wikia.loader', 'wikia.mustache'], function($, nirvana, msg, loader, mustache){
		'use strict';

		var category,
			tag;

		loader({
			type: loader.MULTI,
			resources: {
				mustache: '/extensions/wikia/GameGuides/templates/GameGuidesSpecialContent_category.mustache,/extensions/wikia/GameGuides/templates/GameGuidesSpecialContent_tag.mustache'
			}
		}).done(
			function(res){
				//prepare html to be injected in ul
				category = mustache.render(res.mustache[0], {
					category_placeholder: msg('wikiagameguides-content-category'),
					name_placeholder: msg('wikiagameguides-content-name')
				});

				tag = mustache.render(res.mustache[1], {
					tag_placeholder:  msg('wikiagameguides-content-tag')
				});
			}
		);

		//be sure this module is ready to be used
		mw.loader.using(['jquery.autocomplete', 'jquery.ui.sortable'], function(){
			var d = document,
				addCategory = d.getElementById('addCategory'),
				addTag = d.getElementById('addTag'),
				save = d.getElementById('save'),
				form = d.getElementById('contentManagmentForm'),
				$form = $(form),
				status = d.getElementById('status'),
				ul = form.getElementsByTagName('ul')[0],
				$ul = $(ul),
				//it looks better if we display in input category name without Category:
				categoryId = wgNamespaceIds.category,
				categoryName = wgFormattedNamespaces[categoryId] + ':',
				//list of all tags, so we can suggest them to a user
				tags = [],
				setup = function(last){
					$form.find('.category' + (last ? ':last': '')).autocomplete({
						serviceUrl: wgServer + wgScript,
						params: {
							action: 'ajax',
							rs: 'getLinkSuggest',
							format: 'json',
							ns: categoryId
						},
						appendTo: form,
						onSelect: function(){
							$form.find('input:focus').next().focus();
						},
						fnPreprocessResults: function(data){
							var suggestions = data.suggestions,
								suggestion,
								l = suggestions.length,
								i = 0;

							for(; i < l; i++) {
								suggestion = suggestions[i];
								//get rid of non categories suggestions
								//and 'Category:' part of suggestion
								if(suggestion.indexOf(categoryName) > -1) {
									suggestions[i] = suggestion.replace(categoryName, '');
								}else{
									delete suggestions[i];
								}
							}

							data.suggestions = suggestions;
							return data;
						},
						deferRequestBy: 100,
						minLength: 3,
						zIndex: 9999,
						width: 200,
						skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
					});

					$form.find('.name' + (last ? ':last' : '')).on('keydown', function(ev){
						if(ev.keyCode === 13) addNew(category);
					});
				},
				addNew = function(row){
					ul.insertAdjacentHTML('beforeend', row);
					setup(true);
					$ul.find('.category').last().focus();
					$ul.sortable("refresh");
				},
				grabTags = function(){
					$('.tag').each(function(){
						var val = this.value;
						if(val && tags.indexOf(val) === -1) tags.push(val);
					});
				},
				findDuplicates = function(elements){
					var names = [];

					elements.each(function(){
						var val = this.value;
						if(names.indexOf(val) === -1) {
							names.push(val);
							this.className = this.className.replace(' error', '');
							$(this).popover('destroy');
						}else if(val !== ''){
							$(this).popover('destroy').popover({
								content: msg('wikiagameguides-content-duplicate-entry')
							});
							if(this.className.indexOf('error') === -1) this.className += ' error';
						}
					});
				},
				checkSave = function(){
					if(d.getElementsByClassName('error').length > 0){
						save.setAttribute('disabled', '');
					}else{
						save.removeAttribute('disabled');
					}
				};

			$form
				.on('focus', '.category, .name', function(){
					this.className = this.className.replace(' error', '');
				})
				.on('click', '.remove', function(){
					ul.removeChild(this.parentElement);
				})
				.on('blur', '.tag', function(){
					findDuplicates($form.find('.tag input'));

					checkSave();
				})
				.on('blur', '.category', function(){
					this.value = $.trim(this.value).replace(/ /g, '_');

					findDuplicates($form.find('.category'));

					checkSave();
				})
				.on('blur', '.name', function(){
					var tag,
						i = 0;

					this.value = $.trim(this.value);

					while(tag = tags[i++]) {
						findDuplicates($('.tag[value="' + tag + '"] ~ input'));
					}

					checkSave();
				});

			addCategory.addEventListener('click', function(){
				addNew(category);
			});

			addTag.addEventListener('click', function(){
				addNew(tag);
			});

			save.addEventListener('click', function(){
				var categories = form.getElementsByTagName('li'),
					length = categories.length,
					cat = {},
					i = 0;

				for(; i < length; i++){
					var category = categories[i],
						children = category.children,
						catName = children[0].value;

					if(catName){
						cat[catName] = {
							tag: children[1].value,
							name: children[2].value
						};
					}
				}

				status.className = '';

				nirvana.sendRequest({
					controller: 'GameGuidesSpecialContent',
					method: 'save',
					data: {
						categories: cat
					},
					callback: function(data){
						if(data.error) {
							var err = data.error,
								i = err.length,
								categories = $form.find('.category');

							while(i--){
								categories.each(function(){
									if(this.value === err[i]){
										$(this).popover('destroy').popover({
											content: msg('wikiagameguides-content-category-error')
										});
										if(this.className.indexOf('error') === -1) this.className += ' error';
										return false;
									}
									return true;
								});
							}
						}else if(data.status){
							status.className = 'ok';
							setTimeout(function(){
								status.className = '';
							},5000);
						}
					}
				});
			});

			$(ul).sortable({
				opacity: 0.5,
				axis: 'y',
				containment: '#contentManagmentForm',
				cursor: 'move',
				handle: '.drag',
				placeholder: 'drop'
			});

	//		var openWMU = function(){
	//			loader(
	//				{
	//					type: loader.LIBRARY,
	//					resources: ['yui', 'jqueryAIM']
	//				},
	//				'/extensions/wikia/WikiaMiniUpload/css/WMU.scss',
	//				'/extensions/wikia/WikiaMiniUpload/js/WMU.js'
	//			).done(
	//				function() {
	//					openWMU = function(){
	//						WMU_skipDetails = true;
	//						WMU_show();
	//						WMU_openedInEditor = false;
	//					};
	//
	//					openWMU();
	//				}
	//			);
	//		};
	//
	//
	//		$form.on('click', '.photo', openWMU);
	//
	//		$(window).bind('WMU_addFromSpecialPage', function(event, wmuData) {
	//			var filePageUrl = window.location.protocol + '//' + window.location.host + '/' + wmuData.imageTitle;
	//
	//			console.log(wmuData);
	//			console.log(filePageUrl)
	//		});

			grabTags();
			setup();
		});
	});
});