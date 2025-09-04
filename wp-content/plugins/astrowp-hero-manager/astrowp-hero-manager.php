<?php
/**
 * Plugin Name: AstroWP Hero Manager
 * Plugin URI: https://github.com/rileysklar/AstroWP
 * Description: Manages hero section content for AstroWP headless WordPress sites with WPGraphQL integration
 * Version: 1.0.0
 * Author: Riley Sklar
 * License: GPL v2 or later
 * Text Domain: astrowp-hero-manager
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Check if WPGraphQL is active
function astrowp_hero_manager_check_dependencies() {
    if (!class_exists('WPGraphQL')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>';
            echo '<strong>AstroWP Hero Manager</strong> requires <strong>WPGraphQL</strong> to be installed and activated. ';
            echo '<a href="' . admin_url('plugin-install.php?s=WPGraphQL&tab=search&type=term') . '">Install WPGraphQL</a>';
            echo '</p></div>';
        });
        return false;
    }
    return true;
}

// Initialize plugin
function astrowp_hero_manager_init() {
    if (!astrowp_hero_manager_check_dependencies()) {
        return;
    }
    
    // Load plugin functionality
    astrowp_hero_manager_load_customizer();
    astrowp_hero_manager_load_graphql();
}
add_action('init', 'astrowp_hero_manager_init');

/**
 * WordPress Customizer Integration
 */
function astrowp_hero_manager_load_customizer() {
    add_action('customize_register', 'astrowp_hero_manager_customize_register');
}

