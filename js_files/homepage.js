
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

function show_thumbnail(id) {
  const pic_overlay = document.getElementById("pic_overlay");
  const pic = document.getElementById("pic");
  const view_pic = document.getElementById(id);

  pic_overlay.classList.add("active");
  pic.style.display = "block";
  pic.src = view_pic.src;

  pic_overlay.addEventListener("click", () => {
      pic_overlay.classList.remove("active");
      pic.style.display = "none";
})
}