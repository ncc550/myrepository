#!/bin/bash
# for this exercise, it is assumed that the foobar service is already installed on the servers
# and that the calling server user has the correcta user  privlidges to restart the service
# i.e. keygen, sshpass, etc.
# If prilidges are not correct,  you can use 'expect' scripts (also if sudo is needed)
# Since this is Ubuntu Linux we will assume the foobar control script lives in /etc/init.d
# however "service foobar restart" may be available (see commented command)
# It is also assumed ssh is set up correctly

cat machines_list.txt | while read -r a; 
do 
	# for debugging i commented out the actual code
	echo "ssh user@$a /etc/init.d/foobar restart" ;
	# ssh user@$a /etc/init.d/foobar restart
# ****OR****
	# ssh user@$a service foobar restart ;

done

