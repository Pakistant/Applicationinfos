(function ($) {
  'use strict';

  $(function () {
    $('.summernote').each(function () {
      var editor = $(this);

      if (editor.data('summernote')) {
        editor.summernote('destroy');
      }

      editor.summernote({
        height: 280,
        minHeight: 200,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview']]
        ]
      });

      editor.closest('form').on('submit', function () {
        editor.val(editor.summernote('code'));
      });
    });

    $('.article-preview-btn').on('click', function (event) {
      event.preventDefault();

      var $form = $(this).closest('form');
      var $editor = $form.find('.summernote');
      var content = $editor.length ? $editor.summernote('code') : '';
      var title = $('#article-title').val() || 'Sans titre';
      var category = $('#article-category option:selected').text() || 'Sans catégorie';
      var tags = $('#article-tags').val();

      $editor.val(content);
      $('#article-preview-title').text(title);
      $('#article-preview-meta').text(category + (tags ? ' • ' + tags.replace(/,/g, ', ') : ''));
      $('#article-preview-content').html(content || '<p class="text-muted">Aucun contenu pour l’instant.</p>');
      $('#articlePreviewModal').modal('show');
    });
  });
})(jQuery);
