jQuery(document).ready(function ($) {
    /* Download Repeater JS */
    $('#download-items').sortable({
        items: '.apkt-repeater-item',
        cursor: 'move',
        handle: '.apkt-drag-handle',
    });

    $('#add-download-item').on('click', function () {
        var row = $('#download-item-template .apkt-repeater-item').clone(true);
        $('#download-items').prepend(row);
        return false;
    });

    // Handle remove button
    $('#download-repeater').on('click', '.remove-download-item', function () {
        $(this).closest('.apkt-repeater-item').remove();
        return false;
    });

    // Show the current value as a tooltip
    var rangeInput = $('.range-input');
    var tooltip = $('.tooltip');

    rangeInput.on('input', function (e) {
        tooltip.text(e.target.value);
    });

    /* Screenshots JS */
    $('#screenshots-grid').on('click', '.upload-screenshot-btn', function () {
        var button = $(this);
        var target_field_id = button.data('target');
        var custom_uploader = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        custom_uploader.on('select', function () {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            var input = $('#' + target_field_id);
            input.val(attachment.url);
            var card = input.closest('.apkt-screenshot-card');
            card.find('.apkt-screenshot-preview img').attr('src', attachment.url).show();
            card.find('.apkt-screenshot-placeholder').hide();
        });

        custom_uploader.open();
    });

    $('#add-screenshot-btn').on('click', function () {
        var counter = $('#screenshots-grid .apkt-screenshot-card').length + 1;
        var card = $('#screenshot-template .apkt-screenshot-card').clone(true);
        var inputId = 'screenshot-url-' + counter;
        
        card.find('.screenshot-url-input').attr('id', inputId).attr('name', 'datos_imagenes[]');
        card.find('.upload-screenshot-btn').attr('data-target', inputId);
        
        $('#screenshots-grid').append(card);
        return false;
    });

    $('#screenshots-grid').on('click', '.remove-screenshot-btn', function () {
        $(this).closest('.apkt-screenshot-card').remove();
        return false;
    });

    $('#screenshots-grid').on('change keyup', '.screenshot-url-input', function () {
        var val = $(this).val();
        var card = $(this).closest('.apkt-screenshot-card');
        if (val) {
            card.find('.apkt-screenshot-preview img').attr('src', val).show();
            card.find('.apkt-screenshot-placeholder').hide();
        } else {
            card.find('.apkt-screenshot-preview img').hide();
            card.find('.apkt-screenshot-placeholder').show();
        }
    });

    /* Category Icon Uploader */
    var mediaUploader;

    // Handle icon upload button click
    $('#category-icon-upload-button').on('click', function (e) {
        e.preventDefault();

        // If the media uploader already exists, open it
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Create the media uploader
        mediaUploader = wp.media({
            title: 'Choose Icon',
            button: {
                text: 'Select'
            },
            library: {
                type: ['image/svg+xml', 'image/png']
            },
            multiple: false
        });

        // When an image is selected, set it as the category icon
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#category-icon').val(attachment.url);
        });

        // Open the media uploader
        mediaUploader.open();
    });

    /* Banner Image Thumbnail */
    // Uploading files
    var file_frame;

    jQuery.fn.upload_second_featured_image = function (button) {
        var button_id = button.attr('id');
        var field_id = button_id.replace('_button', '');

        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }

        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
            title: jQuery(this).data('uploader_title'),
            button: {
                text: jQuery(this).data('uploader_button_text'),
            },
            multiple: false
        });

        // When an image is selected, run a callback.
        file_frame.on('select', function () {
            var attachment = file_frame.state().get('selection').first().toJSON();
            jQuery("#upload_banner_image").val(attachment.url); // Save the image URL
            jQuery("#banner_background").html('<span class="components-responsive-wrapper"><div><img src="' + attachment.url + '" alt="" class="components-responsive-wrapper__content" style="width: 100%; height: auto;"></div></span>');
            jQuery('#add_banner').text('Replace');
            jQuery('#remove_banner').show();
        });

        // Finally, open the modal
        file_frame.open();
    };

    jQuery('#add_banner, #banner_background').click(function (event) {
        event.preventDefault();
        jQuery.fn.upload_second_featured_image(jQuery(this));
    });

    jQuery('#remove_banner').click(function (event) {
        event.preventDefault();
        if (jQuery('#upload_banner_image').val() !== '') {
            jQuery('#upload_banner_image').val('');
            jQuery('#banner_container img').attr('src', '');
            jQuery('#banner_background').attr('class', 'components-button editor-post-featured-image__toggle');
            jQuery('#banner_background').html('Add Banner Image');
            jQuery('#add_banner').text('Add Banner');
            jQuery(this).hide();
        }
    });
});