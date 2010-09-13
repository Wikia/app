$(function(){
	$('.category-gallery').click(function(ev) {
		var node = $(ev.target);

		var item = node.closest('.category-gallery-item');
		if (item.length <= 0)
			return;
		
		var list = item.parent('.category-gallery');
		if (list.length <= 0)
			return;
		
		var pos = list.children('.category-gallery-item').index(item);
		if (pos < 0)
			return;
			
		var type = item.hasClass('category-gallery-item-text') ? 'text' : 'image'; 
		var url = 'categoryGallery/'+type+'/'+(pos+1);
		$.tracker.byStr(url);
//		alert(url);
	});
});
