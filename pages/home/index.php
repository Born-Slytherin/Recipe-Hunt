<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="./style.css" />
  <link rel="stylesheet" href="../../global.css">
</head>

<?php
if (!isset($_COOKIE["user"])) {
  header("Location: /Recipe-Hunt/pages/login/index.php");
  exit;
}

require("../../components/modal.php");
?>

<body id="home">
  <div>
    <form method="POST">
      <button type="submit" name="action" value="share">Share Recipe</button>
      <button type="submit" name="action" value="generate">Generate Recipe</button>
    </form>
  </div>
  <div class="import-container">
    <?php
    $action = $_POST['action'] ?? 'generate';

    switch ($action) {
      case 'share':
        require("../../components/ShareRecipe.php");
        break;
      case 'generate':
      default:
        require("../../components/GenerateRecipe.php");
        break;
    }
    ?>
  </div>
  <script src="./recipeGeneration.js" type="module" defer></script>
  <script src="./recipeSharing.js" type="module" defer></script>
</body>

</html>