<?php

/** Plugin system **/

$listeners = array();

/* Create an entry point for plugins */
function hook() {
    global $listeners;

    $num_args = func_num_args();
    $args = func_get_args();

    if($num_args < 2)
        trigger_error("Insufficient arguments", E_USER_ERROR);

    // Hook name should always be first argument
    $hook_name = array_shift($args);

    if(!isset($listeners[$hook_name]))
        return; // No plugins have registered this hook

    foreach($listeners[$hook_name] as $func) {
    	// echo('test');
    	// $args = func_get_args();
        // print_r( $args);
        $args = $func($args); 


    }

    if (is_array($args)) {
        return $args[0];
    } else {
        return $args;
    }
    
}

/* Attach a function to a hook */
function add_listener($hook, $function_name) {
    global $listeners;
    $listeners[$hook][] = $function_name;
}

add_listener('z_content', 'galleryContent');
add_listener('z_content', 'faq');

function galleryContent($args) {
    $content = $args[0];
    $galleryStart = '<div class="row"><div id="gallery" class="slider-pro">';
    $gallerySlides = '';
    $galleryTumbnails = '';
    $galleryEnd = '</div></div>';
    preg_match('/\[gallery:(.*?)\]/', $content, $matches);
    // dd($matches[1]);
    if (isset($matches[1])) {
        $galleries = \App\GalleryImage::where('gallery_id', $matches[1])->get();
        foreach ($galleries as $gallery) {
            $gallerySlides .= ' 
                                    <div class="sp-slide">
                                        <img class="sp-image" src="' . asset(config('app.folder_upload_images')) . '/'. $gallery->image . '" 
                                            data-src="' . asset(config('app.folder_upload_images')) . '/'.  $gallery->image . '" />

                                        <p class="sp-layer sp-black sp-padding"
                                            data-position="bottomLeft" data-vertical="0" data-width="100%"
                                            data-show-transition="up">
                                            ' . $gallery->description . '
                                        </p>
                                    </div>';
            $galleryTumbnails .= '
                                        <img class="sp-thumbnail" src="' . asset(config('app.folder_upload_images')) . '/'. $gallery->image . '"/>
                                ';
        }
        $allGallery = $galleryStart . '<div class="sp-slides">' . $gallerySlides . '</div><div class="sp-thumbnails">' . $galleryTumbnails. '</div>' . $galleryEnd;
        return str_replace($matches[0], $allGallery, $content);
    } else {
        return $content;
    }
    
}

function faq($args) {
    $content = $args;
    $script = '<script>$( function() { $( ".accordion" ).accordion();} );</script>';
    preg_match_all('/\[faq:(.*?)\]/', $content, $matches);

    if (isset($matches[1])) {

        foreach ($matches[1] as $key => $value) {
            $allFAQ = '<div class="accordion">';
            $faqs = \App\Post::GetByCategoryId([$value])->where('status', 1)->orderBy('created_at', 'desc')->get();
            
            foreach ($faqs as $faq) {
                $allFAQ .= '<h3>' .$faq->summary . '</h3><div><p>' . $faq->content . '</p></div>';
            }

            $allFAQ .= '</div>';
            $content = str_replace($matches[0][$key], $allFAQ, $content);
        }

        return $script . $content;
    } else {
        return $content;
    }
}
