<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct(){
        parent::__construct();
     //   check_login_user();
       // $this->load->library('curl');
$this->load->helper('form');
       $this->load->database();
      $this->load->model('data_model');

}


public function getSalesItemsid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
// var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $link_id= $data_arr['link_id'];
  $f_date = $data_arr['f_date'];
  $t_date = $data_arr['t_date'];
  $data = array();
  $getSaleStf=$this->data_model->getStaffSalesItemsbyid($cid,$link_id,$f_date,$t_date,$finyear);
//var_dump($getSaleStf);
  if($getSaleStf)
  {
   foreach ($getSaleStf as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}


public function getSalesItemsbycatid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
// var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $link_id= $data_arr['link_id'];
  $f_date = $data_arr['f_date'];
  $t_date = $data_arr['t_date'];
  $catid = $data_arr['catid'];
  $data = array();
  $getSaleStf=$this->data_model->getCatSalesItemsbycatid($cid,$link_id,$f_date,$t_date,$finyear,$catid);
//var_dump($getSaleStf);
  if($getSaleStf)
  {
   foreach ($getSaleStf as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}

public function getTransopStock()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
//var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $f_date = $data_arr['f_date'];
  $t_date = $data_arr['t_date'];
  $catid = $data_arr['catid'];
//  getCatSalesbytranstype($trans_type,$finyear,$cid,$fdate,$tdate)
  $getStock=$this->data_model->getopStockbydate($finyear,$cid,$f_date,$t_date,$catid);
 // var_dump($getSale);
  if($getStock)
  {
   foreach ($getStock as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}

public function getOpStockbycid()
{
//  getopstockbyid
$data=array();
extract($_POST);
$data_arr=get_defined_vars();
//var_dump($data_arr);
$cid=$data_arr['compId'];
$finyear=$data_arr['finyear'];
$getOpStock=$this->data_model->getopstockbyid($cid,$finyear);
if($getOpStock)
{
  foreach ($getOpStock as $key => $opvalue) {
    $data[]=$opvalue;
  }
}


echo json_encode($data);

}

public function getGstFieldStatus()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
//var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $gstin=$data_arr['gstin'];
  $api_name="SEARCH GSTIN BY PAN";
  $getApiConfig=$this->data_model->getApiConfigdata($cid,$api_name);
  ///searchpan
//https://commonapi.mastersindia.co/commonapis/trackReturns?gstin=33ABQFA4136J1ZD&fy=2023-24
  
  if($getApiConfig)
  {
    foreach ($getApiConfig as $key => $api_value) {
      


      $api_baseurl = $api_value['api_url'] . "trackReturns?" . "gstin=" . $gstin . "&fy=" . $finyear;
      $api_authtoken= $api_value['auth_token'];
      $api_client_id=$api_value['api_client_id'];


    }


    $url=$api_baseurl;
            
    /* Init cURL resource */
   // $ch = curl_init($url);
        
    //$clientid= $api_client_id;
//    $token ="0ab31ef7392227173c6e8d34195e86d5eb0da1e9";
    $authorization = "Authorization : " . $api_authtoken;
    $client_id = "client_id:" . $api_client_id;
    //$url =$url; // "http://localhost/pln/api/json?rayon=$rayon&id_pel=$id_pel&nama=$nama";
   var_dump($url);
    $client = curl_init($url);
    
    curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
//    curl_setopt($client,CURLOPT_HTTPHEADER, array('Authorization: Bearer 0ab31ef7392227173c6e8d34195e86d5eb0da1e9','client_id: JarZChUcsytSBbnkpt'));
curl_setopt($client,CURLOPT_HTTPHEADER, array("'Authorization: Bearer " . $authorization . "','client_id: ". $api_client_id . "'"));
      
    $respone = curl_exec($client);
    
    echo $respone;




  }

}



public function getTransStock()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
//var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $f_date = $data_arr['f_date'];
  $t_date = $data_arr['t_date'];
  $catid = $data_arr['catid'];
//  getCatSalesbytranstype($trans_type,$finyear,$cid,$fdate,$tdate)
  $getStock=$this->data_model->getStockbydate($finyear,$cid,$f_date,$t_date,$catid);
 // var_dump($getSale);
  if($getStock)
  {
   foreach ($getStock as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}



public function getSalesby_transtype()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
//var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $trans_type= $data_arr['trans_type'];
  $f_date = $data_arr['f_date'];
  $t_date = $data_arr['t_date'];
//  getCatSalesbytranstype($trans_type,$finyear,$cid,$fdate,$tdate)
  $getSale=$this->data_model->getCatSalesbytranstype($trans_type,$finyear,$cid,$f_date,$t_date);
 // var_dump($getSale);
  if($getSale)
  {
   foreach ($getSale as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}

public function getSalesbyStaffid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
// var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $stf_id= $data_arr['stf_id'];
  $f_date = $data_arr['f_date'];
  $t_date = $data_arr['t_date'];
  $data = array();
  $getSaleStf=$this->data_model->getStaffSalesbyid($cid,$stf_id,$f_date,$t_date,$finyear);
  if($getSaleStf)
  {
   foreach ($getSaleStf as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}


public function getSalesCustid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
// var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  //$stf_id= $data_arr['stf_id'];
  $cust_id = $data_arr['cust_id'];
  //$t_date = $data_arr['t_date'];
  $data = array();
  $getSaleStf=$this->data_model->getStaffSalesbycustid($cid,$finyear,$cust_id);
  if($getSaleStf)
  {
   foreach ($getSaleStf as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}

public function getSalesbyStaffcustid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
// var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $stf_id= $data_arr['stf_id'];
  //$f_date = $data_arr['f_date'];
  //$t_date = $data_arr['t_date'];
  $data = array();
  $getSaleStf=$this->data_model->getStaffSalesbyfinyear($cid,$stf_id,$finyear);
  if($getSaleStf)
  {
   foreach ($getSaleStf as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}



public function getStaffList()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
// var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $stfid=$data_arr['stfid'];
  $data = array();
  $getStf=$this->data_model->getStaffbycid($cid,$stfid);
  if($getStf)
  {
   foreach ($getStf as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}

public function getCategoryList()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
// var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $catid=$data_arr['catid'];
  $data = array();
  $getCat=$this->data_model->getCategorybycid($cid,$catid);
  if($getCat)
  {
   foreach ($getCat as $key => $value) {
     # code...
     $data[]=$value;

   }

  }
echo json_encode($data);


}


public function gettaxesbyid()
{
$data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
 // var_dump($data_arr);
   $cid=$data_arr['compId'];
   //$finyear=$data_arr['finyear'];
   $id=$data_arr['id'];
$taxData=$this->data_model->getTaxesDatabyid($cid,$id);
if($taxData)
{
    foreach ($taxData as $key => $txvalue) {
              $taxdata[]=array(
            "gst_pc" => $txvalue['item_gstpc'],
            "taxable_amount" => $txvalue['taxable_amount'],
            "item_cgst" => $txvalue['item_cgst'],
            "item_sgst"=>$txvalue['item_sgst'],
            "item_igst" => $txvalue['item_igst']
        );
    }
    echo json_encode($taxdata);
}


}


public function spreport()
{
$data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $start_date=$data_arr['fdate'];
   $end_date=$data_arr['tdate'];
   $trans_type=$data_arr['trans_type'];
//var_dump($data_arr);
$spdata = $this->data_model->getsptransaction($cid,$finyear,$start_date,$end_date,$trans_type);

if($spdata)
{
  foreach ($spdata as $key => $spvalue) {
    # code...

$data['data']=array("trans_id" => $splvalue['trans_id'],
            "trans_date" => $splvalue['trans_date'],
            "account_name" => $splvalue['account_name'],
            "trans_type" =>$splvalue['trans_type'],
            "trans_amount" => $splvalue['trans_amount'],
            "gst_amount" =>$spvalue['gst_amount'],
            "net_amount" => $splvalue['net_amount']
);



  } // foreach
}

echo json_encode($data);

}



public function glreportop()
{
//$data = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
$data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
  // var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $actid=$data_arr['actid'];
   $start_date=$data_arr['fdate'];
   $end_date=$data_arr['tdate'];
   $sdate=$data_arr['s_date'];
$lopbal=0;
$op_bal=0;
$opbal=0;
$gl_ldg = $this->data_model->getopbalDatabyid($cid,$finyear,$actid);

if($gl_ldg)
{
  foreach ($gl_ldg as $key => $value) {
    # code...
    $lopbal=$value['open_bal'];
  }
  
}
else
{
  $lopbal=0;
}


$gldata_op = $this->data_model->getglop($cid,$finyear,$start_date,$actid);

if($gldata_op)
{
//var_dump($gldata_op);
 foreach ($gldata_op as $key => $opglvalue) 
    {
        # code...
    //$lopbal=$opglvalue['account_openbal'];    
    $opbal=$opglvalue['opbal'];
    $op_bal = $lopbal+$opbal;
    }   
}
else 
{
  $op_bal=$lopbal;
}
$data[] = array("opbal"=>$op_bal);

/*
$gldata = $this->data_model->getgltransaction($cid,$finyear,$start_date,$end_date,$actid);
if($gldata)
{
 foreach ($gldata as $key => $glvalue) {
        # code...
        
$data[]=array("id" =>  $glvalue['id'],
            "trans_id" => $glvalue['trans_id'],
            "trans_date" => $glvalue['trans_date'],
            "db_account" => $glvalue['db_account'],
            "cr_account" => $glvalue['cr_account'],
            "trans_type" =>$glvalue['trans_type'],
            "trans_amount" => $glvalue['trans_amount'],
            "net_amount" => $glvalue['net_amount'],
            "trans_reference" => $glvalue['trans_reference'],
            "trans_narration" => $glvalue['trans_narration'],
            "opbal"=>$op_bal
);



    }   
}
*/

echo json_encode($data);
   
}


public function glTrans()
{
//$data = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
$data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
  // var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $actid=$data_arr['actid'];
   $start_date=$data_arr['fdate'];
   $end_date=$data_arr['tdate'];
   $sdate=$data_arr['s_date'];

   $gldata = $this->data_model->getgltransaction($cid,$finyear,$start_date,$end_date,$actid);
   if($gldata)
   {
    foreach ($gldata as $key => $glvalue) {
           # code...
           
   $data[]=array("id" =>  $glvalue['id'],
               "trans_id" => $glvalue['trans_id'],
               "trans_date" => $glvalue['trans_date'],
               "db_account" => $glvalue['db_account'],
               "cr_account" => $glvalue['cr_account'],
               "trans_type" =>$glvalue['trans_type'],
               "trans_amount" => $glvalue['trans_amount'],
               "net_amount" => $glvalue['net_amount'],
               "trans_reference" => $glvalue['trans_reference'],
               "trans_narration" => $glvalue['trans_narration']
   );
   
   
   
       }   
   }
   
   echo json_encode($data);
   
  }


public function getmonthwiseclientdata()
{
  $data=array();
$osdata=array("outstand"=>0);
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   //$actid=$data_arr['act_id'];
   $trans_type=$data_arr['trans_type'];

   $getCWCode=$this->data_model->clientwisemsalescode($cid,$finyear,$trans_type);
   if($getCWCode)
   {
    foreach ($getCWCode as $key => $value) {
      # code...
      $actid=$value['db_account'];





   $getCWDataos=$this->data_model->clientwisemsalesdataos($actid,$finyear,$cid);
   if($getCWDataos)
   {
  
    foreach ($getCWDataos as $key => $ovalue) {
      # code...
      //$osdata=$value['outstand'];
$osdata=array("outstand"=>$ovalue['outstand']); 
}
//var_dump($osdata);
}

$getCWData=$this->data_model->clientwisemsalesdata($cid,$finyear,$trans_type,$actid);
if($getCWData)
{
  foreach ($getCWData as $key => $cwvalue) {
    # code...
    $data[]=array_merge($cwvalue,$osdata);
  }
}

    
   
//$fdata=array_merge($data,$osdata);
    } //CWCode



   }


echo json_encode($data);

}

public function getgstr32bdata()
{
  $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
 //  var_dump($data_arr);
   $cid=$data_arr['compId'];
   $fdate=$data_arr['fdate'];
   $tdate=$data_arr['tdate'];
   $cstatecode=$data_arr['cstatecode'];

$gstr32bData=$this->data_model->get_gstr32bData($fdate,$tdate,$cstatecode,$cid);
//var_dump($gstr32bData);
if($gstr32bData)
{
foreach ($gstr32bData as $key => $gvalue) {
$data[]=array("statecode"=>$gvalue['statename'],"txbamt"=>$gvalue['txb_amt'],"igstamt"=>$gvalue['igst_amt']);

  }  
}
echo json_encode($data);


}





public function getGstr2B() //Purchase details
{
$data=array();
extract($_POST);
$data_arr=get_defined_vars();
//var_dump($data_arr);
   $cid=$data_arr['compId'];
   $fdate=$data_arr['fdate'];
   $tdate=$data_arr['tdate'];
   $trans_type=$data_arr['trans_type'];
$gstr2bData=$this->data_model->get_gstr2bData($trans_type,$fdate,$tdate,$cid);

if($gstr2bData)
{
  foreach ($gstr2bData as $key => $purval) {
    if($purval['rcm']==0){
      $rcm="N";
    }
    else {
      $rcm="Y";
    }

    $dt = date("d-m-Y",strtotime($purval['trans_date']));

    $data['data'][]=array("gstin"=>$purval['gstin'],"account_name"=>$purval['account_name'],"trans_id"=>$purval['trans_id'],"inv_type"=>$purval['inv_type'],"trans_date"=>$dt,"invval"=>$purval['invval'],"statecode"=>$purval['statecode'],"rcm"=>$rcm,"txblval"=>$purval['txblval'],"gstpc"=>$purval['item_gstpc'],"igstval"=>$purval['igstval'],"cgstval"=>$purval['cgstval'],"sgstval"=>$purval['sgstval'],"cessval"=>$purval['cessval']);
  }

  echo json_encode($data);
}
else {
  echo 'No Data';
}




}





public function getGstJson()

{
  $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
//$data_post = array("fdate"=>$fdate,"tdate"=>$tdate,"compId"=>$compId,"compStatecode"=>$compStatecode,"compGstin"=>$compGstin,"retmon"=>$retmon,"rcm"=>$rcm);
   //$finyear=$data_arr['finyear'];
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $fdate=$data_arr['fdate'];
   $tdate=$data_arr['tdate'];
   $compStatecode=$data_arr['compStatecode'];
   $compGstin=$data_arr['compGstin'];
   $retmon=$data_arr['retmon'];
   $rcm=$data_arr['rcm'];
   $ec=$data_arr['ec'];
   $trans_stype="SALE";
   $gstGroupData=$this->data_model->gstGroup($fdate,$tdate,$cid);
   if($gstGroupData)
   {
    foreach ($gstGroupData as $key => $gstvalue) {
      
      $gstin=$gstvalue['gstin'];

//var_dump($gstin);
    $transbyGstin=$this->data_model->get_b2bTransbyGstin($fdate,$tdate,$cid,$gstin);
    if($transbyGstin)
    {
      foreach ($transbyGstin as $key => $tbgvalue) {
        
      $inv_no = $tbgvalue['trans_id'];
      $tr_date = $tbgvalue['trans_date'];
      $tr_id = $tbgvalue['trans_id'];
      $igstno = $tbgvalue['gstin'];

//var_dump($inv_no);

    $transbyInvSum=$this->data_model->get_b2bTransbyInvSum($fdate,$tdate,$cid,$igstno,$inv_no);
    if($transbyInvSum)
    {
      foreach ($transbyInvSum as $key => $tbisvalue) {
        # code...
   $invamt=$tbisvalue['inv_amt'];
   




      } //tbisvalue
    }




 $itms = array();
    $transbyInv=$this->data_model->get_b2bTransbyInv($fdate,$tdate,$cid,$gstin,$inv_no);
    if($transbyInv)
    {
      foreach ($transbyInv as $key => $b2bvalue) {

  if($inv_no==$b2bvalue['trans_id'])
{
  
if($compStatecode==$b2bvalue['pos'])
{

$itm_cgst= $b2bvalue['item_cgst'];
$itm_sgst= $b2bvalue['item_sgst'];
$itm_cs = $b2bvalue['item_cess'];
$itm_gstpc = $b2bvalue['gst_pc'].'01';

$itms[]=array('num'=>(int)$itm_gstpc,
    'itm_det' => array('txval'=>(float)$b2bvalue['taxable_amt'],
      'rt' =>(float)$b2bvalue['gst_pc'],
      'camt'=>(float)$itm_cgst,
      'samt'=>(float)$itm_sgst,
      'csamt'=>(float)$itm_cs
  ),);

}
else {
$itm_igst= $b2bvalue['item_igst'];
$itm_cs = $b2bvalue['item_cess'];
$itm_gstpc = $b2bvalue['gst_pc'].'01';
$itms[]=array('num'=>(int)$itm_gstpc,
    'itm_det' => array('txval'=>(float)$b2bvalue['taxable_amt'],
      'rt' =>(float)$b2bvalue['gst_pc'],
      'iamt'=>(float)$itm_igst,
      'csamt'=>(float)$itm_cs
  ),);

}

}




    } //b2bvalue

$inv_amt = $invamt;
//var_dump($inv_amt);
$invdate =date("d-m-Y", strtotime($tr_date));

    $inv['inv'][]= array('inum' => $tr_id,
    'idt'=>$invdate,
    'val'=> (float)$inv_amt,
    'pos' =>"'" . substr($gstin,0,2) ."'", // $gstvalue['placeofsupply'] ."'",
    'rchrg' => $rcm,
    'inv_typ' => 'R','itms'=>$itms);


      } //transbyGstin

    
}

    } //gstvalue
$arrmerge1[]= array_merge(array('ctin' => $gstin),$inv);

$inv = array();
$itms = array();
   
}

$data['b2b']=$arrmerge1;
$arrmerge1=array();
$finalmerge = array_merge(array('gstin'=>$compGstin,'fp'=>"'". $retmon,'version'=>"GST3.0.3",'hash'=>"hash"),$data);

   }
//------------------------------------------CREDIT / DEBIT NOTE---------
//CDNR




$gstcdnrGroupData=$this->data_model->gstcdnrGroup($fdate,$tdate,$cid);
if($gstcdnrGroupData)
{
 foreach ($gstcdnrGroupData as $key => $cdnrgstvalue) {
   
   $gstin=$cdnrgstvalue['gstin'];

//var_dump($gstin);
 $cdnrtransbyGstin=$this->data_model->get_cdnrTransbyGstin($fdate,$tdate,$cid,$gstin);
 if($cdnrtransbyGstin)
 {
   foreach ($cdnrtransbyGstin as $key => $cdnrtbgvalue) {
     
   $inv_no = $cdnrtbgvalue['trans_id'];
   $tr_date = $cdnrtbgvalue['trans_date'];
   $tr_id = $cdnrtbgvalue['trans_id'];
   $igstno = $cdnrtbgvalue['gstin'];

//var_dump($inv_no);

 $cdnrtransbyInvSum=$this->data_model->get_cdnrTransbyInvSum($fdate,$tdate,$cid,$igstno,$inv_no);
 if($cdnrtransbyInvSum)
 {
   foreach ($cdnrtransbyInvSum as $key => $cdnrtbisvalue) {
     # code...
$invamt=$cdnrtbisvalue['inv_amt'];





   } //tbisvalue
 }




$itms = array();
 $cdnrtransbyInv=$this->data_model->get_cdnrTransbyInv($fdate,$tdate,$cid,$gstin,$inv_no);
 if($cdnrtransbyInv)
 {
   foreach ($cdnrtransbyInv as $key => $cdnrvalue) {

if($inv_no==$cdnrvalue['trans_id'])
{
if($cdnrvalue['trans_type']=="SRTN")
{
  $nttype="C";
}  
if($cdnrvalue['trans_type']=="PRTN")
{
  $nttype="D";
}  

if($compStatecode==$cdnrvalue['pos'])
{

$itm_cgst= $cdnrvalue['item_cgst'];
$itm_sgst= $cdnrvalue['item_sgst'];
$itm_cs = $cdnrvalue['item_cess'];
$itm_gstpc = $cdnrvalue['gst_pc'].'01';

$itms[]=array('itm_det' => array('txval'=>(float)$cdnrvalue['taxable_amt'],
   'rt' =>(float)$cdnrvalue['gst_pc'],
   'camt'=>(float)$itm_cgst,
   'samt'=>(float)$itm_sgst,
   'csamt'=>(float)$itm_cs
),'num'=>(int)$itm_gstpc);

}
else {
$itm_igst= $cdnrvalue['item_igst'];
$itm_cs = $cdnrvalue['item_cess'];
$itm_gstpc = $cdnrvalue['gst_pc'].'01';
$itms[]=array('itm_det' => array('txval'=>(float)$cdnrvalue['taxable_amt'],
   'rt' =>(float)$cdnrvalue['gst_pc'],
   'iamt'=>(float)$itm_igst,
   'csamt'=>(float)$itm_cs
),'num'=>(int)$itm_gstpc);

}

}




 } //cdnrvalue

$inv_amt = $invamt;
//var_dump($inv_amt);
$invdate =date("d-m-Y", strtotime($tr_date));

 $inv['nt'][]= array('nt_num' => $tr_id,
 'nt_dt'=>$invdate,
 'ntty'=>$nttype,
 'val'=> (float)$inv_amt,
 'pos' =>"'" . substr($gstin,0,2) ."'", // $gstvalue['placeofsupply'] ."'",
 'rchrg' => $rcm,
 'itms'=>$itms,'inv_typ' => 'R');


   } //transbyGstin

 
}

 } //gstvalue
$arrmerge1[]= array_merge(array('ctin' => $gstin),$inv);

$inv = array();
$itms = array();

}

$data['cdnr']=$arrmerge1;
$arrmerge1=array();
$finalmerge = array_merge(array('gstin'=>$compGstin,'fp'=>"'". $retmon,'version'=>"GST3.0.3",'hash'=>"hash"),$data);
}

//B2C

$b2arr = array();
$b2cData=$this->data_model->getB2C($fdate,$tdate,$cid);

if($b2cData)
  //var_dump($b2cData);
{
foreach ($b2cData as $key => $b2cvalue) {
  
  

if($compStatecode==$b2cvalue['pos'])
{
//$itm_gstpc = $b2bvalue['gst_pc'].'01';

$b2arr[] = array('sply_ty'=>"INTRA",'pos'=>"'" . $b2cvalue['pos'],'typ'=>$ec,'txval'=>(float)$b2cvalue['taxable_amt'],'rt'=>(float)$b2cvalue['gst_pc'],'iamt'=>(float)$b2cvalue['item_igst'],'camt'=>(float)$b2cvalue['item_cgst'],'samt'=>(float)$b2cvalue['item_sgst'],'csamt'=>(float)$b2cvalue['item_cess']);
}
else {
$b2arr[] = array('sply_ty'=>"INTER",'pos'=>"'" . $b2cvalue['pos'],'typ'=>$ec,'txval'=>(float)$b2cvalue['taxable_amt'],'rt'=>(float)$b2cvalue['gst_pc'],'iamt'=>(float)$b2cvalue['item_igst'],'camt'=>(float)$b2cvalue['item_cgst'],'samt'=>(float)$b2cvalue['item_sgst'],'csamt'=>(float)$b2cvalue['item_cess']);
}

}
}


//HSN List
    $hsndata=array();
    $gstr1hsnData=$this->data_model->getGstr1hsn($fdate,$tdate,$cid,$trans_stype);
    if($gstr1hsnData)
    {
      $rw=1;
      foreach ($gstr1hsnData as $key => $hsn) {
//        substr( $string_n, 0, 4 ) === "http"
        if(substr($hsn['item_hsnsac'],0,2)=="99")
  {
        $hsndata["data"][]=array("num"=>$rw,"hsn_sc"=>$hsn['item_hsnsac'],"desc"=>"","uqc"=>"NA","qty"=>intval($hsn['item_qty']),"rt"=>floatval($hsn['item_gstpc']),"txval"=>floatval($hsn['taxable_amount']),"iamt"=>floatval($hsn['igst_amount']),"camt"=>floatval($hsn['cgst_amount']),"samt"=>floatval($hsn['sgst_amount']),"csamt"=>floatval($hsn['cess_amount']));
  }
  else
  {
    $hsndata["data"][]=array("num"=>$rw,"hsn_sc"=>$hsn['item_hsnsac'],"desc"=>"","uqc"=>$hsn['item_unit'],"qty"=>intval($hsn['item_qty']),"rt"=>floatval($hsn['item_gstpc']),"txval"=>floatval($hsn['taxable_amount']),"iamt"=>floatval($hsn['igst_amount']),"camt"=>floatval($hsn['cgst_amount']),"samt"=>floatval($hsn['sgst_amount']),"csamt"=>floatval($hsn['cess_amount']));

  }      

        $rw++;
      }
    }





$data['b2cs']=$b2arr;
$data['hsn'] =$hsndata;
$fmerge = array_merge($finalmerge,$data);
$inv = array();
$itms = array();

ini_set('precision',10);
ini_set('serialize_precision',10);

//echo json_encode($fmerge);
$output = json_encode($fmerge,JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
  $outp = str_replace("'", "", $output);
  echo $outp;





//$output = json_encode($finalmerge,JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
 // $outp = str_replace("'", "", $output);
 // echo $outp;


//echo json_encode($finalmerge,JSON_PRETTY_PRINT);




  }




public function getgstr1hsndata()
{
  $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
    //  $finyear=$data_arr['finyear'];
      
      $cid=$data_arr['compId'];
   $fdate=$data_arr['fdate'];
   $tdate=$data_arr['tdate'];
   $type=$data_arr['type'];

$gstr1hsnData=$this->data_model->getGstr1hsn($fdate,$tdate,$cid,$type);

if($gstr1hsnData)
{

foreach ($gstr1hsnData as $key => $hvalue) {
  if(substr($hvalue['item_hsnsac'],0,2)=="99")
  {
    $data["data"][]=array("hsnsac"=>$hvalue['item_hsnsac'],"uqc"=>"NA", "total_qty"=>$hvalue['item_qty'],"taxable_value"=>$hvalue['taxable_amount'], "gstpc"=>$hvalue['item_gstpc'],"igst"=>$hvalue['igst_amount'],"cgst"=>$hvalue['cgst_amount'],"sgst"=>$hvalue['sgst_amount'],"cess"=>$hvalue['cess_amount']);

  }
else
{ 
      $data["data"][]=array("hsnsac"=>$hvalue['item_hsnsac'],"uqc"=>$hvalue['item_unit'], "total_qty"=>$hvalue['item_qty'],"taxable_value"=>$hvalue['taxable_amount'], "gstpc"=>$hvalue['item_gstpc'],"igst"=>$hvalue['igst_amount'],"cgst"=>$hvalue['cgst_amount'],"sgst"=>$hvalue['sgst_amount'],"cess"=>$hvalue['cess_amount']);
}
  }  
}


echo json_encode($data);
}



public function getgstr1data()
{
  $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
  // var_dump($data_arr);
   $cid=$data_arr['compId'];
   $fdate=$data_arr['fdate'];
   $tdate=$data_arr['tdate'];
   $type=$data_arr['type'];

if($type=="B2B")
{
$gstr1Data=$this->data_model->getGstr1b2b($fdate,$tdate,$cid);
//var_dump($gstr1Data);
$data=array();

if($gstr1Data)
{
foreach ($gstr1Data as $key => $gvalue) {
     $data["data"][]=array("gstin"=>$gvalue['gstin'],"account_name"=>$gvalue['account_name'], "inv_no"=>$gvalue['trans_id'],"trans_date"=>date("d-m-Y",strtotime($gvalue['trans_date'])), "gstpc"=>$gvalue['item_gstpc'],"igst"=>$gvalue['igst'],"cgst"=>$gvalue['cgst'],"sgst"=>$gvalue['sgst'],"txb_amt"=>$gvalue['txb_amt'],"net_amt"=>$gvalue['net_amt']);
  }  
}


}
if($type=="CDNR")
{
  $data=array();

$gstr1cdnrData=$this->data_model->getGstr1cdnr($fdate,$tdate,$cid);

if($gstr1cdnrData)
{
foreach ($gstr1cdnrData as $key => $gvalue) {
  if($gvalue['trans_type']=="SRTN")
  {
    $trans_type="CR NOTE";
  }
  if($gvalue['trans_type']=="PRTN")
  {
    $trans_type="DB NOTE";
  }


     $data["data"][]=array("gstin"=>$gvalue['gstin'],"trans_type"=>$trans_type, "account_name"=>$gvalue['account_name'], "inv_no"=>$gvalue['trans_id'],"trans_date"=>date("d-m-Y",strtotime($gvalue['trans_date'])), "gstpc"=>$gvalue['item_gstpc'],"igst"=>$gvalue['igst'],"cgst"=>$gvalue['cgst'],"sgst"=>$gvalue['sgst'],"txb_amt"=>$gvalue['txb_amt'],"net_amt"=>$gvalue['net_amt']);


  }  
}


}


if($type=="B2C")

{
  $data=array();

$gstr1Data=$this->data_model->getGstr1b2c($fdate,$tdate,$cid);  
if($gstr1Data)
{
foreach ($gstr1Data as $key => $gvalue) {
     $data["data"][]=array("gstin"=>$gvalue['statecode'],"account_name"=>$gvalue['account_name'],"inv_no"=>$gvalue['trans_id'],"trans_date"=>date("d-m-Y",strtotime($gvalue['trans_date'])), "gstpc"=>$gvalue['item_gstpc'],"igst"=>$gvalue['igst'],"cgst"=>$gvalue['cgst'],"sgst"=>$gvalue['sgst'],"txb_amt"=>$gvalue['txb_amt'],"net_amt"=>$gvalue['net_amt']);


  }  
}

}

echo json_encode($data);
}


public function getgstr3b5data()
{
  $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
  // var_dump($data_arr);
   $cid=$data_arr['compId'];
   $fdate=$data_arr['fdate'];
   $tdate=$data_arr['tdate'];
   $trans_type=$data_arr['trans_type'];

$gstr3b5Data=$this->data_model->get_gstr3b5Data($trans_type,$fdate,$tdate,$cid);
//var_dump($gstr3b5Data);
if($gstr3b5Data)
{
foreach ($gstr3b5Data as $key => $gvalue) {
  $data=array("intra_zero"=>$gvalue['intra_zero'],"inter_zero"=>$gvalue['inter_zero']);
//$data=array("zerogst"=>$gvalue['zerogst'],"txbgst"=>$gvalue['txbgst'],"igst_amt"=>$gvalue['txbigst'],"cgst_amt"=>$gvalue['txbcgst'],"sgst_amt"=>$gvalue['txbsgst']);


  }  
}
echo json_encode($data);


}


public function getgstr3bdata()
{
  $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $fdate=$data_arr['fdate'];
   $tdate=$data_arr['tdate'];
   $trans_type=$data_arr['trans_type'];

$gstr3bData=$this->data_model->get_gstr3bData($trans_type,$fdate,$tdate,$cid);
if($gstr3bData)
{
foreach ($gstr3bData as $key => $gvalue) {
$data=array("zerogst"=>$gvalue['zerogst'],"zerorate"=>$gvalue['zerorate'],"txbgst"=>$gvalue['txbgst'],"igst_amt"=>$gvalue['txbigst'],"cgst_amt"=>$gvalue['txbcgst'],"sgst_amt"=>$gvalue['txbsgst']);


  }  
}
echo json_encode($data);
}












public function getmonthwiseclientcode()
{
  $data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];
   $getCWCode=$this->data_model->clientwisemsalescode($cid,$finyear,$trans_type);
   if($getCWCode)
   {
    foreach ($getCWCode as $key => $value) {
      # code...
      $data[]=$value;

    }
   }
echo json_encode($data);
}

public function getOpbyCustid()
{
  $data=array();
  extract($_POST);
  $data_arr=get_defined_vars();
  //var_dump($data_arr);
  $cid=$data_arr['compId'];
  $finyear=$data_arr['finyear'];
  $actid=$data_arr['cust_id'];

$lopbal=0;
$op_bal=0;
$opbal=0;
$ldg_op = $this->data_model->getopbalDatabyid($cid,$finyear,$actid);
if($ldg_op)
{

  foreach ($ldg_op as $key => $value) {
     $data[] = $value;
  }
}


echo json_encode($data);

}

public function cashbankreport()
{
//$data = array("s_date"=>$s_date,"e_date"=>$e_date,"finyear"=>$finyear,"compId"=>$compId,"actid"=>$actid,"fdate"=>$fdate,"tdate"=>$tdate);
$data=array();
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $actid=$data_arr['actid'];
   $start_date=$data_arr['fdate'];
   $end_date=$data_arr['tdate'];
   
$lopbal=0;
$op_bal=0;
$opbal=0;
$gl_ldg = $this->data_model->getopbalDatabyid($cid,$finyear,$actid);
//var_dump($gl_ldg);
if($gl_ldg)
{
  foreach ($gl_ldg as $key => $value) {
    # code...
    $lopbal=$value['open_bal'];
  }
}
else
{
  $lopbal=0;
}


$gldata_op = $this->data_model->getcbOp($cid,$finyear,$start_date,$actid);
//var_dump($gldata_op);
if($gldata_op)
{

 foreach ($gldata_op as $key => $opglvalue) {
  
        # code...
    //$lopbal=$opglvalue['account_openbal'];    
    $opbal=$opglvalue['opbal'];
    if(is_null($opbal))
    {
  
    $op_bal = $lopbal;
    }
    else 
    {
      $op_bal = $lopbal+$opbal;
    }
  //var_dump($op_bal);  
    }   
}
else
{
  $op_bal=0;

}
//var_dump($cid . $finyear . $start_date . $end_date . $actid);
$gldata = $this->data_model->getgltransaction($cid,$finyear,$start_date,$end_date,$actid);
//var_dump($gldata);

if($gldata)
{
 foreach ($gldata as $key => $glvalue) {
        # code...
        
$data[]=array("id" =>  $glvalue['id'],
            "trans_id" => $glvalue['trans_id'],
            "trans_date" => $glvalue['trans_date'],
            "db_account" => $glvalue['db_account'],
            "cr_account" => $glvalue['cr_account'],
            "trans_type" =>$glvalue['trans_type'],
            "trans_amount" => $glvalue['trans_amount'],
            "net_amount" => $glvalue['net_amount'],
            "trans_reference" => $glvalue['trans_reference'],
            "trans_narration" => $glvalue['trans_narration'],
            "opbal"=>$op_bal
);



    }   
}
else {
  $data[]=array("id" => "",
            "trans_id" =>"" ,
            "trans_date" =>"" ,
            "db_account" =>"" ,
            "cr_account" =>"" ,
            "trans_type" =>"",
            "trans_amount" => "0",
            "net_amount" =>"0" ,
            "trans_reference" =>"",
            "trans_narration" => "",
            "opbal"=>$op_bal
);

}

echo json_encode($data);



    
}

public function getmonthwisedata()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];

$monwiseData=$this->data_model->getmonwiseData($cid,$finyear,$trans_type);
if($monwiseData)
{
	foreach ($monwiseData as $key => $value) {
		# code...
    $data[]=$value;		
	}
}
echo json_encode($data);
}


public function getcurmonthtransaction()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];
   $start_date=$data_arr['start_date'];
   $end_date=$data_arr['end_date'];


$cmtrans= $this->data_model->getcmtData($cid,$finyear,$trans_type,$start_date,$end_date);

if($cmtrans)
{
	foreach ($cmtrans as $key => $value) {
		# code...
            $data[]=array("taxable_tot"=>$value['taxable_tot'],"netamount_tot"=>$value['netamount_tot'],"gst_tot"=>$value['gst_tot']);
 

	}

            echo json_encode($data);

}



}

    public function chartData()
    {
   extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];

   $schartdata= $this->data_model->getChartData($finyear,$cid,"SALE");
   $pchartdata= $this->data_model->getChartData($finyear,$cid,"PURC");
   $pichartdata=$this->data_model->getpiChartData($finyear,$cid);
$lable['labels'] = array("Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar");
if($pichartdata)
{
 foreach ($pichartdata as $key => $pivalue) {
 		# code...
$pilabel['pilabels'][]=$pivalue['sales_person'];
$pidata['pidata'][]=$pivalue['tot_rev'];


 	}	
}  

  
if($schartdata)
{
foreach ($schartdata as  $value) {
	# code...
// var_dump($value);
                        
                       
 $sdata['sales']=array(intval($value['APR']),intval($value['MAY']),intval($value['JUN']),intval($value['JUL']),intval($value['AUG']),intval($value['SEP']),intval($value['OCT']),intval($value['NOV']),intval($value['DEC']),intval($value['JAN']),intval($value['FEB']),intval($value['MAR']));



}


}


  
if($pchartdata)
{
foreach ($pchartdata as  $value) {
	# code...
// var_dump($value);
//$lable['labels'] = array("Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec","Jan","Feb","Mar");                        
                       
 $pdata['purchase']=array(intval($value['APR']),intval($value['MAY']),intval($value['JUN']),intval($value['JUL']),intval($value['AUG']),intval($value['SEP']),intval($value['OCT']),intval($value['NOV']),intval($value['DEC']),intval($value['JAN']),intval($value['FEB']),intval($value['MAR']));



}


}

$mdata['data']= array_merge($sdata,$pdata,$pidata);

$data=array_merge($lable,$pilabel,$mdata);
//$data = array_merge($data,$pdata);
echo json_encode($data);







}


public function getmonthwisegstdata()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
   $trans_type=$data_arr['trans_type'];

$cmgsttrans= $this->data_model->getmonwisegstData($cid,$finyear,$trans_type);
//var_dump($cmgsttrans);
if($cmgsttrans)
{
	foreach ($cmgsttrans as $key => $value) {
		# code...
$data[]=$value;

	}

echo json_encode($data);

}


}



public function getmonthwiseitcdata()
{
   extract($_POST);
   $data_arr=get_defined_vars();
   $cid=$data_arr['compId'];
   $finyear=$data_arr['finyear'];
//   $trans_type=$data_arr['trans_type'];

   $mitcData=$this->data_model->getmonwiseITCData($finyear,$cid);
if($mitcData)
{
	foreach ($mitcData as $key => $value) {
		# code...
		$data[]=$value;
	}
echo json_encode($data);
}


}




        public function byname()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
   //var_dump($cid . $qry);
        if(!empty($qry)){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("prod_name",$qry);
        $data=$this->db->get('products_tbl')->result();
        }else{
            $data = $this->db->get("products_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }

        public function keyword()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
   //var_dump($cid . $qry);
        if(!empty($qry)){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->like("prod_name",$qry);
        $data=$this->db->get('products_tbl')->result();
        }else{
            $data = $this->db->get("products_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }

public function updsettings()
{
extract($_POST);
$data_arr=get_defined_vars();
//$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SALE
//var_dump($data_arr);
$cid=$data_arr['compId'];
$finyear=$data_arr['finyear'];
$next_no=$data_arr['next_no'];
$trans_type=$data_arr['trans_type'];

   $updSett=$this->data_model->updSettings($cid,$finyear,$next_no,$trans_type);
//var_dump($updSett);
//return json_encode(array("status"==$updSett));

}



public function getTBData()
{
  $cramt='';
  $dbamt='';
  $opbal=0;
  $total_credit=0;
  $total_debit=0;
extract($_POST);
$data_arr=get_defined_vars();
//$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SALE
//var_dump($data_arr);
$cid=$data_arr['compId'];
$finyear=$data_arr['finyear'];

$data=array();
  $this->db->where('company_id',$cid);
  $group_data = $this->db->get('group_tbl')->result();
//var_dump($group_data);   
if($group_data)
{
  foreach ($group_data as $key => $gvalue) {
    # code...
//var_dump($gvalue);
$group_name=$gvalue->group_name;
$group_id = $gvalue->id;
$gtrans_type=$gvalue->trans_type;
$al_code = $gvalue->assets_liabilities;
$acct_type=$gvalue->acct_type;
$getldgdata = $this->data_model->getLedgerbygrpid($cid,$group_id);
if($getldgdata)
{

foreach ($getldgdata as $lvalue) {
  # code...
 if($lvalue['account_groupid']==$group_id)
 { 
$acct_id=$lvalue['id'];
$account_name=$lvalue['account_name'];
$account_groupid=$lvalue['account_groupid'];
$predefined= $lvalue['predefined'];
$cbcode = $lvalue['cb_code'];
$opbal=0;
$opbalData=$this->data_model->getopbalDatabyid($cid,$finyear,$acct_id);
//var_dump($opbalData);
if($opbalData)
{
 $opbal = $opbalData[0]['open_bal'];

}


$trans_data = $this->data_model->getTransbyacctid($cid,$finyear,$acct_id,$group_id,$cbcode,$gtrans_type);

//$trans_data = $this->data_model->getTrans($cid,$finyear,$acct_id,$group_id,$cbcode,$gtrans_type);
//var_dump($trans_data);

if($trans_data)
{
  foreach ($trans_data as $key => $tvalue) {
    # code...

$clbal = $opbal+ $tvalue['outstand'];

if($acct_type=="DB" && $cbcode=="1")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt = 0;
  }
  else
  {
    $dbamt =$clbal;
    $cramt=0;
  }

 }
}

if($acct_type=="DB" && $cbcode=="0")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt = 0;
  }
  else
  {
    $dbamt =$clbal;
    $cramt=0;
  }

 }
}

if($gtrans_type=="SALE")
{
  if($acct_type=="CR" && $cbcode=="0")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=0;
    $dbamt =abs($clbal);
  }
  else
  {
    $dbamt =0;
    $cramt=abs($clbal);
  }

 }
}

}
else
{
  if($acct_type=="CR" && $cbcode=="0")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt =0;
  }
  else
  {
    $dbamt =$clbal;
    $cramt=0;
  }

 }

}

}


 $total_debit = $total_debit + floatval($dbamt);

 $total_credit = $total_credit + floatval($cramt);

 if($dbamt<>0 || $cramt<>0)
{
if($dbamt==0)
{
  $dbamt="";
}
if($cramt==0)
{
  $cramt="";
}

  $data['data'][]=array("group"=>$group_name,"name"=>$account_name,"debitamt"=>$dbamt,"creditamt"=>$cramt);
}
  $dbamt=0;
$cramt=0;


  } //foreach trans_data
}

 } // Group If conditions

} //ledger forloop


} // ldger_data If



  } //foreach groupdata
}  // if group_data
//$output =array($data,"tot_debit"=>$total_debit,"tot_credit"=>$total_credit);

