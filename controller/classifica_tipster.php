<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace bruninoit\tipster\controller;
class main
{
	/* @var \phpbb\config\config */
	protected $config;
	/* @var \phpbb\controller\helper */
	protected $helper;
	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\user */
	protected $user;
protected $db; 
	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\controller\helper	$helper
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
 $this->db = $db;
$this->user = $user; 
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
	}

	  public function classifica_tipster()
	  {
	$mese_corrente = date("n");
      $anno = date("Y");
      $mese_x = "";
      
      if ($mese_corrente == "1"){$mese_x = "Gennaio";}
      if ($mese_corrente == "2"){$mese_x = "Febbraio";}
      if ($mese_corrente == "3"){$mese_x = "Marzo";}
      if ($mese_corrente == "4"){$mese_x = "Aprile";}
      if ($mese_corrente == "5"){$mese_x = "Maggio";}
      if ($mese_corrente == "6"){$mese_x = "Giugno";}
      if ($mese_corrente == "7"){$mese_x = "Luglio";}
      if ($mese_corrente == "8"){$mese_x = "Agosto";}
      if ($mese_corrente == "9"){$mese_x = "Settembre";}
      if ($mese_corrente == "10"){$mese_x = "Ottobre";}
      if ($mese_corrente == "11"){$mese_x = "Novembre";}
      if ($mese_corrente == "12"){$mese_x = "Dicembre";}
      $this->template->assign_vars(array('MESE_X'       => $mese_x));
      
      
      $autori_tipster = array();
      $sql = "SELECT * FROM pronostici GROUP BY autore_tipster ORDER BY 'autore_tipster' ASC";
    	$result = $this->db->sql_query($sql);
    	while ($row = $this->db->sql_fetchrow($result))
    	{
    		$autori_tipster[] = $row;
    	}
    	$this->db->sql_freeresult($result);

      $autori_tipster_a = "";
      for($i = 0; $i < count($autori_tipster); $i++ )
      {
        $autori_tipster_a .= $autori_tipster[$i]['autore_tipster'].",";
      }
      $this->template->assign_vars(array('AUTORI_TIPSTER_A'       => $autori_tipster_a)); 
	
      
      	//Calcola Profitto (tutti gli anni)
	$profitto_autori_tipster_all = array();
	for($i = 0; $i < count($autori_tipster); $i++ )
	{
        	$profitto = 0;
        	$sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."'";
        	$result = $this->db->sql_query($sql);
        	while ($row = $this->db->sql_fetchrow($result))
      			{
          			$profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      			}
      		if($profitto != 0)
      		{
          	$profitto_autori_tipster_all[$autori_tipster[$i]['autore_tipster']] = $profitto;
        	}
     $this->db->sql_freeresult($result);
	}

     arsort($profitto_autori_tipster_all);
     arsort($profitto_autori_tipster_all_ultimo_mese);
	
      
         //Calcola Profitto (CALCIO)

      $profitto_autori_tipster_all_calcio = array();

      for($i = 0; $i < count($autori_tipster); $i++ )
      {
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '1'";
        $result = $this->db->sql_query($sql);
      	while ($row = $this->db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0)
        {
          $profitto_autori_tipster_all_calcio[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $this->db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_calcio);
      
  //Calcola Profitto (TENNIS)

      $profitto_autori_tipster_all_tennis = array();

      for($i = 0; $i < count($autori_tipster); $i++ )
      {
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '2'";
        $result = $this->db->sql_query($sql);
      	while ($row = $this->db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0)
        {
          $profitto_autori_tipster_all_tennis[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $this->db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_tennis);
      
  //Calcola Profitto (BASKET)

      $profitto_autori_tipster_all_basket = array();

      for($i = 0; $i < count($autori_tipster); $i++ )
      {
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '4'";
        $result = $this->db->sql_query($sql);
      	while ($row = $this->db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0)
        {
          $profitto_autori_tipster_all_basket[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $this->db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_basket);   
      
  //Calcola Profitto (FORMULA1)

      $profitto_autori_tipster_all_formula1 = array();

      for($i = 0; $i < count($autori_tipster); $i++ )
      {
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '9'";
        $result = $this->db->sql_query($sql);
      	while ($row = $this->db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0)
        {
          $profitto_autori_tipster_all_formula1[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $this->db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_formula1);
      
  //Calcola Profitto (HOCKEY)

      $profitto_autori_tipster_all_hockey = array();

      for($i = 0; $i < count($autori_tipster); $i++ )
      {
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '6'";
        $result = $this->db->sql_query($sql);
      	while ($row = $this->db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0)
        {
          $profitto_autori_tipster_all_hockey[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $this->db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_hockey);
      
      
     
//Calcola ROI del Tipster per periodo specifico
      function roi_tipster_periodo_specifico($db,$tipster,$mese,$anno)
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
      function yield_tipster_periodo_specifico($db,$tipster,$mese,$anno)
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
      function roi_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport)
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
      function picks_tipster_periodo_specifico($db,$tipster,$mese,$anno)
      {
           
          $sql = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%'";
          $result = $this->db->sql_query($sql);
          $row = $this->db->sql_fetchrow($result);
          
          return $row['numeroPicks'];
      }
      
  //Calcola Numero di Picks del Tipster per periodo e sport specifico
      function picks_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport)
      {
           
          $sql = "SELECT COUNT(*) as numeroPicks FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND pick_sport = '".$sport."'";
          $result = $this->db->sql_query($sql);
          $row = $this->db->sql_fetchrow($result);
          
          return $row['numeroPicks'];
      }
      
  //Calcola Numero di Picks Vincenti del Tipster per periodo specifico
      function winpicks_tipster_periodo_specifico($db,$tipster,$mese,$anno)
      {
        $sql = "SELECT COUNT(*) as numeroPicksVincenti FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND esito = 'vincente'";
        $result = $this->db->sql_query($sql);
        $row = $this->db->sql_fetchrow($result);
        
       return $row['numeroPicksVincenti'];
      }
      
  //Calcola Numero di Picks Vincenti del Tipster per periodo e sport specifico
      function winpicks_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport)
      {
        $sql = "SELECT COUNT(*) as numeroPicksVincenti FROM pronostici WHERE autore_tipster = '".$tipster."' AND data_evento LIKE '".$anno."-".$mese."-%' AND esito = 'vincente' AND pick_sport = '".$sport."'";
        $result = $this->db->sql_query($sql);
        $row = $this->db->sql_fetchrow($result);
        
       return $row['numeroPicksVincenti'];
      }
      
      
  //Calcola Stake Avg del Tipster per periodo specifico
      function stake_avg_tipster_periodo_specifico($db,$tipster,$mese,$anno)
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
      function stake_avg_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport)
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
      function odd_avg_tipster_periodo_specifico($db,$tipster,$mese,$anno)
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
      function profitto_tipster_periodo_specifico($db,$tipster,$mese,$anno,$giorno = '%')
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
      function profitto_tipster_periodo_sport_specifico($db,$tipster,$mese,$anno,$sport)
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
      function odd_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport)
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
      
      
      	return $this->helper->render('classifica_tipster.html', "Classifica Tipster");
	  }
	  
}
