require(['jquery'], function ($) {
	$('.lightbox, a.image').on('click', function (e) {
		var fileName = $(this).find('[data-image-name]').attr('data-image-name');
		if ( fileName ) {
			e.preventDefault();
			location.href = '?file=' + encodeURIComponent( fileName );
		}
	});
});
