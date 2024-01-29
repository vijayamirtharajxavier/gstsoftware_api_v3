<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Mpdf;
class Inventory extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->library('curl');
$this->load->helper('form');
//$this->load->library('m_pdf');


    //   $this->load->model('common_model');
    //   $this->load->model('login_model');


$this->secret= $this->session->userdata('authkey');

$this->headers = array(
         
         'X-API-Key: '. $this->secret
);
    


    }


		function samplepdf()
		{
			$this->load->library('pdf');
		//	$html = $this->load->view('samplepdf', [], true);
		//	$this->pdf->createPDF($html, 'mypdf', false);
		$data['page'] = 'New Report';

	$this->load->view('samplepdf',$data);

		}

		function printreceiptpayment_pdf()
		{
			$this->load->library('pdf');
		//	$html = $this->load->view('samplepdf', [], true);
		//	$this->pdf->createPDF($html, 'mypdf', false);
		$data['page'] = 'RECEIPT';

	$this->load->view('print_receiptpayment',$data);

		}

		function convertpdf()
		{
			$this->load->library('pdf');
			$html = $this->load->view('generatepdf', [], true);
			$this->pdf->createPDF($html, 'mypdf', false);


		}
		public function prodcutstock_openbal()
		{
			$data = array();
			$data['page'] = 'Products - Opening Stock';
			$this->load->view('product_openbal', $data);
	  }

		public function viewmpdf(){
			$data=array();
			$mpdf = new mPDF(['autoPageBreak' => true,
				'format' => 'A4',
				'default_font_size' => 0,
				'default_font' => '',
				'margin_left' => 10,
				'margin_right' => 10,
				'margin_top' => 105,
				'margin_bottom' => 18,
				'margin_header' => 9,
				'margin_footer' => 9,
				'orientation' => 'P',
		
			]);
	$mpdf->curlAllowUnsafeSslRequests = true;
	//$mpdf->showImageErrors = true;
	//$mpdf->debug = true;
	
	
	
			$invId= $this->input->get('inv');
			$cid= $this->input->get('cid');
			$data['invoiceData'] = $this->model_invoice->get_InvoiceData($cid,$invId);
			$invData = $this->model_invoice->get_InvoiceData($cid,$invId);
		
			foreach ($invData as $key => $value) {
			$pof_supply = $value['placeofsupply'];
			$invoice_date = $value['invoice_date'];
			$cpid=$value['creditperiod'];
	
			$cust_id=$value['cust_id'];
				# code...
			}
			$data['gstData'] = $this->model_invoice->get_GstData($pof_supply);
			$data['companyData'] = $this->model_invoice->get_CompData($cid);
			$compData =  $this->model_invoice->get_CompData($cid);
			foreach ($compData as $key => $compvalue) {
			$comp_statecode = $compvalue['company_statecode'];
			}
			 
			$data['orginData'] = $this->model_invoice->get_OrginData($comp_statecode);
			$orginData = $this->model_invoice->get_OrginData($comp_statecode);
		
			
			$data['customerData'] = $this->model_invoice->get_customerData($cust_id);
			
			$invDate = $invoice_date;
			$data['itemCount'] = $this->model_invoice->get_invoiceCount($invId,$invDate);
		
		$data['invoiceSub'] = $this->model_invoice->get_invoiceSub($invId,$invDate);
		$data['invoiceSubTotal'] =  $this->model_invoice->get_invoiceSubTot($cid,$invId);
		$data['AmountToWords'] = $this->getIndianCurrency($this->model_invoice->get_InvoiceValueData($cid,$invId)[0]['invoice_value']);
		 
	
	
		foreach ($data['invoiceData'] as $key => $row) { 
			$inv_id = $row['invoice_no'];
			
			$i_date = strtotime($row['invoice_date']);
			$inv_date =date("d-m-Y",$i_date);
			$ref_no = $row['order_no'];
			$cust_id=$row['cust_id'];
			$inv_date=date('d-m-Y', strtotime($row['invoice_date']));
			$inv_value=$row['invoice_value'];
			$dateofsupply = date('d-m-Y',strtotime($row['dateofsupply']));
			$order_date = date('d-m-Y',strtotime($row['order_date']));
			$order_no = $row['order_no'];
			$transport_mode = $row['transport_mode'];
			$vehicle_no = $row['vehicle_no'];
			$pof_supply = $row['placeofsupply'];
			
			
			}
			//$cid= $row['company_id'];
			$bill_statecode="";$bill_to_name ="";$ship_to_name="";$bill_add="";$ship_add="";
			$bill_gstin="";$ship_gstin="";$taxable_amount=0;
			// $cid=2;
				//foreach($dbh->query('SELECT * from gststate_tbl where statecode_id=' . $pof_supply ) as $poc) {
				foreach ($data['gstData'] as $key => $poc) {
						# code...
				 
				 $place_of_supply = $poc['state_name'] . " - (" . $poc['statecode_id'] . ")";
			 }
			
			
			
	
		// foreach($dbh->query('SELECT * from company_tbl where id=' . $cid ) as $cpnyrow) {
			foreach ($data['companyData'] as $key => $cpnyrow) {
				# code...
		
			$comp_id = $cpnyrow['id'];
			$comp_name = $cpnyrow['company_name'];
			$comp_add1 = $cpnyrow['company_add1'];
			$comp_add2 = $cpnyrow['company_add2'];
			$comp_add3 = $cpnyrow['company_add3'];
			$comp_state = $cpnyrow['company_state'];	 
			$comp_statecode = $cpnyrow['company_statecode'];
			$comp_gstin = $cpnyrow['company_gstin'];	 	 
			$comp_emailid = $cpnyrow['company_emailid'];
			$comp_contact = $cpnyrow['company_contact'];	
			$comp_logo = $cpnyrow['logo_path'] . $cpnyrow['logo_name'];
			$bnk_details = $cpnyrow['company_bank'];
			$bnk_qrcode = $cpnyrow['logo_path'] .  $cpnyrow['bharath_qr'];
			$upi_alt = $cpnyrow['upi_alter'];
			}
		 
		
		foreach ($data['customerData'] as $key => $custrow) {
			# code...
		 $cust_name = "M/S. " . $custrow['cust_name'];
		$bill_to_name = "M/S. " . $custrow['bill_to_name'];
		$bill_add = $custrow['bill_add'];
	/*	 $bill_add2 = $custrow['bill_add2'];
		$bill_add3 = $custrow['bill_add3']. '*/
		$bill_state = $custrow['bill_state'];
		$bill_statecode = $custrow['bill_statecode'];
		$bill_gstin = $custrow['bill_gstin'];
		$ship_to_name ="M/S. " . $custrow['ship_to_name'];
		$ship_add = $custrow['ship_add'];
	/*	 $ship_add2 = $custrow['ship_add2'];
		$ship_add3 = $custrow['ship_add3'];*/
		$ship_state = $custrow['ship_state'];
		$ship_gstin = $custrow['ship_gstin'];
		$ship_statecode = $custrow['ship_statecode'];
		
	}	
	
	if(substr($comp_gstin,0,2)==$bill_statecode) {
		$taxname = "Central Tax";
		$statetax = "State Tax";
	}
	else { 
		$taxname = "Integrated Tax";
		$statetax="";
	}
	
	$co_address = $comp_add1 . "," . $comp_add2 . "," . $comp_add3;
	$co_email =  "Email : " . $comp_emailid;
	$co_gstin = "GSTIN No. " . $comp_gstin;
	
	$itemdata =array();
	
	$badd = str_replace(",", "<br>", $bill_add);
	$sadd = str_replace(",", "<br>", $ship_add);
	
	
	$compadd = str_replace(",", " | ", $comp_add1 . $comp_add2 . $comp_add3). ' <br /> ' . "Phone :" . $comp_contact . " | E-mail :" . $comp_emailid;
	
	$billto = '<strong>' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $bill_gstin . '</strong><br /> State Code : ' . $bill_statecode;
	//echo base_url() . $comp_logo;
	$head_tbl = '<div style="text-align: center;margin-bottom:10px;">TAX INVOICE</div>
	<div style="margin-left:10px;margin-top:20px;width:60px;height:50px;"><img padding="10px" src="'. base_url() . $comp_logo .'" width="60px" height="60px"></div> <div style="float:right;margin-top:-70px;">';
	if(!$bnk_qrcode=null)
	{
	$head_tbl = '<div style="float:right;font-size:12px;font-weight:bold;margin-left:650px;">G-Pay</div><img style="float:right" padding="10px;margin-right:10px;" src="' . base_url() . $bnk_qrcode . '" width="100px" height="100px"></div>';
  }
	$head_tbl = '<div style="text-align: center;font-size:28px;font-weight:bold;margin-top:-100px">'. $comp_name .'</div>
	<div style="text-align: center;font-size:10px;margin-top:-60px;">'. $compadd .'</div>
	<div style="text-align: center;font-size:18px;margin-top:-30px;">GSTIN : '. $comp_gstin .'</div>
	<div height="200px" width="100%" style="margin-top:10px;">
	
	<table style="width:100%" style="border-collapse:collapse;font-size:14px;">
	<tr>
		<th style="border:1px solid;border-bottom:none;background-color:#f5f6f7;width:500px;">Details of Buyer</th>
		<th colspan="6" style="border:1px solid;border-bottom:none;background-color:#f5f6f7;width:400px;">Invoice Details</th>
	</tr>
	<tr>
	<td height="200px" style="border:1px solid;padding: 15px;font-size:16px;width:450px;height:200px;" rowspan="10" valign="top">'. $billto .' </td>
	<td style="border:1px solid;text-align:center;width:50px;padding: 15px;background-color:#f5f6f7;font-size:16px;">Invoice #</td>
	<td  style="width:50px;border:1px solid;text-align:center;padding: 15px;background-color:#f5f6f7;font-size:16px;">Invoice Date</td>
	</tr>
	<tr>
	<td style="border:1px solid;font-size:16px;text-align:center;width:100px;padding: 15px;font-weight:bold;">'. $inv_id .'</td>
	<td  style="width:100px;border:1px solid;font-size:16px;text-align:center;padding: 15px;font-weight:bold;">'. $inv_date .'</td>
	</tr>
	<tr>
	<td style="border:1px solid;text-align:center;width:100px;background-color:#f5f6f7;padding: 15px;font-size:16px;">Ref #</td>
	<td align="center" style="border:1px solid;text-align:center;width:100px;background-color:#f5f6f7;padding: 15px;font-size:16px;">Page #</td>
	<tr>
	<td style="border:1px solid;font-size:16px;text-align:center;width:100px;padding: 15px;">'. $ref_no .'</td>
	<td align="center" style="border:1px solid;font-size:16px;width:100px;padding: 15px;"> {PAGENO}/{nb} </td>
	</tr>
	<tr>
	<td colspan="2" style="border:1px solid;font-size:16px;text-align:center;width:100px;padding: 15px;">CREDIT PERIOD : &nbsp;'. $cpid .'</td>
	</tr>
	</table>
	</div>';
	
	
		
		$mpdf->setFooter('<p align="right">Contd...</p>');
	///$htmlout = $this->load->view('')
	$htmlout=$this->load->view('invatk_temp',$data,true);
	//var_dump($htmlout);
	//$mpdf->WriteHTML($head_tbl,1);
	
	
	$mpdf->SetHTMLHeader($head_tbl);
	
	$tot_lines = $mpdf->_getHtmlHeight($head_tbl);
	if($tot_lines>81)
	{
		//  echo $tot_lines;
		 
			$mpdf->setFooter('<p align="right">Contd...</p>');
	//    $mpdf->SetFooter('<p align="left">This is a Computer Generated Invoice</p><p style="margin-top:-10px;" align="right">E. & O.E.</p>', 'O');
	$mpdf->SetHTMLHeader($head_tbl);
	
	//$mpdf->SetHTMLHeader($head_tbl);
	//$mpdf->AddPage();
	
	}
	else {
	//$mpdf->setFooter('<p align="right">Contd...</p>' . $tot_lines);
	
	//$mpdf->AddPage();
	
	
	}
	//$path = base_url()."assets/css/style.css";
	//$stylesheet = file_get_contents($path);
	//$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($htmlout,0);
	//$mpdf->WriteHTML($htmlout, \Mpdf\HTMLParserMode::HTML_BODY);
	//$mpdf->WriteHTML( $tot_lines);
	//$mpdf->setFooter('<p align="right">Contd...</p>' . $tot_lines);
	//var_dump($tot_lines);
	$mpdf->SetFooter('<div style="font-size:10px;" align="left">This is a Computer Generated Invoice</div><div align="right" style="margin-top:-10px;font-size:10px;">E. & O.E.</div>', 'O' . $tot_lines);
	//echo $head_tbl;
	//echo $htmlout;
	$mpdf->Output();
	
	
		
				//echo "TEST";
			//		$this->load->library('mpdf');
			//		$mpdf = new \MPDF\MPDF();
		//			$mpdf = new mPDF();
		//			$html_data = $this->load->view('invtest_temp.php',$data,true);
					//$html = $this->load->view('mms_invtmp3_storeview.php' ,$data,true);
		//			$mpdf->WriteHTML($html_data,2);
		//			$mpdf->Output(); // opens in browser
			// var_dump($data);
			// echo $html_data;  
				}
					

    public function newpurchase(){
        $data = array();
        $data['page'] = 'New Purchase';
        $this->load->view('purchaseentry', $data);
    }

    public function newsales(){
        $data = array();
        $data['page'] = 'New Sales';
        $this->load->view('salesentry', $data);
    }

    public function salesreg(){
        $data = array();
        $data['page'] = 'Sales Register';
				$date['trans_type'] ='SALE';
				$compId = $this->session->userdata('id');

				$url=$this->config->item("api_url") . "/api/productlist/getCreditAccount";
				$post = array("compId"=>$compId,"trans_type"=>"SALE");
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
					$response = curl_exec($ch);
					//var_dump($response);
					//$result = json_decode($response);
					curl_close($ch); // Close the connection
				$crAcct = json_decode($response, true);
				//var_dump($crAcct);
				$data['cr_account'] = $crAcct['id'];
        $this->load->view('salesreport', $data);
    
    }
    public function rsalesreg(){
        $data = array();
        $data['page'] = 'Credit Note / Sales Return Register';
				$date['trans_type'] ='SRTN';
				$url=$this->config->item("api_url") . "/api/productlist/getCreditAccount";
				$post = array("compId"=>$compId,"trans_type"=>"SRTN");
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
					$response = curl_exec($ch);
					//$result = json_decode($response);
					curl_close($ch); // Close the connection
				$crAcct = json_decode($response, true);
				$data['cr_account'] = $crAcct['id'];
        $this->load->view('rsalesreport', $data);
    }
    public function rpurchasereg(){
			$data = array();
			$data['page'] = 'Debit Note / Purchase Return Register';
			$date['trans_type'] ='PRTN';
			$url=$this->config->item("api_url") . "/api/productlist/getCreditAccount";
			$post = array("compId"=>$compId,"trans_type"=>"PRTN");
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				$response = curl_exec($ch);
				//$result = json_decode($response);
				curl_close($ch); // Close the connection
			$crAcct = json_decode($response, true);
			$data['cr_account'] = $crAcct['id'];
			$this->load->view('rpurchasereport', $data);
	}

    public function purreg(){
        $data = array();
        $data['page'] = 'Purchase Register';
				$date['trans_type'] ='PURC';
				$url=$this->config->item("api_url") . "/api/productlist/getCreditAccount";
				$post = array("compId"=>$compId,"trans_type"=>"PURC");
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
					$response = curl_exec($ch);
					//$result = json_decode($response);
					curl_close($ch); // Close the connection
				$crAcct = json_decode($response, true);
				$data['cr_account'] = $crAcct['id'];				
				$this->load->view('purchasereport', $data);
    }
    public function rpurreg(){
			$data = array();
			$data['page'] = 'Debit Note / Purchase Return Register';
			$url=$this->config->item("api_url") . "/api/productlist/getCreditAccount";
			$post = array("compId"=>$compId,"trans_type"=>"PRTN");
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				$response = curl_exec($ch);
				//$result = json_decode($response);
				curl_close($ch); // Close the connection
			$crAcct = json_decode($response, true);
			$data['cr_account'] = $crAcct['id'];
			$this->load->view('rpurchasereport', $data);
	}

    public function salesinvoiceprint(){
        $data = array();
        $data['page'] = 'Sales Invoice';
        $this->load->view('salesinvoice', $data);
    }
    public function salesregister(){
        $data = array();
        $data['page'] = 'Sales Register';
        $this->load->view('allsales', $data);
    }


public function getInvLedgerAccount()
{
$url=$this->config->item("api_url") . "/api/ledger";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray['ledger'] as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['account_name'].'</option>';

}
$option .= '<option selected  disabled value="0">Select a Vendor</option>';
echo $option;

}


public function getInvoicePdfbyid()
{


$himgpath=base_url('assets/img/jva_head.jpg');
$hext= pathinfo($himgpath, PATHINFO_EXTENSION);
$hdata = file_get_contents($himgpath);
$hbase64 = 'data:image/' . $hext. ';base64,' . base64_encode($hdata);

$fimgpath=base_url('assets/img/jva_footer.jpg');
$fext= pathinfo($fimgpath, PATHINFO_EXTENSION);
$fdata = file_get_contents($fimgpath);
$fbase64 = 'data:image/' . $fext. ';base64,' . base64_encode($fdata);


$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//getTax breakup
$url=$this->config->item("api_url") . "/api/reports/gettaxesbyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $taxesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;

curl_close($ch); // Close the connection
//var_dump($taxesbyidresponse);
$taxobj = json_decode($taxesbyidresponse,true);
//var_dump(json_decode($taxesbyidresponse,true));

$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems

$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid_get/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 
/*
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> ';
*/
$tbl="";



$pg=1;

$pgbrk =31;
$pglines=32;
/*
$tbl .='<div id="page-wrap">';
$tbl .='<table id="items" >';
$tbl .='<caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr><td id="valign" colspan="18" valign="top">';


$tbl .='<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:18px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$bill_to_name='xyz';
$bill_add='abc';
$bill_statecode='33';
$inv_id='1111'; */
//var_dump($obj);

foreach ($obj as  $mvalue) {
$actid = $mvalue['db_account'];

//var_dump($mvalue);
$url=$this->config->item("api_url") . "/api/inventorylist/ledgerbyidbycid";// . $actid ;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse,true);


$lname=$ldgerArray[0]['account_name'];
$laddress=$ldgerArray[0]['account_address'];
$lgstin=$ldgerArray[0]['account_gstin'];
$lemail=$ldgerArray[0]['account_email'];
$lcontact=$ldgerArray[0]['account_contact'];
$lstatecode=$ldgerArray[0]['account_statecode'];
$lbustype=$ldgerArray[0]['bus_type'];
//var_dump($lname );

//$count = count($objItems);

$number_of_rows= count($objItems);

$pgs= ceil($number_of_rows/$pgbrk);


$tbl .='<tr></tr>
          <th id="details" colspan="6">Details of Buyer</th>
          <th id="details" colspan="12">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong id="custname">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong id="custadd"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong id="invno">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong id="invdate">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong id="orderno"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong id="pgs"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         
$tbl .=  '<tr></tr>';
if($lbustype=="1")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th id="prod">PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="8"></th>
            
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;

foreach ($objItems as  $item) {
    
   // var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }
       if($item['item_desc']<>"") {
            //$item_name = $item['item_name'];
            $item_nar = $item['item_desc'];
        } else {
            $item_nar = "";
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
/*
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:14px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_mrp'] . '</td>';

$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';

*/
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:14px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT INVOICE</th>  
          <tr>
          
        <div style="float:left; "><td style="float:left;" colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $mvalue['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y",strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          
         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="8"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>


        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td><td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;



foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
 
    $tbl .= '<table id="items" style="margin-top:5px;font-size:18px;" >
    <tr>

    <td colspan="10"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="8"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';
}
else if($lbustype=="0")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;
$totcgst=0;
$totigst=0;
$totsgst=0;
foreach ($objItems as  $item) {
    
    //var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }

//      $item_name = $item['item_name'];
       if($item['item_desc']<>"") {
            
            $item_nar = $item['item_desc'];
        } else {
            $item_nar =""; // $item['item_name'];
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:12px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="left" style="border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';

$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:12px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

/*

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT kkkkINVOICE</th>  
          <tr>
          
        <div style="float:left; "><td style="float:left;" colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $value['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $value['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . $value['trans_date'] . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $value['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          

*/

$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         

         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
        
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;


//var_dump($taxobj);
foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
    $tbl .= '<table id="items" style="margin-top:5px;font-size:16px;" >
    <tr>
    <td colspan="6"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="6"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';



} // Bus Type =0

    $tbl .= '</table>';

    
 $tbl .= '<div class=""><p><span style="float:right">This is a Computer Generated Invoice</p></span> </div><br><div align="right">E. & O.E.</div>';



    # code...
//var_dump($value);



} //obj

$tbl .= '</table>';





$html='<html>
    <head>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 3cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 4cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }


table caption #items{
    margin-top:5px;
    font-size:14px;
}
#valign {
  text-align:center;
}

#details{
  text-align:center;

}
#custname {
  font-size:20px;
}

