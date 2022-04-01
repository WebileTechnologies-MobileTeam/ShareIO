<?php 
if($_GET['link']){
   unlink($_GET['link']);
} else{
   unlink($_GET['file']);
}
?>