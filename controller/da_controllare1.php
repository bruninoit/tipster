//Calcola Profitto (tutti gli anni)

      $profitto_autori_tipster_all = array();
      //$profitto_autori_tipster_all_ultimo_mese = array();

      for($i = 0; $i < count($autori_tipster); $i++ ){
        $profitto = 0;
       // $profitto_ultimo_mese = 0;
        
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."'";
        //$sql_ultimo_mese = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."'";
        
        $result = $db->sql_query($sql);
        //$result_ultimo_mese = $db->sql_query($sql);
      	
        while ($row = $db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}
        
        if($profitto != 0){
          $profitto_autori_tipster_all[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        
       /* while ($row = $db->sql_fetchrow($result_ultimo_mese))
      	{
          $profitto_ultimo_mese += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto_ultimo_mese != 0){
          $profitto_autori_tipster_all_ultimo_mese[$autori_tipster[$i]['autore_tipster']] = $profitto_ultimo_mese;
        }*/
        
        $db->sql_freeresult($result);
        //$db->sql_freeresult($result_ultimo_mese);
      }
      
      
      arsort($profitto_autori_tipster_all);
      arsort($profitto_autori_tipster_all_ultimo_mese);
      
      
   //Calcola Profitto (CALCIO)

      $profitto_autori_tipster_all_calcio = array();

      for($i = 0; $i < count($autori_tipster); $i++ ){
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '1'";
        $result = $db->sql_query($sql);
      	while ($row = $db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0){
          $profitto_autori_tipster_all_calcio[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_calcio);
      
   
   
   //Calcola Profitto (TENNIS)

      $profitto_autori_tipster_all_tennis = array();

      for($i = 0; $i < count($autori_tipster); $i++ ){
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '2'";
        $result = $db->sql_query($sql);
      	while ($row = $db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0){
          $profitto_autori_tipster_all_tennis[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_tennis);
      
      
   
   //Calcola Profitto (BASKET)

      $profitto_autori_tipster_all_basket = array();

      for($i = 0; $i < count($autori_tipster); $i++ ){
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '4'";
        $result = $db->sql_query($sql);
      	while ($row = $db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0){
          $profitto_autori_tipster_all_basket[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_basket);   
      


   //Calcola Profitto (FORMULA1)

      $profitto_autori_tipster_all_formula1 = array();

      for($i = 0; $i < count($autori_tipster); $i++ ){
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '9'";
        $result = $db->sql_query($sql);
      	while ($row = $db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0){
          $profitto_autori_tipster_all_formula1[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_formula1);
      
    
      
    //Calcola Profitto (HOCKEY)

      $profitto_autori_tipster_all_hockey = array();

      for($i = 0; $i < count($autori_tipster); $i++ ){
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '6'";
        $result = $db->sql_query($sql);
      	while ($row = $db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0){
          $profitto_autori_tipster_all_hockey[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_hockey);





   //Calcola ROI del Tipster per periodo specifico
      function roi_tipster_periodo_specifico($db,$tipster,$mese,$anno){
          $profitto_totale = 0;
          $stake_totale = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $db->sql_query($sql);
        
          while ($row = $db->sql_fetchrow($result))
        	{
            $stake_totale += $row['pick_stake_a'];
            $profitto_totale += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
        	}
          
          $roi = round((($profitto_totale + $stake_totale)/$stake_totale),2)*100;
          $db->sql_freeresult($result);
        	  
         return $roi;
      }
      
      
    //Calcola YIELD del Tipster per periodo specifico
      function yield_tipster_periodo_specifico($db,$tipster,$mese,$anno){
         
          $profitto_totale = 0;
          $stake_totale = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $db->sql_query($sql);
        
          while ($row = $db->sql_fetchrow($result))
        	{
            //$stake = $row['pick_stake_a'];
            //$quota = $row['pick_quota_a'].".".$row['pick_quota_b'].$row['pick_quota_c'];
            //$profitto = ($stake * $quota) - $stake;
            
            //$profitto_totale += $profitto;
            $stake_totale += $row['pick_stake_a'];
            $profitto_totale += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
        	}
          
         // $totale_parziale = $stake_totale + $profitto_totale;
         // $yield = round((($profitto_totale - $stake_totale)/$stake_totale),2)* 100;
          
          $yield = round(($profitto_totale/$stake_totale),2)*100;
          
          $db->sql_freeresult($result);
          
        	
         return $yield;
      }
      
    //Calcola ROI del Tipster per periodo e sport specifico 
      function roi_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport){
          $A = 0;
          $B = 0;
          $C = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $db->sql_query($sql);
        
        	while ($row = $db->sql_fetchrow($result))
        	{
            $quota = $row['pick_quota_a'].".".$row['pick_quota_b'].$row['pick_quota_c'];
            $A += $row['pick_stake_a'];
            $B += $row['pick_stake_a'] * $quota;
        	}
          $C = $B - $A;
          if($A == 0) $A = 1;
          $roi = round($C/$A,2);
        	$db->sql_freeresult($result);
  
         return $roi;
      }   
  
      
       
       
     //Calcola Numero di Picks del Tipster per periodo specifico
      function picks_tipster_periodo_specifico($db,$tipster,$mese,$anno){
           
          $sql = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $db->sql_query($sql);
          $row = $db->sql_fetchrow($result);
          
          return $row['numeroPicks'];
      }
      
      
      //Calcola Numero di Picks del Tipster per periodo e sport specifico
      function picks_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport){
           
          $sql = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $db->sql_query($sql);
          $row = $db->sql_fetchrow($result);
          
          return $row['numeroPicks'];
      }
       
      
    //Calcola Numero di Picks Vincenti del Tipster per periodo specifico
      function winpicks_tipster_periodo_specifico($db,$tipster,$mese,$anno){
        $sql = "SELECT COUNT(*) as numeroPicksVincenti FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND esito = 'vincente'";
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        
       return $row['numeroPicksVincenti'];
      }
      
      
    //Calcola Numero di Picks Vincenti del Tipster per periodo e sport specifico
      function winpicks_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport){
        $sql = "SELECT COUNT(*) as numeroPicksVincenti FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND esito = 'vincente' AND pick_sport = '".$sport."'";
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        
       return $row['numeroPicksVincenti'];
      }
      
      
      
   //Calcola Stake Avg del Tipster per periodo specifico
      function stake_avg_tipster_periodo_specifico($db,$tipster,$mese,$anno){
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $db->sql_query($sql);
          
          while($row = $db->sql_fetchrow($result)){
            $somma += $row['pick_stake_a'];    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result2 = $db->sql_query($sql2);
          $row2 = $db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;
      }
      
      
      
    //Calcola Stake Avg del Tipster per periodo e sport specifico
      function stake_avg_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport){
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $db->sql_query($sql);
          
          while($row = $db->sql_fetchrow($result)){
            $somma += $row['pick_stake_a'];    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result2 = $db->sql_query($sql2);
          $row2 = $db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;
      }
      
      
      
    //Calcola Odd Avg del Tipster per periodo specifico
      function odd_avg_tipster_periodo_specifico($db,$tipster,$mese,$anno){
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $db->sql_query($sql);
          
          while($row = $db->sql_fetchrow($result)){
            $valore = floatval($row['pick_quota_a'].".".$row['pick_quota_b'].".".$row['pick_quota_c']);
            $somma += $valore;    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result2 = $db->sql_query($sql2);
          $row2 = $db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;   
      }


      //Calcola Profitto del Tipster per periodo specifico
      function profitto_tipster_periodo_specifico($db,$tipster,$mese,$anno,$giorno = '%'){
          $profitto = 0;
          
          //$sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-"."$giorno'";
          $result = $db->sql_query($sql);
          
        	while ($row = $db->sql_fetchrow($result))
        	{
            $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
          }
        	$db->sql_freeresult($result);
  
         return $profitto;
      }
      
      
      //Calcola Profitto del Tipster per periodo e sport specifico
      function profitto_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport){
          $profitto = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          //$sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-"."$giorno' AND pick_sport = '".$sport."'";
          
          $result = $db->sql_query($sql);
          
        	while ($row = $db->sql_fetchrow($result))
        	{
            $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
          }
        	$db->sql_freeresult($result);
  
         return $profitto;
      }


      //Calcola Odd Avg del Tipster per periodo e sport specifico
      function odd_avg_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport){
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $db->sql_query($sql);
          
          while($row = $db->sql_fetchrow($result)){
            $valore = floatval($row['pick_quota_a'].".".$row['pick_quota_b'].".".$row['pick_quota_c']);
            $somma += $valore;    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result2 = $db->sql_query($sql2);
          $row2 = $db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;   
      }
