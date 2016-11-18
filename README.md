# MBR

Projecte en desenvolupament

MBR (nom provisional) és una web app que llegeix una base de dades de sensors connectats a un PLC.

El mòdul "supervisor" (fet amb Python) s'encarrega de llegir el PLC contínuament i omplir la base de dades.

```

 +---------+   +-----+    +------------+    +---------------+    +---------+
 | Sensors |-->| PLC |<-->| Supervisor |<-->| Base de Dades |<-->| Web MBR | <-- Usuari
 +---------+   +-----+    +------------+    +---------------+    +---------+

```

### TO DO
* Poder exportar a Excel múltiples calculations
* Poder editar camps Devices
* A New device: tipus offline plc position N/A desactivar
* A New device tipus manual (offline): comprovar si a problems els detecta, i si és així, treure'ls, pq no són problems
* A Offline nou reading: comprovar si la hora ja existeix, per avisar l'usuari
* L'arxiu sql.php: és insegur, cal un warning per comandes INSERT
* L'arxiu sql.php: canviar comportament delete
* Rules	(més endavant)
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
