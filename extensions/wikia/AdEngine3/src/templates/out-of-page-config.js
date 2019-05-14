import { slotService, slotTweaker } from '@wikia/ad-engine';

const invisibleHighImpactWrapperId = 'InvisibleHighImpactWrapper';

export const getConfig = () => (
  {
    onInit: () => {
      const wrapper = document.getElementById(invisibleHighImpactWrapperId);
      const slot = slotService.get('invisible_high_impact_2');

      wrapper.classList.add('out-of-page-template-loaded');
      wrapper.classList.remove('hidden');

      slotTweaker.onReady(slot)
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
