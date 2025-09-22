function burgerClass() {

    let navList = document.querySelector('.nav-list');
    let navbar = document.querySelector('.navbar');


    // if(navbar.style.height = "5rem"){
    //     navbar.style.height = "43rem";
    // }else{
    //     navbar.style.height = "5rem";
    // }

    navList.classList.toggle('v-class-resp');
    navbar.classList.toggle('h-nav-resp');

}

function showComputerOptions() {
    var computerOptions = document.getElementById("computerOptions");
    if (computerOptions.style.display === "none") {
        computerOptions.style.display = "block";
    } else {
        computerOptions.style.display = "none";
    }
}