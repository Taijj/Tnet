


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="post-header">
		<h2 class="post-title"><?php the_title(); ?></h2>
		<div class="post-date"><?php tnet_echo_post_date(); ?></div>

	</header>

	<div class="post-content"> <?php the_content(); ?> </div>

</article>