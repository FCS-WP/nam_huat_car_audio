<?php
function shortcode_custom_post_list()
{
    $excluded_cat = get_category_by_slug('services');
    $excluded_cat_id = $excluded_cat ? $excluded_cat->term_id : 0;
    $posts = get_posts([
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'DESC',
        'offset' => 1,
        'category__not_in' => [$excluded_cat_id],
    ]);

    ob_start();
?>
    <div class="custom-post-list">

        <?php foreach ($posts as $p): ?>
            <div class="custom-post-item">

                <!-- Thumbnail -->
                <img class="post-thumb"
                    src="<?php echo get_the_post_thumbnail_url($p->ID, 'medium') ?: 'https://via.placeholder.com/300x200?text=Image'; ?>" />

                <div>

                    <!-- Author + Date -->
                    <div class="post-meta">
                        <span>
                            By <?php echo get_the_author_meta('display_name', $p->post_author); ?> ,
                            <?php echo get_the_date('d M Y', $p->ID); ?>
                        </span>
                    </div>

                    <!-- Title -->
                    <div class="post-title"><?php echo get_the_title($p->ID); ?></div>

                    <!-- Excerpt -->
                    <div class="post-excerpt">
                        <?php echo wp_trim_words(get_the_excerpt($p->ID), 20); ?>
                    </div>

                    <!-- Button -->
                    <a class="post-readmore" href="<?php echo get_permalink($p->ID); ?>">
                        READ MORE
                    </a>

                </div>
            </div>
        <?php endforeach; ?>

    </div>

<?php
    return ob_get_clean();
}
add_shortcode('custom_post_list', 'shortcode_custom_post_list');
