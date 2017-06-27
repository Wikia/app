var React = require('react'),
    ClassNames = require('classnames');

var AutoplaySwitch = React.createClass({
    handleAutoPlaySwitch: function() {
        this.props.controller.toggleAutoPlayEnabled();
    },

    render: function(){

        var switchThumbClassName = ClassNames({
            'oo-switch-thumb-autoplay': true,
            'oo-switch-thumb-on-autoplay': this.props.autoPlay.enabled,
            'oo-switch-thumb-off-autoplay': !this.props.autoPlay.enabled
        });
        var switchBodyClassName = ClassNames({
            'oo-switch-body-autoplay': true,
            'oo-switch-body-off-autoplay': !this.props.autoPlay.enabled
        });
        var onAutoplayClassName = ClassNames({
            'oo-switch-autoplay oo-switch-autoplay-on': true,
            'oo-switch-autoplay-active': this.props.autoPlay.enabled
        });
        var offAutoplayClassName = ClassNames({
            'oo-switch-autoplay oo-switch-autoplay-off': true,
            'oo-switch-autoplay-active': !this.props.autoPlay.enabled
        });
        var autoplayOnStyle =  {backgroundColor: this.props.autoPlay.enabled && this.props.skinConfig.general.accentColor ? this.props.skinConfig.general.accentColor : null};

        return (
            <div className="oo-switch-container-autoplay" onClick={this.handleAutoPlaySwitch}>
                <span className={offAutoplayClassName}></span>
                <div className="oo-switch-element-autoplay">
                    <span className={switchBodyClassName} style={autoplayOnStyle}></span>
                    <span className={switchThumbClassName}></span>
                </div>
                <span className={onAutoplayClassName}></span>
                <a className="oo-switch-container-selectable" onClick={this.handleOnOffSwitch}></a>
            </div>
        );
    }
});

module.exports = AutoplaySwitch;