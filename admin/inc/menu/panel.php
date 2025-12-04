<?php
function apkt_panel()
{
    ?>
    <div id="at-panel">
        <form method="POST" id="at-panel-form">
            <div class="at-panel-container">
                <div class="at-panel-left">
                    <div class="at-panel-header">
                        <h2>Panel</h2>
                    </div>
                    <div class="at-panel-tabs">
                        <ul>
                            <li class="at-panel-tab active">
                                <a href="#general">
                                    <i class="fa fa-cog"></i> General
                                </a>
                            </li>
                            <li class="at-panel-tab">
                                <a href="#home">
                                    <i class="fa fa-home"></i> Home
                                </a>
                            </li>
                            <li class="at-panel-tab">
                                <a href="#single">
                                    <i class="fa fa-file-text"></i> Single
                                </a>
                            </li>
                            <li class="at-panel-tab">
                                <a href="#download">
                                    <i class="fa fa-download"></i> Download
                                </a>
                            </li>
                            <!-- <li class="at-panel-tab">
                                <a href="#sidebar">
                                    <i class="fa fa-th-list"></i> Sidebar
                                </a>
                            </li> -->
                            <li class="at-panel-tab">
                                <a href="#advertisement">
                                    <i class="fa fa-usd"></i> Advertisement
                                </a>
                            </li>
                            <!-- <li class="at-panel-tab">
                                <a href="#social">
                                    <i class="fa fa-link"></i> Social
                                </a>
                            </li> -->
                            <li class="at-panel-tab">
                                <a href="#footer">
                                    <i class="fa fa-code"></i> Footer
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
                                <a href="#info">
                                    <i class="fa fa-info-circle"></i> Info
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