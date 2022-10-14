

<?php

    global $wpdb;  

    $id = $book_id;
    $table = $wpdb->prefix .'books';
    $result = $wpdb->delete( $table, array( 'id' => $id ) );

    if($result){
        echo $msg = "<span class='text-success'>Book has been Deleted</span>";
        
    }else{
        echo $msg = "<span class='text-danger'>Book has been Not Deleted</span>";
        
    }

  

?>