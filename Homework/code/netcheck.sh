#!/bin/bash
# First find the names of all the network interfaces.  
# the location can be different depending on the Linux 

# For this exercise im using a MAC so "I'll genetate a list 
# using networksetup -listallhardwareports

# There were no instruction in what to do in the case or up or down
# Just add to the "case r2" switches to cal other actions 
# like sending out an email notice or retrying

exec /usr/sbin/networksetup -listallhardwareports | while read -r a; 
do 
	r=$(echo $a | awk -F':' '{ print $2 }' ;)
	case $a in
    		Hardware* )
			echo "Hardware Port: $r " ;
		;;
    		Device* )
			r2=$(ifconfig $r 2> /dev/null ) ;
			case $r2 in
				*UP* ) echo "Device $r is UP" ;;
				*DOWN* ) echo "Device $r is DOWN" ;;
			* ) echo "Device $r has an unknown state" ;;
		esac
	;;
	esac
done
