jest.dontMock('../../js/components/discoveryPanel')
    .dontMock('../../js/components/discoverItem')
    .dontMock('../../js/components/icon')
    .dontMock('../../js/components/utils')
    .dontMock('classnames');

var React = require('react');
var ReactDOM = require('react-dom');
var TestUtils = require('react-addons-test-utils');
var DiscoveryPanel = require('../../js/components/discoveryPanel');

describe('DiscoveryPanel', function () {
  it('tests displays discovery panel', function () {
    var data = {"relatedVideos":[{"provider_id":69468, "name":"owl", "description":"owl video", "status":"live", "size":742937, "updated_at":"2015-11-03 18:13:34 +0000", "created_at":"2015-05-19 20:56:21 +0000", "processing_progress":1, "preview":"1", "content_type":"Video", "language":"en", "duration":6066, "preview_image_url":"http://cf.c.ooyala.com/o2Ymc2dTpIcimIbgA4eI6oSWbrpyFPhA/promo256337880", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/o2Ymc2dTpIcimIbgA4eI6oSWbrpyFPhA/promo256337880</url>\n<width>1</width>\n<height>1</height>\n</previewImage>" }, { "provider_id":69468, "name":"sintel_small.m4v", "description":null, "status":"live", "size":62834341, "preview":"1", "content_type":"Video", "language":"en", "duration":887666, "preview_image_url":"http://cf.c.ooyala.com/dvdm4zcDrDDrt60-lIcLnMo_SRAGxYTw/3Gduepif0T1UGY8H4xMDoxOjBrO-I4W8", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/dvdm4zcDrDDrt60-lIcLnMo_SRAGxYTw/3Gduepif0T1UGY8H4xMDoxOjBrO-I4W8</url>\n<width>640</width>\n<height>272</height>\n</previewImage>" }, { "provider_id":69468, "name":"husky.mp4", "description":null, "status":"live", "size":878625, "preview":"1", "content_type":"Video", "language":"en", "duration":6458, "preview_image_url":"http://cf.c.ooyala.com/EyYWl3bzo3_YP5iIRhbgJnQvTvGf_yV0/Ut_HKthATH4eww8X4xMDoxOjBmO230Ws", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/EyYWl3bzo3_YP5iIRhbgJnQvTvGf_yV0/Ut_HKthATH4eww8X4xMDoxOjBmO230Ws</url>\n<width>480</width>\n<height>480</height>\n</previewImage>" }, { "provider_id":69468, "name":"lulz.mp4", "description":null, "status":"live", "size":809516, "preview":"1", "content_type":"Video", "language":"en", "duration":6884, "preview_image_url":"http://cf.c.ooyala.com/o5MzF0bjo0llfNt3PM2CdM2nwavPrBb0/Ut_HKthATH4eww8X4xMDoxOmlsO8wKIQ", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/o5MzF0bjo0llfNt3PM2CdM2nwavPrBb0/Ut_HKthATH4eww8X4xMDoxOmlsO8wKIQ</url>\n<width>690</width>\n<height>312</height>\n</previewImage>" }, { "provider_id":69468, "name":"nyc-skyline.mp4", "description":null, "status":"live", "size":2641394, "preview":"1", "content_type":"Video", "language":"en", "duration":29800, "preview_image_url":"http://cf.c.ooyala.com/IwOTQ1bjrpmqST_eRIr9KTb6XAVOrFa3/Ut_HKthATH4eww8X4xMDoxOm1qO3pqzy", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/IwOTQ1bjrpmqST_eRIr9KTb6XAVOrFa3/Ut_HKthATH4eww8X4xMDoxOm1qO3pqzy</url>\n<width>630</width>\n<height>354</height>\n</previewImage>" }, { "provider_id":69468, "name":"Test Asset", "description":"from vine", "status":"live", "size":1080819, "preview":"1", "content_type":"Video", "language":"en", "duration":6800, "preview_image_url":"http://cf.c.ooyala.com/JqNW0ybjpSRty5FCfgbVmsaIL6uK67Dd/Ut_HKthATH4eww8X4xMDoxOjBmO230Ws", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/JqNW0ybjpSRty5FCfgbVmsaIL6uK67Dd/Ut_HKthATH4eww8X4xMDoxOjBmO230Ws</url>\n<width>480</width>\n<height>480</height>\n</previewImage>" } ]};

    //Render discovery panel into DOM
    var DOM = TestUtils.renderIntoDocument(<DiscoveryPanel discoveryData={data} />);

    //test left btn
    var leftBtn = DOM.refs.ChevronLeftButton;
    TestUtils.Simulate.click(leftBtn);

    //test right btn
    var rightBtn = DOM.refs.ChevronRightButton;
    TestUtils.Simulate.click(rightBtn);

    //test discovery videos
    var vidImg = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-image-style');
    var vidName = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-discovery-content-name');
    //loop through all videos, test expected values from mock data
    for (var i=0; i<data.relatedVideos.length; i++) {
      expect(ReactDOM.findDOMNode(vidImg[i]).style.backgroundImage).toEqual("url("+data.relatedVideos[i].preview_image_url+")");
      expect(vidName[i].textContent).toEqual(data.relatedVideos[i].name);
    }

    //test discovery video click
    var video = TestUtils.scryRenderedDOMComponentsWithTag(DOM, 'a');
    var vid1 = video[0];
    TestUtils.Simulate.click(vid1);
  });

  it('tests displays discovery panel with countdown clock', function () {
    var data = {"relatedVideos":[{"provider_id":69468, "name":"owl", "description":"owl video", "status":"live", "size":742937, "updated_at":"2015-11-03 18:13:34 +0000", "created_at":"2015-05-19 20:56:21 +0000", "processing_progress":1, "preview":"1", "content_type":"Video", "language":"en", "duration":6066, "preview_image_url":"http://cf.c.ooyala.com/o2Ymc2dTpIcimIbgA4eI6oSWbrpyFPhA/promo256337880", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/o2Ymc2dTpIcimIbgA4eI6oSWbrpyFPhA/promo256337880</url>\n<width>1</width>\n<height>1</height>\n</previewImage>" } ]};

    //Render discovery panel into DOM
    var DOM = TestUtils.renderIntoDocument(<DiscoveryPanel discoveryData={data} playerState="end" />);

    //test clock click
    var discoveryClock = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-discovery-count-down-icon-style');
    expect(discoveryClock).toBeDefined();
    TestUtils.Simulate.click(discoveryClock);
  });
});