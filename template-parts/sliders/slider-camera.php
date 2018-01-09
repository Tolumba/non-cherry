<?php
/**
*
*   Template part: Slider
*
*/
 ?>
<?php
    if( of_get_option('home_slider', false) ):
        $tax_query = array();
        $taxonomy = of_get_option('sl_posts_taxonomy', false);
        $term = of_get_option('sl_posts_term', false);
        $rule = array();
        if( $taxonomy && $term ){
            $rule['taxonomy'] = $taxonomy;
            $rule['field'] = 'slug';
            $rule['terms'] = explode( ', ', $term );
            $tax_query['relation'] = 'AND';
            $tax_query[] = $rule;
        }
        $args = array(
            'post_type' => of_get_option('sl_posts', 'post'),
            'posts_per_page' => (int)of_get_option('sl_posts_number', '-1'),
            'post_status' => 'publish',
            'tax_query' =>  $tax_query,
        );
        query_posts( $args );
        if( have_posts() ): ?>
        <script>
            jQuery(document).ready(function () {
                jQuery('#camera_wrap').camera({
                    loader: 'none',
                    minHeight: '280px',
                    height: '46.67%',
                    thumbnails: false,
                    thumbnails: false,
                    playPause: false,
                    hover: false,
                    navigationHover: false,
                    autoAdvance: <?php echo of_get_option('sl_slideshow', true); ?>,
                    time: <?php echo of_get_option('sl_pausetime', 7000); ?>,
                    transPeriod: <?php echo of_get_option('sl_animation_speed', 1500); ?>,
                    pagination: <?php echo of_get_option('sl_control_nav', true); ?>,
                    navigation: <?php echo of_get_option('sl_dir_nav', false); ?>,
                    fx: '<?php echo of_get_option('sl_effect', 'random'); ?>',
                });
            });
        </script>
        <div class="slider-wrapper <?php slider_wrapper_classes(); ?>">
            <div id="camera_wrap">
        		<?php while ( have_posts() ): ?>
                    <?php the_post();?>
            		<?php $caption = apply_filters( 'the_content', strip_shortcodes( get_the_content() ) ); ?>
                    <?php $sl_image_obj = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full'); ?>
            		<?php $sl_image_url = is_array($sl_image_obj)? $sl_image_obj[0]: CHILD_URL.'/images/blank.gif'; ?>
                    <div data-src="<?php echo $sl_image_url; ?>">
                        <div class="camera_caption fadeIn">
                            <div><?php echo $caption; ?></div>
                        </div>
                    </div>
        		<?php endwhile; ?>
            </div>
            <div class="clearfix"></div>
        </div><?php
        else: ?>
        <div class="no-slides"></div><?php
        endif;
        wp_reset_query();
    endif;
?>
