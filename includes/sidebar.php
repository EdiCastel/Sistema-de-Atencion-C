<!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark shadow accordion d-print-none" id="accordionSidebar">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-home"></i>
        <span>Inicio</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<div class="sidebar-heading">
    Solicitudes
</div>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=Solicitud-individual">
        <i class="fas fa-fw fa-plus"></i>
        <span>Solicitud individual</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=Solicitud-colectiva">
        <i class="fas fa-fw fa-users"></i>
        <span>Solicitud colectiva</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=Lista-de-solicitudes">
        <i class="fas fa-fw fa-folder-open"></i>
        <span>Lista de solicitudes</span></a>
</li>

<?php
//Verifica que el usuario sea administrador y en caso contrario, no se mostrara el acceso a la lista de usuarios para evitar que 
//accedan a la pagina usuarios no autorizados ya que a estas paginas solo tendra acceso el administrador.
if ($_SESSION['tipo_usuario'] == 'Administrador') {
?>   
    <!-- Divider -->
    <hr class="sidebar-divider">
    
    <!-- Heading -->
    <div class="sidebar-heading">
    usuarios
    </div>
    
    <li class="nav-item">
    <a class="nav-link" href="index.php?page=Lista-de-usuarios">
    <i class="fas fa-fw fa-list"></i>
    <span>Lista de usuarios</span></a>
    </li>
<?php
}    
?>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Ciudadanos
</div>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=Lista-de-ciudadanos">
        <i class="fas fa-fw fa-list"></i>
        <span>Lista de ciudadanos</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Comités
</div>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=Lista-de-comités">
        <i class="fas fa-fw fa-list"></i>
        <span>Lista de comités</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Apoyos
</div>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=Lista-de-apoyos">
        <i class="fas fa-fw fa-list"></i>
        <span>Lista de apoyos</span></a>
</li>


<?php
//Verifica que el usuario sea administrador y en caso contrario, no se mostrara el acceso a los reportes para evitar que 
//accedan a la pagina usuarios no autorizados ya que a estas paginas solo tendra acceso el administrador.
if ($_SESSION['tipo_usuario'] == 'Administrador') {
?>  
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Reportes
</div>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=reporte-1">
        <i class="fas fa-area-chart"></i>
        <span>Módulo de reportes</span></a>
</li>


<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-area-chart"></i>
        <span>Módulo de reporte</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item bg-primary" href="index.php?page=reporte-1"><i class="fas fa-file-text" aria-hidden="true"></i> <span>Reporte 1</span></a>
        </div>
    </div>
</li> -->

<?php
}    
?>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->