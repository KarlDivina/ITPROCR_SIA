<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reimbursements extends CI_Controller {

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
        $data['content']=$this->Reimbursements_model->select_reimbursements();
        $this->load->view('admin/header');
        $this->load->view('admin/reimbursements-history', $data);
        $this->load->view('admin/footer');
    }

    public function apply()
    {
        $this->load->view('staff/header');
        $this->load->view('staff/apply-reimbursement');
        $this->load->view('staff/footer');
    }

    public function approve()
    {
        $staff=$this->session->userdata('userid');
        $data['content']=$this->Reimbursements_model->select_reimbursement_forApprove();
        $this->load->view('admin/header');
        $this->load->view('admin/approve-reimbursement',$data);
        $this->load->view('admin/footer');
    }

    public function manage()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/manage-leave');
        $this->load->view('admin/footer');
    }

    public function view()
    {
        $staff=$this->session->userdata('userid');
        $data['content']=$this->Reimbursements_model->select_reimbursement_byStaffID($staff);
        $this->load->view('staff/header');
        $this->load->view('staff/view-reimbursements',$data);
        $this->load->view('staff/footer');
    }

    public function insert_approve($id, $staffID, $amount, $total)
    {
        $datenow = date('Y:m:d');
        $data=$this->Reimbursements_model->update_reimbursement(array('status'=>1, 'updated_on'=>$datenow), $id, array('reimbursement'=>$amount, 'total'=>$total), $staffID);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Reimbursement Approved Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Reimbursement Approve Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert_reject($id, $staffID)
    {
        $datenow = date('Y:m:d');
        $data=$this->Reimbursements_model->update_leave(array('status'=>2, 'updated_on'=>$datenow), $id, array('reimbursement'=>0), $staffID);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Reimbursement Rejected Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Reimbursement Reject Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert()
    {
        $this->form_validation->set_rules('txtreason', 'Reason', 'required');
        $this->form_validation->set_rules('txt_amount', 'Amount', 'required');

        $staff=$this->session->userdata('userid');
        $reason=$this->input->post('txtreason');
        $amount=$this->input->post('txt_amount');
        $data=$this->Reimbursements_model->insert_reimbursement(array('staff_id'=>$staff,'reason'=>$reason,'amount'=>$amount,'applied_on'=>date('Y-m-d'),'updated_on'=>date('Y-m-d')));
        if($data==true)
        {
            $this->session->set_flashdata('success', "New Expense Applied Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, New Expense Apply Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update()
    {
        $id=$this->input->post('txtid');
        $department=$this->input->post('txtdepartment');
        $data=$this->Department_model->update_department(array('department_name'=>$department),$id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Updated Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Update Failed.");
        }
        redirect(base_url()."department/manage_department");
    }


    function edit($id)
    {
        $data['content']=$this->Department_model->select_department_byID($id);
        $this->load->view('admin/header');
        $this->load->view('admin/edit-department',$data);
        $this->load->view('admin/footer');
    }


    function delete($id)
    {
        $data=$this->Department_model->delete_department($id);
        if($this->db->affected_rows() > 0)
        {
            $this->session->set_flashdata('success', "Department Deleted Succesfully"); 
        }else{
            $this->session->set_flashdata('error', "Sorry, Department Delete Failed.");
        }
        redirect($_SERVER['HTTP_REFERER']);
    }



}
