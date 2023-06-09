<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in'))
        { 
            redirect(base_url().'login');
        }
    }

    public function index()
    {
        $data['content']=$this->Performance_model->select_staff();
        $this->load->view('admin/header');
        $this->load->view('admin/manage-performance',$data);
        // $this->load->view('admin/manage-performance');
        $this->load->view('admin/footer');
    }

    // public function manage()
    // {
    //     // $data['content']=$this->Training_model->select_staff();
    //     $this->load->view('admin/header');
    //     // $this->load->view('admin/manage-trainees',$data);
    //     $this->load->view('admin/manage-trainees');
    //     $this->load->view('admin/footer');
    // }

    // public function insert()
    // {
    //     $this->form_validation->set_rules('txtname', 'Full Name', 'required');
    //     $this->form_validation->set_rules('slcgender', 'Gender', 'required');
    //     $this->form_validation->set_rules('slcdepartment', 'Department', 'required');
    //     $this->form_validation->set_rules('txtemail', 'Email', 'trim|required|valid_email');
    //     $this->form_validation->set_rules('txtmobile', 'Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]');
    //     $this->form_validation->set_rules('txtdob', 'Date of Birth', 'required');
    //     $this->form_validation->set_rules('txtdoj', 'Date of Joining', 'required');
    //     $this->form_validation->set_rules('txtcity', 'City', 'required');
    //     $this->form_validation->set_rules('txtstate', 'State', 'required');
    //     $this->form_validation->set_rules('slccountry', 'Country', 'required');
        
    //     $name=$this->input->post('txtname');
    //     $gender=$this->input->post('slcgender');
    //     $department=$this->input->post('slcdepartment');
    //     $email=$this->input->post('txtemail');
    //     $mobile=$this->input->post('txtmobile');
    //     $dob=$this->input->post('txtdob');
    //     $doj=$this->input->post('txtdoj');
    //     $city=$this->input->post('txtcity');
    //     $state=$this->input->post('txtstate');
    //     $country=$this->input->post('slccountry');
    //     $address=$this->input->post('txtaddress');
    //     $added=$this->session->userdata('userid');

    //     if($this->form_validation->run() !== false)
    //     {
    //         $this->load->library('image_lib');
    //         $config['upload_path']= 'uploads/profile-pic/';
    //         $config['allowed_types'] ='gif|jpg|png|jpeg';
    //         $this->load->library('upload', $config);
    //         if ( ! $this->upload->do_upload('filephoto'))
    //         {
    //             $image='default-pic.jpg';
    //         }
    //         else
    //         {
    //             $image_data =   $this->upload->data();

    //             $configer =  array(
    //               'image_library'   => 'gd2',
    //               'source_image'    =>  $image_data['full_path'],
    //               'maintain_ratio'  =>  TRUE,
    //               'width'           =>  150,
    //               'height'          =>  150,
    //               'quality'         =>  50
    //             );
    //             $this->image_lib->clear();
    //             $this->image_lib->initialize($configer);
    //             $this->image_lib->resize();
                
    //             $image=$image_data['file_name'];
    //         }
    //         $login=$this->Home_model->insert_login(array('username'=>$email,'password'=>$mobile,'usertype'=>2));
    //         if($login>0)
    //         {
    //             $data=$this->Staff_model->insert_staff(array('id'=>$login,'staff_name'=>$name,'gender'=>$gender,'email'=>$email,'mobile'=>$mobile,'dob'=>$dob,'doj'=>$doj,'address'=>$address,'city'=>$city,'state'=>$state,'country'=>$country,'department_id'=>$department,'pic'=>$image,'added_by'=>$added));
    //         }
            
    //         if($data==true)
    //         {
                
    //             $this->session->set_flashdata('success', "New Staff Added Succesfully"); 
    //         }else{
    //             $this->session->set_flashdata('error', "Sorry, New Staff Adding Failed.");
    //         }
    //         redirect($_SERVER['HTTP_REFERER']);
    //     }
    //     else{
    //         $this->index();
    //         return false;

    //     } 
    // }

    public function update()
    {
        $this->load->helper('form');
        $this->form_validation->set_rules('txt_per_current', 'Performance Rating', 'required');
        $this->form_validation->set_rules('txt_pf_improvement', 'Points for Improvement', 'required');
        $this->form_validation->set_rules('txt_highlights', 'Points of Excellence', 'required');
        
        $id=$this->input->post('txtid');
        $rating_previous=$this->input->post('txt_per_previous');
        $rating_current=$this->input->post('txt_per_current');
        $improve=$this->input->post('txt_pf_improvement');
        $excel=$this->input->post('txt_highlights');

        if($this->form_validation->run() !== false)
        {
           $data=$this->Performance_model->update_performance(array('per_previous'=>$rating_previous,'per_current'=>$rating_current,'pf_improvement'=>$improve,'highlights'=>$excel),$id);
            
            if($this->db->affected_rows() > 0)
            {
                $this->session->set_flashdata('success', "Performance Updated Succesfully"); 
            }else{
                $this->session->set_flashdata('error', "Sorry, Performance Update Failed.");
            }
            redirect(base_url()."view-performance");
        }
        else{
            $this->index();
            return false;

        } 
    }


    function edit($id)
    {
        $data['content']=$this->Performance_model->select_staff_byID($id);
        $this->load->view('admin/header');
        $this->load->view('admin/edit-performance',$data);
        $this->load->view('admin/footer');
    }


    // function delete($id)
    // {
    //     $this->Home_model->delete_login_byID($id);
    //     $data=$this->Staff_model->delete_staff($id);
    //     if($this->db->affected_rows() > 0)
    //     {
    //         $this->session->set_flashdata('success', "Staff Deleted Succesfully"); 
    //     }else{
    //         $this->session->set_flashdata('error', "Sorry, Staff Delete Failed.");
    //     }
    //     redirect($_SERVER['HTTP_REFERER']);
    // }

    



}
