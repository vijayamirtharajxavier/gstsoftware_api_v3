<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Data_model extends CI_Model {


public function getSalesPurchaseData($cid=null,$transtype=null,$finyear=null)
{
	   if(!empty($transtype)){
	$sql="SELECT t.id, t.trans_id,t.trans_date,t.order_date,t.order_no,t.dc_no,t.dc_date,t.trans_type,t.db_account,t.cr_account,t.statecode,t.gstin,t.inv_type,t.rcm,t.net_amount,t.trans_amount,t.trans_reference,t.trans_narration,t.salebyperson,t.finyear,l.account_name`custname` FROM transaction_tbl t,ledgermaster_tbl l where  t.db_account=l.id and t.trans_type=? AND t.finyear=? and t.company_id=? GROUP BY t.id order by t.trans_date desc, t.id desc";

$query = $this->db->query($sql, array($transtype,$finyear,$cid));
    return $query->result_array();

}
    

}


public function getSalesPurchaseReg($transtype=null,$finyear=null,$cid=null,$fdate=null,$tdate=null)
{
    //var_dump($transtype . $finyear . $cid . $fdate . $tdate);
       if(!empty($transtype)){
    $sql="SELECT t.id, t.trans_id,t.trans_date,t.order_date,t.order_no,t.dc_no,t.dc_date,t.trans_type,t.db_account,t.cr_account,t.statecode,t.gstin,t.inv_type,t.rcm,t.net_amount,t.trans_amount,t.trans_reference,t.trans_narration,t.salebyperson,t.finyear,l.account_name`custname` FROM transaction_tbl t,ledgermaster_tbl l where  t.db_account=l.id and t.trans_type=? AND t.finyear=? AND t.company_id=? AND t.trans_date>=? AND t.trans_date<=?  GROUP BY t.id order by t.trans_date desc, t.id desc";

$query = $this->db->query($sql, array($transtype,$finyear,$cid,$fdate,$tdate));
    return $query->result_array();

}
    

}

public function gstcdnrGroup($fdate,$tdate,$cid)
{
$sql="SELECT gstin from transaction_tbl where  (trans_type='SRTN' or trans_type='PRTN') AND trans_date>=? and trans_date<=? and company_id=? and gstin<>'' group by gstin order by gstin";
$query = $this->db->query($sql, array($fdate,$tdate,$cid));
return $query->result_array();

}

public function gstGroup($fdate,$tdate,$cid)
{
$sql="SELECT gstin from transaction_tbl where  trans_type='SALE' AND trans_date>=? and trans_date<=? and company_id=? and gstin<>'' group by gstin order by gstin";
$query = $this->db->query($sql, array($fdate,$tdate,$cid));
return $query->result_array();

}

public function get_b2bTransbyInv($fdate,$tdate,$cid,$gstin,$invno)
{

$sql = "SELECT t.trans_id, t.gstin,t.statecode `pos`,t.rcm,t.trans_date,itm.item_gstpc `gst_pc`,ROUND(sum(itm.cgst_amount),2) item_cgst,ROUND(sum(itm.sgst_amount),2) item_sgst,ROUND(sum(itm.igst_amount),2) item_igst,ROUND(sum(itm.cess_amount),2) item_cess,ROUND(sum(itm.taxable_amount),2) taxable_amt,ROUND(sum(itm.nett_amount),2) `net_amt` FROM `itemtransaction_tbl` itm, transaction_tbl t WHERE  t.trans_type='SALE' AND itm.delflag=0 AND itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? and t.gstin=? and itm.trans_id=t.trans_id and  t.trans_id=? GROUP by itm.item_gstpc order by itm.trans_link_id";
$query = $this->db->query($sql, array($fdate,$tdate,$cid,$gstin,$invno));
return $query->result_array();

}


public function get_cdnrTransbyInv($fdate,$tdate,$cid,$gstin,$invno)
{

$sql = "SELECT t.trans_id, t.gstin,t.trans_type,t.statecode `pos`,t.rcm,t.trans_date,itm.item_gstpc `gst_pc`,ROUND(sum(itm.cgst_amount),2) item_cgst,ROUND(sum(itm.sgst_amount),2) item_sgst,ROUND(sum(itm.igst_amount),2) item_igst,ROUND(sum(itm.cess_amount),2) item_cess,ROUND(sum(itm.taxable_amount),2) taxable_amt,ROUND(sum(itm.nett_amount),2) `net_amt` FROM `itemtransaction_tbl` itm, transaction_tbl t WHERE  (t.trans_type='SRTN' or t.trans_type='PRTN') AND itm.delflag=0 AND itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? and t.gstin=? and itm.trans_id=t.trans_id and  t.trans_id=? GROUP by itm.item_gstpc order by itm.trans_link_id";
$query = $this->db->query($sql, array($fdate,$tdate,$cid,$gstin,$invno));
return $query->result_array();

}


public function get_b2bTransbyInvSum($fdate,$tdate,$cid,$gstin,$invno)
{
    $sql = "SELECT ROUND(sum(itm.nett_amount),2) inv_amt FROM `itemtransaction_tbl` itm, transaction_tbl t WHERE  t.trans_type='SALE' AND itm.delflag=0 AND itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? and t.gstin=? and itm.trans_id=t.trans_id and  t.trans_id=?";
$query = $this->db->query($sql, array($fdate,$tdate,$cid,$gstin,$invno));
return $query->result_array();

}

public function get_cdnrTransbyInvSum($fdate,$tdate,$cid,$gstin,$invno)
{
    $sql = "SELECT ROUND(sum(itm.nett_amount),2) inv_amt FROM `itemtransaction_tbl` itm, transaction_tbl t WHERE  (t.trans_type='SRTN' or t.trans_type='PRTN') AND itm.delflag=0 AND itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? and t.gstin=? and itm.trans_id=t.trans_id and  t.trans_id=?";
$query = $this->db->query($sql, array($fdate,$tdate,$cid,$gstin,$invno));
return $query->result_array();

}


public function get_b2bTransbyGstin($fdate,$tdate,$cid,$gstin)
{
    $sql="SELECT * from transaction_tbl  where trans_type='SALE' AND trans_date>=? and trans_date<=? and company_id=? and gstin=?  order by id asc";
$query = $this->db->query($sql, array($fdate,$tdate,$cid,$gstin));
    return $query->result_array();

}



public function get_cdnrTransbyGstin($fdate,$tdate,$cid,$gstin)
{
    $sql="SELECT * from transaction_tbl  where (trans_type='SRTN' or trans_type='PRTN')  AND trans_date>=? and trans_date<=? and company_id=? and gstin=?  order by id asc";
$query = $this->db->query($sql, array($fdate,$tdate,$cid,$gstin));
    return $query->result_array();

}


public function getB2C($fdate,$tdate,$cid)
{


$sql = "SELECT t.gstin,t.statecode `pos`,t.rcm,itm.item_gstpc `gst_pc`,sum(itm.cgst_amount) item_cgst,sum(itm.sgst_amount) item_sgst,sum(itm.igst_amount) item_igst,sum(itm.cess_amount) item_cess,sum(itm.taxable_amount) taxable_amt,sum(itm.nett_amount) `net_amt` FROM `itemtransaction_tbl` itm, transaction_tbl t WHERE  t.trans_type='SALE' AND itm.delflag=0 AND itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? and t.gstin='' and itm.trans_id=t.trans_id  GROUP by t.statecode,itm.item_gstpc";
$query = $this->db->query($sql, array($fdate,$tdate,$cid));
return $query->result_array();


}


public function getCompanyDetails($cid=null)
{
$sql = "SELECT *  FROM company_tbl WHERE  id=?";
$query = $this->db->query($sql, array($cid));
return $query->result_array();
}


public function getGstr1hsn($fdate,$tdate,$cid,$trans_type)
{
$sql="SELECT item_hsnsac,item_unit,sum(item_qty)`item_qty`,sum(taxable_amount)`taxable_amount`,item_gstpc,sum(igst_amount)`igst_amount`,sum(cgst_amount)`cgst_amount`,sum(sgst_amount)`sgst_amount`,sum(cess_amount)`cess_amount` FROM `itemtransaction_tbl` WHERE company_id=? and trans_date>=? AND trans_date<=? AND trans_type=? and company_id=? AND delflag=0 GROUP BY item_hsnsac ORDER BY item_hsnsac";
$query = $this->db->query($sql, array($cid,$fdate,$tdate,$trans_type,$cid));
    return $query->result_array();
}

public function getGstr1cdnr($fdate,$tdate,$cid)
{
$sql="SELECT l.account_name, itm.trans_id,itm.trans_date,t.gstin,t.trans_type,itm.item_gstpc, round(sum(itm.taxable_amount),2)`txb_amt`,round(sum(itm.nett_amount),2)`net_amt`,round(sum(itm.igst_amount),2)`igst`,round(sum(itm.sgst_amount),2)`sgst`,round(sum(itm.cgst_amount),2)`cgst` FROM `itemtransaction_tbl` itm,transaction_tbl t,ledgermaster_tbl l WHERE t.db_account=l.id AND itm.delflag=0 AND (itm.trans_type='SRTN' or itm.trans_type='PRTN')  AND t.id=itm.trans_link_id and t.gstin<>'' and itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? group by itm.trans_id,itm.item_gstpc ORDER BY itm.trans_id,t.gstin";
$query = $this->db->query($sql, array($fdate,$tdate,$cid));
    return $query->result_array();
}


public function getGstr9b2b($yr,$cid)
{
//$sql="SELECT l.account_name, itm.trans_id,itm.trans_date,t.gstin,itm.item_gstpc, round(sum(itm.taxable_amount),2)`txb_amt`,round(sum(itm.nett_amount),2)`net_amt`,round(sum(itm.igst_amount),2)`igst`,round(sum(itm.sgst_amount),2)`sgst`,round(sum(itm.cgst_amount),2)`cgst` FROM `itemtransaction_tbl` itm,transaction_tbl t,ledgermaster_tbl l WHERE t.db_account=l.id AND itm.delflag=0 AND itm.trans_type='SALE' AND t.id=itm.trans_link_id and t.gstin<>'' and t.finyear=? and itm.company_id=? group by itm.trans_id,itm.item_gstpc ORDER BY itm.trans_id,t.gstin";
$sql="SELECT round(sum(itm.taxable_amount),2)`txb_amt`,round(sum(itm.nett_amount),2)`net_amt`,round(sum(itm.igst_amount),2)`igst`,round(sum(itm.sgst_amount),2)`sgst`,round(sum(itm.cgst_amount),2)`cgst`,round(sum(itm.cess_amount),2)`cess` FROM `itemtransaction_tbl` itm,transaction_tbl t,ledgermaster_tbl l WHERE t.db_account=l.id AND itm.delflag=0 AND itm.trans_type='SALE' AND t.id=itm.trans_link_id and t.gstin<>'' and t.finyear=? and itm.company_id=?";
$query = $this->db->query($sql, array($yr,$cid));
//$this->output->enable_profiler(TRUE); 

    return $query->result_array();
}

public function getGstr1b2b($fdate,$tdate,$cid)
{
$sql="SELECT l.account_name, itm.trans_id,itm.trans_date,t.gstin,itm.item_gstpc, round(sum(itm.taxable_amount),2)`txb_amt`,round(sum(itm.nett_amount),2)`net_amt`,round(sum(itm.igst_amount),2)`igst`,round(sum(itm.sgst_amount),2)`sgst`,round(sum(itm.cgst_amount),2)`cgst` FROM `itemtransaction_tbl` itm,transaction_tbl t,ledgermaster_tbl l WHERE t.db_account=l.id AND itm.delflag=0 AND itm.trans_type='SALE' AND t.id=itm.trans_link_id and t.gstin<>'' and itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? group by itm.trans_id,itm.item_gstpc ORDER BY itm.trans_id,t.gstin";
$query = $this->db->query($sql, array($fdate,$tdate,$cid));
//$this->output->enable_profiler(TRUE); 

    return $query->result_array();
}

public function getGstr1b2c($fdate,$tdate,$cid)
{
$sql="SELECT l.account_name, t.statecode, itm.trans_id,itm.trans_date,t.gstin,itm.item_gstpc, round(sum(itm.taxable_amount),2)`txb_amt`,round(sum(itm.nett_amount),2)`net_amt`,round(sum(itm.igst_amount),2)`igst`,round(sum(itm.sgst_amount),2)`sgst`,round(sum(itm.cgst_amount),2)`cgst` FROM `itemtransaction_tbl` itm,transaction_tbl t,ledgermaster_tbl l WHERE t.db_account=l.id AND itm.delflag=0 AND itm.trans_type='SALE' AND t.id=itm.trans_link_id and t.gstin='' and itm.trans_date>=? and itm.trans_date<=? and itm.company_id=? group by itm.trans_id,itm.item_gstpc ORDER BY itm.trans_id,t.gstin";
$query = $this->db->query($sql, array($fdate,$tdate,$cid));
    return $query->result_array();
}

public function get_gstr32bData($fdate,$tdate,$cstatecode,$cid)
{
    $sql="SELECT CONCAT(t.statecode,' - ',st.state_name)`statename`,sum(itm.taxable_amount)`txb_amt`,sum(itm.igst_amount)`igst_amt` FROM `itemtransaction_tbl` itm,transaction_tbl t,gststate_tbl st WHERE itm.delflag=0 and t.gstin='' and t.id=itm.trans_link_id and st.statecode_id=t.statecode and itm.trans_date>=? and itm.trans_type='SALE' and itm.trans_date<=? and t.statecode<>?  and t.company_id=? GROUP BY t.statecode";

$query = $this->db->query($sql, array($fdate,$tdate,$cstatecode,$cid));
    return $query->result_array();

}


public function get_gstr2bData($trans_type,$fdate,$tdate,$cid)
{
    $sql="SELECT t.gstin,l.account_name,t.trans_id,t.inv_type,t.trans_date,SUM(it.nett_amount)`invval`,t.statecode,t.rcm,SUM(it.taxable_amount) `txblval`,it.item_gstpc,sum(igst_amount)`igstval`,sum(cgst_amount)`cgstval`,sum(sgst_amount)`sgstval`,sum(cess_amount)`cessval` FROM `transaction_tbl` t,ledgermaster_tbl l,itemtransaction_tbl it WHERE t.id=it.trans_link_id AND t.db_account=l.id and  t.trans_type=? AND t.company_id=1 and t.trans_date>=? and t.trans_date<=? AND it.delflag=0 and t.company_id=? GROUP BY it.trans_link_id, it.item_gstpc ORDER BY t.trans_date";

$query = $this->db->query($sql, array($trans_type,$fdate,$tdate,$cid));
    return $query->result_array();
}


public function get_gstr3bData($trans_type,$fdate,$tdate,$cid)
{
/*$sql="SELECT SUM(CASE WHEN it.item_gstpc=0 and t.statecode=c.company_statecode THEN taxable_amount END) `intra_zero`,SUM(CASE WHEN it.item_gstpc=0 and t.statecode<>c.company_statecode THEN taxable_amount END) `inter_zero` FROM itemtransaction_tbl it,transaction_tbl t,company_tbl c WHERE it.delflag=0 and it.trans_type=? and it.trans_date>=? and it.trans_date<=? and it.company_id=? and it.trans_link_id=t.id and it.company_id=c.id";
*/

$sql="SELECT SUM(CASE WHEN  t.inv_type<>'DE' and  it.item_gstpc=0 THEN it.taxable_amount END) `zerogst`,SUM(CASE WHEN t.inv_type='DE' THEN it.taxable_amount END) `zerorate`,SUM(CASE WHEN t.inv_type<>'DE' and   it.item_gstpc<>0 THEN it.taxable_amount END) `txbgst`,SUM(CASE WHEN  t.inv_type<>'DE' and  it.item_gstpc<>0 THEN it.igst_amount END) `txbigst`,SUM(CASE WHEN t.inv_type<>'DE' and  it.item_gstpc<>0 THEN it.cgst_amount END) `txbcgst`,SUM(CASE WHEN  t.inv_type<>'DE' and  it.item_gstpc<>0 THEN it.sgst_amount END) `txbsgst` FROM itemtransaction_tbl it, transaction_tbl t WHERE it.trans_link_id=t.id and  it.delflag=0 and it.trans_type=? and it.trans_date>=? and it.trans_date<=? and it.company_id=?";

$query = $this->db->query($sql, array($trans_type,$fdate,$tdate,$cid));
    return $query->result_array();
}


public function get_gstr3b5Data($trans_type,$fdate,$tdate,$cid)
{

$sql="SELECT SUM(CASE WHEN it.item_gstpc=0 and t.statecode=c.company_statecode THEN it.taxable_amount END) `intra_zero`,SUM(CASE WHEN it.item_gstpc=0 and t.statecode<>c.company_statecode THEN it.taxable_amount END) `inter_zero` FROM itemtransaction_tbl it,transaction_tbl t,company_tbl c WHERE it.delflag=0 and it.trans_type=? and it.trans_date>=? and it.trans_date<=? and it.company_id=? and it.trans_link_id=t.id and it.company_id=c.id";

/*$sql="SELECT SUM(CASE WHEN item_gstpc=0 THEN taxable_amount END) `zerogst`,SUM(CASE WHEN item_gstpc<>0 THEN taxable_amount END) `txbgst`,SUM(CASE WHEN item_gstpc<>0 THEN igst_amount END) `txbigst`,SUM(CASE WHEN item_gstpc<>0 THEN cgst_amount END) `txbcgst`,SUM(CASE WHEN item_gstpc<>0 THEN sgst_amount END) `txbsgst` FROM itemtransaction_tbl WHERE delflag=0 and trans_type=? and trans_date>=? and trans_date<=? and company_id=?";
*/
$query = $this->db->query($sql, array($trans_type,$fdate,$tdate,$cid));
    return $query->result_array();


}





public function clientwisemsalesdata($cid,$finyear,$trans_type,$acct_id)
{
    $sql="SELECT t.db_account, l.account_name, SUM(case WHEN month(itm.trans_date)='04' THEN itm.taxable_amount ELSE '' END)`apr`,SUM(case WHEN month(itm.trans_date)='05' THEN itm.taxable_amount ELSE '' END)`may`,SUM(case WHEN month(itm.trans_date)='06' THEN itm.taxable_amount ELSE '' END)`jun`,SUM(case WHEN month(itm.trans_date)='07' THEN itm.taxable_amount ELSE '' END)`jul`,SUM(case WHEN month(itm.trans_date)='08' THEN itm.taxable_amount ELSE '' END)`aug`,SUM(case WHEN month(itm.trans_date)='09' THEN itm.taxable_amount ELSE '' END)`sep`,SUM(case WHEN month(itm.trans_date)='10' THEN itm.taxable_amount ELSE '' END)`oct`,SUM(case WHEN month(itm.trans_date)='11' THEN itm.taxable_amount ELSE '' END)`nov`,SUM(case WHEN month(itm.trans_date)='12' THEN itm.taxable_amount ELSE '' END)`dec`,SUM(case WHEN month(itm.trans_date)='01' THEN itm.taxable_amount ELSE '' END)`jan`,SUM(case WHEN month(itm.trans_date)='02' THEN itm.taxable_amount ELSE '' END)`feb`,SUM(case WHEN month(itm.trans_date)='03' THEN itm.taxable_amount ELSE '' END)`mar`,SUM(case WHEN t.db_account=$acct_id THEN (itm.igst_amount+itm.cgst_amount+itm.sgst_amount) ELSE '0' END)`gst` FROM itemtransaction_tbl itm,transaction_tbl t,ledgermaster_tbl l WHERE itm.trans_link_id=t.id and t.db_account=l.id and itm.delflag=0 AND itm.company_id=? AND itm.finyear=?  and t.db_account=?";
 	$query=$this->db->query($sql,array($cid,$finyear,$acct_id));
 	return $query->result_array();

}


public function getsptransaction($cid,$finyear,$start_date,$end_date,$trans_type)
{
       if(!empty($transtype)){
    $sql="SELECT t.id, t.trans_id,t.trans_date,t.order_date,t.order_no,t.dc_no,t.dc_date,t.trans_type,t.db_account,t.cr_account,t.statecode,t.gstin,t.inv_type,t.rcm,t.net_amount,t.trans_amount,t.net_amount-t.trans_amount `gst_amount`, t.trans_reference,t.trans_narration,t.salebyperson,t.finyear,l.account_name`custname` FROM transaction_tbl t,ledgermaster_tbl l where  t.db_account=l.id and t.trans_type=? AND  t.finyear=? AND t.company_id=? AND t.trans_date>=? and t.trans_date<=? GROUP BY t.id order by t.trans_date, t.id asc";

$query = $this->db->query($sql, array($transtype,$finyear,$cid,$start_date,$end_date));
    return $query->result_array();
}

}




public function getCBTrans($cid,$finyear,$acct_id,$alcode)
{

 if($alcode==1)
 {   

$sql_os ="SELECT SUM(CASE WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . "  ) THEN t.trans_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . "  ) THEN t.trans_amount WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=? and t.delflag=0";

  $query=$this->db->query($sql_os,array($finyear,$cid));
  return $query->result_array();

/*
$sql_os = "SELECT SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . " ) THEN t.trans_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . " ) THEN t.trans_amount  WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=?  and t.delflag=0"; */
}
}


