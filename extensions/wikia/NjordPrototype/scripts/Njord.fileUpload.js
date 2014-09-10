(function (window, $) {
	'use strict';

	jQuery.event.props.push('dataTransfer');

	var $body = $('body'),
		$heroModule = $('#MainPageHero'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleUploadMask = $('#MainPageHero .upload .upload-mask'),
		$heroModuleButton = $('#MainPageHero .upload .upload-btn'),
		$heroModuleInput = $('#MainPageHero .upload input[name="file"]'),
		$heroModuleImage = $('#MainPageHero .hero-image');

	//turn off browser image handling
	$body.on('dragover', function () {return false;});
	$body.on('dragend', function () {return false;});
	$body.on('drop', function () {return false;});

	//those two are needed to cancel default behaviour
	$heroModuleUpload.on('dragover', function () {
		$('.upload').addClass('upload-hover');
		$heroModuleUploadMask.show();
		return false;
	});
	$heroModuleUploadMask.on('dragleave', function () {
		$('.upload').removeClass('upload-hover');
		$heroModuleUploadMask.hide();
	});
	$heroModuleUploadMask.on('dragend', function () {
		return false;
	});
	$heroModuleUploadMask.on('drop', function (e) {
		$('.upload').removeClass('upload-hover');
		$heroModuleUploadMask.hide();
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

	$heroModuleButton.on('click', function () {
		$heroModuleInput.click();
	});

	$heroModuleInput.on('change', function () {
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

				$heroModuleImage.bind('load',function () {$heroModule.trigger('enableDragging');});
				$heroModuleImage.attr('src', data.url);
				$heroModule.height($heroModule.width() * 5 / 16);
				$heroModule.trigger('change', [data.url, data.filename]);
			}
		};
		client.send(formdata);
	}
})(window, jQuery);
