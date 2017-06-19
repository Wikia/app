/**
 * ThumbnailCarousel component
 *
 * @module ThumbnailCarousel
 */

var React = require('react'),
    ReactDOM = require('react-dom'),
    Utils = require('./utils');

var ThumbnailCarousel = React.createClass({
  getInitialState: function() {
    return {
      thumbnailWidth: 0,
      thumbnailHeight: 0,
      centerThumbnailWidth: 0,
      centerThumbnailHeight: 0,
      thumbnailPadding: 6
    };
  },

  componentDidMount: function() {
    var thumbnail = ReactDOM.findDOMNode(this.refs.thumbnail);
    var carousel = ReactDOM.findDOMNode(this.refs.thumbnailCarousel);
    var thumbnailStylePadding = thumbnail ? window.getComputedStyle(thumbnail, null).getPropertyValue("padding") : 0;
    thumbnailStylePadding = parseFloat(thumbnailStylePadding); // convert css px to number
    var thumbnailPadding = !isNaN(thumbnailStylePadding) ? thumbnailStylePadding : this.state.thumbnailPadding;

    if (thumbnail && carousel) {
      if (thumbnail.clientWidth && carousel.clientWidth) {
        this.setState({
          thumbnailWidth: thumbnail.clientWidth,
          thumbnailHeight: thumbnail.clientHeight,
          centerThumbnailWidth: carousel.clientWidth,
          centerThumbnailHeight: carousel.clientHeight,
          thumbnailPadding: thumbnailPadding
        });
      } else {
        var thumbnailStyleWidth = thumbnail ? window.getComputedStyle(thumbnail, null).getPropertyValue("width") : 0;
        thumbnailStyleWidth = parseFloat(thumbnailStyleWidth); // convert css px to number
        var thumbnailWidth = !isNaN(thumbnailStyleWidth) ? thumbnailStyleWidth : parseInt(this.props.thumbnailWidth);

        var thumbnailStyleHeight = thumbnail ? window.getComputedStyle(thumbnail, null).getPropertyValue("height") : 0;
        thumbnailStyleHeight = parseFloat(thumbnailStyleHeight); // convert css px to number
        var thumbnailHeight = !isNaN(thumbnailStyleHeight) ? thumbnailStyleHeight : parseInt(this.props.thumbnailHeight);

        var carouselStyleWidth = carousel ? window.getComputedStyle(carousel, null).getPropertyValue("width") : 0;
        carouselStyleWidth = parseFloat(carouselStyleWidth); // convert css px to number
        var carouselWidth = !isNaN(carouselStyleWidth) ? carouselStyleWidth : parseInt(this.props.carouselWidth);

        var carouselStyleHeight = carousel ? window.getComputedStyle(carousel, null).getPropertyValue("height") : 0;
        carouselStyleHeight = parseFloat(carouselStyleHeight); // convert css px to number
        var carouselHeight = !isNaN(carouselStyleHeight) ? carouselStyleHeight : parseInt(this.props.carouselHeight);

        this.setState({
          thumbnailWidth: thumbnailWidth,
          thumbnailHeight: thumbnailHeight,
          centerThumbnailWidth: carouselWidth,
          centerThumbnailHeight: carouselHeight,
          thumbnailPadding: thumbnailPadding
        });
      }
    }
  },

  findThumbnailsAfter: function(data) {
    var start = (data.scrubberBarWidth + data.centerWidth) / 2;
    var thumbnailsAfter = [];
    for (var i = data.pos + 1, j = 0; i < data.timeSlices.length; i++, j++) {
      var left = start + data.padding + j * (data.imgWidth + data.padding);
      if (left + data.imgWidth <= data.scrubberBarWidth) {
        var thumbStyle = { left: left, top: data.top, backgroundImage: "url(" + data.thumbnails.data.thumbnails[data.timeSlices[i]][data.width].url + ")" };
        thumbnailsAfter.push(<div className="oo-thumbnail-carousel-image" key={i} ref="thumbnail" style={thumbStyle}></div>);
      }
    }
    return thumbnailsAfter;
  },

  findThumbnailsBefore: function(data) {
    var start = (data.scrubberBarWidth - data.centerWidth) / 2;

    var thumbnailsBefore = [];
    for (var i = data.pos - 1, j = 0; i >= 0; i--, j++) {
      var left = start - (j + 1) * (data.imgWidth + data.padding);
      if (left >= 0) {
        var thumbStyle = { left: left, top: data.top, backgroundImage: "url(" + data.thumbnails.data.thumbnails[data.timeSlices[i]][data.width].url + ")" };
        thumbnailsBefore.push(<div className="oo-thumbnail-carousel-image" key={i} ref="thumbnail" style={thumbStyle}></div>);
      }
    }
    return thumbnailsBefore;
  },

  render: function() {
    var centralThumbnail = Utils.findThumbnail(this.props.thumbnails, this.props.hoverTime, this.props.duration);
    var data = {
      thumbnails: this.props.thumbnails,
      timeSlices: this.props.thumbnails.data.available_time_slices,
      width: this.props.thumbnails.data.available_widths[0],
      imgWidth: this.state.thumbnailWidth,
      centerWidth: this.state.centerThumbnailWidth,
      scrubberBarWidth: this.props.scrubberBarWidth,
      top: this.state.centerThumbnailHeight - this.state.thumbnailHeight,
      pos: centralThumbnail.pos,
      padding: this.state.thumbnailPadding
    };

    var thumbnailsBefore = this.findThumbnailsBefore(data);
    var thumbnailsAfter = this.findThumbnailsAfter(data);
    var thumbnailStyle = { left: (data.scrubberBarWidth - data.centerWidth) / 2, backgroundImage: "url(" + centralThumbnail.url + ")" };
    var time = isFinite(parseInt(this.props.hoverTime)) ? Utils.formatSeconds(parseInt(this.props.hoverTime)) : null;

    return (
      <div className="oo-scrubber-carousel-container">
        {thumbnailsBefore}
        <div className="oo-thumbnail-carousel-center-image" ref="thumbnailCarousel" style={thumbnailStyle}>
          <div className="oo-thumbnail-carousel-time">{time}</div>
        </div>
        {thumbnailsAfter}
      </div>
    );
  }
});

ThumbnailCarousel.defaultProps = {
  thumbnails: {},
  duration: 0,
  hoverTime: 0,
  scrubberBarWidth: 0
};

module.exports = ThumbnailCarousel;