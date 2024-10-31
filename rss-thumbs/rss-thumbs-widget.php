<?php
/*
Plugin Name: RSS Thumbs
Plugin URI: http://thedonkeysmouth.com/wordpress/plugins/rss_thumbs_widget/
Description: Pulls thumbnails from up to two different feeds and displays them along with the title of the post. Both are linked to the original post.
Version: 1.0.1
Author: RE Blevins
Author URI: http://thedonkeysmouth.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

//error_reporting(E_ALL);
add_action("widgets_init", array('rss_thumbs_widget', 'register'));
register_activation_hook( __FILE__, array('rss_thumbs_widget', 'activate'));
register_deactivation_hook( __FILE__, array('rss_thumbs_widget', 'deactivate'));

class rss_thumbs_widget {
  function activate(){
    $data = array( 'rss_thumbs_widget_title' => '',
	'rss_thumbs_widget_feed1' => '',
	'rss_thumbs_widget_feed2' => '',
	'rss_thumbs_widget_before_feed' => '<ul>',
	'rss_thumbs_widget_max_per_feed' => 2,
	'rss_thumbs_widget_total_posts' => 4,
	'rss_thumbs_widget_after_feed' => '</ul>',
	'rss_thumbs_widget_before_thumb' => '<li>',
	'rss_thumbs_widget_after_thumb' => '</li>'
	);
    if ( ! get_option('rss_thumbs_widget')){
      add_option('rss_thumbs_widget' , $data);
    } else {
      update_option('rss_thumbs_widget' , $data);
    }
  }
  function deactivate(){
    delete_option('rss_thumbs_widget');
  }
  function control(){
  $data = get_option('rss_thumbs_widget');
  ?>
  <p><label for="rss_thumbs_widget_title">Title (optional)<input name="rss_thumbs_widget_title"
type="text" value="<?php echo $data['rss_thumbs_widget_title']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_feed1">Feed 1<br><input name="rss_thumbs_widget_feed1"
type="text" value="<?php echo $data['rss_thumbs_widget_feed1']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_feed2">Feed 2 (optional)<input name="rss_thumbs_widget_feed2"
type="text" value="<?php echo $data['rss_thumbs_widget_feed2']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_max_per_feed">Max number of posts per feed<input name="rss_thumbs_widget_max_per_feed"
type="text" value="<?php echo $data['rss_thumbs_widget_max_per_feed']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_total_posts">Total number of posts<input name="rss_thumbs_widget_total_posts"
type="text" value="<?php echo $data['rss_thumbs_widget_total_posts']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_before_feed">Before Feed<input name="rss_thumbs_widget_before_feed"
type="text" value="<?php echo $data['rss_thumbs_widget_before_feed']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_after_feed">After Feed<input name="rss_thumbs_widget_after_feed"
type="text" value="<?php echo $data['rss_thumbs_widget_after_feed']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_before_thumb">Before Item<input name="rss_thumbs_widget_before_thumb"
type="text" value="<?php echo $data['rss_thumbs_widget_before_thumb']; ?>" /></label></p>
  <p><label for="rss_thumbs_widget_after_thumb">After Item<input name="rss_thumbs_widget_after_thumb"
type="text" value="<?php echo $data['rss_thumbs_widget_after_thumb']; ?>" /></label></p>
  <?php
   if (isset($_POST['rss_thumbs_widget_feed1'])){
    $data['rss_thumbs_widget_title'] = attribute_escape($_POST['rss_thumbs_widget_title']);
    $data['rss_thumbs_widget_feed1'] = attribute_escape($_POST['rss_thumbs_widget_feed1']);
    $data['rss_thumbs_widget_feed2'] = attribute_escape($_POST['rss_thumbs_widget_feed2']);
    $data['rss_thumbs_widget_total_posts'] = attribute_escape($_POST['rss_thumbs_widget_total_posts']);
    $data['rss_thumbs_widget_max_per_feed'] = attribute_escape($_POST['rss_thumbs_widget_max_per_feed']);
    $data['rss_thumbs_widget_before_thumb'] = attribute_escape($_POST['rss_thumbs_widget_before_thumb']);
    $data['rss_thumbs_widget_after_thumb'] = attribute_escape($_POST['rss_thumbs_widget_after_thumb']);
    update_option('rss_thumbs_widget', $data);
  }
  }  
  function widget($args){
  
  	// First we check to see if they actually saved a feed before trying to output the widget
    $data = get_option('rss_thumbs_widget');
	if (isset($data['rss_thumbs_widget_feed1'])) {
		echo $args['before_widget'];
		$feeds = array();
		$feeds[0] = $data['rss_thumbs_widget_feed1'];
		if (isset($data['rss_thumbs_widget_feed2'])) {
			$feeds[1] = $data['rss_thumbs_widget_feed2'];
		}
		$feed = new SimplePie();
		$feed->set_feed_url($feeds);
		$feed->set_item_limit($data['rss_thumbs_widget_max_per_feed']);
		$feed->enable_cache(false);
		$feed->init();
		$feed->handle_content_type();
		
		//Since the title is optional, let's see if they even put one in
		if (isset($data['rss_thumbs_widget_title'])) {
			echo $args['before_title'] . $data['rss_thumbs_widget_title'] . $args['after_title'];
			$widget_class = sanitize_title($data['rss_thumbs_widget_title']);
		} else {
			$widget_class = '';
		}
		
		echo html_entity_decode($data['rss_thumbs_widget_before_feed']);
		 
		foreach ($feed->get_items(0, $data['rss_thumbs_widget_total_posts']) as $item)
		{ ?>
			<?php echo html_entity_decode($data['rss_thumbs_widget_before_thumb']); ?><a href="<?php echo $item->get_feed()->get_permalink(); ?>"><?php echo $item->get_feed()->get_title(); ?>:</a><br /><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?><br />
			<?php
			if ($enclosure = $item->get_enclosure())
			{
				echo "<img src=\"".$enclosure->get_thumbnail()."\" />";
			} ?>
			</a><?php echo html_entity_decode($data['rss_thumbs_widget_after_thumb']); ?>
		<?php }
		echo html_entity_decode($data['rss_thumbs_widget_after_feed']);
		echo $args['after_widget'];
	}
  }
  function register(){
    register_sidebar_widget('RSS Thumbs', array('rss_thumbs_widget', 'widget'));
    register_widget_control('RSS Thumbs', array('rss_thumbs_widget', 'control'));
  }
}

?>