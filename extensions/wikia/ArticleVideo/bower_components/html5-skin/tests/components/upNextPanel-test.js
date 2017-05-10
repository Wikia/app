jest.dontMock('../../js/components/upNextPanel');
jest.dontMock('../../js/components/closeButton');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var UpNextPanel = require('../../js/components/upNextPanel');

describe('UpNextPanel', function () {
  it('tests up next panel', function () {
    var data = {"upNextData":{"provider_id":69468, "name":"owl", "description":"owl video", "status":"live", "size":742937, "updated_at":"2015-11-03 18:13:34 +0000", "created_at":"2015-05-19 20:56:21 +0000", "processing_progress":1, "preview":"1", "content_type":"Video", "language":"en", "duration":6066, "preview_image_url":"http://cf.c.ooyala.com/o2Ymc2dTpIcimIbgA4eI6oSWbrpyFPhA/promo256337880", "preview_images":"<previewImage>\n<url>http://cf.c.ooyala.com/o2Ymc2dTpIcimIbgA4eI6oSWbrpyFPhA/promo256337880</url>\n<width>1</width>\n<height>1</height>\n</previewImage>" }};

    //Render up next panel into DOM
    DOM = TestUtils.renderIntoDocument(<UpNextPanel upNextInfo={data} />);

    //test up next content link
    var upNextContent = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-up-next-content');
    TestUtils.Simulate.click(upNextContent);

    //test close btn
    var closeBtn = TestUtils.findRenderedDOMComponentWithClass(DOM, 'oo-up-next-close-btn');
    TestUtils.Simulate.click(closeBtn);
  });
});