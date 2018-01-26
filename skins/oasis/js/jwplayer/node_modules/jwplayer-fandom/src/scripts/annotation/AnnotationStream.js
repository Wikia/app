import { stringToHtml } from "./utils";

export default class AnnotationStream {
	constructor(playerInstance, options = {}) {
		this.list = [];
		this.playerInstance = playerInstance;
		this.currentlyVisibleAnnotations = [];
		this.wrapper = this.createWrapper();
		this.options = Object.assign({}, {amount: 2, delay: 5000}, options);

		this.attachListeners();
	}

	attachListeners() {
		this.playerInstance.on('time', ({ position }) => {
			const nextAnnotation = this.findLastSuitableElement(position);
			
			if (nextAnnotation && !this.currentlyVisibleAnnotations.includes(nextAnnotation)) {
				this.manageElements(nextAnnotation);
			}
		});

		this.playerInstance.on('ready', () => this.attachWrapper());
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
		const available = this.list.filter((annotation) => annotation.displayAt < position);

		return available[available.length - 1];
	}

	manageElements(nextAnnotation) {
		if (nextAnnotation.isDisplayed() || this.currentlyVisibleAnnotations.length >= this.options.amount) {
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
