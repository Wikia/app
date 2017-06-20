jest.dontMock('../../js/components/thumbnailCarousel')
  .dontMock('../../js/components/thumbnail')
  .dontMock('../../js/components/utils');

var React = require('react');
var TestUtils = require('react-addons-test-utils');
var ReactDOM = require('react-dom');
var Thumbnail = require('../../js/components/thumbnail');
var ThumbnailCarousel = require('../../js/components/thumbnailCarousel');
var Utils = require('../../js/components/utils');

var testThumbnails = function(DOM, thumbnails, hoverTime, width, duration) {
  var hoverPosition = Utils.findThumbnail(thumbnails, hoverTime, duration).pos;
  var centerImage = ReactDOM.findDOMNode(DOM.refs.thumbnailCarousel);
  var images = centerImage._parentNode._childNodes;

  var lastLeft = 0;
  var next = 0;
  for (var i = 0; i < hoverPosition && i < images.length; i++) {
    var imageStyle = images[i]._style;
    var img = imageStyle._values["background-image"];
    var left = parseInt(imageStyle._values["left"]);
    if (i > 0 && left > lastLeft) { // left edge of scrubber bar reached,  now check images to the right of central, remember index where we stopped
      next = hoverPosition - i;
      break;
    }
    var offset = img.indexOf("url(") + 4;
    lastLeft = left;
    expect(img.slice(offset, -1)).toBe(thumbnails.data.thumbnails[thumbnails.data.available_time_slices[hoverPosition - i - 1]][width]["url"]);
  }
  for (var i = hoverPosition + 1 - next; i < images.length; i++) {
    var imageStyle = images[i]._style;
    var img = imageStyle._values["background-image"];
    var offset = img.indexOf("url(") + 4;
    expect(img.slice(offset, -1)).toBe(thumbnails.data.thumbnails[thumbnails.data.available_time_slices[i + next]][width]["url"]);
  }
}

describe('ThumbnailCarousel', function () {
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

  it('creates a ThumbnailCarousel at 50 sec', function () {
    var hoverTime = 50; // should find thumbnails that correspond to time slice of 50 as there is a time slice for the value of 50
    var width = thumbnails.data.available_widths[0];
    var DOM = TestUtils.renderIntoDocument(
      <ThumbnailCarousel
        duration={100}
        hoverTime={hoverTime}
        scrubberBarWidth={200}
        carouselWidth="154"
        carouselHeight="102"
        thumbnailWidth="93"
        thumbnailHeight="63"
        thumbnails={thumbnails}/>
    );
    var centerImage = ReactDOM.findDOMNode(DOM.refs.thumbnailCarousel).style._values['background-image'];
    centerImage = centerImage.slice(centerImage.indexOf("url(") + 4, -1);
    expect(centerImage).toBe(thumbnails.data.thumbnails[hoverTime][width]["url"]); //50 is present in the data, so hoverTime of 50 should find exact match
  });

  it('creates a ThumbnailCarousel at 45 sec', function () {
    var hoverTime = 45; // should find thumbnails that correspond to time slice of 40 as there is no exact time slice match for the value of 45
    var width = thumbnails.data.available_widths[0];
    var DOM = TestUtils.renderIntoDocument(
      <ThumbnailCarousel
        duration={100}
        hoverTime={hoverTime}
        scrubberBarWidth={200}
        carouselWidth="154"
        carouselHeight="102"
        thumbnailWidth="93"
        thumbnailHeight="63"
        thumbnails={thumbnails}/>
    );
    var centerImage = ReactDOM.findDOMNode(DOM.refs.thumbnailCarousel).style._values['background-image'];
    centerImage = centerImage.slice(centerImage.indexOf("url(") + 4, -1);
    expect(centerImage).toBe(thumbnails.data.thumbnails[hoverTime - 5][width]["url"]);//45 is not present in the data, so hoverTime of 45 should find previous value
  });

  it('test generation of left and right thumbnails at various times', function () {
    var duration = 100;
    var width = thumbnails.data.available_widths[0];
    for (var hoverTime = 0; hoverTime <= 100; hoverTime += 5) {
      var DOM = TestUtils.renderIntoDocument(
          <ThumbnailCarousel
           duration={duration}
           hoverTime={hoverTime}
           scrubberBarWidth={800}
           carouselWidth="154"
           carouselHeight="102"
           thumbnailWidth="93"
           thumbnailHeight="63"
           thumbnails={thumbnails}/>
      );

      testThumbnails(DOM, thumbnails, hoverTime, width, duration);
    }
  });
});