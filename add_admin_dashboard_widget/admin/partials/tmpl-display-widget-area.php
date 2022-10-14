<?php 

$my_course_query = new WP_Query(array('post_type'=>'shop_order','post_status'=>'any', 'posts_per_page' => get_option('posts_per_page')));
$orders = $my_course_query->posts;
?>

<table class="widefat striped fixed">
    <thead>
        <tr>
            <th>#Orders</th>
            <th>Order Status</th>
            <th>Email</th>
            <th>Mobile</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $orders as $order ) { 

            $order = wc_get_order( $order->ID );
            $data  = $order->get_data();
            
        ?>
        <tr>
            <td>#<?php echo $data['id'] . ' ' . $data['billing']['first_name'] . ' ' . $data['billing']['last_name']; ?></td>
            <td><?php echo $data['status']; ?></td>
            <td><?php echo $data['billing']['email']; ?></td>
            <td><?php echo $data['billing']['phone']; ?> </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
