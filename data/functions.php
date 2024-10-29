<?php

/**
 * Function for HTML print and DB connection
 */

// DB Connection (PDO)
require_once('./data/db_connection.php');
try {
    $pdo = new PDO("mysql:host=" . INDIRIZZO . ";dbname=" . DB, UTENTE, PASSWORD);
} catch (PDOException $e) {
    die("Errore " . $e->getCode() . ": " . $e->getMessage());
}

// Require di classe Utility
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

// #################################################################################################################
// #######   HOMEPAGE FUNCTIONS ####################################################################################
// #################################################################################################################

/**
 * Function to print services section
 */
function printServices()
{
    global $pdo;
    $str = '<section class="services">';
    $queryStr = 'SELECT
                    *
                 FROM
                    servizi
                 WHERE
                    cancellato = 0';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        // Printing gallery only if there are results on the query
        $str .= '<div class="services-gallery">';
        $str .= '<div class="gallery-container">';
        $count = 0;
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            $str .= sprintf('<div class="services-item service-' . $count . ' fade"><div class="description"><h2>%s</h2><p>%s</p></div><div class="image" style="background-image:url(%s);"></div></div>', $row['titolo'], $row['descrizione'], $row['urlImmagine']);
        }
        $str .= '</div>';
        // Using $count to print as many dots as the number of slides
        $str .= '<div class="dot-container">';
        for ($i = 0; $i < $count; $i++) {
            $str .= '<span class="dot" data-id="' . $i + 1 . '"></span>';
        }
        $str .= '</div>';
        $str .= '<span id="prev">&#10094;</span><span id="next">&#10095;</span>';
        $str .= '</div>';
        $str .= '<script src="./script/servicesGalleryVer2.js"></script>';
    } else {
        $str .= '<div class="gallery-error"><p>Cannot load services gallery</p></div>';
    }
    $str .= '</section>';

    return $str;
}

/**
 * Function to print knowledges
*/
function printKnowledges()
{
    global $pdo;
    $str = '<section class="knowledges">';
    $queryStr = 'SELECT
                    nome,
                    tipo,
                    urlLogo,
                    descrizione
                 FROM
                    conoscenze
                 WHERE
                    cancellato = 0
                 ORDER BY
                    tipo ASC';
    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $str .= '<div class="knowledge-container">';
        $str .= '<h3>Linguaggi e sistemi conosciuti</h3>';
        $str .= '<div class="icons-container">';
        $count = 0;
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            $str .= sprintf('<div class="known-icon"><img src="%s" alt="%s" title="%s" data-id="' . $count . '"></div>', $row['urlLogo'], $row['nome'], $row['nome']);
            $str .= sprintf('<div class="known-icon-tooltip" id="tooltip-' . $count . '"><h5>%s</h5><p>%s</p></div>', $row['nome'], $row['descrizione']);
        }
        $str .= '</div></div>';
        $str .= '<script src="./script/knowledges.js"></script>';
    }
    $str .= '</section>';

    return $str;
}

/**
 * Function to print aboutMe
*/
function printBio()
{
    global $pdo;
    $str = '<section class="bio" id="about-me">';
    $queryStr = 'SELECT
                    testo,
                    urlImmagine
                 FROM
                    aboutMe
                 WHERE
                    cancellato = 0';

    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $str .= '<div class="bio-container">';
        $str .= '<h2>About Me</h2>';
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $str .= sprintf('<div class="bio-image" style="background-image:url(%s)"></div><div class="bio-text"><p>%s</p></div>', $row['urlImmagine'], nl2br($row['testo']));
        }
        $str .= '</div>';
    }
    $str .= '</section>';

    return $str;
}

/**
 * Function to print homepage
*/
function printHomepage()
{
    $str = '<main>';
    $str .= printServices();
    $str .= printKnowledges();
    $str .= printBio();
    $str .= '</main>';

    return $str;
}

// #################################################################################################################
// #######   PORTFOLIO FUNCTIONS   #################################################################################
// #################################################################################################################

