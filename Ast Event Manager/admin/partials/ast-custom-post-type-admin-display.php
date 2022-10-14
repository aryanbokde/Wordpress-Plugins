<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://arsenaltech.com/
 * @since      1.0.0
 *
 * @package    Ast_Custom_Post_Type
 * @subpackage Ast_Custom_Post_Type/admin/partials
 */

?>
<?php

class Ast_Event_Create_Single_page{

    public function ast_create_single_event_file(){

        $parent_theme_path = get_template_directory().'/single-event.php';
        $child_theme_path = get_stylesheet_directory().'/single-event.php';

        if (file_exists($parent_theme_path) || file_exists($child_theme_path)) {
          // wp_delete_file( $parent_theme_path ); //delete file here.
          // wp_delete_file( $child_theme_path ); //delete file here.
          echo "File already exists we are deleting...";
        } else {
          $oldfile = AST_CUSTOM_POST_TYPE_DIR_URL."single-event.php";
          $newfile = get_template_directory_uri()."/single-event.php";
          $datafile = $this->file_checker($oldfile);
          $blankfile = $this->file_checker($newfile);
                  
          
          if(!copy($datafile,$blankfile)){
            echo "failed to copy $datafile";  
            //$this->showing_error();
          }
          else{
            echo "copied $datafile into $blankfile\n"; 
            // $this->showing_error();
          }

        }
    }
    public function file_checker($file){
        //http://localhost/wordpress/wp-content/themes/THEMEName
        $location = $file;// you can edit this <=
        $location = str_replace("http://","",$location);
        $location = str_replace("https://","",$location);
        $location = str_replace($_SERVER['HTTP_HOST'],"",$location);
        $location = $_SERVER['DOCUMENT_ROOT'].$location;
        return $filename = $location; 
      
    }
}

$data = new Ast_Event_Create_Single_page();
$data->ast_create_single_event_file();


