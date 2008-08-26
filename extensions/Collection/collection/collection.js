/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) 2008, PediaPress GmbH
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */


/******************************************************************************/

var requiredVersion = '1.0pre';

/******************************************************************************/

/** Shorcut for document.getElementByID()
 */
function $(id) {
	return document.getElementById(id);
};

/**
 * Attach event handler hookFunct to event of type hookName of element
 *
 * @param string or [] hookNames event type(s) (e.g. 'click' or ['laod', 'submit'])
 * @param function hookFunc event handler
 * @param Element element element to attach event handler to
 */
function hookEventOnElement(hookNames, hookFunct, element) {
	if (!element) {
		return;
	}
	if (typeof hookNames == 'string') {
		hookNames = [hookNames];
	}
	forEach(hookNames, function(i, hookName) {
		if (element.addEventListener) {
			element.addEventListener(hookName, hookFunct, false);
		} else if (element.attachEvent) {
			element.attachEvent("on" + hookName, hookFunct);
		}	
	});
}

/**
 * Call function fn with the index and the value of the elments of array.
 * Break the loop if fn returns false.
 *
 * @param Array array array to iterate over
 * @param function fn function to call for each element
 */
function forEach(array, fn) {
	for (var i = 0; i < array.length; i++) {
		if (fn(i, array[i]) == false) {
			break;
		}
	}
}

/**
 * Return text of element with given id. Optionally replace %PARAM% with value
 * of param. This allows usage of localization features in PHP from JavaScript.
 *
 * @param String id elment ID of elment containing text
 * @param String param optionally, a text to replace %PARAM% with
 * @return String text of elment with ID id
 */
function gettext(id, param/*=null*/) {
	var txt = document.getElementById(id).firstChild.nodeValue;
	if (param) {
		txt = txt.replace(/%PARAM%/g, param);
	}
	return txt;
}

/**
 * Strip whitespace from beginning and end of a string
 */
function trim(s) {
	return s.replace(/^\s+|\s+$/g, '');
}

/******************************************************************************/

function Collection() {};

Collection.prototype = {
	items: [],
	observers: [],

	getItems: function() {
		var self = this;
		sajax_request_type = "GET";
		try {
			sajax_do_call('wfAjaxGetCollection', [], function(xhr) {
				var result;
				try {
					result = JSON.parse(xhr.responseText);
				} catch(e) {
					alert(gettext('errorResponseText'));
					return;
				}
				self.deserialize(result.collection);
				self.notify();
			});
		} catch (e) {
			alert('XMLHttpRequest failed: ' + e);
		}
	},

	setItems: function(items) {
		this.items = items;
		this.notify();
		this.post();
	},

	post: function(callback/*=null*/) {
		sajax_request_type = "POST";
		try {
			sajax_do_call('wfAjaxPostCollection', [this.serialize()], function(xhr) {
				if (callback) {
					callback(xhr);
				}
			});
		} catch (e) {
			alert('XMLHttpRequest failed: ' + e);
		}
	},

	serialize: function() {
		var result = {
			title: this.title,
			subtitle: this.subtitle,
			items: this.items
		};
		return JSON.stringify(result);
	},

	deserialize: function(collection) {
		this.title = collection.title || '';
		this.subtitle = collection.subtitle || '';
		this.items = collection.items || [];
	},

	observe: function(obj, method_name) {
		this.observers.push({obj: obj, method: method_name});
	},

	notify: function() {
		forEach(this.observers, function(i, observer) {
			observer.obj[observer.method]();
		});
	},

	sort: function() {
		// N.B.: sort articles chapter-wise
		var newItems = [];
		var articles = [];
		function nameCompare(a, b) {
			var t1 = a.displaytitle || a.title;
			var t2 = b.displaytitle || b.title;
			if (t1 < t2) {
				return -1;
			} else if (t1 > t2) {
				return 1;
			}
			return 0;
		}
		forEach(this.items, function(i, item) {
			if (item.type == 'chapter') {
				articles.sort(nameCompare);
				newItems = newItems.concat(articles);
				articles = [];
				newItems.push(item);
			} else if (item.type == 'article') {
				articles.push(item);
			}
		});
		if (articles.length) {
			articles.sort(nameCompare);
			newItems = newItems.concat(articles);
		}
		this.setItems(newItems);
	},

	renameItem: function(index) {
		var newName = prompt(gettext('renameChapterText'), this.items[index].title);
		if (newName) {
			this.items[index].title = newName;
			this.setItems(this.items);
		}
	},

	addItem: function(item) {
		this.items.push(item);
		this.setItems(this.items);
	},

	removeItem: function(index) {
		this.items.splice(index, 1);
		this.setItems(this.items);
	},

	clear: function() {
		this.title = '';
		this.subtitle = '';
		this.setItems([]);
	},

	moveItem: function(oldIndex, newIndex) {
		var temp = this.items[oldIndex];
		this.items[oldIndex] = this.items[newIndex];
		this.items[newIndex] = temp;
		this.setItems(this.items);
	},

	createChapter: function() {
		var chapterName = prompt(gettext('newChapterText'));
		if (chapterName) {
			this.items.push({type: 'chapter', title: chapterName});
			this.setItems(this.items);
		}
	}
};

/******************************************************************************/

