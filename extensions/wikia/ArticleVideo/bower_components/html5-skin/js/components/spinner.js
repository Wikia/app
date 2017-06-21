var React = require('react');

var Spinner = React.createClass({
  render: function() {
    return (
      <div className="oo-spinner-screen">
        <div className="oo-spinner-wrapper">
          <img src={this.props.loadingImage} className="oo-spinner" />
        </div>
      </div>
    );
  }
});
module.exports = Spinner;