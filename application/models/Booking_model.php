<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends CI_Model
{

    protected $table = 'bookings';

    // Get Bookings
    public function getByDate($date)
    {
        $this->db->like('start_time', $date, 'after');
        return $this->db->get($this->table)->result_array();
    }

    // Check Slot Availabilty
    public function isSlotAvailable($start, $end)
    {
        $this->db->where('start_time <', $end);
        $this->db->where('end_time >', $start);
        return $this->db->count_all_results($this->table) == 0;
    }
    // Check Overlapping to avoid duplication(For API)
    public function isOverlapping($start, $end)
    {
        $this->db->where("start_time <", $end);
        $this->db->where("end_time >", $start);
        return $this->db->get('bookings')->num_rows() > 0;
    }
    // Create Bookings
    public function create($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Delete Booking Using Secure Unique Token
    public function deleteByToken($token)
    {
        return $this->db->where('cancel_token', $token)->delete($this->table);
    }
}
