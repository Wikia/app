define('ext.wikia.userProfile.userAvatar', ['jquery', 'mw', 'BannerNotification'], function ($, mw, BannerNotification) {
	var userAvatarServiceUrl = mw.config.get('wgUserAvatarServiceUrl'),
		userAttributeServiceUrl = mw.config.get('wgUserAttributeServiceUrl'),
		userId = mw.config.get('wgUserId');

	var avatarPreview, avatarUploadForm, avatarUploadInput, selectedDefaultAvatar,
		avatarSubmitCallback = function () {
			var $dfd = new $.Deferred();
			$dfd.resolve();
			return $dfd.promise();
		};

	function onAvatarUploadComplete($dfd) {
		return function () {
			if (this.readyState === XMLHttpRequest.DONE) {
				if (this.status === 200) {
					console.log('avatar saved');
					$dfd.resolve();
				} else {
					console.log('avatar could not be saved');
					$dfd.reject();
				}
			}
		};
	}

	function saveDefaultAvatar() {
		var $dfd = new $.Deferred();

		var xmlHttpRequest = new XMLHttpRequest();
		xmlHttpRequest.open('PATCH', userAttributeServiceUrl + '/user/' + userId);
		xmlHttpRequest.responseType = 'json';
		xmlHttpRequest.withCredentials = true;
		xmlHttpRequest.onreadystatechange = onAvatarUploadComplete($dfd).bind(xmlHttpRequest);
		xmlHttpRequest.send('avatar=' + encodeURIComponent(selectedDefaultAvatar));

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

				avatarSubmitCallback = uploadAvatar;
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
		selectedDefaultAvatar = event.target.getAttribute('data-url');

		avatarSubmitCallback = saveDefaultAvatar;
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
			return avatarSubmitCallback();
		}
	};
});
