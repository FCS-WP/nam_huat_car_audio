<?php
function shortcode_product_filter_layout()
{
    ob_start();

    // Lấy category được chọn (nếu có)
    $current_cat = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';

    // Lấy danh sách category
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'orderby' => 'name',
        'order' => 'ASC',
    ]);

    // Lấy products theo category nếu có filter
    $args = [
        'post_type' => 'product',
        'posts_per_page' => 6, // 2 hàng × 3 cột
        'paged' => max(1, get_query_var('paged') ? get_query_var('paged') : 1),
    ];

    if (!empty($current_cat)) {
        $args['tax_query'] = [[
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $current_cat,
        ]];
    }

    $products = new WP_Query($args);
?>
    <div class="product-layout-wrapper">

        <!-- LEFT: Category list -->
        <div class="category-sidebar">
            <?php foreach ($categories as $cat): ?>
                <?php if ($cat->slug === 'uncategorized') continue; ?>

                <a href="?cat=<?php echo $cat->slug; ?>"
                    class="<?php echo ($current_cat === $cat->slug) ? 'active' : ''; ?>">
                    <?php echo $cat->name; ?>
                    (<?php echo $cat->count; ?>)
                </a>

            <?php endforeach; ?>
        </div>

        <!-- RIGHT: Product grid -->
        <div>

            <div class="product-grid">
                <?php if ($products->have_posts()): ?>
                    <?php while ($products->have_posts()):
                        $products->the_post(); ?>
                        <div class="product-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('medium');
                                } else {
                                    echo wc_placeholder_img();
                                }
                                ?>
                                <h3><?php the_title(); ?></h3>
                            </a>
                            <span><?php echo wc_get_product()->get_price_html(); ?></span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <?php
                echo paginate_links([
                    'total' => $products->max_num_pages
                ]);
                ?>
            </div>

        </div>

    </div>

<?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('product_filter_layout', 'shortcode_product_filter_layout');