public function Transbyacctid($cid=null,$finyear=null,$acct_id=null)
{

    $sql_os = "SELECT SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount  WHEN t.trans_type='PRTN' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . " ) THEN t.net_amount  WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.net_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='SRTN' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . " ) THEN t.net_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.net_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=? and (t.db_account=? or t.cr_account=?)  and t.delflag=0";
    $query=$this->db->query($sql_os,array($finyear,$cid,$acct_id,$acct_id));
    return $query->result_array();
    
}



public function getTransbyacctid($cid=null,$finyear=null,$acct_id=null,$group_id=null,$cbcode=null,$gtrans_type=null)
{
if($gtrans_type=="CSBK")
{
    $sql="SELECT SUM(CASE WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . "  ) THEN t.net_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.net_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . "  ) THEN t.net_amount WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.net_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=? and t.delflag=0";
    $query=$this->db->query($sql,array($finyear,$cid));
    return $query->result_array();

}

if($gtrans_type=="SALE")
{
    $sql="SELECT SUM(CASE WHEN  t.trans_type='SALE' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.net_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=? and t.delflag=0";
    $query=$this->db->query($sql,array($finyear,$cid));
    return $query->result_array();

}

if($gtrans_type=="PURC")
{
    $sql="SELECT SUM(CASE WHEN  t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.net_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=? and t.delflag=0";
    $query=$this->db->query($sql,array($finyear,$cid));
    return $query->result_array();

}

