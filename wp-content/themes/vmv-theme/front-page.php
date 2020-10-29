<?php get_header(); ?>
<main class="front-page-header">
	<div class="container">
		<div class="hero">
			<div class="left">
				<?php
				global $post;
				// объявляем глобальную прерменную 
				$myposts = get_posts([
					'numberposts' => 1,
					'category_name' => 'javascript, css, html, web-design',
				]);
				//  Проверяем, есть ли посты
				if ($myposts) {
					// если есть, запускаем цикл
					foreach ($myposts as $post) {
						setup_postdata($post); ?>
						<!-- выводим записи	-->
						<img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>" class="post-thumb" />
						<?php $author_id = get_the_author_meta('ID'); ?>
						<a href="<?php echo get_author_posts_url($author_id) ?>" class="author">
							<img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author() ?>" class="avatar" />
							<div class="author-bio">
								<span class="author-name"><?php the_author(); ?></span>
								<span class="author-rank">Должность</span>
							</div>
						</a>
						<div class="post-text">
							<?php the_category(); ?>
							<h2 class="post-title">
								<?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?>
							</h2>
							<a href="<?php echo get_the_permalink() ?>" class="more">Читать далее</a>
						</div>
					<?php
					}
				} else {
					?>
					<p>Постов нет</p>
				<?php
				}
				wp_reset_postdata();
				?>
			</div>
			<!-- /.left -->
			<div class="right">
				<h3 class="recommend">Рекомендуем</h3>
				<ul class="posts-list">
					<?php
					global $post;
					// объявляем глобальную прерменную 
					$myposts = get_posts([
						'numberposts' => 5,
						'offset' => 1,
						'category_name' => 'javascript, css, html, web-design',
					]);
					// Проверяем, есть ли посты? 
					if ($myposts) {
						// если есть, запускаем цикл 
						foreach ($myposts as $post) {
							setup_postdata(
								$post
							); ?>
							<li class="post">
								<?php the_category(); ?>
								<a class="post-permalink" href="<?php echo get_the_permalink() ?>">
									<h4 class="post-title">
										<?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?>
									</h4>
								</a>
							</li>
						<?php
						}
					} else {
						?>
						<p>Постов нет</p>
					<?php
					}
					wp_reset_postdata();
					?>
				</ul>
			</div>
			<!-- /.right -->
		</div>
		<!-- /.hero -->
	</div>
	<!-- /.container -->
</main>
<div class="container">
	<ul class="article-list">
		<?php
		global $post;
		// объявляем глобальную прерменную 
		$myposts = get_posts([
			'numberposts' => 4,
			'category_name' => 'articles',
		]);
		// Проверяем, есть ли посты?
		if ($myposts) {
			// если есть, запускаем цикл 
			foreach ($myposts as $post) {
				setup_postdata($post); ?>
				<li class="article-item">
					<a class="article-permalink" href="<?php echo get_the_permalink() ?>">
						<h4 class="article-title">
							<?php echo mb_strimwidth(get_the_title(), 0, 50, '...'); ?>
						</h4>
					</a>
					<img class="article-thumb" src="<?php the_post_thumbnail_url(null, 'thumbnail') ?>" alt="<?php the_title() ?>" />
				</li>
			<?php
			}
		} else {
			?>
			<p>Постов нет</p>
		<?php
		}
		wp_reset_postdata();
		?>
	</ul>
	<!--/.article-list  -->
	<div class="main-grid">
		<ul class="article-grid">
			<?php
			global $post;
			// формируем запрос в базу данных
			$query = new WP_Query([
				// Получаем 7 постов
				'posts_per_page' =>	7,
				'category__not_in' => 29
			]);
			// провераем, если посты 
			if ($query->have_posts()) {
				// создаем  переменнрую-счетчик постов 
				$cnt = 0; /* cnt - counter */
				// пока посты есть,	выводим их 
				while ($query->have_posts()) {
					$query->the_post();
					// увеличиваем счетчик постов 
					$cnt++;
					switch ($cnt) {
							// Выводим первый пост
						case '1': ?>
							<li class="article-grid-item article-grid-item-1">
								<a href="<?php the_permalink() ?>" class="article-grid-permalink">
									<img class="article-grid-thumb" src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
									<span class="category-name"><?php $category = get_the_category();
																							echo $category[0]->name; ?></span>
									<h4 class="article-grid-title">
										<?php echo mb_strimwidth(get_the_title(), 0, 60, '...'); ?>
									</h4>
									<p class="article-grid-excerpt">
										<?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '...'); ?>
									</p>
									<div class="article-grid-info">
										<div class="author">
											<?php $author_id = get_the_author_meta('ID'); ?>
											<img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author() ?>" class="author-avatar" />
											<span class="author-name"><strong><?php the_author() ?></strong> :
												<?php echo mb_strimwidth(get_the_author_meta('description'), 0, 26, '...'); ?>
											</span>
										</div>
										<div class="comments">
											<img src="<?php echo get_template_directory_uri() . '/assets/images/comment.svg' ?>" alt="Icon: comments" class="comments-icon" />
											<span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
										</div>
									</div>
								</a>
							</li>
							<!-- /.article-grid-item -->
						<?php
							break;
							// Выводим второй пост
						case '2': ?>
							<li class="article-grid-item article-grid-item-2">
								<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php the_title() ?>" class="article-grid-thumb">
								<a href="<?php the_permalink() ?>" class="article-grid-permalink">
									<span class="tag">
										<?php $posttags = get_the_tags();
										if ($posttags) {
											echo $posttags[0]->name . '';
										}
										?>
									</span>
									<span class="category-name"><?php $category = get_the_category();
																							echo $category[0]->name; ?></span>
									<h4 class="article-grid-title">
										<?php the_title() ?>
									</h4>
									<div class="article-grid-info">
										<div class="author">
											<?php $author_id = get_the_author_meta('ID'); ?>
											<img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author() ?>" class="author-avatar" />
											<div class="author-info">
												<span class="author-name"><strong><?php the_author() ?></strong></span>
												<span class="date"><?php the_time('j F') ?></span>
												<div class="comments">
													<img src="<?php echo get_template_directory_uri() . '/assets/images/comment-white.svg' ?>" alt="Icon: comments" class="comments-icon" />
													<span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
												</div>
												<div class="likes">
													<img src="<?php echo get_template_directory_uri() . '/assets/images/heart-white.svg' ?>" alt="icon: likes" class="likes-icon">
													<span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
												</div>
											</div>
											<!-- /.author-info -->
										</div>
									</div>
								</a>
							</li>
						<?php
							break;
							// Выводим третий пост
						case '3': ?>
							<li class="article-grid-item article-grid-item-3">
								<a href="<?php the_permalink() ?>" class="article-grid-permalink">
									<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php the_title() ?>" class="article-grid-thumb">
									<h4 class="article-grid-title">
										<?php echo the_title() ?>
									</h4>
								</a>
							</li>
						<?php
							break;
							// выводим остальные посты
						default: ?>
							<li class="article-grid-item article-grid-item-default">
								<a href="<?php the_permalink() ?>" class="article-grid-permalink">
									<h4 class="article-grid-title">
										<?php echo mb_strimwidth(get_the_title(), 0, 33, '...'); ?>
									</h4>
									<p class="article-grid-excerpt">
										<?php echo mb_strimwidth(get_the_excerpt(), 0, 76, '...') ?>
									</p>
									<span class="article-date"><?php the_time('j F') ?></span>
								</a>
							</li>
					<?php
							break;
					}
					?>
					<!-- Вывода постов, функции цикла: the_title() и т.д. -->
			<?php
				}
			} else {
				// Постов не найдено
			}
			wp_reset_postdata(); // Сбрасываем $post
			?>
		</ul>
		<!-- /.article-grid -->
		<!-- Подключаем сайдбар -->
		<?php get_sidebar() ?>
	</div>
	<!-- /.main-grid -->
