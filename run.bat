@echo off						
arp -d *						


del mac-list2.txt					
del mac-list3.txt


FOR /L  %%i IN (100,1,115) DO ping -n 1 -w 2 192.168.1.%%i		
arp -a > mac-list2.txt
 
for /f "skip=3 tokens=2" %%a in (mac-list2.txt) do (
	echo %%a	
) >> mac-list3.txt


SET PATH=%PATH%;D:\xampp\php
php p1.php						
 