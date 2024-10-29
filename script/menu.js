/**
 * Script to manage the visibility of the side menu
*/

// Doc elems
const menuShowBtn = document.getElementById('menu-button');
const menuHideBtn = document.getElementById('menu-close-button');
const menuElem = document.querySelector('nav');

const showMenu = () => {
    menuElem.classList.remove('hidden');
}

const hideMenu = () => {
    menuElem.classList.add('hidden');
}

menuShowBtn.addEventListener('click', showMenu);
menuHideBtn.addEventListener('click', hideMenu);