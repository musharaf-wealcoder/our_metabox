<?php

  /*
      Plugin Name: Our Metabox
      version: 1.0
      Text Domain: omb
      Domain Path: /language

  */

class OurMetabox{

  public function __construct()
  {
    add_action('plugins_loaded', array($this, 'omb_plugin_textdomain_loaded'));
    add_action('admin_menu', array($this, 'omb_add_metabox'));

  }

  public function omb_plugin_textdomain_loaded()
  {
    load_plugin_textdomain('omb', false, plugin_dir_url(__FILE__). '/language');
  }
}

new OurMetabox; 

?>