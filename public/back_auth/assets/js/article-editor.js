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
  });
})(jQuery);
