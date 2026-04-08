// Extract token from link
function extractToken(link) {
  // If it's a full URL, get last part
  if (link.includes("/")) {
    let parts = link.split("/");
    return parts.pop();
  }
  return link; // already token
}

// Cancel button action
$(".cancel-btn").on("click", function () {
  let link = $("#cancel_input").val().trim();

  if (!link) {
    $("#cancelMessage").html(
      '<span class="text-danger">Please paste a valid link</span>',
    );
    return;
  }

  let token = extractToken(link);

  if (!confirm("Are you sure you want to cancel this booking?")) {
    return;
  }

  cancelBooking(token);
});

// Booking Cancelation
function cancelBooking(token) {
  const baseURL = document.querySelector('meta[name = "base-url"]').content;
  $.ajax({
    url: baseURL + "Booking/cancel/" + token,
    type: "GET",
    dataType: "json",
    beforeSend: function () {
      $("#cancelMessage").html('<span class="text-muted">Processing...</span>');
    },
    success: function (res) {
      if (res.status === "success") {
        $("#cancelMessage").html(
          '<span class="text-success">Booking cancelled successfully ✅</span>',
        );
        $("#cancel_input").val("");
        // Reset form + reload slots
        resetBookingForm();
      } else {
        $("#cancelMessage").html(
          '<span class="text-danger">' + res.message + "</span>",
        );
      }
    },
    error: function () {
      $("#cancelMessage").html('<span class="text-danger">Server error</span>');
    },
  });
}

// Reset booking form after AJAX success
function resetBookingForm() {
  // Reset input fields
  $("#bookingForm")[0].reset();

  // Clear hidden start_time
  $("#start_time").val("");

  // Set today again
  let today = new Date().toISOString().split("T")[0];
  $("#booking_date").val(today);

  // Reload slots for today
  loadSlots(today);

  // Optional: clear selection styling
  $(".slot-selected").removeClass("slot-selected");
}
