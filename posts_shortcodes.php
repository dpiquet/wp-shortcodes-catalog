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

function DYS_bss_latest($atts) {

    extract(shortcode_atts(array(
        'cats'       => 'undef',
        'cat_name'   => 1,
        'thumbnails' => 1
    ), $atts));


    if($cats == 'undef') {
        return 'You must specify categories with cat="id1,id2" in this shortcode !';
    }

    $categories = explode(',', $cats);

    $out = '<div id="dys-bss-latest">';

    foreach ($categories as $cat) {

        $catObj = get_category($cat);
        if (! $catObj) {
            continue;
        }

        $r = new WP_Query( Array(
                'post_type' => 'post',
                'ignore_sticky_posts' => 1,
                'posts_per_page' => 3,
                'cat' => $cat
            )
        );

        $out .= '<div class="dys-cat-latest">';
        if ($cat_name == 1) {
            $out .= '<h2>'.$catObj->name.'</h2>';
        }
        
        if($r->have_posts()) {
            while($r->have_posts()) {
                $r->the_post();

                $out .= '<h4>' . get_the_title() . '</h4>';

                if($thumbnails == 1) {
                    $out .= get_the_post_thumbnail(null, Array(50,50));
                }

                $out .= '<p>' . get_the_excerpt() . '</p>';
                $out .= '<a href="'. get_permalink() . '" class="button"> Read more</a>';
            }
        }
        
        //close dys_bss_$cat div
        $out .= '</div>';

        wp_reset_postdata();
    } 

    // close dys_bss_latest div
    $out .= '</div>';

    return $out;

}

add_shortcode( 'DYS_BSS_LATEST', 'DYS_bss_latest' );
?>
