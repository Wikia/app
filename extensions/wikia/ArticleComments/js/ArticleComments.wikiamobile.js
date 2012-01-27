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

	function clickHandler(event){
		event.preventDefault();

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

				commsUl.remove();
				loadMore.before(result.text);
				commsUl = $('#article-comments-ul');

				elm.toggleClass('active');
				$.hideLoader(elm);

				//there's a good reason to use display instead of show/hide in the following lines
				if(finished)
					elm.css('display', 'none');

				((forward) ? loadPrev : loadMore).css('display', 'block');

				window.scrollTo(0, wrapper.offset().top);
			});
		}
	}
	
	function post(ev) {
		ev.preventDefault();

		var self = $(this),
		commId = self.find('input').first(),
		parentId = (commId.attr('name') === 'wpParentId')?commId.val():undefined,
		data = {
			action:'ajax',
			article:wgArticleId,
			method:'axPost',
			rs:'ArticleCommentsAjax',
			title:wgPageName,
			wpArticleComment:self.find('textarea').val(),
			useskin:'wikiamobile'
		};
		
		if(parentId)
			data.parentId = parentId;

		$.post(wgScript, data, function(resp) {
			var json = JSON.parse(resp);
			if(!json.error){
				self.find('textarea').val('');
				var reply = $(json.text);
				
				if(parentId) {
					var prev = self.parent().prev();

					if(prev.hasClass('sub-comments')) {
						prev.append(reply.find('.sub-comments li'));
					}else{
						prev.after(reply.find('.sub-comments'));
					}
				}else{
					commsUl.prepend(reply.find('li, .rpl'));
				}
				wrapper.children('h1').text(json.counter);
			}
		});
	}

	//init
	$(function(){
		wrapper = $('#wkArtCom');
		loadMore = $('#commMore');
		loadPrev = $('#commPrev');
		commsUl = $('#article-comments-ul');
		postComm = document.getElementById('article-comm-form');
		totalPages = parseInt(wrapper.data('pages'));

		if(totalPages > 1 && wgArticleId){
			loadMore.bind(clickEvent, clickHandler);
			loadPrev.bind(clickEvent, clickHandler);
		}

		wrapper.on(clickEvent, '.rpl', function(){
			var self = $(this),
			prev = self.prev(),
			rplComm = $(postComm.cloneNode(true)).height(35);

			if(prev.is('ul')) prev = prev.prev();
			
			rplComm.find('input').first().attr('name', 'wpParentId').val(prev.attr('id')).next().attr('name', 'wpArticleReply');

			self.removeClass().html('').append(rplComm).find('#article-comm').focus();
		})
		.on('submit', '.article-comm-form', post);
	});

	/** @public **/

	return {};
})();