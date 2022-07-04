<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class PollListTable extends WP_List_Table {

    function __construct() {
      global $status, $page;
      parent::__construct(array(
        'singular' => 'Poll',
        'plural' => 'Polls',
      ));
    }

    function column_default($item, $column_name) {

        switch($column_name){
          case 'action':
			echo '<a href="'.admin_url('admin.php?page=edit-poll&id='.$item['id']).'">Edit</a> <br>';
			echo '<a href="'.admin_url('admin.php?page=delete-poll&id='.$item['id']).'">Delete</a>';
		}

		if(isset($item[$column_name])){
			return $item[$column_name];
		}
		
    }
    
    function column_shortcode($item) {
	  global $wpdb;
	  $shortcode = '[simple-poll id="'.$item['id'].'"]';
	  echo $shortcode;
	}

	function column_total_votes($item) {
	  global $wpdb;
	  $yes_votes = $wpdb->get_var("SELECT `yes` FROM ".$wpdb->prefix."simple_poll WHERE id = ".$item['id']);
	  $no_votes = $wpdb->get_var("SELECT `no` FROM ".$wpdb->prefix."simple_poll WHERE id = ".$item['id']);
	  $total_votes = $yes_votes + $no_votes;
	  echo $total_votes;
	}

	function column_yes($item) {
		global $wpdb;
		$yes_votes = $wpdb->get_var("SELECT `yes` FROM ".$wpdb->prefix."simple_poll WHERE id = ".$item['id']);
		$no_votes = $wpdb->get_var("SELECT `no` FROM ".$wpdb->prefix."simple_poll WHERE id = ".$item['id']);
		$total_votes = $yes_votes + $no_votes;

		if($total_votes == 0)
			$yes_percentage = 0;
		else
			$yes_percentage = round( (($yes_votes / $total_votes) * 100), 2);

		$output = $yes_votes.' ('.$yes_percentage.'%)';
		echo $output;
	  }

	  function column_no($item) {
		global $wpdb;
		$yes_votes = $wpdb->get_var("SELECT `yes` FROM ".$wpdb->prefix."simple_poll WHERE id = ".$item['id']);
		$no_votes = $wpdb->get_var("SELECT `no` FROM ".$wpdb->prefix."simple_poll WHERE id = ".$item['id']);
		$total_votes = $yes_votes + $no_votes;

		if($total_votes == 0)
			$no_percentage = 0;
		else
			$no_percentage = round((($no_votes / $total_votes) * 100), 2);
		$output = $no_votes.' ('.$no_percentage.'%)';
		echo $output;

	  }

    function column_cb($item) {
      return sprintf( '<input type="checkbox" name="id[]" value="%s" />', $item['id'] );
    }

    function get_columns() {
      $columns = array(
        'cb' => '<input type="checkbox" />',
		'question'=> 'Question',
		'shortcode'=> 'Shortcode',
		'total_votes'=> 'Total Votes',
		'yes'=> 'Yes',
		'no'=> 'No',
        'action' => 'Action',
      );
      return $columns;
    }

    function get_sortable_columns() {
      $sortable_columns = array(
        'question' => array('question', true),
		'yes' => array('yes', true),
		'no' => array('no', true),
      );
      return $sortable_columns;
    }

    function get_bulk_actions() {
      $actions = array( 'delete' => 'Delete' );
      return $actions;
    }

    function process_bulk_action() {
      global $wpdb;
      $table_name = $wpdb->prefix . "simple_poll";
        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);
            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items() {
      global $wpdb,$current_user;

      $table_name = $wpdb->prefix . "simple_poll";
	  $per_page = 10;
      $columns = $this->get_columns();
      $hidden = array();
      $sortable = $this->get_sortable_columns();
      $this->_column_headers = array($columns, $hidden, $sortable);
      $this->process_bulk_action();
      $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

      $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
      $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
      $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

	  if(isset($_REQUEST['s']) && $_REQUEST['s']!='') {
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE `question` LIKE '%".$_REQUEST['s']."%' ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged * $per_page), ARRAY_A);
	  } else {
        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged * $per_page), ARRAY_A);
	  }

      $this->set_pagination_args(array(
        'total_items' => $total_items,
        'per_page' => $per_page,
        'total_pages' => ceil($total_items / $per_page)
      ));
    }
}
?>