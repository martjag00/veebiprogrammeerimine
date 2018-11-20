<?php
  class Test
  {
	 //muutujad - properties, funktsioonid - , methods
	 private $secretNumber;
	 public $publicNumber;
	 
	 //eriline fukntsioon on konstruktor
	 public function __construct($givenNumber){
		 $this->secretNumber = 4;
		 $this->publicNumber= $this->secretNumber* $givenNumber;
		 $this->tellSecrets();
	 }
	 
	 public function __destruct(){
		 echo "Lõpetame!";
	 }
	 
	 public function tellThings(){
	 echo "Saladustele (" .$this->secretNumber .") pääseb ligi vaid klass ise";
	 	 
	 }
	 
	 private function tellSecrets(){
	 echo "Klassi salajane arv on : " .$this->secretNumber. "\n";
	 }
	 
  }//class lõpeb

?>