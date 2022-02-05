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
    add_action('plugins_loaded', array($this, 'omb_textdomain_loaded'));
    add_action('add_meta_boxes', array($this, 'omb_metabox_add_func'));
    add_action('save_post', array($this, 'omb_metabox_data_save'));
  }

  private function is_secure($nonce_name, $omb_action, $post_id){

    $nonce = isset($_POST[$nonce_name]) ? $_POST[$nonce_name] : '';
    if($nonce == ''){
      return false;
    }
 
 
     if(!wp_verify_nonce($nonce,  $omb_action))
     {
       return false;
     }
 
     if(!current_user_can('edit_post', $post_id))
     {
       return false;
     }
 
     if(wp_is_post_autosave( $post_id ))
     {
       return false;
     }
 
     if(wp_is_post_revision( $post_id ))
     {
       return false;
     }
 
  }


  public function omb_metabox_data_save($post_id)
  {

    if(!$this->is_secure('omb_nonce_field', 'omb_nonce_action', $post_id)){
      return $post_id;
    }

    $location = isset($_POST['omb_input_name']) ? $_POST['omb_input_name'] : '';

    add_post_meta($post_id, 'omb_input_name', $location);

  }

  public function omb_metabox_add_func()
  {
    add_meta_box(
      'omb_metabox_id',
      __('Location track','omb'),
      array($this, 'omb_display_meta_box'),
      'page',
      'normal'
    );
  }

  

  public function omb_display_meta_box($post)
  {

    $location = get_post_meta($post->ID, 'omb_metabox_id', true );
    $country = get_post_meta($post->ID, 'omb_country_name', true );

    $label = __('Location', 'omb');
    $label1 = __('Country', 'omb');
    wp_nonce_field('omb_nonce_action', 'omb_nonce_field');

    $metabox_form = <<<EOD
      <div>
        <label for="">{$label}</label>
        <input type="text" class="regular-text" name="omb_input_name"  value="{$location}" />
      </div>

      <div>
        <label for="omb_country">{$label1}</label>
        <input type="text" class="regular-text" name="omb_country_name" id="omb_country"  value="{$country}" />
      </div>


    EOD;

    echo $metabox_form;
  }


  public function omb_textdomain_loaded()
  {
    load_plugin_textdomain('omb', false, plugin_dir_url(__FILE__). "/language");
  }



























  // public function __construct()
  // {
  //   add_action('plugins_loaded', array($this, 'omb_plugin_textdomain_loaded'));
  //   add_action('add_meta_boxes', array($this, 'omb_add_metabox'));
  //   add_action('save_post',array($this, 'omb_metabox_data_save'));


  // }

  // public function omb_metabox_data_save($post_id)
  // {
  //     $location = isset($_POST['omb_meta_input']) ? $_POST['omb_meta_input'] : '';

  //     if($location == ""){
  //       return $post_id;
  //     }

  //     update_post_meta($post_id, 'omb_meta_input', $location);
  
  // }

  // public function omb_add_metabox()
  // {
  //   add_meta_box(
  //     'omb_post_location', 
  //     __('your Location', 'omb'),
  //     array($this,'omb_display_meta'),
  //     'post',
  //     'side',
  //     'high'
     
  //     );
  // }


  // public function omb_display_meta($post)
  // {
  //   $location = get_post_meta($post->id, 'omb_post_location', true);
  //   $metabox = <<<EOD
  //     <p>

  //       <label for="metabox_input"> locatoin </label>
  //       <input type="text" name="omb_meta_input" id="metabox_input" value="{$location}"/>
        
      
  //     </p>

  //   EOD;


  //   echo $metabox;
  // }

  // public function omb_plugin_textdomain_loaded()
  // {
  //   load_plugin_textdomain('omb', false, plugin_dir_url(__FILE__). '/language');
  // }
}

new OurMetabox; 

?>