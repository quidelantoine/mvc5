<h1>Framework Pédagogique MVC5</h1>

<h2>Installation</h2>
<h3>Prérequis</h3>
<ul>
	<li>PHP >= 7.1.*</li>
	<li>Composer</li>
	<li>MySQL avec PDO</li>
</ul>

<h3>Configurations</h3>

<p>Par sa simplicité, MVC5 requière peu de configuration pour fonctionner.</p>

<h3>Le fichier de configuration</h3>

<p>MVC5 est livré avec un fichier nommé config/config-dist.php. Ce fichier est destiné à être versionné, et ne doit pas contenir d'informations personnelles ou sensibles. Le fichier lu par défaut par le framework est <span class="code">config/config.php</span>, qui lui, ne doit pas être versionné, il vous est personnel.</p>

<p>Pour démarrer copier-coller le contenu du fichier config/config-dist.php dans 

<pre><code>/* config/config.php */

return array(
    'db_name'   => 'dbname',
    'db_user'   => 'root',
    'db_pass'   => '',
    'db_host'   => 'localhost',

    'directory' => '/chemin/to/view/'
);
</code></pre>
<h3>Controlleur Frontal</h3> => /public/index.php
Pour afficher le site aller via localhost dans le dossier public de votre application
<h2>Routes</h2> => /config/routes.php

<h4>À quoi servent les routes ?</h4>
<p>Les routes permettent d'associer simplement des URL virtuelles à des pages spécifiques de votre site.
 Plus précisémment, elles vous permettent d'exécuter une méthode de contrôleur que vous avez choisie

<h4>Comment créer une nouvelle route ?</h4>
<p>Toutes les routes doivent être définie dans le fichier /config/routes.php dans le tableau $routes

<pre><code>array('single2','default','single2',array('id','slug')), </code></pre>

