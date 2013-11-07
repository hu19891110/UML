<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

global $OperatieVariabelenFout; //(leaf/scope/unique/visibility/static) waarde * aantalvarsfout = totale_aftrek
global $AttribuutVariabelenFout; //(leaf/scope/unique/visibility/static) waarde * aantalvarsfout = totale_aftrek
//-----------Puntenaftrek------------


class Checker extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper(array('form', 'url'));
		$this->login = new stdClass;
		$this->load->library('flexi_auth');	
		
		$this->ModelIsNietAanwezig = 0.5; //er ontbreekt een classe in de handed-in model (of de naam is verkeerd)
		$this->GRADE = 10;
		$this->RelatieNaamAnders = 0.1;
		$this->RelatieHeeftAnderBegin = 0.3;
		$this->RelatieHeeftAnderEind = 0.3;
		$this->RelatieAndereSoort = 0.2;
		$this->RelatieMPFout = 0.3; //er is een fout gemaakt bij de multiplicity van een relatie, danwel bij het begin danwel bij de eindbestemming

		$this->DatatypeAttribuutFout = 0.3;
		$this->DataTypeParameterFout = 0.3;
		$this->ParameterMissing = 0.3;
		$this->OperationMissing = 0.3;
		$this->AttribuutMissing = 0.3;

		$this->OperatieVariabelenFout = 0.1; //(leaf/scope/unique/visibility/static) waarde * aantalvarsfout = totale_aftrek
		$this->AttribuutVariabelenFout = 0.1; //(leaf/scope/unique/visibility/static) waarde * aantalvarsfout = totale_aftrek
			
		$this->faults = '';
		
		if (! $this->flexi_auth->is_logged_in_via_password()) 
		{
			
			$this->flexi_auth->set_error_message('You must be logged in to access this area.', TRUE);
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			redirect('login');
		}
		
		$this->data = null;
		
		$this->load->vars('base_url', 'http://'.$_SERVER['HTTP_HOST'].'/');
		$this->load->vars('includes_dir', 'http://'.$_SERVER['HTTP_HOST'].'/includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
		
		$currentuser_id = $this->flexi_auth->get_user_id();
		$sql_where = array($this->flexi_auth->db_column('user_acc', 'id') => $currentuser_id);
		$this->data['currentuser'] = $this->flexi_auth->get_users_row_array(FALSE, $sql_where);
	}
	
	
	
	function index() {
	
		$this->data['error'] = ' ';
		
		$correctfile = $this->flexi_auth->get_correct_file_by_deadline();
		$correctfile = $correctfile->result_array();
		$correctfile = $correctfile[0];
		
		$correctfile_name = (string) $correctfile['student_id'] . '-' . (string)$correctfile['deadline_id'] . '.xml';
		
		$uploads = $this->flexi_auth->get_uploads_by_deadline();
		$uploads = $uploads->result_array();
		
		foreach($uploads as $upload) {
			$this->faults = ' ';
			$this->GRADE = 0;
			
			$handed_in_file = (string) $upload['student_id'] . '-' . (string)$upload['deadline_id'] . '.xml';
			$this->checkFile($correctfile_name, $handed_in_file);
			
			
		}
		
		
		$this->data['uploads'] = $uploads;
		
		$data['maincontent'] = $this->load->view('compare_file_view', $this->data, TRUE);
		
		
		if ($this->flexi_auth->is_admin()) {
			$this->load->view('template-teacher', $data);
		} else {
			$this->load->view('template-student', $data);
		}
	
	}
	
	function checkFile($correctfile, $handed_in_file) {
		$config['upload_path'] = './uploads/';
		
		$correctfile = file_get_contents('./uploads/' . $correctfile);
		$correctfile = simplexml_load_string($correctfile);
		
		$handed_in_file = file_get_contents('./uploads/' . $handed_in_file);
		$handed_in_file = simplexml_load_string($handed_in_file);
		
		$this->checkModels($correctfile, $handed_in_file);
		
		echo $this->faults;
		echo $this->GRADE;
	
	}
	
	/***
	Checks if the Classes are compared with eachother and goes deeper in each time
	***/
	function checkModels($xml, $xml2) {
		foreach($xml->Models->Package->ModelChildren->Class as $class1) { // goes through all models that should exist.
			if($this->classExists($class1, $xml2)) {
				foreach($xml2->Models->Package->ModelChildren->Class as $class2) { // dieper in klassen gaan als ze met elkaar overeenkomen
					if((string)$class1->attributes()->Name == (string)$class2->attributes()->Name) { 
					
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
			echo 'Leaf, '; 
			$i++;
		}
		if((string)$attributes1->Unique != (string)$attributes2->Unique) {
			echo 'Unique, '; 
			$i++;
		}
		if((string)$attributes1->Static != (string)$attributes2->Static) {
			echo 'Static, '; 
			$i++;
		}
		if((string)$attributes1->Visibility != (string)$attributes2->Visibility) {
			echo 'Visibility, '; 
			$i++;
		}
		if((string)$attributes1->Scope != (string)$attributes2->Scope) {
			echo 'Scope, '; 
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
			if( isset($parameter1->Type->DataType) && isset($parameter2->Type->DataType)){
				if((string)$parameter1->Type->DataType->attributes()->Name == (string)$parameter2->Type->DataType->attributes()->Name) {
					return true; // parameters hebben zelfde standaard datatype
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


?>