# This script is the rule according to a table where measuring the feed EC and temperature
# Gives a value to the RO permeate flow setpoint and RO feed flow setpoint.

# Loads the OPC connection script
from loadOPC import *

# Read Feed EC [AutoGen_D7012]& Read Feed Temperature [AutoGen_D7014]
tags_inputs = ['AutoGen_D7012','AutoGen_D7014']
inputs = opc.read(tags_inputs, group='rule1')
# Save the values in variables
cond = inputs[0][1]
temp = inputs[1][1]

# RO permeate flow setpoint (Qp) [AutoGen_D5006]
PermeateFlow = 'AutoGen_D5006'
# RO feed flow setpoint (Qf) [AutoGen_D]
FeedFlow = 'AutoGen_D'

print "Comprovant valors de temperatura i conductivitat..."
# If temps is less thant 10C or 10C
if(temp <= 10):
    # If the conductivity is less or equal to 1000
    if(cond <= 1000):
        Qp = 1
        Qf = 1

    # If the conductivity is >1000 and less or equal to 1350
    elif(cond > 1000 and cond <= 1350):
        Qp = 2
        Qf = 2

    # If the conductivity is >1350 and less or equal to 1600
    elif(cond > 1350 and cond <= 1600):
        Qp = 3
        Qf = 3

    # If the conductivity is >1600
    elif(cond > 1600):
        Qp = 4
        Qf = 4


# If temp is between >10C and 14C
elif (temp > 10 and temp <= 14):
    # If the conductivity is less or equal to 1000
    if(cond <= 1000):
        Qp = 1
        Qf = 1

    # If the conductivity is >1000 and less or equal to 1350
    elif(cond > 1000 and cond <= 1350):
        Qp = 2
        Qf = 2

    # If the conductivity is >1350 and less or equal to 1600
    elif(cond > 1350 and cond <= 1600):
        Qp = 3
        Qf = 3

    # If the conductivity is >1600
    elif(cond > 1600):
        Qp = 4
        Qf = 4


# If temp is between >14C and 20C
elif (temp > 14 and temp <= 20):
    # If the conductivity is less or equal to 1000
    if(cond <= 1000):
        Qp = 1
        Qf = 1

    # If the conductivity is >1000 and less or equal to 1350
    elif(cond > 1000 and cond <= 1350):
        Qp = 2
        Qf = 2

    # If the conductivity is >1350 and less or equal to 1600
    elif(cond > 1350 and cond <= 1600):
        Qp = 3
        Qf = 3

    # If the conductivity is >1600
    elif(cond > 1600):
        Qp = 4
        Qf = 4


# If temp is >20C
elif (temp > 20):
    # If the conductivity is less or equal to 1000
    if(cond <= 1000):
        Qp = 1
        Qf = 1

    # If the conductivity is >1000 and less or equal to 1350
    elif(cond > 1000 and cond <= 1350):
        Qp = 2
        Qf = 2

    # If the conductivity is >1350 and less or equal to 1600
    elif (cond > 1350 and cond <= 1600):
        Qp = 3
        Qf = 3

    # If the conductivity is >1600
    elif(cond > 1600):
        Qp = 4
        Qf = 4

opc.write([(PermeateFlow, Qp), (FeedFlow, Qf)])
# Close OPC connection
opc.close()