#custadd{
  font-size:16px;
}

#invno {
  font-size:25px;
}
#invdate{
  font-size:25px;
}
#orderno{
  font-size:18px;
}
#pgs {
  font-size:25px;
}

#prod {
  width:500px;
}

        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
                <img src="'. $hbase64 .'" alt="JVA" width="100%" height="110%" >

            <!--<img src="header.png" width="100%"/> -->
        </header>

        <footer>
            <img src="'. $fbase64 .'" width="100%" height="100%"/>
        </footer>




        <!-- Wrap the content of your PDF inside a main tag -->
        <main>';
        $html.= $tbl;
        $html.='</main>
    </body>
</html>';


//var_dump($html);

        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
//$canvas = $this->dompdf->get_canvas();
//$font = Font_Metrics::get_font("DejaVu Mono", "bold");
//$canvas->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        
        // Render the HTML as PDF
        $this->dompdf->render();
      // $this->dompdf->stream("welcome.pdf");
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("_invoice.pdf", array("Attachment"=>1));


}


public function old_getInvoicePdfbyid()
{
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//getTax breakup
$url=$this->config->item("api_url") . "/api/reports/gettaxesbyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $taxesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;

curl_close($ch); // Close the connection
//var_dump($taxesbyidresponse);
$taxobj = json_decode($taxesbyidresponse,true);
//var_dump(json_decode($taxesbyidresponse,true));

$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems

$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 



$tbl="";
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<style type="text/css">
    .pagebreak { page-break-before: always;} 
    .bdr {border: none;}
.breakAfter {
    page-break-after: always
}
</style>';
$pg=1;

$pgbrk =31;
$pglines=32;

$tbl .='<div id="page-wrap">';
$tbl .='<table id="items"  style="margin-top:5px;font-size:14px;" >';
$tbl .='<caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr><td colspan="18" valign="top" style="text-align:center;">';

$tbl .='<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:18px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$bill_to_name='xyz';
$bill_add='abc';
$bill_statecode='33';
$inv_id='1111';
//var_dump($obj);
foreach ($obj as  $mvalue) {
$actid = $mvalue['db_account'];

//var_dump($mvalue);
$url=$this->config->item("api_url") . "/api/ledger/" . $actid ;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);


$lname=$ldgerArray->account_name;
$laddress=$ldgerArray->account_address;
$lgstin=$ldgerArray->account_gstin;
$lemail=$ldgerArray->account_email;
$lcontact=$ldgerArray->account_contact;
$lstatecode=$ldgerArray->account_statecode;
$lbustype=$ldgerArray->bus_type;
//var_dump($lname );

//$count = count($objItems);

$number_of_rows= count($objItems);

$pgs= ceil($number_of_rows/$pgbrk);



$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         
$tbl .=  '<tr></tr>';
if($lbustype=="1")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="8"></th>
            
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;

foreach ($objItems as  $item) {
    
   // var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }
       if($item['item_desc']<>"") {
            //$item_name = $item['item_name'];
            $item_nar = $item['item_desc'];
        } else {
            $item_nar = "";
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:14px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_mrp'] . '</td>';

$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:14px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT INVOICE</th>  
          <tr>
          
        <div><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $mvalue['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y",strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          
         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="8"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>


        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td><td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;



foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
 
    $tbl .= '<table id="items" style="margin-top:5px;font-size:18px;" >
    <tr>

    <td colspan="10"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="8"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';
}
else if($lbustype=="0")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;
$totcgst=0;
$totigst=0;
$totsgst=0;
foreach ($objItems as  $item) {
    
    //var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }

//      $item_name = $item['item_name'];
       if($item['item_desc']<>"") {
            
            $item_nar = $item['item_desc'];
        } else {
            $item_nar =""; // $item['item_name'];
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:12px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="left" style="border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';

$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:12px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

/*

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT kkkkINVOICE</th>  
          <tr>
          
        <div style="float:left; "><td style="float:left;" colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $value['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $value['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . $value['trans_date'] . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $value['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          

*/

$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         

         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
        
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;


//var_dump($taxobj);
foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
    $tbl .= '<table id="items" style="margin-top:5px;font-size:16px;" >
    <tr>
    <td colspan="6"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="6"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';



} // Bus Type =0

    $tbl .= '</table>';

    
 $tbl .= '<div class=""><p><span style="float:right">This is a Computer Generated Invoice</p></span> </div><br><div align="right">E. & O.E.</div>';



    # code...
//var_dump($value);



} //obj

$tbl .= '</table>';

//$tbl .= '</div></table>';
//echo $tbl;



//var_dump($event_data);
//echo $event_data;
        $this->load->library('pdf');
        
        // Load HTML content
        $this->dompdf->loadHtml($tbl);
        
        // (Optional) Setup the paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');
//$canvas = $this->dompdf->get_canvas();
//$font = Font_Metrics::get_font("DejaVu Mono", "bold");
//$canvas->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        
        // Render the HTML as PDF
        $this->dompdf->render();
      // $this->dompdf->stream("welcome.pdf");
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream($mvalue['trans_id'] . "_invoice.pdf", array("Attachment"=>1));


}


public function getInvoiceprintbyid()
{
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//getTax breakup
$url=$this->config->item("api_url") . "/api/reports/gettaxesbyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $taxesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;

curl_close($ch); // Close the connection
//var_dump($taxesbyidresponse);
$taxobj = json_decode($taxesbyidresponse,true);
//var_dump(json_decode($taxesbyidresponse,true));
$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems
$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid_get/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid_get/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 



$tbl="";
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<style type="text/css">
    .pagebreak { page-break-before: always;} 
    .bdr {border: none;}
.breakAfter {
    page-break-after: always
}
</style>';
$pg=1;

$pgbrk =31;
$pglines=32;

$tbl .='<div id="page-wrap">';
$tbl .='<table id="items"  style="margin-top:5px;font-size:14px;" >';
$tbl .='<caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr><td colspan="18" valign="top" style="text-align:center;">';

$tbl .='<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:18px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$bill_to_name='xyz';
$bill_add='abc';
$bill_statecode='33';
$inv_id='1111';
//var_dump($obj);
foreach ($obj as  $mvalue) {
$actid = $mvalue['db_account'];

//var_dump($mvalue);
//ledgerbyidbycid
$url=$this->config->item("api_url") . "/api/productlist/ledgerbyidbycid";

//$url=$this->config->item("api_url") . "/api/ledger/" . $actid ;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse,true);
//var_dump($ldgerArray);

$lname=$ldgerArray[0]['account_name'];
$laddress=$ldgerArray[0]['account_address'];
$lgstin=$ldgerArray[0]['account_gstin'];
$lemail=$ldgerArray[0]['account_email'];
$lcontact=$ldgerArray[0]['account_contact'];
$lstatecode=$ldgerArray[0]['account_statecode'];
$lbustype=$ldgerArray[0]['bus_type'];
//var_dump($lname );

//$count = count($objItems);

$number_of_rows= count($objItems);

$pgs= ceil($number_of_rows/$pgbrk);



$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         
$tbl .=  '<tr></tr>';
if($lbustype=="1")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="8"></th>
            
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;

foreach ($objItems as  $item) {
    
   // var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }
       if($item['item_desc']<>"") {
            //$item_name = $item['item_name'];
            $item_nar = $item['item_desc'];
        } else {
            $item_nar = "";
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:14px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item['item_mrp'] . '</td>';

$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="font-size:14px;border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:14px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT INVOICE</th>  
          <tr>
          
        <div><td  colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $mvalue['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y",strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          
         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="8"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>


        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td><td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;



foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
 
    $tbl .= '<table id="items" style="margin-top:5px;font-size:18px;" >
    <tr>

    <td colspan="10"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="8"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';
}
else if($lbustype=="0")
{
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
              
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;
$totcgst=0;
$totigst=0;
$totsgst=0;
foreach ($objItems as  $item) {
    
    //var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }

//      $item_name = $item['item_name'];
       if($item['item_desc']<>"") {
            
            $item_nar = $item['item_desc'];
        } else {
            $item_nar =""; // $item['item_name'];
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="font-size:12px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
$tbl .= '<td align="left" style="border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';

$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:12px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

/*

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT kkkkINVOICE</th>  
          <tr>
          
        <div style="float:left; "><td style="float:left;" colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $value['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $value['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . $value['trans_date'] . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $value['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          

*/

$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         

         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
        
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;


//var_dump($taxobj);
foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
    $tbl .= '<table id="items" style="margin-top:5px;font-size:16px;" >
    <tr>
    <td colspan="6"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="6"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';



} // Bus Type =0

    $tbl .= '</table>';

    
 $tbl .= '<div class=""><p><span style="float:right">This is a Computer Generated Invoice</p></span> </div><br><div align="right">E. & O.E.</div>';



    # code...
//var_dump($value);



} //obj

$tbl .= '</table>';

//$tbl .= '</div></table>';
echo $tbl;

}


public function Invoiceprintbyid()
{
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//getTax breakup


$url=$this->config->item("api_url") . "/api/inventorylist/getCompanybyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $companyresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;
//var_dump($companyresponse);
curl_close($ch); // Close the connection
$compobj = json_decode($companyresponse,true);
if($compobj)
{
foreach ($compobj as  $cpnyrow) {
	//$comp_id = $cpnyrow[0]['id'];
	$comp_name = $cpnyrow['company_name'];
//	$comp_add1 = $cpnyrow['company_add1'];
//	$comp_add2 = $cpnyrow['company_add2'];
//	$comp_add3 = $cpnyrow['company_add3'];
//	$comp_state = $cpnyrow['company_state'];	 
//	$comp_statecode = $cpnyrow['company_statecode'];
	$comp_gstin = $cpnyrow['company_gstin'];	 	 
//	$comp_emailid = $cpnyrow['company_emailid'];
	$comp_contact = $cpnyrow['company_contact'];	
	$comp_logo = $cpnyrow['logo_path'] . $cpnyrow['logo_name'];
//	$bnk_details = $cpnyrow['company_bank'];
	$bnk_qrcode = $cpnyrow['logo_path'] .  $cpnyrow['bharath_qr'];
	$upi_alt = $cpnyrow['upi_alter'];
} 

}
$url=$this->config->item("api_url") . "/api/reports/gettaxesbyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $taxesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;

curl_close($ch); // Close the connection
//var_dump($taxesbyidresponse);
$taxobj = json_decode($taxesbyidresponse,true);
//var_dump(json_decode($taxesbyidresponse,true));
$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems
$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid_get/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid_get/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 



$tbl="";
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<style type="text/css">
    .pagebreak { page-break-before: always;} 
    .bdr {border: none;}
.breakAfter {
    page-break-after: always
}
#items_head {
  border-collapse:collapse;
border:none;
}
</style>';
$pg=1;

$pgbrk =31;
$pglines=32;

$tbl .='<div id="page-wrap">';
$tbl .='<table id="items_head" style="width:900px;margin-top:5px;font-size:14px;" >';
$tbl .='<caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .='<tr>';
$tbl .= '<td colspan="1" valign="top" style="border:none;text-align:center;">';
$tbl .='<div style="border:none;margin-left:10px;margin-right:10px;margin-top:20px;width:80px;height:50px;text-align:center;"><img padding="10px" src="'. base_url() . $comp_logo .'" width="60px" height="60px"></div></td>'; 
$tbl .='<td colspan="14"  style="border:none;text-align:center"><strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';
$tbl .='<br><div style="font-size:18px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ) . ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email');
$tbl .='<br><strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>';
//$tbl .='<td><div style="float:right;font-size:12px;font-weight:bold;margin-left:650px;">G-Pay</div><img style="float:right" padding="10px;margin-right:10px;" src="' . base_url() . $bnk_qrcode . '" width="100px" height="100px"></div></td>';
$tbl .='<td style="margin-left:500px;border:none;text-align:center">G-Pay<br><img style="float:center" padding="10px;" src="' . base_url() . $bnk_qrcode . '" width="100px" height="100px"></td>';
$tbl .='</table>'; 
$tbl .='<table id="items"  style="margin-top:5px;font-size:14px;" >';

//$tbl .= '<tr><td colspan="18" valign="top" style="text-align:center;">';

//$tbl .='<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

//$tbl .='<br><div style="font-size:18px;color:grey;">';
//$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
//<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
//</tr>';
$tbl .='</tr>';

$bill_to_name='xyz';
$bill_add='abc';
$bill_statecode='33';
$inv_id='1111';
//var_dump($obj);
foreach ($obj as  $mvalue) {
$actid = $mvalue['db_account'];

//var_dump($mvalue);
//ledgerbyidbycid
$url=$this->config->item("api_url") . "/api/productlist/ledgerbyidbycid";

//$url=$this->config->item("api_url") . "/api/ledger/" . $actid ;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse,true);
//var_dump($ldgerArray);

$lname=$ldgerArray[0]['account_name'];
$laddress=$ldgerArray[0]['account_address'];
$lgstin=$ldgerArray[0]['account_gstin'];
$lemail=$ldgerArray[0]['account_email'];
$lcontact=$ldgerArray[0]['account_contact'];
$lstatecode=$ldgerArray[0]['account_statecode'];
$lbustype=$ldgerArray[0]['bus_type'];
//var_dump($lname );

//$count = count($objItems);

$number_of_rows= count($objItems);

$pgs= ceil($number_of_rows/$pgbrk);



$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         
$tbl .=  '<tr></tr>';
          $tbl .= '<tr>
              <th style="width:10px;">SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            
            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;
$totcgst=0;
$totigst=0;
$totsgst=0;
foreach ($objItems as  $item) {
    
    //var_dump($item);

       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }

//      $item_name = $item['item_name'];
       if($item['item_desc']<>"") {
            
            $item_nar = $item['item_desc'];
        } else {
            $item_nar =""; // $item['item_name'];
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl .= '<tr>';
        
$tbl .= '<td align="center" style="width:10px; border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl .= '<td style="white-space:nowrap; font-size:12px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
//$tbl .= '<td align="left" style="border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_mrp"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_qty"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_rate"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["taxable_amount"]. '</td>';
$tbl .= '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl .= '</tr>';

$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
{
$rc=1;
    $r=1;
    $pg=$pg+1;
$tbl .= '<div class="pagebreak"></div>';
    $tbl .= '</table>';
    $tbl .= '<br>';
    $tbl .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl .= '<div class="breakAfter"></div>';
    $tbl .= '<table id="items" style="margin-top:5px;font-size:12px;" >
          <caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';
$tbl .= '<tr>
            <td colspan="17" valign="top" style="text-align:center;">';
                $tbl .= '<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

$tbl .='<br><div style="font-size:14px;color:grey;">';
$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
</tr>';

/*

$tbl .='<tr></tr>
          <th colspan="8" style="text-align:center;">Details of Buyer</th>
          <th colspan="10"  style="text-align:center;">CREDIT kkkkINVOICE</th>  
          <tr>
          
        <div style="float:left; "><td style="float:left;" colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">' . $bill_to_name . ' </strong><br />' . str_replace(",", "<br>", $bill_add) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $value['gstin'] . '</strong><br /> State Code : ' . $bill_statecode . '</td></div>';
  $tbl .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $value['trans_id'] . '</strong></p></td>
  <td colspan="5" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . $value['trans_date'] . '</strong></p></td></tr><tr>
  <tr><td colspan="5" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $value['order_no'] . '</strong></p></td>';
 $tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  $tbl .= '</tr><tr>';          

*/

$tbl .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl .= '<td colspan="6" valign="top"><strong>Invoice No.</strong><p align="center"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="6" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl .= '<td colspan="5"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center">' . $pg . '/' . $pgs . '</strong></p></td>';
  
$tbl .= '</tr><tr>';          
         

         
          $tbl .=  '<tr></tr>';
          $tbl .= '</tr>';
           
           
           $tbl .= '<tr></tr>';
          
          $tbl .= '<tr>
              <th>SL.NO.</th>
              <th style="width:500px" >PRODUCT / SERVICE</th>
              <th>DESCRIPTION</th>
              <th>HSN/SAC</th>
        
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
              <th colspan="2">CGST</td>
              
              
              <th colspan="2">SGST</th>
              <th colspan="2">IGST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="7"></th>
            <th>%</th>
            
            <th>&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>%</th>
            <th>&nbsp;&#8377;</th>
            <th>&nbsp;&#8377;</th>
            
          </tr>';


     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl .= '<tr><td colspan="6" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
           $tbl .= '<td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl .= '</tr>';
        

$tbl .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl .= '</tr><tr></tr>';
$tbl .= '<table id="items" style="margin-top:5px;font-size:12px;"><tr></tr>';
    
$tbl .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;


//var_dump($taxobj);
foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl .= '<tr>';
 $tbl .= '<td align="center">'. $gstpc . '%</td>';
 $tbl .= '<td align="right">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center" >'. $igstpc .'</td>';
 $tbl .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl .= '<td align="center" >'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl .= '<td align="center">'. $divgst .'</td>';
 $tbl .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl .= '<td align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl .= '<tr>
 <td><strong>Total</strong></td><td align="right"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl .= '</tr>';
  
 $tbl .= '</tbody>';
 $tbl .= '<tr></tr>';
 $tbl .= '</table>';
 $bnkdetails=str_replace(",", "</BR>", $this->session->userdata('cbankdetails'));
    $tbl .= '<table id="items" style="margin-top:5px;font-size:16px;" >
    <tr>
    <td colspan="6"  style="border-right:none"><p>' . $bnkdetails . '</p></td>
    <td colspan="6"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';




    $tbl .= '</table>';

    
 $tbl .= '<div class=""><p><span style="float:right">This is a Computer Generated Invoice</p></span> </div><br><div align="right">E. & O.E.</div>';



    # code...
//var_dump($value);



} //obj

$tbl .= '</table>';

//$tbl .= '</div></table>';
echo $tbl;

}


public function new_Invoiceprintbyid()
{
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type = $this->input->get('trans_type');
//$trans_type="SALE";
//getTax breakup


$url=$this->config->item("api_url") . "/api/inventorylist/getCompanybyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $companyresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;
//var_dump($companyresponse);
curl_close($ch); // Close the connection
$compobj = json_decode($companyresponse,true);
if($compobj)
{
foreach ($compobj as  $cpnyrow) {
	//$comp_id = $cpnyrow[0]['id'];
	$comp_name = $cpnyrow['company_name'];
//	$comp_add1 = $cpnyrow['company_add1'];
//	$comp_add2 = $cpnyrow['company_add2'];
//	$comp_add3 = $cpnyrow['company_add3'];
//	$comp_state = $cpnyrow['company_state'];	 
//	$comp_statecode = $cpnyrow['company_statecode'];
	$comp_gstin = $cpnyrow['company_gstin'];	 	 
//	$comp_emailid = $cpnyrow['company_emailid'];
	$comp_contact = $cpnyrow['company_contact'];	
	$comp_logo = $cpnyrow['logo_path'] . $cpnyrow['logo_name'];
	$upi_name = $cpnyrow['upi_name'];
//	$bnk_details = $cpnyrow['company_bank'];
	$bnk_qrcode = $cpnyrow['logo_path'] .  $cpnyrow['bharath_qr'];
	$upi_alt = $cpnyrow['upi_alter'];
	if($cpnyrow['comp_seal'])
{
		$comp_rseal = $cpnyrow['logo_path'] . $cpnyrow['comp_seal'];
}
else
{
	$comp_rseal='';
}
} 

}
$url=$this->config->item("api_url") . "/api/reports/gettaxesbyid";

$data = array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $taxesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $taxesbyidresponse;

curl_close($ch); // Close the connection
//var_dump($taxesbyidresponse);
$taxobj = json_decode($taxesbyidresponse,true);
//var_dump(json_decode($taxesbyidresponse,true));
$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems
$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid_get/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid_get/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 
$tbl_rupees="";
$tbl_item_tax="";
$tbl_final="";
$tbl_head="";
$tbl_buyer_head="";
$tbl_items="";
$tbl_item_head="";
$tbl_footer="";
$tbl_main="";
$tbl_items_row_tot="";
$dummy_tbl ="";
$tbl="";
$tbl_page_head="";
ECHO '<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invprint.css"> 
<link rel="stylesheet" type="text/css" href="'. base_url() . 'assets/css/invstyle.css"> 
<style type="text/css">
    .pagebreak { page-break-before: always;} 
    .bdr {border: none;}
.breakAfter {
    page-break-after: always
}
#items_head {
  border-collapse:collapse;
border:none;
}
</style>';
$pg=1;

$pgbrk =20;
$pglines=22;

$tbl_head .='<div id="page-wrap" style="align-content:center;">';
$tbl_head .='<table id="items_head" style="border-collapse:collapse;width:900px;margin-top:5px;font-size:14px;" >';
if($trans_type=="SALE")
{
	$tbl_head .='<caption style="font-size:30px;text-align:center;">TAX INVOICE</caption>';

}
if($trans_type=="SRTN")
{
	$tbl_head .='<caption style="font-size:30px;text-align:center;">CREDIT NOTE</caption>';

}
if($trans_type=="PRTN")
{
	$tbl_head .='<caption style="font-size:30px;text-align:center;">DEBIT NOTE</caption>';

}
$tbl_head .='<tr>';
$tbl_head .= '<td colspan="1" valign="top" style="border:none;text-align:center;">';
$tbl_head .='<div style="border:none;margin-left:10px;margin-right:10px;margin-top:20px;width:80px;height:50px;text-align:center;"><img padding="10px" src="'. base_url() . $comp_logo .'" width="60px" height="60px"></div></td>'; 
$tbl_head .='<td colspan="14"  style="border:none;text-align:center"><strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';
$tbl_head .='<br><div style="font-size:18px;color:grey;">';
$tbl_head .= str_replace(",", " | ", $this->session->userdata('cadd') ) . ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email');
$tbl_head .='<br><strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>';
//$tbl .='<td><div style="float:right;font-size:12px;font-weight:bold;margin-left:650px;">G-Pay</div><img style="float:right" padding="10px;margin-right:10px;" src="' . base_url() . $bnk_qrcode . '" width="100px" height="100px"></div></td>';
if($cpnyrow['bharath_qr'])
{
	$tbl_head .='<td style="margin-left:500px;border:none;text-align:center">'. $upi_name .'<br><img style="float:center" padding="10px;" src="' . base_url() . $bnk_qrcode . '" width="100px" height="100px"></td>';
}
else {
	$tbl_head .='<td style="margin-left:500px;border:none;text-align:center;"><img width="100px" height="100px" style="border:none;"></td>';
}
$tbl_head .='</table>'; 


$tbl_main .='<table id="items"  style="width:900px;margin-top:5px;font-size:14px;" >';

//$tbl .= '<tr><td colspan="18" valign="top" style="text-align:center;">';

//$tbl .='<strong style="font-size:35px;text-align:center;color:blue;">' . $this->session->userdata('cname') . '</strong>';

//$tbl .='<br><div style="font-size:18px;color:grey;">';
//$tbl .= str_replace(",", " | ", $this->session->userdata('cadd') ). ' <br /> ' . "Phone :" . $this->session->userdata('contact') . " | E-mail :" . $this->session->userdata('email'). '<br />
//<strong style="font-size:20px;padding-top:10px;color:red;">GSTIN : ' . $this->session->userdata('gstin') . '</div></strong></td>
//</tr>';
$tbl_main .='</tr>';

$bill_to_name='xyz';
$bill_add='abc';
$bill_statecode='33';
$inv_id='1111';
//var_dump($obj);
foreach ($obj as  $mvalue) {
$actid = $mvalue['db_account'];

//var_dump($mvalue);
//ledgerbyidbycid
$url=$this->config->item("api_url") . "/api/productlist/ledgerbyidbycid";

//$url=$this->config->item("api_url") . "/api/ledger/" . $actid ;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse,true);
//var_dump($ldgerArray);

$lname=$ldgerArray[0]['account_name'];
$laddress=$ldgerArray[0]['account_address'];
$lgstin=$ldgerArray[0]['account_gstin'];
$lemail=$ldgerArray[0]['account_email'];
$lcontact=$ldgerArray[0]['account_contact'];
$lstatecode=$ldgerArray[0]['account_statecode'];
$lbustype=$ldgerArray[0]['bus_type'];
//var_dump($lname );

//$count = count($objItems);

$number_of_rows= count($objItems);

$pgs= ceil($number_of_rows/$pgbrk);

//' . $pg . '/' . $pgs . '
//$tbl_buyer_head .='<script>$(function() {$("#pgno").val('.$pg.');}); </script>';
$tbl_buyer_head .='<tr></tr>
          <th colspan="5" style="text-align:center;">Details of Buyer</th>
          <th colspan="13"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl_buyer_head .='<tr><td colspan="5" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl_buyer_head .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center" style="whitespace:none;"><strong style="font-size:24px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="7" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;whitespace:none;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl_buyer_head .= '<td colspan="6"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center"  style="whitespace:none;" id="pgno">' . $pg . '/' . $pgs . '</strong></p></td>';
//$tbl_buyer_head .= $tbl_page_head;  
$tbl_buyer_head .= '</tr><td rowspan="2" colspan="2">Credit Period</td><td colspan="5" rowspan="2"><strong>'. $mvalue["creditperiod"]  .'</strong></td><tr>';          
         
//$tbl_buyer_head .=  '<tr></tr>';
          $tbl_item_head .= '<tr>
              <th style="width:10px;">SL.NO.</th>
              <th colspan="3">PRODUCT / SERVICE</th>
              <th>HSN/SAC</th>
              <th>MRP</th>
              <th>QTY</th>
              <th>UOM</th>
              <th>RATE</th>
              
              <th>DIS%</th>
              <th>TAXABLE VALUE</th>
							<th>GST</th>
              <th>TOTAL AMOUNT</th>
          </tr>
          <tr>
            <th colspan="9"></th>
            
            <th>%</th>
            <th>&#8377;</th>
						<th>%</th>

            <th>&nbsp;&#8377;</th>
            
          </tr>';


$rw=1;
$rc=1;
$rws=1;
$r=1;
        $tax_tot = 0.00;
        $cgst_tot = 0.00;
        $sgst_tot = 0.00;
        $igst_tot = 0.00;
        $tot_igst=0.00;
        $tot_cgst=0.00;
        $tot_sgst=0.00;
        $tot_tax=0.00;
        $igst=0.00;
        $tot_amt = 0.00;
        $dis_tot = 0.00;
        $dis_pc=0;
        $itemamt_tot=0.00;
$totcgst=0;
$totigst=0;
$totsgst=0;


//$tbl_items .=$dummy_tbl;
foreach ($objItems as  $item) {
    
    //var_dump($item);
$gst_pc = $item['item_gstpc'];
       if($item['item_name']<>"") {
            $item_name = $item['item_name'];
       }
       else
       {
        $item_name="";
       }

//      $item_name = $item['item_name'];
       if($item['item_desc']<>"") {
            
            $item_nar = $item['item_desc'];
        } else {
            $item_nar =""; // $item['item_name'];
        }
        if($item['cgst_pc']<>"") {
            $cgstpc = "<br>" . $item['cgst_pc'];
        } else {
            $cgstpc = "";
        } 
        if($item['sgst_pc']<>"") {
            $sgstpc = "<br>" . $item['sgst_pc'];
        } else {
            $sgstpc = "";
        } 
        if($item['igst_pc']<>"") {
            $igstpc = "<br>" . $item['igst_pc'];
        } else {
            $igstpc = "";
        } 



$rtot_amt = $item['taxable_amount'] + $item['cgst_amount'] + $item['sgst_amount'] + $item['igst_amount'];
$tbl_items .= '<tr>';
        
$tbl_items .= '<td align="center" style="width:10px; border-top:none;border-bottom:none;">' . $rw. '</td>';
$tbl_items .= '<td  colspan="3" style="font-size:14px;border-top:none;border-bottom:none;">' . $item_name . '</td>';
//$tbl .= '<td align="left" style="border-top:none;border-bottom:none;">' . $item_nar . '</td>';
$tbl_items .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item['item_hsnsac'] . '</td>';
$tbl_items .= '<td align="right" style="border-top:none;border-bottom:none;width:50px;">' . $item["item_mrp"] . '</td>';
$tbl_items .= '<td align="center" style="border-top:none;border-bottom:none;width:40px;">' . $item["item_qty"] . '</td>';
$tbl_items .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["item_unit"]. '</td>';
$tbl_items .= '<td align="right" style="border-top:none;border-bottom:none;width:50px;">' . $item["item_rate"]. '</td>';
$tbl_items .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_dispc"]. '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["item_disamount"]. '</td>';

$tbl_items .= '<td align="right" style="border-top:none;border-bottom:none;width:80px;">' . $item["taxable_amount"]. '</td>';
$tbl_items .= '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $item["item_gstpc"]. '</td>';
//$tbl .= '<td align="center" style="width:30px;border-top:none;border-bottom:none;">' . $item["cgst_pc"]. '</td>';

//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["cgst_amount"]. '</td>';
//$tbl .= '<td align="center" style="border-top:none;border-bottom:none;" >' . $item["sgst_pc"] . '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["sgst_amount"] . '</td>';
//$tbl .= '<td align="center" style="border-top:none;border-bottom:none;">' . $item["igst_pc"] . '</td>';
//$tbl .= '<td align="right" style="border-top:none;border-bottom:none;">' . $item["igst_amount"]. '</td>';
$tbl_items .= '<td align="right" style="border-top:none;border-bottom:none;width:80px;">' . number_format($rtot_amt, 2, ".", ",") . '</td>';
$tbl_items .= '</tr>';
if($item["item_desc"] )
{
	$tbl_items .= '<tr>';
	$tbl_items .= '<td align="center" style="width:10px; border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td  colspan="3" style="font-size:10px;border-top:none;border-bottom:none;">' . $item["item_desc"] . '</td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';
	$tbl_items .= '<td style="border-top:none;border-bottom:none;"></td>';

	$tbl_items .= '</tr>';

}


$rw=$rw+1;
        $tax_tot = $tax_tot + $item['taxable_amount'];
        $dis_tot = $dis_tot + $item['item_disamount'];
        $itemamt_tot = $itemamt_tot + $item['item_amount'];
        $taxable_tot = $itemamt_tot ;
        $cgst_tot = $cgst_tot + $item['cgst_amount'];
        $sgst_tot = $sgst_tot + $item['sgst_amount'];
        $igst_tot = $igst_tot + $item['igst_amount'];
        $tot_amt = $tax_tot + $cgst_tot + $sgst_tot + $igst_tot;

if($rc==$pglines) 
//if($rw>30)
{
$tbl_next_pg_head="";
//	echo $rw;
$rc=1;
    $r=1;
//		echo $pg;
		$tbl_page_head="";
		$pg=$pg+1;
	//	echo $pg;
	//	$tbl_items .= '<div class="pagebreak"></div>';
    $tbl_items .= '</table></table>';
    $tbl_items .= '<br>';
    $tbl_items .= '<div class="pull-right" align="right"> Contd./-</div>';
$tbl_items .= '<div class="breakAfter"></div>';
$tbl_items .= $tbl_head;
$tbl_items .= $tbl_main;
//$tbl_page_head .= '<td colspan="6"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center"  style="whitespace:none;">' . $pg . '/' . $pgs . '</strong></p></td>';
//$tbl_buyer_head .= $tbl_page_head;  

$tbl_next_pg_head .='<tr></tr>
          <th colspan="6" style="text-align:center;">Details of Buyer</th>
          <th colspan="12"  style="text-align:center;">INVOICE DETAILS</th>';  

$tbl_next_pg_head .='<tr><td colspan="6" rowspan="4" valign="top"><strong style="font-size:20px;">M/S. ' . $lname . ' </strong><br />' . str_replace(",", "<br>", $laddress) . ' <br /><strong style="font-size:16px;"> "GSTIN : "' . $lgstin . '</strong><br /> State Code : ' . $lstatecode . '</td>';

$tbl_next_pg_head .= '<td colspan="5" valign="top"><strong>Invoice No.</strong><p align="center" style="whitespace:none;"><strong style="font-size:25px;">' . $mvalue['trans_id'] . '</strong></p></td><td colspan="7" valign="top"><strong>Date</strong><p  align="center"><strong style="font-size:25px;whitespace:none;">' . date("d-m-Y", strtotime($mvalue['trans_date']))  . '</strong></p></td></tr><tr><td colspan="6" valign="top"><strong>Reference #</strong><strong style="font-size:18px;"><p align="center">' . $mvalue['order_no'] . '</strong></p></td>';

$tbl_next_pg_head .= '<td colspan="6"><strong>Pages</strong><strong style="font-size:25px;"><p class="text-align:center" align="center"  style="whitespace:none;" id="pgno">' . $pg . '/' . $pgs . '</strong></p></td>';
//$tbl_buyer_head .= $tbl_page_head;  
$tbl_next_pg_head .= '</tr><td rowspan="2" colspan="2">Credit Period</td><td colspan="5" rowspan="2"><strong>'. $mvalue["creditperiod"]  .'</strong></td><tr>';          
         
//$tbl_next_pg_head .=  '<tr></tr>';


$tbl_items .= $tbl_next_pg_head;

$tbl_items .= $tbl_item_head;
$tbl_items .= $tbl_items_row_tot;
$tbl_items .= $tbl_rupees;
$tbl_items .= $tbl_item_tax;

     

}
        $rc=$rc+1;


} //items


 $rws=$rc+8;
 while($rws <= $pglines) {
      
     
     $tbl_items .= '<tr>
        <td style="border-top:none;border-bottom:none;">&nbsp;</td>
        <td colspan="3" style="border-top:none;border-bottom:none;"></td>
        
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td>
        <td style="border-top:none;border-bottom:none;"></td></tr><tr>';

$rws=$rws+1;    

}


$r=1;


$tbl_items_row_tot .= '<tr><td colspan="10" align="right">Total </td>';
        //$tbl .= '<td align="right"><strong>' . number_format($itemamt_tot, 2, '.', ','). '</strong></td>';
//        $tbl_items_row_tot .= '<td></td>';
 //          $tbl_items_row_tot .= '<td></td>';
  //      $tbl .= '<td align="right">  <strong>' . number_format($dis_tot, 2, '.', ','). '</strong></td>';
        $tbl_items_row_tot .= '<td align="right">  <strong>' . number_format($taxable_tot, 2, '.', ','). '</strong></td>';
      //  $tbl_items_row_tot .= '<td></td>';
      //  $tbl_items_row_tot .= '<td align="right">  <strong>' . number_format($cgst_tot, 2, '.', ','). '</strong></td>';
     //   $tbl_items_row_tot .= '<td></td>';
    //    $tbl_items_row_tot .= '<td align="right"> <strong>' . number_format($sgst_tot, 2, '.', ','). '</strong></td>';
        $tbl_items_row_tot .= '<td></td>';
      //  $tbl_items_row_tot .= '<td align="right"><strong> ' . number_format($igst_tot, 2, '.', ','). '</strong></td>';
        $tbl_items_row_tot .= '<td align="right"><strong> ' . number_format($tot_amt, 2, '.', ','). '</strong></td>';
$tbl_items_row_tot .= '</tr>';
        
$tbl_rupees .= '<tr>';
           $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$tbl_rupees .= '<td valign="top" colspan="17" rowspan="2"><strong>(Rupees in words) :</strong>Rupees ' . ucwords($f->format(round($tot_amt,2))) . " only". '</td>';
$tbl_rupees .= '</tr><tr></tr></table>';
$tbl_item_tax .='<div style="height:150px;border: solid 1px;">';
$tbl_item_tax .='<div style="float: left;width:640px;height:150px;">
  <table class="table" style="border-collapse:collapse;width:700px;">
    <tr>
		<th style="border-left:none;border-top:none;">TAX %</th><th style="border-top:none;" colspan="2">AMOUNT</th><th style="border-top:none;">%</th><th style="border-top:none;">IGST</th><th style="border-top:none;">%</th><th style="border-top:none;">CGST</th><th style="border-top:none;">%</th><th style="border-top:none;">SGST</th><th style="border-top:none;" colspan="2">Total</th>
		</tr>';



//$tbl_item_tax .='<table id="items_tax" style="width:900px;margin-top:5px;font-size:12px;"><td colspan="17">';
//$tbl_item_tax .= '<table id="items" style="width:900px;margin-top:5px;font-size:12px;"><tr></tr>';
    
//$tbl_item_tax .= '<th>TAX %</th><th>AMOUNT</th><th>%</th><th>IGST</th><th>%</th><th>CGST</th><th>%</th><th>SGST</th><th>Total</th><tbody>';
 $rwtaxtot =0;
 $tot_amt=0;


//var_dump($taxobj);
foreach ($taxobj as  $taxdata) {
 $gstpc = $taxdata['gst_pc'];
 $igst = $taxdata['item_igst'];
 $cgst = $taxdata['item_cgst'];
 $sgst = $taxdata['item_sgst'];
 $taxableamt=$taxdata['taxable_amount'];
 $rwtaxtot = $igst+$cgst+$sgst;
 
 if($gstpc >0){
     $divgst= $gstpc/2 . '%';
 }
 else {
     $divgst= "";
 }
if($cgst>0) {
     $cgstamt=$cgst;
     $sgstamt=$sgst;
     $divgst= $gstpc/2 . '%';
     $igstamt=0.00;
     $igstpc="";

     
 }
 else {
     $cgstamt=0.00;
     $sgstamt=0.00;
     $divgst=0.00;
     $igstamt=$igst;
     $igstpc=$gstpc;
     $tot_cgst=0.00;
     $tot_sgst=0.00;

     //$totigst=$tot_igst;
     } 


 $tbl_item_tax .= '<tr>';
 $tbl_item_tax .= '<td style="border-left:none;" align="center">'. $gstpc . '%</td>';
 $tbl_item_tax .= '<td align="right" colspan="2">' . number_format($taxableamt, 2, '.', ',') . '</td>';
 $tbl_item_tax .= '<td align="center" >'. $igstpc .'</td>';
 $tbl_item_tax .= '<td align="right">' . number_format($igstamt, 2, '.', ',') . '</td>';


 $tbl_item_tax .= '<td align="center" >'. $divgst .'</td>';
 $tbl_item_tax .= '<td align="right">' . number_format($cgstamt, 2, '.', ',') . '</td>';
 $tbl_item_tax .= '<td align="center">'. $divgst .'</td>';
 $tbl_item_tax .= '<td align="right">' . number_format($sgstamt, 2, '.', ',') . '</td>';

 $tbl_item_tax .= '<td colspan="2" align="right">' . number_format($rwtaxtot, 2, '.', ',') . '</td></tr>';
 $tot_igst =$tot_igst+$igst;
 $tot_cgst =$tot_cgst+$cgst;
 $tot_sgst =$tot_sgst+$sgst;
 $tot_tax = $tot_tax+$rwtaxtot;
 $tot_amt = $tot_amt+$taxableamt;
 $rwtaxtot=0;



} //tax loop

 if($tot_igst>0) {
     $totigst=$tot_igst;
     //$totcgst="";
     //$totsgst="";
 }
 else {
     $totigst=0.00;
         $totcgst=$tot_cgst;
     $totsgst=$tot_sgst;
 }

 $tbl_item_tax .= '<tr>
 <td><strong>Total</strong></td><td align="right" colspan="2"><strong>'.  number_format($tot_amt, 2)  .'</strong></td><td></td><td align="right"><strong>'. number_format($totigst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totcgst, 2) . '</strong></td><td></td><td align="right"><strong>'. number_format($totsgst , 2) . '</strong></td><td align="right"><strong>'. number_format($tot_tax , 2) . '</strong></td>'; 

  $tbl_item_tax .= '</tr>';
  
 $tbl_item_tax .= '</tbody>';

 $tbl_item_tax .= '<tr></tr>';
 $tbl_item_tax .= '</table>';
 $tbl_item_tax .= '</td>';

 $tbl_item_tax .= '<td>';
 $tbl_item_tax .= '<table>';
 $tbl_item_tax .= '<tr>';
 $tbl_item_tax .= '<tbody>
 </table>
</div>';

$tot_val= $taxable_tot+$tot_tax;
$rund_val = round($tot_val);
$rund_off = $tot_val - $rund_val;
$adv_tot=0.00;
$bal_due = $rund_val-$adv_tot;
 $tbl_item_tax .= '<div style="float: right;"><table class="table" style="border-collapse:collapse;width:200px;"><tr>';
 $tbl_item_tax .= '<td style="border-top:none;" colspan="2">Sub Total</td>';
 $tbl_item_tax .= '<td style="border-top:none;border-right:none;"  align="right" colspan="2">  <strong>' . number_format($taxable_tot, 2). '</strong></td>';
 $tbl_item_tax .= '</tr>';
 $tbl_item_tax .= '<tr>';
 $tbl_item_tax .= '<td colspan="2">Tax</td>';
 $tbl_item_tax .= '<td align="right" colspan="2" style="border-right:none;">  <strong>' .  number_format($tot_tax, 2). '</strong></td>';
 $tbl_item_tax .= '</tr>';
 $tbl_item_tax .= '<tr>';
 $tbl_item_tax .= '<td colspan="2">Round Off</td>';
 $tbl_item_tax .= '<td align="right" colspan="2" style="border-right:none;">  <strong>' . number_format($rund_off, 2). '</strong></td>';
 $tbl_item_tax .= '</tr>';
 $tbl_item_tax .= '<tr>';
 $tbl_item_tax .= '<td colspan="2"><strong>Total</stron></td>';
 $tbl_item_tax .= '<td align="right" colspan="2" style="border-right:none;">  <strong>' . number_format($rund_val, 2, '.', ','). '</strong></td>';
 $tbl_item_tax .= '</tr>';
 //$tbl_item_tax .= '<tr>';
// $tbl_item_tax .= '<td colspan="2">Advances</td>';
 //$tbl_item_tax .= '<td align="right" colspan="2">  <strong>' . number_format($adv_tot, 2, '.', ','). '</strong></td>';
 //$tbl_item_tax .= '</tr>';

 //$tbl_item_tax .= '<tr>';
 //$tbl_item_tax .= '<td colspan="2">Balance due</td>';
 //$tbl_item_tax .= '<td align="right" colspan="2">  <strong>' . number_format($bal_due, 2, '.', ','). '</strong></td>';
 //$tbl_item_tax .= '</tr>';


$tbl_item_tax .='</tr>
</table>
</div></div>';

 $bnkdetails="<p><u>Bank Details:-</u></p><strong>" . str_replace(",", "</BR>", $this->session->userdata('cbankdetails')) . "</strong>";

/* $tbl .= '<table id="items" style="margin-top:5px;font-size:16px;" >
    <tr>
    <td colspan="6"  style="border-right:none"border-left:none;border-right:none;border-bottom:none;border-top:none;><p>' . $bnkdetails . '</p></td>
    <td colspan="6"  style="border-left:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>
                <br /><br /><br />
                <h4 align="right" style="font-size:18px;">Authorized Signatory</h4></td>
    
    </tr>';
*/
	//	$tbl_item_tax .= $bnkdetails;
  $tbl_item_tax .='<div style="margin-bottom:10px;height:140px;border:solid 1px;border-left:none;border-right:none;border-top:none;">';
		$tbl_item_tax .='<div style="float: left;margin-right:10px;margin-top:10px;width:640px;">
		<table style="width:620px;border-collapse:collapse;">
			<tr><td style="border-right:none; border-left:none;border-right:none;border-bottom:none;border-top:none;">';
		$tbl_item_tax .= $bnkdetails;	

	
			$tbl_item_tax .='</td></tr>
			</table>
			</div>';
			$tbl_item_tax .= '<div style="float: left;margin-top:10px;"><table style="width:230px;"><tr>';
			$tbl_item_tax .= '<td colspan="6" rowspan="6" style="border-left:none;border-right:none;border-bottom:none;border-top:none;" align="right"><h4 align="right" style="font-size:20px;">for <strong> ' . ucwords($this->session->userdata('cname')). '</strong></h4>';
 			if($comp_rseal)
			{
			$tbl_item_tax .= '<br /><img src="' . base_url() . $comp_rseal . '" style="float:left;width:80px;height:80px;margin-top:-25px;margin-left:120px;">';

      }			
$tbl_item_tax .= '<br/><h4 align="right" style="margin-bottom:30px;font-size:18px;border-left:none;border-right:none;border-bottom:none;border-top:none;">Authorized Signatory</h4></td>';
			$tbl_item_tax .='</tr>
			</table>
			</div></div>';
						 

    $tbl_item_tax .= '</table>';
    //$tbl_item_tax .= '<div style="width:900px;border:solid 1px;"></div>';
//$tbl_item_tax .= '<div style="margin-top:-10px;">';
$tbl_item_tax .= '<div style="float:left;margin-top:-20px;">E. & O.E.</div><div style="float:right;margin-top:-20px;">This is a Computer Generated Invoice</div>';
//$tbl_item_tax .= '</div>';
$tbl_item_tax .= '</div>';
    
// $tbl_item_tax .= '<br><div float="left">E. & O.E.</div><div class=""><p><span style="float:right">This is a Computer Generated Invoice</p></span> </div>';



    # code...
//var_dump($value);



} //obj

//$tbl .= '</table>';

//$tbl .= '</div></table>';
$tbl_final = $tbl_head;
$tbl_final .= $tbl_main;
$tbl_final .= $tbl_buyer_head;
$tbl_final .= $tbl_item_head;

$tbl_final .= $tbl_items;
//$cnt = count($tbl_items);
//if($cnt>2)
//{

//}
//else 
//{
$tbl_final .= $tbl_items_row_tot;
$tbl_final .= $tbl_rupees;
$tbl_final .= $tbl_item_tax;

//}
echo $tbl_final;
}


public function getPurchasebyid()
{

$flag=$this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";

$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems
//$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid/" . $id . "/" . $trans_type;

$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid_get/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
//  var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 


//$url=$this->config->item("api_url") . "/api/getinvtype.php";
$url_invtype=$this->config->item("api_url") . "/api/inventorylist/getinvoicetype";

//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url_invtype);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);



foreach ($obj as $key => $value) {
  # code...
// var_dump($value);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);
//var_dump($invdata);
foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$value["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}


$tbl .='<table id="editInvoice" class="table table-bordered">';
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $value['custname'] . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';


}


$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
if($objItems)
{
$count = count($objItems);
foreach ($objItems as  $item) {

$i=1;

foreach ($unitdata as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}



}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. number_format($item['item_qty'],"0") . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}
}


echo $tbl;

}




public function __getPurchasebyid()
{

$flag=$this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";
$url=$this->config->item("api_url") . "/api/transaction/getSalesPurchaseDatabyId/" . $id . "/" . $trans_type;
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;
var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);

$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
curl_close($ch); 
$objItems = json_decode($itemsresponse,true);

$tbl .='<table id="editInvoice" class="table table-bordered">';



foreach ($obj as  $value) {
    # code...
//var_dump($value);





$actid=$obj['db_account'];
//$url=$this->config->item("api_url") . "/api/getsingle_ledger.php?id=" . $actid;
$url=$this->config->item("api_url") . "/api/ledger/" . $actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;


//$url=$this->config->item("api_url") . "/api/getinvtype.php";
$url=$this->config->item("api_url") . "/api/invoicetype";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$obj["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}



$url=$this->config->item("api_url") . "/api/salesperson";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $salebyresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$soption='';
$salebydata =  json_decode($salebyresponse,true);

foreach ($salebydata as $key => $svalue) {
    
 if($svalue['id']==$obj["salebyperson"])
{   
$soption .= '<option selected value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';
}
else
{
 $soption .= '<option value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';   
}

}

if($flag=="pur")
{


$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $obj['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $obj['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $obj['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $obj['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $obj['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $obj['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $obj['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';
}






else if($flag=="rpur")
{
//$url=$this->config->item("api_url") . "/api/getsettings.php";
$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;
$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $dnprefix = $settArr->dn_prefix;
    $dnsuffix = $settArr->dn_suffix;
    $dn_no = $settArr->dn_no;
    $dn_numtype = $settArr->inv_numtype;
    $dn_leadingzero = $settArr->leading_zero;

if($dn_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_dnno = sprintf("%0". $dn_leadingzero ."d", $dn_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$dnno = $dnprefix . $_dnno . $dnsuffix;
$next_dnno = $dn_no+1;
}
else
{
    $_dnno= $dn_no;
    $dnno = $dnprefix . $_dnno . $dnsuffix;
    $next_dnno = $dn_no+1;
//$dnno = $dnprefix . $_dnno . $dnsuffix;
}



}



$tbl .='<tr><td> Debit Note.#<input type="text" class="form-control" autocomplete="off"  id="cndn_no" name="cndn_no" value="'. $dnno . '" readonly></td><td>Debit Note Date<input type="date" class="form-control" autocomplete="off"  id="cndn_date" name="cndn_date" required></td><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="statecode" value="' . $obj['statecode'] . '" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="invoiceno" name="invoiceno" value="'. $obj['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="invdate" name="invdate" value="'. $obj['trans_date'] . '" readonly></td></tr>';



$tbl .='<tr><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '" readonly></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="gstin" name="gstin" value="'. $obj['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="invtype" name="invtype" readonly >'. $invoption .'</select> </td><td>Sales by<select class="form-control" autocomplete="off" id="salebyperson" name="salebyperson" readonly>'. $soption .'</select> </td></tr>';

/*
$tbl .='<tr><td> <input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';*/
}



$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
$count = count($value[0]['items']);
foreach ($value[0]['items'] as  $item) {

$i=1;

foreach ($unitdata['units'] as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}
}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. number_format($item['item_qty'],"0") . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}

}
$tbl .='</tbody></table></div>';
echo $tbl;
}





public function getSalesbyid()
{

$trans_type=$this->input->get('trans_type');
$flag=$this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
//$trans_type="SALE";
//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";
$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid/" . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/" . $id . "/" . $trans_type;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
//var_dump($salesbyidresponse);
curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);gegetSalesPurchaseItemsgetSalesPurchaseItemstSalesPurchaseItems
//$url=$this->config->item("api_url") . "/api/itemtransaction/pursal_byid/" . $id . "/" . $trans_type;

$url=$this->config->item("api_url") . "/api/inventorylist/pursal_byid_get/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;
//$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $itemsresponse = curl_exec($ch);
  //var_dump($itemsresponse);
$objItems = json_decode($itemsresponse,true);

curl_close($ch); 


//$url=$this->config->item("api_url") . "/api/getinvtype.php";
//$url=$this->config->item("api_url") . "/api/invoicetype";
$url_invtype=$this->config->item("api_url") . "/api/inventorylist/getinvoicetype";

//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url_invtype);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

//var_dump($invvalue['inv_type']);


foreach ($obj as $key => $value) {
  # code...
 // var_dump($value);
//var_dump($value['inv_type']);
$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$value["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}

//$url=$this->config->item("api_url") . "/api/salesperson";
$url=$this->config->item("api_url") . "/api/productlist/salespersonbycid";

//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];

$data = array("compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));


  $salebyresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$soption='';
$salebydata =  json_decode($salebyresponse,true);

foreach ($salebydata as $key => $svalue) {
    
 if($svalue['id']==$value["salebyperson"])
{   
$soption .= '<option selected value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';
}
else
{
 $soption .= '<option value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';   
}

}
$tbl .='<table id="editInvoice" class="table table-bordered">';
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>Sales by<select class="form-control" autocomplete="off" id="editsalebyperson" name="editsalebyperson">'. $soption .'</select> </td></tr>';


$tbl .='<tr><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $value['custname'] . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';
	$tbl .='<input type="hidden" id="trans_type" name="trans_type" value="' . $trans_type . '">';	
	$tbl .='<tr><td>CREDIT PERIOD</td><td colspan="4"><input class="form-control" type="text" value="'. $value["creditperiod"] .'" id="creditperiod" name="creditperiod" ></td></tr>';

/*
$tbl .='<table id="editInvoice" class="table table-bordered">';
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td></tr>';

$tbl .='<tr><td colspan="3">Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $value['custname'] . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td colspan="2">Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';
*/

}


$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>MRP</th><th>UOM</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
if($objItems)
{
$count = count($objItems);
foreach ($objItems as  $item) {

$i=1;

foreach ($unitdata as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}



}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemmrp" autocomplete="off" id="itemmrp' .$count. '" name="itemmrp[]"  value="'. $item['item_mrp'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. number_format($item['item_qty'],"0") . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}
}


echo $tbl;

}




public function __oldgetSalesbyid()
{
$flag= $this->input->get('flag');
$id = $this->input->get('id');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
$url=$this->config->item("api_url") . "/api/transaction/pursal_byid/"  . $id . "/" . $trans_type . "/" . $compId . "/" . $finyear;

//$url=$this->config->item("api_url") . "/api/gettransactionbyid.php";
$data = array("id"=>$id,"finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

  $salesbyidresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesbyidresponse;

curl_close($ch); // Close the connection
$obj = json_decode($salesbyidresponse,true);
$tbl="";
//var_dump($obj);

$tbl .='<table id="editInvoice" class="table table-bordered">';
foreach ($obj as  $value) {
    # code...
//var_dump($value);
$actid=$value['db_account'];

$url=$this->config->item("api_url") . "/api/ledger/" .$actid;
//$post = ['batch_id'=> "2"];

$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $ldgresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($ldgresponse);
//var_dump($ldgerArray);
$lname=$ldgerArray->account_name;

$url=$this->config->item("api_url") . "/api/invoicetype";
//$url=$this->config->item("api_url") . "/api/getinvtype.php";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
 if($invvalue['inv_type']==$value["inv_type"])
{   
$invoption .= '<option selected value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';
}
else
{
 $invoption .= '<option value="'. $invvalue['inv_type'].'">'. $invvalue['description'].'</option>';   
}

}


$url=$this->config->item("api_url") . "/api/salesperson";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $salebyresponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$soption='';
$salebydata =  json_decode($salebyresponse,true);

foreach ($salebydata as $key => $svalue) {
    
 if($svalue['id']==$value["salebyperson"])
{   
$soption .= '<option selected value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';
}
else
{
 $soption .= '<option value="'. $svalue['id'].'">'. $svalue['sales_person'].'</option>';   
}

}

if($flag=="sl")
{
$tbl .='<tr><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="recid" name="statecode" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="editinvoiceno" name="editinvoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="editinvdate" name="editinvdate" value="'. $value['trans_date'] . '"></td><td>Order #<input type="text" class="form-control" autocomplete="off" id="editorderno" name="editorderno" value="'. $value['order_no'] . '"></td><td>Order Date<input type="date" class="form-control" autocomplete="off"  id="editorderdate" name="editorderdate" value="'. $value['order_date'] . '"></td><td>Sales by<select class="form-control" autocomplete="off" id="editsalebyperson" name="editsalebyperson">'. $soption .'</select> </td></tr>';


$tbl .='<tr><td>DC #<input type="text" class="form-control" autocomplete="off"  id="editdcno" name="editdcno" value="'. $value['dc_no'] . '"></td><td>DC Date<input type="date" class="form-control" autocomplete="off"  id="editdcdate" name="editdcdate" value="'. $value['dc_date'] . '"></td><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '"></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="editgstin" name="editgstin" value="'. $value['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="editinvtype" name="editinvtype" >'. $invoption .'</select> </td></tr>';

}
else if($flag=="sr")
{

//$url=$this->config->item("api_url") . "/api/getsettings.php";
//$url=$this->config->item("api_url") . "/api/settings";
$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;
$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $dnprefix = $settArr->dn_prefix;
    $dnsuffix = $settArr->dn_suffix;
    $dn_no = $settArr->dn_no;
    $dn_numtype = $settArr->inv_numtype;
    $dn_leadingzero = $settArr->leading_zero;

if($dn_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_dnno = sprintf("%0". $dn_leadingzero ."d", $dn_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$dnno = $dnprefix . $_dnno . $dnsuffix;
$next_dnno = $dn_no+1;
}
else
{
    $_dnno= $dn_no;
    $dnno = $dnprefix . $_dnno . $dnsuffix;
    $next_dnno = $dn_no+1;
//$dnno = $dnprefix . $_dnno . $dnsuffix;
}



}


$tbl .='<tr><td> Debit Note.#<input type="text" class="form-control" autocomplete="off"  id="cndn_no" name="cndn_no" value="'. $dnno . '" readonly></td><td>Debit Note Date<input type="date" class="form-control" autocomplete="off"  id="cndn_date" name="cndn_date" required></td><td><input type="hidden" id="recid" name="recid" value="' . $id . '"><input type="hidden" id="statecode" value="' . $value['statecode'] . '" name="statecode"> Inv.#<input type="text" class="form-control" autocomplete="off"  id="invoiceno" name="invoiceno" value="'. $value['trans_id'] . '" readonly></td><td>Inv.Date<input type="date" class="form-control" autocomplete="off"  id="invdate" name="invdate" value="'. $value['trans_date'] . '" readonly></td></tr>';



$tbl .='<tr><td>Customer<input type="text" class="form-control custname" autocomplete="off"  id="customer_name" name="customer_name" value="'. $lname . '" readonly></td><td>GSTIN#<input type="text"  class="form-control" autocomplete="off" id="gstin" name="gstin" value="'. $value['gstin'] . '" readonly></td><td>Inv.Type<select  class="form-control" autocomplete="off" id="invtype" name="invtype" readonly >'. $invoption .'</select> </td><td>Sales by<select class="form-control" autocomplete="off" id="salebyperson" name="salebyperson" readonly>'. $soption .'</select> </td></tr>';
}
$tbl .='</table>';


$tbl .='<div class="table-responsive"style="overflow:auto; height:200px;"><table id="editInvoiceItems" border="1" >';
//$itemobj = json_decode($salesbyidresponse['item']);
//var_dump($itemobj);
//echo count($value[0]['items']);
$tbl .='<tr><thead><th>Item Name</th><th>Item Description</th><th>HSNSAC</th><th>GST%</th><th>UOM</th><th>STK</th><th>QTY</th><th>RATE</th><th>DIS%</th><th>TAXABLE AMOUNT</th><th>NETT AMOUNT</th><th>?</th></thead></tr><tbody>';
//$count=1;
$unitdata = json_decode($this->getProductUnitArr(),true);
//var_dump($unitdata);
$option='';
$count = count($value['items']);
foreach ($value['items'] as  $item) {

$i=1;

foreach ($unitdata['units'] as $key => $uvalue) {
 if($uvalue['unit_id']==$item["item_unit"])
 {   
$option .= '<option selected value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';
}
else
{
 $option .= '<option value="'.$uvalue['unit_id'].'">'.$uvalue['unit_id'].'</option>';   
}
}

//echo $option;

//var_dump($option);    
    //var_dump($item);
$tbl .='<tr data-row="row'.$count.'" class="trrow" id="row' . $count . '" ><td style="width:25%;"><input style="width:100%;" type="text"  class="form-control itemname" autocomplete="off" id="itemname'.$count.'" name="itemname[]" value="'. $item['item_name'] . '"></td><td><input type="text"  class="form-control itemdesc" autocomplete="off" id="itemdesc'.$count.'" name="itemdesc[]" value="'. $item['item_desc'] . '"></td><td><input type="text"  class="form-control itemhsnsac" autocomplete="off" id="hsnsac'.$count.'" name="hsnsac[]" value="'. $item['item_hsnsac'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemgstpc" autocomplete="off" id="itemgstpc'.$count.'" name="itemgstpc[]" value="'. $item['item_gstpc'] . '"></td><td style="width:8%"><select style="width:100%"  class="form-control itemunit" autocomplete="off" id="itemunit'.$count.'" name="itemunit[]">'.$option.'</select></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemstk'.$count.'" name="itemstk[]" value="'. $item['item_stock'] . '"></td><td style="width:5%"><input type="text"  style="text-align:right"  class="form-control itemqty" autocomplete="off" id="itemqty'.$count.'" name="itemqty[]" value="'. $item['item_qty'] . '"></td><td style="width:9%"><input type="text"  style="text-align:right"  class="form-control itemrate" autocomplete="off" id="itemrate'.$count.'" name="itemrate[]" value="'. $item['item_rate'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemdispc" autocomplete="off" id="itemdispc'.$count.'" name="itemdispc[]" value="'. $item['item_dispc'] . '"></td><td><input type="text"  style="text-align:right"  class="form-control itemamt" autocomplete="off" id="itemamt'.$count.'" name="itemamt[]" value="'. $item['taxable_amount'] . '"></td><td><input type="text"  class="form-control itemnet" autocomplete="off" style="text-align:right"  id="itemnet'.$count.'" name="itemnet[]" value="'. $item['nett_amount'] . '"></td><td><button class="btn btn-sm btn-danger remove" data-row="row'.$count.'" ><i class="fa fa-times"></i></button></td></tr>';

$count--;

}

}
$tbl .='</tbody></table></div>';
echo $tbl;
}




public function getsaleschart()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
$url=$this->config->item("api_url") . "/api/productlist/chartData";
$postdata = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));

 $chartresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
echo $chartresponse;

}

public function getallPurchase()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallsales.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
$tbl='<table class="table table-bordered" id="saleslistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist">';


$maindata = json_decode($salesresponse,true);
foreach ($maindata as $key => $d) 
{
    # code...
$gst_tot = $d['net_amount']-$d['taxable_amount'];

$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-info btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalEditPurchase" onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-danger btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalRPurchase" onclick="rpurchaseTransid(' . $d['id'] . ')"><i class="fa fa-redo"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
}


$tbl .='</tbody></table>';

echo $tbl;
}



public function deletestockOpbalbyid()
{
	$id = $this->input->get('id');
	$compId = $this->session->userdata('id');
	$finyear = $this->session->userdata('finyear');

	$del_array = array("delflag"=>"1","company_id"=>$compId,"finyear"=>$finyear,"prod_id"=>$id);
	//var_dump($del_array);
	$url=$this->config->item("api_url") . "/api/productlist/delete_stockOpBal";

	$ch = curl_init($url);
	 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($del_array));
	
	$response = curl_exec($ch);
	if(curl_errno($ch)) {
			echo 'Error: ' . curl_error($ch);
	} else {
			echo $response;
	}
	curl_close($ch);
	
	
}





public function getproductopenbal()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SALE";
//getTax breakup
$url=$this->config->item("api_url") . "/api/productlist/get_stockopbal";
$data = array("finyear"=>$finyear,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $prodopresponse = curl_exec($ch);
//	var_dump($prodopresponse);
  //$result = json_decode($response);
//echo $taxesbyidresponse;
//var_dump($opresponse);
curl_close($ch); // Close the connection



$phpArray = json_decode($prodopresponse, true);
//$character = json_decode($data);
//print_r($phpArray);
$data=array();
$i=0;

echo json_encode($phpArray);

}


public function updateStockOpBal()
{
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
  $open_stock = $this->input->post('open_stock');
	$item_id = $this->input->post('item_id');
	$item_name = $this->input->post('prodname');
//	$cnt = count($this->input->post('acid'));

  $data=array();
 //var_dump($opdata);
$data  = array("prod_id"=>$item_id,"prod_name"=>$item_name, "prod_qty"=>$open_stock,"finyear"=>$finyear,"company_id"=>$compId,"delflag"=>0);
// echo json_encode($data);
//	var_dump($data);
$url=$this->config->item("api_url") . "/api/productlist/insertStockOpBal";

$ch = curl_init($url);
 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);
if(curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo $response;
}
curl_close($ch);

}




public function getallSales()
{
$data=array();    
$trans_type= $this->input->get('trans_type');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
//$trans_type="SALE";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallsales.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
if($trans_type=="SALE")
{
$tbl='<table class="table table-bordered" id="saleslistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>ITMES</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist">';

									$maindata = json_decode($salesresponse,true);
									foreach ($maindata as $key => $d) 
									{
											# code...
									$gst_tot = $d['net_amount']-$d['taxable_amount'];
									
									$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalEditSales" onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="pdfTransid('. $d['id']. ')"><i class="fa fa-pdf"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
									}
									
									
}
if($trans_type=="PURC")
{
$tbl='<table class="table table-bordered" id="purchaselistTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>INVOICE#</th>
                      <th>INVOICE DATE</th>
                      <th>CUSTOMER</th>
                      <th>GSTIN</th>
                      <th>ITMES</th>
                      <th>TAXABLE VALUE</th>
                      <th>GST</th>
                      <th>NETT VALUE</th>

                    </tr>
                  </thead>
                  <tbody id="saleslist">';



$maindata = json_decode($salesresponse,true);
foreach ($maindata as $key => $d) 
{
    # code...
$gst_tot = $d['net_amount']-$d['taxable_amount'];

$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-backdrop="static" data-keyboard="true" data-target="#modalEditPurchase" onclick="purchaseupdateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button></td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
}

}
$tbl .='</tbody></table>';

echo $tbl;
}


public function olllldgetallrPurchaselist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PRTN";
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallpurchase.php";
$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type . "/" . $finyear ;
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);
$data['data']= array();
//$data=array('data[]');
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
if($d['net_tot']!=null)
{
  $netamt= $d['net_tot'];
}
else
{
  $netamt=0;
}

if($d['txb_tot']!=null)
{
  $txbamt= $d['txb_tot'];
}
else
{
  $txbamt=0;
}

$gst_tot = $netamt-$txbamt;

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block' href='#'  data-toggle='modal' data-target='#modalEditSales' onclick='rpurchaseTransid(". $d["id"]. ")'><i class='fa fa-redo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='rpurchaseupdateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$txbamt,"gst_tot"=>$gst_tot,"net_amount"=>$netamt,"noi"=>$d['noi']);

}
}

//$tbl .='</tbody></table>';

echo json_encode($data);
}




public function getallrSaleslist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type=$this->input->get('trans_type'); // "SRTN";
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallsales.php";
//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
$url=$this->config->item("api_url") . "/api/inventorylist/pursal/" . $compId . "/" .  $trans_type . "/" . $finyear ;

//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type . "/" . $finyear ;
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type;

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);
$data['data']= array();

