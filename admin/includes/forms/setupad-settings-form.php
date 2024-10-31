<table style="width: 100%; margin: 0" class="form-table settings-tbl">
    <tbody>
    <tr class="lazy-load-offset">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Lazy load offset (px)', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Set lazy loading offset of how many pixels before bottom of the screen lazy load code will execute. ( Default is -400 - your code with lazy loading enabled will execute when it reaches 400 pixels offset from the bottom of the screen.)','setupad'); ?></span>
            </div>
        </td>

        <td>
            <input id="setupad_lazy_load_offset" name="setupad_lazy_load_offset" class="code" type="text" placeholder="-400" value="<?php if (isset($setupad_settings['setupad_lazy_load_offset'])) echo $setupad_settings['setupad_lazy_load_offset'] ?>">
        </td>
    </tr>
    <tr class="ad-placement-class-name">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Block class name', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enter a custom ad placement wrapper class name. Default used is stpd-wp-block.','setupad'); ?></span>
            </div>
        </td>

        <td>
            <input id="setupad_ad_placement_class_name" name="setupad_ad_placement_class_name" class="code" type="text" placeholder="stpd-wp-block" value="<?php if (isset($setupad_settings['setupad_ad_placement_class_name'])) echo $setupad_settings['setupad_ad_placement_class_name'] ?>">
        </td>
    </tr>
    <tr id="ad-placement-label-enable">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Enable ad placement label', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enable ad placements to have a label displayed above them.','setupad'); ?></span>
            </div>
        </td>

        <td>
            <label class="stpd-tgl-switch">
                <input id="setupad_ad_placement_label_enable" name="setupad_ad_placement_label_enable" type="checkbox" value="true"
                    <?php if ($setupad_settings['setupad_ad_placement_label_enable']) { echo 'checked'; } ?>
                >
                <span class="stpd-slider"></span>
            </label>
        </td>
    </tr>
    <tr id="ad-placement-label" <?php if (!isset($setupad_settings['setupad_ad_placement_label_enable']) || !$setupad_settings['setupad_ad_placement_label_enable']) {
        echo 'style="display: none;"';
    }; ?>>
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Ad placement label name', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enter a custom label to display it above an ad placement. If enabled, by default "Advertisement" will be used.','setupad'); ?></span>
            </div>
        </td>

        <td>
            <input id="setupad_ad_placement_label" name="setupad_ad_placement_label" class="code" type="text" placeholder="Advertisement" value="<?php if (isset($setupad_settings['setupad_ad_placement_label'])) echo $setupad_settings['setupad_ad_placement_label'] ?>">
        </td>
    </tr>
    <tr class="paragraph-exclusion">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Exclude paragraphs inside', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enter comma separated elements from which to exclude paragraph insertion when ad position is "Before Paragraph" or "After Paragraph".','setupad'); ?></span>
            </div>
        </td>

        <td>
            <input id="setupad_paragraph_exclusion" name="setupad_paragraph_exclusion" class="code" type="text" placeholder="li, figure, blockquote" value="<?php if (isset($setupad_settings['setupad_paragraph_exclusion'])) echo $setupad_settings['setupad_paragraph_exclusion'] ?>">
        </td>
    </tr>
    </tbody>
</table>