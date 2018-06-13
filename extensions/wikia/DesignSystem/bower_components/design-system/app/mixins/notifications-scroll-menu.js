import Mixin from '@ember/object/mixin';

export default Mixin.create({
	classNameBindings: ['isLoadingNewResults'],
	almostBottom: 100,

	didInsertElement() {
		this._super(...arguments);

		this.onScroll = this.onScroll.bind(this);

		this.element.addEventListener('scroll', this.onScroll);
		this.element.addEventListener('mousewheel', this.onMouseWheel);
		this.element.addEventListener('DOMMouseScroll', this.onMouseWheel);
	},

	willDestroyElement() {
		this._super(...arguments);

		this.element.removeEventListener('scroll', this.onScroll);
		this.element.addEventListener('mousewheel', this.onMouseWheel);
		this.element.addEventListener('DOMMouseScroll', this.onMouseWheel);
	},

	onScroll(event) {
		if (this.hasAlmostScrolledToTheBottom(event.target)) {
			this.get('notifications').loadNextPage();
		}
	},

	onMouseWheel(event) {
		const delta = -event.wheelDelta || event.detail,
			scrollTop = this.scrollTop;
		if ((delta < 0 && scrollTop === 0) || (delta > 0 && this.scrollHeight - this.clientHeight - scrollTop === 0)) {
			event.preventDefault();
		}
	},

	/**
	 * Has the user scrolled almost to the bottom?
	 * @private
	 */
	hasAlmostScrolledToTheBottom(element) {
		return element.scrollHeight - this.get('almostBottom') <= element.scrollTop + element.offsetHeight;
	}

});