//$data=array();
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_tot']-$d['txb_tot'];

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-backdrop='static' data-keyboard='true' data-target='#modalEditRSales' onclick='sreturnTransid(" . $d["id"] . ")'><i class='fa fa-undo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='cnupdateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='cnprintTransid(". $d["id"]. ")'><i class='fa fa-print'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block' href='#' onclick='cnTransid(". $d["id"]. ")'><i style='color:white;' class='fa fa fa-file-pdf'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['txb_tot'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_tot'],"noi"=>$d['noi']);

}
}

//$tbl .='</tbody></table>';

echo json_encode($data);
}


public function getallrPurchaselist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type=$this->input->get('trans_type'); // "SRTN";
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallsales.php";
//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
$url=$this->config->item("api_url") . "/api/inventorylist/pursal/" . $compId . "/" .  $trans_type . "/" . $finyear ;

//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type . "/" . $finyear ;
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type;

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);
$data['data']= array();

//$data=array();
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_tot']-$d['txb_tot'];

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-backdrop='static' data-keyboard='true' data-target='#modalEditRSales' onclick='sreturnTransid(" . $d["id"] . ")'><i class='fa fa-undo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='dnupdateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='dnprintTransid(". $d["id"]. ")'><i class='fa fa-print'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block' href='#' onclick='dnTransid(". $d["id"]. ")'><i style='color:white;' class='fa fa fa-file-pdf'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['txb_tot'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_tot'],"noi"=>$d['noi']);

}
}

