function show_dropdown(){
    document.getElementById("dropdown_elements").classList.toggle("disp");
}

function show_notifs(){
    document.getElementById("notifs").classList.toggle("disp");
}

window.onclick = function(event){
    if(event.target.id != "dropdown_elements" && event.target.id != "dropdown"){
        var dropdown_popup = document.getElementById("dropdown_elements");
        if(dropdown_popup.classList.contains("disp")){
            dropdown_popup.classList.remove("disp");
        }
    }
    if(event.target.id != "notifs" && event.target.id != "notifs_list"){
        var notif_popup = document.getElementById("notifs");
        if(notif_popup.classList.contains("disp")){
            notif_popup.classList.remove("disp");
        }
    }
    if(!event.target.matches(".dropbtn")){
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for(i = 0; i < dropdowns.length; i++){
            var openDropdown = dropdowns[i];
            if(openDropdown.classList.contains("show")){
                openDropdown.classList.remove("show");
            }
        }
    }
}