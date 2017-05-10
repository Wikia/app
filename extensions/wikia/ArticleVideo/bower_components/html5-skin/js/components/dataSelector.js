var React = require('react'),
    ClassNames = require('classnames'),
    Icon = require('./icon');

var DataSelector = React.createClass({
  getInitialState: function() {
    return {
      currentPage: 1
    };
  },

  handleDataSelection: function(dataItem) {
    this.props.onDataChange(dataItem);
  },

  handleLeftChevronClick: function(event) {
    event.preventDefault();
    this.setState({
      currentPage: this.state.currentPage - 1
    });
  },

  handleRightChevronClick: function(event) {
    event.preventDefault();
    this.setState({
      currentPage: this.state.currentPage + 1
    });
  },

  componentWillReceiveProps: function(nextProps) {
    //If we are changing view sizes, adjust the currentPage number to reflect the new number of items per page.
    if (nextProps.responsiveView != this.props.viewSize) {
      var currentViewSize = this.props.viewSize;
      var nextViewSize = nextProps.responsiveView;
      var firstDataIndex = this.state.currentPage * this.props.dataItemsPerPage[currentViewSize] - this.props.dataItemsPerPage[currentViewSize];
      var newCurrentPage = Math.floor(firstDataIndex/nextProps.dataItemsPerPage[nextViewSize]) + 1;
      this.setState({
        currentPage: newCurrentPage
      });
    }
  },

  setClassname: function(item) {
    return ClassNames({
      'oo-item': true,
      'oo-item-selected': this.props.selectedData == item && this.props.enabled,
      'oo-disabled': !this.props.enabled
    });
  },

  render: function() {
    //pagination
    var currentViewSize = this.props.viewSize;
    var dataItemsPerPage = this.props.dataItemsPerPage[currentViewSize];
    var startAt = dataItemsPerPage * (this.state.currentPage - 1);
    var endAt = dataItemsPerPage * this.state.currentPage;
    var dataItems = this.props.availableDataItems.slice(startAt, endAt);

    //Build data content blocks
    var dataContentBlocks = [];
    for (var i = 0; i < dataItems.length; i++) {
      //accent color
      var selectedItemStyle = {};
      if (this.props.selectedData == dataItems[i] && this.props.enabled && this.props.skinConfig.general.accentColor) {
        selectedItemStyle = {backgroundColor: this.props.skinConfig.general.accentColor};
      }

      dataContentBlocks.push(
        <a className={this.setClassname(dataItems[i])}  style={selectedItemStyle} onClick={this.handleDataSelection.bind(this, dataItems[i])} key={i}>
          <span className="oo-data">{dataItems[i]}</span>
        </a>
      );
    }

    var leftChevron = ClassNames({
      'oo-left-button': true,
      'oo-hidden': !this.props.enabled || this.state.currentPage <= 1
    });
    var rightChevron = ClassNames({
      'oo-right-button': true,
      'oo-hidden': !this.props.enabled || endAt >= this.props.availableDataItems.length
    });

    return(
      <div className="oo-data-selector">
        <div className="oo-data-panel oo-flexcontainer">
          {dataContentBlocks}
        </div>

        <a className={leftChevron} ref="leftChevron" onClick={this.handleLeftChevronClick}>
          <Icon
            {...this.props}
            icon="left"
          />
        </a>
        <a className={rightChevron} ref="rightChevron" onClick={this.handleRightChevronClick}>
          <Icon
            {...this.props}
            icon="right"
          />
        </a>
      </div>
    );
  }
});

module.exports = DataSelector;