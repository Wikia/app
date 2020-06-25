import { Communicator, setupPostQuecast } from "@wikia/post-quecast";
import { fromEventPattern } from "rxjs";
import { shareReplay } from "rxjs/operators";

class CommunicationService {
	action$;
	/**
	 * @private
	 */
	communicator;

	constructor() {
		setupPostQuecast();
		this.communicator = new Communicator();
		this.action$ = fromEventPattern(
			(handler) => this.communicator.addListener(handler),
			(handler) => this.communicator.removeListener(handler),
		).pipe(shareReplay({ refCount: true }));
	}

	dispatch(action) {
		this.communicator.dispatch({ ...action, __global: true });
	}
}

export const communicationService = new CommunicationService();
