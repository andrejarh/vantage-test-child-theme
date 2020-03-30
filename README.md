# Test - A Vantage child theme

This is a Vantage child theme, which demonstrates Live Editor issues https://github.com/siteorigin/siteorigin-panels/issues/733 and https://github.com/siteorigin/siteorigin-panels/issues/667

To test it, 
1. Install the Test child theme next to the Vantage theme. Preferably on a fresh WP install.
2. In Settings -> Page builder enable "Static block" post type.
3. In Plugins -> SiteOrigin Widgets enable (TEST) Static Block widget.
4. Import the import.xml content with WordPress importer (Tools -> Import).

A page with banner area will be imported. On the front end, everything works. But it produces PHP notice when opened with Live editor.
