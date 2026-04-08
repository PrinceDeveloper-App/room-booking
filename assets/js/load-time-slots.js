// Load the time slots
function loadSlots(date) {
  const baseURL = document.querySelector('meta[name = "base-url"]').content;
  $.ajax({
    url: baseURL + "Booking/getSlots",
    type: "GET",
    data: {
      date: date,
    },
    dataType: "json",
    beforeSend: function () {
      $("#slotContainer").html(`
                <div class="text-center w-100">
                    <div class="spinner-border text-primary"></div>
                </div>
            `);
    },
    success: function (response) {
      renderSlots(response);
    },
    error: function () {
      alert("Error loading slots");
    },
  });
}

// Get today's date (YYYY-MM-DD)
let today = new Date().toISOString().split("T")[0];

// Set date input value
$("#booking_date").val(today);

// Load slots for today
loadSlots(today);

// Reload when user changes date
$("#booking_date").on("change", function () {
  let selectedDate = $(this).val();
  loadSlots(selectedDate);
});

// Display the slots in slot container
function renderSlots(slots) {
  let container = $("#slotContainer");
  container.html(""); // Clear previous slots

  let selectedDate = $("#booking_date").val();
  let now = new Date();

  $.each(slots, function (index, slot) {
    let slotDateTime = new Date(slot.full_time);

    let isPast = false;

    // Check if selected date is today
    if (selectedDate === now.toISOString().split("T")[0]) {
      if (slotDateTime <= now) {
        isPast = true;
      }
    }

    let isBooked = slot.booked;
    let disabled = isBooked || isPast;

    let slotClass = disabled ? "bg-secondary" : "bg-success";

    let label = isBooked ? "Booked" : isPast ? "Expired" : "Available";

    let div = $(`
            <div class="p-3 text-center text-white rounded ${slotClass}">
                ${slot.time}
                <div class="small">${label}</div>
            </div>
        `);

    if (!disabled) {
      div.css("cursor", "pointer");

      div.on("click", function () {
        $(".slot-selected").removeClass("slot-selected");
        $(this).addClass("slot-selected");
        $("#start_time").val(slot.full_time);
      });
    } else {
      div.css("opacity", "0.6");
    }

    container.append(div);
  });
  let firstAvailable = container.find(".bg-success").first();
  if (firstAvailable.length) {
    firstAvailable.click();
  }
}
