<article class="col-md-3 col-12 mb-4 d-flex align-items-stretch">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Article <?= $post->getId() . " - " . $post->getName() ?></h5>
            <p class="card-text"><?= $post->getExcerpt(100) ?></p>
            <a class="card-link" href="<?= $router->url('post', ['id' => $post->getId(), 'slug' => $post->getSlug()])?>">lire plus</a>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($post->getCategories() as $key => $category) :
                    $category_url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
                    ?>
                    <li class="list-group-item bg-light"><a class="card-link" href="<?= $category_url ?>"><?= $category->getName() ?></a></li>
                <?php endforeach ?>
            </ul>
        <div class="card-footer text-muted">
            <?= ($post->getCreatedAtDMY())   ?>
        </div>
    </div>
</article>