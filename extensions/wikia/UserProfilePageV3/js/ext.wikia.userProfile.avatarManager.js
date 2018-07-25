define('ext.wikia.userProfile.userAvatar', ['jquery', 'mw', 'BannerNotification'], function ($, mw, BannerNotification) {
	var userAvatarServiceUrl = mw.config.get('wgUserAvatarServiceUrl'),
		userId = mw.config.get('wgUserId');

	var avatarPreview, avatarUploadForm, avatarUploadInput, selectedDefaultAvatar,
		avatarChoice = { custom : false, default : false };

	function onAvatarUploadComplete($dfd) {
		return function () {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200 || this.status === 204) {
					$dfd.resolve();
				} else {
					$dfd.reject();
				}
			}
		};
	}

	function saveDefaultAvatar() {
		var $dfd = new $.Deferred();

		var xmlHttpRequest = new XMLHttpRequest();
		xmlHttpRequest.open('POST', mw.util.wikiScript('wikia') + '?controller=UserProfilePage&method=saveDefaultAvatar');
		xmlHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlHttpRequest.responseType = 'json';
		xmlHttpRequest.onreadystatechange = onAvatarUploadComplete($dfd).bind(xmlHttpRequest);
		xmlHttpRequest.send('avatar=' + encodeURIComponent(selectedDefaultAvatar) + '&token=' + encodeURIComponent(mw.user.tokens.get('editToken')));

		return $dfd.promise();
	}

	function uploadAvatar() {
		var $dfd = new $.Deferred();
		var formData = new FormData(avatarUploadForm);

		var xmlHttpRequest = new XMLHttpRequest();
		xmlHttpRequest.open('PUT', userAvatarServiceUrl + '/user/' + userId + '/avatar');
		xmlHttpRequest.responseType = 'json';
		xmlHttpRequest.withCredentials = true;
		xmlHttpRequest.onreadystatechange = onAvatarUploadComplete($dfd).bind(xmlHttpRequest);
		xmlHttpRequest.send(formData);

		return $dfd.promise();
	}

	function onAvatarValidationComplete() {
		if (this.readyState === XMLHttpRequest.DONE) {
			if (this.status === 200) {
				var fileInfoReader = new FileReader();
				fileInfoReader.addEventListener('load', function () {
					avatarPreview.src = fileInfoReader.result;
				});

				fileInfoReader.readAsDataURL(avatarUploadInput.files[0]);

				avatarChoice.custom = true;
				avatarChoice.default = false;
			} else {
				alert(JSON.stringify(this.response));
			}
		}
	}

	function doAvatarValidation() {
		var formData = new FormData(avatarUploadForm);

		var xmlHttpRequest = new XMLHttpRequest();
		xmlHttpRequest.open('POST', userAvatarServiceUrl + '/validate');
		xmlHttpRequest.responseType = 'json';
		xmlHttpRequest.withCredentials = true;
		xmlHttpRequest.onreadystatechange = onAvatarValidationComplete.bind(xmlHttpRequest);
		xmlHttpRequest.send(formData);
	}

	function selectSampleAvatar(event) {
		avatarPreview.src = event.target.src;
		selectedDefaultAvatar = event.target.getAttribute('data-name');

		avatarChoice.custom = false;
		avatarChoice.default = true;
	}

	return {
		init: function () {
			avatarPreview = document.querySelector('.avatar-preview');
			avatarUploadForm = document.getElementById('avatar-upload-form');
			avatarUploadInput = document.getElementById('avatar-upload-input');

			avatarUploadInput.addEventListener('change', doAvatarValidation);

			var sampleAvatars = document.getElementsByClassName('default-avatar'),
				sampleAvatarsCount = sampleAvatars.length;

			for (var i = 0; i < sampleAvatarsCount; i++) {
				sampleAvatars[i].addEventListener('click', selectSampleAvatar);
			}
		},

		close: function () {
			avatarPreview = null;
			avatarUploadForm = null;
			avatarUploadInput = null;
		},

		saveAvatar: function () {
			if (avatarChoice.default) {
				return saveDefaultAvatar();
			} else if (avatarChoice.custom) {
				return uploadAvatar();
			} else {
				var $dfd = new $.Deferred();
				$dfd.resolve();

				return $dfd.promise();
			}
		}
	};
});
