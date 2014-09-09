(function (window, $) {
	'use strict';

	jQuery.event.props.push('dataTransfer');

	var $heroModule = $('#MainPageHero'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image');

	//those two are needed to cancel default behaviour
	$heroModuleUpload.on('dragover', function () {
		return false;
	});
	$heroModuleUpload.on('dragend', function () {
		return false;
	});
	$heroModuleUpload.on('drop', function (e) {
		e.preventDefault();
		var fd = new FormData();
		if (e.dataTransfer.files.length) {
			//if file is uploaded
			fd.append('file', e.dataTransfer.files[0]);
			sendForm(fd);
		} else if (e.dataTransfer.getData('text/html')) {
			//if url
			var $img = $(e.dataTransfer.getData('text/html'));
			if (e.target.src !== $img.attr('src')) {
				fd.append('url', $img.attr('src'));
				sendForm(fd);
			}
		}
	});

	$heroModuleUpload.find('.upload-btn').on('click', function () {
		if ($heroModuleInput[0].files.length) {
			var fd = new FormData();
			fd.append('file', $heroModuleInput[0].files[0]);
			sendForm(fd);
		}
	});

	function sendForm(formdata) {
		var client = new XMLHttpRequest();
		client.open('POST', '/wikia.php?controller=Njord&method=upload', true);
		client.onreadystatechange = function () {
			if (client.readyState === 4 && client.status === 200) {
				var data = JSON.parse(client.responseText);

				$heroModule.height($heroModule.width() * 5 / 16);
				$heroModuleImage.attr('src', data.url);
				$heroModule.trigger('change', [data.url, data.filename]);
			}
		};
		client.send(formdata);
	}
})(window, jQuery);
