=== RSS Thumbs ===
Contributors: reblevins
Donate link: http://thedonkeysmouth.com/wordpress/plugins/rss_thumbs_widget/
Tags: rss, thumbnails, media
Requires at least: 2.7.1
Tested up to: 2.7.1
Stable tag: trunk

== Description ==

This is a plugin which will provide you with a widget in which you can pull thumbnails from up to two RSS feeds.  I created it to showcase the latest posts from my daughters’ blogs with thumbnails of the posts along with the title of the post and a link to the original post.

I wrote this because I was originally trying to use the very nice KB Advanced RSS Widget, but apparently, the feed parser in WordPress doesn’t support enclosures.  I still use the KB widget for other feeds on my blog.

Since I’m using SimplePie, I also could have just included the necessary SimplePie code in my template, but I wanted to include it with the other widgets on my blog and be able to move it around from within the WP Admin.  Besides, what’s the fun in that?

== Requirements ==

* The RSS feed from which you are pulling must contain thumbnails.  I use the plugin MediaRSS on the WordPress blog(s) providing the feed, which works great.
* Requires that both SimplePie Core and SimplePie Plugin for WordPress plugins be installed.

== Installation ==

You MUST be using a widgets-enabled theme. If you are using pre-2.2 WordPress, you’ll also need the sidebar widgets plugin.

   1. WP 2.7+: Use the plugin installer. Upload the rss-thumbs-widget folder to either /wp-content/plugins/widgets/ or /wp-content/plugins/.
   2. Activate the widget through the ‘Plugins’ menu in WordPress.
   3. Add the new RSS Thumbs widget to your sidebar through the ‘Presentation => Sidebar Widgets’ menu in WordPress.

== Features ==

* Provides a control panel where you can specify name, two feeds (one feed is also okay), how many items to display from each feed, what html should come before and after the feed(s) and the individual posts (defaults are <ul></ul>, and <li></li> respectively).
* If there is more than one thumbnail associated with a post, it will pull only the first one.
* Degrades gracefully.  If there are no thumbnails for a particluar feed or post, only the post title is included with a link to the post.

== How to use ==

Title

Pretty obvious, I think.  If you put a title in here, then that shows up, otherwise it doesn’t.
Feed 1 & Feed 2

The urls, including http://, but not including feed:, of the feeds you want to use.  The plugin uses SimplePie, so if you don’t know the exact url, SimplePie might be able to locate it.

Both feeds will be merged together and appear in the same list.
Max number of posts per feed (Default: 2)

If you have two feeds, then each feed will only be allowed to show x number of posts.
Total number of posts

This is the total number of combined posts that will be shown.
Before Feed, After Feed

The HTML you would like to have appear before the list begins.  Defaults to <ul> and </ul> respectively.
Before Item, After Item

Same as above, except this appears before each post.  Defaults to <li> and </li> respectively.

Here’s some example code using the default before and after values:

<code>
<ul>
<li>
<a href="http://link-to-blog-one">Blog One Name:</a><br /><a href="http://permalink-to-post">Post Title<br />
<img src="http://link-to-thumb.jpg" /></a>
</li>
<li>
<a href="http://link-to-blog-two">Blog Two Name:</a><br /><a href="http://permalink-to-post">Post Title<br />
<img src="http://link-to-thumb.jpg" /></a>
</li>
...
</ul>
</code>

== TO-DO List ==

* Add support for multiple instances of the widget
* Templating
* any suggestions?