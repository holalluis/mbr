''' 
	Use supervisor library to Read PLC each 10 seconds and insert values to mysql DB
'''
import time
import supervisor

#set sample time (seconds)
sampleTime=10 

#connect to plc and mysql
[opc,cursor]=supervisor.connect() 

print "+------------------------+"
print "| Recording PLC to MySQL | Sample Time: %s seconds" % sampleTime
print "+------------------------+"

while True:
	opcState = opc.ping() #check connection
	if not(opcState): print ' [!] ERROR not connected to PLC. Exiting...'; break;

	print "	=== New Reading: %s" % (time.asctime()) 	#display time 

	#iterate device types that we want to store
	deviceTypes=['Sensor','Alarm','Equipment','Setpoint']
	supervisor.readAndStore(cursor,opc,deviceTypes)

	print "	[+] Sleeping %s seconds...\n\n" % (sampleTime)
	time.sleep(sampleTime)
