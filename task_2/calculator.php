<?php
    /* 
    * simple car insurance calculator
    * by Zino Adidi
    * Insly Test
    *
    * I wasnt sure what skills were been tested so i tried to keep it simple
    * I thought about the task and figured if i went full MVC spliting different 
    * codes into various files / folders and maybe using fancy design frameworks to style
    * it up might be an overkill so i went with old php and html in the mix style :)
    * little did i know that there is more to an insurance calculator than i anticipated.
    */

    $error = false;
    $isSubmitted = false;
    $answerObject = new stdClass();

    if(ISSET($_POST['carValue'])){
        $isSubmitted = true;

        $calculate = new InsuranceCalculator();
        $answerObject->carValue = $_POST['carValue'];
        $answerObject->basePricePercent = $calculate->verifyUserDateTime($_POST['clientDay'],$_POST['clientTime']);        
        $answerObject->basePrice = $calculate->basePriceOfPolicy($_POST['carValue'],$answerObject->basePricePercent);
        $answerObject->commission = $calculate->commission($answerObject->basePrice);
        $answerObject->taxPercent = $_POST['taxValue'];
        $answerObject->tax = $calculate->tax($_POST['taxValue'],$answerObject->basePrice);
        $answerObject->installments = $_POST['instalmentValue'];
        $answerObject->totalPolicySum = $calculate->totalPolicySum($answerObject->basePrice,$answerObject->commission,$answerObject->tax);
        $answerObject->commissionPercent = 17;
    }else{
       $error = "Kindly Provide All Fields to Continue";
    }

    Class InsuranceCalculator{

        public function basePriceOfPolicy($carValue,$basePricePercent){

            $basePrice = ($carValue / 100) * $basePricePercent;                
            return $basePrice;
        }

        public function verifyUserDateTime($day,$time){
            $today = date('l');
            if(
                // check if time and date data recived from clint follows the rules specified
                $day == '5' && ($time >14 && $time < 21) &&
                // extra validation for security loophole by relying on browser data
                ($today == 'Thursday' || $today == 'Friday' || $today == 'Saturday')    
            ){
                return 13;
            }else{
                return 11;
            }
        }

        public function commission($basePrice){
            return ($basePrice / 100) * 17;
        }

        public function tax($taxPercent, $basePrice){
            return ($basePrice / 100) * $taxPercent;
        }

        public function totalPolicySum($basePrice,$commission,$tax){
            return floatval($basePrice) + floatval($commission) + floatval($tax);
        }

        public function generateAnswerTable ($answerObject){
            $answerTable ="";
            if($answerObject->installments >1){
                // insert table head
                $answerTable = '<tr id="answerTableHead"><td></td><td class="bold">Policy<td/>';
                for($columns=1; $columns<=$answerObject->installments; $columns++){
                    $answerTable.="<td class='bold'>{$columns} installment</td>";
                }
                $answerTable.="</tr>";
                
                // insert value
                $answerTable .= "
                    <tr id='carValue'>
                        <td>Value</td><td>{$answerObject->carValue}<td/>
                    </tr>
                ";
                
                // insert base premium
                $answerTable .= "<tr id='basePremium'><td>Base premium ({$answerObject->basePricePercent}%)</td><td>{$answerObject->basePrice}</td><td></td>";
                for($columns=1; $columns<=$answerObject->installments; $columns++){
                    $pricePerInstallment = round($answerObject->basePrice / $answerObject->installments,2);
                    $answerTable.="<td>{$pricePerInstallment}</td>";
                }
                $answerTable.="</tr>";

                // insert commission
                $answerTable .= "<tr id='basePremium'><td>Commission ({$answerObject->commissionPercent}%)</td><td>{$answerObject->commission}</td><td></td>";
                for($columns=1; $columns<=$answerObject->installments; $columns++){
                    $commissionPerInstallment = round($answerObject->commission / $answerObject->installments,2);
                    $answerTable.="<td>{$commissionPerInstallment}</td>";
                }
                $answerTable.="</tr>";
                // insert tax
                $answerTable .= "<tr id='basePremium'><td>Tax ({$answerObject->taxPercent}%)</td><td>{$answerObject->tax}</td><td></td>";
                for($columns=1; $columns<=$answerObject->installments; $columns++){
                    $taxPerInstallment = round($answerObject->tax / $answerObject->installments,2);
                    $answerTable.="<td>{$taxPerInstallment}</td>";
                }
                $answerTable.="</tr>";
                // insert total cost
                $answerTable .= "<tr id='basePremium'><td class='bold'>Total Cost</td><td>{$answerObject->totalPolicySum}</td><td></td>";
                for($columns=1; $columns<=$answerObject->installments; $columns++){
                    $totalPerInstallment = round($answerObject->totalPolicySum / $answerObject->installments,2);
                    $answerTable.="<td>{$totalPerInstallment}</td>";
                }
                $answerTable.="</tr>";
            }

            return $answerTable;            
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
        font-size:20px
    }
    .answerTable{
        width: -webkit-fill-available;
    }
    .bold {
        font-weight:bold
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
                            <input type="range" min="100" max = "100000" name="carValue" value ="100" id="CarValue"  step="2" oninput="updateElementValue('CarValue')" required>
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
                            <input type="range" min="0" max = "100" name="taxValue" value ="12" id="TaxValue"  step="1" oninput="updateElementValue('TaxValue')" required>
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
                            <input type="range" min="1" max = "12" name="instalmentValue" value ="6" id="InstalmentValue" step="1" oninput="updateElementValue('InstalmentValue')" required>
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
        
        <div class="answerTableDiv center padding-extra margin-extra">
            <table class="answerTable">
                <tbody>
                <?php 
                    if($isSubmitted){
                        echo $calculate->generateAnswerTable($answerObject);
                    }
                ?>
                </tbody>    
            </table>
        </div>
    </body>

    <div id="errorDiv">
        <p><?php echo $error; ?></p>
    </div>  
</html>


