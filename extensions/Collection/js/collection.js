/*
 * Collection Extension for MediaWiki
 *
 * Copyright (C) PediaPress GmbH
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
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

(function($) {

/******************************************************************************/

var requiredVersion = '1.5';

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

function req(func, args, callback) {
    $.post(script_url, {
        'action': 'ajax',
        'rs': 'wfAjaxCollection' + func,
        'rsargs[]': args
    }, callback, 'json');
}

var script_url = wgServer +
	((wgScript == null) ? (wgScriptPath + "/index.php") : wgScript);

var chapter_max_len = 200;

/******************************************************************************/

function getMWServeStatus() {
	$.getJSON(script_url, {
		'action': 'ajax',
		'rs': 'wfAjaxGetMWServeStatus',
		'rsargs[]': [collection_id, writer]
	}, function(result) {
		if (result.state == 'progress' ) {
			if ( result.status.progress )  {
				$('#renderingProgress').html('' + result.status.progress);
			}
			if (result.status.status) {
				var status = result.status.status;
				if (result.status.article) {
					status += gettext('#renderingArticle', result.status.article);
				} else if (result.status.page) {
					status += gettext('#renderingPage', result.status.page);
				}
				$('#renderingStatus').html(gettext('#renderingStatusText', status));
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
		req('Clear',
			[],
			function(result) {
				$('#titleInput').val('');
				$('#subtitleInput').val('');
				refresh_list(result);
				req('GetBookCreatorBoxContent', ['showbook', null, wgPageName], function(result2) {
					$('#coll-book_creator_box').html(result2.html);
				});
			});
	}
	return false;
}

function create_chapter() {
	var name = prompt(gettext('#newChapterText'));
	if (name) {
		name = name.substring(0, chapter_max_len);
		req('AddChapter', [name], refresh_list);
	}
	return false;
}

function rename_chapter(index, old_name) {
	var new_name = prompt(gettext('#renameChapterText'), old_name);
	if (new_name) {
		new_name = new_name.substring(0, chapter_max_len);
		req('RenameChapter', [index, new_name], refresh_list);
	}
	return false;
}

function remove_item(index) {
	req('RemoveItem',
		[index],
		function(result) {
			refresh_list(result);
			req('GetBookCreatorBoxContent', ['showbook', null, wgPageName], function(result2) {
				$('#coll-book_creator_box').html(result2.html);
			});
		});
	return false;
}

function set_titles() {
	req('SetTitles', [$('#titleInput').val(), $('#subtitleInput').val()], function(result) {
        wfCollectionSave(result.collection);
    });
	return false;
}

function set_sorting(items_string) {
	req('SetSorting', [items_string], refresh_list);
	return false;
}

function update_buttons() {
	if ($('#collectionList .article').length == 0) {
		$('#saveButton').attr('disabled', 'disabled');
		$('#downloadButton').attr('disabled', 'disabled');
		$('input.order').attr('disabled', 'disabled');
		return;
	} else {
		$('#downloadButton').removeAttr('disabled');
		$('input.order').removeAttr('disabled');
	}
	if (!$('#saveButton').length) {
		return;
	}
	if (!$('#communityCollTitle').length || $('#personalCollType:checked').val()) {
		$('#personalCollTitle').removeAttr('disabled');
		$('#communityCollTitle').attr('disabled', 'disabled');
		if (!$.trim($('#personalCollTitle').val())) {
			$('#saveButton').attr('disabled', 'disabled');
			return;
		}
	} else if (!$('#personalCollTitle').length || $('#communityCollType:checked').val()) {
		$('#communityCollTitle').removeAttr('disabled');
		$('#personalCollTitle').attr('disabled', 'disabled');
		if (!$.trim($('#communityCollTitle').val())) {
			$('#saveButton').attr('disabled', 'disabled');
			return;
		}
	}
	$('#saveButton').removeAttr('disabled');
}

function make_sortable() {
	$('#collectionList').sortable({
		axis: 'y',
		update: function(evt, ui) {
			set_sorting($('#collectionList').sortable('serialize'));
		}
	});
	$('#collectionList .sortableitem').css('cursor', 'move');
}

function refresh_list(data) {
    wfCollectionSave(data.collection);
	$('#collectionListContainer').html(data.html);
	$('.makeVisible').css('display', 'inline');
	make_sortable();
	update_buttons();
}

function toggle_order_info(flag) {
	if (flag) {
		$('#coll-more_info').css('display', 'none');
		$('#coll-order_info').css('display', 'block');
		$('#coll-hide_info').css('display', 'block');
	} else {
		$('#coll-more_info').css('display', 'block');
		$('#coll-order_info').css('display', 'none');
		$('#coll-hide_info').css('display', 'none');
	}
}

$(function() {
	if (requiredVersion != wgCollectionVersion) {
		alert('ERROR: Version mismatch between Javascript and PHP code. Contact admin to fix the installation of Collection extension for MediaWiki.');
		return;
	}
	if ($('#collectionList').length) {
		$('.makeVisible').css('display', 'inline');
		window.coll_create_chapter = create_chapter;
		window.coll_remove_item = remove_item;
		window.coll_rename_chapter = rename_chapter;
		window.coll_clear_collection = clear_collection;
		window.coll_toggle_order_info = toggle_order_info;
		toggle_order_info(false);
		update_buttons();
		make_sortable();
		$('#personalCollTitle').val($('#titleInput').val());
		$('#personalCollTitle').keyup(update_buttons);
		$('#personalCollTitle').change(update_buttons);
		$('#communityCollTitle').val($('#titleInput').val());
		$('#communityCollTitle').keyup(update_buttons);
		$('#communityCollTitle').change(update_buttons);
		$('#personalCollType').change(update_buttons);
		$('#communityCollType').change(update_buttons);
		$('#titleInput').change(set_titles);
		$('#subtitleInput').change(set_titles);
	}
	if (typeof collection_rendering != 'undefined') {
		getMWServeStatus();
	}
});

})(jQuery);
