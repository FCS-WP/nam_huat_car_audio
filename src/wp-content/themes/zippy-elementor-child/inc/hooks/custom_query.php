<?php
add_action('elementor/query/product-loop', function ($query) {
    $query->set('post_type', 'product');
});

add_action('elementor/query/post-loop', function ($query) {
    $query->set('post_type', 'post');
});
