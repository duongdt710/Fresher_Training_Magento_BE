define([
    'ko',
    'uiElement',
    'uiRegisty'
], function(ko, Component, registry){
    return Component.extend({
        defaults: {
            template: 'Magenest_KnockoutJs/new-component'
        },

        message: ko.observable("this is a message"),

        initialize: function(){
            this.message("this is another message");
            uiRegistry.get(nme)
        },

        collect: function(){},
    })
});