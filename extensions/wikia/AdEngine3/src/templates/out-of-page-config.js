import { slotTweaker } from '@wikia/ad-engine';

const invisibleHighImpactWrapperId = 'InvisibleHighImpactWrapper';

export const getConfig = () => (
  {
    onInit: (adSlot) => {
      const wrapper = document.getElementById(invisibleHighImpactWrapperId);

      wrapper.classList.add('out-of-page-template-loaded');
      wrapper.classList.remove('hidden');

      slotTweaker.onReady(adSlot)
        .then(() => {
          wrapper.querySelector('.button-close').addEventListener('click', () => {
            wrapper.classList.add('hidden');
          });
        });
    },
  }
);

export default {
  getConfig,
};
