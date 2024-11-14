<?php

/*
 *
 * @author              Jules Girardon
 *
 * @wordpress-plugin
 * Plugin Name:         Newsletters Plugin
 * Description:         Plugin pour ajouter un formulaire d'inscription à une newsletter.
 * Version:             1.0
 * Author:              Jules
 * Author URI:          https://github.com/JulesGirardon
 */

use Jules\NewslettersPlugin\NewslettersPlugin;

if (!defined('ABSPATH')) exit;

define('NEWSLETTERS_PLUGIN_DIR', plugin_dir_path(__FILE__));

require NEWSLETTERS_PLUGIN_DIR . 'vendor/autoload.php';

$plugin = new NewslettersPlugin(__FILE__);