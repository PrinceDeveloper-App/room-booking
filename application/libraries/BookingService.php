<?php
class BookingService {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Booking_model');
    }
    // Create Booking
    public function createBooking($data)
    {
        // Validation
        if (empty($data['name'])) {
            return ['status' => false, 'message' => 'Name is required'];
        }

        $start = strtotime($data['start_time']);
        $end   = strtotime("+{$data['duration']} hours", $start);

        if ($data['duration'] < 1 || $data['duration'] > 6) {
            return ['status' => false, 'message' => 'Invalid duration'];
        }

        if ($start < time()) {
            return ['status' => false, 'message' => 'Cannot book past'];
        }

        if ($start > strtotime('+7 days')) {
            return ['status' => false, 'message' => 'Max 7 days ahead'];
        }

        if (!$this->CI->Booking_model->isSlotAvailable(date('Y-m-d H:i:s',$start), date('Y-m-d H:i:s',$end))) {
            return ['status' => false, 'message' => 'Slot already booked'];
        }

        $token = bin2hex(random_bytes(16));

        $this->CI->Booking_model->create([
            'name' => htmlspecialchars($data['name']),
            'purpose' => htmlspecialchars($data['purpose']),
            'start_time' => date('Y-m-d H:i:s',$start),
            'end_time' => date('Y-m-d H:i:s',$end),
            'cancel_token' => $token
        ]);

        return [
            'status' => true,
            'message' => 'Booking successful',
            'token' => $token
        ];
    }
}