<?php
// #################################################################################################################
// #######   HOMEPAGE FUNCTIONS ####################################################################################
// #################################################################################################################

// Require Utility class
require_once('./data/CLASSE_Utility.php');
use LMWebDev2\Utility as UT;

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
