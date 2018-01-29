import { stringToHtml } from "./utils";
import Comment from "./Comments";

export default class AnnotationStream {
	constructor(playerInstance, options = {}) {
		this.list = [];
		this.playerInstance = playerInstance;
		this.currentlyVisibleAnnotations = [];
		this.currentlyVisibleSpoiler = null;
		this.wrapper = this.createWrapper();
		this.options = Object.assign({}, {amount: 2, delay: 5000}, options);

		this.attachListeners();
	}

	attachListeners() {
		console.log('#######', 'base');
		this.playerInstance.on('time', ({ position }) => {
			const nextAnnotation = this.findLastSuitableElement(position);
			const nextSpoiler = this.findNextSuitableSpoiler(position);

			if (nextAnnotation && !this.currentlyVisibleAnnotations.includes(nextAnnotation)) {
				this.manageElements(nextAnnotation);
			}

			if (nextSpoiler && !nextSpoiler.wasDisplayed() && nextSpoiler !== this.currentlyVisibleSpoiler) {
				this.currentlyVisibleSpoiler = nextSpoiler;

				this.playerInstance.pause();
				this.currentlyVisibleSpoiler.show();

				this.wrapper.parentNode.insertBefore(nextSpoiler.element, this.wrapper);
			}
		});

		this.playerInstance.on('comment', ({ commentData }) => {
			this.add([
				new Comment({
					item: commentData,
					playerInstance: this.playerInstance
				})
			]);
		});

		this.playerInstance.on('ready', () => this.attachWrapper());

		this.playerInstance.on('spoilerFastForwarded', () => this.restorePlayer());
		this.playerInstance.on('spoilerDismissed', () => this.restorePlayer());
	}

	createWrapper() {
		return stringToHtml(`<div class="wikia-annotation__wrapper"></div>`);
	}

	attachWrapper() {
		this.playerInstance.getContainer().appendChild(this.wrapper);
	}

	add(items) {
		this.list = [...this.list, ...items].sort((a, b) => a.displayAt > b.displayAt);
		return this;
	}

	findLastSuitableElement(position) {
		const isRightMoment = (displayAt, position) => displayAt > position - 1 && displayAt < position + 1;
		const available = this.list.find(({ moveTo, displayAt }) => !this.isSpoiler(moveTo) && isRightMoment(displayAt, position));

		return available;
	}

	findNextSuitableSpoiler(position) {
		const available = this.list.filter(({ moveTo, displayAt }) => this.isSpoiler(moveTo) && displayAt < position);

		return available[available.length - 1];
	}

	isSpoiler(moveTo) {
		return Boolean(moveTo);
	}

	restorePlayer() {
		this.currentlyVisibleSpoiler = null;

		this.playerInstance.play();
	}

	manageElements(nextAnnotation) {
		if (nextAnnotation.wasDisplayed() || this.currentlyVisibleAnnotations.length >= this.options.amount) {
			return;
		}

		this.currentlyVisibleAnnotations = [ ...this.currentlyVisibleAnnotations, nextAnnotation ];

		this.wrapper.prepend(nextAnnotation.element);

		setTimeout(() => nextAnnotation.show(), 0);

		this.removeWithDelay(nextAnnotation);
	}

	removeWithDelay() {
		setTimeout(() => {
			const first = this.currentlyVisibleAnnotations.shift();

			if (first) {
				first.hide();
			}

		}, this.options.delay);
	}
}
