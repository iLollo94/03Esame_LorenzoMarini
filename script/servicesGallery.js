/**
 * Script to manage the services gallery (infinite scroll carousel)
*/

// Elements
const galleryEl = document.querySelector('div.gallery-container');
const dotContainerEl = document.querySelector('div.dot-container');
const nextBtn = document.getElementById('next');
const prevBtn = document.getElementById('prev');
const slides = document.getElementsByClassName('services-item');
const dots = document.getElementsByClassName('dot');

// variables
let slideIndex = 1;

// Set display: block only for the first image
if (slideIndex === 1) {
    let currentSlide = slides[slideIndex - 1];
    currentSlide.style.visibility = 'visible';

    let currentDot = dots[slideIndex - 1];
    currentDot.classList.add('active')
}

// Function to change current slide by clicking on DOTS
const setSlide = (n) => {
    slides[slideIndex - 1].style.visibility = 'hidden';
    dots[slideIndex - 1].classList.remove('active');

    slideIndex = n;

    let currentSlide = slides[slideIndex - 1];
    currentSlide.style.visibility = 'visible';

    let currentDot = dots[slideIndex - 1];
    currentDot.classList.add('active')
}

// Next slide event listener and function
nextBtn.addEventListener('click', (e) => {
    slides[slideIndex - 1].style.visibility = 'hidden';
    dots[slideIndex - 1].classList.remove('active');

    slideIndex += 1;

    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    let currentSlide = slides[slideIndex - 1];
    currentSlide.style.visibility = 'visible';

    let currentDot = dots[slideIndex - 1];
    currentDot.classList.add('active')
});

// Previous slide event listener and function
prevBtn.addEventListener('click', (e) => {
    slides[slideIndex - 1].style.visibility = 'hidden';
    dots[slideIndex - 1].classList.remove('active');

    slideIndex -= 1;

    if (slideIndex < 1) {
        slideIndex = slides.length;
    }

    let currentSlide = slides[slideIndex - 1];
    currentSlide.style.visibility = 'visible';

    let currentDot = dots[slideIndex - 1];
    currentDot.classList.add('active')
})

// Dots event listener to change slide
for (let i = 0; i < dots.length; i++) {
    const element = dots[i];
    element.addEventListener('click', (e) => {
        let n = e.target.dataset.id;
        setSlide(n);
    })
}