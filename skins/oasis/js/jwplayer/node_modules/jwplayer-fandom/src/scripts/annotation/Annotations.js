import Base from './Base';
import { stringToHtml } from "./utils";

export default class Annotation extends Base {
	constructor() {
		super(...arguments);
	}

	createElement({ content, linksTo }) {
		const domString = `
				<div class="wikia-annotation wikia-annotation--annotation">
					<a href="${linksTo}" class="wikia-annotation__text">
						${content}
					</a>
				</div>
			`;

		return stringToHtml(domString);
	}
}
