var input = document.getElementById("message");
input.addEventListener("keyup", function(event) {
  if (event.key === "Enter" && !event.shiftKey) {
    if (input.value.length <= 1) {
      input.value = "";
      return;
    }
    event.preventDefault();
    document.getElementById("send_message").click();
  }
});