<?php

/**
 * Set allowed IP here
 */
define ('DEPLOY_IPS', serialize(array(
	/**
	 * Bitbucket
	 */
	'131.103.20.160/27',
    '165.254.145.0/26',
	'104.192.143.0/24'
)));

/**
 * The key passed as parameter into webhook url allows you to specify which repository must be updated
 * ex : Use http://deploy.yoursite.com/?k=gYg99OTL4lmtO2cIApzG034590y9L7N9 as webhook url will update files into YOUR_PROJECT_PATH/code/ when new code is pushed into YOUR_BRANCH_NAME 
 * @see https://blog.bitbucket.org/2015/06/24/the-new-bitbucket-webhooks/ for how to use webhooks
 */
define ('DEPLOY_KEYS', serialize(array(
	'gYg99OTL4lmtO2cIApzG034590y9L7N9' => array(
		'path' => 'YOUR_PROJECT_PATH',
		'branch' => 'YOUR_BRANCH_NAME'
	)
)));
?>