<?php 
$arrListSite = $model->getListSite();
$cate_id = isset($_GET['cate_id']) ? (int) $_GET['cate_id'] : 0;
$arrDetail = array();
if($cate_id > 0){
  $arrDetail = $model->getDetailCate($cate_id);
}
?>
<div class="row">

    <h2>Cate Form</h2>

  <div style="text-align:right">    
    <button class="btn btn-default btn-sm" type="button" onclick="location.href='index.php?mod=cate&act=list'">Back</button>
  </div>
<div class="clearfix"></div>
<div class="bs-example" data-example-id="basic-forms">
  <form action="controllers/cate.php" method="POST">
    <input type="hidden" name="cate_id" value="<?php echo $cate_id; ?>">
    <div class="form-group">
      <label for="quantity">Site</label>
      <select class="form-control" id="site_id" name="site_id">
        <?php foreach ($arrListSite as $value) { ?>          
        <option value="<?php echo $value['id']?>" <?php if(!empty($arrDetail) && $arrDetail['site_id']==$value['id']) echo "selected"; ?>><?php echo $value['name']?></option>
        <?php } ?>
        
      </select>
    </div>
    <div class="form-group">
      <label for="name">Cate name</label>
      <input type="text" class="form-control" id="name" name="name" value="<?php if(!empty($arrDetail)) echo $arrDetail['name']; ?>">
    </div>
    <div class="form-group">
      <label for="url">Cate URL</label>
      <input type="text" class="form-control" id="url" name="url" value="<?php if(!empty($arrDetail)) echo $arrDetail['url']; ?>">
    </div>
    <input type="hidden" value="10" name="quantity">
    <!--
    <div class="form-group">
      <label for="quantity">Video Crawler / Day</label>
      <input type="text" class="form-control" id="quantity" name="quantity" value="<?php if(!empty($arrDetail)) echo $arrDetail['quantity']; ?>">
    </div>
    -->
    <div class="form-group">
      <label for="quantity">Status</label>
      <select class="form-control" id="status" name="status">
        <option value="0" <?php if(!empty($arrDetail) && $arrDetail['status']==0) echo "selected"; ?>>Close</option>
        <option value="1" <?php if(!empty($arrDetail) && $arrDetail['status']==1) echo "selected"; ?>>Open</option>
      </select>
    </div>
    
    <button type="submit" class="btn btn-primary btn-sm">Save</button>
    <button class="btn btn-default btn-sm" type="button" onclick="location.href='index.php?mod=cate&act=list'">Cancel</button>
  </form>
</div>
</div>