var React = require('react'),
    Utils = require('./utils');


var Icon = React.createClass({
  shouldComponentUpdate: function(nextProps, nextState) {
    return  (nextProps.icon != this.props.icon);
  },

  render: function() {
    if(this.props.skinConfig.icons[this.props.icon].svg) {
      var svg = {
        __html: this.props.skinConfig.icons[this.props.icon].svg
      };
      return <span dangerouslySetInnerHTML={svg} onMouseOver={this.props.onMouseOver} onMouseOut={this.props.onMouseOut}
                   onClick={this.props.onClick} className="oo-icon-svg"/>;
    }
    var iconStyle = Utils.extend({fontFamily: this.props.skinConfig.icons[this.props.icon].fontFamilyName}, this.props.style);
    return (
      <span
        className={this.props.skinConfig.icons[this.props.icon].fontStyleClass + " " + this.props.className}
        style={iconStyle}
        onMouseOver={this.props.onMouseOver} onMouseOut={this.props.onMouseOut}
        onClick={this.props.onClick}>
        {this.props.skinConfig.icons[this.props.icon].fontString}
      </span>
    );
  }
});

Icon.propTypes = {
  icon: React.PropTypes.string,
  skinConfig: React.PropTypes.object,
  className: React.PropTypes.string,
  style: React.PropTypes.object
};

Icon.defaultProps = {
  icon: "",
  skinConfig: {},
  className: "",
  style: {}
};

module.exports = Icon;