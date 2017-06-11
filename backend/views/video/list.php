<?php
require_once "models/Backend.php";

$model = new Backend;

$link = "index.php?mod=video&act=list";
$link_form='';
if (isset($_GET['site_id']) && $_GET['site_id'] > -1) {
    $site_id = (int) $_GET['site_id']; 
    $link.="&site_id=$site_id";
    $link_form.="&site_id=$site_id";    
} else {
    $site_id = -1;
}
if (isset($_GET['cate_id']) && $_GET['cate_id'] > -1) {
    $cate_id = (int) $_GET['cate_id']; 
    $link.="&cate_id=$cate_id";
    $link_form.="&cate_id=$cate_id";    
} else {
    $cate_id = -1;
}
if (isset($_GET['status']) && $_GET['status'] > -1) {
    $status = (int) $_GET['status'];
    $link.="&status=$status";
    $link_form.="&status=$status";    
} else {
    $status = -1;
}
if(isset($_GET['site_publish'])){
    $site_publish = $model->processData($_GET['site_publish']);
    $link.='&site_publish='.$site_publish;
    $link_form.='&site_publish='.$site_publish;
}else{
    $site_publish='';
}
if(isset($_GET['created_at'])){
    $created_at = ($_GET['created_at']);
    $link.='&created_at='.$created_at;
    $link_form.='&created_at='.$created_at;
}else{
    $created_at='';
}
if(isset($_GET['published_at'])){
    $published_at = ($_GET['published_at']);
    $link.='&published_at='.$published_at;
    $link_form.='&published_at='.$published_at;
}else{
    $published_at='';
}
$limit = 50;

$arrTotal = $model->getListVideo($site_id, $cate_id, $status, $site_publish, $created_at, $published_at, -1, -1);

$arrListCate = $model->getListCate(-1);
$arrListSite = $model->getListSite();

$total_page = ceil($arrTotal['total'] / $limit);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$link_form.='&page='.$page;
$offset = $limit * ($page - 1);
$arrList = $model->getListVideo($site_id, $cate_id, $status, $site_publish,$created_at, $published_at, $offset, $limit);

?>
<h2 class="sub-header">Video List</h2>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Search</h3>
  </div>
  <div class="panel-body">
    <form action="" method="GET">
      <input type="hidden" name="mod" value="video" />
      <input type="hidden" name="act" value="list" />
    <div class="col-md-12">
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
      <div class="col-md-3">
          <div class="form-group">
            <label for="site_id">Cate</label>
            <select class="form-control" name="cate_id" id="cate_id">
              <option value="-1">All</option>
              <?php foreach ($arrListCate as $value) { ?>
              <option value="<?php echo $value['id']; ?>" <?php if($cate_id == $value['id']) echo "selected"; ?>><?php echo $value['name']; ?></option>
              <?php } ?>
            </select>
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
            <label for="site_id">Status</label>
            <select class="form-control" name="status" id="status">
              <option value="-1">All</option>
              <option value="1" <?php if($status == 1) echo "selected"; ?>>Unlisted</option>
              <option value="0" <?php if($status == 0) echo "selected"; ?>>Published</option>
            </select>
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
            <label for="site_id">Site Published</label>
            <input class="form-control" name="site_publish" id="site_publish" value="<?php echo $site_publish; ?>">
          </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for="site_id">Date crawler</label>
            <input class="form-control datepicker" name="created_at" id="created_at" value="<?php echo $created_at; ?>">
          </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
            <label for="site_id">Date Published</label>
            <input class="form-control datepicker" name="published_at" id="published_at" value="<?php echo $published_at; ?>">
          </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="col-md-12" style="text-align:right">
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
      </div>
    </div>
  </form>
  </div>
</div>
<div class="table-responsive">
  <div class="total row">
    <div class="col-md-12">
      <h4>Record found: <?php echo number_format($arrTotal['total']); ?></h4>
    <div>
  </div>
  <div class="clearfix"></div>
      <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
      <div class="clearfix"></div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th width="100px">Thumnail</th>
        <th>Site</th>
        <th>Cate</th>
        <th>Site Publish</th>
        <th width="20%">Title</th> 
        <th>Status</th>
        <th>Created at</th>
        <th>Pusblished at</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $i = ($page-1)*$limit;

      if(!empty($arrList['data'])){                   

      foreach($arrList['data'] as $value){

      $i++;                                                
      ?>
      <tr>
        <td><?php echo $i ; ?></td>
        <td><img class="lazy" data-original="<?php echo $value['thumbnailUrl']; ?>" width="80px" /></td>
        <td><?php echo $arrListSite[$value['site_id']]['name']; ?></td>
        <td><?php echo $arrListCate[$value['cate_id']]['name']; ?></td>
        <td><?php echo $value['site_publish']; ?></td>
        <td><?php echo $value['title']; ?></td>
        <td><?php echo $value['status'] == 0 ? "Pusblished" : "Unlisted"; ?></td>
        <td>
          <?php echo date('d-m-Y', strtotime($value['created_at'])); ?>
        </td>
        <td>
          <?php if($value['published_at']) echo date('d-m-Y', strtotime($value['published_at'])); ?>
        </td>
      </tr>  
      <?php }
      ?>
      
    
      <?php
      } ?>            
    </tbody>
  </table>
  <div class="clearfix"></div>
      <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('#site_id').change(function(){    
    $( "#cate_id" ).load( "ajax/cate.php?site_id=" + $(this).val());
  });
  <?php if($site_id > 0){ ?>
    $( "#cate_id" ).load( "ajax/cate.php?site_id=<?php echo $site_id; ?>", function(){
        $('#cate_id').val(<?php echo $cate_id; ?>);
    });

  <?php } ?>
});
</script>
<script>
  $(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>
