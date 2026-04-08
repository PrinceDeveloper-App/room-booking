// Ensure the chosen date is within allowed range for better UI experience
document.addEventListener("DOMContentLoaded", function () {
  const dateInput = document.getElementById("booking_date");

  const today = new Date();

  // Format date to YYYY-MM-DD
  function formatDate(date) {
    return date.toISOString().split("T")[0];
  }

  // Min = today
  const minDate = formatDate(today);

  // Max = today + 7 days
  const max = new Date();
  max.setDate(today.getDate() + 7);
  const maxDate = formatDate(max);

  // Apply to input
  dateInput.setAttribute("min", minDate);
  dateInput.setAttribute("max", maxDate);
});
