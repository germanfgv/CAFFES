<?php
// incluir los servicios de la base de datos
include 'ConnectDataBase.php'; 
//definciones
define('USCO_ID',0001);
define('FINCA_ID',0002);
//declaración de una clase que define los parametros del flujo de la navegacion
class navegacion
{
	public $UserID=0;
	public $Logged=false;
	public $ActionList=[];
	public $ActionSel='';
	public $CordList=[];
	public $CordSel='';
	public $RemoteList=[];
	public $RemoteSel='';
	public $VariableList=[];
	public $VariableSel='';
	
	//muestra si estado de validación de registro del usuario
	public function getLog() {
		return $this->Logged;
	}
	//pone el valor de log /activado/desactivado dentro del objeto
	public function setLog($value) {
		$this->Logged=$value;
	}

	//busca en la base de datos el ID del usuario
	public function setUserID($id) {
		$this->UserID=$id;
	}
	
	//busca en la base de datos el ID del usuario
	public function getUserID() {
		return $this->UserID;
	}
	
	//busca en la base de datos los permisos a los que tiene un usuario en función de la acción que va a efectuar
	public function getActionList() {
		if(($this->UserID)==USCO_ID) {
			$this->ActionList=['download','upload'];
		}
		elseif(($this->UserID)==FINCA_ID) {
			$this->ActionList=['upload'];	
		}
		return $this->ActionList;
	}
	
	// pone en el campo de ActionSel la variable que seleccióno el usuario en el formulario
	public function setActionSel($action) {
		$this->ActionSel=$action;
	}
	
	// devuelve el valor de la accion que selecciono de la lista anterior
	public function getActionSel() {
		return $this->ActionSel;
	}
	
	public function setCordList() {
		$this->CordList=querryCordinator($this->UserID,$this->ActionSel);
	}
	
	public function getCordList(){
		return $this->CordList;	
	}
	
	public function setCordSel($cordinator){
		$this->CordSel=$cordinator;
	}
	
	public function getCordSel() {
		return $this->CordSel;
	}

	public function setRemList() {	
	}
	
	public function getRemList() {
	}
		
	public function setVarList() {	
	}
	
	public function getVarList() {
	}
}


//Permite hace una validación al formulario de registro
function validar($nombre, $clave) {
	$cmp=false;
	$mysql=connect_database(); //socilita la conexion a la base de datos	
	if ($mysql){
		$query="SELECT UsuarioName, Password FROM Usuarios";
		$result=mysqli_query($mysql, $query);
		while($row=mysqli_fetch_row($result)){//busca en los valores a los que se les ha hecho el fetch
			if((strcmp($row[0], $nombre)==0)&&(strcmp($row[1], $clave)==0)) {
				$cmp=true; // si enceuntra la combinacion de usuario y contraseña se pone en "true";
			}
		}
	}
	mysqli_close($mysql);	
	return $cmp;
}


// asocia un ID a un nombre de Usuario Determinado
function querryID($user) {
		$id=0; // inicializa la variable ID, la idea es buscarlos en base de datos
		if (strcmp($user, 'usco')==0){
			$id=USCO_ID;	
		}
		elseif(strcmp($user, 'finca')==0) {
			$id=FINCA_ID;		
		}
		return $id;
	}
function querryCordinator($id, $action) {
	$list=[];	
	if(($id==USCO_ID)&&($action=="download")){
			$list=['Cord01','Cord02','Cord03'];
	}
	elseif(($id==USCO_ID)&&($action=="upload")) {
		$list=['Cord02','Cord03'];
	}
	elseif(($id==FINCA_ID)&&($action=="download")) {
		$list=[];
	}
	elseif(($id==FINCA_ID)&&($action=="upload")) {
		$list=['Cord01'];
	}
	return $list;		
}

function queryRemoto($id,$action,$cord){
	$list=[];
		switch($id) {
			case FINCA_ID:
				switch($action) {
					case "download":
						$list=['Suelos01','Tanques01'];
					break;
					case "upload":
						$list=[];
					break;
				}
			break;
			case USCO_ID:
				switch($action) {
					case "download":
						switch($cord) {
							case "Cord01":
								$list=['Suelos01','Tanques01','Amb01'];
							break;
							case "Cord02":
								$list=['Suelos02','Tanques02','Amb03'];
							break;
							case "Cord03":
								$list=['Suelos03','Tanques03'];
							break;
						}
					break;
					case "upload":
						switch($cord) {
							case "Cord01":
								$list=[];
							break;
							case "Cord02":
								$list=['Suelos02','Tanques02'];
							break;
							case "Cord03":
								$list=['Suelos03','Tanques03'];
							break;
						}						
					break;
				}
			break;
		}	
	return $list;
}

function ActionMask($action){
	$string="";
	if(strcmp($action, "download")==0){
		$string="Descargar datos";
	}
	elseif(strcmp($action, "upload")==0) {
		$string="Ingresar datos";
	}
	else {
		$string="";
	}
	return $string;	
}
?>