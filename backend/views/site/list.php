<?php
$link = "index.php?mod=age&act=list";
$arrList = $model->getListSite();
?>
<h2 class="sub-header">Site List</h2>
<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>URL</th>
        <th>Total Cate</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $i = 0;

      if(!empty($arrList)){                   

      foreach($arrList as $value){

      $i++;                                                
      ?>
      <tr>
        <td><?php echo $i ; ?></td>
        <td><?php echo $value['name']; ?></td>
        <td><?php echo $value['url']; ?></td>
        <td><?php echo $model->getTotalCateBySite($value['id']); ?>
          - 
        <a href="index.php?mod=cate&act=list&site_id=<?php echo $value['id']?>" target="_blank">View</a>
        </td>
        <td><?php echo $value['status'] == 1 ? "Open" : "Close"; ?></td>
        <td>
          
        </td>
      </tr>  
      <?php }
      } ?>                   
    </tbody>
  </table>
</div>