</div>
<!-- /.container -->

<!-- Вывод постов в большой обложной -->
<?php
global $post;
$query = new WP_Query([
	'posts_per_page' => 1,
	'category_name'  => 'investigation',
]);
if ($query->have_posts()) {
	while ($query->have_posts()) {
		$query->the_post();
?>
		<section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.75), rgba(64, 48, 61, 0.75)),  url(<?php echo get_the_post_thumbnail_url() ?>) no-repeat center">
			<div class="container">
				<h2 class="investigation-title"><?php the_title() ?></h2>
				<a href="<?php echo get_the_permalink() ?>" class="more">Читать статью</a>
			</div>
		</section>
		<!-- /.investigation -->
<?php
	}
} else {
	// Постов не найдено
}
wp_reset_postdata(); // Сбрасываем $post
?>
<div class="container">
	<div class="article-container">
		<ul class="article-column">
			<?php
			global $post;

			$myposts = get_posts([
				'numberposts' => 6,
			]);

			if ($myposts) {
				foreach ($myposts as $post) {
					setup_postdata($post);
			?>
					<li class="article-column-item">
						<div class="article-column-border">
							<img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php the_title() ?>" class="article-column-thumb">
							<a href="<?php the_permalink() ?>" class="article-column-permalink">
								<div class="bookmark">
									<span class="tag">
										<?php $posttags = get_the_tags();
										if ($posttags) {
											echo $posttags[1]->name . '';
										}
										?>
									</span>
									<img src="<?php echo get_template_directory_uri() . '/assets/images/bookmark.svg' ?>" alt="icon: bookmark" class="bookmark-icon">
								</div>
								<!-- /.bookmark -->
								<h4 class="article-column-title"><?php echo mb_strimwidth(get_the_title(), 0, 65, '...'); ?></h4>
								<p class="article-column-excerpt">
									<?php echo mb_strimwidth(get_the_excerpt(), 0, 200, '...'); ?>
								</p>
								<div class="article-column-info">
									<span class="date"><?php the_time('j F') ?></span>
									<div class="comments">
										<img src="<?php echo get_template_directory_uri() . '/assets/images/comment.svg' ?>" alt="Icon: comments" class="comments-icon" />
										<span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
									</div>
									<div class="likes">
										<img src="<?php echo get_template_directory_uri() . '/assets/images/heart.svg' ?>" alt="icon: likes" class="likes-icon">
										<span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
									</div>
								</div>
								<!-- /.article-column-info -->
							</a>
						</div>
						<!-- /.article-column-border -->
					</li>
			<?php
				}
			} else {
				// Постов не найдено
			}

			wp_reset_postdata(); // Сбрасываем $post
			?>
		</ul>
		<!-- /.ul article-column -->
	</div>
	<!-- /.article-container -->
</div>
<!-- /.container -->