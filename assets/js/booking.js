// Booking form submit function
$("#bookingForm").submit(function (e) {
  e.preventDefault();
  const baseURL = document.querySelector('meta[name = "base-url"]').content;
  $.post(
    baseURL + "Booking/create",
    $(this).serialize(),
    function (res) {
      if (res.status) {
        $("#message").html(
          '<div class="alert alert-success">' + res.message + "</div>",
        );
        showCancelLink(res.token);
        // Reset form + reload slots
        resetBookingForm();
      } else {
        $("#message").html(
          '<div class="alert alert-danger">' + res.message + "</div>",
        );
      }
    },
    "json",
  );
});

// Show Cancelation link after booking success
function showCancelLink(token) {
  document.getElementById("cancelLink").value =
    "http://localhost:8080/room-booking/booking/cancel/" + token;
  document.getElementById("cancelBox").classList.remove("d-none");
}

// Copy link functionality
document.getElementById("copyBtn").addEventListener("click", function () {
  const input = document.getElementById("cancelLink");

  input.select();
  input.setSelectionRange(0, 99999);

  navigator.clipboard.writeText(input.value);

  // copied indication
  this.innerHTML = '<i class="fa fa-check"></i> Copied';

  // Hide after 1 second
  setTimeout(() => {
    document.getElementById("cancelBox").style.display = "none";
  }, 1000);
});

// Reset booking form aftre form submit success
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

  // clear selected slot
  $(".slot-selected").removeClass("slot-selected");
}
