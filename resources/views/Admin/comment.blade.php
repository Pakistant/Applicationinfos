@extends('Admin.app')
@section('title', 'Modération des commentaires')

@section('dashboard-header')
  <div class="row align-items-center">
    <div class="col-sm-8"><p class="text-muted mb-1">Échanges avec les lecteurs</p><h3 class="page-title mt-0">Modération des commentaires</h3></div>
    <div class="col-sm-4 text-sm-right"><span class="badge badge-pill badge-light px-3 py-2"><i class="fas fa-shield-alt mr-1"></i>{{ $comments->count() }} commentaire(s)</span></div>
  </div>
@endsection

@section('dashboard-content')
  @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>@endif
  <div class="comment-admin-card">
    <div class="comment-admin-toolbar"><div><h4>Commentaires reçus</h4><p>Gérez la visibilité des réactions publiées sur vos articles.</p></div><span class="comment-count"><i class="fas fa-comments mr-1"></i>{{ $comments->where('isActive', 1)->count() }} visible(s)</span></div>
    @if($comments->isNotEmpty())
      <div class="comment-admin-list">
        @foreach($comments as $comment)
          <article class="admin-comment-row">
            <div class="admin-comment-avatar">{{ strtoupper(substr($comment->name, 0, 1)) }}</div>
            <div class="admin-comment-main"><div class="admin-comment-top"><div><strong>{{ $comment->name }}</strong><span class="admin-comment-email">{{ $comment->email }}</span></div><span class="comment-status {{ $comment->isActive ? 'is-visible' : 'is-hidden' }}"><i class="fas {{ $comment->isActive ? 'fa-eye' : 'fa-eye-slash' }} mr-1"></i>{{ $comment->isActive ? 'Visible' : 'Masqué' }}</span></div><p class="admin-comment-message">{{ $comment->message }}</p><div class="admin-comment-footer"><a href="{{ $comment->article ? route('article.details', $comment->article->slug) : '#' }}" target="_blank" rel="noopener noreferrer"><i class="fas fa-newspaper mr-1"></i>{{ Str::limit(optional($comment->article)->title ?? 'Article supprimé', 65) }}</a><time>{{ $comment->created_at->isoFormat('D MMM YYYY à HH:mm') }}</time><div class="admin-comment-actions"><form action="{{ $comment->isActive ? route('comment.update', $comment) : route('comment.unlock', $comment->id) }}" method="POST">@csrf @method('PUT')<button type="submit" class="btn btn-sm {{ $comment->isActive ? 'btn-outline-warning' : 'btn-outline-success' }}"><i class="fas {{ $comment->isActive ? 'fa-eye-slash' : 'fa-eye' }} mr-1"></i>{{ $comment->isActive ? 'Masquer' : 'Afficher' }}</button></form><form action="{{ route('comment.destroy', $comment) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt mr-1"></i>Supprimer</button></form></div></div></div>
          </article>
+        @endforeach
+      </div>
+    @else
+      <div class="comment-admin-empty"><i class="far fa-comment-dots"></i><h5>Aucun commentaire</h5><p>Les réactions de vos lecteurs apparaîtront ici.</p></div>
+    @endif
+  </div>
+
+  <style>
+    .comment-admin-card{background:#fff;border:1px solid #e7eaf1;border-radius:16px;box-shadow:0 8px 24px rgba(16,24,40,.04);overflow:hidden}.comment-admin-toolbar{display:flex;justify-content:space-between;align-items:center;padding:24px;border-bottom:1px solid #e7eaf1}.comment-admin-toolbar h4{margin:0;font-size:1.1rem}.comment-admin-toolbar p{margin:5px 0 0;color:#667085;font-size:.84rem}.comment-count{color:#4f46e5;font-size:.78rem;font-weight:700;background:#f1f0ff;border-radius:99px;padding:8px 12px}.admin-comment-row{display:flex;gap:16px;padding:22px 24px;border-bottom:1px solid #edf0f4}.admin-comment-row:last-child{border-bottom:0}.admin-comment-avatar{width:42px;height:42px;flex:0 0 auto;display:grid;place-items:center;border-radius:50%;background:#101827;color:#fff;font-weight:800}.admin-comment-main{min-width:0;flex:1}.admin-comment-top{display:flex;justify-content:space-between;gap:12px}.admin-comment-email{color:#98a2b3;font-size:.76rem;margin-left:10px}.admin-comment-message{color:#475467;margin:10px 0;font-size:.9rem}.comment-status{font-size:.72rem;font-weight:700;white-space:nowrap}.is-visible{color:#198754}.is-hidden{color:#dc3545}.admin-comment-footer{display:flex;align-items:center;gap:16px;color:#98a2b3;font-size:.75rem}.admin-comment-footer>a{color:#4f46e5;max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.admin-comment-footer time{white-space:nowrap}.admin-comment-actions{display:flex;gap:7px;margin-left:auto}.admin-comment-actions form{margin:0}.comment-admin-empty{text-align:center;padding:60px 20px;color:#667085}.comment-admin-empty i{font-size:2rem;color:#4f46e5}.comment-admin-empty h5{color:#122033;margin:12px 0 4px}.comment-admin-empty p{margin:0}@media(max-width:700px){.comment-admin-toolbar{display:block}.comment-count{display:inline-block;margin-top:14px}.admin-comment-row{padding:18px 15px}.admin-comment-top{display:block}.comment-status{display:inline-block;margin-top:6px}.admin-comment-email{display:block;margin:3px 0 0}.admin-comment-footer{align-items:flex-start;flex-direction:column;gap:8px}.admin-comment-actions{margin-left:0}.admin-comment-footer>a{max-width:100%}}
+  </style>
@endsection
