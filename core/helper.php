<?php

namespace brunnioit\tipster\core;
class helper
{
	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\user */
	protected $user;
protected $db; 
	protected $helper;
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
		 $this->db = $this->db;
$this->user = $user; 
		$this->helper = $helper;
		$this->template = $template;
	}

//Calcola ROI del Tipster per periodo specifico
      public function roi_tipster_periodo_specifico($this->db,$tipster,$mese,$anno)
      {
          $profitto_totale = 0;
          $stake_totale = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $this->db->sql_query($sql);
        
          while ($row = $this->db->sql_fetchrow($result))
        	{
            $stake_totale += $row['pick_stake_a'];
            $profitto_totale += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
        	}
          
          $roi = round((($profitto_totale + $stake_totale)/$stake_totale),2)*100;
          $this->db->sql_freeresult($result);
        	  
         return $roi;
      } 
      
//Calcola YIELD del Tipster per periodo specifico
      public function yield_tipster_periodo_specifico($this->db,$tipster,$mese,$anno)
      {
         
          $profitto_totale = 0;
          $stake_totale = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $this->db->sql_query($sql);
        
          while ($row = $this->db->sql_fetchrow($result))
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
          $this->db->sql_freeresult($result);
	  return $yield;
      }
	   //Calcola ROI del Tipster per periodo e sport specifico 
      public function roi_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport)
      {
          $A = 0;
          $B = 0;
          $C = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $this->db->sql_query($sql);
        
        	while ($row = $this->db->sql_fetchrow($result))
        	{
            $quota = $row['pick_quota_a'].".".$row['pick_quota_b'].$row['pick_quota_c'];
            $A += $row['pick_stake_a'];
            $B += $row['pick_stake_a'] * $quota;
        	}
          $C = $B - $A;
          if($A == 0) $A = 1;
          $roi = round($C/$A,2);
        	$this->db->sql_freeresult($result);
  
         return $roi;
      }   
      
      
   //Calcola Numero di Picks del Tipster per periodo specifico
      public function picks_tipster_periodo_specifico($this->db,$tipster,$mese,$anno)
      {
           
          $sql = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $this->db->sql_query($sql);
          $row = $this->db->sql_fetchrow($result);
          
          return $row['numeroPicks'];
      }
      
  //Calcola Numero di Picks del Tipster per periodo e sport specifico
      public function picks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport)
      {
           
          $sql = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $this->db->sql_query($sql);
          $row = $this->db->sql_fetchrow($result);
          
          return $row['numeroPicks'];
      }
      
  //Calcola Numero di Picks Vincenti del Tipster per periodo specifico
      public function winpicks_tipster_periodo_specifico($this->db,$tipster,$mese,$anno)
      {
        $sql = "SELECT COUNT(*) as numeroPicksVincenti FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND esito = 'vincente'";
        $result = $this->db->sql_query($sql);
        $row = $this->db->sql_fetchrow($result);
        
       return $row['numeroPicksVincenti'];
      }
      
  //Calcola Numero di Picks Vincenti del Tipster per periodo e sport specifico
      public function winpicks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport)
      {
        $sql = "SELECT COUNT(*) as numeroPicksVincenti FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND esito = 'vincente' AND pick_sport = '".$sport."'";
        $result = $this->db->sql_query($sql);
        $row = $this->db->sql_fetchrow($result);
        
       return $row['numeroPicksVincenti'];
      }
      
      
  //Calcola Stake Avg del Tipster per periodo specifico
      public function stake_avg_tipster_periodo_specifico($this->db,$tipster,$mese,$anno)
      {
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $this->db->sql_query($sql);
          
          while($row = $this->db->sql_fetchrow($result)){
            $somma += $row['pick_stake_a'];    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result2 = $this->db->sql_query($sql2);
          $row2 = $this->db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;
      }
      
    //Calcola Stake Avg del Tipster per periodo e sport specifico
      public function stake_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport)
      {
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $this->db->sql_query($sql);
          
          while($row = $this->db->sql_fetchrow($result)){
            $somma += $row['pick_stake_a'];    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result2 = $this->db->sql_query($sql2);
          $row2 = $this->db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;
      }
      
   //Calcola Odd Avg del Tipster per periodo specifico
      public function odd_avg_tipster_periodo_specifico($this->db,$tipster,$mese,$anno)
      {
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $this->db->sql_query($sql);
          
          while($row = $this->db->sql_fetchrow($result)){
            $valore = floatval($row['pick_quota_a'].".".$row['pick_quota_b'].".".$row['pick_quota_c']);
            $somma += $valore;    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result2 = $this->db->sql_query($sql2);
          $row2 = $this->db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;   
      }
      
  //Calcola Profitto del Tipster per periodo specifico
      public function profitto_tipster_periodo_specifico($this->db,$tipster,$mese,$anno,$giorno = '%')
      {
          $profitto = 0;
          
          //$sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-"."$giorno'";
          $result = $this->db->sql_query($sql);
          
        	while ($row = $this->db->sql_fetchrow($result))
        	{
            $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
          }
        	$this->db->sql_freeresult($result);
  
         return $profitto;
      }
      
      
 //Calcola Profitto del Tipster per periodo e sport specifico
      public function profitto_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport)
      {
          $profitto = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          //$sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-"."$giorno' AND pick_sport = '".$sport."'";
          
          $result = $this->db->sql_query($sql);
          
        	while ($row = $this->db->sql_fetchrow($result))
        	{
            $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
          }
        	$this->db->sql_freeresult($result);
  
         return $profitto;
      }


 //Calcola Odd Avg del Tipster per periodo e sport specifico
      public function odd_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport)
      {
          $somma = 0;
          
          $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $this->db->sql_query($sql);
          
          while($row = $this->db->sql_fetchrow($result))
          {
            $valore = floatval($row['pick_quota_a'].".".$row['pick_quota_b'].".".$row['pick_quota_c']);
            $somma += $valore;    
          }
          
          $sql2 = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result2 = $this->db->sql_query($sql2);
          $row2 = $this->db->sql_fetchrow($result2);
          $num_picks = $row2['numeroPicks'];
          
         $a = number_format(($somma / $num_picks),2); 
         //$a = round($somma / $num_picks);
         return $a;   
      }
	
}
