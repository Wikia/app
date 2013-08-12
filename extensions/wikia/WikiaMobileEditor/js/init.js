document.addEventListener('DOMContentLoaded', function(){
    require(['config', 'menu'], function(config, menu){
        menu.init();
        //config.init();
    });
});