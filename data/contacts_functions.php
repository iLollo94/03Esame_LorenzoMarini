<?php
// #################################################################################################################
// #######   CONTACTS FUNCTIONS   ##################################################################################
// #################################################################################################################

// Require Utility class
require_once('./data/CLASSE_Utility.php');

use LMWebDev2\Utility as UT;

/**
 * Function to print personal contact data
 */
function printPersonalContacts()
{
    global $pdo;
    $str = '<div class="personal-contacts">';
    // Get from DB the sub-sections to insert in the contacts section
    $queryStr = 'SELECT
                    sezione
                 FROM
                    recapitiindirizzi
                 WHERE
                    cancellato = 0
                 GROUP BY
                    sezione';
    $query = $pdo->prepare($queryStr);
    $query->execute();
    if ($query->rowCount() > 0) {
        // Get from DB the datas of each sub-section and print them in HTML
        while ($section = $query->fetch(PDO::FETCH_ASSOC)) {
            $str .= sprintf('<div class="%s-container">', strtolower($section['sezione']));
            $str .= sprintf('<h2>%s</h2>', $section['sezione']);
            $subqueryStr = 'SELECT
                                nome,
                                testo,
                                url,
                                logo
                            FROM
                                recapitiindirizzi
                            WHERE
                                sezione = :sezione
                                AND cancellato = 0';
            $subquery = $pdo->prepare($subqueryStr);
            $subquery->bindParam(':sezione', $section['sezione'], PDO::PARAM_STR);
            $subquery->execute();
            if ($subquery->rowCount() > 0) {
                $str .= '<ul class="contacts-list">';
                while ($link = $subquery->fetch(PDO::FETCH_ASSOC)) {
                    // Distinct logo links from textual links
                    if ($link['logo'] == null) {
                        $str .= sprintf('<li><p>%s: <a href="%s" title="%s">%s</a></p></li>', $link['nome'], $link['url'], $link['testo'], $link['testo']);
                    } else {
                        $str .= sprintf(('<li><a href="%s" title="%s"><img src="%s" alt="%s" title="%s"></a></li>'), $link['url'], $link['nome'], $link['logo'], $link['nome'], $link['nome']);
                    }
                }
                $str .= '</ul>';
            }
            $str .= '</div>';
        }
    }
    $str .= '</div>';

    return $str;
}

/**
 * Function to print contact form
 */
function printForm() {}

/**
 * Function to handle message trasmission to the DB
 */
function handleMessageTrasmission() {}

/**
 * Function to print contacts page
 */
function printContacts()
{
    $messageSent = UT::richiestaHTTP('messageSent');
    $messageSent = ($messageSent == null) ? false : true;
    $str = '<main>';
    $str .= '<section class="contacts">';
    // Print personal contacts and social links
    $str .= printPersonalContacts();
    // Print form if not sent or handle form submission
    if (!$messageSent) {
        $str .= printForm();
    } else {
        $str .= handleMessageTrasmission();
    }
    $str .= '</section></main>';

    return $str;
}
