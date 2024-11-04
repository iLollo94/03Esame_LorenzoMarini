<?php
// #################################################################################################################
// #######   HTML and DB FUNCTIONS   ###############################################################################
// #################################################################################################################

// DB Connection (PDO)
require_once('./data/db_connection.php');
try {
    $pdo = new PDO("mysql:host=" . INDIRIZZO . ";dbname=" . DB, UTENTE, PASSWORD);
} catch (PDOException $e) {
    die("Errore " . $e->getCode() . ": " . $e->getMessage());
}

// Require Itility class
require_once('./data/CLASSE_Utility.php');
use LMWebDev2\Utility as UT;

// #######   HTML DATA FUNCTIONS ####################################################################################

/**
 * Function to print the html page data (DOCTYPE, HTML OPENING TAG, HEAD, BODY OPENING TAG)
 * 
 * @param string $title Website title to show on tab
 * @param array|string $css Link to CSS file(s)
 * @param string $fonts HTML Embed Code for fonts include
 * @param string $favicon Link to favicon.ico
 * @param string $icons Link to icons script
 * 
 * @return string
 */
function printHTMLData($title, $css, $fonts = null, $favicon = null, $icons = null)
{
    $str = '<!DOCTYPE html>';
    $str .= '<html lang="it">';
    $str .= '<head>';
    $str .= '<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="description" content="Lorenzo Marini Web Developer">'; // Metadata
    $str .= sprintf('<title>%s</title>', $title); // Title
    if (is_array($css)) {
        foreach ($css as $link) {
            $str .= sprintf('<link rel="stylesheet" href="%s">', $link); // CSS link
        }
    } else {
        $str .= sprintf('<link rel="stylesheet" href="%s">', $css); // CSS link
    }
    if ($favicon != null) {
        $str .= sprintf('<link rel="shortcut icon" href="%s" type="image/x-icon">', $favicon); // Favicon
    }
    if ($icons != null) {
        $str .= $icons; // Icons
    }
    if ($fonts != null) {
        $str .= $fonts; // Fonts
    }
    $str .= '</head>';
    $str .= '<body>';

    return $str;
}

/**
 * Function to print the html end page (BODY CLOSING TAG, HTML CLOSING TAG)
 * 
 * @return string
 */
function printHTMLEndPage()
{
    $str = '</body></html>';

    return $str;
}
// #################################################################################################################
// #######   STATIC ELEMENTS FUNCTIONS (Header, Nav, Footer) #######################################################
// #################################################################################################################

/**
 * Function to print html header (Logo, Title, Menu button)
 */
function printHeader()
{
    global $pdo;
    $str = '';
    $queryStr = 'SELECT
                    *
                 FROM
                    header
                 WHERE
                    cancellato = 0
                 ORDER BY
                    posizione';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $array = $query->fetchAll(PDO::FETCH_ASSOC);

        $str .= '<header>';
        foreach ($array as $item) {
            if ($item['tipo'] == "Logo") {
                $str .= sprintf('<div class="logo"><img src="%s" title="%s" alt="%s"></div>', $item['url'], $item['nome'], $item['tipo']);
            } elseif ($item['tipo'] == "Testo") {
                $str .= sprintf('<div class="title"><h1>%s</h1></div>', $item['testo']);
            } elseif ($item['tipo'] == "Menu") {
                $str .= sprintf('<div class="menu-button"><a href="%s" title="%s" id="menu-button"><i class="%s"></i></a></div>', $item['url'], $item['nome'], $item['testo']);
            }
        }
        $str .= '</header>';

        return $str;
    }
}

/**
 * Function to print html nav menu
 */
