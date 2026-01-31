<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC
 *
 * @package    CodeIgniter-HMVC
 * @author     N3Cr0N (N3Cr0N@list.ru)
 * @copyright  2019 N3Cr0N
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 * @filesource
 *
 */

class MY_Controller extends MX_Controller
{
    //
    public $CI;

    /**
     * An array of variables to be passed through to the
     * view, layout,....
     */
    protected $data = array();

    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        // To inherit directly the attributes of the parent class.
        parent::__construct();

        // This function returns the main CodeIgniter object.
        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.
        $CI =& get_instance();

        // Copyright year calculation for the footer
        $begin = 2019;
        $end =  date("Y");
        $date = "$begin - $end";

        // Copyright
        $this->data['copyright'] = $date;
    }
	
	
	public function cek_login($level = '')
    {
        if (empty($this->session->userdata('log_admin')['is_logged_in'])) {
			redirect('login', 'refresh');
        }
		
		if ($level){
			if ($this->session->userdata('log_admin')['user_level'] != $level){
				redirect('.', 'refresh');
			}
		}
		
        $this->login			= $this->session->userdata('log_admin')['is_logged_in'];
        $this->user_id			= $this->session->userdata('log_admin')['user_id'];
        $this->user_level		= $this->session->userdata('log_admin')['user_level'];
        $this->user_nama		= $this->session->userdata('log_admin')['user_nama'];
        $this->user_namalengkap	= $this->session->userdata('log_admin')['user_namalengkap'];
        $this->user_addby	    = $this->session->userdata('log_admin')['user_add_by'];

    }
}

// Backend controller
require_once(APPPATH.'core/Backend_Controller.php');

// Frontend controller
require_once(APPPATH.'core/Frontend_Controller.php');
