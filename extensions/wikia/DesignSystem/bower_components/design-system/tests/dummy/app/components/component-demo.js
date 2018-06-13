import Component from '@ember/component';
import ENV from '../config/environment';
import beautify from '../utils/beautify';

/**
 * This components supports 3 different ways to render a component demo
 * 
 * Showcase template, rendered HTML and rendered component
 * {{#component-demo name='unique-name'}}
 * 	some code to demo
 * {{/component-demo}}
 * 
 * Showcase template and rendered HTML but don't show rendered component
 * {{#component-demo name='unique-name-2' codeOnly=true}}
 *  other code to demo
 * {{/component-demo}}
 * under the hood it uses ember-code-snippet addont to get a snippet of code
 * it uses clever way of searching through code for special markers
 * that we have configured to be
 * 	begin: /{{#component-demo[^}]+name='(\S+)'/,
 * 	end: /{{\/component-demo}}/,
 * This allows us to do easy component demos
 * but it does not support multiline regexps, make sure whole component-demo invocation is on one line
 * 
 * Showcase rendered HTML only 
 * {{#component-demo codeOnly=true}}
 *  other code to demo
 * {{/component-demo}}
 */
export default Component.extend({
	classNames: ['component-demo'],

	// rendered code to demo
	renderedComponent: '',
	codeOnly: false,
	rootURL: ENV.rootURL,
	standalone: false,
	standaloneDevice: null,
	/**
	 * name of a demo e.g. name='unique-name-of-a-demo'
	 * This have to be globally unique name
	*/
	name: null,
	showHTML: false,
	showHBS: true,
	language: 'htmlbars',
	

	didInsertElement() {
		const name = this.get('name');

		this.toggleView(name);

		if (this.get('language') !== 'scss') {
			const $component = this.$('.component-demo__rendered').clone();

			$component.find('.ember-view').removeAttr('id').removeClass('ember-view');
	
			this.set('renderedCode', beautify($component.html()));
		}
	},

	click(event) {
		if (event.target.classList.contains('component-demo__fullscreen')) {
			this.send('closeFullscreen');
		}
	},

	actions: {
		closeFullscreen() {
			this.set('standaloneDevice', null);
		},
		showFullscreen(device) {
			this.set('standaloneDevice', device);
		},
		onTabChange(tab) {
			const isHBS = tab.element.innerText.includes('HBS');
			
			this.toggleView(isHBS);
		}
	},

	toggleView(showHBS) {
		this.set('showHBS', showHBS);
		this.set('showHTML', !showHBS);
	}
});
