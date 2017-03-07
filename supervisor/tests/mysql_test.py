import MySQLdb
server='127.0.0.1'
user='root'
pasw=''
dbName='mbr'
db=MySQLdb.connect(server,user,pasw,dbName)
cursor = db.cursor()
