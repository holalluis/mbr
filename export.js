function export2CSV(id)
/*Generate a CSV file with the table id created and automatically download it*/
{
	var t = document.getElementById(id)
	var csv=""
	for(var i=0;i<t.rows.length;i++)
	{
		for(var j=0;j<t.rows[i].cells.length;j++)
		{
			csv += t.rows[i].cells[j].textContent+";"
		}
		csv+="\r\n"
	}
	//create a link and click it
	var a = document.createElement('a');
	a.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
	a.target = '_blank';
	a.download = 'export.csv';
	document.body.appendChild(a);
	a.click();
}
