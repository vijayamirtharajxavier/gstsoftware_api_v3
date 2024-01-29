<?php
   
   require APPPATH . 'libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;
     
class Company extends REST_Controller {
    
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
            $data = $this->db->get_where("company_tbl", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("company_tbl")->result();
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
        $this->db->insert('company_tbl',$input);
     
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
        $this->db->update('company_tbl', $input, array('id'=>$id));
     
        $this->response(['updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('company_tbl', array('id'=>$id));
       
        $this->response(['deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}