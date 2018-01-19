<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:88:"E:\phpstudy\PHPTutorial\WWW\guanggao.com\public/../application/admin\view\test\edit.html";i:1516330059;s:83:"E:\phpstudy\PHPTutorial\WWW\guanggao.com\application\admin\view\layout\default.html";i:1516182084;s:80:"E:\phpstudy\PHPTutorial\WWW\guanggao.com\application\admin\view\common\meta.html";i:1516182084;s:82:"E:\phpstudy\PHPTutorial\WWW\guanggao.com\application\admin\view\common\script.html";i:1516182084;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label for="c-category_id" class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-category_id" data-rule="required" data-source="category/selectpage" data-params='{"custom[type]":"test"}' class="form-control selectpage" name="row[category_id]" type="text" value="<?php echo $row['category_id']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-category_ids" class="control-label col-xs-12 col-sm-2"><?php echo __('Category_ids'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-category_ids" data-rule="required" data-source="category/selectpage" data-params='{"custom[type]":"test"}' data-multiple="true" class="form-control selectpage" name="row[category_ids]" type="text" value="<?php echo $row['category_ids']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-week" class="control-label col-xs-12 col-sm-2"><?php echo __('Week'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-week" data-rule="required" class="form-control selectpicker" name="row[week]">
                <?php if(is_array($weekList) || $weekList instanceof \think\Collection || $weekList instanceof \think\Paginator): if( count($weekList)==0 ) : echo "" ;else: foreach($weekList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['week'])?$row['week']:explode(',',$row['week']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label for="c-flag" class="control-label col-xs-12 col-sm-2"><?php echo __('Flag'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
                        
            <select  id="c-flag" data-rule="required" class="form-control selectpicker" multiple="" name="row[flag][]">
                <?php if(is_array($flagList) || $flagList instanceof \think\Collection || $flagList instanceof \think\Paginator): if( count($flagList)==0 ) : echo "" ;else: foreach($flagList as $key=>$vo): ?>
                    <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['flag'])?$row['flag']:explode(',',$row['flag']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
    </div>
    <div class="form-group">
        <label for="c-genderdata" class="control-label col-xs-12 col-sm-2"><?php echo __('Genderdata'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($genderdataList) || $genderdataList instanceof \think\Collection || $genderdataList instanceof \think\Paginator): if( count($genderdataList)==0 ) : echo "" ;else: foreach($genderdataList as $key=>$vo): ?>
            <label for="row[genderdata]-<?php echo $key; ?>"><input id="row[genderdata]-<?php echo $key; ?>" name="row[genderdata]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['genderdata'])?$row['genderdata']:explode(',',$row['genderdata']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label for="c-hobbydata" class="control-label col-xs-12 col-sm-2"><?php echo __('Hobbydata'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="checkbox">
            <?php if(is_array($hobbydataList) || $hobbydataList instanceof \think\Collection || $hobbydataList instanceof \think\Paginator): if( count($hobbydataList)==0 ) : echo "" ;else: foreach($hobbydataList as $key=>$vo): ?>
            <label for="row[hobbydata][]-<?php echo $key; ?>"><input id="row[hobbydata][]-<?php echo $key; ?>" name="row[hobbydata][]" type="checkbox" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['hobbydata'])?$row['hobbydata']:explode(',',$row['hobbydata']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label for="c-title" class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text" value="<?php echo $row['title']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-content" class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <textarea id="c-content" data-rule="required" class="form-control editor" rows="5" name="row[content]" cols="50"><?php echo $row['content']; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="c-image" class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-image" data-rule="required" class="form-control" size="50" name="row[image]" type="text" value="<?php echo $row['image']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-image"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-image"></ul>
        </div>
    </div>
    <div class="form-group">
        <label for="c-images" class="control-label col-xs-12 col-sm-2"><?php echo __('Images'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-images" data-rule="required" class="form-control" size="50" name="row[images]" type="text" value="<?php echo $row['images']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-images" class="btn btn-danger plupload" data-input-id="c-images" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-images"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-images" class="btn btn-primary fachoose" data-input-id="c-images" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-images"></span>
            </div>
            <ul class="row list-inline plupload-preview" id="p-images"></ul>
        </div>
    </div>
    <div class="form-group">
        <label for="c-attachfile" class="control-label col-xs-12 col-sm-2"><?php echo __('Attachfile'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class="input-group">
                <input id="c-attachfile" data-rule="required" class="form-control" size="50" name="row[attachfile]" type="text" value="<?php echo $row['attachfile']; ?>">
                <div class="input-group-addon no-border no-padding">
                    <span><button type="button" id="plupload-attachfile" class="btn btn-danger plupload" data-input-id="c-attachfile" data-multiple="false"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                    <span><button type="button" id="fachoose-attachfile" class="btn btn-primary fachoose" data-input-id="c-attachfile" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                </div>
                <span class="msg-box n-right" for="c-attachfile"></span>
            </div>
            
        </div>
    </div>
    <div class="form-group">
        <label for="c-keywords" class="control-label col-xs-12 col-sm-2"><?php echo __('Keywords'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-keywords" data-rule="required" class="form-control" name="row[keywords]" type="text" value="<?php echo $row['keywords']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-description" class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-description" data-rule="required" class="form-control" name="row[description]" type="text" value="<?php echo $row['description']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-city" class="control-label col-xs-12 col-sm-2"><?php echo __('City'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div class='control-relative'><input id="c-city" data-rule="required" class="form-control" data-toggle="city-picker" name="row[city]" type="text" value="<?php echo $row['city']; ?>"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="c-price" class="control-label col-xs-12 col-sm-2"><?php echo __('Price'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-price" data-rule="required" class="form-control" step="0.01" name="row[price]" type="number" value="<?php echo $row['price']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-views" class="control-label col-xs-12 col-sm-2"><?php echo __('Views'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-views" data-rule="required" class="form-control" name="row[views]" type="number" value="<?php echo $row['views']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-startdate" class="control-label col-xs-12 col-sm-2"><?php echo __('Startdate'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-startdate" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[startdate]" type="text" value="<?php echo $row['startdate']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-activitytime" class="control-label col-xs-12 col-sm-2"><?php echo __('Activitytime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-activitytime" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[activitytime]" type="text" value="<?php echo $row['activitytime']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-year" class="control-label col-xs-12 col-sm-2"><?php echo __('Year'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-year" class="form-control datetimepicker" data-date-format="YYYY" data-use-current="true" name="row[year]" type="text" value="<?php echo $row['year']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-times" class="control-label col-xs-12 col-sm-2"><?php echo __('Times'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-times" class="form-control datetimepicker" data-date-format="HH:mm:ss" data-use-current="true" name="row[times]" type="text" value="<?php echo $row['times']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-refreshtime" class="control-label col-xs-12 col-sm-2"><?php echo __('Refreshtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-refreshtime" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[refreshtime]" type="text" value="<?php echo datetime($row['refreshtime']); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-weigh" class="control-label col-xs-12 col-sm-2"><?php echo __('Weigh'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-weigh" data-rule="required" class="form-control" name="row[weigh]" type="number" value="<?php echo $row['weigh']; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="c-switch" class="control-label col-xs-12 col-sm-2"><?php echo __('Switch'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input checked="" id="c-switch" name="row[switch]" type="hidden" value="0"><label for="row[switch]-switch"><input id="row[switch]-switch" name="row[switch]" type="checkbox" <?php if(in_array(($row['switch']), explode(',',"1"))): ?>checked<?php endif; ?> value="1"> abcdefg</label>
        </div>
    </div>
    <div class="form-group">
        <label for="c-status" class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>
            <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['status'])?$row['status']:explode(',',$row['status']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group">
        <label for="c-state" class="control-label col-xs-12 col-sm-2"><?php echo __('State'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            
            <div class="radio">
            <?php if(is_array($stateList) || $stateList instanceof \think\Collection || $stateList instanceof \think\Paginator): if( count($stateList)==0 ) : echo "" ;else: foreach($stateList as $key=>$vo): ?>
            <label for="row[state]-<?php echo $key; ?>"><input id="row[state]-<?php echo $key; ?>" name="row[state]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['state'])?$row['state']:explode(',',$row['state']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>