export let contextReadyResolver;
export const contextReady = new Promise(res => contextReadyResolver = res);
