<?php 

if(!defined('WP_UNINSTALL_PLUGIN')){
  header("location:/demoProject");

}

   //DB connect and table name
   global $wpdb , $table_prefix;
   $wp_cpt = $table_prefix .'cpt'; 

   $q = "DROP TABLE `$wp_cpt`";
   $wpdb->query($q); // this work for execute 

?>