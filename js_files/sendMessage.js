var input = document.getElementById("message");
input.addEventListener("keyup", function(event) {
  if (event.key === "Enter" && !event.shiftKey) {
    event.preventDefault();
    document.getElementById("send_message").click();
  }
});