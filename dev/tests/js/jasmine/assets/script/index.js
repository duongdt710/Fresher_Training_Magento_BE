/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'tests/assets/tools',
    'text!./config.json',
    'text!./template/selector.html',
    'text!./template/virtual.html'
], function (tools, config, selectorTmpl, virtualTmpl) {
    'use strict';

    return tools.init(config, {
        bySelector: selectorTmpl,
        virtual: virtualTmpl
    });
});
