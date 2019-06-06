<article class="col-md-3 col-12 mb-4 d-flex align-items-stretch">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Article <?= $post->getId() . " - ". $post->getName() ?></h5>
                    <p class="card-text"><?= $post->getExcerpt(100) ?></p>
                </div>
                <a href="<?= $router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()]) ?>" class="text-center pb-2">lire plus</a>
                <div class="card-footer text-muted">
                    <?= ($post->getCreatedAtDMY())   ?>
                </div>
            </div>
        </article>
