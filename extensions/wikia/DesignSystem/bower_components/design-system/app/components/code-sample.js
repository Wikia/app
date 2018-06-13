import Component from '@ember/component';
import {registerHljsLanguage} from '../utils/beautify';

export default Component.extend({
	classNameBindings: ['language'],
	language: 'html',
	tagName: 'pre',

	didInsertElement() {
		registerHljsLanguage();

		hljs.highlightBlock(this.element);
	}
});
