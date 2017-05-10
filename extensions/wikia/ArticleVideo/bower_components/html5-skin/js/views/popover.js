var React = require('react');

var Popover = React.createClass({

  render: function() {
    return (
      <div className={this.props.popoverClassName}>
        {this.props.children}
      </div>
    );
  }
});

Popover.defaultProps = {
  popoverClassName: 'oo-popover',
};

module.exports = Popover;