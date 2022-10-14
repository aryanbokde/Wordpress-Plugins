<h1>Book Events list</h1>
<?php

// Load the parent class if it doesn't exist.
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}


class Ast_Event_Order_Record extends WP_List_Table
{

    /*
    *  This is first function of WP_LIST_TABLE to 
    *  prepare all relation function.
    */

    public function prepare_items()
    {

        $orderby = isset($_GET['orderby']) ? trim($_GET['orderby']) : "";
        $order = isset($_GET['order']) ? trim($_GET['order']) : "";
        
        $search_terms = isset($_POST['s']) ? trim($_POST['s']) : "";

        $all_data = $this->wp_list_table_data($orderby, $order, $search_terms);

        $per_page = get_option('posts_per_page');
        $current_page = $this->get_pagenum();
        $total_items = count($all_data);

        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                'per_page' => $per_page
            )
        );

        // $this->items = $all_data;
        $this->items = array_slice($all_data, (($current_page - 1) * $per_page), $per_page);

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
    }


    /*
    *  Get all database table DATA to display in WP_LIST_TABLE. 
    */

    public function wp_list_table_data($orderby = '', $order = '', $search_terms = '')
    {

        global $wpdb;

        $table_list = get_option("ast_table_name");
        foreach ($table_list as $key => $value) {
            if ($key == 'book_event_table') {
                $tablename = $value;
            }
        }

        if (!empty($search_terms)) {
            $results = $wpdb->get_results(
                "SELECT * from $tablename WHERE name Like '%{$search_terms}%' OR mobile Like '%{$search_terms}%' OR email Like '%{$search_terms}%'"
            );
        }else{
            if ($orderby == "name" && $order =="asc") {
                $results = $wpdb->get_results("SELECT * FROM $tablename ORDER BY name ASC");

            }elseif($orderby == "name" && $order =="desc"){
                $results = $wpdb->get_results("SELECT * FROM $tablename ORDER BY name DESC");
            }else{
                $results = $wpdb->get_results("SELECT * FROM $tablename ORDER BY ID DESC");
            }
        }
        
        $data = [];

        if (is_array($results) || is_object($results)) {

            foreach ($results as $result) {
                $bookid = $result->ID;
                $name = $result->name;
                $mobile = $result->mobile;
                $email = $result->email;
                $event_id = $result->event_id;
                $uid = $result->uid;        
                $created_at = $result->created_at;

                if (!empty($event_id)) {
                    $event_data = get_post($event_id);
                    $event_name = $event_data->post_title;
                }else{
                    $event_name = $result->event_id;
                }

                if (!empty($uid)) {
                    $uid = $user = get_userdata( $uid );                    
                    $usernick = $uid->user_nicename;                    
                }else{
                    $usernick = "New User";   
                }

                $data[] = array(
                    'bookid' => $bookid,
                    'name' => $name,
                    'mobile' => $mobile,
                    'email' => $email,
                    'event_id' => $event_name,
                    'uid' => $usernick,
                    'created_at' => $created_at,
                );
            }
        }
        return $data;
    }


    /*
    *  How many column name do want to show add database column name 
    *  And display name 
    */

    public function get_columns()
    {
        $columns = array(
            "bookid" => "ID",
            'name' => "Name",
            'mobile' => "Mobile",
            'email' => "Email",
            'event_id' => "Event",
            'uid' => "User",
            'created_at' => "Created at",
            "hidden" => "Hidden",
            "action" => "Action"
        );
        return $columns;
    }


   /*
    *  Get the database value and pass in this function  
    *  to show on wp_list table.
    */
    
    public function column_default($item, $column_name)
    {

        switch ($column_name) {           
      
            case 'bookid':
            case 'name':
            case 'mobile':
            case 'email':
            case 'event_id':
            case 'uid':
            case 'created_at':
            case 'hidden':
                return $item[$column_name];
            case 'action':
                // return '<a href="?page=' . $_GET['page'] . '&action=owt-edit&post_id=' . $item['bookid'] . '">Edit</a> | <a href="?page=' . $_GET['page'] . '&action=owt-delete&post_id=' . $item['bookid'] . '">Delete</a>';
                return '<a href="?page=' . $_GET['page'] . '&action=ast-view-event&book_id=' . $item['bookid'] . '">View</a>';
            default:
                return "No data found";
        }
    }


    /*
    *  Which column do you want hide from wp_list_table
    *  Just pass the database table column name or column name in array.
    */

    public function get_hidden_columns()
    {
        return array("hidden");
        //return array("hidden", "uid");
    }


    /*
    *  Which column do you want shortable Like on click column ASC OR DESC order
    *  Just pass the database table column name in array.
    */

    public function get_sortable_columns()
    {
        return array(
            "name" => array('name', false)
            // "id" => array('id', false)
        );
    }


    /*
    *  Which column do you want add edit delete button for example 
    *  i want to title write function Name LIKE 
    *  column_{column-name}(column_title)
    *  currently i want add edit delete button to name column.
    */

    public function column_name($item)
    {

        // $action = array(
        //     "edit" => printf('<a href="?page=%s&action=%s&post_id=%s">Edit</a>', $_GET['page'], 'owt-edit', $item['bookid']),
        //     "delete" => printf('<a href="?page=%s&action=%s&post_id=%s">Delete</a>', $_GET['page'], 'owt-delete', $item['bookid']),
        // );

        // return printf('%1$s %2$s', $item['name'], $this->row_actions($action));

        // $action = array(
        //     "edit" => "<a href='?page=" . $_GET['page'] . "&action=owt-edit&post_id=" . $item['bookid'] . "'>Edit</a>",
        //     "delete" => "<a href='?page=" . $_GET['page'] . "&action=owt-delete&post_id=" . $item['bookid'] . "'>Delete</a>"
        // );

        $action = array(
            "view" => "<a href='?page=" . $_GET['page'] . "&action=ast-view-event&book_id=" . $item['bookid'] . "'>View</a>"
        );
        return sprintf('%1$s %2$s', $item['name'], $this->row_actions($action));
    }


}

function Display_all_Event_Order_Data()
{

    $ast_table = new Ast_Event_Order_Record();

    $ast_table->prepare_items();
    echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?page=event-booked">
        <input type="hidden" name="page" value="booking_data" />';
        $ast_table->search_box('search', 'search_id'); 
    echo '</form>';
    $ast_table->row_actions_title();
    $ast_table->display();
}

Display_all_Event_Order_Data();


        
