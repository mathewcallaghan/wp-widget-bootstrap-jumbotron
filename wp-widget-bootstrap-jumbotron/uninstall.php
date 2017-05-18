<?php

/**
 *
 * @link       https://github.com/mathewcallaghan/wp-widget-bootstrap-jumbotron/
 * @since      1.0.0
 *
 * @package    Bootstrap_Jumbotron_Widget
 */

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

delete_option('widget_bootstrap_jumbotron');
