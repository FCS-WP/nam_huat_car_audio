<?php

function register_services_cpt()
{
    $labels = [
        'name'               => 'Services',
        'singular_name'      => 'Service',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Service',
        'edit_item'          => 'Edit Service',
        'new_item'           => 'New Service',
        'view_item'          => 'View Service',
        'search_items'       => 'Search Services',
        'not_found'          => 'No services found',
        'menu_name'          => 'Services',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'services'],
        'menu_icon'          => 'dashicons-hammer',
        'supports'           => [
            'title',
            'editor',
            'thumbnail',
            'excerpt'
        ],
        'show_in_rest'       => true,
    ];

    register_post_type('services', $args);
}
add_action('init', 'register_services_cpt');
