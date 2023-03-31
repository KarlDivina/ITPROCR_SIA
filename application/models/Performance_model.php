<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_model extends CI_Model {


    function insert_staff($data)
    {
        $this->db->insert("staff_tbl",$data);
        return $this->db->insert_id();
    }

    function select_staff()
    {
        $this->db->order_by('performance_tbl.id','DESC');
        $this->db->select("performance_tbl.*,staff_tbl.id, staff_tbl.pic, staff_tbl.email, staff_tbl.doj, department_tbl.department_name");
        $this->db->from("performance_tbl");
        $this->db->join("staff_tbl",'performance_tbl.id=staff_tbl.id');
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_staff_byID($id)
    {
        $this->db->where('performance_tbl.id',$id);
        $this->db->select("performance_tbl.*, staff_tbl.id, department_tbl.department_name");
        $this->db->from("performance_tbl");
        $this->db->join("staff_tbl",'staff_tbl.id=performance_tbl.id');
        $this->db->join("department_tbl",'department_tbl.id=performance_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_staff_byEmail($email)
    {

        $this->db->where('email',$email);
        $qry=$this->db->get('staff_tbl');
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }

    function select_staff_byDept($dpt)
    {
        $this->db->where('staff_tbl.department_id',$dpt);
        $this->db->select("staff_tbl.*,department_tbl.department_name");
        $this->db->from("staff_tbl");
        $this->db->join("department_tbl",'department_tbl.id=staff_tbl.department_id');
        $qry=$this->db->get();
        if($qry->num_rows()>0)
        {
            $result=$qry->result_array();
            return $result;
        }
    }


    function delete_staff($id)
    {
        $this->db->where('id', $id);
        $this->db->delete("staff_tbl");
        $this->db->affected_rows();
    }

    
    function update_performance($data,$id)
    {
        $this->db->where('id', $id);
        $this->db->update('performance_tbl',$data);
        $this->db->affected_rows();
    }

    

    
    




}
