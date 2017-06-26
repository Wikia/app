var React = require('react'),
    Utils = require('./utils'),
    CONSTANTS = require('../constants/constants'),
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
        var onCaptionClassName = ClassNames({
            'oo-switch-captions oo-switch-captions-on': true,
            'oo-switch-captions-active': this.props.autoPlay.enabled
        });
        var offCaptionClassName = ClassNames({
            'oo-switch-captions oo-switch-captions-off': true,
            'oo-switch-captions-active': !this.props.autoPlay.enabled
        });
        var ccOnStyle =  {backgroundColor: this.props.autoPlay.enabled && this.props.skinConfig.general.accentColor ? this.props.skinConfig.general.accentColor : null};

        return (
            <div className="oo-switch-container-autoplay" onClick={this.handleAutoPlaySwitch}>
                <span className={offCaptionClassName}></span>
                <div className="oo-switch-element-autoplay">
                    <span className={switchBodyClassName} style={ccOnStyle}></span>
                    <span className={switchThumbClassName}></span>
                </div>
                <span className={onCaptionClassName}></span>
                <a className="oo-switch-container-selectable" onClick={this.handleOnOffSwitch}></a>
            </div>
        );
    }
});

module.exports = AutoplaySwitch;