//$tbl .='</tbody></table>';

echo json_encode($data);
}



public function oldgetallRSaleslist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="SRTN";
//var_dump($compId . $finyear); 
$url=$this->config->item("api_url") . "/api/getallrsales.php";
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//var_dump($url);
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;

curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);
$data=array();
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_amount']-$d['taxable_amount'];

$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button></div>";

$data['data'][]=array("action"=>$button,"cn_id"=>$d['cn_id'],"cn_date"=>$d['cn_date'],"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['taxable_amount'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_amount'],"noi"=>$d['noi']);

}


//$tbl .='</tbody></table>';

echo json_encode($data);
}



public function getallSalesPlist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$fdate=$this->input->get('fdate');
$tdate=$this->input->get('tdate');
$trans_type=$this->input->get('trans_type');
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallsales.php";
//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
//transtype,$finyear,$cid,$fdate,$tdate
$data = array("fdate"=>$fdate,"tdate"=>$tdate, "finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//var_dump($data);
$url=$this->config->item("api_url") . "/api/transaction/pursalreg/" . $trans_type . "/" . $finyear . "/" . $compId . "/" . $fdate . "/" . $tdate;
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type;

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);

$data=array();
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_tot']-$d['txb_tot'];

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-backdrop='static' data-keyboard='true' data-target='#modalEditRSales' onclick='sreturnTransid(" . $d["id"] . ")'><i class='fa fa-undo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='printTransid(". $d["id"]. ")'><i class='fa fa-print'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='pdfTransid(". $d["id"]. ")'><i class='fa fa-pdf'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['txb_tot'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_tot'],"noi"=>$d['noi']);

}
}

