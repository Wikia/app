/*global define*/
define('ext.wikia.adEngine.slot.topInContentBoxad', [
	'wikia.log',
	'wikia.window',
	'wikia.document',
	'ext.wikia.adEngine.eventDispatcher'
], function (log, window, document, eventDispatcher) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.topInContentBoxad',
		slotName = 'TOP_INCONTENT_BOXAD',
		articleHeightMaxDelta = 125,
		result = null;

	function getComputedStylePropertyValue(el, cssProperty){
		if(!window.getComputedStyle){
			if(document.defaultView && document.defaultView.getComputedStyle){
				return document.defaultView.getComputedStyle.getPropertyValue(cssProperty);
			}
		}
		else{
			return window.getComputedStyle(el).getPropertyValue(cssProperty);
		}
	}

	function doesNotBreakContent(slot) {

		var wikiaArticleDiv,
			wikiaArticleCloneDiv,
			fragment,
			adPlace,
			contentFirstContentElement;

		if (slotName !== slot[0]) {
			return true;
		}

		if (result !== null) {
			log(['doesNotBreakContent result', result], 'debug', logGroup);

			return result;
		}

		if (!window.wgIsArticle) {
			log(['doesNotBreakContent result', false, 'Page is not an article'], 'debug', logGroup);

			return false;
		}

		result = false;
		fragment = document.createDocumentFragment();
		wikiaArticleDiv = document.getElementById('WikiaArticle');

		contentFirstContentElement = document.getElementById('mw-content-text').querySelector(':first-child');
		if ('right' === getComputedStylePropertyValue(contentFirstContentElement, 'float')) {
			contentFirstContentElement.style.clear = 'right';
		}
		if ('TABLE' === contentFirstContentElement.tagName && contentFirstContentElement.offsetWidth > 438 ) {
			log(['doesNotBreakContent', 'First element is full width table'], 'debug', logGroup);
			result = false;
			return result;
		}

		wikiaArticleCloneDiv = document.createElement('DIV');
		wikiaArticleCloneDiv.innerHTML = wikiaArticleDiv.innerHTML;
		wikiaArticleCloneDiv.className = 'WikiaArticle';

		fragment.appendChild(wikiaArticleCloneDiv);

		adPlace = wikiaArticleCloneDiv.querySelector('.home-top-right-ads');

		if (!adPlace) {
			log(['doesNotBreakContent', 'no ad place found'], 'debug', logGroup);
			result = false;
			return result;
		}

		adPlace.className += ' top-right-ads-in-content';
		adPlace.style.height = '250px';
		wikiaArticleCloneDiv.style.position = 'absolute';
		wikiaArticleCloneDiv.style.visibility = 'hidden';

		wikiaArticleDiv.parentNode.insertBefore(fragment, wikiaArticleDiv);

		if (wikiaArticleDiv.offsetHeight + articleHeightMaxDelta > wikiaArticleCloneDiv.offsetHeight) {
			result = true;
			adPlace = wikiaArticleDiv.querySelector('.home-top-right-ads');
			adPlace.className += ' top-right-ads-in-content';
		}

		wikiaArticleCloneDiv.parentNode.removeChild(wikiaArticleCloneDiv);

		log(['doesNotBreakContent result', result], 'debug', logGroup);
		return result;

	}

	function init() {
		log(['init', slotName], 'debug', logGroup);

		eventDispatcher.bind('ext.wikia.adEngine.adDecoratorPageDimensions fillInSlot', doesNotBreakContent);
	}

	return {
		init: init
	};
});
