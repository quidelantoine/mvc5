<h2>Liste des abonnées</h2>
<p>Nombre d'abonnées : <?=$count; ?></p>

<section class="abonne">
    <?php foreach ($abonnes as $abonne) { ?>
        <div>
            <p><?= $abonne->nom; ?></p>
            <p><?= $abonne->prenom; ?></p>
            <p><?= $abonne->age; ?></p>
            <p><?= $abonne->email; ?></p>
            <p><?= $abonne->created_at; ?></p>
        </div>
    <?php } ?>
</section>
