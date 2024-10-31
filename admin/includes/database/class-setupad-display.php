<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Setupad_List_Table extends WP_List_Table
{

    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'setupad',
            'plural' => 'setupads',
        ));
    }


    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }


    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }


    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
            'setupad_title' => __('Ad Title', 'setupad'),
            'setupad_position' => __('Ad Position', 'setupad'),
            'setupad_status' => __('Status', 'setupad'),
            'setupad_shortcode' => __('Ad Shortcode', 'setupad'),
            'setupad_creation_date' => __('Last Updated', 'setupad'),
            'editing_tools_key' => '',
        );
        return $columns;
    }

    function display_tablenav( $which ) {
        if ( 'top' === $which ): ?>
            <?php wp_nonce_field( 'bulk-' . $this->_args['plural'] ); ?>
            <div class="tablenav <?php echo esc_attr( $which ); ?>">

                <?php if ( $this->has_items() ) : ?>
                    <div class="alignleft actions bulkactions">
                        <?php esc_html($this->bulk_actions( $which )); ?>
                    </div>
                <?php
                endif; ?>

                <div class="stpd-btn-row">
                    <a href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=stpd-new_ad')) ?>"class="stpd-create-ad-placement">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        <?php _e('Create ad placement', 'setupad') ?>
                    </a>
                </div>

                <?php
                $this->extra_tablenav( $which );

                if ($this->_pagination_args['total_items']) {
                    $total_items = $this->_pagination_args['total_items'];
                    $output = '<div class="tablenav-pages"><span class="displaying-num">' . sprintf(
                        /* translators: %s: Number of items. */
                            _n('%s item', '%s items', $total_items),
                            number_format_i18n($total_items)
                        ) . '</span></div>';

                    print ($output);
                }
                ?>
            </div>
        <?php elseif (( 'bottom' === $which )):
            $total_pages = $this->_pagination_args['total_pages'];
            $current = $this->get_pagenum();
            $removable_query_args = wp_removable_query_args();

            $current_url = sanitize_url(set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ));
            $current_url = remove_query_arg( $removable_query_args, $current_url );

            $total_pages_before = '<span class="paging-input">';
            $total_pages_after  = '</span></span>';

            $disable_prev = false;
            $disable_next = false;
            if ( 1 == $current ) {
                $disable_prev  = true;
            }
            if ( $total_pages == $current || !$total_pages ) {
                $disable_next = true;
            }

            $html_current_page = sprintf(
                "%s<input class='current-page' id='current-page-selector' type='text' name='paged' value='%s' size='%d' aria-describedby='table-paging' /><span class='tablenav-paging-text'>",
                '<label for="current-page-selector" class="screen-reader-text">' . __( 'Current Page' ) . '</label>',
                $current,
                strlen( $total_pages )
            );

            if ($total_pages == 0) $total_pages = 1;
            $html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );

            $pagination     = $total_pages_before . sprintf(
                /* translators: 1: Current page, 2: Total pages. */
                    _x( 'Page %1$s of %2$s', 'paging' ),
                    $html_current_page,
                    $html_total_pages
                ) . $total_pages_after;

            if ( $disable_prev ) {
                $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">' . __( 'Previous page' ) . '</span>';
            } else {
                $page_links[] = sprintf(
                    "<a class='prev-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>" . __( 'Previous page' ) . "</span></a>",
                    esc_url( add_query_arg( 'paged', max( 1, $current - 1 ), $current_url ) ),
                    __( 'Previous page' ),
                    '&lsaquo;'
                );
            }

            if ( $disable_next ) {
                $page_links[] = '<span class="tablenav-pages-navspan button disabled" aria-hidden="true">' . __( 'Next page' ) . '</span>';
            } else {
                $page_links[] = sprintf(
                    "<a class='next-page button' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>" . __( 'Next page' ) . "</span></a>",
                    esc_url( add_query_arg( 'paged', min( $total_pages, $current + 1 ), $current_url ) ),
                    __( 'Next page' ),
                    '&rsaquo;'
                );
            }

            $output = "\n<div class='pagination-links'>" . implode( "\n", $page_links ) . '</div>';

            if ( $total_pages ) {
                $page_class = $total_pages < 2 ? ' one-page' : '';
            } else {
                $page_class = ' no-pages';
            }
            $this->_pagination = "<div>$pagination</div>";

            echo "<div class='tablenav bottom'>";
            echo wp_kses($this->_pagination, array(
                'div' => [],
                'label' => array(
                    'for' => [],
                    'class' => []
                ),
                'input' => array(
                    'class' => [],
                    'id' => [],
                    'type' => [],
                    'name' => [],
                    'value' => [],
                    'size' => [],
                    'aria-describedby'
                ),
                'span' => array(
                    'class'
                ),
            ));
            echo wp_kses_post($output);
            echo "</div>";
        endif;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'setupad_title' => array('setupad_title', true),
            'setupad_position' => array('setupad_position', false),
            'setupad_status' => array('setupad_status', false),
            'setupad_shortcode' => array('setupad_shortcode', false),
            'setupad_creation_date' => array('setupad_creation_date', false),
        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete',
            'duplicate' => 'Duplicate',
        );
        return $actions;
    }


    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'setupad'; // do not forget about tables prefix



        if ('delete' === $this->current_action() || 'duplicate' === $this->current_action()) {
            if (isset($_REQUEST['id'])) {
                $ids = (is_array($_REQUEST['id'])) ? array_map('sanitize_text_field', $_REQUEST['id']) : $_REQUEST['id'];
            } else {
                $ids = array();
            }
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                switch($this->current_action()){
                    case 'delete':
                        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id IN(%5s)", $ids));
                        break;
                    case 'duplicate':
                        $rows_to_duplicate = $wpdb->get_results(
                            $wpdb->prepare("SELECT * FROM $table_name WHERE id IN (%5s)", $ids)
                        );
                        foreach ($rows_to_duplicate as $row) {

                            unset($row->id); // Remove the existing ID to generate a new one
                            unset($row->setupad_shortcode); // Remove existing shortcode
                            $row->setupad_title = $row->setupad_title . ' copy'; // Append copy to the title of duplicated ad unit
                            $row->setupad_creation_date = date('Y-m-d H:i:s', current_time('timestamp', 0)); // Update timestamp

                            $wpdb->insert($table_name, (array)$row);

                            $new_id = $wpdb->insert_id;
                            // Update shortcode with newly generated ID
                            $wpdb->update(
                                $table_name,
                                array('setupad_shortcode' => '[setupad num=' . $new_id . ']'),
                                array('id' => $new_id)
                            );

                        }
                        break;
                }
            }
        }

    }

    function print_column_headers( $with_id = true )
    {
        list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();

        $current_url = sanitize_url(set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ));
        $current_url = remove_query_arg( 'paged', $current_url );

        if ( isset( $_GET['orderby'] ) ) {
            $current_orderby = sanitize_text_field($_GET['orderby']);
        } else {
            $current_orderby = '';
        }

        if ( isset( $_GET['order'] ) && 'desc' === $_GET['order'] ) {
            $current_order = 'desc';
        } else {
            $current_order = 'asc';
        }


        if ( ! empty( $columns['cb'] ) ) {
            static $cb_counter = 1;
            $columns['cb']     = '<label class="screen-reader-text">' . __( 'Select All' ) . '</label>'
                . '<input id="custom-select-all" type="checkbox" />' . '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                                          <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                                                        </svg>';
            $cb_counter++;
        }

        foreach ( $columns as $column_key => $column_display_name ) {
            $class = array( 'manage-column', "column-$column_key" );

            if ( in_array( $column_key, $hidden, true ) ) {
                $class[] = 'hidden';
            }

            if ( 'cb' === $column_key ) {
                $class[] = '';
            } elseif ( in_array( $column_key, array( 'posts', 'comments', 'links' ), true ) ) {
                $class[] = 'num';
            }

            if ( $column_key === $primary ) {
                $class[] = 'column-primary';
            }

            if ( isset( $sortable[ $column_key ] ) ) {
                list( $orderby, $desc_first ) = $sortable[ $column_key ];

                if ( $current_orderby === $orderby ) {
                    $order = 'asc' === $current_order ? 'desc' : 'asc';

                    $class[] = 'sorted';
                    $class[] = $current_order;
                } else {
                    $order = strtolower( $desc_first );

                    if ( ! in_array( $order, array( 'desc', 'asc' ), true ) ) {
                        $order = $desc_first ? 'desc' : 'asc';
                    }

                    $class[] = 'sortable';
                    $class[] = 'desc' === $order ? 'asc' : 'desc';
                }

                $column_display_name = sprintf(
                    '<a href="%s"><span>%s</span><span class="sorting-indicator"></span></a>',
                    esc_url( add_query_arg( compact( 'orderby', 'order' ), $current_url ) ),
                    $column_display_name
                );
            }

            $tag   = ( 'cb' === $column_key ) ? 'td' : 'th';
            $scope = ( 'th' === $tag ) ? 'scope="col"' : '';
            $id    = $with_id ? "id='$column_key'" : '';

            if ( ! empty( $class ) ) {
                $class = "class='" . implode( ' ', $class ) . "'";
            }

            echo wp_kses("<$tag $scope $id $class>$column_display_name</$tag>", array(
                'tr',
                'td' => array(
                    'id' => [],
                    'class' => []
                ),
                'label' => array(
                    'class' => []
                ),
                'input' => array(
                    'id' => [],
                    'type' => []
                ),
                'svg' => array(
                    'xmlns' => [],
                    'width' => [],
                    'height' => [],
                    'fill' => [],
                    'class' => [],
                    'viewbox' => [],
                ),
                'path' => array(
                    'd' => []
                ),
                'th' => array(
                    'scope' => [],
                    'id' => [],
                    'class' => []
                ),
                'a' => array(
                    'href' => []
                ),
                'span' => array(
                    'class' => []
                )
            ));
        }
    }


    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'setupad'; // do not forget about tables prefix

        $per_page = 10; // constant, how much records will be shown per page

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

        // will be used in pagination settings
        $total_items = $wpdb->get_var($wpdb->prepare("SELECT COUNT(id) FROM %5s", $table_name));

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? ($per_page * max(0, intval(sanitize_text_field($_REQUEST['paged'])) - 1)) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? sanitize_text_field($_REQUEST['orderby']) : 'default';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? sanitize_sql_orderby($_REQUEST['order']) : 'asc';

        // [REQUIRED] define $items array

        // notice that last argument is ARRAY_A, so we will retrieve array
        if ($orderby === 'setupad_shortcode') {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM %5s ORDER BY LENGTH(%5s) %5s, %5s %5s LIMIT %d OFFSET %d",$table_name, $orderby, $order, $orderby, $order, $per_page, $paged), ARRAY_A);
        } else if ($orderby === 'default') {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM %5s ORDER BY setupad_creation_date DESC, setupad_title ASC LIMIT %d OFFSET %d",$table_name, $per_page, $paged), ARRAY_A);
        } else {
            $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM %5s ORDER BY %5s %5s LIMIT %d OFFSET %d",$table_name, $orderby, $order, $per_page, $paged), ARRAY_A);
        }

        $this->items = is_array($this->items) ?
            array_map('stripslashes_deep', $this->items) :
            stripslashes($this->items);

        foreach ($this->items as $key=>$item) {
            $this->items[$key]['setupad_title'] = '<a href="' . esc_url("?page=stpd-new_ad&id=" . $this->items[$key]['id']) . '">' . esc_html($this->items[$key]['setupad_title']) . '</a>';
            $this->items[$key]['setupad_creation_date'] = date("M d\, Y", strtotime($this->items[$key]['setupad_creation_date']));
            $this->items[$key]['editing_tools_key'] = ' <a style="margin-right: 20px;" href="' . esc_url('?page=' . $_REQUEST["page"] . '&action=duplicate&id=' . $this->items[$key]['id']) . '">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19" stroke="currentColor" fill="none" style="vertical-align: text-bottom;">
                                                                <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
                                                            </svg>
                                                        </a>
                                                        <a style="margin-right: 20px;" href="' . esc_url('?page=stpd-new_ad&id=' . $this->items[$key]['id']) . '">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19" fill="none">
                                                                <path d="M14.1667 2.28514C14.3856 2.06627 14.6454 1.89266 14.9314 1.77421C15.2173 1.65575 15.5238 1.59479 15.8334 1.59479C16.1429 1.59479 16.4494 1.65575 16.7353 1.77421C17.0213 1.89266 17.2812 2.06627 17.5 2.28514C17.7189 2.50401 17.8925 2.76385 18.011 3.04982C18.1294 3.33578 18.1904 3.64228 18.1904 3.95181C18.1904 4.26134 18.1294 4.56784 18.011 4.8538C17.8925 5.13977 17.7189 5.39961 17.5 5.61848L6.25002 16.8685L1.66669 18.1185L2.91669 13.5351L14.1667 2.28514Z" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </a>
                                                        <a href="' . esc_url('?page=' . $_REQUEST["page"] . '&action=delete&id=' . $this->items[$key]['id']) . '">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 18 19" fill="none">
                                                                <path d="M1.5 4.78518H3.16667M3.16667 4.78518H16.5M3.16667 4.78518V16.4518C3.16667 16.8939 3.34226 17.3178 3.65482 17.6304C3.96738 17.9429 4.39131 18.1185 4.83333 18.1185H13.1667C13.6087 18.1185 14.0326 17.9429 14.3452 17.6304C14.6577 17.3178 14.8333 16.8939 14.8333 16.4518V4.78518H3.16667ZM5.66667 4.78518V3.11851C5.66667 2.67648 5.84226 2.25256 6.15482 1.94C6.46738 1.62744 6.89131 1.45184 7.33333 1.45184H10.6667C11.1087 1.45184 11.5326 1.62744 11.8452 1.94C12.1577 2.25256 12.3333 2.67648 12.3333 3.11851V4.78518M7.33333 8.95184V13.9518M10.6667 8.95184V13.9518" stroke="#667085" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </a>';

            if (!$this->items[$key]['setupad_status']) {
                $this->items[$key]['setupad_position'] = esc_html(ucwords(str_replace('_', ' ', $this->items[$key]['setupad_position'])));
                $this->items[$key]['setupad_status'] = '<button data-id="'. $this->items[$key]['id'] .'" class="stpd-ad-status stpd-ad-status-disabled">Disabled</button>';
            } else {
                $this->items[$key]['setupad_position'] = esc_html(ucwords(str_replace('_', ' ', $this->items[$key]['setupad_position'])));
                $this->items[$key]['setupad_status'] = '<button data-id="'. $this->items[$key]['id'] .'" class="stpd-ad-status stpd-ad-status-active">Active</button>';
            }
        }

        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

    function display() {
        $singular = $this->_args['singular'];

        $this->display_tablenav( 'top' );

        $this->screen->render_screen_reader_content( 'heading_list' );
        ?>
        <table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
            <thead>
                <tr>
                    <?php $this->print_column_headers(); ?>
                </tr>
            </thead>

            <tbody id="the-list"
                <?php
                if ( $singular ) {
                    echo " data-wp-lists='list:" . esc_attr($singular) . "'";
                }
                ?>
            >
            <?php $this->display_rows_or_placeholder(); ?>
            </tbody>

        </table>
        <?php
        $this->display_tablenav( 'bottom' );
    }
}


