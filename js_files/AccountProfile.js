// for changing profile picture
function change_prof_pic(){
    document.getElementById("prof_pic_dropdown").classList.toggle("popup");
}

// for changing acc details
function validate() {
  let fname = document.getElementById("fname");
  let lname = document.getElementById("lname");
  let birthday = document.getElementById("birthday");
  let password = document.getElementById("password");
  let confPassword = document.getElementById("confPassword");

  var isAlpha = /^[A-Za-z\s]*$/;

  var dob = new Date(birthday.value);
  var diff = Date.now() - dob.getTime();
  var date_diff = new Date(diff);
  var age = date_diff.getUTCFullYear() - 1970;

  if (!(fname.value.match(isAlpha))) {
    alert("Error! Your first name is not valid.");
    return false;
  }

  if (!(lname.value.match(isAlpha))) {
    alert("Error! Your last name is not valid.");
    return false;
  }

  if(age < 16 || age > 26) {
    alert("Error! Please make sure you are a college student before creating an account.");
    return false;
  }

  if (password.value != confPassword.value) {
    alert("Error! Passwords do not match.");
    return false;
  }

  return true;
}

// for delete button

const delete_button = document.getElementById("open_delete_message")
const delete_overlay = document.getElementById("delete_overlay")
const msg = document.getElementById("delete_popup")
const cancel = document.getElementById("close_delete_message")
const proceed = document.getElementById("continue_delete")
if(delete_button){
  delete_button.addEventListener("click", () => {
      delete_overlay.classList.add("active")
      msg.classList.add("active")
  })

  proceed.addEventListener("click", () => {
      window.open("Login.html", "_self")
  })

  cancel.addEventListener("click", () => {
      delete_overlay.classList.remove("active")
      msg.classList.remove("active")
  })

  delete_overlay.addEventListener("click", () => {
      delete_overlay.classList.remove("active")
      msg.classList.remove("active")
  })
}

const image = document.getElementById("upload_pic");
if(image){
  image.onchange = function() {
    document.getElementById("submit_prof_pic").submit();
    document.getElementById("submit_prof_pic").reset();
  }
}