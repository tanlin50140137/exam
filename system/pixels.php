<?php
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
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
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */