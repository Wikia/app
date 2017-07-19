var React = require('react'),
    Utils = require('./utils');

var Slider = React.createClass({

  componentDidMount: function() {
    this.handleSliderColoring(this.props);
  },

  componentWillReceiveProps: function(nextProps) {
    if (nextProps.value != this.props.value) {
      this.handleSliderColoring(nextProps);
    }
  },

  handleSliderColoring: function(props){
    if (!Utils.isEdge()){
      var input = this.refs[this.props.itemRef];
      var style = window.getComputedStyle(input, null);

      var colorBeforeThumb = style.getPropertyValue("border-left-color");
      var colorAfterThumb = style.getPropertyValue("border-right-color");

      var value = (props.value - props.minValue)/(props.maxValue - props.minValue);
      input.style.backgroundImage = [
        '-webkit-gradient(',
          'linear, ',
          'left top, ',
          'right top, ',
          'color-stop(' + value + ', '+ colorBeforeThumb + '), ',
          'color-stop(' + value + ', '+ colorAfterThumb + ')',
        ')'
      ].join('');
    }
  },

  changeValue: function(event) {
    if (event.type == 'change' && !Utils.isIE()){
      this.props.onChange(event);
      this.handleSliderColoring(this.props);
    }
    else if (Utils.isIE()) {
      this.props.onChange(event);
    }
  },

  render: function() {
    return (
      <input type="range" className={this.props.className} min={this.props.minValue} max={this.props.maxValue} 
           value={this.props.value} step={this.props.step} ref={this.props.itemRef}
           onChange={this.changeValue} onClick={this.changeValue} onMouseMove={this.changeValue}/>
    );
  }
});
module.exports = Slider;