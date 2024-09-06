<!DOCTYPE html>
<html>
  <head>
    <title>Error 404 - Página no encontrada</title>
    <style>
      /* Estilos CSS para la página */
      body {
        background-color: #f9f9f9;
        font-family: sans-serif;
        text-align: center;
        margin: 0;
        padding: 0;
      }
      
      .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
      
      h1 {
        font-size: 8rem;
        font-weight: bold;
        color: #f00;
        margin: 0;
        padding: 0;
      }
      
      p {
        font-size: 1.5rem;
        color: #666;
        margin: 1rem;
        padding: 0;
      }
      
      /* Estilos CSS para la animación */
      #svg-container {
        width: 300px;
        height: 300px;
        margin: 2rem;
      }
      
      #svg-container svg {
        width: 100%;
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <?php
        // Configuración de la página
        $page_title = "Error 404 - Página no encontrada";
        $page_description = "Lo siento, la página que estás buscando no se encuentra disponible.";

        // Configuración del encabezado HTTP
        header("HTTP/1.0 404 Not Found");
      ?>
      <h1>404</h1>
      <p><?php echo $page_description; ?></p>
      <div id="svg-container"></div>
    </div>

    <script>
      // Animación de SVG
      const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
      const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
      const animate = document.createElementNS("http://www.w3.org/2000/svg", "animate");

      svg.setAttribute("viewBox", "0 0 100 100");
      svg.setAttribute("xmlns", "http://www.w3.org/2000/svg");
      svg.setAttribute("stroke", "#f00");
      svg.setAttribute("stroke-width", "4");

      path.setAttribute("d", "M 10 10 L 90 90 M 10 90 L 90 10");

      animate.setAttribute("attributeName", "stroke-dashoffset");
     animate.setAttribute("from", "200");
      animate.setAttribute("to", "0");
      animate.setAttribute("dur", "2s");
      animate.setAttribute("repeatCount", "indefinite");

      path.appendChild(animate);
      svg.appendChild(path);
      document.getElementById("svg-container").appendChild(svg);
    </script>
  </body>
</html>