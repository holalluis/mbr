# MBR

## Manual en desenvolupament

### TO DO
* NEXT: exportar arxiu.sql amb estructura base de dades
* Arxiu 'config': per base de dades i direcció del PLC. Exemple:

```
[MySQL]
	host= "127.0.0.1"
	user= "root"
	pass= ""
	ddbb= "mbr"
[OPC]
	plc='Matrikon.OPC.Simulation.1'
```

* New device: tipus offline plc position N/A desactivar
* New device tipus manual (offline): comprovar si a problems els detecta, i si és així, treure'ls, pq no són problems
* Offline nou reading: comprovar si la hora ja existeix, per avisar l'usuari
* sql.php: és insegur, cal un warning per comandes INSERT
* sql.php: canviar comportament delete


* Rules	(més endavant)
