import wikiaJWPlayerIcons from './icons';

const domParser = new DOMParser();

export function createToggle(params) {
	const toggleWrapper = document.createElement('li'),
		toggleInput = document.createElement('input'),
		toggleLabel = document.createElement('label');

	toggleWrapper.className = 'wikia-jw-settings__toggle';

	toggleInput.className = 'wds-toggle__input';
	toggleInput.id = params.id;
	toggleInput.type = 'checkbox';
	toggleInput.checked = params.checked;

	toggleLabel.className = 'wds-toggle__label';
	toggleLabel.setAttribute('for', params.id);

	toggleLabel.appendChild(document.createTextNode(params.label));

	toggleWrapper.appendChild(toggleInput);
	toggleWrapper.appendChild(toggleLabel);

	return toggleWrapper;
}

/**
 * Available directions:
 * - left
 * - right
 *
 * @param {String} direction
 * @returns {HTMLElement}
 */
export function createArrowIcon(direction) {
	const arrowIcon = createSVG(wikiaJWPlayerIcons.back);

	if (direction === 'left') {
		arrowIcon.classList.add('wikia-jw-settings__back-icon');
	} else {
		arrowIcon.classList.add('wikia-jw-settings__right-arrow-icon');
	}

	return arrowIcon;
}

export function clearListElement(element) {
	if (element) {
		while (element.childElementCount > 1) {
			element.removeChild(element.firstChild);
		}
	}
}

export function createSVG(svgHtml) {
	return domParser.parseFromString(svgHtml, 'image/svg+xml').documentElement;
}

export function showElement(element) {
	if (element) {
		element.style.display = 'block';
	}
}

export function hideElement(element) {
	if (element) {
		element.style.display = 'none';
	}
}