/**
 * Function to generate the select based on project types present on the DB
 * This select will have a "change" event listener to send filter type to URL query string
*/
function generateSelect()
{
    global $pdo;
    $str = '<select name="filter" id="filter-select">';
    $queryStr = 'SELECT
                    tipologiaProgetto,
                    case
                        when progetti.tipologiaProgetto = 0 then "Nessuna categoria"
                        when progetti.tipologiaProgetto = 1 then "Website"
                        when progetti.tipologiaProgetto = 2 then "Web-Application"
                        when progetti.tipologiaProgetto = 3 then "Script/Utility"
                        when progetti.tipologiaProgetto = 4 then "Ambiente Web"
                        ELSE ""
                    END AS nomeTipologia
                 FROM
                    progetti
                 WHERE
                    cancellato = 0
                 GROUP BY
                    tipologiaProgetto';
    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        $str .= '<option value="all" selected>Tutti</option>';
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $str .= sprintf('<option value="%s">%s</option>', $row['tipologiaProgetto'], $row['nomeTipologia']);
        }
    }
    $str .= '</select>';

    return $str;
}

/**
 * Function to print projects based on filter
*/
function printProjects($filter = null)
{
    global $pdo;
    $str = '';
    if ($filter == null || $filter == "all") {
        $queryStr = 'SELECT
                        nomeProgetto,
                        descrizioneProgetto,
                        DATE_FORMAT(dataProgetto, "%d/%m/%Y") AS data,
                        case
                            when progetti.tipologiaProgetto = 0 then "Nessuna categoria"
                            when progetti.tipologiaProgetto = 1 then "Website"
                            when progetti.tipologiaProgetto = 2 then "Web-Application"
                            when progetti.tipologiaProgetto = 3 then "Script/Utility"
                            when progetti.tipologiaProgetto = 4 then "Ambiente Web"
                            ELSE ""
                        END AS tipologiaProgetto,
                        urlImmagine
                    FROM
                        progetti
                    WHERE
                        cancellato = 0';
        $query = $pdo->prepare($queryStr);
    } else {
        $queryStr = 'SELECT
                        nomeProgetto,
                        descrizioneProgetto,
                        DATE_FORMAT(dataProgetto, "%d/%m/%Y") AS data,
                        case
                            when progetti.tipologiaProgetto = 0 then "Nessuna categoria"
                            when progetti.tipologiaProgetto = 1 then "Website"
                            when progetti.tipologiaProgetto = 2 then "Web-Application"
                            when progetti.tipologiaProgetto = 3 then "Script/Utility"
                            when progetti.tipologiaProgetto = 4 then "Ambiente Web"
                            ELSE ""
                        END AS tipologiaProgetto,
                        urlImmagine
                    FROM
                        progetti
                    WHERE
                        cancellato = 0
                        AND tipologiaProgetto = :tipologia';
        $query = $pdo->prepare($queryStr);
        $query->bindParam(':tipologia', $filter, PDO::PARAM_STR);
    }
    $query->execute();
    if ($query->rowCount() > 0) {
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $str .= '<div class="project-card">';
            $str .= sprintf('<div class="project-image"><img src="%s" alt="%s" title="%s"></div>', $row['urlImmagine'], $row['nomeProgetto'], $row['nomeProgetto']);
            $str .= sprintf('<div class="project-description"><h4>%s</h4><p>%s</p><p>%s</p></div>', $row['nomeProgetto'], $row['descrizioneProgetto'], $row['tipologiaProgetto']);
            $str .= sprintf('<div class="project-date"><p>%s</p></div>', $row['data']);
            $str .= '</div>';
        }
    }
}

/**
 * Function to print portfolio
*/
function printPortfolio()
{
    $str = '<main>';
    $str .= '<section class="portfolio">';
    $str .= '<div class="portfolio-container">';
    $filterSelect = generateSelect();
    $str .= sprintf('<div class="portfolio-top-line"><h2>Progetti</h2><div class="filter-select">%s</div></div>', $filterSelect);
    $filter = UT::richiestaHTTP('filter');
    $str .= printProjects($filter);
    $str .= '</div></section>';
    $str .= '</main>';
}
