<?php use App\App; ?>
<form method="post" action="/add" class="flex gap-2 mb-6">
  <input type="hidden" name="csrf" value="<?= App::csrf() ?>">
  <input name="text" maxlength="255" required placeholder="Write a note…"
         class="flex-1 rounded bg-slate-800 border border-slate-700 px-3 py-2">
  <button class="rounded bg-indigo-600 hover:bg-indigo-500 px-4 py-2">Add</button>
</form>

<ul class="space-y-2">
<?php foreach ($notes as $n): ?>
  <li class="flex items-center justify-between rounded bg-slate-800 px-3 py-2">
    <span><?= App::h($n['text']) ?> <small class="text-slate-400"><?= App::h($n['created']) ?></small></span>
    <form method="post" action="/delete">
      <input type="hidden" name="csrf" value="<?= App::csrf() ?>">
      <input type="hidden" name="id" value="<?= App::h((string) $n['id']) ?>">
      <button class="text-red-400 hover:text-red-300">Delete</button>
    </form>
  </li>
<?php endforeach; ?>
<?php if (!$notes): ?><li class="text-slate-400">No notes yet.</li><?php endif; ?>
</ul>
