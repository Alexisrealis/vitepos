<?php
/**
 * Plugin Name: Vitepos Pro
 * Plugin URI: http://appsbd.com
 * Description: It's a  Point of Sale plugin for Woocommerce , so fast and easy.
 * Version: 1.3.2
 * Author: appsbd
 * Author URI: http://www.appsbd.com
 * Text Domain: vitepos
 * wc require:3.2.0
 * @package Vitepos
 */




require_once 'vitepos/helper/plugin-helper.php';
require_once 'vitepos/core/class-vitepos.php';
use VitePos\Core\VitePos;




$vtpos = new VitePos( __FILE__ );


$vtpos->start_plugin();
