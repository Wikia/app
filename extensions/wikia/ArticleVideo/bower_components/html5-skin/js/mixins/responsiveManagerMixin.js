var ReactDOM = require('react-dom'),
    ClassNames = require('classnames'),
    debounce = require('lodash.debounce');

var ResponsiveManagerMixin = {
  getInitialState: function() {
      return {
        componentWidth: null,
        responsiveClass: null,
        responsiveId: null
      };
  },

  componentDidMount: function() {
    window.addEventListener('resize', debounce(this.onResize, 150));
    window.addEventListener('webkitfullscreenchange', debounce(this.onResize, 150));
    this.generateResponsiveData();
  },

  componentWillUnmount: function() {
    window.removeEventListener('resize', this.onResize);
    window.removeEventListener('webkitfullscreenchange', this.onResize);
  },

  onResize: function() {
    this.generateResponsiveData();
  },

  generateResponsiveData: function() {
    var componentWidth = ReactDOM.findDOMNode(this).getBoundingClientRect().width;
    var breakpoints = this.props.skinConfig.responsive.breakpoints;
    var breakpointData = {
      classes: {},
      ids: {}
    };

    //loop through breakpoints from skinConfig
    //generate Classname object with name and min/max width
    for (var key in breakpoints) {
      if (breakpoints.hasOwnProperty(key)) {
        //min width only, 1st breakpoint
        if(breakpoints[key].minWidth && !breakpoints[key].maxWidth) {
          breakpointData.classes[breakpoints[key].name] = breakpointData.ids[breakpoints[key].id] = componentWidth >= breakpoints[key].minWidth;
        }
        //min and max, middle breakpoints
        else if(breakpoints[key].minWidth && breakpoints[key].maxWidth) {
          breakpointData.classes[breakpoints[key].name] = breakpointData.ids[breakpoints[key].id] = componentWidth >= breakpoints[key].minWidth && componentWidth <= breakpoints[key].maxWidth;
        }
        //max width only, last breakpoint
        else if(breakpoints[key].maxWidth && !breakpoints[key].minWidth) {
          breakpointData.classes[breakpoints[key].name] = breakpointData.ids[breakpoints[key].id] = componentWidth <= breakpoints[key].maxWidth;
        }
      }
    }

    //set responsive data to state
    this.setState({
      componentWidth: componentWidth,
      responsiveClass: ClassNames(breakpointData.classes),
      responsiveId: ClassNames(breakpointData.ids)
    });
  }
};
module.exports = ResponsiveManagerMixin;