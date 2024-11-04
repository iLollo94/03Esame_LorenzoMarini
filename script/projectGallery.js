// Elements 
const carouselContainer = document.querySelector('div.project-gallery');
const slideWrapper = document.querySelector('div.project-gallery-container');
const slides = document.querySelectorAll('div.image-container');
const navdotWrapper = document.querySelector('div.dot-container');
const navdots = document.querySelectorAll('span.dot');
const prevBtn = document.querySelector('span#prev');
const nextBtn = document.querySelector('span#next');

// Params
const n_slides = slides.length;
let spaceBtwSlides = Number(window.getComputedStyle(slideWrapper).getPropertyValue('column-gap').slice(0, -2)); // slice to remove 'px' at the end

/**
 * Function to compute the index of the slide shown
 * based on the position of the slideWrapper scroll
 * and activate the correct span.dot
*/
const index_slideCurrent = () => {
    let slideWidth = slides[0].offsetWidth;

    return Math.round(slideWrapper.scrollLeft / (slideWidth + spaceBtwSlides));
}

// Nav dot click handler and prev/next buttons click handler
const goto = (index) => {
    let slideWidth = slides[0].offsetWidth;

    slideWrapper.scrollTo((slideWidth + spaceBtwSlides) * index, 0);
}
const next = () => {
    goto(index_slideCurrent() + 1);
}
const prev = () => {
    goto(index_slideCurrent() - 1)
}
for (let i = 0; i < n_slides; i++) {
    navdots[i].addEventListener('click', () => goto(i));
}
prevBtn.addEventListener('click', () => {
    if (index_slideCurrent() != 0) {
        prev();
    }
});
nextBtn.addEventListener('click', () => {
    if (index_slideCurrent() != (n_slides - 1)) {
        next();
    }
});

/**
 * Function to mark current dot as active
*/
const markNavdot = (index) => {
    navdots[index].classList.add('active');
}
const updateNavdot = () => {
    const c = index_slideCurrent();
    if (c < 0 || c >= n_slides) {
        return;
    }
    markNavdot(c);
}

slideWrapper.addEventListener('scroll', () => {
    // Reset navdot mark
    navdots.forEach(navdot => {
        navdot.classList.remove('active');
    });

    // Mark navdot
    updateNavdot();
})

// Init
markNavdot(0);
slideWrapper.classList.add('smooth-scroll');