<?php

/**
 * Template Name: Codecrewz Page
 *
 * The template for displaying all pages
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package codecrewz_DCS
 */
global $wpdb;
$table_name = $wpdb->prefix . 'codecrewz_project';
$data = $wpdb->get_results("SELECT * FROM $table_name WHERE TRIM(name) != ''");

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Code Crewz Projects</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    .card-item {
      margin-top: 40px;
    }

    .card {
      position: relative;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      padding: 10px;
    }

    .white {
      color: #fff;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .img-top {
      margin-top: -40px;
    }

    .card-img-top {
      width: 100%;
      border-radius: 50%;
      max-width: 60px;
      aspect-ratio: 1/1;
      object-fit: contain;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      width: 100%;
      flex-grow: 1;
      padding: 2px 16px;
      align-items: center;

    }

    .card-title {
      font-size: 1.5em;
      text-align: center;
    }

    .card-text {
      font-size: 1em;
      color: #666;
      overflow: hidden;
      text-overflow: ellipsis;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
    }

    .card:hover .card-text {
      overflow: auto;
      display: block;
      text-overflow: none;
    }

    .btn {
      border-radius: 0;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      padding: 20px 20px;
    }

    .card-info {
      flex-grow: 1;
      font-size: 0.9em;
      color: #666;
      padding-top: 10px;
    }

    .card-img-back {

      position: absolute;
      object-fit: cover;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .card-content {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      z-index: 2;
    }
  </style>
</head>

<body>
  <div class="card mb-10">
    <img src="https://ik.imagekit.io/grknoi8mz/<?= home_url() ?>/images/about/about_3.png" alt="Code Crewz Technology Background" class="card-img-back">
    <div class="card-content">
      <img src="https://codecrewz.com.au/wp-content/themes/codecrewz_site/static/media/icon.13809b21be52f6d8b9f8.png" alt="Code Crewz Technology logo" class="card-img-top">
      <div class="card-body white">
        <h5 class="card-title">Code Crewz Technology</h5>
        <a href="https://codecrewz.com.au" class="btn btn-primary">Visit Website</a>
      </div>
    </div>
  </div>
  <div class="card">
    <h1 class="card-title">Code Crewz Projects</h1>
  </div>
  <div class="grid">
    <?php
    foreach ($data as $item) { ?>
      <div class="card card-item">
        <div class="card-content">
          <img src="<?= empty($item->logo) ? "https://avatars.dicebear.com/api/initials/$item->name.svg" : $item->logo ?>" alt="Company 1 logo" class="card-img-top img-top">
          <div class="card-body">
            <h2 class="card-title"><?= $item->name ?></h2>
            <?php if ($item->description) { ?>
              <p class="card-text"><?= $item->description ?></p>
            <?php } ?>
            <div class="card-info">
              <?php if ($item->phone) { ?>
                <a href="tel:<?= $item->phone ?>">Phone: <?= $item->phone ?></a>
              <?php } ?>
              <?php if ($item->email) { ?>
                <a href="mailto:<?= $item->email ?>">Email: <?= $item->email ?></a>
              <?php } ?>
              <?php if ($item->address) { ?>
                <a href="#">Address: <?= $item->address ?></a>
              <?php } ?>
              <?php if ($item->abn) { ?>
                <a href="#">Abn: <?= $item->abn ?></a>
              <?php } ?>
            </div>
            <a href="<?= $item->link ?>" target='_blank' class="btn btn-primary">Visit Website</a>
          </div>
        </div>
      </div>
    <?php
    }
    ?>
  </div>

</body>

</html>