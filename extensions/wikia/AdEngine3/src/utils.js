import  { utils } from '@wikia/ad-engine';

export async function waitForContentAndJS() {
    const extendedPromise = utils.createExtendedPromise();

    window.wgAfterContentAndJS.push(() => {
        extendedPromise.resolve();
    });

    return extendedPromise
}
