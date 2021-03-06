<?php js::set('programID', $programID);?>
<?php js::set('module', $module);?>
<?php js::set('method', $method);?>
<?php js::set('extra', $extra);?>
<?php
$iCharges = 0;
$others   = 0;
$dones    = 0;
$programNames = array();
$myProgramsHtml     = '';
$normalProgramsHtml = '';
$closedProgramsHtml = '';
foreach($programs as $program)
{
    if($program->status != 'done' and $program->status != 'closed' and $program->PM == $this->app->user->account) $iCharges++;
    if($program->status != 'done' and $program->status != 'closed' and !($program->PM == $this->app->user->account)) $others++;
    if($program->status == 'done' or $program->status == 'closed') $dones++;
    $programNames[] = $program->name;
}
$programsPinYin = common::convert2Pinyin($programNames);

foreach($programs as $program)
{
    $link = $this->createLink('program', 'index', "programID=$program->id", '', '', $program->id);
    if($program->status != 'done' and $program->status != 'closed' and $program->PM == $this->app->user->account)
    {
        $myProgramsHtml .= html::a($link, "<i class='icon icon-folder-outline'></i> " . $program->name, '', "class='text-important' title='{$program->name}' data-id={$program->id} data-key='" . zget($programsPinYin, $program->name, '') . "'");
    }
    else if($program->status != 'done' and $program->status != 'closed' and !($program->PM == $this->app->user->account))
    {
        $normalProgramsHtml .= html::a($link, "<i class='icon icon-folder-outline'></i> " . $program->name, '', "title='{$program->name}' data-id={$program->id} data-key='" . zget($programsPinYin, $program->name, '') . "'");
    }
    else if($program->status == 'done' or $program->status == 'closed') $closedProgramsHtml .= html::a($link, "<i class='icon icon-folder-outline'></i> " . $program->name, '', "title='{$program->name}' data-id={$program->id} data-key='" . zget($programsPinYin, $program->name, '') . "'");
}
?>
<div class="table-row">
  <div class="table-col col-left">
    <div class='list-group'>
    <?php
    if(!empty($myProgramsHtml))
    {
        echo "<div class='heading'>{$lang->project->mine}</div>";
        echo $myProgramsHtml;
        if(!empty($myProgramsHtml))
        {
            echo "<div class='heading'>{$lang->project->other}</div>";
        }
    }
    echo $normalProgramsHtml;
    ?>
    </div>
    <div class="col-footer">
      <div class='pull-left'>
        <?php echo html::a(helper::createLink('program', 'browse', 'status=all'), '<i class="icon icon-cards-view muted"></i> ' . $lang->project->all, '', 'class="not-list-item"'); ?>
      </div>
      <div class='pull-right'>
        <span class='text-muted muted'> &nbsp; | &nbsp; </span>
        <a class='toggle-right-col not-list-item'><?php echo $lang->project->doneProjects?><i class='icon icon-angle-right'></i></a>
      </div>
    </div>
  </div>
  <div class="table-col col-right">
    <div class='list-group'>
    <?php
    echo $closedProgramsHtml;
    ?>
    </div>
  </div>
</div>
