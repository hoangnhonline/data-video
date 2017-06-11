<?php
$link = "index.php?mod=age&act=list";
$site_id = isset($_GET['site_id']) ? (int) $_GET['site_id'] : -1;
$arrList = $model->getListCate($site_id);
$arrListSite = $model->getListSite();
?>

    <h2 class="sub-header">Cate List</h2>
 
  
<div class="clearfix"></div>
<div class="panel-body">  
    <div class="col-md-12">
      <div class="col-md-9">
        <button class="btn btn-primary btn-sm" type="button" onclick="location.href='index.php?mod=cate&act=form'">Add new</button>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="site_id">Site</label>
          <select class="form-control" name="site_id" id="site_id">
            <option value="-1">All</option>
            <?php foreach ($arrListSite as $value) { ?>
            <option value="<?php echo $value['id']; ?>" <?php if($site_id == $value['id']) echo "selected"; ?>><?php echo $value['name']; ?></option>
            <?php } ?>
          </select>         
        </div>
      </div>     
    </div>  
  </div>
  <div class="total row">
    <div class="col-md-12">
      <h4>Record found: <?php echo number_format(count($arrList)); ?></h4>
    </div>
  </div>
<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Site</th>
        <th>Cate</th>
        <th>URL</th>
       <!-- <th style="text-align:right">Video Crawler / Day</th>-->
        <th style="text-align:right">Total Video</th>
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
        <td><?php 
        echo $model->getSiteNameById($value['site_id']);
        ?></td>
        <td><?php echo $value['name']; ?></td>
        <td><?php echo $value['url']; ?></td>
        <!--<td style="text-align:right"><?php echo $value['quantity']; ?></td>-->
        <td style="text-align:right">
          Total : <?php echo number_format($model->getTotalVideoByCate($value['id'])); ?>
          <br />
          Published : <?php echo number_format($model->getTotalVideoPublishByCate($value['id'])); ?>
          <br />
          Unlisted : <?php echo number_format($model->getTotalVideoUnlistedByCate($value['id'])); ?>
          <br />
        </td>
        <td style="vertical-align:middle"><?php echo $value['status'] == 1 ? "<span style='color:green'>Open</span>" : "<span style='color:red'>Close</span>"; ?></td>
        <td style="vertical-align:middle">
          <a href="index.php?mod=cate&act=form&cate_id=<?php echo $value['id']; ?>" title="edit"> 
            <span class="glyphicon glyphicon-pencil"></span>
          </a>  
          &nbsp;&nbsp
          <a href="controllers/delete.php?mod=cate&id=<?php echo $value['id']; ?>" title="delete" onclick="return confirm('Are you sure?'); "> 
            <span class="glyphicon glyphicon-trash"></span>
          </a>        
        </td>
      </tr>  
      <?php }
      } ?>                   
    </tbody>
  </table>
</div>
<script type="text/javascript">
$(function(){
  $('#site_id').change(function(){
    location.href="index.php?mod=cate&act=list&site_id=" + $(this).val();
  })
});
</script>