// Unwrap widgets iframes
$('script[type=x-wikia-widget]').each(function () {
	$(this).replaceWith(this.textContent);
});