echo json_encode($data);
//var_dump($data);

}


// Balance by account id
public function getBalancebyAcctId()
{
  $cramt='';
  $dbamt='';
  $opbal=0;
  $total_credit=0;
  $total_debit=0;
extract($_POST);
$data_arr=get_defined_vars();
//$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SALE
//var_dump($data_arr);
$cid=$data_arr['compId'];
$finyear=$data_arr['finyear'];
$acct_id = $data_arr['acct_id'];
$cbcode = $data_arr['cbcode'];
$grpid = $data_arr['grpid'];
$data=array();
$opbal=0;
$grpdata = $this->data_model->getGroupbyid($cid,$grpid);
if($grpdata)
{
  $acct_type = $grpdata[0]['acct_type'];
}

$opbalData=$this->data_model->getopbalDatabyid($cid,$finyear,$acct_id);
//var_dump($opbalData);
if($opbalData)
{
 $opbal = $opbalData[0]['open_bal'];

}


$trans_data = $this->data_model->Transbyacctid($cid,$finyear,$acct_id);
//var_dump($trans_data);
if($trans_data)
{
  foreach ($trans_data as $key => $tvalue) {
    # code...

$clbal = $opbal+ $tvalue['outstand'];

if($acct_type=="DB" && $cbcode=="1")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt = 0;
  }
  else
  {
    $dbamt =$clbal;
    $cramt=0;
  }

 }
}

