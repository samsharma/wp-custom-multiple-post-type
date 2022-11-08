<?php 

/**
* Plugin Name: Wp Custom post
* Plugin URI: 
* Description: This plugins will create custom post type.
* Version: 1.0
* Author: Metacube
* Author URI: 
**/


if(!defined('ABSPATH')){
       header("location:/demoProject");
       //die("Can't access");
}


function wp_custom_post_activation(){
       //DB connect and table name
       global $wpdb , $table_prefix;
       $wp_cpt = $table_prefix .'cpt'; 

       // create table in DB
       $q = "CREATE TABLE IF NOT EXISTS `$wp_cpt` (`ID` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(50) NOT NULL , `slugname` VARCHAR(100) NOT NULL , `cpticon` VARCHAR(50) NOT NULL , `status` BOOLEAN NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
       $wpdb->query($q); // this work for execute 

       //Insert Data in table

       //$q= "INSERT INTO `$wp_cpt` (`ID`, `name`, `slugname`, `status`) VALUES (NULL, 'News', 'news', '1');";  // this not safe 
       //$wpdb->query($q);// this work for execute 

       $data = array(
              'name' => 'News',
              'slugname' => 'news',
              'cpticon' => 'dashicons-welcome-write-blog',
              'status' => 1
       );

        $wpdb->insert($wp_cpt, $data);

     

       


}
register_activation_hook( __FILE__, "wp_custom_post_activation");


function wp_custom_post_deactivation(){

        //DB connect and table name
        global $wpdb , $table_prefix;
        $wp_cpt = $table_prefix .'cpt'; 

        //$q = "DROP TABLE `$wp_cpt`";
        $q = "TRUNCATE TABLE `$wp_cpt`";
        $wpdb->query($q); // this work for execute 

}
register_deactivation_hook( __FILE__, "wp_custom_post_deactivation");


// admin page view

function customerview_admin_page(){
       ?>
      
      <h2>Coustom Post Tye</h2>
      <div class="formbox" id="createCPT">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>">
          
                      <div class="form-row">
                          <label>  Custom post Type Name: <sup>*</sup></label>
                           <div class="form-inputbox"> <input type="text" name="cptName"></div>
                     </div>
                     <div class="form-row">
                           <label> Custom post Type Sulg Name: <sup>*</sup></label>
                           <div class="form-inputbox"><input type="text" name="cptSlugName"></div>
                     </div>
                     <div class="form-row">
                            <label> post Type icon: <sup>*</sup></label>
                            <div class="form-inputbox"><input type="text" name="cpticon">
                            <div class="iframbx">
                            <p>View icon list click  <a target="_blank" href="https://developer.wordpress.org/resource/dashicons/#welcome-write-blog">here</a></p>
                            </div></div>
                     
                          
                     </div> 
                     <div class="form-row">
                            <label> post Type Status: <sup>*</sup></label>
                            <div class="form-inputbox"><input type="text" name="cptStatus"></div>
                     </div>       
                     
                     <div class="form-row">
                     <label></label>
                     <div class="form-inputbox">
                            <input type="submit" class="submit-btn" name="submit" value="Submit">
                     </div>
                     </div>
              
       </form>
       </div>
       <div class="formbox" id="editCPT" style="display: none;">
              <div id="message"></div>
      <form>
          
                     <div class="form-row">
                          <label>  Custom post Type Name: <sup>*</sup></label>
                           <div class="form-inputbox"> <input type="text" id="cptName"></div>
                     </div>
                     <div class="form-row">
                           <label> Custom post Type Sulg Name: <sup>*</sup></label>
                           <div class="form-inputbox"><input type="text" id="cptSlugName"></div>
                     </div>
                     <div class="form-row">
                            <label> post Type Status: <sup>*</sup></label>
                            <div class="form-inputbox"><input type="text" id="cptStatus"></div>
                     </div>       
                     
                     <div class="form-row">
                     <label></label>
                     <div class="form-inputbox">
                            <button type="button"  class="submit-btn" id="submit">Submit</button>
                     </div>
                     </div>
              
       </form>
       </div>

       <div class="CPT-list-box">
              <?php 

                      //fatch data from db
              global $wpdb , $table_prefix;
              $wp_cpt = $table_prefix .'cpt'; 

              $ShowData = "SELECT * FROM `$wp_cpt`; ";
              $showResults = $wpdb->get_results($ShowData);
              ?>
                            <table>
                                   <thead>
                                          <tr>
                                                 <th>
                                                        id
                                                 </th>
                                                 <th>
                                                       CPT Name
                                                 </th>
                                                 <th>
                                                        CPT Sulg Name
                                                 </th>
                                                 <th>
                                                        CPT icon
                                                 </th>
                                                 <th>
                                                        CPT Status
                                                 </th>
                                          </tr>
                                   </thead>
                                   <tbody>
             <?php  foreach($showResults as $showRow){ 
                   
                     ?>
                          
                                          <tr>
                                                 <td>
                                                        <?php  print_r($showRow->ID)  ?>
                                                        
                                                 </td>
                                                 <td>
                                                        <?php print_r($showRow->name);  ?>
                                                        
                                                 </td>
                                                 <td>
                                                        <?php  print_r($showRow->slugname);  ?>
                                                        
                                                 </td>
                                                 <td>
                                                 <span class="dashicons-before <?php  print_r($showRow->cpticon);  ?>"></span>
                                                       
                                                        
                                                 </td>
                                                 <td>
                                                        <?php  print_r($showRow->status);  ?>
                                                        
                                                 </td>
                                          </tr>
                                 
                     <?php
              }
              
              ?>
                                   </tbody>
                            </table>

       </div>

       <?php
              if ($_SERVER['REQUEST_METHOD'] == 'POST'){
              // Defining variables
              $name = $slugname = $cptstatus = $cpticon = "";

              // Checking for a POST request
              $name = $_POST["cptName"];
              $slugname = $_POST["cptSlugName"];
              $cptstatus = $_POST["cptStatus"];
              $cpticon = $_POST["cpticon"];


              // validation
              if($name == "" ||  $slugname == "" || $cptstatus == "" || $cpticon == "" ){
                     ?> 
                     <p>Please fill </p>
                     <?php
              }else{
                     
               // db connect with insert query     
              global $wpdb , $table_prefix;
              $wp_cpt = $table_prefix .'cpt'; 

              

              $data = array(
                     'name' => $name,
                     'slugname' => $slugname,
                     'cpticon' => $cpticon,
                     'status' => $cptstatus
              );
       
               $wpdb->insert($wp_cpt, $data);

              // after submit data page refresh
               echo "<meta http-equiv='refresh' content='0'>";
              }

              //end of validation
 
              }
              //end of submit action      
            
     
     
      }
      function my_admin_menu() {
            add_menu_page(
    'Customer Request View', 
    'Customer Requests', 
    'manage_options', 
    'myplugin/View_Customer_Details.php', 
    'customerview_admin_page', 
    'dashicons-tag', 20  );
     }

