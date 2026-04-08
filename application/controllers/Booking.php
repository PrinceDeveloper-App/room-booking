<?php
class Booking extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->library('BookingService');
    }
    // Fetch Booking By Date
    public function index()
    {
        $date = $this->input->get('date') ?? date('Y-m-d');

        $data['date'] = $date;
        $data['bookings'] = $this->Booking_model->getByDate($date);
        $this->load->view('booking_view', $data);
    }
    // Get Time Slots
    public function getSlots()
    {
        $date = $this->input->get('date');

        $bookings = $this->Booking_model->getByDate($date);

        $slots = [];

        for ($h = 7; $h < 21; $h++) {
            $start = "$date " . str_pad($h, 2, '0', STR_PAD_LEFT) . ":00:00";
            $end   = "$date " . str_pad($h + 1, 2, '0', STR_PAD_LEFT) . ":00:00";

            $booked = false;

            foreach ($bookings as $b) {
                if ($start < $b['end_time'] && $end > $b['start_time']) {
                    $booked = true;
                    break;
                }
            }

            $slots[] = [
                'time' => "$h:00 - " . ($h + 1) . ":00",
                'full_time' => $start,
                'booked' => $booked
            ];
        }

        echo json_encode($slots);
    }
    // Create Bookings
    public function create()
    {
        $response = $this->bookingservice->createBooking($this->input->post());

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    // Cancel Booking By Token
    public function cancel($token)
    {
        
        if (!$token) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid token']);
            return;
        }

        $deleted = $this->Booking_model->deleteByToken($token);

        if ($deleted) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Booking not found']);
        }
    }
}
