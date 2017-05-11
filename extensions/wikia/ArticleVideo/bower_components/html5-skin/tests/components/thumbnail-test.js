jest.dontMock('../../js/components/thumbnail')
  .dontMock('../../js/components/utils');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var ReactDOM = require('react-dom');
var Thumbnail = require('../../js/components/thumbnail');
var Utils = require('../../js/components/utils');

describe('Thumbnail', function () {
  var thumbnails = {
    "data":{
      "available_time_slices":[
         0,
         10,
         20,
         30,
         40,
         50,
         60,
         70,
         80,
         90,
         100
      ],
      "available_widths":[
         120
        ],
      "thumbnails":{
        "0":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_000.jpg",
               "width":120,
               "height":80
            }
         },
         "10":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_010.jpg",
               "width":120,
               "height":80
            }
         },
         "20":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_020.jpg",
               "width":120,
               "height":80
            }
         },
         "30":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_030.jpg",
               "width":120,
               "height":80
            }
         },
         "40":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_040.jpg",
               "width":120,
               "height":80
            }
         },
         "50":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_050.jpg",
               "width":120,
               "height":80
            }
         },
         "60":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_060.jpg",
               "width":120,
               "height":80
            }
         },
         "70":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_070.jpg",
               "width":120,
               "height":80
            }
         },
         "80":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_080.jpg",
               "width":120,
               "height":80
            }
         },
         "90":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_090.jpg",
               "width":120,
               "height":80
            }
         },
         "100":{
            "120":{
               "url":"http://media.video-cdn.espn.com/motion/Miercoles_100.jpg",
               "width":120,
               "height":80
            }
         }
      },
      "errors":[
        {
         "status":404,
         "code":"Not Found",
         "title":"unable to find thumbnail images",
         "detail":"embed code not found"
        }
      ]
    }
  };

  it('creates and verifies thumbnails at hover times of [0, 100], step 5', function () {
    var width = thumbnails.data.available_widths[0];
    var duration = 100;
    for (var hoverTime = 0; hoverTime <= 100; hoverTime += 5) {
      var DOM = TestUtils.renderIntoDocument
      (
          <Thumbnail
           hoverPosition={hoverTime}
           duration={duration}
           hoverTime={hoverTime}
           scrubberBarWidth={100}
           thumbnails={thumbnails}/>
      );
      var thumbnail = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-thumbnail');
      var thumbnailTime = TestUtils.scryRenderedDOMComponentsWithClass(DOM, 'oo-thumbnail-time');
      var hoverPosition = Utils.findThumbnail(thumbnails, hoverTime, duration).pos;
      var node = ReactDOM.findDOMNode(DOM.refs.thumbnail);
      if (hoverTime % 10 == 0) {
        expect(node.style._values['background-image']).toBe("url("+thumbnails.data.thumbnails[hoverTime][width]["url"]+")");
      } else {
        expect(node.style._values['background-image']).toBe("url("+thumbnails.data.thumbnails[(hoverTime - 5).toString()][width]["url"]+")");
      }
      expect(thumbnail.length).toBe(1);
      expect(thumbnailTime.length).toBe(1);
    }
  });
});