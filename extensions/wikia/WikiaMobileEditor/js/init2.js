document.addEventListener('DOMContentLoaded', function(){

    require(['config', 'editor', 'menu'], function(config, editor, menu){

        config.init();
    });
});