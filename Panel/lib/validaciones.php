<?php
function validarFecha($pFecha){

// Comprobar que una cadena tiene una estructura conforme 
// a la de una fecha en formato [D]D/[M]M/AAAA y recuperar 
// los tres componentes: día, mes y año. 
//	$patrón = ’#ˆ([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})$#’; 


// Utilización de preg_match. 

//	$ok = (preg_match($patrón,$pFecha,$resultado) > 0); 
//	if ($ok) { 
		    //TODO Fecha valida 
		
//	} else { 
		//TODO Fecha no valida
//	} 


// aqui se debe comprobar con checkdate que los valores se corresponden con una fecha valida

}	
function validaFormatoImagen($pFormato){
		return $okFormatoImagen =  (($pFormato=="image/jpeg") || ($pFormato=="image/png"))?true:false;
}
function validarCorreo(){

/*
*    ^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$  
*    
*    /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
*    Descripción: Con el acento circunflejo (^) indicamos que debe empezar a buscar 
*    al comienzo del String. En el primer grupo buscamos caracteres alfanuméricos  guión, 
*    guión bajo y puntos; con el signo de más (+) indicamos que el grupo que lo precede debe 
*    aparecer por lo menos una vez. A continuación colocamos el arroba y creamos un segundo grupo 
*    buscará  caracteres alfanuméricos, puntos o guiones. \. nos indica que debe haber un punto. 
*    En el tercer grupo buscaremos caracteres alfabéticos y puntos que tengan entre 2 y 6 caracteres.	
*/
}

function validarContrasenha($pDato){
/*
 * patron PASSWORD
 * 
 * REQUIERE UNA cadena CON UN MINIMO DE 6 Y UN MAXIMO DE 10, 
 * DEBE CONTENER COMO MINIMO UNA MINUSCULA, NUMERO, CARACTER ESPECIAL Y
 * NO PUEDE CONTENER SALTO DE LINEA
 * ?= aserción hacia delante Exito si el patrón ecnuentra una coincidencia a la derecha
 * ?! aserción hacia delante negativa
 * (?=.*\d) al menos un numero
 * (?=.*\W) al menos un caracter que no es un caracter de palabra
 * (?=.*[a-z]) al menos una minuscula
 * (?![.\n]) no contenga un retorno de linea
 * (?=^.{8,15}$) de 8 a 15
 */

$patron ="/(^(?=.*\d)(?=.*\W)(?=.*[a-z])(?![.\n])(?=^.{6,10}$).+$)/"; 

return $ok = ((preg_match($patron,$pDato) == 0))?false:true;

}
function validarAlias($pDato){
	
/*
 * patron alias
 * 
 * REQUIERE UNA cadena CON UN MINIMO DE 3 Y UN MAXIMO DE 15, 
 * puede CONTENER  LETRAS MAYUSCULAS, MINUSCULAS, NUMEROS, "-" Y "_"
 * 
 */
$patron ="/^[a-zA-Z0-9_-]{3,15}$/" ;  

return $ok = ((preg_match($patron,$pDato) == 0))?false:true;	
}
function validarNombreUsuario($pDato){
	

/*
 * patron nombre
 * 
 * REQUIERE UNA cadena CON UN MINIMO DE 3 Y UN MAXIMO DE 25, 
 * puede CONTENER  LETRAS MAYUSCULAS, MINUSCULAS, acentuadas minusculas y "ñ"
 * 
 */


$patron ="/^[A-Za-záéíóúñ]{3,25}$/" ;  

return $ok = ((preg_match($patron,$pDato) == 0))?false:true;	
}

function validarNombre($pDato){


	/*
	 * patron nombre
	 *
	 * REQUIERE UNA cadena CON UN MINIMO DE 3 Y UN MAXIMO DE 50,
	 * puede CONTENER  LETRAS MAYUSCULAS, MINUSCULAS, acentuadas minusculas y "ñ"
	 *
	 */


	$patron ="/^[A-Za-záéíóúñ ]{3,50}$/" ;

	return $ok = ((preg_match($patron,$pDato) == 0))?false:true;
}


function validarTexto(){
	
}
?>