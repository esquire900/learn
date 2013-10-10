<?php

function listFolderFiles($dir){
    $ffs = scandir($dir);
    $return = array();
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
        	if(is_dir($dir.'/'.$ff)) {
            	listFolderFiles($dir.'/'.$ff);
            	continue;
        	}

            $e = explode(".", $ff);
            if(!isset($e[1]))
            	continue;
            
            if($e[1] !== "php" && $e[1] !== "html")
            	continue;

            // echo $ff."<br/>";
            if((GetCorrectMTime($dir.'/'.$ff) - microtime(true))*10 > -20 )
            {
                echo 1;
                exit();
            }
        }
    }
    
}

function GetCorrectMTime($filePath)
{
    $time = @filemtime($filePath);
    $isDST = (date('I', $time) == 1);
    $systemDST = (date('I') == 1);

    $adjustment = 0;

    if($isDST == false && $systemDST == true)
        $adjustment = 3600;
   
    else if($isDST == true && $systemDST == false)
        $adjustment = -3600;

    else
        $adjustment = 0;

    return ($time + $adjustment);
} 

listFolderFiles('./');
echo 0;
exit();
?>
