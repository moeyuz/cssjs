<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<style>body{background-color: #fff;}</style>
<div class="row">	
		<div class="col-md-12 t_null contpost " <?php if ($this->options->rlweb == 'lble'):?>style="float: right;"<?php else : ?><?php endif; ?>>		
		        <header>
                <div class="widget-list-title"><i class="icon iconfont icon-wenjuan"></i> <span><?php if($this->_currentPage>1) echo '第 '.$this->_currentPage.' 页 - '; ?><?php $this->archiveTitle(array('category'  =>  _t('%s ')), '', ''); ?></span></div>
                </header>		
				<div class="row " id="content">
                <div class="part-list section-cont cate_s">   
                <?php if ($this->have()): ?>
                <?php while($this->next()): ?>
                      <div class="col-item item c_lt"><div class="hunter-item"><a href="<?php $this->permalink(); ?>" ><div class="hunter-thumb"><div class="feaimg"><i class="block-fea scrollLoading" data-url="<?php echo stcdn($this->fields->img); ?>"></i></div>
                      <div class="picsum-icon c_l"><?php echo imgNum($this->content) ?> 图</div>
                      </div><span><?php $this->title() ?></span>
                      <div class="a_cl"> 
                      <?php $email=$this->author->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="22" width="22">'; ?> <?php $this->author->screenName(); ?> 
                      <span class="a_cl_r"><?php Postviews($this); ?>阅读</span></div>
                      </a></div></div>
                 <?php endwhile; ?>
	             <?php endif; ?>	
                 </div> 
                 <script>$(function(){$('.cck').hide(); });</script>
                 <?php $this->pageNav('<', '>', 1, '...', array('wrapTag' => 'ol', 'wrapClass' => 'page-navigator', 'itemTag' => 'li', 'textTag' => 'span', 'currentClass' => 'current', 'prevClass' => 'prev', 'nextClass' => 'next',)); ?>
                 </div>
		 </div>
	</div>
<?php $this->need('footer.php'); ?>