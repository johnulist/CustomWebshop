<?php
/**
* Helper to modify images, create thumbnails etc
** PHP version 5
*
* @author Chris de Kok http://www.mech7.net
* @version $Rev$
*
*/
class ImageHelper {
      /**
       * Other helpers used only html
       *
       * @var array
       */
      public $helpers = array('Html');

      /**
       * Path to the image directory
       *
       * @var string
       */
      public $imgpath;
      /**
       * Path to the image cache directory
       *
       * @var string
       */
      public $imgCachePath;
      /**
       * Relative path to the cached image
       */
      public $relativeImgPath;

      /**
       * Old image
       */
      private $oldImage;
      /**
       * Working image
       */
      private $workingImage;
      /**
       * New image
       */
      private $newImage;
      /**
       * Current size of image after editing contains an array
       * with width / height
       * @var array
       */
      private $currentSize = array();
      /**
       * Contains the filetype for the image either JPG, PNG, GIF or false
       */
      private $fileType;
      /**
       * Class constructor check if gd is installed
       *
       */
      public function __construct(){

              // Setup paths
              $this->imgpath = WWW_ROOT.'img'.DS;
              $this->imgCachePath = IMAGES.'cache'.DS;
              $this->relativeImgPath = 'cache/';

              if(!function_exists("gd_info")) {
                      echo 'You do not have the GD Library installed.  This class requires the GD library to function properly.' . "\n";
                      echo 'visit http://us2.php.net/manual/en/ref.image.php for more information';
                      exit;
              }

              if (!is_dir($this->imgCachePath)) {
                      echo 'Cache directory does not exists: '. $this->imgCachePath;
                      exit();
              }
              if (!is_writable($this->imgCachePath)) {
                      echo 'Cache directory is not writable: '.$this->imgCachePath;
                      exit();
              }
      }
      /**
       * Method to resize an image
	   *
	   * It will resize to the largest possible value if $largest
       * is set to true. This is used in the crop function will it will cut the rest of the
       * top / bottom if you need it. $return to true, saves the image to the cache and
       * returns the html.
       *
       * @access public
       * @param string $file
       * @param integer $width
       * @param integer $height
       * @param array $htmlAttributes
       * @param boolean $largest
       * @param booelean $return
       */
      public function resize($file, $width, $height, $htmlAttributes = false, $largest = false, $return = true)
	  {
   			  $filename = basename($file);
   			  $this->imgpath = WWW_ROOT.'img'.DS . substr($file, 0, strlen($file) - strlen($filename));
   			  $file = $filename;
   			  $file_path = $this->imgpath.$file;
              $file_type = $this->checkFile($file_path);

              if($this->fileType){

                      // Get new dimensions
                      list($width_orig, $height_orig) = getimagesize($file_path);
                      $ratio_orig = $width_orig/$height_orig;
                      if($largest){
                              if ($width/$height < $ratio_orig) {
                                      $width = $height*$ratio_orig;
                              } else {
                                      $height = $width/$ratio_orig;
                              }
                      } else {
                              if ($width/$height > $ratio_orig) {
                                      $width = $height*$ratio_orig;
                              } else {
                                      $height = $width/$ratio_orig;
                              }
                      }
                      $this->currentSize['width'] = $width;
                      $this->currentSize['height'] = $height;

                      $htmlAttributes['height'] = $height;
				  	  $htmlAttributes['width'] = $width;

                      /**
                       * If file is already cached return html
                       */
                      $cache_filename = 'r_'.$width.'_'.$height.'_'.$file;
                      if($return && $this->checkCache($file_path, $cache_filename)){
                              return $this->Html->image($this->relativeImgPath.$cache_filename, $htmlAttributes);
                      }
                      switch($this->fileType) {
                              case 'GIF':
                                      $this->oldImage = ImageCreateFromGif($file_path);
                                      break;
                              case 'JPG':
                                      $this->oldImage = ImageCreateFromJpeg($file_path);
                                      break;
                              case 'PNG':
                                      $this->oldImage = ImageCreateFromPng($file_path);
                                      break;
                      }
                      $this->workingImage = imagecreatetruecolor($this->currentSize['width'], $this->currentSize['height']);
                      if($this->fileType == 'PNG')
					  {
                      		imagesavealpha($this->workingImage, true);
                      		$trans_colour = imagecolorallocatealpha($this->workingImage, 0, 0, 0, 127);
                      		imagefill($this->workingImage, 0, 0, $trans_colour);
                      }

                      /** Transparante gifs worden snel lelijk... **/
                      if($this->fileType == 'GIF')
					  {
  						$trnprt_indx = imagecolortransparent($this->oldImage);
 						if ($trnprt_indx >= 0)
					 	{
					         // Get the original image's transparent color's RGB values
					        $trnprt_color    = imagecolorsforindex($this->oldImage, $trnprt_indx);

					        // Allocate the same color in the new image resource
					        $trnprt_indx    = imagecolorallocate($this->workingImage, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

					        // Completely fill the background of the new image with allocated color.
					        imagefill($this->workingImage, 0, 0, $trnprt_indx);

					        // Set the background color for new image to transparent
					        imagecolortransparent($this->workingImage, $trnprt_indx);
					    }
 					  }


                      imagecopyresampled($this->workingImage, $this->oldImage, 0, 0, 0, 0, $this->currentSize['width'], $this->currentSize['height'], $width_orig, $height_orig);
                      if($return){
                              // Save image to cache and return html
                              $this->newImage = $this->workingImage;
                              $this->saveFile($this->imgCachePath.$cache_filename);
                              return $this->Html->image($this->relativeImgPath.$cache_filename, $htmlAttributes);
                      }
              }
      }
      /**
       * Method to resize and crop the image if height and width are larger than the
       * values from the parameters
       *
       * @param string $file
       * @param integer $width
       * @param integer $height
       * @param array $htmlAttributes
       */
      public function resizeAndCrop($file, $width = 150, $height = 100, $htmlAttributes = false){
              $file_path = $this->imgpath.DS.$file;
              $cache_filename = 'rc_'.$width.'_'.$height.'_'.str_replace('/','-',$file);
              $file_type = $this->checkFile($file_path);
              if($this->fileType){
                      /**
                       * Image is cached allready return html with image
                       */
                      if($this->checkCache($file_path, $cache_filename)){
                              return $this->Html->image($this->relativeImgPath.$cache_filename, $htmlAttributes);
                      }
                      $this->resize($file, $width, $height, false, true, false);
                      $cropX = intval(($this->currentSize['width'] - $width) / 2);
                      $cropY = intval(($this->currentSize['height'] - $height) / 2);

                      $this->newImage = imagecreatetruecolor ($width, $height);

                      if($this->fileType == 'PNG'){
                              imagesavealpha($this->newImage, true);
                      $trans_colour = imagecolorallocatealpha($this->newImage, 0, 0, 0, 127);
                      imagefill($this->newImage, 0, 0, $trans_colour);
                      }
                      imagecopyresampled ($this->newImage, $this->workingImage, 0, 0, $cropX, $cropY, $this->currentSize['width'], $this->currentSize['height'], $this->currentSize['width'], $this->currentSize['height']);
                      $this->saveFile($this->imgCachePath.$cache_filename);
                      return $this->Html->image($this->relativeImgPath.$cache_filename, $htmlAttributes);
              }
      }
      /**
       * Method to check filetype and if it is readable and exists
       * return false or PNG, GIF, JPG depending on filetype
       *
       * @param string $file
       */
      public function checkFile($file = false){
              if($file){
                      //check to see if file exists
                      if(!file_exists($file) OR !is_readable($file)) {
                              return false;
                      }
                      //check if gif
                      if(stristr(strtolower($file),'.gif')){
                              $this->fileType = 'GIF';
                      }
                      //check if jpg
                      elseif(stristr(strtolower($file),'.jpg') || stristr(strtolower($file),'.jpeg')){
                              $this->fileType = 'JPG';
                      }
                      //check if png
                      elseif(stristr(strtolower($file),'.png')){
                              $this->fileType = 'PNG';
                      }
                      //unknown file format
                      else {
                              $this->fileType = false;
                      }
              }
      }
      /**
       * Method to check if the file is allready saved in the cache
       * returns false or true wether the file needs to be saved.
       * The first param $file needs to be the name to the original file,
       * the second param $cached_file is the what the cached filename
       * should be
       *
       * @access private
       * @param string $file
       * @param string $cached_file
       * @return boolean;
       */
      private function checkCache($file = null, $cache_file = null){
              if($file && $cache_file){
                      // Original file
                      $file = $this->imgpath.DS.$file;
                      // Cached file
                      $cachefile = $this->imgCachePath.$cache_file;
                      if (file_exists($cachefile)) {
                              if (@filemtime($cachefile) < @filemtime($file)){
                                      return false;
                              }
                      } else {
                              return false;
                      }
                      return true;
              }
      }
      /**
       * Method to save the file to the cache
       *
       * @param string $file_name
       */
      public function saveFile($file_name){
              switch($this->fileType) {
                      case 'GIF':
                              ImageGif($this->newImage,$file_name);
                              break;
                      case 'JPG':
                              ImageJpeg($this->newImage,$file_name,100);
                              break;
                      case 'PNG':
                              ImagePng($this->newImage,$file_name);
                              break;
              }
      }
      /**
       * Class destructor
       *
       */
      public function __destruct() {
              if(is_resource($this->newImage)) @ImageDestroy($this->newImage);
              if(is_resource($this->oldImage)) @ImageDestroy($this->oldImage);
              if(is_resource($this->workingImage)) @ImageDestroy($this->workingImage);
      }
}
?>