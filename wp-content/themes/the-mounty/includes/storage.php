<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage THE_MOUNTY
 * @since THE_MOUNTY 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('the_mounty_storage_get')) {
	function the_mounty_storage_get($var_name, $default='') {
		global $THE_MOUNTY_STORAGE;
		return isset($THE_MOUNTY_STORAGE[$var_name]) ? $THE_MOUNTY_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('the_mounty_storage_set')) {
	function the_mounty_storage_set($var_name, $value) {
		global $THE_MOUNTY_STORAGE;
		$THE_MOUNTY_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('the_mounty_storage_empty')) {
	function the_mounty_storage_empty($var_name, $key='', $key2='') {
		global $THE_MOUNTY_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($THE_MOUNTY_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($THE_MOUNTY_STORAGE[$var_name][$key]);
		else
			return empty($THE_MOUNTY_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('the_mounty_storage_isset')) {
	function the_mounty_storage_isset($var_name, $key='', $key2='') {
		global $THE_MOUNTY_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($THE_MOUNTY_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($THE_MOUNTY_STORAGE[$var_name][$key]);
		else
			return isset($THE_MOUNTY_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('the_mounty_storage_inc')) {
	function the_mounty_storage_inc($var_name, $value=1) {
		global $THE_MOUNTY_STORAGE;
		if (empty($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = 0;
		$THE_MOUNTY_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('the_mounty_storage_concat')) {
	function the_mounty_storage_concat($var_name, $value) {
		global $THE_MOUNTY_STORAGE;
		if (empty($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = '';
		$THE_MOUNTY_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('the_mounty_storage_get_array')) {
	function the_mounty_storage_get_array($var_name, $key, $key2='', $default='') {
		global $THE_MOUNTY_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($THE_MOUNTY_STORAGE[$var_name][$key]) ? $THE_MOUNTY_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($THE_MOUNTY_STORAGE[$var_name][$key][$key2]) ? $THE_MOUNTY_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('the_mounty_storage_set_array')) {
	function the_mounty_storage_set_array($var_name, $key, $value) {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if ($key==='')
			$THE_MOUNTY_STORAGE[$var_name][] = $value;
		else
			$THE_MOUNTY_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('the_mounty_storage_set_array2')) {
	function the_mounty_storage_set_array2($var_name, $key, $key2, $value) {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if (!isset($THE_MOUNTY_STORAGE[$var_name][$key])) $THE_MOUNTY_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$THE_MOUNTY_STORAGE[$var_name][$key][] = $value;
		else
			$THE_MOUNTY_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Merge array elements
if (!function_exists('the_mounty_storage_merge_array')) {
	function the_mounty_storage_merge_array($var_name, $key, $value) {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if ($key==='')
			$THE_MOUNTY_STORAGE[$var_name] = array_merge($THE_MOUNTY_STORAGE[$var_name], $value);
		else
			$THE_MOUNTY_STORAGE[$var_name][$key] = array_merge($THE_MOUNTY_STORAGE[$var_name][$key], $value);
	}
}

// Add array element after the key
if (!function_exists('the_mounty_storage_set_array_after')) {
	function the_mounty_storage_set_array_after($var_name, $after, $key, $value='') {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if (is_array($key))
			the_mounty_array_insert_after($THE_MOUNTY_STORAGE[$var_name], $after, $key);
		else
			the_mounty_array_insert_after($THE_MOUNTY_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('the_mounty_storage_set_array_before')) {
	function the_mounty_storage_set_array_before($var_name, $before, $key, $value='') {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if (is_array($key))
			the_mounty_array_insert_before($THE_MOUNTY_STORAGE[$var_name], $before, $key);
		else
			the_mounty_array_insert_before($THE_MOUNTY_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('the_mounty_storage_push_array')) {
	function the_mounty_storage_push_array($var_name, $key, $value) {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($THE_MOUNTY_STORAGE[$var_name], $value);
		else {
			if (!isset($THE_MOUNTY_STORAGE[$var_name][$key])) $THE_MOUNTY_STORAGE[$var_name][$key] = array();
			array_push($THE_MOUNTY_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('the_mounty_storage_pop_array')) {
	function the_mounty_storage_pop_array($var_name, $key='', $defa='') {
		global $THE_MOUNTY_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($THE_MOUNTY_STORAGE[$var_name]) && is_array($THE_MOUNTY_STORAGE[$var_name]) && count($THE_MOUNTY_STORAGE[$var_name]) > 0) 
				$rez = array_pop($THE_MOUNTY_STORAGE[$var_name]);
		} else {
			if (isset($THE_MOUNTY_STORAGE[$var_name][$key]) && is_array($THE_MOUNTY_STORAGE[$var_name][$key]) && count($THE_MOUNTY_STORAGE[$var_name][$key]) > 0) 
				$rez = array_pop($THE_MOUNTY_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('the_mounty_storage_inc_array')) {
	function the_mounty_storage_inc_array($var_name, $key, $value=1) {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if (empty($THE_MOUNTY_STORAGE[$var_name][$key])) $THE_MOUNTY_STORAGE[$var_name][$key] = 0;
		$THE_MOUNTY_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('the_mounty_storage_concat_array')) {
	function the_mounty_storage_concat_array($var_name, $key, $value) {
		global $THE_MOUNTY_STORAGE;
		if (!isset($THE_MOUNTY_STORAGE[$var_name])) $THE_MOUNTY_STORAGE[$var_name] = array();
		if (empty($THE_MOUNTY_STORAGE[$var_name][$key])) $THE_MOUNTY_STORAGE[$var_name][$key] = '';
		$THE_MOUNTY_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('the_mounty_storage_call_obj_method')) {
	function the_mounty_storage_call_obj_method($var_name, $method, $param=null) {
		global $THE_MOUNTY_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($THE_MOUNTY_STORAGE[$var_name]) ? $THE_MOUNTY_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($THE_MOUNTY_STORAGE[$var_name]) ? $THE_MOUNTY_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('the_mounty_storage_get_obj_property')) {
	function the_mounty_storage_get_obj_property($var_name, $prop, $default='') {
		global $THE_MOUNTY_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($THE_MOUNTY_STORAGE[$var_name]->$prop) ? $THE_MOUNTY_STORAGE[$var_name]->$prop : $default;
	}
}
?>