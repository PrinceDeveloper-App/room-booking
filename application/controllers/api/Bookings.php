<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        header('Content-Type: application/json');
    }
    // ✅ GET: Fetch bookings by date
    public function index()
    {

        $date = $this->input->get('date');

        if (!$date) {
            echo json_encode(['status' => 'error', 'message' => 'Date required']);
            return;
        }

        $data = $this->Booking_model->getByDate($date);

        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }
    // Create booking
    public function create()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $this->input->post();
        }

        $name       = $input['name'] ?? null;
        $start_time = $input['start_time'] ?? null;
        $duration   = $input['duration'] ?? null;

        if (!$name || !$start_time || !$duration) {
            echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
            return;
        }

        // Check date constraints
        $today = strtotime(date('Y-m-d H:i:s'));
        $start_ts = strtotime($start_time);
        $max_ts = strtotime('+7 days', $today);

        if ($start_ts < $today) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot book in the past']);
            return;
        }
        if ($start_ts > $max_ts) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot book more than 7 days in advance']);
            return;
        }

        $end_time = date('Y-m-d H:i:s', strtotime($start_time . " +$duration hour"));
        $cancel_token = bin2hex(random_bytes(16));

        if ($this->Booking_model->isOverlapping($start_time, $end_time)) {
            echo json_encode(['status' => 'error', 'message' => 'Slot already booked']);
            return;
        }

        $data = [
            'name' => $name,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'cancel_token' => $cancel_token
        ];

        $inserted = $this->Booking_model->create($data);

        if ($inserted) {
            echo json_encode([
                'status' => 'success',
                'cancel_link' => base_url("booking/cancel/$cancel_token")
            ]);
        } else {
            $error = $this->db->error();
            echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $error['message']]);
        }
    }

    // Cancel booking
    public function cancel($token = null)
    {
        if (!$token) {
            echo json_encode(['status' => 'error', 'message' => 'Missing token']);
            return;
        }

        $deleted = $this->Booking_model->cancelByToken($token);

        if ($deleted) {
            echo json_encode(['status' => 'success', 'message' => 'Booking cancelled']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or expired token']);
        }
    }
}
