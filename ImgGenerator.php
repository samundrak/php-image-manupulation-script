<?php

class ImgGenerator {
private $accountBilld;
private $invoiceId;
private $date;
private $amount;
private $plan;
private $logoImage;
private $companyName;
private $config;
    /**
     * @return mixed
     */
    public function getAccountBilld()
    {
        return $this->accountBilld;
    }

    /**
     * @param mixed $accountBilld
     */
    public function setAccountBilld($accountBilld)
    {
        $this->accountBilld = $accountBilld;
    }

    /**
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @param mixed $invoiceId
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param mixed $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @return mixed
     */
    public function getLogoImage()
    {
        return $this->logoImage;
    }

    /**
     * @param mixed $logoImage
     */
    public function setLogoImage($logoImage)
    {
        $this->logoImage = $logoImage;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

	

    public function show(){
        echo $this->getInvoiceId();

    }

    public function initConfigs(){
        $config = "config.json";
        if(file_exists($config)){
           if(function_exists('file_get_contents')){
                $file =  file_get_contents($config);
           }else if(function_exists('fopen')){
                $file =  fread(fopen($config,"w"),filesize($config));
           }
            else {
                $file =  file($config);
            }

            if(empty($file)){
                $this->config = null;
            }
            else{
                 $this->config = json_decode($file,false);
          }



        }
    }
    public function createImage(){
        if($this->config === null){
            return null;
        }else{
            $this->setDate(date("y/m/d h:m:s a"));
            $this->setPlan("plus");
           return $this->manipulateImage();
        }
    }

    private function manipulateImage(){
        $img = imagecreate(800,400);
        $config = $this->config;
        $background_color = imagecolorallocate($img,$this->config->color->background[0],$this->config->color->background[1],$this->config->color->background[2]);
        $foreground_color = imagecolorallocate($img,$this->config->color->foreground[0],$this->config->color->foreground[1],$this->config->color->foreground[2]);
//        imagettftext($img,12,0,100,100,$this->config->,)
        $textLocationX = 100;
        $textLocationY = 100;
        $textYincrement = 0;
        $labels =  array(
            $config->labels->accountBilled,
            $config->labels->invoiceId,
            $config->labels->amount,
            $config->labels->date,
            $config->labels->plan

        );
        $values = array(
            $this->getAccountBilld(),
            $this->getInvoiceId(),
            $this->getAmount(),
            $this->getDate(),
            $this->getPlan()
        );
        $valueCounter = 0;
        foreach($labels as $label){
            imagestring($img, $config->fontsize, $textLocationX, $textLocationY + $textYincrement, $label.": " .$values[$valueCounter], $foreground_color);
            $textYincrement += ( 20 + $config->fontsize);
            $valueCounter++;
        }
        imagestring($img, $config->fontsize, $textLocationX, $textLocationY + $textYincrement + 50, $config->companyname, $foreground_color);


        if($config->imageformat === 'png'){
            $finalImg =  $config->imageSavePath.uniqid().'.png';
            $process = imagepng($img,$finalImg);
        }
        else{
            $finalImg =  $config->imageSavePath.uniqid().'.jpg';
            $process = imagejpeg($img,$finalImg);
        }

        return $finalImg;
    }
}
?>