function printMenu()
{
    global $pdo;
    $str = '<nav class="hidden">';
    $str .= '<div class="menu-close"><a href="javascript:void(0)" title="Chiudi menu" id="menu-close-button"><i class="fa-solid fa-xmark"></i></a></div>';

    // Select and print only menu items
    $queryStr = 'SELECT
                    *
                 FROM
                    menu
                 WHERE
                    cancellato = 0
                    AND sezione = "Menu"
                 ORDER BY
                    posizione';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        $str .= '<ul class="menu-main">';
        // Print menu items
        foreach ($array as $link) {
            $str .= sprintf('<li class="menu-item"><a href="%s" title="%s">%s</a></li>', $link['url'], $link['nome'], $link['titolo']);
        }
        $str .= '</ul>';
    }

    // Select and print only social links
    $queryStr = 'SELECT
                    *
                 FROM
                    recapitiIndirizzi
                 WHERE
                    cancellato = 0
                    AND tipo = "Socials"';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        $str .= '<ul class="menu-socials">';
        // Print social links
        foreach ($array as $link) {
            $str .= sprintf('<li class="social-link"><a href="%s" title="%s"><img src="%s" alt="%s" title="%s" width="40" height="40"></a></li>', $link['url'], $link['nome'], $link['logo'], $link['nome'], $link['testo']);
        }
        $str .= '</ul>';
    }

    // Select and print only policies links
    $queryStr = 'SELECT
                    *
                 FROM
                    menu
                 WHERE
                    cancellato = 0
                    AND sezione = "Policy"
                 ORDER BY
                    posizione';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        $str .= '<ul class="menu-policies">';
        // Print policy links
        foreach ($array as $link) {
            $str .= sprintf('<li class="policy-link"><a href="%s" title="%s">%s</a></li>', $link['url'], $link['nome'], $link['titolo']);
        }
        $str .= '</ul>';
    }

    // Close <nav>
    $str .= '</nav>';

    // Link to menu.js script for the menu toggle
    $str .= '<script src="./script/menu.js"></script>';

    return $str;
}

/**
 * Function to print footer
 */
function printFooter()
{
    global $pdo;
    $str = '<footer>';
    $str .= '<div class="footer-row">';

    // Select and print only contacts
    $queryStr = 'SELECT
                    *
                 FROM
                    recapitiIndirizzi
                 WHERE
                    cancellato = 0
                    AND tipo = "Contatti"';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        $str .= '<div class="footer-col">';
        $str .= '<h3>Contatti</h3>';
        $str .= '<ul class="footer-contacts">';
        // Print social links
        foreach ($array as $link) {
            $str .= sprintf('<li class="contact-link"><a href="%s" title="%s">%s</a></li>', $link['url'], $link['testo'], $link['testo']);
        }
        $str .= '</ul></div>';
    }

    // Select and print only social links
    $queryStr = 'SELECT
                    *
                 FROM
                    recapitiIndirizzi
                 WHERE
                    cancellato = 0
                    AND tipo = "Socials"';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        $str .= '<div class="footer-col">';
        $str .= '<h3>Social</h3>';
        $str .= '<ul class="footer-socials">';
        // Print social links
        foreach ($array as $link) {
            $str .= sprintf('<li class="social-link"><a href="%s" title="%s"><img src="%s" alt="%s" title="%s" width="40" height="40"></a></li>', $link['url'], $link['nome'], $link['logo'], $link['nome'], $link['testo']);
        }
        $str .= '</ul></div>';
    }

    // Select and print only policies links
    $queryStr = 'SELECT
                    *
                 FROM
                    menu
                 WHERE
                    cancellato = 0
                    AND sezione = "Policy"';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $array = $query->fetchAll(PDO::FETCH_ASSOC);
        $str .= '<div class="footer-col">';
        $str .= '<h3>Policy</h3>';
        $str .= '<ul class="footer-policies">';
        // Print policy links
        foreach ($array as $link) {
            $str .= sprintf('<li class="policy-link"><a href="%s" title="%s">%s</a></li>', $link['url'], $link['nome'], $link['titolo']);
        }
        $str .= '</ul></div>';
    }
    $str .= '</div>';

    // Print copyright text
    $str .= '<div class="footer-copy"><p>Created by Lorenzo Marini. All rights reserved &copy; 2024</p></div>';
    $str .= '</footer>';

    return $str;
}
