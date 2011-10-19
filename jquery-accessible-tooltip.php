<?php
/*
Plugin Name: JQuery Accessible Tooltip
Plugin URI: http://wordpress.org/extend/plugins/jquery-accessible-tooltip/
Description: WAI-ARIA Enabled Tooltip Plugin for Wordpress
Author: Theofanis Oikonomou, Kontotasiou Dionysia
Version: 2.0
Author URI: http://www.iti.gr/iti/people/ThOikon.html, http://www.iti.gr/iti/people/Dionisia_Kontotasiou.html
*/
// include_once 'getRecentPosts.php';
// include_once 'getRecentComments.php';
// include_once 'getArchives.php';

add_action("plugins_loaded", "JQueryAccessibleTooltip_init");
function JQueryAccessibleTooltip_init() {
    register_sidebar_widget(__('JQuery Accessible Tooltip'), 'widget_JQueryAccessibleTooltip');
    register_widget_control(   'JQuery Accessible Tooltip', 'JQueryAccessibleTooltip_control', 200, 200 );
    if ( !is_admin() && is_active_widget('widget_JQueryAccessibleTooltip') ) {
        wp_register_style('jquery.ui.all', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/themes/base/jquery.ui.all.css'));
        wp_enqueue_style('jquery.ui.all');

        wp_deregister_script('jquery');

        // add your own script
        wp_register_script('jquery-1.4.2', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/jquery-1.4.2.js'));
        wp_enqueue_script('jquery-1.4.2');

        wp_register_script('jquery.ui.core.js', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/ui/jquery.ui.core.js'));
        wp_enqueue_script('jquery.ui.core.js');

        wp_register_script('jquery.ui.widget', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/ui/jquery.ui.widget.js'));
        wp_enqueue_script('jquery.ui.widget');

        wp_register_script('jquery.ui.tabs', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/ui/jquery.ui.tabs.js'));
        wp_enqueue_script('jquery.ui.tabs');

        wp_register_script('jquery.ui.position', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/ui/jquery.ui.position.js'));
        wp_enqueue_script('jquery.ui.position');

        wp_register_script('jquery.ui.tooltip', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/ui/jquery.ui.tooltip.js'));
        wp_enqueue_script('jquery.ui.tooltip');

        wp_register_style('demos', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/jquery-ui/demos.css'));
        wp_enqueue_style('demos');

        wp_register_style('demo', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/demo.css'));
        wp_enqueue_style('demo');

        wp_register_script('JQueryAccessibleTooltip', ( get_bloginfo('wpurl') . '/wp-content/plugins/jquery-accessible-tooltip/lib/JQueryAccessibleTooltip.js'));
        wp_enqueue_script('JQueryAccessibleTooltip');
    }
}

function widget_JQueryAccessibleTooltip($args) {
    extract($args);

    $options = get_option("widget_JQueryAccessibleTooltip");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'JQuery Accessible Tooltip',
            'tooltip' => 'Type what to search for',
            'search' => 'Search'
        );
    }

    echo $before_widget;
    echo $before_title;
    echo $options['title'];
    echo $after_title;

    //Our Widget Content
    JQueryAccessibleTooltipContent();
    echo $after_widget;
}

function JQueryAccessibleTooltipContent() {
    // $recentPosts = get_recent_posts();
    // $recentComments = get_recent_comments();
    // $archives = get_my_archives();

    $options = get_option("widget_JQueryAccessibleTooltip");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'JQuery Accessible Tooltip',
            'tooltip' => 'Type what to search for',
            'search' => 'Search'
        );
    }

    echo '<!--<div class="demo" role="application">-->
	<form action="" id="searchform" method="get" role="search">
		<div class="widget_search" id="searchformJQueryAccessibleTooltip">
			<label for="s" class="screen-reader-text">Search for:</label>
			<input type="text" id="s" name="s" value="" title="' . $options['tooltip'] . '">
			<input type="submit" value="Search" id="searchsubmit" title="' . $options['search'] . '">
		</div>
	</form>
<!--</div>-->';
}

function JQueryAccessibleTooltip_control() {
    $options = get_option("widget_JQueryAccessibleTooltip");
    if (!is_array( $options )) {
        $options = array(
            'title' => 'JQuery Accessible Tooltip',
            'tooltip' => 'Type what to search for',
            'search' => 'Search'
        );
    }

    if ($_POST['JQueryAccessibleTooltip-SubmitTitle']) {
        $options['title'] = htmlspecialchars($_POST['JQueryAccessibleTooltip-WidgetTitle']);
        update_option("widget_JQueryAccessibleTooltip", $options);
    }
    if ($_POST['JQueryAccessibleTooltip-SubmitTooltip']) {
        $options['tooltip'] = htmlspecialchars($_POST['JQueryAccessibleTooltip-WidgetTooltip']);
        update_option("widget_JQueryAccessibleTooltip", $options);
    }
    if ($_POST['JQueryAccessibleTooltip-SubmitSearch']) {
        $options['search'] = htmlspecialchars($_POST['JQueryAccessibleTooltip-WidgetSearch']);
        update_option("widget_JQueryAccessibleTooltip", $options);
    }
    ?>
    <p>
        <label for="JQueryAccessibleTooltip-WidgetTitle">Widget Title: </label>
        <input type="text" id="JQueryAccessibleTooltip-WidgetTitle" name="JQueryAccessibleTooltip-WidgetTitle" value="<?php echo $options['title'];?>" />
        <input type="hidden" id="JQueryAccessibleTooltip-SubmitTitle" name="JQueryAccessibleTooltip-SubmitTitle" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTooltip-WidgetTooltip">Translation for "Type what to search for": </label>
        <input type="text" id="JQueryAccessibleTooltip-WidgetTooltip" name="JQueryAccessibleTooltip-WidgetTooltip" value="<?php echo $options['tooltip'];?>" />
        <input type="hidden" id="JQueryAccessibleTooltip-SubmitTooltip" name="JQueryAccessibleTooltip-SubmitTooltip" value="1" />
    </p>
    <p>
        <label for="JQueryAccessibleTooltip-WidgetSearch">Translation for "Search": </label>
        <input type="text" id="JQueryAccessibleTooltip-WidgetSearch" name="JQueryAccessibleTooltip-WidgetSearch" value="<?php echo $options['search'];?>" />
        <input type="hidden" id="JQueryAccessibleTooltip-SubmitSearch" name="JQueryAccessibleTooltip-SubmitSearch" value="1" />
    </p>
    
    <?php
}

?>
