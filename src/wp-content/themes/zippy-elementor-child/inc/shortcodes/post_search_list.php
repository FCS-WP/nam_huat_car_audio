<?php
function shortcode_post_search_list()
{
    $excluded_cat = get_category_by_slug('services');
    $excluded_cat_id = $excluded_cat ? $excluded_cat->term_id : 0;

    $all_posts = get_posts([
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order'     => 'DESC',
        'category__not_in' => [$excluded_cat_id],
    ]);

    if (!empty($all_posts)) {
        array_shift($all_posts);
    }

    $posts_json = array_map(function ($p) {
        return [
            'title' => get_the_title($p),
            'link' => get_permalink($p),
            'date' => get_the_date('d M Y', $p),
            'thumbnail' => get_the_post_thumbnail_url($p, 'medium')
                ?: 'https://via.placeholder.com/150?text=No+Image'
        ];
    }, $all_posts);

    ob_start();
?>
    <div id="post-search-component"
        data-posts='<?php echo json_encode($posts_json); ?>'
        style="max-width:500px;">

        <input id="post-search-input"
            type="text"
            placeholder="Search posts..."
            style="width:100%;padding:12px;border-radius:8px;border:1px solid #ddd;margin-bottom:15px;" />

        <div id="post-list"></div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('post_search_list', 'shortcode_post_search_list');
