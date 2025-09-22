var burger = document.querySelector('.burger');
var navList = document.querySelector('.nav-list');
var navbar = document.querySelector('.navbar');

function openBurger(){
    navList.classList.toggle('v-class-resp');
    navbar.classList.toggle('h-nav-resp');
}