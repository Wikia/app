/**
 * Article Comments JS code for the WikiaMobile skin
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub 'Student' Olek
 **/

require(['loader', 'toast', 'modal', 'events', 'track', 'JSMessages'], function(loader, toast, modal, events, track, msg){
	"use strict";
	/** @private **/

	var d = document,
		wkArtCom = d.getElementById('wkArtCom'),
		loadMore = d.getElementById('commMore'),
		loadPrev = d.getElementById('commPrev'),
		//double-tilde is a faster alternative to Math.floor()
		totalPages = ~~wkArtCom.getAttribute('data-pages'),
		currentPage = 1,
		ajaxUrl = wgServer +
			"/index.php?action=ajax&rs=ArticleCommentsAjax&method=axGetComments&useskin=" +
			skin +
			"&article=" +
			wgArticleId,
		clickEvent = events.click,
		firstPage,
		commsUl = d.getElementById('wkComUl'),
		postReply = msg('wikiamobile-article-comments-post-reply'),
		view = msg('wikiamobile-article-comments-view'),
		replies = msg('wikiamobile-article-comments-replies'),
		postComm = d.getElementsByClassName('commFrm')[0].cloneNode(true);

	postComm.getElementsByClassName('wkInp')[0].setAttribute('placeholder', postReply);

	function clickHandler(event){
		event.preventDefault();

		var elm = this,
			forward = (elm.getAttribute('id') == 'commMore'),
			pageIndex = (forward) ? currentPage + 1 : currentPage - 1,
			condition = (forward) ? (currentPage < totalPages) : (currentPage > 1);

		if(currentPage === 1) {
			firstPage = commsUl.innerHTML;
		}

		track.event('article-comments', track.PAGINATE, {
			label: (forward) ? 'next' : 'previous'
		});

		if(condition){
			elm.className += ' active';
			loader.show(elm, {size: '30px'});

			Wikia.ajax({
				url: ajaxUrl + '&page=' + ~~pageIndex,
				dataType: 'json',
				success: function(result){
					var finished;

					currentPage = pageIndex;
					finished = (forward) ? (currentPage == totalPages) : (currentPage == 1);

					commsUl.innerHTML = result.text;

					elm.className = elm.className.replace(' active', '');
					loader.hide(elm);

					//there's a good reason to use display instead of show/hide in the following lines
					if(finished) {
						elm.style.display = 'none';
					}

					((forward) ? loadPrev : loadMore).style.display = 'block';

					wkArtCom.scrollIntoView();
				}
			});
		}
	}

	function loginRequired(ev){
		if(window.wgDisableAnonymousEditing && !window.wgUserName){
			ev.stopPropagation();

			var target = ev.target,
				elm = (target.nodeName == 'FORM') ? target : target.parentElement,
				prev = elm.previousElementSibling;

			target.blur();

			toast.show(msg('wikiamobile-article-comments-login-post'), {error: true});

			require(['topbar'], function(t){
				t.openProfile('comm-' + (prev ? (prev.id || 'wkComm') : elm.parentElement.id));
				modal.close(true);
			});

			return true;
		}
		return false;
	}

	function post(ev) {
		ev.preventDefault();
		ev.stopPropagation();
		if(!loginRequired(ev)){

			var form = ev.target,
				parent = form.previousElementSibling,
				parentId = (parent) ? parent.id : false,
				submit = form.getElementsByTagName('input')[0],
				textArea = form.getElementsByClassName('wkInp')[0],
				text = textArea.value;

			if(text !== '') {
				submit.disabled =  true;
				loader.show(form, {size: '35px', center: true});

				var data = {
					action: 'ajax',
					article: wgArticleId,
					method: 'axPost',
					rs: 'ArticleCommentsAjax',
					title: wgPageName,
					wpArticleComment: text,
					useskin: 'wikiamobile'
				};

				if(parentId) {
					data.parentId = parentId;
				}

				Wikia.ajax({
					url: wgScript,
					data: data,
					dataType: 'json',
					type: 'POST',
					success: function(json) {
						textArea.value = '';

						if(!json.error && json.text){

							if(currentPage > 1){
								commsUl.innerHTML = firstPage;
								currentPage = 1;
								loadPrev.style.display = 'none';
							}

							if(parentId){
								updateUI(json.text, parent);
								track.event('article-comments', track.SUBMIT, {
									label: 'reply'
								});
							}else{
								commsUl.insertAdjacentHTML('afterbegin', json.text);
								track.event('article-comments', track.SUBMIT, {
									label: 'new'
								});
							}
							d.getElementById('wkArtCnt').innerText = json.counter;
						}

						submit.disabled = false;
						loader.hide(form);
					}
				});
			}
		}
	}

	function updateUI(comment, parent){
		var realparent = d.getElementById(parent.id),
			rply = realparent.lastElementChild,
			cnt = ~~rply.getAttribute('data-replies')+1,
			subs = realparent.getElementsByClassName('sub-comments')[0],
			viewAll = rply.getElementsByClassName('viewAll')[0];

		//append reply to a original place and in modal
		if(subs){
			subs.insertAdjacentHTML('beforeend', comment);
			parent.getElementsByClassName('sub-comments')[0].insertAdjacentHTML('beforeend', comment);
		}else{
			var ul = '<ul class=sub-comments>' + comment + '</ul>';
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
		modal.setToolbar(replies + ' ('+cnt+')');
	}

	function openModal(elm, focus){
		var parent = elm.parentElement,
			num = ~~parent.getAttribute('data-replies'),
			toolbar = num ? replies + ' (' + num + ')' : postReply;

		modal.open({
			classes: 'cmnMdl',
			content: parent.parentElement.outerHTML + postComm.outerHTML,
			toolbar: toolbar,
			stopHiding: true,
			scrollable: true,
			onOpen: (function(){
				return focus ?
					/*
						If this is reply action focus on input and scroll to it
						otherwise scroll to top
					*/
					function(content){
						var input = content.getElementsByClassName('wkInp')[0];
						if(input){
							input.scrollIntoView();
							input.focus();
						}
					}:
					function(){
						window.scrollTo(0,0);
					};
			})()
		});
	}

	if(totalPages > 1 && wgArticleId){
		loadMore.addEventListener(clickEvent, clickHandler, true);
		loadPrev.addEventListener(clickEvent, clickHandler, true);
	}

	wkArtCom.addEventListener(clickEvent, function(ev){
		var t = ev.target,
			className = t.className;

		if(className.indexOf('viewAll') > -1){
			openModal(t);
			track.event('article-comments', track.CLICK, {
				label: 'open'
			});
		}else if(className.indexOf('cmnRpl') > -1){
			if(!loginRequired(ev)){
				openModal(t, true);
				track.event('article-comments', track.CLICK, {
					label: 'open'
				});
			}
		}else if(className.indexOf('avatar') > -1){
			track.event('article-comments', track.IMAGE_LINK, {
				label: 'avatar',
				href: t.parentElement.href
			});
		}
	});

	d.body.addEventListener('submit', function(ev){
		var t = ev.target;

		if(t.className.indexOf('commFrm') > -1){
			post(ev);
		}
	});

	d.body.addEventListener(clickEvent, function(ev){
		var t = ev.target;

		if(t.matchesSelector('.commFrm textarea')){
			loginRequired(ev);
		}
	});
});