//$tbl .='</tbody></table>';

echo json_encode($data);
}


public function getallSaleslist()
{
$data=array();    
$trans_type=$this->input->get('trans_type');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
//$trans_type="SALE";
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallsales.php";
//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
//$post = ['batch_id'=> "2"];
$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
$url=$this->config->item("api_url") . "/api/inventorylist/pursal/" . $compId . "/" .  $trans_type . "/" . $finyear ;
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $trans_type;

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);

$data=array();
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
$gst_tot = $d['net_tot']-$d['txb_tot'];

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-backdrop='static' data-keyboard='true' data-target='#modalEditRSales' onclick='sreturnTransid(" . $d["id"] . ")'><i class='fa fa-undo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditSales'  onclick='updateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button><button type='button' class='btn btn-primary btn-circle btn-xs center-block' href='#' onclick='printTransid(". $d["id"]. ")'><i class='fa fa-print'></i></button><button type='button' class='btn btn-danger btn-circle btn-xs center-block' href='#' onclick='pdfTransid(". $d["id"]. ")'><i style='color:white;' class='fa fa fa-file-pdf'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$d['txb_tot'],"gst_tot"=>$gst_tot,"net_amount"=>$d['net_tot'],"noi"=>$d['noi']);
//var_dump($data);
}
}

//$tbl .='</tbody></table>';

echo json_encode($data);
}


public function getallPurchaselist()
{
$data=array();    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$trans_type="PURC";
//var_dump($compId . $finyear); 
//$url=$this->config->item("api_url") . "/api/getallpurchase.php";
//$url=$this->config->item("api_url") . "/api/transaction/pursal/" . $compId . "/" . $trans_type . "/" . $finyear ;
//$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);

$data = array("finyear"=>$finyear,"compId"=>$compId,"trans_type"=>$trans_type);
$url=$this->config->item("api_url") . "/api/inventorylist/pursal/" . $compId . "/" .  $trans_type . "/" . $finyear ;


//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

  $salesresponse = curl_exec($ch);
  //$result = json_decode($response);
//echo $salesresponse;
//var_dump($salesresponse);
curl_close($ch); // Close the connection
$maindata = json_decode($salesresponse,true);
//$data=array("data[]");
//var_dump($maindata);
if($maindata)
{
foreach ($maindata as $key => $d) 
{
//var_dump($d);
    # code...
if($d['net_tot'])
{
  $netamt= $d['net_tot'];
}
else
{
  $netamt=0;
}

if($d['txb_tot'])
{
  $txbamt= $d['txb_tot'];
}
else
{
  $txbamt=0;
}

$gst_tot = $netamt-$txbamt;

/*$tbl .='<tr><td><div class="btn-group"><button type="button" class="btn btn-warning btn-circle btn-xs center-block"  href="#" data-toggle="modal" data-target="#modalEditSales"  onclick="updateTransid(' . $d['id'] . ')"><i class="fa fa-edit"></i></button><button type="button" class="btn btn-primary btn-circle btn-xs center-block" href="#" onclick="printTransid('. $d['id']. ')"><i class="fa fa-print"></i></button>' . '<td style="width:30%;">'. $d['trans_id'] .'</td>' . '<td>'. $d['trans_date'] .'</td>'. '<td style="width:100%;">'. $d['custname'] .'</td>' . '<td>'. $d['gstin'] .'</td>'. '<td style="text-align:right;">'. number_format($d['taxable_amount'],"2") .'</td>'. '<td style="text-align:right;">' . number_format($gst_tot,"2") . '</td><td style="text-align:right;">'. number_format($d['net_amount'],"2") .'</td>'  .'</tr>';
<button type='button' class='btn btn-danger btn-circle btn-xs center-block' href='#'  data-toggle='modal' data-target='#modalEditSales' onclick='rpurchaseTransid(". $d["id"]. ")'><i class='fa fa-redo'></i></button>
*/
$button="<div class='btn-group'><button type='button' class='btn btn-warning btn-circle btn-xs center-block'  href='#' data-toggle='modal' data-target='#modalEditPurchase'  onclick='purchaseupdateTransid(" . $d["id"] . ")'><i class='fa fa-edit'></i></button></div>";

$data['data'][]=array("action"=>$button,"trans_id"=>$d['trans_id'],"trans_date"=>$d['trans_date'],"custname"=>$d['custname'],"gstin"=>$d['gstin'],"taxable_amount"=>$txbamt,"gst_tot"=>$gst_tot,"net_amount"=>$netamt,"noi"=>$d['noi']);

}

}
//$tbl .='</tbody></table>';

echo json_encode($data);
}


public function getInvoiceType()
{

//$url=$this->config->item("api_url") . "/api/getinvtype.php";
$url=$this->config->item("api_url") . "/api/inventorylist/getinvoicetype";
//$post = ['batch_id'=> "2"];

//$data = array("id"=>$actid,"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $invtyperesponse = curl_exec($ch);
  //$result = json_decode($response);
//var_dump($data);
//var_dump($ldgresponse);
  curl_close($ch); // Close the connection
//var_dump($invtyperesponse);

$invoption='';
$invdata =  json_decode($invtyperesponse,true);

foreach ($invdata as $key => $invvalue) {
    
$invoption .= '<option value="'.$invvalue['inv_type'].'">'.$invvalue['description'].'</option>';

}

echo $invoption;
}



public function getSalesPerson()
{
	$compId = $this->session->userdata('id');
	$url=$this->config->item("api_url") . "/api/productlist/salespersonbycid";
//$url=$this->config->item("api_url") . "/api/getSalesPerson.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();

	$data = array("compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));


	$response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['sales_person'].'</option>';

}
$option .= '<option selected  disabled value="0">Select a Sales Person</option>';
echo $option;

}

public function getledgerdatasearchbyname($name)
{
$data_array=array();

$itemkeyword= $name; 
//var_dump($itemkeyword);

$compId = $this->session->userdata('id');
$data_array = array("flag"=>"oth", "itemkeyword"=>$name,"compId"=>$compId);
//$id = $this->input->get('id');    
//$url=$this->config->item("api_url") . "/api/getledgerbykeyword.php";
$url=$this->config->item("api_url") . "/api/productlist/lbyname";// . $itemkeyword . "/" . $compId ;

//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
 // var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
return $ldgerArray;

}

public function getledgerdatabysearch()
{
$data_array=array();

$itemkeyword= $this->input->get('itemkeyword'); 
//var_dump($itemkeyword);
$compId = $this->session->userdata('id');
$data_array = array("itemkeyword"=>$itemkeyword,"compId"=>$compId);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/productlist/lbyname"; // . $itemkeyword . "/" . $compId;
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
echo $response;

}

public function getproductdatabysearch()
{
$data_array=array();

$itemkeyword= $this->input->get('itemkeyword'); 
//var_dump($itemkeyword);
$finyear = $this->session->userdata('finyear');

$compId = $this->session->userdata('id');
$data_array = array("itemkeyword"=>$itemkeyword,"compId"=>$compId,"finyear"=>$finyear);
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/productlist/keyword/";//. $itemkeyword . "/" . $compId ;
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  

  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

  $response = curl_exec($ch);
  //$result = json_decode($response);
 
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response,true);
$item_data=array();
echo $response;
}



public function productdatabyname()
{
//$id = $this->input->get('id');  
$name=$this->input->get('itemname');
//var_dump($name);
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$data_array = array('itemkeyword'=> $name,'compId'=>$compId,"finyear"=>$finyear);
$url=$this->config->item("api_url") . "/api/productlist/byname" ;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data_array));

 // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  


  $response = curl_exec($ch);
//echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);
echo $response;

//return $response;
}



public function getproductbyname()
{
$name = $this->input->get('itemkeyword');    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$data_array = array('itemkeyword'=> $name,'compId'=>$compId,"finyear"=>$finyear);
$url=$this->config->item("api_url") . "/api/productlist/productbyname";///" . $name . "/" . $compId ;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

  $response = curl_exec($ch);
//var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
//$prodArray = json_decode($response, true);
echo $response;
//echo json_encode($response);
//return $response;
}



public function getproductdatabyname($name)
{
//$name = $this->input->get('itemkeyword');    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$data_array = array('itemkeyword'=> $name,'compId'=>$compId,"finyear"=>$finyear);
$url=$this->config->item("api_url") . "/api/productlist/byname";///" . $name . "/" . $compId ;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

  $response = curl_exec($ch);
//var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
//$prodArray = json_decode($response, true);
echo $response;

//return $response;
}

public function getproductdatabyid($id)
{
$compId = $this->session->userdata('id');
//$id = $this->input->get('id');    
$url=$this->config->item("api_url") . "/api/product/" . $id . "/" . $compId ;
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
//$ldgerArray = json_decode($response, true);
echo $response;

//return $response;
}



public function getledgerdatabyname()
{
$flag = $this->input->get('flag');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$itemkeyword = rawurlencode($this->input->get('itemkeyword'));    
$url=$this->config->item("api_url") . "/api/inventorylist/ldg_keyword/" . $itemkeyword . "/" . $compId ;
//$post = ['batch_id'=> "2"];

//$post=array("flag"=>$flag,"itemkeyword"=>$itemkeyword,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

//  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
 // var_dump($url);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;
}




public function getvendordata()
{
$id = $this->input->get('id');    
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$url=$this->config->item("api_url") . "/api/ledger/" . $id . "/" . $compId;
//$post = ['batch_id'=> "2"];

$post=array("id"=>$id,"compId"=>$compId);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ldgerArray = json_decode($response, true);

echo $response;
}


function validateDate($date, $format = 'Y-m-d')
{
 //   $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
   // return $d && $d->format($format) === $date;

$timestamp = strtotime($date);
return $timestamp ? $date : null;

}


public function getInvItems()
{
$url=$this->config->item("api_url") . "/api/getinvitems.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray['products'] as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['prod_name'].'</option>';

}
$option .= '<option selected disabled value="0">Select a Product</option>';
echo $option;

}

public function addPurchase()
{
//Main Purchase 
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
    $invno= $this->input->post('invoice_no');
    $invdate= $this->input->post('invoice_date');
    $orderno= $this->input->post('order_no');
    $orderdate= $this->input->post('order_date');
    $dc_no= $this->input->post('dc_no');
    $dc_date= $this->input->post('dc_date');
    $vendor_name= $this->input->post('vendor_name');
    $statecode = $this->input->post('statecode');
    $gstin= $this->input->post('gstin');

//Items Purchase
$taxable_tot=0;
$netamt_tot=0;

$url=$this->config->item("api_url") . "/api/insert_transaction.php";

$data_array=array(
    "trans_id"=> $invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"PURC",            
    "db_account"=>$vendor_name,
    "cr_account"=>2,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "trans_narration"=>"INWARD ENTRY POSTED",
    "finyear"=>$finyear,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response, true);
//echo $response;
//var_dump($res);
$ins_sql=array();
$trans_link_id=$res['last_ins_id'];
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for($rw = $cnt+1; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemid = $this->input->post('itemname')[$rw];


$itemData = $this->getproductdatabyid($itemid);
//var_dump(json_decode($itemData));
$obj = json_decode($itemData);
//var_dump($obj);
if($obj)
{
    $itemmrp= $obj->mrp;
    $itemname=$obj->name;
//    print_r($itemmrp);

}
$itemname = $itemname;
$itemdesc = $this->input->post('itemdesc')[$rw];
$itemhsn = $this->input->post('itemhsn')[$rw];
$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemuom = $this->input->post('itemuom')[$rw];
$itemqty = $this->input->post('itemqty')[$rw];
$itemrate = $this->input->post('itemrate')[$rw];
$itemdispc = $this->input->post('itemdispc')[$rw];
$itemdis = $this->input->post('itemdis')[$rw];
$itemmrp = $itemmrp;
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];

$taxable_tot = $taxable_tot+$itemamt;
$netamt_tot = $netamt_tot+$itemnet;

if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

$ins_sql[] = array("trans_link_id"=>$trans_link_id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn,"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"PURC","item_id"=>$itemid,/*"item_name"=>$item_name,*/"item_unit"=>$itemuom,"item_qty"=>$itemqty,"item_rate"=>$itemrate,"item_amount"=>$itemamt,"item_mrp"=>$itemmrp,"item_gstpc"=>$itemgstpc,"item_dispc"=>$itemdispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt,"nett_amount"=>$itemnet,"item_desc"=>$itemdesc,"company_id"=>$compId,"finyear"=>$finyear);

//$ins_sql = array($trans_link_id,$itemhsn,$invno,$invdate,$itemid,$itemuom,$itemqty,$itemrate,$itemamt,$itemgstpc,$itemdispc,$itemdis,$cgstamt,$sgstamt,$igstamt,$cgstpc,$sgstpc,$igstpc,$itemamt,$itemnet,$itemdesc,$compId);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_transactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);

foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);


}


$url=$this->config->item("api_url") . "/api/update_transaction_total.php";

$data_updarray=array(
    "id"=> $trans_link_id,
    "taxable_amount"=>$taxable_tot,
    "net_amount"=>$netamt_tot,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_updarray));
  $updresponse = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);


echo $results;
/*
for ($i=0; $i <count($ins_sql) ; $i++) { 

    //print_r($ins_sql[$i]);
$each_data =  array($ins_sql[$i]);

    # code...

    # code...

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($each_data));


echo json_encode($each_data);
}  */ 
  //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($ins_sql));
  /*$response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection



echo $response;
*/


}