if($gtrans_type=="")
{
    $sql_os = "SELECT SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount  WHEN t.trans_type='PRTN' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . " ) THEN t.net_amount  WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.net_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='SRTN' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . " ) THEN t.net_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.net_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=?  and t.delflag=0";
    $query=$this->db->query($sql_os,array($finyear,$cid));
    return $query->result_array();
    
}


}


public function getTrans($cid,$finyear,$acct_id,$gcode,$cbcode)
{

 if($gcode==1 && $cbcode==1)
 {   

$sql_os ="SELECT SUM(CASE WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . "  ) THEN t.trans_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . "  ) THEN t.trans_amount WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=? and t.delflag=0";
$query=$this->db->query($sql_os,array($finyear,$cid));
return $query->result_array();

/*

$sql_os = "SELECT SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . " ) THEN t.trans_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . " ) THEN t.trans_amount  WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=?  and t.delflag=0"; */

}
elseif ($gcode==1 && $cbcode==0) {


$sql_os ="SELECT SUM(CASE WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . "  ) THEN t.trans_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . "  ) THEN t.trans_amount WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . "  ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=? and t.delflag=0";    
    # code...
    $query=$this->db->query($sql_os,array($finyear,$cid));
    return $query->result_array();

}



elseif($gcode<>1) {
/*
$sql_os = "SELECT SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=?  and t.delflag=0";
*/

$sql_os = "SELECT SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount  WHEN t.trans_type='PRTN' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount WHEN t.trans_type='CNTR' AND (t.cr_account=" . $acct_id . " ) THEN t.trans_amount  WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='SRTN' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount  WHEN t.trans_type='CNTR' AND (t.db_account=" . $acct_id . " ) THEN t.trans_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=?  and t.delflag=0";
$query=$this->db->query($sql_os,array($finyear,$cid));
return $query->result_array();

}

