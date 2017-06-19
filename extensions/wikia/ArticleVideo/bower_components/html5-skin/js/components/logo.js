var React = require('react');

var Logo = React.createClass({
  render: function() {
    var content = this.props.clickUrl ?
      (<a href={this.props.clickUrl} target={this.props.target}>
        <img width={this.props.width} height={this.props.height} src={this.props.imageUrl}/>
      </a>) :
      // if no link just show img
      <img width={this.props.width} height={this.props.height} src={this.props.imageUrl}/>;

    return (
      <div className="oo-logo oo-control-bar-item" style={this.props.style}>
        {content}
      </div>
    );
  }
});

Logo.propTypes = {
  imageUrl: React.PropTypes.string.isRequired,
  clickUrl: React.PropTypes.string,
  target: React.PropTypes.string,
  width: React.PropTypes.oneOfType([
    React.PropTypes.string,
    React.PropTypes.number
  ]),
  height: React.PropTypes.oneOfType([
    React.PropTypes.string,
    React.PropTypes.number
  ]),
  style: React.PropTypes.object
};

Logo.defaultProps = {
  imageUrl: '/assets/images/ooyala.png',
  clickUrl: '',
  target: '_blank',
  width: null,
  height: null,
  style: {}
};

module.exports = Logo;