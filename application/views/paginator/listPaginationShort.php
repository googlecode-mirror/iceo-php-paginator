<!-- This should be in head, but it is here just in case 
	you were wondering where all that beauty comes from. -->
<link href="<?php echo base_url('assets/css/pagination.css'); ?>" rel="stylesheet" type="text/css" />

<!-- If you don't want first and last links to appear in html,
	just ignore them altogether when generating view. Easy, right? -->
<ul class="pagination">

<?php if($prev == 'disabled'):?>
	<li class="disabled">&lt; prev</li>
<?php else: ?>
	<li><a href="<?php echo $prev;?>">&lt; prev</a></li>
<?php endif;?>

<?php foreach ($page_links as $page):?>
<?php if($page['link'] == 'disabled'):?>
	<li class="current"><?php echo $page['number'];?></li>
<?php else: ?>
	<li><a href="<?php echo $page['link'];?>"><?php echo $page['number'];?></a></li>
<?php endif;?>
<?php endforeach;?>

<?php if($next == 'disabled'):?>
	<li class="disabled">next &gt;</li>
<?php else: ?>
	<li><a href="<?php echo $next;?>">next &gt;</a></li>
<?php endif;?>

</ul>
