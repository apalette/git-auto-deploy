<?php
define ('CONFIG_PATH', '../config.php');
define ('TODEPLOY_PATH', '../todeploy');

require_once CONFIG_PATH; 

// Check IP
$allowed = false;
$allowed_ips = unserialize(DEPLOY_IPS);
$ip = $_SERVER['REMOTE_ADDR'];
$ip_long = ip2long($ip);
$i = 0;
while (! $allowed && ($i < count($allowed_ips))) {
	list ($subnet, $bits) = explode('/', $allowed_ips[$i]);
	
	// Simple IP
	if (! $bits) {
		if ($allowed_ips[$i] == $ip) {
			$allowed = true;
		}
	}
	// IP Range
	else {
		$subnet = ip2long($subnet);
		$mask = -1 << (32 - $bits);
		$subnet &= $mask;
		if (($ip_long & $mask) == $subnet) {
			$allowed = true;
		}
	}
	$i++;
}

// Get Key
$projects_keys = unserialize(DEPLOY_KEYS);
$k = isset($_GET['k']) ? $_GET['k'] : null;


// IP is not allowed
if (! $allowed) {
	echo 'IP is not allowed error';
}
else {
	// Project key exist
	if ($k && isset($projects_keys[$k])) {
		$project = $projects_keys[$k];
		print_r($project);
		
		// Report into "to deploy list"
		file_put_contents(TODEPLOY_PATH, $project['path'].':'.$project['branch']. "\n", FILE_APPEND);
	}
	
	// Project key doesn't exist
	else {
		echo 'key error';
	}
}
?>