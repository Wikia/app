import Component from '@ember/component';
import hljs from 'npm:highlight.js/lib/highlight.js';

export default Component.extend({
	classNameBindings: ['language'],
	language: 'html',
	tagName: 'pre',

	didInsertElement() {
		hljs.highlightBlock(this.element);
	}
});
