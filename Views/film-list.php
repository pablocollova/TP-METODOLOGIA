<br>
<div class="d-flex justify-content-between">
    <h2>PELICULAS DISPONIBLES</h2>
    <div class="col-md-2">
  
    <a href="<?php echo FRONT_ROOT ?>Films/refresh/" class="btn btn-outline-danger"><i class="fa fa-refresh"></i>&#160;&#160;&#160;Actualizar</a>
    </div>
</div>
<?php require_once(ROOT . '/Views/filter.php'); ?>
<br>
<div id="peliculas" class="row col-12">

 <?php
        foreach($films as $film){
    ?>

  <div class="card col-3">
<br>
<?php if (empty($film->getPoster())) { ?>
  <img class="card-img-top" src="<?php echo IMAGES ?>not-available.jpg" alt="Card image cap">

<?php }else{ ?>

<img class="card-img-top" src="<?php echo IMAGENES.$film->getPoster() ?>" alt="Card image cap">

<?php } ?>

  <div class="card-body">

    <h4 class="card-title"><?php echo $film->getTitulo() ?></h4>

    </div>
<span>
<div class="row col-12">

    <a href="<?php echo FRONT_ROOT ?>Funcion/ShowAddView/ <?php echo $film->getId() ?>" class="btn btn-danger col-9"><i class="fa fa-ticket"></i>&#160;&#160;Agregar Función</a>&#160;&#160;
    </div>
    <div class="row col-12" style="margin-top: 10px;">
	<a href="<?php echo FRONT_ROOT ?>Films/getInfoFuncion/<?php echo $film->getId() ?>" class="btn btn-secondary col-4"><i class="fa fa-plus"></i>&#160;&#160;Info</a>

</div>
</span>
<br>
</div>


<?php
        }
    ?>

 <br><br>
</div>