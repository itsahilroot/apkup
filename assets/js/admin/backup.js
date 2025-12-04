jQuery(document).ready(function ($) {
    function delay(callback, ms) {
        var timer = 0;
        return function () {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    function at_init_repeater(container_id, item_name) {
        $(`#${container_id}`).sortable({
            handle: '.at-action-move',
            containment: '.at-panel-fields-container',
            update: function (event, ui) {
                update_repeater_title(container_id, item_name);
                update_repeater_names(container_id);
            }
        });

        $(`#${container_id} .at-coll-header`).click(function () {
            $(this).next(".at-coll-body").slideToggle(150);
        });

        $(`#${container_id} .remove-at-coll`).click(function () {
            $(this).closest(".at-coll-container").remove();
            update_repeater_title(container_id, item_name);
        });
    }

    function add_new_repeater_item(container_id, item_name, item_html) {
        if (!$(`#${container_id}`).hasClass('active')) {
            $(`#${container_id}`).addClass('active');
        }

        var total_container = $(`#${container_id} .at-coll-container`).length + 1;
        var repeater_id = $(`#${container_id} .at-coll-container`).length;
        var new_container_html = item_html;

        var new_container = $(new_container_html).clone();
        new_container.find("*[name]").each(function () {
            if ($(this).attr("name")) {
                var old_name = $(this).attr("name");
                var new_name = old_name.replace(/\[\]/g, `[${repeater_id}]`);
                $(this).attr("name", new_name);
            }
        });
        new_container.find("[data-term-search-id]").each(function () {
            var old_data_term_search_id = $(this).attr("data-term-search-id");
            var new_data_term_search_id = old_data_term_search_id.replace(/\[\]/g, repeater_id);
            $(this).attr("data-term-search-id", new_data_term_search_id);
        });
        
        new_container.find("[data-post-search-id]").each(function () {
            var old_data_post_search_id = $(this).attr("data-post-search-id");
            var new_data_post_search_id = old_data_post_search_id.replace(/\[\]/g, repeater_id);
            $(this).attr("data-post-search-id", new_data_post_search_id);
        });

        new_container.find(".at-coll-title").text(`${item_name} ${total_container}`);
        new_container.find(".at-coll-body").hide();
        $(`#${container_id}`).append(new_container);

        new_container.find(".at-coll-header").click(function () {
            $(this).next(".at-coll-body").slideToggle(150);
        });

        new_container.find(".remove-at-coll").click(function () {
            $(this).closest(".at-coll-container").remove();
            update_repeater_title(container_id, item_name);
            if ($(`#${container_id} .at-coll-container`).length == 0) {
                $(`#${container_id}`).removeClass('active');
            }
        });

        update_repeater_title(container_id, item_name);
    }

    function update_repeater_title(container_id, item_name) {
        $(`#${container_id} .at-coll-container`).each(function (index) {
            var postTitle = `${item_name} ${(index + 1)}`;
            $(this).find(".at-coll-title").text(postTitle);
        });
    }

    function update_repeater_names(container_id) {
        if (container_id == 'at-posts-field') {
            $(`#${container_id} .at-coll-container`).each(function (index) {
                $(this).find("input[type=text]").attr("name", `au_home_posts[${index}][title]`);

                $(this).find("input[type=number]").attr("name", `au_home_posts[${index}][limit]`);

                $(this).find("input[type=hidden]").attr("name", `au_home_posts[${index}][term_id]`);

                $(this).find("input[type=checkbox]").attr("name", `au_home_posts[${index}][is_btm_ad]`);
            });
        } else if (container_id == 'at-home-fp-field') {
            $(`#${container_id} .at-coll-container`).each(function (index) {
                $(this).find("input[type=text]").attr("name", `au_home_fp[${index}][featured_img]`);

                $(this).find("input[type=text]").attr("name", `au_home_fp[${index}][post_title]`);

                $(this).find("input[type=hidden]").attr("name", `au_home_fp[${index}][post_id]`);
            });
        }
    }

    function single_media_uploader(title, target_url) {
        var media_uploader = wp.media({
            title: title,
            multiple: false
        });

        media_uploader.on('select', function () {
            var selected_image = media_uploader.state().get('selection').first();
            var image_url = selected_image.toJSON().url;

            $(target_url).val(image_url);
        });

        media_uploader.open();
    }

    /* Panel Tab Select */

    function activate_tab_section(section) {
        $('.at-panel-fields-container .at-field-section').removeClass('active');
        $('.at-panel-tab').removeClass('active');

        $('.at-field-section[data-section=' + section + ']').addClass('active');

        $('.at-panel-tab a[href="#' + section + '"]').parent().addClass('active');

        $('html, body').scrollTop(0);
    }

    $('.at-panel-tabs ul .at-panel-tab a').on('click', function (event) {
        event.preventDefault();

        var section = this.hash.replace('#', '');

        activate_tab_section(section);

        history.pushState(null, null, this.href);
    });

    $(window).on('popstate', function (event) {
        var section = location.hash.replace('#', '');

        activate_tab_section(section);
    });

    var init_selection = location.hash.replace('#', '');

    if (init_selection) {
        activate_tab_section(init_selection);
    }

    /* Term Select */
    function at_init_repeater_term_search(container_id, term_limit) {
        $(document).on('click', '#' + container_id + ' .coll-term-search', function (e) {
            e.stopPropagation();
        });

        $('body').on('click', function (e) {
            if (!$(e.target).hasClass('coll-term-search') && !$(e.target).hasClass('coll-term-results')) {
                $('.' + container_id + ' .coll-term-results').hide();
            }
        });

        $(document).on('click', '#' + container_id + ' .coll-term-search', function () {
            var search = $(this).val();
            if (search.length >= 3) {
                $('.' + container_id + ' .coll-term-results').show();
            }
        });

        $(document).on('keyup', '#' + container_id + ' .coll-term-search', delay(function () {
            var search_input = $(this);
            var search = search_input.val();

            if (search.length == 0) {
                search_input.siblings('.coll-term-results').hide();
                return;
            }

            if (search.length < 3) return;

            var request = $.ajax({
                url: apktemplates_ajax_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'at_search_term',
                    nonce: apktemplates_ajax_vars.nonce,
                    query: search
                },
                success: function (data) {
                    search_input.siblings('.coll-term-results').show().html(data);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                show_snackbar('Request failed ' + textStatus);
            });
        }, 500));

        $(document).on('click', '#' + container_id + ' .coll-term-selected ul li .delete', function () {
            var selected_container = $(this).closest('.at-coll-container').find('.coll-term-selected ul');
            var data_term_search_id = selected_container.data('term-search-id');
            $(this).parent().fadeOut(350, function () {
                $(this).remove();
            });
            selected_container.append('<input type="hidden" name="home_terms[' + data_term_search_id + '][term_id]" value="" />');
        });

        $(document).on('click', '#' + container_id + ' .coll-term-results ul li', function () {
            var selected_container = $(this).closest('.at-coll-container').find('.coll-term-selected ul');
            var term_id = $(this).data('term-id');
            var term_title = $(this).text();
            var data_term_search_id = selected_container.data('term-search-id');
            var exist_terms = $(this).closest('.at-coll-container').find('.coll-term-selected ul li');
            var new_term = $('<li data-term-id="' + term_id + '">' + term_title + '<span class="delete"><i class="fa fa-trash-alt"></i><input type="hidden" name="home_terms[' + data_term_search_id + '][term_id]" value="' + term_id + '" /></li></span>').hide();

            selected_container.find("input[name='home_terms[" + data_term_search_id + "][term_id]']").remove();

            if (exist_terms.length >= term_limit) {
                show_snackbar('You have reached the maximum limit of ' + term_limit + ' terms.');
                return;
            }

            var exist_terms_ids = $(this).closest('.at-coll-container').find('.coll-term-selected ul li').map(function () {
                return $(this).data('term-id');
            }).get();

            if (exist_terms_ids.includes(term_id)) {
                show_snackbar('This term has already been added.');
                return;
            }

            $(this).closest('.at-coll-container').find('.coll-term-selected ul').append(new_term);
            new_term.slideDown(250);

            $(this).closest('.at-coll-container').find('.coll-term-search').val('');
        });

    }

    function at_init_repeater_posts_search(container_id, save_key, post_limit) {
        $(document).on('click', '#' + container_id + ' .at-search-ipt', function (e) {
            e.stopPropagation();
        });

        $('body').on('click', function (e) {
            if (!$(e.target).hasClass('at-search-ipt') && !$(e.target).hasClass('post-results')) {
                $('#' + container_id + ' .post-results').hide();
            }
        });

        $(document).on('click', '#' + container_id + ' .at-search-ipt', function () {
            var search = $(this).val();
            if (search.length >= 3) {
                $('#' + container_id + ' .post-results').show();
            }
        });

        $(document).on('keyup', '#' + container_id + ' .at-search-ipt', delay(function () {
            var search_input = $(this);
            var search = search_input.val();

            if (search.length == 0) {
                search_input.siblings('.post-results').hide();
                return;
            }

            if (search.length < 3) return;

            var request = $.ajax({
                url: apktemplates_ajax_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'at_search_post',
                    nonce: apktemplates_ajax_vars.nonce,
                    query: search
                },
                success: function (data) {
                    search_input.siblings('.coll-post-results').show().html(data);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                show_snackbar('Request failed ' + textStatus);
            });
        }, 500));

        $(document).on('click', '#' + container_id + ' .coll-post-selected ul li .delete', function () {
            $(this).parent().fadeOut(350, function () {
                $(this).remove();
            });
            $(this).parent().parent().append('<input type="hidden" name="' + save_key + '" value="" />');
        });

        $(document).on('click', '#' + container_id + ' .coll-post-results ul li', function () {
            var selected_container = $(this).closest('.at-coll-container').find('.coll-post-selected ul');
            var post_id = $(this).data('post-id');
            var post_title = $(this).text();
            var exist_posts = $('#' + container_id + ' .coll-post-selected ul li');
            var data_post_search_id = selected_container.data('post-search-id');
            var exist_posts = $(this).closest('.at-coll-container').find('.coll-post-selected ul li');
            var new_post = $('<li data-post-id="' + post_id + '">' + post_title + '<span class="delete"><i class="fa fa-trash-alt"></i><input type="hidden" name="au_home_posts[' + data_post_search_id + '][post_id]" value="' + post_id + '" /></li></span>').hide();
            
            selected_container.find("input[name='au_home_posts[" + data_post_search_id + "][post_id]']").remove();

            if (exist_posts.length >= post_limit) {
                show_snackbar('You have reached the maximum limit of ' + post_limit + ' posts.');
                return;
            }

            var exist_posts_ids = $('#' + container_id + ' .coll-post-selected ul li').map(function () {
                return $(this).data('post-id');
            }).get();

            if (exist_posts_ids.includes(post_id)) {
                show_snackbar('This post has already been added.');
                return;
            }

            $('#' + container_id + ' .coll-post-selected ul').append(new_post);
            new_post.slideDown(250);

            $('#' + container_id + ' .at-search-ipt').val('');
        });
    }

    $(document).on('click', '#apkt-license-btn', function (e) {
        e.preventDefault();
        var panel_form = $('#at-panel-form');

        const license_key = $('#apkt_license_key').val();
        const license_email = $('#apkt_license_email').val();
        const license_action = $(this).attr('data-action');

        panel_form.addClass('loading');
        show_snackbar('Verifying...', false);

        var request = $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: {
                'action': license_action,
                'nonce': apktemplates_ajax_vars.nonce,
                'apkt_license_key': license_key,
                'apkt_license_email': license_email
            },
        });

        request.done(function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response?.status === 'success') {
                panel_form.removeClass('loading');
                show_snackbar(response?.data?.message);
                setTimeout(function (e) {
                    window.location.reload();
                }, 2000);
            } else if (response?.status === 'error') {
                panel_form.removeClass('loading');
                show_snackbar(response?.data?.message);
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            panel_form.removeClass('loading');
            show_snackbar("The following error occurred: " + textStatus, errorThrown);
        });
    });

    $(document).on('click', '#import-demo-btn', function (e) {
        e.preventDefault();
        const confirm_import = confirm("Are you sure you want to import demo? After import, new posts where added.");

        if (confirm_import) {
            $('#import-demo-container').slideToggle(350);
        }
    });

    $(document).on('change', '#import-demo', function (e) {
        var panel_form = $('#at-panel-form');
        var import_file = $('#import-demo')[0].files[0];
        var snackbar = $("#at-snackbar");
        if (import_file) {
            if (import_file.name.toLowerCase().endsWith('.json')) {
                panel_form.addClass('loading');
                show_snackbar('File uploading...')
                var formData = new FormData();
                formData.append('action', 'apkt_import_demo');
                formData.append('nonce', apktemplates_ajax_vars.nonce);
                formData.append('import_file', import_file);

                show_snackbar("Importing...", false);

                var request = $.ajax({
                    url: apktemplates_ajax_vars.ajax_url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false
                });

                request.done(function (data, textStatus, jqXHR) {
                    snackbar.css('opacity', '0');
                    panel_form.removeClass('loading');
                    show_snackbar(data.data);

                    setTimeout(function (e) {
                        window.location.reload();
                    }, 2000);
                });

                request.fail(function (jqXHR, textStatus, errorThrown) {
                    panel_form.removeClass('loading');
                    snackbar.css('opacity', '0');
                    show_snackbar("The following error occurred: " + textStatus, errorThrown);
                });
            } else {
                snackbar.css('opacity', '0');
                show_snackbar('Please select a .json file to import.');
            }
        } else {
            snackbar.css('opacity', '0');
            show_snackbar('Please select a file to import.');
        }
    });


    $(document).on('click', '#import-settings-btn', function (e) {
        e.preventDefault();
        const confirm_import = confirm("Are you sure you want to import settings? After import, your current settings were changed. So before import, take backup settings by export.");

        if (confirm_import) {
            $('#import-settings-container').slideToggle(350);
        }
    });

    $(document).on('change', '#import-settings', function (e) {
        var panel_form = $('#at-panel-form');
        var import_file = $('#import-settings')[0].files[0];
        var snackbar = $("#at-snackbar");
        if (import_file) {
            if (import_file.name.toLowerCase().endsWith('.json')) {
                panel_form.addClass('loading');
                show_snackbar('File uploading...')
                var formData = new FormData();
                formData.append('action', 'apkt_import_settings');
                formData.append('nonce', apktemplates_ajax_vars.nonce);
                formData.append('import_file', import_file);

                var request = $.ajax({
                    url: apktemplates_ajax_vars.ajax_url,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false
                });

                request.done(function (data, textStatus, jqXHR) {
                    panel_form.removeClass('loading');
                    show_snackbar(data.data);

                    setTimeout(function (e) {
                        window.location.reload();
                    }, 2000);
                });

                request.fail(function (jqXHR, textStatus, errorThrown) {
                    panel_form.removeClass('loading');
                    snackbar.css('opacity', '0');
                    show_snackbar("The following error occurred: " + textStatus, errorThrown);
                });
            } else {
                snackbar.css('opacity', '0');
                show_snackbar('Please select a .json file to import.');
            }
        } else {
            snackbar.css('opacity', '0');
            show_snackbar('Please select a file to import.');
        }
    });

    $(document).on('click', '#export-settings', function (e) {
        e.preventDefault();
        var panel_form = $('#at-panel-form');
        const confirm_export = confirm("Are you sure you want to export settings?");

        if (confirm_export) {
            panel_form.addClass('loading');
            var request = $.ajax({
                url: apktemplates_ajax_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'apkt_export_settings',
                    nonce: apktemplates_ajax_vars.nonce,
                }
            });

            request.done(function (data, textStatus, jqXHR) {
                const export_file_url = data.data;
                const export_file_name = export_file_url.split('/').pop();

                panel_form.removeClass('loading');
                show_snackbar('Downloading...!');

                var link = document.createElement('a');
                link.href = export_file_url;
                link.download = export_file_name;
                link.style.display = 'none';
                document.body.appendChild(link);

                link.click();

                document.body.removeChild(link);
            });

            request.fail(function (jqXHR, textStatus, errorThrown) {
                panel_form.removeClass('loading');
                show_snackbar("The following error occurred: " + textStatus, errorThrown);
            });
        } else {
            return;
        }
    });

    $(document).on('click', '#delete-cache', function (e) {
        e.preventDefault();
        var panel_form = $('#at-panel-form');
        panel_form.addClass('loading');

        var request = $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'apkt_delete_folder_action',
                nonce: apktemplates_ajax_vars.nonce,
            }
        });

        request.done(function (data, textStatus, jqXHR) {
            panel_form.removeClass('loading');
            show_snackbar('Cleared!');
            window.location.reload();
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            panel_form.removeClass('loading');
            show_snackbar(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
    });

    $(document).on('submit', '#at-panel-form', function (e) {
        e.preventDefault();
        if ($('#at-home-fp-field .at-coll-container').length === 0) {
            $('<input>').attr({
                type: 'hidden',
                name: 'au_home_fp[]',
                value: ''
            }).appendTo($('#at-home-fp-field'));
        }

        if ($('#at-posts-field .at-coll-container').length === 0) {
            $('<input>').attr({
                type: 'hidden',
                name: 'au_home_posts[]',
                value: ''
            }).appendTo($('#at-posts-field'));
        }
        var panel_form = $(this);
        panel_form.addClass('loading');
        var panel_inputs = panel_form.find("input, select, button, textarea");
        var serializedData = panel_form.find(":input:not([type='search']):not([type='submit']):not([type='button']):not([type='file']):not([id='apkt_license_key']):not([id='apkt_license_email'])").map(function () {
            if (this.type === 'checkbox') {
                return { name: this.name, value: this.checked ? true : false };
            } else {
                return { name: this.name, value: $(this).val() };
            }
        }).get();
        panel_inputs.prop("disabled", true);
        var request = $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'save_at_customization',
                nonce: apktemplates_ajax_vars.nonce,
                data: serializedData
            }
        });

        request.done(function (data, textStatus, jqXHR) {
            panel_form.removeClass('loading');
            show_snackbar(data.data);
        });
        request.fail(function (jqXHR, textStatus, errorThrown) {
            panel_form.removeClass('loading');
            show_snackbar("The following error occurred: " + textStatus, errorThrown);
        });
        request.always(function () {
            panel_inputs.prop("disabled", false);
        });

    });

    function show_snackbar(message, timeout = true) {
        // Remove existing snackbar if it exists
        $('#at-snackbar').remove();

        var snackbar = $('<div id="at-snackbar">' + message + '</div>');
        snackbar.css('opacity', '0');

        $('body').append(snackbar);

        snackbar.css({
            'position': 'fixed',
            'bottom': '7%',
            'left': '50%',
            'transform': 'translateX(-50%)',
            'background-color': '#111',
            'color': '#fff',
            'font-size': '15px',
            'font-weight': '500',
            'padding': '15px',
            'border-radius': '2px',
            'box-shadow': '0 0 10px rgba(0, 0, 0, 0.2)',
            'z-index': '999',
            'opacity': '0',
            'transition': 'opacity 0.3s',
        });

        setTimeout(function () {
            snackbar.css('opacity', '1');
        }, 300);

        if (timeout === true) {
            setTimeout(function () {
                snackbar.css('opacity', '0');
                setTimeout(function () {
                    snackbar.remove();
                }, 300);
            }, 4000);
        }
    }

    $('.at-password-btn').click(function () {
        var container = $(this).closest('.at-inputs-container');

        var passwordInput = container.find('.at-password-ipt');
        var passwordButton = container.find('.at-password-btn');

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            passwordButton.val('\uf06e');
        } else {
            passwordInput.attr('type', 'password');
            passwordButton.val('\uf070');
        }
    });

    const home_fp_html = '<div class="at-coll-container">' +
        '    <div class="at-coll-header">' +
        '        <div class="at-coll-title">Featured Post 1</div>' +
        '        <div class="at-coll-action">' +
        '            <span class="at-action-move">' +
        '            <i class="fa fa-bars"></i>' +
        '            </span>' +
        '            <a href="javascript:void(0);" class="remove-at-coll delete">Remove</a>' +
        '            <a href="javascript:void(0);" class="edit-at-coll edit">Edit</a>' +
        '        </div>' +
        '    </div>' +
        '    <div class="at-coll-body" style="display: none">' +
        '        <div class="at-mb-1">' +
        '           <p class="at-mini-title">Featured Image</p>' +
        '           <div class="at-img-upload">' +
        '               <input type="text" name="au_home_fp[][featured_img]" id="au_home_fp[][featured_img]" class="at-text-ipt" />' +
        '               <input type="button" class="at-upload-img-ipt" value="&#xf093;" data-title="Featured Image" data-target="#au_home_fp[][featured_img]" />' +
        '           </div>' +
        '           <p class="at-field-hint at-mb-2">Required image size: 820px width, 400px height.</p>' +
        '        </div>' +
        '        <div class="at-mb-2 at-pb-2">' +
        '            <p class="at-mini-title">Post Title</p>' +
        '            <p>Add text for the post title.</p>' +
        '            <input type="text" name="au_home_fp[][post_title]" class="at-text-ipt" />' +
        '        </div>' +
        '        <div>' +
        '            <p class="at-mini-title">Post</p>' +
        '            <p>Select a post to link to this featured post.</p>' +
        '            <input type="search" class="at-search-ipt coll-post-search" min="3" placeholder="Enter atleast 3 letters..." />' +
        '            <div class="coll-post-results" style="display: none">' +
        '            </div>' +
        '            <div class="coll-post-selected">' +
        '                <ul data-post-search-id="[]">' +
        '                    <input type="hidden" name="au_home_fp[][post_id]" value="" />' +
        '                </ul>' +
        '            </div>' +
        '        </div>' +
        '    </div>' +
        '</div>';

    const home_posts_html = '<div class="at-coll-container">' +
        '    <div class="at-coll-header">' +
        '        <div class="at-coll-title">Posts 1</div>' +
        '        <div class="at-coll-action">' +
        '            <span class="at-action-move">' +
        '            <i class="fa fa-bars"></i>' +
        '            </span>' +
        '            <a href="javascript:void(0);" class="remove-at-coll delete">Remove</a>' +
        '            <a href="javascript:void(0);" class="edit-at-coll edit">Edit</a>' +
        '        </div>' +
        '    </div>' +
        '    <div class="at-coll-body" style="display: none">' +
        '        <div class="at-mb-2 at-pb-2">' +
        '            <p class="at-mini-title">Section Title</p>' +
        '            <p>Add text for title.</p>' +
        '            <input type="text" name="home_terms[][term_title]" class="at-text-ipt" />' +
        '        </div>' +
        '        <div class="at-mb-2 at-pb-2">' +
        '            <p class="at-mini-title">Posts Limit</p>' +
        '            <p>Set the number of posts shown.</p>' +
        '            <input type="number" name="home_terms[][term_limit]" class="at-number-ipt" min="1" max="50" /> Posts' +
        '        </div>' +
        '        <div class="at-mb-2 at-pb-2">' +
        '            <p class="at-mini-title">Term</p>' +
        '            <p>Select a category or tag term for the posts that will be shown.</p>' +
        '            <input type="search" class="at-search-ipt coll-term-search" min="3" placeholder="Enter atleast 3 letters..." />' +
        '            <div class="coll-term-results" style="display: none">' +
        '            </div>' +
        '            <div class="coll-term-selected">' +
        '                <ul data-term-search-id="[]">' +
        '                    <input type="hidden" name="home_terms[][term_id]" value="" />' +
        '                </ul>' +
        '            </div>' +
        '        </div>' +
        '        <div>' +
        '            <p class="at-mini-title">Term Bottom Ad</p>' +
        '            <p>Show or hide the advertisement shown at the bottom of this term.</p>' +
        '            <label class="at-switch-btn">' +
        '            <input type="checkbox" name="home_terms[][term_btm_ad]">' +
        '            <span class="at-switch"></span>' +
        '            </label>' +
        '        </div>' +
        '    </div>' +
        '</div>';

    $(".at-upload-img-ipt").click(function () {
        var title = $(this).data('title');
        var target = $(this).data('target');
        single_media_uploader(title, target);
    });
    $('.color-picker').wpColorPicker();

    at_init_repeater('at-home-fp-field', 'Featured Post');
    at_init_repeater('at-posts-field', 'Posts');

    at_init_repeater_posts_search('at-home-fp-field', 'post_id', 1);

    at_init_repeater_posts_search('at-posts-field', 'post_id', 1);
    at_init_repeater_term_search('at-posts-field', 1);

    $("#add-new-fp").click(function () {
        add_new_repeater_item('at-home-fp-field', 'Featured Post', home_fp_html);
    });
    $("#add-new-posts").click(function () {
        add_new_repeater_item('at-posts-field', 'Posts', home_posts_html);
    });
});