/*
$sql_os = "SELECT (CASE WHEN  l.ldger_id=".$acct_id." THEN l.open_bal ELSE 0 END) + SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t, openingbalance_tbl l WHERE  l.ldger_id=" . $acct_id . " AND t.finyear=? and t.company_id=?  and l.delflag=0 and t.delflag=0";
*/

 //   $query=$this->db->query($sql_os,array($finyear,$cid));



}



public function clientwisemsalesdataos($acct_id,$finyear,$cid)
{
$sql_os = "SELECT (CASE WHEN  l.ldger_id=".$acct_id." THEN l.open_bal ELSE 0 END) + SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=" . $acct_id . " or t.cr_account=" . $acct_id . " )  THEN net_amount WHEN t.trans_type='PYMT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " )  THEN t.net_amount WHEN t.trans_type='RCPT' AND (t.db_account=" . $acct_id . "  or t.cr_account=" . $acct_id . " ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t, openingbalance_tbl l WHERE  l.ldger_id=" . $acct_id . " AND t.finyear=? and t.company_id=?  and l.delflag=0 and t.delflag=0";
 	$query=$this->db->query($sql_os,array($finyear,$cid));
 	return $query->result_array();



}


public function clientwisemsalescode($cid,$finyear,$transtype)
{
$sql="SELECT db_account FROM transaction_tbl WHERE trans_type=? AND finyear=? and company_id=? group by db_account order by db_account";
 	$query=$this->db->query($sql,array($transtype,$finyear,$cid));
 	return $query->result_array();

}





public function getcbOp($cid,$finyear,$fdate,$actid)
{
    $opQuery="SELECT (SUM(CASE WHEN (t.db_account=? and t.trans_type='RCPT') or (t.db_account=? and t.trans_type='CNTR') THEN t.trans_amount ELSE '0' END)) - (SUM(CASE WHEN (t.db_account=? and t.trans_type='PYMT') or (t.cr_account=? and t.trans_type='CNTR')  THEN t.trans_amount ELSE '0' END)) `opbal` FROM transaction_tbl t,ledgermaster_tbl l WHERE t.delflag=0 and t.company_id=? and t.finyear=? and t.trans_date<? and (t.db_account=? or t.cr_account=?) and t.db_account=l.id";

$query = $this->db->query($opQuery, array($actid,$actid,$actid,$actid,$cid,$finyear,$fdate,$actid,$actid));
//$this->output->enable_profiler(TRUE); 
return $query->result_array();

}


//$gldata_op = $this->data_model->getglop($cid,$finyear,$sdate,$start_date,$actid);
public function getglop($cid,$finyear,$fdate,$actid)
{
$opQuery ="SELECT (SUM(CASE WHEN t.trans_type='SALE' THEN t.net_amount ELSE '0' END) + SUM(CASE WHEN t.trans_type='PYMT' THEN t.trans_amount ELSE '0' END)) - (SUM(CASE WHEN t.trans_type='PURC' THEN t.net_amount ELSE '0' END)+SUM(CASE WHEN t.trans_type='RCPT' THEN t.trans_amount ELSE '0' END)) `opbal` FROM transaction_tbl t,ledgermaster_tbl l WHERE t.delflag=0 and t.company_id=? and t.finyear=? and t.trans_date<? and (t.db_account=? or t.cr_account=?) and t.db_account=l.id";

$query = $this->db->query($opQuery, array($cid,$finyear,$fdate,$actid,$actid));
//$this->output->enable_profiler(TRUE); 
return $query->result_array();

}

public function getgltransaction($cid,$finyear,$fdate,$tdate,$actid)
{
$sql ="SELECT * FROM transaction_tbl t WHERE t.delflag=0 and t.company_id=? and t.finyear=? and t.trans_date>=? and t.trans_date<=? and (t.db_account=? or t.cr_account=?) order by t.trans_date asc";
$query = $this->db->query($sql, array($cid,$finyear,$fdate,$tdate,$actid,$actid));
return $query->result_array();

}

public function getTransbyid($cid,$finyear,$id)
{
    $sql ="SELECT * FROM transaction_tbl t WHERE t.delflag=0 and t.company_id=? and t.finyear=? and t.id=?";
    $query = $this->db->query($sql, array($cid,$finyear,$id));
    return $query->result_array();
    
}


public function getSumSP($trid=null)
{
	$sql="SELECT count(trans_link_id)`noi`,sum(taxable_amount) `txb_amt`, sum(nett_amount)`net_amt` FROM itemtransaction_tbl where delflag=0 and trans_link_id=?";
$query = $this->db->query($sql, array($trid));
return $query->result_array();

}





public function getcmtData($cid=null,$finyear=null,$trans_type=null,$start_date=null,$end_date=null)
{

$sql = "SELECT sum(taxable_amount) taxable_tot,sum(igst_amount)+sum(cgst_amount)+sum(sgst_amount) gst_tot, sum(nett_amount) netamount_tot FROM itemtransaction_tbl  WHERE delflag=0 and finyear=? and company_id=? and trans_type=? and trans_date>=? and trans_date<=?";


$query = $this->db->query($sql,array($finyear,$cid,$trans_type,$start_date,$end_date));
return $query->result_array();

}

public function updateTrans()
{
 $upd_sql = "UPDATE transaction_tbl
                    SET
                        
                        trans_date = :trans_date, 
                        order_no = :order_no, 
                        order_date = :order_date, 
                        dc_no = :dc_no,
                        dc_date = :dc_date, 
                        trans_type = :trans_type,
                        db_account = :db_account,
                        cr_account = :cr_account,
                        statecode = :statecode,
                        gstin = :gstin,
                        inv_type=:invtype,
                        salebyperson = :salebyperson,
                        trans_amount =:trans_amount,
                        net_amount =:net_amount
                         WHERE 
                        id =:id";



}


public function setdelflagopbal($cid=null,$finyear=null)
{

  $upd = array('delflag' =>"1");
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('openingbalance_tbl',$upd);


}


public function getmonwisegstData($cid=null,$finyear=null,$trans_type=null)
{
    $sql="SELECT SUM(case WHEN month(trans_date)='04' THEN (igst_amount+cgst_amount+sgst_amount) ELSE 0 END)`apr`,SUM(case WHEN month(trans_date)='05' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`may`,SUM(case WHEN month(trans_date)='06' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`jun`,SUM(case WHEN month(trans_date)='07' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`jul`,SUM(case WHEN month(trans_date)='08' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`aug`,SUM(case WHEN month(trans_date)='09' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`sep`,SUM(case WHEN month(trans_date)='10' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`oct`,SUM(case WHEN month(trans_date)='11' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`nov`,SUM(case WHEN month(trans_date)='12' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`dec`,SUM(case WHEN month(trans_date)='01' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`jan`,SUM(case WHEN month(trans_date)='02' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`feb`,SUM(case WHEN month(trans_date)='03' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`mar` FROM itemtransaction_tbl WHERE delflag=0 AND company_id=? AND finyear=? AND trans_type=?";


$query = $this->db->query($sql,array($cid,$finyear,$trans_type));
return $query->result_array();
}


public function getTaxesDatabyid($cid,$invno)
{
//    $taxdata=array();
 $sql="SELECT item_gstpc,sum(taxable_amount) AS `taxable_amount`, sum(cgst_amount) AS `item_cgst`,sum(sgst_amount) AS `item_sgst`,sum(igst_amount) AS `item_igst` FROM itemtransaction_tbl   WHERE delflag=0 and trans_link_id=? and company_id=? GROUP by item_gstpc";
$query = $this->db->query($sql,array($invno,$cid));
return $query->result_array();

}

