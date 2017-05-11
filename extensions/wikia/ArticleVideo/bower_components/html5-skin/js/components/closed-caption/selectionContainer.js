var React = require('react');

var SelectionContainer = React.createClass({
  render: function() {
    return(
      <div className={"oo-selection-container" + (this.props.className ? " " + this.props.className : "")}>
        <div className="oo-selection-inner-wrapper">
          <div className="oo-selection-container-title">
            {this.props.title}: <span className="oo-selection-container-selection-text">{this.props.selectionText}</span>
          </div>
          <div className="oo-selection-items-container">
            {this.props.children}
          </div>
        </div>
      </div>
    );
  }
});

module.exports = SelectionContainer;