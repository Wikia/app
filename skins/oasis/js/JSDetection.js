$(function() {
	$('[href*="js=0"]').each(function() {
		this.href = this.href.replace('js=0', 'js=1');
	});
});

