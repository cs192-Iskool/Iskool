function validate() {
  let fname = document.getElementById("fname");
  let lname = document.getElementById("lname");
  let email = document.getElementById("email");
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

  if(!(email.value.endsWith("@up.edu.ph"))) {
    alert("Error! Your email address is not a valid UP account.");
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