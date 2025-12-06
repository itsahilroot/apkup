<?php
function apkt_panel()
{
    ?>
    <div id="at-panel">
        <form method="POST" id="at-panel-form">
            <div class="at-panel-container">
                <div class="at-panel-left">
                    <div class="at-panel-header">
                        <h2>Panel <span class="at-panel-version" style="font-size: 0.75rem; opacity: 0.7;">v<?php echo APKT_THEME_VERSION; ?></span></h2>
                    </div>
                    <div class="at-panel-tabs">
                        <ul>
                            <li class="at-panel-tab active">
                                <a href="#general">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" /></svg> General
                                </a>
                            </li>
                            <li class="at-panel-tab">
                                <a href="#home">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg> Home
                                </a>
                            </li>
                            <li class="at-panel-tab">
                                <a href="#single">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg> Single
                                </a>
                            </li>
                            <li class="at-panel-tab">
                                <a href="#download">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg> Download
                                </a>
                            </li>
                            <!-- <li class="at-panel-tab">
                                <a href="#sidebar">
                                    <i class="fa fa-th-list"></i> Sidebar
                                </a>
                            </li> -->
                            <li class="at-panel-tab">
                                <a href="#advertisement">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Advertisement
                                </a>
                            </li>
                            <!-- <li class="at-panel-tab">
                                <a href="#social">
                                    <i class="fa fa-link"></i> Social
                                </a>
                            </li> -->
                            <li class="at-panel-tab">
                                <a href="#footer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-3 18" /></svg> Footer
                                </a>
                            </li>
                            <!-- <li class="at-panel-tab">
                                <a href="#importer">
                                    <i class="fa-brands fa-google-play"></i> APK Importer
                                </a>
                            </li> -->
                            <!-- <li class="at-panel-tab">
                                <a href="#settings">
                                    <i class="fa fa-sliders"></i> Settings
                                </a>
                            </li> -->
                            <li class="at-panel-tab">
                                <a href="#changelog">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg> Changelog
                                </a>
                            </li>
                            <li class="at-panel-tab">
                                <a href="#info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg> Info
                                </a>
                            </li>
                            <li>
                                <div class="save-changes">
                                    <input type="submit" name="save-at-panel" class="button-primary" value="Save Changes" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="at-panel-right">
                    <div class="at-panel-fields-container">
                        <?php
                        $components = [
                            'general',
                            'home',
                            'single',
                            'download',
                            //'sidebar',
                            'advertisement',
                            //'social',
                            'footer',
                            //'importer',
                            //'settings',
                            'changelog',
                            'info'
                        ];

                        foreach ($components as $component) {
                            get_template_part('admin/inc/menu/components/' . $component);
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="save-changes" style="display: none">
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>
    <?php
}