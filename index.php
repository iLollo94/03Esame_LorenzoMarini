<?php
ini_set("auto_detect_line_endings", true);

// Function file include
require_once('./data/CLASSE_Utility.php');
use LMWebDev2\Utility as UT;
require_once('./data/functions.php');

use function PHPSTORM_META\type;

// Page data variables definition
$title = "LM Web Dev";
$favicon = "./img/favicon.ico";
$css = "./scss/css/style.min.css";
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
                echo printPortfolio();
                break;
            case 'contacts':

                break;
            case 'privacy':

                break;
            case 'cookie':

                break;
            default:
                echo printHomepage();
                break;
        }

    echo printFooter();

// HTML end-page
echo printHTMLEndPage();
?>