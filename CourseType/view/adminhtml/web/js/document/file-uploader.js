/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'jquery',
    'Magento_Ui/js/form/element/file-uploader'
], function ($, fileuploader) {
    'use strict';

    return fileuploader.extend({
        addFile: function (file) {
            this._super();
            file = this.processFile(file);
            $('input[name="file_label"]').val(file.name.split('.').shift());
            $('input[name="file_name"]').val(file.name);
            return this._super(file);
        }
    });
});
