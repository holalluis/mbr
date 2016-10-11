<?php /* functions for evaluating calculations' formulas */

function idsPerFormula($formula)
/*
	return array of integers corresponding to ids matched in formula string
	example: "[#id1]+[#id56]/[#id89]" returns [1,56,89]
*/
{
	preg_match_all('/\[#id\d+\]/',$formula,$matches); 
	$matches=$matches[0]; //matches fa una matriu 3d on el primer index es el caracter inicial, aqui ens interessa el 0 (tot l'string)
	$ids=[];
	foreach($matches as $m)
	{
		$ids[]=preg_replace("/\[#id(\d+)\]/","$1",$m);
	}
	return array_unique($ids);
}

function applyFormula($formula,$values)
/*evaluate the formula with the given $values (readings)*/
{
	$rawFormula=$formula;
	$ids=idsPerFormula($formula);
	$i=0;
	foreach($ids as $id)
	{
		if($values[$i]=="")return null;
		$formula=preg_replace("/\[#id$id\]/"," ".$values[$i++]." ",$formula);
	}
	$result=eval("return $formula;") or die("<b style=color:red>ERROR IN FORMULA '$rawFormula'</b>");
	return $result;
}

?>
