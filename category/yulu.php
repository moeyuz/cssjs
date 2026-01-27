<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div class="row author-page">
    <div class="col-md-9 archive-content video-index" <?php if ($this->options->rlweb == 'lble'):?>style="float: right;"<?php else : ?><?php endif; ?>>	
	<header><div class="widget-list-title"><i class="icon iconfont icon-wenjuan"></i> <span><?php if($this->_currentPage>1) echo '第 '.$this->_currentPage.' 页 - '; ?><?php $this->archiveTitle(array('category'  =>  _t('%s ')), '', ''); ?></span></div></header>   
	<div class="row" id="content">   
    <ul class="archilist"><div id="spimes-archives">
  <?php if ($this->have()): ?>
    <?php while($this->next()): ?>     
     <li class="list-archive-day"> <a href="<?php $this->permalink(); ?>"><div class="toggle"></div><?php $this->title() ?><?php if(timeZone($this->date->timeStamp)) echo '<span class="badge arc_v2">最新</span>'; ?></a><div class="tmes"><i class="icon iconfont icon-huatifuhao"></i><?php $this->tags(',', false, ','); ?><span class="separator">/</span><i><?php Postviews($this); ?> 阅读</i><span class="separator">/</span><span class="time"><?php $this->date('m-d'); ?></span></div></li>
   <?php endwhile; ?>
	<?php endif; ?>
  </div></ul>
<script>$(function(){$('.cck').hide(); });</script>
      <?php $this->pageNav('<', '>', 1, '...', array('wrapTag' => 'ol', 'wrapClass' => 'page-navigator', 'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'current', 'prevClass' => 'prev', 'nextClass' => 'next',)); ?>
   </div>		
    </div><!-- end #main -->    
    <?php $this->need('sidebar.php'); ?>
</div>
<?php $this->need('footer.php'); ?>
