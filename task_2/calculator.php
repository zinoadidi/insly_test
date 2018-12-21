<?php
    /* 
    * simple car insurance calculator
    * by Zino Adidi
    * Insly Test
    *
    * I wasnt sure what skills were been tested so i tried to keep it simple
    * I thought about the task and figured if i went full MVC spliting different 
    * codes into varios files / folders and maybe using fancy design frameworks to style
    * it up might be an overkill ? so i went with good old php and html in the mix :)
    */


     $isSubmitted = false;
     $answerObject = new stdClass();

    if(ISSET($_POST['carValue'])){
        $isSubmitted = true;

        $calculate = new InsuranceCalculator();
        $answerObject->carValue = $_POST['carValue'];
        $answerObject->basePrice = $calculate->basePriceOfPolicy($_POST['carValue']);
        $answerObject->commission = $calculate->commission($answerObject->basePrice);
        $answerObject->tax = $_POST['taxValue'];
        $answerObject->installments = $_POST['instalmentValue'];
        $answerObject->totalPolicySum = $calculate->totalPolicySum($answerObject->basePrice,$answerObject->commission,$answerObject->tax);

    }else{
       
    }

    Class InsuranceCalculator{

        public function basePriceOfPolicy($carValue){
           
            if($this->verifyUserDateTime($_POST['clientDay'],$_POST['clientTime'])){
                $basePrice = ($carValue / 100) *13;                
            }else{
                $basePrice = ($carValue / 100) *11;                
            }
            return $basePrice;
        }

        private function verifyUserDateTime($day,$time){
            $today = date('l');
            if(
                // check if time and date data recived from clint follows the rules specified
                $day == '5' && ($time >14 && $time < 21) &&
                // extra validation for security loophole by relying on browser data
                ($today == 'Thursday' || $today == 'Friday' || $today == 'Saturday')    
            ){
                return true;
            }else{
                return false;
            }
        }

        public function commission($basePrice){
            return ($basePrice / 100) * 17;
        }

        public function totalPolicySum($basePrice,$commission,$tax){
            return floatval($basePrice) + floatval($commission) + floatval($tax);
        }
    }

?>

<style>
    .center{
        text-align: center;
    }
    .padding{
        padding: 4px;
    }
    .padding-extra{
        padding: 8px;
    }
    .margin{
        margin: 4px;
    }
    .margin-extra{
        margin: 8px;
    }
    .half{
        width: 45%;
    }
    .left{
        text-align: left;
    }
    .right{
        text-align: right;
    }
    .btn{
        background:black;
        color:white;
        border:0px solid black;
        width:166px;
    }
</style>

<script>
    function updateElementValue(elementName){
        document.getElementById('showSelected'+elementName).innerHTML = document.getElementById(elementName).value.toLocaleString()
    }
    function attachDateTime(){
        document.getElementById('clientDay').value = new Date().getDay();
        document.getElementById('clientTime').value = new Date().getHours();
    }

    function generateAnswerTable(answerObject){
        console.log(answerObject)
    }

</script>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Insurance Calculator</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div id="formDiv">
            <center>
                <form action="calculator.php" method="post" onsubmit="attachDateTime()">
                    <div>
                        <h2 class="padding">Insurance Calculator</h2>
                    </div>   
                    <div>
                        <h4>
                            <label>Estimated value of car (100 - 100 000 EUR)</label>
                        </h4>
                        <div>
                            <label >Car Value:</label>
                            <b><label id="showSelectedCarValue">100</label> EUR</b>
                        </div>
                        <div>
                            <input type="range" min="100" max = "100000" name="carValue" value ="100" id="CarValue" onchange="updateElementValue('CarValue')" required>
                        </div>
                    </div>   
                    <div>
                        <h4>
                            <label>TAX Percentage (0 - 100%)</label>
                        </h4>
                        <div>
                            <label >Tax Percentage: </label>
                            <b><label id="showSelectedTaxValue">12</label> %</b>
                        </div>
                        <div>
                            <input type="range" min="0" max = "100" name="taxValue" value ="12" id="TaxValue" onchange="updateElementValue('TaxValue')" required>
                        </div>
                    </div> 
                    <div>
                        <h4>
                            <label>instalments (1 – 12)</label>
                        </h4>
                        <div>
                            <b><label id="showSelectedInstalmentValue">6</label> Instalment(s)</b>
                        </div>
                        <div>
                            <input type="range" min="0" max = "12" name="instalmentValue" value ="6" id="InstalmentValue" onchange="updateElementValue('InstalmentValue')" required>
                        </div>
                    </div>      
                    <div>
                        <div class="margin-extra">
                            <input type="hidden" id="clientDay" name="clientDay" value='script:attachDateTime()'>
                            <input type="hidden" id="clientTime" name="clientTime" value=''>
                            <button class="padding-extra btn" id="submitBtn" >Calculate</button>
                        </div>
                    </div>          
                </form>
            </center>
        </div>
        
        <div id="answerTableDiv">
        </div>
        <?php 
            if($isSubmitted){
                $answerObject = json_encode($answerObject);
                echo "
                    <script>
                        generateAnswerTable({$answerObject})
                    </script>
                "; 
            }
        ?>
    </body>
</html>


