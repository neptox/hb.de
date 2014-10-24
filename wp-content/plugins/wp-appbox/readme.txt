=== WP-Appbox ===
Contributors: Marcelismus
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6
Tags: google play, google, android, apps, apple, app store, ios, windows, windows phone, mobile, windows store, androidpit, blackberry, appworld, appbox, firefox, firefox marketplace, chrome, chrome web store, samsung, samsung apps, amazon, amazon apps, wordpress, opera, steam, tradedoubler, phg, gog.com, good old games
Requires at least: 3.4
Tested up to: 4.0
Stable tag: 2.4.7
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0

Via Shortcode schnell und einfach App-Details von Apps aus einer Reihe an App Stores in Artikeln oder Seiten anzeigen.


== Description ==

Info: Although the plugin supports multiple languages, the app stores, however, are designed only for German users. If the app stores of other countries are to be used, the URLs must be adapted himself. See the F.A.Q. or [this blog article](http://www.blogtogo.de/wp-appbox-tradedoubler-id-und-store-url-updatesicher-aendern/ "Change TradeDoubler- and Store-Languages") for more informations.

"WP-Appbox" ermöglicht es, via Shortcode schnell und einfach App-Details von Apps aus einer Reihe an App Stores in Artikeln oder auf Seiten anzuzeigen. Das Plugin bietet dabei (bisher) folgende App Stores an:

* Amazon App Shop (Android, experimentell)
* AndroidPit (Android)
* App Store und Mac App Store
* Chrome Web Store (Experimentell)
* Firefox Erweiterungen/Add-ons
* Firefox Marketplace
* Good Old Games (GOG.com)
* Google Play Store
* Opera Add-ons
* Samsung Apps (Android)
* Steam (nur Apps, ohne Alterscheck)
* Windows Store
* Windows Phone Store
* WordPress-Plugins

Info: Die BlackBerry World musste entfernt werden, weil BlackBerry derzeit keine Möglichkeit mehr bietet, auf die Daten zugreifen zu können.

= Einbindung =

Alle Stores in einem Shortcode integriert und können via Button im Editor von WordPress eingefügt werden. Der Aufbau des Shortcodes ist dabei immer der folgende:

[appbox *storename* *app-id* *format*]

Die Reihenfolge ist dabei egal - solange "appbox" vorne an steht. Die Storenamen sind dabei: androidpit, amazonapps, appstore, chromewebstore, firefoxaddon, firefoxmarketplace, goodoldgames, googleplay, intelappup, operaaddons, samsungapps, steam, windowsphone, windowsstore und wordpress. Wie ihr an die ID der entsprechenden Apps kommt, findet sich bebildert in den Einstellungen zu WP-Appbox. Das Format ist standardmäßig "simple", alternativ gibt es auch eine Anzeige mit "compact", "screenshots", "screenshots-only", "video" (nur Google Play) und auch als "banner" (nur für AndroidPit).

Daneben gibt es noch eine Reihe an Attributen, die verwendet werden können: noqrcode, alterpreis=""/oldprice="".

Für den App Store gibt es eine weitere Besonderheit: Hier kann man bei Universal-Apps entscheiden, ob man Screenshots von iPhone und iPad angezeigt bekommen möchte, oder zum Beispiel nur vom iPhone oder nur vom iPad. Dazu reicht es aus, einfach ein "-iphone" oder "-ipad" an die ID der App zu hängen. Beispiel: 392502056-ipad.

= Weitere Features =

* Zoom des QR-Codes bei MouseOver
* Anpassung an mobile Geräte mit kleineren Displays
* Anpassung an die Feedausgabe
* Caching der Daten zu Performancezwecken
* Komplett anpassbar via HTML und CSS
* Nutzung von PHG für den (Mac) App Store
* Nutzung der Affili.net-ID für AndroidPit
* Nutzung der PartnerNet-ID für Amazon Apps
* Nutzung benutzerspezifischer Affiliate IDs

= Systemanforderungen =
* PHP ab 5.2.4
* WordPress ab 3.4
* Server mit laufendem cURL und mb_eregi

= Support =
Supportanfragen und Probleme im Idealfall bitte direkt im [Blog](http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/ "Blog") oder noch besser via [Twitter](https://twitter.com/Marcelismus "Twitter") melden. 

= Übersetzungen =
* Standard: Deutsch
* English (UK)
* English (US)
* French (by Laurent)
* Spanish (by Rubén)
* Italian (by Michele)
* Serbian (by Borisa)

If you want to translate, contact me.

= Autor =
* [blogtogo.de](http://www.blogtogo.de "blogtogo.de")
* [hirngedoens.de](http://www.hirngedoens.de "hirngedoens.de")
* [marcelismus.de](http://www.marcelismus.de "marcelismus.de")
* [Twitter](https://twitter.com/Marcelismus "Twitter")
* [Google+](https://plus.google.com/106153855794163421374/ "Google+")

= Logo =
Das Logo der WP-Appbox stammt von [@craive](https://twitter.com/craive "@craive on Twitter"), dem ich dafür zu tiefsten Dank verpflichtet bin. \o/ 

== Screenshots ==

1. Simpler App-Badge mit und ohne QR-Code
2. Compact App-Badge
3. App-Badge mit Screenshots
4. Banner-Badge (nur WordPress Plugins und AndroidPit)
5. Video-Badge (nur Googly Play)
6. Zoom des QR-Codes
7. Fallback-Anzeige für den Google-Badge
8. WP-Appbox Einstellungen "Cache"
9. WP-Appbox Einstellungen "Optionen"
10. WP-Appbox Einstellungen "App-Banner"
11. WP-Appbox Einstellungen "Buttons"
12. WP-Appbox Einstellungen "Affiliate"
13. WP-Appbox Einstellungen "Hilfe"
14. Artikeleditor mit Buttons

= Requirements =
* PHP ab 5.2.4
* WordPress ab 3.4
* Server mit aktiviertem allow_url_fopen, cURL, curl_init und curl_exec

= Installation =
1. Downloadpaket entpacken
2. Den Plugin-Ordner nach "/wp-content/plugins/" hochladen
3. Das Plugin in WordPress aktivieren


Einfach in den Plugin-Ordner von WordPress extrahieren und aktivieren.


== Frequently Asked Questions ==
  
= Gibt es Vorraussetzungen für den Server? =
  Ja: Der Server muss mindestens auf PHP5 laufen und cURL, sowie mb_eregi unterstützen.

= Kann man die Ausgabe anpassen? =
  Ja - sämtliche Ausgabeelemente können mittels HTML und CSS nach belieben angepasst werden.

= Wieso werden die QR-Codes von 400x400 Pixel runterskaliert? =
  Der QR-Code-Generator von Google hat eine kleine Eigenheit, dass die QR-Codes nur im gesamten auf die fixe Größe erstellt werden - je kürzer die URL ist, desto kleiner wird der Code und desto höher ist der Wert "margin". Dies lässt sich derzeit auch mit einer "margin=0" Angabe nicht korrigieren. Ob es ein Feature oder ein Bug ist wird in den Google Groups diskutiert.
  
= Ich bekomme keine App-Icons aus dem (Mac) App Store angezeigt =
  Das Setzen des Häkchen "Kompabilitätsmodus für App-Icons aus dem (Mac) App Store" in den Einstellungen unter "Fehlerbehebung" sollte das Problem lösen.
  
= Der Google-App-Badge liefert einen Bot-Fehler =
  Google erkennt aufgrund zu vieler Anfragen den Server als Bot und sperrt die Seite. Derzeit wird ein Fallback-Badge angezeigt, ich arbeite aber an einer Lösung, das Problem mittels Captcha-Eingabe zu umgehen.  
  
= Store-URL und -Sprachen wechseln =
  Standardmäßig wird überall der deutschsprachige Store genutzt. Wer eine andere Sprache nutzen möchte, der kann dies über eine kleine Funktion innerhalb der functions.php wechseln. Mehr Infos dazu gibt es [in meinem Blog-Artikel](http://www.blogtogo.de/wp-appbox-tradedoubler-id-und-store-url-updatesicher-aendern/ "Store-URL und -Sprachen wechseln").


== Changelog ==

= 2.4.7 =
* Fix für die neuen AndroidPit-Profile, leider ohne Entwickler-Angabe

= 2.4.6 =
* Fix für Promo-Aktionen im Windows Store

= 2.4.5 =
* Button-Fixes

= 2.4.4 =
* Button-Fix für WordPress 3.9
* Codeoptimierungen

= 2.4.3 =
* TradeDoubler entfernt (mehr Infos [in diesem Artikel](http://www.blogtogo.de/kurzinfo-in-der-sache-wp-appbox-und-dem-tradedoubler-partnerprogramm/ "Kurzinfo in der Sache WP-Appbox und dem TradeDoubler-Partnerprogramm"))

= 2.4.2 =
* Fix für bestimmte Typen von Apple-/PHG-Links

= 2.4.1 =
* Kleine optische Korrektur bezüglich des PHG-Linkes

= 2.4.0 =
* [mehr Infos zu v2.4.0 im Blog](http://www.blogtogo.de/wp-appbox-2-4-0-bringt-neues-apple-affiliate-programm-mit-und-entfernt-intel-appup/ "WP-Appbox 2.4.0 bringt neues Apple-Affiliate-Programm mit und entfernt Intel AppUp")
* PHG auch für europäische Nutzer implementiert (mehr Infos [in diesem Artikel](http://www.blogtogo.de/kurzinfo-in-der-sache-wp-appbox-und-dem-tradedoubler-partnerprogramm/ "Kurzinfo in der Sache WP-Appbox und dem TradeDoubler-Partnerprogramm"))
* Intel AppUp entfernt (schließt Mitte März)

= 2.3.5 =
* Fix für den Amazon App Shop
* Getestet unter WordPress 3.8.1

= 2.3.4 =
* Fix für den Play Store (Entwickler wurde nicht angezeigt)

= 2.3.3 =
* Getestet unter WordPress 3.8

= 2.3.2 =
* [mehr Infos zu v2.3.0 im Blog](http://www.blogtogo.de/wp-appbox-2-3-0-bringt-unterstuetzung-fuer-good-old-games-gog-com-mit/ "WP-Appbox 2.3.0 bringt Unterstützung für Good Old Games (GOG.com) mit")
* Fix für Intel AppUp
* Serbische Übersetzung

= 2.3.1 =
* Fix für AndroidPit

= 2.3.0 =
* Good Old Games (GOG.com) implementiert
* Codeoptimierungen

= 2.2.3 =
* Lauffähig unter WordPress 3.7
* Fix Amazon App Shop Bug (App-Daten neu laden)
* Codeoptimierungen

= 2.2.2 =
* Korrektur des Autor-Links bei Firefox Addons
* Codeoptimierungen

= 2.2.1 =
* Unterstützung für das PHG-Affiliate-Programm für den (Mac) App Store - nicht für Europa
* Codeoptimierungen

= 2.2.0 =
* [mehr Infos zu v2.2.0 im Blog](http://www.blogtogo.de/wp-appbox-2-2-0-benutzerspezifische-affiliate-ids-dauerhafter-cache-und-screenshot-only/ "WP-Appbox 2.2.0: Benutzerspezifische Affiliate-IDs und Screenshot-Only")
* Jeder Nutzer kann seine eigenen Affiliate-IDs nutzen
* Neuer "Screenshot Only"-Badge
* Codeoptimierungen

= 2.1.4 =
* Bugfix bezüglich Datenbanktabellen, die nicht das Standard-Prefix "wp_" besitzen

= 2.1.3 =
* Lauffähig unter WordPress 3.6.1
* Kleinere Codeoptimierungen

= 2.1.2 =
* Kleinere Anpassungen der Feed-Ausgabe

= 2.1.1 = 
* Änderung der Versionsnummer ;-)
* Kleine Codeoptimierung bezüglich des Windows Stores

= 2.1.0 = 
* [mehr Infos zu v2.1.0 im Blog](http://www.blogtogo.de/wp-appbox-2-1-0-bewertungen-aus-den-app-stores-und-hochaufloesendere-app-store-icons/ "WP-Appbox 2.1.0: Bewertungen aus den App Stores und hochauflösendere App-Store-Icons")
* App-Bewertungen aus den App Stores können nun eingeblendet werden
* Hochauflösende Icons eingebaut
* Italienische Übersetzung hinzugefügt
* Kleinere Fehlerbereinigungen

= 2.0.2 = 
* [mehr Infos zu v2.0.0 im Blog](http://www.blogtogo.de/wp-appbox-2-0-0-is-here-danke-fuer-10-000-downloads/ "WP-Appbox 2.0.0 is here! Danke für 10.000 Downloads.")
* Optimierung bezüglich des Banner-Badge für WordPress-Plugins
* Codeoptimierungen

= 2.0.1 =
* [mehr Infos zu v2.0.0 im Blog](http://www.blogtogo.de/wp-appbox-2-0-0-is-here-danke-fuer-10-000-downloads/ "WP-Appbox 2.0.0 is here! Danke für 10.000 Downloads.")
* Die Aneinanderreihung der Parameter [... "App-ID" "simple"] gibt keinen Fehler mehr aus

= 2.0.0 =
* [mehr Infos im Blog](http://www.blogtogo.de/wp-appbox-2-0-0-is-here-danke-fuer-10-000-downloads/ "WP-Appbox 2.0.0 is here! Danke für 10.000 Downloads.")
* Neues Logo - danke an @craive!
* Weite Teile des Codes neu geschrieben
* Intel AppUp hinzugefügt
* Apps im Cache können einzeln gelöscht werden
* Compact Badge eingebaut
* Video-Badge für Steam und Google Play hinzugefügt
* CSS-Sheet des Plugins kann deaktiviert werden
* Neuer Aufbau der Einstellungen
* Stand-Alone-Buttons und "Kombinierter Button" nun zusammen möglich
* Shortcode preis/price entfernt (Cache kann neu geladen werden)
* Korrekturen bezüglich der Icons aus dem Windows Store

= 1.8.15 =
* Getestet unter WordPress 3.6

= 1.8.14 =
* Fehler werden bei Aktivierung abgefangen

= 1.8.13 =
* Kleinere Fehlerkorrekturen

= 1.8.12 =
* Kleinere Korrektur bezüglich des Apple App Stores
* Kleinere Korrektur bezüglich des Windows Phone Store

= 1.8.11 =
* Kleine Anpassung an den Windows Phone Store

= 1.8.10 =
* Kleine Fehlerbehebung im App Store
* Codeanpassungen

= 1.8.9 =
* Screenshots aus dem Chrome Web Store zur Zeit nicht mehr möglich
* Bugfix, es sollten nun wieder alle App-Store-Icons angezeigt werden
* Codeoptimierungen

= 1.8.8 =
* Anpassung an den neuen Play Store und gezwungene Entfernung des Typs "Banner Badge"

= 1.8.7 =
* Codeoptimierungen

= 1.8.6 =
* Fix für App-Store-Icons
* Fix für die Kürzung des App-Titels
* Codeoptimierungen

= 1.8.5 =
* Implementierung von Steam (experimentell, nur ohne Alterscheck)
* Überarbeitung der Pluginbox
* Codeoptimierungen

= 1.8.0 =
* Einfache Anpassung der Store-URLs über Funktionen (siehe F.A.Q.)
* Timeout-Zeit kann manuell hochgesetzt werden

= 1.7.13 =
* TIFF-Icons aus dem App Store werden nun (größtenteils) angezeigt
* Fix siehe Version 1.7.12

= 1.7.12 =
* Verbesserte Update-Methode

= 1.7.11 =
* Bugfix und Codeoptimierungen

= 1.7.10 =
* Bugfix

= 1.7.9 =
* Bei Universal-Apps aus dem App Store können Screenshots nun wahlweise nur vom iPhone oder iPad angezeigt werden
* Das erneute Laden von App-Daten kann (trotz Cache) erzwungen werden (GET-Parameter: "wpappbox_reload_cache")
* Codeoptimierungen

= 1.7.8 =
* Optimierungen bezüglich des App-Icons aus dem App Store (testweise)
* Spanische Sprachdatei hinzugefügt

= 1.7.7 =
* Kleinere CSS-Optimierungen
* Kleinere Optimierung für den Play Store

= 1.7.6 =
* Tempfile Fix

= 1.7.5 =
* Opera Add-ons implementiert (Shortcode: operaaddons)
* QR-Codes können nun auch nur für die mobilen Stores angezeigt werden
* Sprachdateien korrigiert
* Codeoptimierungen

= 1.7.1 =
* Fix der Buttonleiste

= 1.7.0 =
* WordPress Plugin Verzeichnis eingebaut (Shortcode: wordpress)
* Behebung kleinerer Fehler
* Etwas aufgeräumt
* Codeoptimierungen

= 1.6.2 =
* Button für die Amazon Apps sollte nun auch angezeigt werden

= 1.6.1 =
* Beim Banner-Badge (Google Play, AndroidPit & Amazon Apps) wird nun auch der QR-Code vergrößert

= 1.6.0 =
* Implementierung des Amazon App Shop
* Kleinere Fehlerbehebungen
* Codeoptimierungen

= 1.5.3 =
* Der Firefox Marketplace ist wieder implementiert
* CSS-Anpassungen

= 1.5.2 =
* Entfernung der Firefox Marketplace, da  Mozilla [keine Möglichkeit mehr bietet](http://www.blogtogo.de/mozilla-ueberarbeitet-den-firefox-marketplace-und-was-das-fuer-wp-appbox-bedeutet/ "Mozilla überarbeitet den Firefox Marketplace – und was das für WP-Appbox bedeutet"), auf die Daten zugreifen zu können
* Codeoptimierungen

= 1.5.1 =
* QR-Codes können auch temporär deaktiviert werden (Attribut: noqrcode)
* Der anzuzeigende Preis kann verändert werden (Attribut: preis="" oder price="")
* Es kann ein "alter Preis" angegeben werden (Attribut: alterpreis="" oder oldprice="")
* Codeoptimierungen

= 1.5.0 =
* Samsung Apps implementiert
* Bugfix bezüglich der Kürzung des Entwickler
* Codeoptimierungen (wie immer)

= 1.4.6 =
* Codeoptimierung und Bugfix im Google Play Store
* Der Cache kann temporär deaktiviert werden
* Kürzung des Titels kann optional deaktiviert werden
* Codeoptimierungen

= 1.4.5 =
* Kleinerer Bugfix in Sachen Play Store
* Optimierungen des CSS-Codes
* Die Summe der Versionsziffern ist 10, daher könnte es WP-Appbox X heißen - käme ich aus Cupertino ;)

= 1.4.4 =
* Codeoptimierungen

= 1.4.3 =
* Fix für den Windows Store (neue URL)
* Fix für den Windows Phone Store (neue URL)
* Zu lange App-Titel werden gekürzt
* French translation (by Laurent)
* Codeoptimierungen

= 1.4.2 =
* Kleinere CSS-Optimierungen

= 1.4.1 =
* Fix QR-Code

= 1.4.0 =
* Firefox Addons hinzugefügt
* QR-Codes können deaktiviert werden
* Fix zwecks Sprachdateien

= 1.3.3 =
* Fix für den QR-Code des (Mac) App Store
* Größere App Icons aus dem (Mac) App Store
* Sprachdatei (*.mo & *.po) hinzugefügt
* Entfernung der BlackBerry World, da  BlackBerry keine Möglichkeit mehr bietet, auf die Daten zugreifen zu können

= 1.3.2 =
* Fix für den (Mac) App Store

= 1.3.1 =
* Korrektur des AndroidPit-Links

= 1.3.0 =
* Überarbeitete Optionsseite
* Abfrage des (Mac) App Store via JSON API
* BlackBerry App World in BlackBerry World umbenannt
* Nutzung des AndroidPit-Affiliate-Programmes via Affili.net möglich
* Firefox Marketplace hinzugefügt
* Chrome Web Store hinzugefügt (experimentelles Feature)

= 1.2.2 =
* Fixed AndroidPit-Screenshots
* Bugfixes

= 1.2.1 =
* Fixed "Cache leeren"-Link

= 1.2.0 =
* Nutzung der Transient API von WordPress zum Cachen der Daten
* Cache kann komplett geleert werden
* Bugfix beim Windows Phone Store und Apps mit Umlauten
* Codeoptimierungen

= 1.1.3 =
* Codeoptimierungen

= 1.1.2 =
* Behebung eines Fehlers, dass die Caching-Zeit im Firefox nicht geändert werden konnte

= 1.1.1 =
* Fehlerausgabe eingefügt
* Codeoptimierungen

= 1.0.2 =
* Fehlerkorrektur siehe Version 1.0.1
* "Blank-Page"-Fehler bei der BlackBerry AppWorld behoben

= 1.0.1 =
* Fallback im Falle das die Anfrage an den Play Store als Bot erkannt wird

= 1.0.0 =
* Code-Freeze