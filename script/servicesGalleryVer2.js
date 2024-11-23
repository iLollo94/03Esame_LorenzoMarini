// Elements 
const carouselContainer = document.querySelector('div.services-gallery');
const slideWrapper = document.querySelector('div.gallery-container');
const slides = document.querySelectorAll('div.services-item');
const navdotWrapper = document.querySelector('div.dot-container');
const navdots = document.querySelectorAll('span.dot');
const prevBtn = document.querySelector('span#prev');
const nextBtn = document.querySelector('span#next');

// Params
const n_slides = slides.length;
const n_slidesCloned = 1; // For infinite scroll
let spaceBtwSlides = Number(window.getComputedStyle(slideWrapper).getPropertyValue('column-gap').slice(0, -2)); // slice to remove 'px' at the end
/**
 * Function to compute the index of the slide shown
 * based on the position of the slideWrapper scroll
 * and activate the correct span.dot
*/
const index_slideCurrent = () => {
    let slideWidth = slides[0].offsetWidth;

    return Math.round(slideWrapper.scrollLeft / (slideWidth + spaceBtwSlides) - n_slidesCloned);
}

// Nav dot click handler and prev/next buttons click handler
const goto = (index) => {
    let slideWidth = slides[0].offsetWidth;

    slideWrapper.scrollTo((slideWidth + spaceBtwSlides) * (index + n_slidesCloned), 0);
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
prevBtn.addEventListener('click', prev);
nextBtn.addEventListener('click', next);

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

// Handle scroll event
let scrollTimer;

slideWrapper.addEventListener('scroll', () => {
    let slideWidth = slides[0].offsetWidth;

    // Reset navdot mark
    navdots.forEach(navdot => {
        navdot.classList.remove('active');
    });

    if (scrollTimer) { // to cancel if scroll continues
        clearTimeout(scrollTimer);
    }
    scrollTimer = setTimeout(() => {
        if (slideWrapper.scrollLeft < (slideWidth + spaceBtwSlides) * (n_slidesCloned - 1 / 2)) {
            forward();
        }
        if (slideWrapper.scrollLeft > (slideWidth + spaceBtwSlides) * ((n_slides - 1 + n_slidesCloned) + 1 / 2)) {
            rewind();
        }
    }, 100)
    // Mark navdot
    updateNavdot();
})

// Update elements sizes as the browser window gets resized
let resizeTimer;
window.addEventListener('resize', () => {
    // let slideWidth = slides[0].offsetWidth;

    if (resizeTimer) {
        clearTimeout(resizeTimer);
    }
    stop();
    resizeTimer = setTimeout(() => {
        play();
    }, 400);

    // markNavdot(index_slideCurrent());
});

// INFINITE SCROLLING
// Duplicating slides
const firstSlideClone = slides[0].cloneNode(true);
slideWrapper.append(firstSlideClone);
const lastSlideClone = slides[n_slides - 1].cloneNode(true);
slideWrapper.prepend(lastSlideClone);

// Instant rewind and forward scroll (achieved removing and adding again the smooth scroll behaviour to the wrapper)
const rewind = () => {
    let slideWidth = slides[0].offsetWidth;

    slideWrapper.classList.remove('smooth-scroll');
    setTimeout(() => { // Wait for smooth scroll to be removed
        slideWrapper.scrollTo((slideWidth + spaceBtwSlides) * n_slidesCloned, 0);
        slideWrapper.classList.add('smooth-scroll');
    }, 100);
}
const forward = () => {
    let slideWidth = slides[0].offsetWidth;

    slideWrapper.classList.remove('smooth-scroll');
    setTimeout(() => { // Wait for smooth scroll to be removed
        slideWrapper.scrollTo((slideWidth + spaceBtwSlides) * (n_slides - 1 + n_slidesCloned), 0);
        slideWrapper.classList.add('smooth-scroll');
    }, 100);
}

// AUTOPLAY
const pause = 3000;
let itv;
const play = () => {
    // return if the user prefers reduced motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }
    clearInterval(itv);
    itv = setInterval(next, pause);
}
const stop = () => {
    clearInterval(itv);
}
// Start autoplay when carousel is full shown
const callback = (entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            play();            
        } else {
            stop();
        }
    })
}
const observer = new IntersectionObserver(callback, { threshold: 0.99 });
observer.observe(carouselContainer);
// Mouse user events
carouselContainer.addEventListener('pointerenter', stop);
carouselContainer.addEventListener('pointerleave', play);
// Keyboards events
carouselContainer.addEventListener('focus', stop, true);
carouselContainer.addEventListener('blur', () => {
    if (carouselContainer.matches(':hover')) {
        return;
    }
    play();
}, true);
// Touch events
carouselContainer.addEventListener('touchstart', stop);

// Init
goto(0);
markNavdot(index_slideCurrent());
slideWrapper.classList.add('smooth-scroll');