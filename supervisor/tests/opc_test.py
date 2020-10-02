import OpenOPC
opc = OpenOPC.client()
opc.connect()
print(opc['Square Waves.Real8'])
opc.close()
