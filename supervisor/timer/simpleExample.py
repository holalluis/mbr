''' TUTORIAL opc and mysql
'''
import supervisor

#create opc (plc) and cursor (mysql) connection objects
[opc,cursor]=supervisor.connect() 	

#how to read plc positions
print opc.read(['Triangle Waves.Real8','Triangle Waves.Real16'])

#read mysql db and show devices table
sql="SELECT * FROM devices LIMIT 10"
res=cursor.execute(sql)
readings=cursor.fetchall()
for r in readings: print r
