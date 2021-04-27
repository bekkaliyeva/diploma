<?php
require_once get_theme_file_path( '/inc/upgrade/upgrade.php' );

//
// Migrate theme_mods from olsen-light
//
add_action( 'after_switch_theme', 'olsen_after_switch_theme_migrate_mods' );
function olsen_after_switch_theme_migrate_mods() {
	$theme_mods = get_theme_mods();
	$light_mods = get_option( 'theme_mods_olsen-light' );
	if ( get_theme_mod( 'imported_olsen_light' ) === false && ! empty( $light_mods ) ) {
		foreach ( $light_mods as $key => $option ) {
			if ( ! isset( $theme_mods[ $key ] ) ) {
				set_theme_mod( $key, $option );
			}
		}
		set_theme_mod( 'imported_olsen_light', true );
	}
}


add_action( 'wp_loaded', 'olsen_register_data_upgrade', 1000 );
function olsen_register_data_upgrade() {
	$upgrader = new Olsen_Data_Upgrade();

	// TODO: Remove this, along with olsen_data_upgrade_force_versionless_to_version() when the 2.5.0.x migrations are removed.
	$upgrader->register( '', 'olsen_migrate_typography_versionless' );

	// TODO: Keep the 2.5.0.x migrations at least until the theme reaches v2.9
	// These migration routines have been brought forward from previous versions of the theme.
	// It is important that they run for existing data in version-less installations, yet leave new installations intact.
	$upgrader->register( '2.5.0.1', 'olsen_migrate_simple_typography_mods_2_5_0_1' );
	$upgrader->register( '2.5.0.2', 'olsen_migrate_typography_mods_lineheight_unitless_2_5_0_2' );
	$upgrader->register( '2.5.0.3', 'olsen_migrate_typography_mods_fix_empty_family_2_5_0_3' );
	$upgrader->register( '2.5.0.4', 'olsen_migrate_custom_css_to_customizer_2_5_0_4' );
	$upgrader->register( '2.5.1', 'olsen_migrate_cleanup_previous_migration_flags_2_5_1' );

	// This needs to run always, even if there are no upgrade steps, as it also takes care of updating the version in the database.
	$upgrader->maybe_upgrade();
}

add_filter( 'olsen_data_upgrade_callback', 'olsen_data_upgrade_force_versionless_to_version' );
function olsen_data_upgrade_force_versionless_to_version( $callback_info ) {
	if ( empty( $callback_info['this_version'] ) ) {
		$callback_info['next_version'] = '2.5.0';
	}

	return $callback_info;
}

function olsen_migrate_typography_versionless( $log, $this_version, $next_version ) {
	// This function is needed so that the upgrader will do the version-less upgrade step.
	// olsen_data_upgrade_force_versionless_to_version() takes care of setting a next_version so that the rest of
	// the old typography steps can be run as versioned upgrade steps.

	$log->set( __( 'Updating data...', 'olsen' ) );

	// We don't really have to do anything else here.

	// Don't repeat this task.
	$repeat = false;
	return $repeat;
}

// Migrate old simple (integers, checkboxes) typography mods.
function olsen_migrate_simple_typography_mods_2_5_0_1( $log, $this_version, $next_version ) {
	// Make sure this doesn't run again, as it may have ran in previous theme versions.
	if ( get_theme_mod( 'migrated_typography' ) ) {
		// Don't repeat this task.
		$repeat = false;
		return $repeat;
	}

	$log->set( __( 'Updating theme typography...', 'olsen' ) );

	$sizes = array(
		'h1_size'            => 'global_typo_h1',
		'h2_size'            => 'global_typo_h2',
		'h3_size'            => 'global_typo_h3',
		'h4_size'            => 'global_typo_h4',
		'h5_size'            => 'global_typo_h5',
		'h6_size'            => 'global_typo_h6',
		'body_text_size'     => 'global_typo_body',
		'widgets_title_size' => 'global_typo_widget_titles',
	);

	$transform = array(
		'capital_widget_titles' => 'global_typo_widget_titles',
		'capital_buttons'       => 'global_typo_buttons',
	);

	foreach ( $sizes as $old => $new ) {
		$old_mod = get_theme_mod( $old );
		if ( $old_mod ) {
			$new_mod = olsen_customizer_defaults( $new );

			$new_mod['desktop']['size'] = intval( $old_mod );

			set_theme_mod( $new, olsen_typography_control_defaults_empty_breakpoints( $new_mod ) );
		}
		remove_theme_mod( $old );
	}

	foreach ( $transform as $old => $new ) {
		$old_mod = get_theme_mod( $old );
		if ( false !== $old_mod ) {
			$new_mod   = get_theme_mod( $new );
			$transform = 1 === intval( $old_mod ) ? 'uppercase' : 'none';

			if ( ! is_array( $new_mod ) || ! isset( $new_mod['desktop']['transform'] ) ) {
				$new_mod = olsen_customizer_defaults( $new );
			}

			$new_mod['desktop']['transform'] = $transform;

			set_theme_mod( $new, $new_mod );
		}
		remove_theme_mod( $old );
	}

	set_theme_mod( 'migrated_typography', true );

	// This flag was added after version 2.5 so that new installations won't recalculate unit-less values.
	set_theme_mod( 'migrated_typography_is_unitless', true );

	// Don't repeat this task.
	$repeat = false;
	return $repeat;
}

