<?php
add_action( 'customize_register', 'bwsocial_customize_register', 10, 1 );
function bwsocial_customize_register( $wp_customize ) {
	
	$wp_customize->add_section(
		'smi-social',
		array(
			'title' => __( 'Social Menu Icons', 'social-menu-icons' )
		)
	);
	
	// Icon Size
	$wp_customize->add_setting( 
		'social_menu_icons[icon_size]',
		array(
			'type'    => 'option',
			'default' => '24'
		)	
	);
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'social_menu_icons[icon_size]',
		array(
			'label'   => __( 'Icon Size', 'social-menu-icons' ),
			'section' => 'smi-social',
			'setting' => 'social_menu_icons[icon_size]',
			'type'    => 'select',
			'choices' => array(
				'12' => '12px',
				'18' => '18px',
				'24' => '24px',
				'36' => '36px', 
				'48' => '48px'
			),
		)
	) );
	
	// Fill Color
	$wp_customize->add_setting( 
		'social_menu_icons[fill_color]',
		array(
			'type'    => 'option',
			'default' => 'gray'
		)	
	);
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'social_menu_icons[fill_color]',
		array(
			'label'   => __( 'Fill Color', 'social-menu-icons' ),
			'section' => 'smi-social',
			'setting' => 'social_menu_icons[fill_color]',
			'type'    => 'select',
			'choices' => array(
				'brand'   => __( 'Brand Colors', 'social-menu-icons' ),
				'gray'    => _x( 'Gray', 'color', 'social-menu-icons' ),
				'white'   => _x( 'White', 'color', 'social-menu-icons' ), 
				'black'   => _x( 'Black', 'color', 'social-menu-icons' ),
				'custom'  => __( 'Custom Color', 'social-menu-icons' )
			),
		)
	) );
	
	// Fill Color Custom
	$wp_customize->add_setting( 
		'social_menu_icons[fill_color_custom]',
		array(
			'type'    => 'option',
			'default' => '#767676'
		)	
	);
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'social_menu_icons[fill_color_custom]',
		array(
			'label'   => __( 'Fill Color Custom', 'social-menu-icons' ),
			'section' => 'smi-social',
			'setting' => 'social_menu_icons[fill_color_custom]',
		)
	) );

	// Fill Color
	$wp_customize->add_setting( 
		'social_menu_icons[layout]',
		array(
			'type'    => 'option',
			'default' => 'list-item'
		)	
	);
	$wp_customize->add_control( new WP_Customize_Control(
		$wp_customize,
		'social_menu_icons[layout]',
		array(
			'label'   => __( 'Layout', 'social-menu-icons' ),
			'section' => 'smi-social',
			'setting' => 'social_menu_icons[layout]',
			'type'    => 'select',
			'choices' => array(
				'list-item'   => __( 'List Items', 'social-menu-icons' ),
				'vertical'    => __( 'Vertical', 'social-menu-icons' ),
				'horizontal'   => __( 'Horizontal', 'social-menu-icons' ),
			),
		)
	) );
}