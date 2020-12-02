<?php

// breadcrumb walker
class sp_Breadcrumb_Walker extends Walker_Nav_Menu {

	// start level
	function start_lvl(&$output, $depth = 0, $args = array()) { return; }
	
	// end level
	function end_lvl(&$output, $depth = 0, $args = array()) { return; }
	
	// start element
	function start_el(&$output, $element, $depth = 0, $args = array(), $current_object_id = 0) {
		static $first = true;
	
		// get element title
		$title = apply_filters('the_title', $element->title, $element->ID);
		
		// prefix first item
		if($first && !empty($args->sp_first)) {
			$output .= $args->sp_first;
			$first = false;
		}

		// show delimiter if set and not first element
		if(!$first && !empty($args->sp_delimiter)) { $output .= $args->sp_delimiter; }
		
		// unset first flag
		$first = false;
		
		// show only title if current item
		if(empty($args->sp_link_current) && in_array('current-menu-item', $element->classes)) {
			$output .= '<span class="current">'.$title.'</span>';
			return;
		}
		
		// link attributes
		$attrs = '';
		if(!empty($element->attr_title)) { $attrs .= ' title="'.esc_attr($element->attr_title).'"'; }
		if(!empty($element->target)) { $attrs .= ' target="'.esc_attr($element->target).'"'; }
		if(!empty($element->xfn)) { $attrs .= ' rel="'.esc_attr($element->xfn).'"'; }
		if(!empty($element->url)) { $attrs .= ' href="'.esc_attr($element->url).'"'; }

		// link tag
		$output .= '<a'.$attrs.'>'.$title.'</a>';
	}
	
	// end element
	function end_el(&$output, $element, $depth = 0, $args = array()) { return; }
	
	// display element
	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
		static $path = array('current-menu-item', 'current-menu-parent', 'current-menu-ancestor');
		
		// stop if element is not on the current path
		if(!array_intersect($path, $element->classes)) { return; }
		$classes = array_intersect($path, $element->classes);
		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
	
}