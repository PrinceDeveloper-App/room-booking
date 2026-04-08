// Paste from clipboard
$("#pasteBtn").on("click", function () {
  navigator.clipboard
    .readText()
    .then((text) => {
      $("#cancel_input").val(text);
    })
    .catch((err) => {
      alert("Clipboard access denied");
    });
});
