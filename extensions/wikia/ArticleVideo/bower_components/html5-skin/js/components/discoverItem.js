var React = require('react'),
    Utils = require('./utils');

var DiscoverItem = React.createClass({
  getInitialState: function() {
    return {
      imgError: false
    };
  },

  componentWillMount: function() {
    var img = new Image();
    img.src = this.props.src;

    // check if error occurs while loading img
    img.onerror = function() {
      this.setState({
        imgError: true
      });
    }.bind(this);
  },

  render: function() {
    // handle img error, return null
    if (this.state.imgError) {
      return null;
    }

    var thumbnailStyle = {
      backgroundImage: "url('" + this.props.src + "')"
    };

    var itemTitleStyle = {
      color: Utils.getPropertyValue(this.props.skinConfig, 'discoveryScreen.contentTitle.font.color'),
      fontFamily: Utils.getPropertyValue(this.props.skinConfig, 'discoveryScreen.contentTitle.font.fontFamily')
    };

    return (
      <div className="oo-discovery-image-wrapper-style">
        <div className="oo-discovery-wrapper">
          <a onClick={this.props.onClickAction}>
            <div className="oo-image-style" style={thumbnailStyle}></div>
          </a>
          {this.props.children}
        </div>
        <div className={this.props.contentTitleClassName} style={itemTitleStyle} dangerouslySetInnerHTML={Utils.createMarkup(this.props.contentTitle)}></div>
      </div>
    );
  }
});

DiscoverItem.propTypes = {
  skinConfig: React.PropTypes.shape({
    discoveryScreen: React.PropTypes.shape({
      contentTitle: React.PropTypes.shape({
        font: React.PropTypes.shape({
          color: React.PropTypes.string,
          fontFamily: React.PropTypes.string
        })
      })
    })
  })
};

module.exports = DiscoverItem;
