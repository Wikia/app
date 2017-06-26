/**
 * Panel component for video quality selection
 *
 * @module VideoQualityPanel
 */
var React = require('react'),
    AutoplaySwitch = require('./autoplaySwitch');

var ConfigPanel = React.createClass({
    handleVideoQualityClick: function () {
        this.props.toggleQualityAction();
    },

    render: function() {
        return (
            <div className="oo-config-panel">
                    <ul>
                        <li><a onClick={this.handleVideoQualityClick}>Video Quality <svg className="oo-chevron" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 14a.997.997 0 0 1-.707-.293l-7-7a.999.999 0 1 1 1.414-1.414L9 11.586l6.293-6.293a.999.999 0 1 1 1.414 1.414l-7 7A.997.997 0 0 1 9 14" fill-rule="evenodd"/>
                        </svg></a></li>
                        <li className="oo-autoplay-element">Autoplay Videos<AutoplaySwitch autoPlay={this.props.controller.state.autoPlay} {...this.props} /></li>
                    </ul>
            </div>
        );
    }
});


module.exports = ConfigPanel;