<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Accountlist extends CI_Controller {

	public function __construct(){
        parent::__construct();
     //   check_login_user();
       // $this->load->library('curl');
$this->load->helper('form');
       $this->load->database();
      $this->load->model('data_model');

}


    public function getAccountTransbyid()
    {
        extract($_POST);
        $data_arr=get_defined_vars();
        $compid=$data_arr['compId'];
        $finyear=$data_arr['finyear'];
        $id=$data_arr['id'];
        //var_dump($data_arr);
        $data=array();
        $acctdata=$this->data_model->getTransbyid($compid,$finyear,$id);
        if($acctdata)
        {
            foreach ($acctdata as  $value) {
              $data[]=$value;
            }
        }
        echo json_encode($data);
    }


    public function ledgerbyidbycid()
    {
      $data=array();
      extract($_POST);
      $data_arr=get_defined_vars();
      $cid=$data_arr['compId'];
      $id=$data_arr['id'];
      $ldgdata= $this->data_model->getLedgerbyidbycid($cid,$id);
      if($ldgdata)
      {
        foreach($ldgdata as $ldg)
        {
          $data[]=$ldg;		
    
        }
      }
      echo json_encode($data);
    
    }
    
    


}