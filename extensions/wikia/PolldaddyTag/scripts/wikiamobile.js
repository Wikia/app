$('a[data-wikia-widget=polldaddy]').each(function () {
	var id = this.getAttribute('data-id');
	$(this).replaceWith('<a name="pd_a_' + id + '" style="display:inline;padding:0;margin:0;"></a>' +
		'<div class="PDS_Poll" id="PDI_container' + id + '"></div>');
	$.getScript('//static.polldaddy.com/p/' + id + '.js');
});
