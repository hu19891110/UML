<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


global $faults;
global $GRADE;
//-----------Puntenaftrek------------
global $ModelIsNietAanwezig; //er ontbreekt een classe in de handed-in model (of de naam is verkeerd)

global $RelatieNaamAnders;
global $RelatieHeeftAnderBegin;
global $RelatieHeeftAnderEind;
global $RelatieAndereSoort;
global $RelatieMPFout; //er is een fout gemaakt bij de multiplicity van een relatie, danwel bij het begin danwel bij de eindbestemming

global $DatatypeAttribuutFout;
global $DataTypeParameterFout;
global $ParameterMissing;
global $OperationMissing;
global $AttribuutMissing;

global $StereotypeFout;
global $returnTypeFout;

global $OperatieVariabelenFout; //(leaf/scope/unique/visibility/static) waarde * aantalvarsfout = totale_aftrek
global $AttribuutVariabelenFout; //(leaf/scope/unique/visibility/static) waarde * aantalvarsfout = totale_aftrek
//-----------Puntenaftrek------------



class Checker 
{
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->model('flexi_auth_lite_model');
		
		/*
		// Validate login credentials on every page load if set via config file.
		if ($this->is_logged_in() && $this->CI->login->auth_security['validate_login_onload'] && !isset($this->CI->flexi_auth_lite_model->auth_verified))
		{
			$this->CI->flexi_auth_lite_model->validate_database_login_session();
		}
		// Auto log in the user if they have 'Remember me' cookies.
		else if (!$this->is_logged_in() && get_cookie($this->CI->login->cookie_name['user_id']) && 
			get_cookie($this->CI->login->cookie_name['remember_series']) && get_cookie($this->CI->login->cookie_name['remember_token']))
		{
			$this->CI->load->model('flexi_auth_model');
			$this->CI->flexi_auth_model->login_remembered_user();
		}
		*/
	}


	function checkFile($correctfile, $handed_in_file) {
		$config['upload_path'] = './uploads/';
		
		$correctfile = file_get_contents('./uploads/' . $correctfile);
		$correctfile = simplexml_load_string($correctfile);
		
		$handed_in_file = file_get_contents('./uploads/' . $handed_in_file);
		$handed_in_file = simplexml_load_string($handed_in_file);
		
		$this->checkModels($correctfile, $handed_in_file);
	
	}
	
	/***
	Checks if the Classes are compared with eachother and goes deeper in each time
	***/
	function checkModels($xml, $xml2) {
		foreach($xml->Models->Package->ModelChildren->Class as $class1) { // goes through all models that should exist.
			if($this->classExists($class1, $xml2)) {
				foreach($xml2->Models->Package->ModelChildren->Class as $class2) { // dieper in klassen gaan als ze met elkaar overeenkomen
					if((string)$class1->attributes()->Name == (string)$class2->attributes()->Name) { 
						if(isset($class1->Stereotypes) && isset($class2->Stereotypes)) {
							if(!((string)$class1->Stereotypes->Stereotype->attributes()->Name == (string)$class2->Stereotypes->Stereotype->attributes()->Name)) {
								$this->faults = $this->faults . 'Het Stereotype van ' . (string)$class1->attributes()->Name . ' komt niet overeen<br />';
								$this->GRADE = $this->GRADE - $this->StereotypeFout;
							}
						}
					
						if($class1->ModelChildren->Attribute != NULL) {
							$this->checkAttributes($class1, $class2);
							
						} 
						
						if($class1->ModelChildren->Operations != NULL) {
							$this->checkOperations($class1, $class2);
						}
					}
				}
			} else {
				$this->faults = $this->faults . 'The Model: ' . (string)$class1->attributes()->Name . ' is missing in the handed in file.  <font color="red">*Puntenaftrek*</font>  <br />';
				$this->GRADE = $this->GRADE - $this->ModelIsNietAanwezig;
			}
		}
		//echo 'NU GAAN WE RELATIES BEKIJKEN =D' . '<br /><br />';
		$this->checkRelations($xml, $xml2);
	}

	function checkOperations($class1, $class2) {
		$modelChildren1 = $class1->ModelChildren;
		$modelChildren2 = $class2->ModelChildren;
		$arrayElements = array();
		$i = 0;
		foreach($modelChildren1->Operation as $operations1) { // gaat alle operations langs vaingevoerde file
			$i = 0; // telt of element vaker dan een keer voor komt
			if($this->oprExists($operations1, $modelChildren2)) { // operation bestaat ergens in $operations2(wellicht twee keer?) kotm ook 2 keer in
				
				foreach($modelChildren2->Operation as $operations2) { // alle operaties langs gaan van andere file, nu kijken of operation naam overeen komt? naam komt twee x overeen
					
					if((string)$operations1->attributes()->Name == (string)$operations2->attributes()->Name) { // De namene van deo peraties zijn hetzelfde, kijken voor parameters
						$i++;
						if($i > 1) {
							if(!in_array((string)$operations1->attributes()->Name, $arrayElements)) {
								array_push($arrayElements, (string)$operations1->attributes()->Name);
							}
						}
					}
				}
			}
		}
		
		for($j = 0; $j < count($arrayElements); $j++) {
			//echo $arrayElements[$j] . ' komt vaker voor! <br />';
		}
		

		foreach($modelChildren1->Operation as $operations1) {	
			if($this->oprExists($operations1, $modelChildren2)) { // operation bestaat ergens in $operations2(wellicht twee keer?) kotm ook 2 keer in
				
				foreach($modelChildren2->Operation as $operations2) { // alle operaties langs gaan van andere file, nu kijken of operation naam overeen komt? naam komt twee x overeen
					
					if((string)$operations1->attributes()->Name == (string)$operations2->attributes()->Name) { // De namene van deo peraties zijn hetzelfde, kijken voor parameters
						
						if(!empty($operations1->ReturnType) && !empty($operations2->ReturnType)) {
							//$laat = $this->returnTypeExists($operations1->ReturnType, $operations2->ReturnType);
							if(!$this->returnTypeExists($operations1->ReturnType, $operations2->ReturnType)) {
								$this->faults = $this->faults . 'The ReturnType of the operation: ' . (string)$operations1->attributes()->Name . ' is not right<br />';
								$this->GRADE = $this->GRADE - $this->returnTypeFout;
							}
						}
						
						
						
						if(!empty($operations1->ModelChildren) && !empty($operations2->ModelChildren)) { // er zijn parameters
						
							if(!in_array((string)$operations1->attributes()->Name, $arrayElements)) { // Operatie komt maar een keer voor
								foreach($operations1->ModelChildren->Parameter as $parameters1) { 
									if($this->paramExists($parameters1, $operations2->ModelChildren)) {
										foreach($operations2->ModelChildren->Parameter as $parameters2) {
											if((string)$parameters1->attributes()->Name == (string)$parameters2->attributes()->Name) {
												if($this->sameTypeParam($parameters1, $parameters2)) {
													$amount = $this->checkOperation($operations1, $operations2);
													if($amount != 0) {
														$this->faults = $this->faults. ' zijn de waardes die niet overeenkomen met elkaar bij de operatie ' . (string)$operations1->attributes()->Name . ' van de klasse ' . (string)$class1->attributes()->Name . '.' . ' <font color="red">*Puntenaftrek*</font>' . '<br />';
														$this->GRADE = $this->GRADE - $this->OperatieVariabelenFout;
													} else {
														//echo 'Parameter: <strong>' . (string)$parameters1->attributes()->Name . '</strong> From the operation <strong>' . (string)$operations1->attributes()->Name . '</strong> From the Class <strong>' . (string)$class1->attributes()->Name . '</strong> is Okay.<br />';
													}
												} else if( isset($operations1->Type->DataType) && isset($operations2->Type->DataType)) { // KIJKEN OF IE UBERHAUBT WEL EEN DATATYPE HEEFT VOORDAT WE HET FOUT REKENEN
													$this->faults = $this->faults. 'The datatype of the parameter: ' . (string)$parameters1->attributes()->Name . ' is ' . (string)$parameters1->attributes()->Type . ', Which should be ' . (string)$parameters2->attributes()->Type . '  of the operation ' . (string)$operations1->attributes()->Name . ' From the Class ' . (string)$class1->attributes()->Name . ' does not match. <font color="red">*Puntenaftrek*</font>  <br />';
													$this->GRADE = $this->GRADE - $this->DataTypeParameterFout;
												}

											} 
										}
									} else {
										$this->faults = $this->faults. 'Parameter: ' . (string)$parameters1->attributes()->Name . ' is missing in the operation ' . (string)$operations1->attributes()->Name . '.  <font color="red">*Puntenaftrek*</font>  <br />';
										$this->GRADE = $this->GRADE - $this->ParameterMissing;
									}
								}
								
							
							} else { // Operatie komt vaker voor, maar hoe vaak?
							/** OPERATIE NAMEN ZIJN HIER AL HETZELFDE GODVERDOMME dus generate elements
							
							
							
							
							
							
							**/
							
							
								$amountelements = 0;
								foreach($modelChildren1->Operation as $operations3) {
									foreach($modelChildren2->Operation as $operations4) { 
										if( in_array( (string)$operations1->attributes()->Name, $arrayElements ) && in_array( (string)$operations2->attributes()->Name, $arrayElements ) ) {
											$amountelements++;
										}
									}	
								}
								
								
								
								
								$array = array();
								$i = 0;
								$j = 0;
								foreach($operations1->ModelChildren->Parameter as $parameters1) { // count parameters
									$i++;
								}
								
								foreach($operations2->ModelChildren->Parameter as $parameters2) { // count parameters
									$j++;
								}
								
								foreach($operations1->ModelChildren->Parameter as $parameters1) {
									$k = 0;
									if($this->paramExists($parameters1, $operations2->ModelChildren)) {	
										foreach($operations2->ModelChildren->Parameter as $parameters2) { // count parameters
											if((string)$parameters1->attributes()->Name == (string)$parameters2->attributes()->Name) {
												if($this->sameTypeParam($parameters1, $parameters2)) {
													$amount = $this->checkOperation($operations1, $operations2);
													if($amount != 0) {
														$this->faults = $this->faults. ' zijn de waardes die niet overeenkomen met elkaar bij de operatie ' . (string)$operations1->attributes()->Name . ' van de klasse ' . (string)$class1->attributes()->Name . '.  <font color="red">*Puntenaftrek*</font>  <br />';
														$this->GRADE = $this->GRADE - $this->OperatieVariabelenFout;
													} else {
														//echo 'Parameter: <strong>' . (string)$parameters1->attributes()->Name . '</strong> From the operation <strong>' . (string)$operations1->attributes()->Name . '</strong> From the Class <strong>' . (string)$class1->attributes()->Name . '</strong> is Okay.<br />';
													}
												} else { // NOG EVEN DIEPER KIJKEN VOOR TYPE OF DATAYPE MY SHIZZLE DIZZLE NIZZLE
													$k++;
													break;
												}

											} 
										
										}
										
									}
									//echo $k . '<br />';
									if($k == 1) {
	/*2x uitzondering*///					echo '<strong>'. (string)$parameters1->attributes()->Name . '</strong> is incorrect in the handed in file.  <font color="red">*Puntenaftrek*</font> <br />';
									}

								}
								
							}
								
							if($i == $j) {
								
							}
							
						} else { // geen kids
						
						}
					}
				}
			} else {
				$this->faults = $this->faults. 'The operation: ' . (string)$operations1->attributes()->Name . ' From the Class ' . (string)$class1->attributes()->Name . ' is missing in the handed in file.  <font color="red">*Puntenaftrek*</font>  <br />';
				$this->GRADE = $this->GRADE - $this->OperationMissing;
			}			
		}
	}
	
	function returnTypeExists($returntype1, $returntype2) {
		if(isset($returntype1->DataType) && isset($returntype2->DataType)){
			if((string)$returntype1->DataType->attributes()->Name == (string)$returntype2->DataType->attributes()->Name) {
				return true;
			}
		} else if(isset($returntype1->Class) && isset($returntype2->Class)) {
			if((string)$returntype1->Class->attributes()->Name == (string)$returntype2->Class->attributes()->Name) {
				return true;
			}	
			return false;
		}
	}
	
	//RELATIONS CHECKER
	function checkRelations($xml, $xml2){
		foreach($xml->Models->ModelRelationshipContainer->ModelChildren->ModelRelationshipContainer as $container1) {
			foreach($xml2->Models->ModelRelationshipContainer->ModelChildren->ModelRelationshipContainer as $container2) {
				//'speciale' relaties
				
					//TODO
				
				//'normale' relaties
				foreach($container1->ModelChildren->Association as $relatie1) {
					foreach($container2->ModelChildren->Association as $relatie2) {
						
						$naam1 = (string)$relatie1->attributes()->Name;
						$naam2 = (string)$relatie2->attributes()->Name;
						
						
						$from_end1 = $relatie1->FromEnd->AssociationEnd;
						$from_end2 = $relatie2->FromEnd->AssociationEnd;
						$to_end1 = $relatie1->ToEnd->AssociationEnd;
						$to_end2 = $relatie2->ToEnd->AssociationEnd;
						
						//check of het om éénzelfde relatie gaat door de begin- en eindbestemmingen te vergelijken.
						if($this->checkBestemming($from_end1, $from_end2, 'eindbestemming') && $this->checkBestemming($to_end1, $to_end2, 'beginbestemming')) {
							//echo 'Deze relatie komt voor in xml2: <strong>'. $naam1 . '</strong><br />';
							
							//check de naam van de relatie
							if ($naam1 == $naam2){
								//echo 'De relatie '. $naam1 .' heeft in het ingeleverde model <strong>dezelfde</strong> naam.' . '<br />';
							}
							else{
								$this->faults = $this->faults. 'De relatie komt wel voor in het ingeleverde model maar heeft een <strong>andere</strong> naam' . '<br />';
								$this->GRADE = $this->GRADE - $this->RelatieNaamAnders;
							}
							
							//check het soort relatie
							$this->checkSoort($relatie1, $relatie2);
										
							//relatie komt voor in nakijkmodel dus we kijken verder
							
									
							//check of de relatie dezelfde begin- en eindbestemming heeft
							//eindbestemming
							if(!$this->checkBestemming($from_end1, $from_end2)){
								$this->faults = $this->faults. 'Deze relatie heeft NIET dezelfde eindbestemming, <font color="red">*Puntenaftrek*</font>' . '<br />';
								$this->GRADE = $this->GRADE - $this->RelatieHeeftAnderEind;
								
							}
									
							//beginbestemming
							if(!$this->checkBestemming($to_end1, $to_end2)){
								$this->faults = $this->faults. 'Deze relatie heeft NIET dezelfde beginbestemming, <font color="red">*Puntenaftrek*</font>' . '<br />';
								$this->GRADE = $this->GRADE - $this->RelatieHeeftAnderBegin;
							}
							
							//kijken of de relatie dezelfde multipliciteit heeft
							//eindbestemming
							$this->checkMP($from_end1, $from_end2, 'eindbestemming');
									
							//beginbestemming
							$this->checkMP($to_end1, $to_end2, 'beginbestemming');
										
						}//if naamgelijkheid
						else {
	//						echo 'Deze relatienaam: "' . $naam1 . '" komt NIET voor in xml2! OF HET PROGRAMMA HEEFT HET VERGELEKEN MET EEN ANDERE RELATIE' . '<br />';
						}// else naamgelijkheid
					}//foreach xml2	
				}//foreach xml
			}
		}		
	}
	// /RELATIONS CHECKER
	
	function checkSoort($relatie1, $relatie2){
		$direction1 = (string)$relatie1->attributes()->Direction;
		$direction2 = (string)$relatie2->attributes()->Direction;
		if ($direction1 == $direction2){
			//echo 'De relatie is van dezelfde soort' . '<br />';
		}//if direction
		else {
			$this->faults = $this->faults. 'De relatie is NIET van dezelfde soort, <font color="red">*Puntenaftrek*</font>' . '<br />';
			$this->GRADE = $this->GRADE - $this->RelatieAndereSoort;
		}//else direction
	}//checkSoort

	function checkBestemming($end1, $end2){
		$relatie_bestemming1 = (string)$end1->Type->Class->attributes()->Name;							
		$relatie_bestemming2 = (string)$end2->Type->Class->attributes()->Name;
		if($relatie_bestemming1 == $relatie_bestemming2){
			//relatie heeft dezelfde eindbestemming
			//echo 'Deze relatie heeft dezelfde ' . $text . '<br />';
			return true;
		}//if relatie_bestemming
		else {
			return false;
		}//else relatie_bestemming
	}//checkbestemming

	function checkMP($end1, $end2, $text){
		$relatie_eindbestemmingMP1 = (string)$end1->attributes()->Multiplicity;
		$relatie_eindbestemmingMP2 = (string)$end2->attributes()->Multiplicity;
		if($relatie_eindbestemmingMP1 == $relatie_eindbestemmingMP2){
			//relatie heeft dezelfde eindbestemming Multiplicity
			//echo 'Deze relatie heeft dezelfde ' . $text . ' Multiplicity' . '<br />';
		}//if relatie_eindbestemmingMP
		else{
			$this->faults = $this->faults. 'Deze relatie heeft NIET dezelfde ' . $text . ' Multiplicity, <font color="red">*Puntenaftrek*</font>' . '<br />';
			$this->GRADE = $this->GRADE - $this->RelatieMPFout;
		}//else relatie_eindbestemmingMP
	}//checkMP
	//RELATIONS CHECKER	
	
	function checkOperation($operations1, $operations2) {
		// abstract, Leaf, Static, Unique, Scope
		$operations1 = $operations1->attributes();
		$operations2 = $operations2->attributes();
		$i = 0;
		if((string)$operations1->Leaf != (string)$operations2->Leaf) {
			$this->faults = $this->faults. 'Leaf, '; 
			$i++;
		}
		if((string)$operations1->Unique != (string)$operations2->Unique) {
			$this->faults = $this->faults. 'Unique, '; 
			$i++;
		}
		if((string)$operations1->Static != (string)$operations2->Static) {
			$this->faults = $this->faults. 'Static, '; 
			$i++;
		}
		if((string)$operations1->Visibility != (string)$operations2->Visibility) {
			$this->faults = $this->faults. 'Visibility, '; 
			$i++;
		}
		if((string)$operations1->Scope != (string)$operations2->Scope) {
			$this->faults = $this->faults. 'Scope, '; 
			$i++;
		}
		return $i;
	}
		
		
	/**
	Checks all attributes and compares them
	**/
	function checkAttributes($class1, $class2) {
		$modelChildren1 = $class1->ModelChildren; // Dieper gaan om attributen te checken
		$modelChildren2 = $class2->ModelChildren; // Dieper gaan om attributen te checken
			
		foreach($modelChildren1->Attribute as $attributes1) {
			if($this->attrExists($attributes1, $modelChildren2)) { // checken of attribuut bestaat
							
				foreach($modelChildren2->Attribute as $attributes2) {				
					if((string)$attributes1->attributes()->Name == (string)$attributes2->attributes()->Name) { // Dieper attribuut bekijken als naam overeenkomt.
						if($this->sameTypeAttr($attributes1, $attributes2)) { // Checkt of dataTypes hetzelfde zijn.
							$amount = $this->checkAttribute($attributes1, $attributes2);
							if($amount != 0) {
								$this->faults = $this->faults. ' zijn de waardes die niet overeenkomen met elkaar bij het attribuut ' . (string)$attributes1->attributes()->Name . ' van de klasse ' . (string)$class1->attributes()->Name . '.  <font color="red">*Puntenaftrek*</font>  <br />';
								$this->GRADE = $this->GRADE - $this->AttribuutVariabelenFout;
							}
						} else {
							$this->faults = $this->faults. 'Het Datatype van het attribuut ' . (string)$attributes1->attributes()->Name . ' van de klasse ' . (string)$class1->attributes()->Name . ' komt niet overeen.  <font color="red">*Puntenaftrek*</font> <br />';
							$this->GRADE = $this->GRADE - $this->DatatypeAttribuutFout;
						}
					} 
				}
			} else {
				$this->faults = $this->faults. 'The attribute: ' . (string)$attributes1->attributes()->Name . ' From the Class ' . (string)$class1->attributes()->Name . ' is missing in the handed in file.  <font color="red">*Puntenaftrek*</font>  <br />';
				$this->GRADE = $this->GRADE - $this->AttribuutMissing;
			}
						
		}
		
	}
	
	
	function paramExists($parameter1, $modelChildren2) {
		
		$name1 = (string)$parameter1->attributes()->Name;
		
		foreach($modelChildren2->Parameter as $parameter2) {
			$name2 = (string)$parameter2->attributes()->Name;
			if($name1 == $name2 /*&& sameTypeParam($parameter1, $parameter2)*/) {
				return true;
			}
		
		}
		return false;
	}

	/**
	Compare if attributes of attribute match eachother, if so faultss nothing
	elsewise faultss the string of the incorrect type.

	**/
	function checkAttribute($attribute1, $attribute2) {
		// Leaf, Static, Unique, Visibility, Scope
		$attributes1 = $attribute1->attributes();
		$attributes2 = $attribute2->attributes();
		$i = 0;
		if((string)$attributes1->Leaf != (string)$attributes2->Leaf) {
			$this->faults = $this->faults . 'Leaf, '; 
			$i++;
		}
		if((string)$attributes1->Unique != (string)$attributes2->Unique) {
			$this->faults = $this->faults . 'Unique, '; 
			$i++;
		}
		if((string)$attributes1->Static != (string)$attributes2->Static) {
			$this->faults = $this->faults . 'Static, '; 
			$i++;
		}
		if((string)$attributes1->Visibility != (string)$attributes2->Visibility) {
			$this->faults = $this->faults . 'Visibility, '; 
			$i++;
		}
		if((string)$attributes1->Scope != (string)$attributes2->Scope) {
			$this->faults = $this->faults . 'Scope, '; 
			$i++;
		}
		return $i;
		
	}


	/**
	Checks if attributes have the same datatype
	**/
	function sameTypeAttr($attribute1, $attribute2) {
		if(!empty($attribute1->Type) && !empty($attribute2->Type)) {
			if( isset($attribute1->Type->DataType) && isset($attribute2->Type->DataType)){
				if((string)$attribute1->Type->DataType->attributes()->Name == (string)$attribute2->Type->DataType->attributes()->Name) {
					return true; // attributen hebben een standaard datatype
				} 
			} else if(isset($attribute1->Type->Class) && isset($attribute2->Type->Class)) {
				if((string)$attribute1->Type->Class->attributes()->Name  == (string)$attribute2->Type->Class->attributes()->Name) {
					return true; // parameters hebben zelfde class
				}
			}
		} else {
			if((string)$attribute1->attributes()->Type == (string)$attribute2->attributes()->Type) {
				return true; // attributen hebben een object datatype
			}
		}
		return false;
	}	
	
	
	
	function sameTypeParam($parameter1, $parameter2) {
		if(!empty($parameter1->Type) && !empty($parameter2->Type)) {
			if(isset($parameter1->Type->DataType) && isset($parameter2->Type->DataType)){
				if((string)$parameter1->Type->DataType->attributes()->Name == (string)$parameter2->Type->DataType->attributes()->Name) {
					return true; // parameters hebben zelfde standaard datatype
				}
			} else if(isset($parameter1->Type->Class) && isset($parameter2->Type->Class)) {
				if((string)$parameter1->Type->Class->attributes()->Name  == (string)$parameter2->Type->Class->attributes()->Name) {
					return true; // parameters hebben zelfde class
				}
			}
		} else {
			if((string)$parameter1->attributes()->Type == (string)$parameter2->attributes()->Type) {
				return true; // attributen hebben een object datatype
			}
		}
		return false;
	}


	/** Function checkt of de naam van de eerste class overeen komt met een van de andere.
		Zo ja is het correct en anders bestaat die niet in de andere file.**/
	function classExists($class1, &$xml2) {
		$class1_name = (string)$class1->attributes()->Name;
		
		foreach($xml2->Models->Package->ModelChildren->Class as $class2) {
			$class2_name = (string)$class2->attributes()->Name;
			
			if($class1_name == $class2_name) {
				return true;
			}
		
		}
		return false;
	}

	/** Function checkt of de naam van het eerste attribuut overeen komt met een van de andere.
		Zo ja is het correct en anders bestaat die niet in de andere file.**/
	function attrExists($attributes1, $modelChildren2) {
		$name1 = (string)$attributes1->attributes()->Name;
	 
		foreach($modelChildren2->Attribute as $attributes2) {
			$name2 = (string)$attributes2->attributes()->Name;
	  
			if($name1 == $name2) {
				return true;
			} 
	 
		}
	 
		return false;
	}
	
	function oprExists($operations1, $modelChildren2) {
		$name1 = (string)$operations1->attributes()->Name;
	 
		foreach($modelChildren2->Operation as $operations2) {
			$name2 = (string)$operations2->attributes()->Name;
	  
			if($name1 == $name2) {
				return true;
			} 
	 
		}
	 
		return false;
	}

}

