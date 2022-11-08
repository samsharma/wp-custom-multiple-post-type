jQuery(document).ready( function(){
  Insert_record()

});

//Insert Record in the Database

function Insert_record(){
  jQuery(document).on('click', '#submit', function(){
    var name = jQuery('#cptName').val();
    var slugname = jQuery('#cptSlugName').val();
    var status = jQuery('#cptStatus').val();
    if(name =="" || slugname =="" || status=="" ){

      jQuery("#message").html("Please fill in blank");
      
    }else{
      jQuery.ajax({
        url: 'insert.php',
        method: 'post',
        data:{name:name,slugname:slugname,status:status},
        success:function(data){
          jQuery('#message').html(data);
        }
      })
    }
  });
}