define([
    "Magento_Ui/js/grid/columns/column",
    "ko",
    "uiRegistry"
], function(Column, ko, registry){
   return Column.extend({
       defaults: {
         bodyTmpl: "Magenest_SuperEasySeo/ui/grid/cells/html/preview",
           modalComponent: "toolbar"
// ,          buttonShow: "popup"
       },
       updateModalVariable: function(data, uiClass, event){
           event.preventDefault();
           event.stopPropagation();
           var modalComponent = registry.get(this.modalComponent);
           modalComponent.update(data);
           // var buttonShow = registry.get(this.buttonShow);
           // buttonShow.update(data);
       }
   })
});