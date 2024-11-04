<?php
// #################################################################################################################
// #######   PORTFOLIO FUNCTIONS   #################################################################################
// #################################################################################################################

// Require Utility class
require_once('./data/CLASSE_Utility.php');

use LMWebDev2\Utility as UT;

/**
 * Function to generate the select based on project types present on the DB
 * This select will have a "change" event listener to send filter type to URL query string
 */
function generateSelect()
{
    global $pdo;
    $str = '<label for="filter" id="lb_filter">Filtra Progetti</label><select name="filter" id="filter-select">';
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
        $count = 0; // Counter to give data-id to each option
        $str .= '<option value="none" data-id="' . $count . '">Tutti i progetti</option>';
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $count++;
            $str .= sprintf('<option value="%s" data-id="%u">%s</option>', $row['tipologiaProgetto'], $count, $row['nomeTipologia']);
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
    if ($filter == null || $filter == "none") {
        $queryStr = 'SELECT
                        idProgetto,
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
                        idProgetto,
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
        $str .= '<div class="portfolio-container">';
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $str .= sprintf('<div class="project-card" data-id="%u">', $row['idProgetto']);
            $str .= sprintf('<div class="project-image" style="background-image:url(%s)"></div>', $row['urlImmagine']);
            $str .= sprintf('<div class="project-description"><h3>%s</h3><p class="project-text">%s</p><p class="project-type">%s</p></div>', $row['nomeProgetto'], $row['descrizioneProgetto'], $row['tipologiaProgetto']);
            $str .= sprintf('<div class="project-date"><p>%s</p></div>', $row['data']);
            $str .= '</div>';
        }
        $str .= '</div>';
        $str .= '<script src="./script/portfolio.js"></script>';
    }

    return $str;
}

/**
 * Function to read the selected project name and description from the DB
 */
function getName($id)
{
    global $pdo;
    $queryStr = 'SELECT
                    nomeProgetto,
                    descrizioneProgetto
                 FROM
                    progetti
                 WHERE
                    idProgetto = :idProgetto
					AND cancellato = 0';
    $query = $pdo->prepare($queryStr);
    $query->bindParam(':idProgetto', $id, PDO::PARAM_INT);
    $query->execute();

    return ($query->rowCount() > 0) ? $query->fetchAll(PDO::FETCH_ASSOC) : null;
}

/**
 * Function to read the selected project images from the DB
 */
function getImgs($id)
{
    global $pdo;
    $queryStr = 'SELECT
                    progettiimmagini.urlImmagine,
                    progettiimmagini.titolo
                 FROM
                    progetti
                    INNER JOIN progettiimmagini USING (idProgetto)
                 WHERE
                    progetti.idProgetto = :idProgetto
					AND progetti.cancellato = 0';
    $query = $pdo->prepare($queryStr);
    $query->bindParam(':idProgetto', $id, PDO::PARAM_INT);
    $query->execute();

    return ($query->rowCount() > 0) ? $query->fetchAll(PDO::FETCH_ASSOC) : null;
}

/**
 * Function to read the selected project descriptions from the DB
 */
function getDesc($id)
{
    global $pdo;
    $queryStr = 'SELECT
                	progettidescrizione.titolo,
                	progettidescrizione.testo
                 FROM
                	progetti
                	INNER JOIN progettidescrizione USING (idProgetto)
                 WHERE
                	progetti.idProgetto = :idProgetto
                	AND progetti.cancellato = 0';
    $query = $pdo->prepare($queryStr);
    $query->bindParam(':idProgetto', $id, PDO::PARAM_INT);
    $query->execute();

    return ($query->rowCount() > 0) ? $query->fetchAll(PDO::FETCH_ASSOC) : null;
}

/**
 * Function to print the selected project details
 */
function printProjectDetails($id)
{
    $str = '<div class="project-preview-bg">';
    $str .= '<div class="project-details-close"><a href="javascript:void(0)" title="Chiudi menu" id="project-details-close-button"><i class="fa-solid fa-xmark"></i></a></div>';
    $str .= '<div class="project-preview-container">';
    $dataArr = getName($id);
    $imgArr = getImgs($id);
    $descArr = getDesc($id);

    // Title
    $str .= sprintf('<div class="title-bar"><h1>%s</h1><h2>%s</h2></div>', $dataArr[0]['nomeProgetto'], $dataArr[0]['descrizioneProgetto']);

    // Carousel
    $str .= '<div class="project-gallery">';
    $str .= '<div class="project-gallery-container">';
    $count = 0;
    foreach ($imgArr as $slide) {
        $count++;
        $str .= sprintf('<div class="image-container image-' . $count . ' fade"><div class="image" style="background-image:url(%s);"></div><div class="description"><p>%s</p></div></div>', $slide['urlImmagine'], $slide['titolo']);
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
    $str .= '<script src="./script/projectGallery.js"></script>';

    // Description
    $str .= '<div class="project-description">';
    foreach ($descArr as $section) {
        $str .= sprintf('<h3>%s</h3><p>%s</p>', $section['titolo'], $section['testo']);
    }
    $str .= '</div>';

    $str .= '</div></div>';

    return $str;
}

/**
 * Function to print portfolio
 */
function printPortfolio()
{
    $str = '<main>';
    $str .= '<section class="portfolio">';
    $filterSelect = generateSelect();
    $str .= sprintf('<div class="portfolio-top-line"><h2>Progetti</h2><div class="filter-select">%s</div></div>', $filterSelect);
    $project = UT::richiestaHTTP('projectID');
    if ($project != null) {
        $str .= printProjectDetails($project);
    }
    $filter = UT::richiestaHTTP('filter');
    $str .= printProjects($filter);
    $str .= '</section>';
    $str .= '</main>';

    return $str;
}
