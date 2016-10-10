import OpenOPC
import sys

#input
plcPosition=sys.argv[1]
value=sys.argv[2]

#display
print "[+] PLC Position:",plcPosition,"<br>"
print "[+] New Value:",value,"<br>"

#connect to opc
plc='Matrikon.OPC.Simulation.1'
try:
	print "[+] Connecting to PLC...",
	opc=OpenOPC.client()
	opc.connect(plc)
	print "		Success!<br>"
except:
	print "Error connecting to OPC<br>"

writing=(plcPosition,value)
print "[+] Writing "
print writing,"<br>"
#test: results=opc.write([('Triangle Waves.Real4',10.0),('Random.String',20.0)]) '''
results=opc.write([writing]) 	

#display how many results
print "[+] Results: ",results,"<br>"
print "<hr><a href=setpoints.php>GO BACK</a>";
