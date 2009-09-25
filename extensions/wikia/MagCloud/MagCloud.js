var MagCloud = {};

// send AJAX request to MagCloud Ajax dispatcher in MW
MagCloud.ajax = function(method, params, callback) {
	$.getJSON(wgScript + '?action=ajax&rs=MagCloudAjax&method=' + method + '&title=' + encodeURIComponent(wgPageName), params, callback);
}

// track events
MagCloud.track = function(fakeUrl) {
	WET.byStr('magcloud' + fakeUrl);
}

// console loging
MagCloud.log = function(msg) {
	$().log(msg, 'MagCloud');
}

// open initial popup
MagCloud.openIntroPopup = function() {
	MagCloud.log('opening intro pop-up');
	MagCloud.track('/intro');

	// fetch and show popup
	$().getModal(wgScript + '?action=ajax&rs=MagCloudAjax&method=renderIntroPopup', false, {
		callback: function() {
			// click on "Ok" will close popup and keep toolbar shown
			$('#MagCloudIntroPopupOk').click(function() {
				MagCloud.track('/intro-ok');

				$('.modalWrapper').closeModal();
			});

			// click on "Cancel" will close popup and hide toolbar
			$('#MagCloudIntroPopupCancel').click(function() {
				MagCloud.track('/intro-cancel');
				MagCloud.hideToolbar();

				$('.modalWrapper').closeModal();
			});

			// show popup
			$('#MagCloudIntroPopup').makeModal({width: 450});
		}
	});

	// fetch and show toolbar
	MagCloud.showToolbar();
}

// show toolbar
MagCloud.showToolbar = function() {
	if ($('#MagCloudToolbar').exists()) {
		return;
	}

	MagCloud.log('showing toolbar');

	// load CSS for popup and toolbar
	importStylesheetURI(wgExtensionsPath + '/wikia/MagCloud/MagCloud.css?' + wgStyleVersion);

	MagCloud.ajax('showToolbar', {}, function(data) {
		$('#body').prepend(data.html);
	});
}

// hide toolbar
MagCloud.hideToolbar = function() {
	MagCloud.log('hiding toolbar');

	$('#MagCloudToolbar').remove();

	MagCloud.ajax('hideToolbar', {}, function() {});
}

// add current article to collection
MagCloud.addArticle = function() {

	MagCloud.log('adding article "' + wgPageName.replace(/_/g, ' ') + '" to collection');

	MagCloud.ajax('addArticle', {}, function(data) {
		// update message...
		$('#MagCloudToolbarArticle').html(data.msg);

		// ...and articles count
		$('#MagCloudToolbarArticlesCount span big').html(data.count);
	});

	// remove "Add" button
	$('#MagCloudToolbarAdd').remove();
}


