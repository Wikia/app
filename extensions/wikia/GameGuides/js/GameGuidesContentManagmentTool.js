/* global wgNamespaceIds, wgFormattedNamespaces, mw, wgServer, wgScript */
$(function(){
	require(['jquery', 'wikia.nirvana', 'JSMessages'], function($, nirvana, msg){
		'use strict';

		var d = document,
			category = mw.config.get('categoryTemplate'),
			tag = mw.config.get('tagTemplate'),
			duplicateError = msg('wikiagameguides-content-duplicate-entry'),
			requiredError = msg('wikiagameguides-content-required-entry'),
			emptyTagError = msg('wikiagameguides-content-empty-tag'),
			categoryError = msg('wikiagameguides-content-category-error'),
			addCategory = d.getElementById('addCategory'),
			addTag = d.getElementById('addTag'),
			$save = $(d.getElementById('save')),
			form = d.getElementById('contentManagmentForm'),
			$form = $(form),
			ul = form.getElementsByTagName('ul')[0],
			$ul = $(ul),
			//it looks better if we display in input category name without Category:
			categoryId = wgNamespaceIds.category,
			categoryName = wgFormattedNamespaces[categoryId] + ':',
			setup = function(elem){
				(elem || $ul.find('.cat-input')).autocomplete({
					serviceUrl: wgServer + wgScript,
					params: {
						action: 'ajax',
						rs: 'getLinkSuggest',
						format: 'json',
						ns: categoryId
					},
					appendTo: form,
					onSelect: function(){
						$ul.find('input:focus').next().focus();
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
					deferRequestBy: 50,
					minLength: 3,
					skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
				});
			},
			addNew = function(row, elem){
				elem = elem || $ul.children(':last');

				elem.after(row);
				setup(elem.next().find('.cat-input'));
				elem.next().find('input').first().focus();
				$ul.sortable('refresh');
			},
			checkInputs = function(elements, checkEmpty, required){
				var names = [];

				elements.each(function(){
					var val = this.value;

					if(required && val === '') {
						$(this)
							.addClass('error')
							.popover('destroy')
							.popover({
								content: requiredError
							});
					} else if(!~names.indexOf(val)) {
						names.push(val);

						$(this)
							.removeClass('error')
							.popover('destroy');

					}else if(checkEmpty || val !== ''){
						$(this)
							.addClass('error')
							.popover('destroy')
							.popover({
								content: duplicateError
							});
					}
				});
			},
			checkForm = function(){

				$save.removeClass();

				checkInputs($ul.find('.tag-input'), true);
				checkInputs($ul.find('.cat-input'), true, true);

				$ul.find('.tag').each(function(){
					var $t = $(this),
						$categories = $t.nextUntil('.tag');

					if($categories.length === 0) {
						$t.find('.tag-input')
							.addClass('error')
							.popover('destroy')
							.popover({
								content: emptyTagError
							});
					}else {
						checkInputs($categories.find('.name'))
					}
				});

				if(d.getElementsByClassName('error').length > 0){
					$save.attr('disabled', true);
					return false;
				}else{
					$save.attr('disabled', false);
					return true;
				}
			};

		$form
			.on('focus', 'input', function(){
				checkForm();
			})
			.on('click', '.remove', function(){
				ul.removeChild(this.parentElement);
				checkForm();
			})
			.on('blur', 'input', function(){
				var val = $.trim(this.value);

				if(this.className == 'cat-input') {
					val = val.replace(/ /g, '_');
				}

				this.value = val;

				checkForm();
			})
			.on('keypress', '.name', function(ev){
				if(ev.keyCode === 13) addNew(category, $(this).parent());
			})
			.on('keypress', '.cat-input', function(ev){
				if(ev.keyCode === 13) $(this).next().focus();
			})
			.on('keypress', '.tag-input', function(ev){
				if(ev.keyCode === 13) $(this).next().focus();
			});

		addCategory.addEventListener('click', function(){
			addNew(category);
		});

		addTag.addEventListener('click', function(){
			addNew(tag);
		});

		function getData(li) {
			li = $(li);

			return {
				title: li.find('.cat-input').val(),
				label: li.find('.name').val()
			}
		}

		$save.click(function(){
			var data = [],
				nonames = [];

			if(checkForm()) {
				$ul.find('.category:not(.tag ~ .category)').each(function(){
					nonames.push(getData(this));
				});

				$ul.find('.tag').each(function(){
					var $t = $(this),
						name = $t.find('.tag-input').val(),
						categories = [];

					$t.nextUntil('.tag').each(function(){
						(name ? categories : nonames).push(getData(this));
					});

					if(name) {
						data.push({
							title: name,
							categories: categories
						});
					}
				});

				if(nonames.length > 0) {
					data.push({title: '', categories: nonames});
				}

				$save.removeClass();

				nirvana.sendRequest({
					controller: 'GameGuidesSpecialContent',
					method: 'save',
					data: {
						tags: data
					}
				}).done(
					function(data){
						if(data.error) {
							var err = data.error,
								i = err.length,
								categories = $form.find('.cat-input');

							while(i--){
								//I cannot use value CSS selector as I want to use current value
								categories.each(function(){
									if(this.value === err[i]){
										$(this)
											.addClass('error')
											.popover('destroy')
											.popover({
												content: categoryError
											});

										return false;
									}
									return true;
								});
							}

							$save.addClass('err');
						}else if(data.status){
							$save.addClass('ok');
						}
				}).fail(
					function(){
						$save.addClass('err');
					}
				);
			}
		});

		//be sure this module is ready to be used
		mw.loader.using(['jquery.autocomplete', 'jquery.ui.sortable'], function(){
			$ul.sortable({
				opacity: 0.5,
				axis: 'y',
				containment: '#contentManagmentForm',
				cursor: 'move',
				handle: '.drag',
				placeholder: 'drop',
				update: function(){
					checkForm();
				}
			});

			setup();
		});
	});
});