function astrowp_hero_manager_customize_register($wp_customize) {
    // Hero Section
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'astrowp-hero-manager'),
        'priority' => 30,
        'description' => __('Configure the hero section content for your Astro frontend.', 'astrowp-hero-manager'),
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default' => 'Astro WordPress',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_title', array(
        'label' => __('Hero Title', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'text',
        'description' => __('Main headline displayed in the hero section.', 'astrowp-hero-manager'),
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Starter',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label' => __('Hero Subtitle', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'text',
        'description' => __('Secondary headline displayed below the main title.', 'astrowp-hero-manager'),
    ));

    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default' => 'Boilerplate for Astro and WordPress using WPGraphQL, shadcn/ui, and Tailwind CSS.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_description', array(
        'label' => __('Hero Description', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'textarea',
        'description' => __('Main description text displayed in the hero section.', 'astrowp-hero-manager'),
    ));

    // Primary Button Text
    $wp_customize->add_setting('hero_primary_button_text', array(
        'default' => 'Explore Events',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_primary_button_text', array(
        'label' => __('Primary Button Text', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'text',
        'description' => __('Text displayed on the primary call-to-action button.', 'astrowp-hero-manager'),
    ));

    // Primary Button Link
    $wp_customize->add_setting('hero_primary_button_link', array(
        'default' => '/events',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_primary_button_link', array(
        'label' => __('Primary Button Link', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'url',
        'description' => __('URL for the primary button (can be external or internal).', 'astrowp-hero-manager'),
    ));

    // Secondary Button Text
    $wp_customize->add_setting('hero_secondary_button_text', array(
        'default' => 'Read Posts',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_secondary_button_text', array(
        'label' => __('Secondary Button Text', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'text',
        'description' => __('Text displayed on the secondary call-to-action button.', 'astrowp-hero-manager'),
    ));

    // Secondary Button Link
    $wp_customize->add_setting('hero_secondary_button_link', array(
        'default' => '/posts',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_secondary_button_link', array(
        'label' => __('Secondary Button Link', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'url',
        'description' => __('URL for the secondary button (can be external or internal).', 'astrowp-hero-manager'),
    ));

    // Show Social Proof
    $wp_customize->add_setting('hero_show_social_proof', array(
        'default' => '1',
        'sanitize_callback' => 'astrowp_hero_manager_sanitize_checkbox',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_show_social_proof', array(
        'label' => __('Show Social Proof', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'checkbox',
        'description' => __('Display social proof text below the buttons.', 'astrowp-hero-manager'),
    ));

    // Social Proof Text
    $wp_customize->add_setting('hero_social_proof_text', array(
        'default' => 'Trusted by developers worldwide',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('hero_social_proof_text', array(
        'label' => __('Social Proof Text', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'type' => 'text',
        'description' => __('Text displayed as social proof (e.g., testimonials, user count).', 'astrowp-hero-manager'),
    ));
}

/**
 * WPGraphQL Integration
 */
function astrowp_hero_manager_load_graphql() {
    add_action('graphql_register_types', 'astrowp_hero_manager_register_graphql_types');
}

function astrowp_hero_manager_register_graphql_types() {
    // Register Hero Settings object type
    register_graphql_object_type('HeroSettings', [
        'description' => __('Hero section settings from WordPress Customizer', 'astrowp-hero-manager'),
        'fields' => [
            'title' => [
                'type' => 'String',
                'description' => __('Hero title', 'astrowp-hero-manager'),
            ],
            'subtitle' => [
                'type' => 'String',
                'description' => __('Hero subtitle', 'astrowp-hero-manager'),
            ],
            'description' => [
                'type' => 'String',
                'description' => __('Hero description', 'astrowp-hero-manager'),
            ],
            'primaryButtonText' => [
                'type' => 'String',
                'description' => __('Primary button text', 'astrowp-hero-manager'),
            ],
            'primaryButtonLink' => [
                'type' => 'String',
                'description' => __('Primary button link', 'astrowp-hero-manager'),
            ],
            'secondaryButtonText' => [
                'type' => 'String',
                'description' => __('Secondary button text', 'astrowp-hero-manager'),
            ],
            'secondaryButtonLink' => [
                'type' => 'String',
                'description' => __('Secondary button link', 'astrowp-hero-manager'),
            ],
            'showSocialProof' => [
                'type' => 'Boolean',
                'description' => __('Whether to show social proof', 'astrowp-hero-manager'),
            ],
            'socialProofText' => [
                'type' => 'String',
                'description' => __('Social proof text', 'astrowp-hero-manager'),
            ],
        ],
    ]);

    // Register heroSettings field on RootQuery
    register_graphql_field('RootQuery', 'heroSettings', [
        'type' => 'HeroSettings',
        'description' => __('Hero section settings', 'astrowp-hero-manager'),
        'resolve' => function() {
            return [
                'title' => get_theme_mod('hero_title', 'Astro WordPress'),
                'subtitle' => get_theme_mod('hero_subtitle', 'Starter'),
                'description' => get_theme_mod('hero_description', 'Boilerplate for Astro and WordPress using WPGraphQL, shadcn/ui, and Tailwind CSS.'),
                'primaryButtonText' => get_theme_mod('hero_primary_button_text', 'Explore Events'),
                'primaryButtonLink' => get_theme_mod('hero_primary_button_link', '/events'),
                'secondaryButtonText' => get_theme_mod('hero_secondary_button_text', 'Read Posts'),
                'secondaryButtonLink' => get_theme_mod('hero_secondary_button_link', '/posts'),
                'showSocialProof' => get_theme_mod('hero_show_social_proof', '1') === '1',
                'socialProofText' => get_theme_mod('hero_social_proof_text', 'Trusted by developers worldwide'),
            ];
        }
    ]);
}

/**
 * Helper Functions
 */
function astrowp_hero_manager_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? '1' : '0');
}

/**
 * Plugin Activation Hook
 */
function astrowp_hero_manager_activate() {
    // Set default values if they don't exist
    $defaults = [
        'hero_title' => 'Astro WordPress',
        'hero_subtitle' => 'Starter',
        'hero_description' => 'Boilerplate for Astro and WordPress using WPGraphQL, shadcn/ui, and Tailwind CSS.',
        'hero_primary_button_text' => 'Explore Events',
        'hero_primary_button_link' => '/events',
        'hero_secondary_button_text' => 'Read Posts',
        'hero_secondary_button_link' => '/posts',
        'hero_show_social_proof' => '1',
        'hero_social_proof_text' => 'Trusted by developers worldwide',
    ];

    foreach ($defaults as $key => $value) {
        if (get_theme_mod($key) === false) {
            set_theme_mod($key, $value);
        }
    }
}
register_activation_hook(__FILE__, 'astrowp_hero_manager_activate');

/**
 * Plugin Deactivation Hook
 */
function astrowp_hero_manager_deactivate() {
    // Clean up if needed
}
register_deactivation_hook(__FILE__, 'astrowp_hero_manager_deactivate');
