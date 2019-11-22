import { communicator } from "../communicator";

export function dispatchRailReady() {
	communicator.dispatch({ type: '[Rail] Ready' });
}
