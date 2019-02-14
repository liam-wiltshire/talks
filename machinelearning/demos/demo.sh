#!/bin/bash

FILES=();

for file in *; do
	if [ -d $file ]; then
		FILES+=($file);
	fi;
done;


function promptDemo {
	x=0;
	for file in ${FILES[@]}; do
		echo "[$x] - $file";
		((x++));
	done;
	echo "";
	echo "Select Which Demo To Run:";
	read demo;
	return $((demo));
}

while [ 1 ]; do
	promptDemo;	
	demoName=${FILES[$?]};
	echo "";
	echo "Starting $demoName...";
	cd $demoName;
	./doDemo.sh;
	echo "";
	echo "Done. Hit return to continue...";
	read anykey;
	cd ../
	echo "";
	echo "";	
done;