function olsen_migrate_typography_mods_lineheight_unitless_2_5_0_2( $log, $this_version, $next_version ) {
	// Make sure this doesn't run again, as it may have ran in previous theme versions.
	if ( get_option( 'olsen_migrated_typography_lineheight' ) ) {
		// Don't repeat this task.
		$repeat = false;
		return $repeat;
	}

	// Make sure this doesn't run if typography is already unit-less.
	if ( get_theme_mod( 'migrated_typography_is_unitless' ) ) {
		// Don't repeat this task.
		$repeat = false;
		return $repeat;
	}

	$log->set( __( 'Updating theme typography...', 'olsen' ) );

	$theme_mods = array_keys( olsen_get_registered_typography_controls() );

	foreach ( $theme_mods as $key ) {
		$value = get_theme_mod( $key );
		if ( is_array( $value ) ) {
			$value = olsen_convert_typography_line_height_to_unitless( $value );
			set_theme_mod( $key, olsen_typography_control_defaults_empty_breakpoints( $value ) );
		}
	}

	update_option( 'olsen_migrated_typography_lineheight', true, true );

	// Don't repeat this task.
	$repeat = false;
	return $repeat;
}

function olsen_convert_typography_line_height_to_unitless( $typo_array ) {
	if ( ! is_array( $typo_array ) ) {
		return $typo_array;
	}

	foreach ( $typo_array as $breakpoint => $bp_values ) {
		if ( ! empty( $bp_values['size'] ) && ! empty( $bp_values['lineHeight'] ) ) {
			$typo_array[ $breakpoint ]['lineHeight'] = round( $bp_values['lineHeight'] / $bp_values['size'], 2 );
		} elseif ( empty( $bp_values['size'] ) && ! empty( $bp_values['lineHeight'] ) ) {
			$typo_array[ $breakpoint ]['lineHeight'] = '';
		}
	}

	return $typo_array;
}

// Fix typography mods that don't have a font family assigned.
// These were caused by olsen_migrate_typography_mods() in previous versions, as (at the time) default typography settings weren't outputted.
// Also, this needs to run after the unit-less conversion, otherwise already unit-less values will get re-calculated, resulting in extremely small values.
function olsen_migrate_typography_mods_fix_empty_family_2_5_0_3( $log, $this_version, $next_version ) {
	if ( get_theme_mod( 'migrated_typography_filled_defaults' ) ) {
		// Don't repeat this task.
		$repeat = false;
		return $repeat;
	}

	$log->set( __( 'Updating theme typography...', 'olsen' ) );

	$mods = array_keys( olsen_get_registered_typography_controls() );

	foreach ( $mods as $key ) {
		$value   = get_theme_mod( $key );
		$default = olsen_customizer_defaults( $key );

		if ( false === $value ) {
			continue;
		} elseif ( ! is_array( $value ) || ! isset( $value['desktop']['family'] ) ) {
			$value = $default;
		} else {
			// 'family' and 'is_gfont' are a pair, so make sure to copy them together.
			$family = $value['desktop']['family'];
			if ( '' === $family ) {
				$value['desktop']['family']   = $default['desktop']['family'];
				$value['desktop']['is_gfont'] = $default['desktop']['is_gfont'];
			}

			// Go through the rest.
			foreach ( $default['desktop'] as $d_key => $d_value ) {
				if ( '' === $value['desktop'][ $d_key ] ) {
					$value['desktop'][ $d_key ] = $d_value;
				}
			}
		}

		set_theme_mod( $key, $value );
	}

	set_theme_mod( 'migrated_typography_filled_defaults', true );

	// Don't repeat this task.
	$repeat = false;
	return $repeat;
}

function olsen_migrate_custom_css_to_customizer_2_5_0_4( $log, $this_version, $next_version ) {
	if ( get_theme_mod( 'custom_css_migrated' ) ) {
		// Don't repeat this task.
		$repeat = false;
		return $repeat;
	}

	$log->set( __( 'Migrating custom CSS...', 'olsen' ) );

	// Migrate any existing theme CSS to the core option added in WordPress 4.7.
	$css = get_theme_mod( 'custom_css', '' );
	if ( $css ) {
		// Preserve any CSS already added to the core option.
		$core_css = wp_get_custom_css();

		$return = wp_update_custom_css_post(
			$core_css .
			PHP_EOL . PHP_EOL .
			"/* Migrated CSS from the theme's old custom CSS setting. */" .
			PHP_EOL .
			html_entity_decode( $css )
		);

		if ( ! is_wp_error( $return ) ) {
			// Remove the old option, so that the CSS is stored in only one place moving forward.
			set_theme_mod( 'custom_css', '' );
			set_theme_mod( 'custom_css_migrated', true );
		}
	}
}

function olsen_migrate_cleanup_previous_migration_flags_2_5_1( $log, $this_version, $next_version ) {
	$log->set( __( 'Cleaning up theme data...', 'olsen' ) );

	remove_theme_mod( 'migrated_typography' );
	remove_theme_mod( 'migrated_typography_is_unitless' );
	delete_option( 'olsen_migrated_typography_lineheight' );
	remove_theme_mod( 'migrated_typography_filled_defaults' );
	remove_theme_mod( 'custom_css' );
	remove_theme_mod( 'custom_css_migrated' );

	// Don't repeat this task.
	$repeat = false;
	return $repeat;
}
