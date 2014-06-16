/*global define*/
define('ext.wikia.adEngine.slot.topInContentBoxad', [
	'wikia.log',
	'wikia.document',
	'ext.wikia.adEngine.eventDispatcher'
], function (log, document, eventDispatcher) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.slot.topInContentBoxad',
		result = null,

		slotName = 'TOP_IN_CONTENT_BOXAD';


	function doesNotBreakContent(slot) {

		var wikiaArticleDiv,
			wikiaArticleCloneDiv,
			fragment,
			adPlace;


		if (slotName !== slot[0]) {
			return true;
		}

		if (result !== null) {
			log(['doesNotBreakContent result', result], 'debug', logGroup);

			return result;
		}

		result = false;
		fragment = document.createDocumentFragment();
		wikiaArticleDiv = document.getElementById('WikiaArticle');

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

		adPlace.setAttribute('style', 'display:block;height:250px;width:300px');
		wikiaArticleCloneDiv.style.position = 'absolute';
		wikiaArticleCloneDiv.style.visibility = 'hidden';

		wikiaArticleDiv.parentNode.insertBefore(fragment, wikiaArticleDiv);

		if (wikiaArticleDiv.offsetHeight + 125 > wikiaArticleCloneDiv.offsetHeight) {
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
