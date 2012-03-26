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
		commsUl,
		track = WikiaMobile.track,
		postComm,
		rpl;

	function clickHandler(event){
		event.preventDefault();

		var elm = $(this),
			forward = (elm.attr('id') == 'commMore'),
			pageIndex = (forward) ? currentPage + 1 : currentPage - 1,
			condition = (forward) ? (currentPage < totalPages) : (currentPage > 1);

		if(currentPage === 1) {
			firstPage = commsUl.innerHTML;
		}
				
		track(['comment', 'page', (forward)?'next':'previous']);

		if(condition){
			elm.toggleClass('active');
			WikiaMobile.loader.show(elm[0]);

			$.getJSON(ajaxUrl + '&page=' + pageIndex.toString(), function(result){
				var finished;

				currentPage = pageIndex;
				finished = (forward) ? (currentPage == totalPages) : (currentPage == 1);

				commsUl.innerHTML = result.text;

				elm.toggleClass('active');
				WikiaMobile.loader.hide(elm[0]);

				//there's a good reason to use display instead of show/hide in the following lines
				if(finished) {
					elm.css('display', 'none');
				}

				((forward) ? loadPrev : loadMore).style.display = 'block';

				window.scrollTo(0, wrapper.offset().top);
			});
		}
	}

	function post(ev) {
		ev.preventDefault();

		var self = $(this),
		prev = this.parentNode.previousElementSibling,
		parentId = (prev.nodeName == 'UL' ? prev.previousElementSibling : prev).id,
		submit = this.getElementsByTagName('input')[0],
		textArea = this.getElementsByTagName('textarea')[0],
		text = textArea.value;
		
		if(text !== '') {
			submit.disabled =  true;
			
			var data = {
				action:'ajax',
				article:wgArticleId,
				method:'axPost',
				rs:'ArticleCommentsAjax',
				title:wgPageName,
				wpArticleComment:text,
				useskin:'wikiamobile'
			};
	
			if(parentId) {
				data.parentId = parentId;
			}
	
			$.post(wgScript, data, function(resp) {
				var json = JSON.parse(resp);
				textArea.value = '';

				submit.disabled = false;
				if(!json.error && json.text){

					if(currentPage > 1){
						commsUl.innerHTML = firstPage;
						currentPage = 1;
						loadPrev.style.display = 'none';
					}

					if(parentId){
						if(prev.className.indexOf('sub-comments') > -1) {
							prev.innerHTML += json.text;
						}else{
							var ul = document.createElement('ul');
							ul.className = 'sub-comments';
							ul.innerHTML = json.text;
							prev.insertAdjacentHTML('afterend', ul.outerHTML);
						}

						track('comment/reply/submit');
					}else{
						var newRpl = rpl.cloneNode(true);
						newRpl.className ='rpl';

						if(commsUl.childElementCount == 0){
							commsUl.previousSibling.nodeValue = '';
						}

						commsUl.insertAdjacentHTML('afterbegin', json.text + newRpl.outerHTML);

						track('comment/new/submit');
					}
					document.getElementById('wkArtCnt').innerText = json.counter;
				}
			});
		}
	}

	//init
	$(function(){
		wrapper = $('#wkArtCom');
		loadMore = document.getElementById('commMore');
		loadPrev = document.getElementById('commPrev');
		commsUl = document.getElementById('wkComUl');
		totalPages = ~~wrapper.data('pages'); // double-tilde is a faster alternative to Math.floor()
		postComm = document.getElementById('wkCommFrm');
		rpl = document.getElementsByClassName('fkRpl')[0];

		if(totalPages > 1 && wgArticleId){
			loadMore.addEventListener(clickEvent, clickHandler);
			loadPrev.addEventListener(clickEvent, clickHandler);
		}

		wrapper.on(clickEvent, '.rpl', function(){
			var rplComm = postComm.cloneNode(true);

			rplComm.getElementsByTagName('input')[0].name = 'wpArticleReply';

			this.className = '';
			this.innerHTML = '';
			this.appendChild(rplComm);
			this.getElementsByTagName('textarea')[0].focus();

			track('comment/reply/form/show');
		})
		.on('submit', '#wkCommFrm', post)
		.on(clickEvent, '.collSec', function(){
			track(['comment',(this.className.indexOf('open')>-1?'close':'open')]);
		});
	});
})();