if($acct_type=="DB" && $cbcode=="0")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt = 0;
  }
  else
  {
    $dbamt =$clbal;
    $cramt=0;
  }

 }
}

/*
if($gtrans_type=="SALE")
{
  if($acct_type=="CR" && $cbcode=="0")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=0;
    $dbamt =abs($clbal);
  }
  else
  {
    $dbamt =0;
    $cramt=abs($clbal);
  }

 }
}

}
else
{
  if($acct_type=="CR" && $cbcode=="0")
{
 if($clbal<>0 )
 {
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt =0;
  }
  else
  {
    $dbamt =$clbal;
    $cramt=0;
  }

 }

}

}
*/

 $total_debit = $total_debit + floatval($dbamt);

 $total_credit = $total_credit + floatval($cramt);
 $cl_bal = $opbal + $clbal;

 if($dbamt<>0 || $cramt<>0)
{
if($dbamt==0)
{
  $dbamt="";
}
if($cramt==0)
{
  $cramt="";
}
}
if($clbal<0)
{
  $data['data']=array("cl_bal"=>number_format($clbal,2)." Cr");

}
else
{
  $data['data']=array("cl_bal"=>number_format($clbal,2) ." Db");

}
$dbamt=0;
$cramt=0;


  } //foreach trans_data
}


