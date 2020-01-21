<?php
/*  ----------------------------------------------------------------------------
    Newspaper V10.1+ Child theme - Please do not use this child theme with older versions of Newspaper Theme

    What can be overwritten via the child theme:
     - everything from /parts folder
     - all the loops (loop.php loop-single-1.php) etc
	 - please read the child theme documentation: http://forum.tagdiv.com/the-child-theme-support-tutorial/

 */

/*  ----------------------------------------------------------------------------
    add the parent style + style.css from this folder
 */
add_action('wp_enqueue_scripts', 'newspaper_child_enqueue_styles', 11);
add_filter('template_include', 'newspaper_child_override_templates', 20);

function newspaper_child_enqueue_styles()
{
    wp_enqueue_style('td-theme', get_template_directory_uri() . '/style.css', '', TD_THEME_VERSION, 'all');
    wp_enqueue_style('td-theme-child', get_stylesheet_directory_uri() . '/style.css', ['td-theme'],
        TD_THEME_VERSION . 'c', 'all');

}

function newspaper_child_authors($layout)
{
    /**
     * This is the action that echoes the author box in the screen.
     * The action pp_multiple_authors_show_author_box accepts 4 params, but for this example we will be using only 2:
     *
     * $showTitle = false
     * $layout = 'inline'
     *
     * The $layout param can contain the slug of any custom layout you have created on Multiple Authors 3.0.0 and above.
     */
    do_action('pp_multiple_authors_show_author_box', false, $layout, false, true);
}

/**
 * @param $template
 *
 * @return mixed
 */
function newspaper_child_override_templates($template)
{
    $relativePath = str_replace(WP_CONTENT_DIR, '', $template);

    $templateMap = [
        '/plugins/td-composer/legacy/Newspaper/single.php' => '/td-composer/legacy/Newspaper/single.php',
        '/plugins/td-standard-pack/Newspaper/loop.php' => '/td-standard-pack/Newspaper/loop.php',
    ];

    if (isset($templateMap[$relativePath])) {
        $overridePath = __DIR__ . $templateMap[$relativePath];

        if (file_exists($overridePath)) {
            $template = $overridePath;
        }
    }

    return $template;
}
