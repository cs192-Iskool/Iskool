// For clicking on upper-right corner

const dropdown = document.getElementById("dropdown")
const dropdown_overlay = document.getElementById("dropdown_overlay")
const dropdown_popup = document.getElementById("dropdown_popup")

dropdown.addEventListener("click", () => {
    dropdown_overlay.classList.add("active")
    dropdown_popup.classList.add("active")
})

dropdown_overlay.addEventListener("click", () => {
    dropdown_overlay.classList.remove("active")
    dropdown_popup.classList.remove("active")
})

// For deleting account

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