//Purchase Return Entry New

// Sales Return Entry New
public function old__createRPurchase()
{
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;
$id=$this->input->post('recid');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    
    $invno= $this->input->post('invoiceno');
    $cndn_no=$this->input->post('cndn_no');
    $cndn_date=$this->input->post('cndn_date');
    $invdate= $this->input->post('invdate');
    //$orderno= $this->input->post('orderno');
    //$odate= $this->input->post('orderdate');
    //$dc_no= $this->input->post('dcno');
    //$ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');
/*
$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}
*/
//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}


//$url=$this->config->item("api_url") . "/api/getsettings.php";
$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;
$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $dnprefix = $settArr->dn_prefix;
    $dnsuffix = $settArr->dn_suffix;
    $dn_no = $settArr->dn_no;
    $dn_numtype = $settArr->inv_numtype;
    $dn_leadingzero = $settArr->leading_zero;

if($dn_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_dnno = sprintf("%0". $dn_leadingzero ."d", $dn_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$dnno = $dnprefix . $_dnno . $dnsuffix;
$next_dnno = $dn_no+1;
}
else
{
    $_dnno= $dn_no;
    $dnno = $dnprefix . $_dnno . $dnsuffix;
    $next_dnno = $dn_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase

$url=$this->config->item("api_url") . "/api/insert_cndntransaction.php";
$trans_type="PRTN";
$data_array=array(
    "srecid"=>$id,
    "cndntrans_id"=>$dnno,
    "cndntrans_date"=>$cndn_date,
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
  //  "order_no"=>$orderno,
  //  "order_date"=>$orderdate,
  //  "dc_no"=>$dc_no,
  //  "dc_date"=>$dc_date,
    "trans_type"=>$trans_type,            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "invtype"=>$invtype,
    "taxable_amount"=>$tax_tot,
    "nett_amount"=>$net_tot,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);


$ins_sql=array();
$id=$res['last_ins_id'];


if($id)
{
$url=$this->config->item("api_url") . "/api/updatesettings.php";
$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_dnno,"trans_type"=>"PRTN");
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 $sts= json_decode($updsettresponse);
}
else
{
  $sts = json_encode(array("status"=>false));
}
if($sts->status==true)
{



$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);

$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
//var_dump($itemData);
//$obj = json_decode($itemData);

if($itemData)
{
    $itemmrp= $itemData[0]['mrp'];
    $itemname=$itemData[0]['name'];
    $itemid=$itemData[0]['id'];
  //var_dump($itemmrp);
  //  var_dump($itemid);
}
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}


//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>$trans_type,"item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_cndntransactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}


// Sales Return Entry New
public function OLDcreateRSales()
{
  $trans_type="SRTN";
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;
$id=$this->input->post('recid');
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));
$cr_account = $this->input->post('cr_acct');

//Main Sales
    
    $invno= $this->input->post('invoiceno');
    $cndn_no=$this->input->post('cndn_no');
    $cndn_date=$this->input->post('cndn_date');
    $invdate= $this->input->post('invdate');
    $orderno= $this->input->post('orderno');
    $orderdate= $this->input->post('orderdate');
    $dc_no= $this->input->post('dcno');
    $dc_date= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');
/*
$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}
*/
//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
 //   var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}

$url=$this->config->item("api_url") . "/api/productlist/getsettings";

//$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
	$iprefix = $settArr[0]['cn_prefix'];
	$isuffix = $settArr[0]['cn_suffix'];
	$inv_no = $settArr[0]['cn_no'];
	$inv_numtype = $settArr[0]['inv_numtype'];
	$inv_leadingzero = $settArr[0]['leading_zero'];

if($inv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_invno = sprintf("%0". $inv_leadingzero ."d", $inv_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$invno = $iprefix . $_invno . $isuffix;
$next_invno = $inv_no+1;
}
else
{
	$_invno= $inv_no;
	$invno = $iprefix . $_invno . $isuffix;
	$next_invno = $inv_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase
$url=$this->config->item("api_url") . "/api/inventorylist/createPurchase";

//$url=$this->config->item("api_url") . "/api/insert_cndntransaction.php";
$trans_type="SRTN";

$data_array=array(
	"trans_id"=>$invno,
	"trans_date"=>$invdate,
	"order_no"=>$orderno,
	"order_date"=>$orderdate,
	"dc_no"=>$dc_no,
	"dc_date"=>$dc_date,
	"trans_type"=>$trans_type,            
	"db_account"=>$db_account,
	"cr_account"=>$cr_account,
	"statecode"=>$statecode,
	"gstin"=>$gstin,
	"finyear"=>$finyear,
	"salebyperson"=>$salebyperson,
	"inv_type"=>$invtype,
	"trans_amount"=>$tax_tot,
	"net_amount"=>$net_tot,
	"company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
// var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);


$ins_sql=array();
$id=$res['last_ins_id'];
//var_dump($id);

if($id)
{
	$url=$this->config->item("api_url") . "/api/productlist/updsettings";

	$compId = $this->session->userdata('id');
	$finyear = $this->session->userdata('finyear');
	
	$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>$trans_type);
	 //var_dump($data_array);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
		$updsettresponse = curl_exec($ch);
curl_close($ch);
// var_dump($updsettresponse);
 $sts= json_decode($updsettresponse,true);

//var_dump($sts);
if($updsettresponse==true)
{

//var_dump($sts);

	$cnt = count($this->input->post('itemqty'));
	//var_dump($cnt);
	//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
	for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
	
	//for($rw = $cnt; $rw >1; $rw--) {
			//print_r($rw);
	//$taxable_amt = $this->input->post('txbval')[$rw];
	$itemname = $this->input->post('itemname');
	//var_dump($itemid);
	
	$itemData = json_decode($this->getproductdatabyname($itemname[$i]),true);
	//var_dump($itemData);
	//$obj = json_decode($itemData);
	
	if($itemData)
	{
			$itemmrp= $itemData[0]['prod_mrp'];
			$itemname=$itemData[0]['prod_name'];
			$itemid=$itemData[0]['id'];
		//var_dump($itemmrp);
		//  var_dump($itemid);
	}
	if(is_numeric($itemmrp))
	{
			$item_mrp=floatval($itemmrp);
	}
	else
	{
			$item_mrp="0.00";
	}
	
	
	//$itemname = $itemname[$i];
	$itemdesc = $this->input->post('itemdesc');
	$itemhsn = $this->input->post('hsnsac');
	$itemgstpc = $this->input->post('itemgstpc');
	$itemuom = $this->input->post('itemunit');
	$itemqty = $this->input->post('itemqty');
	$itemrate = $this->input->post('itemrate');
	
	$itemdispc = $this->input->post('itemdispc');
	
	if(is_null($itemdispc[$i]) )
	{
	 $item_dispc=0.00;   
	 
	}
	else
	{
	 $item_dispc = floatval($itemdispc[$i]);  
	}
	
	//var_dump($itemrate);
	//var_dump($itemqty);
	//var_dump($itemdispc);
	$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);
	
	//$itemdis = $this->input->post('itemdis')[$rw];
	//$itemmrp = $itemmrp[$i];
	//$itemgstamt = $this->input->post('itemgstamt')[$rw];
	$itemamt = $this->input->post('itemamt');
	$itemnet = $this->input->post('itemnet');
	
	
	
	if($cpos==$statecode)
	{
	// Intra state
	$cgstpc=0;
	$sgstpc=0;
	$cgstamt=0;
	$sgstamt=0;    
	$igstpc=0;
	$igstamt=0;
	$cgstpc = $itemgstpc[$i]/2;
	$sgstpc = $itemgstpc[$i]/2;
	$cgstamt = ($itemamt[$i]*$cgstpc)/100;
	$sgstamt = ($itemamt[$i]*$sgstpc)/100;
	
	}
	else 
	{
	//Inter state
	$igstpc=0;
	$igstamt=0;    
	$cgstpc=0;
	$sgstpc=0;
	$cgstamt=0;
	$sgstamt=0;    
	$results=array();
	$igstpc = $itemgstpc[$i];
	$igstamt = ($itemamt[$i]*$igstpc)/100;
	}
	
	$tax_tot=$tax_tot+$itemamt[$i];
	$net_tot=$tax_tot+$itemnet[$i];
	$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>$trans_type,"item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);
	
	//$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SRTN","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);
	
	
	//var_dump($ins_sql);
	}
	
	$each_data=array();
	$url=$this->config->item("api_url") . "/api/inventorylist/createPurchaseItems";
	
	//$url=$this->config->item("api_url") . "/api/insert_cndntransactionitems.php";
	
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
	
	
	
	foreach($ins_sql as $r) {
			//var_dump($r);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
			$results = curl_exec($ch);
			curl_close($ch);
	
	
	
	}
	

}




}
else
{
  $sts = json_encode(array("status"=>false));
}
echo $results;



}

public function createSales()
{
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));
$cr_account = $this->input->post('cr_acct');


//Main Sales
    
    //$invno= $this->input->post('invoiceno');
    $invdate= $this->input->post('invdate');
    $orderno= $this->input->post('orderno');
    $odate= $this->input->post('orderdate');

    $creditperiod= $this->input->post('creditperiod');
		$dc_no= $this->input->post('dcno');
    $ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');

$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}

//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}

$url=$this->config->item("api_url") . "/api/productlist/getsettings";

//$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  

 //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query());
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $iprefix = $settArr[0]['inv_prefix'];
    $isuffix = $settArr[0]['inv_suffix'];
    $inv_no = $settArr[0]['inv_no'];
    $inv_numtype = $settArr[0]['inv_numtype'];
    $inv_leadingzero = $settArr[0]['leading_zero'];

if($inv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_invno = sprintf("%0". $inv_leadingzero ."d", $inv_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$invno = $iprefix . $_invno . $isuffix;
$next_invno = $inv_no+1;
}
else
{
    $_invno= $inv_no;
    $invno = $iprefix . $_invno . $isuffix;
    $next_invno = $inv_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase
$url=$this->config->item("api_url") . "/api/inventorylist/createPurchase";

//$url=$this->config->item("api_url") . "/api/transaction";

$data_array=array(
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"SALE",            
    "db_account"=>$db_account,
    "cr_account"=>$cr_account,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$tax_tot,
    "net_amount"=>$net_tot,
		"creditperiod"=>$creditperiod,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//var_dump($res);

$ins_sql=array();
$id=$res['last_ins_id'];

//var_dump("id = " . $id);
if($id)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SALE");
 //var_dump($data_array);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 //$sts= json_decode($updsettresponse,true);
//var_dump($sts);
$sts="1";
}
else
{
  $sts = "0";
}


if($sts=="1")
{

$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);


$url=$this->config->item("api_url") . "/api/productlist/getproductidbyname";

//$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
//$data_array=array("delflag"=>"1");
$data_array=array("itemkeyword"=>$itemname[$i],"compId"=>$compId);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
	$prodresponse = curl_exec($ch);

	curl_close($ch); // Close the connection
//var_dump($prodresponse);

//$itemData = json_decode($this->getproductidbyname($itemname[$i]),true);
//var_dump($itemData);
$prodobj = json_decode($prodresponse,true);
//var_dump($prodobj);
if($prodobj)
{
		//$itemmrp= $itemData[0]['prod_mrp'];
		//$itemname=$itemData[0]['prod_name'];
		$itemid=$prodobj[0]['id'];
	//var_dump($itemmrp);
 //   var_dump($itemid);
}
	
//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');
$itemmrp = $this->input->post('itemmrp');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname[$i], "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$itemmrp[$i],"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/inventorylist/createPurchaseItems";

//$url=$this->config->item("api_url") . "/api/itemtransaction";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}


//Purchase Return

public function createRPurchase()
{
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));
$cr_account = $this->input->post('cr_acct');


//Main Sales
    
    //$invno= $this->input->post('invoiceno');
    $invdate= $this->input->post('invdate');
    $orderno= $this->input->post('orderno');
    $odate= $this->input->post('orderdate');

    $creditperiod= $this->input->post('creditperiod');
		$dc_no= $this->input->post('dcno');
    $ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');

$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}

//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}

$url=$this->config->item("api_url") . "/api/productlist/getsettings";

//$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  

 //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query());
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $iprefix = $settArr[0]['dn_prefix'];
    $isuffix = $settArr[0]['dn_suffix'];
    $inv_no = $settArr[0]['dn_no'];
    $inv_numtype = $settArr[0]['inv_numtype'];
    $inv_leadingzero = $settArr[0]['leading_zero'];

if($inv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_invno = sprintf("%0". $inv_leadingzero ."d", $inv_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$invno = $iprefix . $_invno . $isuffix;
$next_invno = $inv_no+1;
}
else
{
    $_invno= $inv_no;
    $invno = $iprefix . $_invno . $isuffix;
    $next_invno = $inv_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase
$url=$this->config->item("api_url") . "/api/inventorylist/createPurchase";

//$url=$this->config->item("api_url") . "/api/transaction";

$data_array=array(
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"PRTN",            
    "db_account"=>$db_account,
    "cr_account"=>$cr_account,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$tax_tot,
    "net_amount"=>$net_tot,
		"creditperiod"=>$creditperiod,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//var_dump($res);

$ins_sql=array();
$id=$res['last_ins_id'];

//var_dump("id = " . $id);
if($id)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"PRTN");
 //var_dump($data_array);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 //$sts= json_decode($updsettresponse,true);
//var_dump($sts);
$sts="1";
}
else
{
  $sts = "0";
}


if($sts=="1")
{

$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);


$url=$this->config->item("api_url") . "/api/productlist/getproductidbyname";

//$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
//$data_array=array("delflag"=>"1");
$data_array=array("itemkeyword"=>$itemname[$i],"compId"=>$compId);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
	$prodresponse = curl_exec($ch);

	curl_close($ch); // Close the connection
//var_dump($prodresponse);

//$itemData = json_decode($this->getproductidbyname($itemname[$i]),true);
//var_dump($itemData);
$prodobj = json_decode($prodresponse,true);
//var_dump($prodobj);
if($prodobj)
{
		//$itemmrp= $itemData[0]['prod_mrp'];
		//$itemname=$itemData[0]['prod_name'];
		$itemid=$prodobj[0]['id'];
	//var_dump($itemmrp);
 //   var_dump($itemid);
}
	
//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');
$itemmrp = $this->input->post('itemmrp');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname[$i], "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"PRTN","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$itemmrp[$i],"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/inventorylist/createPurchaseItems";

//$url=$this->config->item("api_url") . "/api/itemtransaction";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}



//Sales Return

public function createRSales()
{
$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    
    //$invno= $this->input->post('invoiceno');
    $invdate= $this->input->post('invdate');
    $orderno= $this->input->post('orderno');
    $odate= $this->input->post('orderdate');

    $creditperiod= $this->input->post('creditperiod');
		$dc_no= $this->input->post('dcno');
    $ddate= $this->input->post('dcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('invtype');

    $salebyperson=$this->input->post('salebyperson');

$o_date=$this->validateDate($odate);
if($o_date==null)
{
$orderdate="1970-01-01";
}
else
{
    $orderdate = $o_date;
}
$d_date=$this->validateDate($ddate);
if($d_date==null)
{
$dc_date="1970-01-01";
}
else
{
    $dc_date = $d_date;
}

//var_dump($orderdate);
//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;


}

$url=$this->config->item("api_url") . "/api/productlist/getsettings";

//$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  

 //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query());
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);


if($settArr)
{
    # code...
  //var_dump($settArr);
    $iprefix = $settArr[0]['cn_prefix'];
    $isuffix = $settArr[0]['cn_suffix'];
    $inv_no = $settArr[0]['cn_no'];
    $inv_numtype = $settArr[0]['inv_numtype'];
    $inv_leadingzero = $settArr[0]['leading_zero'];

if($inv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_invno = sprintf("%0". $inv_leadingzero ."d", $inv_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$invno = $iprefix . $_invno . $isuffix;
$next_invno = $inv_no+1;
}
else
{
    $_invno= $inv_no;
    $invno = $iprefix . $_invno . $isuffix;
    $next_invno = $inv_no+1;
}



}


//var_dump($invno);
//Transaction Sales & Purhcase
$url=$this->config->item("api_url") . "/api/inventorylist/createPurchase";

//$url=$this->config->item("api_url") . "/api/transaction";

$data_array=array(
    "trans_id"=>$invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"SRTN",            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$tax_tot,
    "net_amount"=>$net_tot,
		"creditperiod"=>$creditperiod,
    "company_id"=>$compId);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//var_dump($res);

$ins_sql=array();
$id=$res['last_ins_id'];

//var_dump("id = " . $id);
if($id)
{
$url=$this->config->item("api_url") . "/api/productlist/updsettings";

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

$data_array=array("finyear"=>$finyear,"compId"=>$compId,"next_no"=>$next_invno,"trans_type"=>"SRTN");
 //var_dump($data_array);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $updsettresponse = curl_exec($ch);
curl_close($ch);
 //var_dump($updsettresponse);
 //$sts= json_decode($updsettresponse,true);
//var_dump($sts);
$sts="1";
}
else
{
  $sts = "0";
}


if($sts=="1")
{

$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);


$url=$this->config->item("api_url") . "/api/productlist/getproductidbyname";

//$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
//$data_array=array("delflag"=>"1");
$data_array=array("itemkeyword"=>$itemname[$i],"compId"=>$compId);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
	$prodresponse = curl_exec($ch);

	curl_close($ch); // Close the connection
//var_dump($prodresponse);

//$itemData = json_decode($this->getproductidbyname($itemname[$i]),true);
//var_dump($itemData);
$prodobj = json_decode($prodresponse,true);
//var_dump($prodobj);
if($prodobj)
{
		//$itemmrp= $itemData[0]['prod_mrp'];
		//$itemname=$itemData[0]['prod_name'];
		$itemid=$prodobj[0]['id'];
	//var_dump($itemmrp);
 //   var_dump($itemid);
}
	
//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');
$itemmrp = $this->input->post('itemmrp');

$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname[$i], "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SRTN","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$itemmrp[$i],"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
$url=$this->config->item("api_url") . "/api/inventorylist/createPurchaseItems";

//$url=$this->config->item("api_url") . "/api/itemtransaction";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}

}
echo $results;



}


public function getSettings()
{
$chk_transtype = $this->input->get('chkval');

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');

//$url=$this->config->item("api_url") . "/api/settings/"  ;
//getsettings
$url=$this->config->item("api_url") . "/api/productlist/getsettings";
// . $finyear . "/" . $compId;
//$url=$this->config->item("api_url") . "/api/settings/" . $finyear . "/" . $compId;

$data_array= array("compId"=>$compId,"finyear"=>$finyear);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $setresponse = curl_exec($ch);
  curl_close($ch); // Close the connection
//var_dump($setresponse);
$settArr = json_decode($setresponse,true);
//var_dump($settArr);

if($settArr)
{
  /*  # code...
  //var_dump($settArr);
    $iprefix = $settArr[0]['inv_prefix'];
    $isuffix = $settArr[0]['inv_suffix'];
    $inv_no = $settArr[0]['inv_no'];
    $inv_numtype = $settArr[0]['inv_numtype'];
    $inv_leadingzero = $settArr[0]['leading_zero'];
*/
 // var_dump($settArr);
if($chk_transtype=="SRTN")
{
	$iprefix = $settArr[0]['cn_prefix'];
	$isuffix = $settArr[0]['cn_suffix'];
	$inv_no = $settArr[0]['cn_no'];
	$inv_numtype = $settArr[0]['inv_numtype'];
	$inv_leadingzero = $settArr[0]['leading_zero'];

}
else if($chk_transtype=="PRTN")
{
	$iprefix = $settArr[0]['dn_prefix'];
	$isuffix = $settArr[0]['dn_suffix'];
	$inv_no = $settArr[0]['dn_no'];
	$inv_numtype = $settArr[0]['inv_numtype'];
	$inv_leadingzero = $settArr[0]['leading_zero'];

}
else if($chk_transtype=="SALE")
{
	$iprefix = $settArr[0]['inv_prefix'];
	$isuffix = $settArr[0]['inv_suffix'];
	$inv_no = $settArr[0]['inv_no'];
	$inv_numtype = $settArr[0]['inv_numtype'];
	$inv_leadingzero = $settArr[0]['leading_zero'];

}
if($inv_numtype=="ZEROPAD")
{
//$ivno= $inv_no;
$_invno = sprintf("%0". $inv_leadingzero ."d", $inv_no);
//$invnum = printf("[%0" .$inv_leadingzero ."s]\n",   $ivno); // zero-padding works on strings too

$invno = $iprefix . $_invno . $isuffix;
//var_dump($inv_no);
$next_invno = $inv_no+1;
}
else
{
    $_invno= $inv_no;
    $invno = $iprefix . $_invno . $isuffix;
 //   $next_invno = $inv_no+1;
}


}

echo $invno;

}

