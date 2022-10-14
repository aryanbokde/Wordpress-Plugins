<?php 

if ( !class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if ( !class_exists( 'User_List_Tables' ) ) {
    class User_List_Tables extends WP_List_Table {

        // private $post_array = array();
        /*-----------------------------------------------
        *   Define data set for WP_List_Table => data
        -------------------------------------------------*/
        
        function wp_list_table_data($orderby = '', $order = '', $search_terms = ''){

            global $wpdb;
            $tblname = $wpdb->prefix .'books';
            $post_array = array();

            if(!empty($search_terms)){

                $book_list = $wpdb->get_results(
                    $wpdb->prepare(
                        "SELECT * FROM $tblname WHERE name LIKE '%$search_terms%' && status = 1"
                    )
                );

            }else{
                if($orderby == "name" && $order == "desc"){           

                    $book_list = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM $tblname ORDER BY $tblname.name DESC"
                        )
                    );
    
                }else{   
                    $book_list = $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM $tblname"
                        )
                    );
                }
            }          

            
            if(count($book_list) > 0){
                foreach($book_list as $index => $data){
                    $post_array[] = array(
                        'id' => $data->id,
                        'name' => $data->name,
                        'amount' => $data->amount,
                        'publication' => $data->publication,
                        'description' => $data->description,
                        'email' => $data->email,
                        'status' => $data->status,
                        'created_at' => $data->created_at
                    );
                }
            }

            return $post_array;

        }


        /*-----------------------------------------------
        *   Prepare Method
        -------------------------------------------------*/
        public function prepare_items(){

            $orderby = isset($_GET['orderby']) ? trim($_GET['orderby']) : "";
            $order = isset($_GET['order']) ? trim($_GET['order']) : "";
            $search_terms = isset($_POST['s']) ? trim($_POST['s']) : "";
               
            $datas = $this->wp_list_table_data($orderby, $order, $search_terms);

            $per_page = get_option('posts_per_page');
            $current_page = $this->get_pagenum();
            $total_items = count($datas);

            $this->set_pagination_args(array(

                "total_items" => $total_items,
                "per_page" => $per_page

            ));

            $this->items = array_slice($datas, (($current_page-1) * $per_page), $per_page);
 
            $columns = $this->get_columns();

            $hidden = $this->get_hidden_columns();

            $sortable = $this->get_sortable_columns();
            
            $this->_column_headers = array($columns, $hidden, $sortable);

            
        }


        /*-----------------------------------------------
        *   Get Hidden Colunms
        -------------------------------------------------*/
        function get_hidden_columns(){

            //$hidden_data = array("mobile", "email");
            //return array("mobile", "email");

            $hidden_data = array("");

            return $hidden_data;

        }


        /*-----------------------------------------------
        *   get_sortable_columns
        -------------------------------------------------*/
        function get_sortable_columns(){

            return array(
                "name" => array("name", true),
                //"created_at" => array("created_at", false) //Order by ascending order
                //"email" => array("email", false) //Order by Descending order
            );

        }


        /*-----------------------------------------------
        *   Get Columns
        -------------------------------------------------*/
        public function get_columns(){

            $columns = array(

                "cb" => "<input type='checkbox'>",
                "id" => "ID",
                "name" => "Name",
                "amount" => "Amount",
                "publication" => "Publication",
                "description" => "Description",
                //"book_image" => "Image",
                "email" => "Email",
                "status" => "Status",
                "created_at" => "Created_at"

            );

            return $columns;

        }


        /*-----------------------------------------------
        *   Columns default
        -------------------------------------------------*/
        public function column_default($items, $column_name){
            
            switch($column_name){

                case 'id' :
                case 'name' :
                case 'amount' :
                case 'publication' :
                case 'description' :
               // case 'book_image' :
                case 'email' :
                case 'status' : 
                case 'created_at' :
                    return $items[$column_name];
                default:
                    return "No Value";

            }

        }

        /*-----------------------------------------------
        *   Search Option
        -------------------------------------------------*/
        public function column_name($item){
            
            $actions = array(
                'edit' => sprintf('<a href="?page=%s&action=%s&book_id=%s" >Edit</a>',$_REQUEST['page'],'book-edit',$item['id']),
                'delete' => sprintf('<a href="?page=%s&action=%s&book_id=%s" class="delete_book_id">Delete</a>',$_REQUEST['page'],'book-delete',$item['id']),
            );
            return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) );

        }

        /*-----------------------------------------------
        *   Get Bulk Opration 
        -------------------------------------------------*/
        public function get_bulk_actions(){
            
            $actions = array(
                'edit' => 'Edit',
                'delete' => 'Delete'
            );
            return $actions;

        }

        /*-----------------------------------------------
        *   Checkbox Function
        -------------------------------------------------*/
        public function column_cb($item){            
            return sprintf('<input type="checkbox" name="books[]" value="%s">', $item['id']);
        }



    } //class end

}//endif

function user_show_data_list_table(){

    $owt_table = new User_List_Tables();
    $owt_table->prepare_items();
    echo "<h4>Book Manage</h4>";
    echo "<form method='post' name='form_search_book' action='".$_SERVER['PHP_SELF']."?page=book_dashboard'>";
    $owt_table->search_box('Search book(s)', 'search_book_id');
    echo "</form>";
    $owt_table->display();

}

user_show_data_list_table();