//$output =array($data,"tot_debit"=>$total_debit,"tot_credit"=>$total_credit);

echo json_encode($data);
//var_dump($data);

}



public function oldgetTBData()
{
  $cramt='';
  $dbamt='';
  $opbal=0;
  $total_credit=0;
  $total_debit=0;
extract($_POST);
$data_arr=get_defined_vars();
//$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SALE
//var_dump($data_arr);
$cid=$data_arr['compId'];
$finyear=$data_arr['finyear'];

$data=array();
  $this->db->where('company_id',$cid);
  $group_data = $this->db->get('group_tbl')->result();
//var_dump($group_data);   
if($group_data)
{
  foreach ($group_data as $key => $gvalue) {
    # code...
//var_dump($gvalue);
$group_name=$gvalue->group_name;
$group_id = $gvalue->id;
$gtrans_type=$gvalue->trans_type;
$al_code = $gvalue->assets_liabilities;
$acct_type=$gvalue->acct_type;
$this->db->where("account_groupid",$group_id);
$this->db->like("company_id",$cid);
//$this->db->like("predefined",0);
$ldger_data = $this->db->get('ledgermaster_tbl')->result();

if($ldger_data)
{

foreach ($ldger_data as $key => $lvalue) {
  # code...
$acct_id=$lvalue->id;
$account_name=$lvalue->account_name;
$account_groupid=$lvalue->account_groupid;
$predefined= $lvalue->predefined;
$cbcode = $lvalue->cb_code;
$opbal=0;
$opbalData=$this->data_model->getopbalDatabyid($cid,$finyear,$acct_id);
//var_dump($opbalData);
if($opbalData)
{
 $opbal = $opbalData[0]['open_bal'];

}



$trans_data = $this->data_model->getTrans($cid,$finyear,$acct_id,$group_id,$cbcode,$gtrans_type);
//var_dump($trans_data);

if($trans_data)
{
  foreach ($trans_data as $key => $tvalue) {
    # code...

$clbal = abs($opbal+ $tvalue['outstand']);
/*if($clbal>0)
{
  $cramt=$opbal+$clbal;
  $dbamt="";
}
else
{
  $dbamt=$opbal+$clbal;
  $cramt="";
}
*/

if($clbal<>0)
{

//Debit Amount
//if($al_code==0 && $predefined==0)
if($acct_type=="DB" )
{
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt='';
  }
  else {
  $dbamt=abs($clbal);
  $cramt='';
}
}


//Credit Amount
if($acct_type=="CR" )
{
  if($clbal<0)
  {
    $cramt='';
    $dbamt=abs($clbal);
  }
  else {
  $dbamt='';
  $cramt=abs($clbal);
}

}

if($acct_type=="CR" && $predefined==0)
{
  if($clbal<0)
  {
    $cramt=abs($clbal);
    $dbamt='';
  }
  else {
  $dbamt=abs($clbal);
  $cramt='';
}

}


/*

//if($al_code==0 && $predefined==1)

if($acct_type=="DB" && $predefined==1)
{
  $cramt='';
  $dbamt=$clbal;
}
//if($al_code==1 && $predefined==1)

if($acct_type=="CR" && $predefined==1)
{
  if($clbal<0)
  {
    $cramt=$clbal;
    $dbamt='';
  }
  else {
  $dbamt=$clbal;
  $cramt='';
}

}
//if($al_code==1 && $predefined==0 )
if($acct_type=="CR" && $predefined==0 )
{
  $cramt=$clbal;
  $dbamt='';
}

*/


 $total_debit = $total_debit + floatval($dbamt);

 $total_credit = $total_credit + floatval($cramt);

  $data['data'][]=array("group"=>$group_name,"name"=>$account_name,"debitamt"=>$dbamt,"creditamt"=>$cramt);
}


  } //foreach trans_data
}



}


} // ldger_data If



  } //foreach groupdata
}  // if group_data
//$output =array($data,"tot_debit"=>$total_debit,"tot_credit"=>$total_credit);