<pre><code>array('nom de la page','Nom du controller','nom de la methode',tableau d'arguments)), </code></pre>

<h2>Controller</h2> => /app/Controller

<h4>À quoi servent les contrôleurs ?</h4>
<p>Les contrôleurs sont au coeur de vos applications. 
Ce sont eux qui traitent les requêtes et les formulaires, font appel au "modèle" pour manipuler les données, 
exécutent la logique applicative, et finalement, retournent des réponses (habituellement une vue, 
des données brutes ou une redirection) au client.</p>

<h4>Comment créer un contrôleur ?</h4>
<p>Vous pouvez créer autant de contrôleurs que vous le souhaitez. 
Pour vous donner une idée, il est fréquent d'avoir autant de contrôleurs que vous avez de table 
dans votre base de données (bien que ce ne soit nullement une règle à appliquer strictement). 
Ainsi, pour un blog, il y aurait probablement, a minima, un <span class="code">PostController</span>, 
un <span class="code">CommentController</span> et un <span class="code">UserController</span>.</p>

<p>Toutes vos classes devraient être sous l'espace de nom <span class="code">App\Controller</span> 
et hériter (directement ou non) de la classe <span class="code">App\Weblitzer\Controller</span>,
 afin de bénéficier des méthodes fournies.</p>

<h4>La classe App\Weblitzer\Controller</h4>
<p>Il est essentiel de parcourir vous-même la classe <span class="code">App\Weblitzer\Controller</span>,
 afin d'avoir un portrait juste de tout ce qu'elle vous offre.</p>
<p>En quelques mots, sachez qu'elle vous permet de gérer les redirections et les urls, l'envoi de réponses de vue, 
de pages d'erreurs et de JSON.</p>

<h3>Créer une action</h3>
<p>Pour chacune des "pages" de vos applications, une méthode de contrôleur devrait être définie.
 C'est notamment pour cette raison que vous ressentirez le besoin de créer plusieurs contrôleurs, 
 afin de "classer" vos méthodes, qui deviendront rapidement nombreuses.</p>
<p>Ces méthodes doivent être de visibilité <span class="code">public</span>, 
et devrait normalement se terminer par l'une des actions suivantes : 
 </p>
<pre><code>
/* app/Controller/DefaultController.php */
public function index()
{
	//autre logique ici, puis...
	/** 
	 * Méthodes habituellement utilisées en fin de traitement du contrôleur 
	 */
	 
	//affiche un template
	$this->render('app.default.contact');

	//affiche un template, tout en rendant des données disponibles dans celui-ci
	//template disponible dans le dossier view/app/default/contact.php
	$this->render('app.default.contact',['username' => 'michel']);

    //redirige vers une page du site
    $this->redirect('index.php?page=contact');

	//redirige vers un site externe
	$this->redirect('https://weblitzer.com');

	//retourne une réponse JSON
	//... $data = [];
	$this->showJson($data);

	//retourne une erreur 404
	$this->Abort404();
}
</code></pre>
<h2>Model</h2> => /app/Model

<h3>À quoi servent les modèles ?</h3>
<p>Les modèles (ou <span class="code">Model</span>) sont les classes responsables d'exécuter <em>les requêtes à votre base de données</em>.</p>
<p>Concrètement, chaque fois que vous souhaitez faire une requête à la base de données, vous devriez venir y créer une fonction qui s'en chargera (sauf si elle existe déjà dans les modèles de base du framework).</p>

<h3>Comment créer un nouveau modèle ?</h3> 
<p>Dans votre application, vous pourriez avoir un modèle par table MySQL (sans obligation). Chacune de ces classes devraient hériter de App\Weblitzer\Model\</span>, le modèle de base du framework, qui vous fera profiter de quelques méthodes utiles pour les requêtes simples à la base de données.</p>

<p>Par exemple, pour créer un modèle relié à une table fictive de commentaires nommées <span class="code">comment</span> : </p>
<pre><code>&lt;?php /* app/Model/CommentModel.php */
namespace App\Model;
class CommentModel extends \App\Weblitzer\Model 
{
    protected static $table = 'comments';
    protected $comment;
    protected $created_at;
    protected $status;
	//Récupère les commentaires associés à un article
	public function findPostComments($postId)
	{
		//...
	}
}
</code></pre>

<h3>Les propriétés et méthodes héritées du Model</h3>
<p>Voici les propriétés et les méthodes les plus utiles, héritées du modèle de base. Vous devrez créer vos propres méthodes pour réaliser toutes les requêtes SQL plus complexes !</p>
<pre><code>
/* App/Weblitzer/Model.php */
// Récupère une ligne de la table en fonction d'un identifiant
public function all()
public function findById($id)
public function findByColumn($column,$value)
public function count()
public function delete($id)
</code></pre>

<h2>View</h2> => /view

<h3>À quoi servent les vues ?</h3>
<p>Les <em>vues</em> ou <em>templates</em> permettent de séparer le code de présentation du reste de la logique (contrôleur) ou des données (modèles). On y retrouve donc essentiellement des balises HTML et des <span class="code">echo</span> de variables PHP.</p>

<h3>Comment créer un nouveau fichier de vue ?</h3>
<h4>Où placer ses fichiers de vues ?</h4>
<p>Donnée importante à connaître : Le framework vous impose de placer vos fichiers de vues sous le dossier <span class="code">view/app/</span>. Outre cette règle, vous êtes libre de faire comme bon vous semble.</p>
<p>Ceci étant, la plupart des pages de votre application devrait avoir un fichier de vue propre. Ainsi, il devrait y avoir à peu près autant de routes que de méthodes de contrôleur que de fichiers de vue dans votre application. Il est donc important de les classer un minimum, afin de s'y retrouver. Pour cette raison, je vous suggère de placer vos fichiers de vue dans des répertoires portant le même nom que son contrôleur (sans le suffixe Controller, et en minuscule). Ainsi, si vous avez un <span class="code">PostController</span> et un <span class="code">UserController</span> dans votre application, vous devriez avoir un dossier de vues nommé <span class="code">view/app/post/</span> et un autre nommé <span class="code">view/app/user/</span>. Ce n'est toutefois qu'une convention suggérée.</p>
<p>Les fichiers de vue doivent avoir l'extension <span class="code">.php</span>.</p>
<h4>Que contient un fichier de vue ?</h4>
<p>Au plus simple, un fichier de vue ne doit contenir qu'une page HTML complète. Lorsque votre contrôleur déclenchera l'affichage de votre fichier de vue, il enverra le contenu de celui-ci en réponse au client.</p>

<h4>Les CSS, les JS et les images</h4>
<p>Tous les fichiers publics de votre application (<em>public</em> dans le sens que vous considérez qu'un internaute doit pouvoir l'afficher directement dans son navigateur) doivent se trouver dans le dossier <span class="code">public/</span>. Autrement, le navigateur n'y aura tout simplement pas accès. Ainsi, vos fichiers .css, .js et vos images (souvent nommés <em>assets</em>) devront nécessairement y être placés.</p>

<h1>BRIEF - EXO</h1>

Création d'une application pour gèrer les emprunts de produits par des abonnés d'une association.

<h4>3 entités :</h4>
    <p>- **Abonnes** (id, nom, prenom, email, age (null), created_at)</p>
    <p>- **Products** (id, titre, reference, description(textarea) ) </p>
    <p>- **Borrows** (id, id_abonne, id_product, date_start, date_end(null)) </p>

<h4>Listing, Show, New, Edit, Delete. (CRUD)</h4>
Faire un crud complet pour les abonnés et aussi les Produits.

<h4>Les emprunts</h4>
Faire une seule page qui va afficher tous les emprunts
ainsi que le formulaire d'ajout qui contiendra deux select, un pour choisir parmi les abonnées et un autre pour sélectionnez le produit
On pourra enlever un emprunt de la liste en donnant une date à date_end
<h4>Page Statistiques</h4>
<p>Afficher le nombre d'abonnés.</p>
<p>Afficher le nombre de produits.</p>
<p>Afficher le nombre d’emprunts total.</p>
<p>Afficher le nombre d’emprunts en cours.(date_end IS NULL)</p>

------------------------------------------------------

<h4>Bonus</h4>

- Gestion des catégories de produits.
- Pagination numérotée des listings des abonnés et des produits.
- Gestion d'un formulaire au choix à l'aide d'Ajax.
