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
      
      //codice da controllare1
      
	  }
}
