// ###################################################################
// ################### FILTER SELECTION SCRIPT #######################
// ###################################################################
// Elements
const selectInput = document.querySelector('select#filter-select');
const optionElements = selectInput.options;

// Variables
const url = new URL(window.location)

/**
 * Function to pass filter as URL parameter
*/
const setFilter = () => {
    // Get selected value to pass as search param
    let value = selectInput.value;
    // Get search params from URL
    let urlParams = new URLSearchParams(url.search);
    // Eventually delete old filter value if present in search params
    urlParams.delete('filter');
    // Set search param filter to selected value
    urlParams.append('filter', value);
    // Navigate to new URL, with filter search param added to the params
    window.location.href = url.pathname + '?' + urlParams.toString();
}

// ###################################################################
// ################### PROJECT DETAILS TOGGLE ########################
// ###################################################################
// Elements
const projectCards = document.querySelectorAll('div.project-card');

/**
 * Function to pass project ID as UR parameter
*/
const openProject = (e) => {
    // Get clicked card id to pass as search param
    let projectId = e.currentTarget.dataset.id;
    // Get search params from URL
    let urlParams = new URLSearchParams(url.search);
    // Eventually delete old projectID value if present in search params
    urlParams.delete('projectID');
    // Set search param filter to selected value
    urlParams.append('projectID', projectId);
    // Navigate to new URL, with filter search param added to the params
    window.location.href = url.pathname + '?' + urlParams.toString();
}

/**
 * Function to close project details
*/
const closeProject = () => {
    // Get search params from URL
    let urlParams = new URLSearchParams(url.search);
    // Delete old projectID value
    urlParams.delete('projectID');
    // Navigate to new URL, with filter search param added to the params
    window.location.href = url.pathname + '?' + urlParams.toString();
}

// Init for filtering script
if (!url.searchParams.has('filter')) {
    optionElements[0].setAttribute('selected', '');
} else {
    for (let i = 0; i < optionElements.length; i++) {
        if (optionElements[i].value == url.searchParams.get('filter')) {
            optionElements[i].setAttribute('selected', '');
        }
    }
}
selectInput.addEventListener('change', setFilter); // Select change event handler

// Init for project details script
for (let i = 0; i < projectCards.length; i++) { // Click event handler
    projectCards[i].addEventListener('click', (e) => {
        openProject(e);
    })
}

if (url.searchParams.has('projectID')) {
    const closeBtn = document.querySelector('div.project-details-close');
    closeBtn.addEventListener('click', closeProject);
}