<!DOCTYPE html>
<html>

<head>
    <title>Room Booking</title>
    <meta name="base-url" content="<?php echo base_url(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/custom.css">
</head>

<body class="container mt-4">

    <h4>Create Booking</h4>

    <form id="bookingForm">
        <div class="container">
            <!-- First row: Name & Purpose -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-6">
                    <input name="purpose" class="form-control" placeholder="Purpose">
                </div>
            </div>

            <!-- Second row: Date & Start Time -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <input type="date" id="booking_date" value="<?php echo $date; ?>" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div id="slotContainer" class="d-grid gap-2 mt-3"
                        style="grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));">
                    </div>
                </div>
            </div>
            <!-- Third row: Duration -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <select name="duration" class="form-control">
                        <option value="1">1 hour</option>
                        <option value="2">2 hours</option>
                        <option value="3">3 hours</option>
                        <option value="4">4 hours</option>
                        <option value="5">5 hours</option>
                        <option value="6">6 hours</option>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <!-- Show info -->
                    <small class="text-muted">Choose how long you want to book</small>
                </div>
            </div>

            <!-- Hidden combined field for start time -->
            <input type="hidden" name="start_time" id="start_time">

            <!-- Submit button -->
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-success w-100">Book</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Response Message DIV -->
    <div id="message" class="mx-auto mt-3"></div>

    <!-- Cancelation link DIV -->
    <div id="cancelBox" class="mx-auto mt-3 p-3 border rounded text-center d-none" style="max-width: 500px;">

        <div class="mb-2 fw-bold text-danger">
            ⚠️ Save this cancellation link
        </div>

        <input type="text" id="cancelLink" class="form-control mb-2 text-center" readonly>

        <button id="copyBtn" class="btn btn-outline-primary">
            <i class="fa fa-copy"></i> Copy Link
        </button>

        <div class="mt-2 small text-muted">
            This link will disappear after you copy it.
        </div>
    </div>
    <hr>

    <!-- Cancel Booking Area -->
    <div id="cancelArea" class="mx-auto mt-4 p-3 border rounded text-center" style="max-width: 500px;">

        <div class="fw-bold mb-2 text-danger">
            Cancel Booking
        </div>

        <!-- Paste Link Field -->
        <input type="text" id="cancel_input" class="form-control mb-2 text-center" placeholder="Paste your cancellation link here">

        <!-- Paste Button -->
        <button type="button" id="pasteBtn" class="btn btn-outline-secondary mb-2">
            <i class="fa fa-paste"></i> Paste Link
        </button>

        <!-- Cancel Button -->
        <button type="button" class="btn btn-danger w-100 cancel-btn">
            Cancel Booking
        </button>

        <!-- Message -->
        <div id="cancelMessage" class="mt-2 small text-muted"></div>

    </div>
    <hr>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="<?= base_url('assets/js/date-picker-bounds.js') ?>"></script>
    <script src="<?= base_url('assets/js/load-time-slots.js') ?>"></script>
    <script src="<?= base_url('assets/js/booking.js') ?>"></script>
    <script src="<?= base_url('assets/js/paste-link.js') ?>"></script>
    <script src="<?= base_url('assets/js/cancel-booking.js') ?>"></script>
</body>

</html>