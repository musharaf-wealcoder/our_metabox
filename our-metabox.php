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
    add_action('save_post',array($this, 'omb_metabox_data_save'));


  }

  public function omb_metabox_data_save($post_id)
  {
      $location = isset($_POST['omb_meta_input']) ? $_POST['omb_post_location'] : '';

      if($location == ""){
        return $post_id;
      }

      update_post_meta($post_id, 'omb_meta_input', $location);
  
  }

  public function omb_add_metabox()
  {
    add_meta_box(
      'omb_post_location', 
      __('your Location', 'omb'),
      array($this,'omb_display_meta'),
      'post',
      'side',
      'high'
     
      );
  }


  public function omb_display_meta($post)
  {
    $location = get_post_meta($post->id, 'omb_post_location', true);
    $metabox = <<<EOD
      <p>

        <label for="metabox_input"> locatoin </label>
        <input type="text" name="omb_meta_input" id="metabox_input" value="{$location}"/>
        
      
      </p>

    EOD;


    echo $metabox;
  }



  public function omb_plugin_textdomain_loaded()
  {
    load_plugin_textdomain('omb', false, plugin_dir_url(__FILE__). '/language');
  }
}

new OurMetabox; 

?>