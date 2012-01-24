/**
 * Article Comments JS code for the WikiaMobile skin
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 **/

var ArticleComments = ArticleComments || (function(){
	/** @private **/

	var wrapper,
		loadMore,
		loadPrev,
		totalPages = 0,
		currentPage = 1,
		ajaxUrl = wgServer + "/index.php?action=ajax&rs=ArticleCommentsAjax&method=axGetComments&useskin=" + skin + "&article=" + wgArticleId,
		clickEvent = WikiaMobile.getClickEvent(),
		firstPage,
		commsUl;

	function clickHandler(){
		var elm = $(this),
			forward = (elm.attr('id') == 'commMore'),
			pageIndex = (forward) ? currentPage + 1 : currentPage - 1,
			condition = (forward) ? (currentPage < totalPages) : (currentPage > 1);

		if(currentPage === 1 && !firstPage)
				firstPage = commsUl.html();

		if(condition){
			elm.toggleClass('active');
			$.showLoader(elm);

			$.getJSON(ajaxUrl + '&page=' + pageIndex.toString(), function(result){
				var finished;

				currentPage = pageIndex;
				finished = (forward) ? (currentPage == totalPages) : (currentPage == 1);

				loadMore.before(result.text);

				elm.toggleClass('active');
				$.hideLoader(elm);

				if(finished)
					elm.hide();

				((forward) ? loadPrev : loadMore).show();

				window.scrollTo(0, wrapper.offset().top);
			});
		}
	}

	//init
	$(function(){
		wrapper = $('#wkArtCom');
		loadMore = $('#commMore');
		loadPrev = $('#commPrev');
		commsUl = $('#article-comments-ul');
		totalPages = parseInt(wrapper.data('pages'));

		if(totalPages > 1 && wgArticleId){
			loadMore.bind(clickEvent, clickHandler);
			loadPrev.bind(clickEvent, clickHandler);
		}
	});

	/** @public **/

	return {};
})();