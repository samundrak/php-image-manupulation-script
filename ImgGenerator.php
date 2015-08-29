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
private $ClientName;
private $ClientFullName;
private $ClientLastName;
private $ClientPhone;
private $ClientZip;
private $ClientAddress;
private $ClientEmail;
    

 

 
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
             
                 $this->config = json_decode(utf8_encode($file),false);
              
          }
          switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    //echo ' - No errors';
                break;
                case JSON_ERROR_DEPTH:
                    echo ' - Maximum stack depth exceeded';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Underflow or the modes mismatch';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Unexpected control character found';
                break;
                case JSON_ERROR_SYNTAX:
                    echo ' - Syntax error, malformed JSON';
                break;
                case JSON_ERROR_UTF8:
                    echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
                default:
                    echo ' - Unknown error';
                break;
            }

        }
    }
    public function createImage(){
        
        if($this->config === null){
       
            return null;
        }else{
            $this->setDate(date("Y/m/d h:m:s a"));
            $this->setPlan("plus");
           return $this->manipulateImage();
        }
    }

    private function manipulateImage(){
        $config = $this->config;

        if(!file_exists($config->template)) {
          $img = imagecreate($config->dimension->width,$config->dimension->height);
        }
        else{
          $img = imagecreatefromjpeg($config->template) or die('Permission denied please enable writeable Permission  this image');
        }

        $background_color = imagecolorallocate($img,$this->config->color->background[0],$this->config->color->background[1],$this->config->color->background[2]);
        $foreground_color = imagecolorallocate($img,$this->config->color->foreground[0],$this->config->color->foreground[1],$this->config->color->foreground[2]);
//        imagettftext($img,12,0,100,100,$this->config->,)
        // $textLocationX = 100;
        // $textLocationY = 100;
        // $textYincrement = 0;
        // $labels =  array(
        //     $config->labels->accountBilled,
        //     $config->labels->invoiceId,
        //     $config->labels->amount,
        //     $config->labels->date,
        //     $config->labels->plan

        // );
        // $values = array(
        //     $this->getAccountBilld(),
        //     $this->getInvoiceId(),
        //     $this->getAmount(),
        //     $this->getDate(),
        //     $this->getPlan()
        // );
        // $valueCounter = 0;
        // foreach($labels as $label){
        //     imagestring($img, $config->fontsize, $textLocationX, $textLocationY + $textYincrement, $label.": " .$values[$valueCounter], $foreground_color);
        //     $textYincrement += ( 20 + $config->fontsize);
        //     $valueCounter++;
        // }
        $commands = array(
                  "invoice_id",
                  "invoice_amount",
                  "client_name",
                  "client_firstname",
                  "client_lastname",
                  "client_phonenumber",
                  "account_billed",
                  "client_zip_code",
                  "client_address",
                  "client_country"
                  );

          foreach ($commands as $key => $value) {
            $config->text = str_replace('{{'.$value.'}}', $this->changedText($value),$config->text);
            $config->text = str_replace('{{ '.$value.' }}', $this->changedText($value),$config->text);
          }


        $y = 111;
        $spacing = 2;
        $lines=explode("\n",$config->text);
        for($i=0; $i< count($lines); $i++)
            {
            $newY=$y+($i * $config->fontsizeOfText * $spacing);
            
           if(file_exists($config->fonttype))
             imagettftext($img,  0, 10, $newY, $foreground_color, $config->fonttype,  $lines[$i], $spacing);
            else
              imagestring($img, $config->fontsizeOfText, 10, $newY, $lines[$i], $foreground_color);
            
            }
        imagestring($img, $config->fontsize, 365, 307, $this->getDate(), $foreground_color);
        imagestring($img, $config->fontsize, 4, 380, $config->companyname, $foreground_color);


        if($config->imageformat === 'png'){
            $finalImg =  uniqid().'.png';
            $process = imagepng($img, $config->imageSavePath.$finalImg);
        }
        else{
            $finalImg = uniqid().'.jpg';
            $process = imagejpeg($img, $config->imageSavePath.$finalImg) or die('err');
        }

        return $finalImg;
    }

  private  function changedText($cmd){

      $commands = array( 
                  "invoice_id",
                  "invoice_amount",
                  "client_name",
                  "client_firstname",
                  "client_lastname",
                  "client_phonenumber",
                  "account_billed",
                  "client_zip_code",
                  "client_address",
                  "client_country",
                  "date",
                  "client_plan",
                  "n"
                  );

      $repl = array(
          $this->getInvoiceId(),
          $this->getAmount(),
          $this->getClientName(),
          $this->getClientFullName(),
          $this->getClientLastName(),
          $this->getClientPhone(),
          $this->getAccountBilld(),
          $this->getClientZip(),
          $this->getClientAddress(),
          $this->getDate(),
          $this->getPlan(),
          "newline"
        );
      $counter = 0;
      foreach ($commands as $key => $value) {
        if($cmd === $value){
          return $repl[$counter];
        }
        $counter++;
      }         
  }
  
  

    /**
     * Gets the value of ClientAddress.
     *
     * @return mixed
     */
    public function getClientAddress()
    {
        return $this->ClientAddress;
    }

    /**
     * Sets the value of ClientAddress.
     *
     * @param mixed $ClientAddress the client address
     *
     * @return self
     */
    public function setClientAddress($ClientAddress)
    {
        $this->ClientAddress = $ClientAddress;

        return $this;
    }

    /**
     * Gets the value of accountBilld.
     *
     * @return mixed
     */
    public function getAccountBilld()
    {
        return $this->accountBilld;
    }

    /**
     * Sets the value of accountBilld.
     *
     * @param mixed $accountBilld the account billd
     *
     * @return self
     */
    public function setAccountBilld($accountBilld)
    {
        $this->accountBilld = $accountBilld;

        return $this;
    }

    /**
     * Gets the value of invoiceId.
     *
     * @return mixed
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * Sets the value of invoiceId.
     *
     * @param mixed $invoiceId the invoice id
     *
     * @return self
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    /**
     * Gets the value of date.
     *
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the value of date.
     *
     * @param mixed $date the date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Gets the value of amount.
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets the value of amount.
     *
     * @param mixed $amount the amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Gets the value of plan.
     *
     * @return mixed
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Sets the value of plan.
     *
     * @param mixed $plan the plan
     *
     * @return self
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Gets the value of logoImage.
     *
     * @return mixed
     */
    public function getLogoImage()
    {
        return $this->logoImage;
    }

    /**
     * Sets the value of logoImage.
     *
     * @param mixed $logoImage the logo image
     *
     * @return self
     */
    public function setLogoImage($logoImage)
    {
        $this->logoImage = $logoImage;

        return $this;
    }

    /**
     * Gets the value of companyName.
     *
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Sets the value of companyName.
     *
     * @param mixed $companyName the company name
     *
     * @return self
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Gets the value of config.
     *
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Sets the value of config.
     *
     * @param mixed $config the config
     *
     * @return self
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Gets the value of ClientName.
     *
     * @return mixed
     */
    public function getClientName()
    {
        return $this->ClientName;
    }

    /**
     * Sets the value of ClientName.
     *
     * @param mixed $ClientName the client name
     *
     * @return self
     */
    public function setClientName($ClientName)
    {
        $this->ClientName = $ClientName;

        return $this;
    }

    /**
     * Gets the value of ClientFullName.
     *
     * @return mixed
     */
    public function getClientFullName()
    {
        return $this->ClientFullName;
    }

    /**
     * Sets the value of ClientFullName.
     *
     * @param mixed $ClientFullName the client full name
     *
     * @return self
     */
    public function setClientFullName($ClientFullName)
    {
        $this->ClientFullName = $ClientFullName;

        return $this;
    }

    /**
     * Gets the value of ClientLastName.
     *
     * @return mixed
     */
    public function getClientLastName()
    {
        return $this->ClientLastName;
    }

    /**
     * Sets the value of ClientLastName.
     *
     * @param mixed $ClientLastName the client last name
     *
     * @return self
     */
    public function setClientLastName($ClientLastName)
    {
        $this->ClientLastName = $ClientLastName;

        return $this;
    }

    /**
     * Gets the value of ClientPhone.
     *
     * @return mixed
     */
    public function getClientPhone()
    {
        return $this->ClientPhone;
    }

    /**
     * Sets the value of ClientPhone.
     *
     * @param mixed $ClientPhone the client phone
     *
     * @return self
     */
    public function setClientPhone($ClientPhone)
    {
        $this->ClientPhone = $ClientPhone;

        return $this;
    }

    /**
     * Gets the value of ClientZip.
     *
     * @return mixed
     */
    public function getClientZip()
    {
        return $this->ClientZip;
    }

    /**
     * Sets the value of ClientZip.
     *
     * @param mixed $ClientZip the client zip
     *
     * @return self
     */
    public function setClientZip($ClientZip)
    {
        $this->ClientZip = $ClientZip;

        return $this;
    }

    /**
     * Gets the value of ClientEmail.
     *
     * @return mixed
     */
    public function getClientEmail()
    {
        return $this->ClientEmail;
    }

    /**
     * Sets the value of ClientEmail.
     *
     * @param mixed $ClientEmail the client email
     *
     * @return self
     */
    public function setClientEmail($ClientEmail)
    {
        $this->ClientEmail = $ClientEmail;

        return $this;
    }
}
?>