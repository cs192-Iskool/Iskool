// for toggling ad options

function show_ad_options(id) {
    document.getElementById("popup_".concat(id)).classList.toggle("show");
    document.getElementById("tn_".concat(id)).classList.toggle("adjust");
    document.getElementById("hr_".concat(id)).classList.toggle("adjust");
    document.getElementById("ai_".concat(id)).classList.toggle("adjust");
}

// for deleting ad

function show_delete_ad(id) {
    const delete_overlay = document.getElementById("delete_overlay");
    const msg = document.getElementById("delete_popup");
    const cancel = document.getElementById("close_delete_message");

    delete_overlay.classList.add("active");
    msg.classList.add("active");

    cancel.addEventListener("click", () => {
        delete_overlay.classList.remove("active");
        msg.classList.remove("active");
    })

    delete_overlay.addEventListener("click", () => {
        delete_overlay.classList.remove("active");
        msg.classList.remove("active");
})
}
