<?php

/**
 * JS JOBS Uninstall
 *
 * Uninstalling JS JOBS tables, and pages.
 *
 * @author 		Chilavert N'Dah
 * @category 	Core
 * @package 	JS JOBS/Uninstaller
 * @version     1.0 - Customed version
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

// Conservez les données en base : seules les entrées d’options sont nettoyées
delete_option('jsjobs_do_activation_redirect');