public function createPurchase()
{
	$tax_tot=0;
	$net_tot=0;
	$itemdispc=0.00;
	
	$compId = $this->session->userdata('id');
	$finyear = $this->session->userdata('finyear');
	$cpos = $this->session->userdata('cstatecode');
	$statecode = $this->input->post('statecode');
	$cnt = count($this->input->post('itemqty'));
	$cr_account = $this->input->post('cr_acct');

	
	//Main Sales
			
			$invno= $this->input->post('invoiceno');
			$invdate= $this->input->post('invdate');
			$orderno= $this->input->post('orderno');
			$odate= $this->input->post('orderdate');
			$dc_no= $this->input->post('dcno');
			$ddate= $this->input->post('dcdate');
			$vendor_name= $this->input->post('customer_name');
			//$statecode = $this->input->post('editstatecode');
			$invtype= $this->input->post('invtype');
	
			$salebyperson=$this->input->post('salebyperson');
	
	$o_date=$this->validateDate($odate);
	if($o_date==null)
	{
	$orderdate="1970-01-01";
	}
	else
	{
			$orderdate = $o_date;
	}
	$d_date=$this->validateDate($ddate);
	if($d_date==null)
	{
	$dc_date="1970-01-01";
	}
	else
	{
			$dc_date = $d_date;
	}
	
	//var_dump($orderdate);
	//var_dump($cnt);
	$ldgarray = $this->getledgerdatasearchbyname($vendor_name);
	
	foreach ($ldgarray as $lvalue) {
			//var_dump($lvalue);
			# code...
			$statecode=$lvalue['account_statecode'];
			$gstin=$lvalue['account_gstin'];
			$db_account=$lvalue['id'];
	}
	$r=0;
	
	for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
			# code...
	
			# code...
	
	$itemgstpc = $this->input->post('itemgstpc');
	$itemamt = $this->input->post('itemamt');
	$itemnet = $this->input->post('itemnet');
	
	//echo $itemgstpc[$i];
	//var_dump($itemamt);
	//var_dump($itemnet);
	
	
	if($cpos==$statecode)
	{
	// Intra state
	$cgstpc=0;
	$sgstpc=0;
	$cgstamt=0;
	$sgstamt=0;    
	$igstpc=0;
	$igstamt=0;
	$cgstpc = $itemgstpc[$i]/2;
	$sgstpc = $itemgstpc[$i]/2;
	$cgstamt = ($itemamt[$i]*$cgstpc)/100;
	$sgstamt = ($itemamt[$i]*$sgstpc)/100;
	//var_dump($sgstpc);
	}
	else 
	{
	//Inter state
	$igstpc=0;
	$igstamt=0;    
	$cgstpc=0;
	$sgstpc=0;
	$cgstamt=0;
	$sgstamt=0;    
	$results=array();
	$igstpc = $itemgstpc[$i];
	$igstamt = ($itemamt[$i]*$igstpc)/100;
	//var_dump($igstpc);
	}
	
	$tax_tot=$tax_tot+$itemamt[$i];
	$net_tot=$net_tot+$itemnet[$i];
	
	$r++;
	
	
	}
	
	
	//var_dump($invno);
	//Transaction Sales & Purhcase
	$url=$this->config->item("api_url") . "/api/inventorylist/createPurchase";
	
	//$url=$this->config->item("api_url") . "/api/transaction";
	
	$data_array=array(
			"trans_id"=>$invno,
			"trans_date"=>$invdate,
			"order_no"=>$orderno,
			"order_date"=>$orderdate,
			"dc_no"=>$dc_no,
			"dc_date"=>$dc_date,
			"trans_type"=>"PURC",            
			"db_account"=>$db_account,
			"cr_account"=>$cr_account,
			"statecode"=>$statecode,
			"gstin"=>$gstin,
			"finyear"=>$finyear,
			"salebyperson"=>$salebyperson,
			"inv_type"=>$invtype,
			"trans_amount"=>$tax_tot,
			"net_amount"=>$net_tot,
			"company_id"=>$compId);
	
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
		$response = curl_exec($ch);
		//var_dump($response);
		//echo $response;
		//$result = json_decode($response);
		curl_close($ch); // Close the connection
	
	$res = json_decode($response,true);
	//var_dump($res);
	
	$ins_sql=array();
	$id=$res['last_ins_id'];
	
	
	
	$cnt = count($this->input->post('itemqty'));
	//var_dump($cnt);
	//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
	for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
	
	//for($rw = $cnt; $rw >1; $rw--) {
			//print_r($rw);
	//$taxable_amt = $this->input->post('txbval')[$rw];
	$itemname = $this->input->post('itemname');
	//var_dump($itemid);


	$url=$this->config->item("api_url") . "/api/productlist/getproductidbyname";

	//$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
	//$data_array=array("delflag"=>"1");
	$data_array=array("itemkeyword"=>$itemname[$i],"compId"=>$compId);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
		$prodresponse = curl_exec($ch);
	
		curl_close($ch); // Close the connection
	//var_dump($prodresponse);
	
	//$itemData = json_decode($this->getproductidbyname($itemname[$i]),true);
	//var_dump($itemData);
	$prodobj = json_decode($prodresponse,true);
	//var_dump($prodobj);
	if($prodobj)
	{
			//$itemmrp= $itemData[0]['prod_mrp'];
			//$itemname=$itemData[0]['prod_name'];
			$itemid=$prodobj[0]['id'];
		//var_dump($itemmrp);
	 //   var_dump($itemid);
	}
		
	//$itemname = $itemname[$i];
	$itemdesc = $this->input->post('itemdesc');
	$itemhsn = $this->input->post('hsnsac');
	$itemgstpc = $this->input->post('itemgstpc');
	$itemuom = $this->input->post('itemunit');
	$itemqty = $this->input->post('itemqty');
	$itemrate = $this->input->post('itemrate');
	$item_mrp = $this->input->post('itemmrp');
	
	$itemdispc = $this->input->post('itemdispc');
	
	if(is_null($itemdispc[$i]) )
	{
	 $item_dispc=0.00;   
	 
	}
	else
	{
	 $item_dispc = floatval($itemdispc[$i]);  
	}
	
	//var_dump($itemrate);
	//var_dump($itemqty);
	//var_dump($itemdispc);
	$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);
	
	//$itemdis = $this->input->post('itemdis')[$rw];
	//$itemmrp = $itemmrp[$i];
	//$itemgstamt = $this->input->post('itemgstamt')[$rw];
	$itemamt = $this->input->post('itemamt');
	$itemnet = $this->input->post('itemnet');
	
	
	
	if($cpos==$statecode)
	{
	// Intra state
	$cgstpc=0;
	$sgstpc=0;
	$cgstamt=0;
	$sgstamt=0;    
	$igstpc=0;
	$igstamt=0;
	$cgstpc = $itemgstpc[$i]/2;
	$sgstpc = $itemgstpc[$i]/2;
	$cgstamt = ($itemamt[$i]*$cgstpc)/100;
	$sgstamt = ($itemamt[$i]*$sgstpc)/100;
	
	}
	else 
	{
	//Inter state
	$igstpc=0;
	$igstamt=0;    
	$cgstpc=0;
	$sgstpc=0;
	$cgstamt=0;
	$sgstamt=0;    
	$results=array();
	$igstpc = $itemgstpc[$i];
	$igstamt = ($itemamt[$i]*$igstpc)/100;
	}
	
	$tax_tot=$tax_tot+$itemamt[$i];
	$net_tot=$tax_tot+$itemnet[$i];
	
	$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname[$i], "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"PURC","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp[$i],"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);
	
	
	//var_dump($ins_sql);
	}
	
	$each_data=array();
	$url=$this->config->item("api_url") . "/api/inventorylist/createPurchaseItems";
	
	//$url=$this->config->item("api_url") . "/api/itemtransaction";
	
	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
	
	
	
	foreach($ins_sql as $r) {
			//var_dump($r);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
			$results = curl_exec($ch);
			curl_close($ch);
	
	
	
	}
	
	
	echo $results;
	
	
}



public function editSales()

{

$tax_tot=0;
$net_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));
$trans_type = $this->input->post('trans_type');

//Main Sales
    $id= $this->input->post('recid');
    $invno= $this->input->post('editinvoiceno');
    $invdate= $this->input->post('editinvdate');
    $orderno= $this->input->post('editorderno');

    $creditperiod= $this->input->post('creditperiod');
		$orderdate= $this->input->post('editorderdate');
    $dc_no= $this->input->post('editdcno');
    $dc_date= $this->input->post('editdcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('editinvtype');

    $salebyperson=$this->input->post('editsalebyperson');

//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;
//for($rw = $cnt; $rw >1; $rw--) {
//print_r($this->input->post('itemgstpc'));
//$ex_itemgstpc = explode("=>", $this->input->post('itemgstpc'));
//$ex_itemamt = $this->input->post('itemamt');
//$ex_itemnet = $this->input->post('itemnet');

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$net_tot+$itemnet[$i];

$r++;




}


//Transaction Sales & Purhcase


//$url=$this->config->item("api_url") . "/api/transaction/" . $id;
$url=$this->config->item("api_url") . "/api/inventorylist/transaction_put/" . $id;

$data_array=array(
    //"id"=> $id,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>$trans_type,            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$tax_tot,
    "net_amount"=>$net_tot,
		"creditperiod"=>$creditperiod,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
 // var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//echo $response;
//var_dump($res);
if($res['status'])
{
	$url=$this->config->item("api_url") . "/api/inventorylist/transactionitem_put/" . $id . "/" . $compId . "/" . $finyear ;
//	$compId = $this->session->userdata('id');
//	$finyear = $this->session->userdata('finyear');
	
//$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
$data_array=array("delflag"=>"1","company_id"=>$compId,"finyear"=>$finyear,"trans_link_id"=>$id);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $delresponse = curl_exec($ch);

//var_dump($delresponse);
}


$ins_sql=array();
//$upd_sts=$res['last_ins_id'];
//if($upd_sts==true)/
//{
    
//}
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i < count($this->input->post('itemqty')) ; $i++) { 

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//$//itemid = $this->input->post('itemid');
//var_dump($itemname[$i]);
//var_dump($itemid);


$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$data_array = array('itemkeyword'=>$itemname[$i],'compId'=>$compId,"finyear"=>$finyear);
$url=$this->config->item("api_url") . "/api/productlist/byname";///" . $name . "/" . $compId ;
//var_dump($data_array);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));

  $response = curl_exec($ch);
//var_dump($response);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$prodArray = json_decode($response, true);
//echo json_encode($prodArray);
$itemid =$prodArray['id'];
$itemmrp = $this->input->post('itemmrp');


//$itemData = json_decode($this->getproductdatabyname($itemname[$i],true));
//var_dump($itemData);
//$obj = json_decode($itemData);

  //  $itemmrp= $this->input->post('prod_mrp');
  //  $itemname=$itemData['prod_name'];
//    $itemid=$itemData['id'];



if(is_numeric($itemmrp[$i]))
{
    $item_mrp=floatval($itemmrp[$i]);
}
else
{
    $item_mrp="0.00";
}

//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');
$itemdispc = $this->input->post('itemdispc');
//var_dump($i);
//var_dump($itemdispc[$i]);
if($itemdispc[$i])
{
 $item_dispc = floatval($itemdispc[$i]);  
 
}
else
{
	$item_dispc=0.00;   
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt[$i];
$net_tot=$tax_tot+$itemnet[$i];


$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname[$i], "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>$trans_type, "item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);
//var_dump($ins_sql);
//$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);


//var_dump($ins_sql);
}

$each_data=array();
//createTransItems
$url=$this->config->item("api_url") . "/api/inventorylist/createTransItems";

//$url=$this->config->item("api_url") . "/api/itemtransaction";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");   
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}
echo $results;


}


public function editPurchase()

{

$taxable_tot=0;
$netamt_tot=0;
$itemdispc=0.00;

$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


//Main Sales
    $id= $this->input->post('recid');
    $invno= $this->input->post('editinvoiceno');
    $invdate= $this->input->post('editinvdate');
    $orderno= $this->input->post('editorderno');
    $orderdate= $this->input->post('editorderdate');
    $dc_no= $this->input->post('editdcno');
    $dc_date= $this->input->post('editdcdate');
    $vendor_name= $this->input->post('customer_name');
    //$statecode = $this->input->post('editstatecode');
    $invtype= $this->input->post('editinvtype');

    $salebyperson=0; //$this->input->post('editsalebyperson');

//var_dump($cnt);
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...
    $statecode=$lvalue['account_statecode'];
    $gstin=$lvalue['account_gstin'];
    $db_account=$lvalue['id'];
}
$r=0;
//for($rw = $cnt; $rw >1; $rw--) {
//print_r($this->input->post('itemgstpc'));
//$ex_itemgstpc = explode("=>", $this->input->post('itemgstpc'));
//$ex_itemamt = $this->input->post('itemamt');
//$ex_itemnet = $this->input->post('itemnet');

for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
    # code...

    # code...

$itemgstpc = $this->input->post('itemgstpc');
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

//echo $itemgstpc[$i];
//var_dump($itemamt);
//var_dump($itemnet);


if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;
//var_dump($sgstpc);
}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
//var_dump($igstpc);
}

$taxable_tot=$taxable_tot+$itemamt[$i];
$netamt_tot=$netamt_tot+$itemnet[$i];

$r++;




}


//Transaction Sales & Purhcase

$url=$this->config->item("api_url") . "/api/inventorylist/transaction_put/" . $id;

//$url=$this->config->item("api_url") . "/api/transaction/" . $id;

$data_array=array(
    
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"PURC",            
    "db_account"=>$db_account,
    "cr_account"=>2,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "inv_type"=>$invtype,
    "trans_amount"=>$taxable_tot,
    "net_amount"=>$netamt_tot,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //var_dump($response);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response,true);
//echo $response;
//var_dump($res);
if($res['status']=="1")
{
	$url=$this->config->item("api_url") . "/api/inventorylist/transactionitem_put/" . $id . "/" . $compId . "/" . $finyear ;

//$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
//$data_array=array("delflag"=>"1");
$data_array=array("delflag"=>"1","company_id"=>$compId,"finyear"=>$finyear,"trans_link_id"=>$id);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $delresponse = curl_exec($ch);

//var_dump($delresponse);
}


$ins_sql=array();
//$upd_sts=$res['last_ins_id'];
//if($upd_sts==true)/
//{
    
//}
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for ($i=0; $i <count($this->input->post('itemqty')) ; $i++) { 
$item_amt=0;
$item_net=0;

//for($rw = $cnt; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemname = $this->input->post('itemname');
//var_dump($itemid);
//var_dump($itemname[$i]);



$url=$this->config->item("api_url") . "/api/productlist/getproductidbyname";

//$url=$this->config->item("api_url") . "/api/itemtransaction/" . $id;
//$data_array=array("delflag"=>"1");
$data_array=array("itemkeyword"=>$itemname[$i],"compId"=>$compId);

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $prodresponse = curl_exec($ch);

  curl_close($ch); // Close the connection
//var_dump($prodresponse);

//$itemData = json_decode($this->getproductidbyname($itemname[$i]),true);
//var_dump($itemData);
$prodobj = json_decode($prodresponse,true);
//var_dump($prodobj);
if($prodobj)
{
    //$itemmrp= $itemData[0]['prod_mrp'];
    //$itemname=$itemData[0]['prod_name'];
    $itemid=$prodobj[0]['id'];
  //var_dump($itemmrp);
 //   var_dump($itemid);
}
/*
if(is_numeric($itemmrp))
{
    $item_mrp=floatval($itemmrp);
}
else
{
    $item_mrp="0.00";
}
*/

//$itemname = $itemname[$i];
$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');
$item_mrp =  $this->input->post('itemmrp');
$itemdispc = $this->input->post('itemdispc');

if(is_null($itemdispc[$i]) )
{
 $item_dispc=0.00;   
 
}
else
{
 $item_dispc = floatval($itemdispc[$i]);  
}

//var_dump($itemrate);
//var_dump($itemqty);
//var_dump($itemdispc);
$itemdis = (($itemrate[$i]*$itemqty[$i])*$item_dispc/100);

//$itemdis = $this->input->post('itemdis')[$rw];
//$itemmrp = $itemmrp[$i];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt');
$itemnet = $this->input->post('itemnet');

$item_amt = $itemamt[$i];
$item_net = $itemnet[$i];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc[$i]/2;
$sgstpc = $itemgstpc[$i]/2;
$cgstamt = ($itemamt[$i]*$cgstpc)/100;
$sgstamt = ($itemamt[$i]*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc[$i];
$igstamt = ($itemamt[$i]*$igstpc)/100;
}

//var_dump( $itemamt[$i]);
//var_dump( $itemnet[$i]);

$ins_sql[] = array("trans_link_id"=>$id,"item_name"=>$itemname[$i], "item_hsnsac"=>$itemhsn[$i],"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"PURC", "item_id"=>$itemid,"item_unit"=>$itemuom[$i],"item_qty"=>$itemqty[$i],"item_rate"=>$itemrate[$i],"item_amount"=>$itemamt[$i],"item_mrp"=>$item_mrp[$i],"item_gstpc"=>$itemgstpc[$i],"item_dispc"=>$item_dispc,"item_disamount"=>$itemdis,"cgst_amount"=>$cgstamt,"sgst_amount"=>$sgstamt,"igst_amount"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt[$i],"nett_amount"=>$itemnet[$i],"item_desc"=>$itemdesc[$i],"company_id"=>$compId,"finyear"=>$finyear);
//var_dump($ins_sql);
}



//var_dump($net_tot);

$each_data=array();
$url=$this->config->item("api_url") . "/api/inventorylist/createTransItems";

//$url=$this->config->item("api_url") . "/api/insert_transactionitems.php";
//$url=$this->config->item("api_url") . "/api/itemtransaction";
$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}


echo $results;


}






//Add Sales
public function addSales()
{
$tax_tot=0;
$net_tot=0;
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));


for($rw = $cnt+1; $rw >1; $rw--) {

$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt;
$net_tot=$net_tot+$itemnet;


}


//Main Purchase 
    $invno= $this->input->post('invoice_no');
    $invdate= $this->input->post('invoice_date');
    $orderno= $this->input->post('order_no');
    $orderdate= $this->input->post('order_date');
    $dc_no= $this->input->post('dc_no');
    $dc_date= $this->input->post('dc_date');
    $vendor_name= $this->input->post('customer_name');
    $statecode = $this->input->post('statecode');
    $gstin= $this->input->post('gstin');
    $salebyperson=$this->input->post('salesperson_name');

//Items Purchase


$url=$this->config->item("api_url") . "/api/insert_transaction.php";

$data_array=array(
    "trans_id"=> $invno,
    "trans_date"=>$invdate,
    "order_no"=>$orderno,
    "order_date"=>$orderdate,
    "dc_no"=>$dc_no,
    "dc_date"=>$dc_date,
    "trans_type"=>"SALE",            
    "db_account"=>$vendor_name,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "trans_narration"=>"OUTWARD ENTRY POSTED",
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "taxable_amount"=>$tax_tot,
    "nett_amount"=>$net_tot,
    "company_id"=>$compId);

//var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response, true);
//echo $response;
//var_dump($res);
$ins_sql=array();
$trans_link_id=$res['last_ins_id'];
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for($rw = $cnt+1; $rw >1; $rw--) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemid = $this->input->post('itemname')[$rw];


$itemData = $this->getproductdatabyid($itemid);
//var_dump(json_decode($itemData));
$obj = json_decode($itemData);
//var_dump($obj);
if($obj)
{
    $itemmrp= $obj->mrp;
    $itemname=$obj->name;
//    print_r($itemmrp);

}
$itemname = $itemname;
$itemdesc = $this->input->post('itemdesc')[$rw];
$itemhsn = $this->input->post('itemhsn')[$rw];
$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemuom = $this->input->post('itemuom')[$rw];
$itemqty = $this->input->post('itemqty')[$rw];
$itemrate = $this->input->post('itemrate')[$rw];
$itemdispc = $this->input->post('itemdispc')[$rw];
$itemdis = $this->input->post('itemdis')[$rw];
$itemmrp = $itemmrp;
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

//$tax_tot=$tax_tot+$itemamt;
//$net_tot=$tax_tot+$itemnet;

$ins_sql[] = array("trans_link_id"=>$trans_link_id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn,"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,/*"item_name"=>$item_name,*/"item_unit"=>$itemuom,"item_qty"=>$itemqty,"item_rate"=>$itemrate,"item_amount"=>$itemamt,"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc,"item_dispc"=>$itemdispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt,"nett_amount"=>$itemnet,"item_desc"=>$itemdesc,"company_id"=>$compId,"finyear"=>$finyear);

