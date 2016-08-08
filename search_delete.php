/*
The code below is used to find a file based on the user's choice.
The file will either be deleted/removed or used to draw a tree containing switches.

Author: d-vilela
Date: 08/08/2016
*/

<?php

chdir('./d3');
include('draw.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['entry_removeEntry'])) {//Assume it's the remove button
        $start = explode(' ' ,htmlspecialchars($_POST['entry']));
        $slice_ip_mask = explode('/', $start[0]);
        $current_ip = $slice_ip_mask[0];
        $current_mask = $slice_ip_mask[1];
        $slice_day = explode('/', $start[1]);
        $current_day = $slice_day[0];
        $current_month = $slice_day[1];
        $current_year = $slice_day[2];
        $current_hour = $start[2];
        $current_minute = $start[4];

        $file_name = $current_ip . "_" . $current_mask . "_" . $current_day . "_" . $current_month . "_". $current_year . "_" . $current_hour. "_". $current_minute.".json";
        
        if(unlink($file_name) == true){
            $message = "Arquivo encontrado!  ".$file_name." foi deletado." ;
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else{
            $message = "Arquivo não encontrado! Nome do arquivo: ".$file_name.". Verifique se o mesmo já foi deletado ou informado corretamente.";
            echo "<script type='text/javascript'>alert('$message');</script>";            
        }
        //echo "<script type='text/javascript'>parent.window.location.reload();</script>";
    }
    else if (isset($_POST['entry_findEntry'])){
     //   $var = explode(' ' ,htmlspecialchars($_POST['entry']));//<-- Tenho o que desejo procurar: IP_MASK_DATA_HORARIO
        
        $start = explode(' ' ,htmlspecialchars($_POST['entry']));
        $slice_ip_mask = explode('/', $start[0]);
        $current_ip = $slice_ip_mask[0];
        $current_mask = $slice_ip_mask[1];
        $slice_day = explode('/', $start[1]);
        $current_day = $slice_day[0];
        $current_month = $slice_day[1];
        $current_year = $slice_day[2];
        $current_hour = $start[2];
        $current_minute = $start[4];
        $current_entry_string = $current_ip."/".$current_mask." ".$current_day."/".$current_month."/".$current_year." ".$current_hour." : ".$current_minute;
		$current_entry_json = $current_ip."_".$current_mask."_".$current_day."_".$current_month."_".$current_year."_".$current_hour."_".$current_minute."json";
        
		if(file_exists($current_entry_json)){		
			//echo "<script type='text/javascript'>alert('$current_entry');</script>"; 
			$rede_csv = fopen('rede.csv', 'w');
			fwrite($rede_csv, $current_ip.','.$current_mask);
			fclose($rede_csv);
			
			$dados_json = fopen('dados.json', 'w');
			$file =  file_get_contents($current_entry);
			fwrite($dados_json, $file);
			fclose($dados_json);
			
			echo "<script>findEntry('$current_entry');</script>";
		}
		else{
			echo "Arquivo ".$current_entry_json."não existe!";
		}
    }
    else{
        echo "Algo de errado ocorreu! Verifique os seus IDs!";
    }
}
?>
