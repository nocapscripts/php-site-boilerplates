<?php use App\App; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= App::h(App::env('APP_NAME', 'Starter')) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen">
  <main class="max-w-xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4"><?= App::h(App::env('APP_NAME', 'Starter')) ?></h1>
    <?php if ($f = App::flash()): ?>
      <p class="mb-4 rounded bg-emerald-600/20 border border-emerald-600 px-3 py-2"><?= App::h($f) ?></p>
    <?php endif; ?>
    <?= $content ?>
  </main>
</body>
</html>
