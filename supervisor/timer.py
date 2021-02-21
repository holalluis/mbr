"""
  Use supervisor library to Read PLC each 10 seconds and insert values to mysql DB
"""
import os
import time
import supervisor
import sys

# set sample time (seconds)

sampleTime = 10

# connect to plc and mysql
try:
    [opc,cursor] = supervisor.connect()
except:
    print("Error Values not loaded from Supervisor")

print("+----------------+")
print(f"| Recording PLC to MySQL | Sample Time: {sampleTime} seconds")
print("+----------------+")

if sys.platform.find('win') == 0:
    clear = 'cls'
else:
    clear = 'clear'

i = 0
while True:

    try:
        opcState = opc.ping()  # check connection
    except type(opcState) != int or type(opcState) != float:
        print(' [!] ERROR not connected to PLC. Exiting...')

    print(f" === New Reading: {time.asctime()}")  # display time

    # iterate device types that we want to store
    deviceTypes = ['Sensor','Alarm','Equipment','Setpoint']
    supervisor.readAndStore(cursor,opc,deviceTypes)

    print(f" [+] Sleeping {sampleTime} seconds...\n\n")
    time.sleep(sampleTime)

    i = i+1

    if i == 5:
        os.system(clear)
        i = 0
