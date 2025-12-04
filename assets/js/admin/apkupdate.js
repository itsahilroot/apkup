jQuery(document).ready(function ($) {
    var posts = [];

    $(document).on('click', '#apps_to_update #doaction, #apps_to_update #doaction2', function (event) {
        event.preventDefault();

        var select = $(this).attr('id') === 'doaction'
            ? $('#bulk-action-selector-top')
            : $('#bulk-action-selector-bottom');

        var sn = select.val();

        if (sn === 'update') {
            posts = [];

            var $selectedRows = $('#apps_to_update input[type=checkbox][name="apps_to_import[]"]:checked').map(function () {
                var postId = $(this).val();
                var $row = $(this).closest('tr');
                var $btn = $row.find('.app_import');

                var gplayUrl = $row.find('a[href*="play.google.com/store/apps"]').attr('href');

                posts.push({
                    post_id: postId,
                    gplay_url: gplayUrl
                });

                $row.find('.spinner').remove();
                $row.find('#box-info-import').remove();

                if ($row.find('#box-info-import').length === 0) {
                    $btn.after('<span class="spinner" style="visibility:visible"></span>');
                    $btn.hide();
                }

                $(this).prop('disabled', true);
                return $row;
            }).get();
			
            $('.table_list_apps .bulkactions').find('input, select').prop('disabled', true);
            $('#cb-select-all-1, #cb-select-all-2').prop('disabled', true);

            $.ajax({
                url: vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'bulk_update_version',
                    posts: posts,
                    nonce: vars.nonce
                },
                success: function (response) {
                    if (response.success) {
                        response.data.updated.forEach(function (item) {
                            var $row = $('#apps_to_update input[value="' + item.post_id + '"]').closest('tr');
                            var $btn = $row.find('.app_import');

                            $row.find('.spinner').remove();
                            $row.find('#box-info-import').remove();

                            $btn.after(
                                '<div id="box-info-import">' +
                                '<ul id="extract-result">' +
                                '<li style="color:#10ac10;">post updated successfully</li>' +
                                '</ul>' +
                                '</div>'
                            );

                            $btn.hide();
                            $row.find('input[name="apps_to_import[]"]').prop('disabled', true).prop('checked', false);
                        });
                    } else {
                        $selectedRows.forEach(function ($row) {
                            var $btn = $row.find('.app_import');
                            $row.find('.spinner').remove();
                            $btn.show();
                            $row.find('input[name="apps_to_import[]"]').prop('disabled', false).prop('checked', false);
                        });
                        alert(response.data.message || 'Something went wrong');
                    }
                },
                error: function () {
                    $selectedRows.forEach(function ($row) {
                        var $btn = $row.find('.app_import');
                        $row.find('.spinner').remove();
                        $btn.show();
                        $row.find('input[name="apps_to_import[]"]').prop('disabled', false).prop('checked', false);
                    });
                    alert('Error during bulk update');
                },
                complete: function () {
                    $('.table_list_apps .bulkactions').find('input, select').prop('disabled', false);
                    $('#cb-select-all-1, #cb-select-all-2').prop('disabled', false);
                }
            });
        }
    });

    $(document).on('click', '.app_import', function (e) {
        e.preventDefault();

        var $btn = $(this);
        var $row = $(this).closest('tr');

        var postsData = [];
        var postId = $btn.data('post-id');
        var playUrl = $row.find('a[href*="play.google.com/store/apps"]').attr('href');

        postsData.push({
            post_id: postId,
            gplay_url: playUrl
        });

        $row.find('.spinner').remove();
        $row.find('#box-info-import').remove();

        $btn.after('<span class="spinner" style="visibility:visible"></span>');
        $btn.hide();

        $row.find('input[name="apps_to_import[]"]').prop('disabled', true);

        $.ajax({
            url: vars.ajax_url,
            type: 'POST',
            data: {
                action: 'bulk_update_version',
                posts: postsData,
                nonce: vars.nonce
            },
            success: function (response) {
                if (response.success) {
                    response.data.updated.forEach(function (item) {
                        $row.find('.spinner').remove();

                        $btn.after(
                            '<div id="box-info-import">' +
                            '<ul id="extract-result">' +
                            '<li style="color:#10ac10;">post updated successfully</li>' +
                            '</ul>' +
                            '</div>'
                        );

                        $row.find('input[name="apps_to_import[]"]').prop('disabled', true).prop('checked', false);
                    });
                } else {
                    $row.find('.spinner').remove();
                    $btn.show();
                    $row.find('input[name="apps_to_import[]"]').prop('disabled', false);
                    alert(response.data.message || 'Something went wrong');
                }
            },
            error: function () {
                $row.find('.spinner').remove();
                $btn.show();
                $row.find('input[name="apps_to_import[]"]').prop('disabled', false);
                alert('Error during update');
            }
        });
    });
});