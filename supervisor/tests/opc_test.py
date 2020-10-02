import OpenOPC
opc = OpenOPC.client()
opc.connect('Matrikon.OPC.Simulation.1')
print(opc['Square Waves.Real8'])
opc.close()
