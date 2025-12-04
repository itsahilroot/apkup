jQuery(document).ready(function ($) {
    /* Download Button JS */
    $('#download-table tbody').sortable({
        items: 'tr',
        cursor: 'move',
        handle: '.handle',
    });

    $('#add-row').on('click', function () {
        // Count how many rows already exist (excluding the hidden template)
        var index = $('#download-table tbody tr').not('.empty-d-row').length;

        // Clone the hidden template
        var row = $('.empty-d-row').clone(true);
        row.removeClass('empty-d-row').css('display', 'table-row');

        // Replace __index__ with the new index
        row.find('input').each(function () {
            var name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace('__index__', index));
            }
            $(this).val(''); // clear input values
        });

        // Append row at the end of tbody
        $('#download-table tbody').append(row);

        return false;
    });

    // Handle remove button
    $('#download-table').on('click', '.remove-btn', function () {
        $(this).closest('tr').remove();
        return false;
    });

    // Show the current value as a tooltip
    var rangeInput = $('.range-input');
    var tooltip = $('.tooltip');

    rangeInput.on('input', function (e) {
        tooltip.text(e.target.value);
    });

    /* Screenshots JS */
    $('.upload-screenshot-btn').on('click', function () {
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
            $('#' + target_field_id).val(attachment.url);
        });

        custom_uploader.open();
    });

    $('#add-screenshot-btn').on('click', function () {
        var row = $('.empty-screenshot-row').clone(true);
        row.removeClass('empty-screenshot-row').css('display', 'table-row');
        var counter = $('.upload-screenshot-btn').length + 1;
        row.find('input').attr('id', 'screenshot-url-' + counter);
        row.find('.upload-screenshot-btn').attr('id', 'screenshot-btn-' + counter);
        row.find('.upload-screenshot-btn').attr('data-target', 'screenshot-url-' + counter);
        row.insertBefore('#screenshots-table tbody>tr:last');
        return false;
    });

    $('.remove-screenshot-btn').on('click', function () {
        $(this).parents('tr').remove();
        return false;
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