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

    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label' => __('Hero Background Image', 'astrowp-hero-manager'),
        'section' => 'hero_section',
        'description' => __('Upload a background image for the hero section. If no image is set, the default animated background will be used.', 'astrowp-hero-manager'),
    )));

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

    // Contact Information Section
    $wp_customize->add_section('contact_section', array(
        'title' => __('Contact Information', 'astrowp-hero-manager'),
        'priority' => 35,
        'description' => __('Configure contact information displayed in the footer.', 'astrowp-hero-manager'),
    ));

    // Address
    $wp_customize->add_setting('contact_address', array(
        'default' => '123 Main Street',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('contact_address', array(
        'label' => __('Address', 'astrowp-hero-manager'),
        'section' => 'contact_section',
        'type' => 'text',
        'description' => __('Street address for contact information.', 'astrowp-hero-manager'),
    ));

    // City
    $wp_customize->add_setting('contact_city', array(
        'default' => 'City',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('contact_city', array(
        'label' => __('City', 'astrowp-hero-manager'),
        'section' => 'contact_section',
        'type' => 'text',
        'description' => __('City name for contact information.', 'astrowp-hero-manager'),
    ));

    // State
    $wp_customize->add_setting('contact_state', array(
        'default' => 'State',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('contact_state', array(
        'label' => __('State', 'astrowp-hero-manager'),
        'section' => 'contact_section',
        'type' => 'text',
        'description' => __('State or province for contact information.', 'astrowp-hero-manager'),
    ));

    // ZIP Code
    $wp_customize->add_setting('contact_zip', array(
        'default' => '12345',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('contact_zip', array(
        'label' => __('ZIP Code', 'astrowp-hero-manager'),
        'section' => 'contact_section',
        'type' => 'text',
        'description' => __('ZIP or postal code for contact information.', 'astrowp-hero-manager'),
    ));

    // Phone
    $wp_customize->add_setting('contact_phone', array(
        'default' => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('contact_phone', array(
        'label' => __('Phone Number', 'astrowp-hero-manager'),
        'section' => 'contact_section',
        'type' => 'text',
        'description' => __('Phone number for contact information.', 'astrowp-hero-manager'),
    ));

    // Email
    $wp_customize->add_setting('contact_email', array(
        'default' => 'hello@astrowp.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('contact_email', array(
        'label' => __('Email Address', 'astrowp-hero-manager'),
        'section' => 'contact_section',
        'type' => 'email',
        'description' => __('Email address for contact information.', 'astrowp-hero-manager'),
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
            'backgroundImage' => [
                'type' => 'String',
                'description' => __('Hero background image URL', 'astrowp-hero-manager'),
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

    // Register Contact Settings object type
    register_graphql_object_type('ContactSettings', [
        'description' => __('Contact information settings from WordPress Customizer', 'astrowp-hero-manager'),
        'fields' => [
            'address' => [
                'type' => 'String',
                'description' => __('Contact address', 'astrowp-hero-manager'),
            ],
            'city' => [
                'type' => 'String',
                'description' => __('Contact city', 'astrowp-hero-manager'),
            ],
            'state' => [
                'type' => 'String',
                'description' => __('Contact state', 'astrowp-hero-manager'),
            ],
            'zip' => [
                'type' => 'String',
                'description' => __('Contact ZIP code', 'astrowp-hero-manager'),
            ],
            'phone' => [
                'type' => 'String',
                'description' => __('Contact phone number', 'astrowp-hero-manager'),
            ],
            'email' => [
                'type' => 'String',
                'description' => __('Contact email address', 'astrowp-hero-manager'),
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
                'backgroundImage' => get_theme_mod('hero_background_image', ''),
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

    // Register contactSettings field on RootQuery
    register_graphql_field('RootQuery', 'contactSettings', [
        'type' => 'ContactSettings',
        'description' => __('Contact information settings', 'astrowp-hero-manager'),
        'resolve' => function() {
            return [
                'address' => get_theme_mod('contact_address', '123 Main Street'),
                'city' => get_theme_mod('contact_city', 'City'),
                'state' => get_theme_mod('contact_state', 'State'),
                'zip' => get_theme_mod('contact_zip', '12345'),
                'phone' => get_theme_mod('contact_phone', '+1 (555) 123-4567'),
                'email' => get_theme_mod('contact_email', 'hello@astrowp.com'),
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
        'hero_background_image' => '',
        'hero_description' => 'Boilerplate for Astro and WordPress using WPGraphQL, shadcn/ui, and Tailwind CSS.',
        'hero_primary_button_text' => 'Explore Events',
        'hero_primary_button_link' => '/events',
        'hero_secondary_button_text' => 'Read Posts',
        'hero_secondary_button_link' => '/posts',
        'hero_show_social_proof' => '1',
        'hero_social_proof_text' => 'Trusted by developers worldwide',
        'contact_address' => '123 Main Street',
        'contact_city' => 'City',
        'contact_state' => 'State',
        'contact_zip' => '12345',
        'contact_phone' => '+1 (555) 123-4567',
        'contact_email' => 'hello@astrowp.com',
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
