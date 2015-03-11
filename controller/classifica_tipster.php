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
     arsort($profitto_autori_tipster_all);
     arsort($profitto_autori_tipster_all_ultimo_mese);
      
         //Calcola Profitto (CALCIO)

      $profitto_autori_tipster_all_calcio = array();

      for($i = 0; $i < count($autori_tipster); $i++ ){
        $profitto = 0;
        $sql = "SELECT * FROM pronostici WHERE autore_tipster = '".$autori_tipster[$i]['autore_tipster']."' AND pick_sport = '1'";
        $result = $this->db->sql_query($sql);
      	while ($row = $this->db->sql_fetchrow($result))
      	{
          $profitto += floatval($row['valore_profitto_vincente']) + floatval($row['valore_profitto_perdente']);
      	}

        if($profitto != 0){
          $profitto_autori_tipster_all_calcio[$autori_tipster[$i]['autore_tipster']] = $profitto;
        }
        $this->db->sql_freeresult($result);
      }
      arsort($profitto_autori_tipster_all_calcio);
      
      //codice da controllare1
      
      
      
	  }
}
