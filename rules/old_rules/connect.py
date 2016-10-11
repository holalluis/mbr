
# Import library to link Python to MYSQL
import MySQLdb
# Libraries for time
import time
while True:
    try:
        # Create a variable for the time
        localtime = time.asctime(time.localtime(time.time()))

        # Connect to the DB ("host", "username", "password", "db_name")
        host = 'localhost'                                          # Where the host is (local or internet)
        username = 'MarcJulian'                                       # user name to get into the DB
        password = '123456'                                         # Password to get into the DB
        db_name = 'prova'                                           # DB name
        db = MySQLdb.connect(host, username, password, db_name)     # Connect and name it DB

        # Create the object cursor to execute the SQL command
        cursor = db.cursor()
        break
    except MySQLdb.Error:
        print "Error connectant a la base de dades. Try again!"


# Connect to the OPC server
import OpenOPC                          # Imports the OpenOPC library
opc = OpenOPC.client()                  # Opens the client
server = 'Matrikon.OPC.Simulation'      # Choose the server
opc.connect(server)                     # Connect to server

