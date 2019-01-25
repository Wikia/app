import { context, events, utils } from '@wikia/ad-engine';
import { billTheLizard } from '@wikia/ad-engine/dist/ad-services';
import { methods } from './executor';
import { bucketizeViewportHeight } from './buicketizer';
import instantGlobals from '../instant-globals';
import pageTracker from '../tracking/page-tracker';

function setupProjects() {
  if (context.get('wiki.targeting.hasFeaturedVideo')) {
    billTheLizard.projectsHandler.enable('queen_of_hearts');
    billTheLizard.projectsHandler.enable('vcr');
  }
}

function setupExecutor() {
  Object.keys(methods).forEach(function (methodName) {
    billTheLizard.executor.register(methodName, methods[methodName]);
  });
}

export const billTheLizardConfigurator = {
  configure() {
    const config = instantGlobals.get('wgAdDriverBillTheLizardConfig', {});
    const { mediaId, videoTags } = context.get('wiki.targeting.featuredVideo') || {};
    const now = new Date();
    const [browserName] = utils.client.getBrowser().split(' ');

    context.set('services.billTheLizard.parameters', {
      queen_of_hearts: {
        browser: browserName,
        device: utils.client.getDeviceType(),
        esrb: context.get('targeting.esrb') || null,
        geo: utils.getCountryCode() || null,
        lang: context.get('targeting.lang'),
        npa: context.get('targeting.npa'),
        os: utils.client.getOperatingSystem(),
        pv: Math.min(30, context.get('targeting.pv') || 1),
        pv_global: Math.min(40, window.pvNumberGlobal || 1),
        ref: context.get('targeting.ref') || null,
        s0v: context.get('targeting.s0v') || null,
        s2: context.get('targeting.s2') || null,
        top_1k: context.get('wiki.targeting.wikiIsTop1000') ? 1 : 0,
        video_id: mediaId || null,
        video_tags: videoTags || null,
        viewport_height: bucketizeViewportHeight(Math.max(
            document.documentElement.clientHeight, window.innerHeight || 0
        )),
        wiki_id: context.get('wiki.targeting.wikiId') || null
      },
      vcr: {
        h: now.getHours(),
        pv: Math.min(30, context.get('targeting.pv') || 1),
        pv_global: Math.min(40, window.pvNumberGlobal || 1),
        ref: context.get('targeting.ref') || null
      }
    });
    context.set('services.billTheLizard.projects', config.projects);
    context.set('services.billTheLizard.timeout', config.timeout);

    if (window.wgServicesExternalDomain) {
      context.set('services.billTheLizard.host',
        window.wgServicesExternalDomain.replace(/\/$/, ''));
    }

    setupProjects();
    setupExecutor();

    events.on(events.BILL_THE_LIZARD_REQUEST, (event) => {
      let propName = 'btl_request';
      if (event.callId !== undefined) {
        propName = `${propName}_${event.callId}`;
      }

      pageTracker.trackProp(propName, event.query);
    });

    events.on(events.BILL_THE_LIZARD_RESPONSE, (event) => {
      let propName = 'btl_response';
      if (event.callId !== undefined) {
        propName = `${propName}_${event.callId}`;
      }

      pageTracker.trackProp(propName, event.response);
    });
  }
};
