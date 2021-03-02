"""
 SuperVisor Library
 Module to retrieve data from a PLC and store records to a MySQL DataBase
"""
import mysql.connector
from mysql.connector import errorcode
import pymysql

print("+----------------------------+")
print("| S U P E R V I S O R - v0.2 |")
print("+----------------------------+")

def connect():
    """
    return 2 connection objects: "opc" and "cursor"
    """
    # PLC
    plc = 'OMRON.OpenDataServer.1'

    # MYSQL
    server = '127.0.0.1'
    user = 'root'
    pasw = ''
    dbName = 'test'
    try:
        print("| - Connecting to MySQL... | "),
        db = pymysql.connect(server, user, pasw, dbName)
        cursor = db.cursor()
        print("	Success!")
    except:
        print("Error connecting to MySQL")

    print("+------------+")
    return [cursor]

connect()

'''

def connect():
 """
 return 1 connection object: "cursor"
 connection to MySQL
 """

 try:
     user = 'root'
     password = ''
     host = '127.0.0.1'
     database = 'test'


     config = {
         'user': user,
         'password': password,
         'host': host,
         'database': database,
         'raise_on_warnings': True
     }

     cursor = mysql.connector.connect(**config)
     return [cursor]

 except mysql.connector.Error as err:
     if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
         print("Something is wrong with your user name or password")
     elif err.errno == errorcode.ER_BAD_DB_ERROR:
         print("Database does not exist")
     else:
         print(err)

connect()




def readAndStore(cursor,opc,deviceTypes):
    """
    wrapper fx for getDevices(), readPLC() and storeResults()
    """
    devices = getDevices(cursor, deviceTypes)   # get devices
    results = readPLC(opc, devices)				# read plc
    storeResults(cursor, results)				# store results


def getDevices(cursor,deviceTypes):
    """ return a list of devices of the specified type
                cursor: 	mysql connection object
            deviceTypes: 	array of types (strings) e.g. ('Sensor','Equipment','Alarm')
    """

    # filter string for mysql query e.g. "type in ('Sensor','Equipment','Alarm')"
    typeFilter = str(deviceTypes).replace('[','(').replace(']',')')

    # MySQL Query
    sql = f"SELECT * FROM devices WHERE type in {typeFilter} AND plcPosition!=''"
    queryResult = cursor.execute(sql)
    devices = cursor.fetchall()

    # display info
    print(f"	[+] Getting PLC addresses from  {', '.join([str(d)+'s' for d in deviceTypes])}")
    # ugly line that transforms deviceTypes to make it look good (merges devices from deviceTypes with a (,))

    print(f"Found {queryResult} addresses")

    return devices


def readPLC(opc,devices):
    """ returns a list values read from plc
            opc: plc connection object
            devices: list of devices ( from getDevices() )
    """
    # group all plc positions from devices in a single array
    plcPositions = []
    for device in devices:
        plcPositions.append(device[2])  # plcPosition is column num 2

    # read plc
    results = opc.read(plcPositions)
    if results:
        print(f"		Reading PLC:		{len(results)} values read")
    else:
        print("		No results!")

    return results


def storeResults(cursor,results):
    """ void
        insert results to database
            cursor: mysql connection object
            results: list of results (from readPLC())
    """
    for result in results:  # result is (plcPosition,value,quality,date)
        plcPosition = result[0]
        value		= result[1]
        quality	  	= result[2]  # not used
        date		= result[3]  # not used

        # if value is None, means error
        if value is None:
            value = random.random()  # todo

        # find device id
        sql = f"SELECT id FROM devices WHERE plcPosition= {plcPosition} "
        cursor.execute(sql)
        id_device = cursor.fetchall()[0][0]

        # insert new reading
        sql = f"INSERT INTO readings (id_device,value) VALUES ({id_device},{value}); "
        queryResult = cursor.execute(sql)
        if not queryResult:
            print("ERROR! value not inserted")

print(f"		Storing to MySQL: {len(results)} readings inserted")
'''