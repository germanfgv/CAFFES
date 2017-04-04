<?php
// incluir los servicios de la base de datos
include 'ConnectDataBase.php'; 

//declaración de una clase que define los parametros del flujo de la navegacion
class navegacion
{
	public $UserID=NULL;
	public $UserName='';
	public $Logged=false;
	public $ActionList=[];
	public $ActionSel='';
	public $CordList=[];
	public $CordSel='';
	public $RemoteList=[];
	public $RemoteSel='';
	public $RemoteID=NULL;
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

	//setea el nombre de usuario en 
	public function setUserID($id) {
		$this->UserID=$id;
	}
	
	//busca en la base de datos el ID del usuario
	public function getUserID() {
		return $this->UserID;
	}
	
	//configura el nombre de usuario en la clase
	public function setUserName($name) {
		$this->UserName=$name;
	}
	
	//Devuelve el valor del nombre de usuario
	public function getUserName(){
		return $this->UserName;
	}
		
	//busca en la base de datos los permisos a los que tiene un usuario en función de la acción que va a efectuar
	public function getActionList() {
			$this->ActionList=queryActionList($this->UserName);
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
		$this->CordList=querryCordinator($this->UserName, $this->ActionSel);
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
		$this->RemoteList=queryRemoto($this->ActionSel,$this->CordSel);
	}
	
	public function getRemList() {
		return $this->RemoteList;
	}
	
	public function setRemSel($rem) {
		$this->RemoteSel=$rem;	
	}
	
	public function getRemSel() {
		return $this->RemoteSel;
	}
	
	public function setRemID($rem) {
		$this->RemoteID=$rem;	
	}
	
	public function getRemID() {
		return $this->RemoteID;
	}
		
	public function setVarList() {
		$this->VariableList=queryVariable($this->RemoteSel,$this->RemoteID);	
	}
	
	public function getVarList() {
		return $this->VariableList;
	}
}
?>