define( 'ext.wikia.AffiliateService.templates', [], function() { 
    'use strict'; 

    function unit(options) {
        return '<div class="aff-unit__wrapper">'
            + '<a class="aff-unit__link" href="' + options.link + '" target="_blank">'
            + '<div class="aff-unit__image-wrapper" style="background-image: url(' + options.image + ')"></div>'
            + '<div class="aff-unit__info">'
            + '<p class="aff-unit__header">' + options.heading + '</p>'
            + '<button class="wds-button wds-is-secondary aff-unit__cta">' + options.buttonText + '</button>'
            + '<img class="aff-unit__logo light" src="' + options.logoLight + '">'
            + '<img class="aff-unit__logo dark" src="' + options.logoDark + '">'
            + '</div>'
            + '</a>'
            + '</div>';
    }
    
    return {
        unit: unit,
    }; 
});
