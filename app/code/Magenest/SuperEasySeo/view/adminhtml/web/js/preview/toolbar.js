define(['ko', 'uiComponent'], function (ko, Component) {
    return Component.extend({
        defaults: {},
        canonicalUrl: ko.observable(),
        seoHeader: ko.observable(),
        metaTitle: ko.observable(),
        LengthMetaTitle: ko.observable(),
        metaDescription: ko.observable(),
        showSnippet: ko.observable(),

        initialize: function () {
            return this._super();
        },

        update: function (data) {
            if (data.url_key) {
                this.canonicalUrl(data.url_key);
            }

            if (data.name) {
                this.seoHeader(data.name);
            }

            if (data.meta_title) {
                this.metaTitle(data.meta_title);
            }

            if (data.size) {
                this.LengthMetaTitle(data.size);
            }

            if (data.meta_description) {
                this.metaDescription(data.meta_description);
            }

            if (data.show_snippet) {
                this.showSnippet(data.show_snippet);
            }
        }
    })
})