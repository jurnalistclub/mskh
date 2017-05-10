<?php
/*
Plugin Name: Cool Tag Cloud
Plugin URI: https://wordpress.org/plugins/cool-tag-cloud/
Description: A simple, yet very beautiful tag cloud.
Version: 2.04
Author: Flector
Author URI: https://profiles.wordpress.org/flector#content-plugins
Text Domain: cool-tag-cloud
*/ 

class Cool_Tag_Cloud_Widget extends WP_Widget {

	//defaults
	private $m_defaults = array( 
		'title'         => 'Tags',
		'font-weight'   => 'Normal',
		'font-family'   => 'arial',
		'smallest'      => 10,
		'largest'       => 10,
		'format'        => 'flat',
		'separator'     => '',
		'unit'          => 'px',
		'number'        => 20,
		'orderby'       => 'name',
		'order'         => 'ASC',
		'taxonomy'      => 'post_tag',
		'exclude'       => null,
		'include'       => null,
		'tooltip'       => 'Yes',
		'texttransform' => 'none',
		'nofollow'      => 'No',
		'imagestyle'    => 'ctcdefault',
		'imagealign'    => 'ctcleft',
        'animation'     => 'No'
	);

	public function __construct() {
		$l_options = array('description' => __('Cool Tag Cloud widget.', 'cool-tag-cloud'));
		parent::__construct('cool_tag_cloud', 'Cool Tag Cloud', $l_options);
	}

    //render tagcloud
	public function widget($p_args, $p_instance) {
		extract($p_args, EXTR_PREFIX_ALL, 'l_args');
		
		if (!empty( $p_instance['title'])) {
			$l_title = $p_instance['title'];
		} else {
			$l_current_tax = get_taxonomy( 
				$this->_get_current_taxonomy($p_instance));
			$l_title = __('Tags','cool-tag-cloud');
			$l_title = $l_current_tax->labels->name;
		}
		$l_title = apply_filters('widget_title', $l_title);

		echo $l_args_before_widget;
		echo $l_args_before_title . $l_title . $l_args_after_title;

		$l_tag_params = wp_parse_args($p_instance, $this->m_defaults);
		$l_tag_params["echo"] = 0;
		if ($l_tag_params["tooltip"] == 'No') {add_filter('wp_tag_cloud', 'ctc_remove_title_attributes');};
		if ($l_tag_params["nofollow"] == 'Yes') {add_filter('wp_tag_cloud', 'ctc_nofollow_tag_cloud');};
		$l_tag_cloud_text = wp_tag_cloud( apply_filters('widget_tag_cloud_args', $l_tag_params ) );
		if ($l_tag_params["tooltip"] == 'No') {remove_filter('wp_tag_cloud', 'ctc_remove_title_attributes');};
		if ($l_tag_params["nofollow"] == 'Yes') {remove_filter('wp_tag_cloud', 'ctc_nofollow_tag_cloud');};

		echo '<div class="cool-tag-cloud">';
		if ($l_tag_params["font-weight"] == "Bold") {echo '<div class="cloudbold">';}
        if ($l_tag_params["animation"] == "Yes") {echo '<div class="animation">';}
		echo '<div class="' . $l_tag_params["imagestyle"] . '">'; echo '<div class="' . $l_tag_params["imagealign"] . '">';
		echo '<div class="' . $l_tag_params["font-family"] . '" style="text-transform:' . $l_tag_params["texttransform"] . '!important;">';
		echo $l_tag_cloud_text;
		echo '</div>'; echo '</div>';
		echo '</div>';
        if ($l_tag_params["animation"] == "Yes") {echo '</div>';}
		if ($l_tag_params["font-weight"] == "Bold") {echo '</div>';}
		echo '</div>';

		echo $l_args_after_widget;
	}

