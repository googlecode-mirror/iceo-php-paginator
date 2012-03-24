<!-- This should be in head, but it is here just in case 
	you were wondering where all that beauty comes from. -->
<link href="<?php echo base_url('assets/css/pagination-tnt.css'); ?>" rel="stylesheet" type="text/css" />

<div id="tnt_pagination">

<?php if($first == 'disabled'):?>
	<span class="disabled_tnt_pagination">&laquo; first</span>
<?php else: ?>
	<a href="<?php echo $first;?>">&laquo; first</a>
<?php endif;?>

<?php if($prev == 'disabled'):?>
	<span class="disabled_tnt_pagination">&lt; prev</span>
<?php else: ?>
	<a href="<?php echo $prev;?>">&lt; prev</a>
<?php endif;?>

<?php foreach ($page_links as $page):?>
<?php if($page['link'] == 'disabled'):?>
	<span class="active_tnt_link"><?php echo $page['number'];?></span>
<?php else: ?>
	<a href="<?php echo $page['link'];?>"><?php echo $page['number'];?></a>
<?php endif;?>
<?php endforeach;?>

<?php if($next == 'disabled'):?>
	<span class="disabled_tnt_pagination">next &gt;</span>
<?php else: ?>
	<a href="<?php echo $next;?>">next &gt;</a>
<?php endif;?>

<?php if($last == 'disabled'):?>
	<span class="disabled_tnt_pagination">last &raquo;</span>
<?php else: ?>
	<a href="<?php echo $last;?>">last &raquo;</a>
<?php endif;?>

</div>