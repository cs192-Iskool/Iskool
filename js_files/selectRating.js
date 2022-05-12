function choose_rating(id){
    for(let i = 0; i < parseInt(id[4]); i++){
        document.getElementById("star".concat(String(i + 1))).src = "images/filledStar.png";
    }
    for(let i = parseInt(id[4]); i < 5; i++){
        document.getElementById("star".concat(String(i + 1))).src = "images/emptyStar.png";
    }
    document.getElementById("submit_rating").value = parseInt(id[4]);
}