public function getmonwiseData($cid=null,$finyear=null,$trans_type=null)
{
    $sql="SELECT SUM(case WHEN month(trans_date)='04' THEN taxable_amount ELSE 0 END)`apr`,SUM(case WHEN month(trans_date)='05' THEN taxable_amount ELSE 0 END)`may`,SUM(case WHEN month(trans_date)='06' THEN taxable_amount ELSE 0 END)`jun`,SUM(case WHEN month(trans_date)='07' THEN taxable_amount ELSE 0 END)`jul`,SUM(case WHEN month(trans_date)='08' THEN taxable_amount ELSE 0 END)`aug`,SUM(case WHEN month(trans_date)='09' THEN taxable_amount ELSE 0 END)`sep`,SUM(case WHEN month(trans_date)='10' THEN taxable_amount ELSE 0 END)`oct`,SUM(case WHEN month(trans_date)='11' THEN taxable_amount ELSE 0 END)`nov`,SUM(case WHEN month(trans_date)='12' THEN taxable_amount ELSE 0 END)`dec`,SUM(case WHEN month(trans_date)='01' THEN taxable_amount ELSE 0 END)`jan`,SUM(case WHEN month(trans_date)='02' THEN taxable_amount ELSE 0 END)`feb`,SUM(case WHEN month(trans_date)='03' THEN taxable_amount ELSE 0 END)`mar` FROM itemtransaction_tbl WHERE delflag=0 AND company_id=? AND finyear=? AND trans_type=?";

$query = $this->db->query($sql,array($cid,$finyear,$trans_type));
return $query->result_array();


}

public function getItemtransbyitemid()
{
    $sql="SELECT * FROM `itemtransaction_tbl` WHERE company_id=? and item_id=? and delflag=0";
    $query = $this->db->query($sql,array($cid,$itemid));
    return $query->result_array();
}



public function getSalesPurchaseDatabyId($id=null,$trans_type=null,$cid=nul,$finyear=null)
{
	   if(!empty($id)){
	$sql="SELECT t.id, t.trans_id,t.trans_date,t.order_date,t.order_no,t.dc_no,t.dc_date,t.trans_type,t.db_account,t.cr_account,t.statecode,t.gstin,t.inv_type,t.rcm,t.net_amount,t.trans_amount,t.trans_reference,t.trans_narration,t.salebyperson,t.finyear,t.creditperiod,l.account_name`custname` FROM transaction_tbl t,ledgermaster_tbl l where  t.db_account=l.id and t.id=? AND t.trans_type=? and t.company_id=? and t.finyear=? GROUP BY t.id";


/*	$sql="SELECT t.id, t.trans_id,t.trans_date,t.order_date,t.order_no,t.dc_no,t.dc_date,t.trans_type,t.db_account,t.cr_account,t.statecode,t.gstin,t.inv_type,t.rcm,t.net_amount,t.trans_amount,t.trans_reference,t.trans_narration,t.salebyperson,t.finyear,l.account_name`custname`,sum(itm.taxable_amount)`txb_amt`,sum(itm.nett_amount)`net_amt` FROM transaction_tbl t,ledgermaster_tbl l,itemtransaction_tbl itm where t.id=itm.trans_link_id and t.db_account=l.id and itm.delflag=0 and t.id=? and t.trans_type=? GROUP BY t.id";
*/
$query = $this->db->query($sql, array($id,$trans_type,$cid,$finyear));

//$this->output->enable_profiler(TRUE); 

return $query->result_array();
}
    

}

public function getSettings($cid=null,$finyear)
{
  $sql="SELECT * FROM settings_tbl where company_id=? and finyear=?";
  $query = $this->db->query($sql,array($cid,$finyear));
  return $query->result_array();
}


public function prodbycatid($cid=null,$catid=null)
{
    $sql="SELECT * FROM products_tbl where company_id=? and prod_cat=?";
    $query = $this->db->query($sql,array($cid,$catid));
    return $query->result_array();
  
}


public function getProductbyid($cid=null,$id=null)
{
    $sql="SELECT * FROM products_tbl where company_id=? and id=?";
    $query = $this->db->query($sql,array($cid,$id));
    return $query->result_array();
  
}


public function getFYData($cid=null)
{
  $sql="SELECT * FROM settings_tbl where company_id=?";
  $query = $this->db->query($sql,array($cid));
  return $query->result_array();
}
public function getProductbyqry($qry =null,$cid =null)
{
    $sql="SELECT * FROM products_tbl where prod_name like '%". $qry . "%' and  company_id=?";
   
$query = $this->db->query($sql,array($cid));
return $query->result_array();

}


public function getProductbyqryname($qry =null,$cid =null)
{
    $sql="SELECT * FROM products_tbl where prod_name =? and  company_id=?";
   
$query = $this->db->query($sql,array($qry,$cid));
return $query->result_array();

}



public function getProductsbyidcid($id=null,$cid =null)
{

    $sql="SELECT * FROM products_tbl where id=? and company_id=? and delflag=0";
$query = $this->db->query($sql,array($id,$cid));
return $query->result_array();

}

public function getProductsbycid($cid =null)
{

    $sql="SELECT * FROM products_tbl where company_id=? and delflag=0";
$query = $this->db->query($sql,array($cid));
return $query->result_array();

}

public function updSettings($cid=null,$finyear=null,$next_no=null,$trans_type=null)
{
    $sts="";
	//var_dump($cid . $finyear . $next_no . $trans_type );
if($trans_type=="SALE")
{


  $upd = array('inv_no' =>$next_no);
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('settings_tbl',$upd);

}

elseif ($trans_type=="RCPT") {
	# code...

  $upd = array('receipt_no' =>$next_no);
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('settings_tbl',$upd);

}

elseif ($trans_type=="PYMT") {
	# code...

  $upd = array('payment_no' =>$next_no);
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('settings_tbl',$upd);

}

elseif ($trans_type=="JRNL") {
    # code...

  $upd = array('journal_no' =>$next_no);
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('settings_tbl',$upd);

}


elseif ($trans_type=="CNTR") {
    # code...

  $upd = array('contra_no' =>$next_no);
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('settings_tbl',$upd);

}

elseif ($trans_type=="SRTN") {
    # code...

  $upd = array('cn_no' =>$next_no);
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('settings_tbl',$upd);

}

elseif ($trans_type=="PRTN") {
    # code...

  $upd = array('dn_no' =>$next_no);
  $this->db->where('company_id',$cid);
  $this->db->where('finyear',$finyear);
$sts=  $this->db->update('settings_tbl',$upd);

}


echo json_encode($sts);
}


public function getSalesPurchaseItems($id=null,$trans_type=null,$cid=nul,$finyear=null)
{
	   if(!empty($id)){
$sql="SELECT * FROM itemtransaction_tbl where delflag=0 and trans_link_id=? and trans_type=? and company_id=? and finyear=? order by id desc";

$query = $this->db->query($sql, array($id,$trans_type,$cid,$finyear));
}
    
    return $query->result_array();

}



public function getChartData($finyear=null,$compid=null,$transtype=null)
{
	   $sql ='SELECT SUM(CASE WHEN month(trans_date)="01" THEN trans_amount ELSE 0 END)`JAN`,SUM(CASE WHEN month(trans_date)="02" THEN trans_amount ELSE 0 END)`FEB`,SUM(CASE WHEN month(trans_date)="03" THEN trans_amount ELSE 0 END)`MAR`,SUM(CASE WHEN month(trans_date)="04" THEN trans_amount ELSE 0 END)`APR`,SUM(CASE WHEN month(trans_date)="05" THEN trans_amount ELSE 0 END)`MAY`,SUM(CASE WHEN month(trans_date)="06" THEN trans_amount ELSE 0 END)`JUN`,SUM(CASE WHEN month(trans_date)="07" THEN trans_amount ELSE 0 END)`JUL`,SUM(CASE WHEN month(trans_date)="08" THEN trans_amount ELSE 0 END)`AUG`,SUM(CASE WHEN month(trans_date)="09" THEN trans_amount ELSE 0 END)`SEP`,SUM(CASE WHEN month(trans_date)="10" THEN trans_amount ELSE 0 END)`OCT`,SUM(CASE WHEN month(trans_date)="11" THEN trans_amount ELSE 0 END)`NOV`,SUM(CASE WHEN month(trans_date)="12" THEN trans_amount ELSE 0 END)`DEC` FROM  transaction_tbl  WHERE delflag=0 and finyear=? and company_id=? and trans_type=?';

$query = $this->db->query($sql, array($finyear,$compid,$transtype));

return $query->result_array();
 
}

