/**
 * Article Comments JS code for the WikiaMobile skin
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub 'Student' Olek
 **/

(function(){
	/** @private **/

	var wkArtCom = document.getElementById('wkArtCom'),
		wrapper = $(wkArtCom),
		loadMore = document.getElementById('commMore'),
		loadPrev = document.getElementById('commPrev'),
		totalPages = ~~wkArtCom.getAttribute('data-pages'), //double-tilde is a faster alternative to Math.floor()
		currentPage = 1,
		ajaxUrl = wgServer + "/index.php?action=ajax&rs=ArticleCommentsAjax&method=axGetComments&useskin=" + skin + "&article=" + wgArticleId,
		clickEvent = WikiaMobile.getClickEvent(),
		firstPage,
		commsUl = document.getElementById('wkComUl'),
		track = WikiaMobile.track,
		postReply = $.msg('wikiamobile-article-comments-post-reply'),
		view = $.msg('wikiamobile-article-comments-view'),
		replies = $.msg('wikiamobile-article-comments-replies'),
		postComm = document.getElementsByClassName('commFrm')[0].cloneNode(true);

	postComm.getElementsByClassName('commTxt')[0].setAttribute('placeholder', postReply);

	function clickHandler(event){
		event.preventDefault();

		var elm = this,
			forward = (elm.getAttribute('id') == 'commMore'),
			pageIndex = (forward) ? currentPage + 1 : currentPage - 1,
			condition = (forward) ? (currentPage < totalPages) : (currentPage > 1);

		if(currentPage === 1) {
			firstPage = commsUl.innerHTML;
		}

		track(['comment', 'page', (forward)?'next':'previous']);

		if(condition){
			elm.className += ' active';
			WikiaMobile.loader.show(elm, {size: '30px'});

			$.getJSON(ajaxUrl + '&page=' + ~~pageIndex, function(result){
				var finished;

				currentPage = pageIndex;
				finished = (forward) ? (currentPage == totalPages) : (currentPage == 1);

				commsUl.innerHTML = result.text;

				elm.className = elm.className.replace(' active', '');
				WikiaMobile.loader.hide(elm);

				//there's a good reason to use display instead of show/hide in the following lines
				if(finished) {
					elm.style.display = 'none';
				}

				((forward) ? loadPrev : loadMore).style.display = 'block';

				window.scrollTo(0, wkArtCom.offsetTop);
			});
		}
	}

	function post(ev) {
		ev.preventDefault();
		if(!loginRequired(ev)){

			var form = this,
				parent = form.previousElementSibling,
				parentId = (parent) ? parent.id : false,
				submit = form.getElementsByTagName('input')[0],
				textArea = form.getElementsByClassName('commTxt')[0],
				text = textArea.value;

			if(text !== '') {
				submit.disabled =  true;
				WikiaMobile.loader.show(form, {size: '35px', center: true});

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

					if(!json.error && json.text){

						if(currentPage > 1){
							commsUl.innerHTML = firstPage;
							currentPage = 1;
							loadPrev.style.display = 'none';
						}

						if(parentId){
							updateUI(json.text, parent);

							track('comment/reply/submit');
						}else{
							commsUl.insertAdjacentHTML('afterbegin', json.text);

							track('comment/new/submit');
						}
						document.getElementById('wkArtCnt').innerText = json.counter;
					}

					submit.disabled = false;
					WikiaMobile.loader.hide(form);
				});
			}
		}
	}

	function updateUI(comment, parent){
		var realparent = document.getElementById(parent.id),
			rply = realparent.lastElementChild,
			cnt = ~~rply.getAttribute('data-replies')+1,
			subs = realparent.getElementsByClassName('sub-comments')[0],
			viewAll = rply.childNodes[1];

		//append reply to a original place and in modal
		if(subs){
			subs.insertAdjacentHTML('beforeend', comment);
			parent.getElementsByClassName('sub-comments')[0].insertAdjacentHTML('beforeend', comment);
		}else{
			var ul = '<ul class=sub-comments>'+comment+'</ul>';
			realparent.insertAdjacentHTML('beforeend', ul);
			parent.insertAdjacentHTML('beforeend', ul);
		}

		//update links to open a modal
		rply.setAttribute('data-replies', cnt);

		if(viewAll){
			viewAll.innerHTML = view + ' ('+cnt+')';
		}else{
			rply.insertAdjacentHTML('beforeend', '<span class=viewAll>'+view+' (1)</span>');
		}

		//update counters
		require('modal', function(modal){
			modal.setToolbar(replies + ' ('+cnt+')');
		});
	}

	function loginRequired(ev){

		if(window.wgDisableAnonymousEditing && UserLogin.isForceLogIn()){
			WikiaMobile.toast.show($.msg('wikiamobile-article-comments-login-post'), {error: true});

			var elm = (ev.currentTarget.nodeName == 'FORM') ? ev.currentTarget : ev.currentTarget.parentElement,
				prev = elm.previousElementSibling;

			if(prev && prev.nodeName == 'LI'){
				window.location.hash = 'comm-' + prev.id;
			}else{
				window.location.hash = 'comm-' + elm.parentElement.id;
			}

			return true
		}
		return false;
	}

	function openModal(elm, focus){
		require('modal', function(modal){
			var parent = elm.parentElement,
				num = parent.getAttribute('data-replies'),
				toolbar = (~~num) ? replies + ' (' + num + ')' : postReply;

			modal.open({
				classes: 'cmnMdl',
				content: parent.parentElement.outerHTML + postComm.outerHTML,
				toolbar: toolbar,
				stopHiding: true
			});

			var area = document.getElementById('wkMdlCnt').getElementsByClassName('commTxt')[0];

			if(focus) area.focus();
		});
	}

	if(totalPages > 1 && wgArticleId){
		loadMore.addEventListener(clickEvent, clickHandler);
		loadPrev.addEventListener(clickEvent, clickHandler);
	}

	wrapper.on(clickEvent, '.viewAll', function(){
		openModal(this);
		window.scroll(0,0);
		track('comment/modal/open');
	})
	.on(clickEvent, '.cmnRpl', function(ev){
		ev.stopPropagation();
		if(!loginRequired(ev)){
			openModal(this, true);
			track('comment/modal/open/reply');
		}
	})
	.on(clickEvent, '.collSec', function(){
		track(['comment',(this.className.indexOf('open')>-1?'close':'open')]);
	});

	$(document.body).on('submit', '.commFrm', post)
	.on(clickEvent, '.commFrm textarea', function(ev){
		loginRequired(ev);
	});
})();