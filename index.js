const togle_menu=document.querySelector('.toggle_menu');
const menu=document.querySelector('.menu');

togle_menu.addEventListener('click',()=>{
    togle_menu.classList.toggle('fa-times');
    menu.classList.toggle('menu-active');    
})