public function getpiChartData($finyear=null,$compid=null)
{
	$sql ='SELECT s.sales_person,sum(it.trans_amount) `tot_rev` FROM  transaction_tbl it, salesperson_tbl s WHERE s.delflag=0 and it.finyear=? and it.company_id=? and it.trans_type="SALE" and it.salebyperson=s.id group by it.salebyperson';
$query = $this->db->query($sql, array($finyear,$compid));

return $query->result_array();



}


public function getGstStatebycid()
{
    $sql="SELECT * from gststate_tbl"; 
    $query=$this->db->query($sql);
    return $query->result_array();

}

public function getTransDatabyid($cid=null,$finyear=null,$trans_type=null,$id=null)
{
    $sql="SELECT * from transaction_tbl where company_id=? and finyear=? and trans_type=? and id=?";
    $query=$this->db->query($sql,array($cid,$finyear, $trans_type,$id));
    return $query->result_array();

}


public function getTransData($cid=null,$finyear=null,$trans_type=null)
{
    $sql="SELECT * from transaction_tbl where company_id=? and finyear=? and trans_type=?";
    $query=$this->db->query($sql,array($cid,$finyear, $trans_type));
    return $query->result_array();

}

public function getLedgerbyidbycid($cid=null,$id=null)
{
    $sql="SELECT * from ledgermaster_tbl where company_id=? and id=? and delflag=0 and predefined=0 order by id";
    $query=$this->db->query($sql,array($cid,$id));
 //  $this->output->enable_profiler(TRUE); 
   
    return $query->result_array();

}


public function getall_ledgers($cid=null)
{
    $sql="SELECT * from ledgermaster_tbl where company_id=? and delflag=0 and predefined=0 order by id";
    $query=$this->db->query($sql,array($cid));
    return $query->result_array();
}

public function getProductcatbycid($cid=null)
{
    $sql="SELECT * FROM productscategory_tbl where company_id=? and delflag=0 order by id";
    $query=$this->db->query($sql,array($cid));
    return $query->result_array();

}

public function updateDellflagCategorybyid($id=null,$cid=null)
{
    $upd = array('delflag' =>"1");
    $this->db->where('id',$id);
    $this->db->where('company_id',$cid);
    $query=$this->db->update('productscategory_tbl', $upd);
    return;


}

public function updateDellflagStaffbyid($id=null,$cid=null)
{
    $upd = array('delflag' =>"1");
    $this->db->where('id',$id);
    $this->db->where('company_id',$cid);
    $query=$this->db->update('salesperson_tbl', $upd);
    return;


}

public function getStockbydate($finyear=null,$cid=null,$fdate=null,$tdate=null,$catid)
{
    if($catid=="" || $catid=="0")
    {
    $sql="SELECT c.category_name, i.item_id,i.item_name,(SUM(CASE WHEN i.trans_type='SALE' THEN i.item_qty ELSE 0 END)+SUM(CASE WHEN i.trans_type='PRTN' THEN i.item_qty ELSE 0 END)) `outward`, (SUM(CASE WHEN i.trans_type='PURC' THEN i.item_qty ELSE 0 END)+SUM(CASE WHEN i.trans_type='SRTN' THEN i.item_qty ELSE 0 END)) `inward` FROM `itemtransaction_tbl` i, products_tbl p, productscategory_tbl c WHERE i.company_id=c.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=p.company_id and i.company_id=? and i.trans_date>=? and i.trans_date<=? and i.finyear=? and i.delflag=0 group by i.item_id order by i.item_id";
    $query=$this->db->query($sql,array($cid,$fdate,$tdate,$finyear));
  // $this->output->enable_profiler(TRUE); 
    }
    else
    {
        $sql="SELECT c.category_name, i.item_id,i.item_name,(SUM(CASE WHEN i.trans_type='SALE' THEN i.item_qty ELSE 0 END)+SUM(CASE WHEN i.trans_type='PRTN' THEN i.item_qty ELSE 0 END)) `outward`, (SUM(CASE WHEN i.trans_type='PURC' THEN i.item_qty ELSE 0 END)+SUM(CASE WHEN i.trans_type='SRTN' THEN i.item_qty ELSE 0 END)) `inward` FROM `itemtransaction_tbl` i, products_tbl p, productscategory_tbl c WHERE  i.company_id=c.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=p.company_id and i.company_id=? and i.trans_date>=? and i.trans_date<=? and i.finyear=? and c.id=? and i.delflag=0 group by i.item_id order by i.item_id";
        $query=$this->db->query($sql,array($cid,$fdate,$tdate,$finyear,$catid));
    
    }
  return $query->result_array();
}


public function getProductbycatid($cid=null,$catid=null)
{
    if($catid=="" || $catid=="0")
    {
        $sql="SELECT * from products_tbl where company_id=?  and delflag=0";
        $query=$this->db->query($sql,array($cid));
    }
    else
    {
        $sql="SELECT * from products_tbl where company_id=?  and prod_cat=? and delflag=0";
        $query=$this->db->query($sql,array($cid,$catid));
       
    }
   //$this->output->enable_profiler(TRUE); 

    return $query->result_array();
    
}


public function getProductopbyid($cid=null,$finyear=null,$id=null)
{
    $sql="SELECT * from openingstock_tbl where company_id=? and finyear=? and prod_id=? and delflag=0";
    $query=$this->db->query($sql,array($cid,$finyear,$id));
    return $query->result_array();
    
}



public function getopstockbyid($cid=null,$finyear=null)
{
    $sql="SELECT * from openingstock_tbl where company_id=? and finyear=? and delflag=0";
    $query=$this->db->query($sql,array($cid,$finyear));
    return $query->result_array();
    
}

public function getopStockbydate($finyear=null,$cid=null,$fdate=null,$tdate=null,$catid=null)
{

if($catid=="" || $catid=="0")
{
$sql="SELECT i.item_id,i.item_name,(SUM(CASE WHEN i.trans_type='SRTN' THEN i.item_qty ELSE 0 END) + SUM(CASE WHEN i.trans_type='PURC' THEN i.item_qty ELSE 0 END))-(SUM(CASE WHEN i.trans_type='PRTN' THEN i.item_qty ELSE 0 END) + SUM(CASE WHEN i.trans_type='SALE' THEN i.item_qty ELSE 0 END)) `opstock` FROM `itemtransaction_tbl` i, products_tbl p, productscategory_tbl c WHERE  i.company_id=c.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=p.company_id and i.company_id=? and i.trans_date>=? and i.trans_date<? and i.finyear=? and i.delflag=0 group by i.item_id order by i.item_id";
$query=$this->db->query($sql,array($cid,$fdate,$tdate,$finyear));

}
else
{
    $sql="SELECT i.item_id,i.item_name,(SUM(CASE WHEN i.trans_type='SRTN' THEN i.item_qty ELSE 0 END) + SUM(CASE WHEN i.trans_type='PURC' THEN i.item_qty ELSE 0 END))-(SUM(CASE WHEN i.trans_type='PRTN' THEN i.item_qty ELSE 0 END) + SUM(CASE WHEN i.trans_type='SALE' THEN i.item_qty ELSE 0 END)) `opstock` FROM `itemtransaction_tbl` i, products_tbl p, productscategory_tbl c WHERE  i.company_id=c.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=p.company_id and i.company_id=? and i.trans_date>=? and i.trans_date<? and i.finyear=? and c.id=? and i.delflag=0 group by i.item_id order by i.item_id";
    $query=$this->db->query($sql,array($cid,$fdate,$tdate,$finyear,$catid));
    
}
 //$this->output->enable_profiler(TRUE); 

return $query->result_array();
}



public function getCatSalesItemsbycatid($cid,$id,$fdate,$tdate,$finyear,$catid)
{
if($catid=="" || $catid=="0")
{
    $sql="SELECT  c.category_name, i.trans_id,i.trans_date,i.item_name,i.item_desc,i.item_hsnsac,i.item_unit,i.item_qty,i.item_mrp,i.item_rate,i.item_amount,i.item_dispc,p.v_disc_pc, (i.taxable_amount)`txb_amt`,(i.nett_amount)`net_amt`,((i.igst_amount)+(i.cgst_amount)+(i.igst_amount))`gst_amt`  FROM itemtransaction_tbl i,productscategory_tbl c,products_tbl p where p.company_id=i.company_id and c.company_id=i.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=? and i.trans_link_id=? and i.trans_date>=? and i.trans_date<=? and i.finyear=? and i.delflag=0";
    $query=$this->db->query($sql,array($cid,$id,$fdate,$tdate,$finyear));

}
else
{
    $sql="SELECT c.category_name, i.trans_id,i.trans_date,i.item_name,i.item_desc,i.item_hsnsac,i.item_unit,i.item_qty,i.item_mrp,i.item_rate,i.item_amount,i.item_dispc,p.v_disc_pc,(i.taxable_amount)`txb_amt`,(i.nett_amount)`net_amt`,((i.igst_amount)+(i.cgst_amount)+(i.igst_amount))`gst_amt`  FROM itemtransaction_tbl i,productscategory_tbl c,products_tbl p where p.company_id=i.company_id and c.company_id=i.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=? and i.trans_link_id=? and i.trans_date>=? and i.trans_date<=? and i.finyear=? and c.id=? and i.delflag=0";
    $query=$this->db->query($sql,array($cid,$id,$fdate,$tdate,$finyear,$catid));

}
  // $this->output->enable_profiler(TRUE); 

    return $query->result_array();

}

public function getCategorybyid($id=null,$cid=null)
{
$sql="SELECT * FROM productscategory_tbl where delflag=0 and id=? and company_id=?";
$query=$this->db->query($sql,array($id,$cid));
 return $query->result_array();
}

public function getStaffbyid($id=null,$cid=null)
{
$sql="SELECT * FROM salesperson_tbl where delflag=0 and id=? and company_id=?";
$query=$this->db->query($sql,array($id,$cid));
 return $query->result_array();
}

public function getStaffSalesItemsbyid($cid,$id,$fdate,$tdate,$finyear)
{
    $sql="SELECT  c.category_name, i.trans_id,i.trans_date,sum(i.taxable_amount)`txb_amt`,sum(i.nett_amount)`net_amt`,(sum(i.sgst_amount)+sum(i.cgst_amount)+sum(i.igst_amount))`gst_amt`  FROM itemtransaction_tbl i,productscategory_tbl c,products_tbl p where p.company_id=i.company_id and c.company_id=i.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=? and i.trans_link_id=? and i.trans_date>=? and i.trans_date<=? and i.finyear=? and i.delflag=0 group by i.trans_id";
    //$sql="SELECT c.category_name, i.* FROM itemtransaction_tbl i,productscategory_tbl c,products_tbl p  where p.company_id=i.company_id and c.company_id=i.company_id and i.item_id=p.id and p.prod_cat=c.id and i.company_id=? and i.trans_link_id=? and i.trans_date>=? and i.trans_date<=?  and i.delflag=0 order by i.id";
    $query=$this->db->query($sql,array($cid,$id,$fdate,$tdate,$finyear));
  //  $this->output->enable_profiler(TRUE); 

    return $query->result_array();

}

public function getStaffSalesbycustid($cid=null,$finyear=null,$cust_id=null)
{
  //  $sql="SELECT SUM(CASE WHEN t.trans_type='SALE' AND (t.db_account=? or t.cr_account=? )  THEN net_amount  WHEN t.trans_type='PRTN' AND (t.db_account=? or t.cr_account=?)  THEN t.net_amount WHEN t.trans_type='CNTR' AND (t.cr_account=?) THEN t.trans_amount  WHEN t.trans_type='PYMT' AND (t.db_account=?  or t.cr_account=?) THEN t.trans_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PURC' AND (t.db_account=?  or t.cr_account=? )  THEN t.net_amount  WHEN t.trans_type='SRTN' AND (t.db_account=?  or t.cr_account=? )  THEN t.net_amount  WHEN t.trans_type='CNTR' AND (t.db_account=?) THEN t.trans_amount WHEN t.trans_type='RCPT' AND (t.db_account=?  or t.cr_account=? ) THEN t.trans_amount ELSE 0 END) `outstand` FROM `transaction_tbl` t WHERE t.finyear=? and t.company_id=?  and t.delflag=0";

  //  $sql="SELECT t.salebyperson,t.db_account,l.account_name, SUM(CASE WHEN t.trans_type='SALE' THEN t.net_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='SRTN' THEN t.net_amount ELSE 0 END) `tot_sales`,SUM(CASE WHEN t.trans_type='RCPT' THEN t.net_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='PYMT' THEN t.net_amount ELSE 0 END)`tot_rcpt` FROM `transaction_tbl` t,ledgermaster_tbl l WHERE t.company_id=l.company_id and t.db_account=l.id and t.company_id=? and t.finyear=? AND (t.db_account=? or t.cr_account=?)";
 $sql="SELECT t.salebyperson,t.db_account,l.account_name, SUM(CASE WHEN t.trans_type='SALE' THEN t.net_amount ELSE 0 END)-SUM(CASE WHEN t.trans_type='SRTN' THEN t.net_amount ELSE 0 END)`tot_sales`,SUM(CASE WHEN t.trans_type='RCPT' THEN t.net_amount ELSE 0 END)`tot_rcpt` FROM `transaction_tbl` t,ledgermaster_tbl l WHERE t.company_id=l.company_id and t.db_account=l.id and t.company_id=? and t.finyear=? AND (t.db_account=? or cr_account=?)";
  $query=$this->db->query($sql,array($cid,$finyear,$cust_id,$cust_id));
  //  $this->output->enable_profiler(TRUE); 

 return $query->result_array();

}


public function getStaffSalesbyfinyear($cid,$id,$finyear)
{
  // $sql="SELECT t.salebyperson,t.db_account,l.account_name, SUM(CASE WHEN t.trans_type='SALE' THEN t.net_amount END)`tot_sales`,SUM(CASE WHEN t.trans_type='RCPT' THEN t.net_amount END)`tot_rcpt` FROM `transaction_tbl` t,ledgermaster_tbl l WHERE t.company_id=l.company_id and t.db_account=l.id and t.company_id=? and t.finyear=? AND (t.db_account=? or cr_account=?)";
    $sql="SELECT l.id,l.account_name,t.* FROM transaction_tbl t,ledgermaster_tbl l where t.company_id=l.company_id and t.db_account=l.id and t.company_id=? and t.salebyperson=? and t.finyear=? and  t.delflag=0 group by t.db_account order by t.id";
    $query=$this->db->query($sql,array($cid,$id,$finyear));
   
    return $query->result_array();

}

public function getStaffSalesbyid($cid,$id,$fdate,$tdate,$finyear)
{
    $sql="SELECT l.account_name,t.* FROM transaction_tbl t,ledgermaster_tbl l where t.company_id=l.company_id and t.db_account=l.id and t.company_id=? and t.salebyperson=? and t.trans_date>=? and t.trans_date<=?  and t.delflag=0 order by t.id";
    $query=$this->db->query($sql,array($cid,$id,$fdate,$tdate));
    return $query->result_array();

}

public function getCatSalesbytranstype($trans_type,$finyear,$cid,$fdate,$tdate)
{
    $sql="SELECT l.account_name,t.* FROM transaction_tbl t,ledgermaster_tbl l where t.company_id=l.company_id and t.db_account=l.id and t.company_id=? and t.trans_type=? and t.trans_date>=? and t.trans_date<=? and t.finyear=?  and t.delflag=0 order by t.id";
    $query=$this->db->query($sql,array($cid,$trans_type,$fdate,$tdate,$finyear));
 //   $this->output->enable_profiler(TRUE); 

    return $query->result_array();

}


