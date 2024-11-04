<?php
ini_set("auto_detect_line_endings", true);

// Function file include
require_once('./data/CLASSE_Utility.php');

use LMWebDev2\Utility as UT;

require_once('./data/static_functions.php');

// Page data variables definition
$title = "LM Web Dev";
switch (UT::richiestaHTTP('page')) {
    case 'portfolio':
        $title .= " Portfolio";
        break;
    case 'contacts':
        $title .= " Contatti";
        break;
    case 'privacy' || 'cookie':
        $title .= " Policy";
        break;
}
$favicon = "./img/favicon.ico";
$css = ["./scss/css/style.min.css"];
switch (UT::richiestaHTTP('page')) {
    case 'portfolio':
        array_push($css, "./scss/css/portfolio.min.css");
        break;
    case 'contacts':
        array_push($css, "./scss/css/contacts.min.css");
        break;
    case 'privacy' || 'cookie':
        array_push($css, "./scss/css/policies.min.css");
        break;
    default:
        array_push($css, "./scss/css/homepage.min.css");
        break;
}
$fonts = null;
$icons = '<script src="https://kit.fontawesome.com/52873a7024.js" crossorigin="anonymous"></script>';

// HTML print (Doctype, html tag, head, body opening)
echo printHTMLData($title, $css, $fonts, $favicon, $icons);

// Body
echo printHeader();
echo printMenu();

// Main (depends on the query string)
switch (UT::richiestaHTTP('page')) {
    case 'portfolio':
        require_once('./data/portfolio_functions.php');
        echo printPortfolio();
        break;
    case 'contacts':

        break;
    case 'privacy':

        break;
    case 'cookie':

        break;
    default:
        require_once('./data/homepage_functions.php');
        echo printHomepage();
        break;
}

echo printFooter();

// HTML end-page
echo printHTMLEndPage();
