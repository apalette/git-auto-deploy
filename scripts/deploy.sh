#! /bin/bash
deploy_path="YOUR_DEPLOY_PATH"
deploy_log=$deploy_path"log"
cd $deploy_log
while IFS='' read -r line || [[ -n "$line" ]]; do
	if [ -n "$line" ]; then
		path=$(echo $line | cut -d: -f1)
		branch=$(echo $line | cut -d: -f2)
		repo_dir=$path"repo.git"
		web_root_dir=$path"code"
		#log_file=$path"log/deploy_log"
		cd $repo_dir
		git fetch origin $branch:$branch 2>&1
		cmd="git rev-parse --short "
		cmd+=$branch
		commit_hash=$($cmd)
		now="$(date +'%d/%m/%Y %H:%M')"
		#echo "$now - Deployed branch: $branch - Commit : $commit_hash" >> $log_file
		GIT_WORK_TREE=$web_root_dir git checkout -f $branch
	fi
done < "deploy_log"
cd $deploy_log
echo "" > 'deploy_log'