//$ins_sql = array($trans_link_id,$itemhsn,$invno,$invdate,$itemid,$itemuom,$itemqty,$itemrate,$itemamt,$itemgstpc,$itemdispc,$itemdis,$cgstamt,$sgstamt,$igstamt,$cgstpc,$sgstpc,$igstpc,$itemamt,$itemnet,$itemdesc,$compId);
//var_dump($ins_sql);

}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_transactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}
echo $results;

}


//Sales Return
public function addRSales()
{
$tax_tot=0;
$net_tot=0;
$compId = $this->session->userdata('id');
$finyear = $this->session->userdata('finyear');
$cpos = $this->session->userdata('cstatecode');
$statecode = $this->input->post('statecode');
$cnt = count($this->input->post('itemqty'));



for($rw = 0; $rw<$cnt;  $rw++) {

$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

$tax_tot=$tax_tot+$itemamt;
$net_tot=$net_tot+$itemnet;


}


//Main Purchase 
    $cndninvno= $this->input->post('cndn_no');
    $cndninvdate= $this->input->post('cndn_date');

    $invno= $this->input->post('invoiceno');
    $invdate= $this->input->post('invdate');
    //$orderno= $this->input->post('order_no');
    //$o/rderdate= $this->input->post('order_date');
    //$dc_no= $this->input->post('dc_no');
    //$dc_date= $this->input->post('dc_date');
    $vendor_name= $this->input->post('customer_name');
    $statecode = $this->input->post('statecode');
    $gstin= $this->input->post('gstin');
    $salebyperson=$this->input->post('salebyperson');

//Items Purchase
$ldgarray = $this->getledgerdatasearchbyname($vendor_name);

foreach ($ldgarray as $lvalue) {
    //var_dump($lvalue);
    # code...

    $statecode=$lvalue['statecode'];
    $gstin=$lvalue['gstin'];
    $db_account=$lvalue['id'];
}


$url=$this->config->item("api_url") . "/api/insert_cndntransaction.php";

$data_array=array(
    "cndntrans_id"=> $cndninvno,
    "cndntrans_date"=>$cndninvdate,
    "trans_id"=> $invno,
    "trans_date"=>$invdate,
    //"order_no"=>$orderno,
    //"order_date"=>$orderdate,
    //"dc_no"=>$dc_no,
    //"dc_date"=>$dc_date,
    "trans_type"=>"SRTN",            
    "db_account"=>$db_account,
    "cr_account"=>1,
    "statecode"=>$statecode,
    "gstin"=>$gstin,
    "trans_narration"=>"OUTWARD ENTRY POSTED",
    "finyear"=>$finyear,
    "salebyperson"=>$salebyperson,
    "taxable_amount"=>$tax_tot,
    "nett_amount"=>$net_tot,
    "company_id"=>$compId);

var_dump($data_array);
//$make_call = $this->callAPI('POST', $url, json_encode($data_array));

//$url=$this->config->item("api_url") . "/api/insert_transaction.php";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  echo $response;
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

$res = json_decode($response, true);
//echo $response;
//var_dump($res);
$ins_sql=array();
$trans_link_id=$res['last_ins_id'];
//var_dump($trans_link_id);
$cnt = count($this->input->post('itemqty'));
//var_dump($cnt);
//for($rw = 0; $rw < count($this->input->post('itemqty')); $rw++) {
for($rw =0; $rw<$cnt; $rw++) {
    //print_r($rw);
//$taxable_amt = $this->input->post('txbval')[$rw];
$itemid = $this->input->post('itemname')[$rw];


$itemData = $this->getproductdatabyid($itemid);
//var_dump(json_decode($itemData));
$obj = json_decode($itemData);
//var_dump($obj);
if($obj)
{
    $itemmrp= $obj->mrp;
    $itemname=$obj->name;
//    print_r($itemmrp);

}
/*$itemdesc = $this->input->post('itemdesc');
$itemhsn = $this->input->post('hsnsac');
$itemgstpc = $this->input->post('itemgstpc');
$itemuom = $this->input->post('itemunit');
$itemqty = $this->input->post('itemqty');
$itemrate = $this->input->post('itemrate');

$itemdispc = $this->input->post('itemdispc');
*/

$itemname = $this->input->post('itemname')[$rw];
$itemdesc = $this->input->post('itemdesc')[$rw];
$itemhsn = $this->input->post('hsnsac')[$rw];
$itemgstpc = $this->input->post('itemgstpc')[$rw];
$itemuom = $this->input->post('itemunit')[$rw];
$itemqty = $this->input->post('itemqty')[$rw];
$itemstk = $this->input->post('itemstk')[$rw];
$itemrate = $this->input->post('itemrate')[$rw];
$itemdispc = $this->input->post('itemdispc')[$rw];
//$itemdis = $this->input->post('itemdis')[$rw];
$itemmrp = $this->input->post('itemmrp')[$rw];
//$itemgstamt = $this->input->post('itemgstamt')[$rw];
$itemamt = $this->input->post('itemamt')[$rw];
$itemnet = $this->input->post('itemnet')[$rw];



if($cpos==$statecode)
{
// Intra state
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$igstpc=0;
$igstamt=0;
$cgstpc = $itemgstpc/2;
$sgstpc = $itemgstpc/2;
$cgstamt = ($itemamt*$cgstpc)/100;
$sgstamt = ($itemamt*$sgstpc)/100;

}
else 
{
//Inter state
$igstpc=0;
$igstamt=0;    
$cgstpc=0;
$sgstpc=0;
$cgstamt=0;
$sgstamt=0;    
$results=array();
$igstpc = $itemgstpc;
$igstamt = ($itemamt*$igstpc)/100;
}

//$tax_tot=$tax_tot+$itemamt;
//$net_tot=$tax_tot+$itemnet;

$ins_sql[] = array("trans_link_id"=>$trans_link_id,"item_name"=>$itemname, "item_hsnsac"=>$itemhsn,"trans_id"=>$invno,"trans_date"=>$invdate,"trans_type"=>"SALE","item_id"=>$itemid,/*"item_name"=>$item_name,*/"item_stock"=>$itemstk,"item_unit"=>$itemuom,"item_qty"=>$itemqty,"item_rate"=>$itemrate,"item_amount"=>$itemamt,"item_mrp"=>$item_mrp,"item_gstpc"=>$itemgstpc,"item_dispc"=>$itemdispc,"item_disamount"=>$itemdis,"item_cgst"=>$cgstamt,"item_sgst"=>$sgstamt,"item_igst"=>$igstamt,"cgst_pc"=>$cgstpc,"sgst_pc"=>$sgstpc,"igst_pc"=>$igstpc,"taxable_amount"=>$itemamt,"nett_amount"=>$itemnet,"item_desc"=>$itemdesc,"company_id"=>$compId,"finyear"=>$finyear);

//$ins_sql = array($trans_link_id,$itemhsn,$invno,$invdate,$itemid,$itemuom,$itemqty,$itemrate,$itemamt,$itemgstpc,$itemdispc,$itemdis,$cgstamt,$sgstamt,$igstamt,$cgstpc,$sgstpc,$igstpc,$itemamt,$itemnet,$itemdesc,$compId);
//var_dump($ins_sql);

}

$each_data=array();
$url=$this->config->item("api_url") . "/api/insert_cndntransactionitems.php";

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);



foreach($ins_sql as $r) {
    //var_dump($r);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($r));
    $results = curl_exec($ch);
    curl_close($ch);



}
echo $results;

}





public function getLedgerGroup()
{
$url=$this->config->item("api_url") . "/api/getgroup.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($groupArray['group'] as $key => $value) {
$option .= '<option value="'.$value['id'].'">'.$value['group_name'].'</option>';

}
echo $option;

}


public function getProductUnitArr()
{
	$url=$this->config->item("api_url") . "/api/inventorylist/getunit";
	//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  //var_dump($response);
  curl_close($ch); // Close the connection
$uomArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
return $response;
}


public function getProductUnit()
{
$url=$this->config->item("api_url") . "/api/inventorylist/getunit";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$unitArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($unitArray as $key => $value) {
$option .= '<option value="'.$value['unit_id'].'">'.$value['unit_id'].'</option>';

}
echo $option;

}

public function getStates()
{
	$compId = $this->session->userdata('id');
	$finyear = $this->session->userdata('finyear');
	
	$url=$this->config->item("api_url") . "/api/productlist/statelist/" . $compId ;

//$url=$this->config->item("api_url") . "/api/state";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$stateArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($response);
$data=array();
$option="";
foreach ($stateArray as $key => $value) {
    if($value['state_name']=="Tamil Nadu")
    {
$option .= '<option selected  value="'.$value['statecode_id'].'">'.$value['state_name'].'</option>';
}
else
{
 $option .= '<option value="'.$value['statecode_id'].'">'.$value['state_name'].'</option>';   
}
}
echo $option;

}



public function getLedgerforUpdate()
{

$tbl="";    
$id = $this->input->get('id');

$url=$this->config->item("api_url") . "/api/ledger/" . $id;

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$ledgerArray = json_decode($response, true);
//var_dump($ledgerArray);

//$character = json_decode($data);
//print_r($response);
$url=$this->config->item("api_url") . "/api/group";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$groupArray = json_decode($response, true);



$url=$this->config->item("api_url") . "/api/state";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection
$stateArray = json_decode($response, true);


$data=array();
$option="";
/*foreach ($unitArray['units'] as $key => $value) {
$option .= '<option value="'.$value['unit_id'].'">'.$value['unit_name'].'</option>';

}*/

//print_r($prodArray["id"]);



//print_r($prodArray['name']);
$tbl .='<div class="card"><!--Card content--><div class="card-body px-lg-5 pt-0"><div class="form-row">
                <div class="col"><!-- First name --><div class="md-form"><input type="text" id="recid" name="recid" value="' . $ledgerArray["id"] . '" hidden ><label for="ledgername">LEDGER ACCOUNT NAME</label><input oninput="this.value = this.value.toUpperCase()" type="text" value="' . $ledgerArray["name"] . '" id="ledgername" name="ledgername" class="form-control" autocomplete="off" required></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgergstin">GSTIN NUMBER</label><input type="text" oninput="this.value = this.value.toUpperCase()"  id="ledgergstin" name="ledgergstin"  value="' . $ledgerArray["gstin"] . '"  class="form-control" autocomplete="off"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeraddress">ADDRESS</label><input type="text" oninput="this.value = this.value.toUpperCase()"  id="ledgeraddress"  value="' . $ledgerArray["address"] . '"  autocomplete="off" name="ledgeraddress" class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgergroup">GROUP</label><br>
                        <select id="ledgergroup" class="form-control" name="ledgergroup">';

foreach ($groupArray['group'] as $key => $value) {
  if($ledgerArray["groupid"]==$value["id"])
    {
$tbl .= '<option value="'.$value['id'].'" selected>'.$value['group_name'].'</option>';
}
else 
{
 $tbl .= '<option value="'.$value['id'].'">'.$value['group_name'].'</option>';   
}
}

                        $tbl .='</select></div></div></div><div class="form-row"><div class="col"><!-- First name --><div class="md-form"><label for="ledgercity">CITY</label><input type="text" id="ledgercity" oninput="this.value = this.value.toUpperCase()"   style="text-align: right;" autocomplete="off"  value="' . $ledgerArray["city"] . '" name="ledgercity" class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="Inventorytate">STATE</label><br><select id="Inventorytate" oninput="this.value = this.value.toUpperCase()"  style="width: 250px; height: 20px;" name="Inventorytate">';
foreach ($stateArray['state'] as $key => $value) {
  if($ledgerArray["statecode"]==$value["id"])
    {
$tbl .= '<option value="'.$value['statecode_id'].'" selected>'.$value['state_name'].'</option>';
}
else 
{
 $tbl .= '<option value="'.$value['statecode_id'].'">'.$value['state_name'].'</option>';   
}
}


                        $tbl .='</select></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgercontact">CONTACT#</label><input type="text"  style="text-align: right;"  id="ledgercontact" autocomplete="off"   name="ledgercontact" oninput="this.value = this.value.toUpperCase()" value="' . $ledgerArray["contact"] . '"   class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeremail">EMAIL</label><input type="email" id="ledgeremail"  value="' . $ledgerArray["email"] . '" name="ledgeremail" oninput="this.value = this.value.toUpperCase()"  style="text-align: right;"  autocomplete="off" class="form-control"></div></div></div><div class="form-row"><div class="col"><!-- First name --><div class="md-form"><label for="ledgerbustype">BUSINESS TYPE</label><select class="form-control" id="bus_type" name="bus_type"><option value="0">Regular</option>
                          <option value="1">Store</option>';


                          $tbl .= '</select></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgerpan">PAN#</label><input type="text" id="ledgerpan" oninput="this.value = this.value.toUpperCase()"  autocomplete="off" name="ledgerpan" value="' . $ledgerArray["pan"] . '"  class="form-control"></div></div><div class="col"><!-- Last name --><div class="md-form"><label for="ledgeropenbal">OPENING BALANCE</label><input style="text-align: right;" type="text"  value="' . $ledgerArray["openbal"] . '" id="ledgeropenbal" name="ledgeropenbal" autocomplete="off" value="0.00" class="form-control"></div></div></div><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>"></div></div>';




echo $tbl;

}

public function getLedger()
{
$url=$this->config->item("api_url") . "/api/getallInventory.php";
//$post = ['batch_id'=> "2"];
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection


//var_dump($response);

$phpArray = json_decode($response, true);
//$character = json_decode($data);
//print_r($phpArray);
$data=array();
foreach ($phpArray['data'] as $key => $value) {
    # code...

    //print_r($value['name']);
 $button ='<div class="btn-group">
  <button type="button" class="btn btn-info btn-circle btn-xs center-block" href="#" data-toggle="modal" data-target="#modalEditLedger" onclick="updateLedgerbyid(' . $value['id'] . ')"><i class="fa fa-edit"></i>
      </button>
&nbsp;
  <button type="button" data-target="#deleteModal" class="btn btn-danger btn-circle btn-xs center-block " 
 href="#" data-toggle="modal"  onclick="deleteUpdate(' . $value['id'] . ')"><i class="fa fa-times"></i>
      </button>

  
</div>'; 



$data['data'][]= array('name'=>$value['name'],'address'=>$value['address'],'gstin'=>$value['gstin'],'city'=>$value['city'],'statecode'=>$value['statecode'],'groupid'=>$value['groupid'],'contact'=>$value['contact'],'email'=>$value['email'],'pan'=>$value['pan'],'openbal'=>$value['openbal'],'action'=>$button);




}

echo json_encode($data);

}



public function editLedger()
{

$data_array=array();

       

if($this->input->post("recid")===null)
{
  $id = "";
}else{
  $id = $this->input->post("recid");
}


        if($this->input->post("ledgername")===null)
        { 
            $name="";
        }
        else
        {
        $name=$this->input->post("ledgername");

        }
        if($this->input->post("ledgeraddress")===null)
        {
        $address="";

        }
        else
        {
        $address=$this->input->post("ledgeraddress");

        }

        if($this->input->post("ledgergstin")===null)
        {
        $gstin="";            
        }
        else
        {
        $gstin=$this->input->post("ledgergstin");            
        }

        if($this->input->post("ledgercity")===null)
        {
        $city="";

        }
        else
        {
        $city=$this->input->post("ledgercity");            
        }

        if($this->input->post("Inventorytatecode")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytatecode");            
        }

        if($this->input->post("ledgergroupid")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroupid");            
        }

        if($this->input->post("ledgercontact")===null)
        {
        $contact="";

        }
        else
        {
        $contact=$this->input->post("ledgercontact");

        }

        if($this->input->post("ledgeremail")===null)
        {
        $email="";

        }
        else
        {
        $email=$this->input->post("ledgeremail");

        }

        if($this->input->post("ledgerpan")===null)
        {
        $pan="";

        }
        else
        {
        $pan=$this->input->post("ledgerpan");

        }

        if($this->input->post("ledgeropenbal")===null)
        {
        $openbal="";

        }
        else
        {
        $openbal=$this->input->post("ledgeropenbal");

        }

        if($this->input->post("Inventorytate")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytate");

        }


        if($this->input->post("ledgergroup")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroup");

        }

        if($this->input->post("bus_type")===null)
        {
        $bustype="";

        }
        else
        {
        $bustype=$this->input->post("bus_type");

        }

$data_array=array(
//        "id"=> $id,
        "account_name"=> $name,
        "account_address"=> $address,
        "account_gstin"=> $gstin,
        "account_city"=> $city,
        "account_statecode"=> $statecode,
        "account_groupid"=> $groupid,
        "account_contact"=> $contact,
        "account_email"=> $email,
        "account_pan"=> $pan,
        "account_groupid" =>$groupid,
        "bustype" =>$bustype,
        "account_statecode" =>$statecode,
        "account_openbal"=> $openbal);

//var_dump($data_array);
$url=$this->config->item("api_url") . "/api/ledger/" . $id;
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");  
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);


  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;


}



public function addLedger()
{
$data_array=array();



        if($this->input->post("ledgername")===null)
        { 
            $name="";
        }
        else
        {
        $name=$this->input->post("ledgername");

        }
        if($this->input->post("ledgeraddress")===null)
        {
        $address="";

        }
        else
        {
        $address=$this->input->post("ledgeraddress");

        }

        if($this->input->post("ledgergstin")===null)
        {
        $gstin="";            
        }
        else
        {
        $gstin=$this->input->post("ledgergstin");            
        }

        if($this->input->post("ledgercity")===null)
        {
        $city="";

        }
        else
        {
        $city=$this->input->post("ledgercity");            
        }

        if($this->input->post("Inventorytatecode")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytatecode");            
        }

        if($this->input->post("ledgergroupid")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroupid");            
        }

        if($this->input->post("ledgercontact")===null)
        {
        $contact="";

        }
        else
        {
        $contact=$this->input->post("ledgercontact");

        }

        if($this->input->post("ledgeremail")===null)
        {
        $email="";

        }
        else
        {
        $email=$this->input->post("ledgeremail");

        }

        if($this->input->post("ledgerpan")===null)
        {
        $pan="";

        }
        else
        {
        $pan=$this->input->post("ledgerpan");

        }

        if($this->input->post("ledgeropenbal")===null)
        {
        $openbal="";

        }
        else
        {
        $openbal=$this->input->post("ledgeropenbal");

        }

        if($this->input->post("Inventorytate")===null)
        {
        $statecode="";

        }
        else
        {
        $statecode=$this->input->post("Inventorytate");

        }


        if($this->input->post("ledgergroup")===null)
        {
        $groupid="";

        }
        else
        {
        $groupid=$this->input->post("ledgergroup");

        }

        if($this->input->post("bus_type")===null)
        {
        $bustype="";

        }
        else
        {
        $bustype=$this->input->post("bus_type");

        }


$url=$this->config->item("api_url") . "/api/ledger";

$data_array=array(
        "account_name"=> $name,
        "account_address"=> $address,
        "account_gstin"=> $gstin,
        "account_city"=> $city,
        "account_statecode"=> $statecode,
        "account_groupid"=> $groupid,
        "account_contact"=> $contact,
        "account_email"=> $email,
        "account_pan"=> $pan,
        "account_groupid" =>$groupid,
        "bustype" =>$bustype,
        "account_statecode" =>$statecode,
        "account_openbal"=> $openbal);


  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);
  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;
//print_r($data);
}

public function deleteLedger()
{
$data_array=array();
$id=$this->input->get("id");
$data_array=array("id"=>$id);
$url=$this->config->item("api_url") . "/api/ledger/" . $id;
 $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_array));
  $response = curl_exec($ch);
  //$result = json_decode($response);


  curl_close($ch); // Close the connection

//$res = json_decode($response, true);
echo $response;

//$this->callAPI('DELETE', 'https://apigstsoft.jvait.in/api/Ledger_delete.php', $id);
}



public function view_mpdf()
{
	require '../vendor/autoload.php';
//	require __DIR__.'../../vendor.autoload.php';	
//require_once __DIR__ . '../vendor/autoload.php';	
$mpdf = new \Mpdf\Mpdf();
$mpdf = new mPDF(['autoPageBreak' => true,
'format' => 'A4',
'default_font_size' => 0,
'default_font' => '',
'margin_left' => 10,
'margin_right' => 10,
'margin_top' => 105,
'margin_bottom' => 18,
'margin_header' => 9,
'margin_footer' => 9,
'orientation' => 'P',

]);
$mpdf->curlAllowUnsafeSslRequests = true;


$html = $this->view('pdf',[],true);
	$mpdf->WriteHTML($html);
	$mpdf->Output();
}


}

