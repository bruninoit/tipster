<?php
/**
*
* @package phpBB Extension - Acme Demo
* @copyright (c) 2013 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/
namespace bruninoit\tipster\controller;
class classifica_tipster
{
	/* @var \phpbb\config\config */
	protected $config;
	/* @var \phpbb\controller\helper */
	protected $helper;
	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\user */
	protected $user;
	
	
	protected $root_path;
	
	
protected $db; 
	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\controller\helper	$helper
	* @param \phpbb\template\template	$template
	* @param \phpbb\user				$user
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, $root_path)
	{
 $this->db = $db;
$this->user = $user; 
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->root_path = $root_path;
	}

	  public function classifica_tipster()
	  {
	  	
	  	//impostazioni
	  	$link_avatar_predefinito = "./style/pbetch/images/no_avatar.gif";
	  	
	  	//fine impostazioni
	  	
	  	
	  	
	  	
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




				$posizione_classifica = 1;
                            foreach ($profitto_autori_tipster_all as $key => $value)
                            {
                                $tipster = $key;
                                $mese = "%";
                                $anno = "%";
                                $sql = "SELECT * FROM phpbb_users WHERE username = '" .$tipster."'";
                                    	$result = $db->sql_query($sql);
                                      $row = $db->sql_fetchrow($result);
                                      $avatar = $row['user_avatar'];
                                      
                                      if($avatar == "")
                                      {
                                        $avatar_tipster = $link_avatar_predefinito;
                                      }else{
                                        $avatar_tipster = "./download/file.php?avatar=".$avatar;
                                      }
                                      
                                      if ($value >= 0 )
                                      {
                                      $up_down="up";
                                      }else{
                                      $up_down="down";
                                      }
                                      $number_value=number_format($value, 2, '.', '');
                                      
                                      //controllo
                                      $value2 = $this->helper->profitto_tipster_periodo_specifico($this->db,$tipster,date("m"),date("Y"));
                                      if ($value2 >= 0 )
                                      {
                                      $up_down_mese="up";
                                      }else{
                                      $up_down_mese="down";
                                      }
                                      
                                      //controllo
                                      $yeld=$this->helper->yield_tipster_periodo_specifico($this->db,$tipster,$mese,$anno);
                                      $picks=$this->helper->picks_tipster_periodo_specifico($this->db,$tipster,$mese,$anno);
                                      $winpicks=$this->helper->winpicks_tipster_periodo_specifico($this->db,$tipster,$mese,$anno);
                                      $stake=$this->helper->stake_avg_tipster_periodo_specifico($this->db,$tipster,$mese,$anno);
                                      $odd=$this->helper->odd_avg_tipster_periodo_specifico($this->db,$tipster,$mese,$anno);
                        		
                        		
                        	$intavaleposclas = intval($posizione_classifica);
                        

                        $link_profilo="{$this->root_path}app.php/statistiche_tipster/{$tipster}";
			$this->template-> assign_block_vars('profitto_autori_tipster_all',array(
			'POSIZIONE_CLASSIFICA'	=> $posizione_classifica,
			'LINK_PROFILO'		=> $link_profilo,
			'AVATAR_TIPSTER'	=> $avatar_tipster,
			'TIPSTER'		=> $tipster,
			'UP_DOWN'		=> $up_down,
			'NUMBER_VALUE'		=> $number_value,
			'UP_DOWN_MESE'		=> $up_down_mese,
			'VALUEDUE'		=> $value2,
			'YELD'			=> $yeld,
			'PICKS'			=> $picks,
			'WINPICKS'		=> $winpicks,
			'STAKE'			=> $stake,
			'ODD'			=> $odd,
			'INTVALPOSCLAS'		=> $intavaleposclas
			));
			
			$posizione_classifica = $posizione_classifica + 1;
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
      
      
			    $sport = "1";
                            $posizione_classifica = 1;
                            foreach ($profitto_autori_tipster_all_calcio as $key => $value)
                            {
                                $tipster = $key;
                                $mese = "%";
                                $anno = "%";
                                $sql = "SELECT * FROM phpbb_users WHERE username = '" .$tipster."'";
                                    	$result = $this->db->sql_query($sql);
                                      $row = $this->db->sql_fetchrow($result);
                                      $avatar = $row['user_avatar'];
                                       if($avatar == "")
                                       {
                                        $avatar_tipster = "$link_avatar_predefinito";
                                       }else{
                                        $avatar_tipster = "./download/file.php?avatar=".$avatar;
                                       }
                                       $link_profilo="{$this->root_path}app.php/statistiche_tipster/{$tipster}";
                                       
                                       
                                       if ($value >= 0 )
					{
					$up_down="up";	
					}else{
					$up_down="down";	
					}
					
					$value2 = $this->helper->profitto_tipster_periodo_sport_specifico($this->db,$tipster,date("m"),date("Y"), $sport);
                                       	if ($value2 >= 0 )
                                       	{
                                       	$up_down2="up";
                                       	}else{
                                       	$up_down2="down";
                                       	}
                                       	
                                       	$picks = $this->helper->picks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$winpicks = $this->helper->winpicks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$stake = $this->helper->stake_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$odd = $this->helper->odd_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	
                                $this->template-> assign_block_vars('risultati',array(
				'POSIZIONE_CLASSIFICA'	=> $posizione_classifica,
				'LINK_PROFILO'		=> $link_profilo,
				'AVATAR_TIPSTER'	=> $avatar_tipster,
				'TIPSTER'		=> $tipster,
				'UP_DOWN'		=> $up_down,
				'VALUE'			=> $value,
				'UP_DOWN2'		=> $up_down2,
				'VALUE2'		=> $value2,
				'PICKS'			=> $picks,
				'WINPICKS'		=> $winpicks,
				'STAKE'			=> $stake,
				'ODD'			=> $odd
				));
				$posizione_classifica = $posizione_classifica + 1;
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
      
      
      $sport = "2";
      $posizione_classifica = 1;
      foreach ($profitto_autori_tipster_all_tennis as $key => $value)
      {
            $tipster = $key;
            $mese = "%";
            $anno = "%";
            $sql = "SELECT * FROM phpbb_users WHERE username = '" .$tipster."'";
            $result = $this->db->sql_query($sql);
            $row = $this->db->sql_fetchrow($result);
            $avatar = $row['user_avatar'];
            			if($avatar == "")
                                  {
                                        $avatar_tipster = $link_avatar_predefinito;
                                      }else{
                                        $avatar_tipster = "./download/file.php?avatar=".$avatar;
                                   }
            			if ($value >= 0 )
                                      {
                                      $up_down="up";
                                      }else{
                                      $up_down="down";
                                      }
                                      $number_value=number_format($value, 2, '.', '');
                                      
                                      //controllo
				    $value2 = $this->helper->profitto_tipster_periodo_sport_specifico($db,$tipster,date("m"),date("Y"), $sport);                                      if ($value2 >= 0 )
                                      {
                                      $up_down_mese="up";
                                      }else{
                                      $up_down_mese="down";
                                      }
      					$picks = $this->helper->picks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$winpicks = $this->helper->winpicks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$stake = $this->helper->stake_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$odd = $this->helper->odd_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);

      $link_profilo="{$this->root_path}app.php/statistiche_tipster/{$tipster}";
      $this->template-> assign_block_vars('tennis',array(
			'POSIZIONE_CLASSIFICA'	=> $posizione_classifica,
			'LINK_PROFILO'		=> $link_profilo,
			'AVATAR_TIPSTER'	=> $avatar_tipster,
			'TIPSTER'		=> $tipster,
			'UP_DOWN'		=> $up_down,
			'NUMBER_VALUE'		=> $number_value,
			'UP_DOWN_MESE'		=> $up_down_mese,
			'VALUEDUE'		=> $value2,
			'YELD'			=> $yeld,
			'PICKS'			=> $picks,
			'WINPICKS'		=> $winpicks,
			'STAKE'			=> $stake,
			'ODD'			=> $odd,
			'INTVALPOSCLAS'		=> $intavaleposclas
			));
      $posizione_classifica = $posizione_classifica + 1;
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
      
      
                            $sport = "4"; 
                            $posizione_classifica = 1;
                            foreach ($profitto_autori_tipster_all_basket as $key => $value)
                            {
                                $tipster = $key;
                                $mese = "%";
                                $anno = "%";
      				$sql = "SELECT * FROM phpbb_users WHERE username = '" .$tipster."'";
                                    	$result = $this->db->sql_query($sql);
                                      $row = $this->db->sql_fetchrow($result);
                                      $avatar = $row['user_avatar'];
      				if($avatar == "")
                                      {
                                        $avatar_tipster = $link_avatar_predefinito;
                                      }else{
                                        $avatar_tipster = "./download/file.php?avatar=".$avatar;
                                      }
                                      
                                      if ($value >= 0 )
                                      {
                                      $up_down="up";
                                      }else{
                                      $up_down="down";
                                      }
                                      $number_value=number_format($value, 2, '.', '');
                                      
                                      //controllo
                                      $value2 = profitto_tipster_periodo_specifico($this->db,$tipster,date("m"),date("Y"));
                                      if ($value2 >= 0 )
                                      {
                                      $up_down_mese="up";
                                      }else{
                                      $up_down_mese="down";
                                      }
      				//controllo
   					$picks = $this->helper->picks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$winpicks = $this->helper->winpicks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$stake = $this->helper->stake_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$odd = $this->helper->odd_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);

                        		
                        	$intavaleposclas = intval($posizione_classifica);
                        
                        $link_profilo="{$this->root_path}app.php/statistiche_tipster/{$tipster}";
			$this->template-> assign_block_vars('basket',array(
			'POSIZIONE_CLASSIFICA'	=> $posizione_classifica,
			'LINK_PROFILO'		=> $link_profilo,
			'AVATAR_TIPSTER'	=> $avatar_tipster,$
			'TIPSTER'		=> $tipster,
			'UP_DOWN'		=> $up_down,
			'NUMBER_VALUE'		=> $number_value,
			'UP_DOWN_MESE'		=> $up_down_mese,
			'VALUEDUE'		=> $value2,
			'YELD'			=> $yeld,
			'PICKS'			=> $picks,
			'WINPICKS'		=> $winpicks,
			'STAKE'			=> $stake,
			'ODD'			=> $odd,
			'INTVALPOSCLAS'		=> $intavaleposclas
			));
			
			$posizione_classifica = $posizione_classifica + 1;
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
                             $sport = "9";
                            $posizione_classifica = 1;
                            foreach ($profitto_autori_tipster_all_formula1 as $key => $value)
                            {
                                $tipster = $key;
                                $mese = "%";
                                $anno = "%";
      			$sql = "SELECT * FROM phpbb_users WHERE username = '" .$tipster."'";
                                    	$result = $this->db->sql_query($sql);
                                      $row = $this->db->sql_fetchrow($result);
                                      $avatar = $row['user_avatar'];
      				if($avatar == "")
                                      {
                                        $avatar_tipster = $link_avatar_predefinito;
                                      }else{
                                        $avatar_tipster = "./download/file.php?avatar=".$avatar;
                                      }
                                     if ($value >= 0 )
                                      {
                                      $up_down="up";
                                      }else{
                                      $up_down="down";
                                      }
                                      $number_value=number_format($value, 2, '.', '');
                                      //controllo
                                      $value2 = profitto_tipster_periodo_specifico($this->db,$tipster,date("m"),date("Y"));
                                      if ($value2 >= 0 )
                                      {
                                      $up_down_mese="up";
                                      }else{
                                      $up_down_mese="down";
                                      }
                               //controllo
                                        $picks = $this->helper->picks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$winpicks = $this->helper->winpicks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$stake = $this->helper->stake_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$odd = $this->helper->odd_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
				$intavaleposclas = intval($posizione_classifica);
                        
                        $link_profilo="{$this->root_path}app.php/statistiche_tipster/{$tipster}";
			$this->template-> assign_block_vars('f1',array(
			'POSIZIONE_CLASSIFICA'	=> $posizione_classifica,
			'LINK_PROFILO'		=> $link_profilo,
			'AVATAR_TIPSTER'	=> $avatar_tipster,
			'TIPSTER'		=> $tipster,
			'UP_DOWN'		=> $up_down,
			'NUMBER_VALUE'		=> $number_value,
			'UP_DOWN_MESE'		=> $up_down_mese,
			'VALUEDUE'		=> $value2,
			'YELD'			=> $yeld,
			'PICKS'			=> $picks,
			'WINPICKS'		=> $winpicks,
			'STAKE'			=> $stake,
			'ODD'			=> $odd,
			'INTVALPOSCLAS'		=> $intavaleposclas
			));
			
			$posizione_classifica = $posizione_classifica + 1;
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
      
      
                                  $sport = "6"; 
                            $posizione_classifica = 1;
                            foreach ($profitto_autori_tipster_all_hockey as $key => $value) {
                                $tipster = $key;
                                $mese = "%";
                                $anno = "%";
      $sql = "SELECT * FROM phpbb_users WHERE username = '" .$tipster."'";
                                    	$result = $this->db->sql_query($sql);
                                      $row = $this->db->sql_fetchrow($result);
                                      $avatar = $row['user_avatar'];
      				if($avatar == "")
                                      {
                                        $avatar_tipster = $link_avatar_predefinito;
                                      }else{
                                        $avatar_tipster = "./download/file.php?avatar=".$avatar;
                                      }
                                     if ($value >= 0 )
                                      {
                                      $up_down="up";
                                      }else{
                                      $up_down="down";
                                      }
                                      $number_value=number_format($value, 2, '.', '');
                                      //controllo
                                      $value2 = profitto_tipster_periodo_specifico($this->db,$tipster,date("m"),date("Y"));
                                      if ($value2 >= 0 )
                                      {
                                      $up_down_mese="up";
                                      }else{
                                      $up_down_mese="down";
                                      }
                               //controllo
                                        $picks = $this->helper->picks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$winpicks = $this->helper->winpicks_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$stake = $this->helper->stake_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
                                       	$odd = $this->helper->odd_avg_tipster_periodo_sport_specifico($this->db,$tipster,$mese,$anno,$sport);
				$intavaleposclas = intval($posizione_classifica);
                        
                        $link_profilo="{$this->root_path}app.php/statistiche_tipster/{$tipster}";
			$this->template-> assign_block_vars('hockey',array(
			'POSIZIONE_CLASSIFICA'	=> $posizione_classifica,
			'LINK_PROFILO'		=> $link_profilo,
			'AVATAR_TIPSTER'	=> $avatar_tipster,
			'TIPSTER'		=> $tipster,
			'UP_DOWN'		=> $up_down,
			'NUMBER_VALUE'		=> $number_value,
			'UP_DOWN_MESE'		=> $up_down_mese,
			'VALUEDUE'		=> $value2,
			'YELD'			=> $yeld,
			'PICKS'			=> $picks,
			'WINPICKS'		=> $winpicks,
			'STAKE'			=> $stake,
			'ODD'			=> $odd,
			'INTVALPOSCLAS'		=> $intavaleposclas
			));
			
			$posizione_classifica = $posizione_classifica + 1;
                            }       
      
      arsort($profitto_autori_tipster_all_hockey);

      
      
      	return $this->helper->render('classifica_tipster.html', "Classifica Tipster");
	  }
	  
}
