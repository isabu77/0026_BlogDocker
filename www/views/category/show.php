<?php
use App\Model\PostTable;
use App\Model\CategoryTable;
use App\Helpers\Text;

/**
 * fichier qui génère la vue pour l'url /category/[i:id]
 * 
 */
$id = (int)$params['id'];
$slug = $params['slug'];

// Connexion à la base
$categoryTable = new CategoryTable();

// lecture de la catégorie îd dans la base (objet Category)
$category = $categoryTable->getCategory($id);

if (!$category) {
    throw new \exception("Aucune catégorie ne correspond à cet Id");
}

// vérifier si on est sur le bon article avec le bon slug dans les paramètres de l'url demandée
if ($category->getSlug() !== $slug){
    $url = $router->url('category', ['id' => $id, 'slug' => $category->getSlug()]);
    // code 301 : redirection permanente pour le navigateur (de son cache, plus de requete au serveur)
    http_response_code(301);
    header('Location:' . $url);
    exit();
}


/** DEBUT ********************************************
* 
*$paginatedQuery = new App\PaginatedQuery(queryCount, class, url, perpage = 12);
*$post = $paginatedQuery->getContent();

****  spécifique à la page  *****
*querycount
*query
*class

****  commun  ****
*perpage


*/

// nb d'articles de la catégorie $id
$postTable = new PostTable();
$nbpost = $postTable->getNbPostOfCategory($category->getId());

$perPage = 12;
$nbPage = ceil($nbpost / $perPage);

if ((int)$_GET["page"] > $nbPage) {
    // page inexistante : page 1
    $uri = $router->url("category", ["id"=> $category->getId(), "slug"=>$category->getSlug()]);
    header('location: /category/'.$uri);
    exit();
}
if (isset($_GET["page"])) {
    $currentpage = (int)$_GET["page"];
} else {
    $currentpage = 1;
}
$offset = ($currentpage - 1) * $perPage;

// lecture des articles de la page dans la base
$posts = $postTable->getPostsOfCategory($category->getId(), $perPage, $offset);

/** FIN ******************************************** */

$title = "Catégorie : " . $category->getName();

?>

<p>Catégorie <big><?= $id ?></big></p>
<p>Slug : <big><?= $category->getSlug() ?></big></p>

<?php if (null !== $message) : ?>
    <div class="alert-message">
        <?= $message ?>
    </div>
<?php endif ?>
<section class="row">
    <?php 
    foreach ($posts as $post) {
        require dirname(__DIR__) . '/post/card.php';
    }
    ?>
</section>
<?php
/**
 * 2 approches :
 * $pagination->getNavHTML();  --> html
 * OU
 * $pagination->getNav();  --> [i=>url, 2=>url]
*/
?>
<nav class="Page navigation">
    <ul class="pagination justify-content-center">
    <?php    $uri = $router->url("category", ["id"=> $category->getId(), "slug"=>$category->getSlug()]);?>
        <?php for ($i = 1; $i <= $nbPage; $i++) : ?>
            <?php 
            $class = $currentpage == $i ? " active" : ""; 
            $url = $i == 1 ? $uri : $uri."?page=" . $i; ?>
            <li class="page-item<?= $class ?>"><a class="page-link" href="<?= $url ?>"><?= $i ?></a></li>
        <?php endfor ?>
    </ul>
</nav>
