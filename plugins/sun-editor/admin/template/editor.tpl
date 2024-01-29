//delete tinymce
script#tinymce-options-js|delete
script#tinymce-js|delete

//todo use local files
//add codemirror 
body|append = '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.49.0/lib/codemirror.min.js"></script>'
body|append = '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.49.0/mode/htmlmixed/htmlmixed.js"></script>'
body|append = '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.49.0/mode/xml/xml.js"></script>'
body|append = '<script src="https://cdn.jsdelivr.net/npm/codemirror@5.49.0/mode/css/css.js"></script>'
body|append = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/codemirror@5.49.0/lib/codemirror.min.css"/>'

//katex
body|append = '<script src="https://cdn.jsdelivr.net/npm/katex@0.11.1/dist/katex.min.js"></script>'
body|append = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.11.1/dist/katex.min.css"/>'

//add sun editor

body|append = '<script src="../../plugins/sun-editor/admin/suneditor.min.js"></script>'
body|append = '<script src="../../plugins/sun-editor/admin/suneditor.init.js"></script>'
body|append = '<link href="../../plugins/sun-editor/admin/suneditor.min.css" rel="stylesheet"/>'
