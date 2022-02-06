<?php include('template/cabecera.php') ?>
<link rel="stylesheet" href="css/style.css">

<section>
          <div class="container">
          <div class="card text-center">
  <div class="card-header">
    <h1>Contacto</h1>
  </div>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
  <div class="card-footer text-muted">
    2 days ago
  </div>
</div>
          </div>
     </section>


     <!-- CONTACT -->
     <section id="contact">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-12">
                         <form id="contact-form" role="form" action="" method="post">
                              <div class="col-md-12 col-sm-12">
                                   <input type="text" class="form-control" placeholder="Nombre Completo" name="name" required>
                    
                                   <input type="email" class="form-control" placeholder="Correo" name="email" required>

                                   <textarea class="form-control" rows="6" placeholder="Tell us about your message" name="message" required></textarea>
                              </div>

                              <div class="col-md-4 col-sm-12">
                                   <input type="submit" class="form-control" name="send message" value="Enviar">
                              </div>

                         </form>
                    </div>

                    <div class="col-md-6 col-sm-12">
                         <div class="contact-image">
                              <img src="img/contacto2.jfif" width="500" alt="">
                         </div>
                    </div>

               </div>
          </div>
     </section>             




<?php include('template/pie.php')?>