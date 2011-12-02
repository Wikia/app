$('#article-comments-counter-header').bind(WikiaMobile._clickevent, function() {
	$(this).toggleClass('open').next().toggleClass('open').next().toggleClass('open');
});

//$('.load-more').bind(WikiaMobile._clickevent, function() {
//	var url = wgServer + "/index.php?action=ajax&rs=ArticleCommentsAjax&method=axGetComments&article="+51683+"&page="+3;
//	$.get(url, function(result) {
//		var myObject = eval('(' + result + ')');
//		$('#article-comments-ul').html(myObject.text);
//	});
//});