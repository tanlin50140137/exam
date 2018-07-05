<?php
/**
 * 图片重采样
 * @author TanLin
 * @version 2017年2月13日 
 */
class Imagecreate
{
	private $width;
	
	private $height;
	
	private $imgPath;//原图片路径
	
	private $dstresult;
	
	public  $mimeImage;//图片类型
	
	public  $exd;//图片扩展名

	/**
	 * 参数说明
	 * @param 原图片路径 $imgPath
	 * @param 生成宽度 $width
	 * @param 生成高度 $height
	 * @param 生成文件名 $filename
	 */
	public function __construct($imgPath,$width,$height)
	{
		$this->width = $width;
		$this->height = $height;
		$this->imgPath = $imgPath;

		$this->createGrid();
		$this->showImage();
	}
	/**
	 * 创建图片
	 */
	public function createGrid()
	{		
		$array = getimagesize($this->imgPath);//获取原图信息

		$this->mimeImage = $array['mime'];//原图片类型
			
		$arrExd = explode("/", $this->mimeImage);
		$this->exd = $arrExd[1];//原图片扩展名
		
		$srcWidth = $array[0];//原图看的长度
		$srcHeight = $array[1];//原图看的宽度	
		
		$imageimagecreatefromAll = "imagecreatefrom".$this->exd;		
		$srcresult = $imageimagecreatefromAll($this->imgPath);//创建原图资源
		
		$this->dstresult = imagecreatetruecolor($this->width, $this->height);//创建新图片
		$color = imagecolorallocate($this->dstresult, 255, 255, 255);//白色
		imagefill($this->dstresult, 0, 0, $color);//填充白色背景
		//将原图片重采样
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