    //widget setup
	public function form($p_instance) {

		$l_instance = wp_parse_args($p_instance, $this->m_defaults);
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('title') . '">' .
			__('Title:', 'cool-tag-cloud') . '</label>';
		echo '<input class="widefat" id="' . $this->get_field_id('title') .
			'" name="' . $this->get_field_name('title') . '" type="text" ' .
			'value="' . __(esc_attr($l_instance['title']), 'cool-tag-cloud') . '" />';
		echo '</p>';
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('font-family') . '">' .
			__('Font family:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('font-family') . 
			'" name="' . $this->get_field_name('font-family') . '">';
		echo '<option ' . selected('arial', $l_instance['font-family'], false) .
			' value="arial">Arial, Helvetica, Sans-serif</option>';
		echo '<option ' . selected('rockwell', $l_instance['font-family'],false) .
			' value="rockwell">Rockwell, Georgia, Serif</option>';
		echo '<option ' . selected('tahoma', $l_instance['font-family'], false) .
			' value="tahoma">Tahoma, Geneva, Sans-serif</option>';
		echo '<option ' . selected('georgia', $l_instance['font-family'], false) .
			' value="georgia">Georgia, Times, Serif</option>';
		echo '<option ' . selected('times', $l_instance['font-family'], false) .
			' value="times">Times, Georgia, Serif</option>';
		echo '<option ' . selected('cambria', $l_instance['font-family'], false) .
			' value="cambria">Cambria, Georgia, Serif</option>';
		echo '<option ' . selected('verdana', $l_instance['font-family'], false) .
			' value="verdana">Verdana, Lucida, Sans-serif</option>';
		echo '<option ' . selected('opensans', $l_instance['font-family'], false) .
			' value="opensans">"Open Sans", Helvetica, Arial</option>';
		echo '</select>';
		echo '</p>';
				
		echo '<p>';
		echo '<label for="' . $this->get_field_id('font-weight') . '">' .
			__('Font weight:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('font-weight') . 
			'" name="' . $this->get_field_name('font-weight') . '">';
		echo '<option ' . selected('Normal', $l_instance['font-weight'], false) .
			' value="Normal">' . __('Normal', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected('Bold', $l_instance['font-weight'], false) .
			' value="Bold">' . __('Bold', 'cool-tag-cloud') .'</option>';
		echo '</select>';
		echo '</p>';
				
		echo '<p>';
		echo '<label for="' . $this->get_field_id('smallest') . '">' .
			__('Smallest font size:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('smallest') . 
			'" name="' . $this->get_field_name('smallest') . '">';
		echo '<option ' . selected('10', $l_instance['smallest'], false) .
			' value="10">10px</option>';
		echo '<option ' . selected('11', $l_instance['smallest'], false) .
			' value="11">11px</option>';
		echo '<option ' . selected('12', $l_instance['smallest'], false) .
			' value="12">12px</option>';
		echo '<option ' . selected('13', $l_instance['smallest'], false) .
			' value="13">13px</option>';
		echo '<option ' . selected('14', $l_instance['smallest'], false) .
			' value="14">14px</option>';
		echo '<option ' . selected('15', $l_instance['smallest'], false) .
			' value="15">15px</option>';
		echo '<option ' . selected('16', $l_instance['smallest'], false) .
			' value="16">16px</option>';
		echo '<option ' . selected('17', $l_instance['smallest'], false) .
			' value="17">17px</option>';
		echo '</select>';
		echo '</p>';
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('largest') . '">' .
			__('Largest font size:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id( 'largest' ) . 
			'" name="' . $this->get_field_name('largest') . '">';
		echo '<option ' . selected('10', $l_instance['largest'], false) .
			' value="10">10px</option>';
		echo '<option ' . selected('11', $l_instance['largest'], false) .
			' value="11">11px</option>';
		echo '<option ' . selected('12', $l_instance['largest'], false) .
			' value="12">12px</option>';
		echo '<option ' . selected('13', $l_instance['largest'], false) .
			' value="13">13px</option>';
		echo '<option ' . selected('14', $l_instance['largest'], false) .
			' value="14">14px</option>';
		echo '<option ' . selected('15', $l_instance['largest'], false) .
			' value="15">15px</option>';
		echo '<option ' . selected('16', $l_instance['largest'], false) .
			' value="16">16px</option>';
		echo '<option ' . selected('17', $l_instance['largest'], false) .
			' value="17">17px</option>';
		echo '</select>';
		echo '</p>';
		
        echo '<p>';
		echo '<label for="' . $this->get_field_id('imagestyle') . '">' .
			__( 'Image style:', 'cool-tag-cloud' ) . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('imagestyle') . 
			'" name="' . $this->get_field_name('imagestyle') . '">';
		echo '<option ' . selected('ctcdefault', $l_instance['imagestyle'], false) .
			' value="ctcdefault">' . __('Default (Orange)', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected('ctcsilver', $l_instance['imagestyle'], false) .
			' value="ctcsilver">' . __('Silver', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctcgreen', $l_instance['imagestyle'], false) .
			' value="ctcgreen">' . __('Green', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctcred', $l_instance['imagestyle'], false) .
			' value="ctcred">' . __('Red', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctcblue', $l_instance['imagestyle'], false) .
			' value="ctcblue">' . __('Blue', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctcbrown', $l_instance['imagestyle'], false) .
			' value="ctcbrown">' . __('Brown', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctcpurple', $l_instance['imagestyle'], false) .
			' value="ctcpurple">' . __('Purple', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctccyan', $l_instance['imagestyle'], false) .
			' value="ctccyan">' . __('Cyan', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctclime', $l_instance['imagestyle'], false) .
			' value="ctclime">' . __('Lime', 'cool-tag-cloud') .'</option>';
        echo '<option ' . selected('ctcblack', $l_instance['imagestyle'], false) .
			' value="ctcblack">' . __('Black', 'cool-tag-cloud') .'</option>';
		echo '</select>';
		echo '</p>';
        
		echo '<p>';
		echo '<label for="' . $this->get_field_id('imagealign') . '">' .
			__('Image align:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('imagealign') . 
			'" name="' . $this->get_field_name( 'imagealign' ) . '">';
		echo '<option ' . selected( 'ctcleft', $l_instance['imagealign'], false) .
			' value="ctcleft">' . __('Left', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected( 'ctcright', $l_instance['imagealign'], false) .
			' value="ctcright">' . __('Right', 'cool-tag-cloud') .'</option>';
		echo '</select>';
		echo '</p>';
        
        echo '<p>';
		echo '<label for="' . $this->get_field_id('animation') . '">' .
			__('Animation on hover:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('animation') . 
			'" name="' . $this->get_field_name('animation') . '">';
		echo '<option ' . selected('Yes', $l_instance['animation'], false) .
			' value="Yes">' . __('Yes', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected('No', $l_instance['animation'], false) .
			' value="No">' . __('No', 'cool-tag-cloud') .'</option>';
		echo '</select>';
		echo '</p>';
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('texttransform') . '">' .
			__('Text transform:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('texttransform') . 
			'" name="' . $this->get_field_name('texttransform') . '">';
		echo '<option ' . selected( 'none', $l_instance['texttransform'], false) .
			' value="none">' . __('None', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected('uppercase', $l_instance['texttransform'], false) .
			' value="uppercase">' . __('Uppercase', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected('lowercase', $l_instance['texttransform'], false) .
			' value="lowercase">' . __('Lowercase', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected('capitalize', $l_instance['texttransform'], false) .
			' value="capitalize">' . __('Capitalize', 'cool-tag-cloud') .'</option>';
		echo '</select>';
		echo '</p>';

		echo '<p>';
		echo '<label for="' . $this->get_field_id('number') . '">' .
			__('Maximum tags (0 for no limit):', 'cool-tag-cloud') . '</label>';
		echo '<input class="widefat" id="' . $this->get_field_id('number') .
			'" name="' . $this->get_field_name('number') . '" type="text" ' .
			'value="' . esc_attr($l_instance['number']) . '" />';
		echo '</p>';

		echo '<p>';
		echo '<label for="' . $this->get_field_id('orderby') . '">' .
			__('Order tags by:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . 
			$this->get_field_id('orderby') .  '" name="' . 
			$this->get_field_name('orderby') . '">';
		echo '<option ' . selected('name', $l_instance['orderby'], false) .
			' value="name">'. __('name', 'cool-tag-cloud') . '</option>';
		echo '<option ' . selected('count', $l_instance['orderby'], false) .
			' value="count">'. __('count', 'cool-tag-cloud') . '</option>';
		echo '</select>';
		echo '</p>';

		echo '<p>';
		echo '<label for="' . $this->get_field_id('order') . '">' .
			__('Tag order direction:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('order') . 
			'" name="' . $this->get_field_name( 'order' ) . '">';
		echo '<option ' . selected('ASC', $l_instance['order'], false) .
			' value="ASC">'. __('ascending', 'cool-tag-cloud') . '</option>';
		echo '<option ' . selected('DESC', $l_instance['order'], false) .
			' value="DESC">'. __('descending', 'cool-tag-cloud') . '</option>';
		echo '<option ' . selected('RAND', $l_instance['order'], false) .
			' value="RAND">'. __('random', 'cool-tag-cloud') . '</option>';
		echo '</select>';
		echo '</p>';

		$l_current_tax = $this->_get_current_taxonomy($p_instance);
		echo '<p>';
		echo '<label for="' . $this->get_field_id('taxonomy') . '">' .
			__('Taxonomy:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . 
			$this->get_field_id('taxonomy') . '" name="' . 
			$this->get_field_name('taxonomy') . '">';
		foreach(get_taxonomies() as $l_taxonomy) {
			$l_tax = get_taxonomy($l_taxonomy);
			if (!$l_tax->show_tagcloud || empty($l_tax->labels->name)) {
				continue;
			}
			echo '<option ' . selected($l_taxonomy, $l_current_tax, false) .
				' value="' . esc_attr($l_taxonomy) . '">' .
				$l_tax->labels->name . '</option>';
		}
		echo '</select>';
		echo '</p>';
				
		echo '<p>';
		echo '<label for="' . $this->get_field_id('tooltip') . '">' .
			__('Tooltip:', 'cool-tag-cloud') . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id( 'tooltip' ) . 
			'" name="' . $this->get_field_name('tooltip') . '">';
		echo '<option ' . selected( 'Yes', $l_instance['tooltip'], false ) .
			' value="Yes">' . __('Yes', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected( 'No', $l_instance['tooltip'],false ) .
			' value="No">' . __('No', 'cool-tag-cloud') .'</option>';
		echo '</select>';
		echo '</p>';
		
		echo '<p>';
		echo '<label for="' . $this->get_field_id('nofollow') . '">' .
			__( 'Nofollow for tag links:', 'cool-tag-cloud' ) . '</label>';
		echo '<select class="widefat" id="' . $this->get_field_id('nofollow') . 
			'" name="' . $this->get_field_name('nofollow') . '">';
		echo '<option ' . selected('Yes', $l_instance['nofollow'], false) .
			' value="Yes">' . __('Yes', 'cool-tag-cloud') .'</option>';
		echo '<option ' . selected('No', $l_instance['nofollow'], false) .
			' value="No">' . __('No', 'cool-tag-cloud') .'</option>';
		echo '</select>';
		echo '</p>';
		
		echo '<p><a target="_blank" title="' . __('Donate with PayPal','cool-tag-cloud') .'" href="http://goo.gl/CcxWYg"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" /></a></p>    ';

		
	}

    //update settings
	public function update($p_new_instance, $p_old_instance) {

		$l_instance['title'] = strip_tags(stripslashes($p_new_instance['title']));

		if ('arial' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'arial';
		} else if ('rockwell' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'rockwell';
		} else if ('tahoma' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'tahoma';
		} else if ('georgia' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'georgia';
		} else if ('times' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'times';
		} else if ('cambria' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'cambria';
		} else if ('verdana' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'verdana';
		} else if ('opensans' == $p_new_instance['font-family']) {
			$l_instance['font-family'] = 'opensans';
		} else {
			$l_instance['font-family'] = $p_old_instance['font-family'];
		}
		
		if ('10' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '10';
		} else if ('11' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '11';
		} else if ('12' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '12';
		} else if ('13' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '13';
		} else if ('14' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '14';
		} else if ('15' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '15';
		} else if ('16' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '16';
		} else if ('17' == $p_new_instance['smallest']) {
			$l_instance['smallest'] = '17';
		} else {
			$l_instance['smallest'] = $p_old_instance['smallest'];
		}
		
		if ('10' == $p_new_instance['largest']) {
			$l_instance['largest'] = '10';
		} else if ('11' == $p_new_instance['largest']) {
			$l_instance['largest'] = '11';
		} else if ('12' == $p_new_instance['largest']) {
			$l_instance['largest'] = '12';
		} else if ('13' == $p_new_instance['largest']) {
			$l_instance['largest'] = '13';
		} else if ('14' == $p_new_instance['largest']) {
			$l_instance['largest'] = '14';
		} else if ('15' == $p_new_instance['largest']) {
			$l_instance['largest'] = '15';
		} else if ('16' == $p_new_instance['largest']) {
			$l_instance['largest'] = '16';
		} else if ('17' == $p_new_instance['largest']) {
			$l_instance['largest'] = '17';
		} else {
			$l_instance['largest'] = $p_old_instance['largest'];
		}
		
        if ('ctcdefault' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcdefault';
		} else if ('ctcsilver' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcsilver';
        } else if ('ctcgreen' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcgreen';
        } else if ('ctcred' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcred';
        } else if ('ctcblue' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcblue';
        } else if ('ctcbrown' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcbrown';
        } else if ('ctcpurple' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcpurple';
        } else if ('ctccyan' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctccyan';
        } else if ('ctclime' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctclime';
        } else if ('ctcblack' == $p_new_instance['imagestyle']) {
			$l_instance['imagestyle'] = 'ctcblack';
		} else {
			$l_instance['imagestyle'] = $p_old_instance['imagestyle'];
		}
        
		if ('ctcleft' == $p_new_instance['imagealign']) {
			$l_instance['imagealign'] = 'ctcleft';
		} else if ('ctcright' == $p_new_instance['imagealign']) {
			$l_instance['imagealign'] = 'ctcright';
		} else {
			$l_instance['imagealign'] = $p_old_instance['imagealign'];
		}
		
		
		if ('Bold' == $p_new_instance['font-weight']) {
			$l_instance['font-weight'] = 'Bold';
		} else if ('Normal' == $p_new_instance['font-weight']) {
			$l_instance['font-weight'] = 'Normal';
		} else {
			$l_instance['font-weight'] = $p_old_instance['font-weight'];
		}
		
		if ('none' == $p_new_instance['texttransform']) {
			$l_instance['texttransform'] = 'none';
		} else if ('uppercase' == $p_new_instance['texttransform']) {
			$l_instance['texttransform'] = 'uppercase';
		} else if ('lowercase' == $p_new_instance['texttransform']) {
			$l_instance['texttransform'] = 'lowercase';
		} else if ('capitalize' == $p_new_instance['texttransform']) {
			$l_instance['texttransform'] = 'capitalize';
		} else {
			$l_instance['texttransform'] = $p_old_instance['texttransform'];
		}

		if (is_numeric($p_new_instance['number'])) {
			$l_instance['number'] = $p_new_instance['number'] + 0;
		} else {
			$l_instance['number'] = $p_old_instance['number'] + 0;
		}

		if ('name' == $p_new_instance['orderby']) {
			$l_instance['orderby'] = 'name';
		} else if ('count' == $p_new_instance['orderby']) {
			$l_instance['orderby'] = 'count';
		} else {
			$l_instance['orderby'] = $p_old_instance['orderby'];
		}

		if ('ASC' == $p_new_instance['order']) {
			$l_instance['order'] = 'ASC';
		} else if ('DESC' == $p_new_instance['order']) {
			$l_instance['order'] = 'DESC';
		} else if ('RAND' == $p_new_instance['order']) {
			$l_instance['order'] = 'RAND';
		} else {
			$l_instance['order'] = $p_old_instance['order'];
		}

		if ("" != get_taxonomy(stripslashes($p_new_instance['taxonomy']))) {
			$l_instance['taxonomy'] = 
				stripslashes($p_new_instance['taxonomy']);
		}
		
		if ('Yes' == $p_new_instance['tooltip']) {
			$l_instance['tooltip'] = 'Yes';
		} else if ('No' == $p_new_instance['tooltip']) {
			$l_instance['tooltip'] = 'No';
		} else {
			$l_instance['tooltip'] = $p_old_instance['tooltip'];
		}
		
		if ('Yes' == $p_new_instance['nofollow']) {
			$l_instance['nofollow'] = 'Yes';
		} else if ('No' == $p_new_instance['nofollow']) {
			$l_instance['nofollow'] = 'No';
		} else {
			$l_instance['nofollow'] = $p_old_instance['nofollow'];
		}
        
        if ('Yes' == $p_new_instance['animation']) {
			$l_instance['animation'] = 'Yes';
		} else if ('No' == $p_new_instance['animation']) {
			$l_instance['animation'] = 'No';
		} else {
			$l_instance['animation'] = $p_old_instance['animation'];
		}
		
		return $l_instance;
	}

	//get taxonomy
	function _get_current_taxonomy($p_instance) {
		if (!empty($p_instance['taxonomy']) && 
			 taxonomy_exists($p_instance['taxonomy'])) {
			return $p_instance['taxonomy'];
		}
		return $this->m_defaults['taxonomy'];
	}
}

function ctc_remove_title_attributes($input) {
    return preg_replace('/\s*title\s*=\s*(["\']).*?\1/', '', $input);
}
function ctc_nofollow_tag_cloud($text) {
    return str_replace('<a href=', '<a rel="nofollow" href=',  $text);	
}

add_action('widgets_init', create_function('', 'register_widget( "Cool_Tag_Cloud_Widget" );'));

function cool_tag_cloud_files() {
	$purl = plugins_url();
	wp_register_style('cool-tag-cloud', $purl . '/cool-tag-cloud/inc/cool-tag-cloud.css');
	wp_enqueue_style('cool-tag-cloud');   
}
add_action('wp_enqueue_scripts', 'cool_tag_cloud_files');

function cool_tag_cloud_setup(){
    load_plugin_textdomain('cool-tag-cloud');
}
add_action('init', 'cool_tag_cloud_setup');

?>