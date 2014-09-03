(function (window, $) {
	'use strict';

	jQuery.event.props.push( "dataTransfer" );
	var $heroModuleUpload = $('#MainPageHero .upload');
	//those two are needed to cancel default behaviour
	$heroModuleUpload.on('dragover', function(){return false;});
	$heroModuleUpload.on('dragend', function(){return false;});
	$heroModuleUpload.on('drop', function(e) {
		e.preventDefault();
		console.info(e.dataTransfer.files)
		var fd = new FormData();
		fd.append('action', 'upload');
		fd.append('file', e.dataTransfer.files[0]);
		fd.append('filename', e.dataTransfer.files[0].name);

		var client = new XMLHttpRequest();
		client.open('POST', '/api.php', true);
		client.setRequestHeader("Content-Type", "multipart/form-data");

		client.onreadystatechange = function() {
			if (client.readyState == 4 && client.status == 200)
			{
				console.info('done');
			}
		}

		client.send(fd);
	});
})(window, jQuery);
