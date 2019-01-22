import { context, slotService, utils } from '@wikia/ad-engine';
import { getAdProductInfo } from '@wikia/ad-engine/dist/ad-products';
import { throttle } from 'lodash';

const PAGE_TYPES = {
  article: 'a',
  home: 'h',
};

function setSlotState(slotName, state) {
  if (state) {
    slotService.enable(slotName);
  } else {
    slotService.disable(slotName);
  }
}

export default {
  getContext() {
    return {
      TOP_LEADERBOARD: {
        aboveTheFold: true,
        firstCall: true,
        adProduct: 'top_leaderboard',
        slotNameSuffix: '',
        group: 'LB',
        options: {},
        slotShortcut: 'l',
        sizes: [
          {
            viewportSize: [1440, 0],
            sizes: [
              [728, 90],
              [970, 66],
              [970, 90],
              [970, 150],
              [970, 180],
              [970, 250],
              [970, 365],
              [1024, 416],
              [1030, 65],
              [1030, 130],
              [1030, 250],
              [1440, 585],
            ],
          },
          {
            viewportSize: [1024, 0],
            sizes: [
              [728, 90],
              [970, 66],
              [970, 90],
              [970, 150],
              [970, 180],
              [970, 250],
              [970, 365],
              [1024, 416],
              [1030, 65],
              [1030, 130],
              [1030, 250]
            ],
          },
        ],
        defaultSizes: [[728, 90]],
        defaultTemplates: [],
        targeting: {
          loc: 'top',
          rv: 1,
        },
      },
      TOP_BOXAD: {
        adProduct: 'top_boxad',
        aboveTheFold: true,
        bidderAlias: 'TOP_RIGHT_BOXAD',
        slotNameSuffix: '',
        group: 'MR',
        options: {},
        slotShortcut: 'm',
        sizes: [
          {
            viewportSize: [1024, 1300],
            sizes: [
              [300, 250],
              [300, 600],
              [300, 1050]
            ],
          },
        ],
        defaultSizes: [[300, 250], [300, 600]],
        targeting: {
          loc: 'top',
          pos: ['TOP_BOXAD', 'TOP_RIGHT_BOXAD'],
          rv: 1,
        },
      },
      INVISIBLE_SKIN: {
        adProduct: 'invisible_skin',
        aboveTheFold: true,
        slotNameSuffix: '',
        group: 'PX',
        options: {},
        slotShortcut: 'x',
        sizes: [
          {
            viewportSize: [1240, 0],
            sizes: [
              [1, 1],
              [1000, 1000],
            ],
          },
        ],
        defaultSizes: [[1, 1]],
        targeting: {
          loc: 'top',
          rv: 1,
        },
      },
      INCONTENT_BOXAD_1: {
        adProduct: 'incontent_boxad_1',
        slotNameSuffix: '',
        group: 'HiVi',
        options: {},
        slotShortcut: 'f',
        sizes: [],
        defaultSizes: [[120, 600], [160, 600], [300, 250], [300, 600]],
        targeting: {
          loc: 'hivi',
          rv: 1,
        },
      },
      BOTTOM_LEADERBOARD: {
        adProduct: 'bottom_leaderboard',
        slotNameSuffix: '',
        group: 'PF',
        options: {},
        slotShortcut: 'b',
        sizes: [
          {
            viewportSize: [1024, 0],
            sizes: [
              [728, 90],
              [970, 250],
            ],
          },
        ],
        defaultSizes: [[728, 90]],
        targeting: {
          loc: 'footer',
          rv: 1,
        },
      },
      FEATURED: {
        adProduct: 'featured',
        slotNameSuffix: '',
        nonUapSlot: true,
        group: 'VIDEO',
        lowerSlotName: 'featured',
        defaultSizes: [[640, 480]],
        targeting: {
          rv: 1
        },
        trackingKey: 'featured-video',
      },
      VIDEO: {
        adProduct: 'video',
        slotNameSuffix: '',
        nonUapSlot: true,
        group: 'VIDEO',
        lowerSlotName: 'video',
        defaultSizes: [[640, 480]],
        targeting: {
          rv: 1
        },
        trackingKey: 'video',
      },
    };
  },

  setupSlotParameters(slot) {
    const audioSuffix = slot.config.audio === true ? '-audio' : '';
    const clickToPlaySuffix = slot.config.autoplay === true || slot.config.videoDepth > 1 ? '' : '-ctp';

    slot.setConfigProperty('slotNameSuffix', clickToPlaySuffix || audioSuffix || '');
    slot.setConfigProperty('targeting.audio', audioSuffix ? 'yes' : 'no');
    slot.setConfigProperty('targeting.ctp', clickToPlaySuffix ? 'yes' : 'no');
  },

  setupStates() {
    setSlotState('TOP_LEADERBOARD', true);
    setSlotState('TOP_BOXAD', true);
    setSlotState('INCONTENT_BOXAD_1', true);
    setSlotState('BOTTOM_LEADERBOARD', true);

    setSlotState('INVISIBLE_SKIN', false);

    setSlotState('FEATURED', context.get('custom.hasFeaturedVideo'));

    // TODO: Remove those slots once AE3 is globally enabled
    setSlotState('TOP_LEADERBOARD_AB', false);
    setSlotState('GPT_FLUSH', false);
  },

  setupIdentificators() {
    const pageTypeParam = PAGE_TYPES[context.get('wiki.targeting.pageType')] || 'x';
    const slotsDefinition = context.get('slots');

    // Wikia Page Identificator
    context.set('targeting.wsi', `ox${pageTypeParam}1`);
    Object.keys(slotsDefinition).forEach((key) => {
      const slotParam = slotsDefinition[key].slotShortcut || 'x';
      context.set(`slots.${key}.targeting.wsi`, `o${slotParam}${pageTypeParam}1`);
    });
  },

  setupSlotVideoAdUnit(adSlot, params) {
    if (params.isVideoMegaEnabled) {
      const adProductInfo = getAdProductInfo(adSlot.getSlotName(), params.type, params.adProduct);
      const adUnit = utils.stringBuilder.build(
        context.get('vast.megaAdUnitId'),
        {
          slotConfig: {
            group: adProductInfo.adGroup,
            adProduct: adProductInfo.adProduct,
          },
        },
      );

      context.set(`slots.${adSlot.getSlotName()}.videoAdUnit`, adUnit);
    }
  },

  injectBottomLeaderboard() {
    const pushSlotAfterComments = throttle(() => {
      if (window.ArticleComments && !window.ArticleComments.initCompleted) {
        return;
      }

      // TODO: Recovery part
      document.removeEventListener('scroll', pushSlotAfterComments);
      context.push('events.pushOnScroll.ids', 'BOTTOM_LEADERBOARD');
    }, 250);

    document.addEventListener('scroll', pushSlotAfterComments);
  },
};
