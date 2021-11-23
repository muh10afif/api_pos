<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';
class Token extends API_Controller
{
	function __construct($config = 'rest') {
        parent::__construct($config);
        date_default_timezone_set("Asia/Jakarta");//set you countary name from below timezone list
    }

    public function Get_token()
    {
        header("Access-Control-Allow-Origin: *");

        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

        // you user authentication code will go here, you can compare the user with the database or whatever
        $payload = [
            'id' => "Your User's ID",
            'other' => "Some other data"
        ];

        // Load Authorization Library or Load in autoload config file
        $this->load->library('Authorization_token');
            $token = $this->authorization_token->generateToken($payload);

            $this->api_return(['status' => true, "result" => ['token' => $token, ], ],200);
    }
}