echo json_encode($data);
//var_dump($data);

}



public function getcashbankledger()
{
extract($_POST);  
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
//SELECT l.* from ledgermaster_tbl l,group_tbl g where l.company_id=g.company_id and l.account_groupid=g.id and g.trans_type='CSBK' and l.company_id='2' order by l.id;    

$cid=$data_arr['compId'];
/*        $this->db->where("company_id",$cid);
        $this->db->where("account_groupid",1);
       // $this->db->like("account_name",$qry);
        $data=$this->db->get('ledgermaster_tbl')->result();
 */
$getcashbankacct = $this->data_model->getCashBankAccounts($cid);
if($getcashbankacct)
{
  foreach ($getcashbankacct as $key => $value) {
    # code...
    $data[] = $value;
  }
}

        echo json_encode($data);

}


public function getcashledgerbyname()
{
extract($_POST);  
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
   $flag=$data_arr['flag'];

 if($flag=="csh")
 {
        $this->db->where("company_id",$cid);
        $this->db->where("account_groupid",1);
        $this->db->like("account_name",$qry);

        $data=$this->db->get('ledgermaster_tbl')->result();
    echo json_encode($data);
 }
 else
 {
      $gid=array("1");
        $this->db->where("company_id",$cid);
        $this->db->where_not_in("account_groupid",$gid);
        $this->db->like("account_name",$qry);

        $data=$this->db->get('ledgermaster_tbl')->result();
    echo json_encode($data);


 }

}


        public function lbyid()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['actid'];
   //var_dump($cid . $qry);
        if(!empty($qry)){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("id",$qry);
        $data=$this->db->get('ledgermaster_tbl')->result();
        }else{
            $data = $this->db->get("ledgermaster_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }


        public function lbyname()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
   //var_dump($cid . $qry);
        if(!empty($qry)){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("account_name",$qry);
        $data=$this->db->get('ledgermaster_tbl')->result();
        }else{
            $data = $this->db->get("ledgermaster_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }



        public function ldgbyname()
    {
            extract($_POST);
   $data_arr=get_defined_vars();
   //var_dump($data_arr);
   $cid=$data_arr['compId'];
   $qry=$data_arr['itemkeyword'];
 $flag=$data_arr['flag'];
    //var_dump($cid . $qry);
        if(!empty($flag=="gen")){
            //$data = $this->db->get_where("products_tbl", ['prod_name' => $query])->row_array();
        $this->db->where("company_id",$cid);
        $this->db->where("account_name",$qry);
        $data=$this->db->get('ledgermaster_tbl')->result();
        }else{
            $data = $this->db->get("ledgermaster_tbl")->result();
        }
     echo json_encode($data);
      //  $this->response($data, REST_Controller::HTTP_OK);
    }



}
