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

(function() {

/******************************************************************************/

var requiredVersion = '1.1';

/******************************************************************************/

/**
 * Return text of element with given selector. Optionally replace %PARAM% with value
 * of param. This allows usage of localization features in PHP from JavaScript.
 *
 * @param String id elment ID of elment containing text
 * @param String param optionally, a text to replace %PARAM% with
 * @return String text of elment with ID id
 */
function gettext(sel, param/*=null*/) {
	var txt = jQuery(sel).html();
	if (param) {
		txt = txt.replace(/%PARAM%/g, param);
	}
	return txt;
}

var script_url = wgServer +
	((wgScript == null) ? (wgScriptPath + "/index.php") : wgScript);

/******************************************************************************/

function getMWServeStatus() {
	jQuery.getJSON(script_url, {
		'action': 'ajax',
		'rs': 'wfAjaxGetMWServeStatus',
		'rsargs[]': [collection_id, writer]
	}, function(result) {
		if (result.state == 'progress' ) {
			jQuery('#renderingProgress').html('' + result.status.progress);
			if (result.status.status) {
				var status = result.status.status;
				if (result.status.article) {
					status += gettext('#renderingArticle', result.status.article);
				} else if (result.status.page) {
					status += gettext('#renderingPage', result.status.page);
				}
				jQuery('#renderingStatus').html(gettext('#renderingStatusText', status));
			}
			setTimeout(getMWServeStatus, 500);
		} else {
			window.location.reload(true);
		}
	});
}

/******************************************************************************/

function clear_collection() {
	if (confirm(gettext('#clearCollectionConfirmText'))) {
		sajax_request_type = "POST";
		sajax_do_call('wfAjaxCollectionClear',
			[],
			refresh_list);
	}
	return false;
}

function create_chapter() {
	var name = prompt(gettext('#newChapterText'));
	if (name) {
		sajax_request_type = "POST";
		sajax_do_call('wfAjaxCollectionAddChapter',
			[name],
			refresh_list);
	}
	return false;
}

function rename_chapter(index, old_name) {
	var new_name = prompt(gettext('#renameChapterText'), old_name);
	if (new_name) {
		sajax_request_type = "POST";
		sajax_do_call('wfAjaxCollectionRenameChapter',
			[index, new_name],
			refresh_list);
	}
	return false;
}

function remove_item(index) {
	sajax_request_type = "POST";
	sajax_do_call('wfAjaxCollectionRemoveItem',
		[index],
		refresh_list);
	return false;
}

function set_titles() {
	sajax_request_type = "POST";
	sajax_do_call('wfAjaxCollectionSetTitles',
		[jQuery('#titleInput').val(), jQuery('#subtitleInput').val()], function() {});
	return false;
}

function set_sorting(items_string) {
	sajax_request_type = "POST";
	sajax_do_call('wfAjaxCollectionSetSorting', [items_string], refresh_list);
	return false;
}

function update_save_button() {
	if (!jQuery('#saveButton').get(0)) {
		return;
	}
	if (jQuery('#emptyCollection').get(0)) {
		jQuery('#saveButton').attr('disabled', 'disabled');
		return;
	}
	if (jQuery('#personalCollType:checked').val()) {
		jQuery('#personalCollTitle').attr('disabled', '');
		jQuery('#communityCollTitle').attr('disabled', 'disabled');
		if (!jQuery.trim(jQuery('#personalCollTitle').val())) {
			jQuery('#saveButton').attr('disabled', 'disabled');
			return;
		}
	} else if (jQuery('#communityCollType:checked').val()) {
		jQuery('#communityCollTitle').attr('disabled', '');
		jQuery('#personalCollTitle').attr('disabled', 'disabled');
		if (!jQuery.trim(jQuery('#communityCollTitle').val())) {
			jQuery('#saveButton').attr('disabled', 'disabled');
			return;
		}
	}
	jQuery('#saveButton').attr('disabled', '');
}

function make_sortable() {
	jQuery('#collectionList').sortable({
		axis: 'y',
		update: function(evt, ui) {
			set_sorting(jQuery('#collectionList').sortable('serialize'));
		}
	});
	jQuery('#collectionList .sortableitem').css('cursor', 'move');
}

function refresh_list(xhr) {
	jQuery('#collectionListContainer').html(xhr.responseText);
	jQuery('.makeVisible').css('display', 'inline');
	make_sortable();
	if (jQuery('#emptyCollection').get(0)) {
		jQuery('#downloadButton').attr('disabled', 'disabled');
		jQuery('input.order').attr('disabled', 'disabled');
	} else {
		jQuery('#downloadButton').attr('disabled', '');
		jQuery('input.order').attr('disabled', '');
	}
	update_save_button();
}

jQuery(function() {
	if (requiredVersion != wgCollectionVersion) {
		alert('ERROR: Version mismatch between Javascript and PHP code. Contact admin to fix the installation of Collection extension for MediaWiki.');
		return;
	}
	if (jQuery('#collectionList').get(0)) {
		jQuery('.makeVisible').css('display', 'inline');
		window.coll_create_chapter = create_chapter;
		window.coll_remove_item = remove_item;
		window.coll_rename_chapter = rename_chapter;
		window.coll_clear_collection = clear_collection;
		update_save_button();
		make_sortable();
		jQuery('#personalCollTitle').keyup(update_save_button);
		jQuery('#personalCollTitle').change(update_save_button);
		jQuery('#communityCollTitle').keyup(update_save_button);
		jQuery('#communityCollTitle').change(update_save_button);
		jQuery('#personalCollType').change(update_save_button);
		jQuery('#communityCollType').change(update_save_button);
		jQuery('#titleInput').change(set_titles);
		jQuery('#subtitleInput').change(set_titles);
	}
	if (typeof collection_rendering != 'undefined') {
		getMWServeStatus();
	}
});

})();
