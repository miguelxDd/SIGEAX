    <?php if(isset($_GET['url']) && $_GET['url'] != 'login'){
        ?><footer>
            <p class="pie-izquierdo">&copy; Sistema Adara Xpress - SIAX 2023</p>
            <label class="pie-derecho">
                v1.0
            </label>
        </footer><?php
    }
    ?>  
    
    <!-- JQuery v3.6 -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <!-- Bootstrap v5.3.0 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>    
    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- DATATABLES -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.js"></script>
    <!-- CHART.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="Vistas/js/global.js"></script>
    <script src="Vistas/js/componentes.js"></script>
    <script>
        //Para insertar los iconos Father
        feather.replace();
        //Quitamos animacion de carga cuando se carga todo el documento
        document.addEventListener("DOMContentLoaded", function(event) {
            const carag = document.getElementById('paginaCarga'); carag.classList.remove('loader'); carag.innerHTML = '';
        });
    </script>
</body>
</html>