function CollectionSpecialPage() {
	var self = this;

	this.collection = new Collection();

	this.collectionList = $('collectionList');

	this.createChapter = $('createChapter');
	hookEventOnElement('click', function() { self.collection.createChapter(); }, this.createChapter);

	hookEventOnElement('click', function() {
		if (confirm(gettext('clearConfirmText'))) {
			self.collection.clear();
		}
	}, $('clearLink'));

	hookEventOnElement('click', function() { self.collection.sort(); }, $('sortLink'));

	this.downloadButton = $('downloadButton');
	this.ppList = $('ppList');
	this.titleInput = $('titleInput');

	hookEventOnElement(['keyup', 'change'], function() {
		var val = self.titleInput.value;
		self.collection.title = val;
		$('downloadTitle').value = val;
		var st = $('saveTitle');
		if (st) {
			st.value = val;
		}
	}, this.titleInput);
	hookEventOnElement('blur', function() { self.collection.post(); }, this.titleInput);

	this.subtitleInput = $('subtitleInput');
	hookEventOnElement(['keyup', 'change'], function() {
		var val = self.subtitleInput.value;
		self.collection.subtitle = val;
		$('downloadSubtitle').value = val;
		var sst = $('saveSubtitle');
		if (sst) {
			sst.value = val;
		}
	}, this.subtitleInput);
	hookEventOnElement('blur', function() { self.collection.post(); }, this.subtitleInput);

	hookEventOnElement(['keyup', 'change'], function() { self.updateButtons(); }, $('personalCollTitle'));
	hookEventOnElement(['keyup', 'change'], function() { self.updateButtons(); }, $('communityCollTitle'));
	hookEventOnElement(['keyup', 'change'], function() { self.updateButtons(); }, $('personalCollType'));
	hookEventOnElement(['keyup', 'change'], function() { self.updateButtons(); }, $('communityCollType'));

	this.collection.observe(this, 'refresh');
	this.collection.getItems();
};

CollectionSpecialPage.prototype = {
	refresh: function() {
		this.titleInput.value = this.collection.title;
		this.subtitleInput.value = this.collection.subtitle;
		this.collectionList.innerHTML = '';
		if (this.collection.items && this.collection.items.length) {
			$('clearSpan').style.display = 'inline';
			$('sortSpan').style.display = 'inline';
			this.updateButtons();
			var self = this;
			forEach(this.collection.items, function(i, item) {
				self.collectionList.appendChild(self.createItem(i));
			});
		} else {
			$('clearSpan').style.display = 'none';
			$('sortSpan').style.display = 'none';
			this.updateButtons();
			var div = document.createElement('div');
			div.appendChild(document.createTextNode(gettext('emptyCollectionText')));
			this.collectionList.appendChild(div);
		}
	},

	updateButtons: function() {
		var disabled = '';
		if (!this.collection.items || !this.collection.items.length) {
			disabled = 'disabled';
		}
		this.downloadButton.disabled = disabled;
		forEach(this.ppList.getElementsByTagName('input'), function(i, button) {
			button.disabled = disabled;
		});
		var saveButton = $('saveButton');
		if (!saveButton) {
			return;
		}
		if (disabled) {
			saveButton.disabled = disabled;
			return;
		}
		if ($('personalCollType').checked) {
			$('personalCollTitle').disabled = '';
			$('communityCollTitle').disabled = 'disabled';
			if (!trim($('personalCollTitle').value)) {
				saveButton.disabled = 'disabled';
				return;
			}
		} else if ($('communityCollType').checked) {
			$('communityCollTitle').disabled = '';
			$('personalCollTitle').disabled = 'disabled';
			if (!trim($('communityCollTitle').value)) {
				saveButton.disabled = 'disabled';
				return;
			}
		}
		if (!this.collection.items || !this.collection.items.length) {
			saveButton.disabled = disabled;
			return;
		}
		saveButton.disabled = '';
	},

	createItem: function(index) {
		var item = this.collection.items[index];
		var li;
		if (item.type == 'article') {
			li = $('articleListItem').cloneNode(true);
		} else if (item.type == 'chapter') {
			li = $('chapterListItem').cloneNode(true);
		} else {
			return;
		}
		li.id = '';
		var removeNodes = [];
		var self = this;
		forEach(li.childNodes, function(i, node) {
			switch(node.className) {
			case 'articleLink':
				var text = item.displaytitle || item.title;
				var href = item.url;
				if (typeof(item.revision) == 'string' && item.revision != item.latest) {
					text += ' (' + gettext('revisionText', '' + item.revision) + ')';
					href += '?oldid=' + item.revision;
				}
				node.appendChild(document.createTextNode(text));
				node.href = href;
				break;
			case 'chapterTitle':
				node.appendChild(document.createTextNode(item.title))
				break;
			case 'renameLink':
				hookEventOnElement('click', function() { self.collection.renameItem(index); }, node);
				break;
			case 'removeLink':
				hookEventOnElement('click', function() { self.collection.removeItem(index); }, node);
				break;
			case 'moveUpLink':
				if (index > 0) {
					hookEventOnElement('click', function() { self.collection.moveItem(index, index - 1); }, node);
				} else {
					removeNodes.push(node);
				}
				break;
			case 'moveUpDisabled':
				if (index > 0) {
					removeNodes.push(node);
				}
				break;
			case 'moveDownLink':
				if (index < self.collection.items.length - 1) {
					hookEventOnElement('click', function() { self.collection.moveItem(index, index + 1); }, node);
				} else {
					removeNodes.push(node);
				}
				break;
			case 'moveDownDisabled':
				if (index < self.collection.items.length - 1) {
					removeNodes.push(node);
				}
				break;
			}
		});
		forEach(removeNodes, function(i, node) {
			li.removeChild(node);
		});
		return li;
	}
};

/******************************************************************************/

addOnloadHook(function() {
	if (requiredVersion != wgCollectionVersion) {
		alert('ERROR: Version mismatch between JavaScript code and PHP code. Contact admin to fix installation of Collection extension for MediaWiki.');
		return;
	}
	if ($('collectionList')) {
		new CollectionSpecialPage();
	}
});
