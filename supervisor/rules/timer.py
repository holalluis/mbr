# a script that calls the rules created and added into the DB every time desired and executes them one by one

# Libraries used
import os
import time
import MySQLdb

# Infinite loop
while(True):

    # Get the list of the files in the folder (maybe change it to read if a new rule is added)
    files = os.listdir(os.getcwd())
    db = MySQLdb.connect("localhost", "MarcJulian", "123456", "prova")         # Connect and name it DB
    # Create the object cursor to execute the SQL command
    cursor = db.cursor()
    # Executes the query
    cursor.execute("SELECT Name FROM Rules WHERE Active=1")
    # Saves the name from the rules to use it
    names = cursor.fetchall()
    # Gets the timer time from the DB
    cursor.execute("SELECT * FROM rules_sample_time WHERE id=1")
    for row in cursor:
        sample_time=row[1]
    # Goes through every name
    for name in names:
        # Goes through every file name
        for file in files:
            # If the names from the DB and files are the same
            if (name[0]+".py" == file):
                # It tells which one is executing
                print "Executing",name,"..."
                # And it executes it
                os.system(name[0]+".py")
    # Deletes the cursor
    cursor.close()
    #Close the DB connection
    db.close()

    print "Waiting",sample_time,"seconds..."
    # Waiting time
    time.sleep(sample_time)
