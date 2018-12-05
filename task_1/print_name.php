<?php



/* 
* Program to "print out your name with one of php loops" 
* by Zino Adidi
* Insly Test
*/

$name = 'Zino Adidi';

printName($name);

function printName($name){

    try{
        //convert characters to array :)
        $name = str_split($name);

        // display all characters
        foreach ($name as $letter) {
            print $letter;
        }  
    }catch(Exception $ex){
        
        //echo $ex->getMessage();
        echo "Kindly confirm that you provided string input.";
    }
    

}