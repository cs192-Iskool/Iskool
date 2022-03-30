
function sortbyClick(){
    document.getElementById("dropdownContainer").classList.toggle("show");
}

var input = document.getElementById("search");
input.addEventListener("keyup", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
    document.getElementById("search_ad").click();
  }
});