<?php

return array(

	////////////////////////////////////////
	// Localized JS Message Configuration //
	////////////////////////////////////////

	/**
	 * Validation Messages
	 */
	'validation' => array(
		'alphabet'     => __('Value needs to be Alphabet', 'jobboard'),
		'alphanumeric' => __('Value needs to be Alphanumeric', 'jobboard'),
		'numeric'      => __('Value needs to be Numeric', 'jobboard'),
		'email'        => __('Value needs to be Valid Email', 'jobboard'),
		'url'          => __('Value needs to be Valid URL', 'jobboard'),
		'maxlength'    => __('Length needs to be less than {0} characters', 'jobboard'),
		'minlength'    => __('Length needs to be more than {0} characters', 'jobboard'),
		'maxselected'  => __('Select no more than {0} items', 'jobboard'),
		'minselected'  => __('Select at least {0} items', 'jobboard'),
		'required'     => __('This is required', 'jobboard'),
	),

	/**
	 * Import / Export Messages
	 */
	'util' => array(
		'import_success'    => __('Import succeed, option page will be refreshed..', 'jobboard'),
		'import_failed'     => __('Import failed', 'jobboard'),
		'export_success'    => __('Export succeed, copy the JSON formatted options', 'jobboard'),
		'export_failed'     => __('Export failed', 'jobboard'),
		'restore_success'   => __('Restoration succeed, option page will be refreshed..', 'jobboard'),
		'restore_nochanges' => __('Options identical to default', 'jobboard'),
		'restore_failed'    => __('Restoration failed', 'jobboard'),
	),

	/**
	 * Control Fields String
	 */
	'control' => array(
		// select2 select box
		'select2_placeholder' => __('Select option(s)', 'jobboard'),
		// fontawesome chooser
		'fac_placeholder'     => __('Select an Icon', 'jobboard'),
	),

);

/**
 * EOF
 */