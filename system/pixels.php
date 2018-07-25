<?php
/**
 * @author TanLin
 * @version 2017年2月13日 
 */
class Imagecreate
{
	private $width;
	
	private $height;
	
	private $imgPath;
	
	private $dstresult;
	
	public  $mimeImage;
	
	public  $exd;

	public function __construct($imgPath,$width,$height)
	{
		$this->width = $width;
		$this->height = $height;
		$this->imgPath = $imgPath;

		$this->createGrid();
		$this->showImage();
	}

	public function createGrid()
	{		
		$array = getimagesize($this->imgPath);

		$this->mimeImage = $array['mime'];
			
		$arrExd = explode("/", $this->mimeImage);
		$this->exd = $arrExd[1];
		
		$srcWidth = $array[0];
		$srcHeight = $array[1];	
		
		$imageimagecreatefromAll = "imagecreatefrom".$this->exd;		
		$srcresult = $imageimagecreatefromAll($this->imgPath);
		
		$this->dstresult = imagecreatetruecolor($this->width, $this->height);
		$color = imagecolorallocate($this->dstresult, 255, 255, 255);
		imagefill($this->dstresult, 0, 0, $color);

		imagecopyresampled($this->dstresult, $srcresult, 0, 0, 0, 0, $this->width, $this->height, $srcWidth, $srcHeight);		
		imagedestroy($srcresult);
	}
	private function showImage()
	{
		header("content-type:".$this->mimeImage);
		imagepng($this->dstresult);
		imagedestroy($this->dstresult);
	}
}