<?php
/* =====================================================
	Template part containing the info about the author
	Daze - Premium WordPress Theme, by NordWood
======================================================== */
?>
<article class="author clearfix">	
	<?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ); ?>
	
	<div class="info">
		<h5><?php the_author_meta( 'nickname' ); ?></h5>
		<p><?php the_author_meta( 'description' ); ?></p>
	</div>
</article>