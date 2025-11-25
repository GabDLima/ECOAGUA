<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $this->getView()->title; ?></title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap-533.min.css">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/resources/dashboard/js/sweetalert_config.js"></script>
  <!-- Dark Mode CSS -->
  <link rel="stylesheet" href="/resources/dashboard/css/dark_mode.css">
  <!-- UX Improvements CSS -->
  <link rel="stylesheet" href="/resources/dashboard/css/ux_improvements.css">
  <!-- Dark Mode JS Global -->
  <script src="/resources/dashboard/js/dark_mode.js" defer></script>

  <?php if (isset($_SESSION['dark_mode']) && $_SESSION['dark_mode'] == 1): ?>
  <script>
    // Aplicar dark mode antes da página carregar para evitar flash
    document.documentElement.classList.add('dark-mode');
    document.addEventListener('DOMContentLoaded', function() {
      document.body.classList.add('dark-mode');
    });
  </script>
  <?php endif; ?>

</head>

</html>
