<?php

namespace LostSpace;

require_once(__DIR__."/../src/Directory.php");
require_once(__DIR__."/../src/ViewHelper.php");
require_once(__DIR__."/../src/FlashBag.php");

$toBrowse = isset($_GET['dir']) ? realpath($_GET['dir']) : __DIR__;
$dir = new Directory($toBrowse);
$flashBag = new FlashBag();
?>
<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LostSpace</title>

    <meta name="description" content="LostSpace" />
    <meta name="author" content="Manuel Kea Baldassarri" />

    <link rel="stylesheet" href="//cdn.foundation5.zurb.com/foundation.css" />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
    <link rel="stylesheet" href="main.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js"></script>
  </head>
  <body>

<!-- Header and Nav -->
  <div class="row panel">
    <div class="large-4 columns">
      <h1>LostSpace</h1>
    </div>
    <div class="large-4 columns">
      <ul class="no-bullet">
        <li><i class="fa fa-user"></i> <?php echo $user = $dir->getCurrentUser() ?></li>
        <li><i class="fa fa-trash-o"></i> <?php echo $trash = $dir->getTrashPath() ?></li>
      </ul>
    </div>
  </div>
  <div class="row">
    <ul class="breadcrumbs large-12">
      <li><a href="?dir=/">Root</a></li>
      <?php
        $parts = explode('/', trim($dir->getPath(), '/'));
        $lastPart = count($parts) - 1;
        $currentPath = '';
      ?>
      <?php foreach ($parts as $i => $part) : ?>
        <li <?php echo ($lastPart == $i) ? 'class="current"' : '' ?>>
          <a href="?dir=<?php echo $currentPath.= '/'.$part ?>"><?php echo $part ?></a>
        </li>
      <?php endforeach ?>
      <!--  -->
    </ul>
  </div>
  <?php if ($flashBag->has('success')) : ?>
    <div class="row alert-box success">
      <?php foreach ($flashBag['success'] as $flash) : ?>
        <div><?php echo $flash; ?></div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
  <?php if ($flashBag->has('error')) : ?>
    <div class="row alert-box alert">
      <?php foreach ($flashBag['error'] as $flash) : ?>
        <div><?php echo $flash; ?></div>
      <?php endforeach ?>
    </div>
  <?php endif ?>
  <!-- End Header and Nav -->

  <div class="row">
    <!-- Main Content Section -->
    <div class="large-12">

      <table class="large-12">
        <?php foreach ($dir->getList() as $entry) : ?>
          <tr class="<?php echo $entry['filetype'] ?>">
            <td class="name large-5">
              <i class="<?php echo ViewHelper::classForType($entry['filetype']) ?>" title="<?php echo $entry['filetype'] ?>"></i>
              <?php if ($entry['filetype'] == 'dir') : ?>
                <a href="?dir=<?php echo $dir->getPath().'/'.$entry['filename'] ?>"><?php echo $entry['filename'] ?></a>
              <?php else : ?>
                <?php echo $entry['filename'] ?>
              <?php endif ?>
            </td>
            <td class="size large-6">
              <div class="large-2 columns" style="padding-left:0"><?php echo ViewHelper::humanSize($entry['size']) ?></div>
              <div class="progress large-10 columns"><span class="meter" style="width: <?php echo round($entry['size'] / ($dir->getTotalSize() / 100), 2) ?>%"></span></div>
            </td>
            <td class="actions large-1">
              <a class="to-trash-trigger" href="#trash" data-reveal-id="to-trash" data-remove-file="<?php echo $dir->getPath().'/'.$entry['filename'] ?>"><i class="fa fa-trash-o"></i></a>
            </td>
          </tr>
        <?php endforeach ?>
      </table>
    </div>
  </div>

  <div id="to-trash" class="reveal-modal" data-reveal>
    <h2>Move to trash file/directory</h2>
    <p class="lead">THEFILE</p>
    <button class="primary">Confirm</button> <button class="secondary">Cancel</button>
    <a class="close-reveal-modal">&#215;</a>
  </div>

  <!-- Footer -->

  <footer class="row">
    <div class="large-12 columns">
      <hr />
      <div class="row">
        <div class="large-6 columns">
          <p><a href="//github.com/kea/lost-space">LostSpace on github</a></p>
        </div>
      </div>
    </div>
  </footer>
    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="http://cdn.foundation5.zurb.com/foundation.js"></script>
    <script>
      $(document).foundation();

      $(function(){
        $('.to-trash-trigger').on('click', function(e) {
          $('#to-trash').attr('data-remove-file', $(this).attr('data-remove-file'));
          $('#to-trash .lead').html($(this).attr('data-remove-file'));
        });
        $('#to-trash .secondary').on('click', function(e) {
          $('#to-trash').foundation('reveal', 'close');
        });
        $('#to-trash .primary').on('click', function(e) {
          $(this).removeClass('primary').addClass('secondary').html('<i class="fa fa-spinner fa-spin""></i> Moving to trash...')
          window.location.href = 'toTrash.php?file=' + encodeURIComponent($('#to-trash').attr('data-remove-file'));
        });
      });

    </script>
  </body>
</html>