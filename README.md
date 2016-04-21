# Synopsis
Git Auto Deployment on dedicated server.
# Setting up your project with git
1. Create your project on you server with the following architecture :
	```
	YOUR_PROJECT_PATH
	- /code
	```
	
2. Navigate into *YOUR_PROJECT_PATH* and clone your repository with **--mirror** option
	```
 	ls YOUR_PROJECT_PATH
 	git clone --mirror https://github.com/YOUR_REPOSITORY_PATH
 	```
 		
3. Rename the repository copy as *repo.git* and navigate into it
	- Now *YOUR_PROJECT_PATH* must contain 2 folders :
	```
		- code
		- repo.git 
	```
		
4. Get repository latest copy and update */code* with this git command :
	```
	GIT_WORK_TREE=YOUR_PROJECT_PATH/code git checkout -f
	```
		
# Setting up auto-deployment
1. Install git-auto-deploy script on the same server and configure *www* path as **DocumentRoot**
	```
	<VirtualHost *:80>
	     ServerName deploy.mywebsite.com
	     DocumentRoot "YOUR_DEPLOY_PATH/www"
	     php_admin_value open_basedir "YOUR_PROJECT_PATH:/tmp"
	</VirtualHost>
	```

2. Edit *config.php* with allowed IPs and **create a random key** for your project
	- Allowed IPs depend on which git server you will use to configure Webhooks (Github, Bitbucket, your own...)
	- See https://blog.bitbucket.org/2015/06/24/the-new-bitbucket-webhooks/ for how to use webhooks in Bitbucket
	- See https://developer.github.com/webhooks/creating/ for how to use webhooks in Github
	- Associate YOUR_PROJECT_PATH (absolute path on the server) and the git branch to use to the key
	```
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
	```
3. Check *YOUR_DEPLOY_PATH/todeploy* file permissions (It must be writable) then call http://deploy.yoursite.com/?k=YOUR_RANDOM_KEY (Pay attention to the IP)
	- The *YOUR_DEPLOY_PATH/todeploy file* must contains this line :
	```
	YOUR_PROJECT_PATH:YOUR_BRANCH_NAME
	```
# Setting up cron task
The cron task will check *YOUR_DEPLOY_PATH/todeploy* file content regularly and will update your project code automatically foreach line in this file.
1. Edit *YOUR_DEPLOY_PATH/scripts/deploy.sh* and replace "YOUR_DEPLOY_PATH" with your own value at line 2
2. Add this job into the crontab :
```
* * * * * bash YOUR_DEPLOY_PATH/scripts/deploy.sh 
```
This will check the *YOUR_DEPLOY_PATH/todeploy* file every minute

# Contributors
https://github.com/apalette