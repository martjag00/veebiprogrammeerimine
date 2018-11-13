<?php
  class Photoupload
  {
	 private $myTempImage;
	 private $imageFileType;
	 private $tempName;
	 private $myImage;
	 
	 public function __construct($file, $type){
		$this->tempName = $file;
		$this->imageFileType = $type;
		$this->imageFromFile();
	 }
	 
	 public function __destruct(){
		imagedestroy($this->myTempImage);
		imagedestroy($this->myImage);
	 }
	 
	 private function imageFromFile(){
		 //loome vastavalt faili tüübile pildi objekti
		if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
			$this->myTempImage = imagecreatefromjpeg($this->tempName);
		}
		if($this->imageFileType == "png"){
			$this->myTempImage = imagecreatefrompng($this->tempName);
		}
		if($this->imageFileType == "gif"){
			$this->myTempImage = imagecreatefromgif($this->tempName);
		}
	 }
	 public function changePhotoSize($width, $height){
		$imageWidth=imagesx($myTempImage);
		$imageHeight=imagesy($myTempImage);
		//arvutan suuruse suhtarvu
		if($imageWidth > $imageHeight){
			$sizeRatio= $imageWidth / 600;
		} else {
			$sizeRatio= $imageHeight /400;
		}
		
		$newWidth= round($imageWidth / $sizeRatio);
		$newHeight= round($imageHeight / $sizeRatio);
		
		$this->myImage= $this->resizeImage($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
	 }
	 
	 private function resizeImage($image, $ow, $oh, $w, $h){
		$newImage= imagecreatetruecolor($w, $h);
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
		return $newImage;
	}
	
	public function addWatermark(){
		//lisan vesimärgi
		$waterMark= imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png");
		$waterMarkWidth= imagesx($waterMark);
		$waterMarkHeight= imagesy($waterMark);
		$waterMarkPosX= imagesx($this->myImage) - $waterMarkWidth - 10;
		$waterMarkPosY= imagesy($this->myImage) - $waterMarkHeight -10;
		
		imagecopy($this->myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
	}
	 
	public function addText(){
		//lisan ka teksti
		$textToImage= "Veebiprogrammeerimine";
		$textColor= imagecolorallocatealpha($this->myImage, 255, 255, 255, 60);
		imagettftext($this->myImage, 20, 0, 10, 30, $textColor, "../vp_picfiles/ARIALBD.TTF", $textToImage);
	}
	
	public function saveFile($target_file){
	$notice= null;
	//lähtudes failitüübist, kirjutan pildifaili
	if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
		if(imagejpeg($this->myImage, $target_file, 95)){
			$notice= 1; //great success
		} else {
			$notice=0;
			
		}
	}
	if($this->imageFileType == "png"){
		if(imagejpeg($this->myImage, $target_file, 6)){
			$notice=1;
		} else {
			$notice=0;
		}
	}
	if($this->imageFileType == "gif"){
		if(imagejpeg($this->myImage, $target_file)){
			$notice=1;
		} else {
			$notice=0;
		}
	}
	return $notice;
	}
  }
  //class lõpeb

?>