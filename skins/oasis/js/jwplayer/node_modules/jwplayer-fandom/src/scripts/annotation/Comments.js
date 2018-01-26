import Base from './Base';
import { stringToHtml } from "./utils";

export default class Comment extends Base {
	constructor() {
		super(...arguments);
	}

	createElement({ content, createdBy }) {
		const domString = `
				<div class="wikia-annotation wikia-annotation--comment">
					<div class="wikia-annotation__author">
						<div class="wikia-annotation__avatar">
							<img src="${createdBy.avatarUrl}" alt="" />
						</div>
						<div class="wikia-annotation__user">
							${createdBy.username}
						</div>
					</div>
					<div class="wikia-annotation__text">
						${content}
					</div>
				</div>
			`;

		return stringToHtml(domString);
	}
}
