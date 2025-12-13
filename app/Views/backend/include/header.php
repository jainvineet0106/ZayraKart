<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panal</title>
    <link rel="icon" href="<?php echo base_url();?>public/frontend/assets/images/favicon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>public/backend/CSS/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/backend/CSS/res_style.css">
</head>

<script>
  // function confirmDelete(id,table,img=None) {
  //   let opt =  confirm("Are you sure you want to delete this experience?");
  //   if(opt) {
  //     // Assuming you have a delete endpoint set up
  //     window.location.href = "delete.php?id="+id+"&table="+table+"&img="+img;
  //   }
  // }
  function confirmdelete($id, $tb, $redirect){
    let allow = confirm("Sure To Delete This!");
    if(allow){
      window.location.href = "deleteData/"+$id+"/"+$tb+"/"+$redirect;
    }
  }
</script>