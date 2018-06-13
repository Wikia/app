const indentChar = '	';

/**
 * @see http://stackoverflow.com/a/26361620/1050577
 * @param {Element} node
 * @param {Number} level
 * @returns {Element}
 */
function format(node, level) {
	let indentBefore = new Array(level++ + 1).join(indentChar);
	let indentAfter = new Array(level - 1).join(indentChar);
	let textNode;

	for (let i = 0; i < node.children.length; i++) {
		textNode = document.createTextNode('\n' + indentBefore);
		node.insertBefore(textNode, node.children[i]);

		format(node.children[i], level);

		if (node.lastElementChild == node.children[i]) {
			textNode = document.createTextNode('\n' + indentAfter);
			node.appendChild(textNode);
		}
	}

	return node;
}

export default function (raw) {
	const div = document.createElement('div');

	div.innerHTML = raw.replace(/\n/g, '').replace(/<!---->/g, '');

	return format(div, 0).innerHTML.trim().replace(/disabled=""/g, 'disabled');
}
