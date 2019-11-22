import { communicator } from "../communicator";
import { ofType } from "@wikia/post-quecast";
import { take } from "rxjs/operators";

export function listenSetupJWPlayer(callback) {
	communicator.actions$
		.pipe(
			ofType('[Ad Engine] setup jw player'),
			take(1)
		)
		.subscribe(callback);
}
