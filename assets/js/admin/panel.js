jQuery(document).ready(function ($) {
    // Utility: Delay function for delaying keyup events
    function delay(callback, ms) {
        let timer = 0;
        return function () {
            const context = this;
            const args = arguments;
            clearTimeout(timer);
            timer = setTimeout(() => callback.apply(context, args), ms || 0);
        };
    }

    // Snackbar Module: Display notification messages
    function show_snackbar(message, timeout = true) {
        $('#at-snackbar').remove();
        const $snackbar = $(`<div id="at-snackbar">${message}</div>`).css({
            position: 'fixed',
            bottom: '7%',
            left: '50%',
            transform: 'translateX(-50%)',
            backgroundColor: '#111',
            color: '#fff',
            fontSize: '15px',
            fontWeight: '500',
            padding: '15px',
            borderRadius: '2px',
            boxShadow: '0 0 10px rgba(0, 0, 0, 0.2)',
            zIndex: '999',
            opacity: '0',
            transition: 'opacity 0.3s'
        });

        $('body').append($snackbar);
        setTimeout(() => $snackbar.css('opacity', '1'), 300);

        if (timeout) {
            setTimeout(() => {
                $snackbar.css('opacity', '0');
                setTimeout(() => $snackbar.remove(), 300);
            }, 4000);
        }
    }

    // Search for single posts and terms input
    function at_init_search(container_id, save_key, action, resultClass, selectedClass, idAttr) {
        const container = $('#' + container_id);

        // Hide results when clicking outside
        $('body').on('click', function (e) {
            if (!$(e.target).hasClass('at-search-ipt') && !$(e.target).hasClass(resultClass)) {
                container.find('.' + resultClass).hide();
            }
        });

        // Show results if input has 3+ chars
        $(document).on('keyup', '#' + container_id + ' .at-search-ipt', delay(function () {
            const input = $(this);
            const query = input.val().trim();

            if (query.length < 3) {
                input.siblings('.' + resultClass).hide();
                return;
            }

            $.post(apktemplates_ajax_vars.ajax_url, {
                action,
                nonce: apktemplates_ajax_vars.nonce,
                query
            })
                .done(data => input.siblings('.' + resultClass).show().html(data))
                .fail((_, textStatus) => show_snackbar(`Request failed ${textStatus}`));
        }, 500));

        // Select item (only 1 allowed, replaces previous)
        $(document).on('click', '#' + container_id + ' .' + resultClass + ' ul li', function () {
            const id = $(this).data(idAttr);
            const title = $(this).text();
            const selected = container.find('.' + selectedClass + ' ul');

            selected.empty(); // remove old selection

            const newItem = $(`<li data-${idAttr}="${id}">${title}<span class="delete"><i class="fa fa-trash-alt"></i></span>
                <input type="hidden" name="${save_key}" value="${id}" />
                </li>`).hide();

            selected.append(newItem);
            newItem.slideDown(250);
            container.find('.at-search-ipt').val('');
        });

        // Delete item
        $(document).on('click', '#' + container_id + ' .' + selectedClass + ' ul li .delete', function () {
            $(this).parent().fadeOut(350, function () { $(this).remove(); });
            container.find('.' + selectedClass + ' ul').append(`<input type="hidden" name="${save_key}" value="" />`);
        });
    }

    function at_init_post_search(container_id, save_key) {
        at_init_search(container_id, save_key, 'apkt_panel_search_post', 'post-results', 'post-selected', 'post-id');
    }

    function at_init_term_search(container_id, save_key) {
        at_init_search(container_id, save_key, 'apkt_panel_search_term', 'term-results', 'term-selected', 'term-id');
    }

    // Repeater Module: Create and manage a repeater
    function create_repeater(config) {
        const {
            container_id,
            item_name,
            fields,
            search_config = null,
            add_button_id,
            repeater_limit = null
        } = config;

        // Generate HTML template dynamically
        function generate_template(index_placeholder = '[]') {
            let fields_html = '';
            fields.forEach((field, fieldIndex) => {
                const isLastField = fieldIndex === fields.length - 1;
                let field_html = '';
                let wrapperClass = isLastField ? '' : field.type === 'image' ? 'at-mb-1' : 'at-mb-2 at-pb-2';

                if (field.type === 'text' || field.type === 'number') {
                    field_html = `
                    <div class="${wrapperClass}">
                        <p class="at-mini-title">${field.label}</p>
                        ${field.description ? `<p>${field.description}</p>` : ''}
                        <input type="${field.type}" name="${field.name_prefix}[${index_placeholder}][${field.key}]" 
                            class="at-${field.type}-ipt" ${field.attributes || ''} />
                        ${field.type === 'number' ? ' Posts' : ''}
                    </div>`;
                } else if (field.type === 'image') {
                    const descriptionClass = isLastField ? 'at-field-hint' : 'at-field-hint at-mb-2';
                    field_html = `
                    <div class="${wrapperClass}">
                        <p class="at-mini-title">${field.label}</p>
                        <div class="at-img-upload">
                            <input type="text" name="${field.name_prefix}[${index_placeholder}][${field.key}]" 
                                id="${field.name_prefix}_${index_placeholder}_${field.key}" class="at-text-ipt" 
                                data-field-key="${field.key}" />
                            <button type="button" class="at-upload-img-ipt" data-title="${field.label}" data-target="#${field.name_prefix}_${index_placeholder}_${field.key}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg></button>
                        </div>
                        ${field.description ? `<p class="${descriptionClass}">${field.description}</p>` : ''}
                    </div>`;
                } else if (field.type === 'checkbox') {
                    field_html = `
                    <div class="${wrapperClass}">
                        <p class="at-mini-title">${field.label}</p>
                        ${field.description ? `<p>${field.description}</p>` : ''}
                        <label class="at-switch-btn">
                            <input type="checkbox" name="${field.name_prefix}[${index_placeholder}][${field.key}]">
                            <span class="at-switch"></span>
                        </label>
                    </div>`;
                } else if (field.type === 'textarea') {
                    field_html = `
                    <div class="${wrapperClass}">
                        <p class="at-mini-title">${field.label}</p>
                        ${field.description ? `<p>${field.description}</p>` : ''}
                        <textarea name="${field.name_prefix}[${index_placeholder}][${field.key}]" class="at-textarea" spellcheck="false" rows="7"></textarea>
                    </div>`;
                } else if (field.type === 'search') {
                    field_html = `
                    <div class="${wrapperClass}">
                        <p class="at-mini-title">${field.label}</p>
                        ${field.description ? `<p>${field.description}</p>` : ''}
                        <input type="search" class="at-search-ipt ${field.search_class}" min="3" placeholder="Enter at least 3 letters..." />
                        <div class="${field.results_class}" style="display: none"></div>
                            <div class="${field.results_class}-selected">
                                <ul data-${field.save_key}-search-id="${index_placeholder}">
                                    <input type="hidden" name="${field.name_prefix}[${index_placeholder}][${field.key}]" 
                                        value="" data-field-key="${field.key}" />
                                </ul>
                        </div>
                    </div>`;
                } else if (field.type === 'select') {
                    field_html = `
                    <div class="${wrapperClass}">
                        <p class="at-mini-title">${field.label}</p>
                        ${field.description ? `<p>${field.description}</p>` : ''}
                        <select class="at-select" name="${field.name_prefix}[${index_placeholder}][${field.key}]" data-field-key="${field.key}" style="width: 100%;">
                            <option value="">Select</option>
                            ${Object.keys(field.options).map(key => `
                                <option value="${key}">${field.options[key]}</option>
                            `).join('')}
                        </select>
                    </div>`;
                }
                fields_html += field_html;
            });

            return `
            <div class="at-coll-container">
                <div class="at-coll-header">
                    <div class="at-coll-title">${item_name} 1</div>
                    <div class="at-coll-action">
                        <span class="at-action-move"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu inline-block"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg></span>
                        <a href="javascript:void(0);" class="remove-at-coll delete">Remove</a>
                        <a href="javascript:void(0);" class="edit-at-coll edit">Edit</a>
                    </div>
                </div>
                <div class="at-coll-body" style="display: none">
                    ${fields_html}
                </div>
            </div>`;
        }

        // Initialize repeater
        function at_init_repeater() {
            const $container = $(`#${container_id}`);

            // Initialize jQuery UI Sortable
            $container.sortable({
                handle: '.at-action-move',
                containment: '.at-panel-fields-container',
                update: () => {
                    update_repeater_title();
                    config.update_names();
                    initialize_search_handlers(); // Rebind search handlers after drag
                }
            });

            // Bind header click to toggle body and close others
            $container.on('click', '.at-coll-header', function () {
                const $currentBody = $(this).next('.at-coll-body');
                const $allBodies = $container.find('.at-coll-body');

                // Close all other bodies except the current one
                $allBodies.not($currentBody).slideUp(150).attr('aria-expanded', 'false');

                // Toggle the current body
                $currentBody.slideToggle(150, function () {
                    // Update aria-expanded based on visibility
                    $(this).attr('aria-expanded', $(this).is(':visible') ? 'true' : 'false');
                });
            });

            // Bind remove button click
            $container.on('click', '.remove-at-coll', function () {
                const $item = $(this).closest('.at-coll-container');
                $item.remove();
                update_repeater_title();
                config.update_names();
                initialize_search_handlers(); // Rebind search handlers after removal
                if ($container.find('.at-coll-container').length === 0) {
                    $container.removeClass('active').hide();
                }
            });

            // Initialize search handler if configured
            if (search_config) {
                init_search_handler(container_id, search_config);
            }
        }

        // Add new repeater item
        function add_new_repeater_item() {
            const $container = $(`#${container_id}`);
            const currentCount = $container.find('.at-coll-container').length;

            // 🔴 Check limit
            if (repeater_limit && currentCount >= repeater_limit) {
                show_snackbar(`${item_name} limit of ${repeater_limit} reached`);
                return;
            }

            if (!$container.hasClass('active')) {
                $container.addClass('active').show();
            }

            const repeater_id = currentCount;
            const $new_container = $(generate_template(repeater_id));

            $new_container.find('.at-coll-title').text(`${item_name} ${repeater_id + 1}`);
            $new_container.find('.at-coll-body').hide();
            $new_container.attr('data-index', repeater_id);
            $container.append($new_container);

            update_repeater_title();
            config.update_names();
            initialize_search_handlers();
        }

        // Update titles for repeater items
        function update_repeater_title() {
            $(`#${container_id} .at-coll-container`).each(function (index) {
                $(this).find('.at-coll-title').text(`${item_name} ${index + 1}`);
                $(this).attr('data-index', index);
            });
        }

        // Initialize repeater
        at_init_repeater();

        // Bind add button
        $(`#${add_button_id}`).on('click', add_new_repeater_item);
    }

    // Search Module: Generic search handler for terms and posts
    function init_search_handler(container_id, config) {
        const { search_class, results_class, action, save_key, limit, name_prefix } = config;
        const $container = $(`#${container_id}`);

        // Hide results when clicking outside
        $('body').on('click', (e) => {
            if (!$(e.target).hasClass(search_class) && !$(e.target).hasClass(results_class)) {
                $(`#${container_id} .${results_class}`).hide();
            }
        });

        // Show results on input click
        $container.on('click', `.${search_class}`, function (e) {
            e.stopPropagation();
            const $input = $(this);
            const search = $input.val();
            if (search.length >= 3) {
                $input.siblings(`.${results_class}`).show();
            }
        });

        // Handle search input
        $container.on('keyup', `.${search_class}`, delay(function () {
            const $search_input = $(this);
            const search = $search_input.val();
            const $parent_container = $search_input.closest('.at-coll-container');
            const index = $parent_container.data('index');

            if (typeof index === 'undefined') {
                console.error(`Index undefined for ${container_id}, input:`, $search_input[0]);
                show_snackbar('Search failed: Invalid repeater index.');
                return;
            }

            if (search.length === 0) {
                $search_input.siblings(`.${results_class}`).hide();
                return;
            }

            if (search.length < 3) {
                show_snackbar('Please enter at least 3 characters.');
                return;
            }

            $.ajax({
                url: apktemplates_ajax_vars.ajax_url,
                type: 'POST',
                data: {
                    action: action,
                    nonce: apktemplates_ajax_vars.nonce,
                    query: search
                },
                success: (data) => {
                    if (data && data.trim()) {
                        $search_input.siblings(`.${results_class}`).show().html(data);
                    } else {
                        show_snackbar('No results found.');
                        $search_input.siblings(`.${results_class}`).hide();
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error(`Search AJAX failed for ${action}: ${textStatus}, Error: ${errorThrown}, Response:`, jqXHR.responseText);
                    show_snackbar(`Search failed: ${textStatus}`);
                }
            });
        }, 500));

        // Handle result selection
        $container.on('click', `.${results_class} ul li`, function () {
            const $coll_body = $(this).closest('.at-coll-body');
            const $selected_container = $coll_body.find(`.${results_class}-selected ul, .coll-selected ul`);
            const $search_input = $coll_body.find(`.${search_class}`);
            const item_id = $(this).data(`${save_key}-id`);
            const item_title = $(this).text();
            const data_search_id = $selected_container.data(`${save_key}-search-id`) || $coll_body.closest('.at-coll-container').data('index');

            if (typeof data_search_id === 'undefined') {
                console.error(`Index undefined for ${container_id}, ul:`, $selected_container[0]);
                show_snackbar('Failed to add item: Invalid index.');
                return;
            }

            const exist_items = $selected_container.find('li');
            if (exist_items.length >= limit) {
                show_snackbar(`Maximum limit of ${limit} items reached.`);
                return;
            }

            const exist_item_ids = exist_items.map((_, el) => $(el).data(`${save_key}-id`)).get();
            if (exist_item_ids.includes(item_id)) {
                show_snackbar('This item has already been added.');
                return;
            }

            const new_item = $(`
                <li data-${save_key}-id="${item_id}">
                    ${item_title}
                    <span class="delete"><i class="fa fa-trash-alt"></i></span>
                    <input type="hidden" name="${name_prefix}[${data_search_id}][${save_key}_id]" 
                        value="${item_id}" data-field-key="${save_key}_id" />
                </li>`).hide();

            $selected_container.find(`input[name="${name_prefix}[${data_search_id}][${save_key}_id]"]`).remove();
            $selected_container.append(new_item);
            new_item.slideDown(250);
            $search_input.val('');
            $coll_body.find(`.${results_class}`).hide();

            const repeater_config = repeater_configs.find(c => c.container_id === container_id);
            if (repeater_config) {
                repeater_config.update_names();
            }
        });

        // Handle deletion of selected items
        $container.on('click', `.${results_class}-selected ul li .delete`, function () {
            const $coll_body = $(this).closest('.at-coll-body');
            const $selected_container = $coll_body.find(`.${results_class}-selected ul`);
            const data_search_id = $selected_container.data(`${save_key}-search-id`) || $(this).closest('.at-coll-container').data('index');
            $(this).parent().fadeOut(350, () => {
                $(this).parent().remove();
                if ($selected_container.find('li').length === 0) {
                    $selected_container.find(`input[name="${name_prefix}[${data_search_id}][${save_key}_id]"]`).remove();
                    $selected_container.append(`<input type="hidden" name="${name_prefix}[${data_search_id}][${save_key}_id]" value="" data-field-key="${save_key}_id" />`);
                }
                const repeater_config = repeater_configs.find(c => c.container_id === container_id);
                if (repeater_config) {
                    repeater_config.update_names();
                }
            });
        });
    }

    // Media Uploader Module: Handle single image upload
    function single_media_uploader(title, target_selector) {
        const media_uploader = wp.media({
            title: title,
            multiple: false
        });

        media_uploader.on('select', () => {
            const selected_image = media_uploader.state().get('selection').first();
            const image_url = selected_image.toJSON().url;
            const escaped_selector = target_selector.replace(/\[/g, '\\[').replace(/\]/g, '\\]').replace(/_/g, '\\_');
            const $target = $(escaped_selector);
            if ($target.length) {
                $target.val(image_url);
            } else {
                console.error(`Media uploader: Target input not found for selector ${escaped_selector}`);
                show_snackbar('Failed to set image URL. Please try again.');
            }
        });

        media_uploader.open();
    }

    // Tab Module: Handle tab switching
    function activate_tab_section(section) {
        $('.at-panel-fields-container .at-field-section').removeClass('active');
        $('.at-panel-tab').removeClass('active');
        $(`.at-field-section[data-section="${section}"]`).addClass('active');
        $(`.at-panel-tab a[href="#${section}"]`).parent().addClass('active');
        $('html, body').scrollTop(0);
    }

    $('.at-panel-tabs ul .at-panel-tab a').on('click', function (event) {
        event.preventDefault();
        const section = this.hash.replace('#', '');
        activate_tab_section(section);
        history.pushState(null, null, this.href);
    });

    $(window).on('popstate', () => {
        const section = location.hash.replace('#', '');
        if (section) activate_tab_section(section);
    });

    const init_selection = location.hash.replace('#', '');
    if (init_selection) activate_tab_section(init_selection);

    // AJAX Module: Handle license verification
    $(document).on('click', '#apkt-license-btn', function (e) {
        e.preventDefault();
        const $panel_form = $('#at-panel-form');
        const license_key = $('#apkt_license_key').val();
        const license_email = $('#apkt_license_email').val();
        const license_action = $(this).attr('data-action');

        if (!license_key || !license_email) {
            show_snackbar('Please enter both license key and email.');
            return;
        }

        $panel_form.addClass('loading');
        show_snackbar('Verifying...', false);

        $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: {
                action: license_action,
                nonce: apktemplates_ajax_vars.nonce,
                apkt_license_key: license_key,
                apkt_license_email: license_email
            },
            success: (data) => {
                const response = JSON.parse(data);
                $panel_form.removeClass('loading');
                show_snackbar(response?.data?.message);
                if (response?.status === 'success') {
                    setTimeout(() => window.location.reload(), 2000);
                }
            },
            error: (jqXHR, textStatus) => {
                $panel_form.removeClass('loading');
                show_snackbar(`Verification failed: ${textStatus}`);
            }
        });
    });

    // AJAX Module: Handle demo import
    $(document).on('click', '#import-demo-btn', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to import demo? New posts will be added.')) {
            $('#import-demo-container').slideToggle(350);
        }
    });

    $(document).on('change', '#import-demo', function () {
        const $panel_form = $('#at-panel-form');
        const import_file = this.files[0];
        const $snackbar = $('#at-snackbar');

        if (!import_file) {
            show_snackbar('Please select a file to import.');
            return;
        }

        if (!import_file.name.toLowerCase().endsWith('.json')) {
            show_snackbar('Please select a .json file to import.');
            return;
        }

        $panel_form.addClass('loading');
        show_snackbar('File uploading...');

        const formData = new FormData();
        formData.append('action', 'apkt_import_demo');
        formData.append('nonce', apktemplates_ajax_vars.nonce);
        formData.append('import_file', import_file);

        $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: (data) => {
                $panel_form.removeClass('loading');
                show_snackbar(data.data);
                setTimeout(() => window.location.reload(), 2000);
            },
            error: (jqXHR, textStatus) => {
                $panel_form.removeClass('loading');
                $snackbar.css('opacity', '0');
                show_snackbar(`Import failed: ${textStatus}`);
            }
        });
    });

    // AJAX Module: Handle settings import
    $(document).on('click', '#import-settings-btn', function (e) {
        e.preventDefault();
        if (confirm('Are you sure you want to import settings? Current settings will be changed. Take a backup by exporting first.')) {
            $('#import-settings-container').slideToggle(350);
        }
    });

    $(document).on('change', '#import-settings', function () {
        const $panel_form = $('#at-panel-form');
        const import_file = this.files[0];
        const $snackbar = $('#at-snackbar');

        if (!import_file) {
            show_snackbar('Please select a file to import.');
            return;
        }

        if (!import_file.name.toLowerCase().endsWith('.json')) {
            show_snackbar('Please select a .json file to import.');
            return;
        }

        $panel_form.addClass('loading');
        show_snackbar('File uploading...');

        const formData = new FormData();
        formData.append('action', 'apkt_import_settings');
        formData.append('nonce', apktemplates_ajax_vars.nonce);
        formData.append('import_file', import_file);

        $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: (data) => {
                $panel_form.removeClass('loading');
                show_snackbar(data.data);
                setTimeout(() => window.location.reload(), 2000);
            },
            error: (jqXHR, textStatus) => {
                $panel_form.removeClass('loading');
                $snackbar.css('opacity', '0');
                show_snackbar(`Import failed: ${textStatus}`);
            }
        });
    });

    // AJAX Module: Handle settings export
    $(document).on('click', '#export-settings', function (e) {
        e.preventDefault();
        const $panel_form = $('#at-panel-form');

        if (!confirm('Are you sure you want to export settings?')) return;

        $panel_form.addClass('loading');
        $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'apkt_export_settings',
                nonce: apktemplates_ajax_vars.nonce
            },
            success: (data) => {
                const export_file_url = data.data;
                const export_file_name = export_file_url.split('/').pop();
                $panel_form.removeClass('loading');
                show_snackbar('Downloading...!');

                const link = document.createElement('a');
                link.href = export_file_url;
                link.download = export_file_name;
                link.style.display = 'none';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: (jqXHR, textStatus) => {
                $panel_form.removeClass('loading');
                show_snackbar(`Export failed: ${textStatus}`);
            }
        });
    });

    // AJAX Module: Handle cache deletion
    $(document).on('click', '#delete-cache', function (e) {
        e.preventDefault();
        const $panel_form = $('#at-panel-form');
        $panel_form.addClass('loading');

        $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'apkt_delete_folder_action',
                nonce: apktemplates_ajax_vars.nonce
            },
            success: () => {
                $panel_form.removeClass('loading');
                show_snackbar('Cleared!');
                window.location.reload();
            },
            error: (jqXHR, textStatus) => {
                $panel_form.removeClass('loading');
                show_snackbar(`Cache deletion failed: ${textStatus}`);
            }
        });
    });

    // Form Module: Handle form submission
    $(document).on('submit', '#at-panel-form', function (e) {
        e.preventDefault();
        const $panel_form = $(this);
        const $panel_inputs = $panel_form.find('input, select, button, textarea');

        // Add empty inputs if no containers exist
        repeater_configs.forEach(config => {
            if ($(`#${config.container_id} .at-coll-container`).length === 0) {
                $('<input>').attr({
                    type: 'hidden',
                    name: `${config.fields[0].name_prefix}[]`,
                    value: ''
                }).appendTo(`#${config.container_id}`);
            }
        });

        $panel_form.addClass('loading');
        $panel_inputs.prop('disabled', true);

        const serializedData = $panel_form.find(":input:not([type='search']):not([type='submit']):not([type='button']):not([type='file']):not([id='apkt_license_key']):not([id='apkt_license_email'])")
            .map(function () {
                return {
                    name: this.name,
                    value: this.type === 'checkbox' ? this.checked : $(this).val()
                };
            }).get();

        $.ajax({
            url: apktemplates_ajax_vars.ajax_url,
            type: 'POST',
            data: {
                action: 'save_at_customization',
                nonce: apktemplates_ajax_vars.nonce,
                data: serializedData
            },
            success: (data) => {
                $panel_form.removeClass('loading');
                show_snackbar(data.data);
            },
            error: (jqXHR, textStatus) => {
                $panel_form.removeClass('loading');
                show_snackbar(`Save failed: ${textStatus}`);
            },
            complete: () => {
                $panel_inputs.prop('disabled', false);
            }
        });
    });

    // UI Module: Toggle password visibility
    $('.at-password-btn').click(function () {
        const $container = $(this).closest('.at-inputs-container');
        const $passwordInput = $container.find('.at-password-ipt');
        const $passwordButton = $container.find('.at-password-btn');

        if ($passwordInput.attr('type') === 'password') {
            $passwordInput.attr('type', 'text');
            $passwordButton.val('\uf06e');
        } else {
            $passwordInput.attr('type', 'password');
            $passwordButton.val('\uf070');
        }
    });

    // Repeater Configurations
    const repeater_configs = [
        {
            container_id: 'at-home-rc-field',
            item_name: 'Recommended Post',
            fields: [
                {
                    type: 'search',
                    label: 'Post',
                    description: 'Select a post to link to this featured post.',
                    name_prefix: 'au_home_recommended',
                    key: 'post_id',
                    search_class: 'coll-search',
                    results_class: 'coll-results',
                    save_key: 'post'
                },
                {
                    type: 'text',
                    label: 'Badge Text',
                    description: 'Add custom badge text (e.g. Patrocinado, Destacado). Leave blank for default.',
                    name_prefix: 'au_home_recommended',
                    key: 'badge_text'
                }
            ],
            search_config: {
                search_class: 'coll-search',
                results_class: 'coll-results',
                action: 'at_search_post',
                save_key: 'post',
                limit: 1,
                name_prefix: 'au_home_recommended'
            },
            add_button_id: 'add-new-recommended',
        },
        {
            container_id: 'at-posts-field',
            item_name: 'Posts',
            fields: [
                {
                    type: 'text',
                    label: 'Section Title',
                    description: 'Add text for title.',
                    name_prefix: 'au_home_posts',
                    key: 'title'
                },
                {
                    type: 'number',
                    label: 'Posts Limit',
                    description: 'Set the number of posts shown.',
                    name_prefix: 'au_home_posts',
                    key: 'limit',
                    attributes: 'min="1" max="50"'
                },
                {
                    type: 'select',
                    label: 'Posts Order',
                    description: 'Set the order of listing posts shown.',
                    name_prefix: 'au_home_posts',
                    key: 'sort',
                    options: {
                        'latest': 'Latest',
                        'modified': 'Modified',
                        'popular': 'Popular',
                        'a_to_z': 'A to Z ↓',
                        'z_to_a': 'A to Z ↑',
                    }
                },
                {
                    type: 'select',
                    label: 'Posts Style',
                    description: 'Set posts style to showcase your posts.',
                    name_prefix: 'au_home_posts',
                    key: 'style',
                    options: {
                        'boxed': 'Boxed',
                        'rectangle': 'Rectangle',
                        'landscape': 'Landscape',
                    }
                },
                {
                    type: 'search',
                    label: 'Term',
                    description: 'Select a category or tag term for the posts that will be shown.',
                    name_prefix: 'au_home_posts',
                    key: 'term_id',
                    search_class: 'coll-search',
                    results_class: 'coll-results',
                    save_key: 'term'
                },
                {
                    type: 'checkbox',
                    label: 'Term Bottom Ad',
                    description: 'Show or hide the advertisement shown at the bottom of this term.',
                    name_prefix: 'au_home_posts',
                    key: 'is_btm_ad'
                }
            ],
            search_config: {
                search_class: 'coll-search',
                results_class: 'coll-results',
                action: 'at_search_term',
                save_key: 'term',
                limit: 1,
                name_prefix: 'au_home_posts'
            },
            add_button_id: 'add-new-posts'
        },
        {
            container_id: 'at-single-help-guide',
            item_name: 'Help Text',
            fields: [
                {
                    type: 'text',
                    label: 'Help text',
                    description: 'Add text for help section.',
                    name_prefix: 'au_single_help_guide',
                    key: 'text'
                },
            ],
            add_button_id: 'add-new-help-text',
        },
        {
            container_id: 'at-download-faqs',
            item_name: 'FAQ',
            fields: [
                {
                    type: 'text',
                    label: 'Question',
                    description: 'Add text for question.',
                    name_prefix: 'au_download_faqs',
                    key: 'question'
                },
                {
                    type: 'textarea',
                    label: 'Answer',
                    description: 'Add text for answer.',
                    name_prefix: 'au_download_faqs',
                    key: 'answer'
                }
            ],
            add_button_id: 'add-new-dl-faq',
        },
        {
            container_id: 'archive-dynamic-subcats',
            item_name: 'Subcategory',
            fields: [
                {
                    type: 'checkbox',
                    label: 'Enable/Disable',
                    description: 'Show/Hide this section.',
                    name_prefix: 'archive_dynamic_subcats',
                    key: 'enable'
                },
                {
                    type: 'text',
                    label: 'Custom Title',
                    description: 'Leave empty to use category name.',
                    name_prefix: 'archive_dynamic_subcats',
                    key: 'title'
                },
                {
                    type: 'search',
                    label: 'Subcategory',
                    description: 'Search and select the subcategory.',
                    name_prefix: 'archive_dynamic_subcats',
                    key: 'term_id',
                    search_class: 'coll-search',
                    results_class: 'coll-results',
                    save_key: 'term'
                },
                {
                    type: 'select',
                    label: 'Parent Category Filter',
                    description: 'Show this section on this parent category page only.',
                    name_prefix: 'archive_dynamic_subcats',
                    key: 'parent_cat',
                    options: window.apktemplates_ajax_vars && window.apktemplates_ajax_vars.parent_cats ? window.apktemplates_ajax_vars.parent_cats : { 'all': 'All' }
                },
                {
                    type: 'select',
                    label: 'Display Style',
                    description: 'Choose the layout style.',
                    name_prefix: 'archive_dynamic_subcats',
                    key: 'style',
                    options: {
                        'boxed': 'Boxed',
                        'rectangle': 'Rectangle',
                        'landscape': 'Landscape'
                    }
                },
                {
                    type: 'select',
                    label: 'Order By',
                    description: 'Sorting order for this subcategory.',
                    name_prefix: 'archive_dynamic_subcats',
                    key: 'posts_order',
                    options: {
                        'latest': 'Latest',
                        'popular': 'Popular',
                        'oldest': 'Oldest',
                        'modified': 'Recently Modified',
                        'a_to_z': 'A to Z',
                        'random': 'Random'
                    }
                },
                {
                    type: 'number',
                    label: 'Posts Limit',
                    description: 'Number of apps to show.',
                    name_prefix: 'archive_dynamic_subcats',
                    key: 'limit',
                    attributes: 'min="1" max="100"'
                }
            ],
            search_config: {
                search_class: 'coll-search',
                results_class: 'coll-results',
                action: 'at_search_term',
                save_key: 'term',
                limit: 1,
                name_prefix: 'archive_dynamic_subcats'
            },
            add_button_id: 'add-new-dynamic-subcat',
        }
    ];

    // Add update_names method to each repeater config
    repeater_configs.forEach(config => {
        config.update_names = function () {
            update_repeater_names(this.container_id, this.fields);
        };
    });

    // Generic update names function for repeaters
    function update_repeater_names(container_id, fields) {
        $(`#${container_id} .at-coll-container`).each(function (index) {
            const $container = $(this);
            fields.forEach(field => {
                let $input;
                if (field.type === 'image') {
                    $input = $container.find(`input[type="text"][data-field-key="${field.key}"]`);
                } else if (field.type === 'search') {
                    $input = $container.find(`.${field.results_class}-selected input[type="hidden"][data-field-key="${field.key}"]`);
                } else if (field.type === 'checkbox') {
                    $input = $container.find(`input[type="checkbox"][data-field-key="${field.key}"]`);
                } else if (field.type === 'select') {
                    $input = $container.find(`select[data-field-key="${field.key}"]`);
                } else {
                    $input = $container.find(`input[type="${field.type}"][data-field-key="${field.key}"]`);
                }

                if ($input.length) {
                    $input.attr('name', `${field.name_prefix}[${index}][${field.key}]`);
                }

                if (field.type === 'image') {
                    const $img_input = $container.find(`input[type="text"][id^="${field.name_prefix}_"][data-field-key="${field.key}"]`);
                    if ($img_input.length) {
                        $img_input.attr('id', `${field.name_prefix}_${index}_${field.key}`);
                    }
                    const $img_button = $container.find(`input[type="button"][data-target^="#${field.name_prefix}_"]`);
                    if ($img_button.length) {
                        $img_button.attr('data-target', `#${field.name_prefix}_${index}_${field.key}`);
                    }
                } else if (field.type === 'search') {
                    const $ul = $container.find(`.${field.results_class}-selected ul`);
                    if ($ul.length) {
                        $ul.attr(`data-${field.save_key}-search-id`, index);
                    }
                    const $search_input = $container.find(`.${field.search_class}`);
                    if ($search_input.length) {
                        $search_input.attr('data-index', index);
                    }
                }
            });
        });
    }

    // Initialize existing repeater items with correct indices and re-bind search handlers
    function initialize_search_handlers() {
        repeater_configs.forEach(config => {
            $(`#${config.container_id} .at-coll-container`).each(function (index) {
                const $container = $(this);
                $container.attr('data-index', index);
                if (config.search_config) {
                    $container.find(`.${config.search_config.search_class}`).attr('data-index', index);
                    $container.find(`.${config.search_config.results_class}-selected ul`)
                        .attr(`data-${config.search_config.save_key}-search-id`, index);
                    $container.find(`.${config.search_config.results_class}-selected input[type=hidden]`)
                        .attr('name', `${config.search_config.name_prefix}[${index}][${config.search_config.save_key}_id]`);
                }
            });
        });
    }

    // Initialize components
    function at_init_wp_media_uploader() {
        $(document).on("click", ".at-upload-img-ipt", function () {
            var title = $(this).data('title');
            var target = $(this).data('target');
            single_media_uploader(title, target);
        });
    }

    // Initialize repeaters
    repeater_configs.forEach(config => {
        create_repeater(config);
    });

    // Initialize search handlers
    initialize_search_handlers();

    $(document).ready(function () {
        at_init_wp_media_uploader();
        at_init_term_search('at-hero-term-wrapper', 'au_home_hero_term_id');
        at_init_term_search('at-trending-term-wrapper', 'au_home_trending_term_id');
        at_init_term_search('at-premium-term-wrapper', 'au_home_premium_term_id');
    });
    $('.color-picker').wpColorPicker();

    // Clear Archive Cache Button Handler
    $(document).on('click', '#apkup-clear-cache-btn', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const originalText = $btn.text();
        $btn.prop('disabled', true).text('Clearing...');

        $.post(apktemplates_ajax_vars.ajax_url, {
            action: 'apkup_clear_archive_cache',
            nonce: apktemplates_ajax_vars.nonce
        })
            .done(function (response) {
                if (response.success) {
                    show_snackbar('Archive cache cleared successfully!');
                } else {
                    show_snackbar('Failed to clear cache.');
                }
            })
            .fail(function () {
                show_snackbar('Request failed.');
            })
            .always(function () {
                $btn.prop('disabled', false).text(originalText);
            });
    });
});