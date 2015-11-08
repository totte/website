<?php #

/**
 *  @version 1.0
 *  @author Konrad Bauckmeier <kontakt@dd4kids.de>
 *  @translated 2009/06/03
 */

@define('PLUGIN_EVENT_XHTMLCLEANUP_NAME', '�bliche XHTML-Fehler beseitigen');
@define('PLUGIN_EVENT_XHTMLCLEANUP_DESC', 'Korrigiert �bliche Fehler, die beim XHTML-Markup der Eintr�ge gemacht werden k�nnen');

// Next lines were translated on 2009/06/03
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML', 'kodiere XML-geparste Daten?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_XHTML_DESC', 'Dieses Plugin benutzt als Methode XML-Parsing (Syntaxanalyse) um validen XHTML auszugeben. Diese Methode kann dazu f�hren, dass schon vorher g�litg kodierte (also umgewandelte) Sonderzeichen (Entities) nun nicht mehr kodiert sind. Daher wird nach dem Parsen noch einmal kodiert. Schalten Sie diese diese Option AUS, wenn Sie dadurch doppelt kodierte Sonderzeichen erhalten.' );
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8', 's�ubere UTF-8 kodierte Sonderzeichen?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_UTF8_DESC', 'Wenn aktiviert, werden HTML Sonderzeichen, die von UTF-8 Zeichen abstammen, in der Ausgabe konvertiert und nicht doppelt kodiert.');
@define('PLUGIN_EVENT_XHTMLCLEANUP_YOUTUBE', 'Youtube Player Quelltext s�ubern?');
@define('PLUGIN_EVENT_XHTMLCLEANUP_YOUTUBE_DESC', 'Wenn aktiviert, werden die im XHTML ung�ltigen object-Tags des YouTube-Quelltextes aus dem embed-Teil entfernt. Die Wiedergabe des Videos im Browser funktioniert trotzdem.');

