import Base from './Base';
import {stringToHtml} from "./utils";

export default class Spoiler extends Base {
	constructor({item: {moveTo}}) {
		super(...arguments);

		this.moveTo = moveTo;

		this.attachListeners();
	}

	createElement({content, moveTo, displayAt}) {
		const domString = `
				<div class="wikia-spoiler wikia-annotation--spoiler">
					<div class="wikia-spoiler__icon--close">
						<img src="https://cdn3.iconfinder.com/data/icons/status/100/close_4-512.png" />
					</div>
					<div>
						<div class="wikia-spoiler__icon--warning">
							<img src="https://d30y9cdsu7xlg0.cloudfront.net/png/1635-200.png" />
						</div>
						<div class="wikia-spoiler__text">
							${content}
						</div>
						<div class="wikia-spoiler__forward">
							Fast-forward by ${moveTo - displayAt} seconds 
							<span class="wikia-spoiler__icon--forward">
								<img src="https://cdn3.iconfinder.com/data/icons/line/36/fastforward-512.png" />
							</span>
						</div>
					</div>
				</div>
			`;

		return stringToHtml(domString);
	}

	attachListeners() {
		this.element.querySelector('.wikia-spoiler__forward').addEventListener('click', () => {
			this.playerInstance.trigger('spoilerFastForwarded');
			this.playerInstance.seek(this.moveTo);
			this.remove();
		});

		this.element.querySelector('.wikia-spoiler__icon--close').addEventListener('click', () => {
			this.playerInstance.trigger("spoilerDismissed");
			this.remove();
		})
	}
}
