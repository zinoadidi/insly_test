<?php
     $isSubmitted = false;
     $answerObject = new stdClass();

    if(ISSET($_POST['carValue'])){
        $isSubmitted = true;

    }else{
       
    }

    Class InsuranceCalculator{


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
            <form action="calculator.php" method="post">
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
                        <button class="padding-extra btn">Calculate</button>
                    </div>
                </div>          
            </form>
        </center>
    </div>
    
    <?php if($isSubmitted){?>
        <div id="answerDiv">
        </div>
    <?php } ?>
</body>
</html>


<script>


function updateElementValue(elementName){
    document.getElementById('showSelected'+elementName).innerHTML = document.getElementById(elementName).value.toLocaleString()
}


</script>