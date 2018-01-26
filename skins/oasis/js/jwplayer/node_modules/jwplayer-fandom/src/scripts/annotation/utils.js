const parser = new DOMParser();

export const stringToHtml = (domString) => {
	const html = parser.parseFromString(domString, 'text/html');

	return html.body.firstChild;
};
