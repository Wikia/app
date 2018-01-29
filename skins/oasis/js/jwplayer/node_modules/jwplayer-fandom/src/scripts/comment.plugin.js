import wikiaJWPlayerIcons from './icons';
import { createSVG, hideElement, showElement, createArrowIcon, createToggle, clearListElement } from "./DOMHelpers";

const isActiveClass = 'is-active';

export default function wikiaJWPlayerCommentPlugin(player, config, div) {
	this.player = player;
	this.container = div;
	this.wikiaCommentElement = document.createElement('div');
	this.buttonID = 'wikiaComment';
	this.config = config;
	this.documentClickHandler = this.documentClickHandler.bind(this);

	this.container.classList.add('wikia-jw-comment__plugin');
	this.wikiaCommentElement.classList.add('wikia-jw-comment');
	this.addCommentContent(this.wikiaCommentElement);
	
	this.container.appendChild(this.wikiaCommentElement);

	document.addEventListener('click', this.documentClickHandler);
	// fixes issue when opening the menu on iPhone 5, executing documentClickHandler twice doesn't break anything
	document.addEventListener('touchend', this.documentClickHandler);
	this.show();
}

wikiaJWPlayerCommentPlugin.prototype.isCommentMenuOrCommentButton = function (element) {
	const button = this.getCommentButtonElement();

	return button && (button === element ||
		button.contains(element) ||
		this.wikiaCommentElement === element ||
		this.wikiaCommentElement.contains(element));
};

wikiaJWPlayerCommentPlugin.prototype.getCommentButtonElement = function () {
	return this.player.getContainer().querySelector('[button=' + this.buttonID + ']');
};

wikiaJWPlayerCommentPlugin.prototype.documentClickHandler = function (event) {
	// check if user didn't click the comment menu or comment button and if comment menu is open
	if (!this.isCommentMenuOrCommentButton(event.target) && this.container.style.display) {
		this.close();
	}
};

wikiaJWPlayerCommentPlugin.prototype.addButton = function () {
	const commentIcon = createSVG(wikiaJWPlayerIcons.comment);
	commentIcon.classList.add('jw-svg-icon');
	commentIcon.classList.add('jw-svg-icon-wikia-comment');

	this.player.addButton(commentIcon.outerHTML, this.config.i18n.comment, function () {
		if (!this.wikiaCommentElement.style.display) {
			this.open();
		} else {
			this.close();
		}
	}.bind(this), this.buttonID, 'wikia-jw-comment-button');
};

wikiaJWPlayerCommentPlugin.prototype.removeButton = function () {
	this.player.removeButton(this.buttonID);
};

/**
 * closes comment menu
 */
wikiaJWPlayerCommentPlugin.prototype.close = function () {
	this.container.style.display = null;
	this.player.getContainer().classList.remove('wikia-jw-comment-open');
	this.player.play();
};

/**
 * opens comment menu
 */
wikiaJWPlayerCommentPlugin.prototype.open = function () {
	this.player.pause();
	showElement(this.container);
	this.player.getContainer().classList.add('wikia-jw-comment-open');
};

/**
 * hides the entire plugin (button and comment menu)
 */
wikiaJWPlayerCommentPlugin.prototype.hide = function () {
	this.close();
	this.removeButton();
};

/**
 * shows back the entire plugin (adds button back)
 */
wikiaJWPlayerCommentPlugin.prototype.show = function () {
	
	if (!this.getCommentButtonElement()) {
		this.addButton();
	}
};

wikiaJWPlayerCommentPlugin.prototype.addCommentContent = function (div) {
	div.classList.add('wikia-jw-comment');
	div.classList.remove('jw-reset');
	div.classList.remove('jw-plugin');
	this.commentForm = this.createCommentForm();
	div.appendChild(this.commentForm);

	return div;
};

// autoplay button specific methods
wikiaJWPlayerCommentPlugin.prototype.createCommentForm = function () {
	const form = document.createElement('form');
	const input = document.createElement('input');
	const button = document.createElement('button');

	form.className = 'comment-form';
	input.type = 'text';
	input.placeholder = 'Type in your comment';
	button.type = 'submit';
	button.innerHTML = 'Post';
	button.className = 'wds-is-text wds-button';

	form.appendChild(input);
	form.appendChild(button);

	form.addEventListener('submit', (evt) => {
		evt.preventDefault();
		evt.stopPropagation();

		const val = input.value;

		if (val) {
			fetch('https://services.wikia-dev.pl/video-annotations/videos/10/comments', {
				headers: {
					'Accept': 'application/json, text/plain, */*',
					'Content-Type': 'application/json'
				},
				method: 'POST',
				credentials: 'include',
				body: JSON.stringify({
					content: val,
					displayAt: this.player.getPosition()
				})
			})
				.then((response) => {
					return response.json()
				})
				.then((commentData) => {
					input.value = '';
					this.player.trigger('comment', { commentData })
					this.close();
				})
		}
	});

	form.addEventListener('keydown', (evt) => {
		evt.stopPropagation();
	});

	return form;
};

wikiaJWPlayerCommentPlugin.register = function () {
	jwplayer().registerPlugin('wikiaComment', '8.0.0', wikiaJWPlayerCommentPlugin);
};
