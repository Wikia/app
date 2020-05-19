define( 'ext.wikia.AffiliateService.templates', [], function() {
    'use strict';

    function unit(options) {
        var logos = '';
        var disclaimer = '';
        var extra_disclaimer = '';

        if (options.logoLight) {
            logos = '<img class="aff-unit__logo light" src="' + options.logoLight + '">'
                + '<img class="aff-unit__logo dark" src="' + options.logoDark + '">';
        }

        if (options.showDisclaimer) {
            disclaimer = '<p class="aff-unit__disclaimer-message">'
                + options.disclaimerMessage
                + '</p>';
        }

        if (options.extra_disclaimer) {
            extra_disclaimer = '<p class="aff-unit__extra-disclaimer-message">'
                + options.extra_disclaimer
                + '</p>';
        }

        return '<div class="aff-unit__wrapper" data-campaign="' + options.campaign + '" data-category="' + options.category + '">'
            + '<a class="aff-unit__link" href="' + options.link + '" target="_blank">'
            + '<div class="aff-unit__image-wrapper" style="background-image: url(' + options.image + ')"></div>'
            + '<div class="aff-unit__info">'
            + '<p class="aff-unit__header">' + options.heading + '</p>'
            + '<button class="wds-button wds-is-secondary aff-unit__cta">' + options.buttonText + '</button>'
            + logos
            + '</div>'
            + '</a>'
            + '</div>'
            + disclaimer + ' '
            + extra_disclaimer
    }

    return {
        unit: unit,
    };
});
