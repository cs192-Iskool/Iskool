// for changing profile picture
function change_prof_pic(){
    document.getElementById("prof_pic_dropdown").classList.toggle("popup");
}

// for delete button

const delete_button = document.getElementById("open_delete_message")
const delete_overlay = document.getElementById("delete_overlay")
const msg = document.getElementById("delete_popup")
const cancel = document.getElementById("close_delete_message")
const proceed = document.getElementById("continue_delete")

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
