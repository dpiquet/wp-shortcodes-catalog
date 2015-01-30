<?php


// print count latest articles
function DYS_get_latest_articles($atts) {

    extract(shortcode_atts(array(
              'count' => 5,
    ), $atts));

        $r = new WP_Query( Array(
                    'post_type' => 'post',
                    'posts_per_page' => $count
            )   
        );  

        $out = ''; 

        if ($r->have_posts() ) { 
            while ($r->have_posts()) {
                $r->the_post();

                $out .= '<h2>' . get_the_title() . '</h2>';
                $out .= '<p>' . get_the_excerpt() . '</p>';
                $out .= '<a href="'. get_permalink() . '" class="button"> Read more</a>';
            }
        }

        return $out;
}           

add_shortcode( 'DYS_LATEST_ARTICLES', 'DYS_get_latest_articles' );

?>
