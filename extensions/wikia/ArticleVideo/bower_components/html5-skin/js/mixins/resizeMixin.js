/**
 * Fires handleResize() function if player width (props.componentWidth) changes
 *
 * @mixin ResizeMixin
 * @fires handleResize()
 * @param props.componentWidth
 * @this component using ResizeMixin
 */

var ResizeMixin = {
  componentWillReceiveProps: function(nextProps) {
    if (nextProps.componentWidth != this.props.componentWidth) {
      this.handleResize(nextProps);
    }
  }
};
module.exports = ResizeMixin;