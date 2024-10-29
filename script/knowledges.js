// Elements
const icons = document.querySelectorAll('div.known-icon');
const tooltips = document.querySelectorAll('div.known-icon-tooltip');

// Get mouse position
const getMousePosition = (e) => {
    const x = e.clientX;
    const y = e.clientY;

    return {
        left: x + window.scrollX,
        top: y + window.scrollY
    };
}

// Show tooltip (position based on mouse position)
const showTooltip = (e) => {
    const tooltipToShow = e.target.dataset.id;
    const tooltip = document.getElementById('tooltip-' + tooltipToShow);
    const deltaX = 20; // X-axis distance from mouse position
    const deltaY = -(tooltip.offsetHeight); // Y-axis distance from mouse position
    const screenWidth = window.screen.width;
    const tooltipWidth = tooltip.offsetWidth;
    tooltip.style.top = getMousePosition(e).top + deltaY + "px";
    if ((getMousePosition(e).left + tooltipWidth) < screenWidth) {
        tooltip.style.left = getMousePosition(e).left + deltaX + "px";
    } else {
        tooltip.style.left = getMousePosition(e).left - deltaX - tooltipWidth + "px";
    }
    tooltip.style.visibility = 'visible';
}

const hideTooltip = () => {
    for (let i = 0; i < tooltips.length; i++) {
        tooltips[i].style.visibility = 'hidden';
    }
}

// Init
hideTooltip();
for (let i = 0; i < icons.length; i++) {
    icons[i].addEventListener('mouseover', (e) => showTooltip(e));
    icons[i].addEventListener('mouseout', hideTooltip);
}