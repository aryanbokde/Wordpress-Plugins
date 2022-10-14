<?php 

if ( !class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
if ( !class_exists( 'User_List_Tables' ) ) {
    class User_List_Tables extends WP_List_Table {

        
        /*-----------------------------------------------
        *   Define data set for WP_List_Table => data
        -------------------------------------------------*/
        
        var $data = array(
            array("id" => 1, "name" => "Rakesh", "email" => "demo@gmail.com"),
            array("id" => 2, "name" => "Vinow", "email" => "Vinow@gmail.com"),
            array("id" => 3, "name" => "Rajesh", "email" => "Rajesh@gmail.com"),
            array("id" => 4, "name" => "prashant", "email" => "prashant@gmail.com"),
            array("id" => 5, "name" => "Roshan", "email" => "Roshan@gmail.com")
        );




        /*-----------------------------------------------
        *   Prepare Method
        -------------------------------------------------*/
        public function prepare_items(){
               
            $this->items = $this->data;

            $columns = $this->get_columns();

            $this->_column_headers = array($columns);

            
        }



         /*-----------------------------------------------
        *   Get Columns
        -------------------------------------------------*/
        public function get_columns(){

            $columns = array(
                "id" => "ID",
                "name" => "Name",
                "email" => "Email"
            );

            return $columns;

        }



         /*-----------------------------------------------
        *   Columns default
        -------------------------------------------------*/
        public function columns_default($item, $column_name){
            
            switch($column_name){
                case 'id' :
                case 'name' :
                case 'email' :
                    return $item[$column_name];
                default:
                    return "No Value";
            }

        }



        /*-----------------------------------------------
        *   Old Function
        -------------------------------------------------*/

        // private array $hd_columns;
        // private array $hd_data;
        // private array $hd_hidden;
        // private array $hd_sortable;
        // private array $hd_column_names;

        // public function __construct() {
        //     //parent::__construct();
        //     echo "hello ";
        // }

        // public function set_column_names(array $column_names) {
        //     $this->hd_column_names = $column_names;
        // }

        // public function set_columns(array $columns) {
        //     $this->hd_columns = $columns;
        // }

        // public function set_data(array $data) {
        //     $this->hd_data = $data;
        // }

        // public function set_hidden(array $hidden) {
        //     $this->hd_hidden = $hidden;
        // }

        // public function set_sortable(array $sortable) {
        //     $this->hd_sortable = $sortable;
        // }

        // public function prepare_items() {
        //     $this->_column_headers = array($this->hd_columns, $this->hd_hidden, $this->hd_sortable);
        //     $this->items = $this->hd_data;
        // }

        // public function column_default( $item, $column_name ): mixed {
        //     if (in_array($column_name, $this->hd_column_names)) {
        //         return $item[ $column_name ];
        //     }
        //     return print_r($item, true);
        // }
    }
}

function user_show_data_list_table(){
    $owt_table = new User_List_Tables();
    $owt_table->prepare_items();
    $owt_table->display();
}

user_show_data_list_table();