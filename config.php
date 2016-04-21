<?php

/**
 * Set allowed IP here
 */
define ('DEPLOY_IPS', serialize(array(
	/**
	 * Localhost
	 */
	 '::1',

	/**
	 * Bitbucket Webhooks
	 */
	/*'131.103.20.160/27',
    '165.254.145.0/26',
	'104.192.143.0/24',*/
	
	/**
	 * Github Webhooks
	 */
	 //'192.30.252.0/22'
)));

/**
	 * The key passed as parameter into webhook url allows you to specify which repository must be updated
	 * ex : Use http://deploy.yoursite.com/?k=YOUR_RANDOM_KEY as webhook url will update files into YOUR_PROJECT_PATH/code/ when new code is pushed into YOUR_BRANCH_NAME 
	 * You can call this url manually first to make sure that all is ok
	 * @see https://blog.bitbucket.org/2015/06/24/the-new-bitbucket-webhooks/ for how to use webhooks in Bitbucket
	 * @see https://developer.github.com/webhooks/creating/ for how to use webhooks in Github
	 */
define ('DEPLOY_KEYS', serialize(array(
	'YOUR_RANDOM_KEY' => array(
		'path' => 'YOUR_PROJECT_PATH',
		'branch' => 'YOUR_BRANCH_NAME'
	)
)));
?>