public function getCategorybycid($cid=null)
{
    if($cid)
    {
        $sql="SELECT * FROM productscategory_tbl where company_id=? and delflag=0 order by id";
        $query=$this->db->query($sql,array($cid));
        return $query->result_array();
    }

}

public function getCategorybycatid($cid=null,$id=null)
{
    if($id=="" || $id=="0")
    {
        $sql="SELECT * FROM productscategory_tbl where company_id=? and delflag=0 order by id";
        $query=$this->db->query($sql,array($cid));
}
else
{
    $sql="SELECT * FROM productscategory_tbl where company_id=? and id=?  and delflag=0 order by id";
    $query=$this->db->query($sql,array($cid,$id));

}
 //$this->output->enable_profiler(TRUE); 

return $query->result_array();

}


public function getStaffbycid($cid=null,$id=null)
{
    if($id)
    {
    $sql="SELECT * FROM salesperson_tbl where company_id=? and id=? and delflag=0 order by id";
    $query=$this->db->query($sql,array($cid,$id));
    }
    else
    {
        $sql="SELECT * FROM salesperson_tbl where company_id=? and delflag=0 order by id";
        $query=$this->db->query($sql,array($cid));
    
    }
    return $query->result_array();

}

public function getUnitsbycid($cid=null)
{
    $sql="SELECT * FROM units_tbl where company_id=? order by id";
    $query=$this->db->query($sql,array($cid));
    return $query->result_array();

}


public function getLedgerbycid($cid=null)
{
    $sql="SELECT * FROM ledgermaster_tbl where company_id=? and delflag=0 order by id";
    $query=$this->db->query($sql,array($cid));
    return $query->result_array();

}


public function getLedgerbyId($actid=null,$cid=null)
{
 if($actid)
 {
    $sql="SELECT * FROM ledgermaster_tbl where id=? and company_id=? order by id";
    $query=$this->db->query($sql,array($actid,$cid));
    return $query->result_array();
 }
}

public function getGroupbyid($cid=null,$grpid=null)
{
    $sql="SELECT * FROM `group_tbl` WHERE company_id=? and id=?";
    $query= $this->db->query($sql,array($cid,$grpid));
    return $query->result_array();
}



public function getGroupid($cid=null,$trans_type=null)
{
    $sql="SELECT l.id FROM `group_tbl` g,ledgermaster_tbl l WHERE l.account_groupid=g.id and g.company_id=l.company_id and g.company_id=? and g.trans_type=?";
    $query= $this->db->query($sql,array($cid,$trans_type));
    return $query->result_array();
}

public function getTransDetails($compid=null,$trans_type=null,$fdate=null,$tdate=null,$finyear=null)
{
 $sql="SELECT t.*,count(it.id) FROM transaction_tbl t, itemtransaction_tbl it where t.company_id=it.company_id and t.company_id=? and t.trans_date>=? and t.trans_date<=? and t.finyear=? and t.trans_type=? and it.invoice_id=t.invoice_no  and t.delflag=0 and it.delflag=0";
}

public function getLedgerbygrpid($cid=null,$grp_id)
{
$sql="SELECT * from ledgermaster_tbl  where company_id=? and account_groupid=? order by id";
$query=$this->db->query($sql,array($cid,$grp_id));
return $query->result_array();

}

public function getCashBankAccounts($cid=null)
{
$sql="SELECT l.* from ledgermaster_tbl l,group_tbl g where l.company_id=g.company_id and l.account_groupid=g.id and g.trans_type='CSBK' and l.company_id=? order by l.id";
$query=$this->db->query($sql,array($cid));
return $query->result_array();

}

public function getCashBankLedger($cid=null,$qry=null)
{
    $sql="SELECT * FROM ledgermaster_tbl WHERE company_id=? and account_name like '%?%' and cb_code<>0";
    $query= $this->db->query($sql,array($cid,$qry));
   // $this->output->enable_profiler(TRUE); 

    return $query->result_array();

  
}

public function getLedgerbyAccountName($cid=null,$qry=null)
{
    $sql="SELECT * FROM ledgermaster_tbl WHERE company_id=? and account_name like ?";
    $query= $this->db->query($sql,array($cid,$qry));
   // $this->output->enable_profiler(TRUE); 

    return $query->result_array();

  
}

public function getApiConfigdata($cid=null,$api_name=null)
{
    $sql="SELECT * FROM api_interface_tbl where api_status=0 and company_id=? and api_name=?";
    $query= $this->db->query($sql,array($cid,$api_name));
    return $query->result_array();

}


public function getprodopbalData($compid=null,$finyear=null)
{
      
$sql="SELECT * from openingstock_tbl where delflag=0 and finyear=? and company_id=? order by cur_timestamp desc";

            $query = $this->db->query($sql, array($finyear,$compid));
        //    $data = $this->db->get("ledgermaster_tbl")->result();
        return $query->result_array();

}


public function getopbalData($compid=null,$finyear=null)
{
      
$sql="SELECT * from openingbalance_tbl where delflag=0 and finyear=? and company_id=? order by cur_timestamp desc";

            $query = $this->db->query($sql, array($finyear,$compid));
        //    $data = $this->db->get("ledgermaster_tbl")->result();
        return $query->result_array();

}

public function updateTransItems($id,$cid,$finyear,$data)
{

    foreach($data as $row => $value)
    {
        $this->db->where('trans_link_id',$id);
        $this->db->where('company_id',$cid);
        $this->db->where('finyear',$finyear);

        $query=$this->db->update('itemtransaction_tbl', $data);

    }

    return;

}

public function getopdatabyid($compid=null,$ldg_id=null,$finyear=null)
{
    $sql="SELECT o.ldger_id,o.open_bal,o.finyear,o.company_id,l.ldg_name from openingbalance_tbl o,ledgermaster_tbl l where o.delflag=0 and o.ldger_id=l.id and ldger_id=? and company_id=? and finyear=?";
    $query = $this->db->query($sql,array($ldg_id,$compid,$finyear));
    return $query->result_array();
}

public function getopbalDatabyid($compid=null,$finyear=null,$lid=null)
{
      
$sql="SELECT * from openingbalance_tbl where delflag=0 and finyear=? and company_id=? AND ldger_id=? order by ldger_id";

            $query = $this->db->query($sql, array($finyear,$compid,$lid));
        //    $data = $this->db->get("ledgermaster_tbl")->result();
        return $query->result_array();

}

public function getmonwiseITCData($finyear=null,$compid=null)
{
	 $sql="SELECT SUM(case WHEN month(trans_date)='04' AND trans_type='PURC' THEN (igst_amount+cgst_amount+sgst_amount) ELSE 0 END)-SUM(case WHEN month(trans_date)='04' AND trans_type='SALE' THEN (igst_amount+cgst_amount+sgst_amount) ELSE 0 END) `apr`,SUM(case WHEN month(trans_date)='05' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='05' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`may`,SUM(case WHEN month(trans_date)='06' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='06' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`jun`,SUM(case WHEN month(trans_date)='07' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='07' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`jul`,SUM(case WHEN month(trans_date)='08' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='08' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`aug`,SUM(case WHEN month(trans_date)='09' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='09' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`sep`,SUM(case WHEN month(trans_date)='10' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='10' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`oct`,SUM(case WHEN month(trans_date)='11' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='11' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`nov`,SUM(case WHEN month(trans_date)='12' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='12' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`dec`,SUM(case WHEN month(trans_date)='01' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='01' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`jan`,SUM(case WHEN month(trans_date)='02' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='02' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`feb`,SUM(case WHEN month(trans_date)='03' AND trans_type='PURC' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)-SUM(case WHEN month(trans_date)='03' AND trans_type='SALE' THEN  (igst_amount+cgst_amount+sgst_amount)  ELSE 0 END)`mar` FROM itemtransaction_tbl WHERE delflag=0 AND company_id=? AND finyear=?";

$query = $this->db->query($sql, array($compid,$finyear));

return $query->result_array();

}




}
