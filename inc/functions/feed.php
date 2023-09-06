<?php
function tnet_init_feed()
{
	add_feed('tnet-feed', 'tnet_feed');
}
add_action('init', 'tnet_init_feed');

function tnet_feed()
{
	$postCount = 5; // The number of posts to show in the feed
	$posts     = query_posts('showposts=' . $postCount);

	header('Content-Type: ' . feed_content_type('rss-http'), true);
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
	?>

	<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/"
		xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
		xmlns:slash="http://purl.org/rss/1.0/modules/slash/">

		<channel>
			<title>
				<?php bloginfo_rss('name') . '(' . tnet_get_language() . ')'; ?>
			</title>
			<link>
			<?php bloginfo_rss('url'); ?>
			</link>

			<description>
				<?php echo bloginfo_rss('description'); ?>
			</description>
			<copyright>
				<?php echo get_option('admin_email'); ?>
			</copyright>

			<lastBuildDate>
				<?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?>
			</lastBuildDate>
			<language>
				<?php echo tnet_get_language(); ?>
			</language>

			<?php while (have_posts()):
				the_post(); ?>

				<item>
					<title>
						<?php the_title_rss(); ?>
					</title>
					<description>
						<![CDATA[<?php the_excerpt_rss(); ?>]]>
					</description>

					<link>
					<?php the_permalink_rss(); ?>
					</link>

					<pubDate>
						<?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?>
					</pubDate>
					<guid>
						<?php echo get_the_guid(); ?>
					</guid>

					<content>
						<![CDATA[<?php the_excerpt_rss(); ?>]]>
					</content>

					<?php if (has_post_thumbnail()): ?>
						<image>
							<link>
							<?php the_post_thumbnail_url(); ?>
							</link>
							<title>
								<?php the_title_rss(); ?>
							</title>
							<url>
								<?php the_post_thumbnail_url(); ?>
							</url>
						</image>
					<?php endif; ?>
				</item>

			<?php endwhile; ?>
		</channel>
	</rss>
<?php }