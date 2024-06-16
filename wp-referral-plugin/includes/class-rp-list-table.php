<?php

class RP_List_Table extends WP_List_Table {
	public function __construct() {
        parent::__construct(array(
            'singular' => 'referral',
            'plural'   => 'referrals',
            'ajax'     => false
        ));
    }
    public function get_columns() {
        return array(
            'cb'       => '<input type="checkbox" />',
            'username' => 'Username',           
            'refferral_user'     => 'Referral User name',
            'commission'     => 'Join Commission',
            'actions'     => 'Actions',
        );
    }

    public function column_cb($item) {
        return sprintf('<input type="checkbox" name="referral[]" value="%s" />', $item['id']);
    }

    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'username':
            case 'refferral_user':
            case 'commission':
            case 'actions':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }

    public function get_bulk_actions() {
        return array(
            'delete' => 'Delete',
            'generate' => 'Generate Unique referral Code'
        );
    }

    public function prepare_items(){
    	global $wpdb;
        $table_name = $wpdb->prefix . 'referrals';

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));

    	$columns  = $this->get_columns();
    	$hidden   = array();
    	$sortable = array();
    	 $this->_column_headers = array($columns, $hidden, $sortable);

    	  $this->process_bulk_action();

        $offset = ($current_page - 1) * $per_page;
        $items = $wpdb->get_results($wpdb->prepare(
            "SELECT id, email, code, time as date FROM $table_name ORDER BY time DESC LIMIT %d OFFSET %d",
            $per_page,
            $offset
        ), ARRAY_A);

    	 $this->items = $this->get_referral();
    }

    public function get_referral(){

    }
}