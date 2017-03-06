<?php if (!isset($parent)) $parent = page('shop') ?>

<?php $categories = $parent->children()->visible()->filterBy('template','category') ?>

<?php if ($categories->count()) { ?>

  <?php if ($parent->is('shop')) { ?>
    <h3 dir="auto"><?= l::get('shop-by-category') ?></h3>
  <?php } else { ?>
    <button class="small" aria-expanded="true" aria-controls="<?= $parent->hash() ?>">
      <span class="expand"><?= f::read('site/plugins/shopkit/assets/svg/caret-down.svg') ?></span>
      <span class="collapse"><?= f::read('site/plugins/shopkit/assets/svg/caret-up.svg') ?></span>
    </button>
  <?php } ?>

  <ul dir="auto" class="menu categories" id="<?= $parent->hash() ?>">
    
    <?php if ($user = $site->user() and $user->can('panel.access.options')) { ?>
      <li>
        <a class="button admin" href="<?= url('panel/pages/'.$parent->uri().'/add?template=category') ?>">
          + New category
        </a>
      </li>
    <?php } ?>
    
    <?php foreach($categories as $category) { ?>
      <li>
        <a <?php ecco($category->isActive(), 'class="active"') ?> href="<?= $category->url() ?>">
          <?= $category->title() ?>
        </a>
        <?php snippet('menu.categories', ['parent' => $category]) ?>
      </li>
    <?php } ?>
    
  </ul>
<?php } ?>

<?php
  // This snippet is recursive, so make sure we don't include the script file more than once! -->
  if ($parent->is('shop')) {
    echo js('assets/plugins/shopkit/js/expand-collapse.js');
  }
?>