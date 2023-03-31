<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reimbursements_model extends CI_Model {


    function insert_reimbursement($data)
    {
        $this->db->insert("reimbursements_tbl",$data);
        return $this->db->insert_id();
    }

    function select_reimbursements()
    {
        $this->db->order_by('reimbursements_tbl.id','DESC');
        $this->db->select("reimbursements_tbl.*,staff_tbl.pic,staff_tbl.staff_name,staff_tbl.email,department_tbl.department_name");
        $this->db->from("reimbursements_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=reimbursements_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_department_byID($id)
    {

        $this->db->where('id',$id);
        $qry=$this->db->get('department_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_reimbursement_byStaffID($staffid)
    {
        $this->db->order_by('reimbursements_tbl.id','DESC');
        $this->db->where('reimbursements_tbl.staff_id',$staffid);
        $this->db->select("reimbursements_tbl.*,staff_tbl.staff_name,department_tbl.department_name");
        $this->db->from("reimbursements_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=reimbursements_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_reimbursement_forApprove()
    {
        $this->db->where('reimbursements_tbl.status',0);
        $this->db->select("reimbursements_tbl.*,staff_tbl.pic,staff_tbl.staff_name,reimbursements_tbl.amount,reimbursements_tbl.reason,reimbursements_tbl.applied_on,reimbursements_tbl.updated_on,department_tbl.department_name, salary_tbl.basic_salary, salary_tbl.allowance, salary_tbl.reimbursement, salary_tbl.total");
        $this->db->select("staff_tbl.id as 'staff_id'");
        $this->db->from("reimbursements_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=reimbursements_tbl.staff_id');
        $this->db->join("salary_tbl",'salary_tbl.staff_id=reimbursements_tbl.staff_id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function delete_department($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("department_tbl");
        $this->db->affected_rows();
    }

    

    function update_reimbursement($data, $id, $amount, $staff)
    {
        $this->db->where('id', $id);
        $this->db->update('reimbursements_tbl',$data);
        $this->db->where('staff_id', $staff);
        $this->db->update('salary_tbl',$amount);
        $this->db->affected_rows();
    }

    




}
