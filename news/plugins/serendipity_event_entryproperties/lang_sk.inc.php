<?php #

/**
 *  @author Martin Matu�ka <martin@matuska.org>
 *  EN-Revision: Revision of lang_en.inc.php
 *  @revisionDate 2010-08-17
 */

@define('PLUGIN_EVENT_ENTRYPROPERTIES_TITLE', 'Roz��ren� vlastnosti �l�nkov');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_DESC', 'cachovanie, neverejn� �l�nky, st�le (prilepen�) �l�nky');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_STICKYPOSTS', 'Ozna�i� tento �l�nok ako st�ly (prilepen�)');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS', '�l�nky m��u by� pre��tan�');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS_PRIVATE', 'Mnou');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS_MEMBERS', 'Spoluautormi');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_ACCESS_PUBLIC', 'K�mko�vek');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE', 'Zapn� cachovanie �l�nkov?');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_DESC', 'Ak je zapnut�, pri ka�dom ulo�en� �l�nku bude vytvoren� cachovan� verzia. To znamen�, �e pri ka�dom na��tan� str�nky nebude pr�spevok generovan� odznova, ale pou�ije sa predgenerovan� (cachovan�) verzia. Cachovanie zv�i v�kon weblogu, ale m��e obmedzi� funk�nos� ostatn�ch doplnkov.');
@define('PLUGIN_EVENT_ENTRYPROPERTY_BUILDCACHE', 'Cachova� pr�spevky');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_FETCHNEXT', 'Na��tanie �al�ej d�vky pr�spevkov...');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_FETCHNO', 'Na��tanie pr�spevkov %d a� %d');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_BUILDING', 'Vytv�ranie cachovanej verzie pre pr�spevok #%d, <em>%s</em>...');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHED', 'Pr�spevok cachovan�.');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_DONE', 'Cachovanie pr�spevkov dokon�en�.');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_ABORTED', 'Cachovanie pr�spevkov ZRU�EN�.');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CACHE_TOTAL', ' (z celkov�ho po�tu %d pr�spevkov)...');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_NO_FRONTPAGE', 'Skry� v preh�ade �l�nkov / na hlavnej str�nke');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_GROUPS', 'Pou�� obmedzenie pre skupiny');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_GROUPS_DESC', 'Ak je zapnut�, tak m��ete zada�, ktor� skupiny pou��vate�ov m��u ��ta� �l�nok. Toto nastavenie m� ve�k� vplyv an r�chlos� vytv�rania str�nky s preh�adom �l�nkov. Zapnite toto nastavenie, iba ak ho naozaj potrebujete.');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_USERS', 'Pou�� obmedzenie pre pou��vate�ov');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_USERS_DESC', 'Ak je zapnut�, tak m��ete zada�, ktor� pou��vatelia m��u ��ta� �l�nok. Toto nastavenie m� ve�k� vplyv an r�chlos� v
ytv�rania str�nky s preh�adom �l�nkov. Zapnite toto nastavenie, iba ak ho naozaj potrebujete.');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_HIDERSS', 'Skry� obsah v RSS kan�li');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_HIDERSS_DESC', 'Ak je zapnut� ,tak sa nebude zobrazova� obsah �l�nku v RSS kan�li/kan�loch.');

@define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS', 'Vlastn� pole');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS_DESC1', 'Pridan� vlastn� polia m��u by� pou�it� vo Va�ej vlastnej �abl�ne na miestach, kde chcete zobrazova� �daje z t�chto pol�. Pre t�to funkcio mus�te upravi� �abl�nu "entries.tpl" a v nej umiestni� Smarty tag {$entry.properties.ep_NazevMehoPolicka}. Pred n�zov ka�d�ho po�a mus� by� pridan� predpona ep_ . ');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS_DESC2', 'Tu m��ete zada� zoznam pol�, ktor� chcete pou�i� vo svojich �l�nkoch. Polia odde�ova� �iarkou. Men� pol� nem��u obsahova� �peci�lne znaky ani diakritiku. Pr�klad: "MojePole1, CiziPole2, UplneCiziPole3". ');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_CUSTOMFIELDS_DESC3', 'Zoznam dostupn�ch volite�n�ch pol� m��e by� zmenen� v <a href="%s" target="_blank" title="' . PLUGIN_EVENT_ENTRYPROPERTIES_TITLE . '">nastaveniach doplnku</a>.');

@define('PLUGIN_EVENT_ENTRYPROPERTIES_DISABLE_MARKUP', 'Zak�za� pou�itie transofrm�ci� textu (markup) pre tento �l�nok:');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_EXTJOINS', 'Roz��ren� datab�zov� h�adanie');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_EXTJOINS_DESC', 'Ak je zapnut�, bud� vytvoren� pr�davn� SQL dotazy, ktor� umo�nia pou�i� aj prilepen�, skryt� a z hlavnej str�nky odstr�nan� �l�nky. Ak toto nastavenie nepotrebujete, odpor��ame z d�vodov v�konu ponecha� vypnut�.');

@define('PLUGIN_EVENT_ENTRYPROPERTIES_SEQUENCE', 'Edita�n� obrazovka');
@define('PLUGIN_EVENT_ENTRYPROPERTIES_SEQUENCE_DESC', 'Tu vyberte, ktor� prvky a v akom porad� m� tento doplnok zobrazova� v procese �prav �l�nku.');

