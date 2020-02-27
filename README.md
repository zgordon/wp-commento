# WordPress and Commento Plugin

A WordPress plugin to replace native WordPress comments with Commento - for static and headless WP sites.

![Screenshot of Commento Comments on a WordPress site](https://share.getcloudapp.com/yAuv2b9l "Commento Comments on WordPress site")

## Setup

1. Setup an account with [https://commento.io/](https://commento.io/)
2. Add your domain name in Commento dashboard
3. Choose your subscription in Commento
4. Optionally import your WordPress comments into Comment (see instructions below)
5. Optionally style your Commento comments via your WordPress theme (see instructions below)

### How to Style Commento Comments

This plugin will automatically take any styles from your theme style.css and apply them to Commento.

Use web inspector to find the elements you want to style and add your custom styles to your theme style.css file to have them show up.

### How to Import WordPress Comments into Commento

At the moment this process requires importing your WordPress comments into Disqus and then importing the comments from Disqus into Commento.

1. Sign up for [Disqus](https://disqus.com/) (with a free plan)
2. Setup your site in Disqus, choosing WordPress as your platform
3. Install the [Disqus WordPress Plugin](https://wordpress.org/plugins/disqus-comment-system/)
4. Setup the Disqus WP Plugin
5. Copy the sync token from WordPress plugin to Disqus setup page
6. Complete the setup in Disqus dashboard
7. Go back to the Disqus plugin in WordPress (may need to refresh the settings page) and on "Syncing" tab. Click to "Import Comments"
8. In Disqus dashboard, "Export Comments"
9. Get the URL from Disqus email
10. In the Commento settings for your site, navigate to "Import Comments" and paste in export URL from Disqus
