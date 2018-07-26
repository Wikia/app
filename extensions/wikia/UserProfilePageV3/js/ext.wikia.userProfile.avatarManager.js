define('ext.wikia.userProfile.userAvatar', ['jquery', 'mw', 'BannerNotification'], function ($, mw, BannerNotification) {
	var userAvatarServiceUrl = mw.config.get('wgUserAvatarServiceUrl'),
		userId = mw.config.get('wgUserId');

	var avatarPreview, avatarUploadForm, avatarUploadInput, selectedDefaultAvatar,
		avatarChoice = { custom : false, default : false };

	function showErrorBanner(content) {
		new BannerNotification(content, 'error').show();
	}

	/**
	 * Creates a callback to be fired after an user provided avatar has been uploaded to the service
	 * @param $dfd
	 * @returns {Function}
	 */
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

	/**
	 * Sets user's avatar to one of the provided defaults via MW API
	 */
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

	/**
	 * Uploads an user provided avatar to the service
	 * @returns {*}
	 */
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

	/**
	 * Callback fired after an user provided avatar has been validated by the service
	 * Used for frontend validation
	 */
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
				if (this.response.title === 'avatar_not_an_image') {
					showErrorBanner(mw.message('user-identity-box-avatar-error-nofile').escaped());
				} else if (this.response.title === 'avatar_too_large') {
					showErrorBanner(mw.message('user-identity-box-avatar-error-size', this.response.detail / 1000).escaped());
				} else {
					showErrorBanner(mw.message('user-identity-box-avatar-error').escaped());
				}
			}
		}
	}

	/**
	 * Submits an user provided avatar for preliminary validation to the service
	 * Validation results will be displayed to the user
	 */
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
		/**
		 * Initialize handlers when modal is opened
		 */
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

		/**
		 * Clean up any hanging DOM references after the modal is closed
		 */
		close: function () {
			avatarPreview = null;
			avatarUploadForm = null;
			avatarUploadInput = null;
		},

		/**
		 * Callback fired when modal is saved
		 * Uploads user provided avatar / saves selected default avatar / does nothing, depending on user choice
		 */
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
