<?php
   
   require APPPATH . 'libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Units extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        if(!empty($id)){
            $data = $this->db->get_where("units_tbl", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("units_tbl")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      

    public function unitbycid_get($cid = 0)
	{
        if(!empty($cid)){
            $data = $this->db->get_where("units_tbl", ['company_id' => $cid])->row_array();
        }else{
            $data = $this->db->get("units_tbl")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
    



    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        $this->db->insert('units_tbl',$input);
     
        $this->response(['created successfully.'], REST_Controller::HTTP_OK);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('units_tbl', $input, array('id'=>$id));
     
        $this->response(['updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('units_tbl', array('id'=>$id));
       
        $this->response(['deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}