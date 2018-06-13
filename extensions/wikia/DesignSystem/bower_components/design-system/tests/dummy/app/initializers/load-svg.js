function htmlToElement(html) {
	const template = document.createElement('template');

	template.insertAdjacentHTML('beforeend', html);

	return template.firstChild;
}

function loadSvg(src) {
	const ajax = new XMLHttpRequest();

	ajax.onload = () => {
		const element = htmlToElement(ajax.responseText);

		element.style.cssText = 'height: 0; width: 0; position: absolute; overflow: hidden;';
		document.body.insertBefore(element, document.body.firstChild);
	};

	ajax.onerror = (error) => {
		throw new URIError(`The resource ${error.target.src} is not accessible.`);
	};

	ajax.open('GET', src, true);
	ajax.send();
}

export function initialize(application) {
	const rootURL = application.resolveRegistration('config:environment').rootURL;

	loadSvg(`${rootURL}svg/sprite.svg`);
}

export default {
	name: 'load-svg',
	initialize
};
