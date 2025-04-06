<?php

// Database Table creation
include(SF_DIRECTORY.'/includes/admin/db-table.php');

// Database Table creation
include(SF_DIRECTORY.'/includes/admin/admin-fields.php');


// SprintF Value function
function sprintf_custom_value($str, $vars, $char = '%') {
    $tmp = array();
    foreach($vars as $k => $v) {
        $tmp[$char . $k . $char] = $v;
    }
    return str_replace(array_keys($tmp), array_values($tmp), $str);
}