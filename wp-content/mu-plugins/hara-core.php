<?php
/**
 * Plugin Name: HaRa Core
 * Description: Site functionality for HaRa Foods Ltd — business settings, WhatsApp click-to-chat, testimonials, contact & wholesale enquiry forms, shortcodes and structured data. Lives in mu-plugins so it can't be deactivated by accident and keeps working if the theme changes.
 * Version: 1.0.0
 * Author: Mos EdTech
 */

defined( 'ABSPATH' ) || exit;

define( 'HARA_CORE_DIR', __DIR__ . '/hara-core/' );

require HARA_CORE_DIR . 'settings.php';
require HARA_CORE_DIR . 'post-types.php';
require HARA_CORE_DIR . 'enquiries.php';
require HARA_CORE_DIR . 'shortcodes.php';
require HARA_CORE_DIR . 'whatsapp.php';
require HARA_CORE_DIR . 'woocommerce.php';
require HARA_CORE_DIR . 'seo.php';
