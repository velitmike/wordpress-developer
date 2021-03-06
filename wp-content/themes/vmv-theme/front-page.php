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
							<?php
							foreach (get_the_category() as $category) {
								printf(
									'<a href="%s" class="category-link %s">%s</a>',
									esc_url(get_category_link($category)),
									esc_html($category->slug),
									esc_html($category->name),
								);
							}
							?>
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
								<?php
								foreach (get_the_category() as $category) {
									printf(
										'<a href="%s" class="category-link %s">%s</a>',
										esc_url(get_category_link($category)),
										esc_html($category->slug),
										esc_html($category->name),
									);
								}
								?>
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
									<img class="article-grid-thumb" src="<?php if (has_post_thumbnail()) {
																													echo get_the_post_thumbnail_url(null, 'thumbnail');
																												} else {
																													echo get_template_directory_uri()  . '/assets/images/img-default.png';
																												} ?>" alt="<?php the_title() ?>">
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
											<svg width="19" height="15" class="icon comments-icon">
												<use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
											</svg>

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
								<img src="<?php if (has_post_thumbnail()) {
														echo get_the_post_thumbnail_url(null, 'thumbnail');
													} else {
														echo get_template_directory_uri()  . '/assets/images/img-default.png';
													} ?>" alt="<?php the_title() ?>" class="article-grid-thumb">
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
													<svg width="19" height="15" fill="#fff" class="icon comments-icon">
														<use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
													</svg>
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
									<img src="<?php if (has_post_thumbnail()) {
															echo get_the_post_thumbnail_url(null, 'thumbnail');
														} else {
															echo get_template_directory_uri()  . '/assets/images/img-default.png';
														} ?>" alt="<?php the_title() ?>" class="article-grid-thumb">
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
		<!-- Подключаем верхний сайдбар -->
		<?php get_sidebar('home-top') ?>
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
		<section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.75), rgba(64, 48, 61, 0.75)),  
		url(<?php if (has_post_thumbnail()) {
					echo get_the_post_thumbnail_url();
				} else {
					echo get_template_directory_uri()  . '/assets/images/img-default.png';
				} ?>) no-repeat center center">
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
	<div class="main-column">
		<div class="article-container">
			<ul class="article-column">
				<?php
				global $post;

				$myposts = get_posts([
					'numberposts' => 6,
					'tag' => 'горячее, мнение, новости, подборки',
				]);

				if ($myposts) {
					foreach ($myposts as $post) {
						setup_postdata($post);
				?>
						<li class="article-column-item">
							<div class="article-column-border">
								<img src="<?php if (has_post_thumbnail()) {
														echo get_the_post_thumbnail_url();
													} else {
														echo get_template_directory_uri()  . '/assets/images/img-default.png';
													} ?>" alt="<?php the_title() ?>" class="article-column-thumb">
								<a href="<?php the_permalink() ?>" class="article-column-permalink">
									<div class="bookmark">
										<span class="tag">
											<?php
											$all_the_tags = get_the_tags();
											if ($all_the_tags) {
												foreach (get_the_tags() as $posttags) {
													if ($posttags->name == 'горячее') {
														printf(
															'<span class="tag-%s">%s</span>',
															esc_html($posttags->name),
															esc_html($posttags->name),
														);
													} elseif ($posttags->name == 'подборки') {
														printf(
															'<span class="tag-%s">%s</span>',
															esc_html($posttags->name),
															esc_html($posttags->name),
														);
													} elseif ($posttags->name == 'новости') {
														printf(
															'<span class="tag-%s">%s</span>',
															esc_html($posttags->name),
															esc_html($posttags->name),
														);
													} elseif ($posttags->name == 'мнение') {
														printf(
															'<span class="tag-%s">%s</span>',
															esc_html($posttags->name),
															esc_html($posttags->name),
														);
													} else {
														// не найдена ни одна метка

													}
												}
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
											<svg width="19" height="15" class="icon comments-icon">
												<use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#comment"></use>
											</svg>
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
		<!-- Подключаем нижний сайдбар -->
		<?php get_sidebar('home-bottom') ?>
	</div>
	<!-- /.main-column -->
</div>
<!-- /.container -->
<div class="special">
	<div class="container">
		<div class="special-grid">
			<!-- Вывод special постов -->
			<?php
			global $post;
			$query = new WP_Query([
				'posts_per_page' => 1,
				'category_name'  => 'photo-report'
			]);
			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
			?>
					<div class="photo-report">
						<!-- Slider main container -->
						<div class="swiper-container photo-report-slider">
							<!-- Additional required wrapper -->
							<div class="swiper-wrapper">
								<!-- Slides -->
								<?php $images = get_attached_media('image');
								foreach ($images as $image) {
									echo '<div class="swiper-slide"><img src="';
									print_r($image->guid);
									echo '"></div>';
								}
								?>
							</div>
							<!-- If we need pagination -->
							<div class="swiper-pagination"></div>
						</div>
						<div class="photo-report-content">
							<?php
							foreach (get_the_category() as $category) {
								printf(
									'<a href="%s" class="category-link">%s</a>',
									esc_url(get_category_link($category)),
									esc_html($category->name),
								);
							}
							?>
							<?php $author_id = get_the_author_meta('ID'); ?>
							<a href="<?php echo get_author_posts_url($author_id) ?>" class="author">
								<img src="<?php echo get_avatar_url($author_id) ?>" alt="<?php the_author() ?>" class="author-avatar" />
								<div class="author-bio">
									<span class="author-name"><?php the_author(); ?></span>
									<span class="author-rank">Фотограф</span>
								</div>
							</a>
							<h3 class="photo-report-title"><?php the_title() ?></h3>
							<a href="<?php echo get_the_permalink() ?>" class="button photo-report-button">
								<svg width="19" height="15" class="icon photo-report-icon">
									<use xlink:href="<?php echo get_template_directory_uri() ?>/assets/images/sprite.svg#images"></use>
								</svg>
								<!-- <img src="" alt=""> -->
								Смотреть фото
								<span class="photo-report-counter"><?php echo count($images) ?></span>
							</a>
						</div>
					</div>
					<!-- /.photo-report -->
			<?php
				}
			} else {
				// Постов не найдено
			}
			wp_reset_postdata(); // Сбрасываем $post
			?>
			<div class="other">
				<div class="career">
					<img src="" alt="<?php the_title() ?>" class="career-photo">
				</div>
				<!-- /.career -->
			</div>
			<!-- /.other -->
		</div>
		<!-- /.special-grid -->
	</div>
	<!-- /.container -->
</div>
<!-- /.special -->
<?php wp_footer(); ?>