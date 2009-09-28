var MagCloud = {};

// send AJAX request to MagCloud Ajax dispatcher in MW
MagCloud.ajax = function(method, params, callback) {
	// add page title to AJAX request params
	params.title = wgPageName;

	$.getJSON(wgScript + '?action=ajax&rs=MagCloudAjax&method=' + method, params, callback);
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

				$('#MagCloudIntroPopupWrapper').closeModal();
			});

			// click on "Load a saved magazine" will show popup with list of magazines
			$('#MagCloudIntroPopupLoad').click(function() {
				MagCloud.openLoadMagazinePopup();
			});

			// click on "Cancel" will close popup and hide toolbar
			$('#MagCloudIntroPopupCancel').click(function() {
				MagCloud.track('/intro-cancel');
				MagCloud.hideToolbar();

				$('#MagCloudIntroPopupWrapper').closeModal();
			});

			// show popup
			$('#MagCloudIntroPopup').makeModal({width: 450,	className: 'MagCloudDialog'});
		}
	});

	// fetch and show toolbar
	MagCloud.showToolbar();

	// setup global JS variables
	window.wgMagCloudToolbarVisible = true;
	window.wgMagCloudArticlesCount = 0;
}

// open load a magazine popup
MagCloud.openLoadMagazinePopup = function() {
	MagCloud.log('opening load a magazine pop-up');
	MagCloud.track('/loadMagazine');

	// fetch and show popup
	$().getModal(wgScript + '?action=ajax&rs=MagCloudAjax&method=renderSavedMagazines', false, {
		callback: function() {
			// click on "Ok" will load chosen magazine
			$('#MagCloudLoadMagazine').click(function() {
				// which magazine has been chosen?
				var magazineHash = $('#MagCloudSavedMagazinesList').find('input[checked]').attr('rel');

				if (magazineHash) {
					MagCloud.track('/loadMagazine-ok');

					// close both popups and keep toolbar shown
					$('#MagCloudSavedMagazinesWrapper').closeModal();
					$('#MagCloudIntroPopupWrapper').closeModal();

					// remove popup overlay mask
					$('#positioned_elements .blackout').remove();

					// load magazine
					MagCloud.log('loading chosen magazine (' + magazineHash  + ')');

					// send ajax request to actually load magazine
					MagCloud.ajax('loadCollection', {hash: magazineHash}, function(data) {
						// redirect to Special:MagCloud
						document.location = wgArticlePath.replace(/\$1/, 'Special:WikiaCollection');
					});
				}
				else {
					MagCloud.log('please select magazine');
				}
			});

			// click on "Cancel" will close popup
			$('#MagCloudCancel').click(function() {
				MagCloud.track('/loadMagazine-cancel');

				$('#MagCloudSavedMagazinesWrapper').closeModal();
			});

			// show popup
			$('#MagCloudSavedMagazines').makeModal({width: 450, className: 'MagCloudDialog'});
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
	importStylesheetURI(wgExtensionsPath + '/wikia/MagCloud/css/MagCloud.css?' + wgStyleVersion);

	MagCloud.ajax('showToolbar', {}, function(data) {
		$('#body').prepend(data.html);
	});
}

// hide toolbar
MagCloud.hideToolbar = function() {
	MagCloud.log('hiding toolbar');
	MagCloud.track('/closeToolbar');

	// is collection empty?
	if (window.wgMagCloudArticlesCount == 0) {
		MagCloud.doHideToolbar();
	}
	else {
		// show popup
		// fetch and show popup
		$().getModal(wgScript + '?action=ajax&rs=MagCloudAjax&method=renderDiscardMagazine', false, {
			callback: function() {
				// click on "Cancel" will close popup
				$('#MagCloudDiscardMagazineCancel').click(function() {
					MagCloud.track('/discardMagazine/cancel');

					$('#MagCloudDiscardMagazineWrapper').closeModal();
				});

				// click on "Discard" will close popup and toolbar
				$('#MagCloudDiscardMagazineDiscard').click(function() {
					MagCloud.track('/discardMagazine/discard');
					$('#MagCloudDiscardMagazineWrapper').closeModal();
					MagCloud.doHideToolbar();
				});

				// click on "Save" will store the collection using AJAX call
				$('#MagCloudDiscardMagazineSave').click(function() {
					MagCloud.track('/discardMagazine/save');

					if (window.wgUserName != null) {
						// logged-in: send AJAX request
						MagCloud.saveCollection();
					}
					else {
						// anon: show AjaxLogin form

						// call this function after successful login
						window.wgAjaxLoginOnSuccess = MagCloud.saveCollection;

						// call AjaxLogin
						openLogin($.getEvent());
					}
				});

				// show popup
				$('#MagCloudDiscardMagazine').makeModal({width: 450, className: 'MagCloudDialog'});
			}
		});
	}
}

// actually hide toolbar and send AJAX request
MagCloud.doHideToolbar = function() {
	$('#MagCloudToolbar').remove();

	window.wgMagCloudToolbarVisible = false;

	MagCloud.ajax('hideToolbar', {}, function() {
		// are we on special page
		if (window.wgCanonicalSpecialPageName && window.wgCanonicalSpecialPageName == 'WikiaCollection') {
			// redirect to main page
			document.location = window.wgServer + window.wgScript;
		}
	});
}

// save collection
MagCloud.saveCollection = function() {
	$('#MagCloudDiscardMagazineButtons').html('');

	MagCloud.ajax('saveCollection', {}, function(data) {
		// TODO: show success msg, close toolbar, ...
		$('#MagCloudDiscardMagazineButtons').html(data.msg);
	});
}

// add current article to collection
MagCloud.addArticle = function() {
	MagCloud.log('adding article "' + wgPageName.replace(/_/g, ' ') + '" to collection');
	MagCloud.track('/addArticle');

	// get revision of article we're adding to collection
	var revid = (typeof window.wgRevisionId != 'undefined') ? window.wgRevisionId : 0;

	MagCloud.ajax('addArticle', {revid: revid}, function(data) {
		// update message...
		$('#MagCloudToolbarArticle').html(data.msg);

		// ...and articles count
		$('#MagCloudToolbarArticlesCount').find('span').html(data.articlesMsg);

		// increase counter in global JS variable
		window.wgMagCloudArticlesCount = data.count;
	});

	// remove "Add" button
	$('#MagCloudToolbarAdd').remove();
}
