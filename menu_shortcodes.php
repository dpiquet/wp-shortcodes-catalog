<?php

/*

   Ajoute la liste des liens des pages soeurs ou enfants sous forme 1 2 3 ... X

*/

function dys_gallery_menu() {
    global $post;

    $output = '';
    $a = 1;

    //if child page, list siblings
    if ($post->post_parent) {

        $postParent = ( $post->post_parent ? $post->post_parent : $post->ID );

        $output .= ' <a href="'.get_page_link($post->post_parent).'">'.$a.'</a> ';
        $a++;

        $siblings = get_pages( 'title_li=&child_of='.$postParent.'&depth=1&sort_column=post_date' );

    }
    else {
        $siblings = get_pages('title_li=&child_of='.$post->ID.'&depth=1');
        $output .= ' <a class="dysactive" href="'.get_page_link($post->id).'"> '.$a.'</a> ';
        $a++;
    }

    foreach($siblings as $sibling) {
        $link = get_page_link($sibling->ID);
        $output .= ' <a ';

        if($sibling->ID == $post->ID) { $output .= 'class="dysactive"'; }

        $output .= ' href='.$link.'>'.$a.'</a> ';

        $a++;
    }

    return $output;
}

add_shortcode('DYS_GALLERY_MENU', 'dys_gallery_menu');

?>
