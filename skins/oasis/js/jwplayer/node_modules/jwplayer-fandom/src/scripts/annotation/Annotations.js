import Base from './Base';
import { stringToHtml } from "./utils";

export default class Annotation extends Base {
	constructor() {
		super(...arguments);
	}

	createElement({ text, linksTo }) {
		const domString = `
				<div class="wikia-annotation wikia-annotation--annotation">
					<a href="${linksTo}" class="wikia-annotation__text">
						${text}
					</a>
				</div>
			`;

		return stringToHtml(domString);
	}
}
