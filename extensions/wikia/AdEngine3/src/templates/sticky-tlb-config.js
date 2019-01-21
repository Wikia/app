export const getConfig = () => ({
  adSlot: null,
  slotParams: null,
  updateNavbarOnScroll: null,

  onReady() {
    const { events } = window.Wikia.adEngine;

    const page = document.querySelector('.application-wrapper');

    page.classList.add('bfaa-template');

    events.on(events.MENU_OPEN_EVENT, () => this.adSlot.emit('unstickImmediately'));
    events.on(events.PAGE_CHANGE_EVENT, () => {
      page.classList.remove('bfaa-template');
      document.body.classList.remove('has-bfaa');
      document.body.style.paddingTop = '';
      events.emit(events.HEAD_OFFSET_CHANGE, 0);
    });
  },

  onInit(adSlot, params) {
    const { events, slotTweaker } = window.Wikia.adEngine;

    this.adSlot = adSlot;
    this.slotParams = params;
    this.navbarElement = document.querySelector('.site-head-container .site-head, .wds-global-navigation');

    const wrapper = document.querySelector('.top-leaderboard');

    wrapper.style.opacity = '0';
    slotTweaker.onReady(adSlot).then(() => {
      wrapper.style.opacity = '';
      this.onReady();
    });

    events.emit(events.SMART_BANNER_CHANGE, false);
  },

  onBeforeUnstickBfaaCallback() {
    const { CSS_TIMING_EASE_IN_CUBIC, SLIDE_OUT_TIME } = window.Wikia.adProducts.universalAdPackage;


    Object.assign(this.navbarElement.style, {
      transition: `top ${SLIDE_OUT_TIME}ms ${CSS_TIMING_EASE_IN_CUBIC}`,
      top: '0',
    });
  },

  onAfterUnstickBfaaCallback() {
    Object.assign(this.navbarElement.style, {
      transition: '',
      top: '',
    });
  },

  moveNavbar(offset) {
    const { events } = window.Wikia.adEngine;

    events.emit(events.HEAD_OFFSET_CHANGE, offset || this.adSlot.getElement().clientHeight);
    this.navbarElement.style.top = offset ? `${offset}px` : '';
  },
});

export default {
  getConfig,
};