add_action('admin_menu', 'my_admin_menu' );

// end of  admin page view

/////**** start custome post type ****///////

       function   my_custom_post() {

              //fatch data from db
              global $wpdb , $table_prefix;
              $wp_cpt = $table_prefix .'cpt'; 

              $dataQ = "SELECT * FROM `$wp_cpt`; ";
              $results = $wpdb->get_results($dataQ);
              
       foreach($results as $row){
         $labels = array(
           'name'               => _x( $row->name, 'post type general name' ),
           'singular_name'      => _x( $row->slugname, 'post type singular name' ),
           'add_new'            => _x( 'Add New', $row->name ),
           'add_new_item'       => __( 'Add New'.$row->name ),
           'edit_item'          => __( 'Edit'. $row->name ),
           'new_item'           => __( 'New'. $row->name ),
           'all_items'          => __( 'All'. $row->name ),
           'view_item'          => __( 'View Product' ),
           'search_items'       => __( 'Search'. $row->name ),
           'not_found'          => __( 'No'. $row->name.' found' ),
           'not_found_in_trash' => __( 'No'. $row->name .'found in the Trash' ), 
           'parent_item_colon'  => __('Parent'. $row->name),
           'menu_name'          => $row->name,
         );
         $args = array(
           'labels'        => $labels,
           'description'   => 'Holds our movies and product specific data',
           'public'        => true,
           'menu_position' => 5,
           'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ),
           'has_archive'   => true,
           'menu_icon'     => $row->cpticon,
         );
         register_post_type( $row->name , $args ); 
       }
       //end of foreach
       }
       add_action( 'init', 'my_custom_post', 0);

/////**** end of  custome post type ****///////


/// style and js //////

function my_custom_scripts(){
       //js
       $path_script = plugins_url('style/js/main.js', __FILE__);
       $dep_script = array('jquery');
       $ver_script = filemtime(plugin_dir_path(__FILE__).'style/js/main.js');
       wp_enqueue_script('my-custom-js', $path_script, $dep_script, $ver_script, true);
       
       //css
       $path_css = plugins_url('style/css/CPT-style.css', __FILE__);
       $ver_css = filemtime(plugin_dir_path(__FILE__).'style/css/CPT-style.css');
       wp_enqueue_style('my-custom-css', $path_css, $ver_css, );


       }
       
     
       add_action('admin_enqueue_scripts','my_custom_scripts'); // load for back-end

?>