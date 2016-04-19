# Synopsis
Git Auto Deployment on dedicated server
# Setting up your project with git
1. Create your project with the following architecture :
YOUR_PROJECT_PATH
	/code
	
2. Navigate into YOUR_PROJECT_PATH and clone your repository with --mirror option
	```
 	ls YOUR_PROJECT_PATH
 	git clone --mirror https://github.com/apalette/git-auto-deploy.git
 	```
 		
3. Rename the repository copy as "repo.git" and navigate into it
	Now YOUR_PROJECT_PATH must contain 2 folders :
		- code
		- repo.git 
		
4. Get code latest copy and set it into code
	```
	GIT_WORK_TREE=YOUR_PROJECT_PATH/code git checkout -f
	```
		
# Setting up auto-deployment
1. Install git-auto-deploy script on the same server and configure "/www" path as DocumentRoot
	```
	<VirtualHost *:80>
	     ServerName deploy.mywebsite.com
	     DocumentRoot "YOUR_DEPLOY_PATH/www"
	     php_admin_value open_basedir "YOUR_PROJECT_PATH:/tmp"
	</VirtualHost>
	```

2. Edit config.php with allowed IPs and create a key for your project
	```
	<?php 
	define ('DEPLOY_IPS', serialize(array(
		/**
		 * Bitbucket
		 */
		'131.103.20.160/27',
	    '165.254.145.0/26',
		'104.192.143.0/24'
	)));
	?>
	```


# Contributors
https://github.com/apalette