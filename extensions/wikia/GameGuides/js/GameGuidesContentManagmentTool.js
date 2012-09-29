/* global wgNamespaceIds, wgFormattedNamespaces, mw, wgServer, wgScript */
$(function(){
	'use strict';

	//be sure this module is ready to be used
	mw.loader.using('jquery.autocomplete', function(){
		var d = document,
			add = d.getElementById('addCategory'),
			save = d.getElementById('save'),
			form = d.getElementById('contentManagmentForm'),
			$form = $(form),
			status = d.getElementById('status'),
			ul = form.getElementsByTagName('ul')[0],
			//it looks better if we display in input category name without Category:
			categoryId = window.wgNamespaceIds.category,
			categoryName = window.wgFormattedNamespaces[categoryId] + ':',
			//prepare html to be injected in ul
			row = '<li><input class=category placeholder="' + $.msg('wikiagameguides-content-category') + '" /><input class=tag placeholder="' + $.msg('wikiagameguides-content-tag') + '" /><input class=name placeholder="' + $.msg('wikiagameguides-content-name') + '" /><button class="remove secondary">X</button></li>',
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

				$form.find('.tag' + (last ? ':last' : '')).autocomplete({
					lookup: tags,
					appendTo: form,
					onSelect: function(){
						$form.find('input:focus').next().focus();
					},
					zIndex: 9999,
					width: 200,
					skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
				});

				$form.find('.name' + (last ? ':last' : '')).on('keydown', function(ev){
					if(ev.keyCode === 13) addNew();
				});
			},
			addNew = function(){
				ul.insertAdjacentHTML('beforeend', row);
				setup(true);
				$(ul).find('.category').last().focus();
			},
			grabTags = function(){
				tags.length = 0;
				$('.tag').each(function(){
					var val = this.value;
					if(val && tags.indexOf(val) === -1) tags.push(val);
				});
			};

		$form
			.on('focus', '.category, .name', function(){
				this.className = this.className.replace(' error', '');
			})
			.on('click', '.remove', function(){
				ul.removeChild(this.parentElement);
			})
			.on('blur', '.tag', function(){
				grabTags();
			})
			.on('blur', '.category, .name', function(){
				var names = [];

				$form.find(this.className.indexOf('category') > -1 ? '.category' : '.name').each(function(){
					var val = this.value;
					if(names.indexOf(val) === -1) {
						names.push(val);
						this.className = this.className.replace(' error', '');
						$(this).popover('destroy');
					}else if(val !== ''){
						$(this).popover('destroy').popover({
							content: $.msg('wikiagameguides-content-duplicate-entry')
						});
						if(this.className.indexOf('error') === -1) this.className += ' error';
					}
				});

				if(d.getElementsByClassName('error').length > 0){
					save.setAttribute('disabled', '');
				}else{
					save.removeAttribute('disabled');
				}
			});

		add.addEventListener('click', addNew);

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

			$.nirvana.sendRequest({
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
										content: $.msg('wikiagameguides-content-category-error')
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

		grabTags();
		setup();
	});
});