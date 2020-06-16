import { Communicator, setupPostQuecast } from "@wikia/post-quecast";

class CommunicationService {
	action$;
	/**
	 * @private
	 */
	communicator;

	constructor() {
		setupPostQuecast();
		this.communicator = new Communicator();
		this.action$ = this.communicator.actions$;
	}

	dispatch(action) {
		this.communicator.dispatch(action);
	}
}

